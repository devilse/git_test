<?
include '../../_include/lib_include.php';
if (!$siteoption['skin_class']) {
	$siteoption['skin_class'] = "basic";
}
$tpl->define('frame', "skin/class/".$siteoption['skin_class']."/my_player.html");


$lt_num = $_GET['lt_num'];
$os_num = $_GET['os_num'];
$g_num = $_GET['g_num'];
$lts_num = $_GET['lts_num'];
$ltsp_num = $_GET['ltsp_num'];	// 보여줄 강의 번호

$tpl->assign('lt_num', $lt_num);
$tpl->assign('os_num', $os_num);
$tpl->assign('g_num', $g_num);
$tpl->assign('lts_num', $lts_num);

if (!$lt_num || !$os_num || !$g_num) {
	alertclose("접근 할 수 없습니다.");
}

// 로그인 체크
$User_Info =  Login_Chk($_COOKIE['LIPASS_ID']);
$mb_type = $User_Info['type'];
$mb_num = $User_Info['member_num'];
if (!$mb_type || $mb_type == "G" || !$mb_num) {
	alertclose("로그인이 필요 합니다.");
}


// 자신의 게시물이 맞는지 체크 한다.
$chk_query = mysqli_query($CONN['rosemary'],"select A.mbgl_term from member_goods_lecture A, member_goods B where A.lt_num = '$lt_num' and A.os_num = '$os_num' and A.g_num = '$g_num'  and A.os_num = B.os_num and A.g_num = B.g_num and B.mb_num = '$mb_num' and A.mbgl_state = 'B'");
$chk_nums = mysqli_num_rows($chk_query);
if (!$chk_nums) {
	alertback("존재하지 않는 강의 입니다.");
} else {
	// 수강기간이 남앗는지 체크한다.
	$history_qry = mysqli_query($CONN['rosemary'],"select * from member_goods_lecture_usehistory where os_num = '$os_num' and g_num = '$g_num' and lt_num = '$lt_num' and history_state = 1 order by mbglu_num desc limit 1");
	$history_nums = mysqli_num_rows($history_qry);
	if (!$history_nums) {	//만약에 로그가 하나도 존재하지 않는다면 프로세스를 중단하고 해당 강좌를 대기상태로 돌린다. 
		alertclose("히스토리 로그가 존재하지 않습니다. 관리자에게 문의 하세요.");
	} else {
		$history_rs = mysqli_fetch_array($history_qry);
		if (mktime() > $history_rs['mbglu_edate']) {
			alertclose("해당 강좌는 수강기간이 만료 되었습니다.");
		}
		
		// 해당 강좌의 강좌목록을 가져온다.
		$subject_qry = mysqli_query($CONN['rosemary'],"select * from goods_lecture_subjects where lt_num = '$lt_num'");
		$subject_nums = mysqli_num_rows($subject_qry);
		if (!$subject_nums) {
			alertclose("존재하지 않는 강좌 입니다.");
		}
		$subject_loop = array();
		while ($rs = mysqli_fetch_array($subject_qry)) {
			if (!$lts_num) {
				$lts_num = $rs['lts_num'];
			}
			$subject_loop[] = $rs;
		}
		$tpl->assign('subject_list', $subject_loop);
		

		// 해당 강좌의 강의	를 가져온다.
		$period_qry = mysqli_query($CONN['rosemary'],"select * from goods_lecture_subjects_period where lts_num = '$lts_num' and ltsp_sample_yn = 'N' order by ltsp_period_num asc");
		$period_nums = mysqli_num_rows($period_qry);
		$period_loop = array();
		$number = 1;
		while ($period_rs = mysqli_fetch_array($period_qry)) {
			$period_rs['number'] = $number;
			if (!$ltsp_num) {
				$ltsp_num = $period_rs['ltsp_num'];
			}
			$period_loop[] = $period_rs;
			$number++;
		}
		$tpl->assign('period_nums', $period_nums);
		$tpl->assign('period_list', $period_loop);
		
		// 플레이어에 보여질 강의
		$now_period_qry = mysqli_query($CONN['rosemary'],"select * from goods_lecture_subjects_period where ltsp_num = '$ltsp_num'");
		$now_period_nums = mysqli_num_rows($now_period_qry);
		if ($now_period_nums) {
			$now_period_rs = mysqli_fetch_array($now_period_qry);
			$ltsp_url = $now_period_rs['ltsp_url']; 
			$ltsp_name = $now_period_rs['ltsp_name'];
			$tpl->assign('ltsp_url', $ltsp_url);
			$tpl->assign('ltsp_name', $ltsp_name);
			//mms://media.pyeonib.com/PYEONIB/edustory/nie/3.WMV
		}



	}

}

$tpl->print_('frame');

?>