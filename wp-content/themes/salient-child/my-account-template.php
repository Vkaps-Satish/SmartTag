<?php 
/*
Template Name: My Account
*/
get_header(); 
nectar_page_header($post->ID); 

//full page
$fp_options = nectar_get_full_page_options();
extract($fp_options);
?>

<?php $thumb = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'full' );?>
	<?php
    if(has_post_thumbnail()) { ?>
        <div class="page-featured-img ma-banner-img" 11222>
            <img src='<?php echo $thumb['0'];?>' alt='image' />
        </div>
<?php } ?>

<div class="container-wrap">
	<div class="<?php if($page_full_screen_rows != 'on') echo 'container'; ?> main-content">
		
		<div class="row">

			<div class="col-sm-12 main-content-col">

				<?php 

				//breadcrumbs
				if ( function_exists( 'yoast_breadcrumb' ) && !is_home() && !is_front_page() ){ yoast_breadcrumb('<p id="breadcrumbs">','</p>'); } 

				 //buddypress
				 global $bp; 
				 if($bp && !bp_is_blog_page()) echo '<h1>' . get_the_title() . '</h1>';
				
				 //fullscreen rows
				 if($page_full_screen_rows == 'on') echo '<div id="nectar_fullscreen_rows" data-animation="'.$page_full_screen_rows_animation.'" data-row-bg-animation="'.$page_full_screen_rows_bg_img_animation.'" data-animation-speed="'.$page_full_screen_rows_animation_speed.'" data-content-overflow="'.$page_full_screen_rows_content_overflow.'" data-mobile-disable="'.$page_full_screen_rows_mobile_disable.'" data-dot-navigation="'.$page_full_screen_rows_dot_navigation.'" data-footer="'.$page_full_screen_rows_footer.'" data-anchors="'.$page_full_screen_rows_anchors.'">';

					 if(have_posts()) : while(have_posts()) : the_post(); 
						
						 the_content(); 
			
					 endwhile; endif; 
					
				if($page_full_screen_rows == 'on') echo '</div>'; ?>

			</div>

		</div><!--/row-->
		
	</div><!--/container-->
	
</div><!--/container-wrap-->

<?php get_footer(); ?>