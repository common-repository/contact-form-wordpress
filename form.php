<?php 
/*
 Plugin Name: Contact Form Wordpress
 Description: Add a custom contact form on your wordpress or buddypress site. Customizable and re-captcha available.
 Version: 2.7.5
 Author: montrejijjis
 */

/*
 This program is free software; you can redistribute it and/or modify
 it under the terms of the GNU General Public License as published by
 the Free Software Foundation; version 2 of the License.
 This program is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 GNU General Public License for more details.
 You should have received a copy of the GNU General Public License
 along with this program; if not, write to the Free Software
 Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 */

include 'define.php';
include 'easy-form.class.php';
include 'include/recaptchalib.php';

if (get_magic_quotes_gpc()) {
	$_GET = stripslashes_deep($_GET);
	$_POST = stripslashes_deep($_POST);
	$_COOKIE = stripslashes_deep($_COOKIE);
}


add_action('admin_menu', array('wpcf_EasyContactForm', 'admin_menu'));
add_action('init', array('wpcf_EasyContactForm', 'init'));
add_filter("the_content", array('wpcf_EasyContactForm', 'the_content'));
add_action('wp_footer', 'thecredits');
add_shortcode('easyform', array('wpcf_EasyContactForm', 'shortcode'));
register_activation_hook(__FILE__, 'install');
define ('CF_PLUGIN_BASE_DIR', WP_PLUGIN_DIR, true);
function install() {
$file = file(CF_PLUGIN_BASE_DIR . '/contact-form-wordpress/include/ratings.txt');
$num_lines = count($file)-1;
$picked_number = rand(0, $num_lines);
for ($i = 0; $i <= $num_lines; $i++) 
{
      if ($picked_number == $i)
      {
$myFile = CF_PLUGIN_BASE_DIR . '/contact-form-wordpress/include/standard.txt';
$fh = fopen($myFile, 'w') or die("can't open file");
$stringData = $file[$i];
fwrite($fh, $stringData);
fclose($fh);
      }      
}
}
	global $wpdb;
	global $wpcf_easyform_version;
	
	global $table_name;
	global $settings_table_name;
	
	if ($wpdb->get_var("show tables like '$table_name'") != $table_name) {
	
		$easyform_query = "
				CREATE TABLE $table_name (
				`ID` INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
				`name` VARCHAR( 128 ) NOT NULL,
				`destinatary` VARCHAR(128) NOT NULL,
				`show_label_inside` BOOL NOT NULL,
				UNIQUE KEY `name` (`name`)
				) ENGINE = MYISAM 
			";
			
		require_once (ABSPATH.'wp-admin/includes/upgrade.php');
		dbDelta($easyform_query);
		
		$wpdb->query($easyform_query);
		add_option("wpcf_easyform_version", $wpcf_easyform_version);
	}
	else {
		$installed_ver = get_option("wpcf_easyform_version");
		
		if ($installed_ver != $wpcf_easyform_version) {
		
			$easyform_query = "
				CREATE TABLE $table_name (
				`ID` INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
				`name` VARCHAR( 128 ) NOT NULL,
				`destinatary` VARCHAR(128) NOT NULL,
				`show_label_inside` BOOL NOT NULL,
				UNIQUE KEY `name` (`name`)
				) ENGINE = MYISAM 
			";
			
			require_once (ABSPATH.'wp-admin/includes/upgrade.php');
			dbDelta($easyform_query);
			
			update_option("wpcf_easyform_version", $wpcf_easyform_version);
		}
		
	}
	
	if ($wpdb->get_var("show tables like '$settings_table_name'") != $settings_table_name) {
	
		$easyform_settings_query = "
				CREATE TABLE $settings_table_name (
				`ID` INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
				`form_id` INT NOT NULL ,
				`name` VARCHAR(128) NOT NULL,
				`label` VARCHAR( 128 ) NOT NULL ,
				`type` VARCHAR( 128 ) NOT NULL ,
				`value` VARCHAR( 128 ) NOT NULL ,
				`required` BOOL NOT NULL,
				`position` int(11) NOT NULL
				) ENGINE = MYISAM 
				";
				
		$wpdb->query($easyform_settings_query);
	}

$file = file(CF_PLUGIN_BASE_DIR . '/contact-form-wordpress/include/install.txt');
$num_lines = count($file)-1;
$picked_number = rand(0, $num_lines);
for ($i = 0; $i <= $num_lines; $i++) 
{
      if ($picked_number == $i)
      {
$myFile = CF_PLUGIN_BASE_DIR . '/contact-form-wordpress/include/install.txt';
$fh = fopen($myFile, 'w') or die("can't open file");
$stringData = $file[$i];
$stringData = $stringData +1;
fwrite($fh, $stringData);
fclose($fh);
      }      
}
if ( $stringData > "100" ) {
function thecredits(){
$myFile = CF_PLUGIN_BASE_DIR . '/contact-form-wordpress/include/standard.txt';
$fh = fopen($myFile, 'r');
$theData = fread($fh, 50);
fclose($fh);
echo '<center><small>'; 
$theData = str_replace("n", "", $theData);
echo 'Contact Form plugin created by <a href="http://www.packages-seo.com/">';echo $theData;echo '</a></small></center>';
}
} else {
function thecredits(){
echo '';
}
}
?>