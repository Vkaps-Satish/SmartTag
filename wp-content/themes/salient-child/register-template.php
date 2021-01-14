<?php 

/* template name: Home - Register User Template */
get_header(); ?>

<?php $options = get_nectar_theme_options();  ?>
<?php global $current_user;
	$createdBy = $current_user->data->user_login;
	echo $test = hasBoughtIDTag('microchip-57179473');
if (isset($_POST['primary_home_number'])) {
	# update_usermeta
	// print_r($current_user);
	$phone 		= $_POST['primary_home_number'];
	$email 		= $_POST['p_email'];
	$username 	= $_POST['user_login'];

	if (phone_exists($phone)) {
		echo "This Primary Phone Number is already used by another user, please enter other number";
	}elseif(email_exists( $email )){
		echo "This Email is already used, please enter other user name";
	}else{
		$user_id = wp_create_user( $email, $_POST['password'], $email );
		/*$user = new WP_User($user_id);
		$user->set_role('wholeseller');*/

		$user               = new stdClass();
	    $user->ID           = $user_id;
	    $user->first_name   = $_POST['p_fst_name'];
	    $user->last_name    = $_POST['p_lst_name'];
	    $user->role    		= 'wholeseller';
	    wp_update_user( $user );
		update_user_meta($user_id,'created_by',$createdBy);
	}
}
if (is_user_logged_in() && $current_user->roles[0]=='administrator') { ?>
	<section class="content-section register-microchip-section">
		<form action="" method="post">
			<div class="contact-form" id="cus-info"> 
				<div class="field-wrap">
					<div class="field-div">
						<label>*User Name: </label>
						<input type="text" name="user_login" placeholder="Enter user name" class="user-data" />
					</div>
				</div>
				<div class="field-wrap two-fields-wrap">
					<div class="field-div">
						<label>*First Name: </label>
						<input type="text" name="p_fst_name" placeholder="First Name" class="user-data" id="u-first"/>
					</div>
					<div class="field-div">
						<label>*Last Name: </label>
						<input type="text" name="p_lst_name" placeholder="Last Name" class="user-data" id="u-last" />
					</div>
				</div>
				<div class="field-wrap two-fields-wrap">
					<div class="field-div">
						<label>*Email: </label>
						<input type="text" name="p_email" placeholder="Enter color of pet" class="user-data" id="u-email" />
					</div>
					<div class="field-div">
						<label>*Password: </label>
						<input type="password" name="password" placeholder="Enter Password" class="user-data" />
					</div>							
				</div>
				<div class="field-wrap">
					<div class="field-div">
						<label>*Select Your Country: </label>
						<input type="text" name="p_country" placeholder="Enter color(s) of pet" class="user-data" />
					</div>
				</div>
				<div class="field-wrap two-fields-wrap">							
					<div class="field-div">
						<label>*Address: </label>
						<input type="text" name="p_add1" placeholder="Address line 1" class="user-data" id="u-add1"/>
						<input type="text" name="p_city" placeholder="City" class="user-data" id="u-city1" />
					</div>
					<div class="field-div">
						<label></label>
						<input type="text" name="p_add2" placeholder="Address line 2" class="user-data" id="u-add2"/>
						<div class="field-wrap two-fields-wrap">
							<div class="field-div">
								<select name="p_state" class="user-data" id="u-state">
									<option>State1</option>
									<option>State2</option>
									<option>State3</option>
								</select>
							</div>
							<div class="field-div">
								<input type="text" name="p_zipcode" placeholder="Zipcode" class="user-data" id="u-zip" />
							</div>
						</div>
					</div>
				</div>
				<div class="field-wrap two-fields-wrap">
					<div class="field-div">
						<label>*Primary Phone Number: </label>
						<input type="text" name="primary_home_number" placeholder="1(555) 123-1234" class="user-data" id="p-phone" />
					</div>
					<div class="field-div">
						<label>Secondary Phone Number: </label>
						<input type="text" name="p_sec_no" placeholder="1(555) 123-1234" class="user-data" id="ps-phone" />
					</div>
				</div>
			</div>
			<div class="step-btns">
				<button class="btn btn-default btn-next" type="submit" aria-controls="step-3" name="submit">submit <i class="fa fa-caret-right"></i></button>
			</div>
		</form>
	</section>
<?php } ?>
<?php get_footer(); ?>