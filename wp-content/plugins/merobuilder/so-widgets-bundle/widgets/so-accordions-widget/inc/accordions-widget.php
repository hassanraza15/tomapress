<?php

class SiteOrigin_Widget_Accordions_Widget extends SiteOrigin_Widget {
	function __construct() {
		parent::__construct(
			'sow-accordions',
			__( 'Accordions (Builder)', 'siteorigin-widgets' ),
			array(
				'description' => __( 'Displays  group of accordions.', 'siteorigin-widgets' ),
			),
			array(),
			array(
				'accordions' => array(
					'type' => 'repeater',
					'label' => __('Accordions', 'siteorigin-widgets'),
					'item_name' => __('Accordion', 'siteorigin-widgets'),
					'fields' => array(

						'title' => array(
							'type' => 'text',
							'label' => __('Title Text', 'siteorigin-widgets'),
						),

						'text' => array(
							'type' => 'text',
							'label' => __('Text', 'siteorigin-widgets'),
						),

						'active' => array(
							'type' => 'checkbox',
							'label' => __('Is this active accordion ? ', 'siteorigin-widgets'),
							'default' => false,
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