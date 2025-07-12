<?php

/**
 * YouTube info- Widgets Channel & Video Cards & more
 * settings file
 */

class wpc
{
	public function last_x_conversations() {		
		global $wpdb;
		global $current_user;
		$table = $wpdb->prefix."mychats";
		include_once( get_template_directory() . '/info/classes/wpchats.php' );
		$wpchats = new wpChats;
		$query = isset( $_GET["search"] ) ? esc_attr( $_GET["search"] ) : '';
		$messages = isset($_GET["search"]) && $_GET["search"] !== ''
					? $wpdb->get_results( "SELECT chat_id FROM $table WHERE `body` LIKE '%$query%' ORDER BY `id` DESC" )
					: $wpdb->get_results( "SELECT chat_id FROM $table WHERE `body` != '' ORDER BY `id` DESC" );
		$arr = '';
		foreach ( $messages as $msg ) {
			$arr .= $msg->chat_id . ',';
		}
		$exp = explode(',', $arr);
		$conversations =  array_unique( array_filter( $exp ) );
		//if(count($conversations) == 0)
			//return;
		$off = 25;
		$c_arr = isset( $_GET["conversations"] ) || isset( $_GET["search"] ) ? $conversations : array_slice($conversations, 0, $off);
		if( !isset( $_GET["conversations"] ) ) {
			echo '<h3>';
			echo $off > count($conversations) ? 'Conversations' : 'Last '.$off.' conversation(s)';
			echo ' <a href="admin.php?page=wpchats&conversations=1">&raquo;</a></h3>';
		} else {
			echo '<h3>Conversations';
			echo $query !== '' ? " matching '$query'" : '';
			echo ' ('.count($c_arr).')</h3>';
		}
		echo $query !== '' && count($c_arr) == 0 ? '<p>No messages have matched your search query, please <label for="s_c">try again</label>:</p>' : '';
		if( !isset($_GET["search"]) && count($c_arr) == 0 ) {
			echo '<p>You have no conversations yet.</p>';
			return;
		}
		ob_start();
		?>
		<form action="admin.php" method="get">
			<input type="hidden" name="page" value="wpchats" />
			<input type="hidden" name="conversations" value="1" />
			<input type="text" id="s_c" placeholder="search messages" name="search" <?php echo isset($_GET["search"]) && $query !== "" ? "value=\"$query\"" : ''; ?> />
		</form>
		<?php
		echo ob_get_clean();
		echo count($c_arr) > 0 ? "<table class=\"wp-list-table widefat striped\">" : '';
		echo count($c_arr) > 0 ? "<tr><th style='cursor:help' title='message from'>Sender</th><th style='cursor:help' title='message sent-to'>Recipient</th><th style='cursor:help' title='messages count within conversation'>Total messages</th><th style='cursor:help' title='last message in this conversation, or the message matching your search query'>" : '';
		if(count($c_arr) > 0) echo $query !== '' ? 'Matched message' : 'Last message';
		echo count($c_arr) > 0 ? "</th><th style='cursor:help' title='is last message deleted by one or both users?'>Deleted by</th><th style='cursor:help' title='delete this last message or view the entire conversation'>Actions</th></tr>" : '';
		$countQ = '';
		foreach ( $c_arr as $pm ) {
			$q = $query !== '' && isset($_GET["search"])
				? $wpdb->get_results( "SELECT * FROM $table WHERE `chat_id` = $pm AND `body` LIKE '%$query%' LIMIT 1" )
				: $wpdb->get_results( "SELECT * FROM $table WHERE `chat_id` = $pm ORDER BY `id` DESC LIMIT 1" );
			$countQ = $wpdb->get_results( "SELECT * FROM $table WHERE `chat_id` = $pm" );
			foreach ( $q as $m ) {
				?>
					<tr>
						<td>
							<a href="admin.php?page=wpchats&amp;user=<?php echo $m->from; ?>">
								<?php echo $wpchats->user_avatar( $m->from, 22 ); ?>
								<span style="vertical-align: top;"><?php echo get_userdata( $m->from )->display_name; ?></span>
							</a>
						</td>
						<td>
							<a href="admin.php?page=wpchats&amp;user=<?php echo $m->to; ?>">
								<?php echo $wpchats->user_avatar( $m->to, 22 ); ?>
								<span style="vertical-align: top;"><?php echo get_userdata( $m->to )->display_name; ?></span>
							</a>
						</td>
						<td><?php echo count($countQ); ?></td>
						<td>
							<?php echo isset($_GET["conversations"]) ? strip_tags( $m->body, "" ) : strip_tags( substr( $m->body, 0, 50), "" );
							echo strlen($m->body) > 50 && !isset($_GET["conversations"]) ? ".." : '';
							echo " &mdash; ";
							echo '<i>' . $wpchats->time_difference( date("Y-m-d H:i:s", $m->time), date("Y-m-d H:i:s", time()), ' ago' ) . '</i>';
							?>
						</td>
						<td>
						<?php
						$deleted = array_filter(explode(',', $wpchats->get_message_parts($m->id, 'deleted')));
						if( count($deleted) > 1 ) {
							echo 'Both users';
						} else {
							if( count($deleted) > 0 ) {
								foreach ( $deleted as $id ) {
									echo get_userdata($id)->display_name;
								}
							} else {
								echo 'None';
							}
						}
						?>
						</td>
						<td>
							<a title="view conversation" href="<?php echo $wpchats->get_settings('messages_page'); ?>?conversation=<?php echo $m->chat_id; ?><?php echo $query !== '' ? "&wpc_search=$query" : ''; ?>" onclick="return confirm('Are you sure?');" target="_blank">view</a>
							&middot;
							<a title="delete this message" href="admin.php?page=wpchats&amp;section=moderate&amp;action=pm_delete&amp;mid=<?php echo $m->id; ?>" onclick="return confirm('Are you sure you want to delete this message?');" target="_blank">delete</a>
						</td>
					</tr>
				<?php				
			}
		}
		echo count($conversations) > count($c_arr) ? '<tr><td><a href="admin.php?page=wpchats&conversations=1" class="button">View all &raquo;</a></td></tr>' : '';
		echo count($c_arr) > 0 ? "</table>" : '';
	}
	public function get_user_icon($user, $s, $href) {
		$wpchats = new wpchats;
		$html = isset($href) ? '<a href="'.$href.$user.'">' : '<a href="user-edit.php?user_id='.$user.'">';
		$html .= $wpchats->user_avatar( $user, $s );
		$html .= ' <span style="vertical-align: top;">'. get_userdata( $user )->display_name .'</span>';
		$html .= '</a>';
		return $html;
	}
	public function get_counts($query) {
		$wpchats = new wpchats;
		global $current_user;
		if( $query == 'reported' ) {
			global $wpdb;
			$table 	= $wpdb->prefix . "usermeta";
			$query 	= $wpdb->get_results( "SELECT * FROM $table WHERE meta_key LIKE '%wpc_report%'" );
			$count = 0;
			foreach( $query as $q ) {
				$ide = explode('_', $q->meta_key);
				$id = end($ide);
				$from = $wpchats->get_message_parts($id, 'from');
				if( 
					   $wpchats->get_message_parts($id, 'chat_id')
					&& $current_user->ID == $from 
					&& !current_user_can('manage_options') 
					|| get_userdata($from) 
					&& in_array('administrator', get_userdata($from)->roles ) 
					&& !current_user_can('manage_options')
				)
				{
					$count += 0;
				}
				else 
				{
					$count += 1;
				}
		
			}
			return $count;
		}
		if( $query == 'banned' ) {
			$op = esc_attr( get_option('wpc_banned') );
			$count = 0;
			foreach( array_unique(array_filter(explode(',', $op))) as $user ) {
				if( get_userdata($user) )
					$count += 1;
			}
			return $count;
		}
		if( $query == 'deleted' ) {
			global $wpdb;
			$table = $wpdb->prefix."mychats_temp";
			$q = $wpdb->get_results( "SELECT * FROM $table");
			return count($q);
		}
	}
	public function search_users($s, $query, $additional) {
		$wpchats = new wpChats;
		global $current_user;
		if( $s == 'mod' ) {
			if( $query == '' )
				return;
			if( is_numeric($query) ) {
				echo '<p></p>';
				if( get_userdata( $query ) && ! $this->is_user('banned', $query) ) {
					$user = $query;
					$html = '<div class="wpc_user_res">';
					$html .= '<p><a href="admin.php?page=wpchats&user='.$user.'" title="more options">';
					$html .= $wpchats->user_avatar( $user, 40 );
					$html .= ' <span style="vertical-align: top;">'. get_userdata( $user )->display_name . ' ('.get_userdata( $user )->user_login.')' .'</span>';
					$html .= '</a></p><p>';
					$html .= $this->is_user('mod', $user) ? "<a href=\"admin.php?page=wpchats&section=moderate&action=remove_mod&user=$user\" onclick=\"return confirm('Are you sure you want to do this?');\"><span class=\"button\">Remove moderator</span></a>" : "<a href=\"admin.php?page=wpchats&section=moderate&action=add_mod&user=$user\" onclick=\"return confirm('Are you sure you want to do this?');\"><span class=\"button button-primary\">Make moderator</span></a>";
					$html .= '</p></div>';
					$notice = get_userdata($user) && in_array('administrator', get_userdata($user)->roles ) ? '<div id="error" class="error notice is-dismissible"><p>Site admin is already moderator by default.</p></div>' : '';
					echo get_userdata($user) && in_array('administrator', get_userdata($user)->roles ) ? $notice : $html;
				} else {
					echo "<div id=\"error\" class=\"error notice is-dismissible\"><p>User #$query not found.</p></div>";
				}
			} else {
				echo '<p></p>';
				foreach( $wpchats->get_users('search', $query) as $user ) {
					$html = '<div class="wpc_user_res">';
					$html .= '<p><a href="admin.php?page=wpchats&user='.$user.'" title="more options">';
					$html .= $wpchats->user_avatar( $user, 40 );
					$html .= ' <span style="vertical-align: top;">'. get_userdata( $user )->display_name . ' ('.get_userdata( $user )->user_login.')' .'</span>';
					$html .= '</a></p><p>';
					$html .= $this->is_user('mod', $user) ? "<a href=\"admin.php?page=wpchats&section=moderate&action=remove_mod&user=$user\" onclick=\"return confirm('Are you sure you want to do this?');\"><span class=\"button\">Remove moderator</span></a>" : "<a href=\"admin.php?page=wpchats&section=moderate&action=add_mod&user=$user\" onclick=\"return confirm('Are you sure you want to do this?');\"><span class=\"button button-primary\">Make moderator</span></a>";
					$html .= '</p></div>';
					$notice = count($wpchats->get_users('search', $query)) == 1 ? '<div id="error" class="error notice is-dismissible"><p>User banned or site admin.</p></div>' : '';
					if( $this->is_user('banned', $user) )
						$html = '';
					if( $this->is_user('banned', $user) && count($wpchats->get_users('search', $query)) == 1 )
						$html = $notice;
					echo get_userdata($user) && in_array('administrator', get_userdata($user)->roles ) ? $notice : $html;
				}
				if( count($wpchats->get_users('search', $query)) <= 0 ) {
					echo "<div id=\"error\" class=\"error notice is-dismissible\"><p>User '$query' not found.</p></div>";
				}
			}
		}
		$href = !is_numeric(strpos($_SERVER["REQUEST_URI"], 'admin')) ? $wpchats->get_settings('profile_page').'?id=' : admin_url().'admin.php?page=wpchats&user='; 
		if( $s == 'banned' ) {
			if( $query == '' )
				return;
			$url = $additional;
			if( is_numeric($query) ) {
				echo '<p></p>';
				if( get_userdata( $query ) && $query != $current_user->ID ) {
					$user 	= $query;
					$html 	= '<div class="wpc_user_res">';
					$html 	.= '<div><a href="'.$href.$user.'" title="more options">';
					$html 	.= $wpchats->user_avatar( $user, 40 );
					$html 	.= ' <span style="vertical-align: top;">'. get_userdata( $user )->display_name . ' ('.get_userdata( $user )->user_login.')' .'</span>';
					$html 	.= '</a></div><div>';
					$html 	.= ! $this->is_user('banned', $user) 
								? "<a href=\"$url&action=ban&user=$user\" onclick=\"return confirm('Are you sure you want to ban this user?');\"><span class=\"button\"><i class=\"wpcico-lock\"></i>ban</span></a>"
								: "<a href=\"$url&action=unban&user=$user\" onclick=\"return confirm('Are you sure you want to unban this user?');\"><span class=\"button\"><i class=\"wpcico-lock-open-alt\"></i>unban</span></a>";
					$html 	.= '</div></div>';
					$notice = get_userdata($user) && in_array('administrator', get_userdata($user)->roles ) ? '<div id="error" class="error notice is-dismissible"><p>Site admin can\'t be banned.</p></div>' : '';
					echo get_userdata($user) && in_array('administrator', get_userdata($user)->roles ) ? $notice : $html;
				} else {
					echo in_array('administrator', $current_user->roles ) ? '<div id="error" class="error notice is-dismissible"><p>Site admin can\'t be banned.</p></div>' : "<div id=\"error\" class=\"error notice is-dismissible\"><p>User #$query not found.</p></div>";
				}
			} else {
				echo '<p></p>';
				foreach( $wpchats->get_users('search', $query) as $user ) {
					$html 	= '<div class="wpc_user_res">';
					$html 	.= '<div><a href="'.$href.$user.'" title="more options">';
					$html 	.= $wpchats->user_avatar( $user, 40 );
					$html 	.= ' <span style="vertical-align: top;">'. get_userdata( $user )->display_name . ' ('.get_userdata( $user )->user_login.')' .'</span>';
					$html 	.= '</a></div><div>';
					$html 	.= ! $this->is_user('banned', $user) 
								? "<a href=\"$url&action=ban&user=$user\" onclick=\"return confirm('Are you sure you want to ban this user?');\"><span class=\"button\"><i class=\"wpcico-lock\"></i>ban</span></a>"
								: "<a href=\"$url&action=unban&user=$user\" onclick=\"return confirm('Are you sure you want to unban this user?');\"><span class=\"button\"><i class=\"wpcico-lock-open-alt\"></i>unban</span></a>";
					$html 	.= '</div></div>';
					if( $user == $current_user->ID )
						$html = '';
					$notice = count($wpchats->get_users('search', $query)) == 1 ? '<div id="error" class="error notice is-dismissible"><p>Site admin can\'t be banned.</p></div>' : '';
					echo get_userdata($user) && in_array('administrator', get_userdata($user)->roles ) ? $notice : $html;
				}
				if( count($wpchats->get_users('search', $query)) <= 0 ) {
					echo "<div id=\"error\" class=\"error notice is-dismissible\"><p>User '$query' not found.</p></div>";
				}
			}
		}
	}
	public function mod_actions($action, $user) {
		$op = get_option('wpc_moderators');
		if( $action == 'add' ) {
			if( ! get_userdata($user) || in_array( $user, array_filter( explode(',', $op) ) ) || $this->is_user('banned', $user) ) { // no user || mod already
				echo '<div id="error" class="error notice is-dismissible"><p>User ';
				echo ! get_userdata($user) ? 'does not exist' : 'banned or already moderator';
				echo '</p></div>';
				exit;
			}
			$val = ( ! $op || $op == '' ) ? $user : $op . ','.  $user;
			$Cval = '';
			$arr = array_filter( explode(',', $val) );
			foreach( $arr as $id ) {
				$Cval .= ( $id && $id !== '' ) ? $id : '';
				$Cval .= ( $id !== end( $arr ) ) ? ',' : '';
			}
			update_option( 'wpc_moderators', $Cval );
			// notify the newly-created moderator via email
			$wpchats = new wpChats;
			add_filter('wp_mail_from_name', function() {$wpchats = new wpChats;return $wpchats->get_settings('mail_headers_from_name');});
			add_filter('wp_mail_from', function() {$wpchats = new wpChats;return $wpchats->get_settings('mail_headers_from');});
			wp_mail(
				$wpchats->user_preferences( $user, 'email' ),
				str_replace( 
					array( '[moderator]', '[site-name]', '[site-description]' ), 
					array( get_userdata($user)->user_nicename, get_bloginfo('name'), get_bloginfo('description') ),
					$wpchats->get_settings('new_mod_notif_subject')
				),
				str_replace( 
					array( '[moderator]', '[moderator-link]', '[settings-link]', '[site-name]', '[site-description]', '[mod-panel]' ), 
					array( get_userdata($user)->user_nicename, $wpchats->user_links('link', $user, ''), $wpchats->get_settings('profile_page') . "?edit=1", get_bloginfo('name'), get_bloginfo('description'), $wpchats->get_settings('profile_page').'?mod=1' ),
					$wpchats->get_settings('new_mod_notif_body')
				)
			);
			update_option( 'wpc_total_emails_sent', is_numeric( get_option('wpc_total_emails_sent') ) ? abs( get_option('wpc_total_emails_sent') + 1 ) : 1 );
			// output a success notice
			echo '<div id="updated" class="updated notice is-dismissible"><p>User '. get_userdata($user)->display_name .' successfully assigned as moderator!</p></div>';
		}
		if( $action == 'remove' ) {
			if( ! get_userdata($user) || ! in_array( $user, array_filter( explode(',', $op) ) ) ) { // no user || not mod
				echo '<div id="error" class="error notice is-dismissible"><p>User ';
				echo ! get_userdata($user) ? 'does not exist' : 'not moderator';
				echo '</p></div>';
				exit;
			}
			$val = '';
			$arr = array_filter( explode(',', $op) );
			foreach( $arr as $id ) {
				$val .= ( $id && $id !== '' && $id != $user ) ? $id : '';
				$val .= ( $id !== end( $arr ) ) ? ',' : '';
			}
			if( $val !== '' )
				update_option( 'wpc_moderators', $val );
			else
				delete_option( 'wpc_moderators' );
			echo '<div id="updated" class="updated notice is-dismissible"><p>User '. get_userdata($user)->display_name .' successfully removed as moderator!</p></div>';
		}
	}
	public function is_user($query, $user) {
		if( $query == 'mod' ) {
			$op = get_option('wpc_moderators');
			if( get_userdata($user) && in_array('administrator', get_userdata($user)->roles ) ) {
				return true;
				exit;
			}
			if( ! $op || $op == '' ) {
				return false;
				exit;
			}
			if( in_array( $user, array_filter(explode(',', $op))) )
				return true;
			else
				return false;
		}
		if( $query == 'banned' ) {
			if( in_array( $user, array_filter( explode(',', get_option('wpc_banned')) ) ) )
				return true;
			else
				return false;
		}
	}
	public function do_mod($query, $id, $user) {

		global $current_user;
		$wpchats = new wpChats;
		if( $query == 'del_rep' ) {
			$meta 	= get_user_meta($user, esc_attr( $id ), TRUE);
			$ide 	= explode('_', $id);
			$from 	= $wpchats->get_message_parts(end($ide), 'from');
			if( $current_user->ID == $from && ! current_user_can('manage_options') || get_userdata($from) && in_array('administrator', get_userdata($from)->roles ) && !current_user_can('manage_options') )
			{
				echo '<div id="error" class="error notice is-dismissible"><p>You can\'t delete this report.</p></div>';
				exit;
			}
			if( ! $meta  ) {
				echo '<div id="error" class="error notice is-dismissible"><p>Error - report not found.</p></div>';
			} else {
				delete_user_meta( $user, esc_attr( $id ) );
				echo '<div id="updated" class="updated notice is-dismissible"><p>Report successfully deleted.</p></div>';
			}
		}
		if( $query == 'del_msg' ) {
			if( $wpchats->get_message_parts($id, 'chat_id') ) {
				global $wpdb;
				$table = $wpdb->prefix."mychats";
				$table2 = $wpdb->prefix."mychats_temp";
				$wpdb->insert( 
					$table2, 
					array( 
						'id'		=> $id,
						'chat_id' 	=> $wpchats->get_message_parts($id, 'chat_id'), 
						'from'    	=> $wpchats->get_message_parts($id, 'from'),
						'to'      	=> $wpchats->get_message_parts($id, 'to'),
						'body'    	=> $wpchats->get_message_parts($id, 'body'),
						'time'    	=> $wpchats->get_message_parts($id, 'time'),
						'seen' 		=> $wpchats->get_message_parts($id, 'seen'),
						'status'    => $wpchats->get_message_parts($id, 'status'),
						'deleted' 	=> $wpchats->get_message_parts($id, 'deleted'),
					)
				);
				$wpdb->query($wpdb->prepare("DELETE FROM $table WHERE `id` = %d LIMIT 1",$id));
				echo '<div id="updated" class="updated notice is-dismissible"><p>Message successfully deleted.</p></div>';
			} else {
				echo '<div id="updated" class="error notice is-dismissible"><p>Message not found.</p></div>';
			}
		}
		if( $wpchats->get_settings('mod_can_ban') || current_user_can('manage_options') ) :;
		if( $query == 'ban' ) {
			exit;//pro feature
		}
		if( $query == 'unban' ) {
			exit;//pro feature
		}
		endif;
	}
	public function get_users($query, $additional) {
		if( $query == 'banned' ) {
			$val = '';
			$arr = get_users();
			foreach( $arr as $user ) {
				$val .= $this->is_user('banned', $user->ID) ? $user->ID : '';
				$val .= ( $user !== end( $arr ) ) ? ',' : '';
			}
			return array_unique(array_filter( explode(',', $val) ));
		}
	}
	public function do_deleted($query, $id) {
		global $wpdb;
		$table = $wpdb->prefix."mychats";
		$table2 = $wpdb->prefix."mychats_temp";
		$wpchats = new wpChats;
		if ( ! is_array($id) ) {
			if( $query == 'restore' ) {
				$wpdb->insert( 
					$table, 
					array( 
						'id' 		=> $id, 
						'chat_id' 	=> $this->get_deleted_message($id, 'chat_id'), 
						'from'    	=> $this->get_deleted_message($id, 'from'),
						'to'      	=> $this->get_deleted_message($id, 'to'),
						'body'    	=> $this->get_deleted_message($id, 'body'),
						'time'    	=> $this->get_deleted_message($id, 'time'),
						'seen' 		=> $this->get_deleted_message($id, 'seen'),
						'status'    => $this->get_deleted_message($id, 'status'),
						'deleted' 	=> $this->get_deleted_message($id, 'deleted'),
					)
				);
				$wpdb->query($wpdb->prepare("DELETE FROM $table2 WHERE `id` = %d LIMIT 1",$id));
				echo '<div id="updated" class="updated notice is-dismissible"><p>Message successfully restored.</p></div>';
			}
			if( $query == 'trash' ) {
				$wpdb->query($wpdb->prepare("DELETE FROM $table2 WHERE `id` = %d LIMIT 1",$id));
				echo '<div id="updated" class="updated notice is-dismissible"><p>Message successfully trashed.</p></div>';
			}
		} else {
			if( $query == 'restore' ) {
				foreach( array_unique(array_filter($id)) as $m ) {
					$wpdb->insert( 
						$table, 
						array( 
							'id' 		=> $id, 
							'chat_id' 	=> $this->get_deleted_message($m, 'chat_id'), 
							'from'    	=> $this->get_deleted_message($m, 'from'),
							'to'      	=> $this->get_deleted_message($m, 'to'),
							'body'    	=> $this->get_deleted_message($m, 'body'),
							'time'    	=> $this->get_deleted_message($m, 'time'),
							'seen' 		=> $this->get_deleted_message($m, 'seen'),
							'status'    => $this->get_deleted_message($m, 'status'),
							'deleted' 	=> $this->get_deleted_message($m, 'deleted'),
						)
					);
					$wpdb->query($wpdb->prepare("DELETE FROM $table2 WHERE `id` = %d LIMIT 1",$m));
					echo '<div id="updated" class="updated notice is-dismissible"><p>Message successfully restored.</p></div>';
				}
			}
			if( $query == 'trash' ) {
				foreach( array_unique(array_filter($id)) as $m ) {
					$wpdb->query($wpdb->prepare("DELETE FROM $table2 WHERE `id` = %d LIMIT 1",$m));
					echo '<div id="updated" class="updated notice is-dismissible"><p>Message successfully trashed.</p></div>';
				}
			}
		}
	}

