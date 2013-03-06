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
	if ($key == "gg_code" || $key == "gg_name") {
		$search_where = "and $key like '%$searchword%'";
	}

	$encode_searchword = urlencode($searchword);
}



$state_where = "";
if ($set_state) {
	$state_where = "and gg_sort_type = '$set_state'";
}



$cs_where = "";
if ($set_cs) {
	$cs_where = "and A.cg_code = '$set_cs'";
}


//디비 쿼리
$cnt_qry = "select count(*) as cnt from goods_group A where 1 = 1 $search_where $cs_where $state_where";


$list_qry = "
			 select 
					A.*,
					B.cg_name as cg_name,
					(select count(*) as cnt from goods_group_goods C where C.gg_code = A.gg_code) as goods_cnt
			 from 
					goods_group A,
					category_group B
			 where 
					1 = 1
					and A.cg_code = B.cg_code
					$search_where 
					$cs_where 
					$state_where

					order by A.gg_regdate desc
			";

				

$cnt_query = mysqli_query($CONN['rosemary'],$cnt_qry);


$tot_cnt = mysqli_result($cnt_query,0,0);
$query_number	=	$tot_cnt;
?>

<script type = "text/javascript">
	function page_change(val){
		document.location.href="./index.php?mode="+val;
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
				<td align=center><b>상품 목적그룹 리스트</b></td>
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
		<td align=center width=10%>그룹코드</td>
		<td align=center width=30%>그룹명</td>
		<td align=center width=10%>
		<select name ="set_state" onchange="sel_change('state',this.value)">
			<option value = "" <?php if(!$set_state){?>selected<?}?>>전체</option>
			<option value = "A" <?php if($set_state == "A"){?>selected<?}?>>순서정렬</option>
			<option value = "R" <?php if($set_state == "R"){?>selected<?}?>>무작위정렬</option>
		</select>	
		</td>
		<td align=center width=4%>구성상품수</td>
		<td align=center width=10%>등록일</td>
	</tr>	

<?php
if ($query_number) {
	$number = $query_number - $first;
	$query = mysqli_query($CONN['rosemary'],$list_qry);
	while ($rs = mysqli_fetch_array($query)) {
		$gg_code = $rs['gg_code'];
		$reg_date = date("Y-m-d H:i:s",$rs['gg_regdate']);
		if ($rs['gg_sort_type'] == "A") {
			$sort = "순서정렬";
		} else {
			$sort = "무작위정렬";
		}
		$cg_name = $rs['cg_name'];
		$list_name  = $rs['gg_name'];
?>
	<tr bgcolor="#FFFFFF" height=30> 
		<td align=center><?php echo $number;?></td>
		<td align=center><?php echo $cg_name;?></td>
		<td align=center>
			<?php echo $gg_code;?>
		</td>
		<td align=left>

		&nbsp;<a href="./index.php?mode=sel_goods_view&gg_code=<?php echo $gg_code;?>&page=<?php echo $page;?>&key=<?php echo $key;?>&searchword=<?php echo $encode_searchword;?>&set_state=<?php echo $set_state;?>&set_cs=<?php echo $set_cs;?>"><?php echo $list_name;?></a>

		</td>
		<td align=center>
		<?php echo $sort;?>
		</td>
		<td align=center><?php echo number_format($rs['goods_cnt']);?>개</td>
		<td align=center><?php echo $reg_date;?></td>
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
		<td align=center  colspan=8>등록된 그룹이 없습니다.</td>
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
	<option value = "gg_code" <?if($key == "gg_code"){?>selected<?}?>>그룹코드</option>
	<option value = "gg_name" <?if($key == "gg_name"){?>selected<?}?>>그룹명</option>
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
	<input type = "button" value = "목적 상품 구성" onclick="page_change('sel_goods_reg')">
</div><br></br>



