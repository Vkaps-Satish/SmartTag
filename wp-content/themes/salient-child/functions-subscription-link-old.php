<?php 
add_action( 'woocommerce_account_subscription-link-to-product_endpoint', 'my_account_endpoint_content_subscription_link_to_product' );

function my_account_endpoint_content_subscription_link_to_product(){
    echo '<div class="page-heading"><h1>Link Subscription Plan to Pet</h1></div>';
    if (isset($_POST['products'])) {
      $postId 		= $_POST['products'];
      $susscriptionId = $_POST['subscriptionPlan'];
      update_post_meta($postId,'smarttag_subscription_id',$susscriptionId);
  }

  $customer_subscriptions = get_posts( array(
    'numberposts' => -1,
    'meta_key'    => '_customer_user',
    'meta_value'  => get_current_user_id(),
        'post_type'   => 'shop_subscription', // WC orders post type
        'post_status' => 'wc-active',
    ) 
);
  $j 		= 0;
  $datas 	= '';
  $z 		= 0;
  $k 		= 0;
  foreach ( $customer_subscriptions as $customer_subscription ) {
    $order_id   = $customer_subscription->ID;
    $order      = wc_get_order( $order_id );
    foreach ($order->get_items() as $item) {
        $itemArr 	= $item->get_data();
        $name 		= $itemArr['name'];
    }

    $datas[$j]['id'] = $order_id;
    $datas[$j]['name'] = $name;
    $j++;
}
$size 	= count($datas);
$i 		= 0;
if ($size > 0) { 

   foreach ($datas as $data) {
      $valid = checkSmartIDTag($data['id'],'pet_profile','smarttag_subscription_id');
      if ($valid) {
         $finalDatas[$i]['id'] 	= $data['id'];
         $finalDatas[$i]['name'] = $data['name'];
         $i++;
     }
 } 
}
if (isset($finalDatas)) {
    $size = count($finalDatas);
    $i = 0;
    if ($size > 0) { 
        $k = 1;
        foreach ($finalDatas as $finalData) { 
            $subscriptionDatas[$i]['id']    = $finalData['id'];
            $subscriptionDatas[$i]['name']  = $finalData['name'];
            $i++;
        } 
    }
}

$i = 0;
$user_id = get_current_user_id();
$args=array(
    'post_type' => 'pet_profile',
    'post_status' => 'publish',
    'author' => $user_id,
    'posts_per_page' => -1,	        
);
$query = new WP_Query($args);  	
while ( $query->have_posts() ) : $query->the_post();
  $smarttagSubscriptionId = '';
  $smarttagIdNumber 		= '';
  $mypod 					= pods( 'pet_profile', get_the_id() ); 
  $smarttagIdNumber 		= $mypod->display('smarttag_id_number');
  $smarttagSubscriptionId = $mypod->display('smarttag_subscription_id');

  if (!empty($smarttagIdNumber) && empty($smarttagSubscriptionId)) { 
     $z = 1;
     $products[$i]['id'] 	= get_the_id();
     $products[$i]['name'] 	= get_the_title();
     $i++;
 }
endwhile;
echo "<form id='link-form' action='' method='post'>";
if ($k && $z) { ?>
   <select name="products" class="link-data" id="product">
      <option value="0">Please select any pet</option>
      <?php foreach ($products as $product) {
         echo '<option value="'.$product['id'].'">'.$product['name'].'</option>';
     } ?>
 </select>
 <label class="p-error"></label>
 <select name="subscriptionPlan" class="link-data" id="subscription">
  <option value="0">Please select any subscription Plan</option>
  <?php foreach ($subscriptionDatas as $subscriptionData) {
     echo '<option value="'.$subscriptionData['id'].'">'.$subscriptionData['name'].'</option>';
 } ?>
</select>
<label class="s-error"></label>
<input type="button" name="link" value="Link" id="link">
<?php
}elseif ($z) { ?>
   <select name="products" class="link-data">
      <option value="0">Please select any pet</option>
      <?php foreach ($products as $product) {
         echo '<option value="'.$product['id'].'">'.$product['name'].'</option>';
     } ?>
 </select>
 <select name="subscriptionPlan" class="link-data">
  <option value="0">Sorry No subscription Plans found</option>
</select>
<?php 
}elseif ($k) { ?>
   <select name="products" class="link-data">
      <option value="0">Sorry No products found</option>
  </select>
  <select name="subscriptionPlan" class="link-data">
      <option value="0">Please select any subscription Plan</option>
      <?php foreach ($subscriptionDatas as $subscriptionData) {
         echo '<option value="'.$subscriptionData['id'].'">'.$subscriptionData['name'].'</option>';
     } ?>
 </select>
 <?php 
}else{ ?>
    <div class="lost-found-row" id="filter-row">
        <div class="not-found-text width-100">No data found</div>
    </div>
        
    <?php }
    echo "</form>"; ?>

    <script type="text/javascript">
    	jQuery(document).ready(function($){
    		$('body').on('click', '#link', function(e){
    			e.preventDefault();
    			var pOut = 1;
    			var sOut = 1
    			if ($('#product').val() == 0) {
    				pOut = 0;
    			}else if ($('#subscription').val() == 0) {
    				sOut = 0;
    			}
    			if (sOut != 0 && pOut != 0) {
    				var linkData 	= new FormData();
                   var linkDatas 	= $('#link-form .link-data');

                   $.each($('#link-form .link-data'), function() {
                     linkData.append($(this).attr('name'), $(this).val());
                 });

                   console.log(linkData);
                   linkData.append('action', 'check_subscription_plan');
                   console.log(linkData);
                   $.ajax({
                    url:ajaxurl,
                    type: 'post',
                    data: linkData,
                    contentType: false,
                    processData: false,
                    success: function(res){
                       res = jQuery.parseJSON(res);
                       console.log(res.success);
                       if (res.success) {
                          $('form#link-form').submit();
                      }else{
                          $(".p-error").text("");
                          $(".s-error").text("This plan already use");
                      }
                  },
                  error: function(){
                     console.log('error');
                 }
             });
               }else if (sOut != 0 && pOut != 0){
                $(".p-error").text("This field not empty.");
                $(".s-error").text("This field not empty.");
            }else if (pOut == 0){
                $(".p-error").text("This field not empty.");
                $(".s-error").text("");
            }else if (sOut == 0){
                $(".s-error").text("This field not empty.");
                $(".p-error").text("");
            }	
        });
    	});
    </script>
    <?php
}

add_action('wp_ajax_check_subscription_plan', 'check_subscription_plan_linked_to_product');
add_action('wp_ajax_nopriv_check_subscription_plan', 'check_subscription_plan_linked_to_product');
function check_subscription_plan_linked_to_product(){
	$subscriptionId = $_POST['subscriptionPlan'];
	$result  = checkSmartIDTag($subscriptionId,'pet_profile','smarttag_subscription_id');
	$result = json_encode(array("success"=>$result));
	echo $result;
	exit;
}