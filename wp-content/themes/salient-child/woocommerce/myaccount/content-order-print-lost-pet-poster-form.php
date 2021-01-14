<?php
$postId         = $_GET['pet_id'];
$post           = get_post($postId); 
$authid         = $post->post_author;
$phoneNum       = get_user_meta($authid, 'primary_home_number');
$phoneNum       = $phoneNum[0];
$mypod          = pods( 'pet_profile', $postId );
$petType        = $mypod->display('pet_type');
$breed          = $mypod->display('primary_breed');
$color          = $mypod->display('primary_color');
$addInfo        = $mypod->display('unique_features');
$serialNumber   = $mypod->display('smarttag_id_number');
if (!empty(get_the_post_thumbnail_url($postId))) {
  $imageUrl = get_the_post_thumbnail_url($postId);
}else{
  $imageUrl = get_bloginfo('template_url')."-child/images/logo-icon.png";
}
?>
<div class="row middle-border-row small-poster-row">
  <div class="col-sm-6 rmb-30">
    <div class="contact-form">
      <h3>Edit Lost Pet Poster</h3>
      <div class="field-wrap">
        <div class="field-div">
          <label>*Pet Name:</label>
          <input type="text" name="pet_name" class="pet-name" value="<?php echo $post->post_title; ?>" required="" >
        </div>
      </div>
      <div class="field-wrap two-fields-wrap">
        <div class="field-div">
          <label>*Pet Type & Breed:</label>
          <input type="text" name="pet_type" class="pet-type" value="<?php echo $petType; ?>" required="" >
        </div>
        <div class="field-div">
          <label></label>
          <input type="text" name="pet_breed" class="pet-breed" value="<?php echo $breed; ?>" required="" >
        </div>
      </div>
      <div class="field-wrap">
        <div class="field-div">
          <label>*Color(s):</label>
          <input type="text" name="color" class="color" value="<?php echo $color; ?>" required="" >
        </div>
      </div>
      <div class="field-wrap">
        <div class="field-div">
          <label>*Phone Number:</label>
          <input type="text" name="phone_number" class="phone-number" value="<?php echo $phoneNum; ?>" required="" >
        </div>
      </div>
      <div class="field-wrap">
        <div class="field-div">
          <label>*SmartTag Id Number:</label>
          <input type="text" name="serial_number" class="serial-number" value="<?php echo $serialNumber; ?>" required="" >
        </div>
      </div>
      <div class="field-wrap">
        <div class="field-div">
          <label>*Reward:</label>
          <input type="number" name="reward" class="reward" value="" required="" >
        </div>
      </div>
      <div class="field-wrap">
        <div class="field-div">
          <label>*Additional Information:</label>
          <textarea class="add-info" name="add_info" required="" ><?php echo $addInfo; ?></textarea>
          <div class="field-notice mb-15" style="margin-top: -15px;">Character Count Limit: 250</div>
        </div>
      </div>
      <div class="field-wrap two-fields-wrap">
        <div class="field-div">
          <div class="mb-15">
            <img src="<?php echo get_the_post_thumbnail_url($postId); ?>" class="pet-current-image" name="pet_current_image">
          </div>
        </div>
        <div class="field-div">
          <div class="mb-15">
            <input type="checkbox" name="current_image" class="current-image" checked="checked"> <strong>Use Current Pet Image</strong>
          </div>
        </div>
      </div>
      <div class="field-wrap">
        <div class="field-div">
          <label>Upload New Pet Image:</label>
          <input type="file" name="pet_image" class="pet-image" >
          <div class="field-notice">File must be less than 2 Mb<br>Suggested Dimension Size: 1188px X 800px<br>Allowed file types: .png/ .gif/ .jpg/ .jpeg</div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-sm-6">
    <div class="print-poster-col" style="line-height: 1.5; color: #3c3c3c; font-family: 'Asap', sans-serif; font-size: 14px; border: 1px solid #679fe1; padding: 15px; margin-bottom: 25px;">
      <div class="print-poster-inner">
        <h2 style="font-size: 42px;font-weight: 700;margin: 0 0 15px 0;color: #dc2727;text-align: center;line-height: 1.1 !important;text-transform: uppercase;">Lost Pet</h2>
        <div class="bordered-poster-wrap" style="border: 3px solid #dc2727; padding: 8px; margin-bottom: 15px;">
          <div class="bordered-poster mb-15">
            <table cellpadding="0" cellspacing="0" style="width: 100%; border-collapse: collapse; margin-bottom: 0;">
              <tr>
                <td style="width: 50%; vertical-align: top; padding: 0; border: none; font-size: 14px;">
                  <p style="font-weight: 600; font-size: 18px; margin-bottom: 10px;"><span class="dog-name">"<?php echo $post->post_title; ?>"</span></p>
                  <span class="poster-type"><?php echo $petType; ?></span>, <span class="poster-breed"><?php echo $breed; ?></span>
                  <br>
                  Color: <span class="poster-color"><?php echo $color; ?></span>
                  <br>
                  ID Tag #: <span class="poster-id"><?php echo $serialNumber; ?>
                </span>
              </td>
              <td style="width: 50%; vertical-align: top; padding: 0; border: none; font-size: 14px;">
                <p style="font-weight: 600; font-size: 18px; margin-bottom: 10px; padding: 0;">REWARD <span style="color: #dc2727;" class="user-reward">$100</span></p>
                <strong>Additional Info:</strong>
                <br>
                <span class="extra-info"><?php echo $addInfo; ?></span>
              </td>
            </tr>
            <tr>
              <td colspan="2" style="text-align: center; color: #dc2727; font-size: 18px; text-transform: uppercase; padding: 0; border: none; font-size: 14px;">
                <p style="margin-bottom: 20px; margin-top: 20px; font-size: 18px;">
                  Please call with any info:
                  <br>
                  <span class="poster-phone-number"><?php echo $phoneNum; ?></span>
                </p>
              </td>
            </tr>
            <tr>
              <td colspan="2" style="text-align: center; padding: 0; border: none; font-size: 14px;">
                <p style="margin-bottom: 15px; text-align: center;">
                  <img src="<?php echo $imageUrl; ?>" alt="image" style="width: auto; height: auto; max-width: 100%; display: inline-block;" class="poster-pet-image" />
                </p>
              </td>
            </tr>
          </table>
        </div>
      </div>
      <div class="poster-info-table-wrap">
        <table class="poster-info-table" cellspacing="0" cellpadding="0" style="width: 100%; border-collapse: collapse; margin-bottom: 0;">
          <td style="text-align: left; color: #3c3c3c; padding: 0; border: none; font-size: 14px;">
            <img src="<?php bloginfo('template_url'); ?>-child/images/logo-icon.png" alt="image" style="width: 50px; height: auto;" />
          </td>
          <td  style="text-align: right; color: #3c3c3c; font-size: 14px; padding: 0; border: none; font-size: 14px; font-weight: 600;">
            To Report This Pet Found , Enter ID Tag # on:
            <p style="font-size: 28px; font-weight: 600; margin: 0 0 0 0; color: #3c3c3c; line-height: 1.2;">WWW.IDTAG.COM</p>
          </td>
        </table>
      </div>
    </div>
  </div>
  <p class="text-right mb-25">
    <a href="javascript:;" class="site-btn site-btn-light-blue width-70 text-center see-big-poster">See Full-Size Preview</a>
  </p>
  <p class="text-right">
    <a href="javascript:;" class="site-btn site-btn-red width-70 text-center print-btn">Confirm and Print <i class="fa fa-caret-right"></i></a>
  </p>
