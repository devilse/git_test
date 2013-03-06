<?
header('Content-Type: text/html;charset=utf-8');

include "../../_lib/db_conn.php";	// 디비 접속
include "../../_lib/global.php";
include "../../_lib/function.php";
include "../../_lib/lib.php";	// 관리자 페이지 공용 함수 파일

// 로그인 체크
$User_Info =  Login_Chk($_COOKIE['LIPASS_ID']);
$mb_type = $User_Info['type'];
$mb_num = $User_Info['member_num'];
if (!$mb_type || $mb_type == "G" || !$mb_num) {
	alertback("로그인이 필요 합니다.");
}

$id = $User_Info['id'];
$pwd = md5(md5($_POST['pwd']));
$pwd = "2f7b52aacfbf6f44e13d27656ecb1f59";
$chk_qry = mysqli_query($CONN['rosemary'],"select * from member where mb_id = '$id' and mb_password = '$pwd'");
$chk_nums = mysqli_num_rows($chk_qry);

if (!$chk_nums) {
	alertback("비밀번호가 일치하지 않습니다.");
} else {
	setcookie("LIPASS_MYPAGE_CHK", "Y", 0, "/");
	alertGo("","../../web/mypage/my_info.php");
}




?>