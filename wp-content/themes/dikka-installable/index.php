<?php // Exit if accessed directly
if (!defined('ABSPATH')) {echo '<h1>Forbidden</h1>'; exit();} get_header(); ?>


<section id="blog-normal" class="light-section nopaddingbottom blog-normal">
            
            <!-- BEGIN BLOG WIDTH | OPTION: "big", "medium" container -->
            <div class="container"> 
                
                <!-- BEGIN BLOG POSTS -->       
                <div class="journal col-xs-12 col-sm-12 col-md-9">
                     <?php if (have_posts()) : ?>

                        <?php while (have_posts()) : the_post(); ?>

                            <?php get_template_part('partials/article'); ?>

                        <?php endwhile; ?>

                        <?php if ($wp_query->max_num_pages>1) : ?>

                            <?php dikka_pagination(); ?>

                        <?php endif; ?>

                    <?php else : ?>

                        <?php get_template_part('partials/nothing-found'); ?>

                    <?php endif; ?>
  
                </div>
                <!-- END journal -->
              
                <!-- START SIDEBAR -->
                <div class="col-xs-12 col-sm-12 col-md-3">
                
                <?php get_sidebar(); ?>
                   
                </div>
                
        
            </div>  
            <!-- END: BLOG CONTAINER -->
        </section>



<?php get_footer(); ?>