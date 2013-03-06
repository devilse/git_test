<?php 

$mode = $_GET['mode'];
$c = $_GET['c'];

$cg_code = $_GET['cg_code'];
$ca_num = $_GET['ca_num'];
$ca_tree = $_GET['ca_tree'];
$top_cate = $_GET['top_cate'];

//echo $cg_code;
if ($mode =='category_add') {
	$ca['ca_useyn'] = 0;
	$html_title .= " 생성";

	$sql = @mysqli_query($CONN['rosemary']," select max(ca_num) as num from category ");
	$max_num = @mysqli_fetch_array($sql);
	$ca_num = $max_num['num']+1;

	$sql2 = "SELECT * FROM category_group WHERE cg_useyn='Y' ";
	$result2 = mysqli_query($CONN['rosemary'],$sql2);
	
} else if ($mode =='category_up') {
	$ca1 = mysqli_query($CONN['rosemary'],"select * from category where ca_num = '$ca_num'");
	$ca = mysqli_fetch_array($ca1);
	$html_title .= " 수정";
	
	$sql2 = "SELECT * FROM category_group WHERE cg_useyn='Y' ";
	$result2 = mysqli_query($CONN['rosemary'],$sql2);
} else { 
	alert("잘못된 값이 넘어왔습니다.");
}

?>
<script type="text/javascript" src="../../_js/mb_script.js"></SCRIPT>
<script type='text/javascript'>
	function category2_check(f)
	{
		var f = document.category2;
		var c = f.c.value;
		var num = f.ca_num.value;
		var cg_code = document.category2.cg_code.value;
		var tree = f.ca_tree.value;

		//alert(cg_code);
		f.action= "./process/category_update.php?c="+c+"&ca_num="+num+"&cg_code="+cg_code+"&ca_tree="+tree;
	}
</script>
			
<?php 
if($mode != 'category_up') {

	$next_tree = $ca_tree.'___';

	if($top_cate != 'top')
	{
		$cg = "cg_code = '$cg_code' and ";
	}
	$v_sql1 = mysqli_query($CONN['rosemary'],"select MAX(ca_tree) ca_tree from category where $cg ca_tree like '$next_tree'");
	$v_sql = mysqli_fetch_array($v_sql1);

	if($v_sql['ca_tree'] == null) {
		$ca_tree = $ca_tree.'001';
	}else{
		$str =substr($v_sql['ca_tree'],0,3);

		if($str <= 9) {
			$first = '00';
		}elseif($str <= 99) {
			$first = '0' ;
		}

		$ca_tree = $v_sql['ca_tree'] + 1;
		$ca_tree = $first . $ca_tree;
	}
}
?>
<div class="divtitle">
카테고리 관리
</div>
<br />

<form name='category2' method='post' onsubmit="category2_check(this);" autocomplete="off">
<input type='hidden' name='mode'    value='<?php echo $mode?>'>
<input type='hidden' name='c'    value='<?php echo $c?>'>
<input type='hidden' name='ca_num' value="<?php echo $ca_num?>" id="ca_num">
<input type='hidden' name='ca_tree' value="<?php echo $ca_tree?>" id="ca_tree">
<?php
if(!$top_cate){
	echo"<input type='hidden' name='cg_code'    value='$cg_code'>";
}
?>

<table width="60%" align="center" border="0"  border='0' cellspacing='1' cellpadding='6' class='td' bgcolor='#999999'>	

	<?php 
		if($top_cate == 'top') {
	?>
	<tr>
		<td style='padding-left:10px' bgcolor='#EFEFEF'>그룹&nbsp;코드 : </td>
		<td style='padding-left:10px' bgcolor='#FFFFFF'>
			<select name='cg_code'>
				<?php
					
				for ($i=0; $row=mysqli_fetch_array($result2); $i++) {
					echo "<option value='$row[cg_code]' >$row[cg_name]</option>\n";
				}
				?>
			</select>
			<script type="text/javascript">document.category2.cg_code.value="<?php echo $cg_code?>";</script> 
		</td>
	</tr>
	<?php 
	} 
	?>
	<tr>
		<td style='padding-left:10px' bgcolor='#EFEFEF'>분&nbsp;&nbsp;류&nbsp;&nbsp;명 : </td>
		<td style='padding-left:10px' bgcolor='#FFFFFF'><input type='text' name='ca_name' value="<?php echo $ca['ca_name']?>" required itemname="분류명"></td>
	</tr>
	<tr>
		<td style='padding-left:10px' bgcolor='#EFEFEF'>스&nbsp;&nbsp;킨&nbsp;&nbsp;명 : </td>
		<td style='padding-left:10px' bgcolor='#FFFFFF'>
			<select name="ca_skin">
				<?php
		        // 스킨목록			        			   
		        $dirList = getDirList($DOCUMENT_ROOT.'/_template/skin/ls');
		        
		        for ($i=0; $i<count($dirList); $i++) {
		        	if($dirList[$i] == $cg['ca_skin']) {
		            	echo "<option value='$dirList[$i]' selected='selected'>$dirList[$i]</option>\n";
		        	} else {
		        		echo "<option value='$dirList[$i]'>$dirList[$i]</option>\n";
		        	}
		        }
		        ?>
			</select>
			<script type="text/javascript">document.category2.ca_skin.value="<?php echo $ca['ca_skin']?>";</script>
		</td>
	</tr>
	<tr>
		<td style='padding-left:10px' bgcolor='#EFEFEF'>사용&nbsp;유무 : </td>
		<td style='padding-left:10px' bgcolor='#FFFFFF'><input type='checkbox' name='ca_useyn' value='Y' <?php echo $ca['ca_useyn'] == 'Y' ? 'checked' : '';?>>사용 </td>
	</tr>
</table><br>
<table  width="80%"  border="0" align ="rigth">
	<tr>
		<td colspan="2" align="right" >
			<input type=submit class=btn1 accesskey='s' value=' 저장 '>&nbsp;
			<input type=button class=btn1 value='  취소 ' onclick="document.location.href='./index.php?mode=category&cg_code=<?php echo$cg_code?>';">
		</td>
	</tr>
</table>
</form>