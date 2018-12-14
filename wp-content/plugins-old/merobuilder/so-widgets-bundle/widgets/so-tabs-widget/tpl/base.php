<div id="blog-tabs">
	<ul class="tabs">
		<?php foreach( $instance['tabs'] as $i => $tab ) : ?>
        <li id="tab_two<?php echo $i;?>" class="<?php if( $accordion['active'] ) echo 'current'; ?>"><?php echo wp_kses_post( $tab['title'] ) ?></li>
		<?php endforeach; ?>
	</ul>


	<div class="contents">
	<?php foreach( $instance['tabs'] as $i => $tab ) : ?>
			<div id="content_two<?php echo $i;?>" class="tabscontent">
				<p><?php echo wp_kses_post( $tab['text'] ) ?></p>	              
			</div> 
	<?php endforeach; ?>
	</div>
</div>

