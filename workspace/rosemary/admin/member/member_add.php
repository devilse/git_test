<?php
include "../../_lib/function.php";	// 관리자 페이지 공용 함수 파일
include "../../_lib/db_conn.php";	// 디비 접속	
include "../../_lib/global.php";	// 관리자 페이지 공용 변수 파일	
include "../../_lib/lib.php";	// 관리자 페이지 공용 디비 함수 파일

$c = $_GET['c'];
$type = $_GET['type'];
$mb_num = $_GET['num'];	
$page = $_GET['page'];
$mode = $_GET['mode'];	

if ($mode == 'student') {
	$type = 'S';
} else if ($mode == 'teacher') {
	$type = 'T';
} else if ($mode == 'marketer') {
	$type = 'M';
} else if ($mode == 'admin') {
	$type = 'A';
}

if ($c == '') {
	$c = 'add'; //등록
} else if ($c == 'up') { //수정

	$sql = mysqli_query($CONN['rosemary'],"select * from member where mb_num = '$mb_num' and mt_code = '$type'");

	$v_sql = @mysqli_fetch_array($sql);

		$mb_name = $v_sql['mb_name']; 
		$mb_id = $v_sql['mb_id'];
		$mb_password = $v_sql['mb_password'];
		$tel_array = explode("-",$v_sql['mb_tel']);
		$tel1 = $tel_array[0];
		$tel2 = $tel_array[1];
		$tel3 = $tel_array[2];
		$hp_array = explode("-",$v_sql['mb_hp']);
		$hp1 = $hp_array[0];
		$hp2 = $hp_array[1];
		$hp3 = $hp_array[2];

		$mb_e_mail = $v_sql['mb_email'];

	if ($type == 'S') {
		$sql1 = @mysqli_query($CONN['rosemary'],"select * from member_student where mb_num = '$mb_num'");
		$v_sql1 = mysqli_fetch_array($sql1);

			$zip1 = substr($v_sql1['ms_zipcode'],0,3);
			$zip2 = substr($v_sql1['ms_zipcode'],3,3);
			$address1 = $v_sql1['ms_address'];
			$address2 = $v_sql1['ms_address_detail'];
			$business = $v_sql1['mb_marketer_num'];

	} else if ($type == 'T') {

		$sql1 = @mysqli_query($CONN['rosemary'],"select * from member_teacher where mb_num = '$mb_num'");
		$v_sql1 = mysqli_fetch_array($sql1);

			$mb_img = $v_sql1['mb_picture'];
			$biography = $v_sql1['mb_biography'];
			$education = $v_sql1['mb_education'];
			$paper = $v_sql1['mb_paper'];

	} else if ($type == 'M') {
		$sql1 = @mysqli_query($CONN['rosemary'],"select * from member_marketer where mb_num = '$mb_num'");
		$v_sql1 = mysqli_fetch_array($sql1);

			$hostname = $v_sql1['mb_hostname'];
			$captain = $v_sql1['mb_captainyn'];
			$mb_use = $v_sql1['mb_useyn'];
			$messenger = $v_sql1['mb_messenger'];
			$cafeurl = $v_sql1['mb_cafeurl'];
			$dept = $v_sql1['mbo_num'];
	}
}

?>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<script type="text/javascript" src="../../_js/mb_script.js"></script>
<script type="text/javascript" src="../../_js/jquery.min.js"></script>

