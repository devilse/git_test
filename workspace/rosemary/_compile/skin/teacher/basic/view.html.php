<?php /* Template_ 2.2.7 2013/01/07 12:06:32 C:\rosemary\trunk\src\rosemary\_template\skin\teacher\basic\view.html 000002650 */ 
$TPL_menu_location_1=empty($TPL_VAR["menu_location"])||!is_array($TPL_VAR["menu_location"])?0:count($TPL_VAR["menu_location"]);
$TPL_lt_name_1=empty($TPL_VAR["lt_name"])||!is_array($TPL_VAR["lt_name"])?0:count($TPL_VAR["lt_name"]);?>
<link rel="stylesheet" type="text/css" href="/_template/skin/teacher/basic/css/professor.css"/>
<script type = "text/javascript">
function send_list(page,ca_num)
{
document.location.href="./index.php?page="+page+"&ca_num="+ca_num;
}
</script>
<!-- LS 우측 컨텐츠  영역 시작 -->
<div class="s_r_area04">
<!-- LS 우측 컨텐츠  영역 헤드 시작 -->
<div class="sr_head04">
<h3><img src="/_template/skin/teacher/basic/images/professor/professor_title.gif" alt="교수소개" /></h3>
<p><?php if($TPL_menu_location_1){$TPL_I1=-1;foreach($TPL_VAR["menu_location"] as $TPL_V1){$TPL_I1++;?><?php if($TPL_I1> 0){?><span> &gt; </span><?php }?><span><?php echo $TPL_V1?></span><?php }}?></p>
</div>
<!-- LS 우측 컨텐츠  헤드 끝 -->
<!-- LS 우측 컨텐츠 로그인 시작 -->
<!-- 교수소개 시작 -->
<div class="professor">
<img src="/_template/skin/teacher/basic/images/professor/professor_img.gif" alt="교수소개" />
<div class="pr_img">
<?php if($TPL_VAR["mb_picture"]){?><img class="s_tea_view" src="<?php echo $TPL_VAR["MY_URL"]?>/dir_img/teacher_img/<?php echo $TPL_VAR["mb_picture"]?>" alt="김기홍교수님" /><?php }else{?><img class="s_tea_view" src="" alt="사진없음" /><?php }?>
<span>
<h4><?php echo $TPL_VAR["mb_name"]?> 교수님</h4>
<ul>
<?php if($TPL_lt_name_1){foreach($TPL_VAR["lt_name"] as $TPL_V1){?>
<li><?php echo $TPL_V1["lt_names"]?></li>
<?php }}?>
</ul>
</span>
</div>
<!-- 교수님약력 시작 -->
<h3 class="pr_clear"><img src="/_template/skin/teacher/basic/images/professor/pr_subtitle03.gif" alt="교수님약력" /></h3>
<ul class="pr_list">
<li><?php echo $TPL_VAR["mb_biography"]?></li>
</ul>
<!-- 교수님약력 끝 -->
<!-- 논문/저서 시작 -->
<h3><img src="/_template/skin/teacher/basic/images/professor/pr_subtitle04.gif" alt="논문/저서" /></h3>
<ul class="pr_list">
<li><?php echo $TPL_VAR["mb_paper"]?></li>
</ul>
<!-- 논문/저서 끝 -->
<p class="btn_list"><input type="button" name="bod_btn_gray" class="bod_btn_gray" value="목록" onclick="send_list('<?php echo $TPL_VAR["page"]?>','<?php echo $TPL_VAR["ca_num"]?>')" /></p>
</div>
<!-- 교수소개 끝 -->
<!-- LS 우측 컨텐츠 로그인 끝 -->
</div>
<!-- LS 우측 컨텐츠  영역 끝 -->