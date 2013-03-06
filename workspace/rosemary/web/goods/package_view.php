<?php
include '../../_include/lib_include.php';
include '../include/frame_a.php';

$tpl->createSubMenu('1101');
$tpl->define('content', "skin/ls/$siteoption[skin_package]/package_view.html");


$gp_num = $_GET['num'];
$page = $_GET['page'];

if (!$gp_num) {
	alertback("접근 할 수 없습니다.");
}


$view_query = "
				select 
						A.*,
						E.cg_name as cg_name,
						(select	
								sum((select sum(C.lt_selling_price) - truncate(((sum(C.lt_selling_price) * (D.g_discount_rate / 100) )),0)  from goods_lecture C, goods D  where C.g_num = B.g_num and B.g_num = D.g_num))
						 from 
								goods_package_goods B 
						 where 
								A.gp_num = B.gp_num) as price,

						(select GROUP_CONCAT(CONCAT_WS('<>',C.g_num,C.g_name,D.ca_name) SEPARATOR '||') from goods_package_goods B, goods C, category D  where B.gp_num = A.gp_num and B.g_num = C.g_num and C.ca_num = D.ca_num) as g_name,

						(select sum((select sum(C.lt_term) from goods_lecture C where C.g_num = B.g_num)) from goods_package_goods B where A.gp_num = B.gp_num ) as term

				from 
						goods_package A ,
						category_group E

				where
						A.cg_code = E.cg_code
						and A.gp_state = 'S'
						and A.gp_num = '$gp_num'
			";

$view_result = mysqli_query($CONN['rosemary'],$view_query);
$view_nums = mysqli_num_rows($view_result);
if (!$view_nums) {
	alertback("삭제되거나 존재하지 않는 상품 입니다.");
}
$view_rs = mysqli_fetch_array($view_result);


		$view_rs['gp_regdate'] = date("Y-m-d H:i:s",$view_rs['gp_regdate']);										// 패키지 등록날짜	
		$h_price = @round($view_rs['price'] - ($view_rs['price'] * ($view_rs['gp_discount_rate'] / 100)),0);		// 할인된 금액
		$view_rs['h_price'] = $h_price;																				// 실제 판매금액
		$view_rs['h_price_format'] = number_format($h_price);
		$view_rs['price'] = number_format($view_rs['price']);														// 원래 정가
		$view_rs['gp_name'] = stripslashes($view_rs['gp_name']);													// 패키지명		
		$view_rs['gp_slogan'] = nl2br(stripslashes($view_rs['gp_slogan']));											// 슬로건	
		$view_rs['gp_benefit'] = nl2br(stripslashes($view_rs['gp_benefit']));										// 특전		
		$view_rs['gp_explanation'] = stripslashes($view_rs['gp_explanation']);										// 패키지 설명	
		$view_rs['term'] = number_format($view_rs['term']);															// 수강기간		
		$gp_discount_rate = $view_rs['gp_discount_rate'];															// 패키지 할인율

		$g_name_array = explode("||",$view_rs['g_name']);															// 패키지 등록된 상품명								
		$end_for = count($g_name_array);	

		//상품구성			
		for ($i=0;$i<$end_for;$i++) {
			$g_name_array2 = explode("<>",$g_name_array[$i]);
			$g_num = $g_name_array2[0];
			$g_name = $g_name_array2[1];
			$ca_name = $g_name_array2[2];
			
			if ($i != ($end_for - 1)) {
				$gubun_smg = "|";
			} else {
				$gubun_smg = "";
			}

			$set_goods .= $g_name." (".$ca_name.") $gubun_smg ";
		}

// 강의 구성 및 패키지 정보
$tpl->assign('h_price', $view_rs['h_price']);							// 할인된 금액 - 실제 판매액
$tpl->assign('h_price_format', $view_rs['h_price_format']);				// 할인된 금액 - 실제 판매액 - number_format 처리형
$tpl->assign('price', $view_rs['price']);								// 할인되기전 금액
$tpl->assign('gp_name', $view_rs['gp_name']);							// 패키지명
$tpl->assign('gp_slogan', $view_rs['gp_slogan']);						// 패키지 슬로건	
$tpl->assign('gp_benefit', $view_rs['gp_benefit']);						// 패키지 특전
$tpl->assign('gp_explanation', $view_rs['gp_explanation']);				// 패키지 설명
$tpl->assign('term', $view_rs['term']);									// 패키지 수강기간 - 등록된 강의 전체 수강기간 합친것
$tpl->assign('gp_regdate', $view_rs['gp_regdate']);						// 패키지 등록날짜
$tpl->assign('set_goods', $set_goods);									// 강의구성
$tpl->assign('gp_discount_rate', $view_rs['gp_discount_rate']);			// 활인률


// 패키지 등록된 강좌 정보
$pack_goods_qry = mysqli_query($CONN['rosemary'],"select 
														 B.*,
														 (select sum(C.lt_selling_price) - truncate((sum(C.lt_selling_price) * B.g_discount_rate / 100),0) from goods_lecture C where C.g_num = B.g_num ) as price,
														 (select GROUP_CONCAT(lt_num) from goods_lecture C where C.g_num = B.g_num ) as lt_num,
														 (select count(*) from goods_lecture_subjects C, goods_lecture_subjects_period E where C.lt_num = D.lt_num and C.lts_num = E.lts_num and E.ltsp_sample_yn = 'Y') as sample_cnt,
														 E.mb_name

												  from 
														 goods_package_goods A, goods B, goods_lecture D, member E
												  where 
														 A.gp_num = '$gp_num' and 
														 A.g_num = B.g_num and
														 B.g_num = D.g_num and
														 D.mb_num = E.mb_num

														group by B.g_num 
														 
													");
$goods_loop = array();
$lt_num = "";
while ($goods_rs = mysqli_fetch_array($pack_goods_qry)) {
	$goods_rs['h_price'] = number_format( @round($goods_rs['price'] -  ($goods_rs['price'] * $gp_discount_rate / 100),0) );		// 실제 판매가격 - 할인적용된 가격
	$goods_rs['price'] = number_format($goods_rs['price']);																		// 원래가격
	if (empty($lt_num)) {
		$lt_num =  $goods_rs['lt_num'];	
	} else {
		$lt_num .= ",".$goods_rs['lt_num'];
	}
	$goods_loop[] = $goods_rs;
}
$tpl->assign('goods_loop', $goods_loop);	



// 교재 정보 가져옴


$book_qry = mysqli_query($CONN['rosemary'],"select B.* from goods_lecture_book A, book B where A.lt_num in ($lt_num) and A.bo_num = B.bo_num and B.bo_useyn = 'Y' group by B.bo_num");

$book_loop = array();
$lt_num = "";
while ($book_rs = mysqli_fetch_array($book_qry)) {
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

	$book_loop[] = $book_rs;
}
$tpl->assign('book_loop', $book_loop);	

$tpl->assign('gp_num', $gp_num);	
$tpl->print_('frame');
?>