<?php
/**
 * The template for displaying product content in the single-product.php template
 *
 * Override this template by copying it to yourtheme/woocommerce/content-single-product.php
 *
 * @author    WooThemes
 * @package   WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
?>

<?php

// $variation_id = '75189';
// echo $price = "$".get_post_meta($variation_id, '_price', true);

// die;
global $product;
global $micoPrntId,$SmtProPlan;


if(isset($_GET['switch-subscription'])){
  $title = "Upgrade Protection Plan";
  $viewPet = true;
  $tabs = false;

  $subscription   = wcs_get_subscription($_GET['switch-subscription']);
  foreach( $subscription->get_items() as $item_id => $product_subscription ){
    $variationId  = $product_subscription['variation_id'];
  }

    //Microchip Pet Protection Plan Parent Id 7804
  $handle = new WC_Product_Variable($micoPrntId);
  $currentPlan = $variationId;
  $variations1 = $handle->get_children();

  foreach ($variations1 as $value) {
   $SubPlan[] = $value;
 }

 $location = array_search($currentPlan, $SubPlan);
 for($i=0 ; $i< $location ; $i++){
  unset($SubPlan[$i]);
}

$current_user_id = get_current_user_id();
$usrheader = "Welcome ".get_user_meta( $current_user_id, 'first_name', true )."! Congratulation On Your Registration!";
$args =array('author'      => $current_user_id,
  'post_type'  => 'pet_profile');
$petdata = get_posts( $args );
      /**
       * woocommerce_before_single_product hook
       *
       * @hooked wc_print_notices - 10
       */
      do_action( 'woocommerce_before_single_product' );

      if ( post_password_required() ) {
        echo get_the_password_form();
        return;
      }

      $options = get_nectar_theme_options(); 
      $product_style = (!empty($options['product_style'])) ? $options['product_style'] : 'classic';
    }else{
      $viewPet = false;
      $title = "Pet Protection Plans";
      $currentPlan = "";
      $tabs = true;

      $handle = new WC_Product_Variable($micoPrntId);
      $currentPlan = "";
      $variations1=$handle->get_children();
      
      foreach ($variations1 as $value) {
       $SubPlan[] = $value;
     }

   }

   ?>

   <script type="text/javascript">
    jQuery(document).ready(function($) {

     $(window).load(function() {
       $(":contains('Sign Up Now')").closest('button').attr("id","AutoCart");
     }); 
     $('#alert-sub').hide();
     $('#skip-plan').hide();
     var referrer =  document.referrer;
     if(jQuery.trim(referrer) === '<?= site_url("/product/aluminum-id-tag/"); ?>' ||
      jQuery.trim(referrer) === '<?= site_url("/product/brass-id-tag/"); ?>'){
      $('#skip-plan').show();  
      $(".pp-tabs-nav").hide();
      $(".pp-tabs-content.pp-tab-content-1").hide();
      $(".pp-tabs-content.pp-tab-content-2").show();
    }
    
    $("body").on('click','.SubPln',function(e){

      var id = $(this).attr("id");
      var $protection = $('#'+id).attr('protection');
      var $plan = $('#'+id).attr('plan');

      console.log($protection);
      console.log($plan);

      $('#pa_protection').find('option').each( function() {
        var $this = $(this);
        if ($this.attr('value') == $protection) {
         $this.attr('selected','selected');
         return false;
       }
     });

      $('#pa_plan').find('option').each( function() {
       var $this = $(this);
       if ($this.attr('value') == $plan) {
         $this.attr('selected','selected');
         return false;
       }
     });

      if(jQuery('#pa_protection').val() !="" && jQuery('#pa_plan').val() !="" ){
        $("body").find("#AutoCart").removeClass("disabled wc-variation-selection-needed");  
        $("body").find(".red-class").removeClass("disabled wc-variation-selection-needed");  

        $("#AutoCart").click();
      }

    }); 



  });
</script>
<style type="text/css">
  .postid-<?= $micoPrntId;?> .page-heading, #product-<?= $micoPrntId;?> {
    display: none;
  }
