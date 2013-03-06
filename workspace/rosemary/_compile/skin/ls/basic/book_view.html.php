<?php /* Template_ 2.2.7 2013/01/04 17:00:00 C:\rosemary\trunk\src\rosemary\_template\skin\ls\basic\book_view.html 000003108 */ 
$TPL_menu_location_1=empty($TPL_VAR["menu_location"])||!is_array($TPL_VAR["menu_location"])?0:count($TPL_VAR["menu_location"]);?>
<link rel="stylesheet" type="text/css" href="/_template/skin/ls/basic/css/register.css"/>
<script src="/_js/goods.js" type="text/javascript"></script>
<form name="book_form" method="post">
<input type="hidden" name="set_book_<?php echo $TPL_VAR["bo_num"]?>" value="<?php echo $TPL_VAR["bo_price"]?>">
</form>
<!-- LS 우측 컨텐츠  영역 시작 -->
<div class="s_r_area02 m_left">
<!-- LS 우측 컨텐츠  영역 헤드 시작 -->
<div class="sr_head02">
<h3><img src="/_template/skin/ls/basic/images/sub/bookcon_title.gif" alt="교재상세보기" /></h3>
<p><?php if($TPL_menu_location_1){$TPL_I1=-1;foreach($TPL_VAR["menu_location"] as $TPL_V1){$TPL_I1++;?><?php if($TPL_I1> 0){?><span> &gt; </span><?php }?><span><?php echo $TPL_V1?></span><?php }}?></p>
</div>
<!-- LS 우측 컨텐츠  헤드 끝 -->
<!-- LS 우측 컨텐츠 로그인 시작 -->
<div class="sr_body02">
<!-- 교재상세보기 시작 -->
<div class="register">
<h2><?php echo $TPL_VAR["bo_name"]?></h2>
<div class="re_img">
<ul class="re_img_list">
<li class="img_style"><?php if($TPL_VAR["bo_img"]){?><img src="<?php echo $TPL_VAR["MY_URL"]?>/dir_img/books_img/<?php echo $TPL_VAR["bo_img"]?>"/><?php }else{?><img src="/_template/skin/ls/basic/images/sub/img_book02.gif"  /><?php }?></li>
</ul>
<div class="re_bookcon">
<ul>
<li><span>정가</span> : <font><?php echo $TPL_VAR["bo_list_price"]?>원</font></li>
<li><span>판매가</span> : <?php echo $TPL_VAR["bo_selling_price"]?>원 </li>
<li><span>페이지</span> : <?php echo $TPL_VAR["bo_page_cnt"]?>P</li>
<li><span>수량</span> : 400P</li>
<li style="border-bottom:none;"><span>배송</span> : 무료배송</li>
</ul>
</div>
<p class="re_pay_btn03">
<input class="brown_btn02" type="button" value="결제하기" onclick="send_book_pay()"/>
<input name="" class="gray_btn" type="button" value="목록보기" onclick="send_list('./book_list.php','<?php echo $TPL_VAR["page"]?>')"/>
</p>
</div>
<!-- 교재소개 시작 -->
<h3><img src="/_template/skin/ls/basic/images/sub/book_title03.gif" alt="교재소개" /></h3>
<div class="re_bookcon02">
<h4><?php echo $TPL_VAR["bo_name"]?></h4>
<?php echo $TPL_VAR["bo_explain_book"]?>
</div>
<!-- 교재소개 끝 -->
<!-- 교재목차 시작 -->
<h3><img src="/_template/skin/ls/basic/images/sub/book_title04.gif" alt="교재목차" /></h3>
<table cellspacing="0" cellpadding="0" border="0" summary="board" class="or_bod bk_style">
<caption></caption>
<colgroup>
<col width="20%" />
<col width="80%" />
</colgroup>
<tbody>
<tr class="bk_tr">
<th>목 차</th>
<td>
<?php echo $TPL_VAR["bbo_explain_writer"]?>
</td>
</tr>
</tbody>
</table>
<!-- 교재목차 끝 -->
</div>
<!-- 교재상세보기 끝 -->
</div>
<!-- LS 우측 컨텐츠 로그인 끝 -->
</div>
<!-- LS 우측 컨텐츠  영역 끝 -->