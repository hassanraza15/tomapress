<h4><?php echo esc_html($instance['title']) ?></h4>
<h2><?php echo esc_html($instance['price']) ?><span><?php echo esc_html($instance['per']) ?></span></h2>
<p class="information"><?php echo wp_kses_post( $instance['information'] ) ?></p>

<?php

$this->sub_widget('list', array('title' => '', 'text' => $instance['features'], 'listicon' => $instance['listicon']));
$this->sub_widget('button', array(
	'text' => $instance['button_text'],
	'url' => $instance['button_url'],
	'align' => 'center',
	'bstyle' => $instance['button_bstyle'],
	'one_page_scroll' => $instance['button_one_page_scroll'],
	'new_window' => !empty($instance['button_new_window'])
));

?>