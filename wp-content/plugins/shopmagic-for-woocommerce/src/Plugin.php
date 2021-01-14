<?php
/**
 * Plugin main class.
 *
 * @package WPDesk\ShopMagic
 */

namespace WPDesk\ShopMagic;

use ShopMagic_CreateTables;
use ShopMagic_Twig_Templates_Support;
use ShopMagicVendor\WPDesk_Plugin_Info;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;
use Psr\Log\NullLogger;
use ShopMagicVendor\WPDesk\Logger\WPDeskLoggerFactory;
use ShopMagicVendor\WPDesk\PluginBuilder\Plugin\AbstractPlugin;
use ShopMagicVendor\WPDesk\PluginBuilder\Plugin\HookableCollection;
use ShopMagicVendor\WPDesk\PluginBuilder\Plugin\HookableParent;
use WPDesk\Notice\Notice;
use WPDesk\ShopMagic\Automation\Automation;
use WPDesk\ShopMagic\Action\ActionFactory;
use WPDesk\ShopMagic\Event\EventFactory;
use WPDesk\ShopMagic\Filter\FilterFactory;
use WPDesk\ShopMagic\Filter\Builtin\ProductPurchased;
use WPDesk\ShopMagic\Placeholder\PlaceholderFactory;

/**
 * Main plugin class. The most important flow decisions are made here.
 *
 * @package WPDesk\ShopMagic
 */
class Plugin extends AbstractPlugin implements LoggerAwareInterface, HookableCollection {
	use LoggerAwareTrait;
	use HookableParent;

	/** @var EventFactory */
	private $event_factory;

	/** @var FilterFactory */
	private $filter_factory;

	/** @var ActionFactory */
	private $action_factory;

	/** @var PlaceholderFactory */
	private $placeholder_factory;

	public function __construct( WPDesk_Plugin_Info $plugin_info ) {
		class_alias( self::class, 'ShopMagic' );

		$this->plugin_info = $plugin_info;
		/** @noinspection PhpParamsInspection */
		parent::__construct( $this->plugin_info );
		$this->setLogger( $this->is_debug_mode() ? ( new WPDeskLoggerFactory() )->createWPDeskLogger() : new NullLogger() );

		$this->define_constants();

		$this->plugin_url       = $this->plugin_info->get_plugin_url();
		$this->plugin_path      = $this->plugin_info->get_plugin_dir();
		$this->template_path    = $this->plugin_info->get_text_domain();
		$this->plugin_namespace = $this->plugin_info->get_text_domain();

		$this->event_factory       = new EventFactory();
		$this->filter_factory      = new FilterFactory();
		$this->action_factory      = new ActionFactory();
		$this->placeholder_factory = new PlaceholderFactory();

		( new \WPDesk\ShopMagic\Automation\PostType() )->hooks();
		new ShopMagic_CreateTables();

		// Initialize Welcome Page
		$this->initiate_welcome_page();
	}

	/**
	 * Setup Welcome Mat Redirect
	 *
	 * Select active automations,  register according events and setup its classes
	 *
	 * @since   1.0.0
	 */
	private function initiate_welcome_page() {

		// Add the transient on plugin activation.
		if ( ! function_exists( 'shopmagic_welcome_page' ) ) {

			// Hook that runs on plugin activation.
			register_activation_hook( SHOPMAGIC_BASE_FILE, 'welcome_activate' );
			/**
			 * Add the transient.
			 *
			 * Add the welcome page transient.
			 *
			 * @since 1.0.0
			 */
			function welcome_activate() {

				// Transient max age is 60 seconds.
				set_transient( '_welcome_redirect_shopmagic', true, 60 );
			}
		}
		// Delete the Transient on plugin deactivation.
		if ( ! function_exists( 'shopmagic_welcome_page' ) ) {
			// Hook that runs on plugin deactivation.
			register_deactivation_hook( SHOPMAGIC_BASE_FILE, 'welcome_deactivate' );

			/**
			 * Delete the Transient on plugin deactivation.
			 *
			 * Delete the welcome page transient.
			 *
			 * @since   2.0.0
			 */
			function welcome_deactivate() {
				delete_transient( '_welcome_redirect_shopmagic' );
			}
		}

		//Welcome Page Initiation
		if ( file_exists( __DIR__ . '/../includes/welcome/shopmagic_welcome-init.php' ) ) {
			require_once( __DIR__ . '/../includes/welcome/shopmagic_welcome-init.php' );
		}
	}


