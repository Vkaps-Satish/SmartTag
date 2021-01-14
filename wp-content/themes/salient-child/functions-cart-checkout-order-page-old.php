<?php 


/*Start:- Created by Gaurav Geek, Extra Fields for Checkout & Cart Page*/

// Remove Cross Sells From Default Position 
 
remove_action( 'woocommerce_cart_collaterals', 'woocommerce_cross_sell_display' );

// Display variations dropdowns on shop page for variable products
// add_filter( 'woocommerce_loop_add_to_cart_link', 'woo_display_variation_dropdown_on_shop_page' );
 
 function woo_display_variation_dropdown_on_shop_page() {
     
    global $product;
    if( $product->is_type( 'variable' )) {
    
    $attribute_keys = array_keys( $product->get_attributes() );
    ?>
    
    <form class="variations_form cart" method="post" enctype='multipart/form-data' data-product_id="<?php echo absint( $product->id ); ?>" data-product_variations="<?php echo htmlspecialchars( json_encode( $product->get_available_variations() ) ) ?>">
        <?php do_action( 'woocommerce_before_variations_form' ); ?>
    
        <?php if ( empty( $product->get_available_variations() ) && false !== $product->get_available_variations() ) : ?>
            <p class="stock out-of-stock"><?php _e( 'This product is currently out of stock and unavailable.', 'woocommerce' ); ?></p>
        <?php else : ?>
            <table class="variations" cellspacing="0">
                <tbody>
                    <?php foreach ( $product->get_attributes() as $attribute_name => $options ) : ?>
                        <tr>
                            <td class="label"><label for="<?php echo sanitize_title( $attribute_name ); ?>"><?php echo wc_attribute_label( $attribute_name ); ?></label></td>
                            <td class="value">
                                <?php
                                    $selected = isset( $_REQUEST[ 'attribute_' . sanitize_title( $attribute_name ) ] ) ? wc_clean( urldecode( $_REQUEST[ 'attribute_' . sanitize_title( $attribute_name ) ] ) ) : $product->get_variation_default_attribute( $attribute_name );
                                    wc_dropdown_variation_attribute_options( array( 'options' => $options, 'attribute' => $attribute_name, 'product' => $product, 'selected' => $selected ) );
                                    echo end( $attribute_keys ) === $attribute_name ? apply_filters( 'woocommerce_reset_variations_link', '<a class="reset_variations" href="#">' . __( 'Clear', 'woocommerce' ) . '</a>' ) : '';
                                ?>
                            </td>
                        </tr>
                    <?php endforeach;?>
                </tbody>
            </table>
    
            <?php do_action( 'woocommerce_before_add_to_cart_button' ); ?>
    
            <div class="single_variation_wrap">
                <?php
                    /**
                     * woocommerce_before_single_variation Hook.
                     */
                    do_action( 'woocommerce_before_single_variation' );
    
                    /**
                     * woocommerce_single_variation hook. Used to output the cart button and placeholder for variation data.
                     * @since 2.4.0
                     * @hooked woocommerce_single_variation - 10 Empty div for variation data.
                     * @hooked woocommerce_single_variation_add_to_cart_button - 20 Qty and cart button.
                     */
                    do_action( 'woocommerce_single_variation' );
    
                    /**
                     * woocommerce_after_single_variation Hook.
                     */
                    do_action( 'woocommerce_after_single_variation' );
                ?>
            </div>
    
            <?php do_action( 'woocommerce_after_add_to_cart_button' ); ?>
        <?php endif; ?>
    
        <?php do_action( 'woocommerce_after_variations_form' ); ?>
    </form>
        
    <?php } else {
        
    echo sprintf( '<a rel="nofollow" href="%s" data-quantity="%s" data-product_id="%s" data-product_sku="%s" class="%s">%s</a>',
            esc_url( $product->add_to_cart_url() ),
            esc_attr( isset( $quantity ) ? $quantity : 1 ),
            esc_attr( $product->id ),
            esc_attr( $product->get_sku() ),
            esc_attr( isset( $class ) ? $class : 'button' ),
            esc_html( $product->add_to_cart_text() )
        );
    
    }
     
} 
 

