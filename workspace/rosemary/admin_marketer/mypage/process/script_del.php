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

$del_num = $_GET['del_num'];
$mb_num =  $User_Info['member_num'];


if (!$mb_num || !$del_num) {
	alertback("접근 할 수 없습니다.");
}

//자신의 스크립트가 맞는지 확인한다.
$my_script_qry = mysqli_query($CONN['rosemary'],"select mbs_num from member_marketer_script where mb_num = '$mb_num' and mbs_num = '$del_num'");
$my_script_nums = mysqli_num_rows($my_script_qry);

if ($my_script_nums) {
	$script_del_qry = mysqli_query($CONN['rosemary'],"delete from member_marketer_script where mb_num = '$mb_num' and mbs_num = '$del_num'");
	if ($script_del_qry) {
		alertGo("","http://localhost/admin_marketer/mypage/index.php?mode=script");
	} else {
		alertback("삭제시 디비 오류 발생");
	}
} else {
	alertback("접근 할 수 없습니다.");
}



//$script_del_qry = mysqli_query("delete from ");






?>