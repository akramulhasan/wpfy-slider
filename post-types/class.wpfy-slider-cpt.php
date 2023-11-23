<?php

if(!class_exists('WPFY_SLIDER_CPT')){
    class WPFY_SLIDER_CPT {
        function __construct(){
            add_action('init', array($this, 'create_slider_post_type'));
            add_action('add_meta_boxes', array($this, 'add_meta_boxes'));
            add_action('save_post', array($this, 'save_post'), 10, 2);
            add_filter( 'manage_wpfy-slider_posts_columns', array($this, 'wpfy_slider_cpt_columns') );
            add_action( 'manage_wpfy-slider_posts_custom_column', array($this, 'wpfy_slider_cpt_custom_column'), 10, 2 );
        }


        //method for creating the column heading
        public function wpfy_slider_cpt_columns( $columns ){
            $columns['wpfy_slider_text'] = esc_html__( 'Link Text', 'wpfy-slider' );
            $columns['wpfy_slider_url'] = esc_html__('Link URL', 'wpfy-slider');

            return $columns;
        }

        //method for creating custom column values
        public function wpfy_slider_cpt_custom_column($column, $post_id){
            switch( $column ){
                case 'wpfy_slider_text':
                    echo esc_html( get_post_meta( $post_id, 'wpfy_slider_link_text', true ));
                    break;

                case 'wpfy_slider_url':
                    echo esc_html( get_post_meta( $post_id, 'wpfy_slider_link_url', true ));
                    break;
            }
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
                'show_in_menu' => false,
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

        } // End create_slider_post_type

        public function add_meta_boxes(){
            add_meta_box( 
                'wpfy_slider_meta_box', 
                'Link Options',
                array($this, 'add_inner_beta_boxes'),
                'wpfy-slider',
                'normal', 
                'high'
               
            );
        }


        public function add_inner_beta_boxes($post){
            require_once(WPFY_SLIDER_PATH . 'views/wpfy-slider-metabox.php');
        }

        public function save_post($post_id){

            // check if the nonce field is there
            if( isset( $_POST['wpfy_slider_nonce'] ) ){

                // verify the nonce field
                if( ! wp_verify_nonce( $_POST['wpfy_slider_nonce'], 'wpfy_slider_nonce' ) ){
                    return;
                }
            }

            if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ){
                return;
            }

            // check if the user on the post screen and have the proper editing rights
            if( isset($_POST['post_type']) && $_POST['post_type'] === 'post' ){
                if( !current_user_can( 'edit_page', $post_id ) ){
                    return;
                }elseif( !current_user_can( 'edit_post', $post_id ) ){
                    return;
                }
            }

            if( isset( $_POST['action'] ) && $_POST['action'] == 'editpost' ){
                $old_link_text = get_post_meta($post_id, 'wpfy_slider_link_text', true);
                $new_link_text = $_POST['wpfy_slider_link_text'];
                $old_link_url = get_post_meta($post_id, 'wpfy_slider_link_url', true);
                $new_link_url = $_POST['wpfy_slider_link_url'];

                if( empty( $new_link_text ) ){

                    update_post_meta( $post_id, 'wpfy_slider_link_text', 'Button Label', $old_link_text );

                } else {

                    update_post_meta( $post_id, 'wpfy_slider_link_text', sanitize_text_field( $new_link_text ), $old_link_text );
                }

                if( empty( $new_link_url ) ){

                    update_post_meta( $post_id, 'wpfy_slider_link_url', '#', $old_link_url );

                }else{

                    update_post_meta( $post_id, 'wpfy_slider_link_url', sanitize_text_field( $new_link_url ), $old_link_url );
                }
                
            }
        }

    }
}