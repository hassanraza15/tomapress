<?php // Exit if accessed directly
if (!defined('ABSPATH')) {echo '<h1>Forbidden</h1>'; exit();} ?>

        </div>
<?php  global $dikka_options; ?>
     
       <div class="footer" <?php if(isset($dikka_options['footer-on']) && $dikka_options['footer-on']!=1) echo 'style="display:none;"';?>>
            <!-- BEGIN BOTTOM FOOTER -->
            <div class="container">
                <?php get_template_part('partials/footer-layout'); ?>
                        
            </div>

            <p id="back-top"><a href="#home"><i class="fa fa-angle-up"></i></a></p>       
       </div>
       
       <div id="bottom-footer" class="text-center" <?php if(isset($dikka_options['secondfooter-on']) && $dikka_options['secondfooter-on']!=1) echo 'style="display:none;"';?> >
                                  
       		<div class="container">
	            <?php if(isset($dikka_options['footer-logo']['url']) && $dikka_options['footer-logo']['url']!='') :  ?> 
	            <!-- BEGIN: LOGO FOOTER -->
	            <div class="logo-footer">
	                 <img src="<?php echo esc_url($dikka_options['footer-logo']['url']); ?>" data-at2x="<?php echo esc_url($dikka_options['footer-retinalogo']['url']); ?>" alt="<?php echo esc_attr(get_bloginfo('name')); ?>" />
	                 
	                 <ul class="contacts-footer">
	                 	<?php if(isset($dikka_options['footer-address']) && $dikka_options['footer-address']!='') :  ?> 
	                 	<li><i class="fa fa-map-marker"></i> <?php echo esc_attr($dikka_options['footer-address']); ?></li>
	                    <?php endif; ?>
	                    <?php if(isset($dikka_options['footer-email']) && $dikka_options['footer-email']!='') :  ?> 
	                 	<li><i class="fa fa-envelope-o"></i> <a href="mailto:<?php echo esc_attr($dikka_options['footer-email']); ?>"><?php echo esc_attr($dikka_options['footer-email']); ?></a></li> 
	                    <?php endif; ?>
	                    <?php if(isset($dikka_options['footer-phone']) && $dikka_options['footer-phone']!='') :  ?> 
	                 	<li><i class="fa fa-phone"></i> <?php echo esc_attr($dikka_options['footer-phone']); ?></li>
	                    <?php endif; ?>
	                 </ul>
	                 
	            </div>
	            <?php endif; ?>
	              <?php if (isset($dikka_options['footer-social']) && $dikka_options['footer-social']==1) : ?>
	            <!-- BEGIN: ICONS FOOTER -->
	            <div class="socialdiv colored">
	                <ul>
	                    <?php if (!empty($dikka_options['social_facebook'])) : ?>
	                    <li><a class="facebook" href="<?php  echo esc_url($dikka_options['social_facebook']); ?>" target="_blank" data-original-title="" title=""></a></li>
	                    <?php endif; ?><?php if (!empty($dikka_options['social_twitter'])) : ?>
	                    <li><a class="twitter" href="<?php  echo esc_url($dikka_options['social_twitter']); ?>" target="_blank" data-original-title="" title=""></a></li>
	                    <?php endif; ?><?php if (!empty($dikka_options['social_googlep'])) : ?>
	                    <li><a class="google" href="<?php  echo esc_url($dikka_options['social_googlep']); ?>" target="_blank" data-original-title="" title=""></a></li>
	                    <?php endif; ?><?php if (!empty($dikka_options['social_youtube'])) : ?>
	                    <li><a class="youtube" href="<?php  echo esc_url($dikka_options['social_youtube']); ?>" target="_blank" data-original-title="" title=""></a></li>
	                    <?php endif; ?><?php if (!empty($dikka_options['social_linkedin'])) : ?>
	                    <li><a class="linkedin" href="<?php  echo esc_url($dikka_options['social_linkedin']); ?>" target="_blank" data-original-title="" title=""></a></li>
	                    <?php endif; ?><?php if (!empty($dikka_options['social_pinterest'])) : ?>
	                    <li><a class="pinterest" href="<?php  echo esc_url($dikka_options['social_pinterest']); ?>" target="_blank" data-original-title="" title=""></a></li>
	                    <?php endif; ?><?php if (!empty($dikka_options['social_dribbble'])) : ?>
	                    <li><a class="dribbble" href="<?php  echo esc_url($dikka_options['social_dribbble']); ?>" target="_blank" data-original-title="" title=""></a></li>
	                    <?php endif; ?><?php if (!empty($dikka_options['social_skype'])) : ?>
	                    <li><a class="skype" href="<?php  echo esc_url($dikka_options['social_skype']); ?>" target="_blank" data-original-title="" title=""></a></li>
	                    <?php endif; ?><?php if (!empty($dikka_options['social_vimeo'])) : ?>
	                    <li><a class="vimeo" href="<?php  echo esc_url($dikka_options['social_vimeo']); ?>" target="_blank" data-original-title="" title=""></a></li>
	                    <?php endif; ?><?php if (!empty($dikka_options['social_tumblr'])) : ?>
	                    <li><a class="tumblr" href="<?php  echo esc_url($dikka_options['social_tumblr']); ?>" target="_blank" data-original-title="" title=""></a></li>
	                    <?php endif; ?>
	                    
	                    
	                    <?php if (!empty($dikka_options['social_instagram'])) : ?>
	                    <li><a class="instagram" href="<?php  echo esc_url($dikka_options['social_instagram']); ?>" target="_blank" data-original-title="" title=""></a></li>
	                    <?php endif; ?>
	                    <?php if (!empty($dikka_options['social_yelp'])) : ?>
	                    <li><a class="yelp" href="<?php  echo esc_url($dikka_options['social_yelp']); ?>" target="_blank" data-original-title="" title=""></a></li>
	                    <?php endif; ?>
	                    <?php if (!empty($dikka_options['social_behance'])) : ?>
	                    <li><a class="behance" href="<?php  echo esc_url($dikka_options['social_behance']); ?>" target="_blank" data-original-title="" title=""></a></li>
	                    <?php endif; ?>
	                    <?php if (!empty($dikka_options['social_flickr'])) : ?>
	                    <li><a class="flickr" href="<?php  echo esc_url($dikka_options['social_flickr']); ?>" target="_blank" data-original-title="" title=""></a></li>
	                    <?php endif; ?>
	                </ul>   
	            </div>  
	            <?php endif; ?>     
	            <?php if(isset($dikka_options['footer_text'])) :  ?> 
	            <!-- BEGIN: COPYRIGHTS -->
	            <div class="b-text">
	                <p><?php  echo wp_kses_post($dikka_options['footer_text']); ?></p>
	            </div>
	            <?php endif; ?>
	        </div>
	        <!-- END CONTAINER -->
	    </div><!-- END BOTTOM FOOTER -->
	    
    </div>    
    <!-- Don't forget analytics -->
    <?php if(isset($dikka_options['meta_javascript']) && $dikka_options['meta_javascript']!='') 
    echo $dikka_options['meta_javascript']; ?>  
    <?php wp_footer(); ?>
    </body>
</html>