<?php
/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       http://multidots.com/
 * @since      1.0.0
 *
 * @package    Woo_Shipping_Display_Mode
 * @subpackage Woo_Shipping_Display_Mode/admin/partials
 */
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

class WC_Settings_Shipping_Display_Mode_Methods {

    /**
     * Constructor.
     *
     * @since 1.0.0
     */
    public function __construct() {
        $this->woo_shipping_hooks();
    }

    /**
     * Class hooks.
     *
     * @since 1.0.0
     */
    public function woo_shipping_hooks() {
        // Add WC settings tab
        add_filter('woocommerce_settings_tabs_array', array($this, 'woo_shipping_settings_tab'), 70);

        // Settings page contents
        add_action('woocommerce_settings_tabs_shipping_mode', array($this, 'woo_shipping_settings_page'));

        // Save settings page
        add_action('woocommerce_update_options_shipping_mode', array($this, 'woo_shipping_update_options'));
    }

    /**
     * Settings tab.
     *
     * Add a WooCommerce settings tab for the Receiptful settings page.
     *
     * @since 1.0.0
     *
     * @param    array $tabs Array of default tabs used in WC.
     * @return    array            All WC settings tabs including newly added.
     */
    public function woo_shipping_settings_tab($tabs) {

        $tabs['shipping_mode'] = __('Shipping Method Display Mode', 'woo-shipping-display-mode');

        return $tabs;
    }

    /**
     * Settings page content.
     *
     * @since 1.0.0
     */
    public function woo_shipping_settings_page() {
        if (!defined('ABSPATH')) {
            exit;
        }
        ?>
        <?php
        wp_enqueue_script('jquery');
        wp_enqueue_script('jquery-ui-core');
	    do_action('woocommerce_update_options_shipping_mode');
        $shiiping_method_get_value = get_option('woocommerce_shipping_method_format');
        ?>
        <h3><?php printf(esc_html('Shipping Method Display Mode', 'woocommerce')); ?></h3>
        <table class="form-table" id="shipping_display_table">
            <?php wp_nonce_field(basename(__FILE__), 'woo_shipping_display_mode'); ?>
            <th scope="row" class="titledesc">
                <label for="woocommerce_shipping_method_format"><?php echo esc_html('Shipping Method Display Mode', 'woo-shipping-display-mode'); ?></label>
                <img class="help_tip" src="<?php echo esc_url(WSDM_PLUGIN_URL . 'admin/images/help.png'); ?>" height="16" width="16" data-tip="<?php echo esc_attr('Display shipping methods with Radio buttons and Dropdowns', 'woo-shipping-display-mode'); ?>">
            </th>
            <td class="forminp forminp-radio">
                <fieldset>
                    <ul>
                        <li>
                            <label><input name="woocommerce_shipping_method_format" value="radio" type="radio" style="" class="" <?php
                                if ('radio' === $shiiping_method_get_value) {
                                    echo 'checked="checked"';
                                }
                                ?>>
                                          <?php echo esc_html('Display shipping methods with "radio" buttons', 'woo-shipping-display-mode'); ?>
                            </label>
                        </li>
                        <li>
                            <label><input name="woocommerce_shipping_method_format" value="select" type="radio" style="" class="" <?php
                                if ('select' === $shiiping_method_get_value) {
                                    echo 'checked="checked"';
                                }
                                ?> >
                                          <?php echo esc_html('Display shipping methods in a dropdown', 'woo-shipping-display-mode'); ?>
                            </label>
                        </li>
                    </ul>
                </fieldset>
            </td>
        </table>
        <?php
    }

    /**
     * Save settings.
     *
     * Save settings based on WooCommerce save_fields() method.
     *
     * @since 1.0.0
     */
    public function woo_shipping_update_options() {
	    $page_no  = filter_input( INPUT_POST, 'save', FILTER_SANITIZE_NUMBER_INT );
        if (isset($page_no)) {
            // verify nonce
	        $woo_shipping_display_mode  = filter_input( INPUT_POST, 'woo_shipping_display_mode', FILTER_SANITIZE_STRING );
            if (!isset($woo_shipping_display_mode) || !wp_verify_nonce($woo_shipping_display_mode, basename(__FILE__))) {
                die('Failed security check');
            }
	        $woocommerce_shipping_method_format  = filter_input( INPUT_POST, 'woocommerce_shipping_method_format', FILTER_SANITIZE_STRING );
            if (!empty($woocommerce_shipping_method_format)) {
                $display_mode = sanitize_text_field($woocommerce_shipping_method_format);

	            update_option('woocommerce_shipping_method_format', $display_mode, '', 'yes');
            }
        }
    }
}
