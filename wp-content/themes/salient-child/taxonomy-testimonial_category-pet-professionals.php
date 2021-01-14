<?php get_header(); ?>

<?php 
	$check = 0;
	if ( is_user_logged_in() ){
     $current_user = wp_get_current_user();
     $roles = $current_user->roles;  
     // print_r($roles);die;
       if( !$roles == 'pet_professional' || !in_array( 'pet_professional', $roles )){
       	$check = 1;
        }
	}

	nectar_page_header(get_option('page_for_posts')); ?>
<div class="container-wrap testi-page">
		
	<div class="container main-content">
		
		<div class="row">

			<div class="col-sm-9">
				<div class="page-heading">
					<h1>Testimonials From Pet Professionals</h1>
					<?php if ($check) { ?>
						<span class="page-heading-btn">
							<a href="<?php echo get_home_url().'/share-your-story-for-pet-professional/'; ?>">Share Your Story<i class="fa fa-caret-right"></i></a>
						</span>
					<?php } ?>
				</div>
				<div class="testi-content">
					<div class="testi-list-wrap pet-testimonials">
						<?php if(have_posts()) : while(have_posts()) : the_post(); ?>
						<div class="testi-list">
							<!-- <div class="testi-img">
								<a href="<?php //echo get_permalink(get_the_id()); ?>"><?php //echo get_the_post_thumbnail(); ?></a>
							</div> -->
							<div class="testi-list-content">
								<h3 class="testi-title">
									<a href="<?php echo get_permalink(get_the_id()); ?>">
										<?php echo get_the_title(); ?>		
									</a>
								</h3>
								<div class="testi-meta">
									<span class="testi-author">
										<?php $author =  get_the_author(); 
										$string = explode(" ",$author);
										$firstName = (isset($string[0])) ? ucwords($string[0]) : ""; 
										$lastName = (isset($string[1])) ? ucwords($string[1]) : ""; 
										$lastword = substr($lastName,0,1);
										$usrname = $firstName . " ". $lastword;
										?>
										By: <?= $usrname; ?>
									</span>
									<span class="testi-city">
										,
									</span>
									<span class="testi-country">
										<?php echo get_the_author_meta( 'billing_country'); ?>
									</span>
								</div> 
								<p class="testi-excerpt">
									<?php echo get_the_excerpt(); ?>
								</p>
								<div class="testi-rm">
									<a href="<?php echo get_permalink(get_the_id()); ?>">Read More <i class="fa fa-caret-right"></i></a>
								</div>
							</div>
						</div>
						<?php endwhile; endif; ?>
					</div>						
				</div>					
				<?php nectar_pagination(); ?>
			</div>
			<div class="col-sm-3">
				<?php echo do_shortcode("[stag_sidebar id='main-sidebar']"); ?>
				<div class="sidebar-engrave">
					<img src="<?php echo get_site_url(); ?>/wp-content/themes/salient-child/images/microchip-scanner-st.jpg" class="custom-product-sidebar">
					<br> 
					<p>
						<a href="<?php echo get_site_url(); ?>/product-category/microchip-scanners/id-tags-products-microchips-and-scanners/" class="site-btn site-btn-red btn">Buy Microchip Now <i class="fa fa-caret-right"></i></a>
					</p>
				</div>
				<div class="sidebar-engrave">
					<b>Request A Sample Microchip and More Information</b><br/><br/>
					<?php echo do_shortcode("[gravityform id=14 ajax=true]"); ?>
				</div>
			</div>

		</div>
		
	</div><!--/container-->

</div><!--/container-wrap-->
	
<?php get_footer(); ?>