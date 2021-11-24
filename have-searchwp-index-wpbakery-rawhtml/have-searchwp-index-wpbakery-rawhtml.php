<?php
/*
Plugin Name: Have searchwp index wpbakery rawhtml
Plugin URI: https://wordpresscoder.nl
Description: When you discover that content in rawhtml blocks is not found on your site, switch on this plugin.
Version: 1.0.0
Author: Ruige hond
Author URI: https://ruigehond.nl
License: GPLv3
Text Domain: have-searchwp-index-wpbakery-rawhtml
Domain Path: /languages/
*/
defined( 'ABSPATH' ) or die();

// This is plugin nr. 12 by Ruige hond. It identifies as: ruigehond012.
Define('RUIGEHOND012_VERSION', '1.0.0');

// Startup the plugin
add_action('init', function() {
    // Decode wpbakery base64 encoded rawhtml blocks before indexing in SearchWP (4.0+).
    add_filter( 'searchwp\source\post\attributes\content', function( $content, $args ) {
        while (false !== strpos($content, '[/vc_raw_html]')) {
            $start = strpos($content, '[vc_raw_html');
            if (false === $start) return $content;
            $stop = strpos($content, ']', $start) + 1;
            if (false === $stop) return $content;
            $end = strpos($content, '[/vc_raw_html]', $stop);
            if (false === $end) return $content;
            $chunk = substr($content, $start, $end - $start) . '[/vc_raw_html]';
            $encoded = substr($content, $stop, $end - $stop);
            $decoded = rawurldecode(base64_decode($encoded));
            $content = str_replace($chunk, $decoded, $content);
        }
        return $content;
    }, 20, 2 );
});


