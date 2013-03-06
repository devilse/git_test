<?php
header('Content-Type: text/html;charset=utf-8');

include "../../../_lib/db_conn.php";	// 디비 접속
include "../../../_lib/global.php";
include "../../../_lib/function.php";
include "../../../_lib/lib.php";

$User_Info	 =  Login_Chk($_COOKIE['LIPASS_ID']);			// 로그인 정보 가져오기
$mb_type	 = $User_Info['type'];							// 유저 타입



$member_type_sel_query = @mysqli_query($CONN['rosemary'],"select mt_code from member_type");	
$member_type_nums = @mysqli_num_rows($member_type_sel_query);					
if (!$member_type_nums) {
	$t_chk = false;
	$err_msg = "회원 종류를 가져올 수 없습니다.";			
}else {

	$t_chk = true;	//쿼리 이상유무 체크 변수 
	mysqli_query($CONN['rosemary'],"set autocommit = 0;");
	mysqli_query($CONN['rosemary'],"begin;");


	while ($member_type_rs = mysqli_fetch_array($member_type_sel_query)) {
		$mt_code = $member_type_rs['mt_code'];
		$set_mt_code = $_POST[$mt_code.'_set_mt_code'];			// 사용자 코드 - 해당 변수의 값이 member_type 의 mt_code 값중 하나가 되어야 한다. 그럴일은 없겠지만 혹시 비어있다면 아무런 업데이트도 일어나지 않는다.
		if ($set_mt_code || !empty($set_mt_code)) {
			$user_set_access = $_POST[$mt_code.'_access'];		// 접속권한 
			$user_set_write = $_POST[$mt_code.'_write'];		// 쓰기권한
			$user_set_view = $_POST[$mt_code.'_view'];			// 보기권한
			$user_set_modi = $_POST[$mt_code.'_modi'];			// 수정권한
			$user_set_del = $_POST[$mt_code.'_del'];			// 삭제권한	
			$user_set_reply = $_POST[$mt_code.'_reply'];		// 답글권한

		
			if ($user_set_access != "Y") $user_set_access = "N";
			if ($user_set_write != "Y") $user_set_write = "N";
			if ($user_set_view != "Y") $user_set_view = "N";
			if ($user_set_modi != "Y") $user_set_modi = "N";
			if ($user_set_del != "Y") $user_set_del = "N";
			if ($user_set_reply != "Y") $user_set_reply = "N";


			$board_us_update_query = @mysqli_query($CONN['rosemary'],"
				update 
						qna_user_set 
				 set
						set_access = '$user_set_access',
						set_write = '$user_set_write',
						set_view = '$user_set_view',
						set_modi = '$user_set_modi',
						set_del = '$user_set_del',
						set_reply = '$user_set_reply'
				 where
						mt_code = '$mt_code'
			");
			if (!$board_us_update_query) {
				$t_chk = false;
				$err_msg = "게시판 회원 설정 업데이트 중 오류가 발생 하였습니다.";
			}
		}

	}

	if ($t_chk != true) {
		mysqli_query($CONN['rosemary'],"rollback;");
		echo "X|".$err_msg;
	} else {
		mysqli_query($CONN['rosemary'],"commit;");	
		echo "T|";
	}	


}
?>