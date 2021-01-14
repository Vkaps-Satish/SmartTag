<?php 
/*
* Template Name:  Login to Email SmartTag
*/


get_header(); 
?>

<div class="container-wrap">
        
    <div class="container main-content">
        <div class="row">
            <div class="woo-sidebar col-sm-3">
                <?php echo do_shortcode("[stag_sidebar id='woocommerce']"); ?>
            </div>
            <div class="woo-content col-sm-9" id="woo-content">
                <!-- <form id="profileuser1" method="POST" enctype="multipart/form-data"> -->
                <?php if (has_post_thumbnail( $post->ID ) ): ?>
                    <?php $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'single-post-thumbnail' ); ?>
                    <div class="page-image">
                        <img src="<?php echo $image[0]; ?>" alt="image" />
                    </div>
                <?php endif; ?>
                <div class="page-heading">
                    <h1>Log in to SmartTag</h1>

                </div>
                <section class="multi-step-form" 11111>
                    <form id="signupform" method="POST" action="">      
                       <fieldset aria-label="Step Two" tabindex="-1" id="step-2" class="step-form-box">
                            <div class="contact-form" id="cus-info">
                                 <div class="field-wrap two-fields-wrap">
                                    <div class="field-div">
                                        <label>*Email or Phone Number: </label>
                                        <input type="text" name="email" placeholder="Enter Email or Phone Number" class="signupdata" />
                                    </div>
                                    <div class="field-div">
                                        <label>*Password</label>
                                        <input type="password" name="password" class="signupdata" />
                                    </div>
                                 </div>

                                <div class="step-btns">

                                    <button class="btn btn-default" type="submit">Log In<i class="fa fa-caret-right"></i></button>
                                </div>
                           </div>                           
                        </fieldset>
                    </form> 
                </section>                  
            </div>                  
            <?php //nectar_pagination(); ?>
          
        </div><!--/row-->
        
    </div><!--/container-->

</div><!--/container-wrap-->
<?php get_footer(); ?>
<!-- <script type="text/javascript">
	  jQuery(document).ready(function($) {
	  	     $('#signupform').on('submit',function(e) {
	  		    e.preventDefault();
	  		      var signup =  new FormData();
  		       signup.append('action', 'LoginWithSmartTag');
		         $.each($('#signupform .signupdata'), function() {
		         	console.log($(this).attr('name') +'kkkkkkkk'+ $(this).val());	    
                    signup.append($(this).attr('name'), $(this).val());
                 });
                  $.ajax({
                    type: 'POST',
                     url: ajaxurl,
                     data: signup,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        alert(response); // Append Server Response
                    }
                });
		  
	  		
	  	});
});
</script> -->