/*Start:- This Extra Field Show In Custom ID Tag*/
function checkIssetPostForInputType($post,$key){
    if (isset($post[$key])) {
        echo $post[$key];
    }
}
function single_product_extra_field() {
    global $product; 
    $id = $product->get_id();
    $back = 1;
    $form = false;
    $contant = "ID Tag Engraving - Back";
    if ($id == 6089 || $id == 7722) {
        $back = 0;
        $contant = "ID Tags Engraving - One sided engraving only on ID Tag with a Design";
    }

    if ($id ==  6033 || $id == 6089 || $id == 7722 || $id == 7659) {
       $form = true;
    }

    if ($id == 7722 || $id == 7659) { ?>
        <input type="hidden" name="serialNumber" id="serialNumber" value="<?php checkIssetPostForInputType($_POST,'serialNumber'); ?>">
    <?php }
    // print_r($product);
    if($form){ ?>
        <div class="engraving-fields-wrap">
            <div class="custom_Field engraving-field-inner" id="frontend">
                <h2 class="woo-complex-head">ID Tag Engraving - Front</h2>
                <div class="engraving-field">
                    <span class="engraving-label" for="engraving"><strong>Line 1:</strong> (20 Character Limit)</span>
                    <input type="text" id="engraving_front_line_1" name="engraving_front_line_1" class="front-line" placeholder="Type here" maxlength="20" value="<?php checkIssetPostForInputType($_POST,'frontLine1'); ?>">
                </div>
                <div class="engraving-field">
                    <span class="engraving-label" for="engraving"><strong>Line 2:</strong> (20 Character Limit)</span>
                    <input type="text" id="engraving_front_line_2" name="engraving_front_line_2" class="front-line" placeholder="Type here" maxlength="20" value="<?php checkIssetPostForInputType($_POST,'frontLine2'); ?>">
                </div>
                <div class="engraving-field">
                    <span class="engraving-label" for="engraving"><strong>Line 3:</strong> (20 Character Limit)</span>
                    <input type="text" id="engraving_front_line_3" name="engraving_front_line_3" class="front-line" placeholder="Type here" maxlength="20" value="<?php checkIssetPostForInputType($_POST,'frontLine3'); ?>">
                </div>
                <div class="engraving-field">
                    <span class="engraving-label" for="engraving"><strong>Line 4:</strong> (20 Character Limit)</span>
                    <input type="text" id="engraving_front_line_4" name="engraving_front_line_4" class="front-line" placeholder="Type here" maxlength="20" value="<?php checkIssetPostForInputType($_POST,'frontLine4'); ?>">
                </div>
            </div>
            <div class="custom_Field engraving-field-inner" id="backend">
                <h2 class="woo-complex-head"><?php echo $contant; ?></h2>
                <div class="engraving-field">
                    <span class="engraving-label" for="engraving"><strong>Line 1:</strong> (20 Character Limit)</span>
                    <input type="text" id="engraving_back_line_1" name="engraving_back_line_1" class="back-line" placeholder="Type here" maxlength="20" value="<?php checkIssetPostForInputType($_POST,'backLine1'); ?>">
                </div>
                <div class="engraving-field">
                    <span class="engraving-label" for="engraving"><strong>Line 2:</strong> (20 Character Limit)</span>
                    <input type="text" id="engraving_back_line_2" name="engraving_back_line_2" class="back-line" placeholder="Type here" maxlength="20" value="<?php checkIssetPostForInputType($_POST,'backLine2'); ?>">
                </div>
                <div class="engraving-field">
                    <span class="engraving-label" for="engraving"><strong>Line 3:</strong> (20 Character Limit)</span>
                    <input type="text" id="engraving_back_line_3" name="engraving_back_line_3" class="back-line" placeholder="Type here" maxlength="20" value="<?php checkIssetPostForInputType($_POST,'backLine3'); ?>">
                </div>
                <div class="engraving-field">
                    <span class="engraving-label" for="engraving"><strong>Line 4:</strong> (20 Character Limit)</span>
                    <input type="text" id="engraving_back_line_4" name="engraving_back_line_4" class="back-line" placeholder="Type here" maxlength="20" value="<?php checkIssetPostForInputType($_POST,'backLine4'); ?>">
                </div>
            </div>
        </div>
        <script type="text/javascript">
            jQuery(document).ready(function(){
                var back = "<?php echo $back; ?>";
                if (back == "1") {
                    jQuery('#frontend').show();
                }else{
                    jQuery('#frontend').hide();
                }
            })
        </script>
        <?php
    }
}
 
add_action( 'woocommerce_before_add_to_cart_button', 'single_product_extra_field', 10 );

