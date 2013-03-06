<?php
if (!empty($_GET['key'])) {
	$key = $_GET['key'];
}
if (!empty($_GET['searchword'])) {
	$searchword = trim($_GET['searchword']);
}
if (!$key && $searchword) {
	$key = "title";
}
if (!empty($_GET['sel_mal'])) {
	$sel_mal = $_GET['sel_mal'];
}

$where = "";
$search_where = "";

if ($sel_mal) {
	$where .= " and mal = '$sel_mal'"; 
}


if ($key && $searchword) {
	$searchword_chk = 1;
	if (preg_match("/[!#$%^&*()?{}.;:<>+=\/]/",$searchword)) {
		$searchword_chk = 0; 
	}
	if ($searchword_chk != 1) {
		alertback("특수문자가 포함되어 검색할 수 없습니다.");
	}
	if ($key == "tot") {
		$search_where = "and title like '%$searchword%' or contents like '%$searchword%'";
	} else if ($key == "title") {
		$search_where = "and $key like '%$searchword%'";
	} else if ($key == "con") {
		$search_where = "and contents like '%$searchword%'";
	} else if ($key == "mb_id") {
		$search_where = "and $key like '%$searchword%'";
	}

	$encode_searchword = urlencode($searchword);
}



	$faq_query = sql_query($CONN['rosemary'],"select count(*) as cnt from faq where 1=1 $search_where");


$faq_num = mysqli_result($faq_query,0,0);
$query_number	=	$faq_num;
?>
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

	String.prototype.trim=function()
	{
	  var str=this.replace(/(\s+$)/g,"");
	  return str.replace(/(^\s*)/g,"");
	}


	function send_view(val){
		var submenu = document.getElementById(val);
		var f = document.sel_form;
		if(submenu.style.display == "none"){
			submenu.style.display="block"
			if(f.y_sel.value == ""){
				f.y_sel.value = val;
			}else{
				var y_menu=document.getElementById('y_sel');
				
				var submenu2 = document.getElementById(y_menu.value);
				submenu2.style.display="none";
				f.y_sel.value = val;
			}
		}else{
			submenu.style.display="none";
		}		
	}
	function send_modi(mode,num){
		if(mode == "del"){
			if(confirm("해당 게시물을 삭제 하시겠습니까?")){
				document.location.href = "./process/faq_del_process.php?faq_num="+num;
			}
		}else{
			document.location.href = "./index.php?mode=faq_write&write_mode=modi&faq_num="+num;	
		}
	}
	function change_mal(val){
		document.location.href="./index.php?mode=faq&sel_mal="+val;
	}
	function change_list(val)
	{
		if (!val) {
		var f = document.search_form;
			f.searchword.value = "";
			f.action = "./index.php?mode=faq";
			f.submit();
		}
	}

</script>





 <table width="100%" border="0" cellspacing="1" cellpadding="3" class="td" bgcolor="#999999">

  <tr bgcolor="#EFEFEF" height=30> 
	  <td align=center> 
		<b>FAQ</b>
	  </td>
	</tr>	
  </table>




 <table width="100%" border="0" cellspacing="1" cellpadding="3" class="td" bgcolor="#999999">
<form name = "sel_form">
<input type = "hidden" name = "y_sel" id = "y_sel">
</form>
  <tr bgcolor="#EFEFEF"> 
	  <td align=center width=8%> 
			<select name = "sel_mal" onchange="change_mal(this.value)">
				<option value = "1" <?php if($sel_mal == "1"){?>selected<?php }?>>동영상</option>
				<option value = "2" <?php if($sel_mal == "2"){?>selected<?php }?>>사이트</option>
				<option value = "3" <?php if($sel_mal == "3"){?>selected<?php }?>>결제</option>
				<option value = "4" <?php if($sel_mal == "4"){?>selected<?php }?>>회원정보</option>
				<option value = "5" <?php if($sel_mal == "5"){?>selected<?php }?>>기타</option>
			</select>
	  </td>
	  <td align=center > 
		No
	  </td>
	  <td align=center width=10%> 
		<b>등록날짜</b>
	  </td>
	</tr>
<?php
if ($query_number) {
	$list_query = mysqli_query($CONN['rosemary'],"select * from faq where 1=1 $where $search_where order by faq_num desc $limit");
	while($faq_rs = mysqli_fetch_array($list_query)) {
		$faq_num = $faq_rs['faq_num'];
		$title = $faq_rs['title'];
		$con = $faq_rs['contents'];
		$reg_date = date("Y-m-d h:i:s",$faq_rs['reg_date']);
		$mal = Mal_Chk($faq_rs['mal']);
?>
	<tr bgcolor="#FFFFFF"> 
	  <td align=center > 
		 <?php echo $mal;?>
	  </td>
	  <td align=left> 
			&nbsp;<a href = "javascript:send_view('<?php echo $faq_num;?>')"> <?php echo $title;?></a> <input type = "button" value = "수정" onclick="send_modi('modi','<?php echo $faq_num;?>')"> <input type = "button" value = "삭제" onclick="send_modi('del','<?php echo $faq_num;?>')">
	  </td>
	  <td align=center> 
		<b><?php echo $reg_date;?></b>
	  </td>
	</tr>
	<tr bgcolor="gray"  id = "<?php echo $faq_num;?>" style="display:none"> 
	  <td align=left colspan=2> 
			<?php echo $con;?>
	  </td>

	</tr>

<?php
	}
?>

	<tr bgcolor="#FFFFFF"> 
	  <td align=center colspan=10>
	  <ul class="bod_pagelist">
		<?php echo go_page($query_number, $num_per_page, $num_per_block, $page, "./index.php?sel_mal=$sel_mal&", $key, $searchword,$mode);?>
	  </td>
	  </ul>
	</tr>
<?php } else { ?>
	<tr bgcolor="#FFFFFF"> 
	  <td align=center colspan=6>
		등록된 게시물이 없습니다.
	  </td>
	</tr>
<?php }?>
	
  </table>

<br><br>					

<div align=right>
	<input type = "button" value = "게시물 등록" onclick="send_write('faq_write')"> 
</div>


<br><br>


 <div align=center>
<form name = "search_form">
<input type = "hidden" name = "bo_num" value = "<?=$bo_num?>">
<input type = "hidden" name = "mode" value = "<?=$mode?>">
<select name = "key"">
<!--	<option value = "" <?if(!$key){?>selected<?}?>>전체</option>-->
	<option value = "title" <?if($key == "title"){?>selected<?}?>>제목</option>
	<option value = "con" <?if($key == "con"){?>selected<?}?>>내용</option>
	<option value = "tot" <?if($key == "tot"){?>selected<?}?>>제목+내용</option>
	<option value = "mb_name" <?if($key == "mb_name"){?>selected<?}?>>작성자</option>
</select>

<input type = "text" name  = "searchword" value = "<?=$searchword?>"> <input type = "button" value  = "검색" onclick="search_go()"> 
<?php
	if ($searchword) {
?>
<input type = "button" value = "전체 게시물 보기" onclick="change_list()">
<?php } ?>
</form>
</div>


<br><br>


