<?php if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


include 'social_service.php';

// Popup for social share window
$popup_option
	= "width=550, height=450, top='+((screen.height-450)/2)+', left='+((screen.width-550)/2)+' scrollbars=0, resizable=1, menubar=0, toolbar=0, status=0";

if ( ! empty( $param['menu_1']['item_sub'] ) ) {
	$sub_menu_array = array_filter( $param['menu_1']['item_sub'], "self::sub_menu_array" );
} else {
	$sub_menu_array = array();
}

$count_sub = ( ! empty( $sub_menu_array ) ) ? count( $sub_menu_array ) : '-1';

if ( $count_sub > 0 ) {

	$sub_menu = '<ul>';

	$sub_items = $sub_menu_array;

	foreach ( $sub_items as $i => $value ) {
		if ( $i == 0 ) {
			continue;
		}

		$button_class = $param['menu_1']['button_class'][ $i ];
		$class_add    = ! empty( $button_class ) ? ' class="' . esc_attr( $button_class ) . '"' : '';
		$button_id    = $param['menu_1']['button_id'][ $i ];
		$id_add       = ! empty( $button_id ) ? ' id="' . esc_attr( $button_id ) . '"' : '';
		$link_rel     = ! empty( $param['menu_1']['link_rel'][ $i ] ) ? ' rel="' . esc_attr( $param['menu_1']['link_rel'][ $i ] ) . '"' : '';

		$link_param = $id_add . $class_add . $link_rel;

		$sub_menu .= '<li class="fm-item-' . absint( $id ) . '-' . absint( $i ) . '">';

		if ( ! empty( $param['menu_1']['item_custom'][ $i ] ) ) {
			$img_alt = ! empty( $param['menu_1']['image_alt'][ $i ] ) ? ' alt="' . esc_attr( $param['menu_1']['image_alt'][ $i ] ) . '"' : '';
			$icon    = '<div class="fm-icon"><img src="' . $param['menu_1']['item_custom_link'][ $i ] . '"' . $img_alt . '></div>';
		} elseif ( ! empty( $param['menu_1']['item_custom_text_check'][ $i ] ) ) {
			$icon = '<div class="fm-icon fm-icon-text"><span>' . $param['menu_1']['item_custom_text'][ $i ] . '</span></div>';
		} else {
			$icon = '<div class="fm-icon"><i class="' . $param['menu_1']['item_icon'][ $i ] . '"></i></div>';
		}

		$tooltip = $param['menu_1']['item_tooltip'][ $i ];
		$hold    = ! empty( $param['menu_1']['hold_open'][ $i ] ) ? ' fm-hold-open' : '';
		$name    = $icon . '<div class="fm-label' . esc_attr( $hold ) . '">' . esc_html( $tooltip ) . '</div>';

		$item_type = $param['menu_1']['item_type'][ $i ];
		$open      = ! empty( $param['menu_1']['hold_open'][ $i ] ) ? ' data-label="show"' : '';

		switch ( $item_type ) {
			case 'link':
				$target   = ! empty( $param['menu_1']['new_tab'][ $i ] ) ? '_blank' : '_self';
				$link     = $param['menu_1']['item_link'][ $i ];
				$sub_menu .= '<a href="' . esc_url( $link ) . '" target="' . esc_attr( $target ) . '" ' . $link_param . '' . $open . '>'
				             . $name . '</a>';
				break;
			case 'dynamic':
				$target   = ! empty( $param['menu_1']['new_tab'][ $i ] ) ? '_blank' : '_self';
				$link     = apply_filters( 'float_menu_dynamic_link', '#' );
				$sub_menu .= '<a href="' . esc_url( $link ) . '" target="' . esc_attr( $target ) . '" ' . $link_param . '' . $open . '>'
				             . $name . '</a>';
				break;
			case 'id':
				$element  = $param['menu_1']['item_modal'][ $i ];
				$sub_menu .= '<a href="#" id="' . esc_attr( $element ) . '"' . $open . '>' . $name . '</a>';
				break;
			case 'class':
				$element  = $param['menu_1']['item_modal'][ $i ];
				$sub_menu .= '<a href="#" class="' . esc_attr( $element ) . '"' . $open . '>' . $name . '</a>';
				break;
			case 'share':
				$share_service = mb_strtolower( $param['menu_1']['item_share'][ $i ] );
				$share_link    = $social_services[ $share_service ];
				if ( $share_service == 'email' ) {
					$sub_menu .= '<a href="#" onclick="window.open(\'' . $share_link . '\', \'_self\')" ' . $link_param . ''
					             . $open . '>' . $name . '</a>';
					break;
				}
				$popup_open = 'window.open(\'' . $share_link . '\', \'_blank\', \'' . $popup_option . '\');';
				$sub_menu   .= '<a href="#" onclick="' . $popup_open . '" ' . $link_param . '' . $open . '>' . $name
				               . '</a>';
				break;
			case 'translate':
				$link     = '#';
				$glang    = $param['menu_1']['gtranslate'][ $i ];
				$sub_menu .= '<a href="' . $link . '" ' . $link_param . '' . $open . ' data-google-lang="' . $glang . '">'
				             . $name . '</a>';
				break;
			case 'print':
				$sub_menu .= '<a href="#" onclick="pageprint();" ' . $link_param . '' . $open . '>' . $name . '</a>';
				break;
			case 'totop':
				$sub_menu .= '<a href="#" onclick="scrollToTop();" ' . $link_param . '' . $open . '>' . $name . '</a>';
				break;
			case 'tobottom':
				$sub_menu .= '<a role="button" onclick="scrollToBottom();" ' . $link_param . '' . $open . '>' . $name
				             . '</a>';
				break;
			case 'goback':
				$sub_menu .= '<a href="#" onclick="goBack();" ' . $link_param . '' . $open . '>' . $name . '</a>';
				break;
			case 'goforward':
				$sub_menu .= '<a href="#" onclick="goForward();" ' . $link_param . '' . $open . '>' . $name . '</a>';
				break;
			case 'exit':
				$link     = $param['menu_1']['item_link'][ $i ];
				$sub_menu .= '<a href="#" data-fmp-url="' . esc_url( $link ) . '" onclick="fmpGetAway();" ' . $link_param . '' . $open . '>' . $name . '</a>';
				break;
			case 'smoothscroll':
				$link     = $param['menu_1']['item_link'][ $i ];
				$sub_menu .= '<a href="#" onclick="smoothscroll(\'' . $link . '\');" ' . $link_param . '' . $open . '>'
				             . $name . '</a>';
				break;
			case 'login':
				$url      = wp_login_url( $param['menu_1']['item_link'][ $i ] );
				$sub_menu .= '<a href="' . $url . '" ' . $link_param . '' . $open . '>' . $name . '</a>';
				break;
			case 'logout':
				$url      = wp_logout_url( $param['menu_1']['item_link'][ $i ] );
				$sub_menu .= '<a href="' . $url . '" ' . $link_param . '' . $open . '>' . $name . '</a>';
				break;
			case 'register':
				$url      = wp_registration_url();
				$sub_menu .= '<a href="' . $url . '" ' . $link_param . '' . $open . '>' . $name . '</a>';
				break;
			case 'lostpassword':
				$url      = wp_lostpassword_url( $param['menu_1']['item_link'][ $i ] );
				$sub_menu .= '<a href="' . $url . '" ' . $link_param . '' . $open . '>' . $name . '</a>';
				break;
			case 'popup':
				$sub_menu .= '<a href="#fm-popup-' . $id . '" ' . $link_param . '' . $open . '>' . $name . '</a>';
				$popup    = true;
				break;
			case 'search':
				$sub_menu .= '<a href="#" onclick="return false">' . $icon . '<div class="fm-label' . $hold . '"><form class="fm-search" action="' . esc_url( home_url( '/' ) ) . '"><input type="search" class="fm-input" name="s" value="' . $tooltip . '"></form></div></a>';
				break;
			case 'telephone':
				$link     = 'tel:' . $param['menu_1']['item_link'][ $i ];
				$sub_menu .= '<a href="' . $link . '" ' . $link_param . '' . $open . '>' . $name . '</a>';
				break;
			case 'email':
				$email    = $param['menu_1']['item_link'][ $i ];
				$email    = is_email( $email ) ? antispambot( $email ) : $email;
				$tooltip  = $param['menu_1']['item_tooltip'][ $i ];
				$tooltip  = is_email( $tooltip ) ? antispambot( $tooltip ) : $tooltip;
				$hold     = ! empty( $param['menu_1']['hold_open'][ $i ] ) ? ' fm-hold-open' : '';
				$name     = $icon . '<div class="fm-label' . $hold . '">' . $tooltip
				            . '</div>';
				$sub_menu .= '<a href="mailto:' . $email . '" ' . $link_param . '' . $open . '>' . $name . '</a>';
				break;
		}
		$sub_menu .= '</li>';
	}
	$sub_menu .= '</ul>';
}

