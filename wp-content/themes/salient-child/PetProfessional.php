<?php

/*
* Template Name:  Pet Professional Signup
*/
get_header();
// $userinfo = get_user_meta(168,'primary_home_number',false);
// print_r($userinfo);die;

//for redirect page into pet professional page if pet professional is login
if ( is_user_logged_in() ){
     $current_user = wp_get_current_user();
     $roles = $current_user->roles;  
     // print_r($roles);die;
       if( !$roles == 'pet_professional' || !in_array( 'pet_professional', $roles )){
         print('<div>
        		<div class="not-found-text width-100">This page is only for Pet-Professionals..</div></div>');
         die();
          }else{
          print('<script>window.location.href="'.get_option('siteurl').'/pet-professional"</script>
          	');
          	exit();     	
          }
         
    }
 
$countries_obj = new WC_Countries();
$CountriesName = $countries_obj->__get('countries'); 

?>
<div class="container-wrap">		
	<div class="container main-content">
		<div class="row">
			<div class="woo-sidebar col-sm-3">
		        <?php //echo do_shortcode("[stag_sidebar id='pet-professional-sidebar']"); ?>
		    </div>
			<div class="woo-content col-sm-9" id="woo-content">
				<div class="site-tabs-wrap">
					<p id="existing_info"></p>
					<div class="tabGroup">
				        <ul class="swichtab-controller">
				            <li data-swichtab="controller"><a href="#singup">Sign Up</a></li>
				            <li data-swichtab="controller"><a href="#login">Log In</a></li>
				            <li data-swichtab="controller"><a href="#forgot_pass">Forgot Password?</a></li>
				        </ul>
				        <div class="swichtab-contents">
				        	<div id="singup" class="swichtab-panel" data-swichtab="target">
				                <?php if (has_post_thumbnail( $post->ID ) ): ?>
								    <?php $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'single-post-thumbnail' ); ?>
								    <div class="page-image">
								    	<img src="<?php echo $image[0]; ?>" alt="image" />
								    </div>
								<?php endif; ?>
								<div class="page-heading heading-right-link">
									<h1>Pet Professional Sign Up</h1>
									<a href="<?php echo get_site_url()?>/login-to-smarttag/">Sign Up as a Customer <i class="fa fa-caret-right"></i></a>
								</div>
								<p id="ErMes" style="display: none;color:red;"></p>
							<form id="PetPro" method="POST" name="Petform" >		
					 			<p>Veterinarians, animals shelters, rescue groups and breeders sign up with SmartTag here:</p>
								<p id="ErMes" style="display: none;color:red;"></p>
								<fieldset aria-label="Step Two" tabindex="-1" id="step-2" class="step-form-box">
									<div class="contact-form" id="cus-info">
						        <!-- <input type="hidden" name="action" value="new_register_user"> -->
						        <div class="field-wrap two-fields-wrap">
									<div class="field-div">
										<label>*Organization Name</label>
										<input type="text" name="org_name" placeholder="Enter Organization Name " class="Org-data" required="" />
									</div>
									<div class="field-div">
										<label>*Email</label>
										<input type="email" name="org_email" placeholder="Email Address" class="Org-data" required=""  />
									</div>
								</div>
								<div class="field-wrap two-fields-wrap">
									<div class="field-div">
										<label>*Password</label>
										<input type="password" name="org_password" placeholder="Enter Password" class="Org-data" required="" id="OrgId" />
									</div>
									<div class="field-div">
										<label>*Confirm Password</label>
										<input type="password" name="confirm_password" placeholder="Enter Confirm Password" class="Org-data" required=""  />
									</div>
								</div>
								<div class="field-wrap two-fields-wrap">
									<div class="field-div">
										<label>*First Name</label>
										<input type="text" name="org_fst_name" placeholder="First Name" class="Org-data" id="u-first" required="" />
									</div>
									<div class="field-div">
										<label>*Last Name</label>
										<input type="text" name="org_lst_name" placeholder="Last Name" class="Org-data" id="u-last" required="" />
									</div>
								</div>
								<div class="field-wrap two-fields-wrap">	
  									<div class="field-div">
										<label>*Select Your Type</label>
										<select name="custom_user_type" required="" class="Org-data"> 
											<option value="">Select</option>
											<option value="veterinarians">Veterinarians</option>
											<option value="animals shelters">Animals shelters</option>
											<option value="rescue groups">Rescue groups</option>
											<option value="breeders">Breeders</option>
										</select>
									</div>
								   <div class="field-div">
									<label>*Select Your Country</label>
									<select name="org_country" class="Org-data address-country" required="" >
										<option value="">Select</option>
										<?php 
										foreach ($CountriesName as $key => $value) {?>
											<option value="<?php echo $key; ?>"><?php echo $value;?></option>
											<?php } ?>
										</select>
									</div>
								</div>
								<div class="field-wrap two-fields-wrap">					
									<div class="field-div">
										<label>*Address</label>
										<input type="text" name="org_add1" placeholder="Address line 1" class="Org-data" id="u-add1" required="" />
									</div>
									<div class="field-div">
										<label></label>
										<input type="text" name="org_add2" placeholder="Address line 2" class="Org-data" id="u-add2"/>
									</div>
								</div>
								<div class="field-wrap two-fields-wrap">					
									<div class="field-div">
										<input type="text" name="org_city" placeholder="City" class="Org-data" id="u-city1" required="" />
									</div>
									<div class="field-div">
										<div class="field-wrap two-fields-wrap">
											<div class="field-div">
												<label style="display: none;" class="statevalidate"></label>
												<input type="text" name="org_state" class="Org-data address-state" id="usrstate" placeholder="State"  data-val="" required="">
											</div>
											<div class="field-div">
												<input type="text" name="org_zipcode" placeholder="Zipcode" class="Org-data" id="u-zip" required="" />
											</div>
										</div>
									</div>
								</div>	
								<div class="field-wrap two-fields-wrap">
									<div class="field-div">
										<label>*Primary Phone Number</label>
										<input type="text" name="org_prm_no" placeholder="1(555) 123-1234" class="Org-data phone-number" id="urp-phone" required="" />
										<input type="text" name="org_prm_no_code" placeholder="1(555) 123-1234" class="Org-data" id="urp-phone-code" required="" style="display: none;" value="1" />
									</div>
									<div class="field-div">
										<label>Secondary Phone Number(Optional) </label>
										<input type="text" name="org_sec_no" placeholder="1(555) 123-1234" class="Org-data phone-number" id="urps-phone" />
										<input type="text" name="org_sec_no_code" placeholder="1(555) 123-1234" class="Org-data" id="urps-phone-code" style="display: none;" value="1" />
									</div>
								</div>
								<div class="field-wrap two-fields-wrap">
									<div class="field-div">
										<label>*Security Question1</label>
										<select name="org_Squs1" class="Org-data mySelect mySelect-1" id="sqrtyQus1" required=""> 
									            <option value="">Select a Question..</option>
												<option value="Question1">Question1</option>
												<option value="Question2">Question2</option>
												<option value="Question3">Question3</option>
												<option value="Question4">Question4</option>
										</select>
									</div>
									<div class="field-div">
										<label>*Security Answer1</label>
										<input type="text" name="org_SqAns1" placeholder="Enter Your Answer" class="Org-data" id="sqrtyAns1" required="" />
									</div>
								</div>

								<div class="field-wrap two-fields-wrap">
									<div class="field-div">
										<label>*Security Question2</label>
										<select name="org_Squs2" class="Org-data mySelect mySelect-2" id="sqrtyQus2" required="">
											<option value="">Select a Question..</option>
											<option value="Question1">Question1</option>
											<option value="Question2">Question2</option>
											<option value="Question3">Question3</option>
											<option value="Question4">Question4</option>
										</select>
									</div>
									<div class="field-div">
										<label>*Security Answer2</label>
										<input type="text" name="org_SqAns2" placeholder="Enter Your Answer" class="Org-data" id="sqrtyAns2" required="" />
									</div>
								</div>
							    <div class="field-wrap two-fields-wrap checkbox-wrap">
									<div class="field-div">
										<div class="clearfix">
											<label class="checkbox-label">Sign up for Email Promotion!</label>
											<input type="checkbox" class="Org-data" name="signup" />
										</div>
										<div class="clearfix">
												<input type="checkbox" name="terms" required="" />
												<label class="checkbox-label">I agree to the <a href="<?= site_url('/terms-conditions/');?>">terms and conditions</a></label>
												<div id="agreeValidate"></div>
												
											</div>
								    </div>
								</div>
									 <div class="field-wrap two-fields-wrap">
									    <div class="field-div">
											<label>*Please verify that you are human</label>
											<div id="recaptcha1" class="g-recaptcha"  data-sitekey="6Ldrs0sUAAAAAE4ux2ivpW6ezhEukOFkQWpKJ6uM" data-callback="verifyCallback"></div>
											<input type="text" class="hiddenRecaptcha required" name="hiddenRecaptcha" id="hiddenRecaptcha">
											<p id="NtHumn" style="display: none;color:red;"></p>
										</div>
									   <div class="field-div">
									    <div class="field-wrap two-fields-wrap">
									        <div class="field-div-full">
													<button class="btn btn-default " type="submit">Create My New Account <i class="fa fa-caret-right"></i></button>
									            </div>
									        </div>
									    </div>   
									</div>
					        	</div>							
						    </fieldset>
					    </form>	
							</div>
				            <div id="login" class="swichtab-panel" data-swichtab="target">
				                <?php if (has_post_thumbnail( $post->ID ) ): ?>
								    <?php $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'single-post-thumbnail' ); ?>
								    <div class="page-image">
								    	<img src="<?php echo $image[0]; ?>" alt="image" />
								    </div>
								<?php endif; ?>
								<div class="page-heading heading-right-link">
									<h1>Log In to SmartTag®</h1>
									<!-- <a href="#">Log In with ID Serial Number <i class="fa fa-caret-right"></i></a>	 -->
								</div>
								<p id="LgMes" style="display: none;color:red;"></p>
							<form method="post" id="EmailSignIn" name="EmailSignInform">
								 <div class="contact-form" id="cus-info">
                                 <div class="field-wrap two-fields-wrap">
                                    <div class="field-div">
                                        <label>*Email or Phone Number</label>
                                        <input type="text" name="PetProfessionalemail" placeholder="Enter Email Address" class="signIndata" required="" />
                                    </div>
                                    <div class="field-div">
                                        <label>*Password</label>
                                        <input type="password" name="password" placeholder="Enter Password" class="signIndata" required=""  />
                                    </div>
                                 </div>
                                <div class="field-wrap two-fields-wrap">
	                               <div class="field-div">&nbsp;</div>
	 								 <div class="field-div">
	  									 <div class="field-wrap two-fields-wrap">
					               				 <div class="field-div">
                                	 				 <input type="checkbox" name="remember">
                                	 	  			<label>Remember me</label>
					                  			</div>  
                                    		<div class="field-div">
		                                	<button class="btn btn-default" type="submit">Log In <i class="fa fa-caret-right"></i></button>
		                              		</div>
		                          		 </div>
    								</div>
								</div> 
                               </div>       
                            </form>
				            </div>
				            <div id="forgot_pass" class="swichtab-panel" data-swichtab="target">
				                <?php if (has_post_thumbnail( $post->ID ) ): ?>
								    <?php $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'single-post-thumbnail' ); ?>
								    <div class="page-image">
								    	<img src="<?php echo $image[0]; ?>" alt="image" />
								    </div>
								<?php endif; ?>
								<div class="row middle-border">
									<div class="col-sm-6 rmb-15">
										<div class="page-heading">
											<h1>Forgot your password?</h1>
										</div>
										<form method="POST" id="FogetPass" class="woocommerce-ResetPassword lost_reset_password" name="FogetPassform"><?php wp_nonce_field('ajax-forgot-nonce', 'forgotsecurity'); ?>    
										  	<div class="contact-form" id="cus-info">
												<div class="field-wrap">
													<div class="field-div">
														<label>Enter the Email address or Phone Number associated with SmartTag account</label>
														<input class="woocommerce-Input woocommerce-Input--text input-text Fgemail" type="text" placeholder="Enter Email Address" name="user_login" id="user_login" autocomplete="username" />
														<?php do_action( 'woocommerce_lostpassword_form' ); ?>
														<input type="hidden" name="wc_reset_password" value="true" />
														<p id="Fgpass" style="color: red;"></p>	
														<?php wp_nonce_field( 'lost_password', 'woocommerce-lost-password-nonce' ); ?>
													</div>
												</div>
												<div class="step-btns">
													<button class="btn btn-default" type="submit">Send Password Request <i class="fa fa-caret-right"></i></button>
												</div>
											</div>	
										</form>		
			                        </div>
									<div class="col-sm-6">
										<div class="page-heading">
											<h1>Forgot your email log in?</h1>
										</div>
											 	<form id="ForgetEmail" method="POST" name="ForgetEmailform">		
											        <div class="contact-form" id="cus-info">
													         <div class="field-wrap">
																<div class="field-div">
																	<label>Enter the Phone Number associated with SmartTag account</label>
																	<input type="text" name="phone" placeholder="Phone Number" class="UsrPnO" required="" />
																</div>
																<p id="recap3" style="display: none;color:red;"></p>
															</div>
														<div class="step-btns">
                                                            <button class="btn btn-default" type="submit">Send Login Request <i class="fa fa-caret-right"></i></button>
								                          </div>
					                                    </div>	
					                               </form>	
					                            </div>
										   </div>
						              </div>
						        </div>
						    </div>
						</div>
					</div>
				</div>
			</div>
		</div>
