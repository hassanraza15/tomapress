<?php
/*
 * Template Name: Page Builder Template with Left Sidebar
 *
 */
// Exit if accessed directly
if (!defined('ABSPATH')) {echo '<h1>Forbidden</h1>'; exit();} get_header(); ?>
<section id="blog-normal" class="light-section nopaddingbottom blog-normal">

<div class="container">
 <div class="builder-siderbar col-xs-12 col-sm-12 col-md-3 sbd">      
 
          <?php if(dikka_detect_woocommerce()==true) : ?>
                <?php dynamic_sidebar('dikka-widgets-woocommerce-sidebar'); ?>
                <?php else : ?>
                <?php get_sidebar(); ?>
                <?php endif; ?>                

</div>

<div class="builder-main col-xs-12 col-sm-12 col-md-9">
<?php if (have_posts()) : ?>

    <?php while (have_posts()) : the_post(); ?>


                <?php the_content(); ?>


      

    <?php endwhile; ?>

<?php else : ?>

    <?php get_template_part('partials/nothing-found'); ?>

<?php endif; ?>
 </div>
</div>
</section>
<?php get_footer(); ?>