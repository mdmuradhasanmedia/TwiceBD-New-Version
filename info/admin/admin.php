<?php

/**
 * YouTube info- Widgets Channel & Video Cards & more
 * settings file
 */

// registers a menu and a settings page for this plugin

function wpc_register_settings() {
	register_setting( 'wpc-settings', 'wpc_s_1' );
	register_setting( 'wpc-settings', 'wpc_s_2' );
	register_setting( 'wpc-settings', 'wpc_s_3' );
	register_setting( 'wpc-settings', 'wpc_s_4' );
	register_setting( 'wpc-settings', 'wpc_s_5' );
	register_setting( 'wpc-settings', 'wpc_s_6' );
	register_setting( 'wpc-settings', 'wpc_s_7' );
	register_setting( 'wpc-settings', 'wpc_s_8' );
	register_setting( 'wpc-settings', 'wpc_s_9' );
	register_setting( 'wpc-settings', 'wpc_s_10' );
	register_setting( 'wpc-settings', 'wpc_s_11' );
	register_setting( 'wpc-settings', 'wpc_s_12' );
	register_setting( 'wpc-settings', 'wpc_s_13' );
	register_setting( 'wpc-settings', 'wpc_s_14' );
	register_setting( 'wpc-settings', 'wpc_s_15' );
	register_setting( 'wpc-settings', 'wpc_s_16' );
	register_setting( 'wpc-settings', 'wpc_s_17' );
	register_setting( 'wpc-settings', 'wpc_s_18' );
	register_setting( 'wpc-settings', 'wpc_s_19' );
	register_setting( 'wpc-settings', 'wpc_s_20' );
	register_setting( 'wpc-settings', 'wpc_s_21' );
	register_setting( 'wpc-settings', 'wpc_s_22' );
	register_setting( 'wpc-settings', 'wpc_s_23' );
	register_setting( 'wpc-settings', 'wpc_s_24' );
	register_setting( 'wpc-settings', 'wpc_s_25' );
	register_setting( 'wpc-settings', 'wpc_s_26' );
	register_setting( 'wpc-settings', 'wpc_s_27' );
	register_setting( 'wpc-settings', 'wpc_s_28' );
	register_setting( 'wpc-settings', 'wpc_s_29' );
	register_setting( 'wpc-settings', 'wpc_s_30' );
}
function wpc_admin_page() {
	include_once( get_template_directory() . '/info/classes/wpchats.php' );
	$wpchats = new wpChats;
	include_once('classes/wpc.php');
	$wpc = new wpc;
	?>
		<div class="wrap wpc">
			<h2 class="nav-tab-wrapper wpc">
				<a class="nav-tab<?php echo ! isset($_GET["section"]) ? ' nav-tab-active' : ''; ?>" href="admin.php?page=wpchats"><span><i class="dashicons dashicons-dashboard"></i>Dashboard</span></a>
				<a class="nav-tab<?php echo ( isset($_GET["section"]) && $_GET["section"] == 'moderate' ) ? ' nav-tab-active' : ''; ?>" href="admin.php?page=wpchats&amp;section=moderate"><span><i class="dashicons dashicons-visibility"></i>Moderation panel<?php echo $wpc->get_counts('reported') > 0 ? ' <span class="count">'.$wpc->get_counts('reported').'</span>' : ''; ?></span></a>
				<a class="nav-tab<?php echo ( isset($_GET["section"]) && $_GET["section"] == 'emoji' ) ? ' nav-tab-active' : ''; ?>" href="admin.php?page=wpchats&amp;section=emoji"><span><i class="dashicons dashicons-smiley"></i>Emoji</span></a>
				<a class="nav-tab<?php echo ( isset($_GET["section"]) && $_GET["section"] == 'settings' ) ? ' nav-tab-active' : ''; ?>" href="admin.php?page=wpchats&amp;section=settings"><span><i class="dashicons dashicons-admin-generic"></i>Settings</span></a>
				<a class="nav-tab<?php echo ( isset($_GET["section"]) && $_GET["section"] == 'deleted' ) ? ' nav-tab-active' : ''; ?>" href="admin.php?page=wpchats&amp;section=deleted"><span><i class="dashicons dashicons-trash"></i>Deleted messages<?php echo $wpc->get_counts('deleted') > 0 ? ' ('.$wpc->get_counts('deleted').')' : '' ; ?></span></a>
				<a class="nav-tab<?php echo ( isset($_GET["section"]) && $_GET["section"] == 'banned' ) ? ' nav-tab-active' : ''; ?>" href="admin.php?page=wpchats&amp;section=banned"><span><i class="dashicons dashicons-lock"></i>Banned users<?php echo $wpc->get_counts('banned') > 0 ? ' ('.$wpc->get_counts('banned').')' : ''; ?></span></a>
				<a class="nav-tab<?php echo ( isset($_GET["section"]) && $_GET["section"] == 'mailing' ) ? ' nav-tab-active' : ''; ?>" href="admin.php?page=wpchats&amp;section=mailing"><span><i class="dashicons dashicons-email-alt"></i>Mailing</span></a>
				<a class="nav-tab<?php echo ( isset($_GET["section"]) && $_GET["section"] == 'translate' ) ? ' nav-tab-active' : ''; ?>" href="admin.php?page=wpchats&amp;section=translate"><span><i class="dashicons dashicons-translation"></i>Translate</span></a>
				<a class="nav-tab<?php echo ( isset($_GET["section"]) && $_GET["section"] == 'shortcodes' ) ? ' nav-tab-active' : ''; ?>" href="admin.php?page=wpchats&amp;section=shortcodes"><span><i class="dashicons dashicons-editor-code"></i>Shortocdes</span></a>
			</h2>
			<div class="wpc_left">
				<?php
				if( ! isset( $_GET["section"] ) || ! in_array($_GET["section"], array('settings', 'moderate', 'emoji', 'banned', 'deleted', 'mailing', 'shortcodes', 'translate')) ) {
					include('section/index.php');
				} else {
					$section = $_GET["section"];
					if( $section == 'settings' && !isset($_GET["format"]) ) {
						include('section/settings.php');
					}
					if( $section == 'settings' && isset($_GET["format"]) ) {
						include('section/format.php');
					}
					if( $section == 'emoji' ) {
						include('section/emoji/emoji.php');
					}
					if( $section == 'moderate' ) {
						$exit = false;
						include('section/moderate.php');
					}
					if( $section == 'banned' ) {
						$exit = false;
						include('section/banned.php');
					}
					if( $section == 'deleted' ) {
						include('section/deleted.php');
					}
					if( $section == 'mailing' ) {
						include('section/mailing.php');
					}
					if( $section == 'shortcodes' ) {
						include('section/shortcodes.php');
					}
					if( $section == 'translate' ) {
						include('section/translate.php');
					}
				}
				?>
			</div>	
			<div class="wpc_right">

				<h3>Get the PRO version</h3>
				<p>More cool features are waiting! Enable instant messaging, no need to refresh to receive or send a message... <br/><br/><a class="button" target="_blank" href="http://go.samelh.com/get/wpchats/">More details &raquo;</a></p>
				<p><hr/></p>


				<h3>Check out more of our premium plugins</h3>
					<li><a target="_blank" href="http://go.samelh.com/get/bbpress-ultimate/">bbPress Ultimate</a> adds more features to your forums and bbPress/BuddyPress profiles..</li>
				<?php if( function_exists('bbpress')) : ?>
					<li><a target="_blank" href="http://go.samelh.com/get/bbpress-thread-prefixes/">bbPress Thread Prefixes</a> enables thread prefixes in your blog, just like any other forum board!</li>
				<?php endif; ?>
				<li><a target="_blank" href="http://go.samelh.com/get/youtube-information/">YouTube Information</a>: easily embed YouTube video/channel info and stats, video cards, channel cards, widgets, shortcodes..</li>
				<li><a target="_blank" href="http://go.samelh.com/get/featured-media/">Featured Media</a> Enables custom post types, letting you choose and output your featured media as a post thumbnail or anywhere else using a shortcode</li>
				<p>View more of our <a target="_blank" href="https://profiles.wordpress.org/elhardoum#content-plugins">free</a> and <a target="_blank" href="http://codecanyon.net/user/samiel/portfolio?ref=samiel">premium</a> plugins.</p>
				<p><hr/></p>

				<h3>Subscribe, Join our mailing list</h3>
				<p><i>Join our mailing list today for more WordPress tips and tricks and awesome free and premium plugins</i><p>
				<form action="//samelh.us12.list-manage.com/subscribe/post?u=677d27f6f70087b832c7d6b67&amp;id=7b65601974" method="post" name="mc-embedded-subscribe-form" class="validate" target="_blank" novalidate="">
					<label><strong>Email:</strong><br/>
						<input type="email" value="<?php echo wp_get_current_user()->email; ?>" name="EMAIL" class="required email" id="mce-EMAIL" />
					</label>
					<br/>
					<label><strong>Your name:</strong><br/>
						<input type="text" value="<?php echo wp_get_current_user()->user_nicename; ?>" name="FNAME" class="" id="mce-FNAME" />
					</label>
					<br/>
				    <input type="submit" value="Subscribe" name="subscribe" id="mc-embedded-subscribe" class="button" />
				</form>
				<p><hr/></p>

				<h3>Are you looking for help?</h3>
				<p>Don't worry, we got you covered:</p>
				<li><a target="_blank" href="http://support.samelh.com/">Try our Support forum</a></li>
				<li><a target="_blank" href="http://blog.samelh.com/">Browse our blog for tutorials</a></li>
				<li><a target="_blank" href="http://wordpress.org/support/plugin/wpchats-lite-private-messaging">Plugin support forum on WordPress</a></li>
				<p><hr/></p>

				<p>
					<li><a target="_blank" href="https://wordpress.org/support/view/plugin-reviews/wpchats-lite-private-messaging?rate=5#postform">Give us &#9733;&#9733;&#9733;&#9733;&#9733; rating</a></li>
					<li><a target="_blank" href="http://twitter.com/samuel_elh">Follow on Twitter</a></li>
					<li><a target="_blank" href="https://twitter.com/intent/tweet?text=Check+out+%27WpChats+-+Instant+Chat+%26+Private+Messaging%27+plugin+on+WordPress+https://wordpress.org/plugins/wpchats-lite-private-messaging+%23WordPress+via+%40samuel_elh">Share on Twitter</a></li>
				</p>

			</div>

			<div id="wpc-ft" style="display:none">
				<a class="button" href="http://wpchats.samelh.com/" target="_blank">
					<span class="dashicons dashicons-welcome-view-site"></span>WpChats Pro Demo &raquo;
				</a>
				<br style="clear: both;">
				<a class="button" href="http://go.samelh.com/get-wpchats" target="_blank">
					<span class="dashicons dashicons-welcome-learn-more"></span>Get WpChats Pro &raquo;
				</a>
				<br style="clear: both;">
				<a class="button" href="http://wordpress.org/support/plugin/wpchats-lite-private-messaging" target="_blank">
					<span class="dashicons dashicons-sos"></span>Find support &raquo;
				</a>
				<br style="clear: both;">
				<a class="button" href="https://wordpress.org/support/view/plugin-reviews/wpchats-lite-private-messaging?rate=5#postform" target="_blank">
					<span class="dashicons dashicons-star-filled"></span>Rate/review this plugin &raquo;
				</a>
				<br style="clear: both;">
				<a class="button" href="https://twitter.com/intent/follow?screen_name=samuel_elh" target="_blank">
					<span class="dashicons dashicons-twitter"></span>Follow @samuel_elh &raquo;
				</a>
				<br style="clear: both;">
				<a class="button" target="_blank" href="https://twitter.com/intent/tweet?text=Check+out+%27WpChats+-+Instant+Chat+%26+Private+Messaging%27+plugin+on+WordPress+https://wordpress.org/plugins/wpchats-lite-private-messaging+%23WordPress+via+%40samuel_elh">
					<span class="dashicons dashicons-twitter"></span>Share on Twitter &raquo;
				</a>
				<p>Thank you for using our plugins - <a href="http://go.samelh.com/newsletter" target="_blank">sign up for our newsletter</a> for more :)</p>
			</div>

		</div>
	<?php
}
add_action('admin_enqueue_scripts', function() {
		wp_enqueue_script('wpc-admin-jquery', get_template_directory_uri() . '/info/admin/inc/js/global.js', false, null );
		wp_enqueue_script('wpc-admin-js', get_template_directory_uri() . '/info/admin/inc/js/functions.js' );
		wp_enqueue_style('wpc-admin', get_template_directory_uri() . '/info/admin/inc/css/style.css' );
		wp_enqueue_style('wpc-mod', get_template_directory_uri() . '/info/admin/inc/css/mod.css' );
		wp_enqueue_script('jquery');
		wp_enqueue_media();
});

add_action('admin_head', function() {
	echo 
	'<style type="text/css" media="all">
		li[id*="_wpchats"] .wp-submenu li a {
		    font-weight: initial!important;
		    color: #b4b9be!important;
		}
		li[id*="_wpchats"] .wp-submenu span.active {
			font-weight: 600;
			color: #fff;
		}
		@media screen and (min-width: 700px) {
			.wpc_left,
			.wpc_right {
				display: inline-block;
			}
			.wpc_left {width: 65%;overflow: hidden;position: relative;}
			.wpc_right {
				width: 25%;
				vertical-align: top;
				border-left: 1px solid #ddd;
				padding: 0 1.2em;
				margin-top: -5px;
			}
		}
	</style>';
});