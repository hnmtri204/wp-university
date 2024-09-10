<?php
function university_post_types()
{
    // Đăng ký post type cho sự kiện
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


    // Đăng ký post type cho program
    register_post_type('program', array(
        'labels' => array(
            'name' => 'Programs',
            'singular_name' => 'Program',
            'add_new_item' => 'Add New Program',
            'edit_item' => 'Edit Program',
            'all_items' => 'All Programs',
            'view_item' => 'View program',
            'not_found' => 'No programs found',
            'not_found_in_trash' => 'No Programs found in Trash'
        ),
        'public' => true,
        'supports' => array('title', 'editor', 'thumbnail', 'excerpt'),
        'menu_icon' => 'dashicons-format-aside',
    ));
}

add_action('init', 'university_post_types');

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