	public function get_deleted_message( $id, $query ) {

		global $wpdb;
		$table = $wpdb->prefix."mychats_temp";
		$q = $wpdb->get_results( "SELECT * FROM $table WHERE `id` = '$id' LIMIT 1");
		$id 		= '';
		$chat_id 	= '';
		$to 		= '';
		$from 		= '';
		$body 		= '';
		$time 		= '';
		$seen 		= '';
		$status 	= '';
		$deleted 	= '';
		foreach ( $q as $pm ) {
				$id 		= esc_attr( $pm->id );
				$chat_id 	= esc_attr( $pm->chat_id );
				$to 		= esc_attr( $pm->to );
				$from 		= esc_attr( $pm->from );
				$body 		= esc_attr( $pm->body );
				$time 		= esc_attr( $pm->time );
				$seen 		= esc_attr( $pm->seen );
				$status 	= esc_attr( $pm->status );
				$deleted 	= esc_attr( $pm->deleted );
		}
		if ( $query == 'id' ) return $id;
		if ( $query == 'chat_id' ) return $chat_id;
		if ( $query == 'to' ) return $to;
		if ( $query == 'from' ) return $from;
		if ( $query == 'body' ) return $body;
		if ( $query == 'time' ) return $time;
		if ( $query == 'seen' ) return $seen;
		if ( $query == 'status' ) return $status;
		if ( $query == 'deleted' ) return $deleted;

	}

