<form method="post" action="options.php">
    <?php
    settings_fields( 'wpc-settings' );
    do_settings_sections( 'wpc-settings' );
    $op_pg = esc_attr( get_option('wpc_pages') );
	$op_pg_exp = explode(",", esc_attr( get_option('wpc_pages') ));
	echo isset($_GET["settings-updated"]) ? '<div id="updated" class="updated notice is-dismissible"><p>Settings updated.</p></div>' : '';
	echo isset($_GET["deleted"]) ? '<div id="updated" class="updated notice is-dismissible"><p>Data deleted successfully. Please consider <strong>deactivating</strong> then activating this plugin if you want to use it again.</p></div>' : '';
	?>
	<h2>WpChats Plugin Settings</h2>
	<table class="widefat striped wpc-table">
		<tr><td><h3>Pages</h3></td><td></td></tr>
		<tr>
			<td><label for="wpc_s_1">Messages page</label></td>
			<td>
				<?php 
				echo '<select name="wpc_s_1" id="wpc_s_1">';
				$pgar = get_all_page_ids();
				foreach ( $pgar as $pg ) {
					$op = ( get_option( 'wpc_s_1' ) ) ? get_option( 'wpc_s_1' ) : $op_pg_exp[0];
					$selected = ( $pg == $op ) ? 'selected="selected"' : '';
					echo ( get_post_status ( $pg ) == 'publish' ) ? "<option value=\"$pg\" $selected>".get_the_title($pg)."</option>" : '';
				}
				echo '</select>';
				?>
				<span onclick="helpToggle(1,this);" class="wpc_help">help</span>
			</td>
		</tr>
		<tr id="help_s_1" style="display: none;" class="wpc_help"><td>&nbsp;</td><td>Choose the page where you want the conversations to be shown, and don't forget to add this shortcode <code>[wpc-messages]</code> to the page you select in case you switch the default page created by this plugin to another.</td></tr>
		<tr>
			<td><label for="wpc_s_2">Profiles page</label></td>
			<td>
				<?php
				echo '<select name="wpc_s_2" id="wpc_s_2">';
				$pgar = get_all_page_ids();
				foreach ( $pgar as $pg ) {
					$op = ( get_option( 'wpc_s_2' ) ) ? get_option( 'wpc_s_2' ) : $op_pg_exp[1];
					$selected = ( $pg == $op ) ? 'selected="selected"' : '';
					echo ( get_post_status ( $pg ) == 'publish' ) ? "<option value=\"$pg\" $selected>".get_the_title($pg)."</option>" : '';
				}
				echo '</select>';
				?>
				<span onclick="helpToggle(2,this);" class="wpc_help">help</span>
			</td>
		</tr>
		<tr id="help_s_2" style="display: none;" class="wpc_help"><td>&nbsp;</td><td>Choose the page where you want the users and profiles to be displayed, and don't forget to add this shortcode <code>[wpc-users]</code> to the page you select in case you switch the default page created by this plugin to another.</td></tr>
		<tr><td><h3>Pagination</h3></td><td></td></tr>
		<tr>
			<td><label for="wpc_s_3">Messages</label></td>
			<td><input type="number" max="200" min="1" name="wpc_s_3" value="<?php echo esc_attr(get_option('wpc_s_3')); ?>" id="wpc_s_3" /><span onclick="helpToggle(3,this);" class="wpc_help">help</span></td>
		</tr>
		<tr id="help_s_3" style="display: none;" class="wpc_help"><td>&nbsp;</td><td>Number of messages per page, to show in the messages page</td></tr>
		<tr>
			<td><label for="wpc_s_4">Users</label></td>
			<td><input type="number" max="200" min="1" name="wpc_s_4" value="<?php echo esc_attr(get_option('wpc_s_4')); ?>" id="wpc_s_4" /><span onclick="helpToggle(4,this);" class="wpc_help">help</span></td>
		</tr>
		<tr id="help_s_4" style="display: none;" class="wpc_help"><td>&nbsp;</td><td>Number of users per page, to show in the users page</td></tr>

		<tr>
			<td><label for="wpc_s_9">Inside-conversation messages</label></td>
			<td><input type="number" max="200" min="1" name="wpc_s_9" value="<?php echo esc_attr(get_option('wpc_s_9')); ?>" id="wpc_s_9" /><span onclick="helpToggle(9,this);" class="wpc_help">help</span></td>
		</tr>
		<tr id="help_s_9" style="display: none;" class="wpc_help"><td>&nbsp;</td><td>Number of messages to display per page within the conversations</td></tr>
		<tr><td><h3>Moderation</h3></td><td></td></tr>
		<tr>
			<td><input type="checkbox" name="wpc_s_5" <?php echo get_option('wpc_s_5') == 'on' || get_option('wpc_s_5') !== '' && get_option('wpc_s_5') !== 'on' ? 'checked' : '' ?> id="wpc_s_5" />
			<label for="wpc_s_5">Allow moderators to ban/unban users</label>
			<span onclick="helpToggle(5,this);" class="wpc_help">help</span>
			</td><td></td>
		</tr>
		<tr id="help_s_5" style="display: none;" class="wpc_help"><td class="wpc_help">By default, chat moderators can search users and ban or unban them through their <a href="<?php echo $wpchats->get_settings('profile_page'); ?>?mod=1">moderation panel</a>. Would you like to prevent this?</td></tr>
		<tr>
			<td><input type="checkbox" name="wpc_s_8" <?php echo get_option('wpc_s_8') && get_option('wpc_s_8') == 'on' ? 'checked' : '' ?> id="wpc_s_8" />
			<label for="wpc_s_8">Allow moderators to view user conversations and messages</label>
			<span onclick="helpToggle(8,this);" class="wpc_help">help</span>
			</td><td></td>
		</tr>
		<tr id="help_s_8" style="display: none;" class="wpc_help"><td class="wpc_help">Check this if you want to allow moderators to read other users' messages anytime. This could help out when investigating a reported message BUT it is not recommended to turn this on if moderators are going to use it to spy on users' private messages. Admin messages are excluded. It's up to you, be wise :)</td></tr>		
		<tr>
			<td><input type="checkbox" name="wpc_s_7" disabled <?php echo get_option('wpc_s_7') == 'on' || get_option('wpc_s_7') !== '' && get_option('wpc_s_7') !== 'on' ? 'checked' : '' ?> id="wpc_s_7" />
			<label for="wpc_s_7">Allow users to update their reports anytime</label>
			<span onclick="helpToggle(7,this);" class="wpc_help">help</span><?php $wpchats->pro_notice(true); ?>
			</td><td></td>
		</tr>
		<tr id="help_s_7" style="display: none;" class="wpc_help"><td class="wpc_help">By default, after any user reports a message (using the report link in the conversations), they will be able to view and update their report within the report page. Would you like to prevent users from updating their submitted reports anytime?</td></tr>
		<tr>
			<td><input type="checkbox" name="wpc_s_6" disabled="disabled" <?php echo get_option('wpc_s_6') == 'on' || get_option('wpc_s_6') !== '' && get_option('wpc_s_6') !== 'on' ? 'checked' : '' ?> id="wpc_s_6" />
			<label for="wpc_s_6">Allow users to delete their reports anytime</label>
			<span onclick="helpToggle(6,this);" class="wpc_help">help</span><?php $wpchats->pro_notice(true); ?>
			</td><td></td>
		</tr>
		<tr id="help_s_6" style="display: none;" class="wpc_help"><td class="wpc_help">By default, after any user reports a message (using the report link in the conversations), they will be able to view and update their report within the report page, and they can also delete this report. Would you like to prevent users from deleting their submitted reports anytime?</td></tr>
		<?php if( function_exists( 'bbpress' ) ) :; ?>
		<tr><td><h3>bbPress</h3></td><td></td></tr>
			<tr>
				<td>
					<input type="checkbox" name="wpc_s_20" id="wpc_s_20" <?php echo get_option('wpc_s_20') == 'on' || get_option('wpc_s_20') !== '' && get_option('wpc_s_20') !== 'on' ? 'checked' : '' ?>  />
					<label for="wpc_s_20">Show meta in bbPress user profile</label>
					<span onclick="helpToggle(20,this);" class="wpc_help">help</span><br>
				</td><td></td>
			</tr>
			<tr id="help_s_20" style="display: none;" class="wpc_help"><td class="wpc_help">Display user contact link, user online status and block/unblock in user bbPress profile?</td></tr>
			<tr>
				<td>
					<label>
						<input type="checkbox" name="wpc_s_30" id="wpc_s_30" <?php echo $wpchats->get_settings('add_after_bbp_auth_details') ? 'checked' : '' ?>  />
						Add meta after author details in forum topics/replies
					</label>
					<span onclick="helpToggle(30,this);" class="wpc_help">help</span>
				</td><td></td>
			</tr>
			<tr id="help_s_30" style="display: none;" class="wpc_help"><td class="wpc_help">If checked, we will display the user online status, contact link and block/unblock link in their topics and replies under their avatars</td></tr>
		<?php endif; ?>
		<?php if( function_exists( 'buddypress' ) ) :; ?>
		<tr><td><h3>BuddyPress</h3></td><td></td></tr>
			<tr>
				<td>
					<input type="checkbox" name="wpc_s_21" id="wpc_s_21" <?php echo get_option('wpc_s_21') == 'on' || get_option('wpc_s_21') !== '' && get_option('wpc_s_21') !== 'on' ? 'checked' : '' ?>  />
					<label for="wpc_s_21">Show meta in BuddyPress user profile</label>
					<span onclick="helpToggle(21,this);" class="wpc_help">help</span><br>
				</td><td></td>
			</tr>
			<tr id="help_s_21" style="display: none;" class="wpc_help"><td class="wpc_help">Display user contact link, user online status and block/unblock in user BuddyPress profile?</td></tr>
		<?php endif; ?>

		<tr><td><h3>Translation</h3></td><td></td></tr>
		<tr>
			<td>
				<label>
					<input type="checkbox" name="wpc_s_26" <?php echo $wpchats->get_settings('translation') ? 'checked="checked"' : ''; ?>  />
					Enable translation
				</label>
				<span onclick="helpToggle(26,this);" class="wpc_help">help</span>
			</td>
		</tr>
		<tr id="help_s_26" style="display: none;" class="wpc_help"><td class="wpc_help">Check this option to enable translation. You can update translations in 'translation' section</td></tr>
		<tr>
			<td>
				<input type="checkbox" name="wpc_s_25" id="wpc_s_25" <?php echo $wpchats->get_settings('rtl') ? 'checked="checked"' : ''; ?>  />
				<label for="wpc_s_25">Display in RTL (Right-to-left) direction</label>
				<span onclick="helpToggle(25,this);" class="wpc_help">help</span><br>
			</td><td></td>
		</tr>
		<tr id="help_s_25" style="display: none;" class="wpc_help"><td class="wpc_help">RTL stands for right-to-left, some of languages are displayed in RTL mode. Leave unchecked for LTR default mode.</td></tr>
		<tr><td><h3>Other settings</h3></td><td></td></tr>
		<tr>
			<td><label for="wpc_s_18">New message sound</label></td>
			<td>
				<input type="url" disabled="disabled" name="wpc_s_18" value="<?php echo $wpchats->get_settings('beep'); ?>" id="wpc_s_18" class="wpc_uploader_target" onchange="document.getElementById('wpc-audio').setAttribute('src', this.value);" size="40" />
				<span onclick="helpToggle(18,this);" class="wpc_help">help</span><br>
				<span class="button"><i class="dashicons dashicons-upload" style="vertical-align: text-bottom;"></i>Upload</span>
				<span onclick="audioPlay(this)" id="play-audio" class="button">Preview</span>
				<audio id="wpc-audio" src="<?php echo $wpchats->get_settings('beep'); ?>" onended="audioStop(this);"></audio>
				<?php $wpchats->pro_notice(true); ?>
			</td>
		</tr>
		<tr id="help_s_18" style="display: none;" class="wpc_help"><td></td><td>When a user receives a new message, we'll automatically play this audio alert. Upload a new audio or paste a valid URL here.</td></tr>
		<tr>
			<td><label for="wpc_s_19">New message tab title</label></td>
			<td>
				<input type="text" name="wpc_s_19" id="wpc_s_19" value="<?php echo $wpchats->get_settings('new_message_text'); ?>" size="30" />
				<span onclick="helpToggle(19,this);" class="wpc_help">help</span><?php $wpchats->pro_notice(true); ?>
			</td>
		</tr>
		<tr id="help_s_19" style="display: none;" class="wpc_help"><td></td><td>When there's a new message, the browser tab will switch the title repeatedly until user sees the message.<br>Which tab title would it be?</td></tr>
		<tr>
			<td>
				<input type="checkbox" name="wpc_s_24" id="wpc_s_24" <?php echo $wpchats->get_settings('can_go_offline') ? 'checked' : '' ?>  />
				<label for="wpc_s_24">Allow users to go offline</label>
				<span onclick="helpToggle(24,this);" class="wpc_help">help</span><br>
			</td><td></td>
		</tr>
		<tr id="help_s_24" style="display: none;" class="wpc_help"><td class="wpc_help">If enabled, any user can go offline (their online status won't get updated), and they can choose to do so from their profile settings pages.</td></tr>
		<tr>
			<td><label>Redirect user profiles to</label></td>
			<td>
				<label<?php echo !function_exists('bbpress') ? ' title="bbPress is not active"' : ''; ?>><input type="radio" name="wpc_s_29" value="bbp" <?php echo $wpchats->get_settings('redirect_profile_to') == 'bbp' ? 'checked="checked"' : ''; ?><?php echo !function_exists('bbpress') ? ' disabled="disabled"' : ''; ?>/>bbPress <?php echo !function_exists('bbpress') ? '<i>(not active)</i>' : ''; ?></label><br/>
				<label<?php echo !function_exists('buddypress') ? ' title="BuddyPress is not active"' : ''; ?>><input type="radio" name="wpc_s_29" value="bp" <?php echo $wpchats->get_settings('redirect_profile_to') == 'bp' ? 'checked="checked"' : ''; ?><?php echo !function_exists('buddypress') ? ' disabled="disabled"' : ''; ?>/>BuddyPress <?php echo !function_exists('buddypress') ? '<i>(not active)</i>' : ''; ?></label><br/>
				<label><input type="radio" name="wpc_s_29" value="auth" <?php echo $wpchats->get_settings('redirect_profile_to') == 'auth' ? 'checked="checked"' : ''; ?>/>Author archives</label>
				<p><a href="javascript: wpc_uncheck_rdr('wpc_s_29');">clear</a></p>
				<p>
					<?php if(function_exists('bbpress')):;?><label>bbPress user profile base<br/><input type="text" name="wpc_s_27" value="<?php echo $wpchats->get_settings('bbp_user_base'); ?>" /></label><br/><?php endif; ?>
					<?php if(function_exists('buddypress')):;?><label>BuddyPress user profile base<br/><input type="text" name="wpc_s_28" value="<?php echo $wpchats->get_settings('bp_user_base'); ?>" /></label><?php endif; ?>
				</p>
				<p><span onclick="helpToggle(29,this);" class="wpc_help">help</span></p>
			</td>
		</tr>
		<tr id="help_s_29" style="display: none;" class="wpc_help"><td class="wpc_help"><p>Redirecting will result in making user profiles point to their bbPress or BuddyPress or author archives pages. Please note that still, users can edit their WpChats profiles to update their preferences and settings.</p>		<p><strong>bbPress user profile base:</strong> enter the URL structure, example if your profile URL is at <i>http://mysite.com/forums/users/matt</i> then enter <i>http://mysite.com/forums/users/</i></p><p><strong>BuddyPress user profile base:</strong> enter the URL structure, example if your profile URL is at <i>http://mysite.com/members/matt</i> then enter <i>http://mysite.com/members/</i></p></td></tr><tr>
			<td>
				<label for="wpc_s_22" style="cursor:default">Banned words <?php echo $wpchats->get_settings('banned_words') && count($wpchats->get_settings('banned_words')) !== 0 ? '('.count($wpchats->get_settings('banned_words')).')' : ''; ?></label>
			</td>
			<td>
				<div style="max-width:500px"><div id="banned-words"></div><span class="add-banned" onclick="addBanned()">+ Add word</span></div>
				<br />
				<?php if($wpchats->get_settings('banned_words') && count($wpchats->get_settings('banned_words')) !== 0) { ?>
					<textarea data-name="wpc_s_22" id="wpc_s_22" cols="50" rows="5" style="display:none"><?php foreach ( $wpchats->get_settings('banned_words') as $word ) { echo $word . ','; } ?></textarea>
				<?php } else { ?>
					<textarea data-name="wpc_s_22" id="wpc_s_22" cols="50" rows="5" style="display:none"></textarea>
				<?php } ?>
				<span onclick="helpToggle(22,this);" class="wpc_help">help</span>
				<?php $wpchats->pro_notice(true); ?>
			</td>
		</tr>
		<tr id="help_s_22" style="display: none;" class="wpc_help"><td></td><td>Automatically reject sending messages containing these words (bad words, etc).</td></tr>

		<tr>
			<td><label for="wpc_s_23">Custom CSS</label></td>
			<td><textarea name="wpc_s_23" id="wpc_s_23" cols="50" rows="5"><?php echo get_option('wpc_s_23'); ?></textarea>
			<p></p>
			<span onclick="helpToggle(23,this);" class="wpc_help">help</span>
			</td>
		</tr>
		<tr id="help_s_23" style="display: none;" class="wpc_help"><td></td><td>Enter your valid custom styles (CSS) </td></tr>

	</table>
	<?php submit_button(); ?>
	<span class="button" onclick="window.location.href='admin.php?page=wpchats&amp;section=settings&amp;format=1';" style="opacity:.7">Delete everything</span>
</form>
<?php
if(is_numeric(get_option('wpc_s_1')) && is_numeric(get_option('wpc_s_2'))){
	update_option('wpc_pages', esc_attr( get_option( 'wpc_s_1' ).','.get_option( 'wpc_s_2' ) ) );
}