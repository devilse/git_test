<?php
header('Content-Type: text/html;charset=utf-8');

include "../../../_lib/db_conn.php";	// 디비 접속
include "../../../_lib/global.php";
include "../../../_lib/function.php";
include "../../../_lib/lib.php";	// 관리자 페이지 공용 함수 파일

$mode = $_POST['mode'];
$pack_name = addslashes(trim($_POST['pack_name']));	//패키지명
$set_good = $_POST['set_good'];		//구성상품
$cg_code = $_POST['cg_code'];		//구성cs
$pack_benefit = addslashes(trim($_POST['pack_benefit']));	//패키지특전
$contents = $_POST['content'];		// 패키지설명
$pack_dis = addslashes(trim($_POST['pack_dis']));		//패키지할인
$pack_slo = addslashes(trim($_POST['pack_slo']));		//패키지슬로건
$upfile_name = addslashes(trim($_FILES['list_img']['name']));	//리스트 이미지

$User_Info =  Login_Chk($_COOKIE['LIPASS_ID']);
$mb_type = $User_Info['type'];
if ($mb_type != "A") {
	alertGo("", "/");
}





if (!$pack_name) alertback("패키지명을 입력해 주세요.");
if (!$set_good) alertback("상품을 선택해 주세요.");
if (!$cg_code) alertback("선택한 카테고리가 없습니다.");


$page = $_POST['page'];
$key = $_POST['key'];
$searchword = $_POST['searchword'];
$set_cs = $_POST['set_cs'];
$set_state = $_POST['set_state'];

$page_param = "&page=$page&key=$key&searchword=$searchword&set_cs=$set_cs&set_state=$set_state";


