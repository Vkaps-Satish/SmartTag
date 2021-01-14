<?php

if (!function_exists('is_plugin_active')) {
    include_once(ABSPATH . 'wp-admin/includes/plugin.php');
}

update_option('elastic-email-sender-basename', plugin_basename(__FILE__));

function sender_deactivation_admin_notice__info()
{
    $class = 'notice notice-info';
    $message = __('The Plugin Elastic Email Sender has just been activated. We\'ve detected the use of our second product - Elastic Email Subscribe Form. The plugin that has been activated is only for shipping. You want to send via the Elastic Email API and collect your contacts through our Widgets, activate Subscribe Form. If you don\'t need widgets, it\'s okay, keep Sender active.', 'elastic-email-subscribe');

    printf('<div class="%1$s"><p>%2$s</p></div>', esc_attr($class), esc_html($message));
}

if (is_plugin_active(get_option('elastic-email-subscribe-basename')) === true) {

    deactivate_plugins(get_option('elastic-email-subscribe-basename'));
    add_action('admin_notices', 'sender_deactivation_admin_notice__info');

} else {

    /*
     * Plugin Name: Elastic Email Sender
     * Text Domain: elastic-email-sender
     * Domain Path: /languages
     * Plugin URI: https://wordpress.org/plugins/elastic-email-sender/
     * Description: This plugin reconfigures the wp_mail() function to send email using API (via Elastic Email) instead of SMTP and creates an options page that allows you to specify various options.
     * Author: Elastic Email
     * Author URI: https://elasticemail.com
     * Version: 1.1.21
     * License: GPLv2 or later
     * Elastic Email Inc. for WordPress
     * Copyright (C) 2020
     */

    /* Version check */
    global $wp_version;
    $exit_msg = 'ElasticEmail Sender requires WordPress 4.1 or newer. <a href="http://codex.wordpress.org/Upgrading_WordPress"> Please update!</a>';

    global $sender_queue__db_version;
    $ee_db_version = '1.0';

    if (version_compare($wp_version, "4.1", "<")) {
        exit($exit_msg);
    }

    if (!class_exists('eemail')) {
        require_once('defaults/function.reset_pass.php');
        require_once('class/ees_mail.php');
        eemail::on_load(__DIR__);
    }
    update_option('ees_plugin_dir_name', plugin_basename(__DIR__));

    /* ----------- ADMIN ----------- */
    if (is_admin()) {

        register_activation_hook(__FILE__, 'elasticemailsender_activate');
        register_deactivation_hook(__FILE__, 'elasticemailsender_deactivate');

        /* activate */
        function elasticemailsender_activate()
        {
            update_option('daterangeselect', 'last-wk');
            register_uninstall_hook(__FILE__, 'elasticemailsender_uninstall');
        }

        /* deactivate */
        function elasticemailsender_deactivate()
        {
            if ((get_option('ee_setapikey') === 'eeset') && (get_option('ee_setapikey') !== 'eeunset')) {
                if (get_option('ee_accountemail') !== null || get_option('ee_accountemail') !== '') {
                    require_once(plugin_dir_path(__FILE__) . '/api/ElasticEmailClient.php');
                    try {
                        $addToUserListAPI = new \ElasticEmailClient\Contact();
                        $error = null;
                        $addToUserList = $addToUserListAPI->Add('d0bcb758-a55c-44bc-927c-34f48d5db864', get_option('ee_accountemail'), array('55c8fa37-4c77-45d0-8675-0937d034c605'), array(), 'D', 'Sender', ApiTypes\ContactSource::ContactApi, null, null, null, null, false, null, null, array(), null);
                    } catch (Exception $ex) {
                        $addToUserList = array();
                    }
                }
            }
        }

        /* uninstall */
        function elasticemailsender_uninstall()
        {
            delete_option('ees-connecting-status');
            delete_option('ee_publicaccountid');
            delete_option('ee_enablecontactfeatures');
            delete_option('ee_options');
            delete_option('ee_accountemail');
            delete_option('ee_accountemail_2');
            delete_option('ee_setapikey');
            delete_option('ee_send-email-type');
            delete_option('ees_plugin_dir_name');
            delete_option('ee_config_from_name');
            delete_option('ee_config_from_email');
            delete_option('ee_from_email');
            delete_option('daterangeselect');
            delete_option('elastic-email-sender-basename');
            delete_option('ee_config_override_wooCommerce');
            delete_option('ee_config_woocommerce_original_email');
            delete_option('ee_config_woocommerce_original_name');
        }

        require_once 'class/ees_admin.php';
        $ee_admin = new eeadmin(__DIR__);
    }
}