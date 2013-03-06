<?php
include '../../_include/lib_include.php';
include '../include/frame_a.php';
include "../../_lib/board.class.php";

$tpl->createSubMenu_bo_num($_GET['bo_num']);

$User_Info =  Login_Chk($_COOKIE['LIPASS_ID']);
$mb_type = $User_Info['type'];
$tpl->assign('mb_id', $User_Info['id']);


$bo_num = $_GET['bo_num'];	//게시판 pk 번호
if (!$bo_num) {
	alertGo("","$MY_URL");
}

$mode = "board_list";

include "../../_lib/board_lib.php";



//사용자 권한 관련
$tpl->assign('set_write', $set_write);			// 글쓰기 권한

//게시판 설정 관련
$tpl->assign('board_skin', $board_skin);
$tpl->assign('head_title', $head_title);
$tpl->assign('end_title', $end_title);
$tpl->assign('bo_set_file', $bo_set_file);
$tpl->assign('bo_comment', $bo_comment);
$tpl->assign('bo_recom', $bo_set_recom);

if (!empty($bo_list_mal)) {
	$list_mal = "Y";
} else {
	$list_mal = "N";
}
$tpl->assign('list_mal', $list_mal);
$tpl->assign('bo_list_mal', $bo_list_mal);


if ($notice_list_query != false) {

	$notice_loop = array();
	for ($i=0;$i<count($notice_list_query);$i++) {
		if ($bo_set_title_length < 9) {					
			$bo_set_title_length = 30;
		}
		$notice_list_query[$i]['title'] = mb_strimwidth($notice_list_query[$i]['title'], 0, $bo_set_title_length, "...", "UTF-8");	// 제목
		$notice_list_query[$i]['list_number'] = "[공지]";
		$notice_loop[] = $notice_list_query[$i];
	}
}


if ($list_query != false) {
	$number = $query_number - $first + 1;
	$list_loop = array();
	for ($i=0;$i<count($list_query);$i++) {
		if ($bo_set_title_length < 9) {						// 기본길이가 10 보다 작을땐 기본 길이 30으로 책정 해놈
			$bo_set_title_length = 30;
		}
		$list_query[$i]['title'] = mb_strimwidth($list_query[$i]['title'], 0, $bo_set_title_length, "...", "UTF-8");	// 제목
		$list_query[$i]['list_number'] = $number;
		$list_loop[] = $list_query[$i];
		$number--;
	}
}


if (!$board_skin) {
	$board_skin = "basic";
}
$page_list_url = $MY_URL."_template/skin/board/".$board_skin;


if ($bo_list_state == "B") {
	$page_html = "list.html";
} else if($bo_list_state == "G") {
	$page_html = "gallery_list.html";
} else {
	$page_html = "list.html";
}

$tpl->define('content', "skin/board/$board_skin/$page_html");


$page_list = go_page_list($query_number, $num_per_page, $num_per_block, $list_page, "./index.php?bo_num=$bo_num&", $key, $searchword,$mode);


$tpl->assign('bo_file', $bo_file);

$tpl->assign('bo_num', $bo_num);	
$tpl->assign('key', $key);
$tpl->assign('searchword', $searchword);
$tpl->assign('list_page', $list_page);
$tpl->assign('param', $param);

$tpl->assign('list_query', $list_query);
$tpl->assign('page_list', $page_list);
$tpl->assign('notice_list', $notice_loop);
$tpl->assign('list', $list_loop);




$tpl->print_('frame');
?>

