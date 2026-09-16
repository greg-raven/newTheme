<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

function amren_field( $name, $post_id = false, $default = '' ) {
    if ( function_exists( 'get_field' ) ) {
        $value = get_field( $name, $post_id );
        if ( null !== $value && false !== $value && '' !== $value ) {
            return $value;
        }
    }
    return $default;
}

add_action(
    'after_setup_theme',
    function () {
        add_theme_support( 'title-tag' );
        add_theme_support( 'post-thumbnails' );
        add_theme_support(
            'html5',
            array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'script', 'style' )
        );

        register_sidebar(
            array(
                'id'            => 'sidebar-1',
                'name'          => 'Sidebar',
                'before_widget' => '<div id="%1$s" class="widget %2$s hidden">',
                'after_widget'  => '</div>',
                'before_title'  => '<div class="widget-title">',
                'after_title'   => '</div>',
            )
        );

        register_sidebar(
            array(
                'id'            => 'footer-1',
                'name'          => 'Footer',
                'before_widget' => '<div id="%1$s" class="widget %2$s hidden">',
                'after_widget'  => '</div>',
                'before_title'  => '<div class="widget-title">',
                'after_title'   => '</div>',
            )
        );
    }
);

add_action( 'init', 'wpb_custom_new_menu' );
function wpb_custom_new_menu() {
    register_nav_menu( 'main-menu', __( 'Main Menu' ) );
    register_nav_menu( 'footer-menu', __( 'Footer Menu' ) );
}

add_action(
    'pre_get_posts',
    function ( $query ) {
        if ( is_admin() || ! $query->is_main_query() ) {
            return;
        }

        if ( $query->is_home() ) {
            $exclude = get_category_by_slug( 'features' );
            if ( $exclude && ! is_wp_error( $exclude ) ) {
                $query->set( 'category__not_in', array( (int) $exclude->term_id ) );
            } else {
                $query->set( 'category__not_in', array( 90 ) );
            }

            $query->set( 'posts_per_page', wp_is_mobile() ? 5 : 40 );
            $query->set( 'ignore_sticky_posts', true );
            $query->set( 'no_found_rows', true );
        }
    }
);

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

add_action(
    'save_post',
    function ( $post_id ) {
        if ( wp_is_post_revision( $post_id ) || wp_is_post_autosave( $post_id ) ) {
            return;
        }
        delete_transient( 'amren_home_features_ids' );
    }
);

add_filter(
    'nav_menu_css_class',
    function ( $classes, $item ) {
        if ( ! is_front_page() ) {
            return $classes;
        }

        $item_url = untrailingslashit( $item->url );
        $home_url = untrailingslashit( home_url() );

        if ( '/' === $item->url || '' === $item_url || $item_url === $home_url ) {
            $classes[] = 'current-menu-item';
        }

        return $classes;
    },
    10,
    2
);

add_filter(
    'jetpack_lazy_images_blacklisted_classes',
    function ( $classes ) {
        $classes[] = 'no-ll';
        return $classes;
    },
    999,
    1
);

add_action(
    'wp_enqueue_scripts',
    function () {
        wp_enqueue_style( 'amren-style', get_template_directory_uri() . '/style.css', array(), filemtime( get_template_directory() . '/style.css' ) );
        wp_enqueue_style( 'owl-css', get_template_directory_uri() . '/css/owl.carousel.min.css' );
        wp_enqueue_style( 'owl-theme-css', get_template_directory_uri() . '/css/owl.theme.default.min.css' );
        wp_enqueue_script( 'jqueryui', 'https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.2/jquery-ui.min.js', array( 'jquery' ), '1.13.2', true );
        wp_enqueue_script( 'owl-js', get_template_directory_uri() . '/js/owl.carousel.js', array( 'jquery' ), null, true );
        wp_enqueue_script( 'owl-js-ap', get_template_directory_uri() . '/js/owl.autoplay.js', array( 'owl-js' ), null, true );
        wp_enqueue_script( 'owl-js-mav', get_template_directory_uri() . '/js/owl.navigation.js', array( 'owl-js' ), null, true );
        wp_enqueue_script( 'amren-main', get_template_directory_uri() . '/js/amren.js', array( 'jquery', 'jqueryui', 'owl-js' ), filemtime( get_template_directory() . '/js/amren.js' ), true );
    }
);

add_action(
    'admin_print_footer_scripts',
    function () {
        if ( wp_script_is( 'quicktags' ) ) {
            ?>
            <script type="text/javascript">
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
        }
    }
);

add_action(
    'wp_body_open',
    function () {
        if ( ! is_front_page() ) {
            return;
        }
        echo '<div class="front-page-banner" style="background-color: #F6D55F; color: black; font-weight: bold; margin: 0; padding: 6px; text-align: center;">We hope to see you at the <a href="https://www.amren.com/2026-american-renaissance-conference/">2026 American Renaissance Conference</a>.</div>';
    }
);

require_once __DIR__ . '/includes/block-manager.php';
require_once __DIR__ . '/includes/shortcode-toggle.php';
require_once __DIR__ . '/includes/pagination.php';

function amren_algolia_settings( $settings ) {
    $settings['attributesToSnippet'][1] = 'content:40';
    return $settings;
}
add_filter( 'algolia_searchable_posts_index_settings', 'amren_algolia_settings', 10, 1 );
