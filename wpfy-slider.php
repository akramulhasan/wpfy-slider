<?php
/**
 * WPFY Slider
 *
 * @package           wpfyslider
 * @author            wpfy
 * @license           GPL-2.0-or-later
 *
 * @wordpress-plugin
 * Plugin Name:       WPFY Slider
 * Plugin URI:        https://akramulhasan.com/wpfy-slider
 * Description:       Description of the plugin.
 * Version:           1.0.0
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            wpfy
 * Author URI:        https://akramulhasan.com
 * Text Domain:       wpfy-slider
 * License:           GPL v2 or later
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Update URI:        https://akramulhasan.com/my-plugin
 */

if( ! defined( 'ABSPATH' ) ){
    exit;
}

if( ! class_exists( 'WPFY_Slider' ) ){
    class WPFY_Slider {
        function __construct(){
            $this->define_constants();

            add_action('admin_menu', array($this, 'add_menu'));

            //include the CPT Class and instantiate
            require_once(WPFY_SLIDER_PATH . '/post-types/class.wpfy-slider-cpt.php');
            $wpfy_slider_cpt = new WPFY_SLIDER_CPT();
        }

        function define_constants(){
            define( 'WPFY_SLIDER_PATH', plugin_dir_path( __FILE__ ) );
            define( 'WPFY_SLIDER_URL', plugin_dir_url( __FILE__ ) );
            define( 'WPFY_SLIDER_VERSION', '1.0.0' );
        }

        public static function activate(){
            update_option('rewrite_rules', '');
        }
        public static function deactivate(){
            flush_rewrite_rules();
            unregister_post_type( 'wpfy-slider' );
        }
        public static function uninstall(){

        }

        //method for add_menu

        public function add_menu(){
            add_menu_page( 'WPFY Slider Options', 'WPFY Slider Settings', 'manage_options', 'wpfy-slider-options', array($this,'wpfy_slier_settings_page'), 'dashicons-images-alt2', 10 );
        }

        //slider menu callback
        public function wpfy_slier_settings_page(){
            echo 'Show some settings of the slider';
        }
    }
}

if( class_exists( 'WPFY_Slider' ) ){
    register_activation_hook( __FILE__, array( 'WPFY_Slider', 'activate' ) );
    register_deactivation_hook( __FILE__, array( 'WPFY_Slider', 'deactivate' ) );
    register_uninstall_hook( __FILE__, array( 'WPFY_Slider', 'uninstall' ) );
    $wpfy_slider = new WPFY_Slider();
}