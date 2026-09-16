<?php
/**
 * Template Name: Archives Page
 */
get_header();
?>
<div class="container main-content archives-page">
    <div class="wrapper">
        <div class="container">
            <div class="content">
                <div class="articles archive">
                    <h1 class="title"><?php esc_html_e( 'Archives', 'amren' ); ?></h1>
                </div>

                <div class="tag-cloud">
                    <h2 class="h3"><?php esc_html_e( 'Tag Archives:', 'amren' ); ?></h2>
                    <?php
                    wp_tag_cloud(
                        array(
                            'smallest'  => 8,
                            'largest'   => 22,
                            'number'    => 120,
                            'separator' => ",\n",
                        )
                    );
                    ?>
                </div>

                <div class="monthly-archives">
                    <h2 class="h3"><?php esc_html_e( 'Monthly Archives:', 'amren' ); ?></h2>
                    <select name="archive-dropdown" onchange="document.location.href=this.options[this.selectedIndex].value;">
                        <option value=""><?php esc_html_e( 'Select a Month', 'amren' ); ?></option>
                        <?php
                        wp_get_archives(
                            array(
                                'type'   => 'monthly',
                                'format' => 'option',
                            )
                        );
                        ?>
                    </select>
                </div>

                <div class="author-archives">
                    <h2 class="h3"><?php esc_html_e( 'Author Archives:', 'amren' ); ?></h2>
                    <ul>
                        <?php
                        wp_list_authors(
                            array(
                                'show_fullname' => true,
                                'optioncount'   => true,
                            )
                        );
                        ?>
                    </ul>
                </div>
            </div>
            <div class="sidebar"><?php dynamic_sidebar( 'sidebar-1' ); ?></div>
        </div>
    </div>
</div>
<?php get_footer(); ?>
