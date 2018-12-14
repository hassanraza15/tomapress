<?php
/**
 * Dikka functions file.
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {echo '<h1>Forbidden</h1>'; exit();}

global $dikka_options;


if ( !class_exists( 'ReduxFramework' ) && file_exists( dirname( __FILE__ ) . '/ReduxCore/framework.php' ) ) {
    require_once( dirname( __FILE__ ) . '/ReduxCore/framework.php' );
}
if ( !isset( $redux_demo ) && file_exists( dirname( __FILE__ ) . '/ReduxCore/sample-config.php' ) ) {
    require_once( dirname( __FILE__ ) . '/ReduxCore/sample-config.php' );
}
require_once( ABSPATH . 'wp-admin/includes/plugin.php' );

/*********************************************************************
* THEME SETUP
*/

function dikka_setup() {

    global $dikka_options;

    // Translations support. Find language files in dikka/languages
    load_theme_textdomain('dikka', get_template_directory().'/languages');
    $locale = get_locale();
    $locale_file = get_template_directory()."/languages/{$locale}.php";
    if(is_readable($locale_file)) { require_once($locale_file); }

    // Set content width
    global $content_width;
    if (!isset($content_width)) $content_width = 720;

    // Editor style (editor-style.css)
    add_editor_style(array('assets/css/editor-style.css'));

    // Load plugin checker
    require(get_template_directory() . '/inc/plugin-activation.php');

    //Include all post types
    require(get_template_directory() . '/inc/custom_post_types.php');

    add_filter('add_to_cart_fragments' , 'woocommerce_header_add_to_cart_fragment' );

    // Nav Menu (Custom menu support)
    if (function_exists('register_nav_menu')) :
        register_nav_menu('primary', __('Dikka Primary Menu', 'dikka'));
    endif;

    // Theme Features: Automatic Feed Links
    add_theme_support('automatic-feed-links');

    // Theme Features: woocommerce
    add_theme_support( 'woocommerce' );

    // Theme Features: Dynamic Sidebar
    add_post_type_support( 'post', 'simple-page-sidebars' );


    // Theme Features: Post Thumbnails and custom image sizes for post-thumbnails
    add_theme_support('post-thumbnails', array('post', 'page','product','portfolio'));

    // Theme Features: Post Formats
    add_theme_support('post-formats', array( 'gallery', 'image', 'link', 'quote', 'video', 'audio'));


    
}
add_action('after_setup_theme', 'dikka_setup');


function dikka_widgets_setup() {

    global $dikka_options;
    // Widget areas
    if (function_exists('register_sidebar')) :
        // Sidebar right
        register_sidebar(array(
            'name' => "Blog Sidebar",
            'id' => "dikka-widgets-aside-right",
            'description' => __('Widgets placed here will display in the right sidebar', 'dikka'),
            'before_widget' => '<div id="%1$s" class="well well-sm widget %2$s">',
            'after_widget'  => '</div>'
        ));

        // Woocommerce sidebar
        register_sidebar(array(
            'name' => "WooCommerce Sidebar",
            'id' => "dikka-widgets-woocommerce-sidebar",
            'description' => __('Widgets placed here will display in the product page sidebar', 'dikka'),
            'before_widget' => '<div id="%1$s" class="well well-sm widget %2$s">',
            'after_widget'  => '</div>'
        ));
        // Footer Block 1
        register_sidebar(array(
            'name' => "Footer Block 1",
            'id' => "dikka-widgets-footer-block-1",
            'description' => __('Widgets placed here will display in the first footer block', 'dikka'),
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget'  => '</div>'
        ));
        // Footer Block 2
        register_sidebar(array(
            'name' => "Footer Block 2",
            'id' => "dikka-widgets-footer-block-2",
            'description' => __('Widgets placed here will display in the second footer block', 'dikka'),
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget'  => '</div>'
        ));
        // Footer Block 3
        if(isset($dikka_options['footer-layout']) && esc_attr($dikka_options['footer-layout'])>5) {
        register_sidebar(array(
            'name' => "Footer Block 3",
            'id' => "dikka-widgets-footer-block-3",
            'description' => __('Widgets placed here will display in the third footer block', 'dikka'),
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget'  => '</div>'
        ));
        }

        // Footer Block 4
        if(isset($dikka_options['footer-layout']) && esc_attr($dikka_options['footer-layout'])>9) {
        register_sidebar(array(
            'name' => "Footer Block 4",
            'id' => "dikka-widgets-footer-block-4",
            'description' => __('Widgets placed here will display in the third footer block', 'dikka'),
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget'  => '</div>'
        ));
        }
       
    endif;
   
}
add_action('widgets_init', 'dikka_widgets_setup');


// The excerpt "more" button
function dikka_excerpt($text) {
    return str_replace('[&hellip;]', '[&hellip;]<a class="" title="'. sprintf (__('Read more on %s','dikka'), get_the_title()).'" href="'.get_permalink().'">' . __(' Read more','dikka') . '</a>', $text);
}
add_filter('excerpt_more', 'dikka_excerpt');

function dikka_more_link($more_link, $more_link_text) {
    return str_replace($more_link_text, '[&hellip;]<a class="" title="'. sprintf (__('Read more on %s','dikka'), get_the_title()).'" href="'.get_permalink().'">' . __(' Read more','dikka') . '</a>', $more_link_text );
}
add_filter('the_content_more_link', 'dikka_more_link', 10, 2);

/*********************************************************************
 * Function to load all theme assets (scripts and styles) in header
 */
