<?php
/*
Plugin Name: Cube Portfolio
Plugin URI: http://scriptpie.com
Description: Cube Portfolio - Responsive Wordpress Grid Plugin
Author: Mihai Buricea
Version: 1.4.1
Author URI: http://codecanyon.net/user/bmihai
Text Domain: cubeportfolio
Domain Path: /languages
*/

if ( defined( 'ABSPATH' ) && !class_exists('CubePortfolioMain') ) {

    if(!defined('CUBEPORTFOLIO_VERSION')) {
        
         define( 'CUBEPORTFOLIO_VERSION', '1.4.1' );
    }

    if(!defined('CUBEPORTFOLIO_TEXTDOMAIN')) {
        define( 'CUBEPORTFOLIO_TEXTDOMAIN', 'cubeportfolio' );
    }

    if(!defined('CUBEPORTFOLIO_DIRNAME')) {
        define( 'CUBEPORTFOLIO_DIRNAME', dirname( plugin_basename( __FILE__ ) ) );
    }

    if(!defined('CUBEPORTFOLIO_PATH')) {
        define( 'CUBEPORTFOLIO_PATH', trailingslashit( dirname( __FILE__ ) ) );
    }

    if(!defined('CUBEPORTFOLIO_URL')) {
        define( 'CUBEPORTFOLIO_URL', trailingslashit( plugins_url( '', __FILE__ ) ) );
    }

}

require_once CUBEPORTFOLIO_PATH . 'php/CubePortfolioMain.php';

$cbp = new CubePortfolioMain( __FILE__ );
