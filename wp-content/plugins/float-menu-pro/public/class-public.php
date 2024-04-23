<?php
/**
 * Public Class
 *
 * @package     Wow_Plugin
 * @subpackage  Public
 * @author      Wow-Company <helper@wow-company.com>
 * @copyright   2019 Wow-Company
 * @license     GNU Public License
 * @version     1.0
 */

namespace float_menu_pro;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Wow_Plugin_Public
 *
 * @package wow_plugin
 *
 * @property array plugin   - base information about the plugin
 * @property array url      - home, pro and other URL for plugin
 * @property array rating   - website and link for rating
 * @property string basedir  - filesystem directory path for the plugin
 * @property string baseurl  - URL directory path for the plugin
 */
class Wow_Plugin_Public {

	/**
	 * Setup to frontend of the plugin
	 *
	 * @param array $info general information about the plugin
	 *
	 * @since 1.0
	 */

	public function __construct( $info ) {

		$this->plugin = $info['plugin'];
		$this->url    = $info['url'];
		$this->rating = $info['rating'];

		add_shortcode( $this->plugin['shortcode'], array( $this, 'shortcode' ) );
		// Display on the site
		add_action( 'wp_footer', array( $this, 'display' ) );
	}

	static function sub_menu_array( $var ) {
		return ( ! empty( $var ) );
	}


	/**
	 * Display a shortcode
	 *
	 * @param $atts
	 *
	 * @return false|string
	 */
	public function shortcode( $atts ) {
		extract( shortcode_atts( array( 'id' => "" ), $atts ) );
		$id = absint( $atts['id'] );

		global $wpdb;
		$table  = $wpdb->prefix . 'wow_' . $this->plugin['prefix'];
		$sSQL   = $wpdb->prepare( "select * from $table WHERE id = %d", $id );
		$result = $wpdb->get_results( $sSQL, 'OBJECT_K' );

		if ( empty( $result ) ) {
			return false;
		}

		$param = unserialize( $result[ $id ]->param );
		$check = $this->check( $param, $id );

		if ( $check === false ) {
			return false;
		}

		ob_start();
		include( 'partials/public.php' );
		$menu = ob_get_contents();
		ob_end_clean();

		$this->include_style_script( $param, $id );

		return $menu;
	}

	private function include_style_script( $param, $id ) {
		$slug    = $this->plugin['slug'];
		$version = $this->plugin['version'];

		if ( empty( $param['disable_fontawesome'] ) ) {
			$url_icons = $this->plugin['url'] . 'vendors/fontawesome/css/fontawesome-all.min.css';
			wp_enqueue_style( $slug . '-fontawesome', $url_icons, null, '5.15.3' );
		}

		$pre_suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';

		$url_style = plugin_dir_url( __FILE__ ) . 'assets/css/style' . $pre_suffix . '.css';
		wp_enqueue_style( $slug, $url_style, null, $version );

		$inline_style = self::style( $param, $id );
		wp_add_inline_style( $slug, $inline_style );

		$url_velocity = plugin_dir_url( __FILE__ ) . 'assets/js/velocity.min.js';
		wp_enqueue_script( 'velocity', $url_velocity, array( 'jquery' ), $version );

		$url_script = plugin_dir_url( __FILE__ ) . 'assets/js/floatMenu' . $pre_suffix . '.js';
		wp_enqueue_script( $slug, $url_script, array( 'jquery' ), $version );

		$inline_script = self::script( $param, $id );
		wp_add_inline_script( $slug, $inline_script );

		if ( $this->check_translation( $param ) ) {
			wp_enqueue_script( 'g-translate', '//translate.google.com/translate_a/element.js?cb=flTranslateInit', array(), $version );
		}
	}

	/**
	 * Display the Item on the specific pages, not via the Shortcode
	 */
	public function display() {
		require plugin_dir_path( __FILE__ ) . 'display.php';
	}

