<?php
/*
Plugin Name: RC Site Map
Plugin URI: https://qreate.co.uk/projects/#rcsitemap
Description: This plugin adds a shortcode that will list a site map or list of a particular type of post such as page, post or custom post types.
Version: 1.4
Author: Rick Curran
Author URI: https://qreate.co.uk
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html
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
        $links_array[] = '<a href="options-general.php?page=rc_site_map">' . __('Settings','rc_site_map_page') . '</a>';
        $links_array[] = '<a href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=QZEXMAMCYDS3G">'.__('Donate', 'rc_site_map_page').'</a>';
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
		'heading_class' => 'rc_sitemap_heading',
		'child_of' => '',
		'post_parent' => '',
		'depth' => '',
		'exclude' => '',
		'post__not_in' => '',
		'include' => '',
		'post__in' => '',
		'wrapper' => 'ul',
		'wrapper_class' => 'rc_sitemap_list',
	), $atts, 'rc_sitemap' );
	
    $post_type = sanitize_text_field( $atts[ 'post_type' ] );
    $orderby = sanitize_text_field( $atts[ 'orderby' ] );
    $order = sanitize_text_field( $atts[ 'order' ] );
    $heading_text = sanitize_text_field( $atts[ 'heading_text' ] );
    $heading_tag = sanitize_text_field( $atts[ 'heading_tag' ] );
    $heading_class = sanitize_text_field( $atts[ 'heading_class' ] );
    
    if ( sanitize_text_field( $atts[ 'child_of' ] ) != '' ) {
        $post_parent = sanitize_text_field( $atts[ 'child_of' ] );
    } else {
        $post_parent = sanitize_text_field( $atts[ 'post_parent' ] );
    }
    $depth = sanitize_text_field( $atts[ 'depth' ] );
    
    if ( sanitize_text_field( $atts[ 'exclude' ] ) != '' ) {
        $post__not_in = sanitize_text_field( $atts[ 'exclude' ] );
    } else {
        $post__not_in = sanitize_text_field( $atts[ 'post__not_in' ] );
    }
    if ( sanitize_text_field( $atts[ 'include' ] ) != '' ) {
        $post__in = sanitize_text_field( $atts[ 'include' ] );
    } else {
        $post__in = sanitize_text_field( $atts[ 'post__in' ] );
    }
    
    $wrapper = sanitize_text_field( $atts[ 'wrapper' ] );
    $wrapper_class = sanitize_text_field( $atts[ 'wrapper_class' ] );
    
    $rc_sitemap_data = '';
    
    if ( $heading_tag != '' ) {
        $h_tag = $heading_tag;
    } else {
        $h_tag = 'h2';
    }
        
    if ( $heading_text != '' ) {
        $rc_sitemap_data .= '<' . $h_tag . ' class="' . $heading_class . '">' . $heading_text . '</' . $h_tag . '>';
    }
    
    if ($wrapper != '') {
        $before = '<' . $wrapper . ' class="' . $wrapper_class . '">';
        $after = '</' . $wrapper . '>';
    }
    
	$rc_sitemap_data .= $before;
    
    $args = array(
        //'echo' => 0, // Removed - unnecessary
        'post_type' => $post_type, // Same
        'orderby' => $orderby, // 'sort_column'
        'order' => $order, // 'sort_order'
        //'title_li' => '', // Removed - unnecessary
        'post_parent' => $post_parent, // 'child_of'
		//'depth' => $depth, // Depth has to be handled as child queries now, a bit tricky!!!
		'post__not_in' => $post__not_in, // 'exclude'
		'post__in' => $post__in //  'include'  
    );
    
    //$rc_sitemap_data .= wp_list_pages( $args );  
    
    $rc_sitemap_data_query = new WP_Query( $args );
    
    if ( $rc_sitemap_data_query->have_posts() ) {
        while ( $rc_sitemap_data_query->have_posts() ) {
            $rc_sitemap_data_query->the_post();
            
            // TODO
            // Child query...
            //$depth, if -1 or 0 then get all children / depths, 1 = top level, 2, top plus one down, etc, etc
            $children = ''; // Empty by default, need to loop over all levels and generate tree hierarchy
            // TODO
            
            $rc_sitemap_data .= '<li class="page_item page-item-' . $rc_sitemap_data_query->post->ID . '"><a href="' . get_the_permalink() . '">' . get_the_title() . '</a>' . $children . '</li>';
            
            
            
        }
    }
    
    
	$rc_sitemap_data .= $after;
	
	return $rc_sitemap_data;
}
	
add_shortcode( 'rc_sitemap', 'rc_sitemap_shortcode' );

?>