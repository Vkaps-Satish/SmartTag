<?php 
/*
* Template Name: Other product template
*/
get_header(); 

//Redirect user if user not login or not petprofessional
if ( is_user_logged_in() ){
     $current_user = wp_get_current_user();
     $roles = $current_user->roles; 

       if( !$roles == 'pet_professional' || !in_array( 'pet_professional', $roles )){
         print('<div>
        <div class="not-found-text width-100">This page is only for Pet-Professionals..</div></div>');
         die();
          }

    }else{
        print('<script>window.location.href="/pet-professionals-signup"</script>');
    }
     
?>
<div class="container-wrap">
	
	<div class="<?php if($page_full_screen_rows != 'on') echo 'container'; ?> main-content">
		
		<div class="row">
            <div class="woo-sidebar col-sm-3">
            <!-- <h3 class="widgettitle">Pet Professional</h3> -->
                <?php //echo do_shortcode("[wpb_childpages]");?>
                <?php echo do_shortcode("[stag_sidebar id='pet-professional-sidebar']"); ?>
                &nbsp;
                <?php echo do_shortcode("[stag_sidebar id='main-sidebar']"); ?>
            </div>

			<div class="col-sm-9 main-content-col">
                <div class="page-heading">
					<h1>Order Other Products</h1>
				</div>
				<ul class="products">
    <?php
        $args = array( 'post_type' => 'product', 'posts_per_page' => 10, 'product_cat' => 'other_products', 'orderby' => 'rand' );
        $loop = new WP_Query( $args );
        while ( $loop->have_posts() ) : $loop->the_post(); global $product; 
            ?>
                <li class="product">    

                    <a href="<?php echo get_permalink( $loop->post->ID ) ?>" title="<?php echo esc_attr($loop->post->post_title ? $loop->post->post_title : $loop->post->ID); ?>">

                        <?php woocommerce_show_product_sale_flash( $post, $product ); ?>

                        <?php if (has_post_thumbnail( $loop->post->ID )) echo get_the_post_thumbnail($loop->post->ID, 'shop_catalog'); else echo '<img src="'.wc_placeholder_img_src().'" alt="Placeholder" width="300px" height="300px" />'; ?>

                        <h3><?php the_title(); ?></h3>

                        <h4>Price</h4><span class="price"><?php echo $product->get_price_html(); ?></span>                    
                         <?php woocommerce_template_loop_add_to_cart( $loop->post, $product); ?>                 

                    </a>

                   

                </li>

    <?php endwhile; ?>
    <?php wp_reset_query(); ?>
</ul><!--/.products-->

             </div>
		</div><!--/row-->
		
	</div><!--/container-->
	
</div><!--/container-wrap-->

<?php get_footer(); ?>
