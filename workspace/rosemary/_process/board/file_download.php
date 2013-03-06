<?php
header('Content-Type: text/html;charset=utf-8');
function file_transact($file_path, $type,$filename="file",$filesize=0,$save_name) 
{
       if ($type == "file") {  		  
              if (eregi("(MSIE 5.5|MSIE 6.0)", $HTTP_USER_AGENT)) {
					 header('Content-Type: text/html;charset=utf-8');
                     Header("Content-Type: doesn/matter");
                     Header("Content-Length: $filesize");   // 이부부을 넣어 주어야지 다운로드 진행 상태가 표시 됩니다. - 익스 버전 8 이상부턴 안보임 그래도 하위버전을 위해 걍 놔둠
                     Header("Content-Disposition: inline; filename=$save_name");
                     Header("Content-Transfer-Encoding: binary");
                     Header("Pragma: no-cache");
                     Header("Expires: 0");
              } else {
					  header('Content-Type: text/html;charset=utf-8');
                     Header("Content-type: file/unknown");
                     Header("Content-Length: $filesize");
                     Header("Content-Disposition: attachment; filename=$save_name");
                     Header("Content-Description: PHP3 Generated Data");
                     Header("Pragma: no-cache");
                     Header("Expires: 0");
              }
       } else {
              header("Content-type: $type");
              header("Pragma: no-cache");
              header("Expires: 0");
       }
 
       if (is_file("$file_path")) {
              $fp = fopen("$file_path", "r");
              if (!fpassthru($fp))  // 서버부하를 줄이려면 print 나 echo 또는 while 문을 이용한 기타 보단 이방법이...
                     fclose($fp);
       } else {
              echo "해당 파일이나 경로가 존재하지 않습니다.";
       }
}
 
function JsUnescapeFunc($str)
{
 return iconv('UTF-16LE', 'UHC', chr(hexdec(substr($str[1], 2, 2))).chr(hexdec(substr($str[1],0,2))));
}
 
 $filename = $_GET['file_name'];
 $save_name = urldecode(preg_replace_callback('/%u([[:alnum:]]{4})/', 'JsUnescapeFunc', $_GET['save_name']));


 $file_url="../../dir_file/".$filename; // 실제로 다운받을 파일이 있는 경로 
 $file_exist=file_exists($file_url);
 
 if ($file_exist==1) {
  $files=filesize($file_url);
  file_transact($file_url, "file",$filename,$files,$save_name);
 } else {
  echo"
  <script>
   window.alert('파일이 존재하지 않습니다.');
   history.back();
  </script>";
  exit;
 }
?>
