<?php
$last_row = floor( ( count($instance['counters']) - 1 ) / $instance['per_row'] );
?>

<div class="sow-counters-list <?php if( $instance['responsive'] ) echo 'sow-counters-responsive'; ?>">

	<?php foreach( $instance['counters'] as $i => $counter ) : ?>

		<?php if( $i % $instance['per_row'] == 0 && $i != 0 ) : ?>
			<div class="sow-counters-clear"></div>
		<?php endif; ?>


		<div class="sow-counters-counter <?php if( $instance['layout'] ) echo  $instance['layout']; ?> <?php if(  floor( $i / $instance['per_row'] ) == $last_row ) echo 'sow-counters-counter-last-row' ?>" style="width: <?php echo round( 100 / $instance['per_row'], 3 ) ?>%">
	
				<?php $rand=rand();?>
				<?php

				$step_size=$counter['step_size'];

				?>
				

					<?php
					if( !empty($counter['icon_image']) ) {
						$attachment = wp_get_attachment_image_src($counter['icon_image']);
						if(!empty($attachment)) {
							if(!empty($instance['icon_size'])) $icon_styles[] = 'width: '.intval($instance['icon_size']).'px';
							if(!empty($instance['icon_size'])) $icon_styles[] = 'height: '.intval($instance['icon_size']).'px';

							?><div class="center-icon"><div class="sow-icon-image"><img src="<?php echo esc_url($attachment[0]); ?>" style="<?php echo implode('; ', $icon_styles) ?>"></div></div><?php
						}
					}
					else {
						$icon_styles = array();
						if(!empty($instance['icon_size'])) $icon_styles[] = 'font-size: '.intval($instance['icon_size']).'px';
						if(!empty($counter['icon_color'])) $icon_styles[] = 'color: '.$counter['icon_color'];
						echo '<div class="center-icon">';
						echo siteorigin_widget_get_icon($counter['icon'], $icon_styles);
						echo '</div>';
					}
					?>
			
				<div class="numericals">
				<script type="text/javascript">
				    jQuery(window).load(function () {
				        if (isScrolledIntoView("numerical-<?php echo $rand;?>")) {
				            jQuery('#numerical-<?php echo $rand;?>').removeClass('notinview');
				            incrementNumerical('#numerical-<?php echo $rand;?>', <?php echo esc_html($counter['number']) ?>, <?php echo $step_size;?>);
				        }
				    });
				    jQuery(window).scroll(function () {
				        if (jQuery('#numerical-<?php echo $rand;?>.notinview').length) {
				            if (isScrolledIntoView("numerical-<?php echo $rand;?>")) {
				                jQuery('#numerical-<?php echo $rand;?>').removeClass('notinview');
				                incrementNumerical('#numerical-<?php echo $rand;?>', <?php echo esc_html($counter['number']) ?>, <?php echo $step_size;?>);
				            }
				        }
				    });
				</script>


					<div class="numerical-container">
					    <div id="numerical-<?php echo $rand;?>" class="notinview">
					        <div class="value">0</div>
					    </div>
					    <div class="numerical-content"><?php if(!empty($counter['text'])) echo esc_html($counter['text']) ; ?></div>
					</div>
				</div>
		</div>

	<?php endforeach; ?>

</div>