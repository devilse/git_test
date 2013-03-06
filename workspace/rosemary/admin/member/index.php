<?php
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
header('Content-Type: text/html;charset=utf-8');

include "../../_lib/function.php";	// 관리자 페이지 공용 함수 파일
include "../../_lib/db_conn.php";	// 디비 접속	
include "../../_lib/global.php";	// 관리자 페이지 공용 변수 파일	
include "../../_lib/lib.php";	

$User_Info =  LOGIN_CHK($_COOKIE[LIPASS_ID]);
auth_block($User_Info['type'], "A");

$mode = $_GET['mode'];

switch ($mode) {

	case 'student' :							// 학습자
		$current_menu_code = "020101";
		$includeStr = "./student.php";
	break;
	
	case 'teacher' :							// 교수자
		$current_menu_code = "020102";
		$includeStr = "./student.php";
	break;			

	case 'marketer' :							// 영업자
		$current_menu_code = "020103";
		$includeStr = "./student.php";
	break;			

	case 'admin' :								// 관리자
		$current_menu_code = "020104";
		$includeStr = "./student.php";
	break;			

	case 'login_log' :								// 로긴 로그
		$current_menu_code = "020201";
		$includeStr = "./login_log.php";
	break;	



	default :
		$current_menu_code = "02";
		$includeStr = "./student.php";
	break;
}


include "../include/head.php";
include $includeStr;
include "../include/copyright.php";
?>

