<?php 

get_header(); 
nectar_page_header($post->ID); 

//full page
$fp_options = nectar_get_full_page_options();
extract($fp_options);

?>

<?php $thumb = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'full' );?>
	<?php
    if(has_post_thumbnail()) { ?>
        <div class="page-featured-img">
            <img src='<?php echo $thumb['0'];?>' alt='image' />
        </div>
<?php } ?>



<?php
/*
* Template Name: Report Pet Found
*/

get_header();
nectar_page_header($post->ID); 
//full page
$fp_options = nectar_get_full_page_options();
extract($fp_options);
?>
<?php
 $post_id= 7014;
if($_POST['submit']){
	wp_update_attachment_metadata( $post_id, $data ); 
	foreach ($_POST as $meta_key => $meta_value) {
		update_post_meta( $post_id,$meta_key, $meta_value, $prev_value);
			}		 
		} 

if($_POST['upload']){
	 $imgdata = $_POST['finder_pet_image'];
	 // These files need to be included as dependencies when on the front end.
    require_once( ABSPATH . 'wp-admin/includes/image.php' );
    require_once( ABSPATH . 'wp-admin/includes/file.php' );
    require_once( ABSPATH . 'wp-admin/includes/media.php' );

    // Let WordPress handle the upload.
    $img_id = media_handle_upload( $imgdata, 0 );
    
    if ( is_wp_error( $img_id ) ) {
      echo "Error";
    } else {
      update_user_meta( $current_user->ID, 'avatar_user', $img_id );
    }
}
?>
<div class="container-wrap">
		
	<div class="container main-content">

		<div class="container">
			<div class="page-heading single-page-heading">
				<h1>Report Found Pet</h1>
			</div>
		</div>
		
		<div class="row">

			<div class="col-sm-9">
				
				<div class="single-blog-content">
			<script src='https://www.google.com/recaptcha/api.js'></script>
				<form method="POST" action="">
					<div class="contact-form">
						<div class="field-wrap two-fields-wrap">
							<div class="field-div">
								<label>Enter the SmartTag ID#(if any):</label>
								<input type="text" name="" />
							</div>
							
						</div>

						<div class="field-wrap two-fields-wrap">
							<div class="field-div">
								<label>Enter the Microchip ID#(if any):</label>
								<input type="text" name="" />
							</div>
							<div class="field-div">
								 <input type="hidden" name="pet_status" value="0">
							</div>
							
						</div>
						<div class="field-wrap two-fields-wrap">
							<div class="field-div">
								<label>What kind of pet did you find?</label>
								<select>
									<option>Please select..</option>
								</select>
							</div>
							
						</div>

						<div class="field-wrap two-fields-wrap">
							<div class="field-div">
								<label>*Finder Name:</label>
								<input type="text" name="finder_name" />
							</div>
							<div class="field-div">
								<label>*Finder Email:</label>
								<input type="text" name="finder_email" />
							</div>
							
						</div>
						<div class="field-wrap two-fields-wrap">
							<div class="field-div">
								<label>*Phone:</label>
								<input type="number" name="finder_phone" placeholder="1 (555) 123-1234" />
							</div>
							<div class="field-div">
								<label>&nbsp;</label>
								<input type="text" name="finder_phone2" placeholder="1 (555) 123-1234" />
							</div>
						</div>
						<div class="field-wrap">
							<div class="field-div">
								<label>*Finder Country</label>
								<select name="finder_country">
									<option>United States</option>
								</select>
							</div>
						</div>
						<div class="field-wrap two-fields-wrap">
							<div class="field-div">
								<label>*The Location The Pet Was Found:</label>
								<input type="text" name="finer_pet_found_add1" placeholder="Address 1" />
							</div>
							<div class="field-div">
								<label>&nbsp;</label>
								<input type="text" name="finer_pet_found_add2" placeholder="Address 2" />
							</div>
						</div>
						<div class="field-wrap two-fields-wrap">
							<div class="field-div">
								<label>*Finder City:</label>
								<input type="text" name="finder_city" placeholder="City" />
							</div>
							<div class="field-div">
								<div class="field-wrap two-fields-wrap">
									<div class="field-div">
										<label>*State:</label>
										<select name="finder_state">
											<option>State</option>
										</select>
									</div>
									<div class="field-div">
										<label>*Zipcode:</label>
										<input type="text" name="finder_zip_code" placeholder="Zipcode" />
									</div>
								</div>
							</div>
						</div>
						
						<div class="field-wrap two-fields-wrap">
							<div class="field-div">
								<label>*Please varfiy that you are human:</label>
								<div class="g-recaptcha" data-sitekey="6Ldrs0sUAAAAAE4ux2ivpW6ezhEukOFkQWpKJ6uM"></div>
								
							</div>
							<div class="field-div">
								<input type="submit" name="submit" value="Report this pet as found">
								<!-- <button type="submit">
									Submit <i class="fa fa-caret-right"></i>
								</button> -->
							</div>
						</div>
					

					 </div>
				</form>
			 </div>
										
				</div>					
				<?php nectar_pagination(); ?>

			
			
			<div class="col-sm-3 main-sidebar-col border-sidebar">

				<div class="widget">
					<form method="post" action="" enctype='multipart/form-data'>
					      <div class="field-div">
								<label>Upload an image of the pet you found:</label>
								<input class="text-input" name="finder_pet_image" type="file" id="finder_pet_image" multiple="false"/>
								<!-- <input type="file" name="finder_pet_image"> -->
								<span>Files must be less than 2 MB</span>
                                <span>Allowed file types: .png/ .gif /.jpg /.jpeg</span>
                                <input type="submit" name="upload" value="upload">
							</div>
						</form>
					</div>
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

<div id="content">
    


</div>

<?php
// get_footer();