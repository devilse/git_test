	
	function send_list(mode,page)
	{
		document.location.href="./index.php?mode="+mode+"&page="+page+"&sub_menu_num="+sub_num;
	}
	function send_write(mode,bo_num,page,sub_num)
	{
		document.location.href="./index.php?mode="+mode+"&bo_num="+bo_num+"&page="+page+"&sub_menu_num="+sub_num;
	}
	function search_go(action)
	{
		var f = document.search_form;
		if (f.searchword.value == "") {
			alert("검색하실 단어를 입력해 주세요.");
			f.searchword.focus();
			return;
		} else {
			var value = f.searchword.value;
			var val = value.trim();

			if (val ==''||val.length <2) {
				alert('검색할 단어를 2자이상 입력해주세요');
				f.searchword.focus();
				return;
			} else {
				f.action = action;
				f.submit();
			}
		}		
	}
	function change_list(val)
	{
		if (!val) {
		var f = document.search_form;
			f.searchword.value = "";
			f.action = "./index.php";
			f.submit();
		}
	}
	String.prototype.trim=function()
	{
	  var str=this.replace(/(\s+$)/g,"");
	  return str.replace(/(^\s*)/g,"");
	}


	
	function sel_cs(mode,val) 
	{

		var f = document.chk_form;
		var bo_num = f.bo_num.value;
		var sub_menu_num = f.sub_menu_num.value;

		if (mode == "cs") {
			document.location.href="./index.php?mode=board_list&bo_num="+bo_num+"&set_cs="+val+"&sub_menu_num="+sub_menu_num;
		} else if (mode == "cate") {
			document.location.href="./index.php?mode=board_list&bo_num="+bo_num+"&set_cate="+val+"&sub_menu_num="+sub_menu_num;
		} else if (mode == "goods") {
			document.location.href="./index.php?mode=board_list&bo_num="+bo_num+"&set_goods="+val+"&sub_menu_num="+sub_menu_num;
		}
	}

	function list_notice_change(val)
	{
		var f = document.chk_form;
		var bo_num = f.bo_num.value;
		var sub_menu_num = f.sub_menu_num.value;

		document.location.href="./index.php?mode=board_list&bo_num="+bo_num+"&sub_menu_num="+sub_menu_num+"&list_notice_chk="+val;
	}
	function list_guin_change(val)
	{
		var f = document.chk_form;
		var bo_num = f.bo_num.value;
		var sub_menu_num = f.sub_menu_num.value;

		document.location.href="./index.php?mode=board_list&bo_num="+bo_num+"&sub_menu_num="+sub_menu_num+"&guin_state="+val;
	}

	function user_send_write(val)
	{
		document.location.href="./write.php?mode=board_write&bo_num="+val;
	}



	function set_download(tmp,save_name) 
	{
		var save_names = escape(save_name);
		document.location.href="../../_process/board/file_download.php?file_name="+tmp+"&save_name="+save_names;
	}

	function file_list_close()
	{
		var div_layer=document.getElementById('file_div');
		div_layer.style.display="none";
	}

	function bbs_guest_chk()
	{
		var f = document.guest_form;
		if (!f.list_num.value) {
			return;
		} else if (!f.guest_pwd.value) {
			alert("비밀번호를 입력해 주세요.");
			return;
		} else {
			f.method = "post";
			f.action = "./view.php";
			f.submit();
		}
	}



