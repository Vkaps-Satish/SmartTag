<!doctype html>
<html <?php language_attributes(); ?> class="no-js">
<head>
	
<meta name="google-site-verification" content="2-MIjE5yGD9w9CAyAqvtb6FL2MS2uP3tV10c1FGDOwc" />
<!-- Meta Tags -->
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

<?php $options = get_nectar_theme_options(); ?>

<?php if(!empty($options['responsive']) && $options['responsive'] == 1) { ?>
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0" />

<?php } else { ?>
	<meta name="viewport" content="width=1200" />
<?php } ?>	

<!--Shortcut icon-->
<?php if(!empty($options['favicon']) && !empty($options['favicon']['url'])) { ?>
	<link rel="shortcut icon" href="<?php echo nectar_options_img($options['favicon']); ?>" />
<?php } ?>

<?php wp_head(); 
	$addressStates = WC()->countries->get_states();
	$addressStates = json_encode($addressStates);
	$addressStates = str_replace("'","/'",$addressStates);
	// echo $addressStates;
	// echo $addressStates;
?>

<?php if(!empty($options['google-analytics'])) echo $options['google-analytics']; ?> 
<script type="text/javascript">
    var ajaxurl 			= "<?php echo admin_url('admin-ajax.php'); ?>";
    window.addressStates 	= <?php echo $addressStates; ?>;
    // window.addressStates    = window.addressStates.replace("'", "\'");
    // console.log(addressStates);
</script>
<script src='https://www.google.com/recaptcha/api.js'></script>
<!-- add menu into the pet professionals before -->


<!-- jQuery Modal -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.css" />

<script type="text/javascript" src="//maps.googleapis.com/maps/api/js?key=AIzaSyASoU2Q1q0yX4fwyPiZCaipyA78NCbz6rA"></script>
</head>
<!-- <style>.loader{
	display: none;
}</style> -->
<?php
 global $post; 
 global $woocommerce; 

//check if parallax nectar slider is being used
$parallax_nectar_slider = using_nectar_slider();
$force_effect = get_post_meta($post->ID, '_force_transparent_header', true);

$headerFormat = (!empty($options['header_format'])) ? $options['header_format'] : 'default';

// header transparent option
$transparency_markup = null;
$activate_transparency = null;

$using_page_header = using_page_header($post->ID);
$using_fw_slider = $parallax_nectar_slider;
$using_fw_slider = (!empty($options['transparent-header']) && $options['transparent-header'] == '1') ? $using_fw_slider : 0;
if($force_effect == 'on') $using_fw_slider = '1';
$disable_effect = get_post_meta($post->ID, '_disable_transparent_header', true);

$theme_skin = ( !empty($options['theme-skin']) ) ? $options['theme-skin'] : 'original';

if(!empty($options['transparent-header']) && $options['transparent-header'] == '1' && $headerFormat != 'left-header') {
	
	$starting_color = (empty($options['header-starting-color'])) ? '#ffffff' : $options['header-starting-color'];
	$activate_transparency = $using_page_header;
	$remove_border = (!empty($options['header-remove-border']) && $options['header-remove-border'] == '1' || $theme_skin == 'material') ? 'true' : 'false';
	$transparency_markup = ($activate_transparency == 'true') ? 'data-transparent-header="true" data-remove-border="'.$remove_border.'" class="transparent"' : null ;
}

