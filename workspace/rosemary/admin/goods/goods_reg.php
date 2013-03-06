<style>
#mask {position:absolute;left:0;top:0;z-index:900;background-color:#000;display:none;}
#dialog {position:absolute;left:0;top:0;display:none;z-index:901;}
</style> 
<script src="<?php echo $MY_URL;?>_js/jquery.min.js" type="text/javascript"></script>
<script type = "text/javascript">
	function send_next(){
		var f = document.writeform;
		var check_memo = f.content.value = SubmitHTML();
		if(!f.g_type.value) {
			return false;
		} else if(!f.g_name.value) {
			alert("강좌명을 입력해 주세요.");
			f.g_name.focus();
			return false;
		} else if(f.set_category_num.value == "") {
			alert("카테고리를 선택해 주세요.");
			return false;
		} else {
			return true;
		}	
	}


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
			, beforeSend: function() {
				 $('#ajax_indicator').show().fadeIn('fast'); 
			}
			, complete: function(request) {
				 $('#ajax_indicator').fadeOut();
			}
		});
	}

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

</script>

<form name = "cate_set_form" id = "cate_set_form">
<input type = "hidden" name = "mode">
<input type = "hidden" name = "set_number">
</form>

<div id="mask" onclick="close_layer_window(); return false;"></div>  

<table width="100%" border="0" cellspacing="1" cellpadding="3" class="td" bgcolor="#999999" style="white-space:nowrap">
	<tr bgcolor="#EFEFEF" height=30> 
		<td align=center> 
			<table width=500>
				<tr>
				<td align=center><b>단과/강좌 등록</b></td>
				</tr>
			</table>
		</td>
	</tr>	
</table>
<br>

<table width="100%" border="0" cellspacing="1" cellpadding="3" class="td" bgcolor="#999999" style="white-space:nowrap">
	<tr bgcolor="#EFEFEF" height=30> 
		<td align=center width=5%>
			단과/강좌 유형 선택
		</td>
	</tr>
	<tr bgcolor="#EFEFEF" height=30>
		<td>
			<table width="100%" border="0" cellspacing="1" cellpadding="3" class="td" bgcolor="#999999" style="white-space:nowrap">		
				<tr bgcolor="#FFFFFF" height=400>
					<td align = "center" width=33% ><a href = "javascript:modal_window('A');"><img src = "http://localhost/_template/skin/board/test2/sample.jpg" height=300 width=300 border=0></a></td>
					<td align = "center" width=33% ><a href = "javascript:modal_window('B');"><img src = "http://localhost/_template/skin/board/test/sample.jpg" height=300 width=300 border=0></a></td>
					<td align = "center" width=33% ><a href = "javascript:modal_window('C');"><img src = "http://localhost/_template/skin/board/test3/sample.jpg" height=300 width=300 border=0></a></td>
				</tr>
				<tr bgcolor="#FFFFFF" height = "50">
					<td align = "center" width=33% >오직 단 하나의 단과와 강의만을 구성할 수 있는 유형 입니다.</td>
					<td align = "center" width=33% >단 하나의 단과안에 여러가지 강의를 구성할 수 있는 유형 입니다.</td>
					<td align = "center" width=33% >다수의 단과안에 여러가지 강의를 구성할 수 있는 유형 입니다.</td>
				</tr>
			</table>
		</td>
	</tr>
</table>

 
<div id="dialog">
<table width="100%" border="0" cellspacing="1" cellpadding="3" class="td" bgcolor="#999999" style="white-space:nowrap">
	<tr bgcolor="#EFEFEF" height=30> 
		<td align=center> 
			<table width=500>
				<tr>
				<td align=center><b>강좌 등록</b></td>
				</tr>
			</table>
		</td>
	</tr>	
</table>
<br>

<table width="1100" border="0" cellspacing="1" cellpadding="3" class="td" bgcolor="#999999" style="white-space:nowrap">
<form name  = "writeform" method="post" action = "./process/goods_reg.php" onsubmit="return send_next(this);" autocomplete="off">
<input type = "hidden" name = "g_type">
<input type = "hidden" name = "mode" value = "goods_reg">
<input type = "hidden" name = "set_category_num" id="set_category_num">
	<tr bgcolor="#EFEFEF" height=30>
		<td width=20% align=center>
			강좌명
		</td>

		<td bgcolor="#FFFFFF" colspan=3>
			<input type = "text" name  = "g_name" size = 120>
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

	</tr>


<tr bgcolor="#EFEFEF" height=30 id = "tr_dis">
		<td  width=10% align=center>
			강의할인
		</td>
		<td  bgcolor="#FFFFFF"  width=40%>
			<input type  = "text" name = "discount" OnKeyUp="fnNumberCheck(this);"> %
		</td>
</tr>

	<tr bgcolor="#EFEFEF" height=30>
		<td width=10% align=center>
			강의특전
		</td>

		<td bgcolor="#FFFFFF" colspan=3>
			<textarea name = "g_benefit" cols=200 rows=5></textarea>
		</td>
	</tr>
	<tr bgcolor="#EFEFEF" height=30>
		<td width=10% align=center>
			강좌설명
		</td>
			
		<td bgcolor="#FFFFFF" colspan=3>
			<?php echo myEditor2(1,'../../gmEditor','writeform','content','100%','200');?>
		</td>
	</tr>
	<tr bgcolor="#FFFFFF" height = "50" >
		<td align = "center" width=33% colspan=4><input type = "button" value = "작성취소" onclick="close_layer_window(); return false;">
		<input type='submit' class='btn1'  value=' 단과/강좌구성하기'>&nbsp;
		</td>
	</tr>	

</form>
		</table>
</div>



<script type = "text/javascript">

// 창 리사이즈할때 마다 갱신
/*
	$(window).resize(function () { 
		if(is_mask_run){        modal_window();   
		}
	});	

// 스크롤할때마다 위치 갱신
	$(window).scroll(function () {   
		if(is_mask_run){        modal_window();   
		}
	});
	*/
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
	
	var f = document.writeform;
	f.g_type.value = val;

	if (val != "C") {
		var tr_dis = document.getElementById('tr_dis');
		tr_dis.style.display = "none";
	} else {
		var tr_dis = document.getElementById('tr_dis');
		tr_dis.style.display = "";
	}


	var dial_width =$('#dialog').width(); 
	var dial_height = $('#dialog').height();  
	$('#dialog').css({'width':dial_width,'height':dial_height}); 
	$('#dialog').css('top', h-dial_height/2);  
	$('#dialog').css('left', winW/2-dial_width/2);  
	$('#dialog').fadeIn(2000);
	}
</script>