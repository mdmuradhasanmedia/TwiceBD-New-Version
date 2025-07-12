<?php

class wpc_widget extends WP_Widget {
	function __construct() {
		parent::__construct(
			'wpc_widget', 
			__('WpChats', 'wordpress'), 
			array( 'description' => __( 'Display WpChats quick links and counts for current user', 'wordpress' ), ) 
		);
	}
	public function widget( $args, $instance ) {
		foreach( array( 'field_1', 'field_2', 'field_3', 'field_4', 'field_5', 'field_6', 'field_7', 'field_8', 'field_9' ) as $field ) {
			error_reporting(0); // disable error reporting here to avoid undefind indexes being reported due to theme changing and widget being active
			if( is_null($instance[$field]) )
				$instance[$field] = '';
		}
		error_reporting(E_ALL);
		$title 		= apply_filters( 'widget_title', $instance['title'] );
		$field_1 	= apply_filters( 'widget_field_1', $instance['field_1'] );
		$field_2 	= apply_filters( 'widget_field_2', $instance['field_2'] );
		$field_3 	= apply_filters( 'widget_field_3', $instance['field_3'] );
		$field_4 	= apply_filters( 'widget_field_4', $instance['field_4'] );
		$field_5 	= apply_filters( 'widget_field_5', $instance['field_5'] );
		$field_6 	= apply_filters( 'widget_field_6', $instance['field_6'] );
		$field_7 	= apply_filters( 'widget_field_7', $instance['field_7'] );
		$field_8 	= apply_filters( 'widget_field_8', $instance['field_8'] );
		$field_9 	= apply_filters( 'widget_field_9', $instance['field_9'] );

		if( is_user_logged_in() ) {
			$wpchats = new wpChats;
			$wpc = new wpc;
			global $current_user;
			$status = $wpchats->user_preferences( $current_user->ID, 'go_offline' ) ? 'online' : 'offline';
			switch($status) {
				case 'online':
				  $staTitle = $wpchats->translate(227);
				  break;
				case 'offline':
				  $staTitle = $wpchats->translate(228);
				  break;
			}

			echo $args['before_widget'];
			if ( ! empty( $title ) )
				echo $args['before_title'] . $title . $args['after_title'];
			ob_start();
			?>
				<ul class="wpc-widget<?php echo $wpchats->get_settings('rtl') ? ' rtl' : ''; ?>">
					<?php if( $field_2 !== 'off' ) :; ?>
					<li class="avatar">
						<a href="<?php echo $wpchats->user_links('link', $current_user->ID, false); ?>" title="<?php echo $wpchats->translate(141); ?>">
							<i class="wpcico-user-1"></i><span><?php echo $wpchats->translate(199); ?> <?php echo $current_user->display_name; ?></span>
							<?php echo $wpchats->user_avatar($current_user->ID, 30); ?>
						</a>
					</li>
					<?php endif; ?>
					<?php if( $field_3 !== 'off' ) :; ?>
					<li class="messages">
						<a href="<?php echo $wpchats->get_settings('messages_page'); ?>" title="<?php echo $wpchats->get_counts('unread') > 0 ? str_replace( '[count]', $wpchats->get_counts('unread'), $wpchats->translate(219) ) : $wpchats->translate(220); ?>">
							<i class="wpcico-chat"></i><?php echo $wpchats->translate(79); ?><?php echo $wpchats->get_counts('unread') > 0 ? '<span class="count">'.$wpchats->get_counts('unread').'</span>' : ''; ?>
						</a>
					</li>
					<?php endif; ?>
					<?php if( $field_4 !== 'off' ) :; ?>
					<li ="online">
						<a href="<?php echo $wpchats->get_settings('profile_page'); ?>?filter=online" title="<?php echo $wpchats->get_counts('online') > 0 ? str_replace('[count]', $wpchats->get_counts('online'), $wpchats->translate(221)) : $wpchats->translate(222); ?>">
							<i class="wpcico-ok-circled"></i><?php echo $wpchats->translate(191); ?><?php echo $wpchats->get_counts('online') > 0 ? '<span class="count wpc_on_cnt">'.$wpchats->get_counts("online").'</span>' : $wpchats->translate(222); ?>
						</a>
					</li>
					<?php endif; ?>
					<?php if( $field_5 !== 'off' ) :; ?>
					<?php if( $wpchats->get_counts('blocked') > 0 ) : ; ?>
					<li class="blocked">
						<a href="<?php echo $wpchats->get_settings('profile_page'); ?>?filter=blocked" title="<?php echo str_replace('[count]', $wpchats->get_counts('blocked'), $wpchats->translate(223)); ?>">
							<i class="wpcico-block"></i><?php echo $wpchats->translate(151); ?><span class="count"><?php echo $wpchats->get_counts('blocked'); ?></span>
						</a>
					</li>
					<?php endif; ?>
					<?php endif; ?>
					<?php if( $field_6 !== 'off' ) :; ?>
					<?php if( $wpc->is_user('mod', $current_user->ID) ) : ; ?>
					<li class="reported">
						<a href="<?php echo $wpchats->get_settings('profile_page'); ?>?mod=1" title="<?php echo $wpc->get_counts('reported') > 0 ? str_replace('[count]', $wpc->get_counts('reported'), $wpchats->translate(224)) : $wpchats->translate(225); ?>">
							<i class="wpcico-eye"></i><?php echo $wpchats->translate(192); ?><?php echo $wpc->get_counts('reported') > 0 ? ' <span class="count">'.$wpc->get_counts('reported').'</span>' : ''; ?>				
						</a>
					</li>
					<?php endif; ?>
					<?php endif; ?>
					<?php if( $field_7 !== 'off' ) :; ?>
					<li class="settings">
						<a href="<?php echo $wpchats->get_settings('profile_page'); ?>?edit=1" title="<?php echo $wpchats->translate(226); ?>"><i class="wpcico-wrench"></i><?php echo $wpchats->translate(142); ?></a>
					</li>
					<?php endif; ?>
					<?php if( $field_9 !== 'off' ) :; ?>
					<?php if( $wpchats->get_settings('can_go_offline') || current_user_can('manage_options') ) { ?>
					<li class="modes">
						<a href="<?php echo $wpchats->get_settings('profile_page'); ?>?edit=1&amp;go=<?php echo $status; ?>&amp;next=<?php echo urlencode($_SERVER["REQUEST_URI"]); ?>" title="<?php echo $staTitle; ?>">
						<i class="wpcico-ok"></i>
						<?php switch( $status ) {
							case 'offline':
							  echo $wpchats->translate(217);
							  break;
							case 'online':
							  echo $wpchats->translate(218);
							  break;
						} ?>
					</a>
					</li>
					<?php } ?>
					<?php endif; ?>
					<?php if( $field_8 !== 'off' ) :; ?>
					<?php do_action('_wpc_add_widget_item'); ?>
					<li class="logout">
						<a href="<?php echo wp_logout_url($_SERVER["REQUEST_URI"]); ?>" title="<?php echo $wpchats->translate(198); ?>"><i class="wpcico-off"></i><?php echo $wpchats->translate(198); ?></a>
					</li>
					<?php endif; ?>
				</ul>
			<?php
			echo ob_get_clean();
			echo $args['after_widget'];
		} else {
			if( $field_1 !== 'off' ) {
				echo $args['before_widget'];
				if ( ! empty( $title ) )
					echo $args['before_title'] . $title . $args['after_title'];
				return wp_login_form();
				echo $args['after_widget'];
			}
		}
	}
	public function form( $instance ) {
		$title 		= isset( $instance[ 'title' ] ) 	? $instance[ 'title' ] 		: '';
		$field_1 	= isset( $instance[ 'field_1' ] ) 	? $instance[ 'field_1' ] 	: '';
		$field_2 	= isset( $instance[ 'field_2' ] ) 	? $instance[ 'field_2' ] 	: '';
		$field_3 	= isset( $instance[ 'field_3' ] ) 	? $instance[ 'field_3' ] 	: '';
		$field_4 	= isset( $instance[ 'field_4' ] ) 	? $instance[ 'field_4' ] 	: '';
		$field_5 	= isset( $instance[ 'field_5' ] ) 	? $instance[ 'field_5' ] 	: '';
		$field_6 	= isset( $instance[ 'field_6' ] ) 	? $instance[ 'field_6' ] 	: '';
		$field_7 	= isset( $instance[ 'field_7' ] ) 	? $instance[ 'field_7' ] 	: '';
		$field_8 	= isset( $instance[ 'field_8' ] ) 	? $instance[ 'field_8' ] 	: '';
		$field_9 	= isset( $instance[ 'field_9' ] ) 	? $instance[ 'field_9' ] 	: '';
		?>
			<p>
				<label for="<?php echo $this->get_field_id( 'title' ); ?>" style="font-weight:bold;"><?php _e( 'Widget Title:' ); ?></label> 
				<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
			</p>
			<p>
				<strong>Fields to show:</strong>
				<br>				
				<input class="widefat" id="<?php echo $this->get_field_id( 'field_2' ); ?>" name="<?php echo $this->get_field_name( 'field_2' ); ?>" type="checkbox" <?php echo $field_2 !== 'off' ? 'checked="checked"' : ''; ?> />
				<label for="<?php echo $this->get_field_id( 'field_2' ); ?>">User avatar icon with 'welcome user' text</label>
				<br>
				<input class="widefat" id="<?php echo $this->get_field_id( 'field_3' ); ?>" name="<?php echo $this->get_field_name( 'field_3' ); ?>" type="checkbox" <?php echo $field_3 !== 'off' ? 'checked="checked"' : ''; ?> />
				<label for="<?php echo $this->get_field_id( 'field_3' ); ?>">Messages link and unread count</label>
				<br>
				<input class="widefat" id="<?php echo $this->get_field_id( 'field_4' ); ?>" name="<?php echo $this->get_field_name( 'field_4' ); ?>" type="checkbox" <?php echo $field_4 !== 'off' ? 'checked="checked"' : ''; ?> />
				<label for="<?php echo $this->get_field_id( 'field_4' ); ?>">Online users count</label>
				<br>
				<input class="widefat" id="<?php echo $this->get_field_id( 'field_5' ); ?>" name="<?php echo $this->get_field_name( 'field_5' ); ?>" type="checkbox" <?php echo $field_5 !== 'off' ? 'checked="checked"' : ''; ?> />
				<label for="<?php echo $this->get_field_id( 'field_5' ); ?>">Blocked users if found</label>
				<br>
				<input class="widefat" id="<?php echo $this->get_field_id( 'field_6' ); ?>" name="<?php echo $this->get_field_name( 'field_6' ); ?>" type="checkbox" <?php echo $field_6 !== 'off' ? 'checked="checked"' : ''; ?> />
				<label for="<?php echo $this->get_field_id( 'field_6' ); ?>">Reported messages count for moderators</label>
				<br>
				<input class="widefat" id="<?php echo $this->get_field_id( 'field_7' ); ?>" name="<?php echo $this->get_field_name( 'field_7' ); ?>" type="checkbox" <?php echo $field_7 !== 'off' ? 'checked="checked"' : ''; ?> />
				<label for="<?php echo $this->get_field_id( 'field_7' ); ?>">User edit settings link</label>
				<br>
				<input class="widefat" id="<?php echo $this->get_field_id( 'field_9' ); ?>" name="<?php echo $this->get_field_name( 'field_9' ); ?>" type="checkbox" <?php echo $field_9 !== 'off' ? 'checked="checked"' : ''; ?> />
				<label for="<?php echo $this->get_field_id( 'field_9' ); ?>">Go offline/online link</label>
				<br>
				<input class="widefat" id="<?php echo $this->get_field_id( 'field_8' ); ?>" name="<?php echo $this->get_field_name( 'field_8' ); ?>" type="checkbox" <?php echo $field_8 !== 'off' ? 'checked="checked"' : ''; ?> />
				<label for="<?php echo $this->get_field_id( 'field_8' ); ?>">Log out link</label>
			</p>
			<p>
				<strong>Log in form:</strong>
				<br>
				<input class="widefat" id="<?php echo $this->get_field_id( 'field_1' ); ?>" name="<?php echo $this->get_field_name( 'field_1' ); ?>" type="checkbox" <?php echo $field_1 !== 'off' ? 'checked="checked"' : ''; ?> />
				<label for="<?php echo $this->get_field_id( 'field_1' ); ?>">Display login form for logged-out users</label>
			</p>
		<?php
	}
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] 		= ! empty( $new_instance['title'] ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['field_1'] 	= ! empty( $new_instance['field_1'] ) ? 'on' : 'off';
		$instance['field_2'] 	= ! empty( $new_instance['field_2'] ) ? 'on' : 'off';
		$instance['field_3'] 	= ! empty( $new_instance['field_3'] ) ? 'on' : 'off';
		$instance['field_4'] 	= ! empty( $new_instance['field_4'] ) ? 'on' : 'off';
		$instance['field_5'] 	= ! empty( $new_instance['field_5'] ) ? 'on' : 'off';
		$instance['field_6'] 	= ! empty( $new_instance['field_6'] ) ? 'on' : 'off';
		$instance['field_7'] 	= ! empty( $new_instance['field_7'] ) ? 'on' : 'off';
		$instance['field_8'] 	= ! empty( $new_instance['field_8'] ) ? 'on' : 'off';
		$instance['field_9'] 	= ! empty( $new_instance['field_9'] ) ? 'on' : 'off';
		return $instance;
	}
}
add_action( 'widgets_init', function() {
	register_widget( 'wpc_widget' );
});