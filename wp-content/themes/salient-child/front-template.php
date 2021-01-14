<?php 

/* template name: Home - Front Page Template */
get_header(); ?>
	
<?php 

global $plholderImg ;
$options = get_nectar_theme_options();  ?>

<div class="home-slider-wrap">
	<?php echo do_shortcode("[home_slider_new]"); ?>
</div>



<section class="content-section custom-id-tag-section" id="custom-id-tag-section">
	<div class="container" >
		<div class="section-content">
			<form class="custom-id-tag-form site-form" id="single-product" method="post" action=""	>
				<div class="row">
					<div class="col-sm-6">
						<h2 class="section-title">Custom Engrave Your Pet ID Tag:</h2>
						<div class="row">
							<div class="col-sm-6">
								<div class="field-box">
									<label class="field-label">Select a Type*:</label>
									<div class="field-div custom-select-div">
										<div class="custom-select-wrap" id="selectType">
									    	<select class="custom-select-box"  name="type">
									    		<option value="0">Select Type</option>
												<option value="bone" data-product="aluminum">Aluminum Bone</option>
												<option value="bone" data-product="brass">Brass Bone</option>
												<option value="circle" data-product="aluminum">Aluminum Circle</option>
												<option value="circle" data-product="brass">Brass Circle</option>
												<option value="heart" data-product="aluminum">Aluminum Heart</option>
												<option value="heart" data-product="brass">Brass Heart</option>
											</select>
									    </div>				
									</div>
									<lable class="error mtt-1"></lable>
								</div>
							</div>
							<div class="col-sm-6">
								<div class="field-box">
									<label class="field-label">Select Size:</label>
									<div class="field-div custom-select-div">
										<div class="custom-select-wrap" id="customSelectType">
									    	<select class="custom-select-box" id="selectSize" name="size">
									    		<option value="0">Select Size</option>
												<option value="small">Small (1 in / 2.54 cm)</option>
												<option value="large">Large (1.5 in / 3.81 cm)</option>
											</select>
									    </div>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-sm-12">
								<div class="field-box">
									<label class="field-label">Select a Style:</label>
									<div class="field-div"  id="stylee">
										<div class="custom-radio-box circle" data-toggle="buttons">
										    <label class="btn active" role="button">
										      <input type="radio" value="circle-1" name="style" required checked="checked" class="style-radio" data-name="design-circle">
										      <div class="custom-radio-img">
										      	  <img src="<?php bloginfo('template_url'); ?>-child/images/flower_circle_shape.png" alt="radio image" data-name="design-circle"/>
										      </div>
										    </label>
										    <label class="btn" role="button">
										      <input type="radio" value="circle-2" name="style" class="style-radio" data-name="design-circle">
										      <div class="custom-radio-img">
										      	  <img src="<?php bloginfo('template_url'); ?>-child/images/pink_paw_circle.png" alt="radio image" data-name="design-circle"/>
										      </div>
										    </label>
										    <label class="btn" role="button">
										      <input type="radio" value="circle-3" name="style" class="style-radio" data-name="design-circle">
										      <div class="custom-radio-img">
										      	  <img src="<?php bloginfo('template_url'); ?>-child/images/pink_paw_circle_shape.png" alt="radio image" data-name="design-circle"/>
										      </div>
										    </label>
										    <label class="btn" role="button">
										      <input type="radio" value="circle-4" name="style" class="style-radio" data-name="design-circle">
										      <div class="custom-radio-img">
										      	  <img src="<?php bloginfo('template_url'); ?>-child/images/smarttag_circle_shape.png" alt="radio image" data-name="design-circle"/>
										      </div>
										    </label>
										    <label class="btn" role="button">
										      <input type="radio" value="circle-5" name="style" class="style-radio" data-name="design-circle">
										      <div class="custom-radio-img">
										      	  <img src="<?php bloginfo('template_url'); ?>-child/images/b3back_paw_circle.png" alt="radio image" data-name="design-circle"/>
										      </div>
										    </label>
										    <label class="btn" role="button">
										      <input type="radio" value="circle-6" name="style" class="style-radio" data-name="design-circle">
										      <div class="custom-radio-img">
										      	  <img src="<?php bloginfo('template_url'); ?>-child/images/black_paw_circle_shape.png" alt="radio image" data-name="design-circle"/>
										      </div>
										    </label>
										    <label class="btn" role="button">
										      <input type="radio" value="circle-7" name="style" class="style-radio" data-name="design-circle">
										      <div class="custom-radio-img">
										      	  <img src="<?php bloginfo('template_url'); ?>-child/images/circle_back.png" alt="radio image" data-name="design-circle"/>
										      </div>
										    </label>
										</div>
										<div class="custom-radio-box heart" data-toggle="buttons">
										     <label class="btn active" role="button">
										      <input type="radio" value="heart-1" name="style" required checked="checked" class="style-radio" data-name="design-heart">
										      <div class="custom-radio-img">
										      	  <img src="<?php bloginfo('template_url'); ?>-child/images/brass_heart.jpg" alt="radio image" data-name="design-heart"/>
										      </div>
										    </label>
										    <label class="btn" role="button">
										      <input type="radio" value="heart-2" name="style" class="style-radio" data-name="design-heart">
										      <div class="custom-radio-img">
										      	  <img src="<?php bloginfo('template_url'); ?>-child/images/crown_heart_shape.png" alt="radio image" data-name="design-heart"/>
										      </div>
										    </label>
										</div>
										<div class="custom-radio-box bone" data-toggle="buttons">
										    <label class="btn active" role="button">
										      <input type="radio" value="bone-1" name="style" required checked="checked" class="style-radio" data-name="design-bone">
										      <div class="custom-radio-img">
										      	  <img src="<?php bloginfo('template_url'); ?>-child/images/black_bone_bone_shape.png" alt="radio image" data-name="design-bone"/>
										      </div>
										    </label>
										    <label class="btn" role="button">
										      <input type="radio" value="bone-2" name="style" class="style-radio" data-name="design-bone">
										      <div class="custom-radio-img">
										      	  <img src="<?php bloginfo('template_url'); ?>-child/images/brass_large_bone_adopted_10.jpg" alt="radio image" data-name="design-bone"/>
										      </div>
										    </label>
										    <label class="btn" role="button">
										      <input type="radio" value="bone-3" name="style" class="style-radio"  data-name="design-bone">
										      <div class="custom-radio-img">
										      	  <img src="<?php bloginfo('template_url'); ?>-child/images/camoflage_bone_shape_1.png" alt="radio image" data-name="design-bone"/>
										      </div>
										    </label>
										    <label class="btn" role="button">
										      <input type="radio" value="bone-4" name="style" class="style-radio" data-name="design-bone">
										      <div class="custom-radio-img">
										      	  <img src="<?php bloginfo('template_url'); ?>-child/images/paw_off_bone_shape_1.png" alt="radio image" data-name="design-bone"/>
										      </div>
										    </label>
										    <label class="btn" role="button">
										      <input type="radio" value="bone-5" name="style" class="style-radio" data-name="design-bone">
										      <div class="custom-radio-img">
										      	  <img src="<?php bloginfo('template_url'); ?>-child/images/rainbow_bone_shape_1.png" alt="radio image" data-name="design-bone"/>
										      </div>
										    </label>
										    <label class="btn" role="button">
										      	<input type="radio" value="bone-6" name="style" class="style-radio" data-name="design-bone">
										      	<div class="custom-radio-img">
										      	  	<img src="<?php bloginfo('template_url'); ?>-child/images/shelter_dog_rock_bone_shape_5_9_2012.png" alt="radio image" data-name="design-bone"/>
										      	</div>
										    </label>
										    <label class="btn" role="button">
										      	<input type="radio" value="bone-7" name="style" class="style-radio" data-name="design-bone">
										      	<div class="custom-radio-img">
										      	  	<img src="<?php bloginfo('template_url'); ?>-child/images/bone_back.jpg" alt="radio image" data-name="design-bone"/>
										      	</div>
										    </label>
										</div>
									</div>
									<div class="field-div"  id="colorr">
										<div class="custom-radio-box circle" data-toggle="buttons">
										    <label class="btn active" role="button">
										      <input type="radio" value="blue-circle" name="color" required checked="checked" class="style-radio" data-name="color-circle">
										      <div class="custom-radio-img">
										      	  <img src="<?php bloginfo('template_url'); ?>-child/images/bluetag2.jpg" alt="radio image" data-name="color-circle"/>
										      </div>
										    </label>
										    <label class="btn" role="button">
										      <input type="radio" value="black-circle" name="color" class="style-radio"  data-name="color-circle">
										      <div class="custom-radio-img">
										      	  <img src="<?php bloginfo('template_url'); ?>-child/images/circle_black_1.jpg" alt="radio image" data-name="color-circle"/>
										      </div>
										    </label>
										    <label class="btn" role="button">
										      <input type="radio" value="pink-circle" name="color" class="style-radio"  data-name="color-circle">
										      <div class="custom-radio-img">
										      	  <img src="<?php bloginfo('template_url'); ?>-child/images/circle_pink_2.jpg" alt="radio image" data-name="color-circle"/>
										      </div>
										    </label>
										</div>
										<div class="custom-radio-box heart" data-toggle="buttons">
										     <label class="btn active" role="button">
										      <input type="radio" value="pink-heart" name="color" required checked="checked" class="style-radio" data-name="color-heart">
										      <div class="custom-radio-img">
										      	  <img src="<?php bloginfo('template_url'); ?>-child/images/heart_pink_shape_2.png" alt="radio image" data-name="color-heart"/>
										      </div>
										    </label>
										    <label class="btn" role="button">
										      <input type="radio" value="red-heart" name="color" class="style-radio"  data-name="color-heart">
										      <div class="custom-radio-img">
										      	  <img src="<?php bloginfo('template_url'); ?>-child/images/heart_red_shape_2.png" alt="radio image" data-name="color-heart"/>
										      </div>
										    </label> 
										    <label class="btn" role="button">
										      <input type="radio" value="yellow-heart" name="color" class="style-radio"  data-name="color-heart">
										      <div class="custom-radio-img">
										      	  <img src="<?php bloginfo('template_url'); ?>-child/images/heart_yellow_shape_2.png" alt="radio image" data-name="color-heart"/>
										      </div>
										    </label>
										</div>
										<div class="custom-radio-box bone" data-toggle="buttons">
										    <label class="btn active" role="button">
										      <input type="radio" value="black-bone" name="color" required checked="checked" class="style-radio" data-name="color-bone">
										      <div class="custom-radio-img">
										      	  <img src="<?php bloginfo('template_url'); ?>-child/images/black_bone_shape_2_2.png" alt="radio image" data-name="color-bone"/>
										      </div>
										    </label>
										    <label class="btn" role="button">
										      <input type="radio" value="blue-bone" name="color" class="style-radio" data-name="color-bone">
										      <div class="custom-radio-img">
										      	  <img src="<?php bloginfo('template_url'); ?>-child/images/blue_bone_shape_2.png" alt="radio image" data-name="color-bone"/>
										      </div>
										    </label>
										    <label class="btn" role="button">
										      <input type="radio" value="pink-bone" name="color" class="style-radio" data-name="color-bone">
										      <div class="custom-radio-img">
										      	  <img src="<?php bloginfo('template_url'); ?>-child/images/pink_bone_shape_2.png" alt="radio image" data-name="color-bone"/>
										      </div>
										    </label>
										    <label class="btn" role="button">
										      <input type="radio" value="red-bone" name="color" class="style-radio" data-name="color-bone">
										      <div class="custom-radio-img">
										      	  <img src="<?php bloginfo('template_url'); ?>-child/images/red_bone-shape_2.png" alt="radio image" data-name="color-bone"/>
										      </div>
										    </label>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-sm-6">
						<div class="home-front-back-section">
							<div class="style-pro">
								<div class="section-front-image design-circle">
									<label>Front:</label>
									<img src="<?php bloginfo('template_url'); ?>-child/images/flower_circle_shape.png" class="front-img">
								</div>
								<div class="section-back-image design-circle">
									<label>Back:</label>
									<img src="<?php bloginfo('template_url'); ?>-child/images/circle_back.png" class="back-img">
								</div>
								<div class="section-front-image design-bone">
									<label>Front:</label>
									<img src="<?php bloginfo('template_url'); ?>-child/images/black_bone_bone_shape.png" class="front-img">
								</div>
								<div class="section-back-image design-bone">
									<label>Back:</label>
									<img src="<?php bloginfo('template_url'); ?>-child/images/bone_back.jpg" class="back-img">
								</div>
								<div class="section-front-image design-heart">
									<label>Front:</label>
									<img src="<?php bloginfo('template_url'); ?>-child/images/brass_heart.jpg" class="front-img">
								</div>
								<div class="section-back-image design-heart">
									<label>Back:</label>
									<img src="<?php bloginfo('template_url'); ?>-child/images/brass_heart.jpg" class="back-img">
								</div>
							</div>
							<div class="color-pro">
								<div class="section-front-image color-circle">
									<label>Front:</label>
									<img src="<?php bloginfo('template_url'); ?>-child/images/bluetag2.jpg" class="front-img">
								</div>
								<div class="section-back-image color-circle">
									<label>Back:</label>
									<img src="<?php bloginfo('template_url'); ?>-child/images/bluetag2.jpg" class="back-img">
								</div>
								<div class="section-front-image color-bone">
									<label>Front:</label>
									<img src="<?php bloginfo('template_url'); ?>-child/images/black_bone_shape_2_2.png" class="front-img">
								</div>
								<div class="section-back-image color-bone">
									<label>Back:</label>
									<img src="<?php bloginfo('template_url'); ?>-child/images/black_bone_shape_2_2.png" class="back-img">
								</div>
								<div class="section-front-image color-heart">
									<label>Front:</label>
									<img src="<?php bloginfo('template_url'); ?>-child/images/heart_pink_shape_2.png" class="front-img">
								</div>
								<div class="section-back-image color-heart">
									<label>Back:</label>
									<img src="<?php bloginfo('template_url'); ?>-child/images/heart_pink_shape_2.png" class="back-img">
								</div>
							</div>
						</div>
						<div class="continue-customize-btn">
							<a href="javascript:;" id="continue-cust" class="home-btn">Continue Customizing <i class="fa fa-caret-right"></i> </a>
							<p><strong>*Continue Customizing to Add Your Info and Select More Options!</strong></p>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
