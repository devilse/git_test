<?php
include '../../_include/lib_include.php';
include '../include/frame_a.php';
include '../../_autocode/siteoption.php';
include "../../gmEditor/func_editor.php";

																		// 넘어온 파라미터 변수선언
$page = $_POST['page'];
$key = $_POST['key'];
$searchword = $_POST['searchword'];
$write_mode = $_POST['write_mode'];
$qna_num = $_POST['qna_num'];


$param = "page=".$page."&key=".$key."&searchword=".$searchword;

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
$tpl->define('content', "skin/qna/$qna_skin/write.html");

																		// 로그인 체크 - 회원만 접근이 가능하다.
$User_Info =  Login_Chk($_COOKIE['LIPASS_ID']);
$mb_type = $User_Info['type'];
$mb_num = $User_Info["member_num"];
if ($mb_type == "G" || !$mb_type || !$mb_num) {
	alertGo("","$MY_URL");
}
$tpl->assign('mb_id', $User_Info['id']);


																		// write 페이지에서 사용할 변수 선언
$counsel_date_loop = array();
$counsel_date_val = array();
for ($i=0;$i<24;$i++) {
	if ($i < 10) {
		$i = "0".$i;
	}
	$counsel_date1_val['number'] = $i;
	$counsel_date1_loop[] = $counsel_date1_val;
}
$tpl->assign('counsel_date', $counsel_date1_loop);	


if ($write_mode == "modi") {										// 수정하기
		
	if (!$qna_num) {
		alertback("접근 할 수 없습니다.");
	}

	$con_query = mysqli_query($CONN['rosemary'],"select 
									a.mb_id,a.title,a.mb_name,a.hit_cnt,a.reg_date,a.file_chk,a.state,a.phone,a.email,a.counsel_time,
									b.contents as con
							from 
									qna_list a, 
									qna_contents b 
							where 
									a.qna_num = '$qna_num' and 
									a.qna_num = b.qna_num");

	$con_nums = mysqli_num_rows($con_query);
	if (!$con_nums) alertback("삭제 되었거나 존재하지 않는 게시물 입니다.");

	$con_rs = mysqli_fetch_array($con_query);

	$title		= $con_rs['title'];
	$file_chk	= $con_rs['file_chk'];
	$state		= $con_rs['state'];
	$gubun		= $con_rs['gubun'];
	$content	= $con_rs['con'];		// 내용
	$phone_array = explode("-",$con_rs['phone']);
	$email_array = explode("@",$con_rs['email']);
	$counsel_array = explode("<>",$con_rs['counsel_time']);

	$tpl->assign('title', $title);
	$tpl->assign('mb_hp3', $file_chk);
	$tpl->assign('state', $state);
	$tpl->assign('gubun', $gubun);
	$tpl->assign('content', $content);
	$tpl->assign('mb_email1', $email_array[0]);
	$tpl->assign('mb_email2', $email_array[1]);
	$tpl->assign('mb_hp1', $phone_array[0]);
	$tpl->assign('mb_hp2', $phone_array[1]);
	$tpl->assign('mb_hp3', $phone_array[2]);

	$tpl->assign('counsel1', $counsel_array[1]);
	$tpl->assign('counsel2', $counsel_array[2]);
	$tpl->assign('counsel3', $counsel_array[3]);

	$tpl->assign('write_mode', $write_mode);
	$tpl->assign('qna_num', $qna_num);

	if ($file_chk == "Y") {
		$file_query = @mysqli_query($CONN['rosemary'],"select * from qna_file where qna_num = '$qna_num'");
		$file_nums = @mysqli_num_rows($file_query);
		if ($file_nums) {
			$file_loop = array();
			while($file_rs = mysqli_fetch_array($file_query)) {
			$file_rs['file_size'] = viewSizeToByte($file_rs['file_size']);
			$file_loop[] = $file_rs; 
			}
		}
	}

	$tpl->assign('file_loop', $file_loop);



} else {															// 글쓰기
	$info = Member_Info("mb_email,mb_hp","member");
	if (!$info) {
		alertGo("","$MY_URL");
	}
	$mb_email = explode("@",stripslashes($info['mb_email']));
	$mb_hp = explode("-",stripslashes($info['mb_hp']));

	$tpl->assign('mb_email1', $mb_email[0]);
	$tpl->assign('mb_email2', $mb_email[1]);
	$tpl->assign('mb_hp1', $mb_hp[0]);
	$tpl->assign('mb_hp2', $mb_hp[1]);
	$tpl->assign('mb_hp3', $mb_hp[2]);

}





$tpl->print_('frame');
?>