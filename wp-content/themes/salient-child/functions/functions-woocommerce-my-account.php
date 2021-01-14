<?php
   /*
    * Register Permalink Endpoint
    */
   include "/var/www/html/idtag.com/wp-content/themes/salient-child/lib/dompdf/autoload.inc.php";
   use Dompdf\Dompdf;
   global $paged;
  // echo $paged;
   add_action( 'init', 'add_endpoint' );
   function add_endpoint() {

       // WP_Rewrite is my Achilles' heel, so please do not ask me for detailed explanation
     add_rewrite_endpoint( 'pet-profile', EP_PAGES );
     add_rewrite_endpoint( 'report-pet-lost', EP_PAGES );
     add_rewrite_endpoint( 'email-customer-service', EP_PAGES );
     add_rewrite_endpoint( 'all-pet-profile', EP_PAGES );
     add_rewrite_endpoint( 'add-pet-id-my-account', EP_PAGES );
     add_rewrite_endpoint( 'report-my-pet-lost', EP_PAGES );
     add_rewrite_endpoint( 'show-profile', EP_PAGES );
     add_rewrite_endpoint( 'report-pet-found-list', EP_PAGES );
     add_rewrite_endpoint( 'subscription-link-to-product', EP_PAGES );
     add_rewrite_endpoint( 'microchip-subscription-link-to-product', EP_PAGES );
     add_rewrite_endpoint( 'microchip-link-to-pet', EP_PAGES );
     add_rewrite_endpoint( 'smarttag-link-to-pet', EP_PAGES );
     add_rewrite_endpoint( 'purchase-replacement-id-tag', EP_PAGES );
     add_rewrite_endpoint( 'order-print-lost-pet-poster', EP_PAGES );
     add_rewrite_endpoint( 'sign-up-pet-alerts', EP_PAGES );
     add_rewrite_endpoint( 'single-sign-up-pet-alerts', EP_PAGES );
     add_rewrite_endpoint( 'free-replacement-tag', EP_PAGES );
     add_rewrite_endpoint( 'order-print-lost-pet-poster-form', EP_PAGES );

     if (is_user_logged_in()) {
         global $current_user;
         $firstName      = $current_user->user_firstname;
         $lastName       = $current_user->user_lastname;
         $email          = $current_user->user_email;
         $userId         = get_current_user_id();
         $sfname         = get_the_author_meta("secondary_first_name",$userId);
         $slname         = get_the_author_meta("secondary_last_name",$userId);
         $semail         = get_the_author_meta("secondary_email",$userId);

         if (empty($sfname) && empty($slname)) {
             update_user_meta( $userId, 'secondary_first_name', $firstName );
             update_user_meta( $userId, 'secondary_last_name', $lastName );
         }elseif (empty($sfname)) {
               // update_user_meta( $userId, 'secondary_first_name', $firstName );
             update_user_meta( $userId, 'secondary_first_name', '' );
         }elseif (empty($slname)) {
               // update_user_meta( $userId, 'secondary_last_name', $lastName );
             update_user_meta( $userId, 'secondary_last_name', '' );
         }

         if (empty($semail)) {
             update_user_meta( $userId, 'secondary_email', $email );
         }
     }


 }

  add_action("init","show_error_message");
  function show_error_message(){
    
    if(isset($_GET['msg']) && isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] == site_url("/my-account/show-profile") ){
        wc_clear_notices();
          if ( filter_input( INPUT_GET, 'msg' ) === 'success' ) : 
    
            wc_add_notice( "Pet has been removed", "success" );

            else: 
              wc_add_notice( "Something went wrong.", "error" );
    
          endif;
    }
  }


   /*
    * Content for the new page in My Account, woocommerce_account_{ENDPOINT NAME}_endpoint
    */
   add_action( 'woocommerce_account_email-customer-service_endpoint', 'my_account_endpoint_content_email_customer_service' );
   function my_account_endpoint_content_email_customer_service() {
     echo '<div class="page-heading">
     <h1>Email Customer Service</h1>
     </div>';
     echo do_shortcode("[gravityform id=9]");
 }

   /*
    change the order and add the new menu of woocommerce my account menu
    */
    function wpb_woo_my_account_order() {
     $myorder = array(
         'my-account' => __( 'My Pets Information', 'woocommerce' ),
         'edit-account'       => __( 'Owner Profile Information', 'woocommerce' ),
         'purchase-replacement-id-tag'   => __( 'Purchase a Replacement ID Tag','woocommerce' ),
         'subscriptions'             => __( 'Upgrade My Protection Plans', 'woocommerce' ),
         'report-my-pet-lost'          => __( 'Report My Pet as Lost', 'woocommerce' ),
         'order-print-lost-pet-poster'       => __( 'Order or Print Lost Pet Poster', 'woocommerce' ),
         'sign-up-pet-alerts'    => __( 'Sign Up For Pet Alerts', 'woocommerce' ),
         'add-pet-id-my-account'    => __( 'Add or Remove a Pet', 'woocommerce' ),
         'edit-address'    => __( 'Billing/Shipping Information', 'woocommerce' ),
         'orders'    => __( 'Order History', 'woocommerce' ),
         'email-customer-service'    => __( 'Email Customer Service', 'woocommerce' ),
           // 'subscription-link-to-product'  => __( 'Link SmartTag to subscription plan', 'woocommerce' ),
           // 'microchip-link-to-pet'    => __( 'Link Microchip to Pet Profile', 'woocommerce' ),
           // 'smarttag-link-to-pet'    => __( 'Link SmartTag ID To Pet Profile', 'woocommerce' ),
     );
     return $myorder;
 }
 add_filter ( 'woocommerce_account_menu_items', 'wpb_woo_my_account_order' );

 /*Purchase Replacement ID Tag*/

 add_action( 'woocommerce_account_purchase-replacement-id-tag_endpoint', 'my_account_endpoint_content_for_purchase_replacement_id_tag' );
function my_account_endpoint_content_for_purchase_replacement_id_tag(){
  echo '<div class="page-heading"><h1>Purchase Replacement ID Tag</h1></div>';
  wc_get_template("myaccount/content-purchase-replacement-id-tag.php", array()  );
}

add_action( 'woocommerce_account_free-replacement-tag_endpoint', 'my_account_endpoint_content_for_free_replacement_tag' );
function my_account_endpoint_content_for_free_replacement_tag() {
  echo '<div class="page-heading"><h1>Purchase Replacement ID Tag</h1></div>';
  if (isset($_GET['pet_id'])) {
    wc_get_template("myaccount/content-free-replacement-tag.php", array()  );
  }
}

/*Link Microchip to Pet Profile*/

add_action( 'woocommerce_account_microchip-link-to-pet_endpoint', 'my_account_endpoint_content_for_microchip_link_to_pet' );

function my_account_endpoint_content_for_microchip_link_to_pet(){
 echo '<div class="page-heading"><h1>Link Microchip ID To Pet Profile</h1></div>';
 if (isset($_POST['petID'])) {
     $postId         = $_POST['petID'];
     $microchipID    = $_POST['microchipID'];
     update_post_meta($postId,'microchip_id_number',$microchipID);
 }
 echo "<form class='link-microchip' action='' method='post'>";
 $microchipIds   = array();
 $prod_arr       = array( '8054');

   // Get all customer orders
 $customer_orders = get_posts( array(
     'numberposts' => -1,
     'meta_key'    => '_customer_user',
     'meta_value'  => get_current_user_id(),
       'post_type'   => 'shop_order', // WC orders post type
       'post_status' => array_keys( wc_get_order_statuses() ),
   ) );
   //print_r($customer_orders);
 foreach ( $customer_orders as $customer_order ) {
       // Updated compatibility with WooCommerce 3+
     $order_id   = $customer_order->ID;
     $order      = wc_get_order( $order_id );
     $order      = new WC_Order( $order_id );
       // Iterating through each current customer products bought in the order
     foreach ($order->get_items() as $item) {
           // print_r($item);
           // WC 3+ compatibility
         if ( version_compare( WC_VERSION, '3.0', '<' ) ) 
             $product_id = $item['product_id'];
         else
             $product_id = $item->get_product_id();

           // Your condition related to your 2 specific products Ids
         if ( in_array( $product_id, $prod_arr ) ) {
             $kua = $item->get_meta_data();
             $result[] = $kua;

         }
     }
 }
 if (is_array($result)) {
     foreach ($result as $check) {
         foreach ($check as $key => $value) {
             if ($value->key == 'Serial Number') {
                 $idTagID[] = $value->value;
             }
         }
     }
 }
 if (is_array($idTagID)) {
     foreach ($idTagID as $value) {
         $values = explode(',', $value);
         foreach ($values as $id) {
             array_push($microchipIds, $id);
         }
     }
 }
 echo '<select name="microchipID" class="microchip-id">';
 $i = 0;
 $j = 1;
 if (count($microchipIds) > 0) {
     foreach ($microchipIds as $microchipId) {
         $result = checkSerialNumberInPetProfile($microchipId, "microchip_id_number");
         if ($result) {
             $i++;
             $j = 0;
             if ($i == 1 ) {
                 echo '<option value="0">Please Select Microchip.</option>';
             }
             echo '<option value="'.$microchipId.'">'.$microchipId.'</option>';
         }
     }

 }

 if ($j) {
     echo '<option value="0">Sorry No Un-Register Microchip Found.</option>';
 }
 echo '</select>';

 $i = 0;
 $z = 0;
 $user_id = get_current_user_id();
 $args=array(
     'post_type' => 'pet_profile',
     'post_status' => 'publish',
     'author' => $user_id,

 );
 $query = new WP_Query($args);   
 while ( $query->have_posts() ) : $query->the_post();
     $microchipSerialNumber  = '';
     $smarttagIdNumber       = '';
     $mypod                  = pods( 'pet_profile', get_the_id() ); 
     $smarttagIdNumber       = $mypod->display('smarttag_id_number');
     $microchipSerialNumber  = $mypod->display('microchip_id_number');

     if (!empty($smarttagIdNumber) && empty($microchipSerialNumber)) { 
         $z = 1;
         $products[$i]['id']     = get_the_id();
         $products[$i]['name']   = get_the_title();
         $i++;
     }
 endwhile;
 $i = 0;
 echo '<select name="petID" class="pet-profile">';
 if ($z) {
     foreach ($products as $product) {
         $i++;
         if ($i == 1) {
             echo '<option value="0">Please Select Pet Profile for Link Microchip.</option>';
         }
         echo '<option value="'.$product['id'].'">'.$product['name'].'</option>';
     }
 }else{
     echo '<option value="0">Sorry No Pet Profile Found.</option>';
 }
 echo '</select><div class="notice"></div>';

 if ($j == 0 && $z == 1) {
     echo "<button type='submit' name='submitButton' class='site-btn submit-btn'>Submit</button>";
 }
 echo "</form>";
 echo '<script type="text/javascript">
 jQuery(document).ready(function($){
     $("form.link-microchip").on("submit", function() {
         var microchip   = $(".microchip-id").val();
         var petProfile  = $(".pet-profile").val();
         if (microchip == "0" && petProfile == "0") {
             console.log(microchip);
             $(".notice").text("Please Select Microchip ID and Pet Profile");
             return false;
             }else if (microchip == "0") {
                 $(".notice").text("Please Select Microchip ID");
                 return false;
                 }else if (petProfile == "0") {
                     $(".notice").text("Please Select Pet Profile");
                     return false;
                 }
                 });
                 });
                 </script>';

}

/*Link SmartTag ID to Pet Profile*/

add_action( 'woocommerce_account_smarttag-link-to-pet_endpoint', 'my_account_endpoint_content_for_smarttag_link_to_pet' );

function my_account_endpoint_content_for_smarttag_link_to_pet(){
  echo '<div class="page-heading"><h1>Link SmartTag ID To Pet Profile</h1></div>';
  if (isset($_POST['petID'])) {
    $postId         = $_POST['petID'];
    $smartTagId    = $_POST['smartTagID'];
    update_post_meta($postId,'smarttag_id_number',$smartTagId);
  }
  echo "<form class='link-smarttag' action='' method='post'>";
  $SmartTagIds   = array();
  $prod_arr       = array( '6089', '6033');

  // Get all customer orders
  $customer_orders = get_posts( array(
    'numberposts' => -1,
    'meta_key'    => '_customer_user',
    'meta_value'  => get_current_user_id(),
    'post_type'   => 'shop_order', // WC orders post type
    'post_status' => array_keys( wc_get_order_statuses() ),
  ) );
   //print_r($customer_orders);
  foreach ( $customer_orders as $customer_order ) {
    // Updated compatibility with WooCommerce 3+
    $order_id   = $customer_order->ID;
    $order      = wc_get_order( $order_id );
    $order      = new WC_Order( $order_id );
    // Iterating through each current customer products bought in the order
    foreach ($order->get_items() as $item) {
      // print_r($item);
      // WC 3+ compatibility
      if ( version_compare( WC_VERSION, '3.0', '<' ) ) 
        $product_id = $item['product_id'];
      else
        $product_id = $item->get_product_id();

      // Your condition related to your 2 specific products Ids
      if ( in_array( $product_id, $prod_arr ) ) {
        $kua = $item->get_meta_data();
        $result[] = $kua;
      }
    }
  }
  
  if (is_array($result)) {
    foreach ($result as $check) {
      foreach ($check as $key => $value) {
        if ($value->key == 'Serial Number') {
          $idTagID[] = $value->value;
        }
      }
    }
  }

  if (is_array($idTagID)) {
    foreach ($idTagID as $value) {
      $values = explode(',', $value);
      foreach ($values as $id) {
        array_push($SmartTagIds, $id);
      }
    }
  }

  echo '<select name="smartTagID" class="microchip-id">';
  $i = 0;
  $j = 1;
  if (count($SmartTagIds) > 0) {
    foreach ($SmartTagIds as $SmartTagId) {
      $result = checkSerialNumberInPetProfile($SmartTagId, "smarttag_id_number");
      if ($result) {
        $i++;
        $j = 0;
        if ($i == 1 ) {
          echo '<option value="0">Please Select Microchip.</option>';
        }
        echo '<option value="'.$SmartTagId.'">'.$SmartTagId.'</option>';
      }
    }
  }

  if ($j) {
    echo '<option value="0">Sorry, Un-Register SmartTag ID Not Found.</option>';
  }
  echo '</select>';
  $i = 0;
  $z = 0;
  $user_id = get_current_user_id();
  $args=array(
    'post_type' => 'pet_profile',
    'post_status' => 'publish',
    'author' => $user_id,
  );
  $query = new WP_Query($args);   
  while ( $query->have_posts() ) : $query->the_post();
   $microchipSerialNumber  = '';
   $smarttagIdNumber       = '';
   $mypod                  = pods( 'pet_profile', get_the_id() ); 
   $smarttagIdNumber       = $mypod->display('smarttag_id_number');
   $microchipSerialNumber  = $mypod->display('microchip_id_number');

   if (empty($smarttagIdNumber) && !empty($microchipSerialNumber)) { 
     $z = 1;
     $products[$i]['id']     = get_the_id();
     $products[$i]['name']   = get_the_title();
     $i++;
   }
 endwhile;
 $i = 0;
 echo '<select name="petID" class="pet-profile">';
 if ($z) {
   foreach ($products as $product) {
     $i++;
     if ($i == 1) {
       echo '<option value="0">Please Select Pet Profile for Link Microchip.</option>';
     }
     echo '<option value="'.$product['id'].'">'.$product['name'].'</option>';
   }
 }else{
   echo '<option value="0">Sorry, Pet Profile Not Found.</option>';
 }
 echo '</select><div class="notice"></div>';

 if ($j == 0 && $z == 1) {
   echo "<button type='submit' name='submitButton' class='site-btn submit-btn'>Submit</button>";
 }
 echo "</form>";
 echo '<script type="text/javascript">
 jQuery(document).ready(function($){
   $("form.link-microchip").on("submit", function() {
     var microchip   = $(".microchip-id").val();
     var petProfile  = $(".pet-profile").val();
     if (microchip == "0" && petProfile == "0") {
       console.log(microchip);
       $(".notice").text("Please Select Microchip ID and Pet Profile");
       return false;
       }else if (microchip == "0") {
         $(".notice").text("Please Select Microchip ID");
         return false;
         }else if (petProfile == "0") {
           $(".notice").text("Please Select Pet Profile");
           return false;
         }
         });
         });
         </script>';

}

/*Order Print Lost Pet Poster*/ 
add_action( 'woocommerce_account_order-print-lost-pet-poster_endpoint', 'my_account_endpoint_content_for_order_print_lost_pet_poster' );
function my_account_endpoint_content_for_order_print_lost_pet_poster() {
  echo '<div class="page-heading"><h1>Order or Print Lost Pet Poster</h1></div>';
  wc_get_template("myaccount/content-order-print-lost-pet-poster.php", array()  );
}

add_action( 'woocommerce_account_order-print-lost-pet-poster-form_endpoint', 'my_account_endpoint_content_for_order_print_lost_pet_poster_form' );
function my_account_endpoint_content_for_order_print_lost_pet_poster_form() {
  echo '<div class="page-heading"><h1>Order or Print Lost Pet Poster</h1></div>';
  if (isset($_GET['pet_id'])) {
    wc_get_template("myaccount/content-order-print-lost-pet-poster-form.php", array()  );
  }
}

/*Sign Up Pet Alerts*/

add_action( 'woocommerce_account_sign-up-pet-alerts_endpoint', 'my_account_endpoint_content_for_sign_up_pet_alerts' );
function my_account_endpoint_content_for_sign_up_pet_alerts() {
 echo '<div class="page-heading"><h1>Sign Up For Alerts</h1></div>';
 $user_id = get_current_user_id();
 $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
 $paged = get_query_var('sign-up-pet-alerts');
 if($paged){
   $paged = explode("page/", $paged);
   $paged = $paged[1];
 }else{
   $paged = 1;
 }
 $args=array(
     'post_type' => 'pet_profile',
     'paged' => $paged,
     'author' => $user_id,
     'posts_per_page' => 2,
 );                      
 $wp_query = new WP_Query($args);
 $i = 0;
 if ($wp_query->have_posts()) {
     while ( $wp_query->have_posts() ) : $wp_query->the_post(); 
         $mypod = pods( 'pet_profile', get_the_id() ); 
         $smarttag_id_number = $mypod->display('smarttag_id_number');
         $microchip_id_number = $mypod->display('microchip_id_number');
         $subscriptionId  = $mypod->display("smarttag_subscription_id");
         if (!empty($subscriptionId)) {
            $itemNumber     = explode("-", $subscriptionId);
            $itemKey        = $itemNumber[0];
            $subscriptionId = WC_Order_Item_Data_Store::get_order_id_by_order_item_id($itemNumber[0]);
             $subscription   = wcs_get_subscription($subscriptionId);
             $date           = $subscription->get_date("end");
             $date           = date_parse_from_format('Y-m-d H:i:s',$date);
             $time           = mktime(0, 0, 0, $date['month'], $date['day'], $date['year']);
             $date           = date("m/d/Y", $time);

             foreach( $subscription->get_items() as $item_id => $product_subscription ){
                   // Get the name
                 $product_name = $product_subscription['name']." (Expires: ".$date.")";
                 $variationId  = $product_subscription['variation_id'];
             }
         }else{
             $product_name = '';
         }

         ?>
         <div class="bottom-border-box">
             <h3>Registered Pet <?php echo ++$i; ?></h3>
             <div class="row">
              <div class="col-sm-3 rmb-15">
               <?php echo get_the_post_thumbnail(); ?>
           </div>
           <div class="col-sm-5 rmb-15">
               <strong>Pet Name:</strong> <span class="name"><?php echo get_the_title(); ?></span>
               <br>
               <strong>Pet Type:</strong> <span><?php $typeId = $mypod->display('pet_type');
						echo (isset(get_term( $typeId )->name)) ? get_term( $typeId )->name : "" ;
						 ?></span>
               <br>
               <strong>IDTag Serial Number:</strong> <span class="name"><?php echo $mypod->display('smarttag_id_number'); ?></span>
               <br>
               <strong>IDTag Microchip Number:</strong> <span class="name"><?php echo $microchip_id_number; ?></span>
               <br>
               <strong>ID Tag Plan:</strong> <span><?php echo $product_name; ?></span>
           </div>
           <div class="col-sm-4 mb-elements">
               <?php if (!empty($product_name) ) { 
                $paltinumPlanVariationId = array(6856,6857,6858,75373,75374,75375);
                $variationId = (int)$variationId;
                if (in_array($variationId, $paltinumPlanVariationId)) { ?>
                   <form action="<?php echo get_site_url(); ?>/my-account/single-sign-up-pet-alerts" method="get" class="custom-form">
                    <input type="hidden" name="post_id" value="<?php echo get_the_ID(); ?>">
                    <input type="hidden" name="petProtectionPlan" value="<?php echo $product_name; ?>">
                    <p><button type="submit" class="sing-up-for-alerts site-btn-red">Sing Up for Alerts <i class="fa fa-caret-right"></i></button></p>
                </form>
            <?php }else{ 
                ?>
                <p><a href="<?php echo site_url().'/my-account/view-subscription/'.$subscriptionId.'/'; ?>" class="button view site-btn-red">Upgrade Protection Plan <i class="fa fa-caret-right"></i></a></p>
                <p style="color: red;">Smart Tag's Alerts service is for Platinum Plan only, Upgrade Pet Protection Plan to receive alerts.</p>
            <?php }
        }else{ ?>
           <p style="color: red;">Smart Tag's Alerts service is for Platinum Plan only, Purchase Pet Protection Plan to receive alerts.</p>
       <?php } ?>
   </div>
</div>
</div>
<?php 
endwhile;
$total_pages = $wp_query->max_num_pages;
if ($total_pages > 1){

 $current_page = max(1, get_query_var('paged'));

 echo paginate_links(array(
     'base' => get_pagenum_link(1) . '%_%',
     'format' => 'page/%#%',
     'current' => $paged,
     'total' => $total_pages,
     'prev_text'    => __('« prev'),
     'next_text'    => __('next »'),
 ));
}
} else{ ?>
    <div class="no-pet-content">
     <div class="sub-heading">
      <h3>Why sign up for alerts?</h3>
  </div>
  <div class="content-list">
      <ul class="list">
       <li> Keep track of all your pet's needs. </li>
       <li> Set reminders for heartworm, flea and tick meds, and veterinarian checkups. </li>
       <li> You can also set custom alerts! </li>
       <li> You will be notified via email and/or sms message. </li>
       <li> Alert Services are only for pet's protected under Smart Tag's Platinum Protection plans. </li>
   </ul>
</div>
<div class="redirect-btn">
  <a class="site-btn site-btn-red" href="<?php echo site_url(); ?>/my-account/add-pet-id-my-account/"> Please Register Your Pet <i class="fa fa-caret-right"></i></a>
</div>
</div>
<?php }
}

function getSubscriptionPlanNameUsingSerialKey($subscriptionId){
  
  $product_name = '';
  $startDate    = '';
  $enddate      = '';
  $variationId  = 0;
  $expir        = '';

  if (!empty($subscriptionId)) {

    $itemNumber     = explode("-", $subscriptionId);
    $itemKey        = $itemNumber[0];
    $subscriptionId = WC_Order_Item_Data_Store::get_order_id_by_order_item_id($itemNumber[0]);
    $subscription = wc_get_order($subscriptionId);
    if (!empty($subscription)) {
      $startDate = $subscription->get_date("date_created");
      $enddate   = $subscription->get_date("end");

      if (empty($enddate)) {
        $enddate = $subscription->get_date("next_payment");
      }

      $enddate = date_parse_from_format('Y-m-d H:i:s',$enddate);
      $enddate = mktime(0, 0, 0, $enddate['month'], $enddate['day'], $enddate['year']);
      $enddate = date("m/d/Y", $enddate);
      $startDate = date_parse_from_format('Y-m-d H:i:s',$startDate);
      $startDate = mktime(0, 0, 0, $startDate['month'], $startDate['day'], $startDate['year']);
      $startDate = date("m/d/Y", $startDate);

      foreach( $subscription->get_items() as $item_id => $product_subscription ){
        // Get the name
        if($item_id == $itemKey){
          $product_name = $product_subscription['name'];
          $expir = " (Expires: ".$enddate.")";
          $variationId  = $product_subscription['variation_id'];
        }
      }
    }
  }
  return json_encode(array('productName' => $product_name, 'startDate' => $startDate, 'endDate' => $endDate, 'variationId' => $variationId, 'subscriptionId' => $subscriptionId, 'expir' => $expir));
}

