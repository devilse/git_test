<?
if ($mode == "package_modi") {
	$gp_num = $_GET['gp_num'];
	$page = $_GET['page'];
	$key = $_GET['key'];
	
	$searchword = $_GET['searchword'];
	$set_cs = $_GET['set_cs'];
	$set_state = $_GET['set_state'];

	
	$view_query = "select A.*,B.cg_name from goods_package A, category_group B where A.gp_num = '$gp_num' and A.cg_code = B.cg_code  ";

	$view_result = mysqli_query($CONN['rosemary'],$view_query);
	$view_nums = mysqli_num_rows($view_result);
	if (!$view_nums) {
		alertback("삭제되거나 존재하지 않는 상품 입니다.");
	}
	$view_rs = mysqli_fetch_array($view_result);
	$content = $view_rs['gp_explanation'];
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
		var check_memo = f.content.value = SubmitHTML();
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
		if (!f.pack_name.value) {
			alert("패키지명을 입력해 주세요.");
			f.pack_name.focus();
		} else if (!set_goods) {
			alert("선택한 상품이 없습니다.");
		} else if (!f.list_img.value && f.mode.value != 'package_modi') {
			alert("리스트 이미지를 선택해 주세요.");
		} else if (!check_memo) {
			alert("패키지 설명을 작성해 주세요.");
		} else {
			f.set_good.value = set_goods;
			f.action = "./process/pack_reg.php";
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
				<td align=center><b>패키지 등록</b></td>
				</tr>
			</table>
		</td>
	</tr>	
</table>

<br>

<table width="100%" border="0" cellspacing="1" cellpadding="3" class="td" bgcolor="#999999" style="white-space:nowrap">
<form name  = "writeform" method="post" enctype='multipart/form-data' autocomplete="off">
<input type="hidden" name="set_good">
<input type="hidden" name="gp_num" value="<?php echo $gp_num?>">
<input type="hidden" name="mode" value="<?php echo $mode?>">

<input type="hidden" name="page" value="<?php echo $page?>">
<input type="hidden" name="key" value="<?php echo $key?>">
<input type="hidden" name="searchword" value="<?php echo $searchword?>">
<input type="hidden" name="set_cs" value="<?php echo $set_cs?>">
<input type="hidden" name="set_state" value="<?php echo $set_state?>">





	<tr bgcolor="#EFEFEF" height=30> 
		<td align=center>패키지명</td>
		<td align=left width=30%><input type = "text" size=100 name = "pack_name" value="<?php echo $view_rs['gp_name'];?>"></td>
		<td align=center width=100>패키지할인</td>
		<td align=left><input type = "text" size=3 name = "pack_dis" OnKeyUp="fnNumberCheck(this);" value="<?php echo $view_rs['gp_discount_rate'];?>">%</td>
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
					<option value="none">===============선택된상품==============</option>
<?php
	if (!empty($gp_num)){
		$view_query2 = mysqli_query($CONN['rosemary'],"select B.g_num,B.g_name,C.ca_name from goods_package_goods A, goods B, category C where A.gp_num = '$gp_num' and A.g_num = B.g_num and B.ca_num = C.ca_num");
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

<?php
	if ($mode == "package_modi") {
?>
	<tr bgcolor="#EFEFEF" height=30>
		<td width=10% align=center>
			적용중 리스트 이미지
		</td>
		<td  colspan=3>
			<img src = "../../dir_img/goods_img/<?php echo $view_rs['gp_img'];?>">
		</td>
	</tr>
<?php }?>

	<tr bgcolor="#EFEFEF" height=30>
		<td width=10% align=center>
			리스트 이미지
		</td>
		<td  colspan=3>
			<input type = "file" name = "list_img">
		</td>
	</tr>


	<tr bgcolor="#EFEFEF" height=30>
		<td width=10% align=center>
			패키지 슬로건
		</td>
		<td  colspan=3>
			<input type ="text" name = "pack_slo" size = 120 value="<?php echo $view_rs['gp_slogan'];?>">
		</td>
	</tr>


	<tr bgcolor="#EFEFEF" height=30>
		<td width=10% align=center>
			패키지 특전
		</td>
		<td  colspan=3>
			<textarea name = "pack_benefit" cols=200 rows=5><?php echo $view_rs['gp_benefit'];?></textarea>
		</td>
	</tr>
	<tr bgcolor="#EFEFEF" height=30>
		<td width=10% align=center>
			패키지 설명
		</td>
			
		<td bgcolor="#FFFFFF" colspan=3>
			<?php echo myEditor2(1,'../../gmEditor','writeform','content','100%','200');?>
		</td>
	</tr>


</form>
</table>

<br><br>


<div align="right">
	<input type = "button" value = "리스트" onclick="history.back();"><input type = "button" value = "등록하기" onclick="send_reg()">
</div>

<br><br>