<?php 
$user_id = get_current_user_id();
$paged = get_query_var('order-print-lost-pet-poster');
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
$i = 0;
if ($wp_query->have_posts()) {
	while ( $wp_query->have_posts() ) : $wp_query->the_post(); 
		$mypod = pods( 'pet_profile', get_the_id() ); 
		$smarttag_id_number = $mypod->display('smarttag_id_number');
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
               // $subscription = wc_get_order($subscriptionId);
               // print_r($subscription->get_items());
			foreach( $subscription->get_items() as $item_id => $product_subscription ){
                   // Get the name
				$product_name = $product_subscription['name']." (Expires: ".$date.")";

                   // print_r($product_subscription);
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
					<strong>ID Tag Plan:</strong> <span><?php echo $product_name; ?></span>
				</div>
				<div class="col-sm-4 mb-elements">
					<form action="<?php echo get_site_url(); ?>/my-account/order-print-lost-pet-poster-form" method="post" class="custom-form">
						<input type="hidden" name="post_id" value="<?php echo get_the_ID(); ?>">
						<input type="hidden" name="smarttagid" value="<?php echo $smarttag_id_number; ?>">
						<p><a href="/my-account/order-print-lost-pet-poster-form/?pet_id=<?php echo get_the_id(); ?>" class="site-btn btn site-btn-red width-100"><strong>Print Lost Pet Poster</strong> <i class="fa fa-caret-right"></i></a></p>
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
	}?>
	<?php
} else{
	echo '<div class="no-found">Sorry, No pet found </div> <br>        
	<div class="redirect-btn">
	<a class="site-btn site-btn-red" href="https://prelaunch.idtag.com/my-account/add-pet-id-my-account/"> Please Register Your Pet <i class="fa fa-caret-right"></i></a>
	</div>';
}