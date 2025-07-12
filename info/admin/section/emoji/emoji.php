<?php
echo isset($_GET["updated"]) ? '<div id="updated" class="updated notice is-dismissible"><p>Updated successfully!</p></div>' : '';
echo isset($_GET["deleted"]) ? '<div id="updated" class="updated notice is-dismissible"><p>Deleted successfully!</p></div>' : '';
echo isset($_GET["added"]) ? '<div id="updated" class="updated notice is-dismissible"><p>Emoji added successfully!</p></div>' : '';
echo isset($_GET["invalid_url"]) ? '<div id="error" class="error notice is-dismissible"><p>Please enter a valid URL</p></div>' : '';
echo isset($_GET["required"]) ? '<div id="error" class="error notice is-dismissible"><p>All 3 fields are required.</p></div>' : '';
echo isset($_GET["used_code"]) ? '<div id="error" class="error notice is-dismissible"><p>This code is already being used.</p></div>' : '';
echo isset($_GET["found"]) ? '<div id="error" class="error notice is-dismissible"><p>This emoji does not exist.</p></div>' : '';
echo isset($_GET["css"]) ? '<div id="updated" class="updated notice is-dismissible"><p>Custom CSS saved successfully!</p></div>' : '';
add_action('admin_enqueue_scripts', function() { wp_enqueue_media(); });
$option = get_option('wpc_admin_smileys');
$defaul_codes = array(
				':)',
				':D',
				':(',
				':\'(',
				':P',
				'O-)',
				'3-)',
				'o.O',
				';)',
				':O',
				'-_-',
				'>_<',
				':*',
				'<3',
				'^_^',
				'8-)',
				'8|',
				'>-(',
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
				);
if( $option && strlen($option) > 0 ) {
	$existing_codes = ''; 
	$ar2 = '';
	foreach( explode(',', $option) as $emo ) {
		if( strlen($emo) > 0 ) {
			$urlV = explode('url="', $emo);
			$url = substr($urlV[1], 0, strpos($urlV[1], '" code="'));
			$codeV = explode('code="', $emo);
			$code = substr($codeV[1], 0, strpos($codeV[1], '" alt="'));
			$altV = explode('alt="', $emo);
			$alt = substr($altV[1], 0, strpos($altV[1], '"}'));
			$existing_codes .= $code . ',';
		}
	}
}
if( isset($_GET["edit"]) || isset($_GET["delete"]) ) {
	include('actions.php');
	exit;
}
$wpchats = new wpchats;
$wpchats->pro_notice();
?>
<h2>Emoji</h2>
<p>An emoji or emoticon or smiley is a small digital image or icon used to express an idea, emotion, etc., in electronic communication. This page will let you upload more emoji to be used within the conversations. You can edit or delete those emoticons you upload anytime, using below tools.</p>
<p>Use below-form to upload a new icon. Here are some instructions to get you started:
<li>Download an emoticon (image), save it and then upload it using the 'upload image' button below. Here's a website where we have downloaded all the beautiful emoji used in this plugin: <a href="http://www.symbols-n-emoticons.com/p/facebook-emoticons-list.html" target="_blank">http://www.symbols-n-emoticons.com/p/facebook-emoticons-list.html</a></li>
<li>Fill in a code for the emoji, which will be used to display the icon whenever a user sends a message containing that code. Example <code>:|</code>, <code>:big-smile:</code>, <code>T_T</code> etc. Tip: type something special, it should better start and end in specific character to avoid replacing all text within conversations with emoji. And, avoid repeating existing/default codes and don't use these 2 characters <code>&lt;</code>&amp;<code>&gt;</code> as they'll be stripped.</li>
<li>Type-in a description or alternative text for the emoji. Example <code>big smile</code>.</li>
</p>
<h3>Add new emoticon</h3>
<form action="#" method="post" id="add_smiley">
<table class="wp-list-table widefat striped">
	<tr>
		<td><label for="su">Image URL</label></td>
		<td>
			<input type="url" name="smiley_url" placeholder="emoji image URL" id="su" size="20" value="<?php echo isset($_GET["url"]) ? $_GET["url"] : ''; ?>" class="wpc_uploader_target" />
			<span class="button wpc_uploader"><i class="dashicons dashicons-upload" style="vertical-align: text-bottom;"></i>upload image</span>
		</td>
	</tr>
	<tr>
		<td><label for="sc">Emoji code</label></td>
		<td><input type="text" name="smiley_code" placeholder="emoji code" id="sc" size="30" value="<?php echo isset($_GET["code"]) ? $_GET["code"] : ''; ?>" /></td>
	</tr>
	<tr>
		<td><label for="sd">Emoji description/alt text</label></td>
		<td><input type="text" name="smiley_alt" placeholder="emoji description/alt text" id="sd" value="<?php echo isset($_GET["alt"]) ? $_GET["alt"] : ''; ?>" size="30" /></td>
	</tr>
	<tr>
		<td><input type="submit" value="add emoji" class="button button-primary" name="" /></td>
	</tr>
