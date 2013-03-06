<?
header('Content-Type: text/html;charset=utf-8');

include "../../_lib/db_conn.php";	// 디비 접속
include "../../_lib/global.php";
include "../../_lib/function.php";
include "../../_lib/lib.php";	// 관리자 페이지 공용 함수 파일
include "../../web/member/process/lib_join.php";

// 로그인 체크
$User_Info =  Login_Chk($_COOKIE['LIPASS_ID']);
$mb_type = $User_Info['type'];
$mb_num = $User_Info['member_num'];
if (!$mb_type || $mb_type == "G" || !$mb_num) {
	echo "로그인이 필요 합니다.";
	exit;
}

$mb_email = addslashes(trim($_POST['email1']))."@".addslashes(trim($_POST['email2']));
if(email_check_info($mb_email,$mb_num)) {
	echo "이미 가입된 이메일 입니다.";
	exit;
}

$mb_name = addslashes(trim($_POST['mb_name']));
$ms_birth = $_POST['birth_year']."-".Get2Number($_POST['birth_month'])."-".Get2Number($_POST['birth_day']);




if(empty($_POST['mb_tel2']) == false && empty($_POST['mb_tel3']) == false) {
	$mb_tel = $_POST['mb_tel1']."-".$_POST['mb_tel2']."-".$_POST['mb_tel3'];
}

if(empty($_POST['mb_hp2']) == false && empty($_POST['mb_hp3']) == false) {
	$mb_hp = $_POST['mb_hp1']."-".$_POST['mb_hp2']."-".$_POST['mb_hp3'];
}

$ms_sex = $_POST['ms_sex'];

if(empty($_POST['ms_zip1']) == false && empty($_POST['ms_zip2']) == false) {
	$ms_zipcode = $_POST['ms_zip1']."-".$_POST['ms_zip2'];
}

$ms_address = addslashes(trim($_POST['ms_address']));
$ms_address_detail = addslashes(trim($_POST['ms_address_detail']));

$ms_email_yn = GetYN($_POST['ms_email_yn']);
$ms_sms_yn = GetYN($_POST['ms_sms_yn']);



// 회원 정보 저장
$result = true;
mysqli_query($CONN['rosemary'],"set autocommit = 0;");
mysqli_query($CONN['rosemary'],"begin;");

$up_qry = mysqli_query($CONN['rosemary'],"update member set mb_name = '$mb_name', mb_email='$mb_email', mb_tel='$mb_tel', mb_hp = '$mb_hp' where mb_num = '$mb_num'");
if (!$up_qry) {
	$result = false;
} else {
	$detail_up_qry = mysqli_query($CONN['rosemary'],"update member_student set ms_zipcode = '$ms_zipcode', ms_address='$ms_address', ms_address_detail='$ms_address_detail', ms_birthday = '$ms_birth',ms_sex = '$ms_sex', ms_email_yn = '$ms_email_yn', ms_sms_yn = '$ms_sms_yn'  where mb_num = '$mb_num'");
	if (!$detail_up_qry) {
		$result = false;
	} 
}

if($result == true) {
	mysqli_query($CONN['rosemary'], "commit;");	
	echo "정보가 변경 되었습니다.";
	exit;
} else {
	mysqli_query($CONN['rosemary'], "rollback;");
	echo "디비 오류 발생";
	exit;	
}










function Get2Number($str)
{
	if(strlen($str) == 1) {
		return "0".$str;
	} else {
		return $str;
	}
}

// $str이 빈값이면 N을 반환합니다.
function GetYN($str)
{
	if(empty($str)) {
		return "N";
	} else {
		return $str;
	}
}





?>