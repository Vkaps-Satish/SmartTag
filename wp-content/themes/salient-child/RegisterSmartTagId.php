<?php 
/*
* Template Name:  SmartTag registery
*/
get_header();

$getbreeds = get_top_parents('pet_type_and_breed');
	
$single 		= true; 
$user_id 		= get_current_user_id(); 
$countries_obj 	= new WC_Countries();
$countries 		= $countries_obj->__get('countries');
$current_user   = get_user_by( 'id', $user_id );
$first_name 	= get_user_meta( $user_id, 'first_name', $single ); 
$last_name 	    = get_user_meta( $user_id, 'last_name', $single ); 
$email 		    = $current_user->user_email; 
$primary_country= get_user_meta( $user_id, 'primary_country', $single );
$primary_state  = get_user_meta( $user_id, 'primary_state', $single );
$primary_address_line1 = get_user_meta( $user_id,'primary_address_line1', $single ); 
$primary_address_line2 = get_user_meta( $user_id,'primary_address_line2', $single ); 
$primary_city		   = get_user_meta( $user_id,'primary_city', $single ); 
$pristate 		       = get_user_meta( $user_id,'primary_state', $single );

$primary_postcode 	 = get_user_meta( $user_id,'primary_postcode', $single ); 
$primary_home_number = get_user_meta( $user_id,'primary_home_number', $single ); 
$primary_cell_number = get_user_meta( $user_id,'primary_cell_number', $single ); 
$Sfirst_name 	     = get_user_meta( $user_id, 'secondary_first_name', $single );
$Slast_name 	     = get_user_meta( $user_id, 'secondary_last_name', $single ); 
$Semail 		     = get_user_meta( $user_id, 'secondary_email', $single );
$Sprimary_country    = get_user_meta( $user_id, 'secondary_country', $single ); 

$Sprimary_address_line1 = get_user_meta( $user_id,'secondary_address_line1', $single ); 
$Sprimary_address_line2 = get_user_meta( $user_id,'secondary_address_line2', $single ); 
$Sprimary_city			= get_user_meta( $user_id,'secondary_city', $single ); 
$Sprimary_state 		= get_user_meta( $user_id,'secondary_state', $single ); 

$Sprimary_postcode 	  = get_user_meta( $user_id,'secondary_postcode', $single ); 

$Sprimary_home_number = get_user_meta( $user_id,'secondary_home_number', $single ); 
$Sprimary_cell_number = get_user_meta( $user_id,'secondary_cell_number', $single );

$secondary_cell_country_code  = get_user_meta($user_id,'secondary_cell_country_code',$single);
$secondary_phone_country_code  = get_user_meta($user_id,'secondary_phone_country_code',$single);
$primary_home_number_code = get_user_meta($user_id,'primary_phone_country_code',$single);
$primary_cell_number_code = get_user_meta($user_id,'primary_cell_country_code',$single); 
?>

<!-- <?php if(is_user_logged_in()){
	
 ?>
	<script type="text/javascript">
		jQuery(document).ready(function(){
			$.each($('#profileuser1 .text-data'), function() {
				
				var name = $(this).attr('name');
				$("#"+name).text(localStorage.getItem(name));
			
				if(name == "pet_type" || name == "primary_breed" || name == "secondary_breed" || name == "gender" || name == "size"){
					if($("#profileuser1 select[name='"+name+"']").hasClass('text-data')){

						var optionValue  = localStorage.getItem(name);
						$('#profileuser1 select[name="'+name+'"] option[value="'+optionValue+'"]').attr('selected', true);
					}					
				}else{
					
					$( "#profileuser1 input[name='"+name+"']").val(localStorage.getItem(name));
				}

			});

			$.each($('#profileuser1 .text-data'), function() {
				var fieldName = $(this).attr('name');
	        	localStorage.removeItem(fieldName);
	        });

		})
	</script>
<?php } ?> -->

