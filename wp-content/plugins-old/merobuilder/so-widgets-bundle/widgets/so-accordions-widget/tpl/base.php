<?php if ( !empty( $instance['title'] ) ) {
	echo $args['before_title'] . esc_html( $instance['title'] ) . $args['after_title'];
} ?>
<div class="collapse-group" id="accordion">
 	<?php foreach( $instance['accordions'] as $i => $accordion ) : ?>
            <div class="panel">
                <div class="collapse-heading">
                    <h4><a data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo $i;?>" class="collapsed"><?php echo wp_kses_post( $accordion['title'] ) ?></a></h4>
                </div>
                <div id="collapse<?php echo $i;?>" class="panel-collapse  collapse <?php if( $accordion['active'] ) echo 'in'; else echo 'collapsed' ?>">
                    <div class="collapse-body">
                        <p><?php echo wp_kses_post( $accordion['text'] ) ?></p>
                    </div>
                </div>
            </div>
		              
<?php endforeach; ?>
</div>
