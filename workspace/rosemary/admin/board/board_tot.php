<?php
$bbs_list_query = sql_query($CONN['rosemary'],"select * from board");
$bbs_list_num = mysqli_num_rows($bbs_list_query);
$query_number	=	$bbs_list_num;
?>

<script type="text/javascript">
	function sned_set(num,page) 
	{
		if (!num) {
			alert("선택된 게시판이 없습니다.");
		} else {
			document.location.href="./index.php?mode=bbs_detail&bo_num="+num+"&page="+page;
		}
	}
	function send_del(val) 
	{
		if (confirm("해당 게시판의 게시물을 모두 삭제 하시겠습니까?")) {
			document.location.href="./process/board_del.php?bo_num="+val;
		}
	}
</script>

<table width="100%" border="0" cellspacing="1" cellpadding="3" class="td" bgcolor="#999999">
	<tr bgcolor="#EFEFEF" height=30> 
	  <td align=center> 
		게시판 설정 관리
	  </td>
	</tr>	
</table>
<br>

 <table width="100%" border="0" cellspacing="1" cellpadding="3" class="td" bgcolor="#999999">

  <tr bgcolor="#EFEFEF"> 
	  <td align=center> 
		No
	  </td>
	  <td align=center> 
		게시판명
	  </td>
	  <td align=center> 
		게시물수
	  </td>
	  <td align=center> 
		사용스킨
	  </td>
	  <td align=center> 
		세부설정
	  </td>
	  <td align=center> 
		초기화
	  </td>
	</tr>
<?php
if($query_number){
	$qq = sql_query($CONN['rosemary'],"select * from board ");
	$number = $query_number - $first;
	while ($bbs_list_rs = mysqli_fetch_array($qq)) {
		$board_skin = $bbs_list_rs['bo_skin'];
		if (!$board_skin) {
			$board_skin = "basic";
		}
?>
	<tr bgcolor="#FFFFFF"> 
	  <td align=center> 
		<?=number_format($number)?>
	  </td>
	  <td align=center> 
		<a href="javascript:sned_set('<?=$bbs_list_rs['bo_num']?>','<?=$page?>')"><?=$bbs_list_rs['bo_name']?></a>
	  </td>
	  <td align=center> 
		<?=number_format($bbs_list_rs['list_cnt'])?>
	  </td>
	  <td align=center> 
		<img src = 'http://localhost/_template/skin/board/<?=$board_skin?>/sample.jpg' width=100 height=100 border=0>
	  </td>
	  <td align=center> 
		<input type = "button" value = "세부설정" onclick="sned_set('<?=$bbs_list_rs['bo_num']?>','<?=$page?>')">
	  </td>
	  <td align=center> 
		<a href="javascript:send_del('<?=$bbs_list_rs['bo_num']?>')">초기화</a>
	  </td>
	</tr>
<?php
		$number--;
	}
}else{
?>
	<tr bgcolor="#FFFFFF"> 
	  <td align=center colspan=10>
		등록된 게시판이 없습니다.
	  </td>
	</tr>
<?php }?>

  </table>

<br><br>					
