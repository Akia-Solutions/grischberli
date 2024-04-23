<?php
/**
 * Main Settings
 *
 * @package     Wow_Plugin
 * @copyright   Copyright (c) 2018, Dmytro Lobov
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
include_once( 'options/main.php' );

?>
<fieldset class="itembox">
    <legend>
		<?php esc_attr_e( 'Main', $this->plugin['text'] ); ?>
    </legend>

    <div class="columns">
        <div class="column">
            <div class="field">
                <label class="label">
					<?php esc_attr_e( 'Position', $this->plugin['text'] ); ?><?php self::tooltip( $menu_help ); ?>
                </label>
				<?php self::option( $menu ); ?>
            </div>

        </div>
        <div class="column">

            <label class="label">
				<?php esc_attr_e( 'Top offset', $this->plugin['text'] ); ?><?php self::tooltip( $top_offset_help ); ?>
            </label>
            <div class="field has-addons">
				<?php self::option( $top_offset ); ?>
                <div class="control">
                    <span class="addon">px</span>
                </div>
            </div>


        </div>
        <div class="column">

            <label class="label">
				<?php esc_attr_e( 'Side offset', $this->plugin['text'] ); ?><?php self::tooltip( $side_offset_help ); ?>
            </label>
            <div class="field has-addons">
				<?php self::option( $side_offset ); ?>
                <div class="control">
                    <span class="addon">px</span>
                </div>
            </div>


        </div>
    </div>

    <div class="columns">
        <div class="column">
            <div class="field">
                <label class="label">
					<?php esc_attr_e( 'Align', $this->plugin['text'] ); ?><?php self::tooltip( $align_help ); ?>
                </label>
				<?php self::option( $align ); ?>
            </div>
        </div>
        <div class="column">
            <div class="field">
                <label class="label">
					<?php esc_attr_e( 'Shape', $this->plugin['text'] ); ?><?php self::tooltip( $shape_help ); ?>
                </label>
				<?php self::option( $shape ); ?>
            </div>
        </div>
        <div class="column">
            <div class="field">
                <label class="label">
					<?php esc_attr_e( 'Side Space', $this->plugin['text'] ); ?><?php self::tooltip( $sideSpace_help ); ?>
                </label>
				<?php self::option( $sideSpace ); ?>
            </div>
        </div>
    </div>

    <div class="columns">
        <div class="column">
            <div class="field">
                <label class="label">
					<?php esc_attr_e( 'Button Space', $this->plugin['text'] ); ?><?php self::tooltip( $buttonSpace_help ); ?>
                </label>
				<?php self::option( $buttonSpace ); ?>
            </div>
        </div>
        <div class="column">
            <div class="field">
                <label class="label">
					<?php esc_attr_e( 'Label On', $this->plugin['text'] ); ?><?php self::tooltip( $labelsOn_help ); ?>
                </label>
				<?php self::option( $labelsOn ); ?>
            </div>
        </div>
        <div class="column">
            <div class="field">
                <label class="label">
					<?php esc_attr_e( 'Label Space', $this->plugin['text'] ); ?><?php self::tooltip( $labelSpace_help ); ?>
                </label>
				<?php self::option( $labelSpace ); ?>
            </div>
        </div>
    </div>

    <div class="columns">
        <div class="column">
            <div class="field">
                <label class="label">
					<?php esc_attr_e( 'Label Connected', $this->plugin['text'] ); ?><?php self::tooltip( $labelConnected_help ); ?>
                </label>
				<?php self::option( $labelConnected ); ?>
            </div>
        </div>
        <div class="column">
            <div class="field">
                <label class="label">
					<?php esc_attr_e( 'Label Effect', $this->plugin['text'] ); ?><?php self::tooltip( $labelEffect_help ); ?>
                </label>
				<?php self::option( $labelEffect ); ?>
            </div>
        </div>
        <div class="column">
            <label class="label">
				<?php esc_attr_e( 'Label Speed (ms)', $this->plugin['text'] ); ?><?php self::tooltip( $labelSpeed_help ); ?>
            </label>
            <div class="field has-addons">
				<?php self::option( $labelSpeed ); ?>
                <div class="control">
                    <span class="addon">ms</span>
                </div>
            </div>
        </div>
    </div>

    <div class="columns">
        <div class="column">
            <label class="label">
				<?php esc_attr_e( 'Icon size', $this->plugin['text'] ); ?><?php self::tooltip( $iconSize_help ); ?>
            </label>
            <div class="field has-addons">
				<?php self::option( $iconSize ); ?>
                <div class="control">
                    <span class="addon">px</span>
                </div>
            </div>
        </div>
        <div class="column">

            <label class="label">
				<?php esc_attr_e( 'Icon size for mobile', $this->plugin['text'] ); ?><?php self::tooltip( $mobiliconSize_help ); ?>
            </label>
            <div class="field has-addons">
				<?php self::option( $mobiliconSize ); ?>
                <div class="control">
                    <span class="addon">px</span>
                </div>
            </div>


        </div>
        <div class="column">
            <label class="label">
				<?php esc_attr_e( 'Mobile Screen', $this->plugin['text'] ); ?><?php self::tooltip( $mobilieScreen_help ); ?>
            </label>
            <div class="field has-addons">
				<?php self::option( $mobilieScreen ); ?>
                <div class="control">
                    <span class="addon">px</span>
                </div>
            </div>
        </div>
    </div>

    <div class="columns">
        <div class="column">
            <div class="field">
                <label class="label">
					<?php esc_attr_e( 'Label size', $this->plugin['text'] ); ?><?php self::tooltip( $labelSize_help ); ?>
                </label>
                <div class="field has-addons">
		            <?php self::option( $labelSize ); ?>
                    <div class="control">
                        <span class="addon">px</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="column">
            <label class="label">
				<?php esc_attr_e( 'Label size for mobile', $this->plugin['text'] ); ?><?php self::tooltip( $mobillabelSize_help ); ?>
            </label>
            <div class="field has-addons">
				<?php self::option( $mobillabelSize ); ?>
                <div class="control">
                    <span class="addon">px</span>
                </div>
            </div>
        </div>
        <div class="column">
            <div class="field">
                <label class="label">
					<?php esc_attr_e( 'Show After Position', $this->plugin['text'] ); ?><?php self::tooltip( $showAfterPosition_help ); ?>
                </label>
				<?php self::option( $showAfterPosition ); ?>
            </div>
        </div>
    </div>

    <div class="columns">
        <div class="column is-4">
            <div class="field">
                <label class="label">
					<?php esc_attr_e( 'Hide After Position', $this->plugin['text'] ); ?><?php self::tooltip( $hideAfterPosition_help ); ?>
                </label>
				<?php self::option( $hideAfterPosition ); ?>
            </div>
        </div>
        <div class="column is-4">
            <div class="field">
                <label class="label">
					<?php esc_attr_e( 'Z-index', $this->plugin['text'] ); ?>
                </label>
				<?php self::option( $z_index ); ?>
            </div>
        </div>
        <div class="column is-4"></div>
    </div>


</fieldset>


<fieldset class="itembox">
    <legend>
		<?php esc_attr_e( 'Sub Menu ', $this->plugin['text'] ); ?>
    </legend>

    <div class="columns is-multiline">
        <div class="column is-4">
            <div class="field">
                <label class="label">
					<?php esc_attr_e( 'Sub Position', $this->plugin['text'] ); ?><?php self::tooltip( $subPosition_help ); ?>
                </label>
				<?php self::option( $subPosition ); ?>
            </div>
        </div>
        <div class="column is-4">
            <div class="field">
                <label class="label">
					<?php esc_attr_e( 'Sub Space', $this->plugin['text'] ); ?><?php self::tooltip( $subSpace_help ); ?>
                </label>
				<?php self::option( $subSpace ); ?>
            </div>
        </div>
        <div class="column is-4">
            <div class="field">
                <label class="label">
					<?php esc_attr_e( 'Sub Effect', $this->plugin['text'] ); ?><?php self::tooltip( $subEffect_help ); ?>
                </label>
				<?php self::option( $subEffect ); ?>
            </div>
        </div>
        <div class="column is-4">
            <label class="label">
				<?php esc_attr_e( 'Sub Speed', $this->plugin['text'] ); ?><?php self::tooltip( $subSpeed_help ); ?>
            </label>
            <div class="field has-addons">
				<?php self::option( $subSpeed ); ?>
                <div class="control">
                    <span class="addon">ms</span>
                </div>
            </div>
        </div>
        <div class="column is-4">
            <div class="field">
                <label class="label">
					<?php esc_attr_e( 'Sub Open', $this->plugin['text'] ); ?><?php self::tooltip( $subOpen_help ); ?>
                </label>
				<?php self::option( $subOpen ); ?>
            </div>
        </div>

    </div>

</fieldset>

<fieldset class="itembox">
    <legend>
		<?php esc_attr_e( 'Popup', $this->plugin['text'] ); ?>
    </legend>

    <div class="columns is-multiline">
        <div class="column is-4">
            <div class="field">
                <label class="label">
					<?php esc_attr_e( 'Horizontal position', $this->plugin['text'] ); ?><?php self::tooltip( $windowhorizontalPosition_help ); ?>
                </label>
				<?php self::option( $windowhorizontalPosition ); ?>
            </div>
        </div>
        <div class="column is-4">
            <div class="field">
                <label class="label">
					<?php esc_attr_e( 'Vertical position', $this->plugin['text'] ); ?><?php self::tooltip( $windowverticalPosition_help ); ?>
                </label>
				<?php self::option( $windowverticalPosition ); ?>
            </div>
        </div>
        <div class="column is-4">
            <div class="field">
                <label class="label">
					<?php esc_attr_e( 'Corners', $this->plugin['text'] ); ?><?php self::tooltip( $windowCorners_help ); ?>
                </label>
				<?php self::option( $windowCorners ); ?>
            </div>
        </div>
        <div class="column is-4">
            <div class="field">
                <label class="label">
					<?php esc_attr_e( 'Color', $this->plugin['text'] ); ?><?php self::tooltip( $windowColor_help ); ?>
                </label>
				<?php self::option( $windowColor ); ?>
            </div>
        </div>
    </div>

</fieldset>