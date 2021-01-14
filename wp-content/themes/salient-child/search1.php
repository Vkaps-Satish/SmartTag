<?php 
/*
* Template Name: Search Registry1
*/
 // print_r(get_user_meta(15576, $key, $single)); die;

get_header(); 

// echo "<img src='https://idtag.agiliscloud.com/wp-content/themes/salient-child/images/back/pink-heart-back.png'>";
// echo get_site_url();
// echo "<img src='https://idtag.agiliscloud.com/wp-content/themes/salient-child/images/back/pink-heart-back.png'>";
// die;

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
    $id = get_current_user_id();

    $petProfileId =array();
    $args=array(
        'post_type' => 'pet_profile',
        'post_status' => 'publish',
        'posts_per_page' => -1,
        'author'      => $id ,
    );
    $query = new WP_Query($args);
?>
<!-- <script type="text/javascript">
    jQuery(document).ready(function($){
        $(".date-picker").datepicker({
            dateFormat : "mm/dd/yy"
        });
    });
</script> -->
<div class="container-wrap">
    <div class="container main-content">
        <div class="row">
            <div class="woo-sidebar col-sm-3">
             <!-- <h3 class="widgettitle">Pet Professional</h3> -->
                <?php //echo do_shortcode("[wpb_childpages]");?>
                <?php echo do_shortcode("[stag_sidebar id='pet-professional-sidebar']"); ?>
                &nbsp;
                <?php echo do_shortcode("[stag_sidebar id='main-sidebar']"); ?>
            </div>
            <div class="woo-content col-sm-9" id="woo-content">
                <div class="site-tabs-wrap">
                    <p id="existing_info"></p>

                    <?php if (isset($_POST['transferOwner']) && !empty($_POST['transferOwner'])) { 
                        ?>
                        <div class="page-heading heading-right-link">
                            <h1>Search Registry</h1>
                            <a href=""><i class="fa fa-caret-left"></i>&nbsp;Back to Registration History</a>
                        </div>   
                        <h4>Transfer Owner</h4> 
                        <form action="" method="post" id="transferInfo" class="transferOwnerInfo">
                            <input type="hidden" name="postId" value="<?php echo $_POST['transferOwner']; ?>">
                            <input type="hidden" name="action" value="transferOwnerInfo">
                            <div class="contact-form">
                                <div class="acc-blue-box">
                                    <div class="acc-blue-head">
                                        Owner Information
                                    </div>
                                    <div class="acc-blue-content">
                                        <div class="field-wrap two-fields-wrap">
                                            <div class="field-div">
                                                <label>*First Name:</label>
                                                <input type="text" name="primary_first_name" value="" placeholder="First Name">
                                            </div>
                                            <div class="field-div">
                                                <label>*Last Name:</label>
                                                <input type="text" name="primary_last_name" value="" placeholder="Last Name">
                                            </div>
                                        </div>                            
                                        <div class="field-wrap">
                                            <div class="field-div">
                                                <label>*Country:</label>
                                                <?php 
                                                    $countries_obj = new WC_Countries();
                                                    $countries = $countries_obj->__get('countries');
                                                    echo '<select name="primary_country" class="address-country">';
                                                        foreach ($countries as $key => $value){

                                                            echo '<option value="'.$key.'" >'.$value.'</option>';
                                                        }
                                                    echo '</select>';
                                                ?>
                                            </div>
                                        </div>
                                        <div class="field-wrap two-fields-wrap">
                                            <div class="field-div">
                                                <label>*Address:</label>
                                                <input type="text" name="primary_address_line1" value="" placeholder="Address Line 1">
                                            </div>
                                            <div class="field-div">
                                                <label></label>
                                                <input type="text" name="primary_address_line2" value="" placeholder="Address Line 2">
                                            </div>
                                        </div>
                                        <div class="field-wrap two-fields-wrap">    
                                            <div class="field-div">
                                                 <input type="text" name="primary_city" value="" placeholder="City">
                                            </div>
                                            <div class="field-div">
                                                <div class="field-wrap two-fields-wrap">
                                                    <div class="field-div">
                                                        <label style="display: none;" class="statevalidate"></label>
                                                        <select class="address-state" name="primary_state" data-val=""></select>
                                                    </div>
                                                    <div class="field-div">
                                                        <input type="text" name="primary_postcode" value="" placeholder="Zipcode">
                                                    </div>
                                                </div>
                                            </div>    
                                       </div>
                                        <div class="field-wrap two-fields-wrap">
                                            <div class="field-div">
                                                <label>*Primary Phone Number:</label>
                                                <input type="text" name="primary_home_number" placeholder="1(555) 123-1234">
                                            </div>
                                            <div class="field-div">
                                                <label>Secondary Phone Number:</label>
                                                <input type="text" name="primary_cell_number" placeholder="1(555) 123-1234">
                                            </div>
                                        </div> 
                                        <div class="field-wrap two-fields-wrap">
                                            <div class="field-div">
                                                <label>*Email:</label>
                                                <input type="email" name="primary_email" id="primary_email" value="" placeholder="Email Address">
                                                <span class="error-email"></span>
                                            </div>
                                            <div class="field-div primary-alert">
                                                <label>*Receive Urgent Alert?</label>
                                                <div class="field-div">
                                                    <div class="two-checks">
                                                        <p>
                                                            <input name="primary_argent_alert" class="primary_argent_alert primary-info-check" value="yes" type="radio"> Yes
                                                        </p>
                                                        <p>
                                                            <input name="primary_argent_alert" class="primary_argent_alert primary-info-check" value="no" type="radio"> No
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div> 
                                        <div class="field-wrap submit-wrap text-center">
                                            <div class="field-div">
                                                <input type="button" name="transferOwnerInfo" id="transferOwner" value="Transfer New Owner Information" class="site-btn-red">
                                            </div>
                                        </div> 
                                        <div class="field-wrap error">
                                            <div class="field-div">
                                            </div>
                                        </div>
                                    </div>
                                </div> 
                            </div>
                        </form>

                    <?php }elseif (isset($_POST['editOwner']) && !empty($_POST['editOwner'])) { 
                        $petId  = $_POST['editOwner'];
                        $userId = get_post_meta($petId,"pet_owner",true);
                        $alert  = get_the_author_meta("primary_argent_alert",$userId);
                    ?>
                    <div class="page-heading heading-right-link">
                        <h1>Search Registry</h1>
                        <a href=""><i class="fa fa-caret-left"></i>&nbsp;Back to Registration History</a>
                    </div>   
                    <h4>Edit Owner</h4> 
                    <form method="post" id="editOner" class="edit-owner-form">
                        <input type="hidden" name="userId" value="<?php echo $userId; ?>">
                        <input type="hidden" name="action" value="updateOwnerInformation">
                        <div class="contact-form">
                            <div class="acc-blue-box">
                                <div class="acc-blue-head">
                                    Primary Contact Information
                                </div>
                                <div class="acc-blue-content">
                                    <div class="field-wrap two-fields-wrap">
                                        <div class="field-div">
                                            <label>First Name:</label>
                                            <input type="text" name="primary_first_name" value="<?php echo get_the_author_meta("first_name",$userId); ?>" placeholder="First Name">
                                        </div>
                                        <div class="field-div">
                                            <label>Last Name:</label>
                                            <input type="text" name="primary_last_name" value="<?php echo get_the_author_meta("last_name",$userId); ?>" placeholder="Last Name">
                                        </div>
                                    </div>                            
                                    <div class="field-wrap">
                                        <div class="field-div">
                                            <label>*Country:</label>
                                            <?php 
                                                $country = get_the_author_meta("primary_country",$userId);
                                                $countries_obj = new WC_Countries();
                                                $countries = $countries_obj->__get('countries');
                                                echo '<select name="primary_country" class="address-country" required="">
                                                <option value="">Select</option>';
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
                                            <label>Address:</label>
                                            <input type="text" name="primary_address_line1" value="<?php echo get_the_author_meta("primary_address_line1",$userId); ?>" placeholder="Address Line 1">
                                        </div>
                                        <div class="field-div">
                                            <label></label>
                                            <input type="text" name="primary_address_line2" value="<?php echo get_the_author_meta("primary_address_line2",$userId); ?>" placeholder="Address Line 2">
                                        </div>
                                     </div>
                                     <div class="field-wrap two-fields-wrap">   
                                        <div class="field-div">
                                            <input type="text" name="primary_city" value="<?php echo get_the_author_meta("primary_city",$userId); ?>" placeholder="City">
                                        </div>    
                                        <div class="field-div">
                                            <div class="field-wrap two-fields-wrap">
                                                <div class="field-div">
                                                   <label style="display: none" class="statevalidate"></label>
                                                   <select class="address-state" name="primary_state" data-val="<?php echo get_the_author_meta("primary_state",$userId); ?>"></select>
                                                </div>
                                                <div class="field-div">
                                                    <input type="text" name="primary_postcode" value="<?php echo get_the_author_meta("primary_postcode",$userId); ?>" placeholder="Zipcode">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="field-wrap two-fields-wrap">
                                        <div class="field-div">
                                            <label>*Primary Phone Number:</label>
                                            <input type="text" name="primary_home_number" value="<?php echo get_the_author_meta("primary_home_number",$userId); ?>" placeholder="1(555) 123-1234">
                                        </div>
                                        <div class="field-div">
                                            <label>Secondary Phone Number:</label>
                                            <input type="text" name="primary_cell_number" value="<?php echo get_the_author_meta("primary_cell_number",$userId); ?>" placeholder="1(555) 123-1234">
                                        </div>
                                    </div> 
                                    <div class="field-wrap two-fields-wrap primary-alert">
                                        <div class="field-div">
                                            <label>*Receive Urgent Alert? </label>
                                            <div class="field-div">
                                                <div class="two-checks">
                                                    <p>
                                                        <input name="primary_argent_alert" class="primary_argent_alert primary-info-check" value="yes" type="radio" <?php if ($alert == 'yes'): ?>
                                                            checked="checked"
                                                        <?php endif ?>> Yes
                                                    </p>
                                                    <p>
                                                        <input name="primary_argent_alert" class="primary_argent_alert primary-info-check" value="no" type="radio" <?php if ($alert == 'no'): ?>
                                                            checked="checked"
                                                        <?php endif ?>> No
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div> 
                                    <div class="field-wrap submit-wrap text-center">
                                        <div class="field-div">
                                            <input type="button" id="update-owner-information" value="Save" class="site-btn-red">
                                        </div>
                                    </div> 
                                    <div class="field-wrap error">
                                        <div class="field-div">
                                        </div>
                                    </div>
                                </div>
                            </div> 
                        </div>
                    </form>
                    <?php }elseif (isset($_POST['editPet']) && !empty($_POST['editPet'])) {
                        $petId = $_POST['editPet'];
                        $post  = get_post($petId);
                        $mypod = pods( 'pet_profile', $petId );
                        $shots = get_post_meta($petId,'shot');
                        $gend  = $mypod->display('gender');
                        $natur = $mypod->display('neutered_spayed');
                        // var_dump($natur);
                    ?>
                        <div class="edit">   
                            <div class="page-heading heading-right-link">
                                <h1>Search Registry</h1>
                                <a href=""><i class="fa fa-caret-left"></i>&nbsp;Back to Registration History</a>
                            </div>   
                            <h4>Edit Pet</h4> 
                            <div class="acc-blue-box">
                                <div class="acc-blue-head">
                                    Current Pet Image
                                </div>
                                <div class="acc-blue-content">
                                    <div class="row">
                                        <div class="col-sm-6 mb-15">
                                            <h4>Current Pet Image:</h4>

                                            <?php $imageURL = get_the_post_thumbnail_url($petId);
                                            if(!empty($imageURL)){ ?>
                                                <img src="<?php echo $imageURL; ?>" alt="Profile Image" class="pet-profile-image" />
                                             <?php }else{ ?>
                                                <img src="<?php echo get_site_url(); ?>/wp-content/uploads/2019/02/pet-image.jpg" alt="Profile Image" class="pet-profile-image" />
                                                <?php } ?>
                                        </div>
                                        <div class="col-sm-6 mb-15">
                                            <h4>Upload New Pet Image:</h4>
                                            <input name="feature" id="feature" type="file">
                                            <p class="field-notice">
                                                Files must be less than 2 MB.
                                                <br>
                                                Allowed file types: .png / .gif / .jpg / .jpeg
                                            </p>
                                        </div>
                                    </div>
                                    <div class="text-center">
                                        <input type="button" name="UploadPetProfileImage" id="upload-pet-profile-image" value="Save" class="site-btn-red">
                                    </div>
                                    <div class="field-wrap error">
                                        <div class="field-div">
                                        </div>
                                    </div>
                                </div>
                            </div> 
                            <div class="acc-blue-box">
                                <div class="acc-blue-head">
                                    Pet Information
                                </div>
                                <div class="acc-blue-content">
                                    <fieldset aria-label="Step Two" tabindex="-1" id="step-2" class="step-form-box">
                                    <div class= "Edit-response"></div>
                                    <form id="editInfo" method="POST" enctype="multipart/form-data">
                                        <input type="hidden" name="postId" value="<?php echo $petId; ?>" id="pet-id" class="petdata">
                                        <input type="hidden" name="action" value="editPetInfo" class="petdata">
                                        <div class="contact-form" id="sections">
                                            <div class="field-wrap">
                                                <div class="field-div">
                                                    <label>*SmartTag Serial #: </label>
                                                    <input type="text" name="smarttag_id_number" placeholder="Enter SmartTag Serial Number " class="petdata" pre="" value="<?php echo $mypod->display('smarttag_id_number'); ?>" />
                                                </div>
                                            </div>
                                            <div class="field-wrap two-fields-wrap">
                                                <div class="field-div">
                                                    <label>*Pet Name: </label>
                                                    <input type="text" name="pet_name" placeholder="Enter Pet Name " class="petdata" pre="" value="<?php echo $post->post_title; ?>" />
                                                </div>
                                                <div class="field-div">
                                                    <div class="field-wrap two-fields-wrap">
                                                        <div class="field-div">
                                                            <label>*Gender: </label>
                                                            <select name="gender" id="PetGen" class="petdata">
                                                               
                                                                <option value="">Select Gender</option>
                                                                 <option value="male" <?php if ($gend == "male"): ?>selected="selected"<?php endif ?>>Male</option>
                                                                 <option value="female" <?php if ($gend == "female"): ?>selected="selected"<?php endif ?>>Female</option>
                                                            </select>
                                                        </div>
                                                        <div class="field-div">
                                                            <label>*Pet Type: </label>
                                                            <input type="text" name="pet_type" class="petdata" placeholder="Pet Type" value="<?php echo $mypod->display('pet_type'); ?>">
                                                        </div>
                                                    </div>
                                                </div>
                                             </div>
                                                <div class="field-wrap two-fields-wrap">
                                                    <div class="field-div">
                                                        <label>Primary Breed: </label>
                                                        <input type="text" name="primary_breed" placeholder="Primary Breed" id="PriBrd" class="petdata" pre="" value="<?php echo $mypod->display('primary_breed'); ?>" />
                                                    </div>
                                                    <div class="field-div">
                                                        <label>Secondary Breed: </label>
                                                        <input type="text" name="secondary_breed" placeholder="Secondary Breed" id="SecBrd" class="petdata" pre="" value="<?php echo $mypod->display('secondary_breed'); ?>" />
                                                    </div>
                                                </div>
                                                <div class="field-wrap two-fields-wrap">
                                                    <div class="field-div">
                                                        <label>Primary Color: </label>
                                                        <input type="text" name="primary_color" placeholder="Enter color of pet" id="PrmColor" class="petdata" pre="" value="<?php echo $mypod->display('primary_color'); ?>" />
                                                    </div>
                                                    <div class="field-div">
                                                        <label>Secondary Color(s):</label>
                                                        <input type="text" name="secondary_color" placeholder="Enter color(s) of pet" id="SecColor" class="petdata" pre="" value="<?php echo $mypod->display('secondary_color'); ?>" />
                                                    </div>
                                                </div>
                                                <div class="field-wrap two-fields-wrap">
                                                    <div class="field-div">
                                                        <label>Size: </label>
                                                        <input type="text" name="size" placeholder="Size" id="Siz" class="petdata" pre="" value="<?php echo $mypod->display('size'); ?>" />
                                                    </div>
                                                    <div class="field-div">
                                                        <label>Pet Date of Birth: (optional)</label>
                                                        <div class="field-wrap three-fields-wrap ">
                                                            <input type="text" name="pet_date_of_birth" id="pet-dob" placeholder="mm/dd/yyyy" class="input-10 input petdata date-picker" pre=""value="<?php echo $mypod->display('pet_date_of_birth'); ?>" />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="field-wrap two-fields-wrap">
                                                    <div class="field-div">
                                                        <label>Neutered/Spayed: </label>
                                                         <select name="neutered_spayed" class="petdata">
                                                                <option value="Yes" <?php if ($natur == "Yes"): ?>
                                                                    selected="selected"
                                                                <?php endif ?>>Yes</option>
                                                                <option value="No" <?php if ($natur == "No"): ?>
                                                                    selected="selected"
                                                                <?php endif ?>>No</option>
                                                              </select>
                                                    </div>
                                                </div>
                                                <div class="field-wrap two-fields-wrap">
                                                    <div class="prl-15">
                                                        <label>Shots/Vaccination: </label>
                                                    </div>
                                                    <div class="field-div">
                                                        <div class="field-div">
                                                            <input type="checkbox" class="petdata" name="shot[]" value="Canine Distemper" <?php foreach ($shots as $shot): ?>
                                                                <?php if ($shot == 'Canine Distemper'): ?>
                                                                    checked="checked"
                                                                <?php break; endif ?>
                                                            <?php endforeach ?>>Canine Distemper
                                                        </div>
                                                        <div class="field-div">
                                                            <input type="checkbox" class="petdata" name="shot[]" value="Measles" <?php foreach ($shots as $shot): ?>
                                                                <?php if ($shot == 'Measles'): ?>
                                                                    checked="checked"
                                                                <?php break; endif ?>
                                                            <?php endforeach ?>>Measles
                                                        </div>
                                                        <div class="field-div">
                                                            <input type="checkbox" class="petdata" name="shot[]" value="Parvovirus" <?php foreach ($shots as $shot): ?>
                                                                <?php if ($shot == 'Parvovirus'): ?>
                                                                    checked="checked"
                                                                <?php break; endif ?>
                                                            <?php endforeach ?>>Parvovirus
                                                        </div>
                                                        <div class="field-div">
                                                            <input type="checkbox" class="petdata" name="shot[]" value="Hepatitis" <?php foreach ($shots as $shot): ?>
                                                                <?php if ($shot == 'Hepatitis'): ?>
                                                                    checked="checked"
                                                                <?php break; endif ?>
                                                            <?php endforeach ?>>Hepatitis
                                                        </div>
                                                        <div class="field-div">
                                                            <input type="checkbox" class="petdata" name="shot[]" value="Rabies" <?php foreach ($shots as $shot): ?>
                                                                <?php if ($shot == 'Rabies'): ?>
                                                                    checked="checked"
                                                                <?php break; endif ?>
                                                            <?php endforeach ?>>Rabies
                                                        </div>
                                                        <div class="field-div">
                                                            <input type="checkbox" class="petdata" name="shot[]" value="Respiratory disease from canine adenovirus-2 (CAV-2)" <?php foreach ($shots as $shot): ?>
                                                                <?php if ($shot == 'Respiratory disease from canine adenovirus-2 (CAV-2)'): ?>
                                                                    checked="checked"
                                                                <?php break; endif ?>
                                                            <?php endforeach ?>>Respiratory disease from canine adenovirus-2 (CAV-2)
                                                        </div>
                                                            
                                                    </div> 
                                                    <div class="field-div"> 
                                                        <div class="field-div">  
                                                            <input type="checkbox" class="petdata" name="shot[]" value="Parainfluenza" <?php foreach ($shots as $shot): ?>
                                                                <?php if ($shot == 'Parainfluenza'): ?>
                                                                    checked="checked"
                                                                <?php break; endif ?>
                                                            <?php endforeach ?>>Parainfluenza
                                                        </div>

                                                        <div class="field-div">
                                                            <input type="checkbox" class="petdata" name="shot[]" value="Bordetella" <?php foreach ($shots as $shot): ?>
                                                                <?php if ($shot == 'Bordetella'): ?>
                                                                    checked="checked"
                                                                <?php break; endif ?>
                                                            <?php endforeach ?>>Bordetella
                                                        </div>

                                                        <div class="field-div">
                                                            <input type="checkbox" class="petdata" name="shot[]" value="Leptospirosis" <?php foreach ($shots as $shot): ?>
                                                                <?php if ($shot == 'Leptospirosis'): ?>
                                                                    checked="checked"
                                                                <?php break; endif ?>
                                                            <?php endforeach ?>>Leptospirosis
                                                        </div>

                                                        <div class="field-div">
                                                            <input type="checkbox" class="petdata" name="shot[]" value="Lyme" <?php foreach ($shots as $shot): ?>
                                                                <?php if ($shot == 'Lyme'): ?>
                                                                    checked="checked"
                                                                <?php break; endif ?>
                                                            <?php endforeach ?>>Lyme
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="field-wrap">
                                                        <div class="field-div">
                                                        <label>Unique Features: </label>
                                                        <textarea  name="unique_features" placeholder="Enter Unique_Features" class="petdata" pre=""><?php echo $mypod->display('unique_features'); ?></textarea>
                                                         </div>
                                                </div>
                                                <div class="field-wrap">
                                                        <div class="field-div">
                                                            <label>Allergies: </label>
                                                            <textarea name="allergies" placeholder="Enter Allergies" class="petdata" pre="" ><?php echo $mypod->display('allergies'); ?></textarea>
                                                        </div>
                                                </div>
                                                <div class="field-wrap">
                                                    <div class="field-div">
                                                        <label>Special Needs:</label>
                                                        <textarea class="petdata" placeholder="Enter Special Needs" name="special_needs" pre=""><?php echo $mypod->display('special_needs'); ?></textarea>
                                                    </div>
                                                </div>  
                                                <div class="text-center">
                                                        <input type ="button" value ="Save" class ="btn btn-primary text-center pet-data site-btn-red" />
                                                </div>   
                                                <div class="field-wrap error">
                                                    <div class="field-div">
                                                    </div>
                                                </div>               
                                            </div>
                                        </form>
                                    </fieldset>
                                </div>
                            </div>
                        </div>

                    <?php }else{ ?>

                        <div class="tabGroup">
                            <div class="swichtab-contents">
                                <div id="singup" class="swichtab-panel" data-swichtab="target">
                                    <div class="page-heading heading-right-link">
                                    <h1>Monmouth Country SPCA - Search Registry</h1>
                                    </div>
                                    <fieldset aria-label="Step Two" tabindex="-1" id="step-2" class="step-form-box">
                                        <form id="Srch-reg" method="POST" enctype="multipart/form-data">
                                            <div class="contact-form" id="sections">
                                                <div class="section">
                                                    <div class="field-wrap two-fields-wrap">
                                                        <div class="field-div">
                                                        <label>SmartTag Serial #: </label>
                                                            <input type="text" name="SerialNum" placeholder="Enter SmartTag Serial Number " class="Srch-data" />
                                                        </div>
                                                        <div class="field-div">
                                                        <label>Phone Number: </label>
                                                        <input type="text" name="phone" placeholder="1(555) 123-1234" class="Srch-data" />
                                                        </div>
                                                    </div>
                                                    <div class="field-wrap three-fields-wrap">
                                                        <div class="field-div">
                                                            <label>Pet Owner: </label>
                                                            <input type="text" name="petowner" placeholder="Enter Pet Owner Username " class="Srch-data" />
                                                        </div>
                                                        <div class="field-div">
                                                            <label>Email: </label>
                                                            <input type="text" name="email" placeholder="Email Address" class="Srch-data" />
                                                        </div>
                                                        <div class="field-div">
                                                            <label>&nbsp;</label>
                                                            <input type="submit" name="submit" value="Search" class="width-100" />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </fieldset>
                                </div>
                                <table id="tab-data" class="search-table">
                                    <thead>
                                        <tr>
                                            <th>Date<span><span></th>
                                            <th>Last Name<span><span></th>
                                            <th>Phone #<span><span></th>
                                            <th>Email<span><span></th>
                                            <th>Pet Name<span><span></th>
                                            <th>Serial Number<span><span></th>
                                            <th>Subscription<span><span></th>
                                            <th>Edit</th>
                                        </tr>  
                                    </thead>
                                    <tbody>
                                         <?php 
                                        while( $query->have_posts() ) : $query->the_post(); 
                                            $id     = get_the_ID();
                                            $mypod          = pods( 'pet_profile', $id );
                                            // $author         = get_post_field( 'post_author', $id );
                                            $author   = get_post_meta($id,"pet_owner",true);
                                                // echo "ocean" . $author . "ocean"; 
                                                //$userInfo       = get_userdata($author);
                                                $subscriptionId = $mypod->display("smarttag_subscription_id");
                                                $serialId = get_post_meta($id,"smarttag_id_number",true);
                                                $smartTagId     = $mypod->display('smarttag_id_number');
                                                if (!empty($subscriptionId)) {
                                                    $subscription   = wcs_get_subscription($subscriptionId);
                                                    if (!empty($subscription)) {
                                                        foreach( $subscription->get_items() as $item_id => $product_subscription ){
                                                        // Get the name
                                                            $variationId            = $product_subscription['variation_id'];
                                                            $variation              = wc_get_product($variationId);
                                                            $variation_attributes   = $variation->get_variation_attributes();
                                                            $subscription           = $variation_attributes['attribute_pa_protection'];
                                                        }
                                                    }else{
                                                        $subscription = "This subscription deleted";
                                                    }
                                                }else{
                                                    $subscription = "Not Added";
                                                }

                                                $check = checkSmartIDTag(1,'lost_found_pets','pet_status','smarttag_id_number',$smartTagId);
                                                if ($check) {
                                                    $form = "<form method='post' action='".get_site_url()."'/my-account/report-pet-lost'><input type='hidden' value='".$id."' name='post_id'><a href='javascript:;' class='post-btn color-red'>Report Lost</a></form>";
                                                }else{
                                                    $form = "<form method='post' action='".get_site_url()."'/my-account/report-pet-found-list'><input type='hidden' value='".$smartTagId."' name='smarttag_id_number'><input type='hidden' value='1' name='report_pet_as_found'><a href='javascript:;' class='post-btn'>Report Pet as Found</a></form>";
                                                }
                                                
                                                echo "<tr>";
                                                      echo"<td>".get_the_date("d-m-Y",$id)."</td>";
                                                      echo"<td>".get_user_meta( $author, 'last_name', true )."</td>";
                                                      echo"<td>".get_user_meta( $author, 'primary_home_number', true )."</td>";
                                                      echo"<td class='search-email'><p>".get_the_author_meta( 'user_email', $author )."</p></td>";
                                                      echo"<td>".get_the_title( $id )."</td>";
                                                      echo"<td>".$smartTagId."<br>".$form."</td>";
                                                      echo"<td><ul><li>". $serialId ."</li><li>".$form."</li</ul></td>";
                                                      echo"<td><form method='post'><input type='hidden' name='editPet' value='".$id."'><a href='javascript:;' class='post-btn'>Edit Pet</a></form><form method='post'><input type='hidden' value='".$id."' name='editOwner'><a href='javascript:;' class='post-btn'>Edit Owner</a></form><form method='post'><input type='hidden' name='transferOwner' value='".$id."'><a href='javascript:;' class='post-btn'>Transfer Owner</a></form></td>";
                                                      echo "</tr>";
                                           endwhile;
                                        ?>
                                    </tbody> 
                                </table>
                            </div>
                        </div>
                    <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php get_footer(); ?>
    <script type="text/javascript">
        jQuery(document).ready(function($) {
        var today        = new Date();
        
        //datepicker
        $("#pet-dob").datepicker({
            dateFormat : "mm/dd/yy",
            endDate: "today",
            maxDate: today,
            onSelect: function() {
                var Pdb = $(this).datepicker('getDate');
                $("#ptdob").text(Pdb);
            }
        });
         function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    alert(e.target.result);
                    $('#blah').attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
        $("#imgInp").change(function() {
            readURL(this);
        });

       //upload pet image
        
   });
    </script>
    <script type="text/javascript">
    $(document).ready(function() {
    // When the Upload button is clicked...
    $('body').on('click', '.upload-form .btn-upload', function(e){
        e.preventDefault;

        var fd = new FormData();
        var files_data = $('.upload-form .files-data'); // The <input type="file" /> field
        
        // Loop through each data and create an array file[] containing our files data.
        $.each($(files_data), function(i, obj) {
            $.each(obj.files,function(j,file){
                console.log('files[' + j + ']'+file);
                fd.append('files[' + j + ']', file);
            })
        });
        
        // our AJAX identifier
        fd.append('action', 'Create_Pet_profile');  
        
        // Remove this code if you do not want to associate your uploads to the current page.
        fd.append('post_id',8028); 

        $.ajax({
            type: 'POST',
            url: '<?php echo admin_url( 'admin-ajax.php' ); ?>',
            data: fd,
            contentType: false,
            processData: false,
            success: function(response){
                $('.upload-response').html(response); // Append Server Response
            }
        });
    });
});
</script>
<script type="text/javascript">
    $(document).ready(function() {
        $('#Srch-reg').on('submit', function (e) {
            e.preventDefault();
             var Srh = new FormData();

             $.each($('#Srch-reg .Srch-data'), function() {
                //console.log($(this).attr('name')+'fffffff'+$(this).val());
                  Srh.append($(this).attr('name'), $(this).val());
             });

             Srh.append('action','PetProfessionalFilter');
             $.ajax({
                        type: 'POST',
                        url: ajaxurl,
                        data: Srh,
                        contentType: false,
                        processData: false,
                        success: function(response) {
                            $('#tab-data tbody').html("");
                            $('#tab-data tbody').append(response);
                        }
                    });
        });

        $("body").on('click','.post-btn',function(e){
             e.preventDefault();
             var ed = new FormData();
            ed.append($(this).attr('id'),$(this).attr('value')); 
            ed.append('action','PetProfessionalEdit'); 
            $.ajax({
                        type: 'POST',
                        url: ajaxurl,
                        data: ed,
                        contentType: false,
                        processData: false,
                        success: function(response) {
                        $('#EdiPet').append(response);
                        }
                    });
            });
        $("body").on('click','.cust-btn',function(e){
             e.preventDefault();
             var ed = new FormData();
            ed.append($(this).attr('id'),$(this).attr('value')); 
            ed.append('action','OenerEdit'); 
            $.ajax({
                        type: 'POST',
                        url: ajaxurl,
                        data: ed,
                        contentType: false,
                        processData: false,
                        success: function(response) {
                        $('#EdiOwnr').append(response);
                            
                        }
                    });
            });
        });

  //update post fields
</script>
<script type="text/javascript">
     $(document).ready(function() {
// alert('hgfh');
    $('body').on('submit','#EditInfo', function (event) {
      event.preventDefault();
      var Eid = new FormData();
      $.each($('#EditInfo .petdata'), function() {
      Eid.append($(this).attr('name'),$('#PostId').val()+','+$(this).attr('pre')+','+$(this).val()); 
      });
       
    Eid.append('action','PetProfessionalUpdate'); 
        $.ajax({
                    type: 'POST',
                    url: ajaxurl,
                    data: Eid,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                    alert(response);
                    
                      }
                });
         });
    $('body').on('submit','#ContInfo', function (event) {         
        event.preventDefault();
        var con = new FormData();
        $.each($('#ContInfo .Onrdata'), function() {
            con.append($(this).attr('name'),$('#OwnId').val()+','+$(this).attr('pre')+','+$(this).val()); 
        });
       
        con.append('action','OwnerUpdate'); 
        $.ajax({
            type: 'POST',
            url: ajaxurl,
            data: con,
            contentType: false,
            processData: false,
            success: function(response) {
                alert(response);
            }
        });
    });


    var transferValidator = $('form[id="transferInfo"]').validate({
            rules: {
                    primary_first_name: 'required',
                    primary_last_name: 'required',
                    primary_country: 'required',
                    primary_address_line1: 'required',
                    primary_home_number:{
                        required: true,
                           number: true,
                           minlength:10,
                           maxlength:10
                       },
                       primary_cell_number:{ 
                           number: true,
                           minlength:10,
                           maxlength:10
                       }, 
                    primary_email: 'required',
                    primary_argent_alert: 'required',
                },
                submitHandler: function(form) {
                form.submit();
              }
            });

    $('body').on('click','#transferOwner', function () {
        if($("#transferInfo").valid()){
            var dataa = $("#transferInfo").serialize();
            console.log(dataa);
            $.ajax({
                type: 'GET',
                url: ajaxurl,
                data: dataa,
                contentType: false,
                processData: false,
                success: function(response) {
                    $(".acc-blue-content .field-wrap.error .field-div").html("");
                    response = jQuery.parseJSON(response);
                    console.log(response.msg);
                    if(response.success == 1){
                        $(".acc-blue-content .field-wrap.error .field-div").html('<div class="alert alert-success alert-dismissible message" style="margin-top:18px;"><a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a><strong>Success!</strong> '+response.msg+'</div>');
                    }else{
                        $(".acc-blue-content .field-wrap.error .field-div").html('<div class="alert alert-danger alert-dismissible message" style="margin-top:18px;"><a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>'+response.msg+'</div>');
                    }
                }
            });
        
        }else{
            transferValidator.focusInvalid();
        }
    });

    $("#upload-pet-profile-image").click(function(){
        var uploadProfileImage = new FormData();
        var file    = $('#feature').get(0).files[0];
        var postId  = $("#pet-id").val();
        var image   = document.querySelector('input[type=file]');
        uploadProfileImage.append('feature', file);
        uploadProfileImage.append('postId', postId);
        uploadProfileImage.append('action', 'UploadPetProfileImage');
        console.log(uploadProfileImage);
        jQuery.ajax({
            type: 'POST',
            url: '<?php echo admin_url( 'admin-ajax.php' ); ?>',
            data: uploadProfileImage,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function(response){
                if (response.attachId) {
                    readURLL(image,'pet-profile-image');
                    $(".acc-blue-content .field-wrap.error .field-div").html('<div class="alert alert-success alert-dismissible" style="margin-top:18px;"><a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a><strong>Success!</strong> '+response.msg+'</div>');
                }else{
                    $(".acc-blue-content .field-wrap.error .field-div").html('<div class="alert alert-danger alert-dismissible" style="margin-top:18px;"><a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>'+response.msg+'</div>');
                }
            }
        });
    });

    var validator = $('form[id="editInfo"]').validate({
        rules: {
        smarttag_id_number: 'required',
                pet_name: 'required',
                gender: 'required',
                pet_type: 'required',

                },
            submitHandler: function(form) {
            form.submit();
          }
        });


    $(".pet-data").click(function(){
        if($("#editInfo").valid()){
            var data = $('#editInfo').serialize();
            jQuery.ajax({
                type: 'GET',
                url: '<?php echo admin_url( 'admin-ajax.php' ); ?>',
                data: data,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function(response){
                    console.log(response.postId);
                    if (response.success) {
                        $("#editInfo .field-wrap.error .field-div").html('<div class="alert alert-success alert-dismissible" style="margin-top:18px;"><a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a><strong>Success!</strong> '+response.msg+'</div>');
                    }else{
                        $("#editInfo .field-wrap.error .field-div").html('<div class="alert alert-danger alert-dismissible" style="margin-top:18px;"><a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>'+response.msg+'</div>');
                    }
                }
            });
        }else{
            validator.focusInvalid();
        }
        
    });

    var updatevalidator = $('form[id="editOner"]').validate({
        rules: {
            primary_argent_alert: 'required',
             primary_home_number:{
                        required: true,
                           number: true,
                           minlength:10,
                           maxlength:10
                       },
                       primary_cell_number:{ 
                           number: true,
                           minlength:10,
                           maxlength:10
                       }, 
                },
            submitHandler: function(form) {
            form.submit();
          }
        });
    //validate Edit Owner
    $("#update-owner-information").click(function(){
        if($("#editOner").valid()){
            var data = $("#editOner").serialize();
            jQuery.ajax({
                type: 'GET',
                url: '<?php echo admin_url( 'admin-ajax.php' ); ?>',
                data: data,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function(response){
                    console.log(response);
                    if (response.success) {
                        $(".edit-owner-form .field-wrap.error .field-div").html('<div class="alert alert-success alert-dismissible" style="margin-top:18px;"><a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a><strong>Success!</strong> '+response.msg+'</div>');
                    }else{
                        $(".edit-owner-form .field-wrap.error .field-div").html('<div class="alert alert-danger alert-dismissible" style="margin-top:18px;"><a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>'+response.msg+'</div>');
                    }
                    $(".field-wrap.error").show();
                }
            });
        }else{
            updatevalidator.focusInvalid();
        }
    });
    $("body").on('click','.post-btn',function(){
        $(this).parent().submit();
    });
});
// $(document).ready( function () {
//     $('#tab-data').DataTable();
// } );

$(document).ready(function() {
    // Setup - add a text input to each footer cell
    $('#tab-data thead th span').each( function () {
        var title = $(this).text();
        $(this ).html( '<input type="text" placeholder="Search '+title+'" />' );
    } );
 
    // DataTable
    var table = $('#tab-data').DataTable();
 
    // Apply the search
    table.columns().every( function () {
        var that = this;
 
        $( 'input', this.header() ).on( 'keyup change', function () {
            if ( that.search() !== this.value ) {
                that
                    .search( this.value )
                    .draw();
            }
        } );
    } );
} );
</script>>