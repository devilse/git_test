<?php
include '../../_include/lib_include.php';
include '../include/frame_a.php';

$tpl->createSubMenu('9301');
$tpl->define('content', "skin/member/$siteoption[skin_member]/idpw.html");

$tpl->print_('frame');
?>