<?php

class SiteOrigin_Panels_Widget_Map extends SiteOrigin_Panels_Widget  {
	function __construct() {
		parent::__construct(
			__('Map (Builder)', 'siteorigin-panels'),
			array(
				'description' => __('Displays a google map', 'siteorigin-panels'),
				'default_style' => 'simple',
			),
			array(),
			array(

				'address' => array(
					'type' => 'text',
					'label' => __('Address', 'siteorigin-panels'),
				),
				'description' => array(
					'type' => 'textarea',
					'label' => __('Description', 'siteorigin-panels'),
				),
				'logo_url' => array(
					'type' => 'text',
					'label' => __('Logo url', 'siteorigin-panels'),
				),
			)
		);	
	}

	
}