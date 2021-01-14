
<?php 
/*
* Template Name:  Smarttag Hero
*/
get_header(); 
?><div class="container-wrap testi-page">
		
	<div class="container main-content">
		
		<div class="row">

			<div class="col-sm-9">
				<div class="page-heading">
					<h1>Recommend a Hero</h1>
				</div>
				<div class="testi-content">
					<?php echo do_shortcode("[gravityform id=16 title=false description=false ajax=true tabindex=49]"); ?>					
				</div>						
			</div>
			<div class="col-sm-3">
				<?php echo do_shortcode("[stag_sidebar id='main-sidebar']"); ?>
			</div>

		</div>
		
	</div><!--/container-->

</div><!--/container-wrap-->
	
<?php get_footer(); ?>