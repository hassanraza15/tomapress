<?php // Exit if accessed directly
if (!defined('ABSPATH')) {echo '<h1>Forbidden</h1>'; exit();} ?>
<?php  
    global $dikka_options;
    global $post;
    if(is_home()){
        $pageid=get_option('page_for_posts');
    } else {
        $pageid=get_the_ID();
    }
    
    if($menu=get_post_meta( $pageid, 'dikka_menu_select',true)){
    $menu_object = get_term_by('term_taxonomy_id',$menu[0] , 'nav_menu');
    }
    global $woocommerce;

?>


<div class="navbar <?php if (!empty($dikka_options['menu-hide']) && $dikka_options['menu-hide']==1) : ?>hide-on-start<?php endif; ?> <?php if (!empty($dikka_options['pagelayout']) && $dikka_options['pagelayout']=='box') : ?>container box <?php endif; ?> <?php if (!empty($dikka_options['topbar']) && $dikka_options['topbar']==1) : ?>nav-topbar<?php endif; ?> navbar-default default navbar-fixed-top navbar-shrink <?php if(isset($dikka_options['menu-style'])) : ?><?php if($dikka_options['menu-style']=='slight') : ?>slight<?php elseif($dikka_options['menu-style']=='sdark') : ?>sdark <?php elseif($dikka_options['menu-style']=='tLight') : ?>tLight <?php elseif($dikka_options['menu-style']=='tdark') : ?>tdark <?php elseif($dikka_options['menu-style']=='tfull') : ?>tfull <?php elseif($dikka_options['menu-style']=='flfull') : ?>flfull <?php else : ?>slight <?php endif; ?><?php if($dikka_options['menu-style']=='fdfull') : ?>fdfull<?php endif; ?><?php endif; ?>" role="navigation">
            
             <?php if (!empty($dikka_options['topbar']) && $dikka_options['topbar']==1) : ?>
		
			<div class="top-bar">
				<div class="container clearfix">
					
					<div class="slidedown">
					    	<div class="col-xs-12 col-sm-12">
						<?php if (!empty($dikka_options['topbar-socialicons']) && $dikka_options['topbar-socialicons']==1) : ?>
					
						    <div class="social-icons-fa">
						        <ul>
						         <?php if (!empty($dikka_options['social_facebook'])) : ?>
        	                    <li><a  href="<?php  echo esc_url($dikka_options['social_facebook']); ?>" target="_blank" data-original-title="" title=""><i class="fa fa-facebook"></i></a></li>
        	                    <?php endif; ?>
        	                    <?php if (!empty($dikka_options['social_twitter'])) : ?>
        	                    <li><a class="twitter" href="<?php  echo esc_url($dikka_options['social_twitter']); ?>" target="_blank" data-original-title="" title=""><i class="fa fa-twitter"></i></a></li>
        	                    <?php endif; ?>
        	                    <?php if (!empty($dikka_options['social_googlep'])) : ?>
        	                    <li><a class="google" href="<?php  echo esc_url($dikka_options['social_googlep']); ?>" target="_blank" data-original-title="" title=""><i class="fa fa-google"></i></a></li>
        	                    <?php endif; ?>
        	                    <?php if (!empty($dikka_options['social_youtube'])) : ?>
        	                    <li><a class="youtube" href="<?php  echo esc_url($dikka_options['social_youtube']); ?>" target="_blank" data-original-title="" title=""><i class="fa fa-youtube"></i></a></li>
        	                    <?php endif; ?>
        	                    <?php if (!empty($dikka_options['social_linkedin'])) : ?>
        	                    <li><a class="linkedin" href="<?php  echo esc_url($dikka_options['social_linkedin']); ?>" target="_blank" data-original-title="" title=""><i class="fa fa-linkedin"></i></a></li>
        	                    <?php endif; ?>
        	                    <?php if (!empty($dikka_options['social_pinterest'])) : ?>
        	                    <li><a class="pinterest" href="<?php  echo esc_url($dikka_options['social_pinterest']); ?>" target="_blank" data-original-title="" title=""><i class="fa fa-pinterest"></i></a></li>
        	                    <?php endif; ?>
        	                    <?php if (!empty($dikka_options['social_dribbble'])) : ?>
        	                    <li><a class="dribbble" href="<?php  echo esc_url($dikka_options['social_dribbble']); ?>" target="_blank" data-original-title="" title=""><i class="fa fa-dribbble"></i></a></li>
        	                    <?php endif; ?>
        	                    <?php if (!empty($dikka_options['social_skype'])) : ?>
        	                    <li><a class="skype" href="<?php  echo esc_url($dikka_options['social_skype']); ?>" target="_blank" data-original-title="" title=""><i class="fa fa-skype"></i></a></li>
        	                    <?php endif; ?>
        	                    <?php if (!empty($dikka_options['social_vimeo'])) : ?>
        	                    <li><a class="vimeo" href="<?php  echo esc_url($dikka_options['social_vimeo']); ?>" target="_blank" data-original-title="" title=""><i class="fa fa-vimeo-square"></i></a></li>
        	                    <?php endif; ?>
        	                    <?php if (!empty($dikka_options['social_tumblr'])) : ?>
        	                    <li><a class="tumblr" href="<?php  echo esc_url($dikka_options['social_tumblr']); ?>" target="_blank" data-original-title="" title=""><i class="fa fa-tumblr"></i></a></li>
        	                    <?php endif; ?>
        	                    
        	                    <?php if (!empty($dikka_options['social_instagram'])) : ?>
        	                    <li><a class="instagram" href="<?php  echo esc_url($dikka_options['social_instagram']); ?>" target="_blank" data-original-title="" title=""><i class="fa fa-instagram"></i></a></li>
        	                    <?php endif; ?>
        	                    <?php if (!empty($dikka_options['social_yelp'])) : ?>
        	                    <li><a class="yelp" href="<?php  echo esc_url($dikka_options['social_yelp']); ?>" target="_blank" data-original-title="" title=""><i class="fa fa-yelp"></i></a></li>
        	                    <?php endif; ?>
        	                    <?php if (!empty($dikka_options['social_behance'])) : ?>
        	                    <li><a class="behance" href="<?php  echo esc_url($dikka_options['social_behance']); ?>" target="_blank" data-original-title="" title=""><i class="fa fa-behance"></i></a></li>
        	                    <?php endif; ?>
        	                    <?php if (!empty($dikka_options['social_flickr'])) : ?>
        	                    <li><a class="flickr" href="<?php  echo esc_url($dikka_options['social_flickr']); ?>" target="_blank" data-original-title="" title=""><i class="fa fa-flickr"></i></a></li>
        	                    <?php endif; ?>
        	                    
						          
						        </ul>   
						    </div>  
				<?php endif; ?>
						
							<ul class="phone-mail">
					     		 <?php if (!empty($dikka_options['topbar-email'])) : ?><li><i class="fa fa-envelope"></i><a href="mailto:<?php echo esc_attr($dikka_options['topbar-email']); ?>"><?php echo esc_attr($dikka_options['topbar-email']); ?></a></li><?php endif; ?> 
						 		 <?php if (!empty($dikka_options['topbar-phone'])) : ?><li><i class="fa fa-phone"></i> <?php  echo esc_attr($dikka_options['topbar-phone']); ?></li><?php endif; ?>
						 		 <?php if (!empty($dikka_options['topbar-text'])) : ?><li><?php  echo esc_attr($dikka_options['topbar-text']); ?></li><?php endif; ?>
					     	
							</ul>
						</div>
					</div>
				
				</div>
				
				<a href="#" class="down-button"><i class="fa fa-angle-down"></i></a><!-- this appear on small devices -->
				
			</div>
		
			<?php endif; ?>

            <!-- BEGIN: NAV-CONTAINER -->
            <div class="nav-container container">
                <div class="navbar-header">
                	
                    <!-- BEGIN: TOGGLE BUTTON (RESPONSIVE)-->
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                        <span class="sr-only"><?php __( 'Toggle navigation', 'dikka' ); ?></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    <!-- BEGIN: LOGO -->

         
        <?php 
        if (isset($dikka_options['logo']) && $dikka_options['logo']['url']!='') {
         ?>

            <a class="navbar-brand nav-to logo" href="<?php echo esc_url(site_url()); ?>" title="<?php echo esc_attr(get_bloginfo('name')); ?>">
            <img src="<?php echo esc_url($dikka_options['logo']['url']); ?>"  data-at2x="<?php echo esc_url($dikka_options['retinalogo']['url']); ?>" alt="<?php echo esc_attr(get_bloginfo('name')); ?>" />
            </a>
            
        <?php } else { ?>
            <a class="navbar-brand" href="<?php echo esc_url(site_url()); ?>" title="<?php echo esc_attr(get_bloginfo('name')); ?>">
            <?php echo esc_attr(get_bloginfo('name')); ?><br>     
            </a>         
        <?php } ?>
             
		
       <!-- BEGIN: WPML MENU -->     
       <?php do_action('icl_language_selector'); ?> 
                    
                  
                </div>
        <div class="icons-style-mobile">
                   <?php 
            if (isset($dikka_options['cart']) && $dikka_options['cart'] == 1 &&  is_plugin_active('woocommerce/woocommerce.php') ) {
            ?>
            
                <div class="dikka_dynamic_shopping_bag">
             
                    <div class="dikka_little_shopping_bag_wrapper">
                        <div class="dikka_little_shopping_bag">
                            <div class="title">
                                
                                <i class="fa fa-shopping-cart"></i>
                                
                            </div>
                            
                            <div class="overview"><?php echo $woocommerce->cart->get_cart_total(); ?> <span class="minicart_items">/ <?php echo sprintf(_n('%d item', '%d items', $woocommerce->cart->cart_contents_count, 'dikka'), $woocommerce->cart->cart_contents_count); ?></span></div>
                        </div>
                        <div class="dikka_minicart_wrapper">
                            <div class="dikka_minicart">
                            <?php                                    
                            echo '<ul class="cart_list">';                                        
                                if (sizeof($woocommerce->cart->cart_contents)>0) : foreach ($woocommerce->cart->cart_contents as $cart_item_key => $cart_item) :
                                
                                    $_product = $cart_item['data'];                                            
                                    if ($_product->exists() && $cart_item['quantity']>0) :                                            
                                        echo '<li class="cart_list_product">';                                                
                                            echo '<a class="cart_list_product_img" href="'.get_permalink($cart_item['product_id']).'">' . $_product->get_image().'</a>';                                                    
                                            echo '<div class="cart_list_product_title">';
                                                $dikka_product_title = $_product->get_title();
                                                $dikka_short_product_title = (strlen($dikka_product_title) > 28) ? substr($dikka_product_title, 0, 25) . '...' : $dikka_product_title;
                                                echo '<a href="'.get_permalink($cart_item['product_id']).'">' . apply_filters('woocommerce_cart_widget_product_title', $dikka_short_product_title, $_product) . '</a>';
                                                echo '<div class="cart_list_product_quantity">'.__('Quantity:', 'dikka').' '.$cart_item['quantity'].'</div>';
                                            echo '</div>';
                                            echo apply_filters( 'woocommerce_cart_item_remove_link', sprintf('<a href="%s" class="remove" title="%s">&times;</a>', esc_url( $woocommerce->cart->get_remove_url( $cart_item_key ) ), __('Remove this item', 'dikka') ), $cart_item_key );
                                            echo '<div class="cart_list_product_price">'.woocommerce_price($_product->get_price()).'</div>';
                                            echo '<div class="clr"></div>';                                                
                                        echo '</li>';                                         
                                    endif;                                        
                                endforeach;
                                ?>
                                        
                                <div class="minicart_total_checkout">                                        
                                    <?php _e('Cart subtotal', 'dikka'); ?><span><?php echo $woocommerce->cart->get_cart_total(); ?></span>                                   
                                </div>
                                
                                <a href="<?php echo esc_url( $woocommerce->cart->get_cart_url() ); ?>" class="button dikka_minicart_cart_but"><?php _e('View Shopping Bag', 'dikka'); ?></a>   
                                
                                <a href="<?php echo esc_url( $woocommerce->cart->get_checkout_url() ); ?>" class="button dikka_minicart_checkout_but"><?php _e('Proceed to Checkout', 'dikka'); ?></a>
                                
                                <?php                                        
                                else: echo '<li class="empty">'.__('No products in the cart.','woothemes').'</li>'; endif;                                    
                            echo '</ul>';                                    
                            ?>                                                                        
            
                            </div>
                        </div>
                        
                    </div>
                    
                    <a href="<?php echo esc_url( $woocommerce->cart->get_cart_url() ); ?>" class="dikka_little_shopping_bag_wrapper_mobiles"><span><?php echo $woocommerce->cart->cart_contents_count; ?></span></a>
                
                </div>
            <?php } ?>    
            
            <?php 
            if (isset($dikka_options['search']) && $dikka_options['search'] == 1) {
            ?>
             <form method="get" id="searchform_top" autocomplete="off" action="<?php echo home_url( '/' ); ?>">
                <?php
                    $msie = strpos($_SERVER["HTTP_USER_AGENT"], 'MSIE') ? true : false;
                    if ($msie){
                        ?>
                        <input type="text" value="" class="field" name="s" id="s_top"  placeholder=""/>
                        <?php
                    } else {
                        ?>
                        <input type="text" value="" class="field closed" name="s" id="s_top"  placeholder="Type and hit Enter" onfocus="this.value = this.value;"/>
                        <?php
                    }
                ?>
            </form>
            <?php } ?>
                 
          
        </div>
               
                <?php
                    if(isset($menu_object) && is_object($menu_object)){
                        $args = array(
                        'menu'            => $menu_object->slug,
                        'items_wrap' => '<div class="collapse navbar-collapse "><ul class="nav navbar-nav navbar-right sm">%3$s</ul></div>',
                        'echo'            => true,
                        'fallback_cb'     => 'wp_page_menu()',
                        'walker'  => new description_walker()
                    );
                    } else {

                        $args = array(
                        'theme_location' => 'primary',
                        'items_wrap' => '<div class="collapse navbar-collapse "><ul class="nav navbar-nav navbar-right sm">%3$s</ul></div>',
                        'echo'            => true,
                        'fallback_cb'     => 'wp_page_menu()',
                        'walker'  => new description_walker()
                    );

                    }
                    wp_nav_menu($args);
                

                ?>
               
               
                <!-- END: MENU -->
            </div>
            
          
		    
            <!--END: NAV-CONTAINER -->
        </div>




