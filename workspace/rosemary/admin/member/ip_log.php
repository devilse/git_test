<?php
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
header('Content-Type: text/html;charset=utf-8');

include "../../_lib/function.php";	// 관리자 페이지 공용 함수 파일
include "../../_lib/db_conn.php";	// 디비 접속	
include "../../_lib/global.php";	// 관리자 페이지 공용 변수 파일	
include "../../_lib/lib.php";	

$mb_num = $_GET['mb_num'];

if (!$mb_num) {
	alertclose("접근 할 수 없습니다.");
}



$ip_log_query = mysqli_query($CONN['rosemary'],"select *,MAX(mbl_regdate) reg_date from member_loginlog where mb_num = '$mb_num' group by mbl_ip order by mbl_regdate desc");
$query_number = mysqli_num_rows($ip_log_query);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title><?php echo $siteinfo['si_site_name']; ?> 관리자</title>

<style type="text/css">
html {overflow: scroll; overflow-x: auto;}
body, td, p, input, button, textarea, select, .c1 { font-family:Tahoma,굴림; font-size:9pt; color:#222222; }

form { margin:0px; }

/* img {border:0px;} */

a:link, a:visited, a:active { text-decoration:none; color:#466C8A; }
a:hover { text-decoration:none; }





a.menu:link, a.menu:visited, a.menu:active { text-decoration:none; color:#454545; }
a.menu:hover { text-decoration:none; }



input.ed { height:20px; border:1px solid #9A9A9A; border-right:1px solid #D8D8D8; border-bottom:1px solid #D8D8D8; padding:3px 2px 0 2px; }
input.ed_password { height:20px; border:1px solid #9A9A9A; border-right:1px solid #D8D8D8; border-bottom:1px solid #D8D8D8; padding:3px 2px 0 2px; font:10px Tahoma; }
textarea.tx { border:1px solid #9A9A9A; border-right:1px solid #D8D8D8; border-bottom:1px solid #D8D8D8; padding:2px; }


</style>


</head>

<body>


<table width="100%" border="0" cellspacing="1" cellpadding="3" class="td" bgcolor="#999999" style="white-space:nowrap">
	<tr bgcolor="#EFEFEF" height=30> 
		<td align=center colspan=3> 
			<table width=100%>
				<tr>
					<td align=center><b>사용아이피</b></td>
				</tr>
			</table>
		</td>
	</tr>
	<tr bgcolor="#EFEFEF">
		<td align=center>번호</td>
		<td align=center>아이피</td>
		<td align=center>접속일</td>
	</tr>
<?php
if ($query_number) {	
	$number = $query_number - $first;
	$ip_log_query2 = mysqli_query($CONN['rosemary'],"select *,MAX(mbl_regdate) reg_date from member_loginlog where mb_num = '$mb_num' group by mbl_ip order by mbl_regdate desc $limit");
	while($ip_log_rs = mysqli_fetch_array($ip_log_query2)){
		$ip = $ip_log_rs['mbl_ip'];
		$reg_date = date("Y-m-d H:i:s",$ip_log_rs['reg_date']);
?>
	<tr bgcolor="#FFFFFF">
		<td align=center><?php echo $number;?></td>
		<td align=center><?php echo $ip;?></td>
		<td align=center><?php echo $reg_date;?></td>
	</tr>
<?php
$number--;
	}
?>
	<tr bgcolor="#FFFFFF">
		<td align=center colspan=3><?php echo go_page($query_number, $num_per_page, $num_per_block, $page, "./ip_log.php?mb_num=$mb_num&", $key, $searchword,$mode);?></td>
	</tr>
<?php
} else {	
?>
	<tr bgcolor="#FFFFFF">
		<td align=center colspan=3>등록된 데이터가 없습니다.</td>
	</tr>
<?php }?>
</table>

</body>
</html>