<?php
$option_query = mysqli_query($CONN['rosemary'],"select GROUP_CONCAT(CONCAT_WS('<>',so_key,so_val)) as val from site_option");
$option_nums = mysqli_num_rows($option_query);
if ($option_nums > 0) {
	$option_rs = mysqli_fetch_array($option_query);

	$array = explode(",",$option_rs['val']);
	for($i=0; $i<count($array); $i++) {
		$val_array = explode("<>",$array[$i]);
		$key = $val_array[0];
		$val = $val_array[1];

		$option_rs[$key] = $val;
	}

}
?>

<script type = "text/javascript">
	function send_go()
	{
		// 체크 박스에 체크를 하지 않으면 아무런 값도 넘어가지 않기 때문에 빈 텍스트 박스에 해당 체크박스 이름과 값을 넘겨서 받아야함.
		var f = document.pg_form;
		var analytics_n_use_chk =document.getElementById("analytics_n_use_chk");
		var analytics_g_use_chk =document.getElementById("analytics_g_use_chk");


		if (f.analytics_n_use.checked != true) {
			analytics_n_use_chk.value = "N";
			analytics_n_use_chk.name = "analytics_n_use";
		} 

		if(f.analytics_g_use.checked != true) {
			analytics_g_use_chk.value = "N";
			analytics_g_use_chk.name = "analytics_g_use";
		}
		f.submit();
	}
</script>


<div class="divtitle">
기타 옵션
</div>
<br />
<form name="pg_form" method="post" action="./process/pg_process.php">
<input type="hidden" name="mode" id="mode" value="etc">
<input type="hidden" id="analytics_n_use_chk">
<input type="hidden" id="analytics_g_use_chk">

