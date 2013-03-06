<?php
$g_num = $_GET['g_num'];
$goods_query = mysqli_query($CONN['rosemary'],"select a.*,(select b.ca_name from category b where b.ca_num = a.ca_num) as ca_name from goods a where a.g_num = '$g_num'");
$goods_nums = mysqli_num_rows($goods_query);
if (!$goods_nums) {
	alertback("존재하지 않는 강좌입니다.");
}

$goods_rs = mysqli_fetch_array($goods_query);
$goods_name = $goods_rs['g_name'];		//강좌명



	$dan_chk = mysqli_query($CONN['rosemary'],"select a.*,(select mb_name from member where mb_num = a.mb_num) as mb_name from goods_lecture a where a.g_num = '$g_num'");
	$dan_cnt = mysqli_num_rows($dan_chk);


	$type_query =  mysqli_query($CONN['rosemary'],"select * from goods_lecture_subjects_ctype");
	$type_num = mysqli_num_rows($type_query);

	if ($type_num > 0) {
		while($type_rs = mysqli_fetch_array($type_query)){
			$lsct_code = $type_rs['lsct_code'];
			$lsct_name = $type_rs['lsct_name'];
			$type_option .= "<option value = $lsct_code>$lsct_name</option>";
		}
	} else {
			$type_option = "<option value = \'A\'>동영상</option>";
	}

?>


<style>
#mask {position:absolute;left:0;top:0;z-index:900;background-color:#000;display:none;}
#dialog {position:absolute;left:0;top:0;display:none;z-index:901;}
#dialog2 {position:absolute;left:0;top:0;display:none;z-index:901;}
</style> 
<script src="<?php echo $MY_URL;?>_js/jquery.min.js" type="text/javascript"></script>





<script type="text/javascript">

function microtime(get_as_float){ 
 var now = new Date().getTime() / 1000;
 var s = parseInt(now);
 return (get_as_float) ? now : (Math.round((now - s) * 1000) / 1000) + ' ' + s;
}
function send_gang()
{
	var f = document.sub_form;
	f.submit();
}
function send_movie()
{
	var f = document.sub_form2;
	f.submit();
}

$(document).ready(function() {
 $("#addDynamicInput").click(function(){
  var orderno = $("#dynamicInputArea").children().length;
  var uniqueID = Math.round(microtime(true)*100);
  var data = '텍스트 #' + orderno;
	var f = document.sub_form;
	if (!f.sel_form_num.value) {
		f.sel_form_num.value = orderno;
	} else {
		f.sel_form_num.value = f.sel_form_num.value +"<>"+ orderno;
	}
	var i = "";
//	for (i=0;i<5;i++) {
	$("#dynamicInputArea").append('<table><tr><td><table width="900" border="0" cellspacing="1" cellpadding="3" class="td" bgcolor="#999999" style="white-space:nowrap"><tr ><td bgcolor="#EFEFEF" align=center>강의명</td><td bgcolor="#FFFFFF" ><input type = "text" name = "subject_title_'+orderno+'"></td></tr><tr ><td bgcolor="#EFEFEF" align=center>강의유형</td><td bgcolor="#FFFFFF"><select name = "subject_type_'+orderno+'"><?=$type_option?></select></td></tr></table><input type="button" value="삭제" id="deleteDynamicInput' + uniqueID + '" class="deleteDynamicInput" /></td></tr></table>');
//	}
	

  $(".deleteDynamicInput").bind("click", function(){
	 
   $(this).parent().remove();
  });


 });



 $("#addDynamicInput2").click(function(){
  var orderno = $("#dynamicInputArea2").children().length;
  var movie_num = orderno + 1; 
  var uniqueID = Math.round(microtime(true)*100);
  var data = '텍스트 #' + orderno;

	var f = document.sub_form2;
	//var i = "";
	//for (i=0;i<5;i++) {
	//orderno++;
	if (!f.sel_form_num.value) {
		f.sel_form_num.value = orderno;
	} else {
		f.sel_form_num.value = f.sel_form_num.value +"<>"+ orderno;
	}


	$("#dynamicInputArea2").append('<table><tr><td><table width="900" border="0" cellspacing="1" cellpadding="3" class="td" bgcolor="#999999" style="white-space:nowrap"><tr ><td bgcolor="#EFEFEF" align=center width=200>차시번호</td><td bgcolor="#FFFFFF" ><input type = "text" name = "movie_num_'+orderno+'" value="'+movie_num+'" ></td><td bgcolor="#EFEFEF" align=center width=200>차시총길이</td><td bgcolor="#FFFFFF" ><input type = "text" name = "movie_len_'+orderno+'">분</td></tr><tr ><td bgcolor="#EFEFEF" align=center>차시명</td><td bgcolor="#FFFFFF" colspan=3><input type = "text" name = "movie_name_'+orderno+'" size=120></td></tr><tr ><td bgcolor="#EFEFEF" align=center>동영상주소</td><td bgcolor="#FFFFFF" colspan=3><input type = "text" name = "movie_url_'+orderno+'" size=120></td></tr></table><input type="button" value="삭제" id="deleteDynamicInput' + uniqueID + '" class="deleteDynamicInput" /></td></tr></table>');
	//}
	

  $(".deleteDynamicInput").bind("click", function(){
	 
   $(this).parent().remove();
  });


 });



 $(".deleteDynamicInput").bind("click", function(){

  $(this).parent().remove();
 });


 var initForm = {
  init : function(maxlength){
   for(var i = 0;i < maxlength;i++){
    $("#addDynamicInput").trigger("click");
   }
  }
 }
 initForm.init(0); //initForm.init(생성원하는 숫자 입력);
});
//]]>
</script>










