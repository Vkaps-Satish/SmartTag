<?php
/*
 * Register Permalink Endpoint
 */

add_action( 'init', 'add_endpoint' );
function add_endpoint() {
 
    // WP_Rewrite is my Achilles' heel, so please do not ask me for detailed explanation
    add_rewrite_endpoint( 'pet-profile', EP_PAGES );
    add_rewrite_endpoint( 'report-pet-lost', EP_PAGES );
    add_rewrite_endpoint( 'email-customer-service', EP_PAGES );
    add_rewrite_endpoint( 'all-pet-profile', EP_PAGES );
    add_rewrite_endpoint( 'add-pet-id-my-account', EP_PAGES );
    add_rewrite_endpoint( 'report-my-pet-lost', EP_PAGES );
    add_rewrite_endpoint( 'show-profile', EP_PAGES );
    add_rewrite_endpoint( 'report-pet-found-list', EP_PAGES );
    add_rewrite_endpoint( 'subscription-link-to-product', EP_PAGES );
    add_rewrite_endpoint( 'microchip-link-to-pet', EP_PAGES );
    add_rewrite_endpoint( 'smarttag-link-to-pet', EP_PAGES );
    add_rewrite_endpoint( 'purchase-replacement-id-tag', EP_PAGES );
    add_rewrite_endpoint( 'order-print-lost-pet-poster', EP_PAGES );
    add_rewrite_endpoint( 'sign-up-pet-alerts', EP_PAGES );
    add_rewrite_endpoint( 'single-sign-up-pet-alerts', EP_PAGES );
    add_rewrite_endpoint( 'free-replacement-tag', EP_PAGES );
    add_rewrite_endpoint( 'order-print-lost-pet-poster-form', EP_PAGES );

    if (is_user_logged_in()) {
        global $current_user;
        $firstName      = $current_user->user_firstname;
        $lastName       = $current_user->user_lastname;
        $email          = $current_user->user_email;
        $userId         = get_current_user_id();
        $sfname         = get_the_author_meta("secondary_first_name",$userId);
        $slname         = get_the_author_meta("secondary_last_name",$userId);
        $semail         = get_the_author_meta("secondary_email",$userId);

        if (empty($sfname) && empty($slname)) {
            update_user_meta( $userId, 'secondary_first_name', $firstName );
            update_user_meta( $userId, 'secondary_last_name', $lastName );
        }elseif (empty($sfname)) {
            // update_user_meta( $userId, 'secondary_first_name', $firstName );
            update_user_meta( $userId, 'secondary_first_name', '' );
        }elseif (empty($slname)) {
            // update_user_meta( $userId, 'secondary_last_name', $lastName );
            update_user_meta( $userId, 'secondary_last_name', '' );
        }

        if (empty($semail)) {
            update_user_meta( $userId, 'secondary_email', $email );
        }
    }

 
}


/*
 * Content for the new page in My Account, woocommerce_account_{ENDPOINT NAME}_endpoint
 */
add_action( 'woocommerce_account_email-customer-service_endpoint', 'my_account_endpoint_content_email_customer_service' );
function my_account_endpoint_content_email_customer_service() {
    echo '<div class="page-heading">
    <h1>Email Customer Service</h1>
</div>';
    echo do_shortcode("[gravityform id=9]");
}

/*
 change the order and add the new menu of woocommerce my account menu
 */
function wpb_woo_my_account_order() {
    $myorder = array(
        'my-account' => __( 'My Pets Information', 'woocommerce' ),
        'edit-account'       => __( 'Owner Profile Information', 'woocommerce' ),
        'purchase-replacement-id-tag'          => __( 'Purchase a Replacement ID Tag', 'woocommerce' ),
        'subscriptions'             => __( 'Upgrade My Protection Plans', 'woocommerce' ),
        'report-my-pet-lost'          => __( 'Report My Pet as Lost', 'woocommerce' ),
        'order-print-lost-pet-poster'       => __( 'Order or Print Lost Pet Poster', 'woocommerce' ),
        'sign-up-pet-alerts'    => __( 'Sign Up For Pet Alerts', 'woocommerce' ),
        'add-pet-id-my-account'    => __( 'Add Or Remove a Pet', 'woocommerce' ),
        'edit-address'    => __( 'Billing/Shipping Information', 'woocommerce' ),
        'orders'    => __( 'Order History', 'woocommerce' ),
        'email-customer-service'    => __( 'Email Customer Service', 'woocommerce' ),
        'subscription-link-to-product'    => __( 'Link SmartTag to subscription plan', 'woocommerce' ),
        'microchip-link-to-pet'    => __( 'Link Microchip to Pet Profile', 'woocommerce' ),
        'smarttag-link-to-pet'    => __( 'Link SmartTag ID To Pet Profile', 'woocommerce' ),
    );
    return $myorder;
}
add_filter ( 'woocommerce_account_menu_items', 'wpb_woo_my_account_order' );

/*Purchase Replacement ID Tag*/

add_action( 'woocommerce_account_purchase-replacement-id-tag_endpoint', 'my_account_endpoint_content_for_purchase_replacement_id_tag' );
function my_account_endpoint_content_for_purchase_replacement_id_tag() {
    echo '<div class="page-heading"><h1>Purchase Replacement ID Tag</h1></div><h3 class="border-head">Step 1: Select Pet</h3>';
    $user_id = get_current_user_id();
    $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
    $args=array(
        'post_type' => 'pet_profile',
        'paged' => $paged,
        'author' => $user_id
    );
    $wp_query = new WP_Query($args);
    $i = 0;
    if ($wp_query->have_posts()) {
        while ( $wp_query->have_posts() ) : $wp_query->the_post(); 
            $mypod = pods( 'pet_profile', get_the_id() ); 
            $smarttag_id_number = $mypod->display('smarttag_id_number');
            $subscriptionId  = $mypod->display("smarttag_subscription_id");
            if (!empty($subscriptionId)) {
                $subscription   = wcs_get_subscription($subscriptionId);
                $date           = $subscription->get_date("end");
                $date           = date_parse_from_format('Y-m-d H:i:s',$date);
                $time           = mktime(0, 0, 0, $date['month'], $date['day'], $date['year']);
                $date           = date("m/d/Y", $time);
                // $subscription = wc_get_order($subscriptionId);
                // print_r($subscription->get_items());
                foreach( $subscription->get_items() as $item_id => $product_subscription ){
                    // Get the name
                    $product_name = $product_subscription['name']." (Expires: ".$date.")";

                    // print_r($product_subscription);
                    $variationId  = $product_subscription['variation_id'];
                }
            }else{
                $product_name = '';
            }
            
            ?>
            <div class="bottom-border-box">
                <h3>Registered Pet <?php echo ++$i; ?></h3>
                <div class="row">
                    <div class="col-sm-3 rmb-15">
                        <?php echo get_the_post_thumbnail(); ?>
                    </div>
                    <div class="col-sm-5 rmb-15">
                        <strong>Pet Name:</strong> <span class="name"><?php echo get_the_title(); ?></span>
                        <br>
                        <strong>Pet Type:</strong> <span><?php echo $mypod->display('pet_type'); ?></span>
                        <br>
                        <strong>IDTag Serial Number:</strong> <span class="name"><?php echo $mypod->display('smarttag_id_number'); ?></span>
                        <br>
                        <strong>ID Tag Plan:</strong> <span><?php echo $product_name; ?></span>
                    </div>
                    <div class="col-sm-4 mb-elements">                        
                        <form action="/my-account/free-replacement-tag" method="post" class="custom-form">
                            <input type="hidden" name="post_id" value="<?php echo get_the_ID(); ?>">
                            <input type="hidden" name="smarttagid" value="<?php echo $smarttag_id_number; ?>">
                            <p><button type="submit" class="replacement-tag button view site-btn-red"><strong>Order a free Replacement Tag</strong> <i class="fa fa-caret-right"></i></button></p>
                        </form>
                    </div>
                </div>
            </div>
        <?php 
        endwhile;
        $total_pages = $wp_query->max_num_pages;
        if ($total_pages > 1){

            $current_page = max(1, get_query_var('paged'));

            echo paginate_links(array(
                'base' => get_pagenum_link(1) . '%_%',
                'format' => 'page/%#%',
                'current' => $current_page,
                'total' => $total_pages,
                'prev_text'    => __('« prev'),
                'next_text'    => __('next »'),
            ));
        }?>
        <?php
    } else{
        echo "Sorry, No pet found";
    }
}

add_action( 'woocommerce_account_free-replacement-tag_endpoint', 'my_account_endpoint_content_for_free_replacement_tag' );
function my_account_endpoint_content_for_free_replacement_tag() {
    echo '<div class="page-heading"><h1>Purchase Replacement ID Tag</h1></div><h3 class="border-head">Step 2: Select Pet ID Tag</h3>';

    if (isset($_POST['smarttagid'])) {
        $smartTagId = $_POST['smarttagid'];
        global $wpdb;
        $results = $wpdb->get_results("SELECT wp_woocommerce_order_items.`order_item_name`, wp_woocommerce_order_items.`order_item_type`, wp_woocommerce_order_items.`order_id`, wp_woocommerce_order_itemmeta.* FROM wp_woocommerce_order_items JOIN wp_woocommerce_order_itemmeta ON wp_woocommerce_order_items.order_item_id = wp_woocommerce_order_itemmeta.order_item_id where wp_woocommerce_order_itemmeta.order_item_id = (SELECT MAX(order_item_id) FROM wp_woocommerce_order_itemmeta where meta_value = '".$smartTagId."' and meta_key = 'Serial Number')", OBJECT);
        $dataa = json_encode($results);
        $data = json_decode($dataa);
        foreach ($data as $value) {
            $order_id = $value->order_id;
            if ($value->meta_key == 'FrontLine1') {
                $frontLine1 = strip_tags($value->meta_value);
            }elseif ($value->meta_key == 'FrontLine2') {
                $frontLine2 = strip_tags($value->meta_value);
            }elseif ($value->meta_key == 'FrontLine3') {
                $frontLine3 = strip_tags($value->meta_value);
            }elseif ($value->meta_key == 'FrontLine4') {
                $frontLine4 = strip_tags($value->meta_value);
            }elseif ($value->meta_key == 'BackLine1') {
                $backLine1  = strip_tags($value->meta_value);
            }elseif ($value->meta_key == 'BackLine2') {
                $backLine2  = strip_tags($value->meta_value);
            }elseif ($value->meta_key == 'BackLine3') {
                $backLine3  = strip_tags($value->meta_value);
            }elseif ($value->meta_key == 'BackLine4') {
                $backLine4  = strip_tags($value->meta_value);
            }elseif ($value->meta_key == '_product_id') {
                $product_id  = $value->meta_value;
            }elseif ($value->meta_key == '_variation_id') {
                $variation_id  = $value->meta_value;
            }elseif ($value->meta_key == 'pa_shape') {
                $shape  = $value->meta_value;
            }elseif ($value->meta_key == 'pa_size') {
                $size  = $value->meta_value;
            }elseif ($value->meta_key == 'pa_color') {
                $color  = $value->meta_value;
            }elseif ($value->meta_key == 'pa_ttype') {
                $type  = $value->meta_value;
            }elseif ($value->meta_key == 'pa_style') {
                $style  = $value->meta_value;
            }elseif ($value->meta_key == 'FrontImage') {
                $frontImage  = $value->meta_value;
            }elseif ($value->meta_key == 'BackImage') {
                $backImage  = $value->meta_value;
            }
        } 
        if ($product_id == 6089 || $product_id == 7722) {
            $attributes = array(
                'pa_ttype'  => $type,
                'pa_size'   => $size,
                'pa_style'  => $style,
            );
        }elseif ($product_id == 6033 || $product_id == 7659) {
            $attributes = array(
                'pa_shape'  => $shape,
                'pa_size'   => $size,
                'pa_color'  => $color,
            );
        }
        // print_r($attributes);
        $postId = $_POST['post_id'];
        // $product = new WC_Product_Variable( $product_id );
        // echo $variation_id."<br>variation_id:- ".iconic_find_matching_product_variation($product, $attributes);
        ?>
        <div class="pp-tabs-wrap">
            <div class="pp-tabs-nav">
                <div class="view pp-tabs-nav-inner pp-tab-option-1 active">View</div>
                <div class="view pp-tabs-nav-inner pp-tab-option-2">Edit</div>
            </div>
            <div class="pp-tabs-content pp-tab-content-1" style="display: block;">
                <div class="acc-blue-box mb-15">
                    <div class="acc-blue-head">
                        Pet ID Tag Information
                        <div class="acc-edit lines-edit">
                            <i class="fa fa-cog"></i> EDIT
                        </div>
                    </div>
                    <div class="acc-blue-content">
                        <div class="row">
                            <div class="col-sm-2 rmb-15">
                                <?php echo get_the_post_thumbnail($postId); ?>
                            </div>
                            <div class="col-sm-5 rmb-15">
                                <h4 class="color-light-blue">FRONT</h4>
                                <?php if ($product_id == 6089 || $product_id == 7722) { 
                                        echo $frontImage;
                                    }elseif ($product_id == 6033 || $product_id == 7659) { ?>
                                        <p class="fline1"><strong>Line 1:</strong> <span><?php echo $frontLine1; ?></span></p>
                                        <p class="fline2"><strong>Line 2:</strong> <span><?php echo $frontLine2; ?></span></p>
                                        <p class="fline3"><strong>Line 3:</strong> <span><?php echo $frontLine3; ?></span></p>
                                        <p class="fline4"><strong>Line 4:</strong> <span><?php echo $frontLine4; ?></span></p>
                                <?php } ?>
                            </div>
                            <div class="col-sm-5">
                                <h4 class="color-light-blue">BACK</h4>
                                <p class="bline1"><strong>Line 1:</strong> <span><?php echo $backLine1; ?></span></p>
                                <p class="bline2"><strong>Line 2:</strong> <span><?php echo $backLine2; ?></span></p>
                                <p class="bline3"><strong>Line 3:</strong> <span><?php echo $backLine3; ?></span></p>
                                <p class="bline4"><strong>Line 4:</strong> <span><?php echo $backLine4; ?></span></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="pp-tabs-content pp-tab-content-2">
                <div class="contact-form">
                    <form action="" method="post" class="update-form">
                        <input type="hidden" name="post_id" value="<?php echo $postId; ?>">      
                        <div class="acc-blue-box">
                            <div class="acc-blue-content">
                                <div class="row">
                                    <?php if ($product_id == 6089 || $product_id == 7722) {
                                        echo '<div class="col-sm-12 mb-15">
                                            <h4 class="color-light-blue">BACK</h4>
                                            <p><strong>Line 1: </strong><input type="text" name="backLine1" value="<?php echo $backLine1; ?>" class="backLine1" ></p>
                                            <p><strong>Line 2: </strong><input type="text" name="backLine2" value="<?php echo $backLine2; ?>" class="backLine2" ></p>
                                            <p><strong>Line 3: </strong><input type="text" name="backLine3" value="<?php echo $backLine3; ?>" class="backLine3" ></p>
                                            <p><strong>Line 4: </strong><input type="text" name="backLine4" value="<?php echo $backLine4; ?>" class="backLine4" ></p>
                                        </div>
                                    </div>';
                                    }elseif ($product_id == 6033 || $product_id == 7659) {
                                        echo '<div class="col-sm-6 mb-15">
                                            <h4 class="color-light-blue">FRONT</h4>
                                            <p><strong>Line 1: </strong><input type="text" name="frontLine1" class="frontLine1" value="<?php echo $frontLine1; ?>"></p>
                                            <p><strong>Line 2: </strong><input type="text" name="frontLine2" class="frontLine2" value="<?php echo $frontLine2; ?>"></p>
                                            <p><strong>Line 3: </strong><input type="text" name="frontLine3" class="frontLine3" value="<?php echo $frontLine3; ?>"></p>
                                            <p><strong>Line 4: </strong><input type="text" name="frontLine4" class="frontLine4" value="<?php echo $frontLine4; ?>"></p>
                                        </div>
                                        <div class="col-sm-6 mb-15">
                                            <h4 class="color-light-blue">BACK</h4>
                                            <p><strong>Line 1: </strong><input type="text" name="backLine1" value="<?php echo $backLine1; ?>" class="backLine1" ></p>
                                            <p><strong>Line 2: </strong><input type="text" name="backLine2" value="<?php echo $backLine2; ?>" class="backLine2" ></p>
                                            <p><strong>Line 3: </strong><input type="text" name="backLine3" value="<?php echo $backLine3; ?>" class="backLine3" ></p>
                                            <p><strong>Line 4: </strong><input type="text" name="backLine4" value="<?php echo $backLine4; ?>" class="backLine4" ></p>
                                        </div>
                                    </div>';
                                    }?>
                                <div class="text-center">
                                    <button type="button" class="site-btn-light-blue lines-show">Save</button>
                                </div>
                            </div>
                        </div>                         
                    </form>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-4 rmb-15">
                    <div class="blue-border-box">
                        <p></p>
                        <?php  
                            if ($product_id == 6089 || $product_id == 7722) {
                                if ($type == "bone") {
                                    echo '<img src="https://idtag.agiliscloud.com/wp-content/themes/salient-child/images/black_bone_shape_2_2.png" data-name="color-bone">';
                                }elseif ($type == "circle") {
                                    echo '<img src="https://idtag.agiliscloud.com/wp-content/themes/salient-child/images/bluetag2.jpg" data-name="color-circle">';
                                }elseif ($type == "heart") {
                                    echo '<img src="https://idtag.agiliscloud.com/wp-content/themes/salient-child/images/heart_pink_shape_2.png" data-name="color-heart">';
                                }
                            }elseif ($product_id == 6033 || $product_id == 7659) {
                                if ($shape == "bone") {
                                    echo '<img src="https://idtag.agiliscloud.com/wp-content/themes/salient-child/images/bone_back.jpg" data-name="back-img">';
                                }elseif ($shape == "circle") {
                                    echo '<img src="https://idtag.agiliscloud.com/wp-content/themes/salient-child/images/circle_back.png" data-name="back-img">';
                                }elseif ($shape == "heart") {
                                    echo '<img src="https://idtag.agiliscloud.com/wp-content/themes/salient-child/images/brass_heart.jpg" data-name="back-img">';
                                }
                            }
                        ?>
                        <a href="javascript:;" class="color-light-blue replace-btn">Order Replacement Tag <i class="fa fa-caret-right"></i></a>
                    </div>
                </div>
                <div class="col-sm-4 rmb-15">
                    <div class="blue-border-box">
                        <p></p>
                        <?php echo $frontImage; 
                            if ($product_id == 6033 || $product_id == 7659) {
                                echo $frontLine1."<br>".$frontLine2."<br>".$frontLine3."<br>".$frontLine4."<br>";
                            }
                        ?>
                        <a href="javascript:;" class="color-light-blue">Order Your Custom Tag <i class="fa fa-caret-right"></i></a>
                    </div>                
                </div>
                <div class="col-sm-4 rmb-15">
                    <div class="blue-border-box">
                        <p></p>
                        IMAGE
                        <a href="javascript:;" class="color-light-blue">Create a New Tag <i class="fa fa-caret-right"></i></a>
                    </div>                
                </div>
            </div>
        </div>
        <form style="display: none;" action="" method="post" id="replace-form">
            <input type="hidden" name="product_id" value="<?php echo $product_id; ?>" id="product-id">
            <input type="hidden" name="frontLine1" class="front-line-1 front-line" value="">
            <input type="hidden" name="frontLine2" class="front-line-2 front-line" value="">
            <input type="hidden" name="frontLine3" class="front-line-3 front-line" value="">
            <input type="hidden" name="frontLine4" class="front-line-4 front-line" value="">
            <input type="hidden" name="backLine1" class="back-line-1" value="">
            <input type="hidden" name="backLine2" class="back-line-2" value="">
            <input type="hidden" name="backLine3" class="back-line-3" value="">
            <input type="hidden" name="backLine4" class="back-line-4" value="">
            <input type="hidden" name="serialNumber" value="<?php echo $smartTagId; ?>">
            <?php if ($product_id == 6089 || $product_id == 7722) { ?>
                <input type="hidden" name="type" value="<?php echo $type; ?>">
                <input type="hidden" name="style" value="<?php echo $style; ?>">
            <?php } elseif ($product_id == 6033 || $product_id == 7659) { ?>
                <input type="hidden" name="color" value="<?php echo $color; ?>">
                <input type="hidden" name="type" value="<?php echo $shape; ?>">
            <?php } ?>
            <input type="hidden" name="size" value="<?php echo $size; ?>">
        </form>
        <script type="text/javascript">
            jQuery(document).ready(function($){
                $(".lines-edit").click(function(){
                    $(".pp-tab-option-2").click();
                });
                $(".lines-show").click(function(){
                    $("p.fline1 span").text($('input.frontLine1').val());
                    $("p.fline2 span").text($('input.frontLine2').val());
                    $("p.fline3 span").text($('input.frontLine3').val());
                    $("p.fline4 span").text($('input.frontLine4').val());

                    $("p.bline1 span").text($('input.backLine1').val());
                    $("p.bline2 span").text($('input.backLine2').val());
                    $("p.bline3 span").text($('input.backLine3').val());
                    $("p.bline4 span").text($('input.backLine4').val());
                    $(".pp-tab-option-1").click();
                });
                $(".pp-tab-option-2").click(function(){
                    $('input.frontLine1').val($("p.fline1 span").text());
                    $('input.frontLine2').val($("p.fline2 span").text());
                    $('input.frontLine3').val($("p.fline3 span").text());
                    $('input.frontLine4').val($("p.fline4 span").text());
                    $('input.backLine1').val($("p.bline1 span").text());
                    $('input.backLine2').val($("p.bline2 span").text());
                    $('input.backLine3').val($("p.bline3 span").text());
                    $('input.backLine4').val($("p.bline4 span").text());
                });
                $('.replace-btn').on('click',function(){
                    var productId = $('input#product-id').val();
                    $('input.front-line-1').val($("p.fline1 span").text());
                    $('input.front-line-2').val($("p.fline2 span").text());
                    $('input.front-line-3').val($("p.fline3 span").text());
                    $('input.front-line-4').val($("p.fline4 span").text());
                    $('input.back-line-1').val($("p.bline1 span").text());
                    $('input.back-line-2').val($("p.bline2 span").text());
                    $('input.back-line-3').val($("p.bline3 span").text());
                    $('input.back-line-4').val($("p.bline4 span").text());
                    if (productId == '6089' || productId == '7722') {
                        $('input.front-line').prop('disabled', true);
                        $('form#replace-form').attr('action','/product/aluminum-id-tag-2/');
                        $('form#replace-form').submit();
                    }else if (productId == '6033' || productId == '7659') {
                        $('form#replace-form').attr('action','/product/brass-id-tag-2/');
                        $('form#replace-form').submit();
                    }
                });
            });
        </script>
    <?php  
    }
}

/*Link Microchip to Pet Profile*/

add_action( 'woocommerce_account_microchip-link-to-pet_endpoint', 'my_account_endpoint_content_for_microchip_link_to_pet' );

function my_account_endpoint_content_for_microchip_link_to_pet(){
    echo '<div class="page-heading"><h1>Link Microchip ID To Pet Profile</h1></div>';
    if (isset($_POST['petID'])) {
        $postId         = $_POST['petID'];
        $microchipID    = $_POST['microchipID'];
        update_post_meta($postId,'microchip_id_number',$microchipID);
    }
    echo "<form class='link-microchip' action='' method='post'>";
    $microchipIds   = array();
    $prod_arr       = array( '8054');

    // Get all customer orders
    $customer_orders = get_posts( array(
        'numberposts' => -1,
        'meta_key'    => '_customer_user',
        'meta_value'  => get_current_user_id(),
        'post_type'   => 'shop_order', // WC orders post type
        'post_status' => array_keys( wc_get_order_statuses() ),
    ) );
    //print_r($customer_orders);
    foreach ( $customer_orders as $customer_order ) {
        // Updated compatibility with WooCommerce 3+
        $order_id   = $customer_order->ID;
        $order      = wc_get_order( $order_id );
        $order      = new WC_Order( $order_id );
        // Iterating through each current customer products bought in the order
        foreach ($order->get_items() as $item) {
            // print_r($item);
            // WC 3+ compatibility
            if ( version_compare( WC_VERSION, '3.0', '<' ) ) 
                $product_id = $item['product_id'];
            else
                $product_id = $item->get_product_id();

            // Your condition related to your 2 specific products Ids
            if ( in_array( $product_id, $prod_arr ) ) {
                $kua = $item->get_meta_data();
                $result[] = $kua;
                
            }
        }
    }
    if (is_array($result)) {
        foreach ($result as $check) {
            foreach ($check as $key => $value) {
                if ($value->key == 'Serial Number') {
                    $idTagID[] = $value->value;
                }
            }
        }
    }
    if (is_array($idTagID)) {
        foreach ($idTagID as $value) {
            $values = explode(',', $value);
            foreach ($values as $id) {
                array_push($microchipIds, $id);
            }
        }
    }
    echo '<select name="microchipID" class="microchip-id">';
    $i = 0;
    $j = 1;
    if (count($microchipIds) > 0) {
        foreach ($microchipIds as $microchipId) {
            $result = checkSerialNumberInPetProfile($microchipId, "microchip_id_number");
            if ($result) {
                $i++;
                $j = 0;
                if ($i == 1 ) {
                    echo '<option value="0">Please Select Microchip.</option>';
                }
                echo '<option value="'.$microchipId.'">'.$microchipId.'</option>';
            }
        }
            
    }

    if ($j) {
        echo '<option value="0">Sorry No Un-Register Microchip Found.</option>';
    }
    echo '</select>';

    $i = 0;
    $z = 0;
    $user_id = get_current_user_id();
    $args=array(
        'post_type' => 'pet_profile',
        'post_status' => 'publish',
        'author' => $user_id,
        'posts_per_page' => -1,         
    );
    $query = new WP_Query($args);   
    while ( $query->have_posts() ) : $query->the_post();
        $microchipSerialNumber  = '';
        $smarttagIdNumber       = '';
        $mypod                  = pods( 'pet_profile', get_the_id() ); 
        $smarttagIdNumber       = $mypod->display('smarttag_id_number');
        $microchipSerialNumber  = $mypod->display('microchip_id_number');
        
        if (!empty($smarttagIdNumber) && empty($microchipSerialNumber)) { 
            $z = 1;
            $products[$i]['id']     = get_the_id();
            $products[$i]['name']   = get_the_title();
            $i++;
        }
    endwhile;
    $i = 0;
    echo '<select name="petID" class="pet-profile">';
    if ($z) {
        foreach ($products as $product) {
            $i++;
            if ($i == 1) {
                echo '<option value="0">Please Select Pet Profile for Link Microchip.</option>';
            }
            echo '<option value="'.$product['id'].'">'.$product['name'].'</option>';
        }
    }else{
        echo '<option value="0">Sorry No Pet Profile Found.</option>';
    }
    echo '</select><div class="notice"></div>';

    if ($j == 0 && $z == 1) {
        echo "<button type='submit' name='submitButton' class='site-btn submit-btn'>Submit</button>";
    }
    echo "</form>";
    echo '<script type="text/javascript">
        jQuery(document).ready(function($){
            $("form.link-microchip").on("submit", function() {
                var microchip   = $(".microchip-id").val();
                var petProfile  = $(".pet-profile").val();
                if (microchip == "0" && petProfile == "0") {
                    console.log(microchip);
                    $(".notice").text("Please Select Microchip ID and Pet Profile");
                    return false;
                }else if (microchip == "0") {
                    $(".notice").text("Please Select Microchip ID");
                    return false;
                }else if (petProfile == "0") {
                    $(".notice").text("Please Select Pet Profile");
                    return false;
                }
            });
        });
    </script>';

}


/*Link SmartTag ID to Pet Profile*/

add_action( 'woocommerce_account_smarttag-link-to-pet_endpoint', 'my_account_endpoint_content_for_smarttag_link_to_pet' );

function my_account_endpoint_content_for_smarttag_link_to_pet(){
    echo '<div class="page-heading"><h1>Link SmartTag ID To Pet Profile</h1></div>';
    if (isset($_POST['petID'])) {
        $postId         = $_POST['petID'];
        $smartTagId    = $_POST['smartTagID'];
        update_post_meta($postId,'smarttag_id_number',$smartTagId);
    }
    echo "<form class='link-smarttag' action='' method='post'>";
    $SmartTagIds   = array();
    $prod_arr       = array( '6089', '6033');

    // Get all customer orders
    $customer_orders = get_posts( array(
        'numberposts' => -1,
        'meta_key'    => '_customer_user',
        'meta_value'  => get_current_user_id(),
        'post_type'   => 'shop_order', // WC orders post type
        'post_status' => array_keys( wc_get_order_statuses() ),
    ) );
    //print_r($customer_orders);
    foreach ( $customer_orders as $customer_order ) {
        // Updated compatibility with WooCommerce 3+
        $order_id   = $customer_order->ID;
        $order      = wc_get_order( $order_id );
        $order      = new WC_Order( $order_id );
        // Iterating through each current customer products bought in the order
        foreach ($order->get_items() as $item) {
            // print_r($item);
            // WC 3+ compatibility
            if ( version_compare( WC_VERSION, '3.0', '<' ) ) 
                $product_id = $item['product_id'];
            else
                $product_id = $item->get_product_id();

            // Your condition related to your 2 specific products Ids
            if ( in_array( $product_id, $prod_arr ) ) {
                $kua = $item->get_meta_data();
                $result[] = $kua;
                
            }
        }
    }
    if (is_array($result)) {
        foreach ($result as $check) {
            foreach ($check as $key => $value) {
                if ($value->key == 'Serial Number') {
                    $idTagID[] = $value->value;
                }
            }
        }
    }
    if (is_array($idTagID)) {
        foreach ($idTagID as $value) {
            $values = explode(',', $value);
            foreach ($values as $id) {
                array_push($SmartTagIds, $id);
            }
        }
    }
    echo '<select name="smartTagID" class="microchip-id">';
    $i = 0;
    $j = 1;
    if (count($SmartTagIds) > 0) {
        foreach ($SmartTagIds as $SmartTagId) {
            $result = checkSerialNumberInPetProfile($SmartTagId, "smarttag_id_number");
            if ($result) {
                $i++;
                $j = 0;
                if ($i == 1 ) {
                    echo '<option value="0">Please Select Microchip.</option>';
                }
                echo '<option value="'.$SmartTagId.'">'.$SmartTagId.'</option>';
            }
        }
            
    }

    if ($j) {
        echo '<option value="0">Sorry, Un-Register SmartTag ID Not Found.</option>';
    }
    echo '</select>';

    $i = 0;
    $z = 0;
    $user_id = get_current_user_id();
    $args=array(
        'post_type' => 'pet_profile',
        'post_status' => 'publish',
        'author' => $user_id,
        'posts_per_page' => -1,         
    );
    $query = new WP_Query($args);   
    while ( $query->have_posts() ) : $query->the_post();
        $microchipSerialNumber  = '';
        $smarttagIdNumber       = '';
        $mypod                  = pods( 'pet_profile', get_the_id() ); 
        $smarttagIdNumber       = $mypod->display('smarttag_id_number');
        $microchipSerialNumber  = $mypod->display('microchip_id_number');
        
        if (empty($smarttagIdNumber) && !empty($microchipSerialNumber)) { 
            $z = 1;
            $products[$i]['id']     = get_the_id();
            $products[$i]['name']   = get_the_title();
            $i++;
        }
    endwhile;
    $i = 0;
    echo '<select name="petID" class="pet-profile">';
    if ($z) {
        foreach ($products as $product) {
            $i++;
            if ($i == 1) {
                echo '<option value="0">Please Select Pet Profile for Link Microchip.</option>';
            }
            echo '<option value="'.$product['id'].'">'.$product['name'].'</option>';
        }
    }else{
        echo '<option value="0">Sorry, Pet Profile Not Found.</option>';
    }
    echo '</select><div class="notice"></div>';

    if ($j == 0 && $z == 1) {
        echo "<button type='submit' name='submitButton' class='site-btn submit-btn'>Submit</button>";
    }
    echo "</form>";
    echo '<script type="text/javascript">
        jQuery(document).ready(function($){
            $("form.link-microchip").on("submit", function() {
                var microchip   = $(".microchip-id").val();
                var petProfile  = $(".pet-profile").val();
                if (microchip == "0" && petProfile == "0") {
                    console.log(microchip);
                    $(".notice").text("Please Select Microchip ID and Pet Profile");
                    return false;
                }else if (microchip == "0") {
                    $(".notice").text("Please Select Microchip ID");
                    return false;
                }else if (petProfile == "0") {
                    $(".notice").text("Please Select Pet Profile");
                    return false;
                }
            });
        });
    </script>';

}


/*Order Print Lost Pet Poster*/ 

add_action( 'woocommerce_account_order-print-lost-pet-poster_endpoint', 'my_account_endpoint_content_for_order_print_lost_pet_poster' );
function my_account_endpoint_content_for_order_print_lost_pet_poster() {
    echo '<div class="page-heading"><h1>Order Print Lost Pet Poster</h1></div>';
    $user_id = get_current_user_id();
    $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
    $args=array(
        'post_type' => 'pet_profile',
        'posts_per_page' => -1,
        'paged' => $paged,
        'author' => $user_id
    );
    $wp_query = new WP_Query($args);
    $i = 0;
    if ($wp_query->have_posts()) {
        while ( $wp_query->have_posts() ) : $wp_query->the_post(); 
            $mypod = pods( 'pet_profile', get_the_id() ); 
            $smarttag_id_number = $mypod->display('smarttag_id_number');
            $subscriptionId  = $mypod->display("smarttag_subscription_id");
            if (!empty($subscriptionId)) {
                $subscription   = wcs_get_subscription($subscriptionId);
                $date           = $subscription->get_date("end");
                $date           = date_parse_from_format('Y-m-d H:i:s',$date);
                $time           = mktime(0, 0, 0, $date['month'], $date['day'], $date['year']);
                $date           = date("m/d/Y", $time);
                // $subscription = wc_get_order($subscriptionId);
                // print_r($subscription->get_items());
                foreach( $subscription->get_items() as $item_id => $product_subscription ){
                    // Get the name
                    $product_name = $product_subscription['name']." (Expires: ".$date.")";

                    // print_r($product_subscription);
                    $variationId  = $product_subscription['variation_id'];
                }
            }else{
                $product_name = '';
            }
            
            ?>
            <div class="bottom-border-box">
                <h3>Registered Pet <?php echo ++$i; ?></h3>
                <div class="row">
                    <div class="col-sm-3 rmb-15">
                        <?php echo get_the_post_thumbnail(); ?>
                    </div>
                    <div class="col-sm-5 rmb-15">
                        <strong>Pet Name:</strong> <span class="name"><?php echo get_the_title(); ?></span>
                        <br>
                        <strong>Pet Type:</strong> <span><?php echo $mypod->display('pet_type'); ?></span>
                        <br>
                        <strong>IDTag Serial Number:</strong> <span class="name"><?php echo $mypod->display('smarttag_id_number'); ?></span>
                        <br>
                        <strong>ID Tag Plan:</strong> <span><?php echo $product_name; ?></span>
                    </div>
                    <div class="col-sm-4 mb-elements">                        
                        <form action="/my-account/order-print-lost-pet-poster-form" method="post" class="custom-form">
                            <input type="hidden" name="post_id" value="<?php echo get_the_ID(); ?>">
                            <input type="hidden" name="smarttagid" value="<?php echo $smarttag_id_number; ?>">
                            <p><button type="submit" class="replacement-tag button view site-btn-red width-100"><strong>Print Lost Pet Poster</strong> <i class="fa fa-caret-right"></i></button></p>
                        </form>
                    </div>
                </div>
            </div>
        <?php 
        endwhile;
        $total_pages = $wp_query->max_num_pages;
        if ($total_pages > 1){

            $current_page = max(1, get_query_var('paged'));

            echo paginate_links(array(
                'base' => get_pagenum_link(1) . '%_%',
                'format' => 'page/%#%',
                'current' => $current_page,
                'total' => $total_pages,
                'prev_text'    => __('« prev'),
                'next_text'    => __('next »'),
            ));
        }?>
        <?php
    } else{
        echo "Sorry, No pet found";
    }
}

