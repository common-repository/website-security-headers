<?php
/**
 * Headers
 *
 * @package DAVEDOESTHINGS\WSH
 */

namespace DAVEDOESTHINGS\WSH\Headers;

use const DAVEDOESTHINGS\WSH\DATA_PREFIX;

/**
 * Setup.
 *
 * @return void
 */
function setup() : void {
	add_filter( 'wp_headers', __NAMESPACE__ . '\\maybe_generate_security_headers' );
}

/**
 * Maybe generate the security headers.
 *
 * @param array $headers Array of server HTTP response headers.
 *
 * @return array
 */
function maybe_generate_security_headers( $headers ) : array {

	if ( is_admin() ) {
		return $headers;
	}

	$enable = get_option( DATA_PREFIX . '_global_enable' );

	if ( ! $enable ) {
		return $headers;
	}

	$header_settings = get_option( DATA_PREFIX . '_header_settings' );

	if ( ! $header_settings ) {
		return $headers;
	}

	$header_whitelist = [
		'sts'  => 'Strict-Transport-Security',
		'csp'  => 'Content-Security-Policy',
		'xfo'  => 'X-Frame-Options',
		'xcto' => 'X-Content-Type-Options',
		'rp'   => 'Referrer-Policy',
		'pp'   => 'Permissions-Policy',
	];

	foreach ( $header_whitelist as $k => $h ) {

		$enable_key = DATA_PREFIX . '_' . $k . '_enable';
		$val_key    = DATA_PREFIX . '_' . $k . '_value';

		if ( ! empty( $header_settings[ $enable_key ] ) && ! empty( $header_settings[ $val_key ] ) ) {
			// Sanitizing again in case the values change in the DB
			// between save and output, just to be safe.
			$headers[ $h ] = sanitize_text_field( wp_unslash( $header_settings[ $val_key ] ) );
		}
	}

	return $headers;
}
