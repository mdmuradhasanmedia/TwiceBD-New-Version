<?php
require_once( '../../info/classes/wpchats.php' );
require_once( './../../../../../wp-blog-header.php' );

$wpchats = new wpChats;
$recipient = $_GET["to"];
$message = $_GET["message"];

if( !isset( $_GET['to'] ) || !isset( $_GET['message'] )){
	wp_redirect( $wpchats->get_settings('messages_page') . '?scs=10' ); exit;
}else{
	global $wpdb; $options1 = get_option('wpc_pages');  $url = $options1["users"]; $url2 = $options1["messaging"];
	wp_redirect( $url2 .'?return=false'); 
}

global $current_user;
$message = $_GET["message"];
$wpchats->send( $wpchats->get_conversation_id( $current_user->ID, $recipient ), $current_user->ID, $recipient, $message, time() );