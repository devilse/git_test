<?php
include '../../_include/lib_include.php';
include '../include/frame_b.php';

$cg_code = $siteoption['default_cs_code'];
if (!$cg_code) {
	$cg_code = "001";
}

$tpl->define('content', "skin/cs/".$cs_skin_array[$tpl->cs]."/search_list_board2.html");
$search_text = $_GET['top_search'];
$tpl->assign('search_text', $search_text);


// 자료실 가져오기 - 게시판
$bbs_qry2 = "select count(*) as cnt from board_list A, board B where A.bo_num = B.bo_num and A.del_chk = 'N' and A.title like '%$search_text%' and B.bo_state in('D','CD') and A.cg_code = '$cg_code'";
$bbs_list_qry2 = "select 
						A.*,
						B.bo_name,B.bo_num
				 from 
						board_list A, board B
				 where 
						A.bo_num = B.bo_num and
						A.del_chk = 'N' and
						A.title like '%$search_text%' and
						B.bo_state in('D','CD') and 
						A.cg_code = '$cg_code'

						limit 4;
				 ";

$bbs_cnt_query2 = mysqli_query($CONN['rosemary'],$bbs_qry2);
$bbs_cnt2 = mysqli_result($bbs_cnt_query2,0,0);


if ($bbs_cnt2) {
	$bbs_query2 = mysqli_query($CONN['rosemary'],$bbs_list_qry2);
	$bbs_list_loop2 = array();
	while($bbs_rs2 = mysqli_fetch_array($bbs_query2)){
		$bbs_rs2['title'] = stripslashes($bbs_rs2['title']);
		$bbs_rs2['title'] = preg_replace("/$search_text/", "<span>".$search_text."</span>", $bbs_rs2['title']);
		$bbs_rs2['reg_date'] = date("Y-m-d H:i:s",$bbs_rs2['reg_date']);
		$bbs_list_loop2[] = $bbs_rs2; 
	}
}


$list_page = go_page($bbs_cnt2, $num_per_page, $num_per_block, $page, "./search_list_board2.php?top_search=$search_text&", $key, $searchword,$mode);



$tpl->assign('list_page', $list_page);

$tpl->assign('bbs_cnt2', $bbs_cnt2);
$tpl->assign('bbs_list2', $bbs_list_loop2);




$tpl->print_('frame');
?>