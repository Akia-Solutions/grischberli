<?php



class VC_WDO_Tabs {


    /**
     * Get things started
     */
    function __construct() {

        add_action('init', array($this, 'wdo_tabs_parent'));
        add_action('init', array($this, 'wdo_tabs_child'));
        add_shortcode('wdo_advance_tabs_free', array($this, 'wdo_advance_tabs_rendering'));
        add_shortcode('wdo_advance_tab_free', array($this, 'wdo_advance_tab_rendering'));
        add_action( 'init', array( $this, 'check_if_vc_is_install' ) );

        define( 'TABS_URL', plugins_url('/', __FILE__ ) );
    }

    function wdo_tabs_parent() {
        if (function_exists("vc_map")) {

    	    vc_map(array(
    	        "name" => __("Advance Tabs - Free", "wdo-tabs"),
    	        "base" => "wdo_advance_tabs_free",
    	        "as_parent" => array('only' => 'wdo_advance_tab_free'),
    	        'category' => 'Advance Tabs',
    	        "js_view" => 'VcColumnView',
                "content_element" => true,
                "show_settings_on_create" => true,
                "is_container" => true,
                "icon" => TABS_URL.'admin/tabs-icon.png',
                'admin_enqueue_css' => array( plugins_url( '/admin/css/style.css' , __FILE__ ) ),
    	        "params" => array(

                	array(
                		'type'			=> 'dropdown',
                		'admin_label'	=> true,
                		'heading'		=> esc_html__('Tabs Style (More in Pro Version)', 'wdo-tabs'),
                		'param_name'	=> 'wdo_tabs_style',
                		'value' => array(
                			'Select Style' => '',
                			'Style1' => 'style1',
                			'Style2' => 'style2',
                			'Style3' => 'style3',
                            'Style4 (PRO)' => '',
                            'Style5 (PRO)' => '',
                            'Style6 (PRO)' => '',
                            'Style7 (PRO)' => '',
                            'Style8 (PRO)' => '',
                		)
                	),

                    array(
                        'type'          => 'dropdown',
                        'admin_label'   => true,
                        'heading'       => esc_html__('Tabs Type (PRO Feature)', 'wdo-tabs'),
                        'param_name'    => 'wdo_tabs_type',
                        'value' => array(
                            'Select Type' => '',
                            'Vertical' => 'vertical',
                            'Horizontal' => 'horizantal',
                        )
                    ),

                	

                	array(
                		'type'			=> 'dropdown',
                		'admin_label'	=> true,
                		'heading'		=> esc_html__('Color Scheme (More in Pro Version)', 'wdo-tabs'),
                		'param_name'	=> 'wdo_color_scheme',
                		'group' => esc_html__('Color Scheme','wdo-tabs'),
                		'value' => array(
                			'Select Color Scheme' => '',
                			'Blue' => 'blue',
                			'Green' => 'green',
                			'MidNight Blue' => 'midnightblue',
                			'Orange' => 'orange',
                            'Pumpkin (PRO)' => 'blue',
                            'Red (PRO)' => 'blue',
                            'Sky Blue (PRO)' => 'blue',
                            'Turqoise (PRO)' => 'blue',
                            'Voilet (PRO)' => 'blue',
                            'Amethyst (PRO)' => 'blue',
                		)
                	),

                    /* PRO Features */
                    array(
                        "type" => "html",
                        "heading" => "  <h3 style='padding: 10px;background: #2b4b80;color: #fff;'>Special Limited time Offer: 50% Discount</h3>
                                        <h3><a target='_blank' href='https://webdevocean.com/product/tabs-vc-addon/' > Get Pro Version </a></h3>",
                        "param_name" => "pro_feature",
                        'group' => esc_html__('Get Pro Version','wdo-tabs'),
                    ),
                    
                   
    			)
    	    ));


        }
    }

    function wdo_tabs_child() {
        if (function_exists("vc_map")) {


	        vc_map(array(
	            "name" => __("Advance Tab", "wdo-tabs"),
	            "base" => "wdo_advance_tab_free",
	            "as_child" => array('only' => 'wdo_advance_tabs_free'),
	            'as_parent'			=> array(''),
	            'allowed_container_element' => 'vc_row',
				'js_view'					=> 'VcColumnView',
	            "icon" => 'extended-custom-icon-wdo icon-wpb-advanced-tab',
	            'params' => array_merge(
					array(
						array(
							'type' => 'textfield',
							"holder" => "div",
							'admin_label' => true,
							'heading' => esc_html__('Tab Title', "wdo-tabs"),
							'param_name' => 'wdo_tab_title',
							"description" => "Will be displayed as the name of tab.",
						),
					)
				)
	        ));


        }
    }

