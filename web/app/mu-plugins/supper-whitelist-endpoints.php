<?php

/**
 * Plugin Name: Supper API Whitelist
 * Description: Whitelist for supper api endpoints
 * Version: v1.0.0
 * Author: Jim van Eijk
 *
 * Text Domain: whitelist for supper api endpoints
 * 
 * @package .
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/*----------------------------------------------------------------------------*/
/**
 * JWT whitelist
 */

add_filter('jwt_auth_whitelist', function ($whitelist) {
    $whitelist[] = '/wp-json/*';
    $whitelist[] = '/wp-json/wc-analytics/*';
    $whitelist[] = '/wp-json/wholesale/v1/*';
    $whitelist[] = '/wp-json/jetpack/*';
    
    return $whitelist;
}, 10,2);
