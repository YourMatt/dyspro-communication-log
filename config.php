<?php
global $wpdb;

// define paths
define ('DCL_BASE_PATH', dirname (__FILE__));
define ('DCL_BASE_WEB_PATH', plugin_dir_url (__FILE__));

// database tables - will use meta system so all of these can be removed later
define ('DCL_TABLE_LOG', $wpdb->prefix . 'dcl_log');

// additional application constants
define ('DCL_MANAGEMENT_NONCE', 'dcl_manage_nonce');

// load support files
require_once (DCL_BASE_PATH . '/classes/dcl-plugin-manager.php');
require_once (DCL_BASE_PATH . '/classes/dcl-shortcode-manager.php');
require_once (DCL_BASE_PATH . '/classes/dcl-log-manager.php');
require_once (DCL_BASE_PATH . '/classes/dcl-activity-manager.php');