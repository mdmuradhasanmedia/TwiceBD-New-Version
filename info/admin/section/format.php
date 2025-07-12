<?php

if( isset( $_POST["wpc_format"] ) ) {

	global $wpdb;
	$table = $wpdb->prefix."mychats";
	$table2 = $wpdb->prefix."mychats_temp";
	$table3 = $wpdb->prefix."options";
	$table4 = $wpdb->prefix."usermeta";
	$q = $wpdb->get_results( "SELECT * FROM $table3 WHERE `option_name` LIKE '%wpc_%'");
	$q2 = $wpdb->get_results( "SELECT * FROM $table4 WHERE `meta_key` LIKE '%wpc_%'");
	foreach( $q as $meta ) {
		delete_option( $meta->option_name );
	}
	foreach( $q2 as $meta ) {
		delete_user_meta( $meta->user_id, $meta->meta_key );
	}
	$wpdb->query( "DROP TABLE $table");
	$wpdb->query( "DROP TABLE $table2");
	wp_redirect( 'admin.php?page=wpchats&section=settings&deleted=1' );
	exit;

} else {
	ob_start();
	?>
	<p>
		<h2>Delete plugin data</h2>
		<p><strong>Are you sure you want to delete all plugin data?</strong></p>
		<p>Please note that this is going to delete everything from your actual database.</p>
		<p>If you have made translations, please make a record of them before processing the deletion.</p>
		<p>Data include:</p>
		<li>Options &amp; settings <i>(plugin settings)</i></li>
		<li>User metas <i>(ie social profiles, preferences)</i></li>
		<li>Data tables and messages <i>(all existing conversations and messages)</i></li>
		<p><form action="#" method="post"><input type="submit" class="button" id="submit" name="wpc_format" onclick="return confirm('Warning: this can\'t be undone.\n\nAre you sure you want to do this?');" value="Confirm deletion" /></form>	</p>
	</p>
	<?php
	echo ob_get_clean();
}