<?php
$v_sql1 = mysqli_query($CONN['rosemary'],"select count(*) cnt from site_info");
$v_sql = mysqli_result($v_sql1,0,0);

if ($v_sql['cnt'] == '0') {
	$type = 'add';
} else {
	$type = 'up';
	
	$sql1 = mysqli_query($CONN['rosemary'],"select * from site_info");
	$sql = mysqli_fetch_array($sql1);

//기본정보
	$business_num1 = substr($sql[si_business_num],0,3);
	$business_num2 = substr($sql[si_business_num],3,2);
	$business_num3 = substr($sql[si_business_num],5,5);

	$corporate_num1 = substr($sql[si_corporate_num],0,6);
	$corporate_num2 = substr($sql[si_corporate_num],6,7);
	
	$zip1 = substr($sql[si_zipcode],0,3);
	$zip2 = substr($sql[si_zipcode],3,3);

	$tel = explode("-", $sql[si_tel]);		//explode '-'로 단어 자르고 배열로 반환

	$fax = explode("-", $sql[si_fax]);

//개인정보
	$info_tel = explode("-", $sql[si_info_tel]);
}

?>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<script type="text/javascript" src="../../_js/mb_script.js"></script>
<script type="text/javascript" src="../../_js/jquery.min.js"></script>

<script type="text/javascript">

	function filterKey(filter)
	{
		if (filter) {
			// fromCharCode : 매개 변수에서 ASCII 값이 나타내는 문자들로 구성된 문자열을 반환합니다
			var sKey = String.fromCharCode(event.keyCode);

			var re = new RegExp(filter);

			// test() : 일치하는 문자열이 있는 경우 true, 없으면 false 
			if (!re.test(sKey)){
				event.returnValue=false;
			}
		}
	}

	function go_submit() 
	{

		var f  = document.form;

		/*if (!f.site_name.value) {
			alert("사이트명을 입력하세요");
			f.site_name.focus();
			return false;
		}
		if (!f.com_name.value) {
			alert("회사명을 입력하세요");
			f.com_name.focus();
			return false;
		}
		if (!f.ceo_name.value) {
			alert("대표자명을 입력하세요");
			f.ceo_name.focus();
			return false;
		}*/
		return true;
	}
</script>

<form name = 'form' method ='post' onsubmit="return go_submit(this);"  action="./process/information_process.php?type=<?php echo $type?>" enctype="multipart/form-data">
<table width="90%" border="0" cellspacing="1" cellpadding="6" class="td" bgcolor="#999999">
	<tr>	
		<td colspan="2" bgcolor="#EFEFEF" align="center"> 기본정보</td>
	</tr>
	<tr bgcolor="#FFFFFF">
		<td  width="20%"  align="center" bgcolor="#EFEFEF">사이트명</td>
		<td><input type="text" name="site_name" style="width:300px;" maxlength="200" value="<?php echo $sql[si_site_name]; ?>" ></td>
	</tr>
	<tr bgcolor="#FFFFFF">
		<td align="center" bgcolor="#EFEFEF">회사명</td>
		<td><input type="text" name="com_name" style="width:300px;" maxlength="200" value="<?php echo $sql[si_com_name]; ?>" ></td>
	</tr>
	<tr bgcolor="#FFFFFF">
		<td align="center" bgcolor="#EFEFEF">대표자명</td>
		<td><input type="text" name="ceo_name" value="<?php echo $sql[si_ceo_name]; ?>" ></td>
	</tr>
	<tr bgcolor="#FFFFFF">
		<td align="center" bgcolor="#EFEFEF">사업자 등록 번호</td>
		<td><input type="text" name="business_num1" maxlength="3" style="width:30px;" value="<?php echo $business_num1; ?>" > - 
			<input type="text" name="business_num2" maxlength="2" style="width:20px;" value="<?php echo $business_num2; ?>" > - 
			<input type="text" name="business_num3" maxlength="5" style="width:50px;" value="<?php echo $business_num3; ?>" >
		</td>
	</tr>		
	<tr bgcolor="#FFFFFF">
		<td align="center" bgcolor="#EFEFEF">법인 등록 번호</td>
		<td><input type="text" name="corporate_num1"  maxlength="6" style="width:50px;" value="<?php echo $corporate_num1; ?>" > - 
			<input type="text" name="corporate_num2"  maxlength="7" style="width:60px;" value="<?php echo $corporate_num2; ?>" >
		</td>
	</tr>
	<tr bgcolor="#FFFFFF">
		<td align="center" bgcolor="#EFEFEF">통신 판매 신고 번호</td>
		<td><input type="text" name="mailorder_num"  style="width:200px;" value="<?php echo $sql[si_mailorder_num]; ?>" ></td>
	</tr>

	<tr bgcolor="#FFFFFF">
		<td rowspan="2" align="center" bgcolor="#EFEFEF">사업장 주소</td>
		<td><input type="text" name="zip1" size="3" align='center'onkeypress="filterKey('[0-9]')" style="ime-mode:disabled" maxlength='3' value = '<?php echo $zip1 ?>'>  
			- <input type="text" name="zip2" size="3" align='center'onkeypress="filterKey('[0-9]')" style="ime-mode:disabled" maxlength='3' value = '<?php echo $zip2 ?>'>  
			&nbsp <a href="#" onClick="javascript:WinPopUP1('../member/zipcode.php?zip1=zip1&zip2=zip2&form=form&add=address1','550','500','우편번호');">우편검색</a>
		</td>
	</tr>
	<tr bgcolor="#FFFFFF">
		<td><input type="text" name="address1" size="30" value="<?php echo $sql[si_address]; ?>" > 
			<input type="text" name="address2" size="50" value="<?php echo $sql[si_address_detail]; ?>" >
		</td>
	</tr>

	<tr bgcolor="#FFFFFF">
		<td align="center" bgcolor="#EFEFEF">대표 전화 번호</td>
		<td><input type="text" name="tel1" size="5" maxlength="10" value="<?php echo $tel[0]; ?>" > - 
			<input type="text" name="tel2" size="3" maxlength="4" value="<?php echo $tel[1]; ?>" > - 
			<input type="text" name="tel3" size="3" maxlength="4" value="<?php echo $tel[2]; ?>" >
		</td>
	</tr>
	<tr bgcolor="#FFFFFF">
		<td align="center" bgcolor="#EFEFEF">대표 팩스 번호</td>
		<td><input type="text" name="fax1" size="5" maxlength="10" value="<?php echo $fax[0]; ?>" > - 
			<input type="text" name="fax2" size="3" maxlength="4" value="<?php echo $fax[1]; ?>" > - 
			<input type="text" name="fax3" size="3" maxlength="4" value="<?php echo $fax[2]; ?>" > 
		</td>
	</tr>
	<tr bgcolor="#FFFFFF">
		<td align="center" bgcolor="#EFEFEF">대표 이메일</td>
		<td><input type="text" name="email" size="50" value="<?php echo $sql[si_email]; ?>" ></td>
	</tr>
