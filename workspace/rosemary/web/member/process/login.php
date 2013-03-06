<?
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
// HTTP/1.0
header("Pragma: no-cache");
header('Content-Type: text/html;charset=utf-8');

include "../../../_lib/function.php";
include "../../../_lib/db_conn.php";	
include "../../../_lib/global.php";	
include "../../../_lib/lib.php";	

$id = $_POST['id'];
$pwd = $_POST['pwd'];

if(!$id) alertback("아이디를 입력해 주세요.");
if(!$pwd) alertback("비밀번호를 입력해 주세요.");

// 해당 부분에서 관리자 디비 검사 해야함.
// 패스워드 체크 아직 안해놈. 아이디로만 체킹 
$login_query = mysqli_query($CONN['rosemary'],"select * from member where mb_id = '$id'");
$login_nums = mysqli_num_rows($login_query);

if ($login_nums == 0) {
	alertback("아이디 혹은 패스워드를 확인해 주세요.");
}

$login_rs = mysqli_fetch_array($login_query);

$mb_num = $login_rs['mb_num'];
$mb_name = $login_rs['mb_name'];
$mt_code = $login_rs['mt_code'];

$admin_type = "";
$admin_access_menuIdx = ""; 						// 일반관리자의 경우 접근할 수 있는 menuIdx

if($mt_code == "A") {
	$admin_query = mysqli_query($CONN['rosemary'], "select * from member_admin where mb_num = '$mb_num'");
	if(mysqli_num_rows($admin_query) > 0) {
		$admin_rs = mysqli_fetch_array($admin_query);
		
		$admin_type = $admin_rs['ma_type'];
		$admin_access_menuIdx = $admin_rs['ma_access_menucode'];
	}	
}

$email_confirm = "Y";
if($mt_code == "S") {
	// 학생인 경우에는 이메일 승인 여부를 DB에서 가져옵니다.
	$email_confirm = mysqli_scalar("select ms_email_confirm_yn from member_student where mb_num = '$mb_num'"); 
}

if($email_confirm == "Y") {
	$Cookie_LIE = $mt_code.'|'.
				  strtolower($id).'|'.
				  $mb_name.'|'.
				  $admin_access_menuIdx.'|'.
				  $admin_type.'|'.
				  $mb_num.'|';
	$new_encrypt = trim(skcrypt($Cookie_LIE));
	
	setcookie("LIPASS_ID", $new_encrypt, 0, "/");
	
	if($_POST['save_id'] == "Y") {
		setcookie("save_id", $id, time() + (3600 * 24 * 356), "/");
	} else {
		setcookie("save_id", "", time() - (3600 * 24 * 356), "/");
	}
	
	Set_Login_log($mb_num);
	
	if(empty($_POST['return_uri'])) {
		alertGo("","../../main/index.php");
	} else {
		alertGo("", urldecode($_POST['return_uri']));
	}
} else {
	$Cookie_Confirm = $mb_num;
	setcookie("EMAIL_CONFIRM", $Cookie_Confirm, 0, "/");
	
	alertGo("","../../member/joinend.php");
}
?>