if ($mode == "package_modi") {	//수정하기

	$gp_num = $_POST['gp_num'];
	if (!$gp_num) alertback("접근할 수 없습니다.");

	$view_query = mysqli_query($CONN['rosemary'],"select gp_explanation,gp_img from goods_package where gp_num = '$gp_num'");
	$view_nums = mysqli_num_rows($view_query);
	if (!$view_nums) {
		alertback("삭제되었거나 존재하지 않는 상품 입니다.");
	}
	$view_rs = mysqli_fetch_array($view_query);
	$y_img = $view_rs['gp_img'];
	$y_con = $view_rs['gp_explanation'];
	$goods_array = explode(",",$set_good);

	//먼저 첨부된 이미지 파일을 실제 디렉토리로 이동시킨다.
	$contents_img	= explode("_tmp_e_",$contents);			// 본문내 첨부된 이미지를 배열로 쪼갠다.
	$end_for		= count($contents_img);					// 이미지 배열 길이
	for ($i=0;$i<$end_for;$i++) {
		$img_use_chk = "Y";
		$contents_img2 = explode("_tmp_s_",$contents_img[$i]);
			if ($contents_img2[1] != "" || !empty($contents_img2[1]) ) {
				$upfile = "_tmp_s_".$contents_img2[1]."_tmp_e_";
				@move("$dir_img_tmp/$upfile","$dir_img/goods_img/$upfile");
			}
	}
	$contents = eregi_replace("\\\\","",$contents);
	$contents = eregi_replace("/dir_img_tmp"  , $MY_URL."dir_img/goods_img",$contents);
	$contents = addslashes(trim($contents));				// 실제 내용


	//새로운 리스트 이미지가 있으면 이미지를 업로드 하고 기존 이미지를 삭제한다. 
	if ($_FILES['list_img']['tmp_name']) {
		$ext = substr($_FILES['list_img']['name'],strrpos(stripslashes($_FILES['list_img']['name']),'.')+1);		// 파일확장자
		$upfile = ".".$ext;																								
		$upfile =  date("YmdHis") . "_" . substr(microtime(),2,4).$upfile;					// 실제 저장할 파일명
		if (!@move_uploaded_file($_FILES['list_img']['tmp_name'],$dir_img.'/goods_img/'.$upfile)) {
			alertback("리스트 이미지 저장 실패");
		}
		@unlink($dir_img.'/goods_img/'.$y_img);

		$set_img = ",gp_img = '$upfile'";

	}
	

	//본문 이미지가 변동 되면 삭제한다.
	$y_con_img = explode("_tmp_e_",$y_con);
	$y_con_end_for = count($y_con_img);
	$del_img_array = array();
	for($i=0;$i<$y_con_end_for;$i++) {
		$y_contents_img2 = explode("_tmp_s_",$y_con_img[$i]);
			if ($y_contents_img2[1] != "" || !empty($y_contents_img2[1]) ) {
				$del_img = "_tmp_s_".$y_contents_img2[1]."_tmp_e_";
				$del_img_array[$i] = $del_img;				// 바로 삭제 하지 않는 이유는 먼저 지웠다가 만약 업데이트가 안돼면 이미지 엑박 뜨기 때문임. 확실히 업데이트 이후 삭제해주자
			}
	}

	$t_chk = true;	//쿼리 이상유무 체크 변수
	mysqli_query($CONN['rosemary'],"set autocommit = 0;");
	mysqli_query($CONN['rosemary'],"begin;");

	$update_query = "update 
							goods_package 
					 set
							gp_name = '$pack_name',
							gp_slogan = '$pack_slo',
							gp_discount_rate = '$pack_dis',
							gp_benefit = '$pack_benefit',
							gp_explanation = '$contents',
							cg_code = '$cg_code'
							$set_img
					 where
							gp_num = '$gp_num'							
					 ";
		
	$update_result = mysqli_query($CONN['rosemary'],$update_query);
	if (!$update_result) {
		$t_chk = false;
	} else {
		//삭제 될 이미지가 있다면 삭제를 한다. - 기존 이미지들임 여기서 주의해야할 점이. 그냥 기존 이미지를 수정하지 않고 그냥 원본을 다시 저장했을때
		//이다. 그런 경우 따로 체크를 하지 않으면 원본 이미지를 삭제 해버리기 때문에 삭제할 이미지와 새로 추가된 이미지의 이름이 서로 같다면 삭제하지 말아야 한다.
		if (!empty($del_img_array)) {	
			$del_end_for = count($del_img_array);					
			for($i=0;$i<$del_end_for;$i++) {
				$img_del_chk = "Y";
				$contents_img = explode("_tmp_e_",$contents);
				$end_for = 	count($contents_img);
				for($j=0;$j<$end_for;$j++) {
							$contents_img2 = explode("_tmp_s_",$contents_img[$j]);
							if ($contents_img2[1] != "" || !empty($contents_img2[1]) ) {
								$upfile = "_tmp_s_".$contents_img2[1]."_tmp_e_";
								if ($upfile == $del_img_array[$i]) {
									$img_del_chk = "N";
								}
							}
				}
				if ($img_del_chk == "Y") {
						@unlink($dir_img.'/goods_img/'.$del_img_array[$i]);
				}
			}
		}

		// goods_package_goods 테이블의 값을 초기화 하고 새로 넣어준다.
		$del_query = mysqli_query($CONN['rosemary'],"delete from goods_package_goods where gp_num = '$gp_num'");
		if (!$del_query) {
			$t_chk = false;
		} else {
			$end_for = count($goods_array) ; 
			for ($i = 0; $i < $end_for;  $i++) { 	
				$g_num = $goods_array[$i];
				$goods_in_query = mysqli_query($CONN['rosemary'],"insert into goods_package_goods(gp_num,g_num) values('$gp_num','$g_num')");
				if (!$goods_in_query) {
					$t_chk = false;
				}
			}
		}


		if ($t_chk != true) {
			mysqli_query($CONN['rosemary'],"rollback;");
			alertback("패키지 수정 실패");
		} else {
			mysqli_query($CONN['rosemary'],"commit;");	
			alertGo("","../index.php?mode=package_view&gp_num=$gp_num&".$page_param);
		}

	}



	




} else {	//등록하기

	$ext = substr($_FILES['list_img']['name'],strrpos(stripslashes($_FILES['list_img']['name']),'.')+1);		// 파일확장자
	$upfile = ".".$ext;																								
	$upfile =  date("YmdHis") . "_" . substr(microtime(),2,4).$upfile;					// 실제 저장할 파일명
	if (!@move_uploaded_file($_FILES['list_img']['tmp_name'],$dir_img.'/goods_img/'.$upfile)) {
		alertback("리스트 이미지 저장 실패");
	} 

	$goods_array = explode(",",$set_good);

	//먼저 첨부된 이미지 파일을 실제 디렉토리로 이동시킨다.
	$contents_img	= explode("_tmp_e_",$contents);			// 본문내 첨부된 이미지를 배열로 쪼갠다.
	$end_for		= count($contents_img);					// 이미지 배열 길이
	for ($i=0;$i<$end_for;$i++) {
		$img_use_chk = "Y";
		$contents_img2 = explode("_tmp_s_",$contents_img[$i]);
			if ($contents_img2[1] != "" || !empty($contents_img2[1]) ) {
				$upfile = "_tmp_s_".$contents_img2[1]."_tmp_e_";
				@move("$dir_img_tmp/$upfile","$dir_img/goods_img/$upfile");
			}
	}

	$contents = eregi_replace("\\\\","",$contents);
	$contents = eregi_replace("/dir_img_tmp"  , $MY_URL."dir_img/goods_img",$contents);
	$contents = addslashes(trim($contents));				// 실제 내용


	$t_chk = true;	//쿼리 이상유무 체크 변수
	mysqli_query($CONN['rosemary'],"set autocommit = 0;");
	mysqli_query($CONN['rosemary'],"begin;");


	$in_query = mysqli_query($CONN['rosemary'],"insert into goods_package(gp_name,gp_slogan,gp_discount_rate,gp_state,gp_benefit,gp_explanation,gp_regdate,cg_code,gp_img) values('$pack_name','$pack_slo','$pack_dis','R','$pack_benefit','$contents',unix_timestamp(),'$cg_code','$upfile')");

	if (!$in_query) {
		$t_chk = false;
	} else {
		$gp_num = mysqli_insert_id($CONN['rosemary']);
		if (!$gp_num) {
			$t_chk = false;
		} else {

			$end_for = count($goods_array) ; 
			for ($i = 0; $i < $end_for;  $i++) { 	
				$g_num = $goods_array[$i];
				$goods_in_query = mysqli_query($CONN['rosemary'],"insert into goods_package_goods(gp_num,g_num) values('$gp_num','$g_num')");
				if (!$goods_in_query) {
					$t_chk = false;
				}
			}
		}
	}



	if ($t_chk != true) {
		mysqli_query($CONN['rosemary'],"rollback;");
		alertback("패키지 등록 실패");
	} else {
		mysqli_query($CONN['rosemary'],"commit;");	
		alertGo("","../index.php?mode=package_list");
	}
}







?>