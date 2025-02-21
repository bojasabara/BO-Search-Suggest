<?php
/**
* Plugin Name: BO Search Suggest
* Description: Search Suggest for Woocommerce
* Version: 1.0
* Author: Boja Sabara
* WC requires at least: 3.0.0
* WC tested up to: 9.4
**/

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

const SS_VERSION = "1.0";

/* Add style and script to plugin*/
function bo_ss_add_scripts() {
    wp_enqueue_style( 'bo_ss-css', untrailingslashit( plugin_dir_url( __FILE__ ) ).'/assets/css/bo_ss.css' );
    wp_enqueue_script( 'bo_ss-js', untrailingslashit( plugin_dir_url( __FILE__ ) ).'/assets/js/bo_ss.js', array('jquery'), false, true);
    $options = get_option( 'bo_ss_searchsuggest_plugin_options' );
    $all_text = __('Show all results', 'bo_search_suggest');
    $not_found = __('Nothing found', 'bo_search_suggest');
    if(isset($options['all_text']) && !empty($options['all_text'])){
        $all_text = $options['all_text'];
    }
    if(isset($options['not_found']) && !empty($options['not_found'])){
        $not_found = $options['not_found'];
    }     
    wp_localize_script( 'bo_ss-js', 'bo_ss_ajax_object', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ), 'show_results' => esc_attr($all_text), 'not_found' => esc_attr($not_found) ));
}
add_action( 'wp_enqueue_scripts', 'bo_ss_add_scripts' );

function bo_ss_add_admin_scripts() {
    wp_enqueue_style( 'wp-color-picker' );
    wp_enqueue_script( 'wp-color-picker');
    wp_enqueue_script( 'bo_ss_admin-js', untrailingslashit( plugin_dir_url( __FILE__ ) ).'/assets/js/bo_ss_admin.js', array('jquery'), false, true);
    wp_enqueue_style('bo_ss_admin-css', untrailingslashit( plugin_dir_url( __FILE__ ) ).'/assets/css/bo_ss_admin.css');
}
add_action('admin_enqueue_scripts', 'bo_ss_add_admin_scripts');


add_action( 'wp_ajax_bo_ss_search', 'bo_ss_search' );
add_action( 'wp_ajax_nopriv_bo_ss_search', 'bo_ss_search' );
function bo_ss_search() {
    $search = new BOSS_SearchClass;
    $products = $search->search(sanitize_text_field($_POST['bo_ss_search']));
    wp_send_json($products);
}

function bo_ss_input_search_shortcode( $attrs ){
    $options = get_option( 'bo_ss_searchsuggest_plugin_options' );
    $all_bg = '#000';
    $all_color = '#fff';
    $placeholder = 'Search products..';
    if(isset($options['all_bg']) && !empty($options['all_bg'])){
        $all_bg = $options['all_bg'];
    }
    if(isset($options['all_color']) && !empty($options['all_color'])){
        $all_color = $options['all_color'];
    }
    if(isset($options['input_placeholder']) && !empty($options['input_placeholder'])){
        $placeholder = $options['input_placeholder'];
    }
    
	$html = '<div class="bo_ss_search_input_container">
                <form method="get" role="search" action="'.get_site_url().'">
                    <input type="search" id="bo_ss_search_input" class="search-field" placeholder="'.esc_attr($placeholder).'" value="" name="s">
                    <img class="bo_ss_loader" src="'.untrailingslashit( plugin_dir_url( __FILE__ ) ).'/assets/img/loading.gif">
                    <input type="submit">
                </form>
            </div>';
    $html .= '<style>.bo_ss_autosuggest_all_res {background-color: '.esc_attr($all_bg).'; color: '.esc_attr($all_color).';}</style>';
    return $html;
}
add_shortcode( 'bo_ss_search', 'bo_ss_input_search_shortcode' );

//Add Hpos Compatibility
add_action('before_woocommerce_init', function(){
    if ( class_exists( \Automattic\WooCommerce\Utilities\FeaturesUtil::class ) ) {
        \Automattic\WooCommerce\Utilities\FeaturesUtil::declare_compatibility( 'custom_order_tables', __FILE__, true );
    }
    
});


include 'classes/SearchClass.php';
include 'classes/ValidatorClass.php';
include 'classes/AdminClass.php';
include 'classes/FeedbackClass.php';
include 'classes/ResultsPageClass.php';
