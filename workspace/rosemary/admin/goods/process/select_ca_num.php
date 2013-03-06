<?php
header('Content-Type: text/html;charset=utf-8');


include "../../../_lib/db_conn.php";	// 디비 접속
include "../../../_lib/global.php";
include "../../../_lib/function.php";
include "../../../_lib/lib.php";	// 관리자 페이지 공용 함수 파일

$mode	= $_POST['mode'];
$num	= $_POST['set_number'];

$cg_code = $_POST['cg_code'];
$ca_num = $_POST['ca_num'];
$search = $_POST['search'];


if ($mode == "cs") {

	$qry = mysqli_query($CONN['rosemary'],"select * from category where cg_code = '$num' and ca_useyn = 'Y'");

	ob_start();
	echo "T|";
	echo "
		<select name = 'ca_num' id = 'ca_num' onchange=\"cs_cate_set(this.value,'category')\">
			<option value=''>전체 보기</option>
	";
	while($rs = mysqli_fetch_array($qry)){

		$ca_tree_len = strlen($rs['ca_tree']) / 3;
		if($ca_tree_len > 1){
			$nbsp = "&nbsp;";
			for($i=0;$i<$ca_tree_len;$i++){
				$nbsp .= $nbsp;
			}
			$cate_dep = $nbsp."ㄴ";
		}else{
			$cate_dep = "";
		}

		$ca_num = $rs['ca_num'];
		$sel_name = $rs['ca_name'];
		echo "	<option value='$ca_num'>$cate_dep $sel_name</option>";
	}
	echo "
		</select> |
	";

	
	echo "
		<select name = 'goods_num'  onchange='set_goods(this.value)'>
			<option value=''>카테고리를 선택하세요</option>
		</select>
	";


	$concon=ob_get_contents();
	ob_end_clean();
	echo $concon;

} else {


	if (!$ca_num && !$cg_code) {
			ob_start();
			echo "X<>선택한 카테고리가 없습니다."; 
			$concon=ob_get_contents();
			ob_end_clean();
			echo $concon;
			exit;
	}

	if (!empty($search)) {
		$search_where = "and g_name like '%$search%'";
	}


	if (!empty($ca_num)) {
		$q = mysqli_query($CONN['rosemary'],"select *,(select ca_name from category b where b.ca_num = '$ca_num' ) as ca_name from goods a where ca_num = '$ca_num' and g_state = 'S' $search_where");
	} else {
		$q = mysqli_query($CONN['rosemary'],"select *,(select ca_name from category b where b.ca_num = a.ca_num ) as ca_name from goods a where cg_code = '$cg_code' and g_state = 'S' $search_where");
	}

	$n = mysqli_num_rows($q);

	$option = "";

	if (!$n) {
		$option = "none|*|검색된 상품이 없습니다.";
	} else {
		while($goods_rs = mysqli_fetch_array($q)){
			$g_name			 = mb_strimwidth($goods_rs['g_name'], 0, 40, "...", "UTF-8");	// 제목
			$g_num = $goods_rs['g_num'];
			$ca_name = $goods_rs['ca_name'];
			$g_value = $goods_rs['g_num']."|".$goods_rs['g_name']." (".$ca_name.")";
			

			if (empty($option)) {
				$option = $g_value."|*|".$g_name." (".$ca_name.")";
			} else {
				$option .= "|^|".$g_value."|*|".$g_name." (".$ca_name.")"; 
			}
		}
	}

		
			ob_start();
			echo "T<>".$option; 
			$concon=ob_get_contents();
			ob_end_clean();
			echo $concon;
			exit;



}




?>