<script type = "text/javascript">
	function pwd_set()
	{
		var f = document.pwd_form;
		if (!f.pwd.value) {
			alert("현재 비밀번호를 입력해 주세요.");
			f.pwd.focus();
			return;
		} else if (!f.new_pwd1.value) {
			alert("변경할 비밀번호를 입력해 주세요.");
			f.new_pwd1.focus();
			return;
		} else if (f.new_pwd1.value != f.new_pwd2.value) {
			alert("비밀번호 확인을 해주세요.");
			f.new_pwd2.focus();
			return;
		} else {
			f.action = "./process/pwd_set.php";
			f.submit();
		}
	}
</script>
<table width="100%" border="0" cellspacing="1" cellpadding="3" class="td" bgcolor="#999999">
	<tr bgcolor="#EFEFEF" height=30> 
		<td align=center> 
			<b>비밀번호 변경</b>
		</td>
	</tr>	
</table>
<br>



<table width="100%" border="0" cellspacing="1" cellpadding="3" class="td" bgcolor="#999999">
<form name = "pwd_form" method="post">
	<tr bgcolor="#EFEFEF"> 
		<td align=center width=8%>현재 비밀번호</td>
		<td align=left > <input type  = "password" name  = "pwd" ></td>
	</tr>
	<tr bgcolor="#EFEFEF"> 
		<td align=center width=8%>새 비밀번호</td>
		<td align=left ><input type  = "password" name  = "new_pwd1" ></td>
	</tr>
	<tr bgcolor="#EFEFEF"> 
		<td align=center width=8%>비밀번호 확인</td>
		<td align=left ><input type  = "password" name  = "new_pwd2" ></td>
	</tr>

</form>
</table>
<br>
<div align=center>
	<input type = "button" value = "정보수정" onclick="pwd_set()">
</div>
