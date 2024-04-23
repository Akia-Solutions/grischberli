<?php
/**
 * Inline Style generator
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


$isize   = ! empty( $param['iconSize'] ) ? $param['iconSize'] : 24;
$lsize   = ! empty( $param['labelSize'] ) ? $param['labelSize'] : 15;
$iwidth  = $isize * 2;
$iwidth1 = $iwidth - 1;
$iwidth2 = $iwidth + 2;
$iwidth3 = $iwidth + 8;
// $lsize = $isize-9;
$misize   = ! empty( $param['mobiliconSize'] ) ? $param['mobiliconSize'] : 24;
$mlsize   = ! empty( $param['mobillabelSize'] ) ? $param['mobillabelSize'] : 15;
$miwidth  = $misize * 2;
$miwidth1 = $miwidth - 1;
$miwidth2 = $miwidth + 2;
$miwidth3 = $miwidth + 8;
$mlsize   = $misize - 9;

$idd = $id;

$zindex = ! empty( $param['zindex'] ) ? $param['zindex'] : 9999;

$css = '.float-menu-' . $id . ' .fm-bar {
z-index: ' . $zindex . ';
}';

$css .= '.float-menu-' . $id . ' {
z-index: ' . $zindex . ';
}';

$count_i = ( ! empty( $param['menu_1']['item_type'] ) ) ? count( $param['menu_1']['item_type'] ) : '0';
if ( $count_i > 0 ) {
	for ( $i = 0; $i < $count_i; $i ++ ) {
		$css .= '.float-menu-' . $id . ' .fm-item-' . $idd . '-' . $i . ' .fm-icon, .fm-item-' . $idd . '-' . $i
		        . ' a:hover .fm-icon, .fm-item-' . $idd . '-' . $i . ' .fm-label{';
		$css .= 'color:' . $param['menu_1']['color'][ $i ] . ';';
		$css .= 'background-color:' . $param['menu_1']['bcolor'][ $i ] . ';';
		$css .= '}';
		$css .= '.fm-item-' . $idd . '-' . $i . ' .fm-icon i {';
		$css .= 'color:' . $param['menu_1']['color'][ $i ] . ';';
		$css .= '}';
	}
}
$css .= '
	.float-menu-' . $id . ' .fm-bar.fm-right li,
	.float-menu-' . $id . ' .fm-right .fm-mask,
	.float-menu-' . $id . ' .fm-hit,
	.float-menu-' . $id . ' .fm-icon {
		height: ' . $iwidth . 'px;
	}
	.float-menu-' . $id . ' .fm-input {
		height: ' . ( $iwidth - 8 ) . 'px;
	}
	.float-menu-' . $id . ' .fm-bar a,
	.float-menu-' . $id . ' .fm-icon,
	.float-menu-' . $id . ' .fm-round .fm-hit,
	.float-menu-' . $id . ' .fm-sub > ul
	{
		width: ' . $iwidth . 'px;
	}
	.float-menu-' . $id . ' .fm-icon,
	.float-menu-' . $id . ' .fm-label {
		line-height:' . $iwidth . 'px;
	}
	.float-menu-' . $id . ' .fm-icon {
		font-size: ' . $isize . 'px;
	}
	.float-menu-' . $id . ' .fm-label {
		font-size: ' . $lsize . 'px;
	}
	.float-menu-' . $id . ' .fm-icon .fa {
		line-height: ' . $iwidth . 'px !important; 
	}
	
	.float-menu-' . $id . ' .fm-round.fm-label-space .fm-hit
	{
		width: ' . $iwidth2 . 'px;
	}
	
	.float-menu-' . $id . ' .fm-round li,
	.float-menu-' . $id . ' .fm-round .fm-mask,
	.float-menu-' . $id . ' .fm-round .fm-icon,
	.float-menu-' . $id . ' .fm-round a,
	.float-menu-' . $id . ' .fm-round .fm-label {
		border-radius: ' . $isize . 'px;
	}
	.float-menu-' . $id . ' .fm-connected .fm-label {
		padding: 0 11px 0 ' . $iwidth3 . 'px;
	}
	.float-menu-' . $id . ' .fm-right.fm-connected .fm-label {
		padding: 0 ' . $iwidth3 . 'px 0 11px;
	}
	.float-menu-' . $id . ' .fm-connected.fm-round .fm-label {
		padding: 0 12px 0 ' . $iwidth1 . 'px;
	}
	.float-menu-' . $id . ' .fm-right.fm-connected.fm-round .fm-label {
		padding: 0 ' . $iwidth1 . 'px 0 12px;
	}
	';

if ( $param['menu'] === 'left' ) {
	$css .= '
	.float-menu-' . $id . ' .fm-label,
	.float-menu-' . $id . ' .fm-label-space .fm-hit,
	.float-menu-' . $id . ' .fm-sub.fm-side > ul
	{
		left: ' . $iwidth . 'px;
	}
	';
} elseif ( $param['menu'] === 'right' ) {
	$css .= '
	.float-menu-' . $id . ' .fm-right .fm-label,
	.float-menu-' . $id . ' .fm-right.fm-label-space .fm-hit,
	.float-menu-' . $id . ' .fm-right .fm-sub.fm-side > ul
	{
		right: ' . $iwidth . 'px;
	}
	';
}

if ( $param['subPosition'] === 'under' ) {
	$css .= '
	.float-menu-' . $id . ' .fm-sub > ul { 
		top: ' . $iwidth . 'px;
	}
	';
}

$mobilieScreen = ! empty( $param['mobilieScreen'] ) ? $param['mobilieScreen'] : 480;
$css           .= '@media only screen and (max-width: ' . $mobilieScreen . 'px){';
$css           .= '.float-menu-' . $id . ' .fm-bar.fm-right li,
		.float-menu-' . $id . ' .fm-right .fm-mask,
		.float-menu-' . $id . ' .fm-hit,
		.float-menu-' . $id . ' .fm-icon {
			height: ' . $miwidth . 'px;
		}
		.float-menu-' . $id . ' .fm-bar a,
		.float-menu-' . $id . ' .fm-icon,
		.float-menu-' . $id . ' .fm-round .fm-hit,
		.float-menu-' . $id . ' .fm-sub > ul
		{
			width: ' . $miwidth . 'px;
		}
		.float-menu-' . $id . ' .fm-icon,
		.float-menu-' . $id . ' .fm-label {
			line-height:' . $miwidth . 'px;
		}
		.float-menu-' . $id . ' .fm-icon {
			font-size: ' . $misize . 'px;
		}
		.float-menu-' . $id . ' .fm-label {
			font-size: ' . $mlsize . 'px;
		}
		.float-menu-' . $id . ' .fm-icon .fa {
			line-height: ' . $miwidth . 'px !important; 
		}

		.float-menu-' . $id . ' .fm-round.fm-label-space .fm-hit
		{
			width: ' . $miwidth2 . 'px;
		}
		
		.float-menu-' . $id . ' .fm-round li,
		.float-menu-' . $id . ' .fm-round .fm-mask,
		.float-menu-' . $id . ' .fm-round .fm-icon,
		.float-menu-' . $id . ' .fm-round a,
		.float-menu-' . $id . ' .fm-round .fm-label {
			border-radius: ' . $misize . 'px;
		}
		.float-menu-' . $id . ' .fm-connected .fm-label {
			padding: 0 11px 0 ' . $miwidth3 . 'px;
		}
		.float-menu-' . $id . ' .fm-right.fm-connected .fm-label {
			padding: 0 ' . $miwidth3 . 'px 0 11px;
		}
		.float-menu-' . $id . ' .fm-connected.fm-round .fm-label {
			padding: 0 12px 0 ' . $miwidth1 . 'px;
		}
		.float-menu-' . $id . ' .fm-right.fm-connected.fm-round .fm-label {
			padding: 0 ' . $miwidth1 . 'px 0 12px;
		}';

if ( $param['menu'] === 'left' ) {
	$css .= '
		.float-menu-' . $id . ' .fm-label,
		.float-menu-' . $id . ' .fm-label-space .fm-hit,
		.float-menu-' . $id . ' .fm-sub.fm-side > ul
		{
			left: ' . $miwidth . 'px;
		}
	';
} elseif ( $param['menu'] === 'right' ) {
	$css .= '
		.float-menu-' . $id . ' .fm-right .fm-label,
		.float-menu-' . $id . ' .fm-right.fm-label-space .fm-hit,
		.float-menu-' . $id . ' .fm-right .fm-sub.fm-side > ul
		{
			right: ' . $miwidth . 'px;
		}
	';
}

if ( $param['subPosition'] === 'under' ) {
	$css .= '
	.float-menu-' . $id . ' .fm-sub > ul {
			top: ' . $miwidth . 'px;
		}
	';
}


$css .= '}';

if ( ! empty( $param['include_mobile'] ) ) {
	$screen = ! empty( $param['screen'] ) ? $param['screen'] : 480;
	$css    .= '
		@media only screen and (max-width: ' . $screen . 'px){
			.float-menu-' . $idd . ' {
				display:none;
			}
		}';
}
if ( ! empty( $param['include_more_screen'] ) ) {
	$screen_more = ! empty( $param['screen_more'] ) ? $param['screen_more'] : 1200;
	$css         .= '
		@media only screen and (min-width: ' . $screen_more . 'px){
			.float-menu-' . $idd . ' {
				display:none;
			}
		}';
}
if ( $this->check_translation( $param ) ) {
	$css .= '.skiptranslate {
		display: none !important;
	}body {top: 0 !important}';
}
$css = trim( preg_replace( '~\s+~s', ' ', $css ) );