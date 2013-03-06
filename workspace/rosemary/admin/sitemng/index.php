<?
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
header('Content-Type: text/html;charset=utf-8');

include "../../_lib/function.php";	// 관리자 페이지 공용 함수 파일
include "../../_lib/db_conn.php";	// 디비 접속	
include "../../_lib/global.php";	// 관리자 페이지 공용 변수 파일
include "../../_lib/lib.php";	
include "../../gmEditor/func_editor.php";

$User_Info =  LOGIN_CHK($_COOKIE[LIPASS_ID]);
auth_block($User_Info['type'], "A");

$current_menu_code = "01";			// 현재메뉴 코드 - 선택된 메뉴를 표시하기 위해서 필요함.
$mode = $_GET['mode'];
?>



<?php
	switch ($mode) {

		case 'information' :							// 기본설정
			$current_menu_code = "010101";
			$includeStr = "./information.php";
		break;
		
		case 'privacy' :							
			$current_menu_code = "010103";
			$includeStr = "./privacy.php";					//개인정보
		break;			

		case 'privacy_write' :	
			$current_menu_code = "010103";
			$includeStr = "./privacy_write.php";						//개인정보
		break;	


		case 'clause' :	
			$current_menu_code = "010102";
			$includeStr = "./clause.php";						//이용약관
		break;			

		case 'clause_write' :	
			$current_menu_code = "010102";
			$includeStr = "./clause_write.php";						//이용약관
		break;	


		case 'account' :	
			$current_menu_code = "010104";
			$includeStr = "./account.php";					//계좌번호
		break;			
		
		case 'pg' :
			$current_menuIdx = 105;
			$includeStr = "./pg.php";						// 전자결제 설정
		break;
		
		case 'meta' :
			$current_menuIdx = 107;
			$includeStr = "./meta.php";						// 전자결제 설정
			break;

		case 'etc' :
			$current_menuIdx = 106;
			$includeStr = "./etc.php";						// 기타옵션 설정
		break;
		
		case 'analytics' :
			$current_menuIdx = 131;
			$includeStr = "./analytics.php";						// 접속통계 확인
		break;
		
		default :
			$current_menu_code = "010101";
			$includeStr = "./information.php";
		break;
	}

?>

<?php include "../include/head.php";?>
<?php include $includeStr;?>
<?php include "../include/copyright.php";?>