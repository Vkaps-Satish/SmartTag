<?php
/*
 * Template Name: update posts
 */
get_header();
?>
<?php 
echo do_shortcode( '[gravityform id="2" update="6933"]' );
// add_action( 'gform_after_submission_5', 'after_submission', 10, 2 );
add_action( 'gform_after_submission_2', 'set_post_content', 10, 2 );
function set_post_content( $entry, $form ) {
 
    //getting post
    $post = get_post( $entry['post_id'] );
    
 
    //changing post content
    $post->post_content = 'Blender Version:' . rgar( $entry, '7' ) . "<br/> <img src='" . rgar( $entry, '8' ) . "'> <br/> <br/> " . rgar( $entry, '13' ) . " <br/> <img src='" . rgar( $entry, '5' ) . "'>";
 
    //updating post
    wp_update_post( $post );
}
?>