</section>

<section class="content-section lost-pet-alerts-section">
	<div class="container">
		<div class="section-content">
			<h2 class="section-title">Lost Pet Alerts:</h2>			
			<div class="row lost-pets-grid">

<?php 
$args = array('post_type' => 'lost_found_pets',
				'post_per_page'=>'3',
				 'orderby' => 'lost_found_date',
				 'order' => 'DESC',
			      'meta_query' => array(
				        array(
				           'key'=>'pet_status',
				           'value'=>'1',
				          
				        )
    ));

		$lost_query = new WP_Query($args); 
	
if( $lost_query->have_posts()){ ?>
      <?php while( $lost_query->have_posts() ) : $lost_query->the_post();
       $petData = get_post_meta($post->ID);
       $content = shorter($petData['description'][0],40);
    ?>
    		    <div class="col-sm-4">
					<div class="lost-pets-col">
						<div class="lost-pets-img">
							<!-- <img src="https://idtag.agiliscloud.com/wp-content/uploads/2018/01/lost-pet-img.jpg" alt="image" /> -->
							<!-- <img src="https://idtag.agiliscloud.com/wp-content/uploads/2018/01/found-pat-img.png" alt="image" /> -->

								<?php 
								if (has_post_thumbnail( $post->ID ) ):
								  the_post_thumbnail(); 
								else: 
									echo "<img src='". (wp_get_attachment_url($plholderImg) ? wp_get_attachment_url($plholderImg) : "") ."'>";
								 endif; ?>
						</div>
						<div class="lost-pets-desc">
							<p>
								<strong>Pet Name: </strong> <?php echo get_the_title();?><br />
								<strong>Lost Area: </strong><?php echo $petData['state'][0].",".$petData['country'][0];?><br />
								<strong>Zip Code: </strong> <?php echo $petData['zip_code'][0];?><br />
								<strong>Lost On: </strong><?php if(!empty($petData['pet_lost_date'][0])){echo $petData['pet_lost_date'][0];}?><br />
								<strong>Reward: </strong> $100<br />
								<strong>Description: </strong><?php if(!empty($petData['description'][0])){echo $content;}?>
							</p>
							<a href="<?= site_url().'/report-found-pet/?pid='.$post->ID.'&title='.$title ?>" class="site-btn site-btn-red">I Found This Pet <i class="fa fa-caret-right"></i></a>
						</div>
					</div>
				</div>

	<?php endwhile;
			}else{ ?>
			<div class="not-found-text width-100">Pets Not Lost</div>
		<?php	}
	 
