<?php 
/*
* Template Name:  Pet Professional Main Page
*/
get_header(); 

//Redirect user if user not login or not petprofessional
if ( is_user_logged_in() ){
     $current_user = wp_get_current_user();
     $roles = $current_user->roles;  
     // print_r($roles);die;
       if( !$roles == 'pet_professional' || !in_array( 'pet_professional', $roles )){
         print('<div>
        		<div class="not-found-text width-100">This page is only for Pet-Professionals..</div></div>');
         die();
          }
}else{
		print('<script>window.location.href="'.get_site_url().'/pet-professionals-signup"</script>');     
    }
    ?>
<div class="container-wrap">		
	<div class="container main-content">
		<div class="row">
			<div class="col-sm-3 woo-sidebar">
				<!-- <h3 class="widgettitle">Pet Professional</h3> -->
				<!-- <?php echo do_shortcode("[wpb_childpages]"); ?> -->
				<?php echo do_shortcode("[stag_sidebar id='pet-professional-sidebar']"); ?>
				
		    </div>
			<div class="col-sm-9">
				<div class="row">
					<div class="col-sm-6">
						<div class="acc-blue-box">
							<div class="acc-blue-head">
								Order History
							</div>
							<div class="acc-blue-content">
								<div>
									Purchase Product: Product Name
									<br>
									Date
									<br>
									Price
									<br>
									<a href="#">Link</a>
								</div>
								<hr>
								<div>
									Purchase Product: Product Name
									<br>
									Date
									<br>
									Price
									<br>
									<a href="#">Link</a>
								</div>
								<hr>
								<div>
									Purchase Product: Product Name
									<br>
									Date
									<br>
									Price
									<br>
									<a href="#">Link</a>
								</div>
							</div>
						</div>
					</div>
					<div class="col-sm-6">
						<div class="acc-blue-box">
							<div class="acc-blue-head">
								Profile
							</div>
							<div class="acc-blue-content">
								<?php 
									$current_user = wp_get_current_user();				    
								    echo '<strong>Username:</strong> ' . $current_user->user_login . '<br />';
								    echo '<strong>User Email:</strong> ' . $current_user->user_email . '<br />';
								    echo '<strong>User First Name:</strong> ' . $current_user->user_firstname . '<br />';
								    echo '<strong>User Last Name:</strong> ' . $current_user->user_lastname . '<br />';
								    echo '<strong>User Display Name:</strong> ' . $current_user->display_name . '<br />';
								    echo '<strong>User ID:</strong> ' . $current_user->ID . '<br />';
								?>
							</div>
						</div>
					</div>	
				</div>
				<?php 
				//echo do_shortcode('[woocommerce_my_account order_count="12"]');
				

		//getting shipping
			// echo "$current_user->ID".$current_user->ID;
			// wp_mail("rohit@geeksperhour.com","get_user_meta",print_r('get_user_meta',true));
	  //       $fname = get_user_meta( $current_user->ID, 'first_name', true );
			// $lname = get_user_meta( $current_user->ID, 'last_name', true );
			// $address_1 = get_user_meta( $current_user->ID, 'billing_address_1', true ); 
			// $address_2 = get_user_meta( $current_user->ID, 'billing_address_2', true );
			// $city = get_user_meta( $current_user->ID, 'billing_city', true );
			// $postcode = get_user_meta( $current_user->ID, 'billing_postcode', true );

			// echo "fname".$fname . "<BR>";
			// echo "lname".$lname . "<BR>";
			// echo "address_1". $address_1 . "<BR>";
			// echo "address_2". $address_2 . "<BR>";
			// echo "city". $city . "<BR>";
			// echo "postcode". $postcode . "<BR>";

			//get orders details
			// 	    $order_id = 38740 ;
			// $order = wc_get_order($order_id);
				
			// Iterating through each WC_Order_Item_Product objects
			// foreach ($order->get_items() as $item_key => $item_values){
			//     ## Using WC_Order_Item methods ##

			//     // Item ID is directly accessible from the $item_key in the foreach loop or
			//     $item_id = $item_values->get_id();

			//     ## Using WC_Order_Item_Product methods ##

			//     $item_name = $item_values->get_name(); // Name of the product
			//     $item_type = $item_values->get_type(); // Type of the order item ("line_item")

			//     $product_id = $item_values->get_product_id(); // the Product id
			//     $product = $item_values->get_product(); // the WC_Product object

			//     ## Access Order Items data properties (in an array of values) ##
			//     $item_data = $item_values->get_data();

			//     echo "product_name".$product_name = $item_data['name'];
			//     $product_id = $item_data['product_id'];
			//     $variation_id = $item_data['variation_id'];
			//     echo "quantity".$quantity = $item_data['quantity'];
			//     $tax_class = $item_data['tax_class'];
			//     $line_subtotal = $item_data['subtotal'];
			//     $line_subtotal_tax = $item_data['subtotal_tax'];
			//     $line_total = $item_data['total'];
			//     $line_total_tax = $item_data['total_tax'];

			//     // Get data from The WC_product object using methods (examples)
			//     $product_type   = $product->get_type();
			//     $product_sku    = $product->get_sku();
			//     $product_price  = $product->get_price();
			//     $stock_quantity = $product->get_stock_quantity();

			// }
				?>
			</div>
		</div>
	</div>
</div>
<?php get_footer(); ?>

