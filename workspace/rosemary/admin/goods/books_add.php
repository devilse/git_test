<?php

$c = $_GET['c'];
$cg_code = $_GET['cg_code'];
$ca_num = $_GET['ca_num'];
$bo_num = $_GET['bo_num'];
$page = $_GET['page'];
$stx = $_GET['stx'];
$ca_list = $_GET['ca_list'];
$cg_list = $_GET['cg_list'];

if ($c =='') {

	//$bo['bo_useyn'] = Y;
	$html_title .= " 생성";

	$sql2 = "SELECT * FROM category_group WHERE cg_useyn='Y'" ;

	$result2 = mysqli_query($CONN['rosemary'],$sql2);
} else if ($c =='u') {

	$bo1 = mysqli_query($CONN['rosemary'],"select * from book where bo_num = '$bo_num'");

	$bo = mysqli_fetch_array($bo1);
	$html_title .= " 수정";

	$sql2 = "SELECT * FROM category_group WHERE cg_code='$cg_code'" ;
	$result2 = mysqli_query($CONN['rosemary'],$sql2);

} else {
	alert("잘못된 값이 넘어왔습니다.");
}
?>
<script type='text/javascript'>
	function fncGet()
	{
		var fm  = document.books1;
		var cg_code= '';

		cg_code= fm.cg_code.options[fm.cg_code.selectedIndex].value;

		document.location.href="./index.php?mode=books_add&cg_code="+cg_code ;
	}

	function fncGet1()
	{
		var fm  = document.books1;

		cg_code= document.books1.cg_code.value;
		ca_num= fm.ca_num.options[fm.ca_num.selectedIndex].value;

		document.location.href="./index.php?mode=books_add&ca_num="+ca_num+"&cg_code="+cg_code;
	}

	function books2_check()
	{
		b = document.books2;
		
		var tmp_image = document.books2.bo_img;
		var bo_img_del = document.books2.bo_img_del;
		var l_price = document.books2.bo_l_price.value;
		var s_price = document.books2.bo_s_price.value;
		var page = document.books2.bo_page.value;
		var ca_num = document.books2.ca_num.value;
		var c = document.books2.c.value;
		var bo_num = document.books2.bo_num.value;
		var ca_list = document.books2.ca_list.value;

		if(b.c.value == ''){
			b.ca_list.value = b.ca_num.value;
		}
		if(!document.books1.ca_num.value){
				alert("분류를 선택하세요");
				document.books1.ca_num.focus();
				return false;
		}

		if(!document.books2.bo_name.value){
				alert("교재명을 입력하세요.");
				b.bo_name.focus();
				return false;
		}
		
		if(l_price){
			if(l_price.match(/^\d+$/gi) == null){
				alert("정가에 숫자만 넣으세요!");
				b.bo_l_price.focus();
				return false;
			}
		}
		if(s_price){
			if(s_price.match(/^\d+$/gi) == null){
				alert("판매가에 숫자만 넣으세요!");
				b.bo_s_price.focus();
				return false;
			}
		}
		if(page){
			if(page.match(/^\d+$/gi) == null){
				alert("페이지에 숫자만 넣으세요!");
				b.bo_page.focus();
				return false;
			}
		}

	   if (tmp_image.value) {
			if (!tmp_image.value.toLowerCase().match(/.(gif|jpg|png)$/i)) {
				alert("이미지가 gif, jpg, png 파일이 아닙니다.");
				return false;
			}
			if (bo_img_del) {
				var img = confirm("기존 사진이 있습니다. 대체하시겠습니까?");

				if (!img) {
					return false;
				}
			}
		}

		   
		b.action = "./books_update.php?c="+c+"&ca_num="+ca_num+"&bo_num="+bo_num+"&ca_list="+ca_list;
	}
</script>

<table width='100%' border='0' align="center" cellspacing='1' cellpadding='6' class='td' bgcolor='#999999'>
  	<form name='books1'>
  	<input type='hidden' name='c'    value='<?php echo $c?>'>
	<input type='hidden' name='bo_num' value='<?php echo  $bo_num?>'>
	<input type='hidden' name='ca_list' value='<?php echo $ca_list?>'>
	<input type='hidden' name='page'  value='<?php echo $page?>'>
	<input type='hidden' name='stx'   value='<?php echo $stx?>'>

<?php  
if($c=='u')
	echo"<input type='hidden' name='cg_code' value='$cg_code'>";
