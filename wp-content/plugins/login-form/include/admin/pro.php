<?php if (!WPA_LOGIN_PRO) { ?>
    <div class="login-form-pro-buy" style="float: right">
        <div class="login-form-pro-description">
            <div class="login-form-pro-description-title" style="min-width: 440px">
                <?php _e('Use Professional version of "Login Form" plugin and get: ', 'login-form')?>
            </div>
            <div class="form-get-pro">
                <form id="login_form_pro" name="login_form_pro" method="post" action="<?php echo WPA_SERVER_URL?>api/">
                    <input type="hidden" name="site" value="<?php echo home_url(); ?>">
                    <input type="hidden" name="actApi" value="<?php echo 'proBackupPay'?>">
                    <input type="hidden" name="email" value="<?php echo get_option('admin_email'); ?>">
                    <input type="hidden" name="plugin" value="<?php echo 'login-form'?>">
                    <input type="hidden" name="success_url" value="<?php echo admin_url("admin.php?page=main-setting&pay=success"); ?>">
                    <input type="hidden" name="cancel_url" value="<?php echo admin_url("admin.php?page=main-setting&pay=cancel"); ?>">
                    <input class="button-buy" type="submit" value="<?php _e('Get PRO', 'login-form')?>">
                </form>
            </div>

            <div style="float:left;">
                <ul class="login-form-pro-list">
                    <li>
                        <img src="<?php echo WPA_LOGIN_DIR_URL . 'img/ok.png';?>" alt="">
                        <span class=""><?php _e('More Design plugin settings', 'login-form');?></span>
                        <div class="clear"></div>
                    </li>
                    <li>
                        <img src="<?php echo WPA_LOGIN_DIR_URL . 'img/ok.png';?>" alt="">
                        <span class=""><?php _e('More Security settings (IP blocking, Captcha, etc.)', 'login-form');?></span>
                        <div class="clear"></div>
                    </li>
                    <li>
                        <img src="<?php echo WPA_LOGIN_DIR_URL . 'img/ok.png';?>" alt="">
                        <span class=""><?php _e('Priority support for PRO version', 'login-form');?></span>
                        <div class="clear"></div>
                    </li>
                    <li>
                        <img src="<?php echo WPA_LOGIN_DIR_URL . 'img/ok.png';?>" alt="">
                        <span class=""><?php _e('One year free updates', 'login-form');?></span>
                        <div class="clear"></div>
                    </li>
                </ul>
            </div>
        </div>

        <div class="clear"></div>
    </div>
<?php } ?>


    

    