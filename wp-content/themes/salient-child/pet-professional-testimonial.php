<?php 
/*
* Template Name:  Pet Professional Testimonial
*/
get_header(); 

$countries_obj = new WC_Countries();
$CountriesName = $countries_obj->__get('countries');

//Redirect user if user not login or not petprofessional
if ( is_user_logged_in() ){


	$userId = get_current_user_id();
		$havemeta = get_user_meta($userId, 'user_image', true);
    	if ($havemeta) {
 			$image = wp_get_attachment_image_src($havemeta);
    	}else{
    		$image = wp_get_attachment_image_src(7919);
    	}
	
	$userImage = get_avatar_url($userId);
	$userImageId = '74571';

    $current_user = wp_get_current_user();
    $roles = $current_user->roles; 

	    if( !$roles == 'pet_professional' || !in_array( 'pet_professional', $roles )){
	        print('<div>
	        <div class="not-found-text width-100">This page is only for Pet-Professionals..</div></div>');
	        die();
	    }
}else{
    print('<script>window.location.href="/pet-professionals-signup"</script>');
}
?>
<div class="container-wrap">		
	<div class="container main-content">
		<div class="row">
			<div class="col-sm-3 woo-sidebar">
				<!-- <h3 class="widgettitle">Pet Professional</h3> -->
				<!-- <?php echo do_shortcode("[wpb_childpages]"); ?> -->
				<?php echo do_shortcode("[stag_sidebar id='pet-professional-sidebar']"); ?>
				&nbsp;
                <?php echo do_shortcode("[stag_sidebar id='main-sidebar']"); ?>
				<!-- <ul class="children">
					<li class="cat-item cat-item-16"><a href="/pet-professional-pagee/email-customer-services">Email Customer Service</a></li>
					<li class="cat-item cat-item-27"><a href="/pet-professional-pagee/pet-licensing">Pet Licensing</a></li>
					<li class="cat-item cat-item-31"><a href="/pet-professional-pagee/provide-testimonial">Provide Testimonial</a></li>
					<li class="cat-item cat-item-32"><a href="/pet-professional-pagee/order-history">Order History</a></li>
					<li class="cat-item cat-item-33"><a href="/pet-professional-pagee/billing-shipping-information">Billing/Shipping Information</a></li>
				</ul> -->
		    </div>
			<div class="col-sm-9">
				<div class="page-heading">
					<h1><?php echo get_the_title(); ?></h1>
				</div>
				<?php 
				if (isset($_POST['saveTestimonial'])) {
					$title              = $_POST['title'];
					$postCont 			= $_POST['testimonial_content'];
				    $userID             = get_current_user_id();
				    
				    $new_post = array(
				     'post_title'   => $title,
				     'post_status'  => 'publish',
				     'post_type'    => 'testimonial',
				     'post_content' => $postCont,
				    );

				 	$post_id = wp_insert_post($new_post);
			 		update_post_meta($post_id,'firstname',$_POST['first_name']);
			 		update_post_meta($post_id,'lastname',$_POST['last_name']);
			 		update_post_meta($post_id,'country',$_POST['country']);
			 		update_post_meta($post_id,'state',$_POST['state']);

				    wp_set_object_terms( $post_id, array(93), 'testimonial_category' );
				    if($_POST['current'] == 1){
				    	
				    	set_post_thumbnail( $post_id, $userImageId );

				 	}else{

				 		if (isset($_FILES['image']) && $_FILES['image']['size'] != 0){
					    	 $upload = wp_upload_bits($_FILES["image"]["name"], null, file_get_contents($_FILES["image"]["tmp_name"]));
						     
						    $filename = $upload['file'];
						    $wp_filetype = wp_check_filetype($filename, null );
						    $attachment = array(
						        'post_mime_type' => $wp_filetype['type'],
						        'post_title' => sanitize_file_name($filename),
						        'post_content' => '',
						        'post_status' => 'inherit'
						    );
						    
						     $attach_id = wp_insert_attachment( $attachment, $filename, $post_id );
						    require_once(ABSPATH . 'wp-admin/includes/image.php');
						    $attach_data = wp_generate_attachment_metadata( $attach_id, $filename );
						    wp_update_attachment_metadata( $attach_id, $attach_data );
						    set_post_thumbnail( $post_id, $attach_id );
						    
				    	}
				    }
				   			echo "<label><b> Thank you for writing a testimonial!</b></label>";
						    echo "<p>Your testimonial will be reviewed and posted to our <a href='/testimonials/pet-professionals/'> Pet Professional's Testimonial </a> page within 48 hours.</p>";
				}else{
			?>
						<form method="post" id="testimonial" enctype="multipart/form-data" action="">
							<div class="contact-form">
								<div class="field-wrap">
									<div class="field-div">
										<label>*Title</label>
							            <input type="text" name="title" required="" placeholder="Enter title">
									</div>
								</div>
								<div class="field-wrap two-fields-wrap">
									<div class="field-div">
										<label>*First Name</label>
							            <input type="text" name="first_name" placeholder="First Name" required="">
									</div>
									<div class="field-div">
										<label>*Last Name</label>
							            <input type="text" name="last_name" placeholder="Last Name" required="">
									</div>
								</div>
								<div class="field-wrap two-fields-wrap">
									<div class="field-div">
										<label>*Country</label>
										<select class="address-country country_select primary-info regular-text" name="country" required="">
						                    <option value="">Select a Country</option>
						                    <?php foreach ($CountriesName as $key => $value): 
						                        if ($country == $key) {
						                            echo '<option value="'.$key.'" selected>'.$value.'</option>';
						                        }else{
						                            echo '<option value="'.$key.'">'.$value.'</option>';
						                        }
						                    ?>
						                    <?php endforeach; ?>
						                </select>
									</div>
									<div class="field-div">
										<label class="statevalidate">*State</label>
							            <input type="text" name="state" class="address-state" data-val=""  required="">
									</div>
								</div>
								<div class="field-wrap two-fields-wrap">
									<div class="field-div">
										<?php 
										if(empty($image[0])){ 
	                                        $image = site_url()."/wp-content/uploads/2019/04/userimage.png";
	                                    }else{ 
	                                        $image = $image[0];
	                                    } ?>
										<label>*Use Current Profile Image?</label>
										<div class="field-div primary-alert">
                                            <div class="two-checks">
                                                <p>
                                                    <input type="radio" name="current" required="" class="current-image" value="1" checked > Yes
                                                </p>
                                                <p>
                                                    <input type="radio" name="current" required="" class="current-image" value="0" > No
                                                </p>
                                            </div>
                                        </div>
									</div>
									<div class="field-div">
										<label>Profile Image</label>
							            <input style="display: none;" id="imgInp" type="file" name="image">
							            <img id="blah" class="blahimg" src="<?= $image; ?>"  class="current-img">
							            <?php if(empty($userImage)){
							             echo "<p class='blahimg'>User's image not found</p>"; }  ?>
							            
							            <p class="message" style="display: none;">Files must be less than 2 MB.<br>
										Allowed file types: .png / .gif / .jpg / .jpeg</p>
										
										
							        </div>
							       
								</div>
								<div class="field-wrap">
									<div class="field-div">
										<label>*Write Testimonial</label>
							            <textarea name="testimonial_content" placeholder="Write your testimonial here.." required=""></textarea>
									</div>
								</div>
								<div class="field-wrap submit-wrap">
									<div class="field-div">
										<input type="submit" name="saveTestimonial" value="Submit">
									</div>
								</div>
							</div>
						</form>
				<?php } ?>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
	jQuery(document).ready(function($){
		// var defaultImage = "https://prelaunch.idtag.com/wp-content/uploads/2019/02/pet-image.jpg";
		var userImage = "<?= $image;?>";
		var defaultImage = '<?= site_url()."/wp-content/uploads/2019/04/userimage.png";?>';
		$(".current-image").change(function(){
			if ($(this).val() == 1) {
				$("#imgInp").fadeOut();
				$(".message").fadeOut();
				
				$("#blah").attr("src",userImage);
				$(".curr-image-file").hide();
				$(".curr-image-file").prop('disabled',true);
				$(".curr-image-file2").prop('disabled',false);
				$("#imgInp-error").hide();
			}else{
				$("#imgInp").fadeIn();
				$(".message").fadeIn();
				
				$("#imgInp").val(null);
				$("#blah").attr("src",defaultImage);
				$(".curr-image-file").show();
				$(".curr-image-file").prop('disabled',false);
				$(".curr-image-file2").prop('disabled',true);
				var image = document.querySelector('input[type=file]');
                //readURLl(image,'current-img');
			}
		});
		$(".curr-image-file").change(function(){
			var image = document.querySelector('input[type=file]');
            console.log(image);
            readURLl(image,'current-img');
		});

		function readURL(input) {
		    if (input.files && input.files[0]) {
		        var reader = new FileReader();

		        reader.onload = function (e) {
		            $('#blah').attr('src', e.target.result);
		        }

		        reader.readAsDataURL(input.files[0]);
		    }
		}

		$("#imgInp").change(function(){
			$("#blah").fadeIn();
		    readURL(this);
		    
		});

		jQuery.validator.addMethod("checkSize", function (value, element) {
	    if (value != "") {
	        var size = element.files[0].size;
	        if (size > 2*1000000)// checks the file more than 1 MB
	        {
	            return false;
	        } else {
	           return true;
	        }
	    }else{
	        return true;
	    }

	    }, "File must be less then 2MB");
		//validate
		var Validator = $('form[id="testimonial"]').validate({
				 rules: {
	                image:{
	                    required: false,
	                    extension: "jpg|png|gif|bmp|jpeg",
	                    checkSize: true
	                },
	             },   
				submitHandler: function(form) {
					form.submit();
				}
			});
	});
</script>

<?php get_footer(); ?>

<!-- 7857 -->