function dikka_load_theme_assets() {

    global $dikka_options;

    echo '
    <!--[if lt IE 9]>
	<script src="http://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.2/html5shiv.min.js"></script>
   <![endif]-->
	
	<!--[if IE]>
		<link rel="stylesheet" href="'.get_template_directory_uri().'/assets/css/ie.css" media="screen" type="text/css" />
    	<![endif]-->

    ';

    //Enqueue google fonts 
    wp_enqueue_style('googlefont-raleway', 'http://fonts.googleapis.com/css?family=Raleway:400,300,600,800');
    wp_enqueue_style('googlefont-opensans', 'http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700,800');
    wp_enqueue_style('googlefont-opensans', 'http://fonts.googleapis.com/css?family=Shadows+Into+Light+Two');

    // Enqueue all the theme CSS
    wp_enqueue_style('bootstrap', get_template_directory_uri().'/assets/css/bootstrap.css');
    wp_enqueue_style('font-awesome', get_template_directory_uri().'/assets/libs/font-awesome/css/font-awesome.min.css');
    wp_enqueue_style('YTPlayer', get_template_directory_uri().'/assets/css/YTPlayer.css');
    wp_enqueue_style('woocm-uxqode', get_template_directory_uri().'/assets/css/woocommerce-ux.css');
    wp_enqueue_style('woo-layout-ux', get_template_directory_uri().'/assets/css/woo-layout-ux.css');
    wp_enqueue_style('main', get_template_directory_uri().'/style.css');
    wp_enqueue_style('resize', get_template_directory_uri().'/assets/css/resize.css');

    wp_enqueue_style('retina', get_template_directory_uri().'/assets/css/retina.css');


    wp_enqueue_style('nivo-lightbox', get_template_directory_uri().'/assets/css/nivo-lightbox.css');
    wp_enqueue_style('nivolightbox', get_template_directory_uri().'/assets/css/nivo_themes/default/default.css');
    wp_enqueue_style('owl.carousel', get_template_directory_uri().'/assets/css/owl.carousel.css');
    wp_enqueue_style('animate', get_template_directory_uri().'/assets/css/animate.css');

    // Enqueue Color variation CSS
    if (!empty($dikka_options['css_style']) ) :
        wp_enqueue_style('dikka-style-css', get_template_directory_uri().'/assets/css/color-variations/'.esc_attr($dikka_options['css_style']).'.css');
    else :
        wp_enqueue_style('dikka-style-css', get_template_directory_uri().'/assets/css/color-variations/red.css');
    endif;
        
    if(isset($dikka_options['typography-body']['font-family']) && $dikka_options['typography-body']['font-family']!=''&& $dikka_options['typography-body']['font-weight']!='') {
    wp_enqueue_style('googlefont-custom', 'http://fonts.googleapis.com/css?family='.esc_attr($dikka_options['typography-body']['font-family']));
    }
    if(isset($dikka_options['typography-h1']['font-family']) && $dikka_options['typography-h1']['font-family']!=''&& $dikka_options['typography-h1']['font-weight']!='') {
    wp_enqueue_style('googlefont-h1', 'http://fonts.googleapis.com/css?family='.esc_attr($dikka_options['typography-h1']['font-family']));
    }
    if(isset($dikka_options['typography-h2']['font-family']) && $dikka_options['typography-h2']['font-family']!=''&& $dikka_options['typography-h2']['font-weight']!='') {
    wp_enqueue_style('googlefont-h2', 'http://fonts.googleapis.com/css?family='.esc_attr($dikka_options['typography-h2']['font-family']));
    }
    if(isset($dikka_options['typography-h3']['font-family']) && $dikka_options['typography-h3']['font-family']!=''&& $dikka_options['typography-h3']['font-weight']!='') {
    wp_enqueue_style('googlefont-h3', 'http://fonts.googleapis.com/css?family='.esc_attr($dikka_options['typography-h3']['font-family']));
    }
    if(isset($dikka_options['typography-h4']['font-family']) && $dikka_options['typography-h4']['font-family']!=''&& $dikka_options['typography-h4']['font-weight']!='') {
    wp_enqueue_style('googlefont-h4', 'http://fonts.googleapis.com/css?family='.esc_attr($dikka_options['typography-h4']['font-family']));
    }
    if(isset($dikka_options['typography-h5']['font-family']) && $dikka_options['typography-h5']['font-family']!=''&& $dikka_options['typography-h5']['font-weight']!='') {
    wp_enqueue_style('googlefont-h5', 'http://fonts.googleapis.com/css?family='.$dikka_options['typography-h5']['font-family']);
    }
    if(isset($dikka_options['typography-h6']['font-family']) && $dikka_options['typography-h6']['font-family']!=''&& $dikka_options['typography-h6']['font-weight']!='') {
    wp_enqueue_style('googlefont-h6', 'http://fonts.googleapis.com/css?family='.$dikka_options['typography-h6']['font-family']);
    }
    

    
   
   // Enqueue all the js files of theme
    wp_enqueue_script('jquery');
    wp_enqueue_script('isotope-min', get_template_directory_uri().'/assets/js/isotope-min.js', array(), FALSE, TRUE);
    wp_enqueue_script('retina-min', get_template_directory_uri().'/assets/js/retina.min.js', array(), FALSE, TRUE);
    wp_enqueue_script('queryloader.min', get_template_directory_uri().'/assets/js/queryloader.min.js', array(), FALSE, TRUE);
    wp_enqueue_script('bootstrap.min', get_template_directory_uri().'/assets/js/bootstrap.min.js', array(), FALSE, TRUE);
    wp_enqueue_script('smartmenus.min', get_template_directory_uri().'/assets/js/smartmenus.min.js', array(), FALSE, TRUE);
    wp_enqueue_script('ytplayer', get_template_directory_uri().'/assets/js/ytplayer.js', array(), FALSE, TRUE);
    wp_enqueue_script('animate', get_template_directory_uri().'/assets/js/wow.js', array(), TRUE, TRUE);
    wp_enqueue_script('utils-js', get_template_directory_uri().'/assets/js/utils.js', array(), FALSE, TRUE);
    wp_enqueue_script('main-js', get_template_directory_uri().'/assets/js/main.js', array(), FALSE, TRUE);
    wp_enqueue_script('SmoothScroll-js', get_template_directory_uri().'/assets/js/SmoothScroll.js', array(), FALSE, TRUE);
    wp_enqueue_script('owl.carousel.min-js', get_template_directory_uri().'/assets/js/owl.carousel.min.js', array(), FALSE, TRUE);
    wp_enqueue_script('nivo-lightbox.min-js', get_template_directory_uri().'/assets/js/nivo-lightbox.min.js', array(), FALSE, TRUE);
    wp_enqueue_script('modernizr.custom', get_template_directory_uri().'/assets/js/modernizr.custom.js', array(), FALSE, TRUE);
    

    $color_variation ='';
    if(isset($dikka_options['custom_color']) && $dikka_options['custom_color']!=''){
          $hex = str_replace("#", "", esc_attr($dikka_options['custom_color']));

           if(strlen($hex) == 3) {
              $r = hexdec(substr($hex,0,1).substr($hex,0,1));
              $g = hexdec(substr($hex,1,1).substr($hex,1,1));
              $b = hexdec(substr($hex,2,1).substr($hex,2,1));
           } else {
              $r = hexdec(substr($hex,0,2));
              $g = hexdec(substr($hex,2,2));
              $b = hexdec(substr($hex,4,2));
           }
           $new_custom_color = array($r, $g, $b);

    $color_variation='
    .navbar-default.style1 .navbar-nav > .open > a, .navbar-default.style1 .navbar-nav > .open > a:hover, .navbar-default.style1 .navbar-nav > .open > a:focus{color: #fff;}
a, .pageXofY .pageX, .pricing .bestprice .name, .filter li a:hover, .widget ul li a:hover, #contacts a:hover, .title-color, .ms-staff-carousel .ms-staff-info h4, .filter li a:hover, .navbar-default .navbar-nav > .open > a, .navbar-default .navbar-nav > .open > a:hover, .navbar-default .navbar-nav > .open > a:focus, .navbar-default .navbar-nav > li > a:hover, .widget_nav_menu li a:hover, .navbar-default .navbar-nav > li > a:focus, a.go-about:hover, .text_color, .navbar-nav .dropdown-menu a:hover, .profile .profile-name, #elements h4, #contact li a:hover, #agency-slider h5, .ms-showcase1 .product-tt h3, .filter li a.active, .contacts li i, .big-icon i, .navbar-default.dark .navbar-brand:hover,.navbar-default.dark .navbar-brand:focus, a.p-button.border:hover, a.social:hover:before, .symbol.colored i, .icon-nofill, .slidecontent-bi .project-title-bi p a:hover, .grid .figcaption a.thumb-link:hover, .tp-caption a:hover, .btn-1d:hover, .btn-1d:active, #contacts .tweet_text a, #contacts .tweet_time a, .social-font-awesome li a:hover, h2.post-title a:hover, .tags a:hover, .category a:hover, .btn-color span, #contacts .form-success p, .center-icon i, .social-icomoon a:hover, .team-details .team-position, .blog-nav a:hover, a:hover .text-inner, .btn-color, .navbar-default .navbar-nav > li > a.selected, .navbar-default .navbar-nav li a:hover, .metas .post-type i, .list-body i, .social-icomoon li a:hover i{
  color: '.esc_attr($dikka_options['custom_color']).';
}
.collapse-group .collapse-heading h4 a, .collapse-group .collapse-heading h4 a .toggle-icon i{
    color: '.esc_attr($dikka_options['custom_color']).' !important;
}
.collapse-group .collapse-heading h4 a .toggle-icon i{
    color: '.esc_attr($dikka_options['custom_color']).';
}
.collapse-group .collapse-heading h4 a.collapsed .toggle-icon i{color: #676767 !important;}
.slight .navbar-nav a.current-menu-item, .slight.navbar-default.default .navbar-nav > .open > a, .slight.navbar-default.default .navbar-nav > .open > a > .open > a, .slight ul.cart_list li a:hover, .woocommerce ul.cart_list li a:hover, .slight .navbar-nav a:hover, .sdark .navbar-nav a.current-menu-item, .sdark.navbar-default.default .navbar-nav > .open > a, .sdark.navbar-default.default .navbar-nav > .open > a > .open > a, .sdark ul.cart_list li a:hover, .woocommerce ul.cart_list li a:hover, .sdark .navbar-nav a:hover, .tLight .navbar-nav a.current-menu-item, .tLight.navbar-default.default .navbar-nav > .open > a, .tLight.navbar-default.default .navbar-nav > .open > a > .open > a, .tLight ul.cart_list li a:hover, .woocommerce ul.cart_list li a:hover, .tLight .navbar-nav a:hover, .navbar-default.default.slight .nav a.current-menu-ancestor{color: '.esc_attr($dikka_options['custom_color']).' !important;opacity: 1;}

a.sf-button.hide-icon, .tabs li.current, .readmore:hover, a.p-button:hover, a.p-button.colored, .navbar-default.style1 .navbar-nav > li > a.selected, .light #contacts a.p-button, .tagcloud a:hover, .rounded.fill, .colored-section, .pricing .bestprice .price, .pricing .bestprice .signup, .signup:hover, .divider.colored, .services-graph li span, .hi-icon-effect-1b .hi-icon:hover, .no-touch .hi-icon-effect-1b .hi-icon:hover, .symbol.colored .line-left, .symbol.colored .line-right, .projects-overlay #projects-loader, .panel-group .panel.active .panel-heading, .mail-box, .double-bounce1, .double-bounce2, .btn-color-1d:after, .container1 > div, .container2 > div, .container3 > div, .btn-color:hover, .collapse-group .collapse-heading h4 a:hover .toggle-icon, .collapse-group .collapse-heading h4 a .toggle-icon, .blog-nav span, #back-top a:hover, .btn-color-fill, .team-div .overlaycolor{
    background-color:'.esc_attr($dikka_options['custom_color']).';
}
.dikka_minicart .cart_list a:hover{
	background:'.esc_attr($dikka_options['custom_color']).';
}
.cbp-l-project-details-visit, .cbp-l-inline-view, .light .divider.colored, .origin-widget-title.text-lightest .divider.colored, .mc4wp-form button, .mc4wp-form input[type=button], .mc4wp-form input[type=submit], .origin-widget-price-box.featured h4, .navbar-default.default .nav li a.border-menu-item{
    background-color:'.esc_attr($dikka_options['custom_color']).' !important;
}

/* Woocommerce */
.woocommerce span.onsale,.woocommerce-page span.onsale, .woocommerce .widget_price_filter .ui-slider .ui-slider-range, .woocommerce-page .widget_price_filter .ui-slider .ui-slider-range, .woocommerce #content input.button:hover, .woocommerce #respond input#submit:hover, .woocommerce a.button:hover, .woocommerce button.button:hover, .woocommerce input.button:hover, .woocommerce-page #content input.button:hover, .woocommerce-page #respond input#submit:hover, .woocommerce-page a.button:hover, .woocommerce-page button.button:hover, .woocommerce-page input.button:hover, .woocommerce #content input.button.alt:hover, .woocommerce #respond input#submit.alt:hover, .woocommerce a.button.alt:hover, .woocommerce button.button.alt:hover, .woocommerce input.button.alt:hover, .woocommerce-page #content input.button.alt:hover, .woocommerce-page #respond input#submit.alt:hover, .woocommerce-page a.button.alt:hover, .woocommerce-page button.button.alt:hover, .woocommerce-page input.button.alt:hover, .woocommerce #payment #place_order, .woocommerce-page #payment #place_order{
    background: '.esc_attr($dikka_options['custom_color']).' !important;
}
.woocommerce ul.products li.product .price, .woocommerce-page ul.products li.product .price{
    color: '.esc_attr($dikka_options['custom_color']).';
}
.woocommerce .widget_price_filter .ui-slider .ui-slider-handle, .woocommerce-page .widget_price_filter .ui-slider .ui-slider-handle{border: 1px solid #d44646 !important;background: #d44646 !important;}
.blog-nav span, .blog-nav a:hover{border: 1px solid '.esc_attr($dikka_options['custom_color']).';}
.hi-icon-effect-1 .hi-icon:after{box-shadow: 0 0 0 4px '.esc_attr($dikka_options['custom_color']).';}
.colored-section:after {border: 20px solid '.esc_attr($dikka_options['custom_color']).';}
.filter li a.active, .filter li a:hover, .panel-group .panel.active .panel-heading{border:1px solid '.esc_attr($dikka_options['custom_color']).'}
a.p-button.colored:hover{background-color: #cb4646;}
.navbar-default.default.border .navbar-nav > li > a.selected:before, .navbar-default.default.border .navbar-nav > li > a.selected:hover, .navbar-default.default.border .navbar-nav > li > a.selected, .mc4wp-form button, .mc4wp-form input[type=button], .mc4wp-form input[type=submit]{
    border-bottom: 1px solid '.esc_attr($dikka_options['custom_color']).';
}
.bs-callout-theme-color {
    background-color: #d3ecfd;
    border-color: '.esc_attr($dikka_options['custom_color']).';
}
.overlay-color{
    background-color: rgba('.$new_custom_color['0'].','.$new_custom_color['1'].','.$new_custom_color['2'].', 0.9);
}
.overlay-color.medium, .skill-bar-percent, .post-content .featured-image a:hover .hover-image-blog{ background-color: rgba('.$new_custom_color['0'].','.$new_custom_color['1'].','.$new_custom_color['2'].', 0.80);
}
.triangle{border-left-color: '.esc_attr($dikka_options['custom_color']).' !important;}
.overlay-color.soft{
    background-color: rgba('.$new_custom_color['0'].','.$new_custom_color['1'].','.$new_custom_color['2'].', 0.25);
}
.navbar-default.default.slight ul.dropdown-menu, .slight .dikka_minicart, .navbar-default.default.sdark ul.dropdown-menu, .sdark .dikka_minicart{
    border-top: 2px solid '.esc_attr($dikka_options['custom_color']).' !important;
}
.btn-color, a:hover .text-inner{
    border: 1px solid '.esc_attr($dikka_options['custom_color']).';
}
.navbar-default .navbar-nav > li:hover > a::before, .navbar-default .navbar-nav > li.active > a::before {
    border-bottom-color: '.esc_attr($dikka_options['custom_color']).';
}
.loading-css, .nivo-lightbox-theme-default .nivo-lightbox-content.nivo-lightbox-loading{
    border-right: 2px solid '.esc_attr($dikka_options['custom_color']).';
    border-top: 2px solid '.esc_attr($dikka_options['custom_color']).';
}
.tp-caption a.slider-link{
    color: '.esc_attr($dikka_options['custom_color']).' !important;
    font-weight: 800 !important;
}

    ';
    }
    wp_add_inline_style( 'dikka-style-css', $color_variation );


       $inline_css='';
     
     if(isset($dikka_options['preloader-image']) && $dikka_options['preloader-image']!=1){
        $inline_css.='
        #load .loader-container {
        margin-top:-50px;
        }';
     }


    if(isset($dikka_options['footer-style2']) && $dikka_options['footer-style2']==1) {
    $inline_css.='
    .socialdiv{width:48%;float:right;top:10px}.socialdiv ul li{float:right}.logo-footer{margin:10px 0 0;position:relative;float:left;padding-left:15px;width:50%}.logo-footer img{float:left}.b-text{padding-left:12px;float:left;width:100%;text-align:left}.b-text p{color:#585858;margin:8px 3px;opacity:.4;font-size:.9em;text-align:left}.contacts-footer{color:#343434;float:left;padding:0;margin:0;width:100%}.contacts-footer li{float:left;list-style-type:none;margin:8px 15px 0 0}.team-details{text-align:left}.cbp-l-filters-alignCenter{text-align:left!important;font-size:13px!important;background:0 0!important;padding:15px 0 20px!important;position:relative;top:-30px;left:0}';
    }

    if ( is_admin_bar_showing() ) {
     $inline_css.='
     .navbar {
     margin-top: 32px;
     }
     @media screen and (max-width: 782px){
         .navbar {
         margin-top: 40px;
         }
     }
    ';
    }

    if(is_home()){
        $pageid=get_option('page_for_posts');
    } else {
        $pageid=get_the_ID();
    }
    $page_setting_activate=get_post_meta( $pageid, 'dikka_pagetitle_activate',true);

    if(isset($page_setting_activate) && $page_setting_activate=='on') {
        
        if(get_post_meta( $pageid, 'dikka_pagetitle_color',true)){
            $inline_css.='.pagetitle .section-title h1{';
            if($epcolor=get_post_meta( $pageid, 'dikka_pagetitle_color',true)){
                 $inline_css.='color:'.$epcolor.' !important;';
            }
            $inline_css.='}';
        }


        if(get_post_meta( $pageid, 'dikka_pagetitle_bgcolor',true) OR get_post_meta( $pageid, 'dikka_pagetitle_image',true)){
            $inline_css.='.pagetitle {';
            if($epbgcolor=get_post_meta( $pageid, 'dikka_pagetitle_bgcolor',true)){
                 $inline_css.='background-color:'.$epbgcolor.'!important;';
            }
            if($epbgimage=get_post_meta( $pageid, 'dikka_pagetitle_image',true)){
                $inline_css.='background-image:url('.$epbgimage.')!important;';
            }
            $inline_css.='}';
        }   
    }
    if(isset($dikka_options['extra-css'])){
    $inline_css.=$dikka_options['extra-css'];  
    }
    wp_add_inline_style( 'dikka-style-css', $inline_css );

    if(isset($dikka_options['topbar-background']) && $dikka_options['topbar-background']!=''){
          $hex = str_replace("#", "", esc_attr($dikka_options['topbar-background']));
          $opacity='1';
          if(isset($dikka_options['topbar-background-opacity']) && $dikka_options['topbar-background-opacity']!=''){
            $opacity=$dikka_options['topbar-background-opacity']/100;
		}
            if(strlen($hex) == 3) {
            $r = hexdec(substr($hex,0,1).substr($hex,0,1));
            $g = hexdec(substr($hex,1,1).substr($hex,1,1));
            $b = hexdec(substr($hex,2,1).substr($hex,2,1));
            } else {
            $r = hexdec(substr($hex,0,2));
            $g = hexdec(substr($hex,2,2));
            $b = hexdec(substr($hex,4,2));
            }
            $new_custom_color = array($r, $g, $b);
            $inline_css.='.top-bar {';
            $inline_css.='background-color: rgba('.$new_custom_color['0'].','.$new_custom_color['1'].','.$new_custom_color['2'].','.$opacity.');';
            $inline_css.='}';
    }
    wp_add_inline_style( 'dikka-style-css', $inline_css );

    if(isset($dikka_options['topbar-textcolor']) && $dikka_options['topbar-textcolor']!=''){
            $inline_css.='.navbar .social-icons-fa a, .navbar .phone-mail, .navbar .phone-mail a {';
            $inline_css.='color: '.esc_attr($dikka_options['topbar-textcolor']).' !important;';
            $inline_css.='}';
    }
    wp_add_inline_style( 'dikka-style-css', $inline_css );

    $util_array = array( 'url' => get_template_directory_uri() );
    wp_localize_script( 'utils-js', 'UtilParam', $util_array );
    if(isset( $dikka_options['twitter_username'])){
    $main_array = array( 'twitter_username' => esc_attr($dikka_options['twitter_username']),'twitter_count' => esc_attr($dikka_options['twitter_number']) );
    wp_localize_script( 'main-js', 'MainParam', $main_array );
    }
    if(isset( $dikka_options['preloader']) && $dikka_options['preloader']==1){
    $main_array = array( 'preloader' => '1');
    wp_localize_script( 'main-js', 'PreloaderParam', $main_array );
    }

    if(is_page_template('dikka-page-builder.php')){
        $main_var = array( 'home_url' => home_url(),'template_active' => 'builder' );
    } else {
        $main_var = array( 'home_url' => home_url(),'template_active' => 'non-builder' );
    }
    wp_localize_script( 'main-js', 'main', $main_var );



}
add_action('wp_enqueue_scripts', 'dikka_load_theme_assets');

/*********************************************************************
 * RETINA SUPPORT
 */
add_filter('wp_generate_attachment_metadata', 'dikka_retina_support_attachment_meta', 10, 2);
function dikka_retina_support_attachment_meta($metadata, $attachment_id) {

    // Create first image @2
    dikka_retina_support_create_images(get_attached_file($attachment_id), 0, 0, false);

    foreach ($metadata as $key => $value) {
        if (is_array($value)) {
            foreach ($value as $image => $attr) {
                if (is_array($attr))
                    dikka_retina_support_create_images(get_attached_file($attachment_id), $attr['width'], $attr['height'], true);
            }
        }
    }

    return $metadata;
}

function dikka_retina_support_create_images($file, $width, $height, $crop = false) {

    $resized_file = wp_get_image_editor($file);
    if (!is_wp_error($resized_file)) {

        if ($width || $height) {
            $filename = $resized_file->generate_filename($width . 'x' . $height . '@2x');
            $resized_file->resize($width * 2, $height * 2, $crop);
        } else {
            $filename = str_replace('-@2x','@2x',$resized_file->generate_filename('@2x'));
        }
        $resized_file->save($filename);

        $info = $resized_file->get_size();

        return array(
            'file' => wp_basename($filename),
            'width' => $info['width'],
            'height' => $info['height'],
        );
    }

    return false;
}

add_filter('delete_attachment', 'dikka_delete_retina_support_images');
function dikka_delete_retina_support_images($attachment_id) {
    $meta = wp_get_attachment_metadata($attachment_id);
    if(is_array($meta)){
        $upload_dir = wp_upload_dir();
        $path = pathinfo($meta['file']);

        // First image (without width-height specified
        $original_filename = $upload_dir['basedir'] . '/' . $path['dirname'] . '/' . wp_basename($meta['file']);
        $retina_filename = substr_replace($original_filename, '@2x.', strrpos($original_filename, '.'), strlen('.'));
        if (file_exists($retina_filename)) unlink($retina_filename);

        foreach ($meta as $key => $value) {
            if ('sizes' === $key) {
                foreach ($value as $sizes => $size) {
                    $original_filename = $upload_dir['basedir'] . '/' . $path['dirname'] . '/' . $size['file'];
                    $retina_filename = substr_replace($original_filename, '@2x.', strrpos($original_filename, '.'), strlen('.'));
                    if (file_exists($retina_filename))
                        unlink($retina_filename);
                }
            }
        }
    }
}

// Enqueue comment-reply script if comments_open and singular
function dikka_enqueue_comment_reply() {
        if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
                wp_enqueue_script( 'comment-reply' );
        }
}
add_action( 'wp_enqueue_scripts', 'dikka_enqueue_comment_reply' );


