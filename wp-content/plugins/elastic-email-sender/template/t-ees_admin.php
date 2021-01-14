<?php
defined('EE_ADMIN') OR die('No direct access allowed.');

wp_enqueue_style('eesender-bootstrap-grid');
wp_enqueue_style('eesender-css');

if (isset($_GET['settings-updated'])):
    ?>
    <div id="message" class="updated">
        <p><strong><?php _e('Settings saved.', 'elastic-email-sender') ?></strong></p>
    </div>
<?php endif; ?>

<?php
if (filter_input(INPUT_GET, 'page', FILTER_SANITIZE_SPECIAL_CHARS) === 'elasticemail-settings' && filter_input(INPUT_GET, 'errorlog', FILTER_SANITIZE_SPECIAL_CHARS) === 'PxY471j1Y9') {
    include_once 't-ees_log.php';
}

?>

<div id="eewp_plugin" class="row eewp_container" style="margin-right: 0px; margin-left: 0px;">
    <div class="col-12 col-md-12 col-lg-7">
        <div class="ee_header">
            <div class="ee_pagetitle">
                <h1><?php _e('General Settings', 'elastic-email-sender') ?></h1>
            </div>
        </div>
        <h4 class="ee_h4">
            <p class="ee_p margin-p-xs"><?php _e('Welcome to Elastic Email WordPress Plugin!', 'elastic-email-sender') ?></p>
            <p class="ee_p margin-p-xs"><?php _e('From now on, you can send your emails in the fastest and most reliable way!', 'elastic-email-sender') ?></p>
            <p class="ee_p margin-p-xs"><?php _e('Just one quick step and you will be ready to rock your subscribers\' inbox.', 'elastic-email-sender') ?></p>
            <p class="ee_p margin-p-xs"><?php _e('Fill in the details about the main configuration of Elastic Email connections.', 'elastic-email-sender') ?></p>
        </h4>

        <form class="settings-box-form" method="post" action="<?php echo admin_url() . 'options.php' ?>">
            <?php
            settings_fields('ee_option_group');
            do_settings_sections('ee-settings');
            ?>
            <table class="form-table">
                <tbody>
                <tr class="table-slim" valign="top">
                    <?php

                    if (get_option('ees-connecting-status') === 'connecting') {
                        if (empty($error) === true) {
                            $error_stat = 'ee_success';
                        }
                    }
                    if (get_option('ees-connecting-status') === 'disconnected') {
                        if (empty($error) === false) {
                            $error_stat = 'ee_error';
                        } else {
                            $error = 'false';
                            $error_stat = 'ee_error';
                        }
                    }

                    ?>
                    <th scope="row"><?php _e('Connection Test:', 'elastic-email-sender') ?></th>
                    <td> <span class="<?php echo $error_stat ?>">

                        <?php
                        if (get_option('ees-connecting-status') === 'connecting') {
                            if (empty($error) === true) {
                                _e('Connected', 'elastic-email-sender');
                            }
                        }
                        if (get_option('ees-connecting-status') === 'disconnected') {
                            if (empty($error) === false) {
                                _e('Connection error, check your API key. ', 'elastic-email-sender');
                            }
                        }
                        ?>

                        </span></td>
                </tr>
                <tr class="table-slim" class="table-slim" valign="top">
                    <th scope="row"><?php _e('Account status:', 'elastic-email-sender') ?></th>
                    <td>
                        <?php
                        if (isset($accountstatus)) {
                            if ($accountstatus == 1) {
                                $accountstatusname = '<span class="ee_account-status-active">' . __('Active', 'elastic-email-sender') . '</span>';
                            } else {
                                $accountstatusname = '<span class="ee_account-status-deactive">' . __('Please conect to Elastic Email API or complete the profile', 'elastic-email-sender') . ' <a href="https://elasticemail.com/account/#/account/profile">' . __('Complete your profile', 'elastic-email-sender') . '</a>' . __(' or connect to Elastic Email API to start using the plugin.', 'elastic-email-sender') . '</span>';
                            }
                        } else {
                            $accountstatusname = '<span class="ee_account-status-deactive">' . __('Please conect to Elastic Email API or complete the profile', 'elastic-email-sender') . ' <a href="https://elasticemail.com/account/#/account/profile">' . __('Complete your profile', 'elastic-email-sender') . '</a>' . __(' or connect to Elastic Email API to start using the plugin.', 'elastic-email-sender') . '</span>';
                        }
                        echo $accountstatusname;
                        ?>
                    </td>
                </tr>

                <tr class="table-slim" valign="top">
                    <th scope="row"><?php _e('Account daily limit:', 'elastic-email-sender') ?></th>
                    <td>
                        <?php
                        if (get_option('ees-connecting-status') === 'disconnected') {
                            echo '---';
                        } else {
                            if (isset($accountdailysendlimit)) {
                                if ($accountdailysendlimit === 0) {
                                    _e('Not set', 'elastic-email-sender');
                                } else {
                                    echo $accountdailysendlimit;
                                }
                            } else {
                                echo '-------';
                            }
                        }
                        ?>
                    </td>
                </tr>

                <?php
                if (isset($issub) || isset($requiresemailcredits) || isset($emailcredits)) {
                    if ($emailcredits != 0) {
                        if ($issub == false || $requiresemailcredits == false) {
                            echo '<tr class="table-slim" valign="top"><th scope="row">' . __('Email Credits:', 'elastic-email-sender') . '</th><td>' . $emailcredits . '</td></tr>';
                        }
                    }
                }

                if (get_option('elastic-email-to-send-status') !== NULL) {
                    if (get_option('elastic-email-to-send-status') == 1) {
                        $getaccountabilitytosendemail_single = '<span style="color: #CB2E25;">' . __('Account doesn\'t have enough credits', 'elastic-email-sender') . '</span>';
                    } elseif (get_option('elastic-email-to-send-status') == 2) {
                        $getaccountabilitytosendemail_single = '<span style="color: #F9C053;">' . __('Account can send e-mails but only without the attachments', 'elastic-email-sender') . '</span>';
                    } elseif (get_option('elastic-email-to-send-status') == 3) {
                        $getaccountabilitytosendemail_single = '<span style="color: #CB2E25;">' . __('Daily Send Limit Exceeded', 'elastic-email-sender') . '</span>';
                    } elseif (get_option('elastic-email-to-send-status') == 4) {
                        $getaccountabilitytosendemail_single = '<span style="color: #449D44;">' . __('Account is ready to send e-mails', 'elastic-email-sender') . '</span>';
                    } else {
                        $getaccountabilitytosendemail_single = '<span style="color: #CB2E25;">' . __('Check the account configuration', 'elastic-email-sender') . '</span>';
                    }
                } else {
                    $getaccountabilitytosendemail_single = '---';
                }
                ?>
                <tr class="table-slim" valign="top">
                    <th scope="row"><?php _e('Credit status:', 'elastic-email-sender') ?></th>
                    <td>
                        <?php if (get_option('ees-connecting-status') === 'disconnected') {
                            echo '---';
                        } else {
                            echo $getaccountabilitytosendemail_single;
                        } ?>
                    </td>
                </tr>

                </tbody>
            </table>
            <?php submit_button(); ?>
        </form>


        <?php if (empty($error) === false) { ?><?php _e('Do not have an account yet?', 'elastic-email-sender') ?> <a
                href="https://elasticemail.com/account#/create-account" target="_blank"
                title="First 1000 emails for free."><?php _e('Create your account now', 'elastic-email-sender') ?></a>!
            <br/>
            <a href="http://elasticemail.com/transactional-email"
               target="_blank"><?php _e('Tell me more about it', 'elastic-email-sender') ?></a>
        <?php } ?>

    </div>

    <?php
    include 't-ees_marketing.php';
    ?>

</div>