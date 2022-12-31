<?php
if(!class_exists('WPFY_Slider_Settings')){

    class WPFY_Slider_Settings{
        public static $options;

        public function __construct(){
            self::$options = get_option( 'wpfy_slider_options' );
            add_action('admin_init', array($this, 'admin_init'));
        }

        public function admin_init(){
            register_setting( 'wpfy_slider_settings_group', 'wpfy_slider_options');

            add_settings_section( 'wpfy_slider_main_section', 'How does it work?', null, 'wpfy_slider_page1');
            add_settings_field( 'wpfy_slider_shortcode', 'Shortcode', array($this, 'wpfy_slider_shortcode_cb'), 'wpfy_slider_page1', 'wpfy_slider_main_section');

            //Second Section second field
            add_settings_section( 'wpfy_slider_second_section', 'Other Settings', null, 'wpfy_slider_page2');
            add_settings_field( 'wpfy_slider_title', 'Slider Title', array($this, 'wpfy_slider_title_cb'), 'wpfy_slider_page2', 'wpfy_slider_second_section');

            //Second Section Third Field
            add_settings_field( 'wpfy_slider_bullets', 'Display Bullets', array($this, 'wpfy_slider_bullet_cb'), 'wpfy_slider_page2', 'wpfy_slider_second_section');

            //Second Section Fourth Field
            add_settings_field( 
                'wpfy_slider_style', 
                'Slider Style', 
                array($this, 'wpfy_slider_style_cb'), 
                'wpfy_slider_page2', 
                'wpfy_slider_second_section', 
                array(
                    'items'=>array(
                        'style-1',
                        'style-2'
                    )
                )
            );
        }

        public function wpfy_slider_style_cb($args){

            
            ?>
                <select id="wpfy_slider_style" name="wpfy_slider_options[wpfy_slider_style]">
                    <?php foreach($args['items'] as $item) : ?>
                        <option value="<?php echo esc_attr($item); ?>" <?php echo isset(self::$options['wpfy_slider_style']) ? selected($item, self::$options['wpfy_slider_style']) : '' ?> ><?php echo esc_html($item); ?></option>
                    <?php endforeach; ?>
                   
  
                </select>
            <?php
        }

        public function wpfy_slider_bullet_cb(){
            ?>
                <input 
                type="checkbox" 
                name="wpfy_slider_options[wpfy_slider_bullets]" 
                id="wpfy_slider_bullets" 
                value="1"
                <?php if(isset(self::$options['wpfy_slider_bullets'])){
                    checked('1', self::$options['wpfy_slider_bullets'], true);
                } ?>
                
                >
            <?php
        }
        public function wpfy_slider_title_cb(){
            ?>
                <input 
                type="text" 
                name="wpfy_slider_options[wpfy_slider_title]" 
                id="wpfy_slider_title" 
                value="<?php echo isset(self::$options['wpfy_slider_title']) ? self::$options['wpfy_slider_title'] : '' ?>">
            <?php
        }

        public function wpfy_slider_shortcode_cb(){
            ?>
            <span>Use the shortcode [wpfy_slider] to display the slider to any page/post/widget</span>
            <?php
        }

    }
}