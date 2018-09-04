=== RC Site Map Plugin ===
Contributors: rickcurran
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=FLMSQ9T7BYFBQ
Tags: sitemap
Requires at least: 4.6
Tested up to: 4.9
Stable tag: 1.0
Requires PHP: 5.2.4
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

This plugin adds a shortcode that will list a site map or list of a particular type of post such as page, post or custom post types.

== Description ==

This plugin adds a shortcode that will list a site map or list of a particular type of post such as page, post or custom post types. The shortcode is registered using the name: `rc_sitemap`. The shortcode will by default render an unordered list of the entries with a class of `"rc_sitemap_list"`. The optional heading that it outputs has the class `"rc_sitemap_heading"`

# Overview of shortcode

Site map (`rc_sitemap`)

This shortcode is used to get and render a list of published posts like a site map. The attributes are as follows:

- `post_type` - defaults to 'page'. You can use 'post', 'page' or any post type name.
- `orderby` - defaults to 'menu_order'. Comma-separated list of options to sort by: accepts 'post_author', 'post_date', 'post_title', 'post_name', 'post_modified', 'post_modified_gmt', 'menu_order', 'post_parent', 'ID', 'rand', or 'comment_count'. Default 'post_title'.
- `order` - defaults to 'ASC'.
- `heading_text` - defaults to empty, show no heading.
- `heading_tag` - defaults to h2. Note, do not include greater than / less than characters, only the alphanumeric characters e.g. p, h1, h2, h3 etc.
- `child_of` - defaults to empty. Display only the sub-pages of a single page by ID. Default 0 (all pages). Note, only works for hierarchical post types.
- `depth` - defaults to empty. Number of levels in the hierarchy of pages to include in the generated list. Accepts -1 (any depth), 0 (all pages), 1 (top-level pages only), and n (pages to the given n depth). Default 0.
- `exclude` - defaults to empty. Comma-separated list of post IDs to exclude.
- `include` - defaults to empty. Comma-separated list of post IDs to include.
- `wrapper` - defaults to `'ul'`. Wrapping element of the list. Note, do not include greater than / less than characters, only the alphanumeric characters e.g. ul, p etc.
- `wrapper_class` - defaults to `'rc_sitemap_list'`. CSS Class added to the wrapping element of the list.

== Example usage: ==

`[rc_sitemap post_type="your_cpt_name" orderby="date" order="DESC" heading_text="My CPT Title" heading_tag="h1" wrapper="ul" wrapper_class="rc_sitemap_list"]`

== Screenshots ==

1. This screen shot shows an example shortcode being entered in the WordPress editor.
2. This screen shot shows the output of the shortcode being rendered on the front end of the website.

== Installation ==
	
1. Upload the plugin package to the plugins directory of your site, or search for "RC Site Map" in the WordPress plugins directory from the Plugins section of your WordPress dashboard.
2. Once uploaded or installed you must activate the plugin from the Plugins section of your WordPress dashboard.
3. You can now use the shortcode `[rc_sitemap]` to display a list of posts.
	
== Frequently Asked Questions ==
	
= What does this plugin do? =

This plugin adds a shortcode that will list a site map or list of a particular type of post such as page, post or custom post types. The shortcode is registered using the name: `rc_sitemap`. The shortcode will by default render an unordered list of the entries with a class of `"rc_sitemap_list"`. The optional heading that it outputs has the class `"rc_sitemap_heading"`

= I don't see a list of posts on my site, I only see text like this: `[rc_sitemap]

Check that the plugin has been correctly uploaded, installed and activated. If not then the text of the shortcode will not be processed and will simply display on the site.

== Changelog ==

= 1.01 =

* Added some additional attributes to provide more of the capabilities of `wp_list_pages` such as 'child_of', 'exclude', 'include' etc.