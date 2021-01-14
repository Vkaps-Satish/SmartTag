<?php 

function checkAuthentication(){

	if ($_SERVER['CONTENT_TYPE'] != "application/json") {
		return json_encode(array("success"=>0,"message"=>"Please set the content type application/json."));
	}

	if ( !isset( $_SERVER['PHP_AUTH_USER'] ) ) {
		return json_encode(array("success"=>0,"message"=>"Please use the basic auth."));
	}

	$username = $_SERVER['PHP_AUTH_USER'];
	$password = $_SERVER['PHP_AUTH_PW'];
	$user 	  = get_user_by( 'email', $username );

	if (!$user || !wp_check_password( $password, $user->data->user_pass, $user->ID)) {
		return json_encode(array("success"=>0,"message"=>"Auth details are incorrect."));
	}elseif ($user->roles[0] != 'pet_professional') {
		return json_encode(array("success"=>0,"message"=>"Only Pet Professional can access this end point."));
	}else{
		return json_encode(array("success"=>1, "userID"=>$user->ID));
	}
}

function petImageUploadUrl($url,$petName){

 	$name 		= basename($url);
 	$type 		= explode('.', $name);
 	$typeArr 	= array('jpeg','jpg','png');

 	if (!isset($type[1]) || !in_array(strtolower($type[1]), $typeArr)) {
 		return json_encode(array("success"=>0, "message"=>"Only jpeg, jpg and png image url acceptable."));
 	}

 	$upload 	 = wp_upload_bits($petName.".".$type[1], null, file_get_contents($url));
    $filename 	 = $upload['file'];
    $wp_filetype = wp_check_filetype(basename( $filename ), null );

    if (strtolower($wp_filetype['ext']) == 'png' || strtolower($wp_filetype['ext']) == 'jpg' || strtolower($wp_filetype['ext']) == 'jpeg') {

        $wp_upload_dir = wp_upload_dir();
        $attachment = array(
            'guid'              => $wp_upload_dir['url'] . '/' . basename( $filename ),
            'post_mime_type'    => $wp_filetype['type'],
            'post_title'        => preg_replace( '/\.[^.]+$/', '', basename( $filename ) ),
            'post_content'      => '',
            'post_status'       => 'inherit'
        );

        $attach_id = wp_insert_attachment( $attachment, $filename);
        require_once(ABSPATH . 'wp-admin/includes/image.php');
        $attach_data = wp_generate_attachment_metadata( $attach_id, $filename );
        wp_update_attachment_metadata( $attach_id, $attach_data );
        return json_encode(array("success"=>1, "attachment"=>$attach_id)); 
    }else{
    	return json_encode(array("success"=>0, "message"=>"Only jpeg, jpg and png image url acceptable."));
    }		
}

function countryListForBabelBark($request){

	$countries_obj = new WC_Countries();
	$CountriesName = $countries_obj->__get('countries'); 
	return json_encode($CountriesName);
}

function stateListForBabelBark($request){

	$countries_obj = new WC_Countries();
	$CountriesName = $countries_obj->__get('countries'); 
	$state  	   = '';

	if (isset($request['country']) && !empty($request['country'])) {

		foreach ($CountriesName as $key => $value) {

			if ($key == strtoupper($request['country'])) {
				$state = $countries_obj->get_states( $key );
				break;
			}
		}
	}

	if (empty($state)) {
		$state = $countries_obj->get_states();
	}
	return json_encode($state);
}

