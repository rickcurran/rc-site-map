<?php
/**
 * Escaped HTML list output for the sitemap.
 *
 * @package RC_Site_Map
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Render links using explicit post objects so shortcode output never changes $post.
 */
class RC_Site_Map_Walker extends Walker_Page {
	/**
	 * Start an entry using its post object rather than the global post.
	 *
	 * @param string  $output            HTML output, appended by reference.
	 * @param WP_Post $data_object       Post being rendered.
	 * @param int     $depth             Current nesting depth.
	 * @param array   $args              Walker arguments and current page context.
	 * @param int     $current_object_id Current page ID.
	 * @return void
	 */
	public function start_el( &$output, $data_object, $depth = 0, $args = array(), $current_object_id = 0 ) {
		$classes = array( 'page_item', 'page-item-' . (int) $data_object->ID );
		if ( isset( $args['pages_with_children'][ $data_object->ID ] ) ) {
			$classes[] = 'page_item_has_children';
		}
		if ( in_array( (int) $data_object->ID, $args['current_ancestors'], true ) ) {
			$classes[] = 'current_page_ancestor';
		}
		if ( (int) $data_object->ID === $args['current_parent'] ) {
			$classes[] = 'current_page_parent';
		}
		$current = (int) $data_object->ID === (int) $current_object_id;
		if ( $current ) {
			$classes[] = 'current_page_item';
		}
		$output .= '<li class="' . esc_attr( implode( ' ', $classes ) ) . '"><a href="'
			. esc_url( get_permalink( $data_object ) ) . '"'
			. ( $current ? ' aria-current="page"' : '' ) . '>'
			. esc_html( wp_strip_all_tags( get_the_title( $data_object ) ) ) . '</a>';
	}
}