?>					
			
			</div>
			<div class="section-bottom-btn">
				<?php 
				if(is_user_logged_in()){
					echo '<a href="'.get_site_url().'/my-account/report-my-pet-lost/" class="home-btn">Click Here to Post Your Lost Pet <i class="fa fa-caret-right"></i></a>';
				}else{
				echo '<a href="'.get_site_url().'/login-to-smarttag/" class="home-btn">Click Here to Post Your Lost Pet <i class="fa fa-caret-right"></i></a>';
				}
				?>
				
			</div>
		</div>
	</div>
</section>

<section class="content-section home-prods-section">
	<div class="container">
		<div class="section-content">
			<h2 class="section-title">SmartTag® Products & Services:</h2>			
			<div class="row home-prods-grid">
				<div class="col-sm-4">
					<div class="home-prods-col">
						<div class="home-prods-img">
							<img src="<?php echo get_site_url(); ?>/wp-content/themes/salient-child/images/universal-microchip-home.png" alt="image" />
						</div>
						<div class="home-prods-desc">
							<p>Register ANY brand microchip here for only $14.95 for the lifetime registration, we are part of the national AAHA microchip database. All microchips show up in all Google searches.</p>
						</div>
						<div class="home-prods-btn">
							<a href="<?php echo get_site_url(); ?>/universal-microchip-register-new/">Universal Microchip Registry ($6.95/yr or $14.95 Lifetime)</a>
						</div>
					</div>
				</div>
				<div class="col-sm-4">
					<div class="home-prods-col">
						<div class="home-prods-img">
							<img src="<?php echo get_site_url(); ?>/wp-content/themes/salient-child/images/microchip-scanner-st.jpg" alt="image" />
						</div>
						<div class="home-prods-desc">
							<p>Shelters, Rescues Groups, Breeders and veterinarians can purchase wholesale microchips and scanners here.</p>&nbsp;
						</div>
						<div class="home-prods-btn">
							<a href="product-category/id-tags-products/id-tags-products-microchips-and-scanners/">Purchase SmartTag® Microchips and Scanners</a>
						</div>
					</div>
				</div>
				<div class="col-sm-4">
					<div class="home-prods-col">
						<div class="home-prods-img">
							<img src="<?php echo get_site_url(); ?>/wp-content/themes/salient-child/images/custom-engrave-st.png" alt="image" />
						</div>
						<div class="home-prods-desc">
							<p>Use our online step-by-step process to make your own custom engraved ID Tags. Enter the pet and owner information and choose from many fishes.</p>&nbsp;
						</div>
						<div class="home-prods-btn">
							<a href="#custom-id-tag-section" id="custom-enverge">SmartTag Protection Plans & Custom Engraved ID Tags</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

