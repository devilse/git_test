<?php
header('Content-Type: text/html;charset=utf-8');

include "../../../_lib/function.php";	// 관리자 페이지 공용 함수 파일
include "../../../_lib/db_conn.php";	// 디비 접속	
include "../../../_lib/global.php";	// 관리자 페이지 공용 변수 파일
include "../../../_lib/lib.php";	// 관리자 페이지 공용 디비 함수 파일

$mode = $_GET['mode'];
$c = $_GET['c'];

$ca_num = $_GET['ca_num'];
$cg_code = $_GET['cg_code'];
$ca_tree = $_GET['ca_tree'];
$updown = $_GET['updown'];

$ca_useyn = $_POST['ca_useyn'];
if(empty($ca_useyn)) $ca_useyn = 'N';

$ca_name = $_POST['ca_name'];
$ca_skin = $_POST['ca_skin'];

$t_chk = true;	//쿼리 이상유무 체크 변수 
	

if ($c == "add") { 	
	$sql = mysqli_query($CONN['rosemary']," select count(*) as cnt from category where cg_code='$cg_code' and ca_name = '$ca_name' ");
	$row = mysqli_fetch_array($sql);
	if ($row['cnt']) {
		alertGo("이미 존재하는 분류명 입니다.","./index.php?mode=category&cg_code=$cg_code");
	}

	$sql = " insert into category
			values('$ca_num' , '$ca_tree' , '$ca_name' , '$ca_useyn' , '$cg_code' , '$ca_skin')";

	mysqli_query($CONN['rosemary'],$sql);

	$err_msg ="생성되었습니다.";
	write_category();
	
} else if ($c == "up") {

	$str =substr($ca_tree,0,3);

	if($str <= 9)
	{
		$first = '00';
	}elseif($str <= 99)
	{
		$first = '0' ;
	}

	if($updown == 'up') {
		

		$len = strlen($ca_tree);

		$v_sql = "select ca_num as a_num, ca_tree as a_tree from category where ca_tree like '$ca_tree%' and cg_code = '$cg_code' order by ca_num ";
		$v_sql = mysqli_query($CONN['rosemary'],$v_sql);
		$k=0;

		for($i=0; $a= mysqli_fetch_array($v_sql); $i++) {
			//a값을 -> c 
			$cut_len = substr($a['a_tree'],0,$len);
			$end_len = substr($a['a_tree'],$len);

			$tree = $cut_len -1;

			$c_tree = $first.$tree.$end_len;
			$c_num = $a['a_num'];

			if($k==0) {
				$v_sql1 = mysqli_query($CONN['rosemary'],"select ca_num as b_num, ca_tree as b_tree from category where ca_tree like '$first$tree%' and cg_code = '$cg_code'");

				for($j=0; $b=mysqli_fetch_array($v_sql1); $j++) {
				//b값을 -> d 

					$cut_len1 = substr($b['b_tree'],0,$len);
					$end_len1 = substr($b['b_tree'],$len);

					$tree1 = $cut_len1 +1;

					$d_tree = $first.$tree1.$end_len1; 
					$d_num = $b['b_num'];

					$sql1 =" update category set ca_tree = '$d_tree' where ca_num ='$d_num'";
					echo 'sql1 d : '.$sql1.'</br>';

					mysqli_query($CONN['rosemary'],$sql1);
				}
			}
			$sql =" update category set ca_tree = '$c_tree' where ca_num ='$c_num'";

			mysqli_query($CONN['rosemary'],$sql);

			$k++;		
		}

	}else if($updown == 'down') {	
		

		$len = strlen($ca_tree);

		$v_sql = mysqli_query($CONN['rosemary'],"select ca_num as a_num, ca_tree as a_tree from category where ca_tree like '$ca_tree%' and cg_code = '$cg_code' order by ca_num ");

		$k=0;

		for($i=0; $a= mysqli_fetch_array($v_sql); $i++) {
		//a값을 -> c 

			$cut_len = substr($a['a_tree'],0,$len);
			$end_len = substr($a['a_tree'],$len);

			$tree = $cut_len +1;

			$c_tree = $first.$tree.$end_len;
			$c_num = $a['a_num'];

			if($k==0) {
				$v_sql1 = mysqli_query($CONN['rosemary'],"select ca_num as b_num, ca_tree as b_tree from category where ca_tree like '$first$tree%' and cg_code = '$cg_code'");

				for($j=0; $b= mysqli_fetch_array($v_sql1); $j++) {
				//b값을 -> d 

					$cut_len1 = substr($b['b_tree'],0,$len);
					$end_len1 = substr($b['b_tree'],$len);

					$tree1 = $cut_len1 -1;

					$d_tree = $first.$tree1.$end_len1; 
					$d_num = $b['b_num'];

					$sql1 =" update category set ca_tree = '$d_tree' where ca_num ='$d_num'";
					//echo 'sql1 d : '.$sql1.'</br>';
					mysqli_query($CONN['rosemary'],$sql1);

				}
			}
			$sql =" update category set ca_tree = '$c_tree' where ca_num ='$c_num'";
			//echo 'sql c : '.$sql.'</br>';
			mysqli_query($CONN['rosemary'],$sql);
			$k++;
		}

	} else {

		$sql = " update category set ca_num = '$ca_num', ca_tree = '$ca_tree', ca_name = '$ca_name', ca_useyn = '$ca_useyn' , cg_code = '$cg_code', ca_skin = '$ca_skin' where ca_num = '$ca_num'";

		mysqli_query($CONN['rosemary'],$sql);
		$err_msg = "수정되었습니다.";
		write_category();
	}
} else if ($c == "delete") {

	$v_sql1 = mysqli_query($CONN['rosemary'],"select count(*) cnt from category where cg_code='$cg_code' and ca_tree like '$ca_tree%' and cg_code = '$cg_code'");

	$v_sql = mysqli_fetch_array($v_sql1);

	if($v_sql['cnt'] == 1) {
		$sql = mysqli_query($CONN['rosemary'],"delete from category where ca_num='$ca_num' and cg_code='$cg_code' and ca_tree = '$ca_tree' and cg_code = '$cg_code'");
	
	} else {
		$err_msg = "하위 카테고리를 먼저 삭제하세요";
	}
	//echo $v_sql;exit;

} else {
	$err_msg("제대로 된 값이 아닙니다.");
}