if ( ! empty( $param['menu_1']['item_type'] ) ) {
	$count_i = count( $param['menu_1']['item_type'] );
} else {
	$count_i = 0;
}


if ( $count_i > 0 ) {
	$menu = '<div class="floating-menu float-menu-' . absint( $id ) . '">';
	$menu .= '<ul class="fm-bar">';
	for ( $i = 0; $i < $count_i; $i ++ ) {

		if ( ! empty( $param['menu_1']['item_custom'][ $i ] ) ) {
			$img_alt = ! empty( $param['menu_1']['image_alt'][ $i ] ) ? ' alt="' . esc_attr( $param['menu_1']['image_alt'][ $i ] ) . '"' : '';
			$icon    = '<div class="fm-icon"><img src="' . $param['menu_1']['item_custom_link'][ $i ] . '"' . $img_alt . '></div>';
		} elseif ( ! empty( $param['menu_1']['item_custom_text_check'][ $i ] ) ) {
			$icon = '<div class="fm-icon fm-icon-text"><span>' . $param['menu_1']['item_custom_text'][ $i ] . '</span></div>';
		} else {
			$icon = '<div class="fm-icon"><i class="' . $param['menu_1']['item_icon'][ $i ] . '"></i></div>';
		}

		$button_class = $param['menu_1']['button_class'][ $i ];
		$class_add    = ! empty( $button_class ) ? ' class="' . $button_class . '"' : '';
		$button_id    = $param['menu_1']['button_id'][ $i ];
		$id_add       = ! empty( $button_id ) ? ' id="' . $button_id . '"' : '';
		$link_rel     = ! empty( $param['menu_1']['link_rel'][ $i ] ) ? ' rel="' . esc_attr( $param['menu_1']['link_rel'][ $i ] ) . '"' : '';

		$link_param = $id_add . $class_add . $link_rel;

		if ( $i == 0 && $count_sub > 0 ) {
			$menu .= '<li class="fm-sub fm-item-' . $id . '-' . $i . '">';
			$menu .= $icon;
			$menu .= $sub_menu;
			$menu .= '</li>';

		} elseif ( empty( $param['menu_1']['item_sub'][ $i ] ) ) {
			$menu    .= '<li class="fm-item-' . $id . '-' . $i . '">';
			$tooltip = $param['menu_1']['item_tooltip'][ $i ];
			$hold    = ! empty( $param['menu_1']['hold_open'][ $i ] ) ? ' fm-hold-open' : '';
			$name    = $icon . '<div class="fm-label' . $hold . '">' . $tooltip
			           . '</div>';

			$item_type = $param['menu_1']['item_type'][ $i ];
			$open      = ! empty( $param['menu_1']['hold_open'][ $i ] ) ? ' data-label="show"' : '';

			switch ( $item_type ) {
				case 'link':
					$target = ! empty( $param['menu_1']['new_tab'][ $i ] ) ? '_blank' : '_self';
					$link   = $param['menu_1']['item_link'][ $i ];
					$menu   .= '<a href="' . $link . '" target="' . $target . '" ' . $link_param . '' . $open . '>'
					           . $name . '</a>';
					break;
				case 'dynamic':
					$target = ! empty( $param['menu_1']['new_tab'][ $i ] ) ? '_blank' : '_self';
					$link   = apply_filters( 'float_menu_dynamic_link', '#' );
					$menu   .= '<a href="' . esc_url( $link ) . '" target="' . esc_attr( $target ) . '" ' . $link_param . '' . $open . '>'
					           . $name . '</a>';
					break;
				case 'id':
					$element = $param['menu_1']['item_modal'][ $i ];
					$menu    .= '<a role="button" id="' . $element . '" ' . $open . '>' . $name . '</a>';
					break;
				case 'class':
					$element = $param['menu_1']['item_modal'][ $i ];
					$menu    .= '<a role="button" class="' . $element . '" ' . $open . '>' . $name . '</a>';
					break;
				case 'share':
					$share_service = mb_strtolower( $param['menu_1']['item_share'][ $i ] );
					$share_link    = $social_services[ $share_service ];
					if ( $share_service == 'email' ) {
						$menu .= '<a role="button" onclick="window.open(\'' . $share_link . '\', \'_self\')" '
						         . $link_param . '' . $open . '>' . $name . '</a>';
						break;
					}
					$popup_open = 'window.open(\'' . $share_link . '\', \'_blank\', \'' . $popup_option . '\');';
					$menu       .= '<a role="button" onclick="' . $popup_open . '" ' . $link_param . '' . $open . '>'
					               . $name . '</a>';
					break;
				case 'translate':
					$link  = '#';
					$glang = $param['menu_1']['gtranslate'][ $i ];
					$menu  .= '<a href="' . $link . '" ' . $link_param . '' . $open . ' data-google-lang="' . $glang . '">'
					          . $name . '</a>';
					break;
				case 'print':
					$menu .= '<a role="button" onclick="pageprint();" ' . $link_param . '' . $open . '>' . $name
					         . '</a>';
					break;
				case 'totop':
					$menu .= '<a role="button" onclick="scrollToTop();" ' . $link_param . '' . $open . '>' . $name
					         . '</a>';
					break;
				case 'tobottom':
					$menu .= '<a role="button" onclick="scrollToBottom();" ' . $link_param . '' . $open . '>' . $name
					         . '</a>';
					break;
				case 'goback':
					$menu .= '<a href="#" onclick="goBack();" ' . $link_param . '' . $open . '>' . $name . '</a>';
					break;
				case 'goforward':
					$menu .= '<a href="#" onclick="goForward();" ' . $link_param . '' . $open . '>' . $name . '</a>';
					break;
				case 'smoothscroll':
					$link = $param['menu_1']['item_link'][ $i ];
					$menu .= '<a role="button" onclick="smoothscroll(\'' . $link . '\');" ' . $link_param . '' . $open
					         . '>' . $name . '</a>';
					break;
				case 'login':
					$url  = wp_login_url( $param['menu_1']['item_link'][ $i ] );
					$menu .= '<a href="' . $url . '" ' . $link_param . '' . $open . '>' . $name . '</a>';
					break;
				case 'logout':
					$url  = wp_logout_url( $param['menu_1']['item_link'][ $i ] );
					$menu .= '<a href="' . $url . '" ' . $link_param . '' . $open . '>' . $name . '</a>';
					break;
				case 'register':
					$url  = wp_registration_url();
					$menu .= '<a href="' . $url . '" ' . $link_param . '' . $open . '>' . $name . '</a>';
					break;
				case 'lostpassword':
					$url  = wp_lostpassword_url( $param['menu_1']['item_link'][ $i ] );
					$menu .= '<a href="' . $url . '" ' . $link_param . '' . $open . '>' . $name . '</a>';
					break;
				case 'popup':
					$menu  .= '<a href="#fm-popup-' . $id . '" ' . $link_param . '' . $open . '>' . $name . '</a>';
					$popup = true;
					break;
				case 'search':
					$menu .= '<a href="#" onclick="return false">' . $icon . '<div class="fm-label' . $hold . '"><form class="fm-search" action="' . esc_url( home_url( '/' ) ) . '"><input type="search" class="fm-input" name="s" value="' . $tooltip . '"></form></div></a>';
					break;
				case 'telephone':
					$link = 'tel:' . $param['menu_1']['item_link'][ $i ];
					$menu .= '<a href="' . $link . '" ' . $link_param . '' . $open . '>' . $name . '</a>';
					break;
				case 'email':
					$email   = $param['menu_1']['item_link'][ $i ];
					$email   = is_email( $email ) ? antispambot( $email ) : $email;
					$tooltip = $param['menu_1']['item_tooltip'][ $i ];
					$tooltip = is_email( $tooltip ) ? antispambot( $tooltip ) : $tooltip;
					$hold    = ! empty( $param['menu_1']['hold_open'][ $i ] ) ? ' fm-show' : '';
					$name    = $icon . '<div class="fm-label' . $hold . '">' . $tooltip
					           . '</div>';
					$menu    .= '<a href="mailto:' . $email . '" ' . $link_param . '' . $open . '>' . $name . '</a>';
					break;
			}

			$menu .= '</li>';
		}
	}
	$menu .= '</ul>';

	if ( ! empty( $popup ) ) {

		$menu .= '<div class="fm-window"><div class="fm-shadow"></div><div id="fm-popup-' . $id
		         . '" class="fm-panel"><div class="fm-head"><div class="fm-title">' . $param['popuptitle']
		         . '</div><div class="fm-close"><i class="fas fa-times" aria-hidden="true"></i></div></div>';
		$menu .= '<div class="fm-body">' . do_shortcode( $param['popupcontent'] ) . '</div></div></div>';

	}

	$menu .= '</div>';

	echo $menu;
}