</table>
</form>
<?php
if( isset( $_POST["smiley_submit"] ) ) {
	exit; // pro feature 
}
$array = array_unique(array_filter(explode(',', $option)));
if(count($array)>0) :
?>
<p></p>
<h3>Your uploaded emoticons</h3>
<table class="wp-list-table widefat striped">
	<tr><th>Emoji</th><th>Code</th><th>Alt text</th><th>Action</th></tr>
	<?php
	foreach( array_unique(array_filter(explode(',', $option))) as $array ) {
		$urlV = explode('url="', $array);
		$url = substr($urlV[1], 0, strpos($urlV[1], '" code="'));
		$codeV = explode('code="', $array);
		$code = substr($codeV[1], 0, strpos($codeV[1], '" alt="'));
		$altV = explode('alt="', $array);
		$alt = substr($altV[1], 0, strpos($altV[1], '"}'));
		echo '<tr><td><a href="'.$url.'" target="_blank" title="view"><img src="'.$url.'" style="max-height:60px;max-width:60px;" alt="'.$alt.'"></img></a></td>';
		echo '<td><code>'.$code.'</code></td>';
		echo '<td>'.$alt.'</td>';
		echo '<td><a href="admin.php?page=wpchats&section=emoji&edit=1&emoji='.urlencode($array).'">Edit</a> &bullet; <a href="admin.php?page=wpchats&section=emoji&delete=1&emoji='.urlencode($array).'">Delete</a></td></tr>';
	}
	?>
</table>
<?php endif; ?>
<h3>Emoji Custom CSS</h3>
<?php
if( isset($_POST["cs_submit"]) ) {
	if( $_POST["cs_body"] !== '' ) {
		update_option('wpc_admin_emoji_css', esc_attr($_POST["cs_body"]));
		wp_redirect( admin_url(). 'admin.php?page=wpchats&section=emoji&css=1');
		exit;
	} else {
		delete_option('wpc_admin_emoji_css');
		wp_redirect( admin_url(). 'admin.php?page=wpchats&section=emoji&css=1');
		exit;
	}
}
$cs = get_option('wpc_admin_emoji_css');
?>
<form action="#" method="post">
	<p>If you want to style the emoji you upload via this page, then, your CSS selector is <code>.wpc-admin-emoji</code>. Drop couple lines of code below:</p>
	<textarea name="cs_body" rows="7" cols="60"><?php echo $cs && $cs !== '' ? $cs : ".wpc-admin-emoji {\n    height: auto!important;\n    width: auto!important;\n    max-width: 300px!important;\n    border-radius: 0!important;\n}"; ?></textarea><br>
	<input type="submit" value="Save CSS" name="cs_submit" class="button button-primary" />
</form>