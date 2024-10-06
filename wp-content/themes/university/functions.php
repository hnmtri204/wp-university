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

add_action('init', 'university_post_types');


// img
function my_theme_setup()
{
    add_theme_support('post-thumbnails');
}

add_action('after_setup_theme', 'my_theme_setup');
// end img

function add_event_meta_boxes()
{
    add_meta_box(
        'event_details',
        'Chi tiết sự kiện',
        'render_event_meta_box',
        'event', // Giả sử 'event' là post type của bạn
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'add_event_meta_boxes');

// Render nội dung của meta box
function render_event_meta_box($post)
{
    // Lấy giá trị hiện tại (nếu có)
    $event_date = get_post_meta($post->ID, '_event_date', true);

    // Tạo nonce để bảo mật
    wp_nonce_field('event_meta_box', 'event_meta_box_nonce');

    // Hiển thị các trường
?>
    <p>
        <label for="event_date">Ngày sự kiện:</label>
        <input type="date" id="event_date" name="event_date" value="<?php echo esc_attr($event_date); ?>">
    </p>
<?php
}

// Lưu dữ liệu meta khi lưu post
function save_event_meta($post_id)
{
    // Kiểm tra nonce
    if (!isset($_POST['event_meta_box_nonce']) || !wp_verify_nonce($_POST['event_meta_box_nonce'], 'event_meta_box')) {
        return;
    }

    // Kiểm tra quyền của người dùng
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    // Lưu dữ liệu
    if (isset($_POST['event_date'])) {
        update_post_meta($post_id, '_event_date', sanitize_text_field($_POST['event_date']));
    }
    if (isset($_POST['event_location'])) {
        update_post_meta($post_id, '_event_location', sanitize_text_field($_POST['event_location']));
    }
}
add_action('save_post', 'save_event_meta');

function custom_event_columns($columns)
{
    $columns['event_date'] = 'Ngày sự kiện';
    return $columns;
}
add_filter('manage_event_posts_columns', 'custom_event_columns');

function custom_event_column_data($column, $post_id)
{
    switch ($column) {
        case 'event_date':
            echo get_post_meta($post_id, '_event_date', true);
            break;
    }
}
add_action('manage_event_posts_custom_column', 'custom_event_column_data', 10, 2);


function custom_login_logo()
{
    $logo_url = get_theme_mod('custom_login_logo', get_template_directory_uri() . '/images/default-logo.png');
?>
    <style type="text/css">
        #login h1 a {
            background-image: url('<?php echo esc_url($logo_url); ?>');
            background-size: cover;
            width: 100px;
            height: 100px;
            border-radius: 50%;
            overflow: hidden;
        }
    </style>
<?php
}
add_action('login_enqueue_scripts', 'custom_login_logo');


function custom_login_logo_url()
{
    return home_url();
}
add_filter('login_headerurl', 'custom_login_logo_url');

function custom_login_logo_url_title()
{
    return get_bloginfo('name');
}
add_filter('login_headertitle', 'custom_login_logo_url_title');

function custom_theme_customizer($wp_customize)
{
    $wp_customize->add_section('custom_login_logo_section', array(
        'title' => __('Custom Login Logo', 'university'),
        'priority' => 30,
    ));

    $wp_customize->add_setting('custom_login_logo', array(
        'default' => get_template_directory_uri() . '/images/default-logo.png',
        'sanitize_callback' => 'esc_url',
    ));

    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'custom_login_logo', array(
        'label' => __('Upload Logo for Login Page', 'university'),
        'section' => 'custom_login_logo_section',
        'settings' => 'custom_login_logo',
    )));
}
add_action('customize_register', 'custom_theme_customizer');
