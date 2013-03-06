<?php /* Template_ 2.2.7 2012/12/31 11:12:35 C:\rosemary\trunk\src\rosemary\_template\skin\ls\basic\view_book_list.html 000001268 */ 
$TPL_book_loop2_1=empty($TPL_VAR["book_loop2"])||!is_array($TPL_VAR["book_loop2"])?0:count($TPL_VAR["book_loop2"]);?>
<?php if($TPL_book_loop2_1){foreach($TPL_VAR["book_loop2"] as $TPL_V1){?>
<div class="re_img">
<ul class="re_img_list">
<li class="img_style"><img src="<?php echo $TPL_VAR["MY_URL"]?>/dir_img/books_img/<?php echo $TPL_V1["bo_img"]?>" alt="네이티브는쉬운영어로말한다" /><!--<img src="/_template/skin/ls/basic/images/sub/img_book02.gif" alt="네이티브는쉬운영어로말한다" />--></li>
<li><a href="#"><img src="/_template/skin/ls/basic/images/sub/btn_booklist.gif" alt="교재목차" /></a></li>
</ul>
<div class="re_bookcon">
<ul>
<li><span>교재명</span> : <font><?php echo $TPL_V1["bo_name"]?></font></li>
<li><span>저자</span> : <?php echo $TPL_V1["bo_writer"]?></li>
<li><span>출판사</span> : <?php echo $TPL_V1["bo_publisher"]?></li>
<li><span>페이지수</span> : <?php echo $TPL_V1["bo_page_cnt"]?>P</li>
<li style="border-bottom:none;"><span>교재특징</span><p class="ft_con"> : <?php echo $TPL_V1["bo_explain_book"]?></p></li>
</ul>
</div>
</div>
<?php }}?>