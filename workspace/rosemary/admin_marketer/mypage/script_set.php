<?php
$mb_num = $User_Info["member_num"];
$query = "select * from member_marketer_script where mb_num = '$mb_num' order by mbs_num desc";
$script_qry = mysqli_query($CONN['rosemary'],$query);
$query_number = mysqli_num_rows($script_qry);
?>

<script type = "text/javascript">
	function script_reg()
	{
		var f = document.script_form;
		if (!f.script.value) {
			alert("등록할 스크립트를 입력해 주세요.");
			f.script.focus();
			return;
		} else {
			f.action = "./process/script_reg.php";
			f.submit();
		}
	}
	function script_del(val)
	{
		if (confirm("해당 스크립트를 삭제 하시겠습니까?")) {
			document.location.href="./process/script_del.php?del_num="+val;
		}
	}
</script>




<table width="100%" border="0" cellspacing="1" cellpadding="3" class="td" bgcolor="#999999">
	<tr bgcolor="#EFEFEF" height=30> 
		<td align=center> 
			<b>스크립트 관리</b>
		</td>
	</tr>	
</table>
<br>



<table width="100%" border="0" cellspacing="1" cellpadding="3" class="td" bgcolor="#999999">
<form name = "script_form" method="post">
	<tr bgcolor="#EFEFEF"> 
		<td align=center width=8%>스크립트</td>
		<td align=left height="40"><textarea style="width:100%;height:100%;" name="script"></textarea></td>
	</tr>

</form>
</table>
<br>
<div align="center">
	<input type = "button" value = "스크립트 추가" onclick="script_reg()">
</div>
<br>


<table width="100%" border="0" cellspacing="1" cellpadding="3" class="td" bgcolor="#999999">
	<tr bgcolor="#EFEFEF"> 
		<td align="center" >NO</td>
		<td align="center" >스크립트</td>
		<td align="center" >등록일</td>
		<td align="center" width="5%">삭제</td>
	</tr>
<?php

	$first = $num_per_page * ($page - 1);
	$limit = "limit $first, $num_per_page";

if ($query_number) {
	$number = $query_number - $first;

	$list_qry = mysqli_query($CONN['rosemary'],$query." ".$limit);

	while ($script_rs = mysqli_fetch_array($list_qry)) {
		$s_num = $script_rs['mbs_num'];
		$script = stripslashes(htmlspecialchars($script_rs['mbs_script']));
		$reg_date = date("Y-m-d H:i:s",$script_rs['mbs_regdate']);
?>

	<tr bgcolor="#FFFFFF"> 
		<td align="center" ><?php echo $number;?></td>
		<td align="left" ><textarea style="width:100%;" rows=5 readOnly><?php echo $script;?></textarea></td>
		<td align="center" width="10%"><?php echo $reg_date;?></td>
		<td align="center" width="5%"><input type="button" value="삭제" onclick="script_del('<?php echo $s_num;?>')"></td>
	</tr>
<?
		$number--;
	}
?>


	<tr bgcolor="#FFFFFF" colspan="2"> 
		<td align="center" height="30" colspan="4">
		<ul class="bod_pagelist">
		<?php echo go_page($query_number, $num_per_page, $num_per_block, $page, "./index.php?", $key, $searchword,$mode);?>
		</ul>
		</td>
	</tr>

<?php
} else {		
?>
	<tr bgcolor="#FFFFFF" colspan="2"> 
		<td align="center" height="30" colspan="4">등록된 스크립트가 없습니다.</td>
	</tr>
<?php
}	
?>

</table>