<table class="optiontable">
	<caption>스킨</caption>
	<tr>
		<td class="title">회원가입/로그인 스킨</td>
		<td><select name="skin_member">
				<?php
		        // 스킨목록			        			   
		        $dirList = getDirList($DOCUMENT_ROOT.'/_template/skin/member');
		        
		        for ($i=0; $i<count($dirList); $i++) {
		        	if($dirList[$i] == $option_rs['skin_member']) {
		            	echo "<option value='$dirList[$i]' selected='selected'>$dirList[$i]</option>\n";
		        	} else {
		        		echo "<option value='$dirList[$i]'>$dirList[$i]</option>\n";
		        	}
		        }
		        ?>
			</select></td>
	</tr>
	<tr>
		<td class="title">교수소개 스킨</td>
		<td><select name="skin_te">
				<?php
		        // 스킨목록			        			   
		        $dirList = getDirList($DOCUMENT_ROOT.'/_template/skin/teacher');
		        
		        for ($i=0; $i<count($dirList); $i++) {
		        	if($dirList[$i] == $option_rs['skin_te']) {
		            	echo "<option value='$dirList[$i]' selected='selected'>$dirList[$i]</option>\n";
		        	} else {
		        		echo "<option value='$dirList[$i]'>$dirList[$i]</option>\n";
		        	}
		        }
		        ?>
			</select></td>
	</tr>
	<tr>
		<td class="title">강의실 스킨</td>
		<td><select name="skin_class">
				<?php
		        // 스킨목록			        			   
		        $dirList = getDirList($DOCUMENT_ROOT.'/_template/skin/class');
		        
		        for ($i=0; $i<count($dirList); $i++) {
		        	if($dirList[$i] == $option_rs['skin_class']) {
		            	echo "<option value='$dirList[$i]' selected='selected'>$dirList[$i]</option>\n";
		        	} else {
		        		echo "<option value='$dirList[$i]'>$dirList[$i]</option>\n";
		        	}
		        }
		        ?>
			</select></td>
	</tr>
	<tr>
		<td class="title">패키지 스킨</td>
		<td><select name="skin_package">
				<?php
		        // 스킨목록			        			   
		        $dirList = getDirList($DOCUMENT_ROOT.'/_template/skin/package');
		        
		        for ($i=0; $i<count($dirList); $i++) {
		        	if($dirList[$i] == $option_rs['skin_package']) {
		            	echo "<option value='$dirList[$i]' selected='selected'>$dirList[$i]</option>\n";
		        	} else {
		        		echo "<option value='$dirList[$i]'>$dirList[$i]</option>\n";
		        	}
		        }
		        ?>
			</select></td>
	</tr>
	<tr>
		<td class="title">교재구매 스킨</td>
		<td><select name="skin_book">
				<?php
		        // 스킨목록			        			   
		        $dirList = getDirList($DOCUMENT_ROOT.'/_template/skin/book');
		        
		        for ($i=0; $i<count($dirList); $i++) {
		        	if($dirList[$i] == $option_rs['skin_book']) {
		            	echo "<option value='$dirList[$i]' selected='selected'>$dirList[$i]</option>\n";
		        	} else {
		        		echo "<option value='$dirList[$i]'>$dirList[$i]</option>\n";
		        	}
		        }
		        ?>
			</select></td>
	</tr>	
	<tr>
		<td class="title">자주하는질문(FAQ) 스킨</td>
		<td><select name="skin_faq">
				<?php
		        // 스킨목록			        			   
		        $dirList = getDirList($DOCUMENT_ROOT.'/_template/skin/faq');
		        
		        for ($i=0; $i<count($dirList); $i++) {
		        	if($dirList[$i] == $option_rs['skin_faq']) {
		            	echo "<option value='$dirList[$i]' selected='selected'>$dirList[$i]</option>\n";
		        	} else {
		        		echo "<option value='$dirList[$i]'>$dirList[$i]</option>\n";
		        	}
		        }
		        ?>
			</select></td>
	</tr>
	<tr>
		<td class="title">1:1문의(Q&A) 스킨</td>
		<td><select name="skin_qna">
				<?php
		        // 스킨목록			        			   
		        $dirList = getDirList($DOCUMENT_ROOT.'/_template/skin/qna');
		        
		        for ($i=0; $i<count($dirList); $i++) {
		        	if($dirList[$i] == $option_rs['skin_qna']) {
		            	echo "<option value='$dirList[$i]' selected='selected'>$dirList[$i]</option>\n";
		        	} else {
		        		echo "<option value='$dirList[$i]'>$dirList[$i]</option>\n";
		        	}
		        }
		        ?>
			</select></td>
	</tr>	
	<tr>
		<td class="title">기타 스킨(이용약관 등)</td>
		<td><select name="skin_etc">
				<?php
		        // 스킨목록			        			   
		        $dirList = getDirList($DOCUMENT_ROOT.'/_template/skin/etc');
		        
		        for ($i=0; $i<count($dirList); $i++) {
		        	if($dirList[$i] == $option_rs['skin_etc']) {
		            	echo "<option value='$dirList[$i]' selected='selected'>$dirList[$i]</option>\n";
		        	} else {
		        		echo "<option value='$dirList[$i]'>$dirList[$i]</option>\n";
		        	}
		        }
		        ?>
			</select></td>
	</tr>	
	<tr>
		<td class="title">기본 카테고리 그룹</td>
		<td>
			
			<select name = "default_cs_code">
<?php
	$cate_query = mysqli_query($CONN['rosemary'],"select cg_code,cg_name from category_group");
	$cate_cnt = mysqli_num_rows($cate_query);
	if ($cate_cnt > 0) {
		while($cate_rs = mysqli_fetch_array($cate_query)){
?>
				<option value="<?php echo $cate_rs['cg_code'];?>" <?if($cate_rs['cg_code'] == $option_rs['default_cs_code'] ){?>selected<?}?>><?php echo $cate_rs['cg_name'];?></option>
<?
		}
	} else {
?>
				<option>등록된 카테고리 그룹이 없습니다.</option>
<?php }?>
			</select> 
			
			(도메인만 입력했을 경우 접속되는 카테고리 그룹)</td>
	</tr>
</table>
<br />
<table class="optiontable">
	<caption>메일 서버</caption>
	<tr>
		<td class="title">SMTP 서버 주소</td>
		<td><input type="text" size="50" name="smtp_url" value="<?php echo $option_rs['smtp_url'];?>" /><br />
		메일 서버의 IP를 입력. 메일 서버가 따로 없다면 localhost를 입력.</td>
	</tr>
