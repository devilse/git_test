<?php
header('Content-Type: text/html;charset=utf-8');

include "../../_lib/db_conn.php";	// 디비 접속
include "../../_lib/global.php";
include "../../_lib/function.php";
include "../../_lib/lib.php";


$write_mode	 = $_POST['write_mode'];						// 쓰기모드 - 쓰기 모드 값이 없으면 그냥 쓰기고 있으면 수정이나 답글이다. 
$User_Info	 =  Login_Chk($_COOKIE['LIPASS_ID']);			// 로그인 정보 가져오기
$mb_type	 = $User_Info['type'];							// 유저 타입

if ($mb_type != "G") {
	$mb_id = $User_Info['id'];								// 유저아이디
	$mb_password = "";										// 유저패스워드
	
	if ($mb_type != "M") {
		$mb_name = addslashes($User_Info['name']);				// 유저네임	
	} else {
		$mb_name = addslashes(trim($_POST['user_name']));				// 유저네임	
		if (!$mb_name) {
			$mb_name = addslashes($User_Info['name']);
		}
	}
} else {
	$user_pwd = $_POST['user_pwd'];
	if (!$user_pwd) {
		echo "X|비밀번호를 입력해 주세요.";
		exit;
	}
	$mb_id = "GUEST";										// 유저아이디
	$mb_password = md5(md5($user_pwd));								// 유저패스워드
	$mb_name = addslashes(trim($_POST['user_name']));		// 유저네임		
}

$bo_num	 = $_POST['bo_num'];								// 게시판 번호
$title	 = addslashes(trim($_POST['title']));				// 제목
$contents = $_POST['content'];								// 내용
$cg_code = $_POST['cg_code'];								// cs 코드
$ca_num = $_POST['sel_ca_num'];								// 해당 cs의 카테고리 번호
$lt_num = $_POST['sel_goods_num'];							// 해당 카테고리의 상품번호





$guin_state = $_POST['list_mal'];						// 구인게시판 상태 (구인,구직) <--- 구인 게시판에서만 값이 있음
$company_url = addslashes(trim($_POST['company_url']));		// 회사 url
$guin_date_arry = explode("-",$_POST['guin_date']);
$guin_date = @mktime(0,0,0,$guin_date_arry[1],$guin_date_arry[2],$guin_date_arry[0]);


$contents2 = addslashes(trim($_POST['certifi']));			// 우대 자격증 <--- 해당 데이터는 board_contetns 의 contetns2 필드에 값을 너어줌. 현재 게시판 형태가 다른건 구인구직 게시판 붙이니 후에 만약 또 다른 형태의 게시판이 추가된다면 그때 해당 데이터는 게시판 종류에 따라 넣어주고, 해당 필드는 게시판 종류에 따라 하는 역활이 달라진다 

if (!$bo_num) {
	echo "X|필요한 정보가 누락 되었습니다.";
	exit;
}
if (!$mb_id) {
	echo "X|로그인 정보가 없습니다.";
	exit;
}
if (!$title) {
	echo "X|제목을 입력해 주세요.";
	exit;
}
if (!$contents) {
	echo "X|내용을 입력해 주세요.";
	exit;
}


$img_use_chk	= "N";									// 이미지 첨부 체크 - 이미지 첨부를 했다면 해당 변수에 Y
$contents_img	= explode("_tmp_e_",$contents);			// 본문내 첨부된 이미지를 배열로 쪼갠다.
$end_for		= count($contents_img);					// 이미지 배열 길이
for ($i=0;$i<$end_for;$i++) {
	$img_use_chk = "Y";
	$contents_img2 = explode("_tmp_s_",$contents_img[$i]);
		if ($contents_img2[1] != "" || !empty($contents_img2[1]) ) {
			$upfile = "_tmp_s_".$contents_img2[1]."_tmp_e_";
			@move("../../dir_img_tmp/$upfile","../../dir_img/$upfile");
		}
}

$contents = eregi_replace("\\\\","",$contents);
$contents = eregi_replace("/dir_img_tmp"  , $MY_URL."dir_img",$contents);
$contents = addslashes(trim($contents));				// 실제 내용
$user_ip = $host_ip;									// 유저 아이피

if (!$cg_code || empty($cg_code)) {
	$cg_code = '';											
}

if (!$ca_num || empty($ca_num)) {
	$ca_num = null;											
}

if (!$lt_num || empty($lt_num)) {
	$lt_num = null;											
}




$notice_chk = $_POST['notice_chk'];						// 공지체크
$secret_chk = $_POST['secret_chk'];						// 비밀글 체크	
if ($notice_chk != "Y") {
	$notice_chk = "N";
}
if ($secret_chk != "Y") {
	$secret_chk = "N";
}

