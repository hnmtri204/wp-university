<?php
function university_post_types()
{
    // Đăng ký custom post type cho sự kiện
    register_post_type('event', array(
        'labels' => array(
            'name' => 'Events',
            'singular_name' => 'Event',
            'add_new_item' => 'Add New Event',
            'edit_item' => 'Edit Event',
            'all_items' => 'All Events',
            'view_item' => 'View Event',
            'not_found' => 'No events found',
            'not_found_in_trash' => 'No events found in Trash'
        ),
        'public' => true,
        'has_archive' => true,
        'rewrite' => array('slug' => 'events'),
        'supports' => array('title', 'editor', 'thumbnail', 'excerpt'),
        'menu_icon' => 'dashicons-calendar-alt',
    ));

    // Đăng ký custom post type cho chương trình
    register_post_type('program', array(
        'labels' => array(
            'name' => 'Programs',
            'singular_name' => 'Program',
            'add_new_item' => 'Add New Program',
            'edit_item' => 'Edit Program',
            'all_items' => 'All Programs',
            'view_item' => 'View Program',
            'not_found' => 'No programs found',
            'not_found_in_trash' => 'No programs found in Trash'
        ),
        'public' => true,
        'has_archive' => true,
        'rewrite' => array('slug' => 'programs'),
        'supports' => array('title', 'editor', 'thumbnail', 'excerpt'),
        'menu_icon' => 'dashicons-format-aside',
    ));
}

add_action('init', 'university_post_types');

