<?php class wpChats {

	public $defaultsJSON;
	public $defaultsJSON_help;
	
	function __construct(){

        $this->defaultsJSON = '{

			"1": "Refresh",
			"2": "search",
			"3": "filter",
			"4": "Online Messages",
			"5": "Unread Messages",
			"6": "search all conversations",
			"7": "cancel search",
			"8": "[number] results have matched your search query",
			"9": "See Older Messages",
			"10": "delete",
			"11": "You have reported this message. This was your report to moderators",
			"12": "reported",
			"13": "report",
			"14": "This conversation is empty. Send a message below.",
			"15": "Nothing found matching your search query.",
			"16": "cancel",
			"17": "Clear",
			"18": "view message",
			"19": "Nothing found matching your search query. Try again",
			"20": "Nothing found. Try again or clear your fitlers",
			"21": "You have no conversations yet",
			"22": "Browse users",
			"23": "Previous",
			"24": "Next",
			"25": "Sorry, this user does not exist or you can\'t contact them right now.",
			"26": "Message deleted successfully",
			"27": "Message successfully marked unread",
			"28": "Conversation deleted successfully",
			"29": "You are not part of this conversation",
			"30": "This message does not exist",
			"31": "You can\'t delete this message",
			"32": "This conversation does not exist or is already empty",
			"33": "User successfully unblocked",
			"34": "User successfully blocked",
			"35": "Error sending message",
			"36": "Message sent successfully",
			"37": "Error deleting conversation &amp;/or blocking user",
			"38": "Conversation deleted and user blocked successfully",
			"39": "Changes saved successfully",
			"40": "This user does not exist",
			"41": "Message not found",
			"42": "Message reported to moderators. Thank you for your time!",
			"43": "Report deleted successfully",
			"44": "Please log in first",
			"45": "You are gone online",
			"46": "You are gone offline",
			"47": "dismiss this notice",
			"48": "offline",
			"49": "download",
			"50": "download this image",
			"51": "Are you sure you want to follow this link?",
			"52": "view",
			"53": "open in a new tab",
			"54": "view conversation",
			"55": "get code for this image",
			"56": "code",
			"57": "Use this code to send/embed this image",
			"58": "visit link",
			"59": "Destination URL",
			"60": "external link",
			"61": "download this video online",
			"62": "Use this code to send/embed this video",
			"63": "view on YouTube",
			"64": "get code for this video",
			"65": "view on Vimeo",
			"66": "view on Dailymotion",
			"67": "Your browser does not support the video tag",
			"68": "Sorry, you can\'t contact [user] right now",
			"69": "Send",
			"70": "Press enter to submit",
			"71": "Enter YouTube video URL",
			"72": "Disabled",
			"73": "Go back to online mode?",
			"74": "Warning - you are not part of this conversation. But, you can access it as a moderator",
			"75": "Warning - you are not part of this conversation. But, you can access it as a site admin",
			"76": "visit [user]\'s profile",
			"77": "A conversation between [user-1] and [user-2]",
			"78": "Administrator",
			"79": "messages",
			"80": "This is an empty conversation",
			"81": "Block messages",
			"82": "Unblock messages",
			"83": "actions",
			"84": "Mark as unread",
			"85": "Delete conversation",
			"86": "Delete &amp; block",
			"87": "you",
			"88": "Are you sure you want to delete this message?",
			"89": "Your draft is not auto-saved..",
			"90": "Please enter a valid image URL.",
			"91": "Please enter a valid image link.",
			"92": "Please enter a valid URL.",
			"93": "Enter a video URL",
			"94": "Enter [service] video ID or URL",
			"95": "Sorry, you can\'t send this message.",
			"96": "auto-saving..",
			"97": "auto-save failed",
			"98": "auto-saved",
			"99": "New message from",
			"100": "seen just now",
			"101": "Enter an image URL (required)",
			"102": "Type the link address (required)",
			"103": "Link title (optional)",
			"104": "Image link (optional)",
			"105": "Sending..",
			"106": "Sent!",
			"107": "YouTube",
			"108": "Vimeo",
			"109": "Dailymotion",
			"110": "Direct video",
			"111": "Redirecting.. Taking so long?",
			"112": "click here",
			"113": "From",
			"114": "To",
			"115": "Message",
			"116": "Date",
			"117": "Conversation ID",
			"118": "Between",
			"119": "You and",
			"120": "Please note that this action, which can not be undone, will not prevent the recipient ([user]) from accessing messages within the conversation.",
			"121": "Are you sure you want to delete this conversation?",
			"122": "confirm",
			"123": "Why do you want to report this message?",
			"124": "It appears you have already reported this message. Use below form to update your report",
			"125": "or delete it",
			"126": "Update",
			"127": "delete report",
			"128": "Are you sure?",
			"129": "Message reported",
			"130": "It looks like you have already reported this message. We have successfully recorded your report, and it is now awaiting moderation.",
			"131": "Go back",
			"132": "This user is already blocked by you",
			"133": "Are you sure you want to block [user]?",
			"134": "Blocking this user will prevent them (and you as well) from exchanging messages.",
			"135" : "This user is not blocked by you",
			"136": "Are you sure you want to unblock [user]?",
			"137": "Unblocking this user will give you the possibility to chat with them as long as they don\'t have you in their blocked list.",
			"138": "Please note that this action, will not prevent the recipient ([user]) from accessing messages within the conversation. But, it will prevent them from contacting you again as you block them.",
			"139": "For your information, you can unblock any user anytime, but you can not restore a deleted conversation.",
			"140": "Are you sure you want to <strong>delete</strong> this conversation and <strong>block</strong> [user] ?",
			"141": "View profile",
			"142": "edit profile",
			"143": "About me",
			"144": "Find me on",
			"145": "Twitter",
			"146": "Facebook",
			"147": "Google+",
			"148": "Linkedin",
			"149": "Website",
			"150": "Users",
			"151": "blocked",
			"152": "Admin Panel",
			"153": "edit",
			"154": "[number] users have matched your search query",
			"155": "No users have matched your search query",
			"156": "No users are currently online",
			"157": "You have no blocked users",
			"158": "page",
			"159": "Contact",
			"160": "Please type something..",
			"161": "Profile picture URL",
			"162": "If you wish to change your profile picture, paste above a valid image URL, or edit the avatar associated with your email (<i>[email]</i>) at www.gravatar.com",
			"163": "Your email",
			"164": "This email will be used for email notifications (if your preferences allow that), and to grab the avatar associated with it.",
			"165": "Enable email notifications for new messages (when offline)",
			"166": "Enable new message sound",
			"167": "Blocked users",
			"168": "Moderation settings",
			"169": "When a message gets reported, email me",
			"170": "instantly",
			"171": "daily (summaries)",
			"172": "don\'t email me",
			"173": "Biography",
			"174": "Tell us a little bit about you",
			"175": "Formatting",
			"176": "Hint: use conversation tools to generate those codes.",
			"177": "Social profiles",
			"178": "I don\'t wish to receive messages now",
			"179": "Go offline",
			"180": "Save changes",
			"181": "delete this message",
			"182": "report this message",
			"183": "add emoticons",
			"184": "add image",
			"185": "add video",
			"186": "add link",
			"187": "back to messages",
			"188": "search messages",
			"189": "load previous messages",
			"190": "search users",
			"191": "online users",
			"192": "moderation panel",
			"193": "previous page",
			"194": "next page",
			"195": "refresh messages",
			"196": "search conversations",
			"197": "New message",
			"198": "log out",
			"199": "welcome",
			"200": "loading..",
			"201": "years",
			"202": "year",
			"203": "months",
			"204": "month",
			"205": "days",
			"206": "day",
			"207": "hours",
			"208": "hour",
			"209": "minutes",
			"210": "minute",
			"211": "seconds",
			"212": "second",
			"213": "Just now",
			"214": "[time] ago",
			"215": "active [time] ago",
			"216": "active now",
			"217": "go offline",
			"218": "go online",
			"219": "You have [count] unread message(s)",
			"220": "You have no unread messages",
			"221": "there is(are) [count] user(s) currently online",
			"222": "There are no online users",
			"223": "you have [count] blocked user(s)",
			"224": "you have [count] reported message(s)",
			"225": "you have no reported messages.",
			"226": "edit your chat settings",
			"227": "You are online. Switch to offline mode?",
			"228": "You are offline. Switch to online mode?",
			"229": "add audio",
			"230": "download this audio",
			"231": "get code for this audio",
			"232": "Use this code to send/embed this audio",
			"233": "Soundcloud",
			"234": "Spotify",
			"235": "Beatport",
			"236": "Direct audio",
			"237": "Enter SoundCloud audio URL",
			"238": "Enter [service] audio URL",
			"239": "Enter an audio URL",
			"240": "More Options",
			"241": "No result match in your search query",
			"242": "Newer Messages",
			"243": "Online"

		}';

		$this->defaultsJSON_help = '{

			"159": "contact user (link)",
			"115": "(noun) message content",
			"158": "used in messages/users pagination",
			"160": "when a user attempts to send an empty message, they get this alert",
			"143": "a label displayed before a user\'s \"about info\" in their profiles",
			"144": "a label displayed before a user\'s social profiles in their profiles",
			"145": "link, displayed in users social profiles section",
			"146": "link, displayed in users social profiles section",
			"147": "link, displayed in users social profiles section",
			"148": "link, displayed in users social profiles section",
			"149": "link, displayed in users social profiles section",
			"150": "in users page, displayed in the top header, for browsing all users",
			"151": "in users page, displayed in the top header, for browsing blocked users",
			"152": "in users page, displayed in the top header, for accessing the moderation panel",
			"153": "in users page, displayed in the top header, used to edit profile",
			"52": "(verb) displayed below media, ie view image, view video..",
			"56": "link displayed below media, returning a dialog box with media shortcode/BBcode",
			"69": "(verb)",
			"72": "displayed instead of the send button if you can not contact the recipient",
			"81": "(verb)",
			"82": "(verb)",
			"83": "conversation tools drop down menu placeholder option",
			"105": "sending message in progress",
			"106": "message sent",
			"113": "message from(sender)",
			"114": "message to(recipient)",
			"118": "this message is between user 1 and user 2",
			"126": "(verb) ie update your report",
			"12": "shown when message is already reported, instead of report link",
			"9": "\'load more messages\' link",
			"17": "(verb) ie clear your filters, displayed as option in dropdown menu",
			"23": "in messages/users pagination",
			"24": "in messages/users pagination",
			"8": "please include [number] in your translation, it will be replaced with the results count",
			"68": "[user] will be replaced with the user\'s name",
			"133": "[user] will be replaced with the user\'s name",
			"136": "[user] will be replaced with the user\'s name",
			"138": "[user] will be replaced with the user\'s name",
			"140": "[user] will be replaced with the user\'s name",
			"49": "\'download link\' text"

		}';


    	add_filter( 'wp_mail_from_name', array( $this, 'settings_mail_headers_from_name' ) );
		add_filter( 'wp_mail_from', array( $this, 'settings_mail_headers_from' ) );


    }

	/**
	 * sends conversation messages
	 * @param int $chat_id conversation ID (10 digits)
	 * @param int $from sender user ID
	 * @param int $to recipient
	 * @param string $body message body
	 * @param int $time time integer
	 * @return no return, redirects on both success and fail
	*/
	public function send( $chat_id, $from, $to, $body, $time ) {
		global $wpdb;
		global $current_user;
		$wpc = new wpc;	
		$table = $wpdb->prefix."mychats";
		if( $this->is_blocked( $to, 'by' ) || $this->is_blocked( $to, '' ) || $this->user_preferences($to, 'not_avail') ) {
			wp_redirect( $this->get_settings('messages_page') . '?conversation='. $this->get_conversation_id( $current_user->ID, $to ) . '&scs=10' );
			exit;
		}
		
		$elements = array( $chat_id, $from, $to, $body, $time );
		foreach ( $elements as $element )
			if ( ! $element )
				return;
		if( $to == $current_user->ID || $wpc->is_user('banned', $current_user->ID) )
			exit;
		$countWords = 0;
		if( $this->get_settings('banned_words') ) {
		foreach( $this->get_settings('banned_words') as $word )
			$countWords += substr_count(esc_attr( strip_tags($body, '') ), $word);
		}
		if( $countWords > 0 ) {
			wp_redirect( $this->get_settings('messages_page') . '?conversation='. $this->get_conversation_id( $current_user->ID, $to ) . '&scs=10' );
			exit;
		}
		$body = preg_replace('#(<br */?>\s*)+#i', "\n", $body);// replace HTML line breaks with one \n line break.
		// All is good, let's perform the inserting now
		$wpdb->insert( 
			$table, 
			array( 
				'chat_id' => $chat_id, 
				'from'    => $from,
				'to'      => $to,
				'body'    => esc_attr( strip_tags($body, '') ),
				'time'    => $time
			)
		);
		if ( is_numeric( $wpdb->insert_id ) ) {// insert success
			$autoSave = get_option('wpc_autosave_' . $chat_id . '_' . $from);
			if( $autoSave )// delete autosave for the sent message
				delete_option('wpc_autosave_' . $chat_id . '_' . $from);
			/**
			 * Notify user(sent-to) by email of the new message, if they're offline and they choose to receive new message notifications by email
			*/
			if( ! $this->is_logged_in( $to ) && $this->user_preferences( $to, 'msg_notif') && strlen($body) > 0 ) {
				$subject = str_replace( 
							array( '[sender]', '[recipient]', '[site-name]', '[site-description]', '[message]' ),
							array( get_userdata($from)->user_nicename, get_userdata($to)->user_nicename, get_bloginfo('name'), get_bloginfo('description'), esc_attr( strip_tags($body, '') ) ),
							$this->get_settings('new_msg_notif_subject')
						);
				$mbody	= str_replace( 
							array( '[sender]', '[recipient]', '[site-name]', '[site-description]', '[message]', '[message-link]', '[settings-link]', '[sender-link]', '[recipient-link]' ),
							array( get_userdata($from)->user_nicename, get_userdata($to)->user_nicename, get_bloginfo('name'), get_bloginfo('description'), esc_attr( strip_tags($body, '') ), $this->get_settings('messages_page')."?conversation=".$chat_id, $this->get_settings('profile_page')."?edit=1", $this->get_settings('profile_page')."?user=".get_userdata($from)->user_login, $this->get_settings('profile_page')."?user=".get_userdata($to)->user_login ),
							$this->get_settings('new_msg_notif_body')
						);
				wp_mail(
					$this->user_preferences( $to, 'email'),
					$subject,
					$mbody
				);
				update_option( 'wpc_total_emails_sent', is_numeric( get_option('wpc_total_emails_sent') ) ? abs( get_option('wpc_total_emails_sent') + 1 ) : 1 );
			}
			// done, redirect when non-ajax-submitted form
			if ( isset( $_GET['referrer'] ) ) {
				wp_redirect( $_GET['referrer'] );
				exit;
			}
			wp_redirect( $this->get_settings('messages_page') . '?conversation='. $this->get_conversation_id( $current_user->ID, $to ) . '&scs=11' );
			exit;
		} else {
			// there's no insert, display an error notice
			wp_redirect( $this->get_settings('messages_page') . '?conversation='. $this->get_conversation_id( $current_user->ID, $to ) . '&scs=10' );
			exit;
		}
	}
	
	/**
	 * lists messages in the single conversations page (site.ext/messages/?conversation={id})
	 * @param int $pm_id conversation ID (10 digits)
	*/
	public function list_messages( $pm_id ) { 
		global $wpdb;
		global $current_user;
		$crnusr 	= $current_user->ID;
		$table 		= $wpdb->prefix."mychats";
		$pg 		= ( isset( $_GET["pg"] ) && $_GET["pg"] > 0 ) ? intval( $_GET["pg"] ) : '0';
		$off 		= 6;
		$lm 		= ( $off * $pg );
		$query 		= isset( $_GET["wpc_search"] ) ? esc_attr( $_GET["wpc_search"] ) : '';
		$total 		= ( isset( $_GET["wpc_search"] ) )
				 	  ? count( $wpdb->get_results( "SELECT id FROM $table WHERE `chat_id` = '$pm_id' AND `body` LIKE '%$query%' AND FIND_IN_SET('$crnusr', `deleted`) = 0" ) )
				 	  : count( $wpdb->get_results( "SELECT id FROM $table WHERE `chat_id` = '$pm_id' AND FIND_IN_SET('$crnusr', `deleted`) = 0" ) );
		$messages 	= ( isset( $_GET["wpc_search"] ) )
					  ? $wpdb->get_results( "SELECT * FROM $table WHERE `chat_id` = '$pm_id' AND `body` LIKE '%$query%' AND FIND_IN_SET('$crnusr', `deleted`) = 0 ORDER BY `id` DESC LIMIT $lm,$off" )
					  : $wpdb->get_results( "SELECT * FROM $table WHERE `chat_id` = '$pm_id' AND FIND_IN_SET('$crnusr', `deleted`) = 0 ORDER BY `id` DESC LIMIT $lm,$off" );
		$ar_count 	= count(array_reverse($messages));
		$pls 		= abs( $pg + 1 );
		$plz 		= abs( $pg - 1 );
		$dataq 		= isset( $_GET["wpc_search"] ) ? " data-q=\"$query\"" : " data-q=\"\"";
		$andq 		= isset( $_GET["wpc_search"] ) ? "&wpc_search=$query" : '';
		
		if($lm - $off < $total && $off < $total && $ar_count == $off){
			echo "<div class='wpc-cont'><a href=\"?conversation=$pm_id". $andq ."&pg=$pls\" class=\"wpc-paginate wpc-tooltip\" data-next=\"$pls\" data-pm=\"$pm_id\" $dataq>" . $this->translate(9) . "...</a></div>";
		}
		
		if($ar_count > 0) {
			$msg_ar 	= array_reverse($messages);
			$classes 	= '';
			$rep 		= '';
			foreach ( array_reverse($messages) as $row ) {
				$classes = '';
				$classes .= ( $row->from == $current_user->ID ) ? 'sent byme' : 'received bycontact';
				$classes .= ( $row->to == $current_user->ID && $row->status == "unread" ) ? ' unread' : '';
				$classes .= ( $row == end($msg_ar) ) ? ' last' : '';
				$classes .= substr_count($this->output_message($row->body), '<iframe') || substr_count($this->output_message($row->body), '<video') || substr_count($this->output_message($row->body), '<audio') || substr_count($this->output_message($row->body), 'wpc-photo-attachement') ? ' media' : false;
				$rep = get_user_meta($current_user->ID, 'wpc_report_'.$row->id, TRUE);
				global $wpdb; $options1 = get_option('wpc_pages');  $url = $options1["users"]; $url2 = $options1["messaging"]; 
	       	?>
			    <div class="<?php echo $classes; ?>" id="msg_single" data-by="<?php echo $row->from == $current_user->ID ? 'me' : 'contact'; ?>" <?php echo $row == end($msg_ar) && !isset($_GET["wpc_search"]) ? 'data-ins="1"' : ''; ?>>
					<table width="100%" class=""><tr>
					    <td width="50px" valign="top" class="avatar"><?php echo get_avatar($row->from, 45); ?></td>
						<td width="auto" valign="top">
					     	<div class="msg_author user-<?php echo $row->from; ?>"><a href="<?php echo $url .'?user='.get_userdata( $row->from )->user_nicename; ?>"><?php echo get_userdata( $row->from )->display_name; ?></a></div>
							<div class="msg_content m-<?php echo $row->id; ?>"><p><?php echo $this->output_message($row->body); ?></p></div>
							<div class="msg_info cont-<?php echo $row->time; ?>">
						    	<span class="msg_time"><?php echo $this->just_now( $this->time_difference( date("Y-m-d H:i:s", $row->time), date("Y-m-d H:i:s", time()), ' ago' ) ); ?></span><span aria-hidden="true"> · </span>
								<span class="msg_delete"><a href="<?php echo $this->get_settings('messages_page'); ?>?todo=pm_delete&amp;id=<?php echo $row->id; ?>" class="wpc-tooltip" data-action="del"><?php echo $this->translate(10); ?></a></span>
								<?php if ($row->to == $current_user->ID){ ?>
								    <span aria-hidden="true"> · </span><span class="msg_report"><a href="<?php echo $url2 .'?todo=pm_report&id='. $row->id ?>" class="wpc-tooltip" data-action="rep"  title="<?php echo $rep && $rep !== '' ? $this->translate(11) . ': \''.$rep.'\'' : ''; ?>"><?php echo $rep && $rep !== '' ? $this->translate(12) : $this->translate(13); ?></a></span>
								<?php } if ( $query == '' && $row->status == "read" && $row == end($msg_ar) && $row->from == $current_user->ID ) {
									$msg = 'seen '; echo "<span aria-hidden='true'> · </span><span class='msg_seen'>$msg</span>";
								}?>
					     	</div>
						</td>
					</tr></table>
				</div>
			<?php }
		} else {				
			if(! isset($_GET["wpc_search"])){
				$msg = $this->translate(14);
			}else{
				$msg 	= $this->translate(15);
				$query 	= urlencode(esc_attr( $_GET["wpc_search"] ));
				$msg 	.= "<br><a href=\"". $this->get_settings('messages_page') ."?wpc_search=$query\"class=\"btm-s-all\" data-q=\"$query\"><i class=\"wpcico-chat\"></i>".$this->translate(6)."</a>";
				$msg 	.= " &mdash; <a href=\"". $this->get_settings('messages_page') ."?conversation=$pm_id\" class=\"wpc-refresh-pm\" data-pm=\"$pm_id\"><i class=\"wpcico-cancel\"></i>".$this->translate(16)."</a>";
			}

			echo "<div class=\"wpc-0\"><p>$msg</p></div>";
		}
		
		if ($pg > 0 ){
			echo "<div class='wpc-conts'><a href=\"?conversation=$pm_id". $andq ."&pg=$plz\" class=\"wpc-paginate wpc-tooltip\" data-next=\"$pls\" data-pm=\"$pm_id\" $dataq>" . $this->translate(242) . "...</a></div>";
		}
	}
	
	/**
	 * lists messages snippets in the messages index page (site.ext/messages/)
	*/
	public function messages_index() { 
		global $wpdb;
		global $current_user;
		$table = $wpdb->prefix."mychats";
		$current_user_id = $current_user->ID;
		if( isset( $_GET["wpc_search"] ) && $_GET["wpc_search"] !== '' ) {
			$st = isset( $_GET["wpc_search"] ) ? esc_attr( $_GET["wpc_search"] ) : false;
			$messages = $wpdb->get_results( "SELECT `chat_id` FROM $table WHERE `to` = '$current_user_id' AND `body` LIKE '%$st%' OR `from` = '$current_user_id' AND `body` LIKE '%$st%'" );
		}
		else
			$messages = $wpdb->get_results( "SELECT `chat_id` FROM $table WHERE `to` = '$current_user_id' OR `from` = '$current_user_id'" );
		$arr = '';
		foreach ( $messages as $msg )
			$arr .= $msg->chat_id . ',';
		$exp = explode(',', $arr);
		$res = '';
		foreach ( array_unique( array_filter( $exp ) ) as $pm ) {
			if( isset( $_GET["wpc_search"] ) || isset( $_GET["filter"] ) ) {
				if( isset( $_GET["wpc_search"] ) ) {
					if( $_GET["wpc_search"] !== '' ) {
						$st = esc_attr( $_GET["wpc_search"] );
						$q = $wpdb->get_results( "SELECT `id` FROM $table WHERE `chat_id` = $pm AND FIND_IN_SET('$current_user_id', `deleted`) = 0 AND `body` LIKE '%$st%' ORDER BY `id` DESC LIMIT 1" );
					} else {
						wp_redirect( $this->get_settings('messages_page') );
						exit;
					}
				}
				if( isset( $_GET["filter"] ) ) {
					if( in_array( $_GET["filter"], array( 'online', 'unread' ) ) ) {
						if( $_GET["filter"] == "online" ) {
							$output = '';
							$output2 = '';
							foreach( $this->get_users('online', '') as $user ) {
								$output .= $user != $current_user->ID ? $user . ',' : false;
							}
							foreach( array_filter( explode(',', $output) ) as $user ) {
								$output2 .= $this->get_conversation( $this->get_conversation_id( $current_user->ID, $user ), 'chat_id' ) ? $this->get_conversation_id( $current_user->ID, $user ) . ',' : false;
							}
							foreach( array_filter( explode(',', $output2) ) as $pm2 ) {
								$q = $wpdb->get_results( "SELECT `id` FROM $table WHERE `chat_id` = $pm2 AND FIND_IN_SET('$current_user_id', `deleted`) = 0 ORDER BY `id` DESC LIMIT 1" );
							}
							$count = count(array_filter( explode(',', $output2) ));
							if( $count == 0 )
								$q = array();
						}
						if( $_GET["filter"] == "unread" ) {
							$q = $wpdb->get_results( "SELECT `id` FROM $table WHERE `chat_id` = $pm AND `to` = '$current_user_id' AND FIND_IN_SET('$current_user_id', `deleted`) = 0 AND `status` = 'unread' ORDER BY `id` DESC LIMIT 1" );
						}
					} else {
						wp_redirect( $this->get_settings('messages_page') );
						exit;
					}
				} 
			} else {
				$q = $wpdb->get_results( "SELECT `id` FROM $table WHERE `chat_id` = $pm AND FIND_IN_SET('$current_user_id', `deleted`) = 0 ORDER BY `id` DESC LIMIT 1" );
			}
			foreach ( $q as $id )
				$res .= $id->id . ',';
		}
		$expl = explode(',', $res);
		rsort( $expl );
		$pm_classes = '';
		$contact = ''; ?>
		<div class="wpc-index-top">
			<?php global $current_user; $wpchats = new wpChats; $wpc = new wpc; global $wpdb; $options1 = get_option('wpc_pages');  $url = $options1["users"]; $url2 = $options1["messaging"];?>
			<table class="top_m" width="100%"><tbody><tr>
			    <td class="t"  width="<?php if ( current_user_can('administrator')){ echo '34%'; }else{echo '50%'; } ?>" style="text-align:center;"><a class="bi" href="<?php echo $url; ?>"><?php echo $this->translate(197); ?></a></td>
				<td class="t"  width="<?php if ( current_user_can('administrator')){ echo '33%'; }else{echo '50%'; } ?>" style="text-align:center;"><a class="bi bi1" href="<?php echo $url2; ?>"><?php echo $this->translate(1); ?></a></td>
		     	<?php if( $wpc->is_user('mod', $current_user->ID)){ ?><td class="t"  width="<?php if ( current_user_can('administrator')){ echo '34%'; }else{echo '50%'; } ?>" style="text-align:center;"><a class="bi bi1" href="<?php echo $url .'?mod=1' ?>"><?php echo $this->translate(152); if($wpc->get_counts('reported')>0){ ?> (<?php echo $wpc->get_counts('reported'); ?>)<?php } ?></a></td><?php }?>
			</tr></tbody></table>
			<?php do_action('_wpc_messages_add_top_header_element'); ?>
			<?php if( isset( $_GET["wpc_search"] ) && $_GET["wpc_search"] !== '' ) :; ?>
			<?php  if(count(array_filter( $expl ))>0){?><div class="wpc-count-res"><?php
				echo str_replace('[number]', count(array_filter( $expl )), $this->translate(8)); ?></div>
			<?php } endif; ?>
		</div>
		<?php echo apply_filters('_wpc_messages_top_header', ob_get_clean()); ?>
		
		<div class="wpchats-container wpchats-index">
		<?php
		$arCount = count(array_filter( $expl ));
		$res_per_pg = '7';
		$total_pg_e = explode( '.', $arCount / $res_per_pg );
		$total 		= ( count( $total_pg_e ) > 1 ) ? abs( $total_pg_e[0] + 1 ) : $total_pg_e[0];
		$pg 		= ( isset( $_GET["pg"] ) && is_numeric( $_GET["pg"] ) && $_GET["pg"] > 0 ) ? $_GET["pg"] : '1';
		$pg 		= ( $pg > $total ) ? $total : $pg;
		$prev 		= ( $pg !== '' && $pg > 1 ) ? abs( $pg - 1 ) : '';
		$cur 		= ( $pg !== '' && is_numeric( $pg ) ) ? $pg : '';
		$nxt 		= $pg == 0 ? 2 : abs( $pg + 1 );
		foreach ( array_slice( array_unique(array_filter( $expl )), ( $pg * $res_per_pg ) - $res_per_pg, $res_per_pg ) as $id ) {
	     	$query = $wpdb->get_results( "SELECT * FROM $table WHERE `id` = $id LIMIT 1" );
			foreach ( $query as $row ) {
				$reply = get_template_directory_uri()."/img/reply.png";
				$unreadCount = $wpdb->get_results( "SELECT * FROM $table WHERE `chat_id` = '$row->chat_id' AND `to` = '$current_user_id' AND `status` = 'unread'" );
				$pm_status_msg = ( $row->to == $current_user_id ) ? "" : "<img class='reply_icon' src=".$reply." />";
				$pm_type_msg = ( $row->status == "read" ) ? "seen" : "unseen";
				$pm_classes = ( $row->to == $current_user_id ) ? "received-" : "sent-";
				$pm_classes .= ( $row->status == "read" ) ? "read" : "unread";
				$contact = ( $current_user_id == $row->from ) ? $row->to : $row->from;
				$dataQ = ( isset( $_GET["wpc_search"] ) && $_GET["wpc_search"] !== '' ) ? ' data-q="'.esc_attr($_GET["wpc_search"]).'"' : ' data-q=""';
    		?>
		<div id="pm-<?php echo $row->chat_id; ?>" data-pm="<?php echo $row->chat_id; ?>" class="pm-cont <?php echo $pm_classes; ?> srvrldd" data-last="<?php echo $row->id; ?>" <?php echo $dataQ; ?> onclick="window.location.href='?conversation=<?php echo $row->chat_id; ?><?php echo (isset($_GET["wpc_search"]) && $_GET["wpc_search"] !== '') ? '&wpc_search='.esc_attr($_GET["wpc_search"]) : ''; ?>';" title="<?php echo $this->translate(54); ?>">
			<table width="100%" class="msg_full"><tr>
				<td valign="top" width="55px"><?php echo get_avatar( $contact, 50 ); ?></td>
				<td valign="middle" width="auto">
					<div class="wpcright"><span><a href="?conversation=<?php echo $row->chat_id; ?>" title="<?php echo get_userdata( $contact )->user_nicename; ?>"><?php echo get_userdata( $contact )->display_name; ?><?php if(count($unreadCount)>0): ;?> (<?php echo count($unreadCount); ?>) <?php endif; ?></a></span> <?php echo $this->online_status( $contact ); ?></div>
					<div class="wpc-pm-index-right">
			     		<div class="from_ico msg_body" title="<?php echo $pm_classes; ?>">
						    <?php echo $pm_status_msg; ?>
							<?php echo $this->output_emoji( substr( stripslashes($row->body), 0, 100) ) . "&nbsp;"; echo ( strlen($row->body) > 100 ) ? "... " : ''; ?>
		    		    </div>
					<div class="time"><?php echo str_replace('[time]', $this->time_difference( date("Y-m-d H:i:s", $row->time), date("Y-m-d H:i:s", time()), '' ), $this->translate(214)); ?><?php if ($row->status == "read" && $row->from == $current_user_id){ ?><span aria-hidden="true"> · </span><?php echo $pm_type_msg; } ?></div>
					</div>
				</td>
			</tr></table>
		</div>
		<?php }
		}
		$total_res = count(array_unique(array_filter( $expl )));
		if( $total_res == 0 ) {
			$warn = get_template_directory_uri()."/img/warn.png";
			echo '<div class="wpc-index-0">';
			if( isset( $_GET["wpc_search"] ) ) {
				echo '<center><p><img src="'.$warn.'"/> '.$this->translate(241).'.</p></center>';
			} else {
				if( isset($_GET["filter"]) ) {
					echo '<center><p><img src="'.$warn.'"/> '.$this->translate(20).'.</p></center>';
				} else {
					echo '<center><p><img src="'.$warn.'"/> '.$this->translate(21).' .</p></center>';
				}
			}
			echo '</div>';
		}
		echo "</div>";
		
		if( $pg <= $total && $total > 1 ) {
			$amp 	= '';
			$extra 	= '';
			if( isset( $_GET["filter"] ) || isset( $_GET["wpc_search"] ) ) {
				$param = ( isset( $_GET["filter"] ) ) ? '?filter='.$_GET["filter"] : '?wpc_search='.$_GET["wpc_search"];
				$extra = ( isset( $_GET["filter"] ) ) ? 'data-todo="filter" data-content="' . $_GET["filter"] . '"' : 'data-todo="search" data-content="' . $_GET["wpc_search"] . '"';
				$amp .= $param .'&pg=';
			} else {
				$extra = 'data-todo="none" data-content="none"';
				$amp .= '?pg=';
			}
			echo '<div class="wpc-pagination" data-paginate="wpchats">';
			echo ( $prev ) ? "<a href=\"$amp$prev\" class=\"wpc-prev wpc-tooltip\" data-target=\"$prev\"$extra>&laquo; ". $this->translate(23) ."</a>" : '';
			echo "<span>".$this->translate(158)." $cur of $total</span>";
			echo ( $nxt <= $total ) ? "<a href=\"$amp$nxt\" class=\"wpc-next wpc-tooltip\" data-target=\"$nxt\"$extra>". $this->translate(24) ." &raquo;</a>" : '';
			echo '</div>';
		} ?>
		
		<div><h3 id="search_section"><?php _e('Search for message'); ?></h3>
	    <?php global $wpdb; $options1 = get_option('wpc_pages');  $url = $options1["users"]; $url2 = $options1["messaging"];?>
		<form action="<?php echo $url2; ?>" method="get" id="wpc_msg_search">
	       	<div class="msg_src">
       	 	<table class="ch" width="100%"><tbody><tr>
     		    <td width="20px" class="n ci cj"><label for="u_0_0"><img src="<?php echo get_template_directory_uri(); ?>/img/people.png" class="s" height="20" width="20"></label></td>
       			<td class="t cl cj"><input style="width: 100%;" maxlength="15" type="text" name="wpc_search" title="Search" value="Search…" onfocus="if (this.value == '<?php _e( 'Search…' ) ?>') {this.value = '';}" onblur="if (this.value == '') {this.value = '<?php _e( 'Search…' ) ?>';}" class="wpc_msg_search_s"/></td>
	      		<td class="n cn cj"><input style="margin-left:5px;float:right;" class="search_submit" value="Search" type="Submit"></td>
       		</tr></tbody></table>
	       	</div>
		</form>
		</div>
		
		<div><h3 id="section"><?php _e('More Options'); ?></h3>
       		<?php global $wpdb; $options1 = get_option('wpc_pages');  $url = $options1["users"]; $url2 = $options1["messaging"];?>
			<div class="cp"><a href="<?php echo $url2 .'?filter=online' ?>"><?php echo $this->translate(4); ?></a></div>
			<div class="cp"><a href="<?php echo $url2 .'?filter=unread' ?>"><?php echo $this->translate(5); ?></a></div>
			<?php echo (isset($_GET["filter"]) || isset($_GET["wpc_search"])) ? '<div class="cp"><a href="">'.$this->translate(17).'</a></div>' : ''; ?>
		</div>
		
		<script type="text/javascript">
			function filterMessages() {
			    var filter  = document.getElementById("wpc-filter-msg").value;
			    if( filter !== '0' ) {
			    	if(filter == 'clear')
			    		window.location.href = "<?php echo $this->get_settings('messages_page'); ?>";
			    	else
			    		window.location.href = "<?php echo $this->get_settings('messages_page'); ?>?filter="+filter;
				}
			}
		</script>
		<?php
		echo ob_get_clean();
	}
	/**
	 * returns a conversation ID of 10 digits, for chats between current user and their recipient
	 * @param int $current_user current user ID
	 * @param int $recipient recipient (contact) user ID
	 * @return chat ID from database if found, else random 10 digits
	*/
	public function get_conversation_id( $current_user, $recipient ) {
		global $wpdb;
		$table = $wpdb->prefix . "mychats";
		$query_id = $wpdb->get_results( "SELECT `chat_id` FROM $table WHERE `to` = '$recipient' AND `from` = '$current_user' OR `from` = '$recipient' AND `to` = '$current_user' LIMIT 1" );
		$count = count( $query_id );
		if ( $count == 0 ) {
			return rand("1000000000","9999999999");
		} else {
			foreach ( $query_id as $id )
				return esc_attr( $id->chat_id );
		}
	}
	/**
	 * there's a drop down select in single conversations for conversation actions. this function takes those actions
	 * @param string $action action name
	 * @param int $pm chat ID
	 * @return no return, redirects on both success and failure with user notices.
	*/
	public function single_actions( $action, $pm ) {
		
		global $wpdb;
		global $current_user;
		$current_user_id = $current_user->ID;
		$table = $wpdb->prefix . "mychats";
		$last_msg;
		if ( ! $pm || ! $action )
			exit;
		if ( $action == "mark_unread" ) {
			$last = $wpdb->get_results( "SELECT `id` FROM $table WHERE `chat_id` = '$pm' AND FIND_IN_SET('$current_user_id', `deleted`) = 0 ORDER BY `id` DESC LIMIT 1" );
			foreach ( $last as $msg )
				$last_msg = $msg->id;
			$wpdb->update( 
				$table, 
				array( 
					'status' => 'unread',
					'seen'   => null
				),
				array(
					'chat_id' => $pm,
					'to'      => $current_user->ID,
					'status'  => 'read',
					'id'      => $last_msg
				)
			);
			wp_redirect( $this->get_settings( "messages_page" ) . '?scs=2' );
			exit;
		}
		if ( $action == "delete_conversation" ) {
			global $wpdb;
			global $current_user;
			$table = $wpdb->prefix . "mychats";
			$meta = $this->get_message_parts( $pm, 'deleted' );
			$messages = $wpdb->get_results( "SELECT `id` FROM $table WHERE `chat_id` = '$pm' AND FIND_IN_SET('$current_user_id', `deleted`) = 0 ORDER BY `id` DESC" );
			$id = '';
			foreach( $messages as $m ) {
				$id 	= $m->id;
				$meta 	= $this->get_message_parts( $id, 'deleted' );
				$val 	= ( strlen( $meta ) > 0 ) ? $meta . ','. $current_user->ID : $current_user->ID;
				$sql 	= "UPDATE $table SET `deleted` = '$val' WHERE `id` = '$id' LIMIT 1";
				require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
				dbDelta( $sql );
			}
			if( ! isset( $_GET["rdr"] ) ) {
				wp_redirect( $this->get_settings( "messages_page" ) . '?scs=3' );
				exit;
			}
		}
		if ( $action == "pm_delete" ) {
			global $wpdb;
			global $current_user;
			$table = $wpdb->prefix . "mychats";
			$meta = $this->get_message_parts( $pm, 'deleted' );
			if( ! in_array( $current_user->ID, explode(',', $meta) ) ) {
				$val = ( strlen( $meta ) > 0 ) ? $meta . ','. $current_user->ID : $current_user->ID;
				$sql = "UPDATE $table SET `deleted` = '$val' WHERE `id` = '$pm' LIMIT 1";
				require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
				dbDelta( $sql );
			}
			wp_redirect( $this->get_settings( "messages_page" ) . '?conversation=' . $this->get_message_parts( $pm, 'chat_id' ) . '&scs=1' );
			exit;
		}
	}
	/**
	 * Gets message meta from the last insert within conversation.
	 * @param int $chat_id conversation ID
	 * @param string $q query
	*/
	public function get_conversation( $chat_id, $q ) {
		global $wpdb;
		global $current_user;
		$current_user_id = $current_user->ID;
		$table 		= $wpdb->prefix . "mychats";
		$query 		= $wpdb->get_results( "SELECT * FROM $table WHERE `chat_id` = '$chat_id' LIMIT 1" );
		$id 		= '';
		$chat_id 	= '';
		$to 		= '';
		$from 		= '';
		$body 		= '';
		$time 		= '';
		$seen 		= '';
		$status 	= '';
		$deleted 	= '';
		$contact 	= '';
		foreach ( $query as $pm ) {
				$id 		= esc_attr( $pm->id );
				$chat_id 	= esc_attr( $pm->chat_id );
				$to 		= esc_attr( $pm->to );
				$from 		= esc_attr( $pm->from );
				$body 		= esc_attr( $pm->body );
				$time 		= esc_attr( $pm->time );
				$seen 		= esc_attr( $pm->seen );
				$status 	= esc_attr( $pm->status );
				$deleted 	= esc_attr( $pm->deleted );
				$contact 	= ( $current_user_id == $pm->from ) ? $pm->to : $pm->from;
		}
		if ( $q == 'id' ) return $id;
		if ( $q == 'chat_id' ) return $chat_id;
		if ( $q == 'to' ) return $to;
		if ( $q == 'from' ) return $from;
		if ( $q == 'body' ) return $body;
		if ( $q == 'time' ) return $time;
		if ( $q == 'seen' ) return $seen;
		if ( $q == 'status' ) return $status;
		if ( $q == 'deleted' ) return $deleted;
		if ( $q == 'contact' ) return esc_attr( $contact );
		if ( $q == 'last_from' ) {
			$query = $wpdb->get_results( "SELECT `from` FROM $table WHERE `chat_id` = '$chat_id' AND FIND_IN_SET('$current_user_id', `deleted`) = 0 ORDER BY `id` DESC LIMIT 1" );
			foreach ( $query as $pm )
				return $pm->from;
		}
		if ( $q == 'last' ) {
			$query = $wpdb->get_results( "SELECT `id` FROM $table WHERE `chat_id` = '$chat_id' AND FIND_IN_SET('$current_user_id', `deleted`) = 0 ORDER BY `id` DESC LIMIT 1" );
			foreach ( $query as $pm )
				return $pm->id;
		}
	}
	/**
	 * Gets message parts
	 * @param int $mid message ID
	 * @param string $parts queried part
	*/
	public function get_message_parts( $mid, $parts ) {
		global $wpdb;
		$table 		= $wpdb->prefix . "mychats";
		$query 		= $wpdb->get_results( "SELECT * FROM $table WHERE `id` = '$mid' LIMIT 1" );
		$id 		= '';
		$chat_id 	= '';
		$to 		= '';
		$from 		= '';
		$body 		= '';
		$time 		= '';
		$seen 		= '';
		$status 	= '';
		$deleted 	= '';
		foreach ( $query as $pm ) {
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
		if ( $parts == 'id' ) return $id;
		if ( $parts == 'chat_id' ) return $chat_id;
		if ( $parts == 'to' ) return $to;
		if ( $parts == 'from' ) return $from;
		if ( $parts == 'body' ) return $body;
		if ( $parts == 'time' ) return $time;
		if ( $parts == 'seen' ) return $seen;
		if ( $parts == 'status' ) return $status;
		if ( $parts == 'deleted' ) return $deleted;
	}
	/**
 	 * Returns conversation form for a conversation that is between current user and the provided recipient
 	 * @param int $recipient recipient user ID
	*/
	public function get_conversation_form( $recipient ) {
		if ( ! get_userdata( $recipient )->ID ) {
			return $this->translate(25);
			return;
		}
		global $current_user;
		$wpc = new wpc;	
		if( 
			   $this->is_blocked( $recipient, 'by' )
			|| $this->is_blocked( $recipient, '' )
			|| $wpc->is_user('banned', $recipient)
			|| $wpc->is_user('banned', $current_user->ID)
			|| $this->user_preferences($recipient, 'not_avail')
		)
		{
			echo $this->load_input($_GET["conversation"], true);

			?>
				<!--<div class="wpc-form wpc-locked">
					<p><i class="wpcico-attention"></i> Sorry, you can't contact <?php echo get_userdata( $recipient )->display_name; ?> right now.</p>
				</div>-->
			<?php
		} else {
			$pm = esc_attr( $_GET["conversation"] );
			$auto_save = get_option('wpc_autosave_' . $pm . '_' . $current_user->ID);
			$path = get_template_directory_uri() . '/info/inc/img/emoji/';
			echo $this->load_input($pm, false);
		}
	}
	/**
	 * Marks messages within conversation seen if $pm is set, else if $id is set then, marks single message seen
	 * @param int $pm conversation ID
	 * @param int $id single message ID
	 * @return false
	*/
	public function mark_seen( $pm, $id ) {
		global $wpdb;
		global $current_user;
		$table = $wpdb->prefix . "mychats";
		if( $pm ) {
			$wpdb->update( 
				$table, 
				array( 
					'status' => 'read',
					'seen'   => time()
				),
				array(
					'chat_id' => $pm,
					'to'      => $current_user->ID,
					'status'  => 'unread'
				)
			);
		}
		if( $id ) {
			$wpdb->update( 
				$table, 
				array( 
					'status' => 'read',
					'seen'   => time()
				),
				array(
					'id' => $id
				)
			);
		}
	}
	/**
	 * function returning difference between 2 dates
	 * @param string $then time 1
	 * @param string $now time now
	 * @param string $after text after time difference
	*/
	public function time_difference( $then, $now, $after ) {
		if( !isset( $then ) ) return false;
		$then = new DateTime($then);
		$now = new DateTime($now);
		$delta = $now->diff($then);
		$quantities = array(
		    'year' => $delta->y,
		    'month' => $delta->m,
		    'day' => $delta->d,
		    'hour' => $delta->h,
		    'minute' => $delta->i,
		    'second' => $delta->s
		    );
		$str = '';
		foreach($quantities as $unit => $value) {
		    if($value == 0) continue;
		    $str .= $value . ' ' . $unit;
		    if($value != 1) {
		        $str .= 's';
		    }
		    $str .=  ', ';
		    break;
		}
		$str = $str == '' ? $this->translate(213) : substr($str, 0, -2) . $after;
		return $this->translate_quantities($str);

	}
	/**
	 * Returns 'Just now' instead of time difference that are less than 1 minute (in seconds)
	 * @param string $str time difference string
	*/
	public function just_now( $str ) {
		return is_numeric(strpos($str, 'second')) ? $this->translate(213) : $str;
	}
	/**
	 * Gets admin settings
	 * @param string $op option
	*/
	public function get_settings( $op ) {
		$op_pg = esc_attr( get_option('wpc_pages') );
		$op_pg_exp = explode(",", esc_attr( get_option('wpc_pages') ));
		if ( $op == "messages_page" ) return get_permalink( $op_pg_exp[0] );
		if ( $op == "profile_page" ) return get_permalink( $op_pg_exp[1] );
		if( $op == 'messages_pagination' ) {
			$option = esc_attr(get_option('wpc_s_3'));
			return is_numeric($option) && $option > 0 ? $option : 15;
		}
		if( $op == 'users_pagination' ) {
			$option = esc_attr(get_option('wpc_s_4'));
			return is_numeric($option) && $option > 0 ? $option : 20;
		}
		if( $op == 'messages_per_page' ) {
			$option = esc_attr(get_option('wpc_s_9'));
			return is_numeric($option) && $option > 0 ? $option : 25;
		}
		if( $op == 'mod_can_ban') {
			return get_option('wpc_s_5') == 'on' || get_option('wpc_s_5') !== '' && get_option('wpc_s_5') !== 'on' ? true : false;
		}
		if( $op == 'user_can_delete_reports') {
			return false;
		}
		if( $op == 'user_can_update_reports') {
			return false;
		}
		if( $op == 'mod_can_view_chats') {
			return get_option('wpc_s_8') && get_option('wpc_s_8') == 'on' ? true : false;
		}
		if( $op == 'mod_notif_ins_body' ) {
			return get_option('wpc_s_15') !== '' && strlen(get_option('wpc_s_15')) > 10 ? get_option('wpc_s_15') : "Hi [moderator],\n\nOne or more messages have been reported to moderation:\n\n[reported-message-details]\n\nPlease navigate to your moderation panel for further information and actions:\n[mod-panel]\n\nThank you!\n\nYou're getting this email because you are a moderator at [site-name] and you have chosen to receive [mod-notification-setting] updates about reported messages.";
		}
		if( $op == 'mod_notif_ins_subject' ) {
			return get_option('wpc_s_14') !== '' && strlen(get_option('wpc_s_14')) > 3 ? get_option('wpc_s_14') : "[[site-name]] [reported-count] new reported message(s)";
		}
		if( $op == 'new_mod_notif_subject' ) {
			return get_option('wpc_s_16') !== '' && strlen(get_option('wpc_s_16')) > 3 ? get_option('wpc_s_16') : "You have been made a moderator at [site-name]";
		}
		if( $op == 'new_mod_notif_body' ) {
			return get_option('wpc_s_17') !== '' && strlen(get_option('wpc_s_17')) > 10 ? get_option('wpc_s_17') : "Hi [moderator],\n\nCongratulations!!\nYou have just been made a moderator at [site-name]!\n\nHere's your moderation panel: [mod-panel]\nEdit your moderation settings: [settings-link]\n\nThank you!";			
		}
		if( $op == 'mail_headers_from_name' ) {
			return get_option('wpc_s_12') !== '' && strlen(get_option('wpc_s_12')) > 2  ? esc_attr(get_option('wpc_s_12')) : esc_attr(get_bloginfo('name'));
		}
		if( $op == 'mail_headers_from' ) {
			return get_option('wpc_s_13') !== '' && is_numeric( strpos(get_option('wpc_s_13'), '@') ) ? get_option('wpc_s_13') : 'wordpress@'.strtolower( $_SERVER['SERVER_NAME'] );
		}
		if( $op == 'beep' ) {
			return get_option('wpc_s_18') !== '' && is_numeric( strpos(get_option('wpc_s_18'), 'http') ) ? get_option('wpc_s_18') : get_template_directory_uri() . '/info/inc/mp3/beep.mp3';			
		}
		if( $op == 'new_message_text' ) {
			return get_option('wpc_s_19') !== '' && strlen(get_option('wpc_s_19')) > 2 ? get_option('wpc_s_19') : '**** New Message ****';
		}
		if( $op == 'new_msg_notif_subject' ) {
   			return get_option('wpc_s_11') !== '' && strlen(get_option('wpc_s_11')) > 10  ? get_option('wpc_s_11') : "[[site-name]] New message from [sender]";
		}
   		if( $op == 'new_msg_notif_body' ) {
			return get_option('wpc_s_10') !== '' && strlen(get_option('wpc_s_10')) > 10  ? get_option('wpc_s_10') : "Hi [recipient],\n\n[sender] has sent you a new message on [site-name]:\n\n\"[message]\"\n\nRead this message: [message-link]\nEdit settings: [settings-link]";
   		}
   		if( $op == 'banned_words' ) {
			return get_option('wpc_s_22') !== '' && strlen(get_option('wpc_s_22')) > 0 ?  array_filter( explode(',', get_option('wpc_s_22')) ) : false;
		}
		if( $op == 'custom_css' ) {
			$ecs = get_option('wpc_admin_emoji_css');
			$ecs = $ecs && $ecs !== '' ? $ecs : ".wpc-admin-emoji {height: auto!important;width: auto!important;max-width: 300px!important;border-radius: 0!important;}";
			$css = "/**\n * WpChats CSS\n * Loads font icons, custom CSS, and tooltips\n */\n";
			$css .= '@import url(\''. get_template_directory_uri() . '/info/inc/icons/fontello/css/wpchats.css\');'.get_option('wpc_s_23') . $ecs;
			return $css;
		}
		if( $op == 'can_go_offline') {
			return get_option('wpc_s_24') && get_option('wpc_s_24') == 'on' ? true : false;
		}
		if( $op == 'rtl') {
			return get_option('wpc_s_25') && get_option('wpc_s_25') == 'on' ? true : false;			
		}
		if( $op == 'translation') {
			return get_option('wpc_s_26') && get_option('wpc_s_26') == 'on' ? true : false;
		}
		if( $op == 'bbp_user_base' ) {
			$base = home_url('/') . 'forums/users/';
			return get_option('wpc_s_27') !== '' && is_numeric(strpos(get_option('wpc_s_27'), 'http')) ? get_option('wpc_s_27') : $base;
		}
		if( $op == 'bp_user_base' ) {
			$base = home_url('/') . 'members/';
			return get_option('wpc_s_28') !== '' && is_numeric(strpos(get_option('wpc_s_28'), 'http')) ? get_option('wpc_s_28') : $base;
		}
		if( $op == 'redirect_profile_to' ) {
			return get_option('wpc_s_29') && get_option('wpc_s_29') !== '' ? get_option('wpc_s_29') : false;			
		}
		if( $op == 'add_after_bbp_auth_details' ) {
			return !get_option('wpc_s_30') && get_option('wpc_s_30') !== '' || get_option('wpc_s_30') == 'on' ? true : false;
		}
	}
	/**
	 * Retrieves user information as submitted throughout their edit profile pages
	 * @param int $user user ID
	 * @param string $op info to retrieve
	*/
	public function user_info( $user, $op ) {
		if( !get_userdata($user) )
			return; // user does not exist.
		if( $op == 'bio') {
			$wpc = new wpc;	
			$meta 	= get_user_meta($user, 'wpc_bio', true);
			$val = current_user_can('manage_options') ? html_entity_decode($meta) : strip_tags( html_entity_decode($meta) );
			return $meta !== '' ? nl2br($val) : false;
		}
		if( $op == 'social_tw') {
			$meta = get_user_meta($user, 'wpc_social_tw', true);
			return $meta !== '' ? esc_attr($meta) : false;
		}
		if( $op == 'social_fb') {
			$meta = get_user_meta($user, 'wpc_social_fb', true);
			return $meta !== '' ? esc_attr($meta) : false;
		}
		if( $op == 'social_yt') {
			$meta = get_user_meta($user, 'wpc_social_yt', true);
			return $meta !== '' ? esc_attr($meta) : false;
		}
		if( $op == 'social_gp') {
			$meta = get_user_meta($user, 'wpc_social_gp', true);
			return $meta !== '' ? esc_attr($meta) : false;
		}
		if( $op == 'social_in') {
			$meta = get_user_meta($user, 'wpc_social_in', true);
			return $meta !== '' ? esc_attr($meta) : false;
		}
		if( $op == 'social_st') {
			$meta = get_user_meta($user, 'wpc_social_st', true);
			return $meta !== '' ? esc_attr($meta) : false;
		}
	}
	/**
	 * Returns user preferences
	 * @param int $user user ID
	 * @param string $op option
	*/
	public function user_preferences($user,$op) {
		if( $op == 'msg_notif' ) {
			$meta = get_user_meta($user, 'wpc_notify_me', true);
			return $meta == '0' ? false : true;
		}
		if( $op == 'go_offline' ) {
			$meta = get_user_meta($user, 'wpc_go_offline', true);
			if( get_userdata($user) && in_array('administrator', get_userdata($user)->roles ) ) { // admin users
				return $meta == '1' ? true : false;
			} else { // non admin users
				return $meta == '1' && $this->get_settings('can_go_offline') ? true : false;
			}
		}
		if( $op == 'not_avail' ) {
			$meta = get_user_meta($user, 'wpc_not_avail', true);
			return $meta !== '' ? true : false;
		}
		if( $op == 'beep' ) {
			$meta = get_user_meta($user, 'wpc_chat_sound', true);
			return $meta !== '0' ? true : false;
		}
		if( $op == 'email' ) {
			$meta = get_user_meta($user, 'wpc_user_email', true);
			return $meta !== '' && is_numeric( strpos($meta,'@') ) ? $meta : get_userdata($user)->user_email;
		}
		if( $op == 'mod_notif' ) {
			$meta = get_user_meta($user, 'wpc_mod_notif', true);
			if( $meta == '1' || $meta == '' || ! $meta )
				return 'instantly';
			if( $meta == '2' )
				return 'daily';
			if( $meta == '0' )
				return false;
		}
	}
	/**
	 * Outputs notices for current user, success and failure notices for options and actions..
	 * @param string $scs a unique number to to recognize which notice to output
	*/
	public function notices( $scs ) {
		global $current_user;
		if( ! isset( $scs ) || ! in_array( $scs, array(1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21) ) )
			return;
		$notice = false;
		$class 	= '';
		if( $scs == '1' ) {
			$notice = $this->translate(26) . ".";
			$class = " wpc_scs";
		}
		if( $scs == '2' ) {
			$notice = $this->translate(27) . ".";
			$class = " wpc_scs";
		}
		if( $scs == '3' ) {
			$notice = $this->translate(28) . ".";
			$class = " wpc_scs";
		}
		if( $scs == '4' ) {
			$notice = $this->translate(29) . ".";
			$class = " wpc_fail";
		}
		if( $scs == '5' ) {
			$notice = $this->translate(30) . ".";
			$class = " wpc_fail";
		}
		if( $scs == '6' ) {
			$notice = $this->translate(31) . ".";
			$class = " wpc_fail";
		}
		if( $scs == '7' ) {
			$notice = $this->translate(32) . ".";
			$class = " wpc_fail";
		}
		if( $scs == '8' ) {
			$notice = $this->translate(33) . ".";
			$class = " wpc_scs";
		}
		if( $scs == '9' ) {
			$notice = $this->translate(34) . ".";
			$class = " wpc_scs";
		}
		if( $scs == '10' ) {
			$notice = $this->translate(35) . ".";
			$class = " wpc_fail";
		}
		if( $scs == '11' ) {
			$notice = $this->translate(36) . ".";
			$class = " wpc_scs";
		}
		if( $scs == '12' ) {
			$notice = $this->translate(37) . ".";
			$class = " wpc_fail";
		}
		if( $scs == '13' ) {
			$notice = $this->translate(38) . ".";
			$class = " wpc_scs";
		}
		if( $scs == '14' ) {
			$notice = $this->translate(39) . ".";
			$class = " wpc_scs";
		}
		if( $scs == '15' ) {
			$notice = $this->translate(40) . ".";
			$class = " wpc_fail";
		}
		if( $scs == '16' ) {
			$notice = $this->translate(41) . ".";
			$class = " wpc_fail";
		}
		if( $scs == '17' ) {
			$notice = $this->translate(42) . "";
			$class = " wpc_scs";
		}
		if( $scs == '18' ) {
			$notice = $this->translate(43) . ".";
			$class = " wpc_scs";
		}
		if( $scs == '19' ) {
			$notice = $this->translate(44) . ".";
			$class = " wpc_fail";
		}
		if(  $scs == '20' ) {
			$notice = $this->translate(45) . ".";
			$class = " wpc_scs";			
		}
		if(  $scs == '21' ) {
			$notice = $this->translate(46) . ".";
			$class = " wpc_scs";			
		}
	}
	/**
	 * If both dates withing paramters were provided, this function returns an online status offline or online
	 * @param string $then date and time 1
	 * @param string $now date and time now
	*/
	function online_diff( $then, $now ) {
		if(!isset($then)) return false;
		$then = new DateTime($then);
		$now = new DateTime($now);
		$delta = $now->diff($then);
		$quantities = array(
		    'year' => $delta->y,
		    'month' => $delta->m,
		    'day' => $delta->d,
		    'hour' => $delta->h,
		    'minute' => $delta->i,
		    'second' => $delta->s
		    );
		$str = '';
		foreach($quantities as $unit => $value) {
		    if($value == 0) continue;
		    $str .= $value . ' ' . $unit;
		    if($value != 1) {
		        $str .= 's';
		    }
		    $str .=  ', ';
		    if( $unit == 'second' && $value < 15 )
		    	$str = '';
		    break;
		}
		$str = $str == '' ? 'online now' : substr($str, 0, -2);
		$ative = get_template_directory_uri()."/img/active.png";
		return $str == 'online now' ? '<span class="wpc_online"><img alt="active" title="active now" src="'. $ative .'" /></span>' : '';
	}
	
	function online_daff( $then, $now ) {
		if(!isset($then)) return false;
		$then = new DateTime($then);
		$now = new DateTime($now);
		$delta = $now->diff($then);
		$quantities = array(
		    'year' => $delta->y,
		    'month' => $delta->m,
		    'day' => $delta->d,
		    'hour' => $delta->h,
		    'minute' => $delta->i,
		    'second' => $delta->s
		    );
		$str = '';
		foreach($quantities as $unit => $value) {
		    if($value == 0) continue;
		    $str .= $value . ' ' . $unit;
		    if($value != 1) {
		        $str .= 's';
		    }
		    $str .=  ', ';
		    if( $unit == 'second' && $value < 15 )
		    	$str = '';
		    break;
		}
		$str = $str == '' ? 'online now' : substr($str, 0, -2);
		return $str == 'online now' ? '<span class="wpc_online wpcico-ok-circled">'. $this->translate(216) .'</span>' : '<span class="wpc_offline wpcico-ok-circled">' . str_replace('[time]', $this->translate_quantities($str), $this->translate(215)) . '</span>';
	}
	/**
	 * Translates time differences quantities (e.g years, seconds) into the user selected language
	 * @param string $string time difference string
	 * @return string translated time difference
	 */
	public function translate_quantities($string) {
		return str_replace(
			array( 'years', 'year', 'months', 'month', 'days', 'day', 'hours', 'hour', 'minutes', 'minute', 'seconds', 'second'),
			array( $this->translate(201), $this->translate(202), $this->translate(203), $this->translate(204), $this->translate(205), $this->translate(206), $this->translate(207), $this->translate(208), $this->translate(209), $this->translate(210), $this->translate(211), $this->translate(212) ),
			$string
		);
	}
	/**
	 * Ouputs online status for provided user IF their last seen meta exists (user has logged-in at least once when this plugin is active)
	 * @param int $user_id provided user ID
	*/
	public function online_status( $user_id ) {
		$meta = get_user_meta($user_id, 'wpc_last_seen', TRUE);
		if( ! $meta ) {
			echo '<span class="wpc_offline wpcico-ok-circled">'. $this->translate(48) .'</span>';
			return;
		}
		echo $this->online_diff( date("Y-m-d H:i:s", $meta), date("Y-m-d H:i:s", time()) );
	}
	
	public function online_status_rec( $user_id ) {
		$meta = get_user_meta($user_id, 'wpc_last_seen', TRUE);
		if( ! $meta ) {
			echo '<span class="wpc_offline wpcico-ok-circled">'. $this->translate(48) .'</span>';
			return;
		}
		echo $this->online_daff( date("Y-m-d H:i:s", $meta), date("Y-m-d H:i:s", time()) );
	}
	/**
	 * Generates a new conversation for current user and recipient
	 * @param int $recipient recipient user ID
	*/
	public function new_conversation( $recipient ) {
		global $wpdb;
		global $current_user;
		$table = $wpdb->prefix."mychats";
		$rand = rand("1000000000","9999999999");
		$wpdb->insert( 
			$table, 
			array( 
				'chat_id' => $rand, 
				'from'    => $current_user->ID,
				'to'      => $recipient,
				'body'    => '',
				'time'    => time(),
				'deleted' => $recipient
			)
		);
		$val = $current_user->ID . ',' . $recipient;
		$insert = $wpdb->insert_id;
		$sql = "UPDATE $table SET `deleted` = '$val' WHERE `chat_id` = '$rand' AND `id` = '$insert' LIMIT 1";
		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		dbDelta( $sql );
		if ( is_numeric( $insert ) ) {
			wp_redirect( $this->get_settings( "messages_page" ) . '?conversation=' . $rand );
			exit;
		}
	}
	/**
	 * Blocks user that current users chooses to block
	 * @param int $user user ID to block
	 * @param string $rdr option where to redirect after
	*/
	public function block_user( $user, $rdr ) {
		global $current_user;
		$meta = get_user_meta( $current_user->ID, 'wpc_blocked', TRUE );
		if( in_array( $user, array_filter( explode(',', $meta) ) ) ) { // blocked already
			return;
		}
		$val = ( ! $meta || $meta == '' ) ? $user : $meta . ','.  $user;
		$clean_val = '';
		$array = array_filter( explode(',', $val) );
		foreach( $array as $id ) {
			$clean_val .= $id && $id !== '' ? $id : '';
			$clean_val .= $id !== end( $array ) ? ',' : '';
		}
		update_user_meta( $current_user->ID, 'wpc_blocked', $clean_val );
		if( $rdr !== '' ) {
			if ( $rdr == 'messages' ) {
				if ( isset( $_GET["pm"] ) && is_numeric( $this->get_conversation( $_GET["pm"], 'chat_id' ) ) ) {
					wp_redirect( $this->get_settings( "messages_page" ) . '?conversation=' . $_GET["pm"] .'&scs=9' );
					exit;
				} else {
					wp_redirect( $this->get_settings( "messages_page" ) . '?scs=9' );
					exit;
				}
			}
			if ( $rdr == 'profile' ) {
				if ( isset( $_GET["user"] ) && get_userdata( $_GET["user"] )->ID ) {
					wp_redirect( $this->user_links('link', $_GET["user"], '') . '&scs=9' );
					exit;
				}
			}
			if ( $rdr == 'users' ) {
				wp_redirect( $this->get_settings( "profile_page" ) . '?scs=9' );
				exit;
			}
			if( strlen($rdr) > 15 ) {
				wp_redirect( $rdr.'?scs=9' );
				exit;
			}
		} else {
			if( $rdr !== '0' ) {
				wp_redirect( $this->user_links('link', $user, '') . '&scs=9' );
				exit;
			}				
		}
	} 
	/**
	 * Unblocks user that current users chooses to unblock
	 * @param int $user user ID to unblock
	 * @param string $rdr option where to redirect after
	*/
	public function unblock_user( $user, $rdr ) {
		global $current_user;
		$meta = get_user_meta( $current_user->ID, 'wpc_blocked', TRUE );
		$array = array_filter( explode(',', $meta) );
		if( in_array( $user, $array ) ) { // blocked already
			$val = '';
			foreach( $array as $id ) {
				$val .= $id && $id != $user && $id !== '' ? $id : '';
				$val .= $id !== end( $array ) ? ',' : '';
			}
			if( $val !== '' )
				update_user_meta( $current_user->ID, 'wpc_blocked', $val );
			else
				delete_user_meta( $current_user->ID, 'wpc_blocked' );
			if( $rdr !== '' ) {
				if ( $rdr == 'messages' ) {
					if ( isset( $_GET["pm"] ) && is_numeric( $this->get_conversation( $_GET["pm"], 'chat_id' ) ) ) {
						wp_redirect( $this->get_settings( "messages_page" ) . '?conversation=' . $_GET["pm"] .'&scs=8' );
						exit;
					} else {
						wp_redirect( $this->get_settings( "messages_page" ) . '?scs=8' );
						exit;
					}
				}
				if ( $rdr == 'profile' ) {
					if ( isset( $_GET["user"] ) && get_userdata( $_GET["user"] )->ID ) {
						wp_redirect( $this->user_links('link', $_GET["user"], '') . '&scs=8' );
						exit;
					}
				}
				if ( $rdr == 'users' ) {
					wp_redirect( $this->get_settings( "profile_page" ) . '?scs=8' );
					exit;
				}
				if ( $rdr == 'edit' ) {
					wp_redirect( $this->get_settings( "profile_page" ) . '?edit=1&scs=8' );
					exit;
				}
				if( strlen($rdr) > 15 ) {
					wp_redirect( $rdr.'?scs=8' );
					exit;
				}
			} else {
				wp_redirect( $this->user_links('link', $user, '') . '&scs=8' );
				exit;				
			}
		} else { // not blocked
			return;
		}
	}
	/**
	 * Checks if a user is blocked by current user and/or if current user is blocked by this user.
	 * @param int $user user ID
	 * @param string $q additional query
	 * @return boolean true|blocked, false|not blockedx
	 */
	public function is_blocked( $user, $q ) {
		global $current_user;
		if( ! $q || $q == '' ) {
			$meta = get_user_meta( $current_user->ID, 'wpc_blocked', TRUE );
			$return = '';
			if( in_array( $user, explode(',', $meta)) )
				return true;
			else
				return false;
		} else {
			if( $q == 'by' ) {
				$meta = get_user_meta( $user, 'wpc_blocked', TRUE );
				$return = '';
				if( in_array( $current_user->ID, explode(',', $meta)) )
					return true;
				else
					return false;
			}
		}
	}
	/**
	 * Outputs links for provided user
	 * @param string $link link to output
	 * @param int $user user ID
	 * @param string $rdr redirect parameter to include in the link
	*/
	public function user_links( $link, $user, $rdr ) {
		global $current_user;
		$contact = $this->is_blocked( $user, 'by' ) || $this->is_blocked( $user, '' ) ? '' : "<a href=\"" . $this->get_settings( 'messages_page' ) . "?recipient=$user\"><i class=\"wpcico-chat-1\"></i>".$this->translate(159)."</a>";
		if( $link == 'message' && is_user_logged_in() ) return $contact;
		if( $link == 'block' && is_user_logged_in() && $current_user->ID != $user ) {			
			$return = '';
			$rdr = $rdr !== '' && in_array( $rdr, array('messages', 'profile', 'users', 'edit') ) || strlen($rdr) > 5 ? "&rdr=$rdr" : '';
			if( $this->is_blocked( $user, '' ) ) { // blocked already
				$return = "<a href=\"" . $this->get_settings( 'messages_page' ) . "?todo=unblock_user&user=$user$rdr\" title=\"".$this->translate(82)." ". get_userdata($user)->user_nicename ."\"><i class=\"wpcico-lock-open-alt\"></i>".$this->translate(82)."</a>";
			} else {
				$return = "<a href=\"" . $this->get_settings( 'messages_page' ) . "?todo=block_user&user=$user$rdr\" title=\"".$this->translate(81)." ". get_userdata($user)->user_nicename ."\"><i class=\"wpcico-block\"></i>".$this->translate(81)."</a>";
			}
			return $return;
		}
		if( $link == 'link' && get_userdata( $user ) ) {

			if( $this->get_settings('redirect_profile_to') ) {
				switch( $this->get_settings('redirect_profile_to') ) {
					case 'bbp':
					  $path = function_exists('bbpress') ? $this->get_settings('bbp_user_base') . get_userdata( $user )->user_login : false;
					break;
					case 'bp':
					  $path = function_exists('buddypress') ? $this->get_settings('bp_user_base') . get_userdata( $user )->user_login : false;
					break;
					case 'auth':
					  $path = home_url('/?author=') . $user;
					break;
				}
			}
			else
				$path = $this->get_settings( 'profile_page' ) . '?user=' . get_userdata( $user )->user_login;

			$path = $path ? $path : $this->get_settings( 'profile_page' ) . '?user=' . get_userdata( $user )->user_login;

			return apply_filters('_wpc_set_user_profile_link', $path, $user );

		}
	}
	/**
	 * Extracts the image source from user avatar code
	 * @param int $user user ID
	 * @param int $size avatar image size
	 * @return string avatar source (path to img)
	*/
	public function avatar_src( $user, $size ) {
		$xpath = new DOMXPath(@DOMDocument::loadHTML( $this->user_avatar( $user, $size ) ));
		return $xpath->evaluate("string(//img/@src)");
	}
	/**
	 * Outputs an image (avatar) for current user.
	 * If user has already chosen an image to be used as avatar (from edit profile page), this image will be used
	 * If user has not set that image, then, we will be using the avatar associated to their email provided from settings page.
	 * @param int $user user ID
	 * @param int $size avatar size height and width
	*/
	public function user_avatar( $user, $size ) {
		if( ! get_userdata( $user ) ) {
			if( is_numeric( $size ) )
				return get_avatar( $this->user_preferences( $user, 'email'), $size );
			else
				return get_avatar( $this->user_preferences( $user, 'email'), 96 );
		}
		$meta = get_user_meta($user, 'wpc_avatar', true);
		if( $meta && $meta !== '' ) 
		{
			if( is_numeric( $size ) )
				return '<img src="'.esc_attr($meta).'" class="wpc-user-avatar avatar avatar-'.$size.'" height="'.$size.'" width="'.$size.'" alt="'.get_userdata($user)->display_name.'\'s profile picture" style="height: '.$size.'px;width: '.$size.'px;" />';
			else
				return '<img src="'.esc_attr($meta).'" class="wpc-user-avatar avatar avatar-auto-size" height="96" width="96" alt="'.get_userdata($user)->display_name.'\'s profile picture" style="height: 96px;width: 96px;" />';
		}
		else
		{
			if( is_numeric( $size ) )
				return get_avatar( $this->user_preferences( $user, 'email'), $size );
			else
				return get_avatar( $this->user_preferences( $user, 'email'), 96 );
		}
	}
	/**
	 * Returns counts related to users
	 * @param string $q which count to return
	*/
	public function get_counts( $q ) {
		if( $q == 'online' ) {
			$count = 0;
			foreach ( get_users() as $user ) {
				if( $this->is_online( $user->ID ) )
					$count += 1;
			}
			return $count;
		}
		if( $q == 'blocked' ) {
			$count = 0;
			foreach ( get_users() as $user ) {
				$blocked = $this->is_blocked( $user->ID, '' );
				if( $blocked )
					$count += 1;
			}
			return $count;
		}
		if( $q == 'users' )
			return count(get_users());
		if( $q == 'unread' ) {
			global $wpdb;
			global $current_user;
			$table = $wpdb->prefix . "mychats";
			$crntusr = $current_user->ID;
			$query = $wpdb->get_results( "SELECT chat_id FROM $table WHERE status = 'unread' AND FIND_IN_SET('$crntusr', `deleted`) = 0 AND `to` = $crntusr" );
			$pms = '';
			foreach ( $query as $msg ) {
				$pms .= $msg->chat_id . ',';
			}
			return count( array_filter(array_unique( explode(',', $pms) )) );
		}

	}
	/**
	 * Query a user from blog users
	 * @param string $q search query
	 * @return array of results (users IDs)
	*/
	public function search_users( $q ) {
		global $wpdb;
		$table 	= $wpdb->prefix . "users";
		$s = esc_attr( $q );
		$query 	= $wpdb->get_results( "SELECT * FROM $table WHERE `user_login` LIKE '%$s%' OR `user_nicename` LIKE '%$s%' OR `display_name` LIKE '%$s%'" );
		$result = '';
		foreach ( $query as $user ) {
			$result .= $user->ID . ',';
		}
		return array_filter( explode(',', $result) );
	}
	/**
	 * Returns an array of users for specific query
	 * @param string $q which users to return
	 * @param string $s search query if task is search
	 * @return an array of users (IDs)
	*/
	public function get_users($q, $s) {
		if( $q == 'online' ) {
			$result = '';
			foreach ( get_users() as $user ) {

				if( $this->is_online( $user->ID ) ) {
					$result .= $user->ID . ',';
				}
			}
			return array_filter( explode(',', $result) );
		}
		if( $q == 'blocked' ) {
			$result = '';
			foreach ( get_users() as $user ) {
				if( $this->is_blocked( $user->ID, '' ) ) {
					$result .= $user->ID . ',';
				}
			}
			return array_filter( explode(',', $result) );
		}
		if( $q == 'search' && $s && $s !== "" ) {
			global $wpdb;
			$table 	= $wpdb->prefix . "users";
			$sq 	= esc_attr( $s );
			$query 	= $wpdb->get_results( "SELECT * FROM $table WHERE `user_login` LIKE '%$sq%' OR `user_nicename` LIKE '%$sq%' OR `display_name` LIKE '%$sq%'" );
			$result = '';
			foreach ( $query as $user ) {
				$result .= $user->ID . ',';
			}
			return array_filter( explode(',', $result) );
		}
		if( $q == 'mods' ) {
			$wpc = new wpc;	
			$return = array();
			foreach( get_users() as $user ) {
				if( $wpc->is_user('mod', $user->ID) && ! $wpc->is_user('banned', $user->ID) ) {
					$return[] .= $user->ID;
				}
			}
			return array_filter( $return );
		}
	}
	/**
	 * Verifies whether the user is online or not
	 * @param int $user_id user ID
	 * @return boolean True|online or False|offline
	*/
	public function is_online( $user_id ) {
			$om = get_user_meta($user_id, 'wpc_last_seen', TRUE);
			if( $om ) {
				$then = date("Y-m-d H:i:s", $om);
				$now = date("Y-m-d H:i:s", time());
				if(!isset($then)) return false;
				$then = new DateTime($then);
				$now = new DateTime($now);
				$delta = $now->diff($then);
				$quantities = array(
				    'year' => $delta->y,
				    'month' => $delta->m,
				    'day' => $delta->d,
				    'hour' => $delta->h,
				    'minute' => $delta->i,
				    'second' => $delta->s
				    );
				$str = '';
				foreach($quantities as $unit => $value) {
				    if($value == 0) continue;
				    $str .= $value . ' ' . $unit;
				    if($value != 1) {
				        $str .= 's';
				    }
				    $str .=  ', ';
				    if( $unit == 'second' && $value < 15 )
				    	$str = '';
				    break;
				}
				$str = $str == '' ? 'online now' : substr($str, 0, -2);
				return in_array( $str, array( 'online now', '1 second', '2 seconds', '3 seconds', '4 seconds', '5 seconds', '6 seconds', '7 seconds', '8 seconds', '9 seconds', '10 seconds', '11 seconds', '12 seconds', '13 seconds', '14 seconds', '15 seconds' ) ) ? true : false;
			}
	}
	/**
	 * Returns an array of unread message for current user
	 * @return array of unread messages IDs
	*/
	public function get_messages( $q ) {
		global $wpdb;
		global $current_user;
		$table = $wpdb->prefix . "mychats";
		$crntusr = $current_user->ID;
		if( $q == 'unread' ) {
			$query = $wpdb->get_results( "SELECT `id` FROM $table WHERE `to` = '$crntusr' AND `status` = 'unread' AND FIND_IN_SET('$crntusr', `deleted`) = 0" );
			$return = '';
			foreach ( $query as $pm ) {
				$return .= $pm->id . ',';
			}
			return array_unique( array_filter( explode(',', $return) ) );
		}
	}
	
	/**
	 * Outputs message from database to client side
	 * Used to output media, smilies etc
	 * @param int $message message ID
	 * @return string outputted message
	*/
	public function output_message( $message ) {		
		$output_img = preg_replace_callback(
			"(\[img\](.*?)\[/img\])is",
			function($m) {
				$l = array_filter(explode('(link)', $m[1]));
				$count = count($l);
				if( $count == intval(1) ) {
					$ret = '<div>';
					$ret .= '<img src="'.$m[1].'" alt="photo attachment" class="wpc-photo-attachement" style="display:block;"/>';
					$ret .= '<div class="wpc-media-links"><a href="'.$m[1].'" download title="'.$this->translate(50).'"><i class="wpcico-download-cloud"></i>'. $this->translate(49) .'</a>';
					$ret .= ' &nbsp; <a href="'.$m[1].'" target="_blank" title="'.$this->translate(53).'"><i class="wpcico-link-ext-alt"></i>'.$this->translate(52).'</a>';
					$ret .= ' &nbsp; <a href="javascript:void(0);" title="'.$this->translate(55).'" onclick="return prompt(\''.$this->translate(57).':\', \'[img]'.$m[1].'[/img]\');"><i class="wpcico-code"></i>'.$this->translate(56).'</a>';
					$ret .= '</div></div>';
					return $ret;
				} else {
					if( $count > 1 ) {
						$ret = '<div>';
						$ret .= '<a href="'.$l[1].'" target="_blank" rel="nofollow" title="'.$this->translate(60).' ('.$l[1].')" onclick="return confirm(\''. $this->translate(51) .'\n\n'.$this->translate(59).': '.$l[1].'\');"><img src="'.substr($m[1], 0, strpos($m[1],'(link)')).'" alt="photo attachment" class="wpc-photo-attachement" /></a>';
						$ret .= '<div class="wpc-media-links"><a href="'.substr($m[1], 0, strpos($m[1],'(link)')).'" download title="'.$this->translate(50).'"><i class="wpcico-download-cloud"></i>'. $this->translate(49) .'</a>';
						$ret .= ' &nbsp; <a href="'.substr($m[1], 0, strpos($m[1],'(link)')).'" target="_blank" title="'.$this->translate(53).'"><i class="wpcico-link-ext-alt"></i>'.$this->translate(53).'</a>';
						$ret .= ' &nbsp; <a href="javascript:void(0);" title="'.$this->translate(55).'" onclick="return prompt(\''.$this->translate(57).':\', \'[img]'.substr($m[1], 0, strpos($m[1],'(link)')).'(link)'.$l[1].'[/img]\');"><i class="wpcico-code"></i>'.$this->translate(56).'</a>';
						$ret .= ' &nbsp; <a href="'.$l[1].'" target="_blank" onclick="return confirm(\''. $this->translate(51) .'\n\n'.$this->translate(59).': '.$l[1].'\');" title="'.$this->translate(58).'"><i class="wpcico-link"></i>'.$this->translate(58).'</a>';
						$ret .= '</div></div>';
						return $ret;
					}
				}
			},
			$this->output_emoji( nl2br($message) )
		);
		$output_yt = preg_replace_callback(
			"(\[youtube\](.*?)\[/youtube\])is",
			function($m) {
				$ret = '<div>';
				$ret .= '<iframe class="youtube-player" src="//www.youtube.com/embed/'.$m[1].'?rel=0" title="YouTube video player" frameborder="0" width="400" height="300"></iframe>';
				$ret .= '<div class="wpc-media-links"><a href="//ssyoutube.com/watch?v='.$m[1].'" title="'. $this->translate(61) .'" target="_blank"><i class="wpcico-download-cloud"></i>'. $this->translate(49) .'</a>';
				$ret .= ' &nbsp; <a href="//youtube.com/watch?v='.$m[1].'" title="'.$this->translate(63).'" target="_blank"><i class="wpcico-link-ext-alt"></i>'.$this->translate(53).'</a>';
				$ret .= ' &nbsp; <a href="javascript:void(0);" title="'.$this->translate(64).'" onclick="return prompt(\''.$this->translate(62).':\', \'[youtube]'.$m[1].'[/youtube]\');"><i class="wpcico-code"></i>'.$this->translate(56).'</a>';
				$ret .= '</div></div>';
				return $ret;
			},
			$output_img
		);
		$output_vm = preg_replace_callback(
			"(\[vimeo\](.*?)\[/vimeo\])is",
			function($m) {
				$ret = '<div><iframe src="https://player.vimeo.com/video/'.$m[1].'" width="400" height="300" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen loop></iframe>';
				$ret .= '<div class="wpc-media-links"><a href="http://en.savefrom.net/#url=http://vimeo.com/'.$m[1].'" title="'. $this->translate(61) .'" target="_blank"><i class="wpcico-download-cloud"></i>'. $this->translate(49) .'</a>';
				$ret .= ' &nbsp; <a href="//vimeo.com/'.$m[1].'" title="'.$this->translate(65).'" target="_blank"><i class="wpcico-link-ext-alt"></i>'.$this->translate(53).'</a>';
				$ret .= ' &nbsp; <a href="javascript:void(0);" title="'.$this->translate(64).'" onclick="return prompt(\''.$this->translate(62).':\', \'[vimeo]'.$m[1].'[/vimeo]\');"><i class="wpcico-code"></i>'.$this->translate(56).'</a>';
				$ret .= '</div></div>';
				return $ret;
			},
			$output_yt
		);
		$output_dm = preg_replace_callback(
			"(\[dailymotion\](.*?)\[/dailymotion\])is",
			function($m) {
				$ret = '<div><iframe src="http://www.dailymotion.com/embed/video/'.$m[1].'?api=true" width="400" height="300" frameborder="0"></iframe>';
				$ret .= '<div class="wpc-media-links"><a href="http://en.savefrom.net/#url=http://www.dailymotion.com/video/'.$m[1].'" title="'. $this->translate(61) .'" target="_blank"><i class="wpcico-download-cloud"></i>'. $this->translate(49) .'</a>';
				$ret .= ' &nbsp; <a href="//www.dailymotion.com/video/'.$m[1].'" title="'.$this->translate(66).'" target="_blank"><i class="wpcico-link-ext-alt"></i>'.$this->translate(53).'</a>';
				$ret .= ' &nbsp; <a href="javascript:void(0);" title="'.$this->translate(64).'" onclick="return prompt(\''.$this->translate(62).':\', \'[dailymotion]'.$m[1].'[/dailymotion]\');"><i class="wpcico-code"></i>'.$this->translate(56).'</a>';
				$ret .= '</div></div>';
				return $ret;
			},
			$output_vm
		);
		$output_vd = preg_replace_callback(
			"(\[video\](.*?)\[/video\])is",
			function($m) {
				$ret = '<div><video width="400" height="300" controls><source src="'.$m[1].'" type="video/mp4">'.$this->translate(67).'.</video>';
				$ret .= '<div class="wpc-media-links"><a href="'.$m[1].'" title="'.$this->translate(61).'" download><i class="wpcico-download-cloud"></i>'. $this->translate(49) .'</a>';
				$ret .= ' &nbsp; <a href="'.$m[1].'" title="'.$this->translate(53).'" target="_blank"><i class="wpcico-link-ext-alt"></i>'.$this->translate(53).'</a>';
				$ret .= ' &nbsp; <a href="javascript:void(0);" title="'.$this->translate(64).'" onclick="return prompt(\''.$this->translate(62).':\', \'[video]'.$m[1].'[/video]\');"><i class="wpcico-code"></i>'.$this->translate(56).'</a>';
				$ret .= '</div></div>';
				return $ret;
			},
			$output_dm
		);
		$output_l = preg_replace_callback(
			"(\[link\](.*?)\[/link\])is",
			function($m) {
				$l = array_filter(explode('(title)', $m[1]));
				$count = count($l);
				if( $count == intval(1) ) {
					return '<a href="'.$m[1].'" target="_blank" rel="nofollow" title="'.$this->translate(60).' ('.$m[1].')" onclick="return confirm(\''. $this->translate(51) .'\n\n'.$this->translate(59).': '.$m[1].'\');">'.$m[1].'<i class="wpcico-link-ext-alt"></i></a>';
				} else {
					if( $count > 1 )
						return '<a href="'.substr($m[1], 0, strpos($m[1],'(title)')).'" target="_blank" rel="nofollow" title="'.$l[1].'"  onclick="return confirm(\''. $this->translate(51) .'\n\n'.$this->translate(59).': '.substr($m[1], 0, strpos($m[1],'(title)')).'\');">'.$l[1].'<i class="wpcico-link-ext-alt"></i></a>';
				}
			},
			$output_vd
		);
		$output_sd = preg_replace_callback(
			"(\[soundcloud\](.*?)\[/soundcloud\])is",
			function($url) {
				$json = wp_remote_retrieve_body( wp_remote_get("http://soundcloud.com/oembed?format=js&url=".$url[1]."&iframe=true") );
				$exp = explode('"html":"', $json);
				$exp_2 = explode('","author_name"', $json);
				$sd_encoded = str_replace( '","author_name"'. $exp_2[1] , "", $exp[1]);
				$sd_html = str_replace('\"', '"', preg_replace_callback('/\\\\u([0-9a-fA-F]{4})/', function ($match) { return mb_convert_encoding(pack('H*', $match[1]), 'UTF-8', 'UCS-2BE');}, $sd_encoded) );
				$exp_3 = explode('src="', $sd_html);
				$val = str_replace( '"></iframe>', '', $exp_3[1] );
				$ret = '<div>';
				$ret .= '<iframe width="400" height="auto" scrolling="no" frameborder="no" src="' . $val . '" class="soundcloud"></iframe>';
				$ret .= '<div class="wpc-media-links">';
				$ret .= '<a href="http://savefrom.net/#url='.$url[1].'" title="'.$this->translate(230).'" target="_blank"><i class="wpcico-download-cloud"></i>'. $this->translate(49) .'</a>';
				$ret .= ' &nbsp; <a href="'.$url[1].'" title="'.$this->translate(53).'" target="_blank"><i class="wpcico-link-ext-alt"></i>'.$this->translate(53).'</a>';
				$ret .= ' &nbsp; <a href="javascript:void(0);" title="'.$this->translate(231).'" onclick="return prompt(\''.$this->translate(232).':\', \'[soundcloud]'.$url[1].'[/soundcloud]\');"><i class="wpcico-code"></i>'.$this->translate(56).'</a>';
				$ret .= '</div>';
				$ret .= '</div>';
				return $ret;
			},
			$output_l
		);
		$output_sp = preg_replace_callback(
			"(\[spotify\](.*?)\[/spotify\])is",
			function($url) {
				$ret = '<div>';
				$ret .= '<iframe width="400" height="80" scrolling="no" frameborder="no" src="https://embed.spotify.com/?uri=' . $url[1] . '" class="spotify"></iframe>';
				$ret .= '<div class="wpc-media-links">';
				//$ret .= '<a href="http://savefrom.net/#url='.$url[1].'" title="'.$this->translate(230).'" target="_blank"><i class="wpcico-download-cloud"></i>'. $this->translate(49) .'</a>';
				$ret .= /*' &nbsp; */'<a href="'.$url[1].'" title="'.$this->translate(53).'" target="_blank"><i class="wpcico-link-ext-alt"></i>'.$this->translate(53).'</a>';
				$ret .= ' &nbsp; <a href="javascript:void(0);" title="'.$this->translate(231).'" onclick="return prompt(\''.$this->translate(232).':\', \'[spotify]'.$url[1].'[/spotify]\');"><i class="wpcico-code"></i>'.$this->translate(56).'</a>';
				$ret .= '</div>';
				$ret .= '</div>';
				return $ret;
			},
			$output_sd
		);
		$output_bt = preg_replace_callback(
			"(\[beatport\](.*?)\[/beatport\])is",
			function($url) {
				$ret = '<div>';
				$ret .= '<iframe width="400" height="auto" scrolling="no" frameborder="no" src="http://embed.beatport.com/player/?id=' . $url[1] . '&type=track" class="beatport"></iframe>';
				$ret .= '<div class="wpc-media-links">';
				//$ret .= '<a href="http://savefrom.net/#url='.$url[1].'" title="'.$this->translate(230).'" target="_blank"><i class="wpcico-download-cloud"></i>'. $this->translate(49) .'</a>';
				$ret .= /*' &nbsp; */'<a href="http://google.com/search?q=beatport.com/track '.$url[1].'" title="'.$this->translate(53).'" target="_blank"><i class="wpcico-link-ext-alt"></i>'.$this->translate(53).'</a>';
				$ret .= ' &nbsp; <a href="javascript:void(0);" title="'.$this->translate(231).'" onclick="return prompt(\''.$this->translate(232).':\', \'[beatport]'.$url[1].'[/beatport]\');"><i class="wpcico-code"></i>'.$this->translate(56).'</a>';
				$ret .= '</div>';
				$ret .= '</div>';
				return is_numeric( $url[1] ) ? $ret : '<a href="http://google.com/search?q=beatport.com/track '.$url[1].'" target="_blank">'.$url[1].'</a>';
			},
			$output_sp
		);		
		$output_au = preg_replace_callback(
			"(\[audio\](.*?)\[/audio\])is",
			function($m) {
				$tag = false;
				if( is_numeric( strpos( $m[1], 'mp3')  ) ) {
					$tag = '<source src="' . $m[1] . '" type="audio/mpeg">';
				}
				elseif( is_numeric( strpos( $m[1], 'ogg')  ) ) {
					$tag = '<source src="' . $m[1] . '" type="audio/ogg">';
				}
				elseif( is_numeric( strpos( $m[1], 'mp4')  ) ) {
					$tag = '<source src="' . $m[1] . '" type="audio/mp4">';
				}
				$ret = '<div><audio controls>' . $tag . '</audio>';
				$ret .= '<div class="wpc-media-links"><a href="'.$m[1].'" title="'.$this->translate(230).'" download><i class="wpcico-download-cloud"></i>'. $this->translate(49) .'</a>';
				$ret .= ' &nbsp; <a href="'.$m[1].'" title="'.$this->translate(53).'" target="_blank"><i class="wpcico-link-ext-alt"></i>'.$this->translate(53).'</a>';
				$ret .= ' &nbsp; <a href="javascript:void(0);" title="'.$this->translate(231).'" onclick="return prompt(\''.$this->translate(232).':\', \'[audio]'.$m[1].'[/audio]\');"><i class="wpcico-code"></i>'.$this->translate(56).'</a>';
				$ret .= '</div></div>';
				return $tag ? $ret : '<a href="'.$m[1].'" target="_blank">'.$m[1].'</a>';
			},
			$output_bt
		);
		return $output_au;
	}
	public function output_emoji($message) {
		$path 	= get_template_directory_uri() . '/info/inc/img/emoji/';
		$output = str_replace( 
			array(
				':)',
				':D',
				':(',
				':"(',
				':P',
				'O-)',
				'3-)',
				'o.O',
				';)',
				':O',
				'-_-',
				'}_{',
				':*',
				'{3',
				'^_^',
				'8-)',
				'8|',
				'}-(',
				':v',
				':-/',
				':3',
				'(y)',
				':blush:',
				':disappointed:',
				':gift-heart:',
				':heart-smiley:',
				':mocking:',
				':sad:',
				':smiling-face:',
				':triumph:',
				':alien-symbol:',
				':cold-sweat:',
				':dizzy:',
				':happy-blushing:',
				':kiss-2:',
				':purple-devil:',
				':satisfied:',
				':smirking:',
				':unamused:',
				':astonished:',
				':cry-2:',
				':eyes-wide-open:',
				':mad:',
				':red-angry:',
				':scared:',
				':tears-of-joy:',
				':wink-2:',
				':cry-tears:',
				':fear:',
				':heart-eyes:',
				':medic:',
				':relieved:',
				':sleepy:',
				':terrified:',
				':wink-3:'
				),
			array( 
				"<img src=\"".$path."smiley-face.png\" title=\":)\" height=\"16\" width=\"16\" class=\"wpc-smiley\" alt=\"smiley face\"></img>",
				"<img src=\"".$path."big-smile.png\" title=\":D\" height=\"16\" width=\"16\" class=\"wpc-smiley\" alt=\"big smile\"></img>",
				"<img src=\"".$path."frown.png\" title=\":(\" height=\"16\" width=\"16\" class=\"wpc-smiley\" alt=\"frown\"></img>",
				"<img src=\"".$path."cry.png\" title=\":&quot;(\" height=\"16\" width=\"16\" class=\"wpc-smiley\" alt=\"cry\"></img>",
				"<img src=\"".$path."tongue-out.png\" title=\":P\" height=\"16\" width=\"16\" class=\"wpc-smiley\" alt=\"tongue out\"></img>",
				"<img src=\"".$path."angel.png\" title=\"O-)\" height=\"16\" width=\"16\" class=\"wpc-smiley\" alt=\"angel\"></img>",
				"<img src=\"".$path."devil.png\" title=\"3-)\" height=\"16\" width=\"16\" class=\"wpc-smiley\" alt=\"angel\"></img>",
				"<img src=\"".$path."confused.png\" title=\"o.O\" height=\"16\" width=\"16\" class=\"wpc-smiley\" alt=\"confused\"></img>",
				"<img src=\"".$path."wink.png\" title=\";)\" height=\"16\" width=\"16\" class=\"wpc-smiley\" alt=\"wink\"></img>",
				"<img src=\"".$path."surprised.png\" title=\":O\" height=\"16\" width=\"16\" class=\"wpc-smiley\" alt=\"surprised\"></img>",
				"<img src=\"".$path."squinting.png\" title=\"-_-\" height=\"16\" width=\"16\" class=\"wpc-smiley\" alt=\"squinting\"></img>",
				"<img src=\"".$path."angry.png\" title=\"}_{\" height=\"16\" width=\"16\" class=\"wpc-smiley\" alt=\"angry\"></img>",
				"<img src=\"".$path."kiss.png\" title=\":*\" height=\"16\" width=\"16\" class=\"wpc-smiley\" alt=\"kiss\"></img>",
				"<img src=\"".$path."heart.png\" title=\"{3\" height=\"16\" width=\"16\" class=\"wpc-smiley\" alt=\"heart\"></img>",
				"<img src=\"".$path."kiki.png\" title=\"^_^\" height=\"16\" width=\"16\" class=\"wpc-smiley\" alt=\"kiki\"></img>",
				"<img src=\"".$path."glasses.png\" title=\"8-)\" height=\"16\" width=\"16\" class=\"wpc-smiley\" alt=\"glasses\"></img>",
				"<img src=\"".$path."sunglasses.png\" title=\"8-)\" height=\"16\" width=\"16\" class=\"wpc-smiley\" alt=\"sunglasses\"></img>",
				"<img src=\"".$path."grumpy.png\" title=\"}-(\" height=\"16\" width=\"16\" class=\"wpc-smiley\" alt=\"grumpy\"></img>",
				"<img src=\"".$path."pacman.png\" title=\":v\" height=\"16\" width=\"16\" class=\"wpc-smiley\" alt=\"pacman\"></img>",
				"<img src=\"".$path."unsure.png\" title=\":-/\" height=\"16\" width=\"16\" class=\"wpc-smiley\" alt=\"unsure\"></img>",
				"<img src=\"".$path."curly-lips.png\" title=\":3\" height=\"16\" width=\"16\" class=\"wpc-smiley\" alt=\"curly lips\"></img>",
				"<img src=\"".$path."thumb-up.png\" title=\"(y)\" height=\"16\" width=\"16\" class=\"wpc-smiley\" alt=\"thumb up\"></img>",
				"<img src=\"".$path."blush.png\" title=\":blush:\" height=\"16\" width=\"16\" class=\"wpc-smiley\" alt=\"blush\"></img>",
				"<img src=\"".$path."disappointed.png\" title=\":disappointed:\" height=\"16\" width=\"16\" class=\"wpc-smiley\" alt=\"disappointed\"></img>",
				"<img src=\"".$path."gift-heart.png\" title=\":gift-heart:\" height=\"16\" width=\"16\" class=\"wpc-smiley\" alt=\"gift heart\"></img>",
				"<img src=\"".$path."heart-smiley.png\" title=\":heart-smiley:\" height=\"16\" width=\"16\" class=\"wpc-smiley\" alt=\"heart smiley\"></img>",
				"<img src=\"".$path."mocking.png\" title=\":mocking:\" height=\"16\" width=\"16\" class=\"wpc-smiley\" alt=\"mocking\"></img>",
				"<img src=\"".$path."sad.png\" title=\":sad:\" height=\"16\" width=\"16\" class=\"wpc-smiley\" alt=\"sad\"></img>",
				"<img src=\"".$path."smiling-face.png\" title=\":smiling-face:\" height=\"16\" width=\"16\" class=\"wpc-smiley\" alt=\"smiling face\"></img>",
				"<img src=\"".$path."triumph.png\" title=\":triumph:\" height=\"16\" width=\"16\" class=\"wpc-smiley\" alt=\"triumph\"></img>",
				"<img src=\"".$path."alien-symbol.png\" title=\":alien-symbol:\" height=\"16\" width=\"16\" class=\"wpc-smiley\" alt=\"alien symbol\"></img>",
				"<img src=\"".$path."cold-sweat.png\" title=\":cold-sweat:\" height=\"16\" width=\"16\" class=\"wpc-smiley\" alt=\"cold sweat\"></img>",
				"<img src=\"".$path."dizzy.png\" title=\":dizzy:\" height=\"16\" width=\"16\" class=\"wpc-smiley\" alt=\"dizzy\"></img>",
				"<img src=\"".$path."happy-blushing.png\" title=\":happy-blushing:\" height=\"16\" width=\"16\" class=\"wpc-smiley\" alt=\"happy blushing\"></img>",
				"<img src=\"".$path."kiss-2.png\" title=\":kiss-2:\" height=\"16\" width=\"16\" class=\"wpc-smiley\" alt=\"kiss\"></img>",
				"<img src=\"".$path."purple-devil.png\" title=\":purple-devil:\" height=\"16\" width=\"16\" class=\"wpc-smiley\" alt=\"purple devil\"></img>",
				"<img src=\"".$path."satisfied.png\" title=\":satisfied:\" height=\"16\" width=\"16\" class=\"wpc-smiley\" alt=\"satisfied\"></img>",
				"<img src=\"".$path."smirking.png\" title=\":smirking:\" height=\"16\" width=\"16\" class=\"wpc-smiley\" alt=\"smirking\"></img>",
				"<img src=\"".$path."unamused.png\" title=\":unamused:\" height=\"16\" width=\"16\" class=\"wpc-smiley\" alt=\"unamused\"></img>",
				"<img src=\"".$path."astonished.png\" title=\":astonished:\" height=\"16\" width=\"16\" class=\"wpc-smiley\" alt=\"astonished\"></img>",
				"<img src=\"".$path."cry-2.png\" title=\":cry-2:\" height=\"16\" width=\"16\" class=\"wpc-smiley\" alt=\"cry\"></img>",
				"<img src=\"".$path."eyes-wide-open.png\" title=\":eyes-wide-open:\" height=\"16\" width=\"16\" class=\"wpc-smiley\" alt=\"eyes wide open\"></img>",
				"<img src=\"".$path."mad.png\" title=\":mad:\" height=\"16\" width=\"16\" class=\"wpc-smiley\" alt=\"mad\"></img>",
				"<img src=\"".$path."red-angry.png\" title=\":red-angry:\" height=\"16\" width=\"16\" class=\"wpc-smiley\" alt=\"red angry\"></img>",
				"<img src=\"".$path."scared.png\" title=\":scared:\" height=\"16\" width=\"16\" class=\"wpc-smiley\" alt=\"scared\"></img>",
				"<img src=\"".$path."tears-of-joy.png\" title=\":tears-of-joy:\" height=\"16\" width=\"16\" class=\"wpc-smiley\" alt=\"tears of joy\"></img>",
				"<img src=\"".$path."wink-2.png\" title=\":wink-2:\" height=\"16\" width=\"16\" class=\"wpc-smiley\" alt=\"wink\"></img>",
				"<img src=\"".$path."cry-tears.png\" title=\":cry-tears:\" height=\"16\" width=\"16\" class=\"wpc-smiley\" alt=\"cry tears\"></img>",
				"<img src=\"".$path."fear.png\" title=\":fear:\" height=\"16\" width=\"16\" class=\"wpc-smiley\" alt=\"fear\"></img>",
				"<img src=\"".$path."heart-eyes.png\" title=\":heart-eyes:\" height=\"16\" width=\"16\" class=\"wpc-smiley\" alt=\"heart eyes\"></img>",
				"<img src=\"".$path."medic.png\" title=\":medic:\" height=\"16\" width=\"16\" class=\"wpc-smiley\" alt=\"medic\"></img>",
				"<img src=\"".$path."relieved.png\" title=\":relieved:\" height=\"16\" width=\"16\" class=\"wpc-smiley\" alt=\"relieved\"></img>",
				"<img src=\"".$path."sleepy.png\" title=\":sleepy:\" height=\"16\" width=\"16\" class=\"wpc-smiley\" alt=\"sleepy\"></img>",
				"<img src=\"".$path."terrified.png\" title=\":terrified:\" height=\"16\" width=\"16\" class=\"wpc-smiley\" alt=\"terrified\"></img>",
				"<img src=\"".$path."wink-3.png\" title=\":wink-3:\" height=\"16\" width=\"16\" class=\"wpc-smiley\" alt=\"wink\"></img>"
				),
			html_entity_decode( stripslashes( $message ) )
		);
		$admin_emoji = get_option('wpc_admin_smileys');
		if( $admin_emoji && strlen($admin_emoji) > 0 ) {
			$ar1 = ''; 
			$ar2 = '';
			foreach( explode(',', $admin_emoji) as $emo ) {
				if( strlen($emo) > 0 ) {
					$urlV = explode('url="', $emo);
					$url = substr($urlV[1], 0, strpos($urlV[1], '" code="'));
					$codeV = explode('code="', $emo);
					$code = substr($codeV[1], 0, strpos($codeV[1], '" alt="'));
					$altV = explode('alt="', $emo);
					$alt = substr($altV[1], 0, strpos($altV[1], '"}'));
					$ar1 .= $code . ',';
					$ar2 .= "<img src=\"$url\" title=\"$code\" class=\"wpc-smiley wpc-admin-emoji\" alt=\"$alt\"></img>,";
				}
			}
		}
		$countEmo = count(array_filter(explode(',', $admin_emoji)));
		if( $countEmo > 0 )
			return str_replace( array_unique(array_filter(explode(',', $ar1))), array_unique(array_filter(explode(',', $ar2))), $output );
		else
			return $output;
	}
	
	/**
	 * Verifies whether user is currently browsing through site or not
	 * This function is used to notify users of new messages via email if they're not active
	 * @param int $recipient user ID
	 * @return bool true|online false|offline.
	*/
	public function is_logged_in($recipient) {
		if( ! get_userdata($recipient) ) { // usre does not exist
			return false;
			exit;
		}
		$meta = get_user_meta($recipient, 'wpc_last_seen', TRUE);
		if( ! $meta ) { // user status not updated yet, so offline
			return false;
			exit;
		}
		$ret = $this->online_diff( date("Y-m-d H:i:s", $meta), date("Y-m-d H:i:s", time()) );
		if( strpos($ret, 'wpc_online') )
			return true;
		else
			return false;
	}
	/**
	 * Returns a single message by ID, in the conversation page
	 * @param int $m message ID
	 * @param string $adi hint for javascript scroll to message by adding className for that.
	 * @return outputs message
	*/
	public function single($m, $adi) {
		global $wpdb;
		global $current_user;
		$table = $wpdb->prefix."mychats";
		$q = $wpdb->get_results( "SELECT * FROM $table WHERE `id` = '$m' LIMIT 1" );
		$chat_id = $this->get_message_parts( $m, "chat_id" );
		$current_user_id = $current_user->ID;
		$query 		= isset( $_GET["wpc_search"] ) ? esc_attr( $_GET["wpc_search"] ) : '';
		$q2 = $wpdb->get_results( "SELECT `id` FROM $table WHERE `chat_id` = '$chat_id' AND FIND_IN_SET('$current_user_id', `deleted`) = 0 ORDER BY `id` DESC LIMIT 1" );
		$lid = '';
		foreach( $q2 as $m )
			$lid = $m->id;
		$mid = false;
		foreach( $q as $row ) {
			$mid = $row->id; 
			$classes = '';
			$classes .= $row->from == $current_user->ID ? 'sent byme' : 'received bycontact';
			$classes .= $row->to == $current_user->ID && $row->status == "unread" ? ' unread' : '';
			$classes .= $row->id == $lid ? ' last' : '';
			$classes .= substr_count($this->output_message($row->body), '<iframe') || substr_count($this->output_message($row->body), '<video') || substr_count($this->output_message($row->body), '<audio') || substr_count($this->output_message($row->body), 'wpc-photo-attachement') ? ' media' : false;
			$classes .= $adi ? ' wpc_scroll_item newm' : '';
			$rep = get_user_meta($current_user->ID, 'wpc_report_'.$row->id, TRUE);
			ob_start();
			?>
				<div class="<?php echo $classes; ?>" id="<?php echo $row->id; ?>" data-by="<?php echo $row->from == $current_user->ID ? 'me' : 'contact'; ?>" <?php echo $row->id == $lid && !isset($_GET["wpc_search"]) ? 'data-ins="1"' : ''; ?>>
					<style type="text/css">.avatar-cont.user-<?php echo $row->from; ?> a:hover:after{content:'<?php echo get_userdata( $row->from )->user_nicename; ?>';display:block;}</style>
					<div class="avatar-cont user-<?php echo $row->from; ?>">
						<a href="<?php echo $this->user_links('link', $row->from, ''); ?>" class="wpc-tooltip">
							<?php echo $this->user_avatar($row->from, 32); ?>
						</a>
					</div>
					<div class="content-cont m-<?php echo $row->id; ?>">
						<div class="msg-content">
							<?php echo $this->output_message($row->body); ?>
							<?php 
							if ( $row->status == "read" && $row->from == $current_user->ID ) {
								$msg = 'seen ' . $this->time_difference( date("Y-m-d H:i:s", $row->seen), date("Y-m-d H:i:s", time()), ' ago' );
								echo "<div class=\"msg-seen wpc-tooltip\" id=\"".$row->id."-seen\">$msg</div>";
								echo "<style type=\"text/css\">.m-".$row->id." .msg-seen:hover:after{content:'$msg (".date("Y-m-d H:i:s", $row->seen).")';}</style>";
							}
							?>
						</div>
						<div class="msg-meta">
							<div class="wpc-tooltip cont-<?php echo $row->time; ?>">
								<style type="text/css">.msg-meta .cont-<?php echo $row->time; ?>:hover:after{content: '<?php echo date("Y-m-d H:i:s", $row->time); ?>';display: block;}</style>
								<span class="wpcico-clock">
									<?php echo $this->just_now( $this->time_difference( date("Y-m-d H:i:s", $row->time), date("Y-m-d H:i:s", time()), '' ) ); ?>
								</span>
							</div>
							<div id="del_rep_cont" data-id="<?php echo $row->id; ?>">
								<a href="<?php echo $this->get_settings('messages_page'); ?>?todo=pm_delete&amp;id=<?php echo $row->id; ?>" class="wpc-tooltip" data-action="del"><i class="wpcico-trash"></i><?php echo $this->translate(10); ?></a>
								<a href="<?php echo $this->get_settings('messages_page'); ?>?todo=pm_report&amp;id=<?php echo $row->id; ?>" class="wpc-tooltip" data-action="rep"  title="<?php echo $rep && $rep !== '' ? $this->translate(11).': \''.$rep.'\'' : ''; ?>"><i class="wpcico-flag"></i><?php echo $rep && $rep !== '' ? $this->translate(12) : $this->translate(13); ?></a>
							</div>
						</div>
					</div>
				</div>
			<?php
			if( $current_user->ID == $this->get_message_parts( $mid, 'to' )  )
				$this->mark_seen( false, $mid );
			echo ob_get_clean();
		}
	}
	/**
	 * Loads message input textarea with conversation tools
	 * For blocked users or users you can't contact, it returns a notice.
	 * @param int $pm conversation ID
	 * @param bool $locked is conversation form locked for current conversation and user or not.
	*/
	public function load_input( $pm, $locked ) {
		global $current_user;
		$auto_save = get_option('wpc_autosave_' . $pm . '_' . $current_user->ID);
		$autoSave = $auto_save && $auto_save !== '' && !$locked ? str_replace('<br>', "\n", html_entity_decode(stripslashes($auto_save))) : '';
		$path = get_template_directory_uri() . '/info/inc/img/emoji/';
		ob_start();
		?>
		<div class="wpc-form">
			<?php do_action('_wpc_before_message_input'); ?>
			<form action="<?php echo !$locked ? get_template_directory_uri() . '/info/core/form.php' : '#'; ?>" method="get" id="single_pm_form">
				<?php ob_start(); ?>
				<div class="textarea-cont">
					<table width="100%"><tr>
					<td width="auto" valign="top"><?php echo $locked ? '<div class="sorry-overlay"><span><i class="wpcico-attention"></i> '. str_replace('[user]', get_userdata( $this->get_conversation($pm, 'contact') )->user_nicename, $this->translate(68)) .'.</span></div>' : ''; ?>
					<textarea name="message" id="message_body"<?php echo $locked ? ' disabled="disabled"' : false; ?>><?php echo $autoSave; ?></textarea>
					</td><td valign="top" width="50px">
					<?php echo $locked ? '<input type="submit" value="'.$this->translate(72).'" onclick="return false;" disabled="disabled" />' : '<input type="submit" value="'.$this->translate(69).'" id="message_send" />'; ?>
					</td></tr></table>
				</div>
				<?php echo apply_filters('_wpc_message_input_area', ob_get_clean(), $auto_save, $locked ); ?>
				<?php if(!$locked):; ?>
				<input type="hidden" name="to" id="message_to" value="<?php echo $this->get_conversation($pm, 'contact'); ?>">
				<input type="hidden" name="referrer" value="<?php echo $_SERVER["REQUEST_URI"]; ?>">
				<?php endif; ?>
			</form>
			<?php do_action('_wpc_after_message_input'); ?>
		</div>
		<?php
		return ob_get_clean();
	}
	public function translate( $indexVal, $lang = false ) {
		$op = get_option('wpc_translations');
		if( $op && $this->get_settings('translation') ) { 
			$data =  json_decode( stripslashes($op) , true );
			foreach( $data as $index => $value ) {
				return !empty($data[$indexVal]) && $data[$indexVal] !== '' ? $data[$indexVal] : $this->defaults($indexVal);
			}
		} else {
			return $this->defaults($indexVal);
		}
	}
	public function defaults( $indexVal ) {
		$data =  json_decode( $this->defaultsJSON, true );
		foreach( $data as $index => $value ) {
			return !empty($data[$indexVal]) && $data[$indexVal] !== '' ? $data[$indexVal] : '';
		}
	}

	public function getTranslation($target) {

		$additional_translations = apply_filters('_wpc_register_additional_translations', $array = false );
		$array = array_filter( array_unique( explode(',', $additional_translations)) );
		if( !in_array( $target, $array) ) {
			return 'This translation is not registered. Please use <code>_wpc_register_additional_translations</code> filter to add it.';
		}
		else {
		$targetVal = preg_replace('/[^\da-z]/i', '', $target);
			$op = get_option('wpc_additional_translations');
			if( $op ) { 
				$data =  json_decode( stripslashes($op) , true );
				foreach( $data as $index => $value ) {
					return !empty($data[$targetVal]) && $data[$targetVal] !== '' ? $data[$targetVal] : $target;
				}
			} else {
				return $target;
			}
		}

	}
	// set mail headers sender name
    public function settings_mail_headers_from_name() {
    	return $this->get_settings('mail_headers_from_name');
    }
	// set mail headers sender email
	public function settings_mail_headers_from() {
		return $this->get_settings('mail_headers_from');
	}
	function __destruct() {
		// remove mail headers filters once done
		remove_filter( 'wp_mail_from_name', array( $this, 'settings_mail_headers_from_name' ) );
		remove_filter( 'wp_mail_from', array( $this, 'settings_mail_headers_from' ) );
	}

	public function pro_notice($hint = false) {
		ob_start();
		?><div style="position: absolute; background: rgba(0, 0, 0, 0.5); width: 100%; height: 100%; z-index: 100;"><div style=" position: relative; top: 50%;color: #fff; font-size: 150%;margin: 0 auto; display: table; padding: 9px 14px; background: #122; border-radius: 2px; ">Pro feature. <a href="http://go.samelh.com/get/wpchats/" target="_blank">More info &raquo;</a></div></div><?php
		$gl = ob_get_clean();

		ob_start();
		?><div style="background: rgba(0, 0, 0, 0.5); width: 100%; height: 100%; z-index: 100; position: relative; top: 50%;color: #fff; font-size: 150%;margin: 0 auto; display: table; padding: 9px 14px; background: #122; border-radius: 2px; ">Pro feature. <a href="http://go.samelh.com/get/wpchats/" target="_blank">More info &raquo;</a></div><?php
		$se = ob_get_clean();

		echo !$hint ? $gl : $se;

	}

}