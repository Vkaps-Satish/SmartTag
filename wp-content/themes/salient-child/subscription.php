<?php
/*
 * Template Name: Susbcription PLan
 */
get_header();
?>
 
<div class="container">
		<table>
		<tr>
		  <form id="Form1" method="post">
			<td>
				<input type="submit" id="submit1" name="microchip" class ="" value="Smart Tag Microchip Protection Plan">
			</td>
		   </form>

			<form method="post" id="Form2">
			  <td>
				<input type="submit" id="submit2" name="id_Tag" value="Smart Id Tag Protection Plan">
		     </td>
		</form>
		
		</tr>
		</table>
		</div>
<?php 

      if(isset($_POST['id_Tag'])){
             	 $args = array( 'post_type' => 'product',
                      'product_cat' => 'Smart Id Tag Protection Plan');
       }elseif(isset($_POST['microchip'])){
                $args = array( 'post_type' => 'product',
                      'product_cat' => 'Smart Tag Microchip Protection Plan');
       }

         $productData = new WP_Query( $args );
	echo "<table>"."<tr>";
		while ( $productData->have_posts() ) : $productData->the_post(); global $product; 
			?> 
		
          <?php      
          /* Get variation attribute based on product ID */
				$product = new WC_Product_Variable( $post->ID );
				$variations = $product->get_available_variations();
				// echo "<pre>";
				// print_r($variations);
  
				// $var_data = [];
				?>
  
     
      
		 <?php 
		 echo "<td>";
              foreach ($variations as $variation) {
                
              	// echo $variation['variation_id']."=".$post->ID ;
			     // if($variation['variation_id'] == $post->ID ){
					// $var_data[] = $variation['attributes'];
					 $Plan = $variation['attributes']['attribute_plan']."</br>";
					 $display_price = $variation['display_price']."</br>";
					 $var_product_id = $variation['variation_id']."</br></br>";
					echo do_shortcode('[add_to_cart id="'.$var_product_id.'"]');
					//echo  WC()->cart->add_to_cart( $var_product_id );
                    
                    }
                echo "</td>";    
				// }
				  ?>
				
	       
           <?php endwhile;
           echo "</tr>"."</table>"; ?>

    <?php
     wp_reset_query(); ?>
  <script type="text/javascript">
		$(document).ready(function(){
			// $('#submit1').on("click",function() {
				$( "#Form1" ).submit(function(){
				  var singleValues = $( "#submit1" ).val();
				alert(singleValues);
		     $( "#submit1" ).addClass( "selected" );
		    });

		    $("#Form2").click(function(event){
		    	
		     $( "#submit2" ).addClass( "selected" );
		    });
    });

    </script>
<style>
.selected{
	background: red;
	}
	</style>
