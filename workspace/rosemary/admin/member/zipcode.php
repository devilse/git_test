<?php
	include "../../_lib/function.php";	// 관리자 페이지 공용 함수 파일
	include "../../_lib/db_conn.php";	// 디비 접속	
	include "../../_lib/global.php";	// 관리자 페이지 공용 변수 파일
	include "../../_lib/lib.php";	// 관리자 페이지 공용 디비 함수 파일
	
	$gbn = $_GET['gbn'];
	$zip1 = $_GET['zip1'];
	$zip2 = $_GET['zip2'];
	$form = $_GET['form'];
	$add = $_GET['add'];
	$zip = trim(addslashes($_POST['zip']));

	if(empty($gbn)) {
		$gbn = "";
	}
	if($gbn =='') {
		$gbn='1';
	}

?>
<script type="text/javascript">
	function go_search()
	{
		var f=document.zip_search;
		
		if(f.zip.value ==''){
			alert('검색어를 입력하세요');
			return;
		}

		f.submit();
	}

	function go_zip(zipcode1,zipcode2,address)
	{
		
		opener.document.<?php echo $form; ?>.<?php echo $zip1; ?>.value = zipcode1;
		opener.document.<?php echo $form; ?>.<?php echo $zip2; ?>.value = zipcode2;
		opener.document.<?php echo $form; ?>.<?php echo $add; ?>.value = address;

		 window.close();
	}

</script>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	</head>

	<body>
		<table width="100%" border="0" cellspacing="1" cellpadding="3" class="td" bgcolor="#999999">

			<form name='zip_search' method='post'>
			<tr> 
				<td bgcolor='#FFFFFF' style='padding:10 10 10 20' colspan='2'>
				<?php
				if($gbn == '1') {
					echo "지 번 &nbsp;&nbsp;| &nbsp;&nbsp;<a href='./zipcode.php?gbn=2'>도로명</a>";
				} else {
					echo "<a href='./zipcode.php?gbn=1'>지번</a> &nbsp;&nbsp;| &nbsp;&nbsp;도로명 ";
				}
				?>		
				</td>
			</tr>
			<tr bgcolor='#FFFFFF'>
				<td align='center' style='padding:10 10 10 10' colspan='2'>
					<input type='text' name='zip' style='width:150px' value=''>
					<input type='button' value='검색' onclick='javascript:go_search();'>

				</td>
			</tr>
			</form>

			<form name='zip_list' method='post'>
			<tr>
				<td bgcolor='#EFEFEF' width='30%' align='center'> 우편번호 </td>
				<td bgcolor='#EFEFEF' align='center'> 주소 </td>
			</tr>

			
			<?php
			if($zip || !empty($zip)) {
				if($gbn == '1') {

					$sql = @sql_query($CONN['rosemary'],"select * from zipcode where dong like '%$zip%'");

					for($i=0; $rows = mysqli_fetch_array($sql); $i++) {
						echo" <tr bgcolor='#FFFFFF'><td align='center'>";

						$zipcode1 = substr($rows['zipcode'],0,3);
						$zipcode2 = substr($rows['zipcode'],3,6);
						$address = $rows['sido'] .' '. $rows['gugun'] .' '. $rows['dong'];
						$address1 = $rows['sido'] .' '. $rows['gugun'] .' '. $rows['dong'] .' '. $rows['ri'] .' '. $rows['bunji'];

						$zipcode = $zipcode1 .'-'. $zipcode2 ;
						
						?>
						<a href ="javascript:go_zip('<?php echo $zipcode1?>','<?php echo $zipcode2?>','<?php echo $address?>')"><?php echo $zipcode?></a>

						
						</td><td>
							<a href ="javascript:go_zip('<?php echo $zipcode1?>','<?php echo $zipcode2?>','<?php echo $address?>')"><?php echo $address1;?></a>
						</td></tr>
						<?php
					}


				} else if($gbn == '2') {

					$sql = @sql_query($CONN['rosemary'],"select * from road_zipcode where roadname like '%$zip%'");

					for($i=0; $rows = mysqli_fetch_array($sql); $i++) {
						echo" <tr bgcolor='#FFFFFF'><td align='center'>";

						$zipcode1 = substr($rows['zipcode'],0,3);
						$zipcode2 = substr($rows['zipcode'],3,6);
						$address = $rows['sido'] .' '. $rows['gugun'] .' '. $rows['roadname'];
						$address1 = $rows['sido'] .' '. $rows['gugun'] .' '. $rows['roadname'] .' '. $rows['building_num1'];
							
						$zipcode = $zipcode1 .'-'. $zipcode2 ;
						
						?>
						<a href ="javascript:go_zip('<?php echo $zipcode1?>','<?php echo $zipcode2?>','<?php echo $address?>')"><?php echo $zipcode?></a>

						<?php
						echo '</td><td>';
						echo $address1;
						echo'</td></tr>';
					}
				}	
			}			
			?>
			</form>
		</table>
	</body>
</html>