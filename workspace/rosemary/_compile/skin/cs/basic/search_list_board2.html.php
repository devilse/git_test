<?php /* Template_ 2.2.7 2013/01/16 16:04:13 C:\rosemary\trunk\src\rosemary\_template\skin\cs\basic\search_list_board2.html 000002190 */ 
$TPL_bbs_list2_1=empty($TPL_VAR["bbs_list2"])||!is_array($TPL_VAR["bbs_list2"])?0:count($TPL_VAR["bbs_list2"]);?>
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
<div class="ca_01 ca_top th_btn">
<h3>자료실 <a href="./search_list_board2.php?top_search=<?php echo $TPL_VAR["search_text"]?>">더보기</a></h3>
<ul class="key_list">
<?php if($TPL_VAR["bbs_cnt2"]> 0){?>
<?php if($TPL_bbs_list2_1){foreach($TPL_VAR["bbs_list2"] as $TPL_V1){?>
<li><b>[<?php echo $TPL_V1["bo_name"]?>]</b> <a href="../board/view.php?mode=board_view&bo_num=<?php echo $TPL_V1["bo_num"]?>&list_num=<?php echo $TPL_V1["list_num"]?>" target="_blink"><?php echo $TPL_V1["title"]?></a> <font>(<?php echo $TPL_V1["reg_date"]?>)</font></li>
<?php }}?>
<?php }else{?>
<li><b>검색된 자료가 없습니다.</b></li>
<?php }?>
</ul>
</div>
</div>
<!-- COMMON 영역 끝 -->
</div>
<!-- LS 컨테이너 영역 끝 -->
</div>