<script type="text/javascript">

	$(document).ready(function() {
		$("input[name=mb_id]").keyup(function() {
			$.post("check.php?ck=id", {
				id: $("input[name=mb_id]").val()
			}, function(data) {
				$("span").html(data)
			});
		});
	});

	$(document).ready(function() {
		$("input[name=mb_e_mail]").keyup(function() {
			$.post("check.php?ck=email", {
				email: $("input[name=mb_e_mail]").val()
			}, function(data) {

				if (data == '1') {
					$(mail).html("잘못된 이메일 주소입니다.")
					document.getElementById('mail').innerHTML += "<input type='hidden' name='email_ck' value='N'>";

				} else if (data == '2') {
					$(mail).html("")
					document.getElementById('mail').innerHTML += "<input type='hidden' name='email_ck' value='Y'>";
				}
			});
		});
	});

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


	function go_dept() 
	{
		var f = document.form;
		var dept = f.dept.options[f.dept.selectedIndex].value;
	}

	function go_submit() 
	{

		var f  = document.form;

		if (f.type.value == 'T') {

			if (f.mb_img.value) {
				if (!f.mb_img.value.toLowerCase().match(/.(gif|jpg|png)$/i)) {
					alert("이미지가 gif, jpg, png 파일이 아닙니다.");
					return false;
				}
			}

		}

		
		if ((f.mb_name.value == '') || (f.mb_name.value == null)) {
			alert('이름을 입력하세요.');
			f.mb_name.focus();
			return false;
		}
		if ((f.mb_id.value == '') || (f.mb_id.value == null)) {
			alert("아이디를 입력하세요.");
			f.mb_id.focus();
			return false;
		} else if (f.id_ck.value == 'N') {
			alert("중복된 아이디 입니다.");
			f.mb_id.focus();
			return false;
		}

		
		if(f.c.value == 'add' || f.type.value== 'A'){
			
			if ((f.mb_password.value == '') || (f.mb_password.value == null)) {
				alert('비밀번호를 입력하세요.');
				f.mb_password.focus();
				return false;
			}
		}

/*
		if (f.type.value == 'S') {
			if ((f.zip1.value == '') || (f.zip1.value == null)) {
				alert('우편번호를 입력하세요.');
				f.zip1.focus();
				return false;
			} else if ((f.zip2.value == '') || (f.zip2.value == null)) {
				alert('우편번호를 입력하세요.');
				f.zip2.focus();
				return false;
			}
			if ((f.address1.value == '') || (f.address1.value == null)) {
				alert('주소를 입력하세요.');
				f.address1.focus();
				return false;
			}
		}

		if ((f.mb_e_mail.value == '') || (f.mb_e_mail.value == null)) {
			alert("이메일을 입력하세요.");
			f.mb_e_mail.focus();
			return false;
		}

		if (f.email_ck.value == 'N') {
			alert("잘못된 이메일 주소입니다.");
			f.mb_e_mail.focus();
			return false;
		}
		*/

		if (f.type.value == 'T') {
			if (f.mb_img.value) {
				if (f.mb_img_del) {

					var img = confirm("기존 사진이 있습니다. 대체하시겠습니까?");

					if (img == true) {
						f.mb_img_del.checked = true;
					} else {
						return false;
					}
				}
			}
		}

		if (f.type.value == 'M') {
			if (!f.dept.value) {
				alert("부서를 선택하세요.");
				f.dept.focus();
				return false;
			}
		}

		return true;
	}
</script>

<form name = 'form' method ='post' onsubmit="return go_submit(this);"  action="./member_update.php?c=<?php echo $c ?>&type=<?php echo $type ?>&page=<?php echo $page ?>" enctype="multipart/form-data">
	<input type= 'hidden' name = 'c' value = '<?php echo $c ?>'>
	<input type= 'hidden' name = 'mb_num' value = '<?php echo $mb_num ?>'>
	<input type = 'hidden' name = 'id_ck' >
	<input type= 'hidden' name = 'type' value = '<?php echo $type ?>'>
	<input type= 'hidden' name = 'mode' value = '<?php echo $mode ?>'>

