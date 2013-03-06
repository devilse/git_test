<?php
header('Content-Type: text/html;charset=utf-8');

include "../../../_lib/function.php";	// 관리자 페이지 공용 함수 파일
include "../../../_lib/db_conn.php";	// 디비 접속	
include "../../../_lib/global.php";	// 관리자 페이지 공용 변수 파일
include "../../../_lib/lib.php";	// 관리자 페이지 공용 디비 함수 파일

$write_mode = $_POST['write_mode'];


$User_Info	 =  Login_Chk($_COOKIE['LIPASS_ID']);



if (!$write_mode) {

	$contents = addslashes(trim($_POST['content']));
	$start_date = explode("-",$_POST['start_date']);
	$start_time = @mktime(0,0,0,$start_date[1],$start_date[2],$start_date[0]);


	if (!$contents) {
		alertback("내용을 입력해 주세요.");
	}

	if (!$start_time) {
		alertback("약관 시행일을 입력해 주세요.");
	}

	$privacy_in_query = mysqli_query($CONN['rosemary'],"insert into site_privacy(sp_content,sp_sdate,sp_regdate) values('$contents','$start_time',unix_timestamp())");
	if (!$privacy_in_query) {
		alertback("디비 업데이트 실패.");
	}else{
		alertGo("","../index.php?mode=privacy");
	}

} else if ($write_mode == "modi") {


	$sp_num = $_POST['sp_num'];
	$write_mode = $_POST['write_mode'];
	$page = $_POST['page'];
	$key = $_POST['key'];
	$searchword = $_POST['searchword'];
	$contents = addslashes(trim($_POST['content']));
	$start_date = explode("-",$_POST['start_date']);
	$start_time = @mktime(0,0,0,$start_date[1],$start_date[2],$start_date[0]);

	if (!$contents) {
		alertback("내용을 입력해 주세요.");
	}

	if (!$start_time) {
		alertback("약관 시행일을 입력해 주세요.");
	}

	$privacy_up_query = mysqli_query($CONN['rosemary'],"update site_privacy set sp_content = '$contents', sp_sdate = '$start_time' where sp_num = '$sp_num'");
	if (!$privacy_up_query) {
		alertback("디비 업데이트 실패.");
	} else {
		alertGo("","../index.php?mode=privacy&page=$page&key=$key&searchword=$searchword");
	}

	

}









?>
