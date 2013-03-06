<?php /* Template_ 2.2.7 2012/12/12 17:36:15 C:\rosemary\trunk\src\rosemary\_template\skin\member\basic\login.html 000002507 */ 
$TPL_menu_location_1=empty($TPL_VAR["menu_location"])||!is_array($TPL_VAR["menu_location"])?0:count($TPL_VAR["menu_location"]);?>
<link rel="stylesheet" type="text/css" href="/_template/skin/member/basic/css/member.css"/>
<link rel="stylesheet" type="text/css" href="/_template/skin/member/basic/css/hack.css"/>
<!-- LS 우측 컨텐츠  영역 헤드 시작 -->
<div class="sr_head">
<h3><img src="/_template/skin/member/basic/images/member/login_title.gif" alt="로그인" /></h3>
<p><?php if($TPL_menu_location_1){$TPL_I1=-1;foreach($TPL_VAR["menu_location"] as $TPL_V1){$TPL_I1++;?><?php if($TPL_I1> 0){?><span> &gt; </span><?php }?><span><?php echo $TPL_V1?></span><?php }}?></p>
</div>
<!-- LS 우측 컨텐츠  헤드 끝 -->
<!-- LS 우측 컨텐츠 로그인 시작 -->
<div class="sr_body">
<!-- 로그인 시작 -->
<form method="post" action="../member/process/login.php">
<input type="hidden" name="return_uri" value="<?php echo $TPL_VAR["return_uri"]?>" />
<div class="login">
<dl>
<dt class="blind"><label for="uid">아이디</label></dt>
<dd><input type="text" name="id" class="text" maxlength="20" value="<?php echo $TPL_VAR["save_id"]?>" /></dd>
<dt class="blind"><label for="upwd">비밀번호</label></dt>
<dd><input type="password" name="pwd" class="text" maxlength="20" /></dd>
</dl>
<input type="image" src="/_template/skin/member/basic/images/member/btn_login.gif" alt="로그인" class="btn_login" />
<p class="login_btm">
<span class="btn_white"><a href="../member/idpw.php">아이디찾기</a></span>
<span class="btn_white"><a href="../member/idpw.php">비밀번호찾기</a></span>
<label><input type="checkbox" name="save_id" class="checkbox" value="Y"<?php if($TPL_VAR["save_id"]!=""){?> checked="checekd"<?php }?> /><img src="/_template/skin/member/basic/images/member/ch_id.gif" alt="아이디기억하기" /></label>
</p>
<p class="login_txt">
<span>아직 <?php echo $TPL_VAR["siteinfo"]["si_site_name"]?> 회원이 아니세요?<br />
회원으로 가입하시면 많은 혜택을 받으실 수 있습니다.</span>
<span class="btn_white02"><a href="../member/join.php">회원가입</a></span>
</p>
</div>
</form>
<!-- 로그인 끝 -->
<div class="left">
<img src="/_template/skin/member/basic/images/member/login_event.gif" alt="이벤트" />
</div>
</div>
<!-- LS 우측 컨텐츠 로그인 끝 -->