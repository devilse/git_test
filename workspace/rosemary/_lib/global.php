<?php
// 사이트 공용 변수 

$DOCUMENT_ROOT = $_SERVER["DOCUMENT_ROOT"];		// 홈디렉토리

$MY_HOST =  $_SERVER["HTTP_HOST"];
$MY_URL = "http://$MY_HOST/";	 		
 
$dir_img = $DOCUMENT_ROOT."/dir_img";	//실제 이미지 디렉토리
$dir_file = $DOCUMENT_ROOT."/dir_file";		// 실제 파일 저장 디렉토리
$dir_img_tmp = $DOCUMENT_ROOT."/dir_img_tmp";	//임시 이미지 디렉토리


//페이지 처리 공용 프로세스 파일 위치
$board_process_url =  $MY_URL."_process/board";	//아직스 처리 때문에 절대 경로를 사용하지 못함. 
$qna_process_url =  $MY_URL."_process/qna";	//아직스 처리 때문에 절대 경로를 사용하지 못함. 

// 페이징 변수 
$page = $_GET[page];
if(empty($page)) $page = 1;
$num_per_page = 10;
$num_per_block = 20;
$first = $num_per_page * ($page - 1);
$limit = "limit $first, $num_per_page";


// 접속 아이피	
$host_ip = $_SERVER['REMOTE_ADDR']; 	

// 현재 접속한 메뉴
$current_menu_code = "";
$current_menuIdx = "";

include $DOCUMENT_ROOT."/_autocode/siteinfo.php";	// 사이트 정보
include $DOCUMENT_ROOT."/_autocode/siteoption.php";	// 사이트 옵션
?>