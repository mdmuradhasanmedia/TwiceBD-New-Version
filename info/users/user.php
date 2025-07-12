<?php
$user_id = get_user_by( 'login', esc_attr( $_GET["user"] ) )->ID;
if( ! $user_id ) {
	wp_redirect( $wpchats->get_settings( "profile_page" ) );
	exit;
}
if( $wpchats->get_settings('redirect_profile_to') && !is_numeric( strpos( $wpchats->user_links('link', $user_id, ''), $wpchats->get_settings('profile_page') ) )  ) {
	wp_redirect( $wpchats->user_links('link', $user_id, false) );
	exit;
}
do_action('_wpc_before_user_profile', $user_id);
$html = '<div style="display:inline-block;padding-right: 6px;"><a href="' . $wpchats->user_links('link', $user_id, '') . '" class="wpc_user_ajax" data-user="' . get_userdata($user_id)->user_login . '">';
$html .= $wpchats->user_avatar( $user_id, apply_filters('_wpc_user_profile_avatar_size', $size = 100 ) );
$html .= '</div></a>';
$html .= '<div style="display:inline-block;vertical-align:top;">';
$html .= '<div><a href="' . $wpchats->user_links('link', $user_id, '') . '" class="wpc_user_ajax" data-user="' . get_userdata($user_id)->user_login . '"><i class="wpcico-user-1"></i>'.get_userdata( $user_id )->display_name.'</a></div>';
$html .= $wpc->is_user('mod', $user_id) ? '<div><i class="wpcico-eye"></i>'.$wpchats->translate(78).'</div>' : '';
ob_start();
?>
  <div>
    <?php echo $wpchats->online_status( $user_id ); ?>
  </div>
<?php
$html .= ob_get_clean();
if( $current_user->ID !== $user_id ) {
	$html .= '<div>'.$wpchats->user_links( 'message', $user_id, '').'</div>';
	$html .= '<div>'.$wpchats->user_links( 'block', $user_id, '' ).'</div>';
} else {
	$html .= '<div><a href="' . $wpchats->get_settings('profile_page') . '?edit=1"><i class="wpcico-wrench"></i>'.$wpchats->translate(142).'</a></div>';
}
ob_start();
?>
  <?php do_action('_wpc_add_user_profile_element', $user_id ); ?>
<?php
$html .= ob_get_clean(); 
$html .= '</div><p></p>';
if($wpchats->user_info( $user_id, 'bio' )) {
	$html .= '<p class="wpc-user-bio">';
	$html .= '<strong>'.$wpchats->translate(143).'</strong><br>';
	$html .= $wpchats->output_message( html_entity_decode( stripslashes( $wpchats->user_info( $user_id, 'bio' ) ) ) );
	$html .= '</p>';
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
	$html .= '<p class="wpc-user-social">';
	$html .= '<strong>'.$wpchats->translate(144).'</strong><br>';
	$html .= $wpchats->user_info($user_id, 'social_tw') ? '<a href="'.$wpchats->user_info($user_id, 'social_tw').'" rel="nofollow" target="_blank" title="' . $wpchats->translate(145) . '"><i class="wpcico-twitter"></i>' . $wpchats->translate(145) . '</a><br>' : '';
	$html .= $wpchats->user_info($user_id, 'social_fb') ? '<a href="'.$wpchats->user_info($user_id, 'social_fb').'" rel="nofollow" target="_blank" title="' . $wpchats->translate(146) . '"><i class="wpcico-facebook-squared"></i>' . $wpchats->translate(146) . '</a><br>' : '';
	$html .= $wpchats->user_info($user_id, 'social_yt') ? '<a href="'.$wpchats->user_info($user_id, 'social_yt').'" rel="nofollow" target="_blank" title="' . $wpchats->translate(107) . '"><i class="wpcico-youtube-squared"></i>' . $wpchats->translate(107) . '</a><br>' : '';
	$html .= $wpchats->user_info($user_id, 'social_gp') ? '<a href="'.$wpchats->user_info($user_id, 'social_gp').'" rel="nofollow" target="_blank" title="' . $wpchats->translate(147) . '"><i class="wpcico-gplus-squared"></i>' . $wpchats->translate(147) . '</a><br>' : '';
	$html .= $wpchats->user_info($user_id, 'social_in') ? '<a href="'.$wpchats->user_info($user_id, 'social_in').'" rel="nofollow" target="_blank" title="' . $wpchats->translate(148) . '"><i class="wpcico-linkedin-squared"></i>' . $wpchats->translate(148) . '</a><br>' : '';
	$html .= $wpchats->user_info($user_id, 'social_st') ? '<a href="'.$wpchats->user_info($user_id, 'social_st').'" rel="nofollow" target="_blank" title="' . $wpchats->translate(149) . '"><i class="wpcico-link-ext-alt"></i>' . $wpchats->translate(149) . '</a><br>' : '';
	ob_start();
	?><?php do_action('_wpc_output_social_profile', $user_id ); ?><?php
	$html .= ob_get_clean(); 
	$html .= '</p>';
}
echo apply_filters( '_wpc_user_profile_content', $html, $user_id );
?>