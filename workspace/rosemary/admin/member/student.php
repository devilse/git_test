<?php 
$key = $_GET['key'];	//조건
$keyword = $_GET['keyword'];	//검색어
$page = $_GET['page'];
$mode = $_GET['mode'];

if (empty($keyword)) {
	$keyword = "";
}

if ($mode == 'student' || $mode == '') {
	$sql_where = "where mt_code = 'S'";
} else if ($mode == 'teacher') {
	$sql_where = "where mt_code = 'T'";
} else if ($mode == 'marketer') {
	$sql_where = "where mt_code = 'M'";
}else if($mode == 'admin'){
	$sql_where = "where mt_code = 'A'";
}

if ($key) {
	$condi = "and $key like '%$keyword%'";
}

$member_cnt_query = @mysqli_query($CONN['rosemary'],"select count(*) as cnt from member $sql_where");
$member_cnt  = mysqli_result($member_cnt_query,0,0);

$sql = @mysqli_query($CONN['rosemary'],"select * from member $sql_where $condi");
$query_number= mysqli_num_rows($sql);
$num_per_page = 10;

if (!$page) {
	$page = 1; // 페이지가 없으면 첫 페이지 (1 페이지)
}

$num_per_block  = ceil($query_number / $num_per_page); // 전체 페이지 계산

$from_record = ($page - 1) * $num_per_page; // 시작 열을 구함

?>

<script type="text/javascript" src="../../_js/mb_script.js"></SCRIPT>
<script type='text/javascript'>
	function go_search() 
	{	
		var f= document.form_search1;
		var keyword='';		
		var p_key_array = f.p_key;
		var p_key_len = p_key_array.length;
		var key_value = "";
		var mode = document.form1.mode.value;

		if (f.p_keyword.value == "" ) {
			alert ('검색어를 입력하세요');
			return;
		}
		keyword=f.p_keyword.value;
		
		for(i=0;i<p_key_len;i++) {
			if (f.p_key[i].checked == true) {
				key_value = f.p_key[i].value;
			}
		}
		
		f.action='./index.php?mode='+mode+'&key='+key_value+'&keyword='+keyword;
		f.submit();
	}
	
	function go_search_all() {
		var f= document.form_search1;
		var mode = document.form1.mode.value;

		f.action = "./index.php?mode="+mode;
		f.submit();
	}
	
	function check_all() {
		var f = document.form1;
		var is_check = (f.allcheck.checked)?true : false;
		
		for(var i=0; i<f.elements.length; i++){
			f.elements[i].checked = is_check;
		}
	}
	function checked_ok() {
		var f = document.form1;
		var chk_cnt = document.getElementsByName("delcheck");
		var page = f.page.value;
		var cnt = 0;
		var chk_data = '';
		
		for(var i=0; i<chk_cnt.length; i++) {
		
			if (chk_cnt.length == '1') {
				cnt++;
				chk_data = chk_data + '||' + f.delcheck.value;
				
			} else {
				if (f.delcheck[i].checked == true) {
					cnt++;
					chk_data = chk_data + '||' + f.delcheck[i].value;
				}
			}
		}
		if (cnt == '0') {
			alert('선택한 데이터가 없습니다.');
			return;
		} else {
			if (confirm('정말 삭제하시겠습니까?')) {
				chk_data = chk_data.substring(2,chk_data.length);
				f.action = 'member_update.php?c=del&page='+page;
				f.checkValues.value = chk_data;
				f.submit();
			}
		}
	}
	function show_ip_log(num)
	{
		window.open("./ip_log.php?mb_num="+num,"ip_log","width=400,height=500,scrollbars=yes");
	}
	function show_board_log(id)
	{
		window.open("./board_log.php?mb_id="+id,"bord_log","width=800,height=500,scrollbars=yes");
	}
</script>
			
<!-- 오른쪽 시작 -->
<?php 
if ( $mode == 'student') {
	$mode_title = '학습자';
} else if ( $mode == 'teacher') {
	$mode_title = '교수자';
} else if ( $mode == 'marketer') {
	$mode_title = '영업자';
} else if ( $mode == 'admin') {
	$mode_title = '관리자';
} 

?> 

<table width="100%" border="0" cellspacing="1" cellpadding="3" class="td" bgcolor="#999999">
	<tr bgcolor="#EFEFEF" height=30> 
		<td align=center> 
			<b><?php echo $mode_title;?> 회원관리</b>
		</td>
	</tr>
	<tr bgcolor="#EFEFEF" > 
		<td align=center> 
			<table width="100%" border="0" cellspacing="1" cellpadding="3" class="td" bgcolor="#999999">
				<tr bgcolor="#EFEFEF">
					<td width=50%>&nbsp; </td>
					<td width=8% align=center>전체 회원 수 </td>
					<td width=10% align=center><?php echo number_format($member_cnt);?></td>
				</tr>
			</table>
		</td>
	</tr>	
</table>
<br>



<form name='form_search1' method='post'>
<table width='100%' border='0' cellspacing='1' cellpadding='3' class='td' bgcolor='#999999'>

	<tr bgcolor='#FFFFFF'>
		<td rowspan='2' align='center' bgcolor='#EFEFEF'>회원</td>
		<td width='10%' align='center'>조건 : &nbsp;</td>
		<td>
			<input type='radio' name='p_key' value='mb_id' <?php if (mb_id == $key || $key == '') { ?> checked <?php } ?> >아이디
			<input type='radio' name='p_key' value='mb_name' <?php if (mb_name == $key) { ?> checked <?php } ?> >회원명
			<input type='radio' name='p_key' value='mb_email' <?php if (mb_email == $key) { ?> checked <?php } ?> >이메일
			<input type='radio' name='p_key' value='mb_hp' <?php if (mb_hp == $key) { ?> checked <?php } ?> >핸드폰번호	
		
		</td>
	</tr>
		<tr bgcolor='#FFFFFF'>
		<td align='center'>검색 : &nbsp;</td>	
		<td>
			<input type='text' name='p_keyword' style='width:100px;' value='<?php echo $keyword?>' onKeyDown="javascript:if (event.keyCode == 13) go_search();">
			<input type='button' value='검색' onclick="javascript:go_search();">
		</td>				
	</tr>
