<?php /* Template_ 2.2.7 2012/12/28 10:52:17 C:\rosemary\trunk\src\rosemary\_template\skin\ls\basic\package_list.html 000003755 */ 
$TPL_menu_location_1=empty($TPL_VAR["menu_location"])||!is_array($TPL_VAR["menu_location"])?0:count($TPL_VAR["menu_location"]);
$TPL_list_1=empty($TPL_VAR["list"])||!is_array($TPL_VAR["list"])?0:count($TPL_VAR["list"]);?>
<link rel="stylesheet" type="text/css" href="/_template/skin/ls/basic/css/register.css"/>
<script src="/_js/goods.js" type="text/javascript"></script>
<script type="text/javascript" src="/_js/cufon-yui.js"></script>
<script type="text/javascript" src="/_js/NanumGothic_400-NanumGothic_Bold_400.font.js"></script>
<script type="text/javascript">
Cufon.replace('.sr_head>h3');
</script>
<form name="list_form" >
<input type="hidden" name="page" value="<?php echo $TPL_VAR["page"]?>">
<input type="hidden" name="num">
</form>
<!-- LS 우측 컨텐츠  영역 시작 -->
<div class="s_r_area02 m_left">
<!-- LS 우측 컨텐츠  영역 헤드 시작 -->
<div class="sr_head">
<h3>합격 패키지</h3>
<p><?php if($TPL_menu_location_1){$TPL_I1=-1;foreach($TPL_VAR["menu_location"] as $TPL_V1){$TPL_I1++;?><?php if($TPL_I1> 0){?><span> &gt; </span><?php }?><span><?php echo $TPL_V1?></span><?php }}?></p>
</div>
<!-- LS 우측 컨텐츠  헤드 끝 -->
<!-- LS 우측 컨텐츠 로그인 시작 -->
<div class="sr_body02">
<!-- 수강신청 시작 -->
<div class="register">
<!-- 패키지과정 시작 -->
<h3><img src="/_template/skin/ls/basic/images/sub/re_title01.gif" alt="패키지과정" /></h3>
<?php if($TPL_list_1){foreach($TPL_VAR["list"] as $TPL_V1){
$TPL_goods_2=empty($TPL_V1["goods"])||!is_array($TPL_V1["goods"])?0:count($TPL_V1["goods"]);?>
<div class="package">
<p class="save_tit"><img src="/_template/skin/ls/basic/images/sub/dot_left.gif" alt="" /><!-- 할인률이미지 시작 -->
<?php if($TPL_V1["second_img"]!=""){?><img src="/_template/skin/ls/basic/images/sub/num_b<?php echo $TPL_V1["first_img"]?>.gif" alt="" /><img src="/_template/skin/ls/basic/images/sub/num_b<?php echo $TPL_V1["second_img"]?>.gif" alt="" /><?php }else{?><img src="/_template/skin/ls/basic/images/sub/num_b<?php echo $TPL_V1["first_img"]?>.gif" alt="" /><?php }?><!-- 할인률이미지 끝 --><img src="/_template/skin/ls/basic/images/sub/txt_save.gif" alt="" /><img src="/_template/skin/ls/basic/images/sub/dot_right.gif" alt="" /></p>
<ul class="package_sj">
<li>· <?php echo $TPL_V1["gp_slogan"]?></li>
<li class="ft_brown">· <a href="javascript:goods_view('<?php echo $TPL_V1["gp_num"]?>','./package_view.php')"><?php echo $TPL_V1["gp_name"]?></a></li>
</ul>
<ul class="package_btn">
<li><input class="white_btn02" type="button" value="자세히보기" onclick="goods_view('<?php echo $TPL_V1["gp_num"]?>','./package_view.php')" />
<input class="white_btn02" type="button" value="강의담기" /></li>
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
<!-- 수강신청 끝 -->
</div>
<div class="list_page">
<ul class="bod_pagelist02">
<?php echo $TPL_VAR["list_page"]?>
</ul>
</div>
<!-- LS 우측 컨텐츠 로그인 끝 -->
</div>
<!-- LS 우측 컨텐츠  영역 끝 -->