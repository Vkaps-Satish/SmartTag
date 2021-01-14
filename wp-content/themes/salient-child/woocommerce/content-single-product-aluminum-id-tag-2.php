<?php
/**
 * The template for displaying product content in the single-product.php template
 *
 * Override this template by copying it to yourtheme/woocommerce/content-single-product.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly


if(isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] == site_url()."".$_SERVER['REQUEST_URI']){
	echo("<script>location.href = '".site_url()."/cart';</script>");
	exit();
}elseif(!isset($_SERVER['HTTP_REFERER']) || $_SERVER['HTTP_REFERER'] != site_url()."/my-account/free-replacement-tag" || !isset($_POST['serialNumber']) || empty($_POST['serialNumber'])){
	global $wp_query;
	$wp_query->set_404();
	status_header( 404 ); exit();
}
/**
 * woocommerce_before_single_product hook
 *
 * @hooked wc_print_notices - 10
 */
 do_action( 'woocommerce_before_single_product' );

 if ( post_password_required() ) {
 	echo get_the_password_form();
 	return;
 }


	 
$options = get_nectar_theme_options(); 
$product_style = (!empty($options['product_style'])) ? $options['product_style'] : 'classic';
// print_r($_POST);
?>

<div class="woo-complex-product woo-brass-product">
	<div itemscope data-project-style="<?php echo $product_style; ?>" itemtype="<?php echo woocommerce_get_product_schema(); ?>" data-tab-pos="<?php echo (!empty($options['product_tab_position'])) ? $options['product_tab_position'] : 'default'; ?>" id="product-<?php the_ID(); ?>" <?php post_class(); ?>>

		<?php
			/**
			 * woocommerce_before_single_product_summary hook
			 *
			 * @hooked woocommerce_show_product_sale_flash - 10
			 * @hooked woocommerce_show_product_images - 20
			 */
			do_action( 'woocommerce_before_single_product_summary' );
		?>

		<div class="summary entry-summary">

			<?php
				/**
				 * woocommerce_single_product_summary hook
				 *
				 * @hooked woocommerce_template_single_title - 5
				 * @hooked woocommerce_template_single_rating - 10
				 * @hooked woocommerce_template_single_price - 10
				 * @hooked woocommerce_template_single_excerpt - 20
				 * @hooked woocommerce_template_single_add_to_cart - 30
				 * @hooked woocommerce_template_single_meta - 40
				 * @hooked woocommerce_template_single_sharing - 50
				 */
				do_action( 'woocommerce_single_product_summary' );
			?>

		</div><!-- .summary -->

		<?php
			/**
			 * woocommerce_after_single_product_summary hook
			 *
			 * @hooked woocommerce_output_product_data_tabs - 10
			 * @hooked woocommerce_upsell_display - 15
			 * @hooked woocommerce_output_related_products - 20
			 */
			//do_action( 'woocommerce_after_single_product_summary' );
		?>

		<meta itemprop="url" content="<?php the_permalink(); ?>" />

	</div><!-- #product-<?php the_ID(); ?> -->
</div>
</div>

<?php do_action( 'woocommerce_after_single_product' ); ?>