//header vars
$logo_class = (!empty($options['use-logo']) && $options['use-logo'] == '1') ? null : 'class="no-image"'; 
$sideWidgetArea = (!empty($options['header-slide-out-widget-area']) && $headerFormat != 'left-header' ) ? $options['header-slide-out-widget-area'] : 'off';
$sideWidgetClass = (!empty($options['header-slide-out-widget-area-style'])) ? $options['header-slide-out-widget-area-style'] : 'slide-out-from-right';
$sideWidgetIconAnimation = 'simple-transform';
if($sideWidgetClass == 'slide-out-from-right-hover') $sideWidgetIconAnimation = 'simple-transform';
$fullWidthHeader = (!empty($options['header-fullwidth']) && $options['header-fullwidth'] == '1') ? 'true' : 'false';
$headerSearch = (!empty($options['header-disable-search']) && $options['header-disable-search'] == '1') ? 'false' : 'true';
$mobile_fixed = (!empty($options['header-mobile-fixed'])) ? $options['header-mobile-fixed'] : 'false';
$mobile_breakpoint = (!empty($options['header-menu-mobile-breakpoint'])) ? $options['header-menu-mobile-breakpoint'] : 1000; 
$fullWidthHeader = (!empty($options['header-fullwidth']) && $options['header-fullwidth'] == '1') ? 'true' : 'false';
$headerColorScheme = (!empty($options['header-color'])) ? $options['header-color'] : 'light';
$userSetBG = (!empty($options['header-background-color']) && $headerColorScheme == 'custom') ? $options['header-background-color'] : '#ffffff';
$trans_header = (!empty($options['transparent-header']) && $options['transparent-header'] == '1') ? $options['transparent-header'] : 'false';
if($headerFormat == 'left-header') $trans_header = 'false';
$bg_header = (!empty($post->ID) && $post->ID != 0) ? $using_page_header : 0;
$bg_header = ($bg_header == 1) ? 'true' : 'false'; //convert to string for references in css
$header_box_shadow = (!empty($options['header-box-shadow'])) ? $options['header-box-shadow'] : 'small';
$perm_trans = (!empty($options['header-permanent-transparent']) && $trans_header != 'false' && $bg_header == 'true') ? $options['header-permanent-transparent'] : 'false'; 
$headerLinkHoverEffect = (!empty($options['header-hover-effect'])) ? $options['header-hover-effect'] : 'default';
$headerRemoveStickiness = (!empty($options['header-remove-fixed'])) ? $options['header-remove-fixed'] : '0'; 
$hideHeaderUntilNeeded = (!empty($options['header-hide-until-needed'])) ? $options['header-hide-until-needed'] : '0';
if($headerFormat == 'left-header') { $hideHeaderUntilNeeded = '0'; $headerRemoveStickiness = '0'; }
if($headerRemoveStickiness == '1') $hideHeaderUntilNeeded = '1';
$headerResize = (!empty($options['header-resize-on-scroll']) && $perm_trans != '1') ? $options['header-resize-on-scroll'] : '0'; 
$dropdownStyle = (!empty($options['header-dropdown-style']) && $perm_trans != '1' && $headerFormat != 'left-header' ) ? $options['header-dropdown-style'] : 'classic';
$page_transition_effect = (!empty($options['transition-effect'])) ? $options['transition-effect'] : 'standard';
$megamenuwidth = (!empty($options['header-megamenu-width']) && $headerFormat != 'left-header') ? $options['header-megamenu-width'] : 'contained';
$megamenuRemoveTransparent = (!empty($options['header-megamenu-remove-transparent']) && $headerFormat != 'left-header') ? $options['header-megamenu-remove-transparent'] : '0'; 
$body_border = (!empty($options['body-border'])) ? $options['body-border'] : 'off';
if($hideHeaderUntilNeeded == '1' || $body_border == '1' || $headerFormat == 'left-header' || $headerRemoveStickiness == '1') $headerResize = '0';
$lightbox_script = (!empty($options['lightbox_script'])) ? $options['lightbox_script'] : 'pretty_photo';
if($lightbox_script == 'pretty_photo') { $lightbox_script = 'magnific'; }
$button_styling = (!empty($options['button-styling'])) ? $options['button-styling'] : 'default'; 
$form_style = (!empty($options['form-style'])) ? $options['form-style'] : 'default'; 
$fancy_rcs = (!empty($options['form-fancy-select'])) ? $options['form-fancy-select'] : 'default';
$footer_reveal = (!empty($options['footer-reveal'])) ? $options['footer-reveal'] : 'false'; 
$footer_reveal_shadow = (!empty($options['footer-reveal-shadow']) && $footer_reveal == '1') ? $options['footer-reveal-shadow'] : 'none'; 
$icon_style = (!empty($options['theme-icon-style'])) ? $options['theme-icon-style'] : 'inherit';
$has_main_menu = (has_nav_menu('top_nav')) ? 'true' : 'false';
$animate_in_effect = (!empty($options['header-animate-in-effect'])) ? $options['header-animate-in-effect'] : 'none';
if($headerColorScheme == 'dark') { $userSetBG = '#1f1f1f'; } 	
$userSetSideWidgetArea = $sideWidgetArea;
if($has_main_menu == 'true' && $mobile_fixed == '1' || $has_main_menu == 'true' && $theme_skin == 'material') $sideWidgetArea = '1';
if($headerFormat == 'centered-menu-under-logo') { 
	if($sideWidgetClass == 'slide-out-from-right-hover' && $userSetSideWidgetArea == '1') {
		$sideWidgetClass = 'slide-out-from-right';
	}
	$fullWidthHeader = 'false';
}
if($sideWidgetClass == 'slide-out-from-right-hover' && $userSetSideWidgetArea == '1') $fullWidthHeader = 'true';
$column_animation_easing = (!empty($options['column_animation_easing'])) ? $options['column_animation_easing'] : 'linear'; 
$column_animation_duration = (!empty($options['column_animation_timing'])) ? $options['column_animation_timing'] : '650'; 
$prependTopNavMobile = (!empty($options['header-slide-out-widget-area-top-nav-in-mobile']) && $userSetSideWidgetArea == '1') ? $options['header-slide-out-widget-area-top-nav-in-mobile'] : 'false';
$smooth_scrolling = (!empty($options['smooth-scrolling'])) ? $options['smooth-scrolling'] : '0';
if($body_border == '1') $smooth_scrolling = '0';
$page_full_screen_rows = (isset($post->ID)) ? get_post_meta($post->ID, '_nectar_full_screen_rows', true) : '';
if($page_full_screen_rows == 'on') $smooth_scrolling = '0';
$form_submit_style = (!empty($options['form-submit-btn-style'])) ? $options['form-submit-btn-style'] : 'default';
$n_boxed_style = (!empty($options['boxed_layout']) && $options['boxed_layout'] == '1' && $headerFormat != 'left-header') ? true : false;

/*material skin defaults*/
if($theme_skin == 'material') {
	$icon_style = 'minimal';
}
if($theme_skin == 'material' && $headerFormat != 'left-header') {
	$dropdownStyle = 'minimal';
}

// $args  = array(
//     'meta_key' => 'source',
//     'meta_value' => 'api',
//     'meta_compare' => '=' // exact match only
// );
 
// $user_query = new WP_User_Query( $args );
// print_r($user_query);
?>