</table>
<br><br>
<table width="90%" border="0" cellspacing="1" cellpadding="6" class="td" bgcolor="#999999">
	<tr>	
		<td colspan="4" bgcolor="#EFEFEF" align="center">개인 정보 보호 담당자 정보</td>
	</tr>
	<tr bgcolor="#FFFFFF">
		<td width="20%" align="center" bgcolor="#EFEFEF">담당자명</td>
		<td><input type="text" name="info_name" value="<?php echo $sql[si_info_name]; ?>" ></td>
		<td width="20%" align="center" bgcolor="#EFEFEF">소속</td>
		<td><input type="text" name="info_team" value="<?php echo $sql[si_info_team]; ?>" ></td>
	</tr>
	<tr bgcolor="#FFFFFF">
		<td align="center" bgcolor="#EFEFEF">전화</td>
		<td><input type="text" name="info_tel1" maxlength="10" size="5" value="<?php echo $info_tel[0]; ?>" > - 
			<input type="text" name="info_tel2" maxlength="4" size="3" value="<?php echo $info_tel[1]; ?>" > - 
			<input type="text" name="info_tel3" maxlength="4" size="3" value="<?php echo $info_tel[2]; ?>" >
		</td>
		<td width="20%" align="center" bgcolor="#EFEFEF">직위</td>
		<td><input type="text" name="info_position" value="<?php echo $sql[si_info_position]; ?>" ></td>
	</tr>		
	<tr bgcolor="#FFFFFF">
		<td align="center" bgcolor="#EFEFEF">이메일</td>
		<td colspan="3"><input type="text" name="info_email" size="50" value="<?php echo $sql[si_info_email]; ?>" ></td>
	</tr>
</table>
<br><br>
<table width="90%" border="0" cellspacing="1" cellpadding="6" class="td" bgcolor="#999999">
	<tr>	
		<td colspan="2" bgcolor="#EFEFEF" align="center">도메인 정보</td>
	</tr>
	<tr bgcolor="#FFFFFF">
		<td  width="20%"  align="center" bgcolor="#EFEFEF">도메인 주소</td>
		<td><input type="text" name="domain" size="50" value="<?php echo $sql[si_domain]; ?>" ></td>
	</tr>
	<tr bgcolor="#FFFFFF">
		<td align="center" bgcolor="#EFEFEF">구입업체</td>
		<td><input type="text" name="domain_company" size="50" value="<?php echo $sql[si_domain_company]; ?>" ></td>
	</tr>		
	<tr bgcolor="#FFFFFF">
		<td align="center" bgcolor="#EFEFEF">만료일</td>
		<td><input type="text" name="domain_ex" size="30" value="<?php echo $sql[si_domain_ex]; ?>" >예)20121108</td>
	</tr>
</table>
<br>
<table width="90%">
	<tr>
		<td align="right"><input type="submit" value="저장"> </td>
	</tr>
</table>
</form>