<?php
$page = $_GET['page'];				//게시판 페이징 번호
$qna_num = $_GET['qna_num'];		//페이징 번호
$key = $_GET['key'];
$searchword = $_GET['searchword'];

if (!$qna_num) {
	alertback("접근 할 수 없습니다.");
}

$con_query = mysqli_query($CONN['rosemary'],"select 
								a.mb_id,a.title,a.mb_name,a.hit_cnt,a.reg_date,a.file_chk,a.state,a.phone,a.email,a.counsel_time,
								b.contents as con,b.admin_contents as con_dap
						from 
								qna_list a, 
								qna_contents b 
						where 
								a.qna_num = '$qna_num' and 
								a.qna_num = b.qna_num");

$con_nums = mysqli_num_rows($con_query);
if (!$con_nums) alertback("삭제 되었거나 존재하지 않는 게시물 입니다.");

$con_rs = mysqli_fetch_array($con_query);

$title = $con_rs['title'];
$mb_name = $con_rs['mb_name'];
$hit_cnt = $con_rs['hit_cnt'];
$reg_date = date("Y-m-d H:i:s",$con_rs['reg_date']);
$file_chk = $con_rs['file_chk'];
$state = $con_rs['state'];
$phone = $con_rs['phone'];
$email = $con_rs['email'];
$counsel_time_array = explode("<>",$con_rs['counsel_time']);
if ($counsel_time_array[0] == "Y") {
	$counsel_time = "항상";
} else {
	$counsel_time = $counsel_time_array[1]."시 ~".$counsel_time_array[2]."시" ;
}



$con = $con_rs['con'];
$con_dap = $con_rs['con_dap'];
$content = $con_dap;

$member_type_name = Member_Type_Name($mb_type);

?>
<script src="<?php echo $MY_URL;?>_js/jquery.min.js" type="text/javascript"></script>
<script>
	function set_download(tmp,save_name) 
	{
		var save_names = escape(save_name);
		document.location.href="<?=$board_process_url?>/file_download.php?file_name="+tmp+"&save_name="+save_names;
	}
	function send_list(mode) 
	{
		var searchword = encodeURIComponent("<?=$searchword?>");
		document.location.href = "./index.php?mode="+mode+"&page="+<?=$page?>+"&key=<?=$key?>&searchword="+searchword;
	}
	function send_modi() 
	{
		var f = document.view_form;
		f.mode.value = "qna_write";
		f.write_mode.value = "modi";
		f.action = "./index.php";
		f.submit();
	}



	function send_del() 
	{
		if (confirm("해당 게시물을 삭제 하시겠습니까?")) {
			var f = document.view_form;
			f.write_mode.value = "del";
			f.method = "post";
			f.action = "<?=$qna_process_url?>/qna_del_process.php";
			f.submit();
		}
	}
	function down_stop() 
	{
		alert("<?=$member_type_name?>는 첨부파일 다운로드 권한이 없습니다.");
	}
	function send_dap(){
		var f = document.writeform; 
		var check_memo = f.content.value = SubmitHTML();
		//alert(check_memo);
		if (!check_memo) {
			alert("답변을 작성해 주세요.");
		} else {
			f.write_mode.value = "write";
			f.action = "<?=$qna_process_url?>/qna_dap_process.php";
			f.submit();
		}
	}
</script>

 <table width="100%" border="0" cellspacing="1" cellpadding="3" class="td" bgcolor="#999999">
<form name = "view_form" id = "view_form">
<input type  = "hidden" name = "page" value = "<?php echo $page;?>">
<input type  = "hidden" name = "qna_num" value = "<?php echo $qna_num;?>">
<input type  = "hidden" name = "mode" >
<input type  = "hidden" name = "write_mode" >
<input type  = "hidden" name = "key" value = "<?php echo $_GET['key'];?>" >
<input type  = "hidden" name = "searchword" value = "<?php echo $_GET['searchword'];?>" >
</form>
  <tr bgcolor="#EFEFEF" height=30> 
	  <td align=center> 
		QNA
	  </td>
	</tr>	
  </table>
<br><br>
 <table width="100%" border="0" cellspacing="1" cellpadding="3" class="td" bgcolor="#999999">

	<tr bgcolor="#EFEFEF"> 
	  <td align=center colspan=7 height=30> 
			<b> <?php echo $title;?></b>
	  </td>
	</tr>

	<tr bgcolor="#EFEFEF"> 
	  <td align=center width=30%> 
		&nbsp;
	  </td>
	  <td align=center width = 60> 
			연락처
	  </td>
	  <td align=center bgcolor="#FFFFFF"> 
			<?php echo $phone;?>
	  </td>
	  <td align=center width = 60> 
			이메일
	  </td>
	  <td align=center bgcolor="#FFFFFF" width = 60> 
			<?php echo $email;?>
	  </td>
	  <td align=center width = 100> 
			상담가능시간
	  </td>
	  <td align=center bgcolor="#FFFFFF"> 
			<?php echo $counsel_time;?>
	  </td>

	</tr>
	<tr bgcolor="#EFEFEF"> 
	  <td align=center width=30%> 
		&nbsp;
	  </td>
	  <td align=center width = 60> 
			글쓴이
	  </td>
	  <td align=center bgcolor="#FFFFFF"> 
			<?php echo $mb_name;?>
	  </td>
	  <td align=center width = 60> 
			조회수
	  </td>
	  <td align=center bgcolor="#FFFFFF" width = 60> 
			<?php echo $hit_cnt;?>
	  </td>
	  <td align=center width = 60> 
			등록일
	  </td>
	  <td align=center bgcolor="#FFFFFF"> 
			<?php echo $reg_date;?>
	  </td>

	</tr>
	<tr bgcolor="#FFFFFF"> 
	
	  <td  colspan=7> 
<?php echo $con;?>
	  </td>
	</tr>
</form>
<?
	if ($file_chk == "Y") {
		$file_query = mysqli_query($CONN['rosemary'],"select * from qna_file where qna_num = '$qna_num'");
		$file_nums = mysqli_num_rows($file_query);
		if ($file_nums) {
?>

	<tr bgcolor="#EFEFEF" height=40> 
	  <td align=center width=20%> 
	첨부파일
	  </td>
	  <td align=left colspan=6 bgcolor="#FFFFFF">
<?
		while($file_rs = mysqli_fetch_array($file_query)) {
		$file_name = $file_rs['file_name'];
		$file_size = viewSizeToByte($file_rs['file_size']);
		$file_name_tmp = $file_rs['file_tmp_name'];
?>

&nbsp;<a href="javascript:set_download('<?php echo $file_name_tmp;?>','<?php echo $file_name;?>')"><?php echo $file_name;?> (<?php echo $file_size;?>)</a><br>
<?
		}
?>
	  </td>
	</tr>
<?}}?>

 </table>

<br>
<br>


 <table width="100%" border="0" cellspacing="1" cellpadding="3" class="td" bgcolor="#999999">
  <tr bgcolor="#EFEFEF" height=30> 
	  <td align=center> 
		관리자 답변
	  </td>
	</tr>	
  </table>
 <table width="100%" border="0" cellspacing="1" cellpadding="3" class="td" bgcolor="#999999">





	<tr bgcolor="#EFEFEF"> 
	  <td align=center width=20%> 
		답  변
	  </td>
	  <td align=left bgcolor="#FFFFFF"> 
<?php
if ($state == "Y") {
?>
<?php echo $con_dap;?>		
<?php } else { ?>
		&nbsp;<b>아직 미답변 상태 입니다.</b>
<?php } ?>
	  </td>
	</tr>



<?php if ($set_chk['set_reply'] == "Y") {?>


<form name="writeform" method="post"  enctype='multipart/form-data' id = "writeform">
<input type = "hidden" name = "write_mode">
<input type = "hidden" name = "qna_num" value = "<?php echo $qna_num;?>">
<input type = "hidden" name = "page" value = "<?php echo $page;?>">
<input type = "hidden" name = "key" value = "<?php echo $key;?>">
<input type = "hidden" name = "searchword" value = "<?php echo $searchword;?>">
	<tr bgcolor="#EFEFEF"> 
	  <td align=center width=20%> 
<?php if($state == "Y") {?>답변수정<?php } else {?> 답변등록<?php }?>
	  </td>
	  <td align=left bgcolor="white"> 
		<?=myEditor2(1,'../../gmEditor','writeform','content','100%','200');?>
	  </td>
	</tr>
</form>
	<tr>
		<td colspan=2 align=right><input type = "button" value = "답변 달기" onclick="send_dap()"></td>
	</tr>

<?php } ?>

</table>

<br>
<br>
<div align=right>


<?php if ($set_chk['set_del']) {?><input type = "button" value = "삭제" onclick="send_del()"><?php } ?>
<?php if ($set_chk['set_modi']) {?><input type = "button" value = "수정" onclick="send_modi()"><?php } ?>
<input type = "button" value = "리스트" onclick="send_list('qna_list')">
</div>	
<br>
<br>





