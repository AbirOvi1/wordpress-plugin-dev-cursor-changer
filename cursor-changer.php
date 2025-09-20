<?php
/*
Plugin Name: Cursor Changer
Plugin URI:  https://github.com/AbirOvi1/Wordpress-Plugin-Dev-Cursor-Changer
Description: Change WordPress admin cursor with customizable color or image.
Version:     2.0
Author:      Abir Ovi
Author URI:  https://github.com/AbirOvi1
License:     GPL2
*/

if (!defined('ABSPATH')) exit; // Exit if accessed directly

// Add menu page
function cc_add_admin_menu() {
    add_menu_page(
        'Cursor Changer',
        'Cursor Changer',
        'manage_options',
        'cursor-changer',
        'cc_settings_page',
        'dashicons-admin-customizer',
        100
    );
}
add_action('admin_menu', 'cc_add_admin_menu');

// Register settings
function cc_register_settings() {
    register_setting('cc_settings_group', 'cc_cursor_color');
    register_setting('cc_settings_group', 'cc_cursor_image');
}
add_action('admin_init', 'cc_register_settings');

// Render settings page
function cc_settings_page() {
    $cursor_color = esc_attr(get_option('cc_cursor_color', '#0000ff')); // default blue
    $cursor_image = esc_attr(get_option('cc_cursor_image', ''));
    ?>
    <div class="wrap">
        <h1>Cursor Changer Settings</h1>
        <form method="post" action="options.php">
            <?php
                settings_fields('cc_settings_group');
                do_settings_sections('cc_settings_group');
            ?>
            <table class="form-table">
                <tr valign="top">
                    <th scope="row">Cursor Color</th>
                    <td>
                        <input type="color" name="cc_cursor_color" value="<?php echo $cursor_color; ?>">
                        <p class="description">Pick a color for the cursor if you don't use an image.</p>
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row">Cursor Image URL</th>
                    <td>
                        <input type="text" name="cc_cursor_image" value="<?php echo $cursor_image; ?>" size="50" placeholder="Optional: Enter cursor image URL">
                        <p class="description">Leave empty to use color cursor. Supports PNG, CUR, ICO.</p>
                    </td>
                </tr>
            </table>
            <?php submit_button(); ?>
        </form>
    </div>
    <?php
}

// Enqueue JS in admin
function cc_enqueue_admin_script($hook) {
    wp_enqueue_script(
        'cursor-changer-js',
        plugin_dir_url(__FILE__) . 'cursor-changer.js',
        array('jquery'),
        '2.0',
        true
    );
    // Pass options to JS
    wp_localize_script('cursor-changer-js', 'ccData', array(
        'cursorColor' => get_option('cc_cursor_color', '#0000ff'),
        'cursorImage' => get_option('cc_cursor_image', '')
    ));
}
add_action('admin_enqueue_scripts', 'cc_enqueue_admin_script');
