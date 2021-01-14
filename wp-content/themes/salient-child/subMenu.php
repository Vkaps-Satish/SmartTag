<?php
class subMenu extends Walker_Nav_Menu {
    function end_el(&$output, $item, $depth=0, $args=array()) {

    // if( 'Pet Professionals' == $item->title ){
    	if( 'Pet Professionals' == $item->title && 'Testimonials' != $item->title ){
        $output .= '<ul class="sub-menu new-menu">
        <li class="menu-item menu-item-type-post_type menu-item-object-page " id="menu-item-48"><a href="/product-category/id-tags-products/id-tags-products-microchips-and-scanners/">Microchips and Scanners</a></li>
        <li class="menu-item menu-item-type-post_type menu-item-object-page " id="menu-item-49"><a href="/universal-microchip-register-new/">Register Microchips & ID Tags</a></li>
        </ul>';
    }
    $output .= "</li>\n";  
    }
}
