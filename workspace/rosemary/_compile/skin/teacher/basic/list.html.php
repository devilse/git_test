<?php /* Template_ 2.2.7 2013/01/08 12:44:43 C:\rosemary\trunk\src\rosemary\_template\skin\teacher\basic\list.html 000007648 */ 
$TPL_menu_location_1=empty($TPL_VAR["menu_location"])||!is_array($TPL_VAR["menu_location"])?0:count($TPL_VAR["menu_location"]);
$TPL_list_1=empty($TPL_VAR["list"])||!is_array($TPL_VAR["list"])?0:count($TPL_VAR["list"]);?>
<link rel="stylesheet" type="text/css" href="/_template/skin/teacher/basic/css/professor.css"/>
<script type="text/javascript">
function sel_view(mb_num,page,ca_num)
{
document.location.href="./view.php?mb_num="+mb_num+"&page="+page+"&ca_num="+ca_num;
}
function list_subject(num,cg_code)
{
$.ajax({
type : "POST"
, async : true
, url : "./subject_list.php"
, dataType : "html"
, timeout : 30000
, cache : false
, data : "mb_num="+num+"&cg_code="+cg_code
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
$('#subject_div').css("left", mX + "px");
$('#subject_div').css("top", mY + "px");
var div_layer=document.getElementById('subject_div');
div_layer.style.display="block";
div_layer.innerHTML=result[1];
}
}
})
}
</script>
<!-- LS 우측 컨텐츠  영역 시작 -->
<div class="s_r_area04">
<!-- LS 우측 컨텐츠  영역 헤드 시작 -->
<div class="sr_head04">
<h3><img src="/_template/skin/teacher/basic/images/professor/professor_title.gif" alt="교수소개" /></h3>
<p><?php if($TPL_menu_location_1){$TPL_I1=-1;foreach($TPL_VAR["menu_location"] as $TPL_V1){$TPL_I1++;?><?php if($TPL_I1> 0){?><span> &gt; </span><?php }?><span><?php echo $TPL_V1?></span><?php }}?></p>
</div>
<!-- LS 우측 컨텐츠  헤드 끝 -->
<!-- LS 우측 컨텐츠 로그인 시작 -->
<!-- 교수소개 시작 -->
<div class="professor">
<img src="/_template/skin/teacher/basic/images/professor/professor_img.gif" alt="교수소개" />
<!-- 교수진소개 시작 -->
<h3>
<img src="/_template/skin/teacher/basic/images/professor/pr_subtitle01.gif" alt="교수진소개" />
<img src="/_template/skin/teacher/basic/images/professor/pr_subtxt01.gif" alt="교수진소개설명" class="pr_right" />
</h3>
<ul class="primg_list">
<?php if($TPL_VAR["list_cnt"]> 0){?>
<?php if($TPL_list_1){foreach($TPL_VAR["list"] as $TPL_V1){
$TPL_lt_name_2=empty($TPL_V1["lt_name"])||!is_array($TPL_V1["lt_name"])?0:count($TPL_V1["lt_name"]);?>
<li>
<?php if($TPL_V1["mb_picture"]){?><img class="m_tea_list" src="<?php echo $TPL_VAR["MY_URL"]?>/dir_img/teacher_img/<?php echo $TPL_V1["mb_picture"]?>" alt="최우영교수" /><?php }else{?><img class="m_tea_list" src="<?php echo $TPL_VAR["MY_URL"]?>/dir_img/teacher_img/<?php echo $TPL_V1["mb_picture"]?>" alt="이미지 없음" /><?php }?>
<span>
<h4><?php echo $TPL_V1["mb_name"]?></h4>
<font><?php if($TPL_lt_name_2){foreach($TPL_V1["lt_name"] as $TPL_V2){?><?php echo $TPL_V2["name"]?><?php }}?></font> <?php if($TPL_V1["lt_name_cnt"]> 2){?><a href="javascript:list_subject('<?php echo $TPL_V1["mb_num"]?>','<?php echo $TPL_VAR["cg_code"]?>')">++</a><?php }?>
<p>
<input  class="prbtn_white" type="button" value="자세히보기" onclick="sel_view('<?php echo $TPL_V1["mb_num"]?>','<?php echo $TPL_VAR["page"]?>','<?php echo $TPL_VAR["ca_num"]?>')" />
</p>
</span>
</li>
<?php }}?>
<?php }?>
</ul>
<!-- 교수진소개 끝 -->
<!-- 교수님칭찬하기 시작 -->
<!--
<h3 class="pr_clear">
<img src="/_template/skin/teacher/basic/images/professor/pr_subtitle02.gif" alt="교수님칭찬하기" />
<img src="/_template/skin/teacher/basic/images/professor/pr_subtxt02.gif" alt="교수님칭찬하기설명" class="pr_right" />
</h3>
<table cellspacing="0" cellpadding="0" border="0" summary="board" class="pr_bod">
<caption></caption>
<colgroup>
<col width="10%" />
<col width="55%" />
<col width="12%" />
<col width="13%" />
<col width="10%" />
</colgroup>
<thead>
<tr>
<th>번호</th>
<th>내용</th>
<th>글쓴이</th>
<th>등록일</th>
<th>삭제</th>
</tr>
</thead>
<tfoot>
<tr>
<td colspan="5">
<ul class="pr_pagelist">
<li><a href="#"><img src="/_template/skin/teacher/basic/images/professor/btn_all_prev.gif"></a>
<a href="#"><img src="/_template/skin/teacher/basic/images/professor/btn_prev.gif"></a></li>
<li><a href="#">1</a></li>
<li><a href="#">2</a></li>
<li><a href="#">3</a></li>
<li><a href="#">4</a></li>
<li><a href="#">5</a></li>
<li><a href="#">6</a></li>
<li><a href="#">7</a></li>
<li><a href="#"><img src="/_template/skin/teacher/basic/images/professor/btn_next.gif"></a>
<a href="#"><img src="/_template/skin/teacher/basic/images/professor/btn_all_next.gif"></a></li>
</ul>
</td>
</tr>
</tfoot>
<tbody>
<tr>
<td>1</td>
<td class="pr_ft"><b>[가스기능장 필기]</b> 강의 잘 들었습니다.</td>
<td>이미은</td>
<td>2012-12-14</td>
<td><a href="#"><img src="/_template/skin/teacher/basic/images/professor/btn_del.gif" alt="삭제" /></a></td>
</tr>
<tr>
<td>2</td>
<td class="pr_ft"><b>[가스기능장 필기]</b> 강의 잘 들었습니다.</td>
<td>이미은</td>
<td>2012-12-14</td>
<td><a href="#"><img src="/_template/skin/teacher/basic/images/professor/btn_del.gif" alt="삭제" /></a></td>
</tr>
<tr>
<td>3</td>
<td class="pr_ft"><b>[가스기능장 필기]</b> 강의 잘 들었습니다.</td>
<td>이미은</td>
<td>2012-12-14</td>
<td><a href="#"><img src="/_template/skin/teacher/basic/images/professor/btn_del.gif" alt="삭제" /></a></td>
</tr>
<tr>
<td>4</td>
<td class="pr_ft"><b>[가스기능장 필기]</b> 강의 잘 들었습니다.</td>
<td>이미은</td>
<td>2012-12-14</td>
<td><a href="#"><img src="/_template/skin/teacher/basic/images/professor/btn_del.gif" alt="삭제" /></a></td>
</tr>
<tr>
<td>5</td>
<td class="pr_ft"><b>[가스기능장 필기]</b> 강의 잘 들었습니다.</td>
<td>이미은</td>
<td>2012-12-14</td>
<td><a href="#"><img src="/_template/skin/teacher/basic/images/professor/btn_del.gif" alt="삭제" /></a></td>
</tr>
<tr>
<td>6</td>
<td class="pr_ft"><b>[가스기능장 필기]</b> 강의 잘 들었습니다.</td>
<td>이미은</td>
<td>2012-12-14</td>
<td><a href="#"><img src="/_template/skin/teacher/basic/images/professor/btn_del.gif" alt="삭제" /></a></td>
</tr>
<tr>
<td>7</td>
<td class="pr_ft"><b>[가스기능장 필기]</b> 강의 잘 들었습니다.</td>
<td>이미은</td>
<td>2012-12-14</td>
<td><a href="#"><img src="/_template/skin/teacher/basic/images/professor/btn_del.gif" alt="삭제" /></a></td>
</tr>
<tr>
<td>8</td>
<td class="pr_ft"><b>[가스기능장 필기]</b> 강의 잘 들었습니다.</td>
<td>이미은</td>
<td>2012-12-14</td>
<td><a href="#"><img src="/_template/skin/teacher/basic/images/professor/btn_del.gif" alt="삭제" /></a></td>
</tr>
<tr class="pr_tr">
<td colspan="5">
<div class="pr_memo">
<textarea style="width:83%; height:40px;" rows="3" cols="20"></textarea><span class="blind">내용</span>
<input type="button" name="prbtn_gray" class="prbtn_gray" value="칭찬등록" />
</div>
</td>
</tr>
</tbody>
</table>
-->
<!-- 교수님칭찬하기 끝 -->
</div>
<!-- 교수소개 끝 -->
<!-- LS 우측 컨텐츠 로그인 끝 -->
</div>
<!-- LS 우측 컨텐츠  영역 끝 -->
<div id="subject_div" style="z-index:1; position:absolute;background-color:#fff;">
</div>