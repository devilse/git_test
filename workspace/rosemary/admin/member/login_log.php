<?php

if (!empty($_GET['key'])) {
	$key = $_GET['key'];
}
if (!empty($_GET['searchword'])) {
	$searchword = trim($_GET['searchword']);
}

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

if ($key && $searchword) {
	$searchword_chk = 1;
	if (preg_match("/[!#$%^&*()?{}.;:<>+=\/]/",$searchword)) {
		$searchword_chk = 0; 
	}
	if ($searchword_chk != 1) {
		alertback("특수문자가 포함되어 검색할 수 없습니다.");
	}

	if ($key != "mb_name") {
		$search_where = "and b.$key = '$searchword'";
	} else {
		$search_where = "and b.$key like '%$searchword%'";
	}
	
	if ($key != "mb_num") {
		if ($key == "mb_name") {
			$search_cnt_where = "and b.mb_name like '%$searchword%'";
		} else {
			$search_cnt_where = "and b.mb_id = '$searchword'";
		}

		
	} else {
		$search_cnt_where = "and a.mb_num = '$searchword'";
	}


	$encode_searchword = urlencode($searchword);
}


$log_cnt_query = mysqli_query($CONN['rosemary'],"select count(*) as cnt from member_loginlog a, member b where a.mb_num = b.mb_num $search_where $set_time_where");
$log_cnt_num = mysqli_result($log_cnt_query,0,0);
$query_number	=	$log_cnt_num;

if ($query_number > 0) {
	$tot_cnt_query = mysqli_query($CONN['rosemary'],"select count(*) as cnt from member_loginlog a, member b where a.mb_num = b.mb_num $search_cnt_where");
	$tot_cnt = mysqli_result($tot_cnt_query,0,0);

	$chk_hour_time = mktime() - 86400;
	$day_cnt_query = mysqli_query($CONN['rosemary'],"select count(*) as cnt from member_loginlog a, member b where a.mb_num = b.mb_num and mbl_regdate > $chk_hour_time $search_cnt_where");
	$day_cnt = mysqli_result($day_cnt_query,0,0);

	$chk_time = mktime() - 3600;
	$time_cnt_query = mysqli_query($CONN['rosemary'],"select count(*) as cnt from member_loginlog a, member b where a.mb_num = b.mb_num and  mbl_regdate > $chk_time $search_cnt_where");
	$time_cnt = mysqli_result($time_cnt_query,0,0);

}


?>
<script type = "text/javascript">
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
			<b>로그인 로그</b>
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
<input type = "text" name = "sel_day" id = "sel_day" size=5 value = "<?php echo $sel_day;?>" onKeyDown = "javascript:onlyNumberInput()"> <input type  = "button" value ="일 이내 목록 보기" onclick="send_log('day')">	<input type = "text" name = "sel_hour" id = "sel_hour" size=5 value = "<?php echo $sel_hour;?>" onKeyDown = "javascript:onlyNumberInput()"> <input type  = "button" value ="시간 이내 목록 보기" onclick="send_log('hour')">  <input type  = "button" value ="전체 시간 보기" onclick="send_log('tot')">
</div><br>

<table width="100%" border="0" cellspacing="1" cellpadding="3" class="td" bgcolor="#999999">

	<tr bgcolor="#EFEFEF"> 
		<td align=center width=10%>NO</td>
		<td align=center width=10%>회원번호</td>
		<td align=center width=10%>아이디</td>
		<td align=center width=10%>회원이름</td>
		<td align=center width=10%>OS</td>
		<td align=center width=10%>브라우저</td>
		<td align=center width=10%>로그인아이피</td>
		<td align=center width=10%>로그인날짜</td>
	</tr>
<?php

if ($query_number) {
	$number = $query_number - $first;
	$log_list_query = mysqli_query($CONN['rosemary'],"select a.*,b.mb_id,b.mb_name,b.mb_num from member_loginlog a, member b where 1=1 and a.mb_num = b.mb_num $search_where $set_time_where order by mbl_num desc $limit");
	while ($log_rs = mysqli_fetch_array($log_list_query)) {
		$reg_date = date("Y-m-d H:i:s",$log_rs['mbl_regdate']);
?>
	<tr bgcolor="#FFFFFF"> 
		<td align=center ><?php echo $number?></td>
		<td align=center ><?php echo $log_rs['mb_num']?></td>
		<td align=center ><?php echo $log_rs['mb_id']?></td>
		<td align=center ><?php echo $log_rs['mb_name']?></td>
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


<div align=center>
<form name = "search_form">
<input type = "hidden" name = "mode" value = "<?=$mode?>">
<select name = "key"">
	<option value = "mb_id" <?if($key == "mb_id"){?>selected<?}?>>아이디</option>
	<option value = "mb_name" <?if($key == "mb_name"){?>selected<?}?>>회원이름</option>
	<option value = "mb_num" <?if($key == "mb_num"){?>selected<?}?>>회원번호</option>
</select>

<input type = "text" name  = "searchword" value = "<?=$searchword?>"> <input type = "button" value  = "검색" onclick="search_go()"> 
<?php
	if ($searchword) {
?>
<input type = "button" value = "전체 게시물 보기" onclick="change_list()">
<?php } ?>
</form>
</div>