<?php // custom functions for Zava child theme


/* custom image sizes
–––––––––––––––––––––––––––––––––––––––––––––––––------– */
add_image_size( 'page-default', 750, 500, true ); // default image for pages and posts


/* load theme js and css
–––––––––––––––––––––––––––––––––––––––––––––––––------– */
function zava_child_scripts() {

	// enqueue parent styles
	wp_enqueue_style('zava-starter-css', get_template_directory_uri() .'/style.css', array(), null );
	
	// off canvas menu
	wp_enqueue_style( 'css-mmenu', get_stylesheet_directory_uri() . '/css/jquery.mmenu.css', array(), null );
	wp_enqueue_script( 'js-mmenu', get_stylesheet_directory_uri() . '/js/jquery.mmenu.js', array('jquery'), null, true );
	
	// theme JS
	wp_enqueue_script( 'js-theme', get_stylesheet_directory_uri() . '/js/theme.js', array('js-mmenu'), null, true );

}
add_action( 'wp_enqueue_scripts', 'zava_child_scripts' );


/* some commonly used wordpress basics
–––––––––––––––––––––––––––––––––––––––––––––––––------– */

/* hide admin toolbar on frontend */
add_filter('show_admin_bar', '__return_false');

/* remove WP version number site and feed */
function remove_version() { return ''; }
add_filter('the_generator', 'remove_version');

/* remove WP version number loaded scripts */
function switch_stylesheet_src( $src, $handle ) { $src = remove_query_arg( 'ver', $src ); return $src; }
add_filter( 'style_loader_src', 'switch_stylesheet_src', 10, 2 );
add_filter( 'script_loader_src', 'switch_stylesheet_src', 10, 2 );

/* remove stupid emojis */
function disable_wp_emojicons() {
	// all actions related to emojis
	remove_action( 'admin_print_styles', 'print_emoji_styles' );
	remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
	remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
	remove_action( 'wp_print_styles', 'print_emoji_styles' );
	remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
	remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
	remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
	// filter to remove TinyMCE emojis
	add_filter( 'tiny_mce_plugins', 'disable_emojicons_tinymce' );
	add_filter( 'emoji_svg_url', '__return_false' );
}
add_action( 'init', 'disable_wp_emojicons' );

/* disable TinyMCE emojis */
function disable_emojicons_tinymce( $plugins ) {
	if ( is_array( $plugins ) ) {
		return array_diff( $plugins, array( 'wpemoji' ) );
	} else {
		return array();
	}
}

/* TinyMCE - Customise buttons on first row */
add_filter( 'mce_buttons', 'custom_mce_buttons' );
function custom_mce_buttons( $old_buttons ) {
    $new_buttons = array(
		'formatselect',
		'bold',
		'italic',
		'blockquote',
		'bullist',
		'numlist',
		'link',
        'unlink',
		'pastetext',
		'removeformat',
		'undo',
		'redo'
	);
    return $new_buttons;
}

/* TinyMCE - modify styles dropdown to hide H1, pre */
function tiny_mce_remove_unused_formats( $initFormats ) {
    // Add block format elements you want to show in dropdown
    $initFormats['block_formats'] = 'Paragraph=p;Heading 2=h2;Heading 3=h3;Heading 4=h4;Heading 5=h5;Heading 6=h6';
    return $initFormats;
}
add_filter( 'tiny_mce_before_init', 'tiny_mce_remove_unused_formats' );

/* TinyMCE - Remove entire second row */
add_filter( 'mce_buttons_2', 'remove_tiny_mce_buttons_from_kitchen_sink');
function remove_tiny_mce_buttons_from_kitchen_sink( $buttons ) {
    $remove_buttons = array(
        'formatselect', // format dropdown menu for <p>, headings, etc
        'underline',
        'alignjustify',
        'forecolor', // text color
        'pastetext', // paste as text
        'removeformat', // clear formatting
        'charmap', // special characters
        'outdent',
        'indent',
        'undo',
        'redo',
		'hr', // horizontal line
		'strikethrough',
        'wp_help' // keyboard shortcuts
    );
    foreach ( $buttons as $button_key => $button_value ) {
        if ( in_array( $button_value, $remove_buttons ) ) {
            unset( $buttons[ $button_key ] );
        }
    }
    return $buttons;
}
