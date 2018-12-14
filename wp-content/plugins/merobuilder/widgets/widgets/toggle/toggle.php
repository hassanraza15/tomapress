<?php

class SiteOrigin_Panels_Widget_Toggle extends SiteOrigin_Panels_Widget  {
	function __construct() {
		parent::__construct(
			__('Toggle (Builder)', 'siteorigin-panels'),
			array(
				'description' => __('An accordion block', 'siteorigin-panels'),
				'default_style' => 'default',
			),
			array(),
			array(

				'heading' => array(
					'type' => 'text',
					'label' => __('Heading', 'siteorigin-panels'),
				),
				'open' => array(
					'type' => 'checkbox',
					'label' => __('Open on start', 'siteorigin-panels'),
				),
				'body' => array(
					'type' => 'textarea',
					'label' => __('Body', 'siteorigin-panels'),
				),
				

			)
		);	
	}

	
}