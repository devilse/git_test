<?php
header('Content-Type: text/html;charset=utf-8');


include "../../../_lib/db_conn.php";	// 디비 접속
include "../../../_lib/global.php";
include "../../../_lib/function.php";
include "../../../_lib/lib.php";	// 관리자 페이지 공용 함수 파일

$mode = $_POST['mode'];
$g_num = $_POST['g_num'];

$page = $_POST['page'];
$key = $_POST['key'];
$searchword = $_POST['searchword'];
$set_g_state = $_POST['set_g_state'];
$sel_type = $_POST['sel_type'];
$ca_num = $_POST['ca_num'];

$page_param = "&page=$page&key=$key&searchword=$searchword&set_g_state=$set_g_state&sel_type=$sel_type&ca_num=$ca_num";


if ($mode == "period") {

	$num = $_POST['num'];

	$del_query = mysqli_query($CONN['rosemary'],"delete from goods_lecture_subjects_period where ltsp_num = '$num'");
	if (!$del_query) {
		alertback("삭제 실패");
	} else {
		alertGo("","../index.php?mode=goods_subject_reg&g_num=$g_num".$page_param);
	}
} else if ($mode == "subject") {

	$num = $_POST['num'];

	//강의가 하나만 존재한다면 삭제되지 않는다.
	$cnt_chk_query = mysqli_query($CONN['rosemary'],"select count(*) cnt from goods_lecture where g_num = '$g_num'");
	$cnt_chk = mysqli_result($cnt_chk_query,0,0);
	if ($cnt_chk < 2) {
		alertback("강의가 하나만 존재 하여 삭제 할 수 없습니다.");
	} else {
		//goods_lecture_subjects_period 테이블은 해당 테이블과 포링키로 묶여 있어서 goods_lecture_subjects테이블만 삭제하면 자동 삭제됨
		$del_query = mysqli_query($CONN['rosemary'],"delete from goods_lecture_subjects where lts_num = '$num'");

		if (!$del_query) {
			alertback("삭제 실패");
		} else {
			alertGo("","../index.php?mode=goods_subject_reg&g_num=$g_num".$page_param);
		}
	}





} else if ($mode == "dan") {
	
	$g_type = $_POST['g_type'];
	$num = $_POST['num'];		//단과번호

	// 단과가 하나만 존재할 경우 삭제 되지 않는다.	
	$cnt_chk_query = mysqli_query($CONN['rosemary'],"select count(*) cnt from goods_lecture where g_num = '$g_num'");
	$cnt_chk = mysqli_result($cnt_chk_query,0,0);
	if ($cnt_chk < 2) {
		alertback("단과가 하나만 존재 하여 삭제 할 수 없습니다.");
	} else {

		$t_chk = true;	//쿼리 이상유무 체크 변수

		mysqli_query($CONN['rosemary'],"set autocommit = 0;");
		mysqli_query($CONN['rosemary'],"begin;");
		// 자식 테이블 goods_lecture_subjects, 같이 삭제됨
		$del_query = mysqli_query($CONN['rosemary'],"delete from goods_lecture where lt_num = '$num'");
		if (!$del_query) {
			$t_chk = false;
		} else {

			// 상품 유형이 강좌 였는데 단과를 삭제하여 단과가 하나만 존재하게 되면 유형이 단과가 된다.
			if ($g_type == "C") {
				$dan_cnt_query = mysqli_query($CONN['rosemary'],"select count(*) as cnt from goods_lecture where g_num = '$g_num'");
				$dan_cnt = mysqli_result($dan_cnt_query,0,0);
				if ($dan_cnt < 2) {
					$state_up_query = mysqli_query($CONN['rosemary'],"update goods set g_type = 'B' where g_num = '$g_num'");
					if (!$state_up_query) {
						$t_chk = false;
					}
				}
			}
			

			if ($t_chk != true) {
				mysqli_query($CONN['rosemary'],"rollback;");
				alertback("단과 삭제 실패");
			} else {
				mysqli_query($CONN['rosemary'],"commit;");	
				alertGo("","../index.php?mode=goods_subject_reg&g_num=$g_num".$page_param);
			}

			
		}
	}

} else if ($mode == "gang") {
	$num = $_POST['num'];

	$t_chk = true;	//쿼리 이상유무 체크 변수

	mysqli_query($CONN['rosemary'],"set autocommit = 0;");
	mysqli_query($CONN['rosemary'],"begin;");

	$dan_del_query = mysqli_query($CONN['rosemary'],"delete from goods_lecture where g_num = '$g_num'");
	
	if (!$dan_del_query) {
		$t_chk = false;
	} else {
		// 첨부된 이미지가 있다면 이미지 삭제 하고 데이터를 지운다.
		$goods_query = mysqli_query($CONN['rosemary'],"select g_explanation from goods where g_num = '$num'");
		$goods_con = mysqli_result($goods_query,0,0);

		$con_img = explode("_tmp_e_",$goods_con);
		$con_end_for = count($con_img);
		$del_img_array = array();
		for($i=0;$i<$con_end_for;$i++) {
			$contents_img2 = explode("_tmp_s_",$con_img[$i]);
				if ($contents_img2[1] != "" || !empty($contents_img2[1]) ) {
					$upfile = "_tmp_s_".$contents_img2[1]."_tmp_e_";
					@unlink($dir_img.'/goods_img/'.$upfile);
				}
		}
		 

		 $del_query = mysqli_query($CONN['rosemary'],"delete from goods where g_num = '$num'");
		 if (!$del_query) {
			 $t_chk = false;
		 } 
		
	}


		if ($t_chk != true) {
			mysqli_query($CONN['rosemary'],"rollback;");
			alertback("삭제 실패");
		} else{
			mysqli_query($CONN['rosemary'],"commit;");	
			alertGo("","../index.php?mode=goods");
		}


}


?>