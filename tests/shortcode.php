<?php
/**
 * Focused regression checks using real WordPress sanitizers, post helpers and walkers.
 * Usage: php tests/shortcode.php /path/to/wordpress
 * Queries and permalinks use fixtures; this does not replace database integration tests.
 */
error_reporting( E_ALL );
set_error_handler( function ( $severity, $message, $file, $line ) {
    throw new ErrorException( $message, 0, $severity, $file, $line );
} );
$root = $argv[1] ?? '';
if ( ! is_file( $root . '/wp-includes/version.php' ) ) {
    throw new RuntimeException( 'Pass the path to an unpacked WordPress installation.' );
}
define( 'ABSPATH', rtrim( $root, '/' ) . '/' );
define( 'WPINC', 'wp-includes' );
define( 'OBJECT', 'OBJECT' );
define( 'ARRAY_A', 'ARRAY_A' );
define( 'ARRAY_N', 'ARRAY_N' );
foreach ( array( 'compat', 'plugin', 'shortcodes', 'load', 'functions', 'utf8', 'formatting', 'kses', 'cache', 'class-wp-post', 'post', 'post-template', 'class-wp-walker', 'class-walker-page', 'pomo/translations', 'l10n', 'class-wp-token-map', 'html-api/html5-named-character-references', 'html-api/class-wp-html-attribute-token', 'html-api/class-wp-html-span', 'html-api/class-wp-html-doctype-info', 'html-api/class-wp-html-text-replacement', 'html-api/class-wp-html-decoder', 'html-api/class-wp-html-tag-processor' ) as $file ) {
    require_once ABSPATH . WPINC . '/' . $file . '.php';
}
wp_cache_init();
$GLOBALS['l10n']['rc-site-map'] = new NOOP_Translations();
add_filter( 'pre_option_blog_charset', function () { return 'UTF-8'; } );
$GLOBALS['wp_post_types'] = array(
    'page' => (object) array( 'hierarchical' => true ),
    'post' => (object) array( 'hierarchical' => false ),
    'book' => (object) array( 'hierarchical' => true ),
);
function get_queried_object_id() { return 3; }
function is_singular() { return true; }
function get_permalink( $post ) { return 'https://example.com/' . $post->ID . '/'; }
class WP_Query {
    public static array $args = array();
    public static array $fixtures = array();
    public array $posts;
    public function __construct( $args ) {
        self::$args = $args;
        $this->posts = array_values( array_filter( self::$fixtures, function ( $post ) use ( $args ) {
            return $post->post_type === $args['post_type']
                && $post->post_status === $args['post_status']
                && ( ! $args['post__in'] || in_array( $post->ID, $args['post__in'], true ) )
                && ! in_array( $post->ID, $args['post__not_in'], true )
                && ( ! isset( $args['post_parent'] ) || $post->post_parent === $args['post_parent'] );
        } ) );
    }
}
require dirname( __DIR__ ) . '/trunk/rc-site-map.php';
function check( $condition, $message ) {
    if ( ! $condition ) {
        throw new RuntimeException( $message );
    }
    echo "PASS: $message\n";
}
function fixture( $id, $parent = 0, $type = 'page', $status = 'publish', $title = null ) {
    $post = new WP_Post( (object) array(
        'ID' => $id, 'post_parent' => $parent, 'post_type' => $type,
        'post_status' => $status, 'post_title' => $title ?? 'Entry ' . $id,
    ) );
    wp_cache_add( $id, $post, 'posts' );
    return $post;
}
WP_Query::$fixtures = array( fixture( 1 ), fixture( 2, 1 ), fixture( 3, 2 ), fixture( 4 ), fixture( 5, 0, 'page', 'private' ), fixture( 6, 0, 'page', 'draft' ) );
for ( $id = 10; $id < 22; ++$id ) {
    WP_Query::$fixtures[] = fixture( $id );
}
$GLOBALS['post'] = WP_Query::$fixtures[0];
$original_post = $GLOBALS['post'];
$output = rc_sitemap_shortcode( array() );
check( substr_count( $output, '<li ' ) === 16, 'all published entries are listed, including more than ten' );
check( WP_Query::$args['posts_per_page'] === -1 && WP_Query::$args['no_found_rows'] && WP_Query::$args['ignore_sticky_posts'], 'query requests all entries without counts or sticky post promotion' );
check( substr_count( $output, "class='children'" ) === 2, 'default output nests children and grandchildren' );
check( strpos( $output, 'current_page_item' ) !== false && strpos( $output, 'current_page_parent' ) !== false && strpos( $output, 'current_page_ancestor' ) !== false, 'current page, parent and ancestor classes are present' );
check( $GLOBALS['post'] === $original_post, 'rendering preserves the original global post' );
check( strpos( $output, 'page-item-5"' ) === false && strpos( $output, 'page-item-6"' ) === false, 'private and draft entries are excluded' );
check( substr_count( rc_sitemap_shortcode( array( 'depth' => '1' ) ), '<li ' ) === 14, 'depth 1 only lists root entries' );
check( substr_count( rc_sitemap_shortcode( array( 'depth' => '2' ) ), '<li ' ) === 15, 'depth 2 excludes grandchildren' );
$output = rc_sitemap_shortcode( array( 'depth' => '-1' ) );
check( substr_count( $output, '<li ' ) === 16 && strpos( $output, "class='children'" ) === false, 'depth -1 lists all entries without nesting' );
$output = rc_sitemap_shortcode( array( 'child_of' => '1', 'post_parent' => '4' ) );
check( substr_count( $output, '<li ' ) === 2 && strpos( $output, 'page-item-1"' ) === false, 'child_of selects descendants and takes precedence over post_parent' );
check( substr_count( rc_sitemap_shortcode( array( 'child_of' => '1', 'depth' => '1' ) ), '<li ' ) === 1, 'depth is relative to the child_of subtree' );
check( substr_count( rc_sitemap_shortcode( array( 'child_of' => '0' ) ), '<li ' ) === 16, 'child_of zero includes the full tree' );
check( substr_count( rc_sitemap_shortcode( array( 'post_parent' => '1' ) ), '<li ' ) === 1, 'post_parent selects immediate children' );
foreach ( array( 'include', 'post__in' ) as $attribute ) {
    $output = rc_sitemap_shortcode( array( $attribute => '1,4' ) );
    check( WP_Query::$args['post__in'] === array( 1, 4 ) && substr_count( $output, '<li ' ) === 2, "$attribute parses an ID list" );
}
foreach ( array( 'exclude', 'post__not_in' ) as $attribute ) {
    $output = rc_sitemap_shortcode( array( $attribute => '4,10' ) );
    check( WP_Query::$args['post__not_in'] === array( 4, 10 ) && substr_count( $output, '<li ' ) === 14, "$attribute parses an ID list" );
}
$output = rc_sitemap_shortcode( array( 'wrapper' => '' ) );
check( strpos( $output, '<li ' ) === 0, 'empty wrapper renders items without warnings' );
check( strpos( rc_sitemap_shortcode( array( 'wrapper' => 'ol' ) ), '<ol ' ) === 0, 'ordered list wrapper works' );
$output = rc_sitemap_shortcode( array(
    'wrapper' => 'img src=x onerror=alert(1)', 'wrapper_class' => 'one two" onmouseover="alert(1)',
    'heading_text' => 'A & B', 'heading_tag' => 'img src=x onerror=alert(1)',
    'heading_class' => 'heading" onclick="alert(1)',
) );
$dom = new DOMDocument();
$dom->loadHTML( $output );
check( $dom->getElementsByTagName( 'img' )->length === 0 && $dom->getElementsByTagName( 'h2' )->length === 1, 'invalid tags fall back to safe tags' );
$has_event_attribute = false;
foreach ( $dom->getElementsByTagName( '*' ) as $element ) {
    foreach ( $element->attributes as $attribute ) {
        $has_event_attribute = $has_event_attribute || strpos( $attribute->name, 'on' ) === 0;
    }
}
check( ! $has_event_attribute, 'class attributes cannot inject event handlers' );
check( strpos( $output, 'A &amp; B' ) !== false, 'heading text is HTML escaped' );
rc_sitemap_shortcode( array( 'orderby' => 'menu_order,post_title', 'order' => 'desc' ) );
check( WP_Query::$args['orderby'] === 'menu_order post_title' && WP_Query::$args['order'] === 'DESC', 'comma-separated sorting and lowercase order are normalized' );
WP_Query::$fixtures = array( fixture( 30, 0, 'post' ), fixture( 31, 30, 'post' ) );
check( strpos( rc_sitemap_shortcode( array( 'post_type' => 'post', 'depth' => '1' ) ), "class='children'" ) === false, 'non-hierarchical posts stay flat' );
WP_Query::$fixtures = array( fixture( 40, 0, 'book' ), fixture( 41, 40, 'book' ) );
check( strpos( rc_sitemap_shortcode( array( 'post_type' => 'book' ) ), 'children' ) !== false, 'hierarchical custom post types nest correctly' );
WP_Query::$fixtures = array( fixture( 50, 0, 'page', 'publish', '<img src=x onerror=alert(1)> & Title' ) );
$output = rc_sitemap_shortcode( array() );
check( strpos( $output, '<img' ) === false && strpos( $output, '&lt;img' ) === false && strpos( $output, '&amp; Title' ) !== false, 'post title HTML is stripped and remaining text is escaped' );
$title_wrapper = function ( $title ) { return '<span class="p-name">' . $title . '</span>'; };
add_filter( 'the_title', $title_wrapper );
WP_Query::$fixtures = array( fixture( 51, 0, 'page', 'publish', 'About & Contact' ) );
$output = rc_sitemap_shortcode( array() );
check( strpos( $output, 'p-name' ) === false && strpos( $output, '>About &amp; Contact</a>' ) !== false, 'theme title wrappers do not appear as markup or visible text' );
remove_filter( 'the_title', $title_wrapper );
WP_Query::$fixtures = array();
check( rc_sitemap_shortcode( array( 'wrapper' => '' ) ) === '', 'empty results and an empty wrapper produce no output' );
ob_start();
rc_site_map_page_display();
$help = ob_get_clean();
check( strpos( $help, 'Overview of shortcode' ) !== false && strpos( $help, '[rc_sitemap]' ) !== false, 'translated dashboard documentation renders successfully' );
check( substr_count( $help, '<div ' ) === substr_count( $help, '</div>' ), 'dashboard documentation closes its containers' );
echo "All regression checks passed.\n";
