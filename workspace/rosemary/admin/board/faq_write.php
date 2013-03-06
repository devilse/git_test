<?php
$faq_num	= $_GET['faq_num'];	//해당 값이 있다면 수정이거나 답글  모드이다.
$page		= $_GET['page'];
$key		= $_GET['key'];
$searchword = $_GET['searchword'];

if (!empty($faq_num)) {
	$write_mode = $_GET['write_mode'];
	if(!$write_mode) alertback("접근 할 수 없습니다.");	// 해당 변수의 값에 따라 수정모드일지 답글 모드일지 정해준다.
	if($write_mode == "modi" ){			//수정시
			
		$con_query = mysqli_query($CONN['rosemary'],"select * from faq where faq_num = '$faq_num'");

		$con_nums = mysqli_num_rows($con_query);
		if (!$con_nums) alertback("삭제 되었거나 존재하지 않는 게시물 입니다.");

		$con_rs = mysqli_fetch_array($con_query);

		$title		= $con_rs['title'];
		$mal	= $con_rs['mal'];
		$content	= $con_rs['contents'];		// 내용


	}
}

?>

<script src="<?=$MY_URL?>_js/jquery.min.js" type="text/javascript"></script>
<script src="<?=$MY_URL?>_js/jquery.uploadify.min.js" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" href="<?=$MY_URL?>_js/uploadify.css">
<script type = "text/javascript">
	function send_write_go()
	{

		var f = document.writeform;
		var check_memo = f.content.value = SubmitHTML();
		var file_cnt = f.chk_file.value;
		if(!f.title.value){
			alert("제목을 입력해 주세요.");
			return;
		}else if(!check_memo){
			alert("내용을 입력해 주세요.");
			return;
		}
		$.ajax({
			type : "POST" 
			, async : true 
			, url : "<?=$MY_URL?>/admin/board/process/faq_write_process.php" 
			, dataType : "html" 
			, timeout : 30000 
			, cache : false  
			, data : $("#writeform").serialize() 
		
			, contentType: "application/x-www-form-urlencoded; charset=UTF-8"

			, error : function(request, status, error) {

			 alert("ajax 통신서버에 접속할 수 업습니다.");
			}
			, success : function(response, status, request) {
			 //통신 성공시 처리
				var result=response.split('|');	
				if(result[0] != "T"){
				//	alert(response);
					alert(result[1]);
				}else{
						document.location.href="./index.php?mode=faq&page=<?php echo $page;?>&key=<?php echo $key;?>&searchword=<?php echo $searchword;?>";

				}
			}
			, beforeSend: function() {
			 //통신을 시작할때 처리
			 $('#ajax_indicator').show().fadeIn('fast'); 
			}
			, complete: function(request) {
			 //통신이 완료된 후 처리
			 $('#ajax_indicator').fadeOut();
			}
		});

	}

	function send_list_go()
	{
		document.location.href="./index.php?mode=qna_list";
	}
</script>






 <table width="100%" border="0" cellspacing="1" cellpadding="3" class="td" bgcolor="#999999">
  <tr bgcolor="#EFEFEF" height=30> 
	  <td align=center> 
<?php if ($write_mode == "modi") { ?>
	 게시물 수정하기
<?php } else {?>
	 Q&A 등록하기 
<?php }?>
	  </td>
	</tr>	
  </table>


<br><br>
 <table width="100%" border="0" cellspacing="1" cellpadding="3" class="td" bgcolor="#999999">
<form name="writeform" method="post"  enctype='multipart/form-data' id = "writeform">
<input type = "hidden" name = "faq_num" value = "<?php echo $faq_num;?>">
<input type = "hidden" name = "chk_file" value = "0">
<input type = "hidden" name = "write_mode" value = "<?php echo $write_mode;?>">
<input type = "hidden" name = "del_file_num">
<input type = "hidden" name = "page" value = "<?php echo $page;?>">


	<tr bgcolor="#EFEFEF"> 
	  <td align=center width=20%> 
		말머리
	  </td>
	  <td align=left> 
			<select name = "mal">
				<option value = "1" <?php if($mal == "1"){?>selected<?php }?>>동영상</option>
				<option value = "2" <?php if($mal == "2"){?>selected<?php }?>>사이트</option>
				<option value = "3" <?php if($mal == "3"){?>selected<?php }?>>결제</option>
				<option value = "4" <?php if($mal == "4"){?>selected<?php }?>>회원정보</option>
				<option value = "5" <?php if($mal == "5"){?>selected<?php }?>>기타</option>
			</select>
	  </td>
	</tr>


	</tr>


	<tr bgcolor="#EFEFEF"> 
	  <td align=center width=20%> 
		제  목
	  </td>
	  <td align=left> 
		<input type = "text" name = "title"  size = 70 value="<?php echo $title;?>">
	  </td>
	</tr>

	<tr bgcolor="#EFEFEF"> 
	  <td align=center width=20%> 
		내  용
	  </td>
	  <td align=left bgcolor="white"> 
		<?=myEditor(1,'../../gmEditor','writeform','content','100%','400');?>
	  </td>
	</tr>



	</form>
 </table>
		
<br><br>			
<div align=right>

<?php if ($write_mode == "modi") {?>
<input type = "button" value = "수정하기" onclick="send_write_go()"> 
<?php } else { ?>
<input type = "button" value = "등록하기" onclick="send_write_go()"> 
<?php } ?>


<input type = "button" value = "리스트가기" onclick="send_list_go()">
</div>