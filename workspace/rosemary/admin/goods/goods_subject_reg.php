<?php
$g_num = $_GET['g_num'];
$key = $_GET['key'];
$searchword = $_GET['searchword'];
$set_g_state = $_GET['set_g_state'];
$sel_type = $_GET['sel_type'];
$ca_num = $_GET['ca_num'];
$cg_code = $_GET['cg_code'];

$goods_query = mysqli_query($CONN['rosemary'],"select a.*,(select b.ca_name from category b where b.ca_num = a.ca_num) as ca_name from goods a where a.g_num = '$g_num'");
$goods_nums = mysqli_num_rows($goods_query);
if (!$goods_nums) {
	alertback("존재하지 않는 강좌입니다.");
}

$goods_rs = mysqli_fetch_array($goods_query);
$goods_name = $goods_rs['g_name'];		//강좌명
$cg_code = $goods_rs['cg_code'];		//강좌명
$ca_num = $goods_rs['ca_num'];		//강좌명
$content = $goods_rs['g_explanation'];
$g_state = $goods_rs['g_state'];
$g_type = $goods_rs['g_type'];

	$dan_chk = mysqli_query($CONN['rosemary'],"select a.*,(select mb_name from member where mb_num = a.mb_num) as mb_name from goods_lecture a where a.g_num = '$g_num'");
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
			$book_option = "<option>등록된 교재가 없습니다.</option>";
	}


	

?>


<style>
#mask {position:absolute;left:0;top:0;z-index:900;background-color:#000;display:none;}
#dialog {position:absolute;left:0;top:0;display:none;z-index:901;}
#dialog2 {position:absolute;left:0;top:0;display:none;z-index:901;}
#dialog3 {position:absolute;left:0;top:0;display:none;z-index:901;}
#dialog4 {position:absolute;left:0;top:0;display:none;z-index:901;}
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
		var f = document.sub_form;
		f.submit();
	}
	function send_dan()
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
		//강의추가
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
//	for (i=0;i<5;i++) {
	orderno++;
	if (!f.sel_form_num.value) {
		f.sel_form_num.value = orderno;
	} else {
		f.sel_form_num.value = f.sel_form_num.value +"<>"+ orderno;
	}

	//차시추가
	$("#dynamicInputArea2").append('<table cellspacing="0" cellpadding="0"><tr><td><table width="900" border="0" cellspacing="1" cellpadding="3" class="td" bgcolor="#999999" style="white-space:nowrap"><tr ><td bgcolor="#EFEFEF" align=center width=200>차시번호</td><td bgcolor="#FFFFFF" ><input type = "text" name = "movie_num_'+orderno+'" value="'+movie_num+'" OnKeyUp="fnNumberCheck(this);"></td><td bgcolor="#EFEFEF" align=center width=200>차시총길이</td><td bgcolor="#FFFFFF" ><input type = "text" name = "movie_len_'+orderno+'" OnKeyUp="fnNumberCheck(this);">초</td><td bgcolor="#EFEFEF" align=center width=200>맛보기</td><td bgcolor="#FFFFFF" ><input type  = "checkbox" name = "movie_sample_'+orderno+'" value = "Y"></td></tr><tr ><td bgcolor="#EFEFEF" align=center>차시명</td><td bgcolor="#FFFFFF" colspan=5><input type = "text" name = "movie_name_'+orderno+'" size=160></td></tr><tr ><td bgcolor="#EFEFEF" align=center>동영상주소</td><td bgcolor="#FFFFFF" colspan=5><input type = "text" name = "movie_url_'+orderno+'" size=160 ></td></tr></table><input type="button" value="삭제" id="deleteDynamicInput' + uniqueID + '" class="deleteDynamicInput" /></td></tr></table>');
