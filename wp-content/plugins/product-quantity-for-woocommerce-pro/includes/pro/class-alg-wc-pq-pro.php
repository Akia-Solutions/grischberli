<?php
/**
 * Product Quantity for WooCommerce - Pro Class
 *
 * @version 1.8.0
 * @since   1.8.0
 * @author  WPFactory
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! class_exists( 'Alg_WC_PQ_Pro' ) ) :

class Alg_WC_PQ_Pro {

	public $attribute_taxonomies = array();
	
	/**
	 * Constructor.
	 *
	 * @version 1.8.0
	 * @since   1.8.0
	 * @todo    [dev] maybe move here: `require_once( 'includes/settings/class-alg-wc-pq-metaboxes.php' );`
	 */
	function __construct() {
		add_filter( 'alg_wc_pq_settings',                            		array( $this, 'settings' ), 10, 3 );
		add_filter( 'alg_wc_pq_advertise',                            		array( $this, 'advertise' ), 10, 3 );
		
		add_filter( 'alg_wc_pq_quantity_step_per_product',           		array( $this, 'quantity_step_per_product' ) );
		add_filter( 'alg_wc_pq_quantity_step_per_product_value',     		array( $this, 'quantity_step_per_product_value' ), 10, 2 );
		
		add_filter( 'alg_wc_pq_quantity_step_per_product_cat',           	array( $this, 'quantity_step_per_product_cat' ) );
		add_filter( 'alg_wc_pq_quantity_step_per_product_cat_value',     	array( $this, 'quantity_step_per_product_cat_value' ), 10, 2 );
		
		add_filter( 'alg_wc_pq_per_item_quantity_per_product',       		array( $this, 'per_item_quantity_per_product' ), 10, 2 );
		add_filter( 'alg_wc_pq_per_item_quantity_per_product_value', 		array( $this, 'per_item_quantity_per_product_value' ), 10, 3 );
		
		add_filter( 'alg_wc_pq_per_item_cat_quantity_per_product',       	array( $this, 'per_item_quantity_per_category' ), 10, 2 );
		add_filter( 'alg_wc_pq_per_item_cat_quantity_per_product_value', 	array( $this, 'per_item_quantity_per_category_value' ), 10, 3 );
		
		add_filter( 'alg_wc_pq_per_item_attr_quantity_per_product',       	array( $this, 'per_item_quantity_per_attr' ), 10, 2 );
		add_filter( 'alg_wc_pq_per_item_attr_quantity_per_product_value', 	array( $this, 'per_item_quantity_per_attr_value' ), 10, 3 );
		
		add_filter( 'alg_wc_pq_per_item_quantity_per_product_value_allvar', array( $this, 'per_item_quantity_per_product_value_allvar' ), 10, 3 );
		
		add_filter( 'alg_wc_pq_per_item_default_quantity_per_product',       array( $this, 'per_item_default_quantity_per_product' ), 10, 1 );
		add_filter( 'alg_wc_pq_per_item_default_quantity_per_product_value', array( $this, 'per_item_default_quantity_per_product_value' ), 10, 2 );
		
		add_filter( 'alg_wc_pq_per_item_cat_default_quantity_per_product',       array( $this, 'per_item_cat_default_quantity_per_product' ), 10, 1 );
		add_filter( 'alg_wc_pq_per_item_cat_default_quantity_per_product_value', array( $this, 'per_item_cat_default_quantity_per_product_value' ), 10, 2 );
		
		add_filter( 'alg_wc_pq_exact_qty_per_product',               		array( $this, 'exact_qty_per_product' ), 10, 2 );
		add_filter( 'alg_wc_pq_exact_qty_per_product_value',         		array( $this, 'exact_qty_per_product_value' ), 10, 3 );
		
		add_filter( 'alg_wc_pq_exact_qty_per_product_value_allvar',         array( $this, 'exact_qty_per_product_value_allvar' ), 10, 3 );
		
		add_filter( 'alg_wc_pq_exact_qty_per_product_cat',               	array( $this, 'exact_qty_per_product_cat' ), 10, 2 );
		add_filter( 'alg_wc_pq_exact_qty_per_product_cat_value',         	array( $this, 'exact_qty_per_product_cat_value' ), 10, 3 );
		
		add_filter( 'alg_wc_pq_exact_qty_per_product_attr',               	array( $this, 'exact_qty_per_product_attr' ), 10, 2 );
		add_filter( 'alg_wc_pq_exact_qty_per_product_attr_value',         	array( $this, 'exact_qty_per_product_attr_value' ), 10, 3 );

		add_filter( 'alg_wc_pq_qty_dropdown_thousand_separator',         	array( $this, 'alg_wc_pq_qty_dropdown_thousand_separator' ), 10, 1 );
		
		add_filter( 'alg_wc_pq_check_user_role',    						array( $this, 'check_user_role' ), 10, 2 );
		
		$this->attribute_taxonomies = alg_wc_pq_wc_get_attribute_taxonomies();
	}
	
	/**
	 * check_user_role.
	 *
	 * @version 1.8.0
	 * @since   1.8.0
	 */
	function check_user_role( $value, $core ) {
		if ( ! isset( $core->user_role_check ) ) {
			
			$enable_exclude_role = get_option( 'alg_wc_pq_enable_exclude_role_specofic', 'no' );
			
			if($enable_exclude_role == 'no'){
				$required_user_roles = get_option( 'alg_wc_pq_required_user_roles', array() );
				if ( empty( $required_user_roles ) ) {
					$core->user_role_check = true;
				} else {
					if ( ! function_exists( 'wp_get_current_user' ) ) {
						require_once( ABSPATH . 'wp-includes/pluggable.php' );
						/*return true;*/
					}
					$user = wp_get_current_user();
					if ( ! isset( $user->roles ) || empty( $user->roles ) ) {
						$user->roles = array( 'guest' );
					}
					if ( ! is_array( $user->roles ) ) {
						$core->user_role_check = false;
					} else {
						if ( in_array( 'administrator', $required_user_roles ) ) {
							$required_user_roles[] = 'super_admin';
						}
						$intersect = array_intersect( $required_user_roles, $user->roles );
						$core->user_role_check = ( ! empty( $intersect ) );
					}
				}
			}else{
				$non_required_user_roles = get_option( 'alg_wc_pq_non_required_user_roles', array() );
				
				if ( empty( $non_required_user_roles ) ) {
					$core->user_role_check = true;
				} else {
					if ( ! function_exists( 'wp_get_current_user' ) ) {
						require_once( ABSPATH . 'wp-includes/pluggable.php' );
						/*return true;*/
					}
					$user = wp_get_current_user();
					if ( ! isset( $user->roles ) || empty( $user->roles ) ) {
						$user->roles = array( 'guest' );
					}

					if ( ! is_array( $user->roles ) ) {
						$core->user_role_check = false;
					} else {
						if ( in_array( 'administrator', $non_required_user_roles ) ) {
							$non_required_user_roles[] = 'super_admin';
						}
						$intersect = array_intersect( $non_required_user_roles, $user->roles );
						$core->user_role_check = ( empty( $intersect ) );
					}
				}
			}
		}

		return $core->user_role_check;
	}
	
	/**
	 * exact_qty_per_product_value.
	 *
	 * @version 1.8.0
	 * @since   1.8.0
	 */
	function exact_qty_per_product_value( $value, $product_id, $allowed_or_disallowed ) {
		return get_post_meta( $product_id, '_' . 'alg_wc_pq_exact_qty_' . $allowed_or_disallowed, true );
	}
	
	/**
	 * exact_qty_per_product_value_allvar.
	 *
	 * @version 1.8.0
	 * @since   1.8.0
	 */
	function exact_qty_per_product_value_allvar( $value, $product_id, $allowed_or_disallowed ) {
		return get_post_meta( $product_id, '_' . 'alg_wc_pq_exact_qty_' . $allowed_or_disallowed . '_variable_qty', true );
	}
	
	/**
	 * exact_qty_per_product_cat_value.
	 *
	 * @version 1.8.0
	 * @since   1.8.0
	 */
	function exact_qty_per_product_cat_value( $value, $product_id, $allowed_or_disallowed ) {
		$term_list = wp_get_post_terms($product_id,'product_cat',array('fields'=>'ids'));
		if(isset($term_list) && count($term_list) > 0)
		{
			foreach ($term_list as $term)
			{
				$t_id = $term;
				$term_meta = get_option( "taxonomy_product_cat_$t_id" );
				
				// $meta_key = 'alg_wc_pq_' . $min_or_max;
				$meta_key = 'alg_wc_pq_exact_qty_' . $allowed_or_disallowed . '_all_product';
				if (!empty($term_meta) && is_array($term_meta)) {
					$cat_quantity = $term_meta[$meta_key];
					if ($cat_quantity > 0)
					{
						return $cat_quantity;
					}
				}
			}
		}
		return;
	}
	
	/**
	 * exact_qty_per_product_attr_value.
	 *
	 * @version 1.8.0
	 * @since   1.8.0
	 */
	function exact_qty_per_product_attr_value( $value, $product_id, $allowed_or_disallowed ) {
		if( !empty( $this->attribute_taxonomies ) ){
				foreach( $this->attribute_taxonomies as $tax ) {
					$name = alg_pq_wc_attribute_taxonomy_name( $tax->attribute_name );
					$term_list = wp_get_post_terms( $product_id, $name, array('fields'=>'ids') );
					if(isset($term_list) && count($term_list) > 0)
					{
						foreach ($term_list as $term)
						{
							$t_id = $term;
							$term_meta = get_option( "taxonomy_product_attribute_item_$t_id" );
							
							// $meta_key = 'alg_wc_pq_' . $min_or_max;
							$meta_key = 'alg_wc_pq_exact_qty_' . $allowed_or_disallowed . '_all_product';
							if (!empty($term_meta) && is_array($term_meta)) {
								$cat_quantity = $term_meta[$meta_key];
								if ($cat_quantity > 0)
								{
									return $cat_quantity;
								}
							}
						}
					}
				}
		}
		return;
	}

	/**
	 * quantity_step_per_product_value.
	 *
	 * @version 1.8.0
	 * @since   1.8.0
	 */
	function quantity_step_per_product_value( $value, $product_id ) {
		$product = wc_get_product($product_id);
		if('yes' == get_post_meta( $product_id, '_' . 'alg_wc_pq_min_allow_selling_below_stock', true )){
			// $product = wc_get_product($product_id);
			$stock = $product->get_stock_quantity();
			$min = get_post_meta( $product_id, '_' . 'alg_wc_pq_min', true );
			if($product->managing_stock() && $stock < $min){
				return 1;
			}
		}
		$step = get_post_meta( $product_id, '_' . 'alg_wc_pq_step', true );
		if ( 'yes' === get_option( 'alg_wc_pq_step_per_item_quantity_per_product_less2x', 'no' ) ) {
			if($step > 0){
				$step = floatval($step);
				$doublestep = $step * 2;
				$stock = $product->get_stock_quantity();
				if(!empty($stock) && $stock < $doublestep){
					$step = $stock - $step;
				}
			}
		}

		if(empty($step)){
			return 0;
		}
		
		return $step;
	}
	
	/**
	 * quantity_step_per_product_cat_value.
	 *
	 * @version 4.5.19
	 * @since   1.8.0
	 */
	function quantity_step_per_product_cat_value( $value, $product_id ) {

		/*kousik: customization start bulk-materials*/
		/*
		$bm_term_list = wp_get_post_terms($product_id,'bulk-materials',array('fields'=>'ids'));
		if(isset($bm_term_list) && count($bm_term_list) > 0)
		{
			foreach ($bm_term_list as $bm_term)
			{
				$bm_t_id = $bm_term;
				$bm_term_meta = get_option( "taxonomy_bulk-materials_$bm_t_id" );
				if (!empty($bm_term_meta) && is_array($bm_term_meta)) {
					$bm_cat_quantity = $bm_term_meta['alg_wc_pq_step'];
					if ($bm_cat_quantity > 0)
					{
						return $bm_cat_quantity;
					}
				}
			}
		}
		*/
		/*kousik: customization end bulk-materials*/

		/*$term_list = wp_get_post_terms($product_id,'product_cat',array('fields'=>'ids'));*/
		$args = array();
		$args['taxonomy'] = 'product_cat';
		$args['fields'] = 'ids';
		$args['object_ids'] = array($product_id);
		$term_query = new WP_Term_Query();
		$term_list = $term_query->query( $args );
		if(isset($term_list) && count($term_list) > 0)
		{
			foreach ($term_list as $term)
			{
				$t_id = $term;
				$term_meta = get_option( "taxonomy_product_cat_$t_id" );
				if (!empty($term_meta) && is_array($term_meta)) {
					$cat_quantity = $term_meta['alg_wc_pq_step'];
					if ($cat_quantity > 0)
					{
						return $cat_quantity;
					}
				}
			}
		}
		return;
	}

	/**
	 * per_item_quantity_per_product_value.
	 *
	 * @version 1.8.0
	 * @since   1.8.0
	 */
	function per_item_quantity_per_product_value( $value, $product_id, $min_or_max ) {
		if($min_or_max == 'min'){
			if('yes' == get_post_meta( $product_id, '_' . 'alg_wc_pq_min_allow_selling_below_stock', true )){
				$product = wc_get_product($product_id);
				$stock = $product->get_stock_quantity();
				$min = get_post_meta( $product_id, '_' . 'alg_wc_pq_min', true );
				if($product->managing_stock() && $stock <= $min){
					// return 1;
					return (float) $stock;
				}
			}
		}
		return (float) get_post_meta( $product_id, '_' . 'alg_wc_pq_' . $min_or_max, true );
	}
	
	/**
	 * per_item_quantity_per_category_value.
	 *
	 * @version 1.8.0
	 * @since   1.8.0
	 */
	function per_item_quantity_per_category_value( $value, $product_id, $min_or_max ) {
		$term_list = wp_get_post_terms($product_id,'product_cat',array('fields'=>'ids'));
		if(isset($term_list) && count($term_list) > 0)
		{
			foreach ($term_list as $term)
			{
				$t_id = $term;
				$term_meta = get_option( "taxonomy_product_cat_$t_id" );
				
				// $meta_key = 'alg_wc_pq_' . $min_or_max;
				$meta_key = 'alg_wc_pq_' . $min_or_max . '_all_product';
				if (!empty($term_meta) && is_array($term_meta)) {
					$cat_quantity = $term_meta[$meta_key];
					if ($cat_quantity > 0)
					{
						return $cat_quantity;
					}
				}
			}
		}
		return;
	}

	/**
	 * per_item_quantity_per_attr_value.
	 *
	 * @version 1.8.0
	 * @since   1.8.0
	 */
	function per_item_quantity_per_attr_value( $value, $product_id, $min_or_max ) {
		$product = wc_get_product($product_id);
		if( $product->is_type( 'variable' ) ){
		   return $value;
		}
		if( !empty( $this->attribute_taxonomies ) ){
				foreach( $this->attribute_taxonomies as $tax ) {
					$name = alg_pq_wc_attribute_taxonomy_name( $tax->attribute_name );
					$term_list = wp_get_post_terms( $product_id, $name, array('fields'=>'ids') );
					if(isset($term_list) && count($term_list) > 0)
					{
						foreach ($term_list as $term)
						{
							$t_id = $term;
							$term_meta = get_option( "taxonomy_product_attribute_item_$t_id" );
							
							
							if($min_or_max == 'step'){
								$meta_key = 'alg_wc_pq_' . $min_or_max;
								if (!empty($term_meta) && is_array($term_meta)) {
									$attr_quantity = $term_meta[$meta_key];
									if ($attr_quantity > 0)
									{
										return $attr_quantity;
									}
								}
							}else{
								$meta_key = 'alg_wc_pq_' . $min_or_max . '_all_product';
								if (!empty($term_meta) && is_array($term_meta)) {
									$attr_quantity = $term_meta[$meta_key];
									if ($attr_quantity > 0)
									{
										return $attr_quantity;
									}
								}
							}
						}
					}
				}
		}
		return;
	}
	
	/**
	 * per_item_quantity_per_product_value_allvar.
	 *
	 * @version 1.8.0
	 * @since   1.8.0
	 */
	function per_item_quantity_per_product_value_allvar( $value, $product_id, $min_or_max ) {
		return (float) get_post_meta( $product_id, '_' . 'alg_wc_pq_' . $min_or_max . '_variable_qty', true );
	}
	
	/**
	 * per_item_default_quantity_per_product_value.
	 *
	 * @version 1.8.0
	 * @since   1.8.0
	 */
	function per_item_default_quantity_per_product_value( $value, $product_id ) {
		return get_post_meta( $product_id, '_' . 'alg_wc_pq_default', true );
	}
	
	/**
	 * per_item_cat_default_quantity_per_product_value.
	 *
	 * @version 1.8.0
	 * @since   1.8.0
	 */
	function per_item_cat_default_quantity_per_product_value( $value, $product_id ) {
		$term_list = wp_get_post_terms($product_id,'product_cat',array('fields'=>'ids'));
		if(isset($term_list) && count($term_list) > 0)
		{
			foreach ($term_list as $term)
			{
				$t_id = $term;
				$term_meta = get_option( "taxonomy_product_cat_$t_id" );
				if (!empty($term_meta) && is_array($term_meta)) {
					$cat_quantity = $term_meta['alg_wc_pq_default'];
					if ($cat_quantity > 0)
					{
						return $cat_quantity;
					}
				}
			}
		}
		return;
	}

	/**
	 * exact_qty_per_product.
	 *
	 * @version 1.8.0
	 * @since   1.8.0
	 */
	function exact_qty_per_product( $value, $allowed_or_disallowed ) {
		return get_option( 'alg_wc_pq_exact_qty_' . $allowed_or_disallowed . '_per_product_enabled', 'no' );
	}
	
	/**
	 * exact_qty_per_product_cat.
	 *
	 * @version 1.8.0
	 * @since   1.8.0
	 */
	function exact_qty_per_product_cat( $value, $allowed_or_disallowed ) {
		return get_option( 'alg_wc_pq_exact_qty_' . $allowed_or_disallowed . '_per_cat_item_quantity_per_product', 'no' );
	}
	
	/**
	 * exact_qty_per_product_attr.
	 *
	 * @version 1.8.0
	 * @since   1.8.0
	 */
	function exact_qty_per_product_attr( $value, $allowed_or_disallowed ) {
		return get_option( 'alg_wc_pq_exact_qty_' . $allowed_or_disallowed . '_per_attribute_item_quantity', 'no' );
	}
	
	/**
	 * alg_wc_pq_qty_dropdown_thousand_separator.
	 *
	 * @version 1.8.0
	 * @since   1.8.0
	 */
	function alg_wc_pq_qty_dropdown_thousand_separator( $value )
	{
		return get_option( 'alg_wc_pq_qty_dropdown_thousand_separator_enabled', 'no' );
	}

	/**
	 * per_item_quantity_per_product.
	 *
	 * @version 1.8.0
	 * @since   1.8.0
	 */
	function per_item_quantity_per_product( $value, $min_or_max ) {
		return get_option( 'alg_wc_pq_' . $min_or_max . '_per_item_quantity_per_product', 'no' );
	}
	
	/**
	 * per_item_quantity_per_category.
	 *
	 * @version 1.8.0
	 * @since   1.8.0
	 */
	function per_item_quantity_per_category( $value, $min_or_max ) {
		return get_option( 'alg_wc_pq_' . $min_or_max . '_per_cat_item_quantity_per_product', 'no' );
	}
	
	/**
	 * per_item_quantity_per_attr.
	 *
	 * @version 1.8.0
	 * @since   1.8.0
	 */
	function per_item_quantity_per_attr( $value, $min_or_max ) {
		return get_option( 'alg_wc_pq_' . $min_or_max . '_per_attribute_item_quantity', 'no' );
	}
	
	
	/**
	 * per_item_default_quantity_per_product.
	 *
	 * @version 1.8.0
	 * @since   1.8.0
	 */
	function per_item_default_quantity_per_product( $value ) {
		return get_option( 'alg_wc_pq_default_per_item_quantity_per_product', 'no' );
	}
	
	/**
	 * per_item_cat_default_quantity_per_product.
	 *
	 * @version 1.8.0
	 * @since   1.8.0
	 */
	function per_item_cat_default_quantity_per_product( $value ) {
		return get_option( 'alg_wc_pq_default_per_cat_item_quantity_per_product', 'no' );
	}

	/**
	 * quantity_step_per_product.
	 *
	 * @version 1.8.0
	 * @since   1.8.0
	 */
	function quantity_step_per_product( $value ) {
		return get_option( 'alg_wc_pq_step_per_product_enabled', 'no' );
	}
	
	/**
	 * quantity_step_per_product_cat.
	 *
	 * @version 1.8.0
	 * @since   1.8.0
	 */
	function quantity_step_per_product_cat( $value ) {
		return get_option( 'alg_wc_pq_step_per_cat_item_quantity_per_product', 'no' );
	}

	/**
	 * settings.
	 *
	 * @version 1.8.0
	 * @since   1.8.0
	 */
	function settings( $value, $type = '', $args = array() ) {
		return '';
	}
	
	/**
	 * advertise.
	 *
	 * @version 1.8.0
	 * @since   1.8.0
	 */
	function advertise( $value, $type = '', $args = array() ) {
		$return = '';
		$user_id = get_current_user_id();
		if($user_id > 0){
			$saveddatetime = get_user_meta($user_id, 'alg_wc_pq_closedate', true);
			if(!empty($saveddatetime)){
				$currentdatetime = time();
				$datediff = $currentdatetime - $saveddatetime;
				$days = round($datediff / (60 * 60 * 24));
				if($days >= 0 && $days <= 90){
					return $return;
				}
			}
		}
		return '<div class="alg_wc_pq_right_ad">
				<div class="alg_wc_pq-sidebar__section">
				<div class="alg_wc_pq_close">&times;</div>
				<p>Selling to customers from EU? Collect & Validate VAT using</p>
				<div class="alg_wc_pq_name_heading">
				<img class="alg_wc_pq_resize" src="https://wpfactory.com/wp-content/uploads/EU-VAT-for-WooCommerce-300x300.png">
				<h2>EU VAT Validator & Assistant for WooCommerce</h2>
				</div>
				<ul>
					<li>
						<strong>Check valid VAT numbers for business clients.</strong>
					</li>
					<li>
						<strong>Exempt VAT if number is valid, preserve in home country or any other country.</strong>
					</li>
					<li>
						<strong>Show/hide field based on country/user role.</strong>
					</li>
					<li><strong>WPML compatible.</strong></li>
					<li><strong>And much more!</strong></li>
				</ul>
				<p>Our AIO Quantity Plugin Pro users enjoy 20% discount on EU VAT Validator, Coupon applied automatically!</p>
				<p style="text-align:center">
				<a id="alg_wc_pq-premium-button" class="alg_wc_pq-button-upsell" href="https://wpfactory.com/item/eu-vat-for-woocommerce/?coupon=1ebeb9e1" target="_blank">Get EU VAT for WooCommerce</a>
				</p>
				<br>
			</div>
			</div>';
	}
	
	

}

endif;

return new Alg_WC_PQ_Pro();
