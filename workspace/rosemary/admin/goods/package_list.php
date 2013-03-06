<?
if (!empty($_GET['key'])) {
	$key = $_GET['key'];
}
if (!empty($_GET['searchword'])) {
	$searchword = trim($_GET['searchword']);
}

if (!empty($_GET['set_state'])) {
	$set_state = trim($_GET['set_state']);
}
if (!$key && $searchword) {
	$key = "g_name";
}
if (!empty($_GET['set_cs'])) {
	$set_cs = trim($_GET['set_cs']);
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
	if ($key == "gp_name") {
		$search_where = "and A.gp_name like '%$searchword%'";
	}

	$encode_searchword = urlencode($searchword);
}



$state_where = "";
if ($set_state) {
	$state_where = "and gp_state = '$set_state'";
}



$cs_where = "";
if ($set_cs) {
	$cs_where = "and E.cg_code = '$set_cs'";
}


//디비 쿼리
$cnt_qry = "select count(*) as cnt from goods_package A, category_group E where  A.cg_code = E.cg_code $search_where $cs_where $state_where";


$list_qry = "
				select 
						A.*,
						E.cg_name as cg_name,
						(select	
								sum((select sum(C.lt_selling_price) - truncate(((sum(C.lt_selling_price) * (D.g_discount_rate / 100) )),0)  from goods_lecture C, goods D  where C.g_num = B.g_num and B.g_num = D.g_num))
						 from 
								goods_package_goods B 
						 where 
								A.gp_num = B.gp_num) as price,

						(select GROUP_CONCAT(CONCAT_WS('<>',C.g_num,C.g_name,D.ca_name) SEPARATOR '||') from goods_package_goods B, goods C, category D  where B.gp_num = A.gp_num and B.g_num = C.g_num and C.ca_num = D.ca_num) as g_name

				from 
						goods_package A ,
						category_group E

				where
						A.cg_code = E.cg_code
						$search_where
						$cs_where
						$state_where

				order by A.gp_num desc $limit
			";
				
$cnt_query = mysqli_query($CONN['rosemary'],$cnt_qry);
$tot_cnt = mysqli_result($cnt_query,0,0);
$query_number	=	$tot_cnt;

//SELECT GROUP_CONCAT(ca_name SEPARATOR ':') FROM category;
//SELECT GROUP_CONCAT(ca_name) FROM category;
//SELECT CONCAT_WS(',',ca_name) FROM category;

?>

