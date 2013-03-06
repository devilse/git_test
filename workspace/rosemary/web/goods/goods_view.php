<?php
include '../../_include/lib_include.php';
include '../include/frame_a.php';

$g_num = $_GET['g_num'];
if (!$g_num) {
	alertback();
}


$ca_num = $_GET['ca_num'];
if(empty($ca_num)) $ca_num = 0;

$tpl->createSubMenu('1201', $ca_num);

if (!$category_skin[$ca_num]) {
	$category_skin[$ca_num] = "basic";
}
$tpl->define('content', "skin/ls/$category_skin[$ca_num]/goods_view.html");
$tpl->define('book_list', "skin/ls/$category_skin[$ca_num]/view_book_list.html");
$tpl->define('period_list', "skin/ls/$category_skin[$ca_num]/view_period_list.html");


// 해당 강좌 정보를 가져온다.
$goods_qry = "select 
						A.*,
						(select sum(lt_selling_price) from goods_lecture B where B.g_num = A.g_num) as price,
						(select GROUP_CONCAT(lt_name) from goods_lecture B where B.g_num = A.g_num) as set_dan
			  from 
						goods A
			  where 
						A.g_num = '$g_num' and A.g_state = 'S'";

$goods_query = mysqli_query($CONN['rosemary'],$goods_qry);
if (!$goods_query) {
	echo "등록된 상품이 없습니다.";
	exit;
}

$goods_rs = mysqli_fetch_array($goods_query);
$g_name = stripslashes($goods_rs['g_name']);							// 강좌명
$set_dan = stripslashes($goods_rs['set_dan']);							// 구성 단과
$g_type = $goods_rs['g_type'];											// 강좌 유형 - A:단과, B:단과, C:강좌	
$g_discount_rate = $goods_rs['g_discount_rate'];						// 강좌 활인률
$g_benefit = nl2br(stripslashes($goods_rs['g_benefit']));				// 강좌 특전
$g_explanation = stripslashes($goods_rs['g_explanation']);				// 강좌 설명	

$tot_price = @round($goods_rs['price'] - ($goods_rs['price'] * ($goods_rs['g_discount_rate'] / 100)),0);



$tpl->assign('g_num', $g_num);
$tpl->assign('g_name', $g_name);
$tpl->assign('g_type', $g_type);
$tpl->assign('g_discount_rate', $g_discount_rate);
$tpl->assign('g_benefit', $g_benefit);
$tpl->assign('g_explanation', $g_explanation);
$tpl->assign('tot_price', $tot_price);
$tpl->assign('number_format_tot_price', number_format($tot_price));

// 해당 강좌에 등록된 단과 + 강의 정보를 가져온다.

$first_lt_num = "";

$subject_qry = "select
						A.lt_name,A.lt_term,A.lt_selling_price,A.lt_num,

						(select C.mb_name from member C where C.mb_num = A.mb_num) as mb_name,
						(select D.mb_picture from member_teacher D where D.mb_num = A.mb_num) as mb_picture,
						(select sum((select count(*) from goods_lecture_subjects_period E where E.lts_num = B.lts_num)) from goods_lecture_subjects B where B.lt_num = A.lt_num ) as period_cnt
				from 
						goods_lecture A
				where
						A.g_num = '$g_num' 
				";
$subject_query = mysqli_query($CONN['rosemary'],$subject_qry);
$subject_nums = mysqli_num_rows($subject_query);
if ($subject_nums) {
	$subject_loop = array();
	$subject_number = 1;
	$tot_price = 0;
	$tot_term = 0;
	$tot_period_cnt = 0;
	while($subject_rs = mysqli_fetch_array($subject_query)){

		if (empty($first_lt_num)) {
			$first_lt_num = $subject_rs['lt_num'];
		}

		$subject_rs['number_format_lt_selling_price'] = number_format($subject_rs['lt_selling_price']);											// 정가
		$subject_rs['h_price'] = @round($subject_rs['lt_selling_price'] - ($subject_rs['lt_selling_price'] * ($g_discount_rate / 100)),0);		// 실제 판매액 - 할인율 포함가격
		$subject_rs['number_format_h_price'] = number_format($subject_rs['h_price']);
		$subject_rs['number'] = $subject_number;
		$subject_number++;
		$tot_term  = $tot_term  + $subject_rs['lt_term'];
		$tot_period_cnt = $tot_period_cnt + $subject_rs['period_cnt'];
		$subject_loop[] = $subject_rs;
	}
}

$tpl->assign('tot_period_cnt', number_format($tot_period_cnt));
$tpl->assign('tot_term', number_format($tot_term));
$tpl->assign('subject_nums', $subject_nums);
$tpl->assign('subject_loop', $subject_loop);
$tpl->assign('first_lt_num', $first_lt_num);



// 해당 강좌에 등록된 교재 정보를 가져온다. - 해당 교제는 결제를 위한 정보임.