add_action( 'woocommerce_account_single-sign-up-pet-alerts_endpoint', 'my_account_endpoint_content_for_single_sign_up_pet_alerts' );
function my_account_endpoint_content_for_single_sign_up_pet_alerts() {
  echo '<div class="page-heading"><h1>Sign Up For Alerts</h1></div>';
  // echo date("d-m-Y h:i:s A");
  if (isset($_GET['post_id'])) {
    $postId          = $_GET['post_id'];
    $mypod           = pods( 'pet_profile', $postId ); 
    $subscriptionId  = $mypod->display("smarttag_subscription_id");
    $subscriptionDetail = json_decode( getSubscriptionPlanNameUsingSerialKey($subscriptionId));
    $subscriptionId  = $subscriptionDetail->subscriptionId;
    $paltinumPlanVariationId = array(6856,6857,6858,75373,75374,75375);
    $variationId = (int)$subscriptionDetail->variationId;
    if (in_array($variationId, $paltinumPlanVariationId)) {
      $petProtectionPlan = $subscriptionDetail->productName;
      $userId          = get_current_user_id();
      $heartworm  = get_post_meta($postId,"heartworm_medication_alert",true);
      $fleaTick   = get_post_meta($postId,"flea_tick_medication_alert",true);
      $vetAppo    = get_post_meta($postId,"vet_appointments_alert",true);
      $medica     = get_post_meta($postId,"medication_alert",true);
      $rabiesShot = get_post_meta($postId,"rabies_shot_alert",true);
      $tagLicens  = get_post_meta($postId,"tag_licensing_alert",true);

      if (!empty($heartworm)) {
          $heartwormCheck = "checked";
          $heartwormDisab = "";
          $heartwormClass = "";
      }else{
          $heartwormCheck = "";
          $heartwormDisab = "disabled";
          $heartwormClass = "disabled";
      }

      if (!empty($fleaTick)) {
          $fleaTickCheck = "checked";
          $fleaTickDisab = "";
          $fleaTickClass = "";
      }else{
          $fleaTickCheck = "";
          $fleaTickDisab = "disabled";
          $fleaTickClass = "disabled";
      }

      if (!empty($vetAppo)) {
          $vetAppoCheck = "checked";
          $vetAppoDisab = "";
          $vetAppoClass = "";
      }else{
          $vetAppoCheck = "";
          $vetAppoDisab = "disabled";
          $vetAppoClass = "disabled";
      }

      if (!empty($medica)) {
          $medicaCheck = "checked";
          $medicaDisab = "";
          $medicaClass = "";
      }else{
          $medicaCheck = "";
          $medicaDisab = "disabled";
          $medicaClass = "disabled";
      }

      if (!empty($rabiesShot)) {
          $rabiesShotCheck = "checked";
          $rabiesShotDisab = "";
          $rabiesShotClass = "";
      }else{
          $rabiesShotCheck = "";
          $rabiesShotDisab = "disabled";
          $rabiesShotClass = "disabled";
      }

      if (!empty($tagLicens)) {
          $tagLicensCheck = "checked";
          $tagLicensDisab = "";
          $tagLicensClass = "";
      }else{
          $tagLicensCheck = "";
          $tagLicensDisab = "disabled";
          $tagLicensClass = "disabled";
      }
      ?>
        <div class="set-alerts-wrap">
           <h4>
            <i>Alerts for Dog Name:</i>
        </h4>
        <div class="bottom-border-box">
          <div class="row">
             <div class="col-sm-3 rmb-15">
              <?php echo get_the_post_thumbnail($postId); ?>
            </div>
            <div class="col-sm-9">
              <strong>Pet Name:</strong> <?php echo get_the_title($postId); ?>
              <br>
              <strong>Pet Type:</strong> <span><?php $typeId = $mypod->display('pet_type');
						echo (isset(get_term( $typeId )->name)) ? get_term( $typeId )->name : "" ;
						 ?></span>
              <br>
              <strong>IDTag Serial Number:</strong> <span class="name"><?php echo $mypod->display('smarttag_id_number'); ?></span>
              <br>
              <strong>Microchip Number:</strong> <span class="name"><?php echo $mypod->display('microchip_id_number'); ?></span>
              <br>
              <strong>ID Tag Plan:</strong> <span><?php echo $petProtectionPlan; ?></span>
            </div>
          </div>
        </div>
        <div class="row middle-border-row mb-15">
          <div class="col-sm-6 standard-alerts rmb-15">
            <h4 class="color-light-blue">Standard Alerts</h4>
            <p>
              <input type="checkbox" name="" <?php echo $heartwormCheck; ?> class="heartworm-alert" /> <strong>Heartworm Medication</strong>
            </p>
            <p>
              <input type="checkbox" name="" class="flea-tick" <?php echo $fleaTickCheck; ?> /> <strong>Flea & Tick Medication</strong>
            </p>
            <p>
              <input type="checkbox" name="" <?php echo $vetAppoCheck; ?> class="vet-appo" /> <strong>Vet Appointments</strong>
            </p>
            <p>
              <input type="checkbox" name="" <?php echo $medicaCheck; ?> class="medication-alert" /> <strong>Medication Alerts</strong>
            </p>
            <p>
              <input type="checkbox" name="" <?php echo $rabiesShotCheck; ?> class="rabies-shot" /> <strong>Rabies Shot Alerts</strong>
            </p>
            <p>
              <input type="checkbox" name="" <?php echo $tagLicensCheck; ?> class="tag-licens" /> <strong>Tag Licensing Alerts</strong>
            </p>
          </div>
          <div class="col-sm-6 standard-alerts">
            <h4 class="color-light-blue">Custom Alerts</h4>
            <p>
              <input type="checkbox" name="" class="custom-alert" /> <strong>Create a Custom Alert</strong>
            </p>
          </div>
        </div>
        <div class="acc-blue-box acc-plus-minus">
          <div class="acc-blue-head">
           Heartworm Medication Alert
           <i class="fa fa-plus"></i>
          </div>
        <div class="acc-blue-content">
          <form>
          <div class="contact-form">
            <input type="hidden" name="pet_id" value="<?php echo $postId; ?>">
            <input type="hidden" name="alert_name" value="heartworm_medication_alert" class="heartworm-alert">
            <div class="field-wrap">
              <div class="field-div">
              <label>*Choose day of the week to receive alert:</label>
              <div class="multi-check-fields mb-15">
                <span>
                  <input type="radio" name="day_of_week" value="7" class="heartworm-alert recieve-alert" <?php if (!empty($heartworm)) {
                    if (isset($heartworm['day_of_week']) && $heartworm['day_of_week'] == 7) {
                      echo "checked";
                    }
                  } ?> required="" /> Sunday
                </span>
                <span>
                  <input type="radio" name="day_of_week" value="1" class="heartworm-alert recieve-alert" <?php if (!empty($heartworm)) { 
                    if (isset($heartworm['day_of_week']) && $heartworm['day_of_week'] == 1) {
                      echo "checked";
                    }
                  } ?> required="" /> Monday
                </span>
                <span>
                  <input type="radio" name="day_of_week" value="2" class="heartworm-alert recieve-alert" <?php if (!empty($heartworm)) {
                    if (isset($heartworm['day_of_week']) && $heartworm['day_of_week'] == 2) {
                      echo "checked";
                    }
                  } ?> required="" /> Tuesday
                </span>
                <span>
                  <input type="radio" name="day_of_week" value="3" class="heartworm-alert recieve-alert" <?php if (!empty($heartworm)) {
                    if (isset($heartworm['day_of_week']) && $heartworm['day_of_week'] == 3) {
                      echo "checked";
                    }
                  } ?> required="" /> Wednesday
                </span>
                <span>
                  <input type="radio" name="day_of_week" value="4" class="heartworm-alert recieve-alert" <?php if (!empty($heartworm)) {
                    if (isset($heartworm['day_of_week']) && $heartworm['day_of_week'] == 4) {
                      echo "checked";
                    }
                  } ?> required="" /> Thursday
                </span>
                <span>
                  <input type="radio" name="day_of_week" value="5" class="heartworm-alert recieve-alert" <?php if (!empty($heartworm)) {
                    if (isset($heartworm['day_of_week']) && $heartworm['day_of_week'] == 5) {
                      echo "checked";
                    }
                  } ?> required="" /> Friday
                </span>
                <span>
                  <input type="radio" name="day_of_week" value="6" class="heartworm-alert recieve-alert" <?php if (!empty($heartworm)) {
                    if (isset($heartworm['day_of_week']) && $heartworm['day_of_week'] == 6) {
                      echo "checked";
                    }
                  } ?> required="" /> Saturday
                </span>
              </div>
            </div>
            </div>
            <div class="field-wrap two-fields-wrap">
              <div class="field-div">
                <label>*Choose time of day to receive alert:</label>
                <select name="time_of_day" class="heartworm-alert" >
                  <?php for($i = 1; $i <= 24; $i++): 
                    $time = date("h.i A", strtotime("$i:00"));
                      if (!empty($heartworm)) {
                        if (isset($heartworm['time_of_day']) && $heartworm['time_of_day'] == $time) {
                          echo '<option selected value="'.$time.'">'. $time.'</option>';
                        }else{
                          echo '<option value="'.$time.'">'. $time.'</option>';
                        }
                      }else{
                        echo '<option value="'.$time.'">'. $time.'</option>';  
                      }

                  endfor; ?>
                </select>
              </div>
              <div class="field-div">
                <label>*Choose first day to receive this alert:</label>
                <input type="text" name="alert_date" class="first-day heartworm-alert" readonly="" required="" value="<?php if (!empty($heartworm)) {
                  if (isset($heartworm['alert_date']) && !empty($heartworm['alert_date'])) {
                    echo $heartworm['alert_date'];
                  }else{
                    echo date("F d, Y");
                  }
                }else{
                  echo date("F d, Y");
                } ?>" >
              </div>
            </div>
            <div class="field-wrap two-fields-wrap">
              <div class="field-div">
               <label>*Frequency of alert:</label>
               <select class="heartworm-alert" name="frequency_of_alert">
                   <?php 
                   $i = 1;
                   while ( $i <= 12 ) {
                    if (!empty($heartworm)) {
                        if (isset($heartworm['frequency_of_alert']) && $heartworm['frequency_of_alert'] == $i) {
                            if ($i == 1) {
                                echo '<option selected value="'.$i.'">Every Month</option>';
                            }else{
                                echo '<option selected value="'.$i.'">Every '.$i.' Months</option>';
                            }
                        }else{
                            if ($i == 1) {
                                echo '<option  value="'.$i.'">Every Month</option>';
                            }else{
                                echo '<option  value="'.$i.'">Every '.$i.' Months</option>';
                            }
                        }
                    }else{
                        if ($i == 1) {
                            echo '<option value="'.$i.'">Every Month</option>';
                        }else{
                            echo '<option value="'.$i.'">Every '.$i.' Months</option>';
                        }  
                    }
                    $i++;  
                }
                ?>
            </select>
            </div>
            <div class="field-div">
               <label>*How would you like to receive this alert?:</label>
               <div class="multi-check-fields mb-15">
                <span>
                    <input type="radio" name="recieve_alert" value="email" required="" class="heartworm-alert alert-type" <?php if (!empty($heartworm)) {
                     if (isset($heartworm['recieve_alert']) && $heartworm['recieve_alert'] == "email") {
                         echo "checked='checked'";
                     }
                 } ?> /> By Email
             </span>
             <span>
                <input type="radio" name="recieve_alert" value="phone" required="" class="heartworm-alert alert-type" <?php if (!empty($heartworm)) {
                 if (isset($heartworm['recieve_alert']) && $heartworm['recieve_alert'] == "phone") {
                     echo "checked='checked'";
                 }
             } ?> /> By Phone, VIA Text Message
            </span>
            </div>
            </div>
            </div>
            <div class="field-wrap">
              <div class="field-div">
               <label>Add Notes (Optional):</label>
               <input type="text" name="note" placeholder="Write Notes..." class="heartworm-alert" value="<?php if (!empty($heartworm)) {
                if (!empty($heartworm['note'])) {
                    echo $heartworm['note'];
                }
            } ?>" >
            </div>
            </div>
            <div class="field-wrap two-fields-wrap">
              <div class="field-div text-left">
               <input type="button" name="" value="Remove Alert" class="site-btn-red remove-sing-up-alert <?php echo $heartwormClass ?>" <?php echo $heartwormClass ?>/>
            </div>
            <div class="field-div text-right">
               <input type="button" name="" value="Save Alert" class="site-btn-red sing-up-alert" />
            </div>
            </div>
            <div class="field-wrap">
              <div class="field-notice"></div>
            </div>
            </div>
          </form>
        </div>
      </div>
  <div class="acc-blue-box acc-plus-minus">
    <div class="acc-blue-head">
     Flea & Tick Medication
     <i class="fa fa-plus"></i>
    </div>
        <div class="acc-blue-content">
         <div class="contact-form">
          <form>
           <input type="hidden" name="pet_id" value="<?php echo $postId; ?>">
           <input type="hidden" name="alert_name" value="flea_tick_medication_alert" class="flea-tick">
           <div class="field-wrap">
            <div class="field-div">
             <label>*Choose day of the week to receive alert:</label>
             <div class="multi-check-fields mb-15">
              <span>
                  <input type="radio" name="day_of_week" value="7" class="flea-tick recieve-alert" <?php if (!empty($fleaTick)) {
                   if (isset($fleaTick['day_of_week']) && $fleaTick['day_of_week'] == 7) {
                       echo "checked";
                   }
               } ?> /> Sunday
           </span>
           <span>
              <input type="radio" name="day_of_week" value="1" class="flea-tick recieve-alert" <?php if (!empty($fleaTick)) {
               if (isset($fleaTick['day_of_week']) && $fleaTick['day_of_week'] == 1) {
                   echo "checked";
               }
           } ?> /> Monday
       </span>
       <span>
          <input type="radio" name="day_of_week" value="2" class="flea-tick recieve-alert" <?php if (!empty($fleaTick)) {
           if (isset($fleaTick['day_of_week']) && $fleaTick['day_of_week'] == 2) {
               echo "checked";
           }
       } ?> /> Tuesday
      </span>
      <span>
          <input type="radio" name="day_of_week" value="3" class="flea-tick recieve-alert" <?php if (!empty($fleaTick)) {
           if (isset($fleaTick['day_of_week']) && $fleaTick['day_of_week'] == 3) {
               echo "checked";
           }
       } ?> /> Wednesday
      </span>
      <span>
          <input type="radio" name="day_of_week" value="4" class="flea-tick recieve-alert" <?php if (!empty($fleaTick)) {
           if (isset($fleaTick['day_of_week']) && $fleaTick['day_of_week'] == 4) {
               echo "checked";
           }
       } ?> /> Thursday
      </span>
      <span>
          <input type="radio" name="day_of_week" value="5" class="flea-tick recieve-alert" <?php if (!empty($fleaTick)) {
           if (isset($fleaTick['day_of_week']) && $fleaTick['day_of_week'] == 5) {
               echo "checked";
           }
       } ?> /> Friday
      </span>
      <span>
          <input type="radio" name="day_of_week" value="6" class="flea-tick recieve-alert" <?php if (!empty($fleaTick)) {
           if (isset($fleaTick['day_of_week']) && $fleaTick['day_of_week'] == 6) {
               echo "checked";
           }
       } ?> /> Saturday
      </span>
      </div>
      </div>
      </div>
      <div class="field-wrap two-fields-wrap">
        <div class="field-div">
         <label>*Choose time of day to receive alert:</label>
         <select name="time_of_day" class="flea-tick" >
             <?php for($i = 1; $i <= 24; $i++): 
              $time = date("h.i A", strtotime("$i:00"));
              if (!empty($fleaTick)) {
                  if (isset($fleaTick['time_of_day']) && $fleaTick['time_of_day'] == $time) {
                      echo '<option selected value="'.$time.'">'.$time.'</option>';
                  }else{
                      echo '<option value="'.$time.'">'.$time.'</option>';
                  }
              }else{
                  echo '<option value="'.$time.'">'.$time.'</option>';  
              }

          endfor; ?>
      </select>
      </div>
      <div class="field-div">
         <label>*Choose first day to receive this alert:</label>
         <input type="text" name="alert_date" class="first-day flea-tick" readonly="" value="<?php if (!empty($fleaTick)) {
          if (isset($fleaTick['alert_date']) && !empty($fleaTick['alert_date'])) {
              echo $fleaTick['alert_date'];
          }else{
              echo date("F d, Y");
          }
      }else{
          echo date("F d, Y");
      } ?>">
      </div>
      </div>
      <div class="field-wrap two-fields-wrap">
        <div class="field-div">
         <label>*Frequency of alert:</label>
         <select class="flea-tick" name="frequency_of_alert">
             <?php 
             $i = 1;
             while ( $i <= 12 ) {
              if (!empty($fleaTick)) {
                  if (isset($fleaTick['frequency_of_alert']) && $fleaTick['frequency_of_alert'] == $i) {
                      if ($i == 1) {
                          echo '<option selected value="'.$i.'">Every Month</option>';
                      }else{
                          echo '<option selected value="'.$i.'">Every '.$i.' Months</option>';
                      }
                  }else{
                      if ($i == 1) {
                          echo '<option  value="'.$i.'">Every Month</option>';
                      }else{
                          echo '<option  value="'.$i.'">Every '.$i.' Months</option>';
                      }
                  }
              }else{
                  if ($i == 1) {
                      echo '<option value="'.$i.'">Every Month</option>';
                  }else{
                      echo '<option value="'.$i.'">Every '.$i.' Months</option>';
                  }  
              }
              $i++;  
          }
          ?>
      </select>
      </div>
      <div class="field-div">
         <label>*How would you like to receive this alert?:</label>
         <div class="multi-check-fields mb-15">
          <span>
              <input type="radio" name="recieve_alert" value="email" class="flea-tick alert-type" <?php if (!empty($fleaTick)) {
               if (isset($fleaTick['recieve_alert']) && $fleaTick['recieve_alert'] == "email") {
                   echo "checked";
               }
           } ?> /> By Email
       </span>
       <span>
          <input type="radio" name="recieve_alert" value="phone" class="flea-tick alert-type" <?php if (!empty($fleaTick)) {
           if (isset($fleaTick['recieve_alert']) && $fleaTick['recieve_alert'] == "phone") {
               echo "checked";
           }
       } ?> /> By Phone, VIA Text Message
      </span>
      </div>
      </div>
      </div>
      <div class="field-wrap">
        <div class="field-div">
         <label>Add Notes (Optional):</label>
         <input type="text" placeholder="Write Notes..." name="note" class="flea-tick" value="<?php if (!empty($fleaTick)) {
          if (!empty($fleaTick['note'])) {
              echo $fleaTick['note'];
          }
      } ?>">
      </div>
      </div>
      <div class="field-wrap two-fields-wrap">
        <div class="field-div text-left">
         <input type="button" name="" value="Remove Alert" class="site-btn-red remove-sing-up-alert <?php echo $fleaTickClass; ?>" <?php echo $fleaTickClass; ?>/>
      </div>
      <div class="field-div text-right">
         <input type="button" name="" value="Save Alert" class="site-btn-red sing-up-alert" />
      </div>
      </div>
      <div class="field-wrap">
        <div class="field-notice"></div>
      </div>
      </form>
      </div>
      </div>
      </div>
      <div class="acc-blue-box acc-plus-minus">
        <div class="acc-blue-head">
         Vet Appointments
         <i class="fa fa-plus"></i>
      </div>
      <div class="acc-blue-content">
         <div class="contact-form">
          <form>
           <input type="hidden" name="pet_id" value="<?php echo $postId; ?>">
           <input type="hidden" name="alert_name" value="vet_appointments_alert" class="vet-appo">
           <div class="field-wrap">
            <div class="field-div">
             <label>*Choose day of the week to receive alert:</label>
             <div class="multi-check-fields mb-15">
              <span>
                  <input type="radio" name="day_of_week" value="7" class="vet-appo recieve-alert" <?php if (!empty($vetAppo)) {
                   if (isset($vetAppo['day_of_week']) && $vetAppo['day_of_week'] == 7) {
                       echo "checked";
                   }
               } ?> /> Sunday
           </span>
           <span>
              <input type="radio" name="day_of_week" value="1" class="vet-appo recieve-alert" <?php if (!empty($vetAppo)) {
               if (isset($vetAppo['day_of_week']) && $vetAppo['day_of_week'] == 1) {
                   echo "checked";
               }
           } ?> /> Monday
       </span>
       <span>
          <input type="radio" name="day_of_week" value="2" class="vet-appo recieve-alert" <?php if (!empty($vetAppo)) {
           if (isset($vetAppo['day_of_week']) && $vetAppo['day_of_week'] == 2) {
               echo "checked";
           }
       } ?> /> Tuesday
      </span>
      <span>
          <input type="radio" name="day_of_week" value="3" class="vet-appo recieve-alert" <?php if (!empty($vetAppo)) {
           if (isset($vetAppo['day_of_week']) && $vetAppo['day_of_week'] == 3) {
               echo "checked";
           }
       } ?> /> Wednesday
      </span>
      <span>
          <input type="radio" name="day_of_week" value="4" class="vet-appo recieve-alert" <?php if (!empty($vetAppo)) {
           if (isset($vetAppo['day_of_week']) && $vetAppo['day_of_week'] == 4) {
               echo "checked";
           }
       } ?> /> Thursday
      </span>
      <span>
          <input type="radio" name="day_of_week" value="5" class="vet-appo recieve-alert" <?php if (!empty($vetAppo)) {
           if (isset($vetAppo['day_of_week']) && $vetAppo['day_of_week'] == 5) {
               echo "checked";
           }
       } ?> /> Friday
      </span>
      <span>
          <input type="radio" name="day_of_week" value="6" class="vet-appo recieve-alert" <?php if (!empty($vetAppo)) {
           if (isset($vetAppo['day_of_week']) && $vetAppo['day_of_week'] == 6) {
               echo "checked";
           }
       } ?> /> Saturday
      </span>
      </div>
      </div>
      </div>
      <div class="field-wrap two-fields-wrap">
        <div class="field-div">
         <label>*Choose time of day to receive alert:</label>
         <select name="time_of_day" class="vet-appo" >
             <?php for($i = 1; $i <= 24; $i++): 
              $time = date("h.i A", strtotime("$i:00"));
              if (!empty($vetAppo)) {
                  if (isset($vetAppo['time_of_day']) && $vetAppo['time_of_day'] == $time) {
                      echo '<option selected value="'.$time.'">'.$time.'</option>';
                  }else{
                      echo '<option value="'.$time.'">'.$time.'</option>';
                  }
              }else{
                  echo '<option value="'.$time.'">'.$time.'</option>';  
              }

          endfor; ?>
      </select>
      </div>
      <div class="field-div">
         <label>*Choose first day to receive this alert:</label>
         <input type="text" name="alert_date" class="first-day vet-appo" readonly="" required="" value="<?php if (!empty($vetAppo)) {
          if (isset($vetAppo['alert_date']) && !empty($vetAppo['alert_date'])) {
              echo $vetAppo['alert_date'];
          }else{
              echo date("F d, Y");
          }
      }else{
          echo date("F d, Y");
      } ?>">
      </div>
      </div>
      <div class="field-wrap two-fields-wrap">
        <div class="field-div">
         <label>*Frequency of alert:</label>
         <select class="vet-appo" name="frequency_of_alert">
             <?php 
             $i = 1;
             while ( $i <= 12 ) {
              if (!empty($vetAppo)) {
                  if (isset($vetAppo['frequency_of_alert']) && $vetAppo['frequency_of_alert'] == $i) {
                      if ($i == 1) {
                          echo '<option selected value="'.$i.'">Every Month</option>';
                      }else{
                          echo '<option selected value="'.$i.'">Every '.$i.' Months</option>';
                      }
                  }else{
                      if ($i == 1) {
                          echo '<option  value="'.$i.'">Every Month</option>';
                      }else{
                          echo '<option  value="'.$i.'">Every '.$i.' Months</option>';
                      }
                  }
              }else{
                  if ($i == 1) {
                      echo '<option value="'.$i.'">Every Month</option>';
                  }else{
                      echo '<option value="'.$i.'">Every '.$i.' Months</option>';
                  } 
              }
              $i++;  
          }
          ?>
      </select>
      </div>
      <div class="field-div">
         <label>*How would you like to receive this alert?:</label>
         <div class="multi-check-fields mb-15">
          <span>
              <input type="radio" name="recieve_alert" value="email" class="vet-appo alert-type" <?php if (!empty($vetAppo)) {
               if (isset($vetAppo['recieve_alert']) && $vetAppo['recieve_alert'] == "email") {
                   echo "checked";
               }
           } ?> /> By Email
       </span>
       <span>
          <input type="radio" name="recieve_alert" value="phone" class="vet-appo alert-type" <?php if (!empty($vetAppo)) {
           if (isset($vetAppo['recieve_alert']) && $vetAppo['recieve_alert'] == "phone") {
               echo "checked";
           }
       } ?> /> By Phone, VIA Text Message
      </span>
      </div>
      </div>
      </div>
      <div class="field-wrap">
        <div class="field-div">
         <label>Add Notes (Optional):</label>
         <input type="text" placeholder="Write Notes..." name="note" class="vet-appo" value="<?php if (!empty($vetAppo)) {
          if (!empty($vetAppo['note'])) {
              echo $vetAppo['note'];
          }
      } ?>">
      </div>
      </div>
      <div class="field-wrap two-fields-wrap">
        <div class="field-div text-left">
         <input type="button" name="" value="Remove Alert" class="site-btn-red remove-sing-up-alert <?php echo $vetAppoClass; ?>" <?php echo $vetAppoClass; ?> />
      </div>
      <div class="field-div text-right">
         <input type="button" name="" value="Save Alert" class="site-btn-red sing-up-alert" />
      </div>
      </div>
      <div class="field-wrap">
        <div class="field-notice"></div>
      </div>
      </form>
      </div>
      </div>
      </div>
      <div class="acc-blue-box acc-plus-minus">
        <div class="acc-blue-head">
         Medication Alerts
         <i class="fa fa-plus"></i>
      </div>
      <div class="acc-blue-content">
         <div class="contact-form">
          <form>
           <input type="hidden" name="pet_id" value="<?php echo $postId; ?>">
           <input type="hidden" name="alert_name" value="medication_alert" class="medication-alert">
           <div class="field-wrap">
            <div class="field-div">
             <label>*Choose day of the week to receive alert:</label>
             <div class="multi-check-fields mb-15">
              <span>
                  <input type="radio" name="day_of_week" value="7" class="medication-alert recieve-alert" <?php if (!empty($medica)) {
                   if (isset($medica['day_of_week']) && $medica['day_of_week'] == 7) {
                       echo "checked";
                   }
               } ?> /> Sunday
           </span>
           <span>
              <input type="radio" name="day_of_week" value="1" class="medication-alert recieve-alert" <?php if (!empty($medica)) {
               if (isset($medica['day_of_week']) && $medica['day_of_week'] == 1) {
                   echo "checked";
               }
           } ?> /> Monday
       </span>
       <span>
          <input type="radio" name="day_of_week" value="2" class="medication-alert recieve-alert" <?php if (!empty($medica)) {
           if (isset($medica['day_of_week']) && $medica['day_of_week'] == 2) {
               echo "checked";
           }
       } ?> /> Tuesday
      </span>
      <span>
          <input type="radio" name="day_of_week" value="3" class="medication-alert recieve-alert" <?php if (!empty($medica)) {
           if (isset($medica['day_of_week']) && $medica['day_of_week'] == 3) {
               echo "checked";
           }
       } ?> /> Wednesday
      </span>
      <span>
          <input type="radio" name="day_of_week" value="4" class="medication-alert recieve-alert" <?php if (!empty($medica)) {
           if (isset($medica['day_of_week']) && $medica['day_of_week'] == 4) {
               echo "checked";
           }
       } ?> /> Thursday
      </span>
      <span>
          <input type="radio" name="day_of_week" value="5" class="medication-alert recieve-alert" <?php if (!empty($medica)) {
           if (isset($medica['day_of_week']) && $medica['day_of_week'] == 5) {
               echo "checked";
           }
       } ?> /> Friday
      </span>
      <span>
          <input type="radio" name="day_of_week" value="6" class="medication-alert recieve-alert" <?php if (!empty($medica)) {
           if (isset($medica['day_of_week']) && $medica['day_of_week'] == 6) {
               echo "checked";
           }
       } ?> /> Saturday
      </span>
      </div>
      </div>
      </div>
      <div class="field-wrap two-fields-wrap">
        <div class="field-div">
         <label>*Choose time of day to receive alert:</label>
         <select name="time_of_day" class="medication-alert" >
             <?php for($i = 1; $i <= 24; $i++): 
              $time = date("h.i A", strtotime("$i:00"));
              if (!empty($medica)) {
                  if (isset($medica['time_of_day']) && $medica['time_of_day'] == $time) {
                      echo '<option selected value="'.$time.'">'.$time.'</option>';
                  }else{
                      echo '<option value="'.$time.'">'.$time.'</option>';
                  }
              }else{
                  echo '<option value="'.$time.'">'.$time.'</option>';  
              }

          endfor; ?>
      </select>
      </div>
      <div class="field-div">
         <label>*Choose first day to receive this alert:</label>
         <input type="text" name="alert_date" class="first-day medication-alert" readonly="" required="" value="<?php if (!empty($medica)) {
          if (isset($medica['alert_date']) && !empty($medica['alert_date'])) {
              echo $medica['alert_date'];
          }else{
              echo date("F d, Y");
          }
      }else{
          echo date("F d, Y");
      } ?>">
      </div>
      </div>
      <div class="field-wrap two-fields-wrap">
        <div class="field-div">
         <label>*Frequency of alert:</label>
         <select class="medication-alert" name="frequency_of_alert">
             <?php 
             $i = 1;
             while ( $i <= 12 ) {
              if (!empty($medica)) {
                  if (isset($medica['frequency_of_alert']) && $medica['frequency_of_alert'] == $i) {
                      if ($i == 1) {
                          echo '<option selected value="'.$i.'">Every Month</option>';
                      }else{
                          echo '<option selected value="'.$i.'">Every '.$i.' Months</option>';
                      }
                  }else{
                      if ($i == 1) {
                          echo '<option  value="'.$i.'">Every Month</option>';
                      }else{
                          echo '<option  value="'.$i.'">Every '.$i.' Months</option>';
                      }
                  }
              }else{
                  if ($i == 1) {
                      echo '<option value="'.$i.'">Every Month</option>';
                  }else{
                      echo '<option value="'.$i.'">Every '.$i.' Months</option>';
                  } 
              }
              $i++;  
          }
          ?>
      </select>
      </div>
      <div class="field-div">
         <label>*How would you like to receive this alert?:</label>
         <div class="multi-check-fields mb-15">
          <span>
              <input type="radio" name="recieve_alert" value="email" class="medication-alert alert-type" <?php if (!empty($medica)) {
               if (isset($medica['recieve_alert']) && $medica['recieve_alert'] == "email") {
                   echo "checked";
               }
           } ?> /> By Email
       </span>
       <span>
          <input type="radio" name="recieve_alert" value="phone" class="medication-alert alert-type" <?php if (!empty($medica)) {
           if (isset($medica['recieve_alert']) && $medica['recieve_alert'] == "phone") {
               echo "checked";
           }
       } ?> /> By Phone, VIA Text Message
      </span>
      </div>
      </div>
      </div>
      <div class="field-wrap">
        <div class="field-div">
         <label>Add Notes (Optional):</label>
         <input type="text" placeholder="Write Notes..." name="note" class="medication-alert" value="<?php if (!empty($medica)) {
          if (!empty($medica['note'])) {
              echo $medica['note'];
          }
      } ?>">
      </div>
      </div>
      <div class="field-wrap two-fields-wrap">
        <div class="field-div text-left">
         <input type="button" name="" value="Remove Alert" class="site-btn-red remove-sing-up-alert <?php echo $medicaClass; ?>" <?php echo $medicaClass; ?> />
      </div>
      <div class="field-div text-right">
         <input type="button" name="" value="Save Alert" class="site-btn-red sing-up-alert" />
      </div>
      </div>
      <div class="field-wrap">
        <div class="field-notice"></div>
      </div>
      </form>
      </div>
      </div>
      </div>
      <div class="acc-blue-box acc-plus-minus">
        <div class="acc-blue-head">
         Rabies Shot Alerts
         <i class="fa fa-plus"></i>
      </div>
      <div class="acc-blue-content">
         <div class="contact-form">
          <form>
           <input type="hidden" name="pet_id" value="<?php echo $postId; ?>">
           <input type="hidden" name="alert_name" value="rabies_shot_alert" class="rabies-shot">
           <div class="field-wrap">
            <div class="field-div">
             <label>*Choose day of the week to receive alert:</label>
             <div class="multi-check-fields mb-15">
              <span>
                  <input type="radio" name="day_of_week" value="7" class="rabies-shot recieve-alert" <?php if (!empty($rabiesShot)) {
                   if (isset($rabiesShot['day_of_week']) && $rabiesShot['day_of_week'] == 7) {
                       echo "checked";
                   }
               } ?> /> Sunday
           </span>
           <span>
              <input type="radio" name="day_of_week" value="1" class="rabies-shot recieve-alert" <?php if (!empty($rabiesShot)) {
               if (isset($rabiesShot['day_of_week']) && $rabiesShot['day_of_week'] == 1) {
                   echo "checked";
               }
           } ?> /> Monday
       </span>
       <span>
          <input type="radio" name="day_of_week" value="2" class="rabies-shot recieve-alert" <?php if (!empty($rabiesShot)) {
           if (isset($rabiesShot['day_of_week']) && $rabiesShot['day_of_week'] == 2) {
               echo "checked";
           }
       } ?> /> Tuesday
      </span>
      <span>
          <input type="radio" name="day_of_week" value="3" class="rabies-shot recieve-alert" <?php if (!empty($rabiesShot)) {
           if (isset($rabiesShot['day_of_week']) && $rabiesShot['day_of_week'] == 3) {
               echo "checked";
           }
       } ?> /> Wednesday
      </span>
      <span>
          <input type="radio" name="day_of_week" value="4" class="rabies-shot recieve-alert" <?php if (!empty($rabiesShot)) {
           if (isset($rabiesShot['day_of_week']) && $rabiesShot['day_of_week'] == 4) {
               echo "checked";
           }
       } ?> /> Thursday
      </span>
      <span>
          <input type="radio" name="day_of_week" value="5" class="rabies-shot recieve-alert" <?php if (!empty($rabiesShot)) {
           if (isset($rabiesShot['day_of_week']) && $rabiesShot['day_of_week'] == 5) {
               echo "checked";
           }
       } ?> /> Friday
      </span>
      <span>
          <input type="radio" name="day_of_week" value="6" class="rabies-shot recieve-alert" <?php if (!empty($rabiesShot)) {
           if (isset($rabiesShot['day_of_week']) && $rabiesShot['day_of_week'] == 6) {
               echo "checked";
           }
       } ?> /> Saturday
      </span>
      </div>
      </div>
      </div>
      <div class="field-wrap two-fields-wrap">
        <div class="field-div">
         <label>*Choose time of day to receive alert:</label>
         <select name="time_of_day" class="rabies-shot" >
             <?php for($i = 1; $i <= 24; $i++): 
              $time = date("h.i A", strtotime("$i:00"));
              if (!empty($rabiesShot)) {
                if (isset($rabiesShot['time_of_day']) && $rabiesShot['time_of_day'] == $time) {
                    echo '<option selected value="'.$time.'">'.$time.'</option>';
                }else{
                    echo '<option value="'.$time.'">'.$time.'</option>';
                }
              }else{
                  echo '<option value="'.$time.'">'.$time.'</option>';  
              }

          endfor; ?>
      </select>
      </div>
      <div class="field-div">
         <label>*Choose first day to receive this alert:</label>
         <input type="text" name="alert_date" class="first-day rabies-shot" readonly="" required="" value="
         <?php if (!empty($rabiesShot)) {
            if (isset($rabiesShot['alert_date']) && !empty($rabiesShot['alert_date'])) {
              echo $rabiesShot['alert_date'];
            }else{
              echo date("F d, Y");
            }
          }else{
              echo date("F d, Y");
          } ?>">
      </div>
      </div>
      <div class="field-wrap two-fields-wrap">
        <div class="field-div">
         <label>*Frequency of alert:</label>
         <select class="rabies-shot" name="frequency_of_alert">
             <?php 
             $i = 1;
             while ( $i <= 12 ) {
              if (!empty($rabiesShot)) {
                  if (isset($rabiesShot['frequency_of_alert']) && $rabiesShot['frequency_of_alert'] == $i) {
                      if ($i == 1) {
                          echo '<option selected value="'.$i.'">Every Month</option>';
                      }else{
                          echo '<option selected value="'.$i.'">Every '.$i.' Months</option>';
                      }
         
                  }else{
                      if ($i == 1) {
                          echo '<option  value="'.$i.'">Every Month</option>';
                      }else{
                          echo '<option  value="'.$i.'">Every '.$i.' Months</option>';
                      }
                  }
              }else{
                  if ($i == 1) {
                      echo '<option value="'.$i.'">Every Month</option>';
                  }else{
                      echo '<option value="'.$i.'">Every '.$i.' Months</option>';
                  } 
              }
              $i++;  
          }
          ?>
      </select>
      </div>
      <div class="field-div">
         <label>*How would you like to receive this alert?:</label>
         <div class="multi-check-fields mb-15">
          <span>
              <input type="radio" name="recieve_alert" value="email" class="rabies-shot alert-type" <?php if (!empty($rabiesShot)) {
               if (isset($rabiesShot['recieve_alert']) && $rabiesShot['recieve_alert'] == "email") {
                   echo "checked";
               }
           } ?> /> By Email
       </span>
       <span>
          <input type="radio" name="recieve_alert" value="phone" class="rabies-shot alert-type" <?php if (!empty($rabiesShot)) {
           if (isset($rabiesShot['recieve_alert']) && $rabiesShot['recieve_alert'] == "phone") {
               echo "checked";
           }
       } ?> /> By Phone, VIA Text Message
      </span>
      </div>
      </div>
      </div>
      <div class="field-wrap">
        <div class="field-div">
         <label>Add Notes (Optional):</label>
         <input type="text" name="note" placeholder="Write Notes..." class="rabies-shot" value="<?php if (!empty($rabiesShot)) {
          if (!empty($rabiesShot['note'])) {
              echo $rabiesShot['note'];
          }
      } ?>">
      </div>
      </div>
      <div class="field-wrap two-fields-wrap">
        <div class="field-div text-left">
         <input type="button" name="" value="Remove Alert" class="site-btn-red remove-sing-up-alert <?php echo $rabiesShotClass; ?>" <?php echo $rabiesShotClass; ?> />
      </div>
      <div class="field-div text-right">
         <input type="button" name="" value="Save Alert" class="site-btn-red sing-up-alert" />
      </div>
      </div>
      <div class="field-wrap">
        <div class="field-notice"></div>
      </div>
      </form>
      </div>
      </div>
      </div>
      <div class="acc-blue-box acc-plus-minus">
        <div class="acc-blue-head">
         Tag Licensing Alerts
         <i class="fa fa-plus"></i>
      </div>
      <div class="acc-blue-content">
         <div class="contact-form">
          <form>
           <input type="hidden" name="pet_id" value="<?php echo $postId; ?>">
           <input type="hidden" name="alert_name" value="tag_licensing_alert" class="tag-licens">
           <div class="field-wrap">
            <div class="field-div">
             <label>*Choose day of the week to receive alert:</label>
             <div class="multi-check-fields mb-15">
              <span>
                  <input type="radio" name="day_of_week" value="7" class="tag-licens recieve-alert" <?php if (!empty($tagLicens)) {
                   if (isset($tagLicens['day_of_week']) && $tagLicens['day_of_week'] == 7) {
                       echo "checked";
                   }
               } ?> /> Sunday
           </span>
           <span>
              <input type="radio" name="day_of_week" value="1" class="tag-licens recieve-alert" <?php if (!empty($tagLicens)) {
               if (isset($tagLicens['day_of_week']) && $tagLicens['day_of_week'] == 1) {
                   echo "checked";
               }
           } ?> /> Monday
       </span>
       <span>
          <input type="radio" name="day_of_week" value="2" class="tag-licens recieve-alert" <?php if (!empty($tagLicens)) {
           if (isset($tagLicens['day_of_week']) && $tagLicens['day_of_week'] == 2) {
               echo "checked";
           }
       } ?> /> Tuesday
      </span>
      <span>
          <input type="radio" name="day_of_week" value="3" class="tag-licens recieve-alert" <?php if (!empty($tagLicens)) {
           if (isset($tagLicens['day_of_week']) && $tagLicens['day_of_week'] == 3) {
               echo "checked";
           }
       } ?> /> Wednesday
      </span>
      <span>
          <input type="radio" name="day_of_week" value="4" class="tag-licens recieve-alert" <?php if (!empty($tagLicens)) {
           if (isset($tagLicens['day_of_week']) && $tagLicens['day_of_week'] == 4) {
               echo "checked";
           }
       } ?> /> Thursday
      </span>
      <span>
          <input type="radio" name="day_of_week" value="5" class="tag-licens recieve-alert" <?php if (!empty($tagLicens)) {
           if (isset($tagLicens['day_of_week']) && $tagLicens['day_of_week'] == 5) {
               echo "checked";
           }
       } ?> /> Friday
      </span>
      <span>
          <input type="radio" name="day_of_week" value="6" class="tag-licens recieve-alert" <?php if (!empty($tagLicens)) {
           if (isset($tagLicens['day_of_week']) && $tagLicens['day_of_week'] == 6) {
               echo "checked";
           }
       } ?> /> Saturday
      </span>
      </div>
      </div>
      </div>
      <div class="field-wrap two-fields-wrap">
        <div class="field-div">
         <label>*Choose time of day to receive alert:</label>
         <select name="time_of_day" class="tag-licens" >
             <?php for($i = 1; $i <= 24; $i++): 
              $time = date("h.i A", strtotime("$i:00"));
              if (!empty($tagLicens)) {
                  if (isset($tagLicens['time_of_day']) && $tagLicens['time_of_day'] == $time) {
                      echo '<option selected value="'.$time.'">'.$time.'</option>';
                  }else{
                      echo '<option value="'.$time.'">'.$time.'</option>';
                  }
              }else{
                  echo '<option value="'.$time.'">'.$time.'</option>';  
              }

          endfor; ?>
      </select>
      </div>
      <div class="field-div">
         <label>*Choose first day to receive this alert:</label>
         <input type="text" required="" name="alert_date" class="first-day tag-licens" readonly="" value="<?php if (!empty($tagLicens)) {
          if (isset($tagLicens['alert_date']) && !empty($tagLicens['alert_date'])) {
              echo $tagLicens['alert_date'];
          }else{
              echo date("F d, Y");
          }
      }else{
          echo date("F d, Y");
      } ?>">
      </div>
      </div>
      <div class="field-wrap two-fields-wrap">
        <div class="field-div">
         <label>*Frequency of alert:</label>
         <select class="tag-licens" name="frequency_of_alert">
             <?php 
             $i = 1;
             while ( $i <= 12 ) {
              if (!empty($tagLicens)) {
                  if (isset($tagLicens['frequency_of_alert']) && $tagLicens['frequency_of_alert'] == $i) {
                      if ($i == 1) {
                          echo '<option selected value="'.$i.'">Every Month</option>';
                      }else{
                          echo '<option selected value="'.$i.'">Every '.$i.' Months</option>';
                      }
                  }else{
                      if ($i == 1) {
                          echo '<option  value="'.$i.'">Every Month</option>';
                      }else{
                          echo '<option  value="'.$i.'">Every '.$i.' Months</option>';
                      }
                  }
              }else{
                  if ($i == 1) {
                      echo '<option value="'.$i.'">Every Month</option>';
                  }else{
                      echo '<option value="'.$i.'">Every '.$i.' Months</option>';
                  }
              }

              $i++;  
          }
          ?>
      </select>
      </div>
      <div class="field-div">
         <label>*How would you like to receive this alert?:</label>
         <div class="multi-check-fields mb-15">
          <span>
              <input type="radio" name="recieve_alert" value="email" class="tag-licens alert-type" <?php if (!empty($tagLicens)) {
               if (isset($tagLicens['recieve_alert']) && $tagLicens['recieve_alert'] == "email") {
                   echo "checked";
               }
           } ?> /> By Email
       </span>
       <span>
          <input type="radio" name="recieve_alert" value="phone" class="tag-licens alert-type" <?php if (!empty($tagLicens)) {
           if (isset($tagLicens['recieve_alert']) && $tagLicens['recieve_alert'] == "phone") {
               echo "checked";
           }
       } ?> /> By Phone, VIA Text Message
      </span>
      </div>
      </div>
      </div>
      <div class="field-wrap">
        <div class="field-div">
         <label>Add Notes (Optional):</label>
         <input type="text" name="note" placeholder="Write Notes..." class="tag-licens" value="<?php if (!empty($tagLicens)) {
          if (!empty($tagLicens['note'])) {
              echo $tagLicens['note'];
          }
      } ?>">
      </div>
      </div>
      <div class="field-wrap two-fields-wrap">
        <div class="field-div text-left">
         <input type="button" name="" value="Remove Alert" class="site-btn-red remove-sing-up-alert <?php echo $tagLicensClass; ?>" <?php echo $tagLicensClass; ?> />
      </div>
      <div class="field-div text-right">
         <input type="button" name="" value="Save Alert" class="site-btn-red sing-up-alert" />
      </div>
      </div>
      <div class="field-wrap">
        <div class="field-notice"></div>
      </div>
      </form>
      </div>
      </div>
      </div>
      <div class="custom-box-wrap">
        <?php 
        $j = 1;
        $k = 0;
        $m = 0;
        while ( $j <= 10 ) {
         $customAlert = get_post_meta($postId,"custom_alert_".$j,true);
         if (!empty($customAlert)) { ?>
            <div class="acc-blue-box acc-plus-minus custom-box">
             <div class="acc-blue-head">
              Custom Alert :- <?php echo $customAlert['custom_alert_name']; ?>
              <i class="fa fa-plus"></i>
          </div>
          <div class="acc-blue-content">
              <div class="contact-form">
               <form>
                <div class="field-wrap">
                 <div class="field-div">
                  <label>*Name Your Custom Alert:</label>
                  <input type="text" name="custom_alert_name" class="custom-alert" required="" value="<?php if (!empty($customAlert)) {
                   if (isset($customAlert['custom_alert_name'])) {
                       echo trim($customAlert['custom_alert_name']);
                   }
               } ?>">
               <input type="hidden" name="custom_alert_number" value="<?php echo "custom_alert_".$j; ?>" class="custom-alert-number">
               <input type="hidden" name="pet_id" value="<?php echo $postId; ?>">
           </div>
       </div>
       <div class="field-wrap">
         <div class="field-div">
          <label>*Choose day of the week to receive alert:</label>
          <div class="multi-check-fields mb-15">
           <span>
               <input type="radio" name="day_of_week" value="7" class="tag-licens recieve-alert" required="" <?php if (!empty($customAlert)) {
                if (isset($customAlert['day_of_week']) && $customAlert['day_of_week'] == 7) {
                    echo "checked";
                }
            } ?> /> Sunday
        </span>
        <span>
           <input type="radio" name="day_of_week" value="1" class="tag-licens recieve-alert" <?php if (!empty($customAlert)) {
            if (isset($customAlert['day_of_week']) && $customAlert['day_of_week'] == 1) {
                echo "checked";
            }
        } ?> required="" /> Monday
      </span>
      <span>
       <input type="radio" name="day_of_week" value="2" class="tag-licens recieve-alert" <?php if (!empty($customAlert)) {
        if (isset($customAlert['day_of_week']) && $customAlert['day_of_week'] == 2) {
            echo "checked";
        }
      } ?> required="" /> Tuesday
      </span>
      <span>
       <input type="radio" name="day_of_week" value="3" class="tag-licens recieve-alert" <?php if (!empty($customAlert)) {
        if (isset($customAlert['day_of_week']) && $customAlert['day_of_week'] == 3) {
            echo "checked";
        }
      } ?> required="" /> Wednesday
      </span>
      <span>
       <input type="radio" name="day_of_week" value="4" class="tag-licens recieve-alert" <?php if (!empty($customAlert)) {
        if (isset($customAlert['day_of_week']) && $customAlert['day_of_week'] == 4) {
            echo "checked";
        }
      } ?> required="" /> Thursday
      </span>
      <span>
       <input type="radio" name="day_of_week" value="5" class="tag-licens recieve-alert" <?php if (!empty($customAlert)) {
        if (isset($customAlert['day_of_week']) && $customAlert['day_of_week'] == 5) {
            echo "checked";
        }
      } ?> required="" /> Friday
      </span>
      <span>
       <input type="radio" name="day_of_week" value="6" class="tag-licens recieve-alert" <?php if (!empty($customAlert)) {
        if (isset($customAlert['day_of_week']) && $customAlert['day_of_week'] == 6) {
            echo "checked";
        }
      } ?> required="" /> Saturday
      </span>
      </div>
      </div>
      </div>
      <div class="field-wrap two-fields-wrap">
         <div class="field-div">
          <label>*Choose time of day to receive alert:</label>
          <select name="time_of_day" class="tag-licens" >
              <?php for($i = 1; $i <= 24; $i++): 
               if (!empty($customAlert)) {
                   if (isset($customAlert['time_of_day']) && $customAlert['time_of_day'] == date("h.i A", strtotime("$i:00"))) {
                       echo '<option selected value="'.date("h.i A", strtotime("$i:00")).'">'. date("h.i A", strtotime("$i:00")).'</option>';
                   }else{
                       echo '<option value="'.date("h.i A", strtotime("$i:00")).'">'. date("h.i A", strtotime("$i:00")).'</option>';
                   }
               }else{
                   echo '<option value="'.date("h.i A", strtotime("$i:00")).'">'. date("h.i A", strtotime("$i:00")).'</option>';  
               }
           endfor; ?>
       </select>
      </div>
      <div class="field-div">
          <label>*Choose first day to receive this alert:</label>
          <input type="text" name="alert_date" class="first-day tag-licens" readonly="" required="" value="<?php if (!empty($customAlert)) {
           if (isset($customAlert['alert_date']) && !empty($customAlert['alert_date'])) {
               echo $customAlert['alert_date'];
           }else{
               echo date("F d, Y");
           }
       }else{
           echo date("F d, Y");
       } ?>">
      </div>
      </div>
      <div class="field-wrap two-fields-wrap">
         <div class="field-div">
          <label>*Frequency of alert:</label>
          <select class="tag-licens" name="frequency_of_alert">
              <?php 
              $i = 1;
              while ( $i <= 12 ) {
               if (!empty($customAlert)) {
                   if (isset($customAlert['frequency_of_alert']) && $customAlert['frequency_of_alert'] == $i) {
                       if ($i == 1) {
                           echo '<option selected value="'.$i.'">Every Month</option>';
                       }else{
                           echo '<option selected value="'.$i.'">Every '.$i.' Months</option>';
                       }
                   }else{
                       if ($i == 1) {
                           echo '<option  value="'.$i.'">Every Month</option>';
                       }else{
                           echo '<option  value="'.$i.'">Every '.$i.' Months</option>';
                       }
                   }
               }else{
                   if ($i == 1) {
                       echo '<option value="'.$i.'">Every Month</option>';
                   }else{
                       echo '<option value="'.$i.'">Every '.$i.' Months</option>';
                   } 
               }

               $i++;  
           }
           ?>
       </select>
      </div>
      <div class="field-div">
          <label>*How would you like to receive this alert?:</label>
          <div class="multi-check-fields mb-15">
           <span>
               <input type="radio" name="recieve_alert" value="email" class="tag-licens alert-type" <?php if (!empty($customAlert)) {
                if (isset($customAlert['recieve_alert']) && $customAlert['recieve_alert'] == "email") {
                    echo "checked";
                }
            } ?> required="" /> By Email
        </span>
        <span>
           <input type="radio" name="recieve_alert" value="phone" class="tag-licens alert-type" <?php if (!empty($customAlert)) {
            if (isset($customAlert['recieve_alert']) && $customAlert['recieve_alert'] == "phone") {
                echo "checked";
            }
        } ?> required="" /> By Phone, VIA Text Message
      </span>
      </div>
      </div>
      </div>
      <div class="field-wrap">
         <div class="field-div">
          <label>Add Notes (Optional):</label>
          <input type="text" name="note" placeholder="Write Notes..." class="tag-licens" value="<?php if (!empty($customAlert)) {
           if (!empty($customAlert['note'])) {
               echo $customAlert['note'];
           }
       } ?>">
      </div>
      </div>
      <div class="field-wrap two-fields-wrap">
         <div class="field-div text-left">
          <input type="button" name="" value="Remove Alert" class="site-btn-red remove-custom-alert" />
      </div>
      <div class="field-div text-right">
          <input type="button" name="" value="Save Alert" class="site-btn-red custom-alert" />
      </div>
      </div>
      <div class="field-wrap">
         <div class="field-notice"></div>
      </div>
      </form>
      </div>
      </div>
      </div>
      <?php 
      }else{
         break;
      }
      $j++;
      }

      $customName = "custom_alert_".$j; ?>
      <div class="acc-blue-box acc-plus-minus custom-box">
         <div class="acc-blue-head">
          Create a Custom Alert
          <i class="fa fa-plus"></i>
      </div>
      <div class="acc-blue-content">
          <div class="contact-form">
           <form>
            <div class="field-wrap">
             <div class="field-div">
              <label>*Name Your Custom Alert:</label>
              <input type="text" name="custom_alert_name" class="custom-alert" required="">
              <input type="hidden" name="custom_alert_number" value="<?php echo $customName; ?>"  class="custom-alert-number">
              <input type="hidden" name="pet_id" value="<?php echo $postId; ?>">
          </div>
      </div>
      <div class="field-wrap">
         <div class="field-div">
          <label>*Choose day of the week to receive alert:</label>
          <div class="multi-check-fields mb-15">
           <span>
               <input type="radio" name="day_of_week" value="7" class="custom-alert recieve-alert" required="" /> Sunday
           </span>
           <span>
               <input type="radio" name="day_of_week" value="1" class="custom-alert recieve-alert" required="" /> Monday
           </span>
           <span>
               <input type="radio" name="day_of_week" value="2" class="custom-alert recieve-alert" required="" /> Tuesday
           </span>
           <span>
               <input type="radio" name="day_of_week" value="3" class="custom-alert recieve-alert" required="" /> Wednesday
           </span>
           <span>
               <input type="radio" name="day_of_week" value="4" class="custom-alert recieve-alert" required="" /> Thursday
           </span>
           <span>
               <input type="radio" name="day_of_week" value="5" class="custom-alert recieve-alert" required="" /> Friday
           </span>
           <span>
               <input type="radio" name="day_of_week" class="custom-alert recieve-alert" value="6" required="" /> Saturday
           </span>
       </div>
      </div>
      </div>
      <div class="field-wrap two-fields-wrap">
         <div class="field-div">
          <label>*Choose time of day to receive alert:</label>
          <select name="time_of_day" class="custom-alert">
           <?php for($i = 1; $i <= 24; $i++): ?>
               <option value="<?= date("h.i A", strtotime("$i:00")); ?>"><?= date("h.i A", strtotime("$i:00")); ?></option>
           <?php endfor; ?>
       </select>
      </div>
      <div class="field-div">
          <label>*Choose first day to receive this alert:</label>
          <input type="text" name="alert_date" class="first-day custom-alert" readonly="" value="<?php echo date("F d, Y"); ?>" required="">
      </div>
      </div>
      <div class="field-wrap two-fields-wrap">
         <div class="field-div">
          <label>*Frequency of alert:</label>
          <select class="custom-alert" name="frequency_of_alert">
              <?php 
              $i = 1;
              while ( $i <= 12 ) {
               if ($i == 1) {
                   echo '<option value="'.$i.'">Every Month</option>';
               }else{
                   echo '<option value="'.$i.'">Every '.$i.' Months</option>';
               }
               $i++;  
           }
           ?>
       </select>
      </div>
      <div class="field-div">
          <label>*How would you like to receive this alert?:</label>
          <div class="multi-check-fields mb-15">
           <span>
               <input type="radio" name="recieve_alert" class="custom-alert alert-type" value="email" required="" /> By Email
           </span>
           <span>
               <input type="radio" name="recieve_alert" class="custom-alert alert-type" value="phone" required="" /> By Phone, VIA Text Message
           </span>
       </div>
      </div>
      </div>
      <div class="field-wrap">
         <div class="field-div">
          <label>Add Notes (Optional):</label>
          <input type="text" name="note" placeholder="Write Notes..." class="custom-alert">
      </div>
      </div>
      <div class="field-wrap two-fields-wrap">
         <div class="field-div text-left">
          <input type="button" name="" value="Remove Alert" class="site-btn-red remove-custom-alert disabled" disabled="" />
      </div>
      <div class="field-div text-right">
          <input type="button" name="" value="Save Alert" class="site-btn-red custom-alert" />
      </div>
      </div>
      </form>
      </div>
      </div>
      </div>
      </div>
      <div class="notice">
        Notice:- You can add upto 10 Custom Alert.
      </div>
      <br>
      <div class="field-wrap">
        <div class="field-div">
         <button id="add-custom"><i class="fa fa-plus"></i> Create a Custom Alert</button>
      </div>
      </div>
      </div>
      <script type="text/javascript">
       window.alertCheck = 0;
       jQuery(document).ready(function($) {
           var clone  = $(".custom-box:last-child").clone();
           $("body").on("click","#add-custom",function(){
               if ($(".custom-box").length == 10) {
                   $("#add-custom").prop("disabled",true);
                   alert("You have already created the 10 custom alert");
                   return;
               }else{
                   $("#add-custom").prop("disabled",false);
               }
               var clone2 = clone.clone().find(".first-day").each(function(){
                   $(this).removeClass("hasDatepicker");
                   $(this).removeAttr('id');
               }).end();
               clone2 = clone2.find('.error').remove().end();
               var fclone = clone2.find('.custom-alert-number').each(function(){
                   $(this).val("0");
               }).end();
               fclone = fclone.find('.remove-custom-alert').each(function(){
                   $(this).attr("disabled",true);
                   $(this).addClass("disabled");
                   $(this).addClass("clone-btn");
               }).end();
               $(fclone).appendTo(".custom-box-wrap");
               $("body").find(".first-day").datepicker({
                   dateFormat : "MM d, yy",
                   minDate: 0
               });
           });

           $("body").find(".first-day").datepicker({
               dateFormat : "MM d, yy",
               minDate: 0
           });

           $('input[type="text"]').on("change", function() {   
               if ($(this)[0].hasAttribute("required")) {
                   if ($(this).val() != "") {
                       $(this).parent().find('label.error').remove();
                   }
               }                               
           });

           $('input[type="radio"]').on("change", function() {   
               if ($(this)[0].hasAttribute("required")) {
                   if ($(this).val() != "") {
                       $(this).parent().parent().find('label.error').remove();
                   }
               }                               
           });


           $('input[type="button"].sing-up-alert').on("click",function(){

               $this            = $(this);
               var heartworm    = new FormData();
               var error        = 0;
               var recieveAlert = 1;
               var alertType    = 1;

               $(this).parent().parent().parent().find('label.error').remove();

               var date = $.datepicker.parseDate('MM d, yy', $(this).parent().parent().parent().find("input[name=alert_date]").val());
               var currentDate = new Date();
               currentDate.setHours(0,0,0,0);
               console.log(currentDate);
               if (date < currentDate) {
                   $(this).parent().parent().parent().find("input[name=alert_date]").after('<label class="error">Please select new date.</label>');
                   error = 1;
               }

               $.each($(this).parent().parent().parent().find('input[type="text"]'), function() {   
                   if ($(this)[0].hasAttribute("required")) {
                       if (!$(this).val()) {
                           $(this).parent().find("label.error").remove();
                           $(this).parent().append('<label class="error">This field is required.</label>');
                           error = 1;
                       }
                   }            
                   heartworm.append($(this).attr('name'), $(this).val());                   
               });
               $.each($(this).parent().parent().parent().find('input[type="hidden"]'), function() {               
                   heartworm.append($(this).attr('name'), $(this).val());                   
               });
               $.each($(this).parent().parent().parent().find('input[type="radio"]'), function() {       
                   if ($(this).prop('checked') == true) {
                       heartworm.append($(this).attr('name'), $(this).val());
                   }                      
               });
               $.each($(this).parent().parent().parent().find('select'), function() {      
                   heartworm.append($(this).attr('name'), $(this).val());                       
               });
               $.each($(this).parent().parent().parent().find('.recieve-alert'), function() {      
                   if ($(this).prop('checked') == true) {
                       recieveAlert = 0;
                       return;
                   }                       
               });
               $.each($(this).parent().parent().parent().find('.alert-type'), function() {      
                   if ($(this).prop('checked') == true) {
                       alertType = 0;
                       return;
                   }                       
               });

               if (recieveAlert && alertType) {

                   $(this).parent().parent().parent().find('.recieve-alert:first').parent().parent().append('<label class="error mtt-1">This field is required.</label>');
                   $(this).parent().parent().parent().find('.alert-type:first').parent().parent().append('<label class="error mtt-1">This field is required.</label>');
                   return;

               }else if(recieveAlert){

                   $(this).parent().parent().parent().find('.recieve-alert:first').parent().parent().append('<label class="error mtt-1">This field is required.</label>');
                   return;

               }else if(alertType){

                   $(this).parent().parent().parent().find('.alert-type:first').parent().parent().append('<label class="error mtt-1">This field is required.</label>');
                   return;
               }

               if (error) {
                   return;
               }


               heartworm.append('action', 'updateAlerts');
               heartworm.append('status', 1);
               $.ajax({
                   type: 'POST',
                   url: '<?php echo admin_url( 'admin-ajax.php' ); ?>',
                   data: heartworm,
                   contentType: false,
                   processData: false,
                   dataType: 'json',
                   success: function(res){
                       console.log(res);
                       console.log(res.class);
                         // res = jQuery.parseJSON(res);
                         if (res.success == 1) {
                           $($this).parent().parent().parent().find('.field-notice').text(res.msg);
                           $($this).parent().parent().parent().find(".remove-sing-up-alert").removeClass("disabled").attr("disabled",false);
                           $(".standard-alerts").find("."+res.class).attr("checked",true);
                       }
                   }
               });
           });
      $('body').on('click','input[type="button"].custom-alert',function(){
       $this            = $(this);
       window.alertCheck= 0;
       var heartworm    = new FormData();
       var error        = 0;
       var recieveAlert = 1;
       var alertType    = 1;

       $(this).parent().parent().parent().find('label.error').remove();

       $.each($(this).parent().parent().parent().find('input[type="text"]'), function() {  
           if ($(this)[0].hasAttribute("required")) {
               if (!$(this).val()) {
                   $(this).parent().find("label.error").remove();
                   $(this).parent().append('<label class="error">This field is required.</label>');
                   error = 1;
               }
           }             
           heartworm.append($(this).attr('name'), $(this).val());                   
       });
       $.each($(this).parent().parent().parent().find('input[type="hidden"]'), function() {               
           heartworm.append($(this).attr('name'), $(this).val());                   
       });
       $.each($(this).parent().parent().parent().find('input[type="radio"]'), function() {       
           if ($(this).prop('checked') == true) {
               heartworm.append($(this).attr('name'), $(this).val());
           }                          
       });
       $.each($(this).parent().parent().parent().find('select'), function() {      
           heartworm.append($(this).attr('name'), $(this).val());                       
       });


       $.each($(this).parent().parent().parent().find('.recieve-alert'), function() {      
           if ($(this).prop('checked') == true) {
               recieveAlert = 0;
               return;
           }                       
       });
       $.each($(this).parent().parent().parent().find('.alert-type'), function() {      
           if ($(this).prop('checked') == true) {
               alertType = 0;
               return;
           }                       
       });

       if (recieveAlert && alertType) {
           $(this).parent().parent().parent().find('.recieve-alert:first').parent().parent().find('label.error').remove();
           $(this).parent().parent().parent().find('.recieve-alert:first').parent().parent().append('<label class="error mtt-1">This field is required.</label>');
           $(this).parent().parent().parent().find('.alert-type:first').parent().parent().find('label.error').remove();
           $(this).parent().parent().parent().find('.alert-type:first').parent().parent().append('<label class="error mtt-1">This field is required.</label>');
           return;
       }else if(recieveAlert){
           $(this).parent().parent().parent().find('.recieve-alert:first').parent().parent().find('label.error').remove();
           $(this).parent().parent().parent().find('.recieve-alert:first').parent().parent().append('<label class="error mtt-1">This field is required.</label>');
           return;
       }else if(alertType){
           $(this).parent().parent().parent().find('.alert-type:first').parent().parent().find('label.error').remove();
           $(this).parent().parent().parent().find('.alert-type:first').parent().parent().append('<label class="error mtt-1">This field is required.</label>');
           return;
       }

       if (error) {
           return;
       }

       heartworm.append('action', 'updateCustomAlerts');
       heartworm.append('status', 1);
       $.ajax({
           type: 'POST',
           url: '<?php echo admin_url( 'admin-ajax.php' ); ?>',
           data: heartworm,
           contentType: false,
           processData: false,
           dataType: 'json',
           success: function(res){
               console.log(res);
                         // res = jQuery.parseJSON(res);
                         if (res.success == 1) {
                           $($this).parent().parent().parent().find('.field-notice').text(res.msg);
                           $($this).parent().parent().parent().find(".custom-alert-number").val(res.alertName);
                           $($this).parent().parent().parent().find(".remove-custom-alert").removeClass("disabled").attr("disabled",false);
                           $.each($('input.custom-alert-number'), function() {  
                               if ($(this).val() != "0") {
                                   window.alertCheck = 1;
                                   return false; 
                               }
                           });
                           if (window.alertCheck) {
                               $(".standard-alerts .custom-alert").attr("checked",true);
                           }else{
                               $(".standard-alerts .custom-alert").attr("checked",false);
                           }
                       }
                   }
               });
      });
      $('body').on('click','input[type="button"].remove-sing-up-alert',function(){
       $this = $(this);
       var heartworm = new FormData();
       $.each($(this).parent().parent().parent().find('input[type="hidden"]'), function() {               
           heartworm.append($(this).attr('name'), $(this).val());                   
       });
       heartworm.append('action', 'removeAlerts');
       $.ajax({
           type: 'POST',
           url: '<?php echo admin_url( 'admin-ajax.php' ); ?>',
           data: heartworm,
           contentType: false,
           processData: false,
           dataType: 'json',
           success: function(res){
               console.log(res);
                         // res = jQuery.parseJSON(res);
                         if (res.success == 1) {
                           $($this).parent().parent().parent().find('.field-notice').text(res.msg);
                           $($this).parent().parent().parent().find(".remove-custom-alert").addClass("disabled").attr("disabled",true);
                           $(".standard-alerts").find("."+res.class).attr("checked",false);
                       }
                   }
               });
      });
      $('body').on('click','input[type="button"].remove-custom-alert',function(){
       $this = $(this);
       window.alertCheck = 0;
       var name = $(".custom-alert-number").val();
       if (name != '0') {
           var heartworm = new FormData();
           $.each($(this).parent().parent().parent().find('input[type="hidden"]'), function() {               
               heartworm.append($(this).attr('name'), $(this).val());                   
           });
           heartworm.append('action', 'removeCustomAlerts');
          $.ajax({
           type: 'POST',
           url: '<?php echo admin_url( 'admin-ajax.php' ); ?>',
           data: heartworm,
           contentType: false,
           processData: false,
           dataType: 'json',
           success: function(res){
               console.log(res);
                         // res = jQuery.parseJSON(res);
                         if (res.success == 1) {
                           if ($(".custom-box").length < 10) {
                               $("#add-custom").prop("disabled",false);
                           }
                           var currentAlertName = $($this).parent().parent().parent().parent().parent().parent().find("input[name=custom_alert_number]").val();
                           var newAlertName     = "";
                           var checkAlertName   = 0;

                           $(".custom-box-wrap .acc-blue-box.acc-plus-minus.custom-box").each(function(i){
                               var j = i++;
                               var customAlertName = $(this).find("input[name=custom_alert_number]").val();

                               if (checkAlertName) {
                                   $(this).find("input[name=custom_alert_number]").val("custom_alert_"+j);
                               }

                               if (currentAlertName == customAlertName) {
                                   checkAlertName = 1;
                               }
                           })
                           $($this).parent().parent().parent().find('.field-notice').text(res.msg);
                           $($this).parent().parent().parent().find(".custom-alert-number").val("0");
                           if ($(".custom-box-wrap .custom-box").length > 1) {
                               $($this).parent().parent().parent().parent().parent().parent().remove();
                           }
                           $.each($('input.custom-alert-number'), function() {  
                               if ($(this).val() != "0") {
                                   window.alertCheck = 1;
                                   return false; 
                               }
                           });
                           console.log(window.alertCheck);
                           if (window.alertCheck) {
                               $(".standard-alerts .custom-alert").attr("checked",true);
                           }else{
                               $(".standard-alerts .custom-alert").attr("checked",false);
                           }
                       }
                   }
               });
        }else{
             if ($(".custom-box-wrap .custom-box").length > 1) {
                 $($this).parent().parent().parent().parent().parent().parent().remove();
             }
             $.each($('input.custom-alert-number'), function() {  
                 if ($(this).val() != "0") {
                     $(".standard-alerts .custom-alert").attr("checked",true);
                     return false; 
                 }else{
                     $(".standard-alerts .custom-alert").attr("checked",false);
                 }
             });
         }

        });
        $.each($('input.custom-alert-number'), function() {  
         if ($(this).val() != "0") {
             $(".standard-alerts .custom-alert").attr("checked",true);
             return false; 
         }
        });
         
        });
      </script>
    <?php }else{ ?>
      <p><a href="<?php echo site_url().'/my-account/view-subscription/'.$subscriptionId.'/'; ?>" class="button view site-btn-red">Upgrade Protection Plan <i class="fa fa-caret-right"></i></a></p>
      <p style="color: red;">Smart Tag's Alerts service is for Platinum Plan only, Upgrade Pet Protection Plan to receive alerts.</p>
    <?php }
  }
} 


