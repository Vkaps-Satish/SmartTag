<?php 
/*
* Template Name: Pet Professional Register Brand Microchip
*/
//U8wAg&VlE_,0
//fh?j]B!7$#Fc
get_header(); 

//Redirect user if user not login or not petprofessional
if ( is_user_logged_in() ){
    $current_user = wp_get_current_user();
    $roles = $current_user->roles;  
     // print_r($roles);die;
    if( !$roles == 'pet_professional' || !in_array( 'pet_professional', $roles )){
        print('<div><div class="not-found-text width-100">This page is only for Pet-Professionals..</div></div>');
        die();
    }       
}else{
    print('<script>window.location.href="'.get_option('siteurl').'/pet-professionals-signup"</script>
            ');
    exit();    
}
    
$countries_obj  = new WC_Countries();
$countries      = $countries_obj->__get('countries');
?>
<div class="container-wrap">        
    <div class="container main-content">
        <div class="row">
            <div class="woo-sidebar col-sm-3">
                 <!-- <h3 class="widgettitle">Pet Professional</h3> -->
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
                <div class="page-heading">
                    <h1>Register Any Brand Microchip in Universal Registry</h1>
                </div>
                <form id="RegBrndMicrochip" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="action" value="Create_mul_Pet_profile">
                    <div class="site-tabs-wrap main-div">
                        <div class="acc-blue-box">
                            <div class="acc-blue-head">
                                Pet Owner <span class="owner-number">1</span>
                            </div>
                            <div class="acc-blue-content">
                                <!--    <div class="row"> -->
                                <div class="contact-form sec-cont-info">
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
                                            </div>
                                        </div>
                                    </div>
                                    <div class="field-wrap three-fields-wrap">
                                        <div class="field-div">
                                            <label>*First Name: </label>
                                            <input type="text" name="first_name" placeholder="First Name" class="user-data first-name rq"/>
                                        </div>
                                        <div class="field-div">
                                            <label>*Last Name: </label>
                                            <input type="text" name="last_name" placeholder="Last Name" class="user-data last-name rq"/>
                                        </div>
                                        <div class="field-div">
                                            <label>*Phone Number: </label>
                                            <input type="text" name="primary_home_number" placeholder="Phone Number" class="user-data phone-number rq check-validate-phone"/>
                                            <input type="hidden" name="primary_home_number_code" placeholder="Phone Number" class="user-data" />
                                        </div>
                                        <input type="hidden" name="registerOwnerId" value="0">
                                    </div>
                                    <div class="field-wrap two-fields-wrap">
                                        <div class="field-div">
                                            <label>*Email: </label>
                                            <input type="text" name="p_email" placeholder="Enter Email Address" class="user-data email-address rq check-validate-email" value="" />
                                        </div>
                                        <div class="field-div">
                                            <label>*Select Your Country: </label>
                                            <?php 
                                                $countries_obj = new WC_Countries();
                                                $countries = $countries_obj->__get('countries');
                                                echo '<select name="primary_country" class="address-country user-data rq">';
                                                    foreach ($countries as $key => $value) {

                                                        echo '<option value="'.$key.'" >'.$value.'</option>';
                                                    }
                                                echo '</select>';
                                            ?>
                                        </div>
                                    </div>
                                    <div class="field-wrap two-fields-wrap">
                                        <div class="field-div">
                                            <label>*Address: </label>
                                            <input type="text" name="primary_address_line1" placeholder="Address line 1" class="user-data address-line-1 rq"/>
                                        </div>
                                        <div class="field-div">
                                            <label></label>
                                            <input type="text" name="primary_address_line2" placeholder="Address line 2" class="user-data address-line-2"/>
                                        </div>
                                    </div>
                                    <div class="field-wrap three-fields-wrap">
                                        <div class="field-div">
                                            <label>*City: </label>
                                            <input type="text" name="primary_city" placeholder="City" class="user-data address-city rq"/>
                                        </div>
                                        <div class="field-div">
                                            <label class="statevalidate">*State: </label>
                                            <select name="primary_state" class="user-data address-state rq" data-val=""></select>
                                        </div>
                                        <div class="field-div">
                                            <label>*Zip Code: </label>
                                            <input type="text" name="primary_postcode" placeholder="Zipcode" class="user-data address-zip-code rq"/>
                                        </div>
                                    </div>
                                     <div class="field-wrap three-fields-wrap">
                                        <div class="field-div">
                                            <label>Secondary Name: </label>
                                            <input type="text" name="secondary_first_name" placeholder="Secondary Name" class="user-data secondary-first-name"/>
                                        </div>
                                        <div class="field-div">
                                            <label>Secondary Email: </label>
                                            <input type="text" name="secondary_email" placeholder="Secondary Email" class="user-data secondary-email-address"/>
                                        </div>
                                        <div class="field-div">
                                            <label>Secondary Phone Number: </label>
                                            <input type="text" name="primary_cell_number" placeholder="Secondary Phone Number" class="user-data secondary-phone-number check-phone phone-number"/>
                                            <input type="hidden" name="primary_cell_number_code" placeholder="Secondary Phone Number" class="user-data" />
                                        </div>
                                    </div>
                                    <div class="step-accordion">
                                            <div class="contact-form" class="sec-cont-info">
                                                <div class="sections">
                                                    <div class="section">
                                                        <h4 class="step-acc-head">Pet <span class="pet-num">1</span> Information: </h4>
                                                     <div class="field-wrap">    
                                                        <div class="field-div">
                                                            <label>*Select Microchip Company of the Implemented Microchip: </label>
                                                            <select name="microchip_company" class="pet-data fpet microchip-company rq"/>
                                                           <option value="">Select Your Microchip Brand</option>
															<option value="HomeAgain">HomeAgain</option>
															<option value="AKC Reunite">AKC Reunite</option>
															<option value="24 Pet Watch Pet Protection Services">24 Pet Watch Pet Protection Services</option>
															<option value="Pet Link">Pet Link</option>
															<option value="Avid">Avid</option>
															<option value="Found Animals">Found Animals</option>
															<option value="Save This Life">Save This Life</option>
															<option value="911PetChip">911PetChip</option>
															<option value="PetKey">PetKey</option>
															<option value="BC Pet Registry">BC Pet Registry</option>
															<option value="EIDAP">EIDAP</option>
															<option value="Free Pet Chip Registry">Free Pet Chip Registry</option>
															<option value="Furreka">Furreka</option>
															<option value="Homeward Bound Pet">Homeward Bound Pet</option>
															<option value="InfoPET">InfoPET</option>
															<option value="Microchip I.D. Solutions">Microchip I.D. Solutions</option>
															<option value="Microchip ID Systems, Incs.">Microchip ID Systems, Incs.</option>
															<option value="Nanochip ID Inc.">Nanochip ID Inc.</option>
															<option value="National Animal Identification Center">National Animal Identification Center</option>
															<option value="Petstablished">Petstablished</option>
															<option value="I Don’t Know the Microchip Brand">I Don’t Know the Microchip Brand</option>
															<option value="Other... Please type in company name">Other... Please type in company name</option>
														    </select>
                                                        </div>
                                                    </div>
                                                        <div class="field-wrap two-fields-wrap">
                                                            <div class="field-div">
                                                                <label>*Microchip Number: </label>
                                                                <input type="text" name="microchip_id_number" placeholder="Enter Microchip Number" class="pet-data fpet change-pet-cont microchip-number rq serial-number-check" required="" />
                                                            </div>
                                                            <div class="field-div">
                                                                <label>*Re-enter Microchip Number: </label>
                                                                <input type="text" name="ReMicroChipNum rq" placeholder="Re-enter Microchip Number" class="pet-data fpet re-microchip-number serial-number-check-double rq" />
                                                            </div>
                                                        </div>
                                                        <div class="field-wrap three-fields-wrap">
                                                            <div class="field-div">
                                                                <label>*Pet Name: </label>
                                                                <input type="text" name="pet_name" placeholder="Pet Name" class="pet-data fpet change-pet-cont pet-name rq" />
                                                            </div>
                                                            <div class="field-div">
                                                                <label>*Gender: </label>
                                                                <select name="gender" class="pet-data fpet change-pet-cont gender rq" />
                                                                <option value="">Gender</option>    
                                                                <option value="Male">Male</option>
                                                                <option value="Female">Female</option>
                                                                </select>
                                                            </div>  
                                                            <div class="field-div">
                                                                <label>*Pet Type: </label>
                                                                <select name="PetTyp" class="pet-data fpet pet-type rq" />
                                                                <option value="">Type</option>
                                                                <option value="Type1">Type1</option>
                                                                <option value="Type2">Type2</option>
                                                                <option value="Type3">Type3</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    <div class="field-wrap">
                                                        <div class="field-div">
                                                            <label>*Select Universal Microchip Protection Plan: </label>
                                                            <select name="universalchipPln" class="pet-data fpet change-pet-cont protection-plan rq">  
                                                                <option value="6909" price="6.95">Universal Microchip silver 1 Year Plan -$6.95 </option>
                                                                <option value="6910" price="14.95">Universal Microchip silver Lifetime Plan -$14.95 </option>
                                                                <option value="6911" price="9.95">Universal Microchip Gold 1 Year Plan -$9.95 </option>
                                                                <option value="6912" price="29.95">Universal Microchip Gold Lifetime Plan -$29.95 </option>
                                                                <option value="6913" price="19.95">Universal Microchip Platinum 1 Year Plan -$19.95 </option>
                                                                <option value="6914" price="49.95">Universal Microchip Platinum Lifetime Plan -$49.95 </option>
                                                            </select>
                                                        </div>
                                                    </div>    
                                                    <div class="step-acc-content">
                                                        <div class="field-wrap two-fields-wrap">
                                                            <div class="field-div">
                                                                <label>Pet Image:</label>
                                                                <img src="<?php echo get_site_url(); ?>/wp-content/uploads/2019/02/pet-image.jpg" alt="your image" />
                                                            </div>
                                                            <div class="field-div">
                                                                <label class="auto-height"><?php __('Upload Pet Image)', 'cvf-upload'); ?></label>
                                                                <label>Upload Pet Image: (Optional however in the event your pet is lost a picture is very helpful</label>
                                                                <div class="field-notice">Files must be less than 2MB.
                                                                <br>Allowed file types .png/ .gif/ .jpg/ .jpeg</div>
                                                                 <input type = "file" name = "feature" accept = "image/*" class = "files-data form-control pet-data feature pet-image" multiple />

                                                            </div>
                                                        </div>  
                                                        <div class="field-wrap two-fields-wrap">
                                                            <div class="field-div">
                                                                <label>Primary Breed: </label>
                                                                <input type="text" name="primary_breed" placeholder="Enter Primary Breed" class="pet-data fpet primary-breed" />
                                                            </div>
                                                            <div class="field-div">
                                                                <label>Secondary Breed: </label>
                                                                <input type="text" name="secondary_breed" placeholder="Enter Secondary Breed" class="pet-data fpet secondary-breed" />
                                                            </div>
                                                        </div>
                                                        <div class="field-wrap two-fields-wrap">
                                                            <div class="field-div">
                                                                <label>Primary Color: </label>
                                                                <input type="text" name="primary_color" placeholder="Enter Primary Color" class="pet-data fpet primary-color"/>
                                                            </div>
                                                            <div class="field-div">
                                                                <label>Secondary Color(s):</label>
                                                                <input type="text" name="secondary_color" placeholder="Enter Secondary Color(s)" class="pet-data fpet secondary-color"/>
                                                            </div>
                                                        </div>
                                                        <div class="field-wrap two-fields-wrap">
                                                            <div class="field-div">
                                                                <label>Size: </label>
                                                                <!-- <input type="text" name="Size" placeholder="Address line 1" class="pet-data fpet pet-size" /> -->
                                                                <select name="Size" class="pet-data fpet pet-size">
                                                                    <option value="">Select</option>
                                                                    <option value="1">1</option>
                                                                    <option value="2">2</option>
                                                                </select>
                                                            </div>
                                                            <div class="field-div">
                                                                <label>Pet Date of Birth: (optional)</label>
                        <input type="text" name="pet_date_of_birth" autocomplete="off" placeholder="mm/dd/yyyy" class="input-10 input pet-data fpet pet-date-birth">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <h4 class="step-acc-head sec-form"><i class="fa fa-plus"></i> Show Extra Information: </h4>
                                                </div>
                                            </div>
                                            <div class="field-wrap two-fields-wrap">
                                                <div class="field-div">
                                                    <p><button class="addsection1 btn btn-default addPet" type="button"><i class="fa fa-plus"></i> Add Another Pet</button></p>
                                                </div>
                                                <!-- <div class="field-div">
                                                    <button class="site-btn-red petdata fpet section-total" type="button" style="float: right;">Purchase Plan for $6.95</button>
                                                </div> -->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div> 
                        </div>
                    </div>
                </div>
            </form>
            <div class="col-sm-12">
                <div class="header-right">
                    <label>Total:- $<span id="total-count">6.95</span></label>
                </div>
            </div>
            <div class="col-sm-12">
                <div class="header-right">
                    <button class="btn site-btn site-btn-blue add-pet-owner"><i class="fa fa-plus"></i> Add Another Pet Owner</button>
                    <button type="submit" class="site-btn-red save-all"> PURCHASE ALL </button>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
</div>
</div>
<?php get_footer(); ?>
<script type="text/javascript">
    jQuery(document).ready(function ($) {
        $checkPhone = 0;
        $checkEmail = 0;
        $checkPost  = 0;
        var error        = 0;
        var error2       = 0;
        var checkerrori  = 0;
        var checkerrors  = 0;
        var mainDiv  = $('.site-tabs-wrap.main-div').clone(true);
        var template = $('.sections .section:first').clone();
        var Info     = $('#Informations .Information:first').clone();
        var today    = new Date();
        //datepicker
        var today = new Date();
        $("input[name='pet_date_of_birth']").datepicker({
            dateFormat : "mm/dd/yy",
            endDate: "today",
            maxDate: today,
            changeMonth: true,
            changeYear: true,
            onSelect: function () {
                var Pdb = $(this).datepicker('getDate');
                $("#ptdob").text(Pdb);
            }
        });

        jQuery("input[name='primary_home_number']").inputFilter(function(value) {
            return /^\d*$/.test(value);
        });

        jQuery("input[name='primary_cell_number']").inputFilter(function(value) {
            return /^\d*$/.test(value);
        });
        
        jQuery("input[name='microchip_id_number']").inputFilter(function(value) {
            return /^\d*$/.test(value);
        });

        jQuery("input[name='ReMicroChipNum']").inputFilter(function(value) {
            return /^\d*$/.test(value);
        });


        $('body').on('click', '.addsection1', function () {
            var parentLength = $(this).parents(".contact-form.sec-cont-info").find(".sections .section").length+1;
            var sectionTotal = 0;
            var total        = 0;
            template.clone().find('span.pet-num').text(parentLength).end().appendTo($(this).parents(".contact-form.sec-cont-info").find(".sections"));
            $(this).parents(".contact-form.sec-cont-info").find(".sections .section").each(function(){
                sectionTotal += parseFloat($(this).find(".protection-plan option:selected").attr("price"));
            });

            $(this).parents(".contact-form.sec-cont-info").find("button.section-total").text("Purchase Plans for $"+sectionTotal.toFixed(2));
            $("form").find(".section").each(function(){
                total += parseFloat($(this).find(".protection-plan option:selected").attr("price"));
            });
            $("#total-count").text(total.toFixed(2));
        });

        $('body').on('click','.owner-remove',function(){
            var total = 0;

            $(this).parents(".main-div").remove();
            $("form").find(".section").each(function(){
                total += parseFloat($(this).find(".protection-plan option:selected").attr("price"));
            });
            $("#total-count").text(total.toFixed(2));
            if ($(".site-tabs-wrap.main-div").length == 1) {
                return false;
            }
            $(".site-tabs-wrap.main-div:last-child").find('.acc-blue-head').append('<div class="acc-edit owner-edit owner-remove"><i class="fa fa-trash"></i> Remove</div>');
        });

        $("body").on('click','.add-pet-owner',function(){
            $(".site-tabs-wrap.main-div:last-child").find(".acc-edit.owner-edit").remove();
            var total     = 0;
            var divLength = $(".site-tabs-wrap.main-div").length+1;
            var div       = mainDiv.clone().find('.acc-blue-box').each(function(){
                $(this).find('.acc-blue-head').append('<div class="acc-edit owner-edit owner-remove"><i class="fa fa-trash"></i> Remove</div>');
                $(this).find('span.owner-number').text(divLength);
                $(this).find('input[name=existingUser]').attr("name","existingUser-"+divLength);
            }).end();

            div = div.clone().find(".phone-number").each(function(i, input){
                var $this = this;
                var main = $(this).parent().parent();
                main.find(".iti--separate-dial-code").remove();
                main.append($this);
                console.log(main.html());
            }).end();


            div = div.clone().find(".phone-number").each(function(i, input){
                var init = window.intlTelInput(input,{
                    separateDialCode: true,
                });

                input.addEventListener("countrychange", function() {
                    var countryCode = init.getSelectedCountryData();
                    var name = $(input).attr("name")+"_code";
                    console.log(name);
                    $(input).parent().parent().find("input[name="+name+"]").val(countryCode.iso2);
                });
            }).end();

            var today = new Date();
            var newDiv = $("#RegBrndMicrochip").append(div);
            newDiv.find("input[name='pet_date_of_birth']").datepicker({
                dateFormat : "mm/dd/yy",
                endDate: "today",
                maxDate: today,
                changeMonth: true,
                changeYear: true,
                onSelect: function () {
                    var Pdb = $(this).datepicker('getDate');
                    $("#ptdob").text(Pdb);
                }
            });
            enableAutocomplete(newDiv.find('input.live-search-input:last-child'));
            $("form").find(".section").each(function(){
                total += parseFloat($(this).find(".protection-plan option:selected").attr("price"));
            });
            $("#total-count").text(total.toFixed(2));
        });

        $("body").on('change','select[name=universalchipPln]',function(){
            var parentLength = $(this).parents(".contact-form.sec-cont-info").find(".sections .section").length+1;
            var sectionTotal = 0;
            var total        = 0;
    
            $(this).parents(".contact-form.sec-cont-info").find(".sections .section").each(function(){
                sectionTotal += parseFloat($(this).find(".protection-plan option:selected").attr("price"));
            });

            console.log(sectionTotal);

            $(this).parents(".contact-form.sec-cont-info").find("button.section-total").text("Purchase Plans for $"+sectionTotal.toFixed(2));
            $("form").find(".section").each(function(){
                total += parseFloat($(this).find(".protection-plan option:selected").attr("price"));
            });
            $("#total-count").text(total.toFixed(2));
            console.log(total);
        });

        $("body").on('change','.change-pet-cont',function(){
            var val     = $(this).val();    
            var div     = $(this).parent().parent().parent();
            var divNum  = div.index();
            if ($(this).hasClass('microchip-number')) {
                if (divNum == 0) {
                    $(".Information .microchip-number").text(val);
                }else{
                    $(".Information"+divNum+" .microchip-number").text(val);
                }
            }else if ($(this).hasClass('pet-name')) {
                if (divNum == 0) {
                    $(".Information .pet-name").text(val);
                }else{
                    $(".Information"+divNum+" .pet-name").text(val);
                }
            }else if ($(this).hasClass('gender')) {
                if (divNum == 0) {
                    $(".Information .gender").text(val);
                }else{
                    $(".Information"+divNum+" .gender").text(val);
                }
            }else if ($(this).hasClass('protection-plan')) {

                if (divNum == 0) {
                    console.log($(this).find('option:selected').attr('price'));
                    $('#pln').text("Purchase Plan for "+$(this).find('option:selected').attr('price'));
                    $(".Information .protection-plan").text($(this).find('option:selected').text());
                }else{
                    $('#pln'+divNum).text("Purchase Plan for "+$(this).find('option:selected').attr('price'));
                    $(".Information"+divNum+" .protection-plan").text($(this).find('option:selected').text());
                }
            }
        });

        $('.save-all').on('click',function(){
            $('#RegBrndMicrochip').submit();
        });



        /*Start validation*/

        $("body").on("change","input.rq",function(i){
            $(this).parent().find("p.error-p").remove();
            $(this).parent().find("p.error-main").remove();
            if ($(this).val() == "") {
                $(this).after("<p class='error-p error-form'>This field is required!</p>");
            }else if($(this).hasClass('check-validate-phone')){
                if ($(this).val().length == 10) {
                    $(this).parent().find("p.error-p").remove();
                }else{
                    $(this).after("<p class='error-p error-form'>Required 10 digit phone number.</p>");
                }
            }else if ($(this).hasClass('check-validate-email')) {
                if (!validateEmail($(this).val())) {
                    $(this).after("<p class='error-p error-form'>Invalid Email Address.</p>");
                }
            }else if ($(this).hasClass('serial-number-check')) {
                var serialNumber = $(this).val();
                $thisSerial      = $(this);
                var doubleCheck  = $(this).parent().parent().find("input.serial-number-check-double").val();
                var check        = 0;
                $thisSerial.parent().find("p.error-p").remove();
                $thisSerial.parent().find("p.error-main").remove();

                $("input.serial-number-check").each(function(){
                    if (serialNumber == $(this).val()) {
                        check++;
                    }
                });

                if (check > 1) {
                    $thisSerial.after("<p class='error-main error-form'>This Microchip Number already used in another form. Please check it.</p>");
                    error = 1;
                    return;
                }else{
                    error = 0;
                }

                if (serialNumber != "") {
                    if (serialNumber.length >= 10 && serialNumber.length <= 15) {
                        $.ajax({
                            type: 'POST',
                            url: ajaxurl,
                            data: {"action":"checkUniversalMicrochipId","universalMicrochipID":serialNumber},
                            success: function(rs) {
                                console.log($.trim(rs));
                                if ($.trim(rs) == "false") {
                                    error = 1;  
                                    console.log("false");
                                    $thisSerial.after("<p class='error-main error-form'>This Microchip Number has already register.</p>");
                                }else{
                                    $thisSerial.parent().find("p.error-main").remove();
                                    error = 0;
                                    var secondSerial = $thisSerial.parent().parent().find("input.serial-number-check-double").val();
                                    $thisDoubleNumb  = $thisSerial.parent().parent().find("input.serial-number-check-double");
                                    $thisDoubleNumb.parent().find("p.error-main").remove();
                                    if (serialNumber != secondSerial && secondSerial != '') {
                                        $thisDoubleNumb.after("<p class='error-main error-form'>Microchip Number and Re-enter Microchip Number are not matching.</p>");
                                        error = 1;
                                        return;
                                    }
                                }
                            }
                        });
                    }else{
                        $thisSerial.after("<p class='error-main error-form'>Microchip Number is invalid. Only 10 to 15 characters number will be acceptable.</p>");
                        error = 1;
                    }
                }else{
                    error = 1;
                }
            }
            if ($(this).hasClass('serial-number-check-double')) {
                var serialNumber = $(this).val();
                $thisDoubleNumb  = $(this);
                var doubleCheck  = $(this).parent().parent().find("input.serial-number-check").val();
                $thisDoubleNumb.parent().find("p.error-p").remove();
                $thisDoubleNumb.parent().find("p.error-main").remove();
                if (doubleCheck != "") {
                    if (doubleCheck != serialNumber) {
                        $thisDoubleNumb.after("<p class='error-main error-form'>Microchip Number and Re-enter Microchip Number are not matching.</p>");
                        error = 1;
                        return;
                    }else{
                        $thisDoubleNumb.parent().find("p.error-main").remove();
                        error = 0;
                    }
                }else{
                    error = 1;
                }
            }
        });

        $("body").on("change","select.rq",function(i){
            $(this).parent().find("p.error-p").remove();
            $(this).parent().find("p.error-p").remove();
            if ($(this).val() == "") {
                $(this).after("<p class='error-p error-form'>This field is required!</p>");
            }
        });

        function readUrlForMultipleForm(input,src) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
            
                reader.onload = function (e) {
                    src.attr('src', e.target.result);
                }
            
                reader.readAsDataURL(input.files[0]);
            }else{
                src.attr('src', "<?php echo get_site_url(); ?>/wp-content/uploads/2019/02/pet-image.jpg");
            }
        }

        $("body").on("change","input[type='file']",function(){
            readUrlForMultipleForm(this,$(this).parent().parent().find("img"));
        });


        $("body").on("change","input.check-validate-phone",function(){
            var phone = $(this).val();
            $thisPhon = $(this);
            var check = 0;
            $thisPhon.parent().find("p.error-p").remove();
            $thisPhon.parent().find("p.error-main").remove();


            $("input.check-validate-phone").each(function(){
                if ($(this).val().length != 10) {
                    $(this).after("<p class='error-p error-form'>Required 10 digit phone number.</p>");
                }else if (phone == $(this).val()) {
                    check++;
                }
            });

            if (check > 1) {
                $thisPhon.after("<p class='error-main error-form'>This phone number already used in another form. Please check it.</p>");
                error = 1;
                return;
            }else{
                error = 0;
            }

            if (phone.length == 10) {
                var ownerId = $(this).next("input[name=registerOwnerId]").val();
                $.ajax({
                    type: 'POST',
                    url: ajaxurl,
                    data: {"action":"checkUserPhoneExist","primary_phone_number":phone,"ownerId":ownerId},
                    success: function(rs) {
                        rs = jQuery.parseJSON(rs);
                        if (rs.success == 1) {
                            error = 1;
                            $thisPhon.after("<p class='error-main error-form'>This phone number already exist.</p>");
                        }else{
                            error = 0;
                            $thisPhon.parent().find("p.error-main").remove();
                        }
                    }
                });
            }
        });  

        $("body").on("change","input.check-validate-email",function(){
            var email = $(this).val();
            $thisemail= $(this);
            var check = 0;
            $thisemail.parent().find("p.error-p").remove();
            $thisemail.parent().find("p.error-main").remove();

            $("input.check-validate-email").each(function(){
                if (email == $(this).val()) {
                    check++;
                }
            });

            if (check > 1) {
                $thisemail.after("<p class='error-main error-form'>This email already used in another form. Please check it.</p>");
                error = 1;
                return;
            }else{
                error = 0;
            }

            if (validateEmail(email)) {
                $.ajax({
                    type: 'POST',
                    url: ajaxurl,
                    data: {"action":"checkUserExist","p_email":email},
                    success: function(rs) {
                        rs = jQuery.parseJSON(rs);
                        if (rs.success == 0) {
                            error = 1;
                            $thisemail.after("<p class='error-main error-form'>This email already exist.</p>");
                        }else{
                            $thisemail.parent().find("p.error-main").remove();
                            error = 0;
                        }
                    }
                });
            }else if(email != ""){
                $thisemail.after("<p class='error-main error-form'>Invalid Email Address.</p>");
                error = 1;
            }
        });


        $('body').on("change","input.check-phone",function(){
            var secPhone = $(this).val();
            if (secPhone != '') {
                if (secPhone.length == 10) {
                    $(this).parent().find("p.error-p").remove();
                }else{
                    $(this).parent().find("p.error-p").remove();
                    $(this).after("<p class='error-p error-form'>Required 10 digit phone number.</p>");
                    checkError = 1;
                }
            }
        });

        $('body').on("change","input.check-email",function(){
            var secEmail = $(this).val();
            if (secEmail != '') {
                if (validateEmail(secEmail)) {
                    $(this).parent().find("p.error-p").remove();
                }else{
                    $(this).parent().find("p.error-p").remove();
                    $(this).after("<p class='error-p'>Invalid Email Address.</p>");
                    checkError = 1;
                }
            }
        });

        $('body').on("change","input[name=primary_postcode]",function(){
            var postcode = $(this).val();
            if (postcode != '') {
                if (postcode.length == 5) {
                    $(this).parent().find("p.error-p").remove();
                }else{
                    $(this).parent().find("p.error-p").remove();
                    $(this).after("<p class='error-p error-form'>Required only 5 digit zip code</p>");
                    checkError = 1;
                }
            }
        }); 

        $('body').on('change', 'input[type=file]', function(){
            $(this).parent().find("p.error-p").remove();
            var fileSize = $(this)[0].files[0].size;
            var fileType = $(this)[0].files[0].type;
            if (fileSize > 0) {
                if(fileSize > 2000000) {
                    checkError = 1;
                    $(this).after("<p class='error-p error-form'>File size is greater than 2MB.</p>");
                }else{
                    checkError = 1;
                    var ext = $(this).val().split('.').pop().toLowerCase();
                    if($.inArray(ext, ['gif','png','jpg','jpeg']) == -1) {
                        $(this).after("<p class='error-p error-form'>Uploaded file is not a valid image. Only JPG, PNG, JPEG and GIF files are allowed.</p>");
                    }
                }
            }
        })

        /*End validation*/

        

        $('#RegBrndMicrochip').on('submit', function (e) {
            e.preventDefault();

            /*Errer check */

            var checkError = 0;
            $("body").find("input.rq").each(function(i){
                $(this).parent().find("p.error-p").remove();
                if ($(this).val() == "") {
                    $(this).after("<p class='error-p error-form'>This field is required!</p>");
                    checkError = 1;
                }else if($(this).hasClass('check-validate-phone')){
                    if ($(this).val().length == 10) {
                        $(this).parent().find("p.error-p").remove();
                    }else{
                        $(this).after("<p class='error-p error-form'>Required 10 digit phone number.</p>");
                        checkError = 1;
                    }
                }else if ($(this).hasClass('check-validate-email')) {
                    if (!validateEmail($(this).val())) {
                        $(this).after("<p class='error-p error-form'>Invalid Email Address.</p>");
                        checkError = 1;
                    }
                }
            });

            $('body').find('input[type=file]').each(function(){
                if ($(this).val() != "") {
                    $(this).parent().find("p.error-p").remove();
                    var fileSize = $(this)[0].files[0].size;
                    var fileType = $(this)[0].files[0].type;
                    if (fileSize > 0) {
                        if(fileSize > 2000000) {
                            checkError = 1;
                            $(this).after("<p class='error-p error-form'>File size is greater than 2MB.</p>");
                        }else{
                            checkError = 1;
                            var ext = $(this).val().split('.').pop().toLowerCase();
                            if($.inArray(ext, ['gif','png','jpg','jpeg']) == -1) {
                                $(this).after("<p class='error-p error-form'>Uploaded file is not a valid image. Only JPG, PNG, JPEG and GIF files are allowed.</p>");
                            }
                        }
                    }
                }
            })

            $("body").find("select.rq").each(function(i){
                $(this).parent().find("p.error-p").remove();
                if ($(this).val() == "") {
                    $(this).after("<p class='error-p error-form'>This field is required!</p>");
                    checkError = 1;
                }
            });

            $("#RegBrndMicrochip").find("input.check-phone").each(function(){
                var secPhone = $(this).val();
                if (secPhone != '') {
                    $checkPhone++;
                    if (secPhone.length == 10) {
                        $(this).parent().find("p.error-p").remove();
                    }else{
                        $(this).parent().find("p.error-p").remove();
                        $(this).after("<p class='error-p error-form'>Required 10 digit phone number.</p>");
                        checkError = 1;
                    }
                }
            });

            $("#RegBrndMicrochip").find("input.check-email").each(function(){
                var secEmail = $(this).val();
                if (secEmail != '') {
                    $checkEmail++;
                    if (validateEmail(secEmail)) {
                        $(this).parent().find("p.error-p").remove();
                    }else{
                        $(this).parent().find("p.error-p").remove();
                        $(this).after("<p class='error-p error-form'>Invalid Email Address.</p>");
                        checkError = 1;
                    }
                }
            })

            $("#RegBrndMicrochip").find("input[name=primary_postcode]").each(function(){
                var postcode = $(this).val();
                if (postcode != '') {
                    $checkPost++;
                    if (postcode.length == 5) {
                        $(this).parent().find("p.error-p").remove();
                    }else{
                        $(this).parent().find("p.error-p").remove();
                        $(this).after("<p class='error-p error-form'>Required only 5 digit zip code</p>");
                        checkError = 1;
                    }
                }
            });

            if (checkError) {
                error2 = 1;
            }else if (!error2) {
                error2 = 0;
            }

            if ($("body form").find(".error-form").length > 0) {
                if ($("body form").find(".error-form").length > 0) {
                    $('html, body').animate({
                        scrollTop: $("body form").find(".error-form").parent().offset().top
                    }, 200);
                }
                return false;
            }

            /*eND eRROR CHECK*/

            var data     = new FormData();
            var formData = $('#RegBrndMicrochip .main-div');

            if ($('#RegBrndMicrochip .main-div').length > 0 ) {
                formData.each(function(i,obj){
                    var files_data = $(this).find('.pet-image');
                    $(this).find('.pet-image').each(function(j, obj) {
                        $.each(obj.files,function(k,file){
                            data.append('profile_images['+i+']['+j+']', file);
                        })
                    });
                    
                    $(this).find('.user-data').each(function(j){
                        data.append("users_info["+i+"]["+$(this).attr('name')+"]", $(this).val());
                    });

                    $(this).find('.sections .section').each(function(j){
                        $(this).find(".pet-data").each(function(k){
                            data.append("pets_info["+i+"]["+j+"]["+$(this).attr('name')+"]", $(this).val());
                        })
                    });
                });
            }/*else{
                $("#RegBrndMicrochip div.main-div").find('.user-data').each(function(i){
                    data.append("users_info["+$(this).attr('name')+"]", $(this).val());
                });

                $("#RegBrndMicrochip div.main-div").find('.sections .section').each(function(i){
                    $(this).find(".pet-data").each(function(j){
                        data.append("pet_info["+i+"]["+$(this).attr('name')+"]", $(this).val());
                    })
                });

                $("#RegBrndMicrochip div.main-div").find('.sections .section').each(function(i,){
                    $(this).find(".pet-image").each(function(j,obj){
                        $.each(obj.files,function(k,file){
                            data.append("profile_image["+i+"]", file);
                        })
                    })
                });
                console.log(data);
            }*/
            data.append('action','multiCustomerPetPro');

            $.ajax({
                type: 'POST',
                url: ajaxurl,
                data: data,
                contentType: false,
                processData: false,
                success: function(response) {
                    var Obj = JSON.parse(response);
                    window.location = "<?php echo site_url(); ?>"+Obj.url;
                }
            });   
    	});
        enableAutocomplete($('input.live-search-input'));


        $("body").on("click","button.section-total",function(){
            var data = new FormData();

            $(this).parents("div.main-div").find('.user-data').each(function(i){
                data.append("user_info["+$(this).attr('name')+"]", $(this).val());
            });

            $(this).parents("div.main-div").find('.sections .section').each(function(i){
                $(this).find(".pet-data").each(function(j){
                    data.append("pet_info["+i+"]["+$(this).attr('name')+"]", $(this).val());
                })
            });

            $(this).parents("div.main-div").find('.sections .section').each(function(i,){
                $(this).find(".pet-image").each(function(j,obj){
                    $.each(obj.files,function(k,file){
                        data.append("profile_image["+i+"]", file);
                    })
                })
                
            });

            data.append('action','multiCustomerPetPro');

            $.ajax({
                type: 'POST',
                url: ajaxurl,
                data: data,
                contentType: false,
                processData: false,
                success: function(response) {
                    var Obj = JSON.parse(response);
                    window.location = "<?php echo site_url(); ?>"+Obj.url
                }
            }); 

        });
    });

    function enableAutocomplete(inputField) {
        $(inputField).autocomplete({
            source: function(request, response) {
                var repeat = "";
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
                    $(this).parents('.contact-form').find("input[name=p_email]").prop("readonly",true);
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
                        $parent.find("input[name=first_name]").val(check);
                    }
                }

                if (ui.item.userMeta.last_name != "undefined" && ui.item.userMeta.last_name !== null && ui.item.userMeta.last_name != undefined) {
                    var check = ui.item.userMeta.last_name[0];
                    if (check != "undefined" && check !== null && check != undefined) {
                        $parent.find("input[name=last_name]").val(check);
                    }
                }

                if (ui.item.userMeta.primary_home_number != "undefined" && ui.item.userMeta.primary_home_number !== null && ui.item.userMeta.primary_home_number != undefined) {
                    var check = ui.item.userMeta.primary_home_number[0];
                    if (check != "undefined" && check !== null && check != undefined) {
                        $parent.find("input[name=primary_home_number]").val(check);
                    }

                    if (ui.item.userMeta.primary_phone_country_code != "undefined" && ui.item.userMeta.primary_phone_country_code !== null && ui.item.userMeta.primary_phone_country_code != undefined) {

                        var check = ui.item.userMeta.primary_phone_country_code[0];
                        if (check != "undefined" && check !== null && check != undefined && check != "") {
                            $parent.find("input[name=primary_home_number_code]").val(check);
                            var input = $parent.find("input[name=primary_home_number]")[0];

                            var main = $(input).parent().parent();
                            main.find(".iti--separate-dial-code").remove();
                            main.append(input);
                            var init = window.intlTelInput(input,{
                                separateDialCode: true,
                            });

                            if(check){
                                init.setCountry(check);
                            }
                        }

                    }
                }

                if (ui.item.data.user_email != "undefined" && ui.item.data.user_email !== null && ui.item.data.user_email != undefined) {
                    var check = ui.item.data.user_email;
                    if (check != "undefined" && check !== null && check != undefined) {
                        $parent.find("input[name=p_email]").val(check);
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

                if (ui.item.userMeta.secondary_first_name != "undefined" && ui.item.userMeta.secondary_first_name !== null && ui.item.userMeta.secondary_first_name != undefined) {
                    var check = ui.item.userMeta.secondary_first_name[0];
                    if (check != "undefined" && check !== null && check != undefined) {
                        $parent.find("input[name=secondary_first_name]").val(check);
                    }
                }

                if (ui.item.userMeta.secondary_email != "undefined" && ui.item.userMeta.secondary_email !== null && ui.item.userMeta.secondary_email != undefined) {
                    var check = ui.item.userMeta.secondary_email[0];
                    if (check != "undefined" && check !== null && check != undefined ) {
                        $parent.find("[name=secondary_email]").val(check);
                    }
                }

                if (ui.item.userMeta.primary_cell_number != "undefined" && ui.item.userMeta.primary_cell_number !== null && ui.item.userMeta.primary_cell_number != undefined) {
                    var check = ui.item.userMeta.primary_cell_number[0];
                    if (check != "undefined" && check !== null && check != undefined) {
                        $parent.find("[name=primary_cell_number]").val(check);
                    }

                    if (ui.item.userMeta.primary_cell_country_code != "undefined" && ui.item.userMeta.primary_cell_country_code !== null && ui.item.userMeta.primary_cell_country_code != undefined) {

                        var check = ui.item.userMeta.primary_cell_country_code[0];
                        if (check != "undefined" && check !== null && check != undefined && check != "") {
                            $parent.find("input[name=primary_cell_number_code]").val(check);
                            var input = $parent.find("input[name=primary_cell_number]")[0];
                            
                            var main = $(input).parent().parent();
                            main.find(".iti--separate-dial-code").remove();
                            main.append(input);
                            var init = window.intlTelInput(input,{
                                separateDialCode: true,
                            });

                            if(check){
                                init.setCountry(check);
                            }
                        }

                    }
                }
            }
        });
    }

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
    
</script>