<body <?php body_class(); ?> data-footer-reveal="<?php echo $footer_reveal; ?>" data-header-format="<?php echo $headerFormat; ?>" data-boxed-style="<?php echo $n_boxed_style; ?>" data-header-breakpoint="<?php echo $mobile_breakpoint; ?>" data-footer-reveal-shadow="<?php echo $footer_reveal_shadow; ?>" data-dropdown-style="<?php echo $dropdownStyle;?>" data-cae="<?php echo $column_animation_easing; ?>" data-megamenu-width="<?php echo $megamenuwidth; ?>" data-cad="<?php echo $column_animation_duration; ?>" data-aie="<?php echo $animate_in_effect; ?>" data-ls="<?php echo $lightbox_script;?>" data-apte="<?php echo $page_transition_effect;?>" data-hhun="<?php echo $hideHeaderUntilNeeded; ?>" data-fancy-form-rcs="<?php echo $fancy_rcs; ?>" data-form-style="<?php echo $form_style; ?>" data-form-submit="<?php echo $form_submit_style; ?>" data-is="<?php echo $icon_style; ?>" data-button-style="<?php echo $button_styling; ?>" data-header-inherit-rc="<?php echo (!empty($options['header-inherit-row-color']) && $options['header-inherit-row-color'] == '1' && $perm_trans != 1) ? "true" : "false"; ?>" data-header-search="<?php echo $headerSearch; ?>" data-animated-anchors="<?php echo (!empty($options['one-page-scrolling']) && $options['one-page-scrolling'] == '1') ? 'true' : 'false'; ?>" data-ajax-transitions="<?php echo (!empty($options['ajax-page-loading']) && $options['ajax-page-loading'] == '1') ? 'true' : 'false'; ?>" data-full-width-header="<?php echo $fullWidthHeader; ?>" data-slide-out-widget-area="<?php echo ($sideWidgetArea == '1') ? 'true' : 'false';  ?>" data-slide-out-widget-area-style="<?php echo $sideWidgetClass; ?>" data-user-set-ocm="<?php echo $userSetSideWidgetArea; ?>" data-loading-animation="<?php echo (!empty($options['loading-image-animation'])) ? $options['loading-image-animation'] : 'none'; ?>" data-bg-header="<?php echo $bg_header; ?>" data-ext-responsive="<?php echo (!empty($options['responsive']) && $options['responsive'] == 1 && !empty($options['ext_responsive']) && $options['ext_responsive'] == '1') ? 'true' : 'false'; ?>" data-header-resize="<?php echo $headerResize; ?>" data-header-color="<?php echo (!empty($options['header-color'])) ? $options['header-color'] : 'light' ; ?>" <?php echo (!empty($options['transparent-header']) && $options['transparent-header'] == '1') ? null : 'data-transparent-header="false"'; ?> data-cart="<?php echo ($woocommerce && !empty($options['enable-cart']) && $options['enable-cart'] == '1') ? 'true': 'false';?>" data-smooth-scrolling="<?php echo $smooth_scrolling; ?>" data-permanent-transparent="<?php echo $perm_trans; ?>" data-responsive="<?php echo (!empty($options['responsive']) && $options['responsive'] == 1) ? '1'  : '0' ?>" >

<?php if($theme_skin == 'material') { echo '<div class="ocm-effect-wrap"><div class="ocm-effect-wrap-inner">'; } ?>

<?php if($n_boxed_style) { echo '<div id="boxed">'; } ?>

<?php $using_secondary = (!empty($options['header_layout']) && $headerFormat != 'left-header') ? $options['header_layout'] : ' '; 

if($using_secondary == 'header_with_secondary') { ?>

	<div id="header-secondary-outer" data-lhe="<?php echo $headerLinkHoverEffect; ?>" data-full-width="<?php echo (!empty($options['header-fullwidth']) && $options['header-fullwidth'] == '1') ? 'true' : 'false' ; ?>" data-permanent-transparent="<?php echo $perm_trans; ?>" >
		<div class="container">
			<nav>
				<?php if(!empty($options['enable_social_in_header']) && $options['enable_social_in_header'] == '1') nectar_header_social_icons('secondary-nav'); ?>
				
				<?php if(has_nav_menu('secondary_nav')) { ?>
					<ul class="sf-menu">	
				   	   <?php wp_nav_menu( array('walker' => new Nectar_Arrow_Walker_Nav_Menu, 'theme_location' => 'secondary_nav', 'container' => '', 'items_wrap' => '%3$s' ) ); ?>
				    </ul>
				<?php }	

				?>
				
			</nav>
		</div>
	</div>

<?php } 

$page_full_screen_rows = (isset($post->ID)) ? get_post_meta($post->ID, '_nectar_full_screen_rows', true) : '';
if($perm_trans != 1 || $perm_trans == 1 && $bg_header == 'false' || $page_full_screen_rows == 'on') { ?> <div id="header-space" data-header-mobile-fixed='<?php echo $mobile_fixed; ?>'></div> <?php } ?>

<?php 
	//using pr
	$using_pr_menu = 'false';
	if($headerFormat == 'menu-left-aligned' || $headerFormat == 'centered-menu') {
		if(has_nav_menu('top_nav_pull_right')) {
			$using_pr_menu = 'true';
		}
	}
