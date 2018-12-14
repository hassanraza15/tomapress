<?php
$last_row = floor( ( count($instance['services']) - 1 ) / $instance['per_row'] );
?>

<div class="sow-services-list <?php if( $instance['responsive'] ) echo 'sow-services-responsive'; ?>">

	<?php foreach( $instance['services'] as $i => $service ) : ?>

		<?php if( $i % $instance['per_row'] == 0 && $i != 0 ) : ?>
			<div class="sow-services-clear"></div>
		<?php endif; ?>


		<div class="sow-services-service <?php if( $instance['layout'] ) echo  $instance['layout']; ?> <?php if(  floor( $i / $instance['per_row'] ) == $last_row ) echo 'sow-services-service-last-row' ?>" style="width: <?php echo round( 100 / $instance['per_row'], 3 ) ?>%" >
	
				<style>
				#service<?php echo $i ;?>{
					background-color: <?php echo esc_attr($service['container_color']) ?>;
				}
				#service<?php echo $i ;?>:hover{
					background-color: <?php echo esc_attr($service['container_color']) ?>;
				}
				#service<?php echo $i ;?>:after {
					box-shadow: 0 0 0 1px <?php echo esc_attr($service['container_color']) ?>;
				}
				</style>

				<div class="hi-icon-wrap hi-icon-effect-1 hi-icon-effect-1a"  >
				<div id="service<?php echo $i ;?>" class="hi-icon <?php if(!empty($service['animation'])) echo 'animated '.$service['animation'];?>" data-wow-delay="<?php echo $service['animation_delay']?>s" >
					        <?php if( !empty( $service['more_url']) && $service['more_icon'] ) echo '<a href="' . esc_url( $service['more_url'] ) . '" ' . ( $service['new_window'] ? 'target="_blank"' : '' ) . '>'; ?>			
						<?php
								if( !empty($service['icon_image']) ) {
									$attachment = wp_get_attachment_image_src($service['icon_image']);
									if(!empty($attachment)) {
										if(!empty($instance['icon_size'])) $icon_styles[] = 'height: '.intval($instance['icon_size']).'px';
										if(!empty($instance['icon_size'])) $icon_styles[] = 'width: '.intval($instance['icon_size']).'px';
										?><div class="sow-icon-image"><img src="<?php echo esc_url($attachment[0]); ?>" style="<?php echo implode('; ', $icon_styles) ?>"></div><?php
									}
								}
								else {
									$icon_styles = array();
									if(!empty($instance['icon_size'])) $icon_styles[] = 'font-size: '.intval($instance['icon_size']).'px';
									if(!empty($service['icon_color'])) $icon_styles[] = 'color: '.$service['icon_color'];

									echo siteorigin_widget_get_icon($service['icon'], $icon_styles);
								}
								?>
                                                        <?php if( !empty( $service['more_url']) && $service['more_icon'] ) echo '</a>'; ?>
							<?php if(!empty($service['text']) && $service['popup']==true) : ?>
								<div class="tooltip-desc">
								<span class="tooltip-arrow-down"></span>
								<div class="tooltip-content">
								<p><?php echo wp_kses_post( $service['text'] ) ?></p>
							</div>
							</div>
						 <?php endif; ?>
					     
				  </div>
 				  <?php if( !empty( $service['more_url']) && $service['more_icon'] ) echo '<a href="' . esc_url( $service['more_url'] ) . '" ' . ( $service['new_window'] ? 'target="_blank"' : '' ) . '>'; ?>			
				  <h4><?php echo wp_kses_post( $service['title'] ) ?></h4>
				  <?php if( !empty( $service['more_url']) && $service['more_icon'] ) echo '</a>'; ?>
				  <?php if($service['popup']==false) : ?>
				  <p><?php echo wp_kses_post( $service['text'] ) ?></p>
				  <?php endif; ?>
				</div>
		</div>

	<?php endforeach; ?>

</div>