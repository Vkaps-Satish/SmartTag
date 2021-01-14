<?php
/**
 * ShopMagic's Settings page in WoooCommerce settings page .
 *
 * Show And Save Pugin Specific settings
 *
 * @package ShopMagic
 * @version 1.0.0
 * @since   1.0.0
 */
if ( ! class_exists( 'WC_Settings_Page' ) ) {
	require_once( WP_PLUGIN_DIR . "/woocommerce/includes/admin/settings/class-wc-settings-page.php" );
}

class ShopMagic_WC_Settings_Tab extends WC_Settings_Page {
	/**
	 * Bootstraps the class and hooks required actions & filters.
	 *
	 */
	public function __construct() {

		$this->id    = 'shopmagic';
		$this->label = __( 'ShopMagic', 'shopmagic-for-woocommerce' );

		add_filter( 'woocommerce_settings_tabs_array', array( $this, 'add_settings_page' ), 50 );

		add_action( 'woocommerce_settings_' . $this->id, array( $this, 'output' ) );
		add_action( 'woocommerce_settings_save_' . $this->id, array( $this, 'save' ) );
		add_action( 'woocommerce_sections_' . $this->id, array( $this, 'output_sections' ) );
	}

	/**
	 * Get sections.
	 *
	 * @return array
	 */
	public function get_sections() {

		$sections = array(
			''          => __( 'General', 'shopmagic-for-woocommerce' ),
			'mailchimp' => __( 'Mailchimp', 'shopmagic-for-woocommerce' ),
		);

		return apply_filters( 'woocommerce_get_sections_' . $this->id, $sections );
	}

	/**
	 * Output the settings.
	 */
	public function output() {
		global $current_section;

		// New admin notices place for ShopMagic page
		do_action( 'shopmagic_admin_notices' );

		$settings = $this->get_settings( $current_section );

		WC_Admin_Settings::output_fields( $settings );
	}

	/**
	 * Save settings.
	 */
	public function save() {
		global $current_section;

		$settings = $this->get_settings( $current_section );
		WC_Admin_Settings::save_fields( $settings );
	}

