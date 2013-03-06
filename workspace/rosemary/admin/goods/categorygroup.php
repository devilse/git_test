<?php 
$mode = $_GET['mode'];

$sql = @mysqli_query($CONN['rosemary']," select count(*) as cnt from category_group");
$row = @mysqli_fetch_array($sql);

$sql = " select * from category_group ";
$result = mysqli_query($CONN['rosemary'],$sql);
?>

<script type="text/javascript" src="../../_js/mb_script.js"></SCRIPT>
<script type='text/javascript'>
	function  use_ck(cg_code,cg_useyn){

		if(cg_useyn=='Y'){

			if (confirm('정말 사용 안 하시겠습니까?') == false ) {

			}else{
				var a ='N';
				location.href='categorygroup_update.php?mode=useyn&cg_code='+cg_code+'&cg_useyn='+a;
			}

		}else{

			if (confirm('정말 사용 하시겠습니까?') == false ) {

			}else{
				a ='Y';
				location.href='categorygroup_update.php?mode=useyn&cg_code='+cg_code+'&cg_useyn='+a;
			}
		}

	}
</script>
			
<div class="divtitle">
대분류 관리
</div>
<br />			
<div class="listtabletopinfo">
총 개수 : <?php echo  $row['cnt'] ?> 개
</div>
<table width='100%' border='0' cellspacing='1'  class='td' bgcolor='#999999'>
	<tr bgcolor='#EFEFEF' align='center' height='35'>
		<td>카테고리 그룹명</td>
		<td>카테고리 코드명</td>
		<td>스킨</td>
		<td>사용유무</td>
		<td>관리</td>
	</tr>
	<?
	for ($i=0; $row=mysqli_fetch_array($result); $i++)
	{
	?>
		
		<tr bgcolor='#FFFFFF' align='center'>
			<td align='center' height='20'><?php echo $row['cg_name']?></td>
			<td align='center'><?php echo $row['cg_code']?></td>
			<td><?php echo $row['cg_skin']?></td>
			
			<td>
			<input type='checkbox' name='cg_useyn' value='Y' <?php echo ($row['cg_useyn'] == 'Y')?'checked':'';?> onclick = use_ck('<?php echo $row['cg_code']?>','<?php echo $row['cg_useyn']?>')>
			</td>
			<td><a href='./index.php?mode=group_up&cg_code=<?php echo $row['cg_code']?>'>수정</a>
			</td>
		</tr>
		
	<?php 
	}
	?>
</table>
<br />
<div class="divbutton">
	<a href="./index.php?mode=group_add">카테고리 그룹 등록</a>
</div>