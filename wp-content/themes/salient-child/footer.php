<div id="dialog-2" style="display: none; cursor: default;">
    <p>Your pet profile linked with subscription plan successfully.</p>
    <a href="#" id="close"><i class="fa fa-close"></i></a>
</div>
<script type="text/javascript">
	//google captcha callback function
	var verifyCallback = function (response) {
		isCaptchaValid = true;
		$("#hiddenRecaptcha-error").hide();
	};

	jQuery(document).ready(function(){

	$("form[name='remove_pet']").validate({
		    
	    submitHandler: function(form) {
	    	if (confirm("Are you sure?")) {
	    		$(".loader-wrap").fadeIn();
				form.submit();
		    }
		    return false;
	    }

	  });

	
	$.validator.addMethod("customEmail", function(value, element) {
     	return this.optional(element) || /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/i.test(value);
    }, "Please enter valid email address!");
	
		jQuery('dl.variation .variation-FrontImage p img').each(function(){
			var img = jQuery(this).attr('src');
			jQuery(this).parent().parent().parent().parent().parent().find('td.product-thumbnail > .row').append('<div class="col-sm-6 rmb-15 cart-front-img text-center"><h4>Front</h4><img src="'+img+'"/></div>');			
			
		});
		jQuery('dl.variation .variation-BackImage p img').each(function(){
			var img = jQuery(this).attr('src');
			jQuery(this).parent().parent().parent().parent().parent().find('td.product-thumbnail > .row').append('<div class="col-sm-6 cart-back-img text-center"><h4>Back</h4><img src="'+img+'"/></div>');
			
			
		});
		jQuery(".emptycart").click(function(){
			var r = confirm("Are you sure you would like to remove all items from the cart?");
			if (r == true) {
			    return true;
			} else {
			    return false;
			}
		});
	});

	
	function validateEmail(sEmail) {
	    var filter = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
	    if (filter.test(sEmail)) {
	        return true;
	    }
	    else {
	        return false;
	    }
	}
	jQuery(document).ready(function(){

		jQuery.validator.addMethod("time", function (value, element) {
	        return this.optional(element) || /^(([0-1]?[0-9])|([2][0-3])):([0-5]?[0-9])(:([0-5]?[0-9]))?$/i.test(value);
	    }, "Please enter a valid time.");

		<?php if (isset($_GET['login']) && $_GET['login'] == 1) { ?>
			jQuery("li.login-click a").click();
		<?php } ?>
		
		jQuery(".cart_item").each(function(){
			jQuery(this).children().children("dl.variation").children("dd.variation-FrontLine1, dt.variation-FrontLine1").wrapAll("<div class='variation-frontlines1'></div>");
			jQuery(this).children().children("dl.variation").children("dd.variation-FrontLine2, dt.variation-FrontLine2").wrapAll("<div class='variation-frontlines2'></div>");
			jQuery(this).children().children("dl.variation").children("dd.variation-FrontLine3, dt.variation-FrontLine3").wrapAll("<div class='variation-frontlines3'></div>");
			jQuery(this).children().children("dl.variation").children("dd.variation-FrontLine4, dt.variation-FrontLine4").wrapAll("<div class='variation-frontlines4'></div>");

			jQuery(this).children().children("dl.variation").children(".variation-frontlines1, .variation-frontlines2, .variation-frontlines3, .variation-frontlines4").wrapAll("<div class='variation-frontlines-wrap'></div>");

			jQuery(this).children().children("dl.variation").children("dd.variation-BackLine1, dt.variation-BackLine1").wrapAll("<div class='variation-backlines1'></div>");
			jQuery(this).children().children("dl.variation").children("dd.variation-BackLine2, dt.variation-BackLine2").wrapAll("<div class='variation-backlines2'></div>");
			jQuery(this).children().children("dl.variation").children("dd.variation-BackLine3, dt.variation-BackLine3").wrapAll("<div class='variation-backlines3'></div>");
			jQuery(this).children().children("dl.variation").children("dd.variation-BackLine4, dt.variation-BackLine4").wrapAll("<div class='variation-backlines4'></div>");

			jQuery(this).children().children("dl.variation").children(".variation-backlines1, .variation-backlines2, .variation-backlines3, .variation-backlines4").wrapAll("<div class='variation-backlines-wrap'></div>");

			var variation_frontlines_wrap = jQuery(this).children().children("dl.variation").children(".variation-frontlines-wrap").clone();

			jQuery(this).children(".product-thumbnail").children().children(".cart-front-img").prepend(variation_frontlines_wrap);

			var variation_backlines_wrap = jQuery(this).children().children("dl.variation").children(".variation-backlines-wrap").clone();

			jQuery(this).children(".product-thumbnail").children().children(".cart-back-img").prepend(variation_backlines_wrap);



			jQuery(this).find(".variation-backlines-wrap").each(function(){
				
				var cartline1 = jQuery(this).find(".variation-BackLine1 .engraving_back_line_1").text();
				console.log("Gaurav",cartline1.length);
			    if (cartline1.length > 5 && cartline1.length < 9 ) {
		            jQuery(this).find('.variation-BackLine1 .engraving_back_line_1').css('font-size', '42px');
		        } else if (cartline1.length > 8 && cartline1.length < 13) {
		            jQuery(this).find('.variation-BackLine1 .engraving_back_line_1').css('font-size', '30px');
		        } else if (cartline1.length > 12 && cartline1.length < 17) {
		            jQuery(this).find('.variation-BackLine1 .engraving_back_line_1').css('font-size', '22px');
		        } else if (cartline1.length > 16 && cartline1.length < 21) {
		            jQuery(this).find('.variation-BackLine1 .engraving_back_line_1').css('font-size', '18px');
		        } else {
		        	jQuery(this).find('.variation-BackLine1 .engraving_back_line_1').css('font-size', '42px');
		        }

		        var cartline2 = jQuery(this).find(".variation-BackLine2 .engraving_back_line_2").text();
			    if (cartline2.length > 5 && cartline2.length < 9 ) {
		            jQuery(this).find('.variation-BackLine2 .engraving_back_line_2').css('font-size', '42px');
		        } else if (cartline2.length > 8 && cartline2.length < 13) {
		            jQuery(this).find('.variation-BackLine2 .engraving_back_line_2').css('font-size', '30px');
		        } else if (cartline2.length > 12 && cartline2.length < 17) {
		            jQuery(this).find('.variation-BackLine2 .engraving_back_line_2').css('font-size', '22px');
		        } else if (cartline2.length > 16 && cartline2.length < 21) {
		            jQuery(this).find('.variation-BackLine2 .engraving_back_line_2').css('font-size', '18px');
		        } else {
		        	jQuery(this).find('.variation-BackLine2 .engraving_back_line_2').css('font-size', '42px');
		        }

		        var cartline3 = jQuery(this).find(".variation-BackLine3 .engraving_back_line_3").text();
			    if (cartline3.length > 5 && cartline3.length < 9 ) {
			    	jQuery(this).find('.variation-BackLine1 .engraving_back_line_1').css('font-size', '28px');
			    	jQuery(this).find('.variation-BackLine2 .engraving_back_line_2').css('font-size', '28px');
		            jQuery(this).find('.variation-BackLine3 .engraving_back_line_3').css('font-size', '28px');
		        } else if (cartline3.length > 8 && cartline3.length < 13) {
		            jQuery(this).find('.variation-BackLine1 .engraving_back_line_1').css('font-size', '22px');
			    	jQuery(this).find('.variation-BackLine2 .engraving_back_line_2').css('font-size', '22px');
		            jQuery(this).find('.variation-BackLine3 .engraving_back_line_3').css('font-size', '22px');
		        } else if (cartline3.length > 12 && cartline3.length < 17) {
		            jQuery(this).find('.variation-BackLine1 .engraving_back_line_1').css('font-size', '18px');
			    	jQuery(this).find('.variation-BackLine2 .engraving_back_line_2').css('font-size', '18px');
		            jQuery(this).find('.variation-BackLine3 .engraving_back_line_3').css('font-size', '18px');
		        } else if (cartline3.length > 16 && cartline3.length < 21) {
		            jQuery(this).find('.variation-BackLine1 .engraving_back_line_1').css('font-size', '18px');
			    	jQuery(this).find('.variation-BackLine2 .engraving_back_line_2').css('font-size', '18px');
		            jQuery(this).find('.variation-BackLine3 .engraving_back_line_3').css('font-size', '18px');
		        } else {
		        	jQuery(this).find('.variation-BackLine3 .engraving_back_line_3').css('font-size', '28px');
		        }

		        var cartline4 = jQuery(this).find(".variation-BackLine4 .engraving_back_line_4").text();
			    if (cartline4.length > 5 && cartline4.length < 9 ) {
			    	jQuery(this).find('.variation-BackLine1 .engraving_back_line_1').css('font-size', '28px');
			    	jQuery(this).find('.variation-BackLine2 .engraving_back_line_2').css('font-size', '28px');
		            jQuery(this).find('.variation-BackLine3 .engraving_back_line_3').css('font-size', '28px');
		            jQuery(this).find('.variation-BackLine4 .engraving_back_line_4').css('font-size', '28px');
		        } else if (cartline4.length > 8 && cartline4.length < 13) {
		            jQuery(this).find('.variation-BackLine1 .engraving_back_line_1').css('font-size', '20px');
			    	jQuery(this).find('.variation-BackLine2 .engraving_back_line_2').css('font-size', '20px');
		            jQuery(this).find('.variation-BackLine3 .engraving_back_line_3').css('font-size', '20px');
		            jQuery(this).find('.variation-BackLine4 .engraving_back_line_4').css('font-size', '20px');
		        } else if (cartline4.length > 12 && cartline4.length < 17) {
		            jQuery(this).find('.variation-BackLine1 .engraving_back_line_1').css('font-size', '18px');
			    	jQuery(this).find('.variation-BackLine2 .engraving_back_line_2').css('font-size', '18px');
		            jQuery(this).find('.variation-BackLine3 .engraving_back_line_3').css('font-size', '18px');
		            jQuery(this).find('.variation-BackLine4 .engraving_back_line_4').css('font-size', '18px');
		        } else if (cartline4.length > 16 && cartline4.length < 21) {
		            jQuery(this).find('.variation-BackLine1 .engraving_back_line_1').css('font-size', '18px');
			    	jQuery(this).find('.variation-BackLine2 .engraving_back_line_2').css('font-size', '18px');
		            jQuery(this).find('.variation-BackLine3 .engraving_back_line_3').css('font-size', '18px');
		            jQuery(this).find('.variation-BackLine4 .engraving_back_line_4').css('font-size', '18px');
		        } else {
		        	jQuery(this).find('.variation-BackLine4 .engraving_back_line_4').css('font-size', '24px');
		        }


			});



			jQuery(this).find(".variation-frontlines-wrap").each(function(){
				
				var cartfrontline1 = jQuery(this).find(".variation-FrontLine1 .engraving_front_line_1").text();
				console.log("Gaurav",cartfrontline1.length);
			    if (cartfrontline1.length > 5 && cartfrontline1.length < 9 ) {
		            jQuery(this).find('.variation-FrontLine1 .engraving_front_line_1').css('font-size', '42px');
		        } else if (cartfrontline1.length > 8 && cartfrontline1.length < 13) {
		            jQuery(this).find('.variation-FrontLine1 .engraving_front_line_1').css('font-size', '30px');
		        } else if (cartfrontline1.length > 12 && cartfrontline1.length < 17) {
		            jQuery(this).find('.variation-FrontLine1 .engraving_front_line_1').css('font-size', '22px');
		        } else if (cartfrontline1.length > 16 && cartfrontline1.length < 21) {
		            jQuery(this).find('.variation-FrontLine1 .engraving_front_line_1').css('font-size', '18px');
		        } else {
		        	jQuery(this).find('.variation-FrontLine1 .engraving_front_line_1').css('font-size', '42px');
		        }

		        var cartfrontline2 = jQuery(this).find(".variation-FrontLine2 .engraving_front_line_2").text();
			    if (cartfrontline2.length > 5 && cartfrontline2.length < 9 ) {
		            jQuery(this).find('.variation-FrontLine2 .engraving_front_line_2').css('font-size', '42px');
		        } else if (cartfrontline2.length > 8 && cartfrontline2.length < 13) {
		            jQuery(this).find('.variation-FrontLine2 .engraving_front_line_2').css('font-size', '30px');
		        } else if (cartfrontline2.length > 12 && cartfrontline2.length < 17) {
		            jQuery(this).find('.variation-FrontLine2 .engraving_front_line_2').css('font-size', '22px');
		        } else if (cartfrontline2.length > 16 && cartfrontline2.length < 21) {
		            jQuery(this).find('.variation-FrontLine2 .engraving_front_line_2').css('font-size', '18px');
		        } else {
		        	jQuery(this).find('.variation-FrontLine2 .engraving_front_line_2').css('font-size', '42px');
		        }

		        var cartfrontline3 = jQuery(this).find(".variation-FrontLine3 .engraving_front_line_3").text();
			    if (cartfrontline3.length > 5 && cartfrontline3.length < 9 ) {
			    	jQuery(this).find('.variation-FrontLine1 .engraving_front_line_1').css('font-size', '28px');
			    	jQuery(this).find('.variation-FrontLine2 .engraving_front_line_2').css('font-size', '28px');
		            jQuery(this).find('.variation-FrontLine3 .engraving_front_line_3').css('font-size', '28px');
		        } else if (cartfrontline3.length > 8 && cartfrontline3.length < 13) {
		            jQuery(this).find('.variation-FrontLine1 .engraving_front_line_1').css('font-size', '22px');
			    	jQuery(this).find('.variation-FrontLine2 .engraving_front_line_2').css('font-size', '22px');
		            jQuery(this).find('.variation-FrontLine3 .engraving_front_line_3').css('font-size', '22px');
		        } else if (cartfrontline3.length > 12 && cartfrontline3.length < 17) {
		            jQuery(this).find('.variation-FrontLine1 .engraving_front_line_1').css('font-size', '18px');
			    	jQuery(this).find('.variation-FrontLine2 .engraving_front_line_2').css('font-size', '18px');
		            jQuery(this).find('.variation-FrontLine3 .engraving_front_line_3').css('font-size', '18px');
		        } else if (cartfrontline3.length > 16 && cartfrontline3.length < 21) {
		            jQuery(this).find('.variation-FrontLine1 .engraving_front_line_1').css('font-size', '18px');
			    	jQuery(this).find('.variation-FrontLine2 .engraving_front_line_2').css('font-size', '18px');
		            jQuery(this).find('.variation-FrontLine3 .engraving_front_line_3').css('font-size', '18px');
		        } else {
		        	jQuery(this).find('.variation-FrontLine3 .engraving_front_line_3').css('font-size', '28px');
		        }

		        var cartfrontline4 = jQuery(this).find(".variation-FrontLine4 .engraving_front_line_4").text();
			    if (cartfrontline4.length > 5 && cartfrontline4.length < 9 ) {
			    	jQuery(this).find('.variation-FrontLine1 .engraving_front_line_1').css('font-size', '28px');
			    	jQuery(this).find('.variation-FrontLine2 .engraving_front_line_2').css('font-size', '28px');
		            jQuery(this).find('.variation-FrontLine3 .engraving_front_line_3').css('font-size', '28px');
		            jQuery(this).find('.variation-FrontLine4 .engraving_front_line_4').css('font-size', '28px');
		        } else if (cartfrontline4.length > 8 && cartfrontline4.length < 13) {
		            jQuery(this).find('.variation-FrontLine1 .engraving_front_line_1').css('font-size', '20px');
			    	jQuery(this).find('.variation-FrontLine2 .engraving_front_line_2').css('font-size', '20px');
		            jQuery(this).find('.variation-FrontLine3 .engraving_front_line_3').css('font-size', '20px');
		            jQuery(this).find('.variation-FrontLine4 .engraving_front_line_4').css('font-size', '20px');
		        } else if (cartfrontline4.length > 12 && cartfrontline4.length < 17) {
		            jQuery(this).find('.variation-FrontLine1 .engraving_front_line_1').css('font-size', '18px');
			    	jQuery(this).find('.variation-FrontLine2 .engraving_front_line_2').css('font-size', '18px');
		            jQuery(this).find('.variation-FrontLine3 .engraving_front_line_3').css('font-size', '18px');
		            jQuery(this).find('.variation-FrontLine4 .engraving_front_line_4').css('font-size', '18px');
		        } else if (cartfrontline4.length > 16 && cartfrontline4.length < 21) {
		            jQuery(this).find('.variation-FrontLine1 .engraving_front_line_1').css('font-size', '18px');
			    	jQuery(this).find('.variation-FrontLine2 .engraving_front_line_2').css('font-size', '18px');
		            jQuery(this).find('.variation-FrontLine3 .engraving_front_line_3').css('font-size', '18px');
		            jQuery(this).find('.variation-FrontLine4 .engraving_front_line_4').css('font-size', '18px');
		        } else {
		        	jQuery(this).find('.variation-FrontLine4 .engraving_front_line_4').css('font-size', '24px');
		        }


			});
			

		});

		jQuery("table.shop_table tr td .coupon").insertBefore(".cart_totals");
		jQuery(".ma-banner-img").prependTo("body.woocommerce-account .woocommerce-MyAccount-content");
		jQuery(".pp-tab-option-1").click(function(){
			jQuery(this).addClass("active");
			jQuery(this).next(".pp-tab-option-2").removeClass("active");
			jQuery(this).parent(".pp-tabs-nav").next(".pp-tab-content-1").fadeIn();
			jQuery(this).parent(".pp-tabs-nav").next(".pp-tab-content-1").next(".pp-tab-content-2").fadeOut();
		});

		jQuery(document).ready(function(){
			jQuery('.report-pet-as-lost').on('click',function(){
	            jQuery(this).parent().parent('.custom-form').attr("action","<?php echo get_site_url(); ?>/my-account/report-pet-lost");
	            jQuery(this).parent().parent('form.custom-form').submit();
	        });
	        jQuery('.report-pet-as-found').on('click',function(){
	            jQuery(this).parent().parent('.custom-form').attr("action","<?php echo get_site_url(); ?>/my-account/report-pet-found-list");
	            jQuery(this).parent().parent('form.custom-form').submit();
	        });
	        jQuery('.show-post').on('click',function(){
	            jQuery(this).parent().parent().parent().find('.custom-form').attr("action","<?php echo get_site_url(); ?>/my-account/show-profile");
	            jQuery(this).parent().parent().parent().find('form.custom-form').submit();
	        });
	        jQuery('.custom-replacement-tag-btn').on('click',function(){
	            jQuery(this).parent().parent().parent().find('.custom-form').attr("action","<?php echo get_site_url(); ?>/my-account/free-replacement-tag");
	            jQuery(this).parent().parent().parent().find('form.custom-form').submit();
	        });
	    });
		jQuery(".woocommerce .woo-complex-product .single-product-summary h1.product_title.entry-title, .woocommerce.single-product .woo-complex-product #single-meta, .woocommerce .woo-complex-product div.product p.price").wrapAll("<div class='cp-title-price'></div>");
		jQuery(".woocommerce .woo-complex-product div.product p.price").prepend("<span>Total Price: </span>")
		jQuery(".woocommerce-page #page-header-wrap").prependTo(".woo-content");
		jQuery(".woocommerce .woo-complex-product div.product form.cart .variations tbody > tr .swatch-anchor").each(function(){
			var var_title = jQuery(this).attr("title");
			jQuery(this).append("<span class='select-option-title-check'><span class='select-option-check'></span><span class='select-option-title'>"+var_title+"</span></span>");
		});
		if(jQuery('#frontend').is(':visible') && jQuery('#backend').is(':visible')) {
			jQuery(".engraving-fields-wrap").addClass("two-cols");
		} else {
			jQuery(".engraving-fields-wrap").addClass("one-col");
		}
		jQuery("#woo-content .woo-complex-product button.single_add_to_cart_button.button").html("Submit Order &nbsp;<i class='fa fa-caret-right'><i>");
		jQuery(".nav-toggle").click(function(){
			jQuery(this).toggleClass("active");
			jQuery(".nav-inner").slideToggle();
		});
		jQuery("#woo-content ul.products li.product .product-wrap .price").prepend("<span>Price: </span>");
		jQuery(".faq-main-row h3.vc_custom_heading").each(function(){
			jQuery(this).append("<span class='faq-ques-caret'></span>");
		});
		jQuery("body").find(".faq-main-row h3.vc_custom_heading").click(function(){
			jQuery(this).toggleClass("active");
			jQuery(this).next().slideToggle();
		});
		jQuery(".faq-ques-row h4").each(function(){
			jQuery(this).append("<span class='faq-ques-caret-2'></span>");
		});
		jQuery("body").find(".faq-ques-row h4").click(function(){
			jQuery(this).toggleClass("active");
			jQuery(this).next().slideToggle();
		});
		jQuery(".woo-content").addClass("showing");
		jQuery(".pet-pro-sign").hover(function(){
			jQuery(this).next(".pet-pro-plus-content").slideToggle();
			jQuery(this).toggleClass("fa-plus");
			jQuery(this).toggleClass("fa-minus");
		});
		jQuery(".contact-form .field-div").each(function(){
			if ( jQuery(this).children("label").text().length == 0 ) {
				jQuery(this).children("label").addClass("empty-label");
			}
		});
		
		$('textarea.add-info').keyup(function () {
			var maxchars = 250;
		    var tlength = $(this).val().length;
		    $(this).val($(this).val().substring(0, maxchars));
		    var tlength = $(this).val().length;
		    remain = maxchars - parseInt(tlength);
		    $(this).parent().find('.field-notice').text("Remaining character "+remain)
		});
		jQuery(".see-big-poster").click(function(){
			var error = 0;
			$('.contact-form .error').remove();
			$.each($('.contact-form input[type="text"]'), function() {
				if ($(this)[0].hasAttribute("required")) {
			        if (!$.trim($(this).val())) {
			            $(this).parent().append('<label class="error">This field is required.</label>');
			            error = 1;
			        }
			    }        
			});
			$.each($('.contact-form input[type="number"]'), function() {
				if ($(this)[0].hasAttribute("required")) {
			        if (!$.trim($(this).val())) {
			            $(this).parent().append('<label class="error">This field is required.</label>');
			            error = 1;
			        }
			    }        
			});
			$.each($('.contact-form textarea'), function() {
				if ($(this)[0].hasAttribute("required")) {
			        if (!$.trim($(this).val())) {
			            $(this).parent().append('<label class="error">This field is required.</label>');
			            error = 1;
			        }
			    }        
			});
			if (error) {
				return;
			}
			jQuery(".small-poster-row").hide();
			jQuery(".big-poster-row").show();
		});
		jQuery(".edit-small-poster").click(function(){
			jQuery(".small-poster-row").show();
			jQuery(".big-poster-row").hide();
		});
		jQuery("body").on("click", ".acc-plus-minus .acc-blue-head .fa", function(){
			jQuery(this).toggleClass("fa-plus");
			jQuery(this).toggleClass("fa-minus");
			jQuery(this).parent().next().slideToggle();
		});
	});

	jQuery("#gform_6 li.gfield:nth-child(3), #gform_6 li.gfield:nth-child(4), #gform_6 li.gfield:nth-child(5), #gform_6 li.gfield:nth-child(6)").wrapAll('<div class="acc-grey-box"><div class="acc-grey-content"></div></div>');
	jQuery('<div class="acc-grey-head">Pet You Found</div>').prependTo("#gform_6 .acc-grey-box");

	jQuery(".quantity.buttons_added").parent().addClass("qty-wrap");
