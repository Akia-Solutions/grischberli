<?php
/**
 * Clone Elements Settings
 *
 * @package     Wow_Plugin
 * @copyright   Copyright (c) 2018, Dmytro Lobov
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Elements for clone Menu 1
$menu_1_item_icon        = array(
	'name'   => 'param[menu_1][item_icon][]',
	'class'  => 'icons',
	'type'   => 'select',
	'val'    => 'fas fa-hand-point-up',
	'option' => $icons_new,
);
$menu_1_item_custom      = array(
	'name'  => 'param[menu_1][item_custom][]',
	'type'  => 'checkbox',
	'class' => 'custom-icon',
	'val'   => 0,
	'func'  => 'customicon(this); checkboxchecked(this);',
);
$menu_1_item_custom_link = array(
	'name'   => 'param[menu_1][item_custom_link][]',
	'type'   => 'text',
	'class'  => 'custom-icon-url',
	'val'    => '',
	'option' => array(
		'placeholder' => esc_attr__( 'Enter Icon URL', $this->plugin['text'] ),
	),
);
// Select custom icon
$menu_1_custom_text_check = array(
	'name'  => 'param[menu_1][item_custom_text_check][]',
	'type'  => 'checkbox',
	'class' => 'custom-icon-text',
	'val'   => 0,
);

// Custom icon URL
$menu_1_custom_text = array(
	'name'   => 'param[menu_1][item_custom_text][]',
	'type'   => 'text',
	'val'    => '',
	'class' => 'icon-custom-text',
	'option' => array(
		'placeholder' => esc_attr__( 'Enter text', $this->plugin['text'] ),
	),
);


$menu_1_item_tooltip     = array(
	'name'  => 'param[menu_1][item_tooltip][]',
	'class' => 'item-tooltip',
	'type'  => 'text',
	'val'   => '',
);

$menu_1_item_sub = array(
	'name' => 'param[menu_1][item_sub][]',
	'type' => 'checkbox',
	'class' => 'sub-item',
	'val'  => '',
);

$menu_1_item_sub_help = array(
	'text' => esc_attr__( 'Set item as sub item for first item of the menu.', $this->plugin['text'] ),
);

$menu_1_item_type = array(
	'name'   => 'param[menu_1][item_type][]',
	'type'   => 'select',
	'val'    => 'link',
	'class'  => 'item-type',
	'option' => array(
		'link'         => esc_attr__( 'Link', $this->plugin['text'] ),
		'share'        => esc_attr__( 'Share', $this->plugin['text'] ),
		'translate'    => esc_attr__( 'Translate', $this->plugin['text'] ),
		'search'       => esc_attr__( 'Search', $this->plugin['text'] ),
		'print'        => esc_attr__( 'Print', $this->plugin['text'] ),
		'totop'        => esc_attr__( 'Scroll to Top', $this->plugin['text'] ),
		'tobottom'     => esc_attr__( 'Scroll to Bottom', $this->plugin['text'] ),
		'smoothscroll' => esc_attr__( 'Smooth Scroll', $this->plugin['text'] ),
		'email'        => esc_attr__( 'Email', $this->plugin['text'] ),
		'telephone'    => esc_attr__( 'Telephone', $this->plugin['text'] ),
		'login'        => esc_attr__( 'Login', $this->plugin['text'] ),
		'logout'       => esc_attr__( 'Logout', $this->plugin['text'] ),
		'register'     => esc_attr__( 'Register', $this->plugin['text'] ),
		'lostpassword' => esc_attr__( 'Lostpassword', $this->plugin['text'] ),
		'id'           => esc_attr__( 'Item only with ID', $this->plugin['text'] ),
		'class'        => esc_attr__( 'Item only with Class', $this->plugin['text'] ),
		'popup'        => esc_attr__( 'Open Popup', $this->plugin['text'] ),
	),
	'func'   => 'itemtype(this);',
);

$menu_1_item_link = array(
	'name' => 'param[menu_1][item_link][]',
	'type' => 'text',
	'val'  => '',
);

$menu_1_new_tab = array(
	'name'  => 'param[menu_1][new_tab][]',
	'class' => '',
	'type'  => 'checkbox',
	'val'   => '',
);

$menu_1_item_share = array(
	'name'   => 'param[menu_1][item_share][]',
	'type'   => 'select',
	'val'    => 'Facebook',
	'option' => array(
		'Facebook'         => esc_attr__( 'Facebook', $this->plugin['text'] ),
		'VK'               => esc_attr__( 'VK', $this->plugin['text'] ),
		'Twitter'          => esc_attr__( 'Twitter', $this->plugin['text'] ),
		'Linkedin'         => esc_attr__( 'Linkedin', $this->plugin['text'] ),
		'Odnoklassniki'    => esc_attr__( 'Odnoklassniki', $this->plugin['text'] ),
		'Google'           => esc_attr__( 'Google', $this->plugin['text'] ),
		'Pinterest'        => esc_attr__( 'Pinterest', $this->plugin['text'] ),
		'xing'             => esc_attr__( 'XING', $this->plugin['text'] ),
		'myspace'          => esc_attr__( 'Myspace', $this->plugin['text'] ),
		'weibo'            => esc_attr__( 'Weibo', $this->plugin['text'] ),
		'buffer'           => esc_attr__( 'Buffer', $this->plugin['text'] ),
		'stumbleupon'      => esc_attr__( 'StumbleUpon', $this->plugin['text'] ),
		'reddit'           => esc_attr__( 'Reddit', $this->plugin['text'] ),
		'tumblr'           => esc_attr__( 'Tumblr', $this->plugin['text'] ),
		'blogger'          => esc_attr__( 'Blogger', $this->plugin['text'] ),
		'livejournal'      => esc_attr__( 'LiveJournal', $this->plugin['text'] ),
		'pocket'           => esc_attr__( 'Pocket', $this->plugin['text'] ),
		'telegram'         => esc_attr__( 'Telegram', $this->plugin['text'] ),
		'skype'            => esc_attr__( 'Skype', $this->plugin['text'] ),
		'email'            => esc_attr__( 'Email', $this->plugin['text'] ),
		'draugiem'         => esc_attr__( 'Draugiem', $this->plugin['text'] ),
		'whatsapp'         => esc_attr__( 'Whatsapp', $this->plugin['text'] ),
		'diaspora'         => esc_attr__( 'Diaspora', $this->plugin['text'] ),
		'digg'             => esc_attr__( 'Digg', $this->plugin['text'] ),
		'douban'           => esc_attr__( 'Douban', $this->plugin['text'] ),
		'evernote'         => esc_attr__( 'Evernote', $this->plugin['text'] ),
		'flipboard'        => esc_attr__( 'Flipboard', $this->plugin['text'] ),
		'google-bookmarks' => esc_attr__( 'Google Bookmarks', $this->plugin['text'] ),
		'hacker-news'      => esc_attr__( 'Hacker News', $this->plugin['text'] ),
		'instapaper'       => esc_attr__( 'Instapaper', $this->plugin['text'] ),
		'line'             => esc_attr__( 'Line', $this->plugin['text'] ),
		'qzone'            => esc_attr__( 'Qzone', $this->plugin['text'] ),
		'renren'           => esc_attr__( 'Renren', $this->plugin['text'] ),
	),
	'func'   => '',
);

$menu_1_item_gtranslate = array(
	'name'   => 'param[menu_1][gtranslate][]',
	'type'   => 'select',
	'val'    => '',
	'class'  => 'gtranslate',
	'option' => array(
		'af'  => esc_attr__( 'Afrikaans', $this->plugin['text'] ),
		'sq'  => esc_attr__( 'Albanian', $this->plugin['text'] ),
		'am'  => esc_attr__( 'Amharic', $this->plugin['text'] ),
		'ar'  => esc_attr__( 'Arabic', $this->plugin['text'] ),
		'hy'  => esc_attr__( 'Armenian', $this->plugin['text'] ),
		'az'  => esc_attr__( 'Azerbaijani', $this->plugin['text'] ),
		'eu'  => esc_attr__( 'Basque', $this->plugin['text'] ),
		'be'  => esc_attr__( 'Belarusian', $this->plugin['text'] ),
		'bn'  => esc_attr__( 'Bengali', $this->plugin['text'] ),
		'bs'  => esc_attr__( 'Bosnian', $this->plugin['text'] ),
		'bg'  => esc_attr__( 'Bulgarian', $this->plugin['text'] ),
		'ca'  => esc_attr__( 'Catalan', $this->plugin['text'] ),
		'ceb' => esc_attr__( 'Cebuano', $this->plugin['text'] ),
		'ny'  => esc_attr__( 'Chichewa', $this->plugin['text'] ),
		'co'  => esc_attr__( 'Corsican', $this->plugin['text'] ),
		'hr'  => esc_attr__( 'Croatian', $this->plugin['text'] ),
		'cs'  => esc_attr__( 'Czech', $this->plugin['text'] ),
		'da'  => esc_attr__( 'Danish', $this->plugin['text'] ),
		'nl'  => esc_attr__( 'Dutch', $this->plugin['text'] ),
		'en'  => esc_attr__( 'English', $this->plugin['text'] ),
		'eo'  => esc_attr__( 'Esperanto', $this->plugin['text'] ),
		'et'  => esc_attr__( 'Estonian', $this->plugin['text'] ),
		'tl'  => esc_attr__( 'Filipino', $this->plugin['text'] ),
		'fi'  => esc_attr__( 'Finnish', $this->plugin['text'] ),
		'fr'  => esc_attr__( 'French', $this->plugin['text'] ),
		'fy'  => esc_attr__( 'Frisian', $this->plugin['text'] ),
		'gl'  => esc_attr__( 'Galician', $this->plugin['text'] ),
		'ka'  => esc_attr__( 'Georgian', $this->plugin['text'] ),
		'de'  => esc_attr__( 'German', $this->plugin['text'] ),
		'el'  => esc_attr__( 'Greek', $this->plugin['text'] ),
		'gu'  => esc_attr__( 'Gujarati', $this->plugin['text'] ),
		'ht'  => esc_attr__( 'Haitian Creole', $this->plugin['text'] ),
		'ha'  => esc_attr__( 'Hausa', $this->plugin['text'] ),
		'haw' => esc_attr__( 'Hawaiian', $this->plugin['text'] ),
		'iw'  => esc_attr__( 'Hebrew', $this->plugin['text'] ),
		'hi'  => esc_attr__( 'Hindi', $this->plugin['text'] ),
		'hmn' => esc_attr__( 'Hmong', $this->plugin['text'] ),
		'hu'  => esc_attr__( 'Hungarian', $this->plugin['text'] ),
		'is'  => esc_attr__( 'Icelandic', $this->plugin['text'] ),
		'ig'  => esc_attr__( 'Igbo', $this->plugin['text'] ),
		'id'  => esc_attr__( 'Indonesian', $this->plugin['text'] ),
		'ga'  => esc_attr__( 'Irish', $this->plugin['text'] ),
		'it'  => esc_attr__( 'Italian', $this->plugin['text'] ),
		'ja'  => esc_attr__( 'Japanese', $this->plugin['text'] ),
		'jw'  => esc_attr__( 'Javanese', $this->plugin['text'] ),
		'kn'  => esc_attr__( 'Kannada', $this->plugin['text'] ),
		'kk'  => esc_attr__( 'Kazakh', $this->plugin['text'] ),
		'km'  => esc_attr__( 'Khmer', $this->plugin['text'] ),
		'ko'  => esc_attr__( 'Korean', $this->plugin['text'] ),
		'ku'  => esc_attr__( 'Kurdish (Kurmanji)', $this->plugin['text'] ),
		'ky'  => esc_attr__( 'Kyrgyz', $this->plugin['text'] ),
		'lo'  => esc_attr__( 'Lao', $this->plugin['text'] ),
		'la'  => esc_attr__( 'Latin', $this->plugin['text'] ),
		'lv'  => esc_attr__( 'Latvian', $this->plugin['text'] ),
		'lb'  => esc_attr__( 'Luxembourgish', $this->plugin['text'] ),
		'mk'  => esc_attr__( 'Macedonian', $this->plugin['text'] ),
		'mg'  => esc_attr__( 'Malagasy', $this->plugin['text'] ),
		'ms'  => esc_attr__( 'Malay', $this->plugin['text'] ),
		'ml'  => esc_attr__( 'Malayalam', $this->plugin['text'] ),
		'mt'  => esc_attr__( 'Maltese', $this->plugin['text'] ),
		'mi'  => esc_attr__( 'Maori', $this->plugin['text'] ),
		'mr'  => esc_attr__( 'Marathi', $this->plugin['text'] ),
		'mn'  => esc_attr__( 'Mongolian', $this->plugin['text'] ),
		'my'  => esc_attr__( 'Myanmar (Burmese)', $this->plugin['text'] ),
		'ne'  => esc_attr__( 'Nepali', $this->plugin['text'] ),
		'no'  => esc_attr__( 'Norwegian', $this->plugin['text'] ),
		'ps'  => esc_attr__( 'Pashto', $this->plugin['text'] ),
		'fa'  => esc_attr__( 'Persian', $this->plugin['text'] ),
		'pl'  => esc_attr__( 'Polish', $this->plugin['text'] ),
		'pt'  => esc_attr__( 'Portuguese', $this->plugin['text'] ),
		'pa'  => esc_attr__( 'Punjabi', $this->plugin['text'] ),
		'ro'  => esc_attr__( 'Romanian', $this->plugin['text'] ),
		'ru'  => esc_attr__( 'Russian', $this->plugin['text'] ),
		'sm'  => esc_attr__( 'Samoan', $this->plugin['text'] ),
		'gd'  => esc_attr__( 'Scottish Gaelic', $this->plugin['text'] ),
		'sr'  => esc_attr__( 'Serbian', $this->plugin['text'] ),
		'st'  => esc_attr__( 'Sesotho', $this->plugin['text'] ),
		'sn'  => esc_attr__( 'Shona', $this->plugin['text'] ),
		'sd'  => esc_attr__( 'Sindhi', $this->plugin['text'] ),
		'si'  => esc_attr__( 'Sinhala', $this->plugin['text'] ),
		'sk'  => esc_attr__( 'Slovak', $this->plugin['text'] ),
		'sl'  => esc_attr__( 'Slovenian', $this->plugin['text'] ),
		'so'  => esc_attr__( 'Somali', $this->plugin['text'] ),
		'es'  => esc_attr__( 'Spanish', $this->plugin['text'] ),
		'su'  => esc_attr__( 'Sudanese', $this->plugin['text'] ),
		'sw'  => esc_attr__( 'Swahili', $this->plugin['text'] ),
		'sv'  => esc_attr__( 'Swedish', $this->plugin['text'] ),
		'tg'  => esc_attr__( 'Tajik', $this->plugin['text'] ),
		'ta'  => esc_attr__( 'Tamil', $this->plugin['text'] ),
		'te'  => esc_attr__( 'Telugu', $this->plugin['text'] ),
		'th'  => esc_attr__( 'Thai', $this->plugin['text'] ),
		'tr'  => esc_attr__( 'Turkish', $this->plugin['text'] ),
		'uk'  => esc_attr__( 'Ukrainian', $this->plugin['text'] ),
		'ur'  => esc_attr__( 'Urdu', $this->plugin['text'] ),
		'uz'  => esc_attr__( 'Uzbek', $this->plugin['text'] ),
		'vi'  => esc_attr__( 'Vietnamese', $this->plugin['text'] ),
		'cy'  => esc_attr__( 'Welsh', $this->plugin['text'] ),
		'xh'  => esc_attr__( 'Xhosa', $this->plugin['text'] ),
		'yi'  => esc_attr__( 'Yiddish', $this->plugin['text'] ),
		'yo'  => esc_attr__( 'Yoruba', $this->plugin['text'] ),
		'zu'  => esc_attr__( 'Zulu', $this->plugin['text'] ),
	),
	'func'   => '',
);

$menu_1_item_modal = array(
	'name' => 'param[menu_1][item_modal][]',
	'type' => 'text',
	'val'  => '',
);


// Font color
$menu_1_color = array(
	'name' => 'param[menu_1][color][]',
	'type' => 'color',
	'val'  => '#ffffff',
);


// Background
$menu_1_bcolor = array(
	'name' => 'param[menu_1][bcolor][]',
	'type' => 'color',
	'val'  => '#128be0',
);


$menu_1_button_id = array(
	'name' => 'param[menu_1][button_id][]',
	'type' => 'text',
	'val'  => '',
);

$menu_1_button_id_help = array(
	'text' => esc_attr__( 'Set ID for element.', $this->plugin['text'] ),
);

$menu_1_button_class = array(
	'name' => 'param[menu_1][button_class][]',
	'type' => 'text',
	'val'  => '',
);

$menu_1_button_class_help = array(
	'title' => esc_attr__( 'Set Class for element.', $this->plugin['text'] ),
	'ul'    => array(
		esc_attr__( 'You may enter several classes separated by a space.', $this->plugin['text'] ),
	)
);

$menu_1_link_rel = array(
	'name' => 'param[menu_1][link_rel][]',
	'type' => 'text',
	'val'  => '',
);

$menu_1_image_alt = array(
	'name' => 'param[menu_1][image_alt][]',
	'type' => 'text',
	'val'  => '',
);

$menu_1_image_alt_help = array(
	'title' => esc_attr__( 'Image Alt', $this->plugin['text'] ),
	'ul'    => array(
		esc_attr__( 'Set the attribute Alt for custom image.', $this->plugin['text'] ),
	)
);

$menu_1_hold_open = array(
	'name'  => 'param[menu_1][hold_open][]',
	'class' => '',
	'type'  => 'checkbox',
	'val'   => '',
);

$menu_1_item_icon_help = array(
	'title' => esc_attr__( 'Set the icon for menu item. If you want use the custom item:', $this->plugin['text'] ),
	'ul'    => array(
		esc_attr__( '1. Check the box on "custom"', $this->plugin['text'] ),
		esc_attr__( '2. Upload the icon in Media Library', $this->plugin['text'] ),
		esc_attr__( '3. Copy the URL to icon', $this->plugin['text'] ),
		esc_attr__( '4. Paste the icon URL to field', $this->plugin['text'] ),
	),
);

$menu_1_item_tooltip_help = array(
	'text' => esc_attr__( 'Set the text for menu item.', $this->plugin['text'] ),
);

$menu_1_item_type_help = array(
	'text' => esc_attr__( 'Select the type of menu item. Explanation of some types:', $this->plugin['text'] ),
	'ul'   => array(
		esc_attr__( '<strong>Smooth Scroll</strong> - Smooth scrolling of the page to the specified anchors on the page. Enter Link like #anchor', $this->plugin['text'] ),

	),
);

$menu_1_hold_open_help = array(
	'text' => esc_attr__( 'When the page loads, the menu item will open.', $this->plugin['text'] ),
);