<div class="container-wrap">
	<div class="container main-content">
		<div class="row">
			<div class="woo-sidebar col-sm-3">
		        <?php echo do_shortcode("[stag_sidebar id='our-services']"); ?>
		    </div>
			<div class="woo-content col-sm-9" id="woo-content">
				<?php if (has_post_thumbnail( $post->ID ) ): ?>
				    <?php $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'single-post-thumbnail' ); ?>
				    <div class="page-image">
				    	<img src="<?php echo $image[0]; ?>" alt="image" />
				    </div>
				<?php endif; ?>
				<div class="page-heading">
					<h1>Register a SmartTag ID Tag</h1>
				</div>
				<section class="multi-step-form">
				  	<form id="profileuser1" method="POST" enctype="multipart/form-data">		
						<fieldset aria-label="Step One" tabindex="-1" id="step-1" class="step-form-box">
							<div class="contact-form" id="pro-info">	
						    	<div class="field-wrap two-fields-wrap">
									<div class="field-div">
										<label>*Serial Number </label>
										<input type="text" placeholder="Serial Number" name="smarttag_id_number" class="text-data sereal-number-1" id="sname_input" required="" value="<?= (isset($_GET['id'])) ? $_GET['id'] : "" ?>"   />
									</div>
									<div class="field-div">
										<label> </label>
										<input type="text" name="conf_smarttag_id_number" placeholder="Confirm Serial Number" class="sereal-number-2 text-data" required="" value="<?= (isset($_GET['id'])) ? $_GET['id'] : "" ?>" />
									</div>							
								</div>
								<div class="field-wrap two-fields-wrap">
						        	<div class="field-div">
										<label>*Pet Name</label>
										<input type="text" name="pet_name" class="text-data" id="pname_input"  placeholder="Enter Pet Name" required="" />
									</div>
								</div>
								<div class="field-wrap two-fields-wrap">
								  	<div class="field-div">
										<label>*Pet Type & Breed </label>
										<div class="field-wrap two-fields-wrap">
											<div class="field-div">
											 	<select name="pet_type" class="text-data" id="pettype" required=""  >
													<option value="">Type</option>
													<?php foreach ($getbreeds as $key => $value) { ?>
												
												<option value="<?= $value['term_id'] ?>"><?= $value['name'] ?></option>
												
													<?php } ?>
												</select>
											</div>
										    <div class="field-div">
											   <select name="primary_breed" class="text-data" id="breedid" required="" >
													<option value="">Breed</option>
												
												</select>
											</div>
										</div>
							    	</div>
							    	<div class="field-div">
										<label>Secondary Breed (Optional)</label>
									    <select name="secondary_breed" class="text-data" id="sbreedid" >
											<option value="">Breed</option>
										</select>
									</div>
						     	</div>
						    	<div class="field-wrap two-fields-wrap">
									<div class="field-div">
										<label>*Primary Color </label>
										<input type="text" name="primary_color" placeholder="Enter color of pet" class="text-data" id="pcolor" required="" />
									</div>
									<div class="field-div">
										<label>Secondary Color(s) (Optional)</label>
										<input type="text" name="secondary_color" placeholder="Enter color(s) of pet" class="text-data" id="scolor" />
									</div>
								</div>
								<div class="field-wrap two-fields-wrap">
									<div class="field-div">
										<div class="field-wrap two-fields-wrap">
											<div class="field-div">
												<label>*Gender </label>
											    <select name="gender" class="text-data" id="pgender" required="">
											    	<option value="">Select</option>
													<option value="male" >Male</option>
													<option value="female">Female</option>
												</select>
											</div>
										    <div class="field-div">
										    	<label>Size(Optional) </label>
											   <select name="size" class="text-data" id="psize">
											    	<option value="">Select</option>
													<option value="1">1</option>
													<option value="2">2</option>
												</select>
											</div>
										</div>
									</div>
						          	<div class="field-div">
										<label>Pet Date of Birth (Optional)</label>
											<input type="text" name="pet_date_of_birth" id="pet-dob1" placeholder="mm/dd/yyyy" class="input-10 input text-data">
						         	</div>
						      	</div>	
							        <div class="field-wrap two-fields-wrap">
							        	 <!-- <label>*Upload Pet Image (Optional however in the event your pet is lost a picture is very helpful)</label> -->
										<div class="field-div">
							                <label>Upload Pet Image</label>
							                <input type="file" name="files" accept="image/*" class="files-data" multiple id="imgInp" required=""  />
							               
										</div>
							            <div class="field-div">
							            	<label></label>
							            	<div class="field-notice">
										    	File must be less than 2MB. 
										    	<br>
										    	Allowed file types .png/ .gif/ .jpg/ .jpeg
											</div>
							            </div>
							        </div> 
								<div class="step-btns">
									<button class="btn btn-default btn-next" type="button" aria-controls="step-2">Next <i class="fa fa-caret-right"></i></button>
								</div>
							</div>
						</fieldset>
						<fieldset aria-label="Step Two" tabindex="-1" id="step-2" class="step-form-box">
							<?php  if(is_user_logged_in()) { ?>
							<div class="contact-form" id="cus-info">
						       <div class="field-wrap two-fields-wrap">
						       	<input type="hidden" name="UsrLoginId" class="user-data" value="<?php echo $user_id;?>" />
						       	
									<div class="field-div">
										<label>*First Name </label>
										<input type="text" name="p_fst_name" placeholder="First Name" class="user-data" id="u-first" required="" value="<?php echo $first_name;?>" />
									</div>
									<div class="field-div">
										<label>*Last Name </label>
										<input type="text" name="p_lst_name" placeholder="Last Name" class="user-data" id="u-last" required="" value="<?php echo $last_name;?>"   />
									</div>
								</div>
								<div class="field-wrap two-fields-wrap">
									<div class="field-div">
										<label>*Email </label>
										<input type="email" name="p_email" placeholder="Enter Email Address" class="user-data" id="u-email" required="" disabled value="<?php echo $email;?>"    />
									</div>
									<div class="field-div">
										<label>*Select Your Country </label>
										<select name="p_country" class="user-data address-country" id="u-country" required="" >
										<option value="">Select</option>
											<?php foreach ($countries as $key => $value) {?>
											<option value="<?php echo $key; ?>" <?php if(!empty($primary_country) && $primary_country  == $key){ echo 'selected="selected"';}?>><?php echo $value;?></option>
											<?php } ?>
									</select>
									</div>
								</div>
								<div class="field-wrap two-fields-wrap">							
									<div class="field-div">
										<label>*Address</label>
										<input type="text" name="p_add1" placeholder="Address line 1" class="user-data" id="u-add1" required="" value="<?php echo $primary_address_line1;?>"  />
									</div>
									<div class="field-div">
										<label></label>
										<input type="text" name="p_add2" placeholder="Address line 2" class="user-data" id="u-add2" value="<?php echo $primary_address_line2;?>"  />
										
									</div>
								</div>	
								<div class="field-wrap two-fields-wrap">
									<div class="field-div">
										<input type="text" name="p_city" placeholder="City" class="user-data" id="u-city1" required="" value="<?php echo $primary_city;?>" />
									</div>
									<div class="field-div">
										<div class="field-wrap two-fields-wrap">
											<div class="field-div">
												<label class="statevalidate" style="display: none"></label>
												<select name="p_state" class="user-data address-state s-sate rq" data-val="<?php echo $primary_state; ?>"></select>
											</div>
											<div class="field-div">
												<input type="text" name="p_zipcode" placeholder="Zipcode" class="user-data" id="u-zip" required="" value="<?php echo $primary_postcode;?>" />
											</div>
										</div>
									</div>
								</div>
								<div class="field-wrap two-fields-wrap">
									<div class="field-div">
										<label>*Primary Phone Number </label>
										<input type="text" name="p_prm_no" placeholder="1(555) 123-1234" class="user-data phone-number" id="p-phone"  required="" value="<?php echo $primary_home_number; ?>" readonly/>
										<input type="hidden" name="p_prm_no_code" placeholder="1(555) 123-1234" class="user-data" value="<?php echo $primary_home_number_code; ?>" />
									</div>
									<div class="field-div">
										<label>Secondary Phone Number </label>
										<input type="text" name="p_sec_no" placeholder="1(555) 123-1234" class="user-data phone-number" id="ps-phone" value="<?php echo $primary_cell_number;?>" />
										<input type="hidden" name="p_sec_no_code" placeholder="1(555) 123-1234" class="user-data" value="<?php echo $primary_cell_number_code; ?>" />
									</div>
								</div>
							</div>
							<div class="step-accordion">
								<h4 class="step-acc-head" id="sec-form"><i class="fa fa-plus"></i> Enter Secondary Contact Information (Optional)</h4>
								<div class="step-acc-content">
									<div class="contact-form" id="sec-cont-info">
										<div class="field-wrap two-fields-wrap">
											<div class="field-div">
												<label>First Name</label>
												<input type="text" name="s_fst_name" placeholder="First Name" class="user-data" id="s-name" value="<?php echo $Sfirst_name;?>" />
											</div>
											<div class="field-div">
												<label>Last Name</label>
												<input type="text" name="s_lst_name" placeholder="Last Name" class="user-data" id="s-lstname" value="<?php echo $Slast_name;?>" />
											</div>
										</div>
										<div class="field-wrap two-fields-wrap">
											<div class="field-div">
												<label>Email</label>
												<input type="email" name="s_email" placeholder="Enter Email Address" class="user-data" id="s-email" value="<?php echo $Semail;?>" />
											</div>
											<div class="field-div">
												<label>Select Your Country</label>
												<select name="s_country" class="user-data address-country not-require" id="s-county">
													<option value="">Select</option>
													<?php foreach ($countries as $key=>$value) {?>
													<option value="<?php echo $key; ?>" <?php if(!empty($Sprimary_country) && $Sprimary_country==$key){ echo 'selected="selected"';}?>>
														<?php echo $value;?>
													</option>
													<?php } ?>
												</select>
											</div>
										</div>
										<div class="field-wrap two-fields-wrap">
											<div class="field-div">
												<label>Address</label>
												<input type="text" name="s_add1" placeholder="Address line 1" class="user-data" id="sadd1" value="<?php echo $Sprimary_address_line1;?>" />
											</div>
											<div class="field-div">
												<label></label>
												<input type="text" name="s_add2" placeholder="Address line 2" class="user-data" id="s-add2" value="<?php echo $Sprimary_address_line2;?>" />
											</div>
										</div>
										<div class="field-wrap two-fields-wrap">
											<div class="field-div">
												<input type="text" name="s_city" placeholder="City" class="user-data" id="s_city1" value="<?php echo $Sprimary_city;?>" />
											</div>
											<div class="field-div">
												<div class="field-wrap two-fields-wrap">
													<div class="field-div state-div">
														<label class="statevalidate" style="display: none"></label>
														<select name="s_state" class="user-data address-state s-sate not-require" data-val="<?php echo $Sprimary_state; ?>"></select>
													</div>
													<div class="field-div">
														<input type="text" name="s_zipcode" placeholder="Zipcode" class="user-data" id="s-zip" value="<?php echo $Sprimary_postcode;?>" />
													</div>
												</div>
											</div>
										</div>
										<div class="field-wrap two-fields-wrap">
											<div class="field-div">
												<label>Primary Phone Number</label>
												<input type="text" name="s_prm_no" placeholder="1(555) 123-1234" class="user-data phone-number" id="sp-phone" value="<?php echo $Sprimary_home_number;?>" />
												<input type="hidden" name="s_prm_no_code" placeholder="1(555) 123-1234" class="user-data" value="<?php echo $secondary_phone_country_code;0 ?>" />
											</div>
											<div class="field-div">
												<label>Secondary Phone Number</label>
												<input type="text" name="s_sec_no" placeholder="1(555) 123-1234" class="user-data phone-number" id="ss-phone" value="<?php echo $Sprimary_cell_number;?>" />
												<input type="hidden" name="s_sec_no_code" placeholder="1(555) 123-1234" class="user-data" value="<?php echo $secondary_cell_country_code; ?>" />
											</div>
										</div>
									</div>
								</div>
							</div>
							<?php }else{ ?>
								<div class="contact-form" id="cus-info">
							       <div class="field-wrap two-fields-wrap">
							       		<div class="field-div">
											<label>*First Name</label>
											<input type="text" name="p_fst_name" placeholder="First Name" class="user-data" id="u-first" required="" value="" />
										</div>
										<div class="field-div">
											<label>*Last Name </label>
											<input type="text" name="p_lst_name" placeholder="Last Name" value="" class="user-data" id="u-last" required=""  />
										</div>
									</div>
									<div class="field-wrap two-fields-wrap">
										<div class="field-div">
											<label>*Email </label>
											<input type="email" name="p_email" placeholder="Enter Email Address" value="" class="user-data" id="u-email" required=""  />
										</div>
										<div class="field-div">
											<label>*Password </label>
											<input type="password" name="password" placeholder="Enter Password" class="user-data" required=""  />
										</div>	
									</div>
									<div class="field-wrap">
										<div class="field-div">
											<label>*Select Your Country </label>
											<select name="p_country" class="user-data address-country" id="u-country" required="">
												<option value="">Select</option>
												<?php foreach ($countries as $key => $value) {?>
												<option value="<?php echo $key; ?>"><?php echo $value;?></option>
												<?php } ?>
											</select>
										</div>
									</div>
									<div class="field-wrap two-fields-wrap">							
										<div class="field-div">
											<label>*Address</label>
											<input type="text" name="p_add1" placeholder="Address line 1" class="user-data" id="u-add1" required="" value=""  />
										</div>
										<div class="field-div">
											<label></label>
											<input type="text" name="p_add2" placeholder="Address line 2" class="user-data" id="u-add2" value=""  />
											
										</div>
									</div>	
									<div class="field-wrap two-fields-wrap">
										<div class="field-div">
											<input type="text" name="p_city" placeholder="City" class="user-data" id="u-city1" required="" value="" />
										</div>
										<div class="field-div">
											<div class="field-wrap two-fields-wrap">
												<div class="field-div">
													<label style="display: none;" class="statevalidate"></label>
													<select name="p_state" class="user-data address-state" id="u-state" placeholder="State" data-val=""></select>
												</div>
												<div class="field-div">
													<input type="text" name="p_zipcode" placeholder="Zipcode" class="user-data" id="u-zip" required="" value="" />
												</div>
											</div>
										</div>
									</div>
									<div class="field-wrap two-fields-wrap">
										<div class="field-div">
											<label>*Primary Phone Number </label>
											<input type="number" name="p_prm_no" placeholder="1(555) 123-1234" class="user-data phone-number" id="p-phone"  required="" value="" />
											<input type="hidden" name="p_prm_no_code" placeholder="1(555) 123-1234" class="user-data" value="<?php echo $primary_home_number; ?>" />
										</div>
										<div class="field-div">
											<label>Secondary Phone Number </label>
											<input type="number" name="p_sec_no" placeholder="1(555) 123-1234" class="user-data phone-number" id="ps-phone" value="" />
											<input type="hidden" name="p_sec_no_code" placeholder="1(555) 123-1234" class="user-data" value="" />
										</div>
									</div>
								</div>
								<div class="step-accordion">
									<h4 class="step-acc-head" id="sec-form"><i class="fa fa-plus"></i> Enter Secondary Contact Information (Optional)</h4>
									<div class="step-acc-content">
										<div class="contact-form" id="sec-cont-info">
											<div class="field-wrap two-fields-wrap">
												<div class="field-div">
													<label>First Name</label>
													<input type="text" name="s_fst_name" placeholder="First Name" class="user-data" id="s-name" value="<?php echo $Sfirst_name;?>" />
												</div>
												<div class="field-div">
													<label>Last Name</label>
													<input type="text" name="s_lst_name" placeholder="Last Name" class="user-data" id="s-lstname" value="<?php echo $Slast_name;?>" />
												</div>
											</div>
											<div class="field-wrap two-fields-wrap">
												<div class="field-div">
													<label>Email</label>
													<input type="email" name="s_email" placeholder="Enter Email Address" class="user-data" id="s-email" value="<?php echo $Semail;?>" />
												</div>
												<div class="field-div">
													<label>Select Your Country</label>
													<select name="s_country" class="user-data address-country not-require" id="s-county">
														<option value="">Select</option>
														<?php foreach ($countries as $key=>$value) {?>
														<option value="<?php echo $key; ?>" <?php if(!empty($Sprimary_country) && $Sprimary_country==$key){ echo 'selected="selected"';}?>>
															<?php echo $value;?>
														</option>
														<?php } ?>
													</select>
												</div>
											</div>
											<div class="field-wrap two-fields-wrap">
												<div class="field-div">
													<label>Address</label>
													<input type="text" name="s_add1" placeholder="Address line 1" class="user-data" id="sadd1" value="<?php echo $Sprimary_address_line1;?>" />
												</div>
												<div class="field-div">
													<label></label>
													<input type="text" name="s_add2" placeholder="Address line 2" class="user-data" id="s-add2" value="<?php echo $Sprimary_address_line2;?>" />
												</div>
											</div>
											<div class="field-wrap two-fields-wrap">
												<div class="field-div">
													<input type="text" name="s_city" placeholder="City" class="user-data" id="s_city1" value="<?php echo $Sprimary_city;?>" />
												</div>
												<div class="field-div">
													<div class="field-wrap two-fields-wrap">
														<div class="field-div state-div">
															<label class="statevalidate" style="display: none"></label>
															<select name="s_state" class="user-data address-state not-require" id="s-state" placeholder="State" data-val=""></select>
														</div>
														<div class="field-div">
															<input type="text" name="s_zipcode" placeholder="Zipcode" class="user-data" id="s-zip" value="<?php echo $Sprimary_postcode;?>" />
														</div>
													</div>
												</div>
											</div>
											<div class="field-wrap two-fields-wrap">
												<div class="field-div">
													<label>Primary Phone Number</label>
													<input type="number" name="s_prm_no" placeholder="1(555) 123-1234" class="user-data phone-number" id="sp-phone" value="<?php echo $Sprimary_home_number;?>" />
													<input type="hidden" name="s_prm_no_code" placeholder="1(555) 123-1234" class="user-data" value="<?php echo $secondary_phone_country_code; ?>" />
												</div>
												<div class="field-div">
													<label>Secondary Phone Number</label>
													<input type="number" name="s_sec_no" placeholder="1(555) 123-1234" class="user-data phone-number" id="ss-phone" value="<?php echo $Sprimary_cell_number;?>" />
													<input type="hidden" name="s_sec_no_code" placeholder="1(555) 123-1234" class="user-data" value="<?php echo $secondary_cell_country_code; ?>" />
												</div>
											</div>
										</div>
									</div>
								</div>	
							<?php } ?>
							<div class="step-accordion">
								<h4 class="step-acc-head" id="vt-form"><i class="fa fa-plus"></i> Enter Veterinarian Contact Information (Optional)</h4>
								<div class="step-acc-content">
									<div class="contact-form" id="vetcont-info">
										<div class="field-wrap two-fields-wrap">
											<div class="field-div">
												<label>First Name </label>
												<input type="text" name="vaterinarian_first_name" placeholder="First Name" class="text-data" id="v-first" />
											</div>
											<div class="field-div">
												<label>Last Name </label>
												<input type="text" name="vaterinarian_last_name" placeholder="Last Name" class="text-data" id="v-last" />
											</div>
										</div>
										<div class="field-wrap two-fields-wrap">
											<div class="field-div">
												<label>Email </label>
												<input type="email" name="vaterinarian_email" placeholder="Enter Email Address" class="text-data" id="v-email" />
											</div>
											<div class="field-div">
												<label>Select Your Country </label>
												<select name="vaterinarian_country" class="user-data address-country not-require" id="v-cuntry" >
													<option value="">Select</option>
													<?php foreach ($countries as $key => $value) {?>
													<option value="<?php echo $key; ?>"><?php echo $value;?></option>
													<?php } ?>
												</select>
											</div>
										</div>
										<div class="field-wrap two-fields-wrap">
											<div class="field-div">
												<label>Address </label>
												<input type="text" name="vaterinarian_address_line_1" placeholder="Address line 1" class="text-data" id="v-add1" />
											</div>	
											<div class="field-div">
												<label></label>
												<input type="text" name="vaterinarian_address_line_2" placeholder="Address line 2" class="text-data" id="v-add2" />
											</div>
										</div>	
										<div class="field-wrap two-fields-wrap">
											<div class="field-div">
												<input type="text" name="vaterinarian_city" placeholder="City" class="text-data" id="v-city1" />
											</div>
											<div class="field-div">
												<div class="field-wrap two-fields-wrap">
													<div class="field-div">
														<label style="display: none;" class="statevalidate" ></label>
													 	<input type="text" name="vaterinarian_state" class="text-data address-state not-require" id="v-state" placeholder="State" data-val="">
													</div>
													<div class="field-div">
													 	<input type="text" name="vaterinarian_zip_code" placeholder="Zipcode" class="text-data" id="v-zip" />
												    </div>
											    </div>
											</div>
										</div>
										<div class="field-wrap two-fields-wrap">
											<div class="field-div">
												<label>Primary Phone Number </label>
												<input type="text" name="vaterinarian_primary_phone_number" placeholder="1(555) 123-1234" class="text-data phone-number" id="v-prim"/>
												<input type="hidden" name="vaterinarian_primary_phone_number_code" placeholder="1(555) 123-1234" class="text-data"/>
											</div>
											<div class="field-div">
												<label>Secondary Phone Number </label>
												<input type="text" name="vaterinarian_secondary_phone_number" placeholder="1(555) 123-1234" class="text-data phone-number" id="v-sec" />
												<input type="hidden" name="vaterinarian_secondary_phone_number_code" placeholder="1(555) 123-1234" class="text-data" />
											</div>							
										</div>
										<!-- <div class="field-wrap two-fields-wrap">
											<div class="field-div">
												<input type="submit" name="submit" value="Sumbit Pet Veterinarian Info">
											</div>
										</div>	 -->
									</div>
								</div>
							</div>
							<div class="step-btns">
								<button class="btn btn-default btn-prev" type="button" aria-controls="step-1"><i class="fa fa-caret-left"></i> Back</button>
								<button class="btn btn-default btn-next" type="button" aria-controls="step-3">Next <i class="fa fa-caret-right"></i></button>
							</div>
						</fieldset>
						<fieldset aria-label="Step Three" tabindex="-1" id="step-3" class="step-form-box">
							<div class="pp-tabs-content steps-pp-tabs-content" style="display: block;">
								<div class="pp-icon-wrap">
									<!-- <div class="pp-icon"></div> -->
									<h2>Pet Protection Plans</h2>
								</div>
								<div class="pp-table-wrap">
									<table class="pp-table">
										<thead>
										    <tr class="pt-remove">
										      <th>
										        <p>Hover " <i class="fa fa-plus"></i> " to show more information about each benefit.</p>
										      </th>
										      <th class="pp-silver">
										        <h2>SILVER</h2>
										      </th>
										      <th class="pp-gold">
										        <h2>GOLD</h2>
										      </th>
										      <th class="pp-platinum">
										        <h2>PLATINUM</h2>
										      </th>
										    </tr>
										  </thead>
										<tfoot id="myDIV">
											<tr>
												<th class="pp-upgrade">
													<div>Upgrade to lifetime plan and save up to 80%</div>
												</th>
												<th class="pp-silver">
													<h2>SILVER</h2>
													<div class="pp-membership-plan">
														<div class="pp-plan-name">Id Tag 1 Year Plan</div>
														<div class="pp-plan-price">
															<h3>$6.95</h3>
															<span>per year</span>
														</div>
														<div class="pp-adc-btn">
															<a href="javascript:void(0)" id="Stsil1" filed="productid" proid="6858" class="site-btn subPlans" price="6.95" PlanNm="Id Tag 1 Year Plan">Add to Cart <i class="fa fa-shopping-cart"></i></a>
														</div>
													</div>
													<div class="pp-membership-plan">
														<div class="pp-plan-name">Id Tag 5 Year Plan</div>
														<div class="pp-plan-price">
															<h3>$24.95</h3>
														</div>
														<div class="pp-adc-btn">
															<a href="javascript:void(0)" id="Stsil2" filed="productid" proid="6856" class="site-btn subPlans" price="24.95" PlanNm="Id Tag 5 Year Plan">Add to Cart <i class="fa fa-shopping-cart"></i></a>
														</div>
													</div>
													<div class="pp-membership-plan">
														<div class="pp-plan-name">Id Tag Lifetime Plan</div>
														<div class="pp-plan-price">
															<h3>$39.95</h3>
														</div>
														<div class="pp-adc-btn">
															<a href="javascript:void(0)" id="Stsil3" filed="productid" proid="6857" class="site-btn subPlans" PlanNm="Id Tag Lifetime Year Plan" price="39.95">Add to Cart <i class="fa fa-shopping-cart"></i></a>
														</div>
													</div>
												</th>
												<th class="pp-gold">
													<h2>GOLD</h2>
													<div class="pp-membership-plan">
														<div class="pp-plan-name">Id Tag 1 Year Plan</div>
														<div class="pp-plan-price">
															<h3>$14.95</h3>
															<span>per year</span>
														</div>
														<div class="pp-adc-btn">
															<a href="javascript:void(0)" id="Sgol1" filed="productid" proid="6852" class="site-btn subPlans" price="14.95" PlanNm="Id Tag 1 Year Plan">Add to Cart <i class="fa fa-shopping-cart"></i></a>
														</div>
													</div>
													<div class="pp-membership-plan">
														<div class="pp-plan-name">Id Tag 5 Year Plan</div>
														<div class="pp-plan-price">
															<h3>$49.95</h3>
														</div>
														<div class="pp-adc-btn">
															<a href="javascript:void(0)" id="Sgol2" filed="productid" proid="6850" class="site-btn subPlans" price="49.95" PlanNm="Id Tag 5 Year Plan">Add to Cart <i class="fa fa-shopping-cart"></i></a>
														</div>
													</div>
													<div class="pp-membership-plan">
														<div class="pp-plan-name">Id Tag Lifetime Plan</div>
														<div class="pp-plan-price">
															<h3>$69.95</h3>
														</div>
														<div class="pp-adc-btn">
															<a href="javascript:void(0)" id="Sgol3" filed="productid" proid="6851" class="site-btn subPlans" price="69.95" PlanNm="Id Tag Lifetime Plan">Add to Cart <i class="fa fa-shopping-cart"></i></a>
														</div>
													</div>
												</th>
												<th class="pp-platinum">
													<h2>PLATINUM</h2>
													<div class="pp-membership-plan">
														<div class="pp-plan-name">Id Tag 1 Year Plan</div>
														<div class="pp-plan-price">
															<h3>$24.95</h3>
															<span>per year</span>
														</div>
														<div class="pp-adc-btn">
															<a href="javascript:void(0)" id="spla1" filed="productid" proid="6855" class="site-btn subPlans" price="24.95" PlanNm="Id Tag 1 Year Plan">Add to Cart <i class="fa fa-shopping-cart"></i></a>
														</div>
													</div>
													<div class="pp-membership-plan">
														<div class="pp-plan-name">Id Tag 5 Year Plan</div>
														<div class="pp-plan-price">
															<h3>$79.95</h3>
														</div>
														<div class="pp-adc-btn">
															<a href="javascript:void(0)" id="spla2" filed="productid" proid="6853" class="site-btn subPlans" price="79.95" PlanNm="Id Tag 5 Year Plan">Add to Cart <i class="fa fa-shopping-cart"></i></a>
														</div>
													</div>
													<div class="pp-membership-plan">
														<div class="pp-plan-name">Id Tag Lifetime Plan</div>
														<div class="pp-plan-price">
															<h3>$129.95</h3>
														</div>
														<div class="pp-adc-btn">
															<a href="javascript:void(0)" id="spla3" filed="productid" proid="6854" class="site-btn subPlans" plan="Id Tag Lifetime Plan" price="129.95" PlanNm="Id Tag Lifetime Plan">Add to Cart <i class="fa fa-shopping-cart"></i></a>
														</div>
													</div>
												</th>
											</tr>
										</tfoot>
										<tbody>
									        <tr>
									          <td class="pp-benefits pp-benefits1">
									            <span class="pp-benefit-icon"></span>
									            <i class="fa fa-plus pet-pro-sign"></i>
									            <div class="pet-pro-plus-content">
									              Lost pet E-Alert Services (change name of benefit)- Lost pet E-Alerts can be sent in any location in all of North America. It will be sent to all the animal shelter, rescue group and veterinarians, breeders, and animal search activists that have requested to be on our lost pet alert lists for their area.
									            </div>
									            Instant Broadcast Alert
									          </td>
									          <td>
									            <i class="fa fa-check"></i>
									          </td>
									          <td>
									            <i class="fa fa-check"></i>
									          </td>
									          <td>
									            <i class="fa fa-check"></i>
									          </td>
									        </tr>
									        <tr>
									          <td class="pp-benefits pp-benefits2">
									            <span class="pp-benefit-icon"></span>
									            <!-- <i class="fa fa-plus pet-pro-sign"></i>
									            <div class="pet-pro-plus-content"></div> -->
									            24/7 Toll Free Live Emergency Support
									          </td>
									          <td>
									            <i class="fa fa-check"></i>
									          </td>
									          <td>
									            <i class="fa fa-check"></i>
									          </td>
									          <td>
									            <i class="fa fa-check"></i>
									          </td>
									        </tr>
									        <tr>
									          <td class="pp-benefits pp-benefits3">
									            <span class="pp-benefit-icon"></span>
									            <!-- <i class="fa fa-plus pet-pro-sign"></i>
									            <div class="pet-pro-plus-content"></div> -->
									            Metal Collar ID Tag
									          </td>
									          <td>
									            <i class="fa fa-check"></i>
									          </td>
									          <td>
									            <i class="fa fa-check"></i>
									          </td>
									          <td>
									            <i class="fa fa-check"></i>
									          </td>
									        </tr>
									        <tr>
									          <td class="pp-benefits pp-benefits4">
									            <span class="pp-benefit-icon"></span>
									            <!-- <i class="fa fa-plus pet-pro-sign"></i>
									            <div class="pet-pro-plus-content"></div> -->
									            All SmartTags Are Searchable on Google
									          </td>
									          <td>
									            <i class="fa fa-check"></i>
									          </td>
									          <td>
									            <i class="fa fa-check"></i>
									          </td>
									          <td>
									            <i class="fa fa-check"></i>
									          </td>
									        </tr>
									        <tr>
									          <td class="pp-benefits pp-benefits5">
									            <span class="pp-benefit-icon"></span>
									            <!-- <i class="fa fa-plus pet-pro-sign"></i>
									            <div class="pet-pro-plus-content"></div> -->
									            Free Pet and owner Profile updates anytime.
									          </td>
									          <td>
									            <i class="fa fa-check"></i>
									          </td>
									          <td>
									            <i class="fa fa-check"></i>
									          </td>
									          <td>
									            <i class="fa fa-check"></i>
									          </td>
									        </tr>
									        <tr>
									          <td class="pp-benefits pp-benefits6">
									            <span class="pp-benefit-icon"></span>
									            <i class="fa fa-plus pet-pro-sign"></i>
									            <div class="pet-pro-plus-content">
									              Your pet protection plan includes 30 days of pet insurance provided by our pet insurance Partner. You must abide by all requirements to activate and must call to them to initiate pet insurance coverage. No credit card required, its fast and easy. Activate it today, please check your emails for details!
									            </div>
									            Free Pet Medical Insurance (30 Days)
									          </td>
									          <td>
									            <i class="fa fa-check"></i>
									          </td>
									          <td>
									            <i class="fa fa-check"></i>
									          </td>
									          <td>
									            <i class="fa fa-check"></i>
									          </td>
									        </tr>
									        <tr>
									          <td class="pp-benefits pp-benefits7">
									            <span class="pp-benefit-icon"></span>
									            <i class="fa fa-plus pet-pro-sign"></i>
									            <div class="pet-pro-plus-content">
									              Please go to IDtag.com and log into your SmartTag account to print lost pet posters (please have a photo of your pet downloaded in your account)
									            </div>
									            Instant Lost Pet Posters
									          </td>
									          <td>
									            <i class="fa fa-check"></i>
									          </td>
									          <td>
									            <i class="fa fa-check"></i>
									          </td>
									          <td>
									            <i class="fa fa-check"></i>
									          </td>
									        </tr>
									        <tr>
									          <td class="pp-benefits pp-benefits8">
									            <span class="pp-benefit-icon"></span>
									            <i class="fa fa-plus pet-pro-sign"></i>
									            <div class="pet-pro-plus-content">
									              SmartTag is partnered with AAHA and part of the national USA microchip database. Any SmartTag microchip or other brand microchip that is registered with SmartTag is searched for in AAHA Microchip Lookup Tool will show our contact information to get the lost or found pet home and reunited with their pet parents as quickly as possible.
									            </div>
									            Registration with national AAHA
									          </td>
									          <td>
									            <i class="fa fa-check"></i>
									          </td>
									          <td>
									            <i class="fa fa-check"></i>
									          </td>
									          <td>
									            <i class="fa fa-check"></i>
									          </td>
									        </tr>
									        <tr>
									          <td class="pp-benefits pp-benefits9">
									            <span class="pp-benefit-icon"></span>
									            <i class="fa fa-plus pet-pro-sign"></i>
									            <div class="pet-pro-plus-content">
									              If your pet is ever lost, SmartTag lost pet recovery agents will call all of the Animal Shelter and Rescue Groups in a 25-50 mile radius (depending on region) of your pets last know location to see if your pet is at any of the locations and to make them aware of your lost pet. This added service is only for Platinum pet protection plan holders. If you don’t have it, Sign up today!
									            </div>
									            Live Emergency Response Team
									          </td>
									          <td></td>
									          <td>
									            <i class="fa fa-check"></i>
									          </td>
									          <td>
									            <i class="fa fa-check"></i>
									          </td>
									        </tr>
									        <tr>
									          <td class="pp-benefits pp-benefits10">
									            <span class="pp-benefit-icon"></span>
									            <i class="fa fa-plus pet-pro-sign"></i>
									            <div class="pet-pro-plus-content">
									              If your pet has ever ingested anytime it should not, you have unlimited access to the best Poison Hotline for free! Normally each call to the Pet Poison Helpline $59 per call! This a very valuable benefit we provide all Platinum pet protection plan holders. Sign up today, this makes it all worth it alone!
									            </div>
									            Pet Poison Helpline
									            <br>
									            <span>($69 value)</span>
									          </td>
									          <td></td>
									          <td></td>
									          <td>
									            <i class="fa fa-check"></i>
									          </td>
									        </tr>
									        <tr>
									          <td class="pp-benefits pp-benefits11">
									            <span class="pp-benefit-icon"></span>
									            <i class="fa fa-plus pet-pro-sign"></i>
									            <div class="pet-pro-plus-content">
									              Free replacement ID tags are for Platinum pet protection plan holders only. Sign up today!
									            </div>
									            Free Engraving on Replacement Tags
									          </td>
									          <td></td>
									          <td></td>
									          <td>
									            <i class="fa fa-check"></i>
									          </td>
									        </tr>
									        <tr>
									          <td class="pp-benefits pp-benefits12">
									            <span class="pp-benefit-icon"></span>
									            <i class="fa fa-plus pet-pro-sign"></i>
									            <div class="pet-pro-plus-content">
									              SmartTag will pay a lost pet reward to the pet finder, a maximum of $100, to any finder that gets you your pet home within our 6-hour guarantee (from the time the pet is reported lost). Finder must request the reward and fill out appropriate required SmartTag paperwork to receive the reward.
									            </div>
									            Lost Pet Reward $100
									          </td>
									          <td></td>
									          <td></td>
									          <td>
									            <i class="fa fa-check"></i>
									          </td>
									        </tr>
									        <tr>
									          <td class="pp-benefits pp-benefits13">
									            <span class="pp-benefit-icon"></span>
									            <i class="fa fa-plus pet-pro-sign"></i>
									            <div class="pet-pro-plus-content">
									              This is an amazing new SmartTag feature; you can set alerts for anything related to your pet and get them texted and emailed to you! Ever have to take your dog to the groomer or vet, book a pet sitter, or need to be reminded monthly to give your pet their heart protection or flea and tick medications? Well this new service allows you to set up email and/or text alerts to be sent to you to remind you to do anything for your pet. This really great service is provided to all Platinum pet protection plan holders. Sign up today!
									            </div>
									            Pet Reminder Alerts
									            <br>
									            <span>(Flea and tick medication, heart worm, vaccinations etc...)</span>
									          </td>
									          <td></td>
									          <td></td>
									          <td>
									            <i class="fa fa-check"></i>
									          </td>
									        </tr>
									      </tbody>
									</table>
								</div>
							</div>
							<div class="step-btns">
								<button class="btn btn-default btn-prev" type="button" aria-controls="step-2"><i class="fa fa-caret-left"></i> Back</button>
								<button class="btn btn-default btn-next ste4" type="button" aria-controls="step-4">Skip Protection Plan <i class="fa fa-caret-right"></i></button>
							</div>
						</fieldset>
						<fieldset aria-label="Step Four" tabindex="-1" id="step-4" class="step-form-box">
							<div class="blue-border-box">
								<div class="pp-icon-wrap">
									<div class="pp-icon pp-icon-plus"></div>
									<h3>Pet Insurance</h3>
								</div>
								<div class="blue-box-content">
									<h3>30-Days of PetFirst Pet Insurance
									<br>
									Included with your SmartTag Membership</h3>
									<p>Veterinary costs continue to rise, and at SmartTag we want to provide you with an introductory pet insurance plan to help reimburse you for your pet’s veterinary expenses. We are the only ID Tag company to include pet insurance with our membership.</p>
									<div class="row">
										<div class="col-sm-4">
											<h4>Plan Details</h4>
											<p>Aggregate Benefit Limit: $1,000
												<br>
												Per-Incident Limit: $500
												<br>
												Pet-Incident Deductible: $50
												<br>
												Reimbursement: 90%
											</p>
										</div>
										<div class="col-sm-8">
											<div class="row">
												<div class="col-sm-12">
													<h4>What is Covered?</h4>
												</div>
												<div class="col-sm-4">
													<p>• Accidents
														<br>
														• Illnesses
														<br>
														• Exam Fees
														<br>
														• X-rays
													</p>
												</div>
												<div class="col-sm-4">
													<p>• Medications
														<br>
														• Ultrasounds
														<br>
														• Hospital Stays
														<br>
														• Surgeries
													</p>
												</div>
												<div class="col-sm-4">
													<p>• Alternative Therapies
														<br>
														• Diagnostic Tests
														<br>
														• Holistic Care
														<br>
														• Much more!
													</p>
												</div>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-sm-12">
											<h4>What Is Not Covered?</h4>
										</div>
										<div class="col-sm-3">
											<p>
												• Special Diets
												<br>
												• Routine Wellness
												<br>
												• Spay/Neuter
											</p>
										</div>
										<div class="col-sm-3">
											<p>
												• Pre-Existing Conditions
												<br>
												• Preventative Conditions
												<br>
												• Chronic Conditions
											</p>
										</div>
										<div class="col-sm-3">
											<p>
												• Hereditary Conditions
												<br>
												• Congenital Conditions
												<br>
												• Behavior Training
											</p>
										</div>
										<div class="col-sm-3">
											<p>
												• Organ Transplants
												<br>
												• Elective Procedures
											</p>
										</div>
									</div>
								</div>
								<div class="step-check-wrap">
									<div class="step-check">
										<input type="radio" name="health_insurance" id="heth_id" value="<?php echo $heth_proid;?>" class="" />
										<label>I Accept my free 30 days of pet health insurance</label>
									</div>
									<div class="step-check">
										<input type="radio" name="health_insurance" id="heth_id1"/>
										<label>I don't want my free 30 days of pet health insurance</label>
									</div>
								</div>
							</div>
							<div class="blue-border-box">
								<div class="pp-icon-wrap">
									<div class="pp-icon pp-icon-foot"></div>
									<h3>Pet Protection Arrangement </h3>
								</div>
								<div class="blue-box-content">
									<h3>What's the difference between a SmartTag PetCare Protection Arrangement and a Pet Trust?</h3>
									<p>A Pet Protection Arrangement, like a Pet Trust is a legal document used to ensure that your pets are fully cared for and protected in case you should become ill, not be able to keep or take care of vour pets, or pass away. The difference is that a Pet Trust is a more formal and costly document that is normally prepared by an attorney who specializes in estate planning and has experience in pet trusts. Pet trusts are normally used when a substantial amount of money is being left to care for the pets or they are very high profile. A Pet Protection Arrangement is all the protection most pet owners need to ensure proper care and safety for their pets.</p>
									<p><img src="<?php bloginfo('template_url'); ?>-child/images/red-table.jpg" alt="image" /></p><?php $product = wc_get_product($protectionArrangement); ?><p><strong>Price: $ <?= $product->get_price(); ?></strong></p>
								</div>
								<div class="step-check-wrap">
									<div class="step-check">
										<input  class="" type="radio" name="protectionArrangement" value="<?= $protectionArrangement;?>" id="PetArg" />
										<label>I would like to add a Pet Protection Arrangement</label>
									</div>
									<div class="step-check">
										<input type="radio" name="protectionArrangement" id="PetArg1" />
										<label>I would not like to add a Pet Protection Arrangement</label>
									</div>
								</div>
							</div>
							<div class="step-btns">
								<button class="btn btn-default btn-prev" type="button" aria-controls="step-3"><i class="fa fa-caret-left"></i> Back</button>
								<button class="btn btn-default btn-next skip2" type="button" aria-controls="step-5">Skip All Offers <i class="fa fa-caret-right"></i></button>
							</div>							
						</fieldset>
						 <fieldset aria-label="Step Five" tabindex="-1" id="step-5" class="step-form-box">
							<p>
								<strong class="pp-icon-wrap">Please review that your Information is correct.</strong>
								<br>
								You can edit this Information if you need to.
							</p>
							<div class="acc-blue-box">
								<div class="acc-blue-head">
									Pet Protection Plan
									<div class="acc-edit plan-edit">
										<i class="fa fa-edit"></i> EDIT
									</div>
								</div>
								<div class="acc-blue-content">
									<div class="row">
										<div class="col-sm-12">
											<span id="pln"><strong>None</strong></span>
										</div>
									</div>
								</div>
							</div>
							<div class="acc-blue-box">
								<div class="acc-blue-head">
									Pet Protection Arrangement
									<div class="acc-edit engrave-edit">
										<i class="fa fa-edit"></i> EDIT
									</div>
								</div>
								<div class="acc-blue-content">
									<div class="row">
										<div class="col-sm-12">
											<strong id="Arrangement">None</strong>
										</div>
									</div>
								</div>
							</div>
							<div class="acc-blue-box">
								<div class="acc-blue-head">
									Pet Health Insurance
									<div class="acc-edit engrave-edit">
										<i class="fa fa-edit"></i> EDIT
									</div>
								</div>
								<div class="acc-blue-content">
									<div class="row">
										<div class="col-sm-12">
											<strong id="Insurance">Free Month</strong>
										</div>
									</div>
								</div>
							</div>
							<div class="acc-blue-box">
								<div class="acc-blue-head">
									Registered Pet
									<div class="acc-edit petpro-edit">
										<i class="fa fa-edit"></i> EDIT
									</div>
								</div>
								<div class="acc-blue-content">
									<div class="row">
										<div class="col-sm-6">
											<strong>SmartTag ID Number:</strong> <span id="smarttag_id_number"></span>
											<br>
											<strong>Pet Name:</strong> <span id="pet_name"></span>
											<br>
											<strong>Pet Type:</strong> <span id="pet_type"></span>
											<br>
											<strong>Primary Breed:</strong> <span id="primary_breed"></span>
											<br>
											<strong>Secondary Breed:</strong> <span id="secondary_breed"></span>
											<br>
											<strong>Primary Color:</strong> <span id="primary_color"></span>
											<br>
											<strong>Secondary Color:</strong> <span id="secondary_color"></span>
											<br>
											<strong>Gender:</strong> <span id="gender"></span>
											<br>
											<strong>Size:</strong> <span id="size"></span>
											<br>
											<strong>Pet Date of Birth:</strong> <span id="pet_date_of_birth"></span>
										</div>
										<div class="col-sm-6">
											<p><strong>Pet Image:</strong></p>
											 <img id="blah" src="<?php echo get_site_url(); ?>/wp-content/uploads/2019/02/pet-image.jpg" alt="your image" />
										</div>
									</div>
								</div>
							</div>
							
							<div class="acc-blue-box">
								<div class="acc-blue-head">Contact Information
									<div class="acc-edit usr-edit">	<i class="fa fa-edit"></i> EDIT</div>
								</div>
								<div class="acc-blue-content">
									<div class="row">
										<?php if(is_user_logged_in()){ ?>
										<div class="col-sm-6 mar-bot">
											<p><strong class="color-light-blue">Primary Contact:</strong>
											</p>	<strong>Email:</strong><span id="pemail"><?= $email;?></span>
											<br>	<strong>First Name:</strong><span id="pfnam"><?= $first_name;?></span>
											<br>	<strong>Last Name:</strong><span id="plnam"><?= $last_name;?></span><br>
											<strong>Address1:</strong><span id="uadd1"><?= $primary_address_line1 ?></span><br> 
											<strong>Address2:</strong><span id="uadd2"><?= $primary_address_line2; ?></span><br>
											<strong>City:</strong><span id="ucity1"><?= $primary_city;?></span><br>
											<strong>Zip Code:</strong><span id="uzip"><?= $primary_postcode;?></span><br>
											<strong>State:</strong><span id="ustte"><?= stateName($primary_state);?></span><br>
											<strong>Country:</strong><span id="ucounty"><?= getCountryName($primary_country); ?></span><br>
											<strong>Primary Phone Number:</strong>

											<span id="p_prm_no_code"><?= 
												get_phone_by_contry_code($primary_home_number_code);?></span>

											  <span id="pnum"><?= $primary_home_number;?></span><br>
											
											<strong>Secondary Phone Number:</strong><span id="p_sec_no_code"><?= 
												get_phone_by_contry_code($primary_cell_number_code);?></span>
												<span id="snum">
												<?= $primary_cell_number;?></span>
										</div>
										<div class="col-sm-6">
											<p><strong class="color-light-blue">Secondary Contact:</strong>
											</p><strong>Email:</strong>  <span id="semail"><?= $Semail ?></span><br>
											<strong>First Name:</strong>  <span id="sfirst"><?= $Sfirst_name; ?></span><br>
											<strong>Last Name:</strong><span id="slst"><?= $Slast_name; ?></span><br>
											<strong>Address1:</strong><span id="preAdd1"><?= $Sprimary_address_line1; ?></span><br>
											<strong>Address2:</strong><span id="preAdd2"><?= $Sprimary_address_line2; ?></span><br>
											<strong>City:</strong><span id="scity"><?= $Sprimary_city ?></span><br>
											<strong>Zip Code:</strong><span id="szip"><?= $Sprimary_postcode ?></span><br>
											<strong>State:</strong><span id="sttate"><?= stateName($Sprimary_state); ?></span><br>
											<strong>Country:</strong><span id="scounty"><?= getCountryName($Sprimary_country); ?></span><br>
											<strong>Primary Phone Number:</strong>  
												<span id="s_prm_no_code"><?= 
												get_phone_by_contry_code($secondary_cell_country_code);?>
												</span>
												<span id="sprino">
												<?= $Sprimary_home_number; ?></span><br>

											<strong>Secondary Phone Number:</strong>  
											<span id="s_sec_no_code"><?= 
												get_phone_by_contry_code($secondary_phone_country_code);?>
													
											</span>
											<span id="sseno">
												<?= $Sprimary_cell_number; ?>
											</span> 
										</div>
										<?php }else { ?>
										<div class="col-sm-6 mar-bot">
											<p><strong class="color-light-blue">Primary Contact:</strong>
											</p>	<strong>Email:</strong><span id="pemail"></span>
											<br>	<strong>First Name:</strong><span id="pfnam"></span>
											<br>	<strong>Last Name:</strong><span id="plnam"></span><br>
											<strong>Address1:</strong><span id="uadd1"></span><br> 
											<strong>Address2:</strong><span id="uadd2"></span><br>
											<strong>City:</strong><span id="ucity1"></span><br>
											<strong>Zip Code:</strong><span id="uzip"></span><br>
											<strong>State:</strong><span id="ustte"></span><br>
											<strong>Country:</strong><span id="ucounty"></span><br>
											<strong>Primary Phone Number:</strong>
											<span id="p_prm_no_code"></span>
											<span id="pnum"></span><br>
											<strong>Secondary Phone Number:</strong>
											<span id="p_sec_no_code"></span>
											<span id="snum"></span>
										</div>
										<div class="col-sm-6">
											<p><strong class="color-light-blue">Secondary Contact:</strong>
											</p><strong>Email:</strong>  <span id="semail"></span><br>
											<strong>First Name:</strong>  <span id="sfirst"></span><br>
											<strong>Last Name:</strong><span id="slst"></span><br>
											<strong>Address1:</strong><span id="preAdd1"></span><br>
											<strong>Address2:</strong><span id="preAdd2"></span><br>
											<strong>City:</strong><span id="scity"></span><br>
											<strong>Zip Code:</strong><span id="szip"></span><br>
											<strong>State:</strong><span id="sttate"></span><br>
											<strong>Country:</strong><span id="scounty"></span><br>
											<strong>Primary Phone Number:</strong>
											<span id="s_prm_no_code"></span>
											<span id="sprino"></span><br>
											<strong>Secondary Phone Number:</strong>
											<span id="s_sec_no_code"></span>
											<span id="sseno"></span>
										</div>
										<?php } ?>
										<div class="col-sm-6 mar-bot">
											<p><strong class="color-light-blue">Veterinarian Information:</strong></p><strong>Email:</strong><span id="vemail"></span><br>
											<strong>First Name:</strong><span id="vname"></span><br>
											<strong>Last Name:</strong><span id="vlst"></span><br>
											<!-- <strong>Address:</strong><span id="v-addrss"></span><br> -->
											<strong>Address1:</strong><span id="vadd1"></span><br> 
											<strong>Address2:</strong><span id="vadd2" ></span><br>
											<strong>City:</strong><span id="vcity"></span><br>
											<strong>Zip Code:</strong><span id="vzip"></span><br>
											<strong>State:</strong><span id="vstate"></span><br>
											<strong>Country:</strong><span id="vcounty"></span><br>
											<strong>Primary Phone Number:</strong>
											<span id="vaterinarian_primary_phone_number_code"></span>
											<span id="vprim"></span><br>
											<strong>Secondary Phone Number:</strong>
											<span id="vaterinarian_secondary_phone_number_code"></span>
											  <span id="vsec"></span>
										</div>
									</div>
								</div>
							</div>
							
							<p class="step-check-wrap">
								<div class="step-check">
									<div class="clearfix">
										<input type="checkbox" name="terms" required="" />
										<label class="checkbox-label">*I agree to the <a href="<?= site_url('/terms-conditions/');?>">terms and conditions</a></label>
										<div id="agreeValidate"></div>
									</div>
								</div>
							</p>
							<div class="step-btns">
								<button class="btn btn-default btn-prev" type="button" aria-controls="step-4"><i class="fa fa-caret-left"></i> Back</button>
								<button class="btn btn-default" type="submit">Checkout and Register Smart Tag <i class="fa fa-caret-right"></i></button>
							</div>
						</fieldset>
					</form>	
				</section>					
	    	</div>			
			<?php //nectar_pagination(); ?>
		</div><!--/row-->
	</div><!--/container-->
</div><!--/container-wrap-->
<?php get_footer(); ?>

