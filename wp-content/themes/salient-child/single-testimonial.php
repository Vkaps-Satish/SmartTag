<?php get_header(); ?>

<?php // nectar_page_header(get_option('page_for_posts')); ?>
<?php

	$term = get_the_terms($post->ID, 'testimonial_category');
	// print_r($term);
	$termId   = $term[0]->term_id;
	$authorId = $post->post_author;
	$countries_obj = new WC_Countries();
    $countries = $countries_obj->__get('countries');
    foreach ($countries as $key => $value) {
    	if ($key == get_the_author_meta('primary_country', $authorId)) {
    		$countryName = $value;
    		break;
    	}
    }

?>
<div class="container-wrap">
		
	<div class="container main-content">
		
		<div class="row">

			<div class="col-sm-9">

				<div class="container">
					<div class="page-heading single-page-heading">
						<?php if ($termId == 92) {
							echo '<h1>Testimonials From SmartTag™ Customers</h1><span class="page-heading-btn">
								<a href="'.get_site_url().'/share-your-story-for-customer/">Share Your Story <i class="fa fa-caret-right"></i></a>
							</span>';
						}else{
							echo '<h1>Testimonials From Pet Professionals</h1><span class="page-heading-btn">
								<a href="'.get_site_url().'/share-your-story-for-pet-professional/">Share Your Story <i class="fa fa-caret-right"></i></a>
							</span>';
						} ?>
						
					</div>
				</div>
				
				<div class="testi-blog-page">
					<div class="testi-back-wrap">
						<div class="row">
							<div class="col-sm-6 mb-15">
								<?php if ($termId == 92) {
									echo '<a href="/testimonials/smarttag-customers/"><strong><i class="fa fa-angle-left"></i> Back To Testimonials</strong></a>';
								}else{
									echo '<a href="/testimonials/pet-professionals/"><strong><i class="fa fa-angle-left"></i> Back To Testimonials</strong></a>';
								} ?>
							</div>
							<div class="col-sm-6 mb-15 text-right">
								<div class="navigation">
									<nav id="nav-single">
									    <span class="nav-previous"><?php previous_post_link('%link', __('<span class="fa fa-angle-left"></span> Previous Testimonial'), TRUE, $excluded_terms = '', $taxonomy = 'testimonial_category'); ?></span>
									    <span class="nav-next"><?php next_post_link('%link', __('Next Testimonial <span class="fa fa-angle-right"></span>'), TRUE, $excluded_terms = '', $taxonomy = 'testimonial_category'); ?></span>
									</nav> 
								</div>
							</div>
						</div>
					</div>
					<div class="test-single-content-wrap">
						<?php if(have_posts()) : while(have_posts()) : the_post(); ?>
							<h3 class="testi-single-title">
								<?php echo get_the_title(); ?>
							</h3>
							<?php 
								if ($termId == 92){ ?>
									<div class="testi-single-img text-center mb-15">
										<?php echo get_the_post_thumbnail(); ?>
									</div>
							<?php } ?>
							<div class="test-single-meta">
								<i>By <?php echo get_the_author(); ?></i>, <?php echo $countryName; ?>
							</div>
							<br/>
							<?php echo get_the_content(); ?>
							<div class="test-single-content"></div>
						<?php endwhile; endif; ?>
					</div>						
				</div>					
			</div>
			<?php if ($termId == 92) { ?>
				<div class="col-sm-3">
					<?php echo do_shortcode("[stag_sidebar id='main-sidebar']"); ?>
					<div class="sidebar-engrave">
						<h3>Custom Engrave Your Pet ID Tag</h3>
						<img src="<?php echo get_site_url(); ?>/wp-content/themes/salient-child/images/circle_back.jpg" class="custom-product-sidebar">
						<form action="<?php echo get_site_url(); ?>/product/brass-id-tag/" method="post">
							<div class="field-div"  id="stylee">
								<label>Select a Shape:</label>
								<div class="custom-radio-box" data-toggle="buttons">
								    <label class="btn active" role="button">
								      <input type="radio" value="circle" name="type" checked="checked" class="custom-product-type" data-img="circle_back">
								      <div class="custom-radio-img">
								      	  <img src="<?php bloginfo('template_url'); ?>-child/images/circle_back.jpg" alt="radio image" data-name="design-circle"/>
								      </div>
								    </label>
								    <label class="btn" role="button">
								      <input type="radio" value="heart" name="type" class="custom-product-type" data-img="heart_shape_back">
								      <div class="custom-radio-img">
								      	  <img src="<?php bloginfo('template_url'); ?>-child/images/heart_shape_back.jpg" alt="radio image" data-name="design-circle"/>
								      </div>
								    </label>
								    <label class="btn" role="button">
								      <input type="radio" value="bone" name="type" class="custom-product-type" data-img="bone_back">
								      <div class="custom-radio-img">
								      	  <img src="<?php bloginfo('template_url'); ?>-child/images/bone_back.jpg" alt="radio image" data-name="design-circle"/>
								      </div>
								    </label>
								</div>
							</div>
							<div class="custom-form-pet-name">
								<label>Enter Pets Name:</label>
								<input type="text" name="petName" value="FIDO">
							</div>
							<input type="submit" name="submit" value="View Custom Id Tag">	
						</form>
						<script type="text/javascript">
							jQuery(document).ready(function(){
								jQuery('.custom-radio-box label').on('click',function(e){
									e.preventDefault();
									var imgName = jQuery(this).find("input.custom-product-type").attr('data-img');
									console.log(imgName);
								 	jQuery('.custom-product-sidebar').attr('src','<?php echo get_site_url(); ?>/wp-content/themes/salient-child/images/'+imgName+'.jpg');
								 	return false;
								});
								

							})
						</script>
					</div>
					<?php echo do_shortcode("[stag_sidebar id='pet-famous-sidebar']"); ?>
				</div>
			<?php }else{ ?>
				<div class="col-sm-3">
					<?php echo do_shortcode("[stag_sidebar id='main-sidebar']"); ?>
					<div class="sidebar-engrave">
						<img src="<?php echo get_site_url(); ?>/wp-content/themes/salient-child/images/circle_back.jpg" class="custom-product-sidebar">
						<br> 
						<p>
							<a href="<?php echo get_site_url(); ?>/product-category/microchip-scanners/id-tags-products-microchips-and-scanners/" class="site-btn site-btn-red btn">Buy Microchip Now <i class="fa fa-caret-right"></i></a>
						</p>
					</div>
					<div class="sidebar-engrave">
						<b>Request A Sample Microchip and More Information</b>
						<?php echo do_shortcode("[gravityform id=14 ajax=true]"); ?>
					</div>
				</div>
			<?php } ?>
		</div><!--/row-->
		
	</div><!--/container-->

</div><!--/container-wrap-->
<script type="text/javascript">
	jQuery(document).ready(function($){
		$('a[rel="prev"]').addClass("btn");
		$('a[rel="next"]').addClass("btn");
		$('#input_14_5_6 option').each(function() {
			if ($(this).text() == "") {
				$(this).text("Select Country");
				return;
			}
		});
	});
</script>
<?php get_footer(); ?>