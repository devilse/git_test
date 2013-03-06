<?php
include '../../_include/lib_include.php';
include '../include/frame_a.php';

// 로그인 체크
$User_Info =  Login_Chk($_COOKIE['LIPASS_ID']);
$mb_type = $User_Info['type'];
$mb_id = $User_Info['id'];
$mb_num = $User_Info['member_num'];
$tpl->assign('mb_id', $User_Info['id']);
if (!$mb_type || $mb_type == "G") {
	alertback("로그인이 필요 합니다.");
}

$tpl->auth_block("S");
$tpl->createSubMenu('7411');
$tpl->define('content', "skin/member/$siteoption[skin_member]/my_pay.html");



$cnt_qry = "
			select 
					*
			from 
					ordersheet 
			where 
					mb_num = '$mb_num'
			";


$list_qry = "
			select 
					*,
					(select rf_state from refund B where A.os_num = B.os_num) as rf_state,
					(select CONCAT_WS('<>',B.gp_num,C.gp_name) from ordersheet_package B, goods_package C where A.os_num = B.os_num and B.gp_num = C.gp_num) as package,
					(select GROUP_CONCAT(CONCAT_WS('<>',B.bo_num,C.bo_name) SEPARATOR '||') from ordersheet_book B, book C where A.os_num = B.os_num and B.bo_num = C.bo_num) as book,
					(select GROUP_CONCAT(CONCAT_WS('<>',C.lt_num,D.lt_name) SEPARATOR '||') from ordersheet_goods B, ordersheet_goods_lecture C, goods_lecture D where A.os_num = B.os_num and B.g_num = C.g_num and B.os_num = C.os_num and C.lt_num = D.lt_num) as goods					
			from 
					ordersheet A
			where 
					A.mb_num = '$mb_num'
			order by os_regdate desc $limit
			";


$cnt_query = mysqli_query($CONN['rosemary'],$cnt_qry);
$tot_cnt = mysqli_num_rows($cnt_query);



if ($tot_cnt > 0) {
	$list_query = mysqli_query($CONN['rosemary'],$list_qry);
	$list_loop = array();
	$book_number = 1;
	while ($rs = mysqli_fetch_array($list_query)) {
		
		$os_num = $rs['os_num'];
		if ($rs['os_state'] == "A") {								// 입금대기중
			$os_state = "<img src='http://".$MY_URL."_template/skin/member/$siteoption[skin_member]/images/mypage/btn_oc.gif'/>";
			$os_text = "입금대기";
		} else if($rs['os_state'] == "B") {							// 입금완료	
			$os_state = "<a href=\"javascript:refund_go('$os_num','$page')\"><img src='".$MY_URL."_template/skin/member/$siteoption[skin_member]/images/mypage/btn_rf.gif'/></a>";
			$os_text = "입금완료";
		} else {													// 환불
			$os_state = "환불";
			$os_text = "환불";
		}

		if ($rs['rf_state'] == "A") {
			$os_state = "접수중";
		} else if ($rs['rf_state'] == "B") {
			$os_state = "접수완료";
		} else if ($rs['rf_state'] == "C") {
			$os_state = "환불처리중";
		} else if ($rs['rf_state'] == "D") {
			$os_state = "환불완료";
		} 

		$rs['os_amt'] = number_format($rs['os_amt']);
		$rs['os_text'] = $os_text;
		$rs['os_state'] = $os_state;
		$rs['os_regdate'] = date("Y-m-d",$rs['os_regdate']);

		if (!empty($rs['package'])) {
			$package_array = explode("<>",$rs['package']);
			$rs['my_goods'] = $package_array[1];
		} else if(!empty($rs['goods'])) {
			$goods_array = explode("||",$rs['goods']);
			$goods_cnt = count($goods_array);
			$rs['goods_cnt'] = $goods_cnt - 1;
			$goods_name_array = explode("<>",$goods_array[0]);
			$rs['my_goods'] = $goods_name_array[1];
		}

		if (!empty($rs['book'])) {
			$book_array = explode("||",$rs['book']);
			$book_cnt = count($book_array);
			$rs['book_cnt'] = $book_cnt;
		}

		$list_loop[] = $rs;
	}
}
$list_page = go_page($tot_cnt, $num_per_page, $num_per_block, $page, "./my_pay.php?", $key, $searchword,$mode);

$tpl->assign('list_page', $list_page);
$tpl->assign('tot_cnt', $tot_cnt);
$tpl->assign('list', $list_loop);







$tpl->print_('frame');
?>