//	}
	
  $(".deleteDynamicInput").bind("click", function(){
	 
   $(this).parent().remove();
  });


 });

 $("#addDynamicInput3").click(function(){
  var orderno = $("#dynamicInputArea3").children().length;
  var uniqueID = Math.round(microtime(true)*100);
  var data = '텍스트 #' + orderno;
	var f = document.dan_form;
	if (!f.sel_form_num.value) {
		f.sel_form_num.value = orderno;
	} else {
		f.sel_form_num.value = f.sel_form_num.value +"<>"+ orderno;
	}
	
	//단과추가
	$("#dynamicInputArea3").append('<table cellspacing="0" cellpadding="0"><tr><td><table width="900" border="0" cellspacing="1" cellpadding="3" class="td" bgcolor="#999999" style="white-space:nowrap"><tr bgcolor="#FFFFFF"><td width=30% align=center>단과명 : <input type = "text" name = "dan_name_'+orderno+'" ><input type = "hidden" name  = "set_select_'+orderno+'" id = "set_select_'+orderno+'"></td><td bgcolor="#FFFFFF" ><table width="100%" border="0" cellspacing="1" cellpadding="3" class="td" bgcolor="#999999" style="white-space:nowrap"><tr ><td bgcolor="#EFEFEF" align=center>담당교수</td><td bgcolor="#FFFFFF"><select name = "te_sel_'+orderno+'"><?=$te_option?></select></td><td bgcolor="#EFEFEF" align=center>교재</td><td bgcolor="#FFFFFF"><select name="file_list_'+orderno+'"  id="file_list_'+orderno+'" size="7" style="width:535; height:90; background-color=#FFFFFF;" multiple class="formtype" ondblclick="chk_select(this.value,\'file_list_'+orderno+'\',\'file_list2_'+orderno+'\')"><option value="none" >========선택하세요=======</option><?=$book_option?></select><select name="file_list2_'+orderno+'" id="file_list2_'+orderno+'" size="7" style="width:535; height:90; background-color=#FFFFFF;" multiple class="formtype" ondblclick="chk_select(this.value,\'file_list2_'+orderno+'\',\'file_list_'+orderno+'\')"><option value="none">========선택된 교재=======</option></select></td></tr><tr ><td bgcolor="#EFEFEF" align=center>기간</td><td bgcolor="#FFFFFF"><input type = "text" name = "dan_date_'+orderno+'" OnKeyUp="fnNumberCheck(this);">일</td><td bgcolor="#EFEFEF" align=center>가격</td><td bgcolor="#FFFFFF"><input type = "text" name = "dan_price_'+orderno+'" OnKeyUp="fnNumberCheck(this);">원</td></tr></table></td></tr></table><input type="button" value="삭제" id="deleteDynamicInput' + uniqueID + '" class="deleteDynamicInput" /></td></tr></table>');



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


	function cs_cate_set(val,mode){
		if (mode == "category") {
			var category_value=document.getElementById('ca_num').value;
			var f = document.writeform;
			f.set_category_num.value = category_value;
			return;
		}
		var f = document.cate_set_form;
		f.mode.value = mode;
		f.set_number.value = val;
		$.ajax({
			type : "POST" 
			, async : true 
			, url : "<?php echo $board_process_url;?>/cate_change_set.php" 
			, dataType : "html" 
			, timeout : 30000 
			, cache : false  
			, data : $("#cate_set_form").serialize() 
			, contentType: "application/x-www-form-urlencoded; charset=UTF-8"
			, error : function(request, status, error) {
				 alert("ajax 통신서버에 접속할 수 업습니다.");
			}
			, success : function(response, status, request) {
				var result=response.split('|');	
				if (result[0] != "T") {
					alert(result[1]);
				} else {
					if (f.mode.value == "cs") {
						var div_layer=document.getElementById('cate_gubun');
						div_layer.innerHTML=result[1];	
					
					} 
				}
			}

		});
	}


	function modi_goods(){
		if (confirm("강좌 상세 내용을 변경 하시겠습니까?")) {
			var f = document.writeform;
			var check_memo = f.content.value = SubmitHTML();
			var g_state_len = f.g_state.length;
			for(i=0;i<g_state_len;i++) {
				if (f.g_state[i].checked == true) {
					f.sel_g_state.value = f.g_state[i].value;
				}
			}

			 if(!f.g_name.value) {
				alert("강좌명을 입력해 주세요.");
				f.g_name.focus();
				return false;
			} else if(f.set_category_num.value == "") {
				alert("카테고리를 선택해 주세요.");
				return false;
			} else {
				f.submit();
			}	
		}
	}



	function goods_subject_modi_change(num,feild,val){

		var f = document.modi_form;
		if (feild == "lts_name") {
			var val =document.getElementById(num+"_lts_name").value;
			f.feild.value = feild;
			f.num.value = num;
			f.val.value = val;
			f.mode.value = "subject";
		} else if (feild == "lsct_code") {
			f.feild.value = feild;
			f.num.value = num;
			f.val.value = val;
			f.mode.value = "subject";
		}

		$.ajax({
			type : "POST" 
			, async : true 
			, url : "./process/goods_modi.php" 
			, dataType : "html" 
			, timeout : 30000 
			, cache : false  
			, data : $("#modi_form").serialize() 
			, contentType: "application/x-www-form-urlencoded; charset=UTF-8"
			, error : function(request, status, error) {
				 alert("ajax 통신서버에 접속할 수 업습니다.");
			}
			, success : function(response, status, request) {
				var result=response.split('|');
				if (f.feild.value == "lsct_code") {
					document.getElementById('lsct_span_'+num).innerHTML = result[1];
				} else {
					alert(result[1]);
					if (feild == "lts_name") {
						var gang_button =document.getElementById(num+"_gang_button");
						gang_button.value = result[2]+" 강의삭제";
					} 
				}
					
			}
		});
	}
	function goods_period_modi_change(num,feild,val){
		var f = document.modi_form;
		if (feild == "ltsp_name") {
			var val =document.getElementById(num+"_ltsp_name").value;
		} else if (feild == "ltsp_url") {
			var val =document.getElementById(num+"_ltsp_url").value;
		} else if (feild == "ltsp_time_length"){
			var val =document.getElementById(num+"_ltsp_time_length").value;
		} else if (feild == "ltsp_period_num") {
			var val =document.getElementById(num+"_ltsp_period_num").value;
		} else {
			return;
		}

			f.feild.value = feild;
			f.num.value = num;
			f.val.value = val;
			f.mode.value = "period";


		$.ajax({
			type : "POST" 
			, async : true 
			, url : "./process/goods_modi.php" 
			, dataType : "html" 
			, timeout : 30000 
			, cache : false  
			, data : $("#modi_form").serialize() 
			, contentType: "application/x-www-form-urlencoded; charset=UTF-8"
			, error : function(request, status, error) {
				 alert("ajax 통신서버에 접속할 수 업습니다.");
			}
			, success : function(response, status, request) {
				var result=response.split('|');
					alert(result[1]);
			}
		});
	}

	function del_send(mode,num){
		var f = document.del_form;
		if (mode == "period") {
			var msg = "해당 차시를 삭제 하시겠습니까?";
		} else if (mode == "subject") {
			var msg = "해당 강의를 삭제 하시겠습니까?";
		} else if (mode == "dan") {
			var msg = "해당 단과를 삭제 하시겠습니까?";
		} else if (mode == "gang") {
			var msg = "해당 강좌를 삭제 하시겠습니까?";
		}

		if (confirm(msg)) {
			f.mode.value = mode;
			f.num.value = num;
			f.action = "./process/goods_del.php";
			f.submit();
		}


	}

	function send_list(){
		var f = document.list_form;
		f.action = "./index.php";
		f.submit();
	}

	function chk_select(val,f,f2)
	{	


		if (val == "none") {
			alert("교재를 선택하세요.");
			return;
		}

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
			//alert("이미 선택한 파일 입니다.");
		}else{
			obj.options[obj.options.length] = new Option(f_value,val, false, true);
		}
	}
	function modi_movie(num){
	//	var f = eval("movie_form_"+num);
		$.ajax({
			type : "POST" 
			, async : true 
			, url : "./process/goods_modi.php" 
			, dataType : "html" 
			, timeout : 30000 
			, cache : false  
			, data : $("#movie_form_"+num).serialize() 
			, contentType: "application/x-www-form-urlencoded; charset=UTF-8"
			, error : function(request, status, error) {
				 alert("ajax 통신서버에 접속할 수 업습니다.");
			}
			, success : function(response, status, request) {
				var result=response.split('|');	
				if (result[0] != "T") {
					alert(result[1]);
				} else {
					alert("차시 정보가 변경 되었습니다.");
				}
			}

		});
	}

	function send_dan_modi(){
		//var f = document.dan_modi_form;


		var aa = document.getElementById('modi_list2_0');

		if (aa != null) {
			
					var books = new Array();

					for (j =  0; j < aa.length; j++) {
						if(aa[j].value != "none"){
							//alert(aa[j].value);
							books[j] = aa[j].value;		
						}
					}
					Books_val = books.join("<>");
					
					var set_select = document.getElementById('modi_set_select');
					set_select.value = Books_val;
		}

		$.ajax({
			type : "POST" 
			, async : true 
			, url : "./process/goods_modi.php" 
			, dataType : "html" 
			, timeout : 30000 
			, cache : false  
			, data : $("#dan_modi_form").serialize() 
			, contentType: "application/x-www-form-urlencoded; charset=UTF-8"
			, error : function(request, status, error) {
				 alert("ajax 통신서버에 접속할 수 업습니다.");
			}
			, success : function(response, status, request) {
				var result=response.split('|');	
				if (result[0] != 'T') {
				} else {
					var f = document.dan_modi_form;
					var lt_num = f.lt_num.value;
					var lt_name = f.lt_name.value;
					//var te_name = f.mb_num.value;
					var te_name = result[2];
					
					var price = f.lt_selling_price.value;
					var lt_term = f.lt_term.value;
					//alert(lt_num);

					var dan_button =document.getElementById(lt_num+"_dan_button");
					var dan_name =document.getElementById(lt_num+"_danname");
					var te_span =document.getElementById(lt_num+"_te_span");
					var price_span =document.getElementById(lt_num+"_price");
					var date_span =document.getElementById(lt_num+"_date");

					dan_button.value = lt_name+" 단과 삭제";
					dan_name.innerHTML = lt_name;
					te_span.innerHTML = te_name;
					price_span.innerHTML = FormatNumber(price,3);
					date_span.innerHTML = lt_term;


					var obj =document.getElementById(lt_num+"_select");
					var chk_list2 =document.getElementById("modi_list2_0");

					//for (j = 0; j < obj.length; j++) {
				//		obj.length = - j;
				//	}
					var book_text = "";
					for (j = 0; j < chk_list2.length; j++) {
						if(chk_list2[j].value != "none"){
						
							var chk_value = chk_list2[j].value;
							var obj_value=chk_value.split('|');	
							if (book_text == "") {
								book_text = obj_value[1];
							} else {
								book_text = book_text+","+obj_value[1];
							}
							
						//	obj.options[obj.options.length] = new Option(obj_value[1],obj_value[0], false, true);
						}
					}
					if (book_text == "") {
						book_text = "등록된 교재가 없습니다.";
					}
					obj.innerHTML = book_text;
					

					close_layer_window();
				}
			}
		});

	}
	function FormatNumber(price,num){ 
		var str=new Array(); 
		price=String(price); 
		for(var i=1;i<=price.length;i++){ 
		if(i%num) str[price.length-i]=price.charAt(price.length-i); 
		else  str[price.length-i]=','+price.charAt(price.length-i); 
	   }
	  return str.join('').replace(/^,/,''); 
	}
</script>


<form name  = "list_form">
	<input type  = "hidden" name  = "mode" value = "goods">
	<input type  = "hidden" name  = "page" value = "<?php echo $page;?>">
	<input type  = "hidden" name  = "key" value = "<?php echo $key;?>">
	<input type  = "hidden" name  = "searchword" value = "<?php echo $searchword;?>">
	<input type  = "hidden" name  = "set_g_state" value = "<?php echo $set_g_state;?>">
	<input type  = "hidden" name  = "sel_type" value = "<?php echo $sel_type;?>">
	<input type  = "hidden" name  = "ca_num" value = "<?php echo $ca_num;?>">
	<input type  = "hidden" name  = "cg_code" value = "<?php echo $cg_code;?>">
</form>


<form name = "modi_form" id = "modi_form">
	<input type = "hidden" name = "mode">
	<input type = "hidden" name = "feild">
	<input type = "hidden" name = "num">
	<input type = "hidden" name = "val">
</form>

<form name = "del_form" id = "del_form" method = "post">
	<input type = "hidden" name = "mode">
	<input type = "hidden" name = "num">
	<input type = "hidden" name = "g_num" value = "<?php echo $g_num;?>">
	<input type = "hidden" name = "g_type" value = "<?php echo $g_type;?>">

	<input type  = "hidden" name  = "page" value = "<?php echo $page;?>">
	<input type  = "hidden" name  = "key" value = "<?php echo $key;?>">
	<input type  = "hidden" name  = "searchword" value = "<?php echo $searchword;?>">
	<input type  = "hidden" name  = "set_g_state" value = "<?php echo $set_g_state;?>">
	<input type  = "hidden" name  = "sel_type" value = "<?php echo $sel_type;?>">
	<input type  = "hidden" name  = "ca_num" value = "<?php echo $ca_num;?>">
</form>

<form name = "cate_set_form" id = "cate_set_form">
<input type = "hidden" name = "mode">
<input type = "hidden" name = "set_number">
</form>




<div id="mask" onclick="close_layer_window(); return false;"></div>  

<table width="100%" border="0" cellspacing="1" cellpadding="3" class="td" bgcolor="#999999" style="white-space:nowrap">
<form name  = "writeform" method="post" action = "./process/goods_modi.php">
<input type = "hidden" name = "mode" value = "goods_modi">
<input type = "hidden" name = "g_num" value = "<?php echo $g_num;?>">
<input type = "hidden" name = "set_category_num" value = "<?php echo $ca_num;?>">
<input type = "hidden" name = "sel_g_state" value = "<?php echo $g_state;?>">

	<tr bgcolor="#EFEFEF" height=30>
		<td width=10% align=center>
			상태
		</td>

		<td bgcolor="#FFFFFF" colspan=3>
			<input type = "radio" name  = "g_state" value = "R" <?if($g_state == "R"){?>checked<?}?>> 준비중 
			<input type = "radio" name  = "g_state" value = "S" <?if($g_state == "S"){?>checked<?}?>> 판매중 
			<input type = "radio" name  = "g_state" value = "N" <?if($g_state == "N"){?>checked<?}?>> 판매중단 
		</td>
	</tr>

	<tr bgcolor="#EFEFEF" height=30>
		<td width=10% align=center>
			강좌명
		</td>

		<td bgcolor="#FFFFFF" colspan=3>
			<input type = "text" name = "g_name" size = "100" value= "<?php echo $goods_name;?>"> 	
		</td>
	</tr>

	<tr bgcolor="#EFEFEF" height=30>
		<td width=10% align=center>
			카테고리
		</td>

		<td bgcolor="#FFFFFF" width=40%>
			<select name = "cg_code" onchange="cs_cate_set(this.value,'cs')">
		<?php
			$category_group_qry = mysqli_query($CONN['rosemary'],"select cg_code,cg_name from category_group");
			$first_cs_code = $cg_code;
			while ($category_group_rs = mysqli_fetch_array($category_group_qry)) {	
				if (!$first_cs_code) {
					$first_cs_code = $category_group_rs['cg_code'];
				}$cg_code
		?>
					<option value="<?php echo $category_group_rs['cg_code'];?>" <?if($category_group_rs['cg_code'] == $cg_code){?>selected<?}?>><?php echo $category_group_rs['cg_name'];?></option>
		<?}?>
				</select>


		<span id = "cate_gubun">
				<select name = "ca_num" id = "ca_num" onchange="cs_cate_set(this.value,'category')">
					<option value="">카테고리</option>
		<?php
			if(!empty($first_cs_code)){
				$category_qry = mysqli_query($CONN['rosemary'],"select * from category where cg_code = '$first_cs_code' and ca_useyn = 'Y' order by ca_tree asc");
				while($coategory_rs = @mysqli_fetch_array($category_qry)){
					$ca_tree_len = strlen($coategory_rs['ca_tree']) / 3;
					if($ca_tree_len > 1){
						$nbsp = "&nbsp;";
						for($i=0;$i<$ca_tree_len;$i++){
							$nbsp .= $nbsp;
						}
						$cate_dep = $nbsp."ㄴ";
					}else{
						$cate_dep = "";
					}
		?>
					<option value="<?php echo $coategory_rs['ca_num'];?>" <?if($coategory_rs['ca_num'] == $ca_num){?>selected<?}?>><?php echo $cate_dep;?><?php echo $coategory_rs['ca_name'];?></option>
		<?php
			}}
		?>
				</select>

		</span>




		</td>
		<td  width=10% align=center >
			강의할인
		</td>
		<td  width=40% bgcolor="#FFFFFF">
			<input type = "text" value = "<?php echo $goods_rs['g_discount_rate'];?>" name = "discount" OnKeyUp="fnNumberCheck(this);">%  (* 할인이 필요할 시 입력해 주세요.)
		</td>
	</tr>

	<tr bgcolor="#EFEFEF" height=30 >
		<td width=10% align=center>
			강의특전
		</td>

		<td bgcolor="#FFFFFF" colspan=3>
			<textarea name = "g_benefit" cols=200 rows=5><?php echo $goods_rs['g_benefit'];?></textarea>
		</td>
	</tr>
	<tr bgcolor="#EFEFEF" height=30 align=center>
		<td width=10%>
			강좌설명
		</td>
			
		<td bgcolor="#FFFFFF" colspan=3>
		<?php echo myEditor2(1,'../../gmEditor','writeform','content','100%','200');?>
		</td>
	</tr>
</form>
	<tr>
		<td bgcolor="#FFFFFF" colspan=4 align=center height=50>
			<table width = 100%>
				<tr  bgcolor="#FFFFFF">
					<td align=left>
						<input type = "button" value = "강좌 삭제" onclick="del_send('gang','<?php echo $g_num;?>')">&nbsp;&nbsp;
					</td>
					<td align=right>
						<a href="#"><input type = "button" value = "단과 추가" onclick="modal_window('<?php echo $lt_num?>',3);"></a>
		<input type  = "button" value = "강좌 상세 정보 수정" onclick="modi_goods()">
					</td>
				</tr>
			</table>
		
		</td>
	</tr>
</table>
		
		<br>

<?
	if($dan_cnt){ 
		while($dan_rs = mysqli_fetch_array($dan_chk )){
			$lt_num = $dan_rs['lt_num']; 
			$dan_name = $dan_rs['lt_name']; 
			$dan_date = $dan_rs['lt_term']; 
			$dan_price = number_format($dan_rs['lt_selling_price']); 
			$mb_name = $dan_rs['mb_name']; 
			$my_book_query = mysqli_query($CONN['rosemary'],"select a.bo_num,b.bo_name from goods_lecture_book a, book b where a.bo_num = b.bo_num and a.lt_num = '$lt_num'");
			$my_book_num = mysqli_num_rows($my_book_query);
			$my_book_option = "";
			if ($my_book_num > 0) {
				while($my_book_rs = mysqli_fetch_array($my_book_query)){
					$my_book_name = $my_book_rs['bo_name'];
					$my_book_num = $my_book_rs['bo_num'];
					$my_book_value = $my_book_rs['bo_num']."|".$my_book_rs['bo_name'];
					if (empty($book_text)) {
						$book_text = $my_book_name;
					} else {
						$book_text .= ",".$my_book_name;
					}
					

					//$my_book_option .= "<option value = $my_book_value>$my_book_name</option>";
				}
			} else {
					//$my_book_option .= "<option>등록된 교재가 없습니다.</option>";
					$book_text = "등록된 교재가 없습니다.";
			}				
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
			<a href="javascript:modal_window('<?php echo $lt_num?>',4);"><span id = "<?php echo $lt_num;?>_danname"><?php echo $dan_name;?></span></a>
			
			

		</td>
		<td bgcolor="#FFFFFF" >
			<table width="100%" border="0" cellspacing="1" cellpadding="3" class="td" bgcolor="#999999" style="white-space:nowrap">
			<tr >
				<td bgcolor="#EFEFEF" align=center width=20%>담당교수</td>
				<td bgcolor="#FFFFFF" width=15%><span id = "<?php echo $lt_num;?>_te_span"><?php echo $mb_name;?></span></td>
				<td bgcolor="#EFEFEF" align=center width=10%>교재</td>
				<td bgcolor="#FFFFFF">
<!--
<select id = "<?php echo $lt_num;?>_select">
<?=$my_book_option?>
</select>
-->
<span  id = "<?php echo $lt_num;?>_select"><?=$book_text?></span>
 


				</td>
			</tr>
			<tr >
				<td bgcolor="#EFEFEF" align=center>가격</td>
				<td bgcolor="#FFFFFF">
					<span id = "<?php echo $lt_num;?>_price"><?php echo $dan_price;?></span>원
				</td>
				<td bgcolor="#EFEFEF" align=center width=10%>기간</td>
				<td bgcolor="#FFFFFF">
					<span id = "<?php echo $lt_num;?>_date"><?php echo $dan_date;?></span>일
				</td>
			</tr>

			<tr >
				<td bgcolor="#EFEFEF" align=center>강의정보 
					
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
								<td bgcolor="#C9C9C9" align=center width=20% height=40>강의명</td>
								<td bgcolor="#FFFFFF" width=40%>
									<input type = "text" name = "<?php echo $subject_num;?>_lts_name"  id = "<?php echo $subject_num;?>_lts_name" value = "<?php echo $subject_name;?>" size=60> <input type = "button" value = "강의명변경" onclick="goods_subject_modi_change('<?php echo $subject_num;?>','lts_name')">			 							
								</td>
								<td bgcolor="#C9C9C9" align=center width=10%>강의유형</td>
								<td bgcolor="#FFFFFF"><span id = "lsct_span_<?php echo $subject_num;?>"><?php echo $lsct_name;?></span> <!--<select name = "subject_type_<?php echo $subject_num;?>" onchange="goods_subject_modi_change('<?php echo $subject_num;?>','lsct_code',this.value)"><?=$type_option?></select>--></td>
							</tr>
							<tr >
								
								<td bgcolor="#FFFFFF" colspan=4>
									<table width="100%" border="0" cellspacing="1" cellpadding="3" class="td" bgcolor="#999999" style="white-space:nowrap">
										<tr bgcolor="#EFEFEF">
											<td align=center colspan="7" height=30>
												차시정보 <a href="#"><input type = "button" value = "차시 추가" onclick="modal_window('<?php echo $subject_num?>',2);"></a>
											</td>
										
										</tr>
<?php
			$movie_query = mysqli_query($CONN['rosemary'],"select * from goods_lecture_subjects_period where lts_num = '$subject_num' order by ltsp_period_num asc");	
			$movie_nums = mysqli_num_rows($movie_query);
			if ($movie_nums) {
				while($movie_rs = mysqli_fetch_array($movie_query)){
					$ltsp_num = $movie_rs['ltsp_num'];
					$movie_name = $movie_rs['ltsp_name'];
					$movie_len = $movie_rs['ltsp_time_length'];
					$movie_num = $movie_rs['ltsp_period_num'];
					$movie_url = $movie_rs['ltsp_url'];
					$movie_sample = $movie_rs['ltsp_sample_yn'];
						

?>
<form name = "movie_form_<?php echo $ltsp_num;?>" id = "movie_form_<?php echo $ltsp_num;?>">
<input type = "hidden" name = "mode" value = "modi_movie">
<input type = "hidden" name = "ltsp_num" value = "<?php echo $ltsp_num;?>">
										<tr bgcolor="#EFEFEF">
											<td align=center colspan="7" height=2>
										
											</td>
										
										</tr>

										<tr bgcolor="#EFEFEF">
											<td align=center width=20%><b>차시순서</b></td>
											<td bgcolor="#FFFFFF">
												<input type = "text" name = "ltsp_period_num"  id = "ltsp_period_num" value = "<?php echo $movie_num;?>" size=10>번 										
											</td>
											<td align=center width=10%><b>차시길이</b> </td>
											<td bgcolor="#FFFFFF">
												<input type = "text" name = "ltsp_time_length"  id = "ltsp_time_length" value = "<?php echo $movie_len;?>" size=10>초 										
											</td>

											<td align=center width=10%><b>맛보기</b></td>
											<td bgcolor="#FFFFFF">
												<input type = "checkbox" name ="movie_sample" value = "Y" <?if($movie_sample == "Y"){?>checked<?}?>>									
											</td>
											<td rowspan=3 align=center bgcolor="#FFFFFF">
												<input type = "button" value = "정보변경" onclick="modi_movie(<?php echo $ltsp_num;?>)"><br><br>
												<input type = "button" value = "차시삭제"  onclick="del_send('period','<?php echo $ltsp_num;?>')">
											</td>

										</tr>
										<tr bgcolor="#EFEFEF">
											<td align=center><b>차시명</b></td>
											<td bgcolor="#FFFFFF" colspan=5>
												<input type = "text" name = "ltsp_name"  id = "ltsp_name" value = "<?php echo $movie_name;?>" size=90> 
											</td>
										</tr>
										<tr bgcolor="#EFEFEF">
											<td align=center><b>차시주소</b></td>
											<td bgcolor="#FFFFFF" colspan=5>
												<input type = "text" name = "ltsp_url"  id = "ltsp_url" value = "<?php echo $movie_url;?>" size=90>								
											</td>
										</tr>


</form>

<?php
				}
			} else {
?>
										<tr bgcolor="#EFEFEF" >
											<td align=center height=20 bgcolor="#FFFFFF">등록된 차시가 없습니다.</td>
										</tr>
<?php }?>
									</table>
								</td>
							</tr>

							<tr>
								<td bgcolor="#FFFFFF" colspan=4 height=30 align=right>
								<input type = "button" value = "<?php echo $subject_name;?> 강의삭제"  onclick="del_send('subject','<?php echo $subject_num;?>')" id = "<?php echo $subject_num;?>_gang_button">	
								</td>
							</tr>
								<td bgcolor="#FFFFFF" colspan=4 height=1 align=center>
								
								</td>
							</tr>
<?php
		}
	} else {	
?>
							<tr bgcolor="#FFFFFF">
								<td>
									등록된 강의가 없습니다. 
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


			<table width = 100%>
				<tr  bgcolor="#FFFFFF">
					<td align=left>
<input  type = "button" value = "<?php echo $dan_name;?> 단과 삭제"  onclick="del_send('dan','<?php echo $lt_num;?>')" id = "<?php echo $lt_num;?>_dan_button">
					</td>
					<td align=right>
 <?//if($goods_rs['g_type'] != "A"){?><a href="#"><input type = "button" value = "강의 추가" onclick="modal_window('<?php echo $lt_num?>',1);"></a><?//}?>	 <input type = "button" value = "단과 수정" onclick="modal_window('<?php echo $lt_num?>',4);">
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

<input type  = "hidden" name  = "page" value = "<?php echo $page;?>">
<input type  = "hidden" name  = "key" value = "<?php echo $key;?>">
<input type  = "hidden" name  = "searchword" value = "<?php echo $searchword;?>">
<input type  = "hidden" name  = "set_g_state" value = "<?php echo $set_g_state;?>">
<input type  = "hidden" name  = "sel_type" value = "<?php echo $sel_type;?>">

<table width="900" border="0" cellspacing="1" cellpadding="3" class="td" bgcolor="#999999" style="white-space:nowrap">
	<tr bgcolor="#EFEFEF" height=30>
		<td width=20%>
			강의 등록하기 <?if($goods_rs['g_type'] != "A"){?> <input type="button" value="추가" id="addDynamicInput" />	<?}?>
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

<script>
	function send_excel(){
		var f = document.sub_form2;
		f.mode.value = "excel_movie_reg";
		f.submit();
}
</script>


<!--차시 테이블-->
<div id="dialog2">
<form name  = "sub_form2" method="post" action = "./process/goods_reg.php" autocomplete="off" enctype='multipart/form-data'>
<input type = "hidden" name = "g_num" value = "<?php echo $g_num?>">
<input type = "hidden" name = "mode" value = "movie_reg">
<input type = "hidden" name = "sub_num" >
<input type = "hidden" name = "sel_form_num">


<input type  = "hidden" name  = "page" value = "<?php echo $page;?>">
<input type  = "hidden" name  = "key" value = "<?php echo $key;?>">
<input type  = "hidden" name  = "searchword" value = "<?php echo $searchword;?>">
<input type  = "hidden" name  = "set_g_state" value = "<?php echo $set_g_state;?>">
<input type  = "hidden" name  = "sel_type" value = "<?php echo $sel_type;?>">

<table width="900" border="0" cellspacing="1" cellpadding="3" class="td" bgcolor="#999999" style="white-space:nowrap">
	<tr bgcolor="#EFEFEF" height=30>
		<td width=20%>
			차시 등록하기 <input type="button" value="추가" id="addDynamicInput2" />  
		</td>
		<td width=20% align=right>
		<input type = "file" name = "excel_file"><input type = "button" value = "엑셀로 넣기" onclick="send_excel()">	
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
				<td bgcolor="#FFFFFF" ><input type = "text" name = "movie_num_0" value="1" OnKeyUp="fnNumberCheck(this);"></td>
				<td bgcolor="#EFEFEF" align=center width=200>차시총길이</td>
				<td bgcolor="#FFFFFF" ><input type = "text" name = "movie_len_0" OnKeyUp="fnNumberCheck(this);">초</td>	
				<td bgcolor="#EFEFEF" align=center width=200>맛보기</td>
				<td bgcolor="#FFFFFF" ><input type  = "checkbox" name = "movie_sample_0" value = "Y"></td>		
			</tr>
			<tr >
				<td bgcolor="#EFEFEF" align=center>차시명</td>
				<td bgcolor="#FFFFFF" colspan=5><input type = "text" name = "movie_name_0" size=160></td>
			</tr>
			<tr >
				<td bgcolor="#EFEFEF" align=center>동영상주소</td>
				<td bgcolor="#FFFFFF" colspan=5><input type = "text" name = "movie_url_0" size=160 ></td>
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


<!--단과등록-->
<div id="dialog3">

<form name  = "dan_form" method="post" action = "./process/goods_reg.php" autocomplete="off">
<input type = "hidden" name = "mode" value = "dan_reg">
<input type = "hidden" name = "g_type" value = "<?php echo $goods_rs['g_type']?>">
<input type = "hidden" name = "g_num" value = "<?php echo $g_num?>">
<input type = "hidden" name = "sel_form_num" id = "sel_form_num">

<input type  = "hidden" name  = "page" value = "<?php echo $page;?>">
<input type  = "hidden" name  = "key" value = "<?php echo $key;?>">
<input type  = "hidden" name  = "searchword" value = "<?php echo $searchword;?>">
<input type  = "hidden" name  = "set_g_state" value = "<?php echo $set_g_state;?>">
<input type  = "hidden" name  = "sel_type" value = "<?php echo $sel_type;?>">

<table width="900" border="0" cellspacing="1" cellpadding="3" class="td" bgcolor="#999999" style="white-space:nowrap">
	<tr bgcolor="#EFEFEF" height=30>
		<td width=20%>
			단과 등록하기 <input type="button" value="추가" id="addDynamicInput3" />	
		</td>
	</tr>

	<tr bgcolor="#FFFFFF" height=30>

		<td colspan=2 id="dynamicInputArea3">



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
				<td bgcolor="#FFFFFF" ><select name = "te_sel_0"><?=$te_option?></select></td>
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
		<input type='button'  value='단과 등록하기' onclick="send_dan()">&nbsp;
		</td>
	</tr>	
</table>

</form>


</div>




<!--단과수정-->
<div id="dialog4">

<form name  = "dan_modi_form" id = "dan_modi_form" method="post" action = "./process/goods_modi.php" autocomplete="off">
<input type = "hidden" name = "mode" value = "dan_modi">
<input type = "hidden" name = "lt_num" >
<table width="900" border="0" cellspacing="1" cellpadding="3" class="td" bgcolor="#999999" style="white-space:nowrap">
	<tr bgcolor="#EFEFEF" height=30>
		<td width=20%>
			단과 수정하기 
		</td>
	</tr>

	<tr bgcolor="#FFFFFF" height=30>
		<td colspan=2 >
			<div id = "opn_list_layer"></div>
		</td>
	</tr>
	<tr bgcolor="#FFFFFF" height = "50" >
		<td align = "center" width=33% colspan=4><input type = "button" value = "작성취소" onclick="close_layer_window(); return false;">
		<input type='button'  value='단과 수정하기' onclick="send_dan_modi()">&nbsp;
		</td>
	</tr>	
</table>

</form>


</div>













<div align=right>
	<input type  = "button" value = "리스트" onclick="send_list()">
</div>


<script type = "text/javascript">




//마스크 배경 클릭시 창 닫기
	$('#mask').click(function (){  
		$(this).hide();    $('#dialog').hide();     is_mask_run =false;
	}); 

/*레이어 윈도우창 닫기*/
	function close_layer_window(){ 
		$('#mask').hide();   
		$('#dialog').hide();    
		$('#dialog2').hide();  
		$('#dialog3').hide(); 
		$('#dialog4').hide();
		is_mask_run= false;
	}


function modal_window(val,mode){    
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

	if (mode == 1) {	//강좌추가
		var f = document.sub_form;
		f.dan_num.value = val;
		var dial_width =$('#dialog').width(); 
		var dial_height = $('#dialog').height();  
		$('#dialog').css({'width':dial_width,'height':dial_height}); 
		//$('#dialog').css('top', h-dial_height/1);  
		$('#dialog').css('top', 100);  
		$('#dialog').css('left', winW/2-dial_width/2);  
		$('#dialog').fadeIn(2000);
	}else if(mode == 2){	//차시추가
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
	}else if(mode == 3) {
		// dialog창 리사이즈  
		var dial_width =$('#dialog3').width(); 
		var dial_height = $('#dialog3').height();  
		$('#dialog3').css({'width':dial_width,'height':dial_height}); 
		//$('#dialog').css('top', h-dial_height/1);  
		$('#dialog3').css('top', 100);  
		$('#dialog3').css('left', winW/2-dial_width/2);  
		// dialog창  effect  
		$('#dialog3').fadeIn(2000);
	} else {


		$.ajax({
			type : "POST" 
			, async : true 
			, url : "./process/goods_modi.php" 
			, dataType : "html" 
			, timeout : 30000 
			, cache : false  
			//, data : $("#modi_form").serialize() 
			, data: "mode=dan_modi_view&num="+val
			, contentType: "application/x-www-form-urlencoded; charset=UTF-8"
			, error : function(request, status, error) {
				 alert("ajax 통신서버에 접속할 수 업습니다.");
			}
			, success : function(response, status, request) {
				var result=response.split('|*|');
					if(result[0] != 'T'){
						if (result[1] == 1) {
							alert("필수 정보 누락으로 인해 접근할 수 없습니다.");
						} else if(result[1] == 2) {
							alert("존재하지 않는 단과 입니다.");
						} else {
							alert("접근할 수 없습니다.");
						}
					} else {
						var div_layer=document.getElementById('opn_list_layer');
						div_layer.innerHTML = result[1];
						
						var form = document.dan_modi_form;
						form.lt_num.value = val;

						// 테이블 노출부분
						var dial_width =$('#dialog4').width(); 
						var dial_height = $('#dialog4').height();  
						$('#dialog4').css({'width':dial_width,'height':dial_height}); 
						$('#dialog4').css('top', h-dial_height/2); 
						
						$('#dialog4').css('left', winW/2-dial_width/2);  
						$('#dialog4').fadeIn(2000);


					}
			}
		});








		

	}


}






</script>