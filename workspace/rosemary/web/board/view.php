<?php

$list_num = $_GET['list_num'];	//게시물 pk 번호
if (!$list_num) $list_num = $_POST['list_num'];	
if (!$list_num) {
	exit;
}
setcookie("LIPASS_VIEW","$list_num",0,"/");
include '../../_include/lib_include.php';
include '../include/frame_a.php';
include "../../gmEditor/func_editor.php";
include "../../_lib/board.class.php";



$bo_num = $_GET['bo_num'];	//게시판 pk 번호
if (!$bo_num) $bo_num = $_POST['bo_num'];
if (!$bo_num) {
	alertGo("","$MY_URL");
}



$tpl->createSubMenu_bo_num($bo_num);


$User_Info =  Login_Chk($_COOKIE['LIPASS_ID']);
$mb_type = $User_Info['type'];
$tpl->assign('mb_id', $User_Info['id']);


if ($_COOKIE['LIPASS_VIEW'] != $list_num) {
	Chk_view($list_num);
}

$mode = "board_view";

include "../../_lib/board_lib.php";								// 해당 파일에서 사용할 공용변수및 프로세스 처리를 해준다. (모드에 따라 게시판의 모든 기능을 처리하는 페이지다.)

$user_set_reply = $set_use_chk['set_reply'];					// 접속 유저 기능중 답글기능 여부 체크




//게시판 설정 관련
$tpl->assign('board_skin', $board_skin);
$tpl->assign('head_title', $head_title);
$tpl->assign('end_title', $end_title);
$tpl->assign('bo_set_reply', $bo_set_reply);
$tpl->assign('bo_set_file', $bo_set_file);
$tpl->assign('set_comment', $set_comment);
$tpl->assign('bo_recom', $bo_recom);
if (!empty($bo_list_mal)) {
	$view_mal = "[".$list_state."]";
}

$tpl->assign('view_mal', $view_mal);

//권한 관련
$tpl->assign('in_board_chk', $in_board_chk);	// 해당 글이 자신의 글인지 체크한다.
$tpl->assign('set_modi', $set_modi);			// 해당 유저가 수정 권한이 있는지
$tpl->assign('set_del', $set_del);				// 해당 유저가 삭제 권한이 있는지
$tpl->assign('set_reply', $set_reply);			// 해당 유저가 답글을 달 수 있는지
$tpl->assign('set_recom', $set_recom);			// 해당 유저가 추천을 할 수 있는지 


if (!$board_skin) {											
	$board_skin = "basic";
}
$page_list_url = $MY_URL."_template/skin/board/".$board_skin;
$tpl->define('content', "skin/board/$board_skin/view.html");


$tpl->assign('title', $title);
$tpl->assign('mb_name', $mb_name);
$tpl->assign('bbs_mb_id', $bbs_mb_id);
$tpl->assign('hit_cnt', number_format($hit_cnt));
$tpl->assign('recom_cnt', number_format($recom_cnt));
$tpl->assign('reg_date', $reg_date);
$tpl->assign('file_chk', $file_chk);
$tpl->assign('secret_chk', $secret_chk);
$tpl->assign('con', $con);
$tpl->assign('cg_code_name', $cg_code_name);
$tpl->assign('cg_cate_name', $cg_cate_name);
$tpl->assign('goods_name', $goods_name);


//댓글 정보
if ($comment_rs != false) {
	$comment_loop = array();
	for ($i=0;$i<count($comment_rs);$i++) {
		$comment_loop[] = $comment_rs[$i];
	}	
}
$tpl->assign('comment_loop', $comment_loop);
$tpl->assign('comment_cnt', number_format($comment_cnt));	//댓글 갯수

//첨부파일 정보
if ($file_chk == "Y") {
	$file_loop = array();
	for ($i=0;$i<count($file_rs);$i++) {
		$file_rs[$i]['file_size'] = viewSizeToByte($file_rs[$i]['file_size']);
		$file_loop[] = $file_rs[$i];
	}
}
$tpl->assign('file_loop', $file_loop);


// 이전글 목록 정보
if ($next_rs != false) {
	$next_loop = array();
	for ($i=0;$i<count($next_rs);$i++) {
		$next_loop[] = $next_rs[$i];
	}	
}
$tpl->assign('next_cnt', count($next_rs));
$tpl->assign('next_loop', $next_loop);


// 다음글 목록 정보
if ($yester_rs != false) {
	$yester_loop = array();
	for ($i=0;$i<count($yester_rs);$i++) {
		$yester_loop[] = $yester_rs[$i];
	}	
}
$tpl->assign('yester_cnt', count($yester_rs));
$tpl->assign('yester_loop', $yester_loop);





$tpl->assign('bo_num', $bo_num);
$tpl->assign('list_num', $list_num);

$tpl->assign('set_down', $set_use_chk['set_down']);

$tpl->assign('key', $key);
$tpl->assign('searchword', $searchword);

$tpl->assign('list_page', $list_page);
$tpl->assign('seq', $seq);
$tpl->assign('ref', $ref);
$tpl->assign('dep', $dep);
$tpl->assign('param', $param);





$tpl->print_('frame');
?>