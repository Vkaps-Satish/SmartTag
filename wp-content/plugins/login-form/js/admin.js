jQuery( document ).ready(function($) {
    $('#lf-s-content .menu a').click(function() {
        $ = jQuery;
        $('#lf-s-content .tab').hide();
        var tab = $(this).attr('data-tab');
        $('#lf-s-content .' + tab).show();
        $('#lf-s-content a').removeClass('active');
        $(this).addClass('active');
    });


    var lf_settings_form_preview_init_top = jQuery('#lf-settings-form-preview').position().top;

    function lf_fixPrevireDiv() {
        var $cache = $('#lf-settings-form-preview');
        if ($cache.closest( "td" ).css('display') == 'block') {
            $cache.css({
                'padding-top' : '0px'
            });
            return;
        }
        if ($(window).scrollTop() > lf_settings_form_preview_init_top) {
            var pos = $(window).scrollTop();
            if (pos > login_form_parameters.width) {
                pos = login_form_parameters.width;
            }
            $cache.css({
                //'position': 'fixed',
                'padding-top': pos - lf_settings_form_preview_init_top + 10 + 'px'
            });
        } else {
            $cache.css({
                //'position': 'relative',
                //'top': 'auto'
                'padding-top': '0px'
            });
        }
    }
    $(window).scroll(lf_fixPrevireDiv);
    lf_fixPrevireDiv();

});

function lf_stopNotice5Stars() {
    jQuery('.stars-content').hide( "slow" );
    var data = {
        'action': 'lf_stopNotice5Stars',
        'stop': 1
    }
    jQuery.post(ajaxurl, data, function (response) {
    });
}


function changeOrientationPreview(or) {
    if (or == 'vertical') {
        jQuery('#lf_form_cont').css('width', '350px');
        jQuery('.form_style').removeClass('horisontal_form');
        jQuery('#lf_form_username_cont').css('display', 'block');

        jQuery('#lf_form_password_cont').addClass('password-input-box');
        jQuery('#lf_form_password_cont').css('display', 'block');
        jQuery('#lf_form_remember_cont').addClass('forgetmenot');

        jQuery('.form_style input').css('margin', '10px 5px');

        jQuery('#lf_form_remember_cont').css('width', '296px');
        jQuery('#lf_form_remember_cont').css('text-align', 'center');

    } else {
        jQuery('#lf_form_cont').css('width', '520px')
        jQuery('.form_style').addClass('horisontal_form')
        jQuery('#lf_form_username_cont').css('display', 'inline');
        jQuery('#lf_form_password_cont').removeClass('password-input-box');
        jQuery('#lf_form_password_cont').css('display', 'inline');
        jQuery('#lf_form_remember_cont').removeClass('forgetmenot');


        jQuery('.form_style input').css('margin', '2px');
        jQuery('.form_style input').css('margin-top', '5px');
        //jQuery('.form_style .button').css('margin-top', '10px');
        jQuery('.form_style input').css('padding', '3px 5px 3px 5px');
        jQuery('#lf_form_remember_cont').css('width', '455px');
        jQuery('#lf_form_remember_cont').css('text-align', 'right');
    }
}

function lf_supportFormNormalize() {
    if (jQuery('#lf_support_text_container')[0].style.display == 'none') {
        jQuery('#lf_support_text').val('');
    }
    jQuery('#lf_support_text_container').show();
    jQuery('#lf-support_send_button').show();
    jQuery('#lf_support_thank_container').hide();
    jQuery('#lf_support_error_container').hide();
}

function lf_sendSupportText() {

    if(jQuery('#lf_support_text').val().trim() == '') {
        return;
    }

    var data = {
        'action': 'lf_sendSupport',

        'message': jQuery('#lf_support_text').val()
    }

    jQuery.post(ajaxurl, data, function (response) {
        try {
            var res = jQuery.parseJSON(response);
            if (res) {
                jQuery('#lf_support_text_container').hide();
                jQuery('#lf-support_send_button').hide();
                if(res.status=='success') {
                    jQuery('#lf_support_thank_container').show();
                } else if(res.status=='error') {
                    jQuery('#lf_support_error_container').show();
                }
            } else {
                jQuery('.tb-close-icon').click();
            }
        } catch (e) {
            jQuery('.tb-close-icon').click();
        }
    });
}