</script>

<?php 

$options = get_nectar_theme_options(); 
global $post;
$theme_skin = ( !empty($options['theme-skin']) ) ? $options['theme-skin'] : 'original';
$cta_link = ( !empty($options['cta-btn-link']) ) ? $options['cta-btn-link'] : '#';
$using_footer_widget_area = (!empty($options['enable-main-footer-area']) && $options['enable-main-footer-area'] == 1) ? 'true' : 'false';
$disable_footer_copyright = (!empty($options['disable-copyright-footer-area']) && $options['disable-copyright-footer-area'] == 1) ? 'true' : 'false';
$footer_reveal = (!empty($options['footer-reveal'])) ? $options['footer-reveal'] : 'false'; 
$footer_full_width = (!empty($options['footer-full-width'])) ? $options['footer-full-width'] : 'false'; 
$midnight_non_reveal = ($footer_reveal != 'false') ? null : 'data-midnight="light"';

$footer_bg_image_overlay = (!empty($options['footer-background-image-overlay'])) ? $options['footer-background-image-overlay'] : '0.8'; 
$footer_bg_image = (!empty($options['footer-background-image']) && !empty($options['footer-background-image']['url'])) ? nectar_options_img($options['footer-background-image']) : false;
$usingFooterBgImg = 'false';
$footer_bg_image_markup = '';

