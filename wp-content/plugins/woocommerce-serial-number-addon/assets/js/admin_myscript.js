jQuery(document).ready(function($){
    /*var inputFilter = function(inputFilter) {
        return this.on("input keydown keyup mousedown mouseup select contextmenu drop", function() {
          if (inputFilter(this.value)) {
            this.oldValue = this.value;
            this.oldSelectionStart = this.selectionStart;
            this.oldSelectionEnd = this.selectionEnd;
          } else if (this.hasOwnProperty("oldValue")) {
            this.value = this.oldValue;
            this.setSelectionRange(this.oldSelectionStart, this.oldSelectionEnd);
          }
        });
    };*/

    var inputFilter = function(inputFilter) {
        if (inputFilter(this.value)) {
            this.oldValue = this.value;
            this.oldSelectionStart = this.selectionStart;
            this.oldSelectionEnd = this.selectionEnd;
          } else if (this.hasOwnProperty("oldValue")) {
            this.value = this.oldValue;
            this.setSelectionRange(this.oldSelectionStart, this.oldSelectionEnd);
          }
    };

	$(".woocommerce_order_items_wrapper .serial-number-manage-div").each(function(){
		$min 	= $(this).find("input.serial-min-range").clone(true);
		$max 	= $(this).find("input.serial-max-range").clone(true);
		$itemID = $(this).find("input.serial-max-range").attr("data-item-key");

		$(this).find("input.serial-min-range").remove();
		$(this).find("input.serial-max-range").remove();

		$('table.woocommerce_order_items tbody#order_line_items tr.item').each(function(){
			if ($(this).attr('data-order_item_id') == $itemID) {
				var row = $("table.woocommerce_order_items").find('.order_item_id[value="' + $itemID + '"]').closest('tr');
				var quantity = parseInt($(this).find('input.quantity').val());
				var index 	 = 0;
				var minDiv 	 = $min.clone().attr("name","min_serial_num["+$(this).attr("data-order_item_id")+"][]").wrap('<div/>').parent().html();
				var maxDiv = $max.clone().attr("name","max_serial_num["+$(this).attr("data-order_item_id")+"][]").wrap('<div/>').parent().html();
				var tt = "<tr><td colspan='6'><h4>Serial Number Range "+row.find('.wc-order-item-name').text()+"</h4>";

				while(index < quantity){
					tt += "<div class='custom-combobox'>"+minDiv+"&nbsp;&nbsp;&nbsp;"+maxDiv+"</div></br>";
					index++;
				}
				tt += "</td></tr>";
				$(this).after(tt);
			}
		})
	})

	$(".woocommerce_order_items_wrapper .serial-number-manage-div-idtag").each(function(){
		console.log("serial-number-idtag");
		$serial = $(this).find("input.serial-number-idtag").clone(true);
		$itemID = $(this).find("input.serial-number-idtag").attr("data-item-key");

		$(this).find("input.serial-number-idtag").remove();

		$('table.woocommerce_order_items tbody#order_line_items tr.item').each(function(){
			if ($(this).attr('data-order_item_id') == $itemID) {
				var row = $("table.woocommerce_order_items").find('.order_item_id[value="' + $itemID + '"]').closest('tr');
				var quantity  = parseInt($(this).find('input.quantity').val());
				var index 	  = 0;
				var serialDiv = $serial.clone().attr("name","serial_num_idtag["+$(this).attr("data-order_item_id")+"][]").wrap('<div/>').parent().html();
				var tt = "<tr><td colspan='6'><h4>Serial Number "+row.find('.wc-order-item-name').text()+"</h4>";
				
				while(index < quantity){
					tt += "<div class='custom-combobox'>"+serialDiv+"</div></br>";
					index++;
				}
				tt += "</td></tr>";
				$(this).after(tt);
			}
		})
	})

	$("body.post-type-shop_order").on("submit","form#post",function(e){
		var check 	= 0;
		var maxNum	= parseInt($("#max-number-h").text());
		var maxSerl	= parseInt($("#smart-tag-max-number-h").text());
		console.log(maxSerl);
		$("input.serial-min-range").each(function(i){
			var minValue1 = parseInt($(this).val());
			var cusMinVal = parseInt($(this).val());
			$(this).parent().find("span.err").remove();
			if ($.trim($(this).val()) == "") {
				$(this).after("<span class='err' style='color:red;'>These fields are required.</span>");
				check = 1;
			}else if(cusMinVal.toString().length != 15){
				$(this).after("<span class='err' style='color:red;'>This serial number is not valid. Please use the 15 digit serial number.</span>");
				check = 1;
			}else if (minValue1 != "") {
				console.log(minValue1,maxNum);
				if (minValue1 <= maxNum) {
					console.log(maxNum,minValue1);
					$(this).after("<span class='err' style='color:red;'>Please enter serial number greater than "+maxNum+" Number.</span>");
					check = 1;
					$('#woocommerce-order-items').find('span.err:first').attr("id","scroll-to");
					$('html, body').animate({
				        scrollTop: $("#scroll-to").parents("tr").offset().top
				    }, 200);
					return false;
				}
				maxNum = minValue1;
				$("input.serial-max-range").each(function(j){
					if (i == j) {
						$(this).parent().find("span.err").remove();
						var maxValue1 = parseInt($(this).val());
						var cusMaxVal = parseInt($(this).val());
						console.log(cusMaxVal.toString().length);
						if ($.trim($(this).val()) == "") {
							check = 1;
							$(this).after("<span class='err' style='color:red;'>These fields are required.</span>");
						}else if(cusMaxVal.toString().length != 15){
							$(this).after("<span class='err' style='color:red;'>This serial number is not valid. Please use the 15 digit serial number.</span>");
							check = 1;
						}else{
							if (maxValue1 <= maxNum) {
								console.log("Jain",maxNum,maxValue1);
								$(this).after("<span class='err' style='color:red;'>Please enter serial number greater than "+maxNum+" Number.</span>");
								check = 1;
								$('#woocommerce-order-items').find('span.err:first').attr("id","scroll-to");
								$('html, body').animate({
							        scrollTop: $("#scroll-to").parents("tr").offset().top
							    }, 200);
								return false;
							}
							maxNum = maxValue1;
						}
						return false;
					}else if ($.trim($(this).val()) == ""){
						check = 1;
						$(this).after("<span class='err' style='color:red;'>These fields are required.</span>");
					}
				});				
			}
		});

		$("input.serial-number-idtag").each(function(i){
			var serialNum = parseInt($(this).val());
			var cuserlNum = parseInt($(this).val());
			$(this).parent().find("span.err").remove();
			if ($.trim($(this).val()) == "") {
				$(this).after("<span class='err' style='color:red;'>These fields are required.</span>");
				check = 1;
			}else if(cuserlNum.toString().length != 8){
				$(this).after("<span class='err' style='color:red;'>This serial number is not valid. Please use the 8 digit serial number.</span>");
				check = 1;
			}else if (serialNum != "") {
				if (serialNum <= maxSerl) {
					console.log(maxSerl,serialNum);
					$(this).after("<span class='err' style='color:red;'>Please enter serial number greater than "+maxSerl+" Number.</span>");
					check = 1;
					$('#woocommerce-order-items').find('span.err:first').attr("id","scroll-to");
					$('html, body').animate({
				        scrollTop: $("#scroll-to").parents("tr").offset().top
				    }, 200);
					return false;
				}
				maxSerl = serialNum;
			}
		});


		if (check) {
			$('#woocommerce-order-items').find('span.err:first').attr("id","scroll-to");
			$('html, body').animate({
		        scrollTop: $("#scroll-to").parents("tr").offset().top
		    }, 200);
			return false;
		}
	});

	jQuery("input.serial-min-range").on('focusin', 'input', function(){
	    $(this).data('val', $(this).val());
	}).on("input keydown keyup mousedown mouseup select contextmenu drop", function() {
		var prev = $(this).data('val');
        var tt = /^\d*$/.test($(this).val());
        if (!tt) {
        	$(this).val(prev);
        }
        $(this).data('val', $(this).val());
    });

    jQuery("input.serial-max-range").on('focusin', 'input', function(){
	    $(this).data('val', $(this).val());
	}).on("input keydown keyup mousedown mouseup select contextmenu drop", function() {
		var prev = $(this).data('val');
        var tt = /^\d*$/.test($(this).val());
        if (!tt) {
        	$(this).val(prev);
        }
        $(this).data('val', $(this).val());
    });

    jQuery("input.serial-number-idtag").on('focusin', 'input', function(){
	    $(this).data('val', $(this).val());
	}).on("input keydown keyup mousedown mouseup select contextmenu drop", function() {
		var prev = $(this).data('val');
        var tt = /^\d*$/.test($(this).val());
        if (!tt) {
        	$(this).val(prev);
        }
        $(this).data('val', $(this).val());
    });
    /*jQuery("input.serial-max-range").inputFilter(function(value) {
        return /^\d*$/.test(value);
    });
    jQuery("input.serial-number-idtag").inputFilter(function(value) {
        return /^\d*$/.test(value);
    });*/
});
