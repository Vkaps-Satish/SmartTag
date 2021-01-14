<?php
$current_user = wp_get_current_user();
?>

<?php echo __( 'Hello', 'login-form' ); ?>, <?php print $current_user->user_login  ?>