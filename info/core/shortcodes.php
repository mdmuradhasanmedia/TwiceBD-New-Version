<?php

add_shortcode('wpc', function( $atts ) {
	
	$wpchats = new wpchats;
	$wpc = new wpc;
	global $current_user;

	$a = shortcode_atts( array(
		'type' 		=> '',
		'part' 		=> '',
        'id' 		=> '',
    ), $atts );

	$type 	= esc_attr( "{$a['type']}" );
	$part 	= esc_attr( "{$a['part']}" );
	$id 	= esc_attr( "{$a['id']}" );

	if( $type == 'user' ) {

		if( is_numeric($id) && ! get_userdata( $id ) )	{
			return '<p>Error - user not found.</p>';
		} else {

			if( $part == 'online_status' )
				return get_userdata( $id ) ? $wpchats->online_status($id) : $wpchats->online_status( $current_user->ID );
			if( $part == 'unread_count' )
				return is_user_logged_in() ? $wpchats->get_counts('unread') : false;
			if( $part == 'online_count' )
				return $wpchats->get_counts('online');
			if( $part == 'blocked_count' )
				return is_user_logged_in() ? $wpchats->get_counts('blocked') : false;
			if( $part == 'reported_count' )
				return $wpc->is_user('mod', $current_user->ID ) ? $wpc->get_counts('reported') : false;
			if( $part == 'avatar_url' )
				return get_userdata( $id ) ? $wpchats->avatar_src( $id, '' ) : $wpchats->avatar_src( $current_user->ID, '' );
			if( is_numeric(strpos( $part, 'avatar' )) && !is_numeric( strpos( $part, 'avatar_url' ) ) ) {
				$e = explode('_', $part);
				$size = count( $e ) > 1 ? end($e) : '';
				return get_userdata( $id ) ? $wpchats->user_avatar( $id, $size ) : $wpchats->user_avatar( $current_user->ID, $size );
			}
			if( $part == 'profile_link_url' )
				return get_userdata( $id ) ? $wpchats->user_links( 'link', $id, false ) : $wpchats->user_links( 'link', $current_user->ID, false );
			if( $part == 'profile_link' )
				return get_userdata( $id ) ? '<a href="'.$wpchats->user_links( 'link', $id, false ).'" title="'.get_userdata($id)->user_nicename.'\'s profile">'.get_userdata($id)->user_nicename.'</a>' : '<a href="'.$wpchats->user_links( 'link', $current_user->ID, false ).'" title="'.$current_user->user_nicename.'\'s profile">'.$current_user->user_nicename.'</a>';
			if( $part == 'block_link' )
				return get_userdata( $id ) && $id != $current_user->ID ? $wpchats->user_links( 'block', $id, false ) : false;
			$user = get_userdata( $id ) ? $id : $current_user->ID;
			if( $part == 'user_bio') {
				$meta 	= get_user_meta($user, 'wpc_bio', true);
				$val 	= $wpc->is_user('mod', $user) ? html_entity_decode($meta) : esc_attr($meta);
				return $meta !== '' ? nl2br($val) : false;
			}
			if( $part == 'user_twitter') {
				$meta = get_user_meta($user, 'wpc_social_tw', true);
				return $meta !== '' ? '<a href="'.esc_attr($meta).'" title="Twitter" rel="nofollow" target="_blank"><i class="wpcico-twitter"></i>Twitter</a>' : false;
			}
			if( $part == 'user_facebook') {
				$meta = get_user_meta($user, 'wpc_social_fb', true);
				return $meta !== '' ? '<a href="'.esc_attr($meta).'" title="Facebook" rel="nofollow" target="_blank"><i class="wpcico-facebook-squared"></i>Facebook</a>' : false;
			}
			if( $part == 'user_youtube') {
				$meta = get_user_meta($user, 'wpc_social_yt', true);
				return $meta !== '' ? '<a href="'.esc_attr($meta).'" title="YouTube" rel="nofollow" target="_blank"><i class="wpcico-youtube-squared"></i>YouTube</a>' : false;
			}
			if( $part == 'user_google') {
				$meta = get_user_meta($user, 'wpc_social_gp', true);
				return $meta !== '' ? '<a href="'.esc_attr($meta).'" title="Google+" rel="nofollow" target="_blank"><i class="wpcico-gplus-squared"></i>Google+</a>' : false;
			}
			if( $part == 'user_linkedin') {
				$meta = get_user_meta($user, 'wpc_social_in', true);
				return $meta !== '' ? '<a href="'.esc_attr($meta).'" title="Linkedin" rel="nofollow" target="_blank"><i class="wpcico-linkedin-squared"></i>Linkedin</a>' : false;
			}
			if( $part == 'user_website') {
				$meta = get_user_meta($user, 'wpc_social_st', true);
				return $meta !== '' ? '<a href="'.esc_attr($meta).'" title="Website" rel="nofollow" target="_blank"><i class="wpcico-link-ext-alt"></i>Website</a>' : false;
			}

		}

	}

});

