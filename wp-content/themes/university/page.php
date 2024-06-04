<?php
get_header();
while (have_posts()) :
    the_post();
?>

    <div class="page-banner">
        <div class="page-banner__bg-image" style="background-image: url(<?php echo get_theme_file_uri('images/library-hero.jpg') ?>)"></div>
        <div class="page-banner__content container container--narrow">
            <h1 class="page-banner__title"><?php the_title(); ?></h1>
            <div class="page-banner__intro">
                <p><?php the_excerpt() ?></p>
            </div>
        </div>
    </div>
    <?php
    $theParent = wp_get_post_parent_id(get_the_ID());
    ?>
    <div class="container container--narrow page-section">
        <div class="metabox metabox--position-up metabox--with-home-link">
            <p>
                <?php if ($theParent) : ?>
                    <a class="metabox__blog-home-link" href="<?php echo get_permalink($theParent) ?>">
                        <i class="fa fa-home" aria-hidden="true"></i> Back to About Us</a>
                    <span class="metabox__main"><?php the_title(); ?></span>
                <?php endif; ?>
            </p>
        </div>
        <div class="page-links">
            <h2 class="page-links__title"><a href="#"><?php echo get_the_title($theParent) ?></a></h2>
            <ul class="min-list">
                <?php
                wp_list_pages(array(
                    'title_li' => '',
                    'child_of' => $theParent ? $theParent : get_the_ID(),
                ));
                ?>
            </ul>
        </div>

        <div class="generic-content">
            <?php the_content(); ?>
        </div>
    </div>
<?php
endwhile;
get_footer();
?>