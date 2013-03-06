<?php
include '../../_include/lib_include.php';
include '../include/frame_a.php';

$first_lt_num = $_POST['lt_num'];
$ca_num = $_GET['ca_num'];
if(empty($ca_num)) $ca_num = 0;

$tpl->createSubMenu('1201', $ca_num);

if (!$category_skin[$ca_num]) {
	$category_skin[$ca_num] = "basic";
}
$tpl->define('period_list', "skin/ls/$category_skin[$ca_num]/view_period_list.html");


if ($first_lt_num) {

	//단과별 강의 목차를 가져온다.

	$lt_subject_qry = "select 
							A.lts_name,A.lts_num
					from 
							
							goods_lecture_subjects A
					where 
							A.lt_num = '$first_lt_num'
				";
	$lt_subject_query = mysqli_query($CONN['rosemary'],$lt_subject_qry);
	$lt_subject_nums = mysqli_num_rows($lt_subject_query);

	if ($lt_subject_nums) {
		$lt_subject_loop = array();
		while($lt_subject_rs = mysqli_fetch_array($lt_subject_query)){

		$lts_num = $lt_subject_rs['lts_num'];
		$period_query = mysqli_query($CONN['rosemary'],"select * from goods_lecture_subjects_period where lts_num = '$lts_num' order by ltsp_period_num asc");
		$period_nums = mysqli_num_rows($period_query);
		if ($period_nums) {
			$period_loop = array();	
			$period_number = 1;
			while($period_rs = mysqli_fetch_array($period_query)){
				$period_rs['number'] = $period_number;
				$period_number++;
				$period_loop[] = $period_rs;
			}
		}
			$lt_subject_rs['period'] = 	$period_loop;
			$lt_subject_rs['period_nums'] = 	$period_nums;


			$lt_subject_loop[] = $lt_subject_rs;
		}
	}



}

$tpl->assign('lt_subject_nums', $lt_subject_nums);
$tpl->assign('lt_subject_loop', $lt_subject_loop);


$tpl->print_('period_list');
?>