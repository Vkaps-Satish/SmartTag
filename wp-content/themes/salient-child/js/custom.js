// BANNER SLIDER JS
jQuery(document).ready(function(){

    /*contact form 7 success message*/
    var wpcf7Elm = document.querySelector( '.wpcf7' );
    if(wpcf7Elm){
        
        wpcf7Elm.addEventListener( 'wpcf7mailsent', function( event ){
            jQuery(".screen-reader-response").fadeIn();
        });
    }

	jQuery("#banner-slider").lightSlider({
	    loop: true,
        mode: 'fade',
        enableTouch: false,
        enableDrag: false,
        freeMove: false
	});
});

// SUBSCIPTION MY ACCOUNT SLIDER JS
jQuery(document).ready(function(){
    jQuery("#subs-my-acc-slider").lightSlider({
        loop: true
    });
    jQuery(".subs-my-acc-slider-wrap .lSAction").appendTo(".subs-my-acc-slider-wrap .lSSlideOuter");
});

// BLOG SLIDER JS
jQuery(document).ready(function(){
	jQuery("#blog-slider").lightSlider({
        mode: 'slide',
	    loop: true,
	    auto: true,
        item: 2,
        responsive : [
            {
                breakpoint:991,
                settings: {
                    item:2,
                    slideMove:1,
                    slideMargin:6,
                  }
            },
            {
                breakpoint:767,
                settings: {
                    item:2,
                    slideMove:1
                  }
            },
            {
                breakpoint:480,
                settings: {
                    item:1,
                    slideMove:1
                  }
            }
        ]
	});
});

// CUSTOM SELECT JS
jQuery(".wpcf7-select").each(function(){
    jQuery(this).parent().addClass("custom-select-wrap");
});
jQuery(document).ready(function() {
    jQuery('.wpcf7-select').niceSelect();
    jQuery("body").click(function(){
        setTimeout(function(){
        jQuery(".wpcf7-select").each(function(){           
            if (jQuery(this).parent().children(".wpcf7-select.open").length) {   
                jQuery(this).parent(".wpcf7-form-control-wrap").addClass("box-opened");
                var select_list_height = jQuery(this).children(".list").outerHeight();  
                jQuery(this).parent(".wpcf7-form-control-wrap").css("height" , select_list_height + 49 + "px");
            } else {
                jQuery(this).parent(".wpcf7-form-control-wrap").removeClass("box-opened");
                var select_list_height = jQuery(this).children(".list").outerHeight();  
                jQuery(this).parent(".wpcf7-form-control-wrap").css("height" , "auto");
            }   
        });
        }, 100);
    });
}); 
jQuery(document).ready(function() {
	jQuery('.custom-select-box').niceSelect();
	jQuery("body").click(function(){
		setTimeout(function(){
		jQuery(".custom-select-box").each(function(){			
			if (jQuery(this).parent().children(".custom-select-box.open").length) {   
				jQuery(this).parent(".custom-select-wrap").addClass("box-opened");
				var select_list_height = jQuery(this).children(".list").outerHeight();  
				jQuery(this).parent(".custom-select-wrap").css("height" , select_list_height + 49 + "px");
			} else {
				jQuery(this).parent(".custom-select-wrap").removeClass("box-opened");
				var select_list_height = jQuery(this).children(".list").outerHeight();  
				jQuery(this).parent(".custom-select-wrap").css("height" , "auto");
			}	
		});
		}, 100);
	});
}); 

// CUSTOM RADIO JS
jQuery(".custom-radio-box").twbsToggleButtons();

// TABS JS
jQuery('.tabGroup').swichTab({
    cahngePanel: 'fade',
    //swiper: true,
    index: 0,
});
jQuery('.tabGroup2').swichTab({
    cahngePanel: 'fade',
    //swiper: true,
    index: 0,
});
jQuery('.tabGroup3').swichTab({
    cahngePanel: 'fade',
    //swiper: true,
    index: 0,
});
jQuery('.tabGroup4').swichTab({
    cahngePanel: 'fade',
    //swiper: true,
    index: 0,
});
jQuery('.tabGroup5').swichTab({
    cahngePanel: 'fade',
    //swiper: true,
    index: 0,
});
jQuery('.tabGroup6').swichTab({
    cahngePanel: 'fade',
    //swiper: true,
    index: 0,
});
jQuery('.tabGroup7').swichTab({
    cahngePanel: 'fade',
    //swiper: true,
    index: 0,
});
jQuery('.tabGroup8').swichTab({
    cahngePanel: 'fade',
    //swiper: true,
    index: 0,
});