<?php
header('Content-Type: text/html;charset=utf-8');

include "../../_lib/db_conn.php";	// 디비 접속
include "../../_lib/global.php";	
include "../../_lib/function.php";	// 관리자 페이지 공용 함수 파일
include "../../_lib/lib.php";	// 관리자 페이지 공용 함수 파일

$list_num	= $_POST['list_num'];					// 리스트 번호
$bo_num		= $_POST['bo_num'];						// 게시판 번호
$comment	= addslashes(trim($_POST['comment']));	// 댓글
$User_Info =  Login_Chk($_COOKIE['LIPASS_ID']);	// 로그인 정보
$mb_type	= $User_Info['type'];				// 멤버타입
$del_num	= $_POST['del_num'];					//삭제 번호, 해당 번호에 값이 있으면 insert 가 아니라 del 임.

if ($User_Info['type'] != "G") {
	$mb_id = $User_Info['id'];						// 멤버 아이디
	$mb_password = "";								// 멤버 비밀번호	
	$mb_name = addslashes($User_Info['name']);		// 멤버 네임
}

$set_use_chk = Set_Chk("set_comment");			// 댓글권한
$board_set = Board_Info($bo_num,"bo_skin"); //게시판 정보를 가져온다.
$board_skin = $board_set['bo_skin'];

if ($set_use_chk['set_comment'] != "Y") {
	echo "X|댓글을 달 수 있는 권한이 없습니다.";
	exit;
}
if (!$list_num) {
	echo "X|접근할 수 없습니다.";
	exit;
}
if (!$del_num) {
	if (!$comment) {
		echo "X|댓글을 입력해 주세요.";
		exit;
	}
}
if (!$mb_id) {
	echo "X|로그인이 필요 합니다.";
	exit;
}


$t_chk = true;	
mysqli_query($CONN['rosemary'],"set autocommit = 0;");
mysqli_query($CONN['rosemary'],"begin;");

	
if (!empty($del_num)) {
	$comment_qry = @mysqli_query($CONN['rosemary'],"delete from board_comment where comment_num = '$del_num'");
	if (!$comment_qry) {
		$t_chk = false;
		$err_msg = "디비 업데이트 실패";	
	}else{
		$update_qry = @mysqli_query($CONN['rosemary'],"update board_list set comment_cnt = comment_cnt - 1 where list_num = '$list_num'");
		if (!$update_qry) {
			$t_chk = false;
			$err_msg = "디비 업데이트 실패";						
		}
	}
}else{
	$comment_qry = mysqli_query($CONN['rosemary'],"
									insert into board_comment(
																	list_num,
																	mb_id,
																	mb_password,
																	mb_name,
																	comment,
																	reg_date,
																	user_ip
									) 
									values(
																	'$list_num',
																	'$mb_id',
																	'$mb_password',
																	'$mb_name',
																	'$comment',
																	unix_timestamp(),
																	'$host_ip'
									)");



	if (!$comment_qry) {
		$t_chk = false;
		$err_msg = "디비 업데이트 실패";	
	}else{
		$update_qry = @mysqli_query($CONN['rosemary'],"update board_list set comment_cnt = comment_cnt + 1 where list_num = '$list_num'");
		if (!$update_qry) {
			$t_chk = false;
			$err_msg = "디비 업데이트 실패";						
		}
	}
}



if ($t_chk != true) {
	mysqli_query($CONN['rosemary'],"rollback;");
	echo "X|".$err_msg;
} else {
	mysqli_query($CONN['rosemary'],"commit;");	

	ob_start();
	echo "T|";

	$comment_query = mysqli_query($CONN['rosemary'],"select * from board_comment where list_num = '$list_num' order by comment_num desc");
	$comment_nums = mysqli_num_rows($comment_query);

	echo "
					<div class='comment'>
						<p class='com_title'>댓글 ".number_format($comment_nums)."</p>
						<ul class='com_list'>

	";



	if ($comment_nums) {
		while($comment_rs = mysqli_fetch_array($comment_query)) {
			$com_name = $comment_rs['mb_name'];
			$comment = $comment_rs['comment'];
			$com_date = date("Y-m-d h:i:s",$comment_rs['reg_date']);
			$com_num =  $comment_rs['comment_num'];
			if ($comment_rs['mb_id'] == $mb_id) {
				$del_chk = "<a href=\"javascript:send_comment_go('".$com_num."')\"><img class='btn_sdel' src='".$MY_URL."_template/skin/board/".$board_skin."/images/board/btn_sdel.gif ' alt='삭제' /></a>";
			} else {
				$del_chk = "";
			}


			echo "
				<li><p>$com_name<span class='ft_style'>　l　$com_date</span> $del_chk </p>
				$comment
				</li>

			";
	}}else{
			echo "
				<tr bgcolor='#FFFFFF'>
					<td width=20% align=center colspan=3>등록된 댓글이 없습니다.</td>
				</tr>
			";
	}
		

	echo "
						</ul>
				
						<div><textarea style='width:87%; height:50px;' name='comment' rows='3' cols='20'></textarea><span class='blind'>내용</span>
						<input type='button' name='bod_btn_wirte' class='bod_btn_wirte' value='등록' onclick='send_comment_go()' /></div>

					</div>

	";


		$concon=ob_get_contents();
		ob_end_clean();
		echo $concon;
		
}
?>


