<?php
/**
 * Defines Site Data Settings Fields for use in Widgets, Structured Data, etc.
 *
 * @package     WordPress
 * @subpackage  ASD_Site_Data
 * Author:      Michael H Fahey
 * Author URI:  https://artisansitedesigns.com/staff/michael-h-fahey
 * Version:     1.201812042
 */

if ( ! defined( 'ABSPATH' ) ) {
	die( '' );
}

/** ------------------------------------------------------------------------------------
 * NOTE ON ODD FUNCTION NAMES WITH INCLUDED VERSIONS
 *
 * Because it is possible/likely that multiple versions of this module will be
 * present if multiple ASD plugins are installed, especially during updates,
 * there is a versioning mechanism built in:
 * The values of the version of this module ($this_asd_register_site_data_version)
 * is compared to the value of the currently hooked version ($asd_register_site_data_version)
 * and if this module is higher version, the function
 *   unhook_asd_register_site_data_functions_1_201812042();
 * is called to unhook the old version, and the function
 *   setup_asd_register_site_data_functions_1_201812042();
 * is called to hook the new versions.
 * This can happen more than once, so that in the end the highest version
 * will be the one that is hooked.
 * ---------------------------------------------------------------------------------- */

$asd_registersitedata_file_data      = get_file_data( __FILE__, array( 'Version' => 'Version' ) );
$this_asd_register_site_data_version = $asd_registersitedata_file_data['Version'];


require_once plugin_dir_path( __FILE__ ) . '../asd-function-lib/asd-function-lib.php';


if ( ! function_exists( 'unhook_asd_register_site_data_functions_1_201812042' ) ) {
	/** ----------------------------------------------------------------------------
	 *   called to unhook the previous hooked scripts from filters if a newer version
	 *   is detected
	 *  --------------------------------------------------------------------------*/
	function unhook_asd_register_site_data_functions_1_201812042() {
		global $asd_register_site_data_version;
		$underscore_asd_register_site_data_version = str_replace( '.', '_', $asd_register_site_data_version );

		remove_action( 'admin_enqueue_scripts', 'asd_fastbuild_sitedata_admin_enqueues_' . $underscore_asd_register_site_data_version );
		remove_action( 'admin_init', 'asd_register_fastbuild_options_' . $underscore_asd_register_site_data_version );
		remove_action( 'register_site_data', 'asd_fastbuild_register_site_data_' . $underscore_asd_register_site_data_version, 12 );
		remove_action( 'wp_print_footer_scripts', 'asd_organization_json_' . $underscore_asd_register_site_data_version );

	}
}


