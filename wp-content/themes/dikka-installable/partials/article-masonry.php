<?php // Exit if accessed directly
if (!defined('ABSPATH')) {echo '<h1>Forbidden</h1>'; exit();} ?>

<?php
$class="journal-post isotope-item ";
if (has_post_format('quote')):
$class="journal-post isotope-item p-quote"; 
endif;
?> 
                    <div id="post-<?php the_ID(); ?>" <?php post_class($class); ?>>
                        <div class="post-content fadeInUpBig">

                              <?php 
                                if ( has_post_format('gallery')) : 
                                        echo get_post_gallery(); 
                                endif;  ?>

                                 <?php if (has_post_format('quote')) :  ?>
                                     <div class="post-quote">
                                <blockquote><i class="fa fa-quote-left"></i> <?php echo  the_content(); ?></blockquote>
                                <span class="author-quote"> - <?php echo esc_attr(get_post_meta( $post->ID, 'q_author', true )); ?></span>
                                </div>
                                 <?php else : ?>
                            <!-- Featured image -->
                            <div class="featured-image">

                                 <?php if (has_post_thumbnail() && (!is_single() || !is_page())) :
                                    // Get attached file guid
                                    $att = get_post_meta(get_the_ID(),'_thumbnail_id',true);
                                    $thumb = get_post($att);
                                    if (is_object($thumb)) { $att_ID = $thumb->ID; $att_url = $thumb->guid; }
                                    else { $att_ID = $post->ID; $att_url = $post->guid; }
                                    $att_title = (!empty(get_post($att_ID)->post_excerpt)) ? get_post($att_ID)->post_excerpt : get_the_title($att_ID);
                                    ?>
                                    
                                    <a href="<?php the_permalink(); ?>">
                                        <?php echo get_the_post_thumbnail(get_the_ID(), 'large', array('class' => 'image-blog')); ?>
                                    

                                <?php endif; ?>

                                <?php if (has_post_format('video')) : ?>
                                 <div class="post-video">
                                <div class="video-thumb">
                                    <div class="video-wrapper">
                                        <?php
                                $videoID = get_post_meta( $post->ID, 'video_id', true ); 
                                echo wp_oembed_get(  $videoID ); 

                                ?> </div></div></div>
                                 <?php endif; ?>
                                 
                                 <?php if (has_post_format('audio')) : ?>
                                 <div class="post-video">
                                <div class="video-thumb">
                                    <div class="video-wrapper">
                                        <?php
                                $audioID = get_post_meta( $post->ID, 'audio_id', true ); 
                                echo wp_oembed_get(  $audioID ); 

                                ?> </div></div></div>
                                 <?php endif; ?>


                               
                                
                            </div>
                            
                            <h2 class="post-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
    
                            <div class="post-summary">
                                <p>   
                                <?php // If displaying a single post or a page
                                if (is_single() OR is_page()) :

                                    if(has_post_format('gallery')):
                                    $postContentStr = apply_filters('the_content', strip_shortcodes($post->post_content));
                                        echo $postContentStr;
                                    else:
                                    the_content();
                                    endif;

                                    wp_link_pages(array(
                                        'next_or_number' => 'number',
                                        'nextpagelink' => __('Next page', 'dikka'),
                                        'previouspagelink' => __('Previous page', 'dikka'),
                                        'pagelink' => '%',
                                        'link_before' => '<span class="ft-btn">',
                                        'link_after' => '</span>',
                                        'before' => '<div class="clearfix"></div>' . __('Pages:', 'dikka') . ' <div class="ft-article-pages">',
                                        'after' => '</div>'
                                    ));

                                else :

                                    
                                    if (has_post_format('link') ):
                                        the_content();
                                    else:
                                        the_excerpt ();
                                    endif;

                                   

                                endif;
                                ?></p>
                            </div>
                            
                             <?php if (!is_page()) : ?>                            
                            <!-- Begin Metas -->
                            <div class="metas">
                                <div class="post-type no-readmore">
                                    <?php if (has_post_format('image')) :  ?>
                                    <i class="fa fa-image"></i>
                                    <?php elseif (has_post_format('video')) : ?>
                                    <i class="fa fa-film"></i>
                                    <?php elseif (has_post_format('gallery')) :  ?>
                                    <i class="fa fa-picture-o"></i>
                                    <?php elseif (has_post_format('audio')) :  ?>
                                    <i class="fa fa-volume-up"></i>
                                    <?php elseif (has_post_format('link')) :  ?>
                                    <i class="fa fa-link"></i>
                                    <?php else :  ?>
                                    <i class="fa fa-pencil"></i>
                                    <?php endif; ?>


                                </div>
                                
                                <div class="date">
                                    <p><i class="fa fa-calendar"></i> <?php echo get_the_date('M, d, Y') ?></p>
                                </div>
                                <div class="tags">
                                      <?php
                                        // Tags
                                        if (get_the_tags()) : ?>
                                            <i class="fa fa-tags"></i>&nbsp;<?php the_tags('',',&nbsp;'); ?>
                                        <?php endif; ?>
                                </div>
                                <div class="category">
                                      <?php
                                        // Tags
                                        if (get_the_category()) :
                                        ?>
                                        <i class="fa fa-pencil"></i>&nbsp;
                                        <?php the_category(', ');
                                        endif; ?>
                                </div>
                                <div class="comments">
                                    <p><i class="fa fa-comment"></i> <?php comments_number('0','1','%'); ?></p>
                                </div>
                            </div>
                            <!-- end metas -->
                        <?php endif;?>
                        <?php endif;?>
                        </div>
                    </div><!-- #post -->
               