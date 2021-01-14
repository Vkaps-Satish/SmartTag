<?php
/**
 * The template for displaying product content in the single-product.php template
 *
 * Override this template by copying it to yourtheme/woocommerce/content-single-product.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
?>

<?php
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
         $('#alert-sub').hide();
     $('#skip-plan').hide();
        var referrer =  document.referrer;
         if(jQuery.trim(referrer) === '<?php echo get_site_url(); ?>/product/aluminum-id-tag/' ||
            jQuery.trim(referrer) === '<?php echo get_site_url(); ?>/product/brass-id-tag/'){
          $('#skip-plan').show();  
         }
      $('#SunPln #Sgol1').on('click',function(e){
             e.preventDefault();
            var sfd1 = new FormData();

             $.each($('#SunPln #Sgol1'), function() {
             	//  console.log($(this).attr('filed')+'ddddddd'+$(this).attr('productid'));
             	sfd1.append($(this).attr('filed'),$(this).attr('productid'));
            });
             sfd1.append('action', 'AddSubscriptionPlan');
                $.ajax({
                    type: 'POST',
                    url: ajaxurl,
                    data: sfd1,
                    contentType: false,
                    processData: false,
                   success: function(response) {
                     var message = response;
                     $('#alert-sub').show();
                          if(message == 1){$('#existing_info').html('sorry');}
                                else{$('#existing_info').html('Subscription Product Added into Cart');}
                                 }
                    });
           
      });

      $('#SunPln #Sgol2').on('click',function(e){
             e.preventDefault();
           var sfd2 = new FormData();
             $.each($('#SunPln #Sgol2'), function() {
             	 //console.log($(this).attr('filed')+'ddddddd'+$(this).attr('productid'));
             	sfd2.append($(this).attr('filed'),$(this).attr('productid'));
            });
            sfd2.append('action', 'AddSubscriptionPlan');
                $.ajax({
                    type: 'POST',
                    url: ajaxurl,
                    data: sfd2,
                    contentType: false,
                    processData: false,
                   success: function(response) {
                     var message = response;
                     $('#alert-sub').show();
                          if(message == 1){$('#existing_info').html('sorry');}
                                else{$('#existing_info').html('Subscription Product Added into Cart');}
                                 }
              });
      });
     
      $('#SunPln #spla1').on('click',function(e){
             e.preventDefault();
             var sfd3 = new FormData();
             
             $.each($('#SunPln #spla1'), function() {
             	 //console.log($(this).attr('filed') +'ddddddd'+ $(this).attr('productid'));
             	sfd3.append($(this).attr('filed'),$(this).attr('productid'));
            });
             sfd3.append('action', 'AddSubscriptionPlan');
                $.ajax({
                    type: 'POST',
                    url: ajaxurl,
                    data: sfd3,
                    contentType: false,
                    processData: false,
                   success: function(response) {
                     var message = response;
                     $('#alert-sub').show();
                          if(message == 1){$('#existing_info').html('sorry');}
                                else{$('#existing_info').html('Subscription Product Added into Cart');}
                                 }
                });
      });

      $('#SunPln #spla2').on('click',function(e){
             e.preventDefault();
            var sfd4 = new FormData();

             $.each($('#SunPln #spla2'), function() {
             	// console.log($(this).attr('filed') +'ddddddd'+$(this).attr('productid'));
             	sfd4.append($(this).attr('filed'), $(this).attr('productid'));
            });
             sfd4.append('action', 'AddSubscriptionPlan');
                $.ajax({
                    type: 'POST',
                    url: ajaxurl,
                    data: sfd4,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                     var message = response;
                     $('#alert-sub').show();
                          if(message == 1){$('#existing_info').html('sorry');}
                                else{$('#existing_info').html('Subscription Product Added into Cart');}
                                 }
 
                });
    });

     //smartTag protection Plans for silver plans
          $('#SmartPln #Stsil1').on('click',function(e){
             e.preventDefault();
            var sfd5 = new FormData();

             $.each($('#SmartPln #Stsil1'), function() {
               //console.log($(this).attr('filed')+'ddddddd'+$(this).attr('productid'));
             	sfd5.append($(this).attr('filed'),$(this).attr('productid'));
            });
             sfd5.append('action', 'AddSubscriptionPlan');
                $.ajax({
                    type: 'POST',
                    url: ajaxurl,
                    data: sfd5,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        $('#alert-sub').show();
                    var message = response;
                          if(message == 1){$('#existing_info').html('sorry');}
                                else{$('#existing_info').html('Subscription Product Added into Cart');}
                                 }
 
                });
        });
            $('#SmartPln #Stsil2').on('click',function(e){
             e.preventDefault();
            var sfd6 = new FormData();

             $.each($('#SmartPln #Stsil2'), function() {
               //console.log($(this).attr('filed')+'ddddddd'+$(this).attr('productid'));
             	sfd6.append($(this).attr('filed'),$(this).attr('productid'));
            });
             sfd6.append('action', 'AddSubscriptionPlan');
                $.ajax({
                    type: 'POST',
                    url: ajaxurl,
                    data: sfd6,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        $('#alert-sub').show();
                  var message = response;
                          if(message == 1){$('#existing_info').html('sorry');}
                                else{$('#existing_info').html('Subscription Product Added into Cart');}
                                 }
 
                });
    }); 

    $('#SmartPln #Stsil3').on('click',function(e){
             e.preventDefault();
            var sfd7 = new FormData();

             $.each($('#SmartPln #Stsil3'), function() {
               //console.log($(this).attr('filed')+'ddddddd'+$(this).attr('productid'));
             	sfd7.append($(this).attr('filed'),$(this).attr('productid'));
            });
             sfd7.append('action', 'AddSubscriptionPlan');
                $.ajax({
                    type: 'POST',
                    url: ajaxurl,
                    data: sfd7,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                     var message = response;
                     $('#alert-sub').show();
                          if(message == 1){$('#existing_info').html('sorry');}
                                else{$('#existing_info').html('Subscription Product Added into Cart');}
                                 }
 
                });
    });       
       //smartTag protection Plans for gold plans
          $('#SmartPln #Stgol1').on('click',function(e){
             e.preventDefault();
            var sfd8 = new FormData();

             $.each($('#SmartPln #Stgol1'), function() {
               //console.log($(this).attr('filed')+'ddddddd'+$(this).attr('productid'));
             	sfd8.append($(this).attr('filed'),$(this).attr('productid'));
            });
             sfd8.append('action', 'AddSubscriptionPlan');
                $.ajax({
                    type: 'POST',
                    url: ajaxurl,
                    data: sfd8,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                 var message = response;
                     $('#alert-sub').show();
                          if(message == 1){$('#existing_info').html('sorry');}
                                else{$('#existing_info').html('Subscription Product Added into Cart');}
                                 }
                });
        });
            $('#SmartPln #Stgol2').on('click',function(e){
             e.preventDefault();
            var sfd9 = new FormData();

             $.each($('#SmartPln #Stgol2'), function() {
               //console.log($(this).attr('filed')+'ddddddd'+$(this).attr('productid'));
             	sfd9.append($(this).attr('filed'),$(this).attr('productid'));
            });
             sfd9.append('action', 'AddSubscriptionPlan');
                $.ajax({
                    type: 'POST',
                    url: ajaxurl,
                    data: sfd9,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                   var message = response;
                     $('#alert-sub').show();
                          if(message == 1){$('#existing_info').html('sorry');}
                                else{$('#existing_info').html('Subscription Product Added into Cart');}
                                 }
                });
    }); 

    $('#SmartPln #Stgol3').on('click',function(e){
             e.preventDefault();
            var sfd10 = new FormData();

             $.each($('#SmartPln #Stgol3'), function() {
              // console.log($(this).attr('filed')+'ddddddd'+$(this).attr('productid'));
             	sfd10.append($(this).attr('filed'),$(this).attr('productid'));
            });
             sfd10.append('action', 'AddSubscriptionPlan');
                $.ajax({
                    type: 'POST',
                    url: ajaxurl,
                    data: sfd10,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                 var message = response;
                      $('#alert-sub').show();
                          if(message == 1){$('#existing_info').html('sorry');}
                                else{$('#existing_info').html('Subscription Product Added into Cart');}
                                 }
                });
    });   

     //smartTag protection Plans for platinum plans
          $('#SmartPln #stple1').on('click',function(e){
             e.preventDefault();
            var sfd11 = new FormData();

             $.each($('#SmartPln #stple1'), function() {
               // console.log($(this).attr('filed')+'ddddddd'+$(this).attr('productid'));
             	sfd11.append($(this).attr('filed'),$(this).attr('productid'));
            });
             sfd11.append('action', 'AddSubscriptionPlan');
                $.ajax({
                    type: 'POST',
                    url: ajaxurl,
                    data: sfd11,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                   var message = response;
                      $('#alert-sub').show();
                          if(message == 1){$('#existing_info').html('sorry');}
                                else{$('#existing_info').html('Subscription Product Added into Cart');}
                                 }
                });
        });
            $('#SmartPln #stple2').on('click',function(e){
             e.preventDefault();
            var sfd12 = new FormData();

             $.each($('#SmartPln #stple2'), function() {
               // console.log($(this).attr('filed')+'ddddddd'+$(this).attr('productid'));
             	sfd12.append($(this).attr('filed'),$(this).attr('productid'));
            });
             sfd12.append('action', 'AddSubscriptionPlan');
                $.ajax({
                    type: 'POST',
                    url: ajaxurl,
                    data: sfd12,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                 var message = response;
                     $('#alert-sub').show();
                          if(message == 1){$('#existing_info').html('sorry');}
                                else{$('#existing_info').html('Subscription Product Added into Cart');}
                                 }
                });
    }); 

    $('#SmartPln #stple3').on('click',function(e){
             e.preventDefault();
            var sfd13 = new FormData();

             $.each($('#SmartPln #stple3'), function() {
               // console.log($(this).attr('filed')+'ddddddd'+$(this).attr('productid'));
             	sfd13.append($(this).attr('filed'),$(this).attr('productid'));
            });
             sfd13.append('action', 'AddSubscriptionPlan');
                $.ajax({
                    type: 'POST',
                    url: ajaxurl,
                    data: sfd13,
                    contentType: false,
                    processData: false,
                     success: function(response) {
                     var message = response;
                      $('#alert-sub').show();
                          if(message == 1){$('#existing_info').html('sorry');}
                                else{$('#existing_info').html('Subscription Product Added into Cart');}
                                 }
                });
    });  

        $("#Sgol1").click(function(){
            alert("klfjha");
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

     
		<div class="pp-tabs-wrap">
            <div class="woocommerce-message" role="alert" id="alert-sub" ><h4 id="existing_info"></h4><a href="/cart/">View Cart</a></div>
			<div class="pp-tabs-nav">
				<div class="pp-tabs-nav-inner pp-tab-option-1 active">
					SmartTag Microchip Protection Plans
				</div>
				<div class="pp-tabs-nav-inner pp-tab-option-2">
					SmartTag ID Tag Protection Plans
				</div>
			</div>
			<div class="pp-tabs-content pp-tab-content-1" style="display: block;">
				<div class="pp-icon-wrap">
					<div class="pp-icon"></div>
					<h4>Pet Protection Plans</h4>
				</div>
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
									<h3>SmartTag Microchips include FREE Silver Lifetime Plan.</h3>
								</th>
								<th class="pp-gold">
									<h2>GOLD</h2>
									<div class="pp-membership-plan">
										<div class="pp-plan-name">Microchip 1 Year Plan</div>
										<div class="pp-plan-price">
											<h3>$9.95</h3>
											<span>per year</span>
										</div>
										<div class="pp-adc-btn">
											<a href="javascript:void(0)" id="Sgol1" filed="productid" productid="7805" class="site-btn">Add to Cart <i class="fa fa-shopping-cart"></i></a>
										</div>
									</div>
                                    <div class="pp-membership-plan">
										<div class="pp-plan-name">Microchip Lifetime Plan</div>
										<div class="pp-plan-price">
											<h3>$29.95</h3>
											<span>per year</span>
										</div>
										<div class="pp-adc-btn">
											<a href="javascript:void(0)" id="Sgol2" filed="productid" productid="7807" class="site-btn">Add to Cart <i class="fa fa-shopping-cart"></i></a>
										</div>
									</div>
								</th>
								<th class="pp-platinum">
									<h2>PLATINUM</h2>
									<div class="pp-membership-plan">
										<div class="pp-plan-name">Microchip 1 Year Plan</div>
										<div class="pp-plan-price">
											<h3>$19.95</h3>
											<span>per year</span>
										</div>
										<div class="pp-adc-btn">
											<a href="javascript:void(0)" id="spla1" filed="productid" productid="7808" class="site-btn">Add to Cart <i class="fa fa-shopping-cart"></i></a>
										</div>
									</div>
                                   <div class="pp-membership-plan">
										<div class="pp-plan-name">Microchip Lifetime Plan</div>
										<div class="pp-plan-price">
											<h3>$49.95</h3>
											<span>per year</span>
										</div>
										<div class="pp-adc-btn">
											<a href="javascript:void(0)" id="spla2" filed="productid" productid="7810" class="site-btn">Add to Cart <i class="fa fa-shopping-cart"></i></a>
										</div>
									</div>
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
			<div class="pp-tabs-content pp-tab-content-2">
				<div class="pp-tabs-content steps-pp-tabs-content" style="display: block;">
								<div class="pp-icon-wrap">
									<div class="pp-icon"></div>
									<h3>Pet Protection Plans</h3>
								</div>
								<div class="pp-table-wrap">
								  <form method="post" id="SmartPln">
									<table class="pp-table">
										<thead>
											<tr>
												<th class="pp-upgrade">
													<div>Upgrade to lifetime plan and save up to 80%</div>
												</th>
												<th class="pp-silver">
													<h2>SILVER</h2>
													<div class="pp-membership-plan">
														<div class="pp-plan-name">Id Tag 1 Year Plan</div>
														<div class="pp-plan-price">
															<h3>$6.95</h3>
															<span>per year</span>
														</div>
														<div class="pp-adc-btn">
															<a href="javascript:void(0)" id="Stsil1" filed="productid" productid="6858" class="site-btn">Add to Cart <i class="fa fa-shopping-cart"></i></a>
														</div>
													</div>
													<div class="pp-membership-plan">
														<div class="pp-plan-name">Id Tag 5 Year Plan</div>
														<div class="pp-plan-price">
															<h3>$24.95</h3>
															<span>per year</span>
														</div>
														<div class="pp-adc-btn">
															<a href="javascript:void(0)" id="Stsil2" filed="productid" productid="6856" class="site-btn">Add to Cart <i class="fa fa-shopping-cart"></i></a>
														</div>
													</div>
													<div class="pp-membership-plan">
														<div class="pp-plan-name">Id Tag Lifetime Plan</div>
														<div class="pp-plan-price">
															<h3>$39.95</h3>
															<span>per year</span>
														</div>
														<div class="pp-adc-btn">
															<a href="javascript:void(0)" id="Stsil3" filed="productid" productid="6857" class="site-btn">Add to Cart <i class="fa fa-shopping-cart"></i></a>
														</div>
													</div>
												</th>
												<th class="pp-gold">
													<h2>GOLD</h2>
													<div class="pp-membership-plan">
														<div class="pp-plan-name">Id Tag 1 Year Plan</div>
														<div class="pp-plan-price">
															<h3>$14.95</h3>
															<span>per year</span>
														</div>
														<div class="pp-adc-btn">
															<a href="javascript:void(0)" id="Stgol1" filed="productid" productid="6852" class="site-btn">Add to Cart <i class="fa fa-shopping-cart"></i></a>
														</div>
													</div>
													<div class="pp-membership-plan">
														<div class="pp-plan-name">Id Tag 5 Year Plan</div>
														<div class="pp-plan-price">
															<h3>$49.95</h3>
															<span>per year</span>
														</div>
														<div class="pp-adc-btn">
															<a href="javascript:void(0)" id="Stgol2" filed="productid" productid="6850" class="site-btn">Add to Cart <i class="fa fa-shopping-cart"></i></a>
														</div>
													</div>
													<div class="pp-membership-plan">
														<div class="pp-plan-name">Id Tag Lifetime Plan</div>
														<div class="pp-plan-price">
															<h3>$69.95</h3>
															<span>per year</span>
														</div>
														<div class="pp-adc-btn">
															<a href="javascript:void(0)" id="Stgol3" filed="productid" productid="6851" class="site-btn">Add to Cart <i class="fa fa-shopping-cart"></i></a>
														</div>
													</div>
												</th>
												<th class="pp-platinum">
													<h2>PLATINUM</h2>
													<div class="pp-membership-plan">
														<div class="pp-plan-name">Id Tag 1 Year Plan</div>
														<div class="pp-plan-price">
															<h3>$24.95</h3>
															<span>per year</span>
														</div>
														<div class="pp-adc-btn">
															<a href="javascript:void(0)" id="stple1" filed="productid" productid="6855" class="site-btn">Add to Cart <i class="fa fa-shopping-cart"></i></a>
														</div>
													</div>
													<div class="pp-membership-plan">
														<div class="pp-plan-name">Id Tag 5 Year Plan</div>
														<div class="pp-plan-price">
															<h3>$79.95</h3>
															<span>per year</span>
														</div>
														<div class="pp-adc-btn">
															<a href="javascript:void(0)" id="stple2" filed="productid" productid="6853" class="site-btn">Add to Cart <i class="fa fa-shopping-cart"></i></a>
														</div>
													</div>
													<div class="pp-membership-plan">
														<div class="pp-plan-name">Id Tag Lifetime Plan</div>
														<div class="pp-plan-price">
															<h3>$129.95</h3>
															<span>per year</span>
														</div>
														<div class="pp-adc-btn">
															<a href="javascript:void(0)" id="stple3" filed="productid" productid="6854" class="site-btn" plan="Id Tag Lifetime Plan">Add to Cart <i class="fa fa-shopping-cart"></i></a>
														</div>
													</div>
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
								</div>
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