/*End:- This Extra Field Show In Custom ID Tag*/

/*Start:- Add Extra Fields In Cart Item Data for Custom ID Tag*/

function add_extra_fields_text_to_cart_item( $cart_item_data, $product_id, $variation_id ) {

    $back = true;
    // if ($product_id == 6089 && $variation_id != 6102 && $variation_id != 6103 && $variation_id != 6104 && $variation_id != 6105 && $variation_id != 6106 && $variation_id != 6107) {
    if ($product_id == 6089 || $product_id == 7722) {
        $back = false;
    }

    $form = false;
    if ($product_id ==  6033 || $product_id == 6089 || $product_id == 7722 || $product_id == 7659) {
       $form = true;
    }

    if ($form) {
        $engraving_back_line_1 = filter_input( INPUT_POST, 'engraving_back_line_1' );
        $engraving_back_line_2 = filter_input( INPUT_POST, 'engraving_back_line_2' );
        $engraving_back_line_3 = filter_input( INPUT_POST, 'engraving_back_line_3' );
        $engraving_back_line_4 = filter_input( INPUT_POST, 'engraving_back_line_4' );
        
        if ($back) {
            $engraving_front_line_1 = filter_input( INPUT_POST, 'engraving_front_line_1' );
            $engraving_front_line_2 = filter_input( INPUT_POST, 'engraving_front_line_2' );
            $engraving_front_line_3 = filter_input( INPUT_POST, 'engraving_front_line_3' );
            $engraving_front_line_4 = filter_input( INPUT_POST, 'engraving_front_line_4' );

            $cart_item_data['engraving_front_line_1'] = $engraving_front_line_1;
            $cart_item_data['engraving_front_line_2'] = $engraving_front_line_2;
            $cart_item_data['engraving_front_line_3'] = $engraving_front_line_3;
            $cart_item_data['engraving_front_line_4'] = $engraving_front_line_4;       
        }
        $cart_item_data['engraving_back_line_1'] = $engraving_back_line_1;
        $cart_item_data['engraving_back_line_2'] = $engraving_back_line_2;
        $cart_item_data['engraving_back_line_3'] = $engraving_back_line_3;
        $cart_item_data['engraving_back_line_4'] = $engraving_back_line_4;
    }
     if ($product_id == 7722 || $product_id == 7659) { 
        $serialNumber                   = filter_input( INPUT_POST, 'serialNumber' );
        $cart_item_data['serialNumber'] = $serialNumber;
    }

    if (!empty($variation_id)) {
        $variation              = wc_get_product($variation_id);
        $variation_attributes   = $variation->get_variation_attributes();
        if (isset($variation_attributes['attribute_pa_protection'])) {
            $cart_item_data['attribute_pa_protection'] = $variation_attributes['attribute_pa_protection'];
        }

        if (isset($variation_attributes['attribute_pa_plan'])) {
            $cart_item_data['attribute_pa_plan'] = $variation_attributes['attribute_pa_plan'];
        }
    }
        
    
    return $cart_item_data;
}
 
add_filter( 'woocommerce_add_cart_item_data', 'add_extra_fields_text_to_cart_item', 10, 3 );

/*End:- Add Fields In Cart Item Data*/

/*Start:- Display Extra Fields In Cart Data for Custom ID Tag*/

