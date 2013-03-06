<?php
include '../../_include/lib_include.php';
include '../include/frame_a.php';

$ca_num = $_GET['ca_num'];
if(empty($ca_num)) $ca_num = 0;

$tpl->createSubMenu('1201', $ca_num);

if (!$category_skin[$ca_num]) {
	$category_skin[$ca_num] = "basic";
}
$tpl->define('content', "skin/ls/$category_skin[$ca_num]/goods_list.html");



//해당 카테고리의 패키지와 상품을 가져온다.

$pack_cnt_qry = "select C.gp_num from goods A, goods_package_goods B , goods_package C where A.ca_num = '$ca_num' and A.g_num = B.g_num and B.gp_num = C.gp_num and C.gp_state = 'S' group by C.gp_num ";
$pack_list_qry = "
				select 
						A.*,
						(select	
								sum((select sum(C.lt_selling_price) - truncate(((sum(C.lt_selling_price) * (D.g_discount_rate / 100) )),0)  from goods_lecture C, goods D  where C.g_num = B.g_num and B.g_num = D.g_num))
						 from 
								goods_package_goods B 
						 where 
								A.gp_num = B.gp_num) as price,

						(select GROUP_CONCAT(CONCAT_WS('<>',C.g_num,C.g_name,D.ca_name) SEPARATOR '||') from goods_package_goods B, goods C, category D  where B.gp_num = A.gp_num and B.g_num = C.g_num and C.ca_num = D.ca_num) as g_name,

						(select sum((select sum(C.lt_term) from goods_lecture C where C.g_num = B.g_num)) from goods_package_goods B where A.gp_num = B.gp_num ) as term

				from 
						goods_package A,
						goods_package_goods E,
						goods F

				where

						F.ca_num = '$ca_num' and 
						F.g_num = E.g_num and
						E.gp_num = A.gp_num and
						A.gp_state = 'S'

				group by A.gp_num
				order by A.gp_num desc $limit
			";


$pack_cnt_query = mysqli_query($CONN['rosemary'],$pack_cnt_qry);
$pack_tot_cnt = mysqli_num_rows($pack_cnt_query);


if ($pack_tot_cnt > 0) {
	$pack_query = mysqli_query($CONN['rosemary'],$pack_list_qry);
	while ($rs = mysqli_fetch_array($pack_query)) {
		
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
		$pack_list_loop[] = $rs;
	}
}
$tpl->assign('pack_tot_cnt', $pack_tot_cnt);
$tpl->assign('pack_list_loop', $pack_list_loop);


// 강좌 상품을 가져온다.

$goods_qry = "select count(*) as cnt from goods where ca_num = '$ca_num' and g_state = 'S'	";
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
						A.ca_num = '$ca_num' and
						A.g_state = 'S'	
					order by A.g_num desc $limit
						";

$goods_cnt_query = mysqli_query($CONN['rosemary'],$goods_qry);
$goods_cnt = mysqli_result($goods_cnt_query,0,0);
$query_number	=	$goods_cnt;
if ($query_number) {
	$number = $query_number - $first;
	$goods_query = mysqli_query($CONN['rosemary'],$goods_list_qry);
	$list_loop = array();
	while($goods_rs = mysqli_fetch_array($goods_query)){
		$goods_rs['number_format_price'] = number_format($goods_rs['price']);													// 정가
		$goods_rs['h_price'] =  @round($goods_rs['price'] - ($goods_rs['price'] * ($goods_rs['g_discount_rate'] / 100)),0);		// 판매가 - 할인된 금액
		$goods_rs['number_format_h_price'] = number_format($goods_rs['h_price']);												// 리스트 노출 판매가
		$goods_rs['lt_term'] = number_format($goods_rs['lt_term']);																// 수강기간
		$list_loop[] = $goods_rs;	
	}
}



$list_page = go_page($query_number, $num_per_page, $num_per_block, $page, "./index.php?", $key, $searchword,$mode);

$tpl->assign('list_cnt', $query_number);
$tpl->assign('list', $list_loop);
$tpl->assign('list_page', $list_page);
$tpl->assign('ca_num', $ca_num);
$tpl->print_('frame');
?>