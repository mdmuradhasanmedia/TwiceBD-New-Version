<?php 
function lnpm_send(){
require_once ( get_template_directory() . '/ntc/live_notification.php'    );
global $wpdb, $current_user;
if ( is_user_logged_in() ){
	if( ($_GET['page'] == "lnpm_inbox") && (current_user_can('administrator')) ){
		$options1 = get_option('ln_options1');
		$current_user = wp_get_current_user();
		
     	// if delete posts
		if( isset($_POST['delete-post']) && isset($_POST['post_nonce_field']) && wp_verify_nonce($_POST['post_nonce_field'], 'post_nonce') ){
			$error    = "";
			$post_id = $_POST['post_id'];
			$author = author_details($post_id);
			
			if ( $error == "" ){
				$options1 = get_option('ln_options1'); 
				$url2 = $options1["plink_sendmsg"]; 
				$rpt_sender = $wpdb->get_results( 'SELECT sender FROM ' . $wpdb->prefix . 'pm WHERE subject = "'.$post_id.'" AND recipient = "' . $current_user->id . '" ORDER BY date DESC' );
				
				// send notification to report users
				foreach ( $rpt_sender as $rpt_senders ){
					$wpdb->query("INSERT INTO " . $wpdb->prefix . "livenotifications (id,userid,userid_subj,content_type,content_id,parent_id,content_text,is_read,time,additional_subj,username) 
					VALUES (NULL, '".$rpt_senders->sender."','1','nb','22','0', '".get_the_title($post_id)." - Post has been removed by admin from your report. Thank you for your feedback.','0','".time()."','0', '".get_the_author_meta('display_name', $rpt_senders->sender)."')");
				}
				
				// send notification to post author
				$wpdb->query("INSERT INTO " . $wpdb->prefix . "livenotifications (id,userid,userid_subj,content_type,content_id,parent_id,content_text,is_read,time,additional_subj,username) 
				VALUES (NULL, '".$author."','1','nb','22','0', 'We will get problem on ".get_the_title($post_id)." post. Be careful, otherwise you will lost your Author-ship.','0','".time()."','0', '".get_the_author_meta('display_name', $author)."')");
		    	
				// delet all rows
				$wpdb->query("DELETE FROM " .$wpdb->prefix. "pm WHERE subject='".$post_id."'");
				
				// delet wp post
				wp_delete_post($post_id);
				
				// redirect to inbox
				$options1 = get_option('ln_options1'); 
				$url2 = $options1["plink_sendmsg"]; 
				$redirect_link2 = $url2.'?page=lnpm_inbox';
				header('Location:'.$redirect_link2);
			}	
		}elseif( isset($_POST['delete-report']) && isset($_POST['post_nonce_field']) && wp_verify_nonce($_POST['post_nonce_field'], 'post_nonce') ){
			$error    = "";
			$post_id = $_POST['post_id'];
			
			if ( $error == "" ){
				// delet all rows
				$wpdb->query("DELETE FROM " .$wpdb->prefix. "pm WHERE subject='".$post_id."'");
				
				// redirect to inbox
				$options1 = get_option('ln_options1'); 
				$url2 = $options1["plink_sendmsg"]; 
				$redirect_link2 = $url2.'?page=lnpm_inbox';
				header('Location:'.$redirect_link2);
			}	
		}
		
		// if view message
		if ( isset( $_GET['action'] ) && 'view' == $_GET['action'] && !empty( $_GET['id'] ) ){
			$id = $_GET['id'];
			check_admin_referer( "lnpm-view_inbox_msg_$id" );
			
			// mark message as read
			$wpdb->update( $wpdb->prefix . 'pm', array( 'read' => 1 ), array( 'id' => $id ) );
			
			// select message information
			$msg_sub = $wpdb->get_var( 'SELECT subject FROM ' . $wpdb->prefix . 'pm WHERE id = "'.$id.'" ORDER BY date DESC LIMIT 1' );
			$msg = $wpdb->get_results( 'SELECT * FROM ' . $wpdb->prefix . 'pm WHERE `subject` = "' . $msg_sub . '" ORDER BY `date` DESC' ); ?>
	    <div class="block_posts view_msg"><h2>View Reports</h2>		
			<ul class="rpul">
			    <li>
			    	<p class="back_link"><a href="?page=lnpm_inbox"><?php _e( 'Back to Dashboard' ); ?></a></p>
				</li>
				<li>
				    <strong>Post Title: </strong><a href="<?php echo home_url(); ?>/?p=<?php echo $msg_sub; ?>"><?php echo get_the_title( $msg_sub ); ?></a><br/>
				    <strong>Reasons: </strong>
					<ul class="list_r">
				       	<?php foreach( $msg as $msg_send ){ ?>
							<li><?php echo $msg_send->content; ?> — <?php echo get_the_author_meta('display_name', $msg_send->sender); ?></li>
						<?php } ?>
				    </ul>
				</li>
				<li>
			     	<form action="" class="primary_btn" method="post" enctype="multipart/form-data">
				    	<?php wp_nonce_field('post_nonce', 'post_nonce_field'); ?>
						<input id="post_id" name="post_id" value='<?php echo $msg_sub; ?>' type="hidden">
						<input id="delete-report" name="delete-report" type="submit" value="Delete report" />
						<input id="delete-post" name="delete-post" type="submit" value="Delete Reported post" />
					</form>
				</li>
			</ul>
		</div>
	<?php return; }
	
        // if delete message
		if ( isset( $_GET['action'] ) && 'delete' == $_GET['action'] && !empty( $_GET['id'] ) ){
			$id = $_GET['id'];
			
			if ( !is_array( $id ) ) {
		    	check_admin_referer( "lnpm-delete_inbox_msg_$id" );
				$id = array( $id );
			}else{
				check_admin_referer( "lnpm-bulk-action_inbox" );
			}
			
			$error = false;
	    	foreach ( $id as $msg_id ) {
		    	// check if the sender has deleted this message
				$sender_deleted = $wpdb->get_var( 'SELECT `deleted` FROM ' . $wpdb->prefix . 'pm WHERE `id` = "' . $msg_id . '" LIMIT 1' );
				
				// create corresponding query for deleting message
				if ( $sender_deleted == 1 ) {
		    		$query = 'DELETE from ' . $wpdb->prefix . 'pm WHERE `id` = "' . $msg_id . '"';
				}else{
					$query = 'UPDATE ' . $wpdb->prefix . 'pm SET `deleted` = "2" WHERE `id` = "' . $msg_id . '"';
				}
				
				$sql = "DELETE FROM " . $wpdb->prefix . "livenotifications WHERE content_type = 'pm' AND content_id = ".$msg_id ;
		 		if ( !$wpdb->query( $query ) ) {
		    		$error = true;
				}else{
					$wpdb->query( $sql);
				}
			}
			
			if ( $error ) {
	     		$status = __( 'Error. Please try again.', 'ln_livenotifications' );
			}else{
				$status = _n( 'Message deleted.', 'Messages deleted.', count( $id ), 'ln_livenotifications' );
			}
		}
		
		// show all messages which have not been deleted by this user (deleted status != 2)
		$msgs = $wpdb->get_results( "select rpt2.id,rpt2.sender,rpt2.subject,rpt2.read,rpt2.date from " . $wpdb->prefix . "pm as rpt2 WHERE rpt2.id IN ( select Max(rpt.id ) from " . $wpdb->prefix . "pm as rpt where rpt.recipient = '".$current_user->id."' GROUP BY rpt.subject ) ORDER BY rpt2.id DESC" ); ?>
		<?php $options1 = get_option('ln_options1'); 
		$url2 = $options1["plink_sendmsg"]; 
		$admin_notice = $url2.'?page=admin_notice'; ?>
		<div class="block_posts view_msg"><h2>Reported Messages | <a href="<?php echo $admin_notice; ?>">Send Notice</a></h2><ul class="rpul"><li>
		<?php if ( empty( $msgs ) ){
	    	echo '<p>', __( 'You have no items in inbox.', 'ln_livenotifications' ), '</p>';
		}else{
	    	$n = count( $msgs );
			$num_unread = 0;
			
			foreach ( $msgs as $msg ) {
		    	if ( !( $msg->read ) ) {
					$num_unread++;
				}
			}
			echo '<p class="count_itm">', sprintf( _n( 'You have %d reported message (%d unread).', 'You have %d reported messages (%d unread).', $n, 'ln_livenotifications' ), $n, $num_unread ), '</p>';?>
		    	<ul class="list_r"><?php foreach ( $msgs as $msg ){ ?>
					<li>
				     	<?php if ( $msg->read ){ ?>
					    	<a href="<?php echo wp_nonce_url( "?page=lnpm_inbox&action=view&id=$msg->id", 'lnpm-view_inbox_msg_' . $msg->id ); ?>"><?php echo get_the_title( $msg->subject ); ?></a>
						<?php }else{ ?>
					    	<strong><a href="<?php echo wp_nonce_url( "?page=lnpm_inbox&action=view&id=$msg->id", 'lnpm-view_inbox_msg_' . $msg->id ); ?>"><?php echo get_the_title( $msg->subject ); ?></a></strong>
						<?php } ?>
				    </li>
				<?php } ?></ul>
			</li></ul>
       	<?php } ?>
		</div>
	<?php }elseif( ($_GET['page'] == "admin_notice") && (current_user_can('administrator')) ){ ?>
	<?php $options1 = get_option('ln_options1'); 
	$url2 = $options1["plink_sendmsg"]; 
	$inbox_notice = $url2.'?page=lnpm_inbox'; ?>
	<div class="block_posts notice"><h2><a href="<?php echo $inbox_notice; ?>">Reported Message</a> | Send Notice</h2>		
	<ul class="rpul"><li>
		<?php if ( $_REQUEST['page'] == 'admin_notice' && isset( $_POST['submit'] ) ){
			
			$current_user = wp_get_current_user();   
			$error   = "";
			$sender = $current_user->ID;
			$content = $_POST['content'];
			
			if($_POST['recipient'] == "") {
				$recipient = array();
			}else {
				$recipient = $_POST['recipient'];
			}
			
			$recipient = array_map( 'strip_tags', $recipient );
			$recipient = array_map( 'esc_sql', $recipient );
			
			// remove duplicate and empty recipient
			$recipient = array_unique( $recipient );
			$recipient = array_filter( $recipient );
			
			if ( empty( $recipient ) ){
		    	$error .= __('<p>Please select a recipient.</p>');
			}
			
			if ( empty( $content ) ){
		    	$error .= __('<p>Please include the reasons of report.</p>');
			}
			
			if ( $error == "" ){
				foreach ( $recipient as $rec ){
					// Send notification to post author
					$wpdb->query("INSERT INTO " . $wpdb->prefix . "livenotifications (id,userid,userid_subj,content_type,content_id,parent_id,content_text,is_read,time,additional_subj,username) 
					VALUES (NULL, '".$rec."','1','nb','22','0', '".$content."','0','".time()."','0', '".get_the_author_meta('display_name',$rec)."')");
					
					global $wp; global $wpdb;
					$options1 = get_option('ln_options1'); 
					$url2 = $options1["plink_sendmsg"]; 
					$redirect_link2 = $url2.'?notice=success';
					header('Location:'.$redirect_link2);
				}
			}else{
				echo "<p id='eror'><p>".$error."</p>";
			} 
		} ?>
	    <form method="post" action="" id="send-form">
	     	<table class="form-table">
		    	<tr>
		    		<th><label for="recipient"><?php _e( 'Recipient', 'ln_livenotifications' ); ?></label></th>
		     		<td><?php if( (isset( $_GET['recipient'])) && ($_GET['recipient'] == $_REQUEST['recipient']) ){
					    	$recipient = $_REQUEST['recipient'];
						}
						
						if( (isset( $_GET['content'])) && ($_GET['content'] == $_REQUEST['content']) ){
					    	$content = $_REQUEST['content'];
						} 
						
						// Get all users of blog
						$users = $wpdb->get_results("SELECT display_name,ID FROM $wpdb->users WHERE ID <> ".$current_user->ID." ORDER BY display_name ASC"); ?>
						<select name="recipient[]" id="recipient" size="5">
		             		<?php foreach ( $users as $user ){
				              	if( (!empty( $recipient )) && ($user->ID == $recipient) ){
									$selected = 'selected="selected"';
								}else{
									$selected = '';
								}
								echo "<option value='".$user->ID."' ".$selected.">".$user->display_name."</option>";
							} ?>
						</select>
					</td>
				</tr>
				
				<tr>
	       			<th><label for="content"><?php _e( 'Content', 'tie' ); ?></label></th>
					<td><textarea cols="4" rows="3" id="content" name="content"><?php echo $content; ?></textarea></td>
				</tr>
				
				<tr>
	       			<td>
			     		<p class="submit" id="submit">
						<input type="hidden" name="page" value="admin_notice"/>
						<input type="submit" name="submit" class="button-primary" value="Send" />
						</p>
					</td>
				</tr>
			</table>
		</form></li></ul>
	</div>
<?php }elseif ( $_GET['notice'] == 'success' ){
		echo '<div class="block_posts notice"><h2>Report Action</h2><ul class="rpul"><li><p>Your notice was successfully sent.</p></li></ul></div>';
	}elseif ( $_GET['report'] == 'success' ){
		echo '<div class="block_posts reports"><h2>Report Action</h2><ul class="rpul"><li><p>Your report has been submitted.</p></li></ul></div>';
	}else{ ?>
	    <div class="block_posts reports"><h2>Report Action</h2><ul class="rpul"><li>
         	<?php if ( $_REQUEST['page'] == 'report_send' && isset( $_POST['submit'] ) ){
				$current_user = wp_get_current_user();    
				$error   = "";
				$sender = $current_user->id;
				
				$subject = $_POST['subject'];
				$sub = url_to_postid( $subject );
				$content = $_POST['content'];
				
				if( !empty( $subject )){
			    	$reports = $wpdb->get_var( 'SELECT id FROM ' . $wpdb->prefix . 'pm WHERE sender = "' . $current_user->id . '" AND subject = "'.$sub.'" ORDER BY date DESC LIMIT 1' );
				}
				
				if ( empty( $subject )){
					$error .= __('Please enter post url to report.');
				}elseif ( $reports > 0 ){
					$error .= __('<p>You have already reported on this post.</p>');
				}	
				if ( empty( $content )){
					$error .= __('<p>Please include the reasons of report.</p>');
				}
				
				if ( $error == "" ){
					$recipient = $wpdb->get_results( 'SELECT '.$wpdb->prefix.'users.ID FROM '.$wpdb->prefix.'users WHERE (SELECT '.$wpdb->prefix.'usermeta.meta_value FROM '.$wpdb->prefix.'usermeta WHERE '.$wpdb->prefix.'usermeta.user_id = '.$wpdb->prefix.'users.ID AND '.$wpdb->prefix.'usermeta.meta_key = "'.$wpdb->prefix.'capabilities") LIKE "%administrator%" ORDER BY '.$wpdb->prefix.'users.ID DESC' );
					foreach ( $recipient as $rec ){
		             	$new_message = array(
				    		'id' => NULL,
							'subject' => url_to_postid( $subject ),
							'content' => $content,
							'sender' => $sender,
							'recipient' => $rec->ID,
							'date' => current_time( 'mysql' ),
							'read' => 0,
							'deleted' => 0
						);
						global $wpdb;
						
						// insert into pm table
						$wpdb->insert( $wpdb->prefix . 'pm', $new_message, array( '%d', '%s', '%s', '%s', '%s', '%s', '%d', '%d' ));
						
						// insert into live notifications table
						$wpdb->query("INSERT INTO " . $wpdb->prefix . "livenotifications (id,userid,userid_subj,content_type,content_id,parent_id,content_text,is_read,time,additional_subj,username) 
						VALUES (NULL, '".$rec->ID."', '".$sender."', 'pm', '" .$wpdb->insert_id. "', '0', '".get_the_title(url_to_postid( $subject ))."', '0', '".time()."', '0', '".get_the_author_meta('display_name', $sender)."')");
					}
				    $options1 = get_option('ln_options1'); 
					$url2 = $options1["plink_sendmsg"]; 
					$redirect_link = $url2.'?report=success';
					header('Location:'.$redirect_link);
				}else{
					echo "<p id='eror'><p>".$error."</p>";
				}
			} ?>
	    <form method="post" action="" id="sends-form">
	     	<table class="form_tabl_msge" width="100%">
				<?php if(isset( $_GET['subject'])){
					$subject = $_GET['subject'];
					$postid = url_to_postid( $subject );
				}
				
				if(isset( $_GET['content'])){
					$content = $_GET['content'];
				} 
				
				if( isset( $_GET['subject']) && ( $_GET['subject'] == $_REQUEST['subject'] )){ ?>
                	<tr>
	                	<td class="report_content"><?php _e('You are going to report ' );?>“<a href="<?php echo $subject; ?>"><?php echo get_the_title($postid); ?></a>”<input type="hidden" id="subject" name="subject" autocomplete="off" value="<?php echo $subject; ?>" /></td></td>
					</tr>
				<?php }else{ ?>	
			    	<tr>
			     		<td class="report_content"><?php echo get_bloginfo('name'); _e(" is a open place to share knowledge. Any one who is 'Author' can create post. There might be fake or spam post. Please report those post here. Admin panel will taka action about those within 24 hours."); ?></td>
					</tr>
					
					<tr>
	                	<th><label for="subject"><?php _e('Post url to Report', 'tie'); ?></label></th>
				       	<td><input type="text" id="subject" name="subject" autocomplete="off" value="<?php echo $subject; ?>"/></td>
					</tr>
				<?php } ?>
				
				<tr>
	               	<th><label for="content"><?php _e('Reasons of Report', 'tie'); ?></label></th>
					<td><textarea cols="4" rows="3" id="content" name="content"><?php echo $content; ?></textarea></td>
				</tr>
				
				<tr>
		     		<td>
		    			<p style="padding:0px;" id="submit">
				     		<input type="hidden" name="page" value="report_send"/>
							<input type="submit" name="submit" class="button-primary" value="Report"/>
					    	<?php if( isset( $_GET['subject']) && ( $_GET['subject'] == $_REQUEST['subject'] )){ ?>
						    	<a class="back_page" href="<?php echo $_GET['subject']; ?>">Back</a>
							<?php } ?>
						</p>  
					</td>
				</tr>
		    </table>
		</form></li></ul>
		</div>
	<?php }
	}else{
     	$options1 = get_option('ln_options1'); 
		$url2 = $options1["plink_sendmsg"]; 
		wp_redirect( wp_login_url( $url2 ) ); 
		exit;
	}
}
add_shortcode( 'lnpm_send', 'lnpm_send' );