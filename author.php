<?php get_header(); ?> 

<?php $curauth = (isset($_GET['author_name'])) ? get_user_by('slug', $author_name) : get_userdata(intval($author));
    $user_info = get_userdata( $curauth->ID );
	$role = implode(',', $user_info->roles );
	$registered = $user_info->user_registered;
	$description = $user_info->description;
	$url = $user_info->user_url;
	$display_name = $user_info->display_name;
	$current_user = get_current_user_id();
?>

<?php if( $curauth->ID == $current_user ){ ?>
	<div class="edit_post"><a href="
<?php echo home_url(); ?>/wp-admin/profile.php">Edit Profile</a></div>
<?php } ?>

<div id="profile"><div class="block_posts">
    <h2 class="title">Profile Of <?php echo $display_name; ?></h2>
		<table width="100%" id="profile"><tr>
	    	<td width="70px"> <?php echo get_avatar( $user_info->ID, 65 ); ?></td> 
			<td valign="top" width="auto">
		    	<h3><?php echo $display_name; ?><?php if ( function_exists( 'wp_verification_badge' ) ) {
    wp_verification_badge($user_id); } ?> </h3> 
		    	<div class="user_role"><font color="red"><?php echo $role; ?></font></div> 
		    	<p><?php echo $description; ?></p> 
			</td>
		</tr></table> 
		
		<div class="author_info"> 
	    	<p>Registered on: <?php echo $registered; ?></p> 
			<p>Website: <a href="<?php echo $url; ?>"><?php echo $url; ?></a></p> 
			<p>Total Posts: <?php the_author_posts(); ?></p> 
			<p>User ID: <?php echo $user_info->ID; ?></p> 
		</div>
</div></div><!-- # Profile -->

<div class="block_posts"><h2><?php echo $display_name; ?>'s  Post</h2>
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
	       		<p><?php echo human_time_diff( get_the_time('U'), current_time('timestamp') ) . ' ago'; ?>  <a href="<?php the_permalink(); ?>#comments"><?php comments_number( 'No Comments', '1 Comment', '% Comments' ); ?></a></p>
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


<?php get_sidebar();?>
 <?php get_footer(); ?>

