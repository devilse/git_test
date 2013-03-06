<?php
// 이곳에서 교수자 페이지의 사이트맵 구조를 정의합니다.
$sitemap = array(
		"01" => array("회원 관리", "/admin_teacher/member/index.php",
			"0101" => array("회원 관리",
				"010101" => array("101", "회원 명단 보기", "#")
			)
		),
		"02" => array("강의 관리", "/admin_teacher/lesson/index.php",
			"0201" => array("강의 관리",
				"020101" => array("201", "내 강의 보기", "#")
			)
		),
		"03" => array("게시판 관리", "/admin_teacher/board/index.php",
			"0301" => array("게시판 관리",
				"030101" => array("301", "질문과 답변", "#"),
				"030102" => array("302", "자료실", "#")
			)
		),
		"04" => array("매출 관리", "/admin_teacher/sales/index.php",
			"0401" => array("매출 관리",
				"040101" => array("401", "결제 내역 확인", "#"),
				"040102" => array("402", "환불 확인", "#"),
				"040103" => array("403", "월별 매출 통계", "#")
			)
		),		
		"05" => array("마이페이지", "/admin_teacher/mypage/index.php",
			"0501" => array("마이페이지",
				"050101" => array("501", "개인정보 수정", "#"),
				"050102" => array("502", "비밀번호 변경", "#")
			)
		)
	);
?>