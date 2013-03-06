<?php
$qna_num	= $_GET['qna_num'];	//해당 값이 있다면 수정이거나 답글  모드이다.
$page		= $_GET['page'];
$key		= $_GET['key'];
$searchword = $_GET['searchword'];

if (!empty($qna_num)) {
	$write_mode = $_GET['write_mode'];
	if(!$write_mode) alertback("접근 할 수 없습니다.");	// 해당 변수의 값에 따라 수정모드일지 답글 모드일지 정해준다.
	if($write_mode == "modi" ){			//수정시
			
		$con_query = mysqli_query($CONN['rosemary'],"select 
										a.mb_id,a.title,a.mb_name,a.hit_cnt,a.reg_date,a.file_chk,a.state,a.phone,a.email,a.counsel_time,a.gubun,
										b.contents as con
								from 
										qna_list a, 
										qna_contents b 
								where 
										a.qna_num = '$qna_num' and 
										a.qna_num = b.qna_num");

		$con_nums = mysqli_num_rows($con_query);
		if (!$con_nums) alertback("삭제 되었거나 존재하지 않는 게시물 입니다.");

		$con_rs = mysqli_fetch_array($con_query);

		$title		= $con_rs['title'];
		$file_chk	= $con_rs['file_chk'];
		$state		= $con_rs['state'];
		$content	= $con_rs['con'];		// 내용
		$phone_array = explode("-",$con_rs['phone']);
		$email_array = explode("@",$con_rs['email']);
		$counsel_array = explode("<>",$con_rs['counsel_time']);
		$gubun = $con_rs['gubun']; 


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
			, url : "<?=$qna_process_url?>/qna_write_process.php" 
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
					alert(response);
					alert(result[1]);
				}else{
					if(parseInt(file_cnt) > 0){
						 $("#file_upload").uploadify("settings", 'formData2', result[1],'list_num');
						 $('#file_upload').uploadify('upload', '*');
					}else{
						//alert(response);
			
						if(f.write_mode.value == "modi"){
							document.location.href="./index.php?mode=qna_view&page=<?php echo $page;?>&qna_num=<?php echo $qna_num;?>&key=<?php echo $key;?>&searchword=<?php echo $searchword;?>";
						}else{
							document.location.href="./index.php?mode=qna_list&page=<?php echo $page;?>&key=<?php echo $key;?>&searchword=<?php echo $searchword;?>";
						}
			
						
					}
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


	function set_file_del(num)
	{
		if(confirm("첨부된 파일을 삭제 하시겠습니까?")){
			var del_file = document.getElementById("del_file_"+num);
			var f = document.writeform;
			if(f.del_file_num.value){
				f.del_file_num.value = f.del_file_num.value + "<>" + num;
			}else{
				f.del_file_num.value =  num;
			}
				del_file.style.display="none";
		}
	}


		$(function() {
			$('#file_upload').uploadify({
			
				'formData'     : {
					'list_num' : '',
					'file_cnt' : '',
					'file_state' : ''
				},

				'buttonText' : '파일 선택',
				//'debug'    : true,
				'auto'     : false,
				'fileSizeLimit' : '5MB',

				'swf'      : '<?=$qna_process_url?>/uploadify.swf',
				'uploader' : '<?=$qna_process_url?>/uploadify.php',
					/*
				'onSelectError' : function(file) {
					alert('[ ' + file.name + ' ] 이 파일을 선택할 수 없습니다.');
				},
				*/
	

				'onUploadStart' : function(file) {
				   
					var f = document.writeform;
					f.chk_file.value = parseInt(f.chk_file.value) - 1;
				    $("#file_upload").uploadify("settings", 'formData2', f.chk_file.value ,'file_cnt');
					$("#file_upload").uploadify("settings", 'formData2', "qna" ,'file_state');
						
				},


				'onUploadSuccess' : function(file, data, response) {
					var result=data.split('|');	
					if(result[0] != "T"){
						alert(result[1]);
						return;
					}else{
						if(parseInt(result[1]) < 1){
							var f = document.writeform;
						if(f.write_mode.value == "modi"){
							document.location.href="./index.php?mode=qna_view&page=<?php echo $page;?>&qna_num=<?php echo $qna_num;?>&key=<?php echo $key;?>&searchword=<?php echo $searchword;?>";
						}else{
							document.location.href="./index.php?mode=qna_list&page=<?php echo $page;?>";
						}
							return;
						}
					}
				}
			}
		);
	});


	function sel_email(val)
	{
		var f = document.writeform;
		if(val == "" || val == "self_in"){
			f.email2.value = "";
			f.email2.readOnly=false;
			f.email2.focus();
		}else{
			f.email2.value = val;
			f.email2.readOnly=true;
		}
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
<input type = "hidden" name = "qna_num" value = "<?php echo $qna_num;?>">
<input type = "hidden" name = "chk_file" value = "0">
<input type = "hidden" name = "write_mode" value = "<?php echo $write_mode;?>">
<input type = "hidden" name = "del_file_num">
<input type = "hidden" name = "page" value = "<?php echo $page;?>">


	<tr bgcolor="#EFEFEF"> 
	  <td align=center width=20%> 
		구분
	  </td>
	  <td align=left> 
			<select name = "gubun">
					<option value = "1" <?php if($gubun == "1"){?>selected<?php }?>>개인정보관련</option>
					<option value = "2" <?php if($gubun == "2"){?>selected<?php }?>>주문/결재관련</option>
					<option value = "3" <?php if($gubun == "3"){?>selected<?php }?>>배송관련</option>
					<option value = "4" <?php if($gubun == "4"){?>selected<?php }?>>사이트 불편사항</option>
					<option value = "5" <?php if($gubun == "5"){?>selected<?php }?>>반품/환불관련</option>
					<option value = "6" <?php if($gubun == "6"){?>selected<?php }?>>기타문의</option>
			</select>
	  </td>
	</tr>

	<tr bgcolor="#EFEFEF"> 
	  <td align=center width=20%> 
		이름
	  </td>
	  <td align=left> 
			<input type = "text" name = "name" value = "<?php echo $mb_name;?>">
	  </td>
	</tr>

	<tr bgcolor="#EFEFEF"> 
	  <td align=center width=20%> 
		연락처
	  </td>
	  <td align=left> 
			<input type = "text" name = "phone1" size=5 maxlength=4 value="<?php echo $phone_array[0];?>"> - <input type = "text" name = "phone2" size=5 maxlength=4 value="<?php echo $phone_array[1];?>"> - <input type = "text" name = "phone3" size=5 maxlength=4 value="<?php echo $phone_array[2];?>"> 
	  </td>
	</tr>

	<tr bgcolor="#EFEFEF"> 
	  <td align=center width=20%> 
		이메일
	  </td>
	  <td align=left> 

	  <input type = "text" name = "email1" size=10 value = "<?php echo $email_array[0];?>"> @<input type = "text" name = "email2" size=10 value = "<?php echo $email_array[1];?>"> 
								<select name = "email3" onchange="sel_email(this.value)">
									<option value="">선택</option>
									<option value="naver.com">naver.com</option>
									<option value="hanmail.net">hanmail.net</option>
									<option value="nate.com">nate.com</option>
									<option value="hotmail.com">hotmail.com</option>
									<option value="yahoo.com">yahoo.com</option>
									<option value="gmail.com">gmail.com</option>
									<option value="self_in">직접입력</option>
								</select>
	  </td>
	</tr>


	<tr bgcolor="#EFEFEF"> 
	  <td align=center width=20%> 
		상담가능시간
	  </td>
	  <td align=left> 
			<select name = "counsel_date1">
		<?php for ($i=0;$i<25;$i++) {
				if ($i < 10) {
					$i = "0".$i;
				}
		?>
				<option value = "<?php echo $i;?>" <?php if($counsel_array[1] == $i){?>selected<?}?>><?php echo $i;?></option>
		<?php } ?>
			</select> 시 ~
			<select name = "counsel_date2">
		<?php for ($k=0;$k<25;$k++) {
				if ($k < 10) {
					$k = "0".$k;
				}
		?>
				<option value = "<?php echo $k;?>" <?php if($counsel_array[2] == $k){?>selected<?}?>><?php echo $k;?></option>
		<?php } ?>
			</select> 시  <input type ="checkbox" name = "counsel_always" value="Y" <?php if($counsel_array[0] == "Y"){?>checked<?}?>>언제든가능
	  </td>
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
		<?=myEditor2(1,'../../gmEditor','writeform','content','100%','400');?>
	  </td>
	</tr>


	<tr bgcolor="#EFEFEF"> 
	  <td align=center width=20%> 
	첨부파일
	  </td>
	  <td align=left >
								<div id="queue"></div>
								<input id="file_upload" name="file_upload" type="file" >
							
	  </td>
	</tr>

<?php
if ($file_chk == "Y") {
	$file_query = @mysqli_query($CONN['rosemary'],"select * from qna_file where qna_num = '$qna_num'");
	$file_nums = @mysqli_num_rows($file_query);
	if ($file_nums) {
?>

	<tr bgcolor="#EFEFEF" height=40> 
	  <td align=center width=20%> 
	기존 첨부파일
	  </td>
	  <td align=left colspan=6 bgcolor="#FFFFFF">
	  	<table>
<?php
		while ($file_rs = mysqli_fetch_array($file_query)) {
		$file_name = $file_rs[file_name];
		$file_size = viewSizeToByte($file_rs[file_size]);
		$file_name_tmp = $file_rs[file_tmp_name];
		$file_num = $file_rs[file_num];
?>
		<tr id = "del_file_<?php echo $file_num;?>">
			<td><?php echo $file_name;?> (<?php echo $file_size;?>) <a href="javascript:set_file_del('<?php echo $file_num;?>')"> 첨부파일 삭제 </a></td>
		</tr>
<?php
		}
?>
		</table>
	  </td>
	</tr>
<?}}?>


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