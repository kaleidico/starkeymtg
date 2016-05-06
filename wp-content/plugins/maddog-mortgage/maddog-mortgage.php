<?php
/**
 * @package mdm_plugin
 */

/*
Plugin Name: MadDog Mortgage Plugin
Plugin URI: http://kaleidico.com
Description: A plugin to use the Mad Dog Mortgage API to enable a fully online mortgage process
Version: 1.2
Author: Kaleidico (Bill Rice, Robert Baker, John Pezzullo, Hieu Pham, Gerard Donnelly)
Author URI: http://kaleidico.com
License: GPLv2 or later
Text Domain: MadDogMortgage.com
*/

require_once('financial_class.php');
require_once('functions.php');

// create shortcodes
add_shortcode('ldf_products', 'shortcode_ldf_shortcode');
add_shortcode('ldf_products_quote_table', 'shortcode_ldf_table_quote_shortcode');
add_shortcode('create_contact', 'shortcode_create_contact');

// create custom post type
// add_action('init', 'custom_post_type', 0);



 ?>
