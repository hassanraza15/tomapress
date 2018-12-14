<?php

$shortcode_attr = array();
		foreach($instance as $k => $v){
			if(empty($v)) continue;
			$shortcode_attr[] = $k.'="'.esc_attr($v).'"';
		}

		echo do_shortcode('[testimonial_slider '.implode(' ', $shortcode_attr).']');
?>

<script>
jQuery(document).ready(function() {
if (jQuery('#testimonials-slider.flexslider').length){
		jQuery('#testimonials-slider.flexslider').flexslider({						
			animation: "slide",
			slideshow: <?php if(!empty($instance['autoslide'])) echo 'true'; else echo 'false'; ?>,
			slideshowSpeed: <?php if(!empty($instance['slidespeed'])) echo esc_attr($instance['slidespeed']); else echo '3500'; ?>,
			animationDuration: <?php if(!empty($instance['slideduration'])) echo esc_attr($instance['slideduration']); else echo '2000'; ?>,
			
			animationSpeed: <?php if(!empty($instance['slidersspeed'])) echo esc_attr($instance['slidersspeed']); else echo '600'; ?>,

			directionNav: <?php if(!empty($instance['navigation'])) echo 'true'; else echo 'false'; ?>,
			controlNav: <?php if(!empty($instance['pagination'])) echo 'true'; else echo 'false'; ?>,
			smootheHeight:true,
			after: function(slider) {
			  slider.removeClass('loading');
			}
			
		});	
	}
});
</script>