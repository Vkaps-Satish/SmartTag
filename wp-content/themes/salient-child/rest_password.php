
<?php
/*
Template Name: Custom WordPress Password Reset
*/
/*https://code.tutsplus.com/tutorials/build-a-custom-wordpress-user-flow-part-3-password-reset--cms-23811*/
global $wpdb, $user_ID; ?>
<script
  src="https://code.jquery.com/jquery-3.4.0.js"
  integrity="sha256-DYZMCC8HTC+QDr5QNaIcfR7VSPtcISykd+6eSmBW5qo="
  crossorigin="anonymous"></script>
<script type="text/javascript">
	 var ajaxurl = "<?php echo admin_url('admin-ajax.php'); ?>";
</script>
<?php 
	if($_GET['action']==='rp' && strpos($_SERVER['REQUEST_URI'],'wp-login.php')) {
	    $key = isset( $_GET['key'] ) ? $_GET['key'] : '';
	    $login = isset( $_GET['login'] ) ? $_GET['login'] : '';
	    wp_redirect( site_url( '/reset-password/' ) . '?key=' . $key . '&login=' . $login );
	    exit;
	}
?>
<div id="content" class="content-area" role="main">
    <div class="forms-wrapper">
        <div class="form-reset-password-wrapper">
            <h1>Reset your password</h1>
            <form id="form-reset-password" name="resetpassform" class="form-reset-password" action="https://prelaunch.idtag.com/wp-login.php?action=resetpass" method="post" autocomplete="off">
                <input type="hidden" id="user_login" value="<?php echo $_GET['login']; ?>" autocomplete="off">
                <p class="form-row">
                    <label for="user_pass">New password
                    <input type="password" name="user_pass" id="user_pass">
                </p>
                <p class="form-row">
                    <label for="user_pass_confirm">Confirm new password
                    <input type="password" name="user_pass_confirm" id="user_pass_confirm">
                </p>
                <p class="reset-password-submit">
                    <input type="submit" id="reset-password-btn" class="reset-password-btn" value="Submit"/>
                </p>
                <div class="form-reset-password-errors"></div>
            </form>
        </div>
    </div>
</div>
