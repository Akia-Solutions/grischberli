<?php
/**
 * Class to handle compatibilities with different themes and plugins.
 */
class BM_Compatibilities {
	/**
	 * Contains instance or null
	 *
	 * @var object|null
	 */
	private static $instance = null;

	/**
	 * Returns instance of BM_Price.
	 *
	 * @return object
	 */
	public static function get_instance() {

		if ( null === self::$instance ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * Constructor for BM_Price.
	 */
	public function __construct() {

		// Prices.
		$prices = BM_Price::get_instance();

		// WP Bakery Pagebuilder.
		add_action( 'woocommerce_shortcode_before_featured_products_loop', array( $prices, 'reenable_prices' ) );
	}
}
