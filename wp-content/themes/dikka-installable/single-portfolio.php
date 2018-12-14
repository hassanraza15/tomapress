<?php // Exit if accessed directly
if (!defined('ABSPATH')) {echo '<h1>Forbidden</h1>'; exit();} get_header(); ?>

<section id="blog-normal" class="light-section nopaddingbottom blog-normal">
                
                <!-- BEGIN BLOG POSTS -->       

                     <?php if (have_posts()) : ?>

                        <?php while (have_posts()) : the_post(); ?>

<section id="proj-noajax" class="light-section nopadding">
                        
              <!-- START PROJECT MEDIA -->
            
            <?php if ( get_post_gallery() ) : ?>
            <div class="project-media">    
               <?php echo get_post_gallery(); ?>
            </div>   
            <?php endif; ?>
            

           <!-- END PROJECT MEDIA -->         
           <?php
          $portfolio_item_title = get_the_title( $post->ID ); 
          $portfolio_item_name =esc_attr(get_post_meta( $post->ID, 'portfolio_person_name', true ));
          $portfolio_item_url =esc_url(get_post_meta( $post->ID, 'portfolio_person_url', true ));
          $postContentStr = apply_filters('the_content', strip_shortcodes($post->post_content));
           

           $filters = '';
           $terms = get_the_terms( $post->ID, 'portfolio_filter' );          
            if ( $terms && ! is_wp_error( $terms ) ) : 

                $term_links = array();
                foreach ( $terms as $term ) {
                    $term_links[] = $term->name;
                }
                                    
                $filters = join( " / ", $term_links );
            endif;    
        
            ?>                    
            <!-- BEGIN: PARALLAX CONTENTS -->   
            <div class="dark-text text-center">
                
                <!-- BEGIN: CONTAINER -->
                <div class="container"> 
                    
                    <div class="section-title light">
                        <h1 class="title-open-proj"><?php echo get_the_title();?></h1>
                            
                        <ul class="proj-tags">
                                <li><p><span><?php _e( 'Client','dikka' ); ?></span>: <a href="<?php echo $portfolio_item_url; ?>"><?php echo $portfolio_item_name; ?></a></p></li>
                                <li><p><span><?php _e( 'Categories','dikka' ); ?></span> : <?php echo $filters; ?></p></li>
                        </ul>
                        
                      
                    </div>
                
                </div>
           </div>
        
           <div class="container">  
       
               <p class="small-pwide projnoajax"><?php echo $postContentStr; ?></p>
           
          </div><!-- END CONTAINER -->           

        </section>
                           
                           
                        <?php endwhile; ?>

                        <?php if ($wp_query->max_num_pages>1) : ?>

                            <?php dikka_pagination(); ?>

                        <?php endif; ?>

                    <?php else : ?>

                        <?php get_template_part('partials/nothing-found'); ?>

                    <?php endif; ?>
  
             
                <!-- END journal -->

           
        </section>



<?php get_footer(); ?>