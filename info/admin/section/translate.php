<?php

if( isset( $_POST["submit_translations"] ) ) {

	if(isset($_POST["translations"]))
		update_option('wpc_translations', sanitize_text_field( $_POST["translations"] ));
	if(isset($_POST["additional_translations"]) )
		update_option('wpc_additional_translations', sanitize_text_field( $_POST["additional_translations"] ));

	if(isset($_POST['enableTrans'])) {
		if( $_POST['enableTrans'] == 'on' ) {
			if( !$wpchats->get_settings('translation') ) {
				update_option('wpc_s_26', 'on');
				echo '<div id="updated" class="updated notice is-dismissible"><p>Translation enabled.</p></div>';
			}
		} else {
			if( $wpchats->get_settings('translation') ) {
				delete_option('wpc_s_26');
				echo '<div id="updated" class="updated notice is-dismissible"><p>Translation disabled.</p></div>';
			}
		}
	}
	echo '<div id="updated" class="updated notice is-dismissible"><p>Translations saved successfully.</p></div>';
}
if( isset( $_GET["getTrans"] ) && $_GET["getTrans"] != '' ) {
	$contents = file_get_contents( $_GET["getTrans"], true);
	if( $contents ) {
		update_option('wpc_translations', sanitize_text_field( $contents ));		
		echo '<div id="updated" class="updated notice is-dismissible"><p>Translations loaded successfully! enjoy :)</p></div>';
	} else {
		echo '<div id="updated" class="error notice is-dismissible"><p>Error while retrieving data. Please try again.</p></div>';
	}
}
$dccn = "dimissContribution";
if( isset( $_GET["dimissContribution"] ) ) {
	$dccv = "1";
	if(!isset($_COOKIE[$dccn]))
		setcookie($dccn, $dccv, time() + (2678400), "/"); // 1 month
	echo '<div id="updated" class="updated notice is-dismissible"><p>Dismissed successfully.</p></div>';
	echo '<style>#wpc_contr {display:none}</style>';
}
$op = get_option('wpc_translations'); 
$op2 = get_option('wpc_additional_translations'); 
$data =  json_decode( stripslashes($op), false );
$data2 =  json_decode( stripslashes($op2), false );
$defaults = $wpchats->defaultsJSON;
$defaultData =  json_decode( $defaults, true );
$defaultDataHelp =  json_decode( $wpchats->defaultsJSON_help, true );
global $current_user;

?>

<h2><?php echo !empty($data) ? 'Translation' : 'Welcome to translation section'; ?></h2>
<p><label><input type="checkbox" name="enable_translation" id="enable_translation" onchange="enableTrans(this)" <?php echo $wpchats->get_settings('translation') ? 'checked="checked"' : ''; ?>/>Enable translation</label></p>
<p id="label-to-submit" style="display:none"><label for="save-translations" class="button button-primary">Save changes</label></p>
<p id="wpc-note">From this page you'll be able to translate the entire content into your own language. <a href="http://wpchats.samelh.com/translations/" target="_blank" class="button">Try some ready translations</a> or <span class="button" id="start-trans">start translating</span>.</p>
<span class="button" id="wpc-add-trans">Add translation</span>
<p id="status"></p>


