<?php
header('Content-Type: text/html;charset=utf-8');

include "../../../_lib/db_conn.php";	// 디비 접속
include "../../../_lib/global.php";
include "../../../_lib/function.php";
include "../../../_lib/lib.php";	// 관리자 페이지 공용 함수 파일

$mode = $_POST['mode'];
$list_name = addslashes(trim($_POST['list_name']));	//그룹명
$set_good = $_POST['set_good'];		//구성상품
$cg_code = $_POST['cg_code'];		//구성cs
$set_radio = $_POST['set_radio'];		//정렬방식



if (!$list_name) alertback("그룹명을 입력해 주세요.");
if (!$set_good) alertback("선택한 상품이 없습니다");
if (!$cg_code) alertback("선택한 카테고리가 없습니다.");
if (!$set_radio) $set_radio = "A";


$page = $_POST['page'];
$key = $_POST['key'];
$searchword = $_POST['searchword'];
$set_cs = $_POST['set_cs'];
$set_state = $_POST['set_state'];

$page_param = "&page=$page&key=$key&searchword=$searchword&set_cs=$set_cs&set_state=$set_state";

if ($mode == "sel_goods_reg") {

	$list_code = addslashes(trim($_POST['list_code']));	//코드명
	if (!$list_code) alertback("코드를 입력해 주세요.");

	// 해당 코드가 중복 되어선 안된다.
	$chk_query = mysqli_query($CONN['rosemary'],"select count(*) as cnt from goods_group where gg_code = '$list_code'");
	$chk_cnt = @mysqli_result($chk_query,0,0);
	if ($chk_cnt > 0) {
		alertback("코드명이 중복 됩니다.");
	}

	$t_chk = true;	//쿼리 이상유무 체크 변수
	mysqli_query($CONN['rosemary'],"set autocommit = 0;");
	mysqli_query($CONN['rosemary'],"begin;");

	$list_in_query = mysqli_query($CONN['rosemary'],"insert into goods_group(gg_code,cg_code,gg_name,gg_sort_type,gg_regdate) values('$list_code','$cg_code','$list_name','$set_radio',unix_timestamp())");
	if (!$list_in_query) {
		$t_chk = false;
	} else {
		$goods_array = explode(",",$set_good);
		$end_for = count($goods_array);
		$sort_number = 1;
		for ($i = 0; $i < $end_for;  $i++) { 	
			$g_num = $goods_array[$i];
			$goods_in_query = mysqli_query($CONN['rosemary'],"insert into goods_group_goods(gg_code,g_num,ggg_sortnum) values('$list_code','$g_num','$sort_number')");
			if (!$goods_in_query) {
				$t_chk = false;
			}
			$sort_number++;
		}			
	}

	if ($t_chk != true) {
		mysqli_query($CONN['rosemary'],"rollback;");
		alertback("상품 그룹 생성 실패");
	} else {
		mysqli_query($CONN['rosemary'],"commit;");	
		alertGo("","../index.php?mode=sel_goods_list");
	}

} else if($mode == "sel_goods_modi") {

	$gg_code = $_POST['gg_code'];
	if (!$gg_code) alertback("접근할 수 없습니다.");

	$view_query = mysqli_query($CONN['rosemary'],"select count(*) as cnt from goods_group where gg_code = '$gg_code'");
	$view_nums = mysqli_result($view_query,0,0);
	if (!$view_nums) {
		alertback("삭제되었거나 존재하지 않는 그룹 입니다.");
	}


	$t_chk = true;	//쿼리 이상유무 체크 변수
	mysqli_query($CONN['rosemary'],"set autocommit = 0;");
	mysqli_query($CONN['rosemary'],"begin;");

	$up_group_query = mysqli_query($CONN['rosemary'],"
									update 
										goods_group
									set
										cg_code = '$cg_code',
										gg_name = '$list_name',
										gg_sort_type = '$set_radio'
									where 
										gg_code = '$gg_code'
									");

	if (!$up_group_query) {
		$t_chk = false;
	} else {
		// 상품 테이블은 업데이트를 하는게 아니라 들어가있는걸 다 삭제하고 새로 인설트 해준다. 
		$del_goods_query = mysqli_query($CONN['rosemary'],"delete from goods_group_goods where gg_code = '$gg_code'");
		if (!$del_goods_query) {
			$t_chk = false;
		} else {
			$goods_array = explode(",",$set_good);
			$end_for = count($goods_array);
			$sort_number = 1;
			for ($i = 0; $i < $end_for;  $i++) { 	
				$g_num = $goods_array[$i];
				$goods_in_query = mysqli_query($CONN['rosemary'],"insert into goods_group_goods(gg_code,g_num,ggg_sortnum) values('$gg_code','$g_num','$sort_number')");
				if (!$goods_in_query) {
					$t_chk = false;
				}
				$sort_number++;
			}	
		}
	}

	if ($t_chk != true) {
		mysqli_query($CONN['rosemary'],"rollback;");
		alertback("상품 그룹 수정 실패");
	} else {
		mysqli_query($CONN['rosemary'],"commit;");	
		alertGo("","../index.php?mode=sel_goods_view&gg_code=$gg_code&".$page_param);
	}

}

?>