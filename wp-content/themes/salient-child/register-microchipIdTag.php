<?php 
   /*
   * Template Name: Register Micochip Id Tag
   */
   global $protectionArrangement,$heth_proid;
   
   $getbreeds = get_top_parents('pet_type_and_breed');
   $single     = true; 
   $user_id       = get_current_user_id(); 
   $countries_obj    = new WC_Countries();
   $countries     = $countries_obj->__get('countries');
   $current_user   = get_user_by( 'id', $user_id );
   $first_name    = get_user_meta($user_id,'first_name',$single); 
   $last_name      = get_user_meta($user_id,'last_name', $single); 
   $email          = $current_user->user_email; 
   $primary_country= get_user_meta($user_id,'primary_country',$single);
   $primary_address_line1 = get_user_meta($user_id,'primary_address_line1',$single);
   $primary_address_line2 = get_user_meta($user_id,'primary_address_line2',$single);
   $primary_city        = get_user_meta($user_id,'primary_city',$single); 
   $primary_state          = get_user_meta($user_id,'primary_state',$single);
   $primary_postcode       = get_user_meta($user_id,'primary_postcode',$single); 
   $primary_home_number   = get_user_meta($user_id,'primary_home_number',$single); 
   $primary_cell_number   = get_user_meta($user_id,'primary_cell_number',$single); 
   $Sfirst_name          = get_user_meta($user_id,'secondary_first_name',$single); 
   $Slast_name           = get_user_meta($user_id,'secondary_last_name',$single); 
   $Semail            = get_user_meta($user_id,'secondary_email',$single);
   $Sprimary_country      = get_user_meta($user_id,'secondary_country',$single); 
   $Sprimary_address_line1= get_user_meta($user_id,'secondary_address_line1',$single); 
   $Sprimary_address_line2= get_user_meta($user_id,'secondary_address_line2',$single); 
   $Sprimary_city       = get_user_meta($user_id,'secondary_city',$single);
   $Sprimary_state      = get_user_meta($user_id,'secondary_state',$single); 
   $Sprimary_postcode      = get_user_meta($user_id,'secondary_postcode',$single); 
   $Sprimary_home_number  = get_user_meta($user_id,'secondary_home_number',$single); 
   $Sprimary_cell_number  = get_user_meta($user_id,'secondary_cell_number',$single);
   ?>
