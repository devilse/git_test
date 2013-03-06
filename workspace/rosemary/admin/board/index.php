<?php
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

$User_Info =  Login_Chk($_COOKIE['LIPASS_ID']);
$mb_type = $User_Info['type'];
if ($mb_type != "A") {
	alertGo("", "/");
}

$mode = $_GET['mode'];
if (!empty($_GET['bo_num'])) {
	$bo_num = $_GET['bo_num'];		// 게시판 번호
}
$menu_mode_array = explode("_",$mode);


switch ($mode) {

	case 'bbs_set' :					// 게시판 게시물 관리
		$current_menu_code = "030101";
		$includeStr = "./board_tot.php";
	break;	

	case 'board_set' :					// 게시판 기능 관리
		$current_menu_code = "030103";
		$includeStr = "./board_set.php";
	break;			

	case 'bbs_detail' :				// 게시판 상세 설정 
		$current_menu_code = "030101";
		$includeStr = "./board_detail.php";
	break;	

	case 'board_list' :					// 게시판 리스트 
		$current_menu_code = "030102";
		if (!empty($_GET['sub_menu_num'])) {
			$current_menuIdx = $_GET['sub_menu_num'];
		}
		$includeStr = "./board_list.php";
	break;	

	case 'board_view' :					// 게시판 뷰 

		if (!empty($_GET['sub_menu_num'])) {
			$current_menuIdx = $_GET['sub_menu_num'];
		} else {
			$current_menu_code = "03";
		}
		$includeStr = "./board_view.php";
	break;	

	case 'board_write' :				// 게시물 작성 페이지 
		if (!empty($_GET['sub_menu_num'])) {
			$current_menuIdx = $_GET['sub_menu_num'];
		}
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
		$includeStr = "./board_write.php";
	break;	

	case 'g_board_set' :				// 게시물 작성 페이지 
		$includeStr = "./g_board_set.php";
	break;	

	case 'qna_set' :
		$current_menu_code = "030102";
		$includeStr = "./qna_set.php";
	break;

	case 'qna_list' :
		$current_menu_code = "030301";
		$set_chk = Set_Qna_Chk("set_access,set_write");
		if($set_chk['set_access'] != "Y") alertback("접근 권한이 없습니다.");
		$includeStr = "./qna_list.php";
	break;

	case 'qna_write' :
		$current_menu_code = "030301";
		$set_chk = Set_Qna_Chk("set_access,set_write");
		if($set_chk['set_access'] != "Y" && $set_chk['set_write'] != "Y") alertback("접근 권한이 없습니다.");
		$includeStr = "./qna_write.php";
	break;

	case 'qna_view' :
		$current_menu_code = "030301";
		$set_chk = Set_Qna_Chk("set_access,set_view,set_reply,set_del,set_modi");
		if($set_chk['set_access'] != "Y" && $set_chk['set_view'] != "Y") alertback("접근 권한이 없습니다.");
		$includeStr = "./qna_view.php";
	break;

	case 'faq' :
		$current_menu_code = "030302";
		$includeStr = "./faq.php";
	break;

	case 'faq_write' :
		$current_menu_code = "030302";
		$includeStr = "./faq_write.php";
	break;




	default :
		$current_menu_code = "030101";
		$includeStr = "./board_set.php";
	break;
}		

 include "../include/head.php";
 include $includeStr;
 include "../include/copyright.php";
 
 ?>