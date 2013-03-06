<?
include "../../_lib/function.php";	// 관리자 페이지 공용 함수 파일
include "../../_lib/db_conn.php";	// 디비 접속	
include "../../_lib/global.php";	// 관리자 페이지 공용 변수 파일
include "../../_lib/lib.php";	

$User_Info =  LOGIN_CHK($_COOKIE[LIPASS_ID]);
auth_block($User_Info['type'], "M");

$mode = $_GET['mode'];

$current_menu_code = "05";			// 현재메뉴 코드 - 선택된 메뉴를 표시하기 위해서 필요함.

switch ($mode) {

	case 'pwd_set' :					// 비밀번호 변경
		$current_menu_code = "050102";
		$includeStr = "./pwd_set.php";
	break;	

	case 'script' :					// 스크립트 관리
		$current_menu_code = "050103";
		$includeStr = "./script_set.php";
	break;	




	default :
		$current_menu_code = "050101";
		$includeStr = "./my_info.php";
	break;
}		

 include "../include/head.php";
 include $includeStr;
 include "../include/copyright.php";
?>