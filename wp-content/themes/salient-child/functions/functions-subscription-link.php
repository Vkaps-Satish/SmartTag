<?php 
add_action( 'woocommerce_account_subscription-link-to-product_endpoint', 'my_account_endpoint_content_subscription_link_to_product' );

function my_account_endpoint_content_subscription_link_to_product(){
  $postId = 0;
  $check  = 1;
  echo '<div class="page-heading"><h1>Link ID Tag Subscription Plan to Pet</h1></div>';

  if (isset($_GET['pet_id'])) {
    $userId   = get_current_user_id();
    $postId   = $_GET['pet_id'];
    $postType = get_post_type($postId);
    $authorId = get_post_field( 'post_author', $postId );
    if ($authorId == $userId && $postType == "pet_profile") {
      $postId = $_GET['pet_id'];
      $mypod  = pods( 'pet_profile', $postId );
      if (empty($mypod->display('smarttag_id_number')) || !empty($mypod->display('smarttag_subscription_id'))) {
        if (empty($mypod->display('smarttag_id_number'))) {
          $check = 0;
          echo "This pet profile id is not linked to IDTag Serial Number.";
        }elseif(!empty($mypod->display('smarttag_subscription_id'))){
          $check = 0;
          echo "This pet profile id is already linked to IDTag Subscription Plan.";
        }
      }
    }else{
      $check = 0;
      echo "This pet id is not valid.";
    }
  } 

  ?>  
  <?php if ($check) { ?>
    <div class="container main-content">
      <div class="row">
        <div class="col-sm-9">
          <div class="site-tabs-wrap main-div">
            <div class="acc-blue-box">
              <div class="acc-content">
                <div class="contact-form sec-cont-info">
                  <form id='link-form' action='' method='post'>
                    <div class="field-wrap two-fields-wrap">
                      <input type="hidden" name="action" value="linkIDTagSubscriptionToPetProfile">
                      <input type="hidden" name="key" value="smarttag_subscription_id">
                      <?php if ($postId) { ?>
                        <input type="hidden" name="petId" value="<?php echo $postId; ?>">
                        <div class="set-alerts-wrap">
                          <h3>
                            <i> <?php echo get_the_title($postId); ?> </i>
                          </h3>
                          <div class="bottom-border-box">
                            <div class="row">
                              <div class="col-sm-3 rmb-15">
                                <?php echo get_the_post_thumbnail($postId); ?>
                              </div>
                              <div class="col-sm-9">
                                <strong>Pet Name:</strong> <?php echo get_the_title($postId); ?>
                                <br>
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
                        </div>
                      <?php }else{ ?>
                        <div class="custom-form">
                          <div class="field-div">
                            <label>Enter pet name.</label>
                            <input type="text" name="auto" id="auto" class="live-search-input">
                            <input type="hidden" name="petId" value="0">
                            <a href="javascript:;" class="clear" style="display: none;">clear</a>
                          </div>
                        </div>
                      <?php } ?>
                      <div class="custom-form">
                        <div class="field-div">
                          <label>Enter subscription serial number.</label>
                          <input type="text" name="serialAuto" id="serial-auto" class="live-search-input">
                          <input type="hidden" name="serial_order" value="0">
                          <input type="hidden" name="serial_id" value="0">
                          <input type="hidden" name="serial" value="0">
                          <a href="javascript:;" class="clear" style="display: none;">clear</a>
                        </div>  
                      </div>
                      <?php if ($postId) { ?>
                        <div class="custom-form">
                          <div class="field-div">
                            <label>&nbsp;</label>
                            <input type="submit" value="Link to pet profile" disabled="" class="btn btn-site" >
                          </div> 
                        </div>
                      </div>
                      <?php }else{ ?>
                        </div>
                        <div class="custom-form">
                          <div class="field-wrap">
                            <div class="field-div">
                              <label>&nbsp;</label>
                              <input type="submit" value="Link to pet profile" disabled="" class="btn btn-site" >
                            </div>
                          </div>
                        </div>
                      <?php } ?> 
                    <!-- <select name="products" class="link-data" id="product">
                      <?php if (!empty($products)) { ?>
                        <option value="0">Please select any pet</option>
                        <?php foreach ($products as $product) { ?>
                          <?php echo '<option value="'.$product['id'].'">'.$product['name'].'</option>'; ?>
                        <?php } ?>
                      <?php } else { ?>
                        <option value="0">Sorry not found any pet.</option>
                      <?php } ?>
                    </select> -->
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <script type="text/javascript">
      jQuery(document).ready(function($){
        $("#auto").autocomplete({
          source: function(request, response) {
              $.getJSON(ajaxurl,{ term:request.term, action:"getListOfPetProfile" }, 
                  response
              );
          },
          minLength: 2,
          response: function( event, ui ) {
            $("input[name=petId]").val("0");
            if ($("input[name=auto]").val() != 0 || $("input[name=auto]").val() != "") {
              $("input[type=submit]").prop("disabled",true);
            }
          },
          select: function( event, ui ) {
            $("input[name=petId]").val(ui.item.id);
            if ($("input[name=auto]").val() != 0 || $("input[name=auto]").val() != "") {
              $("input[type=submit]").prop("disabled",true);
            }
            $("input[name=auto]").prop("disabled",true);
            $("input[name=auto]").parent().find(".clear").show();
          }
        });

        $("#serial-auto").autocomplete({
          source: function(request, response) {
              $.getJSON(ajaxurl,{ term:request.term, action:"getListOfSubscriptionSerial" }, 
                  response
              );
          },
          minLength: 2,
          response: function( event, ui ) {
            $("input[name=serial]").val("0");
            $("input[name=serial_id]").val("0");
            $("input[name=serial_order]").val("0");
            $("input[type=submit]").prop("disabled",true);
          },
          select: function( event, ui ) {
            $("input[name=serial]").val(ui.item.id);
            $("input[name=serial_id]").val(ui.item.serial);
            $("input[name=serial_order]").val(ui.item.orderId);
            <?php if ($postId) { ?>
              $("input[type=submit]").prop("disabled",false);
            <?php }else{ ?>
              if ($("input[name=petId]").val() != 0 || $("input[name=petId]").val() != "") {
                $("input[type=submit]").prop("disabled",false);
              }
            <?php } ?>
            $("input[name=serialAuto]").prop("disabled",true);
            $("input[name=serialAuto]").parent().find(".clear").show();
          }
        });

        $("a.clear").on("click",function(){
          $(this).parent().find("input[name=serialAuto]").prop("disabled",false).val("");
          $(this).parent().find("input[name=auto]").prop("disabled",false).val("");
          $("input[type=submit]").prop("disabled",true);
          $(this).hide();
        });
        $("form#link-form").on("submit",function(event){
          event.preventDefault();
          var form = $(this).serialize();
          $.ajax({
            type: 'POST',
            url: '<?php echo admin_url( 'admin-ajax.php' ); ?>',
            data: form,
            success: function(res){
              var res = jQuery.parseJSON(res);
              if (res.success) {
                jQuery.blockUI({ message: $('#dialog-2'), css: { width: '400px' } });
                $(".custom-form").remove();
              }
            }
          });
        })
      });
    </script>
  <?php } ?>
<?php }