alertGo($err_msg,"../index.php?mode=category&cg_code=$cg_code");

// category.php 파일 생성.
function write_category()
{
	global $DOCUMENT_ROOT, $CONN;
	
	$contents = "$"."site_category = array(\n";
	$contents_skin = ''; 
	$cg_code = '';
	$cnt = 0;
	$category_list_query = mysqli_query($CONN['rosemary'], 'SELECT cg_code, ca_tree, ca_num, ca_name, ca_skin FROM category ORDER BY cg_code, ca_tree');
	while ($category_row = mysqli_fetch_array($category_list_query)) {
		if($cg_code != $category_row[cg_code]) {
			if($cg_code != '') {
				$contents = $contents."),\n";
			}
			$cnt = 0;
			$cg_code = $category_row[cg_code];
			$contents = $contents."\t'$cg_code' => array(\n";
		}
		if($cnt > 0) {
			$contents = $contents.",\n";
		}
		$cnt++;
		$contents = $contents."\t\tarray('$category_row[ca_tree]', '$category_row[ca_num]', '$category_row[ca_name]', '$category_row[ca_skin]')";
		$contents_skin = $contents_skin."$"."category_skin['$category_row[ca_num]'] = '$category_row[ca_skin]';\n";
	}
	
	if($cnt > 0) {
		$contents = $contents.")\n";
	}
	
	$contents = $contents.");\n";
	$contents = $contents.$contents_skin;
	writeFile($DOCUMENT_ROOT.'/_autocode/category.php', getPHPTagString($contents));
}
?>