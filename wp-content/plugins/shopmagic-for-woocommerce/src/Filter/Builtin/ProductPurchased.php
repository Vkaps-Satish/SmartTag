<?php

namespace WPDesk\ShopMagic\Filter\Builtin;

use WPDesk\ShopMagic\DataSharing\DataProvider;
use WPDesk\ShopMagic\Event\Event;
use WPDesk\ShopMagic\Event\OrderCommonEvent;
use WPDesk\ShopMagic\Filter\BasicFilter;

/**
 * ShopMagic Product Purchased Filter class
 *
 * @package ShopMagic
 * @since   1.2.5
 */
final class ProductPurchased extends BasicFilter {
	private $automation_id;

	public static function get_name() {
		return __( 'Product', 'shopmagic-for-woocommerce' );
	}

	public static function get_description() {
		return __( 'Filter for specified product.', 'shopmagic-for-woocommerce' );
	}

	public static function get_required_data_domains() {
		return [ \WC_Order::class ];
	}

	public function __construct( $automation_id ) {
		$this->automation_id = $automation_id;
	}

	public function initialize_ajax() {
		add_action( 'wp_ajax_shopmagic_product_purchased_event_save', array( $this, 'save_products_list' ) );
		add_action( 'wp_ajax_shopmagic_ajax_product_search_action', array( $this, 'shopmagic_ajax_product_search' ) );
	}

	/**
	 * Checks if filter allows event to be executed.
	 *
	 * @param Event $event
	 *
	 * @return bool True if event can be executed.
	 */
	public function passed( DataProvider $event ) {
		/** @var \WC_Order $order */
		$order = $event->get_provided_data()[ \WC_Order::class ];

		$product_list = get_post_meta( $this->automation_id, '_event_product_list', true );
		if ( ! is_array( $product_list ) ) { // no one product in the event
			return false;
		}

		$items        = $order->get_items();
		$has_products = false;
		foreach ( $items as $item ) {
			if ( in_array( $item['product_id'], $product_list ) ) {
				$has_products     = true;
				break;
			}

			if ( in_array( $item['variation_id'], $product_list ) ) {
				$has_products       = true;
				break;
			}

		}

		return $has_products;

	}

	function save_products_list() {

		// check nonce
		$nonce = $_POST['paramProcessNonce'];
		if ( ! wp_verify_nonce( $nonce, 'shopmagic-ajax-process-nonce' ) ) {
			wp_die();
		} // we don't talk with terrorists

		$post_id = intval( $_POST['post'] );
		self::save_parameters( $post_id );

		wp_die();
	}

	/**
	 * Pull WooCommerce Products from Database
	 *
	 * @since 1.2.5
	 */
	function shopmagic_ajax_product_search() {
		$term = sanitize_text_field( $_POST['sm_add_order_items'] );

		/** @var \WC_Product_Data_Store_CPT $data_store */
		$data_store = \WC_Data_Store::load( 'product' );
		$ids        = $data_store->search_products( $term, '', true, false, 10 );
		$products   = array_filter( array_map( 'wc_get_product', $ids ) );

		$items = array_map( function ( $product ) {
			/** @var $product \WC_Product */
			return [
				'id'   => $product->get_id(),
				'text' => "{$product->get_name()} - (#{$product->get_id()})"
			];
		}, $products );

		echo json_encode( $items );

		wp_die();
	}

