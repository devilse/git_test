	function write_qna()
	{
		document.location.href = "./write.php";
	}


	function send_list_go()
	{
		document.location.href="./index.php";
	}


	function set_file_del(num)
	{
		if(confirm("첨부된 파일을 삭제 하시겠습니까?")){
			var del_file = document.getElementById("del_file_"+num);
			var f = document.writeform;
			if(f.del_file_num.value){
				f.del_file_num.value = f.del_file_num.value + "<>" + num;
			}else{
				f.del_file_num.value =  num;
			}
				del_file.style.display="none";
		}
	}
	function search_go()
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
				f.action = "./index.php";
				f.submit();
			}
		}		
	}
	function set_download(tmp,save_name,dir) 
	{
		var save_names = escape(save_name);
		document.location.href=dir+"/file_download.php?file_name="+tmp+"&save_name="+save_names;
	}
	function send_list(mode) 
	{
		var f = document.view_form;
		f.action = "index.php";
		f.submit();
	}
	function send_modi() 
	{
		var f = document.view_form;
		f.write_mode.value = "modi";
		f.method = "post";
		f.action = "./write.php";
		f.submit();
	}
	function send_del(dir) 
	{
		if (confirm("해당 게시물을 삭제 하시겠습니까?")) {
			var f = document.view_form;
			f.write_mode.value = "del";
			f.method = "post";
			f.action = dir+"/qna_del_process.php";
			f.submit();
		}
	}

