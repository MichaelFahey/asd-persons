<?php
/**
 *
 * This is the root file of the ASD Persons WordPress plugin
 *
 * @package ASD_Persons
 * Plugin Name:    ASD Persons
 * Plugin URI:     https://artisansitedesigns.com/persons/asd-persons/
 * Description:    Defines a "Person" Custom Post Type in order to create Rich Content using JSON-LD Structured Data. Included are a grouping Taxonomy, and a shortcode
 * Author:         Michael H Fahey
 * Author URI:     https://artisansitedesigns.com/staff/michael-h-fahey/
 * Text Domain:    asd_persons
 * License:        GPL3
 * Version:        1.201904141
 *
 * ASD Persons is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * any later version.
 *
 * ASD Persons is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with ASD Persons. If not, see
 * https://www.gnu.org/licenses/gpl.html
 */

if ( ! defined( 'ABSPATH' ) ) {
	die( '' );
}

if ( ! defined( 'ASD_PERSONS_DIR' ) ) {
	define( 'ASD_PERSONS_DIR', plugin_dir_path( __FILE__ ) );
}

if ( ! defined( 'ASD_PERSONS_URL' ) ) {
	define( 'ASD_PERSONS_URL', plugin_dir_url( __FILE__ ) );
}

require_once 'includes/asd-admin-menu/asd-admin-menu.php';
require_once 'includes/asd-function-lib/asd-function-lib.php';
require_once 'includes/class-asd-addcustomposts/class-asd-addcustomposts.php';
require_once 'includes/class-asd-custom-post/class-asd-custom-post.php';
require_once 'includes/register-site-data/register-site-data.php';
require_once 'includes/class-asd-addpersons.php';
require_once 'includes/class-asd-persons.php';
require_once 'includes/class-asd-personsshortcode.php';

/* include components */
if ( ! class_exists( 'Gizburdt\Cuztom\Cuztom' ) ) {
	include 'components/cuztom/cuztom.php';
}


/** ----------------------------------------------------------------------------
 *   Function asd_persons_admin_submenu()
 *   Adds two submenu pages to the admn menu with the asd_settings slug.
 *   This admin top menu is loaded in includes/asd-admin-menu.php .
 *  --------------------------------------------------------------------------*/
function asd_persons_admin_submenu() {
	global $asd_cpt_dashboard_display_options;

	if ( get_option( 'asd_persons_display' ) !== $asd_cpt_dashboard_display_options[1] ) {
		add_submenu_page(
			'asd_settings',
			'Persons',
			'Persons',
			'manage_options',
			'edit.php?post_type=persons',
			''
		);
	}
	if ( 'false' !== get_option( 'asd_persongroups_display' ) ) {
		add_submenu_page(
			'asd_settings',
			'Person Groups',
			'Person Groups',
			'manage_options',
			'edit-tags.php?taxonomy=persongroups',
			''
		);
	}
}
if ( is_admin() ) {
	add_action( 'admin_menu', 'asd_persons_admin_submenu', 16 );
}


/** ----------------------------------------------------------------------------
 *   function instantiate_asdperson_class_object()
 *   create a single ASD_Pagersections instance
 *   Hooks into the init action
 *  --------------------------------------------------------------------------*/
function instantiate_asdperson_class_object() {
	$asd_person_type = new ASD_Persons();
}
add_action( 'init', 'instantiate_asdperson_class_object' );


/** ----------------------------------------------------------------------------
 *   function instantiate_asdperson_shortcode_object()
 *   create a single ASD_PageSectionsShortcode instance
 *   Hooks into the plugins_loaded action
 *  --------------------------------------------------------------------------*/
function instantiate_asdperson_shortcode_object() {
	new ASD_PersonsShortcode();
}
add_action( 'plugins_loaded', 'instantiate_asdperson_shortcode_object' );


/** ----------------------------------------------------------------------------
 *   function asdperson_rewrite_flush()
 *   This rewrites the permalinks but ONLY when the plugin is activated
 *  --------------------------------------------------------------------------*/
function asdperson_rewrite_flush() {
	flush_rewrite_rules();
}
register_activation_hook( __FILE__, 'asdperson_rewrite_flush' );


/** ----------------------------------------------------------------------------
 *   function asd_register_settings_asd_persons()
 *  --------------------------------------------------------------------------*/
function asd_register_settings_asd_persons() {
	register_setting( 'asd_dashboard_option_group', 'asd_persons_display' );
	register_setting( 'asd_dashboard_option_group2', 'asd_persongroups_display' );
	/** ----------------------------------------------------------------------------
	 *   add the names of the post types and taxonomies being added
	 *  --------------------------------------------------------------------------*/
	global $asd_cpt_list;
	global $asd_tax_list;
	array_push(
		$asd_cpt_list,
		array(
			'name' => 'Persons',
			'slug' => 'persons',
			'desc' => 'Facilitate setting up JSON-LD Structured Data for persons. Do not confuse with Woo Commerce persons.',
			'link' => 'https://wordpress.org/plugins/asd-persons',
		)
	);
	array_push( $asd_tax_list, 'asdpersongroups' );
}
if ( is_admin() ) {
	add_action( 'admin_init', 'asd_register_settings_asd_persons' );
}


/** ----------------------------------------------------------------------------
 *   function asd_add_settings_asd_persons()
 *  --------------------------------------------------------------------------*/
function asd_add_settings_asd_persons() {
	global $asd_cpt_dashboard_display_options;

	add_settings_field(
		'asd_persons_display_fld',
		'show Persons in:',
		'asd_select_option_insert',
		'asd_dashboard_option_group',
		'asd_dashboard_option_section_id',
		array(
			'settingname'   => 'asd_persons_display',
			'selectoptions' => $asd_cpt_dashboard_display_options,
		)
	);

}
if ( is_admin() ) {
	add_action( 'asd_dashboard_option_section', 'asd_add_settings_asd_persons' );
}

/** ----------------------------------------------------------------------------
 *   function asd_add_settings_asd_persongroups()
 *  --------------------------------------------------------------------------*/
function asd_add_settings_asd_persongroups() {
	add_settings_field(
		'asd_persongroups_display_fld',
		'show Persongroups in submenu:',
		'asd_truefalse_select_insert',
		'asd_dashboard_option_group2',
		'asd_dashboard_option_section2_id',
		'asd_persongroups_display'
	);
}
if ( is_admin() ) {
	add_action( 'asd_dashboard_option_section2', 'asd_add_settings_asd_persongroups' );
}




/** ----------------------------------------------------------------------------
 *   Function asd_persons_plugin_action_links()
 *   Adds links to the Dashboard Plugin page for this plugin.
 *  ----------------------------------------------------------------------------
 *
 *   @param Array $actions -  Returned as an array of html links.
 */
function asd_persons_plugin_action_links( $actions ) {
	if ( is_plugin_active( plugin_basename( __FILE__ ) ) ) {
		$actions[0] = '<a target="_blank" href="https://artisansitedesigns.com/persons/asd-persons/">Help</a>';
		/* $actions[1] = '<a href="' . admin_url() . '">' .  'Settings'  . '</a>';  */
	}
	return apply_filters( 'persons_actions', $actions );
}
add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), 'asd_persons_plugin_action_links' );
