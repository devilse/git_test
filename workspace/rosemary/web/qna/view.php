<?php
include '../../_include/lib_include.php';
include '../include/frame_a.php';
include '../../_autocode/siteoption.php';
include "../../gmEditor/func_editor.php";

																			// 넘어온 파라미터 변수선언
$qna_num = $_GET['qna_num'];
$page = $_GET['page'];
$key = $_GET['key'];
$searchword = $_GET['searchword'];
$param = "page=".$page."&key=".$key."&searchword=".$searchword;

$tpl->assign('qna_num', $qna_num);
$tpl->assign('page', $page);	
$tpl->assign('key', $key);	
$tpl->assign('searchword', $searchword);	
$tpl->assign('param', $param);	

																			// 스킨설정
$qna_skin = $siteoption['skin_qna'];
if (!$qna_skin) {
	$qna_skin = "basic";
}
$tpl->createSubMenu('6201');
$tpl->define('content', "skin/qna/$qna_skin/view.html");

																			// 로그인 체크 - 회원만 접근이 가능하다.
$User_Info =  Login_Chk($_COOKIE['LIPASS_ID']);
$mb_type = $User_Info['type'];
if ($mb_type == "G" || !$mb_type) {
	alertGo("","$MY_URL");
}
$tpl->assign('mb_id', $User_Info['id']);


																			// view 
if (!$qna_num) {
	alertback("접근 할 수 없습니다.");
}

$con_query = mysqli_query($CONN['rosemary'],"select 
								a.mb_id,a.title,a.mb_name,a.hit_cnt,a.reg_date,a.file_chk,a.state,a.phone,a.email,a.counsel_time,
								b.contents as con,b.admin_contents as con_dap
						from 
								qna_list a, 
								qna_contents b 
						where 
								a.qna_num = '$qna_num' and 
								a.qna_num = b.qna_num");

$con_nums = mysqli_num_rows($con_query);
if (!$con_nums) alertback("삭제 되었거나 존재하지 않는 게시물 입니다.");

$con_rs = mysqli_fetch_array($con_query);

$title = stripslashes($con_rs['title']);
$mb_name = stripslashes($con_rs['mb_name']);
$hit_cnt = number_format($con_rs['hit_cnt']);
$reg_date = date("Y-m-d H:i:s",$con_rs['reg_date']);
$file_chk = $con_rs['file_chk'];
$state = $con_rs['state'];
$phone = $con_rs['phone'];
$email = stripslashes($con_rs['email']);
$counsel_time_array = explode("<>",$con_rs['counsel_time']);
if ($counsel_time_array[0] == "Y") {
	$counsel_time = "항상";
} else {
	$counsel_time = $counsel_time_array[1]."시 ~".$counsel_time_array[2]."시" ;
}



$con = stripslashes($con_rs['con']);
$con_dap = stripslashes($con_rs['con_dap']);
$content = $con_dap;

$member_type_name = Member_Type_Name($mb_type);

if ($file_chk == "Y") {
	$file_query = mysqli_query($CONN['rosemary'],"select * from qna_file where qna_num = '$qna_num'");
	$file_nums = mysqli_num_rows($file_query);
	if ($file_nums) {
		$file_loop = array();
		while($file_rs = mysqli_fetch_array($file_query)) {
		$file_rs['file_size'] = viewSizeToByte($file_rs['file_size']);
		$file_loop[] = $file_rs; 
		}
	}
}


$tpl->assign('title', $title);	
$tpl->assign('mb_name', $mb_name);	
$tpl->assign('hit_cnt', $hit_cnt);	
$tpl->assign('reg_date', $reg_date);	
$tpl->assign('file_chk', $file_chk);	
$tpl->assign('state', $state);	
if ($phone == "--") {
	 $phone = "";
}
if ($email == "@") {
	 $email = "";
}
$tpl->assign('phone', $phone);	
$tpl->assign('email', $email);	
$tpl->assign('counsel_time', $counsel_time);	
$tpl->assign('con', $con);
$tpl->assign('con_dap', $con_dap);
$tpl->assign('file_loop', $file_loop);

$tpl->print_('frame');
?>