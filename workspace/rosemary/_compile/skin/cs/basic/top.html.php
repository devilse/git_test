<?php /* Template_ 2.2.7 2013/01/10 17:08:10 C:\rosemary\trunk\src\rosemary\_template\skin\cs\basic\top.html 000010201 */ ?>
<script type="text/javascript">
$(function(){
$("a#bookmark").click(function(){
var bookmarkUrl = this.href;
var bookmarkTitle = this.title;
if ($.browser.mozilla) { // For Mozilla Firefox Bookmark
window.sidebar.addPanel(bookmarkTitle, bookmarkUrl,"");
} else if($.browser.msie) { // For IE Favorite
window.external.AddFavorite( bookmarkUrl, bookmarkTitle);
} else if($.browser.opera ) { // For Opera Browsers
$(this).attr("href",bookmarkUrl);
$(this).attr("title",bookmarkTitle);
$(this).attr("rel","sidebar");
$(this).click();
} else {
alert('단축키 \"CTRL+D\"를 눌러 즐겨찾기 추가하세요.');
}
return false;
});
});
function send_top_search()
{
var f = document.top_search_form;
if (f.top_search.value == "") {
alert("검색할 단어를 입력해 주세요.");
return;
} else {
f.submit();
}
}
function toggle_top(obj) {
var fMenu = jQuery("#" + obj)
var fMenuDisp = fMenu.css("display");
if (fMenuDisp == 'none') {
fMenu.fadeIn("300");
} else {
fMenu.fadeOut("300");
}
}
function my_subject_room()
{
window.open("<?php echo $TPL_VAR["MY_URL"]?>web/class/index.php","my_room","width=820,height=600,scrollbars=yes");
}
function nav(){
$(".bn01").hover(function(){
$("#left_gm1").show();
$("#left_gm2").hide();
$("#left_gm3").hide();
$("#left_gm4").hide();
$("#left_gm5").hide();
});
$(".bn02").hover(function(){
$("#left_gm1").hide();
$("#left_gm2").show();
$("#left_gm3").hide();
$("#left_gm4").hide();
$("#left_gm5").hide();
});
$(".bn03").hover(function(){
$("#left_gm1").hide();
$("#left_gm2").hide();
$("#left_gm3").show();
$("#left_gm4").hide();
$("#left_gm5").hide();
});
$(".bn04").hover(function(){
$("#left_gm1").hide();
$("#left_gm2").hide();
$("#left_gm3").hide();
$("#left_gm4").show();
$("#left_gm5").hide();
});
$(".bn05").hover(function(){
$("#left_gm1").hide();
$("#left_gm2").hide();
$("#left_gm3").hide();
$("#left_gm4").hide();
$("#left_gm5").show();
});
$("#category").mouseleave(function(){
$("#left_gm1").hide();
$("#left_gm2").hide();
$("#left_gm3").hide();
$("#left_gm4").hide();
$("#left_gm5").hide();
});
};
$(document).ready(function(){
nav();
$("#left_gm1").hide();
$("#left_gm2").hide();
$("#left_gm3").hide();
$("#left_gm4").hide();
$("#left_gm5").hide();
});
</script>
<!-- 헤더 영역 시작 -->
<div id ="header">
<!-- 전체보기 레이어 시작 -->
<div id="gm_box" style="display:none">
<div class="gm_list">
<dl>
<dt>기술사·기능장</dt>
<dd>건축전기설비</dd>
<dd>발송배전</dd>
<dd>가스</dd>
<dd>건설안전</dd>
<dd>건축전기설비</dd>
<dd>발송배전</dd>
</dl>
<dl>
<dt>기사·산업기사</dt>
<dd>건축전기설비</dd>
<dd>발송배전</dd>
<dd>가스</dd>
<dd>건설안전</dd>
<dd>건축전기설비</dd>
<dd>발송배전</dd>
</dl>
<dl>
<dt>기술사·기능장</dt>
<dd>건축전기설비</dd>
<dd>발송배전</dd>
<dd>가스</dd>
<dd>건설안전</dd>
<dd>건축전기설비</dd>
<dd>발송배전</dd>
</dl>
<dl>
<dt>기사·산업기사</dt>
<dd>건축전기설비</dd>
<dd>발송배전</dd>
<dd>가스</dd>
<dd>건설안전</dd>
<dd>건축전기설비</dd>
<dd>발송배전</dd>
</dl>
<dl>
<dt>기술사·기능장</dt>
<dd>건축전기설비</dd>
<dd>발송배전</dd>
<dd>가스</dd>
<dd>건설안전</dd>
<dd>건축전기설비</dd>
<dd>발송배전</dd>
</dl>
<dl class="end">
<dt>기사·산업기사</dt>
<dd>건축전기설비</dd>
<dd>발송배전</dd>
<dd>가스</dd>
<dd>건설안전</dd>
<dd>건축전기설비</dd>
<dd>발송배전</dd>
</dl>
<dl>
<dt>기술사·기능장</dt>
<dd>건축전기설비</dd>
<dd>발송배전</dd>
<dd>가스</dd>
<dd>건설안전</dd>
<dd>건축전기설비</dd>
<dd>발송배전</dd>
</dl>
<dl>
<dt>기사·산업기사</dt>
<dd>건축전기설비</dd>
<dd>발송배전</dd>
<dd>가스</dd>
<dd>건설안전</dd>
<dd>건축전기설비</dd>
<dd>발송배전</dd>
</dl>
<dl>
<dt>기술사·기능장</dt>
<dd>건축전기설비</dd>
<dd>발송배전</dd>
<dd>가스</dd>
<dd>건설안전</dd>
<dd>건축전기설비</dd>
<dd>발송배전</dd>
</dl>
<dl>
<dt>기사·산업기사</dt>
<dd>건축전기설비</dd>
<dd>발송배전</dd>
<dd>가스</dd>
<dd>건설안전</dd>
<dd>건축전기설비</dd>
<dd>발송배전</dd>
</dl>
<dl>
<dt>기술사·기능장</dt>
<dd>건축전기설비</dd>
<dd>발송배전</dd>
<dd>가스</dd>
<dd>건설안전</dd>
<dd>건축전기설비</dd>
<dd>발송배전</dd>
</dl>
<dl class="end">
<dt>기사·산업기사</dt>
<dd>건축전기설비</dd>
<dd>발송배전</dd>
<dd>가스</dd>
<dd>건설안전</dd>
<dd>건축전기설비</dd>
<dd>발송배전</dd>
</dl>
</div>
<img class="btn_close" src="/_template/skin/cs/basic/images/btn_close.gif" alt="닫기" onClick="toggle_top('gm_box');" style="cursor:pointer;"/>
</div>
<!-- 전체보기 레이어 끝 -->
<!-- 탑 네비게이션 시작 -->
<div class="tnb">
<div class="tnbtab">
<a href="#"><img src="/_template/skin/cs/basic/images/tnb1.gif" alt="홈으로"/></a>
<a href="#"><img src="/_template/skin/cs/basic/images/tnb2.gif" class="now" alt="국가기술"/></a>
<a href="#"><img src="/_template/skin/cs/basic/images/tnb3.gif" alt="경영,세무,회계,금융"/></a>
<a href="#"><img src="/_template/skin/cs/basic/images/tnb4.gif" alt="문화재"/></a>
<a href="#"><img src="/_template/skin/cs/basic/images/tnb5.gif" alt="공무원"/></a>
<a href="#"><img src="/_template/skin/cs/basic/images/tnb6.gif" alt="공인중개사"/></a>
<a href="#"><img src="/_template/skin/cs/basic/images/tnb7.gif" alt="주택관리사"/></a>
<a href="#"><img src="/_template/skin/cs/basic/images/tnb8.gif" alt="학점인정자격증"/></a>
</div>
<?php if($TPL_VAR["login_info"]["type"]=="G"){?>
<p class="bef_log"><a href="../member/login.php?prev=<?php echo $TPL_VAR["current_uri"]?>"><span>로그인</span></a>&nbsp;｜&nbsp;<a href="../member/join.php"><span>회원가입</span></a></p>
<?php }elseif($TPL_VAR["login_info"]["type"]=="S"){?>
<p><a href="javascript:my_subject_room()"><img class="btn_my" src="/_template/skin/cs/basic/images/btn_my_lec.gif" alt="내강의실가기" /></a>
<a href="../mypage/my_info.php"><span class="out">마이페이지</span></a>&nbsp;｜&nbsp;
<?php }elseif($TPL_VAR["login_info"]["type"]=="T"){?>
<p><a href="/admin_teacher"><img class="btn_my" src="/_template/skin/cs/basic/images/btn_my_teacher.gif" alt="교수자" /></a>
<?php }elseif($TPL_VAR["login_info"]["type"]=="A"){?>
<p><a href="/admin"><img class="btn_my" src="/_template/skin/cs/basic/images/btn_my_admin.gif" alt="관리자" /></a>
<?php }elseif($TPL_VAR["login_info"]["type"]=="M"){?>
<p><a href="/admin_marketer"><img class="btn_my" src="/_template/skin/cs/basic/images/btn_my_marketer.gif" alt="영업자" /></a>
<?php }?>
<?php if($TPL_VAR["login_info"]["type"]!="G"){?>
<a href="../member/process/logout.php?prev=<?php echo $TPL_VAR["current_uri"]?>"><span>로그아웃</span></a></p>
<?php }?>
</div>
<!-- 탑 네비게이션 끝 -->
<!-- 글로벌 영역시작 -->
<div class="gnb">
<!-- 글로벌 영역 상단 시작 -->
<div class="gtop">
<h1><a href="../main/index.php"><img src="/_template/skin/cs/basic/images/logo.gif" alt="라이패스로고" title="라이패스" /></a></h1>
<h2><img src="/_template/skin/cs/basic/images/ls_title01.gif" alt="국가기술자격증 기사&산업기사"/></h2>
<p><!-- <a href="#"><img src="/_template/skin/cs/basic/images/gnb1.gif" alt="고객센터"/></a><a href="#"><img src="/_template/skin/cs/basic/images/gnb2.gif" alt="교육상담"/></a> --><a href="http://www.lipass.co.kr" id="bookmark" title="라이패스"><img src="/_template/skin/cs/basic/images/gnb3.gif" alt="즐겨찾기"/></a></p>
</div>
<!-- 글로벌 영역 상단 끝 -->
<form name="top_search_form" action="<?php echo $TPL_VAR["MY_URL"]?>web/main/search_list.php">
<!-- 글로벌 검색 영역 시작 -->
<div class="gsearch">
<dl>
<dt><img src="/_template/skin/cs/basic/images/lipasssearch.gif" alt="라이패스정보검색"/></dt>
<dd><input type="text" name="top_search"class="gsearchbox" maxlength="max" value="<?php echo $TPL_VAR["search_text"]?>"/><span class="blind">라이패스 정보 검색하기</span></dd>
<dd><input type="button" name="gsearchbtn"class="gsearchbtn" onclick="send_top_search()" /><span class="blind">라이패스 정보 검색 버튼</span></dd>
<dd class="sear_txt"><a href="#">주택관리사</a><span>|</span><a href="#">직업상담사2급</a><span>|</span><a href="#">사회복지사</a><span>|</span><a href="#">재경관리사</a></dd>
</dl>
<ul>
<li><a href="#"><img src="/_template/skin/cs/basic/images/gserbtn_lec.gif" alt="나의강의실"title="나의강의실"/></a></li>
</ul>
</div>
<!-- 글로벌 검색 영역 끝 -->
</form>
<!-- 글로벌 검색 영역 카테고리 시작 -->
<ul class="gcategory">
<li class="gcateA"><img src="/_template/skin/cs/basic/images/gcate6.gif" alt="전체과정" title="전체과정" onClick="toggle_top('gm_box');" onKeyPress="toggle_top('gm_box');" style="cursor:pointer;" /></li>
<li><a href="../board/index.php?bo_num=69627"><img src="/_template/skin/cs/basic/images/gcate7.gif" alt="수험정보" title="수험정보"/></a></li>
<li><a href="../content/index.php?cid=counseldown"><img src="/_template/skin/cs/basic/images/gcate2.gif" alt="학습자료실"title="학습자료실"/></a></li>
<li><a href="../teacher/index.php"><img src="/_template/skin/cs/basic/images/gcate4.gif" alt="교수소개"title="교수소개"/></a></li>
<li><a href="../board/index.php?bo_num=69624"><img src="/_template/skin/cs/basic/images/gcate3.gif" alt="참여마당"title="참여마당"/></a></li>
<li class="gcateB"><a href="../board/index.php?bo_num=69623"><img src="/_template/skin/cs/basic/images/gcate8.gif" alt="고객센터"title="고객센터"/></a></li>
</ul>
<!-- 글로벌 검색 영역 카테고리 끝 -->
</div>
<!-- 글로벌 영역 끝 -->
</div>
<!-- 헤더 영역 끝 -->