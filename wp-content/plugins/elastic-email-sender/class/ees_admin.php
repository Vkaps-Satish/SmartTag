<?php

define('EE_ADMIN', true);

/**
 * Description of eeadmin
 *
 * @author ElasticEmail
 */
class eeadmin
{
    /**
     * Holds the values to be used in the fields callbacks
     */
    private $defaultOptions = array('ee_enable' => 'no', 'ee_apikey' => null),
        $options,
        $initAPI = false,
        $subscribe_status = false;
    public $theme_path;

    /**
     * Start up
     */
    public function __construct($pluginpath)
    {
        $this->theme_path = $pluginpath;
        add_action('init', array($this, 'WooCommerce_email'));
        add_action('init', array($this, 'WooCommerce_name'));
        add_action('admin_init', array($this, 'init_options'));
        add_action('plugins_loaded', array($this, 'eesender_load_textdomain'));
        $this->options = get_option('ee_options', $this->defaultOptions);

        if (is_multisite()) {
            add_action('network_admin_menu', array($this, 'add_menu'));
        } else {
            add_action('admin_menu', array($this, 'add_menu'));
        }
    }

    public function eesender_load_textdomain()
    {
        load_plugin_textdomain('elastic-email-sender', false, basename(dirname(__FILE__)) . '/languages');
    }

    // Added admin menu
    public function add_menu()
    {
        add_action('admin_enqueue_scripts', array($this, 'custom_admin_scripts'));

        add_menu_page('Elastic Email Sender', 'Elastic Email Sender', 'manage_options', 'elasticemail-settings', array($this, 'show_settings'), plugins_url('/assets/images/icon.png', dirname(__FILE__)));
        add_submenu_page('elasticemail-settings', 'Settings', __('Settings', 'elastic-email-sender'), 'manage_options', 'elasticemail-settings', array($this, 'show_settings'));
        add_submenu_page('elasticemail-settings', 'Reports', __('Reports', 'elastic-email-sender'), 'manage_options', 'elasticemail-report', array($this, 'show_reports'));
        add_submenu_page('elasticemail-settings', 'Send Test', __('Send test', 'elastic-email-sender'), 'manage_options', 'elasticemail-send-test', array($this, 'show_sendtest'));
    }

    /**
     *
     */
    public function custom_admin_scripts()
    {
        if (is_admin()) {

            $plugin_path = plugins_url() . '/' . get_option('ees_plugin_dir_name');
            wp_register_script('eesender-jquery', $plugin_path . '/assets/lib/jquery.3.3.1.min.js', '', 3.3, true);
            wp_register_script('eesender-send-test', $plugin_path . '/assets/js/ees_sendTest.js', '', 1.1, true);
            wp_register_script('eesender-chart-script', $plugin_path . '/assets/lib/chart.min.js', '', 2.7, true);
            wp_register_style('eesender-bootstrap-grid', $plugin_path . '/assets/lib/bootstrap-grid.min.css', '', 4.1, false);
            wp_register_style('eesender-css', $plugin_path . '/assets/css/ees_admin.min.css', '', 1.1, false);

            wp_localize_script('eesender-send-test', 'ees_localize_data',
                array(
                    'apikey' => get_option('ee-apikey'),
                    'from' => $this->set_sender_email(),
                    'name' => $this->set_sender_name()
                )
            );
        }
    }


    // Load Elastic Email settings
    public function show_settings()
    {
        $this->initAPI();
        try {
            $accountAPI = new \ElasticEmailClient\Account();
            $statusToSendEmailAPI = new \ElasticEmailClient\Account();
            $error = null;
            $account = $accountAPI->Load();
            $this->statusToSendEmail();
        } catch (ElasticEmailClient\ApiException $e) {
            $error = $e->getMessage();
            $account = array();
            $statusToSendEmail = array();
        }

        if (isset($account['data']['statusnumber'])) {
            if ($account['data']['statusnumber'] > 0) {
                $accountstatus = $account['data']['statusnumber'];
            } else {
                $accountstatus = 'Please conect to Elastic Email API';
            }
            update_option('ees-connecting-status', 'connecting');
        } else {
            $accountstatus = 'Please connect to Elastic Email API';
            update_option('ees-connecting-status', 'disconnected');
        }

        if (isset($account['data']['email'])) {
            update_option('ee_from_email', $account['data']['email']);
            update_option('ee_accountemail', $account['data']['email']);
        }

        $accountdailysendlimit = '';
        if (isset($account['data']['actualdailysendlimit'])) {
            $accountdailysendlimit = $account['data']['actualdailysendlimit'];
        }

        if (isset($account['data']['publicaccountid'])) {
            $this->publicid = $account['data']['publicaccountid'];
            update_option('ee_publicaccountid', $this->publicid);
        }

        if (isset($account['data']['enablecontactfeatures'])) {
            update_option('ee_enablecontactfeatures', $account['data']['enablecontactfeatures']);
        }

        if (isset($account['data']['requiresemailcredits'])) {
            $requiresemailcredits = $account['data']['requiresemailcredits'];
        }

        if (isset($account['data']['emailcredits'])) {
            $emailcredits = $account['data']['emailcredits'];
        }

        if (isset($account['data']['requiresemailcredits'])) {
            $requiresemailcredits = $account['data']['requiresemailcredits'];
        }

        if (isset($account['data']['issub'])) {
            $issub = $account['data']['issub'];
        }

        if (isset($account['data']['apikey'])) {
            update_option('ee-apikey', $account['data']['apikey']);
        }

        if (get_option('ee_accountemail') !== null) {
            if (get_option('ee_accountemail') !== get_option('ee_accountemail_2')) {
                $this->addToUserList();
            }
        }

        require_once($this->theme_path . '/template/t-ees_admin.php');
        return;
    }

