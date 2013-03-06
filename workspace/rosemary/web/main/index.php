<?php
include '../../_include/lib_include.php';
include '../include/frame_b.php';

$tpl->define('content', "skin/cs/".$cs_skin_array[$tpl->cs]."/main.html");

$tpl->print_('frame');
?>