<?php
/**
 * Proceed to checkout button
 *
 * Contains the markup for the proceed to checkout button on the cart.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/proceed-to-checkout-button.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 2.4.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
?>



<a href="<?php echo esc_url( wc_get_checkout_url() ); ?>" class="checkout-button button alt wc-forward">
	<?php esc_html_e( 'Proceed to checkout', 'woocommerce' ); ?>
</a>
<script src="https://unpkg.com/sweetalert2@7.20.1/dist/sweetalert2.all.js"></script>
<script type="text/javascript">
    jQuery( function($) {
        if ( typeof wc_add_to_cart_params === 'undefined' )
            return false;

        $(document.body).on( 'click', '.checkout-button', function() {
            const qty = () => {
                <?php
                $qty=0;
                foreach (WC()->cart->get_cart_item_quantities() as $cart_item_quantity) {
                    $qty+=$cart_item_quantity;
                }
                ?>
                return <?= $qty ?>
            }

            var even = qty % 2;
            const toast = swal.mixin({
                toast: false,
                showConfirmButton: true,
            });
            if (even != 0) {
                event.preventDefault();
                toast({
                    type: 'warning',
                    title: "<?php esc_html_e('Quantity warning', 'woocommerce'); ?>",
                    text: "<?php esc_html_e('The total quantity of selected products must be an even number.', 'woocommerce'); ?>",
                })
            }
        });
    })
</script>