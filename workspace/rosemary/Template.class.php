<?php
include dirname(__file__).'/Template_.class.php';
class Template extends Template_
{
	var $compile_check 	= true;
	var $prefilter 		= 'adjustPath';
	var $postfilter		= 'removeTmpCode | arrangeSpace';
	var $cs = '';		
	var $sitemap;
	var $site_category;
	var $login_info;
	var $current_uri;
	
	function Template($siteinfo, $siteoption, $sitemap, $site_category)
	{
		$this->template_dir	= $_SERVER['DOCUMENT_ROOT'].'/_template';
		$this->compile_dir	= $_SERVER['DOCUMENT_ROOT'].'/_compile';
		$this->sitemap = $sitemap;
		$this->site_category = $site_category;
		
		// 브라우저에서 캐시하지 않도록 처리
		header("Cache-Control: no-store, no-cache, must-revalidate");
		header("Cache-Control: post-check=0, pre-check=0", false);
		// HTTP/1.0
		header("Pragma: no-cache");
		header('Content-Type: text/html;charset=utf-8');
		
		// cs 코드 구하기
		$this->cs = $_GET['cs'];
		if(empty($this->cs)) $this->cs = $siteoption['default_cs_code'];
		$this->assign('cs', $this->cs);
		
		$this->assign('siteinfo', $siteinfo);
		$this->assign('siteoption', $siteoption);
		
		// 로그인 정보		
		$this->login_info = Login_Chk($_COOKIE['LIPASS_ID']);
		$this->assign('login_info', $this->login_info);
		
		// 현재 URL
		if(empty($_GET['prev'])) {			
			$this->current_uri = $_SERVER['REQUEST_URI'];			
		} else {
			$this->current_uri = $_GET['prev'];
		}
		
		$this->assign('current_uri', urlencode($this->current_uri));
	}
	
	// define 되었는지 여부를 반환합니다.
	function defined($tpl_name)
	{
		return is_array($this->tpl_[$tpl_name]);
	}
	
	// 메뉴 번호를 이용하여 서브메뉴를 만듭니다. $ca_num이 0보다 크면 $ca_num 값으로 선택된 메뉴를 결정합니다. 
	function createSubMenu($sm_num, $ca_num = 0)
	{
		$current_menu_code = getTreeCode($this->sitemap, $sm_num);
		$this->createSubMenu_menucode($current_menu_code, $ca_num);
	}
	
	// cid를 이용하여 서브메뉴를 만듭니다.
	function createSubMenu_cid($cid)
	{		
		$current_menu_code = getTreeCode_cid($this->sitemap, $cid);
		$this->createSubMenu_menucode($current_menu_code);		
	}
	
	// bo_num을 이용하여 서브메뉴를 만듭니다.
	function createSubMenu_bo_num($bo_num)
	{
		$current_menu_code = getTreeCode_key_val($this->sitemap, "bo_num", $bo_num);		
		$this->createSubMenu_menucode($current_menu_code);
	}
	
