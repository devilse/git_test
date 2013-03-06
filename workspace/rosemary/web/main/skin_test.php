<?php
include '../../_include/lib_include.php';
include '../include/frame_a.php';

$skin = $_GET['skin'];
$tpl->define('content', $skin);

$tpl->print_('frame');
?>