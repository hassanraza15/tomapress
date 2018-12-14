<?php

class SiteOrigin_Panels_Widget_Product_Recent extends SiteOrigin_Panels_Widget  {
	function __construct() {
		parent::__construct(
			__('Recent Products (Builder)', 'siteorigin-panels'),
			array(
				'description' => __('Show Recent WooCommerce Products ', 'siteorigin-panels'),
			),
			array(),
			array(
				'per_page' => array(
					'type' => 'text',
					'label' => __('Items Per Page number', 'siteorigin-panels'),
					
				),
				'columns' => array(
					'type' => 'text',
					'label' => __('Items column number', 'siteorigin-panels'),
					
				),				
				)
		);
	}

}