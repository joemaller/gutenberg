<?php
/**
 * Load API functions, register scripts and actions, etc.
 *
 * @package gutenberg
 */

if ( ! defined( 'ABSPATH' ) ) {
	die( 'Silence is golden.' );
}

// These files only need to be loaded if within a rest server instance
// which this class will exist if that is the case.
if ( class_exists( 'WP_REST_Controller' ) ) {
	require dirname( __FILE__ ) . '/class-wp-rest-blocks-controller.php';
	require dirname( __FILE__ ) . '/class-wp-rest-autosaves-controller.php';
	require dirname( __FILE__ ) . '/class-wp-rest-block-renderer-controller.php';
	require dirname( __FILE__ ) . '/class-wp-rest-search-controller.php';
	require dirname( __FILE__ ) . '/class-wp-rest-search-handler.php';
	require dirname( __FILE__ ) . '/class-wp-rest-post-search-handler.php';
	require dirname( __FILE__ ) . '/rest-api.php';
}

require dirname( __FILE__ ) . '/meta-box-partial-page.php';
require dirname( __FILE__ ) . '/class-wp-block-type.php';
require dirname( __FILE__ ) . '/class-wp-block-type-registry.php';
require dirname( __FILE__ ) . '/blocks.php';
require dirname( __FILE__ ) . '/client-assets.php';
require dirname( __FILE__ ) . '/compat.php';
require dirname( __FILE__ ) . '/plugin-compat.php';
require dirname( __FILE__ ) . '/i18n.php';
require dirname( __FILE__ ) . '/register.php';


// Register server-side code for individual blocks.
$paths = array(
	dirname( __FILE__ ) . '/../block-library/*/index.php',
	dirname( __FILE__ ) . '/../packages/block-library/src/*/index.php',
);

foreach ( $paths as $path ) {
	$block_logic_files = glob( $path );
	// glob() can sometimes return false if there's an error, or it couldn't find any files.
	if ( ! $block_logic_files ) {
		continue;
	}

	foreach ( $block_logic_files as $block_logic ) {
		require $block_logic;
	}
}
