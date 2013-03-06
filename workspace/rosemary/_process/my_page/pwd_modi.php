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
	echo "로그인이 필요 합니다.";
	exit;
}

$id = $User_Info['id'];
$y_pwd = md5(md5($_POST['y_pwd']));

$pwd = md5(md5($_POST['pwd1']));
$pwd2 = md5(md5($_POST['pwd2']));

if ($pwd != $pwd2) {
	echo "비밀번호 확인을 해주세요.";
	exit;
}
$chk_qry = mysqli_query($CONN['rosemary'],"select * from member where mb_id = '$id' and mb_password = '$y_pwd'");
$chk_nums = mysqli_num_rows($chk_qry);

if (!$chk_nums) {
	echo "현재 비밀번호가 일치하지 않습니다.";
	exit;
} else {

	$up_pwd = mysqli_query($CONN['rosemary'],"update member set mb_password = '$pwd' where mb_id = '$id' and mb_password = '$y_pwd'");
	if (!$up_pwd) {
		echo "디비 오류 발생";
		exit;
	} else {
		echo "비밀번호가 변경 되었습니다.";
		exit;
	}


}




?>