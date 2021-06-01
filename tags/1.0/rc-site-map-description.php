<div id="welcome-panel" class="welcome-panel">
    <div class="welcome-panel-content">
        <div class="welcome-panel-column-container">
            <p>This plugin adds a shortcode to list a site map or list of a particular type of post such as page, post or custom post types.</p>
            <p>The custom post type is registered using the name: <code>rc_sitemap</code>. The shortcode will by default render an unordered list of the entries with a class of <code>&quot;rc_sitemap_list&quot;</code>. The optional heading that it outputs has the class <code>&quot;rc_sitemap_heading&quot;</code></p>
            <hr>
            <h3>Overview of shortcode</h3>
            <p><strong>Site map (<code>rc_sitemap</code>)</strong></p>
            <p>This shortcode is used to get and render a list of published posts like a site map. The attributes are as follows:</p>
            <ul>
            <li><code>post_type</code> - defaults to &#39;page&#39;. You can use &#39;post&#39;, &#39;page&#39; or any post type name.</li>
            <li><code>orderby</code> - defaults to &#39;menu_order&#39;. Comma-separated list of options to sort by: accepts &#39;post_author&#39;, &#39;post_date&#39;, &#39;post_title&#39;, &#39;post_name&#39;, &#39;post_modified&#39;, &#39;post_modified_gmt&#39;, &#39;menu_order&#39;, &#39;post_parent&#39;, &#39;ID&#39;, &#39;rand&#39;, or &#39;comment_count&#39;. Default &#39;post_title&#39;.</li>
            <li><code>order</code> - defaults to &#39;ASC&#39;.</li>
            <li><code>heading_text</code> - defaults to empty, show no heading.</li>
            <li><code>heading_tag</code> - defaults to h2. Note, do not include greater than / less than characters, only the alphanumeric characters e.g. p, h1, h2, h3 etc.</li>
            <li><code>child_of</code> - defaults to empty. Display only the sub-pages of a single page by ID. Default 0 (all pages). Note, only works for hierarchical post types.</li>
            <li><code>depth</code> - defaults to empty. Number of levels in the hierarchy of pages to include in the generated list. Accepts -1 (any depth), 0 (all pages), 1 (top-level pages only), and n (pages to the given n depth). Default 0.</li>
            <li><code>exclude</code> - defaults to empty. Comma-separated list of post IDs to exclude.</li>
            <li><code>include</code> - defaults to empty. Comma-separated list of post IDs to include.</li>
            <li><code>wrapper</code> - defaults to <code>&#39;ul&#39;</code>. Wrapping element of the list. Note, do not include greater than / less than characters, only the alphanumeric characters e.g. ul, p etc.</li>
            <li><code>wrapper_class</code> - defaults to <code>&#39;rc_sitemap_list&#39;</code>. CSS Class added to the wrapping element of the list.</li>
            </ul>
            <p><strong><em>Example usage</em></strong>: </p>
            <p><code>[rc_sitemap post_type=&quot;your_cpt_name&quot; orderby=&quot;date&quot; order=&quot;DESC&quot; heading_text=&quot;My CPT Title&quot; heading_tag=&quot;h1&quot; wrapper=&quot;ul&quot; wrapper_class=&quot;rc_sitemap_list&quot;]</code></p>
            <hr>
            <p>If you have found this plugin to be useful then please consider a donation. Donations like these help to provide time for <strong><a href="https://qreate.co.uk/about">me</a></strong> to develop plugins like this.</p>
            <p><a href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=FLMSQ9T7BYFBQ" class="button button-primary" target="_blank">Donate</a></p>
        </div>
    </div>
</div>