/*Report My Pet as Lost Section*/

add_action( 'woocommerce_account_all-pet-profile_endpoint', 'my_account_endpoint_content_for_show_pet_profile' );
function my_account_endpoint_content_for_show_pet_profile() {

 $paged  = (get_query_var('paged')) ? get_query_var('paged') : 1;
 echo "<div class='page-heading'><h1>My Pets Information</h1></div>";
 $userId = get_current_user_id();
 $args   = array(
     'post_type' => 'pet_profile',
     'paged' => $paged,
     'author' => $userId,
     'posts_per_page' => 10,
 );                       
 $query = new WP_Query($args);
 $i = 0;
 if ($query->have_posts()) {
     while ( $query->have_posts() ) : $query->the_post(); 
         $mypod = pods( 'pet_profile', get_the_id() ); 
         $smarttag_id_number = $mypod->display('smarttag_id_number');
         $microchip_id_number = $mypod->display('microchip_id_number');
         $subscriptionId  = $mypod->display("smarttag_subscription_id");
         if (!empty($subscriptionId)) {
             $subscription   = wcs_get_subscription($subscriptionId);
             if (!empty($subscription)) {
                   // print_r($subscription);
                 $startDate      = $subscription->get_date("start");
                 $date           = $subscription->get_date("end");
                 if (empty($date)) {
                     $date           = $subscription->get_date("next_payment");
                 }
                 $date           = date_parse_from_format('Y-m-d H:i:s',$date);
                 $date           = mktime(0, 0, 0, $date['month'], $date['day'], $date['year']);
                 $date           = date("m/d/Y", $date);

                 $startDate           = date_parse_from_format('Y-m-d H:i:s',$startDate);
                 $startDate           = mktime(0, 0, 0, $startDate['month'], $startDate['day'], $startDate['year']);
                 $startDate           = date("m/d/Y", $startDate);
                   // $subscription = wc_get_order($subscriptionId);
                 foreach( $subscription->get_items() as $item_id => $product_subscription ){
                       // Get the name
                     $product_name = $product_subscription['name']." (Expires: ".$date.")";
                     $variationId  = $product_subscription['variation_id'];
                 }
             }
         }else{
             $product_name = '';
             $startDate    = '';
             $date         = '';
         }

         ?>
         <div class="bottom-border-box">
             <h3>Registered Pet <?php echo ++$i; ?></h3>
             <div class="row">
              <div class="col-sm-3 rmb-15">
               <a href="javascript:;" class="show-post">
                   <?php echo get_the_post_thumbnail(); ?>
               </a>
           </div>
           <div class="col-sm-5 rmb-15">
               <strong>Pet Name:</strong> <a href="javascript:;" class="show-post"><span class="name"><?php echo get_the_title(); ?></span></a>
               <br>
               <strong>Pet Type:</strong> <span><?php $typeId = $mypod->display('pet_type');
						echo (isset(get_term( $typeId )->name)) ? get_term( $typeId )->name : "" ;
						 ?></span>
               <br>
               <strong>IDTag Serial Number:</strong> <span class="name"><?php echo $mypod->display('smarttag_id_number'); ?></span>
               <br>
               <strong>IDTag Microchip Number:</strong> <span class="name"><?php echo $microchip_id_number; ?></span>
               <br>
               <strong>ID Tag Plan:</strong> <span><?php echo $product_name; ?></span>
           </div>
           <div class="col-sm-4 mb-elements">
               <form action="" method="post" class="custom-form">
                <input type="hidden" name="post_id" value="<?php echo get_the_ID(); ?>">
                <input type="hidden" name="startDate" value="<?php echo $startDate; ?>">
                <input type="hidden" name="endDate" value="<?php echo $date; ?>">
                <input type="hidden" name="smarttagid" value="<?php echo $smarttag_id_number; ?>">
                <?php if (!empty($product_name)) { ?>
                    <p><a href="<?php echo site_url().'/my-account/view-subscription/'.$subscriptionId.'/'; ?>" class="button view site-btn-light-blue">Upgrade Protection Plan <i class="fa fa-caret-right"></i></a></p>
                <?php } ?>
                <?php
                $check = checkSmartIDTag(1,'lost_found_pets','pet_status','smarttag_id_number',$smarttag_id_number);
                if ($check) {
                 echo '<p><button type="button" class="report-pet-as-lost site-btn-light-blue">Report Pet As Lost <i class="fa fa-caret-right"></i></button></p>';
             }else{
                 echo '<p><input type="hidden" name="smarttag_id_number" value="'.$smarttag_id_number.'"><input type="hidden" name="report_pet_as_found" value="1"><button type="button" class="report-pet-as-found site-btn-red">Report Pet As Found <i class="fa fa-caret-right"></i></button></p>';
             }
             ?>
             <p><a href="javascript:;" class="custom-replacement-tag-btn light-blue-link"><strong>Order a free Replacement Tag 22</strong> <i class="fa fa-caret-right"></i></a></p>
             <p><a href="javascript:;" class="show-post light-blue-link"><strong>View/Edit Full Pet Profile</strong><i class="fa fa-caret-right"></i></a></p>
         </form>
     </div>
 </div>
</div>
<?php 
endwhile;
$total_pages = $query->max_num_pages;
if ($total_pages > 1){

 $current_page = max(1, get_query_var('paged'));

 echo paginate_links(array(
     'base' => get_pagenum_link(1) . '%_%',
     'format' => 'page/%#%',
     'current' => $current_page,
     'total' => $total_pages,
     'prev_text'    => __('« prev'),
     'next_text'    => __('next »'),
 ));
}?>
<?php
} else{
 echo "Sorry, No pet found";
}

}

