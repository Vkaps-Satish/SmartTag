<?php 
/*
* Template Name: Register any Brand Microchip
5f4dcc3b5aa765d61d8327deb882cf99
*/

get_header(); ?>

<div class="container-wrap">		
	<div class="container main-content">
		<div class="row">
			<div class="woo-sidebar col-sm-3">
		        <?php echo do_shortcode("[stag_sidebar id='main-sidebar']"); ?>
		    </div>
			<div class="woo-content col-sm-9" id="woo-content">
				<div class="site-tabs-wrap">
					<p id="existing_info"></p>
					<div class="tabGroup">
				        <div class="swichtab-contents">
				            <div id="singup" class="swichtab-panel" data-swichtab="target">
				                <?php if (has_post_thumbnail( $post->ID ) ): ?>
								    <?php $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'single-post-thumbnail' ); ?>
								    <div class="page-image">
								    	<img src="<?php echo $image[0]; ?>" alt="image" />
								    </div>
								<?php endif; ?>
							<div class="page-heading heading-right-link">
								<h1>Register Any Brand Microchip in Universal Registry</h1>
							</div>
							<p>Veterinarians, animals shelters, rescue groups and breeders sign up with SmartTag here:</p>
				<fieldset aria-label="Step Two" tabindex="-1" id="step-2" class="step-form-box">
					<form id="RegBrnd" method="POST">
							<div class="contact-form" id="sections">
								 <div class="section">
						        	<div class="blue-border-box">
						           <div class="field-wrap three-fields-wrap">
										<div class="field-div">
											<label>*First Name: </label>
											<input type="text" name="p_fst_name" placeholder="Enter Organization Name " class="" class="usr-data" required="" />
										</div>
										<div class="field-div">
											<label>*Last Name: </label>
											<input type="text" name="p_lst_name" placeholder="Email Address" class="usr-data" required="" />
										</div>
										<div class="field-div">
											<label>*Phone Number: </label>
											<input type="text" name="p_prm_no" placeholder="Email Address" class="usr-data" required="" />
										</div>
										</div>
									<div class="field-wrap two-fields-wrap">
										<div class="field-div">
											<label>*Email: </label>
											<input type="text" name="p_email" placeholder="First Name" class="usr-data" id="u-first" required="" />
										</div>
										<div class="field-div">
											<label>*Country: </label>
											<input type="text" name="p_country" placeholder="Last Name" class="usr-data" id="u-last" required="" />
										</div>
									</div>

									<div class="field-wrap two-fields-wrap">	
									   <div class="field-div">
										<label>*Address: </label>
										<input type="text" name="p_add1" placeholder="Address line 1" class="usr-data" id="u-add1" required="" />
										</div>
									      <div class="field-div">
											<label></label>
											<input type="text" name="p_add2" placeholder="Address line 1" class="usr-data" id="u-add1" required="" />
										</div>
								   </div>

								  <div class="field-wrap three-fields-wrap">				
								  	<div class="field-div">
										<label>*City: </label>
										<input type="text" name="p_city" placeholder="Address line 1" class="usr-data" id="u-add1" required="" />
										</div>
									 <div class="field-div">
										<label>*State: </label>
												<select name="p_state" class="usr-data" id="usrstate" required="">
													<option value="">State1</option>
													<option value="">State2</option>
													<option value="">State3</option>
												</select>
								    </div>
									  <div class="field-div">
									  	<label>*Zipcode: </label>
												<input type="text" name="p_zipcode" placeholder="Zipcode" class="usr-data" id="u-zip" />
									   </div>
									</div>
							<div class="step-accordion">
								<h4 class="step-acc-head" id="sec-form"><i class="fa fa-minus"></i> Show Extra Information: </h4>
								<h4 class="step-acc-head">Pet1 Information: </h4>
								<div class="step-acc-content" style="display: block;">
									<div class="contact-form" id="sec-cont-info">
                                     	<div class="field-wrap two-fields-wrap">
											<label>Select  Microchip Company of the Implented Microchip : </label>
												<select name="microchip_company" class="pet-data" id="usrstate" required="">
													<option value="">Select Your Microchip Brand</option>
													<option value="">brand1</option>
													<option value="">brand1</option>
												</select>
										</div>
										<div class="field-wrap two-fields-wrap">
											<div class="field-div">
												<label>*Microchip Number: </label>
												<input type="text" name="microchip_id_number" placeholder="Enter color of pet" class="pet-data" id="s-email" required="" />
											</div>
											<div class="field-div">
												<label>*Re-Enter Microchip Number: </label>
												<input type="text" name="" placeholder="Enter Country"  id="s-county" required="" />
											</div>
										</div>
										<div class="field-wrap two-fields-wrap">
											<div class="field-div">
												<label>Pet Name: </label>
												<input type="text" name="pet_name" placeholder="Address line 1" class="pet-data" id="sadd1" required="" />
										 	</div>
										 <div class="field-wrap two-fields-wrap">
											<div class="field-div">
												<div class="field-wrap two-fields-wrap">
													<div class="field-div">
														<label>Gender: </label>
														<select name="gender" class="pet-data" id="s-sate" required="" />
															<option value="">Select Gender</option>
															<option value="male">Male</option>
															<option value="female">Female</option>
															</select>
													</div>
													<div class="field-div">
														<label>Pet Type: </label>
														<select name="pet_type" class="pet-data" id="s-sate" required="" />
															<option value="">Select Pet Type</option>
															<option value="type1">Type1</option>
														</select>
													</div>
												</div>
											</div>
										</div>
									</div> 
									 <div class="field-wrap two-fields-wrap">
											<label>*Select Universal Microchip Protection Plan : </label>
												<select name="productid" class="proplan" />
													<option value="">Select Your Microchip Brand</option>
													<option value="6858">silver</option>
													<option value="plan">State3</option>
													<option value="plan">State3</option>
												</select>
										   </div>
										</div>
							      </div>
							</div>
						 </div>
					   </div>
					</div>
				   </fieldset>
				  <button class="btn btn-default" type="submit">Purchese  All</button>
				</form>	
			  </div>
	        </div>
                <p><a href="#" class='addsection'>Add Section</a></p>
		   </div>
		</div>
	</div>
</div>
</div>
</div>
<?php get_footer(); ?>
<script type="text/javascript">
	  jQuery(document).ready(function($) {
	  	alert();
	  	$('body').on('submit', '#RegBrnd', function(e) {
         	 e.preventDefault();

         	  var usfd =  new FormData();
         	   $.each($('#RegBrnd .usr-data'), function() {
                usfd.append($(this).attr('name'), $(this).val());
                 });
                usfd.append('action','new_register_user');
              	$.ajax({
                    type: 'POST',
                    url: ajaxurl,
                    data: usfd,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                       // alert(response); // Append Server Response
                    }
                   }); 

               var petfd =  new FormData();
               $.each($('#PetPro .pet-data'), function() {
                petfd.append($(this).attr('name'), $(this).val());
                 });
               petfd.append('action','Create_Pet_profile');
              	$.ajax({
                    type: 'POST',
                    url: ajaxurl,
                    data: petfd,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        alert(response); // Append Server Response
                    }
                });
          
        var plntfd =  new FormData();
     plntfd.append($('select.proplan').attr('name'),$('select.proplan option:selected').val());
             plntfd.append('action','AddSubscriptionPlan');
              	 $.ajax({
                     type: 'POST',
                     url: ajaxurl,
                     data: plntfd,
                     contentType: false,
                     processData: false,
                     success: function(response) {
                        alert(response); // Append Server Response
                     }
                 });	 	 
      });
    });
</script>