	public function statistics($stat) {
		global $wpdb;
		$table = $wpdb->prefix."mychats";
		$table2 = $wpdb->prefix."mychats_temp";
		$q1 = $wpdb->get_results( "SELECT id FROM $table WHERE `body` != ''");
		$q2 = $wpdb->get_results( "SELECT id FROM $table2");
		$q3 = $wpdb->get_results( "SELECT id FROM $table ORDER BY `id` DESC LIMIT 1");
		$last = '';
		foreach( $q3 as $m )
			$last = $m->id;
		$convs = $wpdb->get_results( "SELECT chat_id FROM $table WHERE `body` != '' ORDER BY `id` DESC" );
		$array = array();
		foreach ( $convs as $msg ) {
			$array[] .= $msg->chat_id . ',';
		}
		$count_mods = 0;
		foreach( get_users() as $user )
			$count_mods += $this->is_user('mod', $user->ID) ? 1 : false;
		$qq = $wpdb->get_results( "SELECT * FROM $table");
		$output = array();
		foreach( $qq as $pm ) {
			$output[] .= ( count(array_filter(explode(',',$pm->deleted)))<2 ) ? $pm->to : '';
			$output[] .= ( count(array_filter(explode(',',$pm->deleted)))<2 ) ? $pm->from : '';
		}
		$total_emails = is_numeric(get_option('wpc_total_emails_sent')) ? get_option('wpc_total_emails_sent') : 0;
		if( $stat == 'total_messages' )
			return count($q1);
		if( $stat == 'total_deleted' )
			return count($q2);
		if( $stat == 'total_trashed' )
			return abs( $last - ( count($q1) + count($q2) ) );
		if( $stat == 'total_conversations' )
			return count(array_unique( array_filter( $array ) ));
		if( $stat == 'total_mods' )
			return $count_mods;
		if( $stat == 'total_users' )
			return count(get_users());
		if( $stat == 'using_chat' )
			return count(array_unique( array_filter($output) ) );
		if( $stat == 'total_emo' )
			return abs( 55 + count( array_filter(explode(',', get_option('wpc_admin_smileys'))) ) );
		if( $stat == 'total_emails' )
			return is_numeric(get_option('wpc_total_emails_sent')) ? get_option('wpc_total_emails_sent') : 0;
	
	}
}