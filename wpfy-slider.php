<?php
/**
 * Plugin Name: WPFY Slider
 * Plugin URI: https://wwww.akramuldev.com/plugins/wpfy-slider
 * Version: 1.0
 * Description: Light weight and nice image slider with contents
 * Requires at least: 5.4
 * Author: Akramul Hasan
 * Author URI: https://www.akramuldev.com
 * Text Domain: wpfy-slider
 * Domain Path: /languages
 */
if(!defined ('ABSPATH')){
    exit;
}

if( !class_exists('WPFY_Slider') ){
    class WPFY_Slider {
        function __construct(){

            $this->define_const();

            require_once(WPFY_SLIDER_PATH.'post-types/class.wpfy-slider-cpt.php');
            $wpfy_slider_post_type = new WPFY_Slider_Post_Type();

            require_once(WPFY_SLIDER_PATH.'class.wpfy-slider-settings.php');
            $wpfy_slider_settings = new WPFY_Slider_Settings();
            
        }

        public static function activate(){
            update_option( 'rewrite_rules', '' );
        }

        public static function deactivate(){
            flush_rewrite_rules();
        }

        // public static function uninstall(){
            
        // }

        public function define_const(){
            define('WPFY_SLIDER_PATH', plugin_dir_path( __FILE__ ));
            define('WPFY_SLIDER_URL', plugin_dir_url( __FILE__ ));
            define('WPFY_SLIDER_VERSION', '1.0');
        }
    }
}
if(class_exists('WPFY_Slider')){
    register_activation_hook( __FILE__, array('WPFY_Slider', 'activate'));
    register_deactivation_hook( __FILE__, array('WPFY_Slider', 'deactivate'));
    register_uninstall_hook( __FILE__, array('WPFY_Slider', 'uninstall'));
    $wpfy_slider = new WPFY_Slider();

    
}
