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
global $product;
$subscription   = wcs_get_subscription($_GET['switch-subscription']);
foreach( $subscription->get_items() as $item_id => $product_subscription ){
  $variationId  = $product_subscription['variation_id'];
}

//Microchip Pet Protection Plan Parent Id 7804
        $handle = new WC_Product_Variable(6908);
        $currentPlan = $variationId;
        $variations1=$handle->get_children();
        
        foreach ($variations1 as $value) {
       $SubPlan[] = $value;
        
      }

 $location = array_search($currentPlan, $SubPlan);
for($i=0 ; $i< $location ; $i++){
  unset($SubPlan[$i]);
}

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
?>

<script type="text/javascript">
    jQuery(document).ready(function($) {
      
       $(window).load(function() {
         $(":contains('Sign Up Now')").closest('button').attr("id","AutoCart");
         //$(":contains('Sign Up Now')").removeClass("disabled");
        }); 
    $('#alert-sub').hide();
    $('#skip-plan').hide();
        var referrer =  document.referrer;
         if(jQuery.trim(referrer) === '<?php echo get_site_url(); ?>/product/aluminum-id-tag/' ||
            jQuery.trim(referrer) === '<?php echo get_site_url(); ?>/product/brass-id-tag/'){
          $('#skip-plan').show();  
         }
    
     $("body").on('click','.SubPln',function(e){
      

            //alert = function() {}; 
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
                $(":contains('Sign Up Now')").closest('button').removeClass("disabled wc-variation-selection-needed");       
                $("#AutoCart").click();
                }

        }); 

         
      
 });
