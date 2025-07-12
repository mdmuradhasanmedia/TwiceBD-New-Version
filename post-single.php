<div class="breadcumbs_single">
    <div id="crumbs"><a href="<?php echo home_url() ?>">Home</a> › <?php the_category(', '); ?> › <span class="current"><?php the_title(); ?></span></div>
</div>

<div class="block_single"><h1><?php the_title(); ?></h1>
    <div class="post_paragraph">
	   
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