</div>
</div>
<div class="row big-poster-row">
  <div class="col-sm-8 rmb-30 big-poster-div">
    <div class="print-poster-col" style="line-height: 1.5; color: #3c3c3c; font-family: 'Asap', sans-serif; font-size: 16px; border: 1px solid #679fe1; padding: 30px; margin-bottom: 30px;">
      <div class="print-poster-inner">
        <h2 style="font-size: 56px;font-weight: 700;margin: 0 0 15px 0;color: #dc2727;text-align: center;line-height: 0.9 !important;text-transform: uppercase;">Lost Pet</h2>
        <div class="bordered-poster-wrap" style="border: 5px solid #dc2727; padding: 8px; margin-bottom: 20px;">
          <div class="bordered-poster mb-15">
            <table cellpadding="0" cellspacing="0" style="width: 100%; border-collapse: collapse; margin-bottom: 0;">
              <tr>
                <td style="width: 50%; vertical-align: top; padding: 0; border: none; font-size: 16px;">
                  <p style="font-weight: 600; font-size: 28px; margin-bottom: 10px;"><span class="dog-name">"<?php echo $post->post_title; ?>"</span></p>
                  <span class="poster-type"><?php echo $petType; ?></span>, <span class="poster-breed"><?php echo $breed; ?></span>
                  <br>
                  Color: <span class="poster-color"><?php echo $color; ?></span>
                  <br>
                  ID Tag #: <span class="poster-id"><?php echo $serialNumber; ?>
                </span>
              </td>
              <td style="width: 50%; vertical-align: top; padding: 0; border: none; font-size: 16px;">
                <p style="font-weight: 600; font-size: 28px; margin-bottom: 10px; padding: 0;">REWARD <span style="color: #dc2727;" class="user-reward user-reward-main">$100</span></p>
                <strong>Additional Info:</strong>
                <br>
                <span class="extra-info"><?php echo $addInfo; ?></span>
              </td>
            </tr>
            <tr>
              <td colspan="2" style="text-align: center; color: #dc2727; font-size: 16px; text-transform: uppercase; padding: 0; border: none; font-size: 14px;">
                <p style="margin-bottom: 30px; margin-top: 30px; font-size: 28px; line-height: 1.2;">
                  Please call with any info:
                  <br>
                  <span class="poster-phone-number"><?php echo $phoneNum; ?></span>
                </p>
              </td>
            </tr>
            <tr>
              <td colspan="2" style="text-align: center; padding: 0; border: none; font-size: 16px;">
                <p style="margin-bottom: 20px; text-align: center;">
                  <img src="<?php echo $imageUrl; ?>" alt="image" style="width: auto; height: auto; max-width: 100%; display: inline-block;" class="poster-pet-image poster-pet-image-main" />
                </p>
              </td>
            </tr>
          </table>
        </div>
      </div>
      <div class="poster-info-table-wrap">
        <table class="poster-info-table" cellspacing="0" cellpadding="0" style="width: 100%; border-collapse: collapse; margin-bottom: 0;">
          <td style="text-align: left; color: #3c3c3c; padding: 0; border: none; font-size: 16px;">
            <img src="<?php bloginfo('template_url'); ?>-child/images/logo-icon.png" alt="image" style="width: 70px; height: auto;" />
          </td>
          <td  style="text-align: right; color: #3c3c3c; font-size: 14px; padding: 0; border: none; font-size: 16px; font-weight: 600;">
            To Report This Pet Found , Enter ID Tag # on:
            <p style="font-size: 28px; font-weight: 600; margin: 0 0 0 0; color: #3c3c3c; line-height: 1.2;">WWW.IDTAG.COM</p>
          </td>
        </table>
      </div>
    </div>
  </div>
