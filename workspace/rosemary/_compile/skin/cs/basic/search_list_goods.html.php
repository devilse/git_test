<?php /* Template_ 2.2.7 2013/01/16 16:01:53 C:\rosemary\trunk\src\rosemary\_template\skin\cs\basic\search_list_goods.html 000004749 */ 
$TPL_list_1=empty($TPL_VAR["list"])||!is_array($TPL_VAR["list"])?0:count($TPL_VAR["list"]);?>
<script src="/_js/goods.js" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" href="/_template/skin/cs/basic/css/search.css"/>
<!-- 전체영역 -->
<div id ="wrap">
<!-- 컨테이너 영역 시작 -->
<div id="container">
<!-- COMMON 영역 시작 -->
<div class="common">
<div class="com_tab">
<ul>
<li><input type="checkbox" name="checkbox" class="checkbox" /><label>전체보기</label></li>
<li><input type="checkbox" name="checkbox" class="checkbox" /><label>동영상강의</label></li>
<li><input type="checkbox" name="checkbox" class="checkbox" /><label>자격증정보</label></li>
<li><input type="checkbox" name="checkbox" class="checkbox" /><label>학위정보</label></li>
<li><input type="checkbox" name="checkbox" class="checkbox" /><label>게시물</label></li>
<li><input type="checkbox" name="checkbox" class="checkbox" /><label>자료실</label></li>
<li><input type="checkbox" name="checkbox" class="checkbox" /><label>교수님소개</label></li>
</ul>
</div>
<p class="com_schtitle"><img src="/_template/skin/cs/basic/images/search/com_blt.gif" /><b class="ft_org">‘경영’</b> 에 대한 검색결과입니다.</p>
<?php if($TPL_VAR["list_cnt"]> 0){?>
<div class="ca_01">
<h3>동영상 강의 <a href="./search_list_goods.php?top_search=<?php echo $TPL_VAR["search_text"]?>">더보기</a></h3>
<!-- 단과과정 시작 -->
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
<?php if($TPL_list_1){foreach($TPL_VAR["list"] as $TPL_V1){?>
<form name="list_goods_form_<?php echo $TPL_VAR["g_num"]?>" >
<input type="hidden" name="g_num" value="<?php echo $TPL_VAR["g_num"]?>">
<input type="hidden" name="wan_price_<?php echo $TPL_VAR["g_num"]?>" value="0" id="wan_price_<?php echo $TPL_VAR["g_num"]?>">
<input type="hidden" name="wan_book_<?php echo $TPL_VAR["g_num"]?>" id="wan_book_<?php echo $TPL_VAR["g_num"]?>" value="0">
<input type="hidden" name="wan_goods_<?php echo $TPL_VAR["g_num"]?>" id="wan_goods_<?php echo $TPL_VAR["g_num"]?>" value="0">
<tr>
<td><?php if($TPL_V1["g_state"]!="C"){?><img src="/_template/skin/cs/basic/images/search/img_sj02.gif" /><?php }else{?><img src="/_template/skin/cs/basic/images/search/img_sj01.gif" /><?php }?><br /></td>
<td class="t_left"><a href="#" onclick="send_goods_view('<?php echo $TPL_V1["g_num"]?>','<?php echo $TPL_VAR["page"]?>','<?php echo $TPL_V1["ca_num"]?>','<?php echo $TPL_VAR["MY_URL"]?>','search')"><?php echo $TPL_V1["g_name"]?></a><p class="ft_style02">수강기간 : <?php echo $TPL_V1["lt_term"]?>일 l 강좌수 : <?php echo $TPL_V1["period_cnt"]?>강</p></td>
<td><a href="javascript:view_list_option('<?php echo $TPL_VAR["ca_num"]?>','<?php echo $TPL_V1["g_num"]?>','<?php echo $TPL_VAR["MY_URL"]?>')"><img src="/_template/skin/cs/basic/images/search/btn_option.gif" /></a></td>
<td><?php if($TPL_V1["g_discount_rate"]> 0){?><p class="ft_style02 t_line"><?php echo $TPL_V1["number_format_price"]?>원</p><p class="s_save"><?php echo $TPL_V1["g_discount_rate"]?>%</p><br /><?php }?><?php echo $TPL_V1["number_format_h_price"]?>원 </td>
<td><input  class="white_btn02" type="button" value="자세히보기" onclick="send_goods_view('<?php echo $TPL_V1["g_num"]?>','<?php echo $TPL_VAR["page"]?>','<?php echo $TPL_V1["ca_num"]?>','<?php echo $TPL_VAR["MY_URL"]?>','search')" />
<input name="" class="white_btn02" type="button" value="강의담기" /></td>
</tr>
<tr id="goods_tr_<?php echo $TPL_V1["g_num"]?>" class="b_n" style="display:none">
<td colspan="5">
<div id="goods_<?php echo $TPL_V1["g_num"]?>" ></div>
</td>
</tr>
</form>
<?php }}?>
</tbody>
</table>
<!-- 단과과정 끝 -->
</div>
<?php }else{?>
<div class="ca_01">
<h3>동영상 강의</h3>
<!-- 단과과정 시작 -->
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
<th colspan="3">검색된 강의가 없습니다.</th>
</tr>
</thead>
</table>
<!-- 단과과정 끝 -->
</div>
<?php }?>
</div>
<!-- COMMON 영역 끝 -->
</div>
<!-- LS 컨테이너 영역 끝 -->
</div>