<div id="mask" onclick="close_layer_window(); return false;"></div>  

<table width="100%" border="0" cellspacing="1" cellpadding="3" class="td" bgcolor="#999999" style="white-space:nowrap">
	<tr bgcolor="#EFEFEF" height=30>
		<td width=10%>
			강좌명
		</td>

		<td bgcolor="#FFFFFF" colspan=3>
			<?php echo $goods_name;?>
		</td>
	</tr>

	<tr bgcolor="#EFEFEF" height=30>
		<td width=10%>
			카테고리
		</td>

		<td bgcolor="#FFFFFF" width=40%>
			<?php echo $goods_rs['ca_name'];?>
		</td>
		<td  width=10%>
			강의할인
		</td>
		<td  width=40% bgcolor="#FFFFFF">
			<?php echo $goods_rs['g_discount_rate'];?>%
		</td>
	</tr>

	<tr bgcolor="#EFEFEF" height=30>
		<td width=10%>
			강의특전
		</td>

		<td bgcolor="#FFFFFF" colspan=3>
			<?php echo $goods_rs['g_benefit'];?>
		</td>
	</tr>
	<tr bgcolor="#EFEFEF" height=30>
		<td width=10%>
			강좌설명
		</td>
			
		<td bgcolor="#FFFFFF" colspan=3>
		<?php echo $goods_rs['g_explanation'];?>
		</td>
	</tr>

</table>
		
		<br>

