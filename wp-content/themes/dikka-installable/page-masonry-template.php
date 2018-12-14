<?php
/*
 * Template Name: Blog Masonry Template
 *
 */
// Exit if accessed directly
if (!defined('ABSPATH')) {echo '<h1>Forbidden</h1>'; exit();} get_header(); ?>
<?php query_posts('post_type=post&post_status=publish&paged='. get_query_var('paged')); ?>

<section id="blog" class="grey-section nopaddingbottom ">
            
            <!-- BEGIN BLOG WIDTH | OPTION: "big", "medium" container -->
            <div class="container"> 
                
                <!-- BEGIN BLOG POSTS -->       
                <div class="journal iso isotope" data-columns="3" data-gutter-space="0.25">
                     <?php if (have_posts()) : ?>

                        <?php while (have_posts()) : the_post(); ?>

                            <?php get_template_part('partials/article-masonry'); ?>
                          
                        <?php endwhile; ?>

                    <?php else : ?>

                        <?php get_template_part('partials/nothing-found'); ?>

                    <?php endif; ?>
  
                </div>
                <div class="center-elements">
                <?php if ($wp_query->max_num_pages>1) : ?>

                            <?php dikka_pagination(); ?>

                        <?php endif; ?>
                    </div>
                <!-- END journal -->

        
            </div>  
            <!-- END: BLOG CONTAINER -->
        </section>



<?php get_footer(); ?>