    function wdo_advance_tabs_rendering($atts, $content = null, $tag) {
    	wp_enqueue_style( 'wdo-tabs-bootstrap', plugins_url( '/assests/bootstrap.min.css' , __FILE__ ));
    	wp_enqueue_style( 'wdo-tabs-css', plugins_url( '/assests/tabs.css' , __FILE__ ));
        wp_enqueue_style( 'wdo-colors-css', plugins_url( '/assests/colors.css' , __FILE__ ));
    	wp_enqueue_script( 'wdo-bootstrap-js', plugins_url( '/assests/bootstrap.min.js', __FILE__ ),array('jquery'));
    	wp_enqueue_script( 'wdo-custom-js', plugins_url( '/assests/script.js', __FILE__ ),array('jquery','wdo-bootstrap-js'));

        $args = array(
        	'wdo_title_tag' => '',
            'wdo_tabs_style' => 'style1',
            'wdo_color_scheme' => 'blue',
        );

        $params  = shortcode_atts($args, $atts);

        extract($params);

        // Extract tab titles
        preg_match_all('/wdo_tab_title="([^\"]+)"/i', $content, $matches, PREG_OFFSET_CAPTURE);
        $tab_titles = array();

        /**
         * get tab titles array
         *
         */
        if (isset($matches[0])) {
        	$tab_titles = $matches[0]; 
        }

        $tab_title_array = array();

        foreach($tab_titles as $tab) {
        	preg_match('/wdo_tab_title="([^\"]+)"/i', $tab[0], $tab_matches, PREG_OFFSET_CAPTURE);
        	$tab_title_array[] = $tab_matches[1][0];
        }

        $params['wdo_tabs_titles'] = $tab_title_array;
        $params['content'] = $content;

        $tabs_color_scheme = $params['wdo_color_scheme'];
        $color_scheme_path =  'assests/colors/'.$tabs_color_scheme.'.css';

        ob_start();

        ?>
        <div class="<?php echo $tabs_color_scheme; ?>">
        	<div class="tc-tabs-<?php echo $params['wdo_tabs_style']; ?> row wdo-tabs-container">
                <ul class="nav nav-tabs">
                    <?php foreach ($tab_title_array as $tab_title): ?>
                    	<li>
                    		<a data-toggle="tab" href="#tab-<?php echo sanitize_title($tab_title)?>"><?php echo $tab_title; ?></a>
                    	</li>
                    <?php endforeach ?>
                </ul>
                <div class="tab-content">
                	<?php do_shortcode( $content ); ?>
                </div>                			
        	</div>
        </div>
        <?php

        $output = ob_get_clean();

        return $output;
    }

    function wdo_advance_tab_rendering($atts, $content = null, $tag) {
        extract(shortcode_atts(array(

        ), $atts));

        $default_atts = array(
        	'wdo_tab_title' => 'Tab',
        	'tab_id' => ''
        );

        $params = shortcode_atts($default_atts, $atts);
        extract($params);

        $rand_number = rand(0, 1000);
        $params['wdo_tab_title'] = $params['wdo_tab_title'].'-'.$rand_number;

        $params['content'] = $content;
        ?>
     	
     	    <div id="tab-<?php echo sanitize_title($params['wdo_tab_title']); ?>" class="tab-pane fade">
     	    	<?php echo do_shortcode($content); ?>
     	    </div>

        <?php
    }

    function check_if_vc_is_install(){
        if ( ! defined( 'WPB_VC_VERSION' ) ) {
            // Display notice that Visual Compser is required
            add_action('admin_notices', array( $this, 'showVcVersionNotice' ));
            return;
        }
    }

    function showVcVersionNotice() {
        $plugin_name = 'Advance Tabs for Visual Composer';
        echo '
        <div class="updated">
          <p>'.sprintf(__('<strong>%s</strong> requires <strong><a href="http://codecanyon.net/item/visual-composer-page-builder-for-wordpress/242431?ref=labibahmed" target="_blank">Visual Composer</a></strong> plugin to be installed and activated on your site.', 'ich-vc'), $plugin_name).'</p>
        </div>';
    }

}

//Your "container" content element should extend WPBakeryShortCodesContainer class to inherit all required functionality
if (class_exists('WPBakeryShortCodesContainer')) {
    class WPBakeryShortCode_wdo_advance_tabs_free extends WPBakeryShortCodesContainer {
    }
}
if (class_exists('WPBakeryShortCodesContainer')) {
    class WPBakeryShortCode_wdo_advance_tab_free extends WPBakeryShortCodesContainer {
    }
}