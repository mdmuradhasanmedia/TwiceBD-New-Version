<?php get_header(); ?>
<?php get_template_part(featured);?> 
<?php get_template_part(hot);?> 


<div class="block_posts"><h2><i class="fab fa-stack-overflow"></i> Recent Update</h2>
	<ul class="rpul">
	    <?php $i = 1; if (have_posts()) : while (have_posts()) : the_post(); ?>
		    <li <?php  if($i % 2 == 0){ echo 'class="colores"'; } $i++;?>>
	    		<?php $thumbnail = get_template_directory_uri()."/img/no-image.png"; 
				if ( has_post_thumbnail() ) {
					the_post_thumbnail('featured',array("class" => "featured_image"));
				} else {
					echo '<img width="60" height="60" src='.$thumbnail.' class="featured_image" alt="noimage" />'; 
				} ?>
	    		<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a> 
	       		<p><font color="green"><i class="fa fa-clock"></i> <?php echo human_time_diff( get_the_time('U'), current_time('timestamp') ) . ' ago'; ?></font> | <a href="<?php the_permalink(); ?>#comments"><?php comments_number( '<i class="fa fa-comment"></i> 0', '<i class="fa fa-comment"></i> 1', '<i class="fa fa-comment"></i> %' ); ?></a> |<font color="grey"> <i class="fa fa-eye"></i> <?php echo getPostViews(get_the_ID()); ?> </font></p>
	    		</li>
		<?php endwhile;
        else :
		    get_template_part('post', 'noresults');
		endif; ?> 
		<?php if ($wp_query->max_num_pages > 1) get_template_part('navigation') ;?>
	</ul>
</div>


<div class="advertisement"><center>


</center></div>

<?php get_sidebar(); ?>
<?php get_footer(); ?>