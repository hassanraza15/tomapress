<?php
class SiteOrigin_Widget_Tabs_Widget extends SiteOrigin_Widget {
	function __construct() {
		parent::__construct(
			'sow-tabs',
			__( 'Tabs (Builder)', 'siteorigin-widgets' ),
			array(
				'description' => __( 'Displays a group of tabs.', 'siteorigin-widgets' ),
			),
			array(),
			array(
				'tabs' => array(
					'type' => 'repeater',
					'label' => __('Tabs', 'siteorigin-widgets'),
					'item_name' => __('Tab', 'siteorigin-widgets'),
					'fields' => array(

						'title' => array(
							'type' => 'text',
							'label' => __('Title Text', 'siteorigin-widgets'),
						),

						'text' => array(
							'type' => 'textarea',
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