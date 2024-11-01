<?php
/**
 * Plugin Name: Eco-Friendly Robots.txt
 * Plugin URI: https://joost.blog/plugins/eco-friendly-robots-txt/
 * GitHub Plugin URI: Emilia-Capital/eco-friendly-robots-txt
 * Description: Optimizes your site's robots.txt to reduce server load and CO2 footprint by blocking unnecessary crawlers while allowing major search engines and specific tools.
 * Version: 0.5
 * Author: Joost de Valk
 * Author URI: https://joost.blog/
 * License: GPL v2 or later
 *
 * @package Emilia\EcoFriendlyRobotsTxt
 */

if ( ! defined( 'ABSPATH' ) ) {
	die( 'Direct script access disallowed.' );
}

require_once plugin_dir_path( __FILE__ ) . 'src/class-plugin.php';

/**
 * Initialize the plugin.
 *
 * @return void
 */
function ecofriendly_robotstxt_init() {
	$eco_friendly_robots = new Emilia\EcoFriendlyRobotsTxt\Plugin();
	$eco_friendly_robots->init();
}

add_action( 'plugins_loaded', 'ecofriendly_robotstxt_init' );