</div>
<div class="col-sm-4">
  <div class="mb-25">
    <a href="javascript:;" class="site-btn site-btn-light-blue text-center width-100 download-pdf">Download PDF <i class="fa fa-caret-right"></i></a>
  </div>
  <div class="mb-25">
    <a href="javascript:;" class="site-btn site-btn-red text-center width-100 print-btn">Print <i class="fa fa-caret-right"></i></a>
  </div>
  <h4>Purchase 25 Color Copies</h4>
  • High quality prints
  <br>
  • Rushed overnight shipping available
  <div class="mb-20"></div>
  <div class="mb-25">
    <a href="javascript:;" class="site-btn site-btn-light-blue width-100 text-center edit-small-poster"><i class="fa fa-caret-left"></i> Edit Poster</a>
  </div>
  <div>
    <a href="javascript:;" class="site-btn site-btn-red text-center width-100 purchase-poster">Purchase Posters $39.95 <i class="fa fa-caret-right"></i></a>
  </div>
</div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script type="text/javascript">
  jQuery(document).ready(function($){
    jQuery(".pet-name").change(function(){
      $("span.dog-name").text('"'+$(this).val()+'"');
    });
    jQuery(".pet-type").change(function(){
      $("span.poster-type").text($(this).val());
    });
    jQuery(".pet-breed").change(function(){
      $("span.poster-breed").text($(this).val());
    });
    jQuery(".color").change(function(){
      $("span.poster-color").text($(this).val());
    });
    jQuery(".phone-number").change(function(){
      $("span.poster-phone-number").text($(this).val());
    });
    jQuery(".reward").change(function(){
      $("span.user-reward").text("$"+$(this).val());
    });
    jQuery(".add-info").change(function(){
      $("span.extra-info").text($(this).val());
    });
    jQuery(".current-image").change(function(){
      if ($(this).prop('checked') == false) {
        $image = document.querySelector('input[type=file]');
        console.log($image);
        readURLL($image,'poster-pet-image');
      }else{
        var image = $(".pet-current-image").attr('src');
        $('.poster-pet-image').attr('src',image);
      }
    });
    jQuery(".pet-image").change(function(){
      if ($('.current-image').prop('checked') == false) {
        var image = document.querySelector('input[type=file]');
        console.log(image);
        readURLL(image,'poster-pet-image');
      }
    });
    jQuery(".download-pdf").on('click',function(){
      var dogName         = $(".pet-name").val();
      var type            = $(".pet-type").val();
      var breed           = $(".pet-breed").val();
      var color           = $(".color").val();
      var phoneNumber     = $(".phone-number").val();
      var serialNumber    = $(".serial-number").val();
      var reward          = $(".user-reward-main").text();
      var extraInfo       = $(".add-info").val();
      var image           = $(".poster-pet-image-main").attr('src');
      var postId          = "<?php echo $postId; ?>";
      var isDownload      = 1;
      var data = {
        'action':'downloadPdf',
        'dogName':dogName,
        'type':type,
        'breed':breed,
        'color':color,
        'phoneNumber':phoneNumber,
        'serialNumber':serialNumber,
        'reward':reward,
        'extraInfo':extraInfo,
        'image':image,
        'postId':postId,
        'isDownload':isDownload
      };
      ajaxRun(data, isDownload);
    });
    jQuery(".purchase-poster").on('click',function(){
      var dogName         = $(".pet-name").val();
      var type            = $(".pet-type").val();
      var breed           = $(".pet-breed").val();
      var color           = $(".color").val();
      var phoneNumber     = $(".phone-number").val();
      var serialNumber    = $(".serial-number").val();
      var reward          = $(".user-reward-main").text();
      var extraInfo       = $(".add-info").val();
      var image           = $(".poster-pet-image-main").attr('src');
      var postId          = "<?php echo $postId; ?>";
      var isDownload      = 0;
      var data = {
        'action':'downloadPdf',
        'dogName':dogName,
        'type':type,
        'breed':breed,
        'color':color,
        'phoneNumber':phoneNumber,
        'serialNumber':serialNumber,
        'reward':reward,
        'extraInfo':extraInfo,
        'image':image,
        'postId':postId,
        'isDownload':isDownload
      };
      ajaxRun(data, isDownload);
    });
    function ajaxRun(data, isDownload){
      $.ajax({
        type: 'POST',
        url: ajaxurl,
        data: data,
        xhrFields: {
          responseType: 'blob'
        },
        success: function (response, status, xhr) {
          if(isDownload){
            var filename = "";                   
            var disposition = xhr.getResponseHeader('Content-Disposition');

            if (disposition) {
              var filenameRegex = /filename[^;=\n]*=((['"]).*?\2|[^;\n]*)/;
              var matches = filenameRegex.exec(disposition);
              if (matches !== null && matches[1]) filename = matches[1].replace(/['"]/g, '');
            } 
            var linkelem = document.createElement('a');
            try {
              var blob = new Blob([response], { type: 'application/octet-stream' });                        

              if (typeof window.navigator.msSaveBlob !== 'undefined') {
                //   IE workaround for "HTML7007: One or more blob URLs were revoked by closing the blob for which they were created. These URLs will no longer resolve as the data backing the URL has been freed."
                window.navigator.msSaveBlob(blob, filename);
              } else {
                var URL = window.URL || window.webkitURL;
                var downloadUrl = URL.createObjectURL(blob);

                if (filename) { 
                // use HTML5 a[download] attribute to specify filename
                var a = document.createElement("a");

                  // safari doesn't support this yet
                  if (typeof a.download === 'undefined') {
                    window.location = downloadUrl;
                  } else {
                    a.href = downloadUrl;
                    a.download = filename;
                    document.body.appendChild(a);
                    a.target = "_blank";
                    a.click();
                  }
                } else {
                  window.location = downloadUrl;
                }
              }   
            } catch (ex) {
              console.log(ex);
            } 
          }else{
            window.location = "<?php echo site_url('cart'); ?>";
          }
        }
      });
    }
  });
</script>
<?php
