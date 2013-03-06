$(function(){
	var today = new Date();
	var year_s = today.getFullYear() - 100;
	var year_d = today.getFullYear();

	var set_y = document.getElementById("birthday_1");
	var set_m = document.getElementById("birthday_2");
	var set_d = document.getElementById("birthday_3");
	
	// 년 생성
	for(var i = year_s; i < year_d; i++) {
		$("#birth_year").append('<option value="' + i + '">' + i + '</option>');
	}
	
	// 년 중간정도 선택
	if (set_y != null) {
		set_y_val = parseInt(set_y.value);
		if (set_y_val > 0) {
			$("#birth_year").val(set_y_val);
		} else {
			$("#birth_year").val(year_d - ((year_d - year_s) / 2));
		}
	} else {
		$("#birth_year").val(year_d - ((year_d - year_s) / 2));
	}
	
	// 월 중간정도 선택
	if (set_m != null) {
		set_m_val = parseInt(set_m.value);
		if (set_m_val > 0) {
			$("#birth_month").val(set_m_val);
		} else {
			$("#birth_month").val("6");
		}
	} else {
		$("#birth_month").val("6");
	}

	
	
	// 일 계산하여 넣어주고 15일 선택
	reloadDay();
	if (set_d != null) {
		set_d_val = parseInt(set_d.value);
		if (set_d_val > 0) {
			$("#birth_day").val(set_d_val);
		} else {
			$("#birth_day").val("15");
		}
	} else {
		$("#birth_day").val("15");
	}

	
	
	// 년이나 월이 변경될 때 마다 일을 다시 계산해서 넣어줍니다.
	$("#birth_year").change(function() {
		if($("#birth_month").val() == "02") {
			reloadDay();
		}
	});
	
	$("#birth_month").change(function() {
		reloadDay();
	});
	
	var id_rule_msg = "영문 소문자, 숫자 조합 5-20자(-,_사용가능)";
	$("#id_result_msg").text(id_rule_msg);
	
	$("input[name=mb_id]").keyup(function() {
		change_css("id_result_msg", "");
		$("#id_result_msg").text(id_rule_msg);
	});
	
	$("input[name=mb_id]").change(function() {
		join_id_check();
	});		
	
	$("input[name=mb_password]").keyup(function() {
		password_rule_check($(this).val());
	});
	
	$("input[name=mb_password_confirm]").keyup(function() {
		password_confirm_check();
	});
});

// 일 다시 고침
function reloadDay() {
	var oldDay = $("#birth_day").val();
	
	$("#birth_day option").remove();
	var day_d = getEndDay($("#birth_year").val(), $("#birth_month").val());
	for(var i = 1; i <= day_d; i++) {
		$("#birth_day").append('<option value="' + i + '">' + i + '</option>');
	}
	
	$("#birth_day").val(oldDay);
}

// 주어진 달의 마지막 일을 반환합니다.
function getEndDay(year, month) {
	var endList = new Array(31,28,31,30,31,30,31,31,30,31,31,31);
	if(( (Number(year) % 4 == 0) && (Number(year) % 100 != 0) ) || (Number(year) % 400 == 0) ) { 
		endList[1] = 29;
	}
	
	return endList[Number(month) - 1];
}

// 아이디 중복 여부 및 사용가능 여부를 체크합니다.
function join_id_check() {				
	var id = $("input[name=mb_id]").val();
	if(id_rule_check(id) == false) {
		change_css("id_result_msg", "red");
		$("#id_result_msg").text("사용 불가능한 아이디입니다.");
		return false;
	}
	
	$.ajax({
		type: "POST",
		url: "../member/process/join_id_check.php",
		data: { id: id },
		dataType: "text",
		success: function(data) {
			if(data == "true") {
				// 중복되었을 경우					
				change_css("id_result_msg", "red");					
				$("#id_result_msg").text("중복된 아이디가 존재합니다.");
				return false;
			} else {
				change_css("id_result_msg", "blue");
				$("#id_result_msg").text("사용 가능한 아이디입니다.");					
				return true;
			}
		},
		error: function(data) {
			alert(data.responseText);
			return false;
		}
	});
}

// 아이디 규칙 체크
function id_rule_check(str_id) {
	var filter = /^[a-z0-9\-_]{5,20}$/g;
	return filter.test(str_id);
}

// css class를 교체합니다.
function change_css(e_id, css_name) {
	var ele = $("#" + e_id);
	var colorArray = ["red", "blue"];
	
	for(var i = 0; i < colorArray.length; i++) {
		if(ele.is("." + colorArray[i])) {
			if(colorArray[i] != css_name) {
				ele.removeClass(colorArray[i]);
			} else {
				
			}
		} else {
			if(colorArray[i] == css_name) {
				ele.addClass(colorArray[i]);
			}
		}
	}
}