	/**
	 * Get settings array.
	 *
	 * @return array
	 */
	public function get_settings( $current_section = '' ) {
		if ( 'mailchimp' == $current_section ) {

			if ( ! class_exists( 'MailChimp_API_Tools' ) ) {
				require_once( SHOPMAGIC_BASE_DIR . '/includes/libraries/MailChimp_API_Tools.class.php' );
			}

			$mc_apiKey_from_settings = get_option( 'wc_settings_tab_mailchimp_api_key', false );

			try {
				$MailChimpTools = new MailChimp_API_Tools( $mc_apiKey_from_settings );

				// Set the lists names options
				$lists_names_options = $MailChimpTools->get_all_lists_options();
			} catch ( Exception $err ) {
				error_log( $err );
				$lists_names_options = array(
					"0" => __( 'Please make sure about the MailChimp API key provided !', 'shopmagic-for-woocommerce' ),
				);
			}

			$settings = apply_filters( 'woocommerce_shopmagic_settings', array(

				array(
					'name' => __( 'Mailchimp Settings', 'shopmagic-for-woocommerce' ),
					'type' => 'title',
					'id'   => 'wc_settings_mailchimp_section_title'
				),
				array(
					'name'     => __( 'API Key', 'shopmagic-for-woocommerce' ),
					'type'     => 'text',
					'css'      => 'min-width:290px;',
					'desc'     => __( 'Insert your API key here which you can create and get from your Mailchimp settings.', 'shopmagic-for-woocommerce' ),
					'desc_tip' => true,
					'id'       => 'wc_settings_tab_mailchimp_api_key'
				),
				array(
					'name'     => __( 'List', 'shopmagic-for-woocommerce' ),
					'type'     => 'select',
					'options'  => $lists_names_options,
					'desc'     => __( 'The DEFAULT MailChimp List names to which you want to add clients.', 'shopmagic-for-woocommerce' ),
					'desc_tip' => true,
					'id'       => 'wc_settings_tab_mailchimp_list_id'
				),
				array(
					'name'     => __( 'Double opt-in', 'shopmagic-for-woocommerce' ),
					'type'     => 'checkbox',
					'default'  => 'yes',
					'desc'     => __( 'Send customers an opt-in confirmation email when they subscribe. (Unchecking may be against Mailchimp policy.)', 'shopmagic-for-woocommerce' ),
					'desc_tip' => false,
					'id'       => 'wc_settings_tab_mailchimp_double_optin'
				),
				array(
					'name'     => __( 'Tags', 'shopmagic-for-woocommerce' ),
					'type'     => 'text',
					'desc'     => __( 'A single text field for seller to include tags (comma separated) to be added to mailchimp upon checkout.', 'shopmagic-for-woocommerce' ),
					'desc_tip' => true,
					'id'       => 'wc_settings_tab_mailchimp_tags'
				),
				array(
					'name'          => __( 'Send additional information to Mailchimp list', 'shopmagic-for-woocommerce' ),
					'type'          => 'checkbox',
					'checkboxgroup' => 'start',
					'default'       => 'no',
					'desc'          => __( 'Last name', 'shopmagic-for-woocommerce' ),
					'desc_tip'      => false,
					'id'            => 'wc_settings_tab_mailchimp_info_lname'
				),
				array(
					'type'          => 'checkbox',
					'checkboxgroup' => '',
					'default'       => 'no',
					'desc'          => __( 'Address', 'shopmagic-for-woocommerce' ),
					'desc_tip'      => false,
					'id'            => 'wc_settings_tab_mailchimp_info_address'
				),
				array(
					'type'          => 'checkbox',
					'checkboxgroup' => '',
					'default'       => 'no',
					'desc'          => __( 'City', 'shopmagic-for-woocommerce' ),
					'desc_tip'      => false,
					'id'            => 'wc_settings_tab_mailchimp_info_city'
				),
				array(
					'type'          => 'checkbox',
					'checkboxgroup' => '',
					'default'       => 'no',
					'desc'          => __( 'State', 'shopmagic-for-woocommerce' ),
					'desc_tip'      => false,
					'id'            => 'wc_settings_tab_mailchimp_info_state'
				),
				array(
					'type'          => 'checkbox',
					'checkboxgroup' => 'end',
					'default'       => 'no',
					'desc'          => __( 'Country', 'shopmagic-for-woocommerce' ),
					'desc_tip'      => false,
					'id'            => 'wc_settings_tab_mailchimp_info_country'
				),
				'mailchimp_section_end' => array(
					'type' => 'sectionend'
				)


			) );
		} else if ( 'debug' == $current_section ) { // Debug
			$settings = apply_filters( 'woocommerce_shopmagic_settings_debug', array(
				array(
					'name' => __( 'Debug Settings', 'shopmagic-for-woocommerce' ),
					'type' => 'title',
					'desc' => __( 'Tools to help you see what\'s going on under the hood.', 'shopmagic-for-woocommerce' ),
					'id'   => 'wc_settings_shopmagic_debug_title'
				),
				array(
					'name'     => __( 'Log all activity', 'shopmagic-for-woocommerce' ),
					'type'     => 'checkbox',
					'default'  => 'no',
					'desc'     => __( 'Store messages (generated by events and actions) in the event log. Useful for debugging and monitoring.', 'shopmagic-for-woocommerce' ),
					'desc_tip' => __( 'Warning: May lead to inflated database if enabled permanently - use for temporary testing only.', 'shopmagic-for-woocommerce' ),
					'id'       => 'wc_settings_sm_store_messages'
				),
				array(
					'name'     => __( 'Debug', 'shopmagic-for-woocommerce' ),
					'type'     => 'checkbox',
					'default'  => 'no',
					'desc'     => __( 'Log activity to wp_log file', 'shopmagic-for-woocommerce' ),
					'desc_tip' => false,
					'id'       => 'wc_settings_sm_debug'
				),
				'settings_debug_section_end' => array(
					'type' => 'sectionend'
				),
				array(
					'name' => __( 'Event Log', 'shopmagic-for-woocommerce' ),
					'type' => 'title',
					'desc' => false,
					'id'   => 'wc_settings_shopmagic_debug_title'
				)
			) );

		} else if ( '' == $current_section ) { // General
			$settings = apply_filters( 'woocommerce_shopmagic-general_settings', array(
				array(
					'name' => __( 'General Settings', 'shopmagic-for-woocommerce' ),
					'type' => 'title',
					'desc' => __( 'Click on the appropriate ShopMagic add-on settings tab above.', 'shopmagic-for-woocommerce' ),
					'id'   => 'wc_settings_shopmagic_section_title'
				),
				array(
					'name'     => __( 'Subscribe on checkout', 'shopmagic-for-woocommerce' ),
					'type'     => 'checkbox',
					'default'  => 'no',
					'desc'     => __( 'Ask customers to subscribe to your mailing list on checkout.', 'shopmagic-for-woocommerce' ),
					'desc_tip' => __( 'Setup Mailchimp or other email service add-on first.', 'shopmagic-for-woocommerce' ),
					'id'       => 'wc_settings_sm_subscribe_on_checkout'
				),
				array(
					'type' => 'sectionend'
				)
			) );
		} else {
			$sections = $this->get_sections();
			foreach ( $sections as $section_id => $title ) {
				if ( $current_section == $section_id ) {
					$settings = apply_filters( 'woocommerce_shopmagic-' . $current_section . '_settings', array() );
				}
			}
		}

		return apply_filters( 'woocommerce_get_settings_' . $this->id, $settings, $current_section );
	}
}
