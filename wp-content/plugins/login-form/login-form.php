<?php
/*
Plugin Name: login-form
Description: Login Form with security and style features
Version: 2.1
Author: www.wpadm.com
Domain Path: /languages
Text Domain: login-form
*/

define ('WPA_LOGIN_DIR', dirname(__FILE__) );
define ('WPA_LOGIN_DIR_URL', plugin_dir_url(__FILE__)); 
define('WPA_SERVER_URL', 'http://secure.wpadm.com/');


add_action( 'init', 'login_form_load_textdomain' );
function login_form_load_textdomain() {
    load_plugin_textdomain( 'login-form' );
}

require WPA_LOGIN_DIR . '/class/class-login.php';

$wpadm_login = new wpadm_login;
if (get_option('login-form-pro-key') && !file_exists(WPA_LOGIN_DIR . '/class/class-pro.php')) {
    $wpadm_login->updatePlugin();
}


if (file_exists(WPA_LOGIN_DIR . '/class/class-pro.php')) {
    require WPA_LOGIN_DIR . '/class/class-pro.php';
    define('WPA_LOGIN_PRO', true);
} else {
    define('WPA_LOGIN_PRO', false);
}




add_action('admin_notices', array($wpadm_login, 'notice'));

function wpadm_login() {

    global $wpadm_login;

    return $wpadm_login -> show();
}


add_shortcode('wpadm-login', 'wpadm_login');

function wpadm_login_init_before_headers(){

    global $wpadm_login;

    $wpadm_login -> actions(); 
}

add_action('template_redirect', 'wpadm_login_init_before_headers');



if ( is_admin() ){ 
    require ( WPA_LOGIN_DIR . '/include/admin/custom_fields_functions.php' ); 
    require ( WPA_LOGIN_DIR . '/include/admin/main-setting.php' ); 
}


function wpadm_clf_hide_login_form() {

    if(get_option("form-stealth-hide-wplogin") == 1 ) {


        add_action('login_init', 'hide_wplogin');
    }
}

function hide_wplogin(){

    if (isset($_GET['action']) && $_GET['action'] == 'logout') {
        //do_action( 'login_init' ); 

        do_action( 'login_form_' . $_GET['action'] ); 

        check_admin_referer('log-out');

        $user = wp_get_current_user();

        wp_logout();
    }

    $url = home_url(); 

    wp_redirect($url, 302);
    exit;
}



function wpadm_clf_requestURI1()
{
    $part = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $part = trim($part, "/");
    $part = strtolower($part);
    $part = explode("/", $part);
    return $part[0];
}


add_action('init', 'wpadm_clf_hide_login_form');
add_action('admin_menu', 'wpadm_lf_generate_menu');

add_action( 'wp_ajax_lf_stopNotice5Stars', array($wpadm_login, 'stopNotice5Stars') );
add_action( 'wp_ajax_lf_sendSupport', array($wpadm_login, 'sendSupport') );

function wpadm_lf_generate_menu() {
    $pages = array();

    $menu_position = '1.9998887770';
    $pages[] = add_menu_page(
    'Login Form',
    'Login Form',
    'read',
    'main-setting',
    'wpadm_clf_wpalogin_main_setting',
    plugins_url('/img/icon.png',__FILE__),
    $menu_position
    );
}

  