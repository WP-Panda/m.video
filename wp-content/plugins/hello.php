<?php
/*
Plugin Name: Category Adder
Plugin URI: http://wp-example.com
Description: This plugin add new category
Author: Andrew 
Version: 1.0
Author URI: 
*/

//register_activation_hook(__FILE__, 'activate_options');

register_deactivation_hook(__FILE__, 'deactivate_options');

add_action('admin_menu', 'plugin_setting_menu_item');

function plugin_setting_menu_item()
{
	add_options_page('RDolls Category Adder', 'RDolls Category Setting', 8, __FILE__, 'plugin_setting_page');
}

function plugin_setting_page()
{

}