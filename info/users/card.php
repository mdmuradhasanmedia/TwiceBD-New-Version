<?php
$classes = $wpc->is_user('mod', $user_id) ? ' moderator': '';
$classes .= $wpchats->is_blocked( $user_id, '' ) ? ' blocked': '';
$classes .= $wpchats->is_online( $user_id ) ? ' online': ' offline';
$classes .= $wpchats->get_settings('rtl') ? ' rtl' : '';
$wpc_user_ajax = is_numeric( strpos( $wpchats->user_links('link', $user_id, ''), $wpchats->get_settings('profile_page') ) ) ? 'wpc_user_ajax' : '';
global $wpdb; $options1 = get_option('wpc_pages');  $url = $options1["users"]; $url2 = $options1["messaging"]; 
ob_start();
?>
<div class="wpc-user-card<?php echo $classes; ?>">
	<table width="100%" class="user-avatar-cont"><tr>
	    <td valign="top" width="55px"><a href="<?php echo $wpchats->user_links('link', $user_id, ''); ?>" class="<?php echo $wpc_user_ajax; ?>" data-user="<?php echo get_userdata($user_id)->user_login; ?>"><?php echo get_avatar( $user_id, 50 ); ?></a></td>
		<td valign="top" width="auto">
		   	<div class="usr_name"><a href="<?php echo $wpchats->user_links('link', $user_id, ''); ?>" class="<?php echo $wpc_user_ajax; ?>" data-user="<?php echo get_userdata($user_id)->user_login; ?>"><span><?php echo get_userdata( $user_id )->display_name; ?></span></a><?php if( intval($current_user->ID) !== intval($user_id) ){ }else{ ?> | <a href="<?php echo admin_url();?>/profile.php">Edit Profile</a><?php } ?></div>
			<div class="usr_list"><?php if($wpc->is_user('mod', $user_id)):; ?><?php echo $wpchats->translate(78); ?> | <?php endif; ?> <?php echo $wpchats->online_status_rec( $user_id ); ?></div>
			<div class="usr_list"><?php if( intval($current_user->ID) !== intval($user_id) ):; ?><a href="<?php echo $url2; ?>?recipient=<?php echo $user_id; ?>"><?php echo $wpchats->translate(159); ?></a><?php endif; ?>	
			<?php if($wpc->is_user('mod', $user_id)){ }else{ if( intval($current_user->ID) !== intval($user_id) ){ ?> | <a href="<?php echo $url2; ?>?todo=block_user&user=<?php echo $user_id; ?>&rdr=users">Block User</a><?php }} ?></div>
		</td>
	</tr></table>
	<?php do_action('_wpc_add_user_card_element', $user_id); ?>
</div>
<?php

echo apply_filters('_wpc_user_card_content', ob_get_clean(), $user_id);