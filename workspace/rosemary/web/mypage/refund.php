<?php
include '../../_include/lib_include.php';

// 로그인 체크
$User_Info =  Login_Chk($_COOKIE['LIPASS_ID']);
$mb_type = $User_Info['type'];
$mb_num = $User_Info['member_num'];
if (!$mb_type || $mb_type == "G") {
	alertclose("로그인이 필요 합니다.");
}
$page = $_GET['page'];
$os_num = $_GET['os_num'];
if (!$os_num) {
	alertclose("접근할 수 없습니다.");
}

$tpl->auth_block("S");
$tpl->createSubMenu('7811');
$tpl->define('content', "skin/member/$siteoption[skin_member]/POP_Refund.html");


// 해당 상품이 자신의 상품이 맞는지 체크한다.

$goods_query = "select * from ordersheet where os_num = '$os_num' and mb_num = '$mb_num'";
$cnt_query = mysqli_query($CONN['rosemary'],$goods_query);
$tot_cnt = mysqli_num_rows($cnt_query);

if (!$tot_cnt) {
	alertclose("등록된 내역이 아닙니다.");
}


$list_qry = "
			select 
					A.os_amt,
					A.os_type,
					(select rf_state from refund B where A.os_num = B.os_num) as rf_state,
					(select CONCAT_WS('<>',B.gp_num,C.gp_name) from ordersheet_package B, goods_package C where A.os_num = B.os_num and B.gp_num = C.gp_num) as package,
					(select GROUP_CONCAT(CONCAT_WS('<>',B.bo_num,C.bo_name) SEPARATOR '||') from ordersheet_book B, book C where A.os_num = B.os_num and B.bo_num = C.bo_num) as book,
					(select GROUP_CONCAT(CONCAT_WS('<>',C.lt_num,D.lt_name) SEPARATOR '||') from ordersheet_goods B, ordersheet_goods_lecture C, goods_lecture D where A.os_num = B.os_num and B.g_num = C.g_num and B.os_num = C.os_num and C.lt_num = D.lt_num) as goods					
			from 
					ordersheet A
			where 
					A.mb_num = '$mb_num' and A.os_num = '$os_num'
			";

$list_query = mysqli_query($CONN['rosemary'],$list_qry);

$rs = mysqli_fetch_array($list_query);

if ($rs['os_type'] == "C") {
	$rs['os_type'] = "카드 결제";
} else if ($rs['os_type'] == "V") {
	$rs['os_type'] = "가상결제";
} else {
	$rs['os_type'] = "무통장 입금";
}

$goods_cnt = 0;

if (!empty($rs['package'])) {
	$goods_array = explode("<>",$rs['package']);
	$goods_cnt = 1;

	$goods_loop = array();
	$goods_loop_array = array();

	for($i=0;$i<$goods_cnt;$i++){
	//	$goods_loop_array[$i]['g_num'] = $goods_array[0];
		$goods_loop_array[$i]['name'] = $goods_array[1];
		$goods_loop[] = $goods_loop_array[$i];		
	}


} else if(!empty($rs['goods'])) {
	$goods_array = explode("||",$rs['goods']);
	$goods_cnt = count($goods_array);
	$goods_loop = array();
	$goods_loop_array = array();
	for($i=0;$i<$goods_cnt;$i++){
		$goods_array2 = explode("<>",$goods_array[$i]);
	//	$goods_loop_array[$i]['g_num'] = $goods_array2[0];
		$goods_loop_array[$i]['name'] = $goods_array2[1];
		$goods_loop[] = $goods_loop_array[$i];		
	}



}



if (!empty($rs['book'])) {
	$book_array = explode("||",$rs['book']);
	$book_cnt = count($book_array);
	$book_loop = array();
	$book_loop_array = array();
	for($i=0;$i<$book_cnt;$i++){
		$book_array2 = explode("<>",$book_array[$i]);
		$book_loop_array[$i]['bo_num'] = $book_array2[0];
		$book_loop_array[$i]['bo_name'] = $book_array2[1];
		$book_loop[] = $book_loop_array[$i];		
	}
}

$tpl->assign('goods_cnt', $goods_cnt);
$tpl->assign('goods_list', $goods_loop);

$tpl->assign('book_cnt', $book_cnt);
$tpl->assign('book_list', $book_loop);

$tpl->assign('os_amt', number_format($rs['os_amt']));
$tpl->assign('os_type', $rs['os_type']);
$tpl->assign('os_num', $os_num);
$tpl->assign('page', $page);



$tpl->print_('content');
?>