</script>
<div class="woo-complex-product woo-protection-product">
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
    <?php 
                $current_user_id = get_current_user_id();
                $usrheader = "Welcome ".get_user_meta( $current_user_id, 'first_name', true )."! Congratulation On Your Registration!";
                 $args =array('author'      => $current_user_id,
                              'post_type'  => 'pet_profile');
                    $petdata = get_posts( $args );
                    
                 ?>

        <div class="subs-my-acc-slider-wrap">
            <ul class="subs-my-acc-slider" id="subs-my-acc-slider">
                 <?php 
                       foreach ($petdata as $post) {?>
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
                            <p><strong>IDTag Serial Number: </strong><?php  echo get_post_meta($post->ID,'smarttag_id_number',true); ?></p>
                            <p class="subs-my-acc-desc">Upgrade your pet protection today! Please take a moment to review each SmartTag Protection Plan below. If you would like more protection and benefits in addition to your current plan, you can do so by upgrading your plan today. Just add the upgraded plan to your shopping cart and complete the checkout process, it will be instantly upgraded!</p>
                        </div>
                    </div>
                </li>
                <?php }
              
                 ?>
              
            </ul>
        </div>

     
    <div class="pp-tabs-wrap">
            <div class="woocommerce-message" role="alert" id="alert-sub" ><h4 id="existing_info"></h4><a href="/cart/">View Cart</a></div>
           <h2>Upgrade Protection Plan</h2>
     <div class="pp-tabs-content">
        <div class="pp-table-wrap">
          <form method="post" id="SunPln">
          <table class="pp-table">
            <thead>
              <tr>
                <th class="pp-upgrade">
                  <div>Upgrade your Free Silver plan to GOLD or Platinum to maximize your pet's protection.</div>
                </th>
                <th class="pp-silver">
                  <h2>SILVER</h2>
                  <?PHP if(!empty($SubPlan[0])){
                  if($SubPlan[0] == $currentPlan){ ?>
                  <div class="pp-membership-plan">
                  <div class="pp-plan-name"><h3>Current Protection Plan</h3></div>
                  <div class="pp-plan-name">Microchip 1 Year Plan</div>
                  <div class="pp-adc-btn">&nbsp;</div>
              </div>
                <?php  }else{?>
                  <div class="pp-membership-plan">
                    <div class="pp-plan-name">Microchip 1 Year Plan</div>
                    <div class="pp-plan-price">
                      <h3>$6.95</h3>
                      <span>per year</span>
                    </div>
                    <div class="pp-adc-btn">
                      <a href="javascript:void(0)" id="Sgol1" filed="productid" productid="<?php echo $SubPlan[0];?>" class="site-btn SubPln" protection="gold" plan="1-year" >Add to Cart <i class="fa fa-shopping-cart"></i></a>
                    </div>
                  </div>
             <?PHP }}if(!empty($SubPlan[1])){
                if($SubPlan[1] == $currentPlan){ ?>
                <div class="pp-membership-plan">
                <div class="pp-plan-name"><h3>Current Protection Plan</h3></div>
                <div class="pp-plan-name">Microchip Lifetime Plan</div>
                <div class="pp-adc-btn">&nbsp;</div>
            </div>
              <?php  }else{?>
                   <div class="pp-membership-plan">
                    <div class="pp-plan-name">Microchip Lifetime Plan</div>
                    <div class="pp-plan-price">
                      <h3>$14.95</h3>
                      <span>per year</span>
                    </div>
                    <div class="pp-adc-btn">

                      <a href="javascript:void(0)" id="Sgol2" filed="productid" productid="<?php echo $SubPlan[1];?>" class="site-btn SubPln" protection="gold" plan="lifetime">Add to Cart <i class="fa fa-shopping-cart"></i></a>
                    </div>
                  </div>
                  <?php }}?> 
                </th>
                <th class="pp-gold">
                  <h2>GOLD</h2>
                <?PHP if(!empty($SubPlan[2])){
                  if($SubPlan[2] == $currentPlan){ ?>
                  <div class="pp-membership-plan">
                  <div class="pp-plan-name"><h3>Current Protection Plan</h3></div>
                  <div class="pp-plan-name">Microchip 1 Year Plan</div>
                  <div class="pp-adc-btn">&nbsp;</div>
              </div>
                <?php  }else{?>
                  <div class="pp-membership-plan">
                    <div class="pp-plan-name">Microchip 1 Year Plan</div>
                    <div class="pp-plan-price">
                      <h3>$9.95</h3>
                      <span>per year</span>
                    </div>
                    <div class="pp-adc-btn">
                      <a href="javascript:void(0)" id="Sgol1" filed="productid" productid="<?php echo $SubPlan[2];?>" class="site-btn SubPln" protection="gold" plan="1-year" >Add to Cart <i class="fa fa-shopping-cart"></i></a>
                    </div>
                  </div>
             <?PHP }}if(!empty($SubPlan[3])){
                if($SubPlan[3] == $currentPlan){ ?>
                <div class="pp-membership-plan">
                <div class="pp-plan-name"><h3>Current Protection Plan</h3></div>
                <div class="pp-plan-name">Microchip Lifetime Plan</div>
                <div class="pp-adc-btn">&nbsp;</div>
            </div>
              <?php  }else{?>
                   <div class="pp-membership-plan">
                    <div class="pp-plan-name">Microchip Lifetime Plan</div>
                    <div class="pp-plan-price">
                      <h3>$29.95</h3>
                      <span>per year</span>
                    </div>
                    <div class="pp-adc-btn">

                      <a href="javascript:void(0)" id="Sgol2" filed="productid" productid="<?php echo $SubPlan[3];?>" class="site-btn SubPln" protection="gold" plan="lifetime">Add to Cart <i class="fa fa-shopping-cart"></i></a>
                    </div>
                  </div>
                  <?php }}?>  
                </th>
                <th class="pp-platinum">
                  <h2>PLATINUM</h2>
                   <?PHP if(!empty($SubPlan[4])){
                    if($SubPlan[4] == $currentPlan){ ?>
                    <div class="pp-membership-plan">
                    <div class="pp-plan-name"><h3>Current Protection Plan</h3></div>
                    <div class="pp-plan-name">Microchip 1 Year Plan</div>
                    <div class="pp-adc-btn">&nbsp;</div>
                </div>
                  <?php  }else{?> 
                  <div class="pp-membership-plan">
                    <div class="pp-plan-name">Microchip 1 Year Plan</div>
                    <div class="pp-plan-price">
                      <h3>$19.95</h3>
                      <span>per year</span>
                    </div>
                    <div class="pp-adc-btn">
                      <a href="javascript:void(0)" id="spla1" filed="productid" productid="<?php echo $SubPlan[4];?>" class="site-btn SubPln" protection="platinum" plan="1-year">Add to Cart <i class="fa fa-shopping-cart"></i></a>
                    </div>
                  </div>
                   <?PHP }}if(!empty($SubPlan[5])){
                    if($SubPlan[5] == $currentPlan){ ?>
                    <div class="pp-membership-plan">
                    <div class="pp-plan-name"><h3>Current Protection Plan</h3></div>
                    <div class="pp-plan-name">Microchip Lifetime Plan</div>
                    <div class="pp-adc-btn">&nbsp;</div>
                </div>
                  <?php  }else{?>
                  <div class="pp-membership-plan">
                    <div class="pp-plan-name">Microchip Lifetime Plan</div>
                    <div class="pp-plan-price">
                      <h3>$49.95</h3>
                      <span>per year</span>
                    </div>
                    <div class="pp-adc-btn">
                      <a href="javascript:void(0)" id="spla2" filed="productid" productid="<?php echo $SubPlan[5];?>" class="site-btn SubPln" protection="platinum" plan="lifetime">Add to Cart <i class="fa fa-shopping-cart"></i></a>
                    </div>
                  </div>
                  <?php }}?>  
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
        do_action( 'woocommerce_after_single_product_summary' );
    ?>

    <meta itemprop="url" content="<?php the_permalink(); ?>" />

</div><!-- #product-<?php the_ID(); ?> -->

<?php do_action( 'woocommerce_after_single_product' ); ?>

