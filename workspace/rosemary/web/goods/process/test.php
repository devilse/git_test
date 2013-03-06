<?
$array = $_POST;
$key = array_keys($array);


$g_num = $_POST['g_num'];
$set_goods = array();
$set_book = array();

for($i=0; $i<count($key); $i++) {

	$chk = explode("_",$key[$i]);
	if ($chk[0] == "set" && $chk[1] == "goods") {	// 선택한 상품
		//echo $chk[2];
		$set_goods[] = $chk[2];
	}

	if ($chk[0] == "set" && $chk[1] == "book") {	// 선택한 교재
		$set_book[] = $chk[2];
	}

}
?>