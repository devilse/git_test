<?php
header('Content-Type: text/html;charset=utf-8');

include "../../../_lib/function.php";	// 관리자 페이지 공용 함수 파일
include "../../../_lib/db_conn.php";	// 디비 접속	
include "../../../_lib/global.php";	// 관리자 페이지 공용 변수 파일
include "../../../_lib/lib.php";	// 관리자 페이지 공용 디비 함수 파일

$mode = $_POST['mode'];
$cg_code = $_POST['cg_code'];
$cg_useyn = $_POST['cg_useyn'];

if(empty($cg_useyn)) $cg_useyn = 'N';

$cg_name = trim($_POST['cg_name']);
$cg_skin = trim($_POST['cg_skin']);
$cg_title = addslashes(trim($_POST['cg_title']));
$cg_description = addslashes(trim($_POST['cg_description']));
$cg_keywords = addslashes(trim($_POST['cg_keywords']));

$t_chk = true;	//쿼리 이상유무 체크 변수 

if ($mode == "group_add"){
	$sql1 = @mysqli_query($CONN['rosemary']," select count(*) as cnt from category_group where cg_code= '$cg_code' ");
	$row = mysqli_fetch_array($sql1);

	if ($row[cnt]){
		alert("이미 존재하는 그룹 코드 입니다.");
	}

	$sql = "insert into category_group (cg_code,cg_name,cg_useyn,cg_skin,cg_title,cg_description,cg_keywords) values ('$cg_code','$cg_name','$cg_useyn','$cg_skin','$cg_title','$cg_description','$cg_keywords')";

	$v_sql = @mysqli_query($CONN['rosemary'],$sql);
	if (!$v_sql) {
		$t_chk = false;
		$alert("등록 중 오류가 발생 하였습니다.");
	}
	$msg ='등록되었습니다.';
	writecs_skin();

} else if ($mode == "group_up"){
	$sql = " update category_group set cg_code = '$cg_code', cg_name = '$cg_name', cg_useyn = '$cg_useyn', cg_skin = '$cg_skin', cg_title = '$cg_title', cg_description = '$cg_description', cg_keywords = '$cg_keywords' where cg_code = '$cg_code'";
	
	$v_sql = mysqli_query($CONN['rosemary'],$sql);
	if (!$v_sql) {
	
		$t_chk = false;
		alert ("수정 중 오류가 발생 하였습니다.");
	}
	$msg ='수정되었습니다.';
	writecs_skin();

} else if($mode == 'useyn'){

	$sql = "update category_group set cg_useyn ='$cg_useyn' where cg_code='$cg_code'";

	$v_sql = mysqli_query($CONN['rosemary'],$sql);
	if (!$v_sql) {
	
		$t_chk = false;
		alert ("수정 중 오류가 발생 하였습니다.");
	}

	$msg = "수정되었습니다.";
	writecs_skin();
		

} else {
	alert("제대로 된 값이 아닙니다.");

}

alertGo($msg,"../index.php?mode=group");

// cs_skin.php 파일 생성.
function writecs_skin()
{
	global $DOCUMENT_ROOT, $CONN;
		
	$category_group_list_query = mysqli_query($CONN['rosemary'], 'SELECT cg_code, cg_skin FROM category_group');	
	while ($category_group_row = mysqli_fetch_array($category_group_list_query)) {
		$contents = $contents."$"."cs_skin_array['".$category_group_row['cg_code']."'] = '".$category_group_row['cg_skin']."';\n";
	}	
	
	writeFile($DOCUMENT_ROOT.'/_autocode/cs_skin.php', getPHPTagString($contents));
}
?>