<?
	if($dan_cnt){ 
		while($dan_rs = mysqli_fetch_array($dan_chk )){
			$lt_num = $dan_rs['lt_num']; 
			$dan_name = $dan_rs['lt_name']; 
			$dan_date = number_format($dan_rs['lt_term']); 
			$dan_price = number_format($dan_rs['lt_selling_price']); 
			$mb_name = $dan_rs['mb_name']; 
?>

<table width="100%" border="0" cellspacing="1" cellpadding="3" class="td" bgcolor="#999999" style="white-space:nowrap">
	<tr bgcolor="#EFEFEF" height=30>
		<td width=20% align=center>
			단과명
		</td>
		<td bgcolor="#EFEFEF" align=center>
			세부속성
		</td>
	</tr>

	<tr bgcolor="#FFFFFF" height=30>
		<td width=20% align=center>
			<?php echo $dan_name;?>
		</td>
		<td bgcolor="#FFFFFF" >
			<table width="100%" border="0" cellspacing="1" cellpadding="3" class="td" bgcolor="#999999" style="white-space:nowrap">
			<tr >
				<td bgcolor="#EFEFEF" align=center width=20%>담당교수</td>
				<td bgcolor="#FFFFFF" colspan=3><?php echo $mb_name;?></td>
			</tr>
			<tr >
				<td bgcolor="#EFEFEF" align=center>가격</td>
				<td bgcolor="#FFFFFF"><?php echo $dan_price;?>원</td>
				<td bgcolor="#EFEFEF" align=center width=10%>기간</td>
				<td bgcolor="#FFFFFF"><?php echo $dan_date;?>일</td>
			</tr>

			<tr >
				<td bgcolor="#EFEFEF" align=center>강의정보 
<input type = "button" value = "강의 추가" onclick="modal_window('<?php echo $dan_name;?>','<?php echo $lt_num?>');">			
				</td>
				<td bgcolor="#FFFFFF" colspan=3>
							<table width="100%" border="0" cellspacing="1" cellpadding="3" class="td" bgcolor="#999999" style="white-space:nowrap">
							
<?php
	$subject_query = mysqli_query($CONN['rosemary'],"select a.*,(select lsct_name from goods_lecture_subjects_ctype where lsct_code = a.lsct_code) as lsct_name from goods_lecture_subjects a where a.lt_num = '$lt_num'");		
	$subject_nums = mysqli_num_rows($subject_query);
	if ($subject_nums) {
		while($subject_rs = mysqli_fetch_array($subject_query)){
			$subject_num = $subject_rs['lts_num'];
			$subject_name = $subject_rs['lts_name'];
			$lsct_name = $subject_rs['lsct_name'];		//강의유형
?>
							<tr>
								<td bgcolor="#EFEFEF" align=center width=20% height=40>강의명</td>
								<td bgcolor="#FFFFFF"><?php echo $subject_name;?></td>
								<td bgcolor="#EFEFEF" align=center width=10%>강의유형</td>
								<td bgcolor="#FFFFFF"><?php echo $lsct_name;?></td>
							</tr>
							<tr >
								<td bgcolor="#EFEFEF" align=center>차시 <input type = "button" value = "차시 추가" onclick="modal_window2('<?php echo $subject_num?>');"></td>
								<td bgcolor="#FFFFFF" colspan=3>
									<table width="100%" border="0" cellspacing="1" cellpadding="3" class="td" bgcolor="#999999" style="white-space:nowrap">
<?php
			$movie_query = mysqli_query($CONN['rosemary'],"select * from goods_lecture_subjects_period where lts_num = '$subject_num' order by ltsp_period_num asc");	
			$movie_nums = mysqli_num_rows($movie_query);
			if ($movie_nums) {
				while($movie_rs = mysqli_fetch_array($movie_query)){
					$movie_name = $movie_rs['ltsp_name'];
					$movie_len = $movie_rs['ltsp_time_length'];
					$movie_num = $movie_rs['ltsp_period_num'];
					$movie_url = $movie_rs['ltsp_url'];
				
?>
										<tr bgcolor="#EFEFEF">
											<td align=center>차시순서</td>
											<td bgcolor="#FFFFFF"><?php echo $movie_num;?></td>
											<td align=center>차시길이 </td>
											<td bgcolor="#FFFFFF"><?php echo $movie_len;?>분</td>
										</tr>
										<tr bgcolor="#EFEFEF">
											<td align=center>차시명</td>
											<td bgcolor="#FFFFFF" colspan=3><?php echo $movie_name;?></td>
										</tr>
										<tr bgcolor="#EFEFEF">
											<td>차시주소</td>
											<td bgcolor="#FFFFFF" colspan=3><?php echo $movie_url?></td>
										</tr>
<?php
				}
			} else {
?>
										<tr bgcolor="#EFEFEF">
											<td>등록된 차시가 없습니다. <input type = "button" value = "차시 추가" onclick="modal_window2('<?php echo $subject_num?>');">	</td>
										</tr>
<?php }?>
									</table>
								</td>
							</tr>
<?php
		}
	} else {	
?>
							<tr bgcolor="#FFFFFF">
								<td>
									등록된 강의가 없습니다. <input type = "button" value = "강의 추가" onclick="modal_window('<?php echo $dan_name;?>','<?php echo $lt_num?>');">
								</td>
							</tr>
						
<?}?>

							
							</table>	

				</td>
			</tr>
			</table>
		</td>
	</tr>
</table>
<br>
<?}}?>
<br>










