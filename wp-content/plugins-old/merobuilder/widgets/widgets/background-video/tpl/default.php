
<?php
if(isset($instance['controls']) && $instance['controls']==1){
	$controls='true';
} else {
	$controls='false';
}
if(isset($instance['autoplay']) && $instance['autoplay']==1){
	$autoplay='true';
} else {
	$autoplay='false';
}
if(isset($instance['loop']) && $instance['loop']==1){
	$loop='true';
} else {
	$loop='false';
}
if(isset($instance['mute']) && $instance['mute']==1){
	$mute='true';
} else {
	$mute='false';
}
if(isset($instance['lightbox']) && $instance['lightbox']==1){ ?>
<div class="video">
	<a href="<?php echo esc_url($instance['url']) ?>" class="open-video"><i class="fa fa-play"></i></a>
</div>
<?php } ?>
<div id="P<?php echo rand(1,10000);?>" class="player" data-property="{videoURL:'<?php echo esc_url($instance['url']) ?>',showControls:<?php echo $controls; ?>,containment:'#<?php echo $instance['container_id'] ?>',startAt:0,mute:<?php echo $mute; ?>,autoPlay:<?php echo $autoplay; ?>,loop:<?php echo $loop; ?>,opacity:1}"></div>