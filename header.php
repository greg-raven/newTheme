<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="profile" href="https://gmpg.org/xfn/11" />
    <?php wp_head(); ?>
    <script async src="https://powerad.ai/script.js"></script>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<?php
$logo     = function_exists( 'amren_field' ) ? amren_field( 'header_logo', 'options' ) : ( function_exists( 'get_field' ) ? get_field( 'header_logo', 'options' ) : '' );
$logo_alt = function_exists( 'amren_field' ) ? amren_field( 'header_logo_alt', 'options', get_bloginfo( 'name' ) ) : ( function_exists( 'get_field' ) ? get_field( 'header_logo_alt', 'options' ) : get_bloginfo( 'name' ) );
?>

<div class="responsive-menu">
    <div class="resp-logo">
        <?php if ( $logo ) : ?>
            <img src="<?php echo esc_url( $logo ); ?>" alt="<?php echo esc_attr( $logo_alt ); ?>" />
        <?php endif; ?>
    </div>
    <?php
    wp_nav_menu(
        array(
            'theme_location'  => 'main-menu',
            'container_class' => 'main-menu',
        )
    );
    ?>
    <form action="<?php echo esc_url( home_url( '/' ) ); ?>" method="get" class="search-form" role="search">
        <input id="mobile-s" class="search-query" type="text" name="s" title="search" placeholder="Search...">
        <button type="submit" aria-label="Search">
            <svg xmlns="http://www.w3.org/2000/svg" class="search-form-icon icon icon-tabler icon-tabler-search" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="#003c5e" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0" /><path d="M21 21l-6 -6" /></svg>
        </button>
    </form>
</div>

<div class="container header">
    <div class="wrapper">
        <div class="container">
            <div class="row">
                <div class="responsive-menu-icon"></div>
                <div class="twelve columns logo">
                    <a href="<?php echo esc_url( home_url( '/' ) ); ?>">
                        <?php if ( $logo ) : ?>
                            <img src="<?php echo esc_url( $logo ); ?>" alt="<?php echo esc_attr( $logo_alt ); ?>" />
                        <?php else : ?>
                            <?php bloginfo( 'name' ); ?>
                        <?php endif; ?>
                    </a>
                </div>
                <div class="twelve columns main-menu">
                    <?php
                    wp_nav_menu(
                        array(
                            'theme_location'  => 'main-menu',
                            'container_class' => 'main-menu',
                        )
                    );
                    ?>
                    <form action="<?php echo esc_url( home_url( '/' ) ); ?>" method="get" class="search-form" role="search">
                        <input id="s" class="search-query" type="text" name="s" title="search" placeholder="Search...">
                        <button type="submit" aria-label="Search">
                            <svg xmlns="http://www.w3.org/2000/svg" class="search-form-icon icon icon-tabler icon-tabler-search" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="#003c5e" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0" /><path d="M21 21l-6 -6" /></svg>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
