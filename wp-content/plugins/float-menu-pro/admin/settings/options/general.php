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

$menu_status = array(
	'id'   => 'menu_status',
	'name' => 'param[menu_status]',
	'type' => 'checkbox',
	'val'  => isset( $param['menu_status'] ) ? $param['menu_status'] : 1,
);

$menu_status_help = array(
	'text' => esc_attr__( 'If check - the menu will show on the frontend. If uncheck - menu not displayed on the frontend.', $this->plugin['text'] ),
);

$test_mode = array(
	'id'   => 'test_mode',
	'name' => 'param[test_mode]',
	'type' => 'checkbox',
	'val'  => isset( $param['test_mode'] ) ? $param['test_mode'] : 0,
);

$test_mode_help = array(
	'text' => esc_attr__( 'If test mode is enabled, the menu will show for admin only.', $this->plugin['text'] ),
);

$tax_args   = array(
	'public'   => true,
	'_builtin' => false
);
$output     = 'names';
$operator   = 'and';
$taxonomies = get_taxonomies( $tax_args, $output, $operator );

$show_option = array(
	'all'        => esc_attr__( 'All posts and pages', $this->plugin['text'] ),
	'onlypost'   => esc_attr__( 'All posts', $this->plugin['text'] ),
	'onlypage'   => esc_attr__( 'All pages', $this->plugin['text'] ),
	'posts'      => esc_attr__( 'Posts with certain IDs', $this->plugin['text'] ),
	'pages'      => esc_attr__( 'Pages with certain IDs', $this->plugin['text'] ),
	'postsincat' => esc_attr__( 'Posts in Categorys with IDs', $this->plugin['text'] ),
	'expost'     => esc_attr__( 'All posts, except...', $this->plugin['text'] ),
	'expage'     => esc_attr__( 'All pages, except...', $this->plugin['text'] ),
	'homepage'   => esc_attr__( 'Only on homepage', $this->plugin['text'] ),
	'shortecode' => esc_attr__( 'Where shortcode is inserted', $this->plugin['text'] ),
);
if ( $taxonomies ) {
	$show_option['taxonomy'] = esc_attr__( 'Taxonomy', $this->plugin['text'] );
}

$show = array(
	'id'     => 'show',
	'name'   => 'param[show]',
	'type'   => 'select',
	'val'    => isset( $param['show'] ) ? $param['show'] : 'all',
	'option' => $show_option,
	'func'   => 'showchange(this);',
	'sep'    => 'p',
);

$show_help = array(
	'text' => esc_attr__( 'Choose a condition to target to specific content.', $this->plugin['text'] ),
);

// Taxonomy
$taxonomy_option = array();
if ( $taxonomies ) {
	foreach ( $taxonomies as $taxonomy ) {
		$taxonomy_option[ $taxonomy ] = $taxonomy;
	}
}

$taxonomy = array(
	'name'   => 'param[taxonomy]',
	'type'   => 'select',
	'val'    => isset( $param['taxonomy'] ) ? $param['taxonomy'] : '',
	'option' => $taxonomy_option,
	'sep'    => 'p',
);

// Content ID'sa
$id_post = array(
	'name'   => 'param[id_post]',
	'type'   => 'text',
	'val'    => isset( $param['id_post'] ) ? $param['id_post'] : '',
	'option' => array(
		'placeholder' => esc_attr__( 'Enter IDs, separated by comma.', $this->plugin['text'] ),
	),
	'sep'    => 'p',
);