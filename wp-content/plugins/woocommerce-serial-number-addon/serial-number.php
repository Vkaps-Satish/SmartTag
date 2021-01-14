<?php 
/**
 * @package GeekSerialNumber
 * @version 1.0
 */
/*
* Plugin Name: WooCommerce Custom Serial Number
 * Description: This is the woocommerce addon for manage the serial number into order side.
 * Author: GeeksPerHour.
 * Author URI: https://geeksperhour.com/
 * Version: 1.0
*/
require_once plugin_dir_path( __FILE__ ) . 'include/activate.php';
require_once plugin_dir_path( __FILE__ ) . 'include/deactivate.php';

register_activation_hook( __FILE__, array('GeekSerialNumberActivate','activate') );
register_deactivation_hook( __FILE__, array('GeekSerialNumberDeactivate','deactivate') );

class GeekSerialNumber {
	function register(){
		//for backend
		add_action( 'admin_enqueue_scripts', array($this,'backendEnqueue'));

		add_action( 'save_post', array( $this, 'save_post' ), 10, 2 );
        add_action( 'woocommerce_admin_order_items_after_line_items', array( $this,'woocommerce_admin_order_items_after_line_items' ) );

        add_action('add_meta_boxes', array($this,'showingMetaBox'));

	}

    function backendEnqueue(){
		wp_enqueue_style( 'GeekSerialNumberStyle', plugins_url( '/assets/css/admin_mystyle.css', __FILE__ ), array(), false, false);
		wp_enqueue_script( 'GeekSerialNumberScript', plugins_url( '/assets/js/admin_myscript.js', __FILE__ ), array(), false, true);
	}
	
	/**
     * Saves serial numbers used in the order
     */
    function save_post( $post_id, $post ) {
    
        /*if ( $post->post_type != 'shop_order' || empty( $_POST[ 'saving_serial_numbers' ] ) ) {
            return;
        }

        print_r($_POST);*/
        if (isset($_POST['min_serial_num'])) {
            $serialNumArrary  = array();
            $minSerialNumbers = $_POST['min_serial_num'];
            $maxSerialNumbers = $_POST['max_serial_num'];
            $count            = count($minSerialNumbers);
            $j                = 1; 
            $mainCount        = 0;

            $order = new WC_Order();

            foreach ($minSerialNumbers as $lineItemKey => $value) {
                if ($j == $count) {
                    $mainCount = count($value);
                }
                $i = 0;
                $k = 1;
                foreach ($value as $key => $serialNumber) {
                    if ($i == 0) {
                        $serial = $serialNumber."-".$maxSerialNumbers[$lineItemKey][$key];
                    }else{
                        $serial .= ", ".$serialNumber."-".$maxSerialNumbers[$lineItemKey][$key];
                    }

                    if ($k == $mainCount && $mainCount > 0) {
                        if (get_option('microchip_max_serial_number')) {
                            update_option( 'microchip_max_serial_number', $maxSerialNumbers[$lineItemKey][$key],"","yes"); 
                        }else{
                            add_option( 'microchip_max_serial_number', $maxSerialNumbers[$lineItemKey][$key],"","yes"); 
                        }
                    }
                    $i++;
                    $k++;
                }
                wc_delete_order_item_meta( $lineItemKey, 'Serial Number Range' );
                wc_add_order_item_meta($lineItemKey,'Serial Number Range',$serial);
                $j++;
            }
        }

        if (isset($_POST['serial_num_idtag'])) {

            $idTagSerialNumbers = $_POST['serial_num_idtag'];
            $count              = count($idTagSerialNumbers);
            $j                  = 1;
            $mainCount          = 0;

            foreach ($idTagSerialNumbers as $lineItemKey => $value) {
                if ($j == $count) {
                    $mainCount = count($value);
                }
                $i = 0;
                $k = 1;
                foreach ($value as $key => $serialNumber) {
                    if ($i == 0) {
                        $serial = $serialNumber;
                    }else{
                        $serial .= ", ".$serialNumber;
                    }

                    if ($k == $mainCount && $mainCount > 0) {
                        if (get_option('smart_tag_max_serial_numbers')) {
                            update_option( 'smart_tag_max_serial_numbers', $serialNumber, "", "yes");
                        }else{
                            add_option( 'smart_tag_max_serial_numbers', $serialNumber, "", "yes"); 
                        }
                    }
                    $i++;
                    $k++;
                }
                wc_delete_order_item_meta( $lineItemKey, 'Serial Number' );
                wc_add_order_item_meta($lineItemKey,'Serial Number',$serial);
                $j++;
            }
        }
    }

