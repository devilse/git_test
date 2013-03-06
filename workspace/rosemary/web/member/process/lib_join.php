<?php
// 이메일 중복 여부를 반환합니다.
function email_check($email)
{
	if(mysqli_scalar("SELECT COUNT(*) FROM member WHERE mb_email = '$email'") > 0) {
		return true;
	} else {
		return false;
	}
}

// 아이디 중복 여부를 반환합니다.
function id_check($id)
{
	if(mysqli_scalar("SELECT COUNT(*) FROM member WHERE mb_id = '$id'") > 0) {
		return true;
	} else {
		return false;
	}
}


function email_check_info($email,$mb_num)	//mypage 에서 수정할경우
{
	if(mysqli_scalar("SELECT COUNT(*) FROM member WHERE mb_email = '$email' and mb_num != '$mb_num'") > 0) {
		return true;
	} else {
		return false;
	}
}

?>