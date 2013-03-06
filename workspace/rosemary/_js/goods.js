
	function goods_view(num,action)
	{
		var f = document.list_form;
		if (num) {
			f.num.value = num;
			f.action = action;
			f.submit();
		}

	}
	function setComma(_no)
	{ 

		return  _no.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","); 

	}


	function view_list_option(ca_num,g_num,my_url)
	{

		var div_layer=document.getElementById('goods_'+g_num);
		var tr_layer=document.getElementById('goods_tr_'+g_num);


		if (div_layer.style.display=="block") {
			div_layer.style.display="none";
			tr_layer.style.display="none";
		} else {
			$.ajax({
				type : "POST" 
				, async : true 
				, url : my_url+"/web/goods/view_list_option.php" 
				, dataType : "html" 
				, timeout : 30000 
				, cache : false  
				, data : "ca_num="+ca_num+"&g_num="+g_num
				, contentType: "application/x-www-form-urlencoded; charset=UTF-8"
				, error : function(request, status, error) {
					alert("ajax 통신서버에 접속할 수 업습니다.");
				}
				, success : function(response, status, request) {
					//div_layer.style.display="block";
					div_layer.style.display="block";
					tr_layer.style.display="block";
					div_layer.innerHTML=response;	
				}
			})
		}
	}

	function pack_sel_book(val,num)
	{
		var my_checkbox=document.getElementById('set_book_'+num);
		var tot_money=document.getElementById('tot_money');
		var wan_price=document.getElementById('wan_price');
		var wan_book=document.getElementById('wan_book');

		if (my_checkbox.checked==true) {
			wan_price.value = parseInt(wan_price.value) + parseInt(val);
			wan_book.value = parseInt(wan_book.value) + parseInt(val);
		} else {
			wan_price.value = parseInt(wan_price.value) - parseInt(val);
			wan_book.value = parseInt(wan_book.value) - parseInt(val);
		}
		tot_money.innerHTML = setComma(wan_price.value);
		book_money.innerHTML = setComma(wan_book.value);	

	}
	function list_sel_goods(g_num,val,num,mode)
	{

		if (mode == "goods") {
			var my_checkbox=document.getElementById('set_goods_'+num)
		} else {
			var my_checkbox=document.getElementById('set_book_'+num)
		}

		var goods_money=document.getElementById('goods_money_'+g_num);
		var book_money=document.getElementById('book_money_'+g_num);
		var tot_money=document.getElementById('tot_money_'+g_num);
		var wan_price=document.getElementById('wan_price_'+g_num);
		var wan_book=document.getElementById('wan_book_'+g_num);
		var wan_goods=document.getElementById('wan_goods_'+g_num);

		if (my_checkbox.checked==true) {
			wan_price.value = parseInt(wan_price.value) + parseInt(val);
			if (mode == "goods") {
				wan_goods.value = parseInt(wan_goods.value) + parseInt(val);
			} else {
				wan_book.value = parseInt(wan_book.value) + parseInt(val);
			}
					
		} else {
			wan_price.value = parseInt(wan_price.value) - parseInt(val);
			if (mode == "goods") {
				wan_goods.value = parseInt(wan_goods.value) - parseInt(val);
			} else {
				wan_book.value = parseInt(wan_book.value) - parseInt(val);
			}
		}
		
		tot_money.innerHTML = setComma(wan_price.value);
		book_money.innerHTML = setComma(wan_book.value);
		goods_money.innerHTML = setComma(wan_goods.value);
	}

	function send_list_goods_pay(val,g_num,ca_num,my_url)
	{

		val.method = "post";
		val.action = my_url+"web/goods/order.php";

		val.submit();
	}
	
	function send_goods_view(g_num,page,ca_num,my_url,mode)
	{
		if (!page) {
			page = 1;
		}
		if (mode == "search") { //메인에서 검색으로 열경우 새창으로 보여줌
			window.open(my_url+"web/goods/goods_view.php?g_num="+g_num+"&page="+page+"&ca_num="+ca_num,"","");
		} else {
			document.location.href=my_url+"web/goods/goods_view.php?g_num="+g_num+"&page="+page+"&ca_num="+ca_num;
		}
		
	}
	function view_period(lt_num,ca_num)
	{

		var tab=document.getElementById('view_period_'+lt_num);
		var set_tab=document.getElementById('sel_tab').value;
		var y_tab=document.getElementById('view_period_'+set_tab);
		tab.className = "re_tab_00"; 
		y_tab.className = "re_tab_01"; 
		document.getElementById('sel_tab').value = lt_num;

		$.ajax({
			type : "POST" 
			, async : true 
			, url : "./view_period_list.php" 
			, dataType : "html" 
			, timeout : 30000 
			, cache : false  
			, data : "ca_num="+ca_num+"&lt_num="+lt_num
			, contentType: "application/x-www-form-urlencoded; charset=UTF-8"
			, error : function(request, status, error) {
				alert("ajax 통신서버에 접속할 수 업습니다.");
			}
			, success : function(response, status, request) {
				var div_layer=document.getElementById('period_list_div');
				div_layer.innerHTML=response;	
			}
		})
	}

	function view_book(lt_num,ca_num)
	{
		var book_tab=document.getElementById('view_book_'+lt_num);
		var set_book_tab=document.getElementById('sel_book_tab').value;
		var y_book_tab=document.getElementById('view_book_'+set_book_tab);
		book_tab.className = "re_tab_00"; 
		y_book_tab.className = "re_tab_01"; 
		document.getElementById('sel_book_tab').value = lt_num;

		$.ajax({
			type : "POST" 
			, async : true 
			, url : "./view_book_list.php" 
			, dataType : "html" 
			, timeout : 30000 
			, cache : false  
			, data : "ca_num="+ca_num+"&lt_num="+lt_num
			, contentType: "application/x-www-form-urlencoded; charset=UTF-8"
			, error : function(request, status, error) {
				alert("ajax 통신서버에 접속할 수 업습니다.");
			}
			, success : function(response, status, request) {
				var div_layer=document.getElementById('book_list_div');
				//var div_tab=document.getElementById('view_book_'+lt_num);
				//div_tab.style="class=re_tab_00";
				//$("#view_book_"+lt_num).css("re_tab_00");

				div_layer.innerHTML=response;	
			}
		})
	}


	function send_list(val,page,ca_num)
	{

		if (ca_num) {
			var ca_location = "&ca_num="+ca_num;
		} else {
			var ca_location = "";
		}
		document.location.href="./"+val+"?page="+page+ca_location;	
	}

	function open_book_info_list(val)
	{
		window.open("./book_info_list.php","book_info_list","width=500,height=500");
	}

	function send_view_info(g_num,ca_num)
	{
		window.open("./goods_view.php?g_num="+g_num+"&ca_num="+ca_num,"lipass","");
		//document.location.href="./goods_view.php?g_num="+g_num+"&ca_num="+ca_num;
	}



	function search_go(f)
	{
		if (f.searchword.value == "") {
			alert("검색할 단어를 입력해 주세요.");
			return;
		} else {
			f.submit();
		}
	}
	
	function send_book_pay()
	{
		var f = document.book_form;
		f.action = "order.php";
		f.submit();
	}