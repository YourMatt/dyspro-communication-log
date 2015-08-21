<?php
/*
Plugin Name: Dyspro Communication Log
Plugin URI:
Description: Adds capability to view and manage daily log entries of a given type.
Version: 0.9
Author: Dyspro Media
Author URI: http://dyspromedia.com
*/

// load configuration variables
require_once (dirname (__FILE__) . '/config.php');

// initialize objects
$dcl_plugin_manager = new dcl_plugin_manager ();
$dcl_shortcode_manager = new dcl_shortcode_manager ();
$dcl_activity_manager = new dcl_activity_manager ();

// add installation script
register_activation_hook (__FILE__, array ($dcl_plugin_manager, 'activate'));
register_uninstall_hook (__FILE__, array ($dcl_plugin_manager, 'uninstall'));

// set up shortcodes
add_shortcode ('dcl_communication_log', array ($dcl_shortcode_manager, 'build_communication_log_page'));

// process any user activity
if ($_POST[DCL_MANAGEMENT_NONCE]) {
   $dcl_activity_manager->process_management_forms ();
   $custom_error_message = $dcl_activity_manager->error_message;
   $custom_success_message = $dcl_activity_manager->success_message;
}