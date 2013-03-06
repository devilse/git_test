<?
include '../../_include/lib_include.php';
if (!$siteoption['skin_class']) {
	$siteoption['skin_class'] = "basic";
}
$tpl->define('frame', "skin/class/".$siteoption['skin_class']."/frame.html");
$tpl->define('content', "skin/class/basic/end_member_goods.html");

// 로그인 체크
$User_Info =  Login_Chk($_COOKIE['LIPASS_ID']);
$mb_type = $User_Info['type'];
$mb_num = $User_Info['member_num'];
$tpl->assign('mb_id', $User_Info['id']);

if (!$mb_type || $mb_type == "G" || !$mb_num) {
	alertback("로그인이 필요 합니다.");
}


$goods_cnt_A = Member_Goods_Cnt($mb_num,'A');		// 수강대기중 강좌
$goods_cnt_B = Member_Goods_Cnt($mb_num,'B');		// 수강중인 강좌
$goods_cnt_C = Member_Goods_Cnt($mb_num,'C');		// 일시정지인 강좌
$goods_cnt_D = Member_Goods_Cnt($mb_num,'D');		// 수강종료인 강좌

$tpl->assign('goods_cnt_A', number_format($goods_cnt_A));
$tpl->assign('goods_cnt_B', number_format($goods_cnt_B));
$tpl->assign('goods_cnt_C', number_format($goods_cnt_C));
$tpl->assign('goods_cnt_D', number_format($goods_cnt_D));

$member_Order_cnt_A = Member_Ordersheet_Cnt($mb_num,'A');	// 결제 입금 대기중
$member_Order_cnt_B = Member_Ordersheet_Cnt($mb_num,'B');	// 결제 완료
$member_Order_cnt_C = Member_Ordersheet_Cnt($mb_num,'C');	// 환불 완료	

$tpl->assign('member_Order_cnt_A', number_format($member_Order_cnt_A));
$tpl->assign('member_Order_cnt_B', number_format($member_Order_cnt_B));
$tpl->assign('member_Order_cnt_C', number_format($member_Order_cnt_C));



$list_qry = "select 
					*,
					(select C.lt_name from goods_lecture C where C.lt_num = A.lt_num) as lt_name,
					(select D.mb_name from goods_lecture C, member D where C.lt_num = A.lt_num and C.mb_num = D.mb_num) as te_name,
					(select CONCAT_WS(',',mbglu_sdate,mbglu_edate) from member_goods_lecture_usehistory E where E.os_num = A.os_num and E.g_num = A.g_num and E.lt_num = A.lt_num order by mbglu_num desc limit 1) as time
			 from 
					member_goods_lecture A, member_goods B 
			 where 
					A.os_num = B.os_num and A.g_num = B.g_num and A.mbgl_state = 'D' and B.mb_num = '$mb_num'
					order by mbg_regdate desc
					$limit";

$query_number	=	$goods_cnt_D;
if ($query_number) {
	$list_query = mysqli_query($CONN['rosemary'],$list_qry);
	$list_loop = array();
	while($rs = mysqli_fetch_array($list_query)){
		$rs['lt_name'] = stripslashes($rs['lt_name']);			// 강의명(단과명)
		$rs['te_name'] = stripslashes($rs['te_name']);			// 교수명
		$rs['reg_date'] = date("Y-m-d",$rs['mbg_regdate']);		// 등록날짜
		$rs['mbgl_term'] = number_format($rs['mbgl_term']);		// 수강일
		$time_array = explode(",",$rs['time']);
		$rs['start_date'] = date("Y-m-d",$time_array[0]);						// 수강시작날
		$rs['end_date'] = date("Y-m-d",$time_array[1]);						// 수강 종료날

		$list_loop[] = $rs; 
	}
}

$list_page = go_page($query_number, $num_per_page, $num_per_block, $page, "./index.php?", $key, $searchword,$mode);
$tpl->assign('list_page', $list_page);
$tpl->assign('query_number', $query_number);
$tpl->assign('list', $list_loop);


$tpl->print_('frame');
?>