// 비밀번호 규칙 체크
function password_rule_check(str_pwd) {
	if(str_pwd == "") {
		change_css("password_result_msg", "");
		$("#password_result_msg").text("영문, 숫자, 특수문자 조합 6-20자");
		return false;
	}
	
	var rule1 = /^[a-zA-Z0-9~!@#$%\^&*()\-_+=\|\\{}\[\];:\"\'.<>,?/`]{6,20}$/;
	var rule2 = /[a-zA-Z]+/;
	var rule3 = /[0-9]+/;
	var rule4 = /[~!@#$%\^&*()\-_+=\|\\{}\[\];:\"\'.<>,?/`]+/;
	var rule5 = /^.{6,20}$/;
	var rule6 = /[^a-zA-Z0-9~!@#$%\^&*()\-_+=\|\\{}\[\];:\"\'.<>,?/`]+/;
	
	if(rule6.test(str_pwd)) {
		change_css("password_result_msg", "red");
		$("#password_result_msg").text("비밀번호에 허용하지 않는 문자가 들어갔습니다.");
		return false;
	}
	
	if(rule2.test(str_pwd) && !rule3.test(str_pwd) && !rule4.test(str_pwd)) {
		change_css("password_result_msg", "red");
		$("#password_result_msg").text("비밀번호를 영문으로만 사용할 수 없습니다.");
		return false;
	}
	
	if(!rule2.test(str_pwd) && rule3.test(str_pwd) && !rule4.test(str_pwd)) {
		change_css("password_result_msg", "red");
		$("#password_result_msg").text("비밀번호를 숫자로만 사용할 수 없습니다.");
		return false;
	}
	
	if(!rule2.test(str_pwd) && !rule3.test(str_pwd) && rule4.test(str_pwd)) {
		change_css("password_result_msg", "red");
		$("#password_result_msg").text("비밀번호를 특수문자로만 사용할 수 없습니다.");
		return false;
	}			
	
	if(!rule5.test(str_pwd)) {
		change_css("password_result_msg", "red");
		$("#password_result_msg").text("비밀번호는 6-20자 사이입니다.");
		return false;
	}
	
	if(rule1.test(str_pwd)) {
		change_css("password_result_msg", "blue");
		$("#password_result_msg").text("사용 가능한 비밀번호 입니다.");
		return true;
	} else {
		change_css("password_result_msg", "red");
		$("#password_result_msg").text("사용할 수 없는 비밀번호 입니다.");
		return false;
	}
}

function password_confirm_check() {
	if($("input[name=mb_password]").val() != "") {
		if($("input[name=mb_password]").val() != $("input[name=mb_password_confirm]").val()) {
			change_css("password_confirm_result_msg", "red");
			$("#password_confirm_result_msg").text("비밀번호 확인이 일치하지 않습니다.");
			return false;
		} else {
			change_css("password_confirm_result_msg", "blue");
			$("#password_confirm_result_msg").text("일치합니다.");
			return true;
		}
	} else {
		return false;
	}
}

// 서버에 전송하기전 최종 확인
function submit_check() {
	// 아이디 유효성 및 중복 체크
	if(join_id_check() == false) {
		alert("아이디를 확인해주세요.");
		$("input[name=mb_id]").focus();
		return;
	}
	
	// 비밀번호 유효성 체크
	if(password_rule_check($("input[name=mb_password]").val()) == false) {
		alert("비밀번호를 확인해주세요.");
		$("input[name=mb_password]").focus();
		return;
	}
	
	// 비밀번호 확인 체크
	if(password_confirm_check() == false) {
		alert("비밀번호와 비밀번호 확인이 일치하지 않습니다.");
		$("input[name=mb_password_confirm]").focus();
		return;
	} 
	
	// 이름 입력여부 체크
	if($.trim($("input[name=mb_name]").val()) == "") {
		alert("이름을 입력해주세요.");
		$("input[name=mb_name]").focus();
		return;
	}
	
	// 성별 입력여부 체크
	if($("input[name=ms_sex]:checked").size() == 0) {
		alert("성별을 선택해주세요.");
		return;
	}
	
	// 연락처 1개 이상 입력했는지 체크
	if( ($.trim($("input[name=mb_hp2]").val()) == "" || $.trim($("input[name=mb_hp3]").val()) == "") &&
		($.trim($("input[name=mb_tel2]").val()) == "" || $.trim($("input[name=mb_tel3]").val()) == "")) {
		alert("연락처는 1개 이상 입력해주세요.");
		return;
	}
	
	// 연락처 유효성 검사
	var ruleTel1 = /^[0-9]{3,4}$/;
	var ruleTel2 = /^[0-9]{4}$/;
	
	if(($.trim($("input[name=mb_tel2]").val()) != "" && $.trim($("input[name=mb_tel3]").val()) != "")) {
		if(ruleTel1.test($("input[name=mb_tel2]").val()) == false) {
			alert("일반전화 번호를 확인해주세요.");
			$("input[name=mb_tel2]").focus();
			return;
		}
		if(ruleTel2.test($("input[name=mb_tel3]").val()) == false) {
			alert("일반전화 번호를 확인해주세요.");
			$("input[name=mb_tel3]").focus();
			return;
		}
	}
	
	if(($.trim($("input[name=mb_hp2]").val()) != "" && $.trim($("input[name=mb_hp3]").val()) != "")) {
		if(ruleTel1.test($("input[name=mb_hp2]").val()) == false) {
			alert("휴대전화 번호를 확인해주세요.");
			$("input[name=mb_hp2]").focus();
			return;
		}
		if(ruleTel2.test($("input[name=mb_hp3]").val()) == false) {
			alert("휴대전화 번호를 확인해주세요.");
			$("input[name=mb_hp3]").focus();
			return;
		}
	}
	
	// ajax로 서버에 던짐
	$.ajax({
		type: "POST",
		url: "../member/process/joincon_process.php",
		data: { 
			mb_id: $("input[name=mb_id]").val(),
			mb_password: $("input[name=mb_password]").val(),
			mb_name: $("input[name=mb_name]").val(),
			birth_year: $("select[name=birth_year]").val(),
			birth_month: $("select[name=birth_month]").val(),
			birth_day: $("select[name=birth_day]").val(),
			email1: $("input[name=email1]").val(),
			email2: $("input[name=email2]").val(),
			mb_tel1: $("select[name=mb_tel1]").val(),
			mb_tel2: $("input[name=mb_tel2]").val(),
			mb_tel3: $("input[name=mb_tel3]").val(),
			mb_hp1: $("select[name=mb_hp1]").val(),
			mb_hp2: $("input[name=mb_hp2]").val(),
			mb_hp3: $("input[name=mb_hp3]").val(),
			ms_sex: $("input[name=ms_sex]:checked").val(),
			ms_zipcode1: $("input[name=ms_zip1]").val(),
			ms_zipcode2: $("input[name=ms_zip2]").val(),
			ms_address: $("input[name=ms_address]").val(),
			ms_address_detail: $("input[name=ms_address_detail]").val(),
			ms_email_yn: $("input[name=ms_email_yn]:checked").val(),
			ms_sms_yn: $("input[name=ms_sms_yn]:checked").val()
			},
		dataType: "text",
		success: function(data) {								
			if(data == "ok") {
				// 성공
				$("#join_form").submit();
			} else {
				// 실패
				alert(data);
			}				
		},
		error: function(data) {
			alert(data.responseText);
			return;
		}
	});
}



function submit_modi_check() {
	// 아이디 유효성 및 중복 체크
	if($.trim($("input[name=mb_name]").val()) == "") {
		alert("이름을 입력해주세요.");
		$("input[name=mb_name]").focus();
		return;
	} 
// 연락처 1개 이상 입력했는지 체크
	if( ($.trim($("input[name=mb_hp2]").val()) == "" || $.trim($("input[name=mb_hp3]").val()) == "") &&
		($.trim($("input[name=mb_tel2]").val()) == "" || $.trim($("input[name=mb_tel3]").val()) == "")) {
		alert("연락처는 1개 이상 입력해주세요.");
		return;
	}
	
	// 연락처 유효성 검사
	var ruleTel1 = /^[0-9]{3,4}$/;
	var ruleTel2 = /^[0-9]{4}$/;
	
	if(($.trim($("input[name=mb_tel2]").val()) != "" && $.trim($("input[name=mb_tel3]").val()) != "")) {
		if(ruleTel1.test($("input[name=mb_tel2]").val()) == false) {
			alert("일반전화 번호를 확인해주세요.");
			$("input[name=mb_tel2]").focus();
			return;
		}
		if(ruleTel2.test($("input[name=mb_tel3]").val()) == false) {
			alert("일반전화 번호를 확인해주세요.");
			$("input[name=mb_tel3]").focus();
			return;
		}
	}
	
	if(($.trim($("input[name=mb_hp2]").val()) != "" && $.trim($("input[name=mb_hp3]").val()) != "")) {
		if(ruleTel1.test($("input[name=mb_hp2]").val()) == false) {
			alert("휴대전화 번호를 확인해주세요.");
			$("input[name=mb_hp2]").focus();
			return;
		}
		if(ruleTel2.test($("input[name=mb_hp3]").val()) == false) {
			alert("휴대전화 번호를 확인해주세요.");
			$("input[name=mb_hp3]").focus();
			return;
		}
	}


		$.ajax({
			type : "POST" 
			, async : true 
			, url : "../../_process/my_page/info_modi.php" 
			, dataType : "html" 
			, timeout : 30000 
			, cache : false  
			, data : $("#join_form").serialize()
			, contentType: "application/x-www-form-urlencoded; charset=UTF-8"
			, error : function(request, status, error) {
				alert("ajax 통신서버에 접속할 수 업습니다.");
			}
			, success : function(response, status, request) {
				alert(response);
			}
		})	
	

}