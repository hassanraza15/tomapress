<?php
$last_row = floor( ( count($instance['features']) - 1 ) / $instance['per_row'] );
$rand=rand();
?>

<div class="sow-features-list <?php if( $instance['responsive'] ) echo 'sow-features-responsive'; ?>">

	<?php foreach( $instance['features'] as $i => $feature ) : ?>

		<?php if( $i % $instance['per_row'] == 0 && $i != 0 ) : ?>
			<div class="sow-features-clear"></div>
		<?php endif; ?>


		<div class="sow-features-feature <?php if( $instance['layout'] ) echo  $instance['layout']; ?> <?php if(  floor( $i / $instance['per_row'] ) == $last_row ) echo 'sow-features-feature-last-row' ?>" style="width: <?php echo round( 100 / $instance['per_row'], 3 ) ?>%">
	
				<style type="text/css" media="screen">
				#feature<?php echo $rand.$i ;?>{
					background-color: <?php echo esc_attr($feature['container_color']) ?>;
					border: 1px solid <?php echo esc_attr($feature['container_color']) ?>;
				}
				#feature<?php echo $rand.$i ;?>:hover{
					background-color: <?php echo esc_attr($feature['hover_color']) ?>;
					border: 1px solid <?php echo esc_attr($feature['hover_color']) ?>;
				}
				#feature<?php echo $rand.$i ;?>:after {
					box-shadow: 0 0 0 1px <?php echo esc_attr($feature['hover_color']) ?>;
				}
				</style>

				<div class="appdesign <?php if( $feature['design'] ) echo 'alternate'; ?>  <?php if(!empty($feature['animation'])) echo 'animated '.$feature['animation'];?>" data-wow-delay="<?php echo $feature['animation_delay']?>s">
					<div class="appdesign-<?php echo $feature['icon_position'] ?>">
						<div class="app-service">
							<!-- ICON -->
							<div class="icon-container">
								<div id="feature<?php echo $rand.$i ;?>" class="icon">
                                                                        <?php if( !empty( $feature['more_url']) && $feature['more_icon'] ) echo '<a href="' . esc_url( $feature['more_url'] ) . '" ' . ( $feature['new_window'] ? 'target="_blank"' : '' ) . '>'; ?>
									<?php
												if( !empty($feature['icon_image']) ) {
													$attachment = wp_get_attachment_image_src($feature['icon_image'],array(intval($instance['icon_size']),intval($instance['icon_size'])));
													if(!empty($attachment)) {
														if(!empty($instance['icon_size'])) $icon_styles[] = 'width: '.intval($instance['icon_size']).'px';
														if(!empty($instance['icon_size'])) $icon_styles[] = 'height: '.intval($instance['icon_size']).'px';

														?><div class="sow-icon-image"><img src="<?php echo esc_url($attachment[0]); ?>" style="<?php echo implode('; ', $icon_styles) ?>"></div><?php
													}
												}
												else {
													$icon_styles = array();
													if(!empty($instance['icon_size'])) $icon_styles[] = 'font-size: '.intval($instance['icon_size']).'px';
													if(!empty($feature['icon_color'])) $icon_styles[] = 'color: '.$feature['icon_color'];

													echo siteorigin_widget_get_icon($feature['icon'], $icon_styles);
												}
												?>
                                                                        <?php if( !empty( $feature['more_url']) && $feature['more_icon'] ) echo '</a>'; ?>
								</div>
							</div>
							
							<!-- DESCRIPTION -->
							<div class="app-service-details">
                                                                <?php if( !empty( $feature['more_url']) && $feature['more_title'] ) echo '<a href="' . esc_url( $feature['more_url'] ) . '" ' . ( $feature['new_window'] ? 'target="_blank"' : '' ) . '>'; ?>
								<h4><?php echo wp_kses_post( $feature['title'] ) ?></h4>
                                                                <?php if( !empty( $feature['more_url']) && $feature['more_title'] ) echo '</a>'; ?>
								<p><?php echo wp_kses_post( $feature['text'] ) ?></p>

								<p class="more-text">
								<?php if( !empty( $feature['more_url'] ) ) echo '<a href="' . esc_url( $feature['more_url'] ) . '" ' . ( $feature['new_window'] ? 'target="_blank"' : '' ) . '>'; ?>
								<?php echo wp_kses_post( $feature['more_text'] ) ?>
								<?php if( !empty( $feature['more_url'] ) ) echo '</a>'; ?>
								</p>
							</div>
							
						</div>
					</div>
				</div>

		</div>

	<?php endforeach; ?>

</div>