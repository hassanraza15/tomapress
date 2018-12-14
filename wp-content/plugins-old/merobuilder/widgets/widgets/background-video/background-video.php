<?php

class SiteOrigin_Panels_Widget_Background_Video extends SiteOrigin_Panels_Widget  {
	function __construct() {
		parent::__construct(
			__('Background Video (Builder)', 'siteorigin-panels'),
			array(
				'description' => __('Compelte testimonial Slider ', 'siteorigin-panels'),
				'default_style' => 'simple',
			),
			array(),
			array(

				'url' => array(
					'type' => 'text',
					'label' => __('Video URL', 'siteorigin-panels'),
				),
				'container_id' => array(
					'type' => 'text',
					'label' => __('Container div ID without #', 'siteorigin-panels'),
				),
				'autoplay' => array(
					'type' => 'checkbox',
					'label' => __('Autoplay video?', 'siteorigin-panels'),
				),
				'controls' => array(
					'type' => 'checkbox',
					'label' => __('Show Controls?', 'siteorigin-panels'),
				),
				'loop' => array(
					'type' => 'checkbox',
					'label' => __('Loop Video?', 'siteorigin-panels'),
				),
				'mute' => array(
					'type' => 'checkbox',
					'label' => __('Mute Video?', 'siteorigin-panels'),
				),
				'lightbox' => array(
					'type' => 'checkbox',
					'label' => __('Lightbox Video Button?', 'siteorigin-panels'),
				),

				)
		);
	}

}