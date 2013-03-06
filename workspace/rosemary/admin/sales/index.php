<?
include "../../_lib/function.php";	// 관리자 페이지 공용 함수 파일
include "../../_lib/db_conn.php";	// 디비 접속	
include "../../_lib/global.php";	// 관리자 페이지 공용 변수 파일
include "../../_lib/lib.php";	

$User_Info =  LOGIN_CHK($_COOKIE[LIPASS_ID]);
auth_block($User_Info['type'], "A");

$mode = $_GET['mode'];

switch ($mode) {
	case 'ordersheet' :								// 주문서	
	default :
		$current_menuIdx = "501";
		$includeStr = "./ordersheet.php";
		break;
	case 'ordersheet_view' :						// 주문서 보기	
		$current_menuIdx = "501";
		$includeStr = "./ordersheet_view.php";
		break;
	case 'refund' :									// 환불 목록
		$current_menuIdx = "502";
		$includeStr = "./refund.php";
		break;
	case 'refund_detail' :							// 환불 상세
		$current_menuIdx = "502";
		$includeStr = "./refund_detail.php";
		break;
}

include "../include/head.php";
include $includeStr;
include "../include/copyright.php";
?>