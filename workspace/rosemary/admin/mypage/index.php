<?
include "../../_lib/function.php";	// 관리자 페이지 공용 함수 파일
include "../../_lib/db_conn.php";	// 디비 접속	
include "../../_lib/global.php";	// 관리자 페이지 공용 변수 파일
include "../../_lib/lib.php";	

$User_Info =  LOGIN_CHK($_COOKIE[LIPASS_ID]);
auth_block($User_Info['type'], "A");

$current_menu_code = "06";			// 현재메뉴 코드 - 선택된 메뉴를 표시하기 위해서 필요함.

$User_Info =  Login_Chk($_COOKIE['LIPASS_ID']);
$mb_type = $User_Info['0'];
if ($mb_type != "A") {
	alertGo("",$MY_URL."admin/admin_login.php");
}

$mode = $_GET['mode'];



switch ($mode) {

	case 'pwd_set' :					// 비밀번호 변경
		$current_menu_code = "060102";
		$includeStr = "./pwd_set.php";
	break;	

	case 'login_log' :					// 로그인 로그
		$current_menu_code = "060103";
		$includeStr = "./login_log.php";
	break;	

	default :
		$current_menu_code = "060101";
		$includeStr = "./my_info.php";
	break;
}		

 include "../include/head.php";
 include $includeStr;
 include "../include/copyright.php";
?>