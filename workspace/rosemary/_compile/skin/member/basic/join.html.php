<?php /* Template_ 2.2.7 2012/12/14 10:50:43 C:\rosemary\trunk\src\rosemary\_template\skin\member\basic\join.html 000002392 */ 
$TPL_menu_location_1=empty($TPL_VAR["menu_location"])||!is_array($TPL_VAR["menu_location"])?0:count($TPL_VAR["menu_location"]);?>
<script type="text/javascript" src="/_template/skin/member/basic/js/join.js"></script>
<link rel="stylesheet" type="text/css" href="/_template/skin/member/basic/css/member.css"/>
<link rel="stylesheet" type="text/css" href="/_template/skin/member/basic/css/hack.css"/>
<!-- LS 우측 컨텐츠  영역 헤드 시작 -->
<div class="sr_head">
<h3><img src="/_template/skin/member/basic/images/member/join_title.gif" alt="회원가입" /></h3>
<p><?php if($TPL_menu_location_1){$TPL_I1=-1;foreach($TPL_VAR["menu_location"] as $TPL_V1){$TPL_I1++;?><?php if($TPL_I1> 0){?><span> &gt; </span><?php }?><span><?php echo $TPL_V1?></span><?php }}?><span> &gt; </span><span>약관동의</span></p>
</div>
<!-- LS 우측 컨텐츠  헤드 끝 -->
<!-- LS 우측 컨텐츠 회원가입 시작 -->
<div class="sr_body">
<!-- 회원가입 시작 -->
<img class="process" src="/_template/skin/member/basic/images/member/join_tab01.gif" alt="약관동의" />
<div class="join">
<h3><img src="/_template/skin/member/basic/images/member/join_subtitle01.gif" alt="약관동의" /></h3>
<h6><img src="/_template/skin/member/basic/images/member/join_txt01.gif" alt="라이패스이용약관" /></h6>
<div class="join_txt">
<div class="join_main">
<?php echo $TPL_VAR["clause"]?>
</div>
</div>
<p class="join_cbox"><label><input type="checkbox" name="checkbox_clause" class="checkbox"/><?php echo $TPL_VAR["siteinfo"]["si_site_name"]?> 이용약관에 동의합니다.</label></p>
<h6><img src="/_template/skin/member/basic/images/member/join_txt02.gif" alt="개인정보수집및이용에대한안내" /></h6>
<div class="join_txt">
<div class="join_main">
<?php echo $TPL_VAR["privacy"]?>
</div>
</div>
<p class="join_cbox"><label><input type="checkbox" name="checkbox_privacy" class="checkbox"/>개인정보 수집 및 이용에 동의합니다.</label></p>
<div class="join_btn">
<span class="btn_rad"><a href="javascript:joincheck()">동의</a></span>
<span class="btn_gray"><a href="../main/index.php">취소</a></span>
</div>
</div>
<!-- 회원가입 끝 -->
</div>
<!-- LS 우측 컨텐츠 회원가입 끝 -->