<?php
   class Board{
        
        //클래스 멤버 변수 
        var $bo_num;
		var $set_cs;
		var $set_cate;
		var $set_goods;
		var $list_notice_chk;
		var $guin_state;
		var $key;
		var $searchword;
		var $bo_state;

        function __construct($bo_num,$set_cs,$set_cate,$set_goods,$list_notice_chk,$guin_state,$key,$searchword,$bo_state){

			$this->bo_num = $bo_num;
			$this->set_cs = $set_cs;
			$this->set_cate = $set_cate;
			$this->set_goods = $set_goods;
			$this->list_notice_chk = $list_notice_chk;
			$this->guin_state = $guin_state;
			$this->key = $key;
			$this->searchword = $searchword;
			$this->bo_state = $bo_state;

            $this->set_board();
        }
		



		function set_board(){
			global $CONN;

			$where = "";
			if (!empty($this->set_cs)) {
				$where .= "and cg_code = '".$this->set_cs."'";
			}
			if (!empty($this->set_cate)) {
				$where .= "and ca_num = '".$this->set_cate."'";
			}
			if (!empty($this->set_goods)) {
				$where .= "and lt_num = '".$this->set_goods."'";
			}
			if (!empty($this->list_notice_chk)) {
				$where .= "and notice_chk = '".$this->list_notice_chk."'";
			}
			if (!empty($this->guin_state)) {
				$where .= "and list_state = '".$this->guin_state."'";
			}			

			$search_where = "";
			if ($this->key == "tot") {
				$search_where = "and a.title like '%".$this->searchword."%' and b.contents like '%".$this->searchword."%'";
			} else if ($this->key == "title") {
				$search_where = " and ".$this->key." like '%".$this->searchword."%'";
			} else if ($this->key == "con") {
				$search_where = " and b.contents like '%".$this->searchword."%'";
			} else if ($this->key == "mb_id") {
				$search_where = " and ".$this->key." like '%".$this->searchword."%'";
			}

			$this->where = $search_where.$where;
		}
    }


	class Board_cnt extends Board {			//해당 리스트 총 갯수 가져오기

		
		 public function list_query_number($val){

			global $CONN;


			$where = $this->where;
			$bo_num = $this->bo_num;
			$key = $this->key;
			if ($key == "tot" || $key == "con") {
				$bbs_list_query = mysqli_query($CONN['rosemary'],"select count(*) as cnt from board_list a, board_contents b where a.bo_num = '$bo_num' and a.list_num = b.list_num and a.notice_show = '$val' and notice_chk = '$val' $where ");
			} else {
				$bbs_list_query = mysqli_query($CONN['rosemary'],"select count(*) as cnt from board_list where bo_num = '$bo_num' and notice_show = '$val' and notice_chk = '$val' $where ");
			}

			$this->query_cnt = mysqli_result($bbs_list_query,0,0);
			return $this->query_cnt;
		 }
	}



	class Board_list extends Board {	// 리스트 가져오기

		function limit_chk($val){

				$this->limit = $val;
		}	

		public function board_list_array($val){

			global $MY_URL,$CONN;
			$limit = $this->limit;
			$bo_num = $this->bo_num;

			$bo_state = $this->bo_state;
			$where = $this->where;
			$key = $this->key;


			$bo_info = Board_Info($bo_num,"bo_skin"); //게시판 스킨을 가져옴
			$bo_skin = $bo_info['bo_skin'];

			if ($bo_state == "C" || $bo_state == "G" || $bo_state == "D" || $bo_state == "CD") {
				$cg_code_query = ", (select cg_name from category_group b where b.cg_code = a.cg_code) as cg_code_name";
				$cg_cate_query = ", (select ca_name from category c where c.ca_num = a.ca_num) as cg_cate_name";
				$goods_query = ", (select lt_name from goods_lecture d where d.lt_num = a.lt_num) as goods_name";
			}


			if ($key == "tot" || $key == "con") {
				$list_query = mysqli_query($CONN['rosemary'],"select 
												a.* 
												$cg_code_query
												$cg_cate_query
												$goods_query	
										from 
												board_list a, board_contents b 
										where 
												a.bo_num = '$bo_num' and a.list_num = b.list_num and notice_show = '$val' $where   order by a.seq desc,a.dep asc $limit");
			} else {
				$list_query = mysqli_query($CONN['rosemary'],"select 
												a.*
												$cg_code_query
												$cg_cate_query
												$goods_query
										 from  
												board_list a
										  where 
												bo_num = '$bo_num' and notice_show = '$val' $where  order by seq desc,dep asc $limit");


			}
			if (!$list_query) {
				return false;
			} else {
				$loop = array();
				$list_cnt = 0;
				while($bbs_list_rs = mysqli_fetch_array($list_query)){
	
					$bbs_list_rs['comment_cnt']	= number_format($bbs_list_rs['comment_cnt']);	// 댓글수
					$bbs_list_rs['hit_cnt']		= number_format($bbs_list_rs['hit_cnt']);		// 조회수
					$bbs_list_rs['recom_cnt']		= number_format($bbs_list_rs['recom_cnt']);		// 추천수
					$bbs_list_rs['reg_date']		= date("Y-m-d H:i:s",$bbs_list_rs['reg_date']);		// 등록날짜
					$notice_chk		= $bbs_list_rs['notice_chk'];
					$secret_chk		= $bbs_list_rs['secret_chk'];

					if ($notice_chk == "Y") {
						$bbs_list_rs['notice_mun']  = "[공지]";
					} else {
						$bbs_list_rs['notice_mun']  = "";
					}
					
					if ($secret_chk == "Y") {
						$bbs_list_rs['secret_mun'] =  "[비밀글]";
					} else {
						$bbs_list_rs['secret_mun'] =  "";
					}	
					$deps = "";
					if ($bbs_list_rs['ref'] > 0) {
					   for($k = 0 ; $k < $bbs_list_rs['ref']; $k++){
						  $deps .=  "&nbsp;&nbsp;";  
					   }
						$deps .= "<img src='".$MY_URL."_template/skin/board/$bo_skin/images/board/ico_re.gif' align='absmiddle'/> ";
					}
					$bbs_list_rs['deps'] = $deps;


					$loop[] = $bbs_list_rs;
				}
				return $loop;
			}
		}
	}

	class Board_view extends Board {			//해당 리스트 상세보기

		 public function view_info($list_num){

			global $CONN;

			$bo_num = $this->bo_num;
			
			if ($this->con_rs) {
				$file_chk = $con_rs['file_chk'];
				$this->file_chk = $file_chk;
				$con_rs = $this->con_rs;
				return $con_rs;
			} else {
				$con_query = mysqli_query($CONN['rosemary'],"select 
												a.mb_id,a.title,a.mb_name,a.hit_cnt,a.reg_date,a.file_chk,a.notice_chk,a.secret_chk,a.seq,a.ref,a.dep,a.recom_cnt,a.secret_chk,a.list_state,
												b.contents as con,
												(select cg_name from category_group c where c.cg_code = a.cg_code) as cg_code_name,
												(select ca_name from category c where c.ca_num = a.ca_num) as cg_cate_name,
												(select lt_name from goods_lecture d where d.lt_num = a.lt_num) as goods_name
										  from 
												board_list a, 
												board_contents b 
										  where 
												a.list_num = '$list_num' and 
												a.bo_num = '$bo_num' and 
												a.list_num = b.list_num");

		
				
				$con_nums = mysqli_num_rows($con_query);
				if (!$con_nums) {
					return false;
				} else {
					$con_rs = mysqli_fetch_array($con_query);
					$file_chk = $con_rs['file_chk'];
					$this->file_chk = $file_chk;
					$this->con_rs = $con_rs;
					return $con_rs;
				}
			}
		 }


		 function view_file($list_num){
			 global $CONN;

			 
			 $file_query = mysqli_query($CONN['rosemary'],"select * from board_file where list_num = '$list_num'");
			 $file_nums = mysqli_num_rows($file_query);
			 if ($file_nums) {
				$loop = array();
				while($file_rs = mysqli_fetch_array($file_query)){
					$loop[] = $file_rs;
				}

				return $loop;
			 } else {
				return false;
			 }
		 }

		 function comment($list_num){
			global $CONN;
			 
			 $comment_query = mysqli_query($CONN['rosemary'],"select * from board_comment where list_num = '$list_num'  order by comment_num desc");
			 $comment_nums = mysqli_num_rows($comment_query);
			 if ($comment_nums) {
				$this->comment_cnt = $comment_nums;
				$loop = array();
				while($comment_rs = mysqli_fetch_array($comment_query)){
					$comment_rs['reg_date'] = date("Y-m-d h:i:s",$comment_rs['reg_date']);	//댓글 작성일
					$loop[] = $comment_rs;
				}

				return $loop;
			 } else {
				return false;
			 }
		 }

		 function comment_cnt($list_num){
			 
				if (!$this->comment_cnt) {
					 $this->comment($list_num);
					 return $this->comment_cnt;
				} else {
					 return $this->comment_cnt;
				}
		 }		



		function next_list($list_num,$set,$number=1,$order){
					
		
				global $CONN;

				$bo_num = $this->bo_num;
				$q = mysqli_query($CONN['rosemary'],"select * from board_list where list_num $set '$list_num' and bo_num = '$bo_num' $order limit $number");
				$n = mysqli_num_rows($q);
				if (!$n) {
					return false;
				} else {
					$loop = array();
					while($r = mysqli_fetch_array($q)){
						$r['reg_date']		= date("Y-m-d",$r['reg_date']);		// 등록날짜
						$loop[] = $r;
					}
					return $loop;
				}
		}
	}


	class Board_set {	

		var $bo_num;

		function __construct($bo_num){

			$this->bo_num = $bo_num;
			$this->board_info();	
		}		

		function board_info(){
			$bo_num =  $this->bo_num;
			if ($this->board_info) {
				return $this->board_info;
			} else {
				$val = Board_Info($bo_num,"*"); //게시판 정보를 가져온다.
				$this->board_info = $val;
				return $val;
			}
		}

		function board_feild($val){

			global $CONN;
			$bo_num = $this->bo_num;


			if (!$this->$val) {
				if ($this->board_info) {
					$this->$val = $this->board_info[$val]; 
					return $this->$val;
				} else {
					$info = $this->board_info();
					$this->$val = $info[$val]; 
					return $this->$val;
				}
			} else {
				return $this->$val;
			}
		}

	}

?>