add_action( 'woocommerce_account_report-pet-lost_endpoint', 'my_account_report_pet_lost_content' );
function my_account_report_pet_lost_content() {

 echo "<div class='page-heading'><h1>Report My Pet as Lost</h1></div>"; 

 wc_get_template("myaccount/content-report-pet-lost.php", array()  );
}

add_action( 'woocommerce_account_report-my-pet-lost_endpoint', 'my_account_endpoint_content_for_report_my_pet_lost' );
function my_account_endpoint_content_for_report_my_pet_lost() {

 echo "<div class='page-heading'><h1>Report My Pet as Lost</h1></div>";
 wc_get_template("myaccount/content-report-my-pet-lost.php", array()  );

}

/*List of pet Pet all founder*/

add_action( 'woocommerce_account_report-pet-found-list_endpoint', 'my_account_endpoint_content_for_show_pet_founder_list' );
function my_account_endpoint_content_for_show_pet_founder_list(){
 echo '<div class="page-heading"><h1>Report My Pet as Lost</h1></div>';
 if (isset($_GET['pet_id'])) {
  wc_get_template("myaccount/content-report-pet-found-list.php", array()  );
 }
}

/*My Pets Information Section*/
add_action( 'woocommerce_account_show-profile_endpoint', 'my_account_endpoint_content_for_show_profile' );
function my_account_endpoint_content_for_show_profile() {
  //var_dump(get_query_var("show-profile"));
  //var_dump(get_query_var('page'));
  echo "<div class='page-heading'><h1>Pet Profile Information</h1></div>";
  if (isset($_GET['pet_id']) && !empty($_GET['pet_id'])) {
    wc_get_template("myaccount/content-show-profile.php", array()  );
  }
}

add_action('wp_ajax_updatePetInformations', 'handle_updatePetInformation');
add_action('wp_ajax_nopriv_updatePetInformations', 'handle_updatePetInformation');
function handle_updatePetInformation(){
 echo updatePetInformation($_POST,$_POST['postId']);
 exit();
}
add_action('wp_ajax_updateOwnerInformations', 'handle_updateOwnerInformation');
add_action('wp_ajax_updateOwnerInformations', 'handle_updateOwnerInformation');
function handle_updateOwnerInformation(){
 $userId = get_current_user_id();
 echo updateOwnerInformation($_POST,$userId,0);
 exit();
}
add_action('wp_ajax_updateAlternateEmergencyInformations', 'handle_updateAlternateEmergencyInformation');
add_action('wp_ajax_updateAlternateEmergencyInformations', 'handle_updateAlternateEmergencyInformation');
function handle_updateAlternateEmergencyInformation(){
 $userId = get_current_user_id();
 echo updateAlternateEmergencyInformation($_POST,$userId);
 exit();
}
add_action('wp_ajax_updateVaterinarianInformations', 'handle_updateVaterinarianInformation');
add_action('wp_ajax_updateVaterinarianInformations', 'handle_updateVaterinarianInformation');
function handle_updateVaterinarianInformation(){
 $postId = $_POST['postId'];
 echo updateVaterinarianInformation($_POST,$postId);
 exit();
}

/*Section for add or remove pet*/

add_action( 'woocommerce_account_add-pet-id-my-account_endpoint', 'my_account_endpoint_content_for_add_pet_id_my_account' );
function my_account_endpoint_content_for_add_pet_id_my_account() {
  wc_get_template("myaccount/content-add-pet-id-my-account.php", array()  );
} 

add_action( 'woocommerce_account_pet-profile_endpoint', 'my_account_endpoint_content_pet_profile' );
function my_account_endpoint_content_pet_profile() {

   if ($_GET['id']) {
       echo do_shortcode("[gravityform id=1]");            
   }else{
       echo "Please hit right URL";
   }
}

/*Add Extra fields in woocommerce my account owner Information*/

add_action( 'woocommerce_save_account_details', 'my_save_extra_profile_fields' );


/*Add extra field in user profile*/
add_action( 'show_user_profile', 'my_show_extra_profile_fields' );
add_action( 'edit_user_profile', 'my_show_extra_profile_fields' );

