<?php get_header(); 

global $options;
$theme_skin = ( !empty($options['theme-skin']) ) ? $options['theme-skin'] : 'original';

?>

<script>
jQuery(document).ready(function($){
	
	var $searchContainer = $('#search-results');
	
	$(window).load(function(){
		
		$searchContainer.isotope({
		   itemSelector: '.result',
		   layoutMode: 'packery',
		   packery: { columnWidth: $('#search-results').width() / 3 }
		});
		
		$searchContainer.css('visibility','visible');
				
	});
	
	$(window).resize(function(){
	   $searchContainer.isotope({
	   	  layoutMode: 'packery',
	      packery: { columnWidth: $('#search-results').width() / 3}
	   });
	});

	
});
</script>

<div class="container-wrap">
	
	<div class="container main-content">

		<div class="page-heading">
			<h1>SmartTag Blog</h1>
		</div>
		
		<div class="row">

			<div class="col-sm-9 main-content-col">

				<h3 class="showing-search-text">
					<?php echo __('Showing search results for: ', NECTAR_THEME_NAME); ?><span>"<?php echo esc_html( get_search_query( false ) ); ?>"</span>
				</h3>
				
				<div id="search-results">

					<?php if(have_posts()) : while(have_posts()) : the_post(); ?>
					<div class="blog-list search-blog-list">
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
					<?php endwhile; ?>
						
					
					<?php 
					
					else: echo "<p>" . __('No results found', NECTAR_THEME_NAME) . "</p>"; endif;?>
				
						
				</div><!--/search-results-->

				<?php if( get_next_posts_link() || get_previous_posts_link() ) { ?>
					<div id="pagination">
						<div class="prev"><?php previous_posts_link('&laquo; Previous Entries') ?></div>
						<div class="next"><?php next_posts_link('Next Entries &raquo;','') ?></div>
					</div>	
				<?php }?>

			</div>

			<div class="col-sm-3 main-sidebar-col">
				
				<?php echo do_shortcode("[stag_sidebar id='custom-blog-sidebar']"); ?>

			</div>
		
		</div><!--/row-->
		
	</div><!--/container-->

</div><!--/container-wrap-->

<?php get_footer(); ?>

