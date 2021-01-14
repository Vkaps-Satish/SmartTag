<?php 

function checkAuthentication1(){
// echo "string";die;
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
	}else{
		return json_encode(array("success"=>1, "userID"=>$user->ID));
	}
}



/*Function to search microchip from DB*/
function searchMicrochipNumber($request)
{
	$check_auth  = checkAuthentication1();
	$checkAuth = json_decode($check_auth,true);
	if (!$checkAuth['success']) {
		return $checkAuth;
	}else{
		$accountId = $checkAuth['userID'];
	}
	$data = $request;
	if (isset($data['microchip_id']) && !empty(trim($data['microchip_id']))) {
		if(!checkMicrochipIDPetProfile($data['microchip_id']) && !checkMicrochipIDOwner($data['microchip_id'])){
			$response = array("registered"=> true ,"hasOwnerInfo" => true, "lastUpdated" => "2015-05-18");
			return json_encode($response);
			
		}
		elseif(!checkMicrochipIDPetProfile($data['microchip_id']) && checkMicrochipIDOwner($data['microchip_id']))
		{
			$response = array("registered"=> true ,"hasOwnerInfo" => false, "lastUpdated" => "2015-05-18");
			return json_encode($response);
			
		}
		elseif(checkMicrochipIDPetProfile($data['microchip_id']) && !checkMicrochipIDOwner($data['microchip_id']))
		{
			$response = array("registered"=> false ,"hasOwnerInfo" => false, "lastUpdated" => "2015-05-18");
			return json_encode($response);
			
		}
		else{
			$response = array("registered"=> false ,"hasOwnerInfo" => false, "lastUpdated" => "2015-05-18");
			return json_encode($response);
		}
	}
	
}


/*Registeration all API  */

add_action('rest_api_init', function () {

  	register_rest_route( 'aaha/v1', 'search-microchip-number',array(
        'methods'  => 'GET',
        'callback' => 'searchMicrochipNumber'
    ));

});

