<?php
/*
Template Name: Cube Portfolio default template
*/
// File Security Check
if ( ! defined( 'ABSPATH' ) ) { exit; }

remove_filter( 'the_content', 'wpautop' );

get_header();
?>
<div class="cbp-popup-singlePage">
    <?php while ( have_posts() ) : the_post();
        $metadata = get_metadata( 'post', get_the_ID() ); ?>
        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
            <div class="cbp-l-inline">
                <div class="cbp-l-inline-left">
                    <?php
                    $images = json_decode( $metadata['cbp_project_images'][0] );

                    $is_slider = ($metadata['cbp_project_images_slider'][0] == 'on')? 'class="cbp-slider"' : '';

                    if (count($images)) : ?>
                        <div <?php echo $is_slider; ?>>
                            <div class="cbp-slider-wrap">
                                <?php foreach ($images as $value) : ?>
                                <div class="cbp-slider-item">
                                    <?php if ($metadata['cbp_project_images_lightbox'][0] == 'on') : ?>
                                    <a href="<?php echo wp_get_attachment_url($value->id) ?>" class="cbp-lightbox" data-cbp-lightbox="<?php echo 'gallery_' . get_the_ID(); ?>"><img src="<?php echo wp_get_attachment_url($value->id) ?>" alt="" width="100%"></a>
                                    <?php else : ?>
                                        <img src="<?php echo wp_get_attachment_url($value->id) ?>" alt="" width="100%">
                                    <?php endif; ?>
                                </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="cbp-l-inline-right">
                    <div class="cbp-l-inline-title"><?php the_title(); ?></div>
                    <div class="cbp-l-inline-subtitle"><?php echo $metadata['cbp_project_subtitle'][0]; ?></div>

                    <div class="cbp-l-inline-desc"><?php the_content(); ?></div>

                <?php

                    $categories = get_the_terms( get_the_ID(), 'cubeportfolio_category');
                    $hasDetailes = false;
                    if ( $metadata['cbp_project_details_client'][0] || $metadata['cbp_project_details_date'][0] || $categories != false ) {
                        $hasDetailes = true;
                    }
                    if ($hasDetailes) : ?>
                    <div class="cbp-l-inline-details">
                        <?php if ($metadata['cbp_project_details_client'][0]) : ?>
                        <div><strong><?php _e('Client:', CUBEPORTFOLIO_TEXTDOMAIN); ?></strong> <?php echo $metadata['cbp_project_details_client'][0];?></div>
                        <?php endif; ?>

                        <?php if ($metadata['cbp_project_details_date'][0]) : ?>
                        <div><strong><?php _e('Date:', CUBEPORTFOLIO_TEXTDOMAIN); ?></strong> <?php echo $metadata['cbp_project_details_date'][0];?></div>
                        <?php endif; ?>

                        <?php if ($categories != false) : ?>
                        <div><strong><?php _e('Categories:', CUBEPORTFOLIO_TEXTDOMAIN); ?></strong> <?php the_terms( get_the_ID(), 'cubeportfolio_category'); ?></div>
                        <?php endif; ?>

                    </div>
                <?php endif; ?>

                    <?php if ($metadata['cbp_project_social_fb'][0] == 'on' || $metadata['cbp_project_social_twitter'][0] == 'on' || $metadata['cbp_project_social_google'][0] == 'on') : ?>
                    <br>
                    <?php endif; ?>

                    <?php if ($metadata['cbp_project_social_fb'][0] == 'on') : ?>
                    <div class="cbp-l-inline-social-wrapper">
                        <iframe src="http://www.facebook.com/plugins/like.php?href=<?php echo the_permalink(); ?>&amp;layout=button_count&amp;show_faces=false&amp;action=like&amp;colorscheme=light" scrolling="no" frameborder="0" allowTransparency="true" height="20" style="border: 0; overflow: hidden;"></iframe>
                    </div>
                    <?php endif; ?>

                    <?php if ($metadata['cbp_project_social_twitter'][0] == 'on') : ?>
                    <div class="cbp-l-inline-social-wrapper">
                        <iframe src="https://platform.twitter.com/widgets/tweet_button.html?url=<?php echo the_permalink(); ?>&text=Check%20out%20this%20site" height="20" title="Twitter Tweet Button" style="border: 0; overflow: hidden;"></iframe>
                    </div>
                    <?php endif; ?>

                    <?php if ($metadata['cbp_project_social_google'][0] == 'on') : ?>
                    <div class="cbp-l-inline-social-wrapper" style="width: 71px">
                        <iframe src="https://plusone.google.com/_/+1/fastbutton?bsv&amp;size=medium&amp;hl=en-US&amp;url=<?php echo the_permalink(); ?>" allowtransparency="true" frameborder="0" scrolling="no" title="+1" height="20" style="border: 0; overflow: hidden;"></iframe>
                    </div>
                    <?php endif; ?>

                    <?php if ($metadata['cbp_project_link'][0]) : ?>
                        <div class="cbp-l-inline-view-wrap">
                            <a href="<?php echo $metadata['cbp_project_link'][0];?>" target="<?php echo $metadata['cbp_project_link_target'][0];?>" class="cbp-l-inline-view"><?php _e('VIEW PROJECT', CUBEPORTFOLIO_TEXTDOMAIN); ?></a>
                        </div>
                    <?php endif; ?>

                    <br>
                </div>
            </div>
        </article>
    <?php endwhile; // end of the loop. ?>

</div>
<?php wp_reset_query(); ?>
<?php get_footer(); ?>
