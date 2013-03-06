<?php /* Template_ 2.2.7 2013/01/10 17:19:39 C:\rosemary\trunk\src\rosemary\_template\skin\member\basic\my_info_chk.html 000002050 */ 
$TPL_menu_location_1=empty($TPL_VAR["menu_location"])||!is_array($TPL_VAR["menu_location"])?0:count($TPL_VAR["menu_location"]);?>
<link rel="stylesheet" type="text/css" href="/_template/skin/member/basic/css/mypage.css"/>
<script type="text/javascript">
function my_chk()
{
var f = document.my_info_chk_form;
if (!f.pwd.value) {
alert("비밀번호를 입력해 주세요.");
f.pwd.focus();
return;
} else {
f.action = "../../_process/my_page/pwd_chk.php";
f.submit();
}
}
</script>
<!-- LS 우측 컨텐츠  영역 시작 -->
<div class="s_r_area03">
<!-- LS 우측 컨텐츠  영역 헤드 시작 -->
<div class="sr_head03">
<h3><img src="/_template/skin/member/basic/images/mypage/privacy_title.gif" alt="개인정보수정" /></h3>
<p><?php if($TPL_menu_location_1){$TPL_I1=-1;foreach($TPL_VAR["menu_location"] as $TPL_V1){$TPL_I1++;?><?php if($TPL_I1> 0){?><span> &gt; </span><?php }?><span><?php echo $TPL_V1?></span><?php }}?></p>
</div>
<!-- LS 우측 컨텐츠  헤드 끝 -->
<!-- LS 우측 컨텐츠 로그인 시작 -->
<div class="sr_body03">
<form name="my_info_chk_form" method="post">
<!-- 개인정보수정 시작 -->
<div class="privacy">
<ul class="idpw">
<li><span>아이디</span><font><?php echo $TPL_VAR["mb_id"]?></font></li>
<li><span>비밀번호</span><input type="password" name="pwd" class="my_text02" maxlength="20" style="width:190px;" /></li>
</ul>
<p class="guide">
· 외부로부터 회원님의 정보를 안전하게 보호하기 위해 비밀번호를 다시 한번 확인 합니다. <br />
· 항상 비밀번호는 타인에게 노출되지 않도록 주의해 주세요.
</p>
</div>
<div class="pop_btn">
<input  class="red_btn03" type="button" value="다음" onclick="my_chk()" />
</div>
<!-- 개인정보수정 끝 -->
</form>
</div>
<!-- LS 우측 컨텐츠 로그인 끝 -->
</div>
<!-- LS 우측 컨텐츠  영역 끝 -->