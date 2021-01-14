<?php get_header(); ?>

<?php nectar_page_header(get_option('page_for_posts')); ?>
<div class="container-wrap">
		
	<div class="container main-content">

		<div class="container">
			<div class="page-heading single-page-heading">
				<h1>SmartTag™ Blogs</h1>
			</div>
		</div>
		
		<div class="row">

			<div class="col-sm-9">
				
				<div class="single-blog-content">
					<div class="single-blog-list-wrap">
						<?php if(have_posts()) : while(have_posts()) : the_post(); ?>
						<div class="single-blog-list">
							<div class="single-blog-img">
								<?php echo get_the_post_thumbnail(); ?>
							</div>
							<div class="single-blog-list-content">
								<h3 class="single-blog-title">
									<?php echo get_the_title(); ?>
								</h3>
								<div class="single-blog-date">
									<?php echo get_the_date( 'F j, Y' ); ?>
								</div>
								<div class="single-blog-meta">
									<span class="single-blog-author">
										By: <?php echo get_the_author(); ?>
									</span>
									<span class="single-blog-cats">
										|&nbsp; <?php the_category(); ?>
									</span>
								</div> 
								<div class="single-blog-texts">
									<?php echo the_content(); ?>
								</div>
							</div>
						</div>
						<?php endwhile; endif; ?>
						<div class="single-share-btns">
							<span class="share-this-text">Share This Page:</span>
							<?php echo do_shortcode("[stag_sidebar id='blog-share-buttons']"); ?>
						</div>
						<div class="related-posts">
							<h4 class="mb-25">Related Articles:</h4>
							<div class="row">
								<?php global $post;
								$orig_post = $post;
								$categories = get_the_category($post->ID);
								if ($categories) {
									$category_ids = array();
									foreach($categories as $individual_category){
										$category_ids[] = $individual_category->term_id;
									} 
									$args=array(
									'category__in' => $category_ids,
									'post__not_in' => array($orig_post->ID),
									'posts_per_page'=> 2, // Number of related posts that will be shown.
									'caller_get_posts'=>1
									);

									$my_query = new wp_query( $args );
									if( $my_query->have_posts() ) {
										$i = 0;
										while( $my_query->have_posts() ) {
											$my_query->the_post(); 
											$img = get_the_post_thumbnail_url(); 
											if ($i == 0) {
												$rmb = 'rmb-30';
											}else{
												$rmb = '';
											}
											$i++;
											?>
											<div class="col-sm-6 <?php echo $rmb; ?>">
												<p>
													<img src="<?= $img; ?>" alt="image" />
												</p>
												<h4 class="color-light-blue">
													<?php the_title(); ?>
												</h4>
												<p>
													<?php $post_date = get_the_date( 'F j, Y' ); echo $post_date; ?>
													<br>
													<strong>By SmartTag</strong> | <?php $categories = get_the_category(get_the_ID());
													if ($categories) {
														foreach($categories as $individual_category){
															$link = get_category_link( $individual_category->term_id );
															echo '<a href="'.$link.'"><strong>'.$individual_category->name.'</strong></a>';
														}
													} 
													?>
												</p>
												<p>
													<?php echo get_the_excerpt(); ?>
												</p>
												<a href="<?php echo get_the_permalink(); ?>" class="site-btn site-btn-red">Read More <i class="fa fa-caret-right"></i></a>
											</div>
										<?php }
									}
								}
									$post = $orig_post;
									wp_reset_query(); 
								?>
							</div>
						</div>
					</div>						
				</div>					
				<?php nectar_pagination(); ?>

			</div>
			
			<div class="col-sm-3 main-sidebar-col">
				
				<?php echo do_shortcode("[stag_sidebar id='custom-blog-sidebar']"); ?>

			</div>
			
		</div><!--/row-->
		
	</div><!--/container-->

</div><!--/container-wrap-->
	
<?php get_footer(); ?>