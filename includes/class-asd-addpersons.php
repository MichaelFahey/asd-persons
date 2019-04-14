<?php
/**
 * Defines the ASD_AddPersons class
 *
 * @package        WordPress
 * @subpackage     ASD_Persons
 * Author:         Michael H Fahey
 * Author URI:     https://artisansitedesigns.com/staff/michael-h-fahey
 */

if ( ! defined( 'ABSPATH' ) ) {
	die( '' );
}

/** ----------------------------------------------------------------------------
 *   class ASD_AddPersons
 *   instantiated by an instance of the ASD_PersonsShortscode class,
 *   which also passes along the shortcode parameters.
 *  --------------------------------------------------------------------------*/
class ASD_AddPersons extends ASD_AddCustomPosts_1_201904141 {

	/** ----------------------------------------------------------------------------
	 *   contsructor
	 *   calls two functions, to set default shortcode parameters,
	 *   and another to parse parameters from the shortcode
	 *  ----------------------------------------------------------------------------
	 *
	 *   @param Array $atts - Parameters passed from the shortcode through
	 *   the ASD_PersonsShortscode instance.
	 */
	public function __construct( $atts ) {
		parent::__construct( $atts, ASD_PERSONS_DIR, 'persons-template.php', 'persons' );
	}

}

