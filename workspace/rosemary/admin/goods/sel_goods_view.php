<?php
$gg_code = $_GET['gg_code'];
$page = $_GET['page'];
$key = $_GET['key'];
$searchword = $_GET['searchword'];
$set_cs = $_GET['set_cs'];
$set_state = $_GET['set_state'];

$view_query = "select A.*,B.cg_name from goods_group A, category_group B where A.gg_code = '$gg_code' and A.cg_code = B.cg_code  ";

$view_result = mysqli_query($CONN['rosemary'],$view_query);
$view_nums = mysqli_num_rows($view_result);
if (!$view_nums) {
	alertback("삭제되거나 존재하지 않는 그룹 입니다.");
}
$view_rs = mysqli_fetch_array($view_result);

if ($view_rs['gg_sort_type'] == "A") {
	$sort_type = "순서정렬";
	//$order_by = "order by A.ggg_sort_type asc";
} else {
	$sort_type = "무작위정렬";
	//$order_by = "order by rand()";
}
$order_by = "order by A.ggg_sortnum asc";
?>
<script type = "text/javascript">
	function send_go(val)
	{
		var f = document.view_form;
		if (val == "sel_goods_del") {
			if (confirm("해당 상품 그룹을 삭제 하시겠습니까?")) {
				f.mode.value = val;
				f.method = "post";
				f.action = "./process/sel_goods_del.php";
				f.submit();
			}
		} else {
			f.mode.value = val;
			f.action = "./index.php";
			f.submit();
		}
	}
</script>

<form name = "view_form">
<input type = "hidden" name = "gg_code" value = "<?php echo $gg_code?>">
<input type = "hidden" name = "page" value = "<?php echo $page?>">
<input type = "hidden" name = "key" value = "<?php echo $key?>">
<input type = "hidden" name = "searchword" value = "<?php echo $searchword?>">
<input type = "hidden" name = "set_cs" value = "<?php echo $set_cs?>">
<input type = "hidden" name = "set_state" value = "<?php echo $set_state?>">
<input type = "hidden" name = "mode">

</form>

<table width="100%" border="0" cellspacing="1" cellpadding="3" class="td" bgcolor="#999999" style="white-space:nowrap">
	<tr bgcolor="#EFEFEF" height=30> 
		<td align=center> 
			<table width=500>
				<tr>
				<td align=center><b>상품 그룹 상세정보</b></td>
				</tr>
			</table>
		</td>
	</tr>	
</table>

<br>

<table width="100%" border="0" cellspacing="1" cellpadding="3" class="td" bgcolor="#999999" style="white-space:nowrap">
<form name  = "writeform" method="post" enctype='multipart/form-data' autocomplete="off">
<input type = "hidden" name = "set_good">

	<tr bgcolor="#EFEFEF" height=30> 
		<td align=center width=10%>상품 코드</td>
		<td align=left width=30% bgcolor="#FFFFFF"><?php echo $view_rs['gg_code'];?></td>
	</tr>

	<tr bgcolor="#EFEFEF" height=30> 
		<td align=center width=10%>상품 그룹 명</td>
		<td align=left width=30% bgcolor="#FFFFFF"><?php echo $view_rs['gg_name'];?></td>
	</tr>
	<tr bgcolor="#EFEFEF" height=30> 
		<td align=center width=10%>정렬방식</td>
		<td align=left width=30% bgcolor="#FFFFFF"><?php echo $sort_type;?></td>
	</tr>	

	<tr bgcolor="#EFEFEF" height=30> 
		<td align=center>과목(자격증) 선택</td>
		<td align=left colspan=3 bgcolor="#FFFFFF">
			<?php echo $view_rs['cg_name'];?>
		
		</td>
	</tr>

	<tr bgcolor="#EFEFEF" height=30> 
		<td align=center>상품 구성</td>
		<td align=left colspan=3 bgcolor="#FFFFFF">

		<table width="100%" border="0" cellspacing="1" cellpadding="3" class="td" bgcolor="#999999" style="white-space:nowrap">
			<tr bgcolor="#EFEFEF">
				<td width="5%">순서</td>
				<td width="10%">카테고리</td>
				<td >상품명</td>
			</tr>



<?php

	$view_query2 = mysqli_query($CONN['rosemary'],"select A.ggg_sortnum,B.g_name,C.ca_name from goods_group_goods A, goods B, category C where A.gg_code = '$gg_code' and A.g_num = B.g_num and B.ca_num = C.ca_num $order_by");
	$view_nums2 = mysqli_num_rows($view_query2);
	if ($view_nums2) {
		while($view_rs2 = mysqli_fetch_array($view_query2)){
			//echo $view_rs2['g_name']." (".$view_rs2['ca_name'].")"."<br>";
?>
			<tr bgcolor="#FFFFFF">
				<td align="center"><?php echo $view_rs2['ggg_sortnum'];?></td>
				<td align="center"><?php echo $view_rs2['ca_name'];?></td>
				<td><?php echo $view_rs2['g_name'];?></td>
			</tr>
<?php
		}} else {
?>
			<tr bgcolor="#FFFFFF">
				<td align="center" colspan=3>등록된 상품이 없습니다.</td>
			</tr>
<?php
	}
?>
			</table>

		</td>
	</tr>




</form>
</table>

<br><br>


<div align="right">
	<input type = "button" value = "삭제" onclick="send_go('sel_goods_del')"> 
	<input type = "button" value = "수정" onclick="send_go('sel_goods_modi')"> 
	<input type = "button" value = "리스트" onclick="send_go('sel_goods_list')">
</div>

<br><br>