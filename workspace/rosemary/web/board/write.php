<?php
include '../../_include/lib_include.php';
include '../include/frame_a.php';
include "../../gmEditor/func_editor.php";
include "../../_lib/board.class.php";

$tpl->createSubMenu_bo_num($_GET['bo_num']);


$User_Info =  Login_Chk($_COOKIE['LIPASS_ID']);
$mb_type = $User_Info['type'];

$bo_num = $_GET['bo_num'];	//게시판 pk 번호
$list_num = $_GET['list_num'];	//게시물 pk 번호
$write_mode = $_GET['write_mode'];	//게시물 작성 모드(새로등록,수정,답글)


if (!$bo_num) {
	alertGo("","$MY_URL");
}


$mode = "board_write";

include "../../_lib/board_lib.php";					// 해당 파일에서 사용할 공용변수및 프로세스 처리를 해준다.

//게시판 설정 관련
$tpl->assign('board_skin', $board_skin);
$tpl->assign('head_title', $head_title);
$tpl->assign('end_title', $end_title);
$tpl->assign('board_set_reply', $board_set_reply);
$tpl->assign('bo_set_file', $bo_set_file);
$tpl->assign('set_file_max', $bo_set_file_max);	//첨부파일 최대 용량 제한
$tpl->assign('bo_set_img', $bo_set_img);
$tpl->assign('bo_set_secret', $bo_set_secret);



if (!empty($bo_list_mal)) {
	$list_mal = "Y";
	$bo_list_mal_array = explode(",",$bo_list_mal);	
	$mal_loop = array();
	$mal_chk = array();
	for ($i=0;$i<count($bo_list_mal_array);$i++) {
		$mal_chk['name'] = $bo_list_mal_array[$i];
		$mal_loop[] = $mal_chk;
	}
		

} else {
	$list_mal = "N";
	$mal_loop = "";
}
$tpl->assign('list_mal', $list_mal);
$tpl->assign('mal_loop', $mal_loop);


//권한 관련
$tpl->assign('in_board_chk', $in_board_chk);			// 해당 글이 자신의 글인지 체크한다.
$tpl->assign('set_modi', $set_modi);		// 해당 유저가 수정 권한이 있는지
$tpl->assign('set_reply', $set_reply);		// 해당 유저가 답글을 달 수 있는지


if ($write_mode == "modi") {	//수정일때

	$tpl->assign('seq', $seq);
	$tpl->assign('ref', $ref);
	$tpl->assign('dep', $dep);
	$tpl->assign('title', $title);
	$tpl->assign('user_name', $user_name);
	$tpl->assign('content', $content);
	$tpl->assign('file_chk', $file_chk);
	$tpl->assign('hit', $hit);
	$tpl->assign('reg_date', $reg_date);
	$tpl->assign('reg_date', $reg_date);
	$tpl->assign('mb_password', $mb_password);
	$tpl->assign('secret_chk', $secret_chk);
	$tpl->assign('list_state', $list_state);


	//첨부파일 정보
	if ($file_chk == "Y") {
		$file_loop = array();
		for ($i=0;$i<count($file_rs);$i++) {
			$file_rs[$i]['file_size'] = viewSizeToByte($file_rs[$i]['file_size']);
			$file_loop[] = $file_rs[$i];
		}
	}
	$tpl->assign('file_loop', $file_loop);

}


$head_title = $board_obj->board_feild('head_title');

if (!$board_skin) {
	$board_skin = "basic";
}
$page_list_url = $MY_URL."_template/skin/board/".$board_skin;


$tpl->define('content', "skin/board/$board_skin/write.html");


$page_list = go_page_list($query_number, $num_per_page, $num_per_block, $list_page, "./index.php?bo_num=$bo_num&", $key, $searchword,$mode);


$tpl->assign('bo_num', $bo_num);
$tpl->assign('list_num', $list_num);
$tpl->assign('write_mode', $write_mode);		//해당 변수의 값이 없으면 그냥 글쓰기, 값이 있으면 수정하기가 됨
$tpl->assign('mb_type', $mb_type);
$tpl->assign('set_img', $board_info['set_img']);

$tpl->assign('key', $key);
$tpl->assign('searchword', $searchword);
$tpl->assign('page', $page);
$tpl->assign('list_page', $list_page);
$tpl->assign('seq', $seq);
$tpl->assign('ref', $ref);
$tpl->assign('dep', $dep);
$tpl->assign('param', $param);
$tpl->assign('set_cs', $set_cs);


$tpl->print_('frame');
?>