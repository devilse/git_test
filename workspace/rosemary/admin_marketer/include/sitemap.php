<?php
// 이곳에서 관리자 페이지의 사이트맵 구조를 정의합니다.
$sitemap = array(
		"01" => array("회원 관리", "/admin_marketer/member/index.php",
			"0101" => array("회원 관리",
				"010101" => array("101", "회원 목록", "/admin_marketer/member/index.php"),
				"010102" => array("102", "빠른 상담 관리", "/admin_marketer/member/index.php?mode=fast")
			)
		),
		"02" => array("게시판 관리", "/admin_marketer/board/index.php",
			"0201" => array("게시판 관리",
				"020101" => array("201", "합격수기", "#")
			)
		),
		/*
		"03" => array("접속통계", "/admin_marketer/sitelog/index.php",
			"0301" => array("접속통계",
				"030101" => array("301", "접속통계 확인", "#")
			)
		),
		*/
		"04" => array("매출 관리", "/admin_marketer/sales/index.php",
			"0401" => array("매출 관리",
				"040101" => array("401", "결제 내역 확인", "#"),
				"040102" => array("402", "환불 확인", "#"),
				"040103" => array("403", "월별 매출 통계", "#")
			)
		),
		"05" => array("마이페이지", "/admin_marketer/mypage/index.php",
			"0501" => array("마이페이지",
				"050101" => array("501", "개인정보 수정", "/admin_marketer/mypage/index.php"),
				"050102" => array("502", "비밀번호 변경", "/admin_marketer/mypage/index.php?mode=pwd_set"),
				"050103" => array("503", "스크립트 관리", "/admin_marketer/mypage/index.php?mode=script")
			)
		)
	);
?>