<section class="multi-step-form">
   <form id="profileuser1" method="POST" enctype="multipart/form-data">
      <!--   <script src='https://www.google.com/recaptcha/api.js'></script> -->
      <fieldset aria-label="Step One" tabindex="-1" id="step-1" class="step-form-box">
         <div class="contact-form" id="pro-info">
            <div class="field-wrap two-fields-wrap">
               <div class="field-div">
                  <label>*Microchip Id Number</label>
                  <input type="text" placeholder="Microchip Id Number" name="microchip_id" class="text-data" id="sname_input" /> <span class="error" id="error"></span>
               </div>
               <div class="field-div">
                  <label></label>
                  <input type="text" name="conf_microchip_id" placeholder="Confirm Microchip Id Number" class="text-data" />
               </div>
            </div>
            <div class="field-wrap two-fields-wrap">
               <div class="field-div">
                  <label>*Pet Name</label>
                  <input type="text" name="pet_name" class="text-data" id="pname_input" placeholder="Enter Pet Name" required="" />
               </div>
               <div class="field-div">&nbsp;</div>
            </div>
            <div class="field-wrap two-fields-wrap">
               <div class="field-div">
                  <label>*Pet Type & Breed</label>
                  <div class="field-wrap two-fields-wrap">
                     <div class="field-div">
                        <select name="pet_type" class="text-data" id="pettype" required=""  >
                           <option value="">Type</option>
                           <?php foreach ($getbreeds as $key => $value) { ?>
                           <option value="<?= $value['term_id'] ?>"><?= $value['name'] ?></option>
                           <?php } ?>
                        </select>
                     </div>
                     <div class="field-div">
                        <select name="primary_breed" class="text-data" id="breedid" required="" />
                           <option value="">Breed</option>
                        </select>
                     </div>
                  </div>
               </div>
               <div class="field-div">
                  <label>Secondary Breed (Optional)</label>
                  <select name="secondary_breed" class="text-data" id="sbreedid" />
                     <option value="">Breed</option>
                  </select>
               </div>
            </div>
            <div class="field-wrap two-fields-wrap">
               <div class="field-div">
                  <label>*Primary Color</label>
                  <input type="text" name="primary_color" placeholder="Enter color of pet" class="text-data" id="pcolor" required="" />
               </div>
               <div class="field-div">
                  <label>Secondary Color(s) (Optional)</label>
                  <input type="text" name="secondary_color" placeholder="Enter color(s) of pet" class="text-data" id="scolor" />
               </div>
            </div>
            <div class="field-wrap two-fields-wrap">
               <div class="field-div">
                  <div class="field-wrap two-fields-wrap">
                     <div class="field-div">
                        <label>*Gender</label>
                        <select name="gender" class="text-data" id="pgender" required="" />
                           <option value="">Select</option>
                           <option value="male">Male</option>
                           <option value="Female">Female</option>
                        </select>
                     </div>
                     <div class="field-div">
                        <label>Size(Optional)</label>
                        <select name="size" class="text-data" id="psize">
                           <option value="">Select</option>
                           <option value="1">1</option>
                           <option value="2">2</option>
                        </select>
                     </div>
                  </div>
               </div>
               <div class="field-div">
                  <label>Pet Date of Birth (Optional)</label>
                  <div class="field-wrap three-fields-wrap ">
                     <input type="text" name="pet_date_of_birth" id="pet-dob1" placeholder="mm/dd/yyyy" class="input-10 input text-data">
                  </div>
               </div>
            </div>
            <div class="field-wrap two-fields-wrap">
               <div class="field-div">
                  <label class="auto-height">
                  <?php __( 'Upload Pet Image)', 'cvf-upload'); ?>
                  </label>
                  <label>Upload Pet Image</label>
                  <input type="file" name="files" class="files-data" multiple id="imgInp" required="" />
               </div>
               <div class="field-div">
                  <label></label>
                  <div class="field-notice">File must be less than 2MB.
                     <br>Allowed file types .png/ .gif/ .jpg/ .jpeg
                  </div>
               </div>
            </div>
         </div>
         <div class="step-btns">
            <button class="btn btn-default btn-next" type="button" aria-controls="step-2">Next <i class="fa fa-caret-right"></i>
            </button>
         </div>
      </fieldset>
      <fieldset aria-label="Step Two" tabindex="-1" id="step-2" class="step-form-box">
         <div class="contact-form" id="cus-info">
            <div class="field-wrap two-fields-wrap">
               <input type="hidden" name="UsrLoginId" class="user-data" value="<?php echo $user_id;?>" />
               <div class="field-div">
                  <label>*First Name </label>
                  <input type="text" name="p_fst_name" placeholder="First Name" class="user-data" id="u-first" required="" value="<?php echo $first_name;?>" />
               </div>
               <div class="field-div">
                  <label>*Last Name </label>
                  <input type="text" name="p_lst_name" placeholder="Last Name" class="user-data" id="u-last" required="" value="<?php echo $last_name;?>"   />
               </div>
            </div>
            <div class="field-wrap two-fields-wrap">
               <div class="field-div">
                  <label>*Email </label>
                  <input type="email" name="p_email" placeholder="Enter Email Address" class="user-data" id="u-email" required="" disabled value="<?php echo $email;?>"    />
               </div>
               <div class="field-div">
                  <label>*Select Your Country </label>
                  <select name="p_country" class="user-data address-country" id="u-country" required="" >
                     <option value="">Select</option>
                     <?php foreach ($countries as $key => $value) {?>
                     <option value="<?php echo $key; ?>" <?php if(!empty($primary_country) && $primary_country  == $key){ echo 'selected="selected"';}?>><?php echo $value;?></option>
                     <?php } ?>
                  </select>
               </div>
            </div>
            <div class="field-wrap two-fields-wrap">
               <div class="field-div">
                  <label>*Address</label>
                  <input type="text" name="p_add1" placeholder="Address line 1" class="user-data" id="u-add1" required="" value="<?php echo $primary_address_line1;?>"  />
               </div>
               <div class="field-div">
                  <label></label>
                  <input type="text" name="p_add2" placeholder="Address line 2" class="user-data" id="u-add2" value="<?php echo $primary_address_line2;?>"  />
               </div>
            </div>
            <div class="field-wrap two-fields-wrap">
               <div class="field-div">
                  <input type="text" name="p_city" placeholder="City" class="user-data" id="u-city1" required="" value="<?php echo $primary_city;?>" />
               </div>
               <div class="field-div">
                  <div class="field-wrap two-fields-wrap">
                     <div class="field-div">
                        <label class="statevalidate" style="display: none"></label>
                        <select name="p_state" class="user-data address-state s-sate rq" data-val="<?php echo $primary_state; ?>"></select>
                     </div >
                     <div class="field-div">
                        <input type="text" name="p_zipcode" placeholder="Zipcode" class="user-data" id="u-zip" required="" value="<?php echo $primary_postcode;?>" />
                     </div>
                  </div>
               </div>
            </div>
            <!-- <div class="field-wrap two-fields-wrap">
               <div class="field-div">
                  <label>*Primary Phone Number </label>
                  <input type="number" name="p_prm_no" placeholder="1(555) 123-1234" class="user-data" id="p-phone"  required="" readonly value="<?php echo $primary_home_number;?>"/>
               </div>
               <div class="field-div">
                  <label>Secondary Phone Number </label>
                  <input type="number" name="p_sec_no" placeholder="1(555) 123-1234" class="user-data" id="ps-phone" value="<?php echo $primary_cell_number;?>" />
               </div>
            </div> -->
         </div>
         <div class="step-accordion">
            <h4 class="step-acc-head" id="sec-form"><i class="fa fa-plus"></i> Enter Secondary Contact Information (Optional)</h4>
            <div class="step-acc-content">
               <div class="contact-form" id="sec-cont-info">
                  <div class="field-wrap two-fields-wrap">
                     <div class="field-div">
                        <label>First Name</label>
                        <input type="text" name="s_fst_name" placeholder="First Name" class="user-data" id="s-name" value="<?php echo $Sfirst_name;?>" />
                     </div>
                     <div class="field-div">
                        <label>Last Name</label>
                        <input type="text" name="s_lst_name" placeholder="Last Name" class="user-data" id="s-lstname" value="<?php echo $Slast_name;?>" />
                     </div>
                  </div>
                  <div class="field-wrap two-fields-wrap">
                     <div class="field-div">
                        <label>Email</label>
                        <input type="email" name="s_email" placeholder="Enter Email Address" class="user-data" id="s-email" value="<?php echo $Semail;?>" />
                     </div>
                     <div class="field-div">
                        <label>Select Your Country</label>
                        <select name="s_country" class="user-data address-country not-require" id="s-county">
                           <option value="">Select</option>
                           <?php foreach ($countries as $key=>$value) {?>
                           <option value="<?php echo $key; ?>" <?php if(!empty($Sprimary_country) && $Sprimary_country==$key){ echo 'selected="selected"';}?>>
                              <?php echo $value;?>
                           </option>
                           <?php } ?>
                        </select>
                     </div>
                  </div>
                  <div class="field-wrap two-fields-wrap">
                     <div class="field-div">
                        <label>Address</label>
                        <input type="text" name="s_add1" placeholder="Address line 1" class="user-data" id="sadd1" value="<?php echo $Sprimary_address_line1;?>" />
                     </div>
                     <div class="field-div">
                        <label></label>
                        <input type="text" name="s_add2" placeholder="Address line 2" class="user-data" id="s-add2" value="<?php echo $Sprimary_address_line2;?>" />
                     </div>
                  </div>
                  <div class="field-wrap two-fields-wrap">
                     <div class="field-div">
                        <input type="text" name="s_city" placeholder="City" class="user-data" id="s_city1" value="<?php echo $Sprimary_city;?>" />
                     </div>
                     <div class="field-div">
                        <div class="field-wrap two-fields-wrap">
                           <div class="field-div state-div">
                              <label class="statevalidate" style="display: none"></label>
                              <select type="text" name="s_state" class="user-data address-state not-require" id="s-state" placeholder="State" data-val="<?php echo $Sprimary_state;?>"></select>
                           </div>
                           <div class="field-div">
                              <input type="text" name="s_zipcode" placeholder="Zipcode" class="user-data" id="s-zip" value="<?php echo $Sprimary_postcode;?>" />
                           </div>
                        </div>
                     </div>
                  </div>
                  <!-- <div class="field-wrap two-fields-wrap">
                     <div class="field-div">
                        <label>Primary Phone Number</label>
                        <input type="number" name="s_prm_no" placeholder="1(555) 123-1234" class="user-data" id="sp-phone" value="<?php echo $Sprimary_home_number;?>" />
                     </div>
                     <div class="field-div">
                        <label>Secondary Phone Number</label>
                        <input type="number" name="s_sec_no" placeholder="1(555) 123-1234" class="user-data" id="ss-phone" value="<?php echo $Sprimary_cell_number;?>" />
                     </div>
                  </div> -->
               </div>
            </div>
         </div>
         <div class="step-accordion">
            <h4 class="step-acc-head" id="vt-form"><i class="fa fa-plus"></i> Enter Veterinarian Contact Information (Optional)</h4>
            <div class="step-acc-content">
               <div class="contact-form" id="vetcont-info">
                  <div class="field-wrap two-fields-wrap">
                     <div class="field-div">
                        <label>First Name </label>
                        <input type="text" name="vaterinarian_first_name" placeholder="First Name" class="text-data" id="v-first" />
                     </div>
                     <div class="field-div">
                        <label>Last Name </label>
                        <input type="text" name="vaterinarian_last_name" placeholder="Last Name" class="text-data" id="v-last" />
                     </div>
                  </div>
                  <div class="field-wrap two-fields-wrap">
                     <div class="field-div">
                        <label>Email </label>
                        <input type="email" name="vaterinarian_email" placeholder="Enter Email Address" class="text-data" id="v-email" />
                     </div>
                     <div class="field-div">
                        <label>Select Your Country </label>
                        <select name="vaterinarian_country" class="user-data address-country not-require" id="v-cuntry" >
                           <option value="">Select</option>
                           <?php foreach ($countries as $key => $value) {?>
                           <option value="<?php echo $key; ?>"><?php echo $value;?></option>
                           <?php } ?>
                        </select>
                     </div>
                  </div>
                  <div class="field-wrap two-fields-wrap">
                     <div class="field-div">
                        <label>Address </label>
                        <input type="text" name="vaterinarian_address_line_1" placeholder="Address line 1" class="text-data" id="v-add1" />
                     </div>
                     <div class="field-div">
                        <label></label>
                        <input type="text" name="vaterinarian_address_line_2" placeholder="Address line 2" class="text-data" id="v-add2" />
                     </div>
                  </div>
                  <div class="field-wrap two-fields-wrap">
                     <div class="field-div">
                        <input type="text" name="vaterinarian_city" placeholder="City" class="text-data" id="v-city1" />
                     </div>
                     <div class="field-div">
                        <div class="field-wrap two-fields-wrap">
                           <div class="field-div">
                              <label style="display: none;" class="statevalidate" ></label>
                              <input type="text" name="vaterinarian_state" class="text-data address-state not-require" id="v-state" placeholder="State" data-val="">
                           </div>
                           <div class="field-div">
                              <input type="text" name="vaterinarian_zip_code" placeholder="Zipcode" class="text-data" id="v-zip" />
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="field-wrap two-fields-wrap">
                     <div class="field-div">
                        <label>Primary Phone Number </label>
                        <input type="text" name="vaterinarian_primary_phone_number" placeholder="1(555) 123-1234" class="text-data phone-number" id="v-prim"/>
                        <input type="hidden" name="vaterinarian_primary_phone_number_code" placeholder="1(555) 123-1234" class="text-data" />
                     </div>
                     <div class="field-div">
                        <label>Secondary Phone Number </label>
                        <input type="text" name="vaterinarian_secondary_phone_number" placeholder="1(555) 123-1234" class="text-data phone-number" id="v-sec" />
                        <input type="hidden" name="vaterinarian_secondary_phone_number_code" placeholder="1(555) 123-1234" class="text-data" />
                     </div>
                  </div>
                  <!-- <div class="field-wrap two-fields-wrap">
                     <div class="field-div">
                        <input type="submit" name="submit" value="Sumbit Pet Veterinarian Info">
                     </div>
                     </div>    -->
               </div>
            </div>
         </div>
         <div class="step-btns">
            <button class="btn btn-default btn-prev" type="button" aria-controls="step-1"><i class="fa fa-caret-left"></i> Back</button>
            <button class="btn btn-default btn-next" type="button" aria-controls="step-3">Next <i class="fa fa-caret-right"></i></button>
         </div>
      </fieldset>
      <fieldset aria-label="Step Three" tabindex="-1" id="step-3" class="step-form-box">
         <div class="pp-tabs-content steps-pp-tabs-content" style="display: block;">
            <div class="pp-icon-wrap">
               <div class="pp-icon"></div>
               <h3>Pet Protection Plans</h3>
            </div>
            <div class="pp-table-wrap">
               <table class="pp-table">
                  <thead>
                     <tr>
                        <th class="pp-upgrade">
                           <div>Upgrade to lifetime plan and save up to 80%</div>
                        </th>
                        <th class="pp-silver">
                           <h2>SILVER</h2>
                           <h3>SmartTag Microchips include FREE Silver Lifetime Plan.</h3>
                           <input type="hidden" id="FreePlan" filed="productid" proid="<?= $ssil1;?>" class="site-btn subPlans AddSubscription" checked="checked" />
                        </th>
                        <th class="pp-gold">
                           <h2>GOLD</h2>
                           <div class="pp-membership-plan">
                              <div class="pp-plan-name">Microchip 1 Year Plan</div>
                              <div class="pp-plan-price">
                                 <h3>$9.95</h3>
                                 <span>per year</span>
                              </div>
                              <div class="pp-adc-btn">   
                                 <a href="javascript:void(0)" id="Sgol1" filed="productid" proid="<?php echo $sgol1;?>" class="site-btn subPlans">Add to Cart <i class="fa fa-shopping-cart"></i></a>
                              </div>
                           </div>
                           <div class="pp-membership-plan">
                              <div class="pp-plan-name">Microchip Lifetime Plan</div>
                              <div class="pp-plan-price">
                                 <h3>$29.95</h3>
                              </div>
                              <div class="pp-adc-btn">   
                                 <a href="javascript:void(0)" id="Sgol2" filed="productid" proid="<?php echo $sgol2; ?>" class="site-btn subPlans">Add to Cart <i class="fa fa-shopping-cart"></i></a>
                              </div>
                           </div>
                        </th>
                        <th class="pp-platinum">
                           <h2>PLATINUM</h2>
                           <div class="pp-membership-plan">
                              <div class="pp-plan-name">Microchip 1 Year Plan</div>
                              <div class="pp-plan-price">
                                 <h3>$19.95</h3>
                                 <span>per year</span>
                              </div>
                              <div class="pp-adc-btn">   
                                 <a href="javascript:void(0)" id="spla1" filed="productid" proid="<?php echo $spla1 ;?>" class="site-btn subPlans">Add to Cart <i class="fa fa-shopping-cart"></i></a>
                              </div>
                           </div>
                           <div class="pp-membership-plan">
                              <div class="pp-plan-name">Microchip Lifetime Plan</div>
                              <div class="pp-plan-price">
                                 <h3>$49.95</h3>
                              </div>
                              <div class="pp-adc-btn">   
                                 <a href="javascript:void(0)" id="spla2" filed="productid" proid="<?php echo $spla2;?>" class="site-btn subPlans">Add to Cart <i class="fa fa-shopping-cart"></i></a>
                              </div>
                           </div>
                        </th>
                     </tr>
                  </thead>
                  <tbody>
                     <tr>
                        <td class="pp-benefits pp-benefits1">  
                           <span class="pp-benefit-icon"></span>
                           <i class="fa fa-plus"></i>
                           Instant Broadcast Alert
                        </td>
                        <td>  <i class="fa fa-check"></i>
                        </td>
                        <td>  <i class="fa fa-check"></i>
                        </td>
                        <td>  <i class="fa fa-check"></i>
                        </td>
                     </tr>
                     <tr>
                        <td class="pp-benefits pp-benefits2">  <span class="pp-benefit-icon"></span>
                           <i class="fa fa-plus"></i>
                           24/7 Toll Free Live Emergency Support
                        </td>
                        <td>  <i class="fa fa-check"></i>
                        </td>
                        <td>  <i class="fa fa-check"></i>
                        </td>
                        <td>  <i class="fa fa-check"></i>
                        </td>
                     </tr>
                     <tr>
                        <td class="pp-benefits pp-benefits3">  <span class="pp-benefit-icon"></span>
                           <i class="fa fa-plus"></i>
                           Metal Collar ID Tag
                        </td>
                        <td>  <i class="fa fa-check"></i>
                        </td>
                        <td>  <i class="fa fa-check"></i>
                        </td>
                        <td>  <i class="fa fa-check"></i>
                        </td>
                     </tr>
                     <tr>
                        <td class="pp-benefits pp-benefits4">  <span class="pp-benefit-icon"></span>
                           <i class="fa fa-plus"></i>
                           All SmartTags Are Searchable on Google
                        </td>
                        <td>  <i class="fa fa-check"></i>
                        </td>
                        <td>  <i class="fa fa-check"></i>
                        </td>
                        <td>  <i class="fa fa-check"></i>
                        </td>
                     </tr>
                     <tr>
                        <td class="pp-benefits pp-benefits5">  <span class="pp-benefit-icon"></span>
                           <i class="fa fa-plus"></i>
                           Free Pet and owner Profile updates anytime.
                        </td>
                        <td>  <i class="fa fa-check"></i>
                        </td>
                        <td>  <i class="fa fa-check"></i>
                        </td>
                        <td>  <i class="fa fa-check"></i>
                        </td>
                     </tr>
                     <tr>
                        <td class="pp-benefits pp-benefits6">  <span class="pp-benefit-icon"></span>
                           <i class="fa fa-plus"></i>
                           Free Pet Medical Insurance (30 Days)
                        </td>
                        <td>  <i class="fa fa-check"></i>
                        </td>
                        <td>  <i class="fa fa-check"></i>
                        </td>
                        <td>  <i class="fa fa-check"></i>
                        </td>
                     </tr>
                     <tr>
                        <td class="pp-benefits pp-benefits7">  <span class="pp-benefit-icon"></span>
                           <i class="fa fa-plus"></i>
                           Instant Lost Pet Posters
                        </td>
                        <td>  <i class="fa fa-check"></i>
                        </td>
                        <td>  <i class="fa fa-check"></i>
                        </td>
                        <td>  <i class="fa fa-check"></i>
                        </td>
                     </tr>
                     <tr>
                        <td class="pp-benefits pp-benefits8">  <span class="pp-benefit-icon"></span>
                           <i class="fa fa-plus"></i>
                           Registration with national AAHA
                        </td>
                        <td>  <i class="fa fa-check"></i>
                        </td>
                        <td>  <i class="fa fa-check"></i>
                        </td>
                        <td>  <i class="fa fa-check"></i>
                        </td>
                     </tr>
                     <tr>
                        <td class="pp-benefits pp-benefits9">  <span class="pp-benefit-icon"></span>
                           <i class="fa fa-plus"></i>
                           Live Emergency Response Team
                        </td>
                        <td></td>
                        <td>  <i class="fa fa-check"></i>
                        </td>
                        <td>  <i class="fa fa-check"></i>
                        </td>
                     </tr>
                     <tr>
                        <td class="pp-benefits pp-benefits10"> <span class="pp-benefit-icon"></span>
                           <i class="fa fa-plus"></i>
                           Pet Poison Helpline
                           <br>  <span>($69 value)</span>
                        </td>
                        <td></td>
                        <td></td>
                        <td>  <i class="fa fa-check"></i>
                        </td>
                     </tr>
                     <tr>
                        <td class="pp-benefits pp-benefits11"> <span class="pp-benefit-icon"></span>
                           <i class="fa fa-plus"></i>
                           Free Engraving on Replacement Tags
                        </td>
                        <td></td>
                        <td></td>
                        <td>  <i class="fa fa-check"></i>
                        </td>
                     </tr>
                     <tr>
                        <td class="pp-benefits pp-benefits12"> <span class="pp-benefit-icon"></span>
                           <i class="fa fa-plus"></i>
                           Lost Pet Reward $100
                        </td>
                        <td></td>
                        <td></td>
                        <td>  <i class="fa fa-check"></i>
                        </td>
                     </tr>
                     <tr>
                        <td class="pp-benefits pp-benefits13"> <span class="pp-benefit-icon"></span>
                           <i class="fa fa-plus"></i>
                           Pet Reminder Alerts
                           <br>  <span>(Flea and tick medication, heart worm, vaccinations etc...)</span>
                        </td>
                        <td></td>
                        <td></td>
                        <td>  <i class="fa fa-check"></i>
                        </td>
                     </tr>
                  </tbody>
               </table>
            </div>
         </div>
         <div class="step-btns">
            <button class="btn btn-default btn-prev" type="button" aria-controls="step-2"><i class="fa fa-caret-left"></i> Back</button>
            <button class="btn btn-default btn-next ste4" type="button" aria-controls="step-4">Skip Protection Plan <i class="fa fa-caret-right"></i>
            </button>
         </div>
      </fieldset>
       <fieldset aria-label="Step Four" tabindex="-1" id="step-4" class="step-form-box">
         <div class="blue-border-box">
                        <div class="pp-icon-wrap previous">
                           <h3>Purchase an Engraved ID Tag with Your Pet Name & Microchip Number</h3>
                        </div>
                        <div class="blue-box-content">
                           <div class="row">
                              <div class="col-sm-8">
                                 <div class="error"></div>
                                 <div class="row">
                                    <div class="col-sm-6">
                                       <div class="field-box">
                                          <label class="field-label">Select a Type:</label>
                                          <div class="field-div custom-select-div">
                                             <div class="custom-select-wrap" id="selectType">
                                                <select class="custom-select-box pro-data" id="field1" name="attribute_pa_ttype">
                                                   <option value="circle" data-product="brass">Brass Circle</option>
                                                   <option value="bone" data-product="aluminum">Aluminum Bone</option>
                                                   <option value="bone" data-product="brass">Brass Bone</option>
                                                   <option value="circle" data-product="aluminum">Aluminum Circle</option>
                                                   <option value="heart" data-product="aluminum">Aluminum Heart</option>
                                                   <option value="heart" data-product="brass">Brass Heart</option>
                                                </select>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                    <div class="col-sm-6">
                                       <div class="field-box">
                                          <label class="field-label">Select Size:</label>
                                          <div class="field-div custom-select-div">
                                             <div class="custom-select-wrap">
                                                <select class="custom-select-box pro-data" id="field2" name="attribute_pa_size">
                                                   <option value="small">Small (1 in / 2.54 cm)</option>
                                                   <option value="large">Large (1.5 in / 3.81 cm)</option>
                                                </select>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                                 <div class="row">
                                    <div class="col-sm-12">
                                       <div class="field-box">
                                          <label class="field-label">Select a Design:</label>
                                          <div class="field-div" id="stylee">
                                             <div class="custom-radio-box circle" data-toggle="buttons">
                                                <label class="btn active" role="button">
                                                   <input type="radio" value="circle-1" name="style" checked="checked" class="style-radio" data-name="design-circle">
                                                   <div class="custom-radio-img">
                                                      <img src="<?php bloginfo('template_url'); ?>-child/images/flower_circle_shape.png" alt="radio image" data-name="design-circle" />
                                                   </div>
                                                </label>
                                                <label class="btn" role="button">
                                                   <input type="radio" value="circle-2" name="style" class="style-radio" data-name="design-circle">
                                                   <div class="custom-radio-img">
                                                      <img src="<?php bloginfo('template_url'); ?>-child/images/pink_paw_circle.png" alt="radio image" data-name="design-circle" />
                                                   </div>
                                                </label>
                                                <label class="btn" role="button">
                                                   <input type="radio" value="circle-3" name="style" class="style-radio" data-name="design-circle">
                                                   <div class="custom-radio-img">
                                                      <img src="<?php bloginfo('template_url'); ?>-child/images/pink_paw_circle_shape.png" alt="radio image" data-name="design-circle" />
                                                   </div>
                                                </label>
                                                <label class="btn" role="button">
                                                   <input type="radio" value="circle-4" name="style" class="style-radio" data-name="design-circle">
                                                   <div class="custom-radio-img">
                                                      <img src="<?php bloginfo('template_url'); ?>-child/images/smarttag_circle_shape.png" alt="radio image" data-name="design-circle" />
                                                   </div>
                                                </label>
                                                <label class="btn" role="button">
                                                   <input type="radio" value="circle-5" name="style" class="style-radio" data-name="design-circle">
                                                   <div class="custom-radio-img">
                                                      <img src="<?php bloginfo('template_url'); ?>-child/images/b3back_paw_circle.png" alt="radio image" data-name="design-circle" />
                                                   </div>
                                                </label>
                                                <label class="btn" role="button">
                                                   <input type="radio" value="circle-6" name="style" class="style-radio" data-name="design-circle">
                                                   <div class="custom-radio-img">
                                                      <img src="<?php bloginfo('template_url'); ?>-child/images/black_paw_circle_shape.png" alt="radio image" data-name="design-circle" />
                                                   </div>
                                                </label>
                                             </div>
                                             <div class="custom-radio-box heart" data-toggle="buttons">
                                                <label class="btn active" role="button">
                                                   <input type="radio" value="heart-1" name="style" checked="checked" class="style-radio" data-name="design-heart">
                                                   <div class="custom-radio-img">
                                                      <img src="<?php bloginfo('template_url'); ?>-child/images/brass_heart.jpg" alt="radio image" data-name="design-heart" />
                                                   </div>
                                                </label>
                                                <label class="btn" role="button">
                                                   <input type="radio" value="heart-2" name="style" class="style-radio" data-name="design-heart">
                                                   <div class="custom-radio-img">
                                                      <img src="<?php bloginfo('template_url'); ?>-child/images/crown_heart_shape.png" alt="radio image" data-name="design-heart" />
                                                   </div>
                                                </label>
                                             </div>
                                             <div class="custom-radio-box bone" data-toggle="buttons">
                                                <label class="btn active" role="button">
                                                   <input type="radio" value="bone-1" name="style" checked="checked" class="style-radio" data-name="design-bone">
                                                   <div class="custom-radio-img">
                                                      <img src="<?php bloginfo('template_url'); ?>-child/images/black_bone_bone_shape.png" alt="radio image" data-name="design-bone" />
                                                   </div>
                                                </label>
                                                <label class="btn" role="button">
                                                   <input type="radio" value="bone-2" name="style" class="style-radio" data-name="design-bone">
                                                   <div class="custom-radio-img">
                                                      <img src="<?php bloginfo('template_url'); ?>-child/images/brass_large_bone_adopted_10.jpg" alt="radio image" data-name="design-bone" />
                                                   </div>
                                                </label>
                                                <label class="btn" role="button">
                                                   <input type="radio" value="bone-3" name="style" class="style-radio" data-name="design-bone">
                                                   <div class="custom-radio-img">
                                                      <img src="<?php bloginfo('template_url'); ?>-child/images/camoflage_bone_shape_1.png" alt="radio image" data-name="design-bone" />
                                                   </div>
                                                </label>
                                                <label class="btn" role="button">
                                                   <input type="radio" value="bone-4" name="style" class="style-radio" data-name="design-bone">
                                                   <div class="custom-radio-img">
                                                      <img src="<?php bloginfo('template_url'); ?>-child/images/paw_off_bone_shape_1.png" alt="radio image" data-name="design-bone" />
                                                   </div>
                                                </label>
                                                <label class="btn" role="button">
                                                   <input type="radio" value="bone-5" name="style" class="style-radio" data-name="design-bone">
                                                   <div class="custom-radio-img">
                                                      <img src="<?php bloginfo('template_url'); ?>-child/images/rainbow_bone_shape_1.png" alt="radio image" data-name="design-bone" />
                                                   </div>
                                                </label>
                                                <label class="btn" role="button">
                                                   <input type="radio" value="bone-6" name="style" class="style-radio" data-name="design-bone">
                                                   <div class="custom-radio-img">
                                                      <img src="<?php bloginfo('template_url'); ?>-child/images/shelter_dog_rock_bone_shape_5_9_2012.png" alt="radio image" data-name="design-bone" />
                                                   </div>
                                                </label>
                                             </div>
                                          </div>
                                          <div class="field-div" id="colorr">
                                             <div class="custom-radio-box circle" data-toggle="buttons">
                                                <label class="btn active" role="button">
                                                   <input type="radio" value="blue-circle" name="color" checked="checked" class="style-radio" data-name="color-circle">
                                                   <div class="custom-radio-img">
                                                      <img src="<?php bloginfo('template_url'); ?>-child/images/bluetag2.jpg" alt="radio image" data-name="color-circle" />
                                                   </div>
                                                </label>
                                                <label class="btn" role="button">
                                                   <input type="radio" value="black-circle" name="color" class="style-radio" data-name="color-circle">
                                                   <div class="custom-radio-img">
                                                      <img src="<?php bloginfo('template_url'); ?>-child/images/circle_black_1.jpg" alt="radio image" data-name="color-circle" />
                                                   </div>
                                                </label>
                                                <label class="btn" role="button">
                                                   <input type="radio" value="pink-circle" name="color" class="style-radio" data-name="color-circle">
                                                   <div class="custom-radio-img">
                                                      <img src="<?php bloginfo('template_url'); ?>-child/images/circle_pink_2.jpg" alt="radio image" data-name="color-circle" />
                                                   </div>
                                                </label>
                                             </div>
                                             <div class="custom-radio-box heart" data-toggle="buttons">
                                                <label class="btn active" role="button">
                                                   <input type="radio" value="pink-heart" name="color" checked="checked" class="style-radio" data-name="color-heart">
                                                   <div class="custom-radio-img">
                                                      <img src="<?php bloginfo('template_url'); ?>-child/images/heart_pink_shape_2.png" alt="radio image" data-name="color-heart" />
                                                   </div>
                                                </label>
                                                <label class="btn" role="button">
                                                   <input type="radio" value="red-heart" name="color" class="style-radio" data-name="color-heart">
                                                   <div class="custom-radio-img">
                                                      <img src="<?php bloginfo('template_url'); ?>-child/images/heart_red_shape_2.png" alt="radio image" data-name="color-heart" />
                                                   </div>
                                                </label>
                                                <label class="btn" role="button">
                                                   <input type="radio" value="yellow-heart" name="color" class="style-radio" data-name="color-heart">
                                                   <div class="custom-radio-img">
                                                      <img src="<?php bloginfo('template_url'); ?>-child/images/heart_yellow_shape_2.png" alt="radio image" data-name="color-heart" />
                                                   </div>
                                                </label>
                                             </div>
                                             <div class="custom-radio-box bone" data-toggle="buttons">
                                                <label class="btn active" role="button">
                                                   <input type="radio" value="black-bone" name="color" checked="checked" class="style-radio" data-name="color-bone">
                                                   <div class="custom-radio-img">
                                                      <img src="<?php bloginfo('template_url'); ?>-child/images/black_bone_shape_2_2.png" alt="radio image" data-name="color-bone" />
                                                   </div>
                                                </label>
                                                <label class="btn" role="button">
                                                   <input type="radio" value="blue-bone" name="color" class="style-radio" data-name="color-bone">
                                                   <div class="custom-radio-img">
                                                      <img src="<?php bloginfo('template_url'); ?>-child/images/blue_bone_shape_2.png" alt="radio image" data-name="color-bone" />
                                                   </div>
                                                </label>
                                                <label class="btn" role="button">
                                                   <input type="radio" value="pink-bone" name="color" class="style-radio" data-name="color-bone">
                                                   <div class="custom-radio-img">
                                                      <img src="<?php bloginfo('template_url'); ?>-child/images/pink_bone_shape_2.png" alt="radio image" data-name="color-bone" />
                                                   </div>
                                                </label>
                                                <label class="btn" role="button">
                                                   <input type="radio" value="red-bone" name="color" class="style-radio" data-name="color-bone">
                                                   <div class="custom-radio-img">
                                                      <img src="<?php bloginfo('template_url'); ?>-child/images/red_bone-shape_2.png" alt="radio image" data-name="color-bone" />
                                                   </div>
                                                </label>
                                             </div>
                                          </div>
                                       </div>
                                    </div
