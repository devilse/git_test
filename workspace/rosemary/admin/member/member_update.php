<?php
header('Content-Type: text/html;charset=utf-8');

include "../../_lib/function.php";	// 관리자 페이지 공용 함수 파일
include "../../_lib/db_conn.php";	// 디비 접속	
include "../../_lib/global.php";	// 관리자 페이지 공용 변수 파일
include "../../_lib/lib.php";	// 관리자 페이지 공용 디비 함수 파일

$t_chk = true;	//쿼리 이상유무 체크 변수 

$type = $_GET['type'];									//회원 구분
$c = $_GET['c'];										//등록, 수정, 삭제 구분
$page = $_GET['page'];									//페이지 번호
$mode = $_POST['mode'];

$num = $_POST['mb_num'];
$id = $_POST['mb_id'];									//id
$name = $_POST['mb_name'];								//이름
$password = $_POST['mb_password'];						//비밀번호
$zipcode = $_POST['zip1'].$_POST['zip2'];				//우편번호
$address1 = $_POST['address1'];							//주소1
$address2 = $_POST['address2'];							//주소2
$tel = $_POST['tel1']."-".$_POST['tel2']."-".$_POST['tel3'];	//전화번호	
$hp = $_POST['hp1']."-".$_POST['hp2']."-".$_POST['hp3'];		//핸드폰번호
$e_mail = $_POST['mb_e_mail'];							//이메일
$business = $_POST['business'];							//영업자번호

$biography = $_POST['biography'];						//교수 약력
$education = $_POST['education'];						//교수 학력
$paper = $_POST['paper'];								//교수 논문
$mb_img_del = $_POST['mb_img_del'];						//교수 사진

$hostname = $_POST['hostname'];							//영업자 호스트명
$captain = $_POST['captain'];							//영업자 직책
$mb_use = $_POST['mb_use'];								//영업자 사용유무
$messenger = $_POST['messenger'];						//영업자 메신저
$cafeurl = $_POST['cafeurl'];							//영업자 카페주소
$dept = $_POST['dept'];									//영업자 부서

$date = mktime();

$file_name= $_FILES['mb_img']['name'];
$tmp_name= $_FILES['mb_img']['tmp_name'];

if ($c == 'add') {
	$sql = @mysqli_query($CONN['rosemary'],"select count(*)cnt from member");
	$cnt = mysqli_fetch_array($sql);
	$num = $cnt['cnt'] + 1;
}

// 이미지 파일 	
for($v_loop = 0;$v_loop < strlen($file_name);$v_loop++)
{
	if (substr($file_name,$v_loop,1) == "."){
		$v_start = $v_loop;
	}
}
$v_ext = strtolower(substr($file_name,$v_start + 1,strlen($file_name) - $v_start));

$mb_path = "$dir_img/teacher_img";

if ($mb_img_del) {
	@unlink("$mb_path/$mb_img_del");
	$img_del .= "  mb_picture = '' ,";
}

if ($file_name) {
	$mb_img_urlencode =teacher."_".$num."_".time().".".$v_ext;
	$img_insert .= "$mb_img_urlencode";
	$img_up .= " , mb_img='$mb_img_urlencode' ";
}	

if ($file_name) {

	$mb_img_path = "$mb_path/$mb_img_urlencode";
	
	$result = @move_uploaded_file($tmp_name, $mb_img_path);
	
	if ($result == true) {
		echo '성공';
	} else {
		echo '실패';
	}
}	

