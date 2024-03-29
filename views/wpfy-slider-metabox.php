<?php 

    $link_text = get_post_meta( $post->ID, 'wpfy_slider_link_text', true );
    $link_url = get_post_meta($post->ID, 'wpfy_slider_link_url', true);

?>

<table class="form-table mv-slider-metabox">
    <input type="hidden" name="wpfy_slider_nonce" value="<?php echo wp_create_nonce( 'wpfy_slider_nonce' ); ?>">
    <tr>
        <th>
            <label for="wpfy_slider_link_text">Link Text</label>
        </th>
        <td>
            <input 
                type="text" 
                name="wpfy_slider_link_text" 
                id="wpfy_slider_link_text" 
                class="regular-text link-text"
                value="<?php echo (isset( $link_text )) ? esc_html($link_text) : ''; ?>"
                required
            >
        </td>
    </tr>
    <tr>
        <th>
            <label for="wpfy_slider_link_url">Link URL</label>
        </th>
        <td>
            <input 
                type="url" 
                name="wpfy_slider_link_url" 
                id="wpfy_slider_link_url" 
                class="regular-text link-url"
                value="<?php echo (isset( $link_url )) ? esc_url($link_url) : ''; ?>"
                required
            >
        </td>
    </tr>               
</table>