add_action( 'woocommerce_account_order-print-lost-pet-poster-form_endpoint', 'my_account_endpoint_content_for_order_print_lost_pet_poster_form' );
function my_account_endpoint_content_for_order_print_lost_pet_poster_form() {
    echo '<div class="page-heading"><h1>Order Print Lost Pet Poster</h1></div>';
    if (isset($_POST['post_id'])) {
        $postId         = $_POST['post_id'];
        $post           = get_post($postId); 
        $authid         = $post->post_author;
        $phoneNum       = get_user_meta($authid, 'primary_home_number');
        $phoneNum       = $phoneNum[0];
        $mypod          = pods( 'pet_profile', $postId );
        $petType        = $mypod->display('pet_type');
        $breed          = $mypod->display('primary_breed');
        $color          = $mypod->display('primary_color');
        $addInfo        = $mypod->display('unique_features');
        $serialNumber   = $mypod->display('smarttag_id_number');
        if (!empty(get_the_post_thumbnail_url($postId))) {
            $imageUrl = get_the_post_thumbnail_url($postId);
        }else{
            $imageUrl = get_bloginfo('template_url')."-child/images/logo-icon.png";
        }
        ?>
        <div class="row middle-border-row small-poster-row">
            <div class="col-sm-6 rmb-30">
                <div class="contact-form">
                    <h3>Edit Lost Pet Poster</h3>
                    <div class="field-wrap">
                        <div class="field-div">
                            <label>*Pet Name:</label>
                            <input type="text" name="pet_name" class="pet-name" value="<?php echo $post->post_title; ?>" required="" >
                        </div>
                    </div>
                    <div class="field-wrap two-fields-wrap">
                        <div class="field-div">
                            <label>*Pet Type & Breed:</label>
                            <input type="text" name="pet_type" class="pet-type" value="<?php echo $petType; ?>" required="" >
                        </div>
                        <div class="field-div">
                            <label></label>
                            <input type="text" name="pet_breed" class="pet-breed" value="<?php echo $breed; ?>" required="" >
                        </div>
                    </div>
                    <div class="field-wrap">
                        <div class="field-div">
                            <label>*Color(s):</label>
                            <input type="text" name="color" class="color" value="<?php echo $color; ?>" required="" >
                        </div>
                    </div>
                    <div class="field-wrap">
                        <div class="field-div">
                            <label>*Phone Number:</label>
                            <input type="text" name="phone_number" class="phone-number" value="<?php echo $phoneNum; ?>" required="" >
                        </div>
                    </div>
                    <div class="field-wrap">
                        <div class="field-div">
                            <label>*SmartTag Id Number:</label>
                            <input type="text" name="serial_number" class="serial-number" value="<?php echo $serialNumber; ?>" disabled="disabled" required="" >
                        </div>
                    </div>
                    <div class="field-wrap">
                        <div class="field-div">
                            <label>*Reward:</label>
                            <input type="number" name="reward" class="reward" value="" required="" >
                        </div>
                    </div>
                    <div class="field-wrap">
                        <div class="field-div">
                            <label>*Additional Information:</label>
                            <textarea class="add-info" name="add_info" required="" ><?php echo $addInfo; ?></textarea>
                            <div class="field-notice mb-15" style="margin-top: -15px;">Character Count Limit: 250</div>
                        </div>
                    </div>
                    <div class="field-wrap two-fields-wrap">
                        <div class="field-div">
                            <div class="mb-15">
                                <img src="<?php echo get_the_post_thumbnail_url($postId); ?>" class="pet-current-image" name="pet_current_image">
                            </div>
                        </div>
                        <div class="field-div">
                            <div class="mb-15">
                                <input type="checkbox" name="current_image" class="current-image" checked="checked"> <strong>Use Current Pet Image</strong>
                            </div>
                        </div>
                    </div>
                    <div class="field-wrap">
                        <div class="field-div">
                            <label>Upload New Pet Image:</label>
                            <input type="file" name="pet_image" class="pet-image" >
                            <div class="field-notice">File must be less than 2 Mb<br>Suggested Dimension Size: 1188px X 800px<br>Allowed file types: .png/ .gif/ .jpg/ .jpeg</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="print-poster-col" style="line-height: 1.5; color: #3c3c3c; font-family: 'Asap', sans-serif; font-size: 14px; border: 1px solid #679fe1; padding: 15px; margin-bottom: 25px;">
                    <div class="print-poster-inner">
                        <h2 style="font-size: 42px;font-weight: 700;margin: 0 0 15px 0;color: #dc2727;text-align: center;line-height: 1.1 !important;text-transform: uppercase;">Lost Pet</h2>
                        <div class="bordered-poster-wrap" style="border: 3px solid #dc2727; padding: 8px; margin-bottom: 15px;">
                            <div class="bordered-poster mb-15">
                                <table cellpadding="0" cellspacing="0" style="width: 100%; border-collapse: collapse; margin-bottom: 0;">
                                    <tr>
                                        <td style="width: 50%; vertical-align: top; padding: 0; border: none; font-size: 14px;">
                                            <p style="font-weight: 600; font-size: 18px; margin-bottom: 10px;"><span class="dog-name">"<?php echo $post->post_title; ?>"</span></p>
                                            <span class="poster-type"><?php echo $petType; ?></span>, <span class="poster-breed"><?php echo $breed; ?></span>
                                            <br>
                                            Color: <span class="poster-color"><?php echo $color; ?></span>
                                            <br>
                                            ID Tag #: <span class="poster-id"><?php echo $serialNumber; ?>
                                            </span>
                                        </td>
                                        <td style="width: 50%; vertical-align: top; padding: 0; border: none; font-size: 14px;">
                                            <p style="font-weight: 600; font-size: 18px; margin-bottom: 10px; padding: 0;">REWARD <span style="color: #dc2727;" class="user-reward">$100</span></p>
                                            <strong>Additional Info:</strong>
                                            <br>
                                            <span class="extra-info"><?php echo $addInfo; ?></span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" style="text-align: center; color: #dc2727; font-size: 18px; text-transform: uppercase; padding: 0; border: none; font-size: 14px;">
                                            <p style="margin-bottom: 20px; margin-top: 20px; font-size: 18px;">
                                                Please call with any info:
                                                <br>
                                                <span class="poster-phone-number"><?php echo $phoneNum; ?></span>
                                            </p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" style="text-align: center; padding: 0; border: none; font-size: 14px;">
                                            <p style="margin-bottom: 15px; text-align: center;">
                                                <img src="<?php echo $imageUrl; ?>" alt="image" style="width: auto; height: auto; max-width: 100%; display: inline-block;" class="poster-pet-image" />
                                            </p>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <div class="poster-info-table-wrap">
                            <table class="poster-info-table" cellspacing="0" cellpadding="0" style="width: 100%; border-collapse: collapse; margin-bottom: 0;">
                                <td style="text-align: left; color: #3c3c3c; padding: 0; border: none; font-size: 14px;">
                                    <img src="<?php bloginfo('template_url'); ?>-child/images/logo-icon.png" alt="image" style="width: 50px; height: auto;" />
                                </td>
                                <td  style="text-align: right; color: #3c3c3c; font-size: 14px; padding: 0; border: none; font-size: 14px; font-weight: 600;">    
                                    To Report This Dog Found , Enter ID Tag # on:
                                    <p style="font-size: 28px; font-weight: 600; margin: 0 0 0 0; color: #3c3c3c; line-height: 1.2;">WWW.IDTAG.COM</p>
                                </td>
                            </table>
                        </div>
                    </div>
                </div>
                <p class="text-right mb-25">
                    <a href="javascript:;" class="site-btn site-btn-light-blue width-70 text-center see-big-poster">See Full-Size Preview</a>
                </p>
                <p class="text-right">
                    <a href="javascript:;" class="site-btn site-btn-red width-70 text-center print-btn">Confirm and Print <i class="fa fa-caret-right"></i></a>
                </p>
            </div>
        </div>
        <div class="row big-poster-row">
            <div class="col-sm-8 rmb-30 big-poster-div">
                <div class="print-poster-col" style="line-height: 1.5; color: #3c3c3c; font-family: 'Asap', sans-serif; font-size: 16px; border: 1px solid #679fe1; padding: 30px; margin-bottom: 30px;">
                    <div class="print-poster-inner">
                        <h2 style="font-size: 56px;font-weight: 700;margin: 0 0 15px 0;color: #dc2727;text-align: center;line-height: 0.9 !important;text-transform: uppercase;">Lost Pet</h2>
                        <div class="bordered-poster-wrap" style="border: 5px solid #dc2727; padding: 8px; margin-bottom: 20px;">
                            <div class="bordered-poster mb-15">
                                <table cellpadding="0" cellspacing="0" style="width: 100%; border-collapse: collapse; margin-bottom: 0;">
                                    <tr>
                                        <td style="width: 50%; vertical-align: top; padding: 0; border: none; font-size: 16px;">
                                            <p style="font-weight: 600; font-size: 28px; margin-bottom: 10px;"><span class="dog-name">"<?php echo $post->post_title; ?>"</span></p>
                                            <span class="poster-type"><?php echo $petType; ?></span>, <span class="poster-breed"><?php echo $breed; ?></span>
                                            <br>
                                            Color: <span class="poster-color"><?php echo $color; ?></span>
                                            <br>
                                            ID Tag #: <span class="poster-id"><?php echo $serialNumber; ?>
                                            </span>
                                        </td>
                                        <td style="width: 50%; vertical-align: top; padding: 0; border: none; font-size: 16px;">
                                            <p style="font-weight: 600; font-size: 28px; margin-bottom: 10px; padding: 0;">REWARD <span style="color: #dc2727;" class="user-reward user-reward-main">$100</span></p>
                                            <strong>Additional Info:</strong>
                                            <br>
                                            <span class="extra-info"><?php echo $addInfo; ?></span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" style="text-align: center; color: #dc2727; font-size: 16px; text-transform: uppercase; padding: 0; border: none; font-size: 14px;">
                                            <p style="margin-bottom: 30px; margin-top: 30px; font-size: 28px; line-height: 1.2;">
                                                Please call with any info:
                                                <br>
                                                <span class="poster-phone-number"><?php echo $phoneNum; ?></span>
                                            </p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" style="text-align: center; padding: 0; border: none; font-size: 16px;">
                                            <p style="margin-bottom: 20px; text-align: center;">
                                                <img src="<?php echo $imageUrl; ?>" alt="image" style="width: auto; height: auto; max-width: 100%; display: inline-block;" class="poster-pet-image poster-pet-image-main" />
                                            </p>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <div class="poster-info-table-wrap">
                            <table class="poster-info-table" cellspacing="0" cellpadding="0" style="width: 100%; border-collapse: collapse; margin-bottom: 0;">
                                <td style="text-align: left; color: #3c3c3c; padding: 0; border: none; font-size: 16px;">
                                    <img src="<?php bloginfo('template_url'); ?>-child/images/logo-icon.png" alt="image" style="width: 70px; height: auto;" />
                                </td>
                                <td  style="text-align: right; color: #3c3c3c; font-size: 14px; padding: 0; border: none; font-size: 16px; font-weight: 600;">    
                                    To Report This Dog Found , Enter ID Tag # on:
                                    <p style="font-size: 28px; font-weight: 600; margin: 0 0 0 0; color: #3c3c3c; line-height: 1.2;">WWW.IDTAG.COM</p>
                                </td>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="mb-25">
                    <a href="javascript:;" class="site-btn site-btn-light-blue text-center width-100 download-pdf">Download PDF <i class="fa fa-caret-right"></i></a>
                </div>
                <div class="mb-25">
                    <a href="javascript:;" class="site-btn site-btn-red text-center width-100 print-btn">Print <i class="fa fa-caret-right"></i></a>
                </div>
                <h4>Purchase 25 Color Copies</h4>
                • High quality prints
                <br>
                • Rushed overnight shipping available
                <div class="mb-20"></div>
                <div class="mb-25">
                    <a href="javascript:;" class="site-btn site-btn-light-blue width-100 text-center edit-small-poster"><i class="fa fa-caret-left"></i> Edit Poster</a>
                </div>
                <div>
                    <a href="javascript:;" class="site-btn site-btn-red text-center width-100">Purchase Posters $39.95 <i class="fa fa-caret-right"></i></a>
                </div>
            </div>
        </div>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script type="text/javascript">
            jQuery(document).ready(function($){
                jQuery(".pet-name").change(function(){
                    $("span.dog-name").text('"'+$(this).val()+'"');
                });
                jQuery(".pet-type").change(function(){
                    $("span.poster-type").text($(this).val());
                });
                jQuery(".pet-breed").change(function(){
                    $("span.poster-breed").text($(this).val());
                });
                jQuery(".color").change(function(){
                    $("span.poster-color").text($(this).val());
                });
                jQuery(".phone-number").change(function(){
                    $("span.poster-phone-number").text($(this).val());
                });
                jQuery(".reward").change(function(){
                    $("span.user-reward").text("$"+$(this).val());
                });
                jQuery(".add-info").change(function(){
                    $("span.extra-info").text($(this).val());
                });
                jQuery(".current-image").change(function(){
                    if ($(this).prop('checked') == false) {
                        $image = document.querySelector('input[type=file]');
                        console.log($image);
                        readURLL($image,'poster-pet-image');
                    }else{
                        var image = $(".pet-current-image").attr('src');
                        $('.poster-pet-image').attr('src',image);
                    }
                });
                jQuery(".pet-image").change(function(){
                    if ($('.current-image').prop('checked') == false) {
                        var image = document.querySelector('input[type=file]');
                        console.log(image);
                        readURLL(image,'poster-pet-image');
                    }
                });
                jQuery(".download-pdf").on('click',function(){
                    var dogName         = $(".pet-name").val();
                    var type            = $(".pet-type").val();
                    var breed           = $(".pet-breed").val();
                    var color           = $(".color").val();
                    var phoneNumber     = $(".phone-number").val();
                    var serialNumber    = $(".serial-number").val();
                    var reward          = $(".user-reward-main").text();
                    var extraInfo       = $(".add-info").val();
                    var image           = $(".poster-pet-image-main").attr('src');
                    $.ajax({
                        type: 'POST',
                        url: ajaxurl,
                        data: {
                            'action':'downloadPdf',
                            'dogName':dogName,
                            'type':type,
                            'breed':breed,
                            'color':color,
                            'phoneNumber':phoneNumber,
                            'serialNumber':serialNumber,
                            'reward':reward,
                            'extraInfo':extraInfo,
                            'image':image,
                        },
                        xhrFields: {
                            responseType: 'blob'
                        },
                        success: function (response, status, xhr) {

                            var filename = "";                   
                            var disposition = xhr.getResponseHeader('Content-Disposition');

                             if (disposition) {
                                var filenameRegex = /filename[^;=\n]*=((['"]).*?\2|[^;\n]*)/;
                                var matches = filenameRegex.exec(disposition);
                                if (matches !== null && matches[1]) filename = matches[1].replace(/['"]/g, '');
                            } 
                            var linkelem = document.createElement('a');
                            try {
                                                       var blob = new Blob([response], { type: 'application/octet-stream' });                        

                                if (typeof window.navigator.msSaveBlob !== 'undefined') {
                                    //   IE workaround for "HTML7007: One or more blob URLs were revoked by closing the blob for which they were created. These URLs will no longer resolve as the data backing the URL has been freed."
                                    window.navigator.msSaveBlob(blob, filename);
                                } else {
                                    var URL = window.URL || window.webkitURL;
                                    var downloadUrl = URL.createObjectURL(blob);

                                    if (filename) { 
                                        // use HTML5 a[download] attribute to specify filename
                                        var a = document.createElement("a");

                                        // safari doesn't support this yet
                                        if (typeof a.download === 'undefined') {
                                            window.location = downloadUrl;
                                        } else {
                                            a.href = downloadUrl;
                                            a.download = filename;
                                            document.body.appendChild(a);
                                            a.target = "_blank";
                                            a.click();
                                        }
                                    } else {
                                        window.location = downloadUrl;
                                    }
                                }   

                            } catch (ex) {
                                console.log(ex);
                            } 
                        }
                    });
                });

            });
                
        </script>
        <?php
    }
}

/*Sign Up Pet Alerts*/

add_action( 'woocommerce_account_sign-up-pet-alerts_endpoint', 'my_account_endpoint_content_for_sign_up_pet_alerts' );
function my_account_endpoint_content_for_sign_up_pet_alerts() {
    echo '<div class="page-heading"><h1>Sign Up For Alerts</h1></div>';
    $user_id = get_current_user_id();
    $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
    $args=array(
        'post_type' => 'pet_profile',
        'posts_per_page' => -1,
        'paged' => $paged,
        'author' => $user_id
    );                      
    $wp_query = new WP_Query($args);
    $i = 0;
    if ($wp_query->have_posts()) {
        while ( $wp_query->have_posts() ) : $wp_query->the_post(); 
            $mypod = pods( 'pet_profile', get_the_id() ); 
            $smarttag_id_number = $mypod->display('smarttag_id_number');
            $microchip_id_number = $mypod->display('microchip_id_number');
            $subscriptionId  = $mypod->display("smarttag_subscription_id");
            if (!empty($subscriptionId)) {
                $subscription   = wcs_get_subscription($subscriptionId);
                $date           = $subscription->get_date("end");
                $date           = date_parse_from_format('Y-m-d H:i:s',$date);
                $time           = mktime(0, 0, 0, $date['month'], $date['day'], $date['year']);
                $date           = date("m/d/Y", $time);
                // $subscription = wc_get_order($subscriptionId);
                // print_r($subscription->get_items());
                foreach( $subscription->get_items() as $item_id => $product_subscription ){
                    // Get the name
                    $product_name = $product_subscription['name']." (Expires: ".$date.")";

                    // print_r($product_subscription);
                    $variationId  = $product_subscription['variation_id'];
                }
            }else{
                $product_name = '';
            }
            
            ?>
            <div class="bottom-border-box">
                <h3>Registered Pet <?php echo ++$i; ?></h3>
                <div class="row">
                    <div class="col-sm-3 rmb-15">
                        <?php echo get_the_post_thumbnail(); ?>
                    </div>
                    <div class="col-sm-5 rmb-15">
                        <strong>Pet Name:</strong> <span class="name"><?php echo get_the_title(); ?></span>
                        <br>
                        <strong>Pet Type:</strong> <span><?php echo $mypod->display('pet_type'); ?></span>
                        <br>
                        <strong>IDTag Serial Number:</strong> <span class="name"><?php echo $mypod->display('smarttag_id_number'); ?></span>
                        <br>
                        <strong>IDTag Microchip Number:</strong> <span class="name"><?php echo $microchip_id_number; ?></span>
                        <br>
                        <strong>ID Tag Plan:</strong> <span><?php echo $product_name; ?></span>
                    </div>
                    <div class="col-sm-4 mb-elements">    
                        <?php if (!empty($product_name)) { 
                                $paltinumPlanVariationId = array(6853,6854,6855);
                                $variationId = (int)$variationId;
                                if (in_array($variationId, $paltinumPlanVariationId)) { ?>
                                    <form action="/my-account/single-sign-up-pet-alerts" method="post" class="custom-form">
                                        <input type="hidden" name="post_id" value="<?php echo get_the_ID(); ?>">
                                        <input type="hidden" name="petProtectionPlan" value="<?php echo $product_name; ?>">
                                        <p><button type="submit" class="sing-up-for-alerts site-btn-red">Sing Up for Alerts <i class="fa fa-caret-right"></i></button></p>
                                    </form>
                                <?php }else{ 
                                    ?>
                                    <p><a href="<?php echo 'https://idtag.agiliscloud.com/my-account/view-subscription/'.$subscriptionId.'/'; ?>" class="button view site-btn-red">Upgrade Protection Plan <i class="fa fa-caret-right"></i></a></p>
                                    <p style="color: red;">Smart Tag's Alerts service is for Platinum Plan only, Upgrade Pet Protection Plan to receive alerts.</p>
                                <?php }
                            }else{ ?>
                                <p style="color: red;">Smart Tag's Alerts service is for Platinum Plan only, Purchase Pet Protection Plan to receive alerts.</p>
                        <?php } ?>
                    </div>
                </div>
            </div>
        <?php 
        endwhile;
        $total_pages = $wp_query->max_num_pages;
        if ($total_pages > 1){

            $current_page = max(1, get_query_var('paged'));

            echo paginate_links(array(
                'base' => get_pagenum_link(1) . '%_%',
                'format' => 'page/%#%',
                'current' => $current_page,
                'total' => $total_pages,
                'prev_text'    => __('« prev'),
                'next_text'    => __('next »'),
            ));
        }
    } else{
        echo "Sorry, No pet found";
    }
 }

 add_action( 'woocommerce_account_single-sign-up-pet-alerts_endpoint', 'my_account_endpoint_content_for_single_sign_up_pet_alerts' );
function my_account_endpoint_content_for_single_sign_up_pet_alerts() {
    echo '<div class="page-heading"><h1>Sign Up For Alerts</h1></div>';
    $userId     = get_current_user_id();
    // print_r(get_user_meta($userId));
    $heartworm  = get_user_meta($userId,"heartworm_medication_alert",true);
    $fleaTick   = get_user_meta($userId,"flea_tick_medication_alert",true);
    $vetAppo    = get_user_meta($userId,"vet_appointments_alert",true);
    $medica     = get_user_meta($userId,"medication_alert",true);
    $rabiesShot = get_user_meta($userId,"rabies_shot_alert",true);
    $tagLicens  = get_user_meta($userId,"tag_licensing_alert",true);

    $totalCustm = get_user_meta($userId,"total_custom_alert",true);
    if (isset($totalCustm[0])) {
        $totalCustm = $totalCustm[0];
    }else{
        $totalCustm = 0;
    }

    if (!empty($heartworm)) {
        $heartwormCheck = "checked";
        $heartwormDisab = "";
        $heartwormClass = "";
    }else{
        $heartwormCheck = "";
        $heartwormDisab = "disabled";
        $heartwormClass = "disabled";
    }

    if (!empty($fleaTick)) {
        $fleaTickCheck = "checked";
        $fleaTickDisab = "";
        $fleaTickClass = "";
    }else{
        $fleaTickCheck = "";
        $fleaTickDisab = "disabled";
        $fleaTickClass = "disabled";
    }

    if (!empty($vetAppo)) {
        $vetAppoCheck = "checked";
        $vetAppoDisab = "";
        $vetAppoClass = "";
    }else{
        $vetAppoCheck = "";
        $vetAppoDisab = "disabled";
        $vetAppoClass = "disabled";
    }

    if (!empty($medica)) {
        $medicaCheck = "checked";
        $medicaDisab = "";
        $medicaClass = "";
    }else{
        $medicaCheck = "";
        $medicaDisab = "disabled";
        $medicaClass = "disabled";
    }
    
    if (!empty($rabiesShot)) {
        $rabiesShotCheck = "checked";
        $rabiesShotDisab = "";
        $rabiesShotClass = "";
    }else{
        $rabiesShotCheck = "";
        $rabiesShotDisab = "disabled";
        $rabiesShotClass = "disabled";
    }

    if (!empty($tagLicens)) {
        $tagLicensCheck = "checked";
        $tagLicensDisab = "";
        $tagLicensClass = "";
    }else{
        $tagLicensCheck = "";
        $tagLicensDisab = "disabled";
        $tagLicensClass = "disabled";
    }

    if (isset($_POST['post_id'])) {
        $postId             = $_POST['post_id'];
        $petProtectionPlan  = $_POST['petProtectionPlan'];
        $mypod = pods( 'pet_profile', $postId );
    ?>
        <div class="set-alerts-wrap">
            <h4>
                <i>Alerts for Dog Name:</i>
            </h4>
            <div class="bottom-border-box">
                <div class="row">
                    <div class="col-sm-3 rmb-15">
                        <?php echo get_the_post_thumbnail($postId); ?>

                    </div>
                    <div class="col-sm-9">
                        <strong>Pet Name:</strong> <?php echo get_the_title($postId); ?>
                        <br>
                        <!-- Dog > Bichon Frise
                        <br>
                        <strong>IDTag Serial Number:</strong> 00555555
                        <br>
                        <strong>Microchip Serial:</strong> 055555555
                        <br>
                        <strong>Platinum ID Tag Lifetime Plan</strong> (Expires: 10/10/2030) -->

                        <strong>Pet Type:</strong> <span><?php echo $mypod->display('pet_type'); ?></span>
                        <br>
                        <strong>IDTag Serial Number:</strong> <span class="name"><?php echo $mypod->display('smarttag_id_number'); ?></span>
                        <br>
                        <strong>Microchip Number:</strong> <span class="name"><?php echo $mypod->display('microchip_id_number'); ?></span>
                        <br>
                        <strong>ID Tag Plan:</strong> <span><?php echo $petProtectionPlan; ?></span>
                    </div>
                </div>
            </div>
            <div class="row middle-border-row mb-15">
                <div class="col-sm-6 standard-alerts rmb-15">
                    <h4 class="color-light-blue">Standard Alerts</h4>
                    <p>
                        <input type="checkbox" name="" <?php echo $heartwormCheck; ?> class="heartworm-alert" /> <strong>Heartworm Medication</strong>
                    </p>
                    <p>
                        <input type="checkbox" name="" class="flea-tick" <?php echo $fleaTickCheck; ?> /> <strong>Flea & Tick Medication</strong>
                    </p>
                    <p>
                        <input type="checkbox" name="" <?php echo $vetAppoCheck; ?> class="vet-appo" /> <strong>Vet Appointments</strong>
                    </p>
                    <p>
                        <input type="checkbox" name="" <?php echo $medicaCheck; ?> class="medication-alert" /> <strong>Medication Alerts</strong>
                    </p>
                    <p>
                        <input type="checkbox" name="" <?php echo $rabiesShotCheck; ?> class="rabies-shot" /> <strong>Rabies Shot Alerts</strong>
                    </p>
                    <p>
                        <input type="checkbox" name="" <?php echo $tagLicensCheck; ?> class="tag-licens" /> <strong>Tag Licensing Alerts</strong>
                    </p>
                </div>
                <div class="col-sm-6 standard-alerts">
                    <h4 class="color-light-blue">Custom Alerts</h4>
                    <p>
                        <input type="checkbox" name="" class="custom-alert" /> <strong>Create a Custom Alert</strong>
                    </p>
                </div>
            </div>
            <div class="acc-blue-box acc-plus-minus">
                <div class="acc-blue-head">
                    Heartworm Medication Alert
                    <i class="fa fa-plus"></i>
                </div>
                <div class="acc-blue-content">
                    <form>
                        <div class="contact-form">
                            <input type="hidden" name="alert_name" value="heartworm_medication_alert" class="heartworm-alert">
                            <div class="field-wrap">
                                <div class="field-div">
                                    <label>*Choose day of the week to receive alert:</label>
                                    <div class="multi-check-fields mb-15">
                                        <span>
                                            <input type="radio" name="day_of_week" value="7" class="heartworm-alert recieve-alert" <?php if (!empty($heartworm)) {
                                                if (isset($heartworm['day_of_week']) && $heartworm['day_of_week'] == 7) {
                                                    echo "checked";
                                                }
                                            } ?> required="" /> Sunday
                                        </span>
                                        <span>
                                            <input type="radio" name="day_of_week" value="1" class="heartworm-alert recieve-alert" <?php if (!empty($heartworm)) { 
                                                if (isset($heartworm['day_of_week']) && $heartworm['day_of_week'] == 1) {
                                                    echo "checked";
                                                }
                                            } ?> required="" /> Monday
                                        </span>
                                        <span>
                                            <input type="radio" name="day_of_week" value="2" class="heartworm-alert recieve-alert" <?php if (!empty($heartworm)) {
                                                if (isset($heartworm['day_of_week']) && $heartworm['day_of_week'] == 2) {
                                                    echo "checked";
                                                }
                                            } ?> required="" /> Tuesday
                                        </span>
                                        <span>
                                            <input type="radio" name="day_of_week" value="3" class="heartworm-alert recieve-alert" <?php if (!empty($heartworm)) {
                                                if (isset($heartworm['day_of_week']) && $heartworm['day_of_week'] == 3) {
                                                    echo "checked";
                                                }
                                            } ?> required="" /> Wednesday
                                        </span>
                                        <span>
                                            <input type="radio" name="day_of_week" value="4" class="heartworm-alert recieve-alert" <?php if (!empty($heartworm)) {
                                                if (isset($heartworm['day_of_week']) && $heartworm['day_of_week'] == 4) {
                                                    echo "checked";
                                                }
                                            } ?> required="" /> Thursday
                                        </span>
                                        <span>
                                            <input type="radio" name="day_of_week" value="5" class="heartworm-alert recieve-alert" <?php if (!empty($heartworm)) {
                                                if (isset($heartworm['day_of_week']) && $heartworm['day_of_week'] == 5) {
                                                    echo "checked";
                                                }
                                            } ?> required="" /> Friday
                                        </span>
                                        <span>
                                            <input type="radio" name="day_of_week" value="6" class="heartworm-alert recieve-alert" <?php if (!empty($heartworm)) {
                                                if (isset($heartworm['day_of_week']) && $heartworm['day_of_week'] == 6) {
                                                    echo "checked";
                                                }
                                            } ?> required="" /> Saturday
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="field-wrap two-fields-wrap">
                                <div class="field-div">
                                    <label>*Choose time of day to receive alert:</label>
                                    <select name="time_of_day" class="heartworm-alert" >
                                        <?php for($i = 1; $i <= 24; $i++): 
                                            if (!empty($heartworm)) {
                                                if (isset($heartworm['time_of_day']) && $heartworm['time_of_day'] == $i) {
                                                    echo '<option selected value="'.$i.'">'. date("h.i A", strtotime("$i:00")).'</option>';
                                                }else{
                                                    echo '<option value="'.$i.'">'. date("h.i A", strtotime("$i:00")).'</option>';
                                                }
                                            }else{
                                                echo '<option value="'.$i.'">'. date("h.i A", strtotime("$i:00")).'</option>';  
                                            }
                                            
                                        endfor; ?>
                                    </select>
                                </div>
                                <div class="field-div">
                                    <label>*Choose first day to receive this alert:</label>
                                    <input type="text" name="alert_date" class="first-day heartworm-alert" required="" value="<?php if (!empty($heartworm)) {
                                            if (isset($heartworm['alert_date']) && !empty($heartworm['alert_date'])) {
                                                echo $heartworm['alert_date'];
                                            }else{
                                                echo date("F d, Y");
                                            }
                                        }else{
                                            echo date("F d, Y");
                                        } ?>" >
                                </div>
                            </div>
                            <div class="field-wrap two-fields-wrap">
                                <div class="field-div">
                                    <label>*Frequency of alert:</label>
                                    <select class="heartworm-alert" name="frequency_of_alert">
                                        <?php 
                                            $i = 1;
                                            while ( $i <= 12 ) {
                                                if (!empty($heartworm)) {
                                                    if (isset($heartworm['frequency_of_alert']) && $heartworm['frequency_of_alert'] == $i) {
                                                        if ($i == 1) {
                                                            echo '<option selected value="'.$i.'">Every Month</option>';
                                                        }else{
                                                            echo '<option selected value="'.$i.'">Every '.$i.' Months</option>';
                                                        }
                                                    }else{
                                                        if ($i == 1) {
                                                            echo '<option  value="'.$i.'">Every Month</option>';
                                                        }else{
                                                            echo '<option  value="'.$i.'">Every '.$i.' Months</option>';
                                                        }
                                                    }
                                                }else{
                                                    if ($i == 1) {
                                                    echo '<option value="'.$i.'">Every Month</option>';
                                                    }else{
                                                        echo '<option value="'.$i.'">Every '.$i.' Months</option>';
                                                    }  
                                                }
                                                $i++;  
                                            }
                                        ?>
                                    </select>
                                </div>
                                <div class="field-div">
                                    <label>*How would you like to receive this alert?:</label>
                                    <div class="multi-check-fields mb-15">
                                        <span>
                                            <input type="radio" name="recieve_alert" value="email" required="" class="heartworm-alert alert-type" <?php if (!empty($heartworm)) {
                                                if (isset($heartworm['recieve_alert']) && $heartworm['recieve_alert'] == "email") {
                                                    echo "checked='checked'";
                                                }
                                            } ?> /> By Email
                                        </span>
                                        <span>
                                            <input type="radio" name="recieve_alert" value="phone" required="" class="heartworm-alert alert-type" <?php if (!empty($heartworm)) {
                                                if (isset($heartworm['recieve_alert']) && $heartworm['recieve_alert'] == "phone") {
                                                    echo "checked='checked'";
                                                }
                                            } ?> /> By Phone, VIA Text Message
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="field-wrap">
                                <div class="field-div">
                                    <label>Add Notes (Optional):</label>
                                    <input type="text" name="note" placeholder="Write Notes..." class="heartworm-alert" value="<?php if (!empty($heartworm)) {
                                                if (!empty($heartworm['note'])) {
                                                    echo $heartworm['note'];
                                                }
                                            } ?>" >
                                </div>
                            </div>
                            <div class="field-wrap two-fields-wrap">
                                <div class="field-div text-left">
                                    <input type="button" name="" value="Remove Alert" class="site-btn-red remove-sing-up-alert <?php echo $heartwormClass ?>" <?php echo $heartwormClass ?>/>
                                </div>
                                <div class="field-div text-right">
                                    <input type="button" name="" value="Save Alert" class="site-btn-red sing-up-alert" />
                                </div>
                            </div>
                            <div class="field-wrap">
                                <div class="field-notice"></div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="acc-blue-box acc-plus-minus">
                <div class="acc-blue-head">
                    Flea & Tick Medication
                    <i class="fa fa-plus"></i>
                </div>
                <div class="acc-blue-content">
                    <div class="contact-form">
                        <form>
                            <input type="hidden" name="alert_name" value="flea_tick_medication_alert" class="flea-tick">
                            <div class="field-wrap">
                                <div class="field-div">
                                    <label>*Choose day of the week to receive alert:</label>
                                    <div class="multi-check-fields mb-15">
                                        <span>
                                            <input type="radio" name="day_of_week" value="7" class="flea-tick recieve-alert" <?php if (!empty($fleaTick)) {
                                                if (isset($fleaTick['day_of_week']) && $fleaTick['day_of_week'] == 7) {
                                                    echo "checked";
                                                }
                                            } ?> /> Sunday
                                        </span>
                                        <span>
                                            <input type="radio" name="day_of_week" value="1" class="flea-tick recieve-alert" <?php if (!empty($fleaTick)) {
                                                if (isset($fleaTick['day_of_week']) && $fleaTick['day_of_week'] == 1) {
                                                    echo "checked";
                                                }
                                            } ?> /> Monday
                                        </span>
                                        <span>
                                            <input type="radio" name="day_of_week" value="2" class="flea-tick recieve-alert" <?php if (!empty($fleaTick)) {
                                                if (isset($fleaTick['day_of_week']) && $fleaTick['day_of_week'] == 2) {
                                                    echo "checked";
                                                }
                                            } ?> /> Tuesday
                                        </span>
                                        <span>
                                            <input type="radio" name="day_of_week" value="3" class="flea-tick recieve-alert" <?php if (!empty($fleaTick)) {
                                                if (isset($fleaTick['day_of_week']) && $fleaTick['day_of_week'] == 3) {
                                                    echo "checked";
                                                }
                                            } ?> /> Wednesday
                                        </span>
                                        <span>
                                            <input type="radio" name="day_of_week" value="4" class="flea-tick recieve-alert" <?php if (!empty($fleaTick)) {
                                                if (isset($fleaTick['day_of_week']) && $fleaTick['day_of_week'] == 4) {
                                                    echo "checked";
                                                }
                                            } ?> /> Thursday
                                        </span>
                                        <span>
                                            <input type="radio" name="day_of_week" value="5" class="flea-tick recieve-alert" <?php if (!empty($fleaTick)) {
                                                if (isset($fleaTick['day_of_week']) && $fleaTick['day_of_week'] == 5) {
                                                    echo "checked";
                                                }
                                            } ?> /> Friday
                                        </span>
                                        <span>
                                            <input type="radio" name="day_of_week" value="6" class="flea-tick recieve-alert" <?php if (!empty($fleaTick)) {
                                                if (isset($fleaTick['day_of_week']) && $fleaTick['day_of_week'] == 6) {
                                                    echo "checked";
                                                }
                                            } ?> /> Saturday
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="field-wrap two-fields-wrap">
                                <div class="field-div">
                                    <label>*Choose time of day to receive alert:</label>
                                    <select name="time_of_day" class="flea-tick" >
                                        <?php for($i = 1; $i <= 24; $i++): 
                                            if (!empty($fleaTick)) {
                                                if (isset($fleaTick['time_of_day']) && $fleaTick['time_of_day'] == $i) {
                                                    echo '<option selected value="'.$i.'">'. date("h.i A", strtotime("$i:00")).'</option>';
                                                }else{
                                                    echo '<option value="'.$i.'">'. date("h.i A", strtotime("$i:00")).'</option>';
                                                }
                                            }else{
                                                echo '<option value="'.$i.'">'. date("h.i A", strtotime("$i:00")).'</option>';  
                                            }
                                            
                                        endfor; ?>
                                    </select>
                                </div>
                                <div class="field-div">
                                    <label>*Choose first day to receive this alert:</label>
                                    <input type="text" name="alert_date" class="first-day flea-tick" value="<?php if (!empty($fleaTick)) {
                                            if (isset($fleaTick['alert_date']) && !empty($fleaTick['alert_date'])) {
                                                echo $fleaTick['alert_date'];
                                            }else{
                                                echo date("F d, Y");
                                            }
                                        }else{
                                            echo date("F d, Y");
                                        } ?>">
                                </div>
                            </div>
                            <div class="field-wrap two-fields-wrap">
                                <div class="field-div">
                                    <label>*Frequency of alert:</label>
                                    <select class="flea-tick" name="frequency_of_alert">
                                        <?php 
                                            $i = 1;
                                            while ( $i <= 12 ) {
                                                if (!empty($fleaTick)) {
                                                    if (isset($fleaTick['frequency_of_alert']) && $fleaTick['frequency_of_alert'] == $i) {
                                                        if ($i == 1) {
                                                            echo '<option selected value="'.$i.'">Every Month</option>';
                                                        }else{
                                                            echo '<option selected value="'.$i.'">Every '.$i.' Months</option>';
                                                        }
                                                    }else{
                                                        if ($i == 1) {
                                                            echo '<option  value="'.$i.'">Every Month</option>';
                                                        }else{
                                                            echo '<option  value="'.$i.'">Every '.$i.' Months</option>';
                                                        }
                                                    }
                                                }else{
                                                    if ($i == 1) {
                                                        echo '<option value="'.$i.'">Every Month</option>';
                                                    }else{
                                                        echo '<option value="'.$i.'">Every '.$i.' Months</option>';
                                                    }  
                                                }
                                                $i++;  
                                            }
                                        ?>
                                    </select>
                                </div>
                                <div class="field-div">
                                    <label>*How would you like to receive this alert?:</label>
                                    <div class="multi-check-fields mb-15">
                                        <span>
                                            <input type="radio" name="recieve_alert" value="email" class="flea-tick alert-type" <?php if (!empty($fleaTick)) {
                                                if (isset($fleaTick['recieve_alert']) && $fleaTick['recieve_alert'] == "email") {
                                                    echo "checked";
                                                }
                                            } ?> /> By Email
                                        </span>
                                        <span>
                                            <input type="radio" name="recieve_alert" value="phone" class="flea-tick alert-type" <?php if (!empty($fleaTick)) {
                                                if (isset($fleaTick['recieve_alert']) && $fleaTick['recieve_alert'] == "phone") {
                                                    echo "checked";
                                                }
                                            } ?> /> By Phone, VIA Text Message
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="field-wrap">
                                <div class="field-div">
                                    <label>Add Notes (Optional):</label>
                                    <input type="text" placeholder="Write Notes..." name="note" class="flea-tick" value="<?php if (!empty($fleaTick)) {
                                                if (!empty($fleaTick['note'])) {
                                                    echo $fleaTick['note'];
                                                }
                                            } ?>">
                                </div>
                            </div>
                            <div class="field-wrap two-fields-wrap">
                                <div class="field-div text-left">
                                    <input type="button" name="" value="Remove Alert" class="site-btn-red remove-sing-up-alert <?php echo $fleaTickClass; ?>" <?php echo $fleaTickClass; ?>/>
                                </div>
                                <div class="field-div text-right">
                                    <input type="button" name="" value="Save Alert" class="site-btn-red sing-up-alert" />
                                </div>
                            </div>
                            <div class="field-wrap">
                                <div class="field-notice"></div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="acc-blue-box acc-plus-minus">
                <div class="acc-blue-head">
                    Vet Appointments
                    <i class="fa fa-plus"></i>
                </div>
                <div class="acc-blue-content">
                    <div class="contact-form">
                        <form>
                            <input type="hidden" name="alert_name" value="vet_appointments_alert" class="vet-appo">
                            <div class="field-wrap">
                                <div class="field-div">
                                    <label>*Choose day of the week to receive alert:</label>
                                    <div class="multi-check-fields mb-15">
                                        <span>
                                            <input type="radio" name="day_of_week" value="7" class="vet-appo recieve-alert" <?php if (!empty($vetAppo)) {
                                                if (isset($vetAppo['day_of_week']) && $vetAppo['day_of_week'] == 7) {
                                                    echo "checked";
                                                }
                                            } ?> /> Sunday
                                        </span>
                                        <span>
                                            <input type="radio" name="day_of_week" value="1" class="vet-appo recieve-alert" <?php if (!empty($vetAppo)) {
                                                if (isset($vetAppo['day_of_week']) && $vetAppo['day_of_week'] == 1) {
                                                    echo "checked";
                                                }
                                            } ?> /> Monday
                                        </span>
                                        <span>
                                            <input type="radio" name="day_of_week" value="2" class="vet-appo recieve-alert" <?php if (!empty($vetAppo)) {
                                                if (isset($vetAppo['day_of_week']) && $vetAppo['day_of_week'] == 2) {
                                                    echo "checked";
                                                }
                                            } ?> /> Tuesday
                                        </span>
                                        <span>
                                            <input type="radio" name="day_of_week" value="3" class="vet-appo recieve-alert" <?php if (!empty($vetAppo)) {
                                                if (isset($vetAppo['day_of_week']) && $vetAppo['day_of_week'] == 3) {
                                                    echo "checked";
                                                }
                                            } ?> /> Wednesday
                                        </span>
                                        <span>
                                            <input type="radio" name="day_of_week" value="4" class="vet-appo recieve-alert" <?php if (!empty($vetAppo)) {
                                                if (isset($vetAppo['day_of_week']) && $vetAppo['day_of_week'] == 4) {
                                                    echo "checked";
                                                }
                                            } ?> /> Thursday
                                        </span>
                                        <span>
                                            <input type="radio" name="day_of_week" value="5" class="vet-appo recieve-alert" <?php if (!empty($vetAppo)) {
                                                if (isset($vetAppo['day_of_week']) && $vetAppo['day_of_week'] == 5) {
                                                    echo "checked";
                                                }
                                            } ?> /> Friday
                                        </span>
                                        <span>
                                            <input type="radio" name="day_of_week" value="6" class="vet-appo recieve-alert" <?php if (!empty($vetAppo)) {
                                                if (isset($vetAppo['day_of_week']) && $vetAppo['day_of_week'] == 6) {
                                                    echo "checked";
                                                }
                                            } ?> /> Saturday
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="field-wrap two-fields-wrap">
                                <div class="field-div">
                                    <label>*Choose time of day to receive alert:</label>
                                    <select name="time_of_day" class="vet-appo" >
                                        <?php for($i = 1; $i <= 24; $i++): 
                                            if (!empty($vetAppo)) {
                                                if (isset($vetAppo['time_of_day']) && $vetAppo['time_of_day'] == $i) {
                                                    echo '<option selected value="'.$i.'">'. date("h.i A", strtotime("$i:00")).'</option>';
                                                }else{
                                                    echo '<option value="'.$i.'">'. date("h.i A", strtotime("$i:00")).'</option>';
                                                }
                                            }else{
                                                echo '<option value="'.$i.'">'. date("h.i A", strtotime("$i:00")).'</option>';  
                                            }
                                            
                                        endfor; ?>
                                    </select>
                                </div>
                                <div class="field-div">
                                    <label>*Choose first day to receive this alert:</label>
                                    <input type="text" name="alert_date" class="first-day vet-appo" required="" value="<?php if (!empty($vetAppo)) {
                                            if (isset($vetAppo['alert_date']) && !empty($vetAppo['alert_date'])) {
                                                echo $vetAppo['alert_date'];
                                            }else{
                                                echo date("F d, Y");
                                            }
                                        }else{
                                            echo date("F d, Y");
                                        } ?>">
                                </div>
                            </div>
                            <div class="field-wrap two-fields-wrap">
                                <div class="field-div">
                                    <label>*Frequency of alert:</label>
                                    <select class="vet-appo" name="frequency_of_alert">
                                        <?php 
                                            $i = 1;
                                            while ( $i <= 12 ) {
                                                if (!empty($vetAppo)) {
                                                    if (isset($vetAppo['frequency_of_alert']) && $vetAppo['frequency_of_alert'] == $i) {
                                                        if ($i == 1) {
                                                            echo '<option selected value="'.$i.'">Every Month</option>';
                                                        }else{
                                                            echo '<option selected value="'.$i.'">Every '.$i.' Months</option>';
                                                        }
                                                    }else{
                                                        if ($i == 1) {
                                                            echo '<option  value="'.$i.'">Every Month</option>';
                                                        }else{
                                                            echo '<option  value="'.$i.'">Every '.$i.' Months</option>';
                                                        }
                                                    }
                                                }else{
                                                    if ($i == 1) {
                                                        echo '<option value="'.$i.'">Every Month</option>';
                                                    }else{
                                                        echo '<option value="'.$i.'">Every '.$i.' Months</option>';
                                                    } 
                                                }
                                                $i++;  
                                            }
                                        ?>
                                    </select>
                                </div>
                                <div class="field-div">
                                    <label>*How would you like to receive this alert?:</label>
                                    <div class="multi-check-fields mb-15">
                                        <span>
                                            <input type="radio" name="recieve_alert" value="email" class="vet-appo alert-type" <?php if (!empty($vetAppo)) {
                                                if (isset($vetAppo['recieve_alert']) && $vetAppo['recieve_alert'] == "email") {
                                                    echo "checked";
                                                }
                                            } ?> /> By Email
                                        </span>
                                        <span>
                                            <input type="radio" name="recieve_alert" value="phone" class="vet-appo alert-type" <?php if (!empty($vetAppo)) {
                                                if (isset($vetAppo['recieve_alert']) && $vetAppo['recieve_alert'] == "phone") {
                                                    echo "checked";
                                                }
                                            } ?> /> By Phone, VIA Text Message
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="field-wrap">
                                <div class="field-div">
                                    <label>Add Notes (Optional):</label>
                                    <input type="text" placeholder="Write Notes..." name="note" class="vet-appo" value="<?php if (!empty($vetAppo)) {
                                                if (!empty($vetAppo['note'])) {
                                                    echo $vetAppo['note'];
                                                }
                                            } ?>">
                                </div>
                            </div>
                            <div class="field-wrap two-fields-wrap">
                                <div class="field-div text-left">
                                    <input type="button" name="" value="Remove Alert" class="site-btn-red remove-sing-up-alert <?php echo $vetAppoClass; ?>" <?php echo $vetAppoClass; ?> />
                                </div>
                                <div class="field-div text-right">
                                    <input type="button" name="" value="Save Alert" class="site-btn-red sing-up-alert" />
                                </div>
                            </div>
                            <div class="field-wrap">
                                <div class="field-notice"></div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="acc-blue-box acc-plus-minus">
                <div class="acc-blue-head">
                    Medication Alerts
                    <i class="fa fa-plus"></i>
                </div>
                <div class="acc-blue-content">
                    <div class="contact-form">
                        <form>
                            <input type="hidden" name="alert_name" value="medication_alert" class="medication-alert">
                            <div class="field-wrap">
                                <div class="field-div">
                                    <label>*Choose day of the week to receive alert:</label>
                                    <div class="multi-check-fields mb-15">
                                        <span>
                                            <input type="radio" name="day_of_week" value="7" class="medication-alert recieve-alert" <?php if (!empty($medica)) {
                                                if (isset($medica['day_of_week']) && $medica['day_of_week'] == 7) {
                                                    echo "checked";
                                                }
                                            } ?> /> Sunday
                                        </span>
                                        <span>
                                            <input type="radio" name="day_of_week" value="1" class="medication-alert recieve-alert" <?php if (!empty($medica)) {
                                                if (isset($medica['day_of_week']) && $medica['day_of_week'] == 1) {
                                                    echo "checked";
                                                }
                                            } ?> /> Monday
                                        </span>
                                        <span>
                                            <input type="radio" name="day_of_week" value="2" class="medication-alert recieve-alert" <?php if (!empty($medica)) {
                                                if (isset($medica['day_of_week']) && $medica['day_of_week'] == 2) {
                                                    echo "checked";
                                                }
                                            } ?> /> Tuesday
                                        </span>
                                        <span>
                                            <input type="radio" name="day_of_week" value="3" class="medication-alert recieve-alert" <?php if (!empty($medica)) {
                                                if (isset($medica['day_of_week']) && $medica['day_of_week'] == 3) {
                                                    echo "checked";
                                                }
                                            } ?> /> Wednesday
                                        </span>
                                        <span>
                                            <input type="radio" name="day_of_week" value="4" class="medication-alert recieve-alert" <?php if (!empty($medica)) {
                                                if (isset($medica['day_of_week']) && $medica['day_of_week'] == 4) {
                                                    echo "checked";
                                                }
                                            } ?> /> Thursday
                                        </span>
                                        <span>
                                            <input type="radio" name="day_of_week" value="5" class="medication-alert recieve-alert" <?php if (!empty($medica)) {
                                                if (isset($medica['day_of_week']) && $medica['day_of_week'] == 5) {
                                                    echo "checked";
                                                }
                                            } ?> /> Friday
                                        </span>
                                        <span>
                                            <input type="radio" name="day_of_week" value="6" class="medication-alert recieve-alert" <?php if (!empty($medica)) {
                                                if (isset($medica['day_of_week']) && $medica['day_of_week'] == 6) {
                                                    echo "checked";
                                                }
                                            } ?> /> Saturday
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="field-wrap two-fields-wrap">
                                <div class="field-div">
                                    <label>*Choose time of day to receive alert:</label>
                                    <select name="time_of_day" class="medication-alert" >
                                         <?php for($i = 1; $i <= 24; $i++): 
                                            if (!empty($medica)) {
                                                if (isset($medica['time_of_day']) && $medica['time_of_day'] == $i) {
                                                    echo '<option selected value="'.$i.'">'. date("h.i A", strtotime("$i:00")).'</option>';
                                                }else{
                                                    echo '<option value="'.$i.'">'. date("h.i A", strtotime("$i:00")).'</option>';
                                                }
                                            }else{
                                                echo '<option value="'.$i.'">'. date("h.i A", strtotime("$i:00")).'</option>';  
                                            }
                                            
                                        endfor; ?>
                                    </select>
                                </div>
                                <div class="field-div">
                                    <label>*Choose first day to receive this alert:</label>
                                    <input type="text" name="alert_date" class="first-day medication-alert" required="" value="<?php if (!empty($medica)) {
                                            if (isset($medica['alert_date']) && !empty($medica['alert_date'])) {
                                                echo $medica['alert_date'];
                                            }else{
                                                echo date("F d, Y");
                                            }
                                        }else{
                                            echo date("F d, Y");
                                        } ?>">
                                </div>
                            </div>
                            <div class="field-wrap two-fields-wrap">
                                <div class="field-div">
                                    <label>*Frequency of alert:</label>
                                    <select class="medication-alert" name="frequency_of_alert">
                                        <?php 
                                            $i = 1;
                                            while ( $i <= 12 ) {
                                                if (!empty($medica)) {
                                                    if (isset($medica['frequency_of_alert']) && $medica['frequency_of_alert'] == $i) {
                                                        if ($i == 1) {
                                                            echo '<option selected value="'.$i.'">Every Month</option>';
                                                        }else{
                                                            echo '<option selected value="'.$i.'">Every '.$i.' Months</option>';
                                                        }
                                                    }else{
                                                        if ($i == 1) {
                                                            echo '<option  value="'.$i.'">Every Month</option>';
                                                        }else{
                                                            echo '<option  value="'.$i.'">Every '.$i.' Months</option>';
                                                        }
                                                    }
                                                }else{
                                                    if ($i == 1) {
                                                        echo '<option value="'.$i.'">Every Month</option>';
                                                    }else{
                                                        echo '<option value="'.$i.'">Every '.$i.' Months</option>';
                                                    } 
                                                }
                                                $i++;  
                                            }
                                        ?>
                                    </select>
                                </div>
                                <div class="field-div">
                                    <label>*How would you like to receive this alert?:</label>
                                    <div class="multi-check-fields mb-15">
                                        <span>
                                            <input type="radio" name="recieve_alert" value="email" class="medication-alert alert-type" <?php if (!empty($medica)) {
                                                if (isset($medica['recieve_alert']) && $medica['recieve_alert'] == "email") {
                                                    echo "checked";
                                                }
                                            } ?> /> By Email
                                        </span>
                                        <span>
                                            <input type="radio" name="recieve_alert" value="phone" class="medication-alert alert-type" <?php if (!empty($medica)) {
                                                if (isset($medica['recieve_alert']) && $medica['recieve_alert'] == "phone") {
                                                    echo "checked";
                                                }
                                            } ?> /> By Phone, VIA Text Message
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="field-wrap">
                                <div class="field-div">
                                    <label>Add Notes (Optional):</label>
                                    <input type="text" placeholder="Write Notes..." name="note" class="medication-alert" value="<?php if (!empty($medica)) {
                                                if (!empty($medica['note'])) {
                                                    echo $medica['note'];
                                                }
                                            } ?>">
                                </div>
                            </div>
                            <div class="field-wrap two-fields-wrap">
                                <div class="field-div text-left">
                                    <input type="button" name="" value="Remove Alert" class="site-btn-red remove-sing-up-alert <?php echo $medicaClass; ?>" <?php echo $medicaClass; ?> />
                                </div>
                                <div class="field-div text-right">
                                    <input type="button" name="" value="Save Alert" class="site-btn-red sing-up-alert" />
                                </div>
                            </div>
                            <div class="field-wrap">
                                <div class="field-notice"></div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="acc-blue-box acc-plus-minus">
                <div class="acc-blue-head">
                    Rabies Shot Alerts
                    <i class="fa fa-plus"></i>
                </div>
                <div class="acc-blue-content">
                    <div class="contact-form">
                        <form>
                            <input type="hidden" name="alert_name" value="rabies_shot_alert" class="rabies-shot">
                            <div class="field-wrap">
                                <div class="field-div">
                                    <label>*Choose day of the week to receive alert:</label>
                                    <div class="multi-check-fields mb-15">
                                        <span>
                                            <input type="radio" name="day_of_week" value="7" class="rabies-shot recieve-alert" <?php if (!empty($rabiesShot)) {
                                                if (isset($rabiesShot['day_of_week']) && $rabiesShot['day_of_week'] == 7) {
                                                    echo "checked";
                                                }
                                            } ?> /> Sunday
                                        </span>
                                        <span>
                                            <input type="radio" name="day_of_week" value="1" class="rabies-shot recieve-alert" <?php if (!empty($rabiesShot)) {
                                                if (isset($rabiesShot['day_of_week']) && $rabiesShot['day_of_week'] == 1) {
                                                    echo "checked";
                                                }
                                            } ?> /> Monday
                                        </span>
                                        <span>
                                            <input type="radio" name="day_of_week" value="2" class="rabies-shot recieve-alert" <?php if (!empty($rabiesShot)) {
                                                if (isset($rabiesShot['day_of_week']) && $rabiesShot['day_of_week'] == 2) {
                                                    echo "checked";
                                                }
                                            } ?> /> Tuesday
                                        </span>
                                        <span>
                                            <input type="radio" name="day_of_week" value="3" class="rabies-shot recieve-alert" <?php if (!empty($rabiesShot)) {
                                                if (isset($rabiesShot['day_of_week']) && $rabiesShot['day_of_week'] == 3) {
                                                    echo "checked";
                                                }
                                            } ?> /> Wednesday
                                        </span>
                                        <span>
                                            <input type="radio" name="day_of_week" value="4" class="rabies-shot recieve-alert" <?php if (!empty($rabiesShot)) {
                                                if (isset($rabiesShot['day_of_week']) && $rabiesShot['day_of_week'] == 4) {
                                                    echo "checked";
                                                }
                                            } ?> /> Thursday
                                        </span>
                                        <span>
                                            <input type="radio" name="day_of_week" value="5" class="rabies-shot recieve-alert" <?php if (!empty($rabiesShot)) {
                                                if (isset($rabiesShot['day_of_week']) && $rabiesShot['day_of_week'] == 5) {
                                                    echo "checked";
                                                }
                                            } ?> /> Friday
                                        </span>
                                        <span>
                                            <input type="radio" name="day_of_week" value="6" class="rabies-shot recieve-alert" <?php if (!empty($rabiesShot)) {
                                                if (isset($rabiesShot['day_of_week']) && $rabiesShot['day_of_week'] == 6) {
                                                    echo "checked";
                                                }
                                            } ?> /> Saturday
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="field-wrap two-fields-wrap">
                                <div class="field-div">
                                    <label>*Choose time of day to receive alert:</label>
                                    <select name="time_of_day" class="rabies-shot" >
                                        <?php for($i = 1; $i <= 24; $i++): 
                                            if (!empty($rabiesShot)) {
                                                if (isset($rabiesShot['time_of_day']) && $rabiesShot['time_of_day'] == $i) {
                                                    echo '<option selected value="'.$i.'">'. date("h.i A", strtotime("$i:00")).'</option>';
                                                }else{
                                                    echo '<option value="'.$i.'">'. date("h.i A", strtotime("$i:00")).'</option>';
                                                }
                                            }else{
                                                echo '<option value="'.$i.'">'. date("h.i A", strtotime("$i:00")).'</option>';  
                                            }
                                            
                                        endfor; ?>
                                    </select>
                                </div>
                                <div class="field-div">
                                    <label>*Choose first day to receive this alert:</label>
                                    <input type="text" name="alert_date" class="first-day rabies-shot" required="" value="<?php if (!empty($rabiesShot)) {
                                            if (isset($rabiesShot['alert_date']) && !empty($rabiesShot['alert_date'])) {
                                                echo $rabiesShot['alert_date'];
                                            }else{
                                                echo date("F d, Y");
                                            }
                                        }else{
                                            echo date("F d, Y");
                                        } ?>">
                                </div>
                            </div>
                            <div class="field-wrap two-fields-wrap">
                                <div class="field-div">
                                    <label>*Frequency of alert:</label>
                                    <select class="rabies-shot" name="frequency_of_alert">
                                        <?php 
                                            $i = 1;
                                            while ( $i <= 12 ) {
                                                if (!empty($rabiesShot)) {
                                                    if (isset($rabiesShot['frequency_of_alert']) && $rabiesShot['frequency_of_alert'] == $i) {
                                                        if ($i == 1) {
                                                            echo '<option selected value="'.$i.'">Every Month</option>';
                                                        }else{
                                                            echo '<option selected value="'.$i.'">Every '.$i.' Months</option>';
                                                        }
                                                    }else{
                                                        if ($i == 1) {
                                                            echo '<option  value="'.$i.'">Every Month</option>';
                                                        }else{
                                                            echo '<option  value="'.$i.'">Every '.$i.' Months</option>';
                                                        }
                                                    }
                                                }else{
                                                    if ($i == 1) {
                                                    echo '<option value="'.$i.'">Every Month</option>';
                                                    }else{
                                                        echo '<option value="'.$i.'">Every '.$i.' Months</option>';
                                                    } 
                                                }
                                                $i++;  
                                            }
                                        ?>
                                    </select>
                                </div>
                                <div class="field-div">
                                    <label>*How would you like to receive this alert?:</label>
                                    <div class="multi-check-fields mb-15">
                                        <span>
                                            <input type="radio" name="recieve_alert" value="email" class="rabies-shot alert-type" <?php if (!empty($rabiesShot)) {
                                                if (isset($rabiesShot['recieve_alert']) && $rabiesShot['recieve_alert'] == "email") {
                                                    echo "checked";
                                                }
                                            } ?> /> By Email
                                        </span>
                                        <span>
                                            <input type="radio" name="recieve_alert" value="phone" class="rabies-shot alert-type" <?php if (!empty($rabiesShot)) {
                                                if (isset($rabiesShot['recieve_alert']) && $rabiesShot['recieve_alert'] == "phone") {
                                                    echo "checked";
                                                }
                                            } ?> /> By Phone, VIA Text Message
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="field-wrap">
                                <div class="field-div">
                                    <label>Add Notes (Optional):</label>
                                    <input type="text" name="note" placeholder="Write Notes..." class="rabies-shot" value="<?php if (!empty($rabiesShot)) {
                                                if (!empty($rabiesShot['note'])) {
                                                    echo $rabiesShot['note'];
                                                }
                                            } ?>">
                                </div>
                            </div>
                            <div class="field-wrap two-fields-wrap">
                                <div class="field-div text-left">
                                    <input type="button" name="" value="Remove Alert" class="site-btn-red remove-sing-up-alert <?php echo $rabiesShotClass; ?>" <?php echo $rabiesShotClass; ?> />
                                </div>
                                <div class="field-div text-right">
                                    <input type="button" name="" value="Save Alert" class="site-btn-red sing-up-alert" />
                                </div>
                            </div>
                            <div class="field-wrap">
                                <div class="field-notice"></div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="acc-blue-box acc-plus-minus">
                <div class="acc-blue-head">
                    Tag Licensing Alerts
                    <i class="fa fa-plus"></i>
                </div>
                <div class="acc-blue-content">
                    <div class="contact-form">
                        <form>
                            <input type="hidden" name="alert_name" value="tag_licensing_alert" class="tag-licens">
                            <div class="field-wrap">
                                <div class="field-div">
                                    <label>*Choose day of the week to receive alert:</label>
                                    <div class="multi-check-fields mb-15">
                                        <span>
                                            <input type="radio" name="day_of_week" value="7" class="tag-licens recieve-alert" <?php if (!empty($tagLicens)) {
                                                if (isset($tagLicens['day_of_week']) && $tagLicens['day_of_week'] == 7) {
                                                    echo "checked";
                                                }
                                            } ?> /> Sunday
                                        </span>
                                        <span>
                                            <input type="radio" name="day_of_week" value="1" class="tag-licens recieve-alert" <?php if (!empty($tagLicens)) {
                                                if (isset($tagLicens['day_of_week']) && $tagLicens['day_of_week'] == 1) {
                                                    echo "checked";
                                                }
                                            } ?> /> Monday
                                        </span>
                                        <span>
                                            <input type="radio" name="day_of_week" value="2" class="tag-licens recieve-alert" <?php if (!empty($tagLicens)) {
                                                if (isset($tagLicens['day_of_week']) && $tagLicens['day_of_week'] == 2) {
                                                    echo "checked";
                                                }
                                            } ?> /> Tuesday
                                        </span>
                                        <span>
                                            <input type="radio" name="day_of_week" value="3" class="tag-licens recieve-alert" <?php if (!empty($tagLicens)) {
                                                if (isset($tagLicens['day_of_week']) && $tagLicens['day_of_week'] == 3) {
                                                    echo "checked";
                                                }
                                            } ?> /> Wednesday
                                        </span>
                                        <span>
                                            <input type="radio" name="day_of_week" value="4" class="tag-licens recieve-alert" <?php if (!empty($tagLicens)) {
                                                if (isset($tagLicens['day_of_week']) && $tagLicens['day_of_week'] == 4) {
                                                    echo "checked";
                                                }
                                            } ?> /> Thursday
                                        </span>
                                        <span>
                                            <input type="radio" name="day_of_week" value="5" class="tag-licens recieve-alert" <?php if (!empty($tagLicens)) {
                                                if (isset($tagLicens['day_of_week']) && $tagLicens['day_of_week'] == 5) {
                                                    echo "checked";
                                                }
                                            } ?> /> Friday
                                        </span>
                                        <span>
                                            <input type="radio" name="day_of_week" value="6" class="tag-licens recieve-alert" <?php if (!empty($tagLicens)) {
                                                if (isset($tagLicens['day_of_week']) && $tagLicens['day_of_week'] == 6) {
                                                    echo "checked";
                                                }
                                            } ?> /> Saturday
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="field-wrap two-fields-wrap">
                                <div class="field-div">
                                    <label>*Choose time of day to receive alert:</label>
                                    <select name="time_of_day" class="tag-licens" >
                                        <?php for($i = 1; $i <= 24; $i++): 
                                            if (!empty($tagLicens)) {
                                                if (isset($tagLicens['time_of_day']) && $tagLicens['time_of_day'] == $i) {
                                                    echo '<option selected value="'.$i.'">'. date("h.i A", strtotime("$i:00")).'</option>';
                                                }else{
                                                    echo '<option value="'.$i.'">'. date("h.i A", strtotime("$i:00")).'</option>';
                                                }
                                            }else{
                                                echo '<option value="'.$i.'">'. date("h.i A", strtotime("$i:00")).'</option>';  
                                            }
                                            
                                        endfor; ?>
                                    </select>
                                </div>
                                <div class="field-div">
                                    <label>*Choose first day to receive this alert:</label>
                                    <input type="text" required="" name="alert_date" class="first-day tag-licens" value="<?php if (!empty($tagLicens)) {
                                            if (isset($tagLicens['alert_date']) && !empty($tagLicens['alert_date'])) {
                                                echo $tagLicens['alert_date'];
                                            }else{
                                                echo date("F d, Y");
                                            }
                                        }else{
                                            echo date("F d, Y");
                                        } ?>">
                                </div>
                            </div>
                            <div class="field-wrap two-fields-wrap">
                                <div class="field-div">
                                    <label>*Frequency of alert:</label>
                                    <select class="tag-licens" name="frequency_of_alert">
                                        <?php 
                                            $i = 1;
                                            while ( $i <= 12 ) {
                                                if (!empty($tagLicens)) {
                                                    if (isset($tagLicens['frequency_of_alert']) && $tagLicens['frequency_of_alert'] == $i) {
                                                        if ($i == 1) {
                                                            echo '<option selected value="'.$i.'">Every Month</option>';
                                                        }else{
                                                            echo '<option selected value="'.$i.'">Every '.$i.' Months</option>';
                                                        }
                                                    }else{
                                                        if ($i == 1) {
                                                            echo '<option  value="'.$i.'">Every Month</option>';
                                                        }else{
                                                            echo '<option  value="'.$i.'">Every '.$i.' Months</option>';
                                                        }
                                                    }
                                                }else{
                                                    if ($i == 1) {
                                                    echo '<option value="'.$i.'">Every Month</option>';
                                                    }else{
                                                        echo '<option value="'.$i.'">Every '.$i.' Months</option>';
                                                    }
                                                }
                                                
                                                $i++;  
                                            }
                                        ?>
                                    </select>
                                </div>
                                <div class="field-div">
                                    <label>*How would you like to receive this alert?:</label>
                                    <div class="multi-check-fields mb-15">
                                        <span>
                                            <input type="radio" name="recieve_alert" value="email" class="tag-licens alert-type" <?php if (!empty($tagLicens)) {
                                                if (isset($tagLicens['recieve_alert']) && $tagLicens['recieve_alert'] == "email") {
                                                    echo "checked";
                                                }
                                            } ?> /> By Email
                                        </span>
                                        <span>
                                            <input type="radio" name="recieve_alert" value="phone" class="tag-licens alert-type" <?php if (!empty($tagLicens)) {
                                                if (isset($tagLicens['recieve_alert']) && $tagLicens['recieve_alert'] == "phone") {
                                                    echo "checked";
                                                }
                                            } ?> /> By Phone, VIA Text Message
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="field-wrap">
                                <div class="field-div">
                                    <label>Add Notes (Optional):</label>
                                    <input type="text" name="note" placeholder="Write Notes..." class="tag-licens" value="<?php if (!empty($tagLicens)) {
                                                if (!empty($tagLicens['note'])) {
                                                    echo $tagLicens['note'];
                                                }
                                            } ?>">
                                </div>
                            </div>
                            <div class="field-wrap two-fields-wrap">
                                <div class="field-div text-left">
                                    <input type="button" name="" value="Remove Alert" class="site-btn-red remove-sing-up-alert <?php echo $tagLicensClass; ?>" <?php echo $tagLicensClass; ?> />
                                </div>
                                <div class="field-div text-right">
                                    <input type="button" name="" value="Save Alert" class="site-btn-red sing-up-alert" />
                                </div>
                            </div>
                            <div class="field-wrap">
                                <div class="field-notice"></div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="custom-box-wrap">
                <?php if ((int)$totalCustm) {
                    $j = 1;
                    $k = 0;
                    while ( $j <= $totalCustm ) {
                        $customAlert = get_user_meta($userId,"custom_alert_".$j,true);
                        if (!empty($customAlert)) {
                        ?>
                        <div class="acc-blue-box acc-plus-minus custom-box">
                            <div class="acc-blue-head">
                                Create a Custom Alert
                                <i class="fa fa-plus"></i>
                            </div>
                            <div class="acc-blue-content">
                                <div class="contact-form">
                                    <form>
                                        <div class="field-wrap">
                                            <div class="field-div">
                                                <label>*Name Your Custom Alert:</label>
                                                <input type="text" name="custom_alert_name" class="custom-alert" required="" value="<?php if (!empty($customAlert)) {
                                                if (isset($customAlert['custom_alert_name'])) {
                                                    echo $customAlert['custom_alert_name'];
                                                }
                                            } ?> ">
                                                <input type="hidden" name="custom_alert_number" value="<?php echo "custom_alert_".$j; ?>" class="custom-alert-number">
                                            </div>
                                        </div>
                                        <div class="field-wrap">
                                            <div class="field-div">
                                                <label>*Choose day of the week to receive alert:</label>
                                                <div class="multi-check-fields mb-15">
                                                    <span>
                                                        <input type="radio" name="day_of_week" value="7" class="tag-licens recieve-alert" <?php if (!empty($customAlert)) {
                                                if (isset($customAlert['day_of_week']) && $customAlert['day_of_week'] == 7) {
                                                    echo "checked";
                                                }
                                            } ?> /> Sunday
                                                    </span>
                                                    <span>
                                                        <input type="radio" name="day_of_week" value="1" class="tag-licens recieve-alert" <?php if (!empty($customAlert)) {
                                                if (isset($customAlert['day_of_week']) && $customAlert['day_of_week'] == 1) {
                                                    echo "checked";
                                                }
                                            } ?> /> Monday
                                                    </span>
                                                    <span>
                                                        <input type="radio" name="day_of_week" value="2" class="tag-licens recieve-alert" <?php if (!empty($customAlert)) {
                                                if (isset($customAlert['day_of_week']) && $customAlert['day_of_week'] == 2) {
                                                    echo "checked";
                                                }
                                            } ?> /> Tuesday
                                                    </span>
                                                    <span>
                                                        <input type="radio" name="day_of_week" value="3" class="tag-licens recieve-alert" <?php if (!empty($customAlert)) {
                                                if (isset($customAlert['day_of_week']) && $customAlert['day_of_week'] == 3) {
                                                    echo "checked";
                                                }
                                            } ?> /> Wednesday
                                                    </span>
                                                    <span>
                                                        <input type="radio" name="day_of_week" value="4" class="tag-licens recieve-alert" <?php if (!empty($customAlert)) {
                                                if (isset($customAlert['day_of_week']) && $customAlert['day_of_week'] == 4) {
                                                    echo "checked";
                                                }
                                            } ?> /> Thursday
                                                    </span>
                                                    <span>
                                                        <input type="radio" name="day_of_week" value="5" class="tag-licens recieve-alert" <?php if (!empty($customAlert)) {
                                                if (isset($customAlert['day_of_week']) && $customAlert['day_of_week'] == 5) {
                                                    echo "checked";
                                                }
                                            } ?> /> Friday
                                                    </span>
                                                    <span>
                                                        <input type="radio" name="day_of_week" value="6" class="tag-licens recieve-alert" <?php if (!empty($customAlert)) {
                                                if (isset($customAlert['day_of_week']) && $customAlert['day_of_week'] == 6) {
                                                    echo "checked";
                                                }
                                            } ?> /> Saturday
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="field-wrap two-fields-wrap">
                                            <div class="field-div">
                                                <label>*Choose time of day to receive alert:</label>
                                                <select name="time_of_day" class="tag-licens" >
                                                    <?php for($i = 1; $i <= 24; $i++): 
                                                        if (!empty($customAlert)) {
                                                            if (isset($customAlert['time_of_day']) && $customAlert['time_of_day'] == $i) {
                                                                echo '<option selected value="'.$i.'">'. date("h.i A", strtotime("$i:00")).'</option>';
                                                            }else{
                                                                echo '<option value="'.$i.'">'. date("h.i A", strtotime("$i:00")).'</option>';
                                                            }
                                                        }else{
                                                            echo '<option value="'.$i.'">'. date("h.i A", strtotime("$i:00")).'</option>';  
                                                        }
                                                    endfor; ?>
                                                </select>
                                            </div>
                                            <div class="field-div">
                                                <label>*Choose first day to receive this alert:</label>
                                                <input type="text" name="alert_date" class="first-day tag-licens" required="" value="<?php if (!empty($customAlert)) {
                                            if (isset($customAlert['alert_date']) && !empty($customAlert['alert_date'])) {
                                                echo $customAlert['alert_date'];
                                            }else{
                                                echo date("F d, Y");
                                            }
                                        }else{
                                            echo date("F d, Y");
                                        } ?>">
                                            </div>
                                        </div>
                                        <div class="field-wrap two-fields-wrap">
                                            <div class="field-div">
                                                <label>*Frequency of alert:</label>
                                                <select class="tag-licens" name="frequency_of_alert">
                                                    <?php 
                                                        $i = 1;
                                                        while ( $i <= 12 ) {
                                                            if (!empty($customAlert)) {
                                                                if (isset($customAlert['frequency_of_alert']) && $customAlert['frequency_of_alert'] == $i) {
                                                                    if ($i == 1) {
                                                                        echo '<option selected value="'.$i.'">Every Month</option>';
                                                                    }else{
                                                                        echo '<option selected value="'.$i.'">Every '.$i.' Months</option>';
                                                                    }
                                                                }else{
                                                                    if ($i == 1) {
                                                                        echo '<option  value="'.$i.'">Every Month</option>';
                                                                    }else{
                                                                        echo '<option  value="'.$i.'">Every '.$i.' Months</option>';
                                                                    }
                                                                }
                                                            }else{
                                                                if ($i == 1) {
                                                                echo '<option value="'.$i.'">Every Month</option>';
                                                                }else{
                                                                    echo '<option value="'.$i.'">Every '.$i.' Months</option>';
                                                                } 
                                                            }
                                                            
                                                            $i++;  
                                                        }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="field-div">
                                                <label>*How would you like to receive this alert?:</label>
                                                <div class="multi-check-fields mb-15">
                                                    <span>
                                                        <input type="radio" name="recieve_alert" value="email" class="tag-licens alert-type" <?php if (!empty($customAlert)) {
                                                if (isset($customAlert['recieve_alert']) && $customAlert['recieve_alert'] == "email") {
                                                    echo "checked";
                                                }
                                            } ?> /> By Email
                                                    </span>
                                                    <span>
                                                        <input type="radio" name="recieve_alert" value="phone" class="tag-licens alert-type" <?php if (!empty($customAlert)) {
                                                if (isset($customAlert['recieve_alert']) && $customAlert['recieve_alert'] == "phone") {
                                                    echo "checked";
                                                }
                                            } ?> /> By Phone, VIA Text Message
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="field-wrap">
                                            <div class="field-div">
                                                <label>Add Notes (Optional):</label>
                                                <input type="text" name="note" placeholder="Write Notes..." class="tag-licens" value="<?php if (!empty($customAlert)) {
                                                if (!empty($customAlert['note'])) {
                                                    echo $customAlert['note'];
                                                }
                                            } ?>">
                                            </div>
                                        </div>
                                        <div class="field-wrap two-fields-wrap">
                                            <div class="field-div text-left">
                                                <input type="button" name="" value="Remove Alert" class="site-btn-red remove-custom-alert" />
                                            </div>
                                            <div class="field-div text-right">
                                                <input type="button" name="" value="Save Alert" class="site-btn-red custom-alert" />
                                            </div>
                                        </div>
                                        <div class="field-wrap">
                                            <div class="field-notice"></div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <?php 
                        }else{
                            $k++;
                        }
                        $j++;
                    }
                    if ($k == $totalCustm) { ?>
                        <div class="acc-blue-box acc-plus-minus custom-box">
                            <div class="acc-blue-head">
                                Create a Custom Alert
                                <i class="fa fa-plus"></i>
                            </div>
                            <div class="acc-blue-content">
                                <div class="contact-form">
                                    <form>
                                        <div class="field-wrap">
                                            <div class="field-div">
                                                <label>*Name Your Custom Alert:</label>
                                                <input type="text" name="custom_alert_name" class="custom-alert" required="">
                                                <input type="hidden" name="custom_alert_number" value="0"  class="custom-alert-number">
                                            </div>
                                        </div>
                                        <div class="field-wrap">
                                            <div class="field-div">
                                                <label>*Choose day of the week to receive alert:</label>
                                                <div class="multi-check-fields mb-15">
                                                    <span>
                                                        <input type="radio" name="day_of_week" value="7" class="custom-alert recieve-alert"  /> Sunday
                                                    </span>
                                                    <span>
                                                        <input type="radio" name="day_of_week" value="1" class="custom-alert recieve-alert" /> Monday
                                                    </span>
                                                    <span>
                                                        <input type="radio" name="day_of_week" value="2" class="custom-alert recieve-alert" /> Tuesday
                                                    </span>
                                                    <span>
                                                        <input type="radio" name="day_of_week" value="3" class="custom-alert recieve-alert" /> Wednesday
                                                    </span>
                                                    <span>
                                                        <input type="radio" name="day_of_week" value="4" class="custom-alert recieve-alert" /> Thursday
                                                    </span>
                                                    <span>
                                                        <input type="radio" name="day_of_week" value="5" class="custom-alert recieve-alert" /> Friday
                                                    </span>
                                                    <span>
                                                        <input type="radio" name="day_of_week" class="custom-alert recieve-alert" value="6" /> Saturday
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="field-wrap two-fields-wrap">
                                            <div class="field-div">
                                                <label>*Choose time of day to receive alert:</label>
                                                <select name="time_of_day" class="custom-alert">
                                                    <?php for($i = 1; $i <= 24; $i++): ?>
                                                        <option value="<?= $i; ?>"><?= date("h.i A", strtotime("$i:00")); ?></option>
                                                    <?php endfor; ?>
                                                </select>
                                            </div>
                                            <div class="field-div">
                                                <label>*Choose first day to receive this alert:</label>
                                                <input type="text" name="alert_date" class="first-day custom-alert" value="<?php echo date("F d, Y"); ?>" required="">
                                            </div>
                                        </div>
                                        <div class="field-wrap two-fields-wrap">
                                            <div class="field-div">
                                                <label>*Frequency of alert:</label>
                                                <select class="custom-alert" name="frequency_of_alert">
                                                    <?php 
                                                        $i = 1;
                                                        while ( $i <= 12 ) {
                                                            if ($i == 1) {
                                                                echo '<option value="'.$i.'">Every Month</option>';
                                                            }else{
                                                                echo '<option value="'.$i.'">Every '.$i.' Months</option>';
                                                            }
                                                            $i++;  
                                                        }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="field-div">
                                                <label>*How would you like to receive this alert?:</label>
                                                <div class="multi-check-fields mb-15">
                                                    <span>
                                                        <input type="radio" name="recieve_alert" class="custom-alert alert-type" value="email" /> By Email
                                                    </span>
                                                    <span>
                                                        <input type="radio" name="recieve_alert" class="custom-alert alert-type" value="phone" /> By Phone, VIA Text Message
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="field-wrap">
                                            <div class="field-div">
                                                <label>Add Notes (Optional):</label>
                                                <input type="text" name="note" placeholder="Write Notes..." class="custom-alert">
                                            </div>
                                        </div>
                                        <div class="field-wrap two-fields-wrap">
                                            <div class="field-div text-left">
                                                <input type="button" name="" value="Remove Alert" class="site-btn-red remove-custom-alert disabled" disabled="" />
                                            </div>
                                            <div class="field-div text-right">
                                                <input type="button" name="" value="Save Alert" class="site-btn-red custom-alert" />
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    <?php }
                }else{ ?>
                    <div class="acc-blue-box acc-plus-minus custom-box">
                        <div class="acc-blue-head">
                            Create a Custom Alert
                            <i class="fa fa-plus"></i>
                        </div>
                        <div class="acc-blue-content">
                            <div class="contact-form">
                                <form>
                                    <div class="field-wrap">
                                        <div class="field-div">
                                            <label>*Name Your Custom Alert:</label>
                                            <input type="text" name="custom_alert_name" class="custom-alert" required="">
                                            <input type="hidden" name="custom_alert_number" value="0"  class="custom-alert-number">
                                        </div>
                                    </div>
                                    <div class="field-wrap">
                                        <div class="field-div">
                                            <label>*Choose day of the week to receive alert:</label>
                                            <div class="multi-check-fields mb-15">
                                                <span>
                                                    <input type="radio" name="day_of_week" value="7" class="custom-alert recieve-alert" /> Sunday
                                                </span>
                                                <span>
                                                    <input type="radio" name="day_of_week" value="1" class="custom-alert recieve-alert" /> Monday
                                                </span>
                                                <span>
                                                    <input type="radio" name="day_of_week" value="2" class="custom-alert recieve-alert" /> Tuesday
                                                </span>
                                                <span>
                                                    <input type="radio" name="day_of_week" value="3" class="custom-alert recieve-alert" /> Wednesday
                                                </span>
                                                <span>
                                                    <input type="radio" name="day_of_week" value="4" class="custom-alert recieve-alert" /> Thursday
                                                </span>
                                                <span>
                                                    <input type="radio" name="day_of_week" value="5" class="custom-alert recieve-alert" /> Friday
                                                </span>
                                                <span>
                                                    <input type="radio" name="day_of_week" class="custom-alert recieve-alert" value="6" /> Saturday
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="field-wrap two-fields-wrap">
                                        <div class="field-div">
                                            <label>*Choose time of day to receive alert:</label>
                                            <select name="time_of_day" class="custom-alert">
                                                <?php for($i = 1; $i <= 24; $i++): ?>
                                                    <option value="<?= $i; ?>"><?= date("h.i A", strtotime("$i:00")); ?></option>
                                                <?php endfor; ?>
                                            </select>
                                        </div>
                                        <div class="field-div">
                                            <label>*Choose first day to receive this alert:</label>
                                            <input type="text" name="alert_date" class="first-day custom-alert" value="<?php echo date("F d, Y"); ?>">
                                        </div>
                                    </div>
                                    <div class="field-wrap two-fields-wrap">
                                        <div class="field-div">
                                            <label>*Frequency of alert:</label>
                                            <select class="custom-alert" name="frequency_of_alert">
                                                <?php 
                                                    $i = 1;
                                                    while ( $i <= 12 ) {
                                                        if ($i == 1) {
                                                            echo '<option value="'.$i.'">Every Month</option>';
                                                        }else{
                                                            echo '<option value="'.$i.'">Every '.$i.' Months</option>';
                                                        }
                                                        $i++;  
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="field-div">
                                            <label>*How would you like to receive this alert?:</label>
                                            <div class="multi-check-fields mb-15">
                                                <span>
                                                    <input type="radio" name="recieve_alert" class="custom-alert alert-type" value="email" /> By Email
                                                </span>
                                                <span>
                                                    <input type="radio" name="recieve_alert" class="custom-alert alert-type" value="phone" /> By Phone, VIA Text Message
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="field-wrap">
                                        <div class="field-div">
                                            <label>Add Notes (Optional):</label>
                                            <input type="text" name="note" placeholder="Write Notes..." class="custom-alert">
                                        </div>
                                    </div>
                                    <div class="field-wrap two-fields-wrap">
                                        <div class="field-div text-left">
                                            <input type="button" name="" value="Remove Alert" class="site-btn-red remove-custom-alert disabled" disabled="" />
                                        </div>
                                        <div class="field-div text-right">
                                            <input type="button" name="" value="Save Alert" class="site-btn-red custom-alert" />
                                        </div>
                                    </div>
                                    <div class="field-wrap">
                                        <div class="field-notice"></div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
            <div class="field-wrap">
                <div class="field-div">
                    <button id="add-custom"><i class="fa fa-plus"></i> Create a Custom Alert</button>
                </div>
            </div>
        </div>
        <script type="text/javascript">
            window.alert = 0;
            jQuery(document).ready(function($) {
                $("body").on("click","#add-custom",function(){
                    var clone  = $(".custom-box:last-child").clone().find(".first-day").each(function(){
                            $(this).removeClass("hasDatepicker");
                            $(this).removeAttr('id');
                         }).end();
                    clone      = clone.find('.error').remove().end();
                    var fclone = clone.find('.custom-alert-number').each(function(){
                            $(this).val("0");
                         }).end();
                    fclone      = fclone.find('.remove-custom-alert').each(function(){
                            $(this).attr("disabled",true);
                            $(this).addClass("disabled");
                            $(this).addClass("clone-btn");
                         }).end();
                    $(fclone).appendTo(".custom-box-wrap");
                    $("body").find(".first-day").datepicker({
                        dateFormat : "MM d, yy",
                    });

                });
                $("body").find(".first-day").datepicker({
                    dateFormat : "MM d, yy",
                });

                $('input[type="button"].sing-up-alert').on("click",function(){
                    $this            = $(this);
                    var heartworm    = new FormData();
                    var error        = 0;
                    var recieveAlert = 1;
                    var alertType    = 1;

                    $(this).parent().parent().parent().find('label.error').remove();

                    $.each($(this).parent().parent().parent().find('input[type="text"]'), function() {   
                        if ($(this)[0].hasAttribute("required")) {
                            if (!$(this).val()) {
                                $(this).parent().find("label.error").remove();
                                $(this).parent().append('<label class="error">This field is required.</label>');
                                error = 1;
                            }
                        }            
                        heartworm.append($(this).attr('name'), $(this).val());                   
                    });
                    $.each($(this).parent().parent().parent().find('input[type="hidden"]'), function() {               
                        heartworm.append($(this).attr('name'), $(this).val());                   
                    });
                    $.each($(this).parent().parent().parent().find('input[type="radio"]'), function() {       
                        if ($(this).prop('checked') == true) {
                            heartworm.append($(this).attr('name'), $(this).val());
                        }                      
                    });
                    $.each($(this).parent().parent().parent().find('select'), function() {      
                        heartworm.append($(this).attr('name'), $(this).val());                       
                    });
                    $.each($(this).parent().parent().parent().find('.recieve-alert'), function() {      
                        if ($(this).prop('checked') == true) {
                            recieveAlert = 0;
                            return;
                        }                       
                    });
                    $.each($(this).parent().parent().parent().find('.alert-type'), function() {      
                        if ($(this).prop('checked') == true) {
                            alertType = 0;
                            return;
                        }                       
                    });

                    if (recieveAlert && alertType) {
                        
                        $(this).parent().parent().parent().find('.recieve-alert:first').parent().parent().append('<label class="error mtt-1">This field is required.</label>');
                        $(this).parent().parent().parent().find('.alert-type:first').parent().parent().append('<label class="error mtt-1">This field is required.</label>');
                        return;

                    }else if(recieveAlert){
                        
                        $(this).parent().parent().parent().find('.recieve-alert:first').parent().parent().append('<label class="error mtt-1">This field is required.</label>');
                        return;

                    }else if(alertType){
                        
                        $(this).parent().parent().parent().find('.alert-type:first').parent().parent().append('<label class="error mtt-1">This field is required.</label>');
                        return;
                    }

                    if (error) {
                        return;
                    }


                    heartworm.append('action', 'updateAlerts');
                    heartworm.append('status', 1);
                    $.ajax({
                        type: 'POST',
                        url: '<?php echo admin_url( 'admin-ajax.php' ); ?>',
                        data: heartworm,
                        contentType: false,
                        processData: false,
                        dataType: 'json',
                        success: function(res){
                            console.log(res);
                            console.log(res.class);
                            // res = jQuery.parseJSON(res);
                            if (res.success == 1) {
                                $($this).parent().parent().parent().find('.field-notice').text(res.msg);
                                $($this).parent().parent().parent().find(".remove-sing-up-alert").removeClass("disabled").attr("disabled",false);
                                $(".standard-alerts").find("."+res.class).attr("checked",true);
                            }
                        }
                    });
                });
                $('body').on('click','input[type="button"].custom-alert',function(){
                    $this            = $(this);
                    window.alert     = 0;
                    var heartworm    = new FormData();
                    var error        = 0;
                    var recieveAlert = 1;
                    var alertType    = 1;

                    $(this).parent().parent().parent().find('label.error').remove();

                    $.each($(this).parent().parent().parent().find('input[type="text"]'), function() {  
                        if ($(this)[0].hasAttribute("required")) {
                            if (!$(this).val()) {
                                $(this).parent().find("label.error").remove();
                                $(this).parent().append('<label class="error">This field is required.</label>');
                                error = 1;
                            }
                        }             
                        heartworm.append($(this).attr('name'), $(this).val());                   
                    });
                    $.each($(this).parent().parent().parent().find('input[type="hidden"]'), function() {               
                        heartworm.append($(this).attr('name'), $(this).val());                   
                    });
                    $.each($(this).parent().parent().parent().find('input[type="radio"]'), function() {       
                        if ($(this).prop('checked') == true) {
                            heartworm.append($(this).attr('name'), $(this).val());
                        }                          
                    });
                    $.each($(this).parent().parent().parent().find('select'), function() {      
                        heartworm.append($(this).attr('name'), $(this).val());                       
                    });


                    $.each($(this).parent().parent().parent().find('.recieve-alert'), function() {      
                        if ($(this).prop('checked') == true) {
                            recieveAlert = 0;
                            return;
                        }                       
                    });
                    $.each($(this).parent().parent().parent().find('.alert-type'), function() {      
                        if ($(this).prop('checked') == true) {
                            alertType = 0;
                            return;
                        }                       
                    });

                    if (recieveAlert && alertType) {
                        $(this).parent().parent().parent().find('.recieve-alert:first').parent().parent().find('label.error').remove();
                        $(this).parent().parent().parent().find('.recieve-alert:first').parent().parent().append('<label class="error mtt-1">This field is required.</label>');
                        $(this).parent().parent().parent().find('.alert-type:first').parent().parent().find('label.error').remove();
                        $(this).parent().parent().parent().find('.alert-type:first').parent().parent().append('<label class="error mtt-1">This field is required.</label>');
                        return;
                    }else if(recieveAlert){
                        $(this).parent().parent().parent().find('.recieve-alert:first').parent().parent().find('label.error').remove();
                        $(this).parent().parent().parent().find('.recieve-alert:first').parent().parent().append('<label class="error mtt-1">This field is required.</label>');
                        return;
                    }else if(alertType){
                        $(this).parent().parent().parent().find('.alert-type:first').parent().parent().find('label.error').remove();
                        $(this).parent().parent().parent().find('.alert-type:first').parent().parent().append('<label class="error mtt-1">This field is required.</label>');
                        return;
                    }

                    if (error) {
                        return;
                    }

                    heartworm.append('action', 'updateCustomAlerts');
                    heartworm.append('status', 1);
                    $.ajax({
                        type: 'POST',
                        url: '<?php echo admin_url( 'admin-ajax.php' ); ?>',
                        data: heartworm,
                        contentType: false,
                        processData: false,
                        dataType: 'json',
                        success: function(res){
                            console.log(res);
                            // res = jQuery.parseJSON(res);
                            if (res.success == 1) {
                                $($this).parent().parent().parent().find('.field-notice').text(res.msg);
                                $($this).parent().parent().parent().find(".custom-alert-number").val(res.alertName);
                                $($this).parent().parent().parent().find(".remove-custom-alert").removeClass("disabled").attr("disabled",false);
                                $.each($('input.custom-alert-number'), function() {  
                                    if ($(this).val() != "0") {
                                        window.alert = 1;
                                        return false; 
                                    }
                                });
                                if (window.alert) {
                                    $(".standard-alerts .custom-alert").attr("checked",true);
                                }else{
                                    $(".standard-alerts .custom-alert").attr("checked",false);
                                }
                            }
                        }
                    });
                });
                $('body').on('click','input[type="button"].remove-sing-up-alert',function(){
                    $this = $(this);
                    var heartworm = new FormData();
                    $.each($(this).parent().parent().parent().find('input[type="hidden"]'), function() {               
                        heartworm.append($(this).attr('name'), $(this).val());                   
                    });
                    heartworm.append('action', 'removeAlerts');
                    $.ajax({
                        type: 'POST',
                        url: '<?php echo admin_url( 'admin-ajax.php' ); ?>',
                        data: heartworm,
                        contentType: false,
                        processData: false,
                        dataType: 'json',
                        success: function(res){
                            console.log(res);
                            // res = jQuery.parseJSON(res);
                            if (res.success == 1) {
                                $($this).parent().parent().parent().find('.field-notice').text(res.msg);
                                $($this).parent().parent().parent().find(".remove-custom-alert").addClass("disabled").attr("disabled",true);
                                $(".standard-alerts").find("."+res.class).attr("checked",false);
                            }
                        }
                    });
                });
                $('body').on('click','input[type="button"].remove-custom-alert',function(){
                    $this = $(this);
                    window.alert = 0;
                    var name = $(".custom-alert-number").val();
                    if (name != '0') {
                        var heartworm = new FormData();
                        $.each($(this).parent().parent().parent().find('input[type="hidden"]'), function() {               
                            heartworm.append($(this).attr('name'), $(this).val());                   
                        });
                        heartworm.append('action', 'removeCustomAlerts');
                        $.ajax({
                            type: 'POST',
                            url: '<?php echo admin_url( 'admin-ajax.php' ); ?>',
                            data: heartworm,
                            contentType: false,
                            processData: false,
                            dataType: 'json',
                            success: function(res){
                                console.log(res);
                                // res = jQuery.parseJSON(res);
                                if (res.success == 1) {
                                    $($this).parent().parent().parent().find('.field-notice').text(res.msg);
                                    $($this).parent().parent().parent().find(".custom-alert-number").val("0");
                                    if ($(".custom-box-wrap .custom-box").length > 1) {
                                        $($this).parent().parent().parent().parent().parent().parent().remove();
                                    }
                                    $.each($('input.custom-alert-number'), function() {  
                                        if ($(this).val() != "0") {
                                            window.alert = 1;
                                            return false; 
                                        }
                                    });
                                    console.log(window.alert);
                                    if (window.alert) {
                                        $(".standard-alerts .custom-alert").attr("checked",true);
                                    }else{
                                        $(".standard-alerts .custom-alert").attr("checked",false);
                                    }
                                }
                            }
                        });
                    }else{
                        if ($(".custom-box-wrap .custom-box").length > 1) {
                            $($this).parent().parent().parent().parent().parent().parent().remove();
                        }
                        $.each($('input.custom-alert-number'), function() {  
                            if ($(this).val() != "0") {
                                $(".standard-alerts .custom-alert").attr("checked",true);
                                return false; 
                            }else{
                                $(".standard-alerts .custom-alert").attr("checked",false);
                            }
                        });
                    }
                        
                });
                $.each($('input.custom-alert-number'), function() {  
                    if ($(this).val() != "0") {
                        $(".standard-alerts .custom-alert").attr("checked",true);
                        return false; 
                    }
                });
                // console.log($(".custom-box-wrap .custom-box").length);
                /*$('input[type="button"].heartworm-alert').on("click",function(){
                    $this = $(this);
                    var heartworm = new FormData();

                    $.each($('input[type="text"].heartworm-alert'), function() {               
                        heartworm.append($(this).attr('name'), $(this).val());                   
                    });
                    $.each($('input[type="hidden"].heartworm-alert'), function() {               
                        heartworm.append($(this).attr('name'), $(this).val());                   
                    });
                    $.each($('input[type="radio"].heartworm-alert'), function() {       
                        if ($(this).prop('checked') == true) {
                            heartworm.append($(this).attr('name'), $(this).val());
                        }                          
                    });
                    $.each($('select.heartworm-alert'), function() {      
                        heartworm.append($(this).attr('name'), $(this).val());                       
                    });
                    heartworm.append('action', 'updateAlerts');
                    heartworm.append('status', 1);
                    $.ajax({
                        type: 'POST',
                        url: '<?php echo admin_url( 'admin-ajax.php' ); ?>',
                        data: heartworm,
                        contentType: false,
                        processData: false,
                        dataType: 'json',
                        success: function(res){
                            console.log(res);
                            // res = jQuery.parseJSON(res);
                            if (res.success == 1) {
                                $($this).parent().parent().parent().append('<div class="field-wrap"><div class="field-notice">Update Heartworm Medication Alert Successfully.</div></div>');
                            }
                        }
                    });
                });

                $('input[type="button"].flea-tick').on("click",function(){
                    $this = $(this);
                    var heartworm = new FormData();

                    $.each($('input[type="text"].flea-tick'), function() {               
                        heartworm.append($(this).attr('name'), $(this).val());                   
                    });
                    $.each($('input[type="hidden"].flea-tick'), function() {               
                        heartworm.append($(this).attr('name'), $(this).val());                   
                    });
                    $.each($('input[type="radio"].flea-tick'), function() {       
                        if ($(this).prop('checked') == true) {
                            heartworm.append($(this).attr('name'), $(this).val());
                        }                          
                    });
                    $.each($('select.flea-tick'), function() {      
                        heartworm.append($(this).attr('name'), $(this).val());                       
                    });
                    heartworm.append('action', 'updateAlerts');
                    heartworm.append('status', 1);
                    $.ajax({
                        type: 'POST',
                        url: '<?php echo admin_url( 'admin-ajax.php' ); ?>',
                        data: heartworm,
                        contentType: false,
                        processData: false,
                        dataType: 'json',
                        success: function(res){
                            console.log(res);
                            // res = jQuery.parseJSON(res);
                            if (res.success == 1) {
                                $($this).parent().parent().parent().append('<div class="field-wrap"><div class="field-notice">Update Heartworm Medication Alert Successfully.</div></div>');
                            }
                        }
                    });
                });*/
            });
        </script>
    <?php
    }
 } 


