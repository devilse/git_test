<?php /* Template_ 2.2.7 2013/01/15 18:00:40 C:\rosemary\trunk\src\rosemary\_template\skin\member\basic\POP_Refund.html 000005433 */ 
$TPL_goods_list_1=empty($TPL_VAR["goods_list"])||!is_array($TPL_VAR["goods_list"])?0:count($TPL_VAR["goods_list"]);
$TPL_book_list_1=empty($TPL_VAR["book_list"])||!is_array($TPL_VAR["book_list"])?0:count($TPL_VAR["book_list"]);?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>라이패스LS</title>
<meta name="author" content="nanumcommunications"/>
<meta name="robots" content="all"/>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<link rel="stylesheet" type="text/css" href="/_template/skin/member/basic/css/mypage.css"/>
<script src="/_js/jquery.min.js" type="text/javascript"></script>
</head>
<script type="text/javascript">
function chk_value(value)
{
var f = document.refund_form;
if (value == "예금주") {
f.rf_bank_account_name.value = "";
f.rf_bank_account_name.focus;
} else if (value == "계좌번호") {
f.rf_bank_account.value = "";
f.rf_bank_account.focus;
}
}
function send_refund(page)
{
var f = document.refund_form;
if (f.refund_con.value == "") {
alert("환불 사유를 입력해 주세요.");
f.refund_con.focus;
} else if (f.rf_bank_account_name.value == "") {
alert("환불 받을 계좌의 예금주를 입력해 주세요.");
f.rf_bank_account_name.focus;
} else if (f.rf_bank_name.value == "") {
alert("환불 받을 계좌의 은행을 선택해 주세요.");
} else if (f.rf_bank_account.value == "") {
alert("환불 받을 계좌의 계좌번호를 입력해 주세요.");
f.rf_bank_account.focus;
} else {
$.ajax({
type : "POST"
, async : true
, url : "../../_process/my_page/refund.php"
, dataType : "html"
, timeout : 30000
, cache : false
, data : $("#refund_form").serialize()
, contentType: "application/x-www-form-urlencoded; charset=UTF-8"
, error : function(request, status, error) {
alert("ajax 통신서버에 접속할 수 업습니다.");
}
, success : function(response, status, request) {
var result=response.split('|');
if (result[0] != "T") {
alert(result[1]);
} else {
opener.document.location.href="../../web/mypage/my_pay.php?page="+page;
self.close();
}
}
})
}
}
</script>
<body>
<form name="refund_form" method="post" id="refund_form">
<input type="hidden" name="os_num" value="<?php echo $TPL_VAR["os_num"]?>">
<div class="pop">
<img src="/_template/skin/member/basic/images/mypage/top.gif" alt="환불신청"/>
<div class="bg">
<ul class="bg_list">
<li>하단의 환불규정을 읽어주세요.</li>
<li>환불 사유를 작성해 주시면 관리자가 확인 후 처리해 드리겠습니다. <span>(필수 사항)</span></li>
<li>환불 계좌는 반드시 본인 명의의 계좌를 입력 해주세요.</li>
</ul>
<table cellspacing="0" cellpadding="0" border="0" summary="board" class="pop_bod">
<caption></caption>
<colgroup>
<col width="23%" />
<col width="77%" />
</colgroup>
<tbody>
<tr>
<th>주문번호</th>
<td class="my_red"><?php echo $TPL_VAR["os_num"]?></td>
</tr>
<tr>
<th>총결제금액</th>
<td><span><?php echo $TPL_VAR["os_amt"]?></span>원 (<?php echo $TPL_VAR["os_type"]?>)</td>
</tr>
<tr>
<th class="pop_th">환불항목</th>
<td>
<ul>
<?php if($TPL_VAR["goods_cnt"]> 0){?>
<?php if($TPL_goods_list_1){foreach($TPL_VAR["goods_list"] as $TPL_V1){?>
<li><img src="/_template/skin/member/basic/images/mypage/pop_list01.gif" alt="동영상"/><?php echo $TPL_V1["name"]?></li>
<?php }}?>
<?php }?>
<?php if($TPL_VAR["book_cnt"]> 0){?>
<?php if($TPL_book_list_1){foreach($TPL_VAR["book_list"] as $TPL_V1){?>
<li><img src="/_template/skin/member/basic/images/mypage/pop_list02.gif" alt="교재"/><?php echo $TPL_V1["bo_name"]?></li>
<?php }}?>
<?php }?>
</ul>
</td>
</tr>
<tr>
<th class="pop_th">환불사유</th>
<td class="pop_td"><textarea style="width:93%; height:90px;" rows="3" cols="20" name="refund_con"></textarea><span class="blind">내용</span></td>
</tr>
<tr>
<th class="pop_th">환불계좌</th>
<td class="pop_td">
<input type="text" name="rf_bank_account_name" class="my_text" style="width:80px;" value="예금주" onclick="chk_value(this.value)"/>
<select style="width:90px;" name="rf_bank_name">
<option value="">은행</option>
<option value="국민은행">국민은행</option>
<option value="우리은행">우리은행</option>
<option value="하나은행">하나은행</option>
<option value="외환은행">외환은행</option>
<option value="기업은행">기업은행</option>
<option value="신한은행">신한은행</option>
<option value="농협">농협</option>
</select>
<input type="text" name="rf_bank_account" class="my_text" style="width:135px;" value="계좌번호" onclick="chk_value(this.value)" />
<br />- 가입시 입력하신 실명과 동일한 명의의 계좌를 입력해주세요.
</td>
</tr>
</tbody>
</table>
<div class="pop_btn">
<a href="javascript:send_refund('<?php echo $TPL_VAR["page"]?>')"><img src="/_template/skin/member/basic/images/mypage/btn_ok.gif" alt="확인"/></a> &nbsp;
<a href="javascript:self.close();"><img src="/_template/skin/member/basic/images/mypage/btn_no.gif" alt="취소"/></a>
</div>
</div>
<div class="btm"></div>
</div>
</form>
</body>
</html>