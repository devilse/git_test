<?php /* Template_ 2.2.7 2012/12/17 13:01:44 C:\rosemary\trunk\src\rosemary\_template\skin\board\basic\view.html 000012600 */ 
$TPL_menu_location_1=empty($TPL_VAR["menu_location"])||!is_array($TPL_VAR["menu_location"])?0:count($TPL_VAR["menu_location"]);
$TPL_file_loop_1=empty($TPL_VAR["file_loop"])||!is_array($TPL_VAR["file_loop"])?0:count($TPL_VAR["file_loop"]);
$TPL_comment_loop_1=empty($TPL_VAR["comment_loop"])||!is_array($TPL_VAR["comment_loop"])?0:count($TPL_VAR["comment_loop"]);
$TPL_yester_loop_1=empty($TPL_VAR["yester_loop"])||!is_array($TPL_VAR["yester_loop"])?0:count($TPL_VAR["yester_loop"]);
$TPL_next_loop_1=empty($TPL_VAR["next_loop"])||!is_array($TPL_VAR["next_loop"])?0:count($TPL_VAR["next_loop"]);?>
<script src="/_js/board.js" type="text/javascript"></script>
<style>
#mask {position:absolute;left:0;top:0;z-index:900;background-color:#000;display:none;}
#dialog {position:absolute;left:0;top:0;display:none;z-index:901;}
</style>
<script type = "text/javascript">
function send_option(val)
{
if (val == "scrap") {
var msg = "해당 게시물을 스크랩 하시겠습니까?";
var send_url = "<?php echo $TPL_VAR["board_process_url"]?>/scrap_process.php";
}else{
var msg = "해당 게시물에 추천을 하시겠습니까?";
var send_url = "<?php echo $TPL_VAR["board_process_url"]?>/recom_process.php";
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
});
}
}
function send_list(mode)
{
document.location.href = "./index.php?mode="+mode+"&<?php echo $TPL_VAR["param"]?>";
}
function send_modi()
{
var f = document.view_form;
f.mode.value = "board_write";
f.write_mode.value = "modi";
f.action = "./write.php";
f.submit();
}
function send_reply()
{
var f = document.view_form;
f.mode.value = "board_write";
f.write_mode.value = "reply";
f.action = "./write.php";
f.submit();
}
function send_del(val)
{
if (val == "guest") {
var f = document.view_form;
f.write_mode.value = "del";
f.method = "post";
f.action = "<?php echo $TPL_VAR["board_process_url"]?>/board_del_process.php";
f.submit();
} else {
if (confirm("해당 게시물을 삭제 하시겠습니까?")) {
var f = document.view_form;
f.write_mode.value = "del";
f.method = "post";
f.action = "<?php echo $TPL_VAR["board_process_url"]?>/board_del_process.php";
f.submit();
}
}
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
, url : "<?php echo $TPL_VAR["board_process_url"]?>/comment_process.php"
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
function send_geust_del()
{
var guest_pwd = document.getElementById('guest_pwd').value;
if (!guest_pwd) {
alert("비밀번호를 입력해 주세요.");
} else {
var f = document.view_form;
f.guest_pwd.value = guest_pwd;
send_del("guest");
}
}
</script>
<link rel="stylesheet" type="text/css" href="/_template/skin/board/basic/css/board.css"/>
<div id="mask" onclick="close_layer_window(); return false;"></div>
<form name = "view_form" id = "view_form">
<input type="hidden" name="bo_num" value="<?php echo $TPL_VAR["bo_num"]?>">
<input type="hidden" name="now_page" value="user" >
<input type="hidden" name="list_page" value="<?php echo $TPL_VAR["list_page"]?>">
<input type="hidden" name="list_num" value="<?php echo $TPL_VAR["list_num"]?>">
<input type="hidden" name="mode" >
<input type="hidden" name="write_mode" >
<input type="hidden" name="key" value="<?php echo $TPL_VAR["key"]?>" >
<input type="hidden" name="searchword" value="<?php echo $TPL_VAR["searchword"]?>" >
<input type="hidden" name="guest_pwd"  >
</form>
<!-- LS 우측 컨텐츠  영역 헤드 시작 -->
<div class="sr_head">
<h3><img src="/_template/skin/board/basic/images/sr_title.gif" alt="가스" /></h3>
<p><?php if($TPL_menu_location_1){$TPL_I1=-1;foreach($TPL_VAR["menu_location"] as $TPL_V1){$TPL_I1++;?><?php if($TPL_I1> 0){?><span> &gt; </span><?php }?><span><?php echo $TPL_V1?></span><?php }}?></p>
</div>
<!-- LS 우측 컨텐츠  헤드 끝 -->
<!-- LS 우측 컨텐츠  본문 시작 -->
<div class="sr_body">
<h4><img src="/_template/skin/board/basic/images/board/bod_blt.gif"><?php echo $TPL_VAR["head_title"]?></h4>
<!-- 자유게시판_내용 -->
<table cellspacing="0" cellpadding="0" border="0" summary="board" class="bod_02">
<caption></caption>
<colgroup>
<col width="20%" />
<col width="30%" />
<col width="20%" />
<col width="30%" />
</colgroup>
<tfoot>
<tr class="line_no">
<td colspan="5">
<ul class="con_menu">
<li class="left"><input type="button" name="bod_btn_gray" class="bod_btn_gray" value="목록" onclick="send_list('board_list')" /></li>
<?php if($TPL_VAR["in_board_chk"]=="Y"||$TPL_VAR["set_del"]=="Y"){?><li class="right"><input type="button" name="bod_btn_gray" class="bod_btn_gray03 leftm" value="삭제" <?php if($TPL_VAR["mb_id"]=="GUEST"&&$TPL_VAR["bbs_mb_id"]=="GUEST"){?>onclick="modal_window()"<?php }else{?>onclick="send_del()"<?php }?> /></li><?php }?>
<?php if($TPL_VAR["in_board_chk"]=="Y"||$TPL_VAR["set_modi"]=="Y"){?><li class="right"><input type="button" name="bod_btn_gray" class="bod_btn_gray03 leftm" value="수정" onclick="send_modi()" /></li><?php }?>
<?php if($TPL_VAR["bo_set_reply"]=="Y"){?><?php if($TPL_VAR["set_reply"]=="Y"){?><li class="right"><input type="button" name="bod_btn_gray" class="bod_btn_gray leftm" value="답글" onclick="send_reply()" /></li><?php }?><?php }?>
<?php if($TPL_VAR["bo_recom"]=="Y"&&$TPL_VAR["set_recom"]=="Y"){?><li class="right"><input type="button" name="bod_btn_gray" class="bod_btn_reco leftm" value="추천" onclick="send_option('recom')" /></li><?php }?>
</ul>
</td>
</tr>
</tfoot>
<tbody>
<tr>
<th>제목</th>
<td colspan="3"><?php echo $TPL_VAR["view_mal"]?> <?php echo $TPL_VAR["title"]?></td>
</tr>
<tr>
<th>글쓴이</th>
<td><?php echo $TPL_VAR["mb_name"]?></td>
<th class="line_left">조회수</th>
<td><?php echo $TPL_VAR["hit_cnt"]?></td>
</tr>
<tr>
<th>등록일</th>
<td><?php echo $TPL_VAR["reg_date"]?></td>
<th class="line_left">추천</th>
<td><img src="/_template/skin/board/basic/images/board/bod_up.gif"> <?php echo $TPL_VAR["recom_cnt"]?></td>
</tr>
<tr class="con">
<td colspan="4"><?php echo $TPL_VAR["con"]?></td>
</tr>
<?php if($TPL_VAR["bo_set_file"]=="Y"){?>
<tr>
<th>첨부파일</th>
<td colspan="3" class="file_list">
<?php if($TPL_file_loop_1){foreach($TPL_VAR["file_loop"] as $TPL_V1){?>
<?php if($TPL_VAR["set_down"]=="Y"){?><ul><li><a href="javascript:set_download('<?php echo $TPL_V1["file_tmp_name"]?>','<?php echo $TPL_V1["file_name"]?>')"><?php }else{?><a href="javascript:down_stop()"><?php }?>
<?php echo $TPL_V1["file_name"]?></a> <span class="ft_style"><?php echo $TPL_V1["file_size"]?></span></li></ul>
<?php }}?>
</td>
</tr>
<?php }?>
</tbody>
</table>
<?php if($TPL_VAR["set_comment"]=="Y"){?>
<form name = "comment_form" id = "comment_form">
<input type  = "hidden" name = "list_num" value = "<?php echo $TPL_VAR["list_num"]?>">
<input type  = "hidden" name = "del_num" >
<input type  = "hidden" name = "bo_num" value = "<?php echo $TPL_VAR["bo_num"]?>">
<div id = "opn_list_layer">
<div class="comment">
<p class="com_title">댓글 <?php echo $TPL_VAR["comment_cnt"]?></p>
<ul class="com_list">
<?php if($TPL_comment_loop_1){foreach($TPL_VAR["comment_loop"] as $TPL_V1){?>
<li><p><?php echo $TPL_V1["mb_name"]?><span class="ft_style">　l　<?php echo $TPL_V1["reg_date"]?></span> <a href="javascript:send_comment_go('<?php echo $TPL_V1["comment_num"]?>')"><img class="btn_sdel" src="<?php echo $TPL_VAR["MY_URL"]?>_template/skin/board/<?php echo $TPL_VAR["board_skin"]?>/images/board/btn_sdel.gif " alt="삭제" /></a></p>
<?php echo $TPL_V1["comment"]?>
</li>
<?php }}?>
</ul>
<div><textarea style="width:87%; height:50px;" name="comment" rows="3" cols="20"></textarea><span class="blind">내용</span>
<input type="button" name="bod_btn_wirte" class="bod_btn_wirte" value="등록" onclick="send_comment_go()" /></div>
</div>
</div>
</form>
<?php }?>
<table  cellspacing="0" cellpadding="0" border="0" summary="board" class="bod_01 line_top m_top">
<caption></caption>
<colgroup>
<col width="12%" />
<col width="61%" />
<col width="12%" />
<col width="15%" />
</colgroup>
<tbody>
<?php if($TPL_VAR["yester_cnt"]> 0){?>
<?php if($TPL_yester_loop_1){foreach($TPL_VAR["yester_loop"] as $TPL_V1){?>
<tr>
<td style="color:#434343; font-weight:bold;">▲ 이전글</td>
<td class="title"><a href="./view.php?mode=board_view&list_num=<?php echo $TPL_V1["list_num"]?>&<?php echo $TPL_VAR["param"]?>"><?php echo $TPL_V1["title"]?></a></td>
<td><?php echo $TPL_V1["mb_name"]?></td>
<td><?php echo $TPL_V1["reg_date"]?></td>
</tr>
<?php }}?>
<?php }else{?>
<tr>
<td colspan="4" align="center">등록된 게시물이 없습니다.</td>
</tr>
<?php }?>
<?php if($TPL_VAR["next_cnt"]> 0){?>
<?php if($TPL_next_loop_1){foreach($TPL_VAR["next_loop"] as $TPL_V1){?>
<tr>
<td style="color:#434343; font-weight:bold;">▼ 다음글</td>
<td class="title"><a href="./view.php?mode=board_view&list_num=<?php echo $TPL_V1["list_num"]?>&<?php echo $TPL_VAR["param"]?>"><?php echo $TPL_V1["title"]?></a></td>
<td><?php echo $TPL_V1["mb_name"]?></td>
<td><?php echo $TPL_V1["reg_date"]?></td>
</tr>
<?php }}?>
<?php }else{?>
<tr>
<td colspan="4" align="center">등록된 게시물이 없습니다.</td>
</tr>
<?php }?>
</tbody>
</table>
<!-- //자유게시판_내용 -->
</div>
<!-- LS 우측 컨텐츠  본문 끝 -->
<link rel="stylesheet" type="text/css" href="/_template/skin/board/basic/css/popup.css"/>
<div class="b_pop" id="dialog">
<div class="b_top"></div>
<div class="b_bg">
<p>비밀번호를 입력해주세요.</p>
<input type="password" name="text" class="text" style="width:180px; margin-top:10px;" maxlength="20" id="guest_pwd" />
<div class="b_btn"><a href="javascript:send_geust_del()"><img src="/_template/skin/board/basic/images/popup/btn_ok.gif" alt="확인"/></a></div>
</div>
<div class="b_btm"></div>
</div>
<script type = "text/javascript">
$(window).resize(function () {
if(is_mask_run){        modal_window();
}
});
$(window).scroll(function () {
if(is_mask_run){        modal_window();
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
// 활성화
is_mask_run = true;
// 마스크 사이즈
var maskHeight = $(document).height();
var maskWidth = $(window).width();
$('#mask').css({'width':maskWidth,'height':maskHeight});
// 마스크 effect
$('#mask').fadeTo("slow",0.8);
// 윈도우 화면 사이즈 구하기
var winH = $(window).height();
var winW = $(window).width();
// 스크롤 높이 구하기
var _y =(window.pageYOffset) ? window.pageYOffset
: (document.documentElement && document.documentElement.scrollTop) ? document.documentElement.scrollTop
: (document.body) ? document.body.scrollTop
: 0;
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