<?php
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
header('Content-Type: text/html;charset=utf-8');

include "../../_lib/function.php";	// 관리자 페이지 공용 함수 파일
include "../../_lib/db_conn.php";	// 디비 접속	
include "../../_lib/global.php";	// 관리자 페이지 공용 변수 파일	
include "../../_lib/lib.php";	

$mb_id = $_GET['mb_id'];


$board_log_query = mysqli_query($CONN['rosemary'],"select count(*) as cnt from board_list where mb_id = '$mb_id' and del_chk = 'N' order by list_num desc");
$query_number = mysqli_result($board_log_query,0,0);


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
		<td align=center colspan=6> 
			<table width=100%>
				<tr>
					<td align=center><b>작성글보기</b></td>
				</tr>
			</table>
		</td>
	</tr>
	<tr bgcolor="#EFEFEF">
		<td align=center width=5%>번호</td>
		<td align=center width=20%>게시판명</td>
		<td align=center width=40%>제목</td>
		<td align=center width=5%>댓글</td>
		<td align=center width=5%>조회</td>
		<td align=center width=10%>등록일</td>
	</tr>
<?php
if ($query_number) {	
	$number = $query_number - $first;
	$board_log_query2 = mysqli_query($CONN['rosemary'],"select *,(select bo_name from board b where b.bo_num = a.bo_num) as bo_name from board_list a where mb_id = '$mb_id' and del_chk = 'N' order by list_num desc $limit");
	while($board_log_rs = mysqli_fetch_array($board_log_query2)){
		$bo_name = $board_log_rs['bo_name'];
		$title	= mb_strimwidth($board_log_rs['title'], 0, 60, "...", "UTF-8");	// 제목
		$hit = number_format($board_log_rs['hit_cnt']);
		$comment_cnt = number_format($board_log_rs['comment_cnt']);
		$list_num = $board_log_rs['list_num'];
		$bo_num = $board_log_rs['bo_num'];


		$reg_date = date("Y-m-d H:i:s",$board_log_rs['reg_date']);
?>
	<tr bgcolor="#FFFFFF">
		<td align=center><?php echo $number;?></td>
		<td align=center><?php echo $bo_name;?></td>
		<td align=left><a href="../board/index.php?mode=board_view&list_num=<?php echo $list_num;?>&bo_num=<?php echo $bo_num;?>" target="_blink"><?php echo $title;?></a></td>
		<td align=center><?php echo $comment_cnt;?></td>
		<td align=center><?php echo $hit;?></td>
		<td align=center><?php echo $reg_date;?></td>
	</tr>
<?php
$number--;
	}
?>
	<tr bgcolor="#FFFFFF">
		<td align=center colspan=6><?php echo go_page($query_number, $num_per_page, $num_per_block, $page, "./board_log.php?mb_id=$mb_id&", $key, $searchword,$mode);?></td>
	</tr>
<?php
} else {	
?>
	<tr bgcolor="#FFFFFF">
		<td align=center colspan=6>등록된 데이터가 없습니다.</td>
	</tr>
<?php }?>
</table>

</body>
</html>