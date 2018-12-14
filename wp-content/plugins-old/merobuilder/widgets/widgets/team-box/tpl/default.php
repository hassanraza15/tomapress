<div class="team-div <?php if (!empty($instance['hovereffect'])) echo esc_attr($instance['hovereffect']); ?>">
    <div class="team-image"><img alt="<?php echo esc_html($instance['name']) ?>" src="<?php echo esc_url($instance['image_url']) ?> " /></div>
    <div class="overlay">
	    <span class="overlaycolor"></span>
	    <div class="team-details">   	
	        <h4><?php echo esc_html($instance['name']) ?></h4>
	        <span class="team-position"><?php echo esc_html($instance['cpost']) ?></span>
	        <?php if (!empty($instance['shortintro'])) : ?>
	        <p><?php echo wp_kses_post( $instance['shortintro'] ) ?></p>
	        <?php endif; ?>
	        
	        <?php if (!empty($instance['facebook']) || !empty($instance['gplus']) || !empty($instance['github']) || !empty($instance['twitter']) || !empty($instance['linkedin']) || !empty($instance['t-email']) ) : ?>
	        <ul class="social-icomoon">
	            
	            <?php if (!empty($instance['facebook'])) : ?>
	            <li><a href="<?php echo esc_url($instance['facebook']); ?>"><i class="fa fa-facebook"></i></a></li>
	            <?php endif; ?>
	            
	            <?php if (!empty($instance['twitter'])) : ?>
	            <li><a href="<?php echo esc_url($instance['twitter']); ?>"><i class="fa fa-twitter"></i></a></li>
	            <?php endif; ?>
	            
	            <?php if (!empty($instance['gplus'])) : ?>
	            <li><a href="<?php echo esc_url($instance['gplus']); ?>"><i class="fa fa-google-plus"></i></a></li>
	            <?php endif; ?>
	            
	            <?php if (!empty($instance['github'])) : ?>
	            <li><a href="<?php echo esc_url($instance['github']); ?>"><i class="fa fa-github"></i></a></li>
	            <?php endif; ?>
	            
	            <?php if (!empty($instance['linkedin'])) : ?>
	            <li><a href="<?php echo esc_url($instance['linkedin']); ?>"><i class="fa fa-linkedin"></i></a></li>
	            <?php endif; ?>
	            
	            <?php if (!empty($instance['t-email'])) : ?>
	            <li><a href="mailto:<?php echo ($instance['t-email']); ?>"><i class="fa fa-envelope-o"></i></a></li>
	            <?php endif; ?>
	               
	        </ul>
	        <?php endif; ?>
	    </div>
    </div>
</div>