/*Report My Pet as Lost Section*/

add_action( 'woocommerce_account_all-pet-profile_endpoint', 'my_account_endpoint_content_for_show_pet_profile' );
function my_account_endpoint_content_for_show_pet_profile() {

    $paged  = (get_query_var('paged')) ? get_query_var('paged') : 1;
    echo "<div class='page-heading'><h1>My Pets Information</h1></div>";
    $userId = get_current_user_id();
    $args   = array(
        'post_type' => 'pet_profile',
        'paged' => $paged,
        'author' => $userId
    );                       
    $query = new WP_Query($args);
    $i = 0;
    if ($query->have_posts()) {
        while ( $query->have_posts() ) : $query->the_post(); 
            $mypod = pods( 'pet_profile', get_the_id() ); 
            $smarttag_id_number = $mypod->display('smarttag_id_number');
            $microchip_id_number = $mypod->display('microchip_id_number');
            $subscriptionId  = $mypod->display("smarttag_subscription_id");
            if (!empty($subscriptionId)) {
                $subscription   = wcs_get_subscription($subscriptionId);
                if (!empty($subscription)) {
                    // print_r($subscription);
                    $startDate      = $subscription->get_date("start");
                    $date           = $subscription->get_date("end");
                    if (empty($date)) {
                        $date           = $subscription->get_date("next_payment");
                    }
                    $date           = date_parse_from_format('Y-m-d H:i:s',$date);
                    $date           = mktime(0, 0, 0, $date['month'], $date['day'], $date['year']);
                    $date           = date("m/d/Y", $date);

                    $startDate           = date_parse_from_format('Y-m-d H:i:s',$startDate);
                    $startDate           = mktime(0, 0, 0, $startDate['month'], $startDate['day'], $startDate['year']);
                    $startDate           = date("m/d/Y", $startDate);
                    // $subscription = wc_get_order($subscriptionId);
                    foreach( $subscription->get_items() as $item_id => $product_subscription ){
                        // Get the name
                        $product_name = $product_subscription['name']." (Expires: ".$date.")";
                        $variationId  = $product_subscription['variation_id'];
                    }
                }else{
                    update_post_meta(get_the_id(),'smarttag_subscription_id','');
                    $product_name = '';
                    $startDate    = '';
                    $date         = '';
                }
            }else{
                $product_name = '';
                $startDate    = '';
                $date         = '';
            }
            
            ?>
            <div class="bottom-border-box">
                <h3>Registered Pet <?php echo ++$i; ?></h3>
                <div class="row">
                    <div class="col-sm-3 rmb-15">
                        <a href="javascript:;" class="show-post">
                            <?php echo get_the_post_thumbnail(); ?>
                        </a>
                    </div>
                    <div class="col-sm-5 rmb-15">
                        <strong>Pet Name:</strong> <a href="javascript:;" class="show-post"><span class="name"><?php echo get_the_title(); ?></span></a>
                        <br>
                        <strong>Pet Type:</strong> <span><?php echo $mypod->display('pet_type'); ?></span>
                        <br>
                        <strong>IDTag Serial Number:</strong> <span class="name"><?php echo $mypod->display('smarttag_id_number'); ?></span>
                        <br>
                        <strong>IDTag Microchip Number:</strong> <span class="name"><?php echo $microchip_id_number; ?></span>
                        <br>
                        <strong>ID Tag Plan:</strong> <span><?php echo $product_name; ?></span>
                    </div>
                    <div class="col-sm-4 mb-elements">                        
                        <form action="" method="post" class="custom-form">
                            <input type="hidden" name="post_id" value="<?php echo get_the_ID(); ?>">
                            <input type="hidden" name="startDate" value="<?php echo $startDate; ?>">
                            <input type="hidden" name="endDate" value="<?php echo $date; ?>">
                            <input type="hidden" name="smarttagid" value="<?php echo $smarttag_id_number; ?>">
                            <?php if (!empty($product_name)) { ?>
                                <p><a href="<?php echo 'https://idtag.agiliscloud.com/my-account/view-subscription/'.$subscriptionId.'/'; ?>" class="button view site-btn-light-blue">Upgrade Protection Plan <i class="fa fa-caret-right"></i></a></p>
                            <?php } ?>
                            <?php
                                $check = checkSmartIDTag(1,'lost_found_pets','pet_status','smarttag_id_number',$smarttag_id_number);
                                if ($check) {
                                    echo '<p><button type="button" class="report-pet-as-lost site-btn-light-blue">Report Pet As Lost <i class="fa fa-caret-right"></i></button></p>';
                                }else{
                                    echo '<p><input type="hidden" name="smarttag_id_number" value="'.$smarttag_id_number.'"><input type="hidden" name="report_pet_as_found" value="1"><button type="button" class="report-pet-as-found site-btn-red">Report Pet As Found <i class="fa fa-caret-right"></i></button></p>';
                                }
                            ?>
                            <p><a href="javascript:;" class="custom-replacement-tag-btn light-blue-link"><strong>Order a free Replacement Tag</strong> <i class="fa fa-caret-right"></i></a></p>
                            <p><a href="javascript:;" class="show-post light-blue-link"><strong>View/Edit Full Pet Profile </strong><i class="fa fa-caret-right"></i></a></p>
                        </form>
                    </div>
                </div>
            </div>
        <?php 
        endwhile;
        $total_pages = $query->max_num_pages;
        if ($total_pages > 1){

            $current_page = max(1, get_query_var('paged'));

            echo paginate_links(array(
                'base' => get_pagenum_link(1) . '%_%',
                'format' => 'page/%#%',
                'current' => $current_page,
                'total' => $total_pages,
                'prev_text'    => __('« prev'),
                'next_text'    => __('next »'),
            ));
        }?>
        <?php
    } else{
        echo "Sorry, No pet found";
    }
        
}

