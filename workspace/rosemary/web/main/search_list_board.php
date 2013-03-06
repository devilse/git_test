<?php
include '../../_include/lib_include.php';
include '../include/frame_b.php';

$cg_code = $siteoption['default_cs_code'];
if (!$cg_code) {
	$cg_code = "001";
}

$tpl->define('content', "skin/cs/".$cs_skin_array[$tpl->cs]."/search_list_board.html");

$search_text = urlencode($_GET['top_search']);
$tpl->assign('search_text', $search_text);


// 게시물 가져오기 - 게시판 (자료실 제외)

$bbs_qry = "select count(*) as cnt from board_list A, board B where A.bo_num = B.bo_num and A.del_chk = 'N' and A.title like '%$search_text%' and B.bo_state not in('D','CD') and A.cg_code = '$cg_code'";
$bbs_list_qry = "select 
						A.*,
						B.bo_name,B.bo_num
				 from 
						board_list A, board B
				 where 
						A.bo_num = B.bo_num and
						A.del_chk = 'N' and
						A.title like '%$search_text%' and
						B.bo_state not in('D','CD') and
						A.cg_code = '$cg_code'

						$limit;
				 ";

$bbs_cnt_query = mysqli_query($CONN['rosemary'],$bbs_qry);
$bbs_cnt = mysqli_result($bbs_cnt_query,0,0);


if ($bbs_cnt) {
	$bbs_query = mysqli_query($CONN['rosemary'],$bbs_list_qry);
	$bbs_list_loop = array();
	while($bbs_rs = mysqli_fetch_array($bbs_query)){
		$bbs_rs['title'] = stripslashes($bbs_rs['title']);
		$bbs_rs['title'] = preg_replace("/$search_text/", "<span>".$search_text."</span>", $bbs_rs['title']);
		$bbs_rs['reg_date'] = date("Y-m-d H:i:s",$bbs_rs['reg_date']);
		$bbs_list_loop[] = $bbs_rs; 
	}
}

$list_page = go_page($bbs_cnt, $num_per_page, $num_per_block, $page, "./search_list_board.php?top_search=$search_text&", $key, $searchword,$mode);



$tpl->assign('list_page', $list_page);
$tpl->assign('bbs_cnt', $bbs_cnt);
$tpl->assign('bbs_list', $bbs_list_loop);



$tpl->print_('frame');
?>