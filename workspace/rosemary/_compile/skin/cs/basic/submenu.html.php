<?php /* Template_ 2.2.7 2013/01/07 12:01:55 C:\rosemary\trunk\src\rosemary\_template\skin\cs\basic\submenu.html 000003366 */ 
$TPL_menu_list_1=empty($TPL_VAR["menu_list"])||!is_array($TPL_VAR["menu_list"])?0:count($TPL_VAR["menu_list"]);?>
<!-- LS 좌측 컨텐츠 영역 시작 -->
<div class="s_l_area">
<!-- LS 좌측 컨텐츠 상단 메뉴 시작 -->
<div class="s_tab">
<h3><?php echo $TPL_VAR["menu_title"]?></h3>
<ul>
<?php if($TPL_menu_list_1){foreach($TPL_VAR["menu_list"] as $TPL_V1){?>
<?php if($TPL_V1[ 6]=="Y"){?>
<li class="<?php echo $TPL_V1[ 0]?><?php if($TPL_V1[ 3]=='Y'){?> in<?php }?><?php if($TPL_V1[ 5]=='Y'&&$TPL_V1[ 4]== 2){?> aco<?php }?>"><a href="<?php echo $TPL_V1[ 1]?>"><?php echo $TPL_V1[ 2]?></a></li>
<?php }?>
<?php }}?>
</ul>
</div>
<!-- LS 좌측 컨텐츠 상단 메뉴 끝 -->
<!-- LS 좌측 디데이, 학습설계상담, 고객센터. 계좌, 학습지원센터 영역  시작 -->
<div class="s_menu">
<div class="s_lecture">
<h3><img src="/_template/skin/cs/basic/images/ls_lec.gif" alt="학습설계상담"/></h3>
<ul>
<li><img src="/_template/skin/cs/basic/images/s_lec1.gif" alt="1" /></li>
<li><img src="/_template/skin/cs/basic/images/s_lec5.gif" alt="5" /></li>
<li><img src="/_template/skin/cs/basic/images/s_lec8.gif" alt="8" /></li>
<li><img src="/_template/skin/cs/basic/images/s_lec8.gif" alt="8" /></li>
<li><img src="/_template/skin/cs/basic/images/s_lec-.gif" alt="-" /></li>
<li><img src="/_template/skin/cs/basic/images/s_lec7.gif" alt="7" /></li>
<li><img src="/_template/skin/cs/basic/images/s_lec6.gif" alt="6" /></li>
<li><img src="/_template/skin/cs/basic/images/s_lec1.gif" alt="1" /></li>
<li><img src="/_template/skin/cs/basic/images/s_lec2.gif" alt="2" /></li>
</ul>
<input type="text" name="s_lec_name" class="s_lec_name1"/>
<input type="text" name="s_lec_num" class="s_lec_num1"/>
<textarea name="s_lec_memo" class="s_lec_memo1" rows="4" cols="15"></textarea>
<p><img src="/_template/skin/cs/basic/images/s_lec_text.gif" alt="빠른상담을 위해 정보를 정확히 입력하세요." /></p>
<input type="button" name="lec_btn" class="s_lect_btn" alt="상담신청클릭"/>
</div>
<!-- LS 고객센터 -->
<div class="s_center">
<h3><img src="/_template/skin/cs/basic/images/s_custome.gif" alt="고객센터" /></h3>
<p><img src="/_template/skin/cs/basic/images/costmer_num.gif" alt="대표번호:1588-7612, 인터넷전화: 070-7589-0645" /></p>
<img src="/_template/skin/cs/basic/images/s_jobtime.gif" alt="평일 10:00~1900, 주말/공휴일 10:00~19:00" />
</div>
<p><h3><img src="/_template/skin/cs/basic/images/s_bank.gif" alt="입금계좌: 1005-601-974091 우리은행 (주)라이패스" /></h3></p>
<div class="stu_center">
<h3><img src="/_template/skin/cs/basic/images/stucenter.gif" alt="학습지원센터" /></h3>
<ul>
<li><a href="#"><img src="/_template/skin/cs/basic/images/stulist01.gif" alt="프로그램다운로드" /></a></li>
<li><a href="#"><img src="/_template/skin/cs/basic/images/stulist02.gif" alt="서식 다운로드" /></a></li>
<li><a href="#"><img src="/_template/skin/cs/basic/images/stulist03.gif" alt="응시자격 진단" /></a></li>
</ul>
</div>
</div>
<!-- LS 좌측 디데이, 학습설계상담, 고객센터. 계좌, 학습지원센터 영역  끝 -->
</div>
<!-- LS 좌측 컨텐츠  영역 끝 -->