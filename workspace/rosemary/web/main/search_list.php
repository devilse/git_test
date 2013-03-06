<?php
include '../../_include/lib_include.php';
include '../include/frame_b.php';

$cg_code = $siteoption['default_cs_code'];
if (!$cg_code) {
	$cg_code = "001";
}

$tpl->define('content', "skin/cs/".$cs_skin_array[$tpl->cs]."/search_list.html");

$search_text = $_GET['top_search'];
$tpl->assign('search_text', $search_text);
// 상품(동영상강의) 가져오기

$goods_qry = "select count(*) as cnt from goods where cg_code = '$cg_code' and g_state = 'S' and g_name like '%$search_text%'";
$goods_list_qry = "
					select 
							A.*,
							(select B.ca_tree from category B where B.ca_num = A.ca_num) as ca_tree,
							(select sum(lt_selling_price) as price from goods_lecture B where B.g_num = A.g_num) as price,
							(select cg_name from category_group B where A.cg_code = B.cg_code) as cg_name,
							(select sum(lt_term) as term from goods_lecture B where B.g_num = A.g_num ) as lt_term,
							(select sum(
								(select sum(
									(select count(ltsp_num) from goods_lecture_subjects_period D where D.lts_num = C.lts_num)
								) from goods_lecture_subjects C where C.lt_num = B.lt_num )	
							) from goods_lecture B where B.g_num = A.g_num ) as period_cnt
					from 
						goods A
					where
						A.cg_code = '$cg_code' and
						A.g_state = 'S'	and
						A.g_name like '%$search_text%'
						order by A.g_num desc $limit
						";

$goods_cnt_query = mysqli_query($CONN['rosemary'],$goods_qry);
$goods_cnt = mysqli_result($goods_cnt_query,0,0);

$query_number	=	$goods_cnt;
if ($query_number) {
	$goods_query = mysqli_query($CONN['rosemary'],$goods_list_qry);
	$list_loop = array();
	while($goods_rs = mysqli_fetch_array($goods_query)){
		$goods_rs['number_format_price'] = number_format($goods_rs['price']);													// 정가
		$goods_rs['h_price'] =  @round($goods_rs['price'] - ($goods_rs['price'] * ($goods_rs['g_discount_rate'] / 100)),0);		// 판매가 - 할인된 금액
		$goods_rs['number_format_h_price'] = number_format($goods_rs['h_price']);												// 리스트 노출 판매가
		$list_loop[] = $goods_rs; 
	}
}
//$list_page = go_page($query_number, $num_per_page, $num_per_block, $page, "./search_index.php?", $key, $searchword,$mode);

$tpl->assign('list_cnt', $query_number);
$tpl->assign('list', $list_loop);
//$tpl->assign('list_page', $list_page);

// 자격증 정보 가져오기
// 학위정보 가져오기
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

						limit 4;
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


$tpl->assign('bbs_cnt', $bbs_cnt);
$tpl->assign('bbs_list', $bbs_list_loop);

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


$tpl->assign('bbs_cnt2', $bbs_cnt2);
$tpl->assign('bbs_list2', $bbs_list_loop2);
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

$tpl->assign('te_cnt', $te_cnt);
$tpl->assign('te_list', $te_list_loop);



$tpl->print_('frame');
?>