<?php
/**
 * Checkout shipping information form
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.2.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
?>

<div class="woocommerce-shipping-fields">
	<?php if ( WC()->cart->needs_shipping_address() === true ) : ?>

		<?php
			if ( empty( $_POST ) ) {

				$ship_to_different_address = get_option( 'woocommerce_ship_to_destination' ) === 'shipping' ? 1 : 0;
				$ship_to_different_address = apply_filters( 'woocommerce_ship_to_different_address_checked', $ship_to_different_address );

			} else {

				$ship_to_different_address = $checkout->get_value( 'ship_to_different_address' );

			}
		?>

		<h3 id="ship-to-different-address">
			<input id="ship-to-different-address-checkbox" class="input-checkbox" <?php checked( $ship_to_different_address, 1 ); ?> type="checkbox" name="ship_to_different_address" value="1" />
			<label for="ship-to-different-address-checkbox" class="checkbox"><?php _e( 'Ship to a different address?', 'woocommerce' ); ?></label>
		</h3>
		<div class="shipping_address">
			<?php if (is_user_logged_in()) {
				$data = get_user_meta(get_current_user_id(),'multiple_shipping_info',true); 
				if (!empty($data) && count($data) > 1) { ?>
					<p class="form-row">
						<label for="multiple_shipping_address" class="">Select Shipping Address</label>
						<?php echo "<select class='multiple-shipping'>";
							echo "<option value=''>Select shipping address</option>";
							foreach ($data as $key => $value) {
								echo "<option value='".$key."'>".$value['shipping_first_name'].", ".$value['shipping_city']." ".$value['shipping_state']." ".$value['shipping_postcode']."</option>";
							}
						echo "</select>";
						$dataJson = json_encode($data); ?>
						<script type="text/javascript">
							jQuery(document).ready(function($){
								var multipleAddress = <?php echo $dataJson; ?>;
								$("body").on("change","select.multiple-shipping",function(){
									var indexing = $(this).val();
									$("#shipping_first_name").val(multipleAddress[indexing].shipping_first_name);
									$("#shipping_last_name").val(multipleAddress[indexing].shipping_last_name);
									$('#shipping_company').val(multipleAddress[indexing].shipping_country);
									$('#shipping_country').val(multipleAddress[indexing].shipping_country).change();
									// $("#shipping_country").val(multipleAddress[indexing].shipping_country);
									// $("#select2-shipping_country-container").text($("#shipping_country option:selected").text());
									$("#shipping_address_1").val(multipleAddress[indexing].shipping_address_1);
									$("#shipping_address_2").val(multipleAddress[indexing].shipping_address_2);
									$("#shipping_city").val(multipleAddress[indexing].shipping_city);
									$("#shipping_postcode").val(multipleAddress[indexing].shipping_postcode);
									$("#shipping_state").val(multipleAddress[indexing].shipping_state);
								});
							});
						</script>
					</p>
				<?php } ?>
			<?php } ?>
			<?php do_action( 'woocommerce_before_checkout_shipping_form', $checkout ); ?>

			<?php foreach ( $checkout->checkout_fields['shipping'] as $key => $field ) : ?>
				<?php if ($key == "shipping_company") { continue; } ?>
				<?php woocommerce_form_field( $key, $field, $checkout->get_value( $key ) ); ?>

			<?php endforeach; ?>

			<?php do_action( 'woocommerce_after_checkout_shipping_form', $checkout ); ?>

		</div>

	<?php endif; ?>

	<?php do_action( 'woocommerce_before_order_notes', $checkout ); ?>

	<?php if ( apply_filters( 'woocommerce_enable_order_notes_field', get_option( 'woocommerce_enable_order_comments', 'yes' ) === 'yes' ) ) : ?>

		<?php if ( ! WC()->cart->needs_shipping() || WC()->cart->ship_to_billing_address_only() ) : ?>

			<h3><?php _e( 'Additional Information', 'woocommerce' ); ?></h3>

		<?php endif; ?>

		<?php foreach ( $checkout->checkout_fields['order'] as $key => $field ) : ?>

			<?php woocommerce_form_field( $key, $field, $checkout->get_value( $key ) ); ?>

		<?php endforeach; ?>

	<?php endif; ?>

	<?php do_action( 'woocommerce_after_order_notes', $checkout ); ?>
</div>
