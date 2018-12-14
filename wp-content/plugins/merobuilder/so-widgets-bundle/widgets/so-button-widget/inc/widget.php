<?php
class SiteOrigin_Widget_cbutton_Widget extends SiteOrigin_Widget {
	function __construct() {
		parent::__construct(
			'sow-cbutton',
			__('Button Custom(Builder)', 'siteorigin-panels'),
			array(
				'description' => __('A button block', 'siteorigin-panels'),
			),
			array(),
			array(
				'text' => array(
					'type' => 'text',
					'label' => __('Text', 'siteorigin-panels'),
				),
				'url' => array(
					'type' => 'text',
					'label' => __('Destination URL', 'siteorigin-panels'),
				),
				'new_window' => array(
					'type' => 'checkbox',
					'label' => __('Open In New Window', 'siteorigin-panels'),
				),

				'one_page_scroll' => array(
					'type' => 'checkbox',
					'label' => __('One page scroll button', 'siteorigin-panels'),
				),

				'one_page_scroll_id' => array(
					'type' => 'text',
					'label' => __('Enter the id of the div to scroll, if one page scroll is checked', 'siteorigin-panels'),
				),

				'align' => array(
					'type' => 'select',
					'label' => __('Button Alignment', 'siteorigin-panels'),
					'options' => array(
						'left' => __('Left', 'siteorigin-panels'),
						'right' => __('Right', 'siteorigin-panels'),
						'center' => __('Center', 'siteorigin-panels'),
						'justify' => __('Justify', 'siteorigin-panels'),
					)
				),

				'big_button' => array(
					'type' => 'checkbox',
					'label' => __('Want the button to be bigger?', 'siteorigin-panels'),
				),

				'round_button' => array(
					'type' => 'checkbox',
					'label' => __('Want the button to be round ?', 'siteorigin-panels'),
				),

				'bstyle' => array(
					'type' => 'select',
					'label' => __('Button Style', 'siteorigin-panels'),
					'description' => __('The design option below are active only if you choose custom button.', 'siteorigin-panels'),
					'options' => array(
						'tp-button green' => __('green', 'siteorigin-panels'),
						'tp-button blue' => __('blue', 'siteorigin-panels'),
						'tp-button red' => __('red', 'siteorigin-panels'),
						'tp-button orange' => __('orange', 'siteorigin-panels'),
						'tp-button darkgrey' => __('darkgrey', 'siteorigin-panels'),
						'tp-button lightgrey' => __('lightgrey', 'siteorigin-panels'),
						'tp-button green-fill' => __('green filled', 'siteorigin-panels'),
						'tp-button blue-fill' => __('blue filled', 'siteorigin-panels'),
						'tp-button red-fill' => __('red filled', 'siteorigin-panels'),
						'tp-button orange-fill' => __('orange filled', 'siteorigin-panels'),
						'tp-button darkgrey-fill' => __('darkgrey filled', 'siteorigin-panels'),
						'tp-button lightgrey-fill' => __('lightgrey filled', 'siteorigin-panels'),
						'custom' => __('Custom Button', 'siteorigin-panels'),
						
					)
				),

				'bg_color' => array(
							'type' => 'color',
							'label' => __('Background Color', 'siteorigin-widgets'),
				),
				
				'bg_hover_color' => array(
							'type' => 'color',
							'label' => __('Background Hover Color', 'siteorigin-widgets'),
				),
				'text_color' => array(
							'type' => 'color',
							'label' => __('Text Color', 'siteorigin-widgets'),
				),
				
				'text_hover_color' => array(
							'type' => 'color',
							'label' => __('Text Hover Color', 'siteorigin-widgets'),
				),

				'border_color' => array(
							'type' => 'color',
							'label' => __('Border Color', 'siteorigin-widgets'),
				),
				
				'border_hover_color' => array(
							'type' => 'color',
							'label' => __('Border Hover Color', 'siteorigin-widgets'),
				),


				'extra_class' => array(
					'type' => 'text',
					'label' => __('Extra class for styling', 'siteorigin-panels'),
				),
			)
		);
	}

	function get_style_name($instance){
		return false;
	}

	function get_template_name($instance){
		return 'base';
	}



	
}