<?php 
/*
* Template Name:  Pet Professional Profile Info
*/
get_header(); 
//Redirect user if user not login or not petprofessional
if ( is_user_logged_in() ){
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
     

$userId = get_current_user_id();
// print_r(get_user_meta($userId));
$groupInfo = get_user_meta($userId,'multiple_group_info',true);

$shippingInfo = get_user_meta($userId,'multiple_shipping_info',true);

if (!empty($shippingInfo)) {
	$rs = 1;
	$i = 0;

	foreach ($shippingInfo as $values) {
		$countries_obj = new WC_Countries();
	    $countries = $countries_obj->__get('countries');
	    $countryDropDown = '<select name="shipping_country[]" class="shipping-info address-country"><option value="">Select</option>';
	    foreach ($countries as $key => $value) {
	    	if ($values['shipping_country'] == $key) {
	    		$countryDropDown .= '<option value="'.$key.'" selected >'.$value.'</option>';
	    	}else{
	       		$countryDropDown .= '<option value="'.$key.'" >'.$value.'</option>';
	       	}
	    }
	    $countryDropDown .= '</select>';
	    $shippingCountry[$i] = $countryDropDown;
	    $i++;
	}
}else{
	$shippingInfo = get_user_meta($userId);
   
	$rs = 0;
	$countries_obj = new WC_Countries();
    $countries = $countries_obj->__get('countries');
    $countryDropDown = '<select name="shipping_country[]" class="shipping-info address-country"><option value="">Select</option>';
    foreach ($countries as $key => $value) {
    	if ($shippingInfo['shipping_country'][0] == $key) {
    		$countryDropDown .= '<option value="'.$key.'" selected >'.$value.'</option>';
    	}else{
       		$countryDropDown .= '<option value="'.$key.'" >'.$value.'</option>';
       	}
    }
    $countryDropDown .= '</select>';
}
if (is_user_logged_in()) {

    	$userId = get_current_user_id();
    	$havemeta = get_user_meta($userId, 'user_image', true);
    	if ($havemeta) {
           
 			$image = wp_get_attachment_url($havemeta);
           
    	}else{
    		$image = wp_get_attachment_url(7919);
           
    	}
    }
   
    
$countries_obj  = new WC_Countries();
$countries      = $countries_obj->__get('countries');
$pcountry       = get_the_author_meta("primary_country",$userId);
$paddress1      = get_the_author_meta("primary_address_line1",$userId);
$paddress2      = get_the_author_meta("primary_address_line2",$userId);
$pcity          = get_the_author_meta("primary_city",$userId);
$pstate         = get_the_author_meta("primary_state",$userId);
$ppostCode      = get_the_author_meta("primary_postcode",$userId);
$shelter 		= get_the_author_meta("shelter_group_name",$userId)."<br>";

$pstate =  stateName($pstate, $pcountry);

foreach ($countries as $key => $value) {
    if (!empty($pcountry)) {
        if ($pcountry == $key) {
            $pcountry = '<br>'.$value;
            break;
        }
    }else
        break;
}
if (!empty($paddress1)) {
    $paddress1 .= ' ';
}
if (!empty($paddress2)) {
    $paddress2 .= ' ';
}
if (!empty($pcity)) {
    $pcity = '<br>'.$pcity.', ';
}elseif (!empty($paddress2)) {
    $paddress2 .= '<br>';
}elseif (!empty($paddress1)) {
    $paddress1 .= '<br>';
}else{
    $paddress1 = '<br>';
}

if (!empty($pstate)) {
    $pstate .= ' ';
}
if (!empty($ppostCode)) {
    $ppostCode  .= ' ';
}

$paddress   = $shelter.$paddress1.$paddress2.$pcity.$pstate.$ppostCode.$pcountry;

    ?>
<div class="container-wrap">		
	<div class="container main-content">
		<div class="row">
			<div class="col-sm-3 woo-sidebar">
				<!-- <h3 class="widgettitle">Pet Professional</h3>
				<?php echo do_shortcode("[wpb_childpages]"); ?> -->
                <?php echo do_shortcode("[stag_sidebar id='pet-professional-sidebar']"); ?>
                &nbsp;
                <?php echo do_shortcode("[stag_sidebar id='main-sidebar']"); ?>
		    </div>
			<div class="col-sm-9">
				<div class='page-heading'><h1>Billing/Shipping Information</h1></div>
            <div class="pp-tabs-wrap">
                <div class="pp-tabs-nav">
                    <div class="view pp-tabs-nav-inner pp-tab-option-1 active">View</div>
                    <div class="view pp-tabs-nav-inner pp-tab-option-2">Edit</div>
                </div>
                <div class="pp-tabs-content pp-tab-content-1" 1111122 style="display: block;">     
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="acc-blue-box">
                                <div class="acc-blue-head">
                                    Profile Image
                                    <div class="acc-edit owner-edit">
                                        <i class="fa fa-edit"></i> EDIT
                                    </div>
                                </div>
                                <div class="acc-blue-content">
                                    <div style="text-align: center;">
                                        <?php

                                        if(empty($image)){ 
                                            $image = site_url()."/wp-content/uploads/2019/04/userimage.png";
                                        }?>
                                        <img src="<?= $image; ?>" alt="Profile Image" class="profile-img" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="acc-blue-box">
                                <div class="acc-blue-head">
                                    Primary Contact Information
                                    <div class="acc-edit owner-edit">
                                        <i class="fa fa-edit"></i> EDIT
                                    </div>
                                </div>
                                <div class="acc-blue-content">
                                	<p><strong><?php echo get_the_author_meta("shelter_group_name",$userId); ?></strong></p>
                                    <p><strong>Name: </strong><?php echo get_the_author_meta("first_name",$userId); echo ' '; echo get_the_author_meta("last_name",$userId); ?></p>
                                	<p><?php echo $paddress; ?><br></p>
                                	<p><strong>Home Number: </strong><?php echo get_the_author_meta("primary_home_number",$userId); ?></p>
                                	<p><strong>Email: </strong><?php echo get_the_author_meta("email",$userId); ?></p> 
                                    <p><strong>Fax Number: </strong><?php echo get_the_author_meta("primary_fax_number",$userId); ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                    	<div class="col-sm-12">
                    		<div class="acc-blue-box">
                                <div class="acc-blue-head">
                                    Group Contact
                                    <div class="acc-edit owner-edit">
                                        <i class="fa fa-edit"></i> EDIT
                                    </div>
                                </div>
                                <div class="acc-blue-content">
                                    <?php 
                                    if(!empty($groupInfo)){
                                        foreach ($groupInfo as $key => $value) { ?>
                                        <span><strong><?= $value['group_title']; ?></strong></span><br>   
                                        <span><?= $value['group_first_name']; ?></span><br>    
                                        <span><?= $value['group_last_name']; ?></span><br>    
                                        <span><?= $value['group_phone_number']; ?></span><br>    
                                        <span><?= $value['group_email']; ?></span><br>     
                                    <?php }
                                    } 
                                    ?>
                                </div>
                            </div>
                    	</div>
                    </div>
                    <div class="row">
                    	<div class="col-sm-12">
                    		<div class="acc-blue-box">
                                <div class="acc-blue-head">
                                    Shipping Address
                                    <div class="acc-edit owner-edit">
                                        <i class="fa fa-edit"></i> EDIT
                                    </div>
                                </div>
                                <div class="acc-blue-content">
                                     <?php 
                                     if($rs){
                                        $num = 1;
                                        foreach ($shippingInfo as $key => $value) { ?>
                                           <span><strong>Address <?= $num++; ?></strong></span><br>
                                            <span><?= $value['shipping_first_name']; ?></span><br>   
                                            <span><?= $value['shipping_last_name']; ?></span><br>    
                                            <span><?= getCountryName($value['shipping_country']); ?></span><br>    
                                            <span><?= $value['shipping_address_1']; ?></span><br>    
                                            <span><?= $value['shipping_address_2']; ?></span><br>    
                                            <span><?= $value['shipping_city']; ?></span><br>    
                                            <span><?= stateName($value['shipping_state'], $value['shipping_country']); ?></span><br>    
                                            <span><?= $value['shipping_postcode']; ?></span><br/><br/>
                                    <?php } 
                                    }else{ ?>
                                    <span><strong><?= $shippingInfo['shipping_first_name'][0]; ?></strong></span><br>   
                                        <span><?= $shippingInfo['shipping_last_name'][0]; ?></span><br>    
                                        <span><?= getCountryName($shippingInfo['shipping_country'][0]); ?></span><br>    
                                        <span><?= $shippingInfo['shipping_address_1'][0]; ?></span><br>    
                                        <span><?= $shippingInfo['shipping_address_2'][0]; ?></span><br>    
                                        <span><?= $shippingInfo['shipping_city'][0]; ?></span>
                                        <br>    
                                        <span><?= stateName($shippingInfo['shipping_state'][0], $shippingInfo['shipping_country'][0]); ?></span>
                                        <br>    
                                        <span><?= $shippingInfo['shipping_postcode'][0]; ?></span><br/><br/>
                                      
                                    <?php }?>
                                </div>
                            </div>
                    	</div>
                    </div>
                </div>
                <div class="pp-tabs-content pp-tab-content-2">
                    <div class="contact-form">
                        <form action="" method="post" enctype="multipart/form-data" class="update-form">
                            <input type="hidden" name="post_id" value="">
                            <input type="hidden" name="action" value="" id="action">      
                            <div class="acc-blue-box">
                                <div class="acc-blue-head">
                                    Profile Image
                                </div>
                                <div class="acc-blue-content">
                                    <div class="row">
                                        <div class="col-sm-6 mb-15">
                                            <h4>Current Profile Image:</h4>
                                            <?php $imageURL = get_the_post_thumbnail_url();
                                          if(!empty($image)){
                                           echo '<img id="blah" src="'.$image.'" alt="Profile Image" />';
                                           }else{
                                               echo '<img id="blah" src="'.get_site_url().'/wp-content/uploads/2019/02/pet-image.jpg" alt="Profile Image" />';
                                           }?>

                                           <!--  <img src="<?= $image;?>" alt="Profile Image" class="profile-img" /> -->
                                        </div>
                                        <div class="col-sm-6 mb-15">
                                            <h4>Upload New Profile Image:</h4>
                                            <input name="profileImage" class="profile-image" id="imgInp" type="file">
                                            <p class="field-notice">
                                                Files must be less than 2 MB.
                                                <br>
                                                Allowed file types: .png / .gif / .jpg / .jpeg
                                            </p>
                                        </div>
                                    </div>
                                    <div class="text-center">
                                        <input type="button" name="uploadProfileImage" id="upload-profile-image" value="Save" class="site-btn-red">
                                    </div>
                                    <div id="uplProfImg"></div>
                                </div>
                            </div>   
                        </form>        
                            <div class="acc-blue-box change-password-email">
								<div class="acc-blue-head">
									Email / Password Change
								</div>
                                <form name="passwordChange" id="pasChange">
    								<div class="acc-blue-content">
    									<div class="field-wrap two-fields-wrap">
    										<div class="field-div">
    											<label for="password_current">Current Password</label>
    											<input type="password" class=" input-text change-pass regular-text" name="password_current" id="password_current" />
    										</div>
    										<div class="field-div">
    											<label for="password_current"></label>
    											<div class="field-notice">
    												Enter your current password to change the E-mail address or Password.
    											</div>
    										</div>
    									</div>

    									<div class="field-wrap two-fields-wrap">
    										<div class="field-div">
    											<label for="account_email">Change Email Address:</label>
    											<input type="email" class=" input-text change-pass regular-text" name="account_email" id="account_email" value="" />
    										</div>
    										<div class="field-notice col-sm-12 mb-15 clear">A valid e-mail address. All e-mails from the system will be sent to this address. The e-mail address is not made public and will only be used if you wish to receive a new password or wish to receive certain news or notifications by e-mail.</div>
    									</div>

    									<div class="field-wrap two-fields-wrap">
    										<div class="field-div">
    											<label for="password_1">New Password</label>
    											<input type="password" class=" input-text change-pass regular-text" name="password_1" id="password_1" />
    										</div>
    										<div class="field-div">
    											<label for="password_current"></label>
    											<div class="pass-strength">
    												<div class="row">
    													<div class="col-sm-12 mb-15">
    														Password Strength:
    														<span class="pull-right password-strength"><strong>Weak</strong></span>
    													</div>
    													<div class="col-sm-12">
    														<div class="pass-strength-line" id="pass-strength-line"></div>
    													</div>
    												</div>
    											</div>
    										</div>
    									</div>

    									<div class="field-wrap two-fields-wrap">
    										<div class="field-div">
    											<label for="password_2">Confirm New Password:</label>
    											<input type="password" class="	 input-text change-pass regular-text" name="password_2" id="password_2" />
    											<div class="field-notice">
    												<p>To make your password stronger:</p>
    												<ul>
    													<li>Make it at least 8 characters</li>
    													<li>Add lowercase letters</li>
    													<li>Add uppercase letters</li>
    													<li>Add numbers</li>
    													<li>Add punctuation</li>
    												</ul>
    											</div>
    										</div>
    										<div class="field-div">
    											<label for="password_current"></label>
    											<div class="pass-strength">
    												<div class="row">
    													<div class="col-sm-12 mb-15">
    														Password Match:
    														<span class="password-match pull-right"><strong></strong></span>
    													</div>
    												</div>
    											</div>
    										</div>
    									</div>
    									<div class="field-wrap submit-wrap">
    										<div class="field-div">
    											<div class="text-center">
    												<button type="button" class="site-btn-red" id="change-email-password">
    													Save
    												</button>
    											</div>
    										</div>
    									</div>				
                                        <div id="chngMsg"></div>
    								</div>
                                </form>
							</div>
							<div class="acc-blue-box change-primary-info">
								<div class="acc-blue-head">
									Primary Contact Information
								</div>
                                <form name="primContact" id="pricont">
    								<div class="acc-blue-content">
    									<div class="field-wrap two-fields-wrap">
    										<div class="field-div">
    											<label>*Shelter or Group Name:</label>
    											<input type="text" name="shelter_group_name" value="<?php echo get_the_author_meta("shelter_group_name",$userId); ?>" placeholder="Shelter or Group Name" class="primary-info">
    										</div>
    										<div class="field-div">
    											<label>*Country</label>
    											<?php 
                                                    $country = get_the_author_meta("primary_country",$userId);
                                                    $countries_obj = new WC_Countries();
                                                    $countries = $countries_obj->__get('countries');
                                                    echo '<select name="primary_country" class="primary-info address-country">';
                                                        foreach ($countries as $key => $value) {
                                                            if ($country == $key) {
                                                                echo '<option value="'.$key.'" selected>'.$value.'</option>';
                                                            }else{

                                                               echo '<option value="'.$key.'" >'.$value.'</option>';
                                                            }
                                                        }
                                                    echo '</select>';
                                                ?>
    										</div>
    									</div>
    									<div class="field-wrap two-fields-wrap">
    										<div class="field-div">
    											<label for="account_first_name">First name:</label>
    											<input type="text" name="account_first_name" value="<?php echo get_the_author_meta("first_name",$userId); ?>" class="primary-info" placeholder="First Name">
    										</div>
    										<div class="field-div">
    											<label for="account_last_name">Last name:</label>
    											<input type="text" name="account_last_name" value="<?php echo get_the_author_meta("last_name",$userId); ?>" placeholder="Last Name" class="primary-info">
    										</div>
    									</div>
    									<div class="field-wrap two-fields-wrap">
    				                        <div class="field-div">
    				                            <label>Address:</label>
    				                            <input type="text" name="primary_address_line1" value="<?php echo get_the_author_meta("primary_address_line1",$userId); ?>" class="primary-info" placeholder="Address Line 1">
    				                            <input type="text" name="primary_city" value="<?php echo get_the_author_meta("primary_city",$userId); ?>" class="primary-info" placeholder="City">
    				                        </div>
    				                        <div class="field-div">
    				                            <label></label>
    				                            <input type="text" name="primary_address_line2" value="<?php echo get_the_author_meta("primary_address_line2",$userId); ?>" class="primary-info" placeholder="Address Line 2">
    				                            <div class="field-wrap two-fields-wrap">
    				                                <div class="field-div">
    				                                	<label style="display: none;" class="statevalidate"></label>
                                                        <select class="address-state primary-info" name="primary_state" data-val="<?php echo get_the_author_meta("primary_state",$userId);  ?>"></select>
    				                                    <!-- <input type="text" name="primary_state" value="<?php //echo get_the_author_meta("primary_state",$userId); ?>" class="primary-info" placeholder="State"> -->
    				                                </div>
    				                                <div class="field-div">
    				                                    <input type="text" name="primary_postcode" value="<?php echo get_the_author_meta("primary_postcode",$userId); ?>" class="primary-info" placeholder="Zipcode">
    				                                </div>
    				                            </div>
    				                        </div>
    				                    </div>
    									<div class="field-wrap two-fields-wrap">
    				                        <div class="field-div">
    				                            <label>Primary Phone Number:</label>
    				                            <input type="text" name="primary_home_number" value="<?php echo get_the_author_meta("primary_home_number",$userId); ?>" class="primary-info" placeholder="1(555) 123-1234">
    				                        </div>
    				                        <div class="field-div">
    				                            <label>Secondary Phone Number:</label>
    				                            <input type="text" name="primary_cell_number" value="<?php echo get_the_author_meta("primary_cell_number",$userId); ?>" class="primary-info" placeholder="1(555) 123-1234">
    				                        </div>
    				                    </div>
    									<div class="field-wrap two-fields-wrap">
    										<div class="field-div">
    											<label>Fax Number:</label>
    											<input type="text" name="primary_fax_number" id="primary_fax_number" value="<?php echo get_the_author_meta("primary_fax_number",$userId); ?>" class="primary-info" />
    										</div>
    									</div>
    									<div class="field-wrap submit-wrap">
    										<div class="field-div">
    											<div class="text-center">
    												<button type="button" class="site-btn-red" id="change-primary-info">
    													Save
    												</button>
    											</div>
    										</div>
    									</div>			
    							        <div id="priryMes"></div>
                                	</div>
                                </form>
                            </div>
							<div class="acc-blue-box change-group-info">
								<div class="acc-blue-head">
									Group Information
								</div>
                                <form id="grupInfo">
    								<div class="acc-blue-content">
    									<div class="group-info-wrap">
    										<?php 

    										if (!empty($groupInfo) > 0) {
    											foreach ($groupInfo as $value) {
    										      	echo '<div class="group-info-class">
    											<div class="field-wrap">
    												<div class="field-div">
    													<label>*Title <span class="remove-block" style="float: right;">Remove</span></label>
    													<input type="text" placeholder="Title" name="group_title[]" value="'.$value['group_title'].'" class="regular-text group-info" />
    												</div>
    											</div>
    											<div class="field-wrap two-fields-wrap">
    												<div class="field-div">
    													<label for="account_first_name">First Name:</label>
    													<input type="text" placeholder="First Name" name="group_first_name[]"  value="'.$value['group_first_name'].'" class="regular-text group-info" />
    												</div>
    												<div class="field-div">
    													<label for="account_last_name">Last name:</label>
    													<input type="text" placeholder="Last Name" name="group_last_name[]" value="'.$value['group_last_name'].'" class="regular-text group-info" />
    												</div>
    											</div>
    											<div class="field-wrap two-fields-wrap">
    												<div class="field-div">
    													<label>*Phone Number:</label>
    													<input type="text" placeholder="Phone Number" name="group_phone_number[]" " value="'.$value['group_phone_number'].'" class="regular-text group-info" />
    												</div>
    												<div class="field-div">
    													<label>Email:</label>
    													<input type="email" placeholder="Email" name="group_email[]"  class="email group-info regular-text" value="'.$value['group_email'].'" />
    												</div>
    											</div>
    											<hr class="site-hr">
    										</div>';
    											}
    												# code...
    										}else{
                                                
    											echo '<div class="group-info-class">
    											<div class="field-wrap">
    												<div class="field-div">
    													<label>*Title <span class="remove-block" style="float: right;">Remove</span></label>
    													<input type="text" placeholder="Title" name="group_title[]" value="" class="regular-text group-info" />
    												</div>
    											</div>
    											<div class="field-wrap two-fields-wrap">
    												<div class="field-div">
    													<label for="account_first_name">First Name:</label>
    													<input type="text" placeholder="First Name" name="group_first_name[]"  value="" class="regular-text group-info" />
    												</div>
    												<div class="field-div">
    													<label for="account_last_name">Last name:</label>
    													<input type="text" placeholder="Last Name" name="group_last_name[]" value="" class="regular-text group-info" />
    												</div>
    											</div>
    											<div class="field-wrap two-fields-wrap">
    												<div class="field-div">
    													<label>*Phone Number:</label>
    													<input type="text" placeholder="Phone Number"  name="group_phone_number[]" " value="" class="regular-text group-info" />
    												</div>
    												<div class="field-div">
    													<label>Email:</label>
    													<input type="email" placeholder="Email" name="group_email[]"  class="email group-info regular-text" value="" />
    												</div>
    											</div>
    											<hr class="site-hr">
    										</div>';
    										} ?>
    										
    									</div>
    									<div class="field-wrap add-another">
    										<div class="field-div">
    											<button type="button" class="site-btn light-blue" id="add-group-info"><i class="fa fa-plus" aria-hidden="true"></i> Add Another Contact
    											</button>
    										</div>
    									</div>
    									<hr class="site-hr">
    									<div class="field-wrap submit-wrap">
    										<div class="field-div">
    											<div class="text-center">
    												<button type="button" class="site-btn-red" id="change-group-info">
    													Save
    												</button>
    											</div>
    										</div>
    									</div>
                                        <div id="gropMsg"></div>
    								</div>
                                </form>	
							</div>  
							<div class="acc-blue-box change-shipping-info">
								<div class="acc-blue-head">
									Shipping Addresses 
								</div>
								<div class="acc-blue-content">
									<div class="shipping-info-wrap">
										<?php
										$i = 0;
                                        $num = 1;
										if ($rs) {
											foreach ($shippingInfo as $value) {
												echo '<div class="shipping-info-class 1111222">
											<h3 class="sub-head">Address <span class="num">'.$num .'</span> <span class="remove-block" style="float: right;">Remove</span></h3>
											<hr class="site-hr">
											<div class="field-wrap two-fields-wrap">
												<div class="field-div">
													<label for="account_first_name">First Name:</label>
													<input type="text" name="shipping_first_name[]"  value="'.$value['shipping_first_name'].'" class="regular-text shipping-info" placeholder="First Name" />
												</div>
												<div class="field-div">
													<label for="account_last_name">Last name:</label>
													<input type="text" name="shipping_last_name[]" value="'.$value['shipping_last_name'].'" class="regular-text shipping-info" placeholder="Last Name" />
												</div>
											</div>
											<div class="field-wrap two-fields-wrap">
												<div class="field-div">
													<label for="account_first_name">Country:</label>
													'.$shippingCountry[$i].'
												</div>
                                                <div class="field-div"> <label class="statevalidate"></label>
                                                    <select class="address-state shipping-info" name="shipping_state[]" data-val="'.$value['shipping_state'].'"></select>
                                                </div>
											</div>
											<div class="field-wrap two-fields-wrap">
						                        <div class="field-div">
						                            <label>Address:</label>
						                            <input type="text" name="shipping_address_line_1[]" value="'.$value['shipping_address_1'].'" class="shipping-info" placeholder="Address Line 1">
						                            <input type="text" name="shipping_city[]" value="'.$value['shipping_city'].'" class="shipping-info" placeholder="City">
						                        </div>
						                        <div class="field-div">
						                            <label></label>
						                            <input type="text" name="shipping_address_line_2[]" value="'.$value['shipping_address_2'].'" class="shipping-info" placeholder="Address Line 2">
						                          <input type="text" name="shipping_postcode[]" value="'.$value['shipping_postcode'].'" class="shipping-info" placeholder="Zipcode">
						                        </div>
						                    </div>
											<!-- <div class="field-wrap two-fields-wrap">
												<div class="field-div">
													<label>*Phone Number:</label>
													<input type="text" name="shipping_phone_number[]" " value="" class="regular-text shipping-info" placeholder="Phone Number" />
												</div>
												<div class="field-div">
													<label>Email:</label>
													<input type="email" name="shipping_email[]"  class="email shipping-info regular-text" value="" placeholder="Email" />
												</div>
											</div> -->
										</div>';
										$i++;
                                        $num++;
											}
										}else{
											echo '<div class="shipping-info-class 222">
											<h3 class="sub-head">Address <span class="num">1</span> <span class="remove-block" style="float: right;">Remove</span></h3>
											<hr class="site-hr">
											<div class="field-wrap two-fields-wrap">
												<div class="field-div">
													<label for="account_first_name">First Name:</label>
													<input type="text" name="shipping_first_name[]"  value="'.$shippingInfo['shipping_first_name'][0].'" class="regular-text shipping-info" placeholder="First Name" />
												</div>
												<div class="field-div">
													<label for="account_last_name">Last name:</label>
													<input type="text" name="shipping_last_name[]" value="'.$shippingInfo['shipping_last_name'][0].'" class="regular-text shipping-info" placeholder="Last Name" />
												</div>
											</div>
											<div class="field-wrap two-fields-wrap">
												<div class="field-div">
													<label for="account_first_name">Country:</label>
													'.$countryDropDown.'
												</div>
											</div>
											<div class="field-wrap two-fields-wrap">
						                        <div class="field-div">
						                            <label>Address:</label>
						                            <input type="text" name="shipping_address_line_1[]" value="'.$shippingInfo['shipping_address_1'][0].'" class="shipping-info" placeholder="Address Line 1">
						                            <input type="text" name="shipping_city[]" value="'.$shippingInfo['shipping_city'][0].'" class="shipping-info" placeholder="City">
						                        </div>
						                        <div class="field-div">
						                            <label></label>
						                            <input type="text" name="shipping_address_line_2[]" value="'.$shippingInfo['shipping_address_2'][0].'" class="shipping-info" placeholder="Address Line 2">
						                            <div class="field-wrap two-fields-wrap">
						                                <div class="field-div">
                                                        <label style="display:none;" class="statevalidate"></label>
						                                <select class="address-state shipping-info" name="shipping_state[]" data-val="'.$shippingInfo['shipping_state'][0].'"></select>
						                    
						                                </div>
						                                <div class="field-div">
						                                    <input type="text" name="shipping_postcode[]" value="'.$shippingInfo['shipping_postcode'][0].'" class="shipping-info" placeholder="Zipcode">
						                                </div>
						                            </div>
						                        </div>
						                    </div>
											<!-- <div class="field-wrap two-fields-wrap">
												<div class="field-div">
													<label>*Phone Number:</label>
													<input type="text" name="shipping_phone_number[]" " value="" class="regular-text shipping-info" placeholder="Phone Number" />
												</div>
												<div class="field-div">
													<label>Email:</label>
													<input type="email" name="shipping_email[]"  class="email shipping-info regular-text" value="" placeholder="Email" />
												</div>
											</div> -->
										</div>';
										} ?>
									</div>
									<div class="field-wrap add-another">
										<hr class="site-hr">
										<div class="field-div">
											<button type="button" class="site-btn light-blue" id="add-shipping-info"><i class="fa fa-plus" aria-hidden="true"></i> Add Another Contact
											</button>
										</div>
									</div>
									<hr class="site-hr">
									<div class="field-wrap submit-wrap">
										<div class="field-div">
											<div class="text-center">
												<button type="button" class="site-btn-red" id="change-shipping-info">
													Save
												</button>
											</div>
										</div>
									</div>
                                    <div id="shipMsg"></div>
								</div>	
							</div>                    
                       
                    </div>
                </div>
            </div>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	jQuery(document).ready(function($){

		$("#upload-profile-image").click(function(){
			
            var uploadProfileImage = new FormData();
			var file = $('.profile-image').get(0).files[0];
			uploadProfileImage.append('feature', file);
	        uploadProfileImage.append('action', 'UploadProfileImage');
	        console.log(uploadProfileImage);
            $("body").find(".loader-wrap").fadeIn();
	        jQuery.ajax({
	            type: 'POST',
	            url: '<?php echo admin_url( 'admin-ajax.php' ); ?>',
	            data: uploadProfileImage,
	            contentType: false,
				processData: false,
				dataType: 'json',
	            success: function(response){
                    console.log(response); // Append Server Response
                    var $msg = "";
                    $("body").find(".loader-wrap").fadeOut();
                    if (response.attachId > 0) {
                        // $mesg = '<div class="alert alert-success"><strong>Success!</strong> '+ response.msg +'</div>'
                        location.reload(true);

                    }else{
                        $mesg = '<div class="alert alert-danger"><strong>Error!</strong> '+ response.msg +'</div>'
                        $("#uplProfImg").html($mesg);
                    }
                }
	        });
		});

        var pssvalidator = $('form[id="pasChange"]').validate({
        rules: {
                password_current: 'required',
                account_email: 'required',
                password_1 : { minlength : 8, required: true,},
                password_2: {minlength : 8, equalTo : "#password_1", required: true,}
                },
            submitHandler: function(form) {
            form.submit();
          }
        });
        
		$("#change-email-password").click(function(e){
            e.preventDefault();
            if($("#pasChange").valid()){
                var changePassForm = new FormData();
    	        $.each($('.change-pass'), function() {		           
    	              changePassForm.append($(this).attr('name'), $(this).val());		            
    	        });
    	        changePassForm.append('action', 'changePasswordForm');
    	        console.log(changePassForm);
    	        jQuery.ajax({
    	            type: 'POST',
    	            url: '<?php echo admin_url( 'admin-ajax.php' ); ?>',
    	            data: changePassForm,
    	            contentType: false,
    				processData: false,
    				dataType: 'json',
    	            success: function(response){
                        var $msg ="";
                        if(response.success == 1){
                            $msg = '<div class="alert alert-success"><strong>Success!</strong> '+ response.message +'</div>'
                        }
                        $("#chngMsg").html($msg);
    	            }
    	        });
            }else{
                pssvalidator.focusInvalid();    
            }    
		});

        
        var parimaryValidator = $('form[id="pricont"]').validate({
                rules: {
                    shelter_group_name: 'required',
                    account_first_name: 'required',
                    account_last_name: 'required',
                    primary_country: 'required',
                    primary_state: 'required',
                    account_email: 'required',
                    primary_address_line1: 'required',
                    primary_home_number: 
                    {
                        minlength : 10,
                        maxlength:10 ,
                        required: true,
                        "remote":
                        {
                          url: ajaxurl,
                          type: "post",
                          data:
                          {
                             'action' : 'checkPrimaryExists',
                             priary_phone: function()
                             {
                              return $('#pricont :input[name="primary_home_number"]').val();
                             }
                          }
                        }
                    },
                    primary_cell_number: {minlength : 10,maxlength:10 },
                    primary_postcode : { minlength :5,maxlength:5,required :true },
                    primary_argent_alert: 'required',
                    password_1 : { minlength : 8, required: true,},
                    password_2: {minlength : 8, equalTo : "#password_1", required: true,},
                    primary_fax_number : { number :true }
                },
                messages :{
                    primary_home_number : {
                        minlength : "The phone number must be 10 digits.",
                        maxlength : "The phone number must be 10 digits.",
                        remote: "This phone number already exists."
                    },
                    primary_postcode : {
                        minlength : "The Zipcode must be 5 digits.",
                        maxlength : "The Zipcode must be 5 digits.",
                    }
                },
            submitHandler: function(form) {
            form.submit();
          }
        });


		$("#change-primary-info").click(function(){
            if($("#pricont").valid()){
    			var updatePrimaryInfo = new FormData();
    	        $.each($('.primary-info'), function() {		           
    	              updatePrimaryInfo.append($(this).attr('name'), $(this).val());		            
    	        });
    	        updatePrimaryInfo.append('action', 'save_primary_info');
    	        console.log(updatePrimaryInfo);
    	        jQuery.ajax({
    	            type: 'POST',
    	            url: '<?php echo admin_url( 'admin-ajax.php' ); ?>',
    	            data: updatePrimaryInfo,
    	            contentType: false,
    				processData: false,
    				dataType: 'json',
    	            success: function(response){
                        var $msg ="";
                        if(response.success == 1){
                            $mesg = '<div class="alert alert-success"><strong>Success!</strong> '+ response.message +'</div>'
                        }
                        $("#priryMes").html($mesg);
                        setTimeout(function(){
                            location.reload();
                        }, 2000);
    	            }
    	        });
            }else{
                parimaryValidator.focusInvalid();    
            }    
		});

        $("#change-group-info").click(function(){

            if($("#grupInfo").valid()){
    			var updateGroupInfo = new FormData();
    	        $.each($('.group-info'), function() {		           
    	              updateGroupInfo.append($(this).attr('name'), $(this).val());		            
    	        });
    	        updateGroupInfo.append('action', 'updateGroupInfo');
    	        jQuery.ajax({
    	            type: 'POST',
    	            url: '<?php echo admin_url( 'admin-ajax.php' ); ?>',
    	            data: updateGroupInfo,
    	            contentType: false,
    				processData: false,
    				dataType: 'json',
    	            success: function(response){
    	                var $msg ="";
                        if(response.success == 1){
                            $mesg = '<div class="alert alert-success"><strong>Success!</strong> '+ response.message +'</div>'
                        }
                        $("#gropMsg").html($mesg);
    	            }
    	        });
            }else{
                grupvalidator.focusInvalid();
            }
		});
		$("#change-shipping-info").click(function(){
			var updateShippingInfo = new FormData();
	        $.each($('.shipping-info'), function() {	
            console.log('ocean',$(this).attr('name'), $(this).val());	           
	              updateShippingInfo.append($(this).attr('name'), $(this).val());		            
	        });
	        updateShippingInfo.append('action', 'updateShippingInfo');
	        console.log(updateShippingInfo);
	        jQuery.ajax({
	            type: 'POST',
	            url: '<?php echo admin_url( 'admin-ajax.php' ); ?>',
	            data: updateShippingInfo,
	            contentType: false,
				processData: false,
				dataType: 'json',
	            success: function(response){
	                var $msg ="";
                    if(response.success == 1){
                        $mesg = '<div class="alert alert-success"><strong>Success!</strong> '+ response.message +'</div>'
                    }
                    $("#shipMsg").html($mesg);
                    setTimeout(function(){
                        location.reload();
                    }, 2000);
	            }
	        });
		});
		// $(".profile-image").on("change",function(){
		// 	if($(this)[0].files.length == 0){
		// 		$(".profile-img").attr("src","<?php echo $image[0]; ?>");
		// 		return;
		// 	}
		// 	var image = document.querySelector('input[type=file]');
  //           console.log(image);
  //           readURLl(image,'profile-img');
		// });

		$("#add-group-info").on("click",function(){
            $('.group-info-wrap .group-info-class:last-child').clone()
                          .find("input").val("").end()
                          .appendTo('.group-info-wrap');
		});
		$("body").on("click",".group-info-wrap .remove-block",function(){
			$(this).parent().parent().parent().parent().remove();
		});
		$("#add-shipping-info").on("click",function(){
			var shippingAddress = $('.shipping-info-wrap .shipping-info-class:last-child').clone();
			shippingAddress = shippingAddress.clone().find('span.num').each(function(){
		          		var num = parseInt($(this).text())+1;
		          		$(this).text(num);
						 }).end();
			shippingAddress = shippingAddress.find("select.address-country option:first-child").prop("selected",true).end();
			var country = shippingAddress.find("select.address-country").val();
			// console.log(window.addressStates['IN']);
			var j = 0;
			var select = "<option value='0'>Please Select State</option>";
			$.each(window.addressStates[country], function(i, item) {
				j++;
			    select += "<option value='"+i+"'>"+item+"</option>";
			});
			if (j==0) {
				select = "<input type='text' class='address-state shipping-info' name='shipping_state[]' placeholder='Enter State' data-val=''>";
				shippingAddress = shippingAddress.find("select.address-state").each(function(){
		          		$parent = $(this).parent();
		          		$(this).remove();
		          		$parent.append(select);
						 }).end();
			}else{
				shippingAddress = shippingAddress.find("select.address-state").html(select).end();
			}
			shippingAddress.find("input").val("").end()
                          .appendTo('.shipping-info-wrap'); 
		});
		$("body").on("click",".shipping-info-wrap .remove-block",function(){
			$(this).parent().parent().remove();
		});
	});
</script>
<?php get_footer(); ?>
<style type="text/css">
	.site-hr {
	    border-bottom: 1px solid #527fb4;
	}
	.sub-head {
	    margin-top: 1px;
	}
	.group-info-class:first-child .remove-block{
		display: none;
	}
	.shipping-info-class:first-child .remove-block{
		display: none;
	}
</style>