add_shortcode('wpchats-author-card', function($atts) {
	$wpchats = new wpchats;
	$wpc = new wpc;
	$user_id = get_the_author_meta( 'ID' );
	global $current_user;

	$a = shortcode_atts( array(
		'full' 		=> ''
    ), $atts );

    $full = esc_attr( "{$a['full']}" ) !== '' ? true : false;

	ob_start();
	echo '<div class="wpchats-auth full';
	echo $wpchats->get_settings('rtl') ? ' rtl">' : '">';
	echo '<div style="display:inline-block;padding-right: 6px;"><a href="' . $wpchats->user_links('link', $user_id, '') . '" class="wpc_user_ajax" data-user="' . get_userdata($user_id)->user_login . '">';
	echo $wpchats->user_avatar( $user_id, 100 );
	echo '</div></a>';
	echo '<div style="display:inline-block;vertical-align:top;">';
	echo '<div><a href="' . $wpchats->user_links('link', $user_id, '') . '" class="wpc_user_ajax" data-user="' . get_userdata($user_id)->user_login . '"><i class="wpcico-user-1"></i>'.get_userdata( $user_id )->display_name.'</a></div>';
	echo $wpc->is_user('mod', $user_id) ? '<div><i class="wpcico-eye"></i>'.$wpchats->translate(78).'</div>' : '';
	echo '<div>'.$wpchats->online_status( $user_id ).'</div>';
	if( $current_user->ID !== $user_id ) {
		echo '<div>'.$wpchats->user_links( 'message', $user_id, '').'</div>';
		echo '<div>'.$wpchats->user_links( 'block', $user_id, '' ).'</div>';
	} else {
		echo '<div><a href="' . $wpchats->get_settings('profile_page') . '?edit=1"><i class="wpcico-wrench"></i>'.$wpchats->translate(142).'</a></div>';
	}
	echo '</div><p></p>';
	if($wpchats->user_info( $user_id, 'bio' )) {
		echo '<p class="wpc-user-bio">';
		echo '<strong>'.$wpchats->translate(143).'</strong><br>';
		echo $wpchats->output_message( html_entity_decode( stripslashes( $wpchats->user_info( $user_id, 'bio' ) ) ) );
		echo '</p>';
	}
	if(
		   $wpchats->user_info( $user_id, 'social_tw' )
		|| $wpchats->user_info( $user_id, 'social_fb' )
		|| $wpchats->user_info( $user_id, 'social_yt' )
		|| $wpchats->user_info( $user_id, 'social_gp' )
		|| $wpchats->user_info( $user_id, 'social_in' )
		|| $wpchats->user_info( $user_id, 'social_st' )
	)
	{
		echo '<p class="wpc-user-social">';
		echo '<strong>'.$wpchats->translate(144).'</strong><br>';
		echo $wpchats->user_info($user_id, 'social_tw') ? '<a href="'.$wpchats->user_info($user_id, 'social_tw').'" rel="nofollow" target="_blank" title="' . $wpchats->translate(145) . '"><i class="wpcico-twitter"></i>' . $wpchats->translate(145) . '</a><br>' : '';
		echo $wpchats->user_info($user_id, 'social_fb') ? '<a href="'.$wpchats->user_info($user_id, 'social_fb').'" rel="nofollow" target="_blank" title="' . $wpchats->translate(146) . '"><i class="wpcico-facebook-squared"></i>' . $wpchats->translate(146) . '</a><br>' : '';
		echo $wpchats->user_info($user_id, 'social_yt') ? '<a href="'.$wpchats->user_info($user_id, 'social_yt').'" rel="nofollow" target="_blank" title="' . $wpchats->translate(107) . '"><i class="wpcico-youtube-squared"></i>' . $wpchats->translate(107) . '</a><br>' : '';
		echo $wpchats->user_info($user_id, 'social_gp') ? '<a href="'.$wpchats->user_info($user_id, 'social_gp').'" rel="nofollow" target="_blank" title="' . $wpchats->translate(147) . '"><i class="wpcico-gplus-squared"></i>' . $wpchats->translate(147) . '</a><br>' : '';
		echo $wpchats->user_info($user_id, 'social_in') ? '<a href="'.$wpchats->user_info($user_id, 'social_in').'" rel="nofollow" target="_blank" title="' . $wpchats->translate(148) . '"><i class="wpcico-linkedin-squared"></i>' . $wpchats->translate(148) . '</a><br>' : '';
		echo $wpchats->user_info($user_id, 'social_st') ? '<a href="'.$wpchats->user_info($user_id, 'social_st').'" rel="nofollow" target="_blank" title="' . $wpchats->translate(149) . '"><i class="wpcico-link-ext-alt"></i>' . $wpchats->translate(149) . '</a><br>' : '';
		echo '</p>';
	}
	echo '</div>';
	$fullCard = ob_get_clean();
	ob_start();
	$redirect = false;
	?>
		<div class="wpchats-auth">
			<?php require_once( get_template_directory_uri() . '/info/users/card.php' ); ?>
		</div>
	<?php
	$card = ob_get_clean();

	return $full ? $fullCard : $card;
});