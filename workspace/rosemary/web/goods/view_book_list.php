<?php
include '../../_include/lib_include.php';
include '../include/frame_a.php';

$first_lt_num = $_POST['lt_num'];
$ca_num = $_GET['ca_num'];
if(empty($ca_num)) $ca_num = 0;

$tpl->createSubMenu('1201', $ca_num);

if (!$category_skin[$ca_num]) {
	$category_skin[$ca_num] = "basic";
}
$tpl->define('book_list', "skin/ls/$category_skin[$ca_num]/view_book_list.html");

if ($first_lt_num) {

	//단과별로 교재 정보 가져옴
	$book_qry2 = "select B.* from goods_lecture_book A, book B where A.lt_num = '$first_lt_num' and A.bo_num = B.bo_num";
	$book_query2 = mysqli_query($CONN['rosemary'],$book_qry2);
	$book_nums2 = mysqli_num_rows($book_query2);
	if ($book_nums2) {
		$book_loop2 = array();
		$book_number = 1;
		while($book_rs2 = mysqli_fetch_array($book_query2)){
			$book_rs2['bo_name'] = stripslashes($book_rs2['bo_name']);							// 교재명
			$book_rs2['bo_list_price'] = number_format($book_rs2['bo_list_price']);				// 교재 정가
			$book_rs2['bo_price'] = $book_rs2['bo_selling_price'];								// 교재 판매가
			$book_rs2['bo_selling_price'] = number_format($book_rs2['bo_selling_price']);			// 교재 판매가
			$book_rs2['bo_writer'] = stripslashes($book_rs2['bo_writer']);						// 저자명
			$book_rs2['bo_page_cnt'] = stripslashes($book_rs2['bo_page_cnt']);					// 페이지 수
			$book_rs2['bo_writer'] = stripslashes($book_rs2['bo_writer']);						// 저자명
			$book_rs2['bo_publisher'] = stripslashes($book_rs2['bo_publisher']);					// 출판사
			$book_rs2['bo_explain_book'] = stripslashes($book_rs2['bo_explain_book']);			// 교재설명
			$book_rs2['bo_explain_writer'] = stripslashes($book_rs2['bo_explain_writer']);		// 교재목차
			$book_rs2['bo_img'] = stripslashes($book_rs2['bo_img']);								// 교재이미지
			$book_rs2['number'] = $book_number;

		
			$book_loop2[] = $book_rs2;
			$book_number++;
			
		}
	}
}
$tpl->assign('book_nums2', $book_nums2);
$tpl->assign('book_loop2', $book_loop2);


$tpl->print_('book_list');
?>