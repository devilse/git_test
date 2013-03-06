<?php
// 가입된 이메일이면 true를 아니면 false를 반환합니다.
include '../../../_lib/isajax.php';
include "../../../_lib/function.php";
include "../../../_lib/db_conn.php";	
include "../../../_lib/global.php";	
include "../../../_lib/lib.php";
include "lib_join.php";

$email = trim($_POST['email']);

if(email_check($email)) {		
	echo 'true';
} else {
	echo 'false';
}
?>