function createUserWithPetProfileForBabelBark($request){

	$data 	   = $request;
	$check     = checkAuthentication();
	$checkAuth = json_decode($check,true);

	if (!$checkAuth['success']) {
		return $check;
	}else{
		$accountId = $checkAuth['userID'];
	}

	if (!isset($data['first_name']) || !isset($data['last_name']) || !isset($data['email']) || !isset($data['password']) || !isset($data['phone']) || empty(trim($data['first_name'])) || empty(trim($data['last_name'])) || empty(trim($data['email'])) || empty(trim($data['password'])) || empty(trim($data['phone'])) && !isset($data['pet_name']) && empty(trim($data['pet_name'])) && !isset($data['pet_type']) && empty(trim($data['pet_type'])) && !isset($data['pet_breed']) && empty(trim($data['pet_breed'])) && !isset($data['pet_primary_color']) && empty(trim($data['pet_primary_color'])) && !isset($data['pet_gender']) && empty(trim($data['pet_gender'])) && !isset($data['pet_birthday']) && empty(trim($data['pet_birthday'])) && !isset($data['pet_primary_image']) && empty(trim($data['pet_primary_image']))) {

		return json_encode(array("success"=>0,"message"=>"Please fill the all required fields."));
	}

	$fName 			= $data['first_name'];
	$lName 			= $data['last_name'];
	$emailAdd 		= $data['email'];
	$password       = $data['password'];
	$phone 			= $data['phone'];
	$petName 		= $data['pet_name'];
	$petType 		= $data['pet_type'];
	$petBreed 		= $data['pet_breed'];
	$petColor 		= $data['pet_primary_color'];
	$petGender 		= $data['pet_gender'];
	$petBirthday 	= $data['pet_birthday'];
	$petImage 		= $data['pet_primary_image'];
	$checkPhone		= phone_exists($phone);
	
	if (isset($data['microchip_id']) && !empty(trim($data['microchip_id']))) {
		$microchipId = $data['microchip_id'];

		if(!checkMicrochipIDPetProfile($microchipId)){
			return array("success"=>0,"message"=>"Microchip ID ".$microchipId." already used by another pet profile.");
		}
	}else{
		$microchipId = '';
	}
	
	if (isset($data['smart_tag_id']) && !empty(trim($data['smart_tag_id']))) {
		$smartTagId = $data['smart_tag_id'];

		if(!checkSmartIDTagPetProfile($smartTagId)){
			return array("success"=>0,"message"=>"SmartTag ID ".$smartTagId." already used by another pet profile.");
		}
	}else{
		$smartTagId = '';
	}
	
	if ($checkPhone['success']) {
		return json_encode(array("success"=>0,"message"=>"Phone number ".$phone." already used by another user."));
	}elseif (email_exists( $emailAdd )) {
		return json_encode(array("success"=>0,"message"=>"Email address ".$emailAdd." already used by another user."));
	}elseif (empty($microchipId) && empty($smartTagId)) {
		return json_encode(array("success"=>0,"message"=>"Please fill the all required fields."));
	}

	$attachment = json_decode(petImageUploadUrl($petImage,$petName),true);
	
	if ($attachment['success'] == 0) {
		return json_encode($attachment);
	}else{
		$attachId = $attachment['attachment'];
	}

	$newUserId = wp_create_user( $emailAdd, $password, $emailAdd );

	if ($newUserId) {
	    $newPost = array(
            'post_title'  => $petName,
            'post_status' => 'publish',        
            'post_type'   => 'pet_profile' ,       
            'post_author' => $newUserId
	    );

        $postId = wp_insert_post($newPost);

        update_post_meta($postId , 'smarttag_id_number', $smartTagId);
        update_post_meta($postId , 'microchip_id_number', $microchipId);
        update_post_meta($postId , 'pet_name', $petName);
        update_post_meta($postId , 'primary_breed', $petBreed);
        update_post_meta($postId , 'gender', $petGender);
        update_post_meta($postId , 'pet_type', $petType);
        update_post_meta($postId , 'primary_color', $petColor);
        update_post_meta($postId , 'pet_date_of_birth', $petBirthday);

        if (isset($data['pet_secondary_breed']) && empty(trim($data['pet_secondary_breed']))) {
        	update_post_meta($postId , 'secondary_breed', $data['pet_secondary_breed']);
        }

        if (isset($data['pet_secondary_color']) && empty(trim($data['pet_secondary_color']))) {
        	update_post_meta($postId , 'secondary_color', $data['pet_secondary_color']);
        }

        if (isset($data['pet_size']) && empty(trim($data['pet_size']))) {
        	update_post_meta($postId , 'size', $data['pet_size']);
        }

        set_post_thumbnail( $postId, $attachId );

		$user               = new stdClass();
        $user->ID           = $newUserId;
        $user->first_name   = $fName;
        $user->last_name    = $lName;
        $user->role			= 'customer';

        wp_update_user( $user );
        update_user_meta($newUserId,'created_by',$accountId);

        if (isset($data['street_address_1']) && !empty(trim($data['street_address_1']))) {
        	update_user_meta($newUserId,'primary_address_line1',$data['street_address_1']);
        }

        if (isset($data['street_address_2']) && !empty(trim($data['street_address_2']))) {
        	update_user_meta($newUserId,'primary_address_line2',$data['street_address_2']);
        }

        if (isset($data['city']) && !empty(trim($data['city']))) {
        	update_user_meta($newUserId,'primary_city',$data['city']);
        }

        if (isset($data['state']) && !empty(trim($data['state']))) {
        	update_user_meta($newUserId,'primary_state',$data['state']);
        }

        if (isset($data['postal_code']) && !empty(trim($data['postal_code']))) {
        	update_user_meta($newUserId,'primary_postcode',$data['postal_code']);
        }

        if (isset($data['country']) && !empty(trim($data['country']))) {
        	update_user_meta($newUserId,'primary_country',$data['country']);
        }

        if (isset($data['alternate_phone']) && !empty(trim($data['alternate_phone']))) {
        	update_user_meta($newUserId,'primary_cell_number',$data['alternate_phone']);
        }
        
        update_user_meta($newUserId,'primary_home_number',$phone);
       
        $result['success'] 		= 1;
        $result['message'] 		= "User and Pet profile registered successfully";
        $result['userId'] 		= $newUserId;
        $result['petProfileId']	= $postId;
        return json_encode($result);
	}else{
		return json_encode(array("success"=>0,"message"=>"User not created, please try again."));
	}

}

