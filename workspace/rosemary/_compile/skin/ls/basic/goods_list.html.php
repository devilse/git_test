<?php /* Template_ 2.2.7 2013/01/07 11:06:47 C:\rosemary\trunk\src\rosemary\_template\skin\ls\basic\goods_list.html 000005701 */ 
$TPL_menu_location_1=empty($TPL_VAR["menu_location"])||!is_array($TPL_VAR["menu_location"])?0:count($TPL_VAR["menu_location"]);
$TPL_pack_list_loop_1=empty($TPL_VAR["pack_list_loop"])||!is_array($TPL_VAR["pack_list_loop"])?0:count($TPL_VAR["pack_list_loop"]);
$TPL_list_1=empty($TPL_VAR["list"])||!is_array($TPL_VAR["list"])?0:count($TPL_VAR["list"]);?>
<link rel="stylesheet" type="text/css" href="/_template/skin/ls/basic/css/register.css"/>
<script src="/_js/goods.js" type="text/javascript"></script>
<form name="list_form" >
<input type="hidden" name="page" value="<?php echo $TPL_VAR["page"]?>">
<input type="hidden" name="num">
</form>
<!-- LS 우측 컨텐츠  영역 시작 -->
<div class="s_r_area02 m_left">
<!-- LS 우측 컨텐츠  영역 헤드 시작 -->
<div class="sr_head02">
<h3><img src="/_template/skin/ls/basic/images/sub/register_title.gif" alt="수강신청" /></h3>
<p><?php if($TPL_menu_location_1){$TPL_I1=-1;foreach($TPL_VAR["menu_location"] as $TPL_V1){$TPL_I1++;?><?php if($TPL_I1> 0){?><span> &gt; </span><?php }?><span><?php echo $TPL_V1?></span><?php }}?></p>
</div>
<!-- LS 우측 컨텐츠  헤드 끝 -->
<!-- LS 우측 컨텐츠 로그인 시작 -->
<div class="sr_body02">
<!-- 수강신청 시작 -->
<div class="register">
<?php if($TPL_VAR["pack_tot_cnt"]> 0){?>
<!-- 패키지과정 시작 -->
<h3><img src="/_template/skin/ls/basic/images/sub/re_title01.gif" alt="패키지과정" /></h3>
<?php if($TPL_pack_list_loop_1){foreach($TPL_VAR["pack_list_loop"] as $TPL_V1){
$TPL_goods_2=empty($TPL_V1["goods"])||!is_array($TPL_V1["goods"])?0:count($TPL_V1["goods"]);?>
<div class="package">
<img src="/_template/skin/ls/basic/images/sub/save30.gif" alt="30%SAVE" /><br />
<ul class="package_sj">
<li>· <?php echo $TPL_V1["gp_slogan"]?></li>
<li class="ft_brown">· <?php echo $TPL_V1["gp_name"]?></li>
</ul>
<ul class="package_btn">
<li><input name="" class="white_btn02" type="button" value="자세히보기" onclick="goods_view('<?php echo $TPL_V1["gp_num"]?>','./package_view.php')" />
<input name="" class="white_btn02" type="button" value="강의담기" /></li>
</ul>
<table cellspacing="0" cellpadding="0" border="0" summary="board" class="package_bod">
<caption></caption>
<colgroup>
<col width="20%" />
<col width="80%" />
</colgroup>
<tbody>
<tr>
<th>강의구성</th>
<td><?php if($TPL_goods_2){foreach($TPL_V1["goods"] as $TPL_V2){?><?php echo $TPL_V2["name"]?><?php }}?></td>
</tr>
<tr>
<th>가격</th>
<td class="td_ft"><span><?php echo $TPL_V1["price"]?>원</span>　<?php echo $TPL_V1["h_price"]?>원</td>
</tr>
<tr>
<th>수강 기간</th>
<td><?php echo $TPL_V1["term"]?>일</td>
</tr>
</tbody>
</table>
</div>
<?php }}?>
<!-- 패키지과정 끝 -->
<?php }?>
<!-- 강좌과정 시작 -->
<h3><img src="/_template/skin/ls/basic/images/sub/re_title02.gif" alt="강좌과정" /></h3>
<table cellspacing="0" cellpadding="0" border="0" summary="board" class="re_bod">
<caption></caption>
<colgroup>
<col width="10%" />
<col width="41%" />
<col width="13%" />
<col width="12%" />
<col width="24%" />
</colgroup>
<thead>
<tr>
<th colspan="3">강의정보</th>
<th>가격</th>
<th>강의신청</th>
</tr>
</thead>
<tbody>
<?php if($TPL_VAR["list_cnt"]> 0){?>
<?php if($TPL_list_1){foreach($TPL_VAR["list"] as $TPL_V1){?>
<tr>
<td><?php if($TPL_V1["g_state"]!="C"){?><img src="/_template/skin/ls/basic/images/sub/img_sj02.gif" /><?php }else{?><img src="/_template/skin/ls/basic/images/sub/img_sj01.gif" /><?php }?><br /><input type="checkbox" name="sel_g_num" class="checkbox" value="<?php echo $TPL_V1["g_num"]?>" /></td>
<td class="t_left"><?php echo $TPL_V1["g_name"]?><p class="ft_style02">수강기간 : <?php echo $TPL_V1["lt_term"]?>일 l 강좌수 : <?php echo $TPL_V1["period_cnt"]?>강</p></td>
<td><a href="javascript:view_list_option('<?php echo $TPL_VAR["ca_num"]?>','<?php echo $TPL_V1["g_num"]?>','<?php echo $TPL_VAR["MY_URL"]?>')"><img src="/_template/skin/ls/basic/images/sub/btn_option.gif" /></a></td>
<td><?php if($TPL_V1["g_discount_rate"]> 0){?><p class="ft_style02 t_line"><?php echo $TPL_V1["number_format_price"]?>원</p><p class="s_save"><span><?php echo $TPL_V1["g_discount_rate"]?>%</span></p><br /><?php }?><?php echo $TPL_V1["number_format_h_price"]?>원 </td>
<td><input class="white_btn02" type="button" value="자세히보기" onclick="send_goods_view('<?php echo $TPL_V1["g_num"]?>','<?php echo $TPL_VAR["page"]?>','<?php echo $TPL_VAR["ca_num"]?>','<?php echo $TPL_VAR["MY_URL"]?>')" />
<input name="" class="white_btn02" type="button" value="강의담기" /></td>
</tr>
<tr id="goods_tr_<?php echo $TPL_V1["g_num"]?>" class="b_n" style="display:none">
<td colspan="5">
<div id="goods_<?php echo $TPL_V1["g_num"]?>" ></div>
</td>
</tr>
<?php }}?>
<?php }else{?>
<tr class="b_n"  >
<td colspan="5">
등록된 강좌가 없습니다.
</td>
</tr>
<?php }?>
</tbody>
</table>
<!-- 강좌과정 끝 -->
<!--
<div class="re_pay">
<p>강좌금액 64,000원 + 교재금액 64,000원<br />
총결재금액 : <span>66,500원</span></p>
</div>
<p class="re_pay_btn"><input name="" class="red_btn02" type="button" value="수강신청하기" onclick="send_go()" />
<input name="" class="gray_btn02" type="button" value="강의담기" /></p>
</div>
-->
<!-- 수강신청 끝 -->
</div>
<!-- LS 우측 컨텐츠 로그인 끝 -->
<div class="list_page">
<ul class="bod_pagelist02">
<?php echo $TPL_VAR["list_page"]?>
</ul>
</div>
</div>
<!-- LS 우측 컨텐츠  영역 끝 -->