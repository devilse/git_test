$(function(){
	$("#email_host").change(function(){
		$("#email2").val($(this).val());
	});
});

function sendemail() {
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
		url: "../member/process/send_confirm_email.php",
		data: {
			mb_num: $("input[name=mb_num]").val(),
			email: email 
			},
		dataType: "text",
		success: function(data) {
			if(data == "ok") {
				alert(email + " 으로\n가입인증 메일이 발송 되었습니다.\n메일을 확인 하신 후 인증을 진행하세요.");
				location.href = "../main/index.php";
			} else {
				alert(data);
			}
		},
		error: function(data) {
			alert(data.responseText);				
		}
	});
}