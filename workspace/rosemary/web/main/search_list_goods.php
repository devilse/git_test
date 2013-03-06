<?php
include '../../_include/lib_include.php';
include '../include/frame_b.php';

$cg_code = $siteoption['default_cs_code'];
if (!$cg_code) {
	$cg_code = "001";
}

$tpl->define('content', "skin/cs/".$cs_skin_array[$tpl->cs]."/search_list_goods.html");

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
$list_page = go_page($query_number, $num_per_page, $num_per_block, $page, "./search_list_goods.php?top_search=$search_text&", $key, $searchword,$mode);


$tpl->assign('list_page', $list_page);

$tpl->assign('list_cnt', $query_number);
$tpl->assign('list', $list_loop);




$tpl->print_('frame');
?>