<?php
header('Content-Type: text/html;charset=utf-8');

include "../../_lib/db_conn.php";	// 디비 접속
include "../../_lib/global.php";
include "../../_lib/function.php";
include "../../_lib/lib.php";

$cg_code = $_POST['cg_code'];
$mb_num = $_POST['mb_num'];

if (!$mb_num || !$cg_code) {
	echo "X|접근 할 수 없습니다.";
	exit;
}


$qry = mysqli_query($CONN['rosemary'],"select B.lt_num,B.lt_name from goods A, goods_lecture B where A.cg_code = '$cg_code' and A.g_num = B.g_num and B.mb_num = '$mb_num' order by B.lt_num desc");
$nums = mysqli_num_rows($qry);
if (!$nums) {
	echo "X|첨부된 파일이 없습니다.";
	exit;
}

ob_start();
echo "T|";



echo "
			<div class='add_list_s'>	
";
	while ($rs = mysqli_fetch_array($qry)) {
		$lt_name = $rs['lt_name'];
echo "
			<ul>
			<li><span class='a_name'>$lt_name </span></li>
			</ul>

";
	}
echo "

			</div>
";



$concon=ob_get_contents();
ob_end_clean();
echo $concon;



?>

