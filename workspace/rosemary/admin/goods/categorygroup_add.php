<?php 

$mode = $_GET['mode'];

$cg_code = $_GET['cg_code'];

if ($mode == 'group_add') {
	$cg[cg_useyn] = '0';
	$html_title .= " 생성";

} else if ($mode =='group_up') {
	$sql = mysqli_query($CONN['rosemary'],"select * from category_group where cg_code = '$cg_code'");
	$cg =	mysqli_fetch_array($sql);
	$cg_code = $cg['cg_code'];
	$html_title .= " 수정";
} else {
	alert("잘못된 값이 넘어왔습니다.");
}
?>

<script type="text/javascript" src="../../_js/mb_script.js"></SCRIPT>
<script type='text/javascript'>
	function category1_check(f)
	{
		var f = document.category1;
		var cg_code = document.category1.cg_code.value;		
		
		if(f.mode.value == 'group_add'){
			if(!f.cg_code.value){
				alert('그룹코드을 입력하세요.');
				f.cg_code.focus();
				return false;
			}
		}
		if ((f.cg_name.value == '') || (f.cg_name.value == null)) {
			alert('그룹명을 입력하세요.');
			f.cg_name.focus();
			return false;
		}

		
		return true;
	}
</script>
<div class="divtitle">
대분류 관리
</div>
<br />			

<form name='category1' method='post' onsubmit="return category1_check(this);" action="./process/categorygroup_update.php" autocomplete="off">
	<input type="hidden" name="mode" value="<?php echo $mode?>" />

	<table class="optiontable">
		<tr>
			<td class="title">그룹&nbsp;코드</td>
			<td>
				<?php 
					if($mode == 'group_add'){
						echo "<input type='text' name='cg_code' maxlength='15' size='15'>";
					}else{
						echo "<input type='text' value ='$cg_code' disabled /><input type='hidden' name='cg_code' value ='$cg_code' />";
					}
				?>

				
			</td>
		</tr>
		<tr>
			<td class="title">그&nbsp;&nbsp;룹&nbsp;&nbsp;명</td>
			<td><input type='text' name='cg_name' maxlength='30' size='30' value='<?php echo htmlspecialchars($cg[cg_name])?>'></td>
		</tr>
		<tr>
			<td class="title">스&nbsp;&nbsp;킨&nbsp;&nbsp;명</td>
			<td>
				<select name='cg_skin'>
			        <?php
			        // 스킨목록			        			   
			        $dirList = getDirList($DOCUMENT_ROOT.'/_template/skin/cs');
			        
			        for ($i=0; $i<count($dirList); $i++) {
			        	if($dirList[$i] == $cg['cg_skin']) {
			            	echo "<option value='$dirList[$i]' selected='selected'>$dirList[$i]</option>\n";
			        	} else {
			        		echo "<option value='$dirList[$i]'>$dirList[$i]</option>\n";
			        	}
			        }
			        ?>
		        </select>
        		<script type="text/javascript">document.category1.cg_skin.value="<?php echo $cg[cg_skin]?>";</script>
	        </td>
		</tr>
		<tr>
			<td class="title">브라우저 타이틀(Title)</td>
			<td><input type="text" name="cg_title" value="<?php echo htmlspecialchars(stripslashes($cg[cg_title]))?>" style="width:60%" /><br />
			* 유니크한 타이틀명을 만들기 위해서 어떤 페이지에서는 자동으로 타이틀명에 추가 정보 등이 삽입될 수 있음.<br />
			* 추가 정보가 삽입된 예) 상품 제목 :: 타이틀명, ooo 교수 소개 :: 타이틀명
			</td>
		</tr>
		<tr>
			<td class="title">간단소개(Description)</td>
			<td><textarea name="cg_description" style="width:99%; height:60px;"><?php echo htmlspecialchars(stripslashes($cg[cg_description]))?></textarea><br />
			* 사이트 검색에 필요한 적절한 키워드를 삽입하여 소개 정보를 입력<br />
			* 유니크한 소개를 만들기 위해서 어떤 페이지에서는 추가 정보 등이 앞쪽에 삽입될 수 있음<br />
			* 100자 내외의 분량을 권장함<br />
			</td>
		</tr>
		<tr>
			<td class="title">키워드(KeyWords)</td>
			<td><textarea name="cg_keywords" style="width:99%; height:60px;"><?php echo htmlspecialchars(stripslashes($cg[cg_keywords]))?></textarea><br />
			* 사용자가 많이 검색하는 검색어 및 사이트와 연관된 키워드 정보를 입력<br />
			* 키워드는 ,(콤마) 로 구분하여 입력 (예:자격증,공인중개사,문화재)<br />
			* 10개 이하의 키워드가 효과적이며 유니크한 키워드를 만들기 위해서 어떤 페이지에서는 자동으로 1~3개의 키워드가 앞쪽에 삽입될 수 있음  
			</td>
		</tr>
		<tr>
			<td class="title">사용&nbsp;유무</td>
			<td><input type='checkbox' name='cg_useyn' value='Y' <?php echo $cg[cg_useyn] == 'Y' ? 'checked="checked"':'';?>>사용</td>
		</tr>		
	</table>
	<br />
	<div class="divbutton">
		<input type='submit' class='btn1' accesskey='s' value=' 저장 '>&nbsp;
		<input type='button' class='btn1' value='  취소 ' onclick="document.location.href='./index.php?mode=group';">
	</div>
</form>