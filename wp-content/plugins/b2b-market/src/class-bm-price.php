<?php
/**
 * Class to handle price calculation in B2B Market.
 */
class BM_Price {
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

		// Simple, grouped and external products.
		add_filter( 'woocommerce_product_get_price', array( $this, 'set_price' ), 10, 2 );
		add_filter( 'woocommerce_product_grouped_get_price', array( $this, 'set_grouped_price' ), 10, 2 );

		// Modify regular price if sale price and B2B price available.
		add_filter( 'woocommerce_product_get_regular_price', array( $this, 'set_regular_price' ), 10, 2 );
		add_filter( 'woocommerce_product_variation_get_regular_price', array( $this, 'set_regular_price' ), 10, 2 );

		// Variations.
		add_filter( 'woocommerce_product_variation_get_price', array( $this, 'set_price' ), 10, 2 );

		// Variable (price range).
		add_filter( 'woocommerce_variation_prices_price', array( $this, 'set_variable_price' ), 10, 3 );
		add_filter( 'woocommerce_variation_prices_regular_price', array( $this, 'set_variable_price' ), 10, 3 );

		// Handling price caching.
		add_filter( 'woocommerce_get_variation_prices_hash', array( $this, 'regenerate_hash' ), 10, 1 );

		// Modify cart prices.
		add_action( 'woocommerce_get_cart_contents', array( $this, 'recalculate_prices' ) );
		add_action( 'woocommerce_before_main_content', array( $this, 'reenable_prices' ) );

		// Sale price output.
		add_filter( 'woocommerce_sale_flash', array( $this, 'show_sale_badge' ), 10, 3 );
		add_filter( 'woocommerce_format_sale_price', array( $this, 'show_sale_price' ), 20, 3 );
		add_filter( 'atomion_sale_percentage', array( $this, 'calculate_atomion_sale_percentage' ), 10, 2 );
		add_filter( 'atomion_sale_badge_html', array( $this, 'show_sale_price_atomion' ), 10, 6 );

