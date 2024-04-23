<?php
namespace Brightplugins_COS;

class Email {

	public function __construct() {
		add_action( 'woocommerce_order_status_changed', [$this, 'status_changed'], 10, 3 );
		add_filter( 'woocommerce_email_classes', [$this, 'order_status_emails'] );
	}

	/**
	 * @param $order_id
	 * @param $old_status
	 * @param $new_status
	 */
	public function status_changed( $order_id, $old_status, $new_status ) {
        $wc_emails = WC()->mailer()->get_emails();
		if( isset( $wc_emails['bvos_custom_' . $new_status] ) ){
			$wc_emails['bvos_custom_' . $new_status]->trigger( $order_id );
		}
	}

	/**
	 * @param $emails
	 * @return mixed
	 */
	public function order_status_emails( $emails ) {

		include_once BVOS_PLUGIN_DIR . '/src/emails/class-wcbv-order-status-email.php';

		$arg = array(
			'numberposts' => -1,
			'post_type'   => 'order_status',
			'meta_query'  => [[
				'key'     => '_enable_email',
				'compare' => '=',
				'value'   => '1',
			]],
		); 
		$postStatusList = get_posts( $arg );

		foreach ( $postStatusList as $post ) {

			$status_index = $statusSlug = get_post_meta( $post->ID, 'status_slug', true ); 

			$emails['bvos_custom_' . $status_index] = new WCBV_Order_Status_Email(
				'bvos_custom_' . $status_index, array(
					'post_id'     => $post->ID,
					'title'       => $post->post_title,
					'description' => $post->post_excerpt,
					'type'        => get_post_meta( $post->ID, '_email_type', true ),
				)
			);

		}
		return $emails;

	}

}
