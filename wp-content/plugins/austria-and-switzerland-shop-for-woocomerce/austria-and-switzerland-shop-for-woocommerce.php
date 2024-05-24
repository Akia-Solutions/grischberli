<?php
/**
 * Plugin Name: Austria and Switzerland shop for woocommerce
 * Description: add Austria and Switzerland VAT and shipping to the Woocommerce shop.
 * Version: 1.1.0
 * Author: Web Bakery
 *
 * Minimum PHP: 8.0.13
 * Minimum WP: 3.6
 *
 * @author      Web Bakery
 * @copyright   Copyright (c) 2021, Web Bakery LLC.
 */

if (!defined('ABSPATH')) {
    exit;
}

class dev_wc_shop
{
    private static $_instance = null;

    public static function instance()
    {
        if (is_null(self::$_instance)) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    public function __construct()
    {

        add_filter('woocommerce_package_rates', array($this, 'custom_shipping_cost'), 10, 2);
        add_filter('woocommerce_loop_add_to_cart_link', array($this, 'add_data_quantity_value'), 10, 2);
        add_action('wp_enqueue_scripts', array($this, 'custom_enqueue_scripts'), 999);
        add_filter('woocommerce_locate_template', array($this, 'custom_modify_wc_templates'), 20, 2);
        add_action('woocommerce_form_field', array($this, 'custom_woocommerce_form_field'), 999);
        add_action('um_custom_field_validation_country_ust_id', array($this, 'um_custom_validate_country_ust_id'), 30, 3);
        add_action('wp_enqueue_scripts', array($this, 'custom_vat_id_scripts'), 999);
    }

    public function custom_shipping_cost($rates, $package)
    {
        $country = $package['destination']['country'];
        $item_count = intval(WC()->cart->get_cart_item_quantities());
        $base_cost = 0;

        $user_id = get_current_user_id();
        $user_data = get_userdata($user_id);
        $at_cost = 8.30;
        $ch_cost = 12;
        if ($user_data) {
            $user_role = $user_data->roles[0];
        }
        if ((!is_user_logged_in() || $user_role == 'customer')) {
            $base_cost = 6.79;
        }

        if ($country == 'AT' || $country == 'Austria') {
            foreach ($rates as $rate_key => $rate) {
                if (($rate->method_id == 'flat_rate')) {
                    if ($item_count <= 14) {
                        $at_cost = 8.3;
                    } elseif ($item_count > 14 && $item_count <= 24) {
                        $at_cost = 9.45;
                    } elseif ($item_count > 24 && $item_count <= 40) {
                        $at_cost = 10.8;
                    } elseif ($item_count > 40 && $item_count <= 60) {
                        $at_cost = 14.8;
                    } elseif ($item_count > 60 && $item_count <= 80) {
                        $at_cost = 21.6;
                    } elseif ($item_count > 80) {
                        $count = ($item_count - 80) / 40;
                        if ($count >= 1) {
                            $at_cost = (ceil($count) * 10.8) + 21.6;
                        } else {
                            $at_cost = 21.6;
                        }
                    }
                    $rate->cost = ($item_count * $at_cost) + $base_cost;
                }
            }
        } elseif ($country == 'CH' || $country == 'Switzerland') {
            foreach ($rates as $rate_key => $rate) {
                if (($rate->method_id == 'flat_rate')) {
                    if ($item_count <= 18) {
                        $ch_cost = 12;
                    } elseif ($item_count > 18 && $item_count <= 30) {
                        $ch_cost = 13.6;
                    } elseif ($item_count > 30 && $item_count <= 40) {
                        $ch_cost = 15.4;
                    } elseif ($item_count > 40 && $item_count <= 60) {
                        $ch_cost = 19.4;
                    } elseif ($item_count > 60 && $item_count <= 80) {
                        $ch_cost = 30.8;
                    } elseif ($item_count > 80) {
                        $count = ($item_count - 80) / 40;
                        if ($count >= 1) {
                            $ch_cost = (ceil($count) * 15.4) + 30.8;
                        } else {
                            $ch_cost = 30.8;
                        }
                    }
                    $rate->cost = ($item_count * $ch_cost) + $base_cost;
                }
            }
        }

        return $rates;
    }

    function custom_woocommerce_form_field( $field )
    {
        $field = str_replace('country_select', '', $field);
        $field = str_replace('state_select', '', $field);

        echo $field;
    }

    public function add_data_quantity_value($html, $product)
    {
        $html .= wc_enqueue_js('
		jQuery(function($) {
		let button = $("button[data-product_id=' . $product->get_id() . ']");
        button.attr("data-quantity", button[0].parentNode[0].value);
		});
		');
        return $html;
    }

    public function custom_enqueue_scripts()
    {
        wp_deregister_script('wc-cart');
        wp_register_script('wc-cart', plugin_dir_url(__FILE__) . 'assets/js/cart.js', array('jquery'), '1.0', true);
        wp_enqueue_script('cart');
    }

    public function custom_modify_wc_templates($template, $template_name)
    {
        global $woocommerce;
        $_template = $template;
        $template_path = $woocommerce->template_url;

        $plugin_path = untrailingslashit(plugin_dir_path(__FILE__)) . '/woocommerce/templates/';
        $template = locate_template(
            array(
                $template_path . $template_name,
                $template_name
            )
        );

        if (!$template && file_exists($plugin_path . $template_name))
            $template = $plugin_path . $template_name;

        if (!$template)
            $template = $_template;

        return $template;
    }

    public function um_custom_validate_country_ust_id( $key, $array, $args )
    {
        if ( isset( $args['country'] ) && !strstr( $args['country'], 'DE' ) ) {
            if ( isset( $args['ust_id'] ) && empty( $args['ust_id']) ) {
                UM()->form()->add_error('ust_id', 'Für Nutzer außerhalb Deutschlands ist die Angabe der Umsatzsteuer-ID erforderlich.');
            }
        }
    }

    public function custom_vat_id_scripts()
    {
        $src = wc_enqueue_js('
		jQuery(function($) {
        const req = \'<span class="um-req" title="Required"> * </span>\';
        const label = $("div[data-key=\'ust_id\']")[0].firstElementChild.firstElementChild;
        let country = $("#country").find(":selected").val();
        const reqHTML = label.innerHTML + req;
        const unReqHTML = label.innerHTML;
        console.log(label, country);

        if (country != "DE") {
            label.innerHTML = reqHTML;
        }else {
            label.innerHTML = unReqHTML;
        }

        if (country == "") {
            $("select option[value=\'DE\']").attr("selected", "selected");
            label.innerHTML = unReqHTML;
            console.log("country and label set");
        }

        if (label != "undefined") {
            $("#country").on("click", function() {
                country = $("#country").find(":selected").val();
                if (country != "DE") {
                    label.innerHTML = reqHTML;
                    console.log("req");
                    console.log(label, country);
                }else {
                    label.innerHTML = unReqHTML;
                    console.log("unreq");
                    console.log(label, country);
                }
            });
        }
    });
    ');
        return $src;
    }
}


function dev_wc_shop_run()
{
    return dev_wc_shop::instance();
}

if (!function_exists('dev_is_woocommerce_active')) {
    function dev_is_woocommerce_active()
    {
        $active_plugins = (array)get_option('active_plugins', array());

        if (is_multisite()) {
            $active_plugins = array_merge($active_plugins, get_site_option('active_sitewide_plugins', array()));
        }

        return in_array('woocommerce/woocommerce.php', $active_plugins) || array_key_exists('woocommerce/woocommerce.php', $active_plugins);
    }
}

/*
 * Initialize
 */
if (dev_is_woocommerce_active()) {

    dev_wc_shop_run();

}