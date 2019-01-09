<?php
/**
 * Facilitate adding raw JS to the end of a Wordpress rendering
 *
 * @author Vino Rodrigues
 * @package ts-raw-scripts
 * @version 1.2
 * @since WordPress 3.4
*/

if ( ! defined( 'TS_RAW_SCRIPTS' ) ) :
	define( 'TS_RAW_SCRIPTS', '1.1' );

// global $ts_scripts;

class TS_Scripts extends WP_Dependencies {

	public function do_items( $handles = false, $group = false ) {
		echo '<script type="text/javascript">' . PHP_EOL;
		parent::do_items($handles, $group);
		echo '</script>' . PHP_EOL;
	}

	public function do_item( $handle, $group = false ) {
		if ( !parent::do_item($handle) )
			return false;

		$src = $this->registered[$handle]->src;
		if (defined('WP_DEBUG') && WP_DEBUG) {
			$src = '/* ' . $handle . ' */' . PHP_EOL . $src;
			$src = "\t" . str_replace("\n", "\n\t", $src);
		}
		echo $src . PHP_EOL;
	}

}  // class TS_Scripts


function ts_print_scripts() {
	global $ts_scripts;
	if ( ! is_a( $ts_scripts, 'TS_Scripts' ) ) return;
	else return $ts_scripts->do_items(false);
}

function _ts_check_ts_scripts() {
	global $ts_scripts;
	if ( ! is_a( $ts_scripts, 'TS_Scripts' ) ) {
		$ts_scripts = new TS_Scripts();
		add_action( 'wp_footer', 'ts_print_scripts', 72 );
	}
	return $ts_scripts;
}

function ts_register_script( $handle, $src, $deps = array() ) {
	global $ts_scripts;
	_ts_check_ts_scripts();
	$ts_scripts->add( $handle, $src, $deps, false );
}

function ts_deregister_script( $handle ) {
	global $ts_scripts;
	_ts_check_ts_scripts();
	$ts_scripts->remove( $handle );
}

function ts_enqueue_script( $handle, $src = false, $deps = array() ) {
	global $ts_scripts;
	_ts_check_ts_scripts();
	if ( $src ) {
		$_handle = explode('?', $handle);
		$ts_scripts->add( $_handle[0], $src, $deps, false );
	}
	$ts_scripts->enqueue( $handle );
}

function ts_dequeue_script( $handle ) {
	global $ts_scripts;
	_ts_check_ts_scripts();
	$ts_scripts->dequeue( $handle );
}

endif;  // TS_RAW_SCRIPTS
