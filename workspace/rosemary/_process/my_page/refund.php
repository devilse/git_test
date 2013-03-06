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
	echo "X|로그인이 필요 합니다.";
	exit;
}

$os_num = $_POST['os_num'];
if (!$os_num) {
	echo "X|접근할 수 없습니다.";
	exit;
}

$refund_con = addslashes($_POST['refund_con']);								// 환불사유
$rf_bank_account_name = addslashes($_POST['rf_bank_account_name']);			// 예금주
$rf_bank_name = $_POST['rf_bank_name'];										// 은행
$rf_bank_account = addslashes(trim($_POST['rf_bank_account']));				// 계좌번호

// 해당 상품이 환불 목록에 들어가 있는지 체크한다.
$refund_chk = mysqli_query($CONN['rosemary'],"select os_num from refund where os_num = '$os_num'");
$refund_nums = mysqli_num_rows($refund_chk);
if ($refund_nums) {
	echo "X|해당 상품은 이미 환불 요청 상태 입니다.";
	exit;
}


// 해당 상품이 자신의 상품이 맞는지 체크한다.
$goods_query = "select * from ordersheet where os_num = '$os_num' and mb_num = '$mb_num'";
$cnt_query = mysqli_query($CONN['rosemary'],$goods_query);
$tot_cnt = mysqli_num_rows($cnt_query);
if (!$tot_cnt) {
	echo "X|등록된 내역이 아닙니다.";
	exit;
}
$goods_rs = mysqli_fetch_array($cnt_query);
$os_amt = $goods_rs['os_amt'];												// 환불금액
if ($goods_rs['os_type'] == "C") {											// 환불방법
	$rf_way = "C";
} else {
	$rf_way = "B";
}

$refund_qry = mysqli_query($CONN['rosemary'],"insert into refund(os_num,rf_reason,rf_bank_name,rf_bank_account,rf_bank_account_name,rf_amt,rf_way,rf_state,rf_sdate,rf_ip) values('$os_num','$refund_con','$rf_bank_name','$rf_bank_account','$rf_bank_account_name','$os_amt','$rf_way','A',unix_timestamp(),'$host_ip')");

if ($refund_qry) {
	echo "T|환불 요청 되었습니다.";
	exit;
} else {
	//alertclose("환불 요청중 오류가 발생 하였습니다.");
	echo "X|환불 요청중 오류가 발생 하였습니다.";
	exit;
}

?>