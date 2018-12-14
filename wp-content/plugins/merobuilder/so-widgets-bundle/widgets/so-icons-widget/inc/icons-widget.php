<?php

class SiteOrigin_Widget_Icons_Widget extends SiteOrigin_Widget {
	function __construct() {
		parent::__construct(
			'sow-icons',
			__( 'Icons (Builder)', 'siteorigin-widgets' ),
			array(
				'description' => __( 'Displays a list of icons.', 'siteorigin-widgets' ),
			),
			array(),
			array(
				'icons' => array(
					'type' => 'repeater',
					'label' => __('Icons', 'siteorigin-widgets'),
					'item_name' => __('Icon', 'siteorigin-widgets'),
					'fields' => array(


						'container_color' => array(
							'type' => 'color',
							'label' => __('Container Color', 'siteorigin-widgets'),
							'default' => '#404040',
						),

						'hover_color' => array(
							'type' => 'color',
							'label' => __('Container Hover Color', 'siteorigin-widgets'),
							'default' => '#404040',
						),

						// The Icon

						'icon' => array(
							'type' => 'icon',
							'label' => __('Icon', 'siteorigin-widgets'),
						),

						'icon_color' => array(
							'type' => 'color',
							'label' => __('Icon Color', 'siteorigin-widgets'),
							'default' => '#FFFFFF',
						),

						'icon_image' => array(
							'type' => 'media',
							'library' => 'image',
							'label' => __('Icon Image', 'siteorigin-widgets'),
							'description' => __('Use your own icon image.', 'siteorigin-widgets'),
						),

						'animation' => array(
						'type' => 'select',
						'label' => __('Box animation', 'siteorigin-panels'),
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
					
						'animation_delay' => array(
							'type' => 'number',
							'label' => __('Delay animation by x seconds.', 'siteorigin-widgets'),
							'default' => 0,
						),



					),
				),


				
				'container_size' => array(
					'type' => 'number',
					'label' => __('Container Size', 'siteorigin-widgets'),
					'default' => 84,
				),

				'icon_size' => array(
					'type' => 'number',
					'label' => __('Icon Size', 'siteorigin-widgets'),
					'default' => 24,
				),

				'per_row' => array(
					'type' => 'number',
					'label' => __('Icons Per Row', 'siteorigin-widgets'),
					'default' => 3,
				),

				'responsive' => array(
					'type' => 'checkbox',
					'label' => __('Responsive Layout', 'siteorigin-widgets'),
					'default' => true,
				),

				'new_window' => array(
					'type' => 'checkbox',
					'label' => __('Open More URL in New Window', 'siteorigin-widgets'),
					'default' => false,
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

	function enqueue_frontend_scripts(){
		wp_enqueue_style('siteorigin-icons', siteorigin_widget_get_plugin_dir_url('icons').'css/style.css', array(), SOW_BUNDLE_VERSION );
	}

	
}