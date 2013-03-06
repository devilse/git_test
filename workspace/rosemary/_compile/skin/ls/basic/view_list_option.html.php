<?php /* Template_ 2.2.7 2013/01/03 12:01:44 C:\rosemary\trunk\src\rosemary\_template\skin\ls\basic\view_list_option.html 000004072 */ 
$TPL_subject_loop_1=empty($TPL_VAR["subject_loop"])||!is_array($TPL_VAR["subject_loop"])?0:count($TPL_VAR["subject_loop"]);
$TPL_book_loop_1=empty($TPL_VAR["book_loop"])||!is_array($TPL_VAR["book_loop"])?0:count($TPL_VAR["book_loop"]);?>
<form name="list_goods_form_<?php echo $TPL_VAR["g_num"]?>" >
<input type="hidden" name="g_num" value="<?php echo $TPL_VAR["g_num"]?>">
<input type="hidden" name="wan_price_<?php echo $TPL_VAR["g_num"]?>" value="0" id="wan_price_<?php echo $TPL_VAR["g_num"]?>">
<input type="hidden" name="wan_book_<?php echo $TPL_VAR["g_num"]?>" id="wan_book_<?php echo $TPL_VAR["g_num"]?>" value="0">
<input type="hidden" name="wan_goods_<?php echo $TPL_VAR["g_num"]?>" id="wan_goods_<?php echo $TPL_VAR["g_num"]?>" value="0">
<table cellspacing="0" cellpadding="0" border="0" summary="board" class="re_bod02">
<caption></caption>
<colgroup>
<col width="12%" />
<col width="3%" />
<col width="9%" />
<col width="60%" />
<col width="14%" />
</colgroup>
<tfoot>
<tr class="re_foot">
<td><img src="/_template/skin/ls/basic/images/sub/th_blt.gif" alt="" />총결제금액</td>
<td colspan="4" class="t_right02">강좌 : <span id="goods_money_<?php echo $TPL_VAR["g_num"]?>">0</span>원 + 교재 : <span id="book_money_<?php echo $TPL_VAR["g_num"]?>">0</span>원 = <span id="tot_money_<?php echo $TPL_VAR["g_num"]?>">0</span>원
<input class="brown_btn02" type="button" value="결제하기" onclick="send_list_goods_pay(this.form,'<?php echo $TPL_VAR["g_num"]?>','','<?php echo $TPL_VAR["MY_URL"]?>')" />
<input name="" class="gray_btn" type="button" value="강의담기" />
</td>
</tr>
</tfoot>
<tbody>
<?php if($TPL_subject_loop_1){foreach($TPL_VAR["subject_loop"] as $TPL_V1){?>
<tr>
<?php if($TPL_V1["number"]== 1){?><th rowspan="<?php echo $TPL_VAR["subject_nums"]?>" class="re_th">온라인강의</th><?php }?>
<td><input type="checkbox" name="set_goods_<?php echo $TPL_V1["lt_num"]?>" id="set_goods_<?php echo $TPL_V1["lt_num"]?>" value="<?php echo $TPL_V1["h_price"]?>" class="checkbox" onclick="list_sel_goods('<?php echo $TPL_VAR["g_num"]?>',this.value,'<?php echo $TPL_V1["lt_num"]?>','goods')" /></td>
<td><?php if($TPL_V1["sample_cnt"]){?><a href="#"><img src="/_template/skin/ls/basic/images/sub/btn_mvi.gif" alt="맛보기" /></a><?php }?></td>
<td class="t_left"><b><?php echo $TPL_V1["lt_name"]?></b> (<?php echo $TPL_V1["mb_name"]?> / 수강기간 <?php echo $TPL_V1["lt_term"]?>일 / 강좌수 <?php echo $TPL_V1["period_cnt"]?>강) <?php if($TPL_VAR["g_discount_rate"]> 0){?>- <span class="ft_red"><?php echo $TPL_VAR["g_discount_rate"]?>% 할인적용</span><?php }?></td>
<td><?php echo $TPL_V1["number_format_h_price"]?>원</td>
</tr>
<?php }}?>
<?php if($TPL_VAR["book_nums"]> 0){?>
<?php if($TPL_book_loop_1){foreach($TPL_VAR["book_loop"] as $TPL_V1){?>
<tr class="b_top">
<?php if($TPL_V1["number"]== 1){?><th rowspan="<?php echo $TPL_VAR["book_nums"]?>" class="re_th02">교재</th><?php }?>
<td><input type="checkbox" name="set_book_<?php echo $TPL_V1["bo_num"]?>" id="set_book_<?php echo $TPL_V1["bo_num"]?>" value="<?php echo $TPL_V1["bo_price"]?>" class="checkbox" onclick="list_sel_goods('<?php echo $TPL_VAR["g_num"]?>',this.value,'<?php echo $TPL_V1["bo_num"]?>','book')" /></td>
<td><a href="#"><?php if($TPL_V1["bo_img"]){?><img src="<?php echo $TPL_VAR["MY_URL"]?>/dir_img/books_img/<?php echo $TPL_V1["bo_img"]?>" alt="" width="100" height="100" /><?php }else{?><img src="/_template/skin/ls/basic/images/sub/img_book.gif" /><?php }?></a></td>
<td class="t_left"><b><?php echo $TPL_V1["bo_name"]?></b> (<?php echo $TPL_V1["bo_publisher"]?> / 저자 <?php echo $TPL_V1["bo_writer"]?>)</td>
<td><?php echo $TPL_V1["bo_selling_price"]?>원</td>
</tr>
<?php }}?>
<?php }?>
<tr class="b_top">
<th>강의특전</th>
<td></td>
<td colspan="3" class="t_left t_ind"><?php echo $TPL_VAR["g_benefit"]?></td>
</tr>
</tbody>
</table>
</form>