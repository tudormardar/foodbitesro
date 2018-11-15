<?php
function my_theme_enqueue_styles() {
    wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
}
add_action( 'wp_enqueue_scripts', 'my_theme_enqueue_styles' );


// Enque custom styles -----------------------------------------
function custom_styles()
{
    wp_register_style( 'fontawesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css', '', '4.7.0', 'all' );
    // wp_register_style( 'bootstrap', '//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css', '', '3.3.7', 'all' );
    wp_register_style( 'custom-style', get_stylesheet_directory_uri() . '/css/custom-style.css', '', '1.0.0', 'all' );

    // For either a plugin or a theme, you can then enqueue the style:
    wp_enqueue_style( 'fontawesome' );
    // wp_enqueue_style( 'bootstrap' );
    wp_enqueue_style( 'custom-style' );


}
// add_action( 'wp_enqueue_scripts', 'custom_styles', 100);


// Shortcodes -----------------------------------------



// Include templates -----------------------------------------


// Remove projects post type from Divi theme
add_filter( 'et_project_posttype_args', 'mytheme_et_project_posttype_args', 10, 1 );
function mytheme_et_project_posttype_args( $args ) {
    return array_merge( $args, array(
        'public'              => false,
        'exclude_from_search' => false,
        'publicly_queryable'  => false,
        'show_in_nav_menus'   => false,
        'show_ui'             => false
    ));
}

// Remove unnecessary features from parent theme function - clean HEAD
function et_remove_support_theme() {
    remove_theme_support( 'woocommerce' );
    remove_theme_support( 'wc-product-gallery-zoom' );
    remove_theme_support( 'wc-product-gallery-lightbox' );
    remove_theme_support( 'wc-product-gallery-slider' );
}
add_action( 'after_setup_theme', 'et_remove_support_theme' );

function wpse_dequeue_google_fonts() {
    wp_dequeue_style( 'divi-fonts' );
}
add_action( 'wp_enqueue_scripts', 'wpse_dequeue_google_fonts', 20 );

function sdt_remove_ver_css_js( $src, $handle )
{
    $handles_with_version = [ 'style' ]; // <-- Adjust to your needs!

    if ( strpos( $src, 'ver=' ) && ! in_array( $handle, $handles_with_version, true ) )
        $src = remove_query_arg( 'ver', $src );

    return $src;
}
add_filter( 'style_loader_src',  'sdt_remove_ver_css_js', 9999, 2 );
add_filter( 'script_loader_src', 'sdt_remove_ver_css_js', 9999, 2 );


// Excerpt remove dots
function new_excerpt_more( $more ) {
    return '';
}
add_filter('excerpt_more', 'new_excerpt_more');


// Remove emoji icons
remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('wp_print_styles', 'print_emoji_styles');

// Remove dashicons
add_action( 'wp_print_styles', 'my_deregister_styles', 100 );
function my_deregister_styles() {
   wp_deregister_style( 'dashicons' );
}


?>