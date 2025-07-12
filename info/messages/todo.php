<?php
$todo 	= isset( $_GET["todo"] ) ? esc_attr( $_GET["todo"] ) : '';
$pm 	= isset( $_GET["pm"] ) ? esc_attr( $_GET["pm"] ) : '';
if ( $todo == "mark_unread" && ! isset( $_GET["rdr"] ) ) {
	if ( $wpchats->get_conversation( $pm, 'from' ) == strval($current_user->ID) || $wpchats->get_conversation( $pm, 'to' ) == strval($current_user->ID) ) {
		echo $wpchats->translate(111)." <a href=\"" . $wpchats->get_settings( "messages_page" ) . "?todo=mark_unread&pm=$pm&rdr=1\">".$wpchats->translate(112)."</a>.";
		echo '<script type="text/javascript">window.location.href= "' . $wpchats->get_settings( "messages_page" ) . "?todo=mark_unread&pm=$pm&rdr=1".'";</script>';
	} else {
		wp_redirect( $wpchats->get_settings( "messages_page" ). '?scs=4' );
		exit;
	}
}
if ( $todo == "mark_unread" && isset( $_GET["rdr"] ) ) {
	if ( $wpchats->get_conversation( $pm, 'from' ) == strval($current_user->ID) || $wpchats->get_conversation( $pm, 'to' ) == strval($current_user->ID) ) {
		$wpchats->single_actions( "mark_unread", $pm );
	} else {
		wp_redirect( $wpchats->get_settings( "messages_page" ). '?scs=4' );
		exit;
	}
}
if ( $todo == "delete_conversation" ) {
	if( ! isset( $pm ) || $pm == '' ) {
		wp_redirect( $wpchats->get_settings( "messages_page" ) );
		exit;
	}
	if( ! $wpchats->get_conversation( $pm, 'last_from') ) {
		wp_redirect( $wpchats->get_settings( "messages_page" ) . '?scs=7' );
		exit;	
	}
	if( $wpchats->get_conversation( $pm, 'from' ) == strval($current_user->ID) || $wpchats->get_conversation( $pm, 'to' ) == strval($current_user->ID) ) {				
		?>
			<blockquote>
				<strong><?php echo $wpchats->translate(117); ?></strong>: <?php echo $pm; ?><br>
				<strong><?php echo $wpchats->translate(118); ?></strong>: <?php echo $wpchats->translate(119); ?> <a href="<?php echo $wpchats->user_links('link', $wpchats->get_conversation( $pm, 'contact' ), '' ); ?>"><?php echo get_userdata($wpchats->get_conversation( $pm, 'contact' ))->display_name; ?></a><br>
			</blockquote>
			<p><?php echo str_replace('[user]', get_userdata($wpchats->get_conversation( $pm, 'contact' ))->display_name, $wpchats->translate(120)); ?></p>
			<p><?php echo $wpchats->translate(121); ?></p>
			<form action="#" method="post">
				<input type="submit" value="<?php echo $wpchats->translate(122); ?>" name="conf_delete_conversation" />
				<input type="reset" class="wpc-load-pm" onclick="if(wpcJSLoaded){return false;}else window.location.href='?conversation=<?php echo $pm; ?>'" data-pm="<?php echo $pm; ?>" value="<?php echo $wpchats->translate(16); ?>" onclick="window.location.href= '<?php echo $wpchats->get_settings( "messages_page" ) . '?conversation='.$pm; ?>';" />
			</form>
		<?php
		if ( ! isset( $_POST["conf_delete_conversation"] ) )
			return;
		else {
			$wpchats->single_actions( "delete_conversation", $pm );
			return;
		}
	} else {
		wp_redirect( $wpchats->get_settings( "messages_page" ). '?scs=4' );
		exit;
	}
}
if ( $todo == "pm_delete" ) {
	if( ! isset( $_GET["id"] ) )
		return;
	$id = esc_attr( $_GET["id"] );
	if( in_array( $current_user->ID, explode(',', $wpchats->get_message_parts( $id, 'deleted' ))) ) {
		wp_redirect( $wpchats->get_settings( "messages_page" ) . '?scs=5' );
		exit;
	}
	if( $wpchats->get_message_parts( $id, 'from' ) == $current_user->ID || $wpchats->get_message_parts( $id, 'to' ) == $current_user->ID ) {
		$pm_id = $wpchats->get_message_parts( $id, 'chat_id' );
		$uid = $current_user->ID;
		ob_start();?>
		<blockquote>
			<strong><?php echo $wpchats->translate(113); ?></strong>: <?php echo get_userdata( $wpchats->get_message_parts( $id, 'from' ) )->display_name; ?><br>
			<strong><?php echo $wpchats->translate(114); ?></strong>: <?php echo get_userdata( $wpchats->get_message_parts( $id, 'to' ) )->display_name; ?><br>
			<strong><?php echo $wpchats->translate(115); ?></strong>: <?php echo strip_tags( $wpchats->get_message_parts( $id, 'body' ), ''); ?><br>
			<strong><?php echo $wpchats->translate(116); ?></strong>: <?php echo date( 'Y-m-d H:i:s', $wpchats->get_message_parts( $id, 'time' ) ); ?>
		</blockquote>
		<p><?php echo $wpchats->translate(88); ?></p>
		<form action="#" method="post">
			<input type="submit" name="conf_delete" value="<?php echo $wpchats->translate(10); ?>" />
			<input type="reset" class="wpc-load-pm" data-pm="<?php echo $pm_id; ?>" value="<?php echo $wpchats->translate(16); ?>" onclick="if(wpcJSLoaded){return false;}else window.location.href= '<?php echo $wpchats->get_settings( "messages_page" ) . '?conversation=' . $wpchats->get_message_parts( $id, 'chat_id' ); ?>';" />
		</form>
		<?php
		$html = ob_get_clean();
		echo $html;
		if ( isset( $_POST["conf_delete"] ) || isset( $_GET["conf"] ) ) {
			if ( $wpchats->get_conversation( $pm_id, 'from' ) == strval($current_user->ID) || $wpchats->get_conversation( $pm_id, 'to' ) == strval($current_user->ID) )
				$wpchats->single_actions( "pm_delete", $id );
		}
	} else {
		wp_redirect( $wpchats->get_settings( "messages_page" ) . '?scs=6' );
		exit;
	}
	return;			
}
if ( $todo == "pm_report" ) {
	if( ! isset( $_GET["id"] ) )
		return;
	$id = esc_attr( $_GET["id"] );
	if( in_array( $current_user->ID, explode(',', $wpchats->get_message_parts( $id, 'deleted' ))) ) {
		wp_redirect( $wpchats->get_settings( "messages_page" ) . '?scs=5' );
		exit;
	}
	if( $wpchats->get_message_parts( $id, 'from' ) == $current_user->ID || $wpchats->get_message_parts( $id, 'to' ) == $current_user->ID ) {
		$meta = get_user_meta( $current_user->ID, "wpc_report_$id", TRUE );
		if( $wpchats->get_settings('user_can_update_reports') && $meta !== '' || $meta == '' ) {
			ob_start();
			?>
				<blockquote>
					<strong><?php echo $wpchats->translate(113); ?></strong>: <?php echo get_userdata( $wpchats->get_message_parts( $id, 'from' ) )->display_name; ?><br>
					<strong><?php echo $wpchats->translate(114); ?></strong>: <?php echo get_userdata( $wpchats->get_message_parts( $id, 'to' ) )->display_name; ?><br>
					<strong><?php echo $wpchats->translate(115); ?></strong>: <?php echo strip_tags( $wpchats->get_message_parts( $id, 'body' ), ''); ?><br>
					<strong><?php echo $wpchats->translate(116); ?></strong>: <?php echo date( 'Y-m-d H:i:s', $wpchats->get_message_parts( $id, 'time' ) ); ?>
				</blockquote>
				<p><label for="rep_body"><strong><?php echo $wpchats->translate(123); ?></strong></label>
				<?php if( $meta !== '' ) :;?>
				<br><?php echo $wpchats->translate(124); ?>
				<?php echo $wpchats->get_settings('user_can_delete_reports') ? ' '. $wpchats->translate(125) : ''; ?>:
				<?php endif; ?>
				</p>
				<form action="#" method="post">
					<textarea name="rep_reason" required="required" id="rep_body" rows="5" cols="60" style="display:block"><?php echo $meta !== "" ? $meta : ''; ?></textarea>
					<input type="submit" value="<?php echo $meta !== "" ? $wpchats->translate(126) : $wpchats->translate(69); ?>" name="conf_report" />
					<?php echo $meta !== "" && $wpchats->get_settings('user_can_delete_reports') ? '<input type="submit" value="'.$wpchats->translate(127).'" onclick="return confirm(\''.$wpchats->translate(128).'\');" name="del_report" />&nbsp;' : ''; ?>
					<input type="reset" class="wpc-load-pm" value="<?php echo $wpchats->translate(16); ?>" onclick="if(wpcJSLoaded){return false;}else window.location.href= '<?php echo $wpchats->get_settings( "messages_page" ) . '?conversation=' . $wpchats->get_message_parts( $id, 'chat_id' ); ?>';" data-pm="<?php echo $wpchats->get_message_parts( $id, 'chat_id' ); ?>" />
				</form>
			<?php
			$html = ob_get_clean();
			if ( isset( $_POST["conf_report"] ) || isset( $_POST["del_report"] ) ) {
				$reason = ( isset( $_POST["del_report"] ) ) ? '' : $_POST["rep_reason"];
				if ( $reason !== '' ) {
					update_user_meta( $current_user->ID, "wpc_report_$id", esc_attr( $reason ) );

					update_option('wpc_cron_rep_ins',  ! in_array( $current_user->ID . '_' . $id, array_filter(explode(',', get_option('wpc_cron_rep_ins'))) ) ? get_option('wpc_cron_rep_ins') . ',' . $current_user->ID . '_' . $id : '');
					update_option('wpc_cron_rep_sum',  ! in_array( $current_user->ID . '_' . $id, array_filter(explode(',', get_option('wpc_cron_rep_sum'))) ) ? get_option('wpc_cron_rep_sum') . ',' . $current_user->ID . '_' . $id : '');

					wp_redirect( $wpchats->get_settings( "messages_page" ) . '?conversation=' . $wpchats->get_message_parts( $id, 'chat_id' ) . '&scs=17' );
					exit;
				} else {
					if($wpchats->get_settings('user_can_delete_reports'))
						delete_user_meta( $current_user->ID, "wpc_report_$id" );
					wp_redirect( $wpchats->get_settings( "messages_page" ) . '?conversation=' . $wpchats->get_message_parts( $id, 'chat_id' ) . '&scs=18' );
					exit;
				}
			}
			echo $html;
		} else {
			ob_start();
			?>
			<h3><?php echo $wpchats->translate(129); ?></h3>
			<p><?php echo $wpchats->translate(130); ?></p>
			<p>This was your report:</p>
			<blockquote><?php echo $meta; ?></blockquote>
			<p><a href="<?php echo $wpchats->get_settings('messages_page').'?conversation='.$wpchats->get_message_parts($id, 'chat_id'); ?>">&laquo; <?php echo $wpchats->translate(131); ?></a></p>
			<?php
			echo ob_get_clean();
		}
	} else {
		wp_redirect( $wpchats->get_settings( "messages_page" ) . '?scs=16' );
		exit;
	}
}
if( $todo == "block_user" ) {
	$user = isset( $_GET["user"] ) ? esc_attr( $_GET["user"] ) : '';
	if( ! is_numeric( $user ) || ! get_userdata($user)->ID || $user == $current_user->ID )
		return; // error
	else {
		if( $wpchats->is_blocked($user, '') ) {
			echo '<p><i class="wpcico-attention"></i> '.$wpchats->translate(132).'.</p>';
			return;
		}
		?>
		<h2><i class="wpcico-block"></i><?php echo $wpchats->translate(81) . ' ' . get_userdata($user)->display_name; ?></h2>
		<p><?php echo str_replace('[user]', get_userdata($user)->display_name, $wpchats->translate(133)); ?></p>
		<p><?php echo $wpchats->translate(134); ?></p>
		<form action="#" method="post">
			<input type="submit" value="<?php echo $wpchats->translate(81) . ' ' . get_userdata($user)->display_name; ?>" name="conf" />
			<input type="reset" class="wpc-load-pm" value="<?php echo $wpchats->translate(16); ?>" onclick="if(wpcJSLoaded){return false;}else window.location.href= '<?php echo $wpchats->get_settings( "messages_page" ) . '?conversation=' . $wpchats->get_conversation_id( $current_user->ID, $user ); ?>';"  data-pm="<?php echo $wpchats->get_conversation_id( $current_user->ID, $user ); ?>" />
		</form>
		<?php
		if(isset( $_POST["conf"] )) {		
			if( isset( $_GET["rdr"] ) ) 
				$wpchats->block_user( $user, esc_attr( $_GET["rdr"] ) );
			else
				$wpchats->block_user( $user, '' );
		}
	}
}
if( $todo == "unblock_user" ) {
	$user = isset( $_GET["user"] ) ? esc_attr( $_GET["user"] ) : '';
	if( ! is_numeric( $user ) || ! get_userdata($user)->ID || $user == $current_user->ID )
		return; // error
	else {
		if( ! $wpchats->is_blocked($user, '') ) {
			echo '<p><i class="wpcico-attention"></i> '.$wpchats->translate(135).'.</p>';
			return;
		}
		?>
		<h2><i class="wpcico-lock-open-alt"></i><?php echo $wpchats->translate(82) . ' ' . get_userdata($user)->display_name; ?></h2>
		<p><?php echo str_replace('[user]', get_userdata($user)->display_name, $wpchats->translate(136)); ?></p>
		<p><?php echo $wpchats->translate(137); ?></p>
		<form action="#" method="post">
			<input type="submit" value="<?php echo $wpchats->translate(82) . ' ' . get_userdata($user)->display_name; ?>" name="conf" />
			<input type="reset" class="wpc-load-pm" value="<?php echo $wpchats->translate(16); ?>" onclick="if(wpcJSLoaded){return false;}else window.location.href= '<?php echo $wpchats->get_settings( "messages_page" ) . '?conversation=' . $wpchats->get_conversation_id( $current_user->ID, $user ); ?>';"  data-pm="<?php echo $wpchats->get_conversation_id( $current_user->ID, $user ); ?>" />
		</form>
		<?php

		if(isset( $_POST["conf"] )) {
			if( isset( $_GET["rdr"] ) ) 
				$wpchats->unblock_user( $user, esc_attr( $_GET["rdr"] ) );
			else
				$wpchats->unblock_user( $user, '' );
		}
	}
}
if ( $todo == "delete_block" ) {
	$user = ( $wpchats->get_conversation( $pm, 'to' ) == $current_user->ID ) ? $wpchats->get_conversation( $pm, 'from' ) : $wpchats->get_conversation( $pm, 'to' );
	if( 
		! isset( $pm ) || $pm == ''
		|| ! isset( $_GET["user"] )
		|| ! is_numeric( $user )
		|| $_GET["user"] !== $user
		|| ! get_userdata($user)->ID
		|| $user == $current_user->ID
		|| ! $wpchats->get_conversation( $pm, 'last_from')
		)
	{
		wp_redirect( $wpchats->get_settings( "messages_page" ). '?scs=12' );
		exit;
	}

	if( $wpchats->get_conversation( $pm, 'from' ) == strval($current_user->ID) || $wpchats->get_conversation( $pm, 'to' ) == strval($current_user->ID) ) {
		?>
			<blockquote>
				<strong><?php echo $wpchats->translate(117); ?></strong>: <?php echo $pm; ?><br>
				<strong><?php echo $wpchats->translate(118); ?></strong>: <?php echo $wpchats->translate(119); ?> <a href="<?php echo $wpchats->user_links('link', $wpchats->get_conversation( $pm, 'contact' ), '' ); ?>"><?php echo get_userdata($wpchats->get_conversation( $pm, 'contact' ))->display_name; ?></a><br>
			</blockquote>
			<p><?php echo str_replace('[user]', get_userdata($wpchats->get_conversation( $pm, 'contact' ))->display_name, $wpchats->translate(138)); ?></p>
			<p><?php echo $wpchats->translate(139); ?></p>
			<p><?php echo str_replace('[user]', get_userdata($wpchats->get_conversation( $pm, 'contact' ))->display_name, $wpchats->translate(140)); ?></p>

			<form action="#" method="post">
				<input type="submit" value="<?php echo $wpchats->translate(86); ?>" name="conf_delete_block" />
				<input type="reset" class="wpc-load-pm" value="<?php echo $wpchats->translate(16); ?>" onclick="if(wpcJSLoaded){return false;}else window.location.href= '<?php echo $wpchats->get_settings( "messages_page" ) . '?conversation=' . $pm; ?>';"  data-pm="<?php echo $pm; ?>" />
			</form>
		<?php
		if ( isset( $_POST["conf_delete_block"] ) ) {

			$wpchats->block_user( $user, '0' );
			$wpchats->single_actions( "delete_conversation", $pm );
			wp_redirect( $wpchats->get_settings( "messages_page" ) . '?scs=13' );
			exit;
		}
	} else {
		wp_redirect( $wpchats->get_settings( "messages_page" ). '?scs=4' );
		exit;
	}
}