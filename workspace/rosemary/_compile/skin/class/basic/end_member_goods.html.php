<?php /* Template_ 2.2.7 2013/01/09 16:13:52 C:\rosemary\trunk\src\rosemary\_template\skin\class\basic\end_member_goods.html 000003146 */ 
$TPL_list_1=empty($TPL_VAR["list"])||!is_array($TPL_VAR["list"])?0:count($TPL_VAR["list"]);?>
<div id="tab_info3" style="display:block;">
<!-- 수강 기본 정보 시작 -->
<div class="myinfo_box">
<dl class="info01">
<dt>동영상강의정보</dt>
<dd><img src="/_template/skin/class/basic/images/mylecture/stit_info101.gif" alt="수강중인강의" /><span><?php echo $TPL_VAR["goods_cnt_B"]?></span>개</dd>
<dd><img src="/_template/skin/class/basic/images/mylecture/stit_info102.gif" alt="수강예정강의" /><?php echo $TPL_VAR["goods_cnt_A"]?>개</dd>
<dd><img src="/_template/skin/class/basic/images/mylecture/stit_info103.gif" alt="수강종료강의" /><?php echo $TPL_VAR["goods_cnt_D"]?>개</dd>
<dd><img src="/_template/skin/class/basic/images/mylecture/stit_info104.gif" alt="수강중지강의" /><?php echo $TPL_VAR["goods_cnt_C"]?>개</dd>
</dl>
<dl class="info02">
<dt>결제정보</dt>
<dd><img src="/_template/skin/class/basic/images/mylecture/stit_info201.gif" alt="결제완료" /><span><?php echo $TPL_VAR["member_Order_cnt_B"]?></span>개</dd>
<dd><img src="/_template/skin/class/basic/images/mylecture/stit_info202.gif" alt="결제대기" /><?php echo $TPL_VAR["member_Order_cnt_A"]?>개</dd>
</dl>
<dl class="info03">
<dt>유의사항</dt>
<dd class="no_bor">상세보기 버튼을 클릭하여 수강하셨던 강의의 상세정보를 보실수 있습니다</dd>
</dl>
</div>
<!-- 수강 기본 정보 끝 -->
<div class="page_tit">
<img src="/_template/skin/class/basic/images/mylecture/or_title_my01.gif" alt="수강정보" />
</div>
<!-- 탭 시작 -->
<ul class="page_tab">
<li><a href="./index.php">수강중인강의</a></li>
<li><a href="./wait_member_goods.php">수강예정강의</a></li>
<li class="on"><a href="?">수강종료강의</a></li>
</ul>
<!-- 탭 끝 -->
<table cellpadding="0" cellspacing="0" border="0" class="myinfo_bod">
<caption></caption>
<colgroup>
<col width="58%" />
<col width="10%" />
<col width="20%" />
<col width="12%" />
</colgroup>
<tbody>
<tr>
<th>강의명</th>
<th>교수명</th>
<th>결제일</th>
<th>상세보기</th>
</tr>
<?php if($TPL_VAR["query_number"]> 0){?>
<?php if($TPL_list_1){foreach($TPL_VAR["list"] as $TPL_V1){?>
<tr>
<td class="lec_tit"><?php echo $TPL_V1["lt_name"]?></td>
<td><?php echo $TPL_V1["te_name"]?></td>
<td><img class="ico_date" src="/_template/skin/class/basic/images/mylecture/ico_start.gif" alt="시작일" /><?php echo $TPL_V1["start_date"]?><br /><img class="ico_date" src="/_template/skin/class/basic/images/mylecture/ico_end.gif" alt="종료일" /><?php echo $TPL_V1["end_date"]?></td>
<td><input name="" class="grey_btn_lec" type="button" value="상세보기"/></td>
</tr>
<?php }}?>
<?php }else{?>
<tr>
<td align="center" colspan="7">종료된 강의가 없습니다.</td>
</tr>
<?php }?>
</tbody>
</table>
<!-- LS 페이징 -->
<ul class="bod_pagelist">
<?php echo $TPL_VAR["list_page"]?>
</ul>
<!-- LS 페이징 끝 -->
</div>