	/**
	 * Show parameters window in an admin side widget
	 *
	 * @param $automation_id integer current displayed automation
	 *
	 * @since   1.2.5
	 */
	static function show_parameters( $automation_id ) {
		?>
		<div id="woocommerce-order-items">
			<table class="shopmagic-table">
				<tbody id="order_line_items">
				<tr class="shopmagic-field">
					<td class="shopmagic-label">
						<label><?php _e( 'Product for watching', 'shopmagic-for-woocommerce' ); ?></label>
					</td>

					<td class="shopmagic-input">
						<table>
							<tbody>
							<?php
							$product_list  = get_post_meta( $automation_id, '_event_product_list', true );
							if ( is_array( $product_list ) ):

								foreach ( $product_list as $product_id ):
									$product = wc_get_product( $product_id );
									$title = "{$product->get_name()} - (#{$product->get_id()})";
									?>
									<tr class="item new_row" data-order_item_id="<?php echo $product->get_id(); ?>">
										<td class="name" data-sort-value="<?php echo $product->get_name(); ?>"
										    width="100%">
											<?php echo $title; ?>
											<input type="hidden" class="order_item_id" name="order_item_id[]" value="4">
											<span class="wc-order-edit-line-item-actions">
                                                        <a class="delete-order-item tips" href="#"></a>
                                                    </span>
										</td>
									</tr>
								<?php
								endforeach;
							endif;
							?>
							</tbody>
						</table>

						<button type="button" <?php echo ! empty( $product_list ) ? "disabled" : ''; ?>
						        class="button add-order-item"><?php _e( 'Add product', 'woocommerce' ); ?></button>
					</td>
				</tr>
				</tbody>
			</table>

			<script type="text/template" id="tmpl-wc-modal-add-products">
				<div class="wc-backbone-modal">
					<div class="wc-backbone-modal-content">
						<section class="wc-backbone-modal-main" role="main">
							<header class="wc-backbone-modal-header">
								<h1><?php _e( 'Add products', 'woocommerce' ); ?></h1>
								<button class="modal-close modal-close-link dashicons dashicons-no-alt">
									<span class="screen-reader-text">Close modal panel</span>
								</button>
							</header>
							<article style="height: 100px">
								<form action="" method="post">
									<select id="sm-ajax-search-field" name="sm_add_order_items">
										<option></option>
									</select>
								</form>
							</article>
							<footer>
								<div class="inner">
									<button id="btn-ok"
									        class="button button-primary button-large"><?php _e( 'Add',
											'woocommerce' ); ?></button>
								</div>
							</footer>
						</section>
					</div>
				</div>
				<div class="wc-backbone-modal-backdrop modal-close"></div>
			</script>
		</div>
		<script>
			jQuery(function ($) {

				/**
				 * Order Items Panel
				 */
				var wc_meta_boxes_order_items = {
					init: function () {
						this.stupidtable.init();

						$('#woocommerce-order-items')
							.on('click', 'button.add-line-item', this.add_line_item)
							.on('click', '.cancel-action', this.cancel)
							.on('click', 'button.add-order-item', this.add_item)
							.on('click', 'button.save-action', this.save_line_items)
							.on('click', 'a.edit-order-item', this.edit_item)
							.on('click', 'a.delete-order-item', this.delete_item)
							.on('click', 'tr.item, tr.fee, tr.shipping, tr.refund', this.select_row)
							.on('click', 'tr.item :input, tr.fee :input, tr.shipping :input, tr.refund :input, tr.item a, tr.fee a, tr.shipping a, tr.refund a', this.select_row_child)


						$(document.body)
							.on('wc_backbone_modal_loaded', this.backbone.init)
							.on('wc_backbone_modal_response', this.backbone.response);
					},

					block: function () {
						$('#woocommerce-order-items').block({
							message: null,
							overlayCSS: {
								background: '#fff',
								opacity: 0.6
							}
						});
					},

					unblock: function () {
						$('#woocommerce-order-items').unblock();
					},

					reload_items: function () {
						var data = {
							order_id: woocommerce_admin_meta_boxes.post_id,
							action: 'woocommerce_load_order_items',
							security: woocommerce_admin_meta_boxes.order_item_nonce
						};

						wc_meta_boxes_order_items.block();

						$.ajax({
							url: "<?php echo admin_url( 'admin-ajax.php' ); ?>",
							data: data,
							type: 'POST',
							success: function (response) {
								$('#woocommerce-order-items').find('.inside').empty();
								$('#woocommerce-order-items').find('.inside').append(response);
								wc_meta_boxes_order.init_tiptip();
								wc_meta_boxes_order_items.unblock();
								wc_meta_boxes_order_items.stupidtable.init();
							}
						});
					},


					add_line_item: function () {
						$('div.wc-order-add-item').slideDown();
						$('div.wc-order-data-row-toggle').not('div.wc-order-add-item').slideUp();
						return false;
					},

					cancel: function () {
						$('div.wc-order-data-row-toggle').not('div.wc-order-bulk-actions').slideUp();
						$('div.wc-order-bulk-actions').slideDown();
						$('div.wc-order-totals-items').slideDown();
						$('#woocommerce-order-items').find('div.refund').hide();
						$('.wc-order-edit-line-item .wc-order-edit-line-item-actions').show();

						// Reload the items
						if ('true' === $(this).attr('data-reload')) {
							wc_meta_boxes_order_items.reload_items();
						}

						return false;
					},

					add_item: function () {
						console.log('add_item');
						$(this).WCBackboneModal({
							template: 'wc-modal-add-products'
						});

						return false;
					},


					delete_item: function () {
						//var answer = window.confirm( woocommerce_admin_meta_boxes.remove_item_notice );
						var answer = window.confirm('Do you really want to delete the product?');

						if (answer) {
							var $item = $(this).closest('tr.item, tr.fee, tr.shipping');
							var order_item_id = $item.attr('data-order_item_id');

							wc_meta_boxes_order_items.block();

							var data = {
								action: 'shopmagic_product_purchased_event_save',
								item_to_remove: order_item_id,
								paramProcessNonce: ShopMagic.paramProcessNonce,
								post: $("#post_ID").val()

							};

							$.ajax({
								url: "<?php echo admin_url( 'admin-ajax.php' ); ?>",
								data: data,
								type: 'POST',
								success: function () {
									// $row.remove();
									//wc_meta_boxes_order_items.unblock();
									$("#_filter").trigger('change');
								}
							});

						}
						return false;
					},


					backbone: {

						init: function (e, target) {
							if ('wc-modal-add-products' === target) {
								$(document.body).trigger('wc-enhanced-select-init');
							}

							// multiple select with AJAX search
							$('#sm-ajax-search-field').select2({
								placeholder: "Click here to search",
								allowClear: true,
								ajax: {
									url: "<?php echo admin_url( 'admin-ajax.php' ); ?>", // AJAX URL is predefined in WordPress admin
									type: "POST",
									dataType: 'json',
									delay: 300, // delay in ms while typing when to perform a AJAX search
									data: function (params) {
										return {
											action: "shopmagic_ajax_product_search_action", // AJAX action for admin-ajax.php
											sm_add_order_items: params.term,
										};
									},
									processResults: function (data) {
										var options = [];
										if (data) {

											// data is the array of arrays, and each of them contains ID and the Label of the option
											$.each(data, function (index, item) { // do not forget that "index" is just auto incremented value
												options.push({id: item.id, text: item.text});
											});

										}
										return {
											results: options
										};
									},
									cache: true
								},
								minimumInputLength: 3 // the minimum of symbols to input before perform a search
							});
						},

						response: function (e, target, data) {
							if ('wc-modal-add-tax' === target) {
								var rate_id = data.add_order_tax;
								var manual_rate_id = '';

								if (data.manual_tax_rate_id) {
									manual_rate_id = data.manual_tax_rate_id;
								}

								wc_meta_boxes_order_items.backbone.add_tax(rate_id, manual_rate_id);
							}
							if ('wc-modal-add-products' === target) {
								wc_meta_boxes_order_items.backbone.add_item(data.sm_add_order_items);
							}
						},

						add_item: function (add_item_ids) {
							add_item_ids = add_item_ids.split(',');

							if (add_item_ids) {
								var data = {
									action: 'shopmagic_product_purchased_event_save',
									items_to_add: add_item_ids,
									paramProcessNonce: ShopMagic.paramProcessNonce,
									post: $("#post_ID").val()

								};
								wc_meta_boxes_order_items.block();
								$.ajax({
									url: "<?php echo admin_url( 'admin-ajax.php' ); ?>",
									data: data,
									type: 'POST',
									success: function () {
										// $row.remove();
										//wc_meta_boxes_order_items.unblock();
										$("#_filter").trigger('change');
										//$('.add-order-item').attr('disabled', 'disabled');
									}
								});

								//console.log('products');
								///console.log(value);

							}
						}
					},

					stupidtable: {
						init: function () {
							$('.woocommerce_order_items').stupidtable();
							$('.woocommerce_order_items').on('aftertablesort', this.add_arrows);
						},

						add_arrows: function (event, data) {
							var th = $(this).find('th');
							var arrow = data.direction === 'asc' ? '&uarr;' : '&darr;';
							var index = data.column;
							th.find('.wc-arrow').remove();
							th.eq(index).append('<span class="wc-arrow">' + arrow + '</span>');
						}
					}
				};
				wc_meta_boxes_order_items.init();

			});
		</script>
		<?php
	}

