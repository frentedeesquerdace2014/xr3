<?php
/**
 * Plugin Name: Very Simple Contact Form
 * Description: This is a very simple contact form. Use shortcode [contact] to display form on page. For more info please check readme file.
 * Version: 1.8
 * Author: Guido van der Leest
 * Author URI: http://www.guidovanderleest.nl
 * License: GNU General Public License v3 or later
 * License URI: http://www.gnu.org/licenses/gpl-3.0.html
 * Text Domain: verysimple
 * Domain Path: translation
 */


// Load the plugin's text domain
function vscf_init() { 
	load_plugin_textdomain( 'verysimple', false, dirname( plugin_basename( __FILE__ ) ) . '/translation' );
}
add_action('plugins_loaded', 'vscf_init');
 

// Enqueues plugin scripts
function vscf_scripts() {	
	if(!is_admin())
	{
		wp_enqueue_style('vscf_style', plugins_url('vscf_style.css',__FILE__));
	}
}
add_action('wp_enqueue_scripts', 'vscf_scripts');


// function to get the IP address of the user
function vscf_get_the_ip() {
	if (isset($_SERVER["HTTP_X_FORWARDED_FOR"])) {
		return $_SERVER["HTTP_X_FORWARDED_FOR"];
	}
	elseif (isset($_SERVER["HTTP_CLIENT_IP"])) {
		return $_SERVER["HTTP_CLIENT_IP"];
	}
	else {
		return $_SERVER["REMOTE_ADDR"];
	}
}


// function to check inputfield
function vscf_clean_input($str){
	$str1 = preg_replace("/(\s){2,}/",'$1',$str);
	$allowed = "/[^a-z0-9\\040\\.\\-\\,]/i";
	$str1 = preg_replace($allowed,"",$str1);
	return $str1;
}

include 'vscf_main.php';

?>