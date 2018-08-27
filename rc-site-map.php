<?php
/*
Plugin Name: RC Site Map
Plugin URI: http://suburbia.org.uk/projects/#rcsitemap
Description: Render a list of pages / posts / cpts on any page or post using a shortcode [rc_sitemap]. Uses a subset of parameters of 'wp_list_pages' as well as some additional parameters.
Version: 1.01
Author: Rick Curran
Author URI: http://suburbia.org.uk
*/

add_action( 'admin_menu', 'rc_site_map_admin_page' );

function rc_site_map_admin_page() {
	add_options_page( 
		'RC Site Map',
		'RC Site Map',
		'edit_posts',
		'rc_site_map',
		'rc_site_map_page_display'
	);
}

function rc_site_map_page_display() {
    echo '<div class="wrap">';
    echo '<h2>RC Site Map Plugin</h2>';
    include_once( 'rc-site-map-description.php' );
}

/*
 * Additional links on plugin list page
 */
add_filter( 'plugin_row_meta', 'rc_site_map_row_meta', 10, 4 );
function rc_site_map_row_meta( $links_array, $plugin_file_name, $plugin_data, $status ) {
    if ( strpos( $plugin_file_name, basename(__FILE__) ) ) {
        $links_array[] = '<a href="options-general.php?page=rc_site_map">' . __('Settings','wp_sitemap_page') . '</a>';
        $links_array[] = '<a href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=FLMSQ9T7BYFBQ">'.__('Donate', 'wp_sitemap_page').'</a>';
    }
    return $links_array;
}


/*
 * Shortcode
 */
function rc_sitemap_shortcode( $atts ) {
    $atts = shortcode_atts( array(
		'post_type' => 'page',
		'orderby' => 'menu_order',
		'order' => 'ASC',
		'heading_text' => '',
		'heading_tag' => 'h2',
		'child_of' => '',
		'depth' => '',
		'exclude' => '',
		'include' => '',
		'wrapper' => 'ul',
		'wrapper_class' => 'rc_sitemap_list',
	), $atts, 'rc_sitemap' );
	
    $post_type = sanitize_text_field( $atts[ 'post_type' ] );
    $orderby = sanitize_text_field( $atts[ 'orderby' ] );
    $order = sanitize_text_field( $atts[ 'order' ] );
    $heading_text = sanitize_text_field( $atts[ 'heading_text' ] );
    $heading_tag = sanitize_text_field( $atts[ 'heading_tag' ] );
    $child_of = sanitize_text_field( $atts[ 'child_of' ] );
    $depth = sanitize_text_field( $atts[ 'depth' ] );
    $exclude = sanitize_text_field( $atts[ 'exclude' ] );
    $include = sanitize_text_field( $atts[ 'include' ] );
    $wrapper = sanitize_text_field( $atts[ 'wrapper' ] );
    $wrapper_class = sanitize_text_field( $atts[ 'wrapper_class' ] );
    
    $rc_sitemap_data = '';
    
    if ( $heading_tag != '' ) {
        $h_tag = $heading_tag;
    } else {
        $h_tag = 'h2';
    }
    
    if ( $heading_text != '' ) {
        $rc_sitemap_data .= '<' . $h_tag . ' class="rc_sitemap_heading">' . $heading_text . '</' . $h_tag . '>';
    }
    
    if ($wrapper != '') {
        $before = '<' . $wrapper . ' class="' . $wrapper_class . '">';
        $after = '</' . $wrapper . '>';
    }
    
	$rc_sitemap_data .= $before;
    
    $args = array(
        'echo' => 0,
        'post_type' => $post_type,
        'sort_column' => $orderby,
        'sort_order' => $order,
        'title_li' => '',
        'child_of' => $child_of,
		'depth' => $depth,
		'exclude' => $exclude,
		'include' => $include       
    );
    
    $rc_sitemap_data .= wp_list_pages( $args );    
	
	$rc_sitemap_data .= $after;
	
	return $rc_sitemap_data;
}
	
add_shortcode( 'rc_sitemap', 'rc_sitemap_shortcode' );

?>