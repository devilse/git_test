<?php 
$mode = $_GET['mode'];
$cg_code = $_GET['cg_code'];

$sql2 = "SELECT * FROM category_group WHERE cg_useyn='Y'" ;
$result2 = mysqli_query($CONN['rosemary'],$sql2);


if($cg_code ==''){
	$sql = " select * from category  ORDER BY cg_code , ca_tree";
	$result = mysqli_query($CONN['rosemary'],$sql);
	
	$sql = mysqli_query($CONN['rosemary'],"select count(*) as cnt from category ");
	$v_sql = mysqli_fetch_array($sql);
	
}else{
	$sql = " select * from category where cg_code='$cg_code' order by ca_tree";
	$result = mysqli_query($CONN['rosemary'],$sql);
	
	$sql = mysqli_query($CONN['rosemary'],"select count(*) as cnt from category where cg_code='$cg_code'");
	$v_sql = mysqli_fetch_array($sql);
}

?>

<script type="text/javascript" src="../../_js/mb_script.js"`></SCRIPT>
<script type='text/javascript'>

	function fncGet()
	{
		var fm  = document.form;
		var cg_code= '';

		cg_code= fm.cg_code.options[fm.cg_code.selectedIndex].value;


	document.location.href="./index.php?mode=category&cg_code="+cg_code;

	}

	function go_delete(ca_num,cg_code,ca_tree)
	{
		if (confirm('정말 삭제하시겠습니까?') == false ) {

		}else {
			location.href='process/category_update.php?c=delete&ca_num='+ca_num+'&cg_code='+cg_code+'&ca_tree='+ca_tree;
		}
	}
</script>
			
<div class="divtitle">
카테고리 관리
</div>
<br />
<form name='form'>

<table width="100%" border="0" cellspacing="1" cellpadding="5" class="td" >
	<tr >
		<td width='80%'  >그룹 목록 &nbsp;&nbsp;&nbsp;
			<select name='cg_code' onchange='javascript_:fncGet();'>
				<?php
				echo "<option value='$cg_cdoe' >전체</option>\n";
				
				for ($i=0; $row2=mysqli_fetch_array($result2); $i++){
					echo "<option value='$row2[cg_code]' >$row2[cg_name]</option>\n";
				}
				?>
			</select>
			<script type="text/javascript">document.form.cg_code.value="<?php echo $cg_code?>";</script>
		</td>
		<td align="right"><a href="./index.php?mode=category_add&c=add&top_cate=top&cg_code=<?php echo $cg_code ?>">1차 카테고리 등록</a></td> 
	</tr>
</table>
</form>
<div class="listtabletopinfo">
총 개수 : <?php echo  $v_sql['cnt'] ?> 개
</div>
<form name='form1' method ='post'>
<input type="hidden" name="ca_num" value="<?php echo  $row['ca_num'] ?>">
<input type="hidden" name="cg_code" value="<?php echo $row['cg_code'] ?>">
<input type="hidden" name="ca_tree" value="<?php echo  $row['ca_tree'] ?>">
<table width="100%" border="0" cellspacing="1"  class="td" bgcolor="#999999">

	<tr bgcolor="#EFEFEF" align='center' height='35'>
		<td>그룹 명 </td>
		<td>트리코드</td>
		<td>분류명</td>		
		<td>스킨명</td>
		<td>사용여부</td>
		<td>관리</td>
		<td>등록</td>
		<td>순서 변경</td>
	</tr>

	<?php 
	for ($i=0; $row=mysqli_fetch_array($result); $i++)
	{
		$tree=strlen($row['ca_tree']);
		switch($tree){
			case 3 :
				$tree_num='1';
				$a='';
				break;
			case 6 :
				$tree_num='2';
				$a='&nbsp;└ ';
				break;
			case 9 :
				$tree_num='3';
				$a='&nbsp;&nbsp;&nbsp;&nbsp;└';
				break;
			case 12 :
				$tree_num='4';
				$a='&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;└';
				break;
			case 15 :
				$tree_num='5';
				$a='&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;└';
				break;
		}
		$sql = mysqli_query($CONN['rosemary'],"select cg_name from category_group where cg_code ='$row[cg_code]'");
		$v_sql = mysqli_fetch_array($sql);
		echo"
		<tr bgcolor='#FFFFFF'  height='20'>
			<td align=center height='25'> $v_sql[cg_name]</td>
			<td align=center>$tree_num 차 $row[ca_tree]</td>
			<td style='padding-left:10px'>$a $row[ca_name]</td>			
			<td align=center>$row[ca_skin]</td>
			<td align=center>";

			if($row['ca_useyn'] == 'Y') {  echo "V"; } 
			
			$ca_tree1 = $tree_num + 1;
			
			echo"
			</td>
			<td align=center>
			<a href='./index.php?mode=category_up&c=up&ca_num=$row[ca_num]&cg_code=$row[cg_code]&ca_tree=$row[ca_tree]'>수정  </a>
			&nbsp;&nbsp;
			<a href=\"javascript:go_delete('".$row['ca_num']."','".$row['cg_code']."','".$row['ca_tree']."')\"> 삭제</a>
	
			</td>
			<td align=center>
			<a href='./index.php?mode=category_add&c=add&cg_code=$row[cg_code]&ca_tree=$row[ca_tree]'>$ca_tree1 차 등록</a></td>
			
			<td align=center>";
			
			$len = $tree -3 ;
			$sub = substr($row['ca_tree'],0,$len);
			$sub_abb = $sub.'___';
			
			$sql = mysqli_query($CONN['rosemary'], " select MIN(ca_tree) AS min, MAX(ca_tree) AS max from category where ca_tree like '$sub_abb' and cg_code = '$row[cg_code]' ");
			$v_sql = mysqli_fetch_array($sql);

			if($row['ca_tree'] == $v_sql['min'] && $row['ca_tree'] == $v_sql['max'])
			{
			}elseif($row['ca_tree'] == $v_sql['min'])
			{
				echo"&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<a href='process/category_update.php?c=up&ca_num=$row[ca_num]&ca_tree=$row[ca_tree]&cg_code=$row[cg_code]&updown=down'>∨</a>";
				
			}elseif($row['ca_tree'] == $v_sql['max'])
			{
				echo"<a href='process/category_update.php?c=up&ca_num=$row[ca_num]&ca_tree=$row[ca_tree]&cg_code=$row[cg_code]&updown=up'>∧</a>
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
				
			}else{
				echo"<a href='process/category_update.php?c=up&ca_num=$row[ca_num]&ca_tree=$row[ca_tree]&cg_code=$row[cg_code]&updown=up'>∧</a>  
				&nbsp;&nbsp;
				<a href='process/category_update.php?c=up&ca_num=$row[ca_num]&ca_tree=$row[ca_tree]&cg_code=$row[cg_code]&updown=down'>∨</a>";
			}
					
		echo"	
			</td>
		</tr>
		";		
	}
	?>
	
</table>
</form>
<br />
<div class="divbutton">
	<a href="./index.php?mode=category_add&c=add&top_cate=top&cg_code=<?php echo $cg_code ?>">1차 카테고리 등록</a>
</div>