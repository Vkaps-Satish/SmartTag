<?php 

/*
Template Name: Report Found Pet Page
*/

get_header(); 
nectar_page_header($post->ID); 

//full page
$fp_options = nectar_get_full_page_options();
extract($fp_options);

?>

<div class="container-wrap">
	
	<div class="<?php if($page_full_screen_rows != 'on') echo 'container'; ?> main-content">
		
		<div class="row">

			<div class="col-sm-9 main-content-col">

				<div class="page-heading">
					<h1><?php echo get_the_title(); ?></h1>
				</div>
				
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

				<div class="report-found-pet-page">
					<div class="custom-panel">
						<div class="custom-panel-head">
							<h4>Pet You Found</h4>
						</div>
						<div class="custom-panel-text">  
							<div class="row">
								<div class="col-sm-6 res-mar-bot">
									<p><strong>ID Tag #:</strong> 40000844</p>
									<p><strong>Pet Name:</strong> Madonna</p>
									<p><strong>Lost Address:</strong> 1201 7th street nw, Washington, WA, 20001, United States</p>
									<p><strong>Pet Type/Breed:</strong> Cat / Norwegian Forest Cat</p>
									<p><strong>Primary color:</strong> Brown and black</p>
									<p><strong>Reward:</strong> $100</p>
									<p><strong>Notes:</strong> Madonna is lost, please help</p>
								</div>
								<div class="col-sm-6 res-mar-bot">
									<p><strong>Pet Image:</strong></p>
									<div>
										<img src="http://idtag.agiliscloud.com/wp-content/uploads/2018/01/lost-pet-img.jpg" alt="image" />
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="contact-form">
						<div class="field-wrap two-fields-wrap">
							<div class="field-div">
								<label>*Finder Name:</label>
								<input type="text" name="" />
							</div>
							<div class="field-div">
								<label>Finder Email:</label>
								<input type="email" name="" />
							</div>
						</div>
						<div class="field-wrap two-fields-wrap">
							<div class="field-div">
								<label>*Phone:</label>
								<input type="number" name="" placeholder="1 (555) 123-1234" />
							</div>
							<div class="field-div">
								<label>&nbsp;</label>
								<input type="text" name="" placeholder="1 (555) 123-1234" />
							</div>
						</div>
						<div class="field-wrap">
							<div class="field-div">
								<label>*Finder Country</label>
								<select>
									<option>United States</option>
								</select>
							</div>
						</div>
						<div class="field-wrap two-fields-wrap">
							<div class="field-div">
								<label>*The Location The Pet Was Found:</label>
								<input type="text" name="" placeholder="Address 1" />
							</div>
							<div class="field-div">
								<label>&nbsp;</label>
								<input type="text" name="" placeholder="Address 2" />
							</div>
						</div>
						<div class="field-wrap two-fields-wrap">
							<div class="field-div">
								<label>*Finder City:</label>
								<input type="text" name="" placeholder="City" />
							</div>
							<div class="field-div">
								<div class="field-wrap two-fields-wrap">
									<div class="field-div">
										<label>*State:</label>
										<select>
											<option>State</option>
										</select>
									</div>
									<div class="field-div">
										<label>*Zipcode:</label>
										<input type="text" name="" placeholder="Zipcode" />
									</div>
								</div>
							</div>
						</div>
						<div class="field-wrap submit-wrap">
							<div class="field-div">
								<button type="submit">
									Submit <i class="fa fa-caret-right"></i>
								</button>
							</div>
						</div>
					</div>
				</div>

			</div>

			<div class="col-sm-3 main-sidebar-col border-sidebar">

				<div class="widget">
					<h3>Report a Found Pet</h3>
					<form>
						<div class="field-div">
							<label>Enter SmartTag ID#</label>
							<input type="text" name="" />
							<button type="submit">
								Report <i class="fa fa-caret-right"></i>
							</button>
						</div>
					</form>
				</div>

				<div class="widget">
					<h3>Report a Missing Pet</h3>
					<p><img src="http://idtag.agiliscloud.com/wp-content/uploads/2018/02/lost-sidebar-img.png" alt="image" /></p>
					<div>
						<a href="#" class="site-btn">Report <i class="fa fa-caret-right"></i></a>
					</div>
				</div>

				<?php echo do_shortcode("[stag_sidebar id='main-sidebar']"); ?>

				<div class="widget">
					<h3>Find a Local Shelter</h3>
					<p class="text-left">
						Change a life fur-ever and adopt a pet today! Find a local shelter near you by entering your zipcode below.
					</p>
					<p><img src="http://idtag.agiliscloud.com/wp-content/uploads/2018/02/lost-sidebar-img.png" alt="image" /></p>
					<form>
						<div class="field-div">
							<label>Enter Zipcode</label>
							<input type="text" name="" />
							<button type="submit">
								Submit <i class="fa fa-caret-right"></i>
							</button>
						</div>
					</form>
				</div>

			</div>

		</div><!--/row-->
		
	</div><!--/container-->
	
</div><!--/container-wrap-->

<?php get_footer(); ?>