<table width="100%" border="0" cellspacing="1" cellpadding="5" class="td" bgcolor="#999999">
	<tr>
		<td width="21%" bgcolor="#EFEFEF" style='padding-left:6px'>이름</td>
		<td bgcolor="#FFFFFF"><input type="text" name="mb_name" value='<?php echo $mb_name ?>'></td>
	</tr>
	<tr>
		<td style='padding-left:6px' bgcolor="#EFEFEF">아이디</td>
		<td bgcolor="#FFFFFF">
			<?php if ($c == 'add') { ?>
				<div>
					<input type="text" name="mb_id" value="" style="ime-mode:disabled;"/> 
					<span></span>
				</div>
			<?php } else { ?>
				<input type='text' name = 'mb_id' value='<?php echo $mb_id ?>'>
			<?php } ?>
		</td>
	</tr>
	
	<?php if ($c == 'add' || $type == 'A' ) { ?>
	<tr>
		<td style='padding-left:6px' bgcolor="#EFEFEF">비밀번호</td>
		<td bgcolor="#FFFFFF"><input type="password" name="mb_password" value = '<?php echo $mb_password ?>'></td>
	</tr>
	<?php } ?>
	
	<tr>
		<td style='padding-left:6px' bgcolor="#EFEFEF">전화번호</td>
		<td bgcolor="#FFFFFF">
			<input type="text" name="tel1" size="4" onkeypress="filterKey('[0-9]')" style="ime-mode:disabled" maxlength='4' value = '<?php echo $tel1 ?>'> 
			- <input type="text" name="tel2" size="4" onkeypress="filterKey('[0-9]')" style="ime-mode:disabled" maxlength='4' value = '<?php echo $tel2 ?>'> 
			- <input type="text" name="tel3" size="4" onkeypress="filterKey('[0-9]')" style="ime-mode:disabled" maxlength='4' value = '<?php echo $tel3 ?>'> 
		</td>
	</tr>
	<tr>
		<td style='padding-left:6px' bgcolor="#EFEFEF">휴대번호</td>
		<td bgcolor="#FFFFFF">
			<input type="text" name="hp1" size="3" onkeypress="filterKey('[0-9]')" style="ime-mode:disabled" maxlength='3' value = '<?php echo $hp1 ?>'> 
			- <input type="text" name="hp2" size="4" onkeypress="filterKey('[0-9]')" style="ime-mode:disabled" maxlength='4' value = '<?php echo $hp2 ?>'> 
			- <input type="text" name="hp3" size="4" onkeypress="filterKey('[0-9]')" style="ime-mode:disabled" maxlength='4' value = '<?php echo $hp3 ?>'> 
		</td>
	</tr>
	<tr>
		<td style='padding-left:6px' bgcolor="#EFEFEF">이메일</td>
		<td bgcolor="#FFFFFF">

				<div>
					<input type="text" name="mb_e_mail" value="<?php echo $mb_e_mail ?>" style="ime-mode:disabled;"> 
					<div id='mail'></div>
				</div>
	
		</td>
	</tr>

	<?php if ($type == 'S') {   /*학습자*/ ?> 
	
	<tr>
		<td style='padding-left:6px' bgcolor="#EFEFEF">주소</td>
		<td bgcolor="#FFFFFF">
			<div id='result' ></div>
			<input type="text" name="zip1" size="3" align='center'onkeypress="filterKey('[0-9]')" style="ime-mode:disabled" maxlength='3' value = '<?php echo $zip1 ?>'>  
			- <input type="text" name="zip2" size="3" align='center'onkeypress="filterKey('[0-9]')" style="ime-mode:disabled" maxlength='3' value = '<?php echo $zip2 ?>'>  
			&nbsp <a href="#" onClick="javascript:WinPopUP1('zipcode.php?zip1=zip1&zip2=zip2&form=form&add=address1','550','500','우편번호');">우편검색</a><br/>
			<input type="text" name="address1" size="40" value = '<?php echo $address1 ?>'> <br/>
			<input type="text" name="address2" size="50" value = '<?php echo $address2 ?>'>
		</td>
	</tr>
	<tr>
		<td style='padding-left:6px' bgcolor="#EFEFEF">영업자</td>
		<td bgcolor="#FFFFFF"><input type="text" name="business" value = '<?php echo $business ?>'> </td>
	</tr>
	
	<?php } else if ($type == 'T') { /*교수자*/ ?>
	
	<tr>
		<td style='padding-left:6px' bgcolor="#EFEFEF"> 약력 </td>
		<td bgcolor="#FFFFFF"> <textarea name='biography' style='width=100%' rows='10' colos='50' ><?php echo $biography ?></textarea> </td>
	</tr>
	<tr>
		<td style='padding-left:6px' bgcolor="#EFEFEF"> 학력 </td>
		<td bgcolor="#FFFFFF"> <textarea name='education' style='width=100%' rows='10' colos='50' ><?php echo $education ?></textarea> </td>
	</tr>
	<tr>
		<td style='padding-left:6px' bgcolor="#EFEFEF"> 논문 or 저서 </td>
		<td bgcolor="#FFFFFF"> <textarea name='paper' style='width=100%' rows='10' colos='50' ><?php echo $paper ?></textarea> </td>
	</tr>
	<tr>
		<td style='padding-left:6px' bgcolor="#EFEFEF" colspan='2' align='center'> 사진 </td>
	</tr>
	<tr>
		<td colspan='2' align='center' bgcolor="#FFFFFF">
			<table >
				<tr>
					<td  bgcolor="#FFFFFF"> 
						<input type="file" name="mb_img"  size="40" maxlength='100'>
					</td>
				</tr>
				<tr>
					<td bgcolor="#FFFFFF">
						<?php
							if ($mb_img){
								echo "<br><a href='../../dir_img/teacher_img/$mb_img' target='_blank'>$mb_img</a>
								<input type=checkbox name='mb_img_del' value='$mb_img'> 삭제<br>
								<img src='../../dir_img/teacher_img/$mb_img'></img>";
							}							
						?>
					</td>
				</tr>
			</table>
		</td>
	</tr>

	<?php } else if ($type == 'M') { /*영업자*/ ?>
	<tr>
		<td style='padding-left:6px' bgcolor="#EFEFEF"> 호스트명</td>
		<td bgcolor="#FFFFFF"> <input type="text" name="hostname" value='<?php echo $hostname ?>' size="50"></td>
	</tr>
	<tr>
		<td style='padding-left:6px' bgcolor="#EFEFEF"> 직책</td>
		<td bgcolor="#FFFFFF"> &nbsp;
			<input type='radio' name='captain' value='Y' <?php if (Y == $captain ) { ?> checked <?php } ?> >팀장 &nbsp;&nbsp;&nbsp;
			<input type='radio' name='captain' value='N' <?php if (N == $captain|| $captain == '') { ?> checked <?php } ?> >팀원
		</td>
	</tr>
	<tr>
		<td style='padding-left:6px' bgcolor="#EFEFEF"> 사용 유무</td>
		<td bgcolor="#FFFFFF"> &nbsp;
			<div id='bbb'>
				<input type='checkbox' name='mb_use' value='Y' <?php if ($mb_use == Y) { ?> checked <?php } ?> >&nbsp;사용
			</div>
		</td>
	</tr>
	<tr>
		<td style='padding-left:6px' bgcolor="#EFEFEF">메신저</td>
		<td bgcolor="#FFFFFF"><input type = 'text' name = 'messenger' value ='<?php echo $messenger ?>' size ='30'></td>
	</tr>
	<tr>
		<td style='padding-left:6px' bgcolor="#EFEFEF">카페주소</td>
		<td bgcolor="#FFFFFF"><input type = 'text' name = 'cafeurl' value = '<?php echo $cafeurl ?>' size="50"> </td>
	</tr>
	<tr>
		<?php
		$v_sql = @mysqli_query($CONN['rosemary'],"select * from member_marketer_organ"); //부서 목록
		?>
		<td style='padding-left:6px' bgcolor="#EFEFEF">부서</td>
		<td bgcolor="#FFFFFF">
			<select name = 'dept' onchange = 'javascript : go_dept();'>
				<?php 
					for ($i=0; $row = mysqli_fetch_array($v_sql); $i++) {
						echo "<option value ='$row[mbo_num]'>$row[mbo_name]</option>\n" ;
					}
				?>
			</select>
			<script type = "text/javascript">document.form.dept.value = "<?php echo  $dept ?>";</script>
		</td>
	</tr>

	<?php } ?>

</table>
	<br>
<table width="100%">
	<tr>
		<td align="center">
			<input type="submit" value="등록"> 
			<input type="button" value="취소" onclick="self.close()">
		</td>
	</tr>
</table>
</form>