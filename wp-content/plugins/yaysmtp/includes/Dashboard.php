<?php
namespace YaySMTP;

defined('ABSPATH') || exit;

class Dashboard {
  protected static $instance = null;

  public static function getInstance() {
    if (null == self::$instance) {
      self::$instance = new self;
      self::$instance->doHooks();
    }

    return self::$instance;
  }

  private function doHooks() {
    add_action('wp_dashboard_setup', array($this, 'init'));
  }

  private function __construct() {}

  public function init() {
    wp_add_dashboard_widget('yaysmtp_analytics_email', __('YaySMTP Stats', 'yay-smtp'), array($this, 'analyticsEmailWidget'), null, null, 'normal', 'high');
  }

  public function analyticsEmailWidget() {
    $pickerHtml = '<div class="filter-wrap"><div class="dashicons filter-icon"></div><input id="yaysmtp_daterangepicker" type="text" value=""/></div>';
    echo $pickerHtml;
    echo '<div class="yaysmtp-chart-wrap"><canvas id="yaysmtpCharts" width="400" height="400"></canvas></div>';
  }
}
