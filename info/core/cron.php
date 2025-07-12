<?php

/**
 * Adds cron job to notify moderators of moderated messages
 * Cron interval: every 10 minutes
 * How it works: runs once every 10 minutes, if there are queued reported messages over the last 10 min, a notice will be sent to moderators via email.
*/
// create custom interval (10 min)
add_filter( 'cron_schedules', function( $schedules ) {
	$schedules['everyminute'] = array(
	    'interval' 	=> 600,
	    'display' 	=> __( 'Once Every 10 Minutes' )
    );
    return $schedules;
} );
// schedule crons upon plugin activation
 function setghghh() {
	if( !wp_next_scheduled( 'wpc_notify_mods' ) ) {  
		wp_schedule_event( time(), 'everyminute', 'wpc_notify_mods' );  
	}
	if( !wp_next_scheduled( 'wpc_notify_mods_summaries' ) ) {  
		wp_schedule_event( time(), 'daily', 'wpc_notify_mods_summaries' );  
	}
}

add_action('after_setup_theme','setghghh');

add_action('wpc_notify_mods', function() {
	$ins_op 	= esc_attr( get_option( 'wpc_cron_rep_ins' ) );
	$wpchats 	= new wpChats;
	$wpc 		= new wpc;
	$count 		= count(array_filter( explode(',', $ins_op) ));
	if( $count > 0 && strlen($ins_op) > 3 ) {
		$cnt = 0;
		foreach( $wpchats->get_users('mods', '') as $user ) {
			if( $wpchats->user_preferences( $user, 'mod_notif' ) == 'instantly' ) {
				$msg_dt	= '';
				$exp 	= '';
				$meta 	= '';
				foreach( array_filter( explode(',', $ins_op) ) as $op ) {
					$exp 	= explode('_', $op);
					$meta 	= get_user_meta( $exp[0], 'wpc_report_' . $exp[1], true);
					if( 
						   $wpchats->get_message_parts($exp[1], 'chat_id')
						&& $user == $wpchats->get_message_parts($exp[1], 'from')
						&& !in_array('administrator', get_userdata($user)->roles ) 
						|| get_userdata($wpchats->get_message_parts($exp[1], 'from')) 
						&& in_array('administrator', get_userdata($wpchats->get_message_parts($exp[1], 'from'))->roles )
						&& !in_array('administrator', get_userdata($user)->roles )
					)
					{
						$cnt += 0;
					}
					else 
					{
						$cnt += 1;
					}
					if(  $meta !== '' ) {
						$msg_dt .= "\nMessage: \"".$wpchats->get_message_parts( $exp[1], 'body' )."\"\nSent by ". get_userdata($wpchats->get_message_parts( $exp[1], 'from' ))->display_name ." at ". date('Y-m-d H:i:s', $wpchats->get_message_parts( $exp[1], 'time' )) ."\nReported few minutes ago by ".get_userdata($exp[0])->display_name."\nReason: \"$meta\"\n----";
					}
				}
				if( $cnt > 0 ) {
					add_filter('wp_mail_from_name', function() {$wpchats = new wpChats;return $wpchats->get_settings('mail_headers_from_name');});
					add_filter('wp_mail_from', function() {$wpchats = new wpChats;return $wpchats->get_settings('mail_headers_from');});
					wp_mail(
						$wpchats->user_preferences( $user, 'email' ),
						str_replace( 
							array( '[moderator]', '[reported-count]', '[site-name]', '[site-description]', '[reported-count]' ), 
							array( get_userdata($user)->user_nicename, $count, get_bloginfo('name'), get_bloginfo('description'), $count ),
							$wpchats->get_settings('mod_notif_ins_subject')
						),
						str_replace( 
							array( '[moderator]', '[moderator-link]', '[settings-link]', '[reported-count]', '[reported-message-details]', '[site-name]', '[site-description]', '[mod-panel]', '[mod-notification-setting]' ), 
							array( get_userdata($user)->user_nicename, $wpchats->user_links('link', $user, ''), $wpchats->get_settings('profile_page').'?edit=1', $count, $msg_dt, get_bloginfo('name'), get_bloginfo('description'), $wpchats->get_settings('profile_page').'?mod=1', $wpchats->user_preferences( $user, 'mod_notif' ) == 'instantly' ? 'instant' : 'daily' ),
							$wpchats->get_settings('mod_notif_ins_body')
						)
					);
					update_option( 'wpc_total_emails_sent', is_numeric( get_option('wpc_total_emails_sent') ) ? abs( get_option('wpc_total_emails_sent') + 1 ) : 1 );
					sleep(2);
				}
			}
		}
		delete_option('wpc_cron_rep_ins');
	}

	$nf_op = esc_attr( get_option( 'wpc_cron_notify' ) );
	$count = count(array_filter( explode(',', $nf_op) ));
	if( $count > 0 ) {
		//
	}
});

