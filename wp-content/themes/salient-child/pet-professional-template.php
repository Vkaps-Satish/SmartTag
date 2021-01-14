<?php 
/*
* Template Name:  Pet Professional Page
*/
get_header(); 
?>
<script type="text/javascript">
	
	$(document).ready(function(){
	var str = location.href ;
	var n = str.lastIndexOf('#');
	console.log(str);
	var result = str.substring(n + 1);
	console.log(result);

	if(result == "veteinaians"){
		$("ul.swichtab-controller li a#pp-vete").trigger( "click" );
	}else if(result == "breeders"){
		$("ul.swichtab-controller li a#pp-breeders").trigger( "click" );
	}else if(result == "retailers"){
		$("ul.swichtab-controller li a#pp-retailers").trigger( "click" );
	}else{
		$("ul.swichtab-controller li a#pp-shelter").trigger( "click" );
	}

	$('body').on('click', 'li.menu-item', function(){
		var target = $(this).find('a').attr('href');
		
		if(target.indexOf('#veteinaians') > -1) {
			$("ul.swichtab-controller li a#pp-vete").trigger( "click" );

		}
		if(target.indexOf('#breeders') > -1) {
			$("ul.swichtab-controller li a#pp-breeders").trigger( "click" );

		}
		if(target.indexOf('#retailers') > -1) {
			$("ul.swichtab-controller li a#pp-retailers").trigger( "click" );

		}
		if(target.indexOf('#shelter') > -1) {
			$("ul.swichtab-controller li a#pp-shelter").trigger( "click" );

		}
	});

});

