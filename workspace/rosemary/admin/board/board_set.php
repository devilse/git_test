<?php
$bbs_list_query = sql_query($CONN['rosemary'],"select * from board where bo_state != 'N'");
$bbs_list_num = mysqli_num_rows($bbs_list_query);
$query_number	=	$bbs_list_num;
?>

<script type="text/javascript">
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
		게시판  관리
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
	$qq = sql_query($CONN['rosemary'],"select * from board where bo_state != 'N' $limit");
	$number = $query_number - $first;
	$loop_number2 = "323";
	while ($bbs_list_rs = mysqli_fetch_array($qq)) {
		$board_skin = $bbs_list_rs['bo_skin'];
		if (!$board_skin) {
			$board_skin = "basic";
		}
?>
	<tr bgcolor="#FFFFFF"> 
	  <td align=center> 
		<?php echo number_format($number);?>
	  </td>
	  <td align=center> 
		<a href="./index.php?mode=board_list&bo_num=<?php echo $bbs_list_rs['bo_num'];?>&page=<?php echo $page;?>&sub_menu_num=<?php echo $loop_number2;?>"><?php echo $bbs_list_rs['bo_name'];?></a>
	  </td>
	  <td align=center> 
		<?php echo number_format($bbs_list_rs['list_cnt']);?>
	  </td>
	  <td align=center> 
	  fds
	  </td>
	  <td align=center> 

	  </td>
	  <td align=center> 
		<a href="javascript:send_del('<?php echo $bbs_list_rs['bo_num'];?>')">초기화</a>
	  </td>

	</tr>
<?php
		$number--;
	    $loop_number2++;
	}
}else{
?>
	<tr bgcolor="#FFFFFF"> 
	  <td align=center colspan=10>
		등록된 게시판이 없습니다.
	  </td>
	</tr>
<?php }?>
	<tr bgcolor="#FFFFFF"> 
	  <td align=center colspan=10>
	  <ul class="bod_pagelist">
<?php echo go_page($query_number, $num_per_page, $num_per_block, $page, "./index.php?", $key, $searchword,$mode);?>
	  </td>
	  </ul>
	</tr>	
  </table>

<br><br>					