?>
  
	<tr height='30'>
		<td align='right' bgcolor='#EFEFEF'> 그룹</td>
		<td style='padding-left:10px' bgcolor='#FFFFFF'>
		<?php  if($c =='u'){
			$row2 = mysqli_fetch_array($result2);
			echo $row2['cg_name'];
		}else{ ?>
		<select name='cg_code' onchange='javascript_:fncGet();' required itemname="그룹">
			<?php
			for ($i=0; $row2=mysqli_fetch_array($result2); $i++){
				echo "<option value='$row2[cg_code]' >$row2[cg_name]</option>\n";
			}
			?>
		</select>
		<script type="text/javascript">document.books1.cg_code.value="<?php echo $cg_code?>";</script>
		<?php  }?>
		</td>
		<td align='right' bgcolor='#EFEFEF'> 분류</td>
		<td style='padding-left:10px' bgcolor='#FFFFFF'>
		<?php 
		$v_sql1 = mysqli_query($CONN['rosemary'],"select * from category where cg_code='$cg_code'");
		 ?>
		<select name='ca_num' onchange='javascript_:fncGet1();' required itemname="분류">
			<?php
			for ($i=0; $row1=mysqli_fetch_array($v_sql1); $i++){
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
		<script type="text/javascript">document.books1.ca_num.value="<?php echo $ca_num?>";</script> 
		</td>
	</tr>
	</form>
	
	<form name='books2' method='post' onsubmit="return books2_check(this);" enctype="multipart/form-data">
	<input type='hidden' name='c'    value='<?php echo $c?>'>
	<input type='hidden' name='bo_num' value='<?php echo $bo_num?>'>
	<input type='hidden' name='ca_num' value='<?php echo $ca_num?>'>
	<input type='hidden' name='cg_code' value='<?php echo $cg_code?>'>
	<input type='hidden' name='page'  value='<?php echo $page?>'>
	<input type='hidden' name='stx'   value='<?php echo $stx?>'>
	<input type='hidden' name='ca_list' value='<?php echo $ca_list?>'>
	<input type='hidden' name='cg_list' value='<?php echo $cg_list?>'>
	<input type='hidden' name='mode'   value='<?php echo $mode?>'>

	<tr height='30'>
		<td align='right' bgcolor='#EFEFEF'>교재 명</td>
		<td style='padding-left:10px' bgcolor='#FFFFFF'><input type='text' name='bo_name' value="<?php echo $bo['bo_name']?>" required itemname="교재명"></td>
		<td align='right' bgcolor='#EFEFEF'>사용유무</td>
		<td style='padding-left:10px' bgcolor='#FFFFFF'>
		<input type='checkbox' name='bo_useyn'  value = "Y" <?php echo ($bo['bo_useyn'] == 'Y')?'checked':'';?>>사용 
		</td>
	</tr>
	<tr height='30'>
		<td align='right' bgcolor='#EFEFEF'>가격</td>
		<td colspan ='3' bgcolor='#FFFFFF'>
			<table border='0' width='100%'>
				<tr height='30' >
					<td align='center' width='20%' bgcolor='#EFEFEF'>정가</td>
					<td align='left'><input type='text' name='bo_l_price' value="<?php echo $bo['bo_list_price'] ?>" style='text-align:right;'></td>
				</tr>
				<tr height='30'>
					<td align='center' bgcolor='#EFEFEF'>판매가</td>
					<td align='left'><input type='text' name='bo_s_price' value="<?php echo $bo['bo_selling_price'] ?>" style='text-align:right;'></td>
				</tr>
			</table>
		</td>
	</tr>
	<tr height='30'>
		<td align='right' bgcolor='#EFEFEF'>저자명</td>
		<td style='padding-left:10px' bgcolor='#FFFFFF'><input type='text' name='bo_writer' value="<?php echo $bo['bo_writer']?>"></td>
		<td align='right' bgcolor='#EFEFEF'>페이지 수</td>
		<td style='padding-left:10px' bgcolor='#FFFFFF'><input type='text' name='bo_page' value="<?php echo $bo['bo_page_cnt']?>" style='text-align:right;'></td>
	</tr>
	<tr height='30'>
		<td align='right' bgcolor='#EFEFEF'>출판사</td>
		<td colspan ='3' style='padding-left:10px' bgcolor='#FFFFFF'><input type='text' name='bo_publisher' value="<?php echo $bo['bo_publisher']?>"></td>
	</tr>
	<tr height='30'>
		<td align='right' bgcolor='#EFEFEF'>교재 설명</td>
		<td colspan ='3' bgcolor='#FFFFFF' ><textarea name='bo_e_book' style='width:100%;' rows='10' colos='50'><?php echo $bo['bo_explain_book']?></textarea></td>
	</tr>
	<tr height='30'>
		<td align='right' bgcolor='#EFEFEF'>교재 목차</td>
		<td colspan ='3' bgcolor='#FFFFFF'><textarea name='bo_e_writer'  style='width:100%;' rows='10' colos='50'><?php echo $bo['bo_explain_writer']?></textarea> </td>
	</tr>
	<tr height='30'>
		<td align='right' bgcolor='#EFEFEF'>이미지 등록</td>
		<td colspan ='3' style='padding-left:10px' bgcolor='#FFFFFF'>
			<input type="file" name="bo_img"  size="40" maxlength='100'>
			<?php 
	        if ($bo['bo_img'])
	            echo "<br><a href='../../dir_img/books_img/$bo[bo_img]' target='_blank'>$bo[bo_img]</a> 
	        <input type=checkbox name='bo_img_del' value='$bo[bo_img]'> 삭제<br>
	        <img src='../../dir_img/books_img/$bo[bo_img]'></img>
	        ";
	        ?>
		</td>
	</tr>
	<tr height='30'>
		<td colspan ='4' align="right" style='padding-right:20px'>
		<input type='submit' value=' 저 장 '>&nbsp;&nbsp;
			<input type='button' value=' 취 소 ' onclick = "document.location.href='./index.php?mode=books&cg_code=<?php echo $cg_list?>&page=<?php echo $page?>&stx=<?php echo $stx?>&ca_list=<?php echo $ca_list?>';">
		</td>
	</tr>
	</form>
</table>