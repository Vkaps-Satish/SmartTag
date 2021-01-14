<?php
    wp_register_style( 'horizontal-form', WPA_LOGIN_DIR_URL . "css/horizontal-form.css" );
    wp_enqueue_style( 'horizontal-form' );
?>


<div class="form_style horizontal-form" >		
    <?php
        //        if($logo_image){
        print '<img src="'.$logo_image.'" id="lf_logo"><br clear="all" '.(!$logo_image?'style="display: none;"':'').'>';
        //        }
    ?>

    <form class="form" id="wpadm-login-form" method="post" action="<?php print get_permalink(); ?>" id="loginform">
        <div style="display: inline" class="block-input" id="lf_form_username_cont">
            <input id="id_username_login_form" class="input_style" value="" type="text" name="log" placeholder="<?php echo esc_attr( $userlogin ); ?>">
        </div>

        <div style="display: inline" class="block-input" id="lf_form_password_cont">
            <input id="id_password_login_form" class="input_style password-input"  type="password" name="pwd" placeholder="<?php echo esc_attr( $userpassword ); ?>">
        </div>

        <?php if (WPA_LOGIN_PRO) {
                login_form_pro::getHTMLCaptcha($demo);
        }?>
        <div class="forgetmenot" id="lf_form_remember_cont">
            <input type="hidden" name="action" value="<?php echo esc_attr( $action_value );?>" id="lf_form_remember_cont">
            <label><input type="checkbox" name="rememberme" value="forever"><?php echo __( 'Remember?', 'login-form' ); ?></label>
        </div>
        <div class="block-input">
            <input id="id_button_login_form"  class="button button-primary button-large submit_style" type="submit" value="<?php echo esc_attr( $button ); ?>" name="submit">
        </div>

        
    </form>

    <style>
      
      
        <?php print $style; ?>
    </style>
    <div class="clear"></div>
</div>