function updateUserForBabelBark($request){

	$data 	   = $request;
	$check     = checkAuthentication();
	$checkAuth = json_decode($check,true);

	if (!$checkAuth['success']) {
		return $check;
	}else{
		$accountId = $checkAuth['userID'];
	}

	if (!isset($data['email']) || empty(trim($data['email']))) {
		return json_encode(array("success"=>0,"message"=>"Please fill the all required fields."));
	}
	
	if (isset($data['phone']) && !empty($data['phone'])) {

		$checkPhone	= phone_exists($data['phone']);

		if ($checkPhone['success']) {
			return json_encode(array("success"=>0,"message"=>"Phone number ".$data['phone']." already used by another user."));
		}
	}

	$ownerUser 		= get_user_by( 'email', $data['email'] );

	if (!$ownerUser) {
		return json_encode(array("success"=>0,"message"=>"This email is not exist in our database."));
	}

	$ownerUserID 	= $ownerUser->ID;
	$createdBy 		= get_user_meta( $ownerUserID, 'created_by', true);
	$user       	= new stdClass();        

	if ($createdBy == $accountId) {

		if (isset($data['first_name']) && !empty(trim($data['first_name']))) {
			$user->ID   		= $ownerUserID;
			$fName 				= $data['first_name'];
			$user->first_name   = $fName;
			wp_update_user( $user );
		}

		if (isset($data['last_name']) && !empty(trim($data['last_name']))) {
			$user->ID   		= $ownerUserID;
			$lName 				= $data['last_name'];
			$user->last_name    = $lName;
			wp_update_user( $user );
		}

		if (isset($data['street_address_1']) && !empty(trim($data['street_address_1']))) {
			$streetAddress1 = $data['street_address_1'];
			update_user_meta($ownerUserID,'primary_address_line1',$streetAddress1);
		}

		if (isset($data['street_address_2']) && !empty(trim($data['street_address_2']))) {
			$streetAddress2	= $data['street_address_2'];
        	update_user_meta($ownerUserID,'primary_address_line2',$streetAddress2);
		}

		if (isset($data['city']) && !empty(trim($data['city']))) {
			$city = $data['city'];
			update_user_meta($ownerUserID,'primary_city',$city);
		}
        
        if (isset($data['state']) && !empty(trim($data['state']))) {
        	$state = $data['state'];
        	update_user_meta($ownerUserID,'primary_state',$state);
        }
        
        if (isset($data['postal_code']) && !empty(trim($data['postal_code']))) {
        	$postalCode = $data['postal_code'];
        	update_user_meta($ownerUserID,'primary_postcode',$postalCode);
        }

        if (isset($data['country']) && !empty(trim($data['country']))) {
        	$country = $data['country'];
        	update_user_meta($ownerUserID,'primary_country',$country);
        }
        
        if (isset($data['phone']) && !empty(trim($data['phone']))) {
        	$phone = $data['phone'];
        	update_user_meta($ownerUserID,'primary_home_number',$phone);
        }

        if (isset($data['alternate_phone']) && !empty(trim($data['alternate_phone']))) {
        	$alternatePhone = $data['alternate_phone'];
        	update_user_meta($ownerUserID,'primary_cell_number',$alternatePhone);
        }
        return json_encode(array("success"=>1,"message"=>"User info updated successfully."));
	}else{
		return json_encode(array("success"=>0,"message"=>"This user is not created by you, so you will not be able to update this user information."));
	}
}

