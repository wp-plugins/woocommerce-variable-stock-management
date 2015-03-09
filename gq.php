<?php

/**
 * GQ
 *
 * Variable stock managemnet
 *
 * @package   gq
 * @author    vimes1984 <churchill.c.j@gmail.com>
 * @license   GPL-2.0+
 * @link      http://buildawebdoctor.com
 * @copyright 2-7-2015 BAWD
 *
 * @wordpress-plugin
 * Plugin Name: GQ
 * Plugin URI:  http://buildawebdoctor.com
 * Description: import categories for gq
 * Version:     1.0.3
 * Author:      vimes1984
 * Author URI:  http://buildawebdoctor.com
 * Text Domain: gq-locale
 * License:     GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 * Domain Path: /lang
 */
// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}
// If this file is called directly, abort.
if (!defined("WPINC")) {
	die;
}

require_once(plugin_dir_path(__FILE__) . "GQ.php");
require_once(plugin_dir_path(__FILE__) . "includes/class-variable-product-stock-reduction.php");
require_once(plugin_dir_path(__FILE__) . "includes/class-import-categories.php");
// Register hooks that are fired when the plugin is activated, deactivated, and uninstalled, respectively.
register_activation_hook(__FILE__, array("GQ", "activate"));
register_deactivation_hook(__FILE__, array("GQ", "deactivate"));

GQ::get_instance();
Variable_product_stock_reduction::get_instance();
Import_categories::get_instance();
