<?php
header('Content-Type: text/html;charset=utf-8');

include "../../../_lib/db_conn.php";	// 디비 접속
include "../../../_lib/global.php";
include "../../../_lib/function.php";
include "../../../_lib/lib.php";	// 관리자 페이지 공용 함수 파일

$User_Info =  Login_Chk($_COOKIE['LIPASS_ID']);

$mb_type = $User_Info['type'];
if ($mb_type != "M") {
	alertGo("",$MY_URL);
}

$mb_num =  $User_Info['member_num'];
$script = addslashes(trim($_POST['script']));
$user_ip = $host_ip;

if (!$mb_num) {
	alertback("접근 할 수 없습니다.");
}

if (!$script) {
	alertback("등록할 스크립트를 입력해 주세요.");
}



$script_in_qry = mysqli_query($CONN['rosemary'],"insert into member_marketer_script(mb_num,mbs_script,mbs_regdate,mbs_ip) values('$mb_num','$script',unix_timestamp(),'$user_ip')");
if ($script_in_qry) {
	alertGo("","http://localhost/admin_marketer/mypage/index.php?mode=script");
} else {
	alertback("디비 오류 발생");
}






?>