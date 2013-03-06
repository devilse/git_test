<?php
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
header('Content-Type: text/html;charset=utf-8');

include "../../_lib/function.php";	// 관리자 페이지 공용 함수 파일
include "../../_lib/db_conn.php";	// 디비 접속
include "../../_lib/global.php";	// 관리자 페이지 공용 변수 파일
include "../../_lib/lib.php";
include "../../gmEditor/func_editor.php";

$mode = $_GET['mode'];
$User_Info =  Login_Chk($_COOKIE['LIPASS_ID']);
$mb_type = $User_Info['type'];
if ($mb_type != "A") {
	alertGo("", "/");
}

?>

<?php

switch ($mode) {

	case 'group' :								// 대분류
		$current_menuIdx = "401";
		$includeStr = "./categorygroup.php";
		break;

	case 'group_add' :							// 대분류 등록
		$current_menuIdx = "401";
		$includeStr = "./categorygroup_add.php";
		break;

	case 'group_up' :							// 대분류 수정
		$current_menuIdx = "401";
		$includeStr = "./categorygroup_add.php";
		break;

	case 'category' :							// 카테고리
		$current_menuIdx = "402";
		$includeStr = "./category.php";
		break;

	case 'category_add' :						// 카테고리 등록
		$current_menuIdx = "402";
		$includeStr = "./category_add.php";
		break;

	case 'category_up' :						// 카테고리 수정
		$current_menuIdx = "402";
		$includeStr = "./category_add.php";
		break;

	case 'books' :								// 교재
		$current_menuIdx = "421";
		$includeStr = "./books.php";
		break;

	case 'books_add' :							// 교재 등록
		$current_menuIdx = "421";
		$includeStr = "./books_add.php";
		break;

	case 'books_up' :							// 교재 수정
		$current_menuIdx = "421";
		$includeStr = "./books_add.php";
		break;


	case 'goods' :							// 단과/광좌 관리
		$current_menuIdx = "422";
		$includeStr = "./goods.php";
		break;

	case 'goods_reg' :							// 단과/광좌 등록
		$current_menuIdx = "422";
		$includeStr = "./goods_reg.php";
		break;

	case 'goods_con_reg' :							// 단과/광좌 세부사항 등록
		$current_menuIdx = "422";
		$includeStr = "./goods_con_reg.php";
		break;


	case 'goods_view' :							// 단과/광좌 세부사항 등록
		$current_menuIdx = "422";
		$includeStr = "./goods_view.php";
		break;


	case 'goods_dan_reg' :							// 단과/광좌 세부사항 등록
		$current_menuIdx = "422";
		$includeStr = "./goods_dan_reg.php";
		break;

	case 'goods_subject_reg' :							// 단과/광좌 세부사항 등록
		$current_menuIdx = "422";
		$includeStr = "./goods_subject_reg.php";
		break;


	case 'package_list' :							// 패키지 리스트
		$current_menuIdx = "423";
		$includeStr = "./package_list.php";
		break;

	case 'package_reg' :							// 패키지 등록
		$current_menuIdx = "423";
		$includeStr = "./package_reg.php";
		break;

	case 'package_view' :							// 패키지 보기
		$current_menuIdx = "423";
		$includeStr = "./package_view.php";
		break;

	case 'package_modi' :							// 패키지 수정
		$current_menuIdx = "423";
		$includeStr = "./package_reg.php";
		break;

	case 'sel_goods_list' :							// 상품 목적그룹 관리
		$current_menuIdx = "424";
		$includeStr = "./sel_goods.php";
		break;

	case 'sel_goods_reg' :							// 상품 목적그룹 등록
		$current_menuIdx = "424";
		$includeStr = "./sel_goods_reg.php";
		break;

	case 'sel_goods_view' :							// 상품 목적그룹 보기
		$current_menuIdx = "424";
		$includeStr = "./sel_goods_view.php";
		break;

	case 'sel_goods_modi' :							// 상품 목적그룹 수정
		$current_menuIdx = "424";
		$includeStr = "./sel_goods_reg.php";
		break;

	default :
		$current_menuIdx = "401";
		$includeStr = "./categorygroup.php";
		break;
}

?>

<?php include "../include/head.php";?>
<?php include $includeStr; ?>
<?php include "../include/copyright.php";?>