// Dikka Pagination
// Code taken from: http://wp-snippets.com/pagination-for-twitter-bootstrap/
function dikka_pagination ($before = '', $after = '') {

    global $dikka_options;

    echo $before;

    

        global $wpdb, $wp_query;

        $request = $wp_query->request;
        $posts_per_page = intval(get_query_var('posts_per_page'));
        $paged = intval(get_query_var('paged'));
        $numposts = $wp_query->found_posts;
        $max_page = $wp_query->max_num_pages;

        if ($numposts <= $posts_per_page) return;
        if (empty($paged) || $paged == 0) $paged = 1;

        $pages_to_show = 7;
        $pages_to_show_minus_1 = $pages_to_show - 1;
        $half_page_start = floor($pages_to_show_minus_1 / 2);
        $half_page_end = ceil($pages_to_show_minus_1 / 2);
        $start_page = $paged - $half_page_start;

        if ($start_page <= 0) $start_page = 1;
        $end_page = $paged + $half_page_end;
        if (($end_page - $start_page) != $pages_to_show_minus_1) {
            $end_page = $start_page + $pages_to_show_minus_1;
        }
        if ($end_page > $max_page) {
            $start_page = $max_page - $pages_to_show_minus_1;
            $end_page = $max_page;
        }
        if ($start_page <= 0) $start_page = 1;

        echo '<div class="space"></div>
              <div class="space"></div>';
        echo ' <div class="blog-nav">';

        echo previous_posts_link( __( '<i class="fa fa-angle-left"></i>', 'dikka' ) );

        for ($i = $start_page; $i <= $end_page; $i++) {
            if ($i == $paged)
                echo ' <span>' . $i . '</span>';
            else
                echo ' <a href="'.get_pagenum_link($i).'">' . $i . '</a>';
        }

        echo next_posts_link( __( '<i class="fa fa-angle-right"></i>', 'dikka' ) );
        echo '</div>';

  

    echo $after;

    return;
}


