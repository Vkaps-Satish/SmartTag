<?php 
/*
* Template Name:  Login to SmartTag

*/
get_header(); 

if ( is_user_logged_in() ){
     $current_user = wp_get_current_user();
     $roles = $current_user->roles; 

       if( $roles == 'pet_professional' || in_array( 'pet_professional', $roles )){
         //print('<script>window.location.href="/pet-professional"</script>');
         print('<div>
        <div class="not-found-text width-100">This page is only for Customers..</div></div>');
         exit();
          }else{
			print('<script>window.location.href="'.get_option('siteurl').'/my-account"</script>');
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
		        <?php echo do_shortcode("[stag_sidebar id='main-sidebar']"); ?>
		    </div>
			<div class="woo-content col-sm-9" id="woo-content">
				<!-- <div class="woocommerce-message" role="alert"> -->
					<p id="existing_info"></p>
				<!-- </div> -->
				<div class="site-tabs-wrap">
					<div class="tabGroup">
				        <ul class="swichtab-controller">
				            <li data-swichtab="controller" class="singup-click"><a href="#singup">Sign Up</a></li>
				            <li data-swichtab="controller" class="login-click"><a href="#login">Log In</a></li>
				            <li data-swichtab="controller" class="forget-password-click"><a href="#forgot_pass">Forgot Password?</a></li>
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
									<h1>Sign Up with SmartTag®</h1>
									<a href="<?php echo get_site_url(); ?>/pet-professionals-signup/">Sign Up as a Shelter / Pet Professional <i class="fa fa-caret-right"></i></a>
								</div>
								<p>Note:- Accurate Phone and Email are vital for your pet's safety.</p>
								<p id="SigEror" style="display: none;color:red;"></p>
						<form id="SmtSignup" method="POST" name="SmtSignupform">		
					         <div class="contact-form" id="cus-info">
						       <div class="field-wrap two-fields-wrap">
									<div class="field-div">
										<label>*First Name </label>
										<input type="text" name="p_fst_name" placeholder="First Name" class="user-data" id="u-first" required="" />
									</div>
									<div class="field-div">
										<label>*Last Name </label>
										<input type="text" name="p_lst_name" placeholder="Last Name" class="user-data" id="u-last" required="" />
									</div>
								</div>
								<div class="field-wrap two-fields-wrap">
									<div class="field-div">
										<label>*Email </label>
										<input type="email" name="p_email" placeholder="Enter Email Address" class="user-data" id="u-email" required="" />
									</div>
									<div class="field-div">
										<label>*Confirm Email </label>
										<input type="email" name="confirm_email" placeholder="Enter Confirm Email Address" class="user-data" id="confirm-email" required="" />
									</div>							
								</div>
								<div class="field-wrap two-fields-wrap">
									<div class="field-div">
										<label>*Password </label>
										<input type="password" name="password" placeholder="Enter Password" class="user-data"  required="" id="u-password" />
									</div>
									<div class="field-div">
										<label>*Confirm Password </label>
										<input type="password" name="confirm_password" placeholder="Enter Confirm Password" class="user-data" id="confirm-password" required="" />
									</div>							
								</div>
								<div class="field-wrap">
									<div class="field-div">
										<label>*Select Your Country </label>
										<select name="p_country" class="user-data address-country" required="" >
										<option value="">Select</option>
										<?php 
										foreach ($CountriesName as $key => $value) {?>
											<option value="<?php echo $key; ?>"><?php echo $value;?></option>
											<?php } ?>
										</select>
									</div>
								</div>
								<!-- <div class="field-wrap two-fields-wrap">							
									<div class="field-div">
										<label>*Address: </label>
										<input type="text" name="p_add1" placeholder="Address line 1" class="user-data" id="u-add1" required="" />
										<input type="text" name="p_city" placeholder="City" class="user-data" id="u-city1" required="" />
									</div>
									<div class="field-div">
										<label></label>
										<input type="text" name="p_add2" placeholder="Address line 2" class="user-data" id="u-add2"/>
										<div class="field-wrap two-fields-wrap">
											<div class="field-div">
												//<input type="text" name="UserState" class="user-data" id="usrstate" required=""> 
												<select name="UserState" class="user-data address-state" id="usrstate" data-val=""></select>
											</div>
											<div class="field-div">
												<input type="text" name="p_zipcode" placeholder="Zipcode" class="user-data" id="u-zip" />
											</div>
										</div>
									</div>
								</div> -->
								<div class="field-wrap two-fields-wrap">	
									<div class="field-div">
										<label>*Address</label>
										<input type="text" name="p_add1" placeholder="Address line 1" class="user-data" id="u-add1" required="" />
									</div>		
									<div class="field-div">
										<label></label>
										<input type="text" name="p_add2" placeholder="Address line 2" class="user-data" id="u-add2"/>
									</div>	
								</div>
								<div class="field-wrap two-fields-wrap">	
									<div class="field-div">
										<input type="text" name="p_city" placeholder="City" class="user-data" id="u-city1" required="" />
									</div>		
									<div class="field-div">
										<div class="field-wrap two-fields-wrap">
											<div class="field-div">
												<label style="display: none;" class="statevalidate"></label>
												<select name="UserState" class="user-data address-state" id="usrstate" data-val=""></select>
											</div>
											<div class="field-div">
												<input type="text" name="p_zipcode" placeholder="Zipcode" class="user-data" id="u-zip" />
											</div>
										</div>
									</div>	
								</div>
								<div class="field-wrap two-fields-wrap">
									<div class="field-div">
										<label>*Primary Phone Number </label>
										<input type="text" name="p_prm_no" placeholder="1(555) 123-1234" class="user-data phone-number" id="urp-phone" required="" />
										<input type="hidden" name="p_prm_no_code" placeholder="1(555) 123-1234" class="user-data" id="urp-phone-code" required="" value="1"/>
									</div>
									<div class="field-div">
										<label>Secondary Phone Number (Optional) </label>
										<input type="text" name="p_sec_no" placeholder="1(555) 123-1234" class="user-data phone-number" id="urps-phone"  />
										<input type="hidden" name="p_sec_no_code" placeholder="1(555) 123-1234" class="user-data" id="urps-phone-code" value="1" />
									</div>
								</div>
								<div class="field-wrap two-fields-wrap">
									<div class="field-div">
										<label>*Security Question1 </label>
										<select name="Squs1" class="user-data mySelect mySelect-1" id="sqrtyQus1" required="">
											<option value="">Select a Question..</option>
											<option value="Question1">Question1</option>
											<option value="Question2">Question2</option>
											<option value="Question3">Question3</option>
											<option value="Question4">Question4</option>
										</select>
									</div>
									<div class="field-div">
										<label>*Security Answer1 </label>
										<input type="text" name="SqAns1" placeholder="Enter Your Answer" class="user-data" id="sqrtyAns1" required="" />
									</div>
								</div>
								 <div class="field-wrap two-fields-wrap">
									<div class="field-div">
										<label>*Security Question2 </label>
										<select name="Squs2" class="user-data mySelect mySelect-2" id="sqrtyQus2" required="">
											<option value="">Select a Question..</option>
											<option value="Question1">Question1</option>
											<option value="Question2">Question2</option>
											<option value="Question3">Question3</option>
											<option value="Question4">Question4</option>
										</select>
									</div>
									<div class="field-div">
										<label>*Security Answer2 </label>
										<input type="text" name="SqAns2" placeholder="Enter Your Answer" class="user-data" id="sqrtyAns2" required="" />
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
									<a href="javascript:void(0)" id="Swplogin"> Log In with ID Serial Number <i class="fa fa-caret-right"></i></a>
									<a href="javascript:void(0)" id="Swplogin1">Log In With Customers Email <i class="fa fa-caret-right"></i></a>		
								</div>
								<p id="EmEror" style="display: none;color:red;"></p>
							<form method="post" id="EmailSignIn" name="EmailSignInform">
								 <div class="contact-form" id="Emform">
								 	
                                 <div class="field-wrap two-fields-wrap">
                                    <div class="field-div">
                                        <label>*Email or Phone Number </label>
                                        <input type="text" name="email" placeholder="Enter Email or Phone Number" class="signIndata" required="" />
                                       </div>
                                    <div class="field-div">
                                        <label>*Password</label>
                                        <input type="password" name="password" placeholder="Enter Password" class="signIndata" required="" />
                                    </div>
                                 </div>
                                <div class="field-wrap two-fields-wrap">
	                               <div class="field-div">&nbsp;</div>
	 								 <div class="field-div">
	  									 <div class="field-wrap two-fields-wrap">
					               				 <div class="field-div">
                                	 				 <input type="checkbox" name="remember" value="false" id="rember1" class="signIndata">
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
                            <form method="post" id="SrialSignIn" name="SrialSignInform">
								 <div class="contact-form" id="Sriform">
								 <div class="field-wrap two-fields-wrap">
                                    <div class="field-div">
                                        <label>*Id Serial Number </label>
                                        <input type="text" id="SrilId" name="SrialId" placeholder="Enter Id Serial Number" class="SrialData" required="" />
                                       </div>
                                    <div class="field-div">
                                        <label>*Confirm Id Serial Number</label>
                                        <input type="text" id="srialId1" name="ConSrialId" placeholder="Enter Id Serial Number" class="SrialData" required="" />
                                    </div>
                                 </div>
                                <div class="field-wrap two-fields-wrap">
	                               <div class="field-div">&nbsp;</div>
	 								 <div class="field-div">
	  									 <div class="field-wrap two-fields-wrap">
					               				 <div class="field-div">
                                	 				 <input type="checkbox" name="remember" value="false" id="rember" class="SrialData">
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
												<form id="ForgetEmail" name="ForgetEmailform">	
													<?php wp_nonce_field('ajax-forgot-nonce', 'forgotsecurity'); ?> 	
											        <div class="contact-form" id="">
													        <div class="field-wrap">
																<div class="field-div">
																	<label>Enter the Phone Number associated with SmartTag account</label>
																	<input type="text" name="phone" placeholder="Enter Phone Number" class="UsrPnO" required="" />
																	<p id="recap3" style="display: none;color:red;"></p>
																</div>
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
jQuery(document).ready(function($){
	jQuery.validator.addMethod("checkEmailAndNumber", function (value, element) {
		if (value.match(/^[0-9]+$/) != null) {
			if (value.length != 10) {
				return false;
			}
		}else{
			if (!validateEmail(value)) {
				return false
			}
		}
		return true;
    }, "Please enter valid Email or Phone Number.");


	$("#login").trigger( "click" );
	$('#rember').change(function(){
		      $(this).val(this.checked ? "true" : "false");
		});


	 	$('#Sriform').hide();
 		$('a#Swplogin1').hide();

 			$('a#Swplogin').click(function(){
 				$(this).hide(); 			
	 			$('a#Swplogin1').show();
	 			$('#EmailSignIn').toggle();
	 			$('#Sriform').toggle();
	 		});
	 	//}
	 	
	 		$('a#Swplogin1').click(function(){
	 			$(this).hide();
	 			$('a#Swplogin').show();
	 			$('#EmailSignIn').toggle();
	 			$('#Sriform').toggle();
	 		});
	 			

	$(function() {
	//	
		$("form[name='EmailSignInform']").validate({
		    // Specify validation rules
		    rules: {
		  		email: {
			        required: true,
			        checkEmailAndNumber: true,
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
		        
		    },
		    submitHandler: function(form) {
		    $('#EmEror').text("");
            $('.loader-wrap').fadeIn();
            var Edata =  new FormData();
              	Edata.append('action', 'LoginWithEmailPassword');
             
             	$.each($('#EmailSignIn .signIndata'), function() {
               		Edata.append($(this).attr('name'), $(this).val());
                });
                    $.ajax({
                        type: 'POST',
                         url: ajaxurl,
                         data: Edata,
                        contentType: false,
                        processData: false,
                        success: function(response) {
                        var obj = jQuery.parseJSON( response );
                            if(obj.success == 0){
                               $('#EmEror').text(obj.message).fadeIn();
                           	}else if(obj.success == 1){
                           		<?php if (isset($_GET['redir']) && !empty($_GET['redir'])) { ?>
                           			window.location.href = "<?php echo $_GET['redir']; ?>";
                           		<?php }else{ ?>
                               		window.location.href = "<?php echo get_site_url(); ?>/my-account/";
                               	<?php } ?>
                           	}else{
                           		$('#EmEror').text(obj.message).fadeIn();
                         	}
                         },
                         complete:function(){
                           $('.loader-wrap').fadeOut();
                         }
		   
		  		});
            }
        }); 

		$("form[name='EmailSignInform']").validate({
		    // Specify validation rules
		    rules: {
		  		email: {
			        required: true,
			        checkEmailAndNumber: true
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
		        
		    },
		    submitHandler: function(form) {
		    $('#EmEror').text("");
            $('.loader-wrap').fadeIn();
            var Edata =  new FormData();
              	Edata.append('action', 'LoginWithEmailPassword');
             
             	$.each($('#EmailSignIn .signIndata'), function() {
               		Edata.append($(this).attr('name'), $(this).val());
                });
                    $.ajax({
                        type: 'POST',
                         url: ajaxurl,
                         data: Edata,
                        contentType: false,
                        processData: false,
                        success: function(response) {
                        var obj = jQuery.parseJSON( response );
                            if(obj.success == 0){
                               $('#EmEror').text(obj.message).fadeIn();
                           	}else if(obj.success == 1){
                           		<?php if (isset($_GET['redir']) && !empty($_GET['redir'])) { ?>
                           			window.location.href = "<?php echo $_GET['redir']; ?>";
                           		<?php }else{ ?>
                               		window.location.href = "<?php echo get_site_url(); ?>/my-account/";
                               	<?php } ?>
                           	}else{
                           		$('#EmEror').text(obj.message).fadeIn();
                         	}
                         },
                         complete:function(){
                           $('.loader-wrap').fadeOut();
                         }
		   
		  		});
            }
        });           
	//	   
		$("form[name='SrialSignInform']").validate({
		    // Specify validation rules
		     rules: {
		  		SrialId: {
				        required: true,
				        },
		      	ConSrialId: {
				        required: true,
				        equalTo : "#SrilId"
		      			},
		      	},
		    messages: {
		    SrialId: "Enter Serial Id",
		    ConSrialId: "Confirm Serial Id",
		    },
		    submitHandler: function(form) {
		    	
		    	$('.loader-wrap').fadeIn();
			    $('#EmEror').text("");
	       		var SrlData =  new FormData();

	       		$.each($('#SrialSignIn .SrialData'), function(){
	       			SrlData.append($(this).attr('name'), $(this).val());
	       		})

	       		 SrlData.append('action', "LoginWithEmailPassword");
	       	
	        		 $.ajax({
			                    type: 'POST',
			                    url: ajaxurl,
			                    data: SrlData,
			                    contentType: false,
			                    processData: false,
			                    success: function(response) {
			                    	var Obj = jQuery.parseJSON( response );
		                    	      if(Obj.success == 1){
	                    					  window.location.href = "<?php echo get_site_url(); ?>/my-account/";
	                    				}else{
						              		$('#EmEror').text(Obj.message).fadeIn();
						                }
			                   	},
			                   	complete:function(){
			                   		$('.loader-wrap').fadeOut();
			                   	}
	                     });
	       		
		    }
		  });

		$("form[name='SmtSignupform']").validate({
			ignore: ".ignore",
			errorPlacement: function(error, element) {
		          if(element.attr("name") == "terms"){
		                          error.appendTo('#agreeValidate');
		                          return true;
		                        } 
		            error.insertAfter(element);
		        },
			rules: {
					terms: {
	                	required :true,
	                },
	                p_email:{
	                	email: true,
	                	"remote":
	                    {
	                      url: ajaxurl,
	                      type: "post",
	                      data:
	                      {
	                         'action' : 'checkEmailExist',
	                         userEmail: function()
	                         {
	                          return $('#SmtSignup :input[name="p_email"]').val();
	                         }
	                      }
	                    }
	                },
	                p_prm_no: {
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
	                          return $('#SmtSignup :input[name="p_prm_no"]').val();
	                         }
	                      }
	                    }
	                },
	                p_sec_no: {
	                	minlength:10,
	                	maxlength:10,
	                	number: true
	                },
	                p_zipcode: {
	                	required :true,
	                	minlength:5,
	                	maxlength:5,
	                },
	                confirm_email: {
	                	email: true,
	                	equalTo : "#u-email"
	                },
	                password : {
                    	minlength : 8
	                },
	                confirm_password: {
	                	minlength : 8,
	                	equalTo : "#u-password"
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
				    id_num: "Enter Serial Id",
				    con_id_num: "Confirm Serial Id",
				    p_prm_no: {
	                    minlength : "The phone number must be 10 digits.",
	                    maxlength : "The phone number must be 10 digits.",
	                    remote: "This phone number already exists."
	                },
	                p_sec_no: {
	                    minlength : "The phone number must be 10 digits.",
	                    maxlength : "The phone number must be 10 digits.",
	                },
	                p_zipcode: {
	                        minlength : "The Zipcode must be 5 digits.",
	                        maxlength : "The Zipcode must be 5 digits.",
	                },
	                p_email : {
                    	remote: "The email Id already exists.",
                    },
                    confirm_password : {
                    	equalTo : "The password and confirm password field do not match."
                    },confirm_email: {
                    	equalTo: "The email and confirm email field do not match."
                    }
			    },
		    submitHandler: function(form) {
		    	 console.log("captcha form fom k ander");
		    	$('.loader-wrap').fadeIn();
				$('#SigEror').text("");
		   		var tagData =  new FormData();

  		       	tagData.append('action', "SmartTagRegster");
		         	$.each($('#SmtSignup .user-data'), function() {
		         		tagData.append($(this).attr('name'), $(this).val());
                 	});

                response = grecaptcha.getResponse();
                
				if($('#Sid_num').val() == $('#Scon_id_num').val() ){  
			 	if (response.length === 0 ) {
			 		alert("faid");
			 	  	$('.loader-wrap').fadeOut();
					$("#NtHumn").text("Please Verify Your are not Robort").show();
				  } else {
				  	   $.ajax({
		                    type: 'POST',
		                    url: ajaxurl,
		                    data: tagData,
		                    contentType: false,
		                    processData: false,
		                    success: function(response) {
	                    	console.log(response);
	                    	var Obj = jQuery.parseJSON( response );
		                    if(Obj.success==1){
			                        $('.popup-wrap').fadeIn(function() {   				
				            		$('#poptitle').text(Obj.title);
				            		$('#popcont').text(Obj.message);
				            		$('#SmtSignup')[0].reset();
								});
		                    }else{
		                        	$("#SigEror").text(Obj.message).show();
			                    }
		                    }
		                    ,complete: function(){
		                    	$('.loader-wrap').fadeOut();
		                    }
                     });
			 	 }
           
				}else{
						$("#SigEror").text('Please Confirm Serial Id').show();
						$('.loader-wrap').fadeOut();	
				}
		    }
		});

	//
		$("form[name='FogetPassform']").validate({
				rules: {
				   	email:{
				   		required :true,
				   		email :true,
				   		customEmail : true
				   	} 
				},
		        submitHandler: function(form) {
		        var forgetform = form;
			  	$('.loader-wrap').fadeIn();
  		    	var fgdata =  new FormData();
  		        fgdata.append('action', 'ForgetUserPassword');
		        $.each($('#FogetPass .Fgemail'), function() {
		        fgdata.append($(this).attr('name'), $(this).val());
                });
                fgdata.append('security', $('#forgotsecurity').val());
		              $.ajax({
		                type: 'POST',
		                 url: ajaxurl,
		                 data: fgdata,
		                contentType: false,
		                processData: false,
		                success: function(response) {
						var Obj = JSON.parse(response);
						
							if(Obj.success == '1'){                    		
								$('.popup-wrap').fadeIn(function() {   						
			            			$('#poptitle').text(Obj.title);
			            			$('#popcont').text(Obj.message);
								});

							}else{
		            		  	$("#Fgpass").text(Obj.message).show();  
		            		  }
	               		},complete:function(){
	               			form.reset();
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
			    	$('#recap3').text("");
		         	$('.loader-wrap').fadeIn();
		  		    var Phdata =  new FormData();
	  		       	Phdata.append('action', 'ForgetUserEmail');
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
			            			$('#poptitle').text(Obj.title);
			            			$('#popcont').text(Obj.message);
								});
		                	}else{
		            		  	 $("#recap3").text(Obj.message).show();               
		            		    }
	               		},
				        complete:function(){
				        	form.reset();
				        	$('.loader-wrap').fadeOut();
				        }
	                });	
			    }
			 
			});	

		});
	});
   
</script>