?>
<div id="header-outer" data-has-menu="<?php echo $has_main_menu; ?>" <?php echo $transparency_markup; ?> data-using-pr-menu="<?php echo $using_pr_menu; ?>" data-mobile-fixed="<?php echo $mobile_fixed; ?>" data-ptnm="<?php echo $prependTopNavMobile;?>" data-lhe="<?php echo $headerLinkHoverEffect; ?>" data-user-set-bg="<?php echo $userSetBG; ?>" data-format="<?php echo $headerFormat; ?>" data-permanent-transparent="<?php echo $perm_trans; ?>" data-megamenu-rt="<?php echo $megamenuRemoveTransparent; ?>" data-remove-fixed="<?php echo $headerRemoveStickiness; ?>" data-cart="<?php echo ($woocommerce && !empty($options['enable-cart']) && $options['enable-cart'] == '1') ? 'true': 'false';?>" data-transparency-option="<?php if($disable_effect == 'on') { echo '0'; } else { echo $using_fw_slider; } ?>" data-box-shadow="<?php echo $header_box_shadow; ?>" data-shrink-num="<?php echo (!empty($options['header-resize-on-scroll-shrink-num'])) ? $options['header-resize-on-scroll-shrink-num'] : 6; ?>" data-full-width="<?php echo $fullWidthHeader; ?>" data-using-secondary="<?php echo ($using_secondary == 'header_with_secondary') ? '1' : '0'; ?>" data-using-logo="<?php if(!empty($options['use-logo'])) echo $options['use-logo']; ?>" data-logo-height="<?php if(!empty($options['logo-height'])) echo $options['logo-height']; ?>" data-m-logo-height="<?php if(!empty($options['mobile-logo-height'])) { echo $options['mobile-logo-height']; } else { echo '24'; } ?>" data-padding="<?php echo (!empty($options['header-padding'])) ? $options['header-padding'] : "0"; ?>" data-header-resize="<?php echo $headerResize; ?>">
	
	<?php if(empty($options['theme-skin'])) { 
		get_template_part('includes/header-search'); 
	} 
	elseif(!empty($options['theme-skin']) && $options['theme-skin'] != 'ascend' && $headerFormat != 'left-header')  {
		 get_template_part('includes/header-search');
	} ?>

	<header class="main-header">
		<div class="container">
			<div class="header-left">

				<a href="<?php echo home_url(); ?>" class="logo">
					<?php nectar_logo_output($activate_transparency, $sideWidgetClass); ?>
				</a>
			</div>
			<div class="header-right">
				<div class="header-log-sign">
					<?php if (is_user_logged_in()) {
						global $current_user;
                        $user = wp_get_current_user();
                        $url = get_site_url();
						$customer_id = $current_user->ID;
						$order = wc_get_customer_last_order( $customer_id );

						echo "<span><strong>Welcome! ".$current_user->user_login."</strong></span>";
						echo '<a href="'.wp_logout_url($url).'" class="header-login">Log Out</a>';
						echo '<br><a href="'.get_site_url().'/my-account/" class="header-login">My Account</a>';

						if (!empty($order)) {
							$order_id  = $order->get_id(); // Get the order ID	
							if ( in_array( 'pet_professional', (array) $user->roles ) && !empty($order_id) ) {
							    echo '<br><a href="javascript:void();" class="header-login ced_my_account_reorder" data-order_id="'.$order_id.'">Reorder <i class="fa fa-shopping-cart" aria-hidden="true"></i></a>';
							}
						}

					    
					}else{
						echo '<a href="'.get_site_url().'/login-to-smarttag/?login=1" class="header-login">Log In</a>
							<a href="'.get_site_url().'/login-to-smarttag/" class="header-signup">Sign Up</a>';
						//echo '<a href="'.get_site_url().'/login-to-smarttag/" class="header-login">Log In</a>
							// <a href="'.get_site_url().'/login-to-smarttag/" class="header-signup">Sign Up</a>';
					} 
					?>
				</div>
				<div class="header-cart-chat">
					<div class="header-cart">
						<!-- <?php
							if (!empty($options['enable-cart']) && $options['enable-cart'] == '1') { 
								if ($woocommerce) { ?>
									<a id="mobile-cart-link" href="<?php echo wc_get_cart_url(); ?>"><i class="icon-salient-cart"></i><div class="cart-wrap"><span><?php echo $woocommerce->cart->cart_contents_count; ?> </span></div></a>
								<?php } 
							} 
						?> -->
						<a id="mobile-cart-link" href="<?php echo wc_get_cart_url(); ?>">
							<i class="header-cart-icon"></i> Cart (<?php echo $woocommerce->cart->cart_contents_count; ?>)
						</a>
						<!-- <a href="#">
							<i class="header-cart-icon"></i> Cart (0)
						</a> -->
					</div>
					<div class="header-chat">
						<a href="#">
							<i class="header-chat-icon"></i> Live Chat
						</a>
					</div>
					<div class="header-report-btn">
						<a href="<?php echo get_site_url(); ?>/report-lost-and-found-pet/">Report Lost or Found Pet <i class="fa fa-caret-right"></i></a>
					</div>
				</div>
			</div>
		</div>
	</header>

	<nav class="main-nav">
		<div class="container">
			<div class="nav-toggle">
				<span></span>
				<span></span>
				<span></span>
			</div>
			<div class="nav-inner">
				<?php if($theme_skin == 'material') {?>
					<ul class="nav-main-ul">	
						<?php 
						if($has_main_menu == 'true') {
						    wp_nav_menu( array('walker' => new Nectar_Arrow_Walker_Nav_Menu, 'theme_location' => 'top_nav', 'container' => '', 'items_wrap' => '%3$s' ) ); 
						} else {
							echo '<li class="no-menu-assigned"><a href="#">No menu assigned</a></li>';
						}

						if(!empty($options['enable_social_in_header']) && $options['enable_social_in_header'] == '1' && $using_secondary != 'header_with_secondary' && $headerFormat != 'menu-left-aligned' && $headerFormat != 'centered-menu' && $headerFormat != 'left-header') {
							echo '<li id="social-in-menu" class="button_social_group">';
							nectar_header_social_icons('main-nav');
							echo '</li>';
						}
						?>
					</ul>
				<?php } //material skin ?>

				<?php if($theme_skin != 'material') { ?>
					<?php 
						
						// $menu =  wp_nav_menu( array('menu' => 'Main Navigation','menu_class' => 'menu-name','walker' => new subMenu));
							// print_r($menu);die;	
					?>
					<ul class="nav-main-ul 111">	
						<?php 
						if($has_main_menu == 'true') {
						wp_nav_menu( array('walker' => new Nectar_Arrow_Walker_Nav_Menu, 'theme_location' => 'top_nav', 'container' => '', 'items_wrap' => '%3$s' ) ); 
							
						} else {
							echo '<li class="no-menu-assigned"><a href="#">No menu assigned</a></li>';
						}

						if(!empty($options['enable_social_in_header']) && $options['enable_social_in_header'] == '1' && $using_secondary != 'header_with_secondary' && $headerFormat != 'menu-left-aligned' && $headerFormat != 'centered-menu' && $headerFormat != 'left-header') {
							echo '<li id="social-in-menu" class="button_social_group">';
							nectar_header_social_icons('main-nav');
							echo '</li>';
						}
						?>
					</ul>
				<?php } //non material skin ?>
			</div>
		</div>
	</nav>
	
	<header id="top" style="display: none !important;">
		
		<div class="container">
			
			<div class="row">
				  
				<div class="col span_3">
					
					<a id="logo" href="<?php echo home_url(); ?>" <?php echo $logo_class; ?>>

						<?php nectar_logo_output($activate_transparency, $sideWidgetClass); ?> 

					</a>

				</div><!--/span_3-->
				
				<div class="col span_9 col_last">
					<?php 
