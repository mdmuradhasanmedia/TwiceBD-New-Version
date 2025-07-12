<?php get_header(); ?>
    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
	<div class="breadcumbs_single">
    <div id="crumbs"><a href="<?php echo home_url() ?>">Home</a> › <?php the_category(', '); ?> › <span class="current"><?php the_title(); ?></span></div>

</div>

<div class="block_single"><h1><?php the_title(); ?></h1>
    <div class="post_paragraph">
	   <div class="g-ytsubscribe" data-channelid="UCfGwHXrngWOoo5tfE0ZYt9A" data-layout="default" data-count="default"></div></center>
<div class="zpathway" style="background: linear-gradient(rgb(181, 200, 229) 0%, rgb(201, 222, 254) 100%); border: 1px solid rgb(88, 140, 218); font-weight: 700; padding: 4px; width: auto;">
<b><marquee style="color: green; margin: -7px 0px; padding: 0px;"><a href="https://youtube.com/channel/UCfGwHXrngWOoo5tfE0ZYt9A">ইউটিউবে টুইচবিডিকে সাবস্ক্রাইব করুন</a></marquee></b></div>
		<?php the_content(''); ?>
	</div>
	<div class="post_options">
	    <table width="100%">
		    <td style="float: left;">
			    <span><?php echo human_time_diff ( get_the_time( 'U'), current_time ('timestamp') ) . ' ago' ; ?> (<?php the_date(); ?>)</span>
			</td>
			<td style="float: right; text-align: right">
			    <span><?php echo getPostViews(get_the_ID()); ?></span>
			</td>
		</table>
	</div>
</div>

<?php $user_id = get_the_author_meta('ID'); $cr_id = get_current_user_id();
	if ( (is_user_logged_in() && $user_id == $cr_id ) || current_user_can('administrator') || current_user_can('editor')){
	global $wpdb;
	$options1 = get_option('ln_options1'); 
	$url5 = $options1["plink_dash"];  ?>
	<div class="edit_post"><a href="<?php echo $url5.'?page=edit_post&post_id='.get_the_ID(); ?>"><?php _e('Edit'); ?></a></div>
<?php } ?>

	
<?php $post_link = get_permalink(); echo do_shortcode('[report_pg var="action" sub="'.$post_link.'"]'); ?>

	
<div class="author_block"><h2>About Author (<?php the_author_posts (); ?>)</h2>
    <div class="author_single">
	<table width="100%">
	    <td class="avata_post"><?php echo get_avatar( get_the_author_meta( 'ID' ), 60 ); ?></td>
		<td class="author_name"><?php the_author_posts_link(); ?>
		    <div class="user_role"><?php global $post; if ( user_can( $post->post_author, 'administrator' ) ) { echo 'Administrator'; } elseif ( user_can( $post->post_author, 'editor' ) ) { echo 'Admin'; } elseif ( user_can( $post->post_author, 'author' ) ) { echo 'Author'; } elseif ( user_can( $post->post_author, 'contributor' ) ) { echo 'Contributor'; } elseif ( user_can( $post->post_author, 'subscriber' ) ) { echo 'Subscriber';} else { echo 'Guest'; }?></div>
			<p><?php the_author_meta('user_description'); ?></p>
		</td>
	</table>
	</div>
</div>

<?php comments_template('', true); ?>

</div>
<?php
	endwhile; else :
		get_template_part('post', 'noresults');
    endif; 
	?>



<?php setPostViews(get_the_ID()); ?> 

<div class="block_posts"><h2>Related Posts</h2><ul class="rpul"> 
<?php $related = get_posts( array( 'category__in' => wp_get_post_categories($post->ID), 'numberposts' => 4, 'post__not_in' => array($post->ID) ) );
if( $related ) foreach( $related as $post ) {
setup_postdata($post); ?>

    <li><?php $thumbnail = get_template_directory_uri()."/img/no-image.png"; 
	    if ( has_post_thumbnail() ) { the_post_thumbnail('featured',array("class" => "featured_image"));
		} else {
			echo '<img width="60" height="60" src='.$thumbnail.' class="featured_image" alt="noimage" />'; 
		} ?>
	<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a> 
	<p><?php the_time('M j, Y'); ?> | <?php comments_popup_link( 'No Comments' , '1 Comment' , '% Comments' ); ?> | <?php echo getPostViews(get_the_ID()); ?></p></li>
 
<?php } wp_reset_postdata(); ?>
</ul></div>

<?php get_footer(); ?>