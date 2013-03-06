<?php
$cg_code = $_GET['cg_code'];
$ca_list = $_GET['ca_list'];
$stx = $_GET['stx'];
$bo_useyn = $_GET['bo_useyn'];

if ($cg_code == null) {
	$sql1 =mysqli_query($CONN['rosemary'],"SELECT cg_code FROM category_group WHERE cg_useyn ='Y' ORDER BY cg_code"); //첫 화면에서는 db 첫 카테고리 출력
	$sql = mysqli_fetch_array($sql1);
	$cg_code = $sql['cg_code'] ;
}

$sql2 = "SELECT * FROM category_group WHERE cg_useyn='Y' ORDER BY cg_code" ; //그룹 목록
$result2 = mysqli_query($CONN['rosemary'],$sql2);

$v_sql1 = mysqli_query($CONN['rosemary'],"select * from category where cg_code='$cg_code'"); //카테고리 목록

if ($ca_list == null) {
	$sql = mysqli_query($CONN['rosemary'],"select count(*) as cnt  from (select ca_num, ca_name, ca_tree from category where cg_code='$cg_code')a, book b where a.ca_num = b.ca_num and b.bo_name LIKE '%$stx%'");
} else {
	$v_sql = mysqli_query($CONN['rosemary'],"select ca_tree from category where cg_code='$cg_code' and ca_num='$ca_list'");
	$v_sql3 = mysqli_fetch_array($v_sql);

	$sql = mysqli_query($CONN['rosemary'],"select count(*) as cnt FROM (SELECT * FROM category WHERE ca_tree LIKE '$v_sql3[ca_tree]%')a, book b WHERE a.ca_num=b.ca_num and b.bo_name LIKE '%$stx%' ORDER BY ca_tree, bo_num  ");
}
$row = mysqli_fetch_array($sql);
$query_number = $row['cnt'];

$num_per_page = 10;

if (!$page) {
	$page = 1; // 페이지가 없으면 첫 페이지 (1 페이지)
}

$num_per_block  = ceil($query_number / $num_per_page); // 전체 페이지 계산

$from_record = ($page - 1) * $num_per_page; // 시작 열을 구함

function f_tree($tree)
{
	$tree=strlen($tree);
	if($tree == 3){
		$tree_num='1';
		$a='';
	}elseif($tree == 6){
		$tree_num='2';
		$a='&nbsp;└';
	}elseif($tree == 9){
		$tree_num='3';
		$a='&nbsp;&nbsp;└';
	}elseif($tree == 12){
		$tree_num='4';
		$a='&nbsp;&nbsp;&nbsp;└';
	}elseif($tree == 15){
		$tree_num='5';
		$a='&nbsp;&nbsp;&nbsp;&nbsp;└';
	}
	return $a;	
}
?>
<script type="text/javascript">
	function bookGet()
	{
		var fm  = document.books;
		var cg_code= '';

		cg_code= fm.cg_code.options[fm.cg_code.selectedIndex].value;
		fm.ca_list.options[fm.ca_list.selectedIndex].value='';
		fm.stx.value='';
		
		document.location.href="./index.php?mode=books&cg_code="+cg_code;
	}

	function fncGet1()
	{
		var fm  = document.books;
		var ca_list= '';
		
		cg_code= fm.cg_code.options[fm.cg_code.selectedIndex].value;
		ca_list= fm.ca_list.options[fm.ca_list.selectedIndex].value;
		fm.stx.value='';
		
		document.location.href="./index.php?mode=books&cg_code="+cg_code+"&ca_list="+ca_list;
	}

	function  use_ck(bo_num,bo_useyn)
	{

		if(bo_useyn=='Y'){
			if (confirm('정말 사용 안 하시겠습니까?') == false ) {
			}else{
				a ='N';

				location.href='books_update.php?c=useyn&bo_num='+bo_num+'&bo_useyn='+a;
			}
		}else{
			if (confirm('정말 사용 하시겠습니까?') == false ) {		
			}else{
				a ='Y';

				location.href='books_update.php?c=useyn&bo_num='+bo_num+'&bo_useyn='+a;
			}
		}
	}

	function go_delete(cg_code,bo_num,page,stx,ca_list)
	{
		if (confirm('정말 삭제하시겠습니까?') == false ) {
			return;
		}else {
			location.href='books_update.php?c=delete&cg_code='+cg_code+'&bo_num='+bo_num+'&page='+page+'&stx='+stx+'&ca_list='+ca_list;
		}
	}

	function go_search() 
	{	
		var f = document.books;
		var stx = f.stx.value;		

		if (f.stx.value == "" ) {
			alert ('검색어를 입력하세요');
			return;
		}
		
		
		location.href='./index.php?mode=books&stx='+stx;
	}


</script>

