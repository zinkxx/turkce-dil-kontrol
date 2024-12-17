<?php
/*
Plugin Name: Türkçe Dil Kontrol Eklentisi
Plugin URI: https://github.com/zinkxx
Description: Blog yazılarınızda Türkçe imla ve dilbilgisi hatalarını tespit eder ve düzeltmenize yardımcı olur.
Version: 1.0
Author: zinkxx
Author URI: https://github.com/zinkxx
License: MIT
Text Domain: turkce-dil-kontrol
Domain Path: /languages
*/

// Stil ve script dosyalarını yükleme
function turkce_dilkontrol_assets() {
    wp_enqueue_style('turkce-dilkontrol-style', plugins_url('assets/style.css', __FILE__));
    wp_enqueue_script('turkce-dilkontrol-script', plugins_url('assets/script.js', __FILE__), array('jquery'), false, true);
}
add_action('admin_enqueue_scripts', 'turkce_dilkontrol_assets');

// Metin analiz butonu ekleme
function turkce_dilkontrol_editor_button() {
    echo '<button id="dilkontrol-btn" class="button button-primary">Dil Kontrolü Yap</button>';
}
add_action('edit_form_after_title', 'turkce_dilkontrol_editor_button');

// Dil kontrol mekanizması
function turkce_dilkontrol_process() {
    include_once plugin_dir_path(__FILE__) . 'includes/dilkontrol.php';
    wp_send_json_success('Dil kontrolü tamamlandı.');
}
add_action('wp_ajax_turkce_dilkontrol', 'turkce_dilkontrol_process');

// Dil kontrol işlemi
function turkce_dilkontrol_process() {
    if (!empty($_POST['content'])) {
        $content = sanitize_textarea_field($_POST['content']);
        $result = turkce_dilkontrol_analyze($content);
        wp_send_json_success($result);
    } else {
        wp_send_json_error('İçerik boş olamaz.');
    }
}

// Gutenberg için script ekleme
function turkce_dilkontrol_gutenberg_assets() {
    wp_enqueue_script('turkce-dilkontrol-gutenberg', plugins_url('assets/gutenberg.js', __FILE__), array('wp-plugins', 'wp-edit-post', 'wp-element', 'wp-components', 'wp-data'), false, true);
}
add_action('enqueue_block_editor_assets', 'turkce_dilkontrol_gutenberg_assets');