    public function addToUserList()
    {
        try {
            $addToUserListAPI = new \ElasticEmailClient\Contact();
            $error = null;
            $sourceUrl = get_site_url();
            $addToUserList = $addToUserListAPI->Add('d0bcb758-a55c-44bc-927c-34f48d5db864', get_option('ee_accountemail'), array('55c8fa37-4c77-45d0-8675-0937d034c605'), array(), 'A', 'Sender', null, null, null, null, null, false, null, null, array(), null);
        } catch (Exception $ex) {
            $addToUserList = array();
        }
        update_option('ee_accountemail_2', get_option('ee_accountemail'));
    }

    public function statusToSendEmail()
    {
        $this->initAPI();
        try {
            $statusToSendEmailAPI = new \ElasticEmailClient\Account();
            $error = null;
            $statusToSendEmail = $statusToSendEmailAPI->GetAccountAbilityToSendEmail();
            update_option('elastic-email-to-send-status', $statusToSendEmail['data']);
        } catch (Exception $ex) {
            $statusToSendEmail = array();
        }
        return;
    }

    //Initialization Elastic Email API
    public function initAPI()
    {
        if ($this->initAPI === true) {
            return;
        }

        //Loads Elastic Email Client
        require_once($this->theme_path . '/api/ElasticEmailClient.php');
        if (empty($this->options['ee_apikey']) === false) {
            \ElasticEmailClient\ApiClient::SetApiKey($this->options['ee_apikey']);
        }
        $this->initAPI = true;
    }

    public function show_reports()
    {
        $this->initAPI();

        if (isset($_POST['daterange'])) {
            $daterangeselect = $_POST['daterange'];
            if ($daterangeselect === 'last-mth') {
                $from = date('c', strtotime('-30 days'));
                $to = date('c');
            }
            if ($daterangeselect === 'last-wk') {
                $from = date('c', strtotime('-7 days'));
                $to = date('c');
            }
            if ($daterangeselect === 'last-2wk') {
                $from = date('c', strtotime('-14 days'));
                $to = date('c');
            }
        } else {
            $from = date('c', strtotime('-30 days'));
            $to = date('c');
        }

        try {
            $LogAPI = new \ElasticEmailClient\Log();
            $error = null;
            $LogAPI_json = $LogAPI->Summary($from, $to, null, null, null);

            if ($LogAPI_json['data']['logstatussummary']['emailtotal'] !== null) {
                $total = $LogAPI_json['data']['logstatussummary']['emailtotal'];
                $delivered = $LogAPI_json['data']['logstatussummary']['delivered'];
                $opened = $LogAPI_json['data']['logstatussummary']['opened'];
                $bounced = $LogAPI_json['data']['logstatussummary']['bounced'];
                $clicked = $LogAPI_json['data']['logstatussummary']['clicked'];
                $unsubscribed = $LogAPI_json['data']['logstatussummary']['unsubscribed'];
            } else {
                $total = 1;
                $delivered = 1;
                $opened = 1;
                $bounced = 1;
                $clicked = 1;
                $unsubscribed = 1;
            }

        } catch (ElasticEmailClient\ApiException $e) {
            $error = $e->getMessage();
            $LogList = array();
        }
        //Loads the settings template
        require_once($this->theme_path . '/template/t-ees_reports.php');
        return;
    }

    public function show_sendtest()
    {
        require_once($this->theme_path . '/template/t-ees_sendtest.php');
        return;
    }


