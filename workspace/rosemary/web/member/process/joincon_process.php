<?php
// 회원가입을 처리합니다.
// 자바스크립트에서 하고 있는 유효성 검사를 이곳에서도 동일하게 진행해야 합니다.
include '../../../_lib/isajax.php';
include "../../../_lib/function.php";
include "../../../_lib/db_conn.php";	
include "../../../_lib/global.php";	
include "../../../_lib/lib.php";
include "lib_join.php";

$mb_id = $_POST['mb_id'];
if(id_check($mb_id)) {
	echo "이미 가입된 아이디입니다.";
	exit;
}

$mb_email = $_POST['email1']."@".$_POST['email2'];
if(email_check($mb_email)) {
	echo "이미 가입된 이메일 입니다.";
	exit;
}

$mb_password = md5(md5($_POST['mb_password']));
$mb_name = $_POST['mb_name'];
$ms_birth = $_POST['birth_year']."-".Get2Number($_POST['birth_month'])."-".Get2Number($_POST['birth_day']);

if(empty($_POST['mb_tel2']) == false && empty($_POST['mb_tel3']) == false) {
	$mb_tel = $_POST['mb_tel1']."-".$_POST['mb_tel2']."-".$_POST['mb_tel3'];
}

if(empty($_POST['mb_hp2']) == false && empty($_POST['mb_hp3']) == false) {
	$mb_hp = $_POST['mb_hp1']."-".$_POST['mb_hp2']."-".$_POST['mb_hp3'];
}

$ms_sex = $_POST['ms_sex'];

if(empty($_POST['ms_zipcode1']) == false && empty($_POST['ms_zipcode2']) == false) {
	$ms_zipcode = $_POST['ms_zipcode1']."-".$_POST['ms_zipcode2'];
}

$ms_address = $_POST['ms_address'];
$ms_address_detail = $_POST['ms_address_detail'];

$ms_email_yn = GetYN($_POST['ms_email_yn']);
$ms_sms_yn = GetYN($_POST['ms_sms_yn']);

$domain_host = explode(".", $_SERVER['HTTP_HOST']);
$mb_marketer_num = mysqli_scalar("select mb_num from member_marketer where mb_hostname = '$domain_host[0]'");
if(empty($mb_marketer_num)) {
	$mb_marketer_num = "null";
}

// 회원 정보 저장
mysqli_query($CONN['rosemary'],"set autocommit = 0;");
mysqli_query($CONN['rosemary'],"begin;");

$member_query = "insert into member (mb_name, mb_id, mb_password, mb_email, mb_tel, mb_hp, mt_code, mb_regdate, mb_ip) values 
	('$mb_name','$mb_id','$mb_password','$mb_email','$mb_tel','$mb_hp','S','".mktime()."','$host_ip')";

$member_student_query = "insert into member_student (mb_num, ms_zipcode, ms_address, ms_address_detail, mb_marketer_num, ms_birthday, ms_sex, ms_email_yn, ms_sms_yn) values 
	(LAST_INSERT_ID(), '$ms_zipcode', '$ms_address', '$ms_address_detail', $mb_marketer_num, '$ms_birth', '$ms_sex', '$ms_email_yn', '$ms_sms_yn')";

$result = false;
if(mysqli_query($CONN['rosemary'], $member_query)) {	
	if(mysqli_query($CONN['rosemary'], $member_student_query)) {		
		$result = true;
	}	
}

if($result == true) {
	$mb_num = mysqli_scalar("select LAST_INSERT_ID()");
	mysqli_query($CONN['rosemary'], "commit;");	
	setcookie("EMAIL_CONFIRM", $mb_num, 0, "/");
	echo "ok";
} else {
	echo mysqli_error($CONN['rosemary']);
	mysqli_query($CONN['rosemary'], "rollback;");	
}
/*
echo "mb_id $mb_id\n";
echo "mb_password $mb_password\n";
echo "mb_name $mb_name\n";
echo "ms_birth $ms_birth\n";
echo "mb_email $mb_email\n";
echo "mb_tel $mb_tel\n";
echo "mb_hp $mb_hp\n";
echo "ms_sex $ms_sex\n";
echo "ms_zipcode $ms_zipcode\n";
echo "ms_address $ms_address\n";
echo "ms_address_detail $ms_address_detail\n";
echo "ms_email_yn $ms_email_yn\n";
echo "ms_sms_yn $ms_sms_yn\n";
*/


// 한자리 문자열을 앞에 0을 붙인 2자리 문자열로 반환합니다.
// 생년월일의 한자리 숫자를 두자리로 교정하는데 사용합니다.
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