function my_show_extra_profile_fields( $user ) { 

   $country = esc_attr( get_the_author_meta( 'primary_country', $user->ID ) );
   $alert = esc_attr( get_the_author_meta( 'primary_argent_alert', $user->ID ) );
   $secondarycountry = esc_attr( get_the_author_meta( 'secondary_country', $user->ID ) );
   $secondaryalert = esc_attr( get_the_author_meta( 'secondary_argent_alert', $user->ID ) );
   $countries_obj = new WC_Countries();
   $countries = $countries_obj->__get('countries');
   ?>
   <!-- Business Name INPUTS -->
   <h3>Business Informations </h3>
   <table class="form-table">
     <tr>
      <th><label for="Business Name">Business Name</label></th>
      <td>
       <input type="text" name="business_name" id="business_name" value="<?php echo esc_attr( get_the_author_meta( 'business_name', $user->ID ) ); ?>" class="regular-text" />
   </td>
</tr>
</table>
<!-- SMARTTAG ID INPUTS -->
<h3>SMARTTAG ID</h3>
<table class="form-table">
 <tr>
  <th><label for="SmartTag Id">SmartTag Id</label></th>
  <td>
   <input type="text" name="smartTag_id" id="smartTag_id" value="<?php echo esc_attr( get_the_author_meta( 'smartTag_id', $user->ID ) ); ?>" class="regular-text" />
</td>
</tr>
<tr>
  <th><label for="SmartTag Id">User type</label></th>
  <td>
   <input type="text" name="custom_user_type" id="custom_user_type" value="<?php echo esc_attr( get_the_author_meta( 'custom_user_type', $user->ID ) ); ?>" class="regular-text" />
</td>
</tr>
</table>
<h3>Primary Contact Information</h3>
<table class="form-table">
 <tr>
  <th><label for="primary_country">Country</label></th>
  <td>
   <select class="country_select address-country" name="primary_country" id="primary_country">
    <option>Select a Country</option>
    <?php foreach ($countries as $key => $value): 
     if ($country == $key) {
         echo '<option value="'.$key.'" selected>'.$value.'</option>';
     }else{
         echo '<option value="'.$key.'">'.$value.'</option>';
     }
     ?>
 <?php endforeach; ?>
</select>
</td>
</tr>
<tr>
  <th><label for="primary_address_line1">Address Line 1</label></th>
  <td>
   <input type="text" name="primary_address_line1" id="primary_address_line1" value="<?php echo esc_attr( get_the_author_meta( 'primary_address_line1', $user->ID ) ); ?>" class="regular-text" />
</td>
</tr>
<tr>
  <th><label for="primary_address_line2">Address Line 2</label></th>
  <td>
   <input type="text" name="primary_address_line2" id="primary_address_line2" value="<?php echo esc_attr( get_the_author_meta( 'primary_address_line2', $user->ID ) ); ?>" class="regular-text" />
</td>
</tr>
<tr>
  <th><label for="primary_city">City</label></th>
  <td>
   <input type="text" name="primary_city" id="primary_city" value="<?php echo esc_attr( get_the_author_meta( 'primary_city', $user->ID ) ); ?>" class="regular-text" />
</td>
</tr>
<tr>
  <th><label for="primary_state">State</label></th>
  <td>
   <input type="text" name="primary_state" id="primary_state" value="<?php echo esc_attr( get_the_author_meta( 'primary_state', $user->ID ) ); ?>" class="regular-text" />
</td>
</tr>
<tr>
  <th><label for="primary_postcode">Postcode / ZIP</label></th>
  <td>
   <input type="text" name="primary_postcode" id="primary_postcode" value="<?php echo esc_attr( get_the_author_meta( 'primary_postcode', $user->ID ) ); ?>" class="regular-text" />
</td>
</tr>
<tr>
  <th><label for="primary_home_number">Home Number</label></th>
  <td>
   <input type="text" name="primary_home_number" id="primary_home_number" value="<?php echo esc_attr( get_the_author_meta( 'primary_home_number', $user->ID ) ); ?>" class="regular-text phone-number" placeholder="1(555) 123-1234" />
   <input type="hidden" name="primary_phone_country_code" id="primary_home_number-code" value="<?php echo esc_attr( get_the_author_meta( 'primary_phone_country_code', $user->ID ) ); ?>" class="regular-text" />
</td>
</tr>
<tr>
  <th><label for="primary_cell_number">Cell Number</label></th>
  <td>
   <input type="text" name="primary_cell_number" id="primary_cell_number" value="<?php echo esc_attr( get_the_author_meta( 'primary_cell_number', $user->ID ) ); ?>" class="regular-text phone-number" placeholder="1(555) 123-1234" />
   <input type="hidden" name="primary_cell_country_code" id="primary_cell_number-code" value="<?php echo esc_attr( get_the_author_meta( 'primary_cell_country_code', $user->ID ) ); ?>" class="regular-text" />
</td>
</tr>
<tr>
  <th><label for="primary_fax_number">Fax Number</label></th>
  <td>
   <input type="text" name="primary_fax_number" id="primary_fax_number" value="<?php echo esc_attr( get_the_author_meta( 'primary_fax_number', $user->ID ) ); ?>" class="regular-text" />
</td>
</tr>
<tr>
  <th><label for="primary_fax_number">Security Question1</label></th>
  <td>
   <input type="text" name="sequrity_qus1" id="sequrity_qus1" value="<?php echo esc_attr( get_the_author_meta( 'sequrity_qus1', $user->ID ) ); ?>" class="regular-text" />
</td>
</tr>
<tr>
  <th><label for="primary_fax_number">Security Answer1</label></th>
  <td>
   <input type="text" name="sequrity_ans1" id="sequrity_ans1" value="<?php echo esc_attr( get_the_author_meta( 'sequrity_ans1', $user->ID ) ); ?>" class="regular-text" />
</td>
</tr>
<tr>
  <th><label for="primary_fax_number">Security Question2</label></th>
  <td>
   <input type="text" name="sequrity_ans2" id="sequrity_ans2" value="<?php echo esc_attr( get_the_author_meta( 'sequrity_qus2', $user->ID ) ); ?>" class="regular-text" />
</td>
</tr>
<tr>
  <th><label for="primary_fax_number">Security Answer2</label></th>
  <td>
   <input type="text" name="sequrity_ans2" id="sequrity_ans2" value="<?php echo esc_attr( get_the_author_meta( 'sequrity_ans2', $user->ID ) ); ?>" class="regular-text" />
</td>
</tr>
<tr>
  <th><label for="r">Organization Name</label></th>
  <td>
   <input type="text" name="Organization_name" id="Organization_name" value="<?php echo esc_attr( get_the_author_meta( 'Organization_name', $user->ID ) ); ?>" class="regular-text" />
</td>
</tr>
<tr>
  <th><label for="primary_fax_number">Organization Email</label></th>
  <td>
   <input type="text" name="Organization_email" id="Organization_email" value="<?php echo esc_attr( get_the_author_meta( 'Organization_email', $user->ID ) ); ?>" class="regular-text" />
</td>
</tr>
<tr>
  <th><label for="primary_argent_alert">Recieve Urgent Alert?</label></th>
  <td>
   <label>
       <input type="radio" name="primary_argent_alert" class="regular-text primary_argent_alert" value="yes" <?php if ($alert == 'yes') { echo "checked"; } ?>/>Yes
   </label>
   <label>
       <input type="radio" name="primary_argent_alert" class="regular-text primary_argent_alert" value="no" <?php if ($alert == 'no') { echo "checked"; } ?> />No 
   </label>   
</td>
</tr>
</table>
<h3>Secondary Contact Information</h3>
<table class="form-table">
 <tr>
  <th><label for="secondary_first_name">First Name</label></th>
  <td>
   <input type="text" name="secondary_first_name" id="secondary_first_name" value="<?php echo esc_attr( get_the_author_meta( 'secondary_first_name', $user->ID ) ); ?>" class="regular-text" />
</td>
</tr>
<tr>
  <th><label for="secondary_last_name">Last Name</label></th>
  <td>
   <input type="text" name="secondary_last_name" id="secondary_last_name" value="<?php echo esc_attr( get_the_author_meta( 'secondary_last_name', $user->ID ) ); ?>" class="regular-text" />
</td>
</tr>
<tr>
  <th><label for="secondary_email">Email</label></th>
  <td>
   <input type="email" name="secondary_email" id="secondary_email" class="email" value="<?php echo esc_attr( get_the_author_meta( 'secondary_email', $user->ID ) ); ?>" class="regular-text" />
</td>
</tr>
<tr>
  <th><label for="secondary_country">Country</label></th>
  <td>
   <select class="country_select address-country" name="secondary_country" id="secondary_country">
    <option>Select a Country</option>
    <?php foreach ($countries as $key => $value): 
     if ($secondarycountry == $key) {
         echo '<option value="'.$key.'" selected>'.$value.'</option>';
     }else{
         echo '<option value="'.$key.'">'.$value.'</option>';
     }
     ?>
 <?php endforeach; ?>
</select>
</td>
</tr>
<tr>
  <th><label for="secondary_address_line1">Address Line 1</label></th>
  <td>
   <input type="text" name="secondary_address_line1" id="secondary_address_line1" value="<?php echo esc_attr( get_the_author_meta( 'secondary_address_line1', $user->ID ) ); ?>" class="regular-text" />
</td>
</tr>
<tr>
  <th><label for="secondary_address_line2">Address Line 2</label></th>
  <td>
   <input type="text" name="secondary_address_line2" id="secondary_address_line2" value="<?php echo esc_attr( get_the_author_meta( 'secondary_address_line2', $user->ID ) ); ?>" class="regular-text" />
</td>
</tr>
<tr>
  <th><label for="secondary_city">City</label></th>
  <td>
   <input type="text" name="secondary_city" id="secondary_city" value="<?php echo esc_attr( get_the_author_meta( 'secondary_city', $user->ID ) ); ?>" class="regular-text" />
</td>
</tr>
<tr>
  <th><label for="secondary_state">State</label></th>
  <td>
   <input type="text" name="secondary_state" id="secondary_state" value="<?php echo esc_attr( get_the_author_meta( 'secondary_state', $user->ID ) ); ?>" class="regular-text" />
</td>
</tr>
<tr>
  <th><label for="secondary_postcode">Postcode / ZIP</label></th>
  <td>
   <input type="text" name="secondary_postcode" id="secondary_postcode" value="<?php echo esc_attr( get_the_author_meta( 'secondary_postcode', $user->ID ) ); ?>" class="regular-text" />
</td>
</tr>
<tr>
  <th><label for="secondary_home_number">Home Number</label></th>
  <td>
   <input type="text" name="secondary_home_number" id="secondary_home_number" value="<?php echo esc_attr( get_the_author_meta( 'secondary_home_number', $user->ID ) ); ?>" class="regular-text phone-number" />
   <input type="hidden" id="secondary_home_number-code" name="secondary_phone_country_code" value="<?php echo esc_attr( get_the_author_meta( 'secondary_phone_country_code', $user->ID ) ); ?>" class="regular-text" />
</td>
</tr>
<tr>
  <th><label for="secondary_cell_number">Cell Number</label></th>
  <td>
   <input type="text" name="secondary_cell_number" id="secondary_cell_number" value="<?php echo esc_attr( get_the_author_meta( 'secondary_cell_number', $user->ID ) ); ?>" class="regular-text phone-number" />
   <input type="hidden" name="secondary_cell_country_code" id="secondary_cell_number-code" value="<?php echo esc_attr( get_the_author_meta( 'secondary_cell_country_code', $user->ID ) ); ?>" class="regular-text " />
</td>
</tr>
<tr>
  <th><label for="secondary_fax_number">Fax Number</label></th>
  <td>
   <input type="text" name="secondary_fax_number" id="secondary_fax_number" value="<?php echo esc_attr( get_the_author_meta( 'secondary_fax_number', $user->ID ) ); ?>" class="regular-text" />
</td>
</tr>
<tr>
  <th><label for="secondary_argent_alert">Recieve Urgent Alert?</label></th>
  <td>
   <label>
       <input type="radio" name="secondary_argent_alert" class="regular-text secondary_argent_alert" value="yes" <?php if ($secondaryalert == 'yes') { echo "checked"; } ?>/>Yes
   </label>
   <label>
       <input type="radio" name="secondary_argent_alert" class="regular-text secondary_argent_alert" value="no" <?php if ($secondaryalert == 'no') { echo "checked"; } ?> />No 
   </label>   
</td>
</tr>
</table>
<script type="text/javascript">
  jQuery(document).ready(function(){
    $(".phone-number").each(function(i, input){
      var inputId = $(input).attr("id");
      var inputVal = $("#"+inputId+"-code").val();
      console.log("Gaurav", inputVal);
      var init = window.intlTelInput(input,{
        separateDialCode: true,
      });

      if(inputVal){
        init.setCountry(inputVal);
      }else{
        init.setCountry("us");
        $("#"+inputId+"-code").val("us");
      }

      input.addEventListener("countrychange", function() {
        var countryCode = init.getSelectedCountryData();
        var inputId = $(input).attr("id");
        console.log(countryCode);
        $("#"+inputId+"-code").val(countryCode.iso2);
      });
    })
  })
</script>
<?php }
add_action( 'personal_options_update', 'my_save_extra_profile_fields' );
add_action( 'edit_user_profile_update', 'my_save_extra_profile_fields' );
/*update and save extara profile fields*/
function my_save_extra_profile_fields( $user_id ) {
    if ( !current_user_can( 'edit_user', $user_id ) )
        return false;
    update_user_meta( $user_id, 'primary_country', $_POST['primary_country'] );
    update_user_meta( $user_id, 'primary_address_line1', $_POST['primary_address_line1'] );
    update_user_meta( $user_id, 'primary_address_line2', $_POST['primary_address_line2'] );
    update_user_meta( $user_id, 'primary_city', $_POST['primary_city'] );
    update_user_meta( $user_id, 'primary_state', $_POST['primary_state'] );
    update_user_meta( $user_id, 'primary_postcode', $_POST['primary_postcode'] );
    update_user_meta( $user_id, 'primary_home_number', $_POST['primary_home_number'] );
    update_user_meta( $user_id, 'primary_phone_country_code', $_POST['primary_phone_country_code'] );
    update_user_meta( $user_id, 'secondary_phone_country_code', $_POST['secondary_phone_country_code'] );
    update_user_meta( $user_id, 'primary_cell_number', $_POST['primary_cell_number'] );
    update_user_meta( $user_id, 'primary_cell_country_code', $_POST['primary_cell_country_code'] );
    update_user_meta( $user_id, 'secondary_cell_country_code', $_POST['secondary_cell_country_code'] );
    update_user_meta( $user_id, 'primary_fax_number', $_POST['primary_fax_number'] );
    update_user_meta( $user_id, 'primary_argent_alert', $_POST['primary_argent_alert'] );
    update_user_meta( $user_id, 'secondary_first_name', $_POST['secondary_first_name'] );
    update_user_meta( $user_id, 'secondary_last_name', $_POST['secondary_last_name'] );
    update_user_meta( $user_id, 'secondary_email', $_POST['secondary_email'] );
    update_user_meta( $user_id, 'secondary_country', $_POST['secondary_country'] );
    update_user_meta( $user_id, 'secondary_address_line1', $_POST['secondary_address_line1'] );
    update_user_meta( $user_id, 'primary_address_line2', $_POST['primary_address_line2'] );
    update_user_meta( $user_id, 'secondary_city', $_POST['secondary_city'] );
    update_user_meta( $user_id, 'secondary_state', $_POST['secondary_state'] );
    update_user_meta( $user_id, 'secondary_postcode', $_POST['secondary_postcode'] );
    update_user_meta( $user_id, 'secondary_home_number', $_POST['secondary_home_number'] );
    update_user_meta( $user_id, 'secondary_cell_number', $_POST['secondary_cell_number'] );
    update_user_meta( $user_id, 'secondary_fax_number', $_POST['secondary_fax_number'] );
    update_user_meta( $user_id, 'secondary_argent_alert', $_POST['secondary_argent_alert'] );
// extra
    update_user_meta( $user_id, 'vet_first_name', $_POST['vet_first_name'] );
    update_user_meta( $user_id, 'vet_last_name', $_POST['vet_last_name'] );
    update_user_meta( $user_id, 'vet_email', $_POST['vet_email'] );
    update_user_meta( $user_id, 'vet_country', $_POST['vet_country'] );
    update_user_meta( $user_id, 'smartTag_id', $_POST['smartTag_id'] );
    update_user_meta( $user_id, 'business_name', $_POST['business_name'] );
    update_user_meta( $user_id, 'custom_user_type', $_POST['custom_user_type'] );
// update_user_meta( $user_id, 'vet_first_name', $_POST['vet_first_name'] );
// update_user_meta( $user_id, 'vet_last_name', $_POST['vet_last_name'] );
// update_user_meta( $user_id, 'vet_email', $_POST['vet_email'] );
// update_user_meta( $user_id, 'vet_country', $_POST['vet_country'] );
// update_user_meta( $user_id, 'vet_address_line1', $_POST['vet_address_line1'] );
// update_user_meta( $user_id, 'vet_address_line2', $_POST['vet_address_line2'] );
// update_user_meta( $user_id, 'vet_city', $_POST['vet_city'] );
// update_user_meta( $user_id, 'vet_state', $_POST['vet_state'] );
// update_user_meta( $user_id, 'vet_postcode', $_POST['vet_postcode'] );
// update_user_meta( $user_id, 'vet_home_number', $_POST['vet_home_number'] );
// update_user_meta( $user_id, 'vet_cell_number', $_POST['vet_cell_number'] );
}
function updateEmailPassword($post){
    wc_nocache_headers();
    $user_id = get_current_user_id();
    if ( $user_id <= 0 ) {
        return;
    }
    $current_user       = get_user_by( 'id', $user_id );
    $current_email      = $current_user->user_email;
    $account_email      = ! empty( $post['account_email'] ) ? wc_clean( $post['account_email'] )          : '';
    $pass_cur           = ! empty( $post['password_current'] ) ? $post['password_current']                : '';
    $pass1              = ! empty( $post['password_1'] ) ? $post['password_1']                            : '';
    $pass2              = ! empty( $post['password_2'] ) ? $post['password_2']                            : '';
    $save_pass          = true;
    $save_email         = true;
    $error              = '';
    $user               = new stdClass();
    $user->ID           = $user_id;
    if ( ! empty( $pass_cur ) && ! wp_check_password( $pass_cur, $current_user->user_pass, $current_user->ID ) ) {
        $error      = 'Your current password is incorrect.';
        $save_pass  = false;
        $save_email = false;
    } elseif ( ! empty( $pass1 ) && empty( $pass_cur ) ) {
        $error      = 'Please enter your current password.';
        $save_pass  = false;
    } elseif ( ! empty( $pass1 ) && empty( $pass2 ) ) {
        $error      = 'Please re-enter your password.';
        $save_pass  = false;
    } elseif ( ( ! empty( $pass1 ) || ! empty( $pass2 ) ) && $pass1 !== $pass2 ) {
        $error      = 'New passwords do not match.';
        $save_pass  = false;
    } elseif (! empty( sanitize_email( $account_email ) ) && ! wp_check_password( $pass_cur, $current_user->user_pass, $current_user->ID ) && $current_email != $account_email ) {
        $error      = 'Your current password is incorrect.';
        $save_email = false;
    } elseif ( ! empty( $account_email ) && $current_email == $account_email ) {
        $save_email = false;
    } elseif ( ! empty( $account_email ) && empty( $pass_cur ) ) {
        $error      = 'Please enter your current password.';
        $save_email = false;
    } elseif(! is_email( sanitize_email( $account_email ) ) && wp_check_password( $pass_cur, $current_user->user_pass, $current_user->ID )) {
        $error      = 'Please provide a valid email address.';
        $save_email = false;
    } elseif( email_exists( sanitize_email( $account_email ) ) && sanitize_email( $account_email ) !== $current_user->user_email ){
        $error      = 'This email address is already registered.';
        $save_email = false;
    } elseif ( ! empty( $pass1 ) && ! wp_check_password( $pass_cur, $current_user->user_pass, $current_user->ID ) ) {
        $error      = 'Your current password is incorrect.';
        $save_pass  = false;
    }
    if ( $pass1 && $save_pass ) {
        $user->user_pass = $pass1;
    }
    if ($save_email) {
        $user->user_email = $account_email;
    }
    if ( ! empty( $error ) ) {
        $message['success'] = 0;
        $message['message'] = $error;
        return json_encode($message);
    }
    if ( empty( $error ) ) {
        wp_update_user( $user );
// Update customer object to keep data in sync.
        $customer = new WC_Customer( $user->ID );
        if ( $customer ) {
// Keep billing data in sync if data changed.
            if ( is_email( $user->user_email ) && $current_email !== $user->user_email ) {
                $customer->set_billing_email( $user->user_email );
            }
            if ( $current_first_name !== $user->first_name ) {
                $customer->set_billing_first_name( $user->first_name );
            }
            if ( $current_last_name !== $user->last_name ) {
                $customer->set_billing_last_name( $user->last_name );
            }
            $customer->save();
        }
        $message['success'] = 1;
        $message['message'] = 'Account details changed successfully.';
        return json_encode($message);
    }
}
function updatePrimaryInfo($post){
    wc_nocache_headers();
    $user_id = get_current_user_id();
    if ( $user_id <= 0 ) {
        return;
    }
    $current_user       = get_user_by( 'id', $user_id );
    $current_first_name = $current_user->first_name;
    $current_last_name  = $current_user->last_name;
    $account_first_name = ! empty( $post['account_first_name'] ) ? wc_clean( $post['account_first_name'] ): '';
    $account_last_name  = ! empty( $post['account_last_name'] ) ? wc_clean( $post['account_last_name'] )  : '';
    $error              = '';
    $user               = new stdClass();
    $user->ID           = $user_id;
    $user->first_name   = $account_first_name;
    $user->last_name    = $account_last_name;
// Prevent emails being displayed, or leave alone.
    $user->display_name = is_email( $current_user->display_name ) ? $user->first_name : $current_user->display_name;
// Handle required fields.
    $required_fields = apply_filters( 'woocommerce_save_account_details_required_fields', array(
        'account_first_name' => __( 'First name', 'woocommerce' ),
        'account_last_name'  => __( 'Last name', 'woocommerce' ),
    ) );
    foreach ( $required_fields as $field_key => $field_name ) {
        if ( empty( $post[ $field_key ] ) ) {
            $error = sprintf( __( '%s is a required field.', 'woocommerce' ), '<strong>' . esc_html( $field_name ) . '</strong>' );
        }
    }
    if ( ! empty( $error ) ) {
        $message['success'] = 0;
        $message['message'] = $error;
        return json_encode($message);
    }
    if ( empty( $error ) ) {
        wp_update_user( $user );
// Update customer object to keep data in sync.
        $customer = new WC_Customer( $user->ID );
        if ( $customer ) {
// Keep billing data in sync if data changed.
            if ( is_email( $user->user_email ) && $current_email !== $user->user_email ) {
                $customer->set_billing_email( $user->user_email );
            }
            if ( $current_first_name !== $user->first_name ) {
                $customer->set_billing_first_name( $user->first_name );
            }
            if ( $current_last_name !== $user->last_name ) {
                $customer->set_billing_last_name( $user->last_name );
            }
            $customer->save();
        }
        update_user_meta( $user_id, 'primary_country', $post['primary_country'] );
        update_user_meta( $user_id, 'primary_address_line1', $post['primary_address_line1'] );
        update_user_meta( $user_id, 'primary_address_line2', $post['primary_address_line2'] );
        update_user_meta( $user_id, 'primary_city', $post['primary_city'] );
        update_user_meta( $user_id, 'primary_state', $post['primary_state'] );
        update_user_meta( $user_id, 'primary_postcode', $post['primary_postcode'] );
        update_user_meta( $user_id, 'primary_home_number', $post['primary_home_number'] );
        update_user_meta( $user_id, 'primary_phone_country_code', $post['primary_phone_country_code'] );
        update_user_meta( $user_id, 'primary_cell_number', $post['primary_cell_number'] );
        update_user_meta( $user_id, 'primary_cell_country_code', $post['primary_cell_country_code'] );
        update_user_meta( $user_id, 'primary_fax_number', $post['primary_fax_number'] );
        if (isset($post['primary_argent_alert'])) {
            update_user_meta( $user_id, 'primary_argent_alert', $post['primary_argent_alert'] );
        }
        if (isset($post['shelter_group_name'])) {
            update_user_meta( $user_id, 'shelter_group_name', $post['shelter_group_name'] );
        }
        $message['success'] = 1;
        $message['message'] = 'Primary Contact Information updated successfully.';
        return json_encode($message);
    }
}
function updateSecondaryInfo($post){
    wc_nocache_headers();
    $user_id = get_current_user_id();
    if ( $user_id <= 0 ) {
        return;
    }
    $current_user       = get_user_by( 'id', $user_id );
    $current_first_name = get_the_author_meta( 'secondary_first_name', $user_id );
    $current_last_name  = get_the_author_meta( 'secondary_last_name', $user_id );
    $current_email      = get_the_author_meta( 'secondary_email', $user_id );
    $account_first_name = ! empty( $post['secondary_first_name'] ) ? wc_clean( $post['secondary_first_name'] ): '';
    $account_last_name  = ! empty( $post['secondary_last_name'] ) ? wc_clean( $post['secondary_last_name'] )  : '';
    $current_email      = ! empty( $post['secondary_email'] ) ? wc_clean( $post['secondary_email'] )  : '';
    $error              = '';
    $user               = new stdClass();
    $user->ID           = $user_id;
// Handle required fields.
    $required_fields = apply_filters( 'woocommerce_save_account_details_required_fields', array(
        'secondary_first_name' => __( 'Secondary First name', 'woocommerce' ),
        'secondary_last_name'  => __( 'Secondary Last name', 'woocommerce' ),
        'secondary_email'      => __( 'Secondary Email address', 'woocommerce' ),
    ) );
    foreach ( $required_fields as $field_key => $field_name ) {
        if ( empty( $post[ $field_key ] ) ) {
            $error = sprintf( __( '%s is a required field.', 'woocommerce' ), '<strong>' . esc_html( $field_name ) . '</strong>' );
        }
    }
    if ( ! empty( $error ) ) {
        $message['success'] = 0;
        $message['message'] = $error;
        return json_encode($message);
    }
    if ( empty( $error ) ) {
        update_user_meta( $user_id, 'secondary_first_name', $post['secondary_first_name'] );
        update_user_meta( $user_id, 'secondary_last_name', $post['secondary_last_name'] );
        update_user_meta( $user_id, 'secondary_email', $post['secondary_email'] );
        update_user_meta( $user_id, 'secondary_country', $post['secondary_country'] );
        update_user_meta( $user_id, 'secondary_address_line1', $post['secondary_address_line1'] );
        update_user_meta( $user_id, 'secondary_address_line2', $post['secondary_address_line2'] );
        update_user_meta( $user_id, 'secondary_city', $post['secondary_city'] );
        update_user_meta( $user_id, 'secondary_state', $post['secondary_state'] );
        update_user_meta( $user_id, 'secondary_postcode', $post['secondary_postcode'] );
        update_user_meta( $user_id, 'secondary_home_number', $post['secondary_home_number'] );
        update_user_meta( $user_id, 'secondary_phone_country_code', $post['secondary_home_number_code'] );
        update_user_meta( $user_id, 'secondary_cell_number', $post['secondary_cell_number'] );
        update_user_meta( $user_id, 'secondary_cell_country_code', $post['secondary_cell_number_code'] );
        update_user_meta( $user_id, 'secondary_fax_number', $post['secondary_fax_number'] );
        update_user_meta( $user_id, 'secondary_argent_alert', $post['secondary_argent_alert'] );
        $message['success'] = 1;
        $message['message'] = 'Secondary Contact Information updated successfully.';
        return json_encode($message);
    }
}
add_action('wp_ajax_save_email_password', 'handle_save_email_password');
add_action('wp_ajax_nopriv_save_email_password', 'handle_save_email_password');
function handle_save_email_password(){
    if ( 'POST' !== strtoupper( $_SERVER['REQUEST_METHOD'] ) ) {
        return;
    }
    echo updateEmailPassword($_POST);
    exit();
}
add_action('wp_ajax_save_primary_info', 'handle_save_primary_info');
add_action('wp_ajax_nopriv_save_primary_info', 'handle_save_primary_info');
function handle_save_primary_info(){
    if ( 'POST' !== strtoupper( $_SERVER['REQUEST_METHOD'] ) ) {
        return;
    }
    echo updatePrimaryInfo($_POST);
    exit();
}
add_action('wp_ajax_save_secondary_info', 'handle_save_secondary_info');
add_action('wp_ajax_nopriv_save_secondary_info', 'handle_save_secondary_info');
function handle_save_secondary_info(){
    if ( 'POST' !== strtoupper( $_SERVER['REQUEST_METHOD'] ) ) {
        return;
    }
    echo updateSecondaryInfo($_POST);
    exit();
}
add_action('wp_ajax_save_custom_woocommerce_owner_form', 'handle_save_custom_woocommerce_owner_form');
add_action('wp_ajax_nopriv_save_custom_woocommerce_owner_form', 'handle_save_custom_woocommerce_owner_form');
function handle_save_custom_woocommerce_owner_form(){
    if ( 'POST' !== strtoupper( $_SERVER['REQUEST_METHOD'] ) ) {
        return;
    }
    $user_id = get_current_user_id();
    if ( $user_id <= 0 ) {
        return;
    }
    $current_user       = get_user_by( 'id', $user_id );
    $current_email      = $current_user->user_email;
    $current_first_name = $current_user->first_name;
    $current_last_name  = $current_user->last_name;
    $secondary_first_name = get_the_author_meta( 'secondary_first_name', $user_id );
    $secondary_last_name  = get_the_author_meta( 'secondary_last_name', $user_id );
    $secondary_email      = get_the_author_meta( 'secondary_email', $user_id );
    $account_email      = ! empty( $_POST['account_email'] ) ? wc_clean( $_POST['account_email'] ): '';
    $pass_cur           = ! empty( $_POST['password_current'] ) ? $_POST['password_current']: '';
    $pass1              = ! empty( $_POST['password_1'] ) ? $_POST['password_1']                            : '';
    $pass2              = ! empty( $_POST['password_2'] ) ? $_POST['password_2']: '';
    $account_first_name = ! empty( $post['account_first_name'] ) ? wc_clean( $post['account_first_name'] ): '';
    $account_last_name  = ! empty( $post['account_last_name'] ) ? wc_clean( $post['account_last_name'] )  : '';
    $secondary_first_name = ! empty( $post['secondary_first_name'] ) ? wc_clean( $post['secondary_first_name'] ): '';
    $secondary_last_name  = ! empty( $post['secondary_last_name'] ) ? wc_clean( $post['secondary_last_name'] )  : '';
    $secondary_email      = ! empty( $post['secondary_email'] ) ? wc_clean( $post['secondary_email'] ): '';
    $save_pass          = true;
    $save_email         = true;
    $error              = '';
    $user               = new stdClass();
    $user->ID           = $user_id;
    if ( ! empty( $pass_cur ) && ! wp_check_password( $pass_cur, $current_user->user_pass, $current_user->ID ) ) {
        $error      = 'Your current password is incorrect.';
        $save_pass  = false;
        $save_email = false;
    } elseif ( ! empty( $pass1 ) && empty( $pass_cur ) ) {
        $error      = 'Please enter your current password.';
        $save_pass  = false;
    } elseif ( ! empty( $pass1 ) && empty( $pass2 ) ) {
        $error      = 'Please re-enter your password.';
        $save_pass  = false;
    } elseif ( ( ! empty( $pass1 ) || ! empty( $pass2 ) ) && $pass1 !== $pass2 ) {
        $error      = 'New passwords do not match.';
        $save_pass  = false;
    } elseif (! empty( sanitize_email( $account_email ) ) && ! wp_check_password( $pass_cur, $current_user->user_pass, $current_user->ID ) && $current_email != $account_email ) {
        $error      = 'Your current password is incorrect.';
        $save_email = false;
    } elseif ( ! empty( $account_email ) && $current_email == $account_email ) {
        $save_email = false;
    } elseif ( ! empty( $account_email ) && empty( $pass_cur ) ) {
        $error      = 'Please enter your current password.';
        $save_email = false;
    } elseif(! is_email( sanitize_email( $account_email ) )) {
        $error      = 'Please provide a valid email address.';
        $save_email = false;
    } elseif( email_exists( sanitize_email( $account_email ) ) && sanitize_email( $account_email ) !== $current_user->user_email ){
        $error      = 'This email address is already registered.';
        $save_email = false;
    } elseif ( ! empty( $pass1 ) && ! wp_check_password( $pass_cur, $current_user->user_pass, $current_user->ID ) ) {
        $error      = 'Your current password is incorrect.';
        $save_pass  = false;
    }
// Handle required fields.
    $required_fields = apply_filters( 'woocommerce_save_account_details_required_fields', array(
        'account_first_name' => __( 'First name', 'woocommerce' ),
        'account_last_name'  => __( 'Last name', 'woocommerce' ),
        'secondary_first_name' => __( 'Secondary First name', 'woocommerce' ),
        'secondary_last_name'  => __( 'Secondary Last name', 'woocommerce' ),
        'secondary_email'      => __( 'Secondary Email address', 'woocommerce' ),
    ) );
    foreach ( $required_fields as $field_key => $field_name ) {
        if ( empty( $_POST[ $field_key ] ) ) {
            $error = sprintf( __( '%s is a required field.', 'woocommerce' ), '<strong>' . esc_html( $field_name ) . '</strong>' );
        }
    }
    if ( ! empty( $error ) ) {
        $message['success'] = 0;
        $message['message'] = $error;
        echo json_encode($message);
    }
    if (empty( $error )) {
        updateEmailPassword($_POST);
        updatePrimaryInfo($_POST);
        echo updateSecondaryInfo($_POST);
    }
    exit();
}
add_action('wp_ajax_check_email', 'handle_check_email');
add_action('wp_ajax_nopriv_check_email', 'handle_check_email');
function handle_check_email(){
    print_r($_POST);
    $email              = $_POST['primary_email'];
    $error['success']   = true;
    if(! is_email( sanitize_email( $email ) )) {
        $error['msg']       = 'Please provide a valid email address.';
        $error['success']   = false;
    } elseif( email_exists( sanitize_email( $email ) ) && sanitize_email( $email ) !== $current_user->user_email ){
        $error['msg']       = 'This email address is already registered.';
        $error['success']   = false;
    }
    echo json_encode($error);
    exit();
}
function iconic_find_matching_product_variation( $product, $attributes ) {
    foreach( $attributes as $key => $value ) {
        if( strpos( $key, 'attribute_' ) === 0 ) {
            continue;
        }
        unset( $attributes[ $key ] );
        $attributes[ sprintf( 'attribute_%s', $key ) ] = $value;
    }
    if( class_exists('WC_Data_Store') ) {
        $data_store = WC_Data_Store::load( 'product' );
        return $data_store->find_matching_product_variation( $product, $attributes );
    } else {
        return $product->get_matching_variation( $attributes );
    }
}
function checkSerialNumber($id){
    $args=array(
        'post_type' => 'pet_profile',
        'post_status' => 'publish',
        'meta_query'=>array(
            'relation' => 'OR',
            array(
                'key' => 'smarttag_id_number',
                'value' => $id,
            ),
            array(
                'key' => 'microchip_id_number',
                'value' => $id,
            ),
        )
    );
    $query = new WP_Query($args);
    if ($query->have_posts()) {
        return 'false';
    }
    global $wpdb;
/*$results = $wpdb->get_results("SELECT MAX(wp_woocommerce_order_items.`order_id`) as order_id FROM wp_woocommerce_order_items JOIN wp_woocommerce_order_itemmeta ON wp_woocommerce_order_items.order_item_id = wp_woocommerce_order_itemmeta.order_item_id where wp_woocommerce_order_itemmeta.order_item_id = (SELECT MAX(order_item_id) FROM wp_woocommerce_order_itemmeta where meta_value Like '%".$id."%' and meta_key = 'Serial Number')", OBJECT);
$data = json_encode($results);
$data = json_decode($data);
return $data;*/
$results = $wpdb->get_results("SELECT * FROM wp_woocommerce_order_itemmeta where meta_value Like '%".$id."%' and meta_key = 'Serial Number'", OBJECT);
$data = json_encode($results);
$datas = json_decode($data);
$count = count($datas);
$check = 0;
if ($count > 0) {
    foreach ($datas as $data) {
        $values = explode(',', $data->meta_value);
        foreach ($values as $value) {
            if ($value == $id) {
                $metaIds[] = $data->order_item_id;
                $check     = 1;
            }
        }
    }
// return $check;
    if ($check) {
        $metaId = 0;
        foreach ($metaIds as $value) {
            if ($value > $b) {
                $metaId = $value;
            }
        }
// return $metaId;
        if ($metaId != 0) {
            $results = $wpdb->get_results("SELECT MAX(wp_woocommerce_order_items.`order_id`) as order_id FROM wp_woocommerce_order_items JOIN wp_woocommerce_order_itemmeta ON wp_woocommerce_order_items.order_item_id = wp_woocommerce_order_itemmeta.order_item_id where wp_woocommerce_order_itemmeta.order_item_id ='".$metaId."'", OBJECT);
            $data = json_encode($results);
            $data = json_decode($data);
            return $data;
        }else{
            return 0;
        }
    }else{
        return 0;
    }                
}else{
    return 0;
}
}
add_action("wp_ajax_checkSerialNumberValid", "checkSerialNumberValidForRegisterMicrochipAndSmartTagID");
add_action("wp_ajax_nopriv_checkSerialNumberValid", "checkSerialNumberValidForRegisterMicrochipAndSmartTagID");
function checkSerialNumberValidForRegisterMicrochipAndSmartTagID(){
    $user = wp_get_current_user();
    foreach ($_POST['data'] as $microchip) {
        $id = $microchip['microchip_id_number'];
        $data = checkSerialNumber($id);
        if ($data === 'false'){
            $result =array('result'=>'This number already register') ;
// echo json_encode(array('result'=>0, 'msg'=>'This number already register'));
        }
        elseif ($data) {
            $order      = wc_get_order( $data[0]->order_id );
            $userId     = $order->get_user_id();
            $userMeta   = get_userdata($userId);
            $userRole   = $userMeta->roles;
            if (in_array("pet_professional", $userRole)){
                if($userMeta->data->ID == $user->data->ID){
                    $result[] = array('result'=>true);
// echo json_encode(array('result'=>true));
                }else{
                    $result[] = array('result'=>false);
// echo json_encode(array('result'=>false));
                }
            }else{
                $result[] = array('result'=>'Invalid Pet Professional login');
// echo json_encode(array('result'=>0, 'msg'=>'Invalid Pet Professional login'));
            }
        }else{
            $result[] = array('result'=>'Invalid Number');
// echo json_encode(array('result'=>'Invalid Number'));
        }  
    }
    echo json_encode($result);
    exit();
}
//rohit custom ajax for check microchip and smartTag id
add_action("wp_ajax_checkSmartTagMicrochipValid", "checkValidForcheckSmartTagIDValid");
add_action("wp_ajax_nopriv_checkSmartTagMicrochipValid", "checkValidForcheckSmartTagIDValid");
function checkValidForcheckSmartTagIDValid(){
    $user = wp_get_current_user();
    if (isset($_POST['smartTagID'])) {
        $id = $_POST['smartTagID'];
    }else{
        $id = $_POST['serialNumber'];
    }
    $data = checkSerialNumber($id);
    if ($data === 'false'){
        $result =array('result'=>0,'msg'=>'This number already register') ;
// echo json_encode(array('result'=>0, 'msg'=>'This number already register'));
    }
    elseif ($data) {
        $order      = wc_get_order( $data[0]->order_id );
        $userId     = $order->get_user_id();
        $userMeta   = get_userdata($userId);
        $userRole   = $userMeta->roles;  
        if (in_array("customer", $userRole) ){
            if($userMeta->data->ID == $user->data->ID){
                $result = array('result'=>true,"msg"=>"Valid ID");
// echo json_encode(array('result'=>true));
            }else{
                $result[] = array('result'=>false);
// echo json_encode(array('result'=>false));
            }
        }else{
            $result[] = array('result'=>'Invalid customer login');
// echo json_encode(array('result'=>0, 'msg'=>'Invalid Pet Professional login'));
        }
    }else{
        $result = array('result'=>false,"msg"=>"Invalid Number");
// echo json_encode(array('result'=>'Invalid Number'));
    }  
    echo json_encode($result);
    exit();
}
function registerNewPetrofessionals($post){
    global $current_user;
    if (is_user_logged_in()) {
        $createdBy = $current_user->data->user_login;
    }else{
        $createdBy = 'self';
    }
    if (isset($post['primary_home_number'])) {
        $phone      = $post['primary_home_number'];
        $email      = $post['p_email'];
        $orgName    = $post['Organization_name'];
        $userType   = $post['custom_user_type'];
        $phoneExist = phone_exists($phone);
        if ($phoneExist['success']) {
            echo "Phone number already exist.";
        }elseif(email_exists( $email )){
            echo "This Email is already used, please enter other user name";
        }else{
            $userId = wp_create_user( $email, $_POST['password'], $email );
/*$user = new WP_User($user_id);
$user->set_role('wholeseller');*/
$user               = new stdClass();
$user->ID           = $userId;
$user->first_name   = $_POST['p_fst_name'];
$user->last_name    = $_POST['p_lst_name'];
$user->role         = 'pet_professional';
wp_update_user( $user );
update_user_meta($userId,'created_by',$createdBy);
update_user_meta($userId,'Organization_name',$orgName);
update_user_meta($userId,'custom_user_type',$userType);
update_user_meta($userId,'source_system','SMARTTAG');
}
}
}
add_action("wp_ajax_downloadPdf", "downloadPdfFile");
add_action("wp_ajax_nopriv_downloadPdf", "downloadPdfFile");
// require_once "lib/dompdf/autoload.inc.php";
function downloadPdfFile(){

    $htmlContent = '<!DOCTYPE html>
    <html>
    <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Pet Poster</title>
    <style type="text/css">
    @font-face {
      font-family: "Asap";           
      src: local("Asap"), url("resources/Asap-Regular.ttf") format("truetype");
      font-weight: normal;
      font-style: normal;
    }
    .print-poster-col{
      line-height: 1.5; 
      color: #3c3c3c; 
      font-family: "Asap", sans-serif; 
      font-size: 16px; 
      border: 1px solid #679fe1; 
      padding: 30px; 
      margin-bottom: 30px;
    }
    .print-poster-col h2{
      font-size: 56px;
      font-weight: 700;
      margin: 0 0 15px 0;
      color: #dc2727;
      text-align: center;
      line-height: 0.9 !important;
      text-transform: uppercase;
    }
    </style>
    </head>
    <body>
    <div class="col-sm-8 rmb-30">
    <div class="print-poster-col">
    <div class="print-poster-inner">
    <h2>Lost Pet</h2>
    <div class="bordered-poster-wrap" style="border: 5px solid #dc2727; padding: 8px; margin-bottom: 20px;">
    <div class="bordered-poster mb-15">
    <table cellpadding="0" cellspacing="0" style="width: 100%; border-collapse: collapse; margin-bottom: 0;">
    <tr>
    <td style="width: 50%; vertical-align: top; padding: 0; border: none; font-size: 16px;">
    <p style="font-weight: 600; font-size: 28px; margin-bottom: 10px;">"'.$_POST["dogName"].'"</p>
    '.$_POST["type"].', '.$_POST["breed"].'
    <br>
    Color: '.$_POST["color"].'
    <br>
    ID Tag #: '.$_POST["serialNumber"].'
    </td>
    <td style="width: 50%; vertical-align: top; padding: 0; border: none; font-size: 16px;">
    <p style="font-weight: 600; font-size: 28px; margin-bottom: 10px; padding: 0;">REWARD <span style="color: #dc2727;">'.$_POST["reward"].'</span></p>
    <strong>Additional Info:</strong>
    <br>
    '.$_POST["extraInfo"].'
    </td>
    </tr>
    <tr>
    <td colspan="2" style="text-align: center; color: #dc2727; font-size: 16px; text-transform: uppercase; padding: 0; border: none; font-size: 14px;">
    <p style="margin-bottom: 30px; margin-top: 30px; font-size: 28px; line-height: 1.2;">
    Please call with any info:
    <br>
    212-868-2559
    </p>
    </td>
    </tr>
    <tr>
    <td colspan="2" style="text-align: center; padding: 0; border: none; font-size: 16px;">
    <p style="margin-bottom: 20px; text-align: center;">
    <img src="'.$_POST["image"].'" style="width: 300px; height: auto;  display: inline-block;" />
    </p>
    </td>
    </tr>
    </table>
    </div>
    </div>
    <div class="poster-info-table-wrap">
    <table class="poster-info-table" cellspacing="0" cellpadding="0" style="width: 100%; border-collapse: collapse; margin-bottom: 0;">
    <td style="text-align: left; color: #3c3c3c; padding: 0; border: none; font-size: 16px;">
    <img src="'.site_url().'/wp-content/themes/salient-child/images/logo-icon.png" alt="image" style="width: 70px; height: auto;" />
    </td>
    <td  style="text-align: right; color: #3c3c3c; font-size: 14px; padding: 0; border: none; font-size: 16px; font-weight: 600;">
    To Report This Pet Found , Enter ID Tag # on:
    <p style="font-size: 28px; font-weight: 600; margin: 0 0 0 0; color: #3c3c3c; line-height: 1.2;">WWW.IDTAG.COM</p>
    </td>
    </table>
    </div>
    </div>
    </div>
    </div>
    </body>
    </html>';

    $dompdf = new Dompdf();
    $dompdf->loadHtml($htmlContent);
    $dompdf->setPaper('A4');
    $dompdf->set_option('isRemoteEnabled', TRUE);
    $dompdf->render();
    $output = $dompdf->output();
    $time   = time();
    $path   = "wp-content/themes/salient-child/lost-pet-poster/".$_POST['postId'].$time.".pdf";
    $pdfroot = $_SERVER['DOCUMENT_ROOT'].$path;
    file_put_contents($pdfroot, $output ); 
    // $dompdf->stream('SmartTagg',array('Attachment'=>false));
    // output the genrated pdf
    if($_POST['isDownload']){
      $dompdf->stream('SmartTagg',array('Attachment'=>1));
    }else{
      global $printLostPoster, $woocommerce;
      $url = site_url()."/".$path;
      $woocommerce->cart->add_to_cart( $printLostPoster, 1, 0, array(), array("poster"=>$url));
    }
    exit();
}
add_action("wp_ajax_UploadProfileImage", "UploadProfileImage");
add_action("wp_ajax_nopriv_UploadProfileImage", "UploadProfileImage");
function UploadProfileImage(){
    $attach_id = 0;
    $post_id = 0;
    if ($_FILES["feature"]['error'] > 0) {
        $msg = 'File name cannot be empty';
    }elseif ($_FILES["feature"]['size'] > 2000000) {
        $msg = 'Please only select images less than 2MB in size';
    }else{
        $upload = wp_upload_bits($_FILES["feature"]["name"], null, file_get_contents($_FILES["feature"]["tmp_name"]));
        $filename = $upload['file'];
        $wp_filetype = wp_check_filetype(basename( $filename ), null );
        strtolower($wp_filetype['ext']);
        if (strtolower($wp_filetype['ext']) == 'png' || strtolower($wp_filetype['ext']) == 'jpg' || strtolower($wp_filetype['ext']) == 'jpeg') {
            $wp_upload_dir = wp_upload_dir();
            $attachment = array(
                'guid'              => $wp_upload_dir['url'] . '/' . basename( $filename ),
                'post_mime_type'    => $wp_filetype['type'],
                'post_title'        => preg_replace( '/\.[^.]+$/', '', basename( $filename ) ),
                'post_content'      => '',
                'post_status'       => 'inherit'
            );
            $attach_id = wp_insert_attachment( $attachment, $filename, $post_id );
            require_once(ABSPATH . 'wp-admin/includes/image.php');
            $attach_data = wp_generate_attachment_metadata( $attach_id, $filename );
            wp_update_attachment_metadata( $attach_id, $attach_data );
            set_post_thumbnail( $post_id, $attach_id ); 
            $msg = "Update Profile Successfully";
        }else{
            $msg = "Please upload only jpg, jpeg and png Type Image.";
        }
    }
    $userId = get_current_user_id();
    update_user_meta( $userId, 'user_image', $attach_id );
    echo json_encode(array("attachId"=>$attach_id, "msg"=>$msg));
    exit();
}
add_action("wp_ajax_changePasswordForm", "changePasswordForm");
add_action("wp_ajax_nopriv_changePasswordForm", "changePasswordForm");
function changePasswordForm(){
    echo updateEmailPassword($_POST);
    exit();
}
add_action("wp_ajax_updateGroupInfo", "updateGroupInfo");
add_action("wp_ajax_nopriv_updateGroupInfo", "updateGroupInfo");
function updateGroupInfo(){
    $userId  = get_current_user_id();
    if (isset($_POST['removeGroupInfo']) && isset($_POST['removeGroup']) && !empty($_POST['removeGroup'])) {
        $userGroupInfo = get_user_meta($userId, 'multiple_group_info', true);
        if (isset($userGroupInfo[$_POST['removeGroup']])) {
            unset($userGroupInfo[$_POST['removeGroup']]);
        }
        update_user_meta( $userId, 'multiple_group_info', $userGroupInfo );
        exit();
    }
    if (isset($_POST['group_title'])) {
        $size = count($_POST['group_title']);
        $i = 0;
        while ( $i < $size) {
            $groupInfo[$i]['group_title']           = $_POST['group_title'][$i];
            $groupInfo[$i]['group_first_name']      = $_POST['group_first_name'][$i];
            $groupInfo[$i]['group_last_name']       = $_POST['group_last_name'][$i];
            $groupInfo[$i]['group_phone_number']    = $_POST['group_phone_number'][$i];
            $groupInfo[$i]['group_email']           = $_POST['group_email'][$i];
            $i++;
        }
        update_user_meta( $userId, 'multiple_group_info', $groupInfo );
        $msg = "Group Information updated successfully.";
        echo json_encode(array("success"=>1,"message"=>$msg));
        exit();
    }
    echo json_encode(array("success"=>0));
    exit();
}
add_action("wp_ajax_updateShippingInfo", "updateShippingInfo");
add_action("wp_ajax_nopriv_updateShippingInfo", "updateShippingInfo");
function updateShippingInfo(){
    $userId  = get_current_user_id();
    if (isset($_POST['shipping_first_name'])) {
        $size = count($_POST['shipping_first_name']);
        $i = 0;
        if ($size > 1) {
            while ( $i < $size) {
                $shippingInfo[$i]['shipping_first_name']       = $_POST['shipping_first_name'][$i];
                $shippingInfo[$i]['shipping_last_name']        = $_POST['shipping_last_name'][$i];
                $shippingInfo[$i]['shipping_country']          = $_POST['shipping_country'][$i];
                $shippingInfo[$i]['shipping_address_1']    = $_POST['shipping_address_line_1'][$i];
                $shippingInfo[$i]['shipping_city']             = $_POST['shipping_city'][$i];
                $shippingInfo[$i]['shipping_address_2']    = $_POST['shipping_address_line_2'][$i];
                $shippingInfo[$i]['shipping_state']            = $_POST['shipping_state'][$i];
                $shippingInfo[$i]['shipping_postcode']         = $_POST['shipping_postcode'][$i];
                $i++;
            }
            update_user_meta( $userId, 'multiple_shipping_info', $shippingInfo );
        }else{
            update_user_meta( $userId, 'shipping_first_name', $_POST['shipping_first_name'][0] );
            update_user_meta( $userId, 'shipping_last_name', $_POST['shipping_last_name'][0] );
            update_user_meta( $userId, 'shipping_state', $_POST['shipping_state'][0] );
            update_user_meta( $userId, 'shipping_city', $_POST['shipping_city'][0] );
            update_user_meta( $userId, 'shipping_address_1', $_POST['shipping_address_line_1'][0] );
            update_user_meta( $userId, 'shipping_address_2', $_POST['shipping_address_line_2'][0] );
            update_user_meta( $userId, 'shipping_postcode', $_POST['shipping_postcode'][0] );
            update_user_meta( $userId, 'shipping_country', $_POST['shipping_country'][0] );
            update_user_meta( $userId, 'multiple_shipping_info', '' );
        }
    }
    $msg = "Shipping Addresses updated successfully.";
    echo json_encode(array("success"=>1,"message"=>$msg));
    exit();
}
/*start ajax for update alert and remove alert*/
add_action("wp_ajax_updateAlerts", "updateAlerts");
add_action("wp_ajax_nopriv_updateAlerts", "updateAlerts");
function updateAlerts(){
    $userId     = get_current_user_id();
    $alertName  = $_POST['alert_name'];
    $notInKey   = array("alert_name", "action", "pet_id");
    $date       = $_POST['alert_date'];
    $date       = DateTime::createFromFormat("F d, Y", $date);
    $date       = $date->format('Y-m-d');
    $time       = date("H:i:s", strtotime($_POST['time_of_day']));
    $dateTime   = date("Y-m-d H:i:s", strtotime($date." ".$time));
    $petId      = $_POST['pet_id'];
    foreach ($_POST as $key => $value) {
        if (!in_array($key, $notInKey)) {
            $data[$key] = $value;
        }
    }
    if ($alertName == 'heartworm_medication_alert') {
        $class   = "heartworm-alert";
        $message = "Update Heartworm Medication Alerts Successfully";
    }elseif ($alertName == 'flea_tick_medication_alert') {
        $class   = "flea-tick";
        $message = "Update Flea & Tick Medication Alerts Successfully";
    }elseif ($alertName == 'vet_appointments_alert') {
        $class   = "vet-appo";
        $message = "Update Vet Appointments Alerts Successfully";
    }elseif ($alertName == 'medication_alert') {
        $class   = "medication-alert";
        $message = "Update Medication Alerts Alerts Successfully";
    }elseif ($alertName == 'rabies_shot_alert') {
        $class   = "flea-tick";
        $message = "Update Rabies Shot Alerts Successfully";
    }elseif ($alertName == 'tag_licensing_alert') {
        $class   = "tag-licens";
        $message = "Update Tag Licensing Alerts Successfully";
    }
    if (!empty($petId)) {
        update_post_meta($petId, $alertName, $data);
        update_post_meta($petId, $alertName."_date", $dateTime);
        echo json_encode(array("success" => 1, "msg" => $message, "class" => $class));
    }
    exit();
}
add_action("wp_ajax_updateCustomAlerts", "updateCustomAlerts");
add_action("wp_ajax_nopriv_updateCustomAlerts", "updateCustomAlerts");
function updateCustomAlerts(){
// var_dump($_POST['custom_alert_number']); die();
    $petId      = $_POST['pet_id'];
    $alertName  = $_POST['custom_alert_number'];
    $notInKey   = array("action", "pet_id","custom_alert_number");
    $date       = $_POST['alert_date'];
    $date       = DateTime::createFromFormat("F d, Y", $date);
    $date       = $date->format('Y-m-d');
    $time       = date("H:i:s", strtotime($_POST['time_of_day']));
    $dateTime   = date("Y-m-d H:i:s", strtotime($date." ".$time));
    foreach ($_POST as $key => $value) {
        if (!in_array($key, $notInKey)) {
            $data[$key] = $value;
        }
    }
    update_post_meta($petId, $alertName, $data);
    update_post_meta($petId, $alertName."_date", $dateTime);
    echo json_encode(array("success" => 1, "msg" => "Update Custom Alert Successfully", "alertName" => $alertName));
    exit();
}
add_action("wp_ajax_removeCustomAlerts", "removeCustomAlerts");
add_action("wp_ajax_nopriv_removeCustomAlerts", "removeCustomAlerts");
function removeCustomAlerts(){
    $postId      = $_POST['pet_id'];
    $alertName   = $_POST['custom_alert_number'];
    $alertName   = explode("_", $alertName); 
    $alertNumber = (int)$alertName[2];
    $userId      = get_current_user_id();
    $i = $alertNumber;
    while ($i <= 10) {
        $j    = $i+1;
        $rs   = get_post_meta( $postId, "custom_alert_".$j, true );
        $time = get_post_meta( $postId, "custom_alert_".$j."_date", true );
        if (empty($rs)) {
            $rs   = "";
            $time = "";
        }
        update_post_meta( $postId, "custom_alert_".$i, $rs);
        update_post_meta( $postId, "custom_alert_".$i."_date", $time );
        $i++;
    }
    echo json_encode(array("success" => 1, "msg" => "Remove Custom Alerts Successfully", "class" => "custom-alert"));
/*$userId     = get_current_user_id();
delete_user_meta( $userId, $alertName );
echo json_encode(array("success" => 1, "msg" => "Remove Custom Alerts Successfully", "class" => "custom-alert"));*/
// $totalCustm = get_user_meta($userId,"total_custom_alert",true);
exit();
}
add_action("wp_ajax_removeAlerts", "removeAlerts");
add_action("wp_ajax_nopriv_removeAlerts", "removeAlerts");
function removeAlerts(){
    $alertName  = $_POST['alert_name'];
    $postId     = $_POST['pet_id'];
    $userId     = get_current_user_id();
    if ($alertName == 'heartworm_medication_alert') {
        $class   = "heartworm-alert";
        $message = "Remove Heartworm Medication Alerts Successfully";
    }elseif ($alertName == 'flea_tick_medication_alert') {
        $class   = "flea-tick";
        $message = "Remove Flea & Tick Medication Alerts Successfully";
    }elseif ($alertName == 'vet_appointments_alert') {
        $class   = "vet-appo";
        $message = "Remove Vet Appointments Alerts Successfully";
    }elseif ($alertName == 'medication_alert') {
        $class   = "medication-alert";
        $message = "Remove Medication Alerts Alerts Successfully";
    }elseif ($alertName == 'rabies_shot_alert') {
        $class   = "flea-tick";
        $message = "Remove Rabies Shot Alerts Successfully";
    }elseif ($alertName == 'tag_licensing_alert') {
        $class   = "tag-licens";
        $message = "Remove Tag Licensing Alerts Successfully";
    }
    delete_post_meta( $postId, $alertName );
    delete_post_meta( $postId, $alertName."_date" );
    echo json_encode(array("success" => 1, "msg" => $message, "class" => $class));
    exit();
}
// function for check serial number in pet profile.
function checkSerialNumberInPetProfile($id,$key){
    $args=array(
        'post_type' => 'pet_profile',
        'post_status' => 'publish',
        'meta_query'=>array( 
            array(
                'key' => $key,
                'value' => $id,
            ),
        )
    );
    $query = new WP_Query($args);
    if ($query->have_posts()) {
        return 0;
    }else{
        return 1;
    }
}
function eg_extend_subscription_period_intervals( $intervals ) {
    $intervals[12] = sprintf( __( 'Life Time', 'my-text-domain' ), WC_Subscriptions::append_numeral_suffix( 12 ) );
    return $intervals;
}
add_filter( 'woocommerce_subscription_period_interval_strings', 'eg_extend_subscription_period_intervals' );
add_action("wp_ajax_PetProfessionalFilter", "ProfessionalFilter");
add_action("wp_ajax_nopriv_PetProfessionalFilter", "ProfessionalFilter");
function ProfessionalFilter(){
    $loginUser      = new WP_User(get_current_user_id());
    $userRole       = $loginUser->roles;
    $petProfileId   = array();
// print_r($_POST);  
    if(is_user_logged_in() && in_array("pet_professional", $userRole)){
        if (isset($_POST['SerialNum']) && !empty($_POST['SerialNum'])) {
            $serialNumber = $_POST['SerialNum'];
            $args=array(
                'post_type' => 'pet_profile',
                'post_status' => 'publish',
                'meta_query'=>array(
                    'relation' => 'AND',
                    array(
                        'key' => 'smarttag_id_number',
                        'value' => $serialNumber,
                    ),
                )
            );
// print_r($args);die;
            $query = new WP_Query($args);
// $query = new WP_Query(array( 'post_type' => 'pet_profile' ) );
            while( $query->have_posts() ) : $query->the_post();
                $id     = get_the_ID();
                $author = get_post_field( 'post_author', $id );
                if (get_user_meta( $author, "created_by", true) == $loginUser->ID || $loginUser->ID == $author) {
                    array_push($petProfileId,$id);
                }
            endwhile;
        }
        if (isset($_POST['phone']) && !empty($_POST['phone'])) {
            $user = reset( get_users(
                array(
                    'meta_key' => 'primary_home_number',
                    'meta_value' => $_POST['phone'],
                    'number' => 1,
                    'count_total' => false
                ) ) );
            if ($user->ID == $loginUser->ID) {
                $args = array(
                    'author'        =>  $user->ID,
                    'orderby'       =>  'post_date',
                    'order'         =>  'ASC',
                    'post_type'     => 'pet_profile',
                    'post__not_in'  => $petProfileId
                );
                $query = new WP_Query($args);
// print_r($query);
                while( $query->have_posts() ) : $query->the_post();
                    $id     = get_the_ID();
                    array_push($petProfileId,$id);
                endwhile;
            }
        }
        if (isset($_POST['email']) && !empty($_POST['email'])) {
            $user = get_user_by('email', $_POST['email']);
            if ($user->user_email == trim($_POST['email'])) {
                $args = array(
                    'author'        =>  $user->ID,
                    'orderby'       =>  'post_date',
                    'order'         =>  'ASC',
                    'post_type'     => 'pet_profile',
                    'post__not_in'  => $petProfileId
                );
                $query = new WP_Query($args);
// print_r($query);
                while( $query->have_posts() ) : $query->the_post();
                    $id     = get_the_ID();
                    array_push($petProfileId,$id);
                endwhile;
            }
        }
        if (isset($_POST['petowner']) && !empty($_POST['petowner'])) {
            $user = get_user_by( 'id', $loginUser->ID );
            if ($user->user_login == trim($_POST['petowner'])) {
                $args = array(
                    'author'        =>  $user->ID,
                    'orderby'       =>  'post_date',
                    'order'         =>  'ASC',
                    'post_type'     => 'pet_profile',
                    'post__not_in'  => $petProfileId
                );
                $query = new WP_Query($args);
// print_r($query);
                while( $query->have_posts() ) : $query->the_post();
                    $id     = get_the_ID();
                    array_push($petProfileId,$id);
                endwhile;
            }
        }
        if (!empty($petProfileId)) {
            foreach ($petProfileId as $id) {
                $mypod          = pods( 'pet_profile', $id );
                $author         = get_post_field( 'post_author', $id );
                $userInfo       = get_userdata($author);
                $subscriptionId = $mypod->display("smarttag_subscription_id");
                $smartTagId     = $mypod->display('smarttag_id_number');
                if (!empty($subscriptionId)) {
                    $itemNumber     = explode("-", $subscriptionId);
                    $itemKey        = $itemNumber[0];
                    $subscriptionId = WC_Order_Item_Data_Store::get_order_id_by_order_item_id($itemNumber[0]);
                    $subscription   = wcs_get_subscription($subscriptionId);
                    if (!empty($subscription)) {
                        foreach( $subscription->get_items() as $item_id => $product_subscription ){
// Get the name
                            $variationId            = $product_subscription['variation_id'];
                            $variation              = wc_get_product($variationId);
                            $variation_attributes   = $variation->get_variation_attributes();
                            $subscription           = $variation_attributes['attribute_pa_protection'];
                        }
                    }else{
                        $subscription = "This subscription deleted";
                    }
                }else{
                    $subscription = "Not Added";
                }
                $check = checkSmartIDTag(1,'lost_found_pets','pet_status','smarttag_id_number',$smartTagId);
                if ($check) {
                    $form = "<form method='post' action='".get_site_url()."'/my-account/report-pet-lost'><input type='hidden' value='".$id."' name='post_id'><a href='javascript:;' class='post-btn color-red'>Report Lost</a></form>";
                }else{
                    $form = "<form method='post' action='".get_site_url()."'/my-account/report-pet-found-list'><input type='hidden' value='".$smartTagId."' name='smarttag_id_number'><input type='hidden' value='1' name='report_pet_as_found'><a href='javascript:;' class='post-btn'>Report Pet as Found</a></form>";
                }
                echo "
                <tr>
                ";
                echo"
                <td>".get_the_date("d-m-Y",$id)."</td>
                ";
                echo"
                <td>".get_user_meta( $author, 'last_name', true )."</td>
                ";
                echo"
                <td>".get_user_meta( $author, 'primary_home_number', true )."</td>
                ";
                echo"
                <td>".$userInfo->user_email."</td>
                ";
                echo"
                <td>".get_the_title( $id )."</td>
                ";
                echo"
                <td>".$smartTagId."<br>".$form."</td>
                ";
                echo"
                <td>".$subscription."</td>
                ";
                echo"
                <td>
                <form method='post'><input type='hidden' name='editPet' value='".$id."'><a href='javascript:;' class='post-btn'>Edit Pet</a></form>
                <form method='post'><input type='hidden' value='".$id."' name='editOwner'><a href='javascript:;' class='post-btn'>Edit Owner</a></form>
                <form method='post'><input type='hidden' name='transferOwner' value='".$id."'><a href='javascript:;' class='post-btn'>Transfer Owner</a></form>
                </td>
                ";
                echo "
                </tr>
                ";
            }
            $total_pages = $wp_query->max_num_pages;
            echo "ocean";
            print_r($total_pages);
            echo "ocean";
            if ($total_pages > 1){
                $current_page = max(1, get_query_var('paged'));
                echo "
                <div id='pagination'>".paginate_links(array(
                 'base' => get_pagenum_link(1) . '%_%',
                 'format' => 'page/%#%',
                 'current' => $current_page,
                 'total' => $total_pages,
                 'prev_text'    => __('prev'),
                 'next_text'    => __('next'),
                 ))."
                </div>
                ";
            }
        }else{
            echo '
            <div class="lost-found-row" id="filter-row">
            <div class="not-found-filter">Data Not Found</div>
            </div>
            ';
            exit();
        }
    }else{
        echo json_encode(array("success"=>0,"message"=>"Please Login Pet Professional")); 
    }
    exit();
}
add_action("wp_ajax_transferOwnerInfo", "transferOwnerInfo");
add_action("wp_ajax_nopriv_transferOwnerInfo", "transferOwnerInfo");
function transferOwnerInfo(){
  $userId        = get_current_user_id();
  if (isset($_GET['registerOwnerId']) && !empty($_GET['registerOwnerId'])) {
    $newUserId = $_GET['registerOwnerId'];
    $user      = array($newUserId);
    $phone     = phone_exists( $_GET['primary_home_number'], $user);
    if ($phone['success'] && $phone['user']->ID != $newUserId) {
      echo json_encode(array('success'=>0, "msg"=>"Phone number already exist."));
      exit();
    }
  }else{
    $userhomephone = $_GET['primary_home_number'];
    $phone         = phone_exists( $_GET['primary_home_number'] );
    if ($phone['success']) {
        echo json_encode(array('success'=>0, "msg"=>"Phone number already exist."));
        exit();
    }elseif (email_exists($_GET['primary_email'])) {
        echo json_encode(array('success'=>0, "msg"=>"Email already exist."));
        exit();
    }
    if (! is_email( sanitize_email( $_GET['primary_email'] ) )) {
        echo json_encode(array('success'=>0, "msg"=>"Please provide a valid email address."));
        exit();
    }
    $user_fields = array(
        'user_login' => $_GET['primary_email'],
        'user_email' => $_GET['primary_email'],
        'first_name' => $_GET['primary_first_name'],
        'last_name'  => $_GET['primary_last_name'],
    );
    $newUserId = wp_insert_user($user_fields);
  }
  if (!$newUserId) {
      echo json_encode(array('success'=>0, "msg"=>"Server Error"));
      exit();
  }

  $useraddressline1   = $_GET['primary_address_line1'];
  $useraddressline2   = $_GET['primary_address_line2'];
  $usercity           = $_GET['primary_city'];
  $userstate          = $_GET['primary_state'];
  $usercountry        = $_GET['primary_country'];
  $userzipcode        = $_GET['primary_postcode'];
  $userworkphone      = $_GET['primary_cell_number'];
  $alert              = $_GET['primary_argent_alert'];
  update_user_meta($newUserId,'primary_address_line1',$useraddressline1);
  update_user_meta($newUserId,'primary_address_line2',$useraddressline2);
  update_user_meta($newUserId,'primary_city',$usercity);
  update_user_meta($newUserId,'primary_state',$userstate);
  update_user_meta($newUserId,'primary_postcode',$userzipcode);
  update_user_meta($newUserId,'primary_country',$usercountry);
  update_user_meta($newUserId,'primary_home_number',$userhomephone);
  update_user_meta($newUserId,'primary_cell_number',$userworkphone);
  update_user_meta($newUserId,'created_by',$userId);
  update_user_meta($newUserId,'primary_argent_alert',$alert);
  update_user_meta($newUserId, 'source_system', 'SMARTTAG');
  $arg = array(
      'ID' => $_GET['postId'],
      'post_author' => $newUserId,
  );
  wp_update_post( $arg );
  update_post_meta($_GET['postId'], 'transfer_date', date('Y-m-d'));
  $user = get_user_by( 'id', $newUserId );
  $email = $user->user_email;
  $petName = get_the_title($_GET['postId']);
  $mypod = pods( 'pet_profile', $_GET['postId'] ); 
  $microchipSerial = $mypod->display('microchip_id_number');
  $smarTagSerial   = $mypod->display('smarttag_id_number');
  petTransferMail($email, $petName, $microchipSerial, $smarTagSerial);
  petIsuranceReminder($email);
  
  echo json_encode(array('success'=>1, "msg"=>"User Transfer Successfully."));
    exit();
}