// 					echo "rohit1";
// 					$temp_message = get_transient( 'temporary_message' );
// 					print_r($temp_message);
// 					echo "rohit12";
// 						print_r($special_query_results);
// 					if ( false === ( $special_query_results = get_transient( '
// 						temporary_messages' ) ) ) {
// 						echo "baba";
// 							  // It wasn't there, so regenerate the data and save the transient
// 							  $special_query_results = new WP_Query( 'cat=5&order=random&tag=tech&post_meta_key=thumbnail' );
// 							  set_transient( 'temporary_message', $special_query_results );
// 							}else{
// 								echo "baba2";
// 							}
// die;

					?>
					<?php if($has_main_menu == 'true' && $mobile_fixed == 'false' && $prependTopNavMobile != '1' && $theme_skin != 'material') { ?>
						<div class="slide-out-widget-area-toggle mobile-icon std-menu <?php echo $sideWidgetClass; ?>" data-icon-animation="simple-transform">
							<div> <a id="toggle-nav" href="#sidewidgetarea" class="closed"> <span> <i class="lines-button x2"> <i class="lines"></i> </i> </span> </a> </div> 
       					</div>
					<?php }

					if($headerSearch != 'false' && $theme_skin == 'material') { ?>
						<a class="mobile-search" href="#searchbox"><span class="nectar-icon icon-salient-search" aria-hidden="true"></span></a>
					<?php } 
					
					if (!empty($options['enable-cart']) && $options['enable-cart'] == '1') { 
						if ($woocommerce) { ?> 
							<!--mobile cart link-->
							<a id="mobile-cart-link" href="<?php echo wc_get_cart_url(); ?>"><i class="icon-salient-cart"></i><div class="cart-wrap"><span><?php echo $woocommerce->cart->cart_contents_count; ?> </span></div></a>
						<?php } 
					} 

					
					if($sideWidgetArea == '1') { ?>
						<div class="slide-out-widget-area-toggle mobile-icon <?php echo $sideWidgetClass; ?>" data-icon-animation="simple-transform">
							<div> <a href="#sidewidgetarea" class="closed"> <span> <i class="lines-button x2"> <i class="lines"></i> </i> </span> </a> </div> 
       					</div>
					<?php } ?>
					
					<?php if($headerFormat == 'left-header') echo '<div class="nav-outer">'; ?>

					<nav>

						<?php if($theme_skin == 'material') { ?>
							<ul class="sf-menu">	
								<?php 
								if($has_main_menu == 'true') {
								    wp_nav_menu( array('walker' => new Nectar_Arrow_Walker_Nav_Menu, 'theme_location' => 'top_nav', 'container' => '', 'items_wrap' => '%3$s' ) ); 
								} else {
									echo '<li class="no-menu-assigned"><a href="#">No menu assigned</a></li>';
								}

								if(!empty($options['enable_social_in_header']) && $options['enable_social_in_header'] == '1' && $using_secondary != 'header_with_secondary' && $headerFormat != 'menu-left-aligned' && $headerFormat != 'centered-menu' && $headerFormat != 'left-header') {
									echo '<li id="social-in-menu" class="button_social_group">';
									nectar_header_social_icons('main-nav');
									echo '</li>';
								}
								?>
							</ul>
						<?php } //material skin ?>


						<?php if($headerFormat != 'menu-left-aligned') { ?>
							<ul class="buttons" data-user-set-ocm="<?php echo $userSetSideWidgetArea; ?>">

								<?php  

									if(!empty($options['enable_social_in_header']) && $options['enable_social_in_header'] == '1' && $using_secondary != 'header_with_secondary' && $headerFormat == 'centered-menu') {
										echo '<li id="social-in-menu" class="button_social_group">';
										nectar_header_social_icons('main-nav');
										echo '</li>';
									}

									//pull right
									if($headerFormat == 'centered-menu' && $using_pr_menu == 'true') {
										wp_nav_menu( array('walker' => new Nectar_Arrow_Walker_Nav_Menu, 'theme_location' => 'top_nav_pull_right', 'container' => '', 'items_wrap' => '%3$s' ) );  
									}
								?>

								<?php if($headerSearch != 'false') { ?>
									<li id="search-btn"><div><a href="#searchbox"><span class="icon-salient-search" aria-hidden="true"></span></a></div> </li>
								<?php } ?>


								<?php if (!empty($options['enable-cart']) && $options['enable-cart'] == '1' && $theme_skin == 'material') { 
										if ($woocommerce) { 
											echo '<li class="nectar-woo-cart">' . nectar_header_cart_output() .'</li>';
									 	}
								   } 


							 	if($sideWidgetArea == '1') { ?>
									<li class="slide-out-widget-area-toggle" data-icon-animation="<?php echo $sideWidgetIconAnimation; ?>">
										<div> <a href="#sidewidgetarea" class="closed"> <span> <i class="lines-button x2"> <i class="lines"></i> </i> </span> </a> </div> 
	       							</li>
								<?php } ?>
							</ul>
						<?php } ?>

						<?php if($theme_skin != 'material') { ?>
							<ul class="sf-menu">	
								<?php 
								if($has_main_menu == 'true') {
								    wp_nav_menu( array('walker' => new Nectar_Arrow_Walker_Nav_Menu, 'theme_location' => 'top_nav', 'container' => '', 'items_wrap' => '%3$s' ) ); 
								} else {
									echo '<li class="no-menu-assigned"><a href="#">No menu assigned</a></li>';
								}

								if(!empty($options['enable_social_in_header']) && $options['enable_social_in_header'] == '1' && $using_secondary != 'header_with_secondary' && $headerFormat != 'menu-left-aligned' && $headerFormat != 'centered-menu' && $headerFormat != 'left-header') {
									echo '<li id="social-in-menu" class="button_social_group">';
									nectar_header_social_icons('main-nav');
									echo '</li>';
								}
								?>
							</ul>
						<?php } //non material skin ?>
					</nav>

					<?php if($headerFormat == 'left-header') echo '</div>'; ?>

					<?php if($theme_skin == 'material' && $headerFormat == 'centered-menu' || $theme_skin == 'material' && $headerFormat == 'centered-logo-between-menu') { nectar_logo_spacing(); } ?>
					
				</div><!--/span_9-->

				<?php if($headerFormat == 'menu-left-aligned') { ?>
					<div class="right-aligned-menu-items">
						<nav>
							<ul class="buttons" data-user-set-ocm="<?php echo $userSetSideWidgetArea; ?>">

								<?php  
								if($using_pr_menu == 'true') {
									wp_nav_menu( array('walker' => new Nectar_Arrow_Walker_Nav_Menu, 'theme_location' => 'top_nav_pull_right', 'container' => '', 'items_wrap' => '%3$s' ) ); 
								} ?>

								<?php if($headerSearch != 'false') { ?>
									<li id="search-btn"><div><a href="#searchbox"><span class="icon-salient-search" aria-hidden="true"></span></a></div> </li>
								<?php } ?>

								<?php if (!empty($options['enable-cart']) && $options['enable-cart'] == '1' && $theme_skin == 'material') { 
										if ($woocommerce) { 
											echo '<li class="nectar-woo-cart">' . nectar_header_cart_output() .'</li>';
									 	}
								   } ?>

								<?php if($sideWidgetArea == '1') { ?>
									<li class="slide-out-widget-area-toggle" data-icon-animation="<?php echo $sideWidgetIconAnimation; ?>">
										<div> <a href="#sidewidgetarea" class="closed"> <span> <i class="lines-button x2"> <i class="lines"></i> </i> </span> </a> </div> 
	       							</li>
								<?php } ?>
							</ul>

							<?php 
								if(!empty($options['enable_social_in_header']) && $options['enable_social_in_header'] == '1' && $using_secondary != 'header_with_secondary') {
									echo '<ul><li id="social-in-menu" class="button_social_group">';
									nectar_header_social_icons('main-nav');
									echo '</li></ul>';
								}
							?>
						</nav>
					</div><!--/right-aligned-menu-items-->

				<?php } else if($headerFormat == 'left-header') {

					if(!empty($options['enable_social_in_header']) && $options['enable_social_in_header'] == '1' && $using_secondary != 'header_with_secondary') {
						echo '<div class="button_social_group"><ul><li id="social-in-menu">';
						nectar_header_social_icons('main-nav');
						echo '</li></ul></div>';
					}

				} ?>

			</div><!--/row-->
			
		</div><!--/container-->
		
	</header>
	
	
	<?php if (!empty($options['enable-cart']) && $options['enable-cart'] == '1' && $theme_skin != 'material') { ?>
		<?php
		if ($woocommerce) { 
			echo nectar_header_cart_output();
	 	}
   } 
   
   
   echo '<div class="ns-loading-cover"></div>';
   
   ?>		
	

