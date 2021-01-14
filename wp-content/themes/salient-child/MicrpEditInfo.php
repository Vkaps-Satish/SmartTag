<?php 
/*
* Template Name: Universal Microchip Edit
*/

get_header(); ?>

<script type="text/javascript">
	var jQuery = jQuery.noConflict();
    jQuery(document).ready(function($){
    	 var ajaxurl = "<?php echo admin_url('admin-ajax.php'); ?>";
	    $('body').on('change', 'input:checkbox', function(e) {
	          var ufd = $('#IdTagProduct').serialize();
	           $.ajax({
	                    type: 'POST',
	                    url: ajaxurl,
	                    data: ufd,
	                   
	                    success: function(response) {
	                        alert(response); // Append Server Response
	                    }
	                });
	          });
	     });
</script>


<section class="content-section custom-id-tag-section">
	<div class="container">
		<div class="section-content">
			<form class="custom-id-tag-form site-form" id="IdTagProduct" method="post" > 
                <input type="hidden" name="action" value="add_id-tag_into_cart">
				<div class="row">
					<div class="col-sm-6">
						<h2 class="section-title">Custom Engrave Your Pet ID Tag:</h2>
						<div class="error"></div>
						<div class="row">
							<div class="col-sm-6">
								<div class="field-box">
									<label class="field-label">Select a Type:</label>
									<div class="field-div custom-select-div">
										<div class="custom-select-wrap" id="selectType">
									    <select class="custom-select-box pro-data"  name="attribute_pa_ttype">
									    		<option value="0">Select Type</option>
												<option value="bone" data-product="aluminum">Aluminum Bone</option>
												<option value="bone" data-product="brass">Brass Bone</option>
												<option value="circle" data-product="aluminum">Aluminum Circle</option>
												<option value="circle" data-product="brass">Brass Circle</option>
												<option value="heart" data-product="aluminum">Aluminum Heart</option>
												<option value="heart" data-product="brass">Brass Heart</option>
											</select>
									    </div>								
									</div>
								</div>
							</div>
							<div class="col-sm-6">
								<div class="field-box">
									<label class="field-label">Select Size:</label>
									<div class="field-div custom-select-div">
										<div class="custom-select-wrap">
									    	<select class="custom-select-box pro-data" id="selectSize" name="attribute_pa_size">
									    		<option value="0">Select Size</option>
												<option value="small">Small (1 in / 2.54 cm)</option>
												<option value="big">Large (1.5 in / 3.81 cm)</option>
											</select>
									    </div>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-sm-12">
								<div class="field-box">
									<label class="field-label">Select a Design:</label>
									<div class="field-div"  id="stylee">
										<div class="custom-radio-box circle" data-toggle="buttons">
										    <label class="btn active" role="button">
										      <input type="radio" value="circle-1" name="attribute_pa_style" required checked="checked" class="style-radio pro-data" data-name="design-circle">
										      <div class="custom-radio-img">
										      	  <img src="<?php bloginfo('template_url'); ?>-child/images/flower_circle_shape.png" alt="radio image" data-name="design-circle"/>
										      </div>
										    </label>
										    <label class="btn" role="button">
										      <input type="radio" value="circle-2" name="attribute_pa_style" class="style-radio" data-name="design-circle">
										      <div class="custom-radio-img pro-data">
										      	  <img src="<?php bloginfo('template_url'); ?>-child/images/pink_paw_circle.png" alt="radio image" data-name="design-circle"/>
										      </div>
										    </label>
										    <label class="btn" role="button">
										      <input type="radio" value="circle-3" name="attribute_pa_style" class="style-radio pro-data" data-name="design-circle">
										      <div class="custom-radio-img">
										      	  <img src="<?php bloginfo('template_url'); ?>-child/images/pink_paw_circle_shape.png" alt="radio image" data-name="design-circle"/>
										      </div>
										    </label>
										    <label class="btn" role="button">
										      <input type="radio" value="circle-4" name="attribute_pa_style" class="style-radio pro-data" data-name="design-circle">
										      <div class="custom-radio-img">
										      	  <img src="<?php bloginfo('template_url'); ?>-child/images/smarttag_circle_shape.png" alt="radio image" data-name="design-circle"/>
										      </div>
										    </label>
										    <label class="btn" role="button">
										      <input type="radio" value="circle-5" name="attribute_pa_style" class="style-radio pro-data" data-name="design-circle">
										      <div class="custom-radio-img">
										      	  <img src="<?php bloginfo('template_url'); ?>-child/images/b3back_paw_circle.png" alt="radio image" data-name="design-circle"/>
										      </div>
										    </label>
										    <label class="btn" role="button">
										      <input type="radio" value="circle-6" name="attribute_pa_style" class="style-radio pro-data" data-name="design-circle">
										      <div class="custom-radio-img">
										      	  <img src="<?php bloginfo('template_url'); ?>-child/images/black_paw_circle_shape.png" alt="radio image" data-name="design-circle"/>
										      </div>
										    </label>
										</div>
										<div class="custom-radio-box heart" data-toggle="buttons">
										    
										    <label class="btn" role="button">
										      <input type="radio" value="heart-2" name="attribute_pa_style" class="style-radio pro-data" data-name="design-heart">
										      <div class="custom-radio-img">
										      	  <img src="<?php bloginfo('template_url'); ?>-child/images/crown_heart_shape.png" alt="radio image" data-name="design-heart"/>
										      </div>
										    </label>
										</div>
										 <div>
                                             <label for="Price">
                                             	<?php ?>
										 </div>
										 <div>
                                             <label>
                                             	<input type="checkbox"> Yes I want a custom engraved ID Tag<br>
                                             	<input type="checkbox"> Yes I don't want an engraved ID Tag<br>
										 </div>
									</div>
						 		</div>
							</div>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
</section>
