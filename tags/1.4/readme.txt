=== RC Site Map Plugin ===
Contributors: rickcurran
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=QZEXMAMCYDS3G
Tags: sitemap
Requires at least: 4.6
Tested up to: 6.6
Stable tag: 1.4
Requires PHP: 5.6
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

This plugin adds a shortcode that will list a site map or list of a particular type of post such as page, post or custom post types.

== Description ==

This plugin adds a shortcode that will list a hierarchical site map or list of a particular type of post such as page, post or custom post types with clickable links to view each listed entry. The shortcode is registered using the name: `rc_sitemap`. The shortcode will by default render an unordered list of the entries with a default class of `"rc_sitemap_list"`. The optional heading that it outputs has the default class of `rc_sitemap_heading`.

# Overview of shortcode

Site map (`rc_sitemap`)

This shortcode is used to get and render a list of published posts like a site map. The attributes are as follows:

- `post_type` - defaults to 'page'. You can use 'post', 'page' or any post type name.
- `orderby` - defaults to 'menu_order'. Comma-separated list of options to sort by: accepts 'post_author', 'post_date', 'post_title', 'post_name', 'post_modified', 'post_modified_gmt', 'menu_order', 'post_parent', 'ID', 'rand', or 'comment_count'.
- `order` - defaults to 'ASC'.
- `heading_text` - defaults to empty, show no heading.
- `heading_tag` - defaults to h2. Note, do not include greater than / less than characters, only the alphanumeric characters e.g. p, h1, h2, h3 etc.
- `heading_class` - defaults to `'rc_sitemap_heading'`. CSS Class added to the heading element.
- `child_of` - defaults to empty. Display only the sub-pages of a single page by ID. Default 0 (all pages). Note, only works for hierarchical post types.
- `depth` - defaults to empty. Number of levels in the hierarchy of pages to include in the generated list. Accepts -1 (any depth), 0 (all pages), 1 (top-level pages only), and n (pages to the given n depth).
- `exclude` - defaults to empty. Comma-separated list of post IDs to exclude.
- `include` - defaults to empty. Comma-separated list of post IDs to include.
- `wrapper` - defaults to `'ul'`. Wrapping element of the list. Note, do not include greater than / less than characters, only the alphanumeric characters e.g. ul, p etc.
- `wrapper_class` - defaults to `'rc_sitemap_list'`. CSS Class added to the wrapping element of the list.

== Example usage: ==

The most basic shortcode will render a list of `page` post type entries as an unordered HTML list in ascending order with no list heading:

`[rc_sitemap]`

The following is an example of a more advanced usage with custom settings applied via the various additional attributes:

`[rc_sitemap post_type="your_cpt_name" orderby="date" order="DESC" heading_text="My CPT Title" heading_tag="h1" heading_class="my_custom_heading_class" wrapper="ul" wrapper_class="my_custom_wrapper_class"]`

== Screenshots ==

1. This screen shot shows an example shortcode being entered in the WordPress editor.
2. This screen shot shows the output of the shortcode being rendered on the front end of the website.

== Installation ==
	
1. Upload the plugin package to the plugins directory of your site, or search for "RC Site Map" in the WordPress plugins directory from the Plugins section of your WordPress dashboard.
2. Once uploaded or installed you must activate the plugin from the Plugins section of your WordPress dashboard.
3. You can now use the shortcode `[rc_sitemap]` to display a list of the pages of your site.
	
== Frequently Asked Questions ==
	
= What does this plugin do? =

This plugin adds a shortcode that will list a site map or list of a particular type of post such as page, post or custom post types. The shortcode is registered using the name: `rc_sitemap`. The shortcode will by default render an unordered list of the entries with a class of `"rc_sitemap_list"`. The optional heading that it outputs has the class `"rc_sitemap_heading"`

= Does this plugin create an XML sitemap? =

No, this plugin does not make an XML site map file for use with search engines. This plugin renders lists of posts (page, post or custom post types) into standard page / post content to be viewed by people visiting your website.

= I don't see a list of posts / pages on my site, I only see text like this: [rc_sitemap]

Check that the plugin has been correctly uploaded, installed and activated. If not then the text of the shortcode will not be processed and will simply display on the site.

= How can I change and style the output of this plugin? =

By default the wrapping element of the rendered list is a `<ul>` tag which has a default class of `rc_sitemap_list`. It is possible to change the wrapping element via the `wrapper` attribute of the shortcode, however, the listed items are always wrapped in `<li>` elements so you should really only change the wrapper to use either `<ol>` (via `wrapper="ol"`) to create an ordered list or set it to an empty value (via `wrapper=""`) to render no wrapping element. Using any other wrapping element will technically work but would render an invalid HTML structure and may not display nicely in web browsers.

The optional `heading_text` attribute can be used to provide a heading for the list using either the default `h2` tag or a custom element using the accompanying `heading_tag` attribute (e.g. `heading_text="Hello World!" heading_tag="h1"`). The heading has a default class of `rc_sitemap_heading` which can be changed using the `heading_class` attribute. The plugin doesn't provide any default CSS styling but simply adds these default classes to the rendered HTML output, so you can either add styles using the standard `rc_sitemap_list` and `rc_sitemap_heading` classes or add your own using the attributes outlined above. 

Note: multiple CSS classes can be added to the above elements by separating them with spaces (e.g. `wrapper_class="my_first_class my_second_class my_third_class"`).

In addition to the elements and classes specified above, each of the rendered list items and inner hyperlink have some default classes that are added as part of the plugin's use of `wp_list_pages` to retrieve the list of entries: 

- `page_item` - This class is added to each `li` list element.

- `page-item-$ID` - This is a unique class added to each `li` list element, the `$ID` part would be the unique ID that represents that entry in WordPress, e.g. `page-item-123`.

- `current_page_item` - This class is added to the `li` list element that is a link to the current page (basically the page you have this shortcode on).

- `current_page_parent` - This class is added to the `li` list element that is a link to the hierarchical parent of the current page (basically the parent of the page you have this shortcode on).

- `current_page_ancestor` - This class is added to the `li` list elements that are hierarchical ancestors of the current page.

If necessary the above default classes can be overridden from within your theme by specifying them in some custom CSS.

= My custom post type won't show up =

For custom post types to be listed by this plugin they currently have to be hierarchical, e.g. in the 'register_post_type' function for setting up the CPT it would have hierarchical' => true and 'capability_type' => 'page'. A future update should enable all kinds of CPTs but for now this is required for CPTs to work with this plugin.

== Changelog ==

= 1.4 =

- Updated the url of the website for the plugin and clarify compatibility up to WordPress 5.7.2

= 1.3 =

- Removed limitation for custom post types to have to be hierarchical ('page' capability). This required a reasonably big change to the underlying code but any existing shortcodes should function as before, however it is worth reading the notes of the plugin as there are some changes that improve the functions of the shortcode. This underlying change will also enable some future improvements to the functionality of the plugin. 

= 1.2 =

- Updated PayPal donation link
- Fixed typo on donation link settings