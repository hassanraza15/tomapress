<?php

class SiteOrigin_Panels_Widget_Address extends SiteOrigin_Panels_Widget  {
	function __construct() {
		parent::__construct(
			__('Address (Builder)', 'siteorigin-panels'),
			array(
				'description' => __('Displays an contact address', 'siteorigin-panels'),
				'default_style' => 'simple',
			),
			array(),
			array(
			    
			   	'title' => array(
					'type' => 'text',
					'label' => __('Title text', 'siteorigin-panels'),
				),
				
				'address_label' => array(
					'type' => 'text',
					'label' => __('Label for Address', 'siteorigin-panels'),
				),
				'address' => array(
					'type' => 'text',
					'label' => __('Street Address', 'siteorigin-panels'),
				),
				'phone_label' => array(
					'type' => 'text',
					'label' => __('Label for Phone', 'siteorigin-panels'),
				),
				'phone' => array(
					'type' => 'text',
					'label' => __('Phone number', 'siteorigin-panels'),
				),
				'fax_label' => array(
					'type' => 'text',
					'label' => __('Label for Fax', 'siteorigin-panels'),
				),
				'fax' => array(
					'type' => 'text',
					'label' => __('Fax number', 'siteorigin-panels'),
				),
				'email_label' => array(
					'type' => 'text',
					'label' => __('Label for Email', 'siteorigin-panels'),
				),
				'email' => array(
					'type' => 'text',
					'label' => __('Email address', 'siteorigin-panels'),
				),
				'website_label' => array(
					'type' => 'text',
					'label' => __('Label for Website', 'siteorigin-panels'),
				),
				'website' => array(
					'type' => 'text',
					'label' => __('Web address', 'siteorigin-panels'),
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