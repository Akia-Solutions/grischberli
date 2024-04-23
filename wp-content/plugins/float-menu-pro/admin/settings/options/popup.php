<?php
/**
 * Popup Settings param
 *
 * @package     Wow_Plugin
 * @copyright   Copyright (c) 2018, Dmytro Lobov
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Popup Title
$popuptitle = array(
	'name' => 'param[popuptitle]',
	'id'   => 'popuptitle',
	'type' => 'text',
	'val'  => isset( $param['popuptitle'] ) ? $param['popuptitle'] : '',
);

// Popup Title help
$popuptitle_help = array(
	'text' => esc_attr__( 'Enter the title fo popup.', $this->plugin['text'] ),
);

// Popup Content
$popupcontent = array(
	'name' => 'param[popupcontent]',
	'id'   => 'popupcontent',
	'type' => 'editor',
	'val'  => isset( $param['popupcontent'] ) ? $param['popupcontent'] : '',
);

// Popup Content help
$popupcontent_help = array(
	'text' => esc_attr__( 'Enter Popup content.', $this->plugin['text'] ),
);