<div id="dialog">

<form name  = "sub_form" method="post" action = "./process/goods_reg.php" autocomplete="off">
<input type = "hidden" name = "mode" value = "subject_reg">
<input type = "hidden" name = "g_type" value = "<?php echo $goods_rs['g_type']?>">
<input type = "hidden" name = "dan_num" >
<input type = "hidden" name = "g_num" value = "<?php echo $g_num?>">
<input type = "hidden" name = "sel_form_num">

<table width="900" border="0" cellspacing="1" cellpadding="3" class="td" bgcolor="#999999" style="white-space:nowrap">
	<tr bgcolor="#EFEFEF" height=30>
		<td width=20%>
			강의 등록하기 <input type="button" value="추가" id="addDynamicInput" />	
		</td>
	</tr>

	<tr bgcolor="#FFFFFF" height=30>

		<td colspan=2 id="dynamicInputArea">



<table>
<tr>
<td>

			<table width="900" border="0" cellspacing="1" cellpadding="3" class="td" bgcolor="#999999" style="white-space:nowrap">
			<tr >
				<td bgcolor="#EFEFEF" align=center>강의명</td>
				<td bgcolor="#FFFFFF" ><input type = "text" name = "subject_title_0"></td>
			
			</tr>
			<tr >
				<td bgcolor="#EFEFEF" align=center>강의유형</td>
				<td bgcolor="#FFFFFF"><select name = "subject_type_0"><?=$type_option?></select></td>
			</tr>
			</table>

</td>
</tr>
</table>

		</td>

	</tr>
	<tr bgcolor="#FFFFFF" height = "50" >
		<td align = "center" width=33% colspan=4><input type = "button" value = "작성취소" onclick="close_layer_window(); return false;">
		<input type='button'  value='강의등록하기' onclick="send_gang()">&nbsp;
		</td>
	</tr>	
</table>

</form>


</div>



<!--차시 테이블-->
<div id="dialog2">
<form name  = "sub_form2" method="post" action = "./process/goods_reg.php" autocomplete="off">
<input type = "hidden" name = "g_num" value = "<?php echo $g_num?>">
<input type = "hidden" name = "mode" value = "movie_reg">
<input type = "hidden" name = "sub_num" >
<input type = "hidden" name = "sel_form_num">

<table width="900" border="0" cellspacing="1" cellpadding="3" class="td" bgcolor="#999999" style="white-space:nowrap">
	<tr bgcolor="#EFEFEF" height=30>
		<td width=20%>
			차시 등록하기 <input type="button" value="추가" id="addDynamicInput2" />	
		</td>
	</tr>

	<tr bgcolor="#FFFFFF" height=30>

		<td colspan=2 id="dynamicInputArea2">



<table>
<tr>
<td>

			<table width="900" border="0" cellspacing="1" cellpadding="3" class="td" bgcolor="#999999" style="white-space:nowrap">
			<tr >
				<td bgcolor="#EFEFEF" align=center width=200>차시번호</td>
				<td bgcolor="#FFFFFF" ><input type = "text" name = "movie_num_0" value="1"></td>
					<td bgcolor="#EFEFEF" align=center width=200>차시총길이</td>
				<td bgcolor="#FFFFFF" ><input type = "text" name = "movie_len_0">분</td>		
			</tr>
			<tr >
				<td bgcolor="#EFEFEF" align=center>차시명</td>
				<td bgcolor="#FFFFFF" colspan=3><input type = "text" name = "movie_name_0" size=120></td>
			</tr>
			<tr >
				<td bgcolor="#EFEFEF" align=center>동영상주소</td>
				<td bgcolor="#FFFFFF" colspan=3><input type = "text" name = "movie_url_0" size=120></td>
			</tr>
			</table>