>                                </div>
                                 <div class="row">
                                    <div class="col-sm-12">
                                       <div class="field-box">
                                          <div class="home-front-back-section">
                                             <div class="style-pro">
                                                <div class="section-front-image design-circle micro-back">
                                                   <label>Front:</label>
                                                   <span class="micro-back-img">
                                                      <img src="<?php bloginfo('template_url'); ?>-child/images/flower_circle_shape.png" class="front-img">
                                                      <span class="woo-complex-custom" style="display: none;">
                                                      <span class="back_line_text1" id="back_line1"></span>
                                                         <span class="back_line_text2" id="back_line2">Microchip ID#</span>
                                                         <span class="back_line_text3" id="back_line3"></span>
                                                      </span>
                                                   </span>
                                                </div>
                                                <div class="section-back-image design-circle micro-back">
                                                   <label>Back:</label>
                                                   <span class="micro-back-img">
                                                      <img src="<?php bloginfo('template_url'); ?>-child/images/circle_back.png" class="back-img">
                                                      <span class="woo-complex-custom">   
                                                         <span class="back_line_text1" id="back_line1"></span>
                                                         <span class="back_line_text2" id="back_line2">Microchip ID#</span>
                                                         <span class="back_line_text3" id="back_line3"></span>
                                                      </span>
                                                   </span>
                                                   
                                                </div>
                                                <div class="section-front-image design-bone micro-back">
                                                   <label>Front:</label>
                                                   <span class="micro-back-img">
                                                      <img src="<?php bloginfo('template_url'); ?>-child/images/black_bone_bone_shape.png" class="front-img">
                                                      <span class="woo-complex-custom" style="display: none;"> 
                                                         <span class="front_line_text1" id="front_line1"></span>
                                                         <span class="front_line_text2" id="front_line2">Microchip ID#</span>
                                                         <span class="front_line_text3" id="front_line3"></span>
                                                      </span>
                                                   </span>
                                                </div>
                                                <div class="section-back-image design-bone micro-back">
                                                   <label>Back:</label>
                                                   <span class="micro-back-img">
                                                      <img src="<?php bloginfo('template_url'); ?>-child/images/bone_back.jpg" class="back-img">
                                                      <span class="woo-complex-custom">   
                                                         <span class="back_line_text1" id="back_line1"></span>
                                                         <span class="back_line_text2" id="back_line2">Microchip ID#</span>
                                                         <span class="back_line_text3" id="back_line3"></span>
                                                      </span>
                                                   </span>
                                                </div>
                                                <div class="section-front-image design-heart micro-back">
                                                   <label>Front:</label>
                                                   <span class="micro-back-img">
                                                      <img src="<?php bloginfo('template_url'); ?>-child/images/brass_heart.jpg" class="front-img">
                                                      <span class="woo-complex-custom" style="display: none;"> 
                                                         <span class="front_line_text1" id="front_line1"></span>
                                                         <span class="front_line_text2" id="front_line2">Microchip ID#</span>
                                                         <span class="front_line_text3" id="front_line3"></span>
                                                      </span>
                                                   </span>
                                                </div>
                                                <div class="section-back-image design-heart micro-back">
                                                   <label>Back:</label>
                                                   <span class="micro-back-img">
                                                      <img src="<?php bloginfo('template_url'); ?>-child/images/brass_heart.jpg" class="back-img">
                                                      <span class="woo-complex-custom">   
                                                         <span class="back_line_text1" id="back_line1"></span>
                                                         <span class="back_line_text2" id="back_line2">Microchip ID#</span>
                                                         <span class="back_line_text3" id="back_line3"></span>
                                                      </span>
                                                   </span>
                                                </div>
                                             </div>
                                             <div class="color-pro">
                                                <div class="section-front-image color-circle micro-back">
                                                   <label>Front:</label>
                                                   <span class="micro-back-img">
                                                      <img src="<?php bloginfo('template_url'); ?>-child/images/bluetag2.jpg" class="front-img"> 
                                                      <span class="woo-complex-custom" style="display: none;"> 
                                                         <span class="front_line_text1" id="front_line1"></span>
                                                         <span class="front_line_text2" id="front_line2">Microchip ID#</span>
                                                         <span class="front_line_text3" id="front_line3"></span>
                                                      </span>
                                                </div>
                                                <div class="section-back-image color-circle micro-back">
                                                   <label>Back:</label>
                                                   <span class="micro-back-img">
                                                      <img src="<?php bloginfo('template_url'); ?>-child/images/bluetag2.jpg" class="back-img">
                                                      <span class="woo-complex-custom">   
                                                         <span class="back_line_text1" id="back_line1"></span>
                                                         <span class="back_line_text2" id="back_line2">Microchip ID#</span>
                                                         <span class="back_line_text3" id="back_line3"></span>
                                                      </span>
                                                   </span>
                                                </div>
                                                <div class="section-front-image color-bone micro-back">
                                                   <label>Front:</label>
                                                   <span class="micro-back-img">
                                                      <img src="<?php bloginfo('template_url'); ?>-child/images/black_bone_shape_2_2.png" class="front-img">
                                                      <span class="woo-complex-custom" style="display: none;"> 
                                                         <span class="front_line_text1" id="front_line1"></span>
                                                         <span class="front_line_text2" id="front_line2">Microchip ID#</span>
                                                         <span class="front_line_text3" id="front_line3"></span>
                                                      </span>
                                                   </span>
                                                </div>
                                                <div class="section-back-image color-bone micro-back">
                                                   <label>Back:</label>
                                                   <span class="micro-back-img">
                                                      <img src="<?php bloginfo('template_url'); ?>-child/images/black_bone_shape_2_2.png" class="back-img">
                                                      <span class="woo-complex-custom">   
                                                         <span class="back_line_text1" id="back_line1"></span>
                                                         <span class="back_line_text2" id="back_line2">Microchip ID#</span>
                                                         <span class="back_line_text3" id="back_line3"></span>
                                                      </span>
                                                   </span>
                                                </div>
                                                <div class="section-front-image color-heart micro-back">
                                                   <label>Front:</label>
                                                   <span class="micro-back-img">
                                                      <img src="<?php bloginfo('template_url'); ?>-child/images/heart_pink_shape_2.png" class="front-img">
                                                      <span class="woo-complex-custom" style="display: none;"> 
                                                         <span class="front_line_text1" id="front_line1"></span>
                                                         <span class="front_line_text2" id="front_line2">Microchip ID#</span>
                                                         <span class="front_line_text3" id="front_line3"></span>
                                                      </span>
                                                   </span>
                                                </div>
                                                <div class="section-back-image color-heart micro-back">
                                                   <label>Back:</label>
                                                   <span class="micro-back-img">
                                                      <img src="<?php bloginfo('template_url'); ?>-child/images/heart_pink_shape_2.png" class="back-img">
                                                      <span class="woo-complex-custom">   
                                                         <span class="back_line_text1" id="back_line1"></span>
                                                         <span class="back_line_text2" id="back_line2">Microchip ID#</span>
                                                         <span class="back_line_text3" id="back_line3"></span>
                                                      </span>
                                                   </span>
                                                   
                                                </div>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                                 <div class="row">
                                    <div class="col-sm-12">
                                       <div class="field-box">
                                          
                                          <div class="field-div" id="stylee">
                                             <div>
                                                <label for="Price">
                                                   <?php ?>
                                             </div>
                                             <div>
                                                <label>
                                                   <input type="radio" id="CustPro" name="customproduct">Yes I want a custom engraved ID Tag
                                                   <br>
                                                   <input type="radio" id="CustProdis" name="customproduct">No, I don't want an engraved ID Tag
                                                   <br>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                     <div class="blue-border-box">
                        <div class="pp-icon-wrap">
                           <div class="pp-icon pp-icon-plus"></div>
                           <h3>Pet Insurance</h3>
                        </div>
                        <div class="blue-box-content">
                           <h3>30-Days of PetFirst Pet Insurance
                              <br>
                              Included with your SmartTag Membership
                           </h3>
                           <p>Veterinary costs continue to rise, and at SmartTag we want to provide you with an introductory pet insurance plan to help reimburse you for your pet’s veterinary expenses. We are the only ID Tag company to include pet insurance with our membership.</p>
                           <div class="row">
                              <div class="col-sm-4">
                                 <h4>Plan Details</h4>
                                 <p>Aggregate Benefit Limit: $1,000
                                    <br>
                                    Per-Incident Limit: $500
                                    <br>
                                    Pet-Incident Deductible: $50
                                    <br>
                                    Reimbursement: 90%
                                 </p>
                              </div>
                              <div class="col-sm-8">
                                 <div class="row">
                                    <div class="col-sm-12">
                                       <h4>What is Covered?</h4>
                                    </div>
                                    <div class="col-sm-4">
                                       <p>• Accidents
                                          <br>
                                          • Illnesses
                                          <br>
                                          • Exam Fees
                                          <br>
                                          • X-rays
                                       </p>
                                    </div>
                                    <div class="col-sm-4">
                                       <p>• Medications
                                          <br>
                                          • Ultrasounds
                                          <br>
                                          • Hospital Stays
                                          <br>
                                          • Surgeries
                                       </p>
                                    </div>
                                    <div class="col-sm-4">
                                       <p>• Alternative Therapies
                                          <br>
                                          • Diagnostic Tests
                                          <br>
                                          • Holistic Care
                                          <br>
                                          • Much more!
                                       </p>
                                    </div>
                                 </div>
                              </div>
                           </div>
                           <div class="row">
                              <div class="col-sm-12">
                                 <h4>What Is Not Covered?</h4>
                              </div>
                              <div class="col-sm-3">
                                 <p>
                                    • Special Diets
                                    <br>
                                    • Routine Wellness
                                    <br>
                                    • Spay/Neuter
                                 </p>
                              </div>
                              <div class="col-sm-3">
                                 <p>
                                    • Pre-Existing Conditions
                                    <br>
                                    • Preventative Conditions
                                    <br>
                                    • Chronic Conditions
                                 </p>
                              </div>
                              <div class="col-sm-3">
                                 <p>
                                    • Hereditary Conditions
                                    <br>
                                    • Congenital Conditions
                                    <br>
                                    • Behavior Training
                                 </p>
                              </div>
                              <div class="col-sm-3">
                                 <p>
                                    • Organ Transplants
                                    <br>
                                    • Elective Procedures
                                 </p>
                              </div>
                           </div>
                        </div>
                        <div class="step-check-wrap">
                           <div class="step-check">
                              <input type="radio" name="health_insurance" id="heth_id" value="<?= $heth_proid; ?>" class="" />
                              <label>I Accept my free 30 days of pet health insurance</label>
                           </div>
                           <div class="step-check">
                              <input type="radio" name="health_insurance" id="heth_id1"/>
                              <label>I don't want my free 30 days of pet health insurance</label>
                           </div>
                        </div>
                     </div>
                     <div class="blue-border-box">
                        <div class="pp-icon-wrap">
                           <div class="pp-icon pp-icon-foot"></div>
                           <h3>Pet Protection Arrangement </h3>
                        </div>
                        <div class="blue-box-content">
                           <h3>What's the difference between a SmartTag PetCare Protection Arrangement and a Pet Trust?</h3>
                           <p>A Pet Protection Arrangement, like a Pet Trust is a legal document used to ensure that your pets are fully cared for and protected in case you should become ill, not be able to keep or take care of your pets, or pass away. The difference is that a Pet Trust is a more formal and costly document that is normally prepared by an attorney who specializes in estate planning and has experience in pet trusts. Pet trusts are normally used when a substantial amount of money is being left to care for the pets or they are very high profile. A Pet Protection Arrangement is all the protection most pet owners need to ensure proper care and safety for their pets.</p>
                           <p>
                              <img src="<?php bloginfo('template_url'); ?>-child/images/red-table.jpg" alt="image" />
                           </p>
                            <?php $product = wc_get_product($protectionArrangement); ?>
                           <p><strong>Price: $ <?= $product->get_price(); ?></strong>
                        </div>
                        <div class="step-check-wrap">
                           <div class="step-check">
                              <input  class="" type="radio" name="protectionArrangement" value="<?= $protectionArrangement; ?>" id="PetArg" />
                              <label>I would like to add a Pet Protection Arrangement</label>
                           </div>
                           <div class="step-check">
                              <input type="radio" name="protectionArrangement" id="PetArg1" />
                              <label>I would not like to add a Pet Protection Arrangement</label>
                           </div>
                        </div>
                     </div>
                     <div class="step-btns">
                        <button class="btn btn-default btn-prev" type="button" aria-controls="step-3"><i class="fa fa-caret-left"></i> Back</button>
                        <button class="btn btn-default btn-next skip2" type="button" aria-controls="step-5">Skip All Offers <i class="fa fa-caret-right"></i></button>
                     </div>
                </fieldset>
      <fieldset aria-label="Step Five" tabindex="-1" id="step-5" class="step-form-box">
         <p>   <strong>Please review that your information is correct.</strong>
            <br>You can edit this information if you need to.
         </p>
         <div class="acc-blue-box">
            <div class="acc-blue-head">
               Engraved ID Tag
               <div class="acc-edit engrave-edit"> <i class="fa fa-edit"></i> EDIT</div>
            </div>
            <div class="acc-blue-content">
               <div class="row" style="display: none" id="eng_id">
                  <div class="col-sm-8">
                     <div class="field-box">
                        <div class="home-front-back-section">
                           <div class="style-pro">
                              <div class="section-front-image design-circle micro-back">
                                 <label>Front:</label>
                                 <span class="micro-back-img">
                                 <img src="<?php bloginfo('template_url'); ?>-child/images/flower_circle_shape.png" class="front-img">
                                 <span class="woo-complex-custom" style="display: none;">
                                 <span class="back_line_text1" id="back_line1"></span>
                                 <span class="back_line_text2" id="back_line2">Microchip ID#</span>
                                 <span class="back_line_text3" id="back_line3"></span>
                                 </span>
                                 </span>
                              </div>
                              <div class="section-back-image design-circle micro-back">
                                 <label>Back:</label>
                                 <span class="micro-back-img">
                                 <img src="<?php bloginfo('template_url'); ?>-child/images/circle_back.png" class="back-img">
                                 <span class="woo-complex-custom">   
                                 <span class="back_line_text1" id="back_line1"></span>
                                 <span class="back_line_text2" id="back_line2">Microchip ID#</span>
                                 <span class="back_line_text3" id="back_line3"></span>
                                 </span>
                                 </span>
                              </div>
                              <div class="section-front-image design-bone micro-back">
                                 <label>Front:</label>
                                 <span class="micro-back-img">
                                 <img src="<?php bloginfo('template_url'); ?>-child/images/black_bone_bone_shape.png" class="front-img">
                                 <span class="woo-complex-custom" style="display: none;"> 
                                 <span class="front_line_text1" id="front_line1"></span>
                                 <span class="front_line_text2" id="front_line2">Microchip ID#</span>
                                 <span class="front_line_text3" id="front_line3"></span>
                                 </span>
                                 </span>
                              </div>
                              <div class="section-back-image design-bone micro-back">
                                 <label>Back:</label>
                                 <span class="micro-back-img">
                                 <img src="<?php bloginfo('template_url'); ?>-child/images/bone_back.jpg" class="back-img">
                                 <span class="woo-complex-custom">   
                                 <span class="back_line_text1" id="back_line1"></span>
                                 <span class="back_line_text2" id="back_line2">Microchip ID#</span>
                                 <span class="back_line_text3" id="back_line3"></span>
                                 </span>
                                 </span>
                              </div>
                              <div class="section-front-image design-heart micro-back">
                                 <label>Front:</label>
                                 <span class="micro-back-img">
                                 <img src="<?php bloginfo('template_url'); ?>-child/images/brass_heart.jpg" class="front-img">
                                 <span class="woo-complex-custom" style="display: none;"> 
                                 <span class="front_line_text1" id="front_line1"></span>
                                 <span class="front_line_text2" id="front_line2">Microchip ID#</span>
                                 <span class="front_line_text3" id="front_line3"></span>
                                 </span>
                                 </span>
                              </div>
                              <div class="section-back-image design-heart micro-back">
                                 <label>Back:</label>
                                 <span class="micro-back-img">
                                 <img src="<?php bloginfo('template_url'); ?>-child/images/brass_heart.jpg" class="back-img">
                                 <span class="woo-complex-custom">   
                                 <span class="back_line_text1" id="back_line1"></span>
                                 <span class="back_line_text2" id="back_line2">Microchip ID#</span>
                                 <span class="back_line_text3" id="back_line3"></span>
                                 </span>
                                 </span>
                              </div>
                           </div>
                           <div class="color-pro">
                              <div class="section-front-image color-circle micro-back">
                                 <label>Front:</label>
                                 <span class="micro-back-img">
                                 <img src="<?php bloginfo('template_url'); ?>-child/images/bluetag2.jpg" class="front-img"> 
                                 <span class="woo-complex-custom" style="display: none;"> 
                                 <span class="front_line_text1" id="front_line1"></span>
                                 <span class="front_line_text2" id="front_line2">Microchip ID#</span>
                                 <span class="front_line_text3" id="front_line3"></span>
                                 </span>
                              </div>
                              <div class="section-back-image color-circle micro-back">
                                 <label>Back:</label>
                                 <span class="micro-back-img">
                                 <img src="<?php bloginfo('template_url'); ?>-child/images/bluetag2.jpg" class="back-img">
                                 <span class="woo-complex-custom">   
                                 <span class="back_line_text1" id="back_line1"></span>
                                 <span class="back_line_text2" id="back_line2">Microchip ID#</span>
                                 <span class="back_line_text3" id="back_line3"></span>
                                 </span>
                                 </span>
                              </div>
                              <div class="section-front-image color-bone micro-back">
                                 <label>Front:</label>
                                 <span class="micro-back-img">
                                 <img src="<?php bloginfo('template_url'); ?>-child/images/black_bone_shape_2_2.png" class="front-img">
                                 <span class="woo-complex-custom" style="display: none;"> 
                                 <span class="front_line_text1" id="front_line1"></span>
                                 <span class="front_line_text2" id="front_line2">Microchip ID#</span>
                                 <span class="front_line_text3" id="front_line3"></span>
                                 </span>
                                 </span>
                              </div>
                              <div class="section-back-image color-bone micro-back">
                                 <label>Back:</label>
                                 <span class="micro-back-img">
                                 <img src="<?php bloginfo('template_url'); ?>-child/images/black_bone_shape_2_2.png" class="back-img">
                                 <span class="woo-complex-custom">   
                                 <span class="back_line_text1" id="back_line1"></span>
                                 <span class="back_line_text2" id="back_line2">Microchip ID#</span>
                                 <span class="back_line_text3" id="back_line3"></span>
                                 </span>
                                 </span>
                              </div>
                              <div class="section-front-image color-heart micro-back">
                                 <label>Front:</label>
                                 <span class="micro-back-img">
                                 <img src="<?php bloginfo('template_url'); ?>-child/images/heart_pink_shape_2.png" class="front-img">
                                 <span class="woo-complex-custom" style="display: none;"> 
                                 <span class="front_line_text1" id="front_line1"></span>
                                 <span class="front_line_text2" id="front_line2">Microchip ID#</span>
                                 <span class="front_line_text3" id="front_line3"></span>
                                 </span>
                                 </span>
                              </div>
                              <div class="section-back-image color-heart micro-back">
                                 <label>Back:</label>
                                 <span class="micro-back-img">
                                 <img src="<?php bloginfo('template_url'); ?>-child/images/heart_pink_shape_2.png" class="back-img">
                                 <span class="woo-complex-custom">   
                                 <span class="back_line_text1" id="back_line1"></span>
                                 <span class="back_line_text2" id="back_line2">Microchip ID#</span>
                                 <span class="back_line_text3" id="back_line3"></span>
                                 </span>
                                 </span>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="col-sm-4">
                     <strong>Price:&nbsp;</strong>$<span id="ProductPrice"></span>
                  </div>
               </div>
               <div class="row" id="eng_id1">
                  <div class="col-sm-12"> <strong>None</strong>
                  </div>
               </div>
            </div>
         </div>
         <div class="acc-blue-box">
            <div class="acc-blue-head">
               Pet Protection Plan
               <div class="acc-edit plan-edit"> <i class="fa fa-edit"></i> EDIT</div>
            </div>
            <div class="acc-blue-content">
               <div class="row">
                  <div class="col-sm-12"> <span id="pln"><strong>None</strong></span>
                  </div>
               </div>
            </div>
         </div>
         <div class="acc-blue-box">
            <div class="acc-blue-head">
               Pet Protection Arrangement
               <div class="acc-edit engrave-edit"> <i class="fa fa-edit"></i> EDIT</div>
            </div>
            <div class="acc-blue-content">
               <div class="row">
                  <div class="col-sm-12"> <strong id="Arrangement">None</strong>
                  </div>
               </div>
            </div>
         </div>
         <div class="acc-blue-box">
            <div class="acc-blue-head">
               Pet Health Insurance
               <div class="acc-edit engrave-edit"> <i class="fa fa-edit"></i> EDIT</div>
            </div>
            <div class="acc-blue-content">
               <div class="row">
                  <div class="col-sm-12"> <strong id="Insurance">Free Month</strong>
                  </div>
               </div>
            </div>
         </div>
         <div class="acc-blue-box">
            <div class="acc-blue-head">
               Registered Pet
               <div class="acc-edit petpro-edit">
                  <i class="fa fa-edit"></i> EDIT
               </div>
            </div>
            <div class="acc-blue-content">
               <div class="row">
                  <div class="col-sm-6">
                     <strong>Microchip Id Number:</strong> <span id="microchip_id"></span>
                     <br>
                     <strong>Pet Name:</strong> <span id="pet_name"></span>
                     <br>
                     <strong>Pet Type:</strong> <span id="pet_type"></span>
                     <br>
                     <strong>Primary Breed:</strong> <span id="primary_breed"></span>
                     <br>
                     <strong>Secondary Breed:</strong> <span id="secondary_breed"></span>
                     <br>
                     <strong>Primary Color:</strong> <span id="primary_color"></span>
                     <br>
                     <strong>Secondary Color:</strong> <span id="secondary_color"></span>
                     <br>
                     <strong>Gender:</strong> <span id="gender"></span>
                     <br>
                     <strong>Size:</strong> <span id="size"></span>
                     <br>
                     <strong>Pet Date of Birth:</strong> <span id="ptdob"></span>
                  </div>
                  <div class="col-sm-6">
                     <p><strong>Pet Image:</strong></p>
                     <img id="blah" src="<?php echo get_site_url(); ?>/wp-content/uploads/2019/02/pet-image.jpg" alt="your image" />
                  </div>
               </div>
            </div>
         </div>
         <div class="acc-blue-box">
            <div class="acc-blue-head">
               Contact Information
               <div class="acc-edit usr-edit">  <i class="fa fa-edit"></i> EDIT</div>
            </div>
            <div class="acc-blue-content">
               <div class="row">
                  <div class="col-sm-6 mar-bot">
                     <p><strong class="color-light-blue">Primary Contact:</strong>
                     </p>
                     <strong>Email:</strong><span id="pemail"><?= $email;?></span>
                     <br>  <strong>First Name:</strong><span id="pfnam"><?= $first_name;?></span>
                     <br>  <strong>Last Name:</strong><span id="plnam"><?= $last_name;?></span><br>
                     <strong>Address1:</strong><span id="uadd1"><?= $primary_address_line1 ?></span><br> 
                     <strong>Address2:</strong><span id="uadd2"><?= $primary_address_line2; ?></span><br>
                     <strong>City:</strong><span id="ucity1"><?= $primary_city;?></span><br>
                     <strong>Zip Code:</strong><span id="uzip"><?= $primary_postcode;?></span><br>
                     <strong>State:</strong><span id="ustte"><?= stateName($primary_state, $primary_country); ?></span><br>
                     <strong>Country:</strong><span id="ucounty"><?= getCountryName($primary_country); ?></span><br>
                     <!-- <strong>Primary Phone Number:</strong>  <span id="pnum"><?= $primary_home_number;?></span><br>
                     <strong>Secondary Phone Number:</strong>  <span id="snum"><?= $primary_cell_number;?></span> -->
                     <div class="mt-3">
                        <p><strong class="color-light-blue">Secondary Contact:</strong>
                        </p>
                        <strong>Email:</strong>  <span id="semail"><?= $Semail ?></span><br>
                        <strong>First Name:</strong>  <span id="sfirst"><?= $Sfirst_name; ?></span><br>
                        <strong>Last Name:</strong><span id="slst"><?= $Slast_name; ?></span><br>
                        <strong>Address1:</strong><span id="preAdd1"><?= $Sprimary_address_line1; ?></span><br>
                        <strong>Address2:</strong><span id="preAdd2"><?= $Sprimary_address_line2; ?></span><br>
                        <strong>City:</strong><span id="scity"><?= $Sprimary_city ?></span><br>
                        <strong>Zip Code:</strong><span id="szip"><?= $Sprimary_postcode ?></span><br>
                        <strong>State:</strong><span id="sttate"><?= stateName($Sprimary_state, $Sprimary_country); ?></span><br>
                        <strong>Country:</strong><span id="scounty"><?= getCountryName($Sprimary_country); ?></span><br>
                        <!-- <strong>Primary Phone Number:</strong>  <span id="sprino"><?= $Sprimary_home_number; ?></span><br>
                        <strong>Secondary Phone Number:</strong>  <span id="sseno"><?= $Sprimary_cell_number; ?></span> -->
                     </div>
                  </div>
                  <div class="col-sm-6 mar-bot">
                     <p><strong class="color-light-blue">Veterinarian Information:</strong>
                     </p>
                     <strong>Email: </strong><span id="vemail"></span><br>
                     <strong>First Name: </strong><span id="vname"></span><br>
                     <strong>Last Name: </strong><span id="vlst"></span><br>
                     <!-- <strong>Address:</strong><span id="v-addrss"></span><br> -->
                     <strong>Address1: </strong><span id="vadd1"></span><br> 
                     <strong>Address2: </strong><span id="vadd2" ></span><br>
                     <strong>City: </strong><span id="vcity"></span><br>
                     <strong>Zip Code: </strong><span id="vzip"></span><br>
                     <strong>State: </strong><span id="vstate"></span><br>
                     <strong>Country: </strong><span id="vcounty"></span><br>
                     <strong>Primary Phone Number: </strong><span id="vaterinarian_primary_phone_number_code">+1-</span><span id="vprim"></span><br>
                     <strong>Secondary Phone Number: </strong><span id="vaterinarian_secondary_phone_number_code">+1-</span><span></span><span id="vsec"></span>
                  </div>
               </div>
            </div>
         </div>
         <p class="step-check-wrap">
         <div class="step-check">
            <div class="clearfix">
               <input type="checkbox" name="terms" required="" />
               <label class="checkbox-label">*I agree to the <a href="<?= site_url('/terms-conditions/');?>">terms and conditions</a>
               </label>
               <div id="agreeValidate"></div>
            </div>
            <!-- <input type="checkbox" name="agree" required="" />
               <label>I agree to the <a href="<?php site_url('/terms-conditions/'); ?>'/terms-conditions/'">terms and conditions</a></label> -->
         </div>
         </p>
         <div class="step-btns">
            <button class="btn btn-default btn-prev" type="button" aria-controls="step-4"><i class="fa fa-caret-left"></i> Back</button>
            <button class="btn btn-default" type="submit">Checkout and Register Microchip <i class="fa fa-caret-right"></i>
            </button>
         </div>
         <div id="test"></div>
      </fieldset>
   </form>
</section>