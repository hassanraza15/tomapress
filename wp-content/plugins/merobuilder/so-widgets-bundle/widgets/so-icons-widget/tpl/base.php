<?php
$last_row = floor( ( count($instance['icons']) - 1 ) / $instance['per_row'] );
?>

<div class="sow-icons-list <?php if( $instance['responsive'] ) echo 'sow-icons-responsive'; ?>">

	<?php foreach( $instance['icons'] as $i => $icon ) : ?>

		<?php if( $i % $instance['per_row'] == 0 && $i != 0 ) : ?>
			<div class="sow-icons-clear"></div>
		<?php endif; ?>


		<div class="sow-icons-icon <?php if(  floor( $i / $instance['per_row'] ) == $last_row ) echo 'sow-icons-icon-last-row' ?>" style="width: <?php echo round( 100 / $instance['per_row'], 3 ) ?>%">
	
				<style>
				#icon<?php echo $i ;?>{
					background-color: <?php echo esc_attr($icon['container_color']) ?>;
					border: 1px solid <?php echo esc_attr($icon['container_color']) ?>;
					width:<?php echo esc_attr($instance['container_size']) ?>px;
					height:<?php echo esc_attr($instance['container_size']) ?>px;
					line-height:<?php echo esc_attr($instance['container_size']) ?>px;
				}
				#icon<?php echo $i ;?>:hover{
					background-color: <?php echo esc_attr($icon['hover_color']) ?>;
					border: 1px solid <?php echo esc_attr($icon['hover_color']) ?>;
				}
				#icon<?php echo $i ;?>:after {
					box-shadow: 0 0 0 1px <?php echo esc_attr($icon['hover_color']) ?>;
				}
				</style>

				<div class="hi-icon-wrap hi-icon-effect-1 hi-icon-effect-1a" >
				<div id="icon<?php echo $i ;?>" class="hi-icon  <?php if(!empty($icon['animation'])) echo 'animated '.$icon['animation'];?>"  data-wow-delay="<?php echo $icon['animation_delay']?>s">
					     <?php
								if( !empty($icon['icon_image']) ) {
									$attachment = wp_get_attachment_image_src($icon['icon_image']);
									if(!empty($attachment)) {
										$icon_styles[] = 'background-image: url(' . esc_url($attachment[0]) . ')';
										if(!empty($instance['icon_size'])) $icon_styles[] = 'font-size: '.intval($instance['icon_size']).'px';

										?><div class="sow-icon-image" style="<?php echo implode('; ', $icon_styles) ?>"></div><?php
									}
								}
								else {
									$icon_styles = array();
									if(!empty($instance['icon_size'])) { $icon_styles[] = 'font-size: '.intval($instance['icon_size']).'px';  $icon_styles[] = 'line-height: '.intval($instance['icon_size']).'px';} 
									if(!empty($icon['icon_color'])) $icon_styles[] = 'color: '.$icon['icon_color'];

									echo siteorigin_widget_get_icon($icon['icon'], $icon_styles);
								}
								?>
						
				  </div>
				</div>

		</div>

	<?php endforeach; ?>

</div>