	/**
	 * Create Inline style for elements
	 */
	public function style( $param, $id ) {
		$css = '';
		require 'generator-style.php';

		return $css;

	}

	/**
	 * Create Inline script for elements
	 */
	public function script( $param, $id ) {
		$js = '';
		require 'generator-script.php';

		return $js;
	}

	public function langugesnew( $lang ) {
		$languages = array(
			'af'             => 'Afrikaans',
			'ar'             => 'العربية',
			'ary'            => 'العربية المغربية',
			'as'             => 'অসমীয়া',
			'az'             => 'Azərbaycan dili',
			'azb'            => 'گؤنئی آذربایجان',
			'bel'            => 'Беларуская мова',
			'bg_BG'          => 'Български',
			'bn_BD'          => 'বাংলা',
			'bo'             => 'བོད་ཡིག',
			'bs_BA'          => 'Bosanski',
			'ca'             => 'Català',
			'ceb'            => 'Cebuano',
			'cs_CZ'          => 'Čeština',
			'cy'             => 'Cymraeg',
			'da_DK'          => 'Dansk',
			'de_DE'          => 'Deutsch',
			'de_CH_informal' => 'Deutsch (Schweiz, Du)',
			'de_CH'          => 'Deutsch (Schweiz)',
			'de_DE_formal'   => 'Deutsch (Sie)',
			'de_AT'          => 'Deutsch (Österreich)',
			'dzo'            => 'རྫོང་ཁ',
			'el'             => 'Ελληνικά',
			'en_US'          => 'English (United States)',
			'en_GB'          => 'English (UK)',
			'en_AU'          => 'English (Australia)',
			'en_NZ'          => 'English (New Zealand)',
			'en_CA'          => 'English (Canada)',
			'en_ZA'          => 'English (South Africa)',
			'eo'             => 'Esperanto',
			'es_ES'          => 'Español',
			'es_VE'          => 'Español de Venezuela',
			'es_GT'          => 'Español de Guatemala',
			'es_CR'          => 'Español de Costa Rica',
			'es_MX'          => 'Español de México',
			'es_CO'          => 'Español de Colombia',
			'es_PE'          => 'Español de Perú',
			'es_CL'          => 'Español de Chile',
			'es_AR'          => 'Español de Argentina',
			'et'             => 'Eesti',
			'eu'             => 'Euskara',
			'fa_IR'          => 'فارسی',
			'fi'             => 'Suomi',
			'fr_FR'          => 'Français',
			'fr_CA'          => 'Français du Canada',
			'fr_BE'          => 'Français de Belgique',
			'fur'            => 'Friulian',
			'gd'             => 'Gàidhlig',
			'gl_ES'          => 'Galego',
			'gu'             => 'ગુજરાતી',
			'haz'            => 'هزاره گی',
			'he_IL'          => 'עִבְרִית',
			'hi_IN'          => 'हिन्दी',
			'hr'             => 'Hrvatski',
			'hu_HU'          => 'Magyar',
			'hy'             => 'Հայերեն',
			'id_ID'          => 'Bahasa Indonesia',
			'is_IS'          => 'Íslenska',
			'it_IT'          => 'Italiano',
			'ja'             => '日本語',
			'jv_ID'          => 'Basa Jawa',
			'ka_GE'          => 'ქართული',
			'kab'            => 'Taqbaylit',
			'kk'             => 'Қазақ тілі',
			'km'             => 'ភាសាខ្មែរ',
			'kn'             => 'ಕನ್ನಡ',
			'ko_KR'          => '한국어',
			'ckb'            => 'كوردی‎',
			'lo'             => 'ພາສາລາວ',
			'lt_LT'          => 'Lietuvių kalba',
			'lv'             => 'Latviešu valoda',
			'mk_MK'          => 'Македонски јазик',
			'ml_IN'          => 'മലയാളം',
			'mn'             => 'Монгол',
			'mr'             => 'मराठी',
			'ms_MY'          => 'Bahasa Melayu',
			'my_MM'          => 'ဗမာစာ',
			'nb_NO'          => 'Norsk bokmål',
			'ne_NP'          => 'नेपाली',
			'nl_NL'          => 'Nederlands',
			'nl_NL_formal'   => 'Nederlands (Formeel)',
			'nl_BE'          => 'Nederlands (België)',
			'nn_NO'          => 'Norsk nynorsk',
			'oci'            => 'Occitan',
			'pa_IN'          => 'ਪੰਜਾਬੀ',
			'pl_PL'          => 'Polski',
			'ps'             => 'پښتو',
			'pt_PT'          => 'Português',
			'pt_AO'          => 'Português de Angola',
			'pt_PT_ao90'     => 'Português (AO90)',
			'pt_BR'          => 'Português do Brasil',
			'rhg'            => 'Ruáinga',
			'ro_RO'          => 'Română',
			'ru_RU'          => 'Русский',
			'sah'            => 'Сахалыы',
			'si_LK'          => 'සිංහල',
			'sk_SK'          => 'Slovenčina',
			'skr'            => 'سرائیکی',
			'sl_SI'          => 'Slovenščina',
			'sq'             => 'Shqip',
			'sr_RS'          => 'Српски језик',
			'sv_SE'          => 'Svenska',
			'szl'            => 'Ślōnskŏ gŏdka',
			'ta_IN'          => 'தமிழ்',
			'te'             => 'తెలుగు',
			'th'             => 'ไทย',
			'tl'             => 'Tagalog',
			'tr_TR'          => 'Türkçe',
			'tt_RU'          => 'Татар теле',
			'tah'            => 'Reo Tahiti',
			'ug_CN'          => 'ئۇيغۇرچە',
			'uk'             => 'Українська',
			'ur'             => 'اردو',
			'uz_UZ'          => 'O‘zbekcha',
			'vi'             => 'Tiếng Việt',
			'zh_CN'          => '简体中文',
			'zh_TW'          => '繁體中文',
			'zh_HK'          => '香港中文版',
		);

		$default_lang = 'en_US';
		$old_lang     = $lang;
		if ( $old_lang !== 'all' ) {
			foreach ( $languages as $key => $val ) {
				$pos = strpos( $key, $old_lang );
				if ( $pos !== false ) {
					$default_lang = $key;
					break;
				}
			}
		}

		return $default_lang;

	}

