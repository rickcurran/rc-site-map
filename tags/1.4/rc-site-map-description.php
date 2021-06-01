<div id="welcome-panel" class="welcome-panel">
    <div class="welcome-panel-content">
        <div class="welcome-panel-column-container">
            <p>This plugin adds a shortcode that will list a hierarchical site map or list of a particular type of post such as page, post or custom post types.</p>
            <p>The custom post type is registered using the name: <code>rc_sitemap</code>. The shortcode will by default render an unordered list of the entries with a class of <code>rc_sitemap_list</code>. The optional heading that it outputs has the class <code>rc_sitemap_heading</code>.</p>
            <hr>
            <h3>Overview of shortcode</h3>
            <p><strong>Site map (<code>rc_sitemap</code>)</strong></p>
            <p>This shortcode is used to get and render a list of published posts like a site map. The attributes are as follows:</p>
            <ul>
                <li><code>post_type</code> - defaults to <code>page</code>. You can use 'post', 'page' or any post type name.</li>
                <li><code>orderby</code> - defaults to <code>menu_order</code>. Comma-separated list of options to sort by: accepts 'post_author', 'post_date', 'post_title', 'post_name', 'post_modified', 'post_modified_gmt', 'menu_order', 'post_parent', 'ID', 'rand', or 'comment_count'.</li>
                <li><code>order</code> - defaults to <code>ASC</code>.</li>
                <li><code>heading_text</code> - defaults to empty, show no heading.</li>
                <li><code>heading_tag</code> - defaults to <code>h2</code>. Note, do not include greater than / less than characters, only the alphanumeric characters e.g. p, h1, h2, h3 etc.</li>
                <li><code>heading_class</code> - defaults to <code>rc_sitemap_heading</code>. CSS Class added to the heading element.</li>
                <li><code>child_of</code> - defaults to empty. Display only the sub-pages of a single page by ID. Default 0 (all pages). Note, only works for hierarchical post types.</li>
                <li><code>depth</code> - defaults to empty. Number of levels in the hierarchy of pages to include in the generated list. Accepts -1 (any depth), 0 (all pages), 1 (top-level pages only), and n (pages to the given n depth).</li>
                <li><code>exclude</code> - defaults to empty. Comma-separated list of post IDs to exclude.</li>
                <li><code>include</code> - defaults to empty. Comma-separated list of post IDs to include.</li>
                <li><code>wrapper</code> - defaults to <code>ul</code>. Wrapping element of the list. Note, do not include greater than / less than characters, only the alphanumeric characters e.g. ul, p etc.</li>
                <li><code>wrapper_class</code> - defaults to <code>rc_sitemap_list</code>. CSS Class added to the wrapping element of the list.</li>
            </ul>
            
            
            <hr>
            
            
            <h3>Example usage:</h3>
            
            <p>The most basic shortcode will render a list of <code>page</code> post type entries as an unordered HTML list in ascending order with no list heading:</p>

            <p><code>[rc_sitemap]</code></p>

            <p>The following is an example of a more advanced usage with custom settings applied via the various additional attributes:</p>

            <p><code>[rc_sitemap post_type=&quot;your_cpt_name&quot; orderby=&quot;date&quot; order=&quot;DESC&quot; heading_text=&quot;My CPT Title&quot; heading_tag=&quot;h1&quot; heading_class=&quot;my_custom_heading_class&quot; wrapper=&quot;ul&quot; wrapper_class=&quot;my_custom_wrapper_class&quot;]</code></p>
            
            <br>
            
            <hr>
            
            <h3>Frequently Asked Questions</h3>
	
            <h4>What does this plugin do?</h4>

            <p>This plugin adds a shortcode that will list a site map or list of a particular type of post such as page, post or custom post types. The shortcode is registered using the name: <code>rc_sitemap</code>. The shortcode will by default render an unordered list of the entries with a class of <code>rc_sitemap_list</code>. The optional heading that it outputs has the class <code>rc_sitemap_heading</code>.</p>

            <h4>Does this plugin create an XML sitemap?</h4>

            <p>No, this plugin does not make an XML site map file for use with search engines. This plugin renders lists of posts (page, post or custom post types) into standard page / post content to be viewed by people visiting your website.</p>

            <h4>I don't see a list of posts / pages on my site, I only see text like this: [rc_sitemap]</h4>

            <p>Check that the plugin has been correctly uploaded, installed and activated. If not then the text of the shortcode will not be processed and will simply display on the site.</p>

            <h4>How can I change and style the output of this plugin?</h4>

            <p>By default the wrapping element of the rendered list is a <code>ul</code> tag which has a default class of <code>rc_sitemap_list</code>. It is possible to change the wrapping element via the <code>wrapper</code> attribute of the shortcode, however, the listed items are always wrapped in <code>li</code> elements so you should really only change the wrapper to use either <code>ol</code> (via <code>wrapper="ol"</code>) to create an ordered list or set it to an empty value (via <code>wrapper=""</code>) to render no wrapping element. Using any other wrapping element will technically work but would render an invalid HTML structure and may not display nicely in web browsers.</p>

            <p>The optional <code>heading_text</code> attribute can be used to provide a heading for the list using either the default <code>h2</code> tag or a custom element using the accompanying <code>heading_tag</code> attribute (e.g. <code>heading_text="Hello World!" heading_tag="h1"</code>). The heading has a default class of <code>rc_sitemap_heading</code> which can be changed using the <code>heading_class</code> attribute. The plugin doesn't provide any default CSS styling but simply adds these default classes to the rendered HTML output, so you can either add styles using the standard <code>rc_sitemap_list</code> and <code>rc_sitemap_heading</code> classes or add your own using the attributes outlined above. </p>

            <p>Note: multiple CSS classes can be added to the above elements by separating them with spaces (e.g. <code>wrapper_class="my_first_class my_second_class my_third_class"</code>).</p>

            <p>In addition to the elements and classes specified above, each of the rendered list items and inner hyperlink have some default classes that are added as part of the plugin's use of <code>wp_list_pages</code> to retrieve the list of entries:</p>

            <ul>
                
                <li><code>page_item</code> - This class is added to each <code>li</code> list element.</li>

                <li><code>page-item-$ID</code> - This is a unique class added to each <code>li</code> list element, the <code>$ID</code> part would be the unique ID that represents that entry in WordPress, e.g. <code>`page-item-123`</code>.</li>

                <li><code>current_page_item</code> - This class is added to the <code>li</code> list element that is a link to the current page (basically the page you have this shortcode on).</li>

                <li><code>current_page_parent</code> - This class is added to the <code>li</code> list element that is a link to the hierarchical parent of the current page (basically the parent of the page you have this shortcode on).</li>

                <li><code>current_page_ancestor</code> - This class is added to the <code>li</code> list elements that are hierarchical ancestors of the current page.</li>
                
            </ul>
            
            <p>If necessary the above default classes can be overridden from within your theme by specifying them in some custom CSS.</p>

            
            
            <hr>
            
            
            <p><strong>If you have found this plugin to be useful then please consider a donation. Donations like these help to provide time for <strong><a href="https://qreate.co.uk/about">me</a></strong> to develop plugins like this.</strong></p>
            <p><a href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=QZEXMAMCYDS3G" class="button button-primary" target="_blank">Donate</a></p>
            
            <br>
            
        </div>
    </div>
</div>