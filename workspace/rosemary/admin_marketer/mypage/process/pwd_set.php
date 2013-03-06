<?php
header('Content-Type: text/html;charset=utf-8');

include "../../../_lib/db_conn.php";	// 디비 접속
include "../../../_lib/global.php";
include "../../../_lib/function.php";
include "../../../_lib/lib.php";	// 관리자 페이지 공용 함수 파일

$User_Info =  Login_Chk($_COOKIE['LIPASS_ID']);

$mb_type = $User_Info['type'];
if ($mb_type != "M") {
	alertGo("",$MY_URL."admin/admin_login.php");
}

$mb_num =  $User_Info['member_num'];
$pwd = md5(md5(addslashes(trim($_POST['pwd']))));
$new_pwd = md5(md5(addslashes(trim($_POST['new_pwd1']))));

if (!$pwd) {
	alertback("비밀번호를 입력해 주세요.");
}

if (!$new_pwd) {
	alertback("변경할 비밀번호를 입력해 주세요.");
}

if (!$mb_num) {
	alertback("접근 할 수 없습니다.");
}


$user_chk_query = mysqli_query($CONN['rosemary'],"select mb_num from member where mb_num = '$mb_num' and mb_password = '$pwd'");
$user_chk = @mysqli_num_rows($user_chk_query);
if (!$user_chk) {
	alertback("현재 비밀번호가 일치 하지 않습니다");
} else {
	$user_up_query = mysqli_query($CONN['rosemary'],"update member set mb_password = '$new_pwd' where mb_num = '$mb_num' and mb_password = '$pwd'");
	if (!$user_up_query) {
		alertback("디비 업데이트 실패");
	} else {
		alertGo("","../index.php?mode=pwd_set");
	}
}






?>