add_action( 'woocommerce_account_report-pet-lost_endpoint', 'my_account_report_pet_lost_content' );
function my_account_report_pet_lost_content() {

    echo "<div class='page-heading'><h1>Report My Pet as Lost</h1></div>"; 

    if (isset($_POST['reportMyPetLost'])) {
        $checkForLost = checkSmartIDTag(1,'lost_found_pets','pet_status','smarttag_id_number',$_POST['smarttag_id_number']);
        if ($checkForLost) {
            $checkForFound = checkSmartIDTag(0,'lost_found_pets','pet_status','smarttag_id_number',$_POST['smarttag_id_number']);
            if ($checkForFound) {
                $title    = $_POST['title'];            
                $new_post = array(
                 'post_title'   => $title,
                 'post_status'  => 'publish',
                 'post_type'    => 'lost_found_pets',
                );
     
                $post_id = wp_insert_post($new_post);
                update_post_meta($post_id,'source_system','SMARTTAG');
                // print_r($new_post);
                foreach ($_POST as $key => $value) {
                    if ($key != 'id' || $key != 'title' || $key != 'attach_id' || $key != 'reportMyPetLost') {
                        update_post_meta($post_id,$key,$value);
                    }
                }
                if (isset($_POST['attach_id']) && !empty($_POST['attach_id'])) {
                    set_post_thumbnail($post_id,$_POST['attach_id']);
                }
                $currentDate = date( 'Y:m:d H:i:s' );
                update_post_meta($postid,'last_modified_date',$currentDate);
                update_post_meta($_POST['id'],'last_lost_date',$currentDate);
            }else{
                $smarttagid = $_POST['smarttag_id_number'];
                $args=array(
                    'post_type' => 'lost_found_pets',
                    'post_status' => 'publish',
                    'posts_per_page' => -1,
                    'meta_query'=>array(
                        'relation' => 'AND',
                            array(
                                'key' => 'smarttag_id_number',
                                'value' => $smarttagid,
                            ),
                            array(
                                'key' => 'pet_status',
                                'value' => 0,
                            ),
                        )
                );
                $query = new WP_Query($args);
                while ( $query->have_posts() ) : $query->the_post();
                    $postid = get_the_id();
                    foreach ($_POST as $key => $value) {
                        if ($key != 'id' || $key != 'title' || $key != 'attach_id' || $key != 'reportMyPetLost') {
                            update_post_meta($postid,$key,$value);
                        }
                    }
                    if (isset($_POST['attach_id']) && !empty($_POST['attach_id'])) {
                        set_post_thumbnail($postid,$_POST['attach_id']);
                    }
                    $currentDate = date( 'Y:m:d H:i:s' );
                    update_post_meta($postid,'last_modified_date',$currentDate);
                    update_post_meta($_POST['id'],'last_lost_date',$currentDate);
                endwhile;   
            }
            echo "<p>Your lost pet will be posted to our Lost & Found Pets page.</p>
                <p>SmartTag and your local shelters have been notified. If your local shelters find your pet you will be contacted by them or SmartTag.</p>
                <p>Please call us at anytime if you have any questions: (888) 379-8880</p>";
        }else{
            echo "<p>Your lost pet will be Already Reported for Lost.</p>
                <p>SmartTag and your local shelters have been notified. If your local shelters find your pet you will be contacted by them or SmartTag.</p>
                <p>Please call us at anytime if you have any questions: (888) 379-8880</p>";
        }
    }elseif (isset($_POST['post_id'])) {
        $postId = $_POST['post_id'];
        $args = array( 'post_type' => 'pet_profile', 'p' => $postId);
        $my_posts = new WP_Query($args); 
        while ( $my_posts->have_posts() ) : $my_posts->the_post(); 
            $mypod              = pods( 'pet_profile', get_the_id() ); 
            $title              = get_the_title();
            $smarttagid         = $mypod->display('smarttag_id_number');
            $pet_type           = $mypod->display('pet_type');
            $primary_breed      = $mypod->display('primary_breed');
            $secondary_breed    = $mypod->display('secondary_breed');
            $primary_color      = $mypod->display('primary_color');
            $secondary_color    = $mypod->display('secondary_color');
            $gender             = $mypod->display('gender');
            $size               = $mypod->display('size');
            $pet_date_of_birth  = $mypod->display('pet_date_of_birth');
            $post_thumbnail_id  = get_post_thumbnail_id( get_the_id() );
            ?>
            <h3>Report Pet as Lost:</h3>
            <div class="row">
                <div class="col-sm-3 rmb-15">
                    <?php echo get_the_post_thumbnail(); ?>
                </div>
                <div class="col-sm-9">
                    <strong>Pet Name:</strong> <span class="name"><?php echo get_the_title(); ?></span>
                    <br>
                    <strong>Pet Type:</strong> <?php echo $mypod->display('pet_type'); ?>
                    <br>
                    <strong>IDTag Serial Number:</strong> <span class="name"><?php echo $mypod->display('smarttag_id_number'); ?></span>
                </div>
            </div>            
        <?php endwhile;
    ?>
    <div class="contact-form">
        <form class="lost-pet-form" action="/my-account/report-pet-lost/" method="post">
            <input type="hidden" name="id" value="<?php echo $postId; ?>">
            <input type="hidden" name="title" value="<?php echo $title; ?>">
            <input type="hidden" name="smarttag_id_number" value="<?php echo $smarttagid; ?>">
            <input type="hidden" name="pet_type" value="<?php echo $pet_type; ?>">
            <input type="hidden" name="primary_breed" value="<?php echo $primary_breed; ?>">
            <input type="hidden" name="secondary_breed" value="<?php echo $secondary_breed; ?>">
            <input type="hidden" name="primary_color" value="<?php echo $primary_color; ?>">
            <input type="hidden" name="secondary_color" value="<?php echo $secondary_color; ?>">
            <input type="hidden" name="gender" value="<?php echo $gender; ?>">
            <input type="hidden" name="size" value="<?php echo $size; ?>">
            <input type="hidden" name="pet_date_of_birth" value="<?php echo $pet_date_of_birth; ?>">
            <input type="hidden" name="attach_id" value="<?php echo $post_thumbnail_id; ?>">
            <div class="lost-pet">
                <div class="field-wrap two-fields-wrap">
                    <div class="field-div">
                        <label>*Pet was lost on</label>
                        <input type="text" name="pet_lost_date" id="pet-lost-date" value="" placeholder="03/29/2018">
                    </div>
                    <div class="field-div">
                        <label>Select country of residence:</label>
                        <?php 
                            $countries_obj = new WC_Countries();
                            $countries = $countries_obj->__get('countries');
                            echo '<select name="country" class="address-country">';
                                foreach ($countries as $key => $value) {
                                    
                                    echo '<option value="'.$key.'" >'.$value.'</option>';
                                }
                            echo '</select>';
                        ?>
                    </div>
                </div>
                <div class="field-wrap two-fields-wrap">
                    <div class="field-div">
                        <label>Address:</label>
                        <input type="text" name="address_line" value="" placeholder="Address Line 1">
                        <input type="text" name="city" value="" placeholder="City">
                    </div>
                    <div class="field-div">
                        <label></label>
                        <input type="text" name="address_line_2" value="" placeholder="Address Line 2">
                        <div class="field-wrap two-fields-wrap">
                            <div class="field-div">
                                <!-- <input type="text" name="state" value="" placeholder="State"> -->
                                <select class="address-state" name="state" data-val=""></select>
                            </div>
                            <div class="field-div">
                                <input type="text" name="zip_code" value="" placeholder="Zip Code">
                            </div>
                        </div>                        
                    </div>
                </div>
                <div class="field-wrap">
                    <div class="field-div">
                        <label>Notes: (Optional)</label>
                        <textarea name="description" placeholder="Write any notes that will helpful for finding your pet..."></textarea>
                    </div>
                </div>
                <div class="field-wrap two-fields-wrap">
                    <div class="field-div">
                        <label>*Reward:</label>
                        <input type="text" name="reward" placeholder="Enter reward amount">
                    </div>
                    <div class="field-div">
                        <label>*Contact Phone Number:</label>
                        <input type="text" name="contact" placeholder="1 (555) 123-1234">
                    </div>
                </div>
                <div class="field-wrap">
                    <div class="field-div mb-15">
                        <label>By clicking “Report as a Lost Pet”:</label>
                        <p>The lost pet’s information and the information entered on this page will be posted to SmartTag’s “<a href="#">Lost & Found Pets</a>” webpage.</p>
                    </div>
                </div>
                <div class="field-wrap two-fields-wrap">
                    <input type="hidden" name="pet_status" value="1">
                    <div class="field-div">
                        <a href="/my-account/report-my-pet-lost/" class="site-btn site-btn-grey">Back</a>
                    </div>
                    <div class="field-div text-right">
                        <input type="submit" name="reportMyPetLost" value="Report as a Lost Pet" class="site-btn-red">
                    </div>
                </div>
            </div>
        </form>
    </div>
    <script type="text/javascript">
        jQuery(document).ready(function($) {
            $("#pet-lost-date").datepicker({
                dateFormat : "mm/dd/yy"
            });
        });
    </script>
   
<?php 
    }
}

add_action( 'woocommerce_account_report-my-pet-lost_endpoint', 'my_account_endpoint_content_for_report_my_pet_lost' );
function my_account_endpoint_content_for_report_my_pet_lost() {
    echo "<div class='page-heading'><h1>Report My Pet as Lost</h1></div>";
    if (isset($_POST['action']) && $_POST['action'] = 'updatePostStatusAndPetStatus') {
        $postid = $_POST['related_post_id'];
        update_post_meta($postid,'pet_status',0);
        $args=array(
            'post_type' => 'found_pet',
            'post_status' => 'publish',
            'posts_per_page' => -1,
            'meta_query'=>array(
                'relation' => 'AND',
                    array(
                        'key' => 'related_post_id',
                        'value' => $postid,
                    ),
                )
        );
        $out = new WP_Query($args);
        while ( $out->have_posts() ) : $out->the_post();
            $post_id = get_the_id();
            if ($post_id != $_POST['post_id']) {
                $my_post = array(
                    'ID'           => $post_id,
                    'post_status'   => 'draft',
                );
                wp_update_post( $my_post );
            }else{
                update_post_meta($post_id,'approve_status',1);
            }
        endwhile;
                
    }
    $user_id = get_current_user_id();
    $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
    $args=array(
        'post_type' => 'pet_profile',
        'posts_per_page' => -1,
        'paged' => $paged,
        'author' => $user_id
    );                       
    $wp_query = new WP_Query($args);
    $i = 0;
    if ($wp_query->have_posts()) {
        while ( $wp_query->have_posts() ) : $wp_query->the_post(); 
            $mypod = pods( 'pet_profile', get_the_id() ); 
            $smarttag_id_number = $mypod->display('smarttag_id_number');
            $subscriptionId  = $mypod->display("smarttag_subscription_id");
            if (!empty($subscriptionId)) {
                $subscription   = wcs_get_subscription($subscriptionId);
                if (!empty($subscription)) {
                    // print_r($subscription);
                    $startDate      = $subscription->get_date("date_created");
                    $enddate           = $subscription->get_date("end");
                    if (empty($enddate)) {
                        $enddate           = $subscription->get_date("next_payment");
                    }
                    $enddate           = date_parse_from_format('Y-m-d H:i:s',$enddate);
                    $enddate           = mktime(0, 0, 0, $enddate['month'], $enddate['day'], $enddate['year']);
                    $enddate           = date("m/d/Y", $enddate);

                    $startDate           = date_parse_from_format('Y-m-d H:i:s',$startDate);
                    $startDate           = mktime(0, 0, 0, $startDate['month'], $startDate['day'], $startDate['year']);
                    $startDate           = date("m/d/Y", $startDate);
                    // $subscription = wc_get_order($subscriptionId);
                    foreach( $subscription->get_items() as $item_id => $product_subscription ){
                        // Get the name
                        $product_name = $product_subscription['name']." (Expires: ".$enddate.")";
                        $variationId  = $product_subscription['variation_id'];
                    }
                }else{
                    update_post_meta(get_the_id(),'smarttag_subscription_id','');
                    $product_name = '';
                    $startDate    = '';
                    $date         = '';
                }
            }else{
                $product_name = '';
                $startDate    = '';
                $date         = '';
            }
            // print_r(get_post_meta(get_the_id(), 'last_lost_date'));
            $lastModifyDates = get_post_meta(get_the_id(), 'last_lost_date');
            if (isset($lastModifyDates[0])) {
                $date = date_parse_from_format('Y:m:d H:i:s',$lastModifyDates[0]);
                $date = mktime(0, 0, 0, $date['month'], $date['day'], $date['year']);
                // echo $date;
                $lastModifyDate = date("m/d/Y", $date);
            }else{
                // echo "else";
                $lastModifyDate = "";
            }
            ?>
            <div class="bottom-border-box">
                <h3>Registered Pet <?php echo ++$i; ?></h3>
                <div class="row">
                    <div class="col-sm-3 rmb-15">
                        <a href="javascript:;" class="show-post">
                            <?php echo get_the_post_thumbnail(); ?>
                        </a>
                    </div>
                    <div class="col-sm-5 rmb-15">
                        <strong>Pet Name:</strong> <a href="javascript:;" class="show-post"><span class="name"><?php echo get_the_title(); ?></span></a>
                        <br>
                        <strong>Pet Type:</strong> <span><?php echo $mypod->display('pet_type'); ?></span>
                        <br>
                        <strong>IDTag Serial Number:</strong> <span class="name"><?php echo $mypod->display('smarttag_id_number'); ?></span>
                        <br>
                        <strong>ID Tag Plan:</strong> <span><?php echo $product_name; ?></span>
                    </div>
                    <div class="col-sm-4 mb-elements">   
                        <form action="" method="post" class="custom-form">
                            <input type="hidden" name="startDate" value="<?php echo $startDate; ?>">
                            <input type="hidden" name="endDate" value="<?php echo $enddate; ?>">
                            <input type="hidden" name="post_id" value="<?php echo get_the_ID(); ?>">
                            <input type="hidden" name="smarttagid" value="<?php echo $smarttag_id_number; ?>">
                            <?php
                                $check = checkSmartIDTag(1,'lost_found_pets','pet_status','smarttag_id_number',$smarttag_id_number);
                                if ($check) {
                                    echo '<p><button type="button" class="report-pet-as-lost site-btn-red">Report Pet As Lost <i class="fa fa-caret-right"></i></button></p>';
                                }else{
                                    echo '
                                    <p class="last-modify-date">REPORTED AS LOST ON: '.$lastModifyDate.' </p><input type="hidden" name="smarttag_id_number" value="'.$smarttag_id_number.'"><input type="hidden" name="report_pet_as_found" value="1"><p><button type="button" class="report-pet-as-found site-btn-light-blue">Report Pet As Found <i class="fa fa-caret-right"></i></button></p>';
                                }
                            ?>
                            <a href="javascript:;" class="show-post"><strong>View/Edit Full Pet Profile</strong> <i class="fa fa-caret-right"></i></a>
                        </form>   
                    </div>
                </div>
            </div>
        <?php 
        endwhile;
        $total_pages = $wp_query->max_num_pages;
        if ($total_pages > 1){

            $current_page = max(1, get_query_var('paged'));

            echo paginate_links(array(
                'base' => get_pagenum_link(1) . '%_%',
                'format' => 'page/%#%',
                'current' => $current_page,
                'total' => $total_pages,
                'prev_text'    => __('« prev'),
                'next_text'    => __('next »'),
            ));
        }
        ?>
        <script type="text/javascript">
            jQuery(document).ready(function(){
                jQuery('.report-pet-as-lost').on('click',function(){
                    jQuery(this).parent('.custom-form').attr("action","/my-account/report-pet-lost");
                    jQuery(this).parent('form.custom-form').submit();
                });
                jQuery('.report-pet-as-found').on('click',function(){
                    jQuery(this).parent('.custom-form').attr("action","/my-account/report-pet-found-list");
                    jQuery(this).parent('form.custom-form').submit();
                });
            });
        </script>
        <?php  
    }else{
        echo "No, data found";
    }
        
}

