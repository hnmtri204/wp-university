<?php
function them_style()
{
    // var_dump(get_theme_file_uri('css/global.css'));
    wp_enqueue_style('boostrap', "https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css");
    wp_enqueue_style('boostrap', "https://fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i|Roboto:100,300,400,400i,700,700i");
    wp_enqueue_style('index-university', get_theme_file_uri('build/index.css'));
    wp_enqueue_style('index-university-extra', get_theme_file_uri('build/style-index.css'));
    wp_enqueue_style('css', get_theme_file_uri('style.css'));
    wp_enqueue_script('bundles-script', get_theme_file_uri('build/index.js'), array('jquery'), '2.2', true);
    wp_enqueue_script('menu', get_theme_file_uri('menu.js'), array('jquery'), '2.2', true);
}
add_action('wp_enqueue_scripts', 'them_style');


if (!function_exists('mytheme_register_nav_menu')) {
    function mytheme_register_nav_menu()
    {
        register_nav_menus(array(
            'primary_menu' => __('Menu chinh', 'university'),
            'footer_menu_1' => __('Menu footer 1', 'university'),
            'footer_menu_2' => __('Menu footer 2', 'university'),
            // 'footer_menu' => __('Footer Menu', 'text_domain'),
        ));
    }
    add_action('after_setup_theme', 'mytheme_register_nav_menu', 0);
}

function university_post_types()
{
    register_post_type('event', array(
        'has_archive' => true,
        'public' => true,
        'labels' => array(
            'name' => 'Events',
            'add_new_item' => 'Add new Event',
            'edit_item' => 'Edit Event',
            'all_items' => 'All Events',
            'singular_name ' => 'Event',
        ),
        'menu_icon' => 'dashicons-calendar'
    ));
}

add_action('init', 'university_post_types');


// img
function my_theme_setup()
{
	add_theme_support('post-thumbnails');
}

add_action('after_setup_theme', 'my_theme_setup');
// end img