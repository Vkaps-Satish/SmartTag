<?php 
/*
* Template Name: Register PetProfessional smartTag ID Tag
5f4dcc3b5aa765d61d8327deb882cf99
*/
get_header();

//for redirect page into pet professional page if pet professional is login
if ( is_user_logged_in() ){
    $current_user = wp_get_current_user();
    $roles = $current_user->roles;  
    if( !$roles == 'pet_professional' || !in_array( 'pet_professional', $roles )){
        print('<div><div class="not-found-text width-100">This page is only for Pet-Professionals..</div></div>');
        die();
    }       
}else{
    print('<script>window.location.href="'.get_option('siteurl').'/pet-professionals-signup"</script>
            ');
    exit();    
}
?>
<div class="container-wrap" ng-app="myapp" ng-controller="fetchCtrl">        
    <div class="container main-content">
        <div class="row">
            <div class="woo-sidebar col-sm-3">
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
                    <h1>Register SmartTag Microchip or ID Tag</h1>
                </div>
                <form id="SmartTagId" method="POST" name="Smartform" enctype="multipart/form-data">
                    <div class="site-tabs-wrap main-div">
                        <div class="acc-blue-box">
                            <div class="acc-blue-head">
                                Pet Owner <span class="owner-number">1</span>
                            </div>
                            <div class="acc-blue-content" ng-click='containerClicked();'>
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
                                            <input type="text" name="first_name" placeholder="First Name" class="user-data s-name rq"/>
                                        </div>
                                        <div class="field-div">
                                            <label>*Last Name: </label>
                                            <input type="text" name="last_name" placeholder="Last Name" class="user-data s-lstname rq"/>
                                        </div>
                                         <div class="field-div">
                                            <label>*Phone Number: </label>
                                            <input type="text" name="primary_home_number" placeholder="Phone Number" class="user-data s-phone Number check-validate-phone rq phone-number"/>
                                            <input type="hidden" name="primary_home_number_code"  class="user-data" value="" />
                                        </div>
                                        <input type="hidden" name="registerOwnerId" value="0">
                                    </div>
                                    <div class="field-wrap two-fields-wrap">
                                        <div class="field-div">
                                            <label>*Email: </label>
                                            <input type="text" name="p_email" placeholder="Enter Email" class="user-data s-email check-validate-email rq email"/>
                                        </div>
                                        <div class="field-div">
                                            <label>*Country: </label> 
                                            <?php 
                                                $countries_obj = new WC_Countries();
                                                $countries = $countries_obj->__get('countries');
                                                echo '<select name="primary_country" class="address-country not-check-validate user-data s-county rq" required>';
                                                echo '<option value="">Select Country</option>';
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
                                            <input type="text" name="primary_address_line1" placeholder="Address line 1" class="user-data sadd1 rq"/>
                                        </div>
                                        <div class="field-div">
                                            <label></label>
                                            <input type="text" name="primary_address_line2" placeholder="Address line 2" class="user-data s-add2"/>
                                        </div>
                                    </div>
                                    <div class="field-wrap three-fields-wrap">
                                        <div class="field-div">
                                            <label>*City: </label>
                                            <input type="text" name="primary_city" placeholder="City" class="user-data s_city1 rq"/>
                                        </div>
                                        <div class="field-div">
                                            <label class="statevalidate">*State: </label>
                                            <select name="primary_state" class="user-data address-state s-sate rq" data-val=""></select>
                                        </div>
                                        <div class="field-div">
                                            <label>*Zip Code: </label>
                                            <input type="text" name="primary_postcode" placeholder="Zipcode" class="user-data s-zip rq"/>
                                        </div>
                                    </div>
                                    <div class="field-wrap three-fields-wrap">
                                        <div class="field-div">
                                            <label>Secondary Name: </label>
                                            <input type="text" name="secondary_first_name" placeholder="Secondary Name" class="user-data SecNm" />
                                        </div>
                                        <div class="field-div">
                                            <label>Secondary Email: </label>
                                            <input type="email" name="secondary_email" class="user-data SecEmail check-email" placeholder="Secondary Email" />
                                        </div>  
                                        <div class="field-div">
                                            <label>Secondary Phone Number: </label>
                                           <input type="text" name="primary_cell_number" class="user-data phoNum check-phone phone-number" placeholder="Secondary Phone Number" />
                                           <input type="hidden" name="primary_cell_number_code" class="user-data" value="" />
                                        </div>
                                    </div>
                                    <div class="step-accordion">
                                        <div class="step-acc-content1">
                                            <div class="contact-form sec-cont-info">
                                                <div class="sections">
                                                    <div class="section SecId">
                                                        <h4 class="step-acc-head-dark"><span class="text-left">Pet <span class="pet-num">1</span> Information:</span></h4>
                                                        <h4 class="Pet_info"> </h4>
                                                        <div class="field-wrap two-fields-wrap">
                                                            <div class="field-div">
                                                                <label>*Serial Number: </label>
                                                                <input type="text" name="serialNumber" class="pet-data rq serial-number-check" placeholder="Serial Number" />
                                                            </div>
                                                            <div class="field-div">
                                                                <label>*Re-enter Serial Number: </label>
                                                                <input type="text" name="reSerialNumber" class="rq serial-number-check-double" placeholder="Re-enter Serial Number"/>
                                                            </div>
                                                        </div>
                                                        <div class="field-wrap two-fields-wrap">
                                                            <div class="field-div">
                                                                <label>*Pet Name: </label>
                                                                <input type="text" name="pet_name" class="pet-data rq" placeholder="Pet Name"/>
                                                            </div>
                                                            <div class="field-div">
                                                                <div class="field-wrap two-fields-wrap">
                                                                    <div class="field-div">
                                                                        <label>*Gender: </label>
                                                                        <select name="gender" class="pet-data rq" />
                                                                        <option value="">Gender</option>    
                                                                        <option value="Male">Male</option>
                                                                        <option value="Female">Female</option>
                                                                        </select>
                                                                    </div>  
                                                                    <div class="field-div">
                                                                        <label>*Pet Type: </label>
                                                                        <select name="PetTyp" class="pet-data rq"  />
                                                                        <option value="">Type</option>
                                                                        <option value="Type1">Type1</option>
                                                                        <option value="Type2">Type2</option>
                                                                        <option value="Type3">Type3</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                          </div>
                                                        </div>
                                                        <div class="step-acc-content">
                                                        <div class="field-wrap two-fields-wrap">
                                                            <div class="field-div">
                                                                <label>Pet Image:</label>
                                                                <img class="blah custom-pet-image" src="<?php echo get_site_url(); ?>/wp-content/uploads/2019/02/pet-image.jpg" alt="your image" />
                                                            </div>
                                                            <div class="field-div">
                                                                <label class="auto-height"><?php __('Upload Pet Image)', 'cvf-upload'); ?></label>
                                                                <label>Upload Pet Image: (Optional however in the event your pet is lost a picture is very helpful)</label>
                                                                <div class="field-notice">Files must be less than 2MB.
                                                                <br>Allowed file types .png/ .gif/ .jpg/ .jpeg</div>
                                                                <input type="file" name="files" accept="image/*" class="pet-data pet-image" multiple   />

                                                            </div>
                                                        </div>  
                                                        <div class="field-wrap two-fields-wrap">
                                                            <div class="field-div">
                                                                <label>Primary Breed: </label>
                                                                <select class="pet-data" name="primary_breed">
                                                                    <option value="">Primary Breed</option>
                                                                    <option value="breed1">Breed1</option>
                                                                    <option value="breed2">Breed2</option>
                                                                    <option value="breed3">Breed3</option>
                                                                    <option value="breed4">Breed4</option>
                                                                </select>
                                                            </div>
                                                            <div class="field-div">
                                                                <label>Secondary Breed: </label>
                                                                <select class="pet-data" name="secondary_breed">
                                                                    <option value="">Secondary Breed</option>
                                                                    <option value="breed1">Breed1</option>
                                                                    <option value="breed2">Breed2</option>
                                                                    <option value="breed3">Breed3</option>
                                                                    <option value="breed4">Breed4</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="field-wrap two-fields-wrap">
                                                            <div class="field-div">
                                                                <label>Primary Color: </label>
                                                                <input type="text" class="pet-data" name="primary_color" placeholder="Primary Color" />
                                                            </div>
                                                            <div class="field-div">
                                                                <label>Secondary Color(s):</label>
                                                                <input type="text" class="pet-data" name="secondary_color" placeholder="Secondary Color(s)" />
                                                            </div>
                                                        </div>
                                                        <div class="field-wrap two-fields-wrap">
                                                            <div class="field-div">
                                                                <label>Size: </label>
                                                                <select class="pet-data" name="Size">
                                                                    <option value="">Select</option>
                                                                    <option value="1">1</option>
                                                                    <option value="2">2</option>
                                                                </select>
                                                            </div>
                                                            <div class="field-div">
                                                                <label>Pet Date of Birth: (optional)</label>
                                                                <input type="text" name="pet_date_of_birth" placeholder="mm/dd/yyyy" class="input-10 input text-data pet-data" placeholder="Pet Date of Birth">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <h4 class="step-acc-head" ><i class="fa fa-plus"></i> Show Extra Pet Information: </h4>
                                                </div>
                                                
                                            </div>
                                                <div class="field-wrap two-fields-wrap">
                                                    <div class="field-div">
                                                        <div class="field-wrap two-fields-wrap">
                                                            <div class="field-div">
                                                                <p><button class="addsection1 btn btn-default addPet" type="button"><i class="fa fa-plus"></i> Add Another Pet</button></p></div>
                                                            <div class="field-div">&nbsp;</div>
                                                        </div>
                                                    </div>
                                                    <div class="field-div">
                                                        <div class="field-wrap two-fields-wrap">
                                                            <div class="field-div">&nbsp;</div>
                                                            <div class="field-div">
                                                                <!-- <button class="btn btn-default"type="submit">Purchese Plan for $7.50</button> -->
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="acc-blue-box owner_Info">
                                    <div class="acc-blue-head">
                                        Owner Information 1
                                        <div class="acc-edit engrave-edit">
                                            <i class="fa fa-cog"></i> EDIT
                                        </div>
                                    </div>
                                    <div class="acc-blue-content">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <strong id="">Home Phone: </strong></br>
                                                <strong id=" ">Cell Phone Number: </strong></br>
                                                <strong id="Insurance">Full Name: </strong></br>
                                                <strong id="Insurance">Address: </strong></br>
                                                <strong id="Insurance">Primary Contact Email: </strong></br>
                                                <strong id="Insurance">Secondary Contact Name: </strong></br>
                                                <strong id="Insurance">Secondary Contact Phone Number: </strong></br>   
                                                <strong id="Insurance">Secondary Contact Email: </strong></br>  
                                            </div>
                                            <div class="col-sm-12">
                                                <div id="Informations">
                                                    <div class="Information">
                                                        <h4 class="step-acc-head">Pet1 Information: </h4>
                                                        <strong>Microchip Number: </strong><span id="MicNum"></span></br>   

                                                        <strong>Pet Name: </strong><span id="PetNam"></span></br>   

                                                        <strong>Gender: </strong><span id="PetGn"></span></br>  

                                                        <strong>Protection Plan: </strong><span id="PetPrPln"></span></br>  
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div> 
                        </div>
                    </div>
                </form>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="header-right">
                            <button class="btn site-btn site-btn-blue add-pet-owner"><i class="fa fa-plus"></i> Add Another Pet Owner</button>
                            <button type="button" class="site-btn-red save-all"> SAVE ALL </button>
                        </div>
                    </div>
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
        var mainDiv      = $('.site-tabs-wrap.main-div:first').clone(true);
        var mainTemplate = $('.sections .section:first');
        var template     = $('.sections .section:first').clone();
        var today        = new Date();

        //datepicker
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
        
        jQuery("input[name='serialNumber']").inputFilter(function(value) {
            return /^\d*$/.test(value);
        });

        jQuery("input[name='reSerialNumber']").inputFilter(function(value) {
            return /^\d*$/.test(value);
        });

        $("body").on("change","input.rq",function(i){
            $(this).parent().find("p.error-p").remove();
            $(this).parent().find("p.error-main").remove();
            if ($(this).val() == "") {
                $(this).after("<p class='error-p'>This field is required!</p>");
            }else if($(this).hasClass('check-validate-phone')){
                if ($(this).val().length == 10) {
                    $(this).parent().find("p.error-p").remove();
                }else{
                    $(this).after("<p class='error-p'>Required 10 digit phone number.</p>");
                }
            }else if ($(this).hasClass('.check-validate-email')) {
                if (!validateEmail($(this).val())) {
                    $(this).after("<p class='error-p'>Invalid Email Address.</p>");
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
                    $thisSerial.after("<p class='error-main'>This serial id already used in another form. Please check it.</p>");
                    error = 1;
                    return;
                }else{
                    error = 0;
                }

                if (serialNumber != "") {
                    if (serialNumber.length == 8 || serialNumber.length == 15) {
                        $.ajax({
                            type: 'POST',
                            url: ajaxurl,
                            data: {"action":"checkSerialNumberExist","serialNumber":serialNumber},
                            success: function(rs) {
                                rs = jQuery.parseJSON(rs);
                                if (rs.success == 0) {
                                    error = 1;
                                    $thisSerial.after("<p class='error-main'>"+rs.message+"</p>");
                                }else{
                                    $thisSerial.parent().find("p.error-main").remove();
                                    error = 0;
                                    var secondSerial = $thisSerial.parent().parent().find("input.serial-number-check-double").val();
                                    $thisDoubleNumb  = $thisSerial.parent().parent().find("input.serial-number-check-double");
                                    $thisDoubleNumb.parent().find("p.error-main").remove();
                                    if (serialNumber != secondSerial && secondSerial != '') {
                                        $thisDoubleNumb.after("<p class='error-main'>Serial Number and Re-enter Serial Number are not matching.</p>");
                                        error = 1;
                                        return;
                                    }
                                }
                            }
                        });
                    }else{
                        $thisSerial.after("<p class='error-main'>Serial number is invalid.</p>");
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
                        $thisDoubleNumb.after("<p class='error-main'>Serial Number and Re-enter Serial Number are not matching.</p>");
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
                $(this).after("<p class='error-p'>This field is required!</p>");
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
                    $(this).after("<p class='error-p'>Required 10 digit phone number.</p>");
                }else if (phone == $(this).val()) {
                    check++;
                }
            });

            if (check > 1) {
                $thisPhon.after("<p class='error-main'>This phone number already used in another form. Please check it.</p>");
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
                            $thisPhon.after("<p class='error-main'>This phone number already exist.</p>");
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
                $thisemail.after("<p class='error-main'>This email already used in another form. Please check it.</p>");
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
                            $thisemail.after("<p class='error-main'>This email already exist.</p>");
                        }else{
                            $thisemail.parent().find("p.error-main").remove();
                            error = 0;
                        }
                    }
                });
            }else if(email != ""){
                $thisemail.after("<p class='error-main'>Invalid Email Address.</p>");
                error = 1;
            }
        });

        $("button.save-all").on('click',function(){
            $('#SmartTagId').submit();
        });

        $('body').on('click','.owner-remove',function(){
            $(this).parents(".main-div").remove();
            if ($(".site-tabs-wrap.main-div").length == 1) {
                return false;
            }
            $(".site-tabs-wrap.main-div:last-child").find('.acc-blue-head').append('<div class="acc-edit owner-edit owner-remove"><i class="fa fa-trash"></i> Remove</div>')
        });
        
        $("body").on('click','.add-pet-owner',function(){
            $(".site-tabs-wrap.main-div:last-child").find(".acc-edit.owner-edit").remove();

            var divLength = $(".site-tabs-wrap.main-div").length+1;
            console.log(mainDiv);
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


            var newDiv = $("#SmartTagId").append(div);
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
            // newDiv.find(".phone-number").each(function(i, input){
            //     var $this = this;
            //     var div = $(this).parent().parent();
            //     div.find(".iti--separate-dial-code").remove().append("Hi");
            //     console.log(div.html());
            // })
            enableAutocomplete(newDiv.find('input.live-search-input:last-child'));
        });

        $('body').on('click', '.addsection1', function () {
            var parentLength = $(this).parents(".contact-form.sec-cont-info").find(".sections .section").length+1;
            var newDiv = template.clone().find('span.pet-num').text(parentLength).end().appendTo($(this).parents(".contact-form.sec-cont-info").find(".sections"));
            var html = "<span class='pet-head-remove'><i class='fa fa-trash'></i> Remove</span>";
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
            $(this).parents(".contact-form.sec-cont-info").find(".sections .section h4.step-acc-head-dark span.pet-head-remove").remove();
            newDiv.find("h4.step-acc-head-dark").append(html);
        });

        $('body').on( 'click', '.pet-head-remove', function(){
            var html        = "<span class='pet-head-remove'><i class='fa fa-trash'></i> Remove</span>";
            $thiSpanRemove  = $(this).parent().parent().parent();
            $thiSpanRemove.find('.section:last-child').remove();
            var lenghtt     = $thiSpanRemove.find('.section').length;
            if (lenghtt > 1) {
                $thiSpanRemove.find('.section:last-child h4.step-acc-head-dark').append(html);
            }
        });

        $('body').on("change","input.check-phone",function(){
            var secPhone = $(this).val();
            if (secPhone != '') {
                if (secPhone.length == 10) {
                    $(this).parent().find("p.error-p").remove();
                }else{
                    $(this).parent().find("p.error-p").remove();
                    $(this).after("<p class='error-p'>Required 10 digit phone number.</p>");
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
                    $(this).after("<p class='error-p'>Required only 5 digit zip code</p>");
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
                    $(this).after("<p class='error-p'>File size is greater than 2MB.</p>");
                }else{
                    checkError = 1;
                    var ext = $(this).val().split('.').pop().toLowerCase();
                    if($.inArray(ext, ['gif','png','jpg','jpeg']) == -1) {
                        $(this).after("<p class='error-p'>Uploaded file is not a valid image. Only JPG, PNG, JPEG and GIF files are allowed.</p>");
                    }
                }
            }
        })

        $('#SmartTagId').on('submit', function (e) {
            e.preventDefault();
            var checkError = 0;
            $("body").find("input.rq").each(function(i){
                $(this).parent().find("p.error-p").remove();
                if ($(this).val() == "") {
                    $(this).after("<p class='error-p'>This field is required!</p>");
                    checkError = 1;
                }else if($(this).hasClass('check-validate-phone')){
                    if ($(this).val().length == 10) {
                        $(this).parent().find("p.error-p").remove();
                    }else{
                        $(this).after("<p class='error-p'>Required 10 digit phone number.</p>");
                        checkError = 1;
                    }
                }else if ($(this).hasClass('check-validate-email')) {
                    if (!validateEmail($(this).val())) {
                        $(this).after("<p class='error-p'>Invalid Email Address.</p>");
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
                            $(this).after("<p class='error-p'>File size is greater than 2MB.</p>");
                        }else{
                            checkError = 1;
                            var ext = $(this).val().split('.').pop().toLowerCase();
                            if($.inArray(ext, ['gif','png','jpg','jpeg']) == -1) {
                                $(this).after("<p class='error-p'>Uploaded file is not a valid image. Only JPG, PNG, JPEG and GIF files are allowed.</p>");
                            }
                        }
                    }
                }
            })

            $("body").find("select.rq").each(function(i){
                $(this).parent().find("p.error-p").remove();
                if ($(this).val() == "") {
                    $(this).after("<p class='error-p'>This field is required!</p>");
                    checkError = 1;
                }
            });

            var secPhone = $("#SmartTagId").find("input.check-phone").val();
            var secEmail = $("#SmartTagId").find("input.check-email").val();
            var postcode = $("#SmartTagId").find("input[name=primary_postcode]").val();

            if (secPhone != '') {
                $checkPhone++;
                if (secPhone.length == 10) {
                    $("#SmartTagId").find("input.check-phone").parent().find("p.error-p").remove();
                }else{
                    $("#SmartTagId").find("input.check-phone").parent().find("p.error-p").remove();
                    $("#SmartTagId").find("input.check-phone").after("<p class='error-p'>Required 10 digit phone number.</p>");
                    checkError = 1;
                }
            }

            if (secEmail != '') {
                $checkEmail++;
                if (validateEmail(secEmail)) {
                    $("#SmartTagId").find("input.check-email").parent().find("p.error-p").remove();
                }else{
                    $("#SmartTagId").find("input.check-email").parent().find("p.error-p").remove();
                    $("#SmartTagId").find("input.check-email").after("<p class='error-p'>Invalid Email Address.</p>");
                    checkError = 1;
                }
            }

            if (postcode != '') {
                $checkPost++;
                if (postcode.length == 5) {
                    $("#SmartTagId").find("input[name=primary_postcode]").parent().find("p.error-p").remove();
                }else{
                    $("#SmartTagId").find("input[name=primary_postcode]").parent().find("p.error-p").remove();
                    $("#SmartTagId").find("input[name=primary_postcode]").after("<p class='error-p'>Required only 5 digit zip code</p>");
                    checkError = 1;
                }
            }

            if (checkError) {
                error2 = 1;
            }else if (!error2) {
                error2 = 0;
            }

            if ($("body form").find(".error-main").length > 0 || $("body form").find(".error-p").length > 0) {
                if ($("body form").find(".error-main").length > 0) {
                    $('html, body').animate({
                        scrollTop: $("body form").find(".error-main").parent().offset().top
                    }, 200);
                }else{
                    $('html, body').animate({
                        scrollTop: $("body form").find(".error-p").parent().offset().top
                    }, 200);
                }
                
                return false;
            }

            $(".loader-wrap").fadeIn();
            var MySection = [];
            $('#sections .section').each(function () {
                MySection.push($(this).attr('id'));
            });
            
            var data     = new FormData();
            var formData = $('#SmartTagId .main-div');

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

            data.append('action','Multicustomer');
            $(".loader-wrap").fadeIn();
            $.ajax({
                type: 'POST',
                url: ajaxurl,
                data: data,
                contentType: false,
                processData: false,
                success: function(response) {

                    $(".loader-wrap").fadeOut();
                    $(".popup-wrap .popup-content #poptitle").text("Success");
                    $(".popup-wrap .popup-content #popcont").text("Your data has been successfully submitted.");
                    $(".popup-wrap").fadeIn();
                    setTimeout(location.reload(), 5000);
                }
            }); 
        });

        enableAutocomplete($('input.live-search-input'));
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
        }
    });
</script>