	/**
	 * Setup entities and perform requirements check for plugin.
	 *
	 * @since   1.0.0
	 */
	public function setup_entities() {

		if ( wp_doing_ajax() ) {
			do_action( 'shopmagic_initialize_product_filter' );
		}

	}


	/**
	 * For compatibility with WC 3.7 settings tab have to be loaded much earlier.
	 */
	public function settings_save_handle() {
		if ( is_admin() ) {
			new \ShopMagic_WC_Settings_Tab();
		}
	}


	/**
	 * Definition wrapper.
	 *
	 * Creates some useful def's in environment to handle
	 * plugin paths
	 *
	 * @since   1.0.0
	 */
	private function define_constants() {

		if ( ! defined( 'SHOPMAGIC_BASE_FILE' ) ) {
			define( 'SHOPMAGIC_BASE_FILE',
				$this->plugin_info->get_plugin_dir() . basename( $this->plugin_info->get_plugin_file_name() ) );
		}
		if ( ! defined( 'SHOPMAGIC_BASE_DIR' ) ) {
			define( 'SHOPMAGIC_BASE_DIR', $this->plugin_info->get_plugin_dir() );
		}
		if ( ! defined( 'SHOPMAGIC_PLUGIN_URL' ) ) {
			define( 'SHOPMAGIC_PLUGIN_URL', $this->plugin_info->get_plugin_url() . '/' );
		}
		if ( ! defined( 'SHOPMAGIC_PLUGIN_DIR' ) ) {
			define( 'SHOPMAGIC_PLUGIN_DIR', $this->plugin_info->get_plugin_dir() );
		}
		if ( ! defined( 'SHOPMAGIC_DIR_NAME' ) ) //Plugin Folder Name.
		{
			define( 'SHOPMAGIC_DIR_NAME', dirname( trim( $this->plugin_info->get_plugin_dir() ) ) );
		}

		//ShopMagic DB Version
		if ( ! defined( 'SHOPMAGIC_DB_VERSION' ) ) {
			define( 'SHOPMAGIC_DB_VERSION', '1.0' );
		}
		if ( ! defined( 'Logger' ) ) {
			define( 'Logger', 'Logger' );
		}
	}

	/**
	 * Returns true when debug mode is on.
	 *
	 * @return bool
	 */
	private function is_debug_mode() {
		return 'yes' === get_option( 'debug_mode', 'no' );
	}

	public function init() {
		parent::init();
		$this->init_tracker();
	}

	private function init_tracker() {
		$tracker_factory = new \WPDesk_Tracker_Factory();
		$tracker_factory->create_tracker( $this->plugin_info->get_plugin_file_name() );

		add_filter( 'wpdesk_track_plugin_deactivation', array( $this, 'wpdesk_track_plugin_deactivation' ) );
	}