	function check_translation( $param ) {
		$item_type = $param['menu_1']['item_type'];
		if ( ! in_array( "translate", $item_type ) ) {
			return false;
		}

		return true;
	}

	private function check_license() {
		$license = get_option( 'wow_license_key_' . $this->plugin['prefix'] );
		$status  = get_option( 'wow_license_status_' . $this->plugin['prefix'] );
		if ( empty( $license ) || $status !== 'valid' ) {
			return false;
		}

		return true;
	}

	private function check_status( $param ) {
		$status = isset( $param['menu_status'] ) ? $param['menu_status'] : 1;
		if ( empty( $status ) ) {
			return false;
		}

		return true;
	}

	private function check_test_mode( $param ) {
		if ( ! empty( $param['test_mode'] ) && ! current_user_can( 'administrator' ) ) {
			return false;
		}

		return true;
	}

	private function check_user( $param ) {
		$user      = isset( $param['item_user'] ) ? $param['item_user'] : 1;
		$user_role = isset( $param['user_role'] ) ? $param['user_role'] : 'all';

		if ( $user == 3 ) {
			return ! is_user_logged_in();
		} elseif ( $user == 2 ) {
			if ( ! is_user_logged_in() ) {
				return false;
			}
			$current_user = wp_get_current_user();
			if ( ! in_array( $user_role, $current_user->roles ) && $user_role != 'all' ) {
				return false;
			}
		}

		return true;

	}