add_action( 'woocommerce_account_microchip-subscription-link-to-product_endpoint', 'my_account_endpoint_content_microchip_subscription_link_to_product' );

function my_account_endpoint_content_microchip_subscription_link_to_product(){

  $postId = 0;
  $check  = 1;
  echo '<div class="page-heading"><h1>Link Microchip Subscription Plan to Pet</h1></div>';

  if (isset($_GET['pet_id'])) {
    $userId   = get_current_user_id();
    $postId   = $_GET['pet_id'];
    $postType = get_post_type($postId);
    $authorId = get_post_field( 'post_author', $postId );
    if ($authorId == $userId && $postType == "pet_profile") {
      $postId = $_GET['pet_id'];
      $mypod  = pods( 'pet_profile', $postId );
      if (empty($mypod->display('microchip_id_number')) || !empty($mypod->display('microchip_subscription_id'))) {
        if (empty($mypod->display('microchip_id_number'))) {
          $check = 0;
          echo "This pet profile id is not linked to Microchip Serial Number.";
        }elseif(!empty($mypod->display('microchip_subscription_id'))){
          $check = 0;
          echo "This pet profile id is already linked to Microchip Subscription Plan.";
        }
      }
    }else{
      $check = 0;
      echo "This pet id is not valid.";
    }
  } 

  ?>  
  <?php if ($check) { ?>
    <div class="container main-content">
      <div class="row">
        <div class="col-sm-9">
          <div class="site-tabs-wrap main-div">
            <div class="acc-blue-box">
              <div class="acc-content">
                <div class="contact-form sec-cont-info">
                  <form id='link-form' action='' method='post'>
                    <div class="field-wrap two-fields-wrap">
                      <input type="hidden" name="action" value="linkIDTagSubscriptionToPetProfile">
                      <input type="hidden" name="key" value="microchip_subscription_id">
                      <?php if ($postId) { ?>
                        <input type="hidden" name="petId" value="<?php echo $postId; ?>">
                        <div class="set-alerts-wrap">
                          <h4>
                            <i> <?php echo get_the_title($postId); ?> </i>
                          </h4>
                          <div class="bottom-border-box">
                            <div class="row">
                              <div class="col-sm-3 rmb-15">
                                <?php echo get_the_post_thumbnail($postId); ?>
                              </div>
                              <div class="col-sm-9">
                                <strong>Pet Name:</strong> <?php echo get_the_title($postId); ?>
                                <br>
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
                        </div>
                      <?php }else{ ?>
                        <div class="custom-form">
                          <div class="field-div">
                            <label>Enter pet name.</label>
                            <input type="text" name="auto" id="auto" class="live-search-input">
                            <input type="hidden" name="petId" value="0">
                            <a href="javascript:;" class="clear" style="display: none;">clear</a>
                          </div>
                        </div>
                      <?php } ?>
                      <div class="custom-form">
                        <div class="field-div">
                          <label>Enter subscription serial number.</label>
                          <input type="text" name="serialAuto" id="serial-auto" class="live-search-input">
                          <input type="hidden" name="serial_order" value="0">
                          <input type="hidden" name="serial_id" value="0">
                          <input type="hidden" name="serial" value="0">
                          <a href="javascript:;" class="clear" style="display: none;">clear</a>
                        </div>  
                      </div>
                      <?php if ($postId) { ?>
                        <div class="custom-form">
                          <div class="field-div">
                            <label>&nbsp;</label>
                            <input type="submit" value="Link to pet profile" disabled="" class="btn btn-site" >
                          </div> 
                        </div>
                      </div>
                      <?php }else{ ?>
                        </div>
                        <div class="custom-form">
                          <div class="field-wrap">
                            <div class="field-div">
                              <label>&nbsp;</label>
                              <input type="submit" value="Link to pet profile" disabled="" class="btn btn-site" >
                            </div>
                          </div>
                        </div>
                      <?php } ?> 
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <script type="text/javascript">
      jQuery(document).ready(function($){
        $("#auto").autocomplete({
          source: function(request, response) {
              $.getJSON(ajaxurl,{ term:request.term, action:"getListOfPetProfile" }, 
                  response
              );
          },
          minLength: 2,
          response: function( event, ui ) {
            $("input[name=petId]").val("0");
            if ($("input[name=auto]").val() != 0 || $("input[name=auto]").val() != "") {
              $("input[type=submit]").prop("disabled",true);
            }
          },
          select: function( event, ui ) {
            $("input[name=petId]").val(ui.item.id);
            if ($("input[name=auto]").val() != 0 || $("input[name=auto]").val() != "") {
              $("input[type=submit]").prop("disabled",true);
            }
            $("input[name=auto]").prop("disabled",true);
            $("input[name=auto]").parent().find(".clear").show();
          }
        });

        $("#serial-auto").autocomplete({
          source: function(request, response) {
              $.getJSON(ajaxurl,{ term:request.term, action:"getListOfMicrochipSubscriptionSerial" }, 
                  response
              );
          },
          minLength: 2,
          response: function( event, ui ) {
            $("input[name=serial]").val("0");
            $("input[name=serial_id]").val("0");
            $("input[name=serial_order]").val("0");
            $("input[type=submit]").prop("disabled",true);
          },
          select: function( event, ui ) {
            $("input[name=serial]").val(ui.item.id);
            $("input[name=serial_id]").val(ui.item.serial);
            $("input[name=serial_order]").val(ui.item.orderId);
            <?php if ($postId) { ?>
              $("input[type=submit]").prop("disabled",false);
            <?php }else{ ?>
              if ($("input[name=petId]").val() != 0 || $("input[name=petId]").val() != "") {
                $("input[type=submit]").prop("disabled",false);
              }
            <?php } ?>
            $("input[name=serialAuto]").prop("disabled",true);
            $("input[name=serialAuto]").parent().find(".clear").show();
          }
        });

        $("a.clear").on("click",function(){
          $(this).parent().find("input[name=serialAuto]").prop("disabled",false).val("");
          $(this).parent().find("input[name=auto]").prop("disabled",false).val("");
          $("input[type=submit]").prop("disabled",true);
          $(this).hide();
        });
        $("form#link-form").on("submit",function(event){
          event.preventDefault();
          var form = $(this).serialize();
          $.ajax({
            type: 'POST',
            url: '<?php echo admin_url( 'admin-ajax.php' ); ?>',
            data: form,
            success: function(res){
              var res = jQuery.parseJSON(res);
              if (res.success) {
                jQuery.blockUI({ message: $('#dialog-2'), css: { width: '400px' } });
                $(".custom-form").remove();
              }
            }
          });
        })
      });
    </script>
  <?php } ?>
<?php 
}

