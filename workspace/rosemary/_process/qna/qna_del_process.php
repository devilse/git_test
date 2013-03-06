<?php
header('Content-Type: text/html;charset=utf-8');

include "../../_lib/db_conn.php";	// 디비 접속
include "../../_lib/global.php";
include "../../_lib/function.php";
include "../../_lib/lib.php";	// 관리자 페이지 공용 함수 파일



$qna_num	= $_POST['qna_num'];				// 리스트번호
$page		= $_POST['page'];					// 게시판 페이징 번호
$key		= $_POST['key'];						// 검색유형
$searchword = $_POST['searchword'];				// 검색어
$move_page	= $_POST['move_page'];

if (!$move_page) {
	$move_page = "../../admin/board/index.php";
} 
if (!$qna_num) {
	alertback("접근 할 수 없습니다.");
}

$User_Info	=  Login_Chk($_COOKIE['LIPASS_ID']);	// 로그인체크
$mb_type	= $User_Info['type'];					// 유저타입


// 먼저 삭제될 글에 첨부된 이미지와 파일이 있는지 체크후 있다면 이미지와 파일부터 삭제 한다.

$list_query = mysqli_query($CONN['rosemary'],"select img_chk,file_chk from qna_list where qna_num = '$qna_num'");
$list_rs = mysqli_fetch_array($list_query);

if ($list_rs['img_chk'] == "Y") { //이미지 삭제한다.
	$con_query = mysqli_query($CONN['rosemary'],"select contents from qna_contents where qna_num = '$qna_num'");
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
	$file_query = mysqli_query($CONN['rosemary'],"select * from qna_file where qna_num = '$qna_num'");
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


	$del_query = mysqli_query($CONN['rosemary'],"delete from qna_list where qna_num = '$qna_num'");
	if (!$del_query) {
		$t_chk = false;
	}


	if ($t_chk != true) {
		mysqli_query($CONN['rosemary'],"rollback;");
		alertback("삭제 시 오류가 발생하였습니다.");
	}else{
		mysqli_query($CONN['rosemary'],"commit;");	
		alertGo("","$move_page?mode=qna_list&page=$page&key=$key&searchword=$searchword");
	}
?>
