<?php

/**
 * This file is used by Joomla to boot up core WordPress functions this shared package uses.
 *
 * @package	com_benchmarkemaillite
 * @license	GNU General Public License version 3; see LICENSE.txt
 *
 */

// No direct access to this file
defined( '_JEXEC' ) or die( 'Restricted access' );

// Define Plugin Path
define( 'BMEL_DIR_PATH', JPATH_ADMINISTRATOR . '/components/com_benchmarkemaillite/' );
define( 'BMEL_DIR_URL', JURI::base() . 'administrator/components/com_benchmarkemaillite/' );

// Stand-Ins For WordPress Core Functions
if( ! function_exists( 'get_option' ) ) {
	function get_option( $arg ) {
		switch( $arg ) {
			case 'benchmark-email-lite_group':
				$benchmarkemaillite_params = JComponentHelper::getParams( 'com_benchmarkemaillite' );
				return array(
					5 => $benchmarkemaillite_params->get( 'timeout' ),
				);
			default:
				return array();
		}
	}
}
if( ! function_exists( 'get_transient' ) ) {
	function get_transient( $arg ) { }
}
if( ! function_exists( 'set_transient' ) ) {
	function set_transient( $arg1, $arg2, $arg3 ) { }
}
if( ! function_exists( 'current_time' ) ) {
	function current_time( $arg1, $arg2=0 ) {
		return time();
	}
}
if( ! function_exists( 'apply_filters' ) ) {
	function apply_filters( $arg1, $arg2 ) {
		return $arg2;
	}
}
if( ! function_exists( '__' ) ) {
	function __( $arg1, $arg2='benchmark-email-lite' ) {
		return JText::_( $arg1 );
	}
}
if( ! function_exists( '_e' ) ) {
	function _e( $arg1, $arg2='benchmark-email-lite' ) {
		echo JText::_( $arg1 );
	}
}
if( ! function_exists( 'wpautop' ) ) {
	function wpautop( $arg1 ) {
		$arg1 = str_replace( "\n\n", '</p><p>', $arg1 );
		return $arg1 ? "<p>{$arg1}</p>" : '';
	}
}
if( ! function_exists( 'sanitize_title' ) ) {
	function sanitize_title( $arg1 ) {
		return JFilterOutput::stringURLSafe( $arg1 );
	}
}
if( ! function_exists( 'esc_attr' ) ) {
	function esc_attr( $arg1 ) {
		return htmlentities( $arg1, ENT_QUOTES );
	}
}
if( ! function_exists( 'wp_get_current_user' ) ) {
	function wp_get_current_user() {
		return ( object ) array( 
			'ID' => 1,
			'user_email' => '',
			'user_firstname' => '',
			'user_lastname' => '',
		);
	}
}
if( ! function_exists( 'is_email' ) ) {
	function is_email( $arg1 ) {
		return JMailHelper::isEmailAddress( $arg1 );
	}
}
if( ! class_exists( 'WP_Widget' ) ) {
	class WP_Widget {
		function __construct( $arg1, $arg2, $arg3, $arg4 ) { }
	}
}

// Include XML-RPC Client
require_once( BMEL_DIR_PATH . 'assets/lib/class-IXR.php' );

// Include Models Used By Joomla! Extensions
require_once( BMEL_DIR_PATH . 'models/class.api.php' );
require_once( BMEL_DIR_PATH . 'models/class.widget.php' );

// Set API Key From Settings
$benchmarkemaillite_params = JComponentHelper::getParams( 'com_benchmarkemaillite' );
benchmarkemaillite_api::$token = $benchmarkemaillite_params->get( 'api_keys' );
