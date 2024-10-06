<?php
get_header();
?>
<div class="page-banner">
    <div class="page-banner__bg-image" style="background-image: url(<?php echo get_theme_file_uri('images/library-hero.jpg') ?>)"></div>
    <div class="page-banner__content container container--narrow">
        <h1 class="page-banner__title"><?php the_title(); ?></h1>
        <div class="page-banner__intro">
            <p>Learn more about our organization.</p>
        </div>
    </div>
</div>
<?php
while (have_posts()) {
    the_post();
    $eventDate = get_post_meta(get_the_ID(), 'event_date', true);
    $eventLocation = get_post_meta(get_the_ID(), 'event_location', true);
?>
    <div class="container container--narrow page-section">
        <div class="metabox metabox--position-up metabox--with-home-link">
            <p><a class="metabox__blog-home-link" href="<?php echo get_post_type_archive_link('event'); ?>">
                    <i class="fa fa-home" aria-hidden="true"></i> Events Home</a>
                <span class="metabox__main"><?php the_title(); ?></span>
            </p>
        </div>

        <div class="generic-content">
            <?php the_content(); ?>
        </div>

        <div class="event-details">
            <?php if ($eventDate) : ?>
                <p><strong>Date:</strong> <?php echo date('F j, Y', strtotime($eventDate)); ?></p>
            <?php endif; ?>
            <?php if ($eventLocation) : ?>
                <p><strong>Location:</strong> <?php echo esc_html($eventLocation); ?></p>
            <?php endif; ?>
        </div>
    </div>
<?php }

get_footer();
?>