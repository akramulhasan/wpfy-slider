<?php 
$slider_button_url = get_post_meta( $post->ID, 'wpfy_slider_link_url', true );
$slider_button_text = get_post_meta( $post->ID, 'wpfy_slider_link_text', true );
?>

<div>
    <input type="hidden" name="wpfy_slider_nonce" value="<?php echo wp_create_nonce( 'wpfy_slider_nonce' ) ?>">
    <label for="wpfy_slider_link_url">Link URL</label>
    <input type="url" name="wpfy_slider_link_url" id="wpfy_slider_link_url" class="regular-text" value="<?php echo (isset($slider_button_url)) ? esc_html($slider_button_url) : "" ?>">
</div>
<div>
    <label for="wpfy_slider_link_text">Link Text</label>
    <input type="text" name="wpfy_slider_link_text" id="wpfy_slider_link_text" class="regular-text" value="<?php echo (isset($slider_button_text)) ? esc_html($slider_button_text) : "" ?>">
</div>
