<?php // Exit if accessed directly
if (!defined('ABSPATH')) {echo '<h1>Forbidden</h1>'; exit();} 
global $dikka_options;

$pageid=get_the_ID();

$page_setting_activate=get_post_meta( $pageid, 'dikka_pagetitle_activate',true);

if(isset($page_setting_activate) && $page_setting_activate=='on') :
    $page_setting_align=get_post_meta( $pageid, 'dikka_pagetitle_align',true);
    $page_setting_line=get_post_meta( $pageid, 'dikka_pagetitle_line',true);
    $page_setting_parallax=get_post_meta( $pageid, 'dikka_pagetitle_parallax',true);
    $page_setting_topmargin=get_post_meta( $pageid, 'dikka_pagetitle_topmargin',true);
    $page_setting_bottommargin=get_post_meta( $pageid, 'dikka_pagetitle_bottommargin',true);
?>
<div class="pagetitle black-section light-text <?php if(isset($page_setting_align)) : ?><?php echo 'align-'.$page_setting_align;  ?> <?php endif; ?> <?php if(isset($page_setting_parallax) && $page_setting_parallax=='on') { echo 'panel-row-style-parallax'; } ?>" >
            
            <div class="title" <?php if(!empty( $page_setting_topmargin) || !empty($page_setting_bottommargin)) { ?>style="padding-top:<?php echo esc_attr($page_setting_topmargin); ?>px;padding-bottom:<?php echo esc_attr($page_setting_bottommargin); ?>px;<?php } ?>">
                <div class="section-title container light">
                    
                    <?php if(isset($page_setting_line) && $page_setting_line=="on")  { ?>
                        <div class="divider colored "></div>
                    <?php } ?>
                    
					<?php if (is_home()) :?>
		            <h1><?php _e('Blog', 'dikka'); ?></h1>
		            <?php elseif (is_single()) :?>
		            <h1><?php echo get_the_title(); ?></h1>
		            <?php elseif (is_page()) : ?>
		            <h1><?php echo get_the_title(); ?></h1>
		            <?php elseif (is_author()) : ?>
		            <h1><?php _e('Author', 'dikka'); ?></h1>
		            <?php elseif (is_search()) : ?>
		            <h1><?php _e('Search', 'dikka'); ?></h1>
		            <?php elseif (is_category()) : ?>
		            <h1>Category: &#8216;<?php single_cat_title(); ?>&#8217;<?php _e('', 'dikka'); ?></h1>
		            <?php elseif (is_tag()) : ?>
		            <h1>Tags: &#8216;<?php single_tag_title(); ?>&#8217;<?php _e('', 'dikka'); ?></h1>
		            <?php elseif (is_archive()) : ?>
		            <?php if (get_post_type() == 'product') : ?>
		            <h1><?php _e('Shop', 'dikka'); ?></h1>
		            <?php else: ?>
		            <h1><?php _e('Archive', 'dikka'); ?></h1>
		            <?php endif; ?>
		            <?php elseif (get_post_type() == 'product') : ?>
		            <h1><?php _e('Shop', 'dikka'); ?></h1>
		            <?php endif; ?>
		            </h1>
					
                </div>
            </div>
        </div>

<?php
else :
?>
<div class="pagetitle black-section light-text <?php if(isset($dikka_options['ptitle-align'])) : ?><?php echo 'align-'.$dikka_options['ptitle-align'];  ?><?php endif; ?> <?php if(isset($dikka_options['ptitle-parallax']) && $dikka_options['ptitle-parallax']==1) { echo 'panel-row-style-parallax'; } ?>" >
            
            <div class="title" <?php if(!empty($dikka_options['ptitle-topmargin']) || !empty($dikka_options['ptitle-bottommargin'])) { ?>style="padding-top:<?php echo esc_attr($dikka_options['ptitle-topmargin']); ?>px;padding-bottom:<?php echo esc_attr($dikka_options['ptitle-bottommargin']); ?>px;<?php } ?>">
                <div class="section-title container light">
                    
                    <?php if(isset($dikka_options['ptitle-line']) && $dikka_options['ptitle-line']==1)  { ?>
                    <div class="divider colored "></div>
                    <?php } ?>
            
                    <?php if (is_home()) :?>
		            <h1><?php _e('Blog', 'dikka'); ?></h1>
		            <?php elseif (is_single()) :?>
		            <h1><?php echo get_the_title(); ?></h1>
		            <?php elseif (is_page()) : ?>
		            <h1><?php echo get_the_title(); ?></h1>
		            <?php elseif (is_author()) : ?>
		            <h1><?php _e('Author', 'dikka'); ?></h1>
		            <?php elseif (is_search()) : ?>
		            <h1><?php _e('Search', 'dikka'); ?></h1>
		            <?php elseif (is_category()) : ?>
		            <h1>Category: &#8216;<?php single_cat_title(); ?>&#8217;<?php _e('', 'dikka'); ?></h1>
		            <?php elseif (is_tag()) : ?>
		            <h1>Tags: &#8216;<?php single_tag_title(); ?>&#8217;<?php _e('', 'dikka'); ?></h1>
		            <?php elseif (is_archive()) : ?>
		            <?php if (get_post_type() == 'product') : ?>
		            <h1><?php _e('Shop', 'dikka'); ?></h1>
		            <?php else: ?>
		            <h1><?php _e('Archive', 'dikka'); ?></h1>
		            <?php endif; ?>
		            <?php elseif (get_post_type() == 'product') : ?>
		            <h1><?php _e('Shop', 'dikka'); ?></h1>
                    <?php else : ?>
                    <h1><?php _e('PAGE NOT FOUND', 'dikka'); ?></h1>
                    <?php endif; ?>
                    </h1>
                </div>
            </div>
        </div>
<?php endif; ?> 