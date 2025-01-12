<?php 

/* ==========================================================================
   Activing All CSS and jQuery in WordPress
   ========================================================================== */


// Add all CSS Files
function my_css_calling(){ 
    wp_register_style('plugins', get_template_directory_uri().'/css/plugins.css', array(), '1.0.1', 'all' ); 
    wp_register_style( 'ali-style', get_stylesheet_uri() );
    wp_register_style('custom', get_template_directory_uri().'/css/custom.css', array(), '1.0.1', 'all' );
    wp_register_style('responsive', get_template_directory_uri().'/css/responsive.css', array(), '1.0.1', 'all' );
    wp_register_style('fontawesomepro', get_template_directory_uri().'/css/all.min.css', array(), '5.15.2', 'all' );
    wp_enqueue_style( 'bootstrap', 'https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css', array(), '4.5.0', 'all' );
    wp_enqueue_style('plugins');
    wp_enqueue_style('fontawesomepro');
    wp_enqueue_style('custom');
    wp_enqueue_style('responsive');
    
    wp_enqueue_script('jquery');
    wp_enqueue_script('popper', 'https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js', array(), '1.16.0', 'true' );
    wp_enqueue_script('bootstrap', 'https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js', array(), '4.5.0', 'true' );
    wp_enqueue_script('plugins', get_template_directory_uri() .'/js/plugins.js', array(), '1.0.1', 'true' );
    wp_enqueue_script('fontawesomepro', get_template_directory_uri() .'/js/all.min.js', array(), '5.15.2', 'false' );
    // wp_enqueue_script('bpkbvote', get_template_directory_uri() .'/basepress/mikb/js/bpkb_vote.js', array(), '1.0.0', 'true' );  -- removed, cookie issue & didn't work as expected
    wp_enqueue_script('main', get_template_directory_uri() .'/js/main.js', array(), '1.0.1', 'true' );
    // wp_enqueue_script('fittext', get_template_directory_uri() .'/js/fittext-nojquery/fittext.js', array(), '1.2.0', 'true' );
}
add_action('wp_enqueue_scripts', 'my_css_calling');

