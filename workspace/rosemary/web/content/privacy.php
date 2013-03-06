<?php
include '../../_include/lib_include.php';
include '../include/frame_a.php';

$tpl->createSubMenu('8301');
$tpl->define('content', "skin/etc/$siteoption[skin_etc]/privacy.html");

$tpl->print_('frame');
?>