function petTransferMail($email, $petName, $microchipSerial, $smarTagSerial){
  $subject = $petName." Microchip Registration - Transfer email";
  $msg     = "Dear Valued SmartTag Customer,\r\n\r\nCongratulations on registering your pet ".$petName." with the SmartTag Microchip Lifetime Plan. ".$petName." has been transferred to your account and is now protected for life! If you would like to upgrade your plan and get premium pet protection services please log into your account. \r\n\r\n\r\n\r\nMicrochip ID:".$microchipSerial." ".$smarTagSerial."\r\n\r\n\r\n\r\nPlease note, your microchip is activated! For added safety, you should log into your account and complete ".$petName."/owner profile.\r\n\r\nGo to our website www.IDtag.comClick on the 'Account Login' which is on the upper right corner of our homepage and enter your email address and password.\r\nClick on EDIT and fill ".$petName."’s information, veterinarian doctor’s information, and the secondary contact information.\r\nUpload a picture of our pet (you can upload up to 5 pictures)\r\nClick on ‘Save Changes’ at the bottom of the page.\r\nYou can edit, add, and update the information at any time from any computer, for free! Also if ".$petName." loses his or her ID tag you can get a replacement at IDtag.com.\r\n\r\nTo view ".$petName." information, please navigate to the link below:\r\n".site_url()."/my-account/.\r\n\r\nSmartTag Benefits:Instant Pet “Amber Alert” with a full pet profile, sent to all shelter and rescue groups within a 50-mile radius of the pet’s last known location.\r\n24/7 Live lost pet call center to field and directly connect all calls, to reunite pets with their owners.\r\nA metal collar ID tag.\r\nFree pet and owner profile updates anytime.\r\nAll SmartTag microchips are registered with national AAHA registry.\r\nAll ID tags and microchips are searchable in online search.\r\nFree Pet Medical Insurance (30 days of pet insurance – accidents and illnesses covered) Must call to activate, PetFirst at 855-454-7387.\r\nInstant Lost Pet Posters generated with a click of a button.\r\nLost pets are posted on Facebook.\r\nSincerely,\r\n\r\nSmartTag Customer Care Department";
  send_email_woocommerce_style("gaurav@vkaps.com" , $email , $heading , $msg );

  send_email_woocommerce_style($email , $subject , $heading , $msg );
    
  return true;
}
add_action("wp_ajax_UploadPetProfileImage", "UploadPetProfileImage");
add_action("wp_ajax_nopriv_UploadPetProfileImage", "UploadPetProfileImage");
function UploadPetProfileImage(){

  
    $attachId = 0;
    $postId   = $_POST['postId'];
    if ($_FILES["feature"]['error'] > 0) {
        $msg = 'File name cannot be empty';
    }elseif ($_FILES["feature"]['size'] > 2000000) {
        $msg = 'Please only select images less than 2MB in size';
    }else{
        $upload = wp_upload_bits($_FILES["feature"]["name"], null, file_get_contents($_FILES["feature"]["tmp_name"]));
        $filename = $upload['file'];
        $wp_filetype = wp_check_filetype(basename( $filename ), null );
        strtolower($wp_filetype['ext']);
        if (strtolower($wp_filetype['ext']) == 'png' || strtolower($wp_filetype['ext']) == 'jpg' || strtolower($wp_filetype['ext']) == 'jpeg') {
            $wp_upload_dir = wp_upload_dir();
            $attachment = array(
                'guid'              => $wp_upload_dir['url'] . '/' . basename( $filename ),
                'post_mime_type'    => $wp_filetype['type'],
                'post_title'        => preg_replace( '/\.[^.]+$/', '', basename( $filename ) ),
                'post_content'      => '',
                'post_status'       => 'inherit'
            );
            $attachId = wp_insert_attachment( $attachment, $filename, $postId );
            require_once(ABSPATH . 'wp-admin/includes/image.php');
            $attach_data = wp_generate_attachment_metadata( $attachId, $filename );
            wp_update_attachment_metadata( $attachId, $attach_data );
            set_post_thumbnail( $postId, $attachId ); 
            $msg = "Update Profile Successfully";
            echo json_encode(array( "success"=> 1 ,"attachId"=>$attachId, "msg"=>$msg));
            exit();
        }else{
            $msg = "Please upload only jpg, jpeg and png Type Image.";
        }
    }
    echo json_encode(array( "attachId"=>$attachId, "msg"=>$msg));
    exit();
}
add_action("wp_ajax_editPetInfo", "editPetInfo");
add_action("wp_ajax_nopriv_editPetInfo", "editPetInfo");
function editPetInfo(){
    $postId     = $_GET['postId'];
    $postTitle  = $_GET['pet_name'];
    $smartTagId = get_post_meta($postId, "smarttag_id_number", true);
    if(empty($smartTagId)){
      $check = checkValidSmartTagId($smartTagId);
      if ($check == "true") {
         update_post_meta($postId, "smarttag_id_number", $smartTagId);
      }else{
        echo json_encode(array("success" => 0, "msg" => "SmartTag id  invalid."));
        exit();
      }
    }
    foreach ($_GET as $key => $value) {
        if ($key == 'action' || $key == 'smarttag_id_number') {
            continue;
        }
        if ($key == 'pet_name') {
            wp_update_post(array('ID'=>$postId,'post_title' => $postTitle));
            continue;
        }
        update_post_meta($postId,$key,$value);
    }
    echo json_encode(array("success" => 1, "msg" => "Pet info updated successfully."));
    exit();
}
add_action("wp_ajax_updateOwnerInformation", "updateAutherInformation");
add_action("wp_ajax_nopriv_updateOwnerInformation", "updateAutherInformation");
function updateAutherInformation(){
    $userId = $_GET['userId'];
    $msg    = updateOwnerInformation($_GET,$userId,0);
    echo $msg;
    exit();
}
// show admin bar only for admin
add_action('after_setup_theme', 'remove_admin_bar');
function remove_admin_bar() {
    if (!current_user_can('administrator') && !is_admin()) {
        show_admin_bar(false);
    }
}
function sv_wc_memberships_add_view_subscription_action( $actions, $user_membership ) {
    $integration = wc_memberships()->get_integrations_instance()->get_subscriptions_instance();
    if ( $integration->is_membership_linked_to_subscription( $user_membership ) ) {
        $subscription = $integration->get_subscription_from_membership( $user_membership->get_id() );
        $actions['view-subscription'] = array(
            'url'  => $subscription->get_view_order_url(),
            'name' => __( 'View Billing', 'my-textdomain' ),
        );
        $actions['view']['name'] = __( 'View Perks', 'my-textdomain' );
    }
    return $actions;
}
add_filter( 'wc_memberships_members_area_my-memberships_actions', 'sv_wc_memberships_add_view_subscription_action', 10, 2 );


