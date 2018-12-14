<?php // Exit if accessed directly
if (!defined('ABSPATH')) {echo '<h1>Forbidden</h1>'; exit();} get_header(); ?>


<section id="blog-normal" class="light-section nopaddingbottom blog-normal">
            
            <!-- BEGIN BLOG WIDTH | OPTION: "big", "medium" container -->
            <div class="container"> 
                
                <!-- BEGIN BLOG POSTS -->       
                <div class="journal col-xs-12 col-sm-12 col-md-9">
                 <div id="post-<?php the_ID(); ?>" <?php post_class("journal-post"); ?>>
                <?php  woocommerce_content(); ?>   
                </div>
                </div>
                <!-- END journal -->
                
                <!-- START SIDEBAR -->
                <div class="col-xs-12 col-sm-12 col-md-3 sbd">
                <?php
                if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('dikka-widgets-woocommerce-sidebar')) :
                 _e ('add widgets here', 'dikka');
                endif;
                ?>
                   
                </div>
                
        
            </div>  
            <!-- END: BLOG CONTAINER -->
        </section>



<?php get_footer(); ?>