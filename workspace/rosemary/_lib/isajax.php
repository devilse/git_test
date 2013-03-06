<?php
// ajax 호출이 아니라면 HTTP 404 에러를 반환하고 페이지 실행을 중단합니다.
if(!(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest')) {
	header('HTTP/1.0 404 Not Found');
	exit;
}
?>