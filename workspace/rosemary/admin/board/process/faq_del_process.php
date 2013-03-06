<?php
header('Content-Type: text/html;charset=utf-8');

include "../../../_lib/db_conn.php";	// 디비 접속
include "../../../_lib/global.php";
include "../../../_lib/function.php";
include "../../../_lib/lib.php";	// 관리자 페이지 공용 함수 파일



$faq_num	= $_GET['faq_num'];				// 리스트번호
$page		= $_GET['page'];					// 게시판 페이징 번호
$key		= $_GET['key'];						// 검색유형
$searchword = $_GET['searchword'];				// 검색어


if (!$faq_num) {
	alertback("접근 할 수 없습니다.");
}

$User_Info =  Login_Chk($_COOKIE['LIPASS_ID']);		// 로그인 체크
if (!$User_Info) {
	echo "X|로그인이 필요합니다.";
	exit;
}


	$del_query = mysqli_query($CONN['rosemary'],"delete from faq where faq_num = '$faq_num'");
	if (!$del_query) {
		alertback("삭제 시 오류가 발생하였습니다.");
	}else{
		alertGo("","../index.php?mode=faq&page=$page&key=$key&searchword=$searchword");
	}
?>
