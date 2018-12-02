<?php
/**
 * A template for inserting person post types with the shorcode.
 *
 * @package        WordPress
 * @subpackage     ASD_Persons
 * Author:         Michael H Fahey
 * Author URI:     https://artisansitedesigns.com/staff/michael-h-fahey
 */

if ( ! defined( 'ABSPATH' ) ) {
	die( '' );
}

global $post;
echo '<div id="' . esc_attr( $post->post_name ) . '"></div>';
echo '<div class="asd-template-detail persons-template">';

if ( has_post_thumbnail() ) {
	echo '<div style="width:33%;float:right;">';
		the_post_thumbnail( 'full' );
	echo '</div>';
}

the_content();
echo '</div>';


