<?php
header('Content-Type: text/html;charset=utf-8');
	
include "../../../_lib/function.php";	// 관리자 페이지 공용 함수 파일
include "../../../_lib/db_conn.php";	// 디비 접속
	

		
$bo_num = $_POST['bo_num'];														// 게시판 일련번호
$bo_name = addslashes(trim($_POST['bo_name']));						// 게시판 이름
$set_use = $_POST['set_use'];														// 게시판 사용유무
$set_show = $_POST['set_show'];													// 리스트 노출 수
$set_title_length = $_POST['set_title_length'];									// 리스트 길이
$board_skin = $_POST['board_skin'];												// 게시판 스킨
$list_mal = addslashes(trim($_POST['list_mal']));					// 꼬리글
$head_title = addslashes(trim($_POST['head_title']));					// 사이트 설명
$end_title = addslashes(trim($_POST['end_title']));					// 꼬리글

$set_comment = $_POST['set_comment'];												// 댓글 기능 사용유무
$set_reply = $_POST['set_reply'];													// 답글 기능 사용유무
$set_secret = $_POST['set_secret'];												// 비밀글 기능 사용유무	

$set_file = $_POST['set_file'];													// 첨부파일 기능 사용유무
$set_file_max = $_POST['set_file_max'];											// 첨부파일 최대 제한 용량 

$set_recom = $_POST['set_recom'];													//추천기능 사용여부
$set_scrap = $_POST['set_scrap'];													//스크랩 사용여부
$set_img =  $_POST['set_img'];													//스크랩 사용여부
$list_state =  $_POST['set_list_state'];										//리스트 형식


if ($set_use != "Y") {
	$set_use = "N";
}
if ($set_comment != "Y") {
	$set_comment = "N";
}
if ($set_reply != "Y") { 
	$set_reply = "N";
}
if ($set_secret != "Y") {
	$set_secret = "N";
}
if ($set_file != "Y") {
	$set_file = "N";
}
if ($set_img != "Y") {
	$set_img = "N";
}
if (!$list_state) {
	$list_state = "B";	//기본형
}
if (!$bo_num) {
	alert("접근할 수 없습니다.");
}
if (!$bo_name) {
	alert("게시판명을 입력해주세요.");
}

$t_chk = true;	//쿼리 이상유무 체크 변수 
mysqli_query($CONN['rosemary'],"set autocommit = 0;");
mysqli_query($CONN['rosemary'],"begin;");
	


