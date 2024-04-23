<?php
/**
 * Plugin Name: Hide Content by User Role for WPBakery
 * Description: Hide/show complete rows in WPBakery (formerly Visual Composer) by user roles
 * Version: 1.2.2
 * Author: wpTerra
 * Author URI: https://wpterra.com
 * Text Domain: hide-content-by-role-for-wpbakery
 * Domain Path: /languages
 *
 * License: GPLv2 or later
 */



define('HCBRWPB_DIR_PATH', plugin_dir_path( __FILE__ ));

require_once('include/utils.php');

if (is_admin()) {

    require_once('include/admin.php');

} else {

	require_once('include/frontend.php');

}
