<?php
global $dikka_options;
?>
<?php if(isset($dikka_options['twitter_username']) && $dikka_options['twitter_username']!='') : ?>
<div class="icon-author">
	<div class="bird"><i class="fa fa-twitter"></i></div>
	<p class="twitter-author"><?php if(!empty($instance['followtext'])) echo esc_attr($instance['followtext']); else echo 'Follow'; ?> <a href="http://twitter.com/<?php echo $dikka_options['twitter_username']; ?>" target="_blank"><b> @<?php echo $dikka_options['twitter_username'];?></b></a></p>
	
</div>
<!-- Twitter Slider -->       
<div class="twitter-slider <?php if( $instance['layout'] ) echo  $instance['layout']; ?>">              
	<div id="twitter-feed"></div>  
</div>
<div id="twitter_data" data-slideshow="<?php if(!empty($instance['autoslide'])) echo 'true'; else echo 'false'; ?>" data-slideshowspeed="<?php if(!empty($instance['slidespeed'])) echo esc_attr($instance['slidespeed']); else echo '3500'; ?>" data-animationduration="<?php if(!empty($instance['slideduration'])) echo esc_attr($instance['slideduration']); else echo '1000'; ?>" data-direction="<?php if(!empty($instance['navigation'])) echo 'true'; else echo 'false'; ?>" data-control="<?php if(!empty($instance['pagination'])) echo 'true'; else echo 'false'; ?>" ></div>
		
</script>
<?php endif; ?>

