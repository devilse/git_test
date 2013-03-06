<?php
header('Content-Type: text/html;charset=utf-8');

include "../../_lib/db_conn.php";	// 디비 접속
include "../../_lib/global.php";
include "../../_lib/function.php";
include "../../_lib/lib.php";	// 관리자 페이지 공용 함수 파일


$bo_num = $_GET['bo_num'];
if (!$bo_num)alertback("접근할 수 없습니다.");


$t_chk = true;	
mysqli_query($CONN['rosemary'],"set autocommit = 0;");
mysqli_query($CONN['rosemary'],"begin;");

$list_query = mysqli_query($CONN['rosemary'],"select * from board_list where bo_num = '$bo_num'");
while($list_rs = mysqli_fetch_array($list_query)) {
	$list_num = $list_rs['list_num'];
	if ($list_rs[img_chk] == "Y") { //이미지 삭제한다.
		$con_query = mysqli_query($CONN['rosemary'],"select contents from board_contents where list_num = '$list_num'");
		$con = mysqli_result($con_query,0,0);

			$con_img = explode("_tmp_e_",$con);
			$con_end_for = count($con_img);
			$del_img_array = array();
			for($i=0;$i<$con_end_for;$i++) {
				$contents_img2 = explode("_tmp_s_",$con_img[$i]);
					if ($contents_img2[1] != "" || !empty($contents_img2[1]) ) {
						$upfile = "_tmp_s_".$contents_img2[1]."_tmp_e_";
						@unlink($dir_img.'/'.$upfile);
					}
			}
	}
		
	if ($list_rs[file_chk] == "Y") {	// 파일 삭제한다.
		$file_query = mysqli_query($CONN['rosemary'],"select * from board_file where list_num = '$list_num'");
		$file_nums = mysqli_num_rows($file_query);
		if ($file_nums) {
			while($file_rs = mysqli_fetch_array($file_query)) {
				$upfile = $file_rs['file_tmp_name'];
				@unlink($dir_file.'/'.$upfile);
			}
		}
	}

	
		$list_update = @mysqli_query($CONN['rosemary'],"update board set list_cnt = list_cnt - 1 where bo_num = '$bo_num'");
		if (!$list_update) {
			$t_chk = false;
			break;
		}			

		$del_query = mysqli_query($CONN['rosemary'],"delete from board_list where list_num = '$list_num'");
		if (!$del_query) {
			$t_chk = false;
			break;
		}
}


if ($t_chk != true) {
	mysqli_query($CONN['rosemary'],"rollback;");
	alertback("삭제 시 오류가 발생하였습니다.");
}else{
	mysqli_query($CONN['rosemary'],"commit;");	
	alertback("삭제 성공");
}



?>