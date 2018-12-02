<?php
/**
 *  Defines the ASD_PersonsShortcode class.
 *
 *  @package         WordPress
 *  @subpackage      ASD_Persons
 *  Author:          Michael H Fahey
 *  Author URI:      https://artisansitedesigns.com/staff/michael-h-fahey
 */

if ( ! defined( 'ABSPATH' ) ) {
	die( '' );
}

/** ----------------------------------------------------------------------------
 *   class ASD_PersonsShortcode
 *   used to create a shortcode for person post types and instantiate the
 *   ASD_AddPersons class to return template-formatted post data.
 *  --------------------------------------------------------------------------*/
class ASD_PersonsShortcode {

		/** ----------------------------------------------------------------------------
		 *   constructor
		 *   Defines a new shortcode for inserting person custom post types.
		 *   Shortcode is [asd_insert_persons]
		 *  --------------------------------------------------------------------------*/
	public function __construct() {
		add_shortcode( 'asd_insert_persons', array( &$this, 'asd_insert_persons' ) );
	}

		/** ----------------------------------------------------------------------------
		 *   function asd_insert_persons( $shortcode_params )
		 *   This function is a callback set in add_shortcode in the class constructor.
		 *   This function instantiates a new ASD_AddPersons class object and
		 *   passes parameter data from the shortcode to the new object.
		 *  ----------------------------------------------------------------------------
		 *
		 *   @param Array $shortcode_params - data from the shortcode.
		 */
	public function asd_insert_persons( $shortcode_params ) {
		$shortcode_posts = new ASD_AddPersons( $shortcode_params );

		ob_start();
		echo wp_kses_post( $shortcode_posts->output_customposts() );
		return ob_get_clean();
	}
}

