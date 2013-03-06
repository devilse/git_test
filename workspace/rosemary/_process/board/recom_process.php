<?php
header('Content-Type: text/html;charset=utf-8');

include "../../_lib/db_conn.php";	// 디비 접속
include "../../_lib/global.php";
include "../../_lib/function.php";	// 관리자 페이지 공용 함수 파일
include "../../_lib/lib.php";	// 관리자 페이지 공용 함수 파일



$list_num	= $_POST['list_num'];	// 리스트번호
$bo_num		= $_POST['bo_num'];		// 게시판번호
$User_Info	=  Login_Chk($_COOKIE['LIPASS_ID']); //로그인 체크
$mb_type	= $User_Info['type'];	// 유저타입				

if ($mb_type != "G") {
	$mb_id = $User_Info['id'];	// 유저아이디
}

$set_use_chk = Set_Chk("set_recom");	//추천 권한 체크

if ($set_use_chk['set_recom'] != "Y") {
	echo "X|추천 할 수 있는 권한이 없습니다.";
	exit;
}

if (!$mb_id) {
	echo "X|로그인이 필요 합니다.";
	exit;
}


if (!$list_num) {
	echo "X|접근 할 수 없습니다.";
	exit;
}else{
// 해당 게시글을 추천을 했는지 체크 한다. - 현재 		
	$chk_query = mysqli_query($CONN['rosemary'],"select count(*) as cnt from board_recom_log where list_num = '$list_num' and mb_id = '$mb_id'");
	$chk_cnt = mysqli_result($chk_query,0,0);
	if ($chk_cnt > 0) {
		echo "X|이미 해당 게시물에 추천을 하였습니다.";
		exit;
	}else{
		$t_chk = true;	
		mysqli_query($CONN['rosemary'],"set autocommit = 0;");
		mysqli_query($CONN['rosemary'],"begin;");
		$chk_update = mysqli_query($CONN['rosemary'],"update board_list set recom_cnt = recom_cnt + 1 where list_num = '$list_num'");
		if (!$chk_update) {
				$t_chk = false;
				$err_msg = "디비 업데이트 실패";	
		}else{
			$chk_log_in = mysqli_query($CONN['rosemary'],"insert into board_recom_log(list_num,mb_id,reg_date,user_ip) values('$list_num','$mb_id',unix_timestamp(),'$host_ip')");
			if (!$chk_log_in) {
				$t_chk = false;
				$err_msg = "디비 업데이트 실패";	
			}
		}
			if ($t_chk != true) {
				mysqli_query($CONN['rosemary'],"rollback;");
				echo "X|".$err_msg;
			}else{
				echo "T|추천을 하였습니다.";
				mysqli_query($CONN['rosemary'],"commit;");	
			}

		

	}
}





?>