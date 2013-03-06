<?
include '../../_include/lib_include.php';
include '../include/frame_a.php';

// 로그인 체크
$User_Info =  Login_Chk($_COOKIE['LIPASS_ID']);
$mb_type = $User_Info['type'];
$tpl->assign('mb_id', $User_Info['id']);

if (!$mb_type || $mb_type == "G") {
	alertback("로그인이 필요 합니다.");
}

// 해당 페이지 스킨을 가져온다.
$ca_num = $_GET['ca_num'];
if(empty($ca_num)) $ca_num = 0;
$tpl->createSubMenu('1201', $ca_num);
if (!$category_skin[$ca_num]) {
	$category_skin[$ca_num] = "basic";
}
$tpl->define('content', "skin/ls/$category_skin[$ca_num]/order.html");


// 넘어온 결제할 상품의 정보를 변수에 담는다.
$array = $_POST;
$key = array_keys($array);

$g_num = $_POST['g_num'];
$gp_num = $_POST['gp_num'];

$set_goods = array();
$set_book = array();





for($i=0; $i<count($key); $i++) {

	$chk = explode("_",$key[$i]);
	if ($chk[0] == "set" && $chk[1] == "goods") {	// 선택한 상품
		$set_goods[] = $chk[2];
	}



	if ($chk[0] == "set" && $chk[1] == "book") {	// 선택한 교재
		$set_book[] = $chk[2];
	}
}

$set_goods_cnt = count($set_goods);
$set_book_cnt = count($set_book);




if (!$set_goods_cnt && !$set_book && !$gp_num) {
	alertback("주문가능한 상품이 없습니다.");
}

if (!$g_num && !$gp_num && !$set_book) {
	alertback("주문가능한 상품이 없습니다.");
}


$set_goods_lt_num = implode($set_goods,",");
$set_book_bo_num = implode($set_book,",");

$tpl->assign('set_goods_lt_num', $set_goods_lt_num);
$tpl->assign('set_book_bo_num', $set_book_bo_num);