function add_program_meta_boxes()
{
    add_meta_box(
        'program_details',
        'Chi tiết chương trình',
        'render_program_meta_box',
        'program',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'add_program_meta_boxes');

function create_program_post_type()
{
    register_post_type(
        'program',
        array(
            'labels' => array(
                'name' => __('Chương Trình'),
                'singular_name' => __('Chương Trình'),
            ),
            'public' => true,
            'has_archive' => true,
            'supports' => array('title', 'editor', 'custom-fields'),
        )
    );
}
add_action('init', 'create_program_post_type');


function render_program_meta_box($post)
{
    $program_date = get_post_meta($post->ID, 'program_date', true);
    $program_location = get_post_meta($post->ID, 'program_location', true);

    wp_nonce_field('program_meta_box', 'program_meta_box_nonce');
?>
    <p>
        <label for="program_date">Ngày chương trình:</label>
        <input type="date" id="program_date" name="program_date" value="<?php echo esc_attr($program_date); ?>">
    </p>
    <p>
        <label for="program_location">Địa điểm:</label>
        <input type="text" id="program_location" name="program_location" value="<?php echo esc_attr($program_location); ?>">
    </p>
<?php
}

function save_program_meta($post_id)
{
    if (!isset($_POST['program_meta_box_nonce']) || !wp_verify_nonce($_POST['program_meta_box_nonce'], 'program_meta_box')) {
        return;
    }

    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    if (isset($_POST['program_date'])) {
        update_post_meta($post_id, 'program_date', sanitize_text_field($_POST['program_date']));
    }
    if (isset($_POST['program_location'])) {
        update_post_meta($post_id, 'program_location', sanitize_text_field($_POST['program_location']));
    }
}
add_action('save_post', 'save_program_meta');


// Thêm taxonomy cho sự kiện
function university_event_taxonomy()
{
    register_taxonomy('event_category', 'event', array(
        'labels' => array(
            'name' => 'Event Categories',
            'singular_name' => 'Event Category',
            'search_items' => 'Search Event Categories',
            'all_items' => 'All Event Categories',
            'edit_item' => 'Edit Event Category',
            'update_item' => 'Update Event Category',
            'add_new_item' => 'Add New Event Category',
            'new_item_name' => 'New Event Category Name',
            'menu_name' => 'Categories',
        ),
        'hierarchical' => true,
        'public' => true,
        'show_admin_column' => true,
        'rewrite' => array('slug' => 'event-category'),
    ));
}

add_action('init', 'university_event_taxonomy');

// Thêm trường tùy chỉnh cho sự kiện
// Add meta box for the Event Date
function university_event_meta()
{
    add_meta_box('event_date', 'Event Date', 'university_event_date_callback', 'event', 'side', 'high');
}
add_action('add_meta_boxes', 'university_event_meta');

// Callback to display the event date field in the admin
function university_event_date_callback($post)
{
    // Add nonce for security
    wp_nonce_field('save_event_date', 'event_date_nonce');

    // Get the saved date (if available)
    $eventDate = get_post_meta($post->ID, 'event_date', true);

    // Display the date field (if no date is set, use today's date as a placeholder)
    $value = $eventDate ? $eventDate : '';
    echo '<label for="event_date">Event Date: </label>';
    echo '<input type="date" id="event_date" name="event_date" value="' . esc_attr($value) . '" />';
}

// Save the event date when the post is saved
function save_event_date($post_id)
{
    // Check if nonce is set
    if (!isset($_POST['event_date_nonce'])) {
        return $post_id;
    }

    // Verify nonce for security
    if (!wp_verify_nonce($_POST['event_date_nonce'], 'save_event_date')) {
        return $post_id;
    }

    // Check if user has permission to edit the post
    if (!current_user_can('edit_post', $post_id)) {
        return $post_id;
    }

    // Save the event date (only if it's set)
    if (isset($_POST['event_date'])) {
        // Sanitize the input date
        $eventDate = sanitize_text_field($_POST['event_date']);

        // Update the post meta
        update_post_meta($post_id, 'event_date', $eventDate);
    }
}
add_action('save_post', 'save_event_date');

// Front-end function to display the event date
function display_event_date()
{
    global $post;

    $eventDate = get_post_meta($post->ID, 'event_date', true);

    if ($eventDate) {
        // Format the date as required (e.g., "F j, Y")
        $formattedDate = date('F j, Y', strtotime($eventDate));
        echo '<p>Event Date: ' . esc_html($formattedDate) . '</p>';
    } else {
        echo '<p>Event Date: Not Set</p>';
    }
}

// Register Slider Custom Post Type
function create_slider_post_type()
{
    register_post_type(
        'slider',
        array(
            'labels' => array(
                'name' => __('Sliders'),
                'singular_name' => __('Slider'),
                'add_new' => __('Add New'),
                'add_new_item' => __('Add New Slider'),
                'edit_item' => __('Edit Slider'),
                'new_item' => __('New Slider'),
                'view_item' => __('View Slider'),
                'search_items' => __('Search Sliders'),
                'not_found' => __('No sliders found'),
                'not_found_in_trash' => __('No sliders found in Trash'),
            ),
            'public' => true,
            'has_archive' => true,
            'menu_icon' => 'dashicons-images-alt2',
            'supports' => array('title', 'thumbnail', 'editor'),
        )
    );
}
add_action('init', 'create_slider_post_type');

// Add Meta Box for Slider Details
function add_slider_meta_boxes()
{
    add_meta_box(
        'slider_details',
        'Slider Details',
        'render_slider_meta_box',
        'slider',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'add_slider_meta_boxes');

// Render Meta Box Content
function render_slider_meta_box($post)
{
    $slider_link = get_post_meta($post->ID, 'slider_link', true);
    wp_nonce_field('slider_meta_box', 'slider_meta_box_nonce');
?>
    <p>
        <label for="slider_link">Slider Link:</label>
        <input type="url" id="slider_link" name="slider_link" value="<?php echo esc_attr($slider_link); ?>" style="width: 100%;">
    </p>
    <?php
}

// Save Slider Meta Data
function save_slider_meta($post_id)
{
    if (!isset($_POST['slider_meta_box_nonce']) || !wp_verify_nonce($_POST['slider_meta_box_nonce'], 'slider_meta_box')) {
        return;
    }

    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    if (isset($_POST['slider_link'])) {
        update_post_meta($post_id, 'slider_link', esc_url_raw($_POST['slider_link']));
    }
}
add_action('save_post', 'save_slider_meta');

// Display Sliders (You can customize this function to display sliders on the front-end)
function display_sliders()
{
    $args = array(
        'post_type' => 'slider',
        'posts_per_page' => -1,
        'orderby' => 'date',
        'order' => 'DESC',
    );

    $sliders = new WP_Query($args);

    if ($sliders->have_posts()) {
        echo '<div class="slider-container">';
        while ($sliders->have_posts()) {
            $sliders->the_post();
            $slider_link = get_post_meta(get_the_ID(), 'slider_link', true);
    ?>
            <div class="slider-item">
                <?php if ($slider_link) : ?>
                    <a href="<?php echo esc_url($slider_link); ?>">
                    <?php endif; ?>
                    <?php the_post_thumbnail('full'); ?>
                    <?php if ($slider_link) : ?>
                    </a>
                <?php endif; ?>
                <h2><?php the_title(); ?></h2>
                <?php the_content(); ?>
            </div>
<?php
        }
        echo '</div>';
    }
    wp_reset_postdata();
}
