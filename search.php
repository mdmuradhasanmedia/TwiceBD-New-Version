<?php get_header(); ?>


     <div class="block_posts">
     <h2>Search Results For '<?php the_search_query(); ?>'</h2>

<ul class="rpul">

<?php $access_key = 1; ?>
		<?php if ( have_posts() ): while ( have_posts() ): the_post();
?>


<li>

<?php  $thumbnail = get_template_directory_uri()."/img/no-image.png"; 
if ( has_post_thumbnail() ) {
 	the_post_thumbnail('featured',array("class" => "featured_image"));
} else {
 	echo '<img width="60" height="60" src='.$thumbnail.' class="featured_image" alt="noimage" />'; 
} ?>


 <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a> 
	<p> <font color="#800080">Posted By:</font> <font color="green"><a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) )?>" title=""><?php echo get_the_author() ?> </a></font> - <font color="fusica"><?php the_time('M j, Y'); ?></font> - <font color="teal"><?php echo human_time_diff( get_the_time('U'), current_time('timestamp') ) . ' ago'; ?></font> - <font color="#bb1919"><?php comments_popup_link( 'No Comments' , '1 Comment' , '% Comments' ); ?></font></p>
	</li>


<?php endwhile;
		else :
		get_template_part('post', 'noresults');
		endif; ?>

<?php if ($wp_query->max_num_pages > 1) get_template_part('navigation') ;?>

</ul>
</div>


<?php get_footer(); ?>