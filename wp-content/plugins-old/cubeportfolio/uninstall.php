<?php

if( !defined('ABSPATH') ) {
    exit();
}

if( !defined('WP_UNINSTALL_PLUGIN') ) {
    exit();
}

require_once( 'php/CubePortfolioMain.php' );

global $wpdb;

$wpdb->query('DROP TABLE IF EXISTS ' .  $wpdb->prefix . CubePortfolioMain::$table_cbp);
$wpdb->query('DROP TABLE IF EXISTS ' .  $wpdb->prefix . CubePortfolioMain::$table_cbp_items);

delete_option('cubeportfolio_version');
delete_option('cubeportfolio_settings');
// @todo - delete other options