	/**
	 * Save parameters from POST request, called from an admin side widget
	 *
	 * @param $automation_id integer current displayed automation
	 *
	 * @since   1.2.5
	 */
	static function save_parameters( $automation_id ) {
		// because previous functions already check nonces (ajax or post)
		// we don't check security nonces here
		$product_list = array();
		$ajax_called  = false;
		if ( isset( $_POST['items_to_add'] ) ) { // this is ajax call, update list of items
			$new_items    = array_map( "intval", $_POST['items_to_add'] );
			$product_list = get_post_meta( $automation_id, '_event_product_list', true );
			if ( ! is_array( $product_list ) ) {
				$product_list = $new_items;
			} else {
				$product_list = array_unique( array_merge( $product_list, $new_items ) );
			}

			$ajax_called = true;
		}

		if ( isset( $_POST['item_to_remove'] ) ) { // this is ajax call, remove list of items
			$del_item     = intval( $_POST['item_to_remove'] );
			$product_list = get_post_meta( $automation_id, '_event_product_list', true );
			if ( is_array( $product_list ) ) {
				$product_list = array_diff( $product_list, array( $del_item ) );
			}

			$ajax_called = true;
		}

		if ( $ajax_called ) {
			update_post_meta( $automation_id, '_event_product_list', $product_list );
		}
	}

}
