<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php the_title(); ?></title>
    <?php wp_head(); ?>
</head>

<body>
    <header class="site-header">
        <div class="container">
            <h1 class="school-logo-text float-left">
                <?php
                $sitename = get_bloginfo('title');
                $fictional = explode(" ", $sitename);
                ?>
                <a href="<?php echo esc_url(site_url("/")); ?>"><strong><?php echo $fictional[0]; ?></strong> <?php echo $fictional[1]; ?></a>
            </h1>
            <a href="" class="js-search-trigger site-header__search-trigger"><i class="fa fa-search" aria-hidden="true"></i></a>
            <i class="site-header__menu-trigger fa fa-bars" aria-hidden="true"></i>
            <div class="site-header__menu group">
                <?php wp_nav_menu(array(
                    'theme_location' => 'primary_menu',
                    'container' => 'nav',
                    'container_class' => 'main-navigation',
                    'depth' => 2,
                ));
                ?>
                <div class="site-header__util">
                    <a href="#" class="btn btn--small btn--orange float-left push-right">Login</a>
                    <a href="#" class="btn btn--small btn--dark-orange float-left">Sign Up</a>
                </div>
            </div>
        </div>
        <div class="overlay"></div>
    </header>