<?php
if(! class_exists('WPFY_Slider_Post_Type')){

    class WPFY_Slider_Post_Type{
        function __construct(){
            add_action( 'init', array($this, 'create_post_type') );
            add_action( 'add_meta_boxes', array($this, 'add_meta_boxes'));
            add_action( 'save_post', array($this, 'wpfy_slider_link_option_save'));
            add_filter( 'manage_slider_post_type_posts_columns', array($this, 'manage_slider_admin_cols'));
            add_filter('manage_slider_post_type_posts_custom_column', array($this, 'slider_new_column_data'), 10, 2);
            add_filter( 'manage_edit-slider_post_type_sortable_columns', array($this, 'make_sortable_columns'));


            //Admin menu
            add_action('admin_menu',array($this, 'add_menu'));

        }

        //Add Menu Method
        public function add_menu(){
            add_menu_page( 'WPFY Slider Options', 'WPFY Slider', 'manage_options', 'wpfy_slider_admin', array($this, 'wpfy_slider_settings_page'), 'dashicons-images-alt2');

            add_submenu_page( 'wpfy_slider_admin', 'Manage Slides', 'Manage Slides', 'manage_options', 'edit.php?post_type=slider_post_type', null,null );


            add_submenu_page( 'wpfy_slider_admin', 'Add Slide', 'Add Slide', 'manage_options', 'post-new.php?post_type=slider_post_type', null,null );
        }

        //add_menu cb
        public function wpfy_slider_settings_page(){
            require(WPFY_SLIDER_PATH.'views/settings-page.php');
        }
        public function make_sortable_columns($columns){
            $columns['wpfy_slider_link_text'] = 'wpfy_slider_link_text';
            return $columns;
        }
        public function slider_new_column_data($column, $post_id){
            switch($column){
                case 'wpfy_slider_link_text':
                    echo esc_html(get_post_meta( $post_id, 'wpfy_slider_link_text', true ));
                break;
                case 'wpfy_slider_link_url':
                    echo esc_url(get_post_meta( $post_id, 'wpfy_slider_link_url', true ));
                break;
            }
        }

        public function manage_slider_admin_cols ($cols){
            $cols['wpfy_slider_link_text'] = esc_html__('Link Text', 'wpfy_slider');
            $cols['wpfy_slider_link_url'] = esc_html__('Link URL', 'wpfy_slider');
            return $cols;
           
        }

        public function create_post_type(){
             // Register Custom Post Type

            $labels = array(
                'name'                  => _x( 'Slides', 'Post Type General Name', 'wpfy_slider' ),
                'singular_name'         => _x( 'Slide', 'Post Type Singular Name', 'wpfy_slider' ),
                'menu_name'             => __( 'Slider', 'wpfy_slider' ),
                'name_admin_bar'        => __( 'Post Type', 'wpfy_slider' ),
                'archives'              => __( 'Item Archives', 'wpfy_slider' ),
                'attributes'            => __( 'Item Attributes', 'wpfy_slider' ),
                'parent_item_colon'     => __( 'Parent Item:', 'wpfy_slider' ),
                'all_items'             => __( 'All Items', 'wpfy_slider' ),
                'add_new_item'          => __( 'Add New Item', 'wpfy_slider' ),
                'add_new'               => __( 'Add New', 'wpfy_slider' ),
                'new_item'              => __( 'New Item', 'wpfy_slider' ),
                'edit_item'             => __( 'Edit Item', 'wpfy_slider' ),
                'update_item'           => __( 'Update Item', 'wpfy_slider' ),
                'view_item'             => __( 'View Item', 'wpfy_slider' ),
                'view_items'            => __( 'View Items', 'wpfy_slider' ),
                'search_items'          => __( 'Search Item', 'wpfy_slider' ),
                'not_found'             => __( 'Not found', 'wpfy_slider' ),
                'not_found_in_trash'    => __( 'Not found in Trash', 'wpfy_slider' ),
                'featured_image'        => __( 'Featured Image', 'wpfy_slider' ),
                'set_featured_image'    => __( 'Set featured image', 'wpfy_slider' ),
                'remove_featured_image' => __( 'Remove featured image', 'wpfy_slider' ),
                'use_featured_image'    => __( 'Use as featured image', 'wpfy_slider' ),
                'insert_into_item'      => __( 'Insert into item', 'wpfy_slider' ),
                'uploaded_to_this_item' => __( 'Uploaded to this item', 'wpfy_slider' ),
                'items_list'            => __( 'Items list', 'wpfy_slider' ),
                'items_list_navigation' => __( 'Items list navigation', 'wpfy_slider' ),
                'filter_items_list'     => __( 'Filter items list', 'wpfy_slider' ),
            );
            $args = array(
                'label'                 => __( 'Slide', 'wpfy_slider' ),
                'description'           => __( 'Post Type Description', 'wpfy_slider' ),
                'labels'                => $labels,
                'supports'              => array( 'title', 'editor', 'thumbnail' ),
                'taxonomies'            => array( 'category' ),
                'hierarchical'          => false,
                'public'                => true,
                'show_ui'               => true,
                'show_in_menu'          => false,
                'menu_position'         => 5,
                'show_in_admin_bar'     => true,
                'show_in_nav_menus'     => true,
                'can_export'            => true,
                'has_archive'           => true,
                'exclude_from_search'   => false,
                'publicly_queryable'    => true,
                'capability_type'       => 'page',
                'show_in_rest'          => true,
            );
	        register_post_type( 'slider_post_type', $args );

        }


        //Add Metabox
        public function add_meta_boxes(){
            add_meta_box( 'wpfy_slider_meta_box', 'Link Option', array($this, 'wpfy_slider_link_box'), array('slider_post_type'), 'normal', 'high', array('foo'=>'Bar'));
        
        }

        public function wpfy_slider_link_box($post, $args){
            require_once(WPFY_SLIDER_PATH.'views/wpfy-slider-metabox-html.php');
        }

        //Save Meta Data with proper Sanitizations
        public function wpfy_slider_link_option_save($post_id){
            if(isset($_POST['wpfy_slider_nonce'])){
                if(!wp_verify_nonce( $_POST['wpfy_slider_nonce'], 'wpfy_slider_nonce' )){
                    return;
                }
            }

            if(defined('DOING_AUTOSAVE') && DOING_AUTOSAVE){
                return;
            }

            if(isset($_POST['post_type']) && $_POST['post_type']==='slider_post_type'){
                if(!current_user_can( 'edit_page',  $post_id)){
                    return;
                }elseif(!current_user_can( 'edit_post', $post_id )){
                    return;
                }
            }

            if(array_key_exists('wpfy_slider_link_url', $_POST) && array_key_exists('wpfy_slider_link_text', $_POST)){


                if(empty($_POST['wpfy_slider_link_url'])){
                    update_post_meta( $post_id, 'wpfy_slider_link_url', '#');
                }else{
                    update_post_meta( $post_id, 'wpfy_slider_link_url', sanitize_text_field( $_POST['wpfy_slider_link_url'] ));
                }


                if(empty($_POST['wpfy_slider_link_text'])){
                    update_post_meta( $post_id, 'wpfy_slider_link_text', 'Add a button');
                }else{
                    update_post_meta( $post_id, 'wpfy_slider_link_text', sanitize_text_field( $_POST['wpfy_slider_link_text'] ));
                }
                
                
                
            }
        }

    }
}