<?php
include '../../_include/lib_include.php';
include '../include/frame_a.php';
include '../../_autocode/siteoption.php';

$faq_skin = $siteoption['skin_faq'];
if (!$faq_skin) {
	$faq_skin = "basic";
}

$tpl->createSubMenu('6401');
$tpl->define('content', "skin/faq/$faq_skin/faq_list.html");

if (!empty($_GET['key'])) {
	$key = $_GET['key'];
}
if (!empty($_GET['searchword'])) {
	$searchword = trim($_GET['searchword']);
}
if (!$key && $searchword) {
	$key = "title";
}
if (!empty($_GET['sel_mal'])) {
	$sel_mal = $_GET['sel_mal'];
}

$where = "";
$search_where = "";

if ($sel_mal) {
	$where .= " and mal = '$sel_mal'"; 
}

if ($key && $searchword) {
	$searchword_chk = 1;
	if (preg_match("/[!#$%^&*()?{}.;:<>+=\/]/",$searchword)) {
		$searchword_chk = 0; 
	}
	if ($searchword_chk != 1) {
		alertback("특수문자가 포함되어 검색할 수 없습니다.");
	}
	if ($key == "tot") {
		$search_where = "and title like '%$searchword%' or contents like '%$searchword%'";
	} else if ($key == "title") {
		$search_where = "and $key like '%$searchword%'";
	} else if ($key == "con") {
		$search_where = "and contents like '%$searchword%'";
	} else if ($key == "mb_id") {
		$search_where = "and $key like '%$searchword%'";
	}

	$encode_searchword = urlencode($searchword);
}

$faq_query = sql_query($CONN['rosemary'],"select count(*) as cnt from faq where 1=1 $search_where");
$faq_num = mysqli_result($faq_query,0,0);
$query_number	=	$faq_num;

if ($query_number) {
	$list_loop = array();
	$list_query = mysqli_query($CONN['rosemary'],"select * from faq where 1=1 $where $search_where order by faq_num desc $limit");
	$faq_view = "none";
	$first_num = "";
	while($faq_rs = mysqli_fetch_array($list_query)) {
		if ($first_num == "") {
			$first_num = $faq_rs['faq_num'];
		}
		$faq_rs['reg_date'] = date("Y-m-d h:i:s",$faq_rs['reg_date']);
		$faq_rs['mal'] = Mal_Chk($faq_rs['mal']);
		$faq_rs['div_view'] = $faq_view;
		$list_loop[] = $faq_rs;
		$faq_view = "none";
	}

	$page_list = go_page($query_number, $num_per_page, $num_per_block, $page, "./index.php?sel_mal=$sel_mal&", $key, $searchword,$mode);
}



$tpl->assign('first_num', $first_num);
$tpl->assign('query_number', $query_number);	
$tpl->assign('page', $page);
$tpl->assign('key', $key);
$tpl->assign('searchword', $searchword);
$tpl->assign('sel_mal', $sel_mal);
$tpl->assign('list', $list_loop);



$tpl->print_('frame');
?>