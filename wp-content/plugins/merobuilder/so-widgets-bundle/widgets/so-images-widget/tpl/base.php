<?php foreach( $instance['images'] as $i => $image ) : ?>
<div class="image_wrapper <?php echo 'align-'.$image['align']; ?>">
<?php if( !empty($image['image']) ) {
									$attachment = wp_get_attachment_image_src($image['image'],'full');

									if(!empty($attachment)) {
										?><?php if( !empty($image['url']) ) : ?><a href="<?php echo esc_url($image['url']); ?>"><?php endif; ?><img src="<?php echo esc_url($attachment[0]); ?>" class="<?php if(!empty($image['animation']) && $image['animation']!='none') : echo 'animated '.$image['animation']; endif; ?>" alt="<?php echo esc_attr($image['animation']);?>">
										
										    <?php if( !empty($image['url']) ) : ?></a><?php endif; ?>	
											<?php
									}
								}
?>
</div>
<?php endforeach; ?>

