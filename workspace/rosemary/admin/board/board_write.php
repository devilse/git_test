<?php
if (!empty($list_num)) {
	$write_mode = $_GET['write_mode'];
	if (!$write_mode) {
		alertback("접근 할 수 없습니다.");	// 해당 변수의 값에 따라 수정모드일지 답글 모드일지 정해준다.
	}
	if ($write_mode == "modi" ) {			//수정시

			include "../../_lib/board_lib.php";	

	} else if ($write_mode == "reply"){	// 답글달때

			include "../../_lib/board_lib.php";	

	}
} else {
	$bo_num = $_GET['bo_num'];	//게시판 pk 번호
	$set_cs = $_GET['set_cs'];	//선택한 cs
	$set_cate = $_GET['set_cate'];	//선택한 카테고리
	$set_goods = $_GET['set_goods'];	//선택한 카테고리
	$sub_menu_num = $_GET['sub_menu_num'];
	$key = $_GET['key'];
	$searchword = trim($_GET['searchword']);
	$list_notice_chk = $_GET['list_notice_chk'];
	$guin_state = $_GET['guin_state'];
	$list_page = $_GET['list_page'];
	$list_num = $_GET['list_num'];	//해당 값이 있다면 수정이거나 답글  모드이다.


	if (!$bo_num) {
		alertback("접근 할 수 없습니다.");
	}

	$set_use_chk = Set_Chk("set_file,set_secret");
	$board_info = Board_Info($bo_num,"bo_name,set_file,set_secret,set_file_max,bo_state,set_img,list_mal");	//게시판 세부 정보 가져오기 (가져올 게시판 번호,가져올 필드 = 다중 필드 선택시 bo_name,bo_title 이런씩)
	$board_name = $board_info['bo_name']; 
	$bo_state = $board_info['bo_state'];
	$bo_list_mal = $board_info['list_mal'];	
}


if (!empty($bo_list_mal)) {
	$bo_list_mal_array = explode(",",$bo_list_mal);	
}


$param = "bo_num=$bo_num&list_num=$list_num&set_cs=$set_cs&set_cate=$set_cate&set_goods=$set_goods&sub_menu_num=$sub_menu_num&key=$key&searchword=$encode_searchword&list_notice_chk=$list_notice_chk&guin_state=$guin_state&list_page=$list_page";
?>

