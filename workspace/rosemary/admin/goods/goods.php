<?php

if (!empty($_GET['key'])) {
	$key = $_GET['key'];
}
if (!empty($_GET['searchword'])) {
	$searchword = trim($_GET['searchword']);
}
if (!empty($_GET['set_g_state'])) {
	$set_g_state = trim($_GET['set_g_state']);
}
if (!empty($_GET['sel_type'])) {
	$sel_type = trim($_GET['sel_type']);
}
if (!empty($_GET['ca_num'])) {
	$ca_num = trim($_GET['ca_num']);
}
if (!empty($_GET['cg_code'])) {
	$cg_code = trim($_GET['cg_code']);
}
if (!$key && $searchword) {
	$key = "g_name";
}

$search_where = "";
if ($key && $searchword) {
	$searchword_chk = 1;
	if (preg_match("/[!#$%^&*()?{}.;:<>+=\/]/",$searchword)) {
		$searchword_chk = 0; 
	}
	if ($searchword_chk != 1) {
		alertback("특수문자가 포함되어 검색할 수 없습니다.");
	}
	if ($key == "g_name") {
		$search_where = "and g_name like '%$searchword%'";
	}

	$encode_searchword = urlencode($searchword);
}

$state_where = "";
if ($set_g_state) {
	$state_where = "and g_state = '$set_g_state'";
}

$type_where = "";
if ($sel_type) {
	if ($sel_type == "C") {
		$type_where = "and g_type = 'C'";
	} else {
		$type_where = "and g_type != 'C'";
	}
	
}

$ca_where = "";
if ($ca_num) {
	$ca_where = "and ca_num = '$ca_num'";
}

$cg_where = "";
if ($cg_code) {
	$cg_where = "and cg_code = '$cg_code'";
}


$goods_cnt_query = mysqli_query($CONN['rosemary'],"select count(*) as cnt from goods where 1 = 1 $search_where $state_where $type_where $cg_where $ca_where");
$goods_cnt = mysqli_result($goods_cnt_query,0,0);
$query_number	=	$goods_cnt;


$category_query = mysqli_query($CONN['rosemary'],"select ca_tree,ca_name,cg_code from category");
$cate_array = array();
$cate_number = 0;
while($cate_rs = mysqli_fetch_array($category_query)){
	$cate_array[$cate_number]['cg_code'] = $cate_rs['cg_code'];
	$cate_array[$cate_number]['tree'] = $cate_rs['ca_tree'];
	$cate_array[$cate_number]['name'] = $cate_rs['ca_name'];

		$cate_number++;
}
		
		
function chk_category($chk,$cg_code)
{

	global $cate_array;

	$len = strlen($chk);
	$end_for = $len / 3;
	$cate_name = "";


	for($i=0;$i<$end_for;$i++){

		$chk_len = substr($chk,0,$len - ($i*3));

		foreach($cate_array as $chk_rs => $chk_val){
			if(is_array($chk_val)) {
				if ($chk_val['tree'] == $chk_len) {

					if ($chk_val['cg_code'] == $cg_code) {
						if (empty($cate_name)) {
							$cate_name = $chk_val['name'];
						} else {
							$cate_name = $chk_val['name']." > ".$cate_name;
						}
					}
				}
			}
		}
	}

	return $cate_name;
}



?>
<script src="<?php echo $MY_URL;?>_js/jquery.min.js" type="text/javascript"></script>
<script type = "text/javascript">
	function goods_reg()
	{
		document.location.href="./index.php?mode=goods_reg";
	}
	function change_state(val,mode)
	{
		var f = document.search_form;
		if (mode == 1) {
			f.sel_type.value = val;
		} else {
			f.set_g_state.value = val;
		}
		
		f.submit();
	}
	function search_go()
	{
		var f = document.search_form;
		if (f.searchword.value == "") {
			alert("검색하실 단어를 입력해 주세요.");
			f.searchword.focus();
			return;
		} else {
			var value = f.searchword.value;
			var val = value.trim();

			if (val ==''||val.length <2) {
				alert('검색할 단어를 2자이상 입력해주세요');
				f.searchword.focus();
				return;
			} else {
				f.action = "./index.php";
				f.submit();
			}
		}		
	}
	function change_list(val)
	{
		if (!val) {
		var f = document.search_form;
			f.searchword.value = "";
			f.action = "./index.php";
			f.submit();
		}

	}

	function enter_down(val){
		var keyCode = event.keyCode ? event.keyCode : event.which ? event.which : event.charCode;
			if (keyCode == 13) {
				if (val == "search") {
					search_go();
				}
			}
	}




	function cs_cate_set(val,mode){


		if (mode == "category") {
			var cg_code=document.getElementById('cg_code');
			var f = document.search_form;
				f.ca_num.value = val;
				f.cg_code.value =  cg_code.value;
				f.action = "./index.php";
				f.submit();

		}else {
			var f = document.search_form;
				f.cg_code.value = val;
				f.action = "./index.php";
				f.submit();
		}
	}

