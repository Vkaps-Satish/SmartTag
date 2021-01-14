<?php
/**
 * Cart Page
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.3.8
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

wc_print_notices();

do_action( 'woocommerce_before_cart' ); 
wp_enqueue_script('iosSlider'); ?>

<form action="<?php echo esc_url( wc_get_cart_url() ); ?>" method="post">

<div class="row">
<div class="col span_8">
<?php do_action( 'woocommerce_before_cart_table' ); ?>
<div class="table-responsive">
	<table class="shop_table cart" cellspacing="0">
		<thead>
			<tr>
				<th class="product-thumb-th"><?php _e( 'Product', 'woocommerce' ); ?></th>
				<th class="product-name"><?php _e( 'Description', 'woocommerce' ); ?></th>
				<th class="product-price"><?php _e( 'Quantity', 'woocommerce' ); ?></th>
				<th class="product-remove"><?php _e( 'Remove', 'woocommerce' ); ?></th>
				<th class="product-quantity"><?php _e( 'Price', 'woocommerce' ); ?></th>
				<!-- <th class="product-subtotal"><?php _e( 'Total', 'woocommerce' ); ?></th> -->
			</tr>
		</thead>
		<tbody>
			<?php do_action( 'woocommerce_before_cart_contents' ); ?>

			<?php
			foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
				$_product     = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
				$product_id   = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );

				if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
					?>
					<tr class="<?php echo esc_attr( apply_filters( 'woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key ) ); ?>">

						<td class="product-thumbnail">
							<?php
								$productId = $cart_item['product_id'];
								if ($productId == 6089 || $productId == 7722) {
						            $class = 'brass-product';
						        }else{
						            $class = 'aluminum-product';
						        }
								if ($productId ==  6033 || $productId == 6089 || $productId == 7722 || $productId == 7659) {
									echo '<div class="row '.$class.'"></row>';
								}else{
									$thumbnail = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key );

									if ( ! $_product->is_visible() )
										echo $thumbnail;
									else
										printf( '<a href="%s">%s</a>', $_product->get_permalink(), $thumbnail );
								}							
							?>
						</td>

						<td class="product-name">
							<?php
								if ( ! $_product->is_visible() )
									echo apply_filters( 'woocommerce_cart_item_name', $_product->get_title(), $cart_item, $cart_item_key );
								else
									echo apply_filters( 'woocommerce_cart_item_name', sprintf( '<a href="%s">%s</a>', $_product->get_permalink(), $_product->get_title() ), $cart_item, $cart_item_key );

								// Meta data
								echo WC()->cart->get_item_data( $cart_item );

	               				// Backorder notification
	               				if ( $_product->backorders_require_notification() && $_product->is_on_backorder( $cart_item['quantity'] ) )
	               					echo '<p class="backorder_notification">' . __( 'Available on backorder', 'woocommerce' ) . '</p>';

	               				$product_item = $cart_item['data'];
	               				if (isset($cart_item['customPetDetail']) && !empty($cart_item['customPetDetail'])) { ?>
	               					<dl class="extra-detail variation">
										<dt class="variation-PetName">Pet Name:</dt>
										<dd class="variation-PetName"><p><?php echo $cart_item['customPetDetail']['petName']; ?></p></dd>
										<!-- <dt class="variation-PetId">Pet Id:</dt>
										<dd class="variation-PetId"><p><?php echo $cart_item['customPetDetail']['petId']; ?></p></dd> -->
									</dl>
	               				<?php }?>
						</td>

						<td class="product-quantity">
							<?php
								if ( $_product->is_sold_individually() ) {
									$product_quantity = sprintf( '1 <input type="hidden" name="cart[%s][qty]" value="1" />', $cart_item_key );
								} else {
									$product_quantity = woocommerce_quantity_input( array(
										'input_name'  => "cart[{$cart_item_key}][qty]",
										'input_value' => $cart_item['quantity'],
										'max_value'   => $_product->backorders_allowed() ? '' : $_product->get_stock_quantity(),
										'min_value'   => '0'
									), $_product, false );
								}

								echo apply_filters( 'woocommerce_cart_item_quantity', $product_quantity, $cart_item_key, $cart_item );
							?>
						</td>

						<td class="product-remove">
							<?php
								echo apply_filters( 'woocommerce_cart_item_remove_link', sprintf( '<a href="%s" class="site-btn site-btn-red" title="%s">Remove</a>', esc_url( WC()->cart->get_remove_url( $cart_item_key ) ), __( 'Remove this item', 'woocommerce' ) ), $cart_item_key );
							?>
						</td>

						<td class="product-price">
							<?php
							// print_r($cart_item); 
							if ($cart_item['attribute_pa_plan'] == "lifetime") {
								echo '<span class="woocommerce-Price-amount amount"><span class="woocommerce-Price-currencySymbol">$</span>'.$cart_item['line_total'].'</span>';
							}else{
								echo apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key );
							}
							?>
						</td>


						<!-- <td class="product-subtotal">
							<?php
								echo apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key );
							?>
						</td> -->
					</tr>
					<?php
				}
			}

			do_action( 'woocommerce_cart_contents' );
			?>
			<tr>
				<td colspan="6" class="actions">

					<?php if ( WC()->cart->coupons_enabled() ) { ?>
						<div class="coupon">

							<label for="coupon_code"><?php _e( 'Coupon', 'woocommerce' ); ?>:</label> <input type="text" name="coupon_code" class="input-text" id="coupon_code" value="" placeholder="<?php _e( 'Coupon code', 'woocommerce' ); ?>" /> <input type="submit" class="button" name="apply_coupon" value="<?php _e( 'Apply Coupon', 'woocommerce' ); ?>" />

							<?php do_action('woocommerce_cart_coupon'); ?>

						</div>
					<?php } ?>

					
				</td>
			</tr>

			<?php do_action( 'woocommerce_after_cart_contents' ); ?>
		</tbody>
	</table>
</div>



<?php do_action( 'woocommerce_cart_collaterals' ); ?>

</div><!--/span-8-->

<div class="col span_4">

	<div class="cart-collaterals">
		<?php global $woocommerce; ?>
		<?php woocommerce_cart_totals(); ?>
		<?php woocommerce_shipping_calculator(); ?>
		<a class="button emptycart" href="<?php echo esc_url( wc_get_cart_url() ); ?>?empty-cart"><?php _e( 'Empty Cart', 'woocommerce' ); ?></a>
		<input type="submit" class="button" name="update_cart" value="<?php _e( 'Update Cart', 'woocommerce' ); ?>" /> 

		<?php 
		
		if(!version_compare( $woocommerce->version, '2.6', ">=" )) { ?>
			<input type="submit" class="checkout-button button alt wc-forward" name="proceed" value="<?php _e( 'Proceed to Checkout', 'woocommerce' ); ?>" />
		<?php } else { ?>
			<div class="wc-proceed-to-checkout">
				<?php do_action( 'woocommerce_proceed_to_checkout' ); ?>
			</div>
		<?php } ?>

		<?php wp_nonce_field( 'woocommerce-cart' ); ?>

	</div>

</div><!--/span-4-->

</div><!--/row-->


<?php do_action( 'woocommerce_after_cart_table' ); ?>


</form>
<?php do_action( 'woocommerce_after_cart' ); ?>
<!-- 
<div class="frequently-cart-product mt-30 mb-30">
	<h3>Frequently Bought Together</h3>
	<ul class="products" data-product-style="classic">
	    <?php
	            $args = array( 'post_type' => 'product', 'posts_per_page' => 4, 'product_cat' => 'microchip-scanners', 'orderby' => 'rand' );
	            $loop = new WP_Query( $args );
	            while ( $loop->have_posts() ) : $loop->the_post(); global $product; 
	            ?>
	     <li class="classic post-8054 product type-product status-publish has-post-thumbnail product_cat-id-tags-products-microchips-and-scanners first instock shipping-taxable purchasable product-type-simple">
	        <div class="product-wrap">
	           <a href="<?php echo get_permalink( $loop->post->ID ) ?>" title="<?php echo esc_attr($loop->post->post_title ? $loop->post->post_title : $loop->post->ID); ?>">
	              <?php if (has_post_thumbnail( $loop->post->ID )) echo get_the_post_thumbnail($loop->post->ID, 'shop_catalog'); else echo '<img src="'.woocommerce_placeholder_img_src().'" alt="Placeholder" width="150" height="150" />'; ?>
	              <h2 class="woocommerce-loop-product__title"><?php the_title(); ?></h2>
	              <span class="price"><span>Price: </span><span class="woocommerce-Price-amount amount"><?php echo $product->get_price_html(); ?></span></span>
	           </a>
	           <?php woocommerce_template_loop_add_to_cart( $loop->post, $product); ?>
	        </div>
	     </li>
	     <?php endwhile; ?>
	        <?php wp_reset_query(); ?>
	</ul>
</div> -->
<script type="text/javascript">
	jQuery(document).ready(function($){
		/*jQuery('dl.variation .variation-FrontImage p img').each(function(){
			var img = jQuery(this).attr('src');
			jQuery(this).parent().parent().parent().parent().parent().find('td.product-thumbnail > .row').append('<div class="col-sm-6 rmb-15 cart-front-img text-center"><h4>Front</h4><img src="'+img+'"/></div>');			
			
		});
		jQuery('dl.variation .variation-BackImage p img').each(function(){
			var img = jQuery(this).attr('src');
			jQuery(this).parent().parent().parent().parent().parent().find('td.product-thumbnail > .row').append('<div class="col-sm-6 cart-back-img text-center"><h4>Back</h4><img src="'+img+'"/></div>');
			
			
		});
		jQuery(".emptycart").click(function(){
			var r = confirm("Are you sure you would like to remove all items from the cart?");
			if (r == true) {
			    return true;
			} else {
			    return false;
			}
		});*/
	});
		
</script>