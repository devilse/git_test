<?php
include '../../_include/lib_include.php';
include '../include/frame_a.php';

$tpl->createSubMenu('8201');
$tpl->define('content', "skin/etc/$siteoption[skin_etc]/clause.html");

$tpl->print_('frame');
?>