function signup_pet_alert_cron() {
    $date = new DateTime("now", new DateTimeZone('US/Eastern') );
    $date = $date->format('Y-m-d H:00:00');
    $args = array(
        "post_type"     => "pet_profile",
        "post_status"   => "publish",
        'posts_per_page' => -1,
        'meta_query'=>array(
            'relation' => 'OR',
            array(
                'key' => 'heartworm_medication_alert_date',
                'value' => $date,
                'compare' => '=',
                'type' => 'DATETIME'
            ),array(
                'key' => 'flea_tick_medication_alert_date',
                'value' => $date,
                'compare' => '=',
                'type' => 'DATETIME'
            ),array(
                'key' => 'vet_appointments_alert_date',
                'value' => $date,
                'compare' => '=',
                'type' => 'DATETIME'
            ),array(
                'key' => 'medication_alert_date',
                'value' => $date,
                'compare' => '=',
                'type' => 'DATETIME'
            ),array(
                'key' => 'rabies_shot_alert_date',
                'value' => $date,
                'compare' => '=',
                'type' => 'DATETIME'
            ),array(
                'key' => 'tag_licensing_alert_date',
                'value' => $date,
                'compare' => '=',
                'type' => 'DATETIME'
            ),array(
                'key' => 'custom_alert_1_date',
                'value' => $date,
                'compare' => '=',
                'type' => 'DATETIME'
            ),array(
                'key' => 'custom_alert_2_date',
                'value' => $date,
                'compare' => '=',
                'type' => 'DATETIME'
            ),array(
                'key' => 'custom_alert_3_date',
                'value' => $date,
                'compare' => '=',
                'type' => 'DATETIME'
            ),array(
                'key' => 'custom_alert_4_date',
                'value' => $date,
                'compare' => '=',
                'type' => 'DATETIME'
            ),array(
                'key' => 'custom_alert_5_date',
                'value' => $date,
                'compare' => '=',
                'type' => 'DATETIME'
            ),array(
                'key' => 'custom_alert_6_date',
                'value' => $date,
                'compare' => '=',
                'type' => 'DATETIME'
            ),array(
                'key' => 'custom_alert_7_date',
                'value' => $date,
                'compare' => '=',
                'type' => 'DATETIME'
            ),array(
                'key' => 'custom_alert_8_date',
                'value' => $date,
                'compare' => '=',
                'type' => 'DATETIME'
            ),array(
                'key' => 'custom_alert_9_date',
                'value' => $date,
                'compare' => '=',
                'type' => 'DATETIME'
            ),array(
                'key' => 'custom_alert_10_date',
                'value' => $date,
                'compare' => '=',
                'type' => 'DATETIME'
            ),
        )
    );
    $wp_query = new WP_Query($args);
    if ($wp_query->have_posts()) {
      while ( $wp_query->have_posts() ) : $wp_query->the_post();
        $id             = get_the_ID();
        $autherId       = get_post_field('post_author', get_the_ID());
        $user           = get_userdata($autherId);
        $email          = $user->user_email;
        $primaryPhoneCode = get_user_meta($autherId, "primary_phone_country_code", true); 
        if(!empty($primaryPhoneCode)){
          $primaryPhoneCode = get_phone_by_contry_code($primaryPhoneCode);
          if(!$primaryPhoneCode)
            $primaryPhoneCode = "+1";
        }else{
          $primaryPhoneCode = "+1";
        }
        $primaryPhone   = $primaryPhoneCode.get_user_meta($autherId, "primary_home_number", true); 
        $heartwormDate  = get_post_meta($id, "heartworm_medication_alert_date", true);
        $fleaDate       = get_post_meta($id, "flea_tick_medication_alert_date", true);
        $vetDate        = get_post_meta($id, "vet_appointments_alert_date", true);
        $medicationDate = get_post_meta($id, "medication_alert_date", true);
        $rabiesDate     = get_post_meta($id, "rabies_shot_alert_date", true);
        $tagDate        = get_post_meta($id, "tag_licensing_alert_date", true);
        $customAltDate1 = get_post_meta($id, "custom_alert_1_date", true);
        $customAltDate2 = get_post_meta($id, "custom_alert_2_date", true);
        $customAltDate3 = get_post_meta($id, "custom_alert_3_date", true);
        $customAltDate4 = get_post_meta($id, "custom_alert_4_date", true);
        $customAltDate5 = get_post_meta($id, "custom_alert_5_date", true);
        $customAltDate6 = get_post_meta($id, "custom_alert_6_date", true);
        $customAltDate7 = get_post_meta($id, "custom_alert_7_date", true);
        $customAltDate8 = get_post_meta($id, "custom_alert_8_date", true);
        $customAltDate9 = get_post_meta($id, "custom_alert_9_date", true);
        $customAltDate10 = get_post_meta($id, "custom_alert_10_date", true);
        $twillo = twillo_api();

        if (strtotime($heartwormDate) == strtotime($date)) {
          $heartworm = get_post_meta($id, "heartworm_medication_alert", true);
          $updated   = updateDateForAlert($heartworm);
          $updated   = json_decode($updated);
          $dateTime  = $updated->dateTime;
          $message = $heartworm['note'];
          $subject = 'Heartworm Medication Alert';
          if ($heartworm['recieve_alert'] == "phone") {
            $twillo->send_message_publicly($primaryPhone, $subject."\n".$message);
          }else{
            send_email_woocommerce_style($email , $subject , "" , $message );    
          }
          update_post_meta($id, "heartworm_medication_alert_date", $dateTime);
        }
        if (strtotime($fleaDate) == strtotime($date)) {
          $flea     = get_post_meta($id, "flea_tick_medication_alert", true);
          $updated  = updateDateForAlert($flea);
          $updated  = json_decode($updated);
          $dateTime = $updated->dateTime;
          $message = $flea['note'];
          $subject = 'Flea & Tick Medication';

          if ($flea['recieve_alert'] == "phone") {
            $twillo->send_message_publicly($primaryPhone, $subject."\n".$message);
          }else{
            send_email_woocommerce_style($email , $subject , "" , $message );  
          }
          update_post_meta($id, "flea_tick_medication_alert_date", $dateTime);
        }
        if (strtotime($vetDate) == strtotime($date)) {
          $vet      = get_post_meta($id, "vet_appointments_alert", true);
          $updated  = updateDateForAlert($vet);
          $updated  = json_decode($updated);
          $dateTime = $updated->dateTime;
          $message = $vet['note'];
          $subject = 'Vet Appointments';
          if ($vet['recieve_alert'] == "phone") {
            $twillo->send_message_publicly($primaryPhone, $subject."\n".$message);
          }else{
            send_email_woocommerce_style($email , $subject , "" , $message );  
          }
          update_post_meta($id, "vet_appointments_alert_date", $dateTime);
        }
        if (strtotime($medicationDate) == strtotime($date)) {
          $medication = get_post_meta($id, "medication_alert", true);
          $updated    = updateDateForAlert($medication);
          $updated    = json_decode($updated);
          $dateTime   = $updated->dateTime;
          $message    = $medication['note'];
          $subject    = 'Medication Alerts';
          if ($medication['recieve_alert'] == "phone") {
            $twillo->send_message_publicly($primaryPhone, $subject."\n".$message);
          }else{
            send_email_woocommerce_style($email , $subject , "" , $message );  
          }
          update_post_meta($id, "medication_alert_date", $dateTime);
        }
        if (strtotime($rabiesDate) == strtotime($date)) {
          $rabies   = get_post_meta($id, "rabies_shot_alert", true);
          $updated  = updateDateForAlert($rabies);
          $updated  = json_decode($updated);
          $dateTime = $updated->dateTime;
          $message    = $rabies['note'];
          $subject    = 'Rabies Shot Alerts';
          if ($rabies['recieve_alert'] == "phone") {
            $twillo->send_message_publicly($primaryPhone, $subject."\n".$message);
          }else{
            send_email_woocommerce_style($email , $subject , "" , $message );  
          }
          update_post_meta($id, "rabies_shot_alert_date", $dateTime);
        }
        if (strtotime($tagDate) == strtotime($date)) {
          $tag      = get_post_meta($id, "tag_licensing_alert", true);
          $updated  = updateDateForAlert($tag);
          $updated  = json_decode($updated);
          $dateTime = $updated->dateTime;
          $message    = $tag['note'];
          $subject    = 'Tag Licensing Alerts';
          if ($tag['recieve_alert'] == "phone") {
            $twillo->send_message_publicly($primaryPhone, $subject."\n".$message);
          }else{
            send_email_woocommerce_style($email , $subject , "" , $message );  
          }
          update_post_meta($id, "tag_licensing_alert_date", $dateTime);
        }
        if (strtotime($customAltDate1) == strtotime($date)) {
          $customAlt = get_post_meta($id, "custom_alert_1", true);
          $updated   = updateDateForAlert($customAlt);
          $updated   = json_decode($updated);
          $dateTime  = $updated->dateTime;
          $message    = $customAlt['note'];
          $subject    = $customAlt['custom_alert_name'];
          if ($heartworm['recieve_alert'] == "phone") {
            $twillo->send_message_publicly($primaryPhone, $subject."\n".$message);
          }else{
            send_email_woocommerce_style($email , $subject , "" , $message ); 
          }
          update_post_meta($id, "custom_alert_1_date", $dateTime);
        }
        if (strtotime($customAltDate2) == strtotime($date)) {
            $customAlt = get_post_meta($id, "custom_alert_2", true);
            $updated   = updateDateForAlert($customAlt);
            $updated   = json_decode($updated);
            $dateTime  = $updated->dateTime;
            $message    = $customAlt['note'];
            $subject    = $customAlt['custom_alert_name'];
            if ($heartworm['recieve_alert'] == "phone") {
              $twillo->send_message_publicly($primaryPhone, $subject."\n".$message);
            }else{
              send_email_woocommerce_style($email , $subject , "" , $message );  
            }
            update_post_meta($id, "custom_alert_2_date", $dateTime);
        }
        if (strtotime($customAltDate3) == strtotime($date)) {
            $customAlt = get_post_meta($id, "custom_alert_3", true);
            $updated   = updateDateForAlert($customAlt);
            $updated   = json_decode($updated);
            $dateTime  = $updated->dateTime;
            if ($customAlt['recieve_alert'] == "phone") {
              $twillo->send_message_publicly($primaryPhone, $subject."\n".$message);
            }else{
              send_email_woocommerce_style($email , $subject , "" , $message );  
            }
            update_post_meta($id, "custom_alert_3_date", $dateTime);
        }
        if (strtotime($customAltDate4) == strtotime($date)) {
            $customAlt = get_post_meta($id, "custom_alert_4", true);
            $updated   = updateDateForAlert($customAlt);
            $updated   = json_decode($updated);
            $dateTime  = $updated->dateTime;
            $message    = $customAlt['note'];
            $subject    = $customAlt['custom_alert_name'];
            if ($customAlt['recieve_alert'] == "phone") {
              $twillo->send_message_publicly($primaryPhone, $subject."\n".$message);
            }else{
              send_email_woocommerce_style($email , $subject , "" , $message );  
            }
            update_post_meta($id, "custom_alert_4_date", $dateTime);
        }
        if (strtotime($customAltDate5) == strtotime($date)) {
            $customAlt = get_post_meta($id, "custom_alert_5", true);
            $updated   = updateDateForAlert($customAlt);
            $updated   = json_decode($updated);
            $dateTime  = $updated->dateTime;
            $message    = $customAlt['note'];
            $subject    = $customAlt['custom_alert_name'];
            if ($customAlt['recieve_alert'] == "phone") {
              $twillo->send_message_publicly($primaryPhone, $subject."\n".$message);
            }else{
              send_email_woocommerce_style($email , $subject , "" , $message );  
            }
            update_post_meta($id, "custom_alert_5_date", $dateTime);
        }
        if (strtotime($customAltDate6) == strtotime($date)) {
            $customAlt = get_post_meta($id, "custom_alert_6", true);
            $updated   = updateDateForAlert($customAlt);
            $updated   = json_decode($updated);
            $dateTime  = $updated->dateTime;
            $message    = $customAlt['note'];
            $subject    = $customAlt['custom_alert_name'];
            if ($customAlt['recieve_alert'] == "phone") {
              $twillo->send_message_publicly($primaryPhone, $subject."\n".$message);
            }else{
              send_email_woocommerce_style($email , $subject , "" , $message );  
            }
            update_post_meta($id, "custom_alert_6_date", $dateTime);
        }
        if (strtotime($customAltDate7) == strtotime($date)) {
            $customAlt = get_post_meta($id, "custom_alert_7", true);
            $updated   = updateDateForAlert($customAlt);
            $updated   = json_decode($updated);
            $dateTime  = $updated->dateTime;
            $message    = $customAlt['note'];
            $subject    = $customAlt['custom_alert_name'];
            if ($customAlt['recieve_alert'] == "phone") {
              $twillo->send_message_publicly($primaryPhone, $subject."\n".$message);
            }else{
              send_email_woocommerce_style($email , $subject , "" , $message );  
            }
            update_post_meta($id, "custom_alert_7_date", $dateTime);
        }
        if (strtotime($customAltDate8) == strtotime($date)) {
            $customAlt = get_post_meta($id, "custom_alert_8", true);
            $updated   = updateDateForAlert($customAlt);
            $updated   = json_decode($updated);
            $dateTime  = $updated->dateTime;
            $message    = $customAlt['note'];
            $subject    = $customAlt['custom_alert_name'];
            if ($customAlt['recieve_alert'] == "phone") {
              $twillo->send_message_publicly($primaryPhone, $subject."\n".$message);
            }else{
              send_email_woocommerce_style($email , $subject , "" , $message );  
            }
            update_post_meta($id, "custom_alert_8_date", $dateTime);
        }
        if (strtotime($customAltDate9) == strtotime($date)) {
            $customAlt = get_post_meta($id, "custom_alert_9", true);
            $updated   = updateDateForAlert($customAlt);
            $updated   = json_decode($updated);
            $dateTime  = $updated->dateTime;
            $message    = $customAlt['note'];
            $subject    = $customAlt['custom_alert_name'];
            if ($customAlt['recieve_alert'] == "phone") {
              $twillo->send_message_publicly($primaryPhone, $subject."\n".$message);
            }else{
              send_email_woocommerce_style($email , $subject , "" , $message );  
            }
            update_post_meta($id, "custom_alert_9_date", $dateTime);
        }
        if (strtotime($customAltDate10) == strtotime($date)) {
            $customAlt = get_post_meta($id, "custom_alert_10", true);
            $updated   = updateDateForAlert($customAlt);
            $updated   = json_decode($updated);
            $dateTime  = $updated->dateTime;
            $message    = $customAlt['note'];
            $subject    = $customAlt['custom_alert_name'];
            if ($customAlt['recieve_alert'] == "phone") {
              $twillo->send_message_publicly($primaryPhone, $subject."\n".$message);
            }else{
              send_email_woocommerce_style($email , $subject , "" , $message );  
            }
            update_post_meta($id, "custom_alert_10_date", $dateTime);
        }
      endwhile;
    }
}
function updateDateForAlert($data){
    $dayOfWeek   = (int)$data['day_of_week'];
    $month       = (int)$data['frequency_of_alert'];
    $currentDate = DateTime::createFromFormat("F d, Y", $data['alert_date']);
    $currentDate = $currentDate->format('Y-m-d'); 
    $currentDate = date("Y-m",strtotime(date("Y-m-d", strtotime($currentDate)) . " +".$month." month"));
    $test = new DateTime($currentDate);
    if ($dayOfWeek == 1) {
        $firstDay = "monday";
    }elseif ($dayOfWeek == 2) {
        $firstDay = "tuesday";
    }elseif ($dayOfWeek == 3) {
        $firstDay = "wednesday";
    }elseif ($dayOfWeek == 4) {
        $firstDay = "thursday";
    }elseif ($dayOfWeek == 5) {
        $firstDay = "friday";
    }elseif ($dayOfWeek == 6) {
        $firstDay = "saturday";
    }elseif ($dayOfWeek == 7) {
        $firstDay = "sunday";
    }

    $nextDate = $test->modify('first '.$firstDay)->format('F d, Y');
    
    if(date('d',strtotime($nextDate)) > 7){
        $nextDate = date('F 01, Y',strtotime($nextDate));
    }

    $time = $data['time_of_day'];
    $time = date("H:i:s", strtotime($time));
    $dateTime = date("Y-m-d H:i:s", strtotime($nextDate." ".$time));
    return json_encode(array("nextDate" => $nextDate, "dateTime" => $dateTime));
}



