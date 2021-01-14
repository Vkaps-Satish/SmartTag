<?php get_header();

if(is_shop() || is_product_category() || is_product_tag()) {
	
	//page header for main shop page
	//nectar_page_header(woocommerce_get_page_id('shop'));
	 if ( version_compare( WC_VERSION, '3.0', '<' ) ) 
               nectar_page_header(woocommerce_get_page_id('shop'));
            else
            	nectar_page_header(wc_get_page_id('shop'));
	
} 

//change to 3 columsn per row when using sidebar
if (!function_exists('loop_columns')) {
	function loop_columns() {
		return 3; // 3 products per row
	}
}

?>

<div class="container-wrap">
	
	<div class="container main-content">
		
		<div class="row">		
			<?php

			 global $wp_query;
	         $cat = $wp_query->get_queried_object();

	         $product_id = $cat->ID;
	            $terms = get_the_terms ( $product_id, 'product_cat' );
	            
		        foreach ( $terms as $term ) {
				     $cat_name = $term->name;
				}
				// echo "ocean";
				// print_r($cat_name);
				// echo "ocean";
				// die;
			if ( function_exists( 'yoast_breadcrumb' ) ){ yoast_breadcrumb('<p id="breadcrumbs">','</p>'); } 
			
			$options = get_nectar_theme_options();  

 			$main_shop_layout = (!empty($options['main_shop_layout'])) ? $options['main_shop_layout'] : 'no-sidebar';
			$single_product_layout = (!empty($options['single_product_layout'])) ? $options['single_product_layout'] : 'no-sidebar';
			//single product layout
			if(trim($cat_name) == 'Protection Plans'){
				
				woocommerce_ProtectionPlan_content();
				
				 if($main_shop_layout == 'right-sidebar' || $main_shop_layout == 'left-sidebar'){ 
				
					add_filter('loop_shop_columns', 'loop_columns');
                 				}
                 
                 switch($main_shop_layout) {
					
				}
			//Main Shop page layout 
		     }
		  //    elseif(trim($cat_name) == 'Pet Protection Plans'){
		  //    	 if($main_shop_layout == 'right-sidebar' || $main_shop_layout == 'left-sidebar'){ 
				
				// 	add_filter('loop_shop_columns', 'loop_columns');
    //              				}
                 
    //              switch($main_shop_layout) {
				// 	case 'no-sidebar':
				// 		woocommerce_PetProtectionPlan_content(); 
				// 		break; 
				// 	case 'right-sidebar':

				// 		echo '<div id="post-area" class="col span_9">';
				// 			woocommerce_PetProtectionPlan_content();
				// 		echo '</div><!--/span_9-->';
						
				// 		echo '<div id="sidebar" class="col span_3 col_last">';
				// 		 	woocommerce_PetProtectionPlan_content();
				// 		echo '</div><!--/span_9-->';
						
				// 		break; 
						
				// 	case 'left-sidebar':
				// 		echo '<div id="sidebar" class="col span_3">';
				// 		 	woocommerce_PetProtectionPlan_content();
				// 		echo '</div><!--/span_9-->';
						
				// 		echo '<div id="post-area" class="col span_9 col_last">';
				// 			woocommerce_PetProtectionPlan_content();
				// 		echo '</div><!--/span_9-->';
				// 		break;

				// 	case 'fullwidth':
				// 		echo '<div class="full-width-content">';
				// 			woocommerce_PetProtectionPlan_content();
				// 		echo '</div>';
				// 		break; 
				// 	default: 
				// 		woocommerce_PetProtectionPlan_content();
				// 		woocommerce_ProtectionPlan_sidebar();
				// 		break; 
				// }

		  //  // woocommerce_cat_content();
		  //      }
		       elseif(is_shop() || is_product_category() || is_product_tag()) {
				
				if($main_shop_layout == 'right-sidebar' || $main_shop_layout == 'left-sidebar'){ 
				
					add_filter('loop_shop_columns', 'loop_columns');
                 				}
                
				switch($main_shop_layout) {
					case 'no-sidebar':
						woocommerce_content(); 
						break; 
					case 'right-sidebar':

						echo '<div id="post-area" class="col span_9">';
							woocommerce_content(); 
						echo '</div><!--/span_9-->';
						
						echo '<div id="sidebar" class="col span_3 col_last">';
						 	get_sidebar(); 
						echo '</div><!--/span_9-->';
						
						break; 
						
					case 'left-sidebar':
						echo '<div id="sidebar" class="col span_3">';
						 	get_sidebar(); 
						echo '</div><!--/span_9-->';
						
						echo '<div id="post-area" class="col span_9 col_last">';
							woocommerce_content(); 
						echo '</div><!--/span_9-->';
						break;

					case 'fullwidth':
						echo '<div class="full-width-content">';
							woocommerce_content();
						echo '</div>';
						break; 
					default: 
						woocommerce_content(); 
						break; 
				}

			}
			elseif(is_product()){
				if($single_product_layout == 'right-sidebar' || $single_product_layout == 'left-sidebar'){ 
					add_filter('loop_shop_columns', 'loop_columns');
				}
				
				switch($single_product_layout) {
					case 'no-sidebar':
						woocommerce_content(); 
						break; 
					case 'right-sidebar':

						echo '<div id="post-area" class="col span_9">';
							woocommerce_content(); 
						echo '</div><!--/span_9-->';
						
						echo '<div id="sidebar" class="col span_3 col_last">';
							get_sidebar(); 
						echo '</div><!--/span_9-->';

						break; 
						
					case 'left-sidebar':
						echo '<div id="sidebar" class="col span_3">';
						 	get_sidebar(); 
						echo '</div><!--/span_9-->';
						
						echo '<div id="post-area" class="col span_9 col_last">';
							woocommerce_content(); 
						echo '</div><!--/span_9-->';
						
						break; 
					default: 
						woocommerce_content(); 
						break; 
				}
		
			}
			
			//regular WooCommerce page layout 
			else {
				woocommerce_content(); 
			}
			
			?>

	
		</div><!--/row-->
		
	</div><!--/container-->

</div><!--/container-wrap-->

<?php get_footer(); ?>