</td>
</tr>
</table>

		</td>

	</tr>
	<tr bgcolor="#FFFFFF" height = "50" >
		<td align = "center" width=33% colspan=4><input type = "button" value = "작성취소" onclick="close_layer_window(); return false;">
		<input type='button'  value='차시등록하기' onclick="send_movie()">&nbsp;
		</td>
	</tr>	
</table>

</form>
</div>




<script type = "text/javascript">

// 창 리사이즈할때 마다 갱신
	$(window).resize(function () { 
		if(is_mask_run){        modal_window();   
		}
	});	


//마스크 배경 클릭시 창 닫기
	$('#mask').click(function (){  
		$(this).hide();    $('#dialog').hide();     is_mask_run =false;
	}); 

/*레이어 윈도우창 닫기*/
	function close_layer_window(){ 
		$('#mask').hide();   
		$('#dialog').hide();    
		$('#dialog2').hide();  
		is_mask_run= false;
	}


function modal_window(name,val){    
	// 활성화 

	is_mask_run = true;
	// 마스크 사이즈  
	var maskHeight = $(document).height();
	var maskWidth = $(window).width();
	$('#mask').css({'width':maskWidth,'height':maskHeight}); 
	// 마스크 effect   
	$('#mask').fadeTo("slow",0.8); 
	// 윈도우 화면 사이즈 구하기    
	var winH = $(window).height();
	var winW = $(window).width();
	// 스크롤 높이 구하기    
	var _y =(window.pageYOffset) ? window.pageYOffset
	: (document.documentElement && document.documentElement.scrollTop) ? document.documentElement.scrollTop
	: (document.body) ? document.body.scrollTop  
	: 0;   
	
	if(_y<1){ 
		var h = winH/2;   
	}else{ 
		var h = winH/2+_y; 
	}
	
	var f = document.sub_form;

	f.dan_num.value = val;

	//var set_img =  document.getElementById("set_img");
	//set_img.src = img;
	// dialog창 리사이즈  
	var dial_width =$('#dialog').width(); 
	var dial_height = $('#dialog').height();  
	$('#dialog').css({'width':dial_width,'height':dial_height}); 
	//$('#dialog').css('top', h-dial_height/1);  
	$('#dialog').css('top', 100);  
	$('#dialog').css('left', winW/2-dial_width/2);  
	// dialog창  effect  
	$('#dialog').fadeIn(2000);
	}




function modal_window2(val){    
	// 활성화 

	is_mask_run = true;
	// 마스크 사이즈  
	var maskHeight = $(document).height();
	var maskWidth = $(window).width();
	$('#mask').css({'width':maskWidth,'height':maskHeight}); 
	// 마스크 effect   
	$('#mask').fadeTo("slow",0.8); 
	// 윈도우 화면 사이즈 구하기    
	var winH = $(window).height();
	var winW = $(window).width();
	// 스크롤 높이 구하기    
	var _y =(window.pageYOffset) ? window.pageYOffset
	: (document.documentElement && document.documentElement.scrollTop) ? document.documentElement.scrollTop
	: (document.body) ? document.body.scrollTop  
	: 0;   
	
	if(_y<1){ 
		var h = winH/2;   
	}else{ 
		var h = winH/2+_y; 
	}
	
	var f = document.sub_form2;

	f.sub_num.value = val;

	// dialog창 리사이즈  
	var dial_width =$('#dialog2').width(); 
	var dial_height = $('#dialog2').height();  
	$('#dialog2').css({'width':dial_width,'height':dial_height}); 
	//$('#dialog').css('top', h-dial_height/1);  
	$('#dialog2').css('top', 100);  
	$('#dialog2').css('left', winW/2-dial_width/2);  
	// dialog창  effect  
	$('#dialog2').fadeIn(2000);
	}


</script>