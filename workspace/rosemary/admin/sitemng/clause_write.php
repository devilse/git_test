<?php
$sc_num = $_GET['sc_num'];
$write_mode = $_GET['write_mode'];
$page = $_GET['page'];
$key = $_GET['key'];
$searchword = $_GET['searchword'];

if ($write_mode == "modi") {

	$sc_view_query = mysqli_query($CONN['rosemary'],"select * from site_clause where sc_num = '$sc_num'");
	$sc_view_nums = mysqli_num_rows($sc_view_query);
	if (!$sc_view_nums) {
		alertback("존재하지 않는 게시물 입니다.");
	} else {
		$sc_rs = mysqli_fetch_array($sc_view_query);
		$content = stripslashes($sc_rs['sc_content']);		// 내용
		$start_date = date("Y-m-d",$sc_rs['sc_sdate']);

	}
}

?>
 
 <script src="<?php echo $MY_URL;?>_js/calendar.js" type="text/javascript"></script>
 
 <script type = "text/javascript">
	function send_write()
	{
		var f = document.writeform;
		var check_memo = f.content.value = SubmitHTML();
		if(!check_memo){
			alert("내용을 입력해 주세요.");
			return;
		}else{
			f.action = "./process/clause_process.php";
			f.submit();
		}
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


 <table width="100%" border="0" cellspacing="1" cellpadding="3" class="td" bgcolor="#999999" style="white-space:nowrap">
<form name="writeform" method="post"  enctype='multipart/form-data' id = "writeform">
	<input type = "hidden" name = "write_mode" value = "<?php echo $write_mode;?>">
	<input type = "hidden" name = "page" value = "<?php echo $page;?>">
	<input type = "hidden" name = "key" value = "<?php echo $key;?>">
	<input type = "hidden" name = "searchword" value = "<?php echo $searchword;?>">
	<input type = "hidden" name = "sc_num" value = "<?php echo $sc_num;?>">
  <tr bgcolor="#EFEFEF" height=30 > 
	  <td align=center> 
		 <table width="100%" border="0" cellspacing="1" cellpadding="3" class="td" bgcolor="#999999" style="white-space:nowrap">
			<tr bgcolor="#EFEFEF">
				<td align=center width="10%">
				
				약관 시행일
				
				</td>
				<td align=left >
				
				<INPUT TYPE="text" NAME="start_date" onclick="Calendar_D(document.all.start_date)" value = "<?php echo $start_date;?>">  ( ex) '2012-12-25' )
				
				</td>
			</tr>


			<tr>
				<td align=center bgcolor="white" colspan=2>
				
				<?php echo myEditor2(1,'../../gmEditor','writeform','content','100%','400');?>
				
				</td>
			</tr>

		</table>
	  </td>
	</tr>	
</form>

</table>

<br><br>
<div align="right">
<input type  = "button" value = "리스트" onclick  = "history.back();"> <input type  = "button" value = "저장" onclick  = "send_write()">
</div>
<br><br>