<script src="<?php echo $MY_URL;?>_js/jquery.min.js" type="text/javascript"></script>
<script src="<?php echo $MY_URL;?>_js/jquery.uploadify.min.js" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" href="<?php echo $MY_URL?>_js/uploadify.css">
<script src="<?php echo $MY_URL;?>_js/calendar.js" type="text/javascript"></script>
<!--<script type="text/javascript" src="../../smarteditor/js/HuskyEZCreator.js" charset="utf-8"></script>-->
<script type="text/javascript">
	function send_write_go()
	{
		var f = document.writeform;
		var check_memo = f.content.value = SubmitHTML();
		var file_cnt = f.chk_file.value;
		if (!f.title.value) {
			alert("제목을 입력해 주세요.");
			return;
		} else if (!f.user_name.value){
			alert("작성자를 입력해 주세요.");
			return;
		} else if (!check_memo){
			alert("내용을 입력해 주세요.");
			return;
		}

		$.ajax({
			type : "POST" 
			, async : true 
			, url : "<?php echo $board_process_url;?>/board_write_process.php" 
			, dataType : "html" 
			, timeout : 30000 
			, cache : false  
			, data : $("#writeform").serialize() 
			, contentType: "application/x-www-form-urlencoded; charset=UTF-8"
			//, contentType: "application/json; charset=UTF-8"
			, error : function(request, status, error) {
				 alert("ajax 통신서버에 접속할 수 없습니다.1");
				 //alert(error);
			}
			, success : function(response, status, request) {
			 //통신 성공시 처리
				var result=response.split('|');	
				if (result[0] != "T") {
					//alert(response);
					alert(result[1]);
				} else {
					if (f.sel_img) {
						if (f.sel_img.value != "" && result[1] != "") {
								f.list_num.value = result[1];
								f.target="join_target";
								f.action="<?php echo $board_process_url;?>/board_img_up_process.php";	
								f.submit();
						}		
					}

					if (parseInt(file_cnt) > 0) {
						 $("#file_upload").uploadify("settings", 'formData2', result[1],'list_num');
						 $('#file_upload').uploadify('upload', '*');
					} else {
						if (f.write_mode.value == "modi") {
							document.location.href="./index.php?mode=board_view&<?=$param?>";
						} else if (f.write_mode.value == "reply") {
							document.location.href="./index.php?mode=board_list&page=<?php echo $page;?>&bo_num=<?php echo $bo_num;?>&list_page=<?php echo $list_page;?>&key=<?php echo $key;?>&searchword=<?php echo $searchword;?>&sub_menu_num=<?php echo $sub_menu_num;?>";
						} else {
							document.location.href="./index.php?mode=board_list&page=<?php echo $page;?>&bo_num=<?php echo $bo_num;?>&key=<?php echo $key;?>&searchword=<?php echo $searchword;?>&sub_menu_num=<?php echo $sub_menu_num;?>";
						}
					}
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

	function send_list_go()
	{
		document.location.href="./index.php?mode=board_list&<?php echo $param;?>";
	}


	function set_file_del(num)
	{
		if (confirm("첨부된 파일을 삭제 하시겠습니까?")) {
			var del_file = document.getElementById("del_file_"+num);
			var f = document.writeform;
			if (f.del_file_num.value) {
				f.del_file_num.value = f.del_file_num.value + "<>" + num;
			} else {
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
			'auto'     : false,
			'fileSizeLimit' : '<?php echo $board_info["set_file_max"];?>MB',

			'swf'      : '<?php echo $board_process_url;?>/uploadify.swf',
			'uploader' : '<?php echo $board_process_url;?>/uploadify.php',
			'onUploadStart' : function(file) {
			   
				var f = document.writeform;
				f.chk_file.value = parseInt(f.chk_file.value) - 1;
				$("#file_upload").uploadify("settings", 'formData2', f.chk_file.value ,'file_cnt');
				$("#file_upload").uploadify("settings", 'formData2', "board" ,'file_state');
				
			},


			'onUploadSuccess' : function(file, data, response) {
				var result=data.split('|');	
				if (result['0'] != "T") {
					alert(result[1]);
					return;
				} else {
					if (parseInt(result[1]) < 1) {
						var f = document.writeform;
						if (f.write_mode.value == "modi") {
							document.location.href="./index.php?mode=board_view&page=<?php echo $page;?>&bo_num=<?php echo $bo_num?>&list_page=<?php echo $list_page?>&list_num=<?php echo $list_num;?>&sub_menu_num=<?php echo $sub_menu_num;?>";
						} else {
							document.location.href="./index.php?mode=board_list&page=<?php echo $page;?>&bo_num=<?php echo $bo_num;?>&sub_menu_num=<?php echo $sub_menu_num;?>";
						}
							return;
					}
				}
			}
		});
	});


	function cs_cate_set(val,mode){
		
		var f = document.cate_set_form;
		f.mode.value = mode;
		f.set_number.value = val;
		$.ajax({
			type : "POST" 
			, async : true 
			, url : "<?php echo $board_process_url;?>/cate_change_set.php" 
			, dataType : "html" 
			, timeout : 30000 
			, cache : false  
			, data : $("#cate_set_form").serialize() 
			, contentType: "application/x-www-form-urlencoded; charset=UTF-8"
			, error : function(request, status, error) {
				 alert("ajax 통신서버에 접속할 수 업습니다.");
			}
			, success : function(response, status, request) {
			 //통신 성공시 처리
				var result=response.split('|');	
				if (result[0] != "T") {
					//alert(response);
					alert(result[1]);
				} else {
					if (f.mode.value == "cs") {
						var div_layer=document.getElementById('cate_gubun');
						var div_layer2=document.getElementById('goods_gubun');
						div_layer.innerHTML=result[1];	
						div_layer2.innerHTML=result[2];	
					} else if(f.mode.value == "category") {
						var div_layer=document.getElementById('goods_gubun');
						var set_f = document.writeform;
						set_f.sel_ca_num.value = val;
						div_layer.innerHTML=result[1];	
					}
					
					
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
	function set_goods(val){
		var set_f = document.writeform;
		set_f.sel_goods_num.value = val;
	}


	jQuery(document).ready(function()
	{
	  init();
	});

</script>






 <table width="100%" border="0" cellspacing="1" cellpadding="3" class="td" bgcolor="#999999">
  <tr bgcolor="#EFEFEF" height=30> 
	  <td align=center> 
<?php if ($write_mode == "modi") {?>
		<b>[<?php echo $con_rs['title']?>]</b> 게시물 수정하기
<?php } else if ($write_mode == "reply") {?>
		<b>[<?php echo $board_name?>]</b> 게시물에 답글 달기
<?php } else {?>
		<b>[<?php echo $board_name?>]</b> 게시물 등록하기 
<?php }?>
	  </td>
	</tr>	
  </table>


<br><br>
 <table width="100%" border="0" cellspacing="1" cellpadding="3" class="td" bgcolor="#999999">
<form name = "cate_set_form" id = "cate_set_form">
<input type = "hidden" name = "mode">
<input type = "hidden" name = "set_number">
</form>
<form name="writeform" method="post"  enctype='multipart/form-data' id = "writeform">
<input type = "hidden" name = "bo_num" value = "<?php echo $bo_num;?>">
<input type = "hidden" name = "chk_file" value = "0">
<input type = "hidden" name = "write_mode" value = "<?php echo $write_mode;?>">
<input type = "hidden" name = "del_file_num">
<input type = "hidden" name = "page" value = "<?php echo $page;?>">
<input type = "hidden" name = "list_page" value = "<?php echo $list_page;?>">
<input type = "hidden" name = "list_num" value = "<?php echo $list_num;?>">
<input type = "hidden" name = "seq" value = "<?php echo $seq;?>">
<input type = "hidden" name = "ref" value = "<?php echo $ref;?>">
<input type = "hidden" name = "dep" value = "<?php echo $dep;?>">
<input type = "hidden" name = "sel_ca_num" value = "<?php echo $ca_num;?>">
<input type = "hidden" name = "sel_goods_num" value = "<?php echo $lt_num;?>">
<?php if ($write_mode == "modi" && $set_admin_chk == "Y") {?>
	<tr bgcolor="#EFEFEF"> 
	  <td align=center width=20%> 
		기타 사항
	  </td>
	  <td align=left> 
			조회수 : <input type = "text" name = "hit" value="<?php echo $hit;?>">
			등록날짜 : <input type = "text" name = "reg_date" value="<?php echo $reg_date;?>">
	  </td>
	</tr>
<?php }?>


<?php
if (($bo_state == "C" || $bo_state == "G" || $bo_state == "D" || $bo_state == "CD") && $write_mode != 'reply') {
?>
	<tr bgcolor="#EFEFEF"> 
	  <td align=center width=20%> 
		과목(자격증) 선택
	  </td>
	  <td align=left> 
		<select name = "cg_code" onchange="cs_cate_set(this.value,'cs')">
<?php
	$category_group_qry = mysqli_query($CONN['rosemary'],"select cg_code,cg_name from category_group");
	$first_cs_code = $cg_code;
	while ($category_group_rs = mysqli_fetch_array($category_group_qry)) {	
		if (!$first_cs_code) {
			$first_cs_code = $category_group_rs['cg_code'];
		}$cg_code
?>
			<option value="<?php echo $category_group_rs['cg_code'];?>" <?if($category_group_rs['cg_code'] == $cg_code){?>selected<?}?>><?php echo $category_group_rs['cg_name'];?></option>
<?php }?>
		</select>
<span id = "cate_gubun">
		<select name = "ca_num" id = "ca_num" onchange="cs_cate_set(this.value,'category')">
			<option value="">카테고리</option>
<?php
	if(!empty($first_cs_code)){
		$category_qry = mysqli_query($CONN['rosemary'],"select * from category where cg_code = '$first_cs_code' and ca_useyn = 'Y' order by ca_tree asc");
		while($coategory_rs = @mysqli_fetch_array($category_qry)){
			$ca_tree_len = strlen($coategory_rs['ca_tree']) / 3;
			if($ca_tree_len > 1){
				$nbsp = "&nbsp;";
				for($i=0;$i<$ca_tree_len;$i++){
					$nbsp .= $nbsp;
				}
				$cate_dep = $nbsp."ㄴ";
			}else{
				$cate_dep = "";
			}
?>
			<option value="<?php echo $coategory_rs['ca_num'];?>" <?if($coategory_rs['ca_num'] == $ca_num){?>selected<?}?>><?php echo $cate_dep;?><?php echo $coategory_rs['ca_name'];?></option>
<?php
	}}
?>
		</select>

</span>


<span id = "goods_gubun">
		<select name = "goods_num">
			<option value="">카테고리를 선택하세요</option>
<?php
if ($ca_num) {
		$cate_query = mysqli_query($CONN['rosemary'],"select ca_tree from category where ca_num = '$ca_num'");
		$ca_tree = mysqli_result($cate_query,0,0);
		$ca_tree_len = strlen($ca_tree);
		$tree_qry = mysqli_query($CONN['rosemary'],"select * from goods_lecture a, goods b where a.g_num = b.g_num and b.ca_num in (select ca_num from category where left(ca_tree,$ca_tree_len) = '$ca_tree')");
		$tree_nums = @mysqli_num_rows($tree_qry);
		if($tree_nums){
			while($tree_rs = mysqli_fetch_array($tree_qry)){
			$sel_name = $tree_rs['lt_name'];
?>
				<option value='$lt_num' <?if($tree_rs['lt_num'] == $lt_num){?>selected<?}?>><?=$sel_name?></option>
<?php 
			}
		}
	}
?>

		</select>
</span>
	  </td>
	</tr>
<?php
}
?>


<?
	if (!empty($bo_list_mal)) {
?>

	<tr bgcolor="#EFEFEF"> 
		<th>말머리</th>
		<td>
			<select name="list_mal">
			<?
				for($i=0;$i<count($bo_list_mal_array);$i++){
			?>
			<option value = "<?php echo $bo_list_mal_array[$i]?>" <?php if ($guin_state == $bo_list_mal_array[$i]) {?>selected<?php } ?>><?php echo $bo_list_mal_array[$i]?></option>
			<?}?>
			</select>
		</td>
	</tr>
<?
	}
?>



	<tr bgcolor="#EFEFEF"> 
	  <td align=center width=20%> 
		제  목
	  </td>
	  <td align=left> 
		<input type = "text" name = "title"  size = 70 value="<?php echo $title;?>">
<?php if ($board_info['set_secret'] == "Y") { ?><?php if ($set_use_chk['set_secret'] == "Y") { ?><input type = "checkbox" name = "secret_chk" value = "Y">비밀글<?php } ?><?}?>
<?php if ($bo_state != "N") {?><input type = "checkbox" name = "notice_chk" value = "Y">공지등록<?php } ?> 

	  </td>
	</tr>
<?php
//	if ($bo_state == "G") {
?>
<!--	구인형태 게시물 작성 필드 였으나 구인게시판이 기본 게시판으로 바뀌면서 필요없게됏음 혹시나 해서 안지우고 주석처리 해둠 2012-12-14 이명철
	<tr bgcolor="#EFEFEF"> 
	  <td align=center width=20%> 
		기타 사항
	  </td>
	  <td align=left> 
		<table width=100% border=0 cellspacing="1" cellpadding="3" class="td" bgcolor="#999999" >
			<tr bgcolor="#EFEFEF">
				<td width = "15%" align=center>회사 사이트</td>
				<td bgcolor="#FFFFFF" width = "35%"><input type = "text" name = "company_url" size = 80></td>
				<td width = "15%" align=center>구인 기간</td>
				<td bgcolor="#FFFFFF" width = "35%">
				<INPUT TYPE="text" NAME="guin_date" onclick="Calendar_D(document.all.guin_date)">
				</td>
			</tr>
		</table>
		
	  </td>
	</tr>
	<tr bgcolor="#EFEFEF"> 
	  <td align=center width=20%> 
		우대자격증
	  </td>
	  <td align=left> 
		<textarea cols=100% name = "certifi"></textarea>
		
	  </td>
	</tr>
	-->
<?php// } ?>

	<tr bgcolor="#EFEFEF"> 
	  <td align=center width=20%> 
	작성자
	  </td>
	  <td align=left> 
		<input type = "text" name = "user_name" maxlength=20 value = "<?php echo $user_name;?>" size = 20>
	  </td>
	</tr>

	<tr bgcolor="#EFEFEF"> 
	  <td align=center width=20%> 
		내  용
	  </td>
	  <td align=left bgcolor="white"> 
<?php echo myEditor2(1,'../../gmEditor','writeform','content','100%','400');?>

	  </td>
	</tr>
<?php if ($board_info['set_img'] == "Y") {?>
	<tr bgcolor="#EFEFEF"> 
	  <td align=center width=20%> 
	리스트 이미지 첨부
	  </td>
	  <td align=left >
		<input type = "file" name = "sel_img">
	  </td>
	</tr>
<?php } ?>
<?php
if ($board_info['set_file'] == "Y") {	
	if ($set_use_chk['set_file'] == "Y") {
?>

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
	  }
  }
?>


<?php
if ($file_chk == "Y") {
?>

	<tr bgcolor="#EFEFEF" height=40> 
	  <td align=center width=20%> 
	기존 첨부파일
	  </td>
	  <td align=left colspan=6 bgcolor="#FFFFFF">
	  	<table>
<?php
	for ($i=0;$i<count($file_rs);$i++) {
		$file_name_tmp = $file_rs[$i]['file_tmp_name'];
		$file_name = $file_rs[$i]['file_name'];
		$file_size = viewSizeToByte($file_rs[$i]['file_size']);
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
<?php

}
?>


	</form>
 </table>
		
<br><br>			
<div align=right>

<?php if ($write_mode == "modi") { ?>
<input type = "button" value = "수정하기" onclick="send_write_go()"> 
<?php } else if ($write_mode == "reply") { ?>
<input type = "button" value = "답글달기" onclick="send_write_go()"> 
<?php } else { ?>
<input type = "button" value = "등록하기" onclick="send_write_go()"> 
<?php } ?>


<input type = "button" value = "리스트가기" onclick="send_list_go()">
</div>


<iframe width="500" height="500" frameborder="0" hspace="0" vspace="0" id="join_target" name="join_target"></iframe>



