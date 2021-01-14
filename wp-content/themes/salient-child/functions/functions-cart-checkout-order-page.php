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
    global $product, $globalBrassIdTag, $globalAluminumIdTag, $globalRepBrassIdTag, $globalRepAluminumIdTag; 
    $id = $product->get_id();
    $back = 1;
    $form = false;
    $contant = "ID Tag Engraving - Back";
    if ($id == $globalBrassIdTag || $id == $globalRepBrassIdTag) {
        $back = 0;
        $contant = "ID Tags Engraving - One sided engraving only on ID Tag with a Design";
    }

    if ($id ==  $globalAluminumIdTag || $id == $globalBrassIdTag || $id == $globalRepBrassIdTag || $id == $globalRepAluminumIdTag) {
       $form = true;
    }

    if ($id == $globalRepBrassIdTag || $id == $globalRepAluminumIdTag) { ?>
        <input type="hidden" name="serialNumber" id="serialNumber" value="<?php checkIssetPostForInputType($_POST,'serialNumber'); ?>">
    <?php }
    // print_r($product);
    if($form){ ?>
        <div class="engraving-fields-wrap clearfix">
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

    // $back = true;
    // if ($product_id == 6089 && $variation_id != 6102 && $variation_id != 6103 && $variation_id != 6104 && $variation_id != 6105 && $variation_id != 6106 && $variation_id != 6107) {
    /*if ($product_id == 6089 || $product_id == 7722) {
        $back = false;
    }*/
    global $globalBrassIdTag, $globalAluminumIdTag, $globalRepBrassIdTag, $globalRepAluminumIdTag; 

    $form = false;
    if ($product_id ==  $globalAluminumIdTag || $product_id == $globalBrassIdTag || $product_id == $globalRepBrassIdTag || $product_id == $globalRepAluminumIdTag) {
       $form = true;
    }

    if ($form) {
        $engraving_back_line_1 = filter_input( INPUT_POST, 'engraving_back_line_1' );
        $engraving_back_line_2 = filter_input( INPUT_POST, 'engraving_back_line_2' );
        $engraving_back_line_3 = filter_input( INPUT_POST, 'engraving_back_line_3' );
        $engraving_back_line_4 = filter_input( INPUT_POST, 'engraving_back_line_4' );
        
        if (!empty(trim(filter_input( INPUT_POST, 'engraving_front_line_1' ))) || !empty(trim(filter_input( INPUT_POST, 'engraving_front_line_2' ))) || !empty(trim(filter_input( INPUT_POST, 'engraving_front_line_3' ))) || !empty(trim(filter_input( INPUT_POST, 'engraving_front_line_4' )))) {
            $engraving_front_line_1 = filter_input( INPUT_POST, 'engraving_front_line_1' );
            $engraving_front_line_2 = filter_input( INPUT_POST, 'engraving_front_line_2' );
            $engraving_front_line_3 = filter_input( INPUT_POST, 'engraving_front_line_3' );
            $engraving_front_line_4 = filter_input( INPUT_POST, 'engraving_front_line_4' );
            if (!empty($engraving_front_line_1)) {
                $cart_item_data['engraving_front_line_1'] = $engraving_front_line_1;
                $cart_item_data['engraving_front_line_2'] = $engraving_front_line_2;
                $cart_item_data['engraving_front_line_3'] = $engraving_front_line_3;
                $cart_item_data['engraving_front_line_4'] = $engraving_front_line_4;
            }    
        }
                   
        if (!empty($engraving_back_line_1) || !empty($engraving_back_line_2) || !empty($engraving_back_line_3) || !empty($engraving_back_line_4)) {
            $cart_item_data['engraving_back_line_1'] = $engraving_back_line_1;
            $cart_item_data['engraving_back_line_2'] = $engraving_back_line_2;
            $cart_item_data['engraving_back_line_3'] = $engraving_back_line_3;
            $cart_item_data['engraving_back_line_4'] = $engraving_back_line_4;
        }
    }

    if ($product_id == $globalRepBrassIdTag || $product_id == $globalRepAluminumIdTag) { 
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

    global $globalBrassIdTag, $globalAluminumIdTag, $globalRepBrassIdTag, $globalRepAluminumIdTag;

    $variation_id = $cart_item['variation_id'];
    $product_id   = $cart_item['product_id'];
    $back = true;
    $form = false;

    if ($product_id ==  $globalAluminumIdTag || $product_id == $globalBrassIdTag || $product_id == $globalRepBrassIdTag || $product_id == $globalRepAluminumIdTag) {
       $form = true;
    }

    if ($form) {

        if ( $product_id == $globalBrassIdTag || $product_id == $globalRepBrassIdTag ) {
            $back = false;
        }

        if ($product_id == $globalBrassIdTag || $product_id == $globalRepBrassIdTag) {
            $taxonomy = 'pa_style';
        }else{
            $taxonomy = 'pa_color';
        }

        $meta = get_post_meta($variation_id, 'attribute_'.$taxonomy, true);
        $term = get_term_by('slug', $meta, $taxonomy);
        $termId = $term->term_id;
        $image = get_woocommerce_term_meta( $termId, $taxonomy.'_swatches_id_photo', true );
        $image = wp_get_attachment_image_src( $image, "full" );
       
        if (isset($cart_item['engraving_front_line_1'])) {
            if (!empty(trim($cart_item['engraving_front_line_1']))) {
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
        }elseif (isset($cart_item['engraving_back_line_1'])) {
            if (!empty(trim($cart_item['engraving_back_line_1']))) {
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

        $i =1;
        while($i < 5){
            if (isset($cart_item['engraving_front_line_'.$i]) && !empty($cart_item['engraving_front_line_'.$i])) {
                $item_data[] = array(
                    'key'     => __( 'Front Line '.$i, 'iconic' ),
                    'value'   => '<span class="engraving_front_line engraving_front_line_'.$i.'">'.wc_clean( $cart_item['engraving_front_line_'.$i] ).'</span>',
                    'display' => '<span class="engraving_front_line engraving_front_line_'.$i.'">'.wc_clean( $cart_item['engraving_front_line_'.$i] ).'</span>',
                );
            }
            $i++;
        }
        
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
                    'value'   => '<img src="'.site_url().'/wp-content/themes/salient-child/images/back/bone-back.png">',
                    'display' => '<img src="'.site_url().'/wp-content/themes/salient-child/images/back/bone-back.png">',
                );
            }elseif($image == 'circle'){
                $item_data[] = array(
                    'key'     => __( 'Back Image', 'iconic' ),
                    'value'   => '<img src="'.site_url().'/wp-content/themes/salient-child/images/back/circle-back.png">',
                    'display' => '<img src="'.site_url().'/wp-content/themes/salient-child/images/back/circle-back.png">',
                );
            }elseif ($image == 'heart') {
                $item_data[] = array(
                    'key'     => __( 'Back Image', 'iconic' ),
                    'value'   => '<img src="'.site_url().'/wp-content/themes/salient-child/images/back/heart-back.png">',
                    'display' => '<img src="'.site_url().'/wp-content/themes/salient-child/images/back/heart-back.png">',
                );
            }
            
        }

    }  

    if ($product_id == $globalRepBrassIdTag || $product_id == $globalRepAluminumIdTag) { 
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

    global $globalBrassIdTag, $globalAluminumIdTag, $globalRepBrassIdTag, $globalRepAluminumIdTag;

    $legacyValues   = $item->legacy_values;
    $design         = $item->legacy_values['variation']['attribute_pa_design'];
    $product_id     = $item->legacy_values['product_id'];
    $variation_id   = $item->legacy_values['variation_id'];
    $back           = true;
    $form           = false;

    if (isset($legacyValues['info']) && !empty($legacyValues['info'])) {
        $item->add_meta_data('info',$legacyValues['info']);
        $item->add_meta_data('customDataGPH',$legacyValues['customDataGPH']);
    }

    if (isset($legacyValues['customPetDetail']) && !empty($legacyValues['customPetDetail'])) {
        $item->add_meta_data('customPetDetail',$legacyValues['customPetDetail']);
    }

    if ($product_id ==  $globalAluminumIdTag || $product_id == $globalBrassIdTag || $product_id == $globalRepBrassIdTag || $product_id == $globalRepAluminumIdTag) {
       $form = true;
    }

    if ($form) {
        // if ($product_id == 6089 && $variation_id != 6102 && $variation_id != 6103 && $variation_id != 6104 && $variation_id != 6105 && $variation_id != 6106 && $variation_id != 6107) {
        if ($product_id == $globalBrassIdTag || $product_id == $globalRepBrassIdTag) {
            $back = false;
            $taxonomy = 'pa_style';
        }else{
            $taxonomy = 'pa_color';
        }

        $meta = get_post_meta($variation_id, 'attribute_'.$taxonomy, true);
        $term = get_term_by('slug', $meta, $taxonomy);
        $termId = $term->term_id;
        $image = get_woocommerce_term_meta( $termId, $taxonomy.'_swatches_id_photo', true );
        $image = wp_get_attachment_image_src( $image, "full" );
        if (!empty(trim($values['engraving_front_line_1'])) || !empty(trim($values['engraving_front_line_2'])) || !empty(trim($values['engraving_front_line_3'])) || !empty(trim($values['engraving_front_line_4']))) {
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
            $taxonomy   = 'pa_ttype';
            $meta       = get_post_meta($variation_id, 'attribute_'.$taxonomy, true);
            $term       = get_term_by('slug', $meta, $taxonomy);
            $image      = $term->slug;
           
            if ($image == 'bone') {

                $item->add_meta_data( 'BackImage','<p><img src="'.site_url().'/wp-content/themes/salient-child/images/back/bone-back.png"></p>');

            }elseif($image == 'circle'){

                $item->add_meta_data( 'BackImage','<p><img src="'.site_url().'/wp-content/themes/salient-child/images/back/circle-back.png"></p>');

            }elseif ($image == 'heart') {
                
                $item->add_meta_data( 'BackImage','<p><img src="'.site_url().'/wp-content/themes/salient-child/images/back/heart-back.png"></p>');
            }
        }
        
    }
    
    if ($product_id == $globalRepBrassIdTag || $product_id == $globalRepAluminumIdTag) { 
        $item->add_meta_data( 'Serial Number', $values['serialNumber'] );
    }   

}
 
add_action( 'woocommerce_checkout_create_order_line_item', 'add_extra_fields_text_to_order_items', 10, 4 );

/*End:- Add Extra Fields In Order Items*/

/*after add to cart redirect other page*/

function action_woocommerce_after_add_to_cart_button($url) { 
    if (!isset($_SERVER['HTTP_REFERER'])) {
        return $url;
    }
    $pos=strpos($_SERVER['HTTP_REFERER'],'?');  

    if ($pos!==false) {
        $refer = substr($_SERVER['HTTP_REFERER'],0,$pos);
    }else {
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


function bbloomer_split_product_individual_cart_items( $cart_item_data, $product_id ){
    global $globalUniversalMicrPlanId;

    if ($product_id == $globalUniversalMicrPlanId) {
        $unique_cart_item_key = uniqid();
        $cart_item_data['unique_key'] = $unique_cart_item_key;
    }
    return $cart_item_data;
}

add_filter( 'woocommerce_add_cart_item_data', 'bbloomer_split_product_individual_cart_items', 10, 2 );  

add_action( 'woocommerce_after_cart_item_quantity_update', 'limit_cart_item_quantity', 20, 4 );
function limit_cart_item_quantity( $cart_item_key, $quantity, $old_quantity, $cart ){
    global $globalUniversalMicrPlanId;
    // Here the quantity limit
    $limit = 1;
    $orders_added = $quantity - $limit;

    if( $quantity > $limit ){
        //get product id of item that was updated
        $product_id = $cart->cart_contents[ $cart_item_key ][ 'product_id' ];

        if ($product_id == $globalUniversalMicrPlanId) {
            
            //Set existing line item quantity to the limit of 1
            $cart->cart_contents[ $cart_item_key ]['quantity'] = $limit;

            for( $i = 0; $i< $orders_added; $i++ ){
                //iterate over the number of orders you must as with quantity one
                $unique_cart_item_key = uniqid();
                //create unique cart item ID, this is what breaks it out as a separate line item
                $cart_item_data = array();
                //initialize cart_item_data array where the unique_cart_item_key will be stored
                $cart_item_data['unique_key'] = $unique_cart_item_key;
                //set the cart_item_data at unique_key = to the newly created unique_key

                //add that shit! this does not take into account variable products

                $cart->add_to_cart( $product_id, 1, 0, 0, $cart_item_data );

            }
        }else{
            $cart->cart_contents[ $cart_item_key ]['quantity'] = $quantity;
        }
        // Add a custom notice
        /*wc_add_notice( __('We Split out quantities of more than one into invididual line items for tracking purposes, please update quantities as needed'), 'notice' );*/
    }
}



function hasBoughtMicrochipID($id, $userId = "") {

    global $globalMicrochipDataId, $globalMicrochipStandrdId;
    // Set HERE in the array your specific target product IDs
    $rs = 0;
    $i  = 0;
    $prod_arr = array( $globalMicrochipDataId, $globalMicrochipStandrdId );
    if (empty($userId)) {
        $userId = get_current_user_id();
    }
    // Get all customer orders

    $customer_orders = get_posts( array(
        'numberposts' => -1,
        'meta_key'    => '_customer_user',
        'meta_value'  => $userId,
        'post_type'   => 'shop_order', // WC orders post type
        'post_status' => array_keys( wc_get_order_statuses() ),
    ) );

    foreach ( $customer_orders as $customer_order ) {
        // Updated compatibility with WooCommerce 3+
        $order_id   = $customer_order->ID;
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

    if (is_array($result) && isset($result[0])) {
        foreach ($result as $check) {
            foreach ($check as $key => $value) {
                // print_r($value->key);die;
                if ($value->key == 'Serial Number Range') {
                    $idTagID[] = $value->value;
                }
            }
        }
    }else{
        $rs = 0;
    }

    if (is_array($idTagID) && isset($idTagID[0])) {
        foreach ($idTagID as $value) {
            $values = explode(',', $value);
            foreach ($values as $value) {
                $microchipIDS = explode('-', $value);
                $start        = $microchipIDS[0];
                $end          = $microchipIDS[1];
                while($start <= $end){
                    if ($start == $id) {
                        $rs = 1;
                        break;
                    }
                    $start++;
                }
            }
        }
    }else{
        $rs = 0;
    }
    
    // /*return $rs;
    // $json = array('id'=>$idTagID,'user-id'=>$userId);*/
    return $rs;
}

add_action('wp_ajax_multiCustomerPetPro', 'createMultiCustomerPetPro');
add_action('wp_ajax_nopriv_multiCustomerPetPro', 'createMultiCustomerPetPro');
 
function createMultiCustomerPetPro() {
    wc()->cart->empty_cart();
    $product = array();
    /*if (isset($_POST['user_info'])) {
        $firstName = $_POST['user_info']['first_name'];
        $lastName  = $_POST['user_info']['last_name'];
        $email     = $_POST['user_info']['p_email'];
        foreach ($_POST['pet_info'] as $key => $value) {
            $information = array();
            $info        = array();
            $petName     = $value['pet_name'];
            $microId     = $value['microchip_id_number'];
            $microCm     = $value['microchip_company'];

            $info['firstName'] = $firstName; 
            $info['lastName']  = $lastName; 
            $info['email']     = $email; 
            $info['petName']   = $petName; 
            $info['microId']   = $microId; 
            $info['microCm']   = $microCm; 

            if (isset($product[$value['universalchipPln']]['quantity'])) {
                $product[$value['universalchipPln']]['quantity'] += 1;
            }else{
                $product[$value['universalchipPln']]['quantity'] = 1;
            }

            $product[$value['universalchipPln']]['info']['info'][] = $info;
            $product[$value['universalchipPln']]['info']['customDataGPH'] = $_POST;
        }
    }*/

    if (isset($_POST['users_info'])) {
        foreach ($_POST['users_info'] as $userKey => $userInfo) {
            $firstName = $userInfo['first_name'];
            $lastName  = $userInfo['last_name'];
            $email     = $userInfo['p_email'];

            foreach ($_POST['pets_info'][$userKey] as $petKey => $petInfo) {
                $information = array();
                $info        = array();
                $petName     = $petInfo['pet_name'];
                $microId     = $petInfo['microchip_id_number'];
                $microCm     = $petInfo['microchip_company'];

                $info['firstName'] = $firstName; 
                $info['lastName']  = $lastName; 
                $info['email']     = $email; 
                $info['petName']   = $petName; 
                $info['microId']   = $microId; 
                $info['microCm']   = $microCm; 

                if (isset($product[$petInfo['universalchipPln']]['quantity'])) {
                    $product[$petInfo['universalchipPln']]['quantity'] += 1;
                }else{
                    $product[$petInfo['universalchipPln']]['quantity'] = 1;
                }

                $product[$petInfo['universalchipPln']]['info']['info'][] = $info;
                $product[$petInfo['universalchipPln']]['info']['customDataGPH'] = $_POST;
            }
        }
    }
    foreach ($product as $key => $value) {
        # add_to_cart( $product_id, $quantity, $variation_id, $variation, $cart_item_data );
        $id = wc()->cart->add_to_cart($key, $value['quantity'], $variation_id = 0, $variation = array(), $value['info'] );
    }
    echo json_encode(array("url" => "/checkout"));
    exit();
}

function checkPageForCheckoutProcess(){
    // if (!is_checkout()) {
    if (is_checkout() || is_cart()) {
        $removeCartData = false;
    }else{
        $removeCartData = true;
    }
    if ($removeCartData) {
        global $woocommerce;
        $items = $woocommerce->cart->get_cart();
        foreach($items as $item => $values) { 
            if (isset($values['info'])) {
                wc()->cart->remove_cart_item($values['key']);
            }
        }
    }
}

add_action( 'wp_head', 'checkPageForCheckoutProcess' );

add_action( 'woocommerce_order_status_processing', 'checkOrderForCreateTheUsersPet' );
add_action( 'woocommerce_order_status_completed', 'checkOrderForCreateTheUsersPet' );

function checkOrderForCreateTheUsersPet($orderId){
    global $globalUniversalMicrPlanId, $micoPrntId, $SmtProPlan;
    $subscriptionsIds = wcs_get_subscriptions_for_order( $orderId );
    if (!empty($subscriptionsIds)) {
        foreach ($subscriptionsIds as $subscriptionId => $subscription_data) {
            $order = wc_get_order($subscriptionId);
            foreach ($order->get_items() as $itemKey => $itemData ):

                $productId = $itemData['product_id'];

                /*Start  Generate the Serial Number of Subscription plan*/

                $quantity = $itemData->get_quantity();
                if (empty(wc_get_order_item_meta($itemKey,'Serial Number'))) {
                    if ($quantity > 1) {
                        $i = 1;
                        while ($i <= $quantity) {
                            if ($i > 1) {
                                $serialNumber .= ",".$itemKey."-".$i;
                            }else{
                                $serialNumber = $itemKey."-".$i;
                            }
                            $i++;
                        }
                    }else{
                        $serialNumber = $itemKey."-1";
                    }
                    wc_add_order_item_meta($itemKey,'Serial Number',$serialNumber);
                }

                /*End  Generate the Serial Number of Subscription plan*/

                /*Start add the universal microchip subscription plan id into pet profile*/

                //url https://prelaunch.idtag.com/universal-microchip-register-new/

                $customPetData = wc_get_order_item_meta($itemKey,'customPetDetail');

                if ($productId == $SmtProPlan) {
                    $slug   = "smarttag_subscription_id";
                }elseif ($productId == $micoPrntId) {
                    $slug   = "microchip_subscription_id";
                }elseif ($productId == $globalUniversalMicrPlanId) {
                    $slug   = "universal_subscription_id";
                }


                if (!empty($customPetData)) {
                    $petProfileId  = $customPetData['petId'];

                    if (!get_post_meta($petProfileId, $slug, true)) {
                        $serialNumbers = wc_get_order_item_meta($itemKey,'Serial Number'); 
                        $serialNumbers = explode(",", $serialNumbers);

                        update_post_meta($petProfileId, $slug, $serialNumbers[0]);
                        $myPost = array(
                          'ID'           => $petProfileId,
                          'post_status'   => 'publish',
                        );
                        wp_update_post( $myPost );
                    }
                }

                /*End add the universal microchip subscription plan id into pet profile*/


                /*create the pet profile and user for Pet pro*/
                if (!empty(wc_get_order_item_meta( $itemKey, 'customDataGPH' ))) {
                    $datas    = wc_get_order_item_meta( $itemKey, 'info' );
                    $allDatas = wc_get_order_item_meta( $itemKey, 'customDataGPH' );
                    $serialId = wc_get_order_item_meta($itemKey,'Serial Number');
                    $serialIds = explode(",", $serialId);
                    wc_delete_order_item_meta( $itemKey, 'customDataGPH' );
                    wc_delete_order_item_meta( $itemKey, 'info' );
                    foreach ($datas as $data) {
                        $email   = $data['email'];
                        $microId = $data['microId'];
                        if (isset($allDatas['users_info'])) {
                            $k = 0;
                            foreach ($allDatas['users_info'] as $userKey => $allData) {
                                if($allData['p_email'] == $email){
                                    foreach ($allDatas['pets_info'][$userKey] as $petKey => $pet) {
                                        if (isset($pet['microchip_id_number']) && $pet['microchip_id_number'] == $microId) {
                                            if (checkUniversalMicrochipIdForPetProfileReturn($microId)) {
                                                $petId = createPetProfileForPetProFormsUniversalMicrochipForm($pet);
                                            }else{
                                                $petId = "";
                                            }
                                            break;
                                        }
                                    }

                                    if (!empty($petId)) {
                                        if (email_exists($allData['p_email'])) {
                                            $userId = email_exists($allData['p_email']);
                                        }else{
                                            $user_fields = array(
                                                'user_login'    => $allData['p_email'],
                                                'role'          => 'customer',
                                                'user_email'    => $allData['p_email'],
                                                'first_name'    => $allData['first_name'],
                                                'last_name'     => $allData['last_name'],
                                                'display_name'  => $allData['first_name'],
                                            );
                                            $userId = wp_insert_user($user_fields);
                                            update_user_meta( $userId,'created_by',get_current_user_id());
                                        }

                                        update_user_meta( $userId, 'primary_country', $allData['primary_country'] );
                                        update_user_meta( $userId, 'primary_address_line1', $allData['primary_address_line1'] );
                                        update_user_meta( $userId, 'primary_address_line2', $allData['primary_address_line2'] );
                                        update_user_meta( $userId, 'primary_city', $allData['primary_city'] );
                                        update_user_meta( $userId, 'primary_state', $allData['primary_state'] );
                                        update_user_meta( $userId, 'primary_postcode', $allData['primary_postcode'] );
                                        update_user_meta( $userId, 'primary_home_number', $allData['primary_home_number'] );
                                        update_user_meta( $userId, 'primary_phone_country_code', $allData['primary_home_number_code'] );
                                        update_user_meta( $userId, 'primary_cell_number', $allData['primary_cell_number'] );
                                        update_user_meta( $userId, 'primary_cell_country_code', $allData['primary_cell_number_code'] );

                                        $arg = array( 'ID' => $petId,'post_author' => $userId);
                                        update_post_meta($petId , $slug, $serialIds[$k]);
                                        /*update_post_meta($petId , 'subscription_id', $subscriptionId);
                                        update_post_meta($petId , 'order_id', $orderId);*/
                                        wp_update_post( $arg );
                                        $k++;
                                        break;
                                    }
                                }
                            }
                        }
                    }
                }
            endforeach;
        }
    }
}

function createPetProfileForPetProFormsUniversalMicrochipForm($pets){
    $title = $pets['pet_name'];
    $newPost = array(
        'post_title'  => $title,
        'post_status' => 'publish',        
        'post_type'   => 'pet_profile' ,       
    );

    $postId = wp_insert_post($newPost);

    if ($postId) {
        update_post_meta($postId , 'universal_microchip_id', $pets['microchip_id_number']);
        update_post_meta($postId , 'microchip_company', $pets['microchip_company']);
        update_post_meta($postId , 'pet_name', $pets['pet_name']);
        update_post_meta($postId , 'primary_breed', $pets['primary_breed']);
        update_post_meta($postId , 'gender', $pets['gender']);
        update_post_meta($postId , 'pet_type', $pets['PetTyp']);
        update_post_meta($postId , 'secondary_breed', $pets['secondary_breed']);
        update_post_meta($postId , 'primary_color', $pets['primary_color']);
        update_post_meta($postId , 'secondary_color', $pets['secondary_color']);
        update_post_meta($postId , 'size', $pets['Size']);
        update_post_meta($postId , 'pet_date_of_birth', $pets['pet_date_of_birth']);
        // update_post_meta($postId , 'microchip_subscription_id', $subscriptionID);
        return $postId; 
    }   
}

add_filter( 'woocommerce_checkout_update_order_meta', 'save_primary_phone_to_order_received_page', 10 , 1 );
function save_primary_phone_to_order_received_page ( $order_id ) {
    if (is_user_logged_in()) {
        $userId = get_current_user_id();
        update_user_meta( $userId, 'primary_home_number', $_POST ['billing_phone'] );
    }
}

function custom_wc_ajax_variation_threshold( $qty, $product ) {
    return 50;
}

add_filter( 'woocommerce_ajax_variation_threshold', 'custom_wc_ajax_variation_threshold', 10, 2 );

function get_orders_ids_by_product_id( $product_id,  $user_id = '', $order_status = array( 'wc-completed', 'wc-processing' ) ){
    global $wpdb;

    if (!empty($user_id)) {
        $forUser = "LEFT JOIN {$wpdb->prefix}postmeta AS postmeta ON order_items.order_id = postmeta.post_id WHERE posts.post_type = 'shop_order' AND postmeta.meta_key = '_customer_user' 
        AND postmeta.meta_value = '".$user_id."'";
    }else{
        $forUser = "WHERE posts.post_type = 'shop_order'";
    }

    $results = $wpdb->get_col("
        SELECT order_items.order_id
        FROM {$wpdb->prefix}woocommerce_order_items as order_items
        LEFT JOIN {$wpdb->prefix}woocommerce_order_itemmeta as order_item_meta ON order_items.order_item_id = order_item_meta.order_item_id
        LEFT JOIN {$wpdb->posts} AS posts ON order_items.order_id = posts.ID
        $forUser
        AND posts.post_status IN ( '" . implode( "','", $order_status ) . "' )
        AND order_items.order_item_type = 'line_item'
        AND order_item_meta.meta_key = '_product_id'
        AND order_item_meta.meta_value = '$product_id'
    ");

    return $results;
}

// print_r(get_orders_ids_by_product_id(6134));

// add_filter( 'woocommerce_is_sold_individually', '__return_true' );