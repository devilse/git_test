<?php
$bo_num		= $_GET['bo_num'];	//게시판 pk 번호
$page		= $_GET['page'];		//페이징 번호

if (!$bo_num) alertback("접근 할 수 없습니다.");

	$board_query = sql_query($CONN['rosemary'],"select 
										a.*,
										b.mt_code as mt_code,
										b.set_access as user_set_access,
										b.set_write as user_set_write,
										b.set_view as user_set_view,
										b.set_modi as user_set_modi,
										b.set_del as user_set_del,
										b.set_comment as user_set_comment,
										b.set_reply as user_set_reply,
										b.set_recom as user_set_recom,
										b.set_secret as user_set_secret,
										b.set_file as user_set_file,
										b.set_scrap as user_set_scrap,
										b.set_down as user_set_down,
										b.set_secret_view as user_set_secret_view,
										b.set_admin as user_set_admin,
										
										c.mt_name 
								from 
										board a, board_user_set b, member_type c 
								where 
										a.bo_num = $bo_num and  a.bo_num = b.bo_num and b.mt_code = c.mt_code ");



	$board_num = @mysqli_num_rows($board_query);
	if (!$board_num) alterback("존재하지 않는 게시판 입니다.");

	
	$user_set_query  = 	$board_query;

	$board_rs = mysqli_fetch_array($board_query);
	
	$board_name = stripslashes($board_rs['bo_name']);							// 게시판 이름
	$board_skin = $board_rs['bo_skin'];											// 게시판 스킨	
	$set_show = number_format($board_rs['set_show']);							// 게시판 리스트 수
	$set_title_length = number_format($board_rs['set_title_length']);			// 게시판 리스트 제목 길이 

	$set_comment = $board_rs['set_comment'];									// 게시판 댓글 기능 사용여부
	$set_reply = $board_rs['set_reply'];										// 게시판 답글 기능 사용여부
	$set_secret = $board_rs['set_secret'];										// 게시판 비밀글 기능 사용여부
	$set_file = $board_rs['set_file'];											// 게시판 파일첨부 기능 사용여부
	$set_recom = $board_rs['set_recom'];										// 게시판 추천기능 사용여부
	$set_scrap = $board_rs['set_scrap'];										// 게시판 스크랩기능 사용여부
	$set_img = $board_rs['set_img'];											// 게시판 리스트 이미지 기능 사용여부
	$list_mal = stripslashes($board_rs['list_mal']);							// 게시판 이름


	$set_file_num = $board_rs['set_file_num'];									// 게시판 파일첨부 최대 개수	
	$set_file_max = $board_rs['set_file_max'];									// 게시판 파일첨부 최대 용량 설정(개당 용량임)
	$head_title = stripslashes($board_rs['head_title']);						// 게시판설명
	$end_title = stripslashes($board_rs['end_title']);							// 꼬리글
	$bo_list_state = $board_rs['bo_list_state'];								// 리스트 유형
	if ($board_rs['bo_state'] == "A") {											// 게시판 유형 - 해당 부분의 값은 입력 후 변경하지 말아야 한다.
		$bo_state = "전체 게시판";
	} else if ($board_rs['bo_state'] == "N") {
		$bo_state = "공지사항 게시판";
	} else if ($board_rs['bo_state'] == "C") {
		$bo_state = "카테고리 게시판";
	} else if ($board_rs['bo_state'] == "D") {
		$bo_state = "상품 게시판";
	} else if ($board_rs['bo_state'] == "CD") {
		$bo_state = "카테고리/상품 게시판";
	} else {
		$bo_state = "과목 게시판";
	}
	$set_use = $board_rs['set_use'];											// 해당 게시판 사용여부
	$mt_code = $board_rs['mt_code'];											// 회원유형
	$user_set_access = $board_rs['user_set_access'];							// 접근권한
	$user_set_write = $board_rs['user_set_write'];								// 쓰기권한
	$user_set_view = $board_rs['user_set_view'];								// 보기권한
	$user_set_modi = $board_rs['user_set_modi'];								// 수정권한
	$user_set_del = $board_rs['user_set_del'];									// 삭제권한	
	$user_set_comment = $board_rs['user_set_comment'];							// 댓글권한
	$user_set_reply = $board_rs['user_set_reply'];								// 답글권한
	$user_set_secret = $board_rs['user_set_secret'];							// 비밀글권한
	$user_set_file = $board_rs['user_set_file'];								// 첨부파일권한
	$user_set_recom = $board_rs['user_set_recom'];								// 추천권한
	$user_set_scrap = $board_rs['user_set_scrap'];								// 스크랩권한
	$user_set_secret_view = $board_rs['user_set_secret_view'];					// 스크랩권한
	$user_set_down = $board_rs['user_set_down'];							    // 첨부파일 다운로드 권한
	$user_set_admin = $board_rs['user_set_admin'];							    // 조회수,날짜 변경권한
	$mt_name = $board_rs['mt_name'];	

?>

<script type="text/javascript">
	function change_img(val) {
		var img = document.getElementById('skin_sample_img');
		img.src = "http://localhost/_template/skin/board/"+val+"/sample.jpg";
	}
	function send() {
			var f = document.set_form;
			if (f.bo_name.value == "") {
				alert("게시판명을 입력해주세요.");
				return;
			}else{
				
				var radio_obj = f.bo_list_state;
				for(i=0; i < radio_obj.length; i++) {
					if (radio_obj[i].checked == true) {
						radio_obj_value = radio_obj[i].value;
					}
				}					
				f.set_list_state.value = radio_obj_value;
				f.target="join_target";
				f.action="./process/board_set_process.php";	
				f.submit();
			}
	}

	function fnNumberCheck(obj) 
	{
		if (/[^0-9,]/g.test(obj.value))  
		{
			var text1 = obj.value.substring(0, obj.value.length - 1);
			alert("숫자만 입력 가능 합니다.");
			obj.focus();
			obj.value = text1;
			return false;
		}
	}
	function send_list(mode,page) {
		document.location.href="./index.php?mode="+mode+"&page="+page;
	}
</script>


 <table width="100%" border="0" cellspacing="1" cellpadding="3" class="td" bgcolor="#999999">
 <form name = "set_form" method="post">
 <input type = "hidden" name = "set_list_state" value="<?php echo $bo_list_state;?>">
 <input type = "hidden" name = "bo_num" value="<?php echo $bo_num;?>">
  <tr bgcolor="#EFEFEF" height=30> 
	  <td align=center> 
		게시판 세부 관리
	  </td>
	</tr>	
  </table>


 <table width="100%" border="0" cellspacing="1" cellpadding="3" class="td" bgcolor="#999999">

	<tr> 
	  <td bgcolor="#EFEFEF" align=center height=25 width=20%> 
		게시판명 
	  </td>
	  <td bgcolor="white" align=left colspan=5> 
		<input type = "text" size=60 name="bo_name" value="<?php echo $board_name;?>"> <input type = "radio" name = "set_use" value="Y"<?php if ($set_use == "Y") { ?>checked<?php } ?>> 게시판 사용 <input type = "radio" name = "set_use" value="N" <?php if ($set_use != "Y") { ?>checked<?php } ?>> 게시판 사용하지 않음
	  </td>
	</tr>
	<tr> 
	  <td bgcolor="#EFEFEF" align=center height=25 width=20%> 
		게시판 CS유형
	  </td>
	  <td bgcolor="white" align=left colspan=5> 
		해당 게시판의 유형은 <b><?php echo $bo_state;?></b> 입니다. 이 속성은 변경할 수 없습니다. 
	  </td>
	</tr>
	<tr> 
	  <td bgcolor="#EFEFEF" align=center height=25 width=20%> 
		게시판 리스트유형
	  </td>
	  <td bgcolor="white" align=left colspan=5> 
			<input type = "radio" name= "bo_list_state" value = "B" <?php if($bo_list_state == "B"){?>checked<?php }?>>기본 리스트 <input type = "radio" name= "bo_list_state" value = "G" <?php if($bo_list_state == "G"){?>checked<?php }?>>갤러리 리스트
	  </td>
	</tr>
	<tr> 
	  <td bgcolor="#EFEFEF" align=center height=25 width=20%> 
		리스트 노출 수
	  </td>
	  <td bgcolor="white" align=left width=30%> 
			<input type = "text" size=2 name="set_show" value="<?php echo $set_show;?>" OnKeyUp="fnNumberCheck(this);"> 개 (0 이면 기본 10개)
	  </td>

		<td bgcolor="#EFEFEF" align=center width=20%> 
			리스트 길이 설정
		</td>

		<td bgcolor="white" align=left colspan=3> 
		<input type = "text" size=2 name="set_title_length" value = "<?php echo $set_title_length;?>" OnKeyUp="fnNumberCheck(this);"> 자 (0 이면 제한 없음)
		</td>
	</tr>


	<tr> 
	  <td bgcolor="#EFEFEF" align=center height=25 width=20%> 
		게시판 스킨
	  </td>
	  <td bgcolor="white" align=left valign=top colspan=5> 
		<table>
			<tr>
				<td><img src="http://localhost/_template/skin/board/<?php echo $board_skin;?>/sample.jpg" width=100 height=100 id = "skin_sample_img"> </td>
				<td>
					<select name = "board_skin" onchange="change_img(this.value)">
<?php
$dir = "C:/rosemary/trunk/src/rosemary/_template/skin/board/";
	if (is_dir($dir)) { // 해당 디렉토리 열기
		if ($dirop=opendir($dir)) { // 디렉토리 열기
			while (($filerd = readdir($dirop)) != false) { //디렉토리 읽어오기
				if ($filerd != "." and $filerd != "..") {
					$skin_dir = $filerd;
?>
					<option value = "<?php echo $skin_dir?>" <?php if ($skin_dir == $board_skin) { ?>selected<?php } ?>>&nbsp;&nbsp;&nbsp;<?php echo $skin_dir;?>&nbsp;&nbsp;&nbsp;    </option>
<?php
				}
			}
		}
	} else {
?>
					<option>등록된 스킨 디렉토리가 없습니다.</option>	
<?php
	}
closedir($dirop);
?>

					</select>
					
				</td>
			</tr>

		</table>
	  </td>
	</tr>

	<tr> 
	  <td bgcolor="#EFEFEF" align=center height=25 width=20%> 
		리스트 머리말
	  </td>
	  <td bgcolor="white" align=left colspan=5 > 
		<input type="text" name="list_mal" value="<?php echo $list_mal;?>" size="100"> (* 말머리를 여러개 등록할 경우 구분자는 , 로 구분 합니다.)
	  </td>
	</tr>


	<tr> 
	  <td bgcolor="#EFEFEF" align=center height=25 width=20%> 
		게시판설명
	  </td>
	  <td bgcolor="white" align=left colspan=5 > 
		<textarea name = "head_title" cols=100><?php echo $head_title;?></textarea>
	  </td>
	</tr>
	<tr> 
	  <td bgcolor="#EFEFEF" align=center height=25 width=20%> 
		꼬리말
	  </td>
	  <td bgcolor="white" align=left colspan=5> 
		<textarea name = "end_title" cols=100><?php echo $end_title;?></textarea>
	  </td>
	</tr>

	<tr> 
	  <td bgcolor="#EFEFEF" align=center height=25 width=20%> 
		게시판 기능 설정
	  </td>
	  <td bgcolor="white" align=left colspan=5> 
		<input type = "checkbox" name="set_comment" value="Y" <?php if ($set_comment == "Y") {?>checked<?php } ?>>댓글 사용
		<input type = "checkbox" name="set_reply" value="Y" <?php if ($set_reply == "Y") {?>checked<?php } ?>>답글 사용
		<input type = "checkbox" name="set_secret" value="Y" <?php if ($set_secret == "Y") {?>checked<?php } ?>>비밀글 사용
		<input type = "checkbox" name="set_secret" value="Y" <?php if ($set_secret == "Y") {?>checked<?php } ?>>비밀글 사용

		<input type = "checkbox" name="set_recom" value="Y" <?php if ($set_recom == "Y") {?>checked<?php } ?>>추천 사용
		<input type = "checkbox" name="set_scrap" value="Y" <?php if ($set_scrap == "Y") {?>checked<?php } ?>>스크랩 사용
		<input type = "checkbox" name="set_img" value="Y" <?php if ($set_img == "Y") {?>checked<?php } ?>>이미지 첨부
	  </td>
	</tr>


	<tr> 
	  <td bgcolor="#EFEFEF" align=center height=25 width=20%> 
		게시판 자료실 설정
	  </td>
	  <td bgcolor="white" align=left width=20%> 
			<input type = "checkbox" name="set_file" value="Y" <?php if ($set_file == "Y") { ?>checked<?php } ?>> 파일 첨부 사용
	  </td>



		<td bgcolor="#EFEFEF" align=center width=20%> 
			  첨부파일 용량 설정
		</td>

		<td bgcolor="white" align=left> 
			<select name = "set_file_max">
				<option value = "1" <?php if ($set_file_max == 1) { ?>selected<?php } ?>>1</option>
				<option value = "3" <?php if ($set_file_max == 3) { ?>selected<?php } ?>>3</option>
				<option value = "5" <?php if ($set_file_max == 5) { ?>selected<?php } ?>>5</option>
				<option value = "10" <?php if ($set_file_max == 10) { ?>selected<?php } ?>>10</option>
			</select> MB
		</td>


	</tr>
  </table>

<br><br>


 <table width="100%" border="0" cellspacing="1" cellpadding="3" class="td" bgcolor="#999999">
  <tr bgcolor="#EFEFEF" height=30> 
	  <td align=center> 
		게시판 사용 권한 설정
	  </td>
	</tr>	
  </table>
 <table width="100%" border="0" cellspacing="1" cellpadding="3" class="td" bgcolor="#999999">
	<tr> 
	  <td bgcolor="#EFEFEF" align=center height=25 width=20%> 
		<?php echo $mt_name?>
	  </td>
	  <td bgcolor="white" align=left colspan=5> 
		<input type = "hidden" name = "<?php echo $mt_code;?>_set_mt_code" value = "<?php echo $mt_code?>">
		<input type = "checkbox" name="<?php echo $mt_code;?>_access" value="Y" <?php if ($user_set_access == "Y") { ?>checked<?php } ?>>접근
		<input type = "checkbox" name="<?php echo $mt_code;?>_write" value="Y" <?php if ($user_set_write == "Y") { ?>checked<?php } ?>>쓰기
		<input type = "checkbox" name="<?php echo $mt_code;?>_view" value="Y" <?php if ($user_set_view == "Y") { ?>checked<?php } ?>>보기
		<input type = "checkbox" name="<?php echo $mt_code;?>_modi" value="Y" <?php if ($user_set_modi == "Y") { ?>checked<?php } ?>>수정
		<input type = "checkbox" name="<?php echo $mt_code;?>_del" value="Y" <?php if ($user_set_del == "Y") { ?>checked<?php } ?>>삭제
		<input type = "checkbox" name="<?php echo $mt_code;?>_comment" value="Y" <?php if ($user_set_comment == "Y") {?>checked<?php } ?>>댓글작성
		<input type = "checkbox" name="<?php echo $mt_code;?>_reply" value="Y" <?php if ($user_set_reply == "Y") { ?>checked<?php } ?>>답글작성
		<input type = "checkbox" name="<?php echo $mt_code;?>_secret" value="Y" <?php if ($user_set_secret == "Y") { ?>checked<?php } ?>>비밀글작성
		<input type = "checkbox" name="<?php echo $mt_code;?>_secret_view" value="Y" <?php if ($user_set_secret_view == "Y") { ?>checked<?php } ?>>비밀글보기  <br>
		<input type = "checkbox" name="<?php echo $mt_code;?>_file" value="Y" <?php if ($user_set_file == "Y") { ?>checked<?php } ?>>첨부파일 업로드
		<input type = "checkbox" name="<?php echo $mt_code;?>_down" value="Y" <?php if ($user_set_down == "Y") { ?>checked<?php } ?>>첨부파일 다운
		<input type = "checkbox" name="<?php echo $mt_code;?>_scrap" value="Y" <?php if ($user_set_scrap == "Y") { ?>checked<?php } ?>>스크랩
		<input type = "checkbox" name="<?php echo $mt_code;?>_recom" value="Y" <?php if ($user_set_recom == "Y") { ?>checked<?php } ?>>추천
		<input type = "checkbox" name="<?php echo $mt_code;?>_admin" value="Y" <?php if ($user_set_admin == "Y") { ?>checked<?php } ?>>조회,날짜 수정
		
	  </td>
	</tr>
<?
	while($user_set_rs = @mysqli_fetch_array($user_set_query)) {
		
		$mt_code = $user_set_rs['mt_code'];					// 회원유형

		$user_set_access = $user_set_rs['user_set_access'];				// 접근권한
		$user_set_write = $user_set_rs['user_set_write'];				// 쓰기권한
		$user_set_view = $user_set_rs['user_set_view'];					// 보기권한
		$user_set_modi = $user_set_rs['user_set_modi'];					// 수정권한
		$user_set_del = $user_set_rs['user_set_del'];					// 삭제권한	
		$user_set_comment = $user_set_rs['user_set_comment'];			// 댓글권한
		$user_set_reply = $user_set_rs['user_set_reply'];				// 답글권한
		$user_set_secret = $user_set_rs['user_set_secret'];				// 비밀글권한
		$user_set_file = $user_set_rs['user_set_file'];					// 첨부파일권한
		$user_set_recom = $user_set_rs['user_set_recom'];					// 추천
		$user_set_scrap = $user_set_rs['user_set_scrap'];					// 스크랩
		$user_set_down = $user_set_rs['user_set_down'];					// 첨부파일다운
		$user_set_secret_view = $user_set_rs['user_set_secret_view'];					// 첨부파일다운
		$mt_name = $user_set_rs['mt_name'];					// 회원유형 이름
?>


	<tr> 
	  <td bgcolor="#EFEFEF" align=center height=25 width=20%> 
		<?php echo $mt_name?>
	  </td>
	  <td bgcolor="white" align=left colspan=5> 
		<input type = "hidden" name = "<?php echo $mt_code;?>_set_mt_code" value = "<?php echo $mt_code?>">
		<input type = "checkbox" name="<?php echo $mt_code;?>_access" value="Y" <?php if ($user_set_access == "Y") { ?>checked<?php } ?>>접근
		<input type = "checkbox" name="<?php echo $mt_code;?>_write" value="Y" <?php if ($user_set_write == "Y") { ?>checked<?php } ?>>쓰기
		<input type = "checkbox" name="<?php echo $mt_code;?>_view" value="Y" <?php if ($user_set_view == "Y") { ?>checked<?php } ?>>보기
		<input type = "checkbox" name="<?php echo $mt_code;?>_modi" value="Y" <?php if ($user_set_modi == "Y") { ?>checked<?php } ?>>수정
		<input type = "checkbox" name="<?php echo $mt_code;?>_del" value="Y" <?php if ($user_set_del == "Y") { ?>checked<?php } ?>>삭제
		<input type = "checkbox" name="<?php echo $mt_code;?>_comment" value="Y" <?php if ($user_set_comment == "Y") {?>checked<?php } ?>>댓글작성
		<input type = "checkbox" name="<?php echo $mt_code;?>_reply" value="Y" <?php if ($user_set_reply == "Y") { ?>checked<?php } ?>>답글작성
		<input type = "checkbox" name="<?php echo $mt_code;?>_secret" value="Y" <?php if ($user_set_secret == "Y") { ?>checked<?php } ?>>비밀글작성
		<input type = "checkbox" name="<?php echo $mt_code;?>_secret_view" value="Y" <?php if ($user_set_secret_view == "Y") { ?>checked<?php } ?>>비밀글보기  <br>
		<input type = "checkbox" name="<?php echo $mt_code;?>_file" value="Y" <?php if ($user_set_file == "Y") { ?>checked<?php } ?>>첨부파일 업로드
		<input type = "checkbox" name="<?php echo $mt_code;?>_down" value="Y" <?php if ($user_set_down == "Y") { ?>checked<?php } ?>>첨부파일 다운
		<input type = "checkbox" name="<?php echo $mt_code;?>_scrap" value="Y" <?php if ($user_set_scrap == "Y") { ?>checked<?php } ?>>스크랩
		<input type = "checkbox" name="<?php echo $mt_code;?>_recom" value="Y" <?php if ($user_set_recom == "Y") { ?>checked<?php } ?>>추천
		<input type = "checkbox" name="<?php echo $mt_code;?>_admin" value="Y" <?php if ($user_set_admin == "Y") { ?>checked<?php } ?>>조회,날짜 수정
	  </td>
	</tr>
<?}?>
</form>
  </table>
<br>
<div align=right><input type = "button" value = "게시판 설정 수정" onclick="send()"> <input type = "button" value = "리스트" onclick="history.back();"></div>



<iframe width="0" height="0" frameborder="0" hspace="0" vspace="0" id="join_target" name="join_target"></iframe>