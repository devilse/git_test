<?php
include "../../../_lib/function.php";
include "../../../_lib/db_conn.php";
include "../../../_lib/global.php";
include "../../../_lib/lib.php";

$mb_num = $_GET['mcd'];
$msc_uniqid = $_GET['ucd'];

$confirm_query = mysqli_query($CONN['rosemary'], "SELECT * FROM member_student a INNER JOIN member_student_confirm_email b ON a.mb_num = b.mb_num WHERE a.mb_num = '$mb_num' AND a.ms_email_confirm_yn = 'N' AND b.msc_confirm_yn = 'N' AND msc_uniqid = '$msc_uniqid'");
if(mysqli_num_rows($confirm_query) == 0) {
	alertGo("이메일 승인이 완료 되었거나 잘못된 접근입니다.", "../../main/index.php");
	exit;
} else {
	$confirm_rs = mysqli_fetch_array($confirm_query);
	$email = $confirm_rs['msc_email'];
	
	mysqli_query($CONN['rosemary'],"set autocommit = 0;");
	mysqli_query($CONN['rosemary'],"begin;");
	
	$result = false;
	if(mysqli_query($CONN['rosemary'], "UPDATE member_student_confirm_email SET msc_confirmdate = ".mktime().", msc_confirm_yn = 'Y' WHERE msc_uniqid = '$msc_uniqid'")) {
		if(mysqli_query($CONN['rosemary'], "UPDATE member_student SET ms_email_confirm_yn = 'Y' WHERE mb_num = '$mb_num'")) {
			if(mysqli_query($CONN['rosemary'], "UPDATE member SET mb_email = '$email' WHERE mb_num = '$mb_num'")) {
				$result = true;
			}
		}
	}
	
	if($result == true) {		
		mysqli_query($CONN['rosemary'], "commit;");
		alertGo("", "../joinconfirm.php?mcd=$mb_num");
	} else {
		$error = mysqli_error($CONN['rosemary']);
		mysqli_query($CONN['rosemary'], "rollback;");
		alertGo($error, "../../main/index.php");
	}
}
?>