<?php
header('Content-Type: text/html;charset=utf-8');

include "../../_lib/db_conn.php";	// 디비 접속
include "../../_lib/global.php";
include "../../_lib/function.php";
include "../../_lib/lib.php";

$list_num = $_POST['list_num'];




function thumbnail($file, $save_filename, $max_width, $max_height , $mode)
{
	global $list_num;

		if ($mode == "jpeg" || $mode == "jpg") {
			 $src_img = ImageCreateFromJPEG($file);
		} else if($mode == "bmp") {
			$src_img = ImageCreateFromwbmp($file);
		} else if($mode == "png") {
			$src_img = ImageCreateFrompng($file);
		} else if($mode == "gif") {
			$src_img = ImageCreateFromgif($file);
		} else {
			mysqli_query($CONN['rosemary'],"delete from board_list where list_num = '$list_num'");
			alert("이미지 첨부는 jpg(jpeg),gif,bmp,png 만 첨부 할 수 있습니다..");
		}

       
        $img_info = getImageSize($file);//원본이미지의 정보를 얻어옵니다
 		
		$img_width = $img_info[0];
        $img_height = $img_info[1];
  
        if(($img_width/$max_width) == ($img_height/$max_height))
        {//원본과 썸네일의 가로세로비율이 같은경우
            $dst_width=$max_width;
            $dst_height=$max_height;
        }
        elseif(($img_width/$max_width) < ($img_height/$max_height))
        {//세로에 기준을 둔경우
            $dst_width=$max_height*($img_width/$img_height);
            $dst_height=$max_height;
        }
        else{//가로에 기준을 둔경우
            $dst_width=$max_width;
            $dst_height=$max_width*($img_height/$img_width);
        }//그림사이즈를 비교해 원하는 썸네일 크기이하로 가로세로 크기를 설정합니다.
  
        $dst_img = imagecreatetruecolor($dst_width, $dst_height); //타겟이미지를 생성합니다
 
        ImageCopyResized($dst_img, $src_img, 0, 0, 0, 0, $dst_width, $dst_height, $img_width, $img_height); //타겟이미지에 원하는 사이즈의 이미지를 저장합니다
  
        ImageInterlace($dst_img);
        ImageJPEG($dst_img,  $save_filename); //실제로 이미지파일을 생성합니다

		if ($mode == "jpeg" || $mode == "jpg") {
			 ImageJPEG($dst_img,  $save_filename); 
		} else if($mode == "bmp") {
			Imagewbmp($dst_img,  $save_filename);
		} else if($mode == "png") {
			Imagepng($dst_img,  $save_filename);;
		} else if($mode == "gif") {
			Imagegif($dst_img,  $save_filename);
		} else {
			mysqli_query($CONN['rosemary'],"delete from board_list where list_num = '$list_num'");
			alert("이미지 첨부는 jpg(jpeg),gif,bmp,png 만 첨부 할 수 있습니다..");
		}


        ImageDestroy($dst_img);
        ImageDestroy($src_img);
}




if ($_FILES['sel_img']['name']) {

	$img_chk = explode("/",$_FILES['sel_img']['type']);
	if ($img_chk[0] == "image") {
		$upfile_name = addslashes(trim($_FILES['sel_img']['name']));												// 업로드 파일 원본 이름
		$ext = substr($_FILES['sel_img']['name'],strrpos(stripslashes($_FILES['sel_img']['name']),'.')+1);		// 파일확장자
		$file_size = $_FILES['sel_img']['size'];																	// 파일 사이즈
		$upfile = '.file.'.$ext;																								
		$upfile = "_tmp_s_" . date("YmdHis") . "_" . substr(microtime(),2,4) . $upfile . "_tmp_e_";					// 실제 저장할 파일명	
		$upfile_sum = $upfile."SUM";
		@move_uploaded_file($_FILES['sel_img']['tmp_name'],$dir_img.'/'.$upfile);
		
		thumbnail($dir_img.'/'.$upfile,$dir_img.'/'.$upfile_sum,"100","100",$img_chk[1]); 


		mysqli_query($CONN['rosemary'],"update board_list set list_img = '$upfile' where list_num = '$list_num'");
		
	} else {
		mysqli_query($CONN['rosemary'],"delete from board_list where list_num = '$list_num'");
		alert("리스트 이미지 첨부 파일이 이미지가 아닙니다. 확인해 주세요.");
	}


}
?>

