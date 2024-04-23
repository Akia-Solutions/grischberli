<?php

/**
 * Class which handles the frontend pricing display
 */
class BM_Shortcode {

	/**
	 * BM_Shortcode constructor.
	 */
	public function __construct() {
		add_shortcode( 'bulk-price-table', array( $this, 'bulk_price_table' ) );
		add_shortcode( 'b2b-group-display', array( $this, 'conditional_customer_group_output' ) );
		add_shortcode( 'b2b-customer-group', array( $this, 'show_current_customer_group' ) );
		add_filter( 'atomion_wc_checkout_description_show_excerpt', array( $this, 'remove_shortcode_from_cart_excerpt' ) );
	}

	/**
	 * Filter excerpt and remove shortcode if exists.
	 *
	 * @param  string $excerpt given excerpt.
	 * @return string
	 */
	public function remove_shortcode_from_cart_excerpt( $excerpt ) {
		return str_replace( '[bulk-price-table]', '', $excerpt );
	}


	/**
	 * Render bulk price table shortcode.
	 *
	 * @param [type] $atts list of arguments.
	 * @return void
	 */
	public function bulk_price_table( $atts ) {

		if ( ! is_product() && ! isset( $atts['product-id'] ) ) {
			return;
		}

		$id = get_the_id();

		if ( isset( $atts['product-id'] ) ) {
			$id = $atts['product-id'];
		}

		$product = wc_get_product( $id );
		$price   = floatval( $product->get_regular_price() );

		if ( isset( $atts['product-price'] ) ) {
			$price = $atts['product-price'];
		}

		if ( $product->get_sale_price() > 0 ) {
			$price = floatval( $product->get_sale_price() );
		}

		$group_id = BM_Conditionals::get_validated_customer_group();

		if ( empty( $group_id ) ) {
			return;
		}

		$group = get_post( $group_id );

		$bulk_prices = apply_filters(
			'bm_bulk_prices',
			array(
				'global'  => get_option( 'bm_global_bulk_prices' ),
				'group'   => get_post_meta( $group_id, 'bm_bulk_prices', true ),
				'product' => get_post_meta( $product->get_id(), 'bm_' . $group->post_name . '_bulk_prices', true ),
			)
		);

		$listable_bulk_prices = array();

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
							if ( $product->get_parent_id() > 0 ) {
								if ( ! has_term( $category, 'product_cat', $product->get_parent_id() ) && ! BM_Price::product_in_descendant_category( $category, $product->get_parent_id() ) ) {
									continue;
								}
							} else {
								if ( ! has_term( $category, 'product_cat', $product->get_id() ) && ! BM_Price::product_in_descendant_category( $category, $product->get_id() ) ) {
									continue;
								}
							}
						}

						$bulk_price = floatval( $price_data['bulk_price'] );
						$from       = intval( $price_data['bulk_price_from'] );

