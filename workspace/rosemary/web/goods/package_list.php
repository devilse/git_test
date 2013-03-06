<?php
include '../../_include/lib_include.php';
include '../include/frame_a.php';

if (!$siteoption['skin_package']) {
	$siteoption['skin_package'] = "basic";
}
$tpl->createSubMenu('1101');
$tpl->define('content', "skin/ls/$siteoption[skin_package]/package_list.html");

$set_cs = $siteoption['default_cs_code'];

$key = $_GET['key'];
$searchword = trim($_GET['searchword']);


if (!$key && $searchword) {
	$key = "g_name";
}

$search_where = "";
if ($key && $searchword) {
	$searchword_chk = 1;
	if (preg_match("/[!#$%^&*()?{}.;:<>+=\/]/",$searchword)) {
		$searchword_chk = 0; 
	}
	if ($searchword_chk != 1) {
		alertback("특수문자가 포함되어 검색할 수 없습니다.");
	}
	if ($key == "gp_name") {
		$search_where = "and A.gp_name like '%$searchword%'";
	}

	$encode_searchword = urlencode($searchword);
}

$state_where = "";
if ($set_state) {
	$state_where = "and gp_state = '$set_state'";
}

$cs_where = "";
if ($set_cs) {
	$cs_where = "and E.cg_code = '$set_cs'";
}


//디비 쿼리
$cnt_qry = "select count(*) as cnt from goods_package A, category_group E where  A.cg_code = E.cg_code and A.gp_state = 'S' $search_where $cs_where $state_where";


$list_qry = "
				select 
						A.*,
						E.cg_name as cg_name,
						(select	
								sum((select sum(C.lt_selling_price) - truncate(((sum(C.lt_selling_price) * (D.g_discount_rate / 100) )),0)  from goods_lecture C, goods D  where C.g_num = B.g_num and B.g_num = D.g_num))
						 from 
								goods_package_goods B 
						 where 
								A.gp_num = B.gp_num) as price,

						(select GROUP_CONCAT(CONCAT_WS('<>',C.g_num,C.g_name,D.ca_name) SEPARATOR '||') from goods_package_goods B, goods C, category D  where B.gp_num = A.gp_num and B.g_num = C.g_num and C.ca_num = D.ca_num) as g_name,

						(select sum((select sum(C.lt_term) from goods_lecture C where C.g_num = B.g_num)) from goods_package_goods B where A.gp_num = B.gp_num ) as term

				from 
						goods_package A ,
						category_group E

				where
						A.cg_code = E.cg_code
						and A.gp_state = 'S'
						$search_where
						$cs_where
						$state_where

				order by A.gp_num desc $limit
			";





$cnt_query = mysqli_query($CONN['rosemary'],$cnt_qry);
$tot_cnt = mysqli_result($cnt_query,0,0);
$query_number	=	$tot_cnt;

if ($query_number > 0) {
	$number = $query_number - $first;
	$query = mysqli_query($CONN['rosemary'],$list_qry);
	$list_loop = array();
	
	while ($rs = mysqli_fetch_array($query)) {
		
		$rs['gp_regdate'] = date("Y-m-d H:i:s",$rs['gp_regdate']);									// 패키지 등록일
		$h_price = @round($rs['price'] - ($rs['price'] * ($rs['gp_discount_rate'] / 100)),0);		// 할인된 금액 - 실제 판매금액
		$rs['h_price'] = number_format($h_price);													// number_format 적용 금액
		$rs['price'] = number_format($rs['price']);													// 원래 가격
		$rs['gp_name'] = stripslashes($rs['gp_name']);												// 패키지명
		$rs['gp_slogan'] = stripslashes($rs['gp_slogan']);											// 패키지 슬로건	
		$rs['gp_benefit'] = stripslashes($rs['gp_benefit']);										// 패키지 특전		
		$rs['gp_explanation'] = stripslashes($rs['gp_explanation']);								// 패키지 설명
		$rs['term'] = number_format($rs['term']);													// 수강 기간	

		$gp_rate_len = strlen($rs['gp_discount_rate']);
		if ($gp_rate_len < 2) {
			$rs['first_img'] = $rs['gp_discount_rate'];
		} else {
			$rs['first_img'] = substr($rs['gp_discount_rate'],0,1);
			$rs['second_img'] = substr($rs['gp_discount_rate'],1,1);
		}
	
		$g_name_array = explode("||",$rs['g_name']);
		$end_for = count($g_name_array);	
		
		$g_loop = array();			//상품구성			
		for ($i=0;$i<$end_for;$i++) {
			$g_name_array2 = explode("<>",$g_name_array[$i]);
			$g_num = $g_name_array2[0];
			$g_name = $g_name_array2[1];
			$ca_name = $g_name_array2[2];
			
			if ($i != ($end_for - 1)) {
				$gubun_smg = "|";
			} else {
				$gubun_smg = "";
			}

			$set_goods = $g_name." (".$ca_name.") $gubun_smg ";
			$g_loop[$i]['name'] = $set_goods; 
		}
		$rs['goods'] = 	$g_loop;

		$number--;
		$list_loop[] = $rs;
	}
}





$list_page = go_page($query_number, $num_per_page, $num_per_block, $page, "./package_list.php?", $key, $searchword,$mode);



$tpl->assign('page', $page);
$tpl->assign('list', $list_loop);
$tpl->assign('list_page', $list_page);
$tpl->print_('frame');
?>