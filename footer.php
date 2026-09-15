<div class="container footer">
    <div class="wrapper">
        <div class="container">
            <?php dynamic_sidebar( 'footer-1' ); ?>
        </div>
        <div class="container">
            <div class="copyright">
                The contents of this website are copyright &copy; 1990-<?php echo esc_html( gmdate( 'Y' ) ); ?> New Century Foundation.
            </div>
        </div>
    </div>
</div>
<?php wp_footer(); ?>
<?php
$custom_css = function_exists( 'amren_field' ) ? amren_field( 'custom_css', 'options' ) : ( function_exists( 'get_field' ) ? get_field( 'custom_css', 'options' ) : '' );
$custom_js  = function_exists( 'amren_field' ) ? amren_field( 'custom_js', 'options' ) : ( function_exists( 'get_field' ) ? get_field( 'custom_js', 'options' ) : '' );

if ( $custom_css ) {
    echo '<style id="amren-custom-css">' . wp_strip_all_tags( $custom_css ) . '</style>';
}

if ( $custom_js ) {
    echo '<script id="amren-custom-js">' . $custom_js . '</script>';
}
?>
</body>
</html>
