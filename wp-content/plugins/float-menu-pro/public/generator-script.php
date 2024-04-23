<?php
/**
 * Inline Script generator
 *
 * @package     Wow_Plugin
 * @author      Wow-Company <helper@wow-company.com>
 * @copyright   2019 Wow-Company
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$align                    = ! empty( $param['align'] ) ? $param['align'] : 'center';
$side_offset              = ! empty( $param['side_offset'] ) ? $param['side_offset'] : '0';
$top_offset               = ! empty( $param['top_offset'] ) ? $param['top_offset'] : '0';
$shape                    = ! empty( $param['shape'] ) ? $param['shape'] : 'square';
$labelEffect              = ! empty( $param['labelEffect'] ) ? $param['labelEffect'] : 'fade';
$subPosition              = ! empty( $param['subPosition'] ) ? $param['subPosition'] : 'under';
$subSpace                 = ! empty( $param['subSpace'] ) ? $param['subSpace'] : 'true';
$subEffect                = ! empty( $param['subEffect'] ) ? $param['subEffect'] : 'none';
$subOpen                  = ! empty( $param['subOpen'] ) ? $param['subOpen'] : 'mouseover';
$subSpeed                 = ! empty( $param['subSpeed'] ) ? $param['subSpeed'] : '400';
$windowhorizontalPosition = ! empty( $param['windowhorizontalPosition'] ) ? $param['windowhorizontalPosition']
	: 'center';
$windowverticalPosition   = ! empty( $param['windowverticalPosition'] ) ? $param['windowverticalPosition'] : 'center';
$windowCorners            = ! empty( $param['windowCorners'] ) ? $param['windowCorners'] : 'match';
$windowColor              = ! empty( $param['windowColor'] ) ? $param['windowColor'] : 'default';
$showAfterPosition        = ! empty( $param['showAfterPosition'] ) ? $param['showAfterPosition'] : 0;
$hideAfterPosition        = ! empty( $param['hideAfterPosition'] ) ? $param['hideAfterPosition'] : 0;
$mobile_screen            = ! empty( $param['mobile_screen'] ) ? $param['mobile_screen'] : 768;
$mobile_rules             = ! empty( $param['mobile_rules'] ) ? 'true' : 'false';

$js .= 'jQuery(document).ready(function() {';
$js .= '
	jQuery(".float-menu-' . $id . '").floatingMenu({
		position: ["' . $param['menu'] . '", "' . $align . '"],
		offset: [' . $side_offset . ', ' . $top_offset . '],
		shape: "' . $shape . '",
		sideSpace: ' . $param['sideSpace'] . ',
		buttonSpace: ' . $param['buttonSpace'] . ',
		labelSpace: ' . $param['labelSpace'] . ',
		labelConnected: ' . $param['labelConnected'] . ',
		labelEffect: "' . $labelEffect . '",
		labelAnim: [' . $param['labelSpeed'] . ', "easeOutQuad"],
		color: "default",
		overColor: "default",
		labelsOn: ' . $param['labelsOn'] . ',
		subPosition: "' . $subPosition . '",
		subSpace: ' . $subSpace . ',
		subEffect: "' . $subEffect . '",
    subOpen: "' . $subOpen . '",
		subAnim: [' . $subSpeed . ', "easeOutQuad"],
		windowPosition: ["' . $windowhorizontalPosition . '", "' . $windowverticalPosition . '"],
		windowOffset: [0, 0],
		windowCorners: "' . $windowCorners . '",
		windowColor: "' . $windowColor . '",
		windowShadow: false,
		showAfterPosition: ' . $showAfterPosition . ',
		hideAfterPosition: ' . $hideAfterPosition . ',
		mobileEnable: ' . $mobile_rules . ',
		mobileScreen: ' . $mobile_screen . ',
	});
';
$js .= '});';

$js = trim( preg_replace( '~\s+~s', ' ', $js ) );