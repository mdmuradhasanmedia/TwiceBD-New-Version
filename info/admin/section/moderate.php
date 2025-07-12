<?php
if( isset( $_GET["action"] ) ) {
	$action = isset( $_GET["action"] ) ? esc_attr( $_GET["action"] ) : '';
	$user 	= isset( $_GET["user"] ) ? esc_attr( $_GET["user"] ) : '';
	// admin + moderators
	if( $action == 'del_rep' ) {
		$meta_key = isset( $_GET["rep"] ) ? esc_attr( $_GET["rep"] ) : '';
		$wpc->do_mod('del_rep', $meta_key, $user);
	}
	if( $action == 'del_reps' ) {
		$metas 	= isset( $_GET["reps"] ) ? esc_attr( $_GET["reps"] ) : '';
		$repE 	= '';
		foreach( array_filter(explode(',', $metas)) as $meta ) {
			$repE = explode('_', $meta);
			$wpc->do_mod('del_rep', 'wpc_report_'.$repE[0], $repE[1]);
		}		
	}
	if( $action == 'pm_delete' ) {
		$msg = isset( $_GET["mid"] ) && is_numeric( $_GET["mid"] ) ? $_GET["mid"] : '';
		$wpc->do_mod('del_msg', $msg, '');
	}
	if( $action == 'pms_delete' ) {
		$msgs = isset( $_GET["ids"] ) ? $_GET["ids"] : '';
		foreach( array_filter(explode(',', $msgs )) as $msg )
			$wpc->do_mod('del_msg', $msg, '');
	}
	if( ! isset( $_GET["mod"] ) ) {
		if( $action == 'ban' ) {
			$wpc->do_mod('ban', '', $user);
		}
		if( $action == 'unban' ) {
			$wpc->do_mod('unban', '', $user);
		}
	}
	// admin only
	if( ! $exit ) {
		if( $action == 'add_mod' ) {
			$wpc->mod_actions('add', $user);
		}
		if( $action == 'remove_mod' ) {
			$wpc->mod_actions('remove', $user);
		}
		if( $action == 'add_mods' ) {
			foreach( array_filter(explode(',', $user)) as $user_id ) {
				$wpc->mod_actions('add', $user_id);
			}
		}
	}
}
if($exit) do_action('_wpc_before_mod_page');
global $wpdb;
global $current_user;
$table 	= $wpdb->prefix . "usermeta";
$query 	= $wpdb->get_results( "SELECT * FROM $table WHERE `meta_key` LIKE '%wpc_report%' ORDER BY `umeta_id` DESC" );
echo $wpc->get_counts('reported') > 0 ? '' : '<p>You don\'t have any reported messages for the now.</p>';
foreach( $query as $q ) {
	$ide = explode('_', $q->meta_key);
	$id = end($ide);
	if(!$wpchats->get_message_parts($id, 'chat_id'))
		delete_user_meta( $q->user_id, 'wpc_report_'.$id );
}
if( $wpc->get_counts('reported') > 0 ) {
	$umetas = '';
	$msgs 	= '';
	echo '<p><strong>You have currently '.$wpc->get_counts('reported').' reported message';
	echo $wpc->get_counts('reported') != 1 ? 's' : '';
	echo '</strong></p>';
	echo '<div class="report_list">';
	foreach ( $query as $q ) {
		$href 		= $exit ? $wpchats->get_settings('profile_page').'?id=' : admin_url().'admin.php?page=wpchats&user='; 
		$rand 		= rand(100, 999);
		$ide 		= explode('_', $q->meta_key);
		$id 		= end($ide);
		$from 		= $wpchats->get_message_parts($id, 'from');
		$noReturn 	= false;
		if( $current_user->ID == $from && !current_user_can('manage_options') || get_userdata($from) && in_array('administrator', get_userdata($from)->roles ) && !current_user_can('manage_options') )
			$noReturn = true;// if this message was sent by the current moderator, then, this moderator won't be able to see that his message was reported. Other mods can, and admin can. And, if this reported message was sent by admin, then only admin can see report and moderate it.
		if( $wpchats->get_message_parts($id, 'chat_id') && ! $noReturn ) {
			$umetas .= $id .'_'.$q->user_id. ',';
			$msgs 	.= $id. ',';
			echo '<div class="report_msg"><ul>';
			echo '<li class="l"><table width="100%"><tr><td width="110px" class="fst">Sender</td><td> '.$wpc->get_user_icon($wpchats->get_message_parts($id, 'from'), 30, $href).'</td></tr></table></li>';
			echo '<li class="l"><table width="100%"><tr><td width="110px" class="fst">Recipient</td><td> '.$wpc->get_user_icon($wpchats->get_message_parts($id, 'to'), 30, $href).'</td></tr></table></li>';
			echo '<li class="l"><table width="100%"><tr><td width="110px" class="fst">Message Body</td><td>'.$wpchats->get_message_parts($id, 'body').'</td></tr></table></li>';
			echo '<li class="l"><table width="100%"><tr><td width="110px" class="fst">Time</td><td>'.$wpchats->time_difference( date("Y-m-d H:i:s", $wpchats->get_message_parts($id, 'time')), date("Y-m-d H:i:s", time()), ' ago' ).'</td></tr></table></li>';
			echo '<li class="l"><table width="100%"><tr><td width="110px" class="fst">Deleted by</td><td>';
			$deleted = array_filter(explode(',', $wpchats->get_message_parts($id, 'deleted')));
			if( count($deleted) > 0 ) {
				foreach ( $deleted as $id ) {
					echo get_userdata($id)->display_name;
					echo $id !== end($deleted) ? ' &amp; ' : '';
				}
			} else {
				echo 'None';
			}
			echo '</td></tr></table></li>';
			echo '<li class="l"><table width="100%"><tr><td width="110px" class="fst">Reported by</td><td> '.$wpc->get_user_icon($q->user_id, 30, $href).'</td></tr></table></li>';
			echo '<li class="l"><table width="100%"><tr><td width="110px" class="fst">Reason</td><td> '.$q->meta_value.'</td></tr></table></li>';
			echo '<li class="l"><table width="100%"><tr><td width="110px" class="fst">Actions</td><td> ';
			echo '<select onchange="toggleActions'.$rand.'()" id="ac-'.$rand.'">';
			echo '<option value="0">&mdash; select &mdash;</option>';
			echo '<option value="del_msg">delete message</option>';
			echo '<option value="del_rep">delete report</option>';
			echo '<option value="pm_sen"';
			echo $current_user->ID == $from || $wpc->is_user('banned',$from) ? 'disabled="disabled" title="That\'s you, or this user is banned."' : ''; 
			echo '>contact '.get_userdata($from)->display_name.' (sender)</option>';
			echo '<option value="pm_rep"';
			echo $current_user->ID == $q->user_id || $wpc->is_user('banned',$q->user_id) ? 'disabled="disabled" title="That\'s you, or this user is banned."' : ''; 
			echo '>contact '.get_userdata($q->user_id)->display_name.' (reporter)</option>';
			if( $wpchats->get_settings('mod_can_ban') || current_user_can('manage_options') ) :;
			echo $wpchats->get_settings('mod_can_view_chats') ? '<option value="view_pm">view conversation</option>' : '';
			echo '<option value="ban"';
			echo get_userdata($from) && in_array('administrator', get_userdata($from)->roles ) || $wpc->is_user('banned', $from ) || $current_user->ID == $from || $wpc->is_user('mod', $from) && !current_user_can('manage_options') ? 'disabled="disabled" title="Sorry, you can\'t ban this user."' : ''; 
			echo '>ban '.get_userdata($from)->display_name.' from chat</option>';
			endif;
			echo '</select>';
			?>
				<script type="text/javascript">
				function toggleActions<?php echo $rand; ?>() {
					var action = document.getElementById('ac-<?php echo $rand; ?>').value;
					var url = "<?php echo $exit ? $wpchats->get_settings('profile_page').'?mod=1' : admin_url().'admin.php?page=wpchats&section=moderate'; ?>";
					if( action == 'del_msg' ) {
						var conf = confirm('Are you sure you want to delete this message?');
						if(conf == true) {
							window.location.href = url+'&action=pm_delete&mid=<?php echo $id; ?>';
						}
					}
					if( action == 'del_rep' ) {
						var conf = confirm('Are you sure you want to delete this report?');
						if(conf == true) {
							window.location.href = url+'&action=del_rep&rep=<?php echo $q->meta_key; ?>&user=<?php echo $q->user_id; ?>';					
						}
					}
					if( action == 'pm_sen' ) {
						<?php echo $current_user->ID == $from ? 'return false;' : 'window.location.href = "' . $wpchats->get_settings('messages_page').'?recipient='.$from .'";'; ?>
					}
					if( action == 'pm_rep' ) {
						<?php echo $current_user->ID == $q->user_id ? 'return false;' : 'window.location.href = "' . $wpchats->get_settings('messages_page').'?recipient='.$q->user_id .'";'; ?>
					}
					<?php if($wpchats->get_settings('mod_can_view_chats')):; ?>
					if( action == 'view_pm' ) {
						window.location.href = "<?php echo $wpchats->get_settings('messages_page').'?conversation='. $wpchats->get_message_parts($id, 'chat_id'); ?>";
					}
					<?php endif; ?>
					if( action == 'ban' ) {
						var conf = confirm('Are you sure you want to ban <?php echo get_userdata($from)->display_name; ?> from using chat?');
						if(conf == true) {
							<?php echo get_userdata($from) && in_array('administrator', get_userdata($from)->roles ) || $wpc->is_user('banned', $from ) ? 'return false;' : 'window.location.href = url+\'&action=ban&user='.$from.'\';'; ?>
						}
					}
				}
				</script>
			<?php
			echo '</td></tr></table></li>';
			echo '</ul></div>';
			echo '</tr>';
		}
	}
	$url = $exit ? $wpchats->get_settings('profile_page').'?mod=1' : admin_url().'admin.php?page=wpchats&section=moderate';
	echo '</div>';
	echo '<p><a href="'.$url.'&action=del_reps&reps='.$umetas.'" onclick="return confirm(\'Are you sure you want to do delete these reports?\');"><button class="button">delete all reports</button></a>';
	echo '&nbsp;<a href="'.$url.'&action=pms_delete&ids='.$msgs.'" onclick="return confirm(\'Are you sure you want to do delete these reported messages?\');"><button class="button">delete all reported messages</button></a>';
	echo '</p>';
}
if( $exit ) {
	include( WPC_PLUGIN_PATH.'admin/section/banned.php');
	do_action('_wpc_after_mod_page');
}
if( ! $exit ) {
	$out = 0;
	foreach( get_users() as $user ) {
		if($wpc->is_user('mod', $user->ID) && ! $wpc->is_user('banned', $user->ID) && $user->ID !== $current_user->ID)
			$out += 1;
	}
	?>
	<p></p>
	<h2>Moderators<label for="s_u" class="add-new-h2">Add New</label></h2>
	<h3>Current moderators:</h3>
	<?php if($out>0) {?>
	<table class="wp-list-table widefat striped">
		<tr><th>User</th><th>Action</th></tr>
		<?php
		foreach( get_users() as $user ) {
			if( $wpc->is_user('mod', $user->ID) && ! $wpc->is_user('banned', $user->ID) && $user->ID !== $current_user->ID ) {
				echo '<tr><td>'.$wpc->get_user_icon($user->ID, 30, 'admin.php?page=wpchats&user=').'</td><td><a href="admin.php?page=wpchats&section=moderate&action=remove_mod&user='.$user->ID.'" onclick="return confirm(\'Are you sure you want to do this?\');"><span class="button">Remove moderator</span></a></td></tr>';
			}
		}
		?>
	</table>
	<?php
	} else {
		echo '<p>You have no moderators yet.</p>';
	}
	$countMods = 0;
	foreach( get_users() as $user ) {
		$countMods += get_userdata($user->ID) && in_array('bbp_moderator', get_userdata($user->ID)->roles ) && ! $wpc->is_user('mod', $user->ID) && ! $wpc->is_user('banned', $user->ID) ? 1 : false;
	}
	?>
	<p></p>
	<h3 id="sm">Add new moderator:</h3>
	<strong><?php echo $countMods > 0 ? '<li>Search users:</li>' : 'Search users:'; ?></strong>
	<p>Type below a username, name or user ID and then select the correct user from search results.<br>Please note that, once you make someone a moderator, they will be notified by e-mail.</p>
	<form action="admin.php?page=wpchats&amp;section=moderate#sm" method="post">
		<label for="s_u">Username or user ID: </label>
		<input type="text" name="search_val" <?php echo isset($_POST["search_val"]) ? 'value="'.$_POST["search_val"].'"' : ''; ?> id="s_u" />
		<input type="submit" value="Search user" class="button" name="search_user" />
	</form>
	<?php
	if( isset($_POST["search_user"]) && isset($_POST["search_val"]) ) {
		echo $wpc->search_users( 'mod', esc_attr( $_POST["search_val"] ), '' );
	}
	if( $countMods > 0 ) {
		?>
		<p><strong><li>Import from <a href="users.php?role=bbp_moderator">bbPress moderators</a>:</li></strong></p>
		<p>
			It appears you have moderators among your forum users. Do you wish to make these users, with moderator roles of course, wpchats moderators?
			<br class="clear" />
			The following users will be made moderators if you click the import button:
		</p>
		<p>
			<?php
			$arr 	= get_users();
			$mods 	= '';
			foreach( get_users() as $user ) {
				if( get_userdata($user->ID) && in_array('bbp_moderator', get_userdata($user->ID)->roles ) && ! $wpc->is_user('mod', $user->ID) && ! $wpc->is_user('banned', $user->ID) ) {
					echo '<div class="wpc_user_res">';
					echo $wpc->get_user_icon($user->ID, 40, 'admin.php?page=wpchats&user=');
					echo '</div>';
					$mods .= $user->ID;
					$mods .= ( $user !== end( $arr ) ) ? ',' : '';
				}
			}
			echo "<p><a href=\"admin.php?page=wpchats&section=moderate&action=add_mods&user=$mods\" onclick=\"return confirm('Are you sure you want to do make this/these user(s) moderators?');\">";
			echo "<span class=\"button\">Import moderators ($countMods)</span>";
			echo "</a></p>";
			?>
		</p>
		<?php
	}	
}