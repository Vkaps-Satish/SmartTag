<?php
if ( !defined('ABSPATH') ) {
	exit; // Exit if accessed directly
}
/**
 * Class to handle backend functionality
 */
if ( !class_exists('WWP_Wholesale_Pricing_Backend') ) {

	class WWP_Wholesale_Pricing_Backend {
		
		public function __construct() {
			add_action('admin_menu', array($this, 'wwp_register_custom_menu_page'));
			add_filter('woocommerce_product_data_tabs', array($this, 'wwp_add_wholesale_product_data_tab'), 99, 1);
			add_action('admin_head', array($this, 'wcpp_custom_style'));
			add_action('woocommerce_product_data_panels', array($this, 'wwp_add_wholesale_product_data_fields'));
			add_action('woocommerce_process_product_meta', array($this, 'wwp_woo_wholesale_fields_save'), 99);
			add_action('woocommerce_product_after_variable_attributes', array($this, 'wwp_variation_settings_fields'), 10, 3);
			add_action('woocommerce_save_product_variation', array($this, 'wwp_save_variation_settings_fields'), 10, 2);
			
		}
		public function wwp_register_custom_menu_page() {
		    global $submenu;
			add_menu_page(
				esc_html__('Wholesale Pricing', 'woocommerce-wholesale-pricing'),
				esc_html__('Wholesale', 'woocommerce-wholesale-pricing'),
				'manage_options',
				'wwp_wholesale',
				array($this, 'wwp_wholesale_page_callback'),
				'dashicons-store',
				58
			);
			add_submenu_page( 
				'wwp_wholesale', 
				esc_html__('Wholesale For WooCommerce', 'woocommerce-wholesale-pricing'), 
				esc_html__('Settings', 'woocommerce-wholesale-pricing'), 
				'manage_options', 
				'wwp_wholesale',
				array($this, 'wwp_wholesale_page_callback')
			);
			$submenu['wwp_wholesale'][] = array( '<b style="color:#fff">Get Pro Version</b>', 'manage_options' , 'https://woocommerce.com/products/wholesale-for-woocommerce/' );  
		}
		public function wwp_wholesale_page_callback() {
			$settings=get_option('wwp_wholesale_pricing_options', true);
			if ( isset($_POST['save-wwp_wholesale']) ) {
				if ( isset($_POST['wwp_wholesale_register_nonce']) || wp_verify_nonce( wc_clean($_POST['wwp_wholesale_register_nonce']), 'wwp_wholesale_register_nonce') ) {
					$settings = isset($_POST['options']) ? wc_clean($_POST['options']) : '';
					$settings['enable_registration_page'] = isset($settings['enable_registration_page']) ? 'yes' : 'no';
					$settings['wholesaler_prodcut_only'] = isset($settings['wholesaler_prodcut_only']) ? 'yes' : 'no';
					$settings['enable_upgrade'] = isset($settings['enable_upgrade']) ? 'yes' : 'no';
					$settings['disable_auto_role'] = isset($settings['disable_auto_role']) ? 'yes' : 'no';
					update_option('wwp_wholesale_pricing_options', $settings);
				}
			} 
			?>
			<form action="" method="post">
				<h2><?php esc_html_e('Wholesale For WooCommerce', 'woocommerce-wholesale-pricing'); ?></h2><hr>
				<?php wp_nonce_field('wwp_wholesale_register_nonce', 'wwp_wholesale_register_nonce'); ?>
				<table class="form-table">
					<tbody>
						<tr scope="row">
							<th colspan="2"><h2><?php esc_html_e('Price Labels', 'woocommerce-wholesale-pricing'); ?></h2></th>
						</tr>
						<tr scope="row">
							<th><label for="retailer_label"><?php esc_html_e('Retailer Price Label', 'woocommerce-wholesale-pricing'); ?></label></th>
							<td><input type="text" class="regular-text" name="options[retailer_label]" id="retailer_label" value="<?php echo isset($settings['retailer_label']) ? esc_html($settings['retailer_label']) : ''; ?>"></td>
						</tr>
						<tr scope="row">
							<th><label for="wholesaler_price_label"><?php esc_html_e('Wholesaler Price Label', 'woocommerce-wholesale-pricing'); ?></label></th>
							<td><input type="text" class="regular-text" name="options[wholesaler_label]" id="wholesaler_price_label" value="<?php echo isset($settings['wholesaler_label']) ? esc_html($settings['wholesaler_label']) : ''; ?>"></td>
						</tr>
						<tr scope="row">
							<th><label for="save_price_label"><?php esc_html_e('Save Price Label', 'woocommerce-wholesale-pricing'); ?></label></th>
							<td><input type="text" class="regular-text" name="options[save_label]" id="save_price_label" value="<?php echo isset($settings['save_label']) ? esc_html($settings['save_label']) : ''; ?>"></td>
						</tr>
					</tbody>            
				</table>
				<p><button name="save-wwp_wholesale" class="button-primary" type="submit" value="Save changes"><?php esc_html_e('Save changes', 'woocommerce-wholesale-pricing'); ?></button></p>
			</form>
			<div id="wcwp" class="wrap" style="    background: #FFF;">
				<div class="pro_container" style="background:url(<?php echo WWP_PLUGIN_URL.'assets/images/wholesale-banner.png'; ?>);">
				<h2>Pro Features</h2>
					<ol>		
						<li>User Roles</li>
						<li> Notifications </li>
						<li> Requests</li>
						<li> Registration Setting </li>
						<li> Bulk Pricing</li>
					</ol>
					
					<a href="https://woocommerce.com/products/wholesale-for-woocommerce/" class="get_pro_btn">Get Pro Now</a>
				</div>
			</div>
			<?php
		}
		/**
		 * Initialize product wholesale data tab
		 * 
		 * @since   1.0
		 * @version 1.0
		 */
		public function wwp_add_wholesale_product_data_tab( $product_data_tabs ) {
			$product_data_tabs['wwp-wholesale-tab'] = array(
				'label' => esc_html__('Wholesale', 'woocommerce-wholesale-pricing'),
				'target' => 'wwp_wholesale_product_data',
			);
			return $product_data_tabs;
		}
		/**
		 * Initialize product wholesale data tab
		 * 
		 * @since   1.0
		 * @version 1.0
		 */
		public function wcpp_custom_style() {
			?>
			<style>
				.wwp-wholesale-tab_tab a:before {
					font-family: Dashicons;
					content: "\f240" !important;
				}
			</style>
			<?php
		}
		/**
		 * Product wholesale data tab single user 
		 * 
		 * @since   1.0
		 * @version 1.0
		 */
		public function wwp_add_wholesale_product_data_fields() {
			global $woocommerce, $post, $product; 
			?>
			<!-- id below must match target registered in above wwp_add_wholesale_product_data_tab function -->
			<div id="wwp_wholesale_product_data" class="panel woocommerce_options_panel">
				<?php
				wp_nonce_field('wwp_product_wholesale_nonce', 'wwp_product_wholesale_nonce');
				woocommerce_wp_checkbox(
					array(
						'id'            => '_wwp_enable_wholesale_item',
						'wrapper_class' => 'wwp_enable_wholesale_item',
						'label'         => esc_html__('Enable Wholesale Item', 'woocommerce-wholesale-pricing'),
						'description'   => esc_html__('Add this item for wholesale customers', 'woocommerce-wholesale-pricing')
					)
				);
				woocommerce_wp_select(
					array(
						'id'      => '_wwp_wholesale_type',
						'label'   => esc_html__('Wholesale Type', 'woocommerce-wholesale-pricing'),
						'options' => array(
							'fixed'   => esc_html__('Fixed Amount', 'woocommerce-wholesale-pricing'),
							'percent' => esc_html__('Percent', 'woocommerce-wholesale-pricing'),
						)
					)
				);
				echo '<div class="hide_if_variable">';
					woocommerce_wp_text_input(
						array(
							'id'          => '_wwp_wholesale_amount',
							'label'       => esc_html__('Enter Wholesale Amount', 'woocommerce-wholesale-pricing'),
							'placeholder' => get_woocommerce_currency_symbol() . '15',
							'desc_tip'    => 'true',
							'description' => esc_html__('Enter Wholesale Price (e.g 15)', 'woocommerce-wholesale-pricing')
						)
					);
					woocommerce_wp_text_input(
						array(
							'id'          => '_wwp_wholesale_min_quantity',
							'label'       => esc_html__('Minimum Quantiy', 'woocommerce-wholesale-pricing'),
							'placeholder' => '1',
							'desc_tip'    => 'true',
							'description' => esc_html__('Minimum quantity to apply wholesale price (default is 1)', 'woocommerce-wholesale-pricing'),
							'type'        => 'number',
							'custom_attributes' => array(
								'step'     => '1',
								'min'    => '1'
							)
						)
					);
				echo '</div>';
				echo '<div class="show_if_variable">';
				echo '<p>' . esc_html__('For Variable Product you can add wholesale price from variations tab', 'woocommerce-wholesale-pricing') . '</p>';
				echo '</div>';
				?>
			</div>
			<?php
		}
		/**
		 * Save product meta fields
		 * 
		 * @param   $post_id to save product meta
		 * @since   1.0
		 * @version 1.0
		 */
		public function wwp_woo_wholesale_fields_save( $post_id ) {
			if ( !isset($_POST['wwp_product_wholesale_nonce']) || !wp_verify_nonce( wc_clean($_POST['wwp_product_wholesale_nonce']), 'wwp_product_wholesale_nonce') ) {
				return;
			}
			// Wholesale Enable
			$woo_wholesale_enable = isset($_POST['_wwp_enable_wholesale_item']) ? wc_clean($_POST['_wwp_enable_wholesale_item']) : '';        
			update_post_meta($post_id, '_wwp_enable_wholesale_item', esc_attr($woo_wholesale_enable));
			// Wholesale Type
			$woo_wholesale_type = isset($_POST['_wwp_wholesale_type']) ? wc_clean($_POST['_wwp_wholesale_type']) : '';
			if ( !empty($woo_wholesale_type) ) {
				update_post_meta($post_id, '_wwp_wholesale_type', esc_attr($woo_wholesale_type));
			}
			// Wholesale Amount
			$woo_wholesale_amount = isset($_POST['_wwp_wholesale_amount']) ? wc_clean($_POST['_wwp_wholesale_amount']) : '';
			if ( !empty($woo_wholesale_amount) ) {
				update_post_meta($post_id, '_wwp_wholesale_amount', esc_attr($woo_wholesale_amount));
			}
			// Wholesale Minimum Quantity
			$wwp_wholesale_min_quantity = isset($_POST['_wwp_wholesale_min_quantity']) ? wc_clean($_POST['_wwp_wholesale_min_quantity']) : '';
			if ( !empty($wwp_wholesale_min_quantity) ) {
				update_post_meta($post_id, '_wwp_wholesale_min_quantity', esc_attr($wwp_wholesale_min_quantity));
			}
		}
		/**
		 * Product variations settings single user 
		 * 
		 * @since   1.0
		 * @version 1.0
		 */
		public function wwp_variation_settings_fields ( $loop, $variation_data, $variation ) {
			wp_nonce_field('wwp_variation_wholesale_nonce', 'wwp_variation_wholesale_nonce');
			woocommerce_wp_text_input(
				array(
					'id'          => '_wwp_wholesale_amount[' . esc_attr($variation->ID) . ']',
					'label'       => esc_html__('Enter Wholesale Price', 'woocommerce-wholesale-pricing'),
					'desc_tip'    => 'true',
					'description' => esc_html__('Enter Wholesale Price Here (e.g 15)', 'woocommerce-wholesale-pricing'),
					'value'       => get_post_meta($variation->ID, '_wwp_wholesale_amount', true),
					'custom_attributes' => array(
						'step'     => 'any',
						'min'    => '0'
					)
				)
			);
			woocommerce_wp_text_input(
				array(
					'id'          => '_wwp_wholesale_min_quantity[' . esc_attr($variation->ID) . ']',
					'label'       => esc_html__('Minimum Quantiy', 'woocommerce-wholesale-pricing'),
					'placeholder' => '1',
					'value'       =>  get_post_meta($variation->ID, '_wwp_wholesale_min_quantity', true),
					'desc_tip'    => 'true',
					'description' => esc_html__('Minimum quantity to apply wholesale price (default is 1)', 'woocommerce-wholesale-pricing'),
					'type'              => 'number',
					'custom_attributes' => array(
						'step'     => '1',
						'min'    => '1'
					)
				)
			);
		}
		/**
		 * Save product variations settings single user 
		 * 
		 * @since   1.0
		 * @version 1.0
		 */
		public function wwp_save_variation_settings_fields ( $post_id ) {
			if ( !isset($_POST['wwp_variation_wholesale_nonce']) || !wp_verify_nonce( wc_clean($_POST['wwp_variation_wholesale_nonce']), 'wwp_variation_wholesale_nonce') ) {
				return;
			}
			$variable_wholesale = isset( $_POST['_wwp_wholesale_amount'][ $post_id ] ) ? wc_clean($_POST['_wwp_wholesale_amount'][ $post_id ]) : '';
			if ( !empty($variable_wholesale) ) {
				update_post_meta($post_id, '_wwp_wholesale_amount', esc_attr($variable_wholesale));
			}
			$wholesale_min_quantity = isset($_POST['_wwp_wholesale_min_quantity'][ $post_id ]) ? wc_clean($_POST['_wwp_wholesale_min_quantity'][ $post_id ]) : '';
			if ( !empty($wholesale_min_quantity) ) {
				update_post_meta($post_id, '_wwp_wholesale_min_quantity', esc_attr($wholesale_min_quantity));
			}
		}
	}
	new WWP_Wholesale_Pricing_Backend();
}
?>
<style>
.pro_container{
	padding: 10px 20px 20px;
	background-position: right!important;
	background-size: 356px!important;
	background-repeat: no-repeat!important;
	}
a.get_pro_btn {
    margin-top: 20px;
    display: block;
    background: #96588a;
    padding: 10px 20px;
    color: #FFF;
    text-decoration: none;
    border-radius: 30px;
    font-weight: bold;
    font-size: 16px;
    width: 105px;
    text-align: center;
}
a.get_pro_btn:hover{
	color:#FFF;
	background:#000;
}

</style>