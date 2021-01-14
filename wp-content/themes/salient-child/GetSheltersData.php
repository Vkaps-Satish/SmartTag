<?php /* Template Name: GetSheltersData */ 

// $data = get_user_by('roles', 'Customer');
 // $data = get_userdata(2);
$data = get_user_meta(2);
echo "<pre>";
print_r($data);
?>
