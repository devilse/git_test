<?php
header('Content-Type: text/html;charset=utf-8');

include "../../_lib/db_conn.php";	// 디비 접속
include "../../_lib/global.php";
include "../../_lib/function.php";
include "../../_lib/lib.php";	// 관리자 페이지 공용 함수 파일


$bo_num		= $_POST['bo_num'];					// 게시판번호	
$list_num	= $_POST['list_num'];				// 리스트번호
$list_page	= $_POST['list_page'];				// 리스트 페이징 번호
$page		= $_POST['page'];					// 게시판 페이징 번호
$key		= $_POST['key'];						// 검색유형
$searchword = $_POST['searchword'];				// 검색어
$now_page	= $_POST['now_page'];				// 처리 끝나고 보낼 페이지 유형

if ($now_page == "user") {
	$move_page = "../../web/board/index.php";
} else {
	$move_page = "../../admin/board/index.php";
}

if (!$bo_num) {
	alertback("접근 할 수 없습니다.");
}
if (!$list_num) {
	alertback("접근 할 수 없습니다.");
}

$User_Info	=  Login_Chk($_COOKIE['LIPASS_ID']);	// 로그인체크
$mb_type	= $User_Info['type'];					// 유저타입

if ($User_Info['type'] != "G") {
	$user_id = $User_Info['id'];					// 유저아이디
} else {
	// 비회원이 삭제를 요청할 경우 해당 비밀번호가 일치한지 체크 한다.
	$guest_pwd = $_POST['guest_pwd'];
	if (!$guest_pwd) {
		alertback("비밀번호를 입력해 주세요.");
	}
}

$set_use_chk = Set_Chk("set_del");				// 삭제권한 체크

if ($set_use_chk['set_del'] != "Y") {
	// 자신의 글이라면 권한에 상관없이 삭제된다.
	if ($User_Info['type'] != "G") {
		$chk_query = mysqli_query($CONN['rosemary'],"select list_num from board_list where list_num = '$list_num' and mb_id = '$user_id'");
		$chk_nums = @mysqli_num_rows($chk_query);
		if (!$chk_nums) {
			alertback("삭제 권한이 없습니다.");
		}
	} else {
		$guest_pwd = md5(md5($guest_pwd));
		$chk_query = mysqli_query($CONN['rosemary'],"select list_num from board_list where list_num = '$list_num' and mb_password = '$guest_pwd'");
		$chk_nums = @mysqli_num_rows($chk_query);
		if (!$chk_nums) {
			alertback("비밀번호가 일치하지 않습니다.");
		}

	}

}	

// 먼저 삭제될 글에 첨부된 이미지와 파일이 있는지 체크후 있다면 이미지와 파일부터 삭제 한다.

$list_query = mysqli_query($CONN['rosemary'],"select img_chk,file_chk,seq,ref from board_list where list_num = '$list_num'");
$list_rs = mysqli_fetch_array($list_query);
$list_seq = $list_rs['seq'];		// 계층형 글 그룹 번호

if ($list_rs['img_chk'] == "Y") { //이미지 삭제한다.
	$con_query = mysqli_query($CONN['rosemary'],"select contents from board_contents where list_num = '$list_num'");
	$con = mysqli_result($con_query,0,0);
	$con_img = explode("_tmp_e_",$con);
	$con_end_for = count($con_img);
	$del_img_array = array();
	for ($i=0;$i<$con_end_for;$i++) {
		$contents_img2 = explode("_tmp_s_",$con_img[$i]);
			if ($contents_img2[1] != "" || !empty($contents_img2[1]) ) {
				$upfile = "_tmp_s_".$contents_img2[1]."_tmp_e_";
				@unlink($dir_img.'/'.$upfile);
			}
	}
}
	
if ($list_rs['file_chk'] == "Y") {	// 파일 삭제한다.
	$file_query = mysqli_query($CONN['rosemary'],"select * from board_file where list_num = '$list_num'");
	$file_nums = mysqli_num_rows($file_query);
	if ($file_nums) {
		while($file_rs = mysqli_fetch_array($file_query)) {
			$upfile = $file_rs['file_tmp_name'];
			@unlink($dir_file.'/'.$upfile);
		}
	}
}


// 게시판 연관 자식테이블을 다 연동 되어 있기 때문에 부모 테이블인 리스트 테이블만 삭제하자. 그럼 자동으로 다 삭제 된다.

	

$t_chk = true;	
mysqli_query($CONN['rosemary'],"set autocommit = 0;");
mysqli_query($CONN['rosemary'],"begin;");


// 원본 답글에 상관없이 같은 seq의 del_chk 가 전부 Y일때 해당 seq를 삭제 해야한다.


$del_update = mysqli_query($CONN['rosemary'],"update board_list set del_chk = 'Y' where list_num = '$list_num'");
if (!$del_update) {
	mysqli_query($CONN['rosemary'],"rollback;");
	alertback("삭제 시 오류가 발생하였습니다.");
}


	
// 해당 seq 와 같은 게시물중에 del_chk 가 N인 게시물(아직 삭제 안된 게시물)을 알아온다. 만약 1개라도 있으면 진짜 삭제를 진행하지 않는다.
$seq_query = mysqli_query($CONN['rosemary'],"select count(*) cnt from board_list where seq = '$list_seq' and del_chk = 'N'");
$seq_nums = mysqli_result($seq_query,0,0);

if ($seq_nums) {	// 해당 관련 글이 모두 삭제 처리 되었으니 삭제 한다.

	// 실제 삭제가 되기전에 게시판 리스트 카운팅을 마이너스 해준다. 
	$del_cnt_query = mysqli_query($CONN['rosemary'],"select count(*) cnt from board_list where seq = '$list_seq' and del_chk = 'Y'");
	$del_cnt = mysqli_result($del_cnt_query,0,0);	

	$list_update = @mysqli_query($CONN['rosemary'],"update board set list_cnt = list_cnt - $del_cnt where bo_num = '$bo_num'");
	if (!$list_update) {
		$t_chk = false;
	}			


	$del_query = mysqli_query($CONN['rosemary'],"delete from board_list where seq = '$list_seq'");
	if (!$del_query) {
		$t_chk = false;
	}
	if ($t_chk != true) {
		mysqli_query($CONN['rosemary'],"rollback;");
		alertback("삭제 시 오류가 발생하였습니다.");
	}else{
		mysqli_query($CONN['rosemary'],"commit;");	
		alertGo("","$move_page?mode=board_list&bo_num=$bo_num&page=$page&list_page=$list_page&key=$key&searchword=$searchword");
	}
}else{
	alertGo("","$move_page?mode=board_list&bo_num=$bo_num&page=$page&list_page=$list_page&key=$key&searchword=$searchword");
}



/*


*/
?>