if ($c == 'add') {
	
	$sql = @mysqli_query($CONN['rosemary'],"select MAX(mb_num) AS max from member");
	$cnt = mysqli_fetch_array($sql);
	$num = $cnt['max'] + 1;
	
	$pw = md5($password);
	$pw1 = md5($pw);
	
	@mysqli_query($CONN['rosemary'],"set autocommit = 0;");
	@mysqli_query($CONN['rosemary'],"begin;");
	
	$v_sql1 = "insert into member values ('$num','$name','$id','$pw1','$e_mail','$tel','$hp','$type','$date','$host_ip')";
	
	$v_sql = @mysqli_query($CONN['rosemary'],$v_sql1);
	
	if (!$v_sql) {
	
		$t_chk = false;
		$err_msg = "회원 등록 중 오류가 발생 하였습니다.";
	} else {
	
		if ($type == 'S') {	
		
			if ($business == '') {
				$test = ", NULL";
			} else {
				$test = ", '$business'";
			}
			
			$v_sql1 = "insert into member_student(mb_num, ms_zipcode, ms_address, ms_address_detail, mb_marketer_num) values('$num','$zipcode','$address1','$address2' $test )";
			
			$v_sql = @mysqli_query($CONN['rosemary'],$v_sql1);
			
			if (!$v_sql) {
				$t_chk = false;
				$err_msg = "학습자 등록 중 오류가 발생 하였습니다.";
			}
		}else if ($type == 'T') {
		
			$v_sql1 = "insert into member_teacher values ('$num', '$img_insert', '$biography', '$education', '$paper')";
			
			$v_sql = @mysqli_query($CONN['rosemary'],$v_sql1);
			
			if (!$v_sql) {
				$t_chk = false;
				$err_msg = "교수자 등록 중 오류가 발생 하였습니다.";
			}
		
		}else if ($type == 'M') {
		
			if ($mb_use =='') {
				$mb_use = 'N';
			}
			
			$v_sql1 = "insert into member_marketer values('$num', '$hostname', '$captain', '$mb_use', '$messenger', '$cafeurl','$dept' )"; //
			
			$v_sql = @mysqli_query($CONN['rosemary'],$v_sql1);
			
			if (!$v_sql) {
				$t_chk = false;
				$err_msg = "영업자 등록 중 오류가 발생 하였습니다.";
			}
		
		}else if ($type == 'A') {
		
		}
	}	
	
	if ($t_chk != true) {
		mysqli_query($CONN['rosemary'],"rollback;");
		alert($err_msg);
	} else {
		mysqli_query($CONN['rosemary'],"commit;");	
		echo "<script type='text/javascript'>
			alert('회원이 등록되었습니다.');
			opener.location ='index.php?mode=$mode'; 
			this.close(); 
		</script>"; 
	}

}else if ($c == 'up') {
	
	if ($type == 'A') {
		$pw = md5($password);
		$pw1 = md5($pw);
		
		$pw2  .= " mb_password = '$pw1', ";
		
	} else {
		$pw2 .= "";
	}
	
	@mysqli_query($CONN['rosemary'],"set autocommit = 0;");
	@mysqli_query($CONN['rosemary'],"begin;");
	
	$v_sql1 = " update member
				set mb_name = '$name',
					mb_id = '$id',
					$pw2
					mb_email = '$e_mail',
					mb_tel = '$tel',
					mb_hp = '$hp'
				where mb_num = '$num'";
	
	$v_sql = @mysqli_query($CONN['rosemary'],$v_sql1);
	
	if (!$v_sql) {
	
		$t_chk = false;
		$err_msg = "회원 수정 중 오류가 발생 하였습니다.";
	
	} else {
	
		if ($type == 'S') {	
			
			if ($business == '') {
				$test = " mb_marketer_num = NULL";
			} else {
				$test = " mb_marketer_num = '$business'";
			}
			
			$v_sql1 = " update member_student
						set ms_zipcode = '$zipcode',
							ms_address = '$address1',
							ms_address_detail = '$address2',
							$test
						where mb_num = '$num' ";
			
			$v_sql = @mysqli_query($CONN['rosemary'],$v_sql1);
			
			if (!$v_sql) {
				$t_chk = false;
				$err_msg = "학습자 수정 중 오류가 발생 하였습니다.";
			}
		
		}else if ($type == 'T') {
		
			if ($mb_img_del) {
				$img = $img_del;
				
				$v_sql1 = " update member_teacher
							set $img
								mb_biography = '$biography',
								mb_education = '$education',
								mb_paper = '$paper'
							where mb_num = '$num' ";
				
				$v_sql = @mysqli_query($CONN['rosemary'],$v_sql1);				
				
			}
			if ($img_insert) {
				if ($img_insert == '') {
					$img .= "";
				} else {
					$img .= " mb_picture = '$img_insert' ,"; 
				}
				
				$v_sql1 = " update member_teacher
							set $img
								mb_biography = '$biography',
								mb_education = '$education',
								mb_paper = '$paper'
							where mb_num = '$num' ";
				
				$v_sql = @mysqli_query($CONN['rosemary'],$v_sql1);
			
			}
			
			if (!$v_sql) {
				$t_chk = false;
				$err_msg = "교수자 수정 중 오류가 발생 하였습니다.";
			}
		
		}else if ($type == 'M') {
		
			if ($mb_use =='') {
				$mb_use = 'N';
			}
			
			$v_sql1 = " update member_marketer
						set mb_hostname = '$hostname',
							mb_captainyn = '$captain',
							mb_useyn = '$mb_use',
							mb_messenger = '$messenger',
							mb_cafeurl = '$cafeurl',
							mbo_num = '$dept'
						where mb_num = '$num' ";
			
			$v_sql = @mysqli_query($CONN['rosemary'],$v_sql1);
			
			if (!$v_sql) {
				$t_chk = false;
				$err_msg = "영업자 수정 중 오류가 발생 하였습니다.";
			}
		
		}else if ($type == 'A') {
		
		}
	}
	
	if ($t_chk != true) {
		mysqli_query($CONN['rosemary'],"rollback;");
		alert($err_msg);
	} else {
		mysqli_query($CONN['rosemary'],"commit;");	
		echo "<script type='text/javascript'>
				alert('회원이 수정되었습니다.');
				opener.location ='index.php?mode=$mode&page=$page'; 
				this.close(); 
			</script>"; 
	}

}else if ($c == 'del') {

	$check_value = $_POST['checkValues'];
	
	$array = explode('||',$check_value);
	
	$check_cnt = sizeof($array);

	
	@mysqli_query($CONN['rosemary'],"set autocommit = 0;");
	@mysqli_query($CONN['rosemary'],"begin;");
	
	for($i=0; $i < $check_cnt; $i++) {
	
		$sql = @mysqli_query($CONN['rosemary'],"select * from member where mb_num = '$array[$i]'");
		
		$v_sql = mysqli_fetch_array($sql);
		

		if ($v_sql['mt_code'] == 'S') {
			$mode = 'student';
		
			$sql =" delete from member_student where mb_num = '$array[$i]' ";
			
			$sql1 = @mysqli_query($CONN['rosemary'],$sql);
			
			if (!$sql1) {
				$t_chk = false;
				$err_msg = "회원 삭제 중 오류가 발생 하였습니다.";
			
			} else {
			
				$sql =" delete from member where mb_num = '$array[$i]' ";
				
				$sql1 = @mysqli_query($CONN['rosemary'],$sql);
				
				if (!$sql1) {
					$t_chk = false;
					$err_msg = "회원 삭제 중 오류가 발생 하였습니다.";
				}
			}
			
		}else if ($v_sql['mt_code'] == 'T') {
			$mode = 'teacher';
		
			$sql =" delete from member_teacher where mb_num = '$array[$i]' ";
			
			$sql1 = @mysqli_query($CONN['rosemary'],$sql);
			
			if (!$sql1) {
				$t_chk = false;
				$err_msg = "회원 삭제 중 오류가 발생 하였습니다.";
			
			} else {
			
				$sql =" delete from member where mb_num = '$array[$i]' ";
				
				$sql1 = @mysqli_query($CONN['rosemary'],$sql);
				
				if (!$sql1) {
					$t_chk = false;
					$err_msg = "회원 삭제 중 오류가 발생 하였습니다.";
				}
			}
			
		} else if ($v_sql['mt_code'] == 'M') {
			$mode = 'marketer';
			$sql =" delete from member_marketer where mb_num = '$array[$i]' ";
			$sql1 = @mysqli_query($CONN['rosemary'],$sql);
			if (!$sql1) {
				$t_chk = false;
				$err_msg = "회원 삭제 중 오류가 발생 하였습니다.";
			} else {
				$sql =" delete from member where mb_num = '$array[$i]' ";
				$sql1 = @mysqli_query($CONN['rosemary'],$sql);
				if (!$sql1) {
					$t_chk = false;
					$err_msg = "회원 삭제 중 오류가 발생 하였습니다.";
				}
			}
	
		} else if ($v_sql['mt_code'] == 'A') {
			$mode = 'admin';
			$sql =" delete from member_admin where mb_num = '$array[$i]' ";
			$sql1 = @mysqli_query($CONN['rosemary'],$sql);
			if (!$sql1) {
				$t_chk = false;
				$err_msg = "회원 삭제 중 오류가 발생 하였습니다.";
			} else {
				$sql =" delete from member where mb_num = '$array[$i]' ";
				$sql1 = @mysqli_query($CONN['rosemary'],$sql);
				if (!$sql1) {
					$t_chk = false;
					$err_msg = "회원 삭제 중 오류가 발생 하였습니다.";
				}
			}

		}
	}
	
	if ($t_chk != true) {
		@mysqli_query($CONN['rosemary'],"rollback;");
		alert($err_msg);
	} else {
		@mysqli_query($CONN['rosemary'],"commit;");
		alertGo("회원이 삭제되었습니다.","./index.php?mode=$mode&page=$page");
	}
}
?>