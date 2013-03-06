<?php
include "../../_lib/board_lib.php";

$param = "bo_num=$bo_num&set_cs=$set_cs&set_cate=$set_cate&set_goods=$set_goods&sub_menu_num=$sub_menu_num&key=$key&searchword=$encode_searchword&list_notice_chk=$list_notice_chk&guin_state=$guin_state&list_page=$list_page";

?>
<script src="<?php echo $MY_URL;?>_js/jquery.min.js" type="text/javascript"></script>
<script src="<?php echo $MY_URL;?>_js/board.js" type="text/javascript"></script>


<form name  = "chk_form">
<input type  = "hidden" name = "bo_num" value = "<?php echo $bo_num;?>">
<input type  = "hidden" name = "sub_menu_num" value = "<?php echo $sub_menu_num;?>">
</form>

<script type="text/javascript" >
	function chk_notice(mode,num)
	{
		if (mode == "Y") {
			var msg = "체크를 하면 해당 공지가 상단에 노출 됩니다.";
		} else { 
			var msg = "체크를 해지 하면 상단 노출에서 제외 됩니다.";
		}
		if(confirm(msg)){
			var f = document.list_form;
			f.notice_show_num.value = num;
			f.notice_show_mode.value = mode;
			$.ajax({
				type : "POST" 
				, async : true 
				, url : "./process/notice_set_process.php" 
				, dataType : "html" 
				, timeout : 30000 
				, cache : false  
				, data : $("#list_form").serialize() 
				, contentType: "application/x-www-form-urlencoded; charset=UTF-8"
				, error : function(request, status, error) {
					alert("ajax 통신서버에 접속할 수 업습니다.");
				}
				, success : function(response, status, request) {
					var result=response.split('|');	
					if (result[0] != "T") {
						alert()
						alert(result[1]);
					}else{
						alert("리스트 공지 노출이 정상적으로 변경 되었습니다.");
					}
				}
			});
		}
	}
</script>


 <table width="100%" border="0" cellspacing="1" cellpadding="3" class="td" bgcolor="#999999" style="white-space:nowrap">

  <tr bgcolor="#EFEFEF" height=30> 
	  <td align=center> 
		<table width=500>
			<tr>
				<td align=center><b><?=$board_info['bo_name']?></b> 리스트</td>
			</tr>
		</table>

		
	  </td>
	</tr>	
  </table>

 <table width="100%" border="0" cellspacing="1" cellpadding="3" class="td" bgcolor="#999999">
<form name = "list_form" id = "list_form">
	<input type = "hidden" name  = "notice_show_mode">
	<input type = "hidden" name  = "notice_show_num">
</form>
  <tr bgcolor="#EFEFEF"> 
	  <td align=center width=5% style="white-space:nowrap"> 
		No
	  </td>
	  <td align=center width=5% style="white-space:nowrap"> 
		<select name = "list_notice_chk" onchange="list_notice_change(this.value)">
			<option value = "" <?php if (!$list_notice_chk) {?>selected<?php } ?>>전체</option>
			<option value = "N" <?php if ($list_notice_chk == "N") {?>selected<?php } ?>>일반</option>
			<option value = "Y" <?php if ($list_notice_chk == "Y") {?>selected<?php } ?>>공지</option>
		</select>
	  </td>

