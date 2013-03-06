<?php /* Template_ 2.2.7 2013/01/08 12:43:55 C:\rosemary\trunk\src\rosemary\_template\skin\board\basic\list.html 000010977 */ 
$TPL_menu_location_1=empty($TPL_VAR["menu_location"])||!is_array($TPL_VAR["menu_location"])?0:count($TPL_VAR["menu_location"]);
$TPL_notice_list_1=empty($TPL_VAR["notice_list"])||!is_array($TPL_VAR["notice_list"])?0:count($TPL_VAR["notice_list"]);
$TPL_list_1=empty($TPL_VAR["list"])||!is_array($TPL_VAR["list"])?0:count($TPL_VAR["list"]);?>
<script src="/_js/board.js" type="text/javascript"></script>
<script type ="text/javascript">
function list_download(num)
{
$.ajax({
type : "POST"
, async : true
, url : "<?php echo $TPL_VAR["board_process_url"]?>/file_list.php"
, dataType : "html"
, timeout : 30000
, cache : false
, data : "list_num="+num
, contentType: "application/x-www-form-urlencoded; charset=UTF-8"
, error : function(request, status, error) {
alert("ajax 통신서버에 접속할 수 업습니다.");
}
, success : function(response, status, request) {
var result=response.split('|');
if (result[0] != "T") {
alert(result[1]);
}else{
var mX = event.clientX + document.documentElement.scrollLeft;
var mY = event.clientY + document.documentElement.scrollTop;
$('#file_div').css("left", mX + "px");
$('#file_div').css("top", mY + "px");
var div_layer=document.getElementById('file_div');
div_layer.style.display="block";
div_layer.innerHTML=result[1];
}
}
})
}
</script>
<link rel="stylesheet" type="text/css" href="/_template/skin/board/basic/css/board.css"/>
<style>
#mask {position:absolute;left:0;top:0;z-index:900;background-color:#000;display:none;}
#dialog {position:absolute;left:0;top:0;display:none;z-index:901;}
</style>
<div id="mask" onclick="close_layer_window(); return false;"></div>
<form name="chk_form">
<input type="hidden" name="bo_num" value="<?php echo $TPL_VAR["bo_num"]?>">
</form>
<!-- LS 우측 컨텐츠  영역 헤드 시작 -->
<div class="sr_head">
<h3><img src="/_template/skin/board/basic/images/sr_title.gif" alt="가스" /></h3>
<p><?php if($TPL_menu_location_1){$TPL_I1=-1;foreach($TPL_VAR["menu_location"] as $TPL_V1){$TPL_I1++;?><?php if($TPL_I1> 0){?><span> &gt; </span><?php }?><span><?php echo $TPL_V1?></span><?php }}?></p>
</div>
<!-- LS 우측 컨텐츠  헤드 끝 -->
<!-- LS 우측 컨텐츠  본문 시작 -->
<div class="sr_body">
<!-- 공지사항 -->
<h4><img src="/_template/skin/board/basic/images/board/bod_blt.gif"><?php echo $TPL_VAR["head_title"]?></h4>
<table cellspacing="0" cellpadding="0" border="0" summary="board" class="bod_01">
<caption></caption>
<colgroup>
<col width="6%" />
<?php if($TPL_VAR["list_mal"]=="Y"){?><col width="10%" /><?php }?>
<col width="36%" />
<col width="10%" />
<col width="10%" />
<?php if($TPL_VAR["bo_set_file"]=="Y"){?><col width="10%" /><?php }?>
<?php if($TPL_VAR["bo_recom"]=="Y"){?><col width="10%" /><?php }?>
<col width="8%" />
</colgroup>
<thead>
<tr>
<th>번호</th>
<?php if($TPL_VAR["list_mal"]=="Y"){?><th>구분</th><?php }?>
<th>제목</th>
<th>작성자</th>
<th>작성일</th>
<?php if($TPL_VAR["bo_set_file"]=="Y"){?><th>첨부파일</th><?php }?>
<?php if($TPL_VAR["bo_recom"]=="Y"){?><th>추천</th><?php }?>
<th>조회</th>
</tr>
</thead>
<tfoot>
<?php if($TPL_VAR["set_write"]=="Y"){?>
<tr class="line_no">
<td colspan="8">
<ul class="con_menu ft_size">
<li class="right"><a href="javascript:user_send_write('<?php echo $TPL_VAR["bo_num"]?>')"><input type="button" name="bod_btn_red" class="bod_btn_red" value="글쓰기" /></a></li>
</ul>
</td>
</tr>
<?php }?>
<tr class="line_no">
<td colspan="8">
<ul class="bod_pagelist">
<?php echo $TPL_VAR["page_list"]?>
</ul>
</td>
</tr>
<tr>
<td class="tdtd"colspan="8" style="border:0;">
<form name="search_form">
<input type="hidden" name="bo_num" value="<?php echo $TPL_VAR["bo_num"]?>">
<div class="bod_sch ft_size">
<select name="key" class="sel_sch">
<option value="title" <?php if($TPL_VAR["key"]=="title"){?>selected<?php }?> >제목</option>
<option value="con" <?php if($TPL_VAR["key"]=="con"){?>selected<?php }?> >내용</option>
<option value="tot" <?php if($TPL_VAR["key"]=="tot"){?>selected<?php }?> >제목+내용</option>
<option value="mb_id" <?php if($TPL_VAR["key"]=="mb_id"){?>selected<?php }?>>작성자</option>
</select>
<input type="text" name="searchword" value = "<?php echo $TPL_VAR["searchword"]?>" class="text_sch" style="width:150px;" /><span class="blind">검색창</span>
<input type="button" name="btn_sch" class="btn_sch" value="검색" onclick="search_go('index.php')" />
<?php if($TPL_VAR["searchword"]!=""){?><input type = "button"  class="btn_sch" value = "전체 게시물 보기" onclick="change_list()"><?php }?>
</div>
</form>
</td>
</tr>
</tfoot>
<tbody>
<?php if($TPL_notice_list_1){foreach($TPL_VAR["notice_list"] as $TPL_V1){?>
<tr>
<td><?php echo $TPL_V1["list_number"]?></td>
<?php if($TPL_VAR["list_mal"]=="Y"){?><td class="sj_color01">국가기술</td><?php }?>
<td class="title"><a href="./view.php?mode=board_view&list_num=<?php echo $TPL_V1["list_num"]?>&<?php echo $TPL_VAR["param"]?>"><?php echo $TPL_V1["title"]?></a></td>
<td><?php echo $TPL_V1["mb_name"]?></td>
<td><?php echo $TPL_V1["reg_date"]?></td>
<?php if($TPL_VAR["bo_set_file"]=="Y"){?><td><?php if($TPL_V1["file_chk"]=="Y"){?><img src="/_template/skin/board/basic/images/board/bod_file.gif" /><?php }?></td><?php }?>
<?php if($TPL_VAR["bo_recom"]=="Y"){?><td class="bod_up"><img src="/_template/skin/board/basic/images/board/bod_up.gif"> <?php echo $TPL_V1["recom_cnt"]?></td><?php }?>
<td><?php echo $TPL_V1["hit_cnt"]?></td>
</tr>
<?php }}?>
<?php if($TPL_VAR["list_query"]){?>
<?php if($TPL_list_1){foreach($TPL_VAR["list"] as $TPL_V1){?>
<tr>
<td><?php echo $TPL_V1["list_number"]?></td>
<?php if($TPL_VAR["list_mal"]=="Y"){?><td class="sj_color01"><?php echo $TPL_V1["list_state"]?></td><?php }?>
<td class="title">
<?php if($TPL_V1["secret_chk"]=="Y"){?>
<?php if($TPL_V1["mb_id"]=="GUEST"){?>
<?php if($TPL_VAR["mb_id"]==$TPL_V1["mb_id"]){?>
<?php echo $TPL_V1["deps"]?><a href="javascript:modal_window('<?php echo $TPL_V1["list_num"]?>')"><?php echo $TPL_V1["title"]?> <?php if($TPL_V1["comment_cnt"]> 0){?><span>[<?php echo $TPL_V1["comment_cnt"]?>]</span><?php }?>   <img src="/_template/skin/board/basic/images/board/ico_lock.gif" alt="비밀글" align="absmiddle" /> </a>
<?php }else{?>
<?php echo $TPL_V1["deps"]?><?php echo $TPL_V1["title"]?> <?php if($TPL_V1["comment_cnt"]> 0){?><span>[<?php echo $TPL_V1["comment_cnt"]?>]</span><?php }?> <img src="/_template/skin/board/basic/images/board/ico_lock.gif" alt="비밀글" align="absmiddle" />
<?php }?>
<?php }else{?>
<?php if($TPL_VAR["mb_id"]==$TPL_V1["mb_id"]){?>
<?php echo $TPL_V1["deps"]?><a href="./view.php?mode=board_view&list_num=<?php echo $TPL_V1["list_num"]?>&<?php echo $TPL_VAR["param"]?>"><?php echo $TPL_V1["title"]?> <?php if($TPL_V1["comment_cnt"]> 0){?><span>[<?php echo $TPL_V1["comment_cnt"]?>]</span><?php }?> <img src="/_template/skin/board/basic/images/board/ico_lock.gif" alt="비밀글" align="absmiddle" />  </a>
<?php }else{?>
<?php echo $TPL_V1["deps"]?><?php echo $TPL_V1["title"]?> <?php if($TPL_V1["comment_cnt"]> 0){?><span>[<?php echo $TPL_V1["comment_cnt"]?>]</span><?php }?> <img src="/_template/skin/board/basic/images/board/ico_lock.gif" alt="비밀글" align="absmiddle" />
<?php }?>
<?php }?>
<?php }else{?>
<?php echo $TPL_V1["deps"]?><a href="./view.php?mode=board_view&list_num=<?php echo $TPL_V1["list_num"]?>&<?php echo $TPL_VAR["param"]?>"><?php echo $TPL_V1["title"]?> <?php if($TPL_V1["comment_cnt"]> 0){?><span>[<?php echo $TPL_V1["comment_cnt"]?>]</span><?php }?>  </a>
<?php }?>
</td>
<td><?php echo $TPL_V1["mb_name"]?></td>
<td><?php echo $TPL_V1["reg_date"]?> </td>
<?php if($TPL_VAR["bo_set_file"]=="Y"){?><td><?php if($TPL_V1["file_chk"]=="Y"){?><a href="javascript:list_download('<?php echo $TPL_V1["list_num"]?>')"><img src="/_template/skin/board/basic/images/board/bod_file.gif" /></a><?php }?></td><?php }?>
<?php if($TPL_VAR["bo_recom"]=="Y"){?><td class="bod_up"><img src="/_template/skin/board/basic/images/board/bod_up.gif"> <?php echo $TPL_V1["recom_cnt"]?></td><?php }?>
<td><?php echo $TPL_V1["hit_cnt"]?></td>
</tr>
<?php }}?>
<?php }else{?>
<tr>
<td align="center" colspan="8">등록된 게시물이 없습니다.</td>
</tr>
<?php }?>
</tbody>
</table>
<!-- //공지사항 -->
</div>
<!-- LS 우측 컨텐츠  본문 끝 -->
<!-- 파일리스트수정 -->
<div id="file_div" style="z-index:1; position:absolute;background-color:#fff;">
</div>
<link rel="stylesheet" type="text/css" href="/_template/skin/board/basic/css/popup.css"/>
<form name="guest_form">
<input type="hidden" name="bo_num" value="<?php echo $TPL_VAR["bo_num"]?>">
<input type="hidden" name="list_num">
<input type="hidden" name="mode" value="board_view">
<input type="hidden" name="key" value="<?php echo $TPL_VAR["key"]?>">
<input type="hidden" name="searchword" value="<?php echo $TPL_VAR["searchword"]?>">
<input type="hidden" name="list_page" value="<?php echo $TPL_VAR["list_page"]?>">
<div class="b_pop" id="dialog">
<div class="b_top"></div>
<div class="b_bg">
<p>비밀번호를 입력해주세요.</p>
<input type="password" name="guest_pwd" class="text" style="width:180px; margin-top:10px;" maxlength="20" id="guest_pwd" />
<div class="b_btn"><a href="javascript:bbs_guest_chk('<?php echo $TPL_VAR["list_num"]?>')"><img src="/_template/skin/board/basic/images/popup/btn_ok.gif" alt="확인"/></a></div>
</div>
<div class="b_btm"></div>
</div>
</form>
<script type = "text/javascript">
is_mask_run = false;
$(window).resize(function () {
if(is_mask_run){
modal_window();
}
});
$(window).scroll(function () {
if(is_mask_run){
modal_window();
}
});
$('#mask').click(function (){
$(this).hide();    $('#dialog').hide();     is_mask_run =false;
});
function close_layer_window(){
$('#mask').hide();
$('#dialog').hide();
is_mask_run= false;
}
function modal_window(val){
is_mask_run = true;
var maskHeight = $(document).height();
var maskWidth = $(window).width();
$('#mask').css({'width':maskWidth,'height':maskHeight});
$('#mask').fadeTo("slow",0.8);
var winH = $(window).height();
var winW = $(window).width();
var _y =(window.pageYOffset) ? window.pageYOffset
: (document.documentElement && document.documentElement.scrollTop) ? document.documentElement.scrollTop
: (document.body) ? document.body.scrollTop
: 0;
if (!val) {
return;
}
var f = document.guest_form;
f.list_num.value = val;
if(_y<1){
var h = winH/2;
}else{
var h = winH/2+_y;
}
var dial_width =$('#dialog').width();
var dial_height = $('#dialog').height();
$('#dialog').css({'width':dial_width,'height':dial_height});
$('#dialog').css('top', h-dial_height/2);
$('#dialog').css('left', winW/2-dial_width/2);
$('#dialog').fadeIn(2000);
}
</script>