	private function check_language( $param ) {
		if ( ! empty( $param['depending_language'] ) ) {
			if ( isset( $param['lang'] ) && ! isset( $param['language'] ) ) {
				$item_lang = $this->langugesnew( $param['lang'] );
			} else {
				$item_lang = $param['language'];
			}
			$site_lang = get_locale();
			if ( $site_lang != $item_lang ) {
				return false;
			}
		}

		return true;
	}

	private function check_browser( $param ) {
		$check = true;
		if ( ! empty( $param['all_browser'] ) ) {
			$browser = $this->get_browser_name();
			switch ( $browser ) {
				case 'Opera':
					$check = ! empty( $param['br_opera'] ) ? false : true;
					break;
				case 'Edge':
					$check = ! empty( $param['br_edge'] ) ? false : true;
					break;
				case 'Chrome':
					$check = ! empty( $param['br_chrome'] ) ? false : true;
					break;
				case 'Safari':
					$check = ! empty( $param['br_safari'] ) ? false : true;
					break;
				case 'Firefox':
					$check = ! empty( $param['br_firefox'] ) ? false : true;
					break;
				case 'IE':
					$check = ! empty( $param['br_ie'] ) ? false : true;
					break;
				case 'Other':
					$check = ! empty( $param['br_other'] ) ? false : true;
					break;
				default:
					$check = true;
			}

		}

		return $check;
	}

	private function get_browser_name() {
		$user_agent = $_SERVER['HTTP_USER_AGENT'];
		if ( strpos( $user_agent, 'Opera' ) || strpos( $user_agent, 'OPR/' ) ) {
			return 'Opera';
		} elseif ( strpos( $user_agent, 'Edg' ) ) {
			return 'Edge';
		} elseif ( strpos( $user_agent, 'Chrome' ) ) {
			return 'Chrome';
		} elseif ( strpos( $user_agent, 'Safari' ) ) {
			return 'Safari';
		} elseif ( strpos( $user_agent, 'Firefox' ) ) {
			return 'Firefox';
		} elseif ( strpos( $user_agent, 'MSIE' ) || strpos( $user_agent, 'Trident/7' ) ) {
			return 'IE';
		}

		return 'Other';

	}

	private function check_day( $param ) {
		$weekday = isset( $param['weekday'] ) ? $param['weekday'] : 'none';
		$day     = true;
		if ( $weekday !== 'none' ) {
			if ( $weekday != date( 'N' ) ) {
				$day = false;
			}
		}

		return $day;
	}


	private function check_time( $param ) {

		$time_start = isset( $param['time_start'] ) ? $param['time_start'] : '00:00';
		$time_end   = isset( $param['time_end'] ) ? $param['time_end'] : '23:59';

		$start   = str_replace( ':', ',', $time_start );
		$end     = str_replace( ':', ',', $time_end );
		$current = current_time( 'H,i' );

		if ( $start <= $current && $current <= $end ) {
			return true;
		} else {
			return false;
		}
	}

	private function check_date( $param ) {
		$date = true;
		if ( ! empty( $param['set_dates'] ) ) {
			$current = date( 'Y-m-d' );
			$start   = $param['date_start'];
			$end     = $param['date_end'];
			if ( $start <= $current && $current <= $end ) {
				$date = true;
			} else {
				$date = false;
			}
		}

		return $date;
	}


	private function check( $param, $id ) {
		$check     = true;
		$check_arr = array(
			'license'   => $this->check_license(),
			'status'    => $this->check_status( $param ),
			'test_mode' => $this->check_test_mode( $param ),
			'user'      => $this->check_user( $param ),
			'language'  => $this->check_language( $param ),
			'browser'   => $this->check_browser( $param ),
			'day'       => $this->check_day( $param ),
			'time'      => $this->check_time( $param ),
			'date'      => $this->check_date( $param ),
		);

		foreach ( $check_arr as $value ) {
			if ( $value === false ) {
				$check = false;
				break;
			}
		}

		return $check;
	}

}
