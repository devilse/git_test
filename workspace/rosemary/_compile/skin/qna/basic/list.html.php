<?php /* Template_ 2.2.7 2012/12/26 14:45:04 C:\rosemary\trunk\src\rosemary\_template\skin\qna\basic\list.html 000005164 */ 
$TPL_menu_location_1=empty($TPL_VAR["menu_location"])||!is_array($TPL_VAR["menu_location"])?0:count($TPL_VAR["menu_location"]);
$TPL_notice_list_1=empty($TPL_VAR["notice_list"])||!is_array($TPL_VAR["notice_list"])?0:count($TPL_VAR["notice_list"]);
$TPL_list_1=empty($TPL_VAR["list"])||!is_array($TPL_VAR["list"])?0:count($TPL_VAR["list"]);?>
<script src="/_js/qna.js" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" href="/_template/skin/qna/basic/css/board.css"/>
<script type="text/javascript" src="/_js/cufon-yui.js"></script>
<script type="text/javascript" src="/_js/NanumGothic_400-NanumGothic_Bold_400.font.js"></script>
<script type="text/javascript">
Cufon.replace('.sr_head>h3');
</script>
<!-- LS 우측 컨텐츠  영역 헤드 시작 -->
<div class="sr_head">
<h3>가스</h3>
<p><?php if($TPL_menu_location_1){$TPL_I1=-1;foreach($TPL_VAR["menu_location"] as $TPL_V1){$TPL_I1++;?><?php if($TPL_I1> 0){?><span> &gt; </span><?php }?><span><?php echo $TPL_V1?></span><?php }}?></p>
</div>
<!-- LS 우측 컨텐츠  헤드 끝 -->
<!-- LS 우측 컨텐츠  본문 시작 -->
<div class="sr_body">
<!-- 공지사항 -->
<h4><img src="/_template/skin/qna/basic/images/board/bod_blt.gif"><?php echo $TPL_VAR["head_title"]?></h4>
<table cellspacing="0" cellpadding="0" border="0" summary="board" class="bod_01">
<caption></caption>
<colgroup>
<col width="6%" />
<col width="10%" />
<col width="36%" />
<col width="10%" />
<col width="10%" />
<!--<col width="10%" />-->
<col width="8%" />
</colgroup>
<thead>
<tr>
<th>번호</th>
<th>구분</th>
<th>제목</th>
<th>작성자</th>
<th>작성일</th>
<!--	<th>조회</th>-->
<th>답변</th>
</tr>
</thead>
<tfoot>
<tr class="line_no">
<td colspan="8">
<ul class="con_menu ft_size">
<li class="right"><a href="javascript:write_qna()"><input type="button" name="bod_btn_red" class="bod_btn_red" value="문의하기" /></a></li>
</ul>
</td>
</tr>
<tr class="line_no">
<td colspan="8">
<ul class="bod_pagelist">
<?php echo $TPL_VAR["page_list"]?>
</ul>
</td>
</tr>
<tr>
<td class="tdtd"colspan="8" style="border:0;">
<form name="search_form">
<input type="hidden" name="bo_num" value="<?php echo $TPL_VAR["bo_num"]?>">
<div class="bod_sch ft_size">
<select name="key" class="sel_sch">
<option value="title" <?php if($TPL_VAR["key"]=="title"){?>selected<?php }?> >제목</option>
<option value="con" <?php if($TPL_VAR["key"]=="con"){?>selected<?php }?> >내용</option>
<option value="tot" <?php if($TPL_VAR["key"]=="tot"){?>selected<?php }?> >제목+내용</option>
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
<!--
<?php if($TPL_notice_list_1){foreach($TPL_VAR["notice_list"] as $TPL_V1){?>
<tr>
<td><?php echo $TPL_V1["list_number"]?></td>
<td class="sj_color01">국가기술</td>
<td class="title"><a href="./view.php?mode=board_view&list_num=<?php echo $TPL_V1["list_num"]?>&<?php echo $TPL_VAR["param"]?>"><?php echo $TPL_V1["title"]?></a></td>
<td><?php echo $TPL_V1["mb_name"]?></td>
<td><?php echo $TPL_V1["reg_date"]?></td>
<?php if($TPL_VAR["bo_set_file"]=="Y"){?><td><?php if($TPL_V1["file_chk"]=="Y"){?><img src="/_template/skin/qna/basic/images/board/bod_file.gif" /><?php }?></td><?php }?>
<?php if($TPL_VAR["bo_recom"]=="Y"){?><td class="bod_up"><img src="/_template/skin/qna/basic/images/board/bod_up.gif"> <?php echo $TPL_V1["recom_cnt"]?></td><?php }?>
<td><?php echo $TPL_V1["hit_cnt"]?></td>
</tr>
<?php }}?>
-->
<?php if($TPL_VAR["query_number"]> 0){?>
<?php if($TPL_list_1){foreach($TPL_VAR["list"] as $TPL_V1){?>
<tr>
<td><?php echo $TPL_V1["list_number"]?></td>
<td class="sj_color01"><?php echo $TPL_V1["gubun"]?></td>
<td class="title">
<?php echo $TPL_V1["deps"]?><a href="./view.php?mode=board_view&qna_num=<?php echo $TPL_V1["qna_num"]?>&<?php echo $TPL_VAR["param"]?>"><?php echo $TPL_V1["title"]?> <?php if($TPL_V1["comment_cnt"]> 0){?><span>[<?php echo $TPL_V1["comment_cnt"]?>]</span><?php }?>  </a>
</td>
<td><?php echo $TPL_V1["mb_name"]?></td>
<td><?php echo $TPL_V1["reg_date"]?> </td>
<!--<td class="bod_up" > <?php echo $TPL_V1["hit_cnt"]?></td>-->
<td><?php if($TPL_V1["state"]=="Y"){?><img src="/_template/skin/qna/basic/images/board/btn_yes.gif" alt="답변완료" /><?php }else{?><img src="/_template/skin/qna/basic/images/board/btn_no.gif" alt="답변완료" /><?php }?></td>
</tr>
<?php }}?>
<?php }else{?>
<tr>
<td align="center" colspan="8">등록된 게시물이 없습니다.</td>
</tr>
<?php }?>
</tbody>
</table>
<!-- //공지사항 -->
</div>
<!-- LS 우측 컨텐츠  본문 끝 -->