<section class="content-section recent-found-pets-section">
	<div class="container">
		<div class="section-content">
			<div class="row">
				<div class="col-sm-6 rfp-left">
					<h2 class="section-title">Pets Recently Found</h2>
					<div class="found-pets-list-wrap">
<?php 
$args = array('post_type' => 'found_pet',
				'posts_per_page'=>'3',
				 'orderby' => 'lost_found_date',
				 'order' => 'DESC',
			      'meta_query' => array(
				        array(
				           'key'=>'approve_status',
				           'value'=>'0',
				          
				        )
    ));
    $found_query = new WP_Query($args); ?>
<div class="note">*All pets listed here were found using our SmartTag services.</div>
<?php if($found_query->have_posts() ): ?>
      <?php while( $found_query->have_posts() ) : $found_query->the_post();
       	?>
						
						<div class="row found-pets-list">
							<div class="col-sm-3">
								<div class="found-pet-img">
									<?php
									if (has_post_thumbnail( $post->ID ) ):
									  the_post_thumbnail(); 
									else: 
										echo "<img src='". (wp_get_attachment_url($plholderImg) ? wp_get_attachment_url($plholderImg) : "") ."'>";
									 endif;
									 ?>
								</div>
							</div>
							<div class="col-sm-9">
								<div class="found-pet-desc">
								<p class="rfp-name"><strong>Pet Name: </strong><?php echo 	get_the_title(); ?></p>
								<p class="rfp-location"><strong>Found Area: </strong><?= get_post_meta($post->ID, 'finder_country', true);  ?></p>
								<p class="rfp-found-on"><strong>Found On: </strong><?= get_the_date();  ?>
								</p>
								<p class="rfp-found-by"><strong>Found By: </strong><?= get_post_meta($post->ID, 'finder_name', true);  ?>
								</p>		
								</div>
							</div>
							
						</div>
	<?php endwhile; ?>
	<!-- <div><a href="<?php echo get_site_url(); ?>/lost-and-found-pets/">See all</a></div> -->
	<div class="section-bottom-btn">
				<a href="<?php echo get_site_url(); ?>/lost-and-found-pets/" class="home-btn" target="_blank" >See all <i class="fa fa-caret-right"></i></a>				
			</div>
