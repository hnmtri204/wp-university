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

// Tùy chỉnh cột trong danh sách quản lý events
function custom_event_columns($columns)
{
    $columns['event_date'] = 'Ngày sự kiện';
    $columns['event_location'] = 'Địa điểm';
    return $columns;
}
add_filter('manage_event_posts_columns', 'custom_event_columns');

// Hiển thị dữ liệu trong các cột tùy chỉnh
function custom_event_column_data($column, $post_id)
{
    switch ($column) {
        case 'event_date':
            echo get_post_meta($post_id, '_event_date', true);
            break;
        case 'event_location':
            echo get_post_meta($post_id, '_event_location', true);
            break;
    }
}
add_action('manage_event_posts_custom_column', 'custom_event_column_data', 10, 2);
