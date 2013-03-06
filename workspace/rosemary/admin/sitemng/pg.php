<?php
$option_query = mysqli_query($CONN['rosemary'],"select GROUP_CONCAT(CONCAT_WS('<>',so_key,so_val)) as val from site_option");
$option_nums = mysqli_num_rows($option_query);
if ($option_nums > 0) {
	$option_rs = mysqli_fetch_array($option_query);

	$array = explode(",",$option_rs['val']);
	for($i=0; $i<count($array); $i++) {
		$val_array = explode("<>",$array[$i]);
		$key = $val_array[0];
		$val = $val_array[1];

		$option_rs[$key] = $val;
	}

}
?>

<script type = "text/javascript">
	function send_go()
	{
		// 체크 박스에 체크를 하지 않으면 아무런 값도 넘어가지 않기 때문에 빈 텍스트 박스에 해당 체크박스 이름과 값을 넘겨서 받아야함.
		var f = document.pg_form;
		var bankbook_chk =document.getElementById("bankbook_chk");
		var account_chk =document.getElementById("account_chk");
		var card_chk =document.getElementById("card_chk");

		if (f.bankbook.checked != true) {
			bankbook_chk.value = "N";
			bankbook_chk.name = "bankbook";
		} 

		if(f.account.checked != true) {
			account_chk.value = "N";
			account_chk.name = "account";
		}

		if(f.card.checked != true) {
			card_chk.value = "N";
			card_chk.name = "card";
		}

		f.submit();
	}
</script>


<div class="divtitle">
결제방식/전자결제
</div>
<br />
<form name = "pg_form" method="post" action="./process/pg_process.php" >
<input type="hidden" name="mode" id="mode" value="pg">
<input type="hidden" id="bankbook_chk">
<input type="hidden" id="account_chk">
<input type="hidden" id="card_chk">
<table class="optiontable">

	<caption>결제방식</caption>
	<tr>
		<td class="title">결제방식</td>
		<td><label><input type="checkbox" value="Y" name="bankbook" <?php if($option_rs['bankbook'] == "Y"){?>checked<?php }?>/>무통장</label><br />
		<label><input type="checkbox" value="Y" name="account" <?php if($option_rs['account'] == "Y"){?>checked<?php }?>  />가상계좌</label><br />
		<label><input type="checkbox"  value="Y" name="card" <?php if($option_rs['card'] == "Y"){?>checked<?php }?>  />신용카드</label><br />
		학생이 보는 결제 화면에서 체크된 결제 방식만 보여지게 됩니다.</td>
	</tr>
	<tr>
		<td class="title">가상계좌 입금예정기한</td>
		<td><input type="text" name="income_date" size="2" value = "<?php echo $option_rs['income_date'];?>" />일 (최대 15일까지 가능)</td>
	</tr>
	<tr>
		<td class="title">무통장 입금예정기한</td>
		<td><input type="text" name="bankbook_date" size="2" value = "<?php echo $option_rs['bankbook_date'];?>" />일 (안내문구에 보여주기 위한 용도)</td>
	</tr>
</table>
<br />	
<table class="optiontable">
	<caption>전자결제 대행업체</caption>
	<tr>
		<td class="title">결제업체</td>
		<td><label><input type="radio" name="pg_company" value="1" <?php if($option_rs['pg_company'] == "1" || !$option_rs['pg_company'] ){?>checked<?php }?> />올더게이트</label> 
		<!--<label><input type="radio" name="pg_company" value="2" <?php if($option_rs['pg_company'] == "2"){?>checked<?php }?> />올더게이트2</label>--></td>
	</tr>
	<tr>
		<td class="title">상점 아이디</td>
		<td><input type="text" name = "pg_id" value = "<?php echo $option_rs['pg_id'];?>" /></td>
	</tr>
	<tr>
		<td class="title">상점 비밀번호</td>
		<td><input type="text" name = "pg_pwd" value = "<?php echo $option_rs['pg_pwd'];?>" /> (비밀번호가 필요한 업체만 입력)</td>
	</tr>
</table>
<br />
<div class="divbutton">
<input type="button" value = "저장" onclick="send_go()">
</div>
</form>