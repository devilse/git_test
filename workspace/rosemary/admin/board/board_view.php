<?php

include "../../_lib/board_lib.php";

//echo $DOCUMENT_ROOT;
//echo $board_skin;





$param = "bo_num=$bo_num&set_cs=$set_cs&set_cate=$set_cate&set_goods=$set_goods&sub_menu_num=$sub_menu_num&key=$key&searchword=$encode_searchword&list_notice_chk=$list_notice_chk&guin_state=$guin_state&list_page=$list_page";

?>
<script src="<?php echo $MY_URL;?>_js/board.js" type="text/javascript"></script>
<script src="<?php echo $MY_URL;?>_js/jquery.min.js" type="text/javascript"></script>
<script type="text/javascript">
	function send_list(mode) 
	{
		document.location.href = "./index.php?mode="+mode+"&<?php echo $param;?>";
	}
	function send_modi() 
	{
		var f = document.view_form;
		f.mode.value = "board_write";
		f.write_mode.value = "modi";
		f.action = "./index.php";
		f.submit();
	}
	function send_reply() 
	{
		var f = document.view_form;
		f.mode.value = "board_write";
		f.write_mode.value = "reply";
		f.action = "./index.php";
		f.submit();
	}

	function send_comment_go(del_num) 
	{
		var f = document.comment_form;
		if (del_num) {
			f.del_num.value = del_num;
		}
		if (!f.del_num.value) {
			if (!f.comment.value) {
				alert("댓글을 작성해 주세요.");
				return;
			}
		}

		$.ajax({
			type : "POST" 
			, async : true 
			, url : "<?php echo $board_process_url;?>/comment_process.php" 
			, dataType : "html" 
			, timeout : 30000 
			, cache : false  
			, data : $("#comment_form").serialize() 
			, contentType: "application/x-www-form-urlencoded; charset=UTF-8"
			, error : function(request, status, error) {
				alert("ajax 통신서버에 접속할 수 업습니다.");
			}
			, success : function(response, status, request) {
				var result=response.split('|');	
				if (result[0] != "T") {
					alert(result[1]);
				}else{
					f.del_num.value = "";
					f.comment.value = "";
					var div_layer=document.getElementById('opn_list_layer');
					div_layer.innerHTML="<table width=100% border=0 cellpadding=0 cellspacing=0>"+result[1]+"</table>";						
				}
			}
		});
	}

	function send_option(val) 
	{
		if (val == "scrap") {
			var msg = "해당 게시물을 스크랩 하시겠습니까?";
			var send_url = "<?php echo $board_process_url;?>/scrap_process.php";
		}else{
			var msg = "해당 게시물에 추천을 하시겠습니까?";
			var send_url = "<?php echo $board_process_url;?>/recom_process.php";
		}


		if (confirm(msg)) {
			$.ajax({
				type : "POST" 
				, async : true 
				, url : send_url
				, dataType : "html" 
				, timeout : 30000 
				, cache : false  
				, data : $("#view_form").serialize() 
			
				, contentType: "application/x-www-form-urlencoded; charset=UTF-8"

				, error : function(request, status, error) {
						 alert("ajax 통신서버에 접속할 수 업습니다.");
				}
				, success : function(response, status, request) {
					var result=response.split('|');	
					if (result[0] != "T") {
						alert(result[1]);
					}else{
						alert(result[1]);					
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
	}

	function send_del() 
	{
		if (confirm("해당 게시물을 삭제 하시겠습니까?")) {
			var f = document.view_form;
			f.write_mode.value = "del";
			f.method = "post";
			f.action = "<?php echo $board_process_url;?>/board_del_process.php";
			f.submit();
		}
	}
	function down_stop() 
	{
		alert("<?php echo $member_type_name;?>는 첨부파일 다운로드 권한이 없습니다.");
	}
</script>

 <table width="100%" border="0" cellspacing="1" cellpadding="3" class="td" bgcolor="#999999">
<form name = "view_form" id = "view_form">
	<input type  = "hidden" name = "now_page" value = "admin" >
	<input type  = "hidden" name = "bo_num" value = "<?php echo $bo_num;?>">
	<input type  = "hidden" name = "list_page" value = "<?php echo $list_page;?>">
	<input type  = "hidden" name = "list_num" value = "<?php echo $list_num;?>">
	<input type  = "hidden" name = "mode" >
	<input type  = "hidden" name = "write_mode" >
	<input type  = "hidden" name = "key" value = "<?php echo $_GET['key'];?>" >
	<input type  = "hidden" name = "searchword" value = "<?php echo $_GET['searchword'];?>" >
	<input type  = "hidden" name = "sub_menu_num" value = "<?php echo $sub_menu_num;?>" >
	<input type  = "hidden" name = "set_cs" value = "<?php echo $set_cs;?>" >
	<input type  = "hidden" name = "set_cate" value = "<?php echo $set_cate;?>" >
	<input type  = "hidden" name = "set_goods" value = "<?php echo $set_goods;?>" >
	<input type  = "hidden" name = "list_notice_chk" value = "<?php echo $list_notice_chk;?>" >
	<input type  = "hidden" name = "guin_state" value = "<?php echo $guin_state;?>" >
	<input type  = "hidden" name = "sub_menu_num" value = "<?php echo $sub_menu_num;?>" >






</form>
  <tr bgcolor="#EFEFEF" height=30> 
	  <td align=center> 
		<b><?php echo $board_info['bo_name']?></b> 리스트
	  </td>
	</tr>	
  </table>
<br><br>
 <table width="100%" border="0" cellspacing="1" cellpadding="3" class="td" bgcolor="#999999">

	<tr bgcolor="#EFEFEF"> 
	  <td align=center colspan=7 height=30> 
			<b><?php echo $notice_mun;?> <?php echo $title;?></b>
	  </td>
	</tr>

	<tr bgcolor="#EFEFEF"> 
	  <td align=center width=30%> 
		<?php echo $cg_code_name;?> / <?php echo $cg_cate_name;?> / <?php echo $goods_name;?>

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

	<tr bgcolor="#EFEFEF" height=40> 
	  <td align=center width=20%> 
	첨부파일
	  </td>
	  <td align=left colspan=6 bgcolor="#FFFFFF">

<?php
if (!empty($file_rs)) {
	for ($i=0;$i<count($file_rs);$i++) {
		$file_name_tmp = $file_rs[$i]['file_tmp_name'];
		$file_name = $file_rs[$i]['file_name'];
		$file_size = viewSizeToByte($file_rs[$i]['file_size']);
?>


&nbsp;<?if ($set_use_chk['set_down'] == "Y") {?><a href="javascript:set_download('<?php echo $file_name_tmp;?>','<?php echo $file_name;?>')"><?}else{?><a href="javascript:down_stop()"><?}?><?php echo $file_name;?> (<?php echo $file_size;?>)</a><br>


<?php
	}
}
?>

	  </td>
	</tr>


 </table>
<br>
<br>
<div align=right>


<?php if ($set_use_chk['set_del'] == "Y" ||  $in_board_chk == "Y") {?><input type = "button" value = "삭제" onclick="send_del()"><?php } ?>
<?php if ($set_use_chk['set_modi'] == "Y" || $in_board_chk == "Y") {?><input type = "button" value = "수정" onclick="send_modi()"><?php } ?>
<?php if ($board_info['set_reply'] == "Y") {?><?php if ($set_use_chk['set_reply'] == "Y") {?><input type = "button" value = "답글" onclick="send_reply()"><?php }?><?php } ?>
<?php if ($board_info['set_scrap'] == "Y") {?><?php if ($set_use_chk['set_scrap'] == "Y") {?><input type = "button" value = "스크랩" onclick="send_option('scrap')"><?php } ?><?php } ?>
<?php if ($board_info['set_recom'] == "Y") {?><?php if ($set_use_chk['set_recom'] == "Y") {?><input type = "button" value = "추천" onclick="send_option('recom')"><?php } ?><?php } ?>

<input type = "button" value = "리스트" onclick="send_list('board_list')">
</div>	
<br>
<br>


<!--
 <table width="100%" border="0" cellspacing="1" cellpadding="3" class="td" bgcolor="#999999">
 <form name = "comment_form" id = "comment_form">
 	<input type  = "hidden" name = "list_num" value = "<?php echo $list_num?>">
	<input type  = "hidden" name = "del_num" >
	<input type  = "hidden" name = "bo_num" value = "<?php echo $bo_num?>">
<?php if ($set_use_chk['set_comment'] == "Y") {?>
  <tr bgcolor="#EFEFEF" height=30> 
	  <td align=center  width=80%> 
			<input type = "text" name = "comment" value ="" size=100>
	  </td>
	  <td align=center>
			<input type = "button"  value ="댓글 등록" onclick="send_comment_go()">
	  </td>
 </tr>	
<?php } ?>
 </form>
  <tr bgcolor="#EFEFEF" height=30 > 
	  <td align=center colspan=2 > 
<div id = "opn_list_layer" class="comment">


<?php
if ($comment_rs != false) {
	for ($i=0;$i<count($comment_rs);$i++) {
		$com_name = $comment_rs[$i]['mb_name'];
		$comment = $comment_rs[$i]['comment'];
		$com_date = $comment_rs[$i]['reg_date'];

?>
<ul class="com_list">
							<li><p><?php echo $com_name;?><span class="ft_style">　l　<?php echo $com_date;?></span> <img class="btn_sdel" src="<?=$MY_URL?>/_template/skin/board/<?php echo $board_skin;?>/images/board/btn_sdel.gif" alt="삭제" align="absmiddle" /></p>
							<?php echo $comment;?>
							</li>
</ul>
<?php 
	}
}else{
?>
				<tr bgcolor="#FFFFFF">
					<td width=20% align=center colspan=3>등록된 댓글이 없습니다.</td>
				</tr>
<?php
	}
?>

</div>

-->

<?php 
if ($set_use_chk['set_comment'] == "Y") {
?>
<form name = "comment_form" id = "comment_form">
 	<input type  = "hidden" name = "list_num" value = "<?php echo $list_num?>">
	<input type  = "hidden" name = "del_num" >
	<input type  = "hidden" name = "bo_num" value = "<?php echo $bo_num?>">	
<div id = "opn_list_layer">

					<div class="comment">
						<p class="com_title">댓글 <?=$comment_cnt?></p>
						<ul class="com_list">
<?php
if ($comment_rs != false) {
	for ($i=0;$i<count($comment_rs);$i++) {
		$com_name = $comment_rs[$i]['mb_name'];
		$comment = $comment_rs[$i]['comment'];
		$com_date = $comment_rs[$i]['reg_date'];

?>
							<li><p><?php echo $com_name;?><span class="ft_style">　l　<?php echo $com_date;?></span> <img class="btn_sdel" src="<?=$MY_URL?>/_template/skin/board/<?php echo $board_skin;?>/images/board/btn_sdel.gif" alt="삭제" align="absmiddle" /></p>
							<?php echo $comment;?>
							</li>
<?
	}	
					}
?>
	
	
						</ul>
				
						<div><textarea style="width:87%; height:50px;" name="comment" rows="3" cols="20"></textarea><span class="blind">내용</span>
						<input type="button" name="bod_btn_wirte" class="bod_btn_wirte" value="등록" onclick="send_comment_go()" /></div>

					</div>

</div>
</form>
<?}?>

	  </td>

 </tr>	

  </table>

<br><br>


