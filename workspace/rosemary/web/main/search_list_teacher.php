<?php
include '../../_include/lib_include.php';
include '../include/frame_b.php';

$cg_code = $siteoption['default_cs_code'];
if (!$cg_code) {
	$cg_code = "001";
}

$tpl->define('content', "skin/cs/".$cs_skin_array[$tpl->cs]."/search_list_teacher.html");

$search_text = $_GET['top_search'];
$tpl->assign('search_text', $search_text);


// 교수 정보가져오기


$te_qry = "select 
				B.*,
				(select mb_picture from member_teacher E where E.mb_num = B.mb_num) as mb_picture,
				A.lt_name
		from 
				goods_lecture A, member B, goods C 
		where 
				A.mb_num = B.mb_num and B.mt_code = 'T' and A.g_num = C.g_num and C.cg_code = '$cg_code' and (B.mb_name like '%$search_text%' or A.lt_name like '%$search_text%') ";

$te_query = mysqli_query($CONN['rosemary'],$te_qry);
$te_cnt = mysqli_num_rows($te_query);
if ($te_cnt) {
	$te_list_loop = array();
	$replace_text = "<>"; 
	while($te_rs = mysqli_fetch_array($te_query)){
		//$te_rs['lt_name'] = preg_replace("/$replace_text/", "<br>", $te_rs['lt_name']);
		$te_rs['lt_name'] = preg_replace("/$search_text/", "<span>".$search_text."</span>", $te_rs['lt_name']);
		$te_list_loop[] = $te_rs; 
	}
}


$list_page = go_page($te_cnt, $num_per_page, $num_per_block, $page, "./search_list_teacher.php?top_search=$search_text&", $key, $searchword,$mode);

$tpl->assign('list_page', $list_page);
$tpl->assign('te_cnt', $te_cnt);
$tpl->assign('te_list', $te_list_loop);
$tpl->print_('frame');
?>