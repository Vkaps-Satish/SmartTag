<?php 
/*
* Template Name:  Pet Professional Email Customer services
*/
get_header(); 
?>
<div class="container-wrap">		
	<div class="container main-content">
		<div class="row">
			<div class="col-sm-3 woo-sidebar">
				<?php echo do_shortcode("[stag_sidebar id='our-services']"); ?>
                &nbsp;
                <?php echo do_shortcode("[stag_sidebar id='main-sidebar']"); ?>
		    </div>
			<div class="col-sm-9">
				<div class="page-heading">
					<h1><?php echo get_the_title(); ?></h1>
				</div>
				<?php 
				if(have_posts()) : while(have_posts()) : the_post(); 
					if (has_post_thumbnail() ):
						the_post_thumbnail();
				    endif;
					the_content(); 
		
				endwhile; endif; 
				?>
			</div>
		</div>
	</div>
</div>
<?php get_footer(); ?>

