<?php
get_header();

while (have_posts()) {
    the_post();
?>

    <div class="page-banner">
        <div class="page-banner__bg-image" style="background-image: url(<?php echo get_theme_file_uri('images/library-hero.jpg') ?>)"></div>
        <div class="page-banner__content container container--narrow">
            <h1 class="page-banner__title"><?php the_title(); ?></h1>
            <div class="page-banner__intro">
                <p>lorem</p>
            </div>
        </div>
    </div>

    <div class="container container--narrow page-section">
        <?php
        $parentPage = wp_get_post_parent_id(get_the_id());
        if ($parentPage) { ?>
            <div class="metabox metabox--position-up metabox--with-home-link">
                <p>
                    <a class="metabox__blog-home-link" href="<?php echo get_permalink($parentPage); ?>">
                        <i class="fa fa-home" aria-hidden="true"></i>
                        Back to
                        <?php echo get_the_title($parentPage); ?>
                    </a>

                    <span class="metabox__main">
                        <?php the_title(); ?>
                    </span>
                </p>
            </div>
        <?php }
        ?>

        <?php
        $childPages = get_pages(array(
            "child_of" => get_the_ID()
        ));

        if ($parentPage or $childPages) { ?>
            <div class="page-links">
                <h2 class="page-links__title">
                    <a href="<?php echo get_permalink($parentPage); ?>">
                        <?php echo get_the_title($parentPage); ?>
                    </a>
                </h2>

                <ul class="min-list">
                    <?php
                    if ($parentPage) {
                        $findChildrenOf = $parentPage;
                    } else {
                        $findChildrenOf = get_the_ID();
                    }

                    wp_list_pages(array(
                        "title_li" => null,
                        "child_of" => $findChildrenOf,
                        "sort_column" => "menu_order"
                    ));
                    ?>
                </ul>
            </div>
        <?php } ?>

        <?php
        // Retrieve all events
        $eventsQuery = new WP_Query(array(
            'post_type' => 'event',
            'posts_per_page' => -1,
            'meta_key' => 'event_date',
            'orderby' => 'meta_value_num',
            'order' => 'ASC'
        ));

        // Check if there are events
        if ($eventsQuery->have_posts()) {
            while ($eventsQuery->have_posts()) {
                $eventsQuery->the_post();
                $eventDate = get_post_meta(get_the_ID(), 'event_date', true);
        ?>

                <div class="event-summary">
                    <a class="event-summary__date t-center" href="<?php the_permalink(); ?>">
                        <span class="event-summary__month"><?php echo strtoupper(date('M', strtotime($eventDate))); ?></span>
                        <span class="event-summary__day"><?php echo date('d', strtotime($eventDate)); ?></span>
                    </a>
                    <div class="event-summary__content">
                        <h2 class="event-summary__title headline headline--medium">
                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                        </h2>
                        <p>
                            <?php if (has_excerpt()) {
                                echo get_the_excerpt();
                            } else {
                                echo wp_trim_words(get_the_content(), 18);
                            } ?>
                            <a href="<?php the_permalink(); ?>" class="nu gray">Read more</a>
                        </p>
                    </div>
                </div>

        <?php }
        } else { ?>
            <p>Không có sự kiện nào.</p>
        <?php }

        // Reset post data
        wp_reset_postdata();
        ?>

    </div>

<?php
}

get_footer();
?>