if ( ! function_exists( 'setup_asd_register_site_data_functions_1_201812042' ) ) {
	/** ----------------------------------------------------------------------------
	 *   contains the functions for this version of register site data
	 *  --------------------------------------------------------------------------*/
	function setup_asd_register_site_data_functions_1_201812042() {

		if ( ! function_exists( 'asd_fastbuild_sitedata_admin_enqueues_1_201812042' ) ) {
			/** ----------------------------------------------------------------------------
			 *   Function asd_fastbuild_sitedata_admin_enqueues()
			 *   Enqueues WordPress plugin-provided jQuery-ui
			 *   Hooks into admin_enqueue_scripts action
			 *  --------------------------------------------------------------------------*/
			function asd_fastbuild_sitedata_admin_enqueues_1_201812042() {
				global $this_asd_register_site_data_version;
					wp_enqueue_script( 'jquery' );
					wp_enqueue_script( 'jquery-ui-core' );
					wp_enqueue_script( 'jquery-ui-tabs' );
					wp_enqueue_style( 'asd-jquery-ui', plugin_dir_path( __FILE__ ) . 'css/jquery-ui.min.css', array(), $this_asd_register_site_data_version );
			}
			add_action( 'admin_enqueue_scripts', 'asd_fastbuild_sitedata_admin_enqueues_1_201812042' );
		}

		if ( ! function_exists( 'asd_register_fastbuild_options_1_201812042' ) ) {
			/** ----------------------------------------------------------------------------
			 *   Function asd_register_fastbuild_options()
			 *   Register settings to store organization data, for displaying in
			 *   widgets, and for inserting into Structured Data
			 *  --------------------------------------------------------------------------*/
			function asd_register_fastbuild_options_1_201812042() {
				add_settings_section( 'asd_fastbuild_org', 'Organization', 'asd_fastbuild_org_panel_1_201812042', 'asd_fastbuild_group_org' );
				register_setting( 'asd_fastbuild_group_org', 'asd_fastbuild_org' );
				register_setting( 'asd_fastbuild_group_org', 'asd_fastbuild_org_legal' );
				register_setting( 'asd_fastbuild_group_org', 'asd_fastbuild_org_type' );

				register_setting( 'asd_fastbuild_group_org', 'asd_fastbuild_org_logo' );
				register_setting( 'asd_fastbuild_group_org', 'asd_fastbuild_org_image' );

				register_setting( 'asd_fastbuild_group_org', 'asd_fastbuild_org_desc' );

				register_setting( 'asd_fastbuild_group_org', 'asd_fastbuild_org_pricerange' );

				add_settings_section( 'asd_fastbuild_addr', 'Address', 'asd_fastbuild_addr_panel_1_201812042', 'asd_fastbuild_group_org' );
				register_setting( 'asd_fastbuild_group_org', 'asd_fastbuild_addr_street1' );
				register_setting( 'asd_fastbuild_group_org', 'asd_fastbuild_addr_city' );
				register_setting( 'asd_fastbuild_group_org', 'asd_fastbuild_addr_state' );
				register_setting( 'asd_fastbuild_group_org', 'asd_fastbuild_addr_zip' );

				add_settings_section( 'asd_fastbuild_phone', 'Phone', 'asd_fastbuild_phone_panel_1_201812042', 'asd_fastbuild_group_org' );
				register_setting( 'asd_fastbuild_group_org', 'asd_fastbuild_phone1' );
				register_setting( 'asd_fastbuild_group_org', 'asd_fastbuild_phone2' );

				add_settings_section( 'asd_fastbuild_contact', 'Contact', 'asd_fastbuild_contact_panel_1_201812042', 'asd_fastbuild_group_org' );
				register_setting( 'asd_fastbuild_group_org', 'asd_fastbuild_email_info' );

				add_settings_section( 'asd_fastbuild_hours', 'Hours', 'asd_fastbuild_hours_panel_1_201812042', 'asd_fastbuild_group_hours' );
				register_setting( 'asd_fastbuild_group_hours', 'asd_fastbuild_hours_mon_start1' );
				register_setting( 'asd_fastbuild_group_hours', 'asd_fastbuild_hours_mon_end1' );

				register_setting( 'asd_fastbuild_group_hours', 'asd_fastbuild_hours_tue_start1' );
				register_setting( 'asd_fastbuild_group_hours', 'asd_fastbuild_hours_tue_end1' );

				register_setting( 'asd_fastbuild_group_hours', 'asd_fastbuild_hours_wed_start1' );
				register_setting( 'asd_fastbuild_group_hours', 'asd_fastbuild_hours_wed_end1' );

				register_setting( 'asd_fastbuild_group_hours', 'asd_fastbuild_hours_thu_start1' );
				register_setting( 'asd_fastbuild_group_hours', 'asd_fastbuild_hours_thu_end1' );

				register_setting( 'asd_fastbuild_group_hours', 'asd_fastbuild_hours_fri_start1' );
				register_setting( 'asd_fastbuild_group_hours', 'asd_fastbuild_hours_fri_end1' );

				register_setting( 'asd_fastbuild_group_hours', 'asd_fastbuild_hours_sat_start1' );
				register_setting( 'asd_fastbuild_group_hours', 'asd_fastbuild_hours_sat_end1' );

				register_setting( 'asd_fastbuild_group_hours', 'asd_fastbuild_hours_sun_start1' );
				register_setting( 'asd_fastbuild_group_hours', 'asd_fastbuild_hours_sun_end1' );

				add_settings_section( 'asd_fastbuild_social', 'Social Media', 'asd_fastbuild_social_panel_1_201812042', 'asd_fastbuild_group_social' );
				register_setting( 'asd_fastbuild_group_social', 'asd_fastbuild_social_facebook' );
				register_setting( 'asd_fastbuild_group_social', 'asd_fastbuild_social_gplus' );
				register_setting( 'asd_fastbuild_group_social', 'asd_fastbuild_social_instagram' );
				register_setting( 'asd_fastbuild_group_social', 'asd_fastbuild_social_linkedin' );
				register_setting( 'asd_fastbuild_group_social', 'asd_fastbuild_social_pinterest' );
				register_setting( 'asd_fastbuild_group_social', 'asd_fastbuild_social_twitter' );
				register_setting( 'asd_fastbuild_group_social', 'asd_fastbuild_social_youtube' );
				register_setting( 'asd_fastbuild_group_social', 'asd_fastbuild_social_yelp' );
			}
			if ( is_admin() ) {
				add_action( 'admin_init', 'asd_register_fastbuild_options_1_201812042' );
			}
		}

		if ( ! function_exists( 'asd_fastbuild_org_panel_1_201812042' ) ) {
			/** ----------------------------------------------------------------------------
			 *   Function asd_fastbuild_org_panel()
			 *   callback function to build the organization part of the
			 *   Site Data admin panel
			 *  --------------------------------------------------------------------------*/
			function asd_fastbuild_org_panel_1_201812042() {
				add_settings_field( 'asd_fastbuild_org_fld', 'Organization Name', 'asd_fld_insert', 'asd_fastbuild_group_org', 'asd_fastbuild_org', 'asd_fastbuild_org' );
				add_settings_field( 'asd_fastbuild_org_legal_fld', 'Legal Name', 'asd_fld_insert', 'asd_fastbuild_group_org', 'asd_fastbuild_org', 'asd_fastbuild_org_legal' );
				add_settings_field( 'asd_fastbuild_org_type_fld', 'Organization Type (schema.org)', 'asd_fld_insert', 'asd_fastbuild_group_org', 'asd_fastbuild_org', 'asd_fastbuild_org_type' );
				add_settings_field( 'asd_fastbuild_org_logo_fld', 'Logo', 'asd_fld_insert', 'asd_fastbuild_group_org', 'asd_fastbuild_org', 'asd_fastbuild_org_logo' );
				add_settings_field( 'asd_fastbuild_org_image_fld', 'Image', 'asd_fld_insert', 'asd_fastbuild_group_org', 'asd_fastbuild_org', 'asd_fastbuild_org_image' );
				add_settings_field( 'asd_fastbuild_org_desc_fld', 'Description', 'asd_fld_insert', 'asd_fastbuild_group_org', 'asd_fastbuild_org', 'asd_fastbuild_org_desc' );
				add_settings_field( 'asd_fastbuild_org_pricerange_fld', 'Price Rage (for local business ex:"$35 - $150)', 'asd_fld_insert', 'asd_fastbuild_group_org', 'asd_fastbuild_org', 'asd_fastbuild_org_pricerange' );
			}
		}

		if ( ! function_exists( 'asd_fastbuild_addr_panel_1_201812042' ) ) {
			/** ----------------------------------------------------------------------------
			 *   Function asd_fastbuild_addr_panel()
			 *   callback function to build the address part of the
			 *   Site Data admin panel
			 *  --------------------------------------------------------------------------*/
			function asd_fastbuild_addr_panel_1_201812042() {
				add_settings_field( 'asd_fastbuild_addr_street1_fld', 'Street Address 1', 'asd_fld_insert', 'asd_fastbuild_group_org', 'asd_fastbuild_addr', 'asd_fastbuild_addr_street1' );
				add_settings_field( 'asd_fastbuild_addr_city_fld', 'City', 'asd_fld_insert', 'asd_fastbuild_group_org', 'asd_fastbuild_addr', 'asd_fastbuild_addr_city' );
				add_settings_field( 'asd_fastbuild_addr_state_fld', 'State', 'asd_fld_insert', 'asd_fastbuild_group_org', 'asd_fastbuild_addr', 'asd_fastbuild_addr_state' );
				add_settings_field( 'asd_fastbuild_addr_zip_fld', 'Zip', 'asd_fld_insert', 'asd_fastbuild_group_org', 'asd_fastbuild_addr', 'asd_fastbuild_addr_zip' );
			}
		}

		if ( ! function_exists( 'asd_fastbuild_phone_panel_1_201812042' ) ) {
			/** ----------------------------------------------------------------------------
			 *   Function asd_fastbuild_phone_panel()
			 *   callback function to build the phone part of the
			 *   Site Data admin panel
			 *  --------------------------------------------------------------------------*/
			function asd_fastbuild_phone_panel_1_201812042() {
				add_settings_field( 'asd_fastbuild_phone1_fld', 'Phone 1', 'asd_fld_insert', 'asd_fastbuild_group_org', 'asd_fastbuild_phone', 'asd_fastbuild_phone1' );
				add_settings_field( 'asd_fastbuild_phone2_fld', 'Phone 1', 'asd_fld_insert', 'asd_fastbuild_group_org', 'asd_fastbuild_phone', 'asd_fastbuild_phone2' );
			}
		}

		if ( ! function_exists( 'asd_fastbuild_contact_panel_1_201812042' ) ) {
			/** ----------------------------------------------------------------------------
			 *   Function asd_fastbuild_contact_panel()
			 *   callback function to build the contact part of the
			 *   Site Data admin panel
			 *  --------------------------------------------------------------------------*/
			function asd_fastbuild_contact_panel_1_201812042() {
				add_settings_field( 'asd_fastbuild_email_info_fld', 'Contact Email', 'asd_fld_insert', 'asd_fastbuild_group_org', 'asd_fastbuild_contact', 'asd_fastbuild_email_info' );
			}
		}

		if ( ! function_exists( 'asd_fastbuild_hours_panel_1_201812042' ) ) {
			/** ----------------------------------------------------------------------------
			 *   Function asd_fastbuild_hours_panel()
			 *   callback function to build the hours part of the
			 *   Site Data admin panel
			 *  --------------------------------------------------------------------------*/
			function asd_fastbuild_hours_panel_1_201812042() {
				add_settings_field( 'asd_fastbuild_hours_mon_start1_fld', 'Monday Start', 'asd_fld_insert_narrow', 'asd_fastbuild_group_hours', 'asd_fastbuild_hours', 'asd_fastbuild_hours_mon_start1' );
				add_settings_field( 'asd_fastbuild_hours_mon_end1_fld', 'Monday End', 'asd_fld_insert_narrow', 'asd_fastbuild_group_hours', 'asd_fastbuild_hours', 'asd_fastbuild_hours_mon_end1' );

				add_settings_field( 'asd_fastbuild_hours_tue_start1_fld', 'Tuesday Start', 'asd_fld_insert_narrow', 'asd_fastbuild_group_hours', 'asd_fastbuild_hours', 'asd_fastbuild_hours_tue_start1' );
				add_settings_field( 'asd_fastbuild_hours_tue_end1_fld', 'Tuesday End', 'asd_fld_insert_narrow', 'asd_fastbuild_group_hours', 'asd_fastbuild_hours', 'asd_fastbuild_hours_tue_end1' );

				add_settings_field( 'asd_fastbuild_hours_wed_start1_fld', 'Wednesday Start', 'asd_fld_insert_narrow', 'asd_fastbuild_group_hours', 'asd_fastbuild_hours', 'asd_fastbuild_hours_wed_start1' );
				add_settings_field( 'asd_fastbuild_hours_wed_end1_fld', 'Wednesday End', 'asd_fld_insert_narrow', 'asd_fastbuild_group_hours', 'asd_fastbuild_hours', 'asd_fastbuild_hours_wed_end1' );

				add_settings_field( 'asd_fastbuild_hours_thu_start1_fld', 'Thurdsay Start', 'asd_fld_insert_narrow', 'asd_fastbuild_group_hours', 'asd_fastbuild_hours', 'asd_fastbuild_hours_thu_start1' );
				add_settings_field( 'asd_fastbuild_hours_thu_end1_fld', 'Thurdsay End', 'asd_fld_insert_narrow', 'asd_fastbuild_group_hours', 'asd_fastbuild_hours', 'asd_fastbuild_hours_thu_end1' );

				add_settings_field( 'asd_fastbuild_hours_fri_start1_fld', 'Friday Start', 'asd_fld_insert_narrow', 'asd_fastbuild_group_hours', 'asd_fastbuild_hours', 'asd_fastbuild_hours_fri_start1' );
				add_settings_field( 'asd_fastbuild_hours_fri_end1_fld', 'Friday End', 'asd_fld_insert_narrow', 'asd_fastbuild_group_hours', 'asd_fastbuild_hours', 'asd_fastbuild_hours_fri_end1' );

				add_settings_field( 'asd_fastbuild_hours_sat_start1_fld', 'Saturday Start', 'asd_fld_insert_narrow', 'asd_fastbuild_group_hours', 'asd_fastbuild_hours', 'asd_fastbuild_hours_sat_start1' );
				add_settings_field( 'asd_fastbuild_hours_sat_end1_fld', 'Saturday End', 'asd_fld_insert_narrow', 'asd_fastbuild_group_hours', 'asd_fastbuild_hours', 'asd_fastbuild_hours_sat_end1' );

				add_settings_field( 'asd_fastbuild_hours_sun_start1_fld', 'Sunday Start', 'asd_fld_insert_narrow', 'asd_fastbuild_group_hours', 'asd_fastbuild_hours', 'asd_fastbuild_hours_sun_start1' );
				add_settings_field( 'asd_fastbuild_hours_sun_end1_fld', 'Sunday End', 'asd_fld_insert_narrow', 'asd_fastbuild_group_hours', 'asd_fastbuild_hours', 'asd_fastbuild_hours_sun_end1' );
			}
		}

		if ( ! function_exists( 'asd_fastbuild_social_panel_1_201812042' ) ) {
			/** ----------------------------------------------------------------------------
			 *   Function asd_fastbuild_social_panel()
			 *   callback function to build the social media links part of the
			 *   Site Data admin panel
			 *  --------------------------------------------------------------------------*/
			function asd_fastbuild_social_panel_1_201812042() {
				add_settings_field( 'asd_fastbuild_social_facebook_fld', 'Facebook URL', 'asd_fld_insert', 'asd_fastbuild_group_social', 'asd_fastbuild_social', 'asd_fastbuild_social_facebook' );
				add_settings_field( 'asd_fastbuild_social_gplus_fld', 'Google+ URL', 'asd_fld_insert', 'asd_fastbuild_group_social', 'asd_fastbuild_social', 'asd_fastbuild_social_gplus' );
				add_settings_field( 'asd_fastbuild_social_instagram_fld', 'Instagram URL', 'asd_fld_insert', 'asd_fastbuild_group_social', 'asd_fastbuild_social', 'asd_fastbuild_social_instagram' );
				add_settings_field( 'asd_fastbuild_social_linkedin_fld', 'Linkedin URL', 'asd_fld_insert', 'asd_fastbuild_group_social', 'asd_fastbuild_social', 'asd_fastbuild_social_linkedin' );
				add_settings_field( 'asd_fastbuild_social_pinterest_fld', 'Pinterst URL', 'asd_fld_insert', 'asd_fastbuild_group_social', 'asd_fastbuild_social', 'asd_fastbuild_social_pinterest' );
				add_settings_field( 'asd_fastbuild_social_twitter_fld', 'Twitter URL', 'asd_fld_insert', 'asd_fastbuild_group_social', 'asd_fastbuild_social', 'asd_fastbuild_social_twitter' );
				add_settings_field( 'asd_fastbuild_social_yelp_fld', 'Yelp URL', 'asd_fld_insert', 'asd_fastbuild_group_social', 'asd_fastbuild_social', 'asd_fastbuild_social_yelp' );
				add_settings_field( 'asd_fastbuild_social_youtube_fld', 'YouTube URL', 'asd_fld_insert', 'asd_fastbuild_group_social', 'asd_fastbuild_social', 'asd_fastbuild_social_youtube' );
			}
		}

		if ( ! function_exists( 'asd_fastbuild_register_site_data_1_201812042' ) ) {
			/** ----------------------------------------------------------------------------
			 *   Function asd_fastbuild_admin_panel()
			 *   adds the "Site Data" submenu to the top-level admin panel
			 *   Hooks into the admin_menu action
			 *  --------------------------------------------------------------------------*/
			function asd_fastbuild_register_site_data_1_201812042() {
				add_submenu_page(
					'asd_settings',
					'Site Data',
					'Site Data',
					'manage_options',
					'asd_fastbuild',
					'asd_fastbuild_options_1_201812042'
				);
			}
			if ( is_admin() ) {
				add_action( 'admin_menu', 'asd_fastbuild_register_site_data_1_201812042', 12 );
			}
		}

		if ( ! function_exists( 'asd_fastbuild_options_1_201812042' ) ) {
			/** ----------------------------------------------------------------------------
			 *   Function asd_fastbuild_options()
			 *   builds the Site Data Settings page, uses jquery-ui tabs
			 *  --------------------------------------------------------------------------*/
			function asd_fastbuild_options_1_201812042() {
				if ( ! current_user_can( 'manage_options' ) ) {
					wp_die( 'Insufficient Permissions' );
				}
				?>
				<div class="wrap">
					<h1>Site Data Settings</h1>

					The information in these fields is used in the ASD Fastbuild Widgets, and is also inserted into the page source as JSON-LD Structured Markup.<br>
					Check the <a target="_blank" href="https://search.google.com/structured-data/testing-tool">Google Structured Data Tool</a> to verify this data is correctly interpreted for Search Engine Semantic Search, Rich Snippets, etc. 

					<script type="text/javascript">
					jQuery(function() {
						jQuery("#asd_fastbuild_fields").tabs();
					});
					</script>

					<div id="asd_fastbuild_fields">
						<ul>
							<li><a href="#asd_fastbuild_fields_org">Organization</a></li>
							<li><a href="#asd_fastbuild_fields_hours">Hours</a></li>
							<li><a href="#asd_fastbuild_fields_social">Social Media</a></li>
						</ul>

						<div id="asd_fastbuild_fields_org">
							<form method="post" action="options.php">
								<?php settings_fields( 'asd_fastbuild_group_org' ); ?>
								<?php do_settings_sections( 'asd_fastbuild_group_org' ); ?>
								<?php submit_button( 'Save Organization Data' ); ?>
							</form>
						</div>
						<div id="asd_fastbuild_fields_hours">
							<form method="post" action="options.php">
									<?php settings_fields( 'asd_fastbuild_group_hours' ); ?>
									<?php do_settings_sections( 'asd_fastbuild_group_hours' ); ?>
									<?php submit_button( 'Save Hours' ); ?>
							</form>
						</div>
						<div id="asd_fastbuild_fields_social">
							<form method="post" action="options.php">
								<?php settings_fields( 'asd_fastbuild_group_social' ); ?>
								<?php do_settings_sections( 'asd_fastbuild_group_social' ); ?>
								<?php submit_button( 'Save Social Media Links' ); ?>
							</form>
						</div>
				</div>
			</div>

				<?php
			}
		}

		if ( ! function_exists( 'asd_organization_json_1_201812042' ) ) {
			/** ----------------------------------------------------------------------------
			 *   Function asd_organization_json()
			 *   Prints Structured data into page footer in JSON-LD format
			 *   Hooks into wp_print_footer_scripts action
			 *  --------------------------------------------------------------------------*/
			function asd_organization_json_1_201812042() {
				if ( is_front_page() ) {

					echo '<script type="application/ld+json">';

					$asd_json_data             = array();
					$asd_json_data['@context'] = 'http://schema.org';

					if ( get_option( 'asd_fastbuild_org_type' )['text_string'] ) {
						$asd_json_data['@type'] = esc_attr( get_option( 'asd_fastbuild_org_type' )['text_string'] );
					} else {
						$asd_json_data['@type'] = 'Organization';
					}
					if ( get_option( 'asd_fastbuild_org' )['text_string'] ) {
						$asd_json_data ['name'] = esc_attr( get_option( 'asd_fastbuild_org' )['text_string'] );
					} else {
						$asd_json_data ['name'] = esc_attr( get_bloginfo( 'name' ) );
					}
					if ( get_option( 'asd_fastbuild_org_legal' )['text_string'] ) {
						$asd_json_data ['legalName'] = esc_attr( get_option( 'asd_fastbuild_org_legal' )['text_string'] );
					}

					if ( get_site_url() ) {
						$asd_json_data['url'] = esc_url( get_site_url() );
					}

					if ( get_option( 'asd_fastbuild_org_logo' )['text_string'] ) {
						$asd_json_data['logo'] = esc_url( get_option( 'asd_fastbuild_org_logo' )['text_string'] );
					} else {
						if ( get_theme_mod( 'custom_logo' ) ) {
							$image                 = wp_get_attachment_image_src( get_theme_mod( 'custom_logo' ), 'full' );
							$asd_json_data['logo'] = esc_url( $image[0] );
						}
					}

					if ( get_option( 'asd_fastbuild_org_image' )['text_string'] ) {
						$asd_json_data['image'] = esc_url( get_option( 'asd_fastbuild_org_image' )['text_string'] );
					}

					if ( get_option( 'asd_fastbuild_org_desc' )['text_string'] ) {
						$asd_json_data['description'] = esc_attr( get_option( 'asd_fastbuild_org_desc' )['text_string'] );
					} else {
						if ( get_bloginfo( 'description' ) ) {
							$asd_json_data['description'] = esc_attr( get_bloginfo( 'description' ) );
						}
					}

					if ( get_option( 'asd_fastbuild_org_pricerange' )['text_string'] ) {
						$asd_json_data['priceRange'] = esc_attr( get_option( 'asd_fastbuild_org_pricerange' )['text_string'] );
					}

					if ( get_option( 'asd_fastbuild_phone1' )['text_string'] ) {
						$asd_json_data['telephone'] = esc_attr( get_option( 'asd_fastbuild_phone1' )['text_string'] );
					}
					if ( get_option( 'asd_fastbuild_email_info' )['text_string'] ) {
						$asd_json_data['email'] = esc_attr( get_option( 'asd_fastbuild_email_info' )['text_string'] );
					}

					$address          = array();
					$address['@type'] = 'PostalAddress';
					if ( get_option( 'asd_fastbuild_addr_street1' )['text_string'] ) {
						$address['streetAddress'] = esc_attr( get_option( 'asd_fastbuild_addr_street1' )['text_string'] );
					}
					if ( get_option( 'asd_fastbuild_addr_city' )['text_string'] ) {
						$address['addressLocality'] = esc_attr( get_option( 'asd_fastbuild_addr_city' )['text_string'] );
					}
					if ( get_option( 'asd_fastbuild_addr_state' )['text_string'] ) {
						$address['addressRegion'] = esc_attr( get_option( 'asd_fastbuild_addr_state' )['text_string'] );
					}
					if ( get_option( 'asd_fastbuild_addr_zip' )['text_string'] ) {
						$address['postalCode'] = esc_attr( get_option( 'asd_fastbuild_addr_zip' )['text_string'] );
					}
					if ( get_option( 'asd_fastbuild_addr_country' )['text_string'] ) {
						$address['addressCountry'] = esc_attr( get_option( 'asd_fastbuild_addr_country' )['text_string'] );
					}
					$asd_json_data['address'] = $address;

					$hours = '';
					if ( ! ( '' === get_option( 'asd_fastbuild_hours_mon_start1' )['text_string'] ) ||
					( 'Closed' === get_option( 'asd_fastbuild_hours_mon_start1' )['text_string'] ) ) {
						$hours = $hours . ' Mo ' . esc_attr( get_option( 'asd_fastbuild_hours_mon_start1' )['text_string'] ) . '-' .
							esc_attr( get_option( 'asd_fastbuild_hours_mon_end1' )['text_string'] );
					}
					if ( ! ( '' === get_option( 'asd_fastbuild_hours_tue_start1' )['text_string'] ) ||
					( 'Closed' === get_option( 'asd_fastbuild_hours_tue_start1' )['text_string'] ) ) {
						$hours = $hours . ' Tu ' . esc_attr( get_option( 'asd_fastbuild_hours_tue_start1' )['text_string'] ) . '-' .
							esc_attr( get_option( 'asd_fastbuild_hours_tue_end1' )['text_string'] );
					}
					if ( ! ( '' === get_option( 'asd_fastbuild_hours_wed_start1' )['text_string'] ) ||
					( 'Closed' === get_option( 'asd_fastbuild_hours_wed_start1' )['text_string'] ) ) {
						$hours = $hours . ' We ' . esc_attr( get_option( 'asd_fastbuild_hours_wed_start1' )['text_string'] ) . '-' .
							esc_attr( get_option( 'asd_fastbuild_hours_wed_end1' )['text_string'] );
					}
					if ( ! ( '' === get_option( 'asd_fastbuild_hours_thu_start1' )['text_string'] ) ||
					( 'Closed' === get_option( 'asd_fastbuild_hours_thu_start1' )['text_string'] ) ) {
						$hours = $hours . ' Th ' . esc_attr( get_option( 'asd_fastbuild_hours_thu_start1' )['text_string'] ) . '-' .
							esc_attr( get_option( 'asd_fastbuild_hours_thu_end1' )['text_string'] );
					}
					if ( ! ( '' === get_option( 'asd_fastbuild_hours_fri_start1' )['text_string'] ) ||
					( 'Closed' === get_option( 'asd_fastbuild_hours_fri_start1' )['text_string'] ) ) {
						$hours = $hours . ' Fr ' . esc_attr( get_option( 'asd_fastbuild_hours_fri_start1' )['text_string'] ) . '-' .
							esc_attr( get_option( 'asd_fastbuild_hours_fri_end1' )['text_string'] );
					}
					if ( ! ( '' === get_option( 'asd_fastbuild_hours_sat_start1' )['text_string'] ) ||
					( 'Closed' === get_option( 'asd_fastbuild_hours_sat_start1' )['text_string'] ) ) {
						$hours = $hours . ' Sa ' . esc_attr( get_option( 'asd_fastbuild_hours_sat_start1' )['text_string'] ) . '-' .
							esc_attr( get_option( 'asd_fastbuild_hours_sat_end1' )['text_string'] );
					}
					if ( ! ( '' === get_option( 'asd_fastbuild_hours_sun_start1' )['text_string'] ) ||
					( 'Closed' === get_option( 'asd_fastbuild_hours_sun_start1' )['text_string'] ) ) {
						$hours = $hours . ' Su ' . esc_attr( get_option( 'asd_fastbuild_hours_sun_start1' )['text_string'] ) . '-' .
							esc_attr( get_option( 'asd_fastbuild_hours_sun_end1' )['text_string'] );
					}

					if ( '' !== $hours ) {
						$asd_json_data['openingHours'] = $hours;
					}

					echo wp_json_encode( $asd_json_data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES );
					echo '</script>';
				}
			}
			add_action( 'wp_print_footer_scripts', 'asd_organization_json_1_201812042' );
		}

	}
}


if ( ! isset( $asd_register_site_data_version ) ) {
	$asd_register_site_data_version = $this_asd_register_site_data_version;
	setup_asd_register_site_data_functions_1_201812042();
} else {
	if ( $this_asd_register_site_data_version > $asd_register_site_data_version ) {
		unhook_asd_register_site_data_functions_1_201812042();
		setup_asd_register_site_data_functions_1_201812042();
		$asd_register_site_data_version = $this_asd_register_site_data_version;
	}
}

