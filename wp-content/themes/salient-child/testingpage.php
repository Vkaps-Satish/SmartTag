<?php 

/* template name: TestingPage */

?>

<?php 

  $customer = wp_get_current_user();
  getSubscription();
  die;
  function checkSubscritpionExsist($field, $value){
    $user_id = get_current_user_id();
    $args = array(
            'post_type' => 'pet_profile',
            // 'author' => $user_id,
            'meta_query' => array(
                array(
                    'key' => $field,
                    'value' => $value,
                ),
              )   
            );

    $query = new WP_Query($args);   
    $postid = $query->posts;
     
    if(empty($postid)){
      return $value;
    }
  }

  // $remainingSubscription = checkSubscritpionExsist('microchip_subscription_id' , '1720-2');  
  // print_r($remainingSubscription);
  // die;
  // $variable = getPlansByItemId(1720);
  // // print_r($variable);die;
  // foreach ($variable[0] as $key => $value) {
  //   if($remainingSubscription = checkSubscritpionExsist('microchip_subscription_id' , $value)){
  //     $values[] = $remainingSubscription;
  //   }  
  // }
  
  
  // die;

  


// Get all customer orders
    $customer_orders = get_posts( array(
        'numberposts' => -1,
        'meta_key'    => '_customer_user',
        'meta_value'  => get_current_user_id(),
        'post_type'   => wc_get_order_types(),
        'post_status' => array_keys( wc_get_order_statuses() ),  //'post_status' => array('wc-completed', 'wc-processing'),
    ) );
    
        $subscriptionId = getSubscriptionIDByOrders($customer_orders);
        $itemIds = getItemIdBySubscriptionId($subscriptionId);
        
        foreach ($itemIds as $key => $value) {
          $variable = getPlansByItemId($value);
          // print_r($variable);die;
          foreach ($variable[0] as $key => $value) {
            
            if($remainingSubscription = checkSubscritpionExsist('microchip_subscription_id' , $value)){
              $values[] = $remainingSubscription;
            }  
          }
        }
        echo "ocean";
         print_r($values);

        /*Get plans by itemsList Id*/
        function getPlansByItemId($itemId){
          if(is_array($itemId)){
              foreach ($itemId as $key => $value) {
                echo "ocean";
                print_r($value);
                echo "ocean";
                $itemList = wc_get_order_item_meta($value,"Serial Number" ,true);
                $searchString = ',';
                if( strpos($itemList, $searchString) !== false ) {
                     $plans[] = explode(",", $itemList);
                }else{
                  $plans[] =$itemList;
                }
              }
          }else{
             $itemList = wc_get_order_item_meta($itemId,"Serial Number" ,true);
             $searchString = ',';
                if( strpos($itemList, $searchString) !== false ) {
                     $plans[] = explode(",", $itemList);
                }else{
                  $plans[] =$itemList;
                }
           }
          return $plans; 
        } 
         

      /*Get item by subscription Id*/
      function getItemIdBySubscriptionId($subscriptionId){
        if(!empty($subscriptionId)){
          foreach ($subscriptionId as $key => $orderId) {
            $order = wc_get_order( $orderId );
            foreach ( $order->get_items() as  $item_key => $item_values ) {
                $item_data = $item_values->get_data();
                $itemId[] = $item_data['id'];
                print_r($itemId);die;
            }
          }
         return $itemId;   
        }else{
          return false;
        }
      }

    /*Get subscription by Orders Id*/        
    function getSubscriptionIDByOrders($customer_orders){
      if(!empty($customer_orders)){
        foreach ($customer_orders as $key => $orderAtt) {
            $subscriptions = wcs_get_subscriptions_for_order( $orderAtt->ID );
           if (!empty($subscriptions)) {
                 foreach ($subscriptions as $subscription) {
                     $id[] = $subscription->id;
                 }
             }
        }
        return $id;
      }else{
        return false;
      }  
    }
function getSubscription(){
  $orderId = 76560;
  $order = wc_get_order( $orderId );
    foreach ( $order->get_items() as  $item_key => $item_values ) {
        $item_data = $item_values->get_data();
        $itemId[] = $item_data['id'];
        print_r($itemId);die;
    }
}