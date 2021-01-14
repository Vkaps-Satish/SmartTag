<?php

$show_notice_5stars = false;

if (!get_option('login-form-stopNotice5Stars')) {
    $first_time = get_option('login-form-first_time');
    if (!$first_time) {
        $first_time = time();
        update_option('login-form-first_time', $first_time);
    }
    $show_notice_5stars = ($first_time && $first_time < time() - 3 * 24 * 60 * 60);
}




if (!$show_notice_5stars) {
    return;
}


?>

<div class="stars-content">
    <div class="stars-right">
        <a class="stars-remover" href="javascript:void(0)" onclick="lf_stopNotice5Stars()">[ <?php _e('Hide this message', 'login-form'); ?> ]</a>
    </div>

    <div class="stars-left" onclick="window.open('https://wordpress.org/support/view/plugin-reviews/login-form?filter=5#postform')">
        <?php _e('Leave us 5 stars', 'login-form'); ?>
        <button type="button" class="button-stars button button-default">
            <span class="glyphicon glyphicon-star" aria-hidden="true"></span>
            <span class="glyphicon glyphicon-star" aria-hidden="true"></span>
            <span class="glyphicon glyphicon-star" aria-hidden="true"></span>
            <span class="glyphicon glyphicon-star" aria-hidden="true"></span>
            <span class="glyphicon glyphicon-star" aria-hidden="true"></span>
        </button>
        <small>&nbsp;&nbsp;<?php _e('It will help us develop this plugin for you', 'login-form'); ?></small>
    </div>
</div>
