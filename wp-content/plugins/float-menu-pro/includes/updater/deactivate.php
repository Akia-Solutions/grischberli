<?php
/**
 * Deactivate license
 *
 * @package     Wow_Plugin
 * @subpackage  Update/Deactivate
 * @author      Wow-Company <helper@wow-company.com>
 * @copyright   2019 Wow-Company
 * @license     GNU Public License
 * @version     1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( isset( $_POST[ 'wow_license_deactivate_' . $this->plugin['prefix'] ] ) ) {
	if ( ! check_admin_referer( 'wow_nonce_' . $this->plugin['prefix'], 'wow_nonce_' . $this->plugin['prefix'] ) ) {
		return;
	}
	$license    = trim( get_option( 'wow_license_key_' . $this->plugin['prefix'] ) );
	$api_params = array(
		'edd_action' => 'deactivate_license',
		'license'    => $license,
		'item_name'  => urlencode( $this->plugin['name'] ),
		'url'        => home_url(),
	);
	$response   =
		wp_remote_post( $this->url['author'], array( 'timeout' => 15, 'sslverify' => false, 'body' => $api_params ) );
	// make sure the response came back okay
	if ( is_wp_error( $response ) || 200 !== wp_remote_retrieve_response_code( $response ) ) {
		if ( is_wp_error( $response ) ) {
			$message = $response->get_error_message();
		} else {
			$message = __( 'An error occurred, please try again.' );
		}
		$base_url = admin_url( 'admin.php?page=' . $this->plugin['slug'] . '&tab=license' );
		$redirect = add_query_arg( array( 'sl_activation' => 'false', 'message' => urlencode( $message ) ), $base_url );
		wp_redirect( $redirect );
		exit();
	}
	// decode the license data
	$license_data = json_decode( wp_remote_retrieve_body( $response ) );
	// $license_data->license will be either "deactivated" or "failed"
	if ( $license_data->license == 'deactivated' ) {
		delete_option( 'wow_license_status_' . $this->plugin['prefix'] );
	}
	wp_redirect( admin_url( 'admin.php?page=' . $this->plugin['slug'] . '&tab=license' ) );
	exit();
}