</script>

<form name = "cate_set_form" id = "cate_set_form">
<input type = "hidden" name = "mode">
<input type = "hidden" name = "set_number">
</form>

<div id="mask" onclick="close_layer_window(); return false;"></div>  
<table width="100%" border="0" cellspacing="1" cellpadding="3" class="td" bgcolor="#999999" style="white-space:nowrap">
	<tr bgcolor="#EFEFEF" height=30> 
		<td align=center> 
			<table width=500>
				<tr>
				<td align=center><b>단과/강좌 리스트</b></td>
				</tr>
			</table>
		</td>
	</tr>	


	<tr bgcolor="#EFEFEF" > 
		<td align=center> 
			<table width="100%" border="0" cellspacing="1" cellpadding="3" class="td" bgcolor="#999999">
				<tr bgcolor="#EFEFEF">
					<td width=50%>&nbsp; </td>
					<td width=8% align=center>전체 상품 수 </td>
					<td width=10% align=center><?php echo number_format($goods_cnt);?></td>
					<!--
					<td width=8% align=center>1일 이내 로그인 수</td>
					<td width=10% align=center><?php echo number_format($day_cnt);?></td>
					<td width=8% align=center>한시간 이내 로그인 수</td>
					<td width=10% align=center><?php echo number_format($time_cnt);?></td>
					-->
				</tr>
			</table>
		</td>
	</tr>

</table>
<br>
<table width="100%" border="0" cellspacing="1" cellpadding="3" class="td" bgcolor="#999999" style="white-space:nowrap">
	<tr bgcolor="#EFEFEF" height=30> 
		<td align=center width=5%> NO	</td>
		<td align=center width=6%> 
		<select name = "cg_code" id = "cg_code" onchange="cs_cate_set(this.value,'cs')">
<?php
	$category_group_qry = mysqli_query($CONN['rosemary'],"select cg_code,cg_name from category_group");
	$first_cs_code = $cg_code;
	while ($category_group_rs = mysqli_fetch_array($category_group_qry)) {	
		if (!$first_cs_code) {
			$first_cs_code = $category_group_rs['cg_code'];
		}
?>
			<option value="<?php echo $category_group_rs['cg_code'];?>" <?if($category_group_rs['cg_code'] == $cg_code){?>selected<?}?>><?php echo $category_group_rs['cg_name'];?></option>
<?}?>
		</select>		
		
		</td>
		<td align=center width=10%> 
	
		


<span id = "cate_gubun">
		<select name = "ca_num" id = "ca_num" onchange="cs_cate_set(this.value,'category')">
			<option value="">전체보기</option>
<?php
	if(!empty($first_cs_code)){
		$category_qry = mysqli_query($CONN['rosemary'],"select * from category where cg_code = '$first_cs_code' and ca_useyn = 'Y' order by ca_tree asc");
		while($coategory_rs = @mysqli_fetch_array($category_qry)){
			$ca_tree_len = strlen($coategory_rs['ca_tree']) / 3;
			if($ca_tree_len > 1){
				$nbsp = "&nbsp;";
				for($i=0;$i<$ca_tree_len;$i++){
					$nbsp .= $nbsp;
				}
				$cate_dep = $nbsp."ㄴ";
			}else{
				$cate_dep = "";
			}
?>
			<option value="<?php echo $coategory_rs['ca_num'];?>" <?if($coategory_rs['ca_num'] == $ca_num){?>selected<?}?>><?php echo $cate_dep;?><?php echo $coategory_rs['ca_name'];?></option>
<?php
	}}
?>
		</select>

</span>
		
		</td>
		<td align=center width=8%> 
				<select name = "sel_type" onchange="change_state(this.value,1)">
				<option value = "" <?php if($sel_type == "" || !$sel_type){?>selected<?php }?>>전체</option>
				<option value = "C" <?php if($sel_type == "C"){?>selected<?php }?>>강좌</option>
				<option value = "B" <?php if($sel_type == "B"){?>selected<?php }?>>단과</option>
			</select>	
		</td>
		<td align=center width=40%> 강좌명	</td>
		<td align=center width=8%> 가격	</td>
		<td align=center width=10%> 등록일	</td>
		<td align=center width=8%> 
			<select name = "sel_g_state" onchange="change_state(this.value,2)">
				<option value = "" <?php if($set_g_state == "" || !$set_g_state){?>selected<?php }?>>전체</option>
				<option value = "R" <?php if($set_g_state == "R"){?>selected<?php }?>>준비중</option>
				<option value = "S" <?php if($set_g_state == "S"){?>selected<?php }?>>판매중</option>
				<option value = "N" <?php if($set_g_state == "N"){?>selected<?php }?>>판매중단</option>
			</select>
		
		</td>
	</tr>	

