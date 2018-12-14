<?php

class SiteOrigin_Widget_Counters_Widget extends SiteOrigin_Widget {
	function __construct() {
		parent::__construct(
			'sow-counters',
			__( 'Counters (Builder)', 'siteorigin-widgets' ),
			array(
				'description' => __( 'Displays a list of counters.', 'siteorigin-widgets' ),
			),
			array(),
			array(
				'counters' => array(
					'type' => 'repeater',
					'label' => __('Counters', 'siteorigin-widgets'),
					'item_name' => __('Counter', 'siteorigin-widgets'),
					'fields' => array(

						

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

						'text' => array(
							'type' => 'text',
							'label' => __('Text', 'siteorigin-panels'),
						),

						'number' => array(
							'type' => 'text',
							'label' => __('Number', 'siteorigin-panels'),
						),

						'step_size' => array(
							'type' => 'text',
							'label' => __('Step Size', 'siteorigin-panels'),
						),

					),
				),

				'icon_size' => array(
					'type' => 'number',
					'label' => __('Icon Size', 'siteorigin-widgets'),
					'default' => 24,
				),

				'per_row' => array(
					'type' => 'number',
					'label' => __('Features Per Row', 'siteorigin-widgets'),
					'default' => 3,
				),

				'layout' => array(
						'type' => 'select',
						'label' => __('Dark/Light layout', 'siteorigin-panels'),
							'options' => array(
								'lightest' => __('Lightest', 'siteorigin-panels'),
								'light' => __('Light', 'siteorigin-panels'),
								'noraml' => __('Normal', 'siteorigin-panels'),
								'dark' => __('Dark', 'siteorigin-panels'),
								'darkest' => __('Darkest', 'siteorigin-panels'),
							),
				),

				'responsive' => array(
					'type' => 'checkbox',
					'label' => __('Responsive Layout', 'siteorigin-widgets'),
					'default' => true,
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
		wp_enqueue_style('siteorigin-widgets-counters', siteorigin_widget_get_plugin_dir_url('counters').'css/style.css', array(), SOW_BUNDLE_VERSION );
	}

	
}