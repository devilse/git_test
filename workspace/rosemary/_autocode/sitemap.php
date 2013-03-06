<?php
// 이 곳에서 학습자의 사이트맵 구조를 정의합니다. 나중에 DB의 정보를 기준으로 자동생성 될 수 있습니다.
$sitemap = array(
		"01" => array("1001", "수강신청", "#",
				"0101" => array("1101", "합격패키지", "../goods/package_list.php"),
				"0102" => array("1201", "[LS:0:../goods/index.php?ca_num={0}]", "#"),			// LS 상품 카테고리가 들어오는 부분
				"0103" => array("1301", "교재구매", "../goods/book_list.php")
			),
		"02" => array("2001", "참여마당", "../board/index.php?bo_num=69624",
				"0201" => array("2101", "합격수기", "../board/index.php?bo_num=69624"),
				"0202" => array("2201", "구인구직", "../board/index.php?bo_num=69625"),
				"0203" => array("2301", "자유게시판", "../board/index.php?bo_num=69626")
			),
		"03" => array("3001", "교수소개", "../teacher/index.php",
				"0301" => array("3101", "전체 교수소개", "../teacher/index.php"),
				"0302" => array("3201", "[LS:1:../teacher/index.php?ca_num={0}]", "#")),
		"04" => array("4001", "수험정보", "../board/index.php?bo_num=69627",
				"0401" => array("4101", "시험뉴스", "../board/index.php?bo_num=69627"),
				"0402" => array("4201", "합격가이드", "../content/index.php?cid=passguide"),
				"0403" => array("4301", "기출문제", "../board/index.php?bo_num=69628"),
				"0404" => array("4401", "강의자료실", "../board/index.php?bo_num=69630")
			),
		"05" => array("5001", "학습자료실", "../content/index.php?cid=counseldown",
				"0501" => array("5101", "필수프로그램 다운로드", "../content/index.php?cid=counseldown"),
				"0502" => array("5201", "병과별 경력인증", "../content/index.php?cid=armysevice"),
				"0503" => array("5301", "서식다운로드", "../board/index.php?bo_num=69631")
			),
		"06" => array("6001", "고객센터", "../board/index.php?bo_num=69623",
				"0601" => array("6101", "공지사항", "../board/index.php?bo_num=69623"),				
				"0602" => array("6301", "SOS Center", "../content/index.php?cid=counseltime"),
				"0603" => array("6401", "자주묻는 질문", "../faq/index.php"),
				"0604" => array("6501", "이벤트", "../board/index.php?bo_num=69632")
			),
		"07" => array("7001", "나의 강의실", "#",
				"0701" => array("7101", "강의함", "#"),
				"0702" => array("7201", "강의자료실", "#"),
				"0703" => array("7301", "질의응답", "#"),								
				"0706" => array("7601", "SOS Center", "#"),
				"0707" => array("7701", "D-day 설정", "#")
			),
		"08" => array("8001", "라이패스", "../main/content.php?cid=introduce",
				"0801" => array("8101", "회사소개", "../content/index.php?cid=introduce"),
				"0802" => array("8601", "오시는길", "../content/index.php?cid=location"),
				"0803" => array("8201", "이용약관", "../content/clause.php"),
				"0804" => array("8301", "개인정보취급방침", "../content/privacy.php"),
				"0805" => array("8401", "사이트맵", "../content/sitemap.php"),
				"0806" => array("8501", "이메일 추출방지정책", "../content/index.php?cid=nospam")				
			),
		"09" => array("9001", "회원", "../member/login.php",
				"0901" => array("9101", "로그인", "../member/login.php"),
				"0902" => array("9201", "회원가입", "../member/join.php"),
				"0903" => array("9301", "ID/PW 찾기", "../member/idpw.php")
			),
		"10" => array("7801", "마이페이지", "../mypage/my_info.php",
				"1001" => array("7811", "개인정보수정", "../mypage/my_info.php"),
				"1002" => array("7821", "비밀번호변경", "../mypage/change_pwd.php"),
				"1003" => array("7411", "주문결제내역", "../mypage/my_pay.php"),
				"1004" => array("7421", "라이카트", "#"),
				"1005" => array("6201", "1:1 상담", "../qna/index.php"),
				"1006" => array("7841", "회원탈퇴", "../mypage/member_draw.php")
			)
		);

/* 사이트맵을 INSERT 쿼리로 만드는 코드
foreach ($sitemap as $sKey => $sVal) {
	if(is_array($sVal)) {
		echoInsertQuery($sitemap[$sKey][0], $sKey, $sitemap[$sKey][1], $sitemap[$sKey][2]);
		foreach ($sitemap[$sKey] as $gKey => $gVal) {
			if(is_array($gVal)) {
				echoInsertQuery($sitemap[$sKey][$gKey][0], $gKey, $sitemap[$sKey][$gKey][1], $sitemap[$sKey][$gKey][2]);
				foreach ($sitemap[$sKey][$gKey] as $mKey => $mVal) {
					if(is_array($mVal)) {
						echoInsertQuery($sitemap[$sKey][$gKey][$mKey][0], $mKey, $sitemap[$sKey][$gKey][$mKey][1], $sitemap[$sKey][$gKey][$mKey][2]);
					}
				}
			}			
		}
	}
	echo "<br />";
}

function echoInsertQuery($menuIdx, $menuTree, $menuName, $menuLink)
{
	echo "INSERT INTO site_menu (sm_num, sm_treecode, sm_name, sm_link) VALUES ('$menuIdx', '$menuTree', '$menuName', '$menuLink');<br />";
}
*/
?>