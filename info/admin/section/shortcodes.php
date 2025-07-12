<h2>Shortcodes</h2>
<p>Below you can find couple shortcodes you can implement in your website. Don't forget to replace <code>{user_id}</code> with the user you are displaying their information. You can request more shortcodes, just <a href="http://samelh.com/contact/" target="_blank">let us know</a>.</p>
<table class="wp-list-table widefat striped scd wpc-table">
	<th>Code</th><th>Return</th>
	<tr><td><code>[wpchats-author-card]</code></td><td> Can be placed within <code>author.php</code> author archieves template, outputs a card containg some information about the currently viewing author. Use <code><?php echo esc_attr("<?php echo do_shortcode('[wpchats-author-card]'); ?>"); ?></code> to place it in a PHP template.</td></tr>
	<tr><td><code>[wpchats-author-card full="1"]</code></td><td> Can be placed within <code>author.php</code> author archieves template, outputs a snippet containg the currently viewing author's WPChats profile. Use <code><?php echo esc_attr("<?php echo do_shortcode('[wpchats-author-card full=\"1\"]'); ?>"); ?></code> to place it in a PHP template.</td></tr>
	<tr><td><code>[wpc type="user" part="online_status" id="{user_id}"]</code></td><td> returns online status for user in id attribute. If id is not set, the return will be for current user.</td></tr>
	<tr><td><code>[wpc type="user" part="unread_count"]</code></td><td> returns the count (number) of unread messages current user has.</td></tr>
	<tr><td><code>[wpc type="user" part="blocked_count"]</code></td><td> returns the count (number) of users that current user has blocked.</td></tr>
	<tr><td><code>[wpc type="user" part="online_count"]</code></td><td> returns the count (number) of online users.</td></tr>
	<tr><td><code>[wpc type="user" part="reported_count"]</code></td><td> if current user is a chat moderator, this returns number of queued messages in their moderation panel.</td></tr>
	<tr><td><code>[wpc type="user" part="avatar" id="{user_id}"]</code></td><td> returns an avatar(image) for the user in ID attribute or current user if id is not set. To set the size of the image, add the size (number) in <code>part</code> attribute after a hyphen: e.g <code>[wpc type="user" part="avatar_250" id="2"]</code> for 250 pixels.</td></tr>
	<tr><td><code>[wpc type="user" part="avatar_url" id="{user_id}"]</code></td><td> returns avatar(image) URL for the user in ID attribute or current user if id is not set.</td></tr>
	<tr><td><code>[wpc type="user" part="profile_link" id="{user_id}"]</code></td><td> returns a clickable link, liking to user's chat profile. Link text is the user nicename.</td></tr>
	<tr><td><code>[wpc type="user" part="profile_link_url" id="{user_id}"]</code></td><td> returns link URL to user profile.</td></tr>
	<tr><td><code>[wpc type="user" part="block_link" id="{user_id}"]</code></td><td> returns a block/unlock link allowing current user to block or unblock the user in ID attribute.</td></tr>
	<tr><td><code>[wpc type="user" part="user_bio" id="{user_id}"]</code></td><td> returns user's biography if set.</td></tr>
	<tr><td><code>[wpc type="user" part="user_twitter" id="{user_id}"]</code></td><td> returns user's Twitter link if set.</td></tr>
	<tr><td><code>[wpc type="user" part="user_facebook" id="{user_id}"]</code></td><td> returns user's Facebook link if set.</td></tr>
	<tr><td><code>[wpc type="user" part="user_youtube" id="{user_id}"]</code></td><td> returns user's YouTube link if set.</td></tr>
	<tr><td><code>[wpc type="user" part="user_google" id="{user_id}"]</code></td><td> returns user's Google+ link if set.</td></tr>
	<tr><td><code>[wpc type="user" part="user_linkedin" id="{user_id}"]</code></td><td> returns user's Linkedin link if set.</td></tr>
	<tr><td><code>[wpc type="user" part="user_website" id="{user_id}"]</code></td><td> returns user's website link if set.</td></tr>
</table>