if($footer_bg_image && !empty($footer_bg_image)) {
	$usingFooterBgImg = 'true';
	$footer_bg_image_markup = 'style="background-image:url('.$footer_bg_image.');"';
}

$exclude_pages = (!empty($options['exclude_cta_pages'])) ? $options['exclude_cta_pages'] : array(); 
$footerColumns = (!empty($options['footer_columns'])) ? $options['footer_columns'] : '4'; 

?>

<div id="footer-outer" <?php echo $midnight_non_reveal; ?> data-cols="<?php echo $footerColumns; ?>" data-disable-copyright="<?php echo $disable_footer_copyright; ?>" data-using-bg-img="<?php echo $usingFooterBgImg; ?>" data-bg-img-overlay="<?php echo $footer_bg_image_overlay; ?>" data-full-width="<?php echo $footer_full_width; ?>" data-using-widget-area="<?php echo $using_footer_widget_area; ?>" <?php echo $footer_bg_image_markup;?>>

	<?php if( $using_footer_widget_area == 'true') { 

		
	?>
		
	<div id="footer-widgets" data-cols="<?php echo $footerColumns; ?>">
		
		<div class="container">
			
			<div class="row">
				
				<?php 
				
				if($footerColumns == '1'){
					$footerColumnClass = 'span_12';
				} else if($footerColumns == '2'){
					$footerColumnClass = 'span_6';
				} else if($footerColumns == '3'){
					$footerColumnClass = 'span_4';
				} else {
					$footerColumnClass = 'span_3';
				}
				?>
				
				<div class="col span_6">
				      <!-- Footer widget area 1 -->
		              <?php if ( function_exists('dynamic_sidebar') && dynamic_sidebar('Footer Area 1') ) : else : ?>	
		              	  <div class="widget">		
						  	 <h4 class="widgettitle">Widget Area 1</h4>
						 	 <p class="no-widget-added"><a href="<?php echo admin_url('widgets.php'); ?>">Click here to assign a widget to this area.</a></p>
				     	  </div>
				     <?php endif; ?>
				</div><!--/span_3-->
				
				<?php if($footerColumns == '2' || $footerColumns == '3' || $footerColumns == '4' || $footerColumns == '5') { ?>

					<div class="col span_3">
						 <!-- Footer widget area 2 -->
			             <?php if ( function_exists('dynamic_sidebar') && dynamic_sidebar('Footer Area 2') ) : else : ?>	
			                  <div class="widget">			
							 	 <h4 class="widgettitle">Widget Area 2</h4>
							 	 <p class="no-widget-added"><a href="<?php echo admin_url('widgets.php'); ?>">Click here to assign a widget to this area.</a></p>
					     	  </div>
					     <?php endif; ?>
					     
					</div><!--/span_3-->

				<?php } ?>

				
				<?php if($footerColumns == '3' || $footerColumns == '4' || $footerColumns == '5') { ?>
					<div class="col span_3">
						 <!-- Footer widget area 3 -->
			              <?php if ( function_exists('dynamic_sidebar') && dynamic_sidebar('Footer Area 3') ) : else : ?>		
			              	  <div class="widget">			
							  	<h4 class="widgettitle">Widget Area 3</h4>
							  	<p class="no-widget-added"><a href="<?php echo admin_url('widgets.php'); ?>">Click here to assign a widget to this area.</a></p>
							  </div>		   
					     <?php endif; ?>
					     
					</div><!--/span_3-->
				<?php } ?>
				
				<?php if($footerColumns == '4' || $footerColumns == '5') { ?>
					<div class="col <?php echo $footerColumnClass;?>" style="display: none;">
						 <!-- Footer widget area 4 -->
			              <?php if ( function_exists('dynamic_sidebar') && dynamic_sidebar('Footer Area 4') ) : else : ?>	
			              	<div class="widget">		
							    <h4>Widget Area 4</h4>
							    <p class="no-widget-added"><a href="<?php echo admin_url('widgets.php'); ?>">Click here to assign a widget to this area.</a></p>
							 </div><!--/widget-->	
					     <?php endif; ?>
					     
					</div><!--/span_3-->
				<?php } ?>
				
			</div><!--/row-->
			
		</div><!--/container-->
	
	</div><!--/footer-widgets-->
	
	<?php } //endif for enable main footer area


	   if( $disable_footer_copyright == 'false') { ?>

	
		<div class="row" id="copyright">
			
			<div class="container">
				
				<?php if($footerColumns != '1'){ ?>
					<div class="col span_12">
						
						<?php if(!empty($options['disable-auto-copyright']) && $options['disable-auto-copyright'] == 1) { ?>
							<p><?php if(!empty($options['footer-copyright-text'])) echo $options['footer-copyright-text']; ?> </p>	
						<?php } else { ?>
							<p>&copy; <?php echo date('Y') . ' ' . get_bloginfo('name'); ?>. <?php if(!empty($options['footer-copyright-text'])) echo $options['footer-copyright-text']; ?> </p>
						<?php } ?>
						
					</div><!--/span_12-->
				<?php } ?>
				
				<!-- <div class="col span_7 col_last">
					<ul id="social">
						<?php  if(!empty($options['use-twitter-icon']) && $options['use-twitter-icon'] == 1) { ?> <li><a target="_blank" href="<?php echo $options['twitter-url']; ?>"><i class="fa fa-twitter"></i> </a></li> <?php } ?>
						<?php  if(!empty($options['use-facebook-icon']) && $options['use-facebook-icon'] == 1) { ?> <li><a target="_blank" href="<?php echo $options['facebook-url']; ?>"><i class="fa fa-facebook"></i> </a></li> <?php } ?>
						<?php  if(!empty($options['use-vimeo-icon']) && $options['use-vimeo-icon'] == 1) { ?> <li><a target="_blank" href="<?php echo $options['vimeo-url']; ?>"> <i class="fa fa-vimeo"></i> </a></li> <?php } ?>
						<?php  if(!empty($options['use-pinterest-icon']) && $options['use-pinterest-icon'] == 1) { ?> <li><a target="_blank" href="<?php echo $options['pinterest-url']; ?>"><i class="fa fa-pinterest"></i> </a></li> <?php } ?>
						<?php  if(!empty($options['use-linkedin-icon']) && $options['use-linkedin-icon'] == 1) { ?> <li><a target="_blank" href="<?php echo $options['linkedin-url']; ?>"><i class="fa fa-linkedin"></i> </a></li> <?php } ?>
						<?php  if(!empty($options['use-youtube-icon']) && $options['use-youtube-icon'] == 1) { ?> <li><a target="_blank" href="<?php echo $options['youtube-url']; ?>"><i class="fa fa-youtube-play"></i> </a></li> <?php } ?>
						<?php  if(!empty($options['use-tumblr-icon']) && $options['use-tumblr-icon'] == 1) { ?> <li><a target="_blank" href="<?php echo $options['tumblr-url']; ?>"><i class="fa fa-tumblr"></i> </a></li> <?php } ?>
						<?php  if(!empty($options['use-dribbble-icon']) && $options['use-dribbble-icon'] == 1) { ?> <li><a target="_blank" href="<?php echo $options['dribbble-url']; ?>"><i class="fa fa-dribbble"></i> </a></li> <?php } ?>
						<?php  if(!empty($options['use-rss-icon']) && $options['use-rss-icon'] == 1) { ?> <li><a target="_blank" href="<?php echo (!empty($options['rss-url'])) ? $options['rss-url'] : get_bloginfo('rss_url'); ?>"><i class="fa fa-rss"></i> </a></li> <?php } ?>
						<?php  if(!empty($options['use-github-icon']) && $options['use-github-icon'] == 1) { ?> <li><a target="_blank" href="<?php echo $options['github-url']; ?>"><i class="fa fa-github-alt"></i></a></li> <?php } ?>
						<?php  if(!empty($options['use-behance-icon']) && $options['use-behance-icon'] == 1) { ?> <li><a target="_blank" href="<?php echo $options['behance-url']; ?>"> <i class="fa fa-behance"></i> </a></li> <?php } ?>
						<?php  if(!empty($options['use-google-plus-icon']) && $options['use-google-plus-icon'] == 1) { ?> <li><a target="_blank" href="<?php echo $options['google-plus-url']; ?>"><i class="fa fa-google-plus"></i> </a></li> <?php } ?>
						<?php  if(!empty($options['use-instagram-icon']) && $options['use-instagram-icon'] == 1) { ?> <li><a target="_blank" href="<?php echo $options['instagram-url']; ?>"><i class="fa fa-instagram"></i></a></li> <?php } ?>
						<?php  if(!empty($options['use-stackexchange-icon']) && $options['use-stackexchange-icon'] == 1) { ?> <li><a target="_blank" href="<?php echo $options['stackexchange-url']; ?>"><i class="fa fa-stackexchange"></i></a></li> <?php } ?>
						<?php  if(!empty($options['use-soundcloud-icon']) && $options['use-soundcloud-icon'] == 1) { ?> <li><a target="_blank" href="<?php echo $options['soundcloud-url']; ?>"><i class="fa fa-soundcloud"></i></a></li> <?php } ?>
						<?php  if(!empty($options['use-flickr-icon']) && $options['use-flickr-icon'] == 1) { ?> <li><a target="_blank" href="<?php echo $options['flickr-url']; ?>"><i class="fa fa-flickr"></i></a></li> <?php } ?>
						<?php  if(!empty($options['use-spotify-icon']) && $options['use-spotify-icon'] == 1) { ?> <li><a target="_blank" href="<?php echo $options['spotify-url']; ?>"><i class="icon-salient-spotify"></i></a></li> <?php } ?>
						<?php  if(!empty($options['use-vk-icon']) && $options['use-vk-icon'] == 1) { ?> <li><a target="_blank" href="<?php echo $options['vk-url']; ?>"><i class="fa fa-vk"></i></a></li> <?php } ?>
						<?php  if(!empty($options['use-vine-icon']) && $options['use-vine-icon'] == 1) { ?> <li><a target="_blank" href="<?php echo $options['vine-url']; ?>"><i class="fa-vine"></i></a></li> <?php } ?>
						<?php  if(!empty($options['use-houzz-icon']) && $options['use-houzz-icon'] == 1) { ?> <li><a target="_blank" href="<?php echo $options['houzz-url']; ?>"><i class="fa-houzz"></i></a></li> <?php } ?>
						<?php  if(!empty($options['use-yelp-icon']) && $options['use-yelp-icon'] == 1) { ?> <li><a target="_blank" href="<?php echo $options['yelp-url']; ?>"><i class="fa-yelp"></i></a></li> <?php } ?>
					</ul>
				</div> --><!--/span_7-->

				<?php if($footerColumns == '1'){ ?>
					<div class="col span_5">
						
						<?php if(!empty($options['disable-auto-copyright']) && $options['disable-auto-copyright'] == 1) { ?>
							<p><?php if(!empty($options['footer-copyright-text'])) echo $options['footer-copyright-text']; ?> </p>	
						<?php } else { ?>
							<p>&copy; <?php echo date('Y') . ' ' . get_bloginfo('name'); ?>. <?php if(!empty($options['footer-copyright-text'])) echo $options['footer-copyright-text']; ?> </p>
						<?php } ?>
						
					</div><!--/span_5-->
				<?php } ?>
			
			</div><!--/container-->
			
		</div><!--/row-->
		
		<?php } //endif for enable main footer copyright ?>

