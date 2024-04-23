<?php
/**
 * Admin notices
 *
 * @package     Include
 * @subpackage  Update
 * @author      Wow-Company <helper@wow-company.com>
 * @copyright   2019 Wow-Company
 * @license     GNU Public License
 * @version     1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( isset( $_GET['sl_activation'] ) && ! empty( $_GET['message'] ) ) {
	switch ( $_GET['sl_activation'] ) {
		case 'false':
			$message = urldecode( $_GET['message'] );
			?>
					<div class="error">
						<p><?php echo $message; ?></p>
					</div>
			<?php
			break;
		case 'true':
		default:
			// Developers can put a custom success message here for when activation is successful if they way.
			break;
	}
}