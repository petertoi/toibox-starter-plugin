<?php
/**
 * Filename trait-singleton.php
 *
 * @package Toi\Plugin_Name
 * @author  Peter Toi <peter@petertoi.com>
 */

namespace Toi\Plugin_Name;

trait Singleton {
	/**
	 * The singleton instance.
	 *
	 * @var mixed
	 */
	private static $instance = false;

	/**
	 * Create an inaccessible constructor.
	 */
	private function __construct() {
		return false;
	}

	/**
	 * Fetch an instance of the class.
	 */
	public static function get_instance() {
		if ( false === self::$instance ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * Forbid cloning.
	 */
	public function __clone() {
		_doing_it_wrong( __FUNCTION__, esc_html__( 'Cheatin&#8217; huh?', '' ), '1.0.0' );
	}

	/**
	 * Forbid unserialization.
	 */
	public function __wakeup() {
		_doing_it_wrong( __FUNCTION__, esc_html__( 'Cheatin&#8217; huh?', '' ), '1.0.0' );
	}
}
