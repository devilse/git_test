<?php /* Template_ 2.2.7 2013/01/07 11:06:47 C:\rosemary\trunk\src\rosemary\_template\skin\ls\basic\book_list.html 000004776 */ 
$TPL_menu_location_1=empty($TPL_VAR["menu_location"])||!is_array($TPL_VAR["menu_location"])?0:count($TPL_VAR["menu_location"]);
$TPL_book_loop_1=empty($TPL_VAR["book_loop"])||!is_array($TPL_VAR["book_loop"])?0:count($TPL_VAR["book_loop"]);?>
<link rel="stylesheet" type="text/css" href="/_template/skin/ls/basic/css/register.css"/>
<script src="/_js/goods.js" type="text/javascript"></script>
<!-- LS 우측 컨텐츠  영역 시작 -->
<div class="s_r_area02 m_left">
<!-- LS 우측 컨텐츠  영역 헤드 시작 -->
<div class="sr_head02">
<h3><img src="/_template/skin/ls/basic/images/sub/booklist_title.gif" alt="교재구매" /></h3>
<p><?php if($TPL_menu_location_1){$TPL_I1=-1;foreach($TPL_VAR["menu_location"] as $TPL_V1){$TPL_I1++;?><?php if($TPL_I1> 0){?><span> &gt; </span><?php }?><span><?php echo $TPL_V1?></span><?php }}?></p>
</div>
<!-- LS 우측 컨텐츠  헤드 끝 -->
<!-- LS 우측 컨텐츠 로그인 시작 -->
<div class="sr_body02">
<!-- 교재구매 시작 -->
<div class="register">
<!-- 이달의 추천도서 시작 -->
<!--
<h3><img src="/_template/skin/ls/basic/images/sub/book_title01.gif" alt="이달의 추천도서" /></h3>
<ul class="book_list">
<li>
<img src="/_template/skin/ls/basic/images/sub/booklist_img.gif" alt="교재" class="booklist_img" />
<a href="#"><img src="/_template/skin/ls/basic/images/sub/btn_zoom.gif" alt="교재" /></a>
<h4>마그리트 MAGRITTE</h4>
마크젠킨스<br />
문학사<br />
<span>20,000</span> &nbsp;<font>17,000</font>
</li>
<li>
<img src="/_template/skin/ls/basic/images/sub/booklist_img.gif" alt="교재" class="booklist_img" />
<a href="#"><img src="/_template/skin/ls/basic/images/sub/btn_zoom.gif" alt="교재" /></a>
<h4>마그리트 MAGRITTE</h4>
마크젠킨스<br />
문학사<br />
<span>20,000</span> &nbsp;<font>17,000</font>
</li>
<li>
<img src="/_template/skin/ls/basic/images/sub/booklist_img02.gif" alt="교재" class="booklist_img" />
<a href="#"><img src="/_template/skin/ls/basic/images/sub/btn_zoom.gif" alt="교재" /></a>
<h4>마그리트 MAGRITTE</h4>
마크젠킨스<br />
문학사<br />
<span>20,000</span> &nbsp;<font>17,000</font>
</li>
<li class="br_no">
<img src="/_template/skin/ls/basic/images/sub/booklist_img.gif" alt="교재" class="booklist_img" />
<a href="#"><img src="/_template/skin/ls/basic/images/sub/btn_zoom.gif" alt="교재" /></a>
<h4>마그리트 MAGRITTE</h4>
마크젠킨스<br />
문학사<br />
<span>20,000</span> &nbsp;<font>17,000</font>
</li>
</ul>
-->
<!-- 이달의 추천도서 끝 -->
<!-- 교재목록 시작 -->
<h3 class="clear"><img src="/_template/skin/ls/basic/images/sub/book_title02.gif" alt="교재목록" /></h3>
<p class="bklist_con">
· 교재명 클릭 시 상세정보 확인 및 검색을 통해 교재정보를 확인 할 수 있습니다.<br />
· 강의를 구매한 회원만 주문할 수 있습니다.
</p>
<form name="search_form" method="get" action="./book_list.php">
<div class="re_sch">
<select name="key">
<option value="bo_name">제목</option>
</select>
<input type="text" name="searchword" class="text_sch" style="width:150px;" /><span class="blind">검색창</span>
<input type="button" name="btn_sch" class="btn_sch" value="검색" onclick="search_go(this.form)" />
</div>
</form>
<ul class="book_list clear">
<?php if($TPL_VAR["book_tot_cnt"]> 0){?>
<?php if($TPL_book_loop_1){foreach($TPL_VAR["book_loop"] as $TPL_V1){?>
<li>
<a href="./book_view.php?bo_num=<?php echo $TPL_V1["bo_num"]?>&page=<?php echo $TPL_VAR["page"]?>&key=<?php echo $TPL_VAR["key"]?>&searchword=<?php echo $TPL_VAR["searchword"]?>"><?php if($TPL_V1["bo_img"]){?><img class="m_book_list" src="<?php echo $TPL_VAR["MY_URL"]?>/dir_img/books_img/<?php echo $TPL_V1["bo_img"]?>" alt="" /><?php }else{?><img src="/_template/skin/ls/basic/images/sub/img_book.gif" alt="" /><?php }?></a>
<a href="#"><img src="/_template/skin/ls/basic/images/sub/btn_zoom.gif" alt="교재" /></a>
<h4><?php echo $TPL_V1["bo_name"]?></h4>
<?php echo $TPL_V1["bo_writer"]?><br />
<?php echo $TPL_V1["bo_publisher"]?><br />
<span><?php echo $TPL_V1["bo_list_price"]?>원</span> &nbsp;<font><?php echo $TPL_V1["bo_selling_price"]?>원</font>
</li>
<?php if($TPL_V1["number"]% 4== 0){?><?php }?>
<?php }}?>
<?php }else{?>
<li>
등록된 교재가 없습니다.
</li>
<?php }?>
</ul>
<!-- 교재목록 끝 -->
</div>
<!-- 교재구매 끝 -->
<div class="list_page">
<ul class="bod_pagelist02">
<?php echo $TPL_VAR["list_page"]?>
</ul>
</div>
<!-- LS 우측 컨텐츠 로그인 끝 -->
</div>
<!-- LS 우측 컨텐츠  영역 끝 -->