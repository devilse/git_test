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


$name = addslashes(trim($_POST['name']));
$tel = $_POST['tel1']."-".$_POST['tel2']."-".$_POST['tel3'];
$phone = $_POST['hp1']."-".$_POST['hp2']."-".$_POST['hp3'];
$email = addslashes(trim($_POST['email']));
$mb_num =  $User_Info['member_num'];
$mb_messenger =  addslashes(trim($_POST['mb_messenger']));
$mb_cafeurl =  addslashes(trim($_POST['mb_cafeurl']));


if (!$name) {
	alertback("이름을 입력해 주세요.");
}

if (!$mb_num) {
	alertback("접근 할 수 없습니다.");
}

$t_chk = true;	//쿼리 이상유무 체크 변수 
mysqli_query($CONN['rosemary'],"set autocommit = 0;");
mysqli_query($CONN['rosemary'],"begin;");


$user_up_query = mysqli_query($CONN['rosemary'],"update member set mb_name = '$name', mb_email = '$email', mb_tel = '$tel', mb_hp = '$phone' where mb_num = '$mb_num'");
if (!$user_up_query) {
	$t_chk = false;
} else {

	$marketer_info_up = mysqli_query($CONN['rosemary'],"update member_marketer set mb_messenger =  '$mb_messenger', mb_cafeurl = '$mb_cafeurl' where mb_num = '$mb_num'");
	if (!$marketer_info_up) {
		$t_chk = false;
	}
}

if ($t_chk != true) {
	mysqli_query($CONN['rosemary'],"rollback;");
	alertback("업데이트 오류 발생");
} else {
	mysqli_query($CONN['rosemary'],"commit;");	
	alertGo("정상적으로 변경 되었습니다.","../index.php");
}



?>