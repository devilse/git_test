<?php
include '../../_include/lib_include.php';
include '../include/frame_a.php';

$tpl->auth_block("G");

$tpl->createSubMenu('9201');
$tpl->define('content', "skin/member/$siteoption[skin_member]/join.html");

// 이용약관
$site_clause = mysqli_scalar("SELECT sc_content FROM site_clause WHERE sc_sdate <= UNIX_TIMESTAMP() ORDER BY sc_sdate DESC LIMIT 0, 1");
if(empty($site_clause)) $site_clause = '관리자 > 사이트관리 > 이용약관 메뉴에서 이용약관을 입력해주세요.';
$tpl->assign('clause', stripslashes($site_clause));

// 개인정보 수집 및 이용에 대한 안내
$site_privacy = mysqli_scalar("SELECT sp_content FROM site_privacy WHERE sp_sdate <= UNIX_TIMESTAMP() ORDER BY sp_sdate DESC LIMIT 0, 1");
if(empty($site_privacy)) $site_privacy = '관리자 > 사이트관리 > 개인정보보호정책 메뉴에서 개인정보보호정책을 입력해주세요.';
$tpl->assign('privacy', stripslashes($site_privacy));

$tpl->print_('frame');
?>