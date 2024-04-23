<?php
/**
 * Popup Settings
 *
 * @package     Wow_Plugin
 * @copyright   Copyright (c) 2018, Dmytro Lobov
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       1.0
 */

if ( !defined( 'ABSPATH' ) ) {
  exit;
}
include_once( 'options/popup.php' );

?>

<div class="columns is-multiline">
  <div class="column is-12">
      <div class="field">
          <label class="label">
            <?php esc_attr_e( 'Popup Title', $this->plugin['text'] ); ?>
            <?php self::tooltip( $popuptitle_help ); ?>
          </label>
            <?php self::option( $popuptitle ); ?>
      </div>
  </div>

  <div class="column is-12">
      <div class="field">
          <label class="label">
	          <?php esc_attr_e( 'Popup Content', $this->plugin['text'] ); ?>
              <?php self::tooltip( $popupcontent_help ); ?>
          </label>
		  <?php self::option($popupcontent); ?>
      </div>
  </div>
</div>