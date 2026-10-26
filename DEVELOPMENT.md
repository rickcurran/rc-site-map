# Development checks

The distributable plugin is in `trunk/`. Release snapshots in `tags/` are preserved.

Install the pinned development tools with Composer:

```sh
composer install
vendor/bin/phpcs
```

`phpcs.xml.dist` runs the full WordPress ruleset over every PHP file in `trunk/`, including its templates and class files. It also checks the `rc-site-map` translation domain, plugin prefixes, and WordPress API compatibility against the declared minimum WordPress version of 4.6. The lockfile pins WordPressCS 3.4.1 and PHP_CodeSniffer 3.13.6. These are development dependencies and are not required to run the plugin.

To apply automatic formatting fixes:

```sh
vendor/bin/phpcbf
```

Run the regression checks against an unpacked WordPress 7.1 installation:

```sh
php tests/shortcode.php /absolute/path/to/wordpress
```

The regression harness loads real WordPress sanitizers, post helpers, translation functions, and tree walkers. Database queries and permalinks use fixtures; no database is needed or modified. PHP warnings are treated as failures. The coding standards scan covers shipped plugin code; the isolated test harness defines WordPress substitutes and is kept outside that scan.

Passing these checks does not replace a database-backed WordPress integration test or runtime checks across supported PHP versions. Before release, test PHP 8.0 and 8.5 and check shortcode output on a development site. The current code was exercised with PHP 8.4.1.
