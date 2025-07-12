<form method="post" action="options.php" id="mailing">
    <?php $wpchats->pro_notice(); ?>
	<?php
    echo isset($_GET["settings-updated"]) ? '<div id="updated" class="updated notice is-dismissible"><p>Changes saved successfully.</p></div>' : '';
    ?>
    <div>
    	<h2>New message notification:</h2>
    	<p>Notify offline users of new received messages via email.</p>
    	<h3>Allowed shortcodes:</h3>
    	<p>
    		<code>[sender]</code>: displays the name of the message sender.<br>
    		<code>[recipient]</code>: displays the name of the message recipient (sent-to).<br>
    		<code>[site-name]</code>: outputs your blog name (<?php bloginfo('name'); ?>).<br>
    		<code>[site-description]</code>: outputs your blog description (<?php bloginfo('description'); ?>).<br>
    		<code>[message]</code>: outputs the message content.<br>
    		<code>[message-link]</code>: ouputs a link to the conversation where the message belongs.<br>
    		<code>[settings-link]</code>: outputs settings edit link where the user can update their preferences including email-notification settings.<br>
    		<code>[sender-link]</code>: a link to the sender's profile.<br>
    		<code>[recipient-link]</code>: a link to the recipient (sent-to-user)'s profile.
    	</p>
    	<h3><label for="wpc_s_11">Message subject:</label></h3>
    	<input type="text" name="wpc_s_11" value="<?php echo $wpchats->get_settings('new_msg_notif_subject') ?>" id="wpc_s_11" class="widefat"/>
    	<p></p>
    	<h3><label for="wpc_s_10">Message body:</label></h3>
		<textarea name="wpc_s_10" cols="100" rows="9" id="wpc_s_10" class="widefat"><?php echo $wpchats->get_settings('new_msg_notif_body'); ?></textarea>
    </div>
    <div>
        <h2>Reported messages:</h2>
    	<p>Notify chat moderators of reported messages, via email.</p>
    	<p>
    		<h3>Allowed shortcodes:</h3>
    		<p>
				<code>[moderator]</code>: displays the name of the moderator.<br>
				<code>[moderator-link]</code>: a link to the moderator's profile.<br>
				<code>[settings-link]</code>: outputs moderator's edit profile settings link.<br>
				<code>[reported-count]</code>: outputs the count (number) of reported messages.<br>
				<code>[reported-message-details]</code>: outputs details about every reported message within the email.<br>
				<code>[site-name]</code>: outputs your blog name (<?php bloginfo('name'); ?>).<br>
				<code>[site-description]</code>: outputs your blog description (<?php bloginfo('description'); ?>).<br>
				<code>[mod-panel]</code>: displays a link to the moderation panel.<br>
				<code>[mod-notification-setting]</code>: outputs <code>instant</code> for moderators who subscribed for instant updates, and <code>daily</code> for those who choose to receive daily summaries.
   			</p>
    		<p>
    			<h3><label for="wpc_s_14">Message subject:</label></h3>
    			<input type="text" class="widefat" name="wpc_s_14" id="wpc_s_14" class="widefat" value="<?php echo $wpchats->get_settings('mod_notif_ins_subject'); ?>" />
		    	<p></p>
    			<h3><label for="wpc_s_15">Message body:</label></h3>
    			<textarea name="wpc_s_15" cols="100" rows="9" id="wpc_s_15" class="widefat"><?php echo $wpchats->get_settings('mod_notif_ins_body'); ?></textarea>
    		</p>
    		
    	</p>
    </div>
    <div>
    	<h2>New moderator message:</h2>
    	<p>Notify newly-created moderator via email.</p>
    	<h3>Allowed shortcodes:</h3>
    	<p>
			<code>[moderator]</code>: displays the name of the moderator.<br>
			<code>[moderator-link]</code>: a link to the moderator's profile.<br>
			<code>[settings-link]</code>: outputs moderator's edit profile settings link.<br>
			<code>[site-name]</code>: outputs your blog name (<?php bloginfo('name'); ?>).<br>
			<code>[site-description]</code>: outputs your blog description (<?php bloginfo('description'); ?>).<br>
			<code>[mod-panel]</code>: displays a link to the moderation panel.<br>
    	</p>
    	<p>
			<h3><label for="wpc_s_16">Message subject:</label></h3>
			<input type="text" class="widefat" name="wpc_s_16" id="wpc_s_16" class="widefat" value="<?php echo $wpchats->get_settings('new_mod_notif_subject'); ?>" />
	    	<p></p>
			<h3><label for="wpc_s_17">Message body:</label></h3>
			<textarea name="wpc_s_17" cols="100" rows="9" id="wpc_s_17" class="widefat"><?php echo $wpchats->get_settings('new_mod_notif_body'); ?></textarea>
    	</p>
    </div>
    <div>
    	<h2>Mail headers:</h2>
    	<p>
    		<h3><label for="wpc_s_12">From name:</label></h3>
    		<input type="text" name="wpc_s_12" id="wpc_s_12" value="<?php echo $wpchats->get_settings('mail_headers_from_name'); ?>" /><br>
    		<h3><label for="wpc_s_13">From email:</label></h3>
    		<input type="email" name="wpc_s_13" id="wpc_s_13" value="<?php echo $wpchats->get_settings('mail_headers_from'); ?>" />
    	</p>
    </div>
    <?php submit_button(); ?>
    <sub>Tip: for default values, make fields empty and then save changes.</sub>
</form>