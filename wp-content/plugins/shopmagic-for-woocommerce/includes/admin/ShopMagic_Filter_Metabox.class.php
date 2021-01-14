<?php
/**
 * ShopMagic's Filter Meta Box.
 *
 * Prepare and show Filter value of automation post type
 *
 * @package ShopMagic
 * @version 1.0.0
 * @since   1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * ShopMagic Filter Meta Box class
 *
 * @package ShopMagic
 * @since   1.0.0
 */
class ShopMagic_Filter_Metabox {

	/** @var \WPDesk\ShopMagic\Filter\FilterFactory */
	private $filter_factory;

	function __construct( \WPDesk\ShopMagic\Filter\FilterFactory $filter_factory ) {
		$this->filter_factory = $filter_factory;
		$this->add_actions();
		$this->setup();
	}

	/**
	 * Setup metabox.
	 *
	 * @since   1.0.0
	 */
	function setup() {
		add_meta_box( 'shopmagic_filter_metabox', __( 'Filter', 'shopmagic-for-woocommerce' ), array(
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
		add_action( 'wp_ajax_shopmagic_load_filter_params', array( $this, 'load_filter_params' ) );
	}

	public function load_filter_params() {

		// check nonce
		$nonce = $_POST['paramProcessNonce'];
		if ( ! wp_verify_nonce( $nonce, 'shopmagic-ajax-process-nonce' ) ) {
			wp_die();
		} // we don't talk with terrorists

		$filter       = sanitize_text_field( $_POST['filter_slug'] );
		$post_id      = intval( $_POST['post'] );
		$filter_class = $this->filter_factory->get_filter_class( $filter );
		if ( $filter_class ) {

			ob_start();
			$filter_class::show_parameters( $post_id );
			$filter_box = ob_get_contents();
			ob_end_clean();

			echo json_encode( array(
					'filter_box'      => $filter_box,
					'description_box' => $filter_class::get_description(),
				)
			);

		}
		wp_die();

	}

	/**
	 * Display metabox in admin side
	 *
	 * @param WP_Post $post
	 *
	 * @since   1.0.0
	 */
	function draw_metabox( $post ) {
		// initialize available filters
		$filters = $this->filter_factory->get_event_classes_list();
		wp_nonce_field( plugin_basename( SHOPMAGIC_BASE_FILE ), 'shopmagic_filter_meta_box' );
		$filter_slug = get_post_meta( $post->ID, '_filter', true );
		?>

		<table class="shopmagic-table">
			<tbody>
			<tr class="shopmagic-field">
				<td class="shopmagic-label">
					<label for="_filter">Filter</label>

					<div id="filter-desc-area">
						<p class="content"></p>
					</div>
				</td>

				<td class="shopmagic-input">
					<select name="_filter" id="_filter" title="<?php _e( 'Filter', 'shopmagic-for-woocommerce' ); ?>">
						<option value="" <?php selected( "", $filter_slug ); ?>><?php _e( 'Select...',
								'shopmagic-for-woocommerce' ); ?></option>

						<?php foreach ( $filters as $slug => $filter ) { ?>
							<option value="<?php echo $slug; ?>" <?php selected( $slug,
								$filter_slug ); ?>><?php echo $filter::get_name(); ?></option>
						<?php } ?>
					</select>

					<div class="error-icon"><span class="dashicons dashicons-warning"></span>
						<div class="error-icon-tooltip">Network connection error</div>
					</div>

					<div class="spinner"></div>
				</td>
			</tr>

			<tr>
				<td id="filter-config-area" class="config-area" colspan="2"></td>
			</tr>
			</tbody>
		</table>
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
		if ( isset( $_POST['post_type'] ) && $_POST['post_type'] == 'shopmagic_automation' && isset( $_POST['_filter'] ) ) {

			// if auto saving skip saving our meta box data
			if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
				return;
			}

			$filter = sanitize_text_field( $_POST['_filter'] );

			//check nonce for security
			wp_verify_nonce( plugin_basename( SHOPMAGIC_BASE_FILE ), 'shopmagic_filter_meta_box' );

			// save the meta box data as post meta using the post ID as a unique prefix
			update_post_meta( $post_id, '_filter', $filter );

			// process filter-specific save
			$filter_class = $this->filter_factory->get_filter_class( $filter );
			if ( $filter_class ) {
				$filter_class::save_parameters( $post_id );
			}
		}

	}

}
