<?php
$gp_num = $_GET['gp_num'];
$page = $_GET['page'];
$key = $_GET['key'];
$searchword = $_GET['searchword'];
$set_cs = $_GET['set_cs'];
$set_state = $_GET['set_state'];

$view_query = "select A.*,B.cg_name from goods_package A, category_group B where A.gp_num = '$gp_num' and A.cg_code = B.cg_code  ";

$view_result = mysqli_query($CONN['rosemary'],$view_query);
$view_nums = mysqli_num_rows($view_result);
if (!$view_nums) {
	alertback("삭제되거나 존재하지 않는 상품 입니다.");
}
$view_rs = mysqli_fetch_array($view_result);
$gp_num = $view_rs['gp_num'];
?>
<script src="<?php echo $MY_URL;?>_js/jquery.min.js" type="text/javascript"></script>
<script type = "text/javascript">
	function send_go(val)
	{
		var f = document.view_form;
		if (val == "package_del") {
			if (confirm("해당 패키지 상품을 삭제 하시겠습니까?")) {
				f.mode.value = val;
				f.method = "post";
				f.action = "./process/pack_del.php";
				f.submit();
			}
		} else {
			f.mode.value = val;
			f.action = "./index.php";
			f.submit();
		}
	}

	function set_gp_state(gp_num,val)
	{
		if (gp_num && val) {
			$.ajax({
				type : "POST" 
				, async : true 
				, url : "./process/pack_state_modi.php" 
				, dataType : "html" 
				, timeout : 30000 
				, cache : false  
				, data : "gp_num="+gp_num+"&val="+val
				, contentType: "application/x-www-form-urlencoded; charset=UTF-8"
				, error : function(request, status, error) {
					 alert("ajax 통신서버에 접속할 수 업습니다.");
				}
				, success : function(response, status, request) {
					var result=response.split('|');	
					alert(result[1]);
				}
			});
		}
	}
</script>

<form name = "view_form">
<input type = "hidden" name = "gp_num" value = "<?php echo $gp_num?>">
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
				<td align=center><b>패키지 상세정보</b></td>
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
		<td align=center>상태</td>
		<td align=left colspan=3 bgcolor="#FFFFFF">
			<input type="radio" name="gp_state" value="S" onclick="set_gp_state('<?php echo $gp_num;?>',this.value)" <?php if($view_rs['gp_state'] == "S"){?>checked<?php }?>> 판매중
			<input type="radio" name="gp_state" value="R" onclick="set_gp_state('<?php echo $gp_num;?>',this.value)" <?php if($view_rs['gp_state'] == "R"){?>checked<?php }?>> 준비중
			<input type="radio" name="gp_state" value="N" onclick="set_gp_state('<?php echo $gp_num;?>',this.value)" <?php if($view_rs['gp_state'] == "N"){?>checked<?php }?>> 판매중지
		</td>
	</tr>

	<tr bgcolor="#EFEFEF" height=30> 
		<td align=center>패키지명</td>
		<td align=left width=30% bgcolor="#FFFFFF"><?php echo $view_rs['gp_name'];?></td>
		<td align=center width=100 >패키지할인</td>
		<td align=left bgcolor="#FFFFFF"><?php echo $view_rs['gp_discount_rate'];?>%</td>
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

<?php

	$view_query2 = mysqli_query($CONN['rosemary'],"select B.g_name,C.ca_name from goods_package_goods A, goods B, category C where A.gp_num = '$gp_num' and A.g_num = B.g_num and B.ca_num = C.ca_num");
	$view_nums2 = mysqli_num_rows($view_query2);
	if ($view_nums2) {
		while($view_rs2 = mysqli_fetch_array($view_query2)){
			echo $view_rs2['g_name']." (".$view_rs2['ca_name'].")"."<br>";
		}} else {

	echo "등록된 상품이 없습니다.";

	}
?>

		</td>
	</tr>

	<tr bgcolor="#EFEFEF" height=30>
		<td width=10% align=center>
			리스트 이미지
		</td>
		<td  colspan=3 bgcolor="#FFFFFF">
			<img src = "../../dir_img/goods_img/<?php echo $view_rs['gp_img'];?>">
		</td>
	</tr>


	<tr bgcolor="#EFEFEF" height=30>
		<td width=10% align=center>
			패키지 슬로건
		</td>
		<td  colspan=3 bgcolor="#FFFFFF">
			<?php echo $view_rs['gp_slogan'];?>
		</td>
	</tr>


	<tr bgcolor="#EFEFEF" height=30>
		<td width=10% align=center>
			패키지 특전
		</td>
		<td  colspan=3 bgcolor="#FFFFFF">
			<?php echo nl2br($view_rs['gp_benefit']);?>
		</td>
	</tr>
	<tr bgcolor="#EFEFEF" height=30>
		<td width=10% align=center>
			패키지 설명
		</td>
			
		<td bgcolor="#FFFFFF" colspan=3>
			<?php echo $view_rs['gp_explanation'];?>
		</td>
	</tr>


</form>
</table>

<br><br>


<div align="right">
	<input type = "button" value = "삭제" onclick="send_go('package_del')"> 
	<input type = "button" value = "수정" onclick="send_go('package_modi')"> 
	<input type = "button" value = "리스트" onclick="send_go('package_list')">
</div>

<br><br>