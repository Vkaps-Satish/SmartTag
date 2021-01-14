<?php

namespace WPDesk\ShopMagic\Action\Builtin;

use WPDesk\ShopMagic\Action\BasicAction;
use WPDesk\ShopMagic\Automation\Automation;
use WPDesk\ShopMagic\Event\Event;

/**
 * ShopMagic Add To MailChimp List Action class
 *
 * @package ShopMagic
 * @since   1.0.0
 */
final class AddToMailChimpList extends BasicAction {
	public static function get_required_data_domains() {
		return [ \WP_User::class, \WC_Order::class ];
	}

	public static function get_name() {
		return __( 'Add Customer to Mailchimp List', 'shopmagic-for-woocommerce' );
	}

	public function execute( Automation $automation, Event $event ) {
		/* Get action parameters */
		// mailchimp list id value

		$mailchimp_list_id = $this->placeholder_processor->process( $this->data['_mailchimp_list_id'] );

		// mailchimp double optin value
		$mailchimp_doubleoptin = $this->placeholder_processor->process( $this->data['_mailchimp_doubleoptin'] );

		/* Get MailChimp parameters from WC setings */
		// API Key
		$mailchimp_api_key = get_option( 'wc_settings_tab_mailchimp_api_key', false );

		try {
			$MailChimpTool = new \MailChimp_API_Tools( $mailchimp_api_key );
		} catch ( \Exception $err ) {
			error_log( $err );

			return;
		}


		// Get customer information
		$order = $this->provided_data[ \WC_Order::class ];

		// Add as new subscriber
		$MailChimpTool->add_member_from_order( $order, $mailchimp_list_id, $mailchimp_doubleoptin );
	}

	/**
	 * Show parameters window in an admin side widget
	 *
	 * @param $automation_id integer called automation id
	 * @param $data array current action settings to set default values
	 * @param $name_prefix string prefix for form control name attributes
	 *
	 * @since   1.0.0
	 */
	static function show_parameters( $automation_id, $data, $name_prefix ) {
		// Read the default List ID value from Woocommerce settings ( ShopMagic Tab )
		$mc_default_list_id = get_option( 'wc_settings_tab_mailchimp_list_id', '' );

		if ( $mc_default_list_id == '0' ) {
			$mc_default_list_id = __( 'Not assigned yet!', 'shopmagic-for-woocommerce' );
		}

		// Read the default double optin value from Woocommerce settings ( ShopMagic Tab )
		$mc_default_double_optin = get_option( 'wc_settings_tab_mailchimp_double_optin', 'yes' );

		if ( ! array_key_exists( '_mailchimp_doubleoptin', $data ) ) {
			if ( in_array( strtolower( $mc_default_double_optin ), array( 'yes', 'on' ) ) ) {
				$data['_mailchimp_doubleoptin'] = 'checked';
			} else {
				$data['_mailchimp_doubleoptin'] = '';
			}
		} else {
			if ( in_array( strtolower( $data['_mailchimp_doubleoptin'] ), array( 'yes', 'on' ) ) ) {
				$data['_mailchimp_doubleoptin'] = 'checked';
			} else {
				$data['_mailchimp_doubleoptin'] = '';
			}
		}

		$is_doubleoptin_checked = $data['_mailchimp_doubleoptin'];

		$mc_apiKey_from_settings = get_option( 'wc_settings_tab_mailchimp_api_key', false );
		try {
			$MailChimpTools = new \MailChimp_API_Tools( $mc_apiKey_from_settings );
		} catch ( \Exception $err ) {
			error_log( $err );

			echo '<div class="notice notice-error"><p>' . __( 'Please make sure to provide Mailchimp API key!',
					'shopmagic-for-woocommerce' ) . ' <a href="' . admin_url( 'admin.php?page=wc-settings&tab=shopmagic&section=mailchimp' ) . '" target="_blank">' . __( 'Please, visit settings page &rarr;',
					'shopmagic-for-woocommerce' ) . '</a></p></div>';

			return;
		}

		// Set the lists names options
		$lists_names_options = $MailChimpTools->get_all_lists_options();

		?>

		<table class="shopmagic-table">
			<tbody>
			<tr class="shopmagic-field">
				<td class="shopmagic-label">
					<label for="mailchimp_list_name"><?php _e( 'List', 'shopmagic-for-woocommerce' ); ?></label>
				</td>

				<td class="shopmagic-input">
					<div class="shopmagic-input-wrap">
						<select name="<?php echo $name_prefix; ?>[_mailchimp_list_id]" id="mailchimp_list_name">
							<?php

							$selected_current_list_id = $data['_mailchimp_list_id'];

							if ( empty( $data['_mailchimp_list_id'] ) ) {
								$selected_current_list_id = $mc_default_list_id;
							}

							$selected_or_not = "";
							foreach ( $lists_names_options as $list_id => $list_name ) {

								if ( $selected_current_list_id == $list_id ) {
									$selected_or_not = "selected";
								}
								?>
								<option
									value="<?php echo $list_id; ?>" <?php echo( $selected_or_not ); ?>><?php echo $list_name; ?></option>
								<?php
							}
							?>
						</select>
					</div>

					<p class="description"><?php _e( 'The default list ID is', 'shopmagic-for-woocommerce' ) ?>
						<code><?php echo( $mc_default_list_id ); ?></code></p>
				</td>
			</tr>

			<tr class="shopmagic-field">
				<td class="shopmagic-label">
					<label for="mailchimp_double-optin"><?php _e( 'Double opt-in',
							'shopmagic-for-woocommerce' ) ?></label>
				</td>

				<td class="shopmagic-input">
					<label><input type="checkbox" name="<?php echo $name_prefix; ?>[_mailchimp_doubleoptin]"
					              id="mailchimp_double-optin" <?php echo $is_doubleoptin_checked; ?> /> <?php _e( 'Send customers an opt-in confirmation email when they subscribe. (Unchecking may be against Mailchimp policy.)',
							'shopmagic-for-woocommerce' ); ?>
					</label>
				</td>
			</tr>
			</tbody>
		</table>

		<?php
	}

