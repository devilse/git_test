<?php
include '../../_include/lib_include.php';
include '../include/frame_a.php';

$mb_num = $_GET['mb_num'];
if (!$mb_num) alertback("접근 할 수 없습니다.");
$cg_code = $siteoption['default_cs_code'];
$ca_num = $_GET['ca_num'];
if(empty($ca_num)) $ca_num = 0;
$tpl->assign('ca_num', $ca_num);
$tpl->createSubMenu('3101', $ca_num);
$tpl->define('content', "skin/teacher/$siteoption[skin_te]/view.html");


$qry = "select 
				A.*,B.*,
				(select GROUP_CONCAT(lt_name SEPARATOR '<>') from goods_lecture D, goods E where A.mb_num = D.mb_num and D.g_num = E.g_num and A.mb_num = '$mb_num' and E.cg_code = '$cg_code') as lt_name
		from 
				member A, member_teacher B 
		where 
				A.mb_num = '$mb_num' and A.mb_num = B.mb_num";



$query = mysqli_query($CONN['rosemary'],$qry);
$qry_nums = mysqli_num_rows($query);
if (!$qry_nums) {
	alertback("등록되지 않거나 존재하지 않는 교수 입니다.");
}

$rs = mysqli_fetch_array($query);

$lt_name_array = explode("<>",$rs['lt_name']);
$lt_name_loop = array();
$lt_name_array2 = array();
for ($i=0;$i<count($lt_name_array);$i++) {
	$lt_name_array2['lt_names'] = $lt_name_array[$i];
	$lt_name_loop[] = $lt_name_array2;
}




$tpl->assign('mb_name', $rs['mb_name']);						// 교수 이름
$tpl->assign('lt_name', $lt_name_loop);							// 담당 과목
$tpl->assign('mb_picture', $rs['mb_picture']);					// 사진	
$tpl->assign('mb_biography', $rs['mb_biography']);				// 약력
$tpl->assign('mb_education', $rs['mb_education']);				// 학력
$tpl->assign('mb_paper', $rs['mb_paper']);						// 논문이나 저서



$tpl->print_('frame');
?>