if (!$write_mode) {	// 글쓰기

	$set_use_chk = Set_Chk("set_write");
	if ($set_use_chk['set_write'] != "Y") {
		echo "X|게시물을 작성할 수 있는 권한이 없습니다.";
		exit;
	}	


	// 계층형 순서 번호를 가져온다.
	$seq_query = mysqli_query($CONN['rosemary'],"select max(seq) as seq from board_list where bo_num = '$bo_num'");
	$seq_rs=mysqli_fetch_array($seq_query); 

	if (!$seq_rs['seq'] || empty($seq_rs['seq'])) {
		$seq = 1;
	} else{
		$seq = $seq_rs['seq'] + 1;
	}

	$ref = 0;
    $dep = 0;

	$list_img = "";



	$t_chk = true;	//쿼리 이상유무 체크 변수

	mysqli_query($CONN['rosemary'],"set autocommit = 0;");
	mysqli_query($CONN['rosemary'],"begin;");
	
	$list_query = @mysqli_query($CONN['rosemary'],"
								insert into 
								board_list(
											bo_num,
											title,
											mb_id,
											mb_password,
											mb_name,
											img_chk,
											user_ip,
											reg_date,
											seq,
											ref,
											dep,
											cg_code,
											notice_chk,
											secret_chk,
											lt_num,
											ca_num,
											list_state,
											end_date,
											list_img

								) 
								values(
											'$bo_num',
											'$title',
											'$mb_id',
											'$mb_password',
											'$mb_name',
											'$img_use_chk',
											'$user_ip',
											unix_timestamp(),
											'$seq',
											'$ref',
											'$dep',
											'$cg_code',
											'$notice_chk',
											'$secret_chk',
											'$lt_num',
											'$ca_num',
											'$guin_state',
											'$guin_date',
											'$list_img'
								)	
	");								

	if (!$list_query) {
		$t_chk = false;
		$err_msg = 1;		
	} else{
		$list_num = mysqli_insert_id($CONN['rosemary']);
		if (!$list_num) {
			$t_chk = false;
			$err_msg = 1;	
		} else{
			$con_query = @mysqli_query($CONN['rosemary'],"insert into board_contents(list_num,contents,url,contents2) values('$list_num','$contents','$company_url','$contents2')");	
			if (!$con_query) {
				$t_chk = false;
				$err_msg = 2;	
			} else{
				$list_update = @mysqli_query($CONN['rosemary'],"update board set list_cnt = list_cnt + 1 where bo_num = '$bo_num'");
				if (!$list_update) {
					$t_chk = false;
					$err_msg = 3;	
				}
			}
		}
	}

	if ($t_chk != true) {
		mysqli_query($CONN['rosemary'],"rollback;");
		echo "X|".$err_msg;
	} else{
		mysqli_query($CONN['rosemary'],"commit;");	
		echo "T|".$list_num;
	}

} else if ($write_mode == "modi") {			//수정하기

	$list_num = $_POST['list_num'];
	$del_file_num = $_POST['del_file_num'];
	if (!$list_num) {
		echo "X|접근할 수 없습니다.";
		exit;
	}

	//비회원인 경우는 비밀번호로 체크 한다. 

	if ($mb_type == "G") {	// 비회원인경우
		$list_chk_query = @mysqli_query($CONN['rosemary'],"select * from board_list where list_num = '$list_num' and mb_password = '$mb_password'");
		$list_chk_nums = @mysqli_num_rows($list_chk_query);
		if (!$list_chk_nums) {
			echo "X|게시물을 수정할 수 있는 권한이 없습니다.";
			exit;
		}		
	} else {
		$set_use_chk = Set_Chk("set_modi"); 	// 자신의 게시물이거나 수정 권한을 가진 사람 인지 알아온다.
		if ($set_use_chk['set_modi'] != "Y") {	// 해당 게시판이 수정이 불가능하다. 하지만 자신의 게시물이라면 권한에 상관없이 수정되어야 한다.
			$list_chk_query = @mysqli_query($CONN['rosemary'],"select * from board_list where list_num = '$list_num' and mb_id = '$mb_id'");
			$list_chk_nums = @mysqli_num_rows($list_chk_query);
			if (!$list_chk_nums) {
				echo "X|게시물을 수정할 수 있는 권한이 없습니다.";
				exit;
			}
		}	
	}



	/*
		1. 첨부파일 변경
		2. 게시판 리스트 정보 변경
		3. 내용 정보 변경
	*/

	$t_chk = true;	//쿼리 이상유무 체크 변수

	mysqli_query($CONN['rosemary'],"set autocommit = 0;");
	mysqli_query($CONN['rosemary'],"begin;");

	// 1.
	if ($del_file_num) {
		$arr_files =  explode('<>', $del_file_num);
		$end_for = count($arr_files);
		for($i = 0; $i < $end_for; $i++) 
		{
			$file_num = $arr_files[$i];
			$file_set_qry = mysqli_query($CONN['rosemary'],"select * from board_file where file_num = '$file_num'");
			$file_nums = mysqli_num_rows($file_set_qry);
			if ($file_nums) {
				$file_rs = mysqli_fetch_array($file_set_qry);
				if (@unlink($dir_file.'/'.$file_rs['file_tmp_name'])) {
					$file_del_qry = mysqli_query($CONN['rosemary'],"delete from board_file where file_num = '$file_num'");
					if (!$file_del_qry) $t_chk = false;
				}			
			}
		}

		$file_use_qry = mysqli_query($CONN['rosemary'],"select count(*) as cnt from board_file where list_num = '$list_num'");
		$file_use_cnt = @mysqli_result($file_use_qry,0,0);
		$file_feild_update = "";
		if (!$file_use_cnt) {
			$file_feild_update = " ,file_chk = 'N'";
		}
		
	}	

	//관리자는 해당 시간과 조회수를 수정할 수 있다.
	$set_admin_chk = Set_Chk("set_admin");
	if ($set_admin_chk == "Y") {
		$hit = $_POST['hit'];
		$reg_date = $_POST['reg_date'];
		if (!$hit) $hit = 0;
		$reg_array = explode(" ",$_POST['reg_date']);
		$reg_array1 = explode("-",$reg_array[0]);
		$reg_array2 = explode(":",$reg_array[1]);
		$up_date = mktime($reg_array2[0],$reg_array2[1],$reg_array2[2],$reg_array1[1],$reg_array1[2],$reg_array1[0]);
		$admin_update = " hit_cnt = $hit, reg_date = '$up_date',";
	}

	if (!empty($guin_state)) {
		$list_mal_update = " ,list_state = '$guin_state'";
	}

	// 2.
	$list_update = mysqli_query($CONN['rosemary'],"
								update 
										board_list 
								set 
										title = '$title',
										mb_name = '$mb_name',
										img_chk = '$img_use_chk',
										notice_chk = '$notice_chk',
										$admin_update
										user_ip = '$host_ip',
										cg_code = '$cg_code',
										ca_num = '$ca_num',
										lt_num = '$lt_num'

										$file_feild_update
										$list_mal_update

								where
										list_num = '$list_num'
								");
		if (!$list_update) {
			$t_chk = false;
			$err_msg = 1;
		} else{
	// 3.
			$con_sel_qry = mysqli_query($CONN['rosemary'],"select contents from board_contents where list_num = '$list_num'"); //기존 본문글에 이미지가 첨부되어 있다면 기존 올라간 파일을 다 삭제하고 새롭게 수정해줘야 한다.
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
				
				$con_update = mysqli_query($CONN['rosemary'],"update board_contents set contents = '$contents' where list_num = '$list_num'");
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
		}


	if ($t_chk != true) {
		mysqli_query($CONN['rosemary'],"rollback;");
		echo "X|".$err_msg;
	} else{
		mysqli_query($CONN['rosemary'],"commit;");	
		echo "T|".$list_num;
	}


} else if ($write_mode == "reply") {			//수정하기
			
	$set_use_chk = Set_Chk("set_reply");
	if ($set_use_chk['set_reply'] != "Y") {
		echo "X|게시물을 작성할 수 있는 권한이 없습니다.";
		exit;
	}	
	

	$seq = $_POST['seq'];			// 계층형 게시물 번호
	$ref = $_POST['ref'];			// 답글 깊이
	$dep = $_POST['dep'];			// 답글 순서

	
	if (!$seq) {
		echo "X|필요한 정보가 누락22 되었습니다.";
		exit;
	}


	$t_chk = true;	//쿼리 이상유무 체크 변수

	mysqli_query($CONN['rosemary'],"set autocommit = 0;");
	mysqli_query($CONN['rosemary'],"begin;");



	$seq_update_query = mysqli_query($CONN['rosemary'],"update board_list set dep = dep + 1 where seq = '$seq' and dep > $dep");
	if (!$seq_update_query) {
		echo "X|업데이트 실패.";
	} else{
		$ref = $ref + 1; 
		$dep = $dep + 1;
				
		$list_query = @mysqli_query($CONN['rosemary'],"
								insert into 
								board_list(
											bo_num,
											title,
											mb_id,
											mb_password,
											mb_name,
											img_chk,
											user_ip,
											reg_date,
											seq,
											ref,
											dep,
											cg_code,
											notice_chk,
											secret_chk,
											lt_num,
											ca_num
								) 
								values(
											'$bo_num',
											'$title',
											'$mb_id',
											'$mb_password',
											'$mb_name',
											'$img_use_chk',
											'$user_ip',
											unix_timestamp(),
											'$seq',
											'$ref',
											'$dep',
											'$cg_code',
											'$notice_chk',
											'$secret_chk',
											'$lt_num',
											'$ca_num'
								)	
		");								

		if (!$list_query) {
			$t_chk = false;
			$err_msg = 1;		
		} else{
			$list_num = mysqli_insert_id($CONN['rosemary']);
			if (!$list_num) {
				$t_chk = false;
				$err_msg = 1;	
			} else{
				$con_query = @mysqli_query($CONN['rosemary'],"insert into board_contents(list_num,contents) values('$list_num','$contents')");	
				if (!$con_query) {
					$t_chk = false;
					$err_msg = 2;	
				}
			}
		}

		if ($t_chk != true) {
			mysqli_query($CONN['rosemary'],"rollback;");
			echo "X|".$err_msg;
		} else{
			mysqli_query($CONN['rosemary'],"commit;");	
			echo "T|".$list_num;
		}
	}

}

?>