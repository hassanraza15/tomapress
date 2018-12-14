<?php

class SiteOrigin_Panels_Widget_Info extends SiteOrigin_Panels_Widget  {
	function __construct() {
		parent::__construct(
			__('Information Text (Builder)', 'siteorigin-panels'),
			array(
				'description' => __('Displays a text information block', 'siteorigin-panels'),
				'default_style' => 'simple',
			),
			array(),
			array(
				'information' => array(
					'type' => 'textarea',
					'label' => __('Info Text', 'siteorigin-panels'),
				),

				'align' => array(
					'type' => 'select',
					'label' => __('Title Alignment', 'siteorigin-panels'),
					'options' => array(
						'left' => __('Left', 'siteorigin-panels'),
						'right' => __('Right', 'siteorigin-panels'),
						'center' => __('Center', 'siteorigin-panels'),
						'justify' => __('Justify', 'siteorigin-panels'),
					)
				),

				'text_style' => array(
					'type' => 'select',
					'label' => __('Text Color Style', 'siteorigin-panels'),
					'options' => array(
						'lightest' => __('Lightest', 'siteorigin-panels'),
						'light' => __('Light', 'siteorigin-panels'),
						'normal' => __('Normal', 'siteorigin-panels'),
						'dark' => __('Dark', 'siteorigin-panels'),
						'darkest' => __('Darkest', 'siteorigin-panels'),
					)
				),
				
			)
		);
	}

	function widget_classes($classes, $instance) {
		$classes[] = 'align-'.(empty($instance['align']) ? 'none' : $instance['align']);
		$classes[] = 'text-'.(empty($instance['text_style']) ? 'none' : $instance['text_style']);
		return $classes;
	}

}