function display_extra_fields_text_cart( $item_data, $cart_item ) {
    
    $variation_id = $cart_item['variation_id'];
    $product_id   = $cart_item['product_id'];
    $back = true;
    $form = false;

    if ($product_id ==  6033 || $product_id == 6089 || $product_id == 7722 || $product_id == 7659) {
       $form = true;
    }
    if ($form) {
            
        // if ($product_id == 6089 && $variation_id != 6102 && $variation_id != 6103 && $variation_id != 6104 && $variation_id != 6105 && $variation_id != 6106 && $variation_id != 6107) {
        if ( $product_id == 6089 || $product_id == 7722 ) {
            $back = false;
            
        }
        if ($product_id == 6089 || $product_id == 7722) {
            $taxonomy = 'pa_style';
        }else{
            $taxonomy = 'pa_color';
        }
        $meta = get_post_meta($variation_id, 'attribute_'.$taxonomy, true);
        $term = get_term_by('slug', $meta, $taxonomy);
        $termId = $term->term_id;
        $image = get_woocommerce_term_meta( $termId, $taxonomy.'_swatches_id_photo', true );
        $image = wp_get_attachment_image_src( $image, "full" );
        if ($product_id ==  6033 || $product_id ==  7659) {
            if (!empty($cart_item['engraving_front_line_1'])) {
                $i = 1;
                $item_data[] = array(
                    'key'     => __( 'Pet Name', 'iconic' ),
                    'value'   => wc_clean( $cart_item['engraving_front_line_1'] ),
                    'display' => wc_clean( $cart_item['engraving_front_line_1'] ),
                );
                $size       = count($item_data);
                $newItem_data = $item_data;
                $j = 0;
                while ($j < $size) {
                    if ($j == $size-1) {
                        $item_data[0] = $newItem_data[$size-1];
                    }else{
                        $item_data[$j+1] = $newItem_data[$j];
                    }
                    $j++;
                }
            }
        }elseif ($product_id == 6089 || $product_id == 7722) {
            if (!empty($cart_item['engraving_back_line_1'])) {
                $i = 1;
                $item_data[] = array(
                    'key'     => __( 'Pet Name', 'iconic' ),
                    'value'   => wc_clean( $cart_item['engraving_back_line_1'] ),
                    'display' => wc_clean( $cart_item['engraving_back_line_1'] ),
                );
                $size       = count($item_data);
                $newItem_data = $item_data;
                $j = 0;
                while ($j < $size) {
                    if ($j == $size-1) {
                        $item_data[0] = $newItem_data[$size-1];
                    }else{
                        $item_data[$j+1] = $newItem_data[$j];
                    }
                    $j++;
                }
            }
        }
        if ($back) {
            $i =1;
            while($i < 5){
                if (!empty($cart_item['engraving_front_line_'.$i])) {
                    $item_data[] = array(
                        'key'     => __( 'Front Line '.$i, 'iconic' ),
                        'value'   => '<span class="engraving_front_line engraving_front_line_'.$i.'">'.wc_clean( $cart_item['engraving_front_line_'.$i] ).'</span>',
                        'display' => '<span class="engraving_front_line engraving_front_line_'.$i.'">'.wc_clean( $cart_item['engraving_front_line_'.$i] ).'</span>',
                    );
                }
                $i++;
            }
            
            /*$item_data[] = array(
                'value'   => wc_clean( $cart_item['engraving_back_line_2'] ),
                'display' => '',
            );
            $item_data[] = array(
                'value'   => wc_clean( $cart_item['engraving_back_line_3'] ),
                'display' => '',
            );
            $item_data[] = array(
                'value'   => wc_clean( $cart_item['engraving_back_line_4'] ),
                'display' => '',
            );*/
        }
        // wp_mail("gaurav@geeksperhour.com","Images",print_r($image,true));
        $item_data[] = array(
            'key'     => __( 'Front Image', 'iconic' ),
            'value'   => "<img src='".$image[0]."'>",
            'display' => "<img src='".$image[0]."'>",
        );
        $i = 1;
        while($i < 5){
            if (!empty($cart_item['engraving_back_line_'.$i])) {
                $item_data[] = array(
                    'key'     => __( 'Back Line '.$i, 'iconic' ),
                    'value'   => '<span class="engraving_back_line engraving_back_line_'.$i.'">'.wc_clean( $cart_item['engraving_back_line_'.$i] ).'</span>',
                    'display' => '<span class="engraving_back_line engraving_back_line_'.$i.'">'.wc_clean( $cart_item['engraving_back_line_'.$i] ).'</span>',
                );
            }
            $i++;
        }
        /*$item_data[] = array(
            'value'   => wc_clean( $cart_item['engraving_front_line_1']),
            'display' => '',
        );
        $item_data[] = array(
            'value'   => wc_clean( $cart_item['engraving_front_line_2'] ),
            'display' => '',
        );
        $item_data[] = array(
            'value'   => wc_clean( $cart_item['engraving_front_line_3'] ),
            'display' => '',
        );
        $item_data[] = array(
            'value'   => wc_clean( $cart_item['engraving_front_line_4'] ),
            'display' => '',
        );*/
        if ($back) {
            $item_data[] = array(
                'key'     => __( 'Back Image', 'iconic' ),
                'value'   => '<img src="'.$image[0].'">',
                'display' => '<img src="'.$image[0].'">',
            );
        }else{
            $taxonomy = 'pa_ttype';
            $meta = get_post_meta($variation_id, 'attribute_'.$taxonomy, true);
            $term = get_term_by('slug', $meta, $taxonomy);
            $image = $term->slug;
            if ($image == 'bone') {
                $item_data[] = array(
                    'key'     => __( 'Back Image', 'iconic' ),
                    'value'   => '<img src="https://idtag.agiliscloud.com/wp-content/themes/salient-child/images/back/bone-back.png">',
                    'display' => '<img src="https://idtag.agiliscloud.com/wp-content/themes/salient-child/images/back/bone-back.png">',
                );
            }elseif($image == 'circle'){
                $item_data[] = array(
                    'key'     => __( 'Back Image', 'iconic' ),
                    'value'   => '<img src="https://idtag.agiliscloud.com/wp-content/themes/salient-child/images/back/circle-back.png">',
                    'display' => '<img src="https://idtag.agiliscloud.com/wp-content/themes/salient-child/images/back/circle-back.png">',
                );
            }elseif ($image == 'heart') {
                $item_data[] = array(
                    'key'     => __( 'Back Image', 'iconic' ),
                    'value'   => '<img src="https://idtag.agiliscloud.com/wp-content/themes/salient-child/images/back/heart-back.png">',
                    'display' => '<img src="https://idtag.agiliscloud.com/wp-content/themes/salient-child/images/back/heart-back.png">',
                );
            }
            
        }

    }   
    if ($product_id == 7722 || $product_id == 7659) { 
        $item_data[] = array(
            'key'     => __( 'Serial Number', 'iconic' ),
            'value'   => $cart_item['serialNumber'],
            'display' => $cart_item['serialNumber'],
        );
    }

    if (isset($cart_item['attribute_pa_protection'])) {
        $item_data[] = array(
            'key'     => __( 'Subscription Plan', 'iconic' ),
            'value'   => $cart_item['attribute_pa_protection'],
            'display' => $cart_item['attribute_pa_protection'],
        );
    }

    if (isset($cart_item['attribute_pa_plan'])) {
        $item_data[] = array(
            'key'     => __( 'Duration', 'iconic' ),
            'value'   => $cart_item['attribute_pa_plan'],
            'display' => $cart_item['attribute_pa_plan'],
        );
    }

    return $item_data;
}
 