<?php	else:
	echo '<div class="lost-found-row" id="filter-row">
		<div class="not-found-text width-100">No Pets Found</div></div>';
	 endif;

?>                  	<!-- <div class="row found-pets-list">
							<div class="col-sm-3">
								<div class="found-pet-img">
									<img src="https://idtag.agiliscloud.com/wp-content/uploads/2018/01/found-pat-img.png" alt="image" />
								</div>
							</div>
							<div class="col-sm-9">
								<div class="found-pet-desc">
									<p class="rfp-name"><strong>Fluffy Doo</strong></p>
									<p class="rfp-location"><i>Mineola, NY</i></p>
									<p class="rfp-found-on"><strong>Found On:</strong> 5/5/2016</p>
									<p class="rfp-found-by"><strong>Found By:</strong> Micro Chip Scan</p>
								</div>
							</div>
						</div>
						<div class="row found-pets-list">
							<div class="col-sm-3">
								<div class="found-pet-img">
									<img src="https://idtag.agiliscloud.com/wp-content/uploads/2018/01/found-pat-img.png" alt="image" />
								</div>
							</div>
							<div class="col-sm-9">
								<div class="found-pet-desc">
									<p class="rfp-name"><strong>Fluffy Doo</strong></p>
									<p class="rfp-location"><i>Mineola, NY</i></p>
									<p class="rfp-found-on"><strong>Found On:</strong> 5/5/2016</p>
									<p class="rfp-found-by"><strong>Found By:</strong> Micro Chip Scan</p>
								</div>
							</div>
						</div> -->
					</div>
				</div>
				<div class="col-sm-6 rfp-right">
					<div class="embed-responsive embed-responsive-16by9">
					    <iframe src="https://www.youtube.com/embed/Qo-Ft84bf84" frameborder="0" allowfullscreen></iframe>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<section class="content-section blogs-section">
	<div class="container">
		<div class="section-content">
			<h2 class="section-title">SmartTag® News Feed</h2>
		</div>
	</div>
	<div class="container blog-slider-wrap">
		<?php echo do_shortcode("[blog_posts]"); ?>
	</div>
	<div class="section-bottom-btn">
		<a href="<?php echo get_site_url(); ?>/blogs/" class="home-btn">Read Our Blog <i class="fa fa-caret-right"></i></a>
	</div>
