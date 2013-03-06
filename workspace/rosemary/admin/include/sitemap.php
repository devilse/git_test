<?php
// 이곳에서 관리자 페이지의 사이트맵 구조를 정의합니다.

$board_query = mysqli_query($CONN['rosemary'],"select bo_num,bo_name from board");
$loop['0302'] =  array("게시물 관리");
$loop['0302']['030201'] = array("321", "전체 게시물 보기", "./index.php?mode=board_list");
$loop['0302']['030202'] = array("322", "#", "#");
$loop_number = "03";
$loop_number2 = "323";
while($board_rs = mysqli_fetch_array($board_query)){
	$array_number = "0302".$loop_number;
	$bbs_name = $board_rs['bo_name'];
	$menu_bo_num = $board_rs['bo_num'];
	$loop['0302'][$array_number] = array($loop_number2, $bbs_name, "./index.php?mode=board_list&bo_num=$menu_bo_num&sub_menu_num=$loop_number2");
	$loop_number++;
	$loop_number2++;
}


$sitemap = array(
		"01" => array("사이트관리", "/admin/sitemng/index.php",
			"0101" => array("기본정보",
				"010101" => array("101", "기본정보", "/admin/sitemng/index.php?mode=information"),
				"010102" => array("102", "이용약관", "/admin/sitemng/index.php?mode=clause"),
				"010103" => array("103", "개인정보보호정책", "/admin/sitemng/index.php?mode=privacy"),
				"010104" => array("104", "무통장 계좌번호", "/admin/sitemng/index.php?mode=account"),
				"010105" => array("105", "결제방식/전자결제", "/admin/sitemng/index.php?mode=pg"),
				"010106" => array("106", "기타 옵션", "/admin/sitemng/index.php?mode=etc")
			),
			/*"0102" => array("부가기능",				
				"010201" => array("121", "팝업관리", "#"),
				"010202" => array("122", "배너관리", "#")				
			),*/
			"0103" => array("접속통계",				
				"010301" => array("131", "접속통계확인", "/admin/sitemng/index.php?mode=analytics")
			)
		),
		"02" => array("회원관리", "/admin/member/index.php?mode=student",
			"0201" => array("회원관리",
				"020101" => array("201", "학습자", "/admin/member/index.php?mode=student"),
				"020102" => array("202", "교수자", "/admin/member/index.php?mode=teacher"),
				"020103" => array("203", "영업자", "/admin/member/index.php?mode=marketer"),
				"020104" => array("204", "관리자", "/admin/member/index.php?mode=admin")
			),
			"0202" => array("로그확인",
				"020201" => array("221", "로그인 로그", "/admin/member/index.php?mode=login_log"),
				"020202" => array("222", "수강 로그", "#")				
			)
		),
		"03" => array("게시판관리", "/admin/board/index.php?mode=board_set",
			"0301" => array("게시판 설정",
				"030101" => array("301", "게시판 설정 관리", "/admin/board/index.php?mode=bbs_set"),
				"030102" => array("301", "QNA 설정 관리", "/admin/board/index.php?mode=qna_set"),
				"030103" => array("302", "게시판 관리", "/admin/board/index.php?mode=board_set"),
			),
			$loop['0302'],
			"0303" => array("1:1상담/자주묻는질문",
				"030301" => array("341", "1:1 상담", "/admin/board/index.php?mode=qna_list"),
				"030302" => array("342", "자주묻는질문", "/admin/board/index.php?mode=faq")
			)
		),
		"04" => array("상품관리", "/admin/goods/index.php?mode=group",
			"0401" => array("분류관리",
				"040101" => array("401", "대분류 관리", "/admin/goods/index.php?mode=group"),
				"040102" => array("402", "카테고리 관리", "/admin/goods/index.php?mode=category")
			),
			"0402" => array("상품관리",				
				"040201" => array("421", "교재 관리", "/admin/goods/index.php?mode=books"),
				"040202" => array("422", "단과/강좌 관리", "/admin/goods/index.php?mode=goods"),
				"040203" => array("423", "패키지 관리", "/admin/goods/index.php?mode=package_list"),
				"040204" => array("424", "상품 목적그룹 관리", "/admin/goods/index.php?mode=sel_goods_list")
			)
		),
		"05" => array("매출관리", "/admin/sales/index.php?mode=ordersheet",
			"0501" => array("결제관리",
				"050101" => array("501", "주문서(결제내역) 관리", "/admin/sales/index.php?mode=ordersheet"),
				"050102" => array("502", "환불 관리", "/admin/sales/index.php?mode=refund")
			),
			"0502" => array("교재배송관리",
				"050201" => array("521", "교재 배송 관리", "#")
			),
			"0503" => array("매출통계",
				"050301" => array("531", "결제방법별 매출", "#"),
				"050302" => array("532", "교수자별 매출", "#"),
				"050303" => array("533", "영업자별 매출", "#"),
				"050304" => array("534", "카테고리별 매출", "#"),
				"050305" => array("535", "상품별 매출", "#")
			)
		),
		"06" => array("마이페이지", "/admin/mypage/index.php",
			"0601" => array("마이페이지",
				"060101" => array("601", "개인정보 수정", "/admin/mypage/index.php"),
				"060102" => array("602", "비밀번호 변경", "/admin/mypage/index.php?mode=pwd_set"),
				"060103" => array("603", "로그인 로그", "/admin/mypage/index.php?mode=login_log")
			)
		)
	);

// 관리자에 권한에 따라서 사이트맵을 다시 구성합니다.
$User_Info =  LOGIN_CHK($_COOKIE['LIPASS_ID']);
if($User_Info["admin_type"] != "S") {
	$admin_menucode_list = explode(",", $User_Info[3]);
	
	for($i = 0, $cnt = count($admin_menucode_list); $i < $cnt; $i++) {
		//echo $admin_menucode_list[$i]."<br />";
		$admin_menucode_list[$i] = getTreeCode($sitemap, $admin_menucode_list[$i]);
		//echo $admin_menucode_list[$i]."<br /><br />";
	}
	
	foreach ($sitemap as $siteKey => $siteVal) {
		if(is_array($siteVal)) {
			if(existsMenu($admin_menucode_list, $siteKey))
			{
				foreach ($sitemap[$siteKey] as $gKey => $gVal) {
					if(is_array($gVal)) {
						if(existsMenu($admin_menucode_list, $gKey)) {
							foreach ($sitemap[$siteKey][$gKey] as $mKey => $mVal) {
								if(is_array($mVal)) {
									if(existsMenu($admin_menucode_list, $mKey) == false) {
										unset($sitemap[$siteKey][$gKey][$mKey]);
									}
								}			
							}
						} else {
							unset($sitemap[$siteKey][$gKey]);
						}	
					}					
				}				
			} else {
				unset($sitemap[$siteKey]);
			}			
		}
	}
}

// 메뉴번호가 있으면 그 메뉴 번호의 treecode를 구합니다.
if($current_menuIdx != NULL && !empty($current_menuIdx)) {
	$current_menu_code = getTreeCode($sitemap, $current_menuIdx);
}

// 메뉴코드 목록에 해당 메뉴키가 존재하는지 확인합니다.
function existsMenu($menucode_list, $menu_key) 
{
	$isExists = false;
	for($i = 0, $cnt = count($menucode_list); $cnt > $i; $i++) {
		if(substr($menucode_list[$i], 0, strlen($menu_key)) == $menu_key) {
			$isExists = true;
			break;
		}
	}
	
	return $isExists;
}
?>