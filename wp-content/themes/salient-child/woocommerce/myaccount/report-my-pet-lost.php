<?php 
if (isset($_POST['action']) && $_POST['action'] = 'updatePostStatusAndPetStatus') {
 $postid = $_POST['related_post_id'];
 update_post_meta($postid,'pet_status',0);
 pet_has_found_reunited_and_return_in_area($_POST['related_post_id']);
 $args=array(
   'post_type' => 'found_pet',
   'post_status' => 'publish',

   'meta_query'=>array(
     'relation' => 'AND',
     array(
       'key' => 'related_post_id',
       'value' => $postid,
     ),
   )
 );
 $out = new WP_Query($args);
 while ( $out->have_posts() ) : $out->the_post();
   $post_id = get_the_id();
   if ($post_id != $_POST['post_id']) {
     $my_post = array(
       'ID'           => $post_id,
       'post_status'   => 'draft',
     );
     wp_update_post( $my_post );
   }else{
     update_post_meta($post_id,'approve_status',1);
   }
 endwhile;

}
$user_id = get_current_user_id();
 //var_dump(get_query_var('report-my-pet-lost'));
$paged = get_query_var('report-my-pet-lost');
if($paged){
  $paged = explode("page/", $paged);
  $paged = $paged[1];
}else{
  $paged = 1;
}
$args=array(
 'post_type' => 'pet_profile',
 'posts_per_page' => 10,
 'paged' => $paged,
 'author' => $user_id
);                       
$wp_query = new WP_Query($args);
 //var_dump($wp_query->get_query_var('paged'));
$i = 0;
if ($wp_query->have_posts()) {
  while ( $wp_query->have_posts() ) : $wp_query->the_post(); 
   $mypod = pods( 'pet_profile', get_the_id() ); 
   $smarttag_id_number = $mypod->display('smarttag_id_number');
   $subscriptionId  = $mypod->display("smarttag_subscription_id");
   if ($subscriptionId) {
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
        $product_name = $product_subscription['name']." (Expires: ".$enddate.")";
        $variationId  = $product_subscription['variation_id'];
      }
    }
  }else{
    $product_name = '';
    $startDate    = '';
    $date         = '';
  }

  $lastModifyDates = get_post_meta(get_the_id(), 'last_lost_date');

  if (isset($lastModifyDates[0])) {
    $date = date_parse_from_format('Y:m:d H:i:s',$lastModifyDates[0]);
    $date = mktime(0, 0, 0, $date['month'], $date['day'], $date['year']);
    $lastModifyDate = date("m/d/Y", $date);
  }else{
    $lastModifyDate = "";
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
        <strong>ID Tag Plan:</strong> <span><?php echo $product_name; ?></span>
      </div>
      <div class="col-sm-4 mb-elements">
        <form action="" method="post" class="custom-form">
          <input type="hidden" name="startDate" value="<?php echo $startDate; ?>">
          <input type="hidden" name="endDate" value="<?php echo $enddate; ?>">
          <input type="hidden" name="post_id" value="<?php echo get_the_ID(); ?>">
          <input type="hidden" name="smarttagid" value="<?php echo $smarttag_id_number; ?>">
          <?php
          $check = checkSmartIDTag(1,'lost_found_pets','pet_status','smarttag_id_number',$smarttag_id_number);

          if ($check) {
            echo '<p><a href="/my-account/report-pet-lost/?pet_id='.get_the_ID().'" class="site-btn-red btn site-btn">Report Pet As Lost <i class="fa fa-caret-right"></i></a></p>';
          }else{
            echo '<p class="last-modify-date">REPORTED AS LOST ON: '.$lastModifyDate.' </p><input type="hidden" name="smarttag_id_number" value="'.$smarttag_id_number.'"><input type="hidden" name="report_pet_as_found" value="1"><p><a href="/my-account/report-pet-found-list/?pet_id='.get_the_ID().'" class="site-btn-light-blue btn site-btn">Report Pet As Found &nbsp;<i class="fa fa-caret-right"></i></a></p>';
          }
          ?>
          <a href="/my-account/show-profile/?pet_id=<?php echo get_the_ID(); ?>" class="light-blue-link"><strong>View/Edit Full Pet Profile </strong><i class="fa fa-caret-right"></i></a>
        </form>
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
?>
<script type="text/javascript">
 jQuery(document).ready(function(){
   jQuery('.report-pet-as-lost').on('click',function(){
     jQuery(this).parent('.custom-form').attr("action","<?php echo get_site_url(); ?>/my-account/report-pet-lost");
     jQuery(this).parent('form.custom-form').submit();
   });
   jQuery('.report-pet-as-found').on('click',function(){
     jQuery(this).parent('.custom-form').attr("action","<?php echo get_site_url(); ?>/my-account/report-pet-found-list");
     jQuery(this).parent('form.custom-form').submit();
   });
 });
</script>
<?php  
}else{
 echo '<div class="no-found">Sorry, No pet found </div> <br>        
 <div class="redirect-btn">
 <a class="site-btn site-btn-red" href="https://prelaunch.idtag.com/my-account/add-pet-id-my-account/"> Please Register Your Pet <i class="fa fa-caret-right"></i></a>
 </div>';
}