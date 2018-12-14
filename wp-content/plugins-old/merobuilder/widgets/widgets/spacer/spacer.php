<?php

class SiteOrigin_Panels_Widget_Spacer extends SiteOrigin_Panels_Widget  {
	function __construct() {
		parent::__construct(
			__('Spacer (Builder)', 'siteorigin-panels'),
			array(
				'description' => __('Adds space in between div w/o line', 'siteorigin-panels'),
				'default_style' => 'simple',
			),
			array(),
			array(
				'padding' => array(
					'type' => 'text',
					'label' => __('Margin value (just value without px)', 'siteorigin-panels'),
				),
				
			)
		);
	}

}