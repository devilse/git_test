<?php /* Template_ 2.2.7 2012/12/26 10:07:12 C:\rosemary\trunk\src\rosemary\_template\skin\qna\basic\view.html 000003861 */ 
$TPL_menu_location_1=empty($TPL_VAR["menu_location"])||!is_array($TPL_VAR["menu_location"])?0:count($TPL_VAR["menu_location"]);
$TPL_file_loop_1=empty($TPL_VAR["file_loop"])||!is_array($TPL_VAR["file_loop"])?0:count($TPL_VAR["file_loop"]);?>
<script src="/_js/qna.js" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" href="/_template/skin/qna/basic/css/board.css"/>
<form name = "view_form" id = "view_form">
<input type  = "hidden" name = "page" value = "<?php echo $TPL_VAR["page"]?>">
<input type  = "hidden" name = "qna_num" value = "<?php echo $TPL_VAR["qna_num"]?>">
<input type  = "hidden" name = "mode" >
<input type  = "hidden" name = "write_mode" >
<input type  = "hidden" name = "move_page" value = "../../web/qna/index.php" >
<input type  = "hidden" name = "key" value = "<?php echo $TPL_VAR["key"]?>" >
<input type  = "hidden" name = "searchword" value = "<?php echo $TPL_VAR["searchword"]?>" >
</form>
<!-- LS 우측 컨텐츠  영역 헤드 시작 -->
<div class="sr_head">
<h3><img src="/_template/skin/qna/basic/images/sr_title.gif" alt="가스" /></h3>
<p><?php if($TPL_menu_location_1){$TPL_I1=-1;foreach($TPL_VAR["menu_location"] as $TPL_V1){$TPL_I1++;?><?php if($TPL_I1> 0){?><span> &gt; </span><?php }?><span><?php echo $TPL_V1?></span><?php }}?></p>
</div>
<!-- LS 우측 컨텐츠  헤드 끝 -->
<!-- LS 우측 컨텐츠  본문 시작 -->
<div class="sr_body">
<h4><img src="/_template/skin/qna/basic/images/board/bod_blt.gif"><?php echo $TPL_VAR["head_title"]?></h4>
<!-- 자유게시판_내용 -->
<table cellspacing="0" cellpadding="0" border="0" summary="board" class="bod_02">
<caption></caption>
<colgroup>
<col width="20%" />
<col width="30%" />
<col width="20%" />
<col width="30%" />
</colgroup>
<tfoot>
<tr class="line_no">
<td colspan="5">
<ul class="con_menu">
<li class="left"><input type="button" name="bod_btn_gray" class="bod_btn_gray" value="목록" onclick="send_list('board_list')" /></li>
<li class="right"><input type="button" name="bod_btn_gray" class="bod_btn_gray03 leftm" value="삭제" onclick="send_del('<?php echo $TPL_VAR["qna_process_url"]?>')"/></li>
<li class="right"><input type="button" name="bod_btn_gray" class="bod_btn_gray03 leftm" value="수정" onclick="send_modi()" /></li>
</ul>
</td>
</tr>
</tfoot>
<tbody>
<tr>
<th>제목</th>
<td colspan="3"><?php echo $TPL_VAR["title"]?>  </td>
</tr>
<tr>
<th>글쓴이</th>
<td colspan="3"><?php echo $TPL_VAR["mb_name"]?></td>
<!--
<th class="line_left">조회수</th>
<td><?php echo $TPL_VAR["hit_cnt"]?></td>
-->
</tr>
<tr>
<th>연락처</th>
<td><?php echo $TPL_VAR["phone"]?></td>
<th class="line_left">이메일</th>
<td><?php echo $TPL_VAR["email"]?></td>
</tr>
<tr>
<th>등록일</th>
<td><?php echo $TPL_VAR["reg_date"]?></td>
<th class="line_left">상담가능시간</th>
<td><?php echo $TPL_VAR["counsel_time"]?></td>
</tr>
<tr>
<th class="f_c1">문의내용</th>
<td colspan="3"><?php echo $TPL_VAR["con"]?></td>
</tr>
<?php if($TPL_VAR["state"]=="Y"){?>
<tr>
<th class="f_c1">답변내용</th>
<td colspan="3"><?php echo $TPL_VAR["con_dap"]?></td>
<?php }?>							</tr>
<tr>
<th>첨부파일</th>
<td colspan="3" class="file_list">
<?php if($TPL_file_loop_1){foreach($TPL_VAR["file_loop"] as $TPL_V1){?>
<ul><li><a href="javascript:set_download('<?php echo $TPL_V1["file_tmp_name"]?>','<?php echo $TPL_V1["file_name"]?>','<?php echo $TPL_VAR["board_process_url"]?>')">
<?php echo $TPL_V1["file_name"]?></a> <span class="ft_style"><?php echo $TPL_V1["file_size"]?></span></li></ul>
<?php }}?>
</td>
</tr>
</tbody>
</table>
<!-- //자유게시판_내용 -->
</div>
<!-- LS 우측 컨텐츠  본문 끝 -->