<script type = "text/javascript">
	function package_reg(){
		document.location.href="./index.php?mode=package_reg";
	}
	function sel_change(mode,val) 
	{
		var f = document.search_form;
		if (mode == "cs") {
			f.set_cs.value = val;
		} else if (mode == "state") {
			f.set_state.value = val;
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
</script>

<table width="100%" border="0" cellspacing="1" cellpadding="3" class="td" bgcolor="#999999" style="white-space:nowrap">
	<tr bgcolor="#EFEFEF" height=30> 
		<td align=center> 
			<table width=500>
				<tr>
				<td align=center><b>패키지 리스트</b></td>
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
					<td width=10% align=center><?php echo number_format($tot_cnt);?></td>
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
		<td align=center width=4%>NO</td>
		<td align=center width=8%>

			<select name ="cg_code_select" onchange="sel_change('cs',this.value)">

				<option value = "" <?if(!$set_cs){?>selected<?}?>>전체</option>
<?php
	$category_group_qry = mysqli_query($CONN['rosemary'],"select cg_code,cg_name from category_group");
	while ($category_group_rs = mysqli_fetch_array($category_group_qry)) {	
?>
				<option value="<?php echo $category_group_rs['cg_code'];?>" <?if($category_group_rs['cg_code'] == $set_cs){?>selected<?}?>><?php echo $category_group_rs['cg_name'];?></option>
<?}?>
			</select>


		</td>
		<td align=center width=30%>리스트이미지 + 패키지명</td>
		<td align=center width=30%>패키지 구성</td>
		<td align=center width=10%>가격</td>
		<td align=center width=4%>할인율</td>
		<td align=center width=10%>등록일</td>
		<td align=center>
<select name ="set_state" onchange="sel_change('state',this.value)">
	<option value = "" <?php if(!$set_state){?>selected<?}?>>전체</option>
	<option value = "R" <?php if($set_state == "R"){?>selected<?}?>>준비중</option>
	<option value = "S" <?php if($set_state == "S"){?>selected<?}?>>판매중</option>
	<option value = "N" <?php if($set_state == "N"){?>selected<?}?>>판매중단</option>
</select>
		</td>
	</tr>	

<?php
if ($query_number) {
	$number = $query_number - $first;
	$query = mysqli_query($CONN['rosemary'],$list_qry);
	while ($rs = mysqli_fetch_array($query)) {
		$gp_num = $rs['gp_num'];
		$reg_date = date("Y-m-d H:i:s",$rs['gp_regdate']);
		if ($rs['gp_state'] == "R") {
			$state = "준비중";
		} else if ($rs['gp_state'] == "S") {
			$state = "판매중";
		} else {
			$state = "판매중단";
		}
		$price = number_format($rs['price']);
		$h_price = @round($rs['price'] - ($rs['price'] * ($rs['gp_discount_rate'] / 100)),0);
		$cg_name = $rs['cg_name'];
		$g_name_array = explode("||",$rs['g_name']);
		
	



?>
	<tr bgcolor="#FFFFFF" height=30> 
		<td align=center><?php echo $number;?></td>
		<td align=center><?php echo $cg_name;?></td>
		<td align=center>
		<img src = "../../dir_img/goods_img/<?php echo $rs['gp_img'];?>"><br>
			<a href="./index.php?mode=package_view&gp_num=<?php echo $gp_num;?>&page=<?php echo $page;?>&key=<?php echo $key;?>&searchword=<?php echo $searchword;?>&set_cs=<?php echo $set_cs;?>&set_state=<?php echo $set_state;?>"><?php echo $rs['gp_name'];?></a>		
		</td>
		<td align=left>
<?php
	$end_for = count($g_name_array);	
	for ($i=0;$i<$end_for;$i++) {
		$g_name_array2 = explode("<>",$g_name_array[$i]);
		$g_num = $g_name_array2[0];
		$g_name = $g_name_array2[1];
		$ca_name = $g_name_array2[2];
		echo "&nbsp;".$g_name." (".$ca_name.")"."<br>";
	}
?>		
	


		</td>
		<td align=center>
		<?php if($rs['gp_discount_rate'] > 0){?>
		(<strike><?php echo $price;?>원</strike>) 
		<?php }?>
		<?php echo number_format($h_price);?>원
		</td>
		<td align=center><?php echo number_format($rs['gp_discount_rate']);?>%</td>
		<td align=center><?php echo $reg_date;?></td>
		<td align=center><?php echo $state;?></td>
	</tr>	
<?php
	$number--;
	}
?>
	<tr bgcolor="#FFFFFF" height=30> 
		<td align=center  colspan=8>
		<ul class="bod_pagelist">
		<?php echo go_page($query_number, $num_per_page, $num_per_block, $page, "./index.php?set_cs=$set_cs&set_state=$set_state&", $key, $searchword,$mode);?>
		</ul>
		</td>
	</tr>	
<?php
} else {
?>
	<tr bgcolor="#FFFFFF" height=30> 
		<td align=center  colspan=8>등록된 상품이 없습니다.</td>
	</tr>	

<?php }?>
</table>
<br></br>


 <div align=center>
<form name = "search_form">
<input type = "hidden" name = "mode" value = "<?php echo $mode;?>">
<input type = "hidden" name = "set_state" value = "<?php echo $set_state;?>">
<input type = "hidden" name = "set_cs" value = "<?php echo $set_cs;?>">

<select name = "key"">
	<option value = "gp_name" <?if($key == "gp_name"){?>selected<?}?>>패키지명</option>
</select>

<input type = "text" name  = "searchword" value = "<?php echo $searchword;?>" onKeyDown = "enter_down('search')"> <input type = "button" value  = "검색" onclick="search_go()"> 
<?php
	if ($searchword) {
?>
<input type = "button" value = "전체 게시물 보기" onclick="change_list()">
<?php } ?>
</form>
</div>


<div align=right>
	<input type = "button" value = "패키지 상품 구성" onclick="package_reg()">
</div><br></br>



