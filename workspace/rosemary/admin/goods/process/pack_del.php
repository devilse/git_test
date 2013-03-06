<?php
header('Content-Type: text/html;charset=utf-8');

include "../../../_lib/db_conn.php";	// 디비 접속
include "../../../_lib/global.php";
include "../../../_lib/function.php";
include "../../../_lib/lib.php";	// 관리자 페이지 공용 함수 파일

$mode = $_POST['mode'];

$page = $_POST['page'];
$key = $_POST['key'];
$searchword = $_POST['searchword'];
$set_cs = $_POST['set_cs'];
$set_state = $_POST['set_state'];
$gp_num = $_POST['gp_num'];

$page_param = "&page=$page&key=$key&searchword=$searchword&set_cs=$set_cs&set_state=$set_state";


if (!$gp_num) alertback("접근할 수 없습니다.");



$t_chk = true;	//쿼리 이상유무 체크 변수
mysqli_query($CONN['rosemary'],"set autocommit = 0;");
mysqli_query($CONN['rosemary'],"begin;");


$goods_del_query = mysqli_query($CONN['rosemary'],"delete from goods_package_goods where gp_num = '$gp_num'");
if (!$goods_del_query) {
	$t_chk = false;
} else {
	// 첨부된 이미지와 본문 이미지를 다 삭제하고 지운다.

	$view_query = mysqli_query($CONN['rosemary'],"select gp_explanation,gp_img from goods_package where gp_num = '$gp_num'");
	$view_rs = mysqli_fetch_array($view_query);

	$con_img = explode("_tmp_e_",$view_rs['gp_explanation']);
	$con_end_for = count($con_img);
	$del_img_array = array();
	for($i=0;$i<$con_end_for;$i++) {
		$contents_img2 = explode("_tmp_s_",$con_img[$i]);
			if ($contents_img2[1] != "" || !empty($contents_img2[1]) ) {
				$upfile = "_tmp_s_".$contents_img2[1]."_tmp_e_";
				@unlink($dir_img.'/goods_img/'.$upfile);
			}
	}
	if (!empty($view_rs['gp_img'])) {
		@unlink($dir_img.'/goods_img/'.$view_rs['gp_img']);
	}
	
	$del_query = mysqli_query($CONN['rosemary'],"delete from goods_package where gp_num = '$gp_num'");
	if (!$del_query) {
		$t_chk = false;
	}
}

if ($t_chk != true) {
	mysqli_query($CONN['rosemary'],"rollback;");
	alertback("패키지 삭제 실패");
} else {
	mysqli_query($CONN['rosemary'],"commit;");	
	alertGo("","../index.php?mode=package_list&".$page_param);
}


?>