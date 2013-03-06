<?php
header('Content-Type: text/html;charset=utf-8');


include "../../../_lib/db_conn.php";	// 디비 접속
include "../../../_lib/global.php";
include "../../../_lib/function.php";
include "../../../_lib/lib.php";	// 관리자 페이지 공용 함수 파일


$gg_code = $_POST['gg_code'];

if (!$gg_code) {
	echo "X|선택 코드가 없음"; 
	exit;
}

$chk_query = mysqli_query($CONN['rosemary'],"select count(*) as cnt from goods_group where gg_code = '$gg_code'");
$chk_cnt = mysqli_result($chk_query,0,0);

if ($chk_cnt) {
	echo "X|중복"; 
	exit;
} else {
	echo "T|사용가능"; 
	exit;
}


?>