/* Code for font-awesome support in Menu*/

add_action('wp_update_nav_menu_item', 'dikka_nav_update',10, 3);
function dikka_nav_update($menu_id, $menu_item_db_id, $args ) {
   if (isset($_REQUEST['menu-item-faicon']) ) {
     $custom_faicon= $_REQUEST['menu-item-faicon'][$menu_item_db_id];
     update_post_meta( $menu_item_db_id, '_menu_item_faicon', $custom_faicon);  
     }

}
add_filter( 'wp_setup_nav_menu_item','dikka_nav_item' );

function dikka_nav_item($menu_item) {
$menu_item->faicon = get_post_meta( $menu_item->ID, '_menu_item_faicon', true );  
return $menu_item;
}



Class Description_Walker extends Walker_Nav_Menu {

    function start_lvl( &$output , $depth = 0 , $args = array() ) {
        $indent = str_repeat( "\t", $depth );
        $output .= "\n$indent<ul class=\"dropdown-menu \">\n";
    }



   function start_el(&$output, $item, $depth = 0, $args = array(), $current_object_id = 0)
      {
           global $wp_query;
           $indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

           $class_names = $value = '';

           $classes = empty( $item->classes ) ? array() : (array) $item->classes;

           $class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item ) );
          
           $class_names = ' '. esc_attr( $class_names ) . '';
           
           $output .= $indent . '<li >';
           $attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
           $attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
           $attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
           $attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';
           $prepend='';
          
           $append = '';
           $description  = ! empty( $item->description ) ? '<span>'.esc_attr( $item->description ).'</span>' : '';
          

            $item_output = $args->before;
            if($depth<1){
                $item_output .= '<a class="nav-to '.esc_attr( $class_names ).'" '. $attributes .'>';
            } else {
                $item_output .= '<a class="'.esc_attr( $class_names ).'" '. $attributes .'>';
            }
            $item_output .= $args->link_before .$prepend.apply_filters( 'the_title', $item->title, $item->ID ).$append;
            $item_output .= $description.$args->link_after;
            $item_output .= '</a>';
            $item_output .= $args->after;
       
            $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );



            }

}



