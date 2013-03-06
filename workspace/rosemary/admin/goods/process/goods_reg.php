<?php
header('Content-Type: text/html;charset=utf-8');


include "../../../_lib/db_conn.php";	// 디비 접속
include "../../../_lib/global.php";
include "../../../_lib/function.php";
include "../../../_lib/lib.php";	// 관리자 페이지 공용 함수 파일

$mode = $_POST['mode'];

$page = $_POST['page'];
$key = $_POST['key'];
$searchword = $_POST['searchword'];
$set_g_state = $_POST['set_g_state'];
$sel_type = $_POST['sel_type'];
$ca_num = $_POST['ca_num'];

$page_param = "&page=$page&key=$key&searchword=$searchword&set_g_state=$set_g_state&sel_type=$sel_type&ca_num=$ca_num";


if ($mode == "goods_reg") {
	
	$g_name = addslashes(trim($_POST['g_name']));
	$ca_num = $_POST['set_category_num'];
	$g_type = $_POST['g_type'];
	$g_state = 'R';
	$g_discount_rate = $_POST['discount'];
	$g_benefit = addslashes(trim($_POST['g_benefit']));
	$contents = $_POST['content'];
	$cg_code = $_POST['cg_code'];

	$contents_img	= explode("_tmp_e_",$contents);			// 본문내 첨부된 이미지를 배열로 쪼갠다.
	$end_for		= count($contents_img);					// 이미지 배열 길이
	for ($i=0;$i<$end_for;$i++) {
		$img_use_chk = "Y";
		$contents_img2 = explode("_tmp_s_",$contents_img[$i]);
			if ($contents_img2[1] != "" || !empty($contents_img2[1]) ) {
				$upfile = "_tmp_s_".$contents_img2[1]."_tmp_e_";
				@move("../../../dir_img_tmp/$upfile","../../../dir_img/goods_img/$upfile");
			}
	}

	$contents = eregi_replace("\\\\","",$contents);
	$contents = eregi_replace("/dir_img_tmp"  , $MY_URL."dir_img/goods_img",$contents);
	$contents = addslashes(trim($contents));				// 실제 내용

	$q = mysqli_query($CONN['rosemary'],"insert into goods(g_name,ca_num,g_type,g_state,g_discount_rate,g_benefit,g_explanation,g_regdate,cg_code) values('$g_name','$ca_num','$g_type','$g_state','$g_discount_rate','$g_benefit','$contents',unix_timestamp(),'$cg_code')");


	if (!$q) {
		alertback("등록실패");
	} else {
		$g_num = mysqli_insert_id($CONN['rosemary']);
		if (!$g_num) {
			echo "1212121";
		} else {
			alertGo("","../index.php?mode=goods_dan_reg&g_num=$g_num");
		}
		
	}

} else if($mode == "dan_reg") {

	$g_num = $_POST['g_num'];
	$g_type = $_POST['g_type'];


	if (!$g_num || !$g_type ) {
		alertback("접근할 수 없습니다.");
	}



	$arr_sel =  explode('<>', $_POST['sel_form_num']);
	$end_for = count($arr_sel) ; 
	
	$t_chk = true;	//쿼리 이상유무 체크 변수

	mysqli_query($CONN['rosemary'],"set autocommit = 0;");
	mysqli_query($CONN['rosemary'],"begin;");

	for ($i = 0; $i < $end_for + 1; $i++) { 
	
		$dan_name = "dan_name_".$i;
		$dan_date = "dan_date_".$i;
		$dan_price = "dan_price_".$i;
		$dan_te = "te_sel_".$i;
		$book_list = "set_select_".$i;
		
		if (!empty($_POST[$dan_name])) {
			$dan_name =  addslashes(trim($_POST[$dan_name]));		//단과명
			$dan_date = $_POST[$dan_date];		//수강일
			$dan_price = $_POST[$dan_price];	//가격
			$dan_te = $_POST[$dan_te];	//가격
			$book_list = $_POST[$book_list];	//가격


			$dan_in_query = mysqli_query($CONN['rosemary'],"insert into goods_lecture(lt_name,lt_term,lt_selling_price,g_num,mb_num) value('$dan_name','$dan_date','$dan_price','$g_num','$dan_te')");
			if (!$dan_in_query) {
					$t_chk = false;
			} else {
				$lt_num = mysqli_insert_id($CONN['rosemary']);
				if (!$lt_num) {
					$t_chk = false;
				} else {

					//교재 등록

					$book_array = explode("<>",$book_list);
					$book_end_for = count($book_array);
					for ($j = 0; $j < $book_end_for + 1; $j++) { 

						if (!empty($book_array[$j])) {
							$book_num_array = explode("|",$book_array[$j]);
							$book_num = $book_num_array[0];
							$book_in_query = mysqli_query($CONN['rosemary'],"insert into goods_lecture_book(lt_num,bo_num) values('$lt_num','$book_num')");
							if (!$book_in_query){
								$t_chk = false;
							}
						}
					}

					if ($g_type == "A") {
						$gang_query =  mysqli_query($CONN['rosemary'],"insert into goods_lecture_subjects(lts_name,lt_num,lsct_code) value('$dan_name','$lt_num','D')");
						if (!$gang_query) {
							$t_chk = false;
						}
					}
				}
				

			}

			if ($t_chk != true) {
				mysqli_query($CONN['rosemary'],"rollback;");
				alertback("단과 등록 실패");
			}
		}
	}

	// 해당 상품에 단과가 2개 이상일땐 강좌가 됨. (만약 상품 유형이 단과인데 단과가 하나이상 더 추가 되면 유형을 강좌로 업데이트 해준다.)
	if ($g_type != "C") {
		$dan_cnt_query = mysqli_query($CONN['rosemary'],"select count(*) as cnt from goods_lecture where g_num = '$g_num'");
		$dan_cnt = mysqli_result($dan_cnt_query,0,0);
		if ($dan_cnt > 1) {
			$state_up_query = mysqli_query($CONN['rosemary'],"update goods set g_type = 'C' where g_num = '$g_num'");
			if (!$state_up_query) {
				$t_chk = false;
			}
		}
	}

	if ($t_chk != true) {
		mysqli_query($CONN['rosemary'],"rollback;");
		alertback("단과 등록 실패");
	} else {
		mysqli_query($CONN['rosemary'],"commit;");	
		alertGo("","../index.php?mode=goods_subject_reg&g_num=$g_num".$page_param);
	}



} else if($mode == "subject_reg") {

	$g_num = $_POST['g_num'];
	$dan_num = $_POST['dan_num'];

	if (!$g_num || !$dan_num) {
		alertback("접근할 수 없습니다.");
	}


	$arr_sel =  explode('<>', $_POST['sel_form_num']);
	$end_for = count($arr_sel) ; 
	$t_chk = true;	//쿼리 이상유무 체크 변수
	mysqli_query($CONN['rosemary'],"set autocommit = 0;");
	mysqli_query($CONN['rosemary'],"begin;");


	for ($i = 0; $i < $end_for + 1; $i++) { 
	
		$sub_name = "subject_title_".$i;
		$sub_type = "subject_type_".$i;
		
		if (!empty($_POST[$sub_name])) {
			$sub_name =  addslashes(trim($_POST[$sub_name]));		//단과명
			$sub_type = $_POST[$sub_type];		//수강일
			$sub_type = preg_replace ("/['\"]/", "", stripslashes(stripslashes(($sub_type)))); 
			$in_query = mysqli_query($CONN['rosemary'],"insert into goods_lecture_subjects(lts_name,lt_num,lsct_code) value('$sub_name','$dan_num','$sub_type')");
			if (!$in_query) {
				$t_chk = false;
			}
		}
	}

	if ($t_chk != true) {
		mysqli_query($CONN['rosemary'],"rollback;");
		alertback("강의 등록 실패");
	} else {
		mysqli_query($CONN['rosemary'],"commit;");	
		alertGo("","../index.php?mode=goods_subject_reg&g_num=$g_num".$page_param);
	}


} else if ($mode == "movie_reg") {

	$g_num = $_POST['g_num'];
	$sub_num = $_POST['sub_num'];

	if (!$g_num || !$sub_num) {
		alertback("접근할 수 없습니다.");
	}


	$arr_sel =  explode('<>', $_POST['sel_form_num']);
	$end_for = count($arr_sel); 

	$t_chk = true;	//쿼리 이상유무 체크 변수
	mysqli_query($CONN['rosemary'],"set autocommit = 0;");
	mysqli_query($CONN['rosemary'],"begin;");


	for ($i = 0; $i <= $end_for + 1; $i++) { 


		$movie_num = "movie_num_".$i;
		$movie_len = "movie_len_".$i;
		$movie_name = "movie_name_".$i;
		$movie_url = "movie_url_".$i;
		$movie_sample = "movie_sample_".$i;
		

		if (!empty($_POST[$movie_name])) {
			$movie_num =  $_POST[$movie_num];		//차시순서
			$movie_len = $_POST[$movie_len];		//차시길이
			$movie_name = addslashes(trim($_POST[$movie_name]));		//차시이름
			$movie_url = addslashes(trim($_POST[$movie_url]));		//동영상주소
			$movie_sample = $_POST[$movie_sample];		//맛보기
			if (!$movie_sample) {
				$movie_sample = "N";
			} else {
				$movie_sample = "Y";	
			}


			$in_query = mysqli_query($CONN['rosemary'],"insert into goods_lecture_subjects_period(lts_num,ltsp_name,ltsp_time_length,ltsp_period_num,ltsp_url,ltsp_sample_yn) value('$sub_num','$movie_name','$movie_len','$movie_num','$movie_url','$movie_sample')");
			if (!$in_query) {
				$t_chk = false;
			}

		}

	}



	if ($t_chk != true) {
		mysqli_query($CONN['rosemary'],"rollback;");
		alertback("차시 등록 실패");
	} else {
		mysqli_query($CONN['rosemary'],"commit;");	
		alertGo("","../index.php?mode=goods_subject_reg&g_num=$g_num".$page_param);
	}

} else if ($mode == "excel_movie_reg") {

	echo "실제 서버에서 테스트 해야함.";
	exit;

	// 포링키가 묶여 있기 때문에 단순히 파일만 밀어넣는다고 들어가지 않는다.
	// 포링키 때문에 임시 테이블에 값을 넣었다가 다시 불러와서 포링키와 같이 밀어 넣는 방법으로 해야하지 싶다.
	//83
	$upfile_name = addslashes(trim($_FILES['excel_file']['name']));												// 업로드 파일 원본 이름
	$ext = substr($_FILES['excel_file']['name'],strrpos(stripslashes($_FILES['excel_file']['name']),'.')+1);		// 파일확장자
	$file_size = $_FILES['excel_file']['size'];																	// 파일 사이즈
	$upfile = '.file.'.$ext;																								
	$upfile = date("YmdHis") . "_" . substr(microtime(),2,4) . $upfile ;					// 실제 저장할 파일명
	

	if (@move_uploaded_file($_FILES['excel_file']['tmp_name'],$dir_file.'/excel_file/'.$upfile)) {
		$in_file = $dir_file.'/excel_file/'.$upfile;
		mysqli_query($CONN['rosemary'],"
			load data infile '/home/public/test.php.csv' into table goods_lecture_subjects_period('83','') fields terminated by '^|^';
		");


		//LOAD DATA INFILE 'backup_file.txt' INTO TABLE mydb.mytable(col1, col2, col3) 
	}else{
		alertback("오류발생");
		
	}
}


//LOAD DATA INFILE "file_name.csv" INTO TABLE tbl_name  FIELDS TERMINATED BY '\t' OPTIONALLY ENCLOSED BY '"'  LINES TERMINATED BY '\r\n' (no, ag, name, dep)

?>