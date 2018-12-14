<?php // Exit if accessed directly
if (!defined('ABSPATH')) {echo '<h1>Forbidden</h1>'; exit();} ?>
<!DOCTYPE html>
<?php
global $dikka_options;
 ?>
<html <?php language_attributes(); ?>>
<head>
<meta http-equiv="X-UA-Compatible" content="IE=9" />
<meta charset="<?php bloginfo('charset'); ?>" />
<?php if(isset($dikka_options['meta_author']) && $dikka_options['meta_author']!='') : ?>
<meta name="author" content="<?php echo esc_attr($dikka_options['meta_author']); ?>">	
<?php else: ?>
<meta name="author" content="<?php esc_attr(bloginfo('name')); ?>">
<?php endif; ?>
<?php if(isset($dikka_options['meta_author']) && $dikka_options['meta_desc']!='') : ?>
<meta name="description" content="<?php echo esc_attr($dikka_options['meta_desc']); ?>">	
<?php endif; ?>
<?php if(isset($dikka_options['meta_author']) && $dikka_options['meta_keyword']!='') : ?>
<meta name="keyword" content="<?php echo esc_attr($dikka_options['meta_keyword']); ?>">	
<?php endif; ?>
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=0">
<title><?php
	/*
	 * Print the <title> tag based on what is being viewed.
	 */
	global $page, $paged, $woocommerce;

	wp_title( '|', true, 'right' );

	// Add the blog name.
	bloginfo( 'name' );

	// Add the blog description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		echo " | $site_description";

	// Add a page number if necessary:
	if ( $paged >= 2 || $page >= 2 )
		echo ' | ' . sprintf( __( 'Page %s', 'dikka' ), max( $paged, $page ) );

	?></title>
	
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
<?php if(isset($dikka_options['favicon']['url'])) :  ?>
<link rel="shortcut icon" href="<?php echo esc_url($dikka_options['favicon']['url']); ?>">
<?php endif; ?>

<?php
// WordPress Head
wp_head();
?>
<link href='https://fonts.googleapis.com/css?family=Roboto:400,300,500,700' rel='stylesheet' type='text/css'>
<?php if (substr_count($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip')) ob_start("ob_gzhandler"); else ob_start(); ?>
<script>
function preload(arrayOfImages) {
    $(arrayOfImages).each(function(){
        $('<img/>')[0].src = this;
        // Alternatively you could use:
        // (new Image()).src = this;
    });
}

// Usage:

preload([
    'https://www.financialize.com/wp-content/uploads/2015/10/annuities-plan.png',
    'https://www.financialize.com/wp-content/uploads/2015/10/info-investment.png',
    'https://www.financialize.com/wp-content/uploads/2015/10/annuity-screen.png'
]);
</script>
<script>
$.fn.preload = function() {
    this.each(function(){
        $('<img/>')[0].src = this;
    });
}

// Usage:

$(['https://www.financialize.com/wp-content/uploads/2015/10/annuities-plan.png.jpg','https://www.financialize.com/wp-content/uploads/2015/10/info-investment.png.jpg','https://www.financialize.com/wp-content/uploads/2015/10/annuity-screen.png']).preload();
</script>
<script>
function preloadimages(arr){
    var newimages=[]
    var arr=(typeof arr!="object")? [arr] : arr //force arr parameter to always be an array
    for (var i=0; i<arr.length; i++){
        newimages[i]=new Image()
        newimages[i].src=arr[i]
    }
}
 
//preload 3 images:
preloadimages(['https://www.financialize.com/wp-content/uploads/2015/10/annuities-plan.png', 'https://www.financialize.com/wp-content/uploads/2015/10/info-investment.png', 'https://www.financialize.com/wp-content/uploads/2015/10/annuity-screen.png'])
</script>
<script>
	(function($) {
  var cache = [];
  // Arguments are image paths relative to the current page.
  $.preLoadImages = function() {
    var args_len = arguments.length;
    for (var i = args_len; i--;) {
      var cacheImage = document.createElement('img');
      cacheImage.src = arguments[i];
      cache.push(cacheImage);
    }
  }
})(jQuery)
</script>
</head> 
<!-- BEGIN BODY -->
<body  <?php body_class(); ?>>
 
<?php if ( isset($dikka_options['preloader']) &&  isset($dikka_options['preloader-type']) && $dikka_options['preloader'] == 1 && $dikka_options['preloader-type']=='logo') : ?> 
	<div id="load">
	    <div class="loader-container">
	    	<div class="loading-css"></div>
	    	<?php if(isset($dikka_options['preloader-logo']['url']) && $dikka_options['preloader-logo']['url']!='') : ?>
	        <div class="loader-logo"><img src="<?php echo esc_url($dikka_options['preloader-logo']['url']); ?> "  data-at2x="<?php echo esc_url($dikka_options['preloader-retinalogo']['url']); ?>" alt=""/></div>
	        <?php endif; ?>
	        <?php if($dikka_options['preloader-title']==1): ?>
	        <h6 class="loading-heading"><?php echo esc_attr(get_bloginfo('name')); ?></h6>
	   		<?php endif; ?>
	    </div>
	</div>
<?php endif ; ?>

  	
<!-- BEGIN: FULL CONTENT DIV -->
<div class="full-content"> 

<?php
 // Navbar
get_template_part('partials/navbar');


if (!is_page_template('dikka-page-builder.php') ) :
	if(get_post_type()!='portfolio'):
	get_template_part('partials/breadcrumb');
	endif;
endif;

?>