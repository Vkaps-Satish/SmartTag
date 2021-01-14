<?php

 $user_id                    = get_current_user_id(); 
 $single                     = true; 
 $current_user               = get_user_by( 'id', $user_id );
 $first_name                 = get_user_meta( $user_id, 'first_name', $single ); 
 $last_name                  = get_user_meta( $user_id, 'last_name', $single ); 
 $email                      = $current_user->user_email; 
 $primary_country            = get_user_meta( $user_id, 'primary_country', $single ); 
 $primary_address_line1      = get_user_meta( $user_id,'primary_address_line1', $single ); 
 $primary_address_line2      = get_user_meta( $user_id,'primary_address_line2', $single ); 
 $primary_city               = get_user_meta( $user_id,'primary_city', $single ); 
 $primary_state              = get_user_meta( $user_id,'primary_state', $single ); 
 $primary_postcode           = get_user_meta( $user_id,'primary_postcode', $single ); 
 $primary_home_number        = get_user_meta( $user_id,'primary_home_number', $single ); 
 $primary_cell_number        = get_user_meta( $user_id,'primary_cell_number', $single ); 

 $Sfirst_name                = get_user_meta( $user_id, 'secondary_first_name', $single ); 
 $Slast_name                 = get_user_meta( $user_id, 'secondary_last_name', $single ); 
 $Semail                     = get_user_meta( $user_id, 'secondary_email', $single );
 $Sprimary_country           = get_user_meta( $user_id, 'secondary_country', $single ); 
 $Sprimary_address_line1     = get_user_meta( $user_id,'secondary_address_line1', $single ); 
 $Sprimary_address_line2     = get_user_meta( $user_id,'secondary_address_line2', $single ); 
 $Sprimary_city              = get_user_meta( $user_id,'secondary_city', $single ); 
 $Sprimary_state             = get_user_meta( $user_id,'secondary_state', $single ); 
 $Sprimary_postcode          = get_user_meta( $user_id,'secondary_postcode', $single ); 
 $Sprimary_home_number       = get_user_meta( $user_id,'secondary_home_number', $single ); 
 $Sprimary_cell_number       = get_user_meta( $user_id,'secondary_cell_number', $single );





  $countries_obj = new WC_Countries();
  $countries = $countries_obj->__get('countries'); 

 ?>

 <div class="page-heading">
     <h1>Add a Pet ID to My Account</h1>
 </div>
 <div>
    <form method="post">
    <div class="pp-tabs-nav">
          <button type="submit" class="pp-tabs-nav-inner pp-tab-option-1 <?php echo (($_POST['template'] != 'microchipIdTag') && ($_POST['template'] != 'UniversalmicrochipIdTag')) ? "active" : "" ?> " name="template" value="smartTagIdTag">SmartTag Register</button>
           <button class="pp-tabs-nav-inner pp-tab-option-2 <?php echo ($_POST['template'] == 'microchipIdTag') ? "active" : "" ?> " type="submit" name="template" value="microchipIdTag">Microchip Register</button>
          <button class="pp-tabs-nav-inner pp-tab-option-2 <?php echo ($_POST['template'] == 'UniversalmicrochipIdTag') ? "active" : "" ?>" type="submit" name="template" value="UniversalmicrochipIdTag">Universal Microchip Register</button>
      </div>
      </form>
     <!-- <form method="post">
         <button type="submit" class="active" name="template" value="smartTagIdTag">SmartTag Register</button>
         <button type="submit" name="template" value="microchipIdTag">Microchip Register</button>
         <button type="submit" name="template" value="UniversalmicrochipIdTag">Universal Microchip Register</button>
     </form> -->
 </div>
 <div id="woo-content">
 <?php 
 if(!empty($_POST['template']) && $_POST['template'] == 'UniversalmicrochipIdTag'){
  
    get_template_part( 'register', 'universalmicrochipIdTag' ); 

 }else if(!empty($_POST['template']) && $_POST['template'] == 'microchipIdTag'){
    
    get_template_part( 'register', 'microchipIdTag' ); 
 
 }else{
    get_template_part( 'register', 'smartTagIdTag' ); 
 }
 ?>
</div>
<?php 