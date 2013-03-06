<?php /* Template_ 2.2.7 2013/01/03 15:58:03 C:\rosemary\trunk\src\rosemary\_template\skin\ls\basic\order.html 000025921 */ 
$TPL_goods_list_1=empty($TPL_VAR["goods_list"])||!is_array($TPL_VAR["goods_list"])?0:count($TPL_VAR["goods_list"]);
$TPL_book_list_1=empty($TPL_VAR["book_list"])||!is_array($TPL_VAR["book_list"])?0:count($TPL_VAR["book_list"]);
$TPL_site_account_list_1=empty($TPL_VAR["site_account_list"])||!is_array($TPL_VAR["site_account_list"])?0:count($TPL_VAR["site_account_list"]);?>
<link rel="stylesheet" type="text/css" href="/_template/skin/ls/basic/css/register.css"/>
<script language=javascript src="http://www.allthegate.com/plugin/AGSWallet_utf8.js"></script>
<script>
function catch_set(mode)
{
var f = document.join_form;
if (mode == "1") {
f.catch_member.value = "";
f.tel_1.value = "<?php echo $TPL_VAR["tel_1"]?>";
f.tel_2.value = "<?php echo $TPL_VAR["tel_2"]?>";
f.tel_3.value = "<?php echo $TPL_VAR["tel_3"]?>";
//f.hp_1.selet = "<?php echo $TPL_VAR["hp_2"]?>";
f.hp_2.value = "<?php echo $TPL_VAR["hp_2"]?>";
f.hp_3.value = "<?php echo $TPL_VAR["hp_3"]?>";
f.email_1.value = "<?php echo $TPL_VAR["email_1"]?>";
f.email_2.value = "<?php echo $TPL_VAR["email_2"]?>";
f.ms_zip1.value = "<?php echo $TPL_VAR["zip_code1"]?>";
f.ms_zip2.value = "<?php echo $TPL_VAR["zip_code2"]?>";
f.ms_address.value = "<?php echo $TPL_VAR["addr"]?>";
f.addr_2.value = "<?php echo $TPL_VAR["addr2"]?>";
f.catch_member.focus();
} else {
f.catch_member.value = "";
f.tel_1.value = "";
f.tel_2.value = "";
f.tel_3.value = "";
f.hp_2.value = "";
f.hp_3.value = "";
f.email_1.value = "";
f.email_2.value = "";
f.ms_zip1.value = "";
f.ms_zip2.value = "";
f.ms_address.value = "";
f.addr_2.value = "";
f.catch_member.focus();
}
}
</script>
<script language=javascript>
<!--
//////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 올더게이트 플러그인 설치를 확인합니다.
//////////////////////////////////////////////////////////////////////////////////////////////////////////////
StartSmartUpdate();
function Pay(form){
if(form.Flag.value == "enable"){
if(Check_Common(form) == true){
if(document.AGSPay == null || document.AGSPay.object == null){
alert("플러그인 설치 후 다시 시도 하십시오.");
}else{
form.DeviId.value = "9000400001";
if(parseInt(form.Amt.value) < 50000)
form.QuotaInf.value = "0";
else
form.QuotaInf.value = "0:2:3:4:5:6:7:8:9:10:11:12";
if(form.DeviId.value == "9000400002")
form.NointInf.value = "ALL";
if(MakePayMessage(form) == true){
Disable_Flag(form);
var openwin = window.open("../../../../agspay/AGS_progress.html","popup","width=300,height=160"); //"지불처리중"이라는 팝업창연결 부분
form.action="../../../../agspay/AGS_pay_ing.php"
form.submit();
}else{
alert("지불에 실패하였습니다.");// 취소시 이동페이지 설정부분
}
}
}
}
}
function Enable_Flag(form){
form.Flag.value = "enable"
}
function Disable_Flag(form){
form.Flag.value = "disable"
}
function Check_Common(form){
if(form.RcpNm.value == ""){
alert("받으시는분을 입력하십시오.");
form.RcpNm.focus();
return false;
}
else if(form.tel_1.value == "" || form.tel_2.value == "" || form.tel_3.value == ""){
alert("전화번호를 정확하게 입력해 주세요");
return false;
}
else if(form.hp_1.value == "" || form.hp_2.value == "" || form.hp_3.value == ""){
alert("핸드폰번호를 정확하게 입력해 주세요");
return false;
}
else if(form.email_1.value == "" || form.email_2.value == ""){
alert("이메일을 정확하게 입력해 주세요.");
return false;
}
else if(form.ms_zip1.value == "" || form.ms_zip1.value == ""){
alert("우편번호를 입력해 주세요.");
return false;
}
else if(form.ms_address.value == "" || form.addr_2.value == ""){
alert("주소를 정확하게 입력해 주세요.");
return false;
}
return true;
}
function Display(form){
if(form.Job.value == "onlycard" || form.TempJob.value == "onlycard"){
document.all.card_hp.style.display= "";
document.all.card.style.display= "";
document.all.hp.style.display= "none";
document.all.virtual.style.display= "none";
}else if(form.Job.value == "onlyhp" || form.TempJob.value == "onlyhp"){
document.all.card_hp.style.display= "";
document.all.card.style.display= "none";
document.all.hp.style.display= "";
document.all.virtual.style.display= "none";
}else if(form.Job.value == "onlyvirtual" || form.TempJob.value == "onlyvirtual" ){
document.all.card_hp.style.display= "none";
document.all.card.style.display= "";
document.all.hp.style.display= "none";
document.all.virtual.style.display= "";
}else if(form.Job.value == "onlyiche" || form.TempJob.value == "onlyiche"  ){
document.all.card_hp.style.display= "none";
document.all.card.style.display= "none";
document.all.hp.style.display= "none";
document.all.virtual.style.display= "none";
}else{
document.all.card_hp.style.display= "";
document.all.card.style.display= "";
document.all.hp.style.display= "";
document.all.virtual.style.display= "";
}
}
-->
</script>
<form name="join_form" method=post >
<!-- LS 우측 컨텐츠  영역 시작 -->
<div class="s_r_area02 m_left">
<!-- LS 우측 컨텐츠  영역 헤드 시작 -->
<div class="sr_head02">
<h3><img src="/_template/skin/ls/basic/images/sub/order_title.gif" alt="주문서작성" /></h3>
<p><span> HOME </span>><span> 수강신청 </span> > <span>주문서작성</span></p>
</div>
<!-- LS 우측 컨텐츠  헤드 끝 -->
<!-- LS 우측 컨텐츠 로그인 시작 -->
<div class="sr_body02">
<h4 class="re_h">
<img src="/_template/skin/ls/basic/images/sub/bod_blt.gif">회원님께서 주문하신 강좌 및 교재를 결제합니다. 아래 입력란에 정확히 기재해 주세요.<br />
<img src="/_template/skin/ls/basic/images/sub/bod_blt.gif">강의에 포함된 교재는 배송비가 무료입니다.<br />
<img src="/_template/skin/ls/basic/images/sub/bod_blt.gif">교재만 구입하는 경우 5만원 미만은 배송비(2,500원)가 부과됩니다.<br />
<img src="/_template/skin/ls/basic/images/sub/bod_blt.gif">동영상강의는 결제를 완료하신 후 [나의 강의실] 수강 예정강의에서 수강시작일을 설정해 주세요.
</h4>
<!-- 주문서작성 시작 -->
<div class="register">
<!-- 주문상품 시작 -->
<h3><img src="/_template/skin/ls/basic/images/sub/or_title01.gif" alt="주문상품" /></h3>
<?php if($TPL_VAR["goods_nums"]> 0){?>
<h4 class="h_bg">강의 주문</h4>
<table cellspacing="0" cellpadding="0" border="0" summary="board" class="re_bod or_style">
<caption></caption>
<colgroup>
<col width="15%" />
<col width="60%" />
<col width="10%" />
<col width="15%" />
</colgroup>
<tfoot class="or_foot">
<tr>
<td colspan="4"><img src="/_template/skin/ls/basic/images/sub/th_blt.gif" alt="" />강의주문합계 : <span class="ft_red"><?php echo $TPL_VAR["tot_lt_price"]?>원</span></td>
</tr>
</tfoot>
<thead>
<tr>
<th>유형</th>
<th>상품명</th>
<th>수강기간</th>
<th>금액</th>
</tr>
</thead>
<tbody>
<?php if($TPL_goods_list_1){foreach($TPL_VAR["goods_list"] as $TPL_V1){?>
<tr class="pack_h03">
<td><?php if($TPL_V1["g_type"]=="C"){?><img src="/_template/skin/ls/basic/images/sub/img_sj01.gif" alt="강좌" /><?php }else{?><img src="/_template/skin/ls/basic/images/sub/img_sj02.gif" alt="강좌" /><?php }?></td>
<td class="t_left"><b><?php echo $TPL_V1["lt_name"]?></b></td>
<td><?php echo $TPL_V1["lt_term"]?>일</td>
<td><?php echo $TPL_V1["number_format_h_price"]?>원</td>
</tr>
<?php }}?>
</tbody>
</table>
<?php }?>
<?php if($TPL_VAR["book_nums"]> 0){?>
<h4 class="h_bg">교재 주문</h4>
<table cellspacing="0" cellpadding="0" border="0" summary="board" class="re_bod or_style">
<caption></caption>
<colgroup>
<col width="71%" />
<col width="6%" />
<col width="8%" />
<col width="15%" />
</colgroup>
<tfoot class="or_foot">
<tr>
<td colspan="4"><img src="/_template/skin/ls/basic/images/sub/th_blt.gif" alt="" />교재주문합계 : <span class="ft_red"><?php echo $TPL_VAR["tot_book_price"]?>원</span></td>
</tr>
</tfoot>
<thead>
<tr>
<th>교재명</th>
<th>수량</th>
<th></th>
<th>금액</th>
</tr>
</thead>
<tbody>
<?php if($TPL_book_list_1){foreach($TPL_VAR["book_list"] as $TPL_V1){?>
<tr class="pack_h03">
<td class="t_left t_ind"><b><?php echo $TPL_V1["bo_name"]?></b></td>
<td>1</td>
<td class="t_left"><!--<a href="#"><img src="/_template/skin/ls/basic/images/sub/btn_re.gif" alt="" /></a>--></td>
<td><?php echo $TPL_V1["bo_selling_price"]?>원</td>
</tr>
<?php }}?>
</tbody>
</table>
<?php }?>
<div class="re_pay">
<p>주문금액 <?php echo $TPL_VAR["tot_price"]?>원 + 배송비 0원<br />
총결제금액 : <span><?php echo $TPL_VAR["tot_price"]?>원</span></p>
</div>
<!-- 주문상품 끝 -->
<!-- 주문고객정보 시작 -->
<h3><img src="/_template/skin/ls/basic/images/sub/or_title02.gif" alt="주문고객정보" /></h3>
<table cellspacing="0" cellpadding="0" border="0" summary="board" class="or_bod">
<caption></caption>
<colgroup>
<col width="20%" />
<col width="80%" />
</colgroup>
<tbody>
<tr>
<th><img src="/_template/skin/ls/basic/images/sub/th_blt.gif" /> 주문하시는분</th>
<td><?php echo $TPL_VAR["member_name"]?></td>
</tr>
<tr>
<th><img src="/_template/skin/ls/basic/images/sub/th_blt.gif" /> 배송지선택</th>
<td><input type="radio" name="catch_addr_set" class="re_radio" onclick="catch_set('1')"  checked/><label>기본배송지</label>&nbsp;
<input type="radio" name="catch_addr_set" class="re_radio" onclick="catch_set('2')" /><label>새로운배송지 입력</label></td>
</tr>
<tr>
<th><img src="/_template/skin/ls/basic/images/sub/th_blt.gif" /> 받으시는분</th>
<td><input type="text" name="RcpNm" class="re_text02" style="width:200px;" /></td>
</tr>
<tr>
<th><img src="/_template/skin/ls/basic/images/sub/th_blt.gif" /> 전화번호</th>
<td>
<input type="text" name="tel_1" class="re_text02" style="width:70px;" maxlength="4" value="<?php echo $TPL_VAR["tel_1"]?>" /> -
<input type="text" name="tel_2" class="re_text02" style="width:70px;" maxlength="4" value="<?php echo $TPL_VAR["tel_2"]?>" /><span class="blind">연락처</span> -
<input type="text" name="tel_3" class="re_text02" style="width:70px;" maxlength="4" value="<?php echo $TPL_VAR["tel_3"]?>" /><span class="blind">연락처</span>
</td>
</tr>
<tr>
<th><img src="/_template/skin/ls/basic/images/sub/th_blt.gif" /> 휴대폰번호</th>
<td>
<select style="width:70px;" name="hp_1">
<option value="010" <?php if($TPL_VAR["hp_1"]=="010"){?>selected<?php }?>>010</option>
<option value="011" <?php if($TPL_VAR["hp_1"]=="011"){?>selected<?php }?>>011</option>
<option value="016" <?php if($TPL_VAR["hp_1"]=="016"){?>selected<?php }?>>016</option>
<option value="017" <?php if($TPL_VAR["hp_1"]=="017"){?>selected<?php }?>>017</option>
<option value="018" <?php if($TPL_VAR["hp_1"]=="018"){?>selected<?php }?>>018</option>
<option value="019" <?php if($TPL_VAR["hp_1"]=="019"){?>selected<?php }?>>019</option>
</select>-
<input type="text" name="hp_2" class="re_text02" style="width:70px;" maxlength="4" value="<?php echo $TPL_VAR["hp_2"]?>" /><span class="blind">연락처</span> -
<input type="text" name="hp_3" class="re_text02" style="width:70px;" maxlength="4" value="<?php echo $TPL_VAR["hp_3"]?>" /><span class="blind">연락처</span>
</td>
</tr>
<tr class="or_con">
<th><img src="/_template/skin/ls/basic/images/sub/th_blt.gif" /> 이메일주소</th>
<td><input type="text" name="email_1" class="re_text02" style="width:110px;" maxlength="20" value="<?php echo $TPL_VAR["email_1"]?>" /><span class="blind">이메일</span> @
<input type="text" name="email_2" class="re_text02" style="width:140px;" maxlength="20" value="<?php echo $TPL_VAR["email_2"]?>" /><span class="blind">이메일</span>
<span class="or_txt"><b>확인완료</b></span>
<p class="or_txt"><input type="checkbox" name="checkbox" class="re_checkbox" /><label>뉴스레터 등 최신 정보를 이메일로 받겠습니다.</label></p>
</td>
</tr>
<tr class="or_con con_style">
<th><img src="/_template/skin/ls/basic/images/sub/th_blt.gif" /> 배송지주소</th>
<td>
<input type="text" name="ms_zip1" value="<?php echo $TPL_VAR["zip_code1"]?>" class="re_text02" style="width:70px;" maxlength="3" /><span class="blind">우편번호</span> -
<input type="text" name="ms_zip2" value="<?php echo $TPL_VAR["zip_code2"]?>" class="re_text02" style="width:70px;" maxlength="3" /><span class="blind">우편번호</span>
<a href="javascript:void(window.open('/admin/member/zipcode.php?zip1=ms_zip1&zip2=ms_zip2&form=join_form&add=ms_address', 'zipcode', 'status=no, scrollbars=yes, resizable=0, width=500, height=500'))"><img src="/_template/skin/ls/basic/images/sub/btn_post.gif" alt="우편번호찾기" /></a>
<p><input type="text" name="ms_address" class="re_text02" style="width:70%;" value="<?php echo $TPL_VAR["addr"]?>" /><span class="blind">주소</span></p>
<input type="text" name="addr_2" class="re_text02" style="width:70%;" value="<?php echo $TPL_VAR["addr2"]?>" /><span class="blind">주소</span>
<span class="or_txt">나머지 주소를 입력해주세요.</span>
</td>
</tr>
<tr class="or_con con_style">
<th><img src="/_template/skin/ls/basic/images/sub/th_blt.gif" /> 배송시 요청사항</th>
<td><textarea style="width:95%; height:60px;" rows="3" cols="20" name="Remark"></textarea><span class="blind">내용</span></td>
</tr>
</tbody>
</table>
<!-- 주문고객정보 끝 -->
<!-- 결제방법선택 시작 -->
<h3><img src="/_template/skin/ls/basic/images/sub/or_title03.gif" alt="결제방법선택" /></h3>
<table cellspacing="0" cellpadding="0" border="0" summary="board" class="or_bod">
<caption></caption>
<colgroup>
<col width="20%" />
<col width="80%" />
</colgroup>
<tbody>
<tr>
<th><img src="/_template/skin/ls/basic/images/sub/th_blt.gif" /> 결제방법</th>
<td>
<!--
<input type="radio" name="Job" value="card" class="re_radio" checked/><label>신용카드</label>&nbsp;
<input type="radio" name="Job" value="M" class="re_radio" /><label>무통장입금</label>&nbsp;
<input type="radio" name="Job" value="virtual" class="re_radio" /><label>가상계좌</label>
-->
<select name=Job style=width:150px onchange="javascript:Display(frmAGS_pay);">
<option value="virtual" selected>선택하십시오.
<option value="card">신용카드
<option value="iche">계좌이체
<option value="virtual">가상계좌
</select>
</td>
</tr>
<tr>
<th><img src="/_template/skin/ls/basic/images/sub/th_blt.gif" /> 무통장입금 결제계좌</th>
<td>
<select style="width:220px;">
<option value="입금계좌를 선택해주세요.">입금계좌를 선택해주세요.</option>
<?php if($TPL_site_account_list_1){foreach($TPL_VAR["site_account_list"] as $TPL_V1){?>
<option value="123-456-78999."><?php echo $TPL_V1["sa_num"]?></option>
<?php }}?>
</select>
</td>
</tr>
<tr>
<th><img src="/_template/skin/ls/basic/images/sub/th_blt.gif" /> 은행명</th>
<td><span id="bank_name">우리은행</span></td>
</tr>
<tr class="or_org">
<th><img src="/_template/skin/ls/basic/images/sub/th_blt.gif" /> 계좌번호</th>
<td><span id="bank_number">123-456-78999</span></td>
</tr>
<tr>
<th><img src="/_template/skin/ls/basic/images/sub/th_blt.gif" /> 예금주</th>
<td><span id="bank_username">(주)라이패스</span></td>
</tr>
<tr>
<th><img src="/_template/skin/ls/basic/images/sub/th_blt.gif" /> 입금자명</th>
<td>김길동</td>
</tr>
<tr class="or_red">
<th><img src="/_template/skin/ls/basic/images/sub/th_blt.gif" /> 입금액</th>
<td>150,000원</td>
</tr>
<tr>
<th><img src="/_template/skin/ls/basic/images/sub/th_blt.gif" /> 입금기한</th>
<td>2012년 9월 30일 (주문일 기준, <span class="ft_red">3일 이내 미입금시 자동 취소</span>됩니다 - 토,일,공휴일 제외)</td>
</tr>
<tr class="or_td">
<td colspan="2">
<p>[신용카드 결제시]</p>
1. 신용카드로 결제할 경우 결제승인과 동시에 내강의실에서 바로 강의를 수강할 수 있습니다. <br />
2. 최종 결제승인이 나기전에 전자결제창을 닫지 마시기 바랍니다.<br />
3. 전자금융거래 기본법에 따라 결제금액이 30만원 이상일 경우 전자상거래법에 의해 발급된 공인인증서를 이용하여 본인 확인을 거쳐야 결제를 할 수 있습니다.<br />
4. 결제승인은 되었으나 내강의실에서 강의를 수강하실 수 없는 경우 고객센터로 전화 주시면 확인후 즉시 해결하여 드리겠습니다.<br /><br />
<p>[무통장 입금, 가상계좌 결제시]</p>
1. 가상계좌는 주문시마다 새로운 입금계좌번호가 생성됩니다.<br />
2. 각각 주문하시는 경우 주문별로 생성되는 입금계좌로 따로 따로 입금하여 주십시오.<br />
3. 주문하신 후 지정하신 입금기한내에 입금하지 않으시면 생성된 입금계좌는 자동으로 없어집니다. 입금기한 이후 입금을 하시려면 재주문을 해주시기 바랍니다.<br />
4. 수강료 입금 후(15분 이내)입금 승인이 되며, 만약 입금승인 미처리 시 고객센터로 문의해 주시기 바랍니다.
</td>
</tr>
</tbody>
</table>
<!-- 결제방법선택 시작 -->
<p class="re_pay_btn"><input class="red_btn02" type="button" value="결제하기"onclick="javascript:Pay(join_form);" />
<input name="" class="gray_btn02" type="button" value="결제취소" /></p>
</div>
<!-- 주문서작성 끝 -->
</div>
<!-- LS 우측 컨텐츠 로그인 끝 -->
</div>
<!-- LS 우측 컨텐츠  영역 끝 -->
<!--결제시 필수 정보-->
<input type=hidden style=width:300px name=UserEmail maxlength=50 value="test@test.com">
<input type=hidden style=width:400px name=ags_logoimg_url maxlength=200 value="http://www.allthegate.com/hyosung/images/aegis_logo.gif">
<input type=hidden style=width:300px name=SubjectData value="업체명;판매상품;계산금액;2012.09.01 ~ 2012.09.30;">
<input type=hidden name=g_num value="<?php echo $TPL_VAR["g_num"]?>">
<input type=hidden name=set_pack_num maxlength=20 value="<?php echo $TPL_VAR["gp_num"]?>">
<input type=hidden name=set_goods_lt_num maxlength=20 value="<?php echo $TPL_VAR["set_goods_lt_num"]?>">
<input type=hidden name=set_book_bo_num maxlength=20 value="<?php echo $TPL_VAR["set_book_bo_num"]?>">
<input type=hidden name=UserId maxlength=20 value="<?php echo $TPL_VAR["mb_id"]?>">
<input type=hidden  name=OrdPhone maxlength=21 value="02-111-1111"> <!--주문자 연락처-->
<input type=hidden  name=RcpPhone maxlength=21 value="02-111-1111"> <!--받는사람 연락처-->
<input type=hidden style=width:300px name=OrdAddr maxlength=100 value="서울시 강남구 청담동"><!-- 주문자 주소-->
<input type=hidden style=width:300px name=DlvAddr maxlength=100 value="서울시 강남구 청담동"><!-- 받는사람 주소-->
<input type=hidden style=width:300px name=CardSelect value="">
<input type=hidden  name=OrdNm maxlength=40 value="<?php echo $TPL_VAR["member_name"]?>"> <!--주문자-->
<input type=hidden name=StoreId value="<?php echo $TPL_VAR["StoreId"]?>">
<input type=hidden name=StoreNm value="상점명">
<input type=hidden name=OrdNo value="<?php echo $TPL_VAR["OrdNo"]?>">
<input type=hidden name=ProdNm value="상품명">
<input type=text name=Amt value="<?php echo $TPL_VAR["pay_tot_price"]?>">
<input type=hidden name=MallUrl value="http://lipass.co.kr">
<!-- 스크립트 및 플러그인에서 값을 설정하는 Hidden 필드  !!수정을 하시거나 삭제하지 마십시오-->
<!-- 각 결제 공통 사용 변수 -->
<input type=hidden name=Flag value="enable">				<!-- 스크립트결제사용구분플래그 -->
<input type=text name=AuthTy value="">			<!-- 결제형태 -->
<input type=hidden name=SubTy value="">				<!-- 서브결제형태 -->
<input type=hidden name=AGS_HASHDATA value="<?php echo $TPL_VAR["AGS_HASHDATA"]?>">	<!-- 암호화 HASHDATA -->
<!-- 신용카드 결제 사용 변수 -->
<input type=hidden name=DeviId value="">			<!-- (신용카드공통)		단말기아이디 -->
<input type=hidden name=QuotaInf value="0">			<!-- (신용카드공통)		일반할부개월설정변수 -->
<input type=hidden name=NointInf value="NONE">		<!-- (신용카드공통)		무이자할부개월설정변수 -->
<input type=hidden name=AuthYn value="">			<!-- (신용카드공통)		인증여부 -->
<input type=hidden name=Instmt value="">			<!-- (신용카드공통)		할부개월수 -->
<input type=hidden name=partial_mm value="">		<!-- (ISP사용)			일반할부기간 -->
<input type=hidden name=noIntMonth value="">		<!-- (ISP사용)			무이자할부기간 -->
<input type=hidden name=KVP_RESERVED1 value="">		<!-- (ISP사용)			RESERVED1 -->
<input type=hidden name=KVP_RESERVED2 value="">		<!-- (ISP사용)			RESERVED2 -->
<input type=hidden name=KVP_RESERVED3 value="">		<!-- (ISP사용)			RESERVED3 -->
<input type=hidden name=KVP_CURRENCY value="">		<!-- (ISP사용)			통화코드 -->
<input type=hidden name=KVP_CARDCODE value="">		<!-- (ISP사용)			카드사코드 -->
<input type=hidden name=KVP_SESSIONKEY value="">	<!-- (ISP사용)			암호화코드 -->
<input type=hidden name=KVP_ENCDATA value="">		<!-- (ISP사용)			암호화코드 -->
<input type=hidden name=KVP_CONAME value="">		<!-- (ISP사용)			카드명 -->
<input type=hidden name=KVP_NOINT value="">			<!-- (ISP사용)			무이자/일반여부(무이자=1, 일반=0) -->
<input type=hidden name=KVP_QUOTA value="">			<!-- (ISP사용)			할부개월 -->
<input type=hidden name=CardNo value="">			<!-- (안심클릭,일반사용)	카드번호 -->
<input type=hidden name=MPI_CAVV value="">			<!-- (안심클릭,일반사용)	암호화코드 -->
<input type=hidden name=MPI_ECI value="">			<!-- (안심클릭,일반사용)	암호화코드 -->
<input type=hidden name=MPI_MD64 value="">			<!-- (안심클릭,일반사용)	암호화코드 -->
<input type=hidden name=ExpMon value="">			<!-- (일반사용)			유효기간(월) -->
<input type=hidden name=ExpYear value="">			<!-- (일반사용)			유효기간(년) -->
<input type=hidden name=Passwd value="">			<!-- (일반사용)			비밀번호 -->
<input type=hidden name=SocId value="">				<!-- (일반사용)			주민등록번호/사업자등록번호 -->
<!-- 계좌이체 결제 사용 변수 -->
<input type=hidden name=ICHE_OUTBANKNAME value="">	<!-- 이체계좌은행명 -->
<input type=hidden name=ICHE_OUTACCTNO value="">	<!-- 이체계좌예금주주민번호 -->
<input type=hidden name=ICHE_OUTBANKMASTER value=""><!-- 이체계좌예금주 -->
<input type=hidden name=ICHE_AMOUNT value="">		<!-- 이체금액 -->
<!-- 핸드폰 결제 사용 변수 -->
<input type=hidden name=HP_SERVERINFO value="">		<!-- 서버정보 -->
<input type=hidden name=HP_HANDPHONE value="">		<!-- 핸드폰번호 -->
<input type=hidden name=HP_COMPANY value="">		<!-- 통신사명(SKT,KTF,LGT) -->
<input type=hidden name=HP_IDEN value="">			<!-- 인증시사용 -->
<input type=hidden name=HP_IPADDR value="">			<!-- 아이피정보 -->
<!-- ARS 결제 사용 변수 -->
<input type=hidden name=ARS_PHONE value="">			<!-- ARS번호 -->
<input type=hidden name=ARS_NAME value="">			<!-- 전화가입자명 -->
<!-- 가상계좌 결제 사용 변수 -->
<input type=hidden name=ZuminCode value="">			<!-- 가상계좌입금자주민번호 -->
<input type=hidden name=VIRTUAL_CENTERCD value="">	<!-- 가상계좌은행코드 -->
<input type=hidden name=VIRTUAL_NO value="">		<!-- 가상계좌번호 -->
<input type=hidden name=mTId value="">
<!-- 에스크로 결제 사용 변수 -->
<input type=hidden name=ES_SENDNO value="">			<!-- 에스크로전문번호 -->
<!-- 계좌이체(소켓) 결제 사용 변수 -->
<input type=hidden name=ICHE_SOCKETYN value="">		<!-- 계좌이체(소켓) 사용 여부 -->
<input type=hidden name=ICHE_POSMTID value="">		<!-- 계좌이체(소켓) 이용기관주문번호 -->
<input type=hidden name=ICHE_FNBCMTID value="">		<!-- 계좌이체(소켓) FNBC거래번호 -->
<input type=hidden name=ICHE_APTRTS value="">		<!-- 계좌이체(소켓) 이체 시각 -->
<input type=hidden name=ICHE_REMARK1 value="">		<!-- 계좌이체(소켓) 기타사항1 -->
<input type=hidden name=ICHE_REMARK2 value="">		<!-- 계좌이체(소켓) 기타사항2 -->
<input type=hidden name=ICHE_ECWYN value="">		<!-- 계좌이체(소켓) 에스크로여부 -->
<input type=hidden name=ICHE_ECWID value="">		<!-- 계좌이체(소켓) 에스크로ID -->
<input type=hidden name=ICHE_ECWAMT1 value="">		<!-- 계좌이체(소켓) 에스크로결제금액1 -->
<input type=hidden name=ICHE_ECWAMT2 value="">		<!-- 계좌이체(소켓) 에스크로결제금액2 -->
<input type=hidden name=ICHE_CASHYN value="">		<!-- 계좌이체(소켓) 현금영수증발행여부 -->
<input type=hidden name=ICHE_CASHGUBUN_CD value="">	<!-- 계좌이체(소켓) 현금영수증구분 -->
<input type=hidden name=ICHE_CASHID_NO value="">	<!-- 계좌이체(소켓) 현금영수증신분확인번호 -->
<!-- 텔래뱅킹-계좌이체(소켓) 결제 사용 변수 -->
<input type=hidden name=ICHEARS_SOCKETYN value="">	<!-- 텔레뱅킹계좌이체(소켓) 사용 여부 -->
<input type=hidden name=ICHEARS_ADMNO value="">		<!-- 텔레뱅킹계좌이체 승인번호 -->
<input type=hidden name=ICHEARS_POSMTID value="">	<!-- 텔레뱅킹계좌이체 이용기관주문번호 -->
<input type=hidden name=ICHEARS_CENTERCD value="">	<!-- 텔레뱅킹계좌이체 은행코드 -->
<input type=hidden name=ICHEARS_HPNO value="">		<!-- 텔레뱅킹계좌이체 휴대폰번호 -->
</form>