<form name='books'>
<table width=100% height='50' >
	<tr>
		<td width='30%' style='padding-left:10px'>그룹 목록 &nbsp;
			<select name='cg_code' onchange='javascript_:bookGet();'>
				<?php
				echo "<option value='' >전체</option>\n";

				for ($i=0; $row2 = mysqli_fetch_array($result2); $i++){
					echo "<option value='$row2[cg_code]' >$row2[cg_name]</option>\n";
				}
				?>
			</select>
			<script type="text/javascript">document.books.cg_code.value="<?php echo $cg_code?>";</script>
		</td>
		<td>카테고리 목록 &nbsp;
			<select name='ca_list' onchange='javascript_:fncGet1();'>
				<?php
				echo "<option value='' >전체</option>\n";
		
				for ($i=0; $row1 = mysqli_fetch_array($v_sql1); $i++) {
					$tree=strlen($row1['ca_tree']);
					switch($tree){
						case 3 :
							$tree_num='1';
							$a='';
						break;
						case 6 :
							$tree_num='2';
							$a='&nbsp;└';
						break;
						case 9 :
							$tree_num='3';
							$a='&nbsp;&nbsp;└';
						break;
						case 12 :
							$tree_num='4';
							$a='&nbsp;&nbsp;&nbsp;└';
						break;
						case 15 :
							$tree_num='5';
							$a='&nbsp;&nbsp;&nbsp;&nbsp;└';
						break;
					}
					echo "<option value='$row1[ca_num]' >$a $row1[ca_name]</option>\n";
				}
				?>
			</select>
			<script type="text/javascript">document.books.ca_list.value="<?php echo $ca_list?>";</script> 
		</td>
		<td align="right"><a href="./index.php?mode=books_add&cg_code=<?php echo $cg_code?>&ca_num=<?php echo $ca_list?>&page=<?php echo $page?>&stx=<?php echo $stx?>&ca_list=<?php echo $ca_list?>&cg_list=<?php echo $cg_code?>">교재 등록</a></td> 
	</tr>
</table>
<table width=100%>
	<tr>
		<td>교재 수 : <?php echo  $query_number ?> 개</td>
		<td align=right>교재 명 : 
			<input type='text' name='stx' value='<?php echo $stx?>' onKeyDown="javascript:if (event.keyCode == 13) go_search();">
			<input type='button' value='검색' onclick="javascript:go_search();">
		</td>
	</tr>
</table>
</form>

<form name='form1' method ='post'>
<input type="hidden" name="ca_num" value="<?php echo  $row['ca_num'] ?>">
<input type="hidden" name="cg_code" value="<?php echo  $row['cg_code'] ?>">
<input type="hidden" name="page"  value='<?php echo $page?>'>
<input type="hidden" name="stx"   value='<?php echo $stx?>'>
<input type="hidden" name="cg_list" value="<?php echo  $cg_list ?>">


<?
if($ca_list == null){
	$v = mysqli_query($CONN['rosemary'],"select * from (select ca_num, ca_name, ca_tree from category where cg_code='$cg_code')a, book b where a.ca_num = b.ca_num and b.bo_name LIKE '%$stx%' ORDER BY ca_tree, bo_num DESC limit $from_record, $num_per_page"); //리스트


}else{
	$v_sql = mysqli_query($CONN['rosemary'],"select ca_tree from category where cg_code='$cg_code' and ca_num='$ca_list'");
	$v_sql3 = mysqli_fetch_array($v_sql);

	$v = mysqli_query($CONN['rosemary'],"SELECT * FROM (SELECT * FROM category WHERE ca_tree LIKE '$v_sql3[ca_tree]%')a, book b WHERE a.ca_num=b.ca_num and b.bo_name LIKE '%$stx%' ORDER BY ca_tree, bo_num DESC limit $from_record, $num_per_page"); //리스트
}


?>

<table width='100%' border='0' cellspacing='1' cellpadding='6' class='td' bgcolor='#999999'>
	<tr bgcolor='#EFEFEF' align='center'>
		<td rowspan='2' width="5%" >사용 </td>
		<td rowspan='2' width="10%">교재번호</td>
		<td rowspan='2' width="20%">카테고리</td>		
		<td rowspan='2' width="30%">교재명</td>
		<td colspan='2'>가격</td>
		<td rowspan='2' width="10%">비고</td>
	</tr>
	<tr bgcolor='#EFEFEF'>
		<td width="12%"  align='center'>정가</td>
		<td  align='center'>판매가</td>
	</tr>

	<?
	for($i=0; $row = mysqli_fetch_array($v);$i++) {
		$tree=f_tree($row['ca_tree']);
	?>
	<tr bgcolor='#FFFFFF'>
		<td align='center'>
			<input type='checkbox' name='bo_useyn'  <?php echo ($row['bo_useyn'] == 'Y')?'checked':'';?> onclick = use_ck("<?php echo $row['bo_num']?>","<?php echo $row['bo_useyn']?>")>
		</td>
		<td align='center'><?php echo $row['bo_num']?></td>
		<td style='padding-left:10px'><?echo $tree; echo $row['ca_name'];?></td>
		<td><?php echo $row['bo_name']?></td>
		<td align='right' style='padding-right:10px'><?php echo number_format($row['bo_list_price'])?></td>
		<td align='right' style='padding-right:10px'><?php echo number_format($row['bo_selling_price'])?></td>
		<td align='center'>
			<a href='./index.php?mode=books_up&c=u&cg_code=<?php echo $cg_code?>&ca_num=<?php echo  $row['ca_num']?>&bo_num=<?php echo $row['bo_num']?>&page=<?php echo $page?>&stx=<?php echo $stx?>&ca_list=<?php echo $ca_list?>'>수정</a>
			<a href="javascript:go_delete('<?php echo $cg_code?>','<?php echo $row['bo_num']?>','<?php echo $page?>','<?php echo $stx?>','<?php echo $ca_list?>')"> 삭제</a>
		</td>
	</tr>
	<? 
	}
	?>	
</table>
<table width =100%>
	<tr>
		<td width=50% align=right><?php echo $pagelist ?></td>
	</tr>
</table>
</form>