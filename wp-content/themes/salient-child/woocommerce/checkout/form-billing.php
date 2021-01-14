<?php
/**
 * Checkout billing information form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/form-billing.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 3.0.9
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/** @global WC_Checkout $checkout */

?>
<div class="woocommerce-billing-fields">
	<?php if ( wc_ship_to_billing_address_only() && WC()->cart->needs_shipping() ) : ?>

		<h3><?php _e( 'Billing &amp; Shipping', 'woocommerce' ); ?></h3>
		<p>Indicates a required field *</p>

	<?php else : ?>

		<h3><?php _e( 'Billing details', 'woocommerce' ); ?></h3>
		<p>Indicates a required field *</p>

	<?php endif; ?>

	<?php do_action( 'woocommerce_before_checkout_billing_form', $checkout ); ?>

	<div class="woocommerce-billing-fields__field-wrapper">
		<?php
			$fields = $checkout->get_checkout_fields( 'billing' );
			unset($fields['billing_company']);
			foreach ( $fields as $key => $field ) {
				if ( isset( $field['country_field'], $fields[ $field['country_field'] ] ) ) {
					$field['country'] = $checkout->get_value( $field['country_field'] );
				}
				woocommerce_form_field( $key, $field, $checkout->get_value( $key ) );
			}
		?>
		<?php if ( $checkout->get_checkout_fields( 'account' ) && !is_user_logged_in() ) : ?>
			<?php foreach ( $checkout->get_checkout_fields( 'account' ) as $key => $field ) : ?>
				<?php woocommerce_form_field( $key, $field, $checkout->get_value( $key ) ); ?>
			<?php endforeach; ?>
		<?php endif; ?>
	</div>

	<?php do_action( 'woocommerce_after_checkout_billing_form', $checkout ); ?>
</div>

<?php if ( ! is_user_logged_in() && $checkout->is_registration_enabled() ) : ?>
	<div class="woocommerce-account-fields">
		<?php if ( ! $checkout->is_registration_required() ) : ?>

			<p class="form-row form-row-wide create-account">
				<label class="woocommerce-form__label woocommerce-form__label-for-checkbox checkbox">
					<input class="woocommerce-form__input woocommerce-form__input-checkbox input-checkbox" id="createaccount" <?php checked( ( true === $checkout->get_value( 'createaccount' ) || ( true === apply_filters( 'woocommerce_create_account_default_checked', false ) ) ), true ) ?> type="checkbox" name="createaccount" value="1" /> <span><?php _e( 'Create an account?', 'woocommerce' ); ?></span>
				</label>
			</p>

		<?php endif; ?>

		<?php do_action( 'woocommerce_before_checkout_registration_form', $checkout ); ?>

		<!-- <?php if ( $checkout->get_checkout_fields( 'account' ) ) : ?>

			<div class="create-account">
				<?php foreach ( $checkout->get_checkout_fields( 'account' ) as $key => $field ) : ?>
					<?php woocommerce_form_field( $key, $field, $checkout->get_value( $key ) ); ?>
				<?php endforeach; ?>
				<div class="clear"></div>
			</div>

		<?php endif; ?> -->

		<?php do_action( 'woocommerce_after_checkout_registration_form', $checkout ); ?>
	</div>
<?php endif; ?>
<?php if (is_user_logged_in()) { 
	$userId = get_current_user_id();
	$current_user = wp_get_current_user();
	$email = $current_user->user_email;
	?>
	<script type="text/javascript">
		$(document).ready(function(){
			var email = "<?php echo $email; ?>";
			var billingPhone = "<?php echo get_user_meta($userId, 'primary_home_number', true); ?>";
			$("#billing_phone").val(billingPhone);
			$("#billing_email").val(email);
			if ($("#billing_phone").val() != "") {
				$("#billing_phone").prop("readonly",true);
			}
			if ($("#billing_email").val() != "") {
				$("#billing_email").prop("readonly",true);
			}
		});
	</script>
<?php } ?>
<script type="text/javascript">
	$(document).ready(function(){
		$("#shipping_state").addClass('s_state_select');
		$("#billing_state_field").show();
		if ($("#billing_state").prop("type") == "hidden") {
			$("#billing_state").prop("type","text");
			$("#billing_state").prop("readonly",false);
			$("#billing_state").prop("class","state");
		}
		$("body").on("change","#billing_country, #shipping_country",function(){
			$this 	= $(this);
			var country = $(this).val();
			var j = 0;

			//wrapper for intended address box
			var wrapper = 'shipping_state_field';

			if($(this).attr('id') == 'billing_country') {
				$state = $(this).closest(".state_select");
				wrapper = 'billing_state_field';
			} else {
				$state = $('body').find('.s_state_select');
			}
			var attrName = $state.attr('name');
			console.log(' attrName '+ attrName);
			var attrClas = $state.attr('class');
			if ($state.attr('id')) {
				var attrId 	 = $state.attr('id');
			}else{
				var attrId 	 = "";
			}
			$parent = $state.parent();
			$state.remove();
			// $parent.find("span#u-state-error").remove();
			if($this.hasClass('not-require')){
				var select = "<select  class='"+attrClas+"' name='"+attrName+"' id='"+attrId+"'><option value=''>Select an option…</option>";
			}else{
				var select = "<select required='' class='"+attrClas+"' name='"+attrName+"' id='"+attrId+"'><option value=''>Select an option…</option>";

			}
			
			$.each(window.addressStates[country], function(i, item) {
				j++;
			    select += "<option value='"+i+"'>"+item+"</option>";
			});
			if (j==0) {
				if($this.hasClass('not-require')){
					select = "<input type='text'class='"+attrClas+"' name='"+attrName+"' placeholder='State' id='"+attrId+"'>";
				}else{
					select = "<input type='text' class='"+attrClas+"' required='' name='"+attrName+"' placeholder='State' id='"+attrId+"'>";
				}
				
			}
			console.log(select);
			$("#"+wrapper+" span.woocommerce-input-wrapper").html(select);
			// if (!$(this).hasClass("not-check-validate")) {
			// 	jQuery(document).find('#u-state').valid();
			// }
		});
	});
</script>