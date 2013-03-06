function joincheck() {
	if($("input[name=checkbox_clause]:checkbox").is(":checked") == true &&
		$("input[name=checkbox_privacy]:checkbox").is(":checked") == true) {
		location.href="../member/joincheck.php";
	} else {
		alert("회원가입을 진행 하시려면 약관을 확인한 후 약관 동의에 모두 체크해주시기 바랍니다.");
	}			
}