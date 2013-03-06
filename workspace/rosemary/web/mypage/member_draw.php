<?php
include '../../_include/lib_include.php';
include '../include/frame_a.php';


// 로그인 체크
$User_Info =  Login_Chk($_COOKIE['LIPASS_ID']);
$mb_type = $User_Info['type'];
$mb_id = $User_Info['id'];
$tpl->assign('mb_id', $User_Info['id']);
if (!$mb_type || $mb_type == "G") {
	alertback("로그인이 필요 합니다.");
}

$tpl->auth_block("S");

$tpl->createSubMenu('7811');
$tpl->define('content', "skin/member/$siteoption[skin_member]/member_draw.html");

$tpl->print_('frame');
?>