add_filter( 'woocommerce_get_item_data', 'display_extra_fields_text_cart', 10, 2 );

/*End:- Display Extra Fields In Cart*/

/*Start:- Add Extra Fields In Order Items For Custom ID Tag*/

function add_extra_fields_text_to_order_items( $item, $cart_item_key, $values, $order ) {

    print_r($values);die;
    $design         = $item->legacy_values['variation']['attribute_pa_design'];
    $product_id     = $item->legacy_values['product_id'];
    $variation_id   = $item->legacy_values['variation_id'];
    $back           = true;
    $form           = false;

    if ($product_id ==  6033 || $product_id == 6089 || $product_id == 7722 || $product_id == 7659) {
       $form = true;
    }

    if ($form) {
        // if ($product_id == 6089 && $variation_id != 6102 && $variation_id != 6103 && $variation_id != 6104 && $variation_id != 6105 && $variation_id != 6106 && $variation_id != 6107) {
        if ($product_id == 6089 || $product_id == 7722) {
            $back = false;
        }

        if ($product_id == 6089 || $product_id == 7722) {
            $taxonomy = 'pa_style';
        }else{
            $taxonomy = 'pa_color';
        }
        $meta = get_post_meta($variation_id, 'attribute_'.$taxonomy, true);
        $term = get_term_by('slug', $meta, $taxonomy);
        $termId = $term->term_id;
        $image = get_woocommerce_term_meta( $termId, $taxonomy.'_swatches_id_photo', true );
        $image = wp_get_attachment_image_src( $image, "full" );
        if ($back) {
            $item->add_meta_data( 'FrontLine1', "<span>".$values['engraving_front_line_1']."</span>" );
            $item->add_meta_data( 'FrontLine2', "<span>".$values['engraving_front_line_2']."</span>" );
            $item->add_meta_data( 'FrontLine3', "<span>".$values['engraving_front_line_3']."</span>" );
            $item->add_meta_data( 'FrontLine4', "<span>".$values['engraving_front_line_4']."</span>" );
        }
        $item->add_meta_data( 'FrontImage','<p><img src="'.$image[0].'"></p>');
             
        
        $item->add_meta_data( 'BackLine1', "<span>".$values['engraving_back_line_1']."</span>" );
        $item->add_meta_data( 'BackLine2', "<span>".$values['engraving_back_line_2']."</span>" );
        $item->add_meta_data( 'BackLine3', "<span>".$values['engraving_back_line_3']."</span>" );
        $item->add_meta_data( 'BackLine4', "<span>".$values['engraving_back_line_4']."</span>" );
        if ($back) {
            $item->add_meta_data( 'BackImage','<p><img src="'.$image[0].'"></p>');       
        }else{
            $taxonomy = 'pa_ttype';
            $meta = get_post_meta($variation_id, 'attribute_'.$taxonomy, true);
            $term = get_term_by('slug', $meta, $taxonomy);
            $image = $term->slug;
           // wp_mail("gaurav@geeksperhour.com","images",$image);
            if ($image == 'bone') {
                $item->add_meta_data( 'BackImage','<p><img src="https://idtag.agiliscloud.com/wp-content/themes/salient-child/images/back/bone-back.png"></p>');
            }elseif($image == 'circle'){
                $item->add_meta_data( 'BackImage','<p><img src="https://idtag.agiliscloud.com/wp-content/themes/salient-child/images/back/circle-back.png"></p>');
            }elseif ($image == 'heart') {
                $item->add_meta_data( 'BackImage','<p><img src="https://idtag.agiliscloud.com/wp-content/themes/salient-child/images/back/back-back.png"></p>');
            }
        }
        
    }
    
    if ($product_id == 7722 || $product_id == 7659) { 
        $item->add_meta_data( 'Serial Number', $values['serialNumber'] );
    }   

}
 
