<?
if ($mode == "sel_goods_modi") {
	$gg_code = $_GET['gg_code'];
	$page = $_GET['page'];
	$key = $_GET['key'];
	
	$searchword = $_GET['searchword'];
	$set_cs = $_GET['set_cs'];
	$set_state = $_GET['set_state'];

	
	$view_query = "select A.*,B.cg_name from goods_group A, category_group B where A.gg_code = '$gg_code' and A.cg_code = B.cg_code  ";

	$view_result = mysqli_query($CONN['rosemary'],$view_query);
	$view_nums = mysqli_num_rows($view_result);
	if (!$view_nums) {
		alertback("삭제되거나 존재하지 않는 상품 입니다.");
	}
	$view_rs = mysqli_fetch_array($view_result);
	$cg_code = $view_rs['cg_code']; 
		

}
?>


<script src="<?php echo $MY_URL;?>_js/jquery.min.js" type="text/javascript"></script>
<script type = "text/javascript">
	function cs_cate_set(val,mode,search)
	{
		if (mode == "category") {

			if (!search) {
				var search = "";
			}
			var cg_code =document.getElementById("cg_code").value;
			var ca_num =document.getElementById("ca_num").value;
			var obj =document.getElementById("file_list_0");
			var obj2 =document.getElementById("file_list2_0");
			var search_val =document.getElementById("goods_search").value;

			if (search_val != "") {
				search = search_val
			}

			$.ajax({
				type : "POST" 
				, async : true 
				, url : "./process/select_ca_num.php" 
				, dataType : "html" 
				, timeout : 30000 
				, cache : false  
				, data: "ca_num="+ca_num+"&cg_code="+cg_code+"&search="+search
				, contentType: "application/x-www-form-urlencoded; charset=UTF-8"
				, error : function(request, status, error) {
					 alert("ajax 통신서버에 접속할 수 업습니다.");
				}
				, success : function(response, status, request) {
					var result=response.split('<>');	
					if (result[0] != "T") {
						alert(result[1]);
					} else {
						for (j = 0; j < obj.length; j++) {
							obj.length = - j;
						}	
						obj.options[obj.options.length] = new Option("===============선택하세요==============","none", false, false);						
						var goods_result=result[1].split('|^|');
						for(i=0;i < goods_result.length;i++){
							var goods_result2 = goods_result[i].split('|*|');
							var f_value = goods_result2[1];
							var val = goods_result2[0];
							obj.options[obj.options.length] = new Option(f_value,val, false, false);	
						}
					}
				}
			});
			return;
		} else {

				var obj2 =document.getElementById("file_list2_0");
				for (j = 0; j < obj2.length; j++) {
					obj2.length = - j;
				}
				obj2.options[obj2.options.length] = new Option("===============선택된상품==============","", false, false);
	
				var f = document.cate_set_form;
				f.mode.value = mode;
				f.set_number.value = val;
				$.ajax({
					type : "POST" 
					, async : true 
					, url : "./process/select_ca_num.php" 
					, dataType : "html" 
					, timeout : 30000 
					, cache : false  
					, data : $("#cate_set_form").serialize() 
					, contentType: "application/x-www-form-urlencoded; charset=UTF-8"
					, error : function(request, status, error) {
						 alert("ajax 통신서버에 접속할 수 업습니다.");
					}
					, success : function(response, status, request) {
					 //통신 성공시 처리
						var result=response.split('|');	
						if (result[0] != "T") {
							alert(result[1]);
						} else {
							if (f.mode.value == "cs") {
								var div_layer=document.getElementById('cate_gubun');
							//	alert(div_layer);
								div_layer.innerHTML=result[1];	
								cs_cate_set('','category');
							} 
						}
					}
				});
		}
	}


	function getStrCuts(str, max) //25자이상글자자르기
	{
		ns = str.substr(0, max);
		if (ns.length != str.length) {
			ns = ns + "";
		}
		return ns;
	}

	function chk_select(val,f,f2)
	{	
		if (val == "none" || !val) {
			alert("상품을 선택하세요.");
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
		//var szName = getStrCuts(value[1],27);
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
			//alert("이미 선택한 상품 입니다.");
		}else{
			obj.options[obj.options.length] = new Option(f_value,val, false, false);
		}
	}

	function search_goods()
	{
		var obj =document.getElementById("goods_search");
		if (!obj.value) {
			alert("검색할 상품명을 입력해 주세요.");
		} else {
			var search = obj.value;
			var cg_code =document.getElementById("cg_code").value;
			if (!cg_code) {
				alert("선택한 CS가 없습니다.");
			} else {
				cs_cate_set(cg_code,"category",search);	
			}
		}
	}

	function enter_down(val)
	{
		var keyCode = event.keyCode ? event.keyCode : event.which ? event.which : event.charCode;
			if (keyCode == 13) {
				if (val == "search") {
					search_goods();
				}
			}
	}
	function send_reg()
	{
		var f = document.writeform;
		var obj2 =document.getElementById("file_list2_0");
		var set_goods = "";
		for (j = 0; j < obj2.length; j++) {
			if(obj2[j].value != "none"){
				var chk_value = obj2[j].value;
				var obj_value=chk_value.split('|');	
				if (set_goods == "") {
					set_goods = obj_value[0];
				} else {
					set_goods = set_goods+","+obj_value[0];
				}
			}
		}

		var radio_obj = f.sort;
		for(i=0; i < radio_obj.length; i++) {
			if (radio_obj[i].checked == true) {
				radio_obj_value = radio_obj[i].value;
			}
		}

		if (f.gg_code.value == "") {
			if (!f.list_code.value) {
				alert("그룹코드를 입력해 주세요.");
				f.list_code.focus();
				return;
			}
		} 

		if (!f.list_name.value) {
			alert("그룹명을 입력해 주세요.");
			f.list_name.focus();
		} else if (!set_goods) {
			alert("선택한 상품이 없습니다.");
		} else {
			f.set_good.value = set_goods;
			f.set_radio.value = radio_obj_value;
			f.action = "./process/sel_goods_reg.php";
			f.submit();
		}

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

	function get_result(argSel)
	{
		formSel=eval("document.writeform."+argSel);
		res=new Array();
		for(var i=0;i<formSel.length;i++) {
			res[i]=formSel.options[i].value;
		}
		res=res.join("@");
	}

	function gou(argSel)
	{
		formSel    = eval("document.writeform."+argSel);
		if(!formSel.value) {
			return;
		}
		if (formSel.value == "none") {
			return;
		}

		thisIndex = formSel.selectedIndex;
		if(!thisIndex) {
			return;
		}

		if (thisIndex == 1) {
			return;
		}


		formSel.value=null;
		prevIndex=thisIndex-1;

		tempText=formSel.options[prevIndex].text;
		tempValue=formSel.options[prevIndex].value;

		formSel.options[prevIndex] = new Option(formSel.options[thisIndex].text,formSel.options[thisIndex].value);
		formSel.options[thisIndex] = new Option(tempText,tempValue);
		formSel.value=formSel.options[prevIndex].value;
	    get_result(argSel);
	}

	function god(argSel)
	{
		formSel    = eval("document.writeform."+argSel);
		if(!formSel.value) {
			return;
		}
		if (formSel.value == "none") {
			return;
		}

		thisIndex = formSel.selectedIndex;
		if(thisIndex+1>=formSel.length) {
			return;
		}

		formSel.value=null;
		prevIndex=thisIndex+1;

		tempText=formSel.options[prevIndex].text;
		tempValue=formSel.options[prevIndex].value;

		formSel.options[prevIndex]    = new Option(formSel.options[thisIndex].text,formSel.options[thisIndex].value);
		formSel.options[thisIndex]    = new Option(tempText,tempValue);
		formSel.value=formSel.options[prevIndex].value;
		get_result(argSel);
	}
	function chk_code(obj)
	{
		var regexp = /^[A-Za-z0-9]{0,10}$/;
		var str = obj.value
		 if (!regexp.test(str)) 
		  {    
			var text1 = obj.value.substring(0, obj.value.length - 1);
			alert("영어,숫자만 입력 가능 합니다. (최대 10자리)");
			obj.focus();
			obj.value = text1;
			return false;
		  } else {
				$.ajax({
					type : "POST" 
					, async : true 
					, url : "./process/code_chk.php" 
					, dataType : "html" 
					, timeout : 30000 
					, cache : false  
					, data: "gg_code="+str
					, contentType: "application/x-www-form-urlencoded; charset=UTF-8"
					, error : function(request, status, error) {
						 alert("ajax 통신서버에 접속할 수 업습니다.");
					}
					, success : function(response, status, request) {
						var result=response.split('|');	
						var div_layer=document.getElementById('span_code');
						if (result[0] != "T") {
							div_layer.innerHTML="<font color='red'>이미 사용중인 코드명 입니다.</font>";	
						} else {
							div_layer.innerHTML="<font color='blue'>사용 가능한 코드명 입니다.</font>";
						}
					}
				});			
		  }
	}

</script>


<form name = "cate_set_form" id = "cate_set_form">
<input type="hidden" name="mode" >
<input type="hidden" name="set_number">
</form>

<table width="100%" border="0" cellspacing="1" cellpadding="3" class="td" bgcolor="#999999" style="white-space:nowrap">
	<tr bgcolor="#EFEFEF" height=30> 
		<td align=center> 
			<table width=500>
				<tr>
				<td align=center>
<?php if ($mode == "sel_goods_modi") {?>
	<b>상품 목적그룹 수정</b>
<?php } else {?>
	<b>상품 목적그룹 등록</b>
<?php }?>

				</td>
				</tr>
			</table>
		</td>
	</tr>	
</table>

<br>

<table width="100%" border="0" cellspacing="1" cellpadding="3" class="td" bgcolor="#999999" style="white-space:nowrap">
<form name  = "writeform" method="post" enctype='multipart/form-data' autocomplete="off">
<input type="hidden" name="set_good">
<input type="hidden" name="set_radio">

<input type="hidden" name="gg_code" value="<?php echo $gg_code?>">
<input type="hidden" name="mode" value="<?php echo $mode?>">



<input type="hidden" name="page" value="<?php echo $page?>">
<input type="hidden" name="key" value="<?php echo $key?>">
<input type="hidden" name="searchword" value="<?php echo $searchword?>">
<input type="hidden" name="set_cs" value="<?php echo $set_cs?>">
<input type="hidden" name="set_state" value="<?php echo $set_state?>">



	<tr bgcolor="#EFEFEF" height=30> 
		<td align=center width=10%>그룹코드</td>
		<td align=left width=30%>
		<?if(!empty($gg_code)){?>
			<?php echo $gg_code;?>
		<?}else{?>
			<input type="text" size=20 name="list_code" maxlength="10" OnKeyUp="chk_code(this);">
		<?}?>
			<span id = "span_code"></span>
		</td>
	</tr>

	<tr bgcolor="#EFEFEF" height=30> 
		<td align=center>정렬순서</td>
		<td align=left width=30%>
			<input type="radio" name="sort" id="sort" value="A" <?if($view_rs['gg_sort_type'] == "A" || !$view_rs['gg_sort_type']){?>checked<?}?>> 순서대로 정렬 
			<input type="radio" name="sort" id="sort" value="R" <?if($view_rs['gg_sort_type'] == "R"){?>checked<?}?>> 무작위 정렬
		</td>
	</tr>


	<tr bgcolor="#EFEFEF" height=30> 
		<td align=center>그룹명</td>
		<td align=left width=30%><input type = "text" size=100 name = "list_name" value="<?php echo $view_rs['gg_name'];?>" maxlength="50"></td>
	</tr>
	

	<tr bgcolor="#EFEFEF" height=30> 
		<td align=center>과목(자격증) 선택</td>
		<td align=left colspan=3>
		<select name = "cg_code" id = "cg_code" onchange="cs_cate_set(this.value,'cs')">
<?php
	$category_group_qry = mysqli_query($CONN['rosemary'],"select cg_code,cg_name from category_group");
	$first_cs_code = $cg_code;
	while ($category_group_rs = mysqli_fetch_array($category_group_qry)) {	
		if (!$first_cs_code) {
			$first_cs_code = $category_group_rs['cg_code'];
		}
?>
			<option value="<?php echo $category_group_rs['cg_code'];?>" <?if($category_group_rs['cg_code'] == $cg_code){?>selected<?}?>><?php echo $category_group_rs['cg_name'];?></option>
<?}?>
		</select>
(* 과목 변경시 이미 선택된 상품은 초기화 됩니다.)	



		</td>
	</tr>

	<tr bgcolor="#EFEFEF" height=30> 
		<td align=center>상품 구성</td>
		<td align=left colspan=3>

<table width="100%" border="0" cellspacing="1" cellpadding="3" class="td" bgcolor="#999999" style="white-space:nowrap">
		<tr  bgcolor="#EFEFEF">
			<td width=10%>
				<select name="file_list_0"  id="file_list_0" size="7" style="width:535; height:90; background-color=#FFFFFF;" multiple class="formtype" ondblclick="chk_select(this.value,'file_list_0','file_list2_0')">
					<option value="none" >===============선택하세요==============</option>
<?php
	if(!empty($first_cs_code)){

		$goods_qry = mysqli_query($CONN['rosemary'],"select *,(select ca_name from category b where b.ca_num = a.ca_num ) as ca_name from goods a where cg_code = '$first_cs_code'  and g_state = 'S' order by g_num desc");
		$goods_nums = mysqli_num_rows($goods_qry);

		if ($goods_nums) {
			while($goods_rs = @mysqli_fetch_array($goods_qry)){
				$g_name			 = mb_strimwidth($goods_rs['g_name'], 0, 40, "...", "UTF-8");	// 제목
				$g_num = $goods_rs['g_num'];
				$ca_name = $goods_rs['ca_name'];
				$g_value = $goods_rs['g_num']."|".$goods_rs['g_name']." (".$ca_name.")";
				
?>
			<option value="<?php echo $g_value?>" ><?php echo $g_name;?> (<?php echo $ca_name;?>)</option>
<?php
			}
		} else {
?>
			<option value="none" >등록된 상품이 없습니다.</option>
<?php
		}} else {

?>
		<option value="none" >등록된 상품이 없습니다.</option>
<?php }?>
					</select>				
			</td>
			<td>
				<select name="file_list2_0" id="file_list2_0" size="7" style="width:535; height:90; background-color=#FFFFFF;" multiple class="formtype" ondblclick="chk_select(this.value,'file_list2_0','file_list_0')">
					<option value="none" >===============선택하세요==============</option>
<?php
	if (!empty($gg_code)){
			$view_query2 = mysqli_query($CONN['rosemary'],"select A.ggg_sortnum,B.g_name,C.ca_name,B.g_num from goods_group_goods A, goods B, category C where A.gg_code = '$gg_code' and A.g_num = B.g_num and B.ca_num = C.ca_num order by A.ggg_sortnum asc");
		$view_nums2 = mysqli_num_rows($view_query2);
		if ($view_nums2) {	
			while($view_rs2 = mysqli_fetch_array($view_query2)){
				$g_name	= $view_rs2['g_name'];
				$g_num = $view_rs2['g_num'];
				$ca_name = $view_rs2['ca_name'];
				$g_value = $view_rs2['g_num']."|".$view_rs2['g_name']." (".$ca_name.")";
?>
					<option value="<?php echo $g_value?>" ><?php echo $g_name;?> (<?php echo $ca_name;?>)</option>
<?php
			}
		}
	}
?>
				</select>

<input name="button" type=button class=button onclick=gou('file_list2_0') value=' ↑ '> 
<input name="button" type=button class=button onclick=god('file_list2_0') value=' ↓ '>

			</td>
		</tr>
		<tr  bgcolor="#EFEFEF">
			<td colspan=2>

<span id = "cate_gubun">
		<select name = "ca_num" id = "ca_num" onchange="cs_cate_set(this.value,'category')">
		<option value=''>전체 보기</option>
<?php
	if(!empty($first_cs_code)){
		$first_ca_num = $ca_num;
		$category_qry = mysqli_query($CONN['rosemary'],"select * from category where cg_code = '$first_cs_code' and ca_useyn = 'Y' order by ca_tree asc");
		while($coategory_rs = @mysqli_fetch_array($category_qry)){
			if (!$first_ca_num) {
				$first_ca_num = $coategory_rs['ca_num'];
			}
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
			<input type = "text" size=30 name = "goods_search" id = "goods_search" onKeyDown = "enter_down('search')"><input type  = "button" value = "상품검색" onclick="search_goods()">
	
			</td>
		</tr>
	</table>


		</td>
	</tr>


</form>
</table>

<br><br>


<div align="right">
	<input type = "button" value = "리스트" onclick="history.back();"><input type = "button" value = "등록하기" onclick="send_reg()">
</div>

<br><br>