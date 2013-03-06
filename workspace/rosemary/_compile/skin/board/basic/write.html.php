<?php /* Template_ 2.2.7 2012/12/17 13:00:22 C:\rosemary\trunk\src\rosemary\_template\skin\board\basic\write.html 000009351 */ 
$TPL_mal_loop_1=empty($TPL_VAR["mal_loop"])||!is_array($TPL_VAR["mal_loop"])?0:count($TPL_VAR["mal_loop"]);
$TPL_file_loop_1=empty($TPL_VAR["file_loop"])||!is_array($TPL_VAR["file_loop"])?0:count($TPL_VAR["file_loop"]);?>
<link rel="stylesheet" type="text/css" href="/_template/skin/board/basic/css/board.css"/>
<script src="/_js/jquery.min.js" type="text/javascript"></script>
<script src="/_js/jquery.uploadify.min.js" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" href="/_js/uploadify.css">
<script type = "text/javascript">
function send_write_go()
{
var f = document.writeform;
var check_memo = f.content.value = SubmitHTML();
var file_cnt = f.chk_file.value;
if (f.member_type.value == "G") {
if (!f.title.value) {
alert("제목을 입력해 주세요.");
return;
} else if (!f.user_name.value){
alert("작성자를 입력해 주세요.");
return;
} else if (!f.user_pwd.value){
alert("비밀번호를 입력해 주세요. 비회원은 비밀번호를 입력해야 합니다.");
return;
} else if (!check_memo){
alert("내용을 입력해 주세요.");
return;
}
} else {
if (!f.title.value) {
alert("제목을 입력해 주세요.");
return;
} else if (!check_memo){
alert("내용을 입력해 주세요.");
return;
}
}
$.ajax({
type : "POST"
, async : true
, url : "<?php echo $TPL_VAR["board_process_url"]?>/board_write_process.php"
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
alert(response);
alert(result[1]);
} else {
if (f.sel_img) {
if (f.sel_img.value != "" && result[1] != "") {
f.list_num.value = result[1];
f.target="join_target";
f.action="<?php echo $TPL_VAR["board_process_url"]?>/board_img_up_process.php";
f.submit();
}
}
if (parseInt(file_cnt) > 0) {
$("#file_upload").uploadify("settings", 'formData2', result[1],'list_num');
$('#file_upload').uploadify('upload', '*');
} else {
if (f.write_mode.value == "modi") {
document.location.href="./view.php?mode=board_view&list_num=<?php echo $TPL_VAR["list_num"]?>&<?php echo $TPL_VAR["param"]?>";
} else if (f.write_mode.value == "reply") {
document.location.href="./index.php?mode=board_list&<?php echo $TPL_VAR["param"]?>";
} else {
document.location.href="./index.php?mode=board_list&<?php echo $TPL_VAR["param"]?>";
}
}
}
}
});
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
'fileSizeLimit' : '<?php echo $TPL_VAR["set_file_max"]?>MB',
'swf'      : '/_template/skin/board/basic/uploadify.swf',
'uploader' : '<?php echo $TPL_VAR["board_process_url"]?>/uploadify.php',
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
document.location.href="./view.php?mode=board_view&list_num=<?php echo $TPL_VAR["list_num"]?>&<?php echo $TPL_VAR["param"]?>";
} else {
document.location.href="./index.php?mode=board_list&<?php echo $TPL_VAR["param"]?>";
}
return;
}
}
}
});
});
function set_goods(val){
var set_f = document.writeform;
set_f.sel_goods_num.value = val;
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
</script>
<form name="writeform" method="post"  enctype='multipart/form-data' id = "writeform">
<input type = "hidden" name = "bo_num" value = "<?php echo $TPL_VAR["bo_num"]?>">
<input type = "hidden" name = "chk_file" value = "0">
<input type = "hidden" name = "write_mode" value = "<?php echo $TPL_VAR["write_mode"]?>">
<input type = "hidden" name = "del_file_num">
<input type = "hidden" name = "page" value = "<?php echo $TPL_VAR["page"]?>">
<input type = "hidden" name = "list_page" value = "<?php echo $TPL_VAR["list_page"]?>">
<input type = "hidden" name = "list_num" value = "<?php echo $TPL_VAR["list_num"]?>">
<input type = "hidden" name = "seq" value = "<?php echo $TPL_VAR["seq"]?>">
<input type = "hidden" name = "ref" value = "<?php echo $TPL_VAR["ref"]?>">
<input type = "hidden" name = "dep" value = "<?php echo $TPL_VAR["dep"]?>">
<input type = "hidden" name = "cg_code" value = "<?php echo $TPL_VAR["set_cs"]?>">
<input type = "hidden" name = "member_type" value = "<?php echo $TPL_VAR["mb_type"]?>">
<!-- LS 우측 컨텐츠  영역 시작 -->
<div class="s_r_area">
<!-- LS 우측 컨텐츠  영역 헤드 시작 -->
<div class="sr_head">
<h3><img src="/_template/skin/board/basic/images/sr_title.gif" alt="가스" /></h3>
<p><span> 국가기술자격증 </span>><span> 기술사/기능장 </span>><span> 가스 </span></p>
</div>
<!-- LS 우측 컨텐츠  헤드 끝 -->
<!-- LS 우측 컨텐츠  본문 시작 -->
<div class="sr_body">
<!-- 합격수기_글쓰기 -->
<h4><img src="/_template/skin/board/basic/images/board/bod_blt.gif"><?php echo $TPL_VAR["head_title"]?></h4>
<table cellspacing="0" cellpadding="0" border="0" summary="board" class="bod_02">
<caption></caption>
<colgroup>
<col width="20%" />
<col width="80%" />
</colgroup>
<tfoot>
<tr class="line_no">
<td colspan="5">
<ul class="con_menu">
<li class="right">
<input type="button" name="bod_btn_red" class="bod_btn_red" value="등록" onclick="send_write_go()" />
<input type="button" name="bod_btn_gray" class="bod_btn_gray03" value="취소" onclick="history.back();"/>
</li>
</ul>
</td>
</tr>
</tfoot>
<tbody>
<?php if($TPL_VAR["list_mal"]=="Y"){?>
<tr>
<th>말머리</th>
<td>
<select name="list_mal">
<?php if($TPL_mal_loop_1){foreach($TPL_VAR["mal_loop"] as $TPL_V1){?>
<option value="<?php echo $TPL_V1["name"]?>" <?php if($TPL_VAR["list_state"]==$TPL_V1["name"]){?>selected<?php }?>><?php echo $TPL_V1["name"]?></option>
<?php }}?>
</select>
</td>
</tr>
<?php }?>
<tr>
<th>제목</th>
<td><input type="text" name="title" class="text" style="width:80%;" maxlength="20" value="<?php echo $TPL_VAR["title"]?>"/><span class="blind">제목</span></td>
</tr>
<?php if($TPL_VAR["bo_set_secret"]=="Y"){?>
<tr>
<th>비밀글</th>
<td><input type = "checkbox" name = "secret_chk" value = "Y" <?php if($TPL_VAR["secret_chk"]=="Y"){?>checked<?php }?>> 비밀글 (* 비밀글 체크를 하면 관리자와 글쓴이만 볼 수 있습니다.) </td>
</tr>
<?php }?>
<?php if($TPL_VAR["mb_type"]=="G"){?>
<tr>
<th>글쓴이</th>
<td><input type="text" name="user_name" class="text" style="width:100px;" maxlength="20" value="<?php echo $TPL_VAR["user_name"]?>" /><span class="blind">글쓴이</span></td>
</tr>
<tr>
<th><?php if($TPL_VAR["write_mode"]=="modi"){?>기존 비밀번호<?php }else{?>비밀번호<?php }?></th>
<td><input type="password" name="user_pwd" class="text" style="width:100px;" maxlength="20" value="<?php echo $TPL_VAR["mb_password"]?>" /><span class="blind">글쓴이</span></td>
</tr>
<?php }?>
<tr class="con">
<td colspan="2">
<?php echo myEditor2(1,'../../gmEditor','writeform','content','100%','340');?>
</td>
</tr>
<?php if($TPL_VAR["write_mode"]=="modi"){?>
<tr>
<th>기존 첨부 파일</th>
<td>
<table><!--추가된 테이블임-->
<?php if($TPL_file_loop_1){foreach($TPL_VAR["file_loop"] as $TPL_V1){?>
<tr id = "del_file_<?php echo $TPL_V1["file_num"]?>">
<td><?php echo $TPL_V1["file_name"]?> <span class="ft_style">(<?php echo $TPL_V1["file_size"]?>) <a href="javascript:set_file_del('<?php echo $TPL_V1["file_num"]?>')"> 첨부파일 삭제 </a></span></td>
</tr>
<?php }}?>
</table><!--추가된 테이블임-->
</td>
</tr>
<?php }?>
<?php if($TPL_VAR["bo_set_img"]=="Y"){?>
<tr>
<th>리스트 이미지 첨부</th>
<td>
<input type="file" name="sel_img" class="add_file">
</td>
</tr>
<?php }?>
<?php if($TPL_VAR["bo_set_file"]=="Y"){?>
<tr>
<th>파일업로드</th>
<td>
<div id="queue"></div>
<input id="file_upload" name="file_upload" type="file">
</td>
</tr>
<?php }?>
</tbody>
</table>
<!-- //합격수기_글쓰기 -->
</div>
<!-- LS 우측 컨텐츠  본문 끝 -->
</div>
<!-- LS 우측 컨텐츠  영역 끝 -->
</form>
<iframe width="0" height="0" frameborder="0" hspace="0" vspace="0" id="join_target" name="join_target"></iframe>