add_action( 'woocommerce_checkout_create_order_line_item', 'add_extra_fields_text_to_order_items', 10, 4 );

/*End:- Add Extra Fields In Order Items*/

/*after add to cart redirect other page*/

function action_woocommerce_after_add_to_cart_button($url) { 
    $pos=strpos($_SERVER['HTTP_REFERER'],'?');    
    if ($pos!==false) 
    {
        $refer = substr($_SERVER['HTTP_REFERER'],0,$pos);
    } 
    else 
    {

        $refer = $_SERVER['HTTP_REFERER'];
    }
    if($refer == site_url().'/product/aluminum-id-tag/' || $refer == site_url().'/product/brass-id-tag/'){
        $url =site_url().'/product/smarttag-id-tag-protection-plans/?sub=true';
    }
    return $url;
} 
          
add_filter( 'woocommerce_add_to_cart_redirect', 'action_woocommerce_after_add_to_cart_button'); 

// check for empty-cart get param to clear the cart
add_action( 'init', 'woocommerce_clear_cart_url' );
function woocommerce_clear_cart_url() {
  global $woocommerce;
    
    if ( isset( $_GET['empty-cart'] ) ) {
        $woocommerce->cart->empty_cart(); 
    }
}

/*add_filter( 'woocommerce_cart_needs_shipping', '__return_true' );
add_filter( 'woocommerce_ship_to_different_address_checked', '__return_true' );

  if ( ! function_exists( 'woocommerce_template_loop_add_to_cart' ) ) {

  function woocommerce_template_loop_add_to_cart() {
    global $product;

    if ($product->product_type == "variable" && (is_product() || is_product_category() || is_product_tag())) {
      woocommerce_variable_add_to_cart(); ?>
        <style type="text/css">
            .select-option.swatch-wrapper {
                display: none;
            }

            .custom-radio-img {
                display:  none;
            }

            select#pa_shape {
                display: block !important;
            }

            select#pa_size {
                display: block !important;
            }

            select#pa_color, .woocommerce .reset_variations {
                display: block !important;
            }
            .engraving-fields-wrap.two-cols, .attribute_pa_shape_picker_label.swatch-label{
                display: none !important;
            }
        </style>
        <script type="text/javascript">
            jQuery(document).ready(function($){
                $(".reset_variations").show();
                $(".variations_form .row .col-sm-8").remove();
                $(".variations_form .row .col-sm-4").removeClass("col-sm-4").addClass("col-sm-12");
                $(".variations_form .row .woo-complex-custom-prod-desc").remove();
                $(".engraving-fields-wrap.two-cols").remove();
            });
        </script>
      <?php 
    }

    else {
      woocommerce_get_template( 'loop/add-to-cart.php' );
    }
  }

}
*/