/*List of pet Pet all founder*/

add_action( 'woocommerce_account_report-pet-found-list_endpoint', 'my_account_endpoint_content_for_show_pet_founder_list' );
function my_account_endpoint_content_for_show_pet_founder_list(){
    echo '<div class="page-heading"><h1>Report My Pet as Lost</h1></div>';
    if (isset($_POST['report_pet_as_found'])) {
        $smarttagid = $_POST['smarttag_id_number'];
        $args=array(
            'post_type' => 'lost_found_pets',
            'post_status' => 'publish',
            'posts_per_page' => -1,
            'meta_query'=>array(
                'relation' => 'AND',
                    array(
                        'key' => 'smarttag_id_number',
                        'value' => $smarttagid,
                    ),
                    array(
                        'key' => 'pet_status',
                        'value' => 1,
                    ),
                )
        );
        $query = new WP_Query($args);
        while ( $query->have_posts() ) : $query->the_post();
            $postid = get_the_id();
        endwhile;
        $args=array(
            'post_type' => 'found_pet',
            'post_status' => 'publish',
            'posts_per_page' => -1,
            'meta_query'=>array(
                'relation' => 'AND',
                    array(
                        'key' => 'related_post_id',
                        'value' => $postid,
                    ),
                    array(
                        'key' => 'approve_status',
                        'value' => 0,
                    ),
                )
        );
        $out = new WP_Query($args);
        if ($out->have_posts()) {
            $i = 0;
            while ( $out->have_posts() ) : $out->the_post();
                $mypod = pods( 'found_pet', get_the_id() );  
                if ($i==0 || $i%2 == 0){
                    echo '<div class="lost-found-row">';                
                }
                                                                                             
                echo '<div class="found-col">
                    <div class="lost-found-col-inner">
                        <div class="lost-found-img">';
                if (has_post_thumbnail( get_the_id() ) ): 
                    the_post_thumbnail(get_the_id());
                endif; 
                echo '</div>
                        
                        <h3 class="lost-found-title"> '.get_the_title().'</h3>
                        <p><strong>ID Tag #:</strong> '.$mypod->display('smarttag').'</p>
                        <p><strong>Finder Name:</strong> '.$mypod->display('finder_name').'</p>
                        <p><strong>Finder Email:</strong> '.$mypod->display('finder_email').'</p>
                        <p><strong>Finder Phone:</strong> '.$mypod->display('phone').'</p>
                        <p><strong>Date:</strong> '.get_the_date('m/d/Y').'</p>
                        <div class="lost-found-mi">
                            <a href="'.get_the_permalink(get_the_id()).'" class="more-info-link">More Info <i class="fa fa-caret-right"></i></a>
                        </div>
                        <div class="lost-found-rm">
                            <form action="/my-account/report-my-pet-lost/" method="post" class="update-post-status">
                                <input type="hidden" name="post_id" value="'.get_the_id().'">
                                <input type="hidden" name="related_post_id" value="'.$postid.'">
                                <input type="hidden" name="action" value="updatePostStatusAndPetStatus">
                                <a href="javascript:;" class="site-btn-success update-post-status-and-pet-status">Yes This is My Pet <i class="fa fa-caret-right"></i></a>
                            </form>
                        </div>
                    </div>
                </div>';
                $j = ++$i;
                if ($j%2 == 0){
                    echo '</div>';
                }
                ?>
                <script type="text/javascript">
                    jQuery("a.update-post-status-and-pet-status").on('click',function(){
                        jQuery(this).parent('form.update-post-status').submit();
                    });
                </script>
                <?php 
        endwhile;
        }else{
            echo "There is no founder for this pet.";
        }
            
    }
}

/*My Pets Information Section*/
add_action( 'woocommerce_account_show-profile_endpoint', 'my_account_endpoint_content_for_show_profile' );
function my_account_endpoint_content_for_show_profile() {
    $userId         = get_current_user_id();
    if (isset($_POST['post_id']) && !empty($_POST['post_id'])) {
        $post_id    = $_POST['post_id'];
        $startDate  = $_POST['startDate'];
        $endDate    = $_POST['endDate'];
        $updateFeature = "";
        $updatePet = "";
        $updateOwner = "";
        $updateUlternate = "";
        $updateVaterian = "";
        $full = "";
        if (isset($_POST['action']) && $_POST['action'] == 'update_owner_information') {
            echo $updateOwner = updateOwnerInformation($_POST,$userId);
        }elseif (isset($_POST['action']) && $_POST['action'] == 'update_alternate_information') {
            echo $updateUlternate = updateAlternateEmergencyInformation($_POST,$userId);
        }elseif (isset($_POST['action']) && $_POST['action'] == 'update_vaterinarian_information') {
            echo $updateVaterian = updateVaterinarianInformation($_POST, $post_id);
        }elseif (isset($_POST['action']) && $_POST['action'] == 'update_all_information') {
            $post_id = $_POST['post_id'];
            updateFeatureImage($_FILES,$post_id);
            updatePetInformation($_POST);
            updateOwnerInformation($_POST,$userId);
            updateAlternateEmergencyInformation($_POST,$userId);
            updateVaterinarianInformation($_POST, $post_id);
            $full = "Data Updated Successfully";
        }

        $id             = $_POST['post_id'];
        $args           = array( 'post_type' => 'pet_profile', 'p' => $id);
        $my_posts       = new WP_Query($args); 
        $countries_obj  = new WC_Countries();
        $countries      = $countries_obj->__get('countries');
        $pcountry       = get_the_author_meta("primary_country",$userId);
        $paddress1      = get_the_author_meta("primary_address_line1",$userId);
        $paddress2      = get_the_author_meta("primary_address_line2",$userId);
        $pcity          = get_the_author_meta("primary_city",$userId);
        $pstate         = get_the_author_meta("primary_state",$userId);
        $ppostCode      = get_the_author_meta("primary_postcode",$userId);

        foreach ($countries as $key => $value) {
            if (!empty($pcountry)) {
                if ($pcountry == $key) {
                    $pcountry = '<br>'.$value;
                    break;
                }
            }else
                break;
        }
        if (!empty($paddress1)) {
            $paddress1 .= ' ';
        }
        if (!empty($paddress2)) {
            $paddress2 .= ' ';
        }
        if (!empty($pcity)) {
            $pcity = '<br>'.$pcity.' City, ';
        }elseif (!empty($paddress2)) {
            $paddress2 .= '<br>';
        }elseif (!empty($paddress1)) {
            $paddress1 .= '<br>';
        }else{
            $paddress1 = '<br>';
        }

        if (!empty($pstate)) {
            $pstate .= ' ';
        }
        if (!empty($ppostCode)) {
            $ppostCode  .= ' ';
        }

        $scountry        = get_the_author_meta("secondary_country",$userId);
        $saddress1       = get_the_author_meta("secondary_address_line1",$userId);
        $saddress2       = get_the_author_meta("secondary_address_line2",$userId);
        $scity           = get_the_author_meta("secondary_city",$userId);
        $sstate          = get_the_author_meta("secondary_state",$userId);
        $spostCode       = get_the_author_meta("secondary_postcode",$userId);

        foreach ($countries as $key => $value) {
            if (!empty($scountry)) {
                if ($scountry == $key) {
                    $scountry = '<br>'.$value;
                    break;
                }
            }else
                break;
        }
        if (!empty($saddress1)) {
            $saddress1 .= ' ';
        }
        if (!empty($saddress2)) {
            $saddress2 .= ' ';
        }
        if (!empty($scity)) {
            $scity = '<br>'.$scity.' City, ';
        }elseif (!empty($saddress2)) {
            $saddress2 .= '<br>';
        }elseif (!empty($saddress1)) {
            $saddress1 .= '<br>';
        }else{
            $saddress1 = '<br>';
        }
        if (!empty($sstate)) {
            $sstate .= ' ';
        }
        if (!empty($spostCode)) {
            $spostCode .= ' ';
        }

        $paddress   = $paddress1.$paddress2.$pcity.$pstate.$ppostCode.$pcountry;
        $saddress   = $saddress1.$saddress2.$scity.$sstate.$spostCode.$scountry;

        while ( $my_posts->have_posts() ) : $my_posts->the_post(); ?>
            <?php $mypod = pods( 'pet_profile', get_the_id() ); ?>
            <?php 
                $id         = get_the_id();
                $shot       = $mypod->display('shot');
                $size       = 0;
                if (strpos($shot, ', ') !== false) {
                    $shots  = explode(', ', $shot);
                    $size   = count($shots);
                    if ($size > 9) {
                        $shot           = 'All';
                    }elseif ($size > 1) {
                       $shots[$size-1]  = substr($shots[$size-1], 4 );
                    }
                }elseif (strpos($shot, ' and ')) {
                    $shots  = explode(' and ', $shot);
                    $size   = count($shots);
                }else{
                    $shots  = $shot;
                }
    
                $neutered   = $mypod->display('neutered_spayed');
                if ($neutered) {
                    $neutered = 'YES';
                }else{
                    $neutered = 'NO';
                }  


                $vcountry        = $mypod->display("vaterinarian_country");
                $vaddress1       = $mypod->display("vaterinarian_address_line_1");
                $vaddress2       = $mypod->display("vaterinarian_address_line_2");
                $vcity           = $mypod->display("vaterinarian_city");
                $vstate          = $mypod->display("vaterinarian_state");
                $vpostCode       = $mypod->display("vaterinarian_zip_code");
                $subscriptionId  = $mypod->display("smarttag_subscription_id");

                foreach ($countries as $key => $value) {
                    if (!empty($scountry)) {
                        if ($vcountry == $key) {
                            $vcountry = '<br>'.$value;
                            break;
                        }
                    }else
                        break;
                }
                if (!empty($vaddress1)) {
                    $vaddress1 .= ' ';
                }
                if (!empty($vaddress2)) {
                    $vaddress2 .= ' ';
                }
                if (!empty($vcity)) {
                    $vcity = '<br>'.$vcity.' City, ';
                }elseif (!empty($vaddress2)) {
                    $vaddress2 .= '<br>';
                }elseif (!empty($vaddress1)) {
                    $vaddress1 .= '<br>';
                }else{
                    $vaddress1 = '<br>';
                }
                if (!empty($vstate)) {
                    $vstate .= ' ';
                }
                if (!empty($vpostCode)) {
                    $vpostCode .= ' ';
                } 

                $vaddress   = $vaddress1.$vaddress2.$vcity.$vstate.$vpostCode.$vcountry;
            ?>
            <div class='page-heading'><h1>Owner Profile Information</h1></div>
            <div class="pp-tabs-wrap">
                <div class="pp-tabs-nav">
                    <div class="view pp-tabs-nav-inner pp-tab-option-1 active">View</div>
                    <div class="view pp-tabs-nav-inner pp-tab-option-2">Edit</div>
                </div>
                <div class="pp-tabs-content pp-tab-content-1" style="display: block;">     
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="acc-blue-box">
                                <div class="acc-blue-head">
                                    Pet Image
                                    <div class="acc-edit owner-edit">
                                        <i class="fa fa-cog"></i> EDIT
                                    </div>
                                </div>
                                <div class="acc-blue-content">
                                    <?php $imageURL = get_the_post_thumbnail_url(); ?>
                                    <img src="<?php echo $imageURL; ?>" alt="Profile Image" />
                                </div>
                            </div>
                            <div class="acc-blue-box">
                                <div class="acc-blue-head">
                                    Found/Lost Status
                                </div>
                                <div class="acc-blue-content">
                                    <form action="" method="post" class="custom-form">
                                        <input type="hidden" name="post_id" value="<?php echo get_the_ID(); ?>">
                                        <?php
                                            $smarttag_id_number = $mypod->display('smarttag_id_number');
                                            $check = checkSmartIDTag(1,'lost_found_pets','pet_status','smarttag_id_number',$smarttag_id_number);
                                            if ($check) {
                                                echo '<p><button type="button" class="report-pet-as-lost site-btn-light-blue">Report Lost <i class="fa fa-caret-right"></i></button></p><p><strong>Found/Lost Status:</strong> Home</p>';
                                            }else{
                                                echo '<input type="hidden" name="smarttag_id_number" value="'.$smarttag_id_number.'"><input type="hidden" name="report_pet_as_found" value="1"><p><button type="button" class="report-pet-as-found site-btn-red">Report Pet As Found <i class="fa fa-caret-right"></i></button></p><p><strong>Found/Lost Status:</strong> Lost</p>';
                                            }
                                        ?>
                                    </form>
                                </div>
                            </div>
                            <div class="acc-blue-box">
                                <div class="acc-blue-head">
                                    Subscription History
                                </div>
                                <div class="acc-blue-content">
                                    <?php 
                                        if ($subscriptionId) {
                                            $subscription = wc_get_order($subscriptionId);
                                            foreach( $subscription->get_items() as $item_id => $product_subscription ){
                                                // Get the name
                                                $product_name = $product_subscription->get_name();
                                            }
                                            echo "<p>".$product_name."   ".$_POST['startDate']." to ".$_POST['endDate']."</p>";
                                            echo '<a href="https://idtag.agiliscloud.com/my-account/view-subscription/'. $subscriptionId.'/" class="button view site-btn-grey">Upgrade Pate Protection Plan</a>';
                                            if ($product_name == "SmartTag ID Tag Protection Plans - Platinum, Lifetime") {
                                                echo "<p style='color:red;'>This Pet is Fully Protected.</p>";
                                            }
                                        }else{
                                            echo $product_name = 'Not Assigned';
                                        }                            
                                    ?>
                                </div>
                            </div>
                            <div class="acc-blue-box">
                                <div class="acc-blue-head">
                                    Vaterinarian Contact Information
                                    <div class="acc-edit owner-edit">
                                        <i class="fa fa-cog"></i> EDIT
                                    </div>
                                </div>
                                <div class="acc-blue-content">
                                    <strong>Address:</strong>
                                    <br>
                                    <?php echo $vaddress; ?>
                                    <br>
                                    <strong>Phone Number:</strong> <?php echo $mypod->display("vaterinarian_primary_phone_number"); ?>
                                </div>
                            </div>
                            <div class="acc-blue-box">
                                <div class="acc-blue-head">
                                    My Pet Alerts
                                </div>
                                <div class="acc-blue-content">

                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="acc-blue-box">
                                <div class="acc-blue-head">
                                    Pet Information
                                    <div class="acc-edit owner-edit">
                                        <i class="fa fa-cog"></i> EDIT
                                    </div>
                                </div>
                                <div class="acc-blue-content">
                                    <strong>Microchip ID Number:</strong> <span></span>
                                    <br>
                                    <strong>ID Tag Serial Number:</strong> <span><?php echo $mypod->display('smarttag_id_number'); ?></span>
                                    <br>
                                    <strong>Pet Name:</strong> <span><?php echo get_the_title(); ?></span>
                                    <br>
                                    <strong>Pet Type:</strong> <span><?php echo $mypod->display('pet_type'); ?></span>
                                    <br>
                                    <strong>Gender:</strong> <span><?php echo $mypod->display('gender'); ?></span>
                                    <br>
                                    <strong>Size:</strong> <span><?php echo $mypod->display('size'); ?></span>
                                    <br>
                                    <strong>Pet Date of Birth:</strong> <span><?php echo $mypod->display('pet_date_of_birth'); ?></span>
                                    <br>
                                    <strong>Primary Breed:</strong> <span><?php echo $mypod->display('primary_breed'); ?></span>
                                    <br>
                                    <strong>Secondary Breed:</strong> <span><?php echo $mypod->display('secondary_breed'); ?></span>
                                    <br>
                                    <strong>Primary Color:</strong> <span><?php echo $mypod->display('primary_color'); ?></span>
                                    <br>
                                    <strong>Secondary Color:</strong> <span><?php echo $mypod->display('secondary_color'); ?></span>
                                    <br>
                                    <strong>Neutered/Spayed:</strong> <span><?php echo $neutered; ?></span>
                                    <br>
                                    <strong>Shots/Vacinations:</strong> <span><?php echo $shot; ?></span>
                                    <br>
                                    <strong>Unique Features:</strong> <span><?php echo $mypod->display('unique_features'); ?></span>
                                    <br>
                                    <strong>Special Needs:</strong> <span><?php echo $mypod->display('special_needs'); ?></span>
                                    <br>
                                    <strong>Allergies:</strong> <span><?php echo $mypod->display('allergies'); ?></span>
                                </div>
                            </div>
                            <div class="acc-blue-box">
                                <div class="acc-blue-head">
                                    Owner Information
                                    <div class="acc-edit owner-edit">
                                        <i class="fa fa-cog"></i> EDIT
                                    </div>
                                </div>
                                <div class="acc-blue-content">
                                    <strong>Email:</strong> <span><?php echo get_the_author_meta("email",$userId); ?></span>
                                    <br>
                                    <strong>First Name:</strong> <span><?php echo get_the_author_meta("first_name",$userId); ?></span>
                                    <br>
                                    <strong>Last Name:</strong> <span><?php echo get_the_author_meta("last_name",$userId); ?></span>
                                    <br>
                                    <strong>Address:</strong>
                                    <br>
                                    <span><?php echo $paddress; ?>
                                    </span>
                                    <br>
                                    <strong>Primary Phone Number:</strong> <span><?php echo get_the_author_meta("primary_home_number",$userId); ?></span>
                                    <br>
                                    <strong>Secondary Phone Number:</strong> <span><?php echo get_the_author_meta("primary_cell_number",$userId); ?></span>
                                </div>
                            </div>
                            <div class="acc-blue-box">
                                <div class="acc-blue-head">
                                    Alternate Emergency Contact
                                    <div class="acc-edit owner-edit">
                                        <i class="fa fa-cog"></i> EDIT
                                    </div>
                                </div>
                                <div class="acc-blue-content">
                                    <strong>Email:</strong> <span><?php echo get_the_author_meta("secondary_email",$userId); ?></span>
                                    <br>
                                    <strong>First Name:</strong> <span><?php echo get_the_author_meta("secondary_first_name",$userId); ?></span>
                                    <br>
                                    <strong>Last Name:</strong> <span><?php echo get_the_author_meta("secondary_last_name",$userId); ?></span>
                                    <br>
                                    <strong>Address:</strong>
                                    <br>
                                    <span><?php echo $saddress; ?></span>
                                    <br>
                                    <strong>Primary Phone Number:</strong> <span><?php echo get_the_author_meta("secondary_home_number",$userId); ?></span>
                                    <br>
                                    <strong>Secondary Phone Number:</strong> <span><?php echo get_the_author_meta("secondary_cell_number",$userId); ?></span>
                                </div>
                            </div>
                            <div class="acc-blue-box">
                                <div class="acc-blue-head">
                                    My Pet Trust
                                </div>
                                <div class="acc-blue-content">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="pp-tabs-content pp-tab-content-2">
                    <div class="contact-form">
                        <div class="acc-blue-box">
                            <form class="uploadImage" method="post" enctype="multipart/form-data">
                                <input type="hidden" name="postId" value="<?php echo get_the_ID(); ?>">
                                <input type="hidden" name="action" value="UploadPetProfileImage">
                                <div class="acc-blue-head">
                                    Pet Image
                                </div>
                                <div class="acc-blue-content">
                                    <div class="row">
                                        <div class="col-sm-6 mb-15">
                                            <h4>Current Pet Image:</h4>
                                            <?php $imageURL = get_the_post_thumbnail_url(); ?>
                                            <img src="<?php echo $imageURL; ?>" alt="Profile Image" />
                                        </div>
                                        <div class="col-sm-6 mb-15">
                                            <h4>Upload New Pet Image:</h4>
                                            <input name="feature" id="feature" type="file">
                                            <p class="field-notice">
                                                Files must be less than 2 MB.
                                                <br>
                                                Allowed file types: .png / .gif / .jpg / .jpeg
                                            </p>
                                        </div>
                                    </div>
                                    <div class="text-center">
                                        <input type="submit" value="Save" class="site-btn-red">
                                    </div>
                                    <div class="field-wrap submit-wrap text-center">
                                        <div class="field-div error-div"></div>
                                    </div> 
                                </div>
                            </form>
                        </div>           
                        <div class="acc-blue-box">
                            <form class="updatePetInformations" method="post" enctype="multipart/form-data">
                                <input type="hidden" name="postId" value="<?php echo get_the_ID(); ?>">
                                <input type="hidden" name="action" value="updatePetInformations">
                                <div class="acc-blue-head">
                                    Pet Information
                                </div>
                                <div class="acc-blue-content">
                                    <div class="field-wrap two-fields-wrap">
                                        <div class="field-div">
                                            <label>*Pet Name:</label>
                                            <input type="text" name="title" value="<?php echo get_the_title(); ?>" required="">
                                        </div>
                                        <div class="field-div">
                                            <div class="field-wrap two-fields-wrap">
                                                <div class="field-div">
                                                    <label>*Gender:</label>
                                                    <select name="gender">
                                                        <option value="male" <?php if ($mypod->display('gender') == 'male'){ echo "selected"; } ?>>Male</option>
                                                        <option value="female" <?php if ($mypod->display('gender') == 'female'){ echo "selected"; } ?>>Female</option>
                                                    </select> 
                                                </div>
                                                <div class="field-div">
                                                    <label>*Pet Type:</label>
                                                    <input type="text" name="pet_type" value="<?php echo $mypod->display('pet_type'); ?>" required="">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="field-wrap two-fields-wrap">
                                        <div class="field-div">
                                            <label>Primary Breed:</label>
                                            <input type="text" name="primary_breed" value="<?php echo $mypod->display('primary_breed'); ?>">
                                        </div>
                                        <div class="field-div">
                                            <label>Secondary Breed:</label>
                                            <input type="text" name="secondary_breed" value="<?php echo $mypod->display('secondary_breed'); ?>">
                                        </div>
                                    </div>
                                    <div class="field-wrap two-fields-wrap">
                                        <div class="field-div">
                                            <label>Primary Color:</label>
                                            <input type="text" name="primary_color" value="<?php echo $mypod->display('primary_color'); ?>">
                                        </div>
                                        <div class="field-div">
                                            <label>Secondary Color(s):</label>
                                            <input type="text" name="secondary_color" value="<?php echo $mypod->display('secondary_color'); ?>">
                                        </div>
                                    </div>
                                    <div class="field-wrap two-fields-wrap">
                                        <div class="field-div">
                                            <label>Size:</label>
                                            <input type="text" name="size" value="<?php echo $mypod->display('secondary_color'); ?>">
                                        </div>
                                        <div class="field-div">
                                            <label>Pet Date of Birth:</label>
                                            <input type="text" name="pet_date_of_birth" value="<?php echo $mypod->display('pet_date_of_birth'); ?>" id="dob">
                                        </div>
                                    </div>
                                    <div class="field-wrap two-fields-wrap">
                                        <div class="field-div">
                                            <label>Neutered/Spayed:</label>
                                            <select name="neutered_spayed">
                                                <option value="1" <?php if ($mypod->display('neutered_spayed') == 1){ echo "selected"; } ?>>Yes</option>
                                                <option value="0" <?php if ($mypod->display('neutered_spayed') == 0){ echo "selected"; } ?>>No</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="field-wrap">
                                        <div class="field-div">
                                            <label>Shots/Vacinations:</label>
                                            <div class="two-checks mb-15">
                                                <p><input type="checkbox" name="shot[]" value="Canine Distemper" class="shot">Canine Distemper</p>
                                                <p><input type="checkbox" name="shot[]" value="Parainfluenza" class="shot">Parainfluenza</p>
                                                <p><input type="checkbox" name="shot[]" value="Measles" class="shot">Measles</p>
                                                <p><input type="checkbox" name="shot[]" value="Bordetella" class="shot">Bordetella</p>
                                                <p><input type="checkbox" name="shot[]" value="Parvovirus" class="shot">Parvovirus</p>
                                                <p><input type="checkbox" name="shot[]" value="Leptospirosis" class="shot">Leptospirosis</p>
                                                <p><input type="checkbox" name="shot[]" value="Hepatitis" class="shot">Hepatitis</p>
                                                <p><input type="checkbox" name="shot[]" value="Coronavirustitis" class="shot">Coronavirustitis</p>
                                                <p><input type="checkbox" name="shot[]" value="Rabies" class="shot">Rabies</p>
                                                <p><input type="checkbox" name="shot[]" value="Lyme" class="shot">Lyme</p>
                                                <p><input type="checkbox" name="shot[]" value="Respiratory disease from canine adenovirus-2 (CAV-2)" class="shot">Respiratory disease from canine adenovirus-2 (CAV-2)</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="field-wrap">
                                        <div class="field-div">
                                            <label>Unique Features:</label>
                                            <textarea name="unique_features"><?php echo $mypod->display('unique_features'); ?></textarea>
                                        </div>
                                    </div>
                                    <div class="field-wrap">
                                        <div class="field-div">
                                            <label>Special Needs:</label>
                                            <textarea name="allergies"><?php echo $mypod->display('allergies'); ?></textarea>
                                        </div>
                                    </div>
                                    <div class="field-wrap">
                                        <div class="field-div">
                                            <label>Allergies:</label>
                                            <textarea name="allergies"><?php echo $mypod->display('allergies'); ?></textarea>
                                        </div>
                                    </div>
                                    <div class="field-wrap submit-wrap text-center">
                                        <input type="submit" value="Save" class="site-btn-red">
                                    </div>
                                    <div class="field-wrap submit-wrap text-center">
                                        <div class="field-div error-div"></div>
                                    </div> 
                                </div>
                            </form>
                        </div> 
                        <div class="acc-blue-box">
                            <form class="updateOwnerInformation" method="post" enctype="multipart/form-data">
                                <input type="hidden" name="action" value="updateOwnerInformations">
                                <div class="acc-blue-head">
                                    Owner Information
                                </div>
                                <div class="acc-blue-content">
                                    <div class="field-wrap two-fields-wrap">
                                        <div class="field-div">
                                            <label>*First Name:</label>
                                            <input type="text" name="primary_first_name" value="<?php echo get_the_author_meta("first_name",$userId); ?>" required="">
                                        </div>
                                        <div class="field-div">
                                            <label>Last Name:</label>
                                            <input type="text" name="primary_last_name" value="<?php echo get_the_author_meta("last_name",$userId); ?>">
                                        </div>
                                    </div>                            
                                    <div class="field-wrap">
                                        <div class="field-div">
                                            <label>Country:</label>
                                            <?php 
                                                $country = get_the_author_meta("primary_country",$userId);
                                                $countries_obj = new WC_Countries();
                                                $countries = $countries_obj->__get('countries');
                                                echo '<select name="primary_country" class="address-country">';
                                                    foreach ($countries as $key => $value) {
                                                        if ($country == $key) {
                                                            echo '<option value="'.$key.'" selected>'.$value.'</option>';
                                                        }else{

                                                           echo '<option value="'.$key.'" >'.$value.'</option>';
                                                        }
                                                    }
                                                echo '</select>';
                                            ?>
                                        </div>
                                    </div>
                                    <div class="field-wrap two-fields-wrap">
                                        <div class="field-div">
                                            <label>*Address:</label>
                                            <input type="text" name="primary_address_line1" value="<?php echo get_the_author_meta("primary_address_line1",$userId); ?>" required="">
                                            <input type="text" name="primary_city" value="<?php echo get_the_author_meta("primary_city",$userId); ?>" required="">
                                        </div>
                                        <div class="field-div">
                                            <label></label>
                                            <input type="text" name="primary_address_line2" value="<?php echo get_the_author_meta("primary_address_line2",$userId); ?>">
                                            <div class="field-wrap two-fields-wrap">
                                                <div class="field-div">
                                                    <!-- <input type="text" name="primary_state" value="<?php echo get_the_author_meta("primary_state",$userId); ?>"> -->
                                                    <select class="address-state" name="primary_state" data-val="<?php echo get_the_author_meta("primary_state",$userId);  ?>"></select>
                                                </div>
                                                <div class="field-div">
                                                    <input type="text" name="primary_postcode" value="<?php echo get_the_author_meta("primary_postcode",$userId); ?>" required="">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="field-wrap two-fields-wrap">
                                        <div class="field-div">
                                            <label>*Primary Phone Number:</label>
                                            <input type="text" name="primary_home_number" value="<?php echo get_the_author_meta("primary_home_number",$userId); ?>" required="">
                                        </div>
                                        <div class="field-div">
                                            <label>Secondary Phone Number:</label>
                                            <input type="text" name="primary_cell_number" value="<?php echo get_the_author_meta("primary_cell_number",$userId); ?>">
                                        </div>
                                    </div> 
                                    <div class="field-wrap two-fields-wrap">
                                        <div class="field-div">
                                            <label>Email:</label>
                                            <input type="email" name="primary_email" id="primary_email" value="<?php echo get_the_author_meta("email",$userId); ?>" readonly>
                                            <span class="error-email"></span>
                                        </div>
                                    </div> 
                                    <div class="field-wrap submit-wrap text-center">
                                        <div class="field-div">
                                            <input type="submit" value="Save" class="site-btn-red">
                                        </div>
                                    </div> 
                                    <div class="field-wrap submit-wrap text-center">
                                        <div class="field-div error-div"></div>
                                    </div> 
                                </div>
                            </form>
                        </div> 
                        <div class="acc-blue-box">
                            <form class="updateAlternateEmergencyInformation" method="post" enctype="multipart/form-data">
                                <input type="hidden" name="action" value="updateAlternateEmergencyInformations">
                                <div class="acc-blue-head">
                                    Alternate Emergency Contact
                                </div>
                                <div class="acc-blue-content">
                                    <div class="field-wrap two-fields-wrap">
                                        <div class="field-div">
                                            <label>*First Name:</label>
                                            <input type="text" name="secondary_first_name" value="<?php echo get_the_author_meta("secondary_first_name",$userId); ?>" required="">
                                        </div>
                                        <div class="field-div">
                                            <label>Last Name:</label>
                                            <input type="text" name="secondary_last_name" value="<?php echo get_the_author_meta("secondary_last_name",$userId); ?>">
                                        </div>
                                    </div>                            
                                    <div class="field-wrap">
                                        <div class="field-div">
                                            <label>Country:</label>
                                            <?php 
                                                $country = get_the_author_meta("secondary_country",$userId);
                                                $countries_obj = new WC_Countries();
                                                $countries = $countries_obj->__get('countries');
                                                echo '<select name="secondary_country" class="address-country">';
                                                    foreach ($countries as $key => $value) {
                                                        if ($country == $key) {
                                                            echo '<option value="'.$key.'" selected>'.$value.'</option>';
                                                        }else{

                                                           echo '<option value="'.$key.'" >'.$value.'</option>';
                                                        }
                                                    }
                                                echo '</select>';
                                            ?>
                                        </div>
                                    </div>
                                    <div class="field-wrap two-fields-wrap">
                                        <div class="field-div">
                                            <label>*Address:</label>
                                            <input type="text" name="secondary_address_line1" value="<?php echo get_the_author_meta("secondary_address_line1",$userId); ?>" required="">
                                            <input type="text" name="secondary_city" value="<?php echo get_the_author_meta("secondary_city",$userId); ?>" required="">
                                        </div>
                                        <div class="field-div">
                                            <label></label>
                                            <input type="text" name="secondary_address_line2" value="<?php echo get_the_author_meta("secondary_address_line2",$userId); ?>">
                                            <div class="field-wrap two-fields-wrap">
                                                <div class="field-div">
                                                    <!-- <input type="text" name="secondary_state" value="<?php echo get_the_author_meta("secondary_state",$userId); ?>"> -->
                                                    <select class="address-state" name="secondary_state" data-val="<?php echo get_the_author_meta("secondary_state",$userId);  ?>"></select>
                                                </div>
                                                <div class="field-div">
                                                    <input type="text" name="secondary_postcode" value="<?php echo get_the_author_meta("secondary_postcode",$userId); ?>" required="">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="field-wrap two-fields-wrap">
                                        <div class="field-div">
                                            <label>*Primary Phone Number:</label>
                                            <input type="text" name="secondary_home_number" value="<?php echo get_the_author_meta("secondary_home_number",$userId); ?>" required="">
                                        </div>
                                        <div class="field-div">
                                            <label>Secondary Phone Number:</label>
                                            <input type="text" name="secondary_cell_number" value="<?php echo get_the_author_meta("secondary_cell_number",$userId); ?>">
                                        </div>
                                    </div> 
                                    <div class="field-wrap two-fields-wrap">
                                        <div class="field-div">
                                            <label>*Email:</label>
                                            <input type="email" name="secondary_email" id="secondary_email" value="<?php echo get_the_author_meta("secondary_email",$userId); ?>" required="">
                                            <span class="error-email"></span>
                                        </div>
                                    </div> 
                                    <div class="field-wrap submit-wrap text-center">
                                        <div class="field-div">
                                            <input type="submit" value="Save" class="site-btn-red">
                                        </div>
                                    </div> 
                                    <div class="field-wrap submit-wrap text-center">
                                        <div class="field-div error-div"></div>
                                    </div> 
                                </div>
                            </form>
                        </div>
                        <div class="acc-blue-box">
                            <form class="updateVaterinarianInformation" method="post" enctype="multipart/form-data">
                                <input type="hidden" name="action" value="updateVaterinarianInformations">
                                <input type="hidden" name="postId" value="<?php echo $post_id; ?>">
                                <div class="acc-blue-head">
                                    Vaterinarian Contact Information
                                </div>
                                <div class="acc-blue-content">
                                    <div class="field-wrap two-fields-wrap">
                                        <div class="field-div">
                                            <label>*Clinic Name:</label>
                                            <input type="text" name="clinic_name" value="<?php echo $mypod->display("clinic_name"); ?>" required="">
                                        </div>
                                        <div class="field-div">
                                            <label>*Vaterinarian First/Last Name:</label>
                                            <input type="text" name="vaterinarian_firstlast_name" value="<?php echo $mypod->display("vaterinarian_firstlast_name"); ?>" required="">
                                        </div>
                                    </div>                            
                                    <div class="field-wrap two-fields-wrap">
                                        <div class="field-div">
                                            <label>Country:</label>
                                            <?php 
                                                $country = $mypod->display("vaterinarian_country");
                                                $countries_obj = new WC_Countries();
                                                $countries = $countries_obj->__get('countries');
                                                echo '<select name="vaterinarian_country" class="address-country">';
                                                    foreach ($countries as $key => $value) {
                                                        if ($country == $key) {
                                                            echo '<option value="'.$key.'" selected>'.$value.'</option>';
                                                        }else{

                                                           echo '<option value="'.$key.'" >'.$value.'</option>';
                                                        }
                                                    }
                                                echo '</select>';
                                            ?>
                                        </div>
                                        <div class="field-div">
                                            <label>*Email:</label>
                                            <input type="email" name="vaterinarian_email" id="vaterinarian_email" value="<?php echo $mypod->display("vaterinarian_email"); ?>">
                                            <span class="error-email" required=""></span>
                                        </div>
                                    </div>
                                    <div class="field-wrap two-fields-wrap">
                                        <div class="field-div">
                                            <label>*Address:</label>
                                            <input type="text" name="vaterinarian_address_line_1" value="<?php echo $mypod->display("vaterinarian_address_line_1"); ?>" required="">
                                            <input type="text" name="vaterinarian_city" value="<?php echo $mypod->display("vaterinarian_city"); ?>" required="">
                                        </div>
                                        <div class="field-div">
                                            <label></label>
                                            <input type="text" name="vaterinarian_address_line_2" value="<?php echo $mypod->display("vaterinarian_address_line_2"); ?>">
                                            <div class="field-wrap two-fields-wrap">
                                                <div class="field-div">
                                                    <!-- <input type="text" name="vaterinarian_state" value="<?php echo $mypod->display("vaterinarian_state"); ?>"> -->
                                                    <select class="address-state" name="vaterinarian_state" data-val="<?php echo $mypod->display("vaterinarian_state");  ?>"></select>
                                                </div>
                                                <div class="field-div">
                                                    <input type="text" name="vaterinarian_zip_code" value="<?php echo $mypod->display("vaterinarian_zip_code"); ?>" required="">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="field-wrap two-fields-wrap">
                                        <div class="field-div">
                                            <label>*Primary Phone Number:</label>
                                            <input type="text" name="vaterinarian_primary_phone_number" value="<?php echo $mypod->display("vaterinarian_primary_phone_number"); ?>" required="">
                                        </div>
                                        <div class="field-div">
                                            <label>Secondary Phone Number:</label>
                                            <input type="text" name="vaterinarian_secondary_phone_number" value="<?php echo $mypod->display("vaterinarian_secondary_phone_number"); ?>">
                                        </div>
                                    </div>
                                    <div class="field-wrap submit-wrap text-center">
                                        <div class="field-div">
                                            <input type="submit" value="Save" class="site-btn-red">
                                        </div>
                                    </div> 
                                    <div class="field-wrap submit-wrap text-center">
                                        <div class="field-div error-div"></div>
                                    </div> 
                                </div>
                            </form>
                        </div>                     
                        <!-- <div class="last-button">
                            <div class="text-right">
                                <input type="button" name="update_all_information" id="update_all_information" value="Save All" class="site-btn-red">
                            </div>
                        </div> -->
                    </div>
                </div>
            </div>
            <script type="text/javascript">
                jQuery(document).ready(function(){
                    jQuery(".shown").click(function(){
                        jQuery(".main-show").show();
                        jQuery(".main-edit").hide();
                    });
                    jQuery(".edited").click(function(){
                        jQuery(".main-show").hide();
                        jQuery(".main-edit").show();
                    });
                    jQuery(".edit-url").click(function(){
                        jQuery(".main-show").hide();
                        jQuery(".main-edit").show();
                    });
                    $('form.uploadImage').on('submit', function (e) {
                       e.preventDefault();
                        $.ajax({
                                 type: 'POST',
                                 url: ajaxurl,
                                 data: new FormData(this),
                                 contentType: false,
                                 processData: false,
                                 dataType: 'json',
                                 success: function(response) {
                                    if (response.success) {
                                        $("form.uploadImage .error-div").html('<div class="alert alert-success alert-dismissible" style="margin-top:18px;"><a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a><strong>Success!</strong> '+response.msg+'</div>');
                                    }else{
                                        $("form.uploadImage .error-div").html('<div class="alert alert-danger alert-dismissible" style="margin-top:18px;"><a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>'+response.msg+'</div>');
                                    }
                                }
                        }); 

                    });

                    $(function() {        
                        $("form[class='updatePetInformations']").validate({
                            submitHandler: function(form) {
                                $.ajax({
                                    type: 'POST',
                                    url: ajaxurl,
                                    data: new FormData(form),
                                    contentType: false,
                                    processData: false,
                                    dataType: 'json',
                                    success: function(response) {
                                        if (response.success) {
                                            $("form[class='updatePetInformations'] .error-div").html('<div class="alert alert-success alert-dismissible" style="margin-top:18px;"><a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a><strong>Success!</strong> '+response.msg+'</div>');
                                        }else{
                                            $("form[class='updatePetInformations'] .error-div").html('<div class="alert alert-danger alert-dismissible" style="margin-top:18px;"><a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>'+response.msg+'</div>');
                                        }
                                    }
                                }); 
                            }   
                        });
                        $("form[class='updateOwnerInformation']").validate({
                            submitHandler: function(form) {
                                $.ajax({
                                    type: 'POST',
                                    url: ajaxurl,
                                    data: new FormData(form),
                                    contentType: false,
                                    processData: false,
                                    dataType: 'json',
                                    success: function(response) {
                                        console.log(response.msg);
                                        if (response.success) {
                                            $("form[class='updateOwnerInformation'] .error-div").html('<div class="alert alert-success alert-dismissible" style="margin-top:18px;"><a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a><strong>Success!</strong> '+response.msg+'</div>');
                                        }else{
                                            $("form[class='updateOwnerInformation'] .error-div").html('<div class="alert alert-danger alert-dismissible" style="margin-top:18px;"><a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>'+response.msg+'</div>');
                                        }
                                    }
                                }); 
                            }   
                        });
                        $("form[class='updateAlternateEmergencyInformation']").validate({
                            submitHandler: function(form) {
                                $.ajax({
                                    type: 'POST',
                                    url: ajaxurl,
                                    data: new FormData(form),
                                    contentType: false,
                                    processData: false,
                                    dataType: 'json',
                                    success: function(response) {
                                        if (response.success) {
                                            $("form[class='updateAlternateEmergencyInformation'] .error-div").html('<div class="alert alert-success alert-dismissible" style="margin-top:18px;"><a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a><strong>Success!</strong> '+response.msg+'</div>');
                                        }else{
                                            $("form[class='updateAlternateEmergencyInformation'] .error-div").html('<div class="alert alert-danger alert-dismissible" style="margin-top:18px;"><a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>'+response.msg+'</div>');
                                        }
                                    }
                                }); 
                            }   
                        });
                        $("form[class='updateVaterinarianInformation']").validate({
                            submitHandler: function(form) {
                                $.ajax({
                                    type: 'POST',
                                    url: ajaxurl,
                                    data: new FormData(form),
                                    contentType: false,
                                    processData: false,
                                    dataType: 'json',
                                    success: function(response) {
                                        if (response.success) {
                                            $("form[class='updateVaterinarianInformation'] .error-div").html('<div class="alert alert-success alert-dismissible" style="margin-top:18px;"><a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a><strong>Success!</strong> '+response.msg+'</div>');
                                        }else{
                                            $("form[class='updateVaterinarianInformation'] .error-div").html('<div class="alert alert-danger alert-dismissible" style="margin-top:18px;"><a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>'+response.msg+'</div>');
                                        }
                                    }
                                }); 
                            }   
                        });
                    });
                    /*jQuery("#update_all_information").click(function(){
                        var val     = jQuery(this).attr('name');
                        var vemail  = jQuery("#vaterinarian_email").val();
                        var semail  = jQuery("#secondary_email").val();
                        var pemail  = jQuery("#primary_email").val();
                        var output  = 1;
                        jQuery("#action").val(val);
                        if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,5})+$/.test(vemail)){
                            jQuery("#vaterinarian_email").next('.error-email').text("");
                        }else{
                            jQuery("#vaterinarian_email").next('.error-email').text("Enter Currect format of email address");
                            output = 0;
                        }
                        if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,5})+$/.test(semail)){
                            jQuery("#secondary_email").next('.error-email').text("");
                        }else{
                            jQuery("#secondary_email").next('.error-email').text("Enter Currect format of email address");
                            output = 0;
                        }
                        if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,5})+$/.test(pemail)){
                            jQuery("#primary_email").next('.error-email').text("");
                        }else{
                            jQuery("#primary_email").next('.error-email').text("Enter Currect format of email address");
                            output = 0;
                        }

                        if (output) {
                            jQuery("form.update-form").submit();
                        }else{
                            return false;
                        }
                    });
                    jQuery(document).ready(function($) {
                        $("#dob").datepicker({
                            dateFormat : "mm/dd/yy"
                        });
                    });*/
                });
            </script>
       <?php 
            if ($size > 9) { ?>
                <script type="text/javascript">
                    jQuery(document).ready(function(){
                        jQuery(".shot").each(function(){
                            jQuery(this).attr("checked","checked");
                        });
                        
                    });
                </script>
            
        <?php   
            }else{ 
                if ($size > 1) {
                    foreach ($shots as $value) { ?>
                        <script type="text/javascript">
                            jQuery(document).ready(function(){
                                jQuery(".shot").each(function(){
                                    var shot  = jQuery(this).val();
                                    var shot2 = '<?php echo $value;  ?>';
                                    if (shot == shot2) {
                                        jQuery(this).attr("checked","checked");
                                    }
                                });
                                
                            });
                        </script>            
        <?php           
                    }
                }else{ ?>
                    <script type="text/javascript">
                        jQuery(document).ready(function(){
                            jQuery(".shot").each(function(){
                                var shot  = jQuery(this).val();
                                var shot2 = '<?php echo $shot;  ?>';
                                if (shot == shot2) {
                                    jQuery(this).attr("checked","checked");
                                }
                            });
                            
                        });
                    </script>
                    
        <?php   }  
           
            }
        endwhile;
    }
}

