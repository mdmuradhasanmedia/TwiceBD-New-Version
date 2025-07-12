<?php 
error_reporting(0);
add_action( 'wp_ajax_nopriv_ln_ajax_process', 'ln_ajax_process' );
add_action( 'wp_ajax_ln_ajax_process', 'ln_ajax_process' );
    
function ln_ajax_process(){	
	global $wpdb;

	$userinfo = wp_get_current_user();
	$options = get_option('ln_options');

	if($_REQUEST['a'] == 'pr'){
		ln_nb_reply_action($_REQUEST['i'],$_REQUEST['t']);
		print($_REQUEST['i'].",".$_REQUEST['h']);
		exit(0);
	}
	
	if($_REQUEST['a'] == 'pr'){
		ln_pm_reply_action($_REQUEST['i'],$_REQUEST['t']);
		print($_REQUEST['i'].",".$_REQUEST['h']);
		exit(0);
	}
	
	if ((!isset($userinfo) || empty($userinfo->ID)) && $_REQUEST['do']) { // User has been logged out
		print("logout");
		exit(0);
	}
	if ($_REQUEST['do'] == 'ln_getcount') {
		@error_reporting(E_NONE); 
		
	// Turn off error reporting completely
	//	if (!is_member_of($userinfo, explode(",",$options['ln_allowed_usergroups']))) return;
	$ln_useroptions['enable_comment'] = $options[0];
	$ln_useroptions['enable_reply'] = $options[1];
	$ln_useroptions['enable_award'] = $options[2];
	$ln_useroptions['enable_moderation'] = $options[3];
	$ln_useroptions['enable_taguser'] = $options[4];
	$ln_useroptions['enable_nb'] = $options[5];
	$ln_useroptions['enable_pm'] = $options[6];
		
	if ($options['enable_comment'] || $options['enable_reply'] || $options['enable_award'] || $options['enable_moderation'] || $options['enable_taguser'] || $options['enable_nb'] || $options['enable_pm']){
		if ($userinfo->ID < 1) die();
			
		if (isset($_REQUEST['act'])){
			if($_REQUEST['act'] == 'nb_delete'){
				ln_nb_delete_action($_REQUEST['nb_id']);
			}else if($_REQUEST['act'] == 'nb_reply'){
				ln_nb_reply_action($_REQUEST['nb_id'],$_REQUEST['nb_text']);
				print($_REQUEST['nb_id'].",".$_REQUEST['scrollpane_height']);
				exit(0);
			}
		}
		
		if (isset($_REQUEST['act'])){
			if($_REQUEST['act'] == 'pm_delete'){
				ln_pm_delete_action($_REQUEST['pm_id']);
			}else if($_REQUEST['act'] == 'pm_reply'){
				ln_pm_reply_action($_REQUEST['pm_id'],$_REQUEST['pm_text']);
				print($_REQUEST['pm_id'].",".$_REQUEST['scrollpane_height']);
				exit(0);
			}
		}
			
		if ($_REQUEST['numonly']){
			ln_update_readflag($userinfo->ID, 0, $options['max_notifications_count'],false,$_REQUEST['type']);
			$op = ln_count_user_notifications($userinfo->ID,$_REQUEST['type']);
			if (isset($_REQUEST['act'])){
				$op .= "|".ln_fetch_notifications($userinfo->ID, 0, $options['max_notifications_count'],false,$_REQUEST['type']);
			}else{
				$op .= "|".$_REQUEST['type'];
			}
		}else{
			if($_REQUEST['count']){
					$type = $_REQUEST['type'];
					$count_comment = $count_nb = $count_pm = $count_moderation = $options['max_notifications_count'];
					$count_tmp = $_REQUEST['count'];
					if($type == 'comment')$count_comment = $count_tmp;
					if($type == 'nb')$count_nb = $count_tmp;
					if($type == 'pm')$count_pm = $count_tmp;
				 	if($type == 'moderation')$count_moderation = $count_tmp;
			}else{
				$count_comment = $count_nb = $count_pm = $count_moderation = $options['max_notifications_count'];
			}
			
			$nb_num = 0;
			$pm_num = 0;
			$moderation_num = 0;
				
			//ln_update_notifications($userinfo->ID,0, $count_moderation, 'moderation');
			$moderation_num = ln_count_user_notifications($userinfo->ID,'moderation');
			$nb_num = ln_count_user_notifications($userinfo->ID,'nb');
			$pm_num = ln_count_user_notifications($userinfo->ID,'pm');
			
			$op = ln_count_user_notifications($userinfo->ID,'comment')."|".$nb_num."|".$pm_num."|".$moderation_num;
			$op .= "|".ln_fetch_notifications($userinfo->ID, 0, $count_comment,false,'comment');
			$op .= "|".ln_fetch_notifications($userinfo->ID, 0, $count_nb,false,'nb');
			$op .= "|".ln_fetch_notifications($userinfo->ID, 0, $count_pm,false,'pm');
			$op .= "|".ln_fetch_notifications($userinfo->ID, 0, $count_moderation,false,'moderation');
		}
		print($op);
		exit(0);
	}
}else if ($_REQUEST['do'] == 'ln_userdropdown'){
	@error_reporting(E_NONE); 
	
	if ($userinfo->ID < 1) die();
			
	$op = ln_fetch_userdropdown($userinfo, $options);
			
	print($op);
	exit(0);
}
else if ($_REQUEST['do'] == 'ln_save_option'){
	@error_reporting(E_NONE); 
		
	if ($userinfo->ID < 1) die();
		
	$option =  str_replace("true","1",$_REQUEST['options']);
	$option =  str_replace("false","0",$option);
		
	$options = explode(",",$option);
	$ln_useroptions['enable_comment'] = $options[0];
	$ln_useroptions['enable_reply'] = $options[1];
	$ln_useroptions['enable_award'] = $options[2];
	$ln_useroptions['enable_moderation'] = $options[3];
	$ln_useroptions['enable_taguser'] = $options[4];
	$ln_useroptions['enable_nb'] = $options[5];
	$ln_useroptions['enable_pm'] = $options[6];
		
	ln_save_useroptions($userinfo->ID,$ln_useroptions);
			
	print("success");
	exit(0);
	}
}

function send_new_topic_notification(){	
	global $wpdb;
	
	$selectpost=mysql_query("select * from ".$wpdb->prefix."posts where post_type='forum'");
	
	if(mysql_num_rows($selectpost)>0){
		while($selectpostrec=mysql_fetch_array($selectpost)){
			$fetchtopics=mysql_query("select * from ".$wpdb->prefix."posts where post_parent='".$selectpostrec['ID']."' and post_type!='revision'");	
	
        	if(mysql_num_rows($fetchtopics)>0){
				while($fetchtopicsrec=mysql_fetch_array($fetchtopics)){
					$fetchusergrpwise=mysql_query("select * from ".$wpdb->prefix."users where ID!='".$selectpostrec['post_author']."'");
					
					if(mysql_num_rows($fetchusergrpwise)>0){
						while($fetchusergrpwiserec=mysql_fetch_array($fetchusergrpwise)){ 
							$selectlivenoti=mysql_query("select id from ".$wpdb->prefix."livenotifications where userid='".$fetchusergrpwiserec['ID']."' and userid_subj='".$selectpostrec['post_author']."' and content_id='".$fetchtopicsrec['ID']."'");
							
							if(mysql_num_rows($selectlivenoti)==0){
								$user_info = get_userdata($selectpostrec['post_author']);
								mysql_query("insert into ".$wpdb->prefix."livenotifications (`userid`,`userid_subj`,`content_type`,`content_id`,`parent_id`,`content_text`,`time`,`username`) values('".$fetchusergrpwiserec['ID']."','".$fetchtopicsrec['post_author']."','bbpressnotification','".$fetchtopicsrec['ID']."','".$fetchtopicsrec['post_parent']."','".$fetchtopicsrec['post_title']."','".time()."','".$user_info->display_name."')");
							}
				     	}
				    }
				}
			}
		}
	}
}
function send_new_reply_notification(){
	global $wpdb;
	
	$selectforum=mysql_query("select * from ".$wpdb->prefix."bp_groups where enable_forum='1'");
	
	if(mysql_num_rows($selectforum)>0){
		while($selectforumrec=mysql_fetch_array($selectforum)){
		    $forumid=groups_get_groupmeta( $selectforumrec['id'], $meta_key = 'forum_id');
			$countforum=count($forumid);
			
			for($i=0;$i<$countforum;$i++){
				$selectpost=mysql_query("select * from ".$wpdb->prefix."posts where post_parent='".$forumid[$i]."'");
				
				if(mysql_num_rows($selectpost)>0){
					while($selectpostrec=mysql_fetch_array($selectpost)){
				    	$selectpostreply=mysql_query("select * from ".$wpdb->prefix."posts where post_parent='".$selectpostrec['ID']."'");
				    	
						if(mysql_num_rows($selectpostreply)>0){
				    		while($selectpostreplyrec=mysql_fetch_array($selectpostreply)){	
						        $fetchusergrpwise=mysql_query("select * from ".$wpdb->prefix."bp_groups_members where group_id='".$selectforumrec['id']."' and user_id!='".$selectpostrec['post_author']."'");
								
								if(mysql_num_rows($fetchusergrpwise)>0){
									while($fetchusergrpwiserec=mysql_fetch_array($fetchusergrpwise)){
										$selectlivenoti=mysql_query("select id from ".$wpdb->prefix."livenotifications where userid='".$fetchusergrpwiserec['user_id']."' and userid_subj='".$selectpostrec['post_author']."' and content_id='".$selectpostreplyrec['ID']."'");
										
										if(mysql_num_rows($selectlivenoti)==0){
											$user_info = get_userdata($selectpostreplyrec['post_author']);
										}
							       	}
					    		}
				          	}
			         	}
					}
				}
			}
		}
	}
	
	$selectpost=mysql_query("select * from ".$wpdb->prefix."posts where post_type='topic'");
	
	if(mysql_num_rows($selectpost)>0){
		while($selectpostrec=mysql_fetch_array($selectpost)){
			$fetchtopics=mysql_query("select * from ".$wpdb->prefix."posts where post_parent='".$selectpostrec['ID']."' and post_type!='revision'");	
			
			if(mysql_num_rows($fetchtopics)>0){
				while($fetchtopicsrec=mysql_fetch_array($fetchtopics)){
					$fetchusergrpwise=mysql_query("select * from ".$wpdb->prefix."users where ID!='".$fetchtopicsrec['post_author']."'");
					
					if(mysql_num_rows($fetchusergrpwise)>0){
						while($fetchusergrpwiserec=mysql_fetch_array($fetchusergrpwise)){ 
							$selectlivenoti=mysql_query("select id from ".$wpdb->prefix."livenotifications where userid='".$fetchusergrpwiserec['ID']."' and userid_subj='".$fetchtopicsrec['post_author']."' and content_id='".$fetchtopicsrec['ID']."'");
							
							if(mysql_num_rows($selectlivenoti)==0){
								$user_info = get_userdata($fetchtopicsrec['post_author']);
								mysql_query("insert into ".$wpdb->prefix."livenotifications (`userid`,`userid_subj`,`content_type`,`content_id`,`parent_id`,`content_text`,`time`,`username`) values('".$fetchusergrpwiserec['ID']."','".$fetchtopicsrec['post_author']."','bbpressnotificationreply','".$fetchtopicsrec['ID']."','".$fetchtopicsrec['post_parent']."','".$fetchtopicsrec['post_title']."','".time()."','".$user_info->display_name."')");
							}
				       	}
			       	}
				}
			}
		}
	}
}



