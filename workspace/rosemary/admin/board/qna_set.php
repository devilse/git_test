<script src="<?php echo $MY_URL;?>_js/jquery.min.js" type="text/javascript"></script>
<script type = "text/javascript">
	function send_write(mode)
	{
		document.location.href="./index.php?mode="+mode;
	}
	function qna_set_modi()
	{
		$.ajax({
			type : "POST" 
			, async : true 
			, url : "<?php echo $MY_URL;?>/admin/board/process/qna_set_process.php" 
			, dataType : "html" 
			, timeout : 30000 
			, cache : false  
			, data : $("#set_form").serialize() 
			, contentType: "application/x-www-form-urlencoded; charset=UTF-8"
			, error : function(request, status, error) {
				 alert("ajax 통신서버에 접속할 수 업습니다.");
			}
			, success : function(response, status, request) {
			 //통신 성공시 처리
				var result=response.split('|');	
				if (result[0] != "T") {
					alert(response);
					alert(result[1]);
				} else {
					alert("기능이 수정 되었습니다.");
				}
			}
			, beforeSend: function() {
				 $('#ajax_indicator').show().fadeIn('fast'); 
			}
			, complete: function(request) {
				 $('#ajax_indicator').fadeOut();
			}
		});
	}
</script>


 <table width="100%" border="0" cellspacing="1" cellpadding="3" class="td" bgcolor="#999999">
 <form name  = "set_form" id = "set_form">
	 <tr bgcolor="#EFEFEF" height=30> 
	  <td align=center colspan=2> 
		Q&A 관리 기능 셋팅
	  </td>
	</tr>	
<?php
	$set_query = mysqli_query($CONN['rosemary'],"select a.*,b.mt_name from qna_user_set a, member_type b where a.mt_code = b.mt_code ");
	$set_nums = mysqli_num_rows($set_query);
	if ($set_nums) {
		while ($set_rs = mysqli_fetch_array($set_query)) {
			$mt_code = $set_rs[mt_code];
			$qna_set_access = $set_rs[set_access];
			$qna_set_write = $set_rs[set_write];
			$qna_set_view = $set_rs[set_view];
			$qna_set_modi = $set_rs[set_modi];
			$qna_set_del = $set_rs[set_del];
			$qna_set_reply = $set_rs[set_reply];

?>

	 <tr bgcolor="#FFFFFF" height=30> 
	  <td align=center width=20% bgcolor="#EFEFEF"> 
		<?php echo $set_rs['mt_name'];?>
	  </td>
	  <td align=left> 
		<input type = "hidden" name = "<?php echo $mt_code;?>_set_mt_code" value = "<?php echo $mt_code?>">
		<input type = "checkbox" name="<?php echo $mt_code;?>_access" value="Y" <?php if ($qna_set_access == "Y") { ?>checked<?php } ?>>접근
		<input type = "checkbox" name="<?php echo $mt_code;?>_write" value="Y" <?php if ($qna_set_write == "Y") { ?>checked<?php } ?>>쓰기
		<input type = "checkbox" name="<?php echo $mt_code;?>_view" value="Y" <?php if ($qna_set_view == "Y") { ?>checked<?php } ?>>보기
		<input type = "checkbox" name="<?php echo $mt_code;?>_modi" value="Y" <?php if ($qna_set_modi == "Y") { ?>checked<?php } ?>>수정
		<input type = "checkbox" name="<?php echo $mt_code;?>_del" value="Y" <?php if ($qna_set_del == "Y") { ?>checked<?php } ?>>삭제
		<input type = "checkbox" name="<?php echo $mt_code;?>_reply" value="Y" <?php if ($qna_set_reply == "Y") { ?>checked<?php } ?>>답변
	  </td>
	</tr>
	<tr bgcolor="#EFEFEF" height=30> 
	  <td align=right colspan=2> 
		<input type  = "button" value = "권한 수정" onclick="qna_set_modi()">
	  </td>
	</tr>
<?php 
		}
	} 
?>
</form>
 </table>

