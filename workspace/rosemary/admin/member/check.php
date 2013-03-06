<?php
include "../../_lib/function.php";	// 관리자 페이지 공용 함수 파일
include "../../_lib/db_conn.php";	// 디비 접속	
include "../../_lib/global.php";	// 관리자 페이지 공용 변수 파일
include "../../_lib/lib.php";	// 관리자 페이지 공용 디비 함수 파일

$mb_id = $_POST['id'];	//id
$ck = $_GET['ck'];		//id 체크 여부
$e_mail = $_POST['email'];	//메일

if($ck == 'id') {
	$v_sql = @mysqli_query($CONN['rosemary'],"select count(*) cnt from member where mb_id='$mb_id'");
	$ck_id = @mysqli_fetch_array($v_sql);

	if($ck_id['cnt'] > 0) {

	// 아이디가 존재할 경우 출력 내용. 
		echo "<span style=\"color:#FF0000\">중복된 아이디입니다.</span>";
		echo "<script type='text/javascript'>document.form.id_ck.value='N';</script>";
	} else {
	// 아이디가 존재하지 않을 경우 출력 내용. */
		echo "<span style=\"color:#00AA00\">사용 가능합니다.</span>";
		echo "<script type='text/javascript'>document.form.id_ck.value='Y';</script>";
	}
} else if($ck == 'email') {

	if(filter_var($e_mail,FILTER_VALIDATE_EMAIL)=='') {
		echo "1";
	} else {
		echo "2";
	}
}
?>