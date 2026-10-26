<?php
/**
 * Shortcode help displayed on the plugin’s dashboard page.
 *
 * @package RC_Site_Map
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div class="rc-site-map-help">
	<p><?php esc_html_e( 'This plugin adds a shortcode that will list a hierarchical site map or list of a particular type of post such as page, post or custom post types.', 'rc-site-map' ); ?></p>
	<p><?php echo wp_kses_post( __( 'The shortcode is registered using the name: <code>rc_sitemap</code>. The shortcode will by default render an unordered list of the entries with a class of <code>rc_sitemap_list</code>. The optional heading that it outputs has the class <code>rc_sitemap_heading</code>.', 'rc-site-map' ) ); ?></p>
	<hr>
	<h3><?php esc_html_e( 'Overview of shortcode', 'rc-site-map' ); ?></h3>
	<p><strong><?php echo wp_kses_post( __( 'Site map (<code>rc_sitemap</code>)', 'rc-site-map' ) ); ?></strong></p>
	<p><?php esc_html_e( 'This shortcode is used to get and render a list of published posts like a site map. The attributes are as follows:', 'rc-site-map' ); ?></p>
	<ul>
		<li><?php echo wp_kses_post( __( '<code>post_type</code> - defaults to <code>page</code>. You can use \'post\', \'page\' or any post type name.', 'rc-site-map' ) ); ?></li>
		<li><?php echo wp_kses_post( __( '<code>orderby</code> - defaults to <code>menu_order</code>. Comma-separated list of options to sort by: accepts \'post_author\', \'post_date\', \'post_title\', \'post_name\', \'post_modified\', \'menu_order\', \'post_parent\', \'ID\', \'rand\', or \'comment_count\'.', 'rc-site-map' ) ); ?></li>
		<li><?php echo wp_kses_post( __( '<code>order</code> - defaults to <code>ASC</code>.', 'rc-site-map' ) ); ?></li>
		<li><?php echo wp_kses_post( __( '<code>heading_text</code> - defaults to empty, show no heading.', 'rc-site-map' ) ); ?></li>
		<li><?php echo wp_kses_post( __( '<code>heading_tag</code> - defaults to <code>h2</code>. Accepts h1–h6, p, div or span; invalid values fall back to h2.', 'rc-site-map' ) ); ?></li>
		<li><?php echo wp_kses_post( __( '<code>heading_class</code> - defaults to <code>rc_sitemap_heading</code>. CSS Class added to the heading element.', 'rc-site-map' ) ); ?></li>
		<li><?php echo wp_kses_post( __( '<code>child_of</code> - defaults to empty. Display all descendants of a page by ID, excluding the parent itself. Empty or 0 includes all pages. Only applies to hierarchical post types and takes precedence over post_parent.', 'rc-site-map' ) ); ?></li>
		<li><?php echo wp_kses_post( __( '<code>depth</code> - defaults to empty. Number of levels in the hierarchy of pages to include in the generated list. Accepts -1 (a flat list of all matching entries), 0 or empty (all levels nested), 1 (top-level entries only), and n (entries to the given depth). With child_of, depth starts at the selected parent’s children. Non-hierarchical post types always render as flat lists.', 'rc-site-map' ) ); ?></li>
		<li><?php echo wp_kses_post( __( '<code>exclude</code> - defaults to empty. Comma-separated list of post IDs to exclude.', 'rc-site-map' ) ); ?></li>
		<li><?php echo wp_kses_post( __( '<code>include</code> - defaults to empty. Comma-separated list of post IDs to include.', 'rc-site-map' ) ); ?></li>
		<li><?php echo wp_kses_post( __( '<code>wrapper</code> - defaults to <code>ul</code>. Wrapping element of the list. Accepts ul, ol or an empty value for no wrapper. Invalid values fall back to ul; nested lists use ul.', 'rc-site-map' ) ); ?></li>
		<li><?php echo wp_kses_post( __( '<code>wrapper_class</code> - defaults to <code>rc_sitemap_list</code>. CSS Class added to the wrapping element of the list.', 'rc-site-map' ) ); ?></li>
		<li><?php echo wp_kses_post( __( '<code>post_parent</code> - optional. Select immediate children of a parent ID; 0 selects top-level entries. Ignored when child_of is set.', 'rc-site-map' ) ); ?></li>
		<li><?php echo wp_kses_post( __( '<code>post__in</code> / <code>post__not_in</code> - aliases for include / exclude. The friendly attributes take precedence when supplied.', 'rc-site-map' ) ); ?></li>
	</ul>


	<hr>


	<h3><?php esc_html_e( 'Example usage:', 'rc-site-map' ); ?></h3>

	<p><?php echo wp_kses_post( __( 'The most basic shortcode will render a list of <code>page</code> post type entries as an unordered HTML list in ascending order with no list heading:', 'rc-site-map' ) ); ?></p>

	<p><code>[rc_sitemap]</code></p>

	<p><?php esc_html_e( 'The following is an example of a more advanced usage with custom settings applied via the various additional attributes:', 'rc-site-map' ); ?></p>

	<p><code>[rc_sitemap post_type=&quot;your_cpt_name&quot; orderby=&quot;date&quot; order=&quot;DESC&quot; heading_text=&quot;My CPT Title&quot; heading_tag=&quot;h1&quot; heading_class=&quot;my_custom_heading_class&quot; wrapper=&quot;ul&quot; wrapper_class=&quot;my_custom_wrapper_class&quot;]</code></p>

	<br>

	<hr>

	<h3><?php esc_html_e( 'Frequently Asked Questions', 'rc-site-map' ); ?></h3>

	<h4><?php esc_html_e( 'What does this plugin do?', 'rc-site-map' ); ?></h4>

	<p><?php echo wp_kses_post( __( 'This plugin adds a shortcode that will list a site map or list of a particular type of post such as page, post or custom post types. The shortcode is registered using the name: <code>rc_sitemap</code>. The shortcode will by default render an unordered list of the entries with a class of <code>rc_sitemap_list</code>. The optional heading that it outputs has the class <code>rc_sitemap_heading</code>.', 'rc-site-map' ) ); ?></p>

	<h4><?php esc_html_e( 'Does this plugin create an XML sitemap?', 'rc-site-map' ); ?></h4>

	<p><?php esc_html_e( 'No, this plugin does not make an XML site map file for use with search engines. This plugin renders lists of posts (page, post or custom post types) into standard page / post content to be viewed by people visiting your website.', 'rc-site-map' ); ?></p>

	<h4><?php esc_html_e( 'I don\'t see a list of posts / pages on my site, I only see text like this: [rc_sitemap]', 'rc-site-map' ); ?></h4>

	<p><?php esc_html_e( 'Check that the plugin has been correctly uploaded, installed and activated. If not then the text of the shortcode will not be processed and will simply display on the site.', 'rc-site-map' ); ?></p>

	<h4><?php esc_html_e( 'How can I change and style the output of this plugin?', 'rc-site-map' ); ?></h4>

	<p><?php echo wp_kses_post( __( 'By default the wrapping element of the rendered list is a <code>ul</code> tag which has a default class of <code>rc_sitemap_list</code>. It is possible to change the wrapping element via the <code>wrapper</code> attribute of the shortcode, however, the listed items are always wrapped in <code>li</code> elements so you should really only change the wrapper to use either <code>ol</code> (via <code>wrapper="ol"</code>) to create an ordered list or set it to an empty value (via <code>wrapper=""</code>) to render no wrapping element. Other values fall back to ul. Nested lists use ul even when the outer wrapper is ol or empty.', 'rc-site-map' ) ); ?></p>

	<p><?php echo wp_kses_post( __( 'The optional <code>heading_text</code> attribute can be used to provide a heading for the list using either the default <code>h2</code> tag or a custom element using the accompanying <code>heading_tag</code> attribute (e.g. <code>heading_text="Hello World!" heading_tag="h1"</code>). The heading has a default class of <code>rc_sitemap_heading</code> which can be changed using the <code>heading_class</code> attribute. The plugin doesn\'t provide any default CSS styling but simply adds these default classes to the rendered HTML output, so you can either add styles using the standard <code>rc_sitemap_list</code> and <code>rc_sitemap_heading</code> classes or add your own using the attributes outlined above. ', 'rc-site-map' ) ); ?></p>

	<p><?php echo wp_kses_post( __( 'Note: multiple CSS classes can be added to the above elements by separating them with spaces (e.g. <code>wrapper_class="my_first_class my_second_class my_third_class"</code>).', 'rc-site-map' ) ); ?></p>

	<p><?php esc_html_e( 'In addition to the elements and classes specified above, the rendered list items have these default classes:', 'rc-site-map' ); ?></p>

	<ul>

		<li><?php echo wp_kses_post( __( '<code>page_item</code> - This class is added to each <code>li</code> list element.', 'rc-site-map' ) ); ?></li>

		<li><?php echo wp_kses_post( __( '<code>page-item-$ID</code> - This is a unique class added to each <code>li</code> list element, the <code>$ID</code> part would be the unique ID that represents that entry in WordPress, e.g. <code>`page-item-123`</code>.', 'rc-site-map' ) ); ?></li>

		<li><?php echo wp_kses_post( __( '<code>current_page_item</code> - This class is added to the <code>li</code> list element that is a link to the current page (basically the page you have this shortcode on).', 'rc-site-map' ) ); ?></li>

		<li><?php echo wp_kses_post( __( '<code>current_page_parent</code> - This class is added to the <code>li</code> list element that is a link to the hierarchical parent of the current page (basically the parent of the page you have this shortcode on).', 'rc-site-map' ) ); ?></li>

		<li><?php echo wp_kses_post( __( '<code>current_page_ancestor</code> - This class is added to the <code>li</code> list elements that are hierarchical ancestors of the current page.', 'rc-site-map' ) ); ?></li>

	</ul>

	<p><?php esc_html_e( 'If necessary the above default classes can be overridden from within your theme by specifying them in some custom CSS.', 'rc-site-map' ); ?></p>



	<hr>


	<p><strong><?php echo wp_kses_post( __( 'If you have found this plugin to be useful then please consider a donation. Donations like these help to provide time for <strong><a href="https://qreate.co.uk/about">me</a></strong> to develop plugins like this.', 'rc-site-map' ) ); ?></strong></p>
	<p><a href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=QZEXMAMCYDS3G" class="button button-primary" target="_blank" rel="noopener noreferrer"><?php esc_html_e( 'Donate', 'rc-site-map' ); ?></a></p>

	<br>

</div>
