<?php
header('Content-Type: text/html;charset=utf-8');

include "../../_lib/db_conn.php";	// 디비 접속
include "../../_lib/global.php";
include "../../_lib/function.php";
include "../../_lib/lib.php";


$User_Info =  Login_Chk($_COOKIE['LIPASS_ID']);		// 로그인 체크
if (!$User_Info) {
	echo "X|로그인이 필요합니다.";
	exit;
}

$mb_type = $User_Info['type'];						// 멤버타입
if ($User_Info['type'] != "G") {
	$mb_id = $User_Info['id'];						// 멤버아이디
	$mb_password = "";								// 멤버 비밀번호
	$mb_name = addslashes($User_Info['name']);		// 멤버 네임
}	

$title		= addslashes(trim($_POST['title']));	// 제목
$contents	= $_POST['content'];					// 내용
$user_ip	= $host_ip;								// 유저아이피
$gubun		= $_POST['gubun'];						// 구분 - 어떤 문의인지
$phone		= $_POST['phone1']."-".$_POST['phone2']."-".$_POST['phone3'];	// 구분 - 어떤 문의인지
$email		= $_POST['email1']."@".$_POST['email2'];						// 구분 - 어떤 문의인지
$counsel_chk		= $_POST['counsel_always'];						
if (!$counsel_chk) {
	$counsel_chk = "N";
}

$counsel_time = $counsel_chk."<>".$_POST['counsel_date1']."<>".$_POST['counsel_date2'];

$write_mode = $_POST['write_mode'];


if (!$title) {
	echo "X|제목을 입력해 주세요.";
	exit;
}
if (!$contents) {
	echo "X|내용을 입력해 주세요.";
	exit;
}


$img_use_chk = "N";
$contents_img = explode("_tmp_e_",$contents);
$end_for = 	count($contents_img);
for($i=0;$i<$end_for;$i++) {
	$img_use_chk = "Y";
	$contents_img2 = explode("_tmp_s_",$contents_img[$i]);
		if ($contents_img2[1] != "" || !empty($contents_img2[1]) ) {
			$upfile = "_tmp_s_".$contents_img2[1]."_tmp_e_";
			@move("../../dir_img_tmp/$upfile","../../dir_img/$upfile");
		}
}

$contents = eregi_replace("\\\\","",$contents);
$contents = eregi_replace("/dir_img_tmp"  , $MY_URL."dir_img",$contents);
$contents = addslashes(trim($contents));			// 내용





	
if (!$write_mode) {	// 글쓰기



	$t_chk = true;	//쿼리 이상유무 체크 변수
	mysqli_query($CONN['rosemary'],"set autocommit = 0;");
	mysqli_query($CONN['rosemary'],"begin;");

	$list_query = mysqli_query($CONN['rosemary'],"insert into 
							   qna_list(
												gubun,
												title,
												mb_id,
												mb_password,
												mb_name,
												img_chk,
												user_ip,
												reg_date,
												phone,
												email,
												counsel_time
							   ) 
							   values(
												'$gubun',
												'$title',
												'$mb_id',
												'$mb_password',
												'$mb_name',
												'$img_use_chk',
												'$user_ip',
												unix_timestamp(),
												'$phone',
												'$email',
												'$counsel_time'
							   
							   )");
	



	if (!$list_query) {
		$t_chk = false;
		$err_msg = "리스트 생성 실패";



	}else {
		$qna_num = mysqli_insert_id($CONN['rosemary']);
		if (!$qna_num) {
			$t_chk = false;
			$err_msg = "리스트 인설트 아이디 생성 실패";
		}else {
			$con_query = @mysqli_query($CONN['rosemary'],"insert into qna_contents(qna_num,contents,admin_contents) values('$qna_num','$contents','')");	//작업중 2012-11-01
			if (!$con_query) {
				$t_chk = false;
				$err_msg = "컨텐츠 생성 실패";
			}
		}
	}



	if ($t_chk != true) {
		mysqli_query($CONN['rosemary'],"rollback;");
		echo "X|".$err_msg;
	}else{
		mysqli_query($CONN['rosemary'],"commit;");	
		echo "T|".$qna_num;
	}
	
}else if($write_mode == "modi"){

	$qna_num = $_POST['qna_num'];
	$del_file_num = $_POST['del_file_num'];
	if (!$qna_num) {
		echo "X|접근할 수 없습니다.";
		exit;
	}


	$t_chk = true;	//쿼리 이상유무 체크 변수

	mysqli_query($CONN['rosemary'],"set autocommit = 0;");
	mysqli_query($CONN['rosemary'],"begin;");


	if ($del_file_num) {				// 기존 파일 삭제를 했을 경우
		$arr_files =  explode('<>', $del_file_num);
		$end_for = count($arr_files);
		for($i = 0; $i < $end_for; $i++) 
		{
			$file_num = $arr_files[$i];
			$file_set_qry = mysqli_query($CONN['rosemary'],"select * from qna_file where file_num = '$file_num'");
			$file_nums = mysqli_num_rows($file_set_qry);
			if ($file_nums) {
				$file_rs = mysqli_fetch_array($file_set_qry);
				if (@unlink($dir_file.'/'.$file_rs['file_tmp_name'])) {
					$file_del_qry = mysqli_query($CONN['rosemary'],"delete from qna_file where file_num = '$file_num'");
					if (!$file_del_qry) {
						$t_chk = false;
					}
				}			
			}
		}

		$file_use_qry = mysqli_query($CONN['rosemary'],"select count(*) as cnt from qna_file where qna_num = '$qna_num'");
		$file_use_cnt = @mysqli_result($file_use_qry,0,0);
		$file_feild_update = "";
		if (!$file_use_cnt) {
			$file_feild_update = " ,file_chk = 'N'";
		}
	}


	$list_update = mysqli_query($CONN['rosemary'],"
								update 
										qna_list 
								set 
										title = '$title',
										img_chk = '$img_use_chk',
								
										user_ip = '$host_ip',
										phone = '$phone',
										email = '$email',
										counsel_time = '$counsel_time'

										$file_feild_update

								where
										qna_num = '$qna_num'
								");
	if (!$list_update) {
		$t_chk = false;
		$err_msg = 1;
	} else{
// 3.
		$con_sel_qry = mysqli_query($CONN['rosemary'],"select contents from qna_contents where qna_num = '$qna_num'"); //기존 본문글에 이미지가 첨부되어 있다면 기존 올라간 파일을 다 삭제하고 새롭게 수정해줘야 한다.
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
			
			$con_update = mysqli_query($CONN['rosemary'],"update qna_contents set contents = '$contents' where qna_num = '$qna_num'");
			if (!$con_update) {
				$t_chk = false;
				$err_msg = 3;					
			} else{
				if (!empty($del_img_array)) {	//삭제 될 이미지가 있다면 삭제를 한다. - 기존 이미지들임 여기서 주의해야할 점이. 그냥 기존 이미지를 수정하지 않고 그냥 원본을 다시 저장했을때
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
		echo "T|".$qna_num;
	}

}

?>