<form method="post" action="#" id="wpc-trans"<?php echo empty($data) ? ' style="display:none"' : ''; ?>>
 	
 	<table class="widefat striped wpc-table">

 		<tr><td><label for="save-translations" class="button button-primary">Save translations</label></td><td><a href="#wpfooter" id="wpc-btb">Scroll To Bottom</a></td></tr>
 		<tr><th>word/sentence</th><th>translation</th></tr>
	 	<?php
	 	foreach( $defaultData as $index => $val ) {
			?>
				<tr>
					<td>
						<label for="case-<?php echo $index; ?>">
							<span class="label"><?php echo $val; ?></span>
							<?php echo !empty($defaultDataHelp[$index]) ? '<span class="help">'.$defaultDataHelp[$index].'</span>' : false; ?>
						</label>
					</td>
					<td>
						<input type="text" id="case-<?php echo $index; ?>" class="wpcTrans" onchange="wpc_submit()" <?php echo $wpchats->get_settings('rtl') ? 'dir="rtl"' : ''; ?>/>
					</td>
				</tr>
			<?php
		}
		$additional_translations = apply_filters('_wpc_register_additional_translations', $array = false );
		$array = array_filter( array_unique( explode(',', $additional_translations)) );
		if( is_array($array) && !empty( $array ) ) : ?>
			<tr><td><h3>Additional translatations</h3></td></tr>
			<?php foreach( $array as $index => $value ) :; ?>
				<tr>
					<td><label for="<?php echo preg_replace('/[^\da-z]/i', '', $value); ?>"><span class="label"><?php echo $value; ?></span></label></td>
					<td><input type="text" id="<?php echo preg_replace('/[^\da-z]/i', '', $value); ?>" class="wpcTransAddi" onchange="wpc_submitAdditional()" <?php echo $wpchats->get_settings('rtl') ? 'dir="rtl"' : ''; ?>/></td>
				</tr>
			<?php endforeach; ?>
		<?php endif; ?>
	 	<input type="hidden" id="enableTrans" name="enableTrans" value="" />
	 	<tr style="display:none" id="trans-object-cont">
	 		<td>
	 			<p><label><span style="display:block;margin-bottom:5px">Add or make a backup of your translations. Copy and save this JSON object, or add a saved object and save translations:</span><textarea id="wpc-translations" name="translations" style="width: 100%; min-height: 200px"><?php echo stripslashes(get_option('wpc_translations')); ?></textarea></label></p>
	 			<?php if(!empty( $array )):;?>
	 			<p>
	 				<label>
	 					<strong>Additional translations:</strong><br/>
	 					<textarea id="wpc-additional-trans" name="additional_translations" style="width:100%" onfocus="this.select()"><?php echo stripslashes(get_option('wpc_additional_translations')); ?></textarea>
	 				</label>
	 			</p>
	 		<?php endif; ?>
	 		</td>
	 	</tr>
	 	<tr>
	 		<td>
	 			<p>
	 				<input type="submit" class="button button-primary" value="Save translations" name="submit_translations" id="save-translations" />
	 				<span class="button" onclick="wpc_showHide('trans-object-cont', 'wpc-translations')">backup</span>
	 			</p>
	 		</td>
	 		<td><a href="#wpcontent" id="wpc-btt">Back To Top</a></td>
	 	</tr>
 	</table>
</form>

<?php if(!isset($_COOKIE[$dccn])):;?>
<div<?php echo empty($data) ? ' style="display:none"' : ''; ?> id="wpc_contr">
	<h2>Contribute your translations</h2>
	<p>Would you like to contribute these translations you made so others can benefit?</p>
	<p>As if you say yes, the translations you provide will be shared in both the premium and lite version of this plugin which is available in WordPress.org plugins repository.</p>
	<p>We will also give you a back-link if you want, linking to your social media or website etc.</p>
	<form method="post" action="http://wpchats.samelh.com/translations/contribute/" target="_blank">
		<table id="contribute-wpc">
		<tr>
			<td><label><span>Your name</span><br/><input type="text" placeholder="" size="60" value="<?php echo $current_user->display_name; ?>" name="cname" /></label></td>
		</tr>
		<tr>
			<td><label><span>The language you're contributing</span><br/><input type="text" placeholder="" size="60" name="clang" /></label></td>
		</tr>
		<tr>
			<td><label><span>Your email</span><br/><input type="text" placeholder="" value="<?php echo $current_user->user_email; ?>" size="60" name="cemail" /></label></td>
		</tr>
		<tr>
			<td><label><span>Website or social profile (optional)</span><br/><input type="text" placeholder="" size="60" value="<?php echo $current_user->user_url; ?>" name="clink" /></label></td>
		</tr>
		<tr>
			<td><label><span>Avatar (image URL) (optional)</span><br/><input type="text" placeholder="" size="60" name="cavatar" /></label></td>
		</tr>
		<tr>
			<td>
				<label><span>Content</span><br/><textarea cols="60" rows="10" name="ccontent">// optional additional comments<?php echo "\n\n"; ?>Translation:<?php echo "\n\n"; ?><?php echo stripslashes(get_option('wpc_translations')); ?></label></textarea>
			</td>
		</tr>
		<tr>
			<td>
				<input type="submit" class="button button-primary" value="submit contribution" style="margin-top:14px" />
				<input type="submit" class="button" value="dismiss" style="margin-top:14px" onclick="window.location.href=window.location.href+'&amp;dimissContribution=1';return false;" />
			</td>
		</tr>
		</table>
	</form>
</div>
<?php endif; ?>
<script type="text/javascript">
window.addEventListener('load', function () {
<?php
if( !empty($data) ) {
	foreach( $data as $index => $value ) {
		echo '  load_trans(' . $index . ', "' . $value . '");' . "\n";
	}
}
if( !empty($data2) ) {
	foreach( $data2 as $index => $value ) {
		echo '  load_additional_trans("' . $index . '", "' . $value . '");' . "\n";
	}
} ?>
}, false);

</script>