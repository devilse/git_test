<?

function myEditor($mode,$editor_Url,$formName,$contentForm,$textWidth,$textHeight)
{
	global $content,$upload_image,$upload_media;

	if(empty($mode)) $mode = '1';
	if(empty($editor_Url)) $editor_Url = '.';
	if(empty($formName)) $formName = 'add_form';
	if(empty($contentForm)) $contentForm = 'content';
	$textWidth = $textWidth ? $textWidth : '100%';
	$textHeight = $textHeight ? $textHeight : '200';


	if($mode==1){
		  $aa = include_once ($editor_Url.'/editor.html');
		  echo $aa;
	}
	else{
		ECHO "<textarea style='width:".$textWidth.";height:".$textHeight."' name='".$contentForm."' wrap='physical' style='ime-mode: active' class='input'>".$content."</textarea>";
	}
}

function myEditor2($mode,$editor_Url,$formName,$contentForm,$textWidth,$textHeight)
{
	global $content,$upload_image,$upload_media,$DOCUMENT_ROOT;



	if(empty($mode)) $mode = '1';
	if(empty($editor_Url)) $editor_Url = '.';
	if(empty($formName)) $formName = 'add_form';
	if(empty($contentForm)) $contentForm = 'content';
	$textWidth = $textWidth ? $textWidth : '100%';
	$textHeight = $textHeight ? $textHeight : '200';

//	$editor_Url = $DOCUMENT_ROOT."/gmEditor";

	if($mode==1){
		@include_once ($editor_Url.'/editor2.html');
	}  else{
		
		ECHO "<textarea style='width:".$textiWdth.";height:".$textHeight."' name='".$contentForm."' wrap='physical' style='ime-mode: active' class='input'>".$content."</textarea>";
	}
}

?>


