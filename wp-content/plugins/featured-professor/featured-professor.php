<?php

/*
  Plugin Name: Featured Professor Block Type
  Version: 1.0
  Author: Pokar Petr
  Author URI:
  Text Domain: featured-professor
  Domain Path: /languages
*/

if( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

require_once plugin_dir_path( __FILE__ ) . '/inc/generateProfessorHTML.php';
require_once plugin_dir_path( __FILE__ ) . '/inc/relatedPostHTML.php';

class FeaturedProfessor {
  function __construct() {
    add_action('init', [$this, 'onInit']);
    add_action('rest_api_init', [$this, 'prof_HTML']);
    add_filter('the_content', [$this, 'add_related_posts']);
  }

  function onInit() {
    load_plugin_textdomain('featured-professor', false, dirname(plugin_basename( __FILE__ )) . '/languages');
    
    register_meta('post', 'featured_professor', array(
      'show_in_rest' => true,
      'type' => 'number',
      'single' => false
    ));
    wp_register_script('featuredProfessorScript', plugin_dir_url(__FILE__) . 'build/index.js', array('wp-blocks', 'wp-i18n', 'wp-editor'));
    wp_register_style('featuredProfessorStyle', plugin_dir_url(__FILE__) . 'build/index.css');

    register_block_type('ourplugin/featured-professor', array(
      'render_callback' => [$this, 'renderCallback'],
      'editor_script' => 'featuredProfessorScript',
      'editor_style' => 'featuredProfessorStyle'
    ));
    wp_set_script_translations('featuredProfessorScript', 'featured-professor', plugin_dir_path( __FILE__ ) . '/languages');
  }
  // Оторажаем блок в браузере
  function renderCallback($attributes) {
    if ($attributes['prof_id']) {
      wp_enqueue_style("featuredProfessorStyle");
      return generate_professor_HTML($attributes['prof_id']);
    } else {
      return NULL;
    }
  }

  // Отображаем блок в блоке редактирования 
  function prof_HTML() {
    register_rest_route('featured_professor/v1', 'getHTML', array(
      'methods' => WP_REST_SERVER::READABLE,
      'callback' => [$this, 'get_prof_HTML']
    ) );
  }

  function get_prof_HTML($data) {
    return generate_professor_HTML($data['prof_id']);
  }

  function add_related_posts($content) {
    if (is_singular( 'leader' ) && in_the_loop() && is_main_query()) {
      return $content . related_post_HTML(get_the_id());
    }
    return $content;
  }
}

$featuredProfessor = new FeaturedProfessor();