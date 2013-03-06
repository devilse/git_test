<?php
include '../../_include/lib_include.php';
include '../include/frame_a.php';
include '../../_lib/tel.php';

$tpl->auth_block("S");
$tpl->createSubMenu('7811');

// 로그인 체크
$User_Info =  Login_Chk($_COOKIE['LIPASS_ID']);
$mb_type = $User_Info['type'];
$mb_id = $User_Info['id'];
$tpl->assign('mb_id', $User_Info['id']);
if (!$mb_type || $mb_type == "G") {
	alertback("로그인이 필요 합니다.");
}
// 해당 페이지는 일반 회원만 접근이 가능하다.

if ($mb_type != "S") {
	alertback("일반 회원만 접근 가능 합니다.");
}

if (!$_COOKIE['LIPASS_MYPAGE_CHK']) {
	$tpl->define('content', "skin/member/$siteoption[skin_member]/my_info_chk.html");
} else {
	$tpl->define('content', "skin/member/$siteoption[skin_member]/myinfo.html");
	
	$member_qry = mysqli_query($CONN['rosemary'],"select * from member A, member_student B where A.mb_id = '$mb_id' and A.mb_num = B.mb_num");
	$member_nums = mysqli_num_rows($member_qry);
	if (!$member_nums) {
		alertback("회원 정보를 불러올 수 없습니다.");
	}

	$member_rs = mysqli_fetch_array($member_qry);
	$mb_name = $member_rs['mb_name']; 
	$mb_tel = $member_rs['mb_tel']; 
	$mb_hp = $member_rs['mb_hp']; 
	$mb_email = $member_rs['mb_email']; 
	$ms_zipcode = $member_rs['ms_zipcode']; 
	$ms_address = $member_rs['ms_address']; 
	$ms_address_detail = $member_rs['ms_address_detail']; 
	$ms_birthday = $member_rs['ms_birthday'];
	$ms_sex = $member_rs['ms_sex'];
	$ms_email_yn = $member_rs['ms_email_yn'];
	$ms_sms_yn = $member_rs['ms_sms_yn'];
	$ms_email_confirm_yn = $member_rs['ms_email_confirm_yn'];

	$tpl->assign('mb_name', $mb_name);

	$mb_tel_array = explode("-",$mb_tel);
	$tpl->assign('mb_tel_1', $mb_tel_array[0]);
	$tpl->assign('mb_tel_2', $mb_tel_array[1]);
	$tpl->assign('mb_tel_3', $mb_tel_array[2]);

	$mb_hp_array = explode("-",$mb_hp);
	$tpl->assign('mb_hp_1', $mb_hp_array[0]);
	$tpl->assign('mb_hp_2', $mb_hp_array[1]);
	$tpl->assign('mb_hp_3', $mb_hp_array[2]);


	$mb_email_array = explode("@",$mb_email);
	$tpl->assign('email1', $mb_email_array[0]);
	$tpl->assign('email2', $mb_email_array[1]);


	$ms_zipcode_array = explode("-",$ms_zipcode);
	$tpl->assign('zip_1', $ms_zipcode_array[0]);
	$tpl->assign('zip_2', $ms_zipcode_array[1]);

	$tpl->assign('ms_address', $ms_address);
	$tpl->assign('ms_address_detail', $ms_address_detail);



	$ms_birthday_array = explode("-",$ms_birthday);
	$tpl->assign('ms_birthday_1', $ms_birthday_array[0]);
	$tpl->assign('ms_birthday_2', $ms_birthday_array[1]);
	$tpl->assign('ms_birthday_3', $ms_birthday_array[2]);

	$tpl->assign('ms_sex', $ms_sex);
	$tpl->assign('ms_email_yn', $ms_email_yn);
	$tpl->assign('ms_sms_yn', $ms_sms_yn);
	$tpl->assign('ms_email_confirm_yn', $ms_email_confirm_yn);

	$tpl->assign('tel_host', $tel_host);
	$tpl->assign('hp_host', $hp_host);

}




$tpl->print_('frame');
?>