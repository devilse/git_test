<?php
include '../../_include/lib_include.php';
include '../include/frame_a.php';

$tpl->auth_block("G");
check_http_referer("/member/process/confirm_email.php", "../main/index.php");

$mb_num = $_GET['mcd'];
$mb_id = mysqli_scalar("SELECT mb_id FROM member WHERE mb_num = '$mb_num'");
$tpl->assign('mb_id', $mb_id);

$tpl->createSubMenu('9201');
$tpl->define('content', "skin/member/$siteoption[skin_member]/joinconfirm.html");

$tpl->print_('frame');
?>