</script>
<div class="container-wrap">		
	<div class="container main-content">
		<div class="row">
			<div class="col-sm-9">
				<div class="page-heading heading-right-link">
					<h1><?php echo get_the_title(); ?></h1>
					<a href="<?php echo get_site_url(); ?>/testimonials/pet-professionals/">Read Pet Professionals Testimonials <i class="fa fa-caret-right"></i></a>
				</div>
				<div class="tabGroup pet-pro-tabs">
				    <ul class="swichtab-controller">
				        <li data-swichtab="controller"><a href="#pp-shelter" id="pp-shelter" >Shelter and Rescue</a></li>
				        <li data-swichtab="controller"><a href="#pp-vete" id="pp-vete">Veterinarians</a></li>
				        <li data-swichtab="controller"><a href="#pp-breeders" id="pp-breeders">Breeders</a></li>
				        <li data-swichtab="controller"><a href="#pp-retailers" id="pp-retailers">Retailers</a></li>
				    </ul>
				    <div class="swichtab-contents">
				        <div id="pp-shelter" class="swichtab-panel" data-swichtab="target">
				            <div class="pet-pro-content">
				            	<div class="page-featured-img">
				            		<img src="<?php bloginfo('template_url'); ?>-child/images/shelter-rescue-banner.jpg" alt="image" />
				            	</div>
				            	<h3>Shelter and Rescue Groups</h3>
				            	<p>SmartTag works with thousands of animal shelters and rescue groups across the US and CANADA in offering the best companion identification for all adopted pets.  SmartTag offers microchip and ID tag programs and provide engraving machines for groups that would like a personalized form of identification for each adopted pet. All SmartTag microchips are ISO universal microchips, the international standard read by all universal scanners. We offer 4 types of microchips, Standard, Mini, Data and Mini Data microchips. Every SmartTag microchip comes with a lifetime registration, a metal engravable ID tag, 1 month of complimentary pet insurance* and free information updates for the life of each dog and cat. SmartTag also offers many other benefits listed below.</p>
				            	<div class="tabGroup2">
								    <ul class="swichtab-controller">
								        <li data-swichtab="controller"><a href="#pp-shelter-micro">Shelter Microchip Programs</a></li>
								        <li data-swichtab="controller"><a href="#pp-shelter-id">Shelter ID Tag Programs</a></li>
								    </ul>
								    <div class="swichtab-contents">
								        <div id="pp-shelter-micro" class="swichtab-panel" data-swichtab="target">
								        	<div class="pet-pro-benefits-wrap">
								        		<div class="pet-pro-benefits-title-wrap">
								        			<span class="pet-pro-benefits-img">
								        				<img src="<?php bloginfo('template_url'); ?>-child/images/icons/micro-icon1.png" alt="image" />
								        			</span>
								        			<span class="pet-pro-benefits-title">
								        				<h3 class="mb-0">SmartTag Microchips Benefits:</h3>
								        			</span>
								        		</div>
								        		<div>
								            		<p>Hover " <i class="fa fa-plus"></i> " to show more information about each benefit.</p>
								        		</div>
								        	</div>
								            <div class="pet-pro-table-wrap">
								            	<?php get_template_part( 'register', 'smartTag-microchips-benefits' );
            									?>
								            	<p>* Platinum Plan Subscription Required</p>
								            	<div class="text-center mb-30">
								            		<a href="<?= site_url('/product-category/microchip-scanners/id-tags-products-microchips-and-scanners/') ;?>" class="site-btn site-btn-light-blue">Buy SmartTag Microchips and Scanners <i class="fa fa-caret-right"></i></a>
								            	</div>
								            	<h3>Why Buy SmartTag Microchips</h3>
								            	<p><strong>Compare how our Microchips SmartTag stacks up against the competition.</strong></p>
								            	<p>Hover " <i class="fa fa-plus"></i> " to show more information about each benefit.</p>
					            				<?php get_template_part( 'register', 'smartTag-microchips-features' );
            						?>
								            	<div class="text-center">
								            		<a href="<?= site_url('/product-category/microchip-scanners/id-tags-products-microchips-and-scanners/') ?>" class="site-btn site-btn-light-blue">Order SmartTag Microchips and Scanners <i class="fa fa-caret-right"></i></a>
								            	</div>
								            </div>
								        </div>
								        <div id="pp-shelter-id" class="swichtab-panel" data-swichtab="target">
								            <h3>Shelter ID Tag Program Options</h3>
								            <div class="program-option mb-35">
								            	<div class="grey-box-head mb-15">
									            	<h4 class="mb-0">Option 1</h4>
									            </div>
									            <h4 class="color-dark-blue">Free Engraving Machine and Free SmartTag Pet ID Tags</h4>
									            <p>SmartTag will provide your group with a free Engraving Machine and free SmartTag ID tags. In order to qualify for the engraving machine, your group must place more than 750 pets a year and include a 1-year or lifetime plan with each adoption.  The 1-year plan is $5.00 and the lifetime plan is $15.00, both plans include free replacement ID tags if lost or damaged.</p>
									            <p class="text-center">
									            	<img src="<?php bloginfo('template_url'); ?>-child/images/option1-img.png" alt="image" />
									            </p>
								            </div>
								            <div class="program-option mb-35">
								            	<div class="grey-box-head mb-15">
									            	<h4 class="mb-0">Option 2</h4>
									            </div>
									            <h4 class="color-dark-blue">SmartTag will provide your group with free pet ID Tags with a LIFETIME subscription to all of our services. (Retail value $50 each).</h4>
									            <p>You will be provided with a 3-month supply of SmartTag pet ID tags to get you started, 20 various styles and colors. A SmartTag will be given out with each adoption and can also be sold to recovered pets or used at fundraisers. The cost for the adopter is $15.00 for the lifetime plan. Most all groups incorporate this fee into their adoption fees. SmartTag will invoice your group for the ID tags at the end of each month based on how many SmartTags have been activated. We will be provided with a registration sheet for each adoption via email or fax, unless you use one of the shelter software’s we are integrated with.</p>
								            </div>
								            <div class="program-option mb-35">
								            	<div class="grey-box-head mb-15">
									            	<h4 class="mb-0">Option 3</h4>
									            </div>
									            <h4 class="color-dark-blue">SmartTag will provide your group with free pet ID Tags to give away with each adoption with a 1-year plan. (Retail value $20 each).</h4>
									            <p>You will be provided with a 3-month supply of SmartTag pet ID tags to get you started, 20 various styles and colors. A SmartTag will be given out with each adoption and can also be sold to recovered pets or used at fundraisers. The cost for the adopter is $5.00. Most groups incorporate this fee in their adoption fees. SmartTag will invoice your group for the ID tags at the end of each month based on how many SmartTags have been activated. We will be provided with a registration sheet for each adoption via email or fax, unless you use one of the shelter software’s we are integrated with.</p>
									            <p>If you have any questions about any of our animal welfare programs, please call (201) 537 - 5644, or submit inquiry using the form on the right sidebar.</p>
									            <p><strong>Also, we offer all groups collars and leashes at our cost. All of the collars and leashes come in a flexible and comfortable black nylon style. We offer a wide variety of different colors for manufacturing orders that place over 1000 units.</strong></p>
									            <p class="text-center">
									            	<img src="<?php bloginfo('template_url'); ?>-child/images/option2-img.png" alt="image" />
									            </p>
									            <p><strong>If you have any questions about any of our animal welfare programs, please call (201) 537 - 5644, or submit inquiry using the form on the right sidebar". BUT there is no right sidebar form. We can either add the form or for to save time just remove the form text and replace it with "submit inquiry on our wholesale page here" which will be linked to our wholesale page, or we can just add our support email to this text to make it easier.</strong></p>
								            </div>
								        </div>
									</div>
								</div>
				            </div>
				        </div>
				        <div id="pp-vete" class="swichtab-panel" data-swichtab="target">
				            <div class="pet-pro-content">
				            	<div class="page-featured-img">
				            		<img src="<?php bloginfo('template_url'); ?>-child/images/vete-banner.jpg" alt="image" />
				            	</div>
				            	<h3>Veterinarians</h3>
				            	<p>SmartTag works with thousands of veterinarians across the US and CANADA in offering the best companion identification for all their clients. All SmartTag microchips are ISO universal microchips, the international standard read by all universal scanners. We offer 4 types of microchips, Standard, Mini, Data and Mini Data microchips. Smarttag microchips can be used for dogs, cats, horses, reptiles, ferrets and small mammals, birds, fish and livestock.  Every SmartTag microchip comes with a lifetime registration, a metal engravable ID tag, 2 months of free pet insurance* and free information updates for the life of each dog and cat. SmartTag also offers many other benefits listed below.</p>
				            	<div class="pet-pro-benefits-wrap">
					        		<div class="pet-pro-benefits-title-wrap">
					        			<span class="pet-pro-benefits-img">
					        				<img src="<?php bloginfo('template_url'); ?>-child/images/icons/micro-icon1.png" alt="image" />
					        			</span>
					        			<span class="pet-pro-benefits-title">
					        				<h3 class="mb-0">SmartTag Microchips Benefits:</h3>
					        			</span>
					        		</div>
					        		<div>
					        			<p>Hover " <i class="fa fa-plus"></i> " to show more information about each benefit.</p>
					        		</div>
					        	</div>
					            <div class="pet-pro-table-wrap">
					            	<?php get_template_part( 'register', 'smartTag-microchips-benefits' );
            						?>
					            	<p>* Platinum Plan Subscription Required</p>
					            	<div class="text-center mb-30">
					            		<a href="<?= site_url('/product-category/microchip-scanners/id-tags-products-microchips-and-scanners/') ;?>" class="site-btn site-btn-light-blue">Buy SmartTag Microchips and Scanners <i class="fa fa-caret-right"></i></a>
					            	</div>
					            	<h3>Why Buy SmartTag Microchips</h3>
					            	<p><strong>Compare how our Microchips SmartTag stacks up against the competition.</strong></p>
					            	<p>Hover " <i class="fa fa-plus"></i> " to show more information about each benefit.</p>
					            	<?php get_template_part( 'register', 'smartTag-microchips-features' );
            						?>
					            	<div class="text-center">
					            		<a href="<?= site_url('/product-category/microchip-scanners/id-tags-products-microchips-and-scanners/') ?>" class="site-btn site-btn-light-blue">Order SmartTag Microchips and Scanners <i class="fa fa-caret-right"></i></a>
					            	</div>
					            </div>
				            </div>
				        </div>
				        <div id="pp-breeders" class="swichtab-panel" data-swichtab="target">
				            <div class="pet-pro-content">
				            	<div class="page-featured-img">
				            		<img src="<?php bloginfo('template_url'); ?>-child/images/breed-banner.jpg" alt="image" />
				            	</div>
				            	<h3>Breeders</h3>
				            	<p>SmartTag works with thousands of breeders across the US and CANADA in offering the best companion identification for all their new litters. All SmartTag microchips are ISO universal microchips, the international standard read by all universal scanners. We offer 4 types of microchips, Standard, Mini, Data and Mini Data microchips. Every SmartTag microchip comes with a lifetime registration, a metal engravable ID tag, 2 months of free pet insurance* and free information updates for the life of each dog and cat. SmartTag also offers many other benefits listed below.</p>
				            	<div class="pet-pro-benefits-wrap">
					        		<div class="pet-pro-benefits-title-wrap">
					        			<span class="pet-pro-benefits-img">
					        				<img src="<?php bloginfo('template_url'); ?>-child/images/icons/micro-icon1.png" alt="image" />
					        			</span>
					        			<span class="pet-pro-benefits-title">
					        				<h3 class="mb-0">SmartTag Microchips Benefits:</h3>
					        			</span>
					        		</div>
					        		<div>
					        			<p>Hover " <i class="fa fa-plus"></i> " to show more information about each benefit.</p>
					        		</div>
					        	</div>
					            <div class="pet-pro-table-wrap">
					            	<?php get_template_part( 'register', 'smartTag-microchips-benefits' );
            						?>
					            	<p>* Platinum Plan Subscription Required</p>
					            	<div class="text-center mb-30">
					            		<a href="<?= site_url('/product-category/microchip-scanners/id-tags-products-microchips-and-scanners/') ;?>" class="site-btn site-btn-light-blue">Buy SmartTag Microchips and Scanners <i class="fa fa-caret-right"></i></a>
					            	</div>
					            	<h3>Why Buy SmartTag Microchips</h3>
					            	<p><strong>Compare how our Microchips SmartTag stacks up against the competition.</strong></p>
					            	<p>Hover " <i class="fa fa-plus"></i> " to show more information about each benefit.</p>
					            	<?php get_template_part( 'register', 'smartTag-microchips-features' );
            						?>
					            	<div class="text-center">
					            		<a href="<?= site_url('/product-category/microchip-scanners/id-tags-products-microchips-and-scanners/') ?>" class="site-btn site-btn-light-blue">Order SmartTag Microchips and Scanners <i class="fa fa-caret-right"></i></a>
					            	</div>
					            </div>
				            </div>
					    </div>
				        <div id="pp-retailers" class="swichtab-panel" data-swichtab="target">
				            <div class="pet-pro-content">
				            	<div class="page-featured-img">
				            		<img src="<?php bloginfo('template_url'); ?>-child/images/retailers-banner.jpg" alt="image" />
				            	</div>
				            	<h3>Retailers</h3>
				            	<p>SmartTag Pet ID tags have been sold in thousands of retailers across the US and CANADA. SmartTag offers a variety of over 26 various brass ID tag styles in 3 sizes,  sold with ID tag sales display options. Each SmartTag pet ID tag is packaged in clam shell packaging, free replacement ID tags are offered to all customers if they are ever lost or damaged. SmartTag also offers custom ID tags. We can manufacture any style, color or logo you request. Minimum quantities are required for all custom ID tags.  To request a quote please fill out the form below. See the bottom of this page for examples.</p>
				            	<h3>Request a Quote</h3>
				            	<div class="contact-form">
				            		<?php echo do_shortcode("[gravityform id=15 title=false description=false ajax=true tabindex=49]"); ?>
				            	</div>
				            </div>
					    </div>
					</div>
				</div>
			</div>
			<div class="col-sm-3">
		        <?php echo do_shortcode("[stag_sidebar id='main-sidebar']"); ?>
		    </div>
		</div>
	</div>
</div>
<?php get_footer(); ?>

