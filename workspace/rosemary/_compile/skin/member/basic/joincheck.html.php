<?php /* Template_ 2.2.7 2012/12/14 10:50:43 C:\rosemary\trunk\src\rosemary\_template\skin\member\basic\joincheck.html 000002568 */ 
$TPL_menu_location_1=empty($TPL_VAR["menu_location"])||!is_array($TPL_VAR["menu_location"])?0:count($TPL_VAR["menu_location"]);
$TPL_email_host_1=empty($TPL_VAR["email_host"])||!is_array($TPL_VAR["email_host"])?0:count($TPL_VAR["email_host"]);?>
<script type="text/javascript" src="/_template/skin/member/basic/js/joincheck.js"></script>
<script type="text/javascript" src="/_template/skin/member/basic/js/emailcheck.js"></script>
<link rel="stylesheet" type="text/css" href="/_template/skin/member/basic/css/member.css"/>
<link rel="stylesheet" type="text/css" href="/_template/skin/member/basic/css/hack.css"/>
<!-- LS 우측 컨텐츠  영역 헤드 시작 -->
<div class="sr_head">
<h3><img src="/_template/skin/member/basic/images/member/join_title.gif" alt="회원가입" /></h3>
<p><?php if($TPL_menu_location_1){$TPL_I1=-1;foreach($TPL_VAR["menu_location"] as $TPL_V1){$TPL_I1++;?><?php if($TPL_I1> 0){?><span> &gt; </span><?php }?><span><?php echo $TPL_V1?></span><?php }}?><span> &gt; </span><span>가입여부확인</span></p>
</div>
<!-- LS 우측 컨텐츠  헤드 끝 -->
<!-- LS 우측 컨텐츠 회원가입 시작 -->
<div class="sr_body">
<!-- 회원가입 시작 -->
<img src="/_template/skin/member/basic/images/member/join_tab02.gif" alt="가입여부확인" />
<div class="join">
<h3>
<img src="/_template/skin/member/basic/images/member/join_subtitle02.gif" alt="가입여부확인" />
<img src="/_template/skin/member/basic/images/member/join_titletxt01.gif" alt="가입여부확인설명" class="right" />
</h3>
<form method="post" id="join_form" action="../member/joincon.php">
<div class="join_txt02">
<p><font>이메일주소</font>
<input type="text" name="email1" id="email1" class="text" style="width:140px; ime-mode:disabled;" /><font>@</font>
<input type="text" name="email2" id="email2" class="text" style="width:190px; ime-mode:disabled;" />
<select id="email_host" style="width:150px;">
<option value="">직접입력</option>
<?php if($TPL_email_host_1){foreach($TPL_VAR["email_host"] as $TPL_V1){?>
<option value="<?php echo $TPL_V1?>"><?php echo $TPL_V1?></option>
<?php }}?>
</select>
</p>
</div>
<div class="join_btn">
<span class="btn_rad"><a href="javascript:emailcheck()">다음</a></span>
<span class="btn_gray"><a href="../main">취소</a></span>
</div>
</form>
</div>
<!-- 회원가입 끝 -->
</div>
<!-- LS 우측 컨텐츠 회원가입 끝 -->