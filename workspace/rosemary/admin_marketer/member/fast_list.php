<?php
$key = $_GET['key'];
$searchword = $_GET['searchword'];

$where = "";
if ($key && $searchword) {
	$where = "and $key like '%$searchword%'";
}

$mb_num = $User_Info["member_num"];
$query = "select * from member_marketer_speedcounsel where mb_num = '$mb_num' $where order by mbsc_num desc";

$qry = mysqli_query($CONN['rosemary'],$query);
$query_number = mysqli_num_rows($qry);
?>

<script type = "text/javascript">
	function search_go(action)
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
				f.action = action;
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




<table width="100%" border="0" cellspacing="1" cellpadding="3" class="td" bgcolor="#999999">
	<tr bgcolor="#EFEFEF" height=30> 
		<td align=center> 
			<b>빠른상담 관리</b>
		</td>
	</tr>	
</table>
<br>





<table width="100%" border="0" cellspacing="1" cellpadding="3" class="td" bgcolor="#999999">
	<tr bgcolor="#EFEFEF"> 
		<td align="center" width="5%">NO</td>
		<td align="center" width="15%">학생명</td>
		<td align="center">상담내용</td>
		<td align="center" width="10%">연락처</td>
		<td align="center" width="10%">상담일시</td>
	</tr>
<?php

	$first = $num_per_page * ($page - 1);
	$limit = "limit $first, $num_per_page";

if ($query_number) {
	$number = $query_number - $first;
	$list_qry = mysqli_query($CONN['rosemary'],$query." ".$limit);
	while ($rs = mysqli_fetch_array($list_qry)) {
		$name = stripslashes($rs['mbsc_name']);
		$text = stripslashes(htmlspecialchars($rs['mbsc_memo']));
		$tel = stripslashes($rs['mbsc_tel']);
		$reg_date = date("Y-m-d H:i:s",$rs['mbsc_regdate']);
?>

	<tr bgcolor="#FFFFFF"> 
		<td align="center"><?php echo $number;?></td>
		<td align="center"><?php echo $name;?></td>
		<td align="center"><textarea style="width:100%;" rows=4 readOnly><?php echo $text;?></textarea></td>
		<td align="center"><?php echo $tel;?></td>
		<td align="center"><?php echo $reg_date?></td>
	</tr>
<?
		$number--;
	}
?>


	<tr bgcolor="#FFFFFF" > 
		<td align="center" height="30" colspan="5">
		<ul class="bod_pagelist">
		<?php echo go_page($query_number, $num_per_page, $num_per_block, $page, "./index.php?", $key, $searchword,$mode);?>
		</ul>
		</td>
	</tr>

<?php
} else {		
?>
	<tr bgcolor="#FFFFFF" > 
		<td align="center" height="30" colspan="5">등록된 문의가 없습니다.</td>
	</tr>
<?php
}	
?>

</table>
<br>

<div align=center>
<form name = "search_form">
<input type = "hidden" name = "mode" value = "<?=$mode?>">
<select name = "key">
	<option value = "mbsc_name" <?if($key == "mbsc_name"){?>selected<?}?>>학생명</option>
	<option value = "mbsc_memo" <?if($key == "mbsc_memo"){?>selected<?}?>>상담내용</option>
	<option value = "mbsc_tel" <?if($key == "mbsc_tel"){?>selected<?}?>>연락처</option>
</select>

<input type = "text" name  = "searchword" value = "<?=$searchword?>"> <input type = "button" value  = "검색" onclick="search_go('index.php')"> 
<?php
	if ($searchword) {
?>
<input type = "button" value = "전체 게시물 보기" onclick="change_list()">
<?php } ?>
</form>
</div>