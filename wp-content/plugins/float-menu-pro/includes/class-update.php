<?php
/**
 * Class for update plugin
 *
 * @package     Wow_Plugin
 * @subpackage  Includes/Database
 * @author      Wow-Company <helper@wow-company.com>
 * @copyright   2019 Wow-Company
 * @license     GNU Public License
 * @version     1.0
 */

namespace float_menu_pro;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Wow_Plugin_Update
 *
 * @package wp_plugin
 *
 * @property array plugin - base information about the plugin
 * @property array url    - home, pro and other URL for plugin
 * @property array rating - website and link for rating
 */
class Wow_Plugin_Update {


	/**
	 * Setup to update the plugin
	 *
	 * @param array $info filesystem directory path for the plugin
	 *
	 * @since 0.1
	 */
	public function __construct( $info ) {
		$this->plugin = $info['plugin'];
		$this->url    = $info['url'];
		$this->rating = $info['rating'];

		add_filter( $this->plugin['slug'] . '_tab_menu', array( $this, 'filter_tab_menu' ) );
		add_filter( $this->plugin['slug'] . '_menu_file', array( $this, 'filter_menu_file' ) );

		// update plugin
		add_action( 'admin_init', array( $this, 'plugin_updater' ), 0 );
		// check plugin
		add_action( 'admin_init', array( $this, 'register_option' ) );
		add_action( 'admin_init', array( $this, 'activate_license' ) );
		add_action( 'admin_init', array( $this, 'deactivate_license' ) );
		add_action( 'admin_notices', array( $this, 'admin_notices' ) );

		register_deactivation_hook( $this->plugin['file'], array( $this, 'deactivate_plugin' ) );
	}

	public function filter_tab_menu( $menu ) {
		if ( empty( $menu['license'] ) ) {
			$menu['license'] = __( 'License', $this->plugin['text'] );
		}

		return $menu;
	}

	public function filter_menu_file( $tab ) {
		$license = get_option( 'wow_license_key_' . $this->plugin['prefix'] );
		$status  = get_option( 'wow_license_status_' . $this->plugin['prefix'] );
		if ( $tab === 'page-list' || $tab === 'page-settings' ) {
			if ( empty( $license ) || $status !== 'valid' ) {
				$tab = $this->plugin['dir'] . 'includes/updater/page-license';
			}
		} elseif ( $tab === 'page-license' ) {
			$tab = $this->plugin['dir'] . 'includes/updater/page-license';
		}

		return $tab;
	}

	// Update plugin
	public function plugin_updater() {
		require_once 'updater/class-update.php';
		$license_key = trim( get_option( 'wow_license_key_' . $this->plugin['prefix'] ) );
		$updater     = __NAMESPACE__ . '\\WOW_PLUGIN_UPDATER';
		$edd_updater = new WOW_PLUGIN_UPDATER( $this->plugin['store_url'], $this->plugin['file'], array(
			'version'   => $this->plugin['version'],
			'license'   => $license_key,
			'item_name' => $this->plugin['name'],
			'item_id'   => $this->plugin['item_id'],
			'author'    => $this->plugin['author'],
			'url'       => home_url(),
			'beta'      => false,
		) );
	}

	// Check plugin
	public function register_option() {
		register_setting( 'wow_license_' . $this->plugin['prefix'], 'wow_license_key_' . $this->plugin['prefix'], array(
			$this,
			'sanitize_license',
		) );
	}

	public function sanitize_license( $new ) {
		$old = get_option( 'wow_license_key_' . $this->plugin['prefix'] );
		if ( $old && $old != $new ) {
			delete_option( 'wow_license_status_' . $this->plugin['prefix'] );
		}

		return $new;
	}

	public function activate_license() {
		require_once 'updater/activate.php';
	}

	public function deactivate_license() {
		require_once 'updater/deactivate.php';
	}

	public function admin_notices() {
		require_once 'updater/notices.php';
	}

	public function deactivate_plugin() {
		$license    = trim( get_option( 'wow_license_key_' . $this->plugin['prefix'] ) );
		$api_params = array(
			'edd_action' => 'deactivate_license',
			'license'    => $license,
			'item_name'  => urlencode( $this->plugin['name'] ),
			'url'        => home_url(),
		);
		$response   = wp_remote_post( $this->url['author'], array(
			'timeout'   => 15,
			'sslverify' => false,
			'body'      => $api_params,
		) );
		// decode the license data
		$license_data = json_decode( wp_remote_retrieve_body( $response ) );
		// $license_data->license will be either "deactivated" or "failed"
		if ( $license_data->license == 'deactivated' ) {
			delete_option( 'wow_license_status_' . $this->plugin['prefix'] );
		}
	}
}