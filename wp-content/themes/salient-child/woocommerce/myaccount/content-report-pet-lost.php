<?php 
if (isset($_POST['reportMyPetLost'])) {
	$checkForLost = checkSmartIDTag(1,'lost_found_pets','pet_status','smarttag_id_number',$_POST['smarttag_id_number']);
	if ($checkForLost) {

		$title    = $_POST['title'];     
		$phone    = $_POST['contact'];  

		$address = $_POST['address_line'];

		$current_user = wp_get_current_user();
		$user_id  = $current_user->ID; 

		$fax      = get_user_meta($user_id, "primary_fax_number",true );
		$email    = $current_user->user_email;  
		$idTag    = $_POST['smarttag_id_number'];
		$postid   = $_POST['id'];
		/*lostPetEmail*/

		$checkForFound = checkSmartIDTag(0,'lost_found_pets','pet_status','smarttag_id_number',$_POST['smarttag_id_number']);
		if ($checkForFound) {


			$new_post = array(
				'post_title'   => $title,
				'post_status'  => 'publish',
				'post_type'    => 'lost_found_pets',
			);

			$post_id = wp_insert_post($new_post);
			update_post_meta($post_id,'source_system','SMARTTAG');
			lostPetEmail($idTag , $postid, $phone, $fax , $email ,$address);
               // print_r($new_post);
			foreach ($_POST as $key => $value) {
				if ($key != 'id' || $key != 'title' || $key != 'attach_id' || $key != 'reportMyPetLost') {
					update_post_meta($post_id,$key,$value);
				}
			}
			if (isset($_POST['attach_id']) && !empty($_POST['attach_id'])) {
				set_post_thumbnail($post_id,$_POST['attach_id']);
			}
			$currentDate = date( 'Y:m:d H:i:s' );
			update_post_meta($postid,'last_modified_date',$currentDate);
			update_post_meta($_POST['id'],'last_lost_date',$currentDate);
		}else{
			$smarttagid = $_POST['smarttag_id_number'];
			$args=array(
				'post_type' => 'lost_found_pets',
				'post_status' => 'publish',

				'meta_query'=>array(
					'relation' => 'AND',
					array(
						'key' => 'smarttag_id_number',
						'value' => $smarttagid,
					),
					array(
						'key' => 'pet_status',
						'value' => 0,
					),
				)
			);
			$query = new WP_Query($args);
			while ( $query->have_posts() ) : $query->the_post();
				$postid = get_the_id();
				foreach ($_POST as $key => $value) {
					if ($key != 'id' || $key != 'title' || $key != 'attach_id' || $key != 'reportMyPetLost') {
						update_post_meta($postid,$key,$value);
					}
				}
				if (isset($_POST['attach_id']) && !empty($_POST['attach_id'])) {
					set_post_thumbnail($postid,$_POST['attach_id']);
				}
				$currentDate = date( 'Y:m:d H:i:s' );
				update_post_meta($postid,'last_modified_date',$currentDate);
				update_post_meta($_POST['id'],'last_lost_date',$currentDate);
			endwhile;   
		}
		echo "<p>Your lost pet will be posted to our Lost & Found Pets page.</p>
		<p>SmartTag and your local shelters have been notified. If your local shelters find your pet you will be contacted by them or SmartTag.</p>
		<p>Please call us at anytime if you have any questions: (888) 379-8880</p>";
	}else{
		echo "<p>Your lost pet will be Already Reported for Lost.</p>
		<p>SmartTag and your local shelters have been notified. If your local shelters find your pet you will be contacted by them or SmartTag.</p>
		<p>Please call us at anytime if you have any questions: (888) 379-8880</p>";
	}
}elseif (isset($_GET['pet_id'])) {
	$currentUserId  = get_current_user_id();
	$postId         = $_GET['pet_id'];
	$userId         = get_post_field( 'post_author', $postId );
	if ($currentUserId != $userId) {
	    echo '<div class="not-found-text width-100">You are not authorized, as you are not the owner of the pet.</div>';
	}else{
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
			?>
			<h3>Report Pet as Lost:</h3>
			<div class="row">
				<div class="col-sm-3 rmb-15">
					<?php echo get_the_post_thumbnail(); ?>
				</div>
				<div class="col-sm-9">
					<strong>Pet Name:</strong> <span class="name"><?php echo get_the_title(); ?></span>
					<br>
					<strong>Pet Type:</strong> <?php 

					$typeObj = get_term_by( 'id', $pet_type , 'pet_type_and_breed' );

					echo $quantityTermName = $typeObj->name;
					?>
					<br>
					<strong>IDTag Serial Number:</strong> <span class="name"><?php echo $mypod->display('smarttag_id_number'); ?></span>
				</div>
			</div>
		<?php endwhile;
		?>
		<div class="contact-form">
			<form class="lost-pet-form" name="lostPet-form" action="" method="post">
				<input type="hidden" name="id" value="<?php echo $postId; ?>">
				<input type="hidden" name="title" value="<?php echo $title; ?>">
				<input type="hidden" name="smarttag_id_number" value="<?php echo $smarttagid; ?>">
				<input type="hidden" name="pet_type" value="<?php echo $pet_type; ?>">
				<input type="hidden" name="primary_breed" value="<?php echo $primary_breed; ?>">
				<input type="hidden" name="secondary_breed" value="<?php echo $secondary_breed; ?>">
				<input type="hidden" name="primary_color" value="<?php echo $primary_color; ?>">
				<input type="hidden" name="secondary_color" value="<?php echo $secondary_color; ?>">
				<input type="hidden" name="gender" value="<?php echo $gender; ?>">
				<input type="hidden" name="size" value="<?php echo $size; ?>">
				<input type="hidden" name="pet_date_of_birth" value="<?php echo $pet_date_of_birth; ?>">
				<input type="hidden" name="attach_id" value="<?php echo $post_thumbnail_id; ?>">
				<div class="lost-pet">
					<div class="field-wrap two-fields-wrap">
						<div class="field-div">
							<label>*Pet was lost on</label>
							<input type="text" name="pet_lost_date" id="pet-dob1" value="" placeholder="mm/dd/yyyy">
						</div>
						<div class="field-div">
							<label>Select country of residence:</label>
							<?php 
							$countries_obj = new WC_Countries();
							$countries = $countries_obj->__get('countries');
							echo '<select name="country" class="address-country">';
							echo '<option value="">Select Country</option>';
							foreach ($countries as $key => $value) {

								echo '<option value="'.$key.'" >'.$value.'</option>';
							}
							echo '</select>';
							?>
						</div>
					</div>
					<div class="field-wrap two-fields-wrap">
						<div class="field-div">
							<label>Address:</label>
							<input type="text" name="address_line" value="" placeholder="Address Line 1">
						</div>
						<div class="field-div">
							<label></label>
							<input type="text" name="address_line_2" value="" placeholder="Address Line 2">
						</div>
					</div>
					<div class="field-wrap two-fields-wrap">
						<div class="field-div">
							<input type="text" name="city" value="" placeholder="City">
						</div>
						<div class="field-div">
							<div class="field-wrap two-fields-wrap">
								<div class="field-div">
									<label class="statevalidate empty-label" style="display: none"></label>
									<select class="address-state" name="state" data-val=""></select>
								</div>
								<div class="field-div">
									<input type="text" name="zip_code" value="" placeholder="Zip Code">
								</div>
							</div>
						</div>
					</div>
					<div class="field-wrap">
						<div class="field-div">
							<label>Notes: (Optional)</label>
							<textarea name="description" placeholder="Write any notes that will helpful for finding your pet..."></textarea>
						</div>
					</div>
					<div class="field-wrap two-fields-wrap">
						<div class="field-div">
							<label>*Reward:</label>
							<input type="text" name="reward" placeholder="Enter reward amount">
						</div>
						<div class="field-div">
							<label>*Contact Phone Number:</label>
							<input type="text" name="contact" placeholder="1 (555) 123-1234">
						</div>
					</div>
					<div class="field-wrap">
						<div class="field-div mb-15">
							<label>By clicking “Report as a Lost Pet”:</label>
							<p>The lost pet’s information and the information entered on this page will be posted to SmartTag’s “<a href="<?= site_url('/lost-and-found-pets/');?>">Lost & Found Pets</a>” webpage.</p>
						</div>
					</div>
					<div class="field-wrap two-fields-wrap">
						<input type="hidden" name="pet_status" value="1">
						<div class="field-div">
							<a href="<?php echo get_site_url(); ?>/my-account/report-my-pet-lost/" class="site-btn site-btn-grey">Back</a>
						</div>
						<div class="field-div text-right">
							<input type="submit" name="reportMyPetLost" value="Report as a Lost Pet" class="site-btn-red">
						</div>
					</div>
				</div>
			</form>
		</div>
		<script type="text/javascript">
			jQuery(document).ready(function($) {
				$("#pet-lost-date").datepicker({
					dateFormat : "mm/dd/yy"
				});
			});
		</script>
	<?php }
}