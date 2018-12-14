<?php

class SiteOrigin_Panels_Widget_Team_Box extends SiteOrigin_Panels_Widget  {
	function __construct() {
		parent::__construct(
			__('Team Box (Builder)', 'siteorigin-panels'),
			array(
				'description' => __('Displays a team member box', 'siteorigin-panels'),
				'default_style' => 'default',
			),
			array(),
			array(
				'name' => array(
					'type' => 'text',
					'label' => __('Name', 'siteorigin-panels'),
				),
				'cpost' => array(
					'type' => 'text',
					'label' => __('Post in company', 'siteorigin-panels'),
				),
				'facebook' => array(
					'type' => 'text',
					'label' => __('Facebook personal address.', 'siteorigin-panels'),
				),
				'twitter' => array(
					'type' => 'text',
					'label' => __('Twitter personal address.', 'siteorigin-panels'),
				),
				
				'linkedin' => array(
					'type' => 'text',
					'label' => __('Linkedin personal address.', 'siteorigin-panels'),
				),

				'gplus' => array(
					'type' => 'text',
					'label' => __('Google Plus personal address.', 'siteorigin-panels'),
				),
				
				't-email' => array(
					'type' => 'text',
					'label' => __('Email personal.', 'siteorigin-panels'),
				),

				'github' => array(
					'type' => 'text',
					'label' => __('Github personal address.', 'siteorigin-panels'),
				),

				'image_url' => array(
					'type' => 'text',
					'label' => __('Image URL', 'siteorigin-panels'),
				),
				'image_new_window' => array(
					'type' => 'checkbox',
					'label' => __('Open In New Window', 'siteorigin-panels'),
				),
				
				'shortintro' => array(
					'type' => 'textarea',
					'label' => __('Shot Intro', 'siteorigin-panels'),
					'description' => __('Enter the short introduction.', 'siteorigin-panels'),
				),

				'hovereffect' => array(
					'type' => 'select',
					'label' => __('Hover effect style', 'siteorigin-panels'),
					'options' => array(
						'hoverleft' => __('Hover Left ', 'siteorigin-panels'),
						'hovercenter' => __('Hover Center', 'siteorigin-panels'),
						'hoverright' => __('Hover Right', 'siteorigin-panels'),
						),
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
	}

	function widget_classes($classes, $instance) {
		$classes[] = 'wow '.(empty($instance['animation']) ? 'none' : $instance['animation']);
		return $classes;
	}

	
}