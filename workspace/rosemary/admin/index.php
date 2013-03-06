<?php
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
header('Content-Type: text/html;charset=utf-8');


include "../_lib/function.php";	// 관리자 페이지 공용 함수 파일
include "../_lib/db_conn.php";	// 디비 접속	
include "../_lib/global.php";	// 관리자 페이지 공용 변수 파일	
include "../_lib/lib.php";	

$User_Info =  LOGIN_CHK($_COOKIE[LIPASS_ID]);
auth_block($User_Info['type'], "A");

$current_menu_code = "main";			// 현재메뉴 코드 - 선택된 메뉴를 표시하기 위해서 필요함.
?>

<?php include "./include/head.php";?>

관리자 메인입니다.

<?php include "./include/copyright.php";?>