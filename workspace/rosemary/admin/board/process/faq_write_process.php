<?php
header('Content-Type: text/html;charset=utf-8');

include "../../../_lib/db_conn.php";	// 디비 접속
include "../../../_lib/global.php";
include "../../../_lib/function.php";
include "../../../_lib/lib.php";


$User_Info =  Login_Chk($_COOKIE['LIPASS_ID']);		// 로그인 체크
if (!$User_Info) {
	echo "X|로그인이 필요합니다.";
	exit;
}

$mb_type = $User_Info['type'];						// 멤버타입
if ($User_Info['type'] != "G") {
	$mb_id = $User_Info['id'];						// 멤버아이디
	$mb_password = "";								// 멤버 비밀번호
	$mb_name = addslashes($User_Info['name']);		// 멤버 네임
}	

$title		= addslashes(trim($_POST['title']));	// 제목
$contents	= $_POST['content'];					// 내용
$mal	= $_POST['mal'];							// 유저아이피
$write_mode = $_POST['write_mode'];


if (!$title) {
	echo "X|제목을 입력해 주세요.";
	exit;
}
if (!$contents) {
	echo "X|내용을 입력해 주세요.";
	exit;
}

$contents = addslashes(trim($contents));			// 내용





	
if (!$write_mode) {	// 글쓰기

	$in_query = mysqli_query($CONN['rosemary'],"insert into faq(mal,title,contents,reg_date) values('$mal','$title','$contents',unix_timestamp())");	
	if ($in_query) {
		echo "T|";
		exit;
	} else {
		echo "X|디비 인설트 오류.";
		exit;
	}



}else if($write_mode == "modi"){

	$faq_num = $_POST['faq_num'];
	if (!$faq_num) {
		echo "X|접근할 수 없습니다.";
		exit;
	}

	$in_query = mysqli_query($CONN['rosemary'],"update faq set title = '$title', contents = '$contents', mal = '$mal' where faq_num = '$faq_num'");	
	if ($in_query) {
		echo "T|";
		exit;
	} else {
		echo "X|디비 인설트 오류.";
		exit;
	}	

}

?>

