<?php
header('Content-Type: text/html;charset=utf-8');

include "../../_lib/db_conn.php";	// 디비 접속
include "../../_lib/global.php";
include "../../_lib/function.php";	// 관리자 페이지 공용 함수 파일
include "../../_lib/lib.php";		// 관리자 페이지 공용 함수 파일

$list_num	= $_POST['list_num'];		// 리스트번호
$bo_num		= $_POST['bo_num'];			// 게시판번호
$User_Info =  Login_Chk($_COOKIE['LIPASS_ID']);	// 로그인 체크
$mb_type	= $User_Info['type'];		// 유저타입

if ($mb_type != "G") {
	$mb_id = $User_Info['id'];		// 유저아이디
}

$set_use_chk = Set_Chk("set_scrap");	//스크랩권한



if (!$mb_id) {
	echo "X|로그인이 필요 합니다.";
	exit;
}


if ($set_use_chk['set_scrap'] != "Y") {
	echo "X|스크랩할 수 있는 권한이 없습니다.";
	exit;
}


if (!$list_num) {
	echo "X|접근 할 수 없습니다.";
	exit;
}else{
	
	//스크랩 할 해당 글이 존재 하는지 먼저 체크 한다.
	$list_query = mysqli_query($CONN['rosemary'],"select * from board_list where list_num = '$list_num'");
	$list_nums = mysqli_num_rows($list_query);
	if (!$list_nums) {
		echo "X|삭제 되었거나 존재하지 않는 글 입니다.";
		exit;
	}else {
		//이미 스크랩한 글인지 먼저 체크 하고 하지 않았다면 인설트 ㄱㄱ
		$chk_query = mysqli_query($CONN['rosemary'],"select * from board_scrap where mb_id = '$mb_id' and list_num = '$list_num'");
		$chk_nums = mysqli_num_rows($chk_query);
		if ($chk_nums) {
			echo "X|이미 스크랩한 글 입니다.";
			exit;				
		}else {
			$scrap_in_qry = mysqli_query($CONN['rosemary'],"insert into board_scrap(list_num,mb_id,reg_date,user_ip) values('$list_num','$mb_id',unix_timestamp(),'$host_ip')");
			if (!$scrap_in_qry) {
				echo "X|DB 업데이트 실패.";
			}else {
				echo "T|스크랩 하였습니다.";
			}
		}
	}

}





?>