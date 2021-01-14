<?php
/**
 * Review order table
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/review-order.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.3.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$check = 0;
if (isset(wc()->cart->cart_contents) && !empty(wc()->cart->cart_contents)) {
	foreach (wc()->cart->cart_contents as $value) {
		if ($value['product_id'] == 7722 || $value['product_id'] == 7659) {
			$check = 1;
		}
	}
}
?>
<div class="woocommerce-checkout-review-order-table">
	<div class="table-responsive">
	<!-- <table class="shop_table woocommerce-checkout-review-order-table"> -->
		<table class="shop_table cart">
			<thead>
				<tr>
					<th class="product-thumb-th"><?php _e( 'Product', 'woocommerce' ); ?></th>
					<th class="product-name"><?php _e( 'Description', 'woocommerce' ); ?></th>
					<th class="product-quantity"><?php _e( 'Price', 'woocommerce' ); ?></th>
				</tr>
			</thead>
			<tbody>
				<?php
					do_action( 'woocommerce_review_order_before_cart_contents' );

					foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {

						$_product     = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );

						if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_checkout_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
							?>
							<tr class="<?php echo esc_attr( apply_filters( 'woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key ) ); ?>">
								<!-- <td class="product-name">
									<?php echo apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key ) . '&nbsp;'; ?>
									<?php echo apply_filters( 'woocommerce_checkout_cart_item_quantity', ' <strong class="product-quantity">' . sprintf( '&times; %s', $cart_item['quantity'] ) . '</strong>', $cart_item, $cart_item_key ); ?>
									<?php echo WC()->cart->get_item_data( $cart_item ); ?>
								</td>
								<td class="product-total">
									<?php echo apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key ); ?>
								</td> -->
								<td class="product-thumbnail">
									<?php
										$productId = $cart_item['product_id'];
										if ($productId == 6089 || $productId == 7722) {
								            $class = 'brass-product';
								        }else{
								            $class = 'aluminum-product';
								        }
										if ($productId ==  '6033' || $productId == '6089' || $productId == '7722' || $productId == '7659') {
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

									/*echo apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key ) . '&nbsp;'; ?>
							<?php echo apply_filters( 'woocommerce_checkout_cart_item_quantity', ' <strong class="product-quantity">' . sprintf( '&times; %s', $cart_item['quantity'] ) . '</strong>', $cart_item, $cart_item_key ); ?>
							<?php echo wc_get_formatted_cart_item_data( $cart_item );*/ 
									if ( ! $_product->is_visible() )
										echo apply_filters( 'woocommerce_cart_item_name', $_product->get_title(), $cart_item, $cart_item_key );
									else
										echo apply_filters( 'woocommerce_cart_item_name', sprintf( '<a href="%s">%s</a>', $_product->get_permalink(), $_product->get_title() ), $cart_item, $cart_item_key );

										echo apply_filters( 'woocommerce_checkout_cart_item_quantity', ' <strong class="product-quantity">' . sprintf( '&times; %s', $cart_item['quantity'] ) . '</strong>', $cart_item, $cart_item_key );
									

									// Meta data
									echo WC()->cart->get_item_data( $cart_item );

		               				// Backorder notification
		               				if ( $_product->backorders_require_notification() && $_product->is_on_backorder( $cart_item['quantity'] ) )
		               					echo '<p class="backorder_notification">' . __( 'Available on backorder', 'woocommerce' ) . '</p>';


				               		if (isset($cart_item['info']) && !empty($cart_item)) { 
				               			$cart_item_infos = $cart_item['info'];
				               			foreach ($cart_item_infos as $key => $cart_item_info) {?>
			               					<div class="cart-extra-info">
			               						<div class="item item-<?php echo $key+1; ?>">
			               							<div class="user-info">
			               								<div class="title"><h4>User Info:- </h4></div>
			               								<div class="row">
			               									<div class="col-sm-4 font-bold">Name: </div>
			               									<div class="col-sm-8 break-word"><?php echo $cart_item_info['firstName']." ".$cart_item_info['lastName']; ?></div>
			               								</div>
			               								<div class="row">
			               									<div class="col-sm-4 font-bold">Email: </div>
			               									<div class="col-sm-8 break-word"><?php echo $cart_item_info['email']; ?></div>
			               								</div>
			               							</div>
			               							<div class="pet-info">
			               								<div class="title"><h4>Pet Info:- </h4></div>
			               								<div class="row">
			               									<div class="col-sm-4 font-bold">Name: </div>
			               									<div class="col-sm-8 break-word"><?php echo $cart_item_info['petName']; ?></div>
			               								</div>
			               								<div class="row">
			               									<div class="col-sm-4 font-bold">Company: </div>
			               									<div class="col-sm-8 break-word"><?php echo $cart_item_info['microCm']; ?></div>
			               								</div>
			               								<div class="row">
			               									<div class="col-sm-4 font-bold">Microchip Id: </div>
			               									<div class="col-sm-8 break-word"> <?php echo $cart_item_info['microId']; ?></div>
			               								</div>
			               							</div>
			               						</div>
			               					</div>
		               					<?php }
		               				}
		               				if (isset($cart_item['customPetDetail']) && !empty($cart_item['customPetDetail'])) { ?>
		               					<div class="title"><h4>Pet Info:- </h4></div>
		               					<dl class="extra-detail variation">
											<dt class="variation-PetName">Pet Name:</dt>
											<dd class="variation-PetName"><p><?php echo $cart_item['customPetDetail']['petName']; ?></p></dd>
										</dl>
	               				<?php }?>
								</td>

								<td class="product-price">
									<?php
									if ($cart_item['attribute_pa_plan'] == "lifetime") {
										echo '<span class="woocommerce-Price-amount amount"><span class="woocommerce-Price-currencySymbol">$</span>'.$cart_item['line_total'].'</span>';
									}else{
										echo apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key );
									}
										// echo apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key );
									?>
								</td>
							</tr>
							<?php
						}
					}

					do_action( 'woocommerce_review_order_after_cart_contents' );
				?>

				<!-- <tr class="cart-subtotal">
					<td colspan="2"><strong><?php _e( 'Subtotal', 'woocommerce' ); ?></strong></td>
					<td><?php wc_cart_totals_subtotal_html(); ?></td>
				</tr>

				<?php foreach ( WC()->cart->get_coupons() as $code => $coupon ) : ?>
					<tr class="cart-discount coupon-<?php echo esc_attr( sanitize_title( $code ) ); ?>">
						<td colspan="2"><strong><?php wc_cart_totals_coupon_label( $coupon ); ?></strong></td>
						<td><?php wc_cart_totals_coupon_html( $coupon ); ?></td>
					</tr>
				<?php endforeach; ?>

				<?php foreach ( WC()->cart->get_fees() as $fee ) : ?>
					<tr class="fee">
						<td colspan="2"><strong><?php echo esc_html( $fee->name ); ?></strong></td>
						<td><?php wc_cart_totals_fee_html( $fee ); ?></td>
					</tr>
				<?php endforeach; ?>

				<?php if ( wc_tax_enabled() && 'excl' === WC()->cart->tax_display_cart ) : ?>
					<?php if ( 'itemized' === get_option( 'woocommerce_tax_total_display' ) ) : ?>
						<?php foreach ( WC()->cart->get_tax_totals() as $code => $tax ) : ?>
							<tr class="tax-rate tax-rate-<?php echo sanitize_title( $code ); ?>">
								<td colspan="2"><strong><?php echo esc_html( $tax->label ); ?></strong></td>
								<td><?php echo wp_kses_post( $tax->formatted_amount ); ?></td>
							</tr>
						<?php endforeach; ?>
					<?php else : ?>
						<tr class="tax-total">
							<td colspan="2"><strong><?php echo esc_html( WC()->countries->tax_or_vat() ); ?></strong></td>
							<td><?php wc_cart_totals_taxes_total_html(); ?></td>
						</tr>
					<?php endif; ?>
				<?php endif; ?>

				<?php do_action( 'woocommerce_review_order_before_order_total' ); ?>

				<tr class="order-total">
					<td colspan="2"><strong><?php _e( 'Total', 'woocommerce' ); ?></strong></td>
					<td><?php wc_cart_totals_order_total_html(); ?></td>
				</tr> -->

				<?php do_action( 'woocommerce_review_order_after_order_total' ); ?>
			</tbody>
		</table>
	</div>
	<div class="select-shipping-wrap">
		<div class="row">
			<div class="col-sm-9 rmb-30">
				<h3>Select Shipping Method:</h3>
				<?php if ( WC()->cart->needs_shipping() && WC()->cart->show_shipping() ) : ?>

					<?php do_action( 'woocommerce_review_order_before_shipping' ); ?>

					<?php wc_cart_totals_shipping_html(); ?>

					<?php do_action( 'woocommerce_review_order_after_shipping' ); ?>

				<?php endif; ?>
			</div>
			<div class="col-sm-3">
				<h3>Order Summary:</h3>
				<div class="table-responsive order-summary-table">
					<table>
						<tr>
							<th>Subtotal:</th>
							<td><?php wc_cart_totals_subtotal_html(); ?></td>
						</tr>
						<?php foreach ( WC()->cart->get_coupons() as $code => $coupon ) : ?>
							<tr class="cart-discount coupon-<?php echo esc_attr( sanitize_title( $code ) ); ?>">
								<th>Discount:</th>
								<td><?php wc_cart_totals_coupon_html( $coupon ); ?></td>
							</tr>
						<?php endforeach; ?>

						<?php foreach ( WC()->cart->get_fees() as $fee ) : ?>
							<tr class="fee">
								<th><?php echo esc_html( $fee->name ); ?></th>
								<td><?php wc_cart_totals_fee_html( $fee ); ?></td>
							</tr>
						<?php endforeach; ?>
						
						<?php if ( WC()->cart->needs_shipping() && WC()->cart->show_shipping() ) : ?>
								<th>Shipping:</th>
								<td id="custom-shipping-amount"></td>
						<?php endif; ?>
						<?php if ( wc_tax_enabled() && 'excl' === WC()->cart->tax_display_cart ) : ?>
							<?php if ( 'itemized' === get_option( 'woocommerce_tax_total_display' ) ) : ?>
								<?php foreach ( WC()->cart->get_tax_totals() as $code => $tax ) : ?>
									<tr class="tax-rate tax-rate-<?php echo sanitize_title( $code ); ?>">
										<th>Tax:</th>
										<td><?php echo wp_kses_post( $tax->formatted_amount ); ?></td>
									</tr>
								<?php endforeach; ?>
							<?php else : ?>
								<tr class="tax-total">
									<td colspan="2"><strong><?php echo esc_html( WC()->countries->tax_or_vat() ); ?></strong></td>
									<td><?php wc_cart_totals_taxes_total_html(); ?></td>
								</tr>
							<?php endif; ?>
						<?php endif; ?>
						<tr>
							<th>Total:</th>
							<td><?php wc_cart_totals_order_total_html(); ?></td>
						</tr>
					</table>
				</div>
			</div>
		</div>		
	</div>
