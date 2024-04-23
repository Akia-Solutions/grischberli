<?php


namespace hcbrwpb\integrations;

new Salient();

/**
 * Class Salient
 *
 * fixes for Salient Theme
 *
 * @package hcbrwpb\integrations
 */
class Salient {

	public function __construct() {

		add_action('admin_footer', array($this, 'add_js'), 999);

	}

	/**
	 * add labels back which are removed by salient theme
	 */
	function add_js(){
		?>
		<style>
			*[data-vc-shortcode-param-name=hcbrwpb_visible_for_roles] .nectar-cb-enabled {
				display:flex;
				align-items:center;
				margin-bottom:8px;
			}
			.hcbrwpb-checkbox-label {
				margin-left:40px;
				font-weight:bold;
			}
		</style>
		<script>
			<?php
			$roles = \HCBRWPB_Utils::get_roles();
			$sorted_roles = array();
			foreach ($roles as $role_label => $role_key){
				$sorted_roles[$role_key] = $role_label;
			}
			echo 'hcbrwpb_roles = '.json_encode($sorted_roles).';'.PHP_EOL;
			?>
			jQuery(document).ready(function($) {

			    console.log('Hide Content by User Role for WPBakery // Init Salient Fix');
				// On modal open.
				$("#vc_ui-panel-edit-element").on('vcPanel.shown',function() {

	                $("[data-vc-shortcode-param-name=hcbrwpb_visible_for_roles] .nectar-cb-enabled .switch-options").each(function(){

	                   var value = $(this).find('input').val();
	                   label = hcbrwpb_roles[value];
	                   $(this).after( '<span class="hcbrwpb-checkbox-label">'+label+'</span>' );
	                });
	            });
			});
		</script>

		<?php
	}

}


