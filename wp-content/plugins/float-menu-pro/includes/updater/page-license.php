<?php
/**
 * License Page
 *
 * @package     Wow_Plugin
 * @subpackage  Update/Licese_Page
 * @author      Wow-Company <helper@wow-company.com>
 * @copyright   2019 Wow-Company
 * @license     GNU Public License
 * @version     1.0
 */
if ( ! defined( 'ABSPATH' ) ) exit; ?>


<div class="about-wrap full-width-layout">
    <div class="feature-section one-col">
        <div class="col">

            <form method="post" action="options.php">
				<?php
				$license = get_option( 'wow_license_key_' . $this->plugin['prefix'] );
				$status = get_option( 'wow_license_status_' . $this->plugin['prefix'] );

				settings_fields('wow_license_' . $this->plugin['prefix']); ?>
                <table class="form-table">
                    <tr>
                        <th scope="row"><?php esc_html_e('Enter Your License key', $this->plugin['text']); ?></th>
                        <td>

                            <input id="wow_license_key_<?php echo $this->plugin['prefix'];?>" name="wow_license_key_<?php echo $this->plugin['prefix'];?>" type="text" class="regular-text" value="<?php esc_attr_e( $license ); ?>" placeholder="Enter your license key" />

							<?php if( !empty( $license ) ) { ?>
								<?php if( $status !== false && $status == 'valid' ) { ?>

									<?php wp_nonce_field( 'wow_nonce_'.$this->plugin['prefix'], 'wow_nonce_'.$this->plugin['prefix'] ); ?>
                                    <input type="submit" class="button-secondary" name="wow_license_deactivate_<?php echo $this->plugin['prefix'];?>" value="<?php esc_html_e('Deactivate License', $this->plugin['text']); ?>"/>
                                    <p/>
                                    <b><?php esc_html_e('Plugin Status', $this->plugin['text']); ?></b>: <span style="color:green;"><?php esc_html_e('Active', $this->plugin['text']); ?></span>

								<?php } else {
									wp_nonce_field( 'wow_nonce_'.$this->plugin['prefix'], 'wow_nonce_'.$this->plugin['prefix'] ); ?>

                                    <input type="submit" class="button-secondary" name="wow_license_activate_<?php echo $this->plugin['prefix'];?>" value="<?php esc_html_e('Activate License', $this->plugin['text']); ?>"/>
                                    <p/>
                                    <b><?php esc_html_e('Plugin Status', $this->plugin['text']); ?></b>: <span style="color:red;"><?php esc_html_e('Inactive', $this->plugin['text']); ?></span>

                                    <div  style="font-size:10px;font-style:italic;color:green;">
										<?php esc_html_e('Click the button "Activate License" to activate the plugin', $this->plugin['text']); ?>

                                    </div>
								<?php } ?>
							<?php } ?>

							<?php submit_button(); ?>
                        </td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
</div>