<?php
include '../../_include/lib_include.php';


$ca_num = $_GET['ca_num'];
if(empty($ca_num)) $ca_num = 0;
$tpl->createSubMenu('1201', $ca_num);
if (!$category_skin[$ca_num]) {
	$category_skin[$ca_num] = "basic";
}
$tpl->define('content', "skin/ls/$category_skin[$ca_num]/book_info_list.html");


$tpl->print_('content');
?>