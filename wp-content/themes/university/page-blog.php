<?php
get_header();
?>

<div class="page-banner">
    <div class="page-banner__bg-image"
        style="background-image: url(<?php echo get_theme_file_uri('images/library-hero.jpg') ?>)"></div>
    <div class="page-banner__content container container--narrow">
        <h1 class="page-banner__title"><?php the_title() ?></h1>
        <div class="page-banner__intro">
            <p><?php
                ?></p>
        </div>
    </div>
</div>

<div class="container container--narrow page-section">
    <?php
    $blogPosts = new WP_Query(array(
        'posts_per_page' => 5,
        'post_type' => 'post',
        'paged' => get_query_var('paged', 1)
    ));

    while ($blogPosts->have_posts()) {
        $blogPosts->the_post(); ?>

        <div class="post-item">
            <h2 class="headline headline--medium headline--post-title">
                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
            </h2>

            <div class="metabox">
                <p>Posted by <?php the_author_posts_link(); ?> on <?php the_time('F j, Y'); ?> in <?php echo get_the_category_list(', '); ?></p>
            </div>

            <div class="generic-content">
                <?php if (has_post_thumbnail()) : ?>
                    <a href="<?php the_permalink(); ?>">
                        <img src="<?php the_post_thumbnail_url('medium'); ?>" alt="<?php the_title(); ?>" class="img-responsive">
                    </a>
                <?php endif; ?>
                <?php the_excerpt(); ?>
                <p><a href="<?php the_permalink(); ?>" class="btn btn--blue">Continue Reading</a></p>
            </div>
        </div>

    <?php }

    echo paginate_links(array(
        'total' => $blogPosts->max_num_pages,
    ));

    wp_reset_postdata();
    ?>
</div>

<?php
get_footer();
