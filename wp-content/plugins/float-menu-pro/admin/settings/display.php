<?php
/**
 * Display
 *
 * @package     Wow_Pluign
 * @copyright   Copyright (c) 2018, Dmytro Lobov
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       1.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
include_once( 'options/display.php' );

?>
<fieldset class="itembox">
    <legend>
		<?php esc_attr_e( 'Show on devices', $this->plugin['text'] ); ?>
    </legend>
    <div class="columns is-multiline">

        <div class="column is-4">
            <label class="checkbox label checkLabel">
				<?php self::option( $include_more_screen ); ?><?php esc_attr_e( "Don't show on screens more", $this->plugin['text'] ); ?><?php self::tooltip( $show_screen_help ); ?>
            </label>
            <div class="field has-addons">
				<?php self::option( $screen_more ); ?>
                <div class="control">
                    <span class="addon">px</span>
                </div>
            </div>
        </div>

        <div class="column is-4">
            <label class="checkbox label checkLabel">
				<?php self::option( $include_mobile ); ?><?php esc_attr_e( "Don't show on screens less", $this->plugin['text'] ); ?><?php self::tooltip( $include_mobile_help ); ?>
            </label>
            <div class="field has-addons">
				<?php self::option( $screen ); ?>
                <div class="control">
                    <span class="addon">px</span>
                </div>
            </div>
        </div>

    </div>
</fieldset>

<fieldset class="itembox">
    <legend>
		<?php esc_attr_e( 'Show for users', $this->plugin['text'] ); ?>
    </legend>
    <div class="columns is-multiline">
        <div class="column is-4">
			<?php self::option( $item_user ); ?>
        </div>
        <div class="column is-4 is-visibile-hidden item-user">
			<?php self::option( $user_role ); ?>
        </div>
    </div>
</fieldset>

<fieldset class="itembox">
    <legend>
		<?php esc_attr_e( 'Depending on the language', $this->plugin['text'] ); ?>
    </legend>
    <div class="columns is-multiline">
        <div class="column is-4">
            <label class="checkbox label checkLabel">
				<?php self::option( $depending_language ); ?><?php esc_attr_e( "Enable", $this->plugin['text'] ); ?>
            </label>
            <div class="field">
				<?php self::option( $language ); ?>
            </div>
        </div>
    </div>
</fieldset>

<fieldset class="itembox">
    <legend>
		<?php esc_attr_e( 'Font Awesome 5 style', $this->plugin['text'] ); ?>
    </legend>
    <div class="columns is-multiline">
        <div class="column is-4">
            <label class="checkbox label">
				<?php self::option( $disable_fontawesome ); ?><?php esc_attr_e( "Disable", $this->plugin['text'] ); ?><?php self::tooltip( $disable_fontawesome_help ); ?>
            </label>
        </div>
    </div>
</fieldset>

<fieldset class="itembox">
    <legend>
		<?php esc_attr_e( 'Mobile Rules', $this->plugin['text'] ); ?>
    </legend>
    <div class="columns is-multiline">
        <div class="column is-4">
            <label class="checkbox label checkBlock">
				<?php self::option( $mobile_rules ); ?><?php esc_attr_e( "Enable", $this->plugin['text'] ); ?><?php self::tooltip( $mobile_rules_help ); ?>
            </label>

        </div>
        <div class="column is-4 blockHidden">
            <label class="label">
				<?php esc_attr_e( 'Mobile screen ', $this->plugin['text'] ); ?><?php self::tooltip( $mobile_screen_help ); ?>
            </label>
            <div class="field has-addons">
				<?php self::option( $mobile_screen ); ?>
                <div class="control">
                    <span class="addon">px</span>
                </div>
            </div>
        </div>
    </div>
</fieldset>

<fieldset class="itembox">
    <legend>
		<?php esc_attr_e( 'Schedule', $this->plugin['text'] ); ?>
    </legend>
    <div class="columns is-multiline">
        <div class="column is-4">
            <div class="field">
                <label class="label">
					<?php esc_attr_e( 'Day of the week', $this->plugin['text'] ); ?><?php self::tooltip( $weekday_help ); ?>
                </label>
	            <?php self::option( $weekday ); ?>
            </div>
        </div>
        <div class="column is-4">
            <div class="field">
                <label class="label">
				    <?php esc_attr_e( 'Time from', $this->plugin['text'] ); ?><?php self::tooltip( $time_start_help ); ?>
                </label>
			    <?php self::option( $time_start ); ?>
            </div>
        </div>
        <div class="column is-4">
            <div class="field">
                <label class="label">
				    <?php esc_attr_e( 'Time to', $this->plugin['text'] ); ?><?php self::tooltip( $time_end_help ); ?>
                </label>
			    <?php self::option( $time_end ); ?>
            </div>
        </div>


        <div class="column is-4">
            <label class="checkbox label checkBlock">
				<?php self::option( $set_dates ); ?><?php esc_attr_e( "Set Dates", $this->plugin['text'] ); ?><?php self::tooltip( $set_dates_help ); ?>
            </label>

        </div>

        <div class="column is-4 blockHidden is-hidden">
            <div class="field">
                <label class="label">
				    <?php esc_attr_e( 'Date Start', $this->plugin['text'] ); ?><?php self::tooltip( $date_start_help ); ?>
                </label>
			    <?php self::option( $date_start ); ?>
            </div>
        </div>

        <div class="column is-4 blockHidden is-hidden">
            <div class="field">
                <label class="label">
				    <?php esc_attr_e( 'Date End', $this->plugin['text'] ); ?><?php self::tooltip( $date_start_help ); ?>
                </label>
			    <?php self::option( $date_end ); ?>
            </div>
        </div>
    </div>
</fieldset>

<fieldset class="itembox">
    <legend>
		<?php esc_attr_e( 'User Browser', $this->plugin['text'] ); ?>
    </legend>

    <div class="columns is-multiline">
        <div class="column is-12">
            <label class="checkbox label checkBlock">
		        <?php self::option( $all_browser ); ?><?php esc_attr_e( "Enable browser dependency", $this->plugin['text'] ); ?>
            </label>
        </div>
        <div class="column is-12 blockHidden">
            <label class="checkbox label">
		        <?php self::option( $br_opera ); ?><?php esc_attr_e( "Don't show in Opera", $this->plugin['text'] ); ?>
            </label>
            <label class="checkbox label">
		        <?php self::option( $br_edge ); ?><?php esc_attr_e( "Don't show in Microsoft Edge", $this->plugin['text'] ); ?>
            </label>
            <label class="checkbox label">
		        <?php self::option( $br_chrome ); ?><?php esc_attr_e( "Don't show in Chrome", $this->plugin['text'] ); ?>
            </label>
            <label class="checkbox label">
		        <?php self::option( $br_safari ); ?><?php esc_attr_e( "Don't show in Safari", $this->plugin['text'] ); ?>
            </label>
            <label class="checkbox label">
		        <?php self::option( $br_firefox ); ?><?php esc_attr_e( "Don't show in Firefox", $this->plugin['text'] ); ?>
            </label>
            <label class="checkbox label">
		        <?php self::option( $br_ie ); ?><?php esc_attr_e( "Don't show in Internet Explorer", $this->plugin['text'] ); ?>
            </label>
            <label class="checkbox label">
		        <?php self::option( $br_other ); ?><?php esc_attr_e( "Don't show in Other", $this->plugin['text'] ); ?>
            </label>

        </div>

    </div>

</fieldset>