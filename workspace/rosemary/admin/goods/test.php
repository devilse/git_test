<link rel="stylesheet" type="text/css" href="css/board.css"/>


<script src="../../../../_js/jquery.min.js" type="text/javascript"></script>
<script src="../../../../_js/jquery.uploadify.min.js" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" href="../../../../_js/uploadify.css">

<script>
	$(function() {
		$('#file_upload').uploadify({
		
			'formData'     : {
				'list_num' : '',
				'file_cnt' : '',
				'file_state' : ''
			},

			'buttonText' : '파일 선택2222',
			'auto'     : false,
			'fileSizeLimit' : '5MB',

			'swf'      : './uploadify.swf',
			'uploader' : './uploadify.php',
			'onUploadStart' : function(file) {
			   
				var f = document.writeform;
				f.chk_file.value = parseInt(f.chk_file.value) - 1;
				$("#file_upload").uploadify("settings", 'formData2', f.chk_file.value ,'file_cnt');
				$("#file_upload").uploadify("settings", 'formData2', "board" ,'file_state');
				
			},


			'onUploadSuccess' : function(file, data, response) {
				var result=data.split('|');	
				if (result['0'] != "T") {
					alert(result[1]);
					return;
				} else {

				}
			}
		});
	});
</script>

<form name="writeform" method="post"  enctype='multipart/form-data' id = "writeform">
<input type = "hidden" name = "bo_num" value = "<?php echo $bo_num;?>">
<input type = "hidden" name = "chk_file" value = "0">
<input type = "hidden" name = "write_mode" value = "<?php echo $write_mode;?>">
<input type = "hidden" name = "del_file_num">
<input type = "hidden" name = "page" value = "<?php echo $page;?>">
<input type = "hidden" name = "list_page" value = "<?php echo $list_page;?>">
<input type = "hidden" name = "list_num" value = "<?php echo $list_num;?>">
<input type = "hidden" name = "seq" value = "<?php echo $seq;?>">
<input type = "hidden" name = "ref" value = "<?php echo $ref;?>">
<input type = "hidden" name = "dep" value = "<?php echo $dep;?>">
<input type = "hidden" name = "sel_ca_num" value = "<?php echo $ca_num;?>">
<input type = "hidden" name = "sel_goods_num" value = "<?php echo $lt_num;?>">


								<div id="queue"></div>
								<input id="file_upload" name="file_upload" type="file" >



</form>