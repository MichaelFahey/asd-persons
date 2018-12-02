<?php
/**
 *
 * Defines the ASD_Persons class.
 *
 * @package        WordPress
 * Plugin Name:    Defines class ASD_Persons
 * Author:         Michael H Fahey
 * Author URI:     https://artisansitedesigns.com/staff/michael-h-fahey/
 * description:    Defines the ASD_Persons class.
 */

if ( ! defined( 'ABSPATH' ) ) {
	die( '' );
}

if ( ! class_exists( 'ASD_Persons' ) ) {
	/** ----------------------------------------------------------------------------
	 *   Defines the class ASD_Persons
	 *  --------------------------------------------------------------------------*/
	class ASD_Persons extends ASD_Custom_Post_1_201811241 {

		/** ----------------------------------------------------------------------------
		 *
		 * @var $customargs holds settings for the custom post type
		 *  --------------------------------------------------------------------------*/
		private $customargs = array(
			'label'               => 'Persons',
			'description'         => 'Persons',
			'labels'              => array(
				'name'               => 'Persons',
				'singular_name'      => 'Person',
				'menu_name'          => 'Persons',
				'parent_item_colon'  => 'Parent Person:',
				'all_items'          => 'All Persons',
				'view_item'          => 'View Person',
				'add_new_item'       => 'Add New Person',
				'add_new'            => 'Add New',
				'edit_item'          => 'Edit Person',
				'update_item'        => 'Update Person',
				'search_items'       => 'Search Persons',
				'not_found'          => 'Person Not Found',
				'not_found_in_trash' => 'Person Not Found In Trash',
			),
			'supports'            => array( 'title', 'editor', 'author', 'thumbnail', 'revisions', 'page-attributes' ),
			'taxonomies'          => array( 'persongroups', 'category' ),
			'heirarchical'        => false,
			'public'              => true,
			'has_archive'         => false,
			'rewrite'             => array( 'slug' => 'persons' ),
			'capability_type'     => 'page',
			'exclude_from_search' => false,
			'publicly_queryable'  => true,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'show_in_nav_menus'   => true,
			'show_in_admin_bar'   => true,
			'show_admin_column'   => true,
			'can_export'          => true,
			'menu_position'       => 31,
		);

		/** ----------------------------------------------------------------------------
		 *
		 * @var $meta_section_def defines custom post meta fields for passing
		 * to cuztom functions.
		 *  --------------------------------------------------------------------------*/
		private $meta_section_def = array(
			'title'  => 'Person Fields',
			'fields' => array(
				array(
					'id'    => 'person_jobTitle',
					'label' => 'Title',
					'type'  => 'text',
				),
				array(
					'id'          => 'person_description',
					'label'       => 'Alternate Description',
					'description' => 'If this Alternate Description field is populated, it will be used as the Description field in Structured Data. ',
					'type'        => 'textarea',
				),
				array(
					'id'          => 'person_image',
					'label'       => 'Person Image URL',
					'description' => 'Use this if a Featured Image is not set. If featured image is used, this field is ignored',
					'type'        => 'text',
				),
				array(
					'id'    => 'person_email',
					'label' => 'Email Address',
					'type'  => 'text',
				),
				array(
					'id'    => 'person_telephone',
					'label' => 'Telephone',
					'type'  => 'text',
				),
				array(
					'id'    => 'person_sameAs',
					'label' => 'official website URL',
					'type'  => 'text',
				),
			),
		);

		/** ----------------------------------------------------------------------------
		 *   function __construct()
		 *   Constructor, calls the parent constructor, adds structured data hook
		 *   to the wp_print_footer_scripts action.
		 *  --------------------------------------------------------------------------*/
		public function __construct() {

			/* check the option, and if it's not set don't show this cpt in the dashboard main meny */
			global $asd_cpt_dashboard_display_options;
			if ( get_option( 'asd_persons_display' ) === $asd_cpt_dashboard_display_options[2] ) {
				$this->customargs['show_in_menu'] = 0;
			}

			parent::__construct( 'persons', $this->customargs );
			$meta_section = register_cuztom_meta_box( 'meta_section', $this->custom_type_name, $this->meta_section_def );

			add_action( 'wp_print_footer_scripts', array( &$this, 'person_json' ) );
		}

		/** ----------------------------------------------------------------------------
		 *   function person_json()
		 *   prints json-ld structured data
		 *  --------------------------------------------------------------------------*/
		public function person_json() {

			global $post;

			if ( get_post_type( $post ) === 'persons' ) {
				$a_person = array();

				$a_person['@context'] = 'https://schema.org/';
				$a_person['@type']    = 'Person';
				$a_person['name']     = the_title( '', '', false );
				if ( get_post_meta( $post->ID, 'person_description', true ) ) {
					$a_person['description'] = esc_attr( get_post_meta( $post->ID, 'person_description', true ) );
				}
				if ( get_post_meta( $post->ID, 'person_jobTitle', true ) ) {
					$a_person['jobTitle'] = esc_attr( get_post_meta( $post->ID, 'person_jobTitle', true ) );
				}

				if ( has_post_thumbnail( $post->ID ) ) {
					$image             = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'single-post-thumbnail' );
					$a_person['image'] = $image[0];
				} else {
					if ( get_post_meta( $post->ID, 'person_image', true ) ) {
						$a_person['image'] = esc_url_raw( get_post_meta( $post->ID, 'person_image', true ) );
					}
				}

				if ( get_option( 'asd_fastbuild_org' )['text_string'] ) {
					if ( get_option( 'asd_fastbuild_org_type' )['text_string'] ) {
						$a_organization           = array();
						$a_organization ['@type'] = esc_attr( get_option( 'asd_fastbuild_org_type' )['text_string'] );
						$a_organization ['name']  = esc_attr( get_option( 'asd_fastbuild_org' )['text_string'] );
						if ( get_option( 'asd_fastbuild_org_image' )['text_string'] ) {
							$a_organization['image'] = esc_attr( get_option( 'asd_fastbuild_org_image' )['text_string'] );
						}

						$a_address         = array();
						$a_ddress['@type'] = 'PostalAddress';
						if ( get_option( 'asd_fastbuild_addr_street1' )['text_string'] ) {
							$a_address['streetAddress'] = esc_attr( get_option( 'asd_fastbuild_addr_street1' )['text_string'] );
						}
						if ( get_option( 'asd_fastbuild_addr_city' )['text_string'] ) {
							$a_address['addressLocality'] = esc_attr( get_option( 'asd_fastbuild_addr_city' )['text_string'] );
						}
						if ( get_option( 'asd_fastbuild_addr_state' )['text_string'] ) {
							$a_address['addressRegion'] = esc_attr( get_option( 'asd_fastbuild_addr_state' )['text_string'] );
						}
						if ( get_option( 'asd_fastbuild_addr_zip' )['text_string'] ) {
							$a_address['postalCode'] = esc_attr( get_option( 'asd_fastbuild_addr_zip' )['text_string'] );
						}

						if ( get_option( 'asd_fastbuild_addr_country' )['text_string'] ) {
							$a_address['addressCountry'] = esc_attr( get_option( 'asd_fastbuild_addr_country' )['text_string'] );
						}
						$a_organization['address'] = $a_address;

						if ( get_option( 'asd_fastbuild_org_pricerange' )['text_string'] ) {
							$a_organization['priceRange'] = esc_attr( get_option( 'asd_fastbuild_org_pricerange' )['text_string'] );
						}
						if ( get_option( 'asd_fastbuild_phone1' )['text_string'] ) {
							$a_organization['telephone'] = esc_attr( get_option( 'asd_fastbuild_phone1' )['text_string'] );
						}
						if ( get_option( 'asd_fastbuild_email_info' )['text_string'] ) {
							$a_organization['email'] = esc_attr( get_option( 'asd_fastbuild_email_info' )['text_string'] );
						}
						$a_offer ['seller'] = $a_organization;
					}
				}
					$a_person['memberOf'] = $a_organization;

				echo '<script type="application/ld+json">' . "\r\n";
				echo wp_json_encode( $a_person, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES );
				echo '</script>' . "\r\n";
			}

		}

	}

}


