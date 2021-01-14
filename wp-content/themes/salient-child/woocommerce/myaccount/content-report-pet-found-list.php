<?php 
$currentUserId  = get_current_user_id();
$postId         = $_GET['pet_id'];
$userId         = get_post_field( 'post_author', $postId );
if($currentUserId == $userId){
    $smarttagid     = get_post_meta($postId, "smarttag_id_number", true);
    $args=array(
        'post_type' => 'lost_found_pets',
        'post_status' => 'publish',

        'meta_query'=>array(
            'relation' => 'AND',
            array(
                'key' => 'smarttag_id_number',
                'value' => $smarttagid,
            ),
            array(
                'key' => 'pet_status',
                'value' => 1,
            ),
        )
    );
    $query = new WP_Query($args);
    while ( $query->have_posts() ) : $query->the_post();
        $postid = get_the_id();
    endwhile;
    $args=array(
        'post_type' => 'found_pet',
        'post_status' => 'publish',

        'meta_query'=>array(
            'relation' => 'AND',
            array(
               'key' => 'related_post_id',
               'value' => $postid,
            ),
            array(
               'key' => 'approve_status',
               'value' => 0,
            ),
        )
    );
    $out = new WP_Query($args);
    if ($out->have_posts()) {
        $i = 0;
        while ( $out->have_posts() ) : $out->the_post();
            $mypod = pods( 'found_pet', get_the_id() );  
            if ($i==0 || $i%2 == 0){
               echo '<div class="lost-found-row">';                
            }

            echo '<div class="found-col">
            <div class="lost-found-col-inner">
            <div class="lost-found-img">';
            if (has_post_thumbnail( get_the_id() ) ): 
               the_post_thumbnail(get_the_id());
           endif; 
           echo '</div>

           <h3 class="lost-found-title"> '.get_the_title().'</h3>
           <p><strong>ID Tag #:</strong> '.$mypod->display('smarttag').'</p>
           <p><strong>Finder Name:</strong> '.$mypod->display('finder_name').'</p>
           <p><strong>Finder Email:</strong> '.$mypod->display('finder_email').'</p>
           <p><strong>Finder Phone:</strong> '.$mypod->display('phone').'</p>
           <p><strong>Date:</strong> '.get_the_date('m/d/Y').'</p>
           <div class="lost-found-mi">
           <a href="'.get_the_permalink(get_the_id()).'" class="more-info-link">More Info <i class="fa fa-caret-right"></i></a>
           </div>
           <div class="lost-found-rm">
           <form action="'.site_url("/my-account/report-my-pet-lost/").'" method="post" class="update-post-status">
           <input type="hidden" name="post_id" value="'.get_the_id().'">
           <input type="hidden" name="related_post_id" value="'.$postid.'">
           <input type="hidden" name="action" value="updatePostStatusAndPetStatus">
           <a href="javascript:;" class="site-btn-success update-post-status-and-pet-status">Yes This is My Pet <i class="fa fa-caret-right"></i></a>
           </form>
           </div>
           </div>
           </div>';
           $j = ++$i;
           if ($j%2 == 0){
            echo '</div>';
        }
        ?>
        <script type="text/javascript">
           jQuery("a.update-post-status-and-pet-status").on('click',function(){
               jQuery(this).parent('form.update-post-status').submit();
           });
       </script>
       <?php 
    endwhile;
    }else{
       echo "There is no founder for this pet.";
    }
}else{
    echo '<div class="not-found-text width-100">You are not authorized, as you are not the owner of the pet.</div>';
}
