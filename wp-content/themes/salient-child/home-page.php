<?php 

/* Template Name: Home Page */?>

<?php get_header(); ?>

<?php nectar_page_header($post->ID); ?>

<?php global $woocommerce; ?>


<div class="container-wrap">
        <div class="container main-content">
		<div class="row">
		    <div class="clear"></div>
		        <form class="single-product" id="single-product" action="" method="post">
		        	<p><h2>Custom Engrave Your Pet ID Tag:</h2></p>
		        	<div class="container">
        				<div class="row">
        					<div class="col-sm-2"></div>
        					<div class="col-sm-2">
        			<div class="text">
        							
					<label>Select a Type:</label>
					<select id="selectType" name="type">
						<option value="0">Select Type</option>
						<option value="bone" product="brass">Brass Bone</option>
						<option value="bone" product="aluminum">Aluminum Bone</option>
						<option value="circle" product="brass">Brass Circle</option>
						<option value="circle" product="aluminum">Aluminum Circle</option>
						<option value="heart" product="brass">Brass Heart</option>
						<option value="heart" product="aluminum">Aluminum Heart</option>
					</select>
        			</div>
        					</div>
        					<div class="col-sm-2">
        						<div class="text">
        							<label>Select Size:</label>
        							<select id="selectSize" name="size">
        								<option value="0">Select Size</option>
        								<option value="big">Large</option>
        								<option value="small">Small</option>  
        							</select>
        						</div>
        					</div>
        					<div class="col-sm-4"></div>
        					<div class="col-sm-2"></div>
        				</div>
        				<div class="row">
        					<div class="col-sm-2"></div>
        					<div class="col-sm-4">
        						<div class="text">
        							<label>Select a Design:</label>
                                                        <select id="selectDesign" name="design">
                                                        <option value="0">Select design</option>
                                                        <option value="design-1" class="design">Design 1</option>
                                                        <option value="design-2" class="design">Design 2</option>
                                                        <option value="design-3" class="design">Design 3</option>
                                                        <option value="blue" class="color">Blue</option>
                                                        <option value="green" class="color">Green</option>
                                                        <option value="pink" class="color">Pink</option>
                                                        <option value="red" class="color">Red</option>
                                                        <option value="white" class="color">White</option> 

                                                	</select>			
                                                </div>
        					</div>
        					<div class="col-sm-4"></div>
        					<div class="col-sm-2"><input type="submit" value="Continue Customizing" id="save"></div>
        				</div>
        			</div>
        		</form>	        
		    <div class="clear"></div>
		</div><!--/row-->
		
	</div><!--/container-->
	
</div>
<!-- Gaurav -->
<script type="text/javascript">
	jQuery(document).ready(function () {
		jQuery("#selectType").on('change', function () {
			var product = jQuery('option:selected', this).attr('product');
			if (product == "aluminum") {
				jQuery("#single-product").attr('action','<?php echo get_site_url(); ?>product/aluminum-id-tag/');
                                jQuery(".design").hide();
                                jQuery(".color").show();
                                jQuery("#selectDesign").attr("name","color");
			}else{
				jQuery("#single-product").attr('action','<?php echo get_site_url(); ?>product/brass-id-tag/');
                                jQuery(".color").hide();
                                jQuery(".design").show();
                                jQuery("#selectDesign").attr("name","design");
			}
		});
                jQuery(".color").hide();
	});
</script>
<?php get_footer(); ?>