	// 메뉴코드를 이용하여 서브메뉴를 만듭니다.
	function createSubMenu_menucode($current_menu_code, $ca_num = 0)
	{
		$menu_title = $this->sitemap[substr($current_menu_code, 0, 2)][1];
		$this->assign('menu_title', $menu_title);
		
		$menuArray = array();
		$this->createMenuArray($menuArray, $this->sitemap[substr($current_menu_code, 0, 2)], $current_menu_code, 1, $ca_num);
		
		// 하위 메뉴가 있는 메뉴는 6번째 값을 Y로 변경해줍니다.
		for($i = 0, $cnt = count($menuArray); $i < $cnt; $i++) {
			if($i + 1 < $cnt) {
				if($menuArray[$i][4] < $menuArray[$i + 1][4]) {
					$menuArray[$i][5] = "Y";
				}
			}
		}
		
		// 아코디언 메뉴로 활용될 때 펼쳐져야 할 메뉴는 7번째 값을 Y로 변경해줍니다.
		$idx = -1;
		$dep = -1;		
		$this->getSelectedIdxDep($idx, $dep, $menuArray);
		
		if($idx > -1) {
			for($i = $idx; $i >= 0; $i--) {
				if($menuArray[$i][4] == 2) {
					$idx = $i;
					break;
				}
			}
			
			for($i = $idx + 1, $cnt = count($menuArray); $i < $cnt; $i++) {
				if($menuArray[$i][4] <= 2) {
					break;
				} else {
					$menuArray[$i][6] = "Y";
				}
			}
		}				
		
		$this->assign('menu_list', $menuArray);
		
		// 메뉴 위치 구하기
		$menu_location = array();			
		
		$idx = -1;
		$dep = -1;
		$this->getSelectedIdxDep($idx, $dep, $menuArray);
		
		if($idx > -1) {			
			for($i = $idx; $i >= 0; $i--) {
				if($menuArray[$i][4] == $dep) {
					array_unshift($menu_location, $menuArray[$i][2]);
					$dep--;
				}
			}
		}
		
		array_unshift($menu_location, $menu_title);
		$this->assign('menu_location', $menu_location);
	}
	
	private function getSelectedIdxDep(&$idx, &$dep, $menuArray) 
	{		
		for($i = 0, $cnt = count($menuArray); $i < $cnt; $i++) {
			if($menuArray[$i][3] == "Y") {
				$idx = $i;
				$dep = $menuArray[$i][4];
				break;
			}
		}
	}

	// 서브메뉴 만드는 재귀호출 함수
	private function createMenuArray(&$menuArray, $sitemap, $current_menu_code, $depth, $ca_num)
	{
		$depth++;
		
		foreach ($sitemap as $menukey => $menuval) {
			if(is_array($menuval)) {
				if(substr($menuval[1], 0, 3) == "[LS") {
					$LSstr = str_replace("]", "", $menuval[1]);
					$LSNum = explode(":", $LSstr);
					$category_depth = intval($LSNum[1]);

					foreach($this->site_category[$this->cs] as $cval) {
						if($category_depth == 0 || $category_depth * 3 >= strlen($cval[0])) {							
							$thisDepth = $depth + (strlen($cval[0]) - 3) / 3;							
														
							$menuArray[] = array($this->getDepthString($thisDepth), 
									str_replace("{0}", $cval[1], $LSNum[2]), $cval[2], $ca_num == $cval[1] ? "Y" : "N", 
									$thisDepth, "N", $thisDepth <= 2 ? "Y" : "N");					
						}
					}
				} else {															
					$menuArray[] = array($this->getDepthString($depth), $menuval[2], $menuval[1], 
							$ca_num == 0 && $current_menu_code == $menukey ? "Y" : "N", $depth, "N", $depth <= 2 ? "Y" : "N");					
				}
				$this->createMenuArray(&$menuArray, $menuval, $current_menu_code, $depth, $ca_num);
			}
		}
	}
	
	// depth를 css class에서 사용하는 문자열로 반환합니다.
	private function getDepthString($depth)
	{
		$result = "";
		switch($depth) {
			case 1 :
				$result = "one_dep";
				break;
			case 2 :
				$result = "two_dep";
				break;
			case 3 :
				$result = "thr_dep";
				break;
			case 4 :
				$result = "fou_dep";
				break;
		}
		return $result;
	}
	
	// $type에 들어있는 회원코드가 아니면 $move_uri로 이동시킵니다.
	function auth_block($type, $move_uri = "../main/index.php")
	{
		$result = false;
		$type_array = explode("|", $type);
		
		foreach($type_array as $val) {
			if($this->login_info['type'] == trim($val)) {		
				$result = true;
				break;
			}
		}

		if($result == false) {
			header("Location: $move_uri");
			exit;
		}
	}
}
?>