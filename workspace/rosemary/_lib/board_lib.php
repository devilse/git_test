<?
$member_id = $User_Info['id'];


//파라미터 변수에 담기
$bo_num = $_GET['bo_num'];	//게시판 pk 번호
if (!$bo_num) $bo_num = $_POST['bo_num'];
$set_cs = $_GET['set_cs'];	//선택한 cs
if (!$set_cs) $set_cs = $_POST['set_cs'];
if (!$set_cs) {
	$set_cs = $tpl->cs;
}
$set_cate = $_GET['set_cate'];	//선택한 카테고리
if (!$set_cate) $set_cate = $_POST['set_cate'];
$set_goods = $_GET['set_goods'];	//선택한 카테고리
if (!$set_goods) $set_goods = $_POST['set_goods'];
$sub_menu_num = $_GET['sub_menu_num'];
if (!$sub_menu_num) $sub_menu_num = $_POST['sub_menu_num'];
$key = $_GET['key'];
if (!$key) $key = $_POST['key'];
$searchword = trim($_GET['searchword']);
if (!$searchword) $searchword = $_POST['searchword'];
$list_notice_chk = $_GET['list_notice_chk'];
if (!$list_notice_chk) $list_notice_chk = $_POST['list_notice_chk'];
$guin_state = $_GET['guin_state'];
if (!$guin_state) $guin_state = $_POST['bo_num'];
$list_page = $_GET['list_page'];
if (!$list_page) $list_page = $_POST['list_page'];
$list_num = $_GET['list_num'];
if (!$list_num) $list_num = $_POST['list_num'];

if (!$bo_num) { 
	alertback("접근 할 수 없습니다.");
}

if (empty($list_page)) {
	$list_page = 1;
}

if (!$key && $searchword) {
	$key = "title";
}

if ($key && $searchword) {
	$searchword_chk = 1;
	if (preg_match("/[!#$%^&*()?{}.;:<>+=\/]/",$searchword)) {
		$searchword_chk = 0; 
	}
	if ($searchword_chk != 1) {
		alertback("특수문자가 포함되어 검색할 수 없습니다.");
	}
	$encode_searchword = urlencode($searchword);
}



// 사용자 각종 권한을 가져온다.
$set_use_chk = Set_Chk("*");
$set_access = $set_use_chk['set_access'];					// 사용자 접근 권한			
$set_write = $set_use_chk['set_write'];						// 사용자 쓰기 권한
$set_view = $set_use_chk['set_view'];						// 사용자 보기 권한
$set_modi = $set_use_chk['set_modi'];						// 사용자 수정 권한
$set_del = $set_use_chk['set_del'];							// 사용자 삭제 권한
$set_comment = $set_use_chk['set_comment'];					// 사용자 댓글 쓰기 권한
$set_reply = $set_use_chk['set_reply'];						// 사용자 답글 쓰기 권한
$set_recom = $set_use_chk['set_recom'];						// 사용자 추천 권한
$set_secret = $set_use_chk['set_secret'];					// 사용자 비밀글 쓰기 권한
$set_secret_view = $set_use_chk['set_secret_view'];			// 사용자 비밀글 보기 권한	
$set_file = $set_use_chk['set_file'];						// 사용자 첨부파일 사용 권한
$set_down = $set_use_chk['set_down'];						// 사용자 첨부파일 다운 권한
$set_scrap = $set_use_chk['set_scrap'];						// 사용자 스크랩 권한
$set_admin = $set_use_chk['set_admin'];						// 사용자 관리자기능(조회수 날짜 변경) 권한
if($set_access != "Y") {
	alertback("접근 권한이 없습니다.");
}


// 게시판 각종 권한을 가져온다.
$board_obj  =  new Board_set($bo_num);
$board_info = $board_obj->board_info();						// 게시판 세부 정보 가져오기 
$bo_name = $board_info['bo_name'];
$bo_set_use = $board_info['set_use'];						// 게시판 사용 여부	
$bo_set_show = $board_info['set_show'];						// 게시판 리스트 갯수
$bo_set_title_length = $board_info['set_title_length'];		// 게시판 리스트 길이
$board_skin = $board_info['bo_skin'];						// 해당 게시판의 사용스킨
$head_title = $board_info['head_title'];					// 게시판 말머리
$end_title = $board_info['end_title'];						// 게시판 꼬리글
$bo_state = $board_info['bo_state'];						// 게시판 cs 유형
$bo_list_state = $board_info['bo_list_state'];				// 게시판 리스트 유형
$bo_set_reply = $board_info['set_reply'];					// 게시판 기능중이 답글기능 여부 체크	
$bo_set_file = $board_info['set_file'];						// 게시판 파일첨부 사용 여부
$bo_set_file_max = $board_info['set_file_max'];				// 게시판 파일첨부 최대용량
$bo_set_comment = $board_info['set_comment'];				// 게시판 댓글 사용 여부
$bo_set_recom = $board_info['set_recom'];					// 추천기능 사용여부
$bo_set_secret = $board_info['set_secret'];					// 비밀글 사용여부
$bo_set_img = $board_info['set_img'];						// 리스트 이미지 사용여부	
$bo_list_mal = $board_info['list_mal'];						// 리스트 말머리	
if($bo_set_use != "Y") {
	alertback("사용하지 않는 게시판 입니다.");
}
if (!$bo_set_show) {
	$bo_set_show = 10;
}