	/**
	 * Init hooks.
	 *
	 * @return null
	 */
	public function hooks() {
		parent::hooks();

		require_once( __DIR__ . '/../includes/admin/ShopMagic_Admin-Alerts-Popups.php' );

		add_action( 'wp_loaded', function () {
			Automation::create_active_automations( $this->event_factory, $this->action_factory,
				$this->placeholder_factory );
		}, 30 );
		add_action( 'wp_loaded', array( $this, 'includes' ), 20 );
		add_action( 'wp_loaded', array( $this, 'settings_save_handle' ), 9 ); // before WC settings
//		add_action( 'wp_loaded', array( $this, 'product_purchased_filter_backward' ), 10 );
		add_action( 'admin_init', array( $this, 'setup_admin_area' ) );
		add_action( 'wp_loaded', array( $this, 'setup_entities' ), 20 );
		add_action( 'shopmagic_initialize_product_filter', array( $this, 'register_product_purchased_filter_ajax' ) );

		add_filter( 'mce_external_plugins', array( $this, 'setup_tinymce_pluign' ) );
		// Add TinyMCE custom button
		add_filter( 'mce_buttons', array( $this, 'add_tinymce_toolbar_button' ) );

		$this->hooks_on_hookable_objects();

		add_action( 'plugins_loaded', function () {
			do_action( 'shopmagic/core/initialized', $this->plugin_info->get_version() );
		} );

		return null;
	}

	public function wpdesk_track_plugin_deactivation( $plugins ) {
		$plugins['shopmagic-for-woocommerce/shopMagic.php'] = 'shopmagic-for-woocommerce/shopMagic.php';

		return $plugins;
	}

	/**
	 * Quick links on plugins page.
	 *
	 * @param array $links .
	 *
	 * @return array
	 */
	public function links_filter( $links ) {
		$plugin_links = [];

		$plugin_links[] = '<a href="' . admin_url( 'admin.php?page=wc-settings&tab=shopmagic' ) . '">' . __( 'Settings',
				'shopmagic-for-woocommerce' ) . '</a>';
		$plugin_links[] = '<a href="https://shopmagic.app/docs/" target="_blank">' . __( 'Docs',
				'shopmagic-for-woocommerce' ) . '</a>';
		$plugin_links[] = '<a href="https://wordpress.org/support/plugin/shopmagic-for-woocommerce/" target="_blank">' . __( 'Support',
				'shopmagic-for-woocommerce' ) . '</a>';

		if ( ! shopmagic_is_pro_active() ) {
			$plugin_links[] = '<a href="https://shopmagic.app/pricing/?utm_source=user-site&utm_medium=quick-link&utm_campaign=shopmagic-upgrade" target="_blank" style="color:#d64e07;font-weight:bold;">' . __( 'Upgrade',
					'shopmagic-for-woocommerce' ) . '</a>';
		}

		return array_merge( $plugin_links, $links );
	}

	/**
	 * Include wrapper.
	 *
	 * Includes core classes
	 * @since   1.0.0
	 */
	public function includes() {
		new ShopMagic_Twig_Templates_Support(); // TODO: now it makes no sense. Backward compatibility. Refactor in future.
	}

	/**
	 * Includes additional TinyMCE plugin, which is not shipped with WP
	 *
	 * @param array $plugins array of plugins
	 *
	 * @return array array of plugins
	 */
	public function setup_tinymce_pluign( $plugins ) {
		$plugins['imgalign'] = SHOPMAGIC_PLUGIN_URL . '/assets/js/tinymce/imgalign/plugin.js';

		return $plugins;
	}

	/**
	 * Adds a button to the TinyMCE / Visual Editor which the user can click
	 * to insert a link with a custom CSS class.
	 *
	 * @param array $buttons Array of registered TinyMCE Buttons
	 *
	 * @return array Modified array of registered TinyMCE Buttons
	 */
	function add_tinymce_toolbar_button( $buttons ) {
		array_push( $buttons, '|', 'imgalign' );

		return $buttons;
	}

	/**
	 * Run class ShopMagic_Product_Purchased_Filter for saving actions with products in settings page
	 * via Ajax (adding, deleting)
	 *
	 *
	 * @since   1.1.
	 */
	public function register_product_purchased_filter_ajax() {
		( new ProductPurchased( 0 ) )->initialize_ajax();
	}

	/**
	 * Setup admin area class
	 *
	 *
	 * @since   1.0.0
	 */
	public function setup_admin_area() {
		new \ShopMagic_Admin(
			$this->event_factory,
			$this->filter_factory,
			$this->action_factory
		);
	}
}
