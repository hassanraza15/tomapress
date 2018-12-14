<div class="align-<?php echo esc_attr($instance['align']) ?>">
<?php if(isset($instance['one_page_scroll']) && $instance['one_page_scroll']==1) : ?>
<a class="btn-color btn-color-1d <?php echo (empty($instance['big_button']) ? '' : 'big-size') ; ?> <?php echo (empty($instance['round_button']) ? '' : 'rounded-tp-button') ; ?> nav-to <?php echo ($instance['bstyle']=='custom' ? $instance['bstyle'] : 'tp-button') ; ?> <?php echo (empty($instance['extra_class']) ? '' : $instance['extra_class']) ; ?>" href="#<?php echo esc_attr($instance['one_page_scroll_id']) ?>" >
	<?php echo esc_html($instance['text']) ?>
</a>
<?php else : ?>
<a class="btn-color btn-color-1d <?php echo (empty($instance['big_button']) ? '' : 'big-size') ; ?> <?php echo (empty($instance['round_button']) ? '' : 'rounded-tp-button') ; ?> <?php echo ($instance['bstyle']=='custom' ? $instance['bstyle'] : 'tp-button') ; ?> <?php echo (empty($instance['extra_class']) ? '' : $instance['extra_class']) ; ?>" href="<?php echo esc_url($instance['url']) ?>" <?php if(!empty($instance['new_window'])) echo 'target="_blank"'; ?>>
	<?php echo esc_html($instance['text']) ?>
</a>
<?php endif; ?>
</div>

<?php if($instance['bstyle']=='custom'): ?>
<style>
.btn-color.custom{
	background-color: <?php echo esc_attr($instance['bg_color']) ?> !important;
	color: <?php echo esc_attr($instance['text_color']) ?> !important;
	border-color: <?php echo esc_attr($instance['border_color']) ?> !important;
}

.btn-color.custom:hover{
	background-color: <?php echo esc_attr($instance['bg_hover_color']) ?> !important;
	color: <?php echo esc_attr($instance['text_hover_color']) ?> !important;
	border-color: <?php echo esc_attr($instance['border_hover_color']) ?> !important;
}
</style>
<?php endif; ?>