    //Initialization custom options
    public function init_options()
    {
        register_setting(
            'ee_option_group', // Option group
            'ee_options', // Option name
            array($this, 'valid_options')   // Santize Callback
        );
        //INIT SECTION
        add_settings_section('setting_section_id', null, null, 'ee-settings');
        //INIT FIELD
        add_settings_field('ee_enable', 'Select mailer:', array($this, 'enable_input'), 'ee-settings', 'setting_section_id', array('input_name' => 'ee_enable'));
        add_settings_field('ee_apikey', 'Elastic Email API Key:', array($this, 'input_apikey'), 'ee-settings', 'setting_section_id', array('input_name' => 'ee_apikey', 'width' => 280));
        add_settings_field('ee_emailtype', 'Email type:', array($this, 'emailtype_input'), 'ee-settings', 'setting_section_id', array('input_name' => 'ee_emailtype'));

        if (is_plugin_active('woocommerce/woocommerce.php')) {
            add_settings_field('ee_override_wooCommerce', 'Override: ', array($this, 'override_wooCommerce_input'), 'ee-settings', 'setting_section_id', array('input_name' => 'ee_override_wooCommerce', 'width' => 280));
        }
        add_settings_field('ee_from_name_config', 'From name (default empty):', array($this, 'from_name_config_input'), 'ee-settings', 'setting_section_id', array('input_name' => 'ee_from_name_config', 'width' => 280));
        add_settings_field('ee_from_email_config', 'Email FROM (default empty):', array($this, 'from_email_config_input'), 'ee-settings', 'setting_section_id', array('input_name' => 'ee_from_email_config', 'width' => 280));

    }

    /**
     * Validation plugin options during their update data
     * @param type $input
     * @return type
     */
    public function valid_options($input)
    {
        // If api key have * then use old api key
        if (strpos($input['ee_apikey'], '*') !== false) {
            $input['ee_apikey'] = $this->options['ee_apikey'];
        } else {
            $input['ee_apikey'] = sanitize_key($input['ee_apikey']);
        }

        if ($input['ee_enable'] !== 'yes') {
            $input['ee_enable'] = 'no';
        }
        return $input;
    }

    /**
     * Get the apikey option and print one of its values
     */
    public function input_apikey($arg)
    {
        $apikey = $this->options[$arg['input_name']];
        if (empty($apikey) === false) {
            $apikey = substr($apikey, 0, 15) . '***************';
        }
        printf('<input type="text" id="title" name="ee_options[' . $arg['input_name'] . ']" value="' . $apikey . '" style="%s"/>', (isset($arg['width']) && $arg['width'] > 0) ? 'width:' . $arg['width'] . 'px' : '');
    }

    /**
     * Displays the settings mailer
     */
    public function enable_input($arg)
    {
        if (!isset($this->options[$arg['input_name']]) || empty($this->options[$arg['input_name']])) {
            $valuel = 'no';
        } else {
            $valuel = $this->options[$arg['input_name']];
        }

        echo '<div style="margin-bottom:15px;"><label><input type="radio" name="ee_options[' . $arg['input_name'] . ']" value="yes" ' . (($valuel === 'yes') ? 'checked' : '') . '/><span>' . __('Send all WordPress emails via Elastic Email API.', 'elastic-email-sender') . '</span><label></div>';
        echo '<label><input type="radio" name="ee_options[' . $arg['input_name'] . ']" value="no"  ' . (($valuel === 'no') ? 'checked' : '') . '/><span>' . __('Use the defaults Wordpress function to send emails.', 'elastic-email-sender') . '</span><label>';
    }

    /**
     * Displays the settings email type
     */
    public function emailtype_input($arg)
    {
        if (!isset($this->options[$arg['input_name']]) || empty($this->options[$arg['input_name']])) {
            $type = 'marketing';
            update_option('ee_send-email-type', false);
        } else {
            $type = $this->options[$arg['input_name']];
            if ($type === 'marketing') {
                update_option('ee_send-email-type', false);
            } else {
                update_option('ee_send-email-type', true);
            }
        }
        echo '<div style="margin-bottom:15px;"><label><input type="radio" name="ee_options[' . $arg['input_name'] . ']" value="marketing" ' . (($type === 'marketing') ? 'checked' : '') . '/><span>' . __('Marketing', 'elastic-email-sender') . '</span><label></div>';
        echo '<label><input type="radio" name="ee_options[' . $arg['input_name'] . ']" value="transactional"  ' . (($type === 'transactional') ? 'checked' : '') . '/><span>' . __('Transactional', 'elastic-email-sender') . '</span><label>';
    }