add_action('wpc_notify_mods_summaries', function() {
	
	$sum_op 	= esc_attr( get_option( 'wpc_cron_rep_sum' ) );
	$wpchats 	= new wpChats;
	$wpc 		= new wpc;
	$count 		= count(array_filter( explode(',', $sum_op) ));
	if( $count > 0 && strlen($sum_op) > 3 ) {
		$ar_max = 8;
		foreach( $wpchats->get_users('mods', '') as $user ) {
			if( $wpchats->user_preferences( $user, 'mod_notif' ) == 'daily' ) {
				$msg_dt	= '';
				$exp 	= '';
				$meta 	= '';
				foreach( array_slice( array_filter( explode(',', $sum_op) ), 0, $ar_max ) as $op ) {
					$exp 	= explode('_', $op);
					$meta 	= get_user_meta( $exp[0], 'wpc_report_' . $exp[1], true);
					if(  $meta !== '' ) {
						$msg_dt .= "\nMessage: \"".$wpchats->get_message_parts( $exp[1], 'body' )."\"\nSent by ". get_userdata($wpchats->get_message_parts( $exp[1], 'from' ))->display_name ." at ". date('Y-m-d H:i:s', $wpchats->get_message_parts( $exp[1], 'time' )) ."\nReported by ".get_userdata($exp[0])->display_name."\nReason: \"$meta\"\n----";
					}
				}
				$msg_dt .= $count > $ar_max ? "\nGo to your moderation panel to view ".abs($count - $ar_max)." more messages.\n" : '';
				add_filter('wp_mail_from_name', function() {$wpchats = new wpChats;return $wpchats->get_settings('mail_headers_from_name');});
				add_filter('wp_mail_from', function() {$wpchats = new wpChats;return $wpchats->get_settings('mail_headers_from');});
				wp_mail(
					$wpchats->user_preferences( $user, 'email' ),
					str_replace( 
						array( '[moderator]', '[reported-count]', '[site-name]', '[site-description]', '[reported-count]' ), 
						array( get_userdata($user)->user_nicename, $count, get_bloginfo('name'), get_bloginfo('description'), $count ),
						$wpchats->get_settings('mod_notif_ins_subject')
					),
					str_replace( 
						array( '[moderator]', '[moderator-link]', '[settings-link]', '[reported-count]', '[reported-message-details]', '[site-name]', '[site-description]', '[mod-panel]', '[mod-notification-setting]' ), 
						array( get_userdata($user)->user_nicename, $wpchats->user_links('link', $user, ''), $wpchats->get_settings('profile_page').'?edit=1', $count, $msg_dt, get_bloginfo('name'), get_bloginfo('description'), $wpchats->get_settings('profile_page').'?mod=1', $wpchats->user_preferences( $user, 'mod_notif' ) == 'instantly' ? 'instant' : 'daily' ),
						$wpchats->get_settings('mod_notif_ins_body')
					)
				);
				update_option( 'wpc_total_emails_sent', is_numeric( get_option('wpc_total_emails_sent') ) ? abs( get_option('wpc_total_emails_sent') + 1 ) : 1 );
				sleep(2);
			}
		}
		delete_option('wpc_cron_rep_sum');
	}



});