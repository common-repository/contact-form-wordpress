<?php 
global $wpdb;
global $table_name;
global $settings_table_name;
global $wpcf_easyform_version;

define('EASYFORM_PLUGIN_PATH', WP_PLUGIN_URL.'/contact-form-wordpress/');
define('EASYFORM_PLUGIN_NAME','Contact Form Wordpress');

$wpcf_easyform_version = '2.7.5';
$table_name = $wpdb->prefix."easyform";
$settings_table_name = $wpdb->prefix."easyform_settings";

?>
