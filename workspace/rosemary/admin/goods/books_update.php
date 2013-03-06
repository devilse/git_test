<?php 
header('Content-Type: text/html;charset=utf-8');

include "../../_lib/function.php";	// 관리자 페이지 공용 함수 파일
include "../../_lib/db_conn.php";	// 디비 접속	
include "../../_lib/global.php";	// 관리자 페이지 공용 변수 파일
include "../../_lib/lib.php";	// 관리자 페이지 공용 디비 함수 파일

$c = $_GET['c'];
$cg_code = $_GET['cg_code'];
$ca_num = $_GET['ca_num'];
$page = $_GET['page'];
$stx = $_GET['stx'];
$ca_list = $_GET['ca_list'];
$cg_list = $_GET['cg_list'];
$bo_num = $_GET['bo_num'];

$bo_name = $_POST['bo_name'];
$bo_l_price = $_POST['bo_l_price'];
$bo_s_price = $_POST['bo_s_price'];
$bo_writer = $_POST['bo_writer'];
$bo_page = $_POST['bo_page'];
$bo_publisher = $_POST['bo_publisher'];
$bo_e_book = $_POST['bo_e_book'];
$bo_e_writer = $_POST['bo_e_writer'];
$bo_useyn = $_POST['bo_useyn'];
$bo_img_del = $_POST['bo_img_del'];

$date = mktime();

if(!$ca_list){
	$ca_list = $ca_num;
}

if ($img = $_FILES['bo_img']['name']) {
	if (!preg_match("/\.(gif|jpg|png)$/i", $img)) {
		alert("상단 이미지가 gif, jpg, png 파일이 아닙니다.");
	}
}

$bo_path = "../../dir_img/books_img";

@mkdir($bo_path, 0707);

if ($bo_img_del) {
	@unlink("$bo_path/$bo_img_del");
	$img_del .= "  bo_img = '' ";
}

if ($_FILES['bo_img']['name']) {
	$bo_img_urlencode =book."_".$bo_num."_".time()."_".$img;
	$img_insert .= "$bo_img_urlencode";
	$img_up .= " , bo_img='$bo_img_urlencode' ";
}
if ($_FILES['bo_img']['name']) {
	$bo_img_path = "$bo_path/$bo_img_urlencode";
	move_uploaded_file($_FILES['bo_img']['tmp_name'], $bo_img_path);
	chmod($bo_img_path, 0606);
}

if(!$bo_useyn){
	$bo_useyn = 'N';
}
if ($c == "") { 
	$v_sql1 = mysqli_query($CONN['rosemary'],"SELECT MAX(bo_num) AS MAX FROM book");
	$v_sql = mysqli_fetch_array($v_sql1);
	$bo_num1 = $v_sql['MAX'];
	$bo_num = $bo_num1 + 1 ;

	$sql = mysqli_query($CONN['rosemary']," select count(*) as cnt from book where bo_num = '$bo_num' ");
	//$row = mysqli_fetch_array($sql);
	 $cnt = mysqli_result($sql,0,0);


	if ($cnt > 0 ) alertback("이미 존재하는 분류명 입니다.");

	$sql = " insert into book
			 values('$bo_num' , '$bo_name' , '$bo_l_price' , '$bo_s_price' , '$bo_writer' , '$bo_page' , '$bo_publisher' , '$bo_e_book' , '$bo_e_writer' , '$img_insert' , '$bo_useyn' , '$ca_num','$date')";

	mysqli_query($CONN['rosemary'],$sql);
	$err_msg = "생성되었습니다.";

} else if ($c == "u") {
	if ($bo_img_del) {
		$sql = " update book set bo_name = '$bo_name', bo_list_price ='$bo_l_price', bo_selling_price ='$bo_s_price', bo_writer ='$bo_writer', bo_page_cnt='$bo_page', bo_publisher='$bo_publisher', bo_explain_book='$bo_e_book', bo_explain_writer='$bo_e_writer', $img_del ,bo_useyn='$bo_useyn',ca_num='$ca_num' where bo_num = '$bo_num' ";
		
	} else {
		$sql = " update book set bo_name = '$bo_name', bo_list_price ='$bo_l_price', bo_selling_price ='$bo_s_price', bo_writer ='$bo_writer', bo_page_cnt='$bo_page', bo_publisher='$bo_publisher', bo_explain_book='$bo_e_book', bo_explain_writer='$bo_e_writer' $img_up , bo_useyn='$bo_useyn',ca_num='$ca_num' where bo_num = '$bo_num' ";
	}
	mysqli_query($CONN['rosemary'],$sql);
	$err_msg = "수정되었습니다.";

}else if($c == 'useyn') {
	$bo_useyn = $_GET['bo_useyn'];

	$sql =mysqli_query($CONN['rosemary'],"update book set bo_useyn ='$bo_useyn' where bo_num='$bo_num'");
	//echo $sql;

} else if ($c == "delete") {

	$sql =mysqli_query($CONN['rosemary'],"delete from book where bo_num='$bo_num'");

} else {
	$err_msg = "제대로 된 값이 아닙니다.";
}

echo $ca_num .'--------'. $ca_list; 
alertGo($err_msg,"./index.php?mode=books&cg_code=$cg_code&ca_num=$ca_num&stx=$stx&ca_list=$ca_list&page=$page");

?>