<?php get_footer(); ?>
<script type="text/javascript">
	$(function() {
		$("form[name='EmailSignInform']").validate({
		    // Specify validation rules
		    rules: {
		  		PetProfessionalemail: {
				        required: true,
				        email: true
		      			},
		      	password: {
				        required: true,
				        minlength: 8
		      			}
		    	},

		    messages: {
		        password: {
			        required: "Please provide a password",
			        minlength: "Your password must be at least 8 characters long"
			    },
		        PetProfessionalemail: "Please Enter a Valid Email Address"
		    },
		    submitHandler: function(form) {
		   	 $('.loader-wrap').fadeIn();
	  		    var Phdata =  new FormData();
  		      	Phdata.append('action', 'PetLoginWithEmailPassword');
		        $.each($('#EmailSignIn .signIndata'), function() {
		         	Phdata.append($(this).attr('name'), $(this).val());
                	 });
                 		 $.ajax({
		                    type: 'POST',
		                    url: ajaxurl,
		                    data: Phdata,
		                    contentType: false,
		                    processData: false,
		                    success: function(response) {
		                    	console.log(response);
		                    	 var Obj = JSON.parse(response);
		                    	  if(Obj.success == 0){
		                    	  	$('#LgMes').text(Obj.message).show();	
		                    	  	}else{
	                    	      		window.location.href = "<?=site_url()?>/pet-professional/";	
                    				}
		                   		},
	                   		complete:function(){
	                   			$('.loader-wrap').fadeOut();
	                   		}
	                   	});
	  		}
	  	}); 

	 //
	 $("form[name='FogetPassform']").validate({
		    // Specify validation rules
		    rules: {
		  		user_login: {
				        required: true,
				        email: true
		      			},
		      	},
		    messages: {
		        user_login: "Please Enter a valid Email Address"
		    },
		    submitHandler: function(form) {
		    	var forgetForm = form;
		    	$('.loader-wrap').fadeIn();
	  		    $('#Fgpass').text('');
	  		     var fgdata =  new FormData();
  		        fgdata.append('action', 'ForgetPetProPassword');
  		        fgdata.append('security', $('#forgotsecurity').val());
  		        $.each($('#FogetPass .Fgemail'), function() {
  		        	console.log($(this).attr('name') + "ocean" + $(this).val());
		         	fgdata.append($(this).attr('name'), $(this).val());
                 });
                  	$.ajax({
	                type:'POST',
	                url:ajaxurl,
	                data:fgdata,
	                contentType: false,
	                processData: false,
	               	success: function(response) {
						var Obj = JSON.parse(response);
	                	if(Obj.success == '1'){                    		
	                		$("#Fgpass").text(Obj.message).show().css("color","green"); 
	      				}else{
	      					
            		  		$('#Fgpass').text(Obj.message).show();
            		  	}
	               	},complete:function(){
	               			$('.loader-wrap').fadeOut();
	               		}
	            	});  
			   
		    }
	  	}); 
	 //
	 $("form[name='ForgetEmailform']").validate({
		    rules: {
				phone: {
					required :true,
					number :true,
					minlength : 10,
				   	maxlength : 10,
				   	
				}
			},
		    messages: {
				    phone: "Enter Registered Phone Number.",
				    minlength : "The phone number must be 10 digits.",
	                maxlength : "The phone number must be 10 digits.",
			    },
		    submitHandler: function(form) {
		    	$('#recap3').text('');
		    	$('.loader-wrap').fadeIn();
			    var Phdata =  new FormData();
		      	Phdata.append('action', 'PetForgetUserEmail');

			    $.each($('#ForgetEmail .UsrPnO'), function() {
			     Phdata.append($(this).attr('name'), $(this).val());
			     });

			  	$.ajax({
		        type: 'POST',
		        url: ajaxurl,
		        data: Phdata,
		        contentType: false,
		        processData: false,
		       	success: function(response) {
		            var Obj = JSON.parse(response);
		            	if(Obj.success == '1'){                    		
		            		$('.popup-wrap').fadeIn(function() {   							
		            			$('#poptitle').text("Confirm");
		            			$('#popcont').text(Obj.message);
								});
		            	}else{
		        		   $('#recap3').text(Obj.message).show();
		            		}
		           		},
		           		complete:function(){
		           			$('.loader-wrap').fadeOut();
		           		}
		           	});  
		    }
	  	});
	 // 	 
	  $("form[name='Petform']").validate({
		    ignore: ".ignore",
			errorPlacement: function(error, element) {
		        if(element.attr("name") == "terms"){
                    error.appendTo('#agreeValidate');
                    return true;
                } 
		        error.insertAfter(element);
		    },
		    rules: {
		    	org_password : {
                    minlength : 8
	            },
	            confirm_password : {
	                minlength : 8,
	                equalTo : "#OrgId"
	            },
	            org_email:{
	               	email: true,
	                "remote":{
	                    url: ajaxurl,
	                    type: "post",
	                    data: {
	                        'action' : 'checkEmailExist',
	                        userEmail: function() {
	                          return $('#PetPro :input[name="org_email"]').val();
	                        }
	                    }
	                }
	            },
                org_prm_no: {
                    required: true,
                    number: true,
                    minlength: 10,
                    maxlength: 10,
                    "remote":
                    {
                      url: ajaxurl,
                      type: "post",
                      data:
                      {
                         'action' : 'checkPrimaryExists',
                         priary_phone: function()
                         {
                          return $('#PetPro :input[name="org_prm_no"]').val();
                         }
                      }
                    }
                },
                org_sec_no: {
                	minlength:10,
                	maxlength:10,
                	number: true
                },
                org_zipcode: {
                	required :true,
                	minlength:5,
                	maxlength:5,
                },
                hiddenRecaptcha: {
                	required: function() {
				    	if(grecaptcha.getResponse() == '') {
				            return true;
				       	} else {
				            return false;
				        }
				    }
				}
	        },
		    messages: {
		        hiddenRecaptcha:"Please verify that you are human",
	        	org_prm_no: {
                    minlength : "The phone number must be 10 digits.",
                    maxlength : "The phone number must be 10 digits.",
                    remote: "This phone number already exists."
                },
                org_sec_no: {
                    minlength : "The phone number must be 10 digits.",
                    maxlength : "The phone number must be 10 digits.",
                },
                org_zipcode: {
                    minlength : "The Zipcode must be 5 digits.",
                    maxlength : "The Zipcode must be 5 digits.",
                },
                org_email : {
                	remote: "The email Id already exists.",
                },
		    },
		    submitHandler: function(form) {
		    	$('#NtHumn').text("");
		    	$('.loader-wrap').fadeIn();
	  		    var OrgData =  new FormData();
  		       	OrgData.append('action', 'PetProfessional');
		        $.each($('#PetPro .Org-data'), function() {
		         	OrgData.append($(this).attr('name'), $(this).val());
                });
                
				var $captcha1 = $( '#recaptcha1' ),
				response1 = grecaptcha.getResponse();
				console.log('rohit'+response1); 
				if (response1.length === 0) {
				  	$('#NtHumn').text("Please Verify Your are not Robort").show();
				  	$('.loader-wrap').fadeOut();
				} else {	
				    $.ajax({
	                    type: 'POST',
	                    url: ajaxurl,
	                    data: OrgData,
	                    contentType: false,
	                    processData: false,
	                    success: function(response) {
	                       	var Obj = JSON.parse(response);
	                    	console.log(Obj.success);
	                    	if(Obj.success == '1'){                    		
	                    		$('.popup-wrap').fadeIn(function() {   						
				            			$('#popcont').text(Obj.message);
										});
	                    	setTimeout(function(){ location.reload(); }, 3000);
	                    	}else{
                    		    $('.popup-wrap').fadeIn(function() {   						
		            			$('#popcont').text(Obj.message);
								});
                    		}	                    	
                    	},complete:function(){
	                   		$('.loader-wrap').fadeOut();
	                   	}                   			
	               	});	
               	}
            }	
		});
	   
	});      
</script>

