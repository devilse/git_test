<?php /* Template_ 2.2.7 2013/01/09 15:05:24 C:\rosemary\trunk\src\rosemary\_template\skin\class\basic\wait_member_goods.html 000003736 */ 
$TPL_list_1=empty($TPL_VAR["list"])||!is_array($TPL_VAR["list"])?0:count($TPL_VAR["list"]);?>
<script type="text/javascript">
function start_goods(lt_num,os_num,g_num)
{
if (!lt_num || !os_num || !g_num) {
alert("접근 할 수 없습니다.");
return;
} else {
var f = document.goods_form;
f.lt_num.value = lt_num;
f.os_num.value = os_num;
f.g_num.value = g_num;
f.method = "post";
f.action = "../../_process/class/start_goods.php";
f.submit();
}
}
</script>
<form name="goods_form">
<input type="hidden" name="lt_num">
<input type="hidden" name="os_num">
<input type="hidden" name="g_num">
</form>
<div id="tab_info2" style="display:block;">
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
<dd>강의를 결재 후 수강 시작버튼을 눌러 강의를 활성화 하셔야 강의를 이용하실 수 있습니다.</dd>
<dd class="no_bor">활성화된 강의는 즉시 이용이 가능합니다.</dd>
</dl>
</div>
<!-- 수강 기본 정보 끝 -->
<div class="page_tit">
<img src="/_template/skin/class/basic/images/mylecture/or_title_my01.gif" alt="수강정보" />
</div>
<!-- 탭 시작 -->
<ul class="page_tab">
<li><a href="./index.php">수강중인강의</a></li>
<li class="on"><a href="?">수강예정강의</a></li>
<li><a href="./end_member_goods.php">수강종료강의</a></li>
</ul>
<!-- 탭 끝 -->
<table cellpadding="0" cellspacing="0" border="0" class="myinfo_bod">
<caption></caption>
<colgroup>
<col width="58%" />
<col width="10%" />
<col width="10%" />
<col width="10%" />
<col width="12%" />
</colgroup>
<tbody>
<tr>
<th>강의명</th>
<th>교수명</th>
<th>결제일</th>
<th>수강일</th>
<th>수강시작</th>
</tr>
<?php if($TPL_VAR["query_number"]> 0){?>
<?php if($TPL_list_1){foreach($TPL_VAR["list"] as $TPL_V1){?>
<tr>
<td class="lec_tit"><?php echo $TPL_V1["lt_name"]?></td>
<td><?php echo $TPL_V1["te_name"]?></td>
<td><?php echo $TPL_V1["reg_date"]?></td>
<td class="col_blue"><?php echo $TPL_V1["mbgl_term"]?>일</td>
<td><input class="grey_btn_lec" type="button" value="수강시작" onclick="start_goods('<?php echo $TPL_V1["lt_num"]?>','<?php echo $TPL_V1["os_num"]?>','<?php echo $TPL_V1["g_num"]?>')" /></td>
</tr>
<?php }}?>
<?php }else{?>
<tr>
<td align="center" colspan="7">수강중인 강의가 없습니다.</td>
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