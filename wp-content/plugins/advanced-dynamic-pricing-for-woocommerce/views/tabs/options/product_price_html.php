<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>

<tr valign="top">
    <th scope="row" class="titledesc">
		<?php _e( 'Product price html template', 'advanced-dynamic-pricing-for-woocommerce' ) ?></th>
    <td class="forminp forminp-checkbox">
        <fieldset>
            <div>
                <label for="enable_product_html_template">
                    <input <?php checked( $options['enable_product_html_template'] ) ?> name="enable_product_html_template" id="enable_product_html_template" type="checkbox">
					<?php _e( 'Enable', 'advanced-dynamic-pricing-for-woocommerce' ) ?>
                </label>
            </div>
            <div>
                <label for="price_html_template">
					<?php _e( 'Output template', 'advanced-dynamic-pricing-for-woocommerce' ) ?>
                    <input style="min-width: 300px;" value="<?php echo $options['price_html_template'] ?>" name="price_html_template" id="price_html_template" type="text">
                </label>
                <br>
				<?php _e( 'Available tags', 'advanced-dynamic-pricing-for-woocommerce' ) ?> : <?php _e( '{{price_html}}, {{Nth_item}}, {{qty_already_in_cart}}', 'advanced-dynamic-pricing-for-woocommerce' ) ?>
            </div>
        </fieldset>
    </td>
</tr>