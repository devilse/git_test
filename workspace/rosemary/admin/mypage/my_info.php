<?php

$mb_num = $User_Info["member_num"];
$mb_query = mysqli_query($CONN['rosemary'],"select * from member where mb_num = '$mb_num'");
$mb_qry_nums = mysqli_num_rows($mb_query);
if (!$mb_qry_nums) {
	alertback("등록되지 않은 회원 입니다.");
}

$mb_rs = mysqli_fetch_array($mb_query);
$mb_name = $mb_rs['mb_name'];
$mb_tel = explode("-",$mb_rs['mb_tel']);
$mb_hp = explode("-",$mb_rs['mb_hp']);
$mb_email = $mb_rs['mb_email'];


?>

<script type="text/javascript">
	function info_set()
	{
		var f = document.info_form;
		if (!f.name.value) {
			alert("이름을 입력해 주세요");
			f.name.focus();
			return;
		} else {
			f.action = "./process/info_set.php";
			f.submit();
		}
	}
</script>



<table width="100%" border="0" cellspacing="1" cellpadding="3" class="td" bgcolor="#999999">
	<tr bgcolor="#EFEFEF" height=30> 
		<td align=center> 
			<b>개인정보 수정</b>
		</td>
	</tr>	
</table>
<br>



<table width="100%" border="0" cellspacing="1" cellpadding="3" class="td" bgcolor="#999999">
<form name = "info_form" method="post">
	<tr bgcolor="#EFEFEF"> 
		<td align=center width=8%>아이디</td>
		<td align=left > <b><?php echo $User_Info["id"];?></b> ( * 아이디는 변경할 수 없습니다.)</td>
	</tr>
	<tr bgcolor="#EFEFEF"> 
		<td align=center width=8%>이름</td>
		<td align=left ><input type  = "text" name  = "name" value = "<?php echo $mb_name;?>"></td>
	</tr>
	<tr bgcolor="#EFEFEF"> 
		<td align=center width=8%>전화 번호</td>
		<td align=left ><input type  = "text" name  = "tel1" value = "<?php echo $mb_tel[0];?>"> - <input type  = "text" name  = "tel2" value = "<?php echo $mb_tel[1];?>"> - <input type  = "text" name  = "tel3" value = "<?php echo $mb_tel[2];?>"></td>
	</tr>
	<tr bgcolor="#EFEFEF"> 
		<td align=center width=8%>휴대폰 번호</td>
		<td align=left ><input type  = "text" name  = "hp1" value = "<?php echo $mb_hp[0];?>"> - <input type  = "text" name  = "hp2" value = "<?php echo $mb_hp[1];?>"> - <input type  = "text" name  = "hp3" value = "<?php echo $mb_hp[2];?>"></td>
	</tr>
	<tr bgcolor="#EFEFEF"> 
		<td align=center width=8%>이메일</td>
		<td align=left ><input type  = "text" name  = "email" value = "<?php echo $mb_email;?>" size=40></td>
	</tr>
</form>
</table>
<br>
<div align=center>
	<input type = "button" value = "정보수정" onclick="info_set()">
</div>
