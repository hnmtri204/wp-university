<?php get_header(); ?>

<div class="page-banner">
  <div class="page-banner__bg-image" style="background-image: url(<?php echo get_theme_file_uri('images/library-hero.jpg') ?>)"></div>
  <div class="page-banner__content container container--narrow">
    <h1 class="page-banner__title">Blog</h1>
    <div class="page-banner__intro">
      <p>lorem</p>
    </div>
  </div>
</div>

<div class="container container--narrow page-section">
  <?php
  $allPostsQuery = new WP_Query(array(
    'posts_per_page' => -1,
  ));

  if ($allPostsQuery->have_posts()) {
    while ($allPostsQuery->have_posts()) {
      $allPostsQuery->the_post(); ?>

      <div class="post-item">
        <h2 class="headline headline--medium">
          <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
        </h2>

        <div class="metabox">
          <p>
            Posted By <?php the_author_posts_link(); ?> on the day <?php the_time('d/m/Y'); ?>
            in <?php echo get_the_category_list(', '); ?>
          </p>
        </div>

        <div class="generic-content">
          <?php the_excerpt(); ?>
          <p><a class="btn btn--blue" href="<?php the_permalink(); ?>">Continue reading &raquo;</a></p>
        </div>
      </div>

    <?php }
  } else { ?>
    <p>There are currently no posts.</p>
  <?php }

  wp_reset_postdata(); 
  ?>

</div>

<?php get_footer(); ?>