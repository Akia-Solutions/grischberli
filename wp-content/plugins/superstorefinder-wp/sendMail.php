<?php
include("ssf-wp-inc/includes/ssf-wp-env.php");
$name=$_POST['name'];
$phone=$_POST['phone'];
$email=$_POST['email'];
$message=$_POST['message'];
$name_lbl  = (isset($_POST['name_lbl']) && !empty($_POST['name_lbl'])) ? $_POST['name_lbl'] : 'Name';
$email_lbl = (isset($_POST['email_lbl']) && !empty($_POST['email_lbl'])) ? $_POST['email_lbl'] : 'Email';
$msg_lbl   = (isset($_POST['msg_lbl']) && !empty($_POST['msg_lbl'])) ? $_POST['msg_lbl'] : 'Message';
$phone_lbl = (isset($_POST['phone_lbl']) && !empty($_POST['phone_lbl'])) ? $_POST['phone_lbl'] : 'Phone';

$to = $_POST['rcvEmail'];
$subject = $_POST['subject']. ' enquiry';
$body = $name_lbl.': '.$name.'<br/>';
$body .= $email_lbl.': '.$email.'<br/>';
if(!empty($phone)){
	$body .= $phone_lbl.': '.$phone.'<br/>';
}
$body .= $msg_lbl.': '.$message.'<br/>';
$headers[] = 'Content-Type: text/html; charset=UTF-8';
$headers[]   = 'Reply-To: '.$name.' <'.$email.'>';
wp_mail( $to, $subject, $body, $headers );
?>