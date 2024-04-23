<?php
/**
 * Elements for clone
 *
 * @package     Wow_Plugin
 * @copyright   Copyright (c) 2018, Dmytro Lobov
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

include_once( 'options/clone.php' );
?>

<div class="panel">
    <div class="panel-heading">
        <div class="level-item icon-select" style="color: #ffffff; background-color: #128be0;">
            <i class="fas fa-hand-point-up"></i>
        </div>
        <div class="level-item">
            <span class="item-label-text">(<?php esc_attr_e( 'no label', $this->plugin['text'] ); ?>)</span>
            <span class="is-submenu is-hidden"><?php esc_attr_e( 'sub item', $this->plugin['text'] ); ?></span>
        </div>
        <div class="level-item element-type">
            Link
        </div>
        <div class="level-item toogle-element">
            <span class="dashicons dashicons-arrow-down is-hidden"></span>
            <span class="dashicons dashicons-arrow-up"></span>
        </div>
    </div>
    <div class="toogle-content">
        <div class="panel-block">
            <div class="field">
                <label class="label is-small">
					<?php esc_attr_e( 'Label Text', $this->plugin['text'] ); ?><?php self::tooltip( $menu_1_item_tooltip_help ); ?>
                </label>
				<?php self::option( $menu_1_item_tooltip ); ?>
            </div>
        </div>
        <label class="panel-block">
			<?php self::option( $menu_1_item_sub ); ?><?php esc_attr_e( 'sub item', $this->plugin['text'] ); ?><?php self::tooltip( $menu_1_item_sub_help ); ?>
        </label>
        <label class="panel-block">
			<?php self::option( $menu_1_hold_open ); ?><?php esc_attr_e( 'Hold open', $this->plugin['text'] ); ?>
        </label>
        <p class="panel-tabs">
            <a class="is-active" data-tab="1">Type</a>
            <a data-tab="2">Icon</a>
            <a data-tab="3">Style</a>
            <a data-tab="4">Attributes</a>
        </p>
        <div data-tab-content="1" class="tabs-content">
            <div class="panel-block">
                <div class="field">
                    <label class="label">
						<?php esc_attr_e( 'Item type', $this->plugin['text'] ); ?><?php self::tooltip( $menu_1_item_type_help ); ?>

                    </label>
					<?php self::option( $menu_1_item_type ); ?>
                </div>
                <div class="field item-link">
                    <label class="label item-link-text">
						<?php esc_attr_e( 'Link', $this->plugin['text'] ); ?>
                    </label>
					<?php self::option( $menu_1_item_link ); ?>
                </div>
                <div class="field item-share">
                    <label class="label">
						<?php esc_attr_e( 'Social Networks', $this->plugin['text'] ); ?>
                    </label>
					<?php self::option( $menu_1_item_share ); ?>
                </div>
                <div class="field item-translate">
                    <label class="label">
						<?php esc_attr_e( 'Select Language', $this->plugin['text'] ); ?>
                    </label>
					<?php self::option( $menu_1_item_gtranslate ); ?>
                </div>
                <div class="field item-modal">
                    <label class="label">
						<?php esc_attr_e( 'Enter value', $this->plugin['text'] ); ?>: <br/>
                    </label>
					<?php self::option( $menu_1_item_modal ); ?>
                    <p class="help"><?php esc_attr_e( '(e.g.: wow-modal-id-1)', $this->plugin['text'] ); ?></p>
                </div>
            </div>
            <label class="panel-block item-link-blank">
				<?php self::option( $menu_1_new_tab ); ?><?php esc_attr_e( 'Open link in a new tab', $this->plugin['text'] ); ?>
            </label>
        </div>
        <div data-tab-content="2" class="tabs-content is-hidden">
            <div class="panel-block icon-default">
                <div class="field">
                    <label class="label">
						<?php esc_attr_e( 'Icon', $this->plugin['text'] ); ?>
                    </label>
					<?php self::option( $menu_1_item_icon ); ?>
                </div>
            </div>
            <label class="panel-block">
				<?php self::option( $menu_1_item_custom ); ?><?php esc_attr_e( 'Custom icon', $this->plugin['text'] ); ?><?php self::tooltip( $menu_1_item_icon_help ); ?>
            </label>
            <div class="panel-block icon-custom">
				<?php self::option( $menu_1_item_custom_link ); ?>
            </div>
            <div class="panel-block icon-custom">
                <div class="field">
                    <label class="label">
						<?php esc_attr_e( 'Image Alt', $this->plugin['text'] ); ?><?php self::tooltip( $menu_1_image_alt_help ); ?>
                    </label>
					<?php self::option( $menu_1_image_alt ); ?>
                </div>
            </div>
            <label class="panel-block icon-text">
				<?php self::option( $menu_1_custom_text_check ); ?><?php esc_attr_e( 'Text', $this->plugin['text'] ); ?>
            </label>
            <div class="panel-block icon-text-field is-hidden">
				<?php self::option( $menu_1_custom_text ); ?>
            </div>

        </div>
        <div data-tab-content="3" class="tabs-content is-hidden">
            <div class="panel-block">
                <div class="field">
                    <label class="label">
						<?php esc_attr_e( 'Font Color', $this->plugin['text'] ); ?>
                    </label>
					<?php self::option( $menu_1_color ); ?>
                </div>
            </div>
            <div class="panel-block">
                <div class="field">
                    <label class="label">
						<?php esc_attr_e( 'Background', $this->plugin['text'] ); ?>
                    </label>
					<?php self::option( $menu_1_bcolor ); ?>
                </div>
            </div>
        </div>
        <div data-tab-content="4" class="tabs-content is-hidden">
            <div class="panel-block">
                <div class="field">
                    <label class="label">
						<?php esc_attr_e( 'ID for element', $this->plugin['text'] ); ?><?php self::tooltip( $menu_1_button_id_help ); ?>
                    </label>
					<?php self::option( $menu_1_button_id ); ?>
                </div>
            </div>
            <div class="panel-block">
                <div class="field">
                    <label class="label">
						<?php esc_attr_e( 'Class for element', $this->plugin['text'] ); ?><?php self::tooltip( $menu_1_button_class_help ); ?>
                    </label>
					<?php self::option( $menu_1_button_class ); ?>
                </div>
            </div>
            <div class="panel-block">
                <div class="field">
                    <label class="label">
				        <?php esc_attr_e( 'Attribute: rel', $this->plugin['text'] ); ?>
                    </label>
			        <?php self::option( $menu_1_link_rel ); ?>
                </div>
            </div>
        </div>
        <div class="panel-block actions">
            <a class="item-delete"><?php esc_attr_e( 'Remove', $this->plugin['text'] ); ?></a>
        </div>
    </div>
</div>

