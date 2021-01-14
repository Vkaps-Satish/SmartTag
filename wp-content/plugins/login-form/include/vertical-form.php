<?php
    wp_register_style( 'horizontal-form', WPA_LOGIN_DIR_URL . "css/horizontal-form.css" );
    wp_enqueue_style( 'horizontal-form' );
?>


<div class="form_style" >
    <?php
        //        if($logo_image){
        print '<img src="'.$logo_image.'" id="lf_logo"><br clear="all" '.(!$logo_image?'style="display: none;"':'').'>';
        //        }
    ?>

    <form class="form " id="wpadm-login-form" method="post" action="<?php print get_permalink(); ?>" id="loginform">
        <div class="block-input" id="lf_form_username_cont">
            <input id="id_username_login_form" class="input_style" value=""  type="text" name="log" placeholder="<?php echo esc_attr( $userlogin ); ?>">
        </div>

        <div class="block-input password-input-box" id="lf_form_password_cont">
            <input class="input_style  password-input" id="id_password_login_form"  type="password" name="pwd" placeholder="<?php echo esc_attr( $userpassword ); ?>">
        </div>

        <?php if (WPA_LOGIN_PRO) {
                login_form_pro::getHTMLCaptcha(true);
        }?>
        
        <div class="" id="lf_form_remember_cont">
            <input type="hidden" name="action" value="<?php echo esc_attr( $action_value );?>">
            <input type="checkbox" name="rememberme" value="forever">
            <label><?php echo __( 'Remember?', 'login-form' ); ?></label>
        </div>
        <div class="block-input">
            <input id="id_button_login_form" class="button button-primary button-large submit_style" type="submit" value="<?php echo esc_attr( $button ); ?>" name="submit">
        </div>
    </form>

    <style>
        .form_style input {
            margin: 10px 5px ;
        }
        .form_style .input_style, .form_style .submit_style { 

        }

        <?php print $style; ?>
    </style>
    </div>
    