<?php
namespace YaySMTP;

use YaySMTP\Controller\GmailServiceVendController;
use YaySMTP\Controller\OutlookMsServicesController;
use YaySMTP\Controller\ZohoServiceVendController;
use YaySMTP\Helper\Utils;

defined('ABSPATH') || exit;

class PluginCore {
  protected static $instance = null;

  public static function getInstance() {
    if (null == self::$instance) {
      self::$instance = new self;
      self::$instance->doHooks();
    }
    return self::$instance;
  }

  private function doHooks() {
    $this->getProcessor();
    global $phpmailer;
    $phpmailer = new PhpMailerExtends();
    add_action('init', array($this, 'actionForSmtpsHasAuth'));
  }

  private function __construct() {}

  public function getProcessor() {
    add_action('phpmailer_init', array($this, 'doSmtperInit'));
    add_filter('wp_mail_from', array($this, 'getFromAddress'));
    add_filter('wp_mail_from_name', array($this, 'getFromName'));
  }

  public function actionForSmtpsHasAuth() {
    if (is_admin()) {
      $currentEmail = Utils::getCurrentMailer();
      if ($currentEmail === 'gmail') {
        $gmailService = new GmailServiceVendController();
        $gmailService->processAuthorizeServive();
      } elseif ($currentEmail === 'zoho') {
        $zohoService = new ZohoServiceVendController();
        $zohoService->processAuthorizeServive();
      } elseif ($currentEmail === 'outlookms') {
        $outlookmsService = new OutlookMsServicesController();
        $outlookmsService->processAuthorizeServive();
      }
    }

  }

  public function getDefaultMailFrom() {
    $sitename = \wp_parse_url(\network_home_url(), PHP_URL_HOST);
    if ('www.' === substr($sitename, 0, 4)) {
      $sitename = substr($sitename, 4);
    }

    $from_email = 'wordpress@' . $sitename;

    return $from_email;
  }

  public function getFromAddress($email) {
    $emailDefault = $this->getDefaultMailFrom();
    $fromEmail = Utils::getCurrentFromEmail();
    if (Utils::getForceFromEmail() == 1) {
      return $fromEmail;
    }
    if (!empty($emailDefault) && $email !== $emailDefault) {
      return $email;
    }

    return $fromEmail;
  }

  public function getFromName($name) {
    $nameDefault = 'WordPress';
    $forceFromName = Utils::getForceFromName();
    if ($forceFromName == 0 && $name !== $nameDefault) {
      return $name;
    }

    return Utils::getCurrentFromName();
  }

  public function doSmtperInit($obj) {
    $currentMailer = Utils::getCurrentMailer();

    $obj->Mailer = $currentMailer;

    $settings = Utils::getYaySmtpSetting();
    $smtpSettings = (!empty($settings) && !empty($settings['smtp'])) ? $settings['smtp'] : array();

    if ('smtp' == $currentMailer) {
      if (!empty($smtpSettings['host'])) {
        $obj->Host = $smtpSettings['host'];
      }

      if (!empty($smtpSettings['port'])) {
        $obj->Port = (int) $smtpSettings['port'];
      }

      if (!empty($smtpSettings['encryption'])) {
        $obj->SMTPSecure  = $smtpSettings['encryption'];
      }

      if (!empty($smtpSettings['auth']) && $smtpSettings['auth'] == 'yes') {
        $obj->SMTPAuth = true;

        if (!empty($smtpSettings['user'])) {
          $obj->Username = $smtpSettings['user'];
        }

        if (!empty($smtpSettings['pass'])) {
          $obj->Password = Utils::decrypt($smtpSettings['pass'], 'smtppass');
        }
      }

      // Set wp_mail_from && wp_mail_from_name - start
      $currentFromEmail = Utils::getCurrentFromEmail();
      $currentFromName = Utils::getCurrentFromName();
      $from_email = apply_filters('wp_mail_from', $currentFromEmail);
      $from_name = apply_filters('wp_mail_from_name', $currentFromName);
      if (Utils::getForceFromEmail() == 1) {
        $from_email = $currentFromEmail;
      }
      if (Utils::getForceFromName() == 1) {
        $from_name = $currentFromName;
      }

      $obj->setFrom($from_email, $from_name, false);
      // Set wp_mail_from && wp_mail_from_name - end

    } else {
      $obj->SMTPSecure  = '';
    }
  }
}