add_action('wp_ajax_updatePetInformations', 'handle_updatePetInformation');
add_action('wp_ajax_nopriv_updatePetInformations', 'handle_updatePetInformation');
function handle_updatePetInformation(){
    echo updatePetInformation($_POST,$_POST['postId']);
    exit();
}
add_action('wp_ajax_updateOwnerInformations', 'handle_updateOwnerInformation');
add_action('wp_ajax_updateOwnerInformations', 'handle_updateOwnerInformation');
function handle_updateOwnerInformation(){
    $userId = get_current_user_id();
    echo updateOwnerInformation($_POST,$userId,0);
    exit();
}
add_action('wp_ajax_updateAlternateEmergencyInformations', 'handle_updateAlternateEmergencyInformation');
add_action('wp_ajax_updateAlternateEmergencyInformations', 'handle_updateAlternateEmergencyInformation');
function handle_updateAlternateEmergencyInformation(){
    $userId = get_current_user_id();
    echo updateAlternateEmergencyInformation($_POST,$userId);
    exit();
}
add_action('wp_ajax_updateVaterinarianInformations', 'handle_updateVaterinarianInformation');
add_action('wp_ajax_updateVaterinarianInformations', 'handle_updateVaterinarianInformation');
function handle_updateVaterinarianInformation(){
    $postId = $_POST['postId'];
    echo updateVaterinarianInformation($_POST,$postId);
    exit();
}

/*Section for add or remove pet*/

