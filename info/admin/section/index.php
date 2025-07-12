<?php
$return = true;
if( isset($_GET["user"]) ) {

	global $current_user;
	echo '<h3>User profile</h3>';
	$user_id = $_GET["user"];
	if( get_userdata($user_id) ) {
		echo '<div style="border: 1px solid #ccc;padding: 1em;background-color: #fff;">';
		echo '<div style="display:inline-block;padding-right: 6px;"><a target="_new" href="' . $wpchats->user_links('link', $user_id, '') . '" class="wpc_user_ajax" data-user="' . get_userdata($user_id)->user_login . '">';
		echo $wpchats->user_avatar( $user_id, 100 );
		echo '</div></a>';
		echo '<div style="display:inline-block;vertical-align:top;">';
		echo '<div><a target="_new" href="' . $wpchats->user_links('link', $user_id, '') . '" class="wpc_user_ajax" data-user="' . get_userdata($user_id)->user_login . '"><i class="wpcico-user-1"></i>'.get_userdata( $user_id )->display_name.'</a></div>';
		echo $wpc->is_user('mod', $user_id) ? '<div><i class="wpcico-eye"></i>Moderator</div>' : '';
		echo '<div>'.$wpchats->online_status( $user_id ).'</div>';
		if( $current_user->ID != $user_id ) {
			echo '<div>'.$wpchats->user_links( 'message', $user_id, '').'</div>';
			echo '<div>'.$wpchats->user_links( 'block', $user_id, '' ).'</div>';
		} else {
			echo '<div><a target="_new" href="' . $wpchats->get_settings('profile_page') . '?edit=1"><i class="wpcico-wrench"></i>edit profile</a></div>';
		}
		echo '</div><p></p>';
		if($wpchats->user_info( $user_id, 'bio' )) {
			echo '<p class="wpc-user-bio">';
			echo '<strong>About me</strong><br>';
			echo $wpchats->user_info( $user_id, 'bio' );
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
			echo '<strong>Find me on</strong>';
			echo $wpchats->user_info($user_id, 'social_tw') ? '<a target="_new" href="'.$wpchats->user_info($user_id, 'social_tw').'" rel="nofollow" target="_blank" title="Twitter" style="display:block;"><i class="wpcico-twitter"></i>Twitter</a>' : '';
			echo $wpchats->user_info($user_id, 'social_fb') ? '<a target="_new" href="'.$wpchats->user_info($user_id, 'social_fb').'" rel="nofollow" target="_blank" title="Facebook" style="display:block;"><i class="wpcico-facebook-squared"></i>Facebook</a>' : '';
			echo $wpchats->user_info($user_id, 'social_yt') ? '<a target="_new" href="'.$wpchats->user_info($user_id, 'social_yt').'" rel="nofollow" target="_blank" title="YouTube" style="display:block;"><i class="wpcico-youtube-squared"></i>YouTube</a>' : '';
			echo $wpchats->user_info($user_id, 'social_gp') ? '<a target="_new" href="'.$wpchats->user_info($user_id, 'social_gp').'" rel="nofollow" target="_blank" title="Google+" style="display:block;"><i class="wpcico-gplus-squared"></i>Google+</a>' : '';
			echo $wpchats->user_info($user_id, 'social_in') ? '<a target="_new" href="'.$wpchats->user_info($user_id, 'social_in').'" rel="nofollow" target="_blank" title="Linkedin" style="display:block;"><i class="wpcico-linkedin-squared"></i>Linkedin</a>' : '';
			echo $wpchats->user_info($user_id, 'social_st') ? '<a target="_new" href="'.$wpchats->user_info($user_id, 'social_st').'" rel="nofollow" target="_blank" title="Website" style="display:block;"><i class="wpcico-link-ext-alt	"></i>Website</a>' : '';
			echo '</p>';
		}
		echo '</div>';
	}
	ob_start();
	?>
	<h3>Quick tools</h3>
	<?php
	echo '<p>';
	if( $current_user->ID != $user_id ) {
		if( $wpc->is_user( 'mod', $user_id ) ) {
			echo "<a target=\"_new\" onclick=\"return confirm('Are you sure you want to do this?');\" href=\"admin.php?page=wpchats&section=moderate&action=remove_mod&user=$user_id\"><span class=\"button\">Remove as moderator</span></a>&nbsp;";
		} else {
			echo "<a target=\"_new\" onclick=\"return confirm('Are you sure you want to do this?');\" href=\"admin.php?page=wpchats&section=moderate&action=add_mod&user=$user_id\"><span class=\"button\">Make moderator</span></a>&nbsp;";
		}
		if( $wpc->is_user( 'banned', $user_id ) ) {
			echo "<a target=\"_new\" onclick=\"return confirm('Are you sure you want to do this?');\" href=\"admin.php?page=wpchats&section=banned&action=unban&user=$user_id\"><span class=\"button\">Unban ".get_userdata($user_id)->user_nicename."</span></a>&nbsp;";
		} else {
			echo "<a target=\"_new\" onclick=\"return confirm('Are you sure you want to do this?');\" href=\"admin.php?page=wpchats&section=banned&action=ban&user=$user_id\"><span class=\"button\">ban ".get_userdata($user_id)->user_nicename."</span></a>&nbsp;";
		}
		if( $wpchats->is_blocked( $user_id, '' ) ) {
			echo "<a target=\"_new\" href=\"" . $wpchats->get_settings( 'messages_page' ) . "?todo=unblock_user&user=$user_id\"><span class=\"button\">Unblock ".get_userdata($user_id)->user_nicename."</span></a>&nbsp;";
		} else {
			echo "<a target=\"_new\" href=\"" . $wpchats->get_settings( 'messages_page' ) . "?todo=block_user&user=$user_id\"><span class=\"button\">Block ".get_userdata($user_id)->user_nicename."</span></a>&nbsp;";
		}
		echo '<a target="_new" href="' . $wpchats->get_settings( 'messages_page' ) . '?recipient='.$user_id.'"><span class="button">Contact '.get_userdata($user_id)->user_nicename.'</span></a>&nbsp;';
	} else {
		echo '<div><a target="_new" href="' . $wpchats->get_settings('profile_page') . '?edit=1"><span class="button">edit profile</span></a></div>';
	}
	echo '</p>';
	?>
	<p>
		<form action="#" method="post">
			<label for="email-body" style="display: block;"><strong>Send an e-mail</strong></label>
			<input type="text" name="email_subject" placeholder="subject" size="50" required="required"/><br>
			<textarea name="email_body" rows="4" cols="50" id="email-body" required="required" placeholder="email body"></textarea><br>
			<input type="text" value="To: <?php echo $wpchats->user_preferences($user_id, 'email'); ?>" disabled="disabled" size="37"/>
			<input type="submit" name="email_send" value="send email" class="button button-primary" onclick="return confirm('Are you sure?');" />
		</form>
	</p>
	<?php
	if( isset( $_POST["email_send"] ) && $_POST["email_subject"] !== '' && $_POST["email_body"] !== '' ) {
		add_filter('wp_mail_from_name', function() {$wpchats = new wpChats;return $wpchats->get_settings('mail_headers_from_name');});
		add_filter('wp_mail_from', function() {$wpchats = new wpChats;return $wpchats->get_settings('mail_headers_from');});
		wp_mail(
			$wpchats->user_preferences( $user_id, 'email'),
			stripslashes($_POST["email_subject"]),
			stripslashes($_POST["email_body"])
		);
		update_option( 'wpc_total_emails_sent', is_numeric( get_option('wpc_total_emails_sent') ) ? abs( get_option('wpc_total_emails_sent') + 1 ) : 1 );
		echo '<div id="updated" class="updated notice is-dismissible"><p>Email sent successfully!</p></div>';
	} else {
		echo isset( $_POST["email_send"] ) ? '<div id="updated" class="error notice is-dismissible"><p>Error sending email.</p></div>' : '';
	}
	
	$return = false;
}
if( isset( $_GET["conversations"] ) ) {
	echo $wpc->last_x_conversations();
	$return = false;
}
if( $return ) {
	$count = 0;
	$off = 25;
	foreach( get_users() as $user ) {
		global $wpdb;
		$table = $wpdb->prefix."mychats";
		$q = $wpdb->get_results( "SELECT * FROM $table WHERE `to` = '$user->ID' AND `body` != '' OR `from` = '$user->ID' AND `body` != '' LIMIT 1" );
		if( !empty($q) ) {
			$count += 1;
		}
	}
	echo '<h3>';
	echo isset($_GET["search"]) && $_GET["search"] !== '' ?  'Search users using chat' : 'People using chat';
	if( $count > $off && ! isset($_GET["users"]) )
		echo $count > 0 ? ' ('.$off.'/'.$count.')' : '';
	else		
		echo !isset($_GET["search"]) && $count > 0 ? ' ('.$count.')' : '';
	echo !isset($_GET["users"]) ? ' <a href="admin.php?page=wpchats&users=1">&raquo;</a>' : '';
	echo '</h3>';
	if( $count > 0 ) {
		ob_start();
		?>
		<form action="admin.php" method="get">
			<input type="hidden" name="page" value="wpchats" />
			<input type="hidden" name="users" value="1" />
			<input type="text" id="user-search" autocomplete="off" placeholder="search users by ID, name or email" name="search" size="33" title="type and press enter" <?php echo isset($_GET["search"]) && $_GET["search"] !== '' ? 'value="'.esc_attr($_GET["search"]).'"' : ''; ?> />
		</form>
		<?php
		echo ob_get_clean();
		echo '<div id="users-cont">';
		$index = 0;
		$user_id = true;
		foreach( get_users() as $user ) {
			if( isset($_GET["search"]) && $_GET["search"] !== '' ) {
				if( is_numeric($_GET["search"]) ) {
					$user_id = $user->ID ==  intval($_GET["search"]) ? true : false;
				} else {
					if( 
						   substr_count( $user->display_name,  esc_attr($_GET["search"]) ) > 0
						|| substr_count( $user->user_email,  esc_attr($_GET["search"]) ) > 0
						|| substr_count( $user->user_nicename,  esc_attr($_GET["search"]) ) > 0
					)
					{
						$user_id = true;					
					}
					else
					{
						$user_id = false;					
					}
				}
			}
			if( $user_id ) {
				global $wpdb;
				$table = $wpdb->prefix."mychats";
				$q = $wpdb->get_results( "SELECT * FROM $table WHERE `to` = '$user->ID' AND `body` != '' OR `from` = '$user->ID' AND `body` != '' LIMIT 1" );
				if( !empty($q) ) {
					$index += 1;
					if($index <= $off || isset($_GET["users"])) {
						?>
						<div data-keyword="<?php echo $user->user_nicename . ' ' . $user->display_name . ' ' . $user->user_email . ' ' . $user->ID; ?>" onclick="window.location.href = 'admin.php?page=wpchats&amp;user=<?php echo $user->ID; ?>';" 
						title="Name: <?php echo $user->display_name . "\nEmail: " . $user->user_email . "\nUser ID: " . $user->ID."\n"; ?>more options &raquo;"
						>
							<a href="admin.php?page=wpchats&amp;user=<?php echo $user->ID; ?>">
								<?php echo $wpchats->user_avatar( $user->ID, 40 ); ?>
								<span><?php echo $user->user_nicename; ?></span>
							</a>
						</div>
						<?php
					}
				}
			}
		}
		echo $index == 0 ? '<p>No user has matched your search query.</p>' : '';
		echo $index > $off && !isset($_GET["users"]) ? '<a href="admin.php?page=wpchats&users=1"><span class="more" style="display:table">view more &raquo;</span></a>' : '';
		echo '</div>';
		echo '<div class="u-sug"></div>';
	} else {
		echo '<p>No users are currently using chat. Please check back later.</p>';
	}
	if( isset($_GET["users"]) )
		return;
	echo $wpc->last_x_conversations();
	echo '<h3>Statistics</h3>';
	echo '<table id="wpc-stats" class="widefat striped">';
	echo '<th>Property</th><th>Count</th>';
	echo "<tr><td>Total conversations</td><td>".$wpc->statistics('total_conversations')."</span></td></tr>";
	echo "<tr><td>Total messages</td><td>".$wpc->statistics('total_messages')."</span></td></tr>";
	echo "<tr><td>Total deleted messages</td><td>".$wpc->statistics('total_deleted')."</span></td></tr>";
	echo "<tr><td>Total trashed messages</td><td>".$wpc->statistics('total_trashed')."</span></td></tr>";
	echo "<tr><td>Users using chat/total</td><td>".$wpc->statistics('using_chat')."/".$wpc->statistics('total_users')."</span></td></tr>";
	echo "<tr><td>Moderators count</td><td>".$wpc->statistics('total_mods')."</span></td></tr>";
	echo "<tr><td>Total emoticons (emoji)</td><td>".$wpc->statistics('total_emo')."</span></td></tr>";
	//echo "<tr><td>Total emails sent</td><td>".$wpc->statistics('total_emails')."</span></td></tr>";
	echo "</table>";

}