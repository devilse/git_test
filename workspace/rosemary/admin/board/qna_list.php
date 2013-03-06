<?php
if (!empty($_GET['key'])) {
	$key = $_GET['key'];
}
if (!empty($_GET['searchword'])) {
	$searchword = trim($_GET['searchword']);
}
if (!empty($_GET['set_gubun'])) {
	$set_gubun = trim($_GET['set_gubun']);
}
if (!$key && $searchword) {
	$key = "title";
}

$search_where = "";
if ($key && $searchword) {
	$searchword_chk = 1;
	if (preg_match("/[!#$%^&*()?{}.;:<>+=\/]/",$searchword)) {
		$searchword_chk = 0; 
	}
	if ($searchword_chk != 1) {
		alertback("특수문자가 포함되어 검색할 수 없습니다.");
	}
	if ($key == "tot") {
		$search_where = "and a.title like '%$searchword%' or b.contents like '%$searchword%'";
	} else if ($key == "title") {
		$search_where = "and $key like '%$searchword%'";
	} else if ($key == "con") {
		$search_where = "and b.contents like '%$searchword%'";
	} else if ($key == "mb_id") {
		$search_where = "and $key like '%$searchword%'";
	}

	$encode_searchword = urlencode($searchword);
}

$where = "";
if ($set_gubun) {
	$where .= "and gubun = '$set_gubun'";
}

if ($key == "tot" || $key == "con") {
	$qna_list_query = sql_query($CONN['rosemary'],"select count(*) as cnt from qna_list a, qna_contents b where 1 = 1 $where $search_where  and a.qna_num = b.qna_num group by a.qna_num");
} else {
	$qna_list_query = sql_query($CONN['rosemary'],"select count(*) as cnt from qna_list where 1 = 1 $where $search_where");
}

$qna_list_num = mysqli_result($qna_list_query,0,0);
$query_number	=	$qna_list_num;
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
	function change_list(val)
	{
		if (!val) {
		var f = document.search_form;
			f.searchword.value = "";
			f.action = "./index.php";
			f.submit();
		}

	}
	String.prototype.trim=function()
	{
	  var str=this.replace(/(\s+$)/g,"");
	  return str.replace(/(^\s*)/g,"");
	}

	function change_list_gubun(val)
	{
		var f = document.search_form;
			f.set_gubun.value = val;
			f.action = "./index.php";
			f.submit();
		
	}
</script>





 <table width="100%" border="0" cellspacing="1" cellpadding="3" class="td" bgcolor="#999999">

  <tr bgcolor="#EFEFEF" height=30> 
	  <td align=center> 
		<b>Q&A</b> 리스트
	  </td>
	</tr>	
  </table>




 <table width="100%" border="0" cellspacing="1" cellpadding="3" class="td" bgcolor="#999999">

  <tr bgcolor="#EFEFEF"> 
	  <td align=center width=5%> 
		No
	  </td>
	  <td align=center width=10%> 
<select name="sel_gubun" onchange="change_list_gubun(this.value)">
	<option value="" <?php if(!$set_gubun){?>selected<?php }?>>전체</option>
	<option value="1" <?php if($set_gubun == "1"){?>selected<?php }?>>개인정보관련</option>
	<option value="2" <?php if($set_gubun == "2"){?>selected<?php }?>>주문/결재관련</option>
	<option value="3" <?php if($set_gubun == "3"){?>selected<?php }?>>배송관련</option>
	<option value="4" <?php if($set_gubun == "4"){?>selected<?php }?>>사이트 불편사항</option>
	<option value="5" <?php if($set_gubun == "5"){?>selected<?php }?>>반품/환불관련</option>
	<option value="6" <?php if($set_gubun == "6"){?>selected<?php }?>>기타문의</option>
</select>
	  </td>
	  <td align=center width=35%> 
		제목
	  </td>
	  <td align=center width=10%> 
		작성자
	  </td>
	  <td align=center width=20%> 
		작성일
	  </td>
	  <td align=center width=10%> 
		조회수
	  </td>
	  <td align=center width=10%> 
		답변
	  </td>
	</tr>
<?php
if ($query_number) {
	if ($key == "tot" || $key == "con") {
		$list_query = mysqli_query($CONN['rosemary'],"select a.* from qna_list a, qna_contents b where 1=1 $where $search_where and a.qna_num = b.qna_num group by qna_num order by qna_num desc $limit");
	} else {
		$list_query = mysqli_query($CONN['rosemary'],"select * from qna_list where 1=1 $where $search_where order by qna_num desc $limit");
	}
	$number = $query_number - $first;
	while($qna_list_rs = mysqli_fetch_array($list_query)) {
		$title = $qna_list_rs['title'];
		$user_name = $qna_list_rs['mb_name'];
		$reg_date = date("Y-m-d H:i:s",$qna_list_rs['reg_date']);
		$hit = number_format($qna_list_rs['hit_cnt']);
		if ($qna_list_rs['state'] == "Y") {
			$chk_state = "답변완료";
		}else {
			$chk_state = "대기";
		}
		$gubun = Qna_Gubun($qna_list_rs['gubun']);
?>
	<tr bgcolor="#FFFFFF"> 
	  <td align=center> 
		<?php echo number_format($number)?>
	  </td>
	  <td align=center width=10%> 
		<?php echo $gubun;?>
	  </td>
	  <td align=left> 
		<a href="./index.php?mode=qna_view&qna_num=<?php echo $qna_list_rs['qna_num']?>&page=<?php echo $page?>&key=<?php echo $key?>&searchword=<?php echo $encode_searchword?>"><?php echo $title?></a>
	  </td>
	  <td align=center> 
		<?php echo $user_name?>
	  </td>
	  <td align=center> 
		<?php echo $reg_date?>
	  </td>
	  <td align=center> 
		<?php echo $hit?>
	  </td>
	  <td align=center> 
		<?php echo $chk_state?>
	  </td>
	</tr>
<?php
		$number--;
	}
?>

	<tr bgcolor="#FFFFFF"> 
	  <td align=center colspan=10>
	  <ul class="bod_pagelist">
		<?php echo go_page($query_number, $num_per_page, $num_per_block, $page, "./index.php?", $key, $searchword,$mode)?>
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

<?php if ($set_chk['set_write'] == "Y") {?>

<div align=right>
	<input type = "button" value = "게시물 등록" onclick="send_write('qna_write')"> 
</div>
<?php } ?>

<br><br>


 <div align=center>
<form name = "search_form">
<input type = "hidden" name = "bo_num" value = "<?php echo $bo_num?>">
<input type = "hidden" name = "mode" value = "<?php echo $mode?>">
<input type = "text" name = "set_gubun" value = "<?php echo $set_gubun?>">
<select name = "key"">
<!--	<option value = "" <?if(!$key){?>selected<?}?>>전체</option>-->
	<option value = "title" <?if($key == "title"){?>selected<?}?>>제목</option>
	<option value = "con" <?if($key == "con"){?>selected<?}?>>내용</option>
	<option value = "tot" <?if($key == "tot"){?>selected<?}?>>제목+내용</option>
	<option value = "mb_name" <?if($key == "mb_name"){?>selected<?}?>>작성자</option>
</select>

<input type = "text" name  = "searchword" value = "<?php echo $searchword?>"> <input type = "button" value  = "검색" onclick="search_go()"> 
<?php
	if ($searchword) {
?>
<input type = "button" value = "전체 게시물 보기" onclick="change_list()">
<?php } ?>
</form>
</div>


<br><br>




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

