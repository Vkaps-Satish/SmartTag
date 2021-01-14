<?php get_header(); ?>

<?php 
global $plholderImg ;
nectar_page_header(get_option('page_for_posts')); ?>
<div class="container-wrap testi-page">
		
	<div class="container main-content">
		
		<div class="row">

			<div class="col-sm-9">
				<div class="page-heading">
					<h1>Testimonials From SmartTag™ Customers</h1>
					<span class="page-heading-btn">
						<a href="<?php echo get_home_url().'/share-your-story-for-customer/'; ?>">Share Your Story <i class="fa fa-caret-right"></i></a>
					</span>
				</div>
				<div class="testi-content">
					<div class="testi-list-wrap customer-testimonials">
						<?php if(have_posts()) : while(have_posts()) : the_post(); ?>
						<div class="testi-list">
							<?php
							    if(has_post_thumbnail()) { ?>
							        <div class="testi-img">
										<a href="<?php echo get_permalink(get_the_id()); ?>"><?php echo get_the_post_thumbnail(); ?></a>
									</div>
								<?php } else { 

									echo "<div class='testi-img'><a href='".get_permalink(get_the_id())."'><img src='". (wp_get_attachment_url($plholderImg) ? wp_get_attachment_url($plholderImg) : "") ."'></a></div>";
								}	?>
								
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
				<div class="sidebar-engrave" id="sidebar-eng">
					<h3>Custom Engrave Your Pet ID Tag</h3>
					<img src="<?php echo get_site_url(); ?>/wp-content/themes/salient-child/images/circle_back.jpg" class="custom-product-sidebar" id="mainImg" tabindex="0">
					<form action="<?php echo get_site_url(); ?>/product/aluminum-id-tag/" method="post">
						<div class="field-div"  id="stylee">
							<label>Select a Shape:</label>
							<div class="custom-radio-box" data-toggle="buttons">
							    <label class="btn active" role="button">
							      <input type="radio" value="circle" name="type" checked="checked" class="custom-product-type" data-img="circle_back">
							      <div class="custom-radio-img">
							      	  <img class="rdio-img" src="<?php bloginfo('template_url'); ?>-child/images/circle_back.jpg" alt="radio image" data-name="design-circle"/>
							      </div>
							    </label>
							    <label class="btn" role="button">
							      <input type="radio" value="heart" name="type" class="custom-product-type" data-img="heart_shape_back">
							      <div class="custom-radio-img">
							      	  <img class="rdio-img" src="<?php bloginfo('template_url'); ?>-child/images/heart_shape_back.jpg" alt="radio image" data-name="design-circle" />
							      </div>
							    </label>
							    <label class="btn" role="button">
							      <input type="radio" value="bone" name="type" class="custom-product-type" data-img="bone_back">
							      <div class="custom-radio-img">
							      	  <img class="rdio-img" src="<?php bloginfo('template_url'); ?>-child/images/bone_back.jpg" alt="radio image" data-name="design-circle"/>
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
							jQuery('.custom-radio-img').on('click',function(e){
								e.preventDefault();
								var imgNameSrc = jQuery(this).find('img').attr('src');	
								jQuery('.custom-product-sidebar').attr('src',imgNameSrc);
								$(this).parent().parent().find('label').removeClass('active').addClass('inactive');
								$(this).parent().removeClass('inactive').addClass('active');
								$(this).parent().find("input[type=radio].custom-product-type").prop("checked", true);
								return false;
							});
						})
					</script>
				</div>
				<?php echo do_shortcode("[stag_sidebar id='pet-famous-sidebar']"); ?>
			</div>

		</div>
		
	</div><!--/container-->

</div><!--/container-wrap-->
	
<?php get_footer(); ?>