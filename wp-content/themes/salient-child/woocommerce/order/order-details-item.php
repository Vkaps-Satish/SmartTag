<?php
/**
 * Order Item Details
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/order/order-details-item.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 3.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! apply_filters( 'woocommerce_order_item_visible', true, $item ) ) {
	return;
}
// print_r($product); 6089, 6033
?>
<tr class="<?php echo esc_attr( apply_filters( 'woocommerce_order_item_class', 'woocommerce-table__line-item order_item', $item, $order ) ); ?> cart_item" >

	<td class="product-thumbnail">
		<?php  
			$product = apply_filters( 'woocommerce_order_item_product', $order->get_product_from_item( $item ), $item );
			$data  = $item->get_formatted_meta_data();
			$productId = $item->get_product_id();
			if ( $productId == 6089 || $productId == 6033 || $productId == 7722 || $productId == 7659) {
				echo "<div class='row'></div>";
			}else{
				echo $product->get_image();
			}
			$cart_item = array();
			foreach ($item->get_meta_data() as $key => $value) {
				$dataa = $value->get_data();
				if (isset($dataa['key']) && $dataa['key'] == 'info') {
					$cart_item['info'] = $dataa['value'];
				}
			}
		?>
	</td>
	<td class="product-name">
		<?php
			$is_visible        = $product && $product->is_visible();
			$product_permalink = apply_filters( 'woocommerce_order_item_permalink', $is_visible ? $product->get_permalink( $item ) : '', $item, $order );

			echo apply_filters( 'woocommerce_order_item_name', $product_permalink ? sprintf( '<a href="%s">%s</a>', $product_permalink, $item->get_name() ) : $item->get_name(), $item, $is_visible );
			echo apply_filters( 'woocommerce_order_item_quantity_html', ' <strong class="product-quantity">' . sprintf( '&times; %s', $item->get_quantity() ) . '</strong>', $item );

			do_action( 'woocommerce_order_item_meta_start', $item_id, $item, $order, false );
			echo '<dl class="variation">';
			foreach ($data as $value) {
				$class = explode(' ',strip_tags($value->display_key));
				$class = implode('', $class);
				/*if (!in_array($value->key, array('back_line_1','back_line_2','back_line_3','back_line_4','front_line_img','front_line_1','front_line_2','front_line_3','front_line_4','back_line_img'))) {*/
					echo '<dt class="variation-'.$class.'">'.$value->display_key.':</dt><dd class="variation-'.$class.'"> '.$value->display_value.'</dd>';
				// }
				
			}
			echo "</dl>";
			// wc_display_item_meta( $item );

			if (isset($cart_item['info']) && !empty($cart_item)) { 
				$cart_item_infos = $cart_item['info'];
				foreach ($cart_item_infos as $key => $cart_item_info) {?>
					<div class="cart-extra-info">
						<div class="item item-<?php echo $key+1; ?>">
							<div class="user-info">
								<div class="title"><h4>User Info:- </h4></div>
								<div class="row">
									<div class="col-sm-4 font-bold">Name: </div>
									<div class="col-sm-8 break-word"><?php echo $cart_item_info['firstName']." ".$cart_item_info['lastName']; ?></div>
								</div>
								<div class="row">
									<div class="col-sm-4 font-bold">Email: </div>
									<div class="col-sm-8 break-word"><?php echo $cart_item_info['email']; ?></div>
								</div>
							</div>
							<div class="pet-info">
								<div class="title"><h4>Pet Info:- </h4></div>
								<div class="row">
									<div class="col-sm-4 font-bold">Name: </div>
									<div class="col-sm-8 break-word"><?php echo $cart_item_info['petName']; ?></div>
								</div>
								<div class="row">
									<div class="col-sm-4 font-bold">Company: </div>
									<div class="col-sm-8 break-word"><?php echo $cart_item_info['microCm']; ?></div>
								</div>
								<div class="row">
									<div class="col-sm-4 font-bold">Microchip Id: </div>
									<div class="col-sm-8 break-word"> <?php echo $cart_item_info['microId']; ?></div>
								</div>
							</div>
						</div>
					</div>
				<?php }
			}	

			do_action( 'woocommerce_order_item_meta_end', $item_id, $item, $order, false );
		?>
	</td>
	<td class="woocommerce-table__product-total product-total">
		<?php echo $order->get_formatted_line_subtotal( $item ); ?>
	</td>

</tr>

<?php if ( $show_purchase_note && $purchase_note ) : ?>

<tr class="woocommerce-table__product-purchase-note product-purchase-note">

	<td colspan="2"><?php echo wpautop( do_shortcode( wp_kses_post( $purchase_note ) ) ); ?></td>

</tr>

<?php endif; ?>

