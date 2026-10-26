<?php
/**
 * RC Site Map shortcode plugin.
 *
 * @package RC_Site_Map
 *
 * Plugin Name: RC Site Map
 * Plugin URI: https://qreate.co.uk/projects/#rcsitemap
 * Description: This plugin adds a shortcode that will list a site map or list of a particular type of post such as page, post or custom post types.
 * Version: 1.5
 * Requires PHP: 8.0
 * Text Domain: rc-site-map
 * Author: Rick Curran
 * Author URI: https://qreate.co.uk
 * License: GPLv2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once __DIR__ . '/includes/class-rc-site-map-walker.php';

add_action( 'admin_menu', 'rc_site_map_admin_page' );
add_action( 'admin_enqueue_scripts', 'rc_site_map_admin_styles' );

/**
 * Load the help page styles only on this plugin’s settings screen.
 *
 * @param string $hook_suffix Current admin screen hook.
 * @return void
 */
function rc_site_map_admin_styles( $hook_suffix ) {
	if ( 'settings_page_rc_site_map' !== $hook_suffix ) {
		return;
	}

	wp_enqueue_style( 'rc-site-map-admin', plugins_url( 'assets/admin.css', __FILE__ ), array(), '1.5' );
}

/**
 * Register the shortcode help page.
 *
 * @return void
 */
function rc_site_map_admin_page() {
	add_options_page(
		__( 'RC Site Map', 'rc-site-map' ),
		__( 'RC Site Map', 'rc-site-map' ),
		'edit_posts',
		'rc_site_map',
		'rc_site_map_page_display'
	);
}

/**
 * Display the shortcode documentation in the dashboard.
 *
 * @return void
 */
function rc_site_map_page_display() {
	echo '<div class="wrap">';
	echo '<h2>' . esc_html__( 'RC Site Map Plugin', 'rc-site-map' ) . '</h2>';
	include __DIR__ . '/rc-site-map-description.php';
	echo '</div>';
}

/*
 * Additional links on plugin list page
 */
add_filter( 'plugin_row_meta', 'rc_site_map_row_meta', 10, 2 );
/**
 * Add help and donation links to this plugin’s metadata.
 *
 * @param string[] $links_array      Existing plugin metadata links.
 * @param string   $plugin_file_name Plugin path relative to the plugins directory.
 * @return string[] Plugin metadata links.
 */
function rc_site_map_row_meta( $links_array, $plugin_file_name ) {
	if ( plugin_basename( __FILE__ ) === $plugin_file_name ) {
		$links_array[] = '<a href="options-general.php?page=rc_site_map">' . esc_html__( 'Settings', 'rc-site-map' ) . '</a>';
		$links_array[] = '<a href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=QZEXMAMCYDS3G">' . esc_html__( 'Donate', 'rc-site-map' ) . '</a>';
	}
	return $links_array;
}


/**
 * Render a published sitemap without modifying the global post.
 *
 * @param array|string $atts Shortcode attributes.
 * @return string Escaped sitemap HTML.
 */
function rc_sitemap_shortcode( $atts ) {
	$atts = shortcode_atts(
		array(
			'post_type'     => 'page',
			'orderby'       => 'menu_order',
			'order'         => 'ASC',
			'heading_text'  => '',
			'heading_tag'   => 'h2',
			'heading_class' => 'rc_sitemap_heading',
			'child_of'      => '',
			'post_parent'   => '',
			'depth'         => '',
			'exclude'       => '',
			'post__not_in'  => '',
			'include'       => '',
			'post__in'      => '',
			'wrapper'       => 'ul',
			'wrapper_class' => 'rc_sitemap_list',
		),
		$atts,
		'rc_sitemap'
	);

	$post_type   = sanitize_key( $atts['post_type'] );
	$heading_tag = strtolower( sanitize_text_field( $atts['heading_tag'] ) );
	if ( ! in_array( $heading_tag, array( 'h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'p', 'div', 'span' ), true ) ) {
		$heading_tag = 'h2';
	}
	$wrapper = strtolower( sanitize_text_field( $atts['wrapper'] ) );
	if ( ! in_array( $wrapper, array( '', 'ul', 'ol' ), true ) ) {
		$wrapper = 'ul';
	}
	$heading_text = sanitize_text_field( $atts['heading_text'] );
	$include      = sanitize_text_field( $atts['include'] );
	$exclude      = sanitize_text_field( $atts['exclude'] );
	$child_of     = sanitize_text_field( $atts['child_of'] );
	$post_parent  = sanitize_text_field( $atts['post_parent'] );
	$depth        = max( -1, (int) $atts['depth'] );

	$args = array(
		'post_type'           => $post_type,
		'post_status'         => 'publish',
		'posts_per_page'      => -1,
		'no_found_rows'       => true,
		'ignore_sticky_posts' => true,
		'orderby'             => str_replace( ',', ' ', sanitize_text_field( $atts['orderby'] ) ),
		'order'               => strtoupper( sanitize_text_field( $atts['order'] ) ) === 'DESC' ? 'DESC' : 'ASC',
		'post__not_in'        => wp_parse_id_list( '' !== $exclude ? $exclude : $atts['post__not_in'] ),
		'post__in'            => wp_parse_id_list( '' !== $include ? $include : $atts['post__in'] ),
	);
	// child_of selects all descendants; post_parent selects immediate children.
	if ( '' === $child_of && '' !== $post_parent ) {
		$args['post_parent'] = absint( $post_parent );
	}

	$query        = new WP_Query( $args );
	$posts        = $query->posts;
	$hierarchical = is_post_type_hierarchical( $post_type );
	if ( $hierarchical && absint( $child_of ) > 0 ) {
		$posts = get_page_children( absint( $child_of ), $posts );
	}

	$current_id   = is_singular() ? get_queried_object_id() : 0;
	$current_post = $current_id ? get_post( $current_id ) : null;
	$walker_args  = array(
		'walker'            => new RC_Site_Map_Walker(),
		'current_ancestors' => $current_post ? array_map( 'intval', get_post_ancestors( $current_post ) ) : array(),
		'current_parent'    => $current_post ? (int) $current_post->post_parent : 0,
	);
	$items        = walk_page_tree( $posts, $hierarchical ? $depth : -1, $current_id, $walker_args );

	$output = '';
	if ( '' !== $heading_text ) {
		$output .= '<' . $heading_tag . ' class="' . esc_attr( $atts['heading_class'] ) . '">'
			. esc_html( $heading_text ) . '</' . $heading_tag . '>';
	}
	if ( '' !== $wrapper ) {
		$output .= '<' . $wrapper . ' class="' . esc_attr( $atts['wrapper_class'] ) . '">';
	}
	$output .= $items;
	if ( '' !== $wrapper ) {
		$output .= '</' . $wrapper . '>';
	}
	return $output;
}

add_shortcode( 'rc_sitemap', 'rc_sitemap_shortcode' );