</div><!--/header-outer-->

<?php //slide in cart style
	if (!empty($options['enable-cart']) && $options['enable-cart'] == '1') { 
		
		$nav_cart_style = (!empty($options['ajax-cart-style'])) ? $options['ajax-cart-style'] : 'default';

		if ($woocommerce && $nav_cart_style == 'slide_in') {
			echo '<div class="nectar-slide-in-cart">'; 
				// Check for WooCommerce 2.0 and display the cart widget
				if ( version_compare( WOOCOMMERCE_VERSION, "2.0.0" ) >= 0 ) {
					the_widget( 'WC_Widget_Cart', 'title= ' );
				} else {
					the_widget( 'WooCommerce_Widget_Cart', 'title= ' );
				}
			echo '</div>'; 
		}
	} 
?>

<?php if(!empty($options['theme-skin']) && $options['theme-skin'] == 'ascend' || $headerFormat == 'left-header' ) { if($headerSearch != 'false') get_template_part('includes/header-search'); } ?> 

<?php if($mobile_fixed != '1') { ?>

	<div id="mobile-menu" data-mobile-fixed="<?php echo $mobile_fixed; ?>">
		
		<div class="container">
			<ul>
				<?php 
					if($has_main_menu == 'true' && $mobile_fixed == 'false') {
						
					    wp_nav_menu( array('theme_location' => 'top_nav', 'menu' => 'Top Navigation Menu', 'container' => '', 'items_wrap' => '%3$s' ) ); 

					    if($headerFormat == 'centered-menu' && $using_pr_menu == 'true' || $headerFormat == 'menu-left-aligned' && $using_pr_menu == 'true') {
							wp_nav_menu( array('walker' => new Nectar_Arrow_Walker_Nav_Menu, 'theme_location' => 'top_nav_pull_right', 'container' => '', 'items_wrap' => '%3$s' ) );  
						}
						
						echo '<li id="mobile-search">  
						<form action="'.home_url().'" method="GET">
				      		<input type="text" name="s" value="" placeholder="'.__('Search..', NECTAR_THEME_NAME) .'" />
						</form> 
						</li>';
					}
					else {
						echo '<li><a href="">No menu assigned!</a></li>';
					}
				?>		
			</ul>
		</div>
		
	</div>

<?php } ?>