/*add_action('wp_ajax_check_subscription_plan', 'check_subscription_plan_linked_to_product');
add_action('wp_ajax_nopriv_check_subscription_plan', 'check_subscription_plan_linked_to_product');*/
function checkSubscriptionPlanLinkedToProduct($subscriptionId, $key){
	$result = checkSmartIDTag($subscriptionId,'pet_profile',$key);
	$result = json_encode(array("success"=>$result));
	return $result;
}


add_action('wp_ajax_getListOfPetProfile', 'listOfWithoutSubscriptionPetProfile');
add_action('wp_ajax_nopriv_getListOfPetProfile', 'listOfWithoutSubscriptionPetProfile');
function listOfWithoutSubscriptionPetProfile(){
  $i          = 0;
  $searchTerm = $_GET['term'];
  $user_id    = get_current_user_id();
  $products   = array();
  $args       = array(
    'post_type' => 'pet_profile',
    'post_status' => 'publish',
    'author' => $user_id,
    "s" => $searchTerm,
    'posts_per_page' => -1,   
    'orderby'     => 'title', 
    'order'       => 'ASC'   
  );

  $query = new WP_Query($args); 
  print_r($query);
  while ( $query->have_posts() ) : $query->the_post();

    $mypod                  = pods( 'pet_profile', get_the_id() ); 
    $smarttagIdNumber       = $mypod->display('smarttag_id_number');
    $smarttagSubscriptionId = $mypod->display('smarttag_subscription_id');

    if (!empty($smarttagIdNumber) && empty($smarttagSubscriptionId)) { 
      $products[$i]['id']    = get_the_id();
      $products[$i]['name']  = get_the_title();
      $products[$i]['label'] = get_the_title();
      $products[$i]['value'] = get_the_title();
      $i++;
    }

  endwhile;
  echo json_encode($products);
  exit();
}