</table>
</form>

<br/><br/>
<form name='form1' method='post'>
<table width='100%' border='0'>
<input type='hidden' name='key' value='<?php echo $key?>'>
<input type='hidden' name='keyword' value='<?php echo $keyword?>'>
<input type='hidden' name='checkValues' >
<input type='hidden' name='page'  value='<?php echo $page?>'>		
<input type='hidden' name='mode'  value='<?php echo $mode ?>'>

	<tr>
		<td colspan='2'><?php echo $mode_title; ?> 회원 목록</td>
	</tr>
	<tr>
		<td>
			<input type='button' name='excel' value='엑셀다운받기' onClick = "location.href='./member_excel.php?key=<?php echo $key?>&keyword=<?php echo $keyword?>'">
			<input type='button' name='excel' value='회원 등록' onClick="javascript:WinPopUP1('./member_add.php?mode=<?php echo $mode?>&c=add&page=<?php echo $page?>','500','550','등록');">
			<input type='button' value='전체보기' onclick="javascript:go_search_all();">			
		</td>
		<td align='right'>
			<!-- 정렬 방법 : 이름순 --> 
		</td>
	</tr>
</table>

<table width='100%' border='0' cellspacing='1' cellpadding='3' class='td' bgcolor='#999999'>
	<tr bgcolor='#EFEFEF'>
		<td width='5%' align='center'><input type='checkbox' name = 'allcheck' onclick='javascript:check_all()'></td>
		<td width='5%' align='center'>번호</td>
		<td width='15%' align='center'>ID</td>
		<td width='15%' align='center'>이름</td>
		<td width='10%' align='center'>회원구분</td>
		<td width='10%' align='center'>가입일</td>
<?php
if ($mode == 'student') {
?>
		<td width='5%' align='center'>수강상태</td>
<?php } else if($mode == 'teacher') {?>
		<td width='5%' align='center'>과목</td>
<?php }?>
		<td width='15%' align='center'>사용아이피</td>
		<td width='15%' align='center'>작성글</td>
	</tr>
<?php 
if ($query_number) {
$member_sql = @mysqli_query($CONN['rosemary'],"select *,FROM_UNIXTIME(mb_regdate,'%Y.%m.%d') as date from member $sql_where $condi limit $from_record, $num_per_page");

$number = $query_number - $first;
for($i=0; $m_sql = mysqli_fetch_array($member_sql); $i++) {

?>
	<tr bgcolor='#FFFFFF'>
		<td bgcolor='#FFFFFF' align='center'><input type='checkbox' name='delcheck' value='<?php echo $m_sql['mb_num'] ?>'></td>
		<td bgcolor='#FFFFFF' align='center'><?php echo $number; ?></td>
		<td bgcolor='#FFFFFF' align='center'><a href="javascript:WinPopUP1('./member_add.php?c=up&num=<?php echo $m_sql['mb_num']?>&mode=<?php echo $mode?>&type=<?php echo $m_sql['mt_code']?>&page=<?php echo $page?>','500','550','수정');"><?php echo  $m_sql['mb_id'] ?></a></td>
		<td bgcolor='#FFFFFF' align='center'><?php echo  $m_sql['mb_name'] ?></td>
		<td bgcolor='#FFFFFF' align='center'>
		<?php  
		if ($m_sql['mt_code'] == 'S') {echo'학습자';}
		if ($m_sql['mt_code'] == 'T') {echo'교수자';}
		if ($m_sql['mt_code'] == 'M') {echo'영업자';}
		if ($m_sql['mt_code'] == 'A') {echo'관리자';}
		?>
		</td>
		<td bgcolor='#FFFFFF' align='center'><?php echo  $m_sql['date'] ?></td>

<?php
if ($mode == 'student') {
?>
		<td width='15%' align='center'>0개</td>
<?php } else if($mode == 'teacher') {?>
		<td width='5%' align='center'>과목임</td>
<?php }?>

		<td width='15%' align='center'><input type = "button" value = "아이피보기" onclick="show_ip_log('<?php echo $m_sql['mb_num'] ?>')"></td>
		<td width='15%' align='center'><input type = "button" value = "글보기" onclick="show_board_log('<?php echo $m_sql['mb_id'] ?>')"></td>

	</tr>
<?php  $number--;} ?>

<?php
} else {
?>
	<tr>
		<td bgcolor='#FFFFFF' align='center' colspan=10 height=30>등록된 회원이 없습니다.</td>
	</tr>

<?php }?>
</table>
<br>
<table width='100%'>
	<tr>
		<td align='right'><input type='button' value='선택 삭제' onclick='javascript:checked_ok()'></td>
	</tr>
	<tr bgcolor="#FFFFFF"> 
		<td align=center >
		<ul class="bod_pagelist">
			<?php 
			if ($query_number) {
				echo go_page($query_number, $num_per_page, $num_per_block, $page, "./student.php?mode=$mode", $key, $keyword,'');
			}
			?>
			</ul>
		</td>
	</tr>	
	
</table>
</form>
<!-- 오른쪽 끝 -->