<?php
namespace YaySMTP;

defined('ABSPATH') || exit;

use YaySMTP\Helper\Utils;

class Schedule {
  protected static $instance = null;

  public static function getInstance() {
    if (null == self::$instance) {
      self::$instance = new self;
      self::$instance->doHooks();
    }

    return self::$instance;
  }

  private function doHooks() {
    add_filter('cron_schedules', array($this, 'yaysmtp_datetime_custom_cron_schedule'), 5, 1);
    add_action('yaysmtp_delete_email_log_schedule_hook', array($this, 'delete_email_log_schedule'));

    if (!wp_next_scheduled('yaysmtp_delete_email_log_schedule_hook')) {
      wp_schedule_event(time(), 'yaysmtp_specific_delete_time', 'yaysmtp_delete_email_log_schedule_hook');
    }
  }

  private function __construct() {}

  public function yaysmtp_datetime_custom_cron_schedule($schedules) {
    $emailLogSetting = Utils::getYaySmtpEmailLogSetting();
    $deleteDatetimeSetting = isset($emailLogSetting) && isset($emailLogSetting['email_log_delete_time']) ? (int) $emailLogSetting['email_log_delete_time'] : 60;
    $disPlayText = 'Every ' . $deleteDatetimeSetting . ' days';
    $schedules['yaysmtp_specific_delete_time'] = array(
      'interval' => 86400 * $deleteDatetimeSetting, // Every 6 hours
      'display' => __($disPlayText),
    );
    return $schedules;
  }

  public function delete_email_log_schedule() {
    global $wpdb;
    $wpdb->query($wpdb->prepare('DELETE FROM ' . $wpdb->prefix . 'yaysmtp_email_logs'));
  }

}
