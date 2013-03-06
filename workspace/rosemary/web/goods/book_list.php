<?php
include '../../_include/lib_include.php';
include '../include/frame_a.php';

$tpl->createSubMenu('1301');
$tpl->define('content', "skin/ls/$siteoption[skin_book]/book_list.html");


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
	$search_where = "and bo_name like '%$searchword%'";
	$encode_searchword = urlencode($searchword);
}

$tpl->assign('key', $key);
$tpl->assign('searchword', $encode_searchword);



$book_cnt_qry = "select * from book where 1=1 and bo_useyn = 'Y' $search_where";
$book_list_qry = "select * from book where 1=1 and bo_useyn = 'Y' $search_where $limit";


$book_cnt_query = mysqli_query($CONN['rosemary'],$book_cnt_qry);
$book_tot_cnt = mysqli_num_rows($book_cnt_query);



if ($book_cnt_query > 0) {
	$book_query = mysqli_query($CONN['rosemary'],$book_list_qry);
	$book_loop = array();
	$book_number = 1;
	while ($book_rs = mysqli_fetch_array($book_query)) {
		
		$book_rs['bo_name'] = stripslashes($book_rs['bo_name']);							// 교재명
		$book_rs['bo_list_price'] = number_format($book_rs['bo_list_price']);				// 교재 정가
		$book_rs['bo_price'] = $book_rs['bo_selling_price'];								// 교재 판매가
		$book_rs['bo_selling_price'] = number_format($book_rs['bo_selling_price']);			// 교재 판매가
		$book_rs['bo_writer'] = stripslashes($book_rs['bo_writer']);						// 저자명
		$book_rs['bo_page_cnt'] = stripslashes($book_rs['bo_page_cnt']);					// 페이지 수
		$book_rs['bo_writer'] = stripslashes($book_rs['bo_writer']);						// 저자명
		$book_rs['bo_publisher'] = stripslashes($book_rs['bo_publisher']);					// 출판사
		$book_rs['bo_explain_book'] = stripslashes($book_rs['bo_explain_book']);			// 교재설명
		$book_rs['bo_explain_writer'] = stripslashes($book_rs['bo_explain_writer']);		// 교재목차
		$book_rs['bo_img'] = stripslashes($book_rs['bo_img']);								// 교재이미지
		$book_rs['number'] = $book_number;
		$book_number++;
		$book_loop[] = $book_rs;
	}
}
$list_page = go_page($book_cnt_query, $num_per_page, $num_per_block, $page, "./book_list.php?", $key, $searchword,$mode);

$tpl->assign('list_page', $list_page);
$tpl->assign('book_tot_cnt', $book_tot_cnt);
$tpl->assign('book_loop', $book_loop);


$tpl->print_('frame');
?>