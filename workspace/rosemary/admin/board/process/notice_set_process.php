<?php
header('Content-Type: text/html;charset=utf-8');

include "../../../_lib/db_conn.php";	// 디비 접속
include "../../../_lib/global.php";
include "../../../_lib/function.php";	// 관리자 페이지 공용 함수 파일
include "../../../_lib/lib.php";		// 관리자 페이지 공용 함수 파일

$notice_show_mode	= $_POST['notice_show_mode'];		// 리스트번호
$list_num	= $_POST['notice_show_num'];		// 리스트번호
$User_Info =  Login_Chk($_COOKIE['LIPASS_ID']);	// 로그인 체크
$mb_type	= $User_Info['type'];		// 유저타입
$mb_id = $User_Info['id'];		// 유저아이디

if (!$mb_id) {
	echo "X|로그인이 필요 합니다.";
	exit;
}


if (!$list_num || !$notice_show_mode) {
	echo "X|접근 할 수 없습니다.";
	exit;
}else{
	$notice_qry = mysqli_query($CONN['rosemary'],"update board_list set notice_show = '$notice_show_mode' where list_num = '$list_num'");	
	if($notice_qry){
		echo "T|스크랩 하였습니다.";
	}else{
		echo "X|DB 업데이트 실패.";
	}
}





?>