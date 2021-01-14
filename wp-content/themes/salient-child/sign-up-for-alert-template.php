<?php 
/*
* Template Name:  Sign Up For Alerts
*/
get_header(); 
if ( !is_user_logged_in() ){
    print('<script>
    		window.location.href = "'.site_url().'/login-to-smarttag/?login=1&redir=https://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'].'";
    	</script>');
    die();    
}
?>
<div class="container-wrap">		
	<div class="container main-content">
		<div class="row">
			<div class="col-sm-3 woo-sidebar">
				<h3 class="widgettitle"><?php echo $parent_title = get_the_title($post->post_parent); ?></h3>
				<?php echo do_shortcode("[wpb_childpages]"); ?>
		    </div>
			<div class="col-sm-9">
				<div class="page-heading">
					<h1><?php echo get_the_title(); ?></h1>
				</div>
				<?php 
				if (isset($_POST['post_id'])) {
				    $userId     = get_current_user_id();
				    // print_r(get_user_meta($userId));
				    $heartworm  = get_user_meta($userId,"heartworm_medication_alert",true);
				    $fleaTick   = get_user_meta($userId,"flea_tick_medication_alert",true);
				    $vetAppo    = get_user_meta($userId,"vet_appointments_alert",true);
				    $medica     = get_user_meta($userId,"medication_alert",true);
				    $rabiesShot = get_user_meta($userId,"rabies_shot_alert",true);
				    $tagLicens  = get_user_meta($userId,"tag_licensing_alert",true);

				    $totalCustm = get_user_meta($userId,"total_custom_alert",true);
				    if (isset($totalCustm[0])) {
				        $totalCustm = $totalCustm[0];
				    }else{
				        $totalCustm = 0;
				    }

				    if (!empty($heartworm)) {
				        $heartwormCheck = "checked";
				        $heartwormDisab = "";
				        $heartwormClass = "";
				    }else{
				        $heartwormCheck = "";
				        $heartwormDisab = "disabled";
				        $heartwormClass = "disabled";
				    }

				    if (!empty($fleaTick)) {
				        $fleaTickCheck = "checked";
				        $fleaTickDisab = "";
				        $fleaTickClass = "";
				    }else{
				        $fleaTickCheck = "";
				        $fleaTickDisab = "disabled";
				        $fleaTickClass = "disabled";
				    }

				    if (!empty($vetAppo)) {
				        $vetAppoCheck = "checked";
				        $vetAppoDisab = "";
				        $vetAppoClass = "";
				    }else{
				        $vetAppoCheck = "";
				        $vetAppoDisab = "disabled";
				        $vetAppoClass = "disabled";
				    }

				    if (!empty($medica)) {
				        $medicaCheck = "checked";
				        $medicaDisab = "";
				        $medicaClass = "";
				    }else{
				        $medicaCheck = "";
				        $medicaDisab = "disabled";
				        $medicaClass = "disabled";
				    }
				    
				    if (!empty($rabiesShot)) {
				        $rabiesShotCheck = "checked";
				        $rabiesShotDisab = "";
				        $rabiesShotClass = "";
				    }else{
				        $rabiesShotCheck = "";
				        $rabiesShotDisab = "disabled";
				        $rabiesShotClass = "disabled";
				    }

				    if (!empty($tagLicens)) {
				        $tagLicensCheck = "checked";
				        $tagLicensDisab = "";
				        $tagLicensClass = "";
				    }else{
				        $tagLicensCheck = "";
				        $tagLicensDisab = "disabled";
				        $tagLicensClass = "disabled";
				    }

				    if (isset($_POST['post_id'])) {
				        $postId             = $_POST['post_id'];
				        $petProtectionPlan  = $_POST['petProtectionPlan'];
				        $mypod = pods( 'pet_profile', $postId );
				    ?>
				        <div class="set-alerts-wrap">
				            <h4>
				                <i>Alerts for Dog Name:</i>
				            </h4>
				            <div class="bottom-border-box">
				                <div class="row">
				                    <div class="col-sm-3 rmb-15">
				                        <?php echo get_the_post_thumbnail($postId); ?>

				                    </div>
				                    <div class="col-sm-9">
				                        <strong>Pet Name:</strong> <?php echo get_the_title($postId); ?>
				                        <br>
				                        <strong>Pet Type:</strong> <span><?php echo $mypod->display('pet_type'); ?></span>
				                        <br>
				                        <strong>IDTag Serial Number:</strong> <span class="name"><?php echo $mypod->display('smarttag_id_number'); ?></span>
				                        <br>
				                        <strong>Microchip Number:</strong> <span class="name"><?php echo $mypod->display('microchip_id_number'); ?></span>
				                        <br>
				                        <strong>ID Tag Plan:</strong> <span><?php echo $petProtectionPlan; ?></span>
				                    </div>
				                </div>
				            </div>
				            <div class="row middle-border-row mb-15">
				                <div class="col-sm-6 standard-alerts rmb-15">
				                    <h4 class="color-light-blue">Standard Alerts</h4>
				                    <p>
				                        <input type="checkbox" name="" <?php echo $heartwormCheck; ?> class="heartworm-alert" /> <strong>Heartworm Medication</strong>
				                    </p>
				                    <p>
				                        <input type="checkbox" name="" class="flea-tick" <?php echo $fleaTickCheck; ?> /> <strong>Flea & Tick Medication</strong>
				                    </p>
				                    <p>
				                        <input type="checkbox" name="" <?php echo $vetAppoCheck; ?> class="vet-appo" /> <strong>Vet Appointments</strong>
				                    </p>
				                    <p>
				                        <input type="checkbox" name="" <?php echo $medicaCheck; ?> class="medication-alert" /> <strong>Medication Alerts</strong>
				                    </p>
				                    <p>
				                        <input type="checkbox" name="" <?php echo $rabiesShotCheck; ?> class="rabies-shot" /> <strong>Rabies Shot Alerts</strong>
				                    </p>
				                    <p>
				                        <input type="checkbox" name="" <?php echo $tagLicensCheck; ?> class="tag-licens" /> <strong>Tag Licensing Alerts</strong>
				                    </p>
				                </div>
				                <div class="col-sm-6 standard-alerts">
				                    <h4 class="color-light-blue">Custom Alerts</h4>
				                    <p>
				                        <input type="checkbox" name="" class="custom-alert" /> <strong>Create a Custom Alert</strong>
				                    </p>
				                </div>
				            </div>
				            <div class="acc-blue-box acc-plus-minus">
				                <div class="acc-blue-head">
				                    Heartworm Medication Alert
				                    <i class="fa fa-plus"></i>
				                </div>
				                <div class="acc-blue-content">
				                    <form>
				                        <div class="contact-form">
				                            <input type="hidden" name="alert_name" value="heartworm_medication_alert" class="heartworm-alert">
				                            <div class="field-wrap">
				                                <div class="field-div">
				                                    <label>*Choose day of the week to receive alert:</label>
				                                    <div class="multi-check-fields mb-15">
				                                        <span>
				                                            <input type="radio" name="day_of_week" value="7" class="heartworm-alert" <?php if (!empty($heartworm)) {
				                                                if (isset($heartworm['day_of_week']) && $heartworm['day_of_week'] == 7) {
				                                                    echo "checked";
				                                                }
				                                            } ?> /> Sunday
				                                        </span>
				                                        <span>
				                                            <input type="radio" name="day_of_week" value="1" class="heartworm-alert" <?php if (!empty($heartworm)) { 
				                                                if (isset($heartworm['day_of_week']) && $heartworm['day_of_week'] == 1) {
				                                                    echo "checked";
				                                                }
				                                            } ?> /> Monday
				                                        </span>
				                                        <span>
				                                            <input type="radio" name="day_of_week" value="2" class="heartworm-alert" <?php if (!empty($heartworm)) {
				                                                if (isset($heartworm['day_of_week']) && $heartworm['day_of_week'] == 2) {
				                                                    echo "checked";
				                                                }
				                                            } ?> /> Tuesday
				                                        </span>
				                                        <span>
				                                            <input type="radio" name="day_of_week" value="3" class="heartworm-alert" <?php if (!empty($heartworm)) {
				                                                if (isset($heartworm['day_of_week']) && $heartworm['day_of_week'] == 3) {
				                                                    echo "checked";
				                                                }
				                                            } ?> /> Wednesday
				                                        </span>
				                                        <span>
				                                            <input type="radio" name="day_of_week" value="4" class="heartworm-alert" <?php if (!empty($heartworm)) {
				                                                if (isset($heartworm['day_of_week']) && $heartworm['day_of_week'] == 4) {
				                                                    echo "checked";
				                                                }
				                                            } ?> /> Thursday
				                                        </span>
				                                        <span>
				                                            <input type="radio" name="day_of_week" value="5" class="heartworm-alert" <?php if (!empty($heartworm)) {
				                                                if (isset($heartworm['day_of_week']) && $heartworm['day_of_week'] == 5) {
				                                                    echo "checked";
				                                                }
				                                            } ?> /> Friday
				                                        </span>
				                                        <span>
				                                            <input type="radio" name="day_of_week" value="6" class="heartworm-alert" <?php if (!empty($heartworm)) {
				                                                if (isset($heartworm['day_of_week']) && $heartworm['day_of_week'] == 6) {
				                                                    echo "checked";
				                                                }
				                                            } ?> /> Saturday
				                                        </span>
				                                    </div>
				                                </div>
				                            </div>
				                            <div class="field-wrap two-fields-wrap">
				                                <div class="field-div">
				                                    <label>*Choose time of day to receive alert:</label>
				                                    <select name="time_of_day" class="heartworm-alert" >
				                                        <?php for($i = 1; $i <= 24; $i++): 
				                                            if (!empty($heartworm)) {
				                                                if (isset($heartworm['time_of_day']) && $heartworm['time_of_day'] == $i) {
				                                                    echo '<option selected value="'.$i.'">'. date("h.i A", strtotime("$i:00")).'</option>';
				                                                }else{
				                                                    echo '<option value="'.$i.'">'. date("h.i A", strtotime("$i:00")).'</option>';
				                                                }
				                                            }else{
				                                                echo '<option value="'.$i.'">'. date("h.i A", strtotime("$i:00")).'</option>';  
				                                            }
				                                            
				                                        endfor; ?>
				                                    </select>
				                                </div>
				                                <div class="field-div">
				                                    <label>*Choose first day to receive this alert:</label>
				                                    <input type="text" name="alert_date" class="first-day heartworm-alert" value="<?php if (!empty($heartworm)) {
				                                            if (isset($heartworm['alert_date']) && !empty($heartworm['alert_date'])) {
				                                                echo $heartworm['alert_date'];
				                                            }else{
				                                                echo date("F d, Y");
				                                            }
				                                        }else{
				                                            echo date("F d, Y");
				                                        } ?>" >
				                                </div>
				                            </div>
				                            <div class="field-wrap two-fields-wrap">
				                                <div class="field-div">
				                                    <label>*Frequency of alert:</label>
				                                    <select class="heartworm-alert" name="frequency_of_alert">
				                                        <?php 
				                                            $i = 1;
				                                            while ( $i <= 12 ) {
				                                                if (!empty($heartworm)) {
				                                                    if (isset($heartworm['frequency_of_alert']) && $heartworm['frequency_of_alert'] == $i) {
				                                                        if ($i == 1) {
				                                                            echo '<option selected value="'.$i.'">Every Month</option>';
				                                                        }else{
				                                                            echo '<option selected value="'.$i.'">Every '.$i.' Months</option>';
				                                                        }
				                                                    }else{
				                                                        if ($i == 1) {
				                                                            echo '<option  value="'.$i.'">Every Month</option>';
				                                                        }else{
				                                                            echo '<option  value="'.$i.'">Every '.$i.' Months</option>';
				                                                        }
				                                                    }
				                                                }else{
				                                                    if ($i == 1) {
				                                                    echo '<option value="'.$i.'">Every Month</option>';
				                                                    }else{
				                                                        echo '<option value="'.$i.'">Every '.$i.' Months</option>';
				                                                    }  
				                                                }
				                                                $i++;  
				                                            }
				                                        ?>
				                                    </select>
				                                </div>
				                                <div class="field-div">
				                                    <label>*How would you like to receive this alert?:</label>
				                                    <div class="multi-check-fields mb-15">
				                                        <span>
				                                            <input type="radio" name="recieve_alert" value="email" class="heartworm-alert" <?php if (!empty($heartworm)) {
				                                                if (isset($heartworm['recieve_alert']) && $heartworm['recieve_alert'] == "email") {
				                                                    echo "checked='checked'";
				                                                }
				                                            } ?> /> By Email
				                                        </span>
				                                        <span>
				                                            <input type="radio" name="recieve_alert" value="phone" class="heartworm-alert" <?php if (!empty($heartworm)) {
				                                                if (isset($heartworm['recieve_alert']) && $heartworm['recieve_alert'] == "phone") {
				                                                    echo "checked='checked'";
				                                                }
				                                            } ?> /> By Phone, VIA Text Message
				                                        </span>
				                                    </div>
				                                </div>
				                            </div>
				                            <div class="field-wrap">
				                                <div class="field-div">
				                                    <label>Add Notes (Optional):</label>
				                                    <input type="text" name="note" placeholder="Write Notes..." class="heartworm-alert" value="<?php if (!empty($heartworm)) {
				                                                if (!empty($heartworm['note'])) {
				                                                    echo $heartworm['note'];
				                                                }
				                                            } ?>" >
				                                </div>
				                            </div>
				                            <div class="field-wrap two-fields-wrap">
				                                <div class="field-div text-left">
				                                    <input type="button" name="" value="Remove Alert" class="site-btn-red remove-sing-up-alert <?php echo $heartwormClass ?>" <?php echo $heartwormClass ?>/>
				                                </div>
				                                <div class="field-div text-right">
				                                    <input type="button" name="" value="Save Alert" class="site-btn-red sing-up-alert" />
				                                </div>
				                            </div>
				                            <div class="field-wrap">
				                                <div class="field-notice"></div>
				                            </div>
				                        </div>
				                    </form>
				                </div>
				            </div>
				            <div class="acc-blue-box acc-plus-minus">
				                <div class="acc-blue-head">
				                    Flea & Tick Medication
				                    <i class="fa fa-plus"></i>
				                </div>
				                <div class="acc-blue-content">
				                    <div class="contact-form">
				                        <form>
				                            <input type="hidden" name="alert_name" value="flea_tick_medication_alert" class="flea-tick">
				                            <div class="field-wrap">
				                                <div class="field-div">
				                                    <label>*Choose day of the week to receive alert:</label>
				                                    <div class="multi-check-fields mb-15">
				                                        <span>
				                                            <input type="radio" name="day_of_week" value="7" class="flea-tick" <?php if (!empty($fleaTick)) {
				                                                if (isset($fleaTick['day_of_week']) && $fleaTick['day_of_week'] == 7) {
				                                                    echo "checked";
				                                                }
				                                            } ?> /> Sunday
				                                        </span>
				                                        <span>
				                                            <input type="radio" name="day_of_week" value="1" class="flea-tick" <?php if (!empty($fleaTick)) {
				                                                if (isset($fleaTick['day_of_week']) && $fleaTick['day_of_week'] == 1) {
				                                                    echo "checked";
				                                                }
				                                            } ?> /> Monday
				                                        </span>
				                                        <span>
				                                            <input type="radio" name="day_of_week" value="2" class="flea-tick" <?php if (!empty($fleaTick)) {
				                                                if (isset($fleaTick['day_of_week']) && $fleaTick['day_of_week'] == 2) {
				                                                    echo "checked";
				                                                }
				                                            } ?> /> Tuesday
				                                        </span>
				                                        <span>
				                                            <input type="radio" name="day_of_week" value="3" class="flea-tick" <?php if (!empty($fleaTick)) {
				                                                if (isset($fleaTick['day_of_week']) && $fleaTick['day_of_week'] == 3) {
				                                                    echo "checked";
				                                                }
				                                            } ?> /> Wednesday
				                                        </span>
				                                        <span>
				                                            <input type="radio" name="day_of_week" value="4" class="flea-tick" <?php if (!empty($fleaTick)) {
				                                                if (isset($fleaTick['day_of_week']) && $fleaTick['day_of_week'] == 4) {
				                                                    echo "checked";
				                                                }
				                                            } ?> /> Thursday
				                                        </span>
				                                        <span>
				                                            <input type="radio" name="day_of_week" value="5" class="flea-tick" <?php if (!empty($fleaTick)) {
				                                                if (isset($fleaTick['day_of_week']) && $fleaTick['day_of_week'] == 5) {
				                                                    echo "checked";
				                                                }
				                                            } ?> /> Friday
				                                        </span>
				                                        <span>
				                                            <input type="radio" name="day_of_week" value="6" class="flea-tick" <?php if (!empty($fleaTick)) {
				                                                if (isset($fleaTick['day_of_week']) && $fleaTick['day_of_week'] == 6) {
				                                                    echo "checked";
				                                                }
				                                            } ?> /> Saturday
				                                        </span>
				                                    </div>
				                                </div>
				                            </div>
				                            <div class="field-wrap two-fields-wrap">
				                                <div class="field-div">
				                                    <label>*Choose time of day to receive alert:</label>
				                                    <select name="time_of_day" class="flea-tick" >
				                                        <?php for($i = 1; $i <= 24; $i++): 
				                                            if (!empty($fleaTick)) {
				                                                if (isset($fleaTick['time_of_day']) && $fleaTick['time_of_day'] == $i) {
				                                                    echo '<option selected value="'.$i.'">'. date("h.i A", strtotime("$i:00")).'</option>';
				                                                }else{
				                                                    echo '<option value="'.$i.'">'. date("h.i A", strtotime("$i:00")).'</option>';
				                                                }
				                                            }else{
				                                                echo '<option value="'.$i.'">'. date("h.i A", strtotime("$i:00")).'</option>';  
				                                            }
				                                            
				                                        endfor; ?>
				                                    </select>
				                                </div>
				                                <div class="field-div">
				                                    <label>*Choose first day to receive this alert:</label>
				                                    <input type="text" name="alert_date" class="first-day flea-tick" value="<?php if (!empty($fleaTick)) {
				                                            if (isset($fleaTick['alert_date']) && !empty($fleaTick['alert_date'])) {
				                                                echo $fleaTick['alert_date'];
				                                            }else{
				                                                echo date("F d, Y");
				                                            }
				                                        }else{
				                                            echo date("F d, Y");
				                                        } ?>">
				                                </div>
				                            </div>
				                            <div class="field-wrap two-fields-wrap">
				                                <div class="field-div">
				                                    <label>*Frequency of alert:</label>
				                                    <select class="flea-tick" name="frequency_of_alert">
				                                        <?php 
				                                            $i = 1;
				                                            while ( $i <= 12 ) {
				                                                if (!empty($fleaTick)) {
				                                                    if (isset($fleaTick['frequency_of_alert']) && $fleaTick['frequency_of_alert'] == $i) {
				                                                        if ($i == 1) {
				                                                            echo '<option selected value="'.$i.'">Every Month</option>';
				                                                        }else{
				                                                            echo '<option selected value="'.$i.'">Every '.$i.' Months</option>';
				                                                        }
				                                                    }else{
				                                                        if ($i == 1) {
				                                                            echo '<option  value="'.$i.'">Every Month</option>';
				                                                        }else{
				                                                            echo '<option  value="'.$i.'">Every '.$i.' Months</option>';
				                                                        }
				                                                    }
				                                                }else{
				                                                    if ($i == 1) {
				                                                        echo '<option value="'.$i.'">Every Month</option>';
				                                                    }else{
				                                                        echo '<option value="'.$i.'">Every '.$i.' Months</option>';
				                                                    }  
				                                                }
				                                                $i++;  
				                                            }
				                                        ?>
				                                    </select>
				                                </div>
				                                <div class="field-div">
				                                    <label>*How would you like to receive this alert?:</label>
				                                    <div class="multi-check-fields mb-15">
				                                        <span>
				                                            <input type="radio" name="recieve_alert" value="email" class="flea-tick" <?php if (!empty($fleaTick)) {
				                                                if (isset($fleaTick['recieve_alert']) && $fleaTick['recieve_alert'] == "email") {
				                                                    echo "checked";
				                                                }
				                                            } ?> /> By Email
				                                        </span>
				                                        <span>
				                                            <input type="radio" name="recieve_alert" value="phone" class="flea-tick" <?php if (!empty($fleaTick)) {
				                                                if (isset($fleaTick['recieve_alert']) && $fleaTick['recieve_alert'] == "phone") {
				                                                    echo "checked";
				                                                }
				                                            } ?> /> By Phone, VIA Text Message
				                                        </span>
				                                    </div>
				                                </div>
				                            </div>
				                            <div class="field-wrap">
				                                <div class="field-div">
				                                    <label>Add Notes (Optional):</label>
				                                    <input type="text" placeholder="Write Notes..." name="note" class="flea-tick" value="<?php if (!empty($fleaTick)) {
				                                                if (!empty($fleaTick['note'])) {
				                                                    echo $fleaTick['note'];
				                                                }
				                                            } ?>">
				                                </div>
				                            </div>
				                            <div class="field-wrap two-fields-wrap">
				                                <div class="field-div text-left">
				                                    <input type="button" name="" value="Remove Alert" class="site-btn-red remove-sing-up-alert <?php echo $fleaTickClass; ?>" <?php echo $fleaTickClass; ?>/>
				                                </div>
				                                <div class="field-div text-right">
				                                    <input type="button" name="" value="Save Alert" class="site-btn-red sing-up-alert" />
				                                </div>
				                            </div>
				                            <div class="field-wrap">
				                                <div class="field-notice"></div>
				                            </div>
				                        </form>
				                    </div>
				                </div>
				            </div>
				            <div class="acc-blue-box acc-plus-minus">
				                <div class="acc-blue-head">
				                    Vet Appointments
				                    <i class="fa fa-plus"></i>
				                </div>
				                <div class="acc-blue-content">
				                    <div class="contact-form">
				                        <form>
				                            <input type="hidden" name="alert_name" value="vet_appointments_alert" class="vet-appo">
				                            <div class="field-wrap">
				                                <div class="field-div">
				                                    <label>*Choose day of the week to receive alert:</label>
				                                    <div class="multi-check-fields mb-15">
				                                        <span>
				                                            <input type="radio" name="day_of_week" value="7" class="vet-appo" <?php if (!empty($vetAppo)) {
				                                                if (isset($vetAppo['day_of_week']) && $vetAppo['day_of_week'] == 7) {
				                                                    echo "checked";
				                                                }
				                                            } ?> /> Sunday
				                                        </span>
				                                        <span>
				                                            <input type="radio" name="day_of_week" value="1" class="vet-appo" <?php if (!empty($vetAppo)) {
				                                                if (isset($vetAppo['day_of_week']) && $vetAppo['day_of_week'] == 1) {
				                                                    echo "checked";
				                                                }
				                                            } ?> /> Monday
				                                        </span>
				                                        <span>
				                                            <input type="radio" name="day_of_week" value="2" class="vet-appo" <?php if (!empty($vetAppo)) {
				                                                if (isset($vetAppo['day_of_week']) && $vetAppo['day_of_week'] == 2) {
				                                                    echo "checked";
				                                                }
				                                            } ?> /> Tuesday
				                                        </span>
				                                        <span>
				                                            <input type="radio" name="day_of_week" value="3" class="vet-appo" <?php if (!empty($vetAppo)) {
				                                                if (isset($vetAppo['day_of_week']) && $vetAppo['day_of_week'] == 3) {
				                                                    echo "checked";
				                                                }
				                                            } ?> /> Wednesday
				                                        </span>
				                                        <span>
				                                            <input type="radio" name="day_of_week" value="4" class="vet-appo" <?php if (!empty($vetAppo)) {
				                                                if (isset($vetAppo['day_of_week']) && $vetAppo['day_of_week'] == 4) {
				                                                    echo "checked";
				                                                }
				                                            } ?> /> Thursday
				                                        </span>
				                                        <span>
				                                            <input type="radio" name="day_of_week" value="5" class="vet-appo" <?php if (!empty($vetAppo)) {
				                                                if (isset($vetAppo['day_of_week']) && $vetAppo['day_of_week'] == 5) {
				                                                    echo "checked";
				                                                }
				                                            } ?> /> Friday
				                                        </span>
				                                        <span>
				                                            <input type="radio" name="day_of_week" value="6" class="vet-appo" <?php if (!empty($vetAppo)) {
				                                                if (isset($vetAppo['day_of_week']) && $vetAppo['day_of_week'] == 6) {
				                                                    echo "checked";
				                                                }
				                                            } ?> /> Saturday
				                                        </span>
				                                    </div>
				                                </div>
				                            </div>
				                            <div class="field-wrap two-fields-wrap">
				                                <div class="field-div">
				                                    <label>*Choose time of day to receive alert:</label>
				                                    <select name="time_of_day" class="vet-appo" >
				                                        <?php for($i = 1; $i <= 24; $i++): 
				                                            if (!empty($vetAppo)) {
				                                                if (isset($vetAppo['time_of_day']) && $vetAppo['time_of_day'] == $i) {
				                                                    echo '<option selected value="'.$i.'">'. date("h.i A", strtotime("$i:00")).'</option>';
				                                                }else{
				                                                    echo '<option value="'.$i.'">'. date("h.i A", strtotime("$i:00")).'</option>';
				                                                }
				                                            }else{
				                                                echo '<option value="'.$i.'">'. date("h.i A", strtotime("$i:00")).'</option>';  
				                                            }
				                                            
				                                        endfor; ?>
				                                    </select>
				                                </div>
				                                <div class="field-div">
				                                    <label>*Choose first day to receive this alert:</label>
				                                    <input type="text" name="alert_date" class="first-day vet-appo" value="<?php if (!empty($vetAppo)) {
				                                            if (isset($vetAppo['alert_date']) && !empty($vetAppo['alert_date'])) {
				                                                echo $vetAppo['alert_date'];
				                                            }else{
				                                                echo date("F d, Y");
				                                            }
				                                        }else{
				                                            echo date("F d, Y");
				                                        } ?>">
				                                </div>
				                            </div>
				                            <div class="field-wrap two-fields-wrap">
				                                <div class="field-div">
				                                    <label>*Frequency of alert:</label>
				                                    <select class="vet-appo" name="frequency_of_alert">
				                                        <?php 
				                                            $i = 1;
				                                            while ( $i <= 12 ) {
				                                                if (!empty($vetAppo)) {
				                                                    if (isset($vetAppo['frequency_of_alert']) && $vetAppo['frequency_of_alert'] == $i) {
				                                                        if ($i == 1) {
				                                                            echo '<option selected value="'.$i.'">Every Month</option>';
				                                                        }else{
				                                                            echo '<option selected value="'.$i.'">Every '.$i.' Months</option>';
				                                                        }
				                                                    }else{
				                                                        if ($i == 1) {
				                                                            echo '<option  value="'.$i.'">Every Month</option>';
				                                                        }else{
				                                                            echo '<option  value="'.$i.'">Every '.$i.' Months</option>';
				                                                        }
				                                                    }
				                                                }else{
				                                                    if ($i == 1) {
				                                                        echo '<option value="'.$i.'">Every Month</option>';
				                                                    }else{
				                                                        echo '<option value="'.$i.'">Every '.$i.' Months</option>';
				                                                    } 
				                                                }
				                                                $i++;  
				                                            }
				                                        ?>
				                                    </select>
				                                </div>
				                                <div class="field-div">
				                                    <label>*How would you like to receive this alert?:</label>
				                                    <div class="multi-check-fields mb-15">
				                                        <span>
				                                            <input type="radio" name="recieve_alert" value="email" class="vet-appo" <?php if (!empty($vetAppo)) {
				                                                if (isset($vetAppo['recieve_alert']) && $vetAppo['recieve_alert'] == "email") {
				                                                    echo "checked";
				                                                }
				                                            } ?> /> By Email
				                                        </span>
				                                        <span>
				                                            <input type="radio" name="recieve_alert" value="phone" class="vet-appo" <?php if (!empty($vetAppo)) {
				                                                if (isset($vetAppo['recieve_alert']) && $vetAppo['recieve_alert'] == "phone") {
				                                                    echo "checked";
				                                                }
				                                            } ?> /> By Phone, VIA Text Message
				                                        </span>
				                                    </div>
				                                </div>
				                            </div>
				                            <div class="field-wrap">
				                                <div class="field-div">
				                                    <label>Add Notes (Optional):</label>
				                                    <input type="text" placeholder="Write Notes..." name="note" class="vet-appo" value="<?php if (!empty($vetAppo)) {
				                                                if (!empty($vetAppo['note'])) {
				                                                    echo $vetAppo['note'];
				                                                }
				                                            } ?>">
				                                </div>
				                            </div>
				                            <div class="field-wrap two-fields-wrap">
				                                <div class="field-div text-left">
				                                    <input type="button" name="" value="Remove Alert" class="site-btn-red remove-sing-up-alert <?php echo $vetAppoClass; ?>" <?php echo $vetAppoClass; ?> />
				                                </div>
				                                <div class="field-div text-right">
				                                    <input type="button" name="" value="Save Alert" class="site-btn-red sing-up-alert" />
				                                </div>
				                            </div>
				                            <div class="field-wrap">
				                                <div class="field-notice"></div>
				                            </div>
				                        </form>
				                    </div>
				                </div>
				            </div>
				            <div class="acc-blue-box acc-plus-minus">
				                <div class="acc-blue-head">
				                    Medication Alerts
				                    <i class="fa fa-plus"></i>
				                </div>
				                <div class="acc-blue-content">
				                    <div class="contact-form">
				                        <form>
				                            <input type="hidden" name="alert_name" value="medication_alert" class="medication-alert">
				                            <div class="field-wrap">
				                                <div class="field-div">
				                                    <label>*Choose day of the week to receive alert:</label>
				                                    <div class="multi-check-fields mb-15">
				                                        <span>
				                                            <input type="radio" name="day_of_week" value="7" class="medication-alert" <?php if (!empty($medica)) {
				                                                if (isset($medica['day_of_week']) && $medica['day_of_week'] == 7) {
				                                                    echo "checked";
				                                                }
				                                            } ?> /> Sunday
				                                        </span>
				                                        <span>
				                                            <input type="radio" name="day_of_week" value="1" class="medication-alert" <?php if (!empty($medica)) {
				                                                if (isset($medica['day_of_week']) && $medica['day_of_week'] == 1) {
				                                                    echo "checked";
				                                                }
				                                            } ?> /> Monday
				                                        </span>
				                                        <span>
				                                            <input type="radio" name="day_of_week" value="2" class="medication-alert" <?php if (!empty($medica)) {
				                                                if (isset($medica['day_of_week']) && $medica['day_of_week'] == 2) {
				                                                    echo "checked";
				                                                }
				                                            } ?> /> Tuesday
				                                        </span>
				                                        <span>
				                                            <input type="radio" name="day_of_week" value="3" class="medication-alert" <?php if (!empty($medica)) {
				                                                if (isset($medica['day_of_week']) && $medica['day_of_week'] == 3) {
				                                                    echo "checked";
				                                                }
				                                            } ?> /> Wednesday
				                                        </span>
				                                        <span>
				                                            <input type="radio" name="day_of_week" value="4" class="medication-alert" <?php if (!empty($medica)) {
				                                                if (isset($medica['day_of_week']) && $medica['day_of_week'] == 4) {
				                                                    echo "checked";
				                                                }
				                                            } ?> /> Thursday
				                                        </span>
				                                        <span>
				                                            <input type="radio" name="day_of_week" value="5" class="medication-alert" <?php if (!empty($medica)) {
				                                                if (isset($medica['day_of_week']) && $medica['day_of_week'] == 5) {
				                                                    echo "checked";
				                                                }
				                                            } ?> /> Friday
				                                        </span>
				                                        <span>
				                                            <input type="radio" name="day_of_week" value="6" class="medication-alert" <?php if (!empty($medica)) {
				                                                if (isset($medica['day_of_week']) && $medica['day_of_week'] == 6) {
				                                                    echo "checked";
				                                                }
				                                            } ?> /> Saturday
				                                        </span>
				                                    </div>
				                                </div>
				                            </div>
				                            <div class="field-wrap two-fields-wrap">
				                                <div class="field-div">
				                                    <label>*Choose time of day to receive alert:</label>
				                                    <select name="time_of_day" class="medication-alert" >
				                                         <?php for($i = 1; $i <= 24; $i++): 
				                                            if (!empty($medica)) {
				                                                if (isset($medica['time_of_day']) && $medica['time_of_day'] == $i) {
				                                                    echo '<option selected value="'.$i.'">'. date("h.i A", strtotime("$i:00")).'</option>';
				                                                }else{
				                                                    echo '<option value="'.$i.'">'. date("h.i A", strtotime("$i:00")).'</option>';
				                                                }
				                                            }else{
				                                                echo '<option value="'.$i.'">'. date("h.i A", strtotime("$i:00")).'</option>';  
				                                            }
				                                            
				                                        endfor; ?>
				                                    </select>
				                                </div>
				                                <div class="field-div">
				                                    <label>*Choose first day to receive this alert:</label>
				                                    <input type="text" name="alert_date" class="first-day medication-alert" value="<?php if (!empty($medica)) {
				                                            if (isset($medica['alert_date']) && !empty($medica['alert_date'])) {
				                                                echo $medica['alert_date'];
				                                            }else{
				                                                echo date("F d, Y");
				                                            }
				                                        }else{
				                                            echo date("F d, Y");
				                                        } ?>">
				                                </div>
				                            </div>
				                            <div class="field-wrap two-fields-wrap">
				                                <div class="field-div">
				                                    <label>*Frequency of alert:</label>
				                                    <select class="medication-alert" name="frequency_of_alert">
				                                        <?php 
				                                            $i = 1;
				                                            while ( $i <= 12 ) {
				                                                if (!empty($medica)) {
				                                                    if (isset($medica['frequency_of_alert']) && $medica['frequency_of_alert'] == $i) {
				                                                        if ($i == 1) {
				                                                            echo '<option selected value="'.$i.'">Every Month</option>';
				                                                        }else{
				                                                            echo '<option selected value="'.$i.'">Every '.$i.' Months</option>';
				                                                        }
				                                                    }else{
				                                                        if ($i == 1) {
				                                                            echo '<option  value="'.$i.'">Every Month</option>';
				                                                        }else{
				                                                            echo '<option  value="'.$i.'">Every '.$i.' Months</option>';
				                                                        }
				                                                    }
				                                                }else{
				                                                    if ($i == 1) {
				                                                        echo '<option value="'.$i.'">Every Month</option>';
				                                                    }else{
				                                                        echo '<option value="'.$i.'">Every '.$i.' Months</option>';
				                                                    } 
				                                                }
				                                                $i++;  
				                                            }
				                                        ?>
				                                    </select>
				                                </div>
				                                <div class="field-div">
				                                    <label>*How would you like to receive this alert?:</label>
				                                    <div class="multi-check-fields mb-15">
				                                        <span>
				                                            <input type="radio" name="recieve_alert" value="email" class="medication-alert" <?php if (!empty($medica)) {
				                                                if (isset($medica['recieve_alert']) && $medica['recieve_alert'] == "email") {
				                                                    echo "checked";
				                                                }
				                                            } ?> /> By Email
				                                        </span>
				                                        <span>
				                                            <input type="radio" name="recieve_alert" value="phone" class="medication-alert" <?php if (!empty($medica)) {
				                                                if (isset($medica['recieve_alert']) && $medica['recieve_alert'] == "phone") {
				                                                    echo "checked";
				                                                }
				                                            } ?> /> By Phone, VIA Text Message
				                                        </span>
				                                    </div>
				                                </div>
				                            </div>
				                            <div class="field-wrap">
				                                <div class="field-div">
				                                    <label>Add Notes (Optional):</label>
				                                    <input type="text" placeholder="Write Notes..." name="note" class="medication-alert" value="<?php if (!empty($medica)) {
				                                                if (!empty($medica['note'])) {
				                                                    echo $medica['note'];
				                                                }
				                                            } ?>">
				                                </div>
				                            </div>
				                            <div class="field-wrap two-fields-wrap">
				                                <div class="field-div text-left">
				                                    <input type="button" name="" value="Remove Alert" class="site-btn-red remove-sing-up-alert <?php echo $medicaClass; ?>" <?php echo $medicaClass; ?> />
				                                </div>
				                                <div class="field-div text-right">
				                                    <input type="button" name="" value="Save Alert" class="site-btn-red sing-up-alert" />
				                                </div>
				                            </div>
				                            <div class="field-wrap">
				                                <div class="field-notice"></div>
				                            </div>
				                        </form>
				                    </div>
				                </div>
				            </div>
				            <div class="acc-blue-box acc-plus-minus">
				                <div class="acc-blue-head">
				                    Rabies Shot Alerts
				                    <i class="fa fa-plus"></i>
				                </div>
				                <div class="acc-blue-content">
				                    <div class="contact-form">
				                        <form>
				                            <input type="hidden" name="alert_name" value="rabies_shot_alert" class="rabies-shot">
				                            <div class="field-wrap">
				                                <div class="field-div">
				                                    <label>*Choose day of the week to receive alert:</label>
				                                    <div class="multi-check-fields mb-15">
				                                        <span>
				                                            <input type="radio" name="day_of_week" value="7" class="rabies-shot" <?php if (!empty($rabiesShot)) {
				                                                if (isset($rabiesShot['day_of_week']) && $rabiesShot['day_of_week'] == 7) {
				                                                    echo "checked";
				                                                }
				                                            } ?> /> Sunday
				                                        </span>
				                                        <span>
				                                            <input type="radio" name="day_of_week" value="1" class="rabies-shot" <?php if (!empty($rabiesShot)) {
				                                                if (isset($rabiesShot['day_of_week']) && $rabiesShot['day_of_week'] == 1) {
				                                                    echo "checked";
				                                                }
				                                            } ?> /> Monday
				                                        </span>
				                                        <span>
				                                            <input type="radio" name="day_of_week" value="2" class="rabies-shot" <?php if (!empty($rabiesShot)) {
				                                                if (isset($rabiesShot['day_of_week']) && $rabiesShot['day_of_week'] == 2) {
				                                                    echo "checked";
				                                                }
				                                            } ?> /> Tuesday
				                                        </span>
				                                        <span>
				                                            <input type="radio" name="day_of_week" value="3" class="rabies-shot" <?php if (!empty($rabiesShot)) {
				                                                if (isset($rabiesShot['day_of_week']) && $rabiesShot['day_of_week'] == 3) {
				                                                    echo "checked";
				                                                }
				                                            } ?> /> Wednesday
				                                        </span>
				                                        <span>
				                                            <input type="radio" name="day_of_week" value="4" class="rabies-shot" <?php if (!empty($rabiesShot)) {
				                                                if (isset($rabiesShot['day_of_week']) && $rabiesShot['day_of_week'] == 4) {
				                                                    echo "checked";
				                                                }
				                                            } ?> /> Thursday
				                                        </span>
				                                        <span>
				                                            <input type="radio" name="day_of_week" value="5" class="rabies-shot" <?php if (!empty($rabiesShot)) {
				                                                if (isset($rabiesShot['day_of_week']) && $rabiesShot['day_of_week'] == 5) {
				                                                    echo "checked";
				                                                }
				                                            } ?> /> Friday
				                                        </span>
				                                        <span>
				                                            <input type="radio" name="day_of_week" value="6" class="rabies-shot" <?php if (!empty($rabiesShot)) {
				                                                if (isset($rabiesShot['day_of_week']) && $rabiesShot['day_of_week'] == 6) {
				                                                    echo "checked";
				                                                }
				                                            } ?> /> Saturday
				                                        </span>
				                                    </div>
				                                </div>
				                            </div>
				                            <div class="field-wrap two-fields-wrap">
				                                <div class="field-div">
				                                    <label>*Choose time of day to receive alert:</label>
				                                    <select name="time_of_day" class="rabies-shot" >
				                                        <?php for($i = 1; $i <= 24; $i++): 
				                                            if (!empty($rabiesShot)) {
				                                                if (isset($rabiesShot['time_of_day']) && $rabiesShot['time_of_day'] == $i) {
				                                                    echo '<option selected value="'.$i.'">'. date("h.i A", strtotime("$i:00")).'</option>';
				                                                }else{
				                                                    echo '<option value="'.$i.'">'. date("h.i A", strtotime("$i:00")).'</option>';
				                                                }
				                                            }else{
				                                                echo '<option value="'.$i.'">'. date("h.i A", strtotime("$i:00")).'</option>';  
				                                            }
				                                            
				                                        endfor; ?>
				                                    </select>
				                                </div>
				                                <div class="field-div">
				                                    <label>*Choose first day to receive this alert:</label>
				                                    <input type="text" name="alert_date" class="first-day rabies-shot" value="<?php if (!empty($rabiesShot)) {
				                                            if (isset($rabiesShot['alert_date']) && !empty($rabiesShot['alert_date'])) {
				                                                echo $rabiesShot['alert_date'];
				                                            }else{
				                                                echo date("F d, Y");
				                                            }
				                                        }else{
				                                            echo date("F d, Y");
				                                        } ?>">
				                                </div>
				                            </div>
				                            <div class="field-wrap two-fields-wrap">
				                                <div class="field-div">
				                                    <label>*Frequency of alert:</label>
				                                    <select class="rabies-shot" name="frequency_of_alert">
				                                        <?php 
				                                            $i = 1;
				                                            while ( $i <= 12 ) {
				                                                if (!empty($rabiesShot)) {
				                                                    if (isset($rabiesShot['frequency_of_alert']) && $rabiesShot['frequency_of_alert'] == $i) {
				                                                        if ($i == 1) {
				                                                            echo '<option selected value="'.$i.'">Every Month</option>';
				                                                        }else{
				                                                            echo '<option selected value="'.$i.'">Every '.$i.' Months</option>';
				                                                        }
				                                                    }else{
				                                                        if ($i == 1) {
				                                                            echo '<option  value="'.$i.'">Every Month</option>';
				                                                        }else{
				                                                            echo '<option  value="'.$i.'">Every '.$i.' Months</option>';
				                                                        }
				                                                    }
				                                                }else{
				                                                    if ($i == 1) {
				                                                    echo '<option value="'.$i.'">Every Month</option>';
				                                                    }else{
				                                                        echo '<option value="'.$i.'">Every '.$i.' Months</option>';
				                                                    } 
				                                                }
				                                                $i++;  
				                                            }
				                                        ?>
				                                    </select>
				                                </div>
				                                <div class="field-div">
				                                    <label>*How would you like to receive this alert?:</label>
				                                    <div class="multi-check-fields mb-15">
				                                        <span>
				                                            <input type="radio" name="recieve_alert" value="email" class="rabies-shot" <?php if (!empty($rabiesShot)) {
				                                                if (isset($rabiesShot['recieve_alert']) && $rabiesShot['recieve_alert'] == "email") {
				                                                    echo "checked";
				                                                }
				                                            } ?> /> By Email
				                                        </span>
				                                        <span>
				                                            <input type="radio" name="recieve_alert" value="phone" class="rabies-shot" <?php if (!empty($rabiesShot)) {
				                                                if (isset($rabiesShot['recieve_alert']) && $rabiesShot['recieve_alert'] == "phone") {
				                                                    echo "checked";
				                                                }
				                                            } ?> /> By Phone, VIA Text Message
				                                        </span>
				                                    </div>
				                                </div>
				                            </div>
				                            <div class="field-wrap">
				                                <div class="field-div">
				                                    <label>Add Notes (Optional):</label>
				                                    <input type="text" name="note" placeholder="Write Notes..." class="rabies-shot" value="<?php if (!empty($rabiesShot)) {
				                                                if (!empty($rabiesShot['note'])) {
				                                                    echo $rabiesShot['note'];
				                                                }
				                                            } ?>">
				                                </div>
				                            </div>
				                            <div class="field-wrap two-fields-wrap">
				                                <div class="field-div text-left">
				                                    <input type="button" name="" value="Remove Alert" class="site-btn-red remove-sing-up-alert <?php echo $rabiesShotClass; ?>" <?php echo $rabiesShotClass; ?> />
				                                </div>
				                                <div class="field-div text-right">
				                                    <input type="button" name="" value="Save Alert" class="site-btn-red sing-up-alert" />
				                                </div>
				                            </div>
				                            <div class="field-wrap">
				                                <div class="field-notice"></div>
				                            </div>
				                        </form>
				                    </div>
				                </div>
				            </div>
				            <div class="acc-blue-box acc-plus-minus">
				                <div class="acc-blue-head">
				                    Tag Licensing Alerts
				                    <i class="fa fa-plus"></i>
				                </div>
				                <div class="acc-blue-content">
				                    <div class="contact-form">
				                        <form>
				                            <input type="hidden" name="alert_name" value="tag_licensing_alert" class="tag-licens">
				                            <div class="field-wrap">
				                                <div class="field-div">
				                                    <label>*Choose day of the week to receive alert:</label>
				                                    <div class="multi-check-fields mb-15">
				                                        <span>
				                                            <input type="radio" name="day_of_week" value="7" class="tag-licens" <?php if (!empty($tagLicens)) {
				                                                if (isset($tagLicens['day_of_week']) && $tagLicens['day_of_week'] == 7) {
				                                                    echo "checked";
				                                                }
				                                            } ?> /> Sunday
				                                        </span>
				                                        <span>
				                                            <input type="radio" name="day_of_week" value="1" class="tag-licens" <?php if (!empty($tagLicens)) {
				                                                if (isset($tagLicens['day_of_week']) && $tagLicens['day_of_week'] == 1) {
				                                                    echo "checked";
				                                                }
				                                            } ?> /> Monday
				                                        </span>
				                                        <span>
				                                            <input type="radio" name="day_of_week" value="2" class="tag-licens" <?php if (!empty($tagLicens)) {
				                                                if (isset($tagLicens['day_of_week']) && $tagLicens['day_of_week'] == 2) {
				                                                    echo "checked";
				                                                }
				                                            } ?> /> Tuesday
				                                        </span>
				                                        <span>
				                                            <input type="radio" name="day_of_week" value="3" class="tag-licens" <?php if (!empty($tagLicens)) {
				                                                if (isset($tagLicens['day_of_week']) && $tagLicens['day_of_week'] == 3) {
				                                                    echo "checked";
				                                                }
				                                            } ?> /> Wednesday
				                                        </span>
				                                        <span>
				                                            <input type="radio" name="day_of_week" value="4" class="tag-licens" <?php if (!empty($tagLicens)) {
				                                                if (isset($tagLicens['day_of_week']) && $tagLicens['day_of_week'] == 4) {
				                                                    echo "checked";
				                                                }
				                                            } ?> /> Thursday
				                                        </span>
				                                        <span>
				                                            <input type="radio" name="day_of_week" value="5" class="tag-licens" <?php if (!empty($tagLicens)) {
				                                                if (isset($tagLicens['day_of_week']) && $tagLicens['day_of_week'] == 5) {
				                                                    echo "checked";
				                                                }
				                                            } ?> /> Friday
				                                        </span>
				                                        <span>
				                                            <input type="radio" name="day_of_week" value="6" class="tag-licens" <?php if (!empty($tagLicens)) {
				                                                if (isset($tagLicens['day_of_week']) && $tagLicens['day_of_week'] == 6) {
				                                                    echo "checked";
				                                                }
				                                            } ?> /> Saturday
				                                        </span>
				                                    </div>
				                                </div>
				                            </div>
				                            <div class="field-wrap two-fields-wrap">
				                                <div class="field-div">
				                                    <label>*Choose time of day to receive alert:</label>
				                                    <select name="time_of_day" class="tag-licens" >
				                                        <?php for($i = 1; $i <= 24; $i++): 
				                                            if (!empty($tagLicens)) {
				                                                if (isset($tagLicens['time_of_day']) && $tagLicens['time_of_day'] == $i) {
				                                                    echo '<option selected value="'.$i.'">'. date("h.i A", strtotime("$i:00")).'</option>';
				                                                }else{
				                                                    echo '<option value="'.$i.'">'. date("h.i A", strtotime("$i:00")).'</option>';
				                                                }
				                                            }else{
				                                                echo '<option value="'.$i.'">'. date("h.i A", strtotime("$i:00")).'</option>';  
				                                            }
				                                            
				                                        endfor; ?>
				                                    </select>
				                                </div>
				                                <div class="field-div">
				                                    <label>*Choose first day to receive this alert:</label>
				                                    <input type="text" name="alert_date" class="first-day tag-licens" value="<?php if (!empty($tagLicens)) {
				                                            if (isset($tagLicens['alert_date']) && !empty($tagLicens['alert_date'])) {
				                                                echo $tagLicens['alert_date'];
				                                            }else{
				                                                echo date("F d, Y");
				                                            }
				                                        }else{
				                                            echo date("F d, Y");
				                                        } ?>">
				                                </div>
				                            </div>
				                            <div class="field-wrap two-fields-wrap">
				                                <div class="field-div">
				                                    <label>*Frequency of alert:</label>
				                                    <select class="tag-licens" name="frequency_of_alert">
				                                        <?php 
				                                            $i = 1;
				                                            while ( $i <= 12 ) {
				                                                if (!empty($tagLicens)) {
				                                                    if (isset($tagLicens['frequency_of_alert']) && $tagLicens['frequency_of_alert'] == $i) {
				                                                        if ($i == 1) {
				                                                            echo '<option selected value="'.$i.'">Every Month</option>';
				                                                        }else{
				                                                            echo '<option selected value="'.$i.'">Every '.$i.' Months</option>';
				                                                        }
				                                                    }else{
				                                                        if ($i == 1) {
				                                                            echo '<option  value="'.$i.'">Every Month</option>';
				                                                        }else{
				                                                            echo '<option  value="'.$i.'">Every '.$i.' Months</option>';
				                                                        }
				                                                    }
				                                                }else{
				                                                    if ($i == 1) {
				                                                    echo '<option value="'.$i.'">Every Month</option>';
				                                                    }else{
				                                                        echo '<option value="'.$i.'">Every '.$i.' Months</option>';
				                                                    }
				                                                }
				                                                
				                                                $i++;  
				                                            }
				                                        ?>
				                                    </select>
				                                </div>
				                                <div class="field-div">
				                                    <label>*How would you like to receive this alert?:</label>
				                                    <div class="multi-check-fields mb-15">
				                                        <span>
				                                            <input type="radio" name="recieve_alert" value="email" class="tag-licens" <?php if (!empty($tagLicens)) {
				                                                if (isset($tagLicens['recieve_alert']) && $tagLicens['recieve_alert'] == "email") {
				                                                    echo "checked";
				                                                }
				                                            } ?> /> By Email
				                                        </span>
				                                        <span>
				                                            <input type="radio" name="recieve_alert" value="phone" class="tag-licens" <?php if (!empty($tagLicens)) {
				                                                if (isset($tagLicens['recieve_alert']) && $tagLicens['recieve_alert'] == "phone") {
				                                                    echo "checked";
				                                                }
				                                            } ?> /> By Phone, VIA Text Message
				                                        </span>
				                                    </div>
				                                </div>
				                            </div>
				                            <div class="field-wrap">
				                                <div class="field-div">
				                                    <label>Add Notes (Optional):</label>
				                                    <input type="text" name="note" placeholder="Write Notes..." class="tag-licens" value="<?php if (!empty($tagLicens)) {
				                                                if (!empty($tagLicens['note'])) {
				                                                    echo $tagLicens['note'];
				                                                }
				                                            } ?>">
				                                </div>
				                            </div>
				                            <div class="field-wrap two-fields-wrap">
				                                <div class="field-div text-left">
				                                    <input type="button" name="" value="Remove Alert" class="site-btn-red remove-sing-up-alert <?php echo $tagLicensClass; ?>" <?php echo $tagLicensClass; ?> />
				                                </div>
				                                <div class="field-div text-right">
				                                    <input type="button" name="" value="Save Alert" class="site-btn-red sing-up-alert" />
				                                </div>
				                            </div>
				                            <div class="field-wrap">
				                                <div class="field-notice"></div>
				                            </div>
				                        </form>
				                    </div>
				                </div>
				            </div>
				            <div class="custom-box-wrap">
				                <?php if ((int)$totalCustm) {
				                    $j = 1;
				                    $k = 0;
				                    while ( $j <= $totalCustm ) {
				                        $customAlert = get_user_meta($userId,"custom_alert_".$j,true);
				                        if (!empty($customAlert)) {
				                        ?>
				                        <div class="acc-blue-box acc-plus-minus custom-box">
				                            <div class="acc-blue-head">
				                                Create a Custom Alert
				                                <i class="fa fa-plus"></i>
				                            </div>
				                            <div class="acc-blue-content">
				                                <div class="contact-form">
				                                    <form>
				                                        <div class="field-wrap">
				                                            <div class="field-div">
				                                                <label>*Name Your Custom Alert:</label>
				                                                <input type="text" name="custom_alert_name" class="custom-alert" value="<?php if (!empty($customAlert)) {
				                                                if (isset($customAlert['custom_alert_name'])) {
				                                                    echo $customAlert['custom_alert_name'];
				                                                }
				                                            } ?> ">
				                                                <input type="hidden" name="custom_alert_number" value="<?php echo "custom_alert_".$j; ?>" class="custom-alert-number">
				                                            </div>
				                                        </div>
				                                        <div class="field-wrap">
				                                            <div class="field-div">
				                                                <label>*Choose day of the week to receive alert:</label>
				                                                <div class="multi-check-fields mb-15">
				                                                    <span>
				                                                        <input type="radio" name="day_of_week" value="7" class="tag-licens" <?php if (!empty($customAlert)) {
				                                                if (isset($customAlert['day_of_week']) && $customAlert['day_of_week'] == 7) {
				                                                    echo "checked";
				                                                }
				                                            } ?> /> Sunday
				                                                    </span>
				                                                    <span>
				                                                        <input type="radio" name="day_of_week" value="1" class="tag-licens" <?php if (!empty($customAlert)) {
				                                                if (isset($customAlert['day_of_week']) && $customAlert['day_of_week'] == 1) {
				                                                    echo "checked";
				                                                }
				                                            } ?> /> Monday
				                                                    </span>
				                                                    <span>
				                                                        <input type="radio" name="day_of_week" value="2" class="tag-licens" <?php if (!empty($customAlert)) {
				                                                if (isset($customAlert['day_of_week']) && $customAlert['day_of_week'] == 2) {
				                                                    echo "checked";
				                                                }
				                                            } ?> /> Tuesday
				                                                    </span>
				                                                    <span>
				                                                        <input type="radio" name="day_of_week" value="3" class="tag-licens" <?php if (!empty($customAlert)) {
				                                                if (isset($customAlert['day_of_week']) && $customAlert['day_of_week'] == 3) {
				                                                    echo "checked";
				                                                }
				                                            } ?> /> Wednesday
				                                                    </span>
				                                                    <span>
				                                                        <input type="radio" name="day_of_week" value="4" class="tag-licens" <?php if (!empty($customAlert)) {
				                                                if (isset($customAlert['day_of_week']) && $customAlert['day_of_week'] == 4) {
				                                                    echo "checked";
				                                                }
				                                            } ?> /> Thursday
				                                                    </span>
				                                                    <span>
				                                                        <input type="radio" name="day_of_week" value="5" class="tag-licens" <?php if (!empty($customAlert)) {
				                                                if (isset($customAlert['day_of_week']) && $customAlert['day_of_week'] == 5) {
				                                                    echo "checked";
				                                                }
				                                            } ?> /> Friday
				                                                    </span>
				                                                    <span>
				                                                        <input type="radio" name="day_of_week" value="6" class="tag-licens" <?php if (!empty($customAlert)) {
				                                                if (isset($customAlert['day_of_week']) && $customAlert['day_of_week'] == 6) {
				                                                    echo "checked";
				                                                }
				                                            } ?> /> Saturday
				                                                    </span>
				                                                </div>
				                                            </div>
				                                        </div>
				                                        <div class="field-wrap two-fields-wrap">
				                                            <div class="field-div">
				                                                <label>*Choose time of day to receive alert:</label>
				                                                <select name="time_of_day" class="tag-licens" >
				                                                    <?php for($i = 1; $i <= 24; $i++): 
				                                                        if (!empty($customAlert)) {
				                                                            if (isset($customAlert['time_of_day']) && $customAlert['time_of_day'] == $i) {
				                                                                echo '<option selected value="'.$i.'">'. date("h.i A", strtotime("$i:00")).'</option>';
				                                                            }else{
				                                                                echo '<option value="'.$i.'">'. date("h.i A", strtotime("$i:00")).'</option>';
				                                                            }
				                                                        }else{
				                                                            echo '<option value="'.$i.'">'. date("h.i A", strtotime("$i:00")).'</option>';  
				                                                        }
				                                                    endfor; ?>
				                                                </select>
				                                            </div>
				                                            <div class="field-div">
				                                                <label>*Choose first day to receive this alert:</label>
				                                                <input type="text" name="alert_date" class="first-day tag-licens" value="<?php if (!empty($customAlert)) {
				                                            if (isset($customAlert['alert_date']) && !empty($customAlert['alert_date'])) {
				                                                echo $customAlert['alert_date'];
				                                            }else{
				                                                echo date("F d, Y");
				                                            }
				                                        }else{
				                                            echo date("F d, Y");
				                                        } ?>">
				                                            </div>
				                                        </div>
				                                        <div class="field-wrap two-fields-wrap">
				                                            <div class="field-div">
				                                                <label>*Frequency of alert:</label>
				                                                <select class="tag-licens" name="frequency_of_alert">
				                                                    <?php 
				                                                        $i = 1;
				                                                        while ( $i <= 12 ) {
				                                                            if (!empty($customAlert)) {
				                                                                if (isset($customAlert['frequency_of_alert']) && $customAlert['frequency_of_alert'] == $i) {
				                                                                    if ($i == 1) {
				                                                                        echo '<option selected value="'.$i.'">Every Month</option>';
				                                                                    }else{
				                                                                        echo '<option selected value="'.$i.'">Every '.$i.' Months</option>';
				                                                                    }
				                                                                }else{
				                                                                    if ($i == 1) {
				                                                                        echo '<option  value="'.$i.'">Every Month</option>';
				                                                                    }else{
				                                                                        echo '<option  value="'.$i.'">Every '.$i.' Months</option>';
				                                                                    }
				                                                                }
				                                                            }else{
				                                                                if ($i == 1) {
				                                                                echo '<option value="'.$i.'">Every Month</option>';
				                                                                }else{
				                                                                    echo '<option value="'.$i.'">Every '.$i.' Months</option>';
				                                                                } 
				                                                            }
				                                                            
				                                                            $i++;  
				                                                        }
				                                                    ?>
				                                                </select>
				                                            </div>
				                                            <div class="field-div">
				                                                <label>*How would you like to receive this alert?:</label>
				                                                <div class="multi-check-fields mb-15">
				                                                    <span>
				                                                        <input type="radio" name="recieve_alert" value="email" class="tag-licens" <?php if (!empty($customAlert)) {
				                                                if (isset($customAlert['recieve_alert']) && $customAlert['recieve_alert'] == "email") {
				                                                    echo "checked";
				                                                }
				                                            } ?> /> By Email
				                                                    </span>
				                                                    <span>
				                                                        <input type="radio" name="recieve_alert" value="phone" class="tag-licens" <?php if (!empty($customAlert)) {
				                                                if (isset($customAlert['recieve_alert']) && $customAlert['recieve_alert'] == "phone") {
				                                                    echo "checked";
				                                                }
				                                            } ?> /> By Phone, VIA Text Message
				                                                    </span>
				                                                </div>
				                                            </div>
				                                        </div>
				                                        <div class="field-wrap">
				                                            <div class="field-div">
				                                                <label>Add Notes (Optional):</label>
				                                                <input type="text" name="note" placeholder="Write Notes..." class="tag-licens" value="<?php if (!empty($customAlert)) {
				                                                if (!empty($customAlert['note'])) {
				                                                    echo $customAlert['note'];
				                                                }
				                                            } ?>">
				                                            </div>
				                                        </div>
				                                        <div class="field-wrap two-fields-wrap">
				                                            <div class="field-div text-left">
				                                                <input type="button" name="" value="Remove Alert" class="site-btn-red remove-custom-alert" />
				                                            </div>
				                                            <div class="field-div text-right">
				                                                <input type="button" name="" value="Save Alert" class="site-btn-red custom-alert" />
				                                            </div>
				                                        </div>
				                                        <div class="field-wrap">
				                                            <div class="field-notice"></div>
				                                        </div>
				                                    </form>
				                                </div>
				                            </div>
				                        </div>
				                        <?php 
				                        }else{
				                            $k++;
				                        }
				                        $j++;
				                    }
				                    if ($k == $totalCustm) { ?>
				                        <div class="acc-blue-box acc-plus-minus custom-box">
				                            <div class="acc-blue-head">
				                                Create a Custom Alert
				                                <i class="fa fa-plus"></i>
				                            </div>
				                            <div class="acc-blue-content">
				                                <div class="contact-form">
				                                    <form>
				                                        <div class="field-wrap">
				                                            <div class="field-div">
				                                                <label>*Name Your Custom Alert:</label>
				                                                <input type="text" name="custom_alert_name" class="custom-alert">
				                                                <input type="hidden" name="custom_alert_number" value="0"  class="custom-alert-number">
				                                            </div>
				                                        </div>
				                                        <div class="field-wrap">
				                                            <div class="field-div">
				                                                <label>*Choose day of the week to receive alert:</label>
				                                                <div class="multi-check-fields mb-15">
				                                                    <span>
				                                                        <input type="radio" name="day_of_week" value="7" class="custom-alert" /> Sunday
				                                                    </span>
				                                                    <span>
				                                                        <input type="radio" name="day_of_week" value="1" class="custom-alert" /> Monday
				                                                    </span>
				                                                    <span>
				                                                        <input type="radio" name="day_of_week" value="2" class="custom-alert" /> Tuesday
				                                                    </span>
				                                                    <span>
				                                                        <input type="radio" name="day_of_week" value="3" class="custom-alert" /> Wednesday
				                                                    </span>
				                                                    <span>
				                                                        <input type="radio" name="day_of_week" value="4" class="custom-alert" /> Thursday
				                                                    </span>
				                                                    <span>
				                                                        <input type="radio" name="day_of_week" value="5" class="custom-alert" /> Friday
				                                                    </span>
				                                                    <span>
				                                                        <input type="radio" name="day_of_week" class="custom-alert" value="6" /> Saturday
				                                                    </span>
				                                                </div>
				                                            </div>
				                                        </div>
				                                        <div class="field-wrap two-fields-wrap">
				                                            <div class="field-div">
				                                                <label>*Choose time of day to receive alert:</label>
				                                                <select name="time_of_day" class="custom-alert">
				                                                    <?php for($i = 1; $i <= 24; $i++): ?>
				                                                        <option value="<?= $i; ?>"><?= date("h.i A", strtotime("$i:00")); ?></option>
				                                                    <?php endfor; ?>
				                                                </select>
				                                            </div>
				                                            <div class="field-div">
				                                                <label>*Choose first day to receive this alert:</label>
				                                                <input type="text" name="alert_date" class="first-day custom-alert" value="<?php echo date("F d, Y"); ?>">
				                                            </div>
				                                        </div>
				                                        <div class="field-wrap two-fields-wrap">
				                                            <div class="field-div">
				                                                <label>*Frequency of alert:</label>
				                                                <select class="custom-alert" name="frequency_of_alert">
				                                                    <?php 
				                                                        $i = 1;
				                                                        while ( $i <= 12 ) {
				                                                            if ($i == 1) {
				                                                                echo '<option value="'.$i.'">Every Month</option>';
				                                                            }else{
				                                                                echo '<option value="'.$i.'">Every '.$i.' Months</option>';
				                                                            }
				                                                            $i++;  
				                                                        }
				                                                    ?>
				                                                </select>
				                                            </div>
				                                            <div class="field-div">
				                                                <label>*How would you like to receive this alert?:</label>
				                                                <div class="multi-check-fields mb-15">
				                                                    <span>
				                                                        <input type="radio" name="recieve_alert" class="custom-alert" value="email" /> By Email
				                                                    </span>
				                                                    <span>
				                                                        <input type="radio" name="recieve_alert" class="custom-alert" value="phone" /> By Phone, VIA Text Message
				                                                    </span>
				                                                </div>
				                                            </div>
				                                        </div>
				                                        <div class="field-wrap">
				                                            <div class="field-div">
				                                                <label>Add Notes (Optional):</label>
				                                                <input type="text" name="note" placeholder="Write Notes..." class="custom-alert">
				                                            </div>
				                                        </div>
				                                        <div class="field-wrap two-fields-wrap">
				                                            <div class="field-div text-left">
				                                                <input type="button" name="" value="Remove Alert" class="site-btn-red remove-custom-alert disabled" disabled="" />
				                                            </div>
				                                            <div class="field-div text-right">
				                                                <input type="button" name="" value="Save Alert" class="site-btn-red custom-alert" />
				                                            </div>
				                                        </div>
				                                    </form>
				                                </div>
				                            </div>
				                        </div>
				                    <?php }
				                }else{ ?>
				                    <div class="acc-blue-box acc-plus-minus custom-box">
				                        <div class="acc-blue-head">
				                            Create a Custom Alert
				                            <i class="fa fa-plus"></i>
				                        </div>
				                        <div class="acc-blue-content">
				                            <div class="contact-form">
				                                <form>
				                                    <div class="field-wrap">
				                                        <div class="field-div">
				                                            <label>*Name Your Custom Alert:</label>
				                                            <input type="text" name="custom_alert_name" class="custom-alert">
				                                            <input type="hidden" name="custom_alert_number" value="0"  class="custom-alert-number">
				                                        </div>
				                                    </div>
				                                    <div class="field-wrap">
				                                        <div class="field-div">
				                                            <label>*Choose day of the week to receive alert:</label>
				                                            <div class="multi-check-fields mb-15">
				                                                <span>
				                                                    <input type="radio" name="day_of_week" value="7" class="custom-alert" /> Sunday
				                                                </span>
				                                                <span>
				                                                    <input type="radio" name="day_of_week" value="1" class="custom-alert" /> Monday
				                                                </span>
				                                                <span>
				                                                    <input type="radio" name="day_of_week" value="2" class="custom-alert" /> Tuesday
				                                                </span>
				                                                <span>
				                                                    <input type="radio" name="day_of_week" value="3" class="custom-alert" /> Wednesday
				                                                </span>
				                                                <span>
				                                                    <input type="radio" name="day_of_week" value="4" class="custom-alert" /> Thursday
				                                                </span>
				                                                <span>
				                                                    <input type="radio" name="day_of_week" value="5" class="custom-alert" /> Friday
				                                                </span>
				                                                <span>
				                                                    <input type="radio" name="day_of_week" class="custom-alert" value="6" /> Saturday
				                                                </span>
				                                            </div>
				                                        </div>
				                                    </div>
				                                    <div class="field-wrap two-fields-wrap">
				                                        <div class="field-div">
				                                            <label>*Choose time of day to receive alert:</label>
				                                            <select name="time_of_day" class="custom-alert">
				                                                <?php for($i = 1; $i <= 24; $i++): ?>
				                                                    <option value="<?= $i; ?>"><?= date("h.i A", strtotime("$i:00")); ?></option>
				                                                <?php endfor; ?>
				                                            </select>
				                                        </div>
				                                        <div class="field-div">
				                                            <label>*Choose first day to receive this alert:</label>
				                                            <input type="text" name="alert_date" class="first-day custom-alert" value="<?php echo date("F d, Y"); ?>">
				                                        </div>
				                                    </div>
				                                    <div class="field-wrap two-fields-wrap">
				                                        <div class="field-div">
				                                            <label>*Frequency of alert:</label>
				                                            <select class="custom-alert" name="frequency_of_alert">
				                                                <?php 
				                                                    $i = 1;
				                                                    while ( $i <= 12 ) {
				                                                        if ($i == 1) {
				                                                            echo '<option value="'.$i.'">Every Month</option>';
				                                                        }else{
				                                                            echo '<option value="'.$i.'">Every '.$i.' Months</option>';
				                                                        }
				                                                        $i++;  
				                                                    }
				                                                ?>
				                                            </select>
				                                        </div>
				                                        <div class="field-div">
				                                            <label>*How would you like to receive this alert?:</label>
				                                            <div class="multi-check-fields mb-15">
				                                                <span>
				                                                    <input type="radio" name="recieve_alert" class="custom-alert" value="email" /> By Email
				                                                </span>
				                                                <span>
				                                                    <input type="radio" name="recieve_alert" class="custom-alert" value="phone" /> By Phone, VIA Text Message
				                                                </span>
				                                            </div>
				                                        </div>
				                                    </div>
				                                    <div class="field-wrap">
				                                        <div class="field-div">
				                                            <label>Add Notes (Optional):</label>
				                                            <input type="text" name="note" placeholder="Write Notes..." class="custom-alert">
				                                        </div>
				                                    </div>
				                                    <div class="field-wrap two-fields-wrap">
				                                        <div class="field-div text-left">
				                                            <input type="button" name="" value="Remove Alert" class="site-btn-red remove-custom-alert disabled" disabled="" />
				                                        </div>
				                                        <div class="field-div text-right">
				                                            <input type="button" name="" value="Save Alert" class="site-btn-red custom-alert" />
				                                        </div>
				                                    </div>
				                                    <div class="field-wrap">
				                                        <div class="field-notice"></div>
				                                    </div>
				                                </form>
				                            </div>
				                        </div>
				                    </div>
				                <?php } ?>
				            </div>
				            <div class="field-wrap">
				                <div class="field-div">
				                    <button id="add-custom"><i class="fa fa-plus"></i> Create a Custom Alert</button>
				                </div>
				            </div>
				        </div>
				        <script type="text/javascript">
				            window.alert = 0;
				            jQuery(document).ready(function($) {
				                $("body").on("click","#add-custom",function(){
				                    var clone = $(".custom-box:last-child").clone().find(".first-day").each(function(){
				                            $(this).removeClass("hasDatepicker");
				                            $(this).removeAttr('id');
				                         }).end();
				                    var fclone = clone.find('.custom-alert-number').each(function(){
				                            $(this).val("0");
				                         }).end();
				                    fclone      = fclone.find('.remove-custom-alert').each(function(){
				                            $(this).attr("disabled",true);
				                            $(this).addClass("disabled");
				                            $(this).addClass("clone-btn");
				                         }).end();
				                    $(fclone).appendTo(".custom-box-wrap");
				                    $("body").find(".first-day").datepicker({
				                        dateFormat : "MM d, yy",
				                    });

				                });
				                $("body").find(".first-day").datepicker({
				                    dateFormat : "MM d, yy",
				                });

				                $('input[type="button"].sing-up-alert').on("click",function(){
				                    $this = $(this);
				                    var heartworm = new FormData();

				                    $.each($(this).parent().parent().parent().find('input[type="text"]'), function() {               
				                        heartworm.append($(this).attr('name'), $(this).val());                   
				                    });
				                    $.each($(this).parent().parent().parent().find('input[type="hidden"]'), function() {               
				                        heartworm.append($(this).attr('name'), $(this).val());                   
				                    });
				                    $.each($(this).parent().parent().parent().find('input[type="radio"]'), function() {       
				                        if ($(this).prop('checked') == true) {
				                            heartworm.append($(this).attr('name'), $(this).val());
				                        }                          
				                    });
				                    $.each($(this).parent().parent().parent().find('select'), function() {      
				                        heartworm.append($(this).attr('name'), $(this).val());                       
				                    });
				                    heartworm.append('action', 'updateAlerts');
				                    heartworm.append('status', 1);
				                    $.ajax({
				                        type: 'POST',
				                        url: '<?php echo admin_url( 'admin-ajax.php' ); ?>',
				                        data: heartworm,
				                        contentType: false,
				                        processData: false,
				                        dataType: 'json',
				                        success: function(res){
				                            console.log(res);
				                            console.log(res.class);
				                            // res = jQuery.parseJSON(res);
				                            if (res.success == 1) {
				                                $($this).parent().parent().parent().find('.field-notice').text(res.msg);
				                                $($this).parent().parent().parent().find(".remove-sing-up-alert").removeClass("disabled").attr("disabled",false);
				                                $(".standard-alerts").find("."+res.class).attr("checked",true);
				                            }
				                        }
				                    });
				                });
				                $('body').on('click','input[type="button"].custom-alert',function(){
				                    $this = $(this);
				                    window.alert = 0;
				                    var heartworm = new FormData();

				                    $.each($(this).parent().parent().parent().find('input[type="text"]'), function() {               
				                        heartworm.append($(this).attr('name'), $(this).val());                   
				                    });
				                    $.each($(this).parent().parent().parent().find('input[type="hidden"]'), function() {               
				                        heartworm.append($(this).attr('name'), $(this).val());                   
				                    });
				                    $.each($(this).parent().parent().parent().find('input[type="radio"]'), function() {       
				                        if ($(this).prop('checked') == true) {
				                            heartworm.append($(this).attr('name'), $(this).val());
				                        }                          
				                    });
				                    $.each($(this).parent().parent().parent().find('select'), function() {      
				                        heartworm.append($(this).attr('name'), $(this).val());                       
				                    });
				                    heartworm.append('action', 'updateCustomAlerts');
				                    heartworm.append('status', 1);
				                    $.ajax({
				                        type: 'POST',
				                        url: '<?php echo admin_url( 'admin-ajax.php' ); ?>',
				                        data: heartworm,
				                        contentType: false,
				                        processData: false,
				                        dataType: 'json',
				                        success: function(res){
				                            console.log(res);
				                            // res = jQuery.parseJSON(res);
				                            if (res.success == 1) {
				                                $($this).parent().parent().parent().find('.field-notice').text(res.msg);
				                                $($this).parent().parent().parent().find(".custom-alert-number").val(res.alertName);
				                                $($this).parent().parent().parent().find(".remove-custom-alert").removeClass("disabled").attr("disabled",false);
				                                $.each($('input.custom-alert-number'), function() {  
				                                    if ($(this).val() != "0") {
				                                        window.alert = 1;
				                                        return false; 
				                                    }
				                                });
				                                if (window.alert) {
				                                    $(".standard-alerts .custom-alert").attr("checked",true);
				                                }else{
				                                    $(".standard-alerts .custom-alert").attr("checked",false);
				                                }
				                            }
				                        }
				                    });
				                });
				                $('body').on('click','input[type="button"].remove-sing-up-alert',function(){
				                    $this = $(this);
				                    var heartworm = new FormData();
				                    $.each($(this).parent().parent().parent().find('input[type="hidden"]'), function() {               
				                        heartworm.append($(this).attr('name'), $(this).val());                   
				                    });
				                    heartworm.append('action', 'removeAlerts');
				                    $.ajax({
				                        type: 'POST',
				                        url: '<?php echo admin_url( 'admin-ajax.php' ); ?>',
				                        data: heartworm,
				                        contentType: false,
				                        processData: false,
				                        dataType: 'json',
				                        success: function(res){
				                            console.log(res);
				                            // res = jQuery.parseJSON(res);
				                            if (res.success == 1) {
				                                $($this).parent().parent().parent().find('.field-notice').text(res.msg);
				                                $($this).parent().parent().parent().find(".remove-custom-alert").addClass("disabled").attr("disabled",true);
				                                $(".standard-alerts").find("."+res.class).attr("checked",false);
				                            }
				                        }
				                    });
				                });
				                $('body').on('click','input[type="button"].remove-custom-alert',function(){
				                    $this = $(this);
				                    window.alert = 0;
				                    var name = $(".custom-alert-number").val();
				                    if (name != '0') {
				                        var heartworm = new FormData();
				                        $.each($(this).parent().parent().parent().find('input[type="hidden"]'), function() {               
				                            heartworm.append($(this).attr('name'), $(this).val());                   
				                        });
				                        heartworm.append('action', 'removeCustomAlerts');
				                        $.ajax({
				                            type: 'POST',
				                            url: '<?php echo admin_url( 'admin-ajax.php' ); ?>',
				                            data: heartworm,
				                            contentType: false,
				                            processData: false,
				                            dataType: 'json',
				                            success: function(res){
				                                console.log(res);
				                                // res = jQuery.parseJSON(res);
				                                if (res.success == 1) {
				                                    $($this).parent().parent().parent().find('.field-notice').text(res.msg);
				                                    $($this).parent().parent().parent().find(".custom-alert-number").val("0");
				                                    if ($(".custom-box-wrap .custom-box").length > 1) {
				                                        $($this).parent().parent().parent().parent().parent().parent().remove();
				                                    }
				                                    $.each($('input.custom-alert-number'), function() {  
				                                        if ($(this).val() != "0") {
				                                            window.alert = 1;
				                                            return false; 
				                                        }
				                                    });
				                                    console.log(window.alert);
				                                    if (window.alert) {
				                                        $(".standard-alerts .custom-alert").attr("checked",true);
				                                    }else{
				                                        $(".standard-alerts .custom-alert").attr("checked",false);
				                                    }
				                                }
				                            }
				                        });
				                    }else{
				                        if ($(".custom-box-wrap .custom-box").length > 1) {
				                            $($this).parent().parent().parent().parent().parent().parent().remove();
				                        }
				                        $.each($('input.custom-alert-number'), function() {  
				                            if ($(this).val() != "0") {
				                                $(".standard-alerts .custom-alert").attr("checked",true);
				                                return false; 
				                            }else{
				                                $(".standard-alerts .custom-alert").attr("checked",false);
				                            }
				                        });
				                    }
				                        
				                });
				                $.each($('input.custom-alert-number'), function() {  
				                    if ($(this).val() != "0") {
				                        $(".standard-alerts .custom-alert").attr("checked",true);
				                        return false; 
				                    }
				                });
				                // console.log($(".custom-box-wrap .custom-box").length);
				                /*$('input[type="button"].heartworm-alert').on("click",function(){
				                    $this = $(this);
				                    var heartworm = new FormData();

				                    $.each($('input[type="text"].heartworm-alert'), function() {               
				                        heartworm.append($(this).attr('name'), $(this).val());                   
				                    });
				                    $.each($('input[type="hidden"].heartworm-alert'), function() {               
				                        heartworm.append($(this).attr('name'), $(this).val());                   
				                    });
				                    $.each($('input[type="radio"].heartworm-alert'), function() {       
				                        if ($(this).prop('checked') == true) {
				                            heartworm.append($(this).attr('name'), $(this).val());
				                        }                          
				                    });
				                    $.each($('select.heartworm-alert'), function() {      
				                        heartworm.append($(this).attr('name'), $(this).val());                       
				                    });
				                    heartworm.append('action', 'updateAlerts');
				                    heartworm.append('status', 1);
				                    $.ajax({
				                        type: 'POST',
				                        url: '<?php echo admin_url( 'admin-ajax.php' ); ?>',
				                        data: heartworm,
				                        contentType: false,
				                        processData: false,
				                        dataType: 'json',
				                        success: function(res){
				                            console.log(res);
				                            // res = jQuery.parseJSON(res);
				                            if (res.success == 1) {
				                                $($this).parent().parent().parent().append('<div class="field-wrap"><div class="field-notice">Update Heartworm Medication Alert Successfully.</div></div>');
				                            }
				                        }
				                    });
				                });

				                $('input[type="button"].flea-tick').on("click",function(){
				                    $this = $(this);
				                    var heartworm = new FormData();

				                    $.each($('input[type="text"].flea-tick'), function() {               
				                        heartworm.append($(this).attr('name'), $(this).val());                   
				                    });
				                    $.each($('input[type="hidden"].flea-tick'), function() {               
				                        heartworm.append($(this).attr('name'), $(this).val());                   
				                    });
				                    $.each($('input[type="radio"].flea-tick'), function() {       
				                        if ($(this).prop('checked') == true) {
				                            heartworm.append($(this).attr('name'), $(this).val());
				                        }                          
				                    });
				                    $.each($('select.flea-tick'), function() {      
				                        heartworm.append($(this).attr('name'), $(this).val());                       
				                    });
				                    heartworm.append('action', 'updateAlerts');
				                    heartworm.append('status', 1);
				                    $.ajax({
				                        type: 'POST',
				                        url: '<?php echo admin_url( 'admin-ajax.php' ); ?>',
				                        data: heartworm,
				                        contentType: false,
				                        processData: false,
				                        dataType: 'json',
				                        success: function(res){
				                            console.log(res);
				                            // res = jQuery.parseJSON(res);
				                            if (res.success == 1) {
				                                $($this).parent().parent().parent().append('<div class="field-wrap"><div class="field-notice">Update Heartworm Medication Alert Successfully.</div></div>');
				                            }
				                        }
				                    });
				                });*/
				            });
				        </script>
				    <?php
				    }
				}else{
					$userId = get_current_user_id();	   
					$args = array('posts_per_page'=>10,
                                 'post_type'=>'pet_profile',
                                 'author' => $userId,
                                 'paged' => get_query_var('paged') ? get_query_var('paged') : 1) ;
					$wp_query = new WP_Query($args); 
				                
					while ( $wp_query->have_posts() ) : $wp_query->the_post(); 
				            $mypod = pods( 'pet_profile', get_the_id() ); 
				            $smarttag_id_number = $mypod->display('smarttag_id_number');
				            $microchip_id_number = $mypod->display('microchip_id_number');
				            $subscriptionId  = $mypod->display("smarttag_subscription_id");
				            if (!empty($subscriptionId)) {
				                $subscription   = wcs_get_subscription($subscriptionId);
				                $date           = $subscription->get_date("end");
				                $date           = date_parse_from_format('Y-m-d H:i:s',$date);
				                $time           = mktime(0, 0, 0, $date['month'], $date['day'], $date['year']);
				                $date           = date("m/d/Y", $time);
				                // $subscription = wc_get_order($subscriptionId);
				                // print_r($subscription->get_items());
				                foreach( $subscription->get_items() as $item_id => $product_subscription ){
				                    // Get the name
				                    $product_name = $product_subscription['name']." (Expires: ".$date.")";

				                    // print_r($product_subscription);
				                    $variationId  = $product_subscription['variation_id'];
				                }
				            }else{
				                $product_name = '';
				            }
				            
				            ?>
				            <div class="bottom-border-box">
				                <h3><?= get_the_title() ;?></h3>
				                <div class="row">
				                    <div class="col-sm-3 rmb-15">
				                        <?php echo get_the_post_thumbnail(); ?>
				                    </div>
				                    <div class="col-sm-5 rmb-15">
				                        <strong>Pet Name:</strong> <span class="name"><?php echo get_the_title(); ?></span>
				                        <br>
				                        <strong>Pet Type:</strong> <span><?php echo $mypod->display('pet_type'); ?></span>
				                        <br>
				                        <strong>IDTag Serial Number:</strong> <span class="name"><?php echo $mypod->display('smarttag_id_number'); ?></span>
				                        <br>
				                        <strong>IDTag Microchip Number:</strong> <span class="name"><?php echo $microchip_id_number; ?></span>
				                        <br>
				                        <strong>ID Tag Plan:</strong> <span><?php echo $product_name; ?></span>
				                    </div>
				                    <div class="col-sm-4 mb-elements">    
				                        <?php if (!empty($product_name)) { 
				                                $paltinumPlanVariationId = array(6853,6854,6855);
				                                $variationId = (int)$variationId;
				                                if (in_array($variationId, $paltinumPlanVariationId)) { ?>
				                                    <form action="" method="post" class="custom-form">
				                                        <input type="hidden" name="post_id" value="<?php echo get_the_ID(); ?>">
				                                        <input type="hidden" name="petProtectionPlan" value="<?php echo $product_name; ?>">
				                                        <p><button type="submit" class="sing-up-for-alerts site-btn-light-blue">Sing Up for Alerts <i class="fa fa-caret-right"></i></button></p>
				                                    </form>
				                                <?php }else{ 
				                                    ?>
				                                    <p><a href="<?php echo get_site_url().'/my-account/view-subscription/'.$subscriptionId.'/'; ?>" class="button view site-btn-light-blue">Upgrade Protection Plan <i class="fa fa-caret-right"></i></a></p>
				                                    <p style="color: red;">Smart Tag's Alerts service is for Platinum Plan only, Upgrade Pet Protection Plan to receive alerts.</p>
				                                <?php }
				                            }else{ ?>
				                                <p style="color: red;">Smart Tag's Alerts service is for Platinum Plan only, Purchase Pet Protection Plan to receive alerts.</p>
				                        <?php } ?>
				                    </div>
				                </div>
				            </div>
				        <?php 
				        endwhile;

					$big = 999999999; // need an unlikely integer
					$total_pages = $wp_query->max_num_pages;

					if ($total_pages > 1){

						echo "<div id='pagination'>".paginate_links( array(
						    'base' => str_replace( $big, '%#%', get_pagenum_link( $big ) ),
						    'format' => '?paged=%#%',
						    'current' => max( 1, get_query_var('paged') ),
						    'total' => $total_pages
						) )."</div>";
					}
					wp_reset_postdata();
				}
				?>
			</div>
		</div>
	</div>
</div>
<?php get_footer(); ?>

