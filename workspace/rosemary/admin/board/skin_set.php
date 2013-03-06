<?
	## 게시판 스킨 관리

?>
 <table width="100%" border="0" cellspacing="1" cellpadding="3" class="td" bgcolor="#999999">

  <tr bgcolor="#EFEFEF"> 
	  <td> 
		<div align="center"><b>사용중 게시판 스킨</b></div>
	  </td>
	</tr>
	<tr> 
	  <td bgcolor="#FFFFFF" align=center>
	<a href="http://localhost/_template/skin/board/<?=$skin_dir?>/sample.jpg" target="_blink"><img src = 'http://localhost/_template/skin/board/basic/sample.jpg' width=300 height=300 border=0></a> <br>
		
	  </td>
	</tr>


  </table>


<table width="100%" border="0" cellspacing="1" cellpadding="3" class="td" bgcolor="#999999">

  <tr bgcolor="#EFEFEF"> 
	  <td> 
		<div align="center"><b>스킨목록</b></div>
	  </td>
	</tr>
	<tr> 
	  <td bgcolor="#FFFFFF" align=center>
	<table>
		<tr>
<?

// $dir = getcwd(); //해당 위치 디렉토리 주소 가져오기
$dir = "C:/rosemary/trunk/src/rosemary/_template/skin/board/";
 

  if(is_dir($dir)){ // 해당 디렉토리 열기

   if($dirop=opendir($dir)){ // 디렉토리 열기
	
	$chk_tr = 0;
    while(($filerd = readdir($dirop)) != false){ //디렉토리 읽어오기
		if ($filerd != "." and $filerd != ".."){
			 //  echo " {$filerd} <br />";
			   $skin_dir = $filerd;
		
		
?>
			<td>
				<table>
					<tr>
						<td><a href="http://localhost/_template/skin/board/<?=$skin_dir?>/sample.jpg" target="_blink"><img src = 'http://localhost/_template/skin/board/<?=$skin_dir?>/sample.jpg' width=100 height=100 border=0></a></td>
					</tr>
					<tr>
						<td align=center><input type = "button" value = "사용하기"></td>
					</tr>
				</table>
			</td>
			

			
<?
				
if($chk_tr % 7== 0) echo "</tr><tr>";
			}
$chk_tr++;     }
?>
	</tr>	
	</table>
<?
    }} else{

			echo "디렉토리가 존재하지 않음";

    }

    closedir($dirop);
?>

		
	  </td>
	</tr>


  </table>