</div>
<script type="text/javascript">
	jQuery(document).ready(function($){
		jQuery('dl.variation .variation-FrontImage p img').each(function(){
			var img = jQuery(this).attr('src');
			jQuery(this).parent().parent().parent().parent().parent().find('td.product-thumbnail > .row').append('<div class="col-sm-6 rmb-15 cart-front-img text-center"><h4>Front</h4><img src="'+img+'"/></div>');
		});
		jQuery('dl.variation .variation-BackImage p img').each(function(){
			var img = jQuery(this).attr('src');
			jQuery(this).parent().parent().parent().parent().parent().find('td.product-thumbnail > .row').append('<div class="col-sm-6 cart-back-img text-center"><h4>Back</h4><img src="'+img+'"/></div>');			
		});
		$("tr.cart_item").each(function(){
			console.log($(this).find("dl.variation dd.variation-SelectSize").text().toLowerCase());
			if($.trim($(this).find("dl.variation dd.variation-SelectSize").text().toLowerCase()) == 'small'){
				console.log("small");
				$(this).find("td.product-thumbnail img").attr('style', 'width: 75% !important');
			}else{
				$(this).find("td.product-thumbnail img").attr('style', 'width: 100% !important');
			}
		});
	});	
	jQuery(document).ready(function(){
		jQuery(".cart_item").each(function(){
			jQuery(this).children().children("dl.variation").children("dd.variation-FrontLine1, dt.variation-FrontLine1").wrapAll("<div class='variation-frontlines1'></div>");
			jQuery(this).children().children("dl.variation").children("dd.variation-FrontLine2, dt.variation-FrontLine2").wrapAll("<div class='variation-frontlines2'></div>");
			jQuery(this).children().children("dl.variation").children("dd.variation-FrontLine3, dt.variation-FrontLine3").wrapAll("<div class='variation-frontlines3'></div>");
			jQuery(this).children().children("dl.variation").children("dd.variation-FrontLine4, dt.variation-FrontLine4").wrapAll("<div class='variation-frontlines4'></div>");

			jQuery(this).children().children("dl.variation").children(".variation-frontlines1, .variation-frontlines2, .variation-frontlines3, .variation-frontlines4").wrapAll("<div class='variation-frontlines-wrap'></div>");

			jQuery(this).children().children("dl.variation").children("dd.variation-BackLine1, dt.variation-BackLine1").wrapAll("<div class='variation-backlines1'></div>");
			jQuery(this).children().children("dl.variation").children("dd.variation-BackLine2, dt.variation-BackLine2").wrapAll("<div class='variation-backlines2'></div>");
			jQuery(this).children().children("dl.variation").children("dd.variation-BackLine3, dt.variation-BackLine3").wrapAll("<div class='variation-backlines3'></div>");
			jQuery(this).children().children("dl.variation").children("dd.variation-BackLine4, dt.variation-BackLine4").wrapAll("<div class='variation-backlines4'></div>");

			jQuery(this).children().children("dl.variation").children(".variation-backlines1, .variation-backlines2, .variation-backlines3, .variation-backlines4").wrapAll("<div class='variation-backlines-wrap'></div>");

			var variation_frontlines_wrap = jQuery(this).children().children("dl.variation").children(".variation-frontlines-wrap").clone();

			jQuery(this).children(".product-thumbnail").children().children(".cart-front-img").prepend(variation_frontlines_wrap);

			var variation_backlines_wrap = jQuery(this).children().children("dl.variation").children(".variation-backlines-wrap").clone();

			jQuery(this).children(".product-thumbnail").children().children(".cart-back-img").prepend(variation_backlines_wrap);

		});
		//custom-shipping-amount
		var shipping = jQuery("body").find("select.shipping_method option:selected").text();
		if (shipping != "") {
			shipping = shipping.split(":");
			jQuery("#custom-shipping-amount").html(shipping[1]);
		}
	});	
</script>