<?php

/**
 * Class to handle admin orders with B2B Market
 */
class BM_Admin_Orders {

	/**
	 * Contains instance or null
	 *
	 * @var object|null
	 */
	private static $instance = null;

	/**
	 * Returns instance of BM_Admin_Orders.
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
	 * Constructor for BM_Admin_Orders.
	 */
	public function __construct() {
		add_action( 'woocommerce_before_order_object_save', array( $this, 'apply_cheapest_price_to_items' ), 10, 2 );
	}

	/**
	 * Applies the cheapest price to items from order.
	 *
	 * @param object $order current post  object.
	 * @param array  $data_store object with the current store abstraction.
	 * @return void
	 */
	public function apply_cheapest_price_to_items( $order, $data_store ) {

		if ( ! current_user_can( 'manage_woocommerce' ) ) {
			return;
		}

		if ( ! is_admin() ) {
			return;
		}

		$group_id = self::get_customer_group_by_id( $order->get_user_id() );
		$tax_type = get_post_meta( $group_id, 'bm_tax_type', true );

		foreach ( $order->get_items() as $item_id => $item ) {
			$product        = wc_get_product( $item->get_product_id() );
			$cheapest_price = BM_Price::get_price( $product->get_price(), $product, $group_id, $item->get_quantity() );
			$cheapest_price = wc_get_price_excluding_tax( $product, array( 'price' => $cheapest_price ) );

			if ( $item->get_total() > 0 ) {
				$item->set_subtotal( $cheapest_price * $item->get_quantity() );
				$item->set_total( $cheapest_price * $item->get_quantity() );
			}

			$item->save();
		}
	}

	/**
	 * Get customer group by user id.
	 *
	 * @param  int $user_id given user id.
	 * @return int
	 */
	public static function get_customer_group_by_id( $user_id ) {
		$current_user = get_user_by( 'id', $user_id );

		if ( ! empty( $current_user->roles ) ) {
			foreach ( $current_user->roles as $slug ) {
				$group = get_page_by_path( $slug, OBJECT, 'customer_groups' );

				if ( ! is_null( $group ) ) {
					return $group->ID;
				}
			}
		}
	}
}