function ln_add_comment_notifications( $comment_ID, $comment_approved ){
	global $wpdb;
	
	if ( !$comment = get_comment($comment_ID) ){
		return false;
	}
	
	$dimentions = get_option('gmt_offset');
	$comments_waiting = $wpdb->get_var("SELECT count(comment_ID) FROM $wpdb->comments WHERE comment_approved = '0'");
	$post_info = get_post($comment->comment_post_ID);
	$userid = $comment->user_id;
	$commenter_name = $comment->comment_author;
	$comment_time = strtotime($comment->comment_date);
	$comment_date = $comment_time+(60*(60*(-($dimentions)) ));
	$comment_approval = $comment->comment_approved;
	$comment_parent = $comment->comment_parent;
	$ln_post = $wpdb->get_row( "SELECT user_id,comment_content FROM " . $wpdb->prefix . "comments WHERE comment_ID = '".$comment_parent."'" );

	// moderation notifiatons
	   $moderator_ids = $wpdb->get_results( 'SELECT ' . $wpdb->prefix . 'users.ID FROM ' . $wpdb->prefix . 'users WHERE (SELECT ' . $wpdb->prefix . 'usermeta.meta_value FROM ' . $wpdb->prefix . 'usermeta WHERE ' . $wpdb->prefix . 'usermeta.user_id = ' . $wpdb->prefix . 'users.ID AND ' . $wpdb->prefix . 'usermeta.meta_key = "' . $wpdb->prefix . 'capabilities") LIKE "%administrator%"' );
		$is_noadmin = true;
		
		foreach( $moderator_ids as $m_id ){
			ln_add_user_notification(0, $m_id->ID, 'mod_comment', 0, $comments_waiting, $comment->comment_post_ID, $comment_date, $commenter_name, $comment_approved);
			if( $m_id->ID == $post_info->post_author ){
				$is_noadmin = false;
			} 
		}
		
		if ( user_can( $post_info->post_author, 'edit_comment', $comment_ID) && $is_noadmin ){
			ln_add_user_notification(0, $post_info->post_author, 'mod_comment', 0, $comments_waiting, $comment->comment_post_ID, $comment_date, $commenter_name, $comment_approved);
		}
		
 	
	// comment notifiatons
	if (($comment_parent == 0) && ($comment_approval == 1) ){
		if ($userid != $post_info->post_author){
			// notification count
			$notification_count = $wpdb->get_var( "SELECT COUNT(*) FROM " . $wpdb->prefix . "livenotifications WHERE `userid` = '".$post_info->post_author."' AND `content_type` = 'comment' AND `parent_id` = '".$comment->comment_post_ID."' ORDER BY `time` DESC" );
			// select id from notification
			$select_id = $wpdb->get_row( "SELECT id FROM " .$wpdb->prefix. "livenotifications WHERE userid = '".$post_info->post_author."' AND content_type = 'comment' AND parent_id = '".$comment->comment_post_ID."' ORDER BY time DESC LIMIT 1" );
			$selected_id =  $select_id->id;
			
			// count total comments excule author
			$comment_count = count( $wpdb->get_results( "select com2.comment_ID, com2.comment_author, com2.user_id, com2.comment_content, com2.comment_date from " . $wpdb->prefix . "comments as com2 WHERE com2.comment_ID IN ( select Max(com.comment_ID) from " . $wpdb->prefix . "comments as com where com.comment_post_ID = '".$comment->comment_post_ID."' AND com.user_id != '".$post_info->post_author."' AND com.comment_approved = 1 AND com.comment_parent = 0 GROUP BY com.user_id ) ORDER BY com2.comment_ID DESC" ) );

			// get comment exclude author (2) - user
			$commenters_2 = $wpdb->get_results( "select com2.comment_ID, com2.comment_author, com2.user_id, com2.comment_content, com2.comment_date from " . $wpdb->prefix . "comments as com2 WHERE com2.comment_ID IN ( select Max(com.comment_ID) from " . $wpdb->prefix . "comments as com where com.comment_post_ID = '".$comment->comment_post_ID."' AND com.user_id != '".$post_info->post_author."' AND com.comment_approved = 1 AND com.comment_parent = 0 GROUP BY com.user_id ) ORDER BY com2.comment_ID DESC LIMIT 2" );
			foreach( $commenters_2 as $cmd_2 ) {
	    		$user_info_2 = get_userdata( $cmd_2->user_id );
				$resultset_2[] = ucfirst(strtolower( $user_info_2->display_name ));
			}
			$commenter_2 = implode(", ", $resultset_2);   
			
			// get comment exclude author (3) - user
			$commenters_3 = $wpdb->get_results( "select com2.comment_ID, com2.comment_author, com2.user_id, com2.comment_content, com2.comment_date from " . $wpdb->prefix . "comments as com2 WHERE com2.comment_ID IN ( select Max(com.comment_ID) from " . $wpdb->prefix . "comments as com where com.comment_post_ID = '".$comment->comment_post_ID."' AND com.user_id != '".$post_info->post_author."' AND com.comment_approved = 1 AND com.comment_parent = 0 GROUP BY com.user_id ) ORDER BY com2.comment_ID DESC LIMIT 3" );
			foreach( $commenters_3 as $cmd_3 ) {
	    		$user_info_3 = get_userdata( $cmd_3->user_id );
				$resultset_3[] = ucfirst(strtolower( $user_info_3->display_name ));
			}
			$commenter_3 = implode(", ", $resultset_3);   			
			
			if( $comment_count == 1 ){
				if( $notification_count == 1){
					// select last id
					$selection = $wpdb->get_row( "SELECT id FROM " .$wpdb->prefix. "livenotifications WHERE userid = '".$post_info->post_author."' AND content_type = 'comment' AND parent_id = '".$comment->comment_post_ID."' ORDER BY time ASC LIMIT 1" );
					// update new rows
					$wpdb->update( $wpdb->prefix. "livenotifications", array( 'userid_subj' => $userid, 'content_id' => $comment_ID, 'content_text' => $post_info->post_title, 'is_read' => 0, 'time' => time(), 'additional_subj' => 0, 'username' => $commenter_name ), array( 'id' => $selection->id ) );
				}elseif( $notification_count > 1){
					// delete rows ids
					$wpdb->query("DELETE FROM " .$wpdb->prefix. "livenotifications WHERE userid='".$post_info->post_author."' AND content_type = 'comment' AND parent_id = '".$comment->comment_post_ID."' AND id NOT IN ( ".$selected_id." )");
					// select last id
					$selection = $wpdb->get_row( "SELECT id FROM " .$wpdb->prefix. "livenotifications WHERE userid = '".$post_info->post_author."' AND content_type = 'comment' AND parent_id = '".$comment->comment_post_ID."' ORDER BY time ASC LIMIT 1" );
					// update new rows
					$wpdb->update( $wpdb->prefix. "livenotifications", array( 'userid_subj' => $userid, 'content_id' => $comment_ID, 'content_text' => $post_info->post_title, 'is_read' => 0, 'time' => time(), 'additional_subj' => 0, 'username' => $commenter_name ), array( 'id' => $selection->id ) );
				}else{
					// insert into live notifications table
					$wpdb->query("INSERT INTO " . $wpdb->prefix . "livenotifications (id,userid,userid_subj,content_type,content_id,parent_id,content_text,is_read,time,additional_subj,username) 
					VALUES (NULL, '".$post_info->post_author."', '".$userid."', 'comment', '".$comment_ID."', '".$comment->comment_post_ID."', '".$post_info->post_title."', '0', '".time()."', '0', '".$commenter_name."')");
				}
			}elseif( $comment_count == 2 ){
				if( $notification_count == 1){
					// select last id
					$selection = $wpdb->get_row( "SELECT id FROM " .$wpdb->prefix. "livenotifications WHERE userid = '".$post_info->post_author."' AND content_type = 'comment' AND parent_id = '".$comment->comment_post_ID."' ORDER BY time ASC LIMIT 1" );
					
					// update new rows
					$wpdb->update( $wpdb->prefix. "livenotifications", array( 'userid_subj' => $userid, 'content_id' => $comment_ID, 'content_text' => $post_info->post_title, 'is_read' => 0, 'time' => time(), 'additional_subj' => '-2', 'username' => $commenter_2 ), array( 'id' => $selection->id ) );
				}elseif( $notification_count > 1){
					// delete rows ids
					$wpdb->query("DELETE FROM " .$wpdb->prefix. "livenotifications WHERE userid='".$post_info->post_author."' AND content_type = 'comment' AND parent_id = '".$comment->comment_post_ID."' AND id NOT IN ( ".$selected_id." )");
					
					// select last id
					$selection = $wpdb->get_row( "SELECT id FROM " .$wpdb->prefix. "livenotifications WHERE userid = '".$post_info->post_author."' AND content_type = 'comment' AND parent_id = '".$comment->comment_post_ID."' ORDER BY time ASC LIMIT 1" );
					// update new rows
					$wpdb->update( $wpdb->prefix. "livenotifications", array( 'userid_subj' => $userid, 'content_id' => $comment_ID, 'content_text' => $post_info->post_title, 'is_read' => 0, 'time' => time(), 'additional_subj' => '-2', 'username' => $commenter_2 ), array( 'id' => $selection->id ) );
				}else{
					// insert into live notifications table
					$wpdb->query("INSERT INTO " . $wpdb->prefix . "livenotifications (id,userid,userid_subj,content_type,content_id,parent_id,content_text,is_read,time,additional_subj,username) 
					VALUES (NULL, '".$post_info->post_author."', '".$userid."', 'comment', '".$comment_ID."', '".$comment->comment_post_ID."', '".$post_info->post_title."', '0', '".time()."', '-2', '".$commenter_2."')");
				}
			}elseif( $comment_count == 3 ){
				if( $notification_count == 1){
					// select last id
					$selection = $wpdb->get_row( "SELECT id FROM " .$wpdb->prefix. "livenotifications WHERE userid = '".$post_info->post_author."' AND content_type = 'comment' AND parent_id = '".$comment->comment_post_ID."' ORDER BY time ASC LIMIT 1" );
					
					// update new rows
					$wpdb->update( $wpdb->prefix. "livenotifications", array( 'userid_subj' => $userid, 'content_id' => $comment_ID, 'content_text' => $post_info->post_title, 'is_read' => 0, 'time' => time(), 'additional_subj' => '-3', 'username' => $commenter_2 ), array( 'id' => $selection->id ) );
				}elseif( $notification_count > 1){
					// delete rows ids
					$wpdb->query("DELETE FROM " .$wpdb->prefix. "livenotifications WHERE userid='".$post_info->post_author."' AND content_type = 'comment' AND parent_id = '".$comment->comment_post_ID."' AND id NOT IN ( ".$selected_id." )");
					
					// select last id
					$selection = $wpdb->get_row( "SELECT id FROM " .$wpdb->prefix. "livenotifications WHERE userid = '".$post_info->post_author."' AND content_type = 'comment' AND parent_id = '".$comment->comment_post_ID."' ORDER BY time ASC LIMIT 1" );
					// update new rows
					$wpdb->update( $wpdb->prefix. "livenotifications", array( 'userid_subj' => $userid, 'content_id' => $comment_ID, 'content_text' => $post_info->post_title, 'is_read' => 0, 'time' => time(), 'additional_subj' => '-3', 'username' => $commenter_2 ), array( 'id' => $selection->id ) );
				}else{
					// insert into live notifications table
					$wpdb->query("INSERT INTO " . $wpdb->prefix . "livenotifications (id,userid,userid_subj,content_type,content_id,parent_id,content_text,is_read,time,additional_subj,username) 
					VALUES (NULL, '".$post_info->post_author."', '".$userid."', 'comment', '".$comment_ID."', '".$comment->comment_post_ID."', '".$post_info->post_title."', '0', '".time()."', '-3', '".$commenter_2."')");
				}
			}elseif( $comment_count > 3 ){
				// commwnts count without three users 
				$comment_final = ( $comment_count - 3 );
				if( $notification_count == 1){
					// select last id
					$selection = $wpdb->get_row( "SELECT id FROM " .$wpdb->prefix. "livenotifications WHERE userid = '".$post_info->post_author."' AND content_type = 'comment' AND parent_id = '".$comment->comment_post_ID."' ORDER BY time ASC LIMIT 1" );
					
					// update new rows
					$wpdb->update( $wpdb->prefix. "livenotifications", array( 'userid_subj' => $userid, 'content_id' => $comment_ID, 'content_text' => $post_info->post_title, 'is_read' => 0, 'time' => time(), 'additional_subj' => $comment_final, 'username' => $commenter_3 ), array( 'id' => $selection->id ) );
				}elseif( $notification_count > 1){
					// delete rows ids
					$wpdb->query("DELETE FROM " .$wpdb->prefix. "livenotifications WHERE userid='".$post_info->post_author."' AND content_type = 'comment' AND parent_id = '".$comment->comment_post_ID."' AND id NOT IN ( ".$selected_id." )");
					
					// select last id
					$selection = $wpdb->get_row( "SELECT id FROM " .$wpdb->prefix. "livenotifications WHERE userid = '".$post_info->post_author."' AND content_type = 'comment' AND parent_id = '".$comment->comment_post_ID."' ORDER BY time ASC LIMIT 1" );
					// update new rows
					$wpdb->update( $wpdb->prefix. "livenotifications", array( 'userid_subj' => $userid, 'content_id' => $comment_ID, 'content_text' => $post_info->post_title, 'is_read' => 0, 'time' => time(), 'additional_subj' => $comment_final, 'username' => $commenter_3 ), array( 'id' => $selection->id ) );
				}else{
					// insert into live notifications table
					$wpdb->query("INSERT INTO " . $wpdb->prefix . "livenotifications (id,userid,userid_subj,content_type,content_id,parent_id,content_text,is_read,time,additional_subj,username) 
					VALUES (NULL, '".$post_info->post_author."', '".$userid."', 'comment', '".$comment_ID."', '".$comment->comment_post_ID."', '".$post_info->post_title."', '0', '".time()."', '".$comment_final."', '".$commenter_3."')");
				}
			}
		}
	}
	
	// reply notifiatons
	if ( ($comment_parent > 0) && ($comment_approval == 1) ){
		// get reply author
		$ln_post = $wpdb->get_row( "SELECT user_id,comment_content FROM " . $wpdb->prefix . "comments WHERE comment_ID = '".$comment_parent."'" );

		if (( $ln_post->user_id ) > 0 && ( $ln_post->user_id != $userid )){
			// notification reply count
			$notifi_reply_count = count( $wpdb->get_results( "SELECT id FROM " .$wpdb->prefix. "livenotifications WHERE userid = '".$ln_post->user_id."' AND content_type = 'reply' AND content_id = '".$comment_parent."' AND parent_id = '".$comment->comment_post_ID."' ORDER BY time DESC" ) );
	
        	// select id from notification
			$sel_rly_id = $wpdb->get_row( "SELECT id FROM " . $wpdb->prefix . "livenotifications WHERE userid = '".$ln_post->user_id."' AND content_type = 'reply' AND content_id = '".$comment_parent."' AND parent_id = '".$comment->comment_post_ID."' ORDER BY time DESC LIMIT 1" );
			$select_r_id = $sel_rly_id->id;

			// count total comments excule author
			$reply_count = count( $wpdb->get_results( "select com2.comment_ID, com2.comment_author, com2.user_id, com2.comment_content, com2.comment_date from " . $wpdb->prefix . "comments as com2 WHERE com2.comment_ID IN ( select Max(com.comment_ID) from " . $wpdb->prefix . "comments as com where com.comment_parent = '".$comment_parent."' AND com.user_id != '".$ln_post->user_id."' AND com.comment_approved = 1 GROUP BY com.user_id ) ORDER BY com2.comment_ID DESC" ) );

			// get reply exclude author (2) - user
			$repliers_2 = $wpdb->get_results( "select com2.comment_ID, com2.comment_author, com2.user_id, com2.comment_content, com2.comment_date from " . $wpdb->prefix . "comments as com2 WHERE com2.comment_ID IN ( select Max(com.comment_ID) from " . $wpdb->prefix . "comments as com where com.comment_parent = '".$comment_parent."' AND com.user_id != '".$ln_post->user_id."' AND com.comment_approved = 1 GROUP BY com.user_id ) ORDER BY com2.comment_ID DESC LIMIT 2" );
			foreach( $repliers_2 as $ply_2 ) {
	    		$user_info_2 = get_userdata( $ply_2->user_id );
				$resultsete_2[] = ucfirst(strtolower( $user_info_2->display_name ));
			}
			$replier_2 = implode(", ", $resultsete_2);  
			
			// get reply exclude author (3) - user
			$repliers_3 = $wpdb->get_results( "select com2.comment_ID, com2.comment_author, com2.user_id, com2.comment_content, com2.comment_date from " . $wpdb->prefix . "comments as com2 WHERE com2.comment_ID IN ( select Max(com.comment_ID) from " . $wpdb->prefix . "comments as com where com.comment_parent = '".$comment_parent."' AND com.user_id != '".$ln_post->user_id."' AND com.comment_approved = 1 GROUP BY com.user_id ) ORDER BY com2.comment_ID DESC LIMIT 3" );
			foreach( $repliers_3 as $ply_3 ) {
	    		$user_info_3 = get_userdata( $ply_3->user_id );
				$resultsete_3[] = ucfirst(strtolower( $user_info_3->display_name ));
			}
			$replier_3 = implode(", ", $resultsete_3);  
			
			if( $reply_count == 1 ){
				if( $notifi_reply_count == 1){
					// select last id
					$selections = $wpdb->get_row( "SELECT id FROM " .$wpdb->prefix. "livenotifications WHERE userid = '".$ln_post->user_id."' AND content_type = 'reply' AND content_id = '".$comment_parent."' AND parent_id = '".$comment->comment_post_ID."' ORDER BY time ASC LIMIT 1" );

					// update new rows
					$wpdb->update( $wpdb->prefix. "livenotifications", array( 'userid_subj' => $userid, 'content_text' => $$comment_ID.",".$comment->comment_content, 'is_read' => 0, 'time' => time(), 'additional_subj' => 0, 'username' => $commenter_name ), array( 'id' => $selections->id ) );
				}elseif( $notifi_reply_count > 1){
					// delete rows ids
					$wpdb->query("DELETE FROM " .$wpdb->prefix. "livenotifications WHERE userid='".$ln_post->user_id."' AND content_type = 'reply' AND content_id = '".$comment_parent."' AND parent_id = '".$comment->comment_post_ID."' AND id NOT IN ( ".$select_r_id." )");
					// select last id
					$selections = $wpdb->get_row( "SELECT id FROM " .$wpdb->prefix. "livenotifications WHERE userid = '".$ln_post->user_id."' AND content_type = 'reply' AND content_id = '".$comment_parent."' AND parent_id = '".$comment->comment_post_ID."' ORDER BY time ASC LIMIT 1" );

					// update new rows
					$wpdb->update( $wpdb->prefix. "livenotifications", array( 'userid_subj' => $userid, 'content_text' => $comment_ID.",".$comment->comment_content, 'is_read' => 0, 'time' => time(), 'additional_subj' => 0, 'username' => $commenter_name ), array( 'id' => $selections->id ) );
				}else{
					// insert into live notifications table
					$wpdb->query("INSERT INTO " . $wpdb->prefix . "livenotifications (id,userid,userid_subj,content_type,content_id,parent_id,content_text,is_read,time,additional_subj,username) 
					VALUES (NULL, '".$ln_post->user_id."', '".$userid."', 'reply', '".$comment_parent."', '".$comment->comment_post_ID."', '".$comment_ID.",".$comment->comment_content."', '0', '".time()."', '0', '".$commenter_name."')");
	       		}
			}elseif( $reply_count == 2 ){
				if( $notifi_reply_count == 1){
					// select last id
					$selections = $wpdb->get_row( "SELECT id FROM " .$wpdb->prefix. "livenotifications WHERE userid = '".$ln_post->user_id."' AND content_type = 'reply' AND content_id = '".$comment_parent."' AND parent_id = '".$comment->comment_post_ID."' ORDER BY time ASC LIMIT 1" );

					// update new rows
					$wpdb->update( $wpdb->prefix. "livenotifications", array( 'userid_subj' => $userid, 'content_text' => $comment_ID.",".$comment->comment_content, 'is_read' => 0, 'time' => time(), 'additional_subj' => -2, 'username' => $replier_2 ), array( 'id' => $selections->id ) );
				}elseif( $notifi_reply_count > 1){
					// delete rows ids
					$wpdb->query("DELETE FROM " .$wpdb->prefix. "livenotifications WHERE userid='".$ln_post->user_id."' AND content_type = 'reply' AND content_id = '".$comment_parent."' AND parent_id = '".$comment->comment_post_ID."' AND id NOT IN ( ".$select_r_id." )");
					// select last id
					$selections = $wpdb->get_row( "SELECT id FROM " .$wpdb->prefix. "livenotifications WHERE userid = '".$ln_post->user_id."' AND content_type = 'reply' AND content_id = '".$comment_parent."' AND parent_id = '".$comment->comment_post_ID."' ORDER BY time ASC LIMIT 1" );

					// update new rows
					$wpdb->update( $wpdb->prefix. "livenotifications", array( 'userid_subj' => $userid, 'content_text' => $comment_ID.",".$comment->comment_content, 'is_read' => 0, 'time' => time(), 'additional_subj' => -2, 'username' => $replier_2 ), array( 'id' => $selections->id ) );
				}else{
					// insert into live notifications table
					$wpdb->query("INSERT INTO " . $wpdb->prefix . "livenotifications (id,userid,userid_subj,content_type,content_id,parent_id,content_text,is_read,time,additional_subj,username) 
					VALUES (NULL, '".$ln_post->user_id."', '".$userid."', 'reply', '".$comment_parent."', '".$comment->comment_post_ID."', '".$comment_ID.",".$comment->comment_content."', '0', '".time()."', '-2', '".$replier_2."')");
				}
			}elseif( $reply_count == 3 ){
				if( $notifi_reply_count == 1){
					// select last id
					$selections = $wpdb->get_row( "SELECT id FROM " .$wpdb->prefix. "livenotifications WHERE userid = '".$ln_post->user_id."' AND content_type = 'reply' AND content_id = '".$comment_parent."' AND parent_id = '".$comment->comment_post_ID."' ORDER BY time ASC LIMIT 1" );

					// update new rows
					$wpdb->update( $wpdb->prefix. "livenotifications", array( 'userid_subj' => $userid, 'content_text' => $comment_ID.",".$comment->comment_content, 'is_read' => 0, 'time' => time(), 'additional_subj' => -3, 'username' => $replier_2 ), array( 'id' => $selections->id ) );
				}elseif( $notifi_reply_count > 1){
					// delete rows ids
					$wpdb->query("DELETE FROM " .$wpdb->prefix. "livenotifications WHERE userid='".$ln_post->user_id."' AND content_type = 'reply' AND content_id = '".$comment_parent."' AND parent_id = '".$comment->comment_post_ID."' AND id NOT IN ( ".$select_r_id." )");
					// select last id
					$selections = $wpdb->get_row( "SELECT id FROM " .$wpdb->prefix. "livenotifications WHERE userid = '".$ln_post->user_id."' AND content_type = 'reply' AND content_id = '".$comment_parent."' AND parent_id = '".$comment->comment_post_ID."' ORDER BY time ASC LIMIT 1" );

					// update new rows
					$wpdb->update( $wpdb->prefix. "livenotifications", array( 'userid_subj' => $userid, 'content_text' => $comment_ID.",".$comment->comment_content, 'is_read' => 0, 'time' => time(), 'additional_subj' => -3, 'username' => $replier_2 ), array( 'id' => $selections->id ) );
				}else{
					// insert into live notifications table
					$wpdb->query("INSERT INTO " . $wpdb->prefix . "livenotifications (id,userid,userid_subj,content_type,content_id,parent_id,content_text,is_read,time,additional_subj,username) 
					VALUES (NULL, '".$ln_post->user_id."', '".$userid."', 'reply', '".$comment_parent."', '".$comment->comment_post_ID."', '".$comment_ID.",".$comment->comment_content."', '0', '".time()."', '-3', '".$replier_2."')");
				}
			}elseif( $reply_count > 3 ){
				// commwnts count without three users 
				$reply_final = ( $reply_count - 3 );
				
				if( $notifi_reply_count == 1){
					// select last id
					$selections = $wpdb->get_row( "SELECT id FROM " .$wpdb->prefix. "livenotifications WHERE userid = '".$ln_post->user_id."' AND content_type = 'reply' AND content_id = '".$comment_parent."' AND parent_id = '".$comment->comment_post_ID."' ORDER BY time ASC LIMIT 1" );

					// update new rows
					$wpdb->update( $wpdb->prefix. "livenotifications", array( 'userid_subj' => $userid, 'content_text' => $comment_ID.",".$comment->comment_content, 'is_read' => 0, 'time' => time(), 'additional_subj' => $reply_final, 'username' => $replier_3 ), array( 'id' => $selections->id ) );
				}elseif( $notifi_reply_count > 1){
					// delete rows ids
					$wpdb->query("DELETE FROM " .$wpdb->prefix. "livenotifications WHERE userid='".$ln_post->user_id."' AND content_type = 'reply' AND content_id = '".$comment_parent."' AND parent_id = '".$comment->comment_post_ID."' AND id NOT IN ( ".$select_r_id." )");
					// select last id
					$selections = $wpdb->get_row( "SELECT id FROM " .$wpdb->prefix. "livenotifications WHERE userid = '".$ln_post->user_id."' AND content_type = 'reply' AND content_id = '".$comment_parent."' AND parent_id = '".$comment->comment_post_ID."' ORDER BY time ASC LIMIT 1" );

					// update new rows
					$wpdb->update( $wpdb->prefix. "livenotifications", array( 'userid_subj' => $userid, 'content_text' => $comment_ID.",".$comment->comment_content, 'is_read' => 0, 'time' => time(), 'additional_subj' => $reply_final, 'username' => $replier_3 ), array( 'id' => $selections->id ) );
				}else{
					// insert into live notifications table
					$wpdb->query("INSERT INTO " . $wpdb->prefix . "livenotifications (id,userid,userid_subj,content_type,content_id,parent_id,content_text,is_read,time,additional_subj,username) 
					VALUES (NULL, '".$ln_post->user_id."', '".$userid."', 'reply', '".$comment_parent."', '".$comment->comment_post_ID."', '".$comment_ID.",".$comment->comment_content."', '0', '".time()."', '".$reply_final."', '".$replier_3."')");
				}
			}
		}
	}
}


function ln_remove_post_notifications($post_ID){
	ln_add_post_notifications($post_ID, 0);
}

function ln_add_post_notifications($post_ID, $status = 1){
	global $wpdb;

	if(!$post_info = get_post($post_ID))
		return false;
	if($post_info->post_type != 'post') return; 
	$userid = $post_info->post_author;
	$poster_name = $wpdb->get_var("SELECT display_name FROM $wpdb->users WHERE ID = $userid");

	$post_date = strtotime($post_info->post_date);
}

//comment user detail jayesh
function ln_add_userdetail($post_ID){
	global $wpdb;

	if(!$post_info = get_post($post_ID))return false;
	if($post_info->post_type != 'post') return; 
	
	$userid = $post_info->post_author;
	$poster_name = $wpdb->get_var("SELECT display_name FROM $wpdb->users WHERE ID = $userid");

	$post_date = strtotime($post_info->post_date);
	$post_status=$post_info->post_status;
	
	//insert record in count_reading table jayesh
	if($post_status=='publish'){
		mysql_query("insert into ".$wpdb->prefix."count_reading (userid,postid,readtime,posttype) values('".$userid."','".$post_ID."','".$post_date."','post')");
	
	$count_post = mysql_query("select * from ".$wpdb->prefix."count_reading where userid='".$userid."' and  posttype='post'");
	
	//get reward system data
	$getpostreward=mysql_query("select * from ".$wpdb->prefix."rewardsystem where type='post' ORDER BY `reid` ASC");
	while($getpostrewardrec=$getpostreward){
		$numlist=$getpostrewardrec['numlist'];
		$repoint=$getpostrewardrec['repoint'];
		$reorder=$getpostrewardrec['reorder'];
		$type=$getpostrewardrec['type'];
		$retitle=$getpostrewardrec['retitle'];
		$rentc=$getpostrewardrec['rentc'];
		$remsg=$getpostrewardrec['remsg'];
		$reid=$getpostrewardrec['reid'];
	
		if($numlist==$count_post){
			//insert into point table
			$countpoints=mysql_query("insert into ".$wpdb->prefix."countpoints (cp_uid,cp_nbid,cp_pmid,cp_points,cp_time,cp_tasklist) values('".$userid."','".$post_ID."','".$repoint."','".$post_date."','".$reorder."')");
			$selectorder=mysql_query("select cp_tasklist from ".$wpdb->prefix."countpoints where cp_uid='".$userid."'");
			if(mysql_num_rows($selectorder)>0){
				$reclist=0;
				while($selectorderrec=mysql_fetch_array($selectorder)){
					if($reclist==0){
		     			$order .="reorder!=".$selectorderrec['cp_tasklist'];
					}else{
			    		$order .=" and reorder!=".$selectorderrec['cp_tasklist'];
					}
		     		$reclist++;
				}
			}else{
				$order="1=1";
			}
			$selectdata1=mysql_query("select * from ".$wpdb->prefix."rewardsystem where ".$order." ORDER BY reorder ASC");
			$rank=mysql_fetch_array($selectdata1);
			$rank_next=$rank['numlist'].' '.$rank['type'];
			
			//insert into livenotification table
			$selectoption=mysql_query("select enable_award from ".$wpdb->prefix."livenotifications_usersettings where userid='".$userid."'");
			if(mysql_num_rows($selectoption)>0){
				$selectoptionrec=mysql_fetch_array($selectoption);
				$award=$selectoptionrec['enable_award'];
			}else{
				$options = get_option('ln_options');
				$award=$options['enable_award'];
				if($award=='on'){
					$award='1';
				}else{
					$award='0';
				}
			}
			if($award=='1'){
	         	$livesnotificationtable=mysql_query("insert into ".$wpdb->prefix."livenotifications (userid,userid_subj,content_type,content_id,content_text,is_read,time,username) values('".$userid."','".$userid."','postaward','".$reid."','".$rentc."','".$remsg."','0','".time()."','".$rank_next."')");
			}
		}
	}}
}
function ln_add_userdetail_comment($comment_ID){
	global $wpdb;

	if(!$post_info = get_comment($comment_ID)) return false;
	
	$commmentpostid = $post_info->comment_post_ID;
	$commentauthor=$post_info->comment_author;
	$current_user = wp_get_current_user();
	$userid=$current_user->ID;
	$post_date = strtotime($post_info->comment_date);
	$post_status=$post_info->post_status;
	
	//insert record in count_reading table jayesh
	mysql_query("insert into ".$wpdb->prefix."count_reading (userid,postid,readtime,posttype) values('".$userid."','".$commmentpostid."','".$post_date."','comment')");
	$count_post=mysql_num_rows(mysql_query("select * from ".$wpdb->prefix."count_reading where userid='".$userid."' and posttype='comment'"));
	
	$getpostreward=mysql_query("select * from ".$wpdb->prefix."rewardsystem where type='comment' ORDER BY `reid` ASC");
	while($getpostrewardrec=mysql_fetch_array($getpostreward)){
		$numlist=$getpostrewardrec['numlist'];
		$repoint=$getpostrewardrec['repoint'];
		$reorder=$getpostrewardrec['reorder'];
		$type=$getpostrewardrec['type'];
		$retitle=$getpostrewardrec['retitle'];
		$rentc=$getpostrewardrec['rentc'];
		$remsg=$getpostrewardrec['remsg'];
		$reid=$getpostrewardrec['reid'];
		if($count_post==$numlist){
			
		//insert into point table
		$countpoints=mysql_query("insert into ".$wpdb->prefix."countpoints (cp_uid,cp_nbid,cp_pmid,cp_points,cp_time,cp_tasklist) values('".$userid."','".$commmentpostid."','".$repoint."','".$post_date."','".$reorder."')");
		
			$selectorder=mysql_query("select cp_tasklist from ".$wpdb->prefix."countpoints where cp_uid='".$userid."'");
			if(mysql_num_rows($selectorder)>0){
			$reclist=0;
			while($selectorderrec=mysql_fetch_array($selectorder)){
				if($reclist==0){
					$order .="reorder!=".$selectorderrec['cp_tasklist'];
				}else{
					$order .=" and reorder!=".$selectorderrec['cp_tasklist'];
				}
				$reclist++;
			}
			}else{
				$order="1=1";
			}
			$selectdata1=mysql_query("select * from ".$wpdb->prefix."rewardsystem where ".$order." ORDER BY reorder ASC");
			$rank=mysql_fetch_array($selectdata1);
			$rank_next=$rank['numlist'].' '.$rank['type'];
			$selectoption=mysql_query("select enable_award from ".$wpdb->prefix."livenotifications_usersettings where userid='".$userid."'");
			if(mysql_num_rows($selectoption)>0){
				$selectoptionrec=mysql_fetch_array($selectoption);
				$award=$selectoptionrec['enable_award'];
			}else{
				$options = get_option('ln_options');
				$award=$options['enable_award'];
				if($award=='on'){
					$award='1';
				}else{
					$award='0';
				}
			}
			
			if($award=='1'){
	        	//insert into livenotification table
	           	$livesnotificationtable=mysql_query("insert into ".$wpdb->prefix."livenotifications (userid,userid_subj,content_type,content_id,content_text,is_read,time,username) values('".$userid."','".$userid."','commentaward','".$reid."','".$rentc."','".$remsg."','0','".time()."','".$rank_next."')");
			}
		}
	}
}

//This function will create new database fields with default values
function ln_defaults(){
	$default = array(
	    'enable_comment' => true,
	    'enable_reply' => true,
		'enable_award' => true,
		'enable_moderation' => true,
		'enable_taguser' => true,
    	'enable_nb' => true,
    	'enable_pm' => true,
		'update_interval' => 15,		
	    'max_notifications_count' => 7,	
	   	'cut_strlen' => 80,
    	'hide_avatar' => false,
	    'ln_avatar_height' => 40,
	    'ln_default_avatar' => 'get_template_directory_uri()."/images/avatar.png"',
	    'max_age' => 7,
	    'ln_enable_userdropdown' => true,
	    'ln_enable_userdropdown_logout' => true,
		'ln_enable_award_link'=> true,
		'ln_bmpopup'=>' enable',
		'ln_udd_morelinks' => 'Notifications Settings => notification'
	);
return $default;
}

function ln_notifications_overview(){
	global $current_user;
	if ( current_user_can('administrator') && is_user_logged_in()){?>
	    <div class="notification_line">
		    <?php echo ln_fetch_notifications_only($current_user->ID, 0, 15,true,'comment,moderation');?>
		</div>
    	<?php if ( $_GET['loading'] == 'more' ){?>
	       <div class="notification_line sec">
			    <?php echo ln_fetch_notifications_only($current_user->ID, 15, 30,true,'comment,moderation');?>
			</div>
	    <?php }elseif(ln_fetch_notifications_only($current_user->ID, 15, 15,true,'comment,moderation')){ 
	       	global $wpdb;
			$options1 = get_option('ln_options1'); 
			$url1 = $options1["plink_noti"];
		?>
		<a class="update_val" id="rel" href="<?php echo $url1 .'?loading=more' ?>"><?php _e("See More Notifications",'tie'); ?></a>
		<?php 
		}
	}elseif( is_user_logged_in()){?>
	        <div class="notification_line">
			    <?php echo ln_fetch_notifications_only($current_user->ID, 0, 12,true,'comment,moderation');?>
			</div>
		<?php if ( $_GET['loading'] == 'more' ){?>
	       <div class="notification_line sec">
			    <?php echo ln_fetch_notifications_only($current_user->ID, 12, 23,true,'comment,moderation');?>
			</div>
	    <?php }elseif(ln_fetch_notifications_only($current_user->ID, 12, 12,true,'comment,moderation')){ 
	       	global $wpdb;
			$options1 = get_option('ln_options1'); 
			$url1 = $options1["plink_noti"];
		?>
		<a class="update_val" href="<?php echo $url1 .'?loading=more' ?>"><?php _e("See More Notifications",'tie'); ?></a>
		<?php 
		}
	}
	else { 
    	global $wp;
		$options1 = get_option('ln_options1'); 
		$url1 = $options1["plink_noti"]; 
		wp_redirect( wp_login_url( $url1 ) ); 
		exit;
 	} 
}
add_shortcode( 'ln_notifications_overview', 'ln_notifications_overview' );

// Runs notification activated and creates new database field
function ln_ntcv_install(){
    add_option('ln_options', ln_defaults());
    create_tables();
}	
add_action('after_setup_theme', 'ln_ntcv_install');

function create_tables(){
	global $wpdb;
	$wpdb->query("
		CREATE TABLE IF NOT EXISTS `".$wpdb->prefix."livenotifications` (
		  `id` int(11) NOT NULL auto_increment,
		  `userid` int(11) NOT NULL,
		  `userid_subj` int(11) NOT NULL,
		  `content_type` varchar(64) NOT NULL,
		  `content_id` int(11) NOT NULL,
		  `parent_id` int(11) NOT NULL,
		  `content_text` varchar(200) NOT NULL,
		  `is_read` int(11) NOT NULL,
		  `time` varchar(32) NOT NULL,
		  `additional_subj` int(11) NOT NULL,
		  `username` varchar(64) NOT NULL,
		  PRIMARY KEY  (`id`)
		) COLLATE utf8_general_ci;
	");
	$wpdb->query('
		CREATE TABLE IF NOT EXISTS ' . $wpdb->prefix . 'pm (
			`id` bigint(20) NOT NULL auto_increment,
			`subject` text NOT NULL,
			`content` text NOT NULL,
			`sender` varchar(60) NOT NULL,
			`recipient` varchar(60) NOT NULL,
			`date` datetime NOT NULL,
			`read` tinyint(1) NOT NULL,
			`deleted` tinyint(1) NOT NULL,
			PRIMARY KEY (`id`)
		) COLLATE utf8_general_ci;'
	);
	

//Welcome Notification for New User
if ( is_user_logged_in() ){
	$current_user = wp_get_current_user();
	$c_r_id = $current_user->ID;
	$c_r_dn = $current_user->display_name;
	$total_nfication = $wpdb->get_var( 'SELECT COUNT(*) FROM ' . $wpdb->prefix . 'livenotifications WHERE `userid` = "'.$c_r_id.'"' );
	if( $total_nfication < 1 ){
		$wpdb->query("INSERT INTO " . $wpdb->prefix . "livenotifications (id,userid,userid_subj,content_type,content_id,parent_id,content_text,is_read,time,additional_subj,username) 
		VALUES (NULL, '".$c_r_id."','1','nb','20','0', 'Welcome to ".get_bloginfo('name')."','0','".time()."','0', '".$c_r_dn."')");
	}
}


//Sensitive area
$wpdb->query("CREATE TRIGGER `livenotification` AFTER INSERT ON `".$wpdb->prefix."comments` FOR EACH ROW IF (INSTR(new.comment_agent, 'Disqus'))
    THEN  insert into ".$wpdb->prefix."livenotifications (userid,userid_subj,content_type,content_id,parent_id,content_text,is_read,time,username) 
	values ((select post_author from ".$wpdb->prefix."posts where ID=new.comment_post_ID),new.user_id,'comment',new.comment_ID,new.comment_post_ID,(select post_title from ".$wpdb->prefix."posts where ID=new.comment_post_ID),'0',UNIX_TIMESTAMP(),new.comment_author);
    END IF");
	//create dynamic pages at the time of plugin installation
	// Create post object
	
$pagesendmsg = get_page_by_title( 'Item Panel' );
	if($pagesendmsg==""){
		$my_post = array(
		  'post_title'    => 'Item Panel',
		  'page_template'  => 'template-panel.php',
		  'post_type'     => 'page',
		  'post_status'   => 'publish',
		  'post_author'   => 1,
		  'post_category' => '',
		  'comment_status' => 'closed',
		  'ping_status'    => 'closed'
		);
		
		// Insert the post into the database
		$pagesendmsg = wp_insert_post( $my_post );
	}
$permalink = get_permalink($pagesendmsg);


$pagedash = get_page_by_title( 'Mobile Dashboard' );
	if($pagedash==""){
		$my_post1 = array(
		'post_title'    => 'Mobile Dashboard',
		'page_template'  => 'template-mobile-dashboard.php',
		'post_type'     => 'page',
		'post_status'   => 'publish',
		'post_author'   => 1,
		'post_category' => '',
		'comment_status' => 'closed',
		'ping_status'    => 'closed'
		);
		
		// Insert the post into the database
		$pagedash = wp_insert_post( $my_post1 );
	}
$permalink1 = get_permalink( $pagedash);	

$pagenotification = get_page_by_title( 'Notification' );
	if($pagenotification==""){
		$my_post2 = array(
		'post_title'    => 'Notification',
		'page_template'  => 'template-notification.php',
		'post_type'     => 'page',
		'post_status'   => 'publish',
		'post_author'   => 1,
		'post_category' => '',
		'comment_status' => 'closed',
		'ping_status'    => 'closed'
		);
		
		// Insert the post into the database
		$pagenotification=wp_insert_post( $my_post2 );
	}
$permalink2 = get_permalink( $pagenotification);

$update_val = array(
    'plink_sendmsg' => $permalink,
	'plink_dash' => $permalink1,
	'plink_noti' => $permalink2
);
update_option('ln_options1', $update_val);
}

function drop_tables(){
	global $wpdb;
	$wpdb->query("
		DROP TABLE IF EXISTS `" .$wpdb->prefix. "livenotifications`
	");
	$wpdb->query("
		DROP TABLE IF EXISTS `" .$wpdb->prefix. "pm`
	");
}

if(isset($_POST['ln_update4'])){
	$selectuser = mysql_query("select * from " .$wpdb->prefix. "users where ID!='1'");
	
	if(mysql_num_rows($selectuser)>0){
		while($selectuserrec=mysql_fetch_array($selectuser)){
			$insert_record1=mysql_query("insert into " .$wpdb->prefix. "livenotifications (userid,userid_subj,content_type,content_id,parent_id,content_text,is_read,time,additional_subj,username) values('".$selectuserrec['ID']."','1','adminnotification','0','0','".$_POST['notification']."','0','".time()."','".$_POST['noti_time']."','admin')");
		}
		$_SESSION['succ']="Notification Added Successfully";
	}
}

//add award detail
if(isset($_POST['ln_update5'])){	
	$insert_record1=mysql_query("update ".$wpdb->prefix. "rewardsystem set rew_image='".$_POST['rew_image']."',numlist='".$_POST['numlist']."',type='".$_POST['type']."',retitle='".$_POST['retitle']."',rentc='".$_POST['rentc']."',remsg='".$_POST['remsg']."',repoint='".$_POST['repoint']."',reorder='".$_POST['reorder']."' where reid='".$_POST['updateid']."'");
	
	echo '<meta http-equiv="refresh" content="0; url='.admin_url( 'admin.php?page=ln_backend_menu', 'http' ).'/">';
	exit;
}

// update the ln_livenotifications options
if(isset($_POST['ln_update'])){
	update_option('ln_options', ln_updates());
}

function ln_updates(){
	$options = $_POST['ln_options'];
	$update_val = array(
	    'update_interval' => $options['update_interval'],
	    'max_notifications_count' => $options['max_notifications_count'],
	   	'cut_strlen' => $options['cut_strlen'],
		'enable_comment' => $options['enable_comment'],
	    'enable_reply' => $options['enable_reply'],
		'enable_award' => $options['enable_award'],
		'enable_moderation' => $options['enable_moderation'],
		'enable_taguser' => $options['enable_taguser'],
    	'enable_nb' => $options['enable_nb'],
    	'enable_pm' => $options['enable_pm'],
	    'hide_avatar' => $options['hide_avatar'],
		'ln_avatar_height' => $options['ln_avatar_height'],
		'ln_default_avatar' => $options['ln_default_avatar'],
		'max_age' => $options['max_age'],
		'ln_enable_userdropdown' => $options['ln_enable_userdropdown'],
		'ln_enable_award_link' =>$options['ln_enable_award_link'],
		'ln_udd_morelinks' => $options['ln_udd_morelinks'],
		'ln_bmpopup'=>$options['ln_bmpopup']
    );
	return $update_val;
}

function ln_backend_menu(){
	global $wpdb;
	wp_nonce_field('update-options'); 
	$options = get_option('ln_options'); 
	$options1 = get_option('ln_options1'); 
?>
<div class="postbox" id="ln_admin">
<?php if((isset($_GET['task'])=='delete') && isset($_GET['id1'])){
	mysql_query("delete from ".$wpdb->prefix."eventodropdown where id='".$_GET['id1']."'");	
	echo '<meta http-equiv="refresh" content="0; url='.admin_url( 'admin.php?page=ln_backend_menu', 'http' ).'/">';
}

if((isset($_GET['task'])=='delete') && isset($_GET['deleteid'])){
	mysql_query("delete from ".$wpdb->prefix."rewardsystem where reid='".$_GET['deleteid']."'");	
	echo '<meta http-equiv="refresh" content="0; url='.admin_url( 'admin.php?page=ln_backend_menu', 'http' ).'/">';
	exit;
}

if((isset($_GET['task'])=='update') && isset($_GET['id'])){
	$selectrecforup=mysql_fetch_array(mysql_query("select * from ".$wpdb->prefix."eventodropdown where id='".$_GET['id']."'"));	
}

if((isset($_GET['task'])=='update') && isset($_GET['editid'])){
	$selectrecforreward=mysql_fetch_array(mysql_query("select * from ".$wpdb->prefix."rewardsystem where reid='".$_GET['editid']."'"));
}
?>
<br />
<?php
	$selectdata=mysql_query("select * from ".$wpdb->prefix."eventodropdown");
	if(mysql_num_rows($selectdata)>0){
		echo '<table border="1"><tr>';
		echo '<td width="20%" align="center">Logo Url</td><td width="20%" align="center">Name For Link</td><td width="20%" align="center">Logo Order</td><td width="20%" align="center">Logo Link</td><td width="20%" align="center">Action</td></tr>';
		while($selectrec=mysql_fetch_array($selectdata)){
			echo '<tr><td align="center"><img src='.$selectrec['logourl'].' width="50"  height="50"></td><td align="center">'.$selectrec['linkname'].'</td><td align="center">'.$selectrec['order1'].'</td><td>'.$selectrec['link'].'</td><td><a href="?page=ln_backend_menu&id='.$selectrec['id'].'&task=update">Edit</a>&nbsp;&nbsp;<a href="?page=ln_backend_menu&id1='.$selectrec['id'].'&task=delete">Delete</a></td></tr>';
		}
		echo '</table>';
	}
	?>
</div>

<div class="postbox" id="ln_admin">
  <?php 
		if(isset($_SESSION['succ']))
		{
			echo $_SESSION['succ'];
			unset($_SESSION['succ']);
		}

?>
  
</div>
<div class="wrap">
  <div id="icon-themes" class="icon32"></div>
  <h2>Reward and Point System</h2>
</div>
<div class="postbox" id="ln_admin">
 <strong> <?php 
		if(isset($_SESSION['succ']))
		{
			echo $_SESSION['succ'];
			unset($_SESSION['succ']);
		}
			if(isset($_SESSION['error']))
		{
			echo $_SESSION['error'];
			unset($_SESSION['error']);
		}

?></strong>
  <form method="post">
    <table id="evento"  style="width:950px !important;">
      <tr>
        <td><?php _e("Reward Title", 'ln_livenotifications'); ?>
          :</td>
        <td><input type="text" id="retitle" name="retitle" value="<?php echo $selectrecforreward['retitle']; ?>"/></td>
      </tr>
      <tr>
        <td><?php _e("Reward Accomplishment", 'ln_livenotifications'); ?>
          :</td>
        <td><input type="text" id="numlist" name="numlist" value="<?php echo $selectrecforreward['numlist']; ?>"/>
          <select name="type" id="type">
            <option value="post" <?php if($selectrecforreward['type']=='post'){ ?> selected="selected" <?php }?>>post</option>
            <option value="notice" <?php if($selectrecforreward['type']=='notice'){ ?> selected="selected" <?php }?>>notice sent</option>
            <option value="message" <?php if($selectrecforreward['type']=='message'){ ?> selected="selected" <?php }?>>message sent</option>
            <option value="comment" <?php if($selectrecforreward['type']=='comment'){ ?> selected="selected" <?php }?>>comment</option>
            <option value="readpost" <?php if($selectrecforreward['type']=='readpost'){ ?> selected="selected" <?php }?>>readpost</option>
          </select></td>
      </tr>
      <tr>
        <td><?php _e("Reward notice", 'ln_livenotifications'); ?>
          :</td>
        <td><textarea name="rentc" id="rentc"><?php echo $selectrecforreward['rentc']; ?></textarea></td>
      </tr>
      <tr>
        <td><?php _e("Reward Message", 'ln_livenotifications'); ?>
          :</td>
        <td><textarea name="remsg" id="remsg"><?php echo $selectrecforreward['remsg']; ?></textarea></td>
      </tr>
      <tr>
        <td><?php _e("Reward Point", 'ln_livenotifications'); ?>
          :</td>
        <td><input type="text" id="repoint" name="repoint" value="<?php echo $selectrecforreward['repoint']; ?>"/></td>
      </tr>
      <tr>
        <td><?php _e("Reward Order", 'ln_livenotifications'); ?>
          :</td>
        <td><input type="text" id="reorder" name="reorder" value="<?php echo $selectrecforreward['reorder']; ?>" <?php if(!empty($selectrecforreward['reorder'])) { ?> readonly="readonly" <?php } ?>/></td>
      </tr>
      <tr>
        <td><?php _e("Reward Image", 'ln_livenotifications'); ?>
          :</td>
        <td><input type="text" id="rew_image" name="rew_image" value="<?php echo $selectrecforreward['rew_image']; ?>"/>
          <input id="upload_rew_image" type="button" value="Upload Image" />
          (Copy uploaded image url and paste into textbox)</td>
      </tr>
    </table>
    <?php if(!empty($selectrecforreward['reid'])) { ?>
    <p class="button-controls">
      <input type="submit" value="<?php _e('Update') ?>" class="button-primary" id="ln_update5" name="ln_update5"/>
      <input type="hidden" value="<?php echo $selectrecforreward['reid']; ?>" name="updateid"/>
    </p>
    <?php } else { ?>
    <p class="button-controls">
      <input type="submit" value="<?php _e('Save') ?>" class="button-primary" id="ln_update6" name="ln_update6"/>
    </p>
    <?php } ?>
  </form>
  <?php
		$selectrewdata=mysql_query("select * from ".$wpdb->prefix."rewardsystem");
		if(mysql_num_rows($selectrewdata)>0)
		{
			echo '<table border="1" style="width:950px;"><tr>';
			echo '<td width="10%" align="center">Reward Image</td>
				<td width="15%" align="center">Reward Title</td>
				<td width="20%" align="center">Reward notice</td>
				<td width="20%" align="center">Reward Message</td>
				<td width="10%" align="center">Reward Point</td>
				<td width="10%" align="center">Reward Order</td>
				<td width="20%" align="center">Reward Achivement</td>
				<td width="35%" align="center">Action</td></tr>';
			while($selectrewrec=mysql_fetch_array($selectrewdata))
			{
				echo '<tr>
				<td align="center"><img src='.$selectrewrec['rew_image'].' width="50"  height="50"></td>
				<td align="center">'.$selectrewrec['retitle'].'</td>
				<td align="center">'.$selectrewrec['rentc'].'</td>
				<td align="center">'.$selectrewrec['remsg'].'</td>
				<td align="center">'.$selectrewrec['repoint'].'</td>
				<td align="center">'.$selectrewrec['reorder'].'</td>
				<td align="center">'.$selectrewrec['numlist'].' '.$selectrewrec['type'].'</td>
				<td align="center"><a href="?page=ln_backend_menu&editid='.$selectrewrec['reid'].'&task=update">Edit</a>&nbsp;&nbsp;<a href="?page=ln_backend_menu&deleteid='.$selectrewrec['reid'].'&task=delete">Delete</a></td></tr>';
			}
			echo '</table>';
		}
	?>
</div>
<?php
}

if ( !function_exists('ln_login_current_url') ){
	function ln_login_current_url( $url = '' ){
		$pageURL  = force_ssl_admin() ? 'https://' : 'http://';
		$pageURL .= esc_attr( $_SERVER['HTTP_HOST'] );
		$pageURL .= esc_attr( $_SERVER['REQUEST_URI'] );

		if ($url != "nologout") {
			if (!strpos($pageURL,'_login=')) {
				$rand_string = md5(uniqid(rand(), true));
				$rand_string = substr($rand_string, 0, 10);
				$pageURL = add_query_arg('_login', $rand_string, $pageURL);
			}
		}
		return strip_tags( $pageURL );
	}
}


function ln_livenotifications(){
	$options = get_option('ln_options');
	echo '<script type="text/javascript">
			var ln_timer;
			var update_interval = '.(max(20,$options['update_interval']) * 1000).'
			var base_url = "'.get_option("siteurl").'"	;
		</script>';
	$current_user = wp_get_current_user();
	$user_id = $current_user->ID;
	$user_name = $current_user->user_login; 
	
	$ln_notificationcount = array();
	$ln_notificationcount['comment'] = ln_count_user_notifications($user_id,'comment');
	$ln_notificationcount['nb'] = ln_count_user_notifications($user_id,'nb');
	$ln_notificationcount['pm'] = ln_count_user_notifications($user_id,'pm');
	$ln_notificationcount['moderation'] = ln_count_user_notifications($user_id,'moderation');
?>
<?php 
global $wp; global $wpdb;
$options1 = get_option('ln_options1'); 
$options2 = get_option('wpc_pages'); 
$url5 = $options1["plink_dash"]; 
$redirected_ul = $url5;
$url = $options2["users"]; 
$url1 = $options1["plink_noti"]; 
$url2 = $options2["messaging"]; 
$crnt = get_current_user_id(); ?>
<div class="main_nav"><ul>
	<li><a title="Home" class="home" href="<?php echo home_url(); ?>">Home</a></li>
	<li><a onclick="ln_fetchnotifications('comment moderation',event); return true;" class="popupctrl" id="rel" href="<?php echo $url1; ?>"><?php _e( 'Notification' ) ?><?php $value1 = $ln_notificationcount['comment']; $value2 = $ln_notificationcount['moderation']; $value3 = $ln_notificationcount['nb']; $value4 = $ln_notificationcount['pm']; $result_notify = $value1 +  $value2 + $value3 + $value4; if( $result_notify > 0){?> <span style="vertical-align: bottom;background:red;font-size:smaller;color:#fff;border-radius:50%;padding: 1px 5px;" ><?php echo $result_notify; ?></span><?php } ?></a><ul style="display:none;" id="livenotifications_list"></ul><ul style="display:none;" id="livenotifications_list_moderation"></ul><ul style="display:none;" id="livenotifications_list_nb"></ul><ul style="display:none;" id="livenotifications_list_pm"></ul></li>
	<li><a title="Nessage" href="<?php echo $url2; ?>"><?php _e('Message'); ?><?php $wpchats = new wpchats; if($wpchats->get_counts('unread')>0){ ?> <span style="vertical-align: bottom;background:red;font-size:smaller;color:#fff;border-radius:50%;padding: 1px 5px;" ><?php echo $wpchats->get_counts('unread'); ?></span><?php } ?></a></li>
</ul></div>
<?php
}
add_shortcode('notification_tie', 'ln_livenotifications');
add_action('bbp_new_topic', 'send_new_topic_notification');
add_action('bbp_new_reply','send_new_reply_notification');
add_action('comment_post', 'ln_add_comment_notifications',10,2);
add_action('wp_set_comment_status', 'ln_add_comment_notifications',11,2);
add_action('after_delete_post', 'ln_remove_post_notifications',10,1);
add_action('trashed_post', 'ln_remove_post_notifications',10,1);
add_action('untrashed_post', 'ln_add_post_notifications',10,1);
add_action('wp_insert_post', 'ln_add_post_notifications',10,1);
add_action('wp_insert_post', 'ln_add_userdetail',10,1);
add_action('comment_post', 'ln_add_userdetail_comment',10,2);


function pinterest_post_page_pin_horiz() {
global $post;
/* HORIZONTAL PINTEREST BUTTON WITH COUNTER */
printf( '<div class="pinterest-posts"><a href="http://pinterest.com/pin/create/button/?url=%s&media=%s" class="pin-it-button" count-layout="horizontal">Pin It</a><script type="text/javascript" src="http://assets.pinterest.com/js/pinit.js"></script></div>', urlencode(get_permalink()), urlencode( get_post_meta($post->ID, 'thesis_post_image', true) ) );
}
add_action( 'thesis_hook_before_post_box', 'pinterest_post_page_pin_horiz' );

$ln_usersettings_cache=array();
function ln_count_user_notifications($userid,$type){
	global $wpdb;
	if($type == 'nb'){
		$cond = " AND content_type = 'nb' ";
	}
	else if($type == 'pm'){
		$cond = " AND content_type = 'pm' ";
	}
	else if($type == 'moderation'){
		$cond = " AND substring(content_type,1,4) = 'mod_'";
	}
	else {
		$cond = " AND content_type <> 'nb' AND content_type <> 'pm' AND substring(content_type,1,4) <> 'mod_'";
	}
	$sql = "SELECT COUNT(id) AS num FROM " . $wpdb->prefix . "livenotifications
		WHERE userid = " . (int)$userid . " AND is_read = 0 ".$cond;
	
	$res = $wpdb->get_row($sql);
	return (!$res || empty($res->num)) ? 0 : (int)$res->num;
}


function ln_add_user_notification($userid_cause, $userid_target, $content_type, $content_id, $content_text, $parent_id=0, $updatetime=0, $username_cause="",$status="") {
	global $wpdb, $ln_usersettings_cache;
	$prefix = "";
	if(strlen($content_type) > 4) $prefix = substr($content_type,0,4);
	
	if (!isset($ln_usersettings_cache[$userid_target])) $ln_usersettings_cache[$userid_target] = ln_fetch_useroptions($userid_target);
	switch ($content_type){
		case 'comment':
			if (!$ln_usersettings_cache[$userid_target]['enable_comment']) return;
			break;
        case 'reply':
			if (!$ln_usersettings_cache[$userid_target]['enable_reply']) return;
			break;	
		case 'mod_comment':
			if (!$ln_usersettings_cache[$userid_target]['enable_moderation']) return;
			break;
		case 'nb':
			if (!$ln_usersettings_cache[$userid_target]['enable_nb']) return;
			break;
		case 'pm':
			if (!$ln_usersettings_cache[$userid_target]['enable_pm']) return;
			break;
		
		default:
			return;
	}

	$where = " userid = ". (int)$userid_target." AND content_type = '".$content_type."' AND content_id = " . (int)$content_id." AND parent_id = " . (int)$parent_id;
	$sql = "SELECT id, userid,userid_subj, additional_subj AS n , content_text FROM " . $wpdb->prefix . "livenotifications WHERE";
	$sql .= $where ;
	$check = $wpdb->get_row($sql);

	if($updatetime == 0) $updatetime = time();
	if ($check && !empty($check) && $check->id > 0){
		// User already has a notification about this, lets add ours
		// if awaiting moderation count is 0 then remove this notification
		// else if old count is different with new count, then update
		if($content_type == "mod_comment" ){
			if((string)$content_text == "" || (string)$content_text == "0"){
				ln_delete_onenotification($check->id);
			}
			else if($content_text != $check->content_text){
				$sql = "UPDATE " . $wpdb->prefix . "livenotifications
					SET time = '" . time() . "',
					content_text = '" . htmlspecialchars(($content_text)) . "',
					is_read = 0
					WHERE id = " . (int)$check->id;
				$wpdb->query($sql);
			}
		}
		// if status is spam, trash or delete then remove this notification
		// else update table
		else if($content_type == "comment" || $content_type == "reply"){
			if ((string)$status == "1" || (string) $status == "approve"){
				$sql = "UPDATE " . $wpdb->prefix . "livenotifications
					SET time = '" . $updatetime . ",
					content_text = '" . htmlspecialchars(($content_text)) . "'
					WHERE id = " . (int)$check->id;
				$wpdb->query($sql);
				
			}
			else{
				ln_delete_onenotification($check->id);
			}
		}
		
	}else{
		// Create new notification
		if($content_type == "mod_comment" && (string)$status != "0" && (string)$status != "hold") return;
		if($content_type == "comment" || $content_type == "reply"){
			if((string)$status != "1" && (string)$status != "approve") {
				return;
			}
		}
		
		$is_red = 0;
		if($content_type == "nb"){
			$content_text = get_excerpt($content_text,0);
		}
		if($content_type == "pm"){
			$content_text = get_excerpt($content_text,0);
		}
		
		$sql = "INSERT INTO " . $wpdb->prefix . "livenotifications
			(`userid`, `userid_subj`, `content_type`, `content_id`, `parent_id`, `content_text`, `is_read`, `time`, `additional_subj`, `username`) VALUES
			(" . (int)$userid_target
			. ", " . (int)$userid_cause
			. ", '" . $content_type
			. "', " . (int)$content_id
			. ", " .  (int)$parent_id
			. ", '" . htmlspecialchars(($content_text))
			. "', " . $is_red
			. ", '" . $updatetime
			. "', " . "0,'".$username_cause . "');";

		$wpdb->query($sql);
	}
	return true;
}

add_action('init', 's2_role_change_event_handler::init', 1);
class s2_role_change_event_handler{
    public static $user_id;
    public static $user_old_role;

    public static function init(){
        global $pagenow;

        if (!is_admin()){
            return; // Not applicable.
        }
        if ($pagenow !== 'user-edit.php'){
            return; // Not applicable.
        }
        if (empty($_REQUEST['user_id'])){
            return; // Not applicable.
        }
        if (!current_user_can('edit_users')) {
            return; // Not applicable.
        }
        $user = new WP_User((int) $_REQUEST['user_id']);

        static::$user_id       = $user->ID;
        static::$user_old_role = reset($user->roles);

        add_action('set_user_role', 's2_role_change_event_handler::event', 10, 2);
    }

    public static function event($user_id, $new_role){
        if ($user_id === static::$user_id && $new_role !== static::$user_old_role) {
            if (($user = new WP_User($user_id)) && $user->exists()) {
                global $wpdb;
				$old_role = static::$user_old_role;
				$c_old_role = ucfirst($old_role);
				$c_new_role = ucfirst($new_role);
				
				// Send Live Notifiation of Role change
				$sql = "INSERT INTO " . $wpdb->prefix . "livenotifications (id,userid,userid_subj,content_type,content_id,parent_id,content_text,is_read,time,additional_subj,username) 
				VALUES (NULL, '".$user_id."','1','nb','121','0', 'your user-role has been update ".$c_old_role." to ".$c_new_role."','0','".time()."','0', '".$user->display_name."')";
				return $wpdb->query($sql);
            }
        }
    }
}

function ln_delete_onenotification($id){
	global $wpdb;
	$sql = "DELETE FROM " . $wpdb->prefix . "livenotifications WHERE id = ".$id ;
	return $wpdb->query($sql);
}

function ln_check_newinstall($comparetime){
	global $vbulletin;
	$sql = "SELECT * FROM " . $wpdb->prefix . "livenotifications ORDER BY time limit 0,1 ";

	$ln = $vbulletin->db->query_first($sql);

	if (!empty($ln) && ($ln['time']+120) < $comparetime) return true;
	return false;
}

function ln_fetch_notifications_only($userid, $start=0, $count=-1, $full=false,$type='all' ,$is_first=true){
	global $wpdb;
	global $current_user1;
    get_currentuserinfo();
	  
	$site_url = get_option( 'siteurl' );
	$options = get_option('ln_options');
	$options1 = get_option('ln_options1');
	
	$output = '';
	
	$update_ids = array(); // ids which we will mark as read in the next step
	$override_status = array();

	if($type == 'all'){
		$cond = " ";
	}
	else if($type == 'comment'){
		$cond = " AND  l.content_type <> 'pm' AND substring(l.content_type,1,4) <> 'frie'  AND substring(l.content_type,1,4) <> 'mod_' ";
		$output = "";
	}
	else if($type == 'nb'){
		$cond = " AND l.content_type = 'nb'  AND l.userid_subj > 0 ";
		$output = "<li class='ln_title'>Private notices<a href='".$options1['plink_sendntc']."'>Send New notices</a> </li>";
		
	}else if($type == 'pm'){
		$cond = " AND l.content_type = 'pm'  AND l.userid_subj > 0 ";
		$output = "<li class='ln_title'>Private Messages<a href='".$options1['plink_sendmsg']."'>Send New Messages</a> </li>";
	}
	if($type == 'moderation'){
		$cond = " AND substring(l.content_type,1,4) = 'mod_'  ";
		$output = "<li class='ln_title'>Moderations</li>";
	}
	$sql = "SELECT l.* FROM " . $wpdb->prefix . "livenotifications AS l WHERE l.userid = " . (int)$userid . " ".$cond." ORDER BY
		l.is_read, l.time DESC
	";
	
	$res = $wpdb->get_results($sql);
	$total_numrows = count($res);
	if ($start >= 0 && $count > 0) $sql .= " LIMIT ".(int)$start.", ".(int)$count;
	$res = $wpdb->get_results($sql);
	
	if ($full && isset($_REQUEST['lntransf']) && !empty($_REQUEST['lntransf'])) {
		$override_status = explode(",",$_REQUEST['lntransf']);
		array_walk($override_status, 'intval');
	}else{
		$override_status = array();
	}
	$scrollpane_height = 230;
	
	if(!$full){
		$numrows = count($res);
		$output .= '<li style="width:330px;"><ul class="ln_scrollpane"';
		if($numrows > 4){
			$output .= ' style="height: '.$scrollpane_height.'px;"';
		}else{
			$scrollpane_height = 0;
		}
		$output .= ">";
	}

	foreach ($res as $notification){
		if (!$notification->is_read) $update_ids[] = (int)$notification->id; // Set pulled notifications as red
		
		$is_read = ($full && in_array($notification->id, $override_status)) ? false : $notification->is_read;
		
		switch ($notification->content_type) {
			case 'comment':
				
				$url = $site_url . '/' . "?p=" . $notification->parent_id."#comment-".$notification->content_id;
				$icons = '<i class="images notifications cmd"></i>';
				
				if( $notification->additional_subj == 0 ){
					$articles = ln_wrap_url( $url, $notification->content_text );
					// data for $phrase
					$cmds = "<strong>".$notification->username."</strong> commented on your post ".$articles."";
				}elseif( $notification->additional_subj == -2 ){
					$names = explode(',', $notification->username);
					$fnames = $names [0];
					$lnames = $names [1];
					$articles = ln_wrap_url( $url, $notification->content_text );
					// data for $phrase
					$cmds = "<strong>".$fnames."</strong> and <strong>".$lnames."</strong> commented on your post ".$articles."";
				}elseif( $notification->additional_subj == -3 ){
					$articles = ln_wrap_url( $url, $notification->content_text );
					// data for $phrase
					$cmds = "<strong>".$notification->username."</strong> and <strong>1</strong> others commented on your post ".$articles."";
				}else{
					$articles = ln_wrap_url( $url, $notification->content_text );
					// data for $phrase
					$cmds = "<strong>".$notification->username."</strong> and <strong>".$notification->additional_subj."</strong> others commented on your post ".$articles."";
				}
				
				$phrase = $cmds;
				break;
			
			// case reply notifications		
			case 'reply':
				
				$content_text = explode(',', $notification->content_text);
				$comments_id = $content_text [0];
				$post_title = $content_text [1];
				$url = $site_url . '/' . "?p=" . $notification->parent_id."#comment-".$comments_id;
				$icons = '<i class="images notifications rpy"></i>';
				
				if( $notification->additional_subj == 0 ){
					$titles = excerpt_text( $post_title, 80 );
					$articles = ln_wrap_url( $url, $titles, $post_title );
					
					// data for $phrase
					$reply = "<strong>".$notification->username."</strong> replied on your comment ".$articles."";
				}elseif( $notification->additional_subj == -2 ){
					$names = explode(',', $notification->username);
					$fnames = $names [0];
					$lnames = $names [1];
					$titles = excerpt_text( $post_title, 80 );
					$articles = ln_wrap_url( $url, $titles, $post_title );
					// data for $phrase
					$reply = "<strong>".$fnames."</strong> and <strong>".$lnames."</strong> replied on your comment on ".$articles."";
				}elseif( $notification->additional_subj == -3 ){
					$titles = excerpt_text( $post_title, 80 );
					$articles = ln_wrap_url( $url, $titles, $post_title );
					// data for $phrase
					$reply = "<strong>".$notification->username."</strong> and <strong>1</strong> others replied on your comment ".$articles."";
				}else{
					$titles = excerpt_text( $post_title, 80 );
					$articles = ln_wrap_url( $url, $titles, $post_title );
					// data for $phrase
					$reply = "<strong>".$notification->username."</strong> and <strong>".$notification->additional_subj."</strong> others replied on your comment ".$articles."";
				}
				
				$phrase = $reply;
				break;
				
			
			case 'nb':
				$icons = '<i class="image notifications nto"></i>';
				if($full){
					$url = $options1["plink_viewntc"];
					$phrase = sprintf("<strong>%s</strong> %s",
						$notification->username,
						$notification->content_text);
				}
				else{
					$notification_time = $notification->time;
					$phrase1 = $notification->username;
					$phrase2 = $notification->content_text;
				}
				break;
			
			case 'rp':
				$icons = '<i class="image notifications rtc"></i>';
				if($full){
					$url = $notification->content_text;
					$items = explode(',', $notification->username);
					$usernames = $items [0];
					$post_name = $items [1];
					$isses = $items [2];
					$phrase = "<strong>".$usernames."</strong> We will get ".$isses." on <a href='".$url."'><strong>".$post_name."</strong></a> post. Would you please resolved it?";
				}
				else{
					$notification_time = $notification->time;
					$phrase1 = $notification->username;
					$phrase2 = $notification->content_text;
				}
				break;
				
			case 'pm':
				$icons ='<i class="image notifications rpt"></i>';
				if($full){
					$url = $options1["plink_sendmsg"];
					$link = $url.'?page=lnpm_inbox';
					
					$phrase = sprintf("<strong>%s</strong> has reported on post: %s",
						$notification->username,
						ln_wrap_url($link, $notification->content_text));
				}
				else{
					$notification_time = $notification->time;
					$phrase1 = $notification->username;
					$phrase2 = $notification->content_text;
				}
				break;

			case 'mod_comment':
				$icons = '<i class="image notifications apr"></i>';
				$url = $site_url . '/wp-admin/edit-comments.php';
				$phrase = sprintf( __('<strong>%d</strong> comment(s) awaiting for your <a href="'.$url .'">approval</a>'), $notification->content_text );

				break;
			default:
			
			$phrase = "Has performed an unknown operation...";
		}
		$time = ln_get_timeformat($notification->time);
		
		$right_width = 260;
		$request_status_class = "request_status";
		if($options['hide_avatar']) {
			$right_width = $right_width + $options['ln_avatar_height'];
			$request_status_class = "request_status_noavatar";
		}
		
		if(($type == "nb" || $type == "pm" || $type == "moderation") && !$full){
			if($type == "nb"){
				$output .= '<li onclick="ln_show_nb_other('.$notification->content_id.',event);" class="lnnbbit '.($full ? 'livebit' : 'livenotificationbit').($is_read ? ' red">' : ' unread">')
					. $icons
					. '<div style="width:'.($right_width + 7).'px;"><div class="'.$request_status_class.'" ><p class="ln_sender_name">'
					. $phrase1
					. '</p>'
					. '<p class="ln_content">'
					. $phrase2
					. '</p>'
					. '<p class="ln_time">'.$time.'</p>'
					. '</div>
					<div class="actions"  >
						<input type="button" id="confirm" onclick="ln_nb_delete_action('.$notification->content_id.',event);" name="nb_delete" value="Delete">
					</div>
					</div><div style="clear:both;"></div>'
								. '</li></div>
					   <div style="clear:both;"></div>'
										. "\n";
				$output .= '<li class="lnnbbit livenotificationbit red ln_nb_inner_window" id="ln_nb_inner_window_'.$notification->content_id.'" style="display:none; " onclick="ln_nb_innerwindow_click(event);">'
						. '<div onclick="ln_back_to_notices('.$notification->content_id.','.$scrollpane_height.');" class="ln_link" id="ln_nb_back_'.$notification->content_id.'">Back to notices</div>'
								. $icons
								. '<div style="width:'.$right_width.'px;">
								<div class="'.$request_status_class.'" ><p class="ln_sender_name">'
								. $phrase1
								. '</p>'
								. '<p class="ln_content">'
								. $phrase2
								. '</p>'

								. '<p class="ln_time">'.$time.'</p>'
								. '</div>
					</div><div style="clear:both;"></div>
					<div style="border-top: 1px solid #DDD; margin-top: 4px;padding-top: 4px;">'
								. $icons
								. '<div style="; width: '.($right_width + 10).'px;">
								<textarea name="reply_'.$notification->content_id.'" id="reply_'.$notification->content_id.
								'" cols="40" rows="3" style="min-width:'.($right_width+5).'px;max-width:'.($right_width+5).'px;"></textarea>'
										. '<div style="clear:both;"></div>
						<div class="ln_nb_reply" >
							<input type="button" id="confirm" onclick="ln_nb_reply_action('.$notification->content_id.','.$scrollpane_height.');" name="nb_reply" value="Reply">
						</div>
						<div class="ln_nb_inbox" onclick="self.location.href=\''.$options1["plink_viewntc"].'\';">View in Inbox</div>
						</div>'
								. '</div>
					<div style="clear:both;"></div>'
										. '</li></div>
				   <div style="clear:both;"></div>'
												. "\n";
			}else if($type == "pm"){
				$output .= '<li onclick="ln_show_pm_other('.$notification->content_id.',event);" class="lnpmbit '.($full ? 'livebit' : 'livenotificationbit').($is_read ? ' red">' : ' unread">')
					. $icons
					. '<div style="width:'.($right_width + 7).'px;"><div class="'.$request_status_class.'" ><p class="ln_sender_name">'
					. $phrase1
					. '</p>'
					. '<p class="ln_content">'
					. $phrase2
					. '</p>'
					. '<p class="ln_time">'.$time.'</p>'
					. '</div>
					<div class="actions"  >
						<input type="button" id="confirm" onclick="ln_pm_delete_action('.$notification->content_id.',event);" name="pm_delete" value="Delete">
					</div>
					</div><div style="clear:both;"></div>'
								. '</li></div>
					   <div style="clear:both;"></div>'
										. "\n";
				$output .= '<li class="lnpmbit livenotificationbit red ln_pm_inner_window" id="ln_pm_inner_window_'.$notification->content_id.'" style="display:none; " onclick="ln_pm_innerwindow_click(event);">'
						. '<div onclick="ln_back_to_messages('.$notification->content_id.','.$scrollpane_height.');" class="ln_link" id="ln_pm_back_'.$notification->content_id.'">Back to Messages</div>'
								. $icons
								. '<div style="width:'.$right_width.'px;">
								<div class="'.$request_status_class.'" ><p class="ln_sender_name">'
								. $phrase1
								. '</p>'
								. '<p class="ln_content">'
								. $phrase2
								. '</p>'

								. '<p class="ln_time">'.$time.'</p>'
								. '</div>
					</div><div style="clear:both;"></div>
					<div style="border-top: 1px solid #DDD; margin-top: 4px;padding-top: 4px;">'
								. $icons
								. '<div style="; width: '.($right_width + 10).'px;">
								<textarea name="reply_'.$notification->content_id.'" id="reply_'.$notification->content_id.
								'" cols="40" rows="3" style="min-width:'.($right_width+5).'px;max-width:'.($right_width+5).'px;"></textarea>'
										. '<div style="clear:both;"></div>
						<div class="ln_pm_reply" >
							<input type="button" id="confirm" onclick="ln_pm_reply_action('.$notification->content_id.','.$scrollpane_height.');" name="pm_reply" value="Reply">
						</div>
						<div class="ln_pm_inbox" onclick="self.location.href=\''.$options1["plink_viewmsg"].'\';">View in Inbox</div>
						</div>'
								. '</div>
					<div style="clear:both;"></div>'
										. '</li></div>
				   <div style="clear:both;"></div>'
												. "\n";
			}else if($type == "moderation"){
				$output .= '<li onclick="self.location.href=\''.$url.'\';"  style="min-height:20px;" class="'.($full ? 'livebit' : 'livenotificationbit').($is_read ? ' red">' : ' unread">')
				.'<div>'
				. '<p class="ln_content">'
				. $phrase
				. '</p>'
				.'</div>
				<div style="clear:both;"></div>'
				. '</li>'
				. "\n";
			}
		}else{
			if($notification->content_type=='adminnotification'){
				$mytime=($notification->time);
				$currtime=time();
				$timestamp = mktime(date('H',$mytime)+$notification->additional_subj, date('i',$mytime), date('s',$mytime), date('m',$mytime), date('d',$mytime), date('Y',$mytime));
				
				if($timestamp>$currtime){
			    	$output1 .= '<li onclick="self.location.href=\''.$url.'\';" class="test '.($full ? 'livebit' : 'livenotificationbit').($is_read ? ' red">' : ' unread">')
					. $icons;
					
					if(!$full) $output1 .= '<div style="width:'.$right_width.'px;">';
					else $output1 .= '<div class="full_right" >';
					$output1 .= '<p class="ln_content">'
					.$phrase
					. '</p>'
					. '<p class="ln_time">'.$time.'</p>';
					$output1 .= '</div>'; 
					$output1 .= '</li>'
					. "\n";
		     	}
			}elseif($notification->content_type=='bbpressnotificationreply'){
				$permalink = get_permalink( $notification->content_id );
				$output2 .= '<li onclick="self.location.href=\''.$permalink.'\';" class="test '.($full ? 'livebit' : 'livenotificationbit').($is_read ? ' red">' : ' unread">')
				. $icons;
				
				if(!$full) $output2 .= '<div style="width:'.$right_width.'px;">';
				else $output2 .= '<div class="full_right" >';
				$output2 .= '<p class="ln_content">'
				.$phrase
				. '</p>'
				. '<p class="ln_time">'.$time.'</p>';
				$output2 .= '</div>'; 
				$output2 .= '</li>'
				. "\n";
			}elseif($notification->content_type=='bbpressnotification'){
				$permalink = get_permalink( $notification->content_id );
				$output2 .= '<li onclick="self.location.href=\''.$permalink.'\';" class="test '.($full ? 'livebit' : 'livenotificationbit').($is_read ? ' red">' : ' unread">')
				. $icons;
				
				if(!$full) $output2 .= '<div style="width:'.$right_width.'px;">';
				else $output2 .= '<div class="full_right" >';
				$output2 .= '<p class="ln_content">'
				.$phrase
				. '</p>'
				. '<p class="ln_time">'.$time.'</p>';
				$output2 .= '</div>'; 
				$output2 .= '</li>'
				. "\n";
			}elseif($notification->content_type=='postaward'){
		       	$selectdata=mysql_query("select * from ".$wpdb->prefix."rewardsystem where reid='".$notification->content_id."'");
	       		
				while($getrewarddatas=mysql_fetch_array($selectdata)){
		    		$repoints=$getrewarddatas['repoint'];
		     		$reorders=$getrewarddatas['reorder'];
					$retitle=$getrewarddatas['retitle'];
					$images=$getrewarddatas['rew_image'];
					$rentc=$getrewarddatas['rentc'];
					$remsg=$getrewarddatas['remsg'];
		    	}
				
				$output2 .= '<li onclick="self.location.href=\''.$options1["plink_award"].'\';" class="test '.($full ? 'livebit' : 'livenotificationbit').($is_read ? ' red">' : ' unread">');
				$output2 .= '<div style="width:100px;"><img src="'.$images.'" width="100" height="100"/></div>';
				
				if(!$full) $output2 .= '<div style="width:200px;">';
				else $output2 .= '<div class="full_right" >';
				
				$selectdata1=mysql_query("select * from ".$wpdb->prefix."rewardsystem where reorder != '".$reorders."' ORDER BY reid  ASC ");
				$rank=mysql_fetch_array($selectdata1);
				$rank_next=$rank['numlist'].' '.$rank['type'];
				$userinfo = wp_get_current_user();
				
				//$options1 = get_option('ln_options1'); 
				$output2 .= '<p class="ln_content"><font color="green">+'
				.$repoints 
				. '  Points</font></p>'
				. '<p class="ln_time">'.$retitle.'</p>'
				. '<p class="ln_time">'.$rentc.'</p>'
				. '<p class="ln_time">'.$remsg.'</p>'
				. '<p class="ln_time">Next:'.$notification->username.'</p>';
				$output2 .= '</div>'; 
				$output2 .= '</li>'
				. "\n";
			}elseif($notification->content_type=='readpostaward'){
				$selectdata=mysql_query("select * from ".$wpdb->prefix."rewardsystem where reid='".$notification->content_id."'");
				
				while($getrewarddatas=mysql_fetch_array($selectdata)){
					$repoints=$getrewarddatas['repoint'];
					$reorders=$getrewarddatas['reorder'];
					$retitle=$getrewarddatas['retitle'];
					$images=$getrewarddatas['rew_image'];
					$rentc=$getrewarddatas['rentc'];
					$remsg=$getrewarddatas['remsg'];
				}
				$output2 .= '<li onclick="self.location.href=\''.$options1["plink_award"].'\';" class="test '.($full ? 'livebit' : 'livenotificationbit').($is_read ? ' red">' : ' unread">');
				$output2 .= '<div style="width:100px;"><img src="'.$images.'" width="100" height="100"/></div>';
				
				if(!$full) $output2 .= '<div style="width:200px;">';
				else $output2 .= '<div class="full_right" >';
				
				$selectdata1=mysql_query("select * from ".$wpdb->prefix."rewardsystem where reorder != '".$reorders."' ORDER BY reid  ASC ");
				$rank=mysql_fetch_array($selectdata1);
				$rank_next=$rank['numlist'].' '.$rank['type'];
				$userinfo = wp_get_current_user();
				
				//$options1 = get_option('ln_options1'); 
				$output2 .= '<p class="ln_content"><font color="green">+'
				.$repoints 
				. '  Points</font></p>'
				. '<p class="ln_time">'.$retitle.'</p>'
				. '<p class="ln_time">'.$rentc.'</p>'
				. '<p class="ln_time">'.$remsg.'</p>'
				. '<p class="ln_time">Next:'.$notification->username.'</p>';
				$output2 .= '</div>'; 
				$output2 .= '</li>'
				. "\n";
			}elseif($notification->content_type=='commentaward'){
				$userinfo = wp_get_current_user();
				$selectdata=mysql_query("select * from ".$wpdb->prefix."rewardsystem where reid='".$notification->content_id."'");
				
				while($getrewarddatas=mysql_fetch_array($selectdata)){
					$repoints=$getrewarddatas['repoint'];
					$reorders=$getrewarddatas['reorder'];
					$retitle=$getrewarddatas['retitle'];
					$images=$getrewarddatas['rew_image'];
					$rentc=$getrewarddatas['rentc'];
					$remsg=$getrewarddatas['remsg'];
				}
			
    			$output2 .= '<li onclick="self.location.href=\''.$options1["plink_award"].'\';" class="test '.($full ? 'livebit' : 'livenotificationbit').($is_read ? ' red">' : ' unread">');
				$output2 .= '<div style="width:100px;"><img src="'.$images.'" width="100" height="100"/></div>';
				
				if(!$full) $output2 .= '<div style="width:200px;">';
				else $output2 .= '<div class="full_right" >';
				
				//$options1 = get_option('ln_options1'); 
				$output2 .= '<p class="ln_content"><font color="green">+'
				.$repoints 
				. '  Points</font></p>'
				. '<p class="ln_time">'.$retitle.'</p>'
				. '<p class="ln_time">'.$rentc.'</p>'
				. '<p class="ln_time">'.$remsg.'</p>'
				. '<p class="ln_time">Next:'.$notification->username.'</p>';
				$output2 .= '</div>'; 
				$output2 .= '</li>'
				. "\n";
			}elseif($notification->content_type=='noticeaward'){
				$userinfo = wp_get_current_user();
				$selectdata=mysql_query("select * from ".$wpdb->prefix."rewardsystem where reid='".$notification->content_id."'");
				
				while($getrewarddatas=mysql_fetch_array($selectdata)){
					$repoints=$getrewarddatas['repoint'];
					$reorders=$getrewarddatas['reorder'];
					$retitle=$getrewarddatas['retitle'];
					$images=$getrewarddatas['rew_image'];
					$rentc=$getrewarddatas['rentc'];
					$remsg=$getrewarddatas['remsg'];
				}
				
				$output2 .= '<li onclick="self.location.href=\''.$options1["plink_award"].'\';" class="test '.($full ? 'livebit' : 'livenotificationbit').($is_read ? ' red">' : ' unread">');
				$output2 .= '<div style="width:100px;"><img src="'.$images.'" width="100" height="100"/></div>';
				
				if(!$full) $output2 .= '<div style="width:200px;">';
				else $output2 .= '<div class="full_right" >';
				
				//$options1 = get_option('ln_options1'); 
				$output2 .= '<p class="ln_content"><font color="green">+'
				.$repoints 
				. '  Points</font></p>'
				. '<p class="ln_time">'.$retitle.'</p>'
				. '<p class="ln_time">'.$rentc.'</p>'
				. '<p class="ln_time">'.$remsg.'</p>'
				. '<p class="ln_time">Next:'.$notification->username.'</p>';
				$output2 .= '</div>'; 
				$output2 .= '</li>'
				. "\n";
			}elseif($notification->content_type=='messageaward'){
				$userinfo = wp_get_current_user();
				$selectdata=mysql_query("select * from ".$wpdb->prefix."rewardsystem where reid='".$notification->content_id."'");
				
				while($getrewarddatas=mysql_fetch_array($selectdata)){
					$repoints=$getrewarddatas['repoint'];
					$reorders=$getrewarddatas['reorder'];
					$retitle=$getrewarddatas['retitle'];
					$images=$getrewarddatas['rew_image'];
					$rentc=$getrewarddatas['rentc'];
					$remsg=$getrewarddatas['remsg'];
				}
				
				$output2 .= '<li onclick="self.location.href=\''.$options1["plink_award"].'\';" class="test '.($full ? 'livebit' : 'livenotificationbit').($is_read ? ' red">' : ' unread">');
				$output2 .= '<div style="width:100px;"><img src="'.$images.'" width="100" height="100"/></div>';
				
				if(!$full) $output2 .= '<div style="width:200px;">';
				else $output2 .= '<div class="full_right" >';
				
				//$options1 = get_option('ln_options1'); 
				$output2 .= '<p class="ln_content"><font color="green">+'
				.$repoints 
				. '  Points</font></p>'
				. '<p class="ln_time">'.$retitle.'</p>'
				. '<p class="ln_time">'.$rentc.'</p>'
				. '<p class="ln_time">'.$remsg.'</p>'
				. '<p class="ln_time">Next:'.$notification->username.'</p>';
				$output2 .= '</div>'; 
				$output2 .= '</li>'
				. "\n";
			}else{	
			    if($notification->content_type =='nb'){
			    	$output2 .= '<li><a href="'.$url.'" id="rel" class="'.($full ? 'livebit' : 'livenotificationbit').($is_read ? ' red">' : ' unread">')
					. '<table class="main_info"><tr><td class="first_ava" valign="middle" width="25px">'
					. $icons;
					$output2 .= '</td>';
				}elseif($notification->content_type =='rp'){
			    	$output2 .= '<li><a href="'.$url.'" id="rel" class="'.($full ? 'livebit' : 'livenotificationbit').($is_read ? ' red">' : ' unread">')
					. '<table class="main_info"><tr><td class="first_ava" valign="middle" width="25px">'
					. $nb_avatar;
					$output2 .= '</td>';
				}elseif($notification->content_type =='mod_comment'){
			    	$output2 .= '<li><a href="'.$url.'" class="'.($full ? 'livebit' : 'livenotificationbit').($is_read ? ' red">' : ' unread">')
					. '<table class="main_info"><tr><td class="first_ava" valign="middle" width="25px">'
					. $icons;
					$output2 .= '</td>';
				}elseif($notification->content_type =='pm'){
			    	$url = $options1["plink_sendmsg"];
					$link = $url.'?page=lnpm_inbox';
					$output2 .= '<li><a href="'.$link.'" id="rel" class="'.($full ? 'livebit' : 'livenotificationbit').($is_read ? ' red">' : ' unread">')
					. '<table class="main_info"><tr><td class="first_ava" valign="middle" width="25px">'
					. $icons;
					$output2 .= '</td>';
				}else{
					$output2 .= '<li><a href="'.$url.'" id="rel" class="'.($full ? 'livebit' : 'livenotificationbit').($is_read ? ' red">' : ' unread">')
					. '<table class="main_info"><tr><td class="first_ava" valign="middle" width="25px">'
					. $icons;
					$output2 .= '</td>';
				}
				
			    if(!$full) $output2 .= '';
				else $output2 .= '<td class="sec_ava" valign="top" width="auto">';
				
				$output2 .= '<div class="noti_content">'. $phrase.'<span> ('.$time.')</span></div>';
				$output2 .= '</td></tr></table>'; 
				$output2 .= '</a></li>'
				. "\n";
	    	}
		}
    }
	$output .=$output1.$output2;
	return $output;
}

function ln_fetch_notifications($userid, $start=0, $count=-1, $full=false,$type='all' ,$is_first=true){
	global $wpdb;
	global $current_user1;
    get_currentuserinfo();
	  
	$site_url = get_option( 'siteurl' );
	$options = get_option('ln_options');
	$options1 = get_option('ln_options1');
	
	$output = '';
	
	$update_ids = array(); // ids which we will mark as read in the next step
	$override_status = array();

	if($type == 'all'){
		$cond = " ";
		$sql = "SELECT l.* FROM " . $wpdb->prefix . "livenotifications AS l WHERE l.userid = " . (int)$userid . " ".$cond." ORDER BY l.is_read, l.time DESC";
	}
	else if($type == 'comment'){
		$cond = " AND l.content_type <> 'nb' AND l.content_type <> 'pm' AND substring(l.content_type,1,4) <> 'mod_' ";
		$sql = "SELECT l.* FROM " . $wpdb->prefix . "livenotifications AS l WHERE l.userid = " . (int)$userid . " ".$cond." ORDER BY l.is_read, l.time DESC";
		$output = "<li class='ln_title'>Notifications</li>";
	}
	else if($type == 'nb'){
		$cond = " AND l.userid_subj > 0 ";
		$sql = "SELECT l.*,count(id) as number FROM " . $wpdb->prefix . "livenotifications AS l WHERE l.content_type = 'nb'  AND l.userid = " . (int)$userid . " ".$cond." GROUP BY l.userid_subj ORDER BY l.is_read, l.time DESC";
		$output = "<li class='ln_title'>Private notices
		    <a href='".$options1['plink_sendntc']."'>Send New notices</a></li>";
	}
	else if($type == 'pm'){
		$cond = " AND l.userid_subj > 0 ";
		$sql = "SELECT l.*,count(id) as number FROM " . $wpdb->prefix . "livenotifications AS l WHERE l.content_type = 'pm'  AND l.userid = " . (int)$userid . " ".$cond." GROUP BY l.userid_subj ORDER BY l.is_read, l.time DESC";
		$output = "<li class='ln_title'>Private Messages
		    <a href='".$options1['plink_sendmsg']."'>Send New Messages</a></li>";
	}
	if($type == 'moderation'){
		$cond = " AND substring(l.content_type,1,4) = 'mod_'  ";
		$sql = "SELECT l.* FROM " . $wpdb->prefix . "livenotifications AS l WHERE l.userid = " . (int)$userid . " ".$cond." ORDER BY l.is_read, l.time DESC";
		$output = "<li class='ln_title'>Moderations</li>";
	}
	
	$res = $wpdb->get_results($sql);
	$total_numrows = count($res);
	
	if ($start >= 0 && $count > 0) $sql .= " LIMIT ".(int)$start.", ".(int)$count;
	$res = $wpdb->get_results($sql);
	
	if ($full && isset($_REQUEST['lntransf']) && !empty($_REQUEST['lntransf'])) {
		$override_status = explode(",",$_REQUEST['lntransf']);
		array_walk($override_status, 'intval');
	}else{
		$override_status = array();
	}
	$scrollpane_height = 230;
	if(!$full){
		$numrows = count($res);
		$output .= '<li style="width:330px;"><ul class="ln_scrollpane"';
		if($numrows > 4){
			$output .= ' style="height: '.$scrollpane_height.'px;"';
		}else{
			$scrollpane_height = 0;
		}
		$output .= ">";
	}

	foreach ($res as $notification){
		if (!$notification->is_read) $update_ids[] = (int)$notification->id; // Set pulled notifications as red
		$is_read = ($full && in_array($notification->id, $override_status)) ? false : $notification->is_read;
		
		switch ($notification->content_type){
			case 'comment':
				$url = $site_url . '/' . "?p=" . $notification->parent_id."#comment-".$notification->content_id;
				$icons = '<i class="image notifications cmd"></i>';
				
				$phrase = ($notification->additional_subj > 0)
				? sprintf("%s and %d others commented on your post %s",
					$notification->username,
					$notification->additional_subj,
						ln_wrap_url($url, $notification->content_text))
						: sprintf("<strong>%s</strong> commented on your post %s",
							$notification->username,
							ln_wrap_url($url, $notification->content_text));
				break;
				
			case 'reply':
				$url = $site_url . '/' . "?p=" . $notification->parent_id."#comment-".$notification->content_id;
				$icons = '<i class="image notifications rpy"></i>';
				$phrase = ($notification->additional_subj > 0)
				? sprintf("%s and %d others reply to your comment on %s",
					$notification->username,
					$notification->additional_subj,
						ln_wrap_url($url, $notification->content_text))
						: sprintf("<strong>%s</strong> reply to your comment on %s",
							$notification->username,
							ln_wrap_url($url, $notification->content_text));
				break;
				
			case 'nb':
				$icons ='<i class="image notifications nto"></i>';
				if($full){
					$url = $options1["plink_viewntc"];
					$phrase = sprintf("We reviewed your report on an article. Go to your Support Inbox to learn more.",
						$notification->username,
						ln_wrap_url($url, $notification->content_text));
				}
				else{
					$notification_time = $notification->time;
					$phrase1 = $notification->username;
					$phrase2 = $notification->content_text;
				}
				break;	
		
	     	case 'rp':
				$icons ='<i class="image notifications rpt"></i>';
				if($full){
					$url = $options1["plink_viewntc"];
					$phrase = sprintf("We reviewed your report on an article. Go to your Support Inbox to learn more.",
						$notification->username,
						ln_wrap_url($url, $notification->content_text));
				}
				else{
					$notification_time = $notification->time;
					$phrase1 = $notification->username;
					$phrase2 = $notification->content_text;
				}
				break;	
				
			case 'pm':
				$icons ='<i class="image notifications rpt"></i>';
				if($full){
					$url = $options1["plink_sendmsg"];
					$link = $url.'?page=lnpm_inbox';
					
					$phrase = sprintf("<strong>%s</strong> has reported on post: %s",
						$notification->username,
						ln_wrap_url($link, $notification->content_text));
				}
				else{
					$notification_time = $notification->time;
					$phrase1 = $notification->username;
					$phrase2 = $notification->content_text;
				}
				break;

			case 'mod_comment':
				$url = $site_url . '/wp-admin/edit-comments.php';
				$phrase = sprintf( __('<strong>%d</strong> comment(s) awaiting for your <a href="'.$url .'">approval</a>'), $notification->content_text );

				break;
			default:
			
			$phrase = "Has performed an unknown operation...";
		}
		$time = ln_get_timeformat($notification->time);
		$right_width = 260;
		$request_status_class = "request_status";
		
		if($options['hide_avatar']){
			$right_width = $right_width + $options['ln_avatar_height'];
			$request_status_class = "request_status_noavatar";
		}
		
		if(($type == "nb" || $type == "pm" || $type == "moderation") && !$full){
			if($type == "nb"){
				$output .= '<li onclick="ln_show_nb_other('.$notification->content_id.',event);" class="lnnbbit '.($full ? 'livebit' : 'livenotificationbit').($is_read ? ' red">' : ' unread">')
					. $icons
					. '<div style="width:'.($right_width + 7).'px;"><div class="'.$request_status_class.'" ><p class="ln_sender_name">'
					. $phrase1
					. '</p>'
					. '<p class="ln_content">'
					. $phrase2
					. '</p>'
					. '<p class="ln_time">'.$time.'</p>'
					. '</div><div class="actions"><input type="button" id="confirm" onclick="ln_nb_delete_action('.$notification->content_id.',event);" name="nb_delete" value="Delete"></div></div><div style="clear:both;"></div>'
					. '</li></div><div style="clear:both;"></div>'
					. "\n";
										
				$output .= '<li class="lnnbbit livenotificationbit red ln_nb_inner_window" id="ln_nb_inner_window_'.$notification->content_id.'" style="display:none; " onclick="ln_nb_innerwindow_click(event);">'
				    .ln_getall_content($notification->userid,$notification->userid_subj,$notification->content_id,$right_width,$request_status_class,$phrase1,$phrase2,$icons,$time,$scrollpane_height,$full).
					'<div style="border-top: 1px solid #DDD; margin-top: 4px;padding-top: 4px;">'
					. $icons
					. '<div style="; width: '.($right_width + 10).'px;"><textarea name="reply_'.$notification->content_id.'" id="reply_'.$notification->content_id.'" cols="40" rows="3" style="min-width:'.($right_width-15).'px;max-width:'.($right_width-20).'px;"></textarea>'
					. '<div style="clear:both;"></div><div class="ln_nb_reply" ><input type="button" id="confirm" onclick="ln_nb_reply_action('.$notification->content_id.','.$scrollpane_height.');" name="nb_reply" value="Reply"></div><div class="ln_nb_inbox" onclick="self.location.href=\''.$options1["plink_viewntc"].'\';">View in Inbox</div></div>'
					. '</div><div style="clear:both;"></div>'
					. '</li></div><div style="clear:both;"></div>'
					. "\n";
			}
			else if($type == "pm"){
				$output .= '<li onclick="ln_show_pm_other('.$notification->content_id.',event);" class="lnpmbit '.($full ? 'livebit' : 'livenotificationbit').($is_read ? ' red">' : ' unread">')
					. $icons
					. '<div style="width:'.($right_width + 7).'px;"><div class="'.$request_status_class.'" ><p class="ln_sender_name">'
					. $phrase1
					. '</p>'
					. '<p class="ln_content">'
					. $phrase2
					. '</p>'
					. '<p class="ln_time">'.$time.'</p>'
					. '</div><div class="actions"><input type="button" id="confirm" onclick="ln_pm_delete_action('.$notification->content_id.',event);" name="pm_delete" value="Delete"></div></div><div style="clear:both;"></div>'
					. '</li></div><div style="clear:both;"></div>'
					. "\n";
										
				$output .= '<li class="lnpmbit livenotificationbit red ln_pm_inner_window" id="ln_pm_inner_window_'.$notification->content_id.'" style="display:none; " onclick="ln_pm_innerwindow_click(event);">'
				    .ln_getall_dashboa($notification->userid,$notification->userid_subj,$notification->content_id,$right_width,$request_status_class,$phrase1,$phrase2,$icons,$time,$scrollpane_height,$full).
					'<div style="border-top: 1px solid #DDD; margin-top: 4px;padding-top: 4px;">'
					. $icons
					. '<div style="; width: '.($right_width + 10).'px;"><textarea name="reply_'.$notification->content_id.'" id="reply_'.$notification->content_id.'" cols="40" rows="3" style="min-width:'.($right_width-15).'px;max-width:'.($right_width-20).'px;"></textarea>'
					. '<div style="clear:both;"></div><div class="ln_pm_reply" ><input type="button" id="confirm" onclick="ln_pm_reply_action('.$notification->content_id.','.$scrollpane_height.');" name="pm_reply" value="Reply"></div><div class="ln_pm_inbox" onclick="self.location.href=\''.$options1["plink_viewntc"].'\';">View in Inbox</div></div>'
					. '</div><div style="clear:both;"></div>'
					. '</li></div><div style="clear:both;"></div>'
					. "\n";
			}
			else if($type == "moderation"){
				//moderation
				$output .= '<li onclick="self.location.href=\''.$url.'\';"  style="min-height:20px;" class="'.($full ? 'livebit' : 'livenotificationbit').($is_read ? ' red">' : ' unread">')
				.'<div>'
				. '<p class="ln_content">'
				. $phrase
				. '</p>'
				.'</div><div style="clear:both;"></div>'
				. '</li>'
				. "\n";
			}
		}
		else{
			if($notification->content_type=='adminnotification'){
				$mytime=($notification->time);
				$currtime=time();
				$timestamp = mktime(date('H',$mytime)+$notification->additional_subj, date('i',$mytime), date('s',$mytime), date('m',$mytime), date('d',$mytime), date('Y',$mytime));
				
				if($timestamp>$currtime){
					$output1 .= '<li onclick="self.location.href=\''.$url.'\';" class="test '.($full ? 'livebit' : 'livenotificationbit').($is_read ? ' red">' : ' unread">')
					    . $icons;
						
					if(!$full) $output1 .= '<div style="width:'.$right_width.'px;">';
					else $output1 .= '<div class="full_right" >';
						$output1 .= '<p class="ln_content">'
						.$phrase
						. '</p>'
						. '<p class="ln_time">'.$time.'</p>';
						$output1 .= '</div>'; 
						$output1 .= '</li>'
						. "\n";
				}
			}elseif($notification->content_type=='bbpressnotificationreply'){
				$permalink = get_permalink( $notification->content_id );
				$output2 .= '<li onclick="self.location.href=\''.$permalink.'\';" class="test '.($full ? 'livebit' : 'livenotificationbit').($is_read ? ' red">' : ' unread">')
				. $icons;
				
				if(!$full) $output2 .= '<div style="width:'.$right_width.'px;">';
				else $output2 .= '<div class="full_right" >';
		     	   	$output2 .= '<p class="ln_content">'
		       		.$phrase
					. '</p>'
					. '<p class="ln_time">'.$time.'</p>';
					$output2 .= '</div>'; 
					$output2 .= '</li>'
				. "\n";
			}elseif($notification->content_type=='bbpressnotification'){
				$permalink = get_permalink( $notification->content_id );
				
				$output2 .= '<li onclick="self.location.href=\''.$permalink.'\';" class="test '.($full ? 'livebit' : 'livenotificationbit').($is_read ? ' red">' : ' unread">')
			. $icons;
			if(!$full) $output2 .= '<div style="width:'.$right_width.'px;">';
			else $output2 .= '<div class="full_right" >';
			$output2 .= '<p class="ln_content">'
			.$phrase
			. '</p>'
			. '<p class="ln_time">'.$time.'</p>';
			$output2 .= '</div>'; 
			$output2 .= '</li>'
			. "\n";
			
		}elseif($notification->content_type=='postaward'){
			$selectdata=mysql_query("select * from ".$wpdb->prefix."rewardsystem where reid='".$notification->content_id."'");
			
			while($getrewarddatas=mysql_fetch_array($selectdata)){
				$repoints=$getrewarddatas['repoint'];
				$reorders=$getrewarddatas['reorder'];
				$retitle=$getrewarddatas['retitle'];
				$images=$getrewarddatas['rew_image'];
				$rentc=$getrewarddatas['rentc'];
				$remsg=$getrewarddatas['remsg'];
			}
			
			$output2 .= '<li onclick="self.location.href=\''.$options1["plink_award"].'\';" class="test '.($full ? 'livebit' : 'livenotificationbit').($is_read ? ' red">' : ' unread">');
			$output2 .= '<div style="width:100px;"><img src="'.$images.'" width="100" height="100"/></div>';
				
			if(!$full) $output2 .= '<div style="width:200px;">';
			else $output2 .= '<div class="full_right" >';
				
			$selectdata1=mysql_query("select * from ".$wpdb->prefix."rewardsystem where reorder != '".$reorders."' ORDER BY reid  ASC ");
			$rank=mysql_fetch_array($selectdata1);
			$rank_next=$rank['numlist'].' '.$rank['type'];
			$userinfo = wp_get_current_user();
		
			//$options1 = get_option('ln_options1'); 
			$output2 .= '<p class="ln_content"><font color="green">+'
			.$repoints 
			. '  Points</font></p>'
			. '<p class="ln_time">'.$retitle.'</p>'
			. '<p class="ln_time">'.$rentc.'</p>'
			. '<p class="ln_time">'.$remsg.'</p>'
			. '<p class="ln_time">Next:'.$notification->username.'</p>';
			$output2 .= '</div>'; 
			$output2 .= '</li>'
			. "\n";
		}elseif($notification->content_type=='readpostaward'){
			$selectdata=mysql_query("select * from ".$wpdb->prefix."rewardsystem where reid='".$notification->content_id."'");
			
			while($getrewarddatas=mysql_fetch_array($selectdata)){
				$repoints=$getrewarddatas['repoint'];
				$reorders=$getrewarddatas['reorder'];
				$retitle=$getrewarddatas['retitle'];
				$images=$getrewarddatas['rew_image'];
				$rentc=$getrewarddatas['rentc'];
				$remsg=$getrewarddatas['remsg'];
			}
			
			$output2 .= '<li onclick="self.location.href=\''.$options1["plink_award"].'\';" class="test '.($full ? 'livebit' : 'livenotificationbit').($is_read ? ' red">' : ' unread">');
			$output2 .= '<div style="width:100px;"><img src="'.$images.'" width="100" height="100"/></div>';
			
			if(!$full) $output2 .= '<div style="width:200px;">';
			else $output2 .= '<div class="full_right" >';
			
			$selectdata1=mysql_query("select * from ".$wpdb->prefix."rewardsystem where reorder != '".$reorders."' ORDER BY reid  ASC ");
			$rank=mysql_fetch_array($selectdata1);
			$rank_next=$rank['numlist'].' '.$rank['type'];
			$userinfo = wp_get_current_user();
			
			//$options1 = get_option('ln_options1'); 
			$output2 .= '<p class="ln_content"><font color="green">+'
			.$repoints 
			. '  Points</font></p>'
			. '<p class="ln_time">'.$retitle.'</p>'
			. '<p class="ln_time">'.$rentc.'</p>'
			. '<p class="ln_time">'.$remsg.'</p>'
			. '<p class="ln_time">Next:'.$notification->username.'</p>';
			$output2 .= '</div>'; 
			$output2 .= '</li>'
			. "\n";
			
		}elseif($notification->content_type=='commentaward'){
			$userinfo = wp_get_current_user();
			$selectdata=mysql_query("select * from ".$wpdb->prefix."rewardsystem where reid='".$notification->content_id."'");
			
			while($getrewarddatas=mysql_fetch_array($selectdata)){
				$repoints=$getrewarddatas['repoint'];
				$reorders=$getrewarddatas['reorder'];
				$retitle=$getrewarddatas['retitle'];
				$images=$getrewarddatas['rew_image'];
				$rentc=$getrewarddatas['rentc'];
				$remsg=$getrewarddatas['remsg'];
			}
			
			$output2 .= '<li onclick="self.location.href=\''.$options1["plink_award"].'\';" class="test '.($full ? 'livebit' : 'livenotificationbit').($is_read ? ' red">' : ' unread">');
			$output2 .= '<div style="width:100px;"><img src="'.$images.'" width="100" height="100"/></div>';
			
			if(!$full) $output2 .= '<div style="width:200px;">';
			else $output2 .= '<div class="full_right" >';
			
			//$options1 = get_option('ln_options1'); 
			$output2 .= '<p class="ln_content"><font color="green">+'
			.$repoints 
			. '  Points</font></p>'
			. '<p class="ln_time">'.$retitle.'</p>'
			. '<p class="ln_time">'.$rentc.'</p>'
			. '<p class="ln_time">'.$remsg.'</p>'
			. '<p class="ln_time">Next:'.$notification->username.'</p>';
			$output2 .= '</div>'; 
			$output2 .= '</li>'
			. "\n";
			
		}elseif($notification->content_type=='noticeaward'){
			$userinfo = wp_get_current_user();
			$selectdata=mysql_query("select * from ".$wpdb->prefix."rewardsystem where reid='".$notification->content_id."'");
			
			while($getrewarddatas=mysql_fetch_array($selectdata)){
				$repoints=$getrewarddatas['repoint'];
				$reorders=$getrewarddatas['reorder'];
				$retitle=$getrewarddatas['retitle'];
				$images=$getrewarddatas['rew_image'];
				$rentc=$getrewarddatas['rentc'];
				$remsg=$getrewarddatas['remsg'];
			}
			
			$output2 .= '<li onclick="self.location.href=\''.$options1["plink_award"].'\';" class="test '.($full ? 'livebit' : 'livenotificationbit').($is_read ? ' red">' : ' unread">');
			$output2 .= '<div style="width:100px;"><img src="'.$images.'" width="100" height="100"/></div>';
			
			if(!$full) $output2 .= '<div style="width:200px;">';
			else $output2 .= '<div class="full_right" >';
			
			//$options1 = get_option('ln_options1'); 
			$output2 .= '<p class="ln_content"><font color="green">+'
			.$repoints 
			. '  Points</font></p>'
			. '<p class="ln_time">'.$retitle.'</p>'
			. '<p class="ln_time">'.$rentc.'</p>'
			. '<p class="ln_time">'.$remsg.'</p>'
			. '<p class="ln_time">Next:'.$notification->username.'</p>';
			$output2 .= '</div>'; 
			$output2 .= '</li>'
			. "\n";
			
		}elseif($notification->content_type=='messageaward'){
			$userinfo = wp_get_current_user();
			$selectdata=mysql_query("select * from ".$wpdb->prefix."rewardsystem where reid='".$notification->content_id."'");
			
			while($getrewarddatas=mysql_fetch_array($selectdata)){
				$repoints=$getrewarddatas['repoint'];
				$reorders=$getrewarddatas['reorder'];
				$retitle=$getrewarddatas['retitle'];
				$images=$getrewarddatas['rew_image'];
				$rentc=$getrewarddatas['rentc'];
				$remsg=$getrewarddatas['remsg'];
			}
			
			$output2 .= '<li onclick="self.location.href=\''.$options1["plink_award"].'\';" class="test '.($full ? 'livebit' : 'livenotificationbit').($is_read ? ' red">' : ' unread">');
			$output2 .= '<div style="width:100px;"><img src="'.$images.'" width="100" height="100"/></div>';
			
			if(!$full) $output2 .= '<div style="width:200px;">';
			else $output2 .= '<div class="full_right" >';
			
			//$options1 = get_option('ln_options1'); 
			$output2 .= '<p class="ln_content"><font color="green">+'
			.$repoints 
			. '  Points</font></p>'
			. '<p class="ln_time">'.$retitle.'</p>'
			. '<p class="ln_time">'.$rentc.'</p>'
			. '<p class="ln_time">'.$remsg.'</p>'
			. '<p class="ln_time">Next:'.$notification->username.'</p>';
			$output2 .= '</div>'; 
			$output2 .= '</li>'
			. "\n";
			
		}else{
			$output2 .= '<li onclick="self.location.href=\''.$url.'\';" class="'.($full ? 'livebit' : 'livenotificationbit').($is_read ? ' red">' : ' unread">')
			. $icons;
			if(!$full) $output2 .= '<div style="width:'.$right_width.'px;">';
			else $output2 .= '<div class="full_right" >';
			$output2 .= '<p class="ln_content">'
			. $phrase
			. '</p>'
			. '<p class="ln_time">'.$time.'</p>';
			$output2 .= '</div>'; 
			$output2 .= '</li>'
			. "\n";
		}
	}
}

$output .=$output1.$output2;

if (!$full) {
	global $current_user;
	get_currentuserinfo();
	$options1 = get_option('ln_options1'); 

	$output .= "</ul></li>";
	    if($numrows < $total_numrows){
			$output .= '<li onclick="ln_checknotifications_more(\''.$type.'\','.($numrows+10).',event);" class="livenotifications_more">'.sprintf( __('See More')).'</li>';
		}
		if($type == "nb"){
			$output .= '<li onclick="ln_transfer_overview(\''.$options1["plink_viewntc"].'\');" class="livenotifications_link">'.sprintf( __('Show All Private notices')).'</li>';
		}
		else if($type == "pm"){
			$output .= '<li onclick="ln_transfer_overview(\''.$options1["plink_viewmsg"].'\');" class="livenotifications_link">'.sprintf( __('Show All Private Messages')).'</li>';
		}
		else if($type == "moderation"){
			$output .= '<li onclick="ln_transfer_overview(\''.$site_url . '/wp-admin/edit-comments.php\' );" class="livenotifications_link">'.sprintf( __('Show All Moderations')).'</li>';
		}
		else{
			$ln_useroptions = ln_fetch_useroptions($userid);
				
			$ln_checked = array(
				'ln_enable_comment'=>  	    $ln_useroptions['enable_comment']?    ' checked="checked"' : '',
				'ln_enable_reply'=>          $ln_useroptions['enable_reply']?      ' checked="checked"' : '',				
				'ln_enable_award'=>	        $ln_useroptions['enable_award']?      ' checked="checked"' : '',
				'ln_enable_moderation'=> 	$ln_useroptions['enable_moderation']? ' checked="checked"' : '',
				'ln_enable_taguser'=>  	    $ln_useroptions['enable_taguser']?    ' checked="checked"' : '',
				'ln_enable_nb'=> 	    	$ln_useroptions['enable_nb']?         ' checked="checked"' : '',
				'ln_enable_pm'=> 	    	$ln_useroptions['enable_pm']?         ' checked="checked"' : ''
			);
				
			$option_img_url = get_template_directory_uri()."/images/settings.png";
			$output .= '<li class="livenotifications_link"><img class="settings_option" src="'.$option_img_url.'" width="15" alt="Setting Options" onclick="ln_show_settings(event);" /></li>';
			$output .= '<li class="lnnbbit lnpmbit livenotificationbit red ln_settings_window" id="ln_settings_window" style="display:none; "  onclick="ln_nb_innerwindow_click(event); ln_pm_innerwindow_click(event);">'
				. '<div onclick="ln_back_to_notification('.$scrollpane_height.');" class="ln_link" id="ln_notification_back">'.sprintf( __('Back to Notifications')).'</div>'
				.'<ul class="checkradio group rightcol">';
				
			if ($options["enable_comment"]){
				$output .= '<li><label for="ln_enable_comment"><input type="checkbox" name="options[ln_enable_comment]" id="ln_enable_comment" tabindex="1" '.$ln_checked['ln_enable_comment'].' /> '.sprintf( __('Enable Comment Notification')).'</label></li>';
			}
			if($options["enable_reply"]){
				$output .= '<li><label for="ln_enable_reply"><input type="checkbox" name="options[ln_enable_reply]" id="ln_enable_reply" tabindex="1" '.$ln_checked['ln_enable_reply'].' /> '.sprintf( __('Enable Reply Notification')).'</label></li>';
			}
			if($options["enable_award"]){
				$output .= '<li><label for="ln_enable_award"><input type="checkbox" name="options[ln_enable_award]" id="ln_enable_award" tabindex="1" '.$ln_checked['ln_enable_award'].' /> '.sprintf( __('Enable Award Notification')).'</label></li>';
			}
			if($options["enable_moderation"]){
				$output .= '<li><label for="ln_enable_moderation"><input type="checkbox" name="options[ln_enable_moderation]" id="ln_enable_moderation" tabindex="1" '.$ln_checked['ln_enable_moderation'].' /> '.sprintf( __('Enable Notification awaiting moderation')).'</label></li>';
			}
			if($options["enable_taguser"]){
				$output .= '<li><label for="ln_enable_taguser"><input type="checkbox" name="options[ln_enable_taguser]" id="ln_enable_taguser" tabindex="1" '.$ln_checked['ln_enable_taguser'].' /> '.sprintf( __('Enable Notification to tagged user')).'</label></li>';
			}
			if($options["enable_nb"]){
				$output .= '<li><label for="ln_enable_nb"><input type="checkbox" name="options[ln_enable_nb]" id="ln_enable_nb" tabindex="1" '.$ln_checked['ln_enable_nb'].' /> '.sprintf( __('Enable Notification of private notice')).'</label></li>';
			}
			if($options["enable_pm"]){
				$output .= '<li><label for="ln_enable_pm"><input type="checkbox" name="options[ln_enable_pm]" id="ln_enable_pm" tabindex="1" '.$ln_checked['ln_enable_pm'].' /> '.sprintf( __('Enable Notification of private message')).'</label></li>';
			}
			
			$output .= '</ul><p class="description">'.sprintf( __('These settings let you control on which events you like to be notified.')).'</p>'
				.'<div class="ln_options_save" ><input type="button" id="save_option_settings" onclick="ln_options_save_action('.$userid.');" name="options_save" value="'.sprintf( __('Save')).'"></div>'
				. '</li><div style="clear:both;"></div>'
				. "\n";
		}
	}
	return $output;
}
add_shortcode( 'ln_fetch_notifications', 'ln_fetch_notifications' );

function get_more_links($morelinks){
	$return = array();
	if($morelinks != ""){
	
	$morelinks_array = explode("\n",$morelinks);
		if(!empty($morelinks_array)){
			foreach($morelinks_array as $more_link){
				$nodes = explode("=>" , $more_link);
				if(count($nodes) == 2){
					$return[] = $nodes;
				}
			}
		}
	}
	return $return;
}


function ln_update_readflag($userid,  $start=0, $count=-1, $full=false,$type){
	global $wpdb;

	$update_ids = array(); 

	if($type == 'all'){
		return;
	}else if($type == 'comment'){
		$cond = " AND  l.content_type <> 'pm' AND substring(l.content_type,1,4) <> 'frie' AND substring(l.content_type,1,4) <> 'mod_' ";
	}
	else if($type == 'nb'){
		$cond = " AND l.content_type = 'nb'  ";
	}
	else if($type == 'pm'){
		$cond = " AND l.content_type = 'pm'  ";
	}
	if($type == 'moderation'){
		$cond = " AND substring(l.content_type,1,4) = 'mod_'  ";
	}
	
	$sql = "SELECT
			l.*
		FROM
			" . $wpdb->prefix . "livenotifications AS l
		WHERE
			l.userid = " . (int)$userid . "
			".$cond."
		ORDER BY
			l.is_read, l.id DESC
	";
	
	if ($start >= 0 && $count > 0) $sql .= " LIMIT ".(int)$start.", ".(int)$count;
	$res = $wpdb->get_results($sql);

	if (!$res || empty($res)) return ;
	
	foreach ($res as $notification) {
		if (!$notification->is_read) $update_ids[] = (int)$notification->id; // Set pulled notifications as red
	}
	if (!empty($update_ids)) {
		$newids = implode(",",$update_ids);
		$sql = "UPDATE " . $wpdb->prefix . "livenotifications SET is_read = 1
			WHERE id IN (" . $newids . ")";
		$wpdb->query($sql);

	}
}

function ln_remove_notifications($content_type, $userid, $userid_subj){
	global $wpdb;
	$sql = "DELETE FROM " . $wpdb->prefix . "livenotifications WHERE content_type = '".$content_type."' AND userid = ".$userid." AND userid_subj = ".$userid_subj ;
	return $wpdb->query($sql);
}

function ln_nb_delete_action($nb_id){
	global $wpdb;
	
	// check if the sender has deleted this notice
	$sender_deleted = $wpdb->get_var( 'SELECT `deleted` FROM ' . $wpdb->prefix . 'nb WHERE `id` = "' . $nb_id . '" LIMIT 1' );

	// create corresponding query for deleting notice
	if ( $sender_deleted == 1 ) {
		$query = 'DELETE from ' . $wpdb->prefix . 'nb WHERE `id` = "' . $nb_id . '"';
	}else{
		$query = 'UPDATE ' . $wpdb->prefix . 'nb SET `deleted` = "2" WHERE `id` = "' . $nb_id . '"';
	}
	$sql = "DELETE FROM " . $wpdb->prefix . "livenotifications WHERE content_type = 'nb' AND content_id = ".$nb_id ;
	if ($wpdb->query( $query ) ) {
		$wpdb->query( $sql);
	}
}

function ln_pm_delete_action($pm_id){
	global $wpdb;
	
	// check if the sender has deleted this message
	$sender_deleted = $wpdb->get_var( 'SELECT `deleted` FROM ' . $wpdb->prefix . 'pm WHERE `id` = "' . $pm_id . '" LIMIT 1' );

	// create corresponding query for deleting message
	if ( $sender_deleted == 1 ) {
		$query = 'DELETE from ' . $wpdb->prefix . 'pm WHERE `id` = "' . $pm_id . '"';
	}else{
		$query = 'UPDATE ' . $wpdb->prefix . 'pm SET `deleted` = "2" WHERE `id` = "' . $pm_id . '"';
	}
	$sql = "DELETE FROM " . $wpdb->prefix . "livenotifications WHERE content_type = 'pm' AND content_id = ".$pm_id ;
	if ($wpdb->query( $query ) ) {
		$wpdb->query( $sql);
	}
}

function ln_nb_reply_action($nb_id,$nb_text){
	global $wpdb, $current_user;

	$nb_parent = $wpdb->get_row("
		SELECT nb.subject, nb.sender, nb.recipient
		FROM " . $wpdb->prefix . "nb AS nb
		WHERE nb.id = " . $nb_id . "
	");
	
	$title = $nb_parent->subject;
	
	if(substr($title,0,3) != "Re:") $title = "Re:".$title;
	$userid_subj = $wpdb->get_var("SELECT ID FROM " . $wpdb->prefix . "users WHERE user_login = '".$nb_parent->sender."'");
	$new_notice = array(
		'id' => NULL,
		'subject' => $title,
		'content' => $nb_text,
		'sender' => $nb_parent->recipient,
		'recipient' => $nb_parent->sender,
		'date' => current_time( 'mysql' ),
		'read' => 0,
		'deleted' => 0
	);
	// insert into database
	if ($wpdb->insert( $wpdb->prefix . 'nb', $new_notice, array( '%d', '%s', '%s', '%s', '%s', '%s', '%d', '%d' ) ) ) {
		ln_add_user_notification($current_user->ID, $userid_subj, 'nb', $wpdb->insert_id, $nb_text, 0, 0, $nb_parent->recipient);
	}
}

function ln_pm_reply_action($pm_id,$pm_text){
	global $wpdb, $current_user;

	$pm_parent = $wpdb->get_row("
		SELECT pm.subject, pm.sender, pm.recipient
		FROM " . $wpdb->prefix . "pm AS pm
		WHERE pm.id = " . $pm_id . "
	");
	
	$title = $pm_parent->subject;
	
	if(substr($title,0,3) != "Re:") $title = "Re:".$title;
	$userid_subj = $wpdb->get_var("SELECT ID FROM " . $wpdb->prefix . "users WHERE user_login = '".$pm_parent->sender."'");
	$new_message = array(
		'id' => NULL,
		'subject' => $title,
		'content' => $pm_text,
		'sender' => $pm_parent->recipient,
		'recipient' => $pm_parent->sender,
		'date' => current_time( 'mysql' ),
		'read' => 0,
		'deleted' => 0
	);
	// insert into database
	if ($wpdb->insert( $wpdb->prefix . 'pm', $new_message, array( '%d', '%s', '%s', '%s', '%s', '%s', '%d', '%d' ) ) ) {
		ln_add_user_notification($current_user->ID, $userid_subj, 'pm', $wpdb->insert_id, $pm_text, 0, 0, $pm_parent->recipient);
	}
}


function get_excerpt($str, $startPos=0, $maxLength=140){
	if(strlen($str) > $maxLength) {
		$excerpt   = substr($str, $startPos, $maxLength-8);
		$lastSpace = strrpos($excerpt, ' ');
		$excerpt   = substr($excerpt, 0, $lastSpace);
		$excerpt  .= '...';
	}else{
		$excerpt = $str;
	}
	return $excerpt;
}

function ln_filter_nb($str) {
	$strs = explode('[/QUOTE]',$str);
	return end($strs);
}

function ln_filter_pm($str) {
	$strs = explode('[/QUOTE]',$str);
	return end($strs);
}

function ln_fetch_useroptions($userid){
	global $wpdb;
	$options = get_option('ln_options');
	$q = "SELECT enable_comment, enable_reply,
		enable_award, enable_moderation, enable_taguser, enable_nb, enable_pm
		FROM " . $wpdb->prefix . "livenotifications_usersettings WHERE userid = " . $userid;
	$res = $wpdb->get_row($q);
	if (!$res) return array(
		'enable_comment' => $options['enable_comment'],
		'enable_reply' => $options['enable_reply'],
		'enable_award' => $options['enable_award'],
		'enable_moderation' => $options['enable_moderation'],
		'enable_taguser' => $options['enable_taguser'],
		'enable_nb' => $options['enable_nb'],
		'enable_pm' => $options['enable_pm']
	);
	else return array(
		'enable_comment' => $res->enable_comment,
		'enable_reply' => $res->enable_reply,
		'enable_award' => $res->enable_award,
		'enable_moderation' => $res->enable_moderation,
		'enable_taguser' => $res->enable_taguser,
		'enable_nb' => $res->enable_nb,
		'enable_pm' => $res->enable_pm
	);
}

function ln_save_useroptions($userid, $options){
	global $wpdb;
	$check = $wpdb->get_row("SELECT userid FROM " . $wpdb->prefix . "livenotifications_usersettings WHERE userid = ".(int)$userid);
	if (isset($check->userid)){
		$q = "UPDATE " . $wpdb->prefix . "livenotifications_usersettings SET
			enable_comment = ".(int)$options['enable_comment'].",
			enable_reply = ".(int)$options['enable_reply'].",
			enable_award = ".(int)$options['enable_award'].",
			enable_moderation = ".(int)$options['enable_moderation'].",
			enable_taguser = ".(int)$options['enable_taguser'].",
			enable_nb = ".(int)$options['enable_nb'].",
			enable_pm = ".(int)$options['enable_pm']."
		WHERE userid = ".(int)$userid;
		$wpdb->query($q);
	}else{
		$q = "INSERT INTO " . $wpdb->prefix . "livenotifications_usersettings
			(enable_comment, enable_reply, enable_award, enable_moderation,
			enable_taguser, enable_nb, enable_pm, userid)
		VALUES (
			".(int)$options['enable_comment'].",
			".(int)$options['enable_reply'].",
			".(int)$options['enable_award'].",
			".(int)$options['enable_moderation'].",
			".(int)$options['enable_taguser'].",
			".(int)$options['enable_nb'].",
			".(int)$options['enable_pm'].",
			".(int)$userid."
		);";
		$wpdb->query($q);
	}
}


function ln_display_useravatar($userid) {
	global $avatar_type;
	$options = get_option("ln_options");
	
	if($options['hide_avatar']) return "";
	$size = $options['ln_avatar_height'];
	
	if($userid) {
		$local = get_usermeta($userid, 'avatar');
		if(!empty($local)) {
			$local = $newsiteurl.$local;
			$avatar_type = TYPE_LOCAL;
			return "<img alt='' src='{$local}' class='avatar avatar-{$size} photo avatar-default' height='30' width='{$size}' />";
		}else if(empty($options['ln_default_avatar'])){
			$avatar_type = TYPE_GLOBAL;
		}
	}
	return get_avatar( $userid, $size,$options['ln_default_avatar'] );
}

function ln_wrap_url($url, $txt, $cut=true) {
	return sprintf('<a onclick="event.stopPropagation();" href="%s">%s</a>', $url, $txt);
}

function ln_prune_notifications(){
	global $wpdb;
	$options = get_option('ln_options');
	$maxage = TIMENOW - (60*60*24* intval($options['max_age']));

	$sql = "DELETE FROM " . $wpdb->prefix . "livenotifications WHERE `time` < " . intval($maxage);
	return $wpdb->query($sql);

}

function time_ago($date) {
    if (empty($date)) {
        return "No date provided";
    }
    $periods = array("sec", "min", "hr", "dy", "week", "mn", "yr", "dc");
    $lengths = array("60", "60", "24", "7", "4.35", "12", "10");
    $now = time();
    $unix_date = strtotime($date);
	
	// check validity of date
    if (empty($unix_date)) {
        return "Bad date";
    }
	
	// is it future date or past date
    if ($now > $unix_date) {
        $difference = $now - $unix_date;
        $tense = "ago";
    } else {
        $difference = $unix_date - $now;
        $tense = "just now";
    }
    for ($j = 0; $difference >= $lengths[$j] && $j < count($lengths) - 1; $j++) {
        $difference /= $lengths[$j];
    }
    $difference = round($difference);
    if ($difference != 1) {
        $periods[$j].= "s";
    }
    return "$difference $periods[$j]";
}

function ln_get_timeformat($timestamp) {
	$diff = time() - (double)$timestamp;

	switch ($diff) {
		case ($diff < 30):
			return sprintf( __('Just now'), $diff);
			
		case ($diff < 60):
			return sprintf( __('%d seconds ago'), $diff);
			
		case ($diff == 60):
			return sprintf( __('1 minute ago'), $diff);

		case ($diff < 3600):
			return sprintf(__('%d minutes ago'), ceil($diff/60));
			
		case ($diff == 3600):
			return sprintf(__('1 hour ago'), ceil($diff/60));
				
		case ($diff < 86400):
			return sprintf(__('%d hours ago'), ceil($diff/3600));
			
		case ($diff == 86400):
			return sprintf(__('1 day ago'), ceil($diff/3600));

		case ($diff < 604800):
			return sprintf(__('%d days ago'), ceil($diff/86400));
			
		case ($diff == 604800):
			return sprintf(__('1 week ago'), ceil($diff/86400));
				
		case ($diff < 2419200):
			return sprintf(__('%d weeks ago'), ceil($diff/604800));

		default:
			return date(get_option( 'date_format' )." - ".get_option( 'time_format' ), (double)$timestamp);
	}
}

add_filter( 'comment_text', 'mh_commenttaglink' , 50 );
function mh_commenttaglink( $text ){
	// RegEx to find #tag, #hyphen-tag with letters and numbers
	$mh_regex = "/\ @[a-zA-Z0-9-]+/";

    // Use that RegEx and populate the hits into an array
	preg_match_all( $mh_regex , $text , $mh_matches );

    // If there's any hits then loop though those and replace those hits with a link
	for ( $mh_count = 0; $mh_count < count( $mh_matches[0] ); $mh_count++ ){
		$mh_old = $mh_matches[0][$mh_count];
		$mh_old_lesshash = str_replace( ' @' , '' , $mh_old );
		$mh_new = str_replace( $mh_old , '<a href="' . get_bloginfo( url ) . '/author/' . $mh_old_lesshash . '"/ rel="tag">' . $mh_old . '</a>' , $mh_matches[0][$mh_count] );
		$text = str_replace( $mh_old  , $mh_new , $text );
    }
	
    // Return any substitutions
    return $text;
}	


function ln_getall_content($userid,$userid_subj,$content_id,$right_width,$request_status_class,$phrase1,$phrase2,$icons,$time1,$scrollpane_height,$full){
	global $wpdb;
	
	$sql_rec=mysql_query("select * from " . $wpdb->prefix . "livenotifications where content_type='nb' and ((userid='".$userid."' and userid_subj='".$userid_subj."') or (userid='".$userid_subj."' and userid_subj='".$userid."'))");
	$numrows1=mysql_num_rows($sql_rec);
	
	$myoutput='<div onclick="ln_back_to_notices('.$content_id.','.$scrollpane_height.');" class="ln_link" id="ln_nb_back_'.$content_id.'">Back to notices</div>';
	if($numrows1>0){
		$scrollpane_height = 230;
		$myoutput .= '<ul id="ulScroll" class="ln_scrollpane" style="height: '.$scrollpane_height.'px !important;">';
		
		$var=1;
		while($numrecord=mysql_fetch_array($sql_rec)){
			if($var=='1'){
				$myoutput.='<li class="lnnbbit">';
				$myoutput.= $icons
				    . '<div style="width:'.$right_width.'px;"><div class="'.$request_status_class.'" ><p class="ln_sender_name">'
					. $numrecord['username']
					. '</p>'
					. '<p class="ln_content">'
					. $numrecord['content_text']
					. '</p>'
					. '<p class="ln_time">'.ln_get_timeformat($numrecord['time']).'</p>'
					. '</div></div><div style="clear:both;"></div></li>';
			}else{
				$myoutput.='<li class="lnnbbit">';
				$myoutput.= $icons
				    . '<div style="width:'.$right_width.'px;"><div class="'.$request_status_class.'" ><p class="ln_sender_name">'
					. $numrecord['username']
					. '</p>'
					. '<p class="ln_content">'
					. $numrecord['content_text']
					. '</p>'
					. '<p class="ln_time">'.ln_get_timeformat($numrecord['time']).'</p>'
					. '</div></div><div style="border-top: 1px solid #DDD; margin-top: 4px;padding-top: 4px;"></div><div style="clear:both;"></div></li>';
			}
			$var++;
		}
	$myoutput.='</ul>';
	}
	return $myoutput;
}


function ln_getall_dashboa($userid,$userid_subj,$content_id,$right_width,$request_status_class,$phrase1,$phrase2,$icons,$time1,$scrollpane_height,$full){
	global $wpdb;
	
	$sql_rec=mysql_query("select * from " . $wpdb->prefix . "livenotifications where content_type='pm' and ((userid='".$userid."' and userid_subj='".$userid_subj."') or (userid='".$userid_subj."' and userid_subj='".$userid."'))");
	$numrows1=mysql_num_rows($sql_rec);
	
	$myoutput='<div onclick="ln_back_to_messages('.$content_id.','.$scrollpane_height.');" class="ln_link" id="ln_pm_back_'.$content_id.'">Back to Messages</div>';
	if($numrows1>0){
		$scrollpane_height = 230;
		$myoutput .= '<ul id="ulScroll" class="ln_scrollpane" style="height: '.$scrollpane_height.'px !important;">';
		
		$var=1;
		while($numrecord=mysql_fetch_array($sql_rec)){
			if($var=='1'){
				$myoutput.='<li class="lnpmbit">';
				$myoutput.= $icons
				    . '<div style="width:'.$right_width.'px;"><div class="'.$request_status_class.'" ><p class="ln_sender_name">'
					. $numrecord['username']
					. '</p>'
					. '<p class="ln_content">'
					. $numrecord['content_text']
					. '</p>'
					. '<p class="ln_time">'.ln_get_timeformat($numrecord['time']).'</p>'
					. '</div></div><div style="clear:both;"></div></li>';
			}else{
				$myoutput.='<li class="lnpmbit">';
				$myoutput.= $icons
				    . '<div style="width:'.$right_width.'px;"><div class="'.$request_status_class.'" ><p class="ln_sender_name">'
					. $numrecord['username']
					. '</p>'
					. '<p class="ln_content">'
					. $numrecord['content_text']
					. '</p>'
					. '<p class="ln_time">'.ln_get_timeformat($numrecord['time']).'</p>'
					. '</div></div><div style="border-top: 1px solid #DDD; margin-top: 4px;padding-top: 4px;"></div><div style="clear:both;"></div></li>';
			}
			$var++;
		}
	$myoutput.='</ul>';
	}
	return $myoutput;
}

function get_avatar_type(){
	global $avatar_type;

	switch($avatar_type) {
		case TYPE_GLOBAL:	return __('Global', 'ln_notifications');
		case TYPE_LOCAL:	return __('Local', 'ln_notifications');
		default:			return __('Default', 'ln_notifications');
	}
}

function avatar_root(){
	return substr(ABSPATH, 0, -strlen(strrchr(substr(ABSPATH, 0, -1), '/')) - 1);
}

if(!function_exists('get_avatar')) :
    function get_avatar($id_or_email, $size = '', $default = '', $post = false){
		if(!get_option('show_avatars')) return false;							// Check if avatars are turned on.
		$options = get_option("ln_options");
		
		if(!is_numeric($size) || $size == '') $size = $options['ln_avatar_height'];	// Check default avatar size
		    $email = '';															// E-mail key for Gravatar.com
			$url = '';																// Anchor.
			$id = '';																// User ID.
			$src = '';																// Image source;
			
		if(is_numeric($id_or_email)) {											// Numeric - user ID...
		    $id = (int)$id_or_email;
			$user = get_userdata($id);
		
	       	if($user){
	    		$email = $user->user_email;
	    		$url = $user->user_url;
			}
     	}elseif(is_object($id_or_email)) {										// Comment object...
		    if(!empty($id_or_email->user_id)) {									// Object has a user ID, commenter was registered & logged in...
		        $id = (int)$id_or_email->user_id;
				$user = get_userdata($id);
				
				if($user){
					$email = $user->user_email;
					$url = $user->user_url;
				}
			}else{																// Comment object...
		    	switch($id_or_email->comment_type) {
				case 'trackback':											// Trackback...
				case 'pingback':
					$url_array = parse_url($id_or_email->comment_author_url);
					$url = "http://" . $url_array['host'];
				break;

				case 'comment':												// Comment...
				case '':
					if(!empty($id_or_email->comment_author_email)) $email = $id_or_email->comment_author_email;
					$user = get_user_by_email($email);
					if($user) $id = $user->ID;								// Set ID if we can to check for local avatar.
					$url = $id_or_email->comment_author_url;
				break;
		     	}
			}
		}else {																	// Assume we have been passed an e-mail address...
     		if(!empty($id_or_email)) $email = $id_or_email;
			$user = get_user_by_email($email);
			if($user) $id = $user->ID;											// Set ID if we can to check for local avatar.
		}
		
		// What class to apply to avatar images?
		$class = ($post ? 'post_avatar no-rate' : 'avatar');
		
		// Try to use local avatar.
		if($id){
			$local = get_usermeta($id, 'avatar');
			if(!empty($local)) {
				$src = get_option('siteurl').$local;
			}
		}
		
		// No local avatar source, so build global avatar source...
		if(!$src){
			if ( !empty($email) )
			$email_hash = md5( strtolower( $email ) );
		if ( is_ssl()){
			$src = 'https://secure.gravatar.com/avatar/';
		} else {
			if ( !empty($email) )
				$src = sprintf( "http://%d.gravatar.com/avatar/", ( hexdec( $email_hash{0} ) % 2 ) );
			else
				$src = 'http://0.gravatar.com/avatar/';
		}
		
		if(empty($email)) $src .= md5(strtolower((empty($default) ? UNKNOWN : BLANK)));
		else $src .= md5(strtolower($email));
		$src .= '?s=' . $size;

		$src .= '&amp;d=';
		if ($options['ln_default_avatar'] != "")
			$src .= check_switch("custom", $options['ln_default_avatar'], $size);
		else
			$src .= urlencode(FALLBACK);
		
		$rating = get_option('avatar_rating');
		if(!empty($rating)) $src .= "&amp;r={$rating}";
	}

	$avatar = "<img src='{$src}' class='{$class} avatar-{$size} avatar-default' height='{$size}' width='{$size}' style='width: {$size}px; height: {$size}px;' alt='avatar' />";

	// Return the filtered result.
	return apply_filters('get_avatar', $avatar, $id_or_email, $size, $default);
}
endif;

function check_switch($chk, $default, $size = SCALED_SIZE){
	switch ($chk){
		case 'custom': return $default;
		case 'mystery': return urlencode(FALLBACK . "?s=" . $size);
		case 'blank': return includes_url('images/blank.gif');
		case 'gravatar_default': return "";
		default: return urlencode($chk);
	}
}

//private message
include_once ( get_template_directory() . '/ntc/message.php' );

//for dispaly notification jayesh
function before_post_content(){
    do_action('before_post_content');
}	
if ( ! function_exists( 'post_content_info_box' ) ){	
	function post_content_info_box() {
		global $wpdb;
		$options = get_option('ln_options'); 
	?>
	<input type="hidden" name="login_check" id="login_check" value="<?php if(is_user_logged_in()) {echo '1';} else {echo '0';} ?>" />
	<input type="hidden" name="login_valid" id="login_valid" value="<?php echo $options['ln_bmpopup']; ?>" />
	<input type="hidden" name="xbarvalid" id="xbarvalid" value="" />
    <?php if($options['ln_bmpopup']=='enable'){
		$current_user = wp_get_current_user();    
    	$current_user->ID;
		$query_last_notification=mysql_query("select * from ".$wpdb->prefix."livenotifications  where userid='".$current_user->ID."' ORDER BY id DESC LIMIT 1 "); 
		
		while($row_time= $query_last_notification){				
		    $time=$row_time['time'];
			$now = strtotime(now);
			$new_timesecond=$now-$time;
			$new_time=floor(($now-$time)/60);
			$username1=$row_time['username'];
			$content_text=$row_time['content_text'];
			$content_id=$row_time['content_id'];
			
			echo '<div class="notification_box" id="notification_box" style="display:none;"><div class="close2" id="close1" style="display:none;margin:0px; width:10px; height:10px;cursor:pointer;">x</div>';
				$user=$row_time['userid_subj'];
				$user_content=$row_time['content_type'];
				$content_id=$row_time['content_id'];
				$rewardimg=mysql_fetch_array(mysql_query("select * from ".$wpdb->prefix."rewardsystem where reid='".$content_id."'"));
				$select_user=mysql_query("select *from ".$wpdb->prefix."users where ID='".$user."'");
				$row_user=mysql_fetch_assoc($select_user);					
				
				if($user_content=='comment'){
		       		$icons = '<i class="image notifications cmd"></i>';
		     		$phrases="commented on your post";
					$phrases1='<p ><img alt="'.$rewardimg['numlist'].' '.$rewardimg['type'].'" src="'.$rewardimg['rew_image'].'" width="40" height="40"></li><li style=" margin-left:5px; list-style:none;">'.$username1.' '.$phrases.'<br /><br /><a href="'.get_permalink($content_id).'">'.$content_text.'</a><br /><br />'.$icons.$new_timesecond.'seconds ago</p>';
				}
				if($user_content=='reply'){
					$icons = '<i class="image notifications rpy"></i>';
					$phrases="reply to your comment";
					$phrases1='<p ><img alt="'.$rewardimg['numlist'].' '.$rewardimg['type'].'" src="'.$rewardimg['rew_image'].'" width="40" height="40"></li><li style=" margin-left:5px; list-style:none;">'.$username1.' '.$phrases.'<br /><br /><a href="'.get_permalink($content_id).'">'.$content_text.'</a><br /><br />'.$icons.$new_timesecond.'seconds ago</p>';
				}
				if($user_content=='nb'){
					$icons = '<i class="image notifications nto"></i>';
					$phrases="We reviewed your report on an article. Go to your Support Inbox to learn more.";
					$phrases1='<p ><img alt="'.$rewardimg['numlist'].' '.$rewardimg['type'].'" src="'.$rewardimg['rew_image'].'" width="40" height="40"></li><li style=" margin-left:5px; list-style:none;">'.$username1.' '.$phrases.'<br /><br /><a href="'.get_permalink($content_id).'">'.$content_text.'</a><br /><br />'.$icons.$new_timesecond.'seconds ago</p>';
				}
				if($user_content=='pm'){
					$icons ='<i class="image notifications rpt"></i>';
					$phrases="has reported on post";
					$phrases1='<p ><img alt="'.$rewardimg['numlist'].' '.$rewardimg['type'].'" src="'.$rewardimg['rew_image'].'" width="40" height="40"></li><li style=" margin-left:5px; list-style:none;">'.$username1.' '.$phrases.'<br /><br /><a href="'.get_permalink($content_id).'">'.$content_text.'</a><br /><br />'.$icons.$new_timesecond.'seconds ago</p>';
				}
				if($user_content=='mod_comment'){
					$icons = '<i class="image notifications apr"></i>';
					$phrases="comment(s) awaiting for your approva";
					$phrases1='<p ><img alt="'.$rewardimg['numlist'].' '.$rewardimg['type'].'" src="'.$rewardimg['rew_image'].'" width="40" height="40"></li><li style=" margin-left:5px; list-style:none;">'.$username1.' '.$phrases.'<br /><br /><a href="'.get_permalink($content_id).'">'.$content_text.'</a><br /><br />'.icons.$new_timesecond.'seconds ago</p>';
				}
				if($user_content=='bbpressnotification'){
					$phrases="Added new topic ";
					$phrases1='<p ><img alt="'.$rewardimg['numlist'].' '.$rewardimg['type'].'" src="'.$rewardimg['rew_image'].'" width="40" height="40"></li><li style=" margin-left:5px; list-style:none;">'.$username1.' '.$phrases.'<br /><br /><a href="'.get_permalink($content_id).'">'.$content_text.'</a><br /><br />'.$new_timesecond.'seconds ago</p>';
				}
				if($user_content=='adminnotification'){
					$phrases="Sitewide Message:";
					$phrases1='<p ><img alt="'.$rewardimg['numlist'].' '.$rewardimg['type'].'" src="'.$rewardimg['rew_image'].'" width="40" height="40"></li><li style=" margin-left:5px; list-style:none;">'.$username1.' '.$phrases.'<br /><br /><a href="'.get_permalink($content_id).'">'.$content_text.'</a><br /><br />'.$new_timesecond.'seconds ago</p>';
				}
				if($user_content=='bbpressnotificationreply'){
					$phrases="replied on ";
					$phrases1='<p ><img alt="'.$rewardimg['numlist'].' '.$rewardimg['type'].'" src="'.$rewardimg['rew_image'].'" width="40" height="40"></li><li style=" margin-left:5px; list-style:none;">'.$username1.' '.$phrases.'<br /><br /><a href="'.get_permalink($content_id).'">'.$content_text.'</a><br /><br />'.$new_timesecond.'seconds ago</p>';
				}	
				if($user_content=='postaward'){
					$phrases=" is your next target";
					$phrases1='<p ><img alt="'.$rewardimg['numlist'].' '.$rewardimg['type'].'" src="'.$rewardimg['rew_image'].'" width="40" height="40"></li><li style=" margin-left:5px; list-style:none;">'.$username1.' '.$phrases.'<br /><br /><a href="'.get_permalink($content_id).'">'.$content_text.'</a><br /><br />'.$new_timesecond.'seconds ago</p>';
				}
				if($user_content=='commentaward'){
					$phrases="is your next target";
					$phrases1='<p ><img alt="'.$rewardimg['numlist'].' '.$rewardimg['type'].'" src="'.$rewardimg['rew_image'].'" width="40" height="40"></li><li style=" margin-left:5px; list-style:none;">'.$username1.' '.$phrases.'<br /><br /><a href="'.get_permalink($content_id).'">'.$content_text.'</a><br /><br />'.$new_timesecond.'seconds ago</p>';
				}
				if($user_content=='noticeaward'){
					$phrases="is your next target";
					$phrases1='<p ><img alt="'.$rewardimg['numlist'].' '.$rewardimg['type'].'" src="'.$rewardimg['rew_image'].'" width="40" height="40"></li><li style=" margin-left:5px; list-style:none;">'.$username1.' '.$phrases.'<br /><br /><a href="'.get_permalink($content_id).'">'.$content_text.'</a><br /><br />'.$new_timesecond.'seconds ago</p>';
				}
				if($user_content=='messageaward'){
					$phrases="is your next target";
					$phrases1='<p ><img alt="'.$rewardimg['numlist'].' '.$rewardimg['type'].'" src="'.$rewardimg['rew_image'].'" width="40" height="40"></li><li style=" margin-left:5px; list-style:none;">'.$username1.' '.$phrases.'<br /><br /><a href="'.get_permalink($content_id).'">'.$content_text.'</a><br /><br />'.$new_timesecond.'seconds ago</p>';
				}
				if($user_content=='readpostaward'){
					$phrases="Keep Learning";
					$phrases1='<p ><img alt="'.$rewardimg['numlist'].' '.$rewardimg['type'].'" src="'.$rewardimg['rew_image'].'" width="40" height="40"></li><li style=" margin-left:5px; list-style:none;">'.$username1.' '.$phrases.'<br /><br /><a href="'.get_permalink($content_id).'">'.$content_text.'</a><br /><br />'.$new_timesecond.'seconds ago</p>';
				}
		 		
				$url = admin_url(); 
				echo $return=$phrases1.'</div>';			
			 
		 }
		?>
<?php
	}}		  
}


function post_read_content(){
	global $wpdb;
	global $current_user;
 	get_currentuserinfo();
	
	if($current_user->ID!='0'){
		$posttype=get_post_type(get_the_ID());
		
		if($posttype=='post'){
			$count_post1= mysql_query("select * from ".$wpdb->prefix."count_reading where userid='".$current_user->ID."' and postid='".get_the_ID()."' and  posttype='readpost'");
			
			if($count_post1==0){
				mysql_query("insert into ".$wpdb->prefix."count_reading (userid,postid,readtime,posttype) values('".$current_user->ID."','".get_the_ID()."','".time()."','readpost')");
				$count_post= mysql_query("select * from ".$wpdb->prefix."count_reading where userid='".$current_user->ID."' and  posttype='readpost'");
				
				//get reward system data
				$getpostreward=mysql_query("select * from ".$wpdb->prefix."rewardsystem where type='readpost' ORDER BY `reid` ASC");
				
				while($getpostrewardrec= $getpostreward) {
					$numlist=$getpostrewardrec['numlist'];
					$repoint=$getpostrewardrec['repoint'];
					$reorder=$getpostrewardrec['reorder'];
					$type=$getpostrewardrec['type'];
					$retitle=$getpostrewardrec['retitle'];
					$rentc=$getpostrewardrec['rentc'];
					$remsg=$getpostrewardrec['remsg'];
					$reid=$getpostrewardrec['reid'];
					
					if($numlist==$count_post){
						//insert into point table
						$countpoints=mysql_query("insert into ".$wpdb->prefix."countpoints (cp_uid,cp_nbid,cp_pmid,cp_points,cp_time,cp_tasklist) values('".$current_user->ID."','".get_the_ID()."','".$repoint."','".time()."','".$reorder."')");
						$selectorder=mysql_query("select cp_tasklist from ".$wpdb->prefix."countpoints where cp_uid='".$current_user->ID."'");
						
						if(mysql_num_rows($selectorder)>0){
							$reclist=0;
							while($selectorderrec=mysql_fetch_array($selectorder)){
								if($reclist==0){
									$order .="reorder!=".$selectorderrec['cp_tasklist'];
								}else{
									$order .=" and reorder!=".$selectorderrec['cp_tasklist'];
								}
								$reclist++;
							}
						}else{
							$order="1=1";
						}
						
						$selectdata1=mysql_query("select * from ".$wpdb->prefix."rewardsystem where ".$order." ORDER BY reorder ASC");
						$rank=mysql_fetch_array($selectdata1);
						$rank_next=$rank['numlist'].' '.$rank['type'];
						
						//insert into livenotification table
						$selectoption=mysql_query("select enable_award from ".$wpdb->prefix."livenotifications_usersettings where userid='".$userid."'");
						
						if(mysql_num_rows($selectoption)>0){
							$selectoptionrec=mysql_fetch_array($selectoption);
							$award=$selectoptionrec['enable_award'];
						}else{
							$options = get_option('ln_options');
							$award=$options['enable_award'];
							
							if($award=='on'){
								$award='1';
							}else{
								$award='0';
							}
						}
						
						if($award=='1'){
							$livesnotificationtable=mysql_query("insert into ".$wpdb->prefix."livenotifications (userid,userid_subj,content_type,content_id,content_text,is_read,time,username) values('".$current_user->ID."','".$current_user->ID."','readpostaward','".$reid."','".$rentc."','".$remsg."','0','".time()."','".$rank_next."')");
						}
					}
				}
			}
		}
	}
}
add_action('wp_footer','post_read_content');
add_action('wp_footer','post_content_info_box');
?>