<?php
	if($bo_state != "A"){
?>

	  <td align=center width=8% style="white-space:nowrap"> 
			<select name ="cg_code_select" onchange="sel_cs('cs',this.value)">

				<option value = "" <?if(!$set_cs){?>selected<?}?>>전체 cs</option>
<?php
	$category_group_qry = mysqli_query($CONN['rosemary'],"select cg_code,cg_name from category_group");
	while ($category_group_rs = mysqli_fetch_array($category_group_qry)) {	
?>
				<option value="<?php echo $category_group_rs['cg_code'];?>" <?if($category_group_rs['cg_code'] == $set_cs){?>selected<?}?>><?php echo $category_group_rs['cg_name'];?></option>
<?}?>
			</select>
	  </td>


	  <td align=center width=8% style="white-space:nowrap"> 
			<select name ="cg_code_select" onchange="sel_cs('cate',this.value)" >

				<option value = "" <?if(!$set_cate){?>selected<?}?>>전체</option>
		<?php
			$category_group_qry = mysqli_query($CONN['rosemary'],"select ca_num,ca_name from category where ca_num in (select ca_num from board_list where bo_num = '$bo_num' group by ca_num)");
			while ($category_group_rs = mysqli_fetch_array($category_group_qry)) {	
		?>
				<option value="<?php echo $category_group_rs['ca_num'];?>" <?if($category_group_rs['ca_num'] == $set_cate){?>selected<?}?>><?php echo $category_group_rs['ca_name'];?></option>
		<?php } ?>
			</select>
	  </td>

<?php if ($bo_state == "CD" || $bo_state == "D") {?>
	  <td align=center width=8% style="white-space:nowrap"> 
			<select name ="cg_code_select" onchange="sel_cs('goods',this.value)" >

				<option value = "" <?if(!$set_goods){?>selected<?}?>>전체</option>
			<?php
				$category_group_qry = mysqli_query($CONN['rosemary'],"select lt_num,lt_name from goods_lecture where lt_num in (select lt_num from board_list where bo_num = '$bo_num' group by lt_num)");
				while ($category_group_rs = mysqli_fetch_array($category_group_qry)) {	
			?>
				<option value="<?php echo $category_group_rs['lt_num'];?>" <?if($category_group_rs['lt_num'] == $set_goods){?>selected<?}?>><?php echo $category_group_rs['lt_name'];?></option>
			<?php } ?>
			</select>
	  </td>
<?php 
		} else if (!empty($bo_list_mal)) { 
		
			$bo_list_mal_array = explode(",",$bo_list_mal);	

				
?>
	  <td align=center width=8% style="white-space:nowrap"> 
		<select name = "guin_state" onchange="list_guin_change(this.value)">
			<option value = "" <?php if (!$guin_state) {?>selected<?php } ?>>전체</option>
			<?
				for($i=0;$i<count($bo_list_mal_array);$i++){
			?>
			<option value = "<?php echo $bo_list_mal_array[$i]?>" <?php if ($guin_state == $bo_list_mal_array[$i]) {?>selected<?php } ?>><?php echo $bo_list_mal_array[$i]?></option>
			<?}?>
		</select>
	  </td>
<?php } ?>
<?php } ?>



	  <td align=center width=30% style="white-space:nowrap"> 
		제목
	  </td>
	  <td align=center width=10% style="white-space:nowrap"> 
		작성자 ID
	  </td>
	  <td align=center width=10% style="white-space:nowrap"> 
		작성자 이름
	  </td>
	  <td align=center width=3% style="white-space:nowrap"> 
	    댓글
	  </td>
	  <td align=center width=3% style="white-space:nowrap"> 
		추천
	  </td>
	  <td align=center width=3% style="white-space:nowrap"> 
		조회
	  </td>
	  <td align=center width=15% style="white-space:nowrap"> 
		등록날짜
	  </td>
	</tr>

<?php include "$DOCUMENT_ROOT/admin/board/notice_list.php";?>
	
<?php



