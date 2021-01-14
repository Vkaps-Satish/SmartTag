<?php 
/*
* Template Name:  Order Replacement Id Tag Template
*/
get_header(); 
if ( !is_user_logged_in() ){
    print('<script>
    		window.location.href = "'.site_url().'/login-to-smarttag/?login=1&redir=https://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'].'";
    	</script>');
    die();    
}
?>
<div class="container-wrap">		
	<div class="container main-content">
		<div class="row">
			<div class="col-sm-3 woo-sidebar">
				<h3 class="widgettitle"><?php echo $parent_title = get_the_title($post->post_parent); ?></h3>
				<?php echo do_shortcode("[wpb_childpages]"); ?>
		    </div>
			<div class="col-sm-9">
				<div class="page-heading">
					<h1><?php echo get_the_title(); ?></h1>
				</div>
				<?php 

				if (isset($_POST['post_id']) && isset($_POST['smarttagid'])) {
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
			                                    echo '<img src="'.get_site_url().'/wp-content/themes/salient-child/images/black_bone_shape_2_2.png" data-name="color-bone">';
			                                }elseif ($type == "circle") {
			                                    echo '<img src="'.get_site_url().'/wp-content/themes/salient-child/images/bluetag2.jpg" data-name="color-circle">';
			                                }elseif ($type == "heart") {
			                                    echo '<img src="'.get_site_url().'/wp-content/themes/salient-child/images/heart_pink_shape_2.png" data-name="color-heart">';
			                                }
			                            }elseif ($product_id == 6033 || $product_id == 7659) {
			                                if ($shape == "bone") {
			                                    echo '<img src="'.get_site_url().'/wp-content/themes/salient-child/images/bone_back.jpg" data-name="back-img">';
			                                }elseif ($shape == "circle") {
			                                    echo '<img src="'.get_site_url().'/wp-content/themes/salient-child/images/circle_back.png" data-name="back-img">';
			                                }elseif ($shape == "heart") {
			                                    echo '<img src="'.get_site_url().'/wp-content/themes/salient-child/images/brass_heart.jpg" data-name="back-img">';
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
			                        <a href="javascript:;" class="color-light-blue old-product">Order Your Custom Tag <i class="fa fa-caret-right"></i></a>
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
				<?php }else{
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
				                <h3><?= get_the_title(); ?></h3>
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
				                        <form action="" method="post" class="custom-form">
				                            <input type="hidden" name="post_id" value="<?php echo get_the_ID(); ?>">
				                            <input type="hidden" name="smarttagid" value="<?php echo $smarttag_id_number; ?>">
				                            <p><button type="submit" class="replacement-tag button view site-btn-light-blue"><strong>Order a free Replacement Tag</strong> <i class="fa fa-caret-right"></i></button></p>
				                        </form>
				                    </div>
				                </div>
				            </div>
				        <?php 
				        endwhile;
				        $total_pages = $wp_query->max_num_pages;
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
				        echo "Sorry, No pet found";
				    }
				}
				?>
			</div>
		</div>
	</div>
</div>
<?php get_footer(); ?>

	