<?php get_header(); ?>

<div class="container">
    <div class="program-detail">
        <?php while (have_posts()) : the_post(); ?>
            <article class="program-post">
                <!-- Hiển thị tiêu đề -->
                <h1 class="program-title"><?php the_title(); ?></h1>

                <!-- Hiển thị ngày đăng bài -->
                <p class="program-date">Published on: <?php echo get_the_date(); ?></p>

                <!-- Hiển thị hình ảnh đại diện -->
                <?php if (has_post_thumbnail()) : ?>
                    <div class="program-thumbnail">
                        <?php the_post_thumbnail('large'); ?>
                    </div>
                <?php endif; ?>

                <!-- Hiển thị nội dung bài viết -->
                <div class="program-content">
                    <?php the_content(); ?>
                </div>

                <!-- Hiển thị trường tùy chỉnh nếu có -->
                <?php
                $program_date = get_post_meta(get_the_ID(), 'program_date', true);
                $program_location = get_post_meta(get_the_ID(), 'program_location', true);
                ?>

                <?php if ($program_date) : ?>
                    <p><strong>Program Date:</strong> <?php echo esc_html($program_date); ?></p>
                <?php endif; ?>

                <?php if ($program_location) : ?>
                    <p><strong>Program Location:</strong> <?php echo esc_html($program_location); ?></p>
                <?php endif; ?>

                <!-- Link để quay lại trang archive của các program -->
                <p><a href="<?php echo get_post_type_archive_link('program'); ?>" class="btn btn--blue">Back to All Programs</a></p>
            </article>
        <?php endwhile; ?>
    </div>
</div>

<?php get_footer(); ?>
