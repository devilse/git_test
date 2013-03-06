<?php
include '../../_include/lib_include.php';
include '../include/frame_a.php';
include '../../_lib/tel.php';

$tpl->auth_block("G");

// 이전 URL을 확인하여 정해진 URL에서 온 것이 아니면 join.php로 이동시킵니다.
check_http_referer("/member/joincheck.php", "../member/join.php");

$tpl->createSubMenu('9201');
$tpl->define('content', "skin/member/$siteoption[skin_member]/joincon.html");

$email1 = trim($_POST["email1"]);
$email2 = trim($_POST["email2"]);

$tpl->assign('email1', $email1);
$tpl->assign('email2', $email2);
$tpl->assign('hp_host', $hp_host);
$tpl->assign('tel_host', $tel_host);

$tpl->print_('frame');
?>
