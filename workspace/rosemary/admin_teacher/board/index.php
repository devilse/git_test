<?
include "../../_lib/function.php";	// 관리자 페이지 공용 함수 파일
include "../../_lib/db_conn.php";	// 디비 접속	
include "../../_lib/global.php";	// 관리자 페이지 공용 변수 파일
include "../../_lib/lib.php";	

$User_Info =  LOGIN_CHK($_COOKIE[LIPASS_ID]);
auth_block($User_Info['type'], "T");

$current_menu_code = "03";			// 현재메뉴 코드 - 선택된 메뉴를 표시하기 위해서 필요함.
?>

<?include "../include/head.php";?>

게시판 관리

<?include "../include/copyright.php";?>