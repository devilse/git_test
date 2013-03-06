 <?php
$account_list_query = mysqli_query($CONN['rosemary'],"select count(*) as cnt from site_account_number where 1=1  ");
$list_cnt = mysqli_result($account_list_query,0,0);
$query_number	=	$list_cnt;
 ?>
 <script type = "text/javascript">

	function send_write()
	{
		document.location.href = "./index.php?mode=clause_write";
	}
	function reg_bank()
	{
		var f = document.bank_form;
		if(!f.bank.value){
			alert("은행명을 입력해 주세요.");
			f.bank.focus();
		}else if(!f.bank_number.value){
			alert("계좌번호를 입력해 주세요.");
			f.bank.focus();
		}else if(!f.name.value){
			alert("계좌주를 입력해 주세요.");
			f.bank.focus();
		}else{
			f.action = "./process/bank_process.php"; 
			f.submit();
		}
	}
	function send_del(val)
	{
		if(confirm("해당 계좌를 삭제 하시겠습니까?")){
			var f = document.bank_form;
			f.set_number.value = val;
			f.write_mode.value = "del";
			f.action = "./process/bank_process.php"; 
			f.submit();
		}
	}
	function send_state(val,mode)
	{
			var f = document.bank_form;
			f.set_number.value = val;
			f.write_mode.value = "state_modi";
			f.state_mode.value = mode;
			f.action = "./process/bank_process.php"; 
			f.submit();
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
		<td align=center width=20%> 
			은행명	
		</td>
		<td align=center width=20%> 
			계좌번호	
		</td>
		<td align=center width=20%> 
			계좌주	
		</td>
		<td align=center width=20%> 
			사용유무	
		</td>
		<td align=center width=10%> 
			등록날짜	
		</td>
		<td align=center width=10%> 
	
		</td>
	</tr>
<?
if ($query_number) {
	$list_query = mysqli_query($CONN['rosemary'],"select* from site_account_number where 1=1  order by sa_regdate desc");
	while($account_rs = mysqli_fetch_array($list_query)){
		$sa_num = $account_rs['sa_num'];
		$bank_name = $account_rs['sa_bankname'];
		$sa_name = $account_rs['sa_name'];
		$sa_useyn = $account_rs['sa_useyn'];
		$reg_date = date("Y-m-d H:i:s",$account_rs['sa_regdate']);
?>
	<tr bgcolor="#FFFFFF" height=30> 
		<td align=center width=20%> 
			<?php echo $bank_name;?>	
		</td>
		<td align=center width=20%> 
			<?php echo $sa_num;?>	
		</td>
		<td align=center width=20%> 
			<?php echo $sa_name;?>		
		</td>
		<td align=center width=20%> 
			<input type  = "checkbox" name = "state_<?php echo $sa_num;?>" <?php if($sa_useyn == "Y"){?>checked onclick="send_state('<?php echo $sa_num;?>','N')"  <?php }else{?>onclick="send_state('<?php echo $sa_num;?>','Y')" >	<?php }?>
		</td>
		<td align=center width=10%> 
			<?php echo $reg_date;?>	
		</td>
		<td align=center width=10%> 
			<input type = "button" value = "삭제" onclick="send_del('<?php echo $sa_num;?>')">	
		</td>


	</tr>
<?php
	}
} else {
?>
	<tr bgcolor="#FFFFFF" height=30> 
		<td align=center colspan=6> 
			등록된 계좌정보가 없습니다.
		</td>
	</tr>
<?php }?>

</table>
<br><br>

<table width="100%" border="0" cellspacing="1" cellpadding="3" class="td" bgcolor="#999999" style="white-space:nowrap">
<form name  = "bank_form" method="post">
<input type  = "hidden" name = "write_mode" value = "reg">
<input type  = "hidden" name = "set_number" >
<input type  = "hidden" name = "state_mode" >
	<tr bgcolor="#EFEFEF" height=30> 
		<td align=center colspan=2> 
			<b>은행계좌 추가</b>
		</td>
	</tr>	

	<tr bgcolor="#EFEFEF"> 
		<td align=center  width=20%> 
			은행명
		</td>
		<td align=left > 
			<input type  = "text" name  = "bank">
		</td>
	</tr>
	<tr bgcolor="#EFEFEF"> 
		<td align=center  width=20%> 
			계좌번호
		</td>
		<td align=left > 
			<input type  = "text" name  = "bank_number">
		</td>
	</tr>
	<tr bgcolor="#EFEFEF"> 
		<td align=center  width=20%> 
			계좌주
		</td>
		<td align=left > 
			<input type  = "text" name  = "name">
		</td>
	</tr>
	<tr bgcolor="#EFEFEF" height=30> 
		<td align=center colspan=2> 
			<input type  ="button" value = " 계좌 등록 " onclick="reg_bank()">
		</td>
	</tr>	
</form>
</table>