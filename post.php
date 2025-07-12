<li><?php  $thumbnail = get_template_directory_uri()."/img/no-image.png"; 
if ( has_post_thumbnail() ) {
 	the_post_thumbnail('featured',array("class" => "featured_image"));
} else {
 	echo '<img width="60" height="60" src='.$thumbnail.' class="featured_image" alt="noimage" />'; 
} ?>
    <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a> 
	<p><?php the_time('M j, Y'); ?> | <?php comments_popup_link( 'No Comments' , '1 Comment' , '% Comments' ); ?></p>
</li>