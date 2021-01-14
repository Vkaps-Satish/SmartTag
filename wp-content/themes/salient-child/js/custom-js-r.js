	// $(function() {z
			$('a[href]').each(function(){ 
	        	if(location.pathname == $(this).attr("href")){
	        	$(this).css("background", "#3b5b81"); 	
        		}
        	});

        	//show chat div
        	$('div.header-chat a').on('click',function(){
        		$('#wp-live-chat-2').show();
        		$("#wp-live-chat-header").addClass("active");
			})

			jQuery(".pp-tab-option-2").click(function(){
			jQuery(this).addClass("active");
			jQuery(this).prev(".pp-tab-option-1").removeClass("active");
			jQuery(this).parent(".pp-tabs-nav").next(".pp-tab-content-1").fadeOut();
			jQuery(this).parent(".pp-tabs-nav").next(".pp-tab-content-1").next(".pp-tab-content-2").fadeIn();

			//customcode for pet owner section
			jQuery(this).parent(".pp-tabs-nav").next(".pp-tab-content-1").next(".pp-tab-content-2").find(".change-password-email").fadeIn();
			jQuery(this).parent(".pp-tabs-nav").next(".pp-tab-content-1").next(".pp-tab-content-2").find(".change-primary-info").fadeIn();
			jQuery(this).parent(".pp-tabs-nav").next(".pp-tab-content-1").next(".pp-tab-content-2").find(".change-secondary-info").fadeIn();
			jQuery("#saveAllBtn").fadeIn();
		});

		jQuery(".owner-edit").click(function(){
			jQuery(".pp-tab-option-2").click();
		});

		jQuery("#own-profile-edit").click(function(){
			
			jQuery(".pp-tab-option-2").addClass("active");
			jQuery(".pp-tab-option-2").prev(".pp-tab-option-1").removeClass("active");
			jQuery(".pp-tab-option-2").parent(".pp-tabs-nav").next(".pp-tab-content-1").fadeOut();
			jQuery(".pp-tab-option-2").parent(".pp-tabs-nav").next(".pp-tab-content-1").next(".pp-tab-content-2").fadeIn();
			console.log(jQuery(this).parents(".pp-tabs-wrap").find(".pp-tab-content-2").next(".change-password-email").html());
			jQuery(this).parents(".pp-tabs-wrap").find(".pp-tab-content-2").find(".change-password-email").fadeOut();
			jQuery(this).parents(".pp-tabs-wrap").find(".pp-tab-content-2").find(".change-primary-info").fadeIn();
			jQuery(this).parents(".pp-tabs-wrap").find(".pp-tab-content-2").find(".change-secondary-info").fadeOut();
			jQuery("#saveAllBtn").fadeOut();
		});

		jQuery("#sec-profile-edit").click(function(){
			
			jQuery(".pp-tab-option-2").addClass("active");
			jQuery(".pp-tab-option-2").prev(".pp-tab-option-1").removeClass("active");
			jQuery(".pp-tab-option-2").parent(".pp-tabs-nav").next(".pp-tab-content-1").fadeOut();
			jQuery(".pp-tab-option-2").parent(".pp-tabs-nav").next(".pp-tab-content-1").next(".pp-tab-content-2").fadeIn();
			console.log(jQuery(this).parents(".pp-tabs-wrap").find(".pp-tab-content-2").next(".change-password-email").html());
			jQuery(this).parents(".pp-tabs-wrap").find(".pp-tab-content-2").find(".change-password-email").fadeOut();
			jQuery(this).parents(".pp-tabs-wrap").find(".pp-tab-content-2").find(".change-secondary-info").fadeIn();
			jQuery(this).parents(".pp-tabs-wrap").find(".pp-tab-content-2").find(".change-primary-info").fadeOut();
			jQuery("#saveAllBtn").fadeOut();
		});

		jQuery("#request_cancle_user").click(function () {
			
			var data = {
	            'action': 'request_for_cancel_Account',
	                'user_id': jQuery(this).attr('user-id'),
	        };
	       
	        jQuery.post(ajaxurl, data, function (response) {
	        	var Obj = JSON.parse(response);
	        		console.log(Obj.message);
	        		 $('.popup-wrap').fadeIn(function() {
                       
                            $('.popup-content').append(Obj.message);

                    });

	        });

	    });

		// get price of custom product
		$("#profileuser1 #CustPro").on('click',function(){
			
         	$("#field1").prop('required',true);
         	$("#field2").prop('required',true);
         	
         	$("#eng_id").show();
         	$("#eng_id1").hide();

        	$('.skip2').html('Next'+' <i class="fa fa-caret-right"></i>');
        
			var product = "";
        	var value = "";

                $.each($('#selectType .nice-select li'), function() {
                	
                    if ($(this).hasClass('selected')) {
                        product = jQuery(this).attr('data-product');
                        value = jQuery(this).attr('data-value');
                    }
                });
                
                var size = $('#field2').val();
                if (product == 'aluminum') {
                    var color = '';
                    $.each($('input[name=color]'), function() {
                        if ($(this).attr('checked') == 'checked') {
                            color = $(this).val();
                        }
                    });
                    data = {
                        'attribute_pa_shape': value,
                        'attribute_pa_size': size,
                        'attribute_pa_color': color,
                        'action': 'custom_product_price',
                        'engraving_front_line_1': $("#front_line1").text(),
                        'engraving_front_line_2': $("#front_line2").text(),
                        'engraving_front_line_3': $("#front_line3").text(),
                    };
                } else {
                    var style = '';
                    $.each($('input[name=style]'), function() {
                        if ($(this).attr('checked') == 'checked') {
                            style = $(this).val();
                        }
                    });
                    data = {
                        'attribute_pa_ttype': value,
                        'attribute_pa_size': size,
                        'attribute_pa_style': style,
                        'action': 'custom_product_price',
                        'engraving_back_line_1':$("#back_line1").text(),
                        'engraving_back_line_2': $("#back_line2").text(),
                        'engraving_back_line_3': $("#back_line3").text(),
                    };
                }

                console.log("value",color);
                console.log("size",size);
                console.log("value",value);

                if(color != "" || size != "" || value != "" ){
                	
                    $.ajax({
                        type: 'POST',
                        url: ajaxurl,
                        data: data,
                        success: function(response) {
                            console.log('custom variable product id is: ' + response);
                            var Obj = JSON.parse(response);
                            if(Obj.success == 1){
                                
                                console.log("product price" , Obj.productPrice);
                                $("span#ProductPrice").text(Obj.productPrice);
                                
                            }
                        }
                    });
                }
  			});