<?php

class SiteOrigin_Panels_Widget_Price_Box extends SiteOrigin_Panels_Widget  {
	function __construct() {
		parent::__construct(
			__('Price Box (Builder)', 'siteorigin-panels'),
			array(
				'description' => __('Displays a price box', 'siteorigin-panels'),
				'default_style' => 'default',
			),
			array(),
			array(

				'featured' => array(
					'type' => 'checkbox',
					'label' => __('Is this featured?', 'siteorigin-panels'),
				),

				'title' => array(
					'type' => 'text',
					'label' => __('Title', 'siteorigin-panels'),
				),
				'price' => array(
					'type' => 'text',
					'label' => __('Price', 'siteorigin-panels'),
				),
				'per' => array(
					'type' => 'text',
					'label' => __('Per', 'siteorigin-panels'),
				),
				'information' => array(
					'type' => 'text',
					'label' => __('Information Text', 'siteorigin-panels'),
				),
				'features' => array(
					'type' => 'textarea',
					'label' => __('Features Text', 'siteorigin-panels'),
					'description' => __('Start each new point with an asterisk (*)', 'siteorigin-panels'),
				),
				'listicon' => array(
					'type' => 'select',
					'label' => __('List Icon', 'siteorigin-panels'),
					'options' => array(
						'none' => __('None', 'siteorigin-panels'),
						'check' => __('Check', 'siteorigin-panels'),
						'check-square' => __('Check Square', 'siteorigin-panels'),	
						'check-square-o' => __('Check Square Hollow', 'siteorigin-panels'),
						'check-circle' => __('Check Circle', 'siteorigin-panels'),
						'check-circle-o' => __('Check Circle Hollow', 'siteorigin-panels'),
						'star' => __('Star', 'siteorigin-panels'),
						'circle' => __('Circle', 'siteorigin-panels'),
						'angle-right' => __('Angle', 'siteorigin-panels'),
					)
				),
				'button_text' => array(
					'type' => 'text',
					'label' => __('Button Text', 'siteorigin-panels'),
				),
				'button_url' => array(
					'type' => 'text',
					'label' => __('Button URL', 'siteorigin-panels'),
				),
				'button_new_window' => array(
					'type' => 'checkbox',
					'label' => __('Open In New Window', 'siteorigin-panels'),
				),
				'button_one_page_scroll' => array(
					'type' => 'checkbox',
					'label' => __('One page scroll button', 'siteorigin-panels'),
				),
				'button_bstyle' => array(
					'type' => 'select',
					'label' => __('Button Style', 'siteorigin-panels'),
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
						

					)
				),
				'animation' => array(
					'type' => 'select',
					'label' => __('Box animation', 'siteorigin-panels'),
					'options' => array(
						'none' => __('none', 'siteorigin-panels'),
						'bounce' => __('bounce', 'siteorigin-panels'),
						'flash' => __('flash', 'siteorigin-panels'),
						'pulse' => __('pulse', 'siteorigin-panels'),
						'rubberBand' => __('rubberBand', 'siteorigin-panels'),
						'shake' => __('shake', 'siteorigin-panels'),
						'swing' => __('swing', 'siteorigin-panels'),
						'tada' => __('tada', 'siteorigin-panels'),
						'wobble' => __('wobble', 'siteorigin-panels'),
						'bounceIn' => __('bounceIn', 'siteorigin-panels'),
						'bounceInDown' => __('bounceInDown', 'siteorigin-panels'),
						'bounceInLeft' => __('bounceInLeft', 'siteorigin-panels'),
						'bounceInRight' => __('bounceInRight', 'siteorigin-panels'),
						'bounceInUp' => __('bounceInUp', 'siteorigin-panels'),
						'fadeIn' => __('fadeIn', 'siteorigin-panels'),
						'fadeInDown' => __('fadeInDown', 'siteorigin-panels'),
						'fadeInDownBig' => __('fadeInDownBig', 'siteorigin-panels'),
						'fadeInLeft' => __('fadeInLeft', 'siteorigin-panels'),
						'fadeInLeftBig' => __('fadeInLeftBig', 'siteorigin-panels'),
						'fadeInRight' => __('fadeInRight', 'siteorigin-panels'),
						'fadeInRightBig' => __('fadeInRightBig', 'siteorigin-panels'),
						'fadeInUp' => __('fadeInUp', 'siteorigin-panels'),
						'fadeInUpBig' => __('fadeInUpBig', 'siteorigin-panels'),
						'flip' => __('flip', 'siteorigin-panels'),
						'flipInX' => __('flipInX', 'siteorigin-panels'),
						'flipInY' => __('flipInY', 'siteorigin-panels'),
						'rotateIn' => __('rotateIn', 'siteorigin-panels'),
						'rotateInDownLeft' => __('rotateInDownLeft', 'siteorigin-panels'),
						'rotateInDownRight' => __('rotateInDownRight', 'siteorigin-panels'),
						'rotateInUpLeft' => __('rotateInUpLeft', 'siteorigin-panels'),
						'rotateInUpRight' => __('rotateInUpRight', 'siteorigin-panels'),
						'slideInDown' => __('slideInDown', 'siteorigin-panels'),
						'slideInLeft' => __('slideInLeft', 'siteorigin-panels'),
						'slideInRight' => __('slideInRight', 'siteorigin-panels'),
						'hinge' => __('hinge', 'siteorigin-panels'),
						'rollIn' => __('rollIn', 'siteorigin-panels'),
					)
				),
			)
		);

		$this->add_sub_widget('button', __('Button', 'siteorigin-panels'), 'SiteOrigin_Panels_Widget_Button');
		$this->add_sub_widget('list', __('Feature List', 'siteorigin-panels'), 'SiteOrigin_Panels_Widget_List');
	}

	function widget_classes($classes, $instance) {
		$classes[] = 'animated '.(empty($instance['animation']) ? 'none' : $instance['animation']);
		$classes[] = ' '.(empty($instance['featured']) ? '' : 'featured');
		return $classes;
	}
}