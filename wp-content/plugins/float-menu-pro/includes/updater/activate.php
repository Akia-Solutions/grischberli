<?php
/**
 * Activate license
 *
 * @package     Wow_Plugin
 * @subpackage  Update/Activate
 * @author      Wow-Company <helper@wow-company.com>
 * @copyright   2019 Wow-Company
 * @license     GNU Public License
 * @version     1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( isset( $_POST[ 'wow_license_activate_' . $this->plugin['prefix'] ] ) ) {
	if ( ! check_admin_referer( 'wow_nonce_' . $this->plugin['prefix'], 'wow_nonce_' . $this->plugin['prefix'] ) ) {
		return;
	}
	$license    = trim( get_option( 'wow_license_key_' . $this->plugin['prefix'] ) );
	$api_params = array(
		'edd_action' => 'activate_license',
		'license'    => $license,
		'item_name'  => urlencode( $this->plugin['name'] ),
		'url'        => home_url(),
	);
	$response   =
		wp_remote_post( $this->url['author'], array( 'timeout' => 15, 'sslverify' => false, 'body' => $api_params ) );
	if ( is_wp_error( $response ) || 200 !== wp_remote_retrieve_response_code( $response ) ) {
		if ( is_wp_error( $response ) ) {
			$message = $response->get_error_message();
		} else {
			$message = __( 'An error occurred, please try again.' );
		}
	} else {
		$license_data = json_decode( wp_remote_retrieve_body( $response ) );
		if ( false === $license_data->success ) {
			switch ( $license_data->error ) {
				case 'expired' :
					$message = sprintf( __( 'Your license key expired on %s.' ), date_i18n( get_option( 'date_format' ),
						strtotime( $license_data->expires, current_time( 'timestamp' ) ) ) );
					break;
				case 'disabled' :
				case 'revoked' :
					$message = __( 'Your license key has been disabled.' );
					break;
				case 'missing' :
					$message = __( 'Invalid license.' );
					break;
				case 'invalid' :
				case 'site_inactive' :
					$message = __( 'Your license is not active for this URL.' );
					break;
				case 'item_name_mismatch' :
					$message =
						sprintf( __( 'This appears to be an invalid license key for %s.' ), $this->plugin['name'] );
					break;
				case 'no_activations_left':
					$message = __( 'Your license key has reached its activation limit.' );
					break;
				default :
					$message = __( 'An error occurred, please try again.' );
					break;
			}
		}
	}
	// Check if anything passed on a message constituting a failure
	if ( ! empty( $message ) ) {
		$base_url = admin_url( 'admin.php?page=' . $this->plugin['slug'] . '&tab=license' );
		$redirect = add_query_arg( array( 'sl_activation' => 'false', 'message' => urlencode( $message ) ), $base_url );
		wp_redirect( $redirect );
		exit();
	}
	// $license_data->license will be either "valid" or "invalid"
	update_option( 'wow_license_status_' . $this->plugin['prefix'], $license_data->license );
	update_option( 'wow_license_expire_' . $this->plugin['prefix'], $license_data->expires );
	wp_redirect( admin_url( 'admin.php?page=' . $this->plugin['slug'] ) );
	exit();
}