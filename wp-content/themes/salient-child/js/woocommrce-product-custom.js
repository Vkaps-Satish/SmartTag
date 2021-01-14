jQuery(document).ready(function($){
	if($("#pa_size").val() == "small"){
		$(".style-pro .design-box .woo-complex-custom-prod-img img").css("width", "75%");
	}else{
		$(".style-pro .design-box .woo-complex-custom-prod-img img").css("width", "100%");
	}

	$("body").on("change", "#picker_pa_size ul input[type=radio]", function(){
		if($(this).val() == "small"){
			$(".style-pro .design-box .woo-complex-custom-prod-img img").css("width", "75%");
		}else{
			$(".style-pro .design-box .woo-complex-custom-prod-img img").css("width", "100%");
		}
	});

	$("tr.cart_item").each(function(){
		console.log($(this).find("dl.variation dd.variation-SelectSize").text().toLowerCase());
		if($.trim($(this).find("dl.variation dd.variation-SelectSize").text().toLowerCase()) == 'small'){
			console.log("small");
			$(this).find("td.product-thumbnail img").attr('style', 'width: 75% !important');
		}else{
			$(this).find("td.product-thumbnail img").attr('style', 'width: 100% !important');
		}
	})
})