	/**
	 * Save parameters from POST request, called from an admin side widget
	 *
	 * in this method we should analyse $post array and store data accordingly in $data array
	 *
	 * @param $automation_id integer called automation id
	 * @param $data array pointer to an array which is will be stored in meta for an automation
	 * @param $post array part from $_POST array, which is belongs for a current action
	 *
	 * @since   1.0.0
	 */
	static function save_parameters( $automation_id, &$data, $post ) {
		$data['_mailchimp_list_id'] = $post["_mailchimp_list_id"];
		// _mailchimp_doubleoptin
		$data['_mailchimp_doubleoptin'] = $post["_mailchimp_doubleoptin"];
	}

}

//*************************************************************************//
// ACTION SPECIFIC INITIALIZATION PART                                     //
//*************************************************************************//

class ShopMagic_AddToMailChimpList_Initialization {

	public function __construct() {

		// Only if checked on settings return false
		$subscribe_on_checkout_setting = get_option( 'wc_settings_sm_subscribe_on_checkout', false );
		if ( $subscribe_on_checkout_setting && $subscribe_on_checkout_setting === 'yes' ) {

			add_action( 'woocommerce_checkout_after_customer_details', array(
				$this,
				'mc_subscribe_on_checkout_field'
			) );
			add_action( 'woocommerce_checkout_update_order_meta', array(
				$this,
				'mc_subscribe_on_checkout_field_execute'
			) );
		}
	}

	/**
	 * MailChimp subscribe on checkout
	 *
	 * Enable the "MailChimp subscribe on checkout" feature if the user check it from the MagicShop settings
	 *
	 * @since   1.0.0
	 */
	function mc_subscribe_on_checkout_field() {
		/* We may want to leave the comment signs '//' to create a header for the new checkbox */
		//echo '<div><h2>'.__( 'Subscribe to our newsletter', 'shopmagic-for-woocommerce' ).'</h2>';

		$checkout = WC()->checkout();

		woocommerce_form_field( 'mailchimp_subscribe_on_checkout', array(
			'type'  => 'checkbox',
			'class' => array( 'form-row-wide' ),
			'label' => __( 'Subscribe to our newsletter ', 'shopmagic-for-woocommerce' ),
		), $checkout->get_value( 'mailchimp_subscribe_on_checkout' ) );

		//echo '</div>';
	}

	/**
	 * checkout update order meta
	 *
	 * @param $order_id int identification of order
	 **/
	function mc_subscribe_on_checkout_field_execute( $order_id ) {

		if ( $_POST['mailchimp_subscribe_on_checkout'] ) {
			// The field is checked, now add to newsletter

			// API Key from settings
			$mailchimp_api_key = get_option( 'wc_settings_tab_mailchimp_api_key', false );

			// mailchimp list id settings value
			$mailchimp_list_id = get_option( 'wc_settings_tab_mailchimp_list_id', false );

			// mailchimp double optin settings value
			$mailchimp_doubleoptin = get_option( 'wc_settings_tab_mailchimp_double_optin', false );

			//
			$order = new \WC_Order( $order_id );

			$MailChimpTool = new \MailChimp_API_Tools( $mailchimp_api_key );

			// Add as new subscriber
			$MailChimpTool->add_member_from_order( $order, $mailchimp_list_id, $mailchimp_doubleoptin );

		}
	}
}

// Activate the subscribe_on_checkout feature if it is checked from the ShopMagic settings
new ShopMagic_AddToMailChimpList_Initialization();