</div><!--/footer-outer-->

<?php 

$mobile_fixed = (!empty($options['header-mobile-fixed'])) ? $options['header-mobile-fixed'] : 'false';
$has_main_menu = (has_nav_menu('top_nav')) ? 'true' : 'false';

$sideWidgetArea = (!empty($options['header-slide-out-widget-area'])) ? $options['header-slide-out-widget-area'] : 'off';
$userSetSideWidgetArea = $sideWidgetArea;
if($has_main_menu == 'true' && $mobile_fixed == '1' || $has_main_menu == 'true' && $theme_skin == 'material') $sideWidgetArea = '1';

$headerFormat = (!empty($options['header_format'])) ? $options['header_format'] : 'default';
$fullWidthHeader = (!empty($options['header-fullwidth']) && $options['header-fullwidth'] == '1') ? true : false;
$sideWidgetClass = (!empty($options['header-slide-out-widget-area-style'])) ? $options['header-slide-out-widget-area-style'] : 'slide-out-from-right';

if($headerFormat == 'centered-menu-under-logo') { 
	if($sideWidgetClass == 'slide-out-from-right-hover' && $userSetSideWidgetArea == '1') {
		$sideWidgetClass = 'slide-out-from-right';
	}
}

$sideWidgetOverlayOpacity = (!empty($options['header-slide-out-widget-area-overlay-opacity'])) ? $options['header-slide-out-widget-area-overlay-opacity'] : 'dark';
$prependTopNavMobile = (!empty($options['header-slide-out-widget-area-top-nav-in-mobile'])) ? $options['header-slide-out-widget-area-top-nav-in-mobile'] : 'false';
if($theme_skin == 'material') $prependTopNavMobile = '1';

$dropdownFunc = (!empty($options['header-slide-out-widget-area-dropdown-behavior'])) ? $options['header-slide-out-widget-area-dropdown-behavior'] : 'default';
if($sideWidgetClass == 'fullscreen' || $sideWidgetClass == 'fullscreen-alt') {
	$dropdownFunc = 'default';
}

if($sideWidgetArea == '1') { 

	if($sideWidgetClass == 'fullscreen') echo '</div><!--blurred-wrap-->'; ?>

	<div id="slide-out-widget-area-bg" class="<?php echo $sideWidgetClass . ' '. $sideWidgetOverlayOpacity; ?>"><?php if($sideWidgetClass == 'fullscreen-alt') echo '<div class="bg-inner"></div>';?></div>
	<div id="slide-out-widget-area" class="<?php echo $sideWidgetClass; ?>" data-dropdown-func="<?php echo $dropdownFunc; ?>" data-back-txt="<?php echo __('Back', NECTAR_THEME_NAME); ?>">

		<?php if($sideWidgetClass == 'fullscreen' || $sideWidgetClass == 'fullscreen-alt' || ($theme_skin == 'material' && $sideWidgetClass == 'slide-out-from-right') || ($theme_skin == 'material' && $sideWidgetClass == 'slide-out-from-right-hover') ) echo '<div class="inner-wrap">'; ?>

		<?php $prepend_mobile_menu = ($prependTopNavMobile == '1' && $has_main_menu == 'true' && $userSetSideWidgetArea != 'off') ? 'true' : 'false'; ?>
		<div class="inner" data-prepend-menu-mobile="<?php echo $prepend_mobile_menu; ?>">

		  <a class="slide_out_area_close" href="#">
		  	<?php 
		  	if($theme_skin != 'material') { 
			  	echo '<span class="icon-salient-x icon-default-style"></span>';
			  } else {
			  	echo '<span class="close-wrap"> <span class="close-line close-line1"></span> <span class="close-line close-line2"></span> </span>';
			  } ?>
		  </a>


		   <?php  

		   if($userSetSideWidgetArea == 'off' || $prependTopNavMobile == '1' && $has_main_menu == 'true') { ?>
			   <div class="off-canvas-menu-container mobile-only">
			  		<ul class="menu">
					   <?php 
					  		////use default top nav menu if ocm is not activated
					  	     ////but is needed for mobile when the mobile fixed nav is on
					   		wp_nav_menu( array('theme_location' => 'top_nav', 'container' => '', 'items_wrap' => '%3$s')); 

					   		if($headerFormat == 'centered-menu' || $headerFormat == 'menu-left-aligned') {
					   			if(has_nav_menu('top_nav_pull_right')) {
									wp_nav_menu( array('walker' => new Nectar_Arrow_Walker_Nav_Menu, 'theme_location' => 'top_nav_pull_right', 'container' => '', 'items_wrap' => '%3$s' ) );  
								}
							}
							
					   ?>
		
					</ul>

					<ul class="menu secondary-header-items"><?php 
						//material secondary nav in menu
						$using_secondary = (!empty($options['header_layout']) && $headerFormat != 'left-header') ? $options['header_layout'] : ' '; 
						if($theme_skin == 'material' && $using_secondary == 'header_with_secondary' && has_nav_menu('secondary_nav')) {
			   	  			 wp_nav_menu( array('walker' => new Nectar_Arrow_Walker_Nav_Menu, 'theme_location' => 'secondary_nav', 'container' => '', 'items_wrap' => '%3$s' ) ); 
						} ?>
					</ul>
				</div>
			<?php } 
		 
		  if(has_nav_menu('off_canvas_nav') && $userSetSideWidgetArea != 'off') { ?>
		 	 <div class="off-canvas-menu-container">
		  		<ul class="menu">
					    <?php wp_nav_menu( array('theme_location' => 'off_canvas_nav', 'container' => '', 'items_wrap' => '%3$s'));	

					  	?>	  
				</ul>
		    </div>
		    
		  <?php } 
		  
		   //widget area
		   if($sideWidgetClass != 'slide-out-from-right-hover') {
			   if ( function_exists('dynamic_sidebar') && dynamic_sidebar('Off Canvas Menu') ) : elseif(!has_nav_menu('off_canvas_nav') && $userSetSideWidgetArea != 'off') : ?>	
			      <div class="widget">			
				 	 <h4 class="widgettitle">Side Widget Area</h4>
				 	 <p class="no-widget-added"><a href="<?php echo admin_url('widgets.php'); ?>">Click here to assign widgets to this area.</a></p>
			 	  </div>
			 <?php endif; 

			} ?>

		</div>

		<?php

			$usingSocialOrBottomText = (!empty($options['header-slide-out-widget-area-social']) && $options['header-slide-out-widget-area-social'] == '1' || !empty($options['header-slide-out-widget-area-bottom-text'])) ? true : false;
			
			echo '<div class="bottom-meta-wrap">';

			if($sideWidgetClass == 'slide-out-from-right-hover') {
			   if ( function_exists('dynamic_sidebar') && dynamic_sidebar('Off Canvas Menu') ) : elseif(!has_nav_menu('off_canvas_nav') && $userSetSideWidgetArea != 'off') : ?>	
			      <div class="widget">			
				 	 <h4 class="widgettitle">Side Widget Area</h4>
				 	 <p class="no-widget-added"><a href="<?php echo admin_url('widgets.php'); ?>">Click here to assign widgets to this area.</a></p>
			 	  </div>
			 <?php endif; 

			} 

			global $using_secondary;
		 	/*social icons*/
			 if(!empty($options['header-slide-out-widget-area-social']) && $options['header-slide-out-widget-area-social'] == '1') {
			 	$social_link_arr = array('twitter-url','facebook-url','vimeo-url','pinterest-url','linkedin-url','youtube-url','tumblr-url','dribbble-url','rss-url','github-url','behance-url','google-plus-url','instagram-url','stackexchange-url','soundcloud-url','flickr-url','spotify-url','vk-url','vine-url','houzz-url', 'phone-url','email-url');
			 	$social_icon_arr = array('fa fa-twitter','fa fa-facebook','fa fa-vimeo','fa fa-pinterest','fa fa-linkedin','fa fa-youtube-play','fa fa-tumblr','fa fa-dribbble','fa fa-rss','fa fa-github-alt','fa fa-behance','fa fa-google-plus','fa fa-instagram','fa fa-stackexchange','fa fa-soundcloud','fa fa-flickr','icon-salient-spotify','fa fa-vk','fa-vine','fa-houzz','fa fa-phone', 'fa fa-envelope');
			 	
			 	echo '<ul class="off-canvas-social-links">';

			 	for($i=0; $i<sizeof($social_link_arr); $i++) {
			 		
			 		if(!empty($options[$social_link_arr[$i]]) && strlen($options[$social_link_arr[$i]]) > 1) echo '<li><a target="_blank" href="'.$options[$social_link_arr[$i]].'"><i class="'.$social_icon_arr[$i].'"></i></a></li>';
			 	}

			 	echo '</ul>';
			 } else if (!empty($options['enable_social_in_header']) && $options['enable_social_in_header'] == '1' && $using_secondary != 'header_with_secondary') {
			 	echo '<ul class="off-canvas-social-links mobile-only">';
				nectar_header_social_icons('off-canvas');
				echo '</ul>';
			 }

			 /*bottom text*/
			 if(!empty($options['header-slide-out-widget-area-bottom-text'])) {
			 	$desktop_social = (!empty($options['enable_social_in_header']) && $options['enable_social_in_header'] == '1') ? 'false' : 'true';
			 	echo '<p class="bottom-text" data-has-desktop-social="'. $desktop_social .'">'.$options['header-slide-out-widget-area-bottom-text'].'</p>';
			 }

			echo '</div><!--/bottom-meta-wrap-->';

			if($sideWidgetClass == 'fullscreen' || $sideWidgetClass == 'fullscreen-alt' || ($theme_skin == 'material' && $sideWidgetClass == 'slide-out-from-right') || ($theme_skin == 'material' && $sideWidgetClass == 'slide-out-from-right-hover') ) echo '</div> <!--/inner-wrap-->'; ?>

	</div>
<?php } ?>


