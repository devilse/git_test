<?php include $DOCUMENT_ROOT."/admin_teacher/include/sitemap.php";?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title><?php echo $siteinfo['si_site_name']; ?> 교수자</title>

<style type="text/css">

body, td, p, input, button, textarea, select, .c1 { font-family:Tahoma,굴림; font-size:9pt; color:#222222; }

form { margin:0px; }

/* img {border:0px;} */

a:link, a:visited, a:active { text-decoration:none; color:#466C8A; }
a:hover { text-decoration:none; }





a.menu:link, a.menu:visited, a.menu:active { text-decoration:none; color:#454545; }
a.menu:hover { text-decoration:none; }



input.ed { height:20px; border:1px solid #9A9A9A; border-right:1px solid #D8D8D8; border-bottom:1px solid #D8D8D8; padding:3px 2px 0 2px; }
input.ed_password { height:20px; border:1px solid #9A9A9A; border-right:1px solid #D8D8D8; border-bottom:1px solid #D8D8D8; padding:3px 2px 0 2px; font:10px Tahoma; }
textarea.tx { border:1px solid #9A9A9A; border-right:1px solid #D8D8D8; border-bottom:1px solid #D8D8D8; padding:2px; }


</style>


</head>

<body>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td height="82" align="center" valign="top" bgcolor="5b4d3f" style="padding:4px 0 0 0px;"><table width="980" border="0" cellpadding="0" cellspacing="0" >
      <tr>
        <td width="18" height="74"></td>
        <td width="945"><table width="945" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="810"><table border="0" cellspacing="0" cellpadding="0">
                <tr>

				
				
					<td width="110" align="left" style="padding:0 5px 0 5px;"><a href="/admin_teacher/"><font color=silver><b>home</b></font></a></td>

					<td align="center" style="padding:0 5px;"></td>

<?php
					// 루프 돌면서 메뉴를 표시합니다.										
					foreach($sitemap as $keys => $val) {
?>						
					<td align="center" style="padding:0 5px;">|</td>
					<td align="center" style="padding:0 5px;">
<?php
						if(substr($current_menu_code, 0, 2) == $keys) {
							// 선택된 메뉴일 경우
							echo "<a href=\"$val[1]\"><font color=red><b>$val[0]</b></font></a>";
						} else {
							echo "<a href=\"$val[1]\"><font color=silver><b>$val[0]</b></font></a>";
						}
?>					
					</td>										
<?php						
					} 
?>
                </tr>
            </table></td>
            <!-- 륜 수정 -->
            <td width="281" align=absmiddle>
            <table width="269" height="53" border="0" cellpadding="0" cellspacing="0">
                <tr>
                  <td width="112"><div align="right"><span class="style5"><font color=silver><?php echo $User_Info['name'];?> </font><font color=#FFFFFF>님</font>
                   | <a href="/web/member/process/logout.php"><font color=silver>로그아웃</font></a></span></div></td>
                  <td width="86"></td>
                  <td width="71"></td>
                </tr>

  
            </table></td>
          </tr>
        </table></td>

      </tr>
    </table></td>
  </tr>      
  <!-- 륜 끝 -->
  <tr>
    <td height="1" bgcolor="3e322c"></td>
  </tr>
  <tr>
    <td height="4" bgcolor="cfcfcf"></td>
  </tr>
  <tr>
    <td height="3" bgcolor="ececec"></td>
  </tr>
</table>
<table width="50" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td height="5"></td>
  </tr>
</table>

<!--탑메뉴 끝-->

<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" style="table-layout:fixed">
<tr>
<?php
if($current_menu_code == "main") {
	// main일 경우에는 왼쪽 메뉴가 없습니다.	
?>
	<td height="550" valign="top">
<?php	
} else {
?>
	<!-- 왼쪽 메뉴 시작 -->
	<td width="210" valign="top">
		<?php include $DOCUMENT_ROOT."/admin_teacher/include/left_menu.php";?>
	</td>
	<!-- 왼쪽 메뉴 끝 -->	
    <td width="90%" height="550" valign="top">
<?php	
}
?>