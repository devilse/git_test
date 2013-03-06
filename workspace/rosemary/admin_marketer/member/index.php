<?
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
header('Content-Type: text/html;charset=utf-8');

include "../../_lib/function.php";	// 관리자 페이지 공용 함수 파일
include "../../_lib/db_conn.php";	// 디비 접속	
include "../../_lib/global.php";	// 관리자 페이지 공용 변수 파일
include "../../_lib/lib.php";	

$mode = $_GET['mode'];

$current_menu_code = "01";			// 현재메뉴 코드 - 선택된 메뉴를 표시하기 위해서 필요함.

$User_Info =  LOGIN_CHK($_COOKIE[LIPASS_ID]);
$mb_type = $User_Info['type'];
if ($User_Info[0] != "M") {
	alertGo("", "/");
}


switch ($mode) {

	case 'fast' :					// 게시판 뷰 
		$current_menu_code = "010102";
		$includeStr = "./fast_list.php";
	break;	

	default :
		$current_menu_code = "010101";
		$includeStr = "./member.php";
	break;
}		

 include "../include/head.php";
 include $includeStr;
 include "../include/copyright.php";
?>