</div> <!--/ajax-content-wrap-->

<div class="login-wrap">
	<div class="login-box">
		<div class="popup-box-inner">
			<div class="popup-close">
				<a href="#">
					<i class="fa fa-close"></i>
				</a>
			</div>
			<div class="login-content">
				<p id="errors-report"></p>
				<form method="post" id="InsSignIn" name="InsSignIn">
					<div class="contact-form text-left" id="Emform">
					 	<div class="field-wrap two-fields-wrap">
                            <div class="field-div">
                                <label>*Email</label>
                                <input type="text" name="email" placeholder="Email" class="signIndata" required="" />
                            </div>
                            <div class="field-div">
                                <label>*Password</label>
                                <input type="password" name="password" placeholder="Enter Password" class="signIndata" required="" />
                            </div>
                        </div>
                        <div class="field-wrap two-fields-wrap">
                           	<div class="field-div">
                           		<input type="checkbox" name="remember" value="false" id="rember1" class="signIndata">
            	 	  			<label>Remember me</label>
            	 	  		</div>
							<div class="field-div">&nbsp; </div>
						</div>
						<div class="field-wrap two-fields-wrap">
               				<div class="field-div">
            	 				 <button class="btn btn-default" type="submit">Log In <i class="fa fa-caret-right"></i></button>
                  			</div>  
                    		<div class="field-div text-right">
                        		<a href="<?= get_site_url() ?>/my-account/lost-password/">Forgot Password?</a>
                      		</div>
                      	</div>
                   	</div>       
                </form>
			</div>
			<div>
				<div id="error-content" style="color: red"></div>
			</div>

		</div>
	</div>
</div>

<?php if(is_user_logged_in()){
	
 ?>
	<script type="text/javascript">
		jQuery(document).ready(function(){
			
			appendlines = function(sname){

				$("#smarttag_id_number").text(sname);
				$("#microchip_id").text(sname);
				$("#smarttag_id_number").text(sname);
				
				$('.front_line_text3').text(sname);
				$('.back_line_text3').text(sname);
			}

			if(localStorage.getItem("instLogin") == "true"){
			var $inputs = $('#profileuser1 .text-data');
				$inputs.each(function() {
					var name = $(this).attr('name');
					
					$("#"+name).text(localStorage.getItem(name));

					if( name == "primary_breed"){
						
							var petTypeID = localStorage.getItem("pet_type");
							var primary_breed = localStorage.getItem("primary_breed");

								$.ajax({
				                    type: 'POST',
				                    url: ajaxurl,
				                    data: {
							                action : 'get_pet_breeds',
							                 typeId:  petTypeID,
							                 primary_breed : primary_breed
							            },
				                    success: function(response) {
				                    	var Obj = jQuery.parseJSON(response);
				                    	$("#breedid").html(Obj.data);
				                    	$("#sbreedid").html(Obj.data);
				                    	
				                    }
							        
				                });
						
					}
					else if(name == "pet_type" || name == "primary_breed" || name == "gender" || name == "size"){
						if($("#profileuser1 select[name='"+name+"']").hasClass('text-data')){

							var optionValue  = localStorage.getItem(name);
							$('#profileuser1 select[name="'+name+'"] option[value="'+optionValue+'"]').attr('selected', true);
						}					
					}else{
						
						if(name == "universal_microchip_id"){
							var sname = localStorage.getItem(name);
							appendlines(sname);
						}

						console.log(name + ": " +localStorage.getItem(name));
						 $( "#profileuser1 input[name='"+name+"']").val(localStorage.getItem(name));
					}

				});
			}
		});
	</script>
<?php }else{ ?>

	<script type="text/javascript">
		setTimeout(function(){ 
			$.each($('#profileuser1 .text-data'), function() {
				var fieldName = $(this).attr('name');
				localStorage.removeItem(fieldName);
	        });
		}, 1000);

		
	</script>

<?php } ?>

<script type="text/javascript">
	
		$(function() {
			
			$("form[name='InsSignIn']").validate({
				    // Specify validation rules
				    rules: {
				  		email: {
					        required: true,
					    },
				      	password: {
					        required: true,
					        minlength: 8
			      		}
				    },

				    messages: {
				        password: {
					        required: "Please provide a password",
					        minlength: "Your password must be at least 8 characters long"
					        },
				        
				    },
				    submitHandler: function(form) {

				    	// $.each($('#profileuser1 .text-data'), function() {
				    	// 	console.log($(this).attr('name') + ":" + $(this).val());
		       //         		localStorage.setItem($(this).attr('name'), $(this).val());
		       //          });
				    	
				    	$('.loader-wrap').fadeIn();
			            var Edata =  new FormData();
			              	Edata.append('action', 'userInstantLogin');
			             
			             	$.each($('#InsSignIn .signIndata'), function() {
			               		Edata.append($(this).attr('name'), $(this).val());
			                });
			                    $.ajax({
			                        type: 'POST',
			                         url: ajaxurl,
			                         data: Edata,
			                        contentType: false,
			                        processData: false,
			                        success: function(response) {
			                        var obj = jQuery.parseJSON( response );
			                            console.log(obj);
			                            if(obj.success == 0){

			                            	$("body").find("div#error-content").append(obj.message);
			                            }else{
			                            	localStorage.setItem("instLogin" , "true");
			                            	$.each($('#profileuser1 .text-data'), function() {
									    		console.log($(this).attr('name') + ":" + $(this).val());
							               		localStorage.setItem($(this).attr('name'), $(this).val());
							                });
									    	
			                            	location.reload();
			                            }
			                         },
			                         complete:function(){
			                           $('.loader-wrap').fadeOut();
			                         }
					   
					  		});
			            }
		        }); 
			}); 

</script>
<div class="popup-wrap">
	<div class="popup-box">
		<div class="popup-box-inner">
			<div class="popup-close">
				<a id="closed" href="#">
					<i class="fa fa-close"></i>
				</a>
			</div>
			<div class="popup-content">
				<h3 id="poptitle"></h3>
				<p id="popcont"></p>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
	$('.fa-close').click(function(){
		 $('.login-wrap').fadeOut();
		 $('.popup-wrap').fadeOut();
	});
</script>

<div class="loader-wrap">
	<div class="loader-img"></div>
</div>

<?php if(!empty($options['boxed_layout']) && $options['boxed_layout'] == '1' && $headerFormat != 'left-header') { echo '</div>'; } ?>

<?php if(!empty($options['back-to-top']) && $options['back-to-top'] == 1) { ?>
	<a id="to-top" class="<?php if(!empty($options['back-to-top-mobile']) && $options['back-to-top-mobile'] == 1) echo 'mobile-enabled'; ?>"><i class="fa fa-angle-up"></i></a>
<?php } 

$body_border = (!empty($options['body-border'])) ? $options['body-border'] : 'off';
if($body_border == '1') {
	echo '<div class="body-border-top"></div>
		<div class="body-border-right"></div>
		<div class="body-border-bottom"></div>
		<div class="body-border-left"></div>';
} 

wp_footer(); ?>	

<?php if($theme_skin == 'material') { echo '</div></div><!--/ocm-effect-wrap-->'; } ?>
<?php if(!is_user_logged_in()){ ?>
	<script type="text/javascript">
		jQuery('#add_pet').parent().parent().hide();
	</script>
<?php } ?>
<script type="text/javascript">
	jQuery(".labl").parent().hide();
</script>
<script type="text/javascript">
	jQuery(document.body).on('click', '.step-acc-head' ,function(){
		jQuery(this).parent().find(".step-acc-content").slideToggle();
		jQuery(this).children(".fa").toggleClass("fa-plus");
		jQuery(this).children(".fa").toggleClass("fa-minus");
	});
</script>

</body>
</html>

