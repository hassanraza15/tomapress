<?php

class SiteOrigin_Panels_Widget_Progressbar extends SiteOrigin_Panels_Widget  {
	function __construct() {
		parent::__construct(
			__('Progressbar (Builder)', 'siteorigin-panels'),
			array(
				'description' => __('A Progress bar ', 'siteorigin-panels'),
				'default_style' => 'simple',
			),
			array(),
			array(
				'title' => array(
					'type' => 'text',
					'label' => __('Title', 'siteorigin-panels'),
				),

				'percent' => array(
					'type' => 'text',
					'label' => __('Percentage (only number)', 'siteorigin-panels'),
				),
				
				'text_style' => array(
					'type' => 'select',
					'label' => __('Text Color Style', 'siteorigin-panels'),
					'options' => array(
						'lightest' => __('Lightest', 'siteorigin-panels'),
						'light' => __('Light', 'siteorigin-panels'),
						'noraml' => __('Normal', 'siteorigin-panels'),
						'dark' => __('Dark', 'siteorigin-panels'),
						'darkest' => __('Darkest', 'siteorigin-panels'),
					)
				),

			)
		);
	}

	function widget_classes($classes, $instance) {
		$classes[] = 'text-'.(empty($instance['text_style']) ? 'none' : $instance['text_style']);
		return $classes;
	}

}