if ($mode == "board_list") {																																					// 리스트 보기

	$num_per_page = $bo_set_show;
	$num_per_block = 20;
	$first = $num_per_page * ($list_page - 1);
	$limit = "limit $first, $num_per_page";

	$obj    =    new Board_cnt($bo_num,$set_cs,$set_cate,$set_goods,$list_notice_chk,$guin_state,$key,$searchword,$bo_state);
	$list_obj    =    new Board_list($bo_num,$set_cs,$set_cate,$set_goods,$list_notice_chk,$guin_state,$key,$searchword,$bo_state);
	$query_number	=	$obj->list_query_number("N");

	if ($query_number > 0) {
		$list_obj->limit_chk($limit);
		$list_query = $list_obj->board_list_array("N");			//리스트 가져오기
	}
	

	$notice_query_number	=	$obj->list_query_number("Y");	//공지 가져오기
	if ($notice_query_number > 0) {
		$notice_list_query = $list_obj->board_list_array("Y");
	}

} else if ($mode == "board_view") {																																				// 글 보기

	$view_my_chk	= View_My_Chk($set_view,$list_num,$member_id);
	if ($view_my_chk == "N") {
		alertback("게시물 보기 권한이 없습니다.");
	}

	$obj_view	= new Board_view($bo_num,$set_cs,$set_cate,$set_goods,$list_notice_chk,$guin_state,$key,$searchword,$bo_state);	
	$con_rs		= $obj_view->view_info($list_num);	//해당 글 정보 가져오기

	if ($con_rs == false) {
		alertback("삭제되었거나 존재하지 않는 게시물 입니다.");
	}

	if ($con_rs['secret_chk'] == "Y") {	//해당 글이 비밀글일때
		if ($con_rs['mb_id'] == "GUEST") {		// 비회원 글일때
			$guest_pwd = $_POST['guest_pwd'];
			if ($set_secret_view != "Y") {
				//비밀번호 필요
				if (!$guest_pwd) {
					alert("비밀번호를 입력해 주세요.");
				} else {
					$guest_pwd = md5(md5($guest_pwd));
					$chk_query = mysqli_query($CONN['rosemary'],"select list_num from board_list where list_num = '$list_num' and mb_password = '$guest_pwd'");
					$chk_nums = @mysqli_num_rows($chk_query);
					if (!$chk_nums) {
						alertback("비밀번호가 일치하지 않습니다.");
					}
				}
				

			}
		} else {
			if ($con_rs['mb_id'] != $member_id) {
				if ($set_secret_view != "Y") {
					alertback("해당 글은 비밀글 입니다.");
				}
			}
		}

	}

	$comment_rs = $obj_view->comment($list_num);		//댓글정보 가져오기
	$comment_cnt = $obj_view->comment_cnt($list_num);		//댓글정보 가져오기

	if ($con_rs['file_chk'] == "Y") {
		$file_rs = $obj_view->view_file($list_num);		// 첨부파일 정보 가져오기
	} else {
		$file_rs = "";
	}

	$next_rs = $obj_view->next_list($list_num,">",1,"order by list_num asc");	// 다음목록 하나를 가져옴
	$yester_rs = $obj_view->next_list($list_num,"<",1,"order by list_num desc");	// 이전목록 하나를 가져옴
	
	$board_name = $bo_name; 


	$title				 = $con_rs['title'];		// 제목
	$bbs_mb_id			 = $con_rs['mb_id'];		// 유저네임
	$mb_name			 = $con_rs['mb_name'];		// 유저네임
	$hit_cnt			 = $con_rs['hit_cnt'];		// 조회수
	$recom_cnt			 = $con_rs['recom_cnt'];		// 조회수
	$reg_date			 = date("Y-m-d H:i:s",$con_rs['reg_date']);	//등록날짜
	$file_chk			 = $con_rs['file_chk'];		// 첨부파일 체크
	$secret_chk			 = 	$con_rs['secret_chk'];	// 비밀글 체크	
	$con				 = $con_rs['con'];			// 내용
	$cg_code_name		 = $con_rs['cg_code_name'];			// cs 
	$cg_cate_name		 = $con_rs['cg_cate_name'];			// ls
	$goods_name			 = $con_rs['goods_name'];			// 선택한 상품명
	$list_state			 = $con_rs['list_state'];			// 말머리


	$member_type_name = Member_Type_Name($mb_type);	// 멤버 타입에 맞는 유형명 가져오기


	// 해당 글이 자신의 글인지 체크한다.
	if ($con_rs['mb_id'] == $member_id) {
		$in_board_chk = "Y";
	}else{
		$in_board_chk = "";
	}

	// 비밀글인지 권한이 있는지 체크
	if ($secret_chk == "Y") {
		if ($set_secret_view != "Y") {
			// 보기 권한이 없다고 해도 자신의 글이라면 볼 수 있어야한다.
			if ($in_board_chk != "Y") {
				alertback("비밀글을 볼 수 있는 권한이 없습니다.");
			}
		}
	}
	$notice_chk = $con_rs['notice_chk'];	//공지체크
	if ($notice_chk == "Y") {
		$notice_mun = "[공지]";
	}else{
		$notice_mun = "";
	}

} else if ($mode == "board_write") {																																							//글쓰기
		

	if ($write_mode == "modi") {																																								//수정시

		$set_admin_chk = $set_admin;
		if($set_modi != "Y"){
			// 자신의 글은 권한이 없다 하더라도 수정할 수 있다.
			$list_chk_query = mysqli_query($CONN['rosemary'],"select * from board_list where list_num = '$list_num' and mb_id = '$member_id'");
			$list_chk_nums = mysqli_num_rows($list_chk_query);
			if(!$list_chk_nums) {
				alertback("수정 권한이 없습니다.");
			}
		}

		$obj_view    =    new Board_view($bo_num,$set_cs,$set_cate,$set_goods,$list_notice_chk,$guin_state,$key,$searchword,$bo_state);
		$con_rs = $obj_view->view_info($list_num);
		if ($con_rs == false) {
			alertback("삭제되었거나 존재하지 않는 게시물 입니다.");
		}

		$seq = $con_rs['seq'];							// 계층형 게시물 글 순서
		$ref = $con_rs['ref'];							// 답글 깊이
		$dep = $con_rs['dep'];							// 답글 순서

		$title		= $con_rs['title'];					// 제목
		$user_name	= $con_rs['mb_name'];				// 작성자 이름
		$mb_password	= $con_rs['mb_password'];		// 작성자 비밀번호(비회원용)
		$content	= $con_rs['con'];					// 내용
		$file_chk	= $con_rs['file_chk'];				// 파일첨부 여부
		$hit		= $con_rs['hit'];					// 조회수
		$cg_code	= $con_rs['cg_code'];				// cs 코드
		$ca_num		= $con_rs['ca_num'];				// 카테고리
		$lt_num		= $con_rs['lt_num'];				// 상품번호
		$secret_chk		= $con_rs['secret_chk'];		// 비밀글 여부
		$list_state			 = $con_rs['list_state'];			// 말머리
		if (!$hit) {
			$hit = 0;
		}
		$reg_date = date("Y-m-d H:i:s",$con_rs['reg_date']);	// 등록날짜


		if ($file_chk == "Y") {
			$file_rs = $obj_view->view_file($list_num);		// 첨부파일 정보 가져오기
		} else {
			$file_rs = "";
		}


	} else if ($write_mode == "reply"){																																						// 답글달때

		if ($set_reply != "Y") {
			alertback("게시물 답글 작성 권한이 없습니다.");
		}

		$obj_view    =    new Board_view($bo_num,$set_cs,$set_cate,$set_goods,$list_notice_chk,$guin_state,$key,$searchword,$bo_state);
		$con_rs = $obj_view->view_info($list_num);
		if ($con_rs == false) {
			alertback("삭제되었거나 존재하지 않는 게시물 입니다.");
		}
	
		$seq = $con_rs['seq'];	// 계층형 게시물 글 순서
		$ref = $con_rs['ref'];	// 답글 깊이
		$dep = $con_rs['dep'];  // 답글 순서

	} else {
		if ($set_write != "Y") {
			alertback("게시물 작성 권한이 없습니다.");
		}
	}
}




$param = "bo_num=$bo_num&key=$key&searchword=$encode_searchword&list_page=$list_page";

?>