</style>
<?php  foreach ($petdata as $post) { ?>
  <style type="text/css">
    .postid-<?= $post->ID;?> .page-heading, #product-<?= $post->ID;?> {
      display: none;
    }
  </style>
<?php } ?>

<div class="woo-complex-product woo-protection-product">
  <?php
      /**
       * woocommerce_before_single_product_summary hook
       *
       * @hooked woocommerce_show_product_sale_flash - 10
       * @hooked woocommerce_show_product_images - 20
       */
      do_action( 'woocommerce_before_single_product_summary' );
      ?>
      <div class="subs-my-acc-slider-wrap">
        <?php if($viewPet && !empty($petdata)){ ?>
          <ul class="subs-my-acc-slider" id="subs-my-acc-slider">
           <?php  foreach ($petdata as $post) { ?>
            <li>
              <div class="row">
                <div class="col-sm-3 rmb-15">
                  <div class="lost-found-img">
                    <?php if (has_post_thumbnail( $post->ID ) ): ?>
                      <?php $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'single-post-thumbnail' );
                      ?>
                      <a href="<?php echo $post_link; ?>" class="more-info-link"><img src="<?php echo $image[0];?>" /></a>
                    <?php endif; ?>
                  </div>
                </div>
                <div class="col-sm-9">
                  <p><strong>Pet Name: </strong><?php echo $post->post_title; ?></p>
                  <p><strong>IDTag Serial Number: </strong><?php  echo "$".get_post_meta($post->ID,'smarttag_id_number',true); ?></p>
                  <p class="subs-my-acc-desc">Upgrade your pet protection today! Please take a moment to review each SmartTag Protection Plan below. If you would like more protection and benefits in addition to your current plan, you can do so by upgrading your plan today. Just add the upgraded plan to your shopping cart and complete the checkout process, it will be instantly upgraded!</p>
                </div>
              </div>
            </li>
          <?php } ?>
        </ul>
      <?php } ?>
    </div>
    <h2><?= $title;?></h2>
    <?php if($tabs){ ?>
      <div class="pp-tabs-nav">
        <div class="pp-tabs-nav-inner pp-tab-option-1 active ">
          <a href="<?= get_permalink($micoPrntId); ?>" >
            SmartTag Microchip Protection Plans
          </a>
        </div>
        <div class="pp-tabs-nav-inner pp-tab-option-2 ">
          <a href="<?= get_permalink($SmtProPlan); ?>" >
            SmartTag ID Tag Protection Plans
          </a>
        </div>
      </div>
    <?php } ?>
    <div class="pp-tabs-content">
      <!-- <div class="pp-icon-wrap">
          <div class="pp-icon"></div>
          <h4>Pet Protection Plans</h4>
        </div> -->
        <div class="pp-table-wrap">
          <form method="post" id="SunPln">
            <table class="pp-table">
              <thead>
                <tr class="pt-remove">
                  <th>
                    <p>Hover " <i class="fa fa-plus"></i> " to show more information about each benefit.</p>
                  </th>
                  <th class="pp-silver">
                    <h2>SILVER</h2>
                  </th>
                  <th class="pp-gold">
                    <h2>GOLD</h2>
                  </th>
                  <th class="pp-platinum">
                    <h2>PLATINUM</h2>
                  </th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td class="pp-benefits pp-benefits1">
                    <span class="pp-benefit-icon"></span>
                    <i class="fa fa-plus pet-pro-sign"></i>
                    <div class="pet-pro-plus-content">
                      Lost pet E-Alert Services (change name of benefit)- Lost pet E-Alerts can be sent in any location in all of North America. It will be sent to all the animal shelter, rescue group and veterinarians, breeders, and animal search activists that have requested to be on our lost pet alert lists for their area.
                    </div>
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
                  <!-- <i class="fa fa-plus pet-pro-sign"></i>
                  <div class="pet-pro-plus-content">
                  </div> -->
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
                  <!-- <i class="fa fa-plus pet-pro-sign"></i>
                  <div class="pet-pro-plus-content">
                  </div> -->
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
                  <!-- <i class="fa fa-plus pet-pro-sign"></i>
                  <div class="pet-pro-plus-content">
                  </div> -->
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
                  <!-- <i class="fa fa-plus pet-pro-sign"></i>
                  <div class="pet-pro-plus-content">
                  </div> -->
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
                  <i class="fa fa-plus pet-pro-sign"></i>
                  <div class="pet-pro-plus-content">
                    Your pet protection plan includes 30 days of pet insurance provided by our pet insurance Partner. You must abide by all requirements to activate and must call to them to initiate pet insurance coverage. No credit card required, its fast and easy. Activate it today, please check your emails for details!
                  </div>
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
                  <i class="fa fa-plus pet-pro-sign"></i>
                  <div class="pet-pro-plus-content">
                    Please go to IDtag.com and log into your SmartTag account to print lost pet posters (please have a photo of your pet downloaded in your account)
                  </div>
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
                  <i class="fa fa-plus pet-pro-sign"></i>
                  <div class="pet-pro-plus-content">
                    SmartTag is partnered with AAHA and part of the national USA microchip database. Any SmartTag microchip or other brand microchip that is registered with SmartTag is searched for in AAHA Microchip Lookup Tool will show our contact information to get the lost or found pet home and reunited with their pet parents as quickly as possible.
                  </div>
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
                  <i class="fa fa-plus pet-pro-sign"></i>
                  <div class="pet-pro-plus-content">
                    If your pet is ever lost, SmartTag lost pet recovery agents will call all of the Animal Shelter and Rescue Groups in a 25-50 mile radius (depending on region) of your pets last know location to see if your pet is at any of the locations and to make them aware of your lost pet. This added service is only for Platinum pet protection plan holders. If you don’t have it, Sign up today!
                  </div>
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
                  <i class="fa fa-plus pet-pro-sign"></i>
                  <div class="pet-pro-plus-content">
                    If your pet has ever ingested anytime it should not, you have unlimited access to the best Poison Hotline for free! Normally each call to the Pet Poison Helpline $59 per call! This a very valuable benefit we provide all Platinum pet protection plan holders. Sign up today, this makes it all worth it alone!
                  </div>
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
                  <i class="fa fa-plus pet-pro-sign"></i>
                  <div class="pet-pro-plus-content">
                    Free replacement ID tags are for Platinum pet protection plan holders only. Sign up today!
                  </div>
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
                  <i class="fa fa-plus pet-pro-sign"></i>
                  <div class="pet-pro-plus-content">
                    SmartTag will pay a lost pet reward to the pet finder, a maximum of $100, to any finder that gets you your pet home within our 6-hour guarantee (from the time the pet is reported lost). Finder must request the reward and fill out appropriate required SmartTag paperwork to receive the reward.
                  </div>
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
                  <i class="fa fa-plus pet-pro-sign"></i>
                  <div class="pet-pro-plus-content">
                    This is an amazing new SmartTag feature; you can set alerts for anything related to your pet and get them texted and emailed to you! Ever have to take your dog to the groomer or vet, book a pet sitter, or need to be reminded monthly to give your pet their heart protection or flea and tick medications? Well this new service allows you to set up email and/or text alerts to be sent to you to remind you to do anything for your pet. This really great service is provided to all Platinum pet protection plan holders. Sign up today!
                  </div>
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
            <tfoot>
              <tr>
                <th class="pp-upgrade">
                  <div>Upgrade your Free Silver plan to GOLD or Platinum to maximize your pet's protection.</div>
                </th>
                <th class="pp-silver">
                  <h2>SILVER</h2>
                  <h3>SmartTag Microchips include FREE Silver Lifetime Plan.</h3>
                </th>
                <th class="pp-gold">
                  <h2>GOLD</h2>
                  <?php if(!empty($SubPlan[1])){
                    if($SubPlan[1] == $currentPlan){ ?>
                      <div class="pp-membership-plan">
                        <div class="pp-plan-name"><h3>Current Protection Plan</h3></div>
                        <div class="pp-plan-name">Id Tag Lifetime Plan</div>
                        <div class="pp-adc-btn">&nbsp;</div>
                      </div>
                    <?php  }else{?>
                      <div class="pp-membership-plan">
                        <div class="pp-plan-name">Microchip 1 Year Plan</div>
                        <div class="pp-plan-price">
                          <h3><?= "$".get_post_meta($SubPlan[1], '_price', true). "<p>per year</p>"; ?></h3>
                          
                        </div>
                        <div class="pp-adc-btn">
                          <a href="javascript:void(0)" id="Sgol1" filed="productid" productid="<?php echo $SubPlan[1];?>" class="site-btn SubPln" protection="gold" plan="1-year" >Add to Cart <i class="fa fa-shopping-cart"></i></a>
                        </div>
                      </div>
                    <?php }
                  }
                  if(!empty($SubPlan[2])){
                    if($SubPlan[2] == $currentPlan){ ?>
                      <div class="pp-membership-plan">
                        <div class="pp-plan-name"><h3>Current Protection Plan</h3></div>
                        <div class="pp-plan-name">Id Tag Lifetime Plan</div>
                        <div class="pp-adc-btn">&nbsp;</div>
                      </div>
                    <?php  }else{?>
                      <div class="pp-membership-plan">
                        <div class="pp-plan-name">Microchip Lifetime Plan</div>
                        <div class="pp-plan-price">
                          <h3><?= "$".get_post_meta($SubPlan[2], '_price', true); ?></h3>
                          
                        </div>
                        <div class="pp-adc-btn">

                          <a href="javascript:void(0)" id="Sgol2" filed="productid" productid="<?php echo $SubPlan[2];?>" class="site-btn SubPln" protection="gold" plan="lifetime">Add to Cart <i class="fa fa-shopping-cart"></i></a>
                        </div>
                      </div>
                    <?php }
                  }?>  
                </th>
                <th class="pp-platinum">
                  <h2>PLATINUM</h2>
                  <?php if(!empty($SubPlan[3])){
                    if($SubPlan[3] == $currentPlan){ ?>
                      <div class="pp-membership-plan">
                        <div class="pp-plan-name"><h3>Current Protection Plan</h3></div>
                        <div class="pp-plan-name">Id Tag Lifetime Plan</div>
                        <div class="pp-adc-btn">&nbsp;</div>
                      </div>
                    <?php  }else{?> 
                      <div class="pp-membership-plan">
                        <div class="pp-plan-name">Microchip 1 Year Plan</div>
                        <div class="pp-plan-price">
                          <h3><?= "$".get_post_meta($SubPlan[3], '_price', true). "<p>per year</p>" ; ?></h3>
                        </div>
                        <div class="pp-adc-btn">
                          <a href="javascript:void(0)" id="spla1" filed="productid" productid="<?php echo $SubPlan[3];?>" class="site-btn SubPln" protection="platinum" plan="1-year">Add to Cart <i class="fa fa-shopping-cart"></i></a>
                        </div>
                      </div>
                    <?php }
                  }if(!empty($SubPlan[4])){
                    if($SubPlan[4] == $currentPlan){ ?>
                      <div class="pp-membership-plan">
                        <div class="pp-plan-name"><h3>Current Protection Plan</h3></div>
                        <div class="pp-plan-name">Id Tag Lifetime Plan</div>
                        <div class="pp-adc-btn">&nbsp;</div>
                      </div>
                    <?php  }else{?>
                      <div class="pp-membership-plan">
                        <div class="pp-plan-name">Microchip Lifetime Plan</div>
                        <div class="pp-plan-price">
                          <h3><?= "$".get_post_meta($SubPlan[4], '_price', true); ?></h3>
                        </div>
                        <div class="pp-adc-btn">
                          <a href="javascript:void(0)" id="spla2" filed="productid" productid="<?php echo $SubPlan[4];?>" class="site-btn SubPln" protection="platinum" plan="lifetime">Add to Cart <i class="fa fa-shopping-cart"></i></a>
                        </div>
                      </div>
                    <?php }
                  }?>  
                </th>
              </tr>
            </foot>
          </table>
        </form> 
        <a href="/cart/" class="btn btn-default btn-next skip1 site-btn" id="skip-plan">Skip Protection Plan <i class="fa fa-caret-right"></i></a>
      </div>

    </div>
  </div>

  <!-- <div class="summary entry-summary"> -->

    <?php
        /**
         * woocommerce_single_product_summary hook
         *
         * @hooked woocommerce_template_single_title - 5
         * @hooked woocommerce_template_single_rating - 10
         * @hooked woocommerce_template_single_price - 10
         * @hooked woocommerce_template_single_excerpt - 20
         * @hooked woocommerce_template_single_add_to_cart - 30
         * @hooked woocommerce_template_single_meta - 40
         * @hooked woocommerce_template_single_sharing - 50
         */
        //do_action( 'woocommerce_single_product_summary' );
        ?>

      </div><!-- .summary -->

      <?php
      /**
       * woocommerce_after_single_product_summary hook
       *
       * @hooked woocommerce_output_product_data_tabs - 10
       * @hooked woocommerce_upsell_display - 15
       * @hooked woocommerce_output_related_products - 20
       */
      //do_action( 'woocommerce_after_single_product_summary' );
      ?>

      <!-- <meta itemprop="url" content="<?php the_permalink(); ?>" /> -->

    </div><!-- #product-<?php the_ID(); ?> -->
  </div>

  <?php //do_action( 'woocommerce_after_single_product' ); ?>
  <?php 
  $options = get_nectar_theme_options(); 
  $product_style = (!empty($options['product_style'])) ? $options['product_style'] : 'classic';
  global $product;
  $terms = get_the_terms( $product->ID, 'product_cat' );
  foreach ($terms as $term) {
    $product_cat = $term->name;
  }
  ?>
  <div class="page-heading">
    <h1><?php echo $product_cat; ?></h1>
  </div>
  <div itemscope data-project-style="<?php echo $product_style; ?>" itemtype="<?php echo woocommerce_get_product_schema(); ?>" data-tab-pos="<?php echo (!empty($options['product_tab_position'])) ? $options['product_tab_position'] : 'default'; ?>" id="product-<?php the_ID(); ?>" <?php post_class(); ?>>

    <?php
        /**
         * woocommerce_before_single_product_summary hook
         *
         * @hooked woocommerce_show_product_sale_flash - 10
         * @hooked woocommerce_show_product_images - 20
         */
        do_action( 'woocommerce_before_single_product_summary' );
        ?>

        <div class="summary entry-summary">

          <?php
            /**
             * woocommerce_single_product_summary hook
             *
             * @hooked woocommerce_template_single_title - 5
             * @hooked woocommerce_template_single_rating - 10
             * @hooked woocommerce_template_single_price - 10
             * @hooked woocommerce_template_single_excerpt - 20
             * @hooked woocommerce_template_single_add_to_cart - 30
             * @hooked woocommerce_template_single_meta - 40
             * @hooked woocommerce_template_single_sharing - 50
             */
            do_action( 'woocommerce_single_product_summary' );
            ?>

          </div><!-- .summary -->

          <?php
        /**
         * woocommerce_after_single_product_summary hook
         *
         * @hooked woocommerce_output_product_data_tabs - 10
         * @hooked woocommerce_upsell_display - 15
         * @hooked woocommerce_output_related_products - 20
         */
        // do_action( 'woocommerce_after_single_product_summary' );
        ?>

        <meta itemprop="url" content="<?php the_permalink(); ?>" />

      </div><!-- #product-<?php the_ID(); ?> -->

      <?php //do_action( 'woocommerce_after_single_product' ); ?>

