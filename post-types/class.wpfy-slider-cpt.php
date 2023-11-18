<?php

if(!class_exists('WPFY_SLIDER_CPT')){
    class WPFY_SLIDER_CPT {
        function __construct(){
            add_action('init', array($this, 'create_slider_post_type'));
        }

        public function create_slider_post_type(){
            register_post_type( 'wpfy-slider', array(
                'label' => 'Slider',
                'description' => 'Sliders',
                'labels' => array(
                    'name' => 'Sliders',
                    'singular_name' => 'Slider'
                ),
                'public' => true,
                'supports' => array('title', 'editor', 'thumbnail'),
                'hierarchical' => false,
                'show_ui' => true,
                'show_in_menu' => true,
                'menu_position'=> 5,
                'show_in_admin_bar' => true,
                'show_in_nav_menus' => true,
                'can_export' => true,
                'has_archive' => false,
                'exclude_from_search' => false,
                'publicly_queryable' => true,
                'show_in_rest' => true,
                'menu_icon' => 'dashicons-images-alt2'
            ));

        }
    }
}