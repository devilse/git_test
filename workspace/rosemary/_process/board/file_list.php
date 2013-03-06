<?php
header('Content-Type: text/html;charset=utf-8');

include "../../_lib/db_conn.php";	// 디비 접속
include "../../_lib/global.php";
include "../../_lib/function.php";
include "../../_lib/lib.php";

$list_num = $_POST['list_num'];

if (!$list_num) {
	echo "X|선택한 게시물이 없습니다.";
	exit;
}


$file_qry = mysqli_query($CONN['rosemary'],"select * from board_file where list_num = '$list_num'");
$file_nums = mysqli_num_rows($file_qry);
if (!$file_nums) {
	echo "X|첨부된 파일이 없습니다.";
	exit;
}

ob_start();
echo "T|";



echo "
			<div class='add_list_s'>	
";
	while ($rs = mysqli_fetch_array($file_qry)) {
		$file_name = $rs['file_name'];
		$file_tmp_name = $rs['file_tmp_name'];
		$file_size =  viewSizeToByte($rs['file_size']);
echo "
			<ul>
			<li><span class='a_name'><a href=\"javascript:set_download('$file_tmp_name','$file_name')\">$file_name ($file_size)</span><span class='a_down'><img src='".$MY_URL."_template/skin/board/basic/images/board/s_down2.png' alt='' /></span></a></li>
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

