<?php
// 가입된 이메일이면 true를 아니면 false를 반환합니다.
include '../../../_lib/isajax.php';
include "../../../_lib/function.php";
include "../../../_lib/db_conn.php";	
include "../../../_lib/global.php";	
include "../../../_lib/lib.php";
include "lib_join.php";

$id = trim($_POST['id']);

if(id_check($id)) {		
	echo 'true';
} else {
	echo 'false';
}
?>