function updatePetProfileForBabelBark($request){

	$data 	   = $request;
	$check     = checkAuthentication();
	$checkAuth = json_decode($check,true);

	if (!$checkAuth['success']) {
		return $check;
	}else{
		$accountId = $checkAuth['userID'];
	}

	if (isset($data['update_pet_microchip_id']) && !empty(trim($data['update_pet_microchip_id']))) {
		$microchipId = $data['update_pet_microchip_id'];
	}else{
		$microchipId = '';
	}

	if (isset($data['update_pet_smart_tag_id']) && !empty(trim($data['update_pet_smart_tag_id']))) {
		$smartTagId = $data['update_pet_smart_tag_id'];
	}else{
		$smartTagId = '';
	}

	if (empty($microchipId) && empty($smartTagId)) {
		return json_encode(array("success"=>0,"message"=>"Please fill the all required fields."));
	}

	if (isset($data['microchip_id'])) {
		return json_encode(array("success"=>0,"message"=>"Microchip id is already added so this field can't be update."));
	}elseif (isset($data['smart_tag_id'])) {
		return json_encode(array("success"=>0,"message"=>"SmartTag id is already added so this field can't be update."));
	}

	if (!empty($microchipId) && empty($smartTagId)) {
		$args=array(
	        'post_type' => 'pet_profile',
	        'post_status' => 'publish',
	        'posts_per_page' => 1,
	        'meta_query'=>array(
	            'relation' => 'AND',
	            array(
	                'key' => 'microchip_id_number',
	                'value' => $microchipId,
	            ),
	        )
        
	    );
	    $query = new WP_Query($args);
	    if ($query->have_posts()) {
	    	while( $query->have_posts() ) : $query->the_post();
	    		$userId  = get_the_author_meta('ID');
	    		$postId  = get_the_ID();
	    		$petName = get_the_title();
	    	endwhile;
	    }else{
	    	return json_encode(array("success"=>0,"message"=>"Microchip id ".$microchipId." is not registered into our database so please register this id."));
	    }
	}elseif (empty($microchipId) && !empty($smartTagId)) {
		$args=array(
	        'post_type' => 'pet_profile',
	        'post_status' => 'publish',
	        'posts_per_page' => 1,
	        'meta_query'=>array(
	            'relation' => 'AND',
	            array(
	                'key' => 'smarttag_id_number',
	                'value' => $smartTagId,
	            ),
	        )
        
	    );
	    $query = new WP_Query($args);
	    if ($query->have_posts()) {
	    	while( $query->have_posts() ) : $query->the_post();
				$userId  = get_the_author_meta('ID');
	    		$postId  = get_the_ID();
	    		$petName = get_the_title();
	    	endwhile;
	    }else{
	    	return json_encode(array("success"=>0,"message"=>"SmartTag id ".$smartTagId." is not registered into our database so please register this id."));
	    }
	}elseif (!empty($microchipId) && !empty($smartTagId)) {
		return json_encode(array("success"=>0,"message"=>"Either update_pet_smart_tag_id or update_pet_microchip_id field is required."));
	}

	$createdBy = get_user_meta( $userId, 'created_by', true);

	if ($accountId != $createdBy) {
		return json_encode(array("success"=>0,"message"=>"This pet profile is not created by you, so you will not be able to update this pet profile information."));
	}

    if (isset($data['pet_name']) && empty(trim($data['pet_name']))) {
    	$petName = $data['pet_name'];
    }

    if (isset($data['pet_primary_image']) && !empty(trim($data['pet_primary_image']))) {
		$attachment = json_decode(petImageUploadUrl($data['pet_primary_image'],$petName),true);
		
		if ($attachment['success'] == 0) {
			return json_encode($attachment);
		}else{
			$attachId = $attachment['attachment'];
			set_post_thumbnail( $postId, $attachId );
		}
	}

    update_post_meta($postId , 'pet_name', $petName);

    if (isset($data['smart_tag_id']) && !empty(trim($data['smart_tag_id']))) {
    	update_post_meta($postId , 'smarttag_id_number', $data['smart_tag_id']);
    }

    if (isset($data['microchip_id']) && !empty(trim($data['microchip_id']))) {
    	update_post_meta($postId , 'microchip_id_number', $data['microchip_id']);
    }

    if (isset($data['pet_type']) && !empty(trim($data['pet_type']))) {
		update_post_meta($postId ,'pet_type', $data['pet_type']);
    }

    if (isset($data['pet_breed']) && !empty(trim($data['pet_breed']))) {
		update_post_meta($postId , 'primary_breed', $data['pet_breed']);
    }

    if (isset($data['pet_primary_color']) && !empty(trim($data['pet_primary_color']))) {
		update_post_meta($postId , 'primary_color', $data['pet_primary_color']);
    }

	if (isset($data['pet_gender']) && !empty(trim($data['pet_gender']))) {
		update_post_meta($postId , 'gender', $data['pet_gender']);
    }


    if (isset($data['pet_birthday']) && !empty(trim($data['pet_birthday']))) {
		update_post_meta($postId , 'pet_date_of_birth', $data['pet_birthday']);
    }

    if (isset($data['pet_secondary_breed']) && !empty(trim($data['pet_secondary_breed']))) {
    	update_post_meta($postId , 'secondary_breed', $data['pet_secondary_breed']);
    }

    if (isset($data['pet_secondary_color']) && !empty(trim($data['pet_secondary_color']))) {
    	update_post_meta($postId , 'secondary_color', $data['pet_secondary_color']);
    }

    if (isset($data['pet_size']) && !empty(trim($data['pet_size']))) {
    	update_post_meta($postId , 'size', $data['pet_size']);
    }

    return json_encode(array("success"=>1,"message"=>"Pet profile info updated successfully."));
}

