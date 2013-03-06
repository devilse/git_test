<?php
include '../../_include/lib_include.php';
include '../include/frame_a.php';

$cid = $_GET['cid'];
$tpl->define('content', "content/$cid.html");
$tpl->createSubMenu_cid($cid);

$tpl->print_('frame');
?>