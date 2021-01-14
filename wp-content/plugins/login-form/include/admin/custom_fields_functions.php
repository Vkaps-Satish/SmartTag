<?php



    function wpadm_clf_short_code_show(){

    ?>
    <input type="text" onclick="this.select();" value="[wpadm-login]">
    <br/>  
    <p class="description">
        <?php
            print __('Please, copy and past this short code in any Post or Page of your website to show the WordPress Login Form on it.', 'login-form' );
        ?>
    </p>
    <?php 
    }

    function wpadm_clf_form_no_password_enable ($field, $value){


    ?>
    <div>
        <input type="radio" name="form-no-password-is-activate" id="form-no-password-is-activate_no" value="no" <?php if($value == 'no') print ' checked'; ?> >
        <label for="form-no-password-is-activate_no">
            <?php _e('Disabled', 'login-form'); ?>
        </label>
        &nbsp;&nbsp;&nbsp;&nbsp;
        <input type="radio" name="form-no-password-is-activate" id="form-no-password-is-activate_yes" value="yes" <?php if($value == 'yes') print ' checked'; ?>>
        <label for="form-no-password-is-activate_yes">
            <?php _e('Enabled', 'login-form'); ?>
        </label>
        <br> 

    </div>
    <script>

        jQuery(document).ready(function(){

            function change_role_box(){

                var value =  jQuery('input[name="form-no-password-is-activate"]:checked').val(); 

                if( value === 'yes' ) {
                    jQuery("#form-no-password-user-role-field-tr").removeClass('display-none').addClass('display-tr');
                    jQuery("#form-no-password-days_num_for_clear-field-tr").removeClass('display-none').addClass('display-tr');
                }
                else {
                    jQuery("#form-no-password-user-role-field-tr").removeClass('display-tr').addClass('display-none');
                    jQuery("#form-no-password-days_num_for_clear-field-tr").removeClass('display-tr').addClass('display-none');
                }
            }

            jQuery('input[name="form-no-password-is-activate"]').change(function(){

                change_role_box();
            })

            change_role_box();
        })
    </script>

    <?php
    }

    function wpadm_clf_form_captcha_settings_show($field, $value){

        wp_enqueue_script( 'wpadm-lib-arcticModal_js',  	plugins_url("../../js/arcticmodal/jquery.arcticmodal-0.3.min.js", (__FILE__) ) );
        wp_enqueue_style ( 'wpadm-lib-arcticModal_style',  	plugins_url("../../js/arcticmodal/jquery.arcticmodal-0.3.css", (__FILE__) ) );
        wp_enqueue_style ( 'wpadm-lib-arcticModal_theme',  	plugins_url("../../js/arcticmodal/themes/simple.css", (__FILE__) ) );

        if($value != '')
        {
            $values = unserialize($value);
        } else {
            $values = array('field' => '0', 'sitekey' => '', 'secretkey' => '');
        }

        if($values['field'] == ''){
            $values['field'] == '0';
        }

    ?>

    <div style="display: none;">
        <div class="box-modal" id="modal_google_keys_help">
            <div class="box-modal_close arcticmodal-close"><?php _e('Close', 'login-form'); ?></div>

            <div>
                <p style="font-size: 15px;">
                <?php 
                    _e('To get <strong>site key</strong> and <strong>secret key</strong> for Google reCAPTCHA you need to follow this simple steps:', 'login-form');
                ?>
                </p>
            </div>

            <div>
                <div style="float:left; margin-right:10px;">
                    <strong><?php _e('Step 1.', 'login-form');?></strong>
                </div>
                <div style="width:80%; float:left;">
                    <p><?php _e('Go to the web site of ', 'login-form');?><a href="https://www.google.com/recaptcha/admin" target="_blank"><?php _e('Google reCAPTCHA and Login', 'login-form');?></a><?php _e(' with your Google account credentials ', 'login-form');?> 
                        <br><i><?php _e('or', 'login-form');?></i><br>
                    <?php _e('if you don\'t have Google account, so, please ', 'login-form');?><a href="https://www.google.com/recaptcha/intro/index.html" target="_blank"><?php _e('Register', 'login-form');?></a><?php _e(' first.', 'login-form');?></p>
                </div>
                <div class="clear"></div>
            </div>

            <div>
                <div style="float:left; margin-right:10px;">
                    <strong><?php _e('Step 2.', 'login-form');?></strong>
                </div>
                <div style="width:80%; float:left;">
                    <p>
                        <strong><?php _e('If you sign in first time', 'login-form');?></strong> 
                        <?php _e('to Google reCAPTCHA  - you will see the button "Get reCAPTCHA" - click on it.', 'login-form');?>
                        <br><strong><?php _e('If you logged in Google', 'login-form');?></strong> 
                        <?php _e('reCAPTCHA, then you can click on this link to ', 'login-form');?><a href="https://www.google.com/recaptcha/admin" target="_blank"><?php _e('"Get reCAPTCHA"', 'login-form');?></a>.</p>
                </div>
                <div class="clear"></div>
            </div>

            <div>
                <div style="float:left; margin-right:10px;">
                    <strong><?php _e('Step 3.', 'login-form');?></strong>
                </div>
                <div style="width:80%; float:left;">
                    <p><?php _e('On the bottom of the page in Google reCAPTCHA dashboard you will see the "key settings", where you will need to register your website domain, through entering of Name, Domain name and Owners', 'login-form');?></p>
                    <p class="description" style="font-size: 10px; margin-top: 4px;">
                        <?php _e('For Example', 'login-form');?>
                        <br><?php _e('Name: MySite', 'login-form');?>
                        <br><?php _e('Domain name: example.com', 'login-form');?>
                        <br><?php _e('Owners: your@mail.com', 'login-form');?>
                    </p>
                </div>
                <div class="clear"></div>
            </div>

            <div>
                <div style="float:left; margin-right:10px;">
                    <strong><?php _e('Step 4.', 'login-form');?></strong>
                </div>
                <div style="width:80%; float:left;">
                    <p><?php _e('After successfully adding of your website domain information at Google reCAPTCHA system you will be able to find 
                        <br><strong>site key</strong> and <strong>secret key</strong> in the middle of the same page of Google reCAPTCHA dashboard.
                        <br>You will need to Copy this values and Paste on this plugin page, in corresponding fields for <strong>site key</strong> and <strong>secret key</strong> on  
                        <br><strong>"Security & Redirect"</strong> tab.
                        <br>After that you will need to wait about 30 minutes, till your domain in Google system will be activated for Google reCAPTCHA service.
                        <br>Enjoy!</p>', 'login-form');?>
                </div>
                <div class="clear"></div>
            </div>

        </div>
    </div>



    <input type="radio" name="form-captcha-settings[field]" value="0" onchange="displayGoogleKeys(this)" <?php if($values['field'] == '0') print 'checked=""';?>> <label for="form-captcha_type_1"><?php _e('Mathematical','login-form')?></label><br>
    <input type="radio" name="form-captcha-settings[field]" value="1" onchange="displayGoogleKeys(this)" <?php if($values['field'] == '1') print 'checked=""';?>> <label for="form-captcha_type_2"><?php _e('Google reCAPTCHA','login-form')?></label><br>

    <fieldset id="form-google-keys" style="margin-left:20px; width:97%"> <!--style="width:97%-->
        <!--<legend>Group</legend>-->
        <div id="gsettings">
            <div style="float:left">
                <input name="form-captcha-settings[sitekey]" placeholder="<?php _e('Enter your site key here','login-form')?>" value="<?php echo esc_attr( $values['sitekey'] );?>" type="text" style="width:370px">
                <p class="description" style="max-width: 300px;"><?php _e('Enter your site key here','login-form')?> <a href="#" style="font-size: 10px;" onclick="show_help()"><?php _e('(Where to get site key?)','login-form')?></a></p>
            </div>
            <div style="float:left">
                <input name="form-captcha-settings[secretkey]" placeholder="<?php _e('Enter your secret key here','login-form')?>" value="<?php echo esc_attr( $values['secretkey'] );?>" type="text" style="width:370px">
                <p class="description" style="max-width: 300px;"><?php _e('Enter your secret key here','login-form')?> <a href="#" style="font-size: 10px;" onclick="show_help()"><?php _e('(Where to get secret key?)','login-form')?></a></p>			
            </div>
        </div>
    </fieldset>

    <script>

        function show_help(){
            jQuery('#modal_google_keys_help').arcticmodal();
        }


        function displayGoogleKeys(t)
        {
            if ( jQuery(t).val() == 1 ) {

                jQuery("#form-google-keys").css ({
                    "display":"",
                });
                jQuery("#form-google-keys").animate({opacity:1}, {duration : 500, queue : false, complete: function() {
                    }
                });

            } else {
                jQuery("#form-google-keys").animate({opacity:0}, {duration : 500, queue : false, complete: function() {
                        jQuery("#form-google-keys").css ({
                            "opacity":"0",
                            "display":"none",
                        })
                    }
                });
            }
        }

        jQuery(document).ready(function() {

            var type = '<?php echo esc_html( $values['field'] );?>';
            if (type == 0) {
                jQuery('#form-google-keys').css('display', 'none');
            }

            if (type == 1) {
                jQuery('#form-google-keys').css('display', '');
            }


            var w = screen.width;
            if(w < 1306){
                jQuery('#form-google-keys').width(372);
            }
        })
    </script>

    <?php
    }

    function wpadm_clf_form_captcha_settings_save(){

        if( ! empty( $_POST['form-captcha-settings'] ) ){

            if( is_array($_POST['form-captcha-settings'])) {

                return serialize($_POST['form-captcha-settings']);
            }
        }
        else {

            return '';
        }
    }

    function wpadm_clf_form_loggedin_msg_show($field, $value){
        if($value != '')
        {
            $values = unserialize($value);
        } else {
            $values = array('field' => '0', 'custom' => 'Hello, {username}, your email: {user-email}');
        }

        if($values['field'] == ''){
            $values['field'] == '0';
        }
    ?>

    <div>
        <input type="radio" name="form-logged-in-show[field]" value="0" onchange="displayLoggedInForm(this)" <?php if($values['field'] == '0') print 'checked=""';?>> <label for="form-loggedin-msg-show_1"><?php _e('You are successfully authorized','login-form')?></label><br>
        <input type="radio" name="form-logged-in-show[field]" value="1" onchange="displayLoggedInForm(this)" <?php if($values['field'] == '1') print 'checked=""';?>> <label for="form-loggedin-msg-show_2"><?php _e('Hello, username','login-form')?></label><br>
        <input type="radio" name="form-logged-in-show[field]" value="2" onchange="displayLoggedInForm(this)" <?php if($values['field'] == '2') print 'checked=""';?>> <label for="form-loggedin-msg-show_3"><?php _e('Hello, user-email','login-form')?></label><br>
        <input type="radio" name="form-logged-in-show[field]" value="3" onchange="displayLoggedInForm(this)" <?php if($values['field'] == '3') print 'checked=""';?>> <label for="form-loggedin-msg-show_4"><?php _e('Custom','login-form')?></label><br>

        <br> 
        <fieldset id="form-custom-logged-field" style="margin-left:20px; display:none">
            <div>	
                <textarea name="form-logged-in-show[custom]" rows="3" cols="30"><?php echo esc_textarea( $values['custom'] ) ;?></textarea>

                <p class="description" style="max-width: 300px;"><?php _e('Available variables: {username}, {user-email}','login-form')?></p>
            </div>
        </fieldset>
    </div>


    <script>
        function displayLoggedInForm(t)
        {
            if ( jQuery(t).val() == 3 ) {

                jQuery("#form-custom-logged-field").css ({
                    "display":"",
                });
                jQuery("#form-custom-logged-field").animate({opacity:1}, {duration : 500, queue : false, complete: function() {
                    }
                });

            } else {
                jQuery("#form-custom-logged-field").animate({opacity:0}, {duration : 500, queue : false, complete: function() {
                        jQuery("#form-custom-logged-field").css ({
                            "opacity":"0",
                            "display":"none",
                        })
                    }
                });
            }
        }

        jQuery(document).ready(function() {
            var type = '<?php echo esc_html( $values['field'] );?>';
            if (type == 0 || type == 1 || type == 2) {
                jQuery('#form-custom-logged-field').css('display', 'none');
            }

            if (type == 3) {
                jQuery('#form-custom-logged-field').css('display', '');
            }
        });


    </script>



    <?php
    }

    function wpadm_clf_form_loggedin_msg_save(){

        if( ! empty( $_POST['form-logged-in-show'] ) ){

            if( is_array($_POST['form-logged-in-show'])) {

                return serialize($_POST['form-logged-in-show']);
            }
        }
        else {

            return '';
        }
    }

    function wpadm_clf_form_no_password_user_select_show($field, $value){

        if (!function_exists('wp_roles')) {
            global $wp_roles;

            if ( ! isset( $wp_roles ) ) {
                $wp_roles = new WP_Roles();
            }
        } else {
            $wp_roles = wp_roles();
        }

        krsort( $wp_roles->roles );

        print '<select name="' . esc_attr( $field['name'] ) . '">';



        foreach($wp_roles->roles as $role_name => $details  ){


            if( $role_name == $value ){

                $checked = ' selected'; 
            } 
            else {

                $checked = '';
            }

        ?>
        <option value="<?php print esc_attr( $role_name ); ?>" <?php print $checked ?>><?php print translate_user_role($details['name'])?></option> 
        <?php

        }

        print '</select>';

    }

    function wpadm_clf_form_role_everyrole_url_show ($field, $value){

        if($value){
            $values = unserialize($value);
        }
        else {
            $values = array('');
        }

        if (!function_exists('wp_roles')) {
            global $wp_roles;

            if ( ! isset( $wp_roles ) ) {
                $wp_roles = new WP_Roles();
            }
        } else {
            $wp_roles = wp_roles();
        }



        foreach($wp_roles->roles as $role_name => $details  ){

            $url = '';

            if( in_array( $role_name, array_keys( $values )) && isset($values[$role_name] ) ){

                $url = $values[$role_name]; 
            } 

        ?>
        <div class="form_role_role_url_show-box">

            <?php print translate_user_role($details['name'])?> <br/>

            <input type="text" name="<?php print esc_attr( $field['name'] ); ?>[<?php print esc_attr( $role_name );?>]" value="<?php echo esc_url( $url, null, '' )?>" placeholder="http://" />

            <br/>
            <br/>
        </div>
        <?php

        }

    }

    function wpadm_clf_form_role_everyrole_url_save(){


        if( ! empty( $_POST['form-role-everyrole-url'] ) ){

            if( is_array($_POST['form-role-everyrole-url'])) {

                return serialize($_POST['form-role-everyrole-url']);
            }
        }
        else {

            return '';
        }

    }

    function wpadm_clf_form_stealth_random_show($field, $value){


        if($value){
            $values = unserialize($value);
        }
        else {
            $values = array('');
        }

        $style = ' style="display:none"';

        foreach($values as $row){

        ?>
        <div class="form_stealth_random-box">
            <input type="text" name="<?php echo $field['name'];?>[]" value="<?php echo esc_attr( $row ); ?>" /><input type="button" <?php echo $style;?> class="button form_stealth_random-del" value="-"/><br/>
        </div>
        <?php

            $style = '';
        }

    ?>
    <input type="button" class="button form_stealth_random-add" value="+"/> <br/>


    <script>
        jQuery(document).ready(function (){

            jQuery(".form_stealth_random-add").click(function(){ 

                jQuery(".form_stealth_random-box:last").clone().insertBefore( ".form_stealth_random-box:last" );
                jQuery(".form_stealth_random-box:last input[type='text']").val('');
                jQuery(".form_stealth_random-box:last input").show();

            });

            jQuery(".form_stealth_random-del").live ('click', function(){  

                jQuery(this).parent().remove();
            });

        })
    </script>
    <?php

}

function wpadm_clf_form_stealth_random_save(){

    if( ! empty( $_POST['form-stealth-random-words'] ) ){

        if( is_array($_POST['form-stealth-random-words'])) {

            return serialize($_POST['form-stealth-random-words']);
        }
    }
    else {

        return '';
    }

}

function wpadm_clf_form_auto_authorization_save()
{
    if( ! empty( $_POST['form-auto-authorization-save'] ) ) {
        if( is_array($_POST['form-auto-authorization-save']) && isset($_POST['form-auto-authorization-save']['username']) && isset($_POST['form-auto-authorization-save']['password']) ) {
            return serialize($_POST['form-auto-authorization-save']);
        }
    } else {
        return '';
    }
}