<!DOCTYPE html PUBLIC "-//WAPFORUM//DTD XHTML Mobile 1.0//EN" "http://www.wapforum.org/DTD/xhtml-mobile10.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head><meta name="theme-color" content="#000066" />
    <meta charset="UTF-8"><meta name="google-site-verification" content="" />
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
	<title><?php if ( is_single() ) { 
	        single_post_title(); echo ' | '; bloginfo( 'name' );
		} elseif ( is_home() || is_front_page() ) {
			bloginfo( 'name' ); echo ' | ' ; bloginfo( 'description' ); 
		} elseif ( is_page() ) {
			single_post_title( '' ); echo ' | '; bloginfo( 'name' );
		} elseif ( is_search() ) {
			echo 'Search results | '; bloginfo( 'name' );
		} elseif ( is_404() ) { 
		    echo 'Not Found | '; bloginfo( 'name' );
		} else { 
		    wp_title( '' ); echo ' | '; bloginfo( 'name' ); 
		} ?>
	</title>
	<meta name="viewport" content="width=device-width, initial-scale=1"/>
	<link href="<?php echo get_template_directory_uri(); ?>/css/notification.css" rel="stylesheet" type="text/css" media="all, handheld" />
	<link href="<?php echo get_template_directory_uri(); ?>/css/pagenavi-css.css" rel="stylesheet" type="text/css" media="all, handheld" />
	<link href="<?php bloginfo( 'template_url' ); ?>/style.css" rel="stylesheet" type="text/css" media="all, handheld" />
	<link rel="icon" type="image/png" href="<?php bloginfo( 'template_url' );?>/favicon.png" />
	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" /> 
	<?php wp_head(); ?>
</head>
<body id="top">
<div class="wapper_main">

<?php global $wpdb;
	$options1 = get_option('ln_options1'); 
	$url5 = $options1["plink_dash"]; 
	$redirected_ul = $url5;
	$cr_id = get_current_user_id(); ?>
	
<?php if ( is_user_logged_in() ){ ?>
<div class="block_top_menu">
	<ul class="menu" >
	    <li><a href="<?php echo $url5; ?>"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
		<li><a href="<?php echo home_url(); ?>/?author=<?php echo $cr_id;  ?>"><i class="fas fa-id-card"></i> Profile</a></li>
		<li><a href="<?php echo $url5.'?page=new_post'; ?>"><i class="fas fa-book-medical"></i> New Post</a></li>
	</ul>
</div>
<?php } ?>

<div class="block_header">
<table class="header_logo" width="100%"><tbody><tr>
    <td valign="middle" align="left" style="margin-right:5px"><a href="<?php bloginfo('url'); ?>"><img width="200px"  src="https://x.twicebd.com/wp-content/uploads/2019/09/login-logo.png"></a></td>

<?php
if ( is_user_logged_in() ) {
    $current_user = wp_get_current_user();
	echo '<td width="50%" align="right"><font color="red">H</font><font color="green">i, </font> '.$current_user->display_name.'</td>';


} else{
    

	echo '<td width="180px" align="right"> <button id="auth1"><a class="login_box" href="/wp-login.php" title="Login"><i class="fa fa-sign-in-alt"></i> Login</a></button><br><br><button id="auth2"><a class="login_box" href="/wp-login.php?action=register" title="Signup"><i class="fa fa-sign-out-alt"></i> Signup</a></button><br><br></td> <br>';
} ?></table></div> 

<div class="main_nav"><ul>
    
<li>
<a href="<?php echo home_url(); ?>"><i class="fa fa-home"></i> Home</a>
</li>
<li>
<i class="fa fa-bell"></i> <?php echo do_shortcode('[f_notification var="user" out="ntc_l_count"]'); ?>
</li>
<li>
<a title="Message" href="https://twicebd.com/"> <i class="fa fa-envelope"></i> <?php _e('Message'); ?><?php $wpchats = new wpchats; if($wpchats->get_counts('unread')>0){ ?> <span style="vertical-align: bottom;background:blue;font-size:smaller;color:#000066;border-radius:50%;padding: 1px 5px;" ><?php echo $wpchats->get_counts('unread'); ?></span><?php } ?></a></td>
</li>
<li class="trickbd_payment_icon"><a href="https://twicebd.com/payment">৳</a></li>
</ul></div>
<div style='text-align: center'><a href='https://twicebd.com/Trainer-Request'><div class='btn btn-danger' style='margin: 5px auto; text-align: center'>Be a trainer!<small style='color: #fff'> Share your knowledge</small></div></a></div>