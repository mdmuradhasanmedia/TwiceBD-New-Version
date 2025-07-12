<?php class PTXShortcode{
	public function __construct(){
		add_shortcode( 'img', array( $this, 'parse_shortcode' ) );
		add_filter( 'media_view_strings', array( $this, 'media_strings' ), 10, 2 );
		add_filter( 'image_size_names_choose', array( $this, 'image_sizes' ) );
		add_filter( 'wp_prepare_attachment_for_js', array( $this, 'fix_attachment' ), 10, 3 );
		add_filter( 'ptx_html_attrs', array( $this, 'html_attrs' ), 10, 2 );
	}

	public function parse_shortcode( $attrs ){
		$post = get_post();
		$a = shortcode_atts( array(
			'id' => get_post_thumbnail_id( $post->ID ),
			'size' => 'large',
			'class' => 'post_thumbnail',
			'link' => 'none',
			'html_attrs' => 'class',
		), $attrs, 'ptx' );

		if ( ! wp_attachment_is_image( $a['id'] ) ) return;

		$html_attrs = apply_filters('ptx_html_attrs', array(), $a);
		$html = wp_get_attachment_image( $a['id'], $a['size'], false, $html_attrs );
		$link_url = wp_get_attachment_url( $a['id'] );

		return "<a href='$link_url'>$html</a>";
	}

	public function file_attrs( $attrs, $shortcode_attrs ){
		foreach ( explode(',', $shortcode_attrs['file_attrs']) as $attr) {
			if ( in_array( $attr, $shortcode_attrs ) ) {
				$attrs[$attr] = $shortcode_attrs[$attr];
			}
		}
		return $attrs;
	}

	public function html_attrs( $attrs, $shortcode_attrs ){
		foreach ( explode(',', $shortcode_attrs['html_attrs']) as $attr) {
			if ( in_array( $attr, $shortcode_attrs ) ) {
				$attrs[$attr] = $shortcode_attrs[$attr];
			}
		}
		return $attrs;
	}

	public function media_strings( $strings, $post ){
		$strings['PTXInsertShortcode'] = __( 'Insert Shortcode', 'tie' );
		return $strings;
	}

	public function image_sizes ( $sizes ){
		if ( false !== $ptx_post_thumbnails = get_option( 'ptx_post_thumbnails' ) ){
			foreach ( $ptx_post_thumbnails as $thumbnail ){
				$sizes[$thumbnail['name']] = $thumbnail['name'];
			}
		}
		return $sizes;
	}

	public function fix_attachment( $response, $attachment, $meta ){
		$predefined = array( 'thumbnail', 'medium', 'large', 'full' );
		$possible_sizes = apply_filters( 'image_size_names_choose', array() );
		foreach ( $predefined as $size ) {
			if ( isset( $possible_sizes[$size] ) ) {
				unset( $possible_sizes[$size] );
			}
		}


		foreach ( $possible_sizes as $size => $label ){
			if ( isset( $response['sizes'][$size] ) )
				continue;
			$img = wp_get_attachment_image_src( $response['id'], $size );
			$response['sizes'][$size] = array(
				'height' => $img[2],
				'width' => $img[1],
				'url' => $img[0],
			  	'orientation' => ( $img[2] > $img[1] ) ? 'portrait' : 'landscape'
			);
		}
		return $response;
	}
}

$PTX_SHORTCODE = new PTXShortcode();
?>