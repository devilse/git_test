<?php
header('Content-Type: text/html;charset=utf-8');


include "../../../_lib/db_conn.php";	// 디비 접속
include "../../../_lib/global.php";
include "../../../_lib/function.php";
include "../../../_lib/lib.php";	// 관리자 페이지 공용 함수 파일

$mode = $_POST['mode'];

if($mode == "goods_modi"){

	$g_num = $_POST['g_num'];
	$g_name = addslashes(trim($_POST['g_name']));
	$ca_num = $_POST['set_category_num'];
	$g_discount_rate = $_POST['discount'];
	$g_benefit = addslashes(trim($_POST['g_benefit']));
	$contents = $_POST['content'];
	$cg_code = $_POST['cg_code'];	
	$g_state = $_POST['sel_g_state'];	


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


	$t_chk = true;	//쿼리 이상유무 체크 변수

	mysqli_query($CONN['rosemary'],"set autocommit = 0;");
	mysqli_query($CONN['rosemary'],"begin;");
	
	$con_sel_qry = mysqli_query($CONN['rosemary'],"select g_explanation from goods where g_num = '$g_num'"); //기존 본문글에 이미지가 첨부되어 있다면 기존 올라간 파일을 다 삭제하고 새롭게 수정해줘야 한다.
	$con_nums = mysqli_num_rows($con_sel_qry);
	if (!$con_nums) {
		$t_chk = false;
		$err_msg = 2;
	} else{

		$y_con = @mysqli_result($con_sel_qry,0,0);

		$y_con_img = explode("_tmp_e_",$y_con);
		$y_con_end_for = count($y_con_img);
		$del_img_array = array();
		for($i=0;$i<$y_con_end_for;$i++) {
			$y_contents_img2 = explode("_tmp_s_",$y_con_img[$i]);
				if ($y_contents_img2[1] != "" || !empty($y_contents_img2[1]) ) {
					$upfile = "_tmp_s_".$y_contents_img2[1]."_tmp_e_";
					$del_img_array[$i] = $upfile;				// 바로 삭제 하지 않는 이유는 먼저 지웠다가 만약 업데이트가 안돼면 이미지 엑박 뜨기 때문임. 확실히 업데이트 이후 삭제해주자
				}
		}

		


			$con_update = mysqli_query($CONN['rosemary'],"
															update 
																	goods 
															set 
																	g_name = '$g_name',
																	ca_num = '$ca_num',
																	g_discount_rate = '$g_discount_rate',
																	g_benefit = '$g_benefit',
																	g_explanation = '$contents',
																	cg_code = '$cg_code',
																	g_state = '$g_state'
															where
																	g_num = '$g_num'

									");


		if (!$con_update) {
			$t_chk = false;
			$err_msg = 3;					
		} else{
			if (!empty($del_img_array)) {									//삭제 될 이미지가 있다면 삭제를 한다. - 기존 이미지들임 여기서 주의해야할 점이. 그냥 기존 이미지를 수정하지 않고 그냥 원본을 다시 저장했을때
				//이다. 그런 경우 따로 체크를 하지 않으면 원본 이미지를 삭제 해버리기 때문에 삭제할 이미지와 새로 추가된 이미지의 이름이 서로 같다면 삭제하지
				$del_end_for = count($del_img_array);					//말아야 한다.
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
							@unlink($dir_img.'/'.$del_img_array[$i]);
					}
				
				}
			}
		}
	}


	if ($t_chk == false) {
		mysqli_query($CONN['rosemary'],"rollback;");
		alertback("수정 실패");
	} else {
		mysqli_query($CONN['rosemary'],"commit;");	
		alertGo("","../index.php?mode=goods_subject_reg&g_num=$g_num");
	}
	


} else if ($mode == "subject") {	//강의 정보 변경

	$feild = $_POST['feild'];
	$lts_num = $_POST['num'];
	$value = addslashes(trim($_POST['val']));


	$up_query = mysqli_query($CONN['rosemary'],"update goods_lecture_subjects set $feild = '$value' where lts_num = '$lts_num'");
	
	ob_start();

	if (!$up_query) {
		echo "X|디비 업데이트 실패.";
	} else {
		if ($feild == "lsct_code") {
			$query = mysqli_query($CONN['rosemary'],"select lsct_name from goods_lecture_subjects_ctype where lsct_code = '$value'");
			$name = mysqli_result($query,0,0);
			echo "T|".$name;
		} else {
			echo "T|수정되었습니다.|".$value;;
		}
	}

	$concon=ob_get_contents();
	ob_end_clean();
	echo $concon;	



} else if($mode == "modi_movie") {

	$ltsp_num = $_POST['ltsp_num'];
	$ltsp_period_num = $_POST['ltsp_period_num'];
	$ltsp_time_length = $_POST['ltsp_time_length'];
	$movie_sample = $_POST['movie_sample'];
	if (!$movie_sample){
		$movie_sample = "N";
	} 
	$ltsp_name = addslashes(trim($_POST['ltsp_name']));
	$ltsp_url = addslashes(trim($_POST['ltsp_url']));

	$up_query = mysqli_query($CONN['rosemary'],"update 
														goods_lecture_subjects_period 
												set
														ltsp_period_num = '$ltsp_period_num',
														ltsp_time_length = '$ltsp_time_length',
														ltsp_sample_yn = '$movie_sample',
														ltsp_name = '$ltsp_name',
														ltsp_url = '$ltsp_url'

												where 
														ltsp_num = '$ltsp_num'");


	ob_start();

	if (!$up_query) {
		echo "X|디비 업데이트 실패.";
	} else {
		echo "T|수정되었습니다.";
	}

	$concon=ob_get_contents();
	ob_end_clean();
	echo $concon;

} else if ($mode == "dan_modi_view") {

	
	$num = $_POST['num'];
	
	if(!$num){
		ob_start();
		echo "X|1"; 
		$concon=ob_get_contents();
		ob_end_clean();
		echo $concon;
		exit;
	}


	// 해당 단과 정보를 가져온다.

	$dan_q = mysqli_query($CONN['rosemary'],"select * from goods_lecture where lt_num = '$num'");
	$dan_n = @mysqli_num_rows($dan_q);
	if (!$dan_n) {
		ob_start();
		echo "X|2"; 
		$concon=ob_get_contents();
		ob_end_clean();
		echo $concon;
		exit;		
	}

	$dan_rs = mysqli_fetch_array($dan_q);
	$lt_name = $dan_rs['lt_name'];
	$lt_term = $dan_rs['lt_term'];
	$lt_selling_price = $dan_rs['lt_selling_price'];
	$mb_num = $dan_rs['mb_num'];
	
	$te_query =  mysqli_query($CONN['rosemary'],"select * from member where mt_code = 'T'");
	$te_num = mysqli_num_rows($te_query);

	if ($te_num > 0) {
		while($te_rs = mysqli_fetch_array($te_query)){
			$te_name = $te_rs['mb_name'];
			$te_num = $te_rs['mb_num'];
			if ($mb_num == $te_num) {
				$selected =  "selected";
			} else {
				$selected =  "";
			}
			
			$te_option .= "<option value = '$te_num' $selected >$te_name</option>";
		}
	} else {
			$te_option .= "<option>등록된 교수가 없습니다.</option>";
	}


	$book_query = mysqli_query($CONN['rosemary'],"select * from book where bo_useyn = 'Y'");
	$book_num = mysqli_num_rows($book_query);

	if ($book_num > 0) {
		while($book_rs = mysqli_fetch_array($book_query)){
			$book_name = $book_rs['bo_name'];
			$book_num = $book_rs['bo_num'];
			$book_value = $book_rs['bo_num']."|".$book_rs['bo_name'];
			$book_option .= "<option value = $book_value>$book_name</option>";
		}
	} else {
			$book_option .= "<option>등록된 교재가 없습니다.</option>";
	}


	$my_book_query = mysqli_query($CONN['rosemary'],"select bo_num,(select b.bo_name from book b where b.bo_num = a.bo_num ) as bo_name from goods_lecture_book a where lt_num = '$num'");
	$my_book_num = mysqli_num_rows($my_book_query);

	if ($my_book_num > 0) {
		$my_book_option = "";
		while($my_book_rs = mysqli_fetch_array($my_book_query)){
			$my_book_name = $my_book_rs['bo_name'];
			$my_book_num = $my_book_rs['bo_num'];
			$my_book_value = $my_book_rs['bo_num']."|".$my_book_rs['bo_name'];
			$my_book_option .= "<option value = $my_book_value>$my_book_name</option>";
		}
	} 


echo "T|*| 
<table width='900' border='0' cellspacing='1' cellpadding='3' class='td' bgcolor='#999999' style='white-space:nowrap'>
	<tr bgcolor='#FFFFFF'>

		<td width=30% align=center>  단과명 : <input type = 'text' name = 'lt_name' value = '$lt_name'><input type = 'hidden' name  = 'modi_set_select' id = 'modi_set_select'></td>
				
		<td bgcolor='#FFFFFF' >
			<table width='100%' border='0' cellspacing='1' cellpadding='3' class='td' bgcolor='#999999' style='white-space:nowrap'>
			<tr >
				<td bgcolor='#EFEFEF' align=center>담당교수</td>
				<td bgcolor='#FFFFFF' >
					<select name = 'mb_num'>
					$te_option
					</select>
				</td>
				<td bgcolor='#EFEFEF' align=center>교재</td>
				<td bgcolor='#FFFFFF'>
					<select name='modi_list_0'  id='modi_list_0' size='7' style='width:535; height:90; background-color=#FFFFFF;' multiple class='formtype' ondblclick=\"chk_select(this.value,'modi_list_0','modi_list2_0')\">
						<option value='none' >========선택하세요=======</option>
						$book_option
					</select>	
														
					<select name='modi_list2_0' id='modi_list2_0' size='7' style='width:535; height:90; background-color=#FFFFFF;' multiple class='formtype' ondblclick=\"chk_select(this.value,'modi_list2_0','modi_list_0')\">
						<option value='none'>========선택된 교재=======</option>
						$my_book_option
					</select>
				</td>				
			</tr>
			<tr >
				<td bgcolor='#EFEFEF' align=center>기간</td>
				<td bgcolor='#FFFFFF'><input type = 'text' name = 'lt_term' value = '$lt_term'>일</td>
				<td bgcolor='#EFEFEF' align=center>가격</td>
				<td bgcolor='#FFFFFF'><input type = 'text' name = 'lt_selling_price' value = '$lt_selling_price'>원</td>
			</tr>
			</table>
		</td>
	</tr>
</table>

";



} else if ($mode == "dan_modi") {

	$lt_num = $_POST['lt_num'];
	$lt_name = addslashes(trim($_POST['lt_name']));
	$mb_num = $_POST['mb_num'];
	$lt_term = $_POST['lt_term'];
	$price = $_POST['lt_selling_price'];
	$book_list = $_POST['modi_set_select'];


	$book_array = explode("<>",$book_list);
	$book_end_for = count($book_array);

	$t_chk = true;

	mysqli_query($CONN['rosemary'],"set autocommit = 0;");
	mysqli_query($CONN['rosemary'],"begin;");

	// 해당 단과의 책목록을 일괄적으로 모두 삭제 처리 하고 새로이 인설트 한다.							
	$book_del = mysqli_query($CONN['rosemary'],"delete from goods_lecture_book where lt_num = '$lt_num'");
	if (!$book_del) {
		$t_chk = false;
	} else {
		for ($j = 0; $j < $book_end_for + 1; $j++) { 
			if (!empty($book_array[$j])) {
				$book_num_array = explode("|",$book_array[$j]);
				$book_num = $book_num_array[0];
				$book_in_query = mysqli_query($CONN['rosemary'],"insert into goods_lecture_book(lt_num,bo_num) values('$lt_num','$book_num')");
				if (!$book_in_query) {
					$t_chk = false;
				}
			}
		}

		if ($t_chk == false) {
			exit;
		} else {
			$up_query = mysqli_query($CONN['rosemary'],"update goods_lecture set lt_name = '$lt_name', lt_term = '$lt_term', lt_selling_price = '$price', mb_num = '$mb_num' where lt_num = '$lt_num'");
			if (!$up_query) {
				$t_chk = false;
			}

		}
	}

	$te_name_query = mysqli_query($CONN['rosemary'],"select mb_name as name from member where mb_num = '$mb_num'");
	$te_name = mysqli_result($te_name_query,0,0);
	

	if ($t_chk == false) {
		mysqli_query($CONN['rosemary'],"rollback;");
		ob_start();
		echo "X|2"; 
		$concon=ob_get_contents();
		ob_end_clean();
		echo $concon;
		exit;	
	} else {
		mysqli_query($CONN['rosemary'],"commit;");	
		ob_start();
		echo "T|성공|".$te_name; 
		$concon=ob_get_contents();
		ob_end_clean();
		echo $concon;
		exit;	
	}



}

?>