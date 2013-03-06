<?php
$g_num = $_GET['g_num'];
$goods_query = mysqli_query($CONN['rosemary'],"select a.*,(select b.ca_name from category b where b.ca_num = a.ca_num) as ca_name from goods a where a.g_num = '$g_num'");
$goods_nums = mysqli_num_rows($goods_query);
if (!$goods_nums) {
	alertback("존재하지 않는 강좌입니다.");
}

$goods_rs = mysqli_fetch_array($goods_query);
$goods_name = $goods_rs['g_name'];		//강좌명
$g_type = $goods_rs['g_type'];		//강좌명


	$dan_chk = mysqli_query($CONN['rosemary'],"select a.*  from goods_lecture a where a.g_num = '$g_num'");
	$dan_cnt = mysqli_num_rows($dan_chk);


	$te_query =  mysqli_query($CONN['rosemary'],"select * from member where mt_code = 'T'");
	$te_num = mysqli_num_rows($te_query);

	if ($te_num > 0) {
		while($te_rs = mysqli_fetch_array($te_query)){
			$te_name = $te_rs['mb_name'];
			$te_num = $te_rs['mb_num'];
			$te_option .= "<option value = $te_num>$te_name</option>";
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
?>


<style>
#mask {position:absolute;left:0;top:0;z-index:900;background-color:#000;display:none;}
#dialog {position:absolute;left:0;top:0;display:none;z-index:901;}
</style> 
<script src="<?php echo $MY_URL;?>_js/jquery.min.js" type="text/javascript"></script>





<script type="text/javascript">

	function fnNumberCheck(obj) 
	{
		if (/[^0-9,]/g.test(obj.value))  
		{
			var text1 = obj.value.substring(0, obj.value.length - 1);
			alert("숫자만 입력 가능 합니다.");
			obj.focus();
			obj.value = text1;
			return false;
		}
	}

	function microtime(get_as_float){ 
	 var now = new Date().getTime() / 1000;
	 var s = parseInt(now);
	 return (get_as_float) ? now : (Math.round((now - s) * 1000) / 1000) + ' ' + s;
	}
	function send_gang()
	{
		var f = document.dan_form;
		var set_from = document.getElementById('sel_form_num').value;
		var result = set_from.split('<>');
		var end_for = result.length;
		//alert(result[0]);
		for (i =  0; i < end_for + 1; i++) {
			if (!result[i]) {
				result[i] = '0';
			}
			var aa = document.getElementById('file_list2_'+result[i]);

			if (aa != null) {
				
					var books = new Array();
				
					for (j =  0; j < aa.length; j++) {
						if(aa[j].value != "none"){
							books[j] = aa[j].value;			
						}
					}
					Books_val = books.join("<>");
					
					var set_select = document.getElementById('set_select_'+result[i]);
					set_select.value = Books_val;
			}
			
			
		}


		f.submit();
	}


	$(document).ready(function() {
	 $("#addDynamicInput").click(function(){
	  var orderno = $("#dynamicInputArea").children().length;
	  var uniqueID = Math.round(microtime(true)*100);
	  var data = '텍스트 #' + orderno;
		var f = document.dan_form;
		if (!f.sel_form_num.value) {
			f.sel_form_num.value = orderno;
		} else {
			f.sel_form_num.value = f.sel_form_num.value +"<>"+ orderno;
		}
		

		$("#dynamicInputArea").append('<table cellspacing="0" cellpadding="3"><tr><td><table width="900" border="0" cellspacing="1" cellpadding="3" class="td" bgcolor="#999999" style="white-space:nowrap"><tr bgcolor="#FFFFFF"><td width=30% align=center>단과명 : <input type = "text" name = "dan_name_'+orderno+'" ><input type = "hidden" name  = "set_select_'+orderno+'" id = "set_select_'+orderno+'"></td><td bgcolor="#FFFFFF" ><table width="100%" border="0" cellspacing="1" cellpadding="3" class="td" bgcolor="#999999" style="white-space:nowrap"><tr ><td bgcolor="#EFEFEF" align=center>담당교수</td><td bgcolor="#FFFFFF"><select name = "te_sel_'+orderno+'"><?=$te_option?></select></td><td bgcolor="#EFEFEF" align=center>교재</td><td bgcolor="#FFFFFF"><select name="file_list_'+orderno+'"  id="file_list_'+orderno+'" size="7" style="width:535; height:90; background-color=#FFFFFF;" multiple class="formtype" ondblclick="chk_select(this.value,\'file_list_'+orderno+'\',\'file_list2_'+orderno+'\')"><option value="none" >========선택하세요=======</option><?=$book_option?></select> <select name="file_list2_'+orderno+'" id="file_list2_'+orderno+'" size="7" style="width:535; height:90; background-color=#FFFFFF;" multiple class="formtype" ondblclick="chk_select(this.value,\'file_list2_'+orderno+'\',\'file_list_'+orderno+'\')"><option value="none">========선택된 교재=======</option></select></td></tr><tr ><td bgcolor="#EFEFEF" align=center>기간</td><td bgcolor="#FFFFFF"><input type = "text" name = "dan_date_'+orderno+'" OnKeyUp="fnNumberCheck(this);">일</td><td bgcolor="#EFEFEF" align=center>가격</td><td bgcolor="#FFFFFF"><input type = "text" name = "dan_price_'+orderno+'" OnKeyUp="fnNumberCheck(this);">원</td></tr></table></td></tr></table><input type="button" value="삭제" id="deleteDynamicInput' + uniqueID + '" class="deleteDynamicInput" /></td></tr></table>');



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




	function chk_select(val,f,f2)
	{	
		if (val == "none") {
			alert("교재를 선택하세요.");
			return;
		}

		var form = document.dan_form;
		var chk_list =document.getElementById(f);
		var value=val.split('|');

		var deleted = 0;
		// 폴더가 선택되었는지 체크
		var sel_chk = 0;	//한번에 몇개씩 체크를 했는지 체크
		for (i = chk_list.length - 1; i > 0; i--) {
			if (chk_list.options[i].selected == true) {
				
				info = chk_list[i].value.split("||");
				if (info[1] == "-1") { 
					for (j = 1; j < chk_list.length; j++) {
						if (chk_list[j].text.indexOf(chk_list[i].text) >= 0) {
							chk_list.options[j].selected = true;
						}
					}
				}
				sel_chk++;
			}
		}
	
		if (sel_chk > 1) {
			alert("하나씩 선택해 주세요.");
			return;
		}

		for (i = chk_list.length - 1; i > 0; i--) {
			if (chk_list.options[i].selected == true) {
				for (j = i; j < chk_list.length-1; j++) {
					chk_list[j].value = chk_list[j+1].value;
					chk_list[j].text = chk_list[j+1].text;
				}
	 
				deleted++;
			}
		}
		var szName = value[1];
		var szNum = value[0];


		insertNewRow(szName,szNum,f,f2);
		chk_list.length -= deleted;
	}



	function insertNewRow(f_value,f_num,f,f2)
	{
		var obj = document.getElementById(f2);;
		var val = f_num+"|"+f_value;
		var chk_list = 0;
		for (j =  0; j < obj.length; j++) {
			if(obj[j].value == val){
				chk_list++;						
			}
		}
		if(chk_list > 0){
			alert("이미 선택한 파일 입니다.");
		}else{
			obj.options[obj.options.length] = new Option(f_value,val, false, true);
		}
	}
</script>






<div id="mask" onclick="close_layer_window(); return false;"></div>  

<table width="100%" border="0" cellspacing="1" cellpadding="3" class="td" bgcolor="#999999" style="white-space:nowrap">
	<tr bgcolor="#EFEFEF" height=30>
		<td width=10% align=center>
			강좌명
		</td>

		<td bgcolor="#FFFFFF" colspan=3>
			<?php echo $goods_name;?>
		</td>
	</tr>

	<tr bgcolor="#EFEFEF" height=30 align=center>
		<td width=10%>
			카테고리
		</td>

		<td bgcolor="#FFFFFF" width=40% align=left>
			<?php echo $goods_rs['ca_name'];?>
		</td>

<?php
	if ($g_type == "C") {
?>
		<td  width=10% align=center>
			강의할인
		</td>
		<td  width=40% bgcolor="#FFFFFF" align=left>
			<?php echo $goods_rs['g_discount_rate'];?>%
		</td>
<?php }?>
	</tr>

	<tr bgcolor="#EFEFEF" height=30>
		<td width=10% align=center>
			강의특전
		</td>

		<td bgcolor="#FFFFFF" colspan=3>
			<?php echo $goods_rs['g_benefit'];?>
		</td>
	</tr>
	<tr bgcolor="#EFEFEF" height=30>
		<td width=10% align=center>
			강좌설명
		</td>
			
		<td bgcolor="#FFFFFF" colspan=3>
		<?php echo $goods_rs['g_explanation'];?>
		</td>
	</tr>

</table>
		
		<br>
<?php
	if ($g_type == "C") {	
?>
					<div align=center>

						 <input type = "button" value = "단과 등록하기" onclick="modal_window();">
					</div>




<div id="dialog">

<form name  = "dan_form" method="post" action = "./process/goods_reg.php" autocomplete="off">
<input type = "hidden" name = "mode" value = "dan_reg">
<input type = "hidden" name = "g_type" value = "<?php echo $goods_rs['g_type']?>">
<input type = "hidden" name = "g_num" value = "<?php echo $g_num?>">
<input type = "hidden" name = "sel_form_num" id = "sel_form_num">
<table width="900" border="0" cellspacing="1" cellpadding="3" class="td" bgcolor="#999999" style="white-space:nowrap">
	<tr bgcolor="#EFEFEF" height=30>
		<td width=20%>
			단과 등록하기 <input type="button" value="추가" id="addDynamicInput" />	
		</td>
	</tr>

	<tr bgcolor="#FFFFFF" height=30>

		<td colspan=2 id="dynamicInputArea">



<table>
<tr>
<td>

<table width="900" border="0" cellspacing="1" cellpadding="3" class="td" bgcolor="#999999" style="white-space:nowrap">
	<tr bgcolor="#FFFFFF">

		<td width=30% align=center>단과명 : <input type = "text" name = "dan_name_0"><input type = "hidden" name  = "set_select_0" id = "set_select_0"></td>
				
		<td bgcolor="#FFFFFF" >
			<table width="100%" border="0" cellspacing="1" cellpadding="3" class="td" bgcolor="#999999" style="white-space:nowrap">
			<tr >
				<td bgcolor="#EFEFEF" align=center>담당교수</td>
				<td bgcolor="#FFFFFF"><select name = "te_sel_0"><?=$te_option?></select></td>
				<td bgcolor="#EFEFEF" align=center>교재</td>
				<td bgcolor="#FFFFFF">
					<select name="file_list_0"  id="file_list_0" size="7" style="width:535; height:90; background-color=#FFFFFF;" multiple class="formtype" ondblclick="chk_select(this.value,'file_list_0','file_list2_0')">
						<option value="none" >========선택하세요=======</option>
						<?=$book_option?>
					</select>	
														
					<select name="file_list2_0" id="file_list2_0" size="7" style="width:535; height:90; background-color=#FFFFFF;" multiple class="formtype" ondblclick="chk_select(this.value,'file_list2_0','file_list_0')">
						<option value="none">========선택된 교재=======</option>
					</select>
				</td>			
			</tr>
			<tr >
				<td bgcolor="#EFEFEF" align=center>기간</td>
				<td bgcolor="#FFFFFF"><input type = "text" name = "dan_date_0" OnKeyUp="fnNumberCheck(this);">일</td>
				<td bgcolor="#EFEFEF" align=center>가격</td>
				<td bgcolor="#FFFFFF"><input type = "text" name = "dan_price_0" OnKeyUp="fnNumberCheck(this);">원</td>
			</tr>
			</table>
		</td>
	</tr>
</table>

</td>
</tr>
</table>

		</td>

	</tr>
	<tr bgcolor="#FFFFFF" height = "50" >
		<td align = "center" width=33% colspan=4><input type = "button" value = "작성취소" onclick="close_layer_window(); return false;">
		<input type='button'  value='단과/강좌구성하기' onclick="send_gang()">&nbsp;
		</td>
	</tr>	
</table>

</form>


</div>



<?php } else {	// A,B타입일때?>




<form name  = "dan_form" method="post" action = "./process/goods_reg.php" autocomplete="off">
<input type = "hidden" name = "mode" value = "dan_reg">
<input type = "hidden" name = "g_type" value = "<?php echo $goods_rs['g_type']?>">
<input type = "hidden" name = "g_num" value = "<?php echo $g_num?>">
<input type = "hidden" name = "sel_form_num" id = "sel_form_num">
<input type = "hidden" name = "dan_name_0" size=80 readOnly value = "<?php echo $goods_name;?>">
<table width="100%" border="0" cellspacing="1" cellpadding="3" class="td" bgcolor="#999999" style="white-space:nowrap">
	<tr bgcolor="#EFEFEF" height=30>
		<td width=20% align= center>
			강좌 세부설정 
		</td>
	</tr>

	<tr bgcolor="#FFFFFF" height=30>

		<td colspan=2 >

				<table width="100%" border="0" cellspacing="1" cellpadding="3" class="td" bgcolor="#999999" style="white-space:nowrap">
					<tr bgcolor="#FFFFFF">

						<td width=30% align=center> <?php echo $goods_name;?><input type = "hidden" name  = "set_select_0" id = "set_select_0"> </td>
								
						<td bgcolor="#FFFFFF" >
							<table width="100%" border="0" cellspacing="1" cellpadding="3" class="td" bgcolor="#999999" style="white-space:nowrap">
							<tr >
								<td bgcolor="#EFEFEF" align=center>담당교수</td>
								<td bgcolor="#FFFFFF" ><select name = "te_sel_0"><?=$te_option?></select></td>
								<td bgcolor="#EFEFEF" align=center>교재</td>
								<td bgcolor="#FFFFFF" >


<select name="file_list_0"  id="file_list_0" size="7" style="width:535; height:90; background-color=#FFFFFF;" multiple class="formtype" ondblclick="chk_select(this.value,'file_list_0','file_list2_0')">
	<option value="none" >========선택하세요=======</option>
	<?=$book_option?>
</select>	
									
<select name="file_list2_0" id="file_list2_0" size="7" style="width:535; height:90; background-color=#FFFFFF;" multiple class="formtype" ondblclick="chk_select(this.value,'file_list2_0','file_list_0')">
	<option value="none">========선택된 교재=======</option>
</select>

								
								</td>							
							</tr>
							<tr >
								<td bgcolor="#EFEFEF" align=center>기간</td>
								<td bgcolor="#FFFFFF"><input type = "text" name = "dan_date_0">일</td>
								<td bgcolor="#EFEFEF" align=center>가격</td>
								<td bgcolor="#FFFFFF"><input type = "text" name = "dan_price_0">원</td>
							</tr>
							</table>
						</td>
					</tr>
				</table>


		</td>

	</tr>

	<tr bgcolor="#FFFFFF" height = "50" >
		<td align = "center" width=33% colspan=4><input type = "button" value = "작성취소" onclick="close_layer_window(); return false;">
		<input type='button'  value='단과/강좌구성하기' onclick="send_gang()">&nbsp;
		</td>
	</tr>	
</table>




</form>
<?php }?>
<br>










<script type = "text/javascript">


//마스크 배경 클릭시 창 닫기
	$('#mask').click(function (){  
		$(this).hide();    $('#dialog').hide();     is_mask_run =false;
	}); 

/*레이어 윈도우창 닫기*/
	function close_layer_window(){ 
		$('#mask').hide();   
		$('#dialog').hide();    
		is_mask_run= false;
	}


function modal_window(val){    
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
	
	//var f = document.writeform;

	//f.g_type.value = val;

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
</script>