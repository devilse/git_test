<?php
$notice_query_number	=	$obj->list_query_number("Y");

if ($notice_query_number) {

	$notice_list_query = $list_obj->board_list_array("Y");

	for ($i=0;$i<count($notice_list_query);$i++) {
		if ($board_info['set_title_length'] < 9) {						// 기본길이가 10 보다 작을땐 기본 길이 30으로 책정 해놈
			$board_info['set_title_length'] = 30;
		}
		$list_num		= $notice_list_query[$i]['list_num'];
		$title			 = mb_strimwidth($notice_list_query[$i]['title'], 0, $board_info['set_title_length'], "...", "UTF-8");	// 제목
		$user_id		= $notice_list_query[$i]['mb_id'];						// 유저아이디	
		$user_name		= $notice_list_query[$i]['mb_name'];						// 유저네임
		$comment_cnt	= $notice_list_query[$i]['comment_cnt'];	// 댓글수
		$list_hit		= $notice_list_query[$i]['hit_cnt'];		// 조회수
		$recom_cnt		= $notice_list_query[$i]['recom_cnt'];		// 추천수
		$user_ip		= $notice_list_query[$i]['user_ip'];						// 유저아이피
		$reg_date		= $notice_list_query[$i]['reg_date'];		// 등록날짜
		$ref			= $notice_list_query[$i]['ref'];							// 답글 깊이
		$del_chk		= $notice_list_query[$i]['del_chk'];						// 삭제 체크 여부 - 해당 부분으 Y면 삭제된 게시물임. 리스트엔 삭제된 게시물이라고 표기됨	
		$notice_chk		= $notice_list_query[$i]['notice_chk'];					// 공지사항 체크
		$secret_chk		= $notice_list_query[$i]['secret_chk'];					// 비밀글 체크	
		$cg_code		= $notice_list_query[$i]['cg_code'];						// cs 코드
		$cg_code_name	= $notice_list_query[$i]['cg_code_name'];					// cs 이름	
		$cg_cate_name	= $notice_list_query[$i]['cg_cate_name'];					// 카테고리 이름
		$goods_name		= $notice_list_query[$i]['goods_name'];					// 상품 이름	
		$notice_show	= $notice_list_query[$i]['notice_show'];					// 공지글을 상단에 노출할건지 (Y,N)
?>

	<tr bgcolor="#FFFFFF"> 
	  <td align=center> 
		<b>공  지</b>
	  </td>
	  <td align=center width=5% style="white-space:nowrap"> 
<?php if ($notice_chk == "Y") {?>
		<input type  = "checkbox" <?php if ($notice_show == "Y") {?> onclick="chk_notice('N','<?php echo $list_num;?>')"  checked<?php } else { ?> onclick="chk_notice('Y','<?php echo $list_num;?>')" <?php } ?>> 
<?php }  ?>
	  </td>
<?php
	if($bo_state != "A"){
?>
	  <td align=center width=5%> 
		<?=$cg_code_name?>
	  </td>
	  <td align=center width=5%> 
		<?=$cg_cate_name?>
	  </td>
<?php if ($bo_state == "CD" || $bo_state == "D") {?>

	  <td align=center width=5%> 
		<?=$goods_name?>
	  </td>

<?php } else if ($bo_state == "G") { ?>
	  <td align=center width=8% style="white-space:nowrap"> 
					구인
	  </td>
<?php } ?>


<?php } ?>
	  <td align=left style="white-space:nowrap"> 
<?php
	 if ($ref > 0 ) {  //공백출력
	   for($k = 0 ; $k < $ref; $k++){
		  echo "&nbsp&nbsp&nbsp";  
		  echo "ㄴ";
	   }
	 }
?>		
		
		<?if($del_chk == "Y"){?>
			삭제된 게시물 입니다.
		<?}else{?>
			<a href="./index.php?mode=board_view&list_num=<?php echo $list_num;?>&<?php echo $param;?>">
			<?php echo $notice_mun;?> <?php echo $secret_mun;?> <?php echo $title;?>
			</a>
		<?}?>
	  </td>
	  <td align=center> 
		<?php echo $user_id;?>
	  </td>
	  <td align=center> 
		<?php echo $user_name;?>
	  </td>
	  <td align=center> 
	    <?php echo $comment_cnt;?>
	  </td>
	  <td align=center> 
		<?php echo $recom_cnt;?>
	  </td>
	  <td align=center> 
		<?php echo $list_hit;?>
	  </td>
	  <td align=center> 
		<?php echo $reg_date;?>
	  </td>
	</tr>

<?php 
	}
?>

	<tr bgcolor="#FFFFFF"> 
	  <td align=center colspan=12>
	  </td>
	</tr>	
<?php
}
?>

  <br><br>	