function dikka_body_classes( $classes ) {
    global $dikka_options;
    if (!is_page_template('dikka-page-builder.php') ) :
    $classes[] = 'multipage';
    endif; 
    if ( $dikka_options['pagelayout'] =='box' ) :
    $classes[] = 'container box';
    endif;  
    return $classes;
}
add_filter( 'body_class', 'dikka_body_classes' );



add_action( 'tgmpa_register', 'dikka_register_required_plugins' );

function dikka_register_required_plugins() {
 

    $plugins = array(
 
        array(
            'name'               => 'Mero Page Builder', // The plugin name.
            'slug'               => 'merobuilder', // The plugin slug (typically the folder name).
            'source'             => get_stylesheet_directory() . '/inc/plugins/merobuilder.zip', // The plugin source.
            'required'           => true, // If false, the plugin is only 'recommended' instead of required.
            'version'            => '', // E.g. 1.0.0. If set, the active plugin must be this version or higher.
            'force_activation'   => true, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
            'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins.
            'external_url'       => '', // If set, overrides default API URL and points to an external URL.
        ),
        array(
            'name'               => 'Contact Form 7', // The plugin name.
            'slug'               => 'contact-form-7', // The plugin slug (typically the folder name).
            'source'             => get_stylesheet_directory() . '/inc/plugins/contact-form-7.zip', // The plugin source.
            'required'           => true, // If false, the plugin is only 'recommended' instead of required.
            'version'            => '', // E.g. 1.0.0. If set, the active plugin must be this version or higher.
            'force_activation'   => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
            'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins.
            'external_url'       => '', // If set, overrides default API URL and points to an external URL.
        ), 
        array(
            'name'               => 'Really simple captcha', // The plugin name.
            'slug'               => 'really-simple-captcha', // The plugin slug (typically the folder name).
            'source'             => get_stylesheet_directory() . '/inc/plugins/really-simple-captcha.zip', // The plugin source.
            'required'           => true, // If false, the plugin is only 'recommended' instead of required.
            'version'            => '', // E.g. 1.0.0. If set, the active plugin must be this version or higher.
            'force_activation'   => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
            'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins.
            'external_url'       => '', // If set, overrides default API URL and points to an external URL.
        ), 
        array(
            'name'               => 'Revolution Slider', // The plugin name.
            'slug'               => 'revslider', // The plugin slug (typically the folder name).
            'source'             => get_stylesheet_directory() . '/inc/plugins/revslider.zip', // The plugin source.
            'required'           => true, // If false, the plugin is only 'recommended' instead of required.
            'version'            => '', // E.g. 1.0.0. If set, the active plugin must be this version or higher.
            'force_activation'   => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
            'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins.
            'external_url'       => '', // If set, overrides default API URL and points to an external URL.
        ), 
        array(
            'name'               => 'MailChimp for WordPress', // The plugin name.
            'slug'               => 'mailchimp-for-wp', // The plugin slug (typically the folder name).
            'source'             => get_stylesheet_directory() . '/inc/plugins/mailchimp-for-wp.zip', // The plugin source.
            'required'           => true, // If false, the plugin is only 'recommended' instead of required.
            'version'            => '', // E.g. 1.0.0. If set, the active plugin must be this version or higher.
            'force_activation'   => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
            'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins.
            'external_url'       => '', // If set, overrides default API URL and points to an external URL.
        ), 
        array(
            'name'               => 'Simple Page Sidebars', // The plugin name.
            'slug'               => 'simple-page-sidebars', // The plugin slug (typically the folder name).
            'source'             => get_stylesheet_directory() . '/inc/plugins/simple-page-sidebars.zip', // The plugin source.
            'required'           => true, // If false, the plugin is only 'recommended' instead of required.
            'version'            => '', // E.g. 1.0.0. If set, the active plugin must be this version or higher.
            'force_activation'   => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
            'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins.
            'external_url'       => '', // If set, overrides default API URL and points to an external URL.
        ), 
        array(
            'name'               => 'Cubefolio', // The plugin name.
            'slug'               => 'cubeportfolio', // The plugin slug (typically the folder name).
            'source'             => get_stylesheet_directory() . '/inc/plugins/cubeportfolio.zip', // The plugin source.
            'required'           => true, // If false, the plugin is only 'recommended' instead of required.
            'version'            => '', // E.g. 1.0.0. If set, the active plugin must be this version or higher.
            'force_activation'   => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
            'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins.
            'external_url'       => '', // If set, overrides default API URL and points to an external URL.
        ), 
        array(
            'name'               => 'Spots', // The plugin name.
            'slug'               => 'spots', // The plugin slug (typically the folder name).
            'source'             => get_stylesheet_directory() . '/inc/plugins/spots.zip', // The plugin source.
            'required'           => false, // If false, the plugin is only 'recommended' instead of required.
            'version'            => '', // E.g. 1.0.0. If set, the active plugin must be this version or higher.
            'force_activation'   => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
            'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins.
            'external_url'       => '', // If set, overrides default API URL and points to an external URL.
        ), 
 
    );
 
    /**
     * Array of configuration settings. Amend each line as needed.
     * If you want the default strings to be available under your own theme domain,
     * leave the strings uncommented.
     * Some of the strings are added into a sprintf, so see the comments at the
     * end of each line for what each argument will be.
     */
    $config = array(
        'default_path' => '',                      // Default absolute path to pre-packaged plugins.
        'menu'         => 'tgmpa-install-plugins', // Menu slug.
        'has_notices'  => true,                    // Show admin notices or not.
        'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
        'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
        'is_automatic' => false,                   // Automatically activate plugins after installation or not.
        'message'      => '',                      // Message to output right before the plugins table.
        'strings'      => array(
            'page_title'                      => __( 'Install Required Plugins', 'tgmpa' ),
            'menu_title'                      => __( 'Install Plugins', 'tgmpa' ),
            'installing'                      => __( 'Installing Plugin: %s', 'tgmpa' ), // %s = plugin name.
            'oops'                            => __( 'Something went wrong with the plugin API.', 'tgmpa' ),
            'notice_can_install_required'     => _n_noop( 'This theme requires the following plugin: %1$s.', 'This theme requires the following plugins: %1$s.' ), // %1$s = plugin name(s).
            'notice_can_install_recommended'  => _n_noop( 'This theme recommends the following plugin: %1$s.', 'This theme recommends the following plugins: %1$s.' ), // %1$s = plugin name(s).
            'notice_cannot_install'           => _n_noop( 'Sorry, but you do not have the correct permissions to install the %s plugin. Contact the administrator of this site for help on getting the plugin installed.', 'Sorry, but you do not have the correct permissions to install the %s plugins. Contact the administrator of this site for help on getting the plugins installed.' ), // %1$s = plugin name(s).
            'notice_can_activate_required'    => _n_noop( 'The following required plugin is currently inactive: %1$s.', 'The following required plugins are currently inactive: %1$s.' ), // %1$s = plugin name(s).
            'notice_can_activate_recommended' => _n_noop( 'The following recommended plugin is currently inactive: %1$s.', 'The following recommended plugins are currently inactive: %1$s.' ), // %1$s = plugin name(s).
            'notice_cannot_activate'          => _n_noop( 'Sorry, but you do not have the correct permissions to activate the %s plugin. Contact the administrator of this site for help on getting the plugin activated.', 'Sorry, but you do not have the correct permissions to activate the %s plugins. Contact the administrator of this site for help on getting the plugins activated.' ), // %1$s = plugin name(s).
            'notice_ask_to_update'            => _n_noop( 'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.', 'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.' ), // %1$s = plugin name(s).
            'notice_cannot_update'            => _n_noop( 'Sorry, but you do not have the correct permissions to update the %s plugin. Contact the administrator of this site for help on getting the plugin updated.', 'Sorry, but you do not have the correct permissions to update the %s plugins. Contact the administrator of this site for help on getting the plugins updated.' ), // %1$s = plugin name(s).
            'install_link'                    => _n_noop( 'Begin installing plugin', 'Begin installing plugins' ),
            'activate_link'                   => _n_noop( 'Begin activating plugin', 'Begin activating plugins' ),
            'return'                          => __( 'Return to Required Plugins Installer', 'tgmpa' ),
            'plugin_activated'                => __( 'Plugin activated successfully.', 'tgmpa' ),
            'complete'                        => __( 'All plugins installed and activated successfully. %s', 'tgmpa' ), // %s = dashboard link.
            'nag_type'                        => 'updated' // Determines admin notice type - can only be 'updated', 'update-nag' or 'error'.
        )
    );
 
    tgmpa( $plugins, $config );
 
}

