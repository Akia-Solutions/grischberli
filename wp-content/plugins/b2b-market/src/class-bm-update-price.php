<?php

class BM_Update_Price {
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
	 * Maybe enqueue assets
	 *
	 * @return void
	 */
	public static function load_assets() {

		if ( ! is_singular( 'product' ) ) {
			// no scripts to add.
			return;
		}

		$product  = wc_get_product( get_the_id() );
		$group_id = BM_Conditionals::get_validated_customer_group();

		if ( ! isset( $group_id ) || empty( $group_id ) ) {
			// no scripts to add.
			return;
		}

		// now adding script and localize.
		$min = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : 'min.';

		wp_enqueue_script( 'bm-update-price-js', B2B_PLUGIN_URL . '/assets/public/bm-update-price.' . $min . 'js', array( 'jquery' ), '1.0.8.2', false );
		wp_localize_script( 'bm-update-price-js', 'bm_update_price', array( 'ajax_url' => admin_url( 'admin-ajax.php' ), 'nonce' => wp_create_nonce( 'update-price-nonce' ) ) );
	}

	/**
	 * Add hidden id for js live price
	 *
	 * @return void
	 */
	public static function add_hidden_id_field() {
		?>
		<span id="current_id" style="visibility:hidden;" data-id="<?php echo esc_attr( get_the_id() ); ?>"></span>
		<?php
	}

	/**
	 * Live update price with ajax
	 *
	 * @return void
	 */
	public static function update_price() {
		// if id or qty missing return false.
		$response = array( 'sucess' => false );
		$nonce    = sanitize_text_field( $_POST['nonce'] );

		if ( ! wp_verify_nonce( $nonce, 'update-price-nonce' ) ) {
			die();
		}

		if ( ! isset( $_POST['id'] ) || empty( $_POST['id'] ) ) {
			print wp_json_encode( $response );
			exit;
		}

		if ( ! isset( $_POST['qty'] ) || empty( $_POST['qty'] ) ) {
			print wp_json_encode( $response );
			exit;
		}

		// setup escaped postdata.
		$product_id = esc_attr( $_POST['id'] );
		$qty        = esc_attr( $_POST['qty'] );

		// setup handling data.
		$product     = wc_get_product( $product_id );
		$group_id    = BM_Conditionals::get_validated_customer_group();
		$customer_id = get_option( 'bm_customer_group' );
		$guest_id    = get_option( 'bm_guest_group' );

		if ( $product->is_type( 'bundle' ) ) {
			exit;
		}

		// if customer_group missing return false.
		if ( ! isset( $group_id ) || empty( $group_id ) ) {
			print wp_json_encode( $response );
			exit;
		}

		$product_price = $product->get_regular_price();

		if ( $product->get_sale_price() > 0 ) {
			$product_price = $product->get_sale_price();
		}

		// get pricing data.
		$cheapest_price = BM_Price::get_price( $product_price, $product, $group_id, $qty );
		$cheapest_price = BM_Tax::get_tax_price( $product, $cheapest_price );

		// JSON response preparation.
		$response = array(
			'sucess'      => true,
			'id'          => $product_id,
			'price'       => wc_price( $cheapest_price ),
			'price_value' => $cheapest_price,
		);

		// WGM PPU compatibility.
		if ( class_exists( 'WGM_Price_Per_Unit' ) ) {
			$price_per_unit = 0;

			if ( $product->is_type( 'variation' ) ) {
				$variation_mult = get_post_meta( $product->get_id(), '_v_unit_regular_price_per_unit_mult', true );
				$variation_qty  = get_post_meta( $product->get_id(), '_v_auto_ppu_complete_product_quantity', true );
				$var_ppu_set    = get_post_meta( $product->get_id(), '_v_used_setting_ppu', true );

				if ( 1 == $var_ppu_set ) {
					$price_per_unit = WGM_Price_Per_Unit::automatic_calculation( $cheapest_price, $variation_qty, $variation_mult );
				} else {
					$parent_product = wc_get_product( $product->get_parent_id() );
					$ppu            = WGM_Price_Per_Unit::get_price_per_unit_data( $parent_product );

					if ( isset( $ppu['mult'] ) ) {
						$qty            = get_post_meta( $product->get_parent_id(), '_auto_ppu_complete_product_quantity', true );
						$price_per_unit = WGM_Price_Per_Unit::automatic_calculation( $cheapest_price, $qty, $ppu['mult'] );
					}
				}
			} else {
				$ppu = WGM_Price_Per_Unit::get_price_per_unit_data( $product );

				if ( isset( $ppu['mult'] ) ) {
					$qty            = get_post_meta( $product->get_id(), '_auto_ppu_complete_product_quantity', true );
					$price_per_unit = WGM_Price_Per_Unit::automatic_calculation( $cheapest_price, $qty, $ppu['mult'] );
				}
			}
			if ( $price_per_unit > 0 ) {
				$response['ppu'] = wc_price( $price_per_unit );
			}
		}

		print wp_json_encode( $response );
		exit;
	}
}
