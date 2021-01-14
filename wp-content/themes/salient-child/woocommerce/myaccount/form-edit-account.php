<?php
/**
 * Edit account form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/form-edit-account.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 3.3.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


do_action( 'woocommerce_before_edit_account_form' ); ?>

<?php do_action( 'woocommerce_edit_account_form_start' ); ?>

<div class="page-heading">
	<h1>Owner Profile Information</h1>
</div>
<?php 
	$countryPhoneCode = json_decode(file_get_contents(__DIR__."/../../lib/countryPhoneCode.json"));

	$countries_obj 	  = new WC_Countries();
    $countries 		  = $countries_obj->__get('countries');
    $user_id 		  = get_current_user_id();
    $country 		  = esc_attr( get_the_author_meta( 'primary_country', $user_id ) );
    $alert 			  = esc_attr( get_the_author_meta( 'primary_argent_alert', $user_id ) );
    $secondarycountry = esc_attr( get_the_author_meta( 'secondary_country', $user_id ) );
    $secondaryalert   = esc_attr( get_the_author_meta( 'secondary_argent_alert', $user_id ) );

    $pcountry         = get_the_author_meta("primary_country",$user_id);
    $paddress1        = get_the_author_meta("primary_address_line1",$user_id);
    $paddress2        = get_the_author_meta("primary_address_line2",$user_id);
    $pcity            = get_the_author_meta("primary_city",$user_id);
    $pstate           = get_the_author_meta("primary_state",$user_id);
    $ppostCode        = get_the_author_meta("primary_postcode",$user_id);

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
        $pcity = '<br>'.$pcity.' City, ';
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

    $scountry        = get_the_author_meta("secondary_country",$user_id);
    $saddress1       = get_the_author_meta("secondary_address_line1",$user_id);
    $saddress2       = get_the_author_meta("secondary_address_line2",$user_id);
    $scity           = get_the_author_meta("secondary_city",$user_id);
    $sstate          = get_the_author_meta("secondary_state",$user_id);
    $spostCode       = get_the_author_meta("secondary_postcode",$user_id);

    foreach ($countries as $key => $value) {
        if (!empty($scountry)) {
            if ($scountry == $key) {
                $scountry = '<br>'.$value;
                break;
            }
        }else
            break;
    }
    if (!empty($saddress1)) {
        $saddress1 .= ' ';
    }
    if (!empty($saddress2)) {
        $saddress2 .= ' ';
    }
    if (!empty($scity)) {
        $scity = '<br>'.$scity.' City, ';
    }elseif (!empty($saddress2)) {
        $saddress2 .= '<br>';
    }elseif (!empty($saddress1)) {
        $saddress1 .= '<br>';
    }else{
        $saddress1 = '<br>';
    }
    if (!empty($sstate)) {
        $sstate .= ' ';
    }
    if (!empty($spostCode)) {
        $spostCode .= ' ';
    }

    $paddress   = $paddress1.$paddress2.$pcity.$pstate.$ppostCode.$pcountry;
    $saddress   = $saddress1.$saddress2.$scity.$sstate.$spostCode.$scountry;

    $primaryPhoneNumberCode = get_the_author_meta("primary_phone_country_code", $user_id);
    $primaryPhoneNumber = get_the_author_meta("primary_home_number",$user_id);
    if(!empty($primaryPhoneNumberCode) && !empty($primaryPhoneNumber)){
		$count = sizeof($countryPhoneCode);
		$i = 0;
		while ($i < $count) {
			if($countryPhoneCode[$i]->iso2 == $primaryPhoneNumberCode){
				$code = $countryPhoneCode[$i]->dialCode;
				$primaryPhoneNumber = "+".$code."-".$primaryPhoneNumber;
				break;
			}
			$i++;
		}
	}elseif (!empty($primaryPhoneNumber)) {
		$primaryPhoneNumber = "+1-".$primaryPhoneNumber;
	}

	$secondaryPhoneCode = get_user_meta($user_id, "secondary_phone_country_code", true);
	$secondaryCellCode = get_user_meta($user_id, "secondary_cell_country_code", true);

	$secondoryPhoneNumberCode = get_the_author_meta("primary_cell_country_code", $user_id);
    $secondoryPhoneNumber = get_the_author_meta("primary_cell_number",$user_id);
    if(!empty($secondoryPhoneNumberCode) && !empty($secondoryPhoneNumber)){
		$count = sizeof($countryPhoneCode);
		// print_r($countryPhoneCode);
		$i = 0;
		while ($i < $count) {
			if($countryPhoneCode[$i]->iso2 == $secondoryPhoneNumberCode){
				$code = $countryPhoneCode[$i]->dialCode;
				$secondoryPhoneNumber = "+".$code."-".$secondoryPhoneNumber;
				break;
			}
			$i++;
		}
	}elseif (!empty($secondoryPhoneNumber)) {
		$secondoryPhoneNumber = "+1-".$secondoryPhoneNumber;
	}


?>
<!-- <form class="woocommerce-EditAccountForm edit-account" action="" method="post" id="custom-woocommerce-owner-form"> -->
	<div class="contact-form">
		<div class="pp-tabs-wrap">
		    <div class="pp-tabs-nav">
		        <div class="view pp-tabs-nav-inner pp-tab-option-1 active">View</div>
		        <div class="view pp-tabs-nav-inner pp-tab-option-2">Edit</div>
		    </div>
		    <div class="pp-tabs-content pp-tab-content-1"  222333 style="display: block;">
		    	<div class="acc-blue-box">
					<div class="acc-blue-head">
						Primary Contact Information
						<div id="own-profile-edit" class="acc-edit">
                            <i class="fa fa-edit"></i> EDIT
                        </div>
					</div>
					<div class="acc-blue-content">
						<span><span><?php echo $user->first_name." ".$user->last_name; ?></span><br><span><?php echo $paddress; ?></span></span><br>
                        <span><strong>Email:</strong> <span><?php echo $user->user_email; ?></span></span><br>
                        <span><strong>Home Number:</strong> <span><?php echo $primaryPhoneNumber; ?></span><br><strong>Cell Number:</strong> <span><?php echo $secondoryPhoneNumber; ?></span></span><br>
                        <span><strong>Fax Number:</strong> <span><?php echo $user->primary_fax_number; ?></span></span><br>
                        <span><strong>Receive Urgent Alert:</strong> <span><?php echo ucfirst($alert); ?></span></span>
					</div>
				</div>
				<div class="acc-blue-box">
					<div class="acc-blue-head">
						Secondary Contact Information
						<div id="sec-profile-edit" class="acc-edit">
                            <i class="fa fa-edit"></i> EDIT
                        </div>
					</div>
					<div class="acc-blue-content">
						<span><span><?php echo get_the_author_meta("secondary_first_name",$user_id)." ".get_the_author_meta("secondary_last_name",$user_id); ?></span><br><span><?php echo ($saddress) ? $saddress:""; ?></span></span></br>
                        <span><strong>Email:</strong> <span><?php echo get_the_author_meta("secondary_email",$user_id); ?></span></span></br>
                        <span><strong>Home Number:</strong> <span><span class="phone-country-code" data-val="<?php echo $secondaryPhoneCode; ?>"></span><?php echo get_the_author_meta("secondary_home_number",$user_id); ?></span><br><strong>Cell Number:</strong> <span><span class="phone-country-code" data-val="<?php echo $secondaryCellCode; ?>"></span><?php echo get_the_author_meta("secondary_cell_number",$user_id); ?></span></span></br>
                        <span><strong>Receive Urgent Alert:</strong> <span><?php echo ucfirst($secondaryalert); ?></span></span>
					</div>
				</div>
				<div class="acc-blue-box">
					 <?php if(isset($_GET["cancel"])){ ?>
			            <form method="post" action="<?php echo get_the_permalink(); ?>">
			               <input type="hidden" name="action" value="delete_user_action">
			               <input type="submit" class="site-btn site-btn-red"  name="Cancel Account" value="Cancel Account ">
			              
			            </form>

			          
			            <br>
			        <?php } else { ?>

			                <a  id="request_cancle_user" class="site-btn site-btn-red" user-id="<?= get_current_user_id() ?>" href="#" > Request to cancel account <i class="fa a-caret-right"></i></a>
			                <!-- <?php echo do_shortcode("[plugin_delete_me /]"); ?> -->
			         
			        <?php } ?>
				</div>
		    </div>
		    <div class="pp-tabs-content pp-tab-content-2">    
		    <form name="editPassword" id="editPasd">	
				<div class="acc-blue-box change-password-email">
					<div class="acc-blue-head">
						Email / Password Change
					</div>
					<div class="acc-blue-content">

						<!-- <div class="field-wrap two-fields-wrap">
							<div class="field-div">
								<label for="account_first_name"><?php esc_html_e( '*First name:', 'woocommerce' ); ?></label>
								<input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="account_first_name" id="account_first_name" value="<?php echo esc_attr( $user->first_name ); ?>" />
							</div>
							<div class="field-div">
								<label for="account_last_name"><?php esc_html_e( '*Last name:', 'woocommerce' ); ?></label>
								<input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="account_last_name" id="account_last_name" value="<?php echo esc_attr( $user->last_name ); ?>" />
							</div>
						</div> -->
						<div class="field-wrap two-fields-wrap">
							<div class="field-div">
								<label for="password_current"><?php esc_html_e( '*Current Password', 'woocommerce' ); ?></label>
								<input type="password" class="woocommerce-Input woocommerce-Input--password input-text change-pass regular-text" name="password_current" id="password_current" />
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
								<label for="password_1"><?php esc_html_e( '*New Password', 'woocommerce' ); ?></label>
								<input type="password" class="woocommerce-Input woocommerce-Input--password input-text change-pass regular-text" name="password_1" id="password_1" />
							</div>
							<div class="field-div">
								<label for="password_current"></label>
								<div class="pass-strength">
									<div class="row">
										<div class="col-sm-12 mb-15">
											Password Strength:
											<span class="password-strength pull-right"><strong></strong></span>
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
								<label for="password_2"><?php esc_html_e( '*Confirm New Password:', 'woocommerce' ); ?></label>
								<input type="password" class="woocommerce-Input woocommerce-Input--password input-text change-pass regular-text" name="password_2" id="password_2" />
							</div>
							<div class="field-div">
								<label for="password_current"></label>
								<div class="pass-strength">
									<div class="row">
										<div class="col-sm-12 mb-15">
											Password Match:
											<span class="password-match pull-right"><strong>No</strong></span>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="field-wrap two-fields-wrap">
							<div class="field-div">
								<label for="account_email"><?php esc_html_e( '*Change Email Address:', 'woocommerce' ); ?></label>
								<input type="email" class="woocommerce-Input woocommerce-Input--email input-text change-pass regular-text" name="account_email" id="account_email" value="<?php echo esc_attr( $user->user_email ); ?>" />
							</div>
							<div class="field-notice col-sm-12 mb-15 clear">A valid e-mail address. All e-mails from the system will be sent to this address. The e-mail address is not made public and will only be used if you wish to receive a new password or wish to receive certain news or notifications by e-mail.</div>
						</div>
						<div class="field-wrap two-fields-wrap">
							<div class="field-div">
								<div class="field-notice">
									<p>To make your password stronger:</p>
									<ul>
										<li>Make it at least 6 characters</li>
										<li>Add lowercase letters</li>
										<li>Add uppercase letters</li>
										<li>Add numbers</li>
										<li>Add punctuation</li>
									</ul>
								</div>
							</div>
							<div class="field-div">
							</div>
						</div>


						<div class="field-wrap mt-15">
							<div class="field-div">
								<div class="text-center">
									<button type="button" class="button site-btn-red" id="change-email-password">
										Save
									</button>
								</div>
							</div>
						</div>				

					</div>
				</div>
			</form>	
				<div class="acc-blue-box change-primary-info">
					<div class="acc-blue-head">
						Primary Contact Information
					</div>
					<div class="acc-blue-content">
					<form id="primContact">	
						<div class="field-wrap two-fields-wrap">
							<div class="field-div">
								<label for="account_first_name"><?php esc_html_e( '*First name:', 'woocommerce' ); ?></label>
								<input type="text" class="woocommerce-Input woocommerce-Input--text input-text primary-info regular-text" name="account_first_name" id="account_first_name" value="<?php echo esc_attr( $user->first_name ); ?>" placeholder="First Name" />
							</div>
							<div class="field-div">
								<label for="account_last_name"><?php esc_html_e( '*Last name:', 'woocommerce' ); ?></label>
								<input type="text" class="woocommerce-Input woocommerce-Input--text input-text primary-info regular-text" name="account_last_name" id="account_last_name" value="<?php echo esc_attr( $user->last_name ); ?>" placeholder="Last Name" />
							</div>
						</div>
						<div class="field-wrap">
							<div class="field-div">
								<label>*Country</label>
								<select class="address-country country_select primary-info regular-text" name="primary_country" id="primary_country">
				                    <option>Select a Country</option>
				                    <?php foreach ($countries as $key => $value): 
				                        if ($country == $key) {
				                            echo '<option value="'.$key.'" selected>'.$value.'</option>';
				                        }else{
				                            echo '<option value="'.$key.'">'.$value.'</option>';
				                        }
				                    ?>
				                    <?php endforeach; ?>
				                </select>
							</div>
						</div>
						<div class="field-wrap two-fields-wrap">
		                    <div class="field-div">
		                        <label>*Address:</label>
		                        <input type="text" placeholder="Address Line 1" name="primary_address_line1" id="primary_address_line1" value="<?php echo esc_attr( get_the_author_meta( 'primary_address_line1', $user_id) ); ?>" class="regular-text primary-info" placeholder="Address line 1"/>
		                    </div>
		                    <div class="field-div">
		                        <label></label>
		                       <input type="text" placeholder="Address Line 2" name="primary_address_line2" id="primary_address_line2" value="<?php echo esc_attr( get_the_author_meta( 'primary_address_line2', $user_id ) ); ?>" class="regular-text primary-info" placeholder="Address line 2" />
		                    </div>
		                </div>
		                <div class="field-wrap two-fields-wrap">    
		                    <div class="field-div">
		                        <input type="text" placeholder="City" name="primary_city" id="primary_city" value="<?php echo esc_attr( get_the_author_meta( 'primary_city', $user_id ) ); ?>" class="regular-text primary-info" />
		                    </div>
		                    <div class="field-div">
		                        <div class="field-wrap two-fields-wrap">
		                            <div class="field-div">
		                            	<label style="display: none" class="statevalidate empty-label"></label>
		                                <select name="primary_state" id="primary_state" data-val="<?php echo esc_attr( get_the_author_meta( 'primary_state', $user_id ) ); ?>"  value="<?php echo esc_attr( get_the_author_meta( 'primary_state', $user_id ) ); ?>" class="address-state regular-text primary-info" ></select>
		                            </div>
		                            <div class="field-div">
		                                <input type="text" placeholder="Zipcode" name="primary_postcode" id="primary_postcode" value="<?php echo esc_attr( get_the_author_meta( 'primary_postcode', $user_id ) ); ?>" class="regular-text primary-info" />
		                            </div>
		                        </div>                        
		                    </div>
		                </div>
						<div class="field-wrap two-fields-wrap">
							<div class="field-div">
								<label>*Home Number:</label>
								<input type="text" name="primary_home_number" id="primary_home_number" value="<?php echo esc_attr( get_the_author_meta( 'primary_home_number', $user_id ) ); ?>" class="regular-text primary-info phone-number" placeholder="1(555) 123-1234" />
								<input type="hidden" name="primary_home_number_code" value="<?php echo esc_attr( get_the_author_meta( 'primary_phone_country_code', $user_id ) ); ?>" class="regular-text primary-info" />
							</div>
							<div class="field-div">
								<label>Cell Number:</label>
								 <input type="text" name="primary_cell_number" id="primary_cell_number" value="<?php echo esc_attr( get_the_author_meta( 'primary_cell_number', $user_id ) ); ?>" class="regular-text primary-info phone-number" placeholder="1(555) 123-1234" />
								 <input type="hidden" name="primary_cell_number_code" value="<?php echo esc_attr( get_the_author_meta( 'primary_cell_country_code', $user_id ) ); ?>" class="regular-text primary-info" placeholder="1(555) 123-1234" />
							</div>
						</div>

						<div class="field-wrap two-fields-wrap">
							<div class="field-div">
								<label>Fax Number:</label>
								<input type="text" name="primary_fax_number" id="primary_fax_number" value="<?php echo esc_attr( get_the_author_meta( 'primary_fax_number', $user_id ) ); ?>" class="regular-text primary-info" placeholder="Fax Number" />
							</div>
							<div class="field-div primary-alert">
								<label>*Recieve Urgent Alerts?</label>
								<div class="field-div ">
									<div class="two-checks">
										<p>
											<input type="radio" name="primary_argent_alert" class="primary_argent_alert primary-info-check" value="yes" <?php if ($alert == 'yes') { echo "checked"; } ?> /> Yes
										</p>
										<p>
											<input type="radio" name="primary_argent_alert" class="primary_argent_alert primary-info-check" value="no" <?php if ($alert == 'no') { echo "checked"; } ?> /> No
										</p>
									</div>
								</div>
							</div>
						</div>

						<div class="field-wrap mt-15">
							<div class="field-div">
								<div class="text-center">
									<button type="button" class="button site-btn-red" id="change-primary-info">
										Save
									</button>
								</div>
							</div>
						</div>	
					</form>			

					</div>
				</div>

				<div class="acc-blue-box change-secondary-info">
					<div class="acc-blue-head">
						Secondary Contact Information
					</div>
					<form id="secContact">
					<div class="acc-blue-content">

						<div class="field-wrap two-fields-wrap">
							<div class="field-div">
								<label for="account_first_name"><?php esc_html_e( '*First name:', 'woocommerce' ); ?></label>
								<input type="text" name="secondary_first_name" id="secondary_first_name" value="<?php echo esc_attr( get_the_author_meta( 'secondary_first_name', $user->ID ) ); ?>" class="regular-text secondary-info" placeholder="First Name" />
							</div>
							<div class="field-div">
								<label for="account_last_name"><?php esc_html_e( '*Last name:', 'woocommerce' ); ?></label>
								<input type="text" name="secondary_last_name" id="secondary_last_name" value="<?php echo esc_attr( get_the_author_meta( 'secondary_last_name', $user->ID ) ); ?>" class="regular-text secondary-info" placeholder="Last Name" />
							</div>
						</div>

						<div class="field-wrap two-fields-wrap">
							<div class="field-div">
								<label>Email:</label>
								<input type="email" name="secondary_email" id="secondary_email" class="email secondary-info regular-text" value="<?php echo esc_attr( get_the_author_meta( 'secondary_email', $user->ID ) ); ?>" />
							</div>
							<div class="field-div">
								<label>*Country</label>
								<select class="country_select secondary-info regular-text address-country" name="secondary_country" id="secondary_country">
						            <?php foreach ($countries as $key => $value): ?>
						                <?php
						                if ($secondarycountry == $key) {
						                    echo '<option value="'.$key.'" selected>'.$value.'</option>';
						                }else{
						                    echo '<option value="'.$key.'">'.$value.'</option>';
						                }
						                ?>
						            <?php endforeach; ?>
						        </select>
							</div>
						</div>
						<div class="field-wrap two-fields-wrap">
		                    <div class="field-div">
		                        <label>*Address:</label>
		                        <input type="text" placeholder="Address Line 1" name="secondary_address_line1" id="secondary_address_line1" value="<?php echo esc_attr( get_the_author_meta( 'secondary_address_line1', $user_id) ); ?>" class="regular-text secondary-info" placeholder="Address Line 1"/>
        				    </div>
		                    <div class="field-div">
		                        <label></label>
		                       <input type="text" placeholder="Address Line 2" name="secondary_address_line2" id="secondary_address_line2" value="<?php echo esc_attr( get_the_author_meta( 'secondary_address_line2', $user_id ) ); ?>" class="regular-text secondary-info" placeholder="Address Line 2" />
		                    </div>
		                </div>
		                <div class="field-wrap two-fields-wrap">
		                    <div class="field-div">
		                        <input type="text" name="secondary_city" id="secondary_city" value="<?php echo esc_attr( get_the_author_meta( 'secondary_city', $user_id ) ); ?>" class="regular-text secondary-info" placeholder="City" />
		                    </div>
		                    <div class="field-div">
		                        <div class="field-wrap two-fields-wrap">
		                            <div class="field-div">
		                            	<label style="display: none" class="statevalidate empty-label"></label>
		                                <select data-val="<?php echo esc_attr( get_the_author_meta( 'secondary_state', $user_id ) ); ?>" placeholder="State" name="secondary_state" id="secondary_state" value="<?php echo esc_attr( get_the_author_meta( 'secondary_state', $user_id ) ); ?>" class="regular-text secondary-info address-state" ></select>
		                            </div>
		                            <div class="field-div">
		                                <input type="text" placeholder="Zipcode" name="secondary_postcode" id="secondary_postcode" value="<?php echo esc_attr( get_the_author_meta( 'secondary_postcode', $user_id ) ); ?>" class="regular-text secondary-info" placeholder="Zipcode" />
		                            </div>
		                        </div>                        
		                    </div>
		                </div>
						<div class="field-wrap two-fields-wrap">
							<div class="field-div">
								<label>*Home Number:</label>
								<input type="text" name="secondary_home_number" id="secondary_home_number" value="<?php echo esc_attr( get_the_author_meta( 'secondary_home_number', $user_id ) ); ?>" class="regular-text secondary-info phone-number" placeholder="1(555) 123-1234" />
								<input type="hidden" name="secondary_home_number_code" value="<?php echo esc_attr( get_the_author_meta( 'secondary_phone_country_code', $user_id ) ); ?>" class="regular-text secondary-info" placeholder="1(555) 123-1234" />
							</div>
							<div class="field-div">
								<label>Cell Number:</label>
								<input type="text" name="secondary_cell_number" id="secondary_cell_number" value="<?php echo esc_attr( get_the_author_meta( 'secondary_cell_number', $user_id ) ); ?>" class="regular-text secondary-info phone-number" placeholder="1(555) 123-1234" />
								<input type="hidden" name="secondary_cell_number_code" value="<?php echo esc_attr( get_the_author_meta( 'secondary_cell_country_code', $user_id ) ); ?>" class="regular-text secondary-info" placeholder="1(555) 123-1234" />
							</div>
						</div>

						<div class="field-wrap two-fields-wrap">
							<div class="field-div">
								<label>Fax Number:</label>
								<input type="text" name="secondary_fax_number" id="secondary_fax_number" value="<?php echo esc_attr( get_the_author_meta( 'secondary_fax_number', $user_id ) ); ?>" class="regular-text secondary-info" placeholder="Fax Number" />
							</div>
							<div class="field-div primary-alert">
								<label>*Recieve Urgent Alerts?</label>
								<div class="field-div ">
									<div class="two-checks">
										<p>
											<input type="radio" name="secondary_argent_alert" class="secondary_argent_alert secondary-info-check" value="yes" <?php if ($secondaryalert == 'yes') { echo "checked"; } ?> /> Yes
										</p>
										<p>
											<input type="radio" name="secondary_argent_alert" class="secondary_argent_alert secondary-info-check" value="no" <?php if ($secondaryalert == 'no') { echo "checked"; } ?> /> No
										</p>
									</div>
								</div>
							</div>
						</div>
					</form>
						<div class="field-wrap mt-15">
							<div class="field-div">
								<div class="text-center">
									<button type="button" class="button site-btn-red" id="change-secondary-info">
										Save
									</button>
								</div>
							</div>
						</div>			
					</div>
				</div>

				<?php do_action( 'woocommerce_edit_account_form' ); ?>
				<div class="text-right" id="saveAllBtn">
					<!-- <?php wp_nonce_field( 'save_account_details' ); ?> -->
					<button type="button" class="woocommerce-Button button site-btn-red" name="save_account_details" id="save-custom-woocommerce-owner-form" value="<?php esc_attr_e( 'Save', 'woocommerce' ); ?>"><?php esc_html_e( 'Save All', 'woocommerce' ); ?></button>
					<!-- <input type="hidden" name="action" value="save_account_details" /> -->
				</div>
			</div>
		</div>
	</form>
</div>

<script type="text/javascript">

/*Form handler start*/
jQuery(document).ready(function($) {
	var validator = $('form[name="editPassword"]').validate({
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


    // When the Upload button is clicked...
    $('body').on('click', '#change-email-password', function(e){
    	e.preventDefault();
        if($("#editPasd").valid()){
        var password1 = $("#password_1").val();
        var password2 = $("#password_2").val();
        if ($("#password_current").val() == "") {
        	var html = '<div class="alert alert-danger alert-dismissible mt-15"><a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">&times;</a>Current Password is not empty</div>';
        	$(".change-password-email .acc-blue-content .alert-danger").remove();
            $(".change-password-email .acc-blue-content .alert-success").remove();
            $(".change-password-email .acc-blue-content").append(html);
            return;
        }
        var rs 	= 0;
        var msg = '';
        if (password1 != "") {
        	var result = checkStrength(password1);
        	if (result.success) {
        		if (password1 != password2) {
        			rs 	= 1;
        			msg = 'New Password and Confirm New Password does not match.';
        		}
        	}else{
        		alert();
        		rs  = 1;
        		msg = 'The password strength should be at least Good.';
        	}
        }

        if (rs) {
        	var html = '<div class="alert alert-danger alert-dismissible mt-15"><a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">&times;</a>'+msg+'</div>';
        	$(".change-password-email .acc-blue-content .alert-danger").remove();
            $(".change-password-email .acc-blue-content .alert-success").remove();
            $(".change-password-email .acc-blue-content").append(html);
            return;
        }
	        var fd = new FormData();        
	
	        // Loop through each data and create an array file[] containing our files data.
	      	$.each($('#editPasd .change-pass'), function() {	
		           
	              fd.append($(this).attr('name'), $(this).val());		            
	        });
	        
	        // our AJAX identifier
	        fd.append('action', 'save_email_password'); 
	        console.log(fd);
	        if(fd != null){
	                
		      	$.ajax({
		            type: 'POST',
		            url: '<?php echo admin_url( 'admin-ajax.php' ); ?>',
		            data: fd,
		            contentType: false,
		            processData: false,
		            success: function(response){
		                console.log(response);// Append Server Response
		                var response = JSON.parse(response);
		                if (response.success == 1) {
		                	var html = '<div class="alert alert-success alert-dismissible mt-15"><a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">&times;</a><strong>Success!</strong> '+response.message+'</div>';
			                $(".change-password-email .acc-blue-content .alert-danger").remove();
			                $(".change-password-email .acc-blue-content .alert-success").remove();
			                $(".change-password-email .acc-blue-content").append(html);
			                //setTimeout(function(){ location.reload(); }, 1000);
		                }else{
		                	var html = '<div class="alert alert-danger alert-dismissible mt-15"><a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">&times;</a><strong>Sorry!</strong> '+response.message+'</div>';
		                	$(".change-password-email .acc-blue-content .alert-danger").remove();
			                $(".change-password-email .acc-blue-content .alert-success").remove();
			                $(".change-password-email .acc-blue-content").append(html);
		                }


		            }
		        });
	        }
	    }else{
	    	validator.focusInvalid();
	    }    
    });

var parimaryValidator = $('form[id="primContact"]').validate({
        		rules: {
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
	                         'action' : 'checkPrimaryExist',
	                         priary_phone: function()
	                         {
	                          return $('#primContact :input[name="primary_home_number"]').val();
	                         }
	                      }
	                    }
	                },
	                primary_cell_number: {minlength : 10,maxlength:10 },
	                primary_postcode : { minlength :5,maxlength:5,required :true },
	                primary_argent_alert: 'required',
	                password_1 : { minlength : 8, required: true,},
	                password_2: {minlength : 8, equalTo : "#password_1", required: true,},
	                primary_fax_number : { number :true	}
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
    $('body').on('click', '#change-primary-info', function(e){
        e.preventDefault();
        if($("#primContact").valid()){
        var fName 			= $("#account_first_name").val();
        var lName 			= $("#account_last_name").val();
        var country 		= $("#primary_country").val();
        var addressLine1 	= $("#primary_address_line1").val();
        var addressLine2 	= $("#primary_address_line2").val();
        var city 		 	= $("#primary_city").val();
        var state 		 	= $("#primary_state").val();
        var postCode 		= $("#primary_postcode").val();
        var phoneNumber 	= $("#primary_home_number").val();

        if (fName == '' && lName == '' && country == '' && addressLine1 == '' && addressLine2 == '' && city == '' && state == '' && postCode == '' && phoneNumber == '') {
        	var html = '<div class="alert alert-danger alert-dismissible mt-15"><a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">&times;</a>Please fill the all required fields.</div>';
        	$(".change-primary-info .acc-blue-content .alert-danger").remove();
            $(".change-primary-info .acc-blue-content .alert-success").remove();
            $(".change-primary-info .acc-blue-content").append(html);
            return;
        }

        var primfd = new FormData();
        
        // Loop through each data and create an array file[] containing our files data.
      	$.each($('#primContact .primary-info'), function() {	
        	
        	if ($(this).attr('name') == "primary_home_number_code") {
        			primfd.append('primary_phone_country_code', $(this).val());
        		}else if($(this).attr('name') == "primary_cell_number_code"){
        			primfd.append('primary_cell_country_code', $(this).val());
        		}else{
        			primfd.append($(this).attr('name'), $(this).val());	
        		}	            
        });
        $.each($('#primContact .primary-info-check'), function() {	
        	if ($(this).attr("checked") == "checked") {
        		primfd.append($(this).attr('name'), $(this).val());
        	}		            
        });
       // our AJAX identifier
        primfd.append('action', 'save_primary_info'); 
        console.log(primfd);
        if(primfd != null){
                
	      	$.ajax({
	            type: 'POST',
	            url: '<?php echo admin_url( 'admin-ajax.php' ); ?>',
	            data: primfd,
	            contentType: false,
	            processData: false,
	            success: function(response){
	                console.log(response);// Append Server Response
	                var response = JSON.parse(response);
	                if (response.success == 1) {
	                	var html = '<div class="alert alert-success alert-dismissible mt-15"><a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">&times;</a>'+response.message+'</div>';
		                $(".change-primary-info .acc-blue-content .alert-danger").remove();
		                $(".change-primary-info .acc-blue-content .alert-success").remove();
		                $(".change-primary-info .acc-blue-content").append(html);
		                setTimeout(function(){ location.reload(); }, 1000);
	                }else{
	                	var html = '<div class="alert alert-danger alert-dismissible mt-15"><a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">&times;</a>'+response.message+'</div>';
	                	$(".change-primary-info .acc-blue-content .alert-danger").remove();
		                $(".change-primary-info .acc-blue-content .alert-success").remove();
		                $(".change-primary-info .acc-blue-content").append(html);
	                }


	            }
	        });
        }
    }else{
	    parimaryValidator.focusInvalid();	
    }
    });

  		var secValidator = $('form[id="secContact"]').validate({
        rules: {
        		secondary_first_name: 'required',
        		secondary_last_name: 'required',
        		secondary_country: 'required',
                secondary_address_line1: 'required',
                secondary_home_number:{ required: true,
				       					minlength: 10,
				       					maxlength :10,	
				       					number :true },

                secondary_cell_number:{ minlength: 10,
                						maxlength :10,		
				       					number :true },
				zipcode :{
					minlength: 5,
                	maxlength :5,},	

                secondary_address_line1: 'required',
                secondary_argent_alert: 'required',
               
                },
                messages :{
                	secondary_home_number : {
                		minlength : "The phone number must be 10 digits.",
                        maxlength : "The phone number must be 10 digits.",
                    },
                    secondary_cell_number :{
                    	minlength : "The phone number must be 10 digits.",
                        maxlength : "The phone number must be 10 digits.",
                    },
                	zipcode : {
                		minlength : "The Zipcode must be 5 digits.",
                        maxlength : "The Zipcode must be 5 digits.",
                	},
                	secondary_fax_number: { number :true	},
                },
            submitHandler: function(form) {
            form.submit();
          }
        });

    $('body').on('click', '#change-secondary-info', function(e){
        e.preventDefault();
        if($("#secContact").valid()){
        var fName 			= $("#secondary_first_name").val();
        var lName 			= $("#secondary_last_name").val();
        var country 		= $("#secondary_country").val();
        var addressLine1 	= $("#secondary_address_line1").val();
        var addressLine2 	= $("#secondary_address_line2").val();
        var city 		 	= $("#secondary_city").val();
        var state 		 	= $("#secondary_state").val();
        var postCode 		= $("#secondary_postcode").val();
        var phoneNumber 	= $("#secondary_home_number").val();

        if (fName == '' && lName == '' && country == '' && addressLine1 == '' && addressLine2 == '' && city == '' && state == '' && postCode == '' && phoneNumber == '') {
        	var html = '<div class="alert alert-danger alert-dismissible mt-15"><a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">&times;</a>Please fill the all required fields.</div>';
        	$(".change-secondary-info .acc-blue-content .alert-danger").remove();
            $(".change-secondary-info .acc-blue-content .alert-success").remove();
            $(".change-secondary-info .acc-blue-content").append(html);
            return;
        }

        var fd = new FormData();
        
        // Loop through each data and create an array file[] containing our files data.
      	$.each($('#secContact .secondary-info'), function() {	
        	
        	fd.append($(this).attr('name'), $(this).val());		            
        });
        $.each($('#secContact .secondary-info-check'), function() {	
        	if ($(this).attr("checked") == "checked") {
        		fd.append($(this).attr('name'), $(this).val());
        	}		            
        });
        
        // our AJAX identifier
        fd.append('action', 'save_secondary_info'); 
        console.log(fd);
        if(fd != null){
                
	      	$.ajax({
	            type: 'POST',
	            url: '<?php echo admin_url( 'admin-ajax.php' ); ?>',
	            data: fd,
	            contentType: false,
	            processData: false,
	            success: function(response){
	                console.log(response);// Append Server Response
	                var response = JSON.parse(response);
	                if (response.success == 1) {
	                	var html = '<div class="alert alert-success alert-dismissible mt-15"><a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">&times;</a>'+response.message+'</div>';
		                $(".change-secondary-info .acc-blue-content .alert-danger").remove();
			            $(".change-secondary-info .acc-blue-content .alert-success").remove();
		                $(".change-secondary-info .acc-blue-content").append(html);
		                setTimeout(function(){ location.reload(); }, 1000);
	                }else{
	                	var html = '<div class="alert alert-danger alert-dismissible mt-15"><a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">&times;</a>Please fill the all required fields.</div>';
			        	$(".change-secondary-info .acc-blue-content .alert-danger").remove();
			            $(".change-secondary-info .acc-blue-content .alert-success").remove();
			            $(".change-secondary-info .acc-blue-content").append(html);
	                }


	            }
	        });
        }
    }else{
    	secValidator.focusInvalid();	
    }
    });

    $('body').on('click', '#save-custom-woocommerce-owner-form', function(e){
    	if($("#editPasd").valid() && $("#primContact").valid() && $("#secContact").valid()){

        e.preventDefault();

        // validation for Email/Password 
        var password1 = $("#password_1").val();
	    var password2 = $("#password_2").val();
        var rs 	= 0;
        var msg = '';
        if (password1 != "") {
	        if ($("#password_current").val() == "") {
	        	var html = '<div class="alert alert-danger alert-dismissible mt-15"><a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">&times;</a>If you change password or email, Current Password is not empty</div>';
	        	$(".pp-tab-content-2 .alert-danger").remove();
	            $(".pp-tab-content-2 .alert-success").remove();
	            $(".pp-tab-content-2").append(html);
	            return;
	        }
        	var result = checkStrength(password1);
        	if (result.success) {
        		if (password1 != password2) {
        			rs 	= 1;
        			msg = 'New Password and Confirm New Password does not match.';
        		}
        	}else{
        		rs  = 1;
        		msg = 'The password strength should be at least Good.';
        	}
        }

        if (rs) {
        	var html = '<div class="alert alert-danger alert-dismissible mt-15"><a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">&times;</a>'+msg+'</div>';
        	$(".pp-tab-content-2 .alert-danger").remove();
            $(".pp-tab-content-2 .alert-success").remove();
            $(".pp-tab-content-2").append(html);
            return;
        }

        // validation for primary contact info
        var fName 			= $("#account_first_name").val();
        var lName 			= $("#account_last_name").val();
        var country 		= $("#primary_country").val();
        var addressLine1 	= $("#primary_address_line1").val();
        var addressLine2 	= $("#primary_address_line2").val();
        var city 		 	= $("#primary_city").val();
        var state 		 	= $("#primary_state").val();
        var postCode 		= $("#primary_postcode").val();
        var phoneNumber 	= $("#primary_home_number").val();

        if (fName == '' && lName == '' && country == '' && addressLine1 == '' && addressLine2 == '' && city == '' && state == '' && postCode == '' && phoneNumber == '') {
        	var html = '<div class="alert alert-danger alert-dismissible mt-15"><a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">&times;</a>Please fill the all required fields.</div>';
        	$(".pp-tab-content-2 .alert-danger").remove();
            $(".pp-tab-content-2 .alert-success").remove();
            $(".pp-tab-content-2").append(html);
            return;
        }

        // validation for secondary contact info
        var fName 			= $("#secondary_first_name").val();
        var lName 			= $("#secondary_last_name").val();
        var country 		= $("#secondary_country").val();
        var addressLine1 	= $("#secondary_address_line1").val();
        var addressLine2 	= $("#secondary_address_line2").val();
        var city 		 	= $("#secondary_city").val();
        var state 		 	= $("#secondary_state").val();
        var postCode 		= $("#secondary_postcode").val();
        var phoneNumber 	= $("#secondary_home_number").val();

        if (fName == '' && lName == '' && country == '' && addressLine1 == '' && addressLine2 == '' && city == '' && state == '' && postCode == '' && phoneNumber == '') {
        	var html = '<div class="alert alert-danger alert-dismissible mt-15"><a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">&times;</a>Please fill the all required fields.</div>';
        	$(".pp-tab-content-2 .alert-danger").remove();
            $(".pp-tab-content-2 .alert-success").remove();
            $(".pp-tab-content-2").append(html);
            return;
        }

        var fd = new FormData();        
        
        // Loop through each data and create an array file[] containing our files data.
      	$.each($('.regular-text'), function() {	
        	
        	fd.append($(this).attr('name'), $(this).val());		            
        });
        $.each($('.primary-info-check'), function() {	
        	if ($(this).attr("checked") == "checked") {
        		fd.append($(this).attr('name'), $(this).val());
        	}		            
        });
        $.each($('.secondary-info-check'), function() {	
        	if ($(this).attr("checked") == "checked") {
        		fd.append($(this).attr('name'), $(this).val());
        	}		            
        });
        
        // our AJAX identifier
        fd.append('action', 'save_custom_woocommerce_owner_form'); 
        console.log(fd);
        if(fd != null){
                
	      	$.ajax({
	            type: 'POST',
	            url: '<?php echo admin_url( 'admin-ajax.php' ); ?>',
	            data: fd,
	            contentType: false,
	            processData: false,
	            success: function(response){
	                console.log(response);// Append Server Response
	                var response = JSON.parse(response);
	                if (response.success == 1) {
	                	var html = '<div class="alert alert-success alert-dismissible mt-15"><a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">&times;</a>'+response.message+'</div>';
		                $(".pp-tab-content-2 .alert-danger").remove();
            			$(".pp-tab-content-2 .alert-success").remove();
		                $(".pp-tab-content-2").append(html);
		                setTimeout(function(){ location.reload(); }, 1000);
	                }else{
	                	var html = '<div class="alert alert-danger alert-dismissible mt-15"><a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">&times;</a>'+response.message+'</div>';
		                $(".pp-tab-content-2 .alert-danger").remove();
            			$(".pp-tab-content-2 .alert-success").remove();
		                $(".pp-tab-content-2").append(html);
	                }


	            }
	        });
        }
    }else{
    	validator.focusInvalid();
    	parimaryValidator.focusInvalid();
    	secValidator.focusInvalid();
    }
    });
});
/*End form handler*/
</script>
<?php do_action( 'woocommerce_edit_account_form_end' ); ?>

<?php do_action( 'woocommerce_after_edit_account_form' ); ?>