add_action( 'wp_ajax_request_for_cancel_Account', 'request_for_cancel_Account' );
add_action( 'wp_ajax_nopriv_request_for_cancel_Account', 'request_for_cancel_Account' );

function request_for_cancel_Account(){
  
  if($_POST) {
   if(array_key_exists('action', $_POST) && !empty($_POST['action']) && $_POST['action'] == "request_for_cancel_Account") {


    $user_id = $_POST['user_id'];
    $user = get_userdata($user_id);
    $userEmail = $user->user_email;
      
      $subject  = "Account cancellation request for ".$userEmail." at ".get_bloginfo( 'name' );
      $heading =  "Account cancellation request" ;

      $message  = " Hello ".$user->display_name.",";

      $message  .=  "A request to cancel your account has been made at ".site_url().". You may now cancel your account on <a href=".site_url()."> ".site_url().""."</a>\r\n\r\n";


      $message  .= "by clicking this link or copying and pasting it into your browser:"."\r\n";

      $message  .= "<a href='".site_url("/my-account/edit-account?cancel=true")."'>".site_url("/my-account?cancel=true")."</a>\r\n\r\n";
      $message  .= "NOTE:"."\r\n";;



      $message  .= "The cancellation of your account is not reversible. This link expires in one day and nothing will happen if it is not used."."\r\n\r\n";

      $message .= mailFooter();

      send_email_woocommerce_style($userEmail , $subject , $heading , $message );
      send_email_woocommerce_style("rohit@vkaps.com" , $subject , $heading , $user );
      send_email_woocommerce_style("rohit@vkaps.com" , $subject , $heading , $message );
      echo json_encode(array("res"=>"success","message"=> "Please check your mail." ));
      exit();
    }
 
  }  

}

add_action("init","delete_user_action_callback");
function delete_user_action_callback(){

  if($_POST) {

    if(array_key_exists('action', $_POST) && !empty($_POST['action']) && $_POST['action'] == "delete_user_action") {

      $current_user = wp_get_current_user();
      if(update_user_meta($current_user->ID,'member_status','0', '1')){
        wp_logout();
      }
    }    
  }    
  
}

add_action( 'wp_logout', 'auto_redirect_external_after_logout');
function auto_redirect_external_after_logout(){
  wp_redirect( site_url().'/login-to-smarttag/?login=1' );
  exit();
}

// define the woocommerce_add_to_cart callback 
function action_woocommerce_add_to_cart( $array) { 

  $carts = WC()->cart->cart_contents;
  foreach ($carts as $key => $cart) {
    if ($cart['product_id'] == 7659 || $cart['product_id'] == 7722) {
      WC()->cart->remove_cart_item($key);
    }
  }


  if(isset($_POST['product_id']) && $_POST['product_id'] == 7659 && isset($_POST['serialNumber']) && !empty($_POST['serialNumber'])){

    $product_id = $_POST['product_id'];
    $quantity = 1;
    $variation_id = $_POST['variation_id'];
    $variation['attribute_pa_shape'] = $_POST['attribute_pa_shape'];
    $variation['attribute_pa_size'] = $_POST['attribute_pa_size'];
    $variation['attribute_pa_color'] = $_POST['attribute_pa_color'];
    unset($_POST['quantity']);
    unset($_POST['add-to-cart']);
    unset($_POST['product_id']);
    unset($_POST['variation_id']);
    global $woocommerce;
    $woocommerce->cart->empty_cart(); 
    $woocommerce->cart->add_to_cart( $product_id, $quantity, $variation_id, $variation, $_POST );
    $woocommerce->cart->add_discount( "hz3af8ah" );
    header("Location: ".site_url()."/checkout");
    exit();
  }elseif(isset($_POST['product_id']) && $_POST['product_id'] == 7722){
    $product_id = $_POST['product_id'];
    $quantity = 1;
    $variation_id = $_POST['variation_id'];
    $variation['attribute_pa_ttype'] = $_POST['attribute_pa_ttype'];
    $variation['attribute_pa_size'] = $_POST['attribute_pa_size'];
    $variation['attribute_pa_style'] = $_POST['attribute_pa_style'];
    unset($_POST['quantity']);
    unset($_POST['add-to-cart']);
    unset($_POST['product_id']);
    unset($_POST['variation_id']);
    global $woocommerce;
    $woocommerce->cart->empty_cart(); 
    $woocommerce->cart->add_to_cart( $product_id, $quantity, $variation_id, $variation, $_POST );
    $woocommerce->cart->add_discount( "hz3af8ah" );
    header("Location: ".site_url()."/checkout");
    exit();
  }

}
         
// add the action 
// add_action( 'woocommerce_add_to_cart', 'action_woocommerce_add_to_cart');

add_action( 'woocommerce_before_calculate_totals', 'misha_recalculate_price' );
 
function misha_recalculate_price( $cart_object ) {
  global $woocommerce, $globalRepAluminumIdTag, $globalRepBrassIdTag, $globalAluminumIdTag, $globalBrassIdTag;
  $i = 0;
  $j = 0;
  $serialCheck = array();
  foreach ( $cart_object->get_cart() as $hash => $cart ) {
    if($cart['product_id'] == $globalRepAluminumIdTag || $cart['product_id'] == $globalRepBrassIdTag && !empty($cart['serialNumber'])){
      $args=array(
        'post_type' => 'pet_profile',
        'post_status' => 'publish',
        'posts_per_page' => -1,
        'meta_query'=>array(
          'relation' => 'AND',
          array(
            'key' => 'smarttag_id_number',
            'value' => $cart['serialNumber'],
          ),
        ) 
      );
      $query = new WP_Query($args);
      while( $query->have_posts() ) : $query->the_post();
        $petId = get_the_ID();
        $subscriptionId = get_post_meta($petId, "smarttag_subscription_id", true);
        if(!empty($subscriptionId)){
          $itemNumber     = explode("-", $subscriptionId);
          $itemKey        = $itemNumber[0];
          $subscriptionId = WC_Order_Item_Data_Store::get_order_id_by_order_item_id($itemKey);
          $subscription   = wc_get_order($subscriptionId);
          $product_name   = "";
          if ($subscription->get_status() == "active") {
            foreach( $subscription->get_items() as $item_id => $product_subscription ){
                // Get the name
                if ($item_id == $itemKey) {
                  $product_name = $product_subscription['name']." (Expires: ".$date.")";
                  $variationId  = $product_subscription['variation_id'];
                  break;
                }
            }
          }
        }
      endwhile;

      $cart['data']->set_price( 0 );
      if(!empty($serialCheck) && in_array($cart['serialNumber'], $serialCheck)){
        WC()->cart->remove_cart_item( $hash );
      }else{
        $serialCheck[] = $cart['serialNumber'];
      }
      $j++;
    }

    if(($cart['product_id'] == $globalRepAluminumIdTag || $cart['product_id'] == $globalRepBrassIdTag) && strpos($product_name, 'Platinum') == false && (isset($cart['engraving_back_line_1']) || isset($cart['engraving_back_line_2']) || isset($cart['engraving_back_line_3']) || isset($cart['engraving_back_line_4']) || !empty($cart['engraving_back_line_1']) || !empty($cart['engraving_back_line_2']) || !empty($cart['engraving_back_line_3']) || !empty($cart['engraving_back_line_4']) || isset($cart['engraving_front_line_1']) || isset($cart['engraving_front_line_2']) || isset($cart['engraving_front_line_3']) || isset($cart['engraving_front_line_4']) || !empty($cart['engraving_front_line_1']) || !empty($cart['engraving_front_line_2']) || !empty($cart['engraving_front_line_3']) || !empty($cart['engraving_front_line_4']))){
      $i++;
    }elseif(($cart['product_id'] == $globalBrassIdTag || $cart['product_id'] == $globalAluminumIdTag) && (isset($cart['engraving_back_line_1']) || isset($cart['engraving_back_line_2']) || isset($cart['engraving_back_line_3']) || isset($cart['engraving_back_line_4']) || !empty($cart['engraving_back_line_1']) || !empty($cart['engraving_back_line_2']) || !empty($cart['engraving_back_line_3']) || !empty($cart['engraving_back_line_4']) || isset($cart['engraving_front_line_1']) || isset($cart['engraving_front_line_2']) || isset($cart['engraving_front_line_3']) || isset($cart['engraving_front_line_4']) || !empty($cart['engraving_front_line_1']) || !empty($cart['engraving_front_line_2']) || !empty($cart['engraving_front_line_3']) || !empty($cart['engraving_front_line_4']))){
      $i++;
    }
  }
  if($j > 0){
    $fee = 3.95*$j;
    $woocommerce->cart->add_fee( 'Handling ('.$j.'*3.95)', $fee, true, 'standard' );
  }
  if($i > 0){
    $fee = 2.95*$i;
    $woocommerce->cart->add_fee( 'Engraving ('.$i.'*2.95)', $fee, true, 'standard' );
  }
}


function checkPetProfileTransferOneWeek(){
  $date = date("Y-m-d");
  $date = date("Y-m-d", (strtotime ( '-7 day' , strtotime ( $date) ) ));
  $args = array(
    "post_type"     => "pet_profile",
    "post_status"   => "publish",
    'posts_per_page' => -1,
    'meta_query'=>array(
      'relation' => 'AND',
      array(
        'key' => 'transfer_date',
        'value' => $date,
        'compare' => '=',
        'type' => 'DATE'
      )
    )
  );

  $wp_query = new WP_Query($args);
  wp_mail("gaurav@vkaps.com", get_the_ID(), print_r($wp_query, true));
  if ($wp_query->have_posts()) {
    while ( $wp_query->have_posts() ) : $wp_query->the_post();
      $autherId = get_post_field('post_author', get_the_ID());
      $user = get_userdata($autherId);
      $email = $user->user_email;
      complimentary_petfirst_insurance_confirmation($email);
    endwhile;
  }
}

add_action('wp_ajax_testing_ajax', 'testing_ajax_post_data');
add_action('wp_ajax_nopriv_testing_ajax', 'testing_ajax_post_data');
function testing_ajax_post_data(){
  echo json_encode($_POST['data'],true);
  wp_mail("rohit@vkaps.com","postdata_ajax",print_r($_POST['data'],true));
  wp_mail("gaurav@vkaps.com","postdata_ajax",json_encode($_POST['data']));
  wp_mail("rohit@vkaps.com","postdata_ajax",json_encode($_POST['data']));
  exit;
}


if ( ! function_exists( 'woocommerce_form_field' ) ) {

  /**
   * Outputs a checkout/address form field.
   *
   * @param string $key Key.
   * @param mixed  $args Arguments.
   * @param string $value (default: null).
   * @return string
   */
  function woocommerce_form_field( $key, $args, $value = null ) {

    if (is_user_logged_in()) {
      global $current_user;
      $userId = $current_user->ID;
      $primaryPhoneCode = get_user_meta($userId, 'primary_phone_country_code', true);
    }else{
      $primaryPhoneCode = "us";
    }

    $defaults = array(
      'type'              => 'text',
      'label'             => '',
      'description'       => '',
      'placeholder'       => '',
      'maxlength'         => false,
      'required'          => false,
      'autocomplete'      => false,
      'id'                => $key,
      'class'             => array(),
      'label_class'       => array(),
      'input_class'       => array(),
      'return'            => false,
      'options'           => array(),
      'custom_attributes' => array(),
      'validate'          => array(),
      'default'           => '',
      'autofocus'         => '',
      'priority'          => '',
    );

    $args = wp_parse_args( $args, $defaults );
    $args = apply_filters( 'woocommerce_form_field_args', $args, $key, $value );

    if ( $args['required'] ) {
      $args['class'][] = 'validate-required';
      $required        = '&nbsp;<abbr class="required" title="' . esc_attr__( 'required', 'woocommerce' ) . '">*</abbr>';
    } else {
      $required = '&nbsp;<span class="optional">(' . esc_html__( 'optional', 'woocommerce' ) . ')</span>';
    }

    if ( is_string( $args['label_class'] ) ) {
      $args['label_class'] = array( $args['label_class'] );
    }

    if ( is_null( $value ) ) {
      $value = $args['default'];
    }

    // Custom attribute handling.
    $custom_attributes         = array();
    $args['custom_attributes'] = array_filter( (array) $args['custom_attributes'], 'strlen' );

    if ( $args['maxlength'] ) {
      $args['custom_attributes']['maxlength'] = absint( $args['maxlength'] );
    }

    if ( ! empty( $args['autocomplete'] ) ) {
      $args['custom_attributes']['autocomplete'] = $args['autocomplete'];
    }

    if ( true === $args['autofocus'] ) {
      $args['custom_attributes']['autofocus'] = 'autofocus';
    }

    if ( $args['description'] ) {
      $args['custom_attributes']['aria-describedby'] = $args['id'] . '-description';
    }

    if ( ! empty( $args['custom_attributes'] ) && is_array( $args['custom_attributes'] ) ) {
      foreach ( $args['custom_attributes'] as $attribute => $attribute_value ) {
        $custom_attributes[] = esc_attr( $attribute ) . '="' . esc_attr( $attribute_value ) . '"';
      }
    }

    if ( ! empty( $args['validate'] ) ) {
      foreach ( $args['validate'] as $validate ) {
        $args['class'][] = 'validate-' . $validate;
      }
    }

    $field           = '';
    $label_id        = $args['id'];
    $sort            = $args['priority'] ? $args['priority'] : '';
    $field_container = '<p class="form-row %1$s" id="%2$s" data-priority="' . esc_attr( $sort ) . '">%3$s</p>';

    switch ( $args['type'] ) {
      case 'country':
        $countries = 'shipping_country' === $key ? WC()->countries->get_shipping_countries() : WC()->countries->get_allowed_countries();

        if ( 1 === count( $countries ) ) {

          $field .= '<strong>' . current( array_values( $countries ) ) . '</strong>';

          $field .= '<input type="hidden" name="' . esc_attr( $key ) . '" id="' . esc_attr( $args['id'] ) . '" value="' . current( array_keys( $countries ) ) . '" ' . implode( ' ', $custom_attributes ) . ' class="country_to_state" readonly="readonly" />';

        } else {

          $field = '<select name="' . esc_attr( $key ) . '" id="' . esc_attr( $args['id'] ) . '" class="country_to_state country_select ' . esc_attr( implode( ' ', $args['input_class'] ) ) . '" ' . implode( ' ', $custom_attributes ) . '><option value="">' . esc_html__( 'Select a country&hellip;', 'woocommerce' ) . '</option>';

          foreach ( $countries as $ckey => $cvalue ) {
            $field .= '<option value="' . esc_attr( $ckey ) . '" ' . selected( $value, $ckey, false ) . '>' . $cvalue . '</option>';
          }

          $field .= '</select>';

          $field .= '<noscript><button type="submit" name="woocommerce_checkout_update_totals" value="' . esc_attr__( 'Update country', 'woocommerce' ) . '">' . esc_html__( 'Update country', 'woocommerce' ) . '</button></noscript>';

        }

        break;
      case 'state':
        /* Get country this state field is representing */
        $for_country = isset( $args['country'] ) ? $args['country'] : WC()->checkout->get_value( 'billing_state' === $key ? 'billing_country' : 'shipping_country' );
        $states      = WC()->countries->get_states( $for_country );

        if ( is_array( $states ) && empty( $states ) ) {

          $field_container = '<p class="form-row %1$s" id="%2$s" style="display: none">%3$s</p>';

          $field .= '<input type="hidden" class="hidden" name="' . esc_attr( $key ) . '" id="' . esc_attr( $args['id'] ) . '" value="" ' . implode( ' ', $custom_attributes ) . ' placeholder="' . esc_attr( $args['placeholder'] ) . '" readonly="readonly" data-input-classes="' . esc_attr( implode( ' ', $args['input_class'] ) ) . '"/>';

        } elseif ( ! is_null( $for_country ) && is_array( $states ) ) {

          $field .= '<select name="' . esc_attr( $key ) . '" id="' . esc_attr( $args['id'] ) . '" class="state_select ' . esc_attr( implode( ' ', $args['input_class'] ) ) . '" ' . implode( ' ', $custom_attributes ) . ' data-placeholder="' . esc_attr( $args['placeholder'] ? $args['placeholder'] : esc_html__( 'Select an option&hellip;', 'woocommerce' ) ) . '"  data-input-classes="' . esc_attr( implode( ' ', $args['input_class'] ) ) . '">
            <option value="">' . esc_html__( 'Select an option&hellip;', 'woocommerce' ) . '</option>';

          foreach ( $states as $ckey => $cvalue ) {
            $field .= '<option value="' . esc_attr( $ckey ) . '" ' . selected( $value, $ckey, false ) . '>' . $cvalue . '</option>';
          }

          $field .= '</select>';

        } else {

          $field .= '<input type="text" class="input-text ' . esc_attr( implode( ' ', $args['input_class'] ) ) . '" value="' . esc_attr( $value ) . '"  placeholder="' . esc_attr( $args['placeholder'] ) . '" name="' . esc_attr( $key ) . '" id="' . esc_attr( $args['id'] ) . '" ' . implode( ' ', $custom_attributes ) . ' data-input-classes="' . esc_attr( implode( ' ', $args['input_class'] ) ) . '"/>';

        }

        break;
      case 'textarea':
        $field .= '<textarea name="' . esc_attr( $key ) . '" class="input-text ' . esc_attr( implode( ' ', $args['input_class'] ) ) . '" id="' . esc_attr( $args['id'] ) . '" placeholder="' . esc_attr( $args['placeholder'] ) . '" ' . ( empty( $args['custom_attributes']['rows'] ) ? ' rows="2"' : '' ) . ( empty( $args['custom_attributes']['cols'] ) ? ' cols="5"' : '' ) . implode( ' ', $custom_attributes ) . '>' . esc_textarea( $value ) . '</textarea>';

        break;
      case 'checkbox':
        $field = '<label class="checkbox ' . implode( ' ', $args['label_class'] ) . '" ' . implode( ' ', $custom_attributes ) . '>
            <input type="' . esc_attr( $args['type'] ) . '" class="input-checkbox ' . esc_attr( implode( ' ', $args['input_class'] ) ) . '" name="' . esc_attr( $key ) . '" id="' . esc_attr( $args['id'] ) . '" value="1" ' . checked( $value, 1, false ) . ' /> ' . $args['label'] . $required . '</label>';

        break;
      case 'text':
      case 'password':
      case 'datetime':
      case 'datetime-local':
      case 'date':
      case 'month':
      case 'time':
      case 'week':
      case 'number':
      case 'email':
      case 'url':
      case 'tel':
      if ($key == "billing_phone") {
        $field .= '<input type="' . esc_attr( $args['type'] ) . '" class="input-text phone-number ' . esc_attr( implode( ' ', $args['input_class'] ) ) . '" name="' . esc_attr( $key ) . '" id="' . esc_attr( $args['id'] ) . '" placeholder="' . esc_attr( $args['placeholder'] ) . '"  value="' . esc_attr( $value ) . '" ' . implode( ' ', $custom_attributes ) . ' />
        <input type="hidden" class="input-text" value="'.$primaryPhoneCode.'" name="' . esc_attr( $key ) . '_code" />';
      }else{
        $field .= '<input type="' . esc_attr( $args['type'] ) . '" class="input-text ' . esc_attr( implode( ' ', $args['input_class'] ) ) . '" name="' . esc_attr( $key ) . '" id="' . esc_attr( $args['id'] ) . '" placeholder="' . esc_attr( $args['placeholder'] ) . '"  value="' . esc_attr( $value ) . '" ' . implode( ' ', $custom_attributes ) . ' />';
      }

        break;
      case 'select':
        $field   = '';
        $options = '';

        if ( ! empty( $args['options'] ) ) {
          foreach ( $args['options'] as $option_key => $option_text ) {
            if ( '' === $option_key ) {
              // If we have a blank option, select2 needs a placeholder.
              if ( empty( $args['placeholder'] ) ) {
                $args['placeholder'] = $option_text ? $option_text : __( 'Choose an option', 'woocommerce' );
              }
              $custom_attributes[] = 'data-allow_clear="true"';
            }
            $options .= '<option value="' . esc_attr( $option_key ) . '" ' . selected( $value, $option_key, false ) . '>' . esc_attr( $option_text ) . '</option>';
          }

          $field .= '<select name="' . esc_attr( $key ) . '" id="' . esc_attr( $args['id'] ) . '" class="select ' . esc_attr( implode( ' ', $args['input_class'] ) ) . '" ' . implode( ' ', $custom_attributes ) . ' data-placeholder="' . esc_attr( $args['placeholder'] ) . '">
              ' . $options . '
            </select>';
        }

        break;
      case 'radio':
        $label_id .= '_' . current( array_keys( $args['options'] ) );

        if ( ! empty( $args['options'] ) ) {
          foreach ( $args['options'] as $option_key => $option_text ) {
            $field .= '<input type="radio" class="input-radio ' . esc_attr( implode( ' ', $args['input_class'] ) ) . '" value="' . esc_attr( $option_key ) . '" name="' . esc_attr( $key ) . '" ' . implode( ' ', $custom_attributes ) . ' id="' . esc_attr( $args['id'] ) . '_' . esc_attr( $option_key ) . '"' . checked( $value, $option_key, false ) . ' />';
            $field .= '<label for="' . esc_attr( $args['id'] ) . '_' . esc_attr( $option_key ) . '" class="radio ' . implode( ' ', $args['label_class'] ) . '">' . $option_text . '</label>';
          }
        }

        break;
    }

    if ( ! empty( $field ) ) {
      $field_html = '';

      if ( $args['label'] && 'checkbox' !== $args['type'] ) {
        $field_html .= '<label for="' . esc_attr( $label_id ) . '" class="' . esc_attr( implode( ' ', $args['label_class'] ) ) . '">' . $args['label'] . $required . '</label>';
      }

      $field_html .= '<span class="woocommerce-input-wrapper">' . $field;

      if ( $args['description'] ) {
        $field_html .= '<span class="description" id="' . esc_attr( $args['id'] ) . '-description" aria-hidden="true">' . wp_kses_post( $args['description'] ) . '</span>';
      }

      $field_html .= '</span>';

      $container_class = esc_attr( implode( ' ', $args['class'] ) );
      $container_id    = esc_attr( $args['id'] ) . '_field';
      $field           = sprintf( $field_container, $container_class, $container_id, $field_html );
    }

    /**
     * Filter by type.
     */
    $field = apply_filters( 'woocommerce_form_field_' . $args['type'], $field, $key, $args, $value );

    /**
     * General filter on form fields.
     *
     * @since 3.4.0
     */
    $field = apply_filters( 'woocommerce_form_field', $field, $key, $args, $value );

    if ( $args['return'] ) {
      return $field;
    } else {
      echo $field; // WPCS: XSS ok.
    }
  }
}


add_action( 'woocommerce_checkout_update_order_meta', 'my_custom_checkout_field_update_order_meta' );

function my_custom_checkout_field_update_order_meta( $order_id ) {

    if ( ! empty( $_POST['billing_phone_code'] ) ) {
      update_post_meta( $order_id, 'billing_phone_code', sanitize_text_field( $_POST['billing_phone_code'] ) );

      if (is_user_logged_in()) {
        global $current_user;
        $userId = $current_user->ID;
        $primaryPhoneCode = update_user_meta($userId, 'primary_phone_country_code', sanitize_text_field( $_POST['billing_phone_code'] ));
      }
    }
}


// define the woocommerce_my_account_my_address_formatted_address callback 
function filter_woocommerce_my_account_my_address_formatted_address( $array, $customer_id, $name ) {
  $countryPhoneCode = json_decode(file_get_contents(__DIR__."/../lib/countryPhoneCode.json"));
  $primaryPhoneNumberCode = get_user_meta($customer_id, 'primary_phone_country_code', true);
  $primaryPhoneNumber = $array['phone'];
  if(!empty($primaryPhoneNumberCode) && !empty($primaryPhoneNumber)){
    $count = sizeof($countryPhoneCode);
    $i = 0;
    while ($i < $count) {
      if($countryPhoneCode[$i]->iso2 == $primaryPhoneNumberCode){
        $code = $countryPhoneCode[$i]->dialCode;
        $primaryPhoneNumber = "+".$code."-".$primaryPhoneNumber;
        break;
      }
      $i++;
    }
  }

  $array['phone'] = $primaryPhoneNumber;
  return $array; 
}; 
         
// add the filter 
add_filter( 'woocommerce_my_account_my_address_formatted_address', 'filter_woocommerce_my_account_my_address_formatted_address', 10, 3 );