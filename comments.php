<?php

// Do not delete these lines
	if (!empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
		die ('Please do not load this page directly. Thanks!');

	if ( post_password_required() ) { ?>

<p class="nocomments">Password protected.</p>
<?php
		return;
	}
?>
<!-- You can start editing here. -->
<div class="block_comment">

<a name="comments" id="comments"></a>
<?php if ( have_comments() ) : ?>

  <h3 id=comments"><?php comments_number('No responses', '1 responses', '% responses');?> to
&#8220;<?php the_title(); ?>&#8221;</h3>

<div class="navigation">
<div class="alignleft"></div>
<div class="alignright"></div>
</div>


  <div class="navigation">
    <div class="previous">
      <?php previous_comments_link() ?><?php echo $role; ?>
    </div>
    <div class="next">
      <?php next_comments_link() ?><?php echo $role; ?>
    </div>
  </div>
  <ol class="commentlist">
   <?php wp_list_comments('type=comment&callback=tie_custom_comments');?>

  </ol>
  <div class="navigation">
    <div class="previous">
      <?php previous_comments_link() ?><?php echo $role; ?>
    </div>
    <div class="previous">
      <?php next_comments_link() ?><?php echo $role; ?>
    </div>
  </div>


  <?php else : // this is displayed if there are no comments so far ?>
  <?php if ('open' == $post->comment_status) : ?>
  <!-- If comments are open, but there are no comments. -->
  <?php else : // comments are closed ?>
  <!-- If comments are closed. -->
  <p>comment closed</p>
  <?php endif; ?>
  <?php endif; ?>
  <?php if ('open' == $post->comment_status) : ?>

<div class="navigation">
<div class="alignleft"></div> <div class="alignright"></div>
</div>

  <div id="respond">
    <h3>Leave a Reply</h3>
    <div class="cancel-comment-reply"> <small>
      <?php cancel_comment_reply_link(); ?>
      </small> </div>
    <?php if ( get_option('comment_registration') && !$user_ID ) : ?>
    <p><?php print 'You must be'; ?> <a href="<?php echo get_option('siteurl'); ?>/wp-login.php?redirect_to=<?php echo urlencode(get_permalink()); ?>"><?php print 'Logged in'; ?></a> <?php print 'to post comment'; ?>.</p>
    <?php else : ?>
    <form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" id="commentform">
      <?php if ( $user_ID ) : ?>
      <p><?php print 'Logged as'; ?> <a href="<?php echo get_option('siteurl'); ?>/wp-admin/profile.php"><?php echo $user_identity; ?></a>. <a href="<?php echo wp_logout_url(get_permalink()); ?>" title="Log out of this account"><?php print 'Log out'; ?> &raquo;</a></p>


      <?php else : ?>


      
      <?php endif; ?>
      <!--<p><small><strong>XHTML:</strong> You can use these tags: <code><?php echo allowed_tags(); ?></code></small></p>-->
      <p>
        <textarea name="comment" id="comment" tabindex="4"></textarea>
      </p>
      <p>
        <input class="submit" name="submit" type="submit" id="submit" tabindex="5" value="Submit Comment" />
        <?php comment_id_fields(); ?>
      </p>
      <?php do_action('comment_form', $post->ID); ?>
    </form>


    <?php endif; // If registration required and not logged in ?>
  

  <?php endif; // if you delete this the sky will fall on your head ?>
 </div> </div>