						if ( $bulk_price > 0 ) {
							switch ( $type ) {
								case 'fix':
									$listable_bulk_prices[] = array( 'price' => $bulk_price, 'to' => $to, 'from' => $from );
									break;

								case 'discount':
									$bulk_price = $price - $bulk_price;

									if ( $bulk_price > 0 ) {
										$listable_bulk_prices[] = array( 'price' => $bulk_price, 'to' => $to, 'from' => $from );
									}
									break;

								case 'discount-percent':
									$bulk_price = $price - ( $bulk_price * $price / 100 );

									if ( $bulk_price > 0 ) {
										$listable_bulk_prices[] = array( 'price' => $bulk_price, 'to' => $to, 'from' => $from );
									}
									break;
							}
						}
					}
				}
			}
		}

		if ( empty( $listable_bulk_prices ) ) {
			return;
		}

		// Build the table.
		$columns     = array();
		$table_class = apply_filters( 'b2b_bulk_price_table_class', 'bm-bulk-table' );

		if ( isset( $atts['product-title'] ) ) {
			$columns['product_title'] = __( 'Product', 'b2b-market' );
		}
		$columns['bulk_price']    = __( 'Bulk Price', 'b2b-market' );
		$columns['quantity_from'] = __( 'Quantity (from)', 'b2b-market' );
		$columns['quantity_to']   = __( 'Quantity (to)', 'b2b-market' );

		if ( class_exists( 'WGM_Price_Per_Unit' ) ) {
			$ppu_data = WGM_Price_Per_Unit::get_price_per_unit_data( $product );

			if ( ! empty( $ppu_data ) ) {
				$columns['price_per_unit'] = __( 'Price Per Unit', 'woocommerce-german-market' );
			}
		}

		$columns = apply_filters( 'bm_bulk_price_table_columns', $columns );

		$shortcode  = '<table class="' . $table_class . '">';
		$shortcode .= '<thead>';
		$shortcode .= '<tr>';

		foreach ( $columns as $key => $value ) {
			$shortcode .= '<td>' . $value . '</td>';
		}
		$shortcode .= '</tr>';
		$shortcode .= '</thead>';
		$shortcode .= '<tbody>';

		foreach ( $listable_bulk_prices as $data ) {
			$price = BM_Tax::get_tax_price( $product, $data['price'] );
			$to    = $data['to'];

			if ( INF === $data['to'] ) {
				$to = '∞';
			}

			$shortcode .= '<tr>';
			$shortcode .= '<td>' . wc_price( $price ) . '</td>';
			$shortcode .= '<td>' . $data['from'] . '</td>';
			$shortcode .= '<td>' . $to . '</td>';

			if ( class_exists( 'WGM_Price_Per_Unit' ) ) {
				if ( $product->is_type( 'variation' ) ) {
					$product = wc_get_product( $product->get_parent_id() );
				}

				$use_weight = get_option( 'woocommerce_de_automatic_calculation_use_wc_weight', 'off' );

				if ( 'on' === $use_weight ) {
					$weight_quantity = wc_get_weight( $product->get_weight(), get_option( 'woocommerce_de_automatic_calculation_use_wc_weight_scale_unit', get_option( 'woocommerce_weight_unit', 'kg' ) ), get_option( 'woocommerce_weight_unit', 'kg' ) );
					$weight_unit     = get_option( 'woocommerce_de_automatic_calculation_use_wc_weight_scale_unit', get_option( 'woocommerce_weight_unit', 'kg' ) );
					$weight_mult     = get_option( 'woocommerce_de_automatic_calculation_use_wc_weight_mult', 1 );
					$price_per_unit  = WGM_Price_Per_Unit::automatic_calculation( $price, $weight_quantity, $weight_mult );
				}

				$ppu     = WGM_Price_Per_Unit::get_price_per_unit_data( $product );
				$ppu_qty = get_post_meta( $product->get_id(), '_auto_ppu_complete_product_quantity', true );

				if ( isset( $ppu['mult'] ) ) {
					$price_per_unit = WGM_Price_Per_Unit::automatic_calculation( $price, $ppu_qty, $ppu['mult'] );
				}

				if ( ! empty( $ppu ) ) {
					$ppu_string = wc_price( $price_per_unit ) . ' / ' . $ppu['mult'] . ' ' . $ppu['unit'];
					$shortcode .= '<td>' . $ppu_string . '</td>';
				}
			}
			$shortcode .= '</tr>';
		}

		$shortcode .= '</tbody>';
		$shortcode .= '</table>';

		return $shortcode;
	}


	/**
	 * Shortcode for group based content display
	 *
	 * @param array  $atts
	 * @param string $content
	 * @return void
	 */
	public function conditional_customer_group_output( $atts, $content = null ) {
		$current_group = get_post( BM_Conditionals::get_validated_customer_group() );
		$group         = $atts['group'];

		if ( strpos( $group, ',' ) ) {
			$groups = explode( ',', $group );

			if ( in_array( $current_group->post_name, $groups ) ) {
				return apply_filters( 'the_content', $content );
			}
		} else {
			if ( isset( $group ) ) {
				if ( $group === $current_group->post_name ) {
					return apply_filters( 'the_content', $content );	
				}
			}
		}
	}

	/**
	 * Show current customer group
	 *
	 * @param  array $atts list of arguments.
	 * @return string
	 */
	public function show_current_customer_group( $atts ) {
		$group_id = BM_Conditionals::get_validated_customer_group();

		if ( is_null( $group_id ) || empty( $group_id ) ) {
			return '';
		}

		$customer_group = get_post( $group_id );

		ob_start();
		?>
		<span class="bm-current-group"><?php echo esc_html( $customer_group->post_title ); ?></span>
		<?php
		return ob_get_clean();
	}
}

new BM_Shortcode();
