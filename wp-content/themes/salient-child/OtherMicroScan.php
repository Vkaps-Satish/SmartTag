<?php 
/*
* Template Name: Other Microchip & Scanners
*/
//Redirect user if user not login or not petprofessional
if ( is_user_logged_in() ){
  $current_user = wp_get_current_user();
  $roles = $current_user->roles; 

  if( !$roles == 'pet_professional' || !in_array( 'pet_professional', $roles )){
    print('<script>window.location.href="/product-category/microchip-scanners/id-tags-products-microchips-and-scanners/"</script>');
    die();
  }

}else{
  print('<script>window.location.href="/product-category/microchip-scanners/id-tags-products-microchips-and-scanners/"</script>');
}
get_header(); 


?>
<div class="container-wrap">
	<div class="<?php if($page_full_screen_rows != 'on') echo 'container'; ?> main-content">
		<div class="row">
            <div class="woo-sidebar col-sm-3">
                <?php echo do_shortcode("[stag_sidebar id='pet-professional-sidebar']"); ?>
                &nbsp;
                <?php echo do_shortcode("[stag_sidebar id='main-sidebar']");?>
                &nbsp;
                <?php echo do_shortcode("[stag_sidebar id='search-microchip']");?>
            </div>

			<div class="col-sm-9 main-content-col">
                <div class="page-heading">
					<h1>Order Microchip & Scanners</h1>
				</div>
          <ul class="products" data-product-style="classic">
            <?php
                    $args = array( 'post_type' => 'product', 'posts_per_page' => 10, 'product_cat' => 'microchip-scanners' );
                    $loop = new WP_Query( $args );
                    while ( $loop->have_posts() ) : $loop->the_post(); global $product; 
                    ?>
             <li class="classic  product type-product status-publish has-post-thumbnail product_cat-id-tags-products-microchips-and-scanners first instock shipping-taxable purchasable product-type-simple">
                <div class="product-wrap">
                   <a href="<?php echo get_permalink( $loop->post->ID ) ?>" title="<?php echo esc_attr($loop->post->post_title ? $loop->post->post_title : $loop->post->ID); ?>">
                      <?php if (has_post_thumbnail( $loop->post->ID )) echo get_the_post_thumbnail($loop->post->ID, 'shop_catalog'); else echo '<img src="'.woocommerce_placeholder_img_src().'" alt="Placeholder" width="150" height="150" />'; ?>
                      <h2 class="woocommerce-loop-product__title"><?= the_title(); ?></h2>
                      <span class="price"><span>Price: </span><span class="woocommerce-Price-amount amount"><span class="woocommerce-Price-currencySymbol"></span><?php echo $product->get_price_html(); ?></span></span>
                   </a>
                   <?php woocommerce_template_loop_add_to_cart( $loop->post, $product); ?>
                </div>
             </li>
             <?php endwhile; ?>
                <?php wp_reset_query(); ?>
          </ul>
            </div>
	</div><!--/row-->
</div><!--/container-->
	
</div><!--/container-wrap-->

<?php get_footer(); ?>
