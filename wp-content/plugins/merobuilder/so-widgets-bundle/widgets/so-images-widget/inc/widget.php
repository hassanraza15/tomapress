<?php
class SiteOrigin_Widget_Images_Widget extends SiteOrigin_Widget {
	function __construct() {
		parent::__construct(
			'sow-images',
			__( 'Images (Builder)', 'siteorigin-widgets' ),
			array(
				'description' => __( 'Displays a group of images.', 'siteorigin-widgets' ),
			),
			array(),
			array(
				'images' => array(
					'type' => 'repeater',
					'label' => __('Images', 'siteorigin-widgets'),
					'item_name' => __('Image', 'siteorigin-widgets'),
					'fields' => array(

						'image' => array(
							'type' => 'media',
							'library' => 'image',
							'label' => __('Icon Image', 'siteorigin-widgets'),
							'description' => __('Use your own icon image.', 'siteorigin-widgets'),
						),

						'alt' => array(
							'type' => 'text',
							'label' => __('Image alt text', 'siteorigin-widgets'),
						),
						
						'url' => array(
							'type' => 'text',
							'label' => __('Image link', 'siteorigin-widgets'),
						),

						'align' => array(
							'type' => 'select',
							'label' => __('Image Alignment', 'siteorigin-panels'),
							'options' => array(
								'left' => __('Left', 'siteorigin-panels'),
								'right' => __('Right', 'siteorigin-panels'),
								'center' => __('Center', 'siteorigin-panels'),
								'justify' => __('Justify', 'siteorigin-panels'),
							)
						),
						
						'animation' => array(
							'type' => 'select',
							'label' => __('Animation', 'siteorigin-panels'),
							'options' => array(
								'none' => __('none', 'siteorigin-panels'),
								'bounce' => __('bounce', 'siteorigin-panels'),
								'flash' => __('flash', 'siteorigin-panels'),
								'pulse' => __('pulse', 'siteorigin-panels'),
								'rubberBand' => __('rubberBand', 'siteorigin-panels'),
								'shake' => __('shake', 'siteorigin-panels'),
								'swing' => __('swing', 'siteorigin-panels'),
								'tada' => __('tada', 'siteorigin-panels'),
								'wobble' => __('wobble', 'siteorigin-panels'),
								'bounceIn' => __('bounceIn', 'siteorigin-panels'),
								'bounceInDown' => __('bounceInDown', 'siteorigin-panels'),
								'bounceInLeft' => __('bounceInLeft', 'siteorigin-panels'),
								'bounceInRight' => __('bounceInRight', 'siteorigin-panels'),
								'bounceInUp' => __('bounceInUp', 'siteorigin-panels'),
								'fadeIn' => __('fadeIn', 'siteorigin-panels'),
								'fadeInDown' => __('fadeInDown', 'siteorigin-panels'),
								'fadeInDownBig' => __('fadeInDownBig', 'siteorigin-panels'),
								'fadeInLeft' => __('fadeInLeft', 'siteorigin-panels'),
								'fadeInLeftBig' => __('fadeInLeftBig', 'siteorigin-panels'),
								'fadeInRight' => __('fadeInRight', 'siteorigin-panels'),
								'fadeInRightBig' => __('fadeInRightBig', 'siteorigin-panels'),
								'fadeInUp' => __('fadeInUp', 'siteorigin-panels'),
								'fadeInUpBig' => __('fadeInUpBig', 'siteorigin-panels'),
								'flip' => __('flip', 'siteorigin-panels'),
								'flipInX' => __('flipInX', 'siteorigin-panels'),
								'flipInY' => __('flipInY', 'siteorigin-panels'),
								'rotateIn' => __('rotateIn', 'siteorigin-panels'),
								'rotateInDownLeft' => __('rotateInDownLeft', 'siteorigin-panels'),
								'rotateInDownRight' => __('rotateInDownRight', 'siteorigin-panels'),
								'rotateInUpLeft' => __('rotateInUpLeft', 'siteorigin-panels'),
								'rotateInUpRight' => __('rotateInUpRight', 'siteorigin-panels'),
								'slideInDown' => __('slideInDown', 'siteorigin-panels'),
								'slideInLeft' => __('slideInLeft', 'siteorigin-panels'),
								'slideInRight' => __('slideInRight', 'siteorigin-panels'),
								'hinge' => __('hinge', 'siteorigin-panels'),
								'rollIn' => __('rollIn', 'siteorigin-panels'),
							)
						),


						
					),
				),


				

			),
			plugin_dir_path(__FILE__).'../'
		);
	}

	function get_style_name($instance){
		return false;
	}

	function get_template_name($instance){
		return 'base';
	}



	
}