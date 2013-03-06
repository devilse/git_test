<?php
$sp_num = $_GET['sp_num'];
$write_mode = $_GET['write_mode'];
$page = $_GET['page'];
$key = $_GET['key'];
$searchword = $_GET['searchword'];

if ($write_mode == "modi") {

	$sp_view_query = mysqli_query($CONN['rosemary'],"select * from site_privacy where sp_num = '$sp_num'");
	$sp_view_nums = mysqli_num_rows($sp_view_query);
	if (!$sp_view_nums) {
		alertback("존재하지 않는 게시물 입니다.");
	} else {
		$sp_rs = mysqli_fetch_array($sp_view_query);
		$content = stripslashes($sp_rs['sp_content']);		// 내용
		$start_date = date("Y-m-d",$sp_rs['sp_sdate']);
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
			f.action = "./process/privacy_process.php";
			f.submit();
		}
	}
 </script>
 
 
 <table width="100%" border="0" cellspacing="1" cellpadding="3" class="td" bgcolor="#999999" style="white-space:nowrap">


  <tr bgcolor="#EFEFEF" height=30> 
	  <td align=center> 
		<table width=500>
			<tr>
				<td align=center><b>개인정보보호정책</b> </td>
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
	<input type = "hidden" name = "sp_num" value = "<?php echo $sp_num;?>">
  <tr bgcolor="#EFEFEF" height=30> 
	  <td align=center> 
		<table width="100%" border="0" cellspacing="1" cellpadding="3" class="td" bgcolor="#999999" style="white-space:nowrap">

			<tr bgcolor="#EFEFEF">
				<td align=center width="10%">
				
				약관 시행일
				
				</td>
				<td align=left >
				
				<INPUT TYPE="text" NAME="start_date" onclick="Calendar_D(document.all.start_date)" value = "<?php echo $start_date;?>"> ( ex) '2012-12-25' )
				
				</td>
			</tr>

			<tr>
				<td align=center bgcolor="white" colspan = "2">
				
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