/**
 * Configure the SiteOrigin page builder settings.
 * 
 * @param $settings
 * @return mixed
 */


/**
 * Add row styles.
 *
 * @param $styles
 * @return mixed
 */
function dikka_panels_row_styles($styles) {
    $styles['wide'] = __('Wide', 'dikka');
    $styles['container'] = __('Container', 'dikka');
    $styles['overlay'] = __('Image Overlay', 'dikka');
    $styles['parallax'] = __('Parallax', 'dikka');
    $styles['parallax-wide'] = __('Parallax Wide', 'dikka');
    $styles['parallax-overlay'] = __('Parallax Overlay', 'dikka');
    $styles['parallax-overlay-wide'] = __('Parallax Overlay Wide', 'dikka');
    $styles['video'] = __('Video background Overlay', 'dikka');
    $styles['video-wide'] = __('Video background Overlay Wide', 'dikka');
    return $styles;
}
add_filter('siteorigin_panels_row_styles', 'dikka_panels_row_styles');


function dikka_panels_row_style_fields($fields) {

    $fields['background_image'] = array(
        'name' => __('Background Image', 'dikka'),
        'type' => 'text',
    );

    $fields['background_image_repeat'] = array(
        'name' => __('Repeat Background Image', 'dikka'),
        'type' => 'checkbox',
    );

    $fields['background'] = array(
        'name' => __('Background Color', 'vantage'),
        'type' => 'color',
    );

    $fields['overlay'] = array(
        'name' => __('Overlay Color', 'vantage'),
        'type' => 'color',
    );

    $fields['overlay_percentage'] = array(
        'name' => __('Overlay Percentage', 'dikka'),
        'type' => 'text',
    );

    $fields['extra_top_margin'] = array(
        'name' => __('Extra Top Margin', 'dikka'),
        'type' => 'text',
    );

    $fields['extra_bottom_margin'] = array(
        'name' => __('Extra Bottom Margin', 'dikka'),
        'type' => 'text',
    );

    $fields['div_id'] = array(
        'name' => __('ID for Section/div', 'dikka'),
        'type' => 'text',
    );

    return $fields;
}
add_filter('siteorigin_panels_row_style_fields', 'dikka_panels_row_style_fields');

function dikka_panels_panels_row_style_attributes($attr, $style) {
    $attr['style'] = '';
     if(!empty($style['overlay'])){
    $attr['overlay'] = '';
    $style['overlay_percentage']=$style['overlay_percentage']/100;
     $hex = str_replace("#", "", esc_attr($style['overlay']));

           if(strlen($hex) == 3) {
              $r = hexdec(substr($hex,0,1).substr($hex,0,1));
              $g = hexdec(substr($hex,1,1).substr($hex,1,1));
              $b = hexdec(substr($hex,2,1).substr($hex,2,1));
           } else {
              $r = hexdec(substr($hex,0,2));
              $g = hexdec(substr($hex,2,2));
              $b = hexdec(substr($hex,4,2));
           }
    $new_custom_color = array($r, $g, $b);
    $new_custom_color=implode(',',$new_custom_color);
    $new_custom_color='rgba('.$new_custom_color.','.$style['overlay_percentage'].')';
    }
    if(!empty($style['div_id']))  $attr['id'] = esc_attr($style['div_id']);
    if(!empty($style['top_border'])) $attr['style'] .= 'border-top: 1px solid '.esc_attr($style['top_border']).'; ';
    if(!empty($style['bottom_border'])) $attr['style'] .= 'border-bottom: 1px solid '.esc_attr($style['bottom_border']).'; ';
    if(!empty($style['background'])) $attr['style'] .= 'background-color: '.esc_attr($style['background']).'; ';
    if(!empty($style['overlay'])) $attr['overlay'] .= 'background-color: '.esc_attr($new_custom_color).'; ';
    if(!empty($style['background_image'])) $attr['style'] .= 'background-image: url('.esc_url($style['background_image']).');background-position:50% 50%; ';
    if(!empty($style['background_image_repeat'])) $attr['style'] .= 'background-repeat: repeat; ';
    if(!empty($style['extra_top_margin'])) $attr['style'] .= 'padding-top: '.esc_attr($style['extra_top_margin']).'px; ';
    if(!empty($style['extra_bottom_margin'])) $attr['style'] .= 'padding-bottom: '.esc_attr($style['extra_bottom_margin']).'px; ';

    if(empty($attr['style'])) unset($attr['style']);
    return $attr;
}
add_filter('siteorigin_panels_row_style_attributes', 'dikka_panels_panels_row_style_attributes', 10, 2);


function dikka_comment($comment, $args, $depth) {
    $GLOBALS['comment'] = $comment;
    extract($args, EXTR_SKIP);

    if ( 'div' == $args['style'] ) {
        $tag = 'div';
        $add_below = 'comment';
    } else {
        $tag = 'li';
        $add_below = 'div-comment';
    }
?>
    <<?php echo $tag ?> <?php comment_class( empty( $args['has_children'] ) ? '' : 'parent' ) ?> id="comment-<?php comment_ID() ?>">
    <?php if ( 'div' != $args['style'] ) : ?>
    <div id="div-comment-<?php comment_ID() ?>" class="comment-body">
    <?php endif; ?>
    <article class="comment">

    <div class="comment-author vcard">
    <?php if ( $args['avatar_size'] != 0 ) echo get_avatar( $comment, $args['avatar_size'] ); ?>
    <?php printf( __( '<cite class="fn">%s</cite>' ), get_comment_author_link() ); ?>
    </div>


    <div class="comment-block">
    <?php if ( $comment->comment_approved == '0' ) : ?>
        <em class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.','dikka' ); ?></em>
        <br />
    <?php endif; ?>
    <?php comment_text(); ?>

        <div class="metas">
            <div class="date">
                <p><i class="fa fa-calendar"></i> <?php
                /* translators: 1: date, 2: time */
                printf( __('%1$s at %2$s','dikka'), get_comment_date(),  get_comment_time() ); ?></a><?php edit_comment_link( __( '(Edit)','dikka' ), '  ', '' );
            ?></p> 
            </div>
            
            <div class="comments">
                <a class="comment-reply-link" href="#"><i class="fa fa-plus"></i> REPLY</a>
            </div><!-- .reply -->
    </div>
    
    </div>

    </article>



   
    <?php if ( 'div' != $args['style'] ) : ?>
    </div>
    <?php endif; ?>
<?php
}