<?php


if ($query_number) {
	$number = $query_number - $first;
	$goods_query = mysqli_query($CONN['rosemary'],"
													select 
															A.*,
															(select B.ca_tree from category B where B.ca_num = A.ca_num) as ca_tree,
															(select sum(lt_selling_price) as price from goods_lecture B where B.g_num = A.g_num) as price,
															(select cg_name from category_group B where A.cg_code = B.cg_code) as cg_name
													from 
														goods A
													where
														1 = 1
														$search_where
														$state_where
														$type_where
														$cg_where
														$ca_where
													order by A.g_num desc $limit
														");
	while($goods_rs = mysqli_fetch_array($goods_query)){
		$g_num = $goods_rs['g_num'];
		$goods_name = $goods_rs['g_name'];
		$cg_name = $goods_rs['cg_name'];
		$price = $goods_rs['price'];
		if ($goods_rs['g_type'] != "C") {
			$g_type = "단과";
		} else {
			$g_type = "강좌";
		}
		if ($goods_rs['g_state'] == "R") {
			$g_state = "준비중";
		} else if ($goods_rs['g_state'] == "S") {
			$g_state = "판매중";
		} else {
			$g_state = "판매중단";
		}

		$reg_date = date("Y-m-d H:i:s",$goods_rs['g_regdate']);
		$cate_name = chk_category($goods_rs['ca_tree'],$goods_rs['cg_code']);	

?>
	<tr bgcolor="#FFFFFF" height=30> 
		<td align=center width=5%><?php echo number_format($number);?></td>
		<td align=center width=5%> <?php echo $cg_name;?>	</td>
		<td align=center width=10%> <?php echo $cate_name;?>	</td>
		<td align=center width=8%> <?php echo $g_type;?>	</td>
		<td align=left width=40%>&nbsp;<a href="./index.php?mode=goods_subject_reg&g_num=<?php echo $g_num;?>&page=<?php echo $page;?>&key=<?php echo $key;?>&searchword=<?php echo $encode_searchword;?>&set_g_state=<?php echo $set_g_state;?>&sel_type=<?php echo $sel_type;?>&ca_num=<?php echo $ca_num;?>&cg_code=<?php echo $cg_code;?>"><?php echo $goods_name;?></a></td>
		<td align=center width=8%> <?php echo number_format($price);?>원</td>
		<td align=center width=10%><?php echo $reg_date;?></td>
		<td align=center width=8%> <?php echo $g_state;?>	</td>
	</tr>	
<?php
	$number--;}
?>
	<tr bgcolor="#FFFFFF" height=30> 
		<td align=center  colspan=8>
		<ul class="bod_pagelist">
		<?php echo go_page($query_number, $num_per_page, $num_per_block, $page, "./index.php?set_g_state=$set_g_state&sel_type=$sel_type&cg_code=$cg_code&", $key, $searchword,$mode);?>
		</ul>
		</td>
	</tr>	

<?php
} else {
?>
	<tr bgcolor="#FFFFFF" height=30> 
		<td align=center  colspan=8>등록된 강좌가 없습니다.	</td>
	</tr>	
<?php }?>

</table>
<br>
<div align=right>
	<input type = "button" value = "단과/강좌 등록" onclick="goods_reg()">
</div>





 <div align=center>
<form name = "search_form">
<input type = "hidden" name = "mode" value = "<?=$mode?>">
<input type = "hidden" name = "set_g_state" value = "<?=$set_g_state?>">
<input type = "hidden" name = "sel_type" value = "<?=$sel_type?>">
<input type = "hidden" name = "ca_num" value = "<?=$ca_num?>">
<input type = "hidden" name = "cg_code" value = "<?=$cg_code?>">

<select name = "key"">
	<option value = "g_name" <?if($key == "g_name"){?>selected<?}?>>강좌명</option>
</select>

<input type = "text" name  = "searchword" value = "<?=$searchword?>" onKeyDown = "enter_down('search')"> <input type = "button" value  = "검색" onclick="search_go()"> 
<?php
	if ($searchword) {
?>
<input type = "button" value = "전체 게시물 보기" onclick="change_list()">
<?php } ?>
</form>
</div>
