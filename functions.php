<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

define( 'AMREN_VERSION', wp_get_theme()->get( 'Version' ) );

function amren_field( $name, $post_id = false, $default = '' ) {
    if ( function_exists( 'get_field' ) ) {
        $value = get_field( $name, $post_id );
        return ( null !== $value && false !== $value && '' !== $value ) ? $value : $default;
    }
    return $default;
}

add_action( 'after_setup_theme', function () {
    add_theme_support( 'title-tag' );
    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'automatic-feed-links' );
    add_theme_support(
        'html5',
        array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'script', 'style' )
    );

    register_nav_menus(
        array(
            'main-menu'   => __( 'Main Menu', 'amren' ),
            'footer-menu' => __( 'Footer Menu', 'amren' ),
        )
    );

    register_sidebar(
        array(
            'id'            => 'sidebar-1',
            'name'          => __( 'Sidebar', 'amren' ),
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget'  => '</div>',
            'before_title'  => '<div class="widget-title">',
            'after_title'   => '</div>',
        )
    );

    register_sidebar(
        array(
            'id'            => 'footer-1',
            'name'          => __( 'Footer', 'amren' ),
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget'  => '</div>',
            'before_title'  => '<div class="widget-title">',
            'after_title'   => '</div>',
        )
    );
} );

add_filter(
    'jetpack_lazy_images_blacklisted_classes',
    function ( $classes ) {
        $classes[] = 'no-ll';
        return $classes;
    },
    999
);

add_filter( 'nav_menu_css_class', function ( $classes, $item ) {
    if ( ! is_front_page() ) {
        return $classes;
    }

    $item_url = untrailingslashit( $item->url );
    $home_url = untrailingslashit( home_url() );

    if ( '/' === $item->url || '' === $item_url || $item_url === $home_url ) {
        $classes[] = 'current-menu-item';
    }

    return $classes;
}, 10, 2 );

add_action( 'wp_enqueue_scripts', function () {
    $theme_uri = get_template_directory_uri();
    $theme_dir = get_template_directory();

    wp_enqueue_style( 'amren-style', $theme_uri . '/style.css', array(), filemtime( $theme_dir . '/style.css' ) );

    if ( file_exists( $theme_dir . '/css/owl.carousel.min.css' ) ) {
        wp_enqueue_style( 'owl-css', $theme_uri . '/css/owl.carousel.min.css', array(), '2.3.4' );
        wp_enqueue_style( 'owl-theme-css', $theme_uri . '/css/owl.theme.default.min.css', array( 'owl-css' ), '2.3.4' );
    }

    if ( file_exists( $theme_dir . '/css/ar-main.css' ) ) {
        wp_enqueue_style( 'amren-main-css', $theme_uri . '/css/ar-main.css', array( 'amren-style' ), filemtime( $theme_dir . '/css/ar-main.css' ) );
    }
    if ( file_exists( $theme_dir . '/css/ar-responsive.css' ) ) {
        wp_enqueue_style( 'amren-responsive', $theme_uri . '/css/ar-responsive.css', array( 'amren-main-css' ), filemtime( $theme_dir . '/css/ar-responsive.css' ) );
    }

    wp_enqueue_script( 'jquery' );

    wp_enqueue_script(
        'jquery-ui',
        'https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.2/jquery-ui.min.js',
        array( 'jquery' ),
        '1.13.2',
        true
    );

    wp_enqueue_script( 'owl-js', $theme_uri . '/js/owl.carousel.js', array( 'jquery' ), '2.3.4', true );
    wp_enqueue_script( 'amren-main', $theme_uri . '/js/amren.js', array( 'jquery', 'jquery-ui', 'owl-js' ), filemtime( $theme_dir . '/js/amren.js' ), true );
} );

add_action( 'wp_body_open', function () {
    if ( ! is_front_page() ) {
        return;
    }

    $banner = amren_field( 'front_page_banner', 'option' );
    if ( $banner ) {
        echo '<div class="front-page-banner">' . wp_kses_post( $banner ) . '</div>';
        return;
    }

    echo '<div class="front-page-banner" style="background-color:#F6D55F;color:#000;font-weight:bold;margin:0;padding:6px;text-align:center;">We hope to see you at the <a href="https://www.amren.com/2026-american-renaissance-conference/">2026 American Renaissance Conference</a>.</div>';
} );

