<div id="skillbar-<?php echo rand();?>" class="skillbar clearfix notinview" data-percent="<?php echo esc_html($instance['percent']) ?>%">
	<div class="skillbar-title">
		<span><?php echo esc_html($instance['title']) ?></span>
	</div>
	<div class="skillbar-bar">
		<div class="skill-bar-percent"></div>
		<div class="pointerval" style="left: <?php echo esc_html($instance['percent']) ?>%;">
			<span class="value"><?php echo esc_html($instance['percent']) ?>%</span>
			<span class="pointer"></span>
		</div>
	</div> <!-- End Skill Bar -->
</div>