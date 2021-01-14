<?php
defined('EE_ADMIN') or die('No direct access allowed.');

wp_enqueue_script('eesender-jquery');
wp_enqueue_style('eesender-bootstrap-grid');
wp_enqueue_style('eesender-css');
wp_enqueue_script('eesender-send-test');

if (isset($_GET['settings-updated'])):
    ?>
    <div id="message" class="updated">
        <p><strong><?php _e('Settings saved.', 'elastic-email-sender') ?></strong></p>
    </div>
<?php endif; ?>
<div id="eewp_plugin" class="row eewp_container" style="margin-right: 0px; margin-left: 0px;">
    <div class="col-12 col-md-12 col-lg-7">
        <?php if (get_option('ees-connecting-status') === 'disconnected') {
            include 't-ees_connecterror.php';
        } else { ?>
            <div class="ee_header">
                <div class="ee_pagetitle">
                    <h1><?php _e('Send test', 'elastic-email-sender') ?></h1>
                </div>
            </div>

            <div class="ee_send-test-container">

                <p class="ee_p test-description"><?php _e('Sending this testing email will provide You with the necessary information about the ability to send emails from your account as well as email and contact status. The email provided by You will be added to your All Contacts list, then the testing message will be send to this contact. Be aware that if you are charged by number of email sent, sending this testing messages will have impact on your credits.', 'elstic-email-sender') ?></p>

                <div class="form-group">
                    <input type="text" class="form-control" id="name" placeholder="Enter name">
                </div>
                <div class="form-group">
                    <input type="email" class="form-control" id="emailAddress" placeholder="Enter email">
                    <p class="error-email test-error" id="invalid_email"></p>
                </div>
                <div class="form-group">
                    <textarea class="form-control" id="textArea" rows="3" placeholder="Enter content"></textarea>
                </div>

                <div class="form-group test-button-box">
                    <button id="sendTest" class="ee_button-test">Submit</button>
                </div>

            </div>
            <div class="ee_send-test-info">
                <p class="ee_p" id="send-test-log"></p>
                <p class="ee_p" id="test-status-error-msg"></p>
                <p class="ee_p" id="test-status"></p>
                <p class="ee_p" id="contact-test-status"></p>
                <div id="loader" class="loader hide"></div>
            </div>

        <?php } ?>
    </div>

    <?php
    include 't-ees_marketing.php';
    ?>

</div>