function addPetProfileExistingUser($request){
	$data 	   = $request;
	$check     = checkAuthentication();
	$checkAuth = json_decode($check,true);
	if (!$checkAuth['success']) {
		return $check;
	}else{
		$accountId = $checkAuth['userID'];
	}

	if (!isset($data['pet_name']) && empty(trim($data['pet_name'])) && !isset($data['pet_type']) && empty(trim($data['pet_type'])) && !isset($data['pet_breed']) && empty(trim($data['pet_breed'])) && !isset($data['pet_primary_color']) && empty(trim($data['pet_primary_color'])) && !isset($data['pet_gender']) && empty(trim($data['pet_gender'])) && !isset($data['pet_birthday']) && empty(trim($data['pet_birthday'])) && !isset($data['pet_primary_image']) && empty(trim($data['pet_primary_image'])) && !isset($data['email']) && empty(trim($data['email']))) {
		
		return json_encode(array("success"=>0,"message"=>"Please fill the all required fields."));
	}

	$ownerUser 		= get_user_by( 'email', $data['email'] );

	if (!$ownerUser) {
		return json_encode(array("success"=>0,"message"=>"This email is not exist in our database."));
	}

	$ownerUserID 	= $ownerUser->ID;
	$createdBy 		= get_user_meta( $ownerUserID, 'created_by', true);

	if ($accountId != $createdBy) {
		return json_encode(array("success"=>0,"message"=>"This user is not created by you, so you will not be able to update this user information."));
	}

	$petName 		= $data['pet_name'];
	$petType 		= $data['pet_type'];
	$petBreed 		= $data['pet_breed'];
	$petColor 		= $data['pet_primary_color'];
	$petGender 		= $data['pet_gender'];
	$petBirthday 	= $data['pet_birthday'];
	$petImage 		= $data['pet_primary_image'];
	
	if (isset($data['microchip_id']) && !empty(trim($data['microchip_id']))) {
		$microchipId = $data['microchip_id'];

		if(!checkMicrochipIDPetProfile($microchipId)){
			return json_encode(array("success"=>0,"message"=>"Microchip ID ".$microchipId." already used by another pet profile."));
		}
	}else{
		$microchipId = '';
	}
	
	if (isset($data['smart_tag_id']) && !empty(trim($data['smart_tag_id']))) {
		$smartTagId = $data['smart_tag_id'];

		if(!checkSmartIDTagPetProfile($smartTagId)){
			return json_encode(array("success"=>0,"message"=>"SmartTag ID ".$smartTagId." already used by another pet profile."));
		}
	}else{
		$smartTagId = '';
	}

	if (empty($microchipId) && empty($smartTagId)) {
		return json_encode(array("success"=>0,"message"=>"Please fill the all required fields."));
	}

	$attachment = json_decode(petImageUploadUrl($petImage,$petName),true);
	
	if ($attachment['success'] == 0) {
		return json_encode($attachment);
	}else{
		$attachId = $attachment['attachment'];
	}

	$newPost = array(
        'post_title'  => $petName,
        'post_status' => 'publish',        
        'post_type'   => 'pet_profile' ,       
        'post_author' => $ownerUserID
    );

    $postId = wp_insert_post($newPost);

    update_post_meta($postId , 'smarttag_id_number', $smartTagId);
    update_post_meta($postId , 'microchip_id_number', $microchipId);
    update_post_meta($postId , 'pet_name', $petName);
    update_post_meta($postId , 'primary_breed', $petBreed);
    update_post_meta($postId , 'gender', $petGender);
    update_post_meta($postId , 'pet_type', $petType);
    update_post_meta($postId , 'primary_color', $petColor);
    update_post_meta($postId , 'pet_date_of_birth', $petBirthday);

    if (isset($data['pet_secondary_breed']) && empty(trim($data['pet_secondary_breed']))) {
    	update_post_meta($postId , 'secondary_breed', $data['pet_secondary_breed']);
    }

    if (isset($data['pet_secondary_color']) && empty(trim($data['pet_secondary_color']))) {
    	update_post_meta($postId , 'secondary_color', $data['pet_secondary_color']);
    }

    if (isset($data['pet_size']) && empty(trim($data['pet_size']))) {
    	update_post_meta($postId , 'size', $data['pet_size']);
    }

    set_post_thumbnail( $postId, $attachId );

    $result['success'] 		= 1;
    $result['message'] 		= "Pet profile registered successfully";
    $result['petProfileId']	= $postId;
    return json_encode($result);
}

