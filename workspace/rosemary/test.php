<?

// $dir = getcwd(); //해당 위치 디렉토리 주소 가져오기
$dir = "C:/rosemary/trunk/src/rosemary/";
 

  if(is_dir($dir)){ // 해당 디렉토리 열기

   if($dirop=opendir($dir)){ // 디렉토리 열기

    while(($filerd = readdir($dirop)) != false){ //디렉토리 읽어오기
		echo "===>".is_dir($filerd);
		if (is_dir($filerd) and $filerd != "." and $filerd != ".."){
			   echo " {$filerd} <br />";
		}
 

    }

    }} else{

			echo "디렉토리가 존재하지 않음";

    }

    closedir($dirop);

?>