$book_qry = "select C.* from goods_lecture_book A, goods_lecture B, book C  where B.g_num = '$g_num' and A.lt_num = B.lt_num and A.bo_num = C.bo_num group by bo_num";
$book_query = mysqli_query($CONN['rosemary'],$book_qry);
$book_nums = mysqli_num_rows($book_query);
if ($book_nums) {
	$book_loop = array();
	$book_number = 1;
	while($book_rs = mysqli_fetch_array($book_query)){
		$book_rs['bo_name'] = stripslashes($book_rs['bo_name']);							// 교재명
		$book_rs['bo_list_price'] = number_format($book_rs['bo_list_price']);				// 교재 정가
		$book_rs['bo_price'] = $book_rs['bo_selling_price'];								// 교재 판매가
		$book_rs['bo_selling_price'] = number_format($book_rs['bo_selling_price']);			// 교재 판매가
		$book_rs['bo_writer'] = stripslashes($book_rs['bo_writer']);						// 저자명
		$book_rs['bo_page_cnt'] = stripslashes($book_rs['bo_page_cnt']);					// 페이지 수
		$book_rs['bo_writer'] = stripslashes($book_rs['bo_writer']);						// 저자명
		$book_rs['bo_publisher'] = stripslashes($book_rs['bo_publisher']);					// 출판사
		$book_rs['bo_explain_book'] = stripslashes($book_rs['bo_explain_book']);			// 교재설명
		$book_rs['bo_explain_writer'] = stripslashes($book_rs['bo_explain_writer']);		// 교재목차
		$book_rs['bo_img'] = stripslashes($book_rs['bo_img']);								// 교재이미지
		$book_rs['number'] = $book_number;
		$book_number++;
		$book_loop[] = $book_rs;
	}
}


$tpl->assign('book_nums', $book_nums);
$tpl->assign('book_loop', $book_loop);





if ($first_lt_num) {			// 처음 페이지가 열릴때 보여질 교재소개와 강의목차

	//단과별 강의 목차를 가져온다.

	$lt_subject_qry = "select A.lts_name,A.lts_num	from goods_lecture_subjects A where A.lt_num = '$first_lt_num'";
	$lt_subject_query = mysqli_query($CONN['rosemary'],$lt_subject_qry);
	$lt_subject_nums = mysqli_num_rows($lt_subject_query);

	if ($lt_subject_nums) {
		$lt_subject_loop = array();
		while($lt_subject_rs = mysqli_fetch_array($lt_subject_query)){

		$lts_num = $lt_subject_rs['lts_num'];
		$period_query = mysqli_query($CONN['rosemary'],"select * from goods_lecture_subjects_period where lts_num = '$lts_num' order by ltsp_period_num asc");
		$period_nums = mysqli_num_rows($period_query);
		if ($period_nums) {																		// 해당 강좌의 차시목록을 가져와서 2차배열로 넣어준다.
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
	$tpl->assign('lt_subject_nums', $lt_subject_nums);
	$tpl->assign('lt_subject_loop', $lt_subject_loop);


	//단과별로 교재 정보 가져옴
	$book_qry2 = "select B.* from goods_lecture_book A, book B where A.lt_num = '$first_lt_num' and A.bo_num = B.bo_num";
	$book_query2 = mysqli_query($CONN['rosemary'],$book_qry2);
	$book_nums2 = mysqli_num_rows($book_query2);
	if ($book_nums2) {
		$book_loop2 = array();
		$book_number = 1;
		while($book_rs2 = mysqli_fetch_array($book_query2)){
			$book_rs2['bo_name'] = stripslashes($book_rs2['bo_name']);							// 교재명
			$book_rs2['bo_list_price'] = number_format($book_rs2['bo_list_price']);				// 교재 정가
			$book_rs2['bo_price'] = $book_rs2['bo_selling_price'];								// 교재 판매가
			$book_rs2['bo_selling_price'] = number_format($book_rs2['bo_selling_price']);		// 교재 판매가
			$book_rs2['bo_writer'] = stripslashes($book_rs2['bo_writer']);						// 저자명
			$book_rs2['bo_page_cnt'] = stripslashes($book_rs2['bo_page_cnt']);					// 페이지 수
			$book_rs2['bo_writer'] = stripslashes($book_rs2['bo_writer']);						// 저자명
			$book_rs2['bo_publisher'] = stripslashes($book_rs2['bo_publisher']);				// 출판사
			$book_rs2['bo_explain_book'] = stripslashes($book_rs2['bo_explain_book']);			// 교재설명
			$book_rs2['bo_explain_writer'] = stripslashes($book_rs2['bo_explain_writer']);		// 교재목차
			$book_rs2['bo_img'] = stripslashes($book_rs2['bo_img']);							// 교재이미지
			$book_rs2['number'] = $book_number;
		
			$book_loop2[] = $book_rs2;
			$book_number++;
			
		}
	}

	$tpl->assign('book_loop2', $book_loop2);

}




// 강좌 상품을 가져온다.



$goods_qry = "select count(*) as cnt from goods where ca_num = '$ca_num' and g_state = 'S' and g_num > '$g_num'";
$goods_list_qry = "
					select 
							A.*,
							(select sum(lt_selling_price) as price from goods_lecture B where B.g_num = A.g_num) as price,
							(select cg_name from category_group B where A.cg_code = B.cg_code) as cg_name
					from 
						goods A
					where
						A.ca_num = '$ca_num' and
						A.g_state = 'S'	and
						A.g_num > '$g_num'
					order by A.g_num desc $limit
						";

$goods_cnt_query = mysqli_query($CONN['rosemary'],$goods_qry);
$goods_cnt = mysqli_result($goods_cnt_query,0,0);
$query_number	=	$goods_cnt;
if ($query_number) {
	$number = $query_number - $first;
	$goods_query = mysqli_query($CONN['rosemary'],$goods_list_qry);
	$list_loop = array();
	while($goods_rs = mysqli_fetch_array($goods_query)){
		$goods_rs['number_format_price'] = number_format($goods_rs['price']);													// 정가
		$goods_rs['h_price'] =  @round($goods_rs['price'] - ($goods_rs['price'] * ($goods_rs['g_discount_rate'] / 100)),0);		// 판매가 - 할인된 금액
		$goods_rs['number_format_h_price'] = number_format($goods_rs['h_price']);												// 리스트 노출 판매가
		$list_loop[] = $goods_rs; 
	}
}


$tpl->assign('list_cnt', $query_number);
$tpl->assign('list', $list_loop);





$tpl->assign('ca_num', $ca_num);
$tpl->print_('frame');
?>