// 구매하고자 하는 패키지 상품의 정보를 가져온다.
if (!empty($gp_num)) {	// 패키지 번호가 있다면 일반 상품번호 ($set_goods_lt_num)가 있을 수 없다. 패키지를 구매했던지 일반 상품을 구매했던지이다. 두가지 상품을 동시에 구매할 수 없다. 현재는 불가능.

	$pack_qry = mysqli_query($CONN['rosemary'],"select * from goods_package where gp_num = '$gp_num'");
	$pack_nums = mysqli_num_rows($pack_qry);
	if (!$pack_nums) {
		alertGo("선택한 상품이 없습니다.",$MY_URL);
	}
	$pack_rs = mysqli_fetch_array($pack_qry);
	$gp_discount_rate = $pack_rs['gp_discount_rate'];
	$pack_goods_qry = mysqli_query($CONN['rosemary'],"select 
															 B.*,
															 (select sum(C.lt_selling_price) - truncate((sum(C.lt_selling_price) * B.g_discount_rate / 100),0) from goods_lecture C where C.g_num = B.g_num ) as price,
															 (select sum(lt_term) from goods_lecture C where C.g_num = B.g_num ) as lt_term,
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
	$goods_nums = mysqli_num_rows($pack_goods_qry);
	if (!$goods_nums) {
		alertback("주문가능한 상품이 없습니다.");
	} else {
			$goods_list = array();	
			$tot_lt_price = 0;
			while($goods_rs = mysqli_fetch_array($pack_goods_qry)){

				$goods_rs['lt_name'] =  stripslashes($goods_rs['g_name']);																// 상품명
				$goods_rs['g_benefit'] =  stripslashes($goods_rs['g_benefit']);															// 상품설명
				$goods_rs['g_discount_rate'] =  stripslashes($goods_rs['g_discount_rate']);												// 상품 할인률
				$goods_rs['g_explanation'] =  stripslashes($goods_rs['g_explanation']);													// 상품 특전
				$goods_rs['h_price'] = @round($goods_rs['price'] - ($goods_rs['price'] * ($gp_discount_rate / 100)),0);		// 실제 판매액
				$goods_rs['number_format_h_price'] = number_format($goods_rs['h_price']);												// number_format 변수 적용 판매액
				$goods_rs['lt_term'] = number_format($goods_rs['lt_term']);																// 수강기간
				$tot_lt_price = $tot_lt_price + $goods_rs['h_price'];																			// 총가격	
				$goods_list[] = $goods_rs; 
			}
	}


} else { 
	// 구매하고자 하는 상품 정보를 가져온다. - 할인률이나 부가적인 정보를 가져온다.
	if ($set_goods_cnt > 0) {
		$goods_query = "select
								A.g_name,g_type,g_discount_rate,g_benefit,g_explanation,
								B.lt_name,B.lt_term,B.lt_selling_price as price
						from 
								goods A,
								goods_lecture B
						where 
								A.g_num = '$g_num' and
								A.g_state = 'S' and
								A.g_num = B.g_num and
								B.lt_num in ($set_goods_lt_num)
						";
		$goods_qry = mysqli_query($CONN['rosemary'],$goods_query);
		$goods_nums = mysqli_num_rows($goods_qry);

		if ($goods_nums) {
			$goods_list = array();	
			$tot_lt_price = 0;
			while($goods_rs = mysqli_fetch_array($goods_qry)){
				$goods_rs['g_name'] =  stripslashes($goods_rs['g_name']);																// 상품명
				$goods_rs['g_benefit'] =  stripslashes($goods_rs['g_benefit']);															// 상품설명
				$goods_rs['g_discount_rate'] =  stripslashes($goods_rs['g_discount_rate']);												// 상품 할인률
				$goods_rs['g_explanation'] =  stripslashes($goods_rs['g_explanation']);													// 상품 특전
				$goods_rs['h_price'] = @round($goods_rs['price'] - ($goods_rs['price'] * ($goods_rs['g_discount_rate'] / 100)),0);		// 실제 판매액
				$goods_rs['number_format_h_price'] = number_format($goods_rs['h_price']);												// number_format 변수 적용 판매액
				$goods_rs['lt_term'] = number_format($goods_rs['lt_term']);																// 수강기간
				$tot_lt_price = $tot_lt_price + $goods_rs['h_price'];																	// 총가격	
				$goods_list[] = $goods_rs; 
			}
		} else {
			alertback("선택한 상품이 존재하지 않거나 오류가 발생 하였습니다.");
		}
	}
}


$tpl->assign('goods_nums', $goods_nums);
$tpl->assign('goods_list', $goods_list);
$tpl->assign('tot_lt_price', number_format($tot_lt_price));


// 구매하고자 하는 교재의 정보를 가져온다.
if ($set_book_cnt > 0) {
	$book_query = "select * from book where bo_num in ($set_book_bo_num)";

	$book_qry = mysqli_query($CONN['rosemary'],$book_query);
	$book_nums = mysqli_num_rows($book_qry);

	if ($book_nums) {
		$book_list = array();	
		$tot_book_price = 0;
		while($book_rs = mysqli_fetch_array($book_qry)){
			$tot_book_price = $tot_book_price + $book_rs['bo_selling_price']; 
			$book_rs['bo_selling_price'] = number_format($book_rs['bo_selling_price']);	
			$book_list[] = $book_rs; 
		}
	} else {
		alertback("선택한 상품이 존재하지 않거나 오류가 발생 하였습니다.");
	}
}

$tpl->assign('book_nums', $book_nums);
$tpl->assign('book_list', $book_list);
$tpl->assign('tot_book_price', number_format($tot_book_price));


// 강의 + 교재
$tpl->assign('tot_price', number_format($tot_lt_price + $tot_book_price));
$tpl->assign('pay_tot_price', $tot_lt_price + $tot_book_price);


// 회원의 정보를 가져온다.
$mb_num = $User_Info['member_num'];
if (!$mb_num) {
	alertback("로그인이 필요 합니다.");
}

if ($mb_type == "S") {
	$member_query = "select A.*,B.* from member A, member_student B where A.mb_num = '$mb_num' and A.mb_num = B.mb_num";
	$member_qry = mysqli_query($CONN['rosemary'],$member_query);
	$member_nums = mysqli_num_rows($member_qry);
	if (!$member_nums) {
		alertback("로그인이 필요 합니다.");
	} else {
		$member_rs = mysqli_fetch_array($member_qry);
		$member_name = stripslashes($member_rs['mb_name']);
		$tel_array = explode("-",$member_rs['mb_tel']);					// 전화번호
		$hp_array = explode("-",$member_rs['mb_hp']);					// 휴대폰번호
		$email_array = explode("@",$member_rs['mb_email']);				//이메일
		$zip_code = $member_rs['ms_zipcode'];							//우편번호
		$addr = stripslashes($member_rs['ms_address']);					//우편번호
		$addr2 = stripslashes($member_rs['ms_address_detail']);			//우편번호
	}
}

$tpl->assign('member_name', $member_name);
$tpl->assign('tel_1', $tel_array[0]);
$tpl->assign('tel_2', $tel_array[1]);
$tpl->assign('tel_3', $tel_array[2]);
$tpl->assign('hp_1', $hp_array[0]);
$tpl->assign('hp_2', $hp_array[1]);
$tpl->assign('hp_3', $hp_array[2]);
$tpl->assign('email_1', $email_array[0]);
$tpl->assign('email_2', $email_array[1]);
$tpl->assign('zip_code1', substr($zip_code,0,3));
$tpl->assign('zip_code2', substr($zip_code,3,3));
$tpl->assign('addr', $addr);
$tpl->assign('addr2', $addr2);



// 무통장 계좌번호 가져옴
$site_account_query = "select * from site_account_number where sa_useyn = 'Y' order by sa_regdate desc";
$site_account_qry = mysqli_query($CONN['rosemary'],$site_account_query);
$site_account_nums = mysqli_num_rows($site_account_qry);
if ($site_account_nums) {
	$site_account_list = array();
	while($site_account_rs = mysqli_fetch_array($site_account_qry)){
		$site_account_list[] = $site_account_rs;
	}
}

$tpl->assign('site_account_list', $site_account_list);


// 결제 정보

$StoreId 	= "aegis";
$rand_no = rand_no();
$OrdNo 		= date("YmdHis").$rand_no;
$hash_price = $tot_lt_price + $tot_book_price;

$AGS_HASHDATA = md5($StoreId . $OrdNo . $hash_price); 

$tpl->assign('g_num', $g_num);
$tpl->assign('gp_num', $gp_num);

$tpl->assign('StoreId', $StoreId);
$tpl->assign('OrdNo', $OrdNo);
$tpl->assign('AGS_HASHDATA', $AGS_HASHDATA);



$tpl->print_('frame');

?>