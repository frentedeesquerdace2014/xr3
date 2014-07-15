<?php

$functions_path = get_template_directory() . '/functions/';
include_once ($functions_path . 'inkthemes-functions.php');
/* These files build out the options interface.  Likely won't need to edit these. */
require_once ($functions_path . 'admin-functions.php');  // Custom functions and plugins
require_once ($functions_path . 'admin-interface.php');  // Admin Interfaces 
require_once ($functions_path . 'theme-options.php');   // Options panel settings and custom settings
require_once ($functions_path . 'define_template.php');

/* ----------------------------------------------------------------------------------- */
/* jQuery Enqueue */
/* ----------------------------------------------------------------------------------- */

function onepage_wp_enqueue_scripts() {
    if (!is_admin()) {
        wp_enqueue_script('onepage-superfish', get_template_directory_uri() . '/js/superfish.js', array('jquery'));
        wp_enqueue_script('onepage-hoverint', get_template_directory_uri() . '/js/hoverIntent.js', array('jquery'));
        wp_enqueue_script('onepage-modernizr', get_template_directory_uri() . '/js/modernizr.custom.08171.js', array('jquery'));
        wp_enqueue_script('onepage-smint', get_template_directory_uri() . '/js/jquery.smint.js', array('jquery'));
        wp_enqueue_script('onepage-custom', get_template_directory_uri() . '/js/custom.js', array('jquery'));
        wp_enqueue_script('mobile-menu', get_template_directory_uri() . "/js/mobile-menu.js", array('jquery'), '', true);
        if (is_singular() and get_site_option('thread_comments')) {
            wp_print_scripts('comment-reply');
        }
    }
}

add_action('wp_enqueue_scripts', 'onepage_wp_enqueue_scripts');

/**
 * Theme option get values
 */
function onepage_get_option($name) {
    $options = get_option('onepage_options');
    if (isset($options[$name]))
        return $options[$name];
}

/**
 * Theme option update values
 */
function onepage_update_option($name, $value) {
    $options = get_option('onepage_options');
    $options[$name] = $value;
    return update_option('onepage_options', $options);
}

/**
 * Theme option delete values
 */
function onepage_delete_option($name) {
    $options = get_option('onepage_options');
    unset($options[$name]);
    return update_option('onepage_options', $options);
}