add_action( 'woocommerce_account_add-pet-id-my-account_endpoint', 'my_account_endpoint_content_for_add_pet_id_my_account' );
function my_account_endpoint_content_for_add_pet_id_my_account() {
$user_id                    = get_current_user_id(); 
$single                     = true; 
$current_user               = get_user_by( 'id', $user_id );
$first_name                 = get_user_meta( $user_id, 'first_name', $single ); 
$last_name                  = get_user_meta( $user_id, 'last_name', $single ); 
$email                      = $current_user->user_email; 
$primary_country            = get_user_meta( $user_id, 'primary_country', $single ); 
$primary_address_line1      = get_user_meta( $user_id,'primary_address_line1', $single ); 
$primary_address_line2      = get_user_meta( $user_id,'primary_address_line2', $single ); 
$primary_city               = get_user_meta( $user_id,'primary_city', $single ); 
$primary_state              = get_user_meta( $user_id,'primary_state', $single ); 
$primary_postcode           = get_user_meta( $user_id,'primary_postcode', $single ); 
$primary_home_number        = get_user_meta( $user_id,'primary_home_number', $single ); 
$primary_cell_number        = get_user_meta( $user_id,'primary_cell_number', $single ); 

$Sfirst_name                = get_user_meta( $user_id, 'secondary_first_name', $single ); 
$Slast_name                 = get_user_meta( $user_id, 'secondary_last_name', $single ); 
$Semail                     = get_user_meta( $user_id, 'secondary_email', $single );
$Sprimary_country           = get_user_meta( $user_id, 'secondary_country', $single ); 
$Sprimary_address_line1     = get_user_meta( $user_id,'secondary_address_line1', $single ); 
$Sprimary_address_line2     = get_user_meta( $user_id,'secondary_address_line2', $single ); 
$Sprimary_city              = get_user_meta( $user_id,'secondary_city', $single ); 
$Sprimary_state             = get_user_meta( $user_id,'secondary_state', $single ); 
$Sprimary_postcode          = get_user_meta( $user_id,'secondary_postcode', $single ); 
$Sprimary_home_number       = get_user_meta( $user_id,'secondary_home_number', $single ); 
$Sprimary_cell_number       = get_user_meta( $user_id,'secondary_cell_number', $single );



 

$countries_obj = new WC_Countries();
$countries = $countries_obj->__get('countries'); 
?>
<div class="page-heading">
    <h1>Add a Pet ID to My Account</h1>
</div>
<section class="multi-step-form">
    <form id="profileuser1" method="POST" enctype="multipart/form-data">        
        <fieldset aria-label="Step One" tabindex="-1" id="step-1" class="step-form-box">
            <input type="hidden" name="userId" value="<?php echo $user_id; ?>">
            <div class="contact-form" id="pro-info">    
                <div class="field-wrap two-fields-wrap">
                    <div class="field-div">
                        <label>*Serial Number: </label>
                        <input type="text" placeholder="Serial Number" name="smarttag_id_number" class="text-data sereal-number-1" id="sname_input" required="" />
                        <span class="error" id="error"></span>
                    </div>
                    <div class="field-div">
                        <label> </label>
                        <input type="text" name="conf_smarttag_id_number" placeholder="Serial Number" class="sereal-number-2" />
                    </div>                          
                </div>
                <div class="field-wrap two-fields-wrap">
                    <div class="field-div">
                        <label>*Pet Name</label>
                        <input type="text" name="pet_name" class="text-data" id="pname_input"  placeholder="Enter Pet Name" required="" />
                    </div>
                </div>
                <div class="field-wrap two-fields-wrap">
                    <div class="field-div">
                        <label>*Pet Type & Breed: </label>
                        <div class="field-wrap two-fields-wrap">
                            <div class="field-div">
                                <select name="pet_type" class="text-data" id="pettypeajax" required=""  >
                                    <option value="">Type</option>
                                    <option value="type1">Type1</option>
                                    <option value="type2">Type2</option>
                                </select>
                            </div>
                            <div class="field-div">
                               <select name="primary_breed" class="text-data" id="breedid" required="" >
                                    <option value="">Breed</option>
                                    <option value="breed1">Breed1</option>
                                    <option value="breed3">Breed2</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="field-div">
                        <label>Secondary Breed: (Optional)</label>
                        <select name="secondary_breed" class="text-data" id="sbreedid" >
                            <option value="">Breed</option>
                                    <option value="breed1">Breed1</option>
                                    <option value="breed3">Breed2</option>
                        </select>
                    </div>
                </div>
                <div class="field-wrap two-fields-wrap">
                    <div class="field-div">
                        <label>*Primay Color: </label>
                        <input type="text" name="primary_color" placeholder="Enter color of pet" class="text-data" id="pcolor" required="" />
                    </div>
                    <div class="field-div">
                        <label>Secondary Color(s): (Optional)</label>
                        <input type="text" name="secondary_color" placeholder="Enter color(s) of pet" class="text-data" id="scolor" />
                    </div>
                </div>
                <div class="field-wrap two-fields-wrap">
                    <div class="field-div">
                        <div class="field-wrap two-fields-wrap">
                            <div class="field-div">
                                <label>*Gender: </label>
                                <select name="gender" class="text-data" id="pgender" required="" ="" >
                                    <option value="">Select</option>
                                    <option>Male</option>
                                    <option>Female</option>
                                </select>
                            </div>
                            <div class="field-div">
                                <label>Size(Optional): </label>
                               <select name="size" class="text-data" id="psize">
                                    <option value="">Select</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="field-div">
                        <label>Pet Date of Birth: (optional)</label>
                        <div class="field-wrap three-fields-wrap ">
                            <input type="text" name="pet_date_of_birth" id="pet-dob1" placeholder="mm/dd/yy" class="input-10 input text-data">
                        </div>
                    </div>
                </div>  
                    <div class="field-wrap two-fields-wrap">
                         <label>*Upload Pet Image: (Optional however in the event your pet is lost a picture is very helpful)</label>
                        <div class="field-div">
                            <label class="auto-height"><?php __('Upload Pet Image)', 'cvf-upload'); ?></label>
                            <input type="file" name="files[]" accept="image/*" class="files-data" multiple id="imgInp" required=""  />
                           
                        </div>
                        <div class="field-div">
                            <label></label>
                            <div class="field-notice">
                                Files must be less then 2MB. 
                                <br>
                                Allowed file types .png/ .gif/ .jpg/ .jpeg
                            </div>
                        </div>
                    </div> 
                <div class="step-btns" id="step">
                    <button class="btn btn-default btn-next" type="button" aria-controls="step-2">Next <i class="fa fa-caret-right"></i></button>
                   
                </div>
            </div>
        </fieldset>
        <fieldset aria-label="Step Two" tabindex="-1" id="step-2" class="step-form-box">
            <div class="contact-form" id="cus-info">
               <div class="field-wrap two-fields-wrap">
                    <div class="field-div">
                        <label>*First Name: </label>
                        <input type="text" name="p_fst_name" placeholder="First Name" class="user-data" id="u-first" required="" value="<?php echo $first_name;?>" />
                    </div>
                    <div class="field-div">
                        <label>*Last Name: </label>
                        <input type="text" name="p_lst_name" placeholder="Last Name" value="<?php echo $last_name;?>" class="user-data" id="u-last" required=""  />
                    </div>
                </div>
                <div class="field-wrap two-fields-wrap">
                    <div class="field-div">
                        <label>*Email: </label>
                        <input type="text" name="p_email" placeholder="Enter Email Address" value="<?php echo $email;?>" class="user-data" id="u-email" required="" disabled   />
                    </div>
                    <div class="field-div">
                        <label>*Password: </label>
                        <input type="password" name="password" placeholder="Enter Password" class="user-data"   />
                    </div>                          
                </div>
                <div class="field-wrap">
                    <div class="field-div">
                        <label>*Select Your Country: </label>
                        <select name="p_country" class="user-data address-country" id="u-country" required="" >
                        <option value="">Select</option>
                        <!-- <option value="">Select</option> -->
                            <?php foreach ($countries as $key => $value) {?>
                            <option value="<?php echo $key; ?>" <?php if(!empty($primary_country) && $primary_country  == $key){ echo 'selected="selected"';}?>><?php echo $value;?></option>
                            <?php } ?>
                    </select>
                        

                    </div>
                </div>
                <div class="field-wrap two-fields-wrap">                            
                    <div class="field-div">
                        <label>*Address: </label>
                        <input type="text" name="p_add1" placeholder="Address line 1" class="user-data" id="u-add1" required="" value="<?php echo $primary_address_line1;?>"  />
                        <input type="text" name="p_city" placeholder="City" class="user-data" id="u-city1" value="<?php echo $primary_city;?>" />
                    </div>
                    <div class="field-div">
                        <label></label>
                        <input type="text" name="p_add2" placeholder="Address line 2" class="user-data" id="u-add2" value="<?php echo $primary_address_line2;?>"  />
                        <div class="field-wrap two-fields-wrap">
                            <div class="field-div">
                                <!-- <input type="text" name="p_state" class="user-data" id="u-state" value="<?php echo $primary_state;?>" > -->
                                <select class="user-data address-state" id="u-state" name="p_state" data-val="<?php echo $primary_state;?>"></select>
                            </div>
                            <div class="field-div">
                                <input type="text" name="p_zipcode" placeholder="Zipcode" class="user-data" id="u-zip" value="<?php echo $primary_postcode;?>" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="field-wrap two-fields-wrap">
                    <div class="field-div">
                        <label>*Primay Phone Number: </label>
                        <input type="tel" name="p_prm_no" placeholder="1(555) 123-1234" class="user-data" id="p-phone"  value="<?php echo $primary_home_number;?>" />
                        <!-- <input type="tel" name="p_prm_no" placeholder="1(555) 123-1234" class="user-data" id="p-phone"  required="" value="<?php echo $primary_home_number;?>" /> -->
                    </div>
                    <div class="field-div">
                        <label>Secondary Phone Number: </label>
                        <input type="tel" name="p_sec_no" placeholder="1(555) 123-1234" class="user-data" id="ps-phone" value="<?php echo $primary_cell_number;?>" />
                    </div>
                </div>
            </div>
            <div class="step-accordion">
                <h4 class="step-acc-head" id="sec-form"><i class="fa fa-plus"></i> Enter Secondary Contact Informantion (Optional)</h4>
                <div class="step-acc-content">
                                                        <div class="contact-form" id="sec-cont-info">
                        <div class="field-wrap two-fields-wrap">
                            <div class="field-div">
                                <label>First Name: </label>
                                <input type="text" name="s_fst_name" placeholder="First Name" class="user-data" id="s-name" value="<?php echo $Sfirst_name;?>" />
                            </div>
                            <div class="field-div">
                                <label>Last Name: </label>
                                <input type="text" name="s_lst_name" placeholder="Last Name" class="user-data" id="s-lstname" value="<?php echo $Slast_name;?>" />
                            </div>
                        </div>
                        <div class="field-wrap two-fields-wrap">
                            <div class="field-div">
                                <label>Email: </label>
                                <input type="text" name="s_email" placeholder="Enter Email Address" class="user-data" id="s-email" value="<?php echo $Semail;?>" />
                            </div>
                            <div class="field-div">
                                <label>Select Your Country: </label>
                                <select name="s_country" class="user-data address-country" id="s-county" required="">
                                    <option value="">Select</option>
                                    <?php foreach ($countries as $key => $value) {?>
                                    <option value="<?php echo $key; ?>" <?php if(!empty($Sprimary_country) && $Sprimary_country  == $key){ echo 'selected="selected"';}?>><?php echo $value;?></option>
                                    <?php } ?>
                                        </select>
                                
                            </div>
                        </div>
                        <div class="field-wrap two-fields-wrap">
                            <div class="field-div">
                                <label>Address: </label>
                                <input type="text" name="s_add1" placeholder="Address line 1" class="user-data" id="sadd1" value="<?php echo $Sprimary_address_line1;?>" />
                                <input type="text" name="s_city" placeholder="City" class="user-data" id="s_city1" value="<?php echo $Sprimary_city;?>" />
                            </div>
                            <div class="field-div">
                                <label></label>
                                <input type="text" name="s_add2" placeholder="Address line 2" class="user-data" id="s-add2" value="<?php echo $Sprimary_address_line2;?>" />
                                <div class="field-wrap two-fields-wrap">
                                    <div class="field-div">
                                        <!-- <input type="text" name="s_state" class="user-data" id="s-sate" required="" value="<?php echo $Sprimary_state;?>" > -->
                                        <select class="user-data address-state" id="s-sate" name="s_state" data-val="<?php echo $Sprimary_state;?>"></select>
                                    </div>
                                    <div class="field-div">
                                        <input type="text" name="s_zipcode" placeholder="Zipcode" class="user-data" id="s-zip" value="<?php echo $Sprimary_postcode;?>" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="field-wrap two-fields-wrap">
                            <div class="field-div">
                                <label>Primay Phone Number: </label>
                                <input type="tel" name="s_prm_no" placeholder="1(555) 123-1234" class="user-data" id="sp-phone" value="<?php echo $Sprimary_home_number;?>" />
                            </div>
                            <div class="field-div">
                                <label>Secondary Phone Number: </label>
                                <input type="tel" name="s_sec_no" placeholder="1(555) 123-1234" class="user-data" id="ss-phone" value="<?php echo $Sprimary_cell_number;?>" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="step-accordion">
                <h4 class="step-acc-head" id="vt-form"><i class="fa fa-plus"></i> Enter Veterinarian Contact Informantion (Optional)</h4>
                <div class="step-acc-content">
                    <div class="contact-form" id="vetcont-info">
                        <div class="field-wrap two-fields-wrap">
                            <div class="field-div">
                                <label>First Name: </label>
                                <input type="text" name="vaterinarian_first_name" placeholder="First Name" class="text-data" id="v-first" />
                            </div>
                            <div class="field-div">
                                <label>Last Name: </label>
                                <input type="text" name="vaterinarian_last_name" placeholder="Last Name" class="text-data" id="v-last" />
                            </div>
                        </div>
                        <div class="field-wrap two-fields-wrap">
                            <div class="field-div">
                                <label>Email: </label>
                                <input type="email" name="vaterinarian_email" placeholder="Enter Email Address" class="text-data" id="v-email" />
                            </div>
                            <div class="field-div">
                                <label>Select Your Country: </label>
                                <select name="vaterinarian_country" class="user-data address-country" id="v-cuntry" >
                                    <option value="">Select</option>
                                    <?php foreach ($countries as $key => $value) {?>
                                    <option value="<?php echo $key; ?>"><?php echo $value;?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="field-wrap two-fields-wrap">
                            <div class="field-div">
                                <label>Address: </label>
                                <input type="text" name="vaterinarian_address_line_1" placeholder="Address line 1" class="text-data" id="v-add1" />
                                <input type="text" name="vaterinarian_city" placeholder="City" class="text-data" id="v-city1" />
                            </div>
                            <div class="field-div">
                                <label></label>
                                <input type="text" name="vaterinarian_address_line_2" placeholder="Address line 2" class="text-data" id="v-add2" />
                                <div class="field-wrap two-fields-wrap">
                                     <div class="field-div">
                                        <!-- <input type="text" name="vaterinarian_state" class="text-data" id="v-state" > -->
                                        <select class="text-data address-state" id="v-state" name="vaterinarian_state" data-val=""></select>
                                        </div>
                                     <div class="field-div">
                                       <input type="text" name="vaterinarian_zip_code" placeholder="Zipcode" class="text-data" id="v-zip" />
                                     </div>
                                </div>
                            </div>
                        </div>
                        <div class="field-wrap two-fields-wrap">
                            <div class="field-div">
                                <label>Primary Phone Number: </label>
                                <input type="tel" name="vaterinarian_primary_phone_number" placeholder="1(555) 123-1234" class="text-data" id="v-prim"/>
                            </div>
                            <div class="field-div">
                                <label>Secondary Phone Number: </label>
                                <input type="tel" name="vaterinarian_secondary_phone_number" placeholder="1(555) 123-1234" class="text-data" id="v-sec" />
                            </div>                          
                        </div>
                        <!-- <div class="field-wrap two-fields-wrap">
                            <div class="field-div">
                                <input type="submit" name="submit" value="Sumbit Pet Veterinarian Info">
                            </div>
                        </div>   -->
                    </div>
                </div>
            </div>
            <div class="step-btns">
                <button class="btn btn-default btn-prev" type="button" aria-controls="step-1"><i class="fa fa-caret-left"></i> Back</button>
                <button class="btn btn-default btn-next" type="button" aria-controls="step-3">Next <i class="fa fa-caret-right"></i></button>
            </div>
        </fieldset>
        <fieldset aria-label="Step Three" tabindex="-1" id="step-3" class="step-form-box">
            <div class="pp-tabs-content steps-pp-tabs-content" style="display: block;">
                <div class="pp-icon-wrap">
                    <div class="pp-icon"></div>
                    <h3>Pet Protection Plans</h3>
                </div>
                <div class="pp-table-wrap">
                    <table class="pp-table">
                    
                        <thead id="myDIV">
                            <tr>
                                <th class="pp-upgrade">
                                    <div>Upgrade to lifetime plan and save up to 80%</div>
                                </th>
                                <th class="pp-silver">
                                    <h2>SILVER</h2>
                                    <div class="pp-membership-plan">
                                        <div class="pp-plan-name">Id Tag 1 Year Plan</div>
                                        <div class="pp-plan-price">
                                            <h3>$6.95</h3>
                                            <span>per year</span>
                                        </div>
                                        <div class="pp-adc-btn">
                                            <a href="javascript:void(0)" id="Stsil1" filed="productid" proid="6858" class="site-btn subPlans" price="6.95" PlanNm="Id Tag 1 Year Plan">Add to Cart <i class="fa fa-shopping-cart"></i></a>
                                        </div>
                                    </div>
                                    <div class="pp-membership-plan">
                                        <div class="pp-plan-name">Id Tag 5 Year Plan</div>
                                        <div class="pp-plan-price">
                                            <h3>$24.95</h3>
                                            <span>per year</span>
                                        </div>
                                        <div class="pp-adc-btn">
                                            <a href="javascript:void(0)" id="Stsil2" filed="productid" proid="6856" class="site-btn subPlans" price="24.95" PlanNm="Id Tag 5 Year Plan">Add to Cart <i class="fa fa-shopping-cart"></i></a>
                                        </div>
                                    </div>
                                    <div class="pp-membership-plan">
                                        <div class="pp-plan-name">Id Tag Lifetime Plan</div>
                                        <div class="pp-plan-price">
                                            <h3>$39.95</h3>
                                            <span>per year</span>
                                        </div>
                                        <div class="pp-adc-btn">
                                            <a href="javascript:void(0)" id="Stsil3" filed="productid" proid="6857" class="site-btn subPlans" PlanNm="Id Tag 5 Year Plan" price="39.95">Add to Cart <i class="fa fa-shopping-cart"></i></a>
                                        </div>
                                    </div>
                                </th>
                                <th class="pp-gold">
                                    <h2>GOLD</h2>
                                    <div class="pp-membership-plan">
                                        <div class="pp-plan-name">Id Tag 1 Year Plan</div>
                                        <div class="pp-plan-price">
                                            <h3>$14.95</h3>
                                            <span>per year</span>
                                        </div>
                                        <div class="pp-adc-btn">
                                            <a href="javascript:void(0)" id="Sgol1" filed="productid" proid="6852" class="site-btn subPlans" price="14.95" PlanNm="Id Tag 1 Year Plan">Add to Cart <i class="fa fa-shopping-cart"></i></a>
                                        </div>
                                    </div>
                                    <div class="pp-membership-plan">
                                        <div class="pp-plan-name">Id Tag 5 Year Plan</div>
                                        <div class="pp-plan-price">
                                            <h3>$49.95</h3>
                                            <span>per year</span>
                                        </div>
                                        <div class="pp-adc-btn">
                                            <a href="javascript:void(0)" id="Sgol2" filed="productid" proid="6850" class="site-btn subPlans" price="49.95" PlanNm="Id Tag 5 Year Plan">Add to Cart <i class="fa fa-shopping-cart"></i></a>
                                        </div>
                                    </div>
                                    <div class="pp-membership-plan">
                                        <div class="pp-plan-name">Id Tag Lifetime Plan</div>
                                        <div class="pp-plan-price">
                                            <h3>$69.95</h3>
                                            <span>per year</span>
                                        </div>
                                        <div class="pp-adc-btn">
                                            <a href="javascript:void(0)" id="Sgol3" filed="productid" proid="6851" class="site-btn subPlans" price="69.95" PlanNm="Id Tag Lifetime Plan">Add to Cart <i class="fa fa-shopping-cart"></i></a>
                                        </div>
                                    </div>
                                </th>
                                <th class="pp-platinum">
                                    <h2>PLATINUM</h2>
                                    <div class="pp-membership-plan">
                                        <div class="pp-plan-name">Id Tag 1 Year Plan</div>
                                        <div class="pp-plan-price">
                                            <h3>$24.95</h3>
                                            <span>per year</span>
                                        </div>
                                        <div class="pp-adc-btn">
                                            <a href="javascript:void(0)" id="spla1" filed="productid" proid="6855" class="site-btn subPlans" price="24.95" PlanNm="Id Tag 1 Year Plan">Add to Cart <i class="fa fa-shopping-cart"></i></a>
                                        </div>
                                    </div>
                                    <div class="pp-membership-plan">
                                        <div class="pp-plan-name">Id Tag 5 Year Plan</div>
                                        <div class="pp-plan-price">
                                            <h3>$79.95</h3>
                                            <span>per year</span>
                                        </div>
                                        <div class="pp-adc-btn">
                                            <a href="javascript:void(0)" id="spla2" filed="productid" proid="6853" class="site-btn subPlans" price="79.95" PlanNm="Id Tag 5 Year Plan">Add to Cart <i class="fa fa-shopping-cart"></i></a>
                                        </div>
                                    </div>
                                    <div class="pp-membership-plan">
                                        <div class="pp-plan-name">Id Tag Lifetime Plan</div>
                                        <div class="pp-plan-price">
                                            <h3>$129.95</h3>
                                            <span>per year</span>
                                        </div>
                                        <div class="pp-adc-btn">
                                            <a href="javascript:void(0)" id="spla3" filed="productid" proid="6854" class="site-btn subPlans" plan="Id Tag Lifetime Plan" price="129.95" PlanNm="Id Tag Lifetime Plan">Add to Cart <i class="fa fa-shopping-cart"></i></a>
                                        </div>
                                    </div>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="pp-benefits pp-benefits1">
                                    <span class="pp-benefit-icon"></span>
                                    <i class="fa fa-plus"></i>
                                    Instant Broadcast Alert
                                </td>
                                <td>
                                    <i class="fa fa-check"></i>
                                </td>
                                <td>
                                    <i class="fa fa-check"></i>
                                </td>
                                <td>
                                    <i class="fa fa-check"></i>
                                </td>
                            </tr>
                            <tr>
                                <td class="pp-benefits pp-benefits2">
                                    <span class="pp-benefit-icon"></span>
                                    <i class="fa fa-plus"></i>
                                    24/7 Toll Free Live Emergency Support
                                </td>
                                <td>
                                    <i class="fa fa-check"></i>
                                </td>
                                <td>
                                    <i class="fa fa-check"></i>
                                </td>
                                <td>
                                    <i class="fa fa-check"></i>
                                </td>
                            </tr>
                            <tr>
                                <td class="pp-benefits pp-benefits3">
                                    <span class="pp-benefit-icon"></span>
                                    <i class="fa fa-plus"></i>
                                    Metal Collar ID Tag
                                </td>
                                <td>
                                    <i class="fa fa-check"></i>
                                </td>
                                <td>
                                    <i class="fa fa-check"></i>
                                </td>
                                <td>
                                    <i class="fa fa-check"></i>
                                </td>
                            </tr>
                            <tr>
                                <td class="pp-benefits pp-benefits4">
                                    <span class="pp-benefit-icon"></span>
                                    <i class="fa fa-plus"></i>
                                    All SmartTags Are Searchable on Google
                                </td>
                                <td>
                                    <i class="fa fa-check"></i>
                                </td>
                                <td>
                                    <i class="fa fa-check"></i>
                                </td>
                                <td>
                                    <i class="fa fa-check"></i>
                                </td>
                            </tr>
                            <tr>
                                <td class="pp-benefits pp-benefits5">
                                    <span class="pp-benefit-icon"></span>
                                    <i class="fa fa-plus"></i>
                                    Free Pet and owner Profile updates anytime.
                                </td>
                                <td>
                                    <i class="fa fa-check"></i>
                                </td>
                                <td>
                                    <i class="fa fa-check"></i>
                                </td>
                                <td>
                                    <i class="fa fa-check"></i>
                                </td>
                            </tr>
                            <tr>
                                <td class="pp-benefits pp-benefits6">
                                    <span class="pp-benefit-icon"></span>
                                    <i class="fa fa-plus"></i>
                                    Free Pet Medical Insurance (30 Days)
                                </td>
                                <td>
                                    <i class="fa fa-check"></i>
                                </td>
                                <td>
                                    <i class="fa fa-check"></i>
                                </td>
                                <td>
                                    <i class="fa fa-check"></i>
                                </td>
                            </tr>
                            <tr>
                                <td class="pp-benefits pp-benefits7">
                                    <span class="pp-benefit-icon"></span>
                                    <i class="fa fa-plus"></i>
                                    Instant Lost Pet Posters
                                </td>
                                <td>
                                    <i class="fa fa-check"></i>
                                </td>
                                <td>
                                    <i class="fa fa-check"></i>
                                </td>
                                <td>
                                    <i class="fa fa-check"></i>
                                </td>
                            </tr>
                            <tr>
                                <td class="pp-benefits pp-benefits8">
                                    <span class="pp-benefit-icon"></span>
                                    <i class="fa fa-plus"></i>
                                    Registration with national AAHA
                                </td>
                                <td>
                                    <i class="fa fa-check"></i>
                                </td>
                                <td>
                                    <i class="fa fa-check"></i>
                                </td>
                                <td>
                                    <i class="fa fa-check"></i>
                                </td>
                            </tr>
                            <tr>
                                <td class="pp-benefits pp-benefits9">
                                    <span class="pp-benefit-icon"></span>
                                    <i class="fa fa-plus"></i>
                                    Live Emergency Response Team
                                </td>
                                <td></td>
                                <td>
                                    <i class="fa fa-check"></i>
                                </td>
                                <td>
                                    <i class="fa fa-check"></i>
                                </td>
                            </tr>
                            <tr>
                                <td class="pp-benefits pp-benefits10">
                                    <span class="pp-benefit-icon"></span>
                                    <i class="fa fa-plus"></i>
                                    Pet Poison Helpline
                                    <br>
                                    <span>($69 value)</span>
                                </td>
                                <td></td>
                                <td></td>
                                <td>
                                    <i class="fa fa-check"></i>
                                </td>
                            </tr>
                            <tr>
                                <td class="pp-benefits pp-benefits11">
                                    <span class="pp-benefit-icon"></span>
                                    <i class="fa fa-plus"></i>
                                    Free Engraving on Replacement Tags
                                </td>
                                <td></td>
                                <td></td>
                                <td>
                                    <i class="fa fa-check"></i>
                                </td>
                            </tr>
                            <tr>
                                <td class="pp-benefits pp-benefits12">
                                    <span class="pp-benefit-icon"></span>
                                    <i class="fa fa-plus"></i>
                                    Lost Pet Reward $100
                                </td>
                                <td></td>
                                <td></td>
                                <td>
                                    <i class="fa fa-check"></i>
                                </td>
                            </tr>
                            <tr>
                                <td class="pp-benefits pp-benefits13">
                                    <span class="pp-benefit-icon"></span>
                                    <i class="fa fa-plus"></i>
                                    Pet Reminder Alerts
                                    <br>
                                    <span>(Flea and tick medication, heart worm, vaccinations etc...)</span>
                                </td>
                                <td></td>
                                <td></td>
                                <td>
                                    <i class="fa fa-check"></i>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="step-btns">
                <button class="btn btn-default btn-prev" type="button" aria-controls="step-2"><i class="fa fa-caret-left"></i> Back</button>
                <button class="btn btn-default btn-next ste4" type="button" aria-controls="step-4">Skip Protection Plan <i class="fa fa-caret-right"></i></button>
            </div>
        </fieldset>
        <fieldset aria-label="Step Four" tabindex="-1" id="step-4" class="step-form-box">
            <div class="blue-border-box">
                <div class="pp-icon-wrap">
                    <div class="pp-icon pp-icon-plus"></div>
                    <h3>Pet Insurance</h3>
                </div>
                <div class="blue-box-content">
                    <h3>30-Days of PetFirst Pet Insurance
                    <br>
                    Included with your SmartTag Membership</h3>
                    <p>Veterinary costs continue to rise, and at SmartTag we want to provide you with an introductory pet insurance plan to help reimburse you for your pet’s veterinary expenses. We are the only ID Tag company to include pet insurance with our membership.</p>
                    <div class="row">
                        <div class="col-sm-4">
                            <h4>Plan Details</h4>
                            <p>Aggregate Benefit Limit: $1,000
                                <br>
                                Per-Incident Limit: $500
                                <br>
                                Pet-Incident Deductible: $50
                                <br>
                                Reimbursement: 90%
                            </p>
                        </div>
                        <div class="col-sm-8">
                            <div class="row">
                                <div class="col-sm-12">
                                    <h4>What is Covered?</h4>
                                </div>
                                <div class="col-sm-4">
                                    <p>• Accidents
                                        <br>
                                        • Illnesses
                                        <br>
                                        • Exam Fees
                                        <br>
                                        • X-rays
                                    </p>
                                </div>
                                <div class="col-sm-4">
                                    <p>• Medications
                                        <br>
                                        • Ultrasounds
                                        <br>
                                        • Hospital Stays
                                        <br>
                                        • Surgeries
                                    </p>
                                </div>
                                <div class="col-sm-4">
                                    <p>• Alternative Therapies
                                        <br>
                                        • Diagnostic Tests
                                        <br>
                                        • Holistic Care
                                        <br>
                                        • Much more!
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <h4>What Is Not Covered?</h4>
                        </div>
                        <div class="col-sm-3">
                            <p>
                                • Special Diets
                                <br>
                                • Routine Wellness
                                <br>
                                • Spay/Neuter
                            </p>
                        </div>
                        <div class="col-sm-3">
                            <p>
                                • Pre-Existing Conditions
                                <br>
                                • Preventative Conditions
                                <br>
                                • Chronic Conditions
                            </p>
                        </div>
                        <div class="col-sm-3">
                            <p>
                                • Hereditary Conditions
                                <br>
                                • Congenital Conditions
                                <br>
                                • Behavior Training
                            </p>
                        </div>
                        <div class="col-sm-3">
                            <p>
                                • Organ Transplants
                                <br>
                                • Elective Procedures
                            </p>
                        </div>
                    </div>
                </div>
                <div class="step-check-wrap">
                    <div class="step-check">
                        <input type="radio" name="health_insurance" id="heth_id" value="7500" class="" />
                        <label>Accept my free 30 days of pet health insurance</label>
                    </div>
                    <div class="step-check">
                        <input type="radio" name="health_insurance" id="heth_id1"/>
                        <label>I don't want my free 30 days of pet health insurance</label>
                    </div>
                </div>
            </div>
            <div class="blue-border-box">
                <div class="pp-icon-wrap">
                    <div class="pp-icon pp-icon-foot"></div>
                    <h3>Pet Protection Arrangement </h3>
                </div>
                <div class="blue-box-content">
                    <h3>What's the difference between a SmartTag PetCare Protection Arrangement and a Pet Trust?</h3>
                    <p>A Pet Protection Arrangement, like a Pet Trust is a legal document used to ensure that your pets are fully cared for and protected in case you should become ill, not be able to keep or take care of vour pets, or pass away. The difference is that a Pet Trust is a more formal and costly document that is normally prepared by an attorney who specializes in estate planning and has experience in pet trusts. Pet trusts are normally used when a substantial amount of money is being left to care for the pets or they are very high profile. A Pet Protection Arrangement is all the protection most pet owners need to ensure proper care and safety for their pets.</p>
                    <p>
                        <img src="<?php bloginfo('template_url'); ?>-child/images/red-table.jpg" alt="image" />
                    </p>
                    <p><strong>Price: $</strong></p>
                </div>
                <div class="step-check-wrap">
                    <div class="step-check">
                        <input  class="" type="radio" name="protectionArrangement" value="6138" id="PetArg" />
                        <label>I would like to add a Pet Protection Arrangement</label>
                    </div>
                    <div class="step-check">
                        <input type="radio" name="protectionArrangement" id="PetArg1" />
                        <label>I would not like to add a Pet Protection Arrangement</label>
                    </div>
                </div>
            </div>
            <div class="step-btns">
                <button class="btn btn-default btn-prev" type="button" aria-controls="step-3"><i class="fa fa-caret-left"></i> Back</button>
                <button class="btn btn-default btn-next skip2" type="button" aria-controls="step-5">Skip All Offers <i class="fa fa-caret-right"></i></button>
                
            </div>                          
        </fieldset>
         <fieldset aria-label="Step Five" tabindex="-1" id="step-5" class="step-form-box">
            <p>
                <strong>Please review that your information is correct.</strong>
                <br>
                You can edit this information if you need to.
            </p>
            <div class="acc-blue-box">
                <div class="acc-blue-head">
                    Pet Protection Plan
                    <div class="acc-edit engrave-edit">
                        <i class="fa fa-cog"></i> EDIT
                    </div>
                </div>
                <div class="acc-blue-content">
                    <div class="row">
                        <div class="col-sm-12">
                            <span id="pln"></span> <span class="color-grey" id="PlnPrice"></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="acc-blue-box">
                <div class="acc-blue-head">
                    Pet Protection Arrangement
                    <div class="acc-edit engrave-edit">
                        <i class="fa fa-plus"></i> ADD
                    </div>
                </div>
                <div class="acc-blue-content">
                    <div class="row">
                        <div class="col-sm-12">
                            <strong id="Arrangement">None</strong>
                        </div>
                    </div>
                </div>
            </div>
            <div class="acc-blue-box">
                <div class="acc-blue-head">
                    Pet Health Insurance
                    <div class="acc-edit engrave-edit">
                        <i class="fa fa-minus"></i> REMOVE
                    </div>
                </div>
                <div class="acc-blue-content">
                    <div class="row">
                        <div class="col-sm-12">
                            <strong id="Insurance">Free Month</strong>
                        </div>
                    </div>
                </div>
            </div>
            <div class="acc-blue-box">
                <div class="acc-blue-head">
                    Registered Pet
                    <div class="acc-edit engrave-edit">
                        <i class="fa fa-cog"></i> EDIT
                    </div>
                </div>
                <div class="acc-blue-content">
                    <div class="row">
                        <div class="col-sm-6">
                            <strong>SmartTag ID Number:</strong> <span id="sname"></span>
                            <br>
                            <strong>Pet Name:</strong> <span id="petname"></span>
                            <br>
                            <strong>Pet Type:</strong> <span id="petype"></span>
                            <br>
                            <strong>Primary Breed:</strong> <span id="bredid"></span>
                            <br>
                            <strong>Secondary Breed:</strong> <span id="sbredid"></span>
                            <br>
                            <strong>Primary Color:</strong> <span id="pcol"></span>
                            <br>
                            <strong>Secondary Color:</strong> <span id="scol"></span>
                            <br>
                            <strong>Gender:</strong> <span id="gen"></span>
                            <br>
                            <strong>Size:</strong> <span id="siz"></span>
                            <br>
                            <strong>Pet Date of Birth:</strong> <span id="ptdob"></span>
                        </div>
                        <div class="col-sm-6">
                            <p><strong>Pet Image:</strong></p>
                             <img id="blah" src="#" alt="your image" />
                        </div>
                    </div>
                </div>
            </div>
            <div class="acc-blue-box">
                <div class="acc-blue-head">
                    Contact Information
                    <div class="acc-edit engrave-edit">
                        <i class="fa fa-cog"></i> EDIT
                    </div>
                </div>
                <div class="acc-blue-content">
                    <div class="row">
                        <div class="col-sm-6 mar-bot">
                            <p><strong class="color-light-blue">Primary Contact:</strong></p>
                            <strong>Email:</strong> <span id="pemail"></span>
                            <br>
                            <strong>First Name:</strong> <span id="pfnam"></span>
                            <br>
                            <strong>Last Name:</strong> <span id="plnam"></span>
                            <br>
                            <strong>Address:</strong> 
                            <br>
                            <span id="uadd1"></span>
                            <br>
                            <span id="ucity1"></span>,<span id="uzip"></span>
                            <br>
                            <span id="ustte"></span>,<span id="ucounty"></span>
                            <br>
                            <strong>Primary Phone Number:</strong> <span id="pnum"></span>
                            <br>
                            <strong>Secondary Phone Number:</strong> <span id="snum"></span>
                        </div>
                        <div class="col-sm-6 mar-bot">
                            <p><strong class="color-light-blue">Veterinarian Information:</strong></p>
                            <strong>Email:</strong> <span id="vemail"></span>
                            <br>
                            <strong>First Name:</strong> <span id="vname"></span>
                            <br>
                            <strong>Last Name:</strong> <span id="vlst"></span>
                            <br>
                            <strong>Address:</strong> <span id="vadd"></span>
                            <br>
                            <span id="vadd1"></span>,<span id="vadd2"></span>
                            <br>
                            <span id="vcity"></span>,<span id="vzip"></span>
                            <br>
                            <span id="vstate"></span>,<span id="vcounty"></span>
                            <br>
                            <strong>Primary Phone Number:</strong> <span id="vprim"></span>
                            <br>
                            <strong>Secondary Phone Number:</strong> <span id="vsec"></span>
                        </div>
                        <div class="col-sm-6">
                            <p><strong class="color-light-blue">Secondary Contact:</strong></p>
                            <strong>Email:</strong> <span id="semail"></span>
                            <br>
                            <strong>First Name:</strong> <span id="sfirst"></span>
                            <br>
                            <strong>Last Name:</strong> <span id="slst"></span>
                            <br>
                            <strong>Address:</strong>
                            <br>
                            <span id="sadd"></span>
                            <br>
                            <span id="scity"></span><span id="szip"></span>
                            <br>
                             <span id="sttate"></span><span id="scounty"></span>
                            <br>
                            <strong>Primary Phone Number:</strong> <span id="sprino"></span>
                            <br>
                            <strong>Secondary Phone Number:</strong> <span id="sseno"></span>
                        </div>
                    </div>
                </div>
            </div>
            <p class="step-check-wrap">
                <div class="step-check">
                    <input type="checkbox" name="" />
                    <label>I agree to the <a href="javascript:;">terms and conditions</a></label>
                </div>
            </p>
            <div class="step-btns">
                <button class="btn btn-default btn-prev" type="button" aria-controls="step-4"><i class="fa fa-caret-left"></i> Back</button>
                <button class="btn btn-default" type="submit">Checkout and Register Microchip <i class="fa fa-caret-right"></i></button>
            </div>  
            </fieldset>
    </form> 
</section>                  
             

<?php }

add_action( 'woocommerce_account_pet-profile_endpoint', 'my_account_endpoint_content_pet_profile' );
function my_account_endpoint_content_pet_profile() {

    if ($_GET['id']) {
        echo do_shortcode("[gravityform id=1]");            
    }else{
        echo "Please hit right URL";
    }
}

/*Add Extra fields in woocommerce my account owner Information*/

add_action( 'woocommerce_save_account_details', 'my_save_extra_profile_fields' );


/*Add extra field in user profile*/
add_action( 'show_user_profile', 'my_show_extra_profile_fields' );
add_action( 'edit_user_profile', 'my_show_extra_profile_fields' );

function my_show_extra_profile_fields( $user ) { 

    $country = esc_attr( get_the_author_meta( 'primary_country', $user->ID ) );
    $alert = esc_attr( get_the_author_meta( 'primary_argent_alert', $user->ID ) );
    $secondarycountry = esc_attr( get_the_author_meta( 'secondary_country', $user->ID ) );
    $secondaryalert = esc_attr( get_the_author_meta( 'secondary_argent_alert', $user->ID ) );
    $countries_obj = new WC_Countries();
    $countries = $countries_obj->__get('countries');
    ?>

<!-- Business Name INPUTS -->
    
    <h3>Business Informations </h3>
    <table class="form-table">
        <tr>
            <th><label for="Business Name">Business Name</label></th>
            <td>
                  <input type="text" name="business_name" id="business_name" value="<?php echo esc_attr( get_the_author_meta( 'business_name', $user->ID ) ); ?>" class="regular-text" />
            </td>
        </tr>
     </table>
<!-- SMARTTAG ID INPUTS -->

      <h3>SMARTTAG ID</h3>
       <table class="form-table">
        <tr>
            <th><label for="SmartTag Id">SmartTag Id</label></th>
            <td>
                  <input type="text" name="smartTag_id" id="smartTag_id" value="<?php echo esc_attr( get_the_author_meta( 'smartTag_id', $user->ID ) ); ?>" class="regular-text" />
            </td>
        </tr>
        <tr>
            <th><label for="SmartTag Id">User type</label></th>
            <td>
                  <input type="text" name="custom_user_type" id="custom_user_type" value="<?php echo esc_attr( get_the_author_meta( 'custom_user_type', $user->ID ) ); ?>" class="regular-text" />
            </td>
        </tr>
    </table>
  

      <h3>Primary Contact Information</h3>

    <table class="form-table">
        <tr>
            <th><label for="primary_country">Country</label></th>

            <td>
                <select class="country_select address-country" name="primary_country" id="primary_country">
                    <option>Select a Country</option>
                    <?php foreach ($countries as $key => $value): 
                        if ($country == $key) {
                            echo '<option value="'.$key.'" selected>'.$value.'</option>';
                        }else{
                            echo '<option value="'.$key.'">'.$value.'</option>';
                        }
                    ?>
                    <?php endforeach; ?>
                </select>
            </td>
        </tr> 
        <tr>
            <th><label for="primary_address_line1">Address Line 1</label></th>

            <td>
                <input type="text" name="primary_address_line1" id="primary_address_line1" value="<?php echo esc_attr( get_the_author_meta( 'primary_address_line1', $user->ID ) ); ?>" class="regular-text" />
            </td>
        </tr>
        <tr>
            <th><label for="primary_address_line2">Address Line 2</label></th>

            <td>
                <input type="text" name="primary_address_line2" id="primary_address_line2" value="<?php echo esc_attr( get_the_author_meta( 'primary_address_line2', $user->ID ) ); ?>" class="regular-text" />
            </td>
        </tr>
        <tr>
            <th><label for="primary_city">City</label></th>

            <td>
                <input type="text" name="primary_city" id="primary_city" value="<?php echo esc_attr( get_the_author_meta( 'primary_city', $user->ID ) ); ?>" class="regular-text" />
            </td>
        </tr>
        <tr>
            <th><label for="primary_state">State</label></th>

            <td>
                <input type="text" name="primary_state" id="primary_state" value="<?php echo esc_attr( get_the_author_meta( 'primary_state', $user->ID ) ); ?>" class="regular-text" />
            </td>
        </tr>
        <tr>
            <th><label for="primary_postcode">Postcode / ZIP</label></th>

            <td>
                <input type="text" name="primary_postcode" id="primary_postcode" value="<?php echo esc_attr( get_the_author_meta( 'primary_postcode', $user->ID ) ); ?>" class="regular-text" />
            </td>
        </tr>
        <tr>
            <th><label for="primary_home_number">Home Number</label></th>

            <td>
                <input type="text" name="primary_home_number" id="primary_home_number" value="<?php echo esc_attr( get_the_author_meta( 'primary_home_number', $user->ID ) ); ?>" class="regular-text" />
            </td>
        </tr>
        <tr>
            <th><label for="primary_cell_number">Cell Number</label></th>

            <td>
                <input type="text" name="primary_cell_number" id="primary_cell_number" value="<?php echo esc_attr( get_the_author_meta( 'primary_cell_number', $user->ID ) ); ?>" class="regular-text" />
            </td>
        </tr>
        <tr>
            <th><label for="primary_fax_number">Fax Number</label></th>

            <td>
                <input type="text" name="primary_fax_number" id="primary_fax_number" value="<?php echo esc_attr( get_the_author_meta( 'primary_fax_number', $user->ID ) ); ?>" class="regular-text" />
            </td>
        </tr>


        <tr>
            <th><label for="primary_fax_number">Sequrity Question1</label></th>

            <td>
                <input type="text" name="sequrity_qus1" id="sequrity_qus1" value="<?php echo esc_attr( get_the_author_meta( 'sequrity_qus1', $user->ID ) ); ?>" class="regular-text" />
            </td>
        </tr>
        <tr>
            <th><label for="primary_fax_number">Sequrity Answer1</label></th>

            <td>
                <input type="text" name="sequrity_ans1" id="sequrity_ans1" value="<?php echo esc_attr( get_the_author_meta( 'sequrity_ans1', $user->ID ) ); ?>" class="regular-text" />
            </td>
        </tr>
        <tr>
            <th><label for="primary_fax_number">Sequrity Question2</label></th>

            <td>
                <input type="text" name="sequrity_ans2" id="sequrity_ans2" value="<?php echo esc_attr( get_the_author_meta( 'sequrity_qus2', $user->ID ) ); ?>" class="regular-text" />
            </td>
        </tr>
        <tr>
            <th><label for="primary_fax_number">Sequrity Answer2</label></th>

            <td>
                <input type="text" name="sequrity_ans2" id="sequrity_ans2" value="<?php echo esc_attr( get_the_author_meta( 'sequrity_ans2', $user->ID ) ); ?>" class="regular-text" />
            </td>
        </tr>

        <tr>
            <th><label for="r">Organization Name</label></th>

            <td>
                <input type="text" name="Organization_name" id="Organization_name" value="<?php echo esc_attr( get_the_author_meta( 'Organization_name', $user->ID ) ); ?>" class="regular-text" />
            </td>
        </tr>
        <tr>
            <th><label for="primary_fax_number">Organization Email</label></th>

            <td>
                <input type="text" name="Organization_email" id="Organization_email" value="<?php echo esc_attr( get_the_author_meta( 'Organization_email', $user->ID ) ); ?>" class="regular-text" />
            </td>
        </tr>



        <tr>
            <th><label for="primary_argent_alert">Recieve Urgent Alert?</label></th>

            <td>
                <label>
                    <input type="radio" name="primary_argent_alert" class="regular-text primary_argent_alert" value="yes" <?php if ($alert == 'yes') { echo "checked"; } ?>/>Yes
                </label>
                <label>
                    <input type="radio" name="primary_argent_alert" class="regular-text primary_argent_alert" value="no" <?php if ($alert == 'no') { echo "checked"; } ?> />No 
                </label>   
            </td>
        </tr>

    </table>

    <h3>Secondary Contact Information</h3>

    <table class="form-table">
        <tr>
            <th><label for="secondary_first_name">First Name</label></th>

            <td>
                <input type="text" name="secondary_first_name" id="secondary_first_name" value="<?php echo esc_attr( get_the_author_meta( 'secondary_first_name', $user->ID ) ); ?>" class="regular-text" />
            </td>
        </tr>
        <tr>
            <th><label for="secondary_last_name">Last Name</label></th>

            <td>
                <input type="text" name="secondary_last_name" id="secondary_last_name" value="<?php echo esc_attr( get_the_author_meta( 'secondary_last_name', $user->ID ) ); ?>" class="regular-text" />
            </td>
        </tr>
        <tr>
            <th><label for="secondary_email">Email</label></th>

            <td>
                <input type="email" name="secondary_email" id="secondary_email" class="email" value="<?php echo esc_attr( get_the_author_meta( 'secondary_email', $user->ID ) ); ?>" class="regular-text" />
            </td>
        </tr>
        <tr>
            <th><label for="secondary_country">Country</label></th>

            <td>
                <select class="country_select address-country" name="secondary_country" id="secondary_country">
                    <option>Select a Country</option>
                    <?php foreach ($countries as $key => $value): 
                        if ($secondarycountry == $key) {
                            echo '<option value="'.$key.'" selected>'.$value.'</option>';
                        }else{
                            echo '<option value="'.$key.'">'.$value.'</option>';
                        }
                    ?>
                    <?php endforeach; ?>
                </select>
            </td>
        </tr> 
        <tr>
            <th><label for="secondary_address_line1">Address Line 1</label></th>

            <td>
                <input type="text" name="secondary_address_line1" id="secondary_address_line1" value="<?php echo esc_attr( get_the_author_meta( 'secondary_address_line1', $user->ID ) ); ?>" class="regular-text" />
            </td>
        </tr>
        <tr>
            <th><label for="secondary_address_line2">Address Line 2</label></th>

            <td>
                <input type="text" name="secondary_address_line2" id="secondary_address_line2" value="<?php echo esc_attr( get_the_author_meta( 'secondary_address_line2', $user->ID ) ); ?>" class="regular-text" />
            </td>
        </tr>
        <tr>
            <th><label for="secondary_city">City</label></th>

            <td>
                <input type="text" name="secondary_city" id="secondary_city" value="<?php echo esc_attr( get_the_author_meta( 'secondary_city', $user->ID ) ); ?>" class="regular-text" />
            </td>
        </tr>
        <tr>
            <th><label for="secondary_state">State</label></th>

            <td>
                <input type="text" name="secondary_state" id="secondary_state" value="<?php echo esc_attr( get_the_author_meta( 'secondary_state', $user->ID ) ); ?>" class="regular-text" />
            </td>
        </tr>
        <tr>
            <th><label for="secondary_postcode">Postcode / ZIP</label></th>

            <td>
                <input type="text" name="secondary_postcode" id="secondary_postcode" value="<?php echo esc_attr( get_the_author_meta( 'secondary_postcode', $user->ID ) ); ?>" class="regular-text" />
            </td>
        </tr>
        <tr>
            <th><label for="secondary_home_number">Home Number</label></th>

            <td>
                <input type="text" name="secondary_home_number" id="secondary_home_number" value="<?php echo esc_attr( get_the_author_meta( 'secondary_home_number', $user->ID ) ); ?>" class="regular-text" />
            </td>
        </tr>
        <tr>
            <th><label for="secondary_cell_number">Cell Number</label></th>

            <td>
                <input type="text" name="secondary_cell_number" id="secondary_cell_number" value="<?php echo esc_attr( get_the_author_meta( 'secondary_cell_number', $user->ID ) ); ?>" class="regular-text" />
            </td>
        </tr>
        <tr>
            <th><label for="secondary_fax_number">Fax Number</label></th>

            <td>
                <input type="text" name="secondary_fax_number" id="secondary_fax_number" value="<?php echo esc_attr( get_the_author_meta( 'secondary_fax_number', $user->ID ) ); ?>" class="regular-text" />
            </td>
        </tr>
        <tr>
            <th><label for="secondary_argent_alert">Recieve Urgent Alert?</label></th>

            <td>
                <label>
                    <input type="radio" name="secondary_argent_alert" class="regular-text secondary_argent_alert" value="yes" <?php if ($secondaryalert == 'yes') { echo "checked"; } ?>/>Yes
                </label>
                <label>
                    <input type="radio" name="secondary_argent_alert" class="regular-text secondary_argent_alert" value="no" <?php if ($secondaryalert == 'no') { echo "checked"; } ?> />No 
                </label>   
            </td>
        </tr>

    </table>
<?php }

add_action( 'personal_options_update', 'my_save_extra_profile_fields' );
add_action( 'edit_user_profile_update', 'my_save_extra_profile_fields' );
/*update and save extara profile fields*/
function my_save_extra_profile_fields( $user_id ) {

    if ( !current_user_can( 'edit_user', $user_id ) )
        return false;

    update_user_meta( $user_id, 'primary_country', $_POST['primary_country'] );
    update_user_meta( $user_id, 'primary_address_line1', $_POST['primary_address_line1'] );
    update_user_meta( $user_id, 'primary_address_line2', $_POST['primary_address_line2'] );
    update_user_meta( $user_id, 'primary_city', $_POST['primary_city'] );
    update_user_meta( $user_id, 'primary_state', $_POST['primary_state'] );
    update_user_meta( $user_id, 'primary_postcode', $_POST['primary_postcode'] );
    update_user_meta( $user_id, 'primary_home_number', $_POST['primary_home_number'] );
    update_user_meta( $user_id, 'primary_cell_number', $_POST['primary_cell_number'] );
    update_user_meta( $user_id, 'primary_fax_number', $_POST['primary_fax_number'] );
    update_user_meta( $user_id, 'primary_argent_alert', $_POST['primary_argent_alert'] );
    update_user_meta( $user_id, 'secondary_first_name', $_POST['secondary_first_name'] );
    update_user_meta( $user_id, 'secondary_last_name', $_POST['secondary_last_name'] );
    update_user_meta( $user_id, 'secondary_email', $_POST['secondary_email'] );
    update_user_meta( $user_id, 'secondary_country', $_POST['secondary_country'] );
    update_user_meta( $user_id, 'secondary_address_line1', $_POST['secondary_address_line1'] );
    update_user_meta( $user_id, 'primary_address_line2', $_POST['primary_address_line2'] );
    update_user_meta( $user_id, 'secondary_city', $_POST['secondary_city'] );
    update_user_meta( $user_id, 'secondary_state', $_POST['secondary_state'] );
    update_user_meta( $user_id, 'secondary_postcode', $_POST['secondary_postcode'] );
    update_user_meta( $user_id, 'secondary_home_number', $_POST['secondary_home_number'] );
    update_user_meta( $user_id, 'secondary_cell_number', $_POST['secondary_cell_number'] );
    update_user_meta( $user_id, 'secondary_fax_number', $_POST['secondary_fax_number'] );
    update_user_meta( $user_id, 'secondary_argent_alert', $_POST['secondary_argent_alert'] );
    // extra
    update_user_meta( $user_id, 'vet_first_name', $_POST['vet_first_name'] );
    update_user_meta( $user_id, 'vet_last_name', $_POST['vet_last_name'] );
    update_user_meta( $user_id, 'vet_email', $_POST['vet_email'] );
    update_user_meta( $user_id, 'vet_country', $_POST['vet_country'] );

     update_user_meta( $user_id, 'smartTag_id', $_POST['smartTag_id'] );
     update_user_meta( $user_id, 'business_name', $_POST['business_name'] );
     update_user_meta( $user_id, 'custom_user_type', $_POST['custom_user_type'] );
    // update_user_meta( $user_id, 'vet_first_name', $_POST['vet_first_name'] );
    // update_user_meta( $user_id, 'vet_last_name', $_POST['vet_last_name'] );
    // update_user_meta( $user_id, 'vet_email', $_POST['vet_email'] );
    // update_user_meta( $user_id, 'vet_country', $_POST['vet_country'] );
    // update_user_meta( $user_id, 'vet_address_line1', $_POST['vet_address_line1'] );
    // update_user_meta( $user_id, 'vet_address_line2', $_POST['vet_address_line2'] );
    // update_user_meta( $user_id, 'vet_city', $_POST['vet_city'] );
    // update_user_meta( $user_id, 'vet_state', $_POST['vet_state'] );
    // update_user_meta( $user_id, 'vet_postcode', $_POST['vet_postcode'] );
    // update_user_meta( $user_id, 'vet_home_number', $_POST['vet_home_number'] );
    // update_user_meta( $user_id, 'vet_cell_number', $_POST['vet_cell_number'] );
}

function updateEmailPassword($post){
    

    wc_nocache_headers();

    $user_id = get_current_user_id();

    if ( $user_id <= 0 ) {
        return;
    }

    $current_user       = get_user_by( 'id', $user_id );
    $current_email      = $current_user->user_email;

    $account_email      = ! empty( $post['account_email'] ) ? wc_clean( $post['account_email'] )          : '';
    $pass_cur           = ! empty( $post['password_current'] ) ? $post['password_current']                : '';
    $pass1              = ! empty( $post['password_1'] ) ? $post['password_1']                            : '';
    $pass2              = ! empty( $post['password_2'] ) ? $post['password_2']                            : '';
    $save_pass          = true;
    $save_email         = true;
    $error              = '';

    $user               = new stdClass();
    $user->ID           = $user_id;


    if ( ! empty( $pass_cur ) && ! wp_check_password( $pass_cur, $current_user->user_pass, $current_user->ID ) ) {
        
        $error      = 'Your current password is incorrect.';
        $save_pass  = false;
        $save_email = false;

    } elseif ( ! empty( $pass1 ) && empty( $pass_cur ) ) {

        $error      = 'Please enter your current password.';
        $save_pass  = false;

    } elseif ( ! empty( $pass1 ) && empty( $pass2 ) ) {

        $error      = 'Please re-enter your password.';
        $save_pass  = false;

    } elseif ( ( ! empty( $pass1 ) || ! empty( $pass2 ) ) && $pass1 !== $pass2 ) {

        $error      = 'New passwords do not match.';
        $save_pass  = false;

    } elseif (! empty( sanitize_email( $account_email ) ) && ! wp_check_password( $pass_cur, $current_user->user_pass, $current_user->ID ) && $current_email != $account_email ) {

        $error      = 'Your current password is incorrect.';
        $save_email = false;

    } elseif ( ! empty( $account_email ) && $current_email == $account_email ) {
        
        $save_email = false;

    } elseif ( ! empty( $account_email ) && empty( $pass_cur ) ) {

        $error      = 'Please enter your current password.';
        $save_email = false;

    } elseif(! is_email( sanitize_email( $account_email ) ) && wp_check_password( $pass_cur, $current_user->user_pass, $current_user->ID )) {
        
        $error      = 'Please provide a valid email address.';
        $save_email = false;
       
    } elseif( email_exists( sanitize_email( $account_email ) ) && sanitize_email( $account_email ) !== $current_user->user_email ){

        $error      = 'This email address is already registered.';
        $save_email = false;

    } elseif ( ! empty( $pass1 ) && ! wp_check_password( $pass_cur, $current_user->user_pass, $current_user->ID ) ) {

        $error      = 'Your current password is incorrect.';
        $save_pass  = false;
    }

    if ( $pass1 && $save_pass ) {
        $user->user_pass = $pass1;
    }

    if ($save_email) {
        $user->user_email = $account_email;
    }


    if ( ! empty( $error ) ) {

        $message['success'] = 0;
        $message['message'] = $error;

        return json_encode($message);
    }

    if ( empty( $error ) ) {
        wp_update_user( $user );

        // Update customer object to keep data in sync.
        $customer = new WC_Customer( $user->ID );

        if ( $customer ) {
            // Keep billing data in sync if data changed.
            if ( is_email( $user->user_email ) && $current_email !== $user->user_email ) {
                $customer->set_billing_email( $user->user_email );
            }

            if ( $current_first_name !== $user->first_name ) {
                $customer->set_billing_first_name( $user->first_name );
            }

            if ( $current_last_name !== $user->last_name ) {
                $customer->set_billing_last_name( $user->last_name );
            }

            $customer->save();
        }

        $message['success'] = 1;
        $message['message'] = 'Account details changed successfully.';

        return json_encode($message);
    }
}

function updatePrimaryInfo($post){
    

    wc_nocache_headers();

    $user_id = get_current_user_id();

    if ( $user_id <= 0 ) {
        return;
    }

    $current_user       = get_user_by( 'id', $user_id );
    $current_first_name = $current_user->first_name;
    $current_last_name  = $current_user->last_name;

    $account_first_name = ! empty( $post['account_first_name'] ) ? wc_clean( $post['account_first_name'] ): '';
    $account_last_name  = ! empty( $post['account_last_name'] ) ? wc_clean( $post['account_last_name'] )  : '';
    $error              = '';

    $user               = new stdClass();
    $user->ID           = $user_id;
    $user->first_name   = $account_first_name;
    $user->last_name    = $account_last_name;

    // Prevent emails being displayed, or leave alone.
    $user->display_name = is_email( $current_user->display_name ) ? $user->first_name : $current_user->display_name;

    // Handle required fields.
    $required_fields = apply_filters( 'woocommerce_save_account_details_required_fields', array(
        'account_first_name' => __( 'First name', 'woocommerce' ),
        'account_last_name'  => __( 'Last name', 'woocommerce' ),
    ) );

    foreach ( $required_fields as $field_key => $field_name ) {
        if ( empty( $post[ $field_key ] ) ) {
            $error = sprintf( __( '%s is a required field.', 'woocommerce' ), '<strong>' . esc_html( $field_name ) . '</strong>' );
        }
    }

    if ( ! empty( $error ) ) {

        $message['success'] = 0;
        $message['message'] = $error;

        return json_encode($message);
    }

    if ( empty( $error ) ) {
        wp_update_user( $user );

        // Update customer object to keep data in sync.
        $customer = new WC_Customer( $user->ID );

        if ( $customer ) {
            // Keep billing data in sync if data changed.
            if ( is_email( $user->user_email ) && $current_email !== $user->user_email ) {
                $customer->set_billing_email( $user->user_email );
            }

            if ( $current_first_name !== $user->first_name ) {
                $customer->set_billing_first_name( $user->first_name );
            }

            if ( $current_last_name !== $user->last_name ) {
                $customer->set_billing_last_name( $user->last_name );
            }

            $customer->save();
        }
        update_user_meta( $user_id, 'primary_country', $post['primary_country'] );
        update_user_meta( $user_id, 'primary_address_line1', $post['primary_address_line1'] );
        update_user_meta( $user_id, 'primary_address_line2', $post['primary_address_line2'] );
        update_user_meta( $user_id, 'primary_city', $post['primary_city'] );
        update_user_meta( $user_id, 'primary_state', $post['primary_state'] );
        update_user_meta( $user_id, 'primary_postcode', $post['primary_postcode'] );
        update_user_meta( $user_id, 'primary_home_number', $post['primary_home_number'] );
        update_user_meta( $user_id, 'primary_cell_number', $post['primary_cell_number'] );
        update_user_meta( $user_id, 'primary_fax_number', $post['primary_fax_number'] );
        if (isset($post['primary_argent_alert'])) {
            update_user_meta( $user_id, 'primary_argent_alert', $post['primary_argent_alert'] );
        }
        if (isset($post['shelter_group_name'])) {
            update_user_meta( $user_id, 'shelter_group_name', $post['shelter_group_name'] );
        }
        $message['success'] = 1;
        $message['message'] = 'Account details changed successfully.';

        return json_encode($message);
    }
}

function updateSecondaryInfo($post){
    

    wc_nocache_headers();

    $user_id = get_current_user_id();

    if ( $user_id <= 0 ) {
        return;
    }


    $current_user       = get_user_by( 'id', $user_id );
    $current_first_name = get_the_author_meta( 'secondary_first_name', $user_id );
    $current_last_name  = get_the_author_meta( 'secondary_last_name', $user_id );
    $current_email      = get_the_author_meta( 'secondary_email', $user_id );

    $account_first_name = ! empty( $post['secondary_first_name'] ) ? wc_clean( $post['secondary_first_name'] ): '';
    $account_last_name  = ! empty( $post['secondary_last_name'] ) ? wc_clean( $post['secondary_last_name'] )  : '';
    $current_email      = ! empty( $post['secondary_email'] ) ? wc_clean( $post['secondary_email'] )  : '';
    $error              = '';

    $user               = new stdClass();
    $user->ID           = $user_id;

    // Handle required fields.
    $required_fields = apply_filters( 'woocommerce_save_account_details_required_fields', array(
        'secondary_first_name' => __( 'Secondary First name', 'woocommerce' ),
        'secondary_last_name'  => __( 'Secondary Last name', 'woocommerce' ),
        'secondary_email'      => __( 'Secondary Email address', 'woocommerce' ),
    ) );

    foreach ( $required_fields as $field_key => $field_name ) {
        if ( empty( $post[ $field_key ] ) ) {
            $error = sprintf( __( '%s is a required field.', 'woocommerce' ), '<strong>' . esc_html( $field_name ) . '</strong>' );
        }
    }

    if ( ! empty( $error ) ) {

        $message['success'] = 0;
        $message['message'] = $error;

        return json_encode($message);
    }

    if ( empty( $error ) ) {
        
        update_user_meta( $user_id, 'secondary_first_name', $post['secondary_first_name'] );
        update_user_meta( $user_id, 'secondary_last_name', $post['secondary_last_name'] );
        update_user_meta( $user_id, 'secondary_email', $post['secondary_email'] );
        update_user_meta( $user_id, 'secondary_country', $post['secondary_country'] );
        update_user_meta( $user_id, 'secondary_address_line1', $post['secondary_address_line1'] );
        update_user_meta( $user_id, 'primary_address_line2', $post['primary_address_line2'] );
        update_user_meta( $user_id, 'secondary_city', $post['secondary_city'] );
        update_user_meta( $user_id, 'secondary_state', $post['secondary_state'] );
        update_user_meta( $user_id, 'secondary_postcode', $post['secondary_postcode'] );
        update_user_meta( $user_id, 'secondary_home_number', $post['secondary_home_number'] );
        update_user_meta( $user_id, 'secondary_cell_number', $post['secondary_cell_number'] );
        update_user_meta( $user_id, 'secondary_fax_number', $post['secondary_fax_number'] );
        update_user_meta( $user_id, 'secondary_argent_alert', $post['secondary_argent_alert'] );
        $message['success'] = 1;
        $message['message'] = 'Account details changed successfully.';

        return json_encode($message);
    }
}

add_action('wp_ajax_save_email_password', 'handle_save_email_password');
add_action('wp_ajax_nopriv_save_email_password', 'handle_save_email_password');
function handle_save_email_password(){
    if ( 'POST' !== strtoupper( $_SERVER['REQUEST_METHOD'] ) ) {
        return;
    }
    echo updateEmailPassword($_POST);
    exit();
}

add_action('wp_ajax_save_primary_info', 'handle_save_primary_info');
add_action('wp_ajax_nopriv_save_primary_info', 'handle_save_primary_info');
function handle_save_primary_info(){
    if ( 'POST' !== strtoupper( $_SERVER['REQUEST_METHOD'] ) ) {
        return;
    }
    echo updatePrimaryInfo($_POST);
    exit();
}

add_action('wp_ajax_save_secondary_info', 'handle_save_secondary_info');
add_action('wp_ajax_nopriv_save_secondary_info', 'handle_save_secondary_info');
function handle_save_secondary_info(){
    if ( 'POST' !== strtoupper( $_SERVER['REQUEST_METHOD'] ) ) {
        return;
    }
    echo updateSecondaryInfo($_POST);
    exit();
}

add_action('wp_ajax_save_custom_woocommerce_owner_form', 'handle_save_custom_woocommerce_owner_form');
add_action('wp_ajax_nopriv_save_custom_woocommerce_owner_form', 'handle_save_custom_woocommerce_owner_form');
function handle_save_custom_woocommerce_owner_form(){
    if ( 'POST' !== strtoupper( $_SERVER['REQUEST_METHOD'] ) ) {
        return;
    }

    $user_id = get_current_user_id();

    if ( $user_id <= 0 ) {
        return;
    }

    $current_user       = get_user_by( 'id', $user_id );
    $current_email      = $current_user->user_email;
    $current_first_name = $current_user->first_name;
    $current_last_name  = $current_user->last_name;
    $secondary_first_name = get_the_author_meta( 'secondary_first_name', $user_id );
    $secondary_last_name  = get_the_author_meta( 'secondary_last_name', $user_id );
    $secondary_email      = get_the_author_meta( 'secondary_email', $user_id );

    $account_email      = ! empty( $_POST['account_email'] ) ? wc_clean( $_POST['account_email'] ): '';
    $pass_cur           = ! empty( $_POST['password_current'] ) ? $_POST['password_current']: '';
    $pass1              = ! empty( $_POST['password_1'] ) ? $_POST['password_1']                            : '';
    $pass2              = ! empty( $_POST['password_2'] ) ? $_POST['password_2']: '';
    $account_first_name = ! empty( $post['account_first_name'] ) ? wc_clean( $post['account_first_name'] ): '';
    $account_last_name  = ! empty( $post['account_last_name'] ) ? wc_clean( $post['account_last_name'] )  : '';
    $secondary_first_name = ! empty( $post['secondary_first_name'] ) ? wc_clean( $post['secondary_first_name'] ): '';
    $secondary_last_name  = ! empty( $post['secondary_last_name'] ) ? wc_clean( $post['secondary_last_name'] )  : '';
    $secondary_email      = ! empty( $post['secondary_email'] ) ? wc_clean( $post['secondary_email'] ): '';
    $save_pass          = true;
    $save_email         = true;
    $error              = '';

    $user               = new stdClass();
    $user->ID           = $user_id;


    if ( ! empty( $pass_cur ) && ! wp_check_password( $pass_cur, $current_user->user_pass, $current_user->ID ) ) {
        
        $error      = 'Your current password is incorrect.';
        $save_pass  = false;
        $save_email = false;

    } elseif ( ! empty( $pass1 ) && empty( $pass_cur ) ) {

        $error      = 'Please enter your current password.';
        $save_pass  = false;

    } elseif ( ! empty( $pass1 ) && empty( $pass2 ) ) {

        $error      = 'Please re-enter your password.';
        $save_pass  = false;

    } elseif ( ( ! empty( $pass1 ) || ! empty( $pass2 ) ) && $pass1 !== $pass2 ) {

        $error      = 'New passwords do not match.';
        $save_pass  = false;

    } elseif (! empty( sanitize_email( $account_email ) ) && ! wp_check_password( $pass_cur, $current_user->user_pass, $current_user->ID ) && $current_email != $account_email ) {

        $error      = 'Your current password is incorrect.';
        $save_email = false;

    } elseif ( ! empty( $account_email ) && $current_email == $account_email ) {

        $save_email = false;

    } elseif ( ! empty( $account_email ) && empty( $pass_cur ) ) {

        $error      = 'Please enter your current password.';
        $save_email = false;

    } elseif(! is_email( sanitize_email( $account_email ) )) {
        
        $error      = 'Please provide a valid email address.';
        $save_email = false;
       
    } elseif( email_exists( sanitize_email( $account_email ) ) && sanitize_email( $account_email ) !== $current_user->user_email ){

        $error      = 'This email address is already registered.';
        $save_email = false;

    } elseif ( ! empty( $pass1 ) && ! wp_check_password( $pass_cur, $current_user->user_pass, $current_user->ID ) ) {

        $error      = 'Your current password is incorrect.';
        $save_pass  = false;
    }

    // Handle required fields.
    $required_fields = apply_filters( 'woocommerce_save_account_details_required_fields', array(
        'account_first_name' => __( 'First name', 'woocommerce' ),
        'account_last_name'  => __( 'Last name', 'woocommerce' ),
        'secondary_first_name' => __( 'Secondary First name', 'woocommerce' ),
        'secondary_last_name'  => __( 'Secondary Last name', 'woocommerce' ),
        'secondary_email'      => __( 'Secondary Email address', 'woocommerce' ),
    ) );

    foreach ( $required_fields as $field_key => $field_name ) {
        if ( empty( $_POST[ $field_key ] ) ) {
            $error = sprintf( __( '%s is a required field.', 'woocommerce' ), '<strong>' . esc_html( $field_name ) . '</strong>' );
        }
    }

    if ( ! empty( $error ) ) {

        $message['success'] = 0;
        $message['message'] = $error;

        echo json_encode($message);
    }
    if (empty( $error )) {
        updateEmailPassword($_POST);
        updatePrimaryInfo($_POST);
        echo updateSecondaryInfo($_POST);
    }
    
    exit();
}

add_action('wp_ajax_check_email', 'handle_check_email');
add_action('wp_ajax_nopriv_check_email', 'handle_check_email');
function handle_check_email(){
    print_r($_POST);
    $email              = $_POST['primary_email'];
    $error['success']   = true;
    if(! is_email( sanitize_email( $email ) )) {
        
        $error['msg']       = 'Please provide a valid email address.';
        $error['success']   = false;
       
    } elseif( email_exists( sanitize_email( $email ) ) && sanitize_email( $email ) !== $current_user->user_email ){

        $error['msg']       = 'This email address is already registered.';
        $error['success']   = false;

    }

    echo json_encode($error);
    exit();
}

function iconic_find_matching_product_variation( $product, $attributes ) {

    foreach( $attributes as $key => $value ) {
        if( strpos( $key, 'attribute_' ) === 0 ) {
            continue;
        }

        unset( $attributes[ $key ] );
        $attributes[ sprintf( 'attribute_%s', $key ) ] = $value;
    }

    if( class_exists('WC_Data_Store') ) {

        $data_store = WC_Data_Store::load( 'product' );
        return $data_store->find_matching_product_variation( $product, $attributes );

    } else {

        return $product->get_matching_variation( $attributes );

    }

}

function checkSerialNumber($id){

    $args=array(
        'post_type' => 'pet_profile',
        'post_status' => 'publish',
        'posts_per_page' => -1,
        'meta_query'=>array(
            'relation' => 'OR',
                array(
                    'key' => 'smarttag_id_number',
                    'value' => $id,
                ),
                array(
                    'key' => 'microchip_id_number',
                    'value' => $id,
                ),
            )
        
    );
    $query = new WP_Query($args);

    if ($query->have_posts()) {
        return 'false';
    }
    global $wpdb;
    /*$results = $wpdb->get_results("SELECT MAX(wp_woocommerce_order_items.`order_id`) as order_id FROM wp_woocommerce_order_items JOIN wp_woocommerce_order_itemmeta ON wp_woocommerce_order_items.order_item_id = wp_woocommerce_order_itemmeta.order_item_id where wp_woocommerce_order_itemmeta.order_item_id = (SELECT MAX(order_item_id) FROM wp_woocommerce_order_itemmeta where meta_value Like '%".$id."%' and meta_key = 'Serial Number')", OBJECT);
        $data = json_encode($results);
        $data = json_decode($data);
        return $data;*/
        $results = $wpdb->get_results("SELECT * FROM wp_woocommerce_order_itemmeta where meta_value Like '%".$id."%' and meta_key = 'Serial Number'", OBJECT);
        $data = json_encode($results);
        $datas = json_decode($data);
        $count = count($datas);
        $check = 0;
        if ($count > 0) {
            foreach ($datas as $data) {
                $values = explode(',', $data->meta_value);
                foreach ($values as $value) {
                    if ($value == $id) {
                        $metaIds[] = $data->order_item_id;
                        $check     = 1;
                    }
                }
            }
            // return $check;
            if ($check) {
                $metaId = 0;

                foreach ($metaIds as $value) {
                    if ($value > $b) {
                        $metaId = $value;
                    }
                }
                // return $metaId;
                if ($metaId != 0) {
                    $results = $wpdb->get_results("SELECT MAX(wp_woocommerce_order_items.`order_id`) as order_id FROM wp_woocommerce_order_items JOIN wp_woocommerce_order_itemmeta ON wp_woocommerce_order_items.order_item_id = wp_woocommerce_order_itemmeta.order_item_id where wp_woocommerce_order_itemmeta.order_item_id ='".$metaId."'", OBJECT);
                    $data = json_encode($results);
                    $data = json_decode($data);
                    return $data;
                }else{
                    return 0;
                }
                
            }else{
                return 0;
            }                
        }else{
            return 0;
        }

}

add_action("wp_ajax_checkSerialNumberValid", "checkSerialNumberValidForRegisterMicrochipAndSmartTagID");
add_action("wp_ajax_nopriv_checkSerialNumberValid", "checkSerialNumberValidForRegisterMicrochipAndSmartTagID");

function checkSerialNumberValidForRegisterMicrochipAndSmartTagID(){
    $user = wp_get_current_user();
    
    foreach ($_POST['data'] as $microchip) {
            $id = $microchip['microchip_id_number'];
            $data = checkSerialNumber($id);
        
        if ($data === 'false'){
            $result =array('result'=>'This number already register') ;
            // echo json_encode(array('result'=>0, 'msg'=>'This number already register'));
        }
        elseif ($data) {
            $order      = wc_get_order( $data[0]->order_id );
            $userId     = $order->get_user_id();
            $userMeta   = get_userdata($userId);
            $userRole   = $userMeta->roles;
            
                if (in_array("pet_professional", $userRole)){
                       if($userMeta->data->ID == $user->data->ID){
                        $result[] = array('result'=>true);
                         // echo json_encode(array('result'=>true));
                         }else{
                            $result[] = array('result'=>false);
                            // echo json_encode(array('result'=>false));
                          }
                }else{
                    $result[] = array('result'=>'Invalid Pet Professional login');
                    // echo json_encode(array('result'=>0, 'msg'=>'Invalid Pet Professional login'));
                }
        }else{
               $result[] = array('result'=>'Invalid Number');
             // echo json_encode(array('result'=>'Invalid Number'));
          }  

      }
     echo json_encode($result);
        exit();
}


//rohit custom ajax for check microchip and smartTag id

add_action("wp_ajax_checkSmartTagMicrochipValid", "checkValidForcheckSmartTagIDValid");
add_action("wp_ajax_nopriv_checkSmartTagMicrochipValid", "checkValidForcheckSmartTagIDValid");

function checkValidForcheckSmartTagIDValid(){
    $user = wp_get_current_user();

    if (isset($_POST['smartTagID'])) {
        $id = $_POST['smartTagID'];
    }else{
        $id = $_POST['serialNumber'];
    }

    $data = checkSerialNumber($id);
    if ($data === 'false'){
        $result =array('result'=>0,'msg'=>'This number already register') ;
        // echo json_encode(array('result'=>0, 'msg'=>'This number already register'));
    }
    elseif ($data) {
        $order      = wc_get_order( $data[0]->order_id );
        $userId     = $order->get_user_id();
        $userMeta   = get_userdata($userId);
        $userRole   = $userMeta->roles;  
        if (in_array("customer", $userRole) ){
               if($userMeta->data->ID == $user->data->ID){
                $result = array('result'=>true,"msg"=>"Valid ID");
                 // echo json_encode(array('result'=>true));
                 }else{
                    $result[] = array('result'=>false);
                    // echo json_encode(array('result'=>false));
                  }
        }else{
            $result[] = array('result'=>'Invalid customer login');
            // echo json_encode(array('result'=>0, 'msg'=>'Invalid Pet Professional login'));
        }
    }else{
        $result = array('result'=>false,"msg"=>"Invalid Number");
           // echo json_encode(array('result'=>'Invalid Number'));
    }  
    echo json_encode($result);
        exit();
}


function registerNewPetrofessionals($post){
    global $current_user;
    if (is_user_logged_in()) {
        $createdBy = $current_user->data->user_login;
    }else{
        $createdBy = 'self';
    }
    if (isset($post['primary_home_number'])) {

        $phone      = $post['primary_home_number'];
        $email      = $post['p_email'];
        $orgName    = $post['Organization_name'];
        $userType   = $post['custom_user_type'];
        $phoneExist = phone_exists($phone);
        if ($phoneExist['success']) {
            echo "Phone number already exist.";
        }elseif(email_exists( $email )){
            echo "This Email is already used, please enter other user name";
        }else{
            $userId = wp_create_user( $email, $_POST['password'], $email );
            /*$user = new WP_User($user_id);
            $user->set_role('wholeseller');*/

            $user               = new stdClass();
            $user->ID           = $userId;
            $user->first_name   = $_POST['p_fst_name'];
            $user->last_name    = $_POST['p_lst_name'];
            $user->role         = 'pet_professional';
            wp_update_user( $user );
            update_user_meta($userId,'created_by',$createdBy);
            update_user_meta($userId,'Organization_name',$orgName);
            update_user_meta($userId,'custom_user_type',$userType);
            update_user_meta($userId,'source_system','SMARTTAG');
        }
    }
}

add_action("wp_ajax_downloadPdf", "downloadPdfFile");
add_action("wp_ajax_nopriv_downloadPdf", "downloadPdfFile");
// require_once "lib/dompdf/autoload.inc.php";
function downloadPdfFile(){
    $htmlContent = '<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Pet Poster</title>
    <style type="text/css">
        @font-face {
            font-family: "Asap";           
            src: local("Asap"), url("resources/Asap-Regular.ttf") format("truetype");
            font-weight: normal;
            font-style: normal;
        }
        .print-poster-col{
            line-height: 1.5; 
            color: #3c3c3c; 
            font-family: "Asap", sans-serif; 
            font-size: 16px; 
            border: 1px solid #679fe1; 
            padding: 30px; 
            margin-bottom: 30px;
        }
        .print-poster-col h2{
            font-size: 56px;
            font-weight: 700;
            margin: 0 0 15px 0;
            color: #dc2727;
            text-align: center;
            line-height: 0.9 !important;
            text-transform: uppercase;
        }
    </style>
</head>
<body>
<div class="col-sm-8 rmb-30">
                <div class="print-poster-col">
                    <div class="print-poster-inner">
                        <h2>Lost Pet</h2>
                        <div class="bordered-poster-wrap" style="border: 5px solid #dc2727; padding: 8px; margin-bottom: 20px;">
                            <div class="bordered-poster mb-15">
                                <table cellpadding="0" cellspacing="0" style="width: 100%; border-collapse: collapse; margin-bottom: 0;">
                                    <tr>
                                        <td style="width: 50%; vertical-align: top; padding: 0; border: none; font-size: 16px;">
                                            <p style="font-weight: 600; font-size: 28px; margin-bottom: 10px;">"'.$_POST["dogName"].'"</p>
                                            '.$_POST["type"].', '.$_POST["breed"].'
                                            <br>
                                            Color: '.$_POST["color"].'
                                            <br>
                                            ID Tag #: '.$_POST["serialNumber"].'
                                        </td>
                                        <td style="width: 50%; vertical-align: top; padding: 0; border: none; font-size: 16px;">
                                            <p style="font-weight: 600; font-size: 28px; margin-bottom: 10px; padding: 0;">REWARD <span style="color: #dc2727;">'.$_POST["reward"].'</span></p>
                                            <strong>Additional Info:</strong>
                                            <br>
                                            '.$_POST["extraInfo"].'
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" style="text-align: center; color: #dc2727; font-size: 16px; text-transform: uppercase; padding: 0; border: none; font-size: 14px;">
                                            <p style="margin-bottom: 30px; margin-top: 30px; font-size: 28px; line-height: 1.2;">
                                                Please call with any info:
                                                <br>
                                                212-868-2559
                                            </p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" style="text-align: center; padding: 0; border: none; font-size: 16px;">
                                            <p style="margin-bottom: 20px; text-align: center;">
                                                <img src="'.$_POST["image"].'" style="width: 300px; height: auto;  display: inline-block;" />
                                            </p>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <div class="poster-info-table-wrap">
                            <table class="poster-info-table" cellspacing="0" cellpadding="0" style="width: 100%; border-collapse: collapse; margin-bottom: 0;">
                                <td style="text-align: left; color: #3c3c3c; padding: 0; border: none; font-size: 16px;">
                                    <img src="https://idtag.agiliscloud.com/wp-content/themes/salient-child/images/logo-icon.png" alt="image" style="width: 70px; height: auto;" />
                                </td>
                                <td  style="text-align: right; color: #3c3c3c; font-size: 14px; padding: 0; border: none; font-size: 16px; font-weight: 600;">    
                                    To Report This Dog Found , Enter ID Tag # on:
                                    <p style="font-size: 28px; font-weight: 600; margin: 0 0 0 0; color: #3c3c3c; line-height: 1.2;">WWW.IDTAG.COM</p>
                                </td>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
</body>
</html>';
    include "lib/dompdf/autoload.inc.php";
    $dompdf = new Dompdf\Dompdf();
    $dompdf->loadHtml($htmlContent);
    $dompdf->setPaper('A4');
    $dompdf->set_option('isRemoteEnabled', TRUE);
    $dompdf->output();
    $dompdf->render();

    // output the genrated pdf
    $dompdf->stream('SmartTagg',array('Attachment'=>1));
    exit();
}

add_action("wp_ajax_UploadProfileImage", "UploadProfileImage");
add_action("wp_ajax_nopriv_UploadProfileImage", "UploadProfileImage");
function UploadProfileImage(){
    $attach_id = 0;
    $post_id = 0;
    if ($_FILES["feature"]['error'] > 0) {
        $msg = 'File name cannot be empty';
    }elseif ($_FILES["feature"]['size'] > 2000000) {
        $msg = 'Please only select images less than 2MB in size';
    }else{
       $upload = wp_upload_bits($_FILES["feature"]["name"], null, file_get_contents($_FILES["feature"]["tmp_name"]));
    
        $filename = $upload['file'];
        $wp_filetype = wp_check_filetype(basename( $filename ), null );
        strtolower($wp_filetype['ext']);
        if (strtolower($wp_filetype['ext']) == 'png' || strtolower($wp_filetype['ext']) == 'jpg' || strtolower($wp_filetype['ext']) == 'jpeg') {
            $wp_upload_dir = wp_upload_dir();
            $attachment = array(
                'guid'              => $wp_upload_dir['url'] . '/' . basename( $filename ),
                'post_mime_type'    => $wp_filetype['type'],
                'post_title'        => preg_replace( '/\.[^.]+$/', '', basename( $filename ) ),
                'post_content'      => '',
                'post_status'       => 'inherit'
            );
            $attach_id = wp_insert_attachment( $attachment, $filename, $post_id );
            require_once(ABSPATH . 'wp-admin/includes/image.php');
            $attach_data = wp_generate_attachment_metadata( $attach_id, $filename );
            wp_update_attachment_metadata( $attach_id, $attach_data );
            set_post_thumbnail( $post_id, $attach_id ); 
            $msg = "Update Profile Successfully";
        }else{
            $msg = "Please upload only jpg, jpeg and png Type Image.";
        }
        
    }
    $userId = get_current_user_id();
    update_user_meta( $userId, 'user_image', $attach_id );
    echo json_encode(array("attachId"=>$attach_id, "msg"=>$msg));
    exit();
}
add_action("wp_ajax_changePasswordForm", "changePasswordForm");
add_action("wp_ajax_nopriv_changePasswordForm", "changePasswordForm");
function changePasswordForm(){
    echo updateEmailPassword($_POST);
    exit();
}
add_action("wp_ajax_updateGroupInfo", "updateGroupInfo");
add_action("wp_ajax_nopriv_updateGroupInfo", "updateGroupInfo");
function updateGroupInfo(){
    $userId  = get_current_user_id();
    if (isset($_POST['group_title'])) {
        $size = count($_POST['group_title']);
        $i = 0;
        while ( $i < $size) {
            $groupInfo[$i]['group_title']           = $_POST['group_title'][$i];
            $groupInfo[$i]['group_first_name']      = $_POST['group_first_name'][$i];
            $groupInfo[$i]['group_last_name']       = $_POST['group_last_name'][$i];
            $groupInfo[$i]['group_phone_number']    = $_POST['group_phone_number'][$i];
            $groupInfo[$i]['group_email']           = $_POST['group_email'][$i];
            $i++;
        }
        update_user_meta( $userId, 'multiple_group_info', $groupInfo );
    }
    exit();
}
add_action("wp_ajax_updateShippingInfo", "updateShippingInfo");
add_action("wp_ajax_nopriv_updateShippingInfo", "updateShippingInfo");
function updateShippingInfo(){
    $userId  = get_current_user_id();
    if (isset($_POST['shipping_first_name'])) {
        $size = count($_POST['shipping_first_name']);
        $i = 0;
        if ($size > 1) {
            while ( $i < $size) {
                $shippingInfo[$i]['shipping_first_name']       = $_POST['shipping_first_name'][$i];
                $shippingInfo[$i]['shipping_last_name']        = $_POST['shipping_last_name'][$i];
                $shippingInfo[$i]['shipping_country']          = $_POST['shipping_country'][$i];
                $shippingInfo[$i]['shipping_address_1']    = $_POST['shipping_address_line_1'][$i];
                $shippingInfo[$i]['shipping_city']             = $_POST['shipping_city'][$i];
                $shippingInfo[$i]['shipping_address_2']    = $_POST['shipping_address_line_2'][$i];
                $shippingInfo[$i]['shipping_state']            = $_POST['shipping_state'][$i];
                $shippingInfo[$i]['shipping_postcode']         = $_POST['shipping_postcode'][$i];
                $i++;
            }
            update_user_meta( $userId, 'multiple_shipping_info', $shippingInfo );
        }else{
            update_user_meta( $userId, 'shipping_first_name', $_POST['shipping_first_name'][0] );
            update_user_meta( $userId, 'shipping_last_name', $_POST['shipping_last_name'][0] );
            update_user_meta( $userId, 'shipping_state', $_POST['shipping_state'][0] );
            update_user_meta( $userId, 'shipping_city', $_POST['shipping_city'][0] );
            update_user_meta( $userId, 'shipping_address_1', $_POST['shipping_address_line_1'][0] );
            update_user_meta( $userId, 'shipping_address_2', $_POST['shipping_address_line_2'][0] );
            update_user_meta( $userId, 'shipping_postcode', $_POST['shipping_postcode'][0] );
            update_user_meta( $userId, 'shipping_country', $_POST['shipping_country'][0] );
            update_user_meta( $userId, 'multiple_shipping_info', '' );
        }
    }
    exit();
}

/*start ajax for update alert and remove alert*/

add_action("wp_ajax_updateAlerts", "updateAlerts");
add_action("wp_ajax_nopriv_updateAlerts", "updateAlerts");
function updateAlerts(){
    $userId     = get_current_user_id();
    $alertName  = $_POST['alert_name'];
    $notInKey   = array("alert_name", "action");
    foreach ($_POST as $key => $value) {
        if (!in_array($key, $notInKey)) {
            $data[$key] = $value;
        }
    }

    if ($alertName == 'heartworm_medication_alert') {
        $class   = "heartworm-alert";
        $message = "Update Heartworm Medication Alerts Successfully";
    }elseif ($alertName == 'flea_tick_medication_alert') {
        $class   = "flea-tick";
        $message = "Update Flea & Tick Medication Alerts Successfully";
    }elseif ($alertName == 'vet_appointments_alert') {
        $class   = "vet-appo";
        $message = "Update Vet Appointments Alerts Successfully";
    }elseif ($alertName == 'medication_alert') {
        $class   = "medication-alert";
        $message = "Update Medication Alerts Alerts Successfully";
    }elseif ($alertName == 'rabies_shot_alert') {
        $class   = "flea-tick";
        $message = "Update Rabies Shot Alerts Successfully";
    }elseif ($alertName == 'tag_licensing_alert') {
        $class   = "tag-licens";
        $message = "Update Tag Licensing Alerts Successfully";
    }

    update_user_meta( $userId, $_POST['alert_name'], $data );
    echo json_encode(array("success" => 1, "msg" => $message, "class" => $class));
    exit();
}
add_action("wp_ajax_updateCustomAlerts", "updateCustomAlerts");
add_action("wp_ajax_nopriv_updateCustomAlerts", "updateCustomAlerts");
function updateCustomAlerts(){
    // var_dump($_POST['custom_alert_number']); die();
    $userId     = get_current_user_id();
    $totalCustm = get_user_meta($userId,"total_custom_alert",true);
    if (isset($totalCustm[0])) {
        $totalCustm = $totalCustm[0];
    }else{
        $totalCustm = 0;
    }
    $notInKey   = array("alert_name", "custom_alert_number", "action");
    foreach ($_POST as $key => $value) {
        if (!in_array($key, $notInKey)) {
            $data[$key] = $value;
        }
    }
    if ($_POST['custom_alert_number'] != "0") {
        update_user_meta( $userId, $_POST['custom_alert_number'], $data );
        echo json_encode(array("success" => 1, "msg" => "Update Custom Alert Successfully", "alertName" => $_POST['custom_alert_number']));
        exit();
    }
    $name = "custom_alert_".++$totalCustm;
    update_user_meta( $userId, $name, $data );
    update_user_meta( $userId, "total_custom_alert", $totalCustm );
    echo json_encode(array("success" => 1, "msg" => "Update Custom Alert Successfully", "alertName" => $name));
    exit();
}


add_action("wp_ajax_removeCustomAlerts", "removeCustomAlerts");
add_action("wp_ajax_nopriv_removeCustomAlerts", "removeCustomAlerts");
function removeCustomAlerts(){
    $alertName  = $_POST['custom_alert_number'];
    $userId     = get_current_user_id();
    delete_user_meta( $userId, $alertName );
    echo json_encode(array("success" => 1, "msg" => "Remove Custom Alerts Successfully", "class" => "custom-alert"));
    // $totalCustm = get_user_meta($userId,"total_custom_alert",true);
    
    exit();
}

add_action("wp_ajax_removeAlerts", "removeAlerts");
add_action("wp_ajax_nopriv_removeAlerts", "removeAlerts");
function removeAlerts(){
    $alertName  = $_POST['alert_name'];
    $userId     = get_current_user_id();

    if ($alertName == 'heartworm_medication_alert') {
        $class   = "heartworm-alert";
        $message = "Remove Heartworm Medication Alerts Successfully";
    }elseif ($alertName == 'flea_tick_medication_alert') {
        $class   = "flea-tick";
        $message = "Remove Flea & Tick Medication Alerts Successfully";
    }elseif ($alertName == 'vet_appointments_alert') {
        $class   = "vet-appo";
        $message = "Remove Vet Appointments Alerts Successfully";
    }elseif ($alertName == 'medication_alert') {
        $class   = "medication-alert";
        $message = "Remove Medication Alerts Alerts Successfully";
    }elseif ($alertName == 'rabies_shot_alert') {
        $class   = "flea-tick";
        $message = "Remove Rabies Shot Alerts Successfully";
    }elseif ($alertName == 'tag_licensing_alert') {
        $class   = "tag-licens";
        $message = "Remove Tag Licensing Alerts Successfully";
    }

    delete_user_meta( $userId, $alertName );
    echo json_encode(array("success" => 1, "msg" => $message, "class" => $class));
    exit();
}

// function for check serial number in pet profile.

function checkSerialNumberInPetProfile($id,$key){
    $args=array(
        'post_type' => 'pet_profile',
        'post_status' => 'publish',
        'posts_per_page' => -1,
        'meta_query'=>array( 
            array(
                'key' => $key,
                'value' => $id,
            ),
        )
        
    );
    $query = new WP_Query($args);
    if ($query->have_posts()) {
        return 0;
    }else{
        return 1;
    }
}

function eg_extend_subscription_period_intervals( $intervals ) {

  $intervals[12] = sprintf( __( 'Life Time', 'my-text-domain' ), WC_Subscriptions::append_numeral_suffix( 12 ) );


  return $intervals;
}
add_filter( 'woocommerce_subscription_period_interval_strings', 'eg_extend_subscription_period_intervals' );

add_action("wp_ajax_PetProfessionalFilter", "ProfessionalFilter");
add_action("wp_ajax_nopriv_PetProfessionalFilter", "ProfessionalFilter");

function ProfessionalFilter(){
    $loginUser      = new WP_User(get_current_user_id());
    $userRole       = $loginUser->roles;
    $petProfileId   = array();
    // print_r($_POST);  
    if(is_user_logged_in() && in_array("pet_professional", $userRole)){
        if (isset($_POST['SerialNum']) && !empty($_POST['SerialNum'])) {
            $serialNumber = $_POST['SerialNum'];
            $args=array(
                'post_type' => 'pet_profile',
                'post_status' => 'publish',
                'posts_per_page' => -1,
                'meta_query'=>array(
                    'relation' => 'AND',
                        array(
                            'key' => 'smarttag_id_number',
                            'value' => $serialNumber,
                        ),
                    )
                
            );
            $query = new WP_Query($args);
            while( $query->have_posts() ) : $query->the_post();
                $id     = get_the_ID();
                $author = get_post_field( 'post_author', $id );
                if (get_user_meta( $author, "created_by", true) == $loginUser->ID) {
                    array_push($petProfileId,$id);
                }
            endwhile;
        }

        if (isset($_POST['phone']) && !empty($_POST['phone'])) {
            $user = reset( get_users(
                      array(
                       'meta_key' => 'primary_home_number',
                       'meta_value' => $_POST['phone'],
                       'number' => 1,
                       'count_total' => false
                  ) ) );
            if (get_user_meta($user->ID, "created_by", true) == $loginUser->ID) {
                $args = array(
                        'author'        =>  $user->ID,
                        'orderby'       =>  'post_date',
                        'order'         =>  'ASC',
                        'posts_per_page' => -1,
                        'post_type'     => 'pet_profile',
                        'post__not_in'  => $petProfileId
                    );
                $query = new WP_Query($args);
                // print_r($query);
                while( $query->have_posts() ) : $query->the_post();
                    $id     = get_the_ID();
                    array_push($petProfileId,$id);
                endwhile;
            }
        }

        if (isset($_POST['email']) && !empty($_POST['email'])) {
            $user = get_user_by('email', $_POST['email']);
            if (get_user_meta($user->ID, "created_by", true) == $loginUser->ID) {
                $args = array(
                        'author'        =>  $user->ID,
                        'orderby'       =>  'post_date',
                        'order'         =>  'ASC',
                        'posts_per_page' => -1,
                        'post_type'     => 'pet_profile',
                        'post__not_in'  => $petProfileId
                    );
                $query = new WP_Query($args);
                // print_r($query);
                while( $query->have_posts() ) : $query->the_post();
                    $id     = get_the_ID();
                    array_push($petProfileId,$id);
                endwhile;
            }
        }

        if (isset($_POST['petowner']) && !empty($_POST['petowner'])) {

            $user = reset( get_users(
                              array(
                               'meta_key' => 'first_name',
                               'meta_value' => $_POST['petowner'],
                               'number' => 1,
                               'count_total' => false
                          ) ) );
            if (get_user_meta($user->ID, "created_by", true) == $loginUser->ID) {
                $args = array(
                        'author'        =>  $user->ID,
                        'orderby'       =>  'post_date',
                        'order'         =>  'ASC',
                        'posts_per_page' => -1,
                        'post_type'     => 'pet_profile',
                        'post__not_in'  => $petProfileId
                    );
                $query = new WP_Query($args);
                // print_r($query);
                while( $query->have_posts() ) : $query->the_post();
                    $id     = get_the_ID();
                    array_push($petProfileId,$id);
                endwhile;
            }
        }

        if (!empty($petProfileId)) {
            foreach ($petProfileId as $id) {
                $mypod          = pods( 'pet_profile', $id );
                $author         = get_post_field( 'post_author', $id );
                $userInfo       = get_userdata($author);
                // echo "Gaurav";print_r($userInfo);
                $subscriptionId = $mypod->display("smarttag_subscription_id");
                $smartTagId     = $mypod->display('smarttag_id_number');
                if (!empty($subscriptionId)) {
                    $subscription   = wcs_get_subscription($subscriptionId);
                    if (!empty($subscription)) {
                        foreach( $subscription->get_items() as $item_id => $product_subscription ){
                        // Get the name
                            $variationId            = $product_subscription['variation_id'];
                            $variation              = wc_get_product($variationId);
                            $variation_attributes   = $variation->get_variation_attributes();
                            $subscription           = $variation_attributes['attribute_pa_protection'];
                        }
                    }else{
                        $subscription = "This subscription deleted";
                    }
                }else{
                    $subscription = "Not Added";
                }

                $check = checkSmartIDTag(1,'lost_found_pets','pet_status','smarttag_id_number',$smartTagId);
                if ($check) {
                    $form = "<form method='post' action='/my-account/report-pet-lost'><input type='hidden' value='".$id."' name='post_id'><a href='javascript:;' class='post-btn color-red'>Report Lost</a></form>";
                }else{
                    $form = "<form method='post' action='/my-account/report-pet-found-list'><input type='hidden' value='".$smartTagId."' name='smarttag_id_number'><input type='hidden' value='1' name='report_pet_as_found'><a href='javascript:;' class='post-btn'>Report Pet as Found</a></form>";
                }
                echo "<tr>";
                      echo"<td>".get_the_date("d-m-Y",$id)."</td>";
                      echo"<td>".get_user_meta( $author, 'last_name', true )."</td>";
                      echo"<td>".get_user_meta( $author, 'primary_home_number', true )."</td>";
                      echo"<td>".$userInfo->user_email."</td>";
                      echo"<td>".get_the_title( $id )."</td>";
                      echo"<td>".$smartTagId."<br>".$form."</td>";
                      echo"<td>".$subscription."</td>";
                      echo"<td><form method='post'><input type='hidden' name='editPet' value='".$id."'><a href='javascript:;' class='post-btn'>Edit Pet</a></form><form method='post'><input type='hidden' value='".$id."' name='editOwner'><a href='javascript:;' class='post-btn'>Edit Owner</a></form><form method='post'><input type='hidden' name='transferOwner' value='".$id."'><a href='javascript:;' class='post-btn'>Transfer Owner</a></form></td>";
                      echo "</tr>";
            }
        }
    }else{
        echo json_encode(array("success"=>0,"message"=>"Please Login Pet Professional")); 
    }
    exit();
}

add_action("wp_ajax_transferOwnerInfo", "transferOwnerInfo");
add_action("wp_ajax_nopriv_transferOwnerInfo", "transferOwnerInfo");

function transferOwnerInfo(){
    $userId        = get_current_user_id();
    $userhomephone = $_GET['primary_home_number'];
    $phone         = phone_exists( $_GET['primary_home_number'] );
    if ($phone['success']) {
        echo json_encode(array('success'=>0, "msg"=>"Phone number already exist."));
        exit();
    }elseif (email_exists($_GET['primary_email'])) {
        echo json_encode(array('success'=>0, "msg"=>"Email already exist."));
        exit();
    }

    if (! is_email( sanitize_email( $_GET['primary_email'] ) )) {
        echo json_encode(array('success'=>0, "msg"=>"Please provide a valid email address."));
        exit();
    }
    $user_fields = array(
        'user_login' => $_GET['primary_email'],
        'user_email' => $_GET['primary_email'],
        'first_name' => $_GET['primary_first_name'],
        'last_name'  => $_GET['primary_last_name'],
         );
    $newUserId = wp_insert_user($user_fields);
    if (!$newUserId) {
        echo json_encode(array('success'=>0, "msg"=>"Server Error"));
        exit();
    }
    $useraddressline1   = $finalData['primary_address_line1'];
    $useraddressline2   = $finalData['primary_address_line2'];
    $usercity           = $finalData['primary_city'];
    $userstate          = $finalData['primary_state'];
    $usercountry        = $finalData['primary_country'];
    $userzipcode        = $finalData['primary_postcode'];
    $userworkphone      = $finalData['primary_cell_number'];
    $alert              = $finalData['primary_argent_alert'];
    update_user_meta($newUserId,'primary_address_line1',$useraddressline1);
    update_user_meta($newUserId,'primary_address_line2',$useraddressline2);
    update_user_meta($newUserId,'primary_city',$usercity);
    update_user_meta($newUserId,'primary_state',$userstate);
    update_user_meta($newUserId,'primary_postcode',$userzipcode);
    update_user_meta($newUserId,'primary_country',$usercountry);
    update_user_meta($newUserId,'primary_home_number',$userhomephone);
    update_user_meta($newUserId,'primary_cell_number',$userworkphone);
    update_user_meta($newUserId,'created_by',$userId);
    update_user_meta($newUserId,'primary_argent_alert',$alert);
    update_user_meta($newUserId, 'source_system', 'SMARTTAG');
    $arg = array(
        'ID' => $_GET['postId'],
        'post_author' => $newUserId,
    );
    wp_update_post( $arg );
    echo json_encode(array('success'=>0, "msg"=>"User Transfer Successfully."));
    exit();
}


add_action("wp_ajax_UploadPetProfileImage", "UploadPetProfileImage");
add_action("wp_ajax_nopriv_UploadPetProfileImage", "UploadPetProfileImage");
function UploadPetProfileImage(){
    $attachId = 0;
    $postId   = $_POST['postId'];
    if ($_FILES["feature"]['error'] > 0) {
        $msg = 'File name cannot be empty';
    }elseif ($_FILES["feature"]['size'] > 2000000) {
        $msg = 'Please only select images less than 2MB in size';
    }else{
       $upload = wp_upload_bits($_FILES["feature"]["name"], null, file_get_contents($_FILES["feature"]["tmp_name"]));
    
        $filename = $upload['file'];
        $wp_filetype = wp_check_filetype(basename( $filename ), null );
        strtolower($wp_filetype['ext']);
        if (strtolower($wp_filetype['ext']) == 'png' || strtolower($wp_filetype['ext']) == 'jpg' || strtolower($wp_filetype['ext']) == 'jpeg') {
            $wp_upload_dir = wp_upload_dir();
            $attachment = array(
                'guid'              => $wp_upload_dir['url'] . '/' . basename( $filename ),
                'post_mime_type'    => $wp_filetype['type'],
                'post_title'        => preg_replace( '/\.[^.]+$/', '', basename( $filename ) ),
                'post_content'      => '',
                'post_status'       => 'inherit'
            );
            $attachId = wp_insert_attachment( $attachment, $filename, $postId );
            require_once(ABSPATH . 'wp-admin/includes/image.php');
            $attach_data = wp_generate_attachment_metadata( $attachId, $filename );
            wp_update_attachment_metadata( $attachId, $attach_data );
            set_post_thumbnail( $postId, $attachId ); 
            $msg = "Update Profile Successfully";
        }else{
            $msg = "Please upload only jpg, jpeg and png Type Image.";
        }
        
    }
    
    echo json_encode(array("attachId"=>$attachId, "msg"=>$msg));
    exit();
}

add_action("wp_ajax_editPetInfo", "editPetInfo");
add_action("wp_ajax_nopriv_editPetInfo", "editPetInfo");

function editPetInfo(){
    $postId     = $_GET['postId'];
    $postTitle  = $_GET['pet_name'];
    foreach ($_GET as $key => $value) {
        if ($key == 'action' || $key == 'smarttag_id_number') {
            continue;
        }
        if ($key == 'pet_name') {
            wp_update_post($postId, array('post_title' => $postTitle));
            continue;
        }
        update_post_meta($postId,$key,$value);
    }
    echo json_encode(array("success" => 1, "msg" => "Pet info updated successfully."));
    exit();
}

add_action("wp_ajax_updateOwnerInformation", "updateAutherInformation");
add_action("wp_ajax_nopriv_updateOwnerInformation", "updateAutherInformation");

function updateAutherInformation(){
    $userId = $_GET['userId'];
    $msg    = updateOwnerInformation($_GET,$userId,0);
    echo $msg;
    exit();
}