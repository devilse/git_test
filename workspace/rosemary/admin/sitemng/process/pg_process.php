<?php
header('Content-Type: text/html;charset=utf-8');
include "../../../_lib/function.php";	// 관리자 페이지 공용 함수 파일
include "../../../_lib/db_conn.php";	// 디비 접속
include "../../../_lib/global.php";	// 관리자 페이지 공용 변수 파일
include "../../../_lib/lib.php";	// 관리자 페이지 공용 디비 함수 파일


$mode = $_POST['mode'];

$array = $_POST;
$key = array_keys($array);

$t_chk = true;	//쿼리 이상유무 체크 변수 
mysqli_query($CONN['rosemary'],"set autocommit = 0;");
mysqli_query($CONN['rosemary'],"begin;");


for($i=0; $i<count($key); $i++) {
	if ($key[$i] != "mode") {
		$result = $key[$i] . "=>" . $array[$key[$i]];
		$so_key = $key[$i];
		$so_val = addslashes(trim($array[$key[$i]]));
	
		if (empty($so_val)) {
			$del_query = mysqli_query($CONN['rosemary'],"delete from site_option where so_key = '$so_key'");
			if (!$del_query) {
				$t_chk = false;
			}
		} else {
			$chk_query = mysqli_query($CONN['rosemary'],"select count(*) as cnt from site_option where so_key = '$so_key'");
			$chk_cnt = mysqli_result($chk_query,0,0);
			if ($chk_cnt) {
				$up_query = mysqli_query($CONN['rosemary'],"update site_option set so_val = '$so_val' where so_key = '$so_key'");
				if (!$up_query) {
					$t_chk = false;
				}
			} else {
				$in_query = mysqli_query($CONN['rosemary'],"insert into site_option(so_key,so_val) values('$so_key','$so_val')");
				if (!$in_query) {
					$t_chk = false;
				}
			}
		}
	}
	//echo $result."<br>";
}

if ($t_chk != true) {
	mysqli_query($CONN['rosemary'],"rollback;");
	alertback("설정변경 오류");
} else {
	mysqli_query($CONN['rosemary'],"commit;");	
	write_page();
	alertGo("","../index.php?mode=$mode");
}




// 사이트 기본 정보를 파일에 기록합니다.
function write_page()
{
	global $DOCUMENT_ROOT, $CONN;
	
	$site_info_list_query = mysqli_query($CONN['rosemary'], "SELECT * FROM site_option");
	$contents = "";
	while ($site_info_row = mysqli_fetch_array($site_info_list_query)) {
		$so_key = $site_info_row['so_key'];
		$so_val = $site_info_row['so_val'];
		$contents = $contents."$"."siteoption['".$so_key."'] = '".$so_val."';\n";		
	}
	writeFile($DOCUMENT_ROOT.'/_autocode/siteoption.php', getPHPTagString($contents));
}	



?>