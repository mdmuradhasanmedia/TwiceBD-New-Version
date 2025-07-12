<?php
if( !is_user_logged_in() ) {
  wp_redirect( $wpchats->get_settings( "profile_page" ).'?scs=19' );
  exit;
}

// Use this action hook to manipulate this page (eg. redirect or return nothing, or even printing other stuff)
do_action('_wpc_before_profile_edit_page');

if( isset($_POST["wpc_submit"]) ) {
	if ( isset( $_POST["wpc_not_avail"] ) && $_POST["wpc_not_avail"] !== "" )
		update_user_meta( $current_user->ID, 'wpc_not_avail', '1');
	else
		delete_user_meta( $current_user->ID, 'wpc_not_avail' );
	if ( isset( $_POST["wpc_go_offline"] ) && $_POST["wpc_go_offline"] !== "" )
		update_user_meta( $current_user->ID, 'wpc_go_offline', '1');
	else
		delete_user_meta( $current_user->ID, 'wpc_go_offline' );
	if ( isset( $_POST["wpc_notify_me"] ) && $_POST["wpc_notify_me"] !== "" )
		update_user_meta( $current_user->ID, 'wpc_notify_me', '1');
	else
		update_user_meta( $current_user->ID, 'wpc_notify_me', '0');

	if ( isset( $_POST["wpc_chat_sound"] ) && $_POST["wpc_chat_sound"] !== "" )
		delete_user_meta( $current_user->ID, 'wpc_chat_sound');
	else
		update_user_meta( $current_user->ID, 'wpc_chat_sound', '0');

	if ( isset( $_POST["wpc_user_email"] ) && $_POST["wpc_user_email"] !== "" )
		update_user_meta( $current_user->ID, 'wpc_user_email', sanitize_text_field($_POST["wpc_user_email"]));
	else
		delete_user_meta( $current_user->ID, 'wpc_user_email' );

	if ( isset( $_POST["wpc_mod_notif"] ) && $_POST["wpc_mod_notif"] !== "" )
		update_user_meta( $current_user->ID, 'wpc_mod_notif', sanitize_text_field($_POST["wpc_mod_notif"]));

	if ( isset( $_POST["wpc_user_avatar"] ) && $_POST["wpc_user_avatar"] !== "" )
		update_user_meta( $current_user->ID, 'wpc_avatar', sanitize_text_field($_POST["wpc_user_avatar"]));
	else
		delete_user_meta( $current_user->ID, 'wpc_avatar' );

	if ( isset( $_POST["wpc_bio"] ) && $_POST["wpc_bio"] !== "" )
		update_user_meta( $current_user->ID, 'wpc_bio', esc_attr($_POST["wpc_bio"]) );
	else
		delete_user_meta( $current_user->ID, 'wpc_bio' );

	if ( isset( $_POST["wpc_social_tw"] ) && $_POST["wpc_social_tw"] !== "" )
		update_user_meta( $current_user->ID, 'wpc_social_tw', sanitize_text_field($_POST["wpc_social_tw"]));
	else
		delete_user_meta( $current_user->ID, 'wpc_social_tw' );

	if ( isset( $_POST["wpc_social_fb"] ) && $_POST["wpc_social_fb"] !== "" )
		update_user_meta( $current_user->ID, 'wpc_social_fb', sanitize_text_field($_POST["wpc_social_fb"]));
	else
		delete_user_meta( $current_user->ID, 'wpc_social_fb' );

	if ( isset( $_POST["wpc_social_yt"] ) && $_POST["wpc_social_yt"] !== "" )
		update_user_meta( $current_user->ID, 'wpc_social_yt', sanitize_text_field($_POST["wpc_social_yt"]));
	else
		delete_user_meta( $current_user->ID, 'wpc_social_yt' );

	if ( isset( $_POST["wpc_social_gp"] ) && $_POST["wpc_social_gp"] !== "" )
		update_user_meta( $current_user->ID, 'wpc_social_gp', sanitize_text_field($_POST["wpc_social_gp"]));
	else
		delete_user_meta( $current_user->ID, 'wpc_social_gp' );

	if ( isset( $_POST["wpc_social_in"] ) && $_POST["wpc_social_in"] !== "" )
		update_user_meta( $current_user->ID, 'wpc_social_in', sanitize_text_field($_POST["wpc_social_in"]));
	else
		delete_user_meta( $current_user->ID, 'wpc_social_in' );

	if ( isset( $_POST["wpc_social_st"] ) && $_POST["wpc_social_st"] !== "" )
		update_user_meta( $current_user->ID, 'wpc_social_st', sanitize_text_field($_POST["wpc_social_st"]));
	else
		delete_user_meta( $current_user->ID, 'wpc_social_st' );

	do_action('_wpc_save_custom_field');

	wp_redirect( $wpchats->get_settings( "profile_page" ) . '?edit=1&scs=14' );
	exit;
}
$meta_1 	= get_user_meta($current_user->ID, 'wpc_not_avail', true);
$meta_2 	= get_user_meta($current_user->ID, 'wpc_user_email', true);
$meta_3 	= get_user_meta($current_user->ID, 'wpc_notify_me', true);
$meta_4 	= get_user_meta($current_user->ID, 'wpc_chat_sound', true);
$meta_5 	= get_user_meta($current_user->ID, 'wpc_mod_notif', true);
$meta_6 	= get_user_meta($current_user->ID, 'wpc_avatar', true);
$meta_7 	= get_user_meta($current_user->ID, 'wpc_bio', true);
$meta_8 	= get_user_meta($current_user->ID, 'wpc_social_tw', true);
$meta_9	 	= get_user_meta($current_user->ID, 'wpc_social_fb', true);
$meta_10 	= get_user_meta($current_user->ID, 'wpc_social_yt', true);
$meta_11 	= get_user_meta($current_user->ID, 'wpc_social_gp', true);
$meta_12 	= get_user_meta($current_user->ID, 'wpc_social_in', true);
$meta_13 	= get_user_meta($current_user->ID, 'wpc_social_st', true);
$meta_14 	= get_user_meta($current_user->ID, 'wpc_go_offline', true);
?>
<h2><?php echo $wpchats->translate(142); ?></h2>
<form action="#" method="post" id="settings">
	<p>
		<label for="wpc_user_avatar" style="display: block;"><strong><?php echo $wpchats->translate(161); ?>:</strong></label>
		<input type="url" name="wpc_user_avatar" id="wpc_user_avatar" value="<?php echo ( $meta_6 !== '' ) ? esc_attr($meta_6) : ''; ?>" size="80"/>
		<sub><?php echo str_replace('[email]', $wpchats->user_preferences( $current_user->ID, 'email'), $wpchats->translate(162)); ?></sub>
	</p>
	<p>
		<label for="wpc_user_email" style="display:block"><strong><?php echo $wpchats->translate(163); ?>:</strong></label>
		<input type="email" name="wpc_user_email" id="wpc_user_email" value="<?php echo $meta_2 == '' ? $current_user->user_email : $meta_2; ?>" size="80"/>
		<sub><?php echo $wpchats->translate(164); ?></sub>
	</p>
	<p>
		<input type="checkbox" name="wpc_notify_me" id="wpc_notify_me" <?php echo $meta_3 == '' || $meta_3 == '1' ? 'checked="checked"' : ''; ?> />
		<label for="wpc_notify_me" style="display: inline-block;"><?php echo $wpchats->translate(165); ?></label>
		<br>
		<input type="checkbox" name="wpc_chat_sound" id="wpc_chat_sound" <?php echo $meta_4 !== '0' ? 'checked="checked"' : ''; ?> />
		<label for="wpc_chat_sound" style="display: inline-block;"><?php echo $wpchats->translate(166); ?></label>
	</p>
	<?php 
	$array_blocked = $wpchats->get_users('blocked', '');
	if(count($array_blocked) > 0 ) :; ?>
	<p>
		<strong style="display:block"><?php echo $wpchats->translate(167); ?> (<?php echo count($array_blocked); ?>)</strong>
		<?php
			foreach ( $array_blocked as $id ) {
				echo get_userdata($id)->user_nicename;
				echo '<a href="'. $wpchats->get_settings( 'messages_page' ) . '?todo=unblock_user&user='.$id.'&rdr=edit" title="'. $wpchats->translate(82) .' '.get_userdata($id)->display_name.'"><sub style="position: static;">[x]</sub></a>';
				echo $id !== end( $array_blocked ) ? ', ' : '';
			}
		?>
	</p>
	<?php endif; ?>
	<?php if( $wpc->is_user('mod', $current_user->ID) && ! $wpc->is_user('banned', $current_user->ID) ) :;?>
	<h3><?php echo $wpchats->translate(168); ?></h3>
	<p>
		<label for="wpc_mod_notif" style="display: inline-block;"><?php echo $wpchats->translate(169); ?>:</label><br>
		<input type="radio" name="wpc_mod_notif" id="wpc_mod_notif_1" value="1" <?php echo $meta_5 == '' || $meta_5 == '1' ? 'checked="checked"' : ''; ?> />
		<label for="wpc_mod_notif_1" style="display: inline-block;"><?php echo $wpchats->translate(170); ?></label><br>
		<input type="radio" name="wpc_mod_notif" id="wpc_mod_notif_2" value="2" <?php echo $meta_5 == '2' ? 'checked="checked"' : ''; ?> />
		<label for="wpc_mod_notif_2" style="display: inline-block;"><?php echo $wpchats->translate(171); ?></label><br>
		<input type="radio" name="wpc_mod_notif" id="wpc_mod_notif_0" value="0" <?php echo $meta_5 == '0' ? 'checked="checked"' : ''; ?> />
		<label for="wpc_mod_notif_0" style="display: inline-block;"><?php echo $wpchats->translate(172); ?></label><br>
	</p>
	<?php endif; ?>
	<h3><?php echo $wpchats->translate(143); ?></h3>
	<p>
		<label for="wpc_bio" style="display: block;"><strong><?php echo $wpchats->translate(173); ?></strong></label>
		<textarea name="wpc_bio" id="wpc_bio" rows="6" cols="80" placeholder="<?php echo $wpchats->translate(174); ?>"><?php echo ( $meta_7 !== '' ) ? esc_attr($meta_7) : ''; ?></textarea>
		<sub><strong><?php echo $wpchats->translate(175); ?></strong>: [link]http://link.to(title)title_here[/link] [img]http://path.to/img[/img] [youtube]video_id[/youtube] [vimeo]video_id[/vimeo] [dailymotion]video_id[/dailymotion] [video]video_source_URI[/video].<br><?php echo $wpchats->translate(176); ?></sub>
	</p>
	<p>
		<strong><?php echo $wpchats->translate(177); ?></strong>
		<br>
		<label for="wpc_social_tw" style="display: inline-block;"><?php echo $wpchats->translate(145); ?>:</label><br>
		<input type="url" name="wpc_social_tw" id="wpc_social_tw" value="<?php echo $meta_8 !== '' ? esc_attr($meta_8) : ''; ?>" size="80" />
		<br>
		<label for="wpc_social_fb" style="display: inline-block;"><?php echo $wpchats->translate(146); ?>:</label><br>
		<input type="url" name="wpc_social_fb" id="wpc_social_fb" value="<?php echo $meta_9 !== '' ? esc_attr($meta_9) : ''; ?>" size="80" />
		<br>
		<label for="wpc_social_yt" style="display: inline-block;"><?php echo $wpchats->translate(107); ?>:</label><br>
		<input type="url" name="wpc_social_yt" id="wpc_social_yt" value="<?php echo $meta_10 !== '' ? esc_attr($meta_10) : ''; ?>" size="80" />
		<br>
		<label for="wpc_social_gp" style="display: inline-block;"><?php echo $wpchats->translate(147); ?>:</label><br>
		<input type="url" name="wpc_social_gp" id="wpc_social_gp" value="<?php echo $meta_11 !== '' ? esc_attr($meta_11) : ''; ?>" size="80" />
		<br>
		<label for="wpc_social_in" style="display: inline-block;"><?php echo $wpchats->translate(148); ?>:</label><br>
		<input type="url" name="wpc_social_in" id="wpc_social_in" value="<?php echo $meta_12 !== '' ? esc_attr($meta_12) : ''; ?>" size="80" />
		<br>
		<label for="wpc_social_st" style="display: inline-block;"><?php echo $wpchats->translate(149); ?>:</label><br>
		<input type="url" name="wpc_social_st" id="wpc_social_st" value="<?php echo $meta_13 !== '' ? esc_attr($meta_13) : ''; ?>" size="80" />
		<br>
		<?php do_action('_wpc_add_social_profile_field_input'); ?>
	</p>
	<p>
		<input type="checkbox" name="wpc_not_avail" id="wpc_not_avail" <?php echo $meta_1 !== '' ? 'checked="checked"' : ''; ?> />
		<label for="wpc_not_avail" style="display: inline-block;"><?php echo $wpchats->translate(178); ?></label>
	</p>
	<?php if( $wpchats->get_settings('can_go_offline') || current_user_can('manage_options') ) :;?>
	<p>
		<input type="checkbox" name="wpc_go_offline" id="wpc_go_offline" <?php echo $meta_14 !== '' ? 'checked="checked"' : ''; ?> />
		<label for="wpc_go_offline" style="display: inline-block;"><?php echo $wpchats->translate(179); ?><?php echo $wpchats->get_settings('can_go_offline') ? '' : ' <i>(for admins only)</i>'; ?></label>
	</p>
	<?php endif; ?>
	<?php do_action('_wpc_after_profile_edit_page'); ?>
	<p>
		<input type="submit" value="<?php echo $wpchats->translate(180); ?>" name="wpc_submit" />
	</p>
</form>
<?php
