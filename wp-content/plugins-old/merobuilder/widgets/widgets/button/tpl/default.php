<?php if(isset($instance['one_page_scroll']) && $instance['one_page_scroll']==1) : ?>
<a class="btn-color btn-color-1d <?php echo (empty($instance['bstyle']) ? '' : 'nav-to') ; ?> <?php echo (empty($instance['bstyle']) ? '' : $instance['bstyle']) ; ?> <?php echo (empty($instance['extra_class']) ? '' : $instance['extra_class']) ; ?>" href="#<?php echo esc_attr($instance['one_page_scroll_id']) ?>" >
	<?php echo esc_html($instance['text']) ?>
</a>
<?php else : ?>
<a class="btn-color btn-color-1d <?php echo (empty($instance['big_button']) ? '' : 'big-size') ; ?> <?php echo (empty($instance['round_button']) ? '' : 'rounded-tp-button') ; ?> <?php echo (empty($instance['bstyle']) ? '' : 'nav-to') ; ?> <?php echo (empty($instance['bstyle']) ? '' : $instance['bstyle']) ; ?> <?php echo (empty($instance['extra_class']) ? '' : $instance['extra_class']) ; ?>" href="<?php echo esc_url($instance['url']) ?>" <?php if(!empty($instance['new_window'])) echo 'target="_blank"'; ?>>
	<?php echo esc_html($instance['text']) ?>
</a>
<?php endif; ?>