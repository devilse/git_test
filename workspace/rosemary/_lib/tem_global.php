<?php
// 해당 파일은 기본 공용 파일인 global.php 의 선언된 변수들을 템플릿 용으로 assign 해주는 파일이다.
// global.php 에 변수를 선언했다면 템플릿 파일에서 사용할려면 해당 파일에다가 assign을 해줘야 한다.

$tpl->assign('DOCUMENT_ROOT', $DOCUMENT_ROOT);	//홈디렉토리
$tpl->assign('MY_HOST', $MY_HOST);
$tpl->assign('MY_URL', $MY_URL);

$tpl->assign('dir_img', $dir_img);
$tpl->assign('dir_file', $dir_file);
$tpl->assign('dir_img_tmp', $dir_img_tmp);

//페이지 처리 공용 프로세스 파일 위치
$tpl->assign('board_process_url', $board_process_url);
$tpl->assign('qna_process_url', $qna_process_url);

// 페이징 변수 

$tpl->assign('page', $page);
$tpl->assign('num_per_page', $num_per_page);
$tpl->assign('num_per_block', $num_per_block);
$tpl->assign('first', $first);
$tpl->assign('limit', $limit);


// 접속 아이피	
$tpl->assign('host_ip', $host_ip);


// 현재 접속한 메뉴
$tpl->assign('current_menu_code', $current_menu_code);
$tpl->assign('current_menuIdx', $current_menuIdx);


?>