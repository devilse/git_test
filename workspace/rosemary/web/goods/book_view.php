<?php
include '../../_include/lib_include.php';
include '../include/frame_a.php';

$tpl->createSubMenu('1301');
$tpl->define('content', "skin/ls/$siteoption[skin_book]/book_view.html");

$bo_num = $_GET['bo_num'];
$key = $_GET['key'];
$searchword = trim($_GET['searchword']);

$tpl->assign('bo_num', $bo_num);
$tpl->assign('key', $key);
$tpl->assign('searchword', $encode_searchword);




if (!$bo_num) {
	alertback("접근 할 수 없습니다.");
}


$book_qry = "select * from book where bo_num = '$bo_num' and bo_useyn='Y'";
$book_query = mysqli_query($CONN['rosemary'],$book_qry);
$book_tot_cnt = mysqli_num_rows($book_query);

if (!$book_tot_cnt) {
	alertback("선택한 교재는 등록되지 않았거나 판매중단된 교재입니다.");
} else {
	$book_rs = mysqli_fetch_array($book_query);
	$bo_name = stripslashes($book_rs['bo_name']);							// 교재명
	$bo_list_price = number_format($book_rs['bo_list_price']);				// 교재 정가
	$bo_price = $book_rs['bo_selling_price'];								// 교재 판매가
	$bo_selling_price = number_format($book_rs['bo_selling_price']);			// 교재 판매가
	$bo_writer = stripslashes($book_rs['bo_writer']);						// 저자명
	$bo_page_cnt = stripslashes($book_rs['bo_page_cnt']);					// 페이지 수
	$bo_writer = stripslashes($book_rs['bo_writer']);						// 저자명
	$bo_publisher = stripslashes($book_rs['bo_publisher']);					// 출판사
	$bo_explain_book = stripslashes($book_rs['bo_explain_book']);			// 교재설명
	$bbo_explain_writer = stripslashes($book_rs['bo_explain_writer']);		// 교재목차
	$bo_img = stripslashes($book_rs['bo_img']);								// 교재이미지
}

$tpl->assign('bo_name', $bo_name);
$tpl->assign('bo_list_price', $bo_list_price);
$tpl->assign('bo_price', $bo_price);
$tpl->assign('bo_selling_price', $bo_selling_price);
$tpl->assign('bo_writer', $bo_writer);
$tpl->assign('bo_page_cnt', $bo_page_cnt);
$tpl->assign('bo_writer', $bo_writer);
$tpl->assign('bo_publisher', $bo_publisher);
$tpl->assign('bo_explain_book', $bo_explain_book);
$tpl->assign('bo_explain_writer', $bo_explain_writer);
$tpl->assign('bo_img', $bo_img);

$tpl->print_('frame');
?>