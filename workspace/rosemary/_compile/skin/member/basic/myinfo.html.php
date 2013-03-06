<?php /* Template_ 2.2.7 2013/01/14 16:41:00 C:\rosemary\trunk\src\rosemary\_template\skin\member\basic\myinfo.html 000007737 */ 
$TPL_menu_location_1=empty($TPL_VAR["menu_location"])||!is_array($TPL_VAR["menu_location"])?0:count($TPL_VAR["menu_location"]);
$TPL_tel_host_1=empty($TPL_VAR["tel_host"])||!is_array($TPL_VAR["tel_host"])?0:count($TPL_VAR["tel_host"]);
$TPL_hp_host_1=empty($TPL_VAR["hp_host"])||!is_array($TPL_VAR["hp_host"])?0:count($TPL_VAR["hp_host"]);?>
<script type="text/javascript" src="/_template/skin/member/basic/js/joincon.js"></script>
<link rel="stylesheet" type="text/css" href="/_template/skin/member/basic/css/member.css"/>
<link rel="stylesheet" type="text/css" href="/_template/skin/member/basic/css/hack.css"/>
<!-- LS 우측 컨텐츠  영역 헤드 시작 -->
<div class="sr_head">
<h3>개인정보수정</h3>
<p><?php if($TPL_menu_location_1){$TPL_I1=-1;foreach($TPL_VAR["menu_location"] as $TPL_V1){$TPL_I1++;?><?php if($TPL_I1> 0){?><span> &gt; </span><?php }?><span><?php echo $TPL_V1?></span><?php }}?></p>
</div>
<!-- LS 우측 컨텐츠  헤드 끝 -->
<!-- LS 우측 컨텐츠 회원가입 시작 -->
<div class="sr_body">
<input type="hidden" name="birthday_1" id="birthday_1" value="<?php echo $TPL_VAR["ms_birthday_1"]?>">
<input type="hidden" name="birthday_2" id="birthday_2" value="<?php echo $TPL_VAR["ms_birthday_2"]?>">
<input type="hidden" name="birthday_3" id="birthday_3" value="<?php echo $TPL_VAR["ms_birthday_3"]?>">
<!-- 회원가입 시작 -->
<form name="join_form" id="join_form" method="post" action="joinend.php">
<input name="email1" type="hidden" value="<?php echo $TPL_VAR["email1"]?>" />
<input name="email2" type="hidden" value="<?php echo $TPL_VAR["email2"]?>" />
<div class="join">
<table cellspacing="0" cellpadding="0" border="0" summary="board" class="bod_02 m_top">
<caption></caption>
<colgroup>
<col width="20%" />
<col width="80%" />
</colgroup>
<tbody>
<tr class="con">
<th><img src="/_template/skin/member/basic/images/member/th_blt.gif" />아이디</th>
<td>
<?php echo $TPL_VAR["mb_id"]?>
</td>
</tr>
<tr class="con">
<th><img src="/_template/skin/member/basic/images/member/th_blt.gif" />이름</th>
<td>
<input type="text" name="mb_name" class="text" style="width:100px;" maxlength="20" value="<?php echo $TPL_VAR["mb_name"]?>" /><span class="blind">이름</span>
<p class="s_txt">※ 반드시 실명을 사용하여주세요. 실명이 아닌 이름을 사용하여 생기는 불이익은 본인 책임입니다.</p>
</td>
</tr>
<tr class="con">
<th><img src="/_template/skin/member/basic/images/member/th_blt.gif" />생년월일</th>
<td>
<select name="birth_year" id="birth_year">
</select><span>년</span> &nbsp;
<select name="birth_month" id="birth_month">
<option value="1">1</option>
<option value="2">2</option>
<option value="3">3</option>
<option value="4">4</option>
<option value="5">5</option>
<option value="6">6</option>
<option value="7">7</option>
<option value="8">8</option>
<option value="9">9</option>
<option value="10">10</option>
<option value="11">11</option>
<option value="12">12</option>
</select><span>월</span> &nbsp;
<select name="birth_day" id="birth_day">
</select><span>일</span> &nbsp;
</td>
</tr>
<tr class="con">
<th><img src="/_template/skin/member/basic/images/member/th_blt.gif" />성별</th>
<td>
<label><input type="radio" name="ms_sex" class="checkbox" value="여성" <?php if($TPL_VAR["ms_sex"]=="여성"){?>checked<?php }?>/>여성</label>&nbsp;&nbsp;
<label><input type="radio" name="ms_sex" class="checkbox" value="남성" <?php if($TPL_VAR["ms_sex"]=="남성"){?>checked<?php }?> />남성</label>
</td>
</tr>
<tr class="con">
<th><img src="/_template/skin/member/basic/images/member/th_blt.gif" />이메일주소</th>
<td><input type="text" class="text" style="width:100px;" maxlength="20" disabled="disabled" value="<?php echo $TPL_VAR["email1"]?>" /><span>@</span>
<input type="text" class="text" style="width:100px;" maxlength="20" disabled="disabled" value="<?php echo $TPL_VAR["email2"]?>" />
<p class="s_txt">
<label><input type="checkbox" name="ms_email_yn" class="checkbox" value="Y" <?php if($TPL_VAR["ms_email_yn"]=="Y"){?>checked<?php }?>/> 뉴스레터 등 최신 정보를 이메일로 받겠습니다.</label>
</p>
</td>
</tr>
<tr class="con">
<th rowspan="2"><img src="/_template/skin/member/basic/images/member/th_blt.gif" />연락처<p>1개 이상 필수 입력</p></th>
<td><span>일반전화</span> &nbsp;
<select name="mb_tel1" style="width:60px;">
<?php if($TPL_tel_host_1){foreach($TPL_VAR["tel_host"] as $TPL_V1){?>
<option value="<?php echo $TPL_V1?>" <?php if($TPL_VAR["mb_tel_1"]==$TPL_V1){?>selected<?php }?>><?php echo $TPL_V1?></option>
<?php }}?>
</select><span>-</span>
<input type="text" name="mb_tel2" class="text" style="width:50px; ime-mode:disabled;" maxlength="4" value="<?php echo $TPL_VAR["mb_tel_2"]?>" /><span class="blind">일반전화</span><span>-</span>
<input type="text" name="mb_tel3" class="text" style="width:50px; ime-mode:disabled;" maxlength="4" value="<?php echo $TPL_VAR["mb_tel_3"]?>" /><span class="blind">일반전화</span>
</td>
</tr>
<tr class="con">
<td><span>휴대전화</span> &nbsp;
<select name="mb_hp1" style="width:60px;">
<?php if($TPL_hp_host_1){foreach($TPL_VAR["hp_host"] as $TPL_V1){?>
<option value="<?php echo $TPL_V1?>" <?php if($TPL_VAR["mb_hp_1"]==$TPL_V1){?>selected<?php }?>><?php echo $TPL_V1?></option>
<?php }}?>
</select><span>-</span>
<input type="text" name="mb_hp2" class="text" style="width:50px; ime-mode:disabled;" maxlength="4" value="<?php echo $TPL_VAR["mb_hp_2"]?>" /><span class="blind">휴대전화</span><span>-</span>
<input type="text" name="mb_hp3" class="text" style="width:50px; ime-mode:disabled;" maxlength="4" value="<?php echo $TPL_VAR["mb_hp_3"]?>" /><span class="blind">휴대전화</span>
<p class="s_txt02">
<label><input type="checkbox" name="ms_sms_yn" class="checkbox" value="Y" <?php if($TPL_VAR["ms_sms_yn"]=="Y"){?>checked<?php }?>  /> SMS 수신을 선택하시면 다양한 이벤트와 시험정보를 받아보실 수 있습니다.</label><br />
<span class="s_txt03">(<font>거래정보</font>와 관련된 내용은 거래 안전을 위하여 <font>수신동의 여부와 관계없이</font> 발송 됩니다.)</span>
</p>
</td>
</tr>
<tr class="con">
<th>주소</th>
<td>
<input type="text" name="ms_zip1" class="text" style="width:50px;" maxlength="3" value="<?php echo $TPL_VAR["zip_1"]?>" /><span class="blind">우편번호</span><span>-</span>
<input type="text" name="ms_zip2" class="text" style="width:50px;" maxlength="3" value="<?php echo $TPL_VAR["zip_2"]?>" /><span class="blind">우편번호</span>
<a href="javascript:void(window.open('/admin/member/zipcode.php?zip1=ms_zip1&zip2=ms_zip2&form=join_form&add=ms_address', 'zipcode', 'status=no, scrollbars=yes, resizable=0, width=500, height=500'))"><img src="/_template/skin/member/basic/images/member/btn_post.gif" alt="우편번호찾기" /></a><br />
<p class="l_h">
<input type="text" name="ms_address" class="text" style="width:70%;" value="<?php echo $TPL_VAR["ms_address"]?>"/><span class="blind">주소</span><br />
<input type="text" name="ms_address_detail" class="text" style="width:70%;" value="<?php echo $TPL_VAR["ms_address_detail"]?>" /><span class="blind">주소</span>
<span>나머지 주소를 입력해주세요.</span>
</p>
</td>
</tr>
</tbody>
</table>
<div class="join_btn">
<span class="btn_rad"><a href="javascript:submit_modi_check()">정보 수정</a></span>
</div>
</div>
</form>
<!-- 회원가입 끝 -->
</div>
<!-- LS 우측 컨텐츠 회원가입 끝 -->