add_action('wp_ajax_getListOfSubscriptionSerial', 'getListOfSubscriptionSerial');
add_action('wp_ajax_nopriv_getListOfSubscriptionSerial', 'getListOfSubscriptionSerial');
function getListOfSubscriptionSerial(){
  global $micoPrntId, $SmtProPlan;
  $serialNumber = $_GET['term'];
  $itemNumber   = explode("-", $serialNumber);
  $itemKey      = $itemNumber[0];
  $response     = checkSubscriptionPlanLinkedToProduct($serialNumber, 'smarttag_subscription_id');
  $response     = json_decode($response);
  $finalrespns  = array();
  if ($response->success) {
    $subscriptionId = WC_Order_Item_Data_Store::get_order_id_by_order_item_id($itemNumber[0]);
    if ($subscriptionId) {
      $subscription   = wc_get_order($subscriptionId);
      $items          = $subscription->get_items();
      $orderId        = method_exists( $subscription, 'get_parent_id' ) ? $subscription->get_parent_id() : $subscription->order->id;
      $serialNumbers  = wc_get_order_item_meta($itemKey,'Serial Number');
      $serialNumbers  = explode(",", $serialNumbers);
      if (in_array($serialNumber, $serialNumbers)) {
        foreach ( $items as $itmKey => $item ) {
          if ($itmKey == $itemKey && $item['product_id'] == $SmtProPlan) {
            $finalrespns[0]['label']   = $item['name'];
            $finalrespns[0]['orderId'] = $orderId;
            $finalrespns[0]['id']      = $subscriptionId;
            $finalrespns[0]['value']   = $item['name'];
            $finalrespns[0]['serial']  = $serialNumber;
            break; 
          }
        }
      }
    }
  }
  echo json_encode($finalrespns);
  exit();
}

