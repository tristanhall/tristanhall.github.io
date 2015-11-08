<?php

add_action('wp_enqueue_scripts', function() {
    wp_deregister_script('jquery');
    wp_register_script('jquery', 'https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js', null, '2.1.3', true);
    wp_enqueue_script('jquery');
    wp_register_script('th-2015-app', get_template_directory_uri().'/js/app.js', array('jquery'), '1.0', true);
    wp_enqueue_script('th-2015-app');
    wp_register_style('th-2015-style', get_template_directory_uri().'/css/style.css');
    wp_enqueue_style('th-2015-style');
});

add_filter('body_class', function($classes) {
    global $post;
    if (isset($post->post_name)) {
        $classes[] = $post->post_name;
    }
    return $classes;
});

add_action('after_setup_theme', function() {
    register_nav_menu('header_menu', __('Header Menu', 'th'));
});