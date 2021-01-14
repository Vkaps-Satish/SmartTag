<?php
/**
 * Thankyou page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/thankyou.php.
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
 * @version     3.2.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<div class="woocommerce-orders">

	<!-- <div class="page-heading">
		<h1>Order Confirmation</h1>
	</div> -->

	<div class="woo-order-content">
		<h3 class="color-light-blue no-border-head">Thank You! Your order has been received.</h3>
		<p><strong>Order Number:</strong> <?php echo $order->get_order_number(); ?>
			<br>
		A confirmation email has been sent to: <strong><?php echo $order->get_billing_email(); ?></strong>.
			<br>
		You will receive a shipping confirmation email shortly.</p>
		<p>If you have any questions about your order please <a href="/contact-us/">Contact Us</a>.</p>
		<!-- <div class="mb-30"></div>
		<h3 class="border-head">Order Summary</h3>
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
		</div> -->
	</div>

	<?php if ( $order ) : ?>

		<?php if ( $order->has_status( 'failed' ) ) : ?>

			<p class="woocommerce-notice woocommerce-notice--error woocommerce-thankyou-order-failed"><?php _e( 'Unfortunately your order cannot be processed as the originating bank/merchant has declined your transaction. Please attempt your purchase again.', 'woocommerce' ); ?></p>

			<p class="woocommerce-notice woocommerce-notice--error woocommerce-thankyou-order-failed-actions">
				<a href="<?php echo esc_url( $order->get_checkout_payment_url() ); ?>" class="button pay"><?php _e( 'Pay', 'woocommerce' ) ?></a>
				<?php if ( is_user_logged_in() ) : ?>
					<a href="<?php echo esc_url( wc_get_page_permalink( 'myaccount' ) ); ?>" class="button pay"><?php _e( 'My account', 'woocommerce' ); ?></a>
				<?php endif; ?>
			</p>

		<?php else : ?>

			<!-- <p class="woocommerce-notice woocommerce-notice--success woocommerce-thankyou-order-received"><?php echo apply_filters( 'woocommerce_thankyou_order_received_text', __( 'Thank you. Your order has been received.', 'woocommerce' ), $order ); ?></p>

			<ul class="woocommerce-order-overview woocommerce-thankyou-order-details order_details">

				<li class="woocommerce-order-overview__order order">
					<?php _e( 'Order number:', 'woocommerce' ); ?>
					<strong><?php echo $order->get_order_number(); ?></strong>
				</li>

				<li class="woocommerce-order-overview__date date">
					<?php _e( 'Date:', 'woocommerce' ); ?>
					<strong><?php echo wc_format_datetime( $order->get_date_created() ); ?></strong>
				</li>

				<?php if ( is_user_logged_in() && $order->get_user_id() === get_current_user_id() && $order->get_billing_email() ) : ?>
					<li class="woocommerce-order-overview__email email">
						<?php _e( 'Email:', 'woocommerce' ); ?>
						<strong><?php echo $order->get_billing_email(); ?></strong>
					</li>
				<?php endif; ?>

				<li class="woocommerce-order-overview__total total">
					<?php _e( 'Total:', 'woocommerce' ); ?>
					<strong><?php echo $order->get_formatted_order_total(); ?></strong>
				</li>

				<?php if ( $order->get_payment_method_title() ) : ?>
					<li class="woocommerce-order-overview__payment-method method">
						<?php _e( 'Payment method:', 'woocommerce' ); ?>
						<strong><?php echo wp_kses_post( $order->get_payment_method_title() ); ?></strong>
					</li>
				<?php endif; ?>

			</ul> -->

		<?php endif; ?>

		<?php /*do_action( 'woocommerce_thankyou_' . $order->get_payment_method(), $order->get_id() );*/ ?>
		<!-- <p>View the status of your order in <a href="https://idtag.agiliscloud.com/my-account/subscriptions/">your account</a>.</p> -->
		<?php do_action( 'woocommerce_thankyou', $order->get_id() ); ?>

	<?php else : ?>

		<p class="woocommerce-notice woocommerce-notice--success woocommerce-thankyou-order-received"><?php echo apply_filters( 'woocommerce_thankyou_order_received_text', __( 'Thank you. Your order has been received.', 'woocommerce' ), null ); ?></p>

	<?php endif; ?>

</div>
<!-- <script type="text/javascript">
	jQuery(document).ready(function(){
		jQuery('dl.variation .variation-FrontImage p img').each(function(){
			var img = jQuery(this).attr('src');
			jQuery(this).parent().parent().parent().parent().parent().find('td.product-thumbnail > .row').append('<div class="col-sm-6 rmb-15 cart-front-img text-center"><h4>Front</h4><img src="'+img+'"/></div>');			
			
		});
		jQuery('dl.variation .variation-BackImage p img').each(function(){
			var img = jQuery(this).attr('src');
			jQuery(this).parent().parent().parent().parent().parent().find('td.product-thumbnail > .row').append('<div class="col-sm-6 cart-back-img text-center"><h4>Back</h4><img src="'+img+'"/></div>');
			
			
		});
	});
		
</script> -->
<?php if (is_user_logged_in()) { ?>
		<script type="text/javascript">
			jQuery(document).ready(function(){
				jQuery('#order_review .variation-AddPetProfile').show();
				jQuery('#order_review .variation-AddPetProfile div').show();
			});
		</script>
<? }else{ ?>
		<script type="text/javascript">
			jQuery(document).ready(function(){
				jQuery('#order_review .variation-AddPetProfile').hide();
				jQuery('#order_review .variation-AddPetProfile div').hide();
			});
		</script>
<?php } ?>