		// Grouped prices output.
		add_filter( 'woocommerce_grouped_price_html', array( $this, 'set_grouped_price_html' ), 10, 3 );
	}

	/**
	 * Get calculated price.
	 *
	 * @param  string $price current price.
	 * @param  object $product current product object.
	 * @param  int    $group_id current group id.
	 * @param  int    $qty current quantity of the product.
	 * @return float
	 */
	public static function get_price( $price, $product, $group_id, $qty ) {

		if ( false === $group_id ) {
			$group_id = BM_Conditionals::get_validated_customer_group();
		}

		// Save group and product data to reduce requests.
		$group      = get_post( $group_id );
		$product_id = $product->get_id();

		if ( empty( $group_id ) ) {
			return $price;
		}

		if ( property_exists( $product, 'bundled_item_price' ) && $product->bundled_item_price > 0 ) {
			return $price;
		}

		// Ensure price is float.
		$price = floatval( $price );

		// collect prices in array.
		$prices = array();

		// check if it's a variation.
		if ( 'variation' === $product->get_type() ) {
			$parent_id = $product->get_parent_id();
		} else {
			$parent_id = 0;
		}

		// get group prices from product and customer group.
		$group_prices = apply_filters(
			'bm_group_prices',
			array(
				'global'  => get_option( 'bm_global_group_prices' ),
				'group'   => get_post_meta( $group_id, 'bm_group_prices', true ),
				'product' => get_post_meta( $product_id, 'bm_' . $group->post_name . '_group_prices', true ),
			)
		);

		// get bulk prices from product, customer group.
		$bulk_prices = apply_filters(
			'bm_bulk_prices',
			array(
				'global'  => get_option( 'bm_global_bulk_prices' ),
				'group'   => get_post_meta( $group_id, 'bm_bulk_prices', true ),
				'product' => get_post_meta( $product_id, 'bm_' . $group->post_name . '_bulk_prices', true ),
			)
		);

		// collect bulk prices for sorting.
		$sortable_bulk_prices = array();

		// calculate group prices and add them to $prices.
		if ( ! empty( $group_prices ) ) {
			foreach ( $group_prices as $price_type => $price_entries ) {
				if ( is_array( $price_entries ) ) {
					foreach ( $price_entries as $price_data ) {

						// no price skip entry.
						if ( empty( $price_data['group_price'] ) ) {
							continue;
						}

						// no type set.
						if ( empty( $price_data['group_price_type'] ) ) {
							$type = 'fix';
						} else {
							$type = $price_data['group_price_type'];
						}

						// no category set.
						if ( empty( $price_data['group_price_category'] ) ) {
							$category = 0;
						} else {
							$category = $price_data['group_price_category'];
						}

						// check for category restriction before calculating.
						if ( $category > 0 ) {
							// if it's a variation we need to check for the parent id.
							if ( $parent_id > 0 ) {

								if ( ! has_term( $category, 'product_cat', $parent_id ) && ! self::product_in_descendant_category( $category, $parent_id ) ) {
									continue;
								}
							} else {
								if ( ! has_term( $category, 'product_cat', $product_id ) && ! self::product_in_descendant_category( $category, $product_id ) ) {
									continue;
								}
							}
						}

						// ensure price is float.
						$group_price = floatval( $price_data['group_price'] );

						// check type, calculate price and add them to prices.
						if ( $group_price > 0 ) {
							switch ( $type ) {
								case 'fix':
									$prices[] = $group_price;
									break;

								case 'discount':
									$group_price = $price - $group_price;

									if ( $group_price > 0 ) {
										$prices[] = $group_price;
									}
									break;

								case 'discount-percent':
									$group_price = $price - ( $group_price * $price / 100 );
									if ( $group_price > 0 ) {
										$prices[] = $group_price;
									}
									break;
							}
						}
					}
				}
			}
		}

		// calculate bulk prices and add them to $prices.
		if ( ! empty( $bulk_prices ) ) {
			foreach ( $bulk_prices as $price_type => $price_entries ) {

				if ( is_array( $price_entries ) ) {
					foreach ( $price_entries as $price_data ) {

						// no price skip.
						if ( empty( $price_data['bulk_price'] ) ) {
							continue;
						}
						// no from skip.
						if ( empty( $price_data['bulk_price_from'] ) ) {
							continue;
						}

						// no type set default.
						if ( empty( $price_data['bulk_price_type'] ) ) {
							$type = 'fix';
						} else {
							$type = $price_data['bulk_price_type'];
						}

						// $to equals 0.
						if ( 0 === intval( $price_data['bulk_price_to'] ) ) {
							$to = INF;
						} else {
							$to = intval( $price_data['bulk_price_to'] );
						}

						// no category set.
						if ( empty( $price_data['bulk_price_category'] ) ) {
							$category = 0;
						} else {
							$category = $price_data['bulk_price_category'];
						}

						// check for category restriction before calculating.
						if ( $category > 0 ) {
							// if it's a variation we need to check for the parent id.
							if ( $parent_id > 0 ) {
								if ( ! has_term( $category, 'product_cat', $parent_id ) && ! self::product_in_descendant_category( $category, $parent_id ) ) {
									continue;
								}
							} else {
								if ( ! has_term( $category, 'product_cat', $product_id ) && ! self::product_in_descendant_category( $category, $product_id ) ) {
									continue;
								}
							}
						}

						$bulk_price = floatval( $price_data['bulk_price'] );
						$from       = intval( $price_data['bulk_price_from'] );

						if ( $bulk_price > 0 ) {
							switch ( $type ) {
								case 'fix':
									$sortable_bulk_prices[] = $bulk_price . '|' . $from . '|' . $product_id;

									// add to prices if matched qty.
									if ( ( $qty >= $from ) && ( $qty <= $to ) ) {
										$prices[] = $bulk_price;
									}
									break;

								case 'discount':
									$bulk_price = $price - $bulk_price;

									if ( $bulk_price > 0 ) {
										$sortable_bulk_prices[] = $bulk_price . '|' . $from . '|' . $product_id;
									}

									// add to prices if matched qty.
									if ( ( $qty >= $from ) && ( $qty <= $to ) && $bulk_price > 0 ) {
										$prices[] = $bulk_price;
									}
									break;

								case 'discount-percent':
									$bulk_price = $price - ( $bulk_price * $price / 100 );

									if ( $bulk_price > 0 ) {
										$sortable_bulk_prices[] = $bulk_price . '|' . $from . '|' . $product_id;
									}

									// add to prices if matched qty.
									if ( ( $qty >= $from ) && ( $qty <= $to ) && $bulk_price > 0 ) {
										$prices[] = $bulk_price;
									}
									break;
							}
						}
					}
				}
			}
		}

		// Display cheapest bulk when available.
		if ( ! empty( $sortable_bulk_prices[0] ) ) {
			// sort bulk prices by cheapest.
			sort( $sortable_bulk_prices, SORT_NATURAL );
			$cheapest_bulk_price = $sortable_bulk_prices[0];

			// display possible discount before price.
			add_filter(
				'bm_bulk_discount_string',
				function ( $string, $product_id ) use ( $cheapest_bulk_price ) {

					$cheapest_bulk_price = explode( '|', $cheapest_bulk_price );

					// Modify price based on tax setting.
					$product = wc_get_product( $product_id );

					$cheapest_price = BM_Tax::get_tax_price( $product, $cheapest_bulk_price[0] );

					if ( $cheapest_price > 0 ) {

						$bulk_price_message = str_replace( array( '[bulk_qty]', '[bulk_price]' ), array( $cheapest_bulk_price[1], wc_price( $cheapest_price ) ), get_option( 'bm_bulk_price_discount_message', 'From [bulk_qty]x only [bulk_price] each.' ) );

						$string = '<span class="bm-cheapest-bulk" style="float:left;width:100%;margin-bottom:10px;"><b>' . $bulk_price_message . '</b></span></br>';

						// Check if condtions match.
						$show_on_shop    = get_option( 'bm_bulk_price_on_shop', 'off' );
						$show_on_product = get_option( 'bm_bulk_price_on_product', 'off' );

						if ( is_shop() && 'on' === $show_on_shop || is_product_category() && 'on' === $show_on_shop || is_product_tag() && 'on' === $show_on_shop ) {
							if ( $product_id == $cheapest_bulk_price[2] ) {
								return $string;
							}
						}
						if ( is_singular( 'product' ) && 'on' === $show_on_product || is_product() && 'on' === $show_on_product ) {
							if ( $product_id == $cheapest_bulk_price[2] ) {
								return $string;
							}
						}
					} else {
						return '';
					}
				},
				10,
				2
			);
		}

		// add the original price.
		$prices[] = $price;
		return min( $prices );
	}

	/**
	 * Set price.
	 *
	 * @param  float  $price current price.
	 * @param  object $product current product object.
	 * @return float
	 */
	public function set_price( $price, $product ) {
		if ( is_cart() || is_checkout() ) {
			return $price;
		}

		$group_id       = BM_Conditionals::get_validated_customer_group();
		$cheapest_price = self::get_price( $price, $product, $group_id, apply_filters( 'bm_default_qty', 1 ) );

		if ( $cheapest_price > 0 ) {
			return $cheapest_price;
		}

		return $price;
	}

	/**
	 * Set regular price if sale price and cheapest price is available.
	 *
	 * @param float  $regular_price given regular price.
	 * @param object $product given product object.
	 * @return float
	 */
	public function set_regular_price( $regular_price, $product ) {
		if ( is_cart() || is_checkout() ) {
			return $regular_price;
		}

		$sale_price = $product->get_sale_price();

		// Check sale price end date.
		$sale_price_end_date = get_post_meta( $product->get_id(), '_sale_price_dates_to', true );

		if ( ! empty( $sale_price_end_date ) ) {
			$today  = gmdate( 'd-m-Y', strtotime( 'today' ) );
			$expire = gmdate( 'd-m-Y', intval( $sale_price_end_date ) );

			$today_date  = new DateTime( $today );
			$expire_date = new DateTime( $expire );

			if ( $expire_date < $today_date ) {
				$sale_price = $regular_price;
			}
		}

		if ( $sale_price > $product->get_price() ) {
			return $sale_price . '.00000000001';
		}
		return $regular_price;
	}

	/**
	 * Set price.
	 *
	 * @param  float  $price current price.
	 * @param  object $product current product object.
	 * @return float
	 */
	public function set_grouped_price( $price, $product ) {
		return $price;
	}

	/**
	 * Set price for variable products.
	 *
	 * @param float  $price current price.
	 * @param object $variation current variation.
	 * @param object $product current product.
	 * @return float
	 */
	public function set_variable_price( $price, $variation, $product ) {
		$group_id       = BM_Conditionals::get_validated_customer_group();
		$cheapest_price = self::get_price( $price, $variation, $group_id, apply_filters( 'bm_default_qty', 1 ) );

		if ( $cheapest_price > 0 ) {
			return $cheapest_price;
		}
		return $price;
	}


	/**
	 * Handles cache busting for variations.
	 *
	 * @param  string $hash current hash for caching.
	 * @return string
	 */
	public function regenerate_hash( $hash ) {
		$group_id = BM_Conditionals::get_validated_customer_group();

		$bm_random = apply_filters( 'bm_random_for_admin', true );

		if ( current_user_can( 'administrator' ) && $bm_random ) {
			$hash[] = get_current_user_id() . wp_rand( 1, 10000000 );
		} else {
			$hash[] = get_current_user_id() . '_' . $group_id;
		}

		return $hash;
	}

	/**
	 * Recalculate the item price if options from WooCommerce TM Extra Product Options attached.
	 *
	 * @param object $cart current cart object.
	 * @return object
	 */
	public function recalculate_prices( $cart ) {

		if ( is_admin() && ! defined( 'DOING_AJAX' ) ) {
			return;
		}

		remove_filter( 'woocommerce_product_get_price', array( $this, 'set_price' ), 10, 2 );
		remove_filter( 'woocommerce_product_variation_get_price', array( $this, 'set_price' ), 10, 2 );

		foreach ( $cart as $hash => $item ) {
			// Find the correct product by ID to use.
			$product = wc_get_product( $item['product_id'] );

			if ( isset( $item['variation_id'] ) && ! empty( $item['variation_id'] ) ) {
				$product = wc_get_product( $item['variation_id'] );
			}

			if ( isset( $item['bundled_by'] ) && ! empty( $item['bundled_by'] ) ) {
				return $cart;
			}

			$group_id = BM_Conditionals::get_validated_customer_group();

			if ( ! $group_id ) {
				return $cart;
			}

			$group = get_post( $group_id );
			$price = $item['data']->get_regular_price();
			$qty   = $item['quantity'];

			if ( $item['data']->get_sale_price() > 0 ) {
				$price = $item['data']->get_sale_price();
			}

			// Check sale price end date.
			$sale_price_end_date = get_post_meta( $product->get_id(), '_sale_price_dates_to', true );

			if ( ! empty( $sale_price_end_date ) ) {

				$today  = gmdate( 'd-m-Y', strtotime( 'today' ) );
				$expire = gmdate( 'd-m-Y', intval( $sale_price_end_date ) );

				$today_date  = new DateTime( $today );
				$expire_date = new DateTime( $expire );

				if ( $expire_date < $today_date ) {
					$price = $item['data']->get_regular_price();
				}
			}

			$cheapest_price = self::get_price( $price, $product, $group_id, $qty );

			// TM Extra Product options.
			if ( isset( $item['tmhasepo'] ) && ! empty( $item['tmhasepo'] ) ) {
				$options_price  = floatval( $item['tm_epo_options_prices'] );
				$cheapest_price = $cheapest_price + $options_price;
			}

			$item['data']->set_price( $cheapest_price );
		}
		return $cart;
	}

	/**
	 * Reenable price filter after mini cart.
	 *
	 * @return void
	 */
	public function reenable_prices() {
		add_filter( 'woocommerce_product_get_price', array( $this, 'set_price' ), 10, 2 );
		add_filter( 'woocommerce_product_variation_get_price', array( $this, 'set_price' ), 10, 2 );
	}

	/**
	 * Check if product is in sub category of given category.
	 *
	 * @param  int $category given category as ID.
	 * @param  int $product_id current product ID.
	 * @return bool
	 */
	public static function product_in_descendant_category( $category, $product_id ) {
		$descendants = get_term_children( $category, 'product_cat' );

		if ( $descendants && has_term( $descendants, 'product_cat', $product_id ) ) {
			return true;
		}
		return false;
	}

	/**
	 * Show sale price based on conditions.
	 *
	 * @param float $price current price.
	 * @param float $regular_price current regular price.
	 * @param float $sale_price current sale price.
	 * @return string
	 */
	public function show_sale_price( $price, $regular_price, $sale_price ) {
		$show_sale = apply_filters( 'bm_show_sale_price', true );

		if ( $show_sale ) {
			return $price;
		}

		if ( $regular_price > $sale_price ) {
			return wc_price( $sale_price );
		}
		return wc_price( $regular_price );
	}

	/**
	 * Show or hide sale badge.
	 *
	 * @param string $span_class_onsale_esc_html_sale_woocommerce_span current html string.
	 * @param object $post post object.
	 * @param object $product product object.
	 * @return string
	 */
	public function show_sale_badge( $span_class_onsale_esc_html_sale_woocommerce_span, $post, $product ) {
		$show_sale = apply_filters( 'bm_show_sale_price', true );

		if ( $show_sale ) {
			return $span_class_onsale_esc_html_sale_woocommerce_span;
		}
	}

	/**
	 * Show / hide sale badge in Atomion.
	 *
	 * @param string $text given discount text.
	 * @param object $post current post object.
	 * @param object $product current product object.
	 * @param string $discount_setting current discount setting.
	 * @param float  $discount given discount.
	 * @param string $sale_text sale text.
	 * @return string
	 */
	public function show_sale_price_atomion( $text, $post, $product, $discount_setting, $discount, $sale_text ) {
		$show_sale = apply_filters( 'bm_show_sale_price', true );

		if ( $show_sale ) {
			return $text;
		}

		return '';
	}


	/**
	 * Set grouped price HTML.
	 *
	 * @param string $price_this_get_price_suffix price with suffix.
	 * @param object $instance given object instance.
	 * @param array  $child_prices list of prices.
	 * @return string
	 */
	public function set_grouped_price_html( $price_this_get_price_suffix, $instance, $child_prices ) {
		$lowest_price  = min( $child_prices );
		$highest_price = max( $child_prices );

		if ( $lowest_price === $highest_price ) {
			return wc_price( $lowest_price );
		}

		return wc_price( $lowest_price ) . ' - ' . wc_price( $highest_price );
	}

	/**
	 * Get cheapest bulk price from given id.
	 *
	 * @param int $product_id given product id.
	 * @param int $group_id given group_id.
	 * @return array
	 */
	public static function get_cheapest_bulk_price( $product_id, $group_id = false ) {

		if ( false === $group_id ) {
			$group_id = BM_Conditionals::get_validated_customer_group();
		}

		// Save group and product data to reduce requests.
		$group   = get_post( $group_id );
		$product = wc_get_product( $product_id );
		$price   = $product->get_price();

		if ( empty( $group_id ) ) {
			return;
		}

		// check if it's a variation.
		if ( 'variation' === $product->get_type() ) {
			$parent_id = $product->get_parent_id();
		} else {
			$parent_id = 0;
		}

		// get bulk prices from product, customer group.
		$bulk_prices = apply_filters(
			'bm_bulk_prices',
			array(
				'global'  => get_option( 'bm_global_bulk_prices' ),
				'group'   => get_post_meta( $group_id, 'bm_bulk_prices', true ),
				'product' => get_post_meta( $product_id, 'bm_' . $group->post_name . '_bulk_prices', true ),
			)
		);

		// collect bulk prices for sorting.
		$sortable_bulk_prices = array();

		// calculate bulk prices and add them to $prices.
		if ( ! empty( $bulk_prices ) ) {
			foreach ( $bulk_prices as $price_type => $price_entries ) {

				if ( is_array( $price_entries ) ) {
					foreach ( $price_entries as $price_data ) {

						// no price skip.
						if ( empty( $price_data['bulk_price'] ) ) {
							continue;
						}
						// no from skip.
						if ( empty( $price_data['bulk_price_from'] ) ) {
							continue;
						}

						// no type set default.
						if ( empty( $price_data['bulk_price_type'] ) ) {
							$type = 'fix';
						} else {
							$type = $price_data['bulk_price_type'];
						}

						// $to equals 0.
						if ( 0 === intval( $price_data['bulk_price_to'] ) ) {
							$to = INF;
						} else {
							$to = intval( $price_data['bulk_price_to'] );
						}

						// no category set.
						if ( empty( $price_data['bulk_price_category'] ) ) {
							$category = 0;
						} else {
							$category = $price_data['bulk_price_category'];
						}

						// check for category restriction before calculating.
						if ( $category > 0 ) {
							// if it's a variation we need to check for the parent id.
							if ( $parent_id > 0 ) {
								if ( ! has_term( $category, 'product_cat', $parent_id ) && ! self::product_in_descendant_category( $category, $parent_id ) ) {
									continue;
								}
							} else {
								if ( ! has_term( $category, 'product_cat', $product_id ) && ! self::product_in_descendant_category( $category, $product_id ) ) {
									continue;
								}
							}
						}

						$bulk_price = floatval( $price_data['bulk_price'] );
						$from       = intval( $price_data['bulk_price_from'] );

						if ( $bulk_price > 0 ) {
							switch ( $type ) {
								case 'fix':
									$sortable_bulk_prices[] = $bulk_price . '|' . $from . '|' . $product_id;
									break;

								case 'discount':
									$bulk_price = $price - $bulk_price;

									if ( $bulk_price > 0 ) {
										$sortable_bulk_prices[] = $bulk_price . '|' . $from . '|' . $product_id;
									}
									break;
								case 'discount-percent':
									$bulk_price = $price - ( $bulk_price * $price / 100 );

									if ( $bulk_price > 0 ) {
										$sortable_bulk_prices[] = $bulk_price . '|' . $from . '|' . $product_id;
									}
									break;
							}
						}
					}
				}
			}
		}

		// Display cheapest bulk when available.
		if ( ! empty( $sortable_bulk_prices[0] ) ) {
			// sort bulk prices by cheapest.
			sort( $sortable_bulk_prices, SORT_NATURAL );
			$cheapest_bulk_price = $sortable_bulk_prices[0];
			return $cheapest_bulk_price;
		}
	}



	/**
	 * Recalculate atomion sale percentage.
	 *
	 * @param float  $discount given discount value.
	 * @param object $product given product object.
	 * @return int
	 */
	public function calculate_atomion_sale_percentage( $discount, $product ) {
		$current_price = floatval( self::get_price( $product->get_regular_price(), $product, false, apply_filters( 'bm_default_qty', 1 ) ) );

		if ( $product->get_sale_price() <= $current_price ) {
			return $discount;
		}

		$discount = ( $current_price / floatval( $product->get_price() ) ) * 100;
		$discount = ceil( 100 - $discount );

		if ( $discount <= 0 ) {
			$price = floatval( $product->get_regular_price() );

			if ( $product->get_sale_price() > 0 ) {
				$price = floatval( $product->get_sale_price() );
			}

			$discount = ( $current_price / $price ) * 100;
			$discount = ceil( 100 - $discount );
		}

		return $discount;
	}
}
