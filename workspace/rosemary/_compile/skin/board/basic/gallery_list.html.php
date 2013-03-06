<?php /* Template_ 2.2.7 2012/12/20 16:06:13 C:\rosemary\trunk\src\rosemary\_template\skin\board\basic\gallery_list.html 000005600 */ 
$TPL_menu_location_1=empty($TPL_VAR["menu_location"])||!is_array($TPL_VAR["menu_location"])?0:count($TPL_VAR["menu_location"]);
$TPL_notice_list_1=empty($TPL_VAR["notice_list"])||!is_array($TPL_VAR["notice_list"])?0:count($TPL_VAR["notice_list"]);
$TPL_list_1=empty($TPL_VAR["list"])||!is_array($TPL_VAR["list"])?0:count($TPL_VAR["list"]);?>
<script src="/_js/board.js" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" href="/_template/skin/board/basic/css/board.css"/>
<form name="chk_form">
<input type="hidden" name="bo_num" value="<?php echo $TPL_VAR["bo_num"]?>">
<input type="hidden" name="sub_menu_num" >
</form>
<!-- LS 우측 컨텐츠  영역 헤드 시작 -->
<div class="sr_head">
<h3><img src="/_template/skin/board/basic/images/sr_title.gif" alt="가스" /></h3>
<p><?php if($TPL_menu_location_1){$TPL_I1=-1;foreach($TPL_VAR["menu_location"] as $TPL_V1){$TPL_I1++;?><?php if($TPL_I1> 0){?><span> &gt; </span><?php }?><span><?php echo $TPL_V1?></span><?php }}?></p>
</div>
<!-- LS 우측 컨텐츠  헤드 끝 -->
<!-- LS 우측 컨텐츠  본문 시작 -->
<div class="sr_body">
<!-- 시험뉴스 -->
<h4><img src="/_template/skin/board/basic/images/board/bod_blt.gif" /><?php echo $TPL_VAR["head_title"]?></h4>
<table cellspacing="0" cellpadding="0" border="0" summary="board" class="bod_01">
<caption></caption>
<colgroup>
<col width="9%" />
<col width="16%" />
<col width="49%" />
<col width="10%" />
<col width="16%" />
</colgroup>
<thead>
<tr>
<th>번호</th>
<th colspan="2">제목</th>
<th>추천수</th>
<th>조회수</th>
</tr>
</thead>
<tfoot>
<tr class="line_no">
<td colspan="8">
<ul class="con_menu ft_size">
<li class="right"><a href="javascript:user_send_write('<?php echo $TPL_VAR["bo_num"]?>')"><input type="button" name="bod_btn_red" class="bod_btn_red" value="글쓰기" /></a></li>
</ul>
</td>
</tr>
<tr class="line_no">
<td colspan="5">
<ul class="bod_pagelist">
<?php echo $TPL_VAR["page_list"]?>
</ul>
<form name="search_form">
<input type="hidden" name="bo_num" value="<?php echo $TPL_VAR["bo_num"]?>">
<div class="bod_sch ft_size tdtd">
<select name="key" class="sel_sch">
<option value="title" <?php if($TPL_VAR["key"]=="title"){?>selected<?php }?> >제목</option>
<option value="con" <?php if($TPL_VAR["key"]=="con"){?>selected<?php }?> >내용</option>
<option value="tot" <?php if($TPL_VAR["key"]=="tot"){?>selected<?php }?> >제목+내용</option>
<option value="mb_id" <?php if($TPL_VAR["key"]=="mb_id"){?>selected<?php }?>>작성자</option>
</select>
<input type="text" name="searchword" value = "<?php echo $TPL_VAR["searchword"]?>" class="text_sch" style="width:150px;" /><span class="blind">검색창</span>
<input type="button" name="btn_sch" class="btn_sch" value="검색" onclick="search_go('index.php')" />
<?php if($TPL_VAR["searchword"]!=""){?><input type = "button"  class="btn_sch" value = "전체 게시물 보기" onclick="change_list()"><?php }?>
</div>
</form>
</td>
</tr>
</tfoot>
<tbody>
<?php if($TPL_notice_list_1){foreach($TPL_VAR["notice_list"] as $TPL_V1){?>
<tr>
<td><?php echo $TPL_V1["list_number"]?></td>
<td class="gallery"><?php if($TPL_V1["list_img"]){?><img src="<?php echo $TPL_VAR["MY_URL"]?>/dir_img/<?php echo $TPL_V1["list_img"]?>SUM" alt="" /><?php }else{?><img src="/_template/skin/board/basic/images/board/noimage.gif" alt="" /><?php }?></td>
<td class="title">
<ul>
<li class="title_txt"><a href="./view.php?mode=board_view&list_num=<?php echo $TPL_V1["list_num"]?>&<?php echo $TPL_VAR["param"]?>"><?php echo $TPL_V1["title"]?> <?php if($TPL_V1["comment_cnt"]> 0){?><span>[<?php echo $TPL_V1["comment_cnt"]?>]</span><?php }?></a>     <!-- <img class="ico_new" src="/_template/skin/board/basic/images/board/ico_new.gif" alt="" /> -->  </li>
<li class="title_stxt">작성자 : <?php echo $TPL_V1["mb_name"]?> | <span class="s_date"><?php echo $TPL_V1["reg_date"]?></span></li>
</ul>
</td>
<td><img class="ico_new" src="/_template/skin/board/basic/images/board/bod_up.gif" alt="" /><?php echo $TPL_V1["hit_cnt"]?></td>
<td>3697</td>
</tr>
<?php }}?>
<?php if($TPL_VAR["list_query"]){?>
<?php if($TPL_list_1){foreach($TPL_VAR["list"] as $TPL_V1){?>
<tr>
<td><?php echo $TPL_V1["list_number"]?> </td>
<td class="gallery"><?php if($TPL_V1["list_img"]){?><img src="<?php echo $TPL_VAR["MY_URL"]?>/dir_img/<?php echo $TPL_V1["list_img"]?>SUM" alt="" /><?php }else{?><img src="/_template/skin/board/basic/images/board/noimage.gif" alt="" /><?php }?></td>
<td class="title">
<ul>
<li class="title_txt"><a href="./view.php?mode=board_view&list_num=<?php echo $TPL_V1["list_num"]?>&<?php echo $TPL_VAR["param"]?>"><?php echo $TPL_V1["title"]?> <?php if($TPL_V1["comment_cnt"]> 0){?><span>[<?php echo $TPL_V1["comment_cnt"]?>]</span><?php }?></a>     <!-- <img class="ico_new" src="/_template/skin/board/basic/images/board/ico_new.gif" alt="" /> -->  </li>
<li class="title_stxt">작성자 : <?php echo $TPL_V1["mb_name"]?> | <span class="s_date"><?php echo $TPL_V1["reg_date"]?></span></li>
</ul>
</td>
<td><img class="ico_new" src="/_template/skin/board/basic/images/board/bod_up.gif" alt="" /><?php echo $TPL_V1["hit_cnt"]?></td>
<td>3697</td>
</tr>
<?php }}?>
<?php }else{?>
<tr>
<td align="center" colspan="5">등록된 게시물이 없습니다.</td>
</tr>
<?php }?>
</tbody>
</table>
<!-- //시험뉴스 -->
</div>
<!-- LS 우측 컨텐츠  본문 끝 -->