/* Code for popular post widget*/
class WP_Widget_Post_Tabs_Dikka extends WP_Widget {

    function __construct() {
        $widget_ops = array('classname' => 'widget_recent_entries', 'description' => __( "A tab showing recent,popluar and random posts in sidebar.","flatty") );
        parent::__construct('popular-posts-dikka', __('Post Tabs (Dikka)','dikka'), $widget_ops);
        $this->alt_option_name = 'widget_post_tabs';

        add_action( 'save_post', array($this, 'flush_widget_cache') );
        add_action( 'deleted_post', array($this, 'flush_widget_cache') );
        add_action( 'switch_theme', array($this, 'flush_widget_cache') );
    }

    function widget($args, $instance) {
        $cache = wp_cache_get('widget_post_tabs', 'widget');

        if ( !is_array($cache) )
            $cache = array();

        if ( ! isset( $args['widget_id'] ) )
            $args['widget_id'] = $this->id;

        if ( isset( $cache[ $args['widget_id'] ] ) ) {
            echo $cache[ $args['widget_id'] ];
            return;
        }

        ob_start();
        extract($args);
        
        $title='';
        echo $before_widget; 
        $number = ( ! empty( $instance['number'] ) ) ? absint( $instance['number'] ) : 2;
        ?>
        <div id="blog-tabs">
        <ul class="tabs">
                            <li id="tab_two1"><?php echo __('Popular','dikka');?></li>
                            <li id="tab_two2"><?php echo __('Recent','dikka');?></li>
                            <li id="tab_two3"><?php echo __('Random','dikka');?></li>
        </ul>
        
        <div class="contents">
            <div id="content_two1" class="tabscontent">
            <ul class="posts">
        <?php
        $r = new WP_Query( apply_filters( 'widget_posts_args', array( 'posts_per_page' => $number, 'orderby' => 'comment_count','no_found_rows' => true, 'post_status' => 'publish', 'ignore_sticky_posts' => true ) ) );
        if ($r->have_posts()) :
        ?>
            
            <?php while ( $r->have_posts() ) : $r->the_post(); ?>
                <li>
                      <a href="<?php the_permalink(); ?>"><?php echo get_the_post_thumbnail($r->post->ID,array(70,70));?></a>
                      <p><a href="<?php the_permalink(); ?>"><?php get_the_title() ? the_title() : the_ID(); ?></a></p>
                      <div class="date">
                          <p><i class="fa fa-calendar"></i> <?php the_time('F jS, Y') ?> <i class="fa fa-comment"></i> <?php comments_number('0','1','%'); ?></p>
                          <div class="inner_text">
                          <?php echo substr(get_the_excerpt(), 0,90).' ...'; ?>
                          </div>
                      </div>
                      
                </li>
            <?php endwhile; ?>
        <?php echo $after_widget; ?>
        <?php
        // Reset the global $the_post as this query will have stomped on it
        wp_reset_postdata();
        endif;
        ?>
            </ul>
            <div id="content_two2" class="tabscontent">
            <ul class="posts">
        <?php
        $r = new WP_Query( apply_filters( 'widget_posts_args', array( 'posts_per_page' => $number, 'no_found_rows' => true, 'post_status' => 'publish', 'ignore_sticky_posts' => true ) ) );
        if ($r->have_posts()) :
        ?>

            <?php while ( $r->have_posts() ) : $r->the_post(); ?>
                <li>
                      <a href="<?php the_permalink(); ?>"><?php echo get_the_post_thumbnail($r->post->ID,array(70,70));?></a>
                      <p><a href="<?php the_permalink(); ?>"><?php get_the_title() ? the_title() : the_ID(); ?></a></p>
                      <div class="date">
                          <p><i class="fa fa-calendar"></i> <?php the_time('F jS, Y') ?> <i class="fa fa-comment"></i> <?php comments_number('0','1','%'); ?></p>
                          <div class="inner_text">
                          <?php echo substr(get_the_excerpt(), 0,90).' ...'; ?>
                          </div>
                      </div>
                      
                </li>
            <?php endwhile; ?>
            
        <?php echo $after_widget; ?>
        <?php
        // Reset the global $the_post as this query will have stomped on it
        wp_reset_postdata();
        endif;
        ?>
        </ul>

        <div id="content_two3" class="tabscontent">
            <ul class="posts">
        
                <?php
        $r = new WP_Query( apply_filters( 'widget_posts_args', array( 'posts_per_page' => $number, 'orderby' => 'rand','no_found_rows' => true, 'post_status' => 'publish', 'ignore_sticky_posts' => true ) ) );
        if ($r->have_posts()) :
        ?>
            
            <?php while ( $r->have_posts() ) : $r->the_post(); ?>
                <li>
                      <a href="<?php the_permalink(); ?>"><?php echo get_the_post_thumbnail($r->post->ID,array(70,70));?></a>
                      <p><a href="<?php the_permalink(); ?>"><?php get_the_title() ? the_title() : the_ID(); ?></a></p>
                      <div class="date">
                          <p><i class="fa fa-calendar"></i> <?php the_time('F jS, Y') ?> <i class="fa fa-comment"></i> <?php comments_number('0','1','%'); ?></p>
                          <div class="inner_text">
                          <?php echo substr(get_the_excerpt(), 0,90).' ...'; ?>
                          </div>
                      </div>
                      
                </li>
            <?php endwhile; ?>
           
        <?php echo $after_widget; ?>
        <?php
        // Reset the global $the_post as this query will have stomped on it
        wp_reset_postdata();
        endif;
        ?>
         </ul>
        </div>
        </div>
        <?php echo $after_widget; ?>
        <?php
        $cache[$args['widget_id']] = ob_get_flush();
        wp_cache_set('widget_recent_posts', $cache, 'widget');
    }

    function update( $new_instance, $old_instance ) {
        $instance = $old_instance;
        $instance['number'] = (int) $new_instance['number'];
       $this->flush_widget_cache();

        $alloptions = wp_cache_get( 'alloptions', 'options' );
        if ( isset($alloptions['widget_recent_entries']) )
            delete_option('widget_recent_entries');

        return $instance;
    }

    function flush_widget_cache() {
        wp_cache_delete('widget_recent_posts', 'widget');
    }

    function form( $instance ) {
        $number    = isset( $instance['number'] ) ? absint( $instance['number'] ) : 2;
        ?>
        <p><label for="<?php echo $this->get_field_id( 'number' ); ?>"><?php _e( 'Number of posts to show:','flatty' ); ?></label>
        <input id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" type="text" value="<?php echo $number; ?>" size="3" /></p>
    <?php
    }   
}
register_widget('WP_Widget_Post_Tabs_Dikka');

add_filter('loop_shop_columns', 'dikka_product_loop_columns');
function dikka_product_loop_columns() {
    return 3; // 3 products per row
}

add_filter( 'loop_shop_per_page', create_function( '$cols', 'return 9;' ), 20 );

add_filter( 'cmb_meta_boxes', 'dikka_cmb_metaboxes' );
/**
 * Define the metabox and field configurations.
 *
 * @param  array $meta_boxes
 * @return array
 */
