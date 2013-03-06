<?
header('Content-Type: text/html;charset=utf-8');

include "../../_lib/db_conn.php";	// 디비 접속
include "../../_lib/global.php";
include "../../_lib/function.php";
include "../../_lib/lib.php";	// 관리자 페이지 공용 함수 파일


// 로그인 체크
$User_Info =  Login_Chk($_COOKIE['LIPASS_ID']);
$mb_type = $User_Info['type'];
$mb_num = $User_Info['member_num'];
if (!$mb_type || $mb_type == "G" || !$mb_num) {
	alertback("로그인이 필요 합니다.");
}

$lt_num = $_POST['lt_num'];
$os_num = $_POST['os_num'];
$g_num = $_POST['g_num'];

if (!$lt_num || !$os_num || !$g_num) {
	alertback("접근 할 수 없습니다.");
}

// 해당 상품이 존재 하는지 체크한다.

$chk_query = mysqli_query($CONN['rosemary'],"select A.mbgl_term from member_goods_lecture A, member_goods B where A.lt_num = '$lt_num' and A.os_num = '$os_num' and A.g_num = '$g_num'  and A.os_num = B.os_num and A.g_num = B.g_num and B.mb_num = '$mb_num' and A.mbgl_state = 'C'");
$chk_nums = mysqli_num_rows($chk_query);

if (!$chk_nums) {
	alertback("존재하지 않는 강의 입니다.");
} else {
	$rs = mysqli_fetch_array($chk_query);
	$start_date = mktime();		// 수강 시작날짜 - 지금 이 시간이 됨
	$end_date = mktime() + (86400 * $rs['mbgl_term']);


	// 정지되어 잇던 히스토리 내역을 가져온다. 
	$history_qry = mysqli_query($CONN['rosemary'],"select * from member_goods_lecture_usehistory where os_num = '$os_num' and g_num = '$g_num' and lt_num = '$lt_num' and history_state = 2 order by mbglu_num desc limit 1");
	$history_nums = mysqli_num_rows($history_qry);
	if (!$history_nums) {	//만약에 로그가 하나도 존재하지 않는다면 프로세스를 중단하고 해당 강좌를 대기상태로 돌린다. 
		mysqli_query($CONN['rosemary'],"update member_goods_lecture set mbgl_state = 'A' where lt_num = '$lt_num' and os_num = '$os_num' and g_num = '$g_num'");
		alertback("히스토리 로그가 존재하지 않습니다. 관리자에게 문의 하세요.");
	} else {
		$history_rs = mysqli_fetch_array($history_qry);
		$history_num = $history_rs['mbglu_num'];
		$use_date = @round(($history_rs['mbglu_edate'] - $history_rs['mbglu_sdate']) / 86400,0);	// 사용한 기간
		$start_date = $start_date - (86400 * $use_date);
		$end_date = $end_date - (86400 * $use_date);
	}

	$t_chk = true;	
	mysqli_query($CONN['rosemary'],"set autocommit = 0;");
	mysqli_query($CONN['rosemary'],"begin;");

	$history_in = mysqli_query($CONN['rosemary'],"insert into member_goods_lecture_usehistory(mbglu_sdate,mbglu_edate,mbglu_regdate,mbglu_ip,os_num,g_num,lt_num) values('$start_date','$end_date',unix_timestamp(),'$host_ip','$os_num','$g_num','$lt_num')");
	if (!$history_in) {
		$t_chk = false;
	} else {						// 제대로 로그가 인설트 되었다면 상태를 업데이트 해준다.
		$state_up = mysqli_query($CONN['rosemary'],"update member_goods_lecture set mbgl_state = 'B' where lt_num = '$lt_num' and os_num = '$os_num' and g_num = '$g_num'");
		if (!$state_up) {
			$t_chk = false;
		}
	}

	if ($t_chk != true) {
		mysqli_query($CONN['rosemary'],"rollback;");
		alertback("디비 오류 발생 관리자에게 문의 하세요.");
	}else{
		mysqli_query($CONN['rosemary'],"commit;");	
		alertGo("","../../web/class/index.php");
	}	

}


?>
