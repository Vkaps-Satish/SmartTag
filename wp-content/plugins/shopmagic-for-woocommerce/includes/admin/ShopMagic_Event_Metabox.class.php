<?php
/**
 * ShopMagic's Event Meta Box.
 *
 * Prepare and show Event value of automation post type
 *
 * @package ShopMagic
 * @version 1.0.0
 * @since   1.0.0
 */

// Exit if accessed directly
use WPDesk\ShopMagic\Event\EventFactory;
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
class ShopMagic_Event_Metabox {
	/** @var EventFactory */
	private $event_factory;

	function __construct( EventFactory $event_factory ) {
		$this->event_factory = $event_factory;
		$this->add_actions();
		$this->setup();
	}

	/**
	 * Setup metabox.
	 *
	 * @since   1.0.0
	 */
	function setup() {
		add_meta_box( 'shopmagic_event_metabox', __( 'Event', 'shopmagic-for-woocommerce' ), array(
			$this,
			'draw_metabox'
		), 'shopmagic_automation', 'normal' );

	}

	/**
	 * Adds action hooks.
	 *
	 * @since   1.0.0
	 */
	private function add_actions() {
		add_action( 'save_post', array( $this, 'save_metabox' ) );
		add_action( 'wp_ajax_shopmagic_load_event_params', array( $this, 'load_event_params' ) );
	}

	public function load_event_params() {

		// check nonce
		$nonce = $_POST['paramProcessNonce'];
		if ( ! wp_verify_nonce( $nonce, 'shopmagic-ajax-process-nonce' ) ) {
			wp_die();
		} // we don't talk with terrorists

		$event       = sanitize_text_field( $_POST['event_slug'] );
		$post_id     = intval( $_POST['post'] );
		$event_class = $this->event_factory->get_event_class( $event );
		if ( $event_class ) {

			ob_start();
			$event_class::show_parameters( $post_id );
			$event_box = ob_get_contents();
			ob_end_clean();

			$placeholders = new PlaceholderFactory();

			echo json_encode( array(
					'event_box'        => $event_box,
					'description_box'  => $event_class::get_description(),
					'placeholders_box' => $this->render_placeholders( $placeholders->get_placeholder_list_to_handle( $event_class ) ),
					'data_domains'     => $event_class::get_provided_data_domains(),
				)
			);

		}
		wp_die();
	}

	/**
	 * @param WPDesk\ShopMagic\Placeholder\Placeholder[] $placeholders
	 *
	 * @return string
	 */
	private function render_placeholders( array $list ) {
		$list = PlaceholderFactory::convert_to_admin_slug_names($list);
		return implode("<br />", $list);
	}


	/**
	 * Display metabox in admin side
	 *
	 * @param WP_Post $post
	 *
	 * @since   1.0.0
	 */
	function draw_metabox( $post ) {
		// initialize available events
		$events = $this->event_factory->get_event_classes_list();
		wp_nonce_field( plugin_basename( SHOPMAGIC_BASE_FILE ), 'shopmagic_event_meta_box' );
		$event_slug = get_post_meta( $post->ID, '_event', true );
		?>
		<div id="_shopmagic_edit_page"></div>
		<div class="shopmagic-fields -left">
			<div class="shopmagic-field">
				<div class="shopmagic-label">
					<label for="_event"><?php _e( 'Event', 'shopmagic-for-woocommerce' ); ?></label>

					<div id="event-desc-area">
						<p class="content"></p>

						<span class="tips"
						      data-tip="<?php _e( 'Make sure that you are placing an order using the front-end of your store when testing automations, not by clicking the Add Order button in WooCommerce &rarr; Orders. If you\'re still not receiving emails, click to read our guide.', 'shopmagic-for-woocommerce' ); ?>"><a
								href="https://shopmagic.app/knowledgebase/my-automation-emails-are-not-being-sent-out/"
								target="_blank"><?php _e( ' Automations not working?', 'shopmagic-for-woocommerce' ); ?></a></span>
					</div>
				</div>

				<div class="shopmagic-input">
					<select name="_event" id="_event" title="<?php _e( 'Event', 'shopmagic-for-woocommerce' ); ?>">

						<option
							value="" <?php selected( '', $event_slug ); ?>><?php _e( 'Select...', 'shopmagic-for-woocommerce' ); ?></option>
						<?php
						// order all events by group
						/**
						 * compares events by groups object
						 *
						 * @param WPDesk\ShopMagic\Event\Event $a
						 * @param WPDesk\ShopMagic\Event\Event $b
						 *
						 * @return int compare result
						 */
						function cmp( $a, $b ) {
							return strcmp( $a::get_group_slug(), $b::get_group_slug() );
						}

						uasort( $events, 'cmp' );

						$prevGroup = '';
						foreach ( $events as $slug => $event ) {
							if ( $prevGroup != $event::get_group_slug() ) { // group was changed
								if ( $prevGroup != '' ) {
									echo '</optgroup>';
								}

								echo '<optgroup label="' . $this->event_factory->event_group_name( $event::get_group_slug() ) . '">';

								$prevGroup = $event::get_group_slug();
							}

							echo '<option value="' . $slug . '" ' . selected( $slug, $event_slug, false ) . '>' . $event::get_name() . '</option>';
						}
						?>
						</optgroup>
					</select>

					<div class="error-icon">
						<span class="dashicons dashicons-warning"></span>

						<div class="error-icon-tooltip">Network connection error</div>
					</div>

					<div class="spinner"></div>

				</div>
			</div>

			<div id="event-config-area"></div>
		</div>
		<?php
	}

	/**
	 * Post save processor
	 *
	 * @param string $post_id
	 *
	 * @since   1.0.0
	 */
	function save_metabox( $post_id ) {

		// process form data if $_POST is set
		if ( isset( $_POST['post_type'] ) && $_POST['post_type'] === 'shopmagic_automation' && isset( $_POST['_event'] ) ) {

			// if auto saving skip saving our meta box data
			if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
				return;
			}

			$event = sanitize_text_field( $_POST['_event'] );

			//check nonce for security
			wp_verify_nonce( plugin_basename( SHOPMAGIC_BASE_FILE ), 'shopmagic_event_meta_box' );

			// save the meta box data as post meta using the post ID as a unique prefix
			update_post_meta( $post_id, '_event', $event );

			// process event-specific save
			$event_class = $this->event_factory->get_event_class( $event );
			if ( $event_class ) {
				$event_class::save_parameters( $post_id );
			}
		}
	}
}
