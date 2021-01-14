/**
 * @name Multi-step form - WIP
 * @description Prototype for basic multi-step form
 * @deps jQuery, jQuery Validate
 */
jQuery.validator.addMethod("checkSize", function (value, element) {
    if (value != "") {
        var size = element.files[0].size;
        if (size > 2*1000000)// checks the file more than 1 MB
        {
            return false;
        } else {
           return true;
        }
    }else{
        return true;
    }

    }, "File must be less then 2MB");

var app = {

    init: function() {
        this.cacheDOM();
        this.setupAria();
        this.nextButton();
        this.prevButton();
        this.validateForm();
        this.startOver();
        this.editForm();
        this.killEnterKey();
        this.handleStepClicks();
    },
    cacheDOM: function() {
        if (jQuery(".multi-step-form").size() === 0) {
            return;
        }
        // jQuery(".multi-step-form").find("form#profileuser1").html();
        this.$formParent = jQuery(".multi-step-form");
        this.$form = this.$formParent.find("form#profileuser1");
        this.$formStepParents = this.$form.find("fieldset"),

            this.$nextButton = this.$form.find(".btn-next");
        this.$prevButton = this.$form.find(".btn-prev");
        this.$editButton = this.$form.find(".btn-edit");
        this.$resetButton = this.$form.find("[type='reset']");

        this.$stepsParent = jQuery(".steps");
        this.$steps = this.$stepsParent.find("button");
    },

    htmlClasses: {
        activeClass: "active",
        hiddenClass: "hidden",
        visibleClass: "visible",
        editFormClass: "edit-form",
        animatedVisibleClass: "animated fadeIn",
        animatedHiddenClass: "animated fadeOut",
        animatingClass: "animating"
    },
    setupAria: function() {

        // set first parent to visible
        // this.$formStepParents.eq(0).attr("aria-hidden", false);

        // set all other parents to hidden
        this.$formStepParents.not(":first").attr("aria-hidden", true);

        // handle aria-expanded on next/prev buttons
        app.handleAriaExpanded();

    },

    nextButton: function() {
        this.$nextButton.on("click", function(e) {              
            e.preventDefault();
            // grab current step and next step parent
            var $this = jQuery(this),
                currentParent = $this.closest("fieldset"),
                nextParent = currentParent.next();
            if (app.checkForValidForm()) {
                if (jQuery(this).hasClass("custom-check-btn")) {
                    var smartTagID = jQuery('#smartTagID').val();
                    var secondarySmartTagID = jQuery('#secondarySmartTagID').val();
                    if (smartTagID == '' || secondarySmartTagID == '') {
                        jQuery('#smartTagID').parent().find('.error').remove();
                        jQuery('#smartTagID').parent().append('<div class="error">Serial number is not empty.</div>');
                    } else if (smartTagID == secondarySmartTagID) {
                        $.ajax({
                            url: '<?php echo get_site_url(); ?>/wp-admin/admin-ajax.php',
                            type: 'post',
                            data: {
                                'smartTagID': smartTagID,
                                'action': 'checkSmartTagIDValid'
                            },
                            success: function(res) {
                                console.log(res);
                                var result = jQuery.parseJSON(res);
                                // console.log(result.msg);
                                if (result.result == 1) {
                                    jQuery('#smartTagID').parent().find('.error').remove();
                                    alert(nextParent);
                                    currentParent.removeClass(app.htmlClasses.visibleClass);
                                    app.showNextStep(currentParent, nextParent);
                                } else {
                                    jQuery('#smartTagID').parent().find('.error').remove();
                                    jQuery('#smartTagID').parent().append('<div class="error">' + result.msg + '</div>');
                                }
                            },
                        });
                    } else {
                        jQuery('#smartTagID').parent().find('.error').remove();
                        jQuery('#smartTagID').parent().append('<div class="error">Serial number not match.</div>');
                    }
                } else if (jQuery(this).hasClass("custom-next-button")) {
                    var serealNumber = jQuery('input.sereal-number-1').val();
                    var secondarySerealNumber = jQuery('input.sereal-number-2').val();
                    if (serealNumber == '' || secondarySerealNumber == '') {
                        jQuery('input.sereal-number-1').parent().find('.error').remove();
                        jQuery('input.sereal-number-1').parent().append('<div class="error">Serial number is not empty.</div>');
                        return;
                    } else if (serealNumber == secondarySerealNumber) {
                        $.ajax({
                            url: ajaxurl,
                            type: 'post',
                            data: {
                                'action': 'checkSerialNumberValid',
                                'serialNumber': serealNumber
                            },
                            success: function(res) {
                                var result = jQuery.parseJSON(res);
                                console.log(res);
                                if (result.result == 1) {
                                    jQuery('input.sereal-number-1').parent().find('.error').remove();
                                    jQuery('input#created_by').val(result.created_by);
                                    // if the form is valid hide current step
                                    // trigger next step
                                    alert(nextParent);
                                    currentParent.removeClass(app.htmlClasses.visibleClass);
                                    app.showNextStep(currentParent, nextParent);
                                } else {
                                    jQuery('input.sereal-number-1').parent().find('.error').remove();
                                    jQuery('input.sereal-number-1').parent().append('<div class="error">' + result.msg + '</div>');
                                    return;
                                }
                            },
                        });
                    } else {
                        jQuery('input.sereal-number-1').parent().find('.error').remove();
                        jQuery('input.sereal-number-1').parent().append('<div class="error">Serial number not match.</div>');
                        return;
                    }
                } else {
                    // if the form is valid hide current step
                    // trigger next step
                    $("html, body").animate({ scrollTop: 0 }, "slow");
                    currentParent.removeClass(app.htmlClasses.visibleClass);
                    app.showNextStep(currentParent, nextParent);
                }
            }

        });
    },

    prevButton: function() {

        this.$prevButton.on("click", function(e) {
            e.preventDefault();
            // grab current step parent and previous parent
            var $this = jQuery(this),
                currentParent = jQuery(this).closest("fieldset"),
                prevParent = currentParent.prev();

            // hide current step and show previous step
            // no need to validate form here
            $("html, body").animate({ scrollTop: 0 }, "slow");
            currentParent.removeClass(app.htmlClasses.visibleClass);
            app.showPrevStep(currentParent, prevParent);

        });
    },

    showNextStep: function(currentParent, nextParent) {

        // hide previous parent
        currentParent
            .addClass(app.htmlClasses.hiddenClass)
            .attr("aria-hidden", true);

        // show next parent
        nextParent
            .removeClass(app.htmlClasses.hiddenClass)
            .addClass(app.htmlClasses.visibleClass)
            .attr("aria-hidden", false);

        // focus first input on next parent
        nextParent.focus();

        // activate appropriate step
        app.handleState(nextParent.index());

        // handle aria-expanded on next/prev buttons
        app.handleAriaExpanded();

    },

    showPrevStep: function(currentParent, prevParent) {

        // hide previous parent
        currentParent
            .addClass(app.htmlClasses.hiddenClass)
            .attr("aria-hidden", true);

        // show next parent
        prevParent
            .removeClass(app.htmlClasses.hiddenClass)
            .addClass(app.htmlClasses.visibleClass)
            .attr("aria-hidden", false);

        // send focus to first input on next parent
        prevParent.focus();

        // activate appropriate step
        app.handleState(prevParent.index());

        // handle aria-expanded on next/prev buttons
        app.handleAriaExpanded();

    },

    handleAriaExpanded: function() {

        /*
            Loop thru each next/prev button
            Check to see if the parent it conrols is visible
            Handle aria-expanded on buttons
        */
        jQuery.each(this.$nextButton, function(idx, item) {
            var controls = jQuery(item).attr("aria-controls");
            if (jQuery("#" + controls).attr("aria-hidden") == "true") {
                jQuery(item).attr("aria-expanded", false);
            } else {
                jQuery(item).attr("aria-expanded", true);
            }
        });

        jQuery.each(this.$prevButton, function(idx, item) {
            var controls = jQuery(item).attr("aria-controls");
            if (jQuery("#" + controls).attr("aria-hidden") == "true") {
                jQuery(item).attr("aria-expanded", false);
            } else {
                jQuery(item).attr("aria-expanded", true);
            }
        });

    },

    validateForm: function() {
        
        // jquery validate form validation
        this.$form.validate({
            ignore: ".ignore",
            
            errorPlacement: function(error, element) {
                if (element.attr("name") == "terms") {
                    error.appendTo('#agreeValidate');
                    return true;
                }
                error.insertAfter(element);
            },
            rules: {
                files:{
                    required: false,
                    extension: "jpg|png|gif|bmp|jpeg",
                    checkSize: true
                },
                universal_microchip_id:
                {
                    required: true,
                    minlength: 10,
                    maxlength: 15,
                    "remote":
                    {
                      url: ajaxurl,
                      type: "post",
                      data:
                      {
                         'action' : 'checkUniversalMicrochipId',
                         universalMicrochipID: function(res)
                         {
                             return $('#profileuser1 :input[name="universal_microchip_id"]').val();
                        }
                      }
                    }
                },
                conf_universal_microchip_id: {
                    required: true,
                    equalTo: "#sname_input",
                    minlength: 10,
                    maxlength: 15,
                }
                ,microchip_id:
                {
                    required: true,
                    minlength: 15,
                    maxlength: 15,
                    "remote":
                    {
                      url: ajaxurl,
                      type: "post",
                      data:
                      {
                         'action' : 'checkMicrochipIDValid1',
                         smartTagID: function(res)
                         {
                             return $('#profileuser1 :input[name="microchip_id"]').val();
                        }
                      }
                    }
                },
                conf_microchip_id: {
                    required: true,
                    equalTo: "#sname_input",
                    minlength: 15,
                    maxlength: 15,
                },
                smarttag_id_number: {
                    required: true,
                    minlength: 8,
                    maxlength: 8,
                    "remote":
                    {
                      url: ajaxurl,
                      type: "post",
                      data:
                      {
                         'action' : 'checkSmartTagIDValid_testing',
                         smartTagID: function()
                         {
                          return $('#profileuser1 :input[name="smarttag_id_number"]').val();
                         }
                      }
                    }
                },
                p_state:{
                    required: true,
                },
                p_country:{
                    required: true,
                },
                p_add1:{
                    required: true,
                },
                p_city:{
                    required: true,
                },
                p_email:{
                    email: true,
                     "remote":
                    {
                      url: ajaxurl,
                      type: "post",
                      data:
                      {
                         'action' : 'checkEmailExist',
                         userEmail: function()
                         {
                          return $('#profileuser1 :input[name="p_email"]').val();
                         }
                      }
                    }
                },
                conf_smarttag_id_number: {
                    required: true,
                    equalTo: "#sname_input",
                    minlength: 8,
                    maxlength: 8,
                },
                p_zipcode: {
                    required: true,
                    number: true,
                    minlength: 5,
                    maxlength: 5
                },
                p_prm_no: {
                    required: true,
                    number: true,
                    minlength: 10,
                    maxlength: 10,
                    "remote":
                    {
                      url: ajaxurl,
                      type: "post",
                      data:
                      {
                         'action' : 'checkPrimaryExists',
                         priary_phone: function()
                         {
                          return $('#profileuser1 :input[name="p_prm_no"]').val();
                         }
                      }
                    }
                },
                p_sec_no: {
                    number: true,
                    minlength: 10,
                    maxlength: 10
                },
                s_prm_no: {
                    number: true,
                    minlength: 10,
                    maxlength: 10
                },
                s_sec_no: {
                    number: true,
                    minlength: 10,
                    maxlength: 10
                },
                s_zipcode :{
                    number: true,
                    minlength: 5,
                    maxlength: 5
                },
                vaterinarian_primary_phone_number: {
                    number: true,
                    minlength: 10,
                    maxlength: 10
                },
                vaterinarian_secondary_phone_number: {
                    number: true,
                    minlength: 10,
                    maxlength: 10
                },
                vaterinarian_zip_code :{
                    number: true,
                    minlength: 5,
                    maxlength: 5
                },
                attribute_pa_ttype:{
                    required:true
                },protectionPlan:{
                    required:true
                }
            },
            messages: {
                microchip_id : {
                    minlength : "The Microchip Id Number must be 15 digits.",
                    maxlength : "The Microchip Id Number must be 15 digits.",
                    remote: "This ID is not valid",
                },
                conf_microchip_id : {
                    minlength : "The Microchip Id Number must be 15 digits.",
                    maxlength : "The Microchip Id Number must be 15 digits.",
                },
                smarttag_id_number: {
                    remote: "This ID is not valid",
                    minlength : "The SmartTag Id must be 8 digits.",
                    maxlength : "The SmartTag Id must be 8 digits.",
                },
                conf_smarttag_id_number: {
                    minlength : "The SmartTag Id must be 8 digits.",
                    maxlength : "The SmartTag Id must be 8 digits.",
                },
                universal_microchip_id: {
                    minlength : "The universal Microchip Id must be 10-15 digits.",
                    maxlength : "The universal Microchip Id must be 10-15 digits.",
                    remote: "This ID is not valid, it's already used by another owner.",
                },
                conf_universal_microchip_id: {
                    minlength : "The universal Microchip Id must be 10-15 digits.",
                    maxlength : "The universal Microchip Id must be 10-15 digits.",
                },
              // microchip_id: {remote: "This ID is not valid"},
                p_prm_no: {
                    minlength : "The phone number must be 10 digits.",
                    maxlength : "The phone number must be 10 digits.",
                    remote: "This phone number already exists"
                },
                p_sec_no: {
                    minlength : "The phone number must be 10 digits.",
                    maxlength : "The phone number must be 10 digits.",
                },
                s_prm_no: {
                        minlength : "The phone number must be 10 digits.",
                        maxlength : "The phone number must be 10 digits.",
                },
                s_sec_no: {
                        minlength : "The phone number must be 10 digits.",
                        maxlength : "The phone number must be 10 digits.",
                },
                vaterinarian_primary_phone_number: {
                        minlength : "The phone number must be 10 digits.",
                        maxlength : "The phone number must be 10 digits.",
                },
                vaterinarian_secondary_phone_number: {
                        minlength : "The phone number must be 10 digits.",
                        maxlength : "The phone number must be 10 digits.",
                },
                p_zipcode: {
                        minlength : "The Zipcode must be 5 digits.",
                        maxlength : "The Zipcode must be 5 digits.",
                },
                s_zipcode: {
                        minlength : "The Zipcode must be 5 digits.",
                        maxlength : "The Zipcode must be 5 digits.",
                },
                vaterinarian_zip_code: {
                        minlength : "The Zipcode must be 5 digits.",
                        maxlength : "The Zipcode must be 5 digits.",
                },
                p_email : {
                    // remote: "The email Id already exists.",
                    remote: "The Email already exists,<a id='loginform' href='javascript:void(0)'> Click here to login. </a>",
                },
                protectionPlan:{
                    required: "Protection plan is compulsary for Universal Microchip, Please choose one.",
                }
            },
            ignore: ":hidden", // any children of hidden desc are ignored
            errorElement: "span", // wrap error elements in span not label
            invalidHandler: function(event, validator) { // add aria-invalid to el with error
                jQuery.each(validator.errorList, function(idx, item) {
                    if (idx === 0) {
                        jQuery(item.element).focus(); // send focus to first el with error
                    }
                    jQuery(item.element).attr("aria-invalid", true); // add invalid aria
                })
            },
            submitHandler: function(f) {
                $('#output').text('');
                $('.loader-wrap').fadeIn();

                // steps form data of smartTag      
                var productId = new FormData();     
                var fd = new FormData();
                var ufd = new FormData();
                var insfd = new FormData();
                var petAramnt = new FormData();
                var cusPro = new FormData();
                var subplan = new FormData();
                var files_data = $('#profileuser1 .files-data');
                var data = "";
                window.resResult = new Array();
                window.UsrID = null;
                // Loop through each data and create an array file[] containing our files data.

                $.each($(files_data), function(i, obj) {
                    $.each(obj.files, function(j, file) {
                        fd.append('files[' + j + ']', file);
                    })
                });

                // our AJAX identifier
                ufd.append('action', 'new_register_user');
                fd.append('action', 'Create_Pet_profile');

                // insfd.append('action', 'Pet_Insurance');
                // petAramnt.append('action', 'Pet_Arrangement');
                cusPro.append('action', 'add_id-tag_into_cart');
                
                // USER AND PET PROFILE DATA
                $.each($('#profileuser1 .text-data'), function() {
                    fd.append($(this).attr('name'), $(this).val());
                });


                $.each($('#profileuser1 .user-data'), function() {
                    ufd.append($(this).attr('name'), $(this).val());
                });

                /* ADD ACTION TO ADD PRODICT */
                productId.append('action', 'productAddToCart');

                /* CUSTOM PRODUCT DATA*/
                

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
                        'action': 'add_id-tag_into_cart',
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
                        'action': 'add_id-tag_into_cart',
                        'engraving_back_line_1':$("#back_line1").text(),
                        'engraving_back_line_2': $("#back_line2").text(),
                        'engraving_back_line_3': $("#back_line3").text(),
                    };
                }

                // Pet Arrangment
                if ($('#PetArg').attr("checked") == 'checked') {
                    $.each($('#profileuser1 .protectArg'), function() {
                        // petAramnt.append($(this).attr('name'), $(this).val());
                        productId.append($(this).attr('name'), $(this).val());
                    });
                }
                
                //Pet insurance
                if ($('#heth_id').attr("checked") == 'checked') {    
                    $.each($('#profileuser1 .PetInsurance'), function() {
                        // insfd.append($(this).attr('name'), $(this).val());
                        productId.append($(this).attr('name'), $(this).val());
                    });
                }
                    
                //Add Subscriptions
                if ($('#profileuser1 .site-btn').hasClass('AddSubscription')) {
                    $.each($('#profileuser1 .AddSubscription'), function() {
                        productId.append($(this).attr('filed'), $(this).attr('proid'));
                    });
                }    

                if ($('#profileuser1 #u-first').attr('value') != '') {
                    $('.popup-content').empty();
                    $.ajax({
                        type: 'POST',
                        url: ajaxurl,
                        data: ufd,
                        contentType: false,
                        processData: false,
                        success: function(response) {
                            var Obj = JSON.parse(response);
                            resResult.push(Obj.message);
                            window.UsrID = Obj.usrId;
                            fd.append('userId', window.UsrID);
                            if ($('#profileuser1 #sname_input').attr('value') != '' && window.UsrID !=null) {
                                $.ajax({
                                    type: 'POST',
                                    url: ajaxurl,
                                    data: fd,
                                    contentType: false,
                                    processData: false,
                                    success: function(response) {
                                        var Obj = JSON.parse(response);
                                        resResult.push(Obj.message);
                                        var petId = Obj.petId;
                                        productId.append("petId",petId);
                                        var type = "";
                                        if ($("input[name=universalMicrochip]").val() == 1) {
                                            type = "universal microchip";
                                        }
                                        productId.append("formType",type);
                                        if (petId != 0) {
                                            $.ajax({
                                                type: 'POST',
                                                url: ajaxurl,
                                                data: productId,
                                                contentType: false,
                                                processData: false,
                                                success: function(response) {
                                                    var Obj = JSON.parse(response);
                                                    resResult.push(Obj.message);
                                                }
                                            });
                                            if ($('#CustPro').attr("checked") == 'checked') {
                                                $.ajax({
                                                    type: 'POST',
                                                    url: ajaxurl,
                                                    data: data,
                                                    success: function(response) {
                                                        console.log('custom' + response);
                                                        var Obj = JSON.parse(response);
                                                        resResult.push(Obj.message);
                                                    }
                                                });
                                            }
                                        }
                                    }
                                });
                            }
                        },
                        complete: function(response) {
                            console.log(resResult);
                            setTimeout(function() {
                                    $('.loader-wrap').fadeOut();
                                    if(window.UsrID != null){
                                        $('#closed').attr('href', 'https://prelaunch.idtag.com/cart');  
                                    }
                                    $('.popup-wrap').fadeIn(function() {
                                        $.each(resResult, function(i, v) {
                                            $('.popup-content').append(resResult[i]);

                                        });
                                    });
                                
                            }, 10000);
                        // }else{
                        //  alert("sorry");
                        // }
                        }
                    });
                }

            }
        });
    },

    checkForValidForm: function() {
        if (this.$form.valid()) {
            return true;
        }
    },

    startOver: function() {

        var $parents = this.$formStepParents,
            $firstParent = this.$formStepParents.eq(0),
            $formParent = this.$formParent,
            $stepsParent = this.$stepsParent;

        this.$resetButton.on("click", function(e) {

            // hide all parents - show first
            $parents
                .removeClass(app.htmlClasses.visibleClass)
                .addClass(app.htmlClasses.hiddenClass)
                .eq(0).removeClass(app.htmlClasses.hiddenClass)
                .eq(0).addClass(app.htmlClasses.visibleClass);

            // remove edit state if present
            $formParent.removeClass(app.htmlClasses.editFormClass);

            // manage state - set to first item
            app.handleState(0);

            // reset stage for initial aria state
            app.setupAria();

            // send focus to first item
            setTimeout(function() {
                $firstParent.focus();
            }, 200);

        }); // click

    },

    handleState: function(step) {

        this.$steps.eq(step).prevAll().removeAttr("disabled");
        this.$steps.eq(step).addClass(app.htmlClasses.activeClass);

        // restart scenario
        if (step === 0) {
            this.$steps
                .removeClass(app.htmlClasses.activeClass)
                .attr("disabled", "disabled");
            this.$steps.eq(0).addClass(app.htmlClasses.activeClass)
        }

    },

    editForm: function() {
        var $formParent = this.$formParent,
            $formStepParents = this.$formStepParents,
            $stepsParent = this.$stepsParent;

        this.$editButton.on("click", function() {
            $formParent.toggleClass(app.htmlClasses.editFormClass);
            $formStepParents.attr("aria-hidden", false);
            $formStepParents.eq(0).find("input").eq(0).focus();
            app.handleAriaExpanded();
        });
    },

    killEnterKey: function() {
        jQuery(document).on("keypress", ":input:not(textarea,button)", function(event) {
            return event.keyCode != 13;
        });
    },

    handleStepClicks: function() {

        var $stepTriggers = this.$steps,
            $stepParents = this.$formStepParents;

        $stepTriggers.on("click", function(e) {

            e.preventDefault();

            var btnClickedIndex = jQuery(this).index();

            // kill active state for items after step trigger
            $stepTriggers.nextAll()
                .removeClass(app.htmlClasses.activeClass)
                .attr("disabled", true);

            // activate button clicked
            jQuery(this)
                .addClass(app.htmlClasses.activeClass)
                .attr("disabled", false)

            // hide all step parents
            $stepParents
                .removeClass(app.htmlClasses.visibleClass)
                .addClass(app.htmlClasses.hiddenClass)
                .attr("aria-hidden", true);

            // show step that matches index of button
            $stepParents.eq(btnClickedIndex)
                .removeClass(app.htmlClasses.hiddenClass)
                .addClass(app.htmlClasses.visibleClass)
                .attr("aria-hidden", false)
                .focus();

        });

    }

};

app.init();

