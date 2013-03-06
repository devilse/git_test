<?php
header('Content-Type: text/html;charset=utf-8');

include "../../../_lib/db_conn.php";	// 디비 접속
include "../../../_lib/global.php";
include "../../../_lib/function.php";
include "../../../_lib/lib.php";	// 관리자 페이지 공용 함수 파일

$User_Info =  Login_Chk($_COOKIE['LIPASS_ID']);

$mb_type = $User_Info['type'];
if ($mb_type != "A") {
	alertGo("",$MY_URL."admin/admin_login.php");
}


$name = addslashes(trim($_POST['name']));
$tel = $_POST['tel1']."-".$_POST['tel2']."-".$_POST['tel3'];
$phone = $_POST['hp1']."-".$_POST['hp2']."-".$_POST['hp3'];
$email = addslashes(trim($_POST['email']));
$mb_num =  $User_Info['member_num'];

if (!$name) {
	alertback("이름을 입력해 주세요.");
}

if (!$mb_num) {
	alertback("접근 할 수 없습니다.");
}


$user_up_query = mysqli_query($CONN['rosemary'],"update member set mb_name = '$name', mb_email = '$email', mb_tel = '$tel', mb_hp = '$phone' where mb_num = '$mb_num'");
if (!$user_up_query) {
	alertback("디비 업데이트 실패");
} else {
	alertGo("","../index.php");
}





?>