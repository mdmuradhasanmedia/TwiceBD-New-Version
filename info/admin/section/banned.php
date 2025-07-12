<?php
if($exit)
	return false;
else
	$wpchats->pro_notice();

if( $wpchats->get_settings('mod_can_ban') || current_user_can('manage_options') ) :;
if( isset( $_GET["action"] ) && in_array( $_GET["action"], array('ban', 'unban') ) ) {
	$action = isset( $_GET["action"] ) ? esc_attr( $_GET["action"] ) : '';
	$user 	= isset( $_GET["user"] ) ? esc_attr( $_GET["user"] ) : '';
	if( $action == 'ban' ) {
		$wpc->do_mod('ban', '', $user);
	}
	if( $action == 'unban' ) {
		$wpc->do_mod('unban', '', $user);
	}
} 
echo '<h2>Banned users<label for="s_b" class="add-new-h2">Add New</label></h2>';
$op = esc_attr( get_option('wpc_banned') );
$banned = $wpc->get_users('banned', '');
$url = $exit ? $wpchats->get_settings('profile_page').'?mod=1' : admin_url(). 'admin.php?page=wpchats&section=banned';
if( ! $op || $op == '' || count( $banned ) == 0 ) {
	echo '<p>You have no banned users for the now.</p>';
} else {
	echo '<h3>You have '.$wpc->get_counts('banned').' banned user';
	echo $wpc->get_counts('banned') != 1 ? 's' : '';
	echo ':</h3>';
	foreach( $banned as $user ) {
		echo '<div class="wpc_user_res"><p>';
		echo $wpc->get_user_icon($user, 40, $exit ? $wpchats->get_settings('profile_page').'?id=' : 'admin.php?page=wpchats&user=');
		echo "</p><p><a href=\"$url&action=unban&user=$user\" onclick=\"return confirm('Are you sure you want to unban this user?');\"><span class=\"button\"><i class=\"wpcico-lock-open-alt\"></i>unban</span></a></p>";
		echo '</div>';
	}
}
?>
<h3 id="sb">Add new banned user:</h3>
<p>Type below a username, name or user ID and then select the correct user from search results.</p>
<form action="<?php echo $url; ?>#sb" method="post">
	<label for="s_b">Username or user ID: </label>
	<input type="text" name="search_ban_val" <?php echo isset($_POST["search_ban_val"]) ? 'value="'.$_POST["search_ban_val"].'"' : ''; ?> id="s_b" />
	<input type="submit" value="Search user" class="button" name="search_ban" />
</form>
<?php
if( isset($_POST["search_ban"]) && isset($_POST["search_ban_val"]) ) {
	echo $wpc->search_users( 'banned', esc_attr( $_POST["search_ban_val"] ), $url );
}
endif;