function dikka_cmb_metaboxes( array $meta_boxes ) {

    $prefix = 'dikka_';

     $meta_boxes['page_metabox'] = array(
        'id'         => 'page_metabox',
        'title'      => __( 'Dikka Page Settings', 'dikka' ),
        'pages'      => array( 'page', ), // Post type
        'context'    => 'normal',
        'priority'   => 'high',
        'show_names' => true, // Show field names on the left
        'fields'     => array(

            array(
                'name' => 'Activate Page Title ',
                'desc' => 'Do you want to enable inner page settings.',
                'id' => $prefix . 'pagetitle_activate',
                'type' => 'checkbox'
            ),

           array(
                'name'    => __( 'Page Title Color', 'dikka' ),
                'id'      => $prefix . 'pagetitle_color',
                'type'    => 'colorpicker',
            ),


           array(
                'name'    => __( 'Page Title Background Color', 'dikka' ),
                'id'      => $prefix . 'pagetitle_bgcolor',
                'type'    => 'colorpicker',
            ),

           array(
                'name' => __( 'Page tite Background', 'dikka' ),
                'desc' => __( 'Upload an image or enter a URL.', 'dikka' ),
                'id'   => $prefix . 'pagetitle_image',
                'type' => 'file',
            ),

            array(
                'name'    => 'Page Title Align',
                'desc'    => 'Select an align option',
                'id'      => $prefix . 'pagetitle_align',
                'type'    => 'select',
                'options' => array(
                    'left' => __( 'Left Align', 'dikka' ),
                    'right'   => __( 'Right Align', 'dikka' ),
                    'center'     => __( 'Center Align', 'dikka' ),
                ),
                'default' => 'left',
            ),

            array(
                'name' => 'Page Title Line',
                'desc' => 'Display page line below title',
                'id' => $prefix . 'pagetitle_line',
                'type' => 'checkbox'
            ),

            array(
                'name' => 'Extra Top margin',
                'desc' => 'Add extra margin on top',
                'id' => $prefix . 'pagetitle_topmargin',
                'type' => 'text'
            ),

            array(
                'name' => 'Extra Bottom margin',
                'desc' => 'Add extra margin on bottom',
                'id' => $prefix . 'pagetitle_bottommargin',
                'type' => 'text'
            ),

            array(
                'name' => 'Page Title Parallax Background',
                'desc' => 'Add parallax background on page title background',
                'id' => $prefix . 'pagetitle_parallax',
                'type' => 'checkbox'
            ),

           
        )
    );

 
    $meta_boxes['menu_metabox'] = array(
        'id'         => 'menu_metabox',
        'title'      => __( 'Menu Option', 'dikka' ),
        'pages'      => array( 'page', ), // Post type
        'context'    => 'side',
        'priority'   => 'high',
        'show_names' => true, // Show field names on the left
        'fields'     => array(
            array(
                'name'     => __( 'Menus', 'dikka' ),
                'desc'     => __( 'Select menu for this page', 'dikka' ),
                'id'       => $prefix . 'menu_select',
                'type'     => 'taxonomy_select',
                'taxonomy' => 'nav_menu', // Taxonomy Slug
                'default' => 'dikka-main-menu',
            ),
        )
    );

    return $meta_boxes;
}


function woocommerce_header_add_to_cart_fragment( $fragments ) {
    global $woocommerce;
    ob_start();
    ?>
    <div class="dikka_dynamic_shopping_bag">
        <div class="dikka_little_shopping_bag_wrapper">
            <div class="dikka_little_shopping_bag" style="background: transparent !important;">
                <div class="title">
                    <i class="fa fa-shopping-cart"></i>
                </div>
                <div class="overview"><?php echo $woocommerce->cart->get_cart_total(); ?> <span class="minicart_items">/ <?php echo sprintf(_n('%d item', '%d items', $woocommerce->cart->cart_contents_count, 'dikka'), $woocommerce->cart->cart_contents_count); ?></span></div>
            </div>
            <div class="dikka_minicart_wrapper">
                <div class="dikka_minicart">
                <?php
                echo '<ul class="cart_list">';
                    if (sizeof($woocommerce->cart->cart_contents)>0) : foreach ($woocommerce->cart->cart_contents as $cart_item_key => $cart_item) :
                        $_product = $cart_item['data'];
                        if ($_product->exists() && $cart_item['quantity']>0) :                                            
                            echo '<li class="cart_list_product">';
                                echo '<a class="cart_list_product_img" href="'.get_permalink($cart_item['product_id']).'">' . $_product->get_image().'</a>';
                                echo '<div class="cart_list_product_title">';
                                    $dikka_product_title = $_product->get_title();
                                    $dikka_short_product_title = (strlen($dikka_product_title) > 28) ? substr($dikka_product_title, 0, 25) . '...' : $dikka_product_title;
                                    echo '<a href="'.get_permalink($cart_item['product_id']).'">' . apply_filters('woocommerce_cart_widget_product_title', $dikka_short_product_title, $_product) . '</a>';
                                    echo '<div class="cart_list_product_quantity">'.__('Quantity:', 'dikka').' '.$cart_item['quantity'].'</div>';
                                echo '</div>';
                                echo apply_filters( 'woocommerce_cart_item_remove_link', sprintf('<a href="%s" class="remove" title="%s">&times;</a>', esc_url( $woocommerce->cart->get_remove_url( $cart_item_key ) ), __('Remove this item', 'dikka') ), $cart_item_key );
                                echo '<div class="cart_list_product_price">'.woocommerce_price($_product->get_price()).'</div>';
                                echo '<div class="clr"></div>';
                            echo '</li>';
                        endif;
                    endforeach;
                    ?>
                    <div class="minicart_total_checkout">
                        <?php _e('Cart subtotal', 'dikka'); ?><span><?php echo $woocommerce->cart->get_cart_total(); ?></span>
                    </div>
                    <a href="<?php echo esc_url( $woocommerce->cart->get_cart_url() ); ?>" class="button dikka_minicart_cart_but"><?php _e('View Shopping Bag', 'dikka'); ?></a>
                    <a href="<?php echo esc_url( $woocommerce->cart->get_checkout_url() ); ?>" class="button dikka_minicart_checkout_but"><?php _e('Proceed to Checkout', 'dikka'); ?></a>
                    <?php                                    
                    else: echo '<li class="empty">'.__('No products in the cart.','woothemes').'</li>'; endif;
                echo '</ul>';
                ?>
                </div>
            </div>
        </div>
        <a href="<?php echo esc_url( $woocommerce->cart->get_cart_url() ); ?>" class="dikka_little_shopping_bag_wrapper_mobiles"><span><?php echo $woocommerce->cart->cart_contents_count; ?></span></a>
        <script type="text/javascript">
	        jQuery(document).ready(function(){	
	
				"use strict";
		        jQuery(".dikka_little_shopping_bag_wrapper").on("mouseenter mouseover", function() {
			
					if(!jQuery(this).data('init')){
			            jQuery(this).data('init', true);
			            jQuery(this).hover(
			                function(){
								jQuery('.dikka_minicart_wrapper').fadeIn(200);
			                },
			                function(){
			                    jQuery('.dikka_minicart_wrapper').fadeOut(200);
			                    
			                }
			            );
			            jQuery(this).trigger('mouseenter');
			        }
				});
				jQuery("ul.cart_list li").mouseenter(function(){
					jQuery(this).children('.remove').fadeIn(0);
				}).mouseleave(function(){
					jQuery(this).children('.remove').fadeOut(0);
				});	
			});	
        </script>
        
        
    </div>
    <?php
    $fragments['div.dikka_dynamic_shopping_bag' ] = ob_get_clean();
    return $fragments;

}

function removeDemoModeLink() {
    if ( class_exists('ReduxFrameworkPlugin') ) {
        remove_filter( 'plugin_row_meta', array( ReduxFrameworkPlugin::get_instance(), 'plugin_metalinks'), null, 2 );
    }
    if ( class_exists('ReduxFrameworkPlugin') ) {
        remove_action('admin_notices', array( ReduxFrameworkPlugin::get_instance(), 'admin_notices' ) );    
    }
}

add_action( 'init', 'dikka_initialize_cmb_meta_boxes', 9999 );
/**
 * Initialize the metabox class.
 */
function dikka_initialize_cmb_meta_boxes() {

    if ( ! class_exists( 'cmb_Meta_Box' ) )
        require_once 'inc/cmb/init.php';

}

add_filter( 'woocommerce_enqueue_styles', '__return_false' );

function dikka_detect_woocommerce()
{
    global $post;
    if ( has_shortcode( $post->post_content, 'woocommerce_cart' ) || has_shortcode( $post->post_content, 'woocommerce_my_account' ) || has_shortcode( $post->post_content, 'woocommerce_checkout' ))
    {
        return true;
    } 
    return false;
}