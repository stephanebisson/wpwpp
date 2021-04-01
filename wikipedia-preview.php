<?php
/**
 * Plugin Name: Wikipedia Preview
 * Description: Add Wikipedia preview to your articles
 * Version: 0.1.0
 */

function wikipediapreview_shortcode( $atts = array(), $content = null, $tag = '' ) {
	$title = $atts['title'] ?? $content;
	$lang = $atts['lang'] ?? 'en';
	return "<span data-wikipedia-preview data-wp-title=\"$title\" data-wp-lang=\"$lang\">" .
		$content .
		'</span>';
}

function wikipediapreview_shortcodes_init() {
    add_shortcode( 'wikipediapreview', 'wikipediapreview_shortcode' );
}

function wikipediapreview_enqueue_scripts() {
	wp_enqueue_script('wikipedia-preview', 'https://unpkg.com/wikipedia-preview@1.1.1/dist/wikipedia-preview.production.js', [], null, true);
	// The content of the init file is basically `wikipediaPreview.init({});`
	wp_enqueue_script('wikipedia-preview-init', plugin_dir_url( __FILE__ ) . '/init.js', [], false, true);

	wp_enqueue_style(
		'wmf-wp-format-css',
		'https://unpkg.com/wikipedia-preview@1.1.1/dist/wikipedia-preview.css'
	);
}

add_action( 'init', 'wikipediapreview_shortcodes_init' );
add_action( 'wp_enqueue_scripts', 'wikipediapreview_enqueue_scripts' );

function myguten_enqueue() {
	wp_enqueue_script(
		'wmf-wp-format',
		plugins_url( 'wmf-wp-format.js', __FILE__ ),
		[], false, true
	);
	wp_enqueue_style(
		'wmf-wp-format-css',
		'https://unpkg.com/wikipedia-preview@1.1.1/dist/wikipedia-preview.css'
	);
}
add_action( 'enqueue_block_editor_assets', 'myguten_enqueue' );
