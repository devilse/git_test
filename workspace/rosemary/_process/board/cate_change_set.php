<?php
header('Content-Type: text/html;charset=utf-8');

include "../../_lib/db_conn.php";	// 디비 접속
include "../../_lib/global.php";	
include "../../_lib/function.php";	// 관리자 페이지 공용 함수 파일
include "../../_lib/lib.php";		// 관리자 페이지 공용 함수 파일


$mode	= $_POST['mode'];							// 어떤 카테고리를 선택 했는지 cs,cate,goods
$num	= $_POST['set_number'];						// 게시판 번호




if ($mode == "cs") {			// cs 셀렉트박스를 선택 했다. - 해당 cs 의 카테고리를 보여준다.
		
	$qry = mysqli_query($CONN['rosemary'],"select * from category where cg_code = '$num' and ca_useyn = 'Y'");

	ob_start();
	echo "T|";
	echo "
		<select name = 'ca_num' id = 'ca_num' onchange=\"cs_cate_set(this.value,'category')\">
			<option value=''>선택하세요</option>
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

} else if($mode == "category") {		//카테고리를 선택 했다. - 해당 카테고리의 상품을 보여준다. 


	$cate_query = mysqli_query($CONN['rosemary'],"select ca_tree from category where ca_num = '$num'");
	$ca_tree = mysqli_result($cate_query,0,0);
	$ca_tree_len = strlen($ca_tree);



	$qry = mysqli_query($CONN['rosemary'],"select * from goods_lecture a, goods b where a.g_num = b.g_num and b.ca_num in (select ca_num from category where left(ca_tree,$ca_tree_len) = '$ca_tree')");
	$nums = @mysqli_num_rows($qry);
	

	ob_start();
	echo "T|";
	if (!$nums) {
		echo "
			<select name = 'goods_num'>
				<option value=''>등록된 상품이 없습니다.</option>
			</select>
		";
	} else {
		echo "
			<select name = 'goods_num' onchange='set_goods(this.value)'>
				<option value=''>선택하세요</option>
		";
		while($rs = mysqli_fetch_array($qry)){
			$lt_num = $rs['lt_num'];
			$sel_name = $rs['lt_name'];
			echo "	<option value='$lt_num '>$sel_name</option>";
		}
		echo "
			</select>
		";
	}


	$concon=ob_get_contents();
	ob_end_clean();
	echo $concon;	

}

?>