<!-- custom script by rohit -->
<script type="text/javascript">
	jQuery(document).ready(function($) {
		
		/* instant login form fadein*/
		$("body").on("click","#loginform",function(){
			$("body").find(".login-wrap").fadeIn();
		});

		appendlines = function(sname){

						$("#smarttag_id_number").text(sname);
						$("#microchip_id").text(sname);
						$("#smarttag_id_number").text(sname);
						
						$('.front_line_text3').text(sname);
						$('.back_line_text3').text(sname);
					}
			       	

       	$("#sname_input").keyup(function(){
			var sname = $(this).val();
			appendlines(sname);
		});



       	$("#pname_input").keyup(function(){
       		var pname = $(this).val();
			$("#pet_name").text(pname);
			$('.front_line_text1').text(pname);
			$('.back_line_text1').text(pname);
		});

		$("#brand").change(function() {
			var brand = $(this).find("option:selected").text();
			$("#microchip_company").text(brand);
		});

       	$("#pettype").change(function() {
			var pet_type = $(this).find("option:selected").text();
			$("#pet_type").text(pet_type);
		});

       	$("#breedid").change(function() {
			var breedid = $(this).find("option:selected").text();
				// alert("breedid",breedid);
			$("#primary_breed").text(breedid);
		});

		$("#sbreedid").change(function() {
			var sbredid = $(this).find("option:selected").text();
			$("#secondary_breed").text(sbredid);
		});
  
       	$("#pcolor").keyup(function(){
			var pcol = $(this).val();
			$("#primary_color").text(pcol);
		});

       	$("#scolor").keyup(function(){
			var scol = $(this).val();
			$("#secondary_color").text(scol);
		});

	    $("#pgender").change(function() {
		  	var gen = $(this).val();
			$("#gender").text(gen);
		});

        $("#psize").change(function(){
			var siz = $(this).val();
			$("#size").text(siz);
		});

		var today = new Date();
		$("#pet-dob1").datepicker({
			dateFormat : "mm/dd/yy",
			endDate: "today",
            maxDate: today,
            changeMonth: true,
		    changeYear: true,
		  	onSelect: function() { 
		        var Pdb = $(this).val(); 
		        $("#ptdob").text(Pdb);
		    }
		});
		
		//primary cotact info

		$("#u-first").keyup(function(){
			var pfnam = $(this).val();
			$("#pfnam").text(pfnam);
		});

		$("#u-last").keyup(function(){
			var plnam = $(this).val();
			$("#plnam").text(plnam);
		});

		$("#u-email").keyup(function(){
			var pmail = $(this).val();
			$("#pemail").text(pmail);
		});

		$("#u-add1").keyup(function(){
			var uadd1 = $(this).val();
			$("#uadd1").text(uadd1);
		});

		$("#u-add2").keyup(function(){
			var uadd2 = $(this).val();
			$("#uadd2").text(uadd2);
		});

		$("#u-city1").keyup(function(){
			var ucity1 = $(this).val();
			$("#ucity1").text(ucity1);
		});

		$(document).on('change','#u-country',function(){
			var ucounty = $(this ).find(':selected').text();
			$("#ucounty").text(ucounty);
		});

		$(document).on('change','[name=p_state]',function(){
			var state = $(this ).find(':selected').text();

			if(!state){
				var ustte  = $(this).val();
				$("#ustte").text(ustte);
			}else{
				var ustte  = $(this ).find(':selected').text();
				$("#ustte").text(ustte);
			}
		});

		$(document).on('change','[name=s_state]',function(){
			var state = $(this ).find(':selected').text();
			$("#sttate").text(state);
		});

		$(document).on('change','[name=vaterinarian_state]',function(){
			var state = $(this ).find(':selected').text();
			$("#vstate").text(state);
		});

		$("#u-zip").keyup(function(){
			var uzip = $(this).val();
			$("#uzip").text(uzip);
		});

		$(document).on('change','#u-state',function(){ 
			var stateType = $(this ).find(':selected').text();
			if(!stateType){
				var ustte  = $(this).val();
				$("#ustte").text(ustte);
			}else{
				var ustte  = $(this ).find(':selected').text();
				$("#ustte").text(ustte);
			}	
		});

		$("#p-phone").keyup(function(){
			var pnum = $(this).val();
			$("#pnum").text(pnum);
		});
		
		$("#ps-phone").keyup(function(){
			var snum = $(this).val();
			$("#snum").text(snum);
		});

		$("#s-name").keyup(function(){
			var sfirst = $(this).val();
			$("#sfirst").text(sfirst);
		});

		$("#s-lstname").keyup(function(){
			var slst = $(this).val();
			$("#slst").text(slst);
		});

		$("#s-email").keyup(function(){
			var semail = $(this).val();
			$("#semail").text(semail);
		});
		
		$("#s-add1").keyup(function(){
			var sadd1 = $(this).val();
			$("#preAdd1").text(sadd1);
		});
		
		$("#s-add2").keyup(function(){
			var sadd2 = $(this).val();
			$("#preAdd2").text(sadd2);
		});

		$(document).on('change','#s-county',function(){
			var scounty = $(this ).find(':selected').text();
			$("#scounty").text(scounty);
		});
		
		$(document).on('change','[name=s_state]',function(){ 
			var state = $(this ).find(':selected').text();

			if(!state){
				var sttate  = $(this).val();
				$("#sttate").text(sttate);
			}else{
				var sttate  = $(this ).find(':selected').text();
				$("#sttate").text(sttate);
			}
			
		});

		$("#s_city1").keyup(function(){
			var scity = $(this).val();
			$("#scity").text(scity);
		});

		 
		$("#s-zip").keyup(function(){
			var szip = $(this).val();
			$("#szip").text(szip);
		});

		$("#sp-phone").keyup(function(){
			var sprino = $(this).val();
			$("#sprino").text(sprino);
		});
		
		$("#ss-phone").keyup(function(){
			var sseno = $(this).val();
			$("#sseno").text(sseno);
		});	  
		$("#v-email").keyup(function(){
			var vemail = $(this).val();			
			$("#vemail").text(vemail);
		});

		$("#v-first").keyup(function(){
			var vname = $(this).val();
			$("#vname").text(vname);
		});

		$("#v-last").keyup(function(){
			var vlst = $(this).val();
			$("#vlst").text(vlst);
		});
		$("#v-add1").keyup(function(){
			var vadd1 = $(this).val();
			$("#vadd1").text(vadd1);
			addresses['vadd1'] = vadd1;
		});

		$("#v-add2").keyup(function(){
			var vadd2 = $(this).val();
			$("#vadd2 ").text(vadd2);
			addresses['vadd2'] = vadd2;
		});
		
		$("#v-city1").keyup(function(){
			var vcity = $(this).val();
			$("#vcity ").text(vcity);
			addresses['vcity'] = vcity;
		});

		$(document).on('change','#v-cuntry',function(){
			var vcounty = $(this ).find(':selected').text();
			$("#vcounty").text(vcounty);
		});

		$(document).on('change','#v-state',function(){ 
			var vatstate = $(this ).find(':selected').text();
			if(!vatstate){
				var vstate  = $(this).val();
				$("#vstate").text(vstate);
			}else{
				var vstate  = $(this ).find(':selected').text();
				$("#vstate").text(vstate);
			}
			
		});
		
		$("#v-zip").keyup(function(){
			var vzip = $(this).val();
			$("#vzip ").text(vzip);
			addresses['vzip'] = vzip;
		});

		$("#v-prim").keyup(function(){
			var vprim = $(this).val();
			$("#vprim").text(vprim);
		});

		$("#v-sec").keyup(function(){
			var vsec = $(this).val();
			$("#vsec").text(vsec);
		});
		
		$("input[name=universal_microchip_id]").on("keyup change",function(){
			var micro = $(this).val();
			$("#universal_microchip_id").text(micro);
		});
		
		$("input[name=microchip_company]").on("change",function(){
			var micro = $(this).val();
			$("#universal_microchip_id").text(micro);
		});
	 
	});	

    /*Form handler start*/
    jQuery(document).ready(function($) {
    	var today = new Date();
    	$("#pet-dob1").datepicker({
            dateFormat : "mm/dd/yy",
            endDate: "today",
            maxDate: today,
            changeMonth: true,
		    changeYear: true,
		    onSelect: function() { 
		        var Pdb = $(this).val(); 
		        $("#ptdob").text(Pdb);
		    }
        });

    	function readURL(input) {
    	 if (input.files && input.files[0]) {
            var reader = new FileReader();
            
            reader.onload = function (e) {
                $('#blah').attr('src', e.target.result);
            }
            
            reader.readAsDataURL(input.files[0]);
           }
         }
    
	    $("#imgInp").change(function(){
	    	readURL(this);
	    });

        $('#heth_id').on('click', function(){
        	$("#Insurance-div").show();
        	$(this).addClass("PetInsurance");
            $('.skip2').html('Next'+' <i class="fa fa-caret-right"></i>');
             $('#Insurance').text("Added");

        });
		$('#heth_id1').on('click', function(){
			$("#Insurance-div").hide();
			$('#heth_id').removeClass("PetInsurance");
			$('#Insurance').text("Free Month");
			if ( $('#heth_id').attr("checked") != 'checked' && $('#CustPro').attr("checked") != 'checked' && $('#PetArg').attr("checked") != 'checked') {
				$('.skip2').html('Skip All Offers'+' <i class="fa fa-caret-right"></i>');
			}else{
					$('.skip2').html('Next'+' <i class="fa fa-caret-right"></i>');
				}
			
		});

		var newvalue = new Array();
		function objectTosting(object){
			var newvalue = [];
	        $.each( object, function( key, value ) {
	        	if(value !== 'null'){
	        	  newvalue.push(value);
	        	}
	        });
	    return newvalue;
	    }

		$('#PetArg').on('click', function(){
			$('#ArrangementDiv').show();
			$(this).addClass("protectArg");
			$('.skip2').html('Next'+' <i class="fa fa-caret-right"></i>');
		    $('#Arrangement').text("Added");
		});
		$('#PetArg1').on('click', function(){
			$('#ArrangementDiv').hide();
			$('#PetArg').removeClass("protectArg");
			$('#Arrangement').text("None");
			if ( $('#heth_id').attr("checked") != 'checked' && $('#CustPro').attr("checked") != 'checked' && $('#PetArg').attr("checked") != 'checked') {
				$('.skip2').html('Skip All Offers'+' <i class="fa fa-caret-right"></i>');
			}else{
					$('.skip2').html('Next'+' <i class="fa fa-caret-right"></i>');
			}
            
		});

		$('#AddCart-silver1').on('click', function(){$('#Usil1').removeClass("add-uni-sub-plan");});
		$('#AddCart-silver2').on('click', function(){$('#Usil2').removeClass("add-uni-sub-plan");});
		$('#AddCart-gold1').on('click', function(){$('#Ugol1').removeClass("add-uni-sub-plan");});
		$('#AddCart-gold2').on('click', function(){$('#Ugol2').removeClass("add-uni-sub-plan");});
		$('#AddCart-plati1').on('click', function(){$('#plati1').removeClass("add-uni-sub-plan");});
		$('#AddCart-plati2').on('click', function(){$('#plati2').removeClass("add-uni-sub-plan");});
  
      
         //add class on add to cart button on subscription plan 

        $('#Stsil1').on('click', function(){
         	 $('.ste4').html('Next'+' <i class="fa fa-caret-right"></i>');
         });
     
         $('#Stsil2').on('click', function(){
         	 $('.ste4').html('Next'+' <i class="fa fa-caret-right"></i>');
         });

        $('#Stsil3').on('click', function(){
     	 $('.ste4').html('Next'+' <i class="fa fa-caret-right"></i>');
        });

         $('#Sgol1').on('click', function(){
          	 $('.ste4').html('Next'+' <i class="fa fa-caret-right"></i>');	        
         });

          $('#Sgol2').on('click', function(){
         	$('.ste4').html('Next'+' <i class="fa fa-caret-right"></i>');
          });

         $('#Sgol3').on('click', function(){
           $('.ste4').html('Next'+' <i class="fa fa-caret-right"></i>');
         });

         $('#spla1').on('click', function(){
         	 $('.ste4').html('Next'+' <i class="fa fa-caret-right"></i>');     
         });

         $('#spla2').on('click', function(){
         	 $('.ste4').html('Next'+' <i class="fa fa-caret-right"></i>');
         });

         $('#spla3').on('click', function(){
         	 $('.ste4').html('Next'+' <i class="fa fa-caret-right"></i>');
         });
  
         $("#profileuser1 #CustPro").on('click',function(){
         	$("#field1").prop('required',true);
         	$("#field2").prop('required',true);
         	
         	$("#eng_id").show();
         	$("#eng_id1").hide();

        	$('.skip2').html('Next'+' <i class="fa fa-caret-right"></i>');
         });
        
        $("#profileuser1 #CustProdis").on("click",function(){
        	$("#eng_id").hide();
         	$("#eng_id1").show();
         	if ( $('#heth_id').attr("checked") != 'checked' && $('#CustPro').attr("checked") != 'checked' && $('#PetArg').attr("checked") != 'checked') {
				$('.skip2').html('Skip All Offers'+' <i class="fa fa-caret-right"></i>');
			}else{
				$('.skip2').html('Next'+' <i class="fa fa-caret-right"></i>');
			}
        })
        
		$("#profileuser1 #heth_id").on('click',function(){
         	$('.ste4').html('Next'+' <i class="fa fa-caret-right"></i>');
         });

         $("#profileuser1 #PetArg").on('click',function(){
      	 $('.ste4').html('Next'+' <i class="fa fa-caret-right"></i>');
         });
      	
      	$('.subPlans').on('click',function(){
      		$("#pln-div").show();
        	$(this).parent().parent().find("div .pp-plan-name");
        	$(this).parents("fieldset").find("input[name=protectionPlan]").val(1);
      	    $('.subPlans').removeClass('AddSubscription');
		   var PlanPrice = $(this).attr('price');
		   var Plantype = $(this).parent().parent().parent().find('h2').text();
      	   var PlnName = $(this).parent().parent().find(".pp-plan-name").text();
      	    $("#pln").text(Plantype+" "+PlnName);
      	    $("#PlnPrice").text(PlanPrice);
          	$(this).addClass('AddSubscription');
          	$('.subPlans').html('Add to Cart'+ ' <i class="fa fa-shopping-cart"></i>');
          	
          	$(this).text('Added'); 

       });

    });
	function readURLL(input,classs) {
        var url = '<?php echo get_site_url(); ?>/wp-content/themes/salient-child/images/no_pet.jpeg';
        console.log(input);
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            console.log(reader);
            reader.onload = function (e) {
                jQuery('.'+classs)
                    .attr('src', e.target.result);
            };

            reader.readAsDataURL(input.files[0]);
        }else{
            jQuery('.'+classs)
                .attr('src', url);
        }
    }
    /*End form handler*/

	// <!-- script for custom products -->
	jQuery(document).ready(function(){
		jQuery("#stylee div.custom-radio-box").hide();
		jQuery("#stylee div.circle").show();
		jQuery("#colorr div.custom-radio-box").hide();
		jQuery(".style-pro div.section-front-image").hide();
		jQuery(".style-pro div.section-back-image").hide();
		jQuery(".color-pro div.section-front-image").hide();
		jQuery(".color-pro div.section-back-image").hide();
		jQuery(".style-pro div.design-circle").show();
		// jQuery("#selectType").on('change', function () {
			jQuery('body').on('click','#selectType .nice-select li', function () {
				if($(this).attr("data-value") == 0){
					// alert("Please select a type");
				}else{
					var product = jQuery(this).attr('data-product');
					var value = jQuery(this).attr('data-value');
					jQuery("div.style-pro div").hide();
					jQuery("div.color-pro div").hide();
					jQuery("#stylee div.custom-radio-box").hide();
					jQuery("#colorr div.custom-radio-box").hide();
					jQuery(".style-pro div.section-front-image").hide();
					jQuery(".style-pro div.section-back-image").hide();
					jQuery(".color-pro div.section-front-image").hide();
					jQuery(".color-pro div.section-back-image").hide();
					jQuery('.style-radio').prop('checked', false);
					if (product == "aluminum") {
						
						jQuery("#colorr div."+value+" label.btn.active").addClass('inactive');
						jQuery("#colorr div."+value+" label.btn.active").removeClass('active');
						jQuery("#colorr div."+value+" label").first().removeClass('inactive');
						jQuery("#colorr div."+value+" label").first().addClass('active');
						jQuery("#single-product").attr('action','<?php echo get_site_url(); ?>/product/aluminum-id-tag/');

		                jQuery("#colorr").find("div."+value).show();

		                var img = jQuery("#colorr div."+value+" label.btn.active .custom-radio-img img").attr('data-name');
		                jQuery("div.color-pro div."+img).show();
		                jQuery("#colorr ."+value+" label.btn.active .style-radio").prop('checked', true);
		                
		                if(value == "bone" || value == "circle" || value == "heart"){
		                	$("span.micro-back-img").children("span.woo-complex-custom").hide();
		                	$("div.section-front-image span").show();
		                	$(".front_line_text1").css('color',"#ffff");
		                	$(".front_line_text2").css('color',"#ffff");
		                	$(".front_line_text3").css('color',"#ffff");
		                }
					}else{
						jQuery("#stylee div."+value+" label.btn.active").addClass('inactive');
						jQuery("#stylee div."+value+" label.btn.active").removeClass('active');
						jQuery("#stylee div."+value+" label").first().removeClass('inactive');
						jQuery("#stylee div."+value+" label").first().addClass('active');
						jQuery("#single-product").attr('action','<?php echo get_site_url(); ?>/product/brass-id-tag/');

						jQuery("#stylee").find("div."+value).show();

		                var img = jQuery("#stylee div."+value+" label.btn.active .custom-radio-img img").attr('data-name');
		                jQuery("div.style-pro div."+img).show();
		                jQuery("#stylee ."+value+" label.btn.active .style-radio").prop('checked', true);
		                
		                // show lines in stepform
		                if(value == "bone" || value == "circle" || value == "heart"){
		                	$("span.micro-back-img").children("span.woo-complex-custom").show();
		                	$("div.section-front-image span.woo-complex-custom").hide();

		                }
					}
				}	
			});
		jQuery("#continue-cust").on('click',function(){
			if (jQuery("select.custom-select-box").val() != 0) {
				var data = jQuery("#single-product").serialize();
				$.ajax({
                    type: 'POST',
                    url: ajaxurl,
                    data: {
			                action : 'set_temp_session',
			                post : data
			            },
                    success: function(response) {
                    	console.log(response);
                    	jQuery("#single-product").submit();
                    }
			        
                });
				// jQuery("#single-product").submit();
			}else{
				$('.popup-wrap-front').fadeIn(function() {   						
	    			$('#poptitle-front').text("Custom Engrave Your Pet ID Tag");
	    			$('#popcont-front').text("Please select atleast one type.");
				});
				// jQuery('.error').html('Please Select at Least One Type.');
				// jQuery.blockUI({ message: $('#dialog'), css: { width: '300px' } });
			}
		});
		jQuery('a#close').click(function() { 
            $.unblockUI(); 
            return false; 
        });
        jQuery('a#close-front').click(function() { 
            $.unblockUI(); 
            return false; 
        });
		jQuery('body').on('click','.custom-radio-img',function(){
			
			jQuery("div.style-pro div").hide();
			jQuery("div.color-pro div").hide();
			var imgName = jQuery(this).find("img").attr("src");
			var img = jQuery(this).parent().find('.style-radio').attr('data-name');
			// alert(img);
			var clas = jQuery(this).parent().find('.style-radio').attr('name');
			if (clas == 'style') {
				jQuery("div."+clas+"-pro div."+img+".section-front-image img").attr("src",imgName);
			}else{
				
				jQuery("div."+clas+"-pro div."+img+" img").attr("src",imgName);
			}
			jQuery("div."+clas+"-pro div."+img).show();
			
		});
		jQuery(".sidebar-engrave .custom-radio-box").show();
	});

	//stepform custom products
	jQuery(document).ready(function($) {
		$('#password_1').keyup(function() {
			var password1 = $(this).val();
			var password2 = $('#password_2').val();

			var result = checkStrength($('#password_1').val());
			if(jQuery(this).val().length === 0){
				$('.pass-strength span.password-strength strong').html("");
				$('.pass-strength-line').css("background", "#eee");
				
			}else{
				if (password2 == password1) {
					$('.pass-strength span.password-match strong').html("Matched");
					$('#password_2-error').fadeOut();
				}else{
					$('.pass-strength span.password-match strong').html("No");
				}
				$('.pass-strength span.password-strength strong').html(result.msg);
			}		
		});

		$('#password_2').keyup(function() {
			var password1 = $('#password_1').val();
			var password2 = $(this).val();
			if(jQuery(this).val().length === 0){
				$('.pass-strength span.password-match strong').html("");
			}
			else{
				if (password2 == password1) {
					$('.pass-strength span.password-match strong').html("Matched");
					$('#password_2-error').fadeOut();
				}else{
					$('.pass-strength span.password-match strong').html("No");
				}
			}
		});
	});
	function checkStrength(password) {
		var strength = 0
		var result;
		if (password.length < 6) {
			$('#pass-strength-line').removeClass()
			$('#pass-strength-line').addClass('pass-strength-line short');
			result = {
			    "success":0,
			    "msg":"Very Weak"
			};
			return result;
		}
		if (password.length > 5) strength += 1
		// If password contains both lower and uppercase characters, increase strength value.
		if (password.match(/([a-z].*[A-Z])|([A-Z].*[a-z])/)) strength += 1
		// If it has numbers and characters, increase strength value.
		if (password.match(/([a-zA-Z])/) && password.match(/([0-9])/)) strength += 1
		// If it has one special character, increase strength value.
		if (password.match(/([!,%,&,@,#,$,^,*,?,_,~])/)) strength += 1
		// Calculated strength value, we can return messages
		// If value is less than 2
		if (strength < 2) {
			$('#pass-strength-line').removeClass()
			$('#pass-strength-line').addClass('pass-strength-line short');
			result = {
			    "success":0,
			    "msg":"Very Weak"
			};
			return result;
		} else if (strength == 2) {
			$('#pass-strength-line').removeClass()
			$('#pass-strength-line').addClass('pass-strength-line bad');
			result = {
			    "success":0,
			    "msg":"Weak"
			};
			return result;
		} else if (strength > 2 && strength < 4) {
			$('#pass-strength-line').removeClass()
			$('#pass-strength-line').addClass('pass-strength-line good');
			result = {
			    "success":1,
			    "msg":"Good"
			};
			return result;
		} else {
			$('#pass-strength-line').removeClass()
			$('#pass-strength-line').addClass('pass-strength-line strong');
			result = {
			    "success":1,
			    "msg":"Strong"
			};
			return result;
		}
	}

	jQuery(document).ready(function($){

		$("body").find(".address-country").each(function(){
			var country = $(this).val();
			$this = $(this);
			var j = 0;
			var select = "<option value=''>Select State</option>";
			
			$state = $(this).parent().parent().parent().find(".address-state");
			var statevalue = $state.val();
			console.log(statevalue);
			// $state = $(this).parent().parent().parent().find(".address-state1");
			var attrName = $state.attr('name');
			var attrClas = $state.attr('class');
			var dataVal  = $state.attr('data-val');
			if ($state.attr('id')) {
				var attrId 	 = $state.attr('id');
			}else{
				var attrId 	 = "";
			}
			// console.log(attrName);

			$.each(window.addressStates[country], function(i, item) {
				j++;
				if (dataVal == i) {
					select += "<option value='"+i+"' selected>"+item+"</option>";
				}else{
					select += "<option value='"+i+"'>"+item+"</option>";
				}
			    
			});


			if (j==0) {
				if($this.hasClass('not-require')){
					select = "<input type='text' class='"+attrClas+"' name='"+attrName+"'  placeholder='State' data-val='"+dataVal+"' id='"+attrId+"' value='"+dataVal+"'>";
				}else{
					select = "<input type='text' class='"+attrClas+"' name='"+attrName+"' required='' placeholder='State' data-val='"+dataVal+"' id='"+attrId+"' value='"+dataVal+"'>";
				}
				
				$parent = $state.parent();
				$state.remove();
				$parent.append(select);
			}else{
				$state.html(select);
			}
		});

		$("body").on("change",".address-country",function(){
				$this 	= $(this);
				var country = $(this).val();
				var j = 0;
				
				$state = $(this).parent().parent().parent().find(".address-state");
				var attrName = $state.attr('name');
				var attrClas = $state.attr('class');
				if ($state.attr('id')) {
					var attrId 	 = $state.attr('id');
				}else{
					var attrId 	 = "";
				}
			$parent = $state.parent();
			$state.remove();
			// $parent.find("span#u-state-error").remove();
			if($this.hasClass('not-require')){
				var select = "<select  class='"+attrClas+"' name='"+attrName+"' id='"+attrId+"'><option value=''>Select State</option>";
			}else{
				var select = "<select required='' class='"+attrClas+"' name='"+attrName+"' id='"+attrId+"'><option value=''>Select State</option>";

			}
			
			$.each(window.addressStates[country], function(i, item) {
				j++;
			    select += "<option value='"+i+"'>"+item+"</option>";
			});
			if (j==0) {
				if($this.hasClass('not-require')){
					select = "<input type='text'class='"+attrClas+"' name='"+attrName+"' placeholder='State' id='"+attrId+"'>";
				}else{
					select = "<input type='text' class='"+attrClas+"' required='' name='"+attrName+"' placeholder='State' id='"+attrId+"'>";
				}
				
			}
			$parent.find("label.statevalidate").after(select);
		});

		$("#profileuser1 input[name=style]").each(function(){
			if ($(this).val() == "circle-1") {
				$(this).prop("checked",true);
				return;
			}
		})
	});

//js for steps form

	$(".plan-edit").on("click",function(){
		$("#step-5").removeClass("visible").addClass("hidden");
		$("#step-3").removeClass("hidden").addClass("visible");
		// $('a.AddSubscription').html('Add to Cart'+ ' <i class="fa fa-shopping-cart"></i>');
		// $("a.subPlans").removeClass("AddSubscription");
		var subscription = $("a.subPlans").hasClass("AddSubscription");
			if(!subscription){
				$("span#pln").text("None");
				$(this).html('<i class="fa fa-edit"></i> EDIT');
				$('button.ste4').html('Skip Protection Plan '+ '<i class="fa fa-caret-right"></i>');
			}
	});

	$(".engrave-edit").on("click",function(){
		$("#step-5").removeClass("visible").addClass("hidden");
		$("#step-4").removeClass("hidden").addClass("visible");
	});

	$(".usr-edit").on("click",function(){
		$("#step-5").removeClass("visible").addClass("hidden");
		$("#step-2").removeClass("hidden").addClass("visible");
	});

	$(".petpro-edit").on("click",function(){
		$("#step-5").removeClass("visible").addClass("hidden");
		$("#step-1").removeClass("hidden").addClass("visible");
	});

	$(function () {
		$("#pettype").on("change",function(){
			var petTypeID = $(this).children("option:selected").val();
				$.ajax({
                    type: 'POST',
                    url: ajaxurl,
                    data: {
			                action : 'get_pet_breeds',
			                 typeId:  petTypeID
			            },
                    success: function(response) {
                    	var Obj = jQuery.parseJSON(response);
                    	$("#breedid").html(Obj.data);
                    	$("#sbreedid").html(Obj.data);
                    	
                    }
			        
                });
		});

	});

	$(function () {
	    $(".print-btn").click(function () {
	    	var error = 0;
	    	$('.contact-form .error').remove();
			$.each($('.contact-form input[type="text"]'), function() {
				if ($(this)[0].hasAttribute("required")) {
			        if (!$.trim($(this).val())) {
			            $(this).parent().append('<label class="error">This field is required.</label>');
			            error = 1;
			        }
			    }        
			});
			$.each($('.contact-form input[type="number"]'), function() {
				if ($(this)[0].hasAttribute("required")) {
			        if (!$.trim($(this).val())) {
			            $(this).parent().append('<label class="error">This field is required.</label>');
			            error = 1;
			        }
			    }        
			});
			$.each($('.contact-form textarea'), function() {
				if ($(this)[0].hasAttribute("required")) {
			        if (!$.trim($(this).val())) {
			            $(this).parent().append('<label class="error">This field is required.</label>');
			            error = 1;
			        }
			    }        
			});
			console.log(error);
			if (error) {
				return;
			}
	        var contents = $(".print-poster-col").html();
	        var frame1 = $('<iframe />');
	        frame1[0].name = "frame1";
	        frame1.css({ "position": "absolute", "top": "-1000000px" });
	        $("body").append(frame1);
	        var frameDoc = frame1[0].contentWindow ? frame1[0].contentWindow : frame1[0].contentDocument.document ? frame1[0].contentDocument.document : frame1[0].contentDocument;
	        frameDoc.document.open();
	        //Create a new HTML document.
	        frameDoc.document.write('<html><head><title>SmartTag Poster</title>');
	        frameDoc.document.write('</head><body>');
	        //Append the DIV contents.
	        frameDoc.document.write(contents);
	        frameDoc.document.write('</body></html>');
	        frameDoc.document.close();
	        setTimeout(function () {
	            window.frames["frame1"].focus();
	            window.frames["frame1"].print();
	            frame1.remove();
	        }, 500);
	    });
	});

	jQuery(document).ready(function(){
		var input = document.querySelector(".phone-number");
		var countryData = window.intlTelInputGlobals.getCountryData();
		$(".phone-country-code").each(function(i, input){
			var code = $(this).attr("data-val");
			$(input).text("+1-");
			$.each(countryData, function(i, val){
				if (val.iso2 == code) {
					$(input).text("+"+val.dialCode+"-");
					return;
				}
			})
		});

		$(".phone-number").each(function(i, input){
			console.log("phoneNumber", input);
			var name = $(input).attr("name")+"_code";
		    var inputVal = $("input[name="+name+"]").val();
		    console.log("Gaurav", inputVal);
			var init = window.intlTelInput(input,{
			    separateDialCode: true,
			});

			if(inputVal){
				try {
				  	init.setCountry(inputVal);
				}
				catch(err) {
				  	init.setCountry("us");
		        	$("input[name="+name+"]").val("us");
				}
		        
		    }else{
		        init.setCountry("us");
		        $("input[name="+name+"]").val("us");
		    }

			input.addEventListener("countrychange", function() {
				var countryCode = init.getSelectedCountryData();
                var name = $(input).attr("name")+"_code";
                
                $(input).parent().parent().find("input[name="+name+"]").val(countryCode.iso2);
                
                $("#"+name).text("+"+countryCode.dialCode);
                
			});
		})
	});
	<?php if (isset($_POST['petName'])) { ?>
		jQuery(document).ready(function(){
			jQuery(".select-option.swatch-wrapper").removeClass("selected");
			jQuery("select#pa_ttype option[value='<?php echo $_POST["type"]; ?>']").prop("selected", true).change();
			jQuery(".select-option.swatch-wrapper[data-value='<?php echo $_POST["type"]; ?>").addClass('selected');
			jQuery(".front_line1").text('<?php echo $_POST['petName']; ?>');
			jQuery("#engraving_back_line_1").val('<?php echo $_POST['petName']; ?>');
			var type = jQuery("#picker_pa_ttype .select-option.swatch-wrapper.selected").attr('data-value');
			
			if (type == "heart") {
				jQuery(".show_img img").attr('src','https://prelaunch.idtag.com/wp-content/themes/salient-child/images/back/heart-back.png');
				jQuery(".show_img img.front_img").attr('src','https://prelaunch.idtag.com/wp-content/themes/salient-child/images/back/heart-back.png');
			} else if(type == "circle"){
				jQuery(".show_img img").attr('src','https://idtag.agiliscloud.com/wp-content/themes/salient-child/images/back/round-silver-big.png');
				jQuery(".show_img img.front_img").attr('src','https://idtag.agiliscloud.com/wp-content/themes/salient-child/images/back/round-silver-big.png');
			} else if(type == "bone"){
				jQuery(".show_img img").attr('src','https://idtag.agiliscloud.com/wp-content/themes/salient-child/images/back/bone-back.png');
				jQuery(".show_img img.front_img").attr('src','https://idtag.agiliscloud.com/wp-content/themes/salient-child/images/back/bone-back.png');
			}
		});
	<?php } ?>
	$("body").on("click", "a.custom-reset-variation", function(){
		alert("Gaurav");
		$("select#pa_ttype").val("bone").change();
		jQuery(".select-option.swatch-wrapper[data-value='bone'").addClass('selected');
	})

	$(document).ready(function(e){
		if($("select.address-country").val() == "" || $("select.address-country").val() == undefined){
			$("select.address-country").val("US").trigger("change");
		}
		if($("select#billing_country").val() == "" || $("select#billing_country").val() == undefined){
			$("select#billing_country").val("US").trigger("change");
		}
	})
	// product-type-variable
</script>