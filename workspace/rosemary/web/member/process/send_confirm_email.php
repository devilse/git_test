<?php
// 가입된 이메일이면 true를 아니면 false를 반환합니다.
include '../../../_lib/isajax.php';
include "../../../_lib/function.php";
include "../../../_lib/db_conn.php";	
include "../../../_lib/global.php";	
include "../../../_lib/lib.php";
include "../../../_autocode/siteinfo.php";

$mb_num = trim($_POST['mb_num']);
$email = trim($_POST['email']);

// 중복여부 체크. 나 외에 다른 사람도 이 이메일을 사용하는지?
if(mysqli_scalar("SELECT COUNT(*) FROM member WHERE mb_num <> '$mb_num' AND mb_email = '$email'") > 0) {
	echo "이미 등록되어 있는 이메일 입니다.";
	exit;
}

if(mysqli_scalar("SELECT COUNT(*) FROM member a INNER JOIN member_student b ON a.mb_num = b.mb_num WHERE a.mb_num = '$mb_num' AND a.mb_email = '$email' AND b.ms_email_confirm_yn = 'Y'") > 0) {
	echo "이미 인증이 완료 되었습니다.";
	exit;
}

// 동일한 메일 계정으로 승인메일을 요청한 적이 있는지 확인합니다.
$confirm_result = mysqli_query($CONN['rosemary'], "SELECT * FROM member_student_confirm_email WHERE mb_num = '$mb_num' AND msc_confirm_yn = 'N' AND msc_email = '$email'");
if(mysqli_num_rows($confirm_result) > 0) {
	$confirm_rs = mysqli_fetch_array($confirm_result);
	$u_id = $confirm_rs['msc_uniqid']; 
} else {
	$u_id = uniqid("", true);
	if(!mysqli_query($CONN['rosemary'], "INSERT INTO member_student_confirm_email (msc_uniqid, mb_num, msc_regdate, msc_email) VALUES ('$u_id', '$mb_num', '".mktime()."', '$email')")) {
		echo mysqli_error($CONN['rosemary']);
		exit;
	}	
}

// 승인메일 발송
$auth_link = $MY_URL."web/member/process/confirm_email.php?mcd=$mb_num&ucd=$u_id";

$to  = $email;

// 제목
$subject = "[".$siteinfo['si_site_name']."] 이메일을 인증해주세요.";

// 메세지
$message = "
<html>
<head>
<title>이메일 인증</title>
</head>
<body>
안녕하세요. ".$siteinfo['si_site_name']." 관리자입니다.<br />
본 메일은 ".$siteinfo['si_site_name']." 회원의 이메일 가입인증 위한 안내 메일입니다.<br />
<br />
아래 링크를 클릭하여 이메일 인증을 진행 해 주시길 바랍니다.<br />
<br />
링크<br />
<a href=\"$auth_link\">$auth_link</a><br />
<br />
회원가입 오류 문의전화 ".$siteinfo['si_tel']."
</body>
</html>
";

// 메일 보내기
if(sendSimpleMail("", $email, $siteinfo['si_site_name'], $siteinfo['si_email'], "[".$siteinfo['si_site_name']."] 이메일을 인증해주세요.", $message)) {
	echo "ok";
} else {
	echo "승인 메일 전송을 실패하였습니다.";
}
?>