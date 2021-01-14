<?php
/**
 * ShopMagic's Admin area handler.
 *
 * Prepare admin area classes and variables
 *
 * @package ShopMagic
 * @version 1.0.0
 * @since   1.0.0
 */
// Exit if accessed directly
use WPDesk\ShopMagic\Action\ActionFactory;
use WPDesk\ShopMagic\Event\EventFactory;
use WPDesk\ShopMagic\Filter\FilterFactory;
use WPDesk\ShopMagic\Placeholder\PlaceholderFactory;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * ShopMagic Event Meta Box class
 *
 * @package ShopMagic
 * @since   1.0.0
 */
class ShopMagic_Admin {

	function __construct( EventFactory $event_factory, FilterFactory $filter_factory, ActionFactory $action_factory ) {
		$this->add_actions();

		$this->setup_admin_menu();

		new ShopMagic_Event_Metabox( $event_factory );
		new ShopMagic_Filter_Metabox( $filter_factory );
		new ShopMagic_Action_Metabox( $action_factory );
		new ShopMagic_Placeholders_Metabox( );
		new ShopMagic_Logger_Viewer();
		new ShopMagic_Email_Template_Loader();

	}

	/**
	 * Adds action hooks.
	 *
	 * @since   1.0.0
	 */
	private function add_actions() {

		// add_action('admin_menu', array($this, 'setup_admin_menu'));
		add_action( 'admin_enqueue_scripts', array( $this, 'admin_scripts' ) );
	}

	/**
	 * Includes admin scripts in admin area
	 *
	 * @param string $hook hook, describes page
	 */
	public function admin_scripts( $hook ) {

		wp_register_style( 'shopmagic-admin', SHOPMAGIC_PLUGIN_URL . 'assets/css/admin-style.css', array(), SHOPMAGIC_VERSION );

		if ( 'woocommerce_page_wc-settings' == $hook ) {
			wp_enqueue_style( 'shopmagic-admin' );
			wp_enqueue_script( 'shopmagic-debug-log-handler', SHOPMAGIC_PLUGIN_URL . '/assets/js/sm-debug-handler.js', array(
				'jquery',
				'jquery-ui-dialog'
			) );

			wp_localize_script( 'shopmagic-debug-log-handler', 'ShopMagic', array(
					// URL to wp-admin/admin-ajax.php to process the request
					'ajaxurl'           => admin_url( 'admin-ajax.php' ),

					// generate a nonce with a unique ID "shopmagic-debug-ajax-process-nonce"
					// so that you can check it later when an AJAX request is sent
					'paramProcessNonce' => wp_create_nonce( 'shopmagic-debug-ajax-process-nonce' ),
				)
			);

		}

		$current_screen = get_current_screen();
		if ( $current_screen->post_type != 'shopmagic_automation' ) {
			return;
		}

		wp_enqueue_style( 'shopmagic-admin' );
		wp_enqueue_style( 'woocommerce_admin_styles' );

		wp_enqueue_script( 'shopmagic-admin-handler', SHOPMAGIC_PLUGIN_URL . 'assets/js/admin-handler.js', array(
			'jquery',
			'jquery-blockui',
			'wc-admin-meta-boxes',
			'wc-backbone-modal',
			'wp-util'
		), SHOPMAGIC_VERSION, true );

		wp_localize_script( 'shopmagic-admin-handler', 'ShopMagic', array(
				// URL to wp-admin/admin-ajax.php to process the request
				'ajaxurl'           => admin_url( 'admin-ajax.php' ),

				// generate a nonce with a unique ID "shopmagic-ajax-process-nonce"
				// so that you can check it later when an AJAX request is sent
				'paramProcessNonce' => wp_create_nonce( 'shopmagic-ajax-process-nonce' ),
			)
		);

		wp_enqueue_media();
		wp_enqueue_editor();
		?>
        <div style="display: none"><?php wp_editor( '', 'shopmagic_editor' ); ?></div><?php
	}

	/**
	 * Initializes admin page menu.
	 *
	 * Adds submenu in WooCommerce menu
	 *
	 * @since   1.0.0
	 */
	private function setup_admin_menu() {
		//Settings Menu Item
		add_submenu_page( 'edit.php?post_type=shopmagic_automation', __( 'Settings', 'shopmagic-for-woocommerce' ), __( 'Settings', 'shopmagic-for-woocommerce' ), 'manage_options', 'admin.php?page=wc-settings&tab=shopmagic', null );
	}
}
