<?
// 이미지가 저장되는 경로
$dir = "C:/rosemary/trunk/src/rosemary/dir_img_tmp";
$url = "/dir_img_tmp";


// 미디어파일 체크확장자
$old = array(
	"mid",
	"rmi",
	"midi",
	"asx",
	"wax",
	"wax",
	"m3u",
	"mvx",
	"mov",
	"qt",
	"asf",
	"wm",
	"wma",
	"wmv",
	"mpeg",
	"mpg",
	"m1v",
	"mp2",
	"mp3",
	"avi",
	"wmv",
	"wav",
	"snd",
	"au",
	"aif",
	"aifc",
	"aiff",
	"rm",
	"ra",
	"ram",
	"swf"
);


/*
*************************   메세지를 보내고 뒤로 이동   *************************
*/
function goBack($message){
	echo"
		<script language='javascript'>
		window.alert('".$message."');
		history.go(-1);
		</script>
	";
	exit;
} // end func


/*
*************************   같은 호스트에서 넘어왔는지 체크   *************************
*/
function referer(){

	$referer = explode('/',preg_replace("/http:\/\//",'',$_SERVER[HTTP_REFERER]));

	if ($referer[0] <> $_SERVER[HTTP_HOST]) {

		echo"
			<script language='javascript'>
				window.alert('Not a possibility of searching the Root');
				history.go(-1);
			</script>
		";
		exit;
	}

} // end func


referer();



if($_SERVER['REQUEST_METHOD'] <> 'POST') {

	goBack('정상적인 방법으로 접근하십시요.');
}



// 업로드 디렉토리가 있는지 체크 
if (!@is_dir($dir)) {
	goBack('업로드 폴더가 존재하지 않습니다.');
}

// 업로드 폴더의 퍼미션 707인지 체크
if(PHP_OS <> 'WIN32'){
	if(substr(decoct(fileperms($dir)),2) <> 777){
		goBack("업로드 폴더의 퍼미션 707로 변경해 주세요.");
	}
} // end if



/***************************************************************************************
*************************   파일 전송
****************************************************************************************/

if(is_uploaded_file($_FILES['upfile']['tmp_name']) && ($_FILES['upfile']['size'] > 0)) {

	$ext = substr($_FILES['upfile']['name'],strrpos(stripslashes($_FILES['upfile']['name']),'.')+1);

	// 이미지이면..
	if($_POST['type']==1){
		$tmp_file = @getimagesize($_FILES['upfile']['tmp_name'],&$type);
		$upfile = '.img.'.$ext;

		// (1) = gif, (2) = jpg, (3) = png, (4) = swf, (5) = psd, (6) = bmp
		/*
		if(($tmp_file[2] != 1) && ($tmp_file[2] != 2) && ($tmp_file[2] != 6)) {
			goBack('GIF,JPG,BMP 확장자가 업로드 가능합니다.');
		}
		*/
	}
	// 미디어이면..
	else{
		$media_chk = '';
		foreach($old as $key => $value){
			if($value == $ext){
				$media_chk = 1;
				break;
			}
		}
		$upfile = '.midi.'.strtolower($ext);

		if($media_chk <> 1) goBack('미디어파일만 업로드해 주세요.');
	} // end if

	$upfile = "_tmp_s_" . date("YmdHis") . "_" . substr(microtime(),2,4) . $upfile . "_tmp_e_";
	
	if(!@move_uploaded_file($_FILES['upfile']['tmp_name'],$dir.'/'.$upfile)) {
		@unlink($dir.'/'.$upfile);
		goBack('파일을 복사하는데 실패하였습니다.');
	}
	@chmod($dir.'/'.$upfile,0606);
} // end if

########################################################################### 이미지 임시 디비에 저장


/***************************************************************************************
*************************   내용을 에디터에 삽입
****************************************************************************************/
if(is_file($dir.'/'.$upfile)){
//	$imgsize = (int)$_POST['imgsize'];
	
	$title = addslashes($_POST['title']);
	$alignment = $_POST['alignment'];
	$upfile_ok = $dir.'/'.addslashes($upfile);
	$file_path = $url.'/'.$upfile;

	$img_size=GetImageSize("../".$file_path);
	$width = $img_size[0]; //이미지의 넓이를 알 수 있음
	$height = $img_size[1]; //이미지의 높이를 알 수 있음

	if($width > 700){
			$imgsize = 700;
	}



	ECHO "<script language='javascript'>\n";
	ECHO "<!--\n";
	ECHO "	var val,os;\n";
	ECHO "	var ostmp = navigator.appName.charAt(0);\n";
	ECHO "	if(ostmp=='M') os = '';\n";
	ECHO "	else if(ostmp=='N') os = 1;\n";
	ECHO "	else os = 2;\n";

	if($_POST['type']==1){


		ECHO "	val = '";

		// 이미지 정렬 2-1
		if(!empty($alignment) && ($alignment=='center')) ECHO "<div align=\"".$alignment."\">";

		ECHO "<img src=\"".$file_path."\" ";

		// 이미지 크기
		if(!empty($imgsize)) ECHO " width=\"".$imgsize."\"";

		ECHO "><br>";

		// 이미지 정렬2-2
		if(!empty($alignment) && ($alignment=='center')) ECHO "</div>";

		ECHO "';\n";
	} else {
		$size = $imgsize ? "width=\"$size\" height=\"$size\"" : "";;
		$media_type = ($ext=="swf") ? "application/x-shockwave-flash" : "audio/midi";
		ECHO "	val = '";

		// 미디어 정렬 2-1
		if(!empty($alignment)) ECHO "<div align=\"".$alignment."\">";

		ECHO "<embed src=\"".$file_path."\" ";
		ECHO " $size";
		ECHO " type=$media_type autostart=\"true\" loop=\"true\">";

		// 미디어 정렬 2-2
		if(!empty($alignment)) ECHO "</div>";

		ECHO "';\n";
	}

	ECHO "if(os < 2) window.opener.HTMLPaste(val);\n";
	ECHO "self.close();\n";
	ECHO "//-->\n";
	ECHO "</script>\n";
}
else{

	ECHO "<script language='javascript'>\n";
	ECHO "<!--\n";
	ECHO "	window.close();\n";
	ECHO "//-->\n";
	ECHO "</script>\n";
}
?>
