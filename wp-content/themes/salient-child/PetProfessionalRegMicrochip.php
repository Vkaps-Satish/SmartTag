<?php
/*
 * Template Name: Pet Professional Register Brand Microchip
 */
get_header();
$getbreeds = get_top_parents('pet_type_and_breed');
//Redirect user if user not login or not petprofessional
if ( is_user_logged_in() ){
     $current_user = wp_get_current_user();
     $roles = $current_user->roles; 

       if( !$roles == 'pet_professional' || !in_array( 'pet_professional', $roles )){
         print('<div>
        <div class="not-found-text width-100">This page is only for Pet-Professionals..</div></div>');
         die();
          }

    }else{
        print('<script>window.location.href="/pet-professionals-signup"</script>');
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
                    <h1>Sign Up With SmartTag</h1>
                </div>
                <div class="site-tabs-wrap">
                    <div class="acc-blue-box">
                        <div class="acc-blue-head">
                            Pet Owner 1
                        </div>
                        <div class="acc-blue-content">
                            <form id="RegBrndMicrochip" method="POST" enctype="multipart/form-data">
                                <!--    <div class="row"> -->
                                <input type="hidden" name="action" value="Create_mul_Pet_profile">
                                <div class="contact-form" id="sec-cont-info">
                                    <div class="field-wrap three-fields-wrap">
                                        <div class="field-div">
                                            <label>First Name: </label>
                                            <input type="text" name="first_name" placeholder="First Name" class="user-data" id="s-name" />
                                        </div>
                                        <div class="field-div">
                                            <label>Last Name: </label>
                                            <input type="text" name="last_name" placeholder="Last Name" class="user-data" id="s-lstname" />
                                        </div>
                                        <div class="field-div">
                                            <label>Phone Number: </label>
                                            <input type="text" name="primary_home_number" placeholder="Phone Number" class="user-data" id="s-lstname" />
                                        </div>
                                    </div>
                                    <div class="field-wrap two-fields-wrap">
                                        <div class="field-div">
                                            <label>Email: </label>
                                            <input type="text" name="p_email" placeholder="Enter Email Address" class="user-data" id="s-email" value="" />
                                        </div>
                                        <div class="field-div">
                                            <label>Select Your Country: </label>
                                            <!-- <input type="text" name="primary_country" placeholder="Enter Country" class="user-data" id="s-county" /> -->
                                            <?php 
                                                $countries_obj = new WC_Countries();
                                                $countries = $countries_obj->__get('countries');
                                                echo '<select name="primary_country" class="address-country user-data" id="s-county">';
                                                    foreach ($countries as $key => $value) {

                                                        echo '<option value="'.$key.'" >'.$value.'</option>';
                                                    }
                                                echo '</select>';
                                            ?>
                                        </div>
                                    </div>
                                    <div class="field-wrap two-fields-wrap">
                                        <div class="field-div">
                                            <label>Address: </label>
                                            <input type="text" name="primary_address_line1" placeholder="Address line 1" class="user-data" id="sadd1" />
                                        </div>
                                        <div class="field-div">
                                            <label></label>
                                            <input type="text" name="primary_address_line2" placeholder="Address line 2" class="user-data" id="s-add2"/>
                                        </div>
                                    </div>
                                    <div class="field-wrap three-fields-wrap">
                                        <div class="field-div">
                                            <label>*City: </label>
                                            <input type="text" name="primary_city" placeholder="City" class="user-data" id="s_city1" />
                                        </div>
                                        <div class="field-div">
                                            <label>*State: </label>
                                            <select name="primary_state" class="user-data address-state" id="s-sate" data-val=""></select>
                                        </div>
                                        <div class="field-div">
                                            <label>*Zip Code: </label>
                                            <input type="text" name="primary_postcode" placeholder="Zipcode" class="user-data" id="s-zip"/>
                                        </div>
                                    </div>
                                    <div class="step-accordion">
                                        <h4 class="step-acc-head" id="sec-form"><i class="fa fa-plus"></i> Show Extra Information: </h4>
                                        <div class="step-acc-content">
                                            <div class="contact-form" id="sec-cont-info">
                                                <div id="sections">
                                                    <div class="section" id="section">
                                                        <h4 class="step-acc-head">Pet Information: </h4>
                                                     <div class="field-wrap">    
                                                        <div class="field-div">
                                                            <label>*Select Microchip Company of the Implemented Microchip: </label>
                                                            <select name="microchip_company[]" class="petdata fpet"  />
                                                            <option value="">Select Your Microchip Brand</option>   
                                                            <option value="State1">State1</option>
                                                            <option value="State2">State2</option>
                                                            <option value="State3">State3</option>
                                                            <option value="State4">State4</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                        <div class="field-wrap two-fields-wrap">
                                                            <div class="field-div">
                                                                <label>*Microchip Number: </label>
                                                                <input type="text" name="microchip_id_number[]" placeholder="Enter Microchip Number" class="petdata fpet change-pet-cont microchip-number"  />
                                                            </div>
                                                            <div class="field-div">
                                                                <label>Re-enter Microchip Number: </label>
                                                                <input type="text" name="ReMicroChipNum[]" placeholder="Re-enter Microchip Number" class="petdata fpet" />
                                                            </div>
                                                        </div>
                                                        <div class="field-wrap three-fields-wrap">
                                                            <div class="field-div">
                                                                <label>Pet Name: </label>
                                                                <input type="text" name="pet_name[]" placeholder="Pet Name" class="petdata fpet change-pet-cont pet-name" />
                                                            </div>
                                                            <div class="field-div">
                                                                <label>*Gender: </label>
                                                                <select name="gender[]" class="petdata fpet change-pet-cont gender" />
                                                                <option value="">Gender</option>    
                                                                <option value="Male">Male</option>
                                                                <option value="Female">Female</option>
                                                                </select>
                                                            </div>  
                                                            <div class="field-div">
                                                                <label>*Pet Type: </label>
                                                                <select name="pet_type" class="text-data" id="pettype" required=""  >
                                                                    <option value="">Type</option>
                                                                    <?php foreach ($getbreeds as $key => $value) { ?>
                                                                
                                                                <option value="<?= $value['term_id'] ?>"><?= $value['name'] ?></option>
                                                                
                                                                    <?php } ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    <div class="field-wrap">
                                                        <div class="field-div">
                                                            <label>*Select Universal Microchip Protection Plan: </label>
                                                            <select name="UnisalchipPln[]" class="petdata fpet change-pet-cont protection-plan">
                                                                <option value="">Select Your Microchip Brand</option>   
                                                                <option value="6858">Universal Microchip Silber 1 Year Plan -$6.95 </option>
                                                                <option value="6856">Universal Microchip Silber 5 Year Plan -$24.95 </option>
                                                                <option value="6857">Universal Microchip Silber Lifetime Plan -$39.95 </option>
                                                                <option value="6852">Universal Microchip Gold 1 Year Plan -$14.95 </option>
                                                                <option value="6850">Universal Microchip Gold 5 Year Plan -$49.95 </option>
                                                                <option value="6851">Universal Microchip Gold Lifetime Plan -$69.95 </option>
                                                                <option value="6855">Universal Microchip Platinum 1 Year Plan -$24.95 </option>
                                                                <option value="6853">Universal Microchip Platinum 5 Year Plan -$79.95 </option>
                                                                <option value="6854">Universal Microchip Platinum Lifetime Plan -$129.95 </option>
                                                            </select>
                                                        </div>
                                                    </div>    
                                                        <div class="field-wrap two-fields-wrap">
                                                            <div class="field-div">
                                                                <label>*Pet Image:</label>
                                                                <img id="blah" src="#" alt="your image" />
                                                            </div>
                                                            <div class="field-div">
                                                                <label class="auto-height"><?php __('Upload Pet Image)', 'cvf-upload'); ?></label>
                                                                <label>*Upload Pet Image</label>
                                                             
                                                                 <input type = "file" name = "feature[]" accept = "image/*" class = "files-data form-control petdata" id="imgInp" multiple />

                                                            </div>
                                                        </div>  
                                                        <div class="field-wrap two-fields-wrap">
                                                            <div class="field-div">
                                                                <label>Primary Breed: </label>
                                                                <input type="text" name="primary_breed[]" placeholder="Enter Primary Breed" class="petdata fpet" />
                                                            </div>
                                                            <div class="field-div">
                                                                <label>Secondary Breed: </label>
                                                                <input type="text" name="secondary_breed[]" placeholder="Enter Secondary Breed" class="petdata fpet" />
                                                            </div>
                                                        </div>
                                                        <div class="field-wrap two-fields-wrap">
                                                            <div class="field-div">
                                                                <label>Primary Color: </label>
                                                                <input type="text" name="primary_color[]" placeholder="Enter Primary Color" class="petdata fpet" />
                                                            </div>
                                                            <div class="field-div">
                                                                <label>Secondary Color(s):</label>
                                                                <input type="text" name="secondary_color[]" placeholder="Enter Secondary Color(s)" class="petdata fpet" />
                                                            </div>
                                                        </div>
                                                        <div class="field-wrap two-fields-wrap">
                                                            <div class="field-div">
                                                                <label>Size: </label>
                                                                <input type="text" name="Size[]" placeholder="Address line 1" class="petdata fpet" />
                                                            </div>
                                                            <div class="field-div">
                                                                <label>Pet Date of Birth: (optional)</label>
                                                               <input type="text" name="pet_date_of_birth[]" placeholder="mm/dd/yy" class="input-10 input petdata fpet">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="field-wrap two-fields-wrap">
                                                    <div class="field-div">
                                                        <div class="field-wrap two-fields-wrap">
                                                            <div class="field-div">
                                                                <p><a href="#" class='addsection btn btn-default'>Add Another Pet</a></p></div>
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
                                <div class="acc-blue-box">
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
                                                        <h4 class="step-acc-head">Pet Information: </h4>
                                                        <strong>Microchip Number: </strong><span id="MicNum" class="microchip-number"></span></br>   

                                                        <strong>Pet Name: </strong><span id="PetNam" class="pet-name"></span></br>   

                                                        <strong>Gender: </strong><span id="PetGn" class="gender"></span></br>  

                                                        <strong>Protection Plan: </strong><span id="PetPrPln" class="protection-plan"></span></br>  
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        </div> 
                        <button class="btn btn-default" type="submit">Purchese All</button>
                        </form>
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
        //datepicker
        $("#pet-dob").datepicker({
            onSelect: function () {
                var Pdb = $(this).datepicker('getDate');
                $("#ptdob").text(Pdb);
            }
        });

//for keyup for perview

        //       $("#MicroNum").keyup(function(){
        //  var MicroNum = $(this).val();
        //  $("#MicNum").text(MicroNum);
        // });
        //       $("#PetNm").keyup(function(){
        //  var PetNm = $(this).val();
        //  $("#PetNam").text(PetNm);
        // });

        //       $("#PetGen").change(function(){
        //  var PetGen = $(this).val();
        //  $("#PetGn").text(PetGen);
        // });

        //       $("#UniMicPln").change(function() {
        //     var UniMicPln = $(this).val();
        //  $("#PetPrPln").text(UniMicPln);
        //   });
       
//define counter
        var template = $('#sections .section:first').clone();
        var Info = $('#Informations .Information:first').clone();

        //increment
        var sectionsCount = 0;
        //add new section
        $('body').on('click', '.addsection', function () {
            sectionsCount++;
            window.formdata = [];
            //for preview section

            Info = Info.clone().find('span').each(function () {
                // var INFOId = this.id + sectionsCount;
                var INFOId = this.id + sectionsCount;
                this.id = INFOId;

            }).end().appendTo("#Informations");

            var InfoSection = $('#Informations').children().last();
            // console.log('latsection'+lastSection);
            InfoSection.attr('class', 'Information' + sectionsCount);
            //for image
            template = template.clone().find('img').each(function () {
                var imgnewId = 'blah' + sectionsCount;
                this.id = imgnewId;
            }).end();
            //loop through each input
            var section = template.clone().find(':input').each(function () {
                 var newId = this.id + sectionsCount;
               // $(this).prev().attr('for', newId);
                this.id = newId;
               
            }).end().appendTo('#sections');
            
            var lastSection = $('#sections').children().last();
            // console.log('latsection'+lastSection);
            lastSection.attr('id', 'SecId' + sectionsCount);

            //for multiple datapicker
            $("#pet-dob"+sectionsCount).datepicker({
                onSelect: function () {
                    var Pdb = $(this).datepicker('getDate');
                    $("#ptdob" + sectionsCount).text(Pdb);
                }
            });

            function readURL(input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        $('#blah'+sectionsCount).attr('src', e.target.result);
                    }
                    reader.readAsDataURL(input.files[0]);
                }
            }
            $("#imgInp"+sectionsCount).change(function () {
                readURL(this);
            });

              $('#imgInp'+sectionsCount).change(function(e){
                     var fileName = e.target.files[0].name;
                       $("imgnm"+sectionsCount).attr('value',fileName);
                        
                       });

            return false;
        });



        $('#RegBrndMicrochip').on('submit', function (e) {
           e.preventDefault();
            /*var fd = new FormData();
            var files_data = $('#RegBrndMicrochip .files-data');

             var BrndMichip = $('#BrndMichip').attr('name');
          // $('#BrndMichip').attr('name','formdata[0]["'+BrndMichip+'"]');

                                
            $.each($('#RegBrndMicrochip .petdata'), function () {
                console.log($(this).attr('name')+'tttttt'+$(this).val());
                fd.append($(this).attr('name'), $(this).val());
             });

             $.each($('#RegBrndMicrochip .petdata1'), function () {
                   //$(this).removeClass('petdata');
                var tem = ($(this).attr('name'));
                 $(this).attr('name','formdata[0]["'+tem+'"]');
                fd.append($(this).attr('name'), $(this).val());
            });*/

            // $.each($(files_data), function(i, obj) {
            //     $.each(obj.files,function(j,file){
            //         console.log('files[' + j + ']'+file);
            //         fd.append('files[' + j + ']', file);
            //     })
            // });
           
            
            // fd.append('action', 'Create_mul_Pet_profile');
            $.ajax({
                     type: 'POST',
                     url: ajaxurl,
                     data: new FormData(this),
                     contentType: false,
                     processData: false,
                     success: function(response) {
                            console.log(response);// Append Server Response
                        }
            }); 
//USER CREATE
        // var usfd = new FormData();
        // $.each($('#RegBrndMicrochip .user-data'), function () {
        //     console.log($(this).attr('name')+'ssssssss'+$(this).val());
        //     usfd.append($(this).attr('name'), $(this).val());
        // });
        // usfd.append('action', 'Multicustomer');
        // //if($('#RegBrndMicrochip #s-email').val() != ""){
        // $.ajax({
        //  type: 'POST',
        //  url: ajaxurl,
        //  data: usfd,
        //  contentType: false,
        //  processData: false,
        //  success: function(response) {
        //         alert(response);// Append Server Response
        //     }
        // }); 

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
                $(".Information .protection-plan").text($(this).find('option:selected').text());
            }else{
                $(".Information"+divNum+" .protection-plan").text($(this).find('option:selected').text());
            }
        }
    });
});    
</script>