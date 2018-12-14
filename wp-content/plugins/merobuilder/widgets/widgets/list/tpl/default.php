<div class="list-body ">
<?php
if ( !empty( $instance['title'] ) ) {
	echo $args['before_title'] . esc_html( $instance['title'] ) . $args['after_title'];
}
echo $this->create_list($instance['text'],$instance['listicon']);
?>
</div>