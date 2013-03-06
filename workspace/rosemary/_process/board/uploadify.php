<?php
include "../../_lib/db_conn.php";	// 디비 접속	
include "../../_lib/global.php";	// 디비 접속	


$file_cnt = $_POST['file_cnt'];		// 업로드 파일 숫자
$list_num = $_POST['list_num'];		// 리스트 번호
$file_state = $_POST['file_state'];	// 업로드 하는 게시판 속성 (일반 게시판인지 qna 인지)

if (!$list_num) {
	echo "X|파일을 업로드 할 수 없습니다.";
	exit;
}

if (!$file_state) {
	echo "X|파일을 업로드 할 수 없습니다.";
	exit;
}

if ($file_state == "board") {
	$chk_query = mysqli_query($CONN['rosemary'],"select count(*) as cnt from board_list where list_num = '$list_num'");
	$chk_cnt = @mysqli_result($chk_query,0,0);
} else {
	$chk_query = mysqli_query($CONN['rosemary'],"select count(*) as cnt from qna_list where qna_num = '$list_num'");
	$chk_cnt = @mysqli_result($chk_query,0,0);
}

if ($chk_cnt > 0) {
	$upfile_name = addslashes(trim($_FILES['Filedata']['name']));												// 업로드 파일 원본 이름
	$ext = substr($_FILES['Filedata']['name'],strrpos(stripslashes($_FILES['Filedata']['name']),'.')+1);		// 파일확장자
	$file_size = $_FILES['Filedata']['size'];																	// 파일 사이즈
	$upfile = '.file.'.$ext;																								
	$upfile = "_tmp_s_" . date("YmdHis") . "_" . substr(microtime(),2,4) . $upfile . "_tmp_e_";					// 실제 저장할 파일명


	if (@move_uploaded_file($_FILES['Filedata']['tmp_name'],$dir_file.'/'.$upfile)) {
		if ($file_state == "board") {
			$file_in_qry = @mysqli_query($CONN['rosemary'],"insert into board_file(list_num,file_name,file_size,file_exe,file_tmp_name) values('$list_num','$upfile_name','$file_size','$ext','$upfile')");
			if (!$file_in_qry) {
				//@mysqli_query($CONN['rosemary'],"delete from board_file where list_num = '$list_num'");
				//@mysqli_query($CONN['rosemary'],"delete from board_contents where list_num = '$list_num'");
				//@mysqli_query($CONN['rosemary'],"delete from board_list where list_num = '$list_num'");
				
				echo "X|파일 업로드중 디비에서 에러가 발생 하였습니다.";
				exit;
			} else{
				@mysqli_query($CONN['rosemary'],"update board_list set file_chk = 'Y' where list_num = '$list_num'");
				echo "T|$file_cnt";
			}
		} else if ($file_state == "qna") {
			$file_in_qry = @mysqli_query($CONN['rosemary'],"insert into qna_file(qna_num,file_name,file_size,file_exe,file_tmp_name) values('$list_num','$upfile_name','$file_size','$ext','$upfile')");
			if (!$file_in_qry) {
				//@mysqli_query($CONN['rosemary'],"delete from qna_file where qna_num = '$list_num'");
				//@mysqli_query($CONN['rosemary'],"delete from qna_contents where qna_num = '$list_num'");
				//@mysqli_query($CONN['rosemary'],"delete from qna_list where qna_num = '$list_num'");
				
				echo "X|파일 업로드중 디비에서 에러가 발생 하였습니다.";
				exit;
			} else{
				@mysqli_query($CONN['rosemary'],"update qna_list set file_chk = 'Y' where qna_num = '$list_num'");
				echo "T|$file_cnt";
			}

		}
		
	} else {
		echo "X|$file_cnt";
	}
}

?>

