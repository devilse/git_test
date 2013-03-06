<?php
include '../../_include/lib_include.php';
include '../include/frame_a.php';
include '../../_autocode/siteoption.php';

																							// 넘어온 파라미터 변수선언
if (!empty($_GET['page'])) {
	$page = $_GET['page'];
}
if (!empty($_GET['key'])) {
	$key = $_GET['key'];
}
if (!empty($_GET['searchword'])) {
	$searchword = trim($_GET['searchword']);
}
if (!$key && $searchword) {
	$key = "title";
}
$param = "page=".$page."&key=".$key."&searchword=".$searchword;
$tpl->assign('param', $param);
																							// 스킨설정
$qna_skin = $siteoption['skin_qna'];
if (!$qna_skin) {
	$qna_skin = "basic";
}
$tpl->createSubMenu('6201');
$tpl->define('content', "skin/qna/$qna_skin/list.html");
$page_list_url = $MY_URL."_template/skin/board/".$qna_skin;

																							// 로그인 체크 - 회원만 접근이 가능하다.
$User_Info =  Login_Chk($_COOKIE['LIPASS_ID']);
$mb_type = $User_Info['type'];

if ($mb_type == "G" || !$mb_type) {
	alertGo("","$MY_URL");
}
$tpl->assign('mb_id', $User_Info['id']);





$search_where = "";
if ($key && $searchword) {
	$searchword_chk = 1;
	if (preg_match("/[!#$%^&*()?{}.;:<>+=\/]/",$searchword)) {
		$searchword_chk = 0; 
	}
	if ($searchword_chk != 1) {
		alertback("특수문자가 포함되어 검색할 수 없습니다.");
	}
	if ($key == "tot") {
		$search_where = "where a.title like '%$searchword%' or b.contents like '%$searchword%'";
	} else if ($key == "title") {
		$search_where = "where $key like '%$searchword%'";
	} else if ($key == "con") {
		$search_where = "where b.contents like '%$searchword%'";
	} else if ($key == "mb_id") {
		$search_where = "where $key like '%$searchword%'";
	}

	$encode_searchword = urlencode($searchword);
}
if ($key == "tot" || $key == "con") {
	$qna_list_query = sql_query($CONN['rosemary'],"select count(*) as cnt from qna_list a, qna_contents b $search_where and a.qna_num = b.qna_num group by a.qna_num");
} else {
	$qna_list_query = sql_query($CONN['rosemary'],"select count(*) as cnt from qna_list $search_where");
}

$qna_list_num = mysqli_result($qna_list_query,0,0);
$query_number	=	$qna_list_num;




if ($query_number) {
	if ($key == "tot" || $key == "con") {
		$list_query = mysqli_query($CONN['rosemary'],"select a.* from qna_list a, qna_contents b $search_where and a.qna_num = b.qna_num group by qna_num order by qna_num desc $limit");
	} else {
		$list_query = mysqli_query($CONN['rosemary'],"select * from qna_list $search_where order by qna_num desc $limit");
	}
	$number = $query_number - $first;
	$list_loop = array();
	while($qna_list_rs = mysqli_fetch_array($list_query)) {
		$qna_list_rs['title'] = stripslashes($qna_list_rs['title']);
		$qna_list_rs['mb_name'] = stripslashes($qna_list_rs['mb_name']);
		$qna_list_rs['reg_date'] = date("Y-m-d H:i:s",$qna_list_rs['reg_date']);
		$qna_list_rs['hit_cnt'] = number_format($qna_list_rs['hit_cnt']);
		$qna_list_rs['gubun'] = Qna_Gubun($qna_list_rs['gubun']);
		

		$qna_list_rs['list_number'] = $number;
		$list_loop[] = $qna_list_rs;
		$number--;
	}
}

$list_page = go_page($query_number, $num_per_page, $num_per_block, $page, "./index.php?", $key, $searchword,$mode);


$tpl->assign('page_list', $list_page);
$tpl->assign('list', $list_loop);
$tpl->assign('query_number', $query_number);


$tpl->print_('frame');
?>