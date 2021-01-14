<?php 
/*
* Template Name: Report a Lost or Found Pet
*/

get_header(); ?>

<div class="container-wrap">
		
	<div class="container main-content">

		<div class="container">
			<div class="page-heading single-page-heading">
				<h1>Report a Lost and Found Pet Here</h1>
			</div>
		</div>
		
		<div class="row">
			<div class="col-sm-9">
			  <div class="single-blog-content"> 
			  	<div class="row">
			  		<div class="col-sm-6 rmb-15">
			  			<a href="<?php echo site_url().'/lost-and-found-pets/';?>" class="site-btn site-btn-red width-100 text-center">Report Found Pet <i class="fa fa-caret-right"></i></a>
			  		<!-- <?php
						if ( is_user_logged_in() ) {?>
						   <a href="<?php echo site_url().'/lost-and-found-pets/';?>" class="site-btn site-btn-red width-100 text-center">Report Found Pet <i class="fa fa-caret-right"></i></a>
						<?php } else { ?>
						    <a href="<?php echo site_url().'/login-to-smarttag/';?>" class="site-btn site-btn-red width-100 text-center">Report Found Pet <i class="fa fa-caret-right"></i></a>
					 	<?php } ?> -->
			  		</div>
			  		<div class="col-sm-6">

			  			<a href="<?php echo get_site_url(); ?>/my-account/report-my-pet-lost/" class="site-btn site-btn-red width-100 text-center">Report Lost Pet <i class="fa fa-caret-right"></i></a>
			  		</div>
			  	</div>
			  </div>
			</div>	
				<?php nectar_pagination(); ?>
               <div class="col-sm-3 main-sidebar-col border-sidebar">
                <div class="widget">
					<h3>Report a Found Pet</h3>
					<!-- acion="report-found-pet/" -->
					<form id="lostPetId" method="POST" name="LostPetform">
						<div class="field-div">
							<label>Enter SmartTag ID#</label>
							<input type="text" name="SmartTagid" id="PetId" />
							<b id="PetId-error"></b>
							<button type="submit" class="site-btn-red">
								Report <i class="fa fa-caret-right"></i>
							</button>
						</div>
					</form>
				</div>

				<div class="widget">
					<h3>Report a Missing Pet</h3>
					<p><img src="<?php echo get_site_url(); ?>/wp-content/uploads/2018/02/lost-sidebar-img.png" alt="image" /></p>
					<div>
						<?php
						if ( is_user_logged_in() ) { ?>
						    <a href="<?php echo get_site_url(); ?>/my-account/report-my-pet-lost/" class="site-btn">Report <i class="fa fa-caret-right"></i></a>
						<?php } else { ?>
						 <a href="<?php echo site_url() ?>/login-to-smarttag/" class="site-btn">Report <i class="fa fa-caret-right"></i></a>
					  	<?php }
						?>
						
					</div>
				</div>

				<?php echo do_shortcode("[stag_sidebar id='main-sidebar']"); ?>

				<div class="widget">
					<h3>Find a Local Shelter</h3>
					<p class="text-left">
						Change a life fur-ever and adopt a pet today! Find a local shelter near you by entering your zipcode below.
					</p>
					<p><img src="<?php echo site_url() ?>/wp-content/uploads/2018/02/lost-sidebar-img.png" alt="image" /></p>
					<form name="Shelter" id="Selt">
						<div class="field-div">
							<label>Enter Zipcode</label>
							<input type="text" name="Zipcode" />
							<button type="submit">
								Submit <i class="fa fa-caret-right"></i>
							</button>
						</div>
					</form>
				</div>
			</div>
	
			
		</div><!--/row-->
		
	</div><!--/container-->

</div><!--/container-wrap-->
<?php get_footer(); ?>
<script type="text/javascript">
 jQuery(document).ready(function ($) {
 $(function() {
	
	$("form[name='LostPetform']").validate({
		 		rules: {
		  			SmartTagid: {
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
	                          return $('#lostPetId :input[name="SmartTagid"]').val();
	                         }
	                      }
	                    }
				    }
		    	},
		    	messages: {
		    		SmartTagid: {
	                    remote: "This ID is not valid",
	                    minlength : "The SmartTag Id must be 8 digits.",
	                    maxlength : "The SmartTag Id must be 8 digits.",
	                },
		    	},
		    submitHandler: function(form) {

		    var pd = new FormData();
			pd.append($('#PetId').attr('name'),$('#PetId').val());
	     	pd.append('action','check_smartTag_id');
	     	 $.ajax({
	            type: 'POST',
	            url: ajaxurl,
	            data: pd,
	            contentType: false,
	            processData: false,
		            success: function(response) {
		             	var obj = jQuery.parseJSON( response );
		                console.log(obj);
		    	        if(obj.success == 1){
		    	        $('#PetId-error').text(obj.message).show().css('color', obj.color);
		                }else{
		                	window.location.href = "/report-found-pet/?pid="+obj.postId+"&title="+obj.postTitle;	
		                }
		        	}
				}); 
		    }
		});

	$("form[name='Shelter']").validate({
		 rules: {
		  		Zipcode: {
				        required: true,
				        }
		    	},
		    submitHandler: function(form) {
		    	alert("comming soon!!");
		    }
		});
	});
});
</script>

