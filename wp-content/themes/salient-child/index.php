
<?php get_header(); ?>

<?php nectar_page_header(get_option('page_for_posts')); ?>
<div class="container-wrap">
		
	<div class="container main-content">
		
		<div class="row">

			<div class="col-sm-9">
				
				<div class="blog-content">
					<div class="blog-list-wrap">

						<?php 
						$cat_id = get_queried_object_id();
						if(have_posts()) : while(have_posts()) : the_post(); ?>
						<div class="blog-list">
							<div class="blog-img">
								<a href="<?php echo get_permalink(get_the_id()); ?>"><?php echo get_the_post_thumbnail(); ?></a>
							</div>
							<div class="blog-list-content">
								<h3 class="blog-title">
									<a href="<?php echo get_permalink(get_the_id()); ?>">
										<?php echo get_the_title(); ?>		
									</a>
								</h3>
								<div class="blog-date">
									<?php echo get_the_date( 'F j, Y' ); ?>
								</div>
								<div class="blog-meta 111">
									<span class="blog-author">
										By: <?php echo get_the_author(); ?>
									</span>
									<span class="blog-cats">
										|&nbsp; <?php the_category(); ?>
									</span>
								</div> 
								<p class="blog-excerpt">
									<?php echo get_the_excerpt(); ?>
								</p>
								<div class="blog-rm">
									<a href="<?php echo get_permalink(get_the_id()); ?>">Read More <i class="fa fa-caret-right"></i></a>
								</div>
							</div>
						</div>
						<?php endwhile; endif; ?>
					</div>						
				</div>					
				<?php nectar_pagination(); ?>
				<input type="hidden" id="cat-id" value="<?php echo $cat_id; ?>">
			</div>
			
			<div class="col-sm-3 main-sidebar-col">
				
				<?php echo do_shortcode("[stag_sidebar id='custom-blog-sidebar']"); ?>

			</div>
			
		</div><!--/row-->
		
	</div><!--/container-->

</div><!--/container-wrap-->

<!-- <script type="text/javascript">
	jQuery(document).ready(function($) {
		jQuery("input[type=hidden].search-field-cat").val($("#cat-id").val());
	});
	
</script> -->
	
<?php get_footer(); ?>