<?php
include '../../_include/lib_include.php';
include '../include/frame_a.php';

$cg_code = $siteoption['default_cs_code'];

$ca_num = $_GET['ca_num'];
if(empty($ca_num)) {
	$ca_num = 0;
	$ca_where = "";
} else {
	$ca_where = " and C.ca_num = '$ca_num'";
}
$tpl->assign('cg_code', $cg_code);
$tpl->assign('ca_num', $ca_num);
$tpl->createSubMenu('3101', $ca_num);
$tpl->define('content', "skin/teacher/$siteoption[skin_te]/list.html");




//CONCAT_WS
$qry = "select 
				B.*,
				(select GROUP_CONCAT(lt_name SEPARATOR '<>') from goods_lecture D, goods E where B.mb_num = D.mb_num and D.g_num = E.g_num and E.cg_code = '$cg_code') as lt_name
		from 
				goods_lecture A, member B, goods C 
		where 
				A.mb_num = B.mb_num and B.mt_code = 'T' and A.g_num = C.g_num and C.cg_code = '$cg_code' $ca_where group by A.mb_num";

$list_qry = "
		select 
				B.*,
				(select mb_picture from member_teacher E where E.mb_num = B.mb_num) as mb_picture,
				(select GROUP_CONCAT(lt_name SEPARATOR '<>') from goods_lecture D, goods E where B.mb_num = D.mb_num and D.g_num = E.g_num and E.cg_code = '$cg_code') as lt_name
		from 
				goods_lecture A, member B, goods C
		where 
				A.mb_num = B.mb_num and B.mt_code = 'T' and A.g_num = C.g_num and C.cg_code = '$cg_code' $ca_where 
				
		group by A.mb_num $limit";


$cnt_query = mysqli_query($CONN['rosemary'],$qry);
$cnt = mysqli_num_rows($cnt_query);
$replace_text = "<>";
$query_number	=	$cnt;
if ($query_number) {
	$list_query = mysqli_query($CONN['rosemary'],$list_qry);
	$list_loop = array();
	$list_number = 1;
	while($rs = mysqli_fetch_array($list_query)){
		$rs['number'] = $list_number;
		$lt_name_loop = array();
		$lt_nmae_array = explode("<>", $rs['lt_name']);
		$lt_name_cnt = count($lt_nmae_array);
		$rs['lt_name_cnt'] = $lt_name_cnt;
		
		for ($i=0;$i<$lt_name_cnt;$i++) {
			if ($i < 2) {	//리스트엔 과목을 2개밖에 안보여준다.
				if ($i < 1) {
					$br = "<br>";
				} else {
					$br = "";
				}
				$lt_name_loop[$i]['name'] = $lt_nmae_array[$i].$br; 
			}
		}			
		$rs['lt_name'] = $lt_name_loop;
		//$rs['lt_name'] = preg_replace("/$replace_text/", "<br>", $rs['lt_name']);

		$list_loop[] = $rs; 
		$list_number++;
	}
}
$list_page = go_page($query_number, $num_per_page, $num_per_block, $page, "./index.php?", $key, $searchword,$mode);
$tpl->assign('list_page', $list_page);
$tpl->assign('list_cnt', $cnt);
$tpl->assign('list', $list_loop);

$tpl->print_('frame');
?>