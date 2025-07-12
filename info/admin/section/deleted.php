<?php
echo '<h2>Deleted messages</h2>';
if( isset($_GET["action"]) && isset($_GET["id"]) && in_array($_GET["action"], array('restore', 'trash', 'restore_all', 'trash_all'))) {
	$action = $_GET["action"];
	$id 	= $_GET["id"];
	if( $action == 'restore' ) {
		$target = substr_count($id, ',') > 0 ? array_filter(explode( ',', $id )) : $id;
		$wpc->do_deleted('restore', $target);
	}
	if( $action == 'trash' ) {
		$target = substr_count($id, ',') > 0 ? array_filter(explode( ',', $id )) : $id;
		$wpc->do_deleted('trash', $target);
	}
}
if($wpc->get_counts('deleted') > 0) {
	global $wpdb;
	$table = $wpdb->prefix."mychats_temp";
	$q = $wpdb->get_results( "SELECT * FROM $table ORDER BY `id` DESC");
	$url = 'admin.php?page=wpchats&section=deleted';
	$ids = '';
	echo '<p>Below you can access all the messages deleted by you or the moderators via the moderation panel. Those deleted messages are stored in a separate database table, and you can either trash them or restore them to their respective conversations:</p>';
	echo '<table class="wp-list-table widefat striped">';
	echo '<tr> <th>ID</th> <th>Deleted from Conversation</th> <th>Sender</th> <th>Recipient</th> <th>Message</th> <th>Time</th> <th>Status</th> <th>actions</th> </tr>';
	foreach( $q as $m ) {
		$ids .= $m->id;
		$ids .= $m !== end($q) ? ',' : '';
		echo '<tr>';
		echo '<td>'.$m->id.'</td>';
		echo '<td>';
		echo $wpchats->get_settings('mod_can_view_chats') || current_user_can('manage_options') ? '<a href="'.$wpchats->get_settings('messages_page').'?conversation='.$m->chat_id.'">'.$m->chat_id.'</a>' :$m->chat_id;
		echo '</td>';
		echo '<td>'.$wpc->get_user_icon($m->from, 40, 'admin.php?page=wpchats&user=').'</td>';
		echo '<td>'.$wpc->get_user_icon($m->to, 40, 'admin.php?page=wpchats&user=').'</td>';
		echo '<td>'.$m->body.'</td>';
		echo '<td>'.$wpchats->time_difference( date("Y-m-d H:i:s", $m->time), date("Y-m-d H:i:s", time()), ' ago' ).'</td>';
		echo '<td>';
		echo $m->status == 'read' ? 'seen by recipient ('.$wpchats->time_difference( date("Y-m-d H:i:s", $m->seen), date("Y-m-d H:i:s", time()), ' ago' ).')' : 'not seen';
		echo '</td>';
		echo '<td><a href="'.$url.'&action=restore&id='.$m->id.'" title="restore this message to user conversation" onclick="return confirm(\'Are you sure you want to restore this message?\');"><span class="button">restore</span></a> <a href="'.$url.'&action=trash&id='.$m->id.'" title="delete this message forever" onclick="return confirm(\'Are you sure you want to trash this message forever?\');"><span class="button">trash</span></a></td>';
		echo '</tr>';
	}
	echo '</table>';
	echo '<a href="'.$url.'&action=trash&id='.$ids.'" onclick="return confirm(\'Are you sure you want to trash '.$wpc->get_counts('deleted').' message(s) forever?\');"><span class="button">trash all ('.$wpc->get_counts('deleted').')</span></a>';
	echo '&nbsp;';
	echo '<a href="'.$url.'&action=restore&id='.$ids.'" onclick="return confirm(\'Are you sure you want to restore '.$wpc->get_counts('deleted').' message(s) to user conversations?\');"><span class="button">restore all ('.$wpc->get_counts('deleted').')</span></a>';
} else {
	echo '<p>You have no deleted messages.</p>';
}