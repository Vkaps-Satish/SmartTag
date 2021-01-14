<?php
/*
 * Template Name: Update or Transfer Microchips
 */
get_header();

if ( is_user_logged_in() ){
  $current_user = wp_get_current_user();
  $roles = $current_user->roles; 

  if( !$roles == 'pet_professional' || !in_array( 'pet_professional', $roles )){
    print('<div>
      <div class="not-found-text width-100">This page is only for Pet-Professionals..</div></div>');
    die();
  }

}else{
  print('<script>window.location.href="/pet-professionals-signup"</script>');
} 
$userId = get_current_user_id();
global $wp;
?>
<div class="container-wrap">    
  <div class="container main-content">
    <div class="row">
      <div class="woo-sidebar col-sm-3">
        <!-- <?php echo do_shortcode("[wpb_childpages]");?> -->
        <?php echo do_shortcode("[stag_sidebar id='pet-professional-sidebar']"); ?>
        &nbsp;
        <?php echo do_shortcode("[stag_sidebar id='main-sidebar']");?>
      </div>
      <div class="woo-content col-sm-9" id="woo-content">
        <?php if (has_post_thumbnail( $post->ID ) ): ?>
          <?php $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'single-post-thumbnail' ); ?>
          <div class="page-image">
            <img src="<?php echo $image[0]; ?>" alt="image" />
          </div>
        <?php endif; ?>
        <?php if (isset($_GET['author_id']) && !empty($_GET['author_id']) && isset($_GET['post_id']) && !empty($_GET['post_id'])) {
          $createdBy = get_user_meta($_GET['author_id'], "created_by", true);
          if ($_GET['author_id'] == $userId) {
            $createdBy = $userId;
          }
          $author = get_post_field( 'post_author', $_GET['post_id'] ); ?>
          <div class="page-heading heading-right-link">
            <h1>Update or Transfer Microchips</h1>
            <a href="<?php echo home_url($wp->request); ?>"><i class="fa fa-caret-left"></i>&nbsp;Back to Registration History</a>
          </div>   
          <h4>Transfer Owner</h4> 
          <?php if($createdBy == $userId && $author == $_GET['author_id']){ ?>
            <form action="" method="post" id="transferInfo" class="transferOwnerInfo">
                <input type="hidden" name="postId" value="<?php echo $_GET['post_id']; ?>">
                <input type="hidden" name="action" value="transferOwnerInfo">
                <div class="contact-form">
                    <div class="acc-blue-box">
                        <div class="acc-blue-head">
                            Owner Information
                        </div>
                        <div class="acc-blue-content">
                            <div class="field-wrap three-fields-wrap">
                                <div class="field-div">
                                    <label>&nbsp;</label>
                                    <span>New Owner</span>
                                    <input type="radio" name="existingUser" value="0" checked="" class="mb-20 existingUser">
                                </div>
                                <div class="field-div">
                                    <label>&nbsp;</label>
                                    <span>Existing Owner</span>
                                    <input type="radio" name="existingUser" value="1" class="mb-20 existingUser">
                                </div>
                                <div class="field-div custom-live-search" style="display: none;">
                                    <div class="ui-widget">
                                        <label for="birds">Search For Existing Owner: </label>
                                        <input type='text' placeholder='Enter existing owner email.' class="live-search-input">
                                        <input type="hidden" name="registerOwnerId">
                                    </div>
                                </div>
                            </div>
                            <div class="field-wrap two-fields-wrap">
                                <div class="field-div">
                                    <label>*First Name:</label>
                                    <input type="text" name="primary_first_name" value="" placeholder="First Name" class="user-data">
                                </div>
                                <div class="field-div">
                                    <label>*Last Name:</label>
                                    <input type="text" name="primary_last_name" value="" placeholder="Last Name" class="user-data">
                                </div>
                            </div>                            
                            <div class="field-wrap">
                                <div class="field-div">
                                    <label>*Country:</label>
                                    <?php 
                                        $countries_obj = new WC_Countries();
                                        $countries = $countries_obj->__get('countries');
                                        echo '<select name="primary_country" class="address-country user-data">';
                                          foreach ($countries as $key => $value){
                                            echo '<option value="'.$key.'" >'.$value.'</option>';
                                          }
                                        echo '</select>';
                                    ?>
                                </div>
                            </div>
                            <div class="field-wrap two-fields-wrap">
                                <div class="field-div">
                                    <label>*Address:</label>
                                    <input type="text" name="primary_address_line1" value="" placeholder="Address Line 1" class="user-data">
                                </div>
                                <div class="field-div">
                                    <label></label>
                                    <input type="text" name="primary_address_line2" value="" placeholder="Address Line 2" class="user-data">
                                </div>
                            </div>
                            <div class="field-wrap two-fields-wrap">    
                                <div class="field-div">
                                     <input type="text" name="primary_city" value="" placeholder="City" class="user-data">
                                </div>
                                <div class="field-div">
                                    <div class="field-wrap two-fields-wrap">
                                        <div class="field-div">
                                            <label style="display: none;" class="statevalidate"></label>
                                            <select class="address-state user-data" name="primary_state" data-val=""></select>
                                        </div>
                                        <div class="field-div">
                                            <input type="text" name="primary_postcode" value="" placeholder="Zipcode" class="user-data">
                                        </div>
                                    </div>
                                </div>    
                           </div>
                            <div class="field-wrap two-fields-wrap">
                                <div class="field-div">
                                    <label>*Primary Phone Number:</label>
                                    <input type="text" name="primary_home_number" placeholder="1(555) 123-1234" class="user-data">
                                </div>
                                <div class="field-div">
                                    <label>Secondary Phone Number:</label>
                                    <input type="text" name="primary_cell_number" placeholder="1(555) 123-1234" class="user-data">
                                </div>
                            </div> 
                            <div class="field-wrap two-fields-wrap">
                                <div class="field-div">
                                    <label>*Email:</label>
                                    <input type="email" name="primary_email" id="primary_email" value="" placeholder="Email Address" class="user-data">
                                    <span class="error-email"></span>
                                </div>
                                <div class="field-div primary-alert">
                                    <label>*Receive Urgent Alert?</label>
                                    <div class="field-div">
                                        <div class="two-checks">
                                            <p>
                                                <input name="primary_argent_alert" class="primary_argent_alert primary-info-check" value="yes" type="radio"> Yes
                                            </p>
                                            <p>
                                                <input name="primary_argent_alert" class="primary_argent_alert primary-info-check" value="no" type="radio"> No
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div> 
                            <div class="field-wrap submit-wrap text-center">
                                <div class="field-div">
                                    <input type="button" name="transferOwnerInfo" id="transferOwner" value="Transfer New Owner Information" class="site-btn-red">
                                </div>
                            </div> 
                            <div class="field-wrap error">
                              <div class="field-div">
                              </div>
                            </div>
                            <div class="field-wrap success">
                              <div class="field-div">
                              </div>
                            </div>
                        </div>
                    </div> 
                </div>
            </form>
            <script type="text/javascript">
              jQuery(document).ready(function($){
                var transferValidator = $('form[id="transferInfo"]').validate({
                  rules: {
                      primary_first_name: 'required',
                      primary_last_name: 'required',
                      primary_country: 'required',
                      primary_address_line1: 'required',
                      primary_home_number:{
                          required: true,
                             number: true,
                             minlength:10,
                             maxlength:10
                         },
                         primary_cell_number:{ 
                             number: true,
                             minlength:10,
                             maxlength:10
                         }, 
                      primary_email: 'required',
                      primary_argent_alert: 'required',
                  },
                  submitHandler: function(form) {
                    form.submit();
                  }
                });

                $('body').on('click','#transferOwner', function () {
                  if($("#transferInfo").valid()){
                    $("body .loader-wrap").show();
                    var dataa = $("#transferInfo").serialize();
                    $.ajax({
                      type: 'GET',
                      url: ajaxurl,
                      data: dataa,
                      contentType: false,
                      processData: false,
                      success: function(response) {
                        $(".acc-blue-content .field-wrap.error .field-div").html("");
                        $(".acc-blue-content .field-wrap.success .field-div").html("");
                        response = jQuery.parseJSON(response);
                        console.log(response.msg);
                        if(response.success == 1){
                          $(".acc-blue-content .field-wrap.success .field-div").html('<div class="alert alert-success alert-dismissible message" style="margin-top:18px;"><a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a><strong>Success!</strong> '+response.msg+'</div>');
                          $("#transferInfo").trigger("reset");
                          $("#transferInfo").find("input[name=action]").val("transferOwnerInfo");
                        }else{
                          $(".acc-blue-content .field-wrap.error .field-div").html('<div class="alert alert-danger alert-dismissible message" style="margin-top:18px;"><a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>'+response.msg+'</div>');
                        }
                        $("body .loader-wrap").hide();
                      }
                    });
                  
                  }else{
                    transferValidator.focusInvalid();
                  }
                });

                $("body").on("change","input.existingUser",function(){
                  if ($(this).val() == 1) {
                    $(this).parent().parent().parent().find("div.field-wrap .user-data").prop("readonly",true);
                    $(this).parent().parent().parent().find("div.field-wrap .user-data").val("");
                    $(this).parent().parent().parent().find("div.field-wrap .user-data").next("p").remove();
                    $(this).parent().parent().find("div.custom-live-search").show();
                    $("button.save-all").prop("disabled",true);
                    $(this).parents('.contact-form').find("input[name=registerOwnerId]").val(0);
                  }else{
                    $("#userEmailText").val("");
                    $(this).parent().parent().parent().find("div.field-wrap .user-data").prop("readonly",false);
                    $(this).parent().parent().parent().find("div.field-wrap .user-data").val("");
                    $(this).parent().parent().parent().find("div.field-wrap .user-data").next("p").remove();
                    $(this).parent().parent().find("div.custom-live-search").hide();
                    $("button.save-all").prop("disabled",false);
                    $(this).parents('.contact-form').find("input[name=registerOwnerId]").val(0);
                    $(this).parents('.contact-form').find("input.live-search-input").val("");
                  }
                });
                enableAutocomplete($('input.live-search-input'));
                function enableAutocomplete(inputField) {
                  $(inputField).autocomplete({
                    source: function(request, response) {
                      var repeat = "<?php echo $_GET['author_id']; ?>,";
                      $("body").find("input[name=registerOwnerId]").each(function(){
                        if ($(this).val() != 0) {
                          repeat += $(this).val()+",";
                        }
                      })
                      $.getJSON(ajaxurl,{ term:request.term, action:"userLiveSearch", notRepeat:repeat }, 
                        response
                      );
                    },
                      // source: ajaxurl+"?action=userLiveSearch",
                      minLength: 2,
                      response: function( event, ui ) {
                          if (ui.content.length > 0) {
                              $(this).parents('.contact-form').find(".user-data").prop("readonly",false);
                              $(this).parents('.contact-form').find("input[name=primary_email]").prop("readonly",true);
                              $("button.save-all").prop("disabled",false);
                          }else{
                              $(this).parents('.contact-form').find("input.user-data").val("");
                              $(this).parents('.contact-form').find("select[name=primary_country]").val("").trigger('change');
                              $(this).parents('.contact-form').find("p.error-p, p.error-main").remove();
                              $(this).parents('.contact-form').find(".user-data").prop("readonly",true);
                              $("button.save-all").prop("disabled",true);
                              $(this).parents('.contact-form').find("input[name=registerOwnerId]").val(0);
                          }
                      },
                      select: function( event, ui ) {
                          $parent = $(this).parents('.contact-form');
                          $(this).parents('.contact-form').find("input[name=registerOwnerId]").val(ui.item.ID);
                          if (ui.item.userMeta.first_name != "undefined" && ui.item.userMeta.first_name !== null && ui.item.userMeta.first_name != undefined) {
                              var check = ui.item.userMeta.first_name[0];
                              if (check != "undefined" && check !== null && check != undefined ) {
                                  $parent.find("input[name=primary_first_name]").val(check);
                              }
                          }

                          if (ui.item.userMeta.last_name != "undefined" && ui.item.userMeta.last_name !== null && ui.item.userMeta.last_name != undefined) {
                              var check = ui.item.userMeta.last_name[0];
                              if (check != "undefined" && check !== null && check != undefined) {
                                  $parent.find("input[name=primary_last_name]").val(check);
                              }
                          }

                          if (ui.item.userMeta.primary_home_number != "undefined" && ui.item.userMeta.primary_home_number !== null && ui.item.userMeta.primary_home_number != undefined) {
                              var check = ui.item.userMeta.primary_home_number[0];
                              if (check != "undefined" && check !== null && check != undefined) {
                                  $parent.find("input[name=primary_home_number]").val(check);
                              }
                          }

                          if (ui.item.data.user_email != "undefined" && ui.item.data.user_email !== null && ui.item.data.user_email != undefined) {
                              var check = ui.item.data.user_email;
                              if (check != "undefined" && check !== null && check != undefined) {
                                  $parent.find("input[name=primary_email]").val(check);
                              }
                          }

                          if (ui.item.userMeta.primary_country != "undefined" && ui.item.userMeta.primary_country !== null && ui.item.userMeta.primary_country != undefined) {
                              var check = ui.item.userMeta.primary_country[0];
                              if (check != "undefined" && check !== null && check != undefined) {
                                  $(this).parents('.contact-form').find("select[name=primary_country]").val(check).trigger('change');
                              }
                          }

                          $parent = $(this).parents('.contact-form');

                          if (ui.item.userMeta.primary_address_line1 != "undefined" && ui.item.userMeta.primary_address_line1 !== null && ui.item.userMeta.primary_address_line1 != undefined) {
                              var check = ui.item.userMeta.primary_address_line1[0];
                              if (check != "undefined" && check !== null && check != undefined) {
                                  $parent.find("input[name=primary_address_line1]").val(check);
                              }
                          }

                          if (ui.item.userMeta.primary_state != "undefined" && ui.item.userMeta.primary_state !== null && ui.item.userMeta.primary_state != undefined) {
                              var check = ui.item.userMeta.primary_state[0];
                              if (check != "undefined" && check !== null && check != undefined ) {
                                  $parent.find("[name=primary_state]").val(check);
                              }
                          }

                          if (ui.item.userMeta.primary_address_line2 != "undefined" && ui.item.userMeta.primary_address_line2 !== null && ui.item.userMeta.primary_address_line2 != undefined) {
                              var check = ui.item.userMeta.primary_address_line2[0];
                              if (check != "undefined" && check !== null && check != undefined ) {
                                  $parent.find("input[name=primary_address_line2]").val(check);
                              }
                          }

                          if (ui.item.userMeta.primary_city != "undefined" && ui.item.userMeta.primary_city !== null && ui.item.userMeta.primary_city != undefined) {
                              var check = ui.item.userMeta.primary_city[0];
                              if (check != "undefined" && check !== null && check != undefined) {
                                  $parent.find("input[name=primary_city]").val(check);
                              }
                          }

                          if (ui.item.userMeta.primary_postcode != "undefined" && ui.item.userMeta.primary_postcode !== null && ui.item.userMeta.primary_postcode != undefined) {
                              var check = ui.item.userMeta.primary_postcode[0];
                              if (check != "undefined" && check !== null && check != undefined) {
                                  $parent.find("input[name=primary_postcode]").val(check);
                              }
                          }

                          if (ui.item.userMeta.primary_cell_number != "undefined" && ui.item.userMeta.primary_cell_number !== null && ui.item.userMeta.primary_cell_number != undefined) {
                              var check = ui.item.userMeta.primary_cell_number[0];
                              if (check != "undefined" && check !== null && check != undefined) {
                                  $parent.find("[name=primary_cell_number]").val(check);
                              }
                          }
                      }
                  });
                }
              });
            </script>
          <?php }else{ ?>
              <div class="contact-form">
                <div class="field-wrap error">
                  <div class="field-div">
                    <div class="alert alert-danger alert-dismissible message" style="margin-top:18px;">There is something wrong, please try again.</div>
                  </div>
                </div>
              </div>
          <?php }
        }else{
          $createdByUsers = new WP_User_Query( 
            array(
              'role__not_in'  => 'pet_professional',
              'meta_query' => array(
                'relation' => 'AND',
                array(
                  'key'     => 'created_by',
                  'value'   => $userId,
                  'compare' => '='
                )
              )
            ) 
          );
          $usersFound = $createdByUsers->get_results();
          $userFound  = array($userId); 
          if (!empty($usersFound)) {
            foreach ($usersFound as $value) {
                array_push($userFound, $value->ID);
            }
          }
          $args=array(
            'author__in'    => $userFound,
            'post_type' => 'pet_profile',
            'post_status' => 'publish',
            'posts_per_page' => -1,
            'meta_query'=>array(
              'relation' => 'AND',
              array(
                  'key' => 'microchip_id_number',
                  'value'   => '',
                  'compare' => '!='
              ),
            )
          );
          $wp_query = new WP_Query($args); ?>
          <div class="page-heading">
            <h1>Update or Transfer Microchips</h1>
          </div>
          <?php while ( $wp_query->have_posts() ) : $wp_query->the_post(); 
            $mypod = pods( 'pet_profile', get_the_id() ); 
            $subscriptionId  = $mypod->display("smarttag_subscription_id");
            if (!empty($subscriptionId)) {
              $subscriptionName = json_decode(getSubscriptionPlanNameUsingSerialKey($subscriptionId));
              $product_name = $subscriptionName->productName;
            }else{
              $product_name = '';
            }
            ?>
            <div class="bottom-border-box">
              <h3>Registered Pet</h3>
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
                  <br/>
                  <strong>Microchip Serial Number:</strong> <span class="name"><?php echo $mypod->display('microchip_id_number'); ?></span>
                  <br>
                  <strong>ID Tag Plan:</strong> <span><?php echo $product_name; ?></span>
                </div>
                <div class="col-sm-4 mb-elements">
                  <p class="woocommerce"><a href="<?php echo site_url(); ?>/pet-professional/update-or-transfer-microchips/?author_id=<?php echo get_post_field( 'post_author', get_the_id() ); ?>&post_id=<?php echo get_the_id(); ?>" class="replacement-tag button view site-btn-red btn"><strong>Update or Transfer Microchip</strong> <i class="fa fa-caret-right"></i></a></p>
                </div>
              </div>
            </div>
          <?php endwhile; ?>
        <?php } ?>
      </div>
    </div>
  </div>
</div>   
<?php get_footer(); ?>