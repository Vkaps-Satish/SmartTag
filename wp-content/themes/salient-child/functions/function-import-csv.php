<?php 
function importPetProfileAndOwner(){

	$csvData    = array_map('str_getcsv', file(__DIR__."/../../../../petAndOwnerProfileImport.csv"));
	$csvHeader  = $csvData[0];
	$csvHeader  = array_map('trim',$csvHeader);
	unset($csvData[0]);
	$finalDatas = array();

	foreach($csvData as $row){
	    $row  = array_map('trim',$row);
	    array_push($finalDatas,array_combine($csvHeader, $row));
	}

	// print_r($finalDatas);

	if(!empty($finalDatas)){
		foreach ($finalDatas as $key => $finalData) {
			$args=array(
		        'post_type' => 'pet_profile',
		        'post_status' => 'publish',
		        'meta_query'=>array(
		            array(
		                'key' => 'idtag_id',
		                'value' => $finalData['Pet_Unique_ID'],
		            )
		        )
		    );
		    $query = new WP_Query($args);
		    if($query->have_posts()){
			    while( $query->have_posts() ) : $query->the_post();

			    endwhile;
			}else{
				// $newPost = array(
			 //        'post_title'  => $finalData['Pet_Name'],
			 //        'post_status' => 'publish',        
			 //        'post_type'   => 'pet_profile'
			 //    );
			 //    if($finalData['Pets_Gender'] == "F"){
			 //    	$gender = "female";
			 //    }else{
			 //    	$gender = "male";
			 //    }
			 //    $postId = wp_insert_post($newPost);
			 //    update_post_meta($postId, "primary_color", $finalData['Pets_Color']);
			 //    update_post_meta($postId, "secondary_color", $finalData['Pets_Seconday_Color']);
			 //    update_post_meta($postId, "pet_date_of_birth", $finalData['Pets_Birthday']);
			 //    update_post_meta($postId, "gender", $gender);
			 //    update_post_meta($postId, "microchip_id_number", $finalData['Pets_Microchip_Number']);
			}
		}
	}
}

add_action("init", "importPetProfileAndOwner");