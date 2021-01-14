  <?php 
  $currentUserId  = get_current_user_id();
  $postId         = $_GET['pet_id'];
  $userId         = get_post_field( 'post_author', $postId );
  if ($currentUserId != $userId) {
    echo '<div class="not-found-text width-100">You are not authorized, as you are not the owner of the pet.</div>';
  }else{
    $updateFeature  = "";
    $updatePet      = "";
    $updateOwner    = "";
    $updateUlternate = "";
    $updateVaterian = "";
    $full = "";
    if (isset($_POST['action']) && $_POST['action'] == 'update_owner_information') {
     echo $updateOwner = updateOwnerInformation($_POST,$userId);
    }elseif (isset($_POST['action']) && $_POST['action'] == 'update_alternate_information') {
     echo $updateUlternate = updateAlternateEmergencyInformation($_POST,$userId);
    }elseif (isset($_POST['action']) && $_POST['action'] == 'update_vaterinarian_information') {
     echo $updateVaterian = updateVaterinarianInformation($_POST, $post_id);
    }elseif (isset($_POST['action']) && $_POST['action'] == 'update_all_information') {
     $post_id = $_POST['post_id'];
     updateFeatureImage($_FILES,$post_id);
     updatePetInformation($_POST);
     updateOwnerInformation($_POST,$userId);
     updateAlternateEmergencyInformation($_POST,$userId);
     updateVaterinarianInformation($_POST, $post_id);
     $full = "Data Updated Successfully";
    }

    $id             = $_GET['pet_id'];
    $args           = array( 'post_type' => 'pet_profile', 'p' => $id);
    $my_posts       = new WP_Query($args); 
    $countries_obj  = new WC_Countries();
    $countries      = $countries_obj->__get('countries');
    $pcountry       = get_the_author_meta("primary_country",$userId);
    $paddress1      = get_the_author_meta("primary_address_line1",$userId);
    $paddress2      = get_the_author_meta("primary_address_line2",$userId);
    $pcity          = get_the_author_meta("primary_city",$userId);
    $pstate         = get_the_author_meta("primary_state",$userId);
    $ppostCode      = get_the_author_meta("primary_postcode",$userId);

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

    $scountry        = get_the_author_meta("secondary_country",$userId);
    $saddress1       = get_the_author_meta("secondary_address_line1",$userId);
    $saddress2       = get_the_author_meta("secondary_address_line2",$userId);
    $scity           = get_the_author_meta("secondary_city",$userId);
    $sstate          = get_the_author_meta("secondary_state",$userId);
    $spostCode       = get_the_author_meta("secondary_postcode",$userId);

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

    while ( $my_posts->have_posts() ) : $my_posts->the_post(); ?>
      <?php $mypod = pods( 'pet_profile', get_the_id() ); ?>
      <?php 
      $id         = get_the_id();
      $shot       = $mypod->display('shot');
      $size       = 0;
      if (strpos($shot, ', ') !== false) {
       $shots  = explode(', ', $shot);
       $size   = count($shots);
       if ($size > 9) {
         $shot           = 'All';
       }elseif ($size > 1) {
        $shots[$size-1]  = substr($shots[$size-1], 4 );
      }
    }elseif (strpos($shot, ' and ')) {
     $shots  = explode(' and ', $shot);
     $size   = count($shots);
    }else{
     $shots  = $shot;
    }

    $neutered   = $mypod->display('neutered_spayed');
    if ($neutered == 'Yes') {
     $neutered = 'YES';
    }else{
     $neutered = 'NO';
    }  


    $vcountry        = $mypod->display("vaterinarian_country");
    $vaddress1       = $mypod->display("vaterinarian_address_line_1");
    $vaddress2       = $mypod->display("vaterinarian_address_line_2");
    $vcity           = $mypod->display("vaterinarian_city");
    $vstate          = $mypod->display("vaterinarian_state");
    $vpostCode       = $mypod->display("vaterinarian_zip_code");
    $subscriptionId  = $mypod->display("smarttag_subscription_id");
    $MicrochipSubscriptionId  = $mypod->display("microchip_subscription_id");

    foreach ($countries as $key => $value) {
     if (!empty($scountry)) {
       if ($vcountry == $key) {
         $vcountry = '<br>'.$value;
         break;
       }
     }else
     break;
    }
    if (!empty($vaddress1)) {
     $vaddress1 .= ' ';
    }
    if (!empty($vaddress2)) {
     $vaddress2 .= ' ';
    }
    if (!empty($vcity)) {
     $vcity = '<br>'.$vcity.' City, ';
    }elseif (!empty($vaddress2)) {
     $vaddress2 .= '<br>';
    }elseif (!empty($vaddress1)) {
     $vaddress1 .= '<br>';
    }else{
     $vaddress1 = '<br>';
    }
    if (!empty($vstate)) {
     $vstate .= ' ';
    }
    if (!empty($vpostCode)) {
     $vpostCode .= ' ';
    } 
    $vcountry = getCountryName($vcountry);
    $vaddress   = $vaddress1.$vaddress2.$vcity.$vstate.$vpostCode.$vcountry;
    ?>
    <div class="pp-tabs-wrap">
     <div class="pp-tabs-nav">
      <div class="view pp-tabs-nav-inner pp-tab-option-1 active">View</div>
      <div class="view pp-tabs-nav-inner pp-tab-option-2">Edit</div>
    </div>
    <div class="pp-tabs-content pp-tab-content-1" style="display: block;">
      <div class="row">
       <div class="col-sm-6">
        <div class="acc-blue-box">
         <div class="acc-blue-head">
          Pet Image
          <div class="acc-edit owner-edit">
           <i class="fa fa-edit"></i> EDIT
         </div>
       </div>
       <div class="acc-blue-content">
         <div style="text-align: center;">
          <?php 
          global $plholderImg ;
          $imageURL = get_the_post_thumbnail_url(); 

          if(!empty($imageURL)){
           echo '<img class="preImg" src="'.$imageURL.'" class alt="Profile Image" />';
         }else{
          echo "<img class='preImg' src='". (wp_get_attachment_url($plholderImg) ? wp_get_attachment_url($plholderImg) : "#") ."'>";

        }?>
      </div>
    </div>
    </div>
    <div class="acc-blue-box">
     <div class="acc-blue-head">
      Remove Pet Profile
    </div>
    <div class="acc-blue-content">
      <form name ="remove_pet" action="<?= get_the_permalink(); ?>" method="post" class="custom-form">
        <input type="hidden" name="action" value="remove-pet">
        <input type="hidden" id="userId" name="userId" value="<?php echo $userId; ?>">
        <input type="hidden" id="petId" name="post_id" value="<?php echo get_the_ID(); ?>">
        <p><button type="submit" name="submit" class="site-btn-red remove-pet"><i class="fa fa-trash"></i> Remove Pet</button></p>
      </form>
    </div>
    </div>
    <div class="acc-blue-box">
     <div class="acc-blue-head">
      Found/Lost Status
    </div>
    <div class="acc-blue-content">
      <form action="" method="post" class="custom-form">
       <input type="hidden" name="post_id" value="<?php echo get_the_ID(); ?>">
       <?php
       $smarttag_id_number = $mypod->display('smarttag_id_number');
       $microchip_id_number = $mypod->display('microchip_id_number');
       $check = checkSmartIDTag(1,'lost_found_pets','pet_status','smarttag_id_number',$smarttag_id_number);
       $microchipcheck = checkMicrochipID(1,'lost_found_pets','pet_status','microchip_id_number',$microchip_id_number);
       if ($check || $microchipcheck) {
        echo '<p><button type="button" class="report-pet-as-lost site-btn-light-blue">Report Lost <i class="fa fa-caret-right"></i></button></p><p><strong>Found/Lost Status:</strong> Home</p>';
      }else{
        echo '<input type="hidden" name="smarttag_id_number" value="'.$smarttag_id_number.'"><input type="hidden" name="report_pet_as_found" value="1"><p><button type="button" class="report-pet-as-found site-btn-red">Report Pet As Found <i class="fa fa-caret-right"></i></button></p><p><strong>Found/Lost Status:</strong> Lost</p>';
      }
      ?>
    </form>
    </div>
    </div>
    <div class="acc-blue-box">
     <div class="acc-blue-head">
      Subscription History
    </div>
    <div class="acc-blue-content">
      <?php 
      $check = 0;
      if ($subscriptionId) {
        $subscriptionDetail = json_decode( getSubscriptionPlanNameUsingSerialKey($subscriptionId));
        $product_name = $subscriptionDetail->productName;
        echo "<p>".$subscriptionDetail->productName." ".$subscriptionDetail->expir."</p>";
        if ($product_name == "SmartTag ID Tag Protection Plans - Platinum, Lifetime") {
          echo "<p style='color:red;'>This Pet is Fully Protected.</p>";
        }else{
          echo '<a href="'.site_url().'/my-account/view-subscription/'. $subscriptionDetail->subscriptionId.'/" class="button view site-btn-grey">Upgrade Pet Protection Plan</a>';
        }
        $check = 1;
      } 

      if ($MicrochipSubscriptionId) {
        $subscriptionDetail = json_decode( getSubscriptionPlanNameUsingSerialKey($MicrochipSubscriptionId));
        echo "<p>".$subscriptionDetail->productName."</p>";
        echo '<a href="'.site_url().'/my-account/view-subscription/'. $subscriptionDetail->subscriptionId.'/" class="button view site-btn-grey">Upgrade Pet Protection Plan</a>';
        $check = 1;
      }

      if (!$check) {
        echo 'Not Assigned';
      }                           
      ?>
    </div>
    </div>
    <div class="acc-blue-box">
     <div class="acc-blue-head">
      Veterinarian Contact Information
      <div class="acc-edit owner-edit">
       <i class="fa fa-edit"></i> EDIT
     </div>
    </div>
    <div class="acc-blue-content">
      <strong>Address:</strong>
      <br>
      <?php echo $vaddress; ?>
      <br>
      <strong>Phone Number:</strong> <span class="phone-country-code" data-val="<?php echo $mypod->display("vaterinarian_primary_phone_number_code"); ?>"></span><?php echo $mypod->display("vaterinarian_primary_phone_number"); ?>
    </div>
    </div>
    <div class="acc-blue-box">
     <div class="acc-blue-head">
      My Pet Alerts
    </div>
    <div class="acc-blue-content">
      <p>Pet alert are included in the Platinum Protection Plan.</p>
      <p><a href="<?= site_url('my-account/subscriptions/') ?>">Upgrade Protection Plan <i class="fa fa-caret-right"></i></a></p>
      <p><a href="<?= site_url('my-account/sign-up-pet-alerts/') ?>">Set up Pet Alerts <i class="fa fa-caret-right"></i></a></p>
    </div>
    </div>
    </div>
    <div class="col-sm-6">
      <div class="acc-blue-box">
       <div class="acc-blue-head">
        Pet Information
        <div class="acc-edit owner-edit">
         <i class="fa fa-edit"></i> EDIT
       </div>
     </div>
     <div class="acc-blue-content">
      <strong>Microchip ID Number:</strong> <span></span>
      <br>
      <strong>ID Tag Serial Number:</strong> <span><?php echo $mypod->display('smarttag_id_number'); ?></span>
      <br>
      <strong>Pet Name:</strong> <span><?php echo get_the_title(); ?></span>
      <br>
      <strong>Pet Type:</strong> 
      <span><?php 
      $termId = $mypod->display('pet_type');
      echo $term_name = get_term( $termId )->name;
      ?>  
    </span>
    <br>
    <strong>Gender:</strong> <span><?php echo $mypod->display('gender'); ?></span>
    <br>
    <strong>Size:</strong> <span><?php echo $mypod->display('size'); ?></span>
    <br>
    <strong>Pet Date of Birth:</strong> <span><?php echo $mypod->display('pet_date_of_birth'); ?></span>
    <br>
    <strong>Primary Breed:</strong> <span><?php $term_id =  $mypod->display('primary_breed'); 
    echo (isset(get_term( $term_id )->name)) ? get_term( $term_id )->name : "" ;
    ?></span>
    <br>
    <strong>Secondary Breed:</strong> <span><?php 

    $sterm_id = $mypod->display('secondary_breed');
    echo (isset(get_term( $sterm_id )->name)) ? get_term( $sterm_id )->name : "";

    ?></span>
    
    <br>
    <strong>Primary Color:</strong> <span><?php echo $mypod->display('primary_color'); ?></span>
    <br>
    <strong>Secondary Color:</strong> <span><?php echo $mypod->display('secondary_color'); ?></span>
    <br>
    <strong>Neutered/Spayed:</strong> <span><?php echo $neutered; ?></span>
    <br>
    <strong>Shots/Vaccinations:</strong> <span><?php echo $shot; ?></span>
    <br>
    <strong>Unique Features:</strong> <span><?php echo $mypod->display('unique_features'); ?></span>
    <br>
    <strong>Special Needs:</strong> <span><?php echo $mypod->display('special_needs'); ?></span>
    <br>
    <strong>Allergies:</strong> <span><?php echo $mypod->display('allergies'); ?></span>
    </div>
    </div>
    <div class="acc-blue-box">
     <div class="acc-blue-head">
      Owner Information
      <div class="acc-edit owner-edit">
       <i class="fa fa-edit"></i> EDIT
     </div>
    </div>
    <div class="acc-blue-content">
      <strong>Email:</strong> <span><?php echo get_the_author_meta("email",$userId); ?></span>
      <br>
      <strong>First Name:</strong> <span><?php echo get_the_author_meta("first_name",$userId); ?></span>
      <br>
      <strong>Last Name:</strong> <span><?php echo get_the_author_meta("last_name",$userId); ?></span>
      <br>
      <strong>Address:</strong>
      <br>
      <span><?php echo $paddress; ?>
    </span>
    <br>
    <strong>Primary Phone Number:</strong> <span><span class="phone-country-code" data-val="<?php echo get_the_author_meta("primary_phone_country_code",$userId); ?>"></span><?php echo get_the_author_meta("primary_home_number",$userId); ?></span>
    <br>
    <strong>Secondary Phone Number:</strong> <span><span class="phone-country-code" data-val="<?php echo get_the_author_meta("primary_cell_country_code",$userId); ?>"></span><?php echo get_the_author_meta("primary_cell_number",$userId); ?></span>
    </div>
    </div>
    <div class="acc-blue-box">
     <div class="acc-blue-head">
      Alternate Emergency Contact
      <div class="acc-edit owner-edit">
       <i class="fa fa-edit"></i> EDIT
     </div>
    </div>
    <div class="acc-blue-content">
      <strong>Email:</strong> <span><?php echo get_the_author_meta("secondary_email",$userId); ?></span>
      <br>
      <strong>First Name:</strong> <span><?php echo get_the_author_meta("secondary_first_name",$userId); ?></span>
      <br>
      <strong>Last Name:</strong> <span><?php echo get_the_author_meta("secondary_last_name",$userId); ?></span>
      <br>
      <strong>Address:</strong>
      <br>
      <span><?php echo $saddress; ?></span>
      <br>
      <strong>Primary Phone Number:</strong> <span><span class="phone-country-code" data-val="<?php echo get_the_author_meta("secondary_phone_country_code",$userId); ?>"></span><?php echo get_the_author_meta("secondary_home_number",$userId); ?></span>
      <br>
      <strong>Secondary Phone Number:</strong> <span><span class="phone-country-code" data-val="<?php echo get_the_author_meta("secondary_cell_country_code",$userId); ?>"></span><?php echo get_the_author_meta("secondary_cell_number",$userId); ?></span>
    </div>
    </div>
    <div class="acc-blue-box">
     <div class="acc-blue-head">
      My Pet Trust
    </div>
    <div class="acc-blue-content">
      <p><a href="#">Purchase a Pet Trust <i class="fa fa-caret-right"></i></a></p>
      <p><a href="#">Edit Pet Trust <i class="fa fa-caret-right"></i></a></p>
      <p><a href="#">Print Pet Trust <i class="fa fa-caret-right"></i></a></p>
      <p><a href="#">Learn More a about Pet Trust <i class="fa fa-caret-right"></i></a></p>
    </div>
    </div>
    </div>
    </div>
    </div>
    <div class="pp-tabs-content pp-tab-content-2">
      <div class="contact-form">
       <div class="acc-blue-box">
        <form class="uploadImage" name="imageUpload" method="post" enctype="multipart/form-data">
          <input type="hidden" class="img-data" name="postId" value="<?php echo get_the_ID(); ?>">
          <input type="hidden" class="img-data" name="action" value="UploadPetProfileImage">
          <div class="acc-blue-head">
            Pet Image
          </div>
          <div class="acc-blue-content">
            <div class="row">
             <div class="col-sm-6 mb-15">
              <h4>Current Pet Image:</h4>
              <?php $imageURL = get_the_post_thumbnail_url();
              if(!empty($imageURL)){
               echo '<img id="blah" src="'.$imageURL.'" alt="Profile Image" />';
             }else{
               echo '<img id="blah" src="'.get_site_url().'/wp-content/uploads/2019/02/pet-image.jpg" alt="Profile Image" />';
             }?>
           </div>
           <div class="col-sm-6 mb-15">
            <h4>Upload New Pet Image:</h4>
            <input name="feature" class="files-data" id="imgInp" type="file">
            <p class="field-notice">
             Files must be less than 2 MB.
             <br>
             Allowed file types: .png / .gif / .jpg / .jpeg
           </p>
         </div>
       </div>
       <div class="text-center">
         <input type="submit" value="Save" class="site-btn-red">
       </div>
       <div class="field-wrap submit-wrap text-center">
         <div class="field-div error-div"></div>
       </div>
     </div>
    </form>
    </div>
    <div class="acc-blue-box">
      <form class="updatePetInformations" method="post" enctype="multipart/form-data">
       <input type="hidden" name="postId" value="<?php echo get_the_ID(); ?>">
       <input type="hidden" name="action" value="updatePetInformations">
       <div class="acc-blue-head">
        Pet Information
      </div>
      <div class="acc-blue-content">
        <div class="field-wrap two-fields-wrap">
         <div class="field-div">
          <label>*Pet Name:</label>
          <input type="text" name="title" value="<?php echo get_the_title(); ?>" placeholder="Enter pet name" required="">
        </div>
        <div class="field-div">
          <div class="field-wrap two-fields-wrap">
           <div class="field-div">
            <label>*Gender:</label>
            <select name="gender">
             <option value="male" <?php if ($mypod->display('gender') == 'male'){ echo "selected"; } ?>>Male</option>
             <option value="female" <?php if ($mypod->display('gender') == 'female'){ echo "selected"; } ?>>Female</option>
           </select>
         </div>
         <div class="field-div">
          <label>*Pet Type:</label>
          <?php
          $getTypes = get_top_parents('pet_type_and_breed');
          $type = $mypod->display('pet_type'); 
          ?>
          <select name="pet_type" class="text-data" id="pettype" required="" >
            <option value="">Type</option>
            <?php foreach ($getTypes as $key => $value) { ?>

             <option <?= ($value['term_id'] == $type) ? "selected" : ""; ?> value="<?= $value['term_id'] ?>"><?= $value['name'] ?></option>
             
           <?php } ?>
         </select>
       </div>
     </div>
    </div>
    </div>
    <div class="field-wrap two-fields-wrap">
     <div class="field-div">
      <label>Primary Breed:</label>
      <?php $primbred =  $mypod->display('primary_breed'); 
      $primchild = get_term_children( $type , "pet_type_and_breed" );

      ?>
      <select name="primary_breed" id="breedid">
       <option value="">Breed</option>
       <?php 
       foreach ($primchild as $key => $childTermId) {
        $primaryselected = ($primbred == $childTermId) ? 'selected' : '';
        echo "<option ".$primaryselected." value='".$childTermId."'>".get_term($childTermId)->name. "</option>";
      }
      ?>
    </select>
    </div>
    <div class="field-div">
      <label>Secondary Breed:</label>
      <?php $secbred = $mypod->display('secondary_breed');
      $secchild = get_term_children( $type , "pet_type_and_breed" );
      ?>
      <select name="secondary_breed" id="sbreedid">
       <option value="">Breed</option>
       <?php 
       foreach ($secchild as $key => $childTermId) {

        $secselected = ($secbred == $childTermId) ? 'selected' : '';
        echo "<option ".$secselected." value='".$childTermId."'>".get_term($childTermId)->name. "</option>";
      }
      ?>
    </select>
    </div>
    </div>
    <div class="field-wrap two-fields-wrap">
     <div class="field-div">
      <label>Primary Color:</label>
      <input type="text" name="primary_color" value="<?php echo $mypod->display('primary_color'); ?>" placeholder="Enter color of pet">
    </div>
    <div class="field-div">
      <label>Secondary Color(s):</label>
      <input type="text" name="secondary_color" value="<?php echo $mypod->display('secondary_color'); ?>" placeholder="Enter color(s) of pet">
    </div>
    </div>
    <div class="field-wrap two-fields-wrap">
     <div class="field-div">
      <label>Size:</label>
      <select name="size" class="text-data" id="psize">
       <?php $size = $mypod->display('size'); ?>
       <option value="">Select</option>
       <option value="1" <?= ($size == '1') ? 'selected' : '' ?>>1</option>
       <option value="2" <?= ($size == '2') ? 'selected' : '' ?>>2</option>
     </select>
    </div>
    <div class="field-div">
      <label>Pet Date of Birth:</label>
      <input type="text" id="datepicker" name="pet_date_of_birth" autocomplete="off" placeholder="mm/dd/yyyy" value="<?= $mypod->display('pet_date_of_birth'); ?>">
      <!-- <input type="text" name="pet_date_of_birth" value="<?php echo $mypod->display('pet_date_of_birth'); ?>" id="dob"> -->
    </div>
    </div>
    <div class="field-wrap two-fields-wrap">
     <div class="field-div">
      <label>Neutered/Spayed:</label>
      <select name="neutered_spayed">
       <option value="">Select</option>
       <option value="1" <?php if ($mypod->display('neutered_spayed') == 'Yes'){ echo "selected"; } ?>>Yes</option>
       <option value="0" <?php if ($mypod->display('neutered_spayed') == 'No'){ echo "selected"; } ?>>No</option>
     </select>
    </div>
    </div>
    <div class="field-wrap">
     <div class="field-div">
      <label>Shots/Vaccinations:</label>
      <?php 
      $string = ($mypod->display('shot')) ;
      $string = str_replace(", and"," and",$string);

      $shots = explode(', ', $string);
      $size = count($shots);

      if ($size > 0) {
        $pre = explode(' and ', $shots[$size-1]); 
        unset($shots[$size-1]);
        array_push($shots, trim($pre[0]));
        array_push($shots, trim($pre[1]));
      }

      ?>
      <div class="two-checks mb-15">
       <p><input type="checkbox" name="shot[]" value="Canine Distemper" class="shot" <?= (in_array('Canine Distemper', $shots)) ? "checked":""; ?> >Canine Distemper</p>
       <p><input type="checkbox" name="shot[]" value="Parainfluenza" class="shot" <?= (in_array('Parainfluenza', $shots)) ? "checked":""; ?>>Parainfluenza</p>
       <p><input type="checkbox" name="shot[]" value="Measles" class="shot" <?= (in_array('Measles', $shots)) ? "checked":""; ?>>Measles</p>
       <p><input type="checkbox" name="shot[]" value="Bordetella" class="shot" <?= (in_array('Bordetella', $shots)) ? "checked":""; ?>>Bordetella</p>
       <p><input type="checkbox" name="shot[]" value="Parvovirus" class="shot" <?= (in_array('Parvovirus', $shots)) ? "checked":""; ?>>Parvovirus</p>
       <p><input type="checkbox" name="shot[]" value="Leptospirosis" class="shot" <?= (in_array('Leptospirosis', $shots)) ? "checked":""; ?>>Leptospirosis</p>
       <p><input type="checkbox" name="shot[]" value="Hepatitis" class="shot" <?= (in_array('Hepatitis', $shots)) ? "checked":""; ?>>Hepatitis</p>
       <p><input type="checkbox" name="shot[]" value="Coronavirustitis" class="shot" <?= (in_array('Coronavirustitis', $shots)) ? "checked":""; ?>>Coronavirustitis</p>
       <p><input type="checkbox" name="shot[]" value="Rabies" class="shot" <?= (in_array('Rabies', $shots)) ? "checked":""; ?>>Rabies</p>
       <p><input type="checkbox" name="shot[]" value="Lyme" class="shot" <?= (in_array('Lyme', $shots)) ? "checked":""; ?>>Lyme</p>
       <p><input type="checkbox" name="shot[]" value="Respiratory disease from canine adenovirus-2 (CAV-2)" class="shot" <?= (in_array('Respiratory disease from canine adenovirus-2 (CAV-2)', $shots)) ? "checked":""; ?>>Respiratory disease from canine adenovirus-2 (CAV-2)</p>
     </div>
    </div>
    </div>
    <div class="field-wrap">
     <div class="field-div">
      <label>Unique Features:</label>
      <textarea name="unique_features" placeholder="Enter unique features"><?php echo $mypod->display('unique_features'); ?></textarea>
    </div>
    </div>
    <div class="field-wrap">
     <div class="field-div">
      <label>Special Needs:</label>
      <textarea name="special_needs" placeholder="Enter special needs"><?php echo $mypod->display('special_needs'); ?></textarea>
    </div>
    </div>
    <div class="field-wrap">
     <div class="field-div">
      <label>Allergies:</label>
      <textarea name="allergies" placeholder="Enter allergies"><?php echo $mypod->display('allergies'); ?></textarea>
    </div>
    </div>
    <div class="field-wrap submit-wrap text-center">
     <input type="submit" value="Save" class="site-btn-red">
    </div>
    <div class="field-wrap submit-wrap text-center">
     <div class="field-div error-div"></div>
    </div>
    </div>
    </form>
    </div>
    <div class="acc-blue-box">
      <form class="updateOwnerInformation" method="post" enctype="multipart/form-data">
       <input type="hidden" name="action" value="updateOwnerInformations">
       <div class="acc-blue-head">
        Owner Information
      </div>
      <div class="acc-blue-content">
        <div class="field-wrap two-fields-wrap">
         <div class="field-div">
          <label>*First Name:</label>
          <input type="text" name="primary_first_name" value="<?php echo get_the_author_meta("first_name",$userId); ?>" required="" placeholder="First Name" >
        </div>
        <div class="field-div">
          <label>Last Name:</label>
          <input type="text"  name="primary_last_name" value="<?php echo get_the_author_meta("last_name",$userId); ?>" placeholder="Last Name">
        </div>
      </div>
      <div class="field-wrap two-fields-wrap">
       <div class="field-div">
        <label>Email:</label>
        <input type="email" name="primary_email" id="primary_email" value="<?php echo get_the_author_meta("email",$userId); ?>" readonly>
        <span class="error-email"></span>
      </div>
      <div class="field-div">
        <label>Country:</label>
        <?php 
        $country = get_the_author_meta("primary_country",$userId);
        $countries_obj = new WC_Countries();
        $countries = $countries_obj->__get('countries');
        echo '<select name="primary_country" class="address-country">';
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
      <label>*Address:</label>
      <input type="text" name="primary_address_line1" value="<?php echo get_the_author_meta("primary_address_line1",$userId); ?>" required="" placeholder="Address line 1">
    </div>
    <div class="field-div">
      <label></label>
      <input type="text" name="primary_address_line2" value="<?php echo get_the_author_meta("primary_address_line2",$userId); ?>" placeholder="Address line 2">    
    </div>
    </div>
    <div class="field-wrap two-fields-wrap">
     <div class="field-div">
      <input type="text" name="primary_city" value="<?php echo get_the_author_meta("primary_city",$userId); ?>" required="" placeholder="City">
    </div>
    <div class="field-div">
      <div class="field-wrap two-fields-wrap">
       <div class="field-div">
        <label style="display: none;" class="statevalidate"></label>
        <select class="address-state" name="primary_state" data-val="<?php echo get_the_author_meta("primary_state",$userId);  ?>" placeholder="State"></select>
      </div>
      <div class="field-div">
        <input type="text" name="primary_postcode" value="<?php echo get_the_author_meta("primary_postcode",$userId); ?>" placeholder="Zipcode" required="">
      </div>
    </div>
    </div>
    </div>
    <div class="field-wrap two-fields-wrap">
     <div class="field-div">
      <label>*Primary Phone Number:</label>
      <input type="text" class="phone-number" name="primary_home_number" value="<?php echo get_the_author_meta("primary_home_number",$userId); ?>" required="" placeholder="1(555) 123-1234">
      <input type="hidden" name="primary_home_number_code" value="<?php echo get_the_author_meta("primary_phone_country_code",$userId); ?>" >
    </div>
    <div class="field-div">
      <label>Secondary Phone Number:</label>
      <input type="text" name="primary_cell_number" value="<?php echo get_the_author_meta("primary_cell_number",$userId); ?>" placeholder="1(555) 123-1234" class="phone-number">
      <input type="hidden" name="primary_cell_number_code" value="<?php echo get_the_author_meta("primary_cell_country_code",$userId); ?>" placeholder="1(555) 123-1234">
    </div>
    </div>
    <div class="field-wrap submit-wrap text-center">
      <div class="field-div">
        <input type="submit" value="Save" class="site-btn-red">
      </div>
    </div>
    <div class="field-wrap submit-wrap text-center">
     <div class="field-div error-div"></div>
    </div>
    </div>
    </form>
    </div>
    <div class="acc-blue-box">
      <form class="updateAlternateEmergencyInformation" method="post" enctype="multipart/form-data">
       <input type="hidden" name="action" value="updateAlternateEmergencyInformations">
       <div class="acc-blue-head">
        Alternate Emergency Contact
      </div>
      <div class="acc-blue-content">
        <div class="field-wrap two-fields-wrap">
         <div class="field-div">
          <label>*First Name:</label>
          <input type="text" name="secondary_first_name" value="<?php echo get_the_author_meta("secondary_first_name",$userId); ?>" required="" placeholder="First Name">
        </div>
        <div class="field-div">
          <label>Last Name:</label>
          <input type="text" name="secondary_last_name" value="<?php echo get_the_author_meta("secondary_last_name",$userId); ?>" placeholder="Last Name">
        </div>
      </div>
      <div class="field-wrap">
       <div class="field-div">
        <label>Country:</label>
        <?php 
        $country = get_the_author_meta("secondary_country",$userId);
        $countries_obj = new WC_Countries();
        $countries = $countries_obj->__get('countries');
        echo '<select name="secondary_country" class="address-country">';
        echo '<option value="">Select</option>';
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
      <label>*Address:</label>
      <input type="text" name="secondary_address_line1" value="<?php echo get_the_author_meta("secondary_address_line1",$userId); ?>" placeholder="Address line 1" required="">
    </div>
    <div class="field-div">
      <label></label>
      <input type="text" name="secondary_address_line2" value="<?php echo get_the_author_meta("secondary_address_line2",$userId); ?>" placeholder="Address line 2">
    </div>
    </div>
    <div class="field-wrap two-fields-wrap">
     <div class="field-div">
      <input type="text" name="secondary_city" value="<?php echo get_the_author_meta("secondary_city",$userId); ?>" required="" placeholder="City">
    </div>
    <div class="field-div">
      <div class="field-wrap two-fields-wrap">
       <div class="field-div">
        <label style="display: none;" class="statevalidate"></label>
        <select class="address-state" name="secondary_state" data-val="<?php echo get_the_author_meta("secondary_state",$userId);  ?>"></select>
      </div>
      <div class="field-div">
        <input type="text" name="secondary_postcode" value="<?php echo get_the_author_meta("secondary_postcode",$userId); ?>" placeholder="Zipcode" required="">
      </div>
    </div>
    </div>
    </div>
    <div class="field-wrap two-fields-wrap">
     <div class="field-div">
      <label>*Primary Phone Number:</label>
      <input type="text" name="secondary_home_number" value="<?php echo get_the_author_meta("secondary_home_number",$userId); ?>" required="" placeholder="1(555) 123-1234" class="phone-number">
      <input type="hidden" name="secondary_home_number_code" value="<?php echo get_the_author_meta("secondary_phone_country_code",$userId); ?>">
    </div>
    <div class="field-div">
      <label>Secondary Phone Number:</label>
      <input type="text" name="secondary_cell_number" value="<?php echo get_the_author_meta("secondary_cell_number",$userId); ?>" placeholder="1(555) 123-1234" class="phone-number">
      <input type="hidden" name="secondary_cell_number_code" value="<?php echo get_the_author_meta("secondary_cell_country_code",$userId); ?>" >
    </div>
    </div>
    <div class="field-wrap submit-wrap text-center">
     <div class="field-div">
      <input type="submit" value="Save" class="site-btn-red">
    </div>
    </div>
    <div class="field-wrap submit-wrap text-center">
     <div class="field-div error-div"></div>
    </div>
    </div>
    </form>
    </div>
    <div class="acc-blue-box">
      <form class="updateVaterinarianInformation" method="post" enctype="multipart/form-data">
       <input type="hidden" name="action" value="updateVaterinarianInformations">
       <input type="hidden" name="postId" value="<?php echo $post_id; ?>">
       <div class="acc-blue-head">
        Veterinarian Contact Information
      </div>
      <div class="acc-blue-content">
        <div class="field-wrap two-fields-wrap">
         <div class="field-div">
          <label>*Clinic Name:</label>
          <input type="text" name="clinic_name" value="<?php echo $mypod->display("clinic_name"); ?>" required="" placeholder="Clinic Name">
        </div>
        <div class="field-div">
          <label>*Veterinarian First/Last Name:</label>
          <input type="text" name="vaterinarian_firstlast_name" value="<?php echo $mypod->display("vaterinarian_firstlast_name"); ?>" required="" placeholder="Vaterinarian First/Last Name">
        </div>
      </div>
      <div class="field-wrap two-fields-wrap">
       <div class="field-div">
        <label>Country:</label>
        <?php 
        $country = $mypod->display("vaterinarian_country");
        $countries_obj = new WC_Countries();
        $countries = $countries_obj->__get('countries');
        echo '<select name="vaterinarian_country" class="address-country">';
        echo '<option value="">Select</option>';
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
    <div class="field-div">
      <label>*Email:</label>
      <input type="email" name="vaterinarian_email" id="vaterinarian_email" value="<?php echo $mypod->display("vaterinarian_email"); ?>" placeholder="Enter Email Address">
    </div>
    </div>
    <div class="field-wrap two-fields-wrap">
     <div class="field-div">
      <label>*Address:</label>
      <input type="text" name="vaterinarian_address_line_1" value="<?php echo $mypod->display("vaterinarian_address_line_1"); ?>" required="" placeholder="Address line 1">
    </div>
    <div class="field-div">
      <label></label>
      <input type="text" name="vaterinarian_address_line_2" value="<?php echo $mypod->display("vaterinarian_address_line_2"); ?>" placeholder="Address line 2">    
    </div>
    </div>
    <div class="field-wrap two-fields-wrap">
     <div class="field-div">
      <input type="text" name="vaterinarian_city" value="<?php echo $mypod->display("vaterinarian_city"); ?>" required="" placeholder="City">
    </div>
    <div class="field-div">
      <div class="field-wrap two-fields-wrap">
       <div class="field-div">
        <label class="statevalidate" style="display: none;"></label>
        <select class="address-state" name="vaterinarian_state" data-val="<?php echo $mypod->display("vaterinarian_state");  ?>"></select>
      </div>
      <div class="field-div">
        <input type="text" name="vaterinarian_zip_code" value="<?php echo $mypod->display("vaterinarian_zip_code"); ?>" placeholder="Zipcode" required="">
      </div>
    </div>
    </div>
    </div>
    <div class="field-wrap two-fields-wrap">
     <div class="field-div">
      <label>*Primary Phone Number:</label>
      <input type="text" name="vaterinarian_primary_phone_number" value="<?php echo $mypod->display("vaterinarian_primary_phone_number"); ?>" required="" placeholder="1(555) 123-1234" class="phone-number">
      <input type="hidden" name="vaterinarian_primary_phone_number_code" value="<?php echo $mypod->display("vaterinarian_primary_phone_number_code"); ?>">
    </div>
    <div class="field-div">
      <label>Secondary Phone Number:</label>
      <input type="text" name="vaterinarian_secondary_phone_number" value="<?php echo $mypod->display("vaterinarian_secondary_phone_number"); ?>" placeholder="1(555) 123-1234" class="phone-number">
      <input type="hidden" name="vaterinarian_secondary_phone_number_code" value="<?php echo $mypod->display("vaterinarian_secondary_phone_number_code"); ?>" placeholder="1(555) 123-1234">
    </div>
    </div>
    <div class="field-wrap submit-wrap text-center">
     <div class="field-div">
      <input type="submit" value="Save" class="site-btn-red">
    </div>
    </div>
    <div class="field-wrap submit-wrap text-center">
     <div class="field-div error-div"></div>
    </div>
    </div>
    </form>
    </div>
               <!-- <div class="last-button">
                  <div class="text-right">
                      <input type="button" name="update_all_information" id="update_all_information" value="Save All" class="site-btn-red">
                  </div>
                </div> -->
              </div>
            </div>
          </div>
          <script type="text/javascript">
           jQuery(document).ready(function(){

            //datepicker modify
            // $('#datepicker').datepicker(function(){
            //    var d = new Date();
            //    var curr_date = d.getDate();
            //    var curr_month = d.getMonth() + 1;
            //    var curr_year = d.getFullYear();
            //    document.write(curr_date + "-" + curr_month + "-" + curr_year);
            // });

            var today = new Date();
            $("#datepicker").datepicker({
              dateFormat : "mm/dd/yy",
              endDate: "today",
              maxDate: today,
              changeMonth: true,
              changeYear: true,
              onSelect: function() { 
                var Pdb = $(this).val(); 
                $("#ptdob").text(Pdb);
              }
            });

             //validate pet image size
             jQuery.validator.addMethod("checkSize", function (value, element) {
               var size = element.files[0].size;
                 if (size > 2*1000000)// checks the file more than 1 MB
                 {
                   return false;
                 } else {
                  return true;
                }

              }, "File must be less then 2MB");


             jQuery(".shown").click(function(){
               jQuery(".main-show").show();
               jQuery(".main-edit").hide();
             });
             jQuery(".edited").click(function(){
               jQuery(".main-show").hide();
               jQuery(".main-edit").show();
             });
             jQuery(".edit-url").click(function(){
               jQuery(".main-show").hide();
               jQuery(".main-edit").show();
             });
             $(function() { 
              $("form[name='imageUpload']").validate({
               rules: {
                feature:{
                 required : true,
                 extension: "jpg|png|gif|bmp|jpeg",
                 checkSize: true
               }, 
             },
             submitHandler: function(form) {
              $("body").find(".loader-wrap").fadeIn();
              $.ajax({
                type: 'POST',
                url: ajaxurl,
                data: new FormData(form),
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function(response) {
                  $("body").find(".loader-wrap").fadeOut();
                  if (response.success) {
                    location.reload(true);
                  }else{
                    $("form.uploadImage .error-div").html('<div class="alert alert-danger alert-dismissible" style="margin-top:18px;"><a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>'+response.msg+'</div>');
                  }
                }
              });
            }
          });
            });

             $(function() {        
               $("form[class='updatePetInformations']").validate({
                 submitHandler: function(form) {
                   $("body").find(".loader-wrap").fadeIn();
                   $.ajax({
                     type: 'POST',
                     url: ajaxurl,
                     data: new FormData(form),
                     contentType: false,
                     processData: false,
                     dataType: 'json',
                     success: function(response) {
                       $("body").find(".loader-wrap").fadeOut();
                       if (response.success) {
                         location.reload(true);
                       }else{
                         $("form[class='updatePetInformations'] .error-div").html('<div class="alert alert-danger alert-dismissible" style="margin-top:18px;"><a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>'+response.msg+'</div>');
                       }
                     }
                   }); 
                 }   
               });

               $("form[class='updateOwnerInformation']").validate({
                 rules: {
                   primary_postcode: {
                     number: true,
                     minlength: 5,
                     maxlength: 5,
                   },
                   primary_home_number: {
                     required: true,
                     number: true,
                     minlength: 10,
                     maxlength: 10,
                   },
                   primary_cell_number: {
                     required: true,
                     number: true,
                     minlength: 10,
                     maxlength: 10,
                   },
                 },    
                 messages: {
                   primary_postcode: {
                     minlength :"The phone number must be 5 digits.",
                     maxlength :"The phone number must be 5 digits.",
                   },
                   primary_home_number: "The phone number must be 10 digits.",
                   primary_cell_number: "The phone number must be 10 digits.",

                 },
                 submitHandler: function(form) {
                   $("body").find(".loader-wrap").fadeIn();
                   $.ajax({
                     type: 'POST',
                     url: ajaxurl,
                     data: new FormData(form),
                     contentType: false,
                     processData: false,
                     dataType: 'json',
                     success: function(response) {
                       $("body").find(".loader-wrap").fadeOut();
                       console.log(response.msg);
                       if (response.success) {
                        location.reload(true);
                      }else{
                       $("form[class='updateOwnerInformation'] .error-div").html('<div class="alert alert-danger alert-dismissible" style="margin-top:18px;"><a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>'+response.msg+'</div>');
                     }
                   }
                 }); 
                 }   
               });
               $("form[class='updateAlternateEmergencyInformation']").validate({
                 rules: {
                   secondary_postcode: {
                     number: true,
                     minlength: 5,
                     maxlength: 5,
                   },
                   secondary_home_number: {
                     required: true,
                     number: true,
                     minlength: 10,
                     maxlength: 10,
                   },
                   secondary_cell_number: {

                     number: true,
                     minlength: 10,
                     maxlength: 10,
                   },
                 },    
                 messages: {
                   secondary_postcode:{
                     minlength :"The Zipcode must be 5 digits.",
                     maxlength : "The Zipcode must be 5 digits.",
                   }, 
                   secondary_home_number: "The phone number must be 10 digits.",
                   secondary_cell_number: "The phone number must be 10 digits.",

                 },
                 submitHandler: function(form) {
                   $("body").find(".loader-wrap").fadeIn();
                   $.ajax({
                     type: 'POST',
                     url: ajaxurl,
                     data: new FormData(form),
                     contentType: false,
                     processData: false,
                     dataType: 'json',
                     success: function(response) {
                       $("body").find(".loader-wrap").fadeOut();
                       if (response.success) {
                         location.reload(true);
                       }else{
                         $("form[class='updateAlternateEmergencyInformation'] .error-div").html('<div class="alert alert-danger alert-dismissible" style="margin-top:18px;"><a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>'+response.msg+'</div>');
                       }
                     }
                   }); 
                 }   
               });
               $("form[class='updateVaterinarianInformation']").validate({
                rules: {
                 vaterinarian_primary_phone_number: {
                   required:true,
                   number: true,
                   minlength: 10,
                   maxlength: 10
                 },
                 vaterinarian_secondary_phone_number: {
                   number: true,
                   minlength: 10,
                   maxlength: 10
                 },
                 vaterinarian_zip_code: {
                   number: true,
                   minlength: 5,
                   maxlength: 5
                 },
               },

               messages: {
                vaterinarian_primary_phone_number: {
                 minlength : "The phone number must be 10 digits.",
                 maxlength : "The phone number must be 10 digits.",
               },
               vaterinarian_secondary_phone_number: {
                 minlength : "The phone number must be 10 digits.",
                 maxlength : "The phone number must be 10 digits.",
               },
               vaterinarian_zip_code: {
                 minlength : "The Zipcode must be 5 digits.",
                 maxlength : "The Zipcode must be 5 digits.",
               },

             },
             submitHandler: function(form) {
               $.ajax({
                 type: 'POST',
                 url: ajaxurl,
                 data: new FormData(form),
                 contentType: false,
                 processData: false,
                 dataType: 'json',
                 success: function(response) {
                   if (response.success) {
                     $("form[class='updateVaterinarianInformation'] .error-div").html('<div class="alert alert-success alert-dismissible" style="margin-top:18px;"><a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a><strong>Success!</strong> '+response.msg+'</div>');
                   }else{
                     $("form[class='updateVaterinarianInformation'] .error-div").html('<div class="alert alert-danger alert-dismissible" style="margin-top:18px;"><a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>'+response.msg+'</div>');
                   }
                 }
               }); 
             }   
           });
             });
             /*jQuery("#update_all_information").click(function(){
                 var val     = jQuery(this).attr('name');
                 var vemail  = jQuery("#vaterinarian_email").val();
                 var semail  = jQuery("#secondary_email").val();
                 var pemail  = jQuery("#primary_email").val();
                 var output  = 1;
                 jQuery("#action").val(val);
                 if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,5})+$/.test(vemail)){
                     jQuery("#vaterinarian_email").next('.error-email').text("");
                 }else{
                     jQuery("#vaterinarian_email").next('.error-email').text("Enter Currect format of email address");
                     output = 0;
                 }
                 if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,5})+$/.test(semail)){
                     jQuery("#secondary_email").next('.error-email').text("");
                 }else{
                     jQuery("#secondary_email").next('.error-email').text("Enter Currect format of email address");
                     output = 0;
                 }
                 if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,5})+$/.test(pemail)){
                     jQuery("#primary_email").next('.error-email').text("");
                 }else{
                     jQuery("#primary_email").next('.error-email').text("Enter Currect format of email address");
                     output = 0;
                 }
         
                 if (output) {
                     jQuery("form.update-form").submit();
                 }else{
                     return false;
                 }
             });
             jQuery(document).ready(function($) {
                 $("#dob").datepicker({
                     dateFormat : "mm/dd/yy"
                 });
               });*/
             });
           </script>
           <?php 
           if ($size > 9) { ?>
            <script type="text/javascript">
             jQuery(document).ready(function(){
               jQuery(".shot").each(function(){
                 jQuery(this).attr("checked","checked");
               });

             });
           </script>
           <?php   
         }else{ 
           if ($size > 1) {
             foreach ($shots as $value) { ?>
              <script type="text/javascript">
               jQuery(document).ready(function(){
                 jQuery(".shot").each(function(){
                   var shot  = jQuery(this).val();
                   var shot2 = '<?php echo $value;  ?>';
                   if (shot == shot2) {
                     jQuery(this).attr("checked","checked");
                   }
                 });

               });
             </script>            
             <?php           
           }
         }else{ ?>
          <script type="text/javascript">
           jQuery(document).ready(function(){
             jQuery(".shot").each(function(){
               var shot  = jQuery(this).val();
               var shot2 = '<?php echo $shot;  ?>';
               if (shot == shot2) {
                 jQuery(this).attr("checked","checked");
               }
             });

           });
         </script>
       <?php   }  
     }
    endwhile;
  }