	/**
     * Gets data for serial numbers dropdowns which are displayed using javascript
     */
    function woocommerce_admin_order_items_after_line_items( $order_id ) {
        global $globalMicrochipDataId, $globalMicrochipStandrdId, $globalBrassIdTag, $globalAluminumIdTag;
        // update_option( 'microchip_max_serial_number', 50,"","yes"); 
        $order = new WC_Order($order_id);
        $items = $order->get_items();
        foreach ($items as $itemKey => $item) {
            $data = $item->get_data();
            if (!empty(wc_get_order_item_meta($itemKey,'Serial Number Range'))) {
                // wc_delete_order_item_meta( $itemKey, 'Serial Number Range' );
            }else{
                if ($data['product_id'] == $globalMicrochipDataId || $data['product_id'] == $globalMicrochipStandrdId) {
                    print '<div class="serial-number-manage-div"><input type="text" value="" placeholder="Min range" class="serial-min-range" data-item-key="'.$itemKey.'"/><input type="text" value="" placeholder="Max range" class="serial-max-range" data-item-key="'.$itemKey.'"/></div>';
                }
            }

            if (!empty(wc_get_order_item_meta($itemKey,'Serial Number'))) {
                // wc_delete_order_item_meta( $itemKey, 'Serial Number' );
            }else{
                if ($data['product_id'] == $globalBrassIdTag || $data['product_id'] == $globalAluminumIdTag) {
                    print '<div class="serial-number-manage-div-idtag"><input type="text" value="" placeholder="Serial Number" class="serial-number-idtag" data-item-key="'.$itemKey.'"/></div>';
                }
            }
        }
    }


  /*BOX */

  public function showingMetaBox() {
    $screens = ['shop_order'];
    foreach ($screens as $screen) {
        add_meta_box(
            'codetycon_max_serial', // Unique ID
            'Last used microchip serial number', // Box title
            array($this,'contentIntoMetaBox'), // Content callback, must be of type callable
            $screen, // Post type,
            'side',
            'core'
        );

        add_meta_box(
            'codetycon_tag_max_serial',           // Unique ID
            'Last used idtag serial number',  // Box title
            array($this,'contentIntoSmartTagMetaBox'),  // Content callback, must be of type callable
            $screen,                  // Post type,
            'side',
            'core'
        );
    }
  }

  public function contentIntoMetaBox() {
    if (get_option('microchip_max_serial_number')) {
        $serialNumber = get_option('microchip_max_serial_number');
    }else{
        $serialNumber = 0;
    }
    echo '<h2 class="max-number" id="max-number-h">'.$serialNumber.'</h2>';
  }

  public function contentIntoSmartTagMetaBox() {
    if (get_option('smart_tag_max_serial_numbers')) {
        $serialNumber = get_option('smart_tag_max_serial_numbers');
    }else{
        $serialNumber = 0;
    }
    echo '<h2 class="smart-tag-max-number" id="smart-tag-max-number-h">'.$serialNumber.'</h2>';
  }

}

if(class_exists('GeekSerialNumber')){
	$geekSerialNumber = new GeekSerialNumber();
	$geekSerialNumber->register();
}