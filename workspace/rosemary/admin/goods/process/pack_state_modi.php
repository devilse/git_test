<?php
header('Content-Type: text/html;charset=utf-8');

include "../../../_lib/db_conn.php";	// 디비 접속
include "../../../_lib/global.php";
include "../../../_lib/function.php";
include "../../../_lib/lib.php";	// 관리자 페이지 공용 함수 파일

$User_Info =  Login_Chk($_COOKIE['LIPASS_ID']);
$mb_type = $User_Info['type'];
if ($mb_type != "A") {
	echo "X|접근 할 수 없습니다.";
	exit;
}

$gp_num = $_POST['gp_num'];
$val = $_POST['val'];

if (!$val || !$gp_num) {
	echo "X|접근 할 수 없습니다.";
	exit;
}

if ($val != "R" && $val != "S" && $val != "N") {
	echo "X|접근 할 수 없습니다.";
	exit;
}



$up_qry = mysqli_query($CONN['rosemary'],"update goods_package set gp_state = '$val' where gp_num = '$gp_num'");
if (!$up_qry) {
	echo "X|디비 오류 발생.";
	exit;
} else {
	if ($val == "R") {
		$msg = "준비중";
	} else if ($val == "S") {
		$msg = "판매중";
	} else {
		$msg = "판매중지";
	}
	echo "T|해당 패키지 상품의 상태가 [$msg]으로 변경 되었습니다.";
	exit;
}




?>