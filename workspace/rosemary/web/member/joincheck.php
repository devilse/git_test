<?php
include '../../_include/lib_include.php';
include '../include/frame_a.php';
include '../../_lib/email.php';

$tpl->auth_block("G");

// 이전 URL을 확인하여 정해진 URL에서 온 것이 아니면 join.php로 이동시킵니다.
check_http_referer("/member/join.php", "../member/join.php");

$tpl->createSubMenu('9201');
$tpl->define('content', "skin/member/$siteoption[skin_member]/joincheck.html");

// 이메일 호스트
$tpl->assign('email_host', $email_host);

$tpl->print_('frame');
?>