add_action('wp_ajax_getListOfMicrochipSubscriptionSerial', 'getListOfMicrochipSubscriptionSerial');
add_action('wp_ajax_nopriv_getListOfMicrochipSubscriptionSerial', 'getListOfMicrochipSubscriptionSerial');
function getListOfMicrochipSubscriptionSerial(){
  global $micoPrntId, $SmtProPlan;
  $serialNumber = $_GET['term'];
  $itemNumber   = explode("-", $serialNumber);
  $itemKey      = $itemNumber[0];
  $response     = checkSubscriptionPlanLinkedToProduct($serialNumber, 'microchip_subscription_id');
  $response     = json_decode($response);
  $finalrespns  = array();
  if ($response->success) {
    $subscriptionId = WC_Order_Item_Data_Store::get_order_id_by_order_item_id($itemNumber[0]);
    if ($subscriptionId) {
      $subscription   = wc_get_order($subscriptionId);
      $items          = $subscription->get_items();
      $orderId        = method_exists( $subscription, 'get_parent_id' ) ? $subscription->get_parent_id() : $subscription->order->id;
      $serialNumbers  = wc_get_order_item_meta($itemKey,'Serial Number');
      $serialNumbers  = explode(",", $serialNumbers);
      if (in_array($serialNumber, $serialNumbers)) {
        foreach ( $items as $itmKey => $item ) {
          if ($itmKey == $itemKey && $item['product_id'] == $micoPrntId) {
            $finalrespns[0]['label']   = $item['name'];
            $finalrespns[0]['orderId'] = $orderId;
            $finalrespns[0]['id']      = $subscriptionId;
            $finalrespns[0]['value']   = $item['name'];
            $finalrespns[0]['serial']  = $serialNumber;
            break; 
          }
        }
      }
    }
  }
  echo json_encode($finalrespns);
  exit();
}

add_action('wp_ajax_linkIDTagSubscriptionToPetProfile', 'linkIDTagSubscriptionToPetProfile');
add_action('wp_ajax_nopriv_linkIDTagSubscriptionToPetProfile', 'linkIDTagSubscriptionToPetProfile');

function linkIDTagSubscriptionToPetProfile(){
  $postId    = $_POST['petId'];
  $oreder    = $_POST['serial_order'];
  $subscrptn = $_POST['serial'];
  $serial    = $_POST['serial_id'];
  $key       = $_POST['key'];
  update_post_meta($postId, $key, $serial);
  echo json_encode(array("success" => true));
  exit();
}