if ($query_number) {

	$number = $query_number - $first;
	
	for ($i=0;$i<count($list_query);$i++) {
		if ($board_info['set_title_length'] < 9) {						// 기본길이가 10 보다 작을땐 기본 길이 30으로 책정 해놈
			$board_info['set_title_length'] = 30;
		}
		$list_num		= $list_query[$i]['list_num'];
		$title			 = mb_strimwidth($list_query[$i]['title'], 0, $board_info['set_title_length'], "...", "UTF-8");	// 제목
		$user_id		= $list_query[$i]['mb_id'];						// 유저아이디	
		$user_name		= $list_query[$i]['mb_name'];						// 유저네임
		$comment_cnt	= $list_query[$i]['comment_cnt'];	// 댓글수
		$list_hit		= $list_query[$i]['hit_cnt'];		// 조회수
		$recom_cnt		= $list_query[$i]['recom_cnt'];		// 추천수
		$user_ip		= $list_query[$i]['user_ip'];						// 유저아이피
		$reg_date		= $list_query[$i]['reg_date'];		// 등록날짜
		$ref			= $list_query[$i]['ref'];							// 답글 깊이
		$del_chk		= $list_query[$i]['del_chk'];						// 삭제 체크 여부 - 해당 부분으 Y면 삭제된 게시물임. 리스트엔 삭제된 게시물이라고 표기됨	
		$notice_chk		= $list_query[$i]['notice_chk'];					// 공지사항 체크
		$secret_chk		= $list_query[$i]['secret_chk'];					// 비밀글 체크	
		$cg_code		= $list_query[$i]['cg_code'];						// cs 코드
		$cg_code_name	= $list_query[$i]['cg_code_name'];					// cs 이름	
		$cg_cate_name	= $list_query[$i]['cg_cate_name'];					// 카테고리 이름
		$goods_name		= $list_query[$i]['goods_name'];					// 상품 이름	
		$notice_show	= $list_query[$i]['notice_show'];					// 공지글을 상단에 노출할건지 (Y,N)
		$list_img		= $list_query[$i]['list_img'];						// 리스트 이미지
		$list_state		= $list_query[$i]['list_state'];						// 리스트 이미지
	

		if ($notice_chk == "Y") {
			$notice_mun = "[공지]";
		} else {
			$notice_mun = "";
		}
		
		if ($secret_chk == "Y") {
			$secret_mun = "[비밀글]";
		} else {
			$secret_mun = "";
		}		

?>

	<tr bgcolor="#FFFFFF"> 
	  <td align=center> 
		<?=$number?>
	  </td>
	  <td align=center width=5% style="white-space:nowrap"> 
<?php if ($notice_chk == "Y") {?>
		<input type  = "checkbox" <?php if ($notice_show == "Y") {?> onclick="chk_notice('N','<?php echo $list_num;?>')"  checked<?php } else { ?> onclick="chk_notice('Y','<?php echo $list_num;?>')" <?php } ?>> 
<?php }  ?>
	  </td>
<?php
	if($bo_state != "A"){
?>
	  <td align=center width=5%> 
		<?=$cg_code_name?>
	  </td>
	  <td align=center width=5%> 
		<?=$cg_cate_name?>
	  </td>
<?php if ($bo_state == "CD" || $bo_state == "D") {?>
	  <td align=center width=5%> 
		<?=$goods_name?>
	  </td>
<?php } else if (!empty($bo_list_mal)) { ?>
	  <td align=center width=8% style="white-space:nowrap"> 
				<?=$list_state?>
	  </td>
<?php } ?>

<?php } ?>
	  <td align=left style="white-space:nowrap"> 
<?php
	 if ($ref > 0 ) {  //공백출력
	   for($k = 0 ; $k < $ref; $k++){
		  echo "&nbsp&nbsp&nbsp";  
	   }
	   echo "ㄴ";
	 }
?>		

		<?if($del_chk == "Y"){?>
			삭제된 게시물 입니다.
		<?}else{?>
			<a href="./index.php?mode=board_view&list_num=<?php echo $list_num;?>&<?php echo $param;?>">
			<?php if(!empty($list_img)){?><img src="<?php echo $MY_URL;?>dir_img/<?=$list_img?>SUM" border=0><?php }?>
			<?php echo $notice_mun;?> <?php echo $secret_mun;?> <?php echo $title;?> <?php if($comment_cnt > 0){?>[<?php echo $comment_cnt;?>]<?}?>
			</a>
		<?}?>
	  </td>
	  <td align=center> 
		<?php echo $user_id;?>
	  </td>
	  <td align=center> 
		<?php echo $user_name;?>
	  </td>
	  <td align=center> 
	    <?php echo $comment_cnt;?>
	  </td>
	  <td align=center> 
		<?php echo $recom_cnt;?>
	  </td>
	  <td align=center> 
		<?php echo $list_hit;?>
	  </td>
	  <td align=center> 
		<?php echo $reg_date;?>
	  </td>
	</tr>

<?php 
		$number--;
	}
?>

	<tr bgcolor="#FFFFFF"> 
	  <td align=center colspan=12>
	  <ul class="bod_pagelist">
<?php 
			echo go_page_list($query_number, $num_per_page, $num_per_block, $list_page, "./index.php?bo_num=$bo_num&sub_menu_num=$sub_menu_num&set_cs=$set_cs&set_cate=$set_cate&list_notice_chk=$list_notice_chk&guin_state=$guin_state&", $key, $searchword,$mode);
?>
	</ul>
	  </td>
	</tr>	
<?php
} else {
?>
	<tr bgcolor="#FFFFFF"> 
	  <td align=center colspan=12>
		등록된 게시물이 없습니다.
	  </td>
	</tr>
<?php } ?>
  </table>
  <br><br>	


<div align=center>
<form name = "search_form">
<input type = "hidden" name = "bo_num" value = "<?=$bo_num?>">
<input type = "hidden" name = "mode" value = "<?=$mode?>">
<select name = "key">
	<option value = "title" <?if($key == "title"){?>selected<?}?>>제목</option>
	<option value = "con" <?if($key == "con"){?>selected<?}?>>내용</option>
	<option value = "tot" <?if($key == "tot"){?>selected<?}?>>제목+내용</option>
	<option value = "mb_id" <?if($key == "mb_id"){?>selected<?}?>>작성자</option>
</select>

<input type = "text" name  = "searchword" value = "<?=$searchword?>"> <input type = "button" value  = "검색" onclick="search_go('index.php')"> 
<?php
	if ($searchword) {
?>
<input type = "button" value = "전체 게시물 보기" onclick="change_list()">
<?php } ?>
</form>
</div>

<br><br>					
<div align=right><input type = "button" value = "게시물 등록" onclick="send_write('board_write','<?php echo $bo_num;?>','<?php echo $page;?>','<?php echo $sub_menu_num;?>')"> <input type = "button" value = "리스트" onclick="send_list('board_set','<?php echo $page;?>','<?php echo $sub_menu_num;?>')"></div>

