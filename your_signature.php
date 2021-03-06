<?php

/*
Plugin Name: Your Signature
Plugin URI: http://URI_Of_Page_Describing_Plugin_and_Updates
Description: Personalize your Youtube insertion
Version: 1.0
Author: Alexis
Text Domain: ys_trad_
License: A "Slug" license name e.g. GPL2
*/
defined( 'ABSPATH' ) or die ( 'Access Prohibited' );

/*function trad_plugin() {
    trad_plugin( 'ys_trad_', false, plugin_basename( dirname( __FILE__ ) ) . '/languages' );
}*/

// Load text domain
load_plugin_textdomain( 'ys_trad', false, plugin_basename(dirname(__FILE__)).'/languages' );

// Plugin and user settings
if ( is_admin() ) {
    require_once( dirname(__FILE__) . '/ys_settings.php' ); // Plugin settings
}

// Tab constructor
require_once( dirname(__FILE__) . '/ys_display.php' );


/*
*default setting options
*/
function ys_display_settings() {

    $current_displayed_style = array(
        'profile_current_background'	=> '#ffffff',
        'profile_current_border'		=> '#cccccc',
        'profile_current_color'			=> '#888888',
    );



    $current_displayed_style = array_merge( $current_displayed_style);

    $display_settings = wp_parse_args( get_option( 'ys_settings_display' ), $current_displayed_style );

    return $display_settings;
}


/**
 * call Your Signature into page content
 */
function ys_add_personal_profile( $content ) {
    if ( is_main_query() ) {
        global $authordata;
        global $post;

        // Use helper functions to get plugin settings
        $ys_settings_display =ys_display_settings();

        if ( is_singular() ) {
            if ( !get_user_meta( $authordata->ID, 'ys_user_hide', false ) && !get_post_meta( $post->ID, 'ys_hide', false ) ) {

                // Show Your Signature in posts
                if ( is_singular( 'post' ) ) {

                    $show_in_posts = $ys_settings_display['show_in_posts'];
                   if ( $show_in_posts ) {
                        $content .= ys_display_profile($authordata->ID );
                    }

               }

            }
        }
    }

    return $content;
}
add_filter( 'the_content', 'ys_add_personal_profile', 15 );


/**
 * Enqueue styles
 */

function ys_styles_scripts(){
    $css_url = plugins_url( "css/ys-suppr-default.css", __FILE__ );
    wp_register_style( 'ys-suppr-default', $css_url,'');
    wp_enqueue_style( 'ys-suppr-default');

    $css_url = plugins_url( "css/ys-style.css", __FILE__ );
    wp_register_style( 'ys-style', $css_url,'');
    wp_enqueue_style( 'ys-style');
}
add_action('wp_enqueue_scripts','ys_styles_scripts');


function ys_insert_color_settings()
{
    $options = ys_display_settings();
        ?>

        <style>
            .ys-str-display {
                background-color: <?php echo $options['profile_current_background']; ?>;
                border: 2px solid <?php echo $options['profile_current_border']; ?>;
                color: <?php echo $options['profile_current_color']; ?>;
            }
        </style>
        <?php


}
    add_action('wp_head', 'ys_insert_color_settings');
