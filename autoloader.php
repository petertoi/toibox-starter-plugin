<?php
/**
 * Filename autoloader.php
 *
 * @package dev
 * @author  Peter Toi <peter@petertoi.com>
 */

namespace Toi\Plugin_Name;

/**
 * An example of a project-specific implementation.
 *
 * After registering this autoload function with SPL, the following line
 * would cause the function to attempt to load the \Foo\Bar\Baz\Qux class
 * from /path/to/project/src/Baz/Qux.php:
 *
 *      new \Foo\Bar\Baz\Qux;
 *
 * @param string $class The fully-qualified class name.
 *
 * @return void
 */

try {

    \spl_autoload_register( function ( $class ) {
        $namespace = __NAMESPACE__;

        $allowed_file_prefixes = [
            'abstract',
            'class',
            'interface',
            'trait',
        ];

        $base_dir = __DIR__ . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR;

        // Check if the class is a member of this package.
        if ( substr( $class, 0, strlen( $namespace ) ) !== $namespace ) {
            // Fail if not a member.
            return false;
        }

        $tokens = array_filter( explode( '\\', substr( $class, strlen( $namespace ) ) ) );

        $tokens = array_map( function ( $token ) {
            $token = strtolower( $token );
            $token = str_replace( '_', '-', $token );

            return $token;
        }, $tokens );

        $file = array_pop( $tokens );

        $path = ( count( $tokens ) )
            ? implode( DIRECTORY_SEPARATOR, $tokens ) . DIRECTORY_SEPARATOR
            : '';

        foreach ( $allowed_file_prefixes as $file_prefix ) {
            $filepath = "${base_dir}${path}${file_prefix}-${file}.php";
            if ( file_exists( $filepath ) ) {
                require_once $filepath;
            }
        }

        return false;
    } );

} catch ( \Exception $e ) {
    wp_die(
        __( 'File not found', '' ),
        __( 'Forecast by WP Perf', '' ),
        $e
    );
}
