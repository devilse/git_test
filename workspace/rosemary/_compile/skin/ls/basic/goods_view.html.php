<?php /* Template_ 2.2.7 2013/01/07 11:06:47 C:\rosemary\trunk\src\rosemary\_template\skin\ls\basic\goods_view.html 000008948 */ 
$TPL_subject_loop_1=empty($TPL_VAR["subject_loop"])||!is_array($TPL_VAR["subject_loop"])?0:count($TPL_VAR["subject_loop"]);
$TPL_book_loop_1=empty($TPL_VAR["book_loop"])||!is_array($TPL_VAR["book_loop"])?0:count($TPL_VAR["book_loop"]);
$TPL_list_1=empty($TPL_VAR["list"])||!is_array($TPL_VAR["list"])?0:count($TPL_VAR["list"]);?>
<link rel="stylesheet" type="text/css" href="/_template/skin/ls/basic/css/register.css"/>
<script src="/_js/goods.js" type="text/javascript"></script>
<input type="hidden" name="g_num" value="<?php echo $TPL_VAR["g_num"]?>">
<input type="hidden" name="wan_price_<?php echo $TPL_VAR["g_num"]?>" value="0" id="wan_price_<?php echo $TPL_VAR["g_num"]?>">
<input type="hidden" name="wan_book_<?php echo $TPL_VAR["g_num"]?>" id="wan_book_<?php echo $TPL_VAR["g_num"]?>" value="0">
<input type="hidden" name="wan_goods_<?php echo $TPL_VAR["g_num"]?>" id="wan_goods_<?php echo $TPL_VAR["g_num"]?>" value="0">
<!-- LS 우측 컨텐츠  영역 시작 -->
<div class="s_r_area02 m_left">
<!-- LS 우측 컨텐츠  영역 헤드 시작 -->
<div class="sr_head02">
<form name="list_goods_form_<?php echo $TPL_VAR["g_num"]?>" >
<input type="hidden" name="g_num" value="<?php echo $TPL_VAR["g_num"]?>">
<h3><img src="/_template/skin/ls/basic/images/sub/registercon_title.gif" alt="상세보기" /></h3>
<p><span> 수강신청 </span>><span> 단과 </span> > <span>상세보기</span></p>
</div>
<!-- LS 우측 컨텐츠  헤드 끝 -->
<!-- LS 우측 컨텐츠 로그인 시작 -->
<div class="sr_body02">
<!-- 상세보기 시작 -->
<div class="register">
<h2><?php echo $TPL_VAR["g_name"]?>&nbsp; <?php if($TPL_VAR["g_type"]!="C"){?><img src="/_template/skin/ls/basic/images/sub/img_sj02.gif" alt="단과" /><?php }else{?><img src="/_template/skin/ls/basic/images/sub/img_sj01.gif" alt="강좌" /><?php }?></h2>
<div class="re_img">
<ul class="re_img_list">
<?php if($TPL_subject_loop_1){foreach($TPL_VAR["subject_loop"] as $TPL_V1){?>
<li class="img_style"><?php if($TPL_VAR["mb_picture"]){?><img src="<?php echo $TPL_VAR["MY_URL"]?>/dir_img/teacher_img/<?php echo $TPL_VAR["mb_picture"]?>"  /><<?php }else{?><img src="/_template/skin/ls/basic/images/sub/noimage2.gif"  /><?php }?></li>
<li><?php echo $TPL_V1["mb_name"]?></li>
<li><a href="#"><img src="/_template/skin/ls/basic/images/sub/btn_view.gif" alt="상세정보보기" /></a></li>
<?php }}?>
</ul>
</div>
<table cellspacing="0" cellpadding="0" border="0" summary="board" class="recon_bod">
<colgroup>
<col width="10%" />
<col width="5%" />
<col width="11%" />
<col width="15%" />
<col width="45%" />
<col width="15%" />
</colgroup>
<tbody>
<tr>
<th colspan="2">· 수강기간</th>
<td><?php echo $TPL_VAR["tot_term"]?>일</td>
<th>· 강좌수</th>
<td colspan="2"><?php echo $TPL_VAR["tot_period_cnt"]?>강</td>
</tr>
<?php if($TPL_subject_loop_1){foreach($TPL_VAR["subject_loop"] as $TPL_V1){?>
<tr class="b_top">
<?php if($TPL_V1["number"]== 1){?><th rowspan="<?php echo $TPL_VAR["subject_nums"]?>" class="re_th03">· 강좌</th><?php }?>
<td class="t_center"><input type="checkbox" name="set_goods_<?php echo $TPL_V1["lt_num"]?>" id="set_goods_<?php echo $TPL_V1["lt_num"]?>" value="<?php echo $TPL_V1["h_price"]?>" class="checkbox" onclick="list_sel_goods('<?php echo $TPL_VAR["g_num"]?>',this.value,'<?php echo $TPL_V1["lt_num"]?>','goods')" /></td>
<td class="t_center"><a href="#"><img src="/_template/skin/ls/basic/images/sub/btn_mvi.gif" alt="맛보기" /></a></td>
<td colspan="2"><span><?php echo $TPL_V1["lt_name"]?></span> (<?php echo $TPL_V1["mb_name"]?> / 수강기간 <?php echo $TPL_V1["lt_term"]?>일 / 강좌수 <?php echo $TPL_V1["period_cnt"]?>강)</td>
<td class="m_right"><span><?php echo $TPL_V1["number_format_h_price"]?>원</span></td>
</tr>
<?php }}?>
<?php if($TPL_book_loop_1){foreach($TPL_VAR["book_loop"] as $TPL_V1){?>
<tr class="b_top">
<?php if($TPL_V1["number"]== 1){?><th rowspan="<?php echo $TPL_VAR["book_nums"]?>" class="re_th04">· 교재</th><?php }?>
<td class="t_center"><input type="checkbox" name="set_book_<?php echo $TPL_V1["bo_num"]?>" id="set_book_<?php echo $TPL_V1["bo_num"]?>" value="<?php echo $TPL_V1["bo_price"]?>" class="checkbox" onclick="list_sel_goods('<?php echo $TPL_VAR["g_num"]?>',this.value,'<?php echo $TPL_V1["bo_num"]?>','book')" /></td>
<td class="t_center"><a href="#"><?php if($TPL_V1["bo_img"]){?><img src="<?php echo $TPL_VAR["MY_URL"]?>/dir_img/books_img/<?php echo $TPL_V1["bo_img"]?>" alt="" width="100" height="100" /><?php }else{?><img src="/_template/skin/ls/basic/images/sub/img_book.gif" /><?php }?></a></td>
<td colspan="2"><font><?php echo $TPL_V1["bo_name"]?></font> (<?php echo $TPL_V1["bo_publisher"]?> / 저자 <?php echo $TPL_V1["bo_writer"]?>)</td>
<td class="m_right"><font><?php echo $TPL_V1["bo_selling_price"]?>원</font></td>
</tr>
<?php }}?>
<tr class="b_top">
<th colspan="2">· 강의특전</th>
<td colspan="4" class="t_ind"><?php echo $TPL_VAR["g_benefit"]?></td>
</tr>
</tbody>
</table>
<div class="re_pay clear">
<p>강좌금액 <span id="goods_money_<?php echo $TPL_VAR["g_num"]?>">0</span>원 + 교재금액 <span id="book_money_<?php echo $TPL_VAR["g_num"]?>">0</span>원<br />
총결재금액 : <span id="tot_money_<?php echo $TPL_VAR["g_num"]?>">0</span>원</p>
</div>
<p class="re_pay_btn02"><input name="" class="red_btn02" type="button" value="수강신청하기" onclick="send_list_goods_pay(this.form,'<?php echo $TPL_VAR["g_num"]?>','','<?php echo $TPL_VAR["MY_URL"]?>')" />
<input class="gray_btn02" type="button" value="목록가기" onclick="send_list('index.php','<?php echo $TPL_VAR["page"]?>','<?php echo $TPL_VAR["ca_num"]?>')" /></p>
</form>
<?php if($TPL_VAR["book_nums"]> 0){?>
<input type="hidden" id="sel_book_tab" name="sel_book_tab" value="<?php echo $TPL_VAR["first_lt_num"]?>">
<!-- 교재소개 시작 -->
<h3><img src="/_template/skin/ls/basic/images/sub/recon_title01.gif" alt="교재소개" /></h3>
<div class="re_bod_tab">
<ul class="re_bod_tab_list">
<?php if($TPL_subject_loop_1){foreach($TPL_VAR["subject_loop"] as $TPL_V1){?>
<li <?php if($TPL_V1["number"]=="1"){?>class="re_tab_00"<?php }else{?>class="re_tab_01"<?php }?> id="view_book_<?php echo $TPL_V1["lt_num"]?>" onclick="view_book('<?php echo $TPL_V1["lt_num"]?>','<?php echo $TPL_VAR["ca_num"]?>')"><h3><?php echo $TPL_V1["lt_name"]?></h3></li>
<?php }}?>
</ul>
</div>
<div id="book_list_div" ><?php $this->print_("book_list",$TPL_SCP,1);?></div>
<!-- 교재소개 끝 -->
<?php }?>
<?php if($TPL_VAR["lt_subject_nums"]> 0){?>
<input type="hidden" id="sel_tab" name="sel_tab" value="<?php echo $TPL_VAR["first_lt_num"]?>">
<!-- 강의목차 시작 -->
<h3 class="clear"><img src="/_template/skin/ls/basic/images/sub/recon_title02.gif" alt="강의목차" /></h3>
<div class="re_bod_tab">
<ul class="re_bod_tab_list">
<?php if($TPL_subject_loop_1){foreach($TPL_VAR["subject_loop"] as $TPL_V1){?>
<li <?php if($TPL_V1["number"]=="1"){?>class="re_tab_00"<?php }else{?>class="re_tab_01"<?php }?> id="view_period_<?php echo $TPL_V1["lt_num"]?>" onclick="view_period('<?php echo $TPL_V1["lt_num"]?>','<?php echo $TPL_VAR["ca_num"]?>')"><h3><?php echo $TPL_V1["lt_name"]?></a></h3></li>
<?php }}?>
</ul>
</div>
<div id="period_list_div" ><?php $this->print_("period_list",$TPL_SCP,1);?></div>
<?php }?>
<!-- 강의목차 끝 -->
<?php if($TPL_VAR["list_cnt"]> 0){?>
<!-- 관련강의정보 시작 -->
<h3><img src="/_template/skin/ls/basic/images/sub/recon_title03.gif" alt="관련강의정보" /></h3>
<table cellspacing="0" cellpadding="0" border="0" summary="board" class="re_bod">
<caption></caption>
<colgroup>
<col width="10%" />
<col width="56%" />
<col width="14%" />
<col width="20%" />
</colgroup>
<thead>
<tr>
<th colspan="2">강의정보</th>
<th>가격</th>
<th>강의신청</th>
</tr>
</thead>
<tbody>
<?php if($TPL_list_1){foreach($TPL_VAR["list"] as $TPL_V1){?>
<tr>
<td><?php if($TPL_V1["g_type"]=="C"){?><img src="/_template/skin/ls/basic/images/sub/img_sj01.gif" /><?php }else{?><img src="/_template/skin/ls/basic/images/sub/img_sj02.gif" /><?php }?></td>
<td class="t_left"><?php echo $TPL_V1["g_name"]?></td>
<td><?php if($TPL_V1["g_discount_rate"]> 0){?><p class="ft_style02 t_line">240,000원</p><p class="s_save"><span><?php echo $TPL_V1["g_discount_rate"]?>%</span></p><br /><?php }?>216,000원</td>
<td><input class="white_btn02" type="button" value="자세히보기" onclick="send_goods_view('<?php echo $TPL_V1["g_num"]?>','1','<?php echo $TPL_VAR["ca_num"]?>')" /></td>
</tr>
<?php }}?>
</tbody>
</table>
<!-- 관련강의정보 끝 -->
<?php }?>
</div>
<!-- 상세보기 끝 -->
</div>
<!-- LS 우측 컨텐츠 로그인 끝 -->
</div>
<!-- LS 우측 컨텐츠  영역 끝 -->