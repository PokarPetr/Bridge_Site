<?php
/*
    Plugin Name: Woo-Cart-Field-Plugin
    Description: Choses behavior of a cart field.
    Version: 1.0
    Author: Petr Pokar
    Author URI: https://github.com/PokarPetr/Application-Data-Analysis
    
*/
if ( ! defined( 'ABSPATH')) exit; //Exit if accessed directly

class PokarWooCustomPlugin {
    function __construct() {
        add_action('woocommerce_product_options_general_product_data', array($this, 'pokar_woo_cart'));
        add_action('woocommerce_process_product_meta', array($this, 'pokar_save_custom_fields' ));
        add_filter('woocommerce_product_single_add_to_cart_text', array($this, 'pokar_add_to_cart_text'));        
        add_filter('woocommerce_add_to_cart_validation', array($this, 'pokar_add_to_cart_validation'), 10, 3);
    }
    // Добавление полей в Product WooCommerce
    function pokar_woo_cart()  {
        woocommerce_wp_text_input(array(
            'id' => 'custom_add_to_cart_text',
            'label' => 'Custom text for "Add to Cart"',
            'placeholder' => 'Add your custom text to "Add To Card"',
        ));
        
        woocommerce_wp_text_input(array(
            'id' => 'custom_add_to_cart_link',
            'label' => 'Custom link "Add to Cart"',
            'placeholder' => 'Add your custom link to "Add To Card"',
        ));
    }

    // Сохранение пользовательских полей
    function pokar_save_custom_fields($post_id) {
        $custom_add_to_cart_text = $_POST['custom_add_to_cart_text'];
        $custom_add_to_cart_link = $_POST['custom_add_to_cart_link'];
    
        update_post_meta($post_id, 'custom_add_to_cart_text', esc_attr($custom_add_to_cart_text));
        update_post_meta($post_id, 'custom_add_to_cart_link', esc_url($custom_add_to_cart_link));
    }
    // Замена текста на кнопке "Добавить в корзину"
    function pokar_add_to_cart_text($text) {
        global $product;
        $custom_text = esc_html(get_post_meta($product->get_id(), 'custom_add_to_cart_text', true));        
        return empty($custom_text) ? $text : $custom_text;
    } 
    
    // Проверка на добавление в корзину и перенаправление
    function pokar_add_to_cart_validation($passed, $product_id, $quantity) {
        $product = wc_get_product($product_id);
        $text = $product->add_to_cart_text();
        // Получаем основную часть URL
        $base_url = home_url();
        
        if ( empty(esc_html( get_post_meta( $product_id, 'custom_add_to_cart_text', true ) ))) {
            $passed = true;
            // Создаем полную URL для перенаправления
            $redirect_url = esc_url($base_url . '/cart/');

            // Перенаправляем пользователя
            wp_safe_redirect($redirect_url);
            
        } else {
            $passed = false;

            // Получаем слаг из метаполя 'custom_add_to_cart_link'
            $slug = get_post_meta($product_id, 'custom_add_to_cart_link', true);            

            // Создаем полную URL для перенаправления
            $redirect_url = esc_url($base_url . $slug);

            // Перенаправляем пользователя
            wp_safe_redirect($redirect_url);
            exit;
    }

    return $passed;
}

    
}

$pokar_woo_custom_plugin = new PokarWooCustomPlugin();

