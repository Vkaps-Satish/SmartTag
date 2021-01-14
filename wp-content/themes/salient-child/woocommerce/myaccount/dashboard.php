<?php
/**
 * My Account Dashboard
 *
 * Shows the first intro screen on the account dashboard.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/dashboard.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @author      WooThemes
 * @package     WooCommerce/Templates
 * @version     2.6.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

 $paged  = (get_query_var('paged')) ? get_query_var('paged') : 1;
    echo "<div class='page-heading'><h1>My Pets Information</h1></div>";
    global $current_user;
    
    $args = array(
        'post_type' => 'pet_profile',
        'author'        =>  $current_user->ID,
        'orderby'       =>  'post_date',
        'order'         =>  'ASC',
        'posts_per_page' => 10,
        'paged' => $paged,
    );

    $query = new WP_Query($args);
    $i = 0;
    if ($query->have_posts()) {
        while ( $query->have_posts() ) : $query->the_post(); 
            $mypod = pods( 'pet_profile', get_the_id() ); 
            $smarttag_id_number = $mypod->display('smarttag_id_number');
            $microchip_id_number = $mypod->display('microchip_id_number');
            $universal_microchip_id_number = $mypod->display('universal_microchip_id');
            $subscriptionId  = $mypod->display("smarttag_subscription_id");
            $microchipSubscriptionId  = $mypod->display("microchip_subscription_id");
            if (!empty($subscriptionId)) {
                $subscriptionDetail = json_decode(getSubscriptionPlanNameUsingSerialKey($subscriptionId));
                $product_name   = $subscriptionDetail->productName;
                $startDate      = $subscriptionDetail->startDate;
                $date           = $subscriptionDetail->endDate;
                $subscriptionId = $subscriptionDetail->subscriptionId;
            }else{
                $product_name   = '';
                $startDate      = '';
                $date           = '';
            }

            if (!empty($microchipSubscriptionId)) {
                $subscriptionDetail = json_decode( getSubscriptionPlanNameUsingSerialKey($microchipSubscriptionId));
                $microchiPlan       = $subscriptionDetail->productName;
                $microchipStartDate = $subscriptionDetail->startDate;
                $microchipDate      = $subscriptionDetail->endDate;
            }else{
                $microchiPlan       = '';
                $microchipStartDate = '';
                $microchipDate      = '';
            }
            
            ?>

        
            <div class="bottom-border-box">
                <h3><?php echo get_the_title(); ?></h3>
                <div class="row">
                    <div class="col-sm-3 rmb-15">
                        <a href="/my-account/show-profile/?pet_id=<?php echo get_the_ID(); ?>">
                            <?php echo get_the_post_thumbnail(); ?>
                        </a>
                    </div>
                    <div class="col-sm-5 rmb-15">
                        <strong>Pet Name:</strong> <a href="/my-account/show-profile/?pet_id=<?php echo get_the_ID(); ?>"><span class="name"><?php echo get_the_title(); ?></span></a>
                        <br>
                        <strong>Pet Type:</strong> <span><?php $typeId = $mypod->display('pet_type');
                        echo (isset(get_term( $typeId )->name)) ? get_term( $typeId )->name : "" ;
                         ?></span>
                        <br>
                        <strong>IDTag Serial Number:</strong> <span class="name"><?php echo $mypod->display('smarttag_id_number'); ?></span>
                        <br>
                        <strong>IDTag Microchip Number:</strong> <span class="name"><?php echo $microchip_id_number; ?></span><br>
                        <strong>IDTag Universal Number:</strong> <span class="name"><?php echo $universal_microchip_id_number; ?></span>
                        <br>
                        <strong>IDTag SmartTag Plan:</strong> <span><?php echo $product_name; ?></span>
                        <br>
                        <strong>IDTag Microchip Plan:</strong> <span><?php echo $microchiPlan; ?></span>
                    </div>
                    <div class="col-sm-4 mb-elements">                        
                        <form action="" method="post" class="custom-form">
                            <input type="hidden" name="startDate" value="<?php echo $startDate; ?>">
                            <input type="hidden" name="endDate" value="<?php echo $date; ?>">
                            <input type="hidden" name="post_id" value="<?php echo get_the_ID(); ?>">
                            <input type="hidden" name="smarttagid" value="<?php echo $smarttag_id_number; ?>">
                            <?php if (!empty($product_name)) { ?>
                                <p><a href="<?php echo get_site_url().'/my-account/view-subscription/'.$subscriptionId.'/'; ?>" class="button view site-btn-light-blue">Update Protection Plan <i class="fa fa-caret-right"></i></a></p>
                            <?php } ?>
                            <?php $check = checkSmartIDTag(1,'lost_found_pets','pet_status','smarttag_id_number',$smarttag_id_number);
                            $microchipcheck = checkMicrochipID(1,'lost_found_pets','pet_status','microchip_id_number',$microchip_id_number);
                            $universalcheck = checkMicrochipID(1,'lost_found_pets','pet_status','universal_microchip_id',$universal_microchip_id_number);
                            if ($check || $microchipcheck || $universalcheck) {
                                echo '<p><a href="/my-account/report-pet-lost/?pet_id='.get_the_ID().'" class="site-btn-red btn site-btn">Report Pet As Lost <i class="fa fa-caret-right"></i></a></p>';
                            }else{
                                echo '<p><input type="hidden" name="smarttag_id_number" value="'.$smarttag_id_number.'"><input type="hidden" name="report_pet_as_found" value="1"><a href="/my-account/report-pet-found-list/?pet_id='.get_the_ID().'" class="site-btn-light-blue btn site-btn">Report Pet As Found &nbsp;<i class="fa fa-caret-right"></i></a></p>';
                            } ?>
                            <p><a href="/my-account/free-replacement-tag/?pet_id=<?php echo get_the_ID(); ?>" class="light-blue-link"><strong>Order a free Replacement Tag</strong> <i class="fa fa-caret-right"></i></a></p>
                            <p><a href="/my-account/show-profile/?pet_id=<?php echo get_the_ID(); ?>" class="light-blue-link"><strong>View/Edit Full Pet Profile </strong><i class="fa fa-caret-right"></i></a></p>
                            <?php if (!empty(trim($smarttag_id_number)) && empty(trim($subscriptionId))) { ?>
                                <p><a href="<?php echo site_url(); ?>/my-account/subscription-link-to-product/?pet_id=<?php echo get_the_id(); ?>" class="light-blue-link"><strong>Link the ID Tag to IDTag Subscription Plan</strong> <i class="fa fa-caret-right"></i></a></p>
                            <?php } ?>
                            <?php if (!empty(trim($microchip_id_number)) && empty(trim($microchipSubscriptionId))) { ?>
                                <p><a href="<?php echo site_url(); ?>/my-account/microchip-subscription-link-to-product/?pet_id=<?php echo get_the_id(); ?>" class="light-blue-link"><strong>Link the Microchip Id to Microchip Subscription Plan</strong> <i class="fa fa-caret-right"></i></a></p>
                            <?php } ?>
                        </form>
                    </div>
                </div>
            </div>
        <?php 
        endwhile;
        $total_pages = $query->max_num_pages;
        if ($total_pages > 1){

            $current_page = max(1, get_query_var('paged'));

            echo "<div id='pagination'>".paginate_links(array(
                'base' => get_pagenum_link(1) . '%_%',
                'format' => 'page/%#%',
                'current' => $current_page,
                'total' => $total_pages,
                'prev_text'    => __('prev'),
                'next_text'    => __('next'),
            ))."</div>";
        }?>
        <?php
    } else{

        echo "<div class='no-found'>Sorry, No pet found</div> <br>"; ?>
        </div>
        <div class="redirect-btn">
            <a class="site-btn site-btn-red" href="<?php echo site_url(); ?>/my-account/add-pet-id-my-account/"> Please Register Your Pet <i class="fa fa-caret-right"></i></a>
        </div>
    <?php }

    /**
     * My Account dashboard.
     *
     * @since 2.6.0
     */
    do_action( 'woocommerce_account_dashboard' );

    /**
     * Deprecated woocommerce_before_my_account action.
     *
     * @deprecated 2.6.0
     */
    do_action( 'woocommerce_before_my_account' );

    /**
     * Deprecated woocommerce_after_my_account action.
     *
     * @deprecated 2.6.0
     */
    do_action( 'woocommerce_after_my_account' );

/* Omit closing PHP tag at the end of PHP files to avoid "headers already sent" issues. */