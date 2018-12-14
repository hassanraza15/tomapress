<?php

class SiteOrigin_Panels_Widget_Tweet_Slider extends SiteOrigin_Panels_Widget  {
	function __construct() {
		parent::__construct(
			__('Tweet Feed Slider (Builder)', 'siteorigin-panels'),
			array(
				'description' => __('Full Tweet Feed Slider ', 'siteorigin-panels'),
				'default_style' => 'simple',
			),
			array(),
			array(
				'autoslide' => array(
					'type' => 'checkbox',
					'label' => __('Activate Auto Slide? ', 'siteorigin-panels'),
				),

				'navigation' => array(
					'type' => 'checkbox',
					'label' => __('Show nagivation arrow? ', 'siteorigin-panels'),
				),

				'pagination' => array(
					'type' => 'checkbox',
					'label' => __('Show control pagination? ', 'siteorigin-panels'),
				),

				'slidespeed' => array(
					'type' => 'text',
					'label' => __('Slide speed', 'siteorigin-panels'),
					'description' => __('Leave blank to use default value 3500', 'siteorigin-panels'),
				),

				'slideduration' => array(
					'type' => 'text',
					'label' => __('Slide duration', 'siteorigin-panels'),
					'description' => __('Leave blank to use default value 1000', 'siteorigin-panels'),
				),
				'layout' => array(
						'type' => 'select',
						'label' => __('Dark/Light layout', 'siteorigin-panels'),
							'options' => array(
								'light' => __('Light', 'siteorigin-panels'),
								'dark' => __('Dark', 'siteorigin-panels'),
							),
				),
				
				'followtext' => array(
					'type' => 'text',
					'label' => __('Follow Label ', 'siteorigin-panels'),
				),
				
				)
		);
	}

}