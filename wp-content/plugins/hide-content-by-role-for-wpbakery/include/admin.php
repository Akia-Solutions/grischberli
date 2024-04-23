<?php

new HCBRWPB_Admin();

class HCBRWPB_Admin {

	function __construct() {

		add_action('plugins_loaded', [$this, 'init']);

		add_action( 'vc_after_mapping', [ $this, 'vc_before_init_actions' ], 999 );

		// for uncode theme we need to use the init hook at 1001
		add_action('init', [ $this, 'vc_before_init_actions' ], 1001);

	}

	function init(){

		// maybe include fix for Salient Theme
		if(defined( 'SALIENT_CORE_VERSION' )){
			require_once(HCBRWPB_DIR_PATH.'/integrations/salient.php');
		}

	}

	function vc_before_init_actions() {
		if ( ! function_exists( 'get_editable_roles' ) ) {
			require_once( ABSPATH . '/wp-admin/includes/user.php' );
		}

		if(!class_exists('WPBMap')){
			error_log('HCBRWPB_Admin // Class WPBMap does not exist -> WpBakery must be active!');
			return;
		}

		$values = HCBRWPB_Utils::get_roles();

		$elements = WPBMap::getAllShortCodes();

		$shortcodes_to_add_options = array_keys($elements);

		$shortcodes_to_add_options = apply_filters('hcbrwpb_shortcodes_to_add_options', $shortcodes_to_add_options);

		foreach ($shortcodes_to_add_options as $shortcode){
			vc_add_param( $shortcode, array(
				"type"       => "checkbox",
				"group"      => __( "Visible for roles", 'hide-content-by-role-for-wpbakery' ),
				"class"      => "hcbrwpb-checkboxes",
				"description" => __( "Leave all empty to show for any user role", 'hide-content-by-role-for-wpbakery' ),
				"heading"    => __( "Visible for roles", 'hide-content-by-role-for-wpbakery' ),
				"param_name" => "hcbrwpb_visible_for_roles",
				"value"      => $values
			) );
		}

	}

}