<?php
include '../../_include/lib_include.php';
include '../include/frame_a.php';

$tpl->createSubMenu('8401');
$tpl->define('content', "skin/etc/$siteoption[skin_etc]/sitemap.html");

$tpl->print_('frame');
?>