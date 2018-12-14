<?php

class SiteOrigin_Panels_Widget_Title extends SiteOrigin_Panels_Widget  {
	function __construct() {
		parent::__construct(
			__('Title (Builder)', 'siteorigin-panels'),
			array(
				'description' => __('A title block', 'siteorigin-panels'),
				'default_style' => 'simple',
			),
			array(),
			array(
				'heading' => array(
					'type' => 'text',
					'label' => __('Heading Text', 'siteorigin-panels'),
				),

				'align' => array(
					'type' => 'select',
					'label' => __('Title Alignment', 'siteorigin-panels'),
					'options' => array(
						'left' => __('Left', 'siteorigin-panels'),
						'right' => __('Right', 'siteorigin-panels'),
						'center' => __('Center', 'siteorigin-panels'),
					)
				),

				'size' => array(
					'type' => 'select',
					'label' => __('Title Size', 'siteorigin-panels'),
					'options' => array(
						'1' => __('H1', 'siteorigin-panels'),
						'2' => __('H2', 'siteorigin-panels'),
						'3' => __('H3', 'siteorigin-panels'),
						'4' => __('H4', 'siteorigin-panels'),
						'5' => __('H5', 'siteorigin-panels'),
						'6' => __('H6', 'siteorigin-panels'),
						'p' => __('Sub heading', 'siteorigin-panels'),
					)
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

				'line' => array(
					'type' => 'checkbox',
					'label' => __('Display line below text', 'siteorigin-panels'),
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