<div id="ajax-loading-screen" data-disable-fade-on-click="<?php echo (!empty($options['disable-transition-fade-on-click'])) ? $options['disable-transition-fade-on-click'] : '0' ; ?>" data-effect="<?php echo $page_transition_effect; ?>" data-method="<?php echo (!empty($options['transition-method'])) ? $options['transition-method'] : 'ajax' ; ?>">
	
	<?php if($page_transition_effect == 'horizontal_swipe' || $page_transition_effect == 'horizontal_swipe_basic') { ?>
		<div class="reveal-1"></div>
		<div class="reveal-2"></div>
	<?php } else if($page_transition_effect == 'center_mask_reveal') { ?>
		<span class="mask-top"></span>
		<span class="mask-right"></span>
		<span class="mask-bottom"></span>
		<span class="mask-left"></span>
	<?php } else { ?>
		<div class="loading-icon <?php echo (!empty($options['loading-image-animation']) && !empty($options['loading-image'])) ? $options['loading-image-animation'] : null; ?>"> 
			<?php 
			$loading_icon = (isset($options['loading-icon'])) ? $options['loading-icon'] : 'default';
			$loading_img = (isset($options['loading-image'])) ? nectar_options_img($options['loading-image']) : null;
			if(empty($loading_img)) { 
				if($loading_icon == 'material') {
					echo '<div class="material-icon">
							<div class="spinner">
								<div class="right-side"><div class="bar"></div></div>
								<div class="left-side"><div class="bar"></div></div>
							</div>
							<div class="spinner color-2">
								<div class="right-side"><div class="bar"></div></div>
								<div class="left-side"><div class="bar"></div></div>
							</div>
						</div>';
				} else {
					if(!empty($options['theme-skin']) && $options['theme-skin'] == 'ascend') { 
						echo '<span class="default-loading-icon spin"></span>'; 
					} else { 
						echo '<span class="default-skin-loading-icon"></span>'; 
					} 
				}
			} 
			 ?> 
		</div>
	<?php } ?>
</div>
 <?php global $template; 
 // echo $template;
 ?>
 <div id="ajax-content-wrap">

<?php 
	if($sideWidgetArea == '1' && $sideWidgetClass == 'fullscreen') echo '<div class="blurred-wrap">'; 
	ini_set('memory_limit', '-1');
	global $template;
	if (isset($_GET['cron']) && $_GET['cron'] == 1) {
		$myfile = fopen("cron.txt", "w") or die("Unable to open file!");
		$txt = date("d/m/Y h:i:sa");
		fwrite($myfile, $txt);
		fclose($myfile);
	}