    /**
     * Displays the settings from name
     */
    public function from_name_config_input($arg)
    {
        if (!isset($this->options[$arg['input_name']]) || empty($this->options[$arg['input_name']])) {
            $config_from_name = '';
            update_option('ee_config_from_name', null);
        } else {
            $config_from_name = $this->options[$arg['input_name']];
            update_option('ee_config_from_name', $config_from_name);
            /**Adding filter  to override wp_mail_from_name field , if the option is checked */
            if (get_option('ee_config_override_wooCommerce')) {
                do_action('WooCommerce_name');
            }
        }
        echo '<input type="text" name="ee_options[' . $arg['input_name'] . ']" placeholder="' . __('From name', 'elastic-email-sender') . '" value="' . $config_from_name . '" style="width:' . $arg['width'] . 'px"/>';
    }

    /**
     * Displays the settings email FROM
     */
    public function from_email_config_input($arg)
    {
        if (!isset($this->options[$arg['input_name']]) || empty($this->options[$arg['input_name']])) {
            $config_from_email = '';
            update_option('ee_config_from_email', null);

        } else {
            $config_from_email = $this->options[$arg['input_name']];
            update_option('ee_config_from_email', $config_from_email);
            /**Adding filter  to override wp_mail_from field , if the option is checked */
            if (get_option('ee_config_override_wooCommerce')) {
                do_action('WooCommerce_email');
            }

        }
        echo '<input type="text" name="ee_options[' . $arg['input_name'] . ']" placeholder="' . __('Email address FROM', 'elastic-email-sender') . '" value="' . $config_from_email . '" style="width:' . $arg['width'] . 'px"/>';
    }

    /**
     * Display checkbox to  override WooCommerce email 'from' and 'fromName'
     */
    public function override_wooCommerce_input($arg)
    {
        if (!isset($this->options[$arg['input_name']]) || empty($this->options[$arg['input_name']])) {
            update_option('ee_config_override_wooCommerce', 0);
            $override = 0;
        } else {
            update_option('ee_config_override_wooCommerce', 1);
            $override = 1;
        }
        echo '<div style="margin-bottom:15px;"><label><input type="checkbox" name="ee_options[' . $arg['input_name'] . ']" value="yes" ' . (($override === 1) ? 'checked' : '') . '/><span></span><label> <span>WooCommerce fields "Email from" and " From name"</span></div>';
    }

    /**function that sets sender email based on the FROM email input , also setting FROM email to send test feature */
    public function set_sender_email()
    {
        $sender = get_option('ee_from_email');
        if (!empty(get_option('ee_config_from_email'))) {
            $sender = get_option('ee_config_from_email');
        }
        return $sender;
    }

    /** function that sets from name based on the form name input , also setting FROM name to send test feature */
    public function set_sender_name()
    {
        $sender = 'Wordpress';
        if (!empty(get_option('ee_config_from_name'))) {
            $sender = get_option('ee_config_from_name');
        }
        return $sender;
    }

    /** function that based on override option and setted FROM email input adds filter for wp_mail_from to override wooCommerce settings */
    public function WooCommerce_email()
    {
        if (get_option('ee_config_override_wooCommerce') && !empty(get_option('ee_config_from_email'))) {
            $wooCommerce_email_original_email = get_option('woocommerce_email_from_address');
            if (!get_option('ee_config_woocommerce_original_email')) {
                add_option('ee_config_woocommerce_original_email', $wooCommerce_email_original_email);
            }

            update_option('woocommerce_email_from_address', $this->set_sender_email());
        } else {
            if (get_option('ee_config_woocommerce_original_email')) {
                update_option('woocommerce_email_from_address', get_option('ee_config_woocommerce_original_email'));
                delete_option('ee_config_woocommerce_original_email');
            }
        }
    }

    /** function that based on override option and setted FROM name input adds filter for wp_mail_from_name to override wooCommerce settings */
    public function WooCommerce_name()
    {
        if (get_option('ee_config_override_wooCommerce') && !empty(get_option('ee_config_from_name'))) {
            $wooCommerce_email_original_name = get_option('woocommerce_email_from_name');
            if (!get_option('ee_config_woocommerce_original_name')) {
                add_option('ee_config_woocommerce_original_name', $wooCommerce_email_original_name);
            }
            update_option('woocommerce_email_from_name', $this->set_sender_name());
        } else {
            if (get_option('ee_config_woocommerce_original_name')) {
                update_option('woocommerce_email_from_name', get_option('ee_config_woocommerce_original_name'));
                delete_option('ee_config_woocommerce_original_name');
            }
        }
    }
}