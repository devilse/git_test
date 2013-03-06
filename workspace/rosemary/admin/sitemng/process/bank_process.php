<?php
header('Content-Type: text/html;charset=utf-8');

include "../../../_lib/function.php";	// 관리자 페이지 공용 함수 파일
include "../../../_lib/db_conn.php";	// 디비 접속	
include "../../../_lib/global.php";	// 관리자 페이지 공용 변수 파일
include "../../../_lib/lib.php";	// 관리자 페이지 공용 디비 함수 파일

$write_mode = $_POST['write_mode'];


if ($write_mode == "reg") {
	$bank = $_POST['bank'];						//은행
	$bank_number = $_POST['bank_number'];		//계좌번호
	$name = $_POST['name'];				//계좌주

	// 계좌번호는 중복으로 들어갈 수 없다. 

	$number_chk_query = mysqli_query($CONN['rosemary'],"select count(*) as cnt from site_account_number where sa_num = '$bank_number'");
	$number_cnt = mysqli_result($number_chk_query,0,0);

	if ($number_cnt) {
		alertback("이미 등록된 계좌번호 입니다.");
	}

	$number_in_query = mysqli_query($CONN['rosemary'],"insert into site_account_number values ('$bank_number','$bank','$name','Y',unix_timestamp())");
	if (!$number_in_query) {
		alertback("디비 업데이트 실패");
	} else {
		alertGo("","../index.php?mode=account");
	}

} else if ($write_mode == "del") {
	$del_number = $_POST['set_number'];
	if (!$del_number) {
		alertback("접근 할 수 없습니다.");	
	}

	$del_query = mysqli_query($CONN['rosemary'],"delete from site_account_number where sa_num = '$del_number'");
	if (!$del_query) {
		alertback("디비 업데이트 실패");
	} else {
		alertGo("","../index.php?mode=account");
	}
} else if ($write_mode == "state_modi") {
	$sa_num = $_POST['set_number'];
	$state_mode = $_POST['state_mode'];

	$up_query = mysqli_query($CONN['rosemary'],"update site_account_number set sa_useyn = '$state_mode' where sa_num = '$sa_num'");
	if (!$up_query) {
		alertback("디비 업데이트 실패");
	} else {
		alertGo("","../index.php?mode=account");
	}

}



?>