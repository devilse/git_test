<?php /* Template_ 2.2.7 2012/12/28 11:25:49 C:\rosemary\trunk\src\rosemary\_template\skin\ls\basic\package_view.html 000006541 */ 
$TPL_menu_location_1=empty($TPL_VAR["menu_location"])||!is_array($TPL_VAR["menu_location"])?0:count($TPL_VAR["menu_location"]);
$TPL_goods_loop_1=empty($TPL_VAR["goods_loop"])||!is_array($TPL_VAR["goods_loop"])?0:count($TPL_VAR["goods_loop"]);
$TPL_book_loop_1=empty($TPL_VAR["book_loop"])||!is_array($TPL_VAR["book_loop"])?0:count($TPL_VAR["book_loop"]);?>
<link rel="stylesheet" type="text/css" href="/_template/skin/ls/basic/css/register.css"/>
<script src="/_js/goods.js" type="text/javascript"></script>
<script>
function sel_book(val){
var book_money=document.getElementById('book_money');
var tot_money=document.getElementById('tot_money');
var wan_price=document.getElementById('wan_price');
var f = document.view_form;
var end_for = f.chk_list.length;
var price = 0;
for (i=0;i<end_for;i++) {
if (f.chk_list[i].checked==true) {
var set_price = parseInt(f.chk_list[i].value);
price = price + set_price;
}
}
book_money.innerHTML = setComma(price);
tot_money.innerHTML = setComma(parseInt(f.h_price.value) + price);
wan_price.value = price;
}
</script>
<input type="hidden" name="wan_price" value="<?php echo $TPL_VAR["h_price"]?>" id="wan_price">
<input type="hidden" name="wan_book" id="wan_book" value="0">
<form name="pack_form" method="post">
<input type="hidden" name="gp_num" value="<?php echo $TPL_VAR["gp_num"]?>">
<!-- LS 우측 컨텐츠  영역 시작 -->
<div class="s_r_area02 m_left">
<!-- LS 우측 컨텐츠  영역 헤드 시작 -->
<div class="sr_head02">
<h3><img src="/_template/skin/ls/basic/images/sub/registercon_title.gif" alt="상세보기" /></h3>
<p><?php if($TPL_menu_location_1){$TPL_I1=-1;foreach($TPL_VAR["menu_location"] as $TPL_V1){$TPL_I1++;?><?php if($TPL_I1> 0){?><span> &gt; </span><?php }?><span><?php echo $TPL_V1?></span><?php }}?></p>
</div>
<!-- LS 우측 컨텐츠  헤드 끝 -->
<!-- LS 우측 컨텐츠 로그인 시작 -->
<div class="sr_body02">
<!-- 상세보기 시작 -->
<div class="register">
<h2><?php echo $TPL_VAR["gp_name"]?>&nbsp; <img src="/_template/skin/ls/basic/images/sub/img_sj03.gif" alt="패키지" /></h2>
<div class="re_pack">
<img src="/_template/skin/ls/basic/images/sub/p_tit_top.gif" alt="" />
<!-- 패키지타이틀 시작 -->
<div class="p_tit">
<?php echo $TPL_VAR["gp_explanation"]?>
</div>
<!-- 패키지타이틀 끝 -->
<img src="/_template/skin/ls/basic/images/sub/p_tit_bottom.gif" alt="" />
<div class="info_01">
<table cellspacing="0" cellpadding="0" border="0" summary="board" class="package_bod pack_w">
<caption></caption>
<colgroup>
<col width="20%" />
<col width="80%" />
</colgroup>
<tbody>
<tr>
<th>강의구성</th>
<td><?php echo $TPL_VAR["set_goods"]?></td>
</tr>
<tr>
<th>가격</th>
<td class="td_ft"><span><?php echo $TPL_VAR["price"]?>원</span> <p class="s_save"><?php echo $TPL_VAR["gp_discount_rate"]?>%</p> <?php echo $TPL_VAR["h_price_format"]?>원</td>
</tr>
<tr>
<th>수강 기간</th>
<td><?php echo $TPL_VAR["term"]?>일</td>
</tr>
</tbody>
</table>
</div>
<img src="/_template/skin/ls/basic/images/sub/package_s_tit1.gif" alt="" />
<div class="info_02">
<?php echo $TPL_VAR["gp_benefit"]?>
</div>
<img src="/_template/skin/ls/basic/images/sub/package_s_tit2.gif" alt="" />
<div class="info_01">
<table cellspacing="0" cellpadding="0" border="0" summary="board" class="re_bod pack_w02">
<caption></caption>
<colgroup>
<col width="10%" />
<col width="40%" />
<col width="10%" />
<col width="15%" />
<col width="10%" />
<col width="15%" />
</colgroup>
<thead>
<tr>
<th colspan="2">강좌명</th>
<th>교수님</th>
<th>가격</th>
<th>샘플보기</th>
<th>자세히보기</th>
</tr>
</thead>
<tbody>
<?php if($TPL_goods_loop_1){foreach($TPL_VAR["goods_loop"] as $TPL_V1){?>
<tr class="pack_h">
<td><img src="/_template/skin/ls/basic/images/sub/img_sj01.gif" /></td>
<td class="t_left"><b><?php echo $TPL_V1["g_name"]?></b></td>
<td><?php echo $TPL_V1["mb_name"]?></td>
<td class="ft_red"><p class="ft_style02 t_line"><?php echo $TPL_V1["price"]?>원</p><b><?php echo $TPL_V1["h_price"]?>원</b></td>
<td><?php if($TPL_V1["sample_cnt"]> 0){?><a href="./goods_view.php?g_num=<?php echo $TPL_V1["g_num"]?>&ca_num=10"><img src="/_template/skin/ls/basic/images/sub/btn_mvi.gif" alt="맛보기" /></a><?php }?></td>
<td><input name="" class="white_btn02" type="button" value="자세히보기" onclick="send_view_info('<?php echo $TPL_V1["g_num"]?>','<?php echo $TPL_V1["ca_num"]?>')"/></td>
</tr>
<?php }}?>
</tbody>
</table>
</div>
<img src="/_template/skin/ls/basic/images/sub/package_s_tit3.gif" alt="" />
<div class="info_01">
<table cellspacing="0" cellpadding="0" border="0" summary="board" class="re_bod pack_w02">
<caption></caption>
<colgroup>
<col width="55%" />
<col width="15%" />
<col width="15%" />
<col width="15%" />
</colgroup>
<thead>
<tr>
<th>교재명</th>
<th>가격</th>
<th>목차보기</th>
<th>선택</th>
</tr>
</thead>
<tbody>
<?php if($TPL_book_loop_1){foreach($TPL_VAR["book_loop"] as $TPL_V1){?>
<tr class="pack_h02">
<td class="t_left t_ind"><b><?php echo $TPL_V1["bo_name"]?></b></td>
<td class="ft_red"><b><?php echo $TPL_V1["bo_selling_price"]?>원</b></td>
<td><input class="white_btn02" type="button" value="목차보기" onclick="open_book_info_list(<?php echo $TPL_V1["bo_num"]?>)"/></td>
<td><input type="checkbox" name="set_book_<?php echo $TPL_V1["bo_num"]?>" id="set_book_<?php echo $TPL_V1["bo_num"]?>" value="<?php echo $TPL_V1["bo_price"]?>" class="checkbox" onclick="pack_sel_book(this.value,'<?php echo $TPL_V1["bo_num"]?>')" /></td>
</tr>
<?php }}?>
</tbody>
</table>
</div>
<img src="/_template/skin/ls/basic/images/sub/package_foot.gif" alt="" />
</div>
<div class="re_pay p_mtop">
<p>강좌금액 <?php echo $TPL_VAR["h_price_format"]?>원 + 교재금액 <span id="book_money">0</span>원<br />
총결재금액 : <span id="tot_money"><?php echo $TPL_VAR["h_price_format"]?></span></p>
</div>
<p class="re_pay_btn"><input class="red_btn02" type="button" value="수강신청하기"  onclick="send_list_goods_pay(this.form)" />
<input  class="gray_btn02" type="button" value="목차보기" onclick="send_list('package_list.php','<?php echo $TPL_VAR["page"]?>')"/></p>
<!-- 상세보기 끝 -->
</div>
<!-- LS 우측 컨텐츠 로그인 끝 -->
</div>
<!-- LS 우측 컨텐츠  영역 끝 -->
</form>