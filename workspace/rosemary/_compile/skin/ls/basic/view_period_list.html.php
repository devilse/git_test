<?php /* Template_ 2.2.7 2012/12/28 12:54:56 C:\rosemary\trunk\src\rosemary\_template\skin\ls\basic\view_period_list.html 000001366 */ 
$TPL_lt_subject_loop_1=empty($TPL_VAR["lt_subject_loop"])||!is_array($TPL_VAR["lt_subject_loop"])?0:count($TPL_VAR["lt_subject_loop"]);?>
<table cellspacing="0" cellpadding="0" border="0" summary="board" class="recon_bod02">
<caption></caption>
<colgroup>
<col width="23%" />
<col width="10%" />
<col width="47%" />
<col width="20%" />
</colgroup>
<thead>
<tr>
<th colspan="2">강좌명</th>
<th>강의명</th>
<th>강의시간</th>
</tr>
</thead>
<tbody>
<?php if($TPL_lt_subject_loop_1){foreach($TPL_VAR["lt_subject_loop"] as $TPL_V1){
$TPL_period_2=empty($TPL_V1["period"])||!is_array($TPL_V1["period"])?0:count($TPL_V1["period"]);?>
<?php if($TPL_V1["period_nums"]> 0){?>
<?php if($TPL_period_2){foreach($TPL_V1["period"] as $TPL_V2){?>
<tr>
<?php if($TPL_V2["number"]=="1"){?><td rowspan="<?php echo $TPL_V1["period_nums"]?>"><?php echo $TPL_V1["lts_name"]?></td><?php }?>
<td class="ft_co"><?php echo $TPL_V2["number"]?>강</td>
<td><?php echo $TPL_V2["ltsp_name"]?></td>
<td class="ft_co02"><?php echo $TPL_V2["ltsp_time_length"]?></td>
</tr>
<?php }}?>
<?php }else{?>
<tr>
<td colspan="4" class="ft_co">등록된 강의가 업습니다.</td>
</tr>
<?php }?>
<?php }}?>
</tbody>
</table>