</section>
<script type="text/javascript">
jQuery(document).ready(function($){

	//ajax to get session vaiable data
	$.ajax({
            type: 'POST',
            url: ajaxurl,
            data: {
	                action : 'get_session',
	            },
            success: function(response) {
    		var Obj = JSON.parse(response);
    		$('#ul .list li option[value="'+Obj.type+'"]').prop('selected', true);
            }
	        
        });	

  // Add smooth scrolling to all links
  $("#custom-enverge").on('click', function(event) {

    if (this.hash !== "") {
      // Prevent default anchor click behavior
      	event.preventDefault();
	    var hash = this.hash;
      $('html, body').animate({
        scrollTop: $(hash).offset().top
      }, 800, function(){
        window.location.hash = hash;
      });
    } // End if
  });

  //get custom Engrave id 

});
</script>
<!-- <div id="dialog" style="display: none; cursor: default;">
  	<p>Please Select at Least One Type.</p>
  	<a href="#" id="close"><i class="fa fa-close"></i></a>
</div> -->
<div class="popup-wrap popup-wrap-front">
	<div class="popup-box">
		<div class="popup-box-inner">
			<div class="popup-close">
				<a id="closed-front" href="#single-product">
					<i class="fa fa-close"></i>
				</a>
			</div>
			<div class="popup-content">
				<h3 id="poptitle-front"></h3>
				<p id="popcont-front"></p>
			</div>
		</div>
	</div>
</div>
<?php get_footer(); ?>