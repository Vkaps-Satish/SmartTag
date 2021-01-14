<?php 
/*
* Template Name: Single Lost Founnd Pets
*/
get_header(); ?>

<?php // nectar_page_header(get_option('page_for_posts')); ?>

<?php 
    while( have_posts() ) :the_post(); 
	    $post_id = get_the_ID();
		$petData = get_post_meta($post_id);
		$title = get_the_title($post_id);

		if($petData['pet_status'][0]==1){
	     $Status ='Lost'; 
	    }else{
	    	$Status ='Found';
	    }
	    $full_title = $title.' ('.$Status.')';
    endwhile;
 ?>
<div class="container-wrap 11">
    <div class="container main-content">
       <div class="container">
			<div class="page-heading single-page-heading">
				<h1>Lost and Found Pets</h1>
			</div>
		</div>
		  <div class="row">
             <div class="col-sm-9">
			     <div class="single-blog-content">
					<div class="mar-bot">
						<a href="javascript:history.back()" class="more-info-link"><i class="fa fa-caret-left"></i>&nbsp; Back To Lost and Found Pets</a>
					</div>
					<div class="single-blog-list-wrap">
						<?php if(have_posts()) : while(have_posts()) : the_post(); ?>
						<div class="single-blog-list">
							<div class="single-blog-list-content">
								<h3 class="single-blog-title">
									<?php echo  $full_title;?>
								</h3>
								<div class="single-blog-img lost-single-img">
									<?php echo get_the_post_thumbnail(); ?>
								</div>
								<div class="row">
									<div class="col-sm-6">
										<div class="custom-panel">
											<div class="custom-panel-head">
										<h4>Pet Information</h4>
											</div>
											<div class="custom-panel-text">
										<p><strong>ID Tag #: </strong><?php echo $petData['smarttag_id_number'][0]?></p>
										<p><strong>Lost Address: </strong><?php echo $petData['city'][0].','. $petData['state'][0].','. $petData['country'][0];?></p>
											<p><strong>Pet Type/Breed: </strong><?php echo $petData['pet_type'][0]."/".$petData['primary_breed'][0]?></p>
												<p><strong>Secondary breed: </strong> <?php echo $petData['secondary_breed'][0]?></p>
												<p><strong>Weight: </strong> 18 lbs</p>
												<p><strong>Date of Birth:</strong><?php echo $petData['pet_date_of_birth'][0]?></p>
												<p><strong>Gender: </strong><?php echo $petData['gender'][0]?></p>
											<p><strong>Primary color: </strong><?php echo $petData['primary_color'][0]?></p>
												<p><strong>Neutered/Spayed: </strong> Yes</p>
												<p><strong>Unique Features: </strong> <?php echo $petData['description'][0]?></p>
												<p><strong>Reward: </strong><?php echo $petData['reward'][0];?></p>
											</div>
										</div>
									</div>
									<div class="col-sm-6">
											<div class="custom-panel-head">
												<h4>Lost/Found Status</h4>
											</div>
											  <div class="custom-panel-text">
                                                 <p><strong>Pet Status: </strong><?php echo $Status;?></p>
												<?php if($petData['pet_status'][0]){?>
												<a href="<?php echo site_url().'/report-found-pet/?pid='.$post_id.'&title='.$title.'&Stagid='.$petData['smarttag_id_number'][0]?>" class="site-btn site-btn-red">I Found This Pet <i class="fa fa-caret-right"></i></a>
												<?php } ?>
											  </div>								   
								    <div class="custom-panel">
											<div class="custom-panel-head">
												<h4>Subscription Information</h4>
											</div>
											<div class="custom-panel-text">
									  <?php

									     $pet_profile_id = $petData['id'][0];
									     $postmeta = get_post_meta($pet_profile_id);
									     $subscriptionId = $postmeta['smarttag_subscription_id'][0];
									     if(!empty($subscriptionId)){
										 $subscription = wc_get_order($subscriptionId); // Or: new 
										foreach( $subscription->get_items() as $item_id => $product_subscription ){
											  $product_name  = $product_subscription->get_name();
											  $proname = explode(",",$product_name);
											   }
                                             }
											    ?>
											<p><strong>Pet Protection Plan:</strong> <?php if(!empty($proname)){ echo $proname['0'];}?></p>
											<p><strong>Effective Date:</strong> <?php if(!empty($proname)){ echo $proname['1'];}?></p>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<?php endwhile; endif; ?>
					</div>						
				</div>					
				<?php nectar_pagination(); ?>

			</div>
			
			<div class="col-sm-3 main-sidebar-col border-sidebar">

				<div class="widget">
					<h3>Report a Found Pet</h3>
					<!-- acion="report-found-pet/" -->
					<form id="LostPet" method="POST">
						<div class="field-div">
							<label>Enter SmartTag ID#</label>
							<input type="text" name="SmartTagid" id="PetId" />
							<p id="RptMes" style="display:none;color:red;"></p>
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
						<a href="<?php echo get_site_url(); ?>/my-account/report-my-pet-lost/" class="site-btn">Report <i class="fa fa-caret-right"></i></a>
					</div>
				</div>

				<?php echo do_shortcode("[stag_sidebar id='main-sidebar']"); ?>

				<div class="widget">
					<h3>Find a Local Shelter</h3>
					<p class="text-left">
						Change a life fur-ever and adopt a pet today! Find a local shelter near you by entering your zipcode below.
					</p>
					<p><img src="<?php echo get_site_url(); ?>/wp-content/uploads/2018/02/lost-sidebar-img.png" alt="image" /></p>
					<form>
						<div class="field-div">
							<label>Enter Zipcode</label>
							<input type="text" name="" />
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
 $('#LostPet').on('submit', function (e) {
	 		var pd = new FormData();
	 		e.preventDefault();
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
            	     	$('#RptMes').text(obj.message).show();
	                    }else{
		                	window.location.href = "/report-found-pet/?pid="+obj.postId+"&title="+obj.postTitle;	
		                }
                	}
       			}); 
	 	
			});
		});
</script>