<?php
get_header();
?>
<div class="page-banner">
  <div class="page-banner__bg-image" style="background-image: url(<?php echo get_theme_file_uri('images/library-hero.jpg') ?>)"></div>
  <div class="page-banner__content container t-center c-white">
    <h1 class="headline headline--large">Welcome!</h1>
    <h2 class="headline headline--medium">We think you&rsquo;ll like it here.</h2>
    <h3 class="headline headline--small">Why don&rsquo;t you check out the <strong>major</strong> you&rsquo;re interested in?</h3>
    <a href="#" class="btn btn--large btn--blue">Find Your Major</a>
  </div>
</div>

<div class="full-width-split group">
  <div class="full-width-split__one">
    <div class="full-width-split__inner">
      <h2 class="headline headline--small-plus t-center">Upcoming Events</h2>
      <?php
      $homepageEvents = new WP_Query(array(
        'posts_per_page' => 2, // Số lượng sự kiện cần hiển thị
        'post_type' => 'event' // Custom post type cho sự kiện
      ));

      while ($homepageEvents->have_posts()) {
        $homepageEvents->the_post();

        // Lấy ngày sự kiện từ custom field 'event_date'
        $eventDate = get_post_meta(get_the_ID(), 'event_date', true);

        if ($eventDate) {
          // Định dạng ngày tháng
          $eventDateFormatted = date('F j, Y', strtotime($eventDate));
        } else {
          $eventDateFormatted = 'Event Date Not Set'; // Xử lý nếu không có ngày
        }
      ?>
        <div class="event-summary">
          <a class="event-summary__date event-summary__date--beige t-center" href="<?php the_permalink(); ?>">
            <span class="event-summary__month"><?php echo date("M", strtotime($eventDateFormatted)); ?></span>
            <span class="event-summary__day"><?php echo date("d", strtotime($eventDateFormatted)); ?></span>
          </a>
          <div class="event-summary__content">
            <h5 class="event-summary__title headline headline--tiny">
              <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
            </h5>
            <p>
              <?php
              if (has_excerpt()) {
                echo get_the_excerpt();
              } else {
                echo wp_trim_words(get_the_content(), 18);
              }
              ?>
              <a href="<?php the_permalink(); ?>" class="nu gray">Read more</a>
            </p>
          </div>
        </div>
      <?php }
      wp_reset_postdata(); // Đảm bảo reset dữ liệu post
      ?>
      <p class="t-center no-margin">
        <a href="<?php echo get_post_type_archive_link('event'); ?>" class="btn btn--blue">View All Events</a>
      </p>
    </div>
  </div>



  <div class="full-width-split__two">
    <div class="full-width-split__inner">
      <h2 class="headline headline--small-plus t-center">From Our Blogs</h2>
      <?php
      $homepagePosts = new WP_Query(array(
        'posts_per_page' => 2
      ));

      while ($homepagePosts->have_posts()) {
        $homepagePosts->the_post(); ?>

        <div class="event-summary">
          <a class="event-summary__date event-summary__date--beige t-center" href="<?php the_permalink(); ?>">
            <span class="event-summary__month"><?php the_time('M'); ?></span>
            <span class="event-summary__day"><?php the_time('d') ?></span>
          </a>
          <div class="event-summary__content">
            <h5 class="event-summary__title headline headline--tiny"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h5>
            <p>
              <?php
              if (has_excerpt()) {
                echo get_the_excerpt();
              } else {
                echo wp_trim_words(get_the_content(), 18);
              }
              ?>
              <a href="<?php echo esc_url(get_the_permalink()); ?>" class="nu gray"> Read more </a>
            </p>
          </div>
        </div>
      <?php }
      wp_reset_postdata(); ?>
      <p class="t-center no-margin"><a href="<?php echo site_url('/blog'); ?>" class="btn btn--yellow">View All Blog Posts</a></p>
    </div>
  </div>
</div>


<div class="hero-slider">
  <div data-glide-el="track" class="glide__track">
    <div class="glide__slides">
      <?php
      $slider_posts = new WP_Query(array(
        'post_type' => 'slider',
        'posts_per_page' => -1, // Fetch all slider posts
        'orderby' => 'date',
        'order' => 'DESC',
      ));

      while ($slider_posts->have_posts()) {
        $slider_posts->the_post();
        $slider_link = get_post_meta(get_the_ID(), 'slider_link', true);
      ?>
        <div class="hero-slider__slide" style="background-image: url(<?php echo get_the_post_thumbnail_url(null, 'full'); ?>)">
          <div class="hero-slider__interior container">
            <div class="hero-slider__overlay">
              <h2 class="headline headline--medium t-center"><?php the_title(); ?></h2>
              <p class="t-center"><?php echo wp_trim_words(get_the_content(), 15); ?></p>
              <?php if ($slider_link) : ?>
                <p class="t-center no-margin"><a href="<?php echo esc_url($slider_link); ?>" class="btn btn--blue">Learn more</a></p>
              <?php endif; ?>
            </div>
          </div>
        </div>
      <?php
      }
      wp_reset_postdata();
      ?>
    </div>
    <div class="slider__bullets glide__bullets" data-glide-el="controls[nav]"></div>
  </div>
</div>
<?php
get_footer();


//id, 
//thumbnail: hình ảnh đại diện,
//title*, permalink*: Quan trọng nhất,
//excerpt: phần rút gọn,
//content: nội dung chính,

//Hàm: the_id(), the_thumbnail(), the_title(), the_title(), the_content(), không cs return
//Hàm: get_the_id(), get_the_thumbnail(), get_the_title(), get_the_title(), get_the_content(), cs return