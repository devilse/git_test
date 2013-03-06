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
$tpl->define('content', "skin/member/$siteoption[skin_member]/my_pay_info.html");

$page = $_GET['page'];
$os_num = $_GET['os_num'];


// 해당 상품이 자신의 상품이 맞는지 체크한다.

$goods_query = "select * from ordersheet where os_num = '$os_num' and mb_num = '$mb_num'";
$cnt_query = mysqli_query($CONN['rosemary'],$goods_query);
$tot_cnt = mysqli_num_rows($cnt_query);

if (!$tot_cnt) {
	alertback("등록된 내역이 아닙니다.");
}



$list_qry = "
			select 
					A.os_amt,
					A.os_type,
					H.*,
					(select rf_state from refund B where A.os_num = B.os_num) as rf_state,
					(select GROUP_CONCAT(CONCAT_WS('<>',B.gp_num,C.gp_name,
						(select	
								sum((select sum(E.lt_selling_price) - truncate(((sum(E.lt_selling_price) * (F.g_discount_rate / 100) )),0)  from goods_lecture E, goods F  where E.g_num = D.g_num and D.g_num = F.g_num))
						 from 
								goods_package_goods D 
						 where 
								C.gp_num = D.gp_num)				
					
					) SEPARATOR '||') from ordersheet_package B, goods_package C where A.os_num = B.os_num and B.gp_num = C.gp_num) as package,
					(select GROUP_CONCAT(CONCAT_WS('<>',B.bo_num,C.bo_name,bo_selling_price) SEPARATOR '||') from ordersheet_book B, book C where A.os_num = B.os_num and B.bo_num = C.bo_num) as book,
					(select GROUP_CONCAT(CONCAT_WS('<>',C.g_num,D.lt_name,D.lt_selling_price,E.g_discount_rate) SEPARATOR '||') from ordersheet_goods B, ordersheet_goods_lecture C, goods_lecture D, goods E where A.os_num = B.os_num and B.g_num = C.g_num and B.os_num = C.os_num and C.lt_num = D.lt_num and D.g_num = E.g_num) as goods					

			from 
					ordersheet A, ordersheet_delivery_info H
			where 
					A.mb_num = '$mb_num' and A.os_num = '$os_num' and A.os_num = H.os_num
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
	$goods_type = "pack";

	$goods_tot_price = 0;	
	$goods_loop = array();
	$goods_loop_array = array();
	
	for($i=0;$i<$goods_cnt;$i++){
		$goods_loop_array[$i]['g_num'] = $goods_array[0];
		$goods_loop_array[$i]['name'] = $goods_array[1];
		$goods_loop_array[$i]['price'] = number_format($goods_array[2]);
		$goods_tot_price = $goods_tot_price + $goods_array[2];
		$goods_loop[] = $goods_loop_array[$i];		
	}


} else if(!empty($rs['goods'])) {

	$goods_array = explode("||",$rs['goods']);
	$goods_type = "dan";
	$goods_cnt = count($goods_array);
	if ($goods_cnt > 1) {
		$goods_type = "goods";
	}
	$goods_tot_price = 0;	
	$goods_loop = array();
	$goods_loop_array = array();
	for($i=0;$i<$goods_cnt;$i++){
		$goods_array2 = explode("<>",$goods_array[$i]);
		$goods_loop_array[$i]['g_num'] = $goods_array2[0];
		$goods_loop_array[$i]['name'] = $goods_array2[1];
		$goods_price = @round($goods_array2[2] - ($goods_array2[2] * ($goods_array2[3] / 100)),0);
		$goods_loop_array[$i]['price'] = number_format($goods_price);
		$goods_tot_price = $goods_tot_price + $goods_price;
		$goods_loop[] = $goods_loop_array[$i];		
	}
}

if (!empty($rs['book'])) {
	$book_array = explode("||",$rs['book']);
	$book_cnt = count($book_array);
	$book_loop = array();
	$book_loop_array = array();
	$book_tot_price = 0;

	for($i=0;$i<$book_cnt;$i++){
		$book_array2 = explode("<>",$book_array[$i]);
		$book_loop_array[$i]['bo_num'] = $book_array2[0];
		$book_loop_array[$i]['bo_name'] = $book_array2[1];
		$book_loop_array[$i]['price'] = number_format($book_array2[2]);
		$book_tot_price = $book_tot_price + $book_array2[2];
		$book_loop[] = $book_loop_array[$i];		
	}
}

$tpl->assign('goods_type', $goods_type);
$tpl->assign('goods_cnt', $goods_cnt);
$tpl->assign('goods_list', $goods_loop);
$tpl->assign('goods_tot_price', number_format($goods_tot_price));

$tpl->assign('book_cnt', $book_cnt);
$tpl->assign('book_tot_price', number_format($book_tot_price));
$tpl->assign('book_list', $book_loop);

$tpl->assign('tot_price', number_format($goods_tot_price + $book_tot_price));


$tpl->assign('os_amt', number_format($rs['os_amt']));
$tpl->assign('os_type', $rs['os_type']);
$tpl->assign('os_num', $os_num);
$tpl->assign('osdi_name', $rs['osdi_name']);					// 받는 사람 이름
$tpl->assign('osdi_tel', $rs['osdi_tel']);								// 전화번호
$tpl->assign('osdi_hp', $rs['osdi_hp']);								// 휴대폰번호
$tpl->assign('osdi_email', $rs['osdi_email']);								// 이메일
$addr = "[".$rs['osdi_zipcode']."]".$rs['osdi_address']." ".$rs['osdi_address_detail'];
$tpl->assign('osdi_addr', $addr);								// 배송지주소
$tpl->assign('osdi_message', $rs['osdi_message']);								// 요청사항





$tpl->assign('page', $page);
$tpl->print_('frame');
?>