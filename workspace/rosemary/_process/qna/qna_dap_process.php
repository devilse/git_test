<?php
header('Content-Type: text/html;charset=utf-8');

include "../../_lib/db_conn.php";	// 디비 접속
include "../../_lib/global.php";
include "../../_lib/function.php";
include "../../_lib/lib.php";


$qna_num = $_POST['qna_num'];
$contents = $_POST['content'];	
$page = $_POST['page'];	



$User_Info =  Login_Chk($_COOKIE['LIPASS_ID']);		// 로그인 체크
if (!$User_Info) {
	echo "X|로그인이 필요합니다.";
	exit;
}

$mb_type = $User_Info['type'];						// 멤버타입
	
$contents_img	= explode("_tmp_e_",$contents);			// 본문내 첨부된 이미지를 배열로 쪼갠다.
$end_for		= count($contents_img);					// 이미지 배열 길이
for ($i=0;$i<$end_for;$i++) {
	$img_use_chk = "Y";
	$contents_img2 = explode("_tmp_s_",$contents_img[$i]);
		if ($contents_img2[1] != "" || !empty($contents_img2[1]) ) {
			$upfile = "_tmp_s_".$contents_img2[1]."_tmp_e_";
			@move("../../../dir_img_tmp/$upfile","../../../dir_img/$upfile");
		}
}

$contents = eregi_replace("\\\\","",$contents);
$contents = eregi_replace("/dir_img_tmp"  , $MY_URL."dir_img",$contents);
$contents = addslashes(trim($contents));				// 실제 내용



$t_chk = true;	//쿼리 이상유무 체크 변수

mysqli_query($CONN['rosemary'],"set autocommit = 0;");
mysqli_query($CONN['rosemary'],"begin;");

$update_list = mysqli_query($CONN['rosemary'],"update qna_list set state = 'Y', wan_date = unix_timestamp() where qna_num = '$qna_num'");
if(!$update_list){
	$t_chk = false;
	$err_msg = "리스트 업데이트 실패";	
}else{
	$update_con = mysqli_query($CONN['rosemary'],"update qna_contents set admin_contents = '$contents' where qna_num = '$qna_num'");
	if(!$update_con){
		$t_chk = false;
		$err_msg = "답변 등록 실패";	
	}
}

if ($t_chk != true) {
	mysqli_query($CONN['rosemary'],"rollback;");
	alertback($err_msg);
} else{
	mysqli_query($CONN['rosemary'],"commit;");	
	alertGo("","../../admin/board/index.php?mode=qna_view&qna_num=$qna_num&page=$page");
}




?>

