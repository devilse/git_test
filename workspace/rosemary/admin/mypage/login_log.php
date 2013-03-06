<?php
$mb_num = $User_Info["member_num"];

if (!empty($_GET['set_time'])) {
	$set_time = trim($_GET['set_time']);
	$set_chk_time = time() - $set_time;
	$set_time_where = "and  mbl_regdate > $set_chk_time";
	if ($set_time >= 86400) {
		$sel_day = $set_time / 86400; 
	} else {
		$sel_hour = $set_time / 3600;
	}
}



$log_cnt_query = mysqli_query($CONN['rosemary'],"select count(*) as cnt from member_loginlog a, member b where a.mb_num = '$mb_num' and a.mb_num = b.mb_num  $set_time_where");
$log_cnt_num = mysqli_result($log_cnt_query,0,0);
$query_number	=	$log_cnt_num;

if ($query_number > 0) {
	$tot_cnt_query = mysqli_query($CONN['rosemary'],"select count(*) as cnt from member_loginlog a, member b where a.mb_num = '$mb_num' and a.mb_num = b.mb_num $search_cnt_where");
	$tot_cnt = mysqli_result($tot_cnt_query,0,0);

	$chk_hour_time = mktime() - 86400;
	$day_cnt_query = mysqli_query($CONN['rosemary'],"select count(*) as cnt from member_loginlog a, member b where a.mb_num = '$mb_num' and a.mb_num = b.mb_num and mbl_regdate > $chk_hour_time $search_cnt_where");
	$day_cnt = mysqli_result($day_cnt_query,0,0);

	$chk_time = mktime() - 3600;
	$time_cnt_query = mysqli_query($CONN['rosemary'],"select count(*) as cnt from member_loginlog a, member b where a.mb_num = '$mb_num' and a.mb_num = b.mb_num and  mbl_regdate > $chk_time $search_cnt_where");
	$time_cnt = mysqli_result($time_cnt_query,0,0);

}


?>
<script type = "text/javascript">
	function send_log(mode)
	{
		if (mode == "tot") {
			var f = document.set_form;
			f.set_time.value = "";
			f.submit();
		} else {
			if (mode == "day") {
				var sel_time = document.getElementById('sel_day');
				var set_time = parseInt(sel_time.value) * 86400;
			} else {
				var sel_time = document.getElementById('sel_hour');
				var set_time = parseInt(sel_time.value) * 3600;
			}

			if (!sel_time.value) {
				alert("검색할 범위의 일수를 입력해 주세요.");
				return;
			} else {
				
				if (set_time > 0) {
					var f = document.set_form;
					f.set_time.value = set_time;
					f.submit();
				} else {
					alert("0보다 큰 수를 입력해 주세요.");
				}
			}
		}

	}

function onlyNumberInput() 
{ 
 var code = window.event.keyCode; 

 if ((code > 34 && code < 41) || (code > 47 && code < 58) || (code > 95 && code < 106) || code == 8 || code == 9 || code == 13 || code == 46) 
 { 
  window.event.returnValue = true; 
  return; 
 } 
 window.event.returnValue = false; 
} 



</script>
<form name = "set_form">
	<input type  = "hidden" name = "mode" value = "<?php echo $mode;?>">
	<input type  = "hidden" name = "key" value = "<?php echo $key;?>">
	<input type  = "hidden" name = "searchword" value = "<?php echo $searchword;?>">
	<input type  = "hidden" name = "set_time" value = "<?php echo $set_time;?>">
</form>


<table width="100%" border="0" cellspacing="1" cellpadding="3" class="td" bgcolor="#999999">
	<tr bgcolor="#EFEFEF" height=30> 
		<td align=center> 
			<b><?php echo $User_Info["id"];?> 로그인 로그</b>
		</td>
	</tr>
	<tr bgcolor="#EFEFEF" > 
		<td align=center> 
			<table width="100%" border="0" cellspacing="1" cellpadding="3" class="td" bgcolor="#999999">
				<tr bgcolor="#EFEFEF">
					<td width=50%>&nbsp; </td>
					<td width=8% align=center>전체 로그인 수 </td>
					<td width=10% align=center><?php echo number_format($tot_cnt);?></td>
					<td width=8% align=center>1일 이내 로그인 수</td>
					<td width=10% align=center><?php echo number_format($day_cnt);?></td>
					<td width=8% align=center>한시간 이내 로그인 수</td>
					<td width=10% align=center><?php echo number_format($time_cnt);?></td>
				</tr>
			</table>
		</td>
	</tr>	
</table>
<br>

<div align=right>
<input type = "text" name = "sel_day" id = "sel_day" size=5 value = "<?php echo $sel_day;?>" onKeyDown = "javascript:onlyNumberInput()"> <input type  = "button" value ="일 이내 목록 보기" onclick="send_log('day')">	<input type = "text" name = "sel_hour" id = "sel_hour" size=5 value = "<?php echo $sel_hour;?>" onKeyDown = "javascript:onlyNumberInput()"> <input type  = "button" value ="시간 이내 목록 보기" onclick="send_log('hour')"> <input type  = "button" value ="전체 시간 보기" onclick="send_log('tot')">
</div><br>

<table width="100%" border="0" cellspacing="1" cellpadding="3" class="td" bgcolor="#999999">

	<tr bgcolor="#EFEFEF"> 
		<td align=center width=10%>NO</td>
		<td align=center width=10%>OS</td>
		<td align=center width=10%>브라우저</td>
		<td align=center width=10%>로그인아이피</td>
		<td align=center width=10%>로그인날짜</td>
	</tr>
<?php

if ($query_number) {
	$number = $query_number - $first;
	$log_list_query = mysqli_query($CONN['rosemary'],"select a.*,b.mb_id,b.mb_name,b.mb_num from member_loginlog a, member b where a.mb_num = '$mb_num'  and a.mb_num = b.mb_num  $set_time_where order by mbl_num desc $limit");
	while ($log_rs = mysqli_fetch_array($log_list_query)) {
		$reg_date = date("Y-m-d H:i:s",$log_rs['mbl_regdate']);
?>
	<tr bgcolor="#FFFFFF"> 
		<td align=center ><?php echo $number?></td>
		<td align=center ><?php echo $log_rs['mbl_browser']?></td>
		<td align=center ><?php echo $log_rs['mbl_os']?></td>
		<td align=center ><?php echo $log_rs['mbl_ip']?></td>
		<td align=center ><?php echo $reg_date;?></td>
	</tr>
<?php
	$number--;
	}
?>
	<tr bgcolor="#FFFFFF"> 
		<td align=center colspan=8>
		<ul class="bod_pagelist">
		<?php echo go_page($query_number, $num_per_page, $num_per_block, $page, "./index.php?set_time=$set_time&", $key, $searchword,$mode);?>
		</ul>
		</td>
	</tr>
<?php
} else {
?>
	<tr bgcolor="#FFFFFF"> 
		<td align=center colspan=8>등록된 로그가 없습니다.</td>
	</tr>
<?php
}
?>
</table><br><br>
