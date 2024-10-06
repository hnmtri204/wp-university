<?php get_header(); ?>

<div class="container">
    <h1>Chương Trình</h1>
    <?php
    $args = array(
        'post_type' => 'program',
        'posts_per_page' => -1,
    );

    $programs = new WP_Query($args);

    if ($programs->have_posts()) {
        while ($programs->have_posts()) {
            $programs->the_post(); ?>
            <div class="program">
                <h2><?php the_title(); ?></h2>
                <div><?php the_content(); ?></div>
                <p><strong>Ngày:</strong> <?php echo esc_html(get_post_meta(get_the_ID(), 'program_date', true)); ?></p>
                <p><strong>Địa điểm:</strong> <?php echo esc_html(get_post_meta(get_the_ID(), 'program_location', true)); ?></p>
            </div>
        <?php }
    } else {
        echo '<p>Không có chương trình nào.</p>';
    }

    wp_reset_postdata(); // Reset post data
    ?>
</div>

<?php get_footer(); ?>
