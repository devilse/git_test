<?php /* Template_ 2.2.7 2013/01/16 12:04:16 C:\rosemary\trunk\src\rosemary\_template\skin\member\basic\my_pay.html 000004592 */ 
$TPL_menu_location_1=empty($TPL_VAR["menu_location"])||!is_array($TPL_VAR["menu_location"])?0:count($TPL_VAR["menu_location"]);
$TPL_list_1=empty($TPL_VAR["list"])||!is_array($TPL_VAR["list"])?0:count($TPL_VAR["list"]);?>
<script type="text/javascript">
function refund_go(val,page)
{
window.open("./refund.php?os_num="+val+"&page="+page,"lipass_refund","width=490,height=619");
}
function my_pay_info_view(os_num,page)
{
document.location.href="./my_pay_info.php?os_num="+os_num+"&page="+page;
}
</script>
<link rel="stylesheet" type="text/css" href="/_template/skin/member/basic/css/mypage.css"/>
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
<div class="my_tab">
<ul class="my_tab_list">
<li class="my_tab_00"><h3><a href="?">주문결제내역</a></h3></li>
<li class="my_tab_01"><h3><a href="./refund_list.php">환불내역</a></h3></li>
</ul>
</div>
<table cellspacing="0" cellpadding="0" border="0" summary="board" class="my_bod my_style">
<caption></caption>
<colgroup>
<col width="12%" />
<col width="12%" />
<col width="28%" />
<col width="12%" />
<col width="12%" />
<col width="12%" />
<col width="12%" />
</colgroup>
<thead>
<tr>
<th>주문번호</th>
<th>주문일자</th>
<th>구매한강의/교재</th>
<th>결재금액</th>
<th>입금상태</th>
<th>배송상태</th>
<th>환불/취소</th>
</tr>
</thead>
<tfoot>
<tr>
<td colspan="7">
<ul class="my_pagelist">
<?php echo $TPL_VAR["list_page"]?>
</ul>
</td>
</tr>
</tfoot>
<tbody>
<?php if($TPL_VAR["tot_cnt"]> 0){?>
<?php if($TPL_list_1){foreach($TPL_VAR["list"] as $TPL_V1){?>
<tr>
<td><p><?php echo $TPL_V1["os_num"]?></p><input class="white_btn04" type="button" value="상세보기" onclick="my_pay_info_view('<?php echo $TPL_V1["os_num"]?>','<?php echo $TPL_VAR["page"]?>')" /></td>
<td><?php echo $TPL_V1["os_regdate"]?></td>
<td class="m_td"><b><?php echo $TPL_V1["my_goods"]?> <?php if($TPL_V1["goods_cnt"]> 1){?>외 <?php echo $TPL_V1["goods_cnt"]?>건<?php }?> <?php if($TPL_V1["book_cnt"]> 0){?>/ <?php echo $TPL_V1["book_cnt"]?>권<?php }?></b></td>
<td><b class="my_red f_s">\<?php echo $TPL_V1["os_amt"]?></b></td>
<td><?php echo $TPL_V1["os_text"]?></td>
<td>배송준비중<br /><input name="" class="gray_btn04" type="button" value="배송조회" style="font-size:1em;" /></td>
<td><?php echo $TPL_V1["os_state"]?></td>
</tr>
<?php }}?>
<?php }else{?>
<tr>
<td colspan="7">결제한 내역이 없습니다.</td>
</tr>
<?php }?>
</tbody>
</table>
<ul class="my_ul">
<li class="my_red f_s"><b>[환불 취소안내]</b></li>
<li>1. 입금 확인중의 강의는 바로 취소가 가능 합니다.</li>
<li>2. 수강생이 수강료를 카드로 결재 승인하였을 경우 카드수수료(카드사마다 상이함)를 공제한 후 환불합니다.</li>
<li>3. 수강료 환불 시 발생되는 각종 세금을 공제한 후 환불합니다.</li>
<li>4. 수강료(강좌)에 대한 환불은 승인일로부터 14일 이내이고 맛보기 강좌(샘플강좌)를 제외하고 3강 이하를 수강한 경우에만 환불이 가능합니다.<br />(수강자가 이용한 강의정지기간에도 사용기간으로 인정함)</li>
<li>5. 회원이 수강 중인 강좌는 다른 강좌로 직접 변경은 불가능하므로, 강좌 변경 요청을 원하는 경우, 변경하고자 하는 강좌를 먼저 취소 후 원하는 강좌로 재신청 하여야 합니다. 단, 이 경우도 1항의 환불기준이 적용됨을 원칙으로 합니다. (회사에서 타당성이 인정되면 환불기준적용안함)</li>
<li>6. 교재가 파본인 경우, 환불/교환이 가능합니다.</li>
<li>7. 환불은 결제수단에 따라 결제취소 또는 고객계좌로 현금 입금등의 여러방식이 있습니다.</li>
</ul>
<!-- 주문결제내역 끝 -->
</div>
<!-- LS 우측 컨텐츠 로그인 끝 -->
</div>