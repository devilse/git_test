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
include "../../_lib/board.class.php";

$mode = $_GET['mode'];
if (!empty($_GET['bo_num'])) {
	$bo_num = $_GET['bo_num'];		// 게시판 번호
}


$current_menu_code = "02";			// 현재메뉴 코드 - 선택된 메뉴를 표시하기 위해서 필요함.

$User_Info =  LOGIN_CHK($_COOKIE[LIPASS_ID]);
$mb_type = $User_Info['type'];
if ($User_Info[0] != "M") {
	alertGo("", "/");
}


switch ($mode) {

	case 'board_view' :					// 게시판 뷰 
		$current_menu_code = "020101";
		$includeStr = "../../admin/board/board_view.php";
	break;	

	case 'board_list' :	
		$current_menu_code = "020101";// 게시판 리스트 
		$includeStr = "../../admin/board/board_list.php";
	break;	

	case 'board_write' :				// 게시물 작성 페이지 
		$current_menu_code = "020101";
		$write_mode = $_GET['write_mode'];
		if ($write_mode == "modi") {
		} else if($write_mode == "reply") {
			$set_chk = Set_Chk("set_reply");
			if ($set_chk != "Y") {
				alertback("답글 권한이 없습니다.");
			}
		} else {
			$set_chk = Set_Chk("set_write");
			if ($set_chk != "Y") {
				alertback("쓰기 권한이 없습니다.");
			}
		}
		$includeStr = "../../admin/board/board_write.php";
	break;	


	default :

		$mode = "board_list";
		$_GET['bo_num'] = "69624";	
		$current_menu_code = "020101";
		$includeStr = "../../admin/board/board_list.php";
	break;
}		

 include "../include/head.php";
 include $includeStr;
 include "../include/copyright.php";
?>