add_action('rest_api_init', function () {

  	register_rest_route( 'babelbark/v1', 'country',array(
        'methods'  => 'GET',
        'callback' => 'countryListForBabelBark'
    ));
});

add_action('rest_api_init', function () {

  	register_rest_route( 'babelbark/v1', 'state/(?P<country>)',array(
        'methods'  => 'GET',
        'callback' => 'stateListForBabelBark'
    ));
});

add_action('rest_api_init', function () {

  	register_rest_route( 'babelbark/v1', 'state',array(
        'methods'  => 'GET',
        'callback' => 'stateListForBabelBark'
    ));
});

add_action('rest_api_init', function () {

  	register_rest_route( 'babelbark/v1', 'create',array(
        'methods'  => 'POST',
        'callback' => 'createUserWithPetProfileForBabelBark',
    ));
});

add_action('rest_api_init', function () {

  	register_rest_route( 'babelbark/v1', 'update-user',array(
        'methods'  => 'PUT',
        'callback' => 'updateUserForBabelBark',
    ));
});

add_action('rest_api_init', function () {

  	register_rest_route( 'babelbark/v1', 'update-pet-profile',array(
        'methods'  => 'PUT',
        'callback' => 'updatePetProfileForBabelBark',
    ));
});

add_action('rest_api_init', function () {

  	register_rest_route( 'babelbark/v1', 'add-pet-profile',array(
        'methods'  => 'POST',
        'callback' => 'addPetProfileExistingUser',
    ));
});