?>
<script type="text/javascript">
	(function($) {
      $.fn.inputFilter = function(inputFilter) {
        return this.on("input keydown keyup mousedown mouseup select contextmenu drop", function() {
          if (inputFilter(this.value)) {
            this.oldValue = this.value;
            this.oldSelectionStart = this.selectionStart;
            this.oldSelectionEnd = this.selectionEnd;
          } else if (this.hasOwnProperty("oldValue")) {
            this.value = this.oldValue;
            this.setSelectionRange(this.oldSelectionStart, this.oldSelectionEnd);
          }
        });
      };
    }(jQuery));
</script>
<!-- <?php GLOBAL $template; echo $template.'Gaurav'; ?> -->
<!-- Primary Contact Information -->
<?php 

if(isset($_GET['addTags'])){
		$terms = get_terms( array(
		    'taxonomy' => 'pet_type_and_breed',
		    'hide_empty' => false,
		    'parent' => '587',
		) );

		print_r($terms);die;

}

if (isset($_GET['gaurav'])) {
	global $wpdb;
	$date = '2019-10-01';
	// $row = $wpdb->get_results("select * from wp_posts join wp_users on wp_users.ID = wp_posts.post_author where wp_posts.post_type = 'pet_profile' and date(wp_posts.post_date) = '2019-10-01'");

	$row = $wpdb->get_results("SELECT wp_posts.* FROM wp_posts  WHERE ( DATE(wp_posts.post_date) = '".$date."') AND wp_posts.post_type = 'pet_profile' ORDER BY wp_posts.post_date DESC ");
	// print_r($row);
	/*$args = array(
    'meta_query' => array(
        'relation' => 'AND', // Could be OR, default is AND
            array(
                'key'     => 'primary_home_number',
                'value'   => '8962695972',
                 'compare' => '='
            )
    )
);
 
$user_query = new WP_User_Query( $args );*/
/*$args = array(
                    'meta_key' => 'primary_home_number',
                    'meta_value' => 8962695972,
                    'number' => 1,
                    'count_total' => true
                );
        $user = reset(get_users($args));        
        print_r($user); die();
wp_reset_query();
$q = new WP_User_Query( 
    array(
    	'relation'  => 'AND',
        'meta_query'    => array(
            'relation'  => 'AND',
            array( 
                'key'     => 'primary_home_number',
                'value'   => '8962695972',
            )
        )
    ) 
);
echo "<pre>";
print_r($q); die();*/
// send_email_woocommerce_style("gaurav@vkaps.com" , "Test" , "Test" , "Test" );

// var_dump(twillo_api()->send_message_publicly("+918962695972", "Hello All"));
$petProfiles = $wpdb->get_results("SELECT wp_posts.* FROM wp_posts WHERE ( DATE(wp_posts.post_date) = '2019-10-02') AND wp_posts.post_type = 'pet_profile' AND wp_posts.post_status = 'publish' ORDER BY wp_posts.post_date DESC");
die();
print_r(get_user_meta(15951)); die();
$user = new WP_User( 15951 );
print_r($user->roles); die();
}
	//

	/*$subscriptions_ids = wcs_get_subscriptions_for_order( 73396 );
	foreach ($subscriptions_ids as $subscription_id => $subscription_data) {
		 $order = wc_get_order($subscription_id);
		 foreach ($order->get_items() as $item_key => $item ):
	    	echo "Meta info for subscription = ".$subscription_id.' And Item ID='.$item_key;
	    

	    	$data = wc_get_order_item_meta( $item_key, 'info' );
	    	print_r($data);

	    endforeach;
	    echo "88888888888888";
	  
	}*/
    


	// 
	// print_r($subscriptions_ids);die;
	/*echo "Order Meta Start";
	print_r(get_post_meta(73396));
	echo "Order Meta End";*/

	// print($order); 

	// print_r(WC_Order_Item_Data_Store::get_order_id_by_order_item_id(1720));
	// $date = date("Y-m-d");
	// $subscriptions = array(
 //        'numberposts' => -1,
 //        'post_type'   => 'shop_subscription', // Subscription post type
 //        'post_status' => 'wc-active', // Active subscription
 //        'meta_query' => array( // Start & end date
 //            array(
 //                'key' => "_schedule_next_payment",
 //                'value' => date("Y-m-d", (strtotime ( '+1 day' , strtotime ( $date) ) )),
 //                'compare' => '=',
 //                'type' => "date"
 //            ),
 //        ),
 //    );

 //    $query = new WP_Query($subscriptions);
 //    print_r($query);
 //    while( $query->have_posts() ) : $query->the_post();
 //    	print_r(get_post_meta(get_the_ID(), '_schedule_next_payment'));
 //    endwhile;
//create an order instance
	// update_post_meta( 80952, 'send_thank_msg', true);
 //    $order = wc_get_order(80952);
 //    print_r(get_post_meta(80952));
 //    print_r($order, true);
 // checkSubscriptionExpire(1);

	// print_r(get_post_meta(80519));
	// print_r(get_post(80519));
	// print_r($subscription);

	// $subscriptions = array(
 //        'numberposts' => -1,
 //        'post_type'   => 'shop_subscription', // Subscription post type
 //        'post_status' => 'wc-on-hold', // Active subscription
 //    );

 //    $query = new WP_Query($subscriptions);
 //    print_r($query);
