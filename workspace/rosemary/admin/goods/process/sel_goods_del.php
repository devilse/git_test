<?php
header('Content-Type: text/html;charset=utf-8');

include "../../../_lib/db_conn.php";	// 디비 접속
include "../../../_lib/global.php";
include "../../../_lib/function.php";
include "../../../_lib/lib.php";	// 관리자 페이지 공용 함수 파일

$gg_code = $_POST['gg_code'];
$page = $_POST['page'];
$key = $_POST['key'];
$searchword = $_POST['searchword'];
$set_cs = $_POST['set_cs'];
$set_state = $_POST['set_state'];

$page_param = "&page=$page&key=$key&searchword=$searchword&set_cs=$set_cs&set_state=$set_state";

if (!$gg_code) alertback("접근할 수 없습니다.");

$t_chk = true;	//쿼리 이상유무 체크 변수
mysqli_query($CONN['rosemary'],"set autocommit = 0;");
mysqli_query($CONN['rosemary'],"begin;");

$goods_del_query = mysqli_query($CONN['rosemary'],"delete from goods_group_goods where gg_code = '$gg_code'");
if (!$goods_del_query) {
	$t_chk = false;
} else {
	$group_del = mysqli_query($CONN['rosemary'],"delete from goods_group where gg_code = '$gg_code'");
	if (!$group_del) {
		$t_chk = false;
	}
}


if ($t_chk != true) {
	mysqli_query($CONN['rosemary'],"rollback;");
	alertback("상품 그룹 삭제 실패");
} else {
	mysqli_query($CONN['rosemary'],"commit;");	
	alertGo("","../index.php?mode=sel_goods_list&".$page_param);
}

?>