<?php
include '../../_include/lib_include.php';
include '../include/frame_a.php';
include '../../_lib/email.php';

$tpl->auth_block("G");
check_http_referer("/member/joincon.php|/member/process/login.php", "../main/index.php");
if(empty($_COOKIE['EMAIL_CONFIRM'])) {
	header("Location:../main/index.php");
	exit;
}

$mb_num = $_COOKIE['EMAIL_CONFIRM'];
$member_query = "SELECT * FROM member a INNER JOIN member_student b ON a.mb_num = b.mb_num WHERE a.mb_num = '$mb_num'";
$member_query_result = mysqli_query($CONN['rosemary'], $member_query);

if(mysqli_num_rows($member_query_result) == 0) {
	header("Location:../main/index.php");
	exit;
}

$member_rs = mysqli_fetch_array($member_query_result);

if($member_rs['ms_email_confirm_yn'] == "Y") {
	header("Location:../main/index.php");
	exit;
}

$email_array = explode('@', $member_rs['mb_email']);

$email1 = $email_array[0];
$email2 = $email_array[1];

$tpl->assign('email1', $email1);
$tpl->assign('email2', $email2);
$tpl->assign('mb_num', $mb_num);

$tpl->createSubMenu('9201');
$tpl->define('content', "skin/member/$siteoption[skin_member]/joinend.html");

// 이메일 호스트
$tpl->assign('email_host', $email_host);

$tpl->print_('frame');
?>