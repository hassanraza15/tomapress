<?php if ( !empty( $instance['title'] ) ) {
	echo $args['before_title'] . esc_html( $instance['title'] ) . $args['after_title'];
} ?>
<div class="address">
<?php if(!empty($instance['address'])): ?>
<p><i class="fa fa-map-marker"></i> <b><?php echo esc_attr($instance['address_label']);?> : </b><?php echo esc_attr($instance['address']);?> </p>
<?php endif; ?>
<?php if(!empty($instance['phone'])): ?>
<p><i class="fa fa-phone"></i> <b><?php echo esc_attr($instance['phone_label']);?> : </b><?php echo esc_attr($instance['phone']);?> </p>
<?php endif; ?>
<?php if(!empty($instance['fax'])): ?>
<p><i class="fa fa-print"></i> <b></b><?php echo esc_attr($instance['fax_label']);?> : </b><?php echo esc_attr($instance['fax']);?> </p>
<?php endif; ?>
<?php if(!empty($instance['email'])): ?>
<p><i class="fa fa-envelope"></i> <b><?php echo esc_attr($instance['email_label']);?> : </b>
	<a href="mailto:<?php echo esc_html($instance['email']);?>">
		<?php echo esc_attr($instance['email']);?> 
	</a>
	</p>
<?php endif; ?>
<?php if(!empty($instance['website'])): ?>
<p><i class="fa fa-globe"></i> <b><?php echo esc_attr($instance['website_label']);?> :</b>
	<a href="<?php echo esc_url($instance['website']);?>">
	<?php echo esc_url($instance['website']);?> 
	</a>
</p>

<?php endif; ?>
</div>