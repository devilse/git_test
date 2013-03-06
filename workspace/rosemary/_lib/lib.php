<?php
function Board_Info($bo_num,$feild="*") //게시판 정보 가져오기
{	
	global $CONN;
	$board_info_query = mysqli_query($CONN['rosemary'],"select $feild from board where bo_num = '$bo_num'");
	$board_info_nums = @mysqli_num_rows($board_info_query);
	if($board_info_nums){
		$board_info_rs = @mysqli_fetch_array($board_info_query);
	}
	return $board_info_rs;
}


function Login_Chk($cookie) // 관리자 로그인 체크
{	
	if (!trim($cookie)) {
		$USER_INFO["type"] = "G";		//유저 유형
		$USER_INFO["id"] = "GUEST";
		$USER_INFO["name"] = "";
	} else {
		$USER_INFO = explode('|',skuncrypt($cookie));
		$USER_INFO["type"] = trim($USER_INFO[0]);		//유저 유형
		$USER_INFO["id"] = trim($USER_INFO[1]);
		$USER_INFO["name"] = trim($USER_INFO[2]);
		$USER_INFO["menuIdx"] = trim($USER_INFO[3]);
		$USER_INFO["admin_type"] = trim($USER_INFO[4]);
		$USER_INFO["member_num"] = trim($USER_INFO[5]);		
	}
	return $USER_INFO;
}


function Set_Chk($val, $tbl = "board_user_set") // 해당 기능 접근 권한 체크 
{			
	global $bo_num,$mb_type,$MY_URL,$CONN;
	
	$val_length = count(explode(",",$val));		
	$chk_qry = mysqli_query($CONN['rosemary'],"select $val from $tbl where bo_num = '$bo_num' and mt_code = '$mb_type'");
	if ($val_length > 1 || $val == "*") {
		$chk = mysqli_fetch_array($chk_qry);
	} else {
		$chk = mysqli_result($chk_qry,0,0);
	}

	return $chk;
}


function Set_Qna_Chk($val) // 해당 기능 접근 권한 체크
{			
	global $mb_type,$MY_URL,$CONN;	
	if (!$mb_type || !$val) {
		alertGo("",$MY_URL);
	}

	$val_length = count(explode(",",$val));	
	$chk_qry = mysqli_query($CONN['rosemary'],"select $val from qna_user_set where mt_code = '$mb_type'");
	if ($val_length > 1) {
		$chk = mysqli_fetch_array($chk_qry);
	} else {
		$chk = mysqli_result($chk_qry,0,0);
	}
	return $chk;
}


function Member_Type_Name($type)	//사용자 타입의 이름을 가져옴
{
	global $CONN;	
	if (!$type) {
		alert("필수 정보 누락");
	}
	$type_qry = mysqli_query($CONN['rosemary'],"select mt_name from member_type where mt_code = '$type' limit 1");
	$type_name = mysqli_result($type_qry,0,0);

	return $type_name;
}


function move( $from, $to )
{	// 첨부 이미지 임시 디렉토리에서 실제 디렉토리 이동	
	if (copy($from, $to)){
		unlink($from);
		return TRUE;
	} else {
		return FALSE;
	}
}


function Set_Login_log($num)		//로그인 로그 인설트
{
	global $host_ip,$CONN;
	
	$browser = @get_browser(null, true);
	$os = $browser['platform'];
	$browser = $browser['browser'];
	@mysqli_query($CONN['rosemary'],"insert into member_loginlog(mb_num,mbl_browser,mbl_os,mbl_ip,mbl_regdate) values('$num','$os','$browser','$host_ip',unix_timestamp())");
}


function View_My_Chk($set_chk,$list_num,$id)
{	//자기 글 보기 권한 체크
	if ($set_chk != "Y") {
		// 보기 권한이 없다고 해도 자신의 글이라면 볼 수 있어야한다.
		$list_chk_query = mysqli_query($CONN['rosemary'],"select * from board_list where list_num = '$list_num' and mb_id = '$id'");
		$list_chk_nums = mysqli_num_rows($list_chk_query);
		if (!$list_chk_nums) {
			return "N";
		} else {
			return "Y";
		}
	}
}

function Chk_view($num)
{
	global $CONN;
	if (!empty($num)) {
		mysqli_query($CONN['rosemary'],"update board_list set hit_cnt = hit_cnt + 1 where list_num = '$num'");
	}
}


function Member_Info($val, $tbl = "member") // 해당 기능 접근 권한 체크 
{			
	global $mb_num,$mb_type,$MY_URL,$CONN;
	
	$val_length = count(explode(",",$val));		
	$chk_qry = mysqli_query($CONN['rosemary'],"select $val from $tbl where mb_num = '$mb_num'");
	if ($val_length > 1 || $val == "*") {
		$chk = mysqli_fetch_array($chk_qry);
	} else {
		$chk = mysqli_result($chk_qry,0,0);
	}

	return $chk;
}

function Member_Goods_Cnt($mb_num,$chk)
{
	global $CONN;

	$q = @mysqli_query($CONN['rosemary'],"select count(*) as cnt from member_goods_lecture A, member_goods B where A.os_num = B.os_num and A.g_num = B.g_num and A.mbgl_state = '$chk' and B.mb_num = '$mb_num'");
	$n = @mysqli_result($q,0,0);
	
	return $n;
}

function Member_Ordersheet_Cnt($mb_num,$chk)
{
	global $CONN;

	$q = @mysqli_query($CONN['rosemary'],"select count(*) from ordersheet where mb_num = '$mb_num' and os_state = '$chk'");
	$n = @mysqli_result($q,0,0);
	
	return $n;
}
function Chk_Goods_End($mb_num)
{
	global $CONN;

	

	$q = mysqli_query($CONN['rosemary'],"select 
								B.os_num,
								B.g_num,
								B.lt_num
					   from 
								member_goods A, member_goods_lecture B, member_goods_lecture_usehistory C 
					   where 
								A.mb_num  = '$mb_num' and 
								A.mbg_state = 'A' and 
								A.os_num = B.os_num and 
								A.g_num = B.g_num and 
								B.mbgl_state = 'B' and 
								A.os_num = C.os_num and
								A.g_num = C.g_num and
								B.lt_num = C.lt_num and 
								C.history_state = 1 and 
								C.mbglu_edate < unix_timestamp()
						group by C.os_num, C.g_num, C.lt_num
						");
	$n = @mysqli_num_rows($q);	
	if ($n) {
		while ($rs = mysqli_fetch_array($q)) {
			$os_num = $rs['os_num'];
			$g_num = $rs['g_num'];
			$lt_num = $rs['lt_num'];
			//echo "update member_goods_lecture set mbgl_state = 'D' where os_num = '$os_num' and g_num = '$g_num' and lt_num = '$lt_num'";
			//exit;
			@mysqli_query($CONN['rosemary'],"update member_goods_lecture set mbgl_state = 'D' where os_num = '$os_num' and g_num = '$g_num' and lt_num = '$lt_num'");
		}
	}


}
?>