</table>
<br />
<table class="optiontable">
	<caption>수강 관련</caption>
	<tr>
		<td class="title">수강정지 가능횟수</td>
		<td><input type="text" size="2" name="class_stop_cnt" value="<?php echo $option_rs['class_stop_cnt'];?>" />번 (0으로 설정하면 수강정지 기능 사용할 수 없음)</td>
	</tr>
</table>
<br />
<table class="optiontable">
	<caption>배송비 관련</caption>
	<tr>
		<td class="title">배송비 기본 정책</td>
		<td>배송해야 할 상품이 있을 경우 주문 금액 <input type="text" name="delivery_limit" size="5" value="<?php echo $option_rs['delivery_limit'];?>" />원 미만은 
		배송비 <input type="text" name="delivery_fee" size="5" value="<?php echo $option_rs['delivery_fee'];?>" />원을 부과합니다.</td>
	</tr>
	<tr>
		<td class="title">예외 조항(동영상 강좌 포함시)</td>
		<td><select name="delivery_free_vod">
			<option value="N"<?php echoCompareString("N", $option_rs['delivery_free_vod'], " selected=\"selected\"")?>>없음</option>
			<option value="Y"<?php echoCompareString("Y", $option_rs['delivery_free_vod'], " selected=\"selected\"")?>>단, 주문서에 동영상 강좌가 포함되어 있으면 배송비는 무료입니다.</option>
		</select></td>
	</tr>
</table>
<br />
<table class="optiontable">
	<caption>접속 통계</caption>
	<tr>
		<td class="title">네이버 애널리틱스</td>
		<td>
			<table class="optiontable">
				<tr>
					<td class="title">사용여부</td>
					<td><label><input type="checkbox" value="Y" name="analytics_n_use" <?php if($option_rs['analytics_n_use']=="Y"){?>checked<?php }?> />사용</label><br /></td>
				</tr>
				<tr>
					<td class="title">서비스ID</td>
					<td><input type="text" name="analytics_n_id" value="<?php echo $option_rs['analytics_n_id'];?>" /> (네이버 로그인 아이디 아님. 서비스 신청하면 생기는 ID를 입력해야 함)</td>
				</tr>
				<tr>
					<td class="title">네이버 아이디</td>
					<td><input type="text" name="analytics_n_lo_id" value="<?php echo $option_rs['analytics_n_lo_id'];?>" /> (어떤 아이디로 서비스 신청했는지 메모하는 용도)</td>
				</tr>
			</table>
			네이버 애널리틱스 서비스 신청 및 서비스ID 생성 : <a href="http://analytics.naver.com" target="_blank">http://analytics.naver.com</a>		
		</td>
	</tr>
	<tr>
		<td class="title">구글 웹 로그분석</td>
		<td>
			<table class="optiontable">
				<tr>
					<td class="title">사용여부</td>
					<td><label><input type="checkbox" value="Y" name="analytics_g_use" <?php if($option_rs['analytics_g_use']=="Y"){?>checked<?php }?> />사용</label><br /></td>
				</tr>
				<tr>
					<td class="title">서비스ID</td>
					<td><input type="text" value="<?php echo $option_rs['analytics_g_id'];?>" name="analytics_g_id" /> (구글 로그인 아이디 아님. 서비스 신청하면 생기는 ID를 입력해야 함.)</td>
				</tr>
				<tr>
					<td class="title">구글 아이디</td>
					<td><input type="text" value="<?php echo $option_rs['analytics_g_lo_id'];?>" name="analytics_g_lo_id" /> (어떤 아이디로 서비스 신청했는지 메모하는 용도)</td>
				</tr>
			</table>
			구글 웹 로그분석 서비스 신청 및 서비스ID 생성 : <a href="http://www.google.com/analytics" target="_blank">http://www.google.com/analytics</a>		
		</td>
	</tr>
</table>
<br />	
<div class="divbutton">
<input type="button" value = "저장" onclick="send_go()">
</div>
</form>