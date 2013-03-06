$(function(){
	$("#email_host").change(function(){
		$("#email2").val($(this).val());
	});
});

function emailcheck() {
	var email1 = $("#email1");
	if($.trim(email1.val()) == "") {
		email1.val("");
		email1.focus();
		alert("이메일을 입력해주세요.");
		return;
	}
	
	var email2 = $("#email2");
	if($.trim(email2.val()) == "") {
		email2.val("");
		email2.focus();
		alert("이메일을 입력해주세요.");
		return;
	}
	
	var email = $.trim(email1.val()) + "@" + $.trim(email2.val());
	if(emailCheck(email) == false) {
		alert("이메일 형식에 맞게 입력해주세요.");
		return;
	}
	
	$.ajax({
		type: "POST",
		url: "../member/process/join_email_check.php",
		data: { email: email },
		dataType: "text",
		success: function(data) {
			if(data == "true") {
				// 중복되었을 경우
				alert(email + "는 등록되어 있는 이메일입니다.\n\n아이디 찾기를 이용하거나 고객 센터로 문의해주세요.");					
			} else {
				$("#join_form").submit();
			}
		},
		error: function(data) {
			alert(data.responseText);				
		}
	});
}