add_action( 'admin_print_footer_scripts', function () {
    if ( ! wp_script_is( 'quicktags' ) ) {
        return;
    }
    ?>
    <script>
    QTags.addButton('text_left_class', '.text-left', ' class="text-left"', '', '', '', 111);
    QTags.addButton('text_right_class', '.text-right', ' class="text-right"', '', '', '', 112);
    QTags.addButton('text_center_class', '.text-center', ' class="text-center"', '', '', '', 113);
    QTags.addButton('text_justify_class', '.text-justify', ' class="text-justify"', '', '', '', 114);
    QTags.addButton('text_nowrap_class', '.text-nowrap', ' class="text-nowrap"', '', '', '', 115);
    QTags.addButton('text_lowercase_class', '.text-lowercase', ' class="text-lowercase"', '', '', '', 116);
    QTags.addButton('text_uppercase_class', '.text-uppercase', ' class="text-uppercase"', '', '', '', 117);
    QTags.addButton('text_capitalize_class', '.text-capitalize', ' class="text-capitalize"', '', '', '', 118);
    QTags.addButton('text_muted_class', '.text-muted', ' class="text-muted"', '', '', '', 119);
    </script>
    <?php
} );

add_action( 'pre_get_posts', function ( $query ) {
    if ( is_admin() || ! $query->is_main_query() ) {
        return;
    }

    if ( $query->is_home() ) {
        $exclude = get_category_by_slug( 'uncategorized' );

        if ( $exclude && ! is_wp_error( $exclude ) ) {
            $query->set( 'category__not_in', array( (int) $exclude->term_id ) );
        } else {
            $query->set( 'category__not_in', array( 90 ) );
        }

        $query->set( 'posts_per_page', wp_is_mobile() ? 5 : 15 );
        $query->set( 'ignore_sticky_posts', true );
        $query->set( 'no_found_rows', true );
    }
} );

function amren_get_home_features() {
    $cached = get_transient( 'amren_home_features_ids' );

    if ( false === $cached ) {
        $q = new WP_Query(
            array(
                'post_type'              => 'post',
                'post_status'            => 'publish',
                'category_name'          => 'features',
                'posts_per_page'         => 6,
                'fields'                 => 'ids',
                'no_found_rows'          => true,
                'ignore_sticky_posts'    => true,
                'update_post_term_cache' => false,
            )
        );
        $cached = $q->posts;
        set_transient( 'amren_home_features_ids', $cached, 15 * MINUTE_IN_SECONDS );
    }

    if ( empty( $cached ) ) {
        return new WP_Query();
    }

    return new WP_Query(
        array(
            'post_type'           => 'post',
            'post__in'            => $cached,
            'orderby'             => 'post__in',
            'posts_per_page'      => count( $cached ),
            'no_found_rows'       => true,
            'ignore_sticky_posts' => true,
        )
    );
}

add_action( 'save_post', function ( $post_id ) {
    if ( wp_is_post_revision( $post_id ) || wp_is_post_autosave( $post_id ) ) {
        return;
    }
    delete_transient( 'amren_home_features_ids' );
} );

require_once __DIR__ . '/includes/block-manager.php';
require_once __DIR__ . '/includes/shortcode-toggle.php';
require_once __DIR__ . '/includes/pagination.php';

add_filter( 'algolia_searchable_posts_index_settings', function ( $settings ) {
    $settings['attributesToSnippet'][1] = 'content:40';
    return $settings;
} );

// What changed: title-tag and thumbnails, ACF helper, menus registered once, widgets no longer forced hidden, scripts in footer with versions/deps, optional enqueue of ar-main.css / ar-responsive.css, banner can come from ACF later. If those extra CSS files are already pulled in by @import inside style.css, remove the extra wp_enqueue_style lines so you don’t load them twice.


