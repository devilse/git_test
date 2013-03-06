<?php /* Template_ 2.2.7 2013/01/16 16:05:19 C:\rosemary\trunk\src\rosemary\_template\skin\cs\basic\search_list_teacher.html 000002510 */ 
$TPL_te_list_1=empty($TPL_VAR["te_list"])||!is_array($TPL_VAR["te_list"])?0:count($TPL_VAR["te_list"]);?>
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
<h3>교수님소개 <a href="./search_list_goods.php?top_search=<?php echo $TPL_VAR["search_text"]?>">더보기</a></h3>
<ul class="th_list02">
<?php if($TPL_VAR["te_cnt"]> 0){?>
<?php if($TPL_te_list_1){foreach($TPL_VAR["te_list"] as $TPL_V1){?>
<li>
<?php if($TPL_V1["mb_picture"]){?><img src="<?php echo $TPL_VAR["MY_URL"]?>/dir_img/teacher_img/<?php echo $TPL_V1["mb_picture"]?>"  class="img_th02"  /><?php }else{?><img src="<?php echo $TPL_VAR["MY_URL"]?>/dir_img/teacher_img/<?php echo $TPL_V1["mb_picture"]?>"  class="img_th02" alt="이미지 없음" /><?php }?>
<h3><?php echo $TPL_V1["lt_name"]?></h3><?php echo $TPL_V1["mb_name"]?> 교수
<p><a href="../teacher/view.php?mb_num=<?php echo $TPL_V1["mb_num"]?>" target="_blink"><img src="/_template/skin/cs/basic/images/search/btn_vi02.gif" alt="자세히보기" /></a></p>
</li>
<?php }}?>
<?php }else{?>
<li>
검색된 교수 정보가 없습니다.
</li>
<?php }?>
</ul>
</div>
</div>
<!-- COMMON 영역 끝 -->
</div>
<!-- LS 컨테이너 영역 끝 -->
</div>