<?php
include "../../_lib/function.php";	// 관리자 페이지 공용 함수 파일
include "../../_lib/db_conn.php";	// 디비 접속	
include "../../_lib/global.php";	// 관리자 페이지 공용 변수 파일	
include "../../_lib/lib.php";	

$User_Info =  Login_Chk($_COOKIE[LIPASS_ID]);
$mb_type = $User_Info['type'];
$mb_num = $User_Info['member_num'];
if ($User_Info[0] != "M" || !$mb_num) {
	alert("로그인이 필요 합니다.");
}

function Send($filename)
{
	header("Content-type: application/vnd.ms-excel");
	header("Content-Disposition: attachment; filename=\"$filename\"");
	header("Expires: 0");
	header("Cache-Control: must-revalidate, post-check=0,pre-check=0");
	header("Pragma: public");
	header("charset=utf-8");
}
$filename	 =	 "member.xls";
Send($filename);

$key = $_GET['key'];
$keyword = $_GET['keyword'];

if ($key) {
	$condi = "where $key like '%$keyword%'";
}

$sql = mysqli_query($CONN['rosemary'],"select A.* from member A, member_student B where A.mb_num = B.mb_num  $condi");
?>

<html>
	<body>
	<meta http-equiv="Content-Type" content="application/vnd.ms-excel;charset=utf-8">
		<table>
			<tr>
				<td width = "100">
					번호	
				</td>	
				<td width = "100">
					회원구분	
				</td>	
				<td width = "150">
					ID
				</td>
				<td width = "150">
					이름
				</td>
				<td width = "200">
					전화번호
				</td>		
				<td width = "200">
					휴대번호
				</td>
				<td width = "200">
					이메일
				</td>
			
			</tr>
			<?php
			while($query = mysqli_fetch_array($sql)) {
			?>
			<tr>
				<td>
					<?php echo $query['mb_num'] ?>
				</td>
				<td>
					<?php
					if ($query['mt_code'] == 'S') {	
						echo '학습자'; 
					}
					if ($query['mt_code'] == 'T') {
						echo '교수자'; 
					}
					if ($query['mt_code'] == 'M') {
						echo '영업자';
					}
					if ($query['mt_code'] == 'A') {
						echo '관리자';
					}
					?>
				</td>
				<td>
					<?php echo $query['mb_id'] ?>
				</td>
				<td>
					<?php echo $query['mb_name'] ?>
				</td>
				<td>
					<?php
					$tel = substr($query['mb_tel'],0,4) .'-'. substr($query['mb_tel'],4,4) .'-'. substr($query['mb_tel'],8,4);
					echo $tel;
					?>	
				</td>		
				<td>
					<?php
					$hp = substr($query['mb_hp'],0,3) .'-'. substr($query['mb_hp'],3,4) .'-'. substr($query['mb_hp'],7,4);
					echo $hp;
					?>
				</td>
				<td>
					<?php echo $query['mb_email'] ?>
				</td>
			
			</tr>
			<?php } ?>
		</table>
	</body>
</html>