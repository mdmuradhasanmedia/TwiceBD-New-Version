<?php
// define constants
defined( 'WPC_PLUGIN_DIR' )  	|| define( 'WPC_PLUGIN_DIR', plugin_dir_url(__FILE__) );
defined( 'WPC_PLUGIN_PATH' ) 	|| define( 'WPC_PLUGIN_PATH', plugin_dir_path(__FILE__) );
defined( 'WPC_PLUGIN_FILE' )	|| define( 'WPC_PLUGIN_FILE', __FILE__ );
// load chating files
include_once( get_template_directory() . '/info/core/init.php' );
include_once( get_template_directory() . '/info/classes/wpchats.php' );
include_once( get_template_directory() . '/info/admin/classes/wpc.php' );
include_once( get_template_directory() . '/info/admin/admin.php' );
include_once( get_template_directory() . '/info/core/widget.php' );
include_once( get_template_directory() . '/info/core/cron.php' );
include_once( get_template_directory() . '/info/core/shortcodes.php' );