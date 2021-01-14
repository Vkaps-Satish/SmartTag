<?php


    // color picker 

    function wpadm_clf_add_admin_iris_scripts( $hook ){
        // подключаем IRIS
        wp_enqueue_script( 'wp-color-picker' );
        wp_enqueue_style( 'wp-color-picker' );

    }
    add_action( 'admin_enqueue_scripts', 'wpadm_clf_add_admin_iris_scripts' );


    // установка файл пикера

    function wpadm_clf_wpalogin_admin_scripts() {

        if ( isset($_GET['page']) && $_GET['page'] == 'main-setting'){

            wp_enqueue_script('jquery');
            wp_enqueue_script('media-upload');
            wp_enqueue_script('thickbox');
            wp_register_script('login-form-js', WPA_LOGIN_DIR_URL . 'js/file_chooser.js', array('jquery','media-upload','thickbox'));
            wp_enqueue_script('login-form-js');
            wp_register_script('login-form-admin-js', WPA_LOGIN_DIR_URL . 'js/admin.js', array('jquery','media-upload','thickbox'));
            wp_enqueue_script('login-form-admin-js');
            $demo_w = 1200;
            if (WPA_LOGIN_PRO) {
                $demo_w = 2300;
            } 
            wp_localize_script('login-form-admin-js', 'login_form_parameters', array( 'width' => $demo_w) );

        }
    }

    function wpadm_clf_wpalogin_admin_styles(){

        if (isset($_GET['page']) && $_GET['page'] == 'main-setting') {

            wp_enqueue_style('thickbox'); 
            wp_register_style('login-form-css', WPA_LOGIN_DIR_URL . 'css/admin.css', array('thickbox')); 
            wp_register_style('glyphicons', WPA_LOGIN_DIR_URL . 'css/glyphicons.css', array('thickbox'));
            wp_enqueue_style('login-form-css');
            wp_enqueue_style('glyphicons');
        }
    }


    add_action('admin_print_scripts', 'wpadm_clf_wpalogin_admin_scripts');
    add_action('admin_print_styles', 'wpadm_clf_wpalogin_admin_styles');


    // Hook for adding admin menus
    add_action('admin_menu', 'wpadm_clf_wpalogin_add_pages');

    // action function for above hook
    function wpadm_clf_wpalogin_add_pages() {

        // Add a new submenu under Options:
        add_options_page('Wpadm-login-title', 'Login Form', 'activate_plugins', 'main-setting', 'wpadm_clf_wpalogin_main_setting');

    } 

    $wpadm_login->checkPay();

    function wpadm_clf_wpalogin_main_setting() {


        global $wpadm_login; 

        $parts = $wpadm_login->getParts(); 
        $hidden_field_name = 'mt_submit_hidden';
        $saved = false;

        if( !empty($_POST[ $hidden_field_name ]) && $_POST[ $hidden_field_name ] == 'Y' ) { 


            foreach($parts as $part) {
                if (isset($part['field'])) {
                    foreach($part['field'] as $field) {

                        if( ! empty($field['type']) && $field['type'] == 'title'){

                            continue;
                        }

                        if( empty( $field['save_function'] )){ 


                            if( ! isset($_POST[$field['name']] )){

                                continue; 
                            }

                            $value_for_update = sanitize_text_field( $_POST[$field['name']] );
                        }
                        else {

                            $value_for_update = $field['save_function']();

                        }


                        update_option( $field['name'], $value_for_update );
                    }
                }
            }

            $saved = true;
        }

        // Now display the options editing screen



        // header
        $title_page = __( 'Login Form', 'login-form' ) . '<small>' . __( 'Dashboard', 'login-form' ) . '</small>' ;
        if (WPA_LOGIN_PRO) {
            login_form_pro::getStylesAndScripts();
            $title_page = __( 'Login Form PRO', 'login-form' ) . '<small>' . __( 'Dashboard', 'login-form' ) . '</small>' ;

            //            if (!file_exists(WPA_LOGIN_DIR . '/class/class-pro.php')) {
            //                $title_page .= login_form_pro::updatePROHTML();
            //            }
        }

    ?>

    <style type="text/css">
        @media screen and (max-width: 782px) {
        .auto-fold #wpcontent {
        padding-left: 0px;
        }
        }

        #wpcontent {
        padding-left: 0px;
        }


    </style>
    <div>
        <div id='lf-s-content'>
            <div class='head'>
                <?php require 'pro.php'; ?>
                <div style="float: left">
                    <h1><?php echo $title_page; ?></h1>
                </div>



            </div>




            <?php
                require '5star.php';

                if ($saved) { ?>
                <div class="updated"><p><strong><?php _e('Settings was saved successfully', 'login-form' ); ?></strong></p></div>
                <?php } ?>




            <div class="menu">
                <ul>
                    <?php
                        foreach($parts as $key => $part) {
                            if (isset($part['title']) && isset($part['field'])) {
                                echo "<li><a href='javascript: void(0)' data-tab='tab_{$key}' " . (($key == 0) ? "class='active'" : '') . ">{$part['title']}</a></li>";
                            }
                        }
                    ?>

                    <li class="contact_us_cont">
                        <span class="contact_us_descr"><?php _e('If you have any suggestions or wishes', 'login-form'); ?> </span>

                        <button type="button" class="button button-primary button-large" onclick="lf_supportFormNormalize(); jQuery('.contact_us_btn').click()"><?php _e('Contact us', 'login-form'); ?></button>
                    </li>
                </ul>
            </div>


            <?php add_thickbox(); ?>
            <div id="modal_contact_us" style="display:none; max-height: 500px; max-width: 600px">
                <div id="lf_support_text_container">
                    <h2><?php _e('Suggestion', 'login-form'); ?></h2>
                    <textarea style="width: 100%; height: 300px" id="lf_support_text"></textarea>
                </div>

                <div id="lf_support_thank_container" style="display: none;">
                    <h2><?php _e('Thanks for your suggestion!', 'login-form'); ?></h2>
                    <?php _e('Within next plugin updates we will try to satisfy your request.', 'login-form');?>
                </div>

                <div id="lf_support_error_container" style="display: none;">
                    <br><b><?php _e('At your website the mail functionality is not available.', 'login-form'); ?></b><br /><br />
                    <?php _e('Your request was not sent.'); ?>
                </div>


                <div style="text-align: right; margin-top: 20px;">
                    <button type="button" class="button" onclick="jQuery('.tb-close-icon').click()"><?php _e('close', 'login-form'); ?></button>
                    <button type="button" class="button-primary" id="lf-support_send_button" onclick="lf_sendSupportText()"><?php _e('Send suggestion', 'login-form'); ?></button>

                </div>

            </div>
            <a class="contact_us_btn thickbox" href="#TB_inline?width=600&height=500&inlineId=modal_contact_us" style="display: none"><?php _e('Contact us' ,'login-form');?></a>



            <div class="tabs">
                <!--<form name="form1" method="post" action="--><?php //echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?><!--">-->
                <form name="form1" method="post" autocomplete="off">
                    <?php
                        foreach($parts as $key => $part) {
                            if (isset($part['title']) && isset($part['field'])) {
                                echo "<div class='tab tab_{$key}' " .(($key ==0) ? "style='display: block;'" : '') . ">";
                                require 'main-setting-tab.php';
                                echo "</div>";
                            }
                        }
                    ?>
                    <input type="hidden" name="mt_submit_hidden" value="Y">
                    <p>
                        <input type="submit" name="Submit" class="button button-primary button-large" value="<?php _e('Save Settings', 'login-form' ) ?>" />
                    </p>
                </form>
            </div>
        </div>

    </div>

    <style>
        /*#form-no-password-is-activate-field-tr .field_input_box {
        border:1px solid;
        border-bottom: 0;

        }
        #form-no-password-user-role-field-tr .field_input_box {
        border:1px solid;
        border-top:0;
        } */
        .nopadding {
            padding:0 !important;
        }
    </style>

    <?php
    require_once  WPA_LOGIN_DIR .   '/include/admin/file_chooser.php';
}




function wpadm_login_add_admin_media_chooser( $hook ){

    wp_enqueue_media( );

}

function wpadm_login_remove_media_tab($tabs) {
    unset($tabs['type']);
    unset($tabs['type_url']);
    unset($tabs['gallery']);
    unset($tabs['library']); 
    return $tabs;
}
add_filter('media_upload_tabs','wpadm_login_remove_media_tab', 99);

add_action( 'admin_enqueue_scripts', 'wpadm_login_add_admin_media_chooser' );

$_default_tabs = array(
		'type' => __('From Computer', 'login-form'), // handler action suffix => tab text
		'type_url' => __('From URL', 'login-form'),
		'gallery' => __('Gallery', 'login-form'),
		'library' => __('Media Library', 'login-form')
    );

 
# apply_filters( 'media_upload_tabs', $_default_tabs );