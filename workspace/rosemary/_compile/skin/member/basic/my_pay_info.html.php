<?php /* Template_ 2.2.7 2013/01/16 15:57:09 C:\rosemary\trunk\src\rosemary\_template\skin\member\basic\my_pay_info.html 000008363 */ 
$TPL_menu_location_1=empty($TPL_VAR["menu_location"])||!is_array($TPL_VAR["menu_location"])?0:count($TPL_VAR["menu_location"]);
$TPL_goods_list_1=empty($TPL_VAR["goods_list"])||!is_array($TPL_VAR["goods_list"])?0:count($TPL_VAR["goods_list"]);
$TPL_book_list_1=empty($TPL_VAR["book_list"])||!is_array($TPL_VAR["book_list"])?0:count($TPL_VAR["book_list"]);?>
<link rel="stylesheet" type="text/css" href="/_template/skin/member/basic/css/mypage.css"/>
<script type="text/javascript">
function send_info_goods(g_num)
{
if (g_num) {
window.open("../goods/goods_view.php?g_num="+g_num,"","");
}
}
function send_info_book(bo_num)
{
if (bo_num) {
window.open("../goods/book_view.php?bo_num="+bo_num,"","");
}
}
function send_list(page)
{
document.location.href = "./my_pay.php?page="+page;
}
</script>
<!-- LS 우측 컨텐츠  영역 시작 -->
<div class="s_r_area03">
<!-- LS 우측 컨텐츠  영역 헤드 시작 -->
<div class="sr_head03">
<h3><img src="/_template/skin/member/basic/images/mypage/paylist_title.gif" alt="주문결제내역" /></h3>
<p><?php if($TPL_menu_location_1){$TPL_I1=-1;foreach($TPL_VAR["menu_location"] as $TPL_V1){$TPL_I1++;?><?php if($TPL_I1> 0){?><span> &gt; </span><?php }?><span><?php echo $TPL_V1?></span><?php }}?></p>
</div>
<!-- LS 우측 컨텐츠  헤드 끝 -->
<!-- LS 우측 컨텐츠 로그인 시작 -->
<div class="sr_body03">
<!-- 주문결제내역 시작 -->
<h3><img src="/_template/skin/member/basic/images/mypage/pay_subtitle01.gif" alt="주문번호" /><span><?php echo $TPL_VAR["os_num"]?></span></h3>
<div class="t_c"><img src="/_template/skin/member/basic/images/mypage/pay_img.gif" alt="주문번호" /></div>
<!-- 강의 시작 -->
<h4 class="subtitle_bg">강의</h4>
<table cellspacing="0" cellpadding="0" border="0" summary="board" class="my_bod">
<caption></caption>
<colgroup>
<col width="11%" />
<col width="59%" />
<col width="10%" />
<col width="20%" />
</colgroup>
<thead>
<tr>
<th>상품유형</th>
<th>구매한강의</th>
<th>가격</th>
<th>강의신청</th>
</tr>
</thead>
<tbody>
<?php if($TPL_VAR["goods_cnt"]> 0){?>
<?php if($TPL_goods_list_1){foreach($TPL_VAR["goods_list"] as $TPL_V1){?>
<tr>
<td><?php if($TPL_VAR["goods_type"]=="pack"){?><img src="/_template/skin/member/basic/images/mypage/img_sj03.gif" alt="패키지" /><?php }elseif($TPL_VAR["goods_type"]=="dan"){?><img src="/_template/skin/member/basic/images/mypage/img_sj02.gif" alt="단과" /><?php }else{?><img src="/_template/skin/member/basic/images/mypage/img_sj01.gif"/><?php }?></td>
<td class="t_l">
<b><?php echo $TPL_V1["name"]?></b>
<p class="td_re"><img src="/_template/skin/member/basic/images/mypage/blt03.gif" /> 정보통신기사 실기 50,000원</p>
<p class="td_re"><img src="/_template/skin/member/basic/images/mypage/blt03.gif" /> 정보통신기사 실기 50,000원</p>
</td>
<td class="v_t"><?php echo $TPL_V1["price"]?>원</td>
<td class="v_t"><input class="white_btn03" type="button" value="자세히보기" onclick="send_info_goods('<?php echo $TPL_V1["g_num"]?>')"/></td>
</tr>
<?php }}?>
<?php }?>
</tbody>
</table>
<!-- 강의 끝 -->
<!-- 교재 시작 -->
<h4 class="subtitle_bg">교재</h4>
<table cellspacing="0" cellpadding="0" border="0" summary="board" class="my_bod">
<caption></caption>
<colgroup>
<col width="55%" />
<col width="15%" />
<col width="10%" />
<col width="20%" />
</colgroup>
<thead>
<tr>
<th>구매한교재</th>
<th>수량</th>
<th>가격</th>
<th>강의신청</th>
</tr>
</thead>
<tbody>
<?php if($TPL_VAR["book_cnt"]> 0){?>
<?php if($TPL_book_list_1){foreach($TPL_VAR["book_list"] as $TPL_V1){?>
<tr>
<td class="t_l t_i"><b><?php echo $TPL_V1["bo_name"]?></b></td>
<td>1</td>
<td><?php echo $TPL_V1["price"]?>원</td>
<td><input onclick="send_info_book(<?php echo $TPL_V1["bo_num"]?>)" class="white_btn03" type="button" value="자세히보기" /></td>
</tr>
<?php }}?>
<?php }?>
</tbody>
</table>
<!-- 교재 끝 -->
<div class="my_pay">
<p>강좌금액 : <?php echo $TPL_VAR["goods_tot_price"]?>원 + 교재금액 : <?php echo $TPL_VAR["book_tot_price"]?>원 + 배송비 0원<br />
총결재금액 : <span><?php echo $TPL_VAR["tot_price"]?>원</span></p>
</div>
<!-- 결제정보 시작 -->
<h3><img src="/_template/skin/member/basic/images/mypage/pay_subtitle02.gif" alt="결제정보" /></h3>
<table cellspacing="0" cellpadding="0" border="0" summary="board" class="pr_bod">
<caption></caption>
<colgroup>
<col width="20%" />
<col width="30%" />
<col width="20%" />
<col width="30%" />
</colgroup>
<tbody>
<tr>
<th><img src="/_template/skin/member/basic/images/mypage/blt02.gif" /> 구매금액</th>
<td><b class="my_red"><?php echo $TPL_VAR["tot_price"]?>원</b></td>
<th class="b_l"><img src="/_template/skin/member/basic/images/mypage/blt02.gif" /> 지불방법</th>
<td><?php echo $TPL_VAR["os_type"]?></td>
</tr>
<tr>
<th><img src="/_template/skin/member/basic/images/mypage/blt02.gif" /> 입금자명</th>
<td>홍길동</td>
<th class="b_l"><img src="/_template/skin/member/basic/images/mypage/blt02.gif" /> 입금계좌</th>
<td><b class="my_org">우체국 1234-4567-78999</b></td>
</tr>
<tr>
<th><img src="/_template/skin/member/basic/images/mypage/blt02.gif" /> sms 발송</th>
<td colspan="3" class="v_a">
<input type="text" name="text" class="my_text" style="width:200px;" maxlength="13" /><span class="blind">연락처</span> <a href="#"><img src="/_template/skin/member/basic/images/mypage/btn_sms.gif" /></a>
</td>
</tr>
</tbody>
</table>
<!-- 결제정보 끝 -->
<!-- 배송고객정보 시작 -->
<h3><img src="/_template/skin/member/basic/images/mypage/pay_subtitle03.gif" alt="배송고객정보" /></h3>
<table cellspacing="0" cellpadding="0" border="0" summary="board" class="pr_bod">
<caption></caption>
<colgroup>
<col width="20%" />
<col width="80%" />
</colgroup>
<tbody>
<tr>
<th><img src="/_template/skin/member/basic/images/mypage/blt02.gif" /> 수취인</th>
<td><?php echo $TPL_VAR["osdi_name"]?></td>
</tr>
<tr>
<th><img src="/_template/skin/member/basic/images/mypage/blt02.gif" /> 전화번호</th>
<td><?php echo $TPL_VAR["osdi_tel"]?></td>
</tr>
<tr>
<th><img src="/_template/skin/member/basic/images/mypage/blt02.gif" /> 휴대폰번호</th>
<td><?php echo $TPL_VAR["osdi_hp"]?></td>
</tr>
<tr>
<th><img src="/_template/skin/member/basic/images/mypage/blt02.gif" /> 이메일</th>
<td><?php echo $TPL_VAR["osdi_email"]?></td>
</tr>
<tr>
<th><img src="/_template/skin/member/basic/images/mypage/blt02.gif" /> 배송지주소</th>
<td class="v_a">
<?php echo $TPL_VAR["osdi_addr"]?>
<a href="#"><img src="/_template/skin/member/basic/images/mypage/btn_post02.gif" /></a>
</td>
</tr>
<tr>
<th><img src="/_template/skin/member/basic/images/mypage/blt02.gif" /> 배송시 요청사항</th>
<td><?php echo $TPL_VAR["osdi_message"]?></td>
</tr>
</tbody>
</table>
<!-- 배송고객정보 끝 -->
<!-- 배송정보 시작 -->
<h3><img src="/_template/skin/member/basic/images/mypage/pay_subtitle04.gif" alt="배송정보" /></h3>
<table cellspacing="0" cellpadding="0" border="0" summary="board" class="pr_bod">
<caption></caption>
<colgroup>
<col width="20%" />
<col width="30%" />
<col width="20%" />
<col width="30%" />
</colgroup>
<tbody>
<tr>
<th><img src="/_template/skin/member/basic/images/mypage/blt02.gif" /> 배송상태</th>
<td><b class="my_red">배송대기</b></td>
<th class="b_l"><img src="/_template/skin/member/basic/images/mypage/blt02.gif" /> 배송일</th>
<td>2012-12-24</td>
</tr>
<tr>
<th><img src="/_template/skin/member/basic/images/mypage/blt02.gif" /> 택배사</th>
<td>로젠택배</td>
<th class="b_l"><img src="/_template/skin/member/basic/images/mypage/blt02.gif" /> 운송장번호</th>
<td>
<b class="my_org">012024549657</b>
<input name="" class="gray_btn04" type="button" value="배송조회" />
</td>
</tr>
</tbody>
</table>
<!-- 배송정보 끝 -->
<div class="pop_btn">
<input onclick="history.back();" class="gray_btn05" type="button" value="목록으로" />
</div>
<!-- 주문결제내역 끝 -->
</div>
<!-- LS 우측 컨텐츠 로그인 끝 -->
</div>