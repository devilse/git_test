<?php /* Template_ 2.2.7 2012/12/14 17:46:35 C:\rosemary\trunk\src\rosemary\_template\skin\qna\basic\write.html 000008618 */ 
$TPL_counsel_date_1=empty($TPL_VAR["counsel_date"])||!is_array($TPL_VAR["counsel_date"])?0:count($TPL_VAR["counsel_date"]);
$TPL_file_loop_1=empty($TPL_VAR["file_loop"])||!is_array($TPL_VAR["file_loop"])?0:count($TPL_VAR["file_loop"]);?>
<link rel="stylesheet" type="text/css" href="/_template/skin/qna/basic/css/board.css"/>
<script src="/_js/jquery.min.js" type="text/javascript"></script>
<script src="/_js/jquery.uploadify.min.js" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" href="/_js/uploadify.css">
<script src="/_js/qna.js" type="text/javascript"></script>
<script type = "text/javascript">
function send_write_go()
{
var f = document.writeform;
var check_memo = f.content.value = SubmitHTML();
var file_cnt = f.chk_file.value;
if(!f.title.value){
alert("제목을 입력해 주세요.");
f.title.focus();
return;
}else if(!check_memo){
alert("내용을 입력해 주세요.");
return;
}
$.ajax({
type : "POST"
, async : true
, url : "<?php echo $TPL_VAR["qna_process_url"]?>/qna_write_process.php"
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
document.location.href="./view.php?qna_num=<?php echo $TPL_VAR["qna_num"]?>&<?php echo $TPL_VAR["param"]?>";
}else{
document.location.href="./index.php?<?php echo $TPL_VAR["param"]?>";
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
'fileSizeLimit' : '5MB',
'swf'      : '/_template/skin/qna/basic/uploadify.swf',
'uploader' : '<?php echo $TPL_VAR["qna_process_url"]?>/uploadify.php',
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
document.location.href="./view.php?qna_num=<?php echo $TPL_VAR["qna_num"]?>&<?php echo $TPL_VAR["param"]?>";
}else{
document.location.href="./index.php?<?php echo $TPL_VAR["param"]?>";
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
<form name="writeform" method="post"  enctype='multipart/form-data' id = "writeform">
<input type = "text" name = "qna_num" value = "<?php echo $TPL_VAR["qna_num"]?>">
<input type = "hidden" name = "chk_file" value = "0">
<input type = "text" name = "write_mode" value = "<?php echo $TPL_VAR["write_mode"]?>">
<input type = "hidden" name = "del_file_num">
<input type = "hidden" name = "page" value = "<?php echo $TPL_VAR["page"]?>">
<!-- LS 우측 컨텐츠  영역 시작 -->
<div class="s_r_area">
<!-- LS 우측 컨텐츠  영역 헤드 시작 -->
<div class="sr_head">
<h3><img src="/_template/skin/qna/basic/images/sr_title.gif" alt="가스" /></h3>
<p><span> 국가기술자격증 </span>><span> 기술사/기능장 </span>><span> 가스 </span></p>
</div>
<!-- LS 우측 컨텐츠  헤드 끝 -->
<!-- LS 우측 컨텐츠  본문 시작 -->
<div class="sr_body">
<!-- 합격수기_글쓰기 -->
<h4><img src="/_template/skin/qna/basic/images/board/bod_blt.gif"><?php echo $TPL_VAR["head_title"]?></h4>
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
<tr>
<th>구분</th>
<td>
<select name = "gubun">
<option value = "1" <?php if($TPL_VAR["gubun"]=="1"){?>selected<?php }?>>개인정보관련</option>
<option value = "2" <?php if($TPL_VAR["gubun"]=="2"){?>selected<?php }?>>주문/결재관련</option>
<option value = "3" <?php if($TPL_VAR["gubun"]=="3"){?>selected<?php }?>>배송관련</option>
<option value = "4" <?php if($TPL_VAR["gubun"]=="4"){?>selected<?php }?>>사이트 불편사항</option>
<option value = "5" <?php if($TPL_VAR["gubun"]=="5"){?>selected<?php }?>>반품/환불관련</option>
<option value = "6" <?php if($TPL_VAR["gubun"]=="6"){?>selected<?php }?>>기타문의</option>
</select>
</td>
</tr>
<tr>
<th>제목</th>
<td><input type="text" name="title" class="text" style="width:80%;" maxlength="20" value="<?php echo $TPL_VAR["title"]?>"/><span class="blind">제목</span></td>
</tr>
<tr>
<th>연락처</th>
<td>
<input type = "text" class="text" name = "phone1" size=5 maxlength=4 value="<?php echo $TPL_VAR["mb_hp1"]?>"> - <input class="text" type = "text" name = "phone2" size=5 maxlength=4 value="<?php echo $TPL_VAR["mb_hp2"]?>"> - <input class="text" type = "text" name = "phone3" size=5 maxlength=4 value="<?php echo $TPL_VAR["mb_hp3"]?>">
</td>
</tr>
<tr>
<th>이메일</th>
<td>
<input type = "text" name = "email1" size=10 value = "<?php echo $TPL_VAR["mb_email1"]?>" class="text"> @ <input class="text" type = "text" name = "email2" size=10 value = "<?php echo $TPL_VAR["mb_email2"]?>">
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
<tr>
<th>상담가능시간</th>
<td>
<select name = "counsel_date1">
<?php if($TPL_counsel_date_1){foreach($TPL_VAR["counsel_date"] as $TPL_V1){?>
<option value = "<?php echo $TPL_V1["number"]?>" <?php if($TPL_VAR["counsel1"]==$TPL_V1["number"]){?>selected<?php }?>><?php echo $TPL_V1["number"]?></option>
<?php }}?>
</select> 시 ~
<select name = "counsel_date2">
<?php if($TPL_counsel_date_1){foreach($TPL_VAR["counsel_date"] as $TPL_V1){?>
<option value = "<?php echo $TPL_V1["number"]?>"<?php if($TPL_VAR["counsel2"]==$TPL_V1["number"]){?>selected<?php }?>><?php echo $TPL_V1["number"]?></option>
<?php }}?>
</select> 시  <input type ="checkbox" name = "counsel_always" value="Y" <?php if($TPL_VAR["counsel3"]=="Y"){?>checked<?php }?>>언제든가능
</td>
</tr>
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
<tr>
<th>파일업로드</th>
<td>
<div id="queue"></div>
<input id="file_upload" name="file_upload" type="file">
</td>
</tr>
</tbody>
</table>
<!-- //합격수기_글쓰기 -->
</div>
<!-- LS 우측 컨텐츠  본문 끝 -->
</div>
<!-- LS 우측 컨텐츠  영역 끝 -->
</form>