$board_update_query = @mysqli_query($CONN['rosemary'],"
				update 
						board 
				set
						bo_name = '$bo_name',
						bo_skin = '$board_skin',
						set_show = '$set_show',
						set_title_length = '$set_title_length',
						set_comment = '$set_comment',
						set_reply = '$set_reply',
						set_secret = '$set_secret',
						set_file = '$set_file',
						set_file_max = '$set_file_max',
						head_title = '$head_title',
						end_title = '$end_title',
						set_use = '$set_use',
						set_recom = '$set_recom',
						set_scrap = '$set_scrap',
						set_img = '$set_img',
						bo_list_state = '$list_state',
						list_mal = '$list_mal'

				where		
						bo_num = '$bo_num'
				");




if (!$board_update_query) {
	$t_chk = false;
	$err_msg = "게시판 업데이트 중 오류가 발생 하였습니다.";
}else {
	// 해당 테이블을 쿼리하는 이유는 member_type 필드수에 맞춰 while문을 돌리기 위해서 가져오는거임. 만약 회원 종류가 추가되거나 삭제 되었을때 해당 row 만큼 데이터가 노출 및 업데이트 된다.
	$member_type_sel_query = @mysqli_query($CONN['rosemary'],"select mt_code from member_type");	
	$member_type_nums = @mysqli_num_rows($member_type_sel_query);					
	if (!$member_type_nums) {
		$t_chk = false;
		$err_msg = "회원 종류를 가져올 수 없습니다.";			
	}else {
		while ($member_type_rs = mysqli_fetch_array($member_type_sel_query)) {
			$mt_code = $member_type_rs['mt_code'];
			$set_mt_code = $_POST[$mt_code.'_set_mt_code'];		// 사용자 코드 - 해당 변수의 값이 member_type 의 mt_code 값중 하나가 되어야 한다. 그럴일은 없겠지만 혹시 비어있다면 아무런 업데이트도 일어나지 않는다.
			if ($set_mt_code || !empty($set_mt_code)) {
				$user_set_access = $_POST[$mt_code.'_access'];		// 접속권한 
				$user_set_write = $_POST[$mt_code.'_write'];		// 쓰기권한
				$user_set_view = $_POST[$mt_code.'_view'];			// 보기권한
				$user_set_modi = $_POST[$mt_code.'_modi'];			// 수정권한
				$user_set_del = $_POST[$mt_code.'_del'];			// 삭제권한	
				$user_set_comment = $_POST[$mt_code.'_comment'];	// 댓글권한
				$user_set_reply = $_POST[$mt_code.'_reply'];		// 답글권한
				$user_set_secret = $_POST[$mt_code.'_secret'];		// 비밀글권한	
				$user_set_file = $_POST[$mt_code.'_file'];			// 파일첨부권한
				$user_set_recom = $_POST[$mt_code.'_recom'];		// 추천
				$user_set_scrap = $_POST[$mt_code.'_scrap'];		// 스크랩
				$user_set_down = $_POST[$mt_code.'_down'];			// 파일첨부다운로드권한
				$user_set_secret_view = $_POST[$mt_code.'_secret_view'];		// 비밀글보기
				$user_set_admin = $_POST[$mt_code.'_admin'];		// 조회,날짜변경
			
				if ($user_set_access != "Y") $user_set_access = "N";
				if ($user_set_write != "Y") $user_set_write = "N";
				if ($user_set_view != "Y") $user_set_view = "N";
				if ($user_set_modi != "Y") $user_set_modi = "N";
				if ($user_set_del != "Y") $user_set_del = "N";
				if ($user_set_comment != "Y") $user_set_comment = "N";
				if ($user_set_reply != "Y") $user_set_reply = "N";
				if ($user_set_secret != "Y") $user_set_secret = "N";
				if ($user_set_file != "Y") $user_set_file = "N";
				if ($user_set_recom != "Y") $user_set_recom = "N";
				if ($user_set_scrap != "Y") $user_set_scrap = "N";
				if ($user_set_down != "Y") $user_set_down = "N";
				if ($user_set_secret_view != "Y") $user_set_secret_view = "N";
				if ($user_set_admin != "Y") $user_set_admin = "N";

				$board_us_update_query = @mysqli_query($CONN['rosemary'],"
					update 
							board_user_set 
					 set
							set_access = '$user_set_access',
							set_write = '$user_set_write',
							set_view = '$user_set_view',
							set_modi = '$user_set_modi',
							set_del = '$user_set_del',
							set_comment = '$user_set_comment',
							set_reply = '$user_set_reply',
							set_secret = '$user_set_secret',
							set_file = '$user_set_file',
							set_recom = '$user_set_recom',
							set_scrap = '$user_set_scrap',
							set_down = '$user_set_down',
							set_secret_view = '$user_set_secret_view',
							set_admin = '$user_set_admin'
					 where
							bo_num = '$bo_num' and
							mt_code = '$mt_code'
				");
				if (!$board_us_update_query) {
					$t_chk = false;
					$err_msg = "게시판 회원 설정 업데이트 중 오류가 발생 하였습니다.";
				}
			}
		}
	}
}


if ($t_chk != true) {
	mysqli_query($CONN['rosemary'],"rollback;");
	alert($err_msg);
} else {
	mysqli_query($CONN['rosemary'],"commit;");	
	alert("게시판 설정이 변경 되었습니다.");
}



?>