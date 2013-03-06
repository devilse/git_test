 <?php

$key = $_GET['key'];
$searchword = $_GET['searchword'];


if ($key == "sc_content") {
	$clause_list_query = mysqli_query($CONN['rosemary'],"select count(*) as cnt from site_clause where 1=1 and sc_content like '%$searchword%'");
} else {
	$clause_list_query = mysqli_query($CONN['rosemary'],"select count(*) as cnt from site_clause where 1=1  ");
}

$list_cnt = mysqli_result($clause_list_query,0,0);
$query_number	=	$list_cnt;
 ?>
 <script type = "text/javascript">

	String.prototype.trim=function()
	{
	  var str=this.replace(/(\s+$)/g,"");
	  return str.replace(/(^\s*)/g,"");
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



	function send_write()
	{
		document.location.href = "./index.php?mode=clause_write";
	}

 </script>
 
 
 
 
 <table width="100%" border="0" cellspacing="1" cellpadding="3" class="td" bgcolor="#999999" style="white-space:nowrap">

  <tr bgcolor="#EFEFEF" height=30> 
	  <td align=center> 
		<table width=500>
			<tr>
				<td align=center><b>이용약관</b> </td>
			</tr>
		</table>

		
	  </td>
	</tr>	
  </table><br>


<table width="100%" border="0" cellspacing="1" cellpadding="3" class="td" bgcolor="#999999" style='layout-fixed;'>
	<tr bgcolor="#EFEFEF" height=30> 
		<td align=center width=50> 
			내용	
		</td>
		<td align=center width=10%> 
			사용시작일	
		</td>
		<td align=center width=10%> 
			등록일시	
		</td>
	</tr>


<?php
if ($query_number) {
	if ($key == "sc_content") {
		$list_query = mysqli_query($CONN['rosemary'],"select * from site_clause where 1=1 and sc_content like '%$searchword%'  order by sc_num desc");
	} else {
		$list_query = mysqli_query($CONN['rosemary'],"select * from site_clause where 1=1  order by sc_num desc ");
	}	
	while($list_rs = mysqli_fetch_array($list_query)){
		$list_title = mb_strimwidth(stripslashes($list_rs['sc_content']), 0, 500, "...", "UTF-8");	// 제목
		$start_date = date("Y-m-d",$list_rs['sc_sdate']);
		$reg_date = date("Y-m-d H:i:s",$list_rs['sc_regdate']);
		$sc_num = $list_rs['sc_num'];
?>
	<tr bgcolor="#FFFFFF"> 
		<td  width=50 style="padding:20 0 20 0"> 
			<a href="./index.php?mode=clause_write&write_mode=modi&sc_num=<?php echo $sc_num;?>&page=<?php echo $page;?>&key=<?php echo $key;?>&searchword=<?php echo $searchword;?>"><?php echo $list_title;?></a>	
		</td>
		<td align=center width=10%> 
			<?php echo $start_date;?>	
		</td>
		<td align=center width=10%> 
			<?php echo $reg_date?>	
		</td>
	</tr>
<?php }?>


	<tr bgcolor="#FFFFFF"> 
	  <td align=center colspan=3>
	  <ul class="bod_pagelist">
<?php 
			echo go_page($query_number, $num_per_page, $num_per_block, $page, "./index.php?", $key, $searchword,$mode);
?>			
</ul>
	  </td>
	</tr>

<?
} else {	
?>
	<tr bgcolor="#FFFFFF"> 
		<td align=center colspan=3> 
			등록된 게시물이 없습니다.
		</td>
	</tr>
<?php }?>


	<tr bgcolor="#FFFFFF"> 
		<td align="right" colspan=3> 
			<input  type = "button" value  = "등록" onclick="send_write()">
		</td>
	</tr>
</table>



<div align=center>
<form name = "search_form">
<input type = "hidden" name = "mode" value = "<?=$mode?>">
<select name = "key"">
	<option value = "sc_content" <?if($key == "sc_content"){?>selected<?}?>>내용</option>

</select>

<input type = "text" name  = "searchword" value = "<?=$searchword?>"> <input type = "button" value  = "검색" onclick="search_go()"> 
<?php
	if ($searchword) {
?>
<input type = "button" value = "전체 게시물 보기" onclick="change_list()">
<?php } ?>
</form>
</div>