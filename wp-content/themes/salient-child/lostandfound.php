<?php 
/*
* Template Name: Lost and found
*/
get_header(); 
nectar_page_header($post->ID); 
global $plholderImg;


//full page
$fp_options = nectar_get_full_page_options();
extract($fp_options);

?>

<?php $thumb = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'full' );?>
	<?php
    if(has_post_thumbnail()) { ?>
        <div class="page-featured-img">
            <img src='<?php echo $thumb['0'];?>' alt='image' />
        </div>
<?php } ?>

<?php 
	$country = $pet_type = $state = NULL;
	$args = array( 'post_type' => 'lost_found_pets',
					'post_per_page'=>'-1',
					);
	$the_query = new WP_Query($args);
	$petData = get_posts( $args );
	$state = array();
	$country = array();
	$type = array();
	foreach ($petData as $value){
		 array_push($state,  get_post_meta($value->ID,'state',true));
		 array_push($country,  get_post_meta($value->ID,'country',true));
		 array_push($type, get_post_meta($value->ID,'pet_type',true));
	}
	$state1   = array_unique($state); 
	$country1 = array_unique($country);
	$type1    = array_unique($type); 
	$countries_obj = new WC_Countries();
	$countries = $countries_obj->__get('countries'); 
?>

<div class="container-wrap">
	
	<div class="<?php if($page_full_screen_rows != 'on') echo 'container'; ?> main-content">
		
		<div class="row">

			<div class="col-sm-9 main-content-col">

				<div class="page-heading">
					<h1><?php //echo get_the_title(); ?> Lost and Found Pets</h1>
				</div>

				<div class="lost-found-content">
					<form class="lost-found-filter-form" action="" method="post" id="filter">
						<div class="lost-found-filter">
							<div class="lost-found-filter-inner">
								<label for="Status">Status</label>
								<select name="Status" class="filter-data">
									<option value=NULL>Any</option>
									<option value="1">Lost</option>
									<option value="0">Found</option>	  
								</select>
							</div>
							<div class="lost-found-filter-inner">
								<label for="PetType">PetType</label>
								<select name="PetType" class="filter-data">
				         			<option value=NULL>Any</option>
				            		<?php foreach ($type1 as $value) {?>
							  		<option value="<?php echo $value;?>"><?php echo $value;?></option>
						  			<?php } ?>							  
								</select>
							</div>
							<div class="lost-found-filter-inner">
								<label for="Country">Country</label>
								<select name="Country" class="filter-data lost-country">
				       				<option value=NULL >Any</option>
				          			<?php foreach ($countries as $key => $value) {?>
						      		<option value="<?php echo $key;?>"><?php echo $value;?></option>
									<?php } ?>						  
								</select>
							</div>
							<div class="lost-found-filter-inner">
								<label for="State">State</label>
								<select name="State" class="filter-data lost-state">
					 				<option value=NULL>Any</option>		
								</select>
							</div>
							<div class="lost-found-filter-inner">
								<label for="Zip Code">Zip Code</label>
								<input type='text' name="zip_code" placeholder="Zip Code" class="filter-data">
							</div>
							<div class="lost-found-filter-inner">
								<input type="submit" value="Find Pets">
							</div>
						</div>
					</form>

					<div class="lost-found-row" id="filter-row">					
					    <?php 
						$args = array(
								'post_type' => 'lost_found_pets',
							    'post_per_page'=>'5',
								       );
							$the_query = new WP_Query($args); 
							if( $the_query->have_posts() ):
							while( $the_query->have_posts() ) : $the_query->the_post();
			                    $petmetaData = get_post_meta($post->ID); 
			                    //print_r( $petmetaData);die;
			                    $post_link  = get_permalink( $post->ID );
			                    $title = get_the_title($post->ID); 
			                ?>
		                        <div class="lost-found-col">
									<div class="lost-found-col-inner">
										<div class="lost-found-img">
								 <?php if (has_post_thumbnail( $post->ID ) ):
								 	$image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ));
									 		    ?>
					                  <a  href="<?php echo $post_link; ?>" class="more-info-link"><?php the_post_thumbnail($post->ID, "post-thumbnails"); ?></a>
									<?php  else :?>
									<a  href="<?php echo $post_link; ?>" class="more-info-link"><img src="<?=  wp_get_attachment_url($plholderImg); ?>" /></a>
									<?php endif; ?>
							</div>
								<h3 class="lost-found-title"><?php echo $title;?></h3>
								<p><strong>ID Tag #: </strong><?php echo $petmetaData['smarttag_id_number'][0];?></p>
								<p><strong>Pet Type/Breed: </strong><?php echo $petmetaData['pet_type'][0];?></p>
								<p><strong>Reward: </strong><?php echo '$'.$petmetaData['reward'][0]; ?></p>
								<p><strong>Lost Area: </strong><?php echo $petmetaData['city'][0].','. $petmetaData['state'][0].','. $petmetaData['country'][0];?></p>
								<p><strong>Date Lost: </strong><?php echo $petmetaData['pet_lost_date'][0];?></p>
								<div class="lost-found-mi">
									
									<a href="<?php echo $post_link; ?>" class="more-info-link">More Info <i class="fa fa-caret-right"></i></a>
								</div>
								<div class="lost-found-rm">
									<?php if($petmetaData['pet_status'][0]=='1') { ?>		
									<a href="<?php echo site_url().'/report-found-pet/?pid='.$post->ID.'&title='.$title ?>" class="site-btn site-btn-red">I Found This Pet <i class="fa fa-caret-right"></i></a>
									<?php } ?>
								</div>
							</div>
						</div>
								    
				 <?php endwhile;  endif; ?>
						
					</div>
				</div>
			<div id="test"></div>	
			</div>


			<div class="col-sm-3 main-sidebar-col border-sidebar">

				<div class="widget">
					<h3>Report a Found Pet</h3>
					<!-- acion="report-found-pet/" -->
					<form id="LostPet" method="POST" name="LostPetform">
						<div class="field-div">
							<label>Enter SmartTag ID#</label>
							<input type="text" name="SmartTagid" id="PetId" required="" />
							<b id="PetId-error"></b>
							<button type="submit" class="site-btn-red">
								Report <i class="fa fa-caret-right"></i>
							</button>
						</div>
					</form>
				</div>

				<div class="widget">
					<h3>Report a Missing Pet</h3>
					<p><img src="/wp-content/uploads/2018/02/lost-sidebar-img.png" alt="image" /></p>
					<div>
						<?php
						if ( is_user_logged_in() ) { ?>
						    <a href="<?php echo get_site_url(); ?>/my-account/report-my-pet-lost/" class="site-btn">Report <i class="fa fa-caret-right"></i></a>
						<?php } else { ?>
						 <a href="/login-to-smarttag/" class="site-btn">Report <i class="fa fa-caret-right"></i></a>
					  	<?php }
						?>
						
					</div>
				</div>

				<?php echo do_shortcode("[stag_sidebar id='main-sidebar']"); ?>

				<div class="widget">
					<h3>Find a Local Shelter</h3>
					<p class="text-left">
						Change a life forever and adopt a pet today! Find a local shelter near you by entering your zipcode below.
					</p>
					<p><img src="/wp-content/uploads/2018/02/lost-sidebar-img.png" alt="image" /></p>
					<form name="Shelter" id="">
						<div class="field-div">
							<label>Enter Zipcode</label>
							<input type="text" name="Zipcode"  />
							<button type="submit" class="site-btn-red">
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
				        }
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

	

 	$("body").on("change",".lost-country",function(){
		var country = $(this).val();	
		console.log(country);	
		var select = "<option value=NULL>Any</option>";
		$.each(window.addressStates[country], function(i, item) {
		    select += "<option value='"+i+"'>"+item+"</option>";
		});
		$(".lost-state").html(select);
	});
});

$('#filter').on('submit', function (e) {
            $('.loader-wrap').fadeIn();
                e.preventDefault();
                var sfd1 = new FormData();
                var id = $(this).attr("id");  
                console.log(id);
             $.each($('#filter .filter-data'), function() {
                sfd1.append($(this).attr('name'),$(this).val());
                console.log($(this).attr('name')+'ffff'+$(this).val());
                });

             sfd1.append('action', 'PetLostAndFoundFilter');
                $.ajax({
                    type: 'POST',
                    url: ajaxurl,
                    data: sfd1,
                    contentType: false,
                    processData: false,
                   success: function(response) {
                   	$('#filter-row').html(response);

                   },complete:function(){
                        $('.loader-wrap').fadeOut();
                    }
                });
           
          });
</script>