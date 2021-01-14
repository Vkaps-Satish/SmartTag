<?php 
/*
* Template Name:  Update Pet Information Template
*/
get_header(); 
if ( !is_user_logged_in() ){
    print('<script>
    		window.location.href = "'.site_url().'/login-to-smarttag/?login=1&redir=https://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'].'";
    	</script>');
    die();    
}
?>
<div class="container-wrap">		
	<div class="container main-content">
		<div class="row">
			<div class="col-sm-3 woo-sidebar">
				<h3 class="widgettitle"><?php echo $parent_title = get_the_title($post->post_parent); ?></h3>
				<?php echo do_shortcode("[wpb_childpages]"); ?>
		    </div>
			<div class="col-sm-9">
				<div class="page-heading">
					<h1><?php echo get_the_title(); ?></h1>
				</div>
			<?php if (isset($_POST['post_id'])) {
			        $postId = $_POST['post_id'];
			        $args = array( 'post_type' => 'pet_profile', 'p' => $postId);
			        $my_posts = new WP_Query($args); 
			        while ( $my_posts->have_posts() ) : $my_posts->the_post(); 
			            $mypod              = pods( 'pet_profile', get_the_id() ); 
			            $title              = get_the_title();
			            $smarttagid         = $mypod->display('smarttag_id_number');
			            $pet_type           = $mypod->display('pet_type');
			            $primary_breed      = $mypod->display('primary_breed');
			            $secondary_breed    = $mypod->display('secondary_breed');
			            $primary_color      = $mypod->display('primary_color');
			            $secondary_color    = $mypod->display('secondary_color');
			            $gender             = $mypod->display('gender');
			            $size               = $mypod->display('size');
			            $pet_date_of_birth  = $mypod->display('pet_date_of_birth');
			            $post_thumbnail_id  = get_post_thumbnail_id( get_the_id() );
			            $imageUrl 			= get_the_post_thumbnail_url();
			            ?>
			            <h3>Update Pet Information For:</h3>
			            <div class="row border-bottom">
			                <div class="col-sm-3 rmb-15">
			                   	<p><img class="pet-img" src="<?php echo $imageUrl; ?>" alt=""></p>
			                </div>
			                <div class="col-sm-9">
			                    <strong>Pet Name:</strong> <span class="name"><?php echo get_the_title(); ?></span>
			                    <br>
			                    <strong>Pet Type:</strong> <?php echo $mypod->display('pet_type'); ?>
			                    <br>
			                    <strong>IDTag Serial Number:</strong> <span class="name"><?php echo $mypod->display('smarttag_id_number'); ?></span>
			                </div>
			            </div>            
			        <?php endwhile;
			    ?>
			    <div class="contact-form">
			        <form class="update-pet-form" action="" method="post">
			        	<input type="hidden" name="petId" value="<?php echo $postId; ?>">
			        	<input type="hidden" name="action" value="ourServicesUpdatePetInfo">
			            <div class="lost-pet">
			                <div class="field-wrap two-fields-wrap">
			                    <div class="field-div">
			                        <label>*Pet Name:</label>
			                        <input type="text" name="pet_name" value="<?php echo $title; ?>" id="pet_name" placeholder="Pet Name" required="">
			                    </div>
			                </div>
			                <div class="field-wrap two-fields-wrap">
			                    <div class="field-div">
			                    	<label>Current Pet Image:</label>
			                        <p><img class="pet-img" src="<?php echo $imageUrl; ?>" alt=""></p>
			                    </div>
			                    <div class="field-div">
			                        <label>Upload a New Pet Image: (Optional)</label>
			                        <input type="file" name="feature" class="pet-image" id="pet-image">
			                        <div class="field-notice">
										Files must be less then 2MB. <br> Allowed file types .png/ .gif/ .jpg/ .jpeg
									</div>
			                    </div>
			                </div>
			                <div class="field-wrap two-fields-wrap">
							  	<div class="field-div">
									<label>*Pet Type & Breed: </label>
									<div class="field-wrap two-fields-wrap">
										<div class="field-div">
										 	<select name="pet_type" class="text-data" id="pettype" required="" aria-required="true">
												<option value="">Type</option>
												<option value="Type1" <?=  ($pet_type =='Type1') ? "selected": "" ?>>Type1</option>
												<option value="Type2" <?=  ($pet_type =='Type2') ? "selected": "" ?>>Type2</option>
												<option value="Type3" <?=  ($pet_type =='Type3') ? "selected": "" ?>>Type3</option>
												<option value="Type4" <?=  ($pet_type =='Type4') ? "selected": "" ?>>Type4</option>
											</select>
										</div>
									    <div class="field-div">
										   <select name="primary_breed" class="text-data" id="breedid" required="" aria-required="true">
											<option value="">Breed</option>
											<option value="Breed1"  <?=  ($primary_breed =='Breed1') ? "selected": "" ?>>Breed1</option>
											<option value="Breed2"  <?=  ($primary_breed =='Breed2') ? "selected": "" ?>>Breed2</option>
											<option value="breed3"  <?=  ($primary_breed =='Breed3') ? "selected": "" ?>>Breed3</option>	
											<option value="breed4"  <?=  ($primary_breed =='Breed4') ? "selected": "" ?>>Breed4</option>
												
											</select>
										</div>
									</div>
						    	</div>
						    	<div class="field-div">
									<label>Secondary Breed: (Optional)</label>
								    <select name="secondary_breed" class="text-data" id="sbreedid">
									<option value="">Breed</option>
									<option value="Breed1" <?=  ($secondary_breed =='Breed1') ? "selected": "" ?>>Breed1</option>
									<option value="Breed2" <?=  ($secondary_breed =='Breed1') ? "selected": "" ?>>Breed2</option>
									<option value="breed3" <?=  ($secondary_breed =='Breed1') ? "selected": "" ?>>Breed3</option>
									<option value="breed4" <?=  ($secondary_breed =='Breed1') ? "selected": "" ?>>Breed4</option>
									
									</select>
								</div>
					     	</div>
					    	<div class="field-wrap two-fields-wrap">
								<div class="field-div">
									<label>*Primay Color: </label>
								   <input type="text" name="primary_color" placeholder="Enter color of pet" class="text-data" required="" value="<?php echo $primary_color; ?>" />
								</div>
								<div class="field-div">
									<label>Secondary Color(s): (Optional)</label>
									<input type="text" name="secondary_color" placeholder="Enter color(s) of pet" class="text-data" value="<?php echo $secondary_color; ?>" />
								</div>
							</div>
							<div class="field-wrap two-fields-wrap">
								<div class="field-div">
									<div class="field-wrap two-fields-wrap">
										<div class="field-div">
											<label>*Gender: </label>
											<select name="gender" class="text-data" id="pgender" required=""  />
										        <option value="">Select</option>
												<option value="male" <?php if ($gender == "male"): ?>
													selected="selected"
												<?php endif ?>>Male</option>
												<option value="female" <?php if ($gender == "female"): ?>
													selected="selected"
												<?php endif ?>>Female</option>
											</select>
										</div>
									    <div class="field-div">
									    	<label>Size(Optional): </label>
										    <input type="text" name="size" value="<?php echo $size; ?>">
										</div>
									</div>
								</div>
					          	<div class="field-div">
									<label>Pet Date of Birth: (optional)</label>
									<div class="field-wrap three-fields-wrap ">
										<input type="text" name="pet_date_of_birth" id="pet-dob1" placeholder="mm/dd/yyyy" class="input-10 input" value="<?= $pet_date_of_birth; ?>">
										<!-- <input type="text" name="pet_date_of_birth" id="pet-dob1" placeholder="mm/dd/yy" class="input text-data pet-birth-date" value="<?php echo $pet_date_of_birth; ?>" required=""> -->
									</div>
					         	</div>
					      	</div>
			                <div class="field-wrap">
			                    <div class="field-div text-right">
			                        <input type="submit" name="update_pet_info" value="Update Information" class="site-btn">
			                    </div>
			                </div>
			                <div class="field-wrap">
			                	<div class="field-div">
			                		<div class="pet-error"></div>
			                		<div class="image-error"></div>
			                	</div>
			                </div>
			            </div>
			        </form>
			    </div>
			    <script type="text/javascript">
			        jQuery(document).ready(function($) {
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
			            $(".pet-birth-date").datepicker({
			                dateFormat : "mm/dd/yy"
			            });
			            $(function() {
	
							$("form.update-pet-form").validate({
								rules : {
									pet_name : 'required',
									pet_type : 'required',
									primary_breed : 'required',
									primary_color : 'required',
									gender : 'required',
									primary_color : 'required',
									feature:{
					                    required: false,
					                    extension: "jpg|png|gif|bmp|jpeg",
					                    checkSize: true
					                },
								},
								submitHandler: function(form) {
									$.ajax({
					                    type: 'POST',
					                    url: ajaxurl,
					                    data: new FormData(form),
					                    contentType: false,
					                    processData: false,
					                    success: function(response) {
					                    	response = $.parseJSON(response);
					                    	console.log(response.pet.success);
					                        if (response.pet.success) {
					                        	$(".pet-error").html('<div class="alert alert-success  alert-dismissible" style="margin-top:18px;"><a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a><strong>Success!</strong> '+response.pet.msg+'</div>');
					                        }

					                        if( document.getElementById("pet-image").files.length != 0 ){
											    if (response.image.success) {
											    	$(".image-error").html('<div class="alert alert-success  alert-dismissible" style="margin-top:18px;"><a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a><strong>Success!</strong> '+response.image.msg+'</div>');
											    	$image = document.querySelector('input[type=file]');
											    	console.log($image);
											    	readURLL($image,'pet-img');
											    }else{
											    	$(".image-error").html('<div class="alert alert-danger  alert-dismissible" style="margin-top:18px;"><a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a> '+response.image.msg+'</div>');
											    }
											}
					                    }
						            });	
								}
							});
						});
			            /*$('form.update-pet-form').on("submit",function(e){
			            	e.preventDefault();
			            	
			            });*/
			        });
			    </script>
   
		<?php }else{
				$paged  = (get_query_var('paged')) ? get_query_var('paged') : 1;
			    $userId = get_current_user_id();
			    $args   = array(
			        'post_type' => 'pet_profile',
			        'paged' => $paged,
			        'author' => $userId
			    );                       
			    $query = new WP_Query($args);
			    $i = 0;
			    if ($query->have_posts()) {
			        while ( $query->have_posts() ) : $query->the_post(); 
			            $mypod = pods( 'pet_profile', get_the_id() ); 
			            $smarttag_id_number = $mypod->display('smarttag_id_number');
			            $microchip_id_number = $mypod->display('microchip_id_number');
			            $subscriptionId  = $mypod->display("smarttag_subscription_id");
			            if (!empty($subscriptionId)) {
			                $subscription   = wcs_get_subscription($subscriptionId);
			                if (!empty($subscription)) {
			                    // print_r($subscription);
			                    $startDate      = $subscription->get_date("date_created");
			                    $date           = $subscription->get_date("end");
			                    if (empty($date)) {
			                        $date           = $subscription->get_date("next_payment");
			                    }
			                    $date           = date_parse_from_format('Y-m-d H:i:s',$date);
			                    $date           = mktime(0, 0, 0, $date['month'], $date['day'], $date['year']);
			                    $date           = date("m/d/Y", $date);

			                    $startDate           = date_parse_from_format('Y-m-d H:i:s',$startDate);
			                    $startDate           = mktime(0, 0, 0, $startDate['month'], $startDate['day'], $startDate['year']);
			                    $startDate           = date("m/d/Y", $startDate);
			                    // $subscription = wc_get_order($subscriptionId);
			                    foreach( $subscription->get_items() as $item_id => $product_subscription ){
			                        // Get the name
			                        $product_name = $product_subscription['name']." (Expires: ".$date.")";
			                        $variationId  = $product_subscription['variation_id'];
			                    }
			                }
			            }else{
			                $product_name = '';
			                $startDate    = '';
			                $date         = '';
			            }
			            
			            ?>
			            <div class="bottom-border-box">
			                <h3>Registered Pet <?php echo ++$i; ?></h3>
			                <div class="row">
			                    <div class="col-sm-3 rmb-15">
			                        <a href="javascript:;" class="show-post">
			                            <?php echo get_the_post_thumbnail(); ?>
			                        </a>
			                    </div>
			                    <div class="col-sm-5 rmb-15">
			                        <strong>Pet Name:</strong> <a href="javascript:;" class="show-post"><span class="name"><?php echo get_the_title(); ?></span></a>
			                        <br>
			                        <strong>Pet Type:</strong> <span><?php echo $mypod->display('pet_type'); ?></span>
			                        <br>
			                        <strong>IDTag Serial Number:</strong> <span class="name"><?php echo $mypod->display('smarttag_id_number'); ?></span>
			                        <br>
			                        <strong>IDTag Microchip Number:</strong> <span class="name"><?php echo $microchip_id_number; ?></span>
			                        <br>
			                        <strong>ID Tag Plan:</strong> <span><?php echo $product_name; ?></span>
			                    </div>
			                    <div class="col-sm-4 mb-elements">                        
			                        <form action="" method="post" class="custom-form">
			                            <input type="hidden" name="startDate" value="<?php echo $startDate; ?>">
			                            <input type="hidden" name="endDate" value="<?php echo $date; ?>">
			                            <input type="hidden" name="post_id" value="<?php echo get_the_ID(); ?>">
			                            <input type="hidden" name="smarttagid" value="<?php echo $smarttag_id_number; ?>">
			                            <p><button type="submit" class="site-btn-red">Update/Edit Pet Profile <i class="fa fa-caret-right"></i></button></p>
			                            <p><a href="javascript:;" class="custom-replacement-tag-btn light-blue-link"><strong>Order a free Replacement Tag</strong> <i class="fa fa-caret-right"></i></a></p>
			                            <?php if (!empty($product_name)) { ?>
			                                <p><a href="<?php echo 'get_site_url()/my-account/view-subscription/'.$subscriptionId.'/'; ?>" class="button view site-btn-light-blue">Update Protection Plan <i class="fa fa-caret-right"></i></a></p>
			                            <?php } ?>
			                     
			                        </form>
			                    </div>
			                </div>
			            </div>
			        <?php 
			        endwhile;
			        $total_pages = $query->max_num_pages;
			        if ($total_pages > 1){

			            $current_page = max(1, get_query_var('paged'));

			            echo "<div id='pagination'>".paginate_links(array(
			                'base' => get_pagenum_link(1) . '%_%',
			                'format' => 'page/%#%',
			                'current' => $current_page,
			                'total' => $total_pages,
			                'prev_text'    => __('prev'),
			                'next_text'    => __('next'),
			            ))."</div>";
			        }?>
			        <?php
			    } else{
			        echo "Sorry, No pet found";
			    } 
			} ?>
			</div>
		</div>
	</div>
</div>
<?php get_footer(); ?>
