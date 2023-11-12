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
            ));

        }
    }
}