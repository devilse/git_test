<?php
include '../../_include/lib_include.php';
include '../include/frame_a.php';

$tpl->auth_block("G");

$tpl->createSubMenu('9101');
$tpl->define('content', "skin/member/$siteoption[skin_member]/login.html");

$return_